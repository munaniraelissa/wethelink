<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    use ActionLogTrait;

    public function __construct()
    {
        $this->middleware('auth:sanctum');
        // Orders are primarily user-scoped; admin can have broader permissions
        $this->middleware('permission:order-list|order-create|order-edit|order-delete', ['only' => ['index','show']]);
        $this->middleware('permission:order-create', ['only' => ['store']]);
    }

    public function index(Request $request)
    {
        $orders = Order::where('user_id', $request->user()->id)
            ->with('items')
            ->orderByDesc('created_at')
            ->paginate($request->get('per_page', 15));

        return response()->json($orders);
    }

    public function show(Request $request, Order $order)
    {
        if ($order->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->load('items');

        return response()->json($order);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $cart = Cart::where('user_id', $user->id)->with('items.product', 'items.variant')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        $data = $request->validate([
            'company_id' => 'nullable|integer|exists:companies,id',
            'company_location_id' => 'nullable|integer|exists:company_locations,id',
            'tax' => 'nullable|numeric|min:0',
            'shipping_cost' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'shipping_name' => 'nullable|string|max:255',
            'shipping_phone' => 'nullable|string|max:50',
            'shipping_address' => 'nullable|string',
            'notes' => 'nullable|string',
            'payment_status' => ['nullable', Rule::in(['pending', 'paid', 'failed', 'refunded'])],
            'status' => ['nullable', Rule::in(['pending', 'processing', 'approved', 'shipped', 'delivered', 'cancelled'])],
        ]);

        $subtotal = $cart->items->sum(fn ($item) => $item->quantity * $item->unit_price);
        $tax = $data['tax'] ?? 0;
        $shippingCost = $data['shipping_cost'] ?? 0;
        $discount = $data['discount'] ?? 0;
        $total = $subtotal + $tax + $shippingCost - $discount;

        $order = Order::create([
            'company_location_id' => $data['company_location_id'] ?? $user->location?->id,
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'company_id' => $data['company_id'] ?? $user->company_id,
            'user_id' => $user->id,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'shipping_cost' => $shippingCost,
            'discount' => $discount,
            'total' => $total,
            'payment_status' => $data['payment_status'] ?? 'pending',
            'status' => $data['status'] ?? 'pending',
            'shipping_name' => $data['shipping_name'] ?? trim($user->firstname . ' ' . $user->lastname),
            'shipping_phone' => $data['shipping_phone'] ?? $user->telephone,
            'shipping_address' => $data['shipping_address'] ?? null,
            'notes' => $data['notes'] ?? null,
        ]);

        foreach ($cart->items as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'product_variant_id' => $cartItem->product_variant_id,
                'product_name' => $cartItem->product->name ?? 'Unknown product',
                'sku' => $cartItem->variant?->sku ?? $cartItem->product->sku ?? 'unknown',
                'quantity' => $cartItem->quantity,
                'unit_price' => $cartItem->unit_price,
                'total' => $cartItem->quantity * $cartItem->unit_price,
                'size' => $cartItem->size,
                'color' => $cartItem->color,
            ]);

            if ($cartItem->variant) {
                $cartItem->variant->decrement('quantity', $cartItem->quantity);
            } else {
                $cartItem->product->decrement('quantity', $cartItem->quantity);
            }
        }

        $cart->items()->delete();

        $order->load('items');

        Log::info('Order placed', array_merge($this->actionLogContext($request), [
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'subtotal' => $order->subtotal,
            'total' => $order->total,
        ]));

        return response()->json([
            'message' => 'Order created successfully',
            'order' => $order,
        ], 201);
    }
}
