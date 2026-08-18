@extends('dashboard.app')

@section('title', __('cms.companies.title'))

@section('content')
<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3 mb-4">
      <div>
        <span class="page-icon"><i class="bi bi-building" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">{{ __('cms.companies.title') }}</p>
          <h1 class="h3 mb-1">{{ __('cms.companies.list_title') }}</h1>
          <p class="text-muted mb-0">{{ __('cms.companies.list_subtitle') }}</p>
        </div>
      </div>
      <div class="heading-actions">
        <a class="btn btn-primary btn-sm" href="{{ route('companies.create') }}">
          <i class="bi bi-plus-circle" aria-hidden="true"></i> {{ __('cms.companies.new_company') }}
        </a>
      </div>
    </div>

    @if ($message = Session::get('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <section class="panel">
      <div class="panel-header">
        <div>
          <h2 class="h5 mb-1 section-title">
            <i class="bi bi-table" aria-hidden="true"></i>
            <span>{{ __('cms.companies.title') }}</span>
          </h2>
          <p class="text-muted mb-0">{{ __('cms.companies.list_subtitle') }}</p>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">{{ __('cms.companies.company_name') }}</th>
              <th scope="col">{{ __('cms.companies.email') }}</th>
              <th scope="col">{{ __('cms.companies.industry') }}</th>
              {{-- <th scope="col">{{ __('cms.companies.locations') }}</th> --}}
              <th scope="col">{{ __('cms.companies.status') }}</th>
              <th scope="col" class="text-end">{{ __('cms.companies.actions') ?? 'Actions' }}</th>
            </tr>
          </thead>
          <tbody>
            @forelse($companies as $company)
              <tr>
                <td>{{ $loop->iteration + ($companies->currentPage() - 1) * $companies->perPage() }}</td>
                <td>
                  <p class="fw-semibold mb-0">{{ $company->name }}</p>
                  <small class="text-muted">{{ $company->slug }}</small>
                </td>
                <td>{{ $company->email ?? '—' }}</td>
                <td>{{ $company->industry ?? '—' }}</td>
                {{-- <td>
                  <a class="text-decoration-none text-dark" href="{{ route('companies.locations.index', $company) }}">
                    {{ $company->locations_count ?? $company->locations->count() }}
                  </a>
                </td> --}}
                <td>
                  <span class="badge {{ $company->status === 'active' ? 'bg-success' : ($company->status === 'pending' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                    {{ ucfirst($company->status) }}
                  </span>
                </td>
                <td class="text-end">
                  <a class="btn btn-light btn-sm" href="{{ route('companies.show', $company) }}">{{ __('cms.companies.view') }}</a>
                  <a class="btn btn-light btn-sm" href="{{ route('companies.edit', $company) }}">{{ __('cms.companies.edit') }}</a>
                  <form action="{{ route('companies.destroy', $company) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('cms.companies.delete') }}?');">{{ __('cms.companies.delete') }}</button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center py-4">
                  <p class="text-muted">{{ __('cms.companies.no_companies') }}</p>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      @if($companies->hasPages())
        <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mt-3 px-3 pb-3">
          <p class="text-muted small mb-0">
            {{ __('cms.companies.showing_results', ['first' => $companies->firstItem(), 'last' => $companies->lastItem(), 'total' => $companies->total()]) }}
          </p>
          {{ $companies->links() }}
        </div>
      @endif
    </section>
  </div>
</main>
@endsection