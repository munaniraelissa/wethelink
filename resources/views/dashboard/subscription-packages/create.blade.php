@extends('dashboard.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('subscriptions.create_package') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('subscription-packages.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('subscriptions.package_name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('subscriptions.package_description') }}</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="pricing_monthly" class="form-label">{{ __('subscriptions.pricing_monthly') }} <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control @error('pricing_monthly') is-invalid @enderror" id="pricing_monthly" name="pricing_monthly" value="{{ old('pricing_monthly') }}" required>
                                    @error('pricing_monthly')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="pricing_yearly" class="form-label">{{ __('subscriptions.pricing_yearly') }} <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control @error('pricing_yearly') is-invalid @enderror" id="pricing_yearly" name="pricing_yearly" value="{{ old('pricing_yearly') }}" required>
                                    @error('pricing_yearly')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="max_locations" class="form-label">{{ __('subscriptions.max_locations') }} <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('max_locations') is-invalid @enderror" id="max_locations" name="max_locations" value="{{ old('max_locations', 1) }}" required>
                                    @error('max_locations')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="max_users" class="form-label">{{ __('subscriptions.max_users') }} <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('max_users') is-invalid @enderror" id="max_users" name="max_users" value="{{ old('max_users', 1) }}" required>
                                    @error('max_users')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="billing_cycle_days" class="form-label">{{ __('subscriptions.billing_cycle_days') }} <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('billing_cycle_days') is-invalid @enderror" id="billing_cycle_days" name="billing_cycle_days" value="{{ old('billing_cycle_days', 30) }}" required>
                            @error('billing_cycle_days')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('subscriptions.features') }}</label>
                            <div class="row">
                                @foreach($modules as $module)
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="features[]" value="{{ $module }}" id="feature_{{ $module }}" {{ in_array($module, old('features', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="feature_{{ $module }}">
                                                {{ ucfirst($module) }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">{{ __('subscriptions.status') }} <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="">Select Status</option>
                                @foreach($statuses as $status)
                                    <option value="{{ $status }}" {{ old('status') === $status ? 'selected' : '' }}>{{ __('subscriptions.status_' . $status) }}</option>
                                @endforeach
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">{{ __('subscriptions.save') }}</button>
                            <a href="{{ route('subscription-packages.index') }}" class="btn btn-outline-secondary">{{ __('subscriptions.cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
