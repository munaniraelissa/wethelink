@extends('dashboard.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('subscriptions.subscription_details') }} #{{ $subscription->id }}</h5>
                    <div>
                        @if($subscription->approval_status === 'pending' && auth()->user()->can('subscription-approve'))
                            <a href="{{ route('subscriptions.approve', $subscription) }}" class="btn btn-sm btn-success">
                                {{ __('subscriptions.approve') }}
                            </a>
                            <a href="{{ route('subscriptions.reject', $subscription) }}" class="btn btn-sm btn-danger">
                                {{ __('subscriptions.reject') }}
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="mb-3">{{ __('subscriptions.company_information') }}</h6>
                            <dl class="row">
                                <dt class="col-sm-5">{{ __('subscriptions.company') }}:</dt>
                                <dd class="col-sm-7">{{ $subscription->company->name }}</dd>

                                <dt class="col-sm-5">{{ __('subscriptions.email') }}:</dt>
                                <dd class="col-sm-7">{{ $subscription->company->email }}</dd>

                                <dt class="col-sm-5">{{ __('subscriptions.telephone') }}:</dt>
                                <dd class="col-sm-7">{{ $subscription->company->telephone }}</dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <h6 class="mb-3">{{ __('subscriptions.subscription_information') }}</h6>
                            <dl class="row">
                                <dt class="col-sm-5">{{ __('subscriptions.approval_status') }}:</dt>
                                <dd class="col-sm-7">
                                    <span class="badge bg-{{ $subscription->approval_status === 'approved' ? 'success' : ($subscription->approval_status === 'pending' ? 'warning' : 'danger') }}">
                                        {{ __('subscriptions.approval_status_' . $subscription->approval_status) }}
                                    </span>
                                </dd>

                                <dt class="col-sm-5">{{ __('subscriptions.status') }}:</dt>
                                <dd class="col-sm-7">
                                    <span class="badge bg-{{ $subscription->status === 'active' ? 'success' : ($subscription->status === 'pending' ? 'warning' : 'danger') }}">
                                        {{ __('subscriptions.status_' . $subscription->status) }}
                                    </span>
                                </dd>
                            </dl>
                        </div>
                    </div>

                    @if($subscription->package)
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6 class="mb-3">{{ __('subscriptions.package_information') }}</h6>
                                <dl class="row">
                                    <dt class="col-sm-5">{{ __('subscriptions.package_name') }}:</dt>
                                    <dd class="col-sm-7">{{ $subscription->package->name }}</dd>

                                    <dt class="col-sm-5">{{ __('subscriptions.pricing_monthly') }}:</dt>
                                    <dd class="col-sm-7">${{ number_format($subscription->package->pricing_monthly, 2) }}</dd>

                                    <dt class="col-sm-5">{{ __('subscriptions.max_locations') }}:</dt>
                                    <dd class="col-sm-7">{{ $subscription->package->max_locations }}</dd>

                                    <dt class="col-sm-5">{{ __('subscriptions.max_users') }}:</dt>
                                    <dd class="col-sm-7">{{ $subscription->package->max_users }}</dd>
                                </dl>
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-3">{{ __('subscriptions.subscription_information') }}</h6>
                                <dl class="row">
                                    <dt class="col-sm-5">{{ __('subscriptions.started_at') }}:</dt>
                                    <dd class="col-sm-7">{{ $subscription->started_at ? $subscription->started_at->format('M d, Y') : '-' }}</dd>

                                    <dt class="col-sm-5">{{ __('subscriptions.ends_at') }}:</dt>
                                    <dd class="col-sm-7">{{ $subscription->ends_at ? $subscription->ends_at->format('M d, Y') : '-' }}</dd>

                                    <dt class="col-sm-5">{{ __('subscriptions.amount_paid') }}:</dt>
                                    <dd class="col-sm-7">${{ number_format($subscription->amount_paid, 2) }}</dd>

                                    <dt class="col-sm-5">{{ __('subscriptions.current_location_count') }}:</dt>
                                    <dd class="col-sm-7">{{ $subscription->current_location_count }} / {{ $subscription->package->max_locations }}</dd>
                                </dl>
                            </div>
                        </div>
                    @endif

                    @if($subscription->rejection_reason)
                        <div class="alert alert-danger" role="alert">
                            <strong>{{ __('subscriptions.rejection_reason') }}:</strong>
                            {{ $subscription->rejection_reason }}
                        </div>
                    @endif
                </div>
            </div>

            @if($subscription->histories->count() > 0)
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{ __('subscriptions.subscription_history') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>{{ __('subscriptions.date') }}</th>
                                        <th>{{ __('subscriptions.action') }}</th>
                                        <th>{{ __('subscriptions.details') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subscription->histories as $history)
                                        <tr>
                                            <td>{{ $history->created_at->format('M d, Y H:i') }}</td>
                                            <td>
                                                <span class="badge bg-info">{{ ucfirst($history->action) }}</span>
                                            </td>
                                            <td>
                                                @if($history->details)
                                                    <small>{{ json_encode($history->details) }}</small>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <div class="mt-4">
                <a href="{{ route('subscriptions.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> {{ __('subscriptions.back') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
