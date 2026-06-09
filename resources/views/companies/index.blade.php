@extends('dashboard.app')
 
@section('content')
<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">
    @forelse ($companies as $company)
 
    {{-- Page Heading --}}
    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-geo-alt" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">{{ $company->name }}</p>
          <h1 class="h3 mb-1">{{ __('companies.locations') }}</h1>
          <p class="text-muted mb-0">{{ __('companies.manage_locations') }}</p>
        </div>
      </div>
      <div class="heading-actions">
        <a class="btn btn-secondary btn-sm" href="{{ route('companies.show', $company) }}">
          <i class="bi bi-arrow-left" aria-hidden="true"></i> {{ __('companies.back') }}
        </a>
        <a class="btn btn-primary btn-sm" href="{{ route('companies.locations.create', $company) }}">
          <i class="bi bi-plus-circle" aria-hidden="true"></i> {{ __('companies.add_location') }}
        </a>
      </div>
    </div>
 
    @if ($message = Session::get('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ __('companies.success') }}!</strong> {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
 
    <section class="panel mt-3">
      <div class="panel-header">
        <div>
          <h2 class="h5 mb-1 section-title">
            <i class="bi bi-table" aria-hidden="true"></i>
            <span>{{ __('companies.location_list') }}</span>
          </h2>
          <p class="text-muted mb-0">{{ __('companies.manage_locations') }}</p>
        </div>
      </div>
 
      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead>
            <tr>
              <th scope="col">{{ __('companies.name') }}</th>
              <th scope="col">{{ __('companies.address_information') }}</th>
              <th scope="col">{{ __('companies.contact_information') }}</th>
              <th scope="col">{{ __('companies.manager_name') }}</th>
              <th scope="col">{{ __('companies.head_office') }}</th>
              <th scope="col">{{ __('companies.status') }}</th>
              <th scope="col" class="text-end">{{ __('companies.actions') }}</th>
            </tr>
          </thead>
          <tbody>
            @forelse($locations as $location)
              <tr>
                <td>
                  <p class="fw-semibold mb-0">{{ $location->name }}</p>
                </td>
                <td>
                  <p class="mb-0">
                    {{ collect([$location->city, $location->district, $location->province])->filter()->implode(', ') ?: '—' }}
                  </p>
                  <small class="text-muted">{{ $location->country ?? '' }}</small>
                </td>
                <td>
                  <p class="mb-0">{{ $location->email ?? '—' }}</p>
                  <small class="text-muted">{{ $location->telephone ?? '' }}</small>
                </td>
                <td>{{ $location->manager_name ?? '—' }}</td>
                <td>
                  @if($location->is_head_office)
                    <span class="badge bg-primary">
                      <i class="bi bi-star-fill"></i> {{ __('companies.head_office') }}
                    </span>
                  @else
                    <span class="text-muted small">{{ __('companies.branch') }}</span>
                  @endif
                </td>
                <td>
                  <span class="badge {{ $location->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                    {{ __('companies.status_' . $location->status) }}
                  </span>
                </td>
                <td class="text-end">
                  <a class="btn btn-light btn-sm"
                     href="{{ route('companies.locations.show', [$company, $location]) }}">
                    {{ __('companies.view') }}
                  </a>
                  <a class="btn btn-light btn-sm"
                     href="{{ route('companies.locations.edit', [$company, $location]) }}">
                    {{ __('companies.edit') }}
                  </a>
                  <form action="{{ route('companies.locations.destroy', [$company, $location]) }}"
                        method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('{{ __('companies.delete_location_confirm') }}')">
                      {{ __('companies.delete') }}
                    </button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center py-4">
                  <p class="text-muted">{{ __('companies.no_locations_found') }}</p>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
 
      @if($locations->hasPages())
        <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mt-3 px-3 pb-3">
          <p class="text-muted small mb-0">
            {{ __('companies.showing') }} {{ $locations->firstItem() }}
            {{ __('companies.to') }} {{ $locations->lastItem() }}
            {{ __('companies.of') }} {{ $locations->total() }}
            {{ __('companies.results') }}
          </p>
          {{ $locations->links() }}
        </div>
      @endif
    </section>
 
    @empty
      <p>{{ __('companies.no_companies') }}</p>
    @endforelse
  </div>
</main>
@endsection
  </div>
</main>
@endsection