@extends('dashboard.app')

@section('title', 'Companies')

@section('content')
<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3 mb-4">
      <div>
        <span class="page-icon"><i class="bi bi-building" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">Companies</p>
          <h1 class="h3 mb-1">Company list</h1>
          <p class="text-muted mb-0">Manage registered companies and their status.</p>
        </div>
      </div>
      <div class="heading-actions">
        <a class="btn btn-primary btn-sm" href="{{ route('companies.create') }}">
          <i class="bi bi-plus-circle" aria-hidden="true"></i> Add Company
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
            <span>Companies</span>
          </h2>
          <p class="text-muted mb-0">Browse all companies on the platform.</p>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead>
            <tr>
              <th scope="col">Name</th>
              <th scope="col">Email</th>
              <th scope="col">Industry</th>
              {{-- <th scope="col">Locations</th> --}}
              <th scope="col">Status</th>
              <th scope="col" class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($companies as $company)
              <tr>
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
                  <a class="btn btn-light btn-sm" href="{{ route('companies.show', $company) }}">View</a>
                  <a class="btn btn-light btn-sm" href="{{ route('companies.edit', $company) }}">Edit</a>
                  <form action="{{ route('companies.destroy', $company) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this company?');">Delete</button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center py-4">
                  <p class="text-muted">No companies found.</p>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      @if($companies->hasPages())
        <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mt-3 px-3 pb-3">
          <p class="text-muted small mb-0">
            Showing {{ $companies->firstItem() }} to {{ $companies->lastItem() }} of {{ $companies->total() }} results
          </p>
          {{ $companies->links() }}
        </div>
      @endif
    </section>
  </div>
</main>
@endsection