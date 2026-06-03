@extends('dashboard.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('subscriptions.register_company') }}</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">
                        {{ __('subscriptions.company_registration_info') }}
                    </p>

                    <form action="{{ route('company.registration.store') }}" method="POST">
                        @csrf

                        <h6 class="mb-3">{{ __('subscriptions.company_details') }}</h6>

                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('subscriptions.company_name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('subscriptions.company_email') }} <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="telephone" class="form-label">{{ __('subscriptions.telephone') }} <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control @error('telephone') is-invalid @enderror" id="telephone" name="telephone" value="{{ old('telephone') }}" required>
                            @error('telephone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="website" class="form-label">{{ __('subscriptions.website') }}</label>
                            <input type="url" class="form-control @error('website') is-invalid @enderror" id="website" name="website" value="{{ old('website') }}">
                            @error('website')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tax_number" class="form-label">{{ __('subscriptions.tax_number') }}</label>
                                    <input type="text" class="form-control @error('tax_number') is-invalid @enderror" id="tax_number" name="tax_number" value="{{ old('tax_number') }}">
                                    @error('tax_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="registration_number" class="form-label">{{ __('subscriptions.registration_number') }}</label>
                                    <input type="text" class="form-control @error('registration_number') is-invalid @enderror" id="registration_number" name="registration_number" value="{{ old('registration_number') }}">
                                    @error('registration_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="industry" class="form-label">{{ __('subscriptions.industry') }}</label>
                            <input type="text" class="form-control @error('industry') is-invalid @enderror" id="industry" name="industry" value="{{ old('industry') }}">
                            @error('industry')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">{{ __('subscriptions.submit') }}</button>
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary">{{ __('subscriptions.cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
