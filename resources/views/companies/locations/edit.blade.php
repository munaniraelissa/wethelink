{{-- resources/views/companies/locations/edit.blade.php --}}
@extends('dashboard.app')

@section('title', __('cms.companies.edit_location'))

@section('content')
<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3 mb-4">
      <div>
        <span class="page-icon"><i class="bi bi-geo-alt" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">{{ __('cms.companies.locations') }}</p>
          <h1 class="h3 mb-1">{{ __('cms.companies.edit_location') }}</h1>
          <p class="text-muted mb-0">{{ __('cms.companies.edit_location_for', ['company' => $company->name]) }}</p>
        </div>
      </div>
      <div class="heading-actions">
        <a href="{{ route('companies.locations.index', $company) }}" class="btn btn-secondary btn-sm">
          <i class="bi bi-arrow-left" aria-hidden="true"></i> {{ __('cms.back') ?? 'Back' }}
        </a>
      </div>
    </div>

    <div class="card">
      <div class="card-body">
        @if ($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('companies.locations.update', [$company, $location]) }}" method="POST">
          @csrf
          @method('PUT')

          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">{{ __('cms.companies.location_name') }}</label>
              <input type="text" name="name" value="{{ old('name', $location->name) }}" class="form-control @error('name') is-invalid @enderror" required>
              @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
              <label class="form-label">{{ __('cms.companies.status') }}</label>
              <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                <option value="active" @selected(old('status', $location->status) === 'active')>{{ __('cms.active') ?? 'Active' }}</option>
                <option value="inactive" @selected(old('status', $location->status) === 'inactive')>{{ __('cms.inactive') ?? 'Inactive' }}</option>
              </select>
              @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6">
              <label class="form-label">{{ __('cms.companies.location_email') }}</label>
              <input type="email" name="email" value="{{ old('email', $location->email) }}" class="form-control @error('email') is-invalid @enderror">
              @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
              <label class="form-label">{{ __('cms.companies.location_telephone') }}</label>
              <input type="text" name="telephone" value="{{ old('telephone', $location->telephone) }}" class="form-control @error('telephone') is-invalid @enderror">
              @error('telephone')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6">
              <label class="form-label">{{ __('cms.companies.location_manager') }}</label>
              <input type="text" name="manager_name" value="{{ old('manager_name', $location->manager_name) }}" class="form-control @error('manager_name') is-invalid @enderror">
              @error('manager_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6">
              <label class="form-label">{{ __('cms.companies.location_country') }}</label>
              <input type="text" name="country" value="{{ old('country', $location->country) }}" class="form-control @error('country') is-invalid @enderror">
              @error('country')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-4">
              <label class="form-label">{{ __('cms.companies.location_province') }}</label>
              <input type="text" name="province" value="{{ old('province', $location->province) }}" class="form-control @error('province') is-invalid @enderror">
              @error('province')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
              <label class="form-label">{{ __('cms.companies.location_district') }}</label>
              <input type="text" name="district" value="{{ old('district', $location->district) }}" class="form-control @error('district') is-invalid @enderror">
              @error('district')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
              <label class="form-label">{{ __('cms.companies.location_city') }}</label>
              <input type="text" name="city" value="{{ old('city', $location->city) }}" class="form-control @error('city') is-invalid @enderror">
              @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-12">
              <label class="form-label">{{ __('cms.companies.location_address') }}</label>
              <textarea name="address" rows="3" class="form-control @error('address') is-invalid @enderror">{{ old('address', $location->address) }}</textarea>
              @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-4">
              <div class="form-check mt-4">
                <input class="form-check-input" type="checkbox" name="is_head_office" id="is_head_office" value="1" @checked(old('is_head_office', $location->is_head_office))>
                <label class="form-check-label" for="is_head_office">{{ __('cms.companies.head_office') }}</label>
              </div>
            </div>

            <div class="col-12 text-end">
              <a href="{{ route('companies.locations.index', $company) }}" class="btn btn-secondary me-2">{{ __('cms.back') ?? 'Back' }}</a>
              <button type="submit" class="btn btn-primary">{{ __('cms.companies.save_location') }}</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</main>
@endsection