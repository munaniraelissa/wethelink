@extends('dashboard.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('subscriptions.subscription_management') }}</h5>
                </div>
                <div class="card-body">
                    <form method="GET" class="mb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="{{ __('subscriptions.search') }}" value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="approval_status" class="form-select">
                                    <option value="">{{ __('subscriptions.approval_status') }}</option>
                                    @foreach($approvalStatuses as $status)
                                        <option value="{{ $status }}" {{ request('approval_status') === $status ? 'selected' : '' }}>
                                            {{ __('subscriptions.approval_status_' . $status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="status" class="form-select">
                                    <option value="">{{ __('subscriptions.status') }}</option>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                                            {{ __('subscriptions.status_' . $status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-outline-primary w-100">{{ __('subscriptions.search') }}</button>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>{{ __('subscriptions.id') }}</th>
                                    <th>{{ __('subscriptions.company') }}</th>
                                    <th>{{ __('subscriptions.package_name') }}</th>
                                    <th>{{ __('subscriptions.approval_status') }}</th>
                                    <th>{{ __('subscriptions.status') }}</th>
                                    <th>{{ __('subscriptions.duration') }}</th>
                                    <th>{{ __('subscriptions.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($subscriptions as $subscription)
                                    <tr>
                                        <td>{{ $subscription->id }}</td>
                                        <td>{{ $subscription->company->name }}</td>
                                        <td>{{ $subscription->package ? $subscription->package->name : '-' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $subscription->approval_status === 'approved' ? 'success' : ($subscription->approval_status === 'pending' ? 'warning' : 'danger') }}">
                                                {{ __('subscriptions.approval_status_' . $subscription->approval_status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $subscription->status === 'active' ? 'success' : ($subscription->status === 'pending' ? 'warning' : 'danger') }}">
                                                {{ __('subscriptions.status_' . $subscription->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($subscription->started_at && $subscription->ends_at)
                                                {{ $subscription->started_at->format('M d, Y') }} - {{ $subscription->ends_at->format('M d, Y') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('subscriptions.show', $subscription) }}" class="btn btn-sm btn-info" title="{{ __('subscriptions.view') }}">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            @if($subscription->approval_status === 'pending' && auth()->user()->can('subscription-approve'))
                                                <form action="{{ route('subscriptions.approve', $subscription) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success" title="{{ __('subscriptions.approve') }}">
                                                        <i class="bi bi-check-circle"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('subscriptions.reject', $subscription) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-danger" title="{{ __('subscriptions.reject') }}">
                                                        <i class="bi bi-x-circle"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">{{ __('subscriptions.no_subscriptions_found') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $subscriptions->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
