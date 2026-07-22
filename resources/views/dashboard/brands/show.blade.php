@extends('dashboard.app')
@section('content')
<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-building" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">{{ __('messages.brand_management') }}</p>
          <h1 class="h3 mb-1">{{ $brand->name }}</h1>
          <p class="text-muted mb-0">View brand details</p>
        </div>
      </div>
      <div class="heading-actions">
        <a class="btn btn-secondary btn-sm" href="{{ route('brands.index') }}">
          <i class="bi bi-arrow-left" aria-hidden="true"></i> {{ __('messages.back') }}
        </a>
      </div>
    </div>

    <section class="panel mt-3">
      <div class="panel-body">
        <div class="row g-4">
          <div class="col-lg-8">
            <div class="mb-3">
              <h2 class="h6 text-muted mb-1">{{ __('messages.name') }}</h2>
              <p class="mb-0 fw-semibold">{{ $brand->name }}</p>
            </div>
            <div class="mb-3">
              <h2 class="h6 text-muted mb-1">{{ __('messages.slug') }}</h2>
              <p class="mb-0">{{ $brand->slug ?? '-' }}</p>
            </div>
            <div class="mb-3">
              <h2 class="h6 text-muted mb-1">{{ __('messages.description') }}</h2>
              <p class="mb-0">{{ $brand->description ?? '-' }}</p>
            </div>
            <div class="mb-3">
              <h2 class="h6 text-muted mb-1">{{ __('messages.status') }}</h2>
              <p class="mb-0">
                @if($brand->is_active)
                  <span class="badge text-bg-success">{{ __('messages.active') }}</span>
                @else
                  <span class="badge text-bg-danger">{{ __('messages.inactive') }}</span>
                @endif
              </p>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="border rounded p-3">
              <h2 class="h6 text-muted mb-3">{{ __('messages.logo') }}</h2>
              @if($brand->logo)
                <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}" class="img-fluid rounded">
              @else
                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 180px;">
                  <i class="bi bi-image text-muted fs-1"></i>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</main>
@endsection