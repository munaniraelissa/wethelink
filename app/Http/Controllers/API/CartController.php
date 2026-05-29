<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    use ActionLogTrait;

    protected function getCartForUser(Request $request): Cart
    {
        return Cart::firstOrCreate(['user_id' => $request->user()->id]);
    }

    public function index(Request $request)
    {
        $cart = $this->getCartForUser($request);
        $cart->load(['items.product']);

        return response()->json($cart);
    }

    public function addItem(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($data['product_id']);
        $quantity = max($data['quantity'], $product->minimum_order_quantity ?? 1);
        $unitPrice = $product->discount_price && $product->discount_price > 0
            ? $product->discount_price
            : $product->price;

        $cart = $this->getCartForUser($request);

        $item = $cart->items()->firstOrNew(['product_id' => $product->id]);
        $item->quantity = $item->exists
            ? $item->quantity + $quantity
            : $quantity;
        $item->unit_price = $unitPrice;
        $item->save();

        $cart->load(['items.product']);

        Log::info('Cart item added', array_merge($this->actionLogContext($request), [
            'cart_id' => $cart->id,
            'cart_item_id' => $item->id,
            'product_id' => $product->id,
            'quantity' => $item->quantity,
            'unit_price' => $item->unit_price,
        ]));

        return response()->json([
            'message' => 'Item added to cart',
            'cart' => $cart,
        ], 201);
    }

    public function updateItem(Request $request, CartItem $item)
    {
        $cart = $this->getCartForUser($request);

        if ($item->cart_id !== $cart->id) {
            return response()->json(['message' => 'Cart item not found'], 404);
        }

        $data = $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        if ($data['quantity'] === 0) {
            $item->delete();

            Log::info('Cart item removed by quantity zero', array_merge($this->actionLogContext($request), [
                'cart_id' => $cart->id,
                'cart_item_id' => $item->id,
            ]));

            return response()->json(['message' => 'Item removed from cart']);
        }

        $item->update(['quantity' => $data['quantity']]);
        $cart->load(['items.product']);

        Log::info('Cart item updated', array_merge($this->actionLogContext($request), [
            'cart_id' => $cart->id,
            'cart_item_id' => $item->id,
            'quantity' => $item->quantity,
        ]));

        return response()->json([
            'message' => 'Cart item updated successfully',
            'cart' => $cart,
        ]);
    }

    public function removeItem(Request $request, CartItem $item)
    {
        $cart = $this->getCartForUser($request);

        if ($item->cart_id !== $cart->id) {
            return response()->json(['message' => 'Cart item not found'], 404);
        }

        $item->delete();
        $cart->load(['items.product']);

        Log::info('Cart item removed', array_merge($this->actionLogContext($request), [
            'cart_id' => $cart->id,
            'cart_item_id' => $item->id,
        ]));

        return response()->json([
            'message' => 'Item removed from cart',
            'cart' => $cart,
        ]);
    }

    public function clear(Request $request)
    {
        $cart = $this->getCartForUser($request);
        $cart->items()->delete();

        Log::info('Cart cleared', array_merge($this->actionLogContext($request), [
            'cart_id' => $cart->id,
        ]));

        return response()->json(['message' => 'Cart cleared successfully']);
    }
}
