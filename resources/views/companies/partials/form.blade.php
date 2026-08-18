{{-- resources/views/companies/partials/form.blade.php --}}
{{-- Usage: include with $company (or null for create) and $action, $method --}}

<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($method ?? false)
        @method($method)
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title text-primary">{{ __('cms.companies.company_details_overview') }}</h5>
            <div class="row g-3 mt-3">
                <div class="col-md-6">
                    <label class="form-label">{{ __('cms.companies.company_name') }} <span class="text-danger">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $company->name ?? '') }}"
                           class="form-control @error('name') is-invalid @enderror" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">{{ __('cms.companies.status') }} <span class="text-danger">*</span></label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        @foreach(['pending','active','inactive','blocked'] as $s)
                            <option value="{{ $s }}" @selected(old('status', $company->status ?? 'pending') === $s)>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">{{ __('cms.companies.email') }}</label>
                    <input type="email" name="email" value="{{ old('email', $company->email ?? '') }}"
                           class="form-control @error('email') is-invalid @enderror">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">{{ __('cms.companies.telephone') }}</label>
                    <input type="text" name="telephone" value="{{ old('telephone', $company->telephone ?? '') }}"
                           class="form-control @error('telephone') is-invalid @enderror">
                    @error('telephone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">{{ __('cms.companies.website') }}</label>
                    <input type="url" name="website" value="{{ old('website', $company->website ?? '') }}"
                           placeholder="https://" class="form-control @error('website') is-invalid @enderror">
                    @error('website')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">{{ __('cms.companies.industry') }}</label>
                    <input type="text" name="industry" value="{{ old('industry', $company->industry ?? '') }}"
                           class="form-control @error('industry') is-invalid @enderror">
                    @error('industry')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">{{ __('cms.companies.description') }}</label>
                    <textarea name="description" rows="4"
                              class="form-control @error('description') is-invalid @enderror">{{ old('description', $company->description ?? '') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title text-primary">{{ __('cms.companies.legal') }}</h5>
            <div class="row g-3 mt-3">
                <div class="col-md-6">
                    <label class="form-label">{{ __('cms.companies.tax_number') }}</label>
                    <input type="text" name="tax_number" value="{{ old('tax_number', $company->tax_number ?? '') }}"
                           class="form-control @error('tax_number') is-invalid @enderror">
                    @error('tax_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">{{ __('cms.companies.registration_number') }}</label>
                    <input type="text" name="registration_number" value="{{ old('registration_number', $company->registration_number ?? '') }}"
                           class="form-control @error('registration_number') is-invalid @enderror">
                    @error('registration_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title text-primary">{{ __('cms.companies.business') }}</h5>
            <div class="row g-3 mt-3">
                <div class="col-md-6">
                    <label class="form-label">{{ __('cms.companies.credit_limit') }}</label>
                    <div class="input-group">
                        <span class="input-group-text">RWF</span>
                        <input type="number" name="credit_limit" step="0.01" min="0"
                               value="{{ old('credit_limit', $company->credit_limit ?? 0) }}"
                               class="form-control @error('credit_limit') is-invalid @enderror">
                    </div>
                    @error('credit_limit')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">{{ __('cms.companies.payment_terms_days') }}</label>
                    <input type="number" name="payment_terms_days" min="0"
                           value="{{ old('payment_terms_days', $company->payment_terms_days ?? 0) }}"
                           class="form-control @error('payment_terms_days') is-invalid @enderror">
                    @error('payment_terms_days')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title text-primary">{{ __('cms.companies.logo') }}</h5>
            @if(!empty($company->logo))
                <div class="mb-3 d-flex align-items-center gap-3">
                    <img src="{{ Storage::url($company->logo) }}" alt="Current logo"
                         class="rounded-3" style="width:72px; height:72px; object-fit:cover;">
                    <p class="mb-0 text-muted">{{ __('cms.companies.current_logo') }}</p>
                </div>
            @endif
            <div class="mb-3">
                <label class="form-label">{{ __('cms.companies.upload_logo') }}</label>
                <input type="file" name="logo" accept="image/*" class="form-control @error('logo') is-invalid @enderror">
                @error('logo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">{{ __('cms.upload_image_hint') ?? 'JPEG, PNG, SVG, WebP — max 2MB.' }}</small>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mb-4">
        <a href="{{ route('companies.index') }}" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-save" aria-hidden="true"></i>
            {{ isset($company) ? 'Save Changes' : 'Create Company' }}
        </button>
    </div>
</form>