{{-- resources/views/companies/locations/show.blade.php --}}
@extends('dashboard.app')

@section('title', $location->name)

@section('content')
<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3 mb-4">
      <div>
        <span class="page-icon"><i class="bi bi-geo-alt" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">{{ __('cms.companies.locations') }}</p>
          <h1 class="h3 mb-1">{{ $location->name }}</h1>
          <p class="text-muted mb-0">{{ __('cms.companies.view_location') }}</p>
        </div>
      </div>
      <div class="heading-actions">
        <a href="{{ route('companies.locations.index', $company) }}" class="btn btn-secondary btn-sm">
          <i class="bi bi-arrow-left" aria-hidden="true"></i> {{ __('cms.back') ?? 'Back' }}
        </a>
        <a href="{{ route('companies.locations.edit', [$company, $location]) }}" class="btn btn-primary btn-sm">
          <i class="bi bi-pencil" aria-hidden="true"></i> {{ __('cms.companies.edit_location') }}
        </a>
      </div>
    </div>

    <div class="row g-4">
      <div class="col-lg-8">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title text-primary">{{ __('cms.companies.location') }}</h5>
            <dl class="row mb-0">
              <dt class="col-sm-4 text-muted">{{ __('cms.companies.location_email') }}</dt>
              <dd class="col-sm-8 mb-3">{{ $location->email ?? '—' }}</dd>
              <dt class="col-sm-4 text-muted">{{ __('cms.companies.location_telephone') }}</dt>
              <dd class="col-sm-8 mb-3">{{ $location->telephone ?? '—' }}</dd>
              <dt class="col-sm-4 text-muted">{{ __('cms.companies.location_manager') }}</dt>
              <dd class="col-sm-8 mb-3">{{ $location->manager_name ?? '—' }}</dd>
              <dt class="col-sm-4 text-muted">{{ __('cms.companies.location_address') }}</dt>
              <dd class="col-sm-8 mb-3">{{ $location->address ?? '—' }}</dd>
              <dt class="col-sm-4 text-muted">{{ __('cms.companies.location_city') }}</dt>
              <dd class="col-sm-8 mb-3">{{ $location->city ?? '—' }}</dd>
              <dt class="col-sm-4 text-muted">{{ __('cms.companies.location_district') }}</dt>
              <dd class="col-sm-8 mb-3">{{ $location->district ?? '—' }}</dd>
              <dt class="col-sm-4 text-muted">{{ __('cms.companies.location_province') }}</dt>
              <dd class="col-sm-8 mb-3">{{ $location->province ?? '—' }}</dd>
              <dt class="col-sm-4 text-muted">{{ __('cms.companies.location_country') }}</dt>
              <dd class="col-sm-8 mb-3">{{ $location->country ?? '—' }}</dd>
            </dl>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="card h-100">
          <div class="card-body">
            <h5 class="card-title text-primary">{{ __('cms.companies.status') }}</h5>
            <p class="mb-3">@include('companies.partials.status-badge', ['status' => $location->status])</p>
            <p class="mb-0 text-muted">{{ $location->is_head_office ? __('cms.companies.head_office') : __('cms.companies.branch') }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection