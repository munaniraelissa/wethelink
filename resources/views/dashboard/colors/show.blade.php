@extends('dashboard.app')
@section('content')
<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-palette" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">Color Management</p>
          <h1 class="h3 mb-1">{{ $color->name }}</h1>
          <p class="text-muted mb-0">View color details</p>
        </div>
      </div>
      <div class="heading-actions">
        <a class="btn btn-secondary btn-sm" href="{{ route('colors.index') }}">
          <i class="bi bi-arrow-left" aria-hidden="true"></i> Back
        </a>
      </div>
    </div>

    <section class="panel mt-3">
      <div class="panel-body">
        <div class="row g-4">
          <div class="col-lg-8">
            <div class="mb-3">
              <h2 class="h6 text-muted mb-1">Name</h2>
              <p class="mb-0 fw-semibold">{{ $color->name }}</p>
            </div>
            <div class="mb-3">
              <h2 class="h6 text-muted mb-1">Code</h2>
              <p class="mb-0">{{ $color->code ?? '-' }}</p>
            </div>
            <div class="mb-3">
              <h2 class="h6 text-muted mb-1">Sort Order</h2>
              <p class="mb-0">{{ $color->sort_order }}</p>
            </div>
            <div class="mb-3">
              <h2 class="h6 text-muted mb-1">Status</h2>
              <p class="mb-0">
                @if($color->is_active)
                  <span class="badge text-bg-success">Active</span>
                @else
                  <span class="badge text-bg-danger">Inactive</span>
                @endif
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</main>
@endsection
