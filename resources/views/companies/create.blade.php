{{-- resources/views/companies/create.blade.php --}}
@extends('dashboard.app')

@section('title', __('cms.companies.new_company'))

@section('content')
<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">
    @if ($errors->any())
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>{{ __('cms.error') ?? 'Error!' }}</strong>
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-building" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">{{ __('cms.companies.title') }}</p>
          <h1 class="h3 mb-1">{{ __('cms.companies.new_company') }}</h1>
          <p class="text-muted mb-0">{{ __('cms.companies.new_company_description') }}</p>
        </div>
      </div>
      <div class="heading-actions">
        <a href="{{ route('companies.index') }}" class="btn btn-secondary btn-sm">
          <i class="bi bi-arrow-left" aria-hidden="true"></i> {{ __('cms.back') }}
        </a>
      </div>
    </div>

    <section class="panel mt-3">
      <div class="panel-body">
        @include('companies.partials.form', [
          'action' => route('companies.store'),
          'method' => null,
        ])
      </div>
    </section>
  </div>
</main>
@endsection