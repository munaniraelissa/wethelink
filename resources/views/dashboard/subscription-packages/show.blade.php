@extends('dashboard.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ $subscriptionPackage->name }}</h5>
                    <div>
                        @can('subscription-edit')
                            <a href="{{ route('subscription-packages.edit', $subscriptionPackage) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i> {{ __('subscriptions.edit') }}
                            </a>
                        @endcan
                        @can('subscription-delete')
                            <form action="{{ route('subscription-packages.destroy', $subscriptionPackage) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('subscriptions.delete') }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i> {{ __('subscriptions.delete') }}
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="mb-3">{{ __('subscriptions.package_information') }}</h6>
                            <dl class="row">
                                <dt class="col-sm-4">{{ __('subscriptions.package_name') }}:</dt>
                                <dd class="col-sm-8">{{ $subscriptionPackage->name }}</dd>

                                <dt class="col-sm-4">{{ __('subscriptions.package_slug') }}:</dt>
                                <dd class="col-sm-8">{{ $subscriptionPackage->slug }}</dd>

                                <dt class="col-sm-4">{{ __('subscriptions.status') }}:</dt>
                                <dd class="col-sm-8">
                                    <span class="badge bg-{{ $subscriptionPackage->status === 'active' ? 'success' : ($subscriptionPackage->status === 'inactive' ? 'warning' : 'danger') }}">
                                        {{ __('subscriptions.status_' . $subscriptionPackage->status) }}
                                    </span>
                                </dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <h6 class="mb-3">{{ __('subscriptions.pricing') }}</h6>
                            <dl class="row">
                                <dt class="col-sm-4">{{ __('subscriptions.pricing_monthly') }}:</dt>
                                <dd class="col-sm-8">${{ number_format($subscriptionPackage->pricing_monthly, 2) }}</dd>

                                <dt class="col-sm-4">{{ __('subscriptions.pricing_yearly') }}:</dt>
                                <dd class="col-sm-8">${{ number_format($subscriptionPackage->pricing_yearly, 2) }}</dd>

                                <dt class="col-sm-4">{{ __('subscriptions.billing_cycle_days') }}:</dt>
                                <dd class="col-sm-8">{{ $subscriptionPackage->billing_cycle_days }} {{ __('subscriptions.days') }}</dd>
                            </dl>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="mb-3">{{ __('subscriptions.limits') }}</h6>
                            <dl class="row">
                                <dt class="col-sm-4">{{ __('subscriptions.max_locations') }}:</dt>
                                <dd class="col-sm-8">{{ $subscriptionPackage->max_locations }}</dd>

                                <dt class="col-sm-4">{{ __('subscriptions.max_users') }}:</dt>
                                <dd class="col-sm-8">{{ $subscriptionPackage->max_users }}</dd>
                            </dl>
                        </div>
                    </div>

                    @if($subscriptionPackage->description)
                        <div class="mb-4">
                            <h6>{{ __('subscriptions.package_description') }}</h6>
                            <p>{{ $subscriptionPackage->description }}</p>
                        </div>
                    @endif

                    @if($subscriptionPackage->features && count($subscriptionPackage->features) > 0)
                        <div class="mb-4">
                            <h6>{{ __('subscriptions.features') }}</h6>
                            <ul class="list-unstyled">
                                @foreach($subscriptionPackage->features as $feature)
                                    <li>
                                        <i class="bi bi-check-circle text-success"></i> {{ ucfirst($feature) }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mt-4">
                        <a href="{{ route('subscription-packages.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> {{ __('subscriptions.back') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
