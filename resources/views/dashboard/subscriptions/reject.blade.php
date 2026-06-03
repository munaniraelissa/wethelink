@extends('dashboard.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('subscriptions.reject') }} {{ __('subscriptions.subscription') }}</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning" role="alert">
                        <strong>{{ __('subscriptions.company') }}:</strong> {{ $subscription->company->name }}
                    </div>

                    <form action="{{ route('subscriptions.perform-reject', $subscription) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="rejection_reason" class="form-label">{{ __('subscriptions.provide_rejection_reason') }} <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('rejection_reason') is-invalid @enderror" id="rejection_reason" name="rejection_reason" rows="5" required minlength="10" maxlength="500" placeholder="{{ __('subscriptions.min_10_characters') }}">{{ old('rejection_reason') }}</textarea>
                            <small class="text-muted">{{ __('subscriptions.min_10_characters') }}</small>
                            @error('rejection_reason')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-danger">{{ __('subscriptions.reject') }}</button>
                            <a href="{{ route('subscriptions.show', $subscription) }}" class="btn btn-outline-secondary">{{ __('subscriptions.cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
