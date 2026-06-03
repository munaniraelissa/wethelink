@extends('dashboard.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('subscriptions.assign_package') }}</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info" role="alert">
                        <strong>{{ __('subscriptions.company') }}:</strong> {{ $subscription->company->name }}
                    </div>

                    <form action="{{ route('subscriptions.perform-approve', $subscription) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="subscription_package_id" class="form-label">{{ __('subscriptions.select_subscription_package') }} <span class="text-danger">*</span></label>
                            <select class="form-select @error('subscription_package_id') is-invalid @enderror" id="subscription_package_id" name="subscription_package_id" required onchange="updatePackageDetails()">
                                <option value="">Select Package</option>
                                @foreach(\App\Models\SubscriptionPackage::where('status', 'active')->get() as $pkg)
                                    <option value="{{ $pkg->id }}" {{ old('subscription_package_id') == $pkg->id ? 'selected' : '' }}>
                                        {{ $pkg->name }} - ${{ number_format($pkg->pricing_monthly, 2) }}/mo
                                    </option>
                                @endforeach
                            </select>
                            @error('subscription_package_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="started_at" class="form-label">{{ __('subscriptions.subscription_start_date') }} <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('started_at') is-invalid @enderror" id="started_at" name="started_at" value="{{ old('started_at', now()->format('Y-m-d')) }}" required>
                                    @error('started_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="amount_paid" class="form-label">{{ __('subscriptions.amount_to_pay') }} <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control @error('amount_paid') is-invalid @enderror" id="amount_paid" name="amount_paid" value="{{ old('amount_paid', 0) }}" required>
                                    @error('amount_paid')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-light" id="packageDetails" style="display: none;">
                            <h6>{{ __('subscriptions.package_information') }}</h6>
                            <ul class="mb-0">
                                <li>{{ __('subscriptions.max_locations') }}: <span id="pkgMaxLocations">-</span></li>
                                <li>{{ __('subscriptions.max_users') }}: <span id="pkgMaxUsers">-</span></li>
                                <li>{{ __('subscriptions.billing_cycle_days') }}: <span id="pkgBillingCycles">-</span></li>
                            </ul>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">{{ __('subscriptions.approve') }}</button>
                            <a href="{{ route('subscriptions.show', $subscription) }}" class="btn btn-outline-secondary">{{ __('subscriptions.cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const packages = {!! \App\Models\SubscriptionPackage::where('status', 'active')->pluck('max_locations', 'id')->union(\App\Models\SubscriptionPackage::where('status', 'active')->pluck('max_users', 'id'))->union(\App\Models\SubscriptionPackage::where('status', 'active')->pluck('billing_cycle_days', 'id'))->toJson() !!};

const packageDetails = @json(\App\Models\SubscriptionPackage::where('status', 'active')->get(['id', 'max_locations', 'max_users', 'billing_cycle_days'])->keyBy('id'));

function updatePackageDetails() {
    const select = document.getElementById('subscription_package_id');
    const packageId = select.value;

    if (packageId && packageDetails[packageId]) {
        const pkg = packageDetails[packageId];
        document.getElementById('pkgMaxLocations').textContent = pkg.max_locations;
        document.getElementById('pkgMaxUsers').textContent = pkg.max_users;
        document.getElementById('pkgBillingCycles').textContent = pkg.billing_cycle_days;
        document.getElementById('packageDetails').style.display = 'block';
    } else {
        document.getElementById('packageDetails').style.display = 'none';
    }
}

document.addEventListener('DOMContentLoaded', updatePackageDetails);
</script>
@endsection
