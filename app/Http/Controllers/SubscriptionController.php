<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\SubscriptionPackage;
use App\Models\SubscriptionHistory;
use App\Models\Company;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(function ($request, $next) {
    //         abort_if(!auth()->user()->can('subscription-list'), 403);
    //         return $next($request);
    //     });
    // }

    public function index(Request $request)
    {
        $query = Subscription::with(['company', 'package'])->orderBy('id', 'desc');

        if ($request->filled('approval_status')) {
            $query->where('approval_status', $request->approval_status);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('company', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $subscriptions = $query->paginate(15);
        $approvalStatuses = ['pending', 'approved', 'rejected'];
        $statuses = ['pending', 'active', 'paused', 'cancelled', 'expired'];

        return view('dashboard.subscriptions.index', compact('subscriptions', 'approvalStatuses', 'statuses'));
    }

    public function show(Subscription $subscription)
    {
        $subscription->load(['company', 'package', 'histories']);
        return view('dashboard.subscriptions.show', compact('subscription'));
    }

    public function approve(Subscription $subscription)
    {
        abort_if(!auth()->user()->can('subscription-approve'), 403);
        abort_if($subscription->approval_status !== 'pending', 403);

        return view('dashboard.subscriptions.approve', compact('subscription'));
    }

    public function performApprove(Request $request, Subscription $subscription)
    {
        abort_if(!auth()->user()->can('subscription-approve'), 403);
        abort_if($subscription->approval_status !== 'pending', 403);

        $validated = $request->validate([
            'subscription_package_id' => 'required|exists:subscription_packages,id',
            'started_at' => 'required|date|after_or_equal:today',
            'amount_paid' => 'required|numeric|min:0',
        ]);

        $package = SubscriptionPackage::findOrFail($validated['subscription_package_id']);
        $startedAt = \Carbon\Carbon::parse($validated['started_at']);
        $endsAt = $startedAt->copy()->addDays($package->billing_cycle_days);

        $subscription->update([
            'subscription_package_id' => $package->id,
            'started_at' => $startedAt,
            'ends_at' => $endsAt,
            'renewal_date' => $endsAt,
            'amount_paid' => $validated['amount_paid'],
            'approval_status' => 'approved',
            'status' => 'active',
            'approved_at' => now(),
        ]);

        $subscription->company->update(['status' => 'active']);

        SubscriptionHistory::create([
            'subscription_id' => $subscription->id,
            'action' => 'approved',
            'details' => [
                'package_id' => $package->id,
                'package_name' => $package->name,
                'amount_paid' => $validated['amount_paid'],
                'started_at' => $startedAt,
                'ends_at' => $endsAt,
            ],
        ]);

        return redirect()->route('subscriptions.show', $subscription)
            ->with('success', __('subscriptions.subscription_approved'));
    }

    public function reject(Subscription $subscription)
    {
        abort_if(!auth()->user()->can('subscription-approve'), 403);
        abort_if($subscription->approval_status !== 'pending', 403);

        return view('dashboard.subscriptions.reject', compact('subscription'));
    }

    public function performReject(Request $request, Subscription $subscription)
    {
        abort_if(!auth()->user()->can('subscription-approve'), 403);
        abort_if($subscription->approval_status !== 'pending', 403);

        $validated = $request->validate([
            'rejection_reason' => 'required|string|min:10|max:500',
        ]);

        $subscription->update([
            'approval_status' => 'rejected',
            'status' => 'cancelled',
            'rejected_at' => now(),
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        $subscription->company->update(['status' => 'blocked']);

        SubscriptionHistory::create([
            'subscription_id' => $subscription->id,
            'action' => 'rejected',
            'details' => ['reason' => $validated['rejection_reason']],
        ]);

        return redirect()->route('subscriptions.show', $subscription)
            ->with('success', __('subscriptions.subscription_rejected'));
    }
}
