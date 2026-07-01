{{-- resources/views/companies/show.blade.php --}}
@extends('dashboard.app')

@section('title', $company->name)

@section('content')
<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-building" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">Companies</p>
          <h1 class="h3 mb-1">{{ $company->name }}</h1>
          <p class="text-muted mb-0">Company details and location overview.</p>
        </div>
      </div>
      <div class="heading-actions">
        <a href="{{ route('companies.index') }}" class="btn btn-secondary btn-sm">
          <i class="bi bi-arrow-left" aria-hidden="true"></i> Back
        </a>
        <a href="{{ route('companies.edit', $company) }}" class="btn btn-primary btn-sm">
          <i class="bi bi-pencil" aria-hidden="true"></i> Edit
        </a>
      </div>
    </div>

    <div class="row g-4">
      <div class="col-12">
        <div class="card">
          <div class="card-body d-flex flex-column flex-md-row align-items-start gap-3">
            @if($company->logo)
              <img src="{{ Storage::url($company->logo) }}" alt="{{ $company->name }}"
                   class="rounded-3" style="width:80px; height:80px; object-fit:cover;">
            @else
              <div class="d-flex h-80 w-80 align-items-center justify-content-center rounded-3 bg-primary bg-opacity-10 text-primary fw-bold" style="width:80px; height:80px;">
                {{ strtoupper(substr($company->name, 0, 2)) }}
              </div>
            @endif
            <div class="flex-grow-1">
              <h2 class="h5 mb-1">{{ $company->name }}</h2>
              <p class="mb-1 text-muted">{{ $company->slug }}</p>
              @if($company->industry)
                <p class="mb-0">{{ $company->industry }}</p>
              @endif
            </div>
            <div class="text-end">
              @include('companies.partials.status-badge', ['status' => $company->status])
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="card h-100">
          <div class="card-body">
            <h5 class="card-title text-primary">Contact</h5>
            <dl class="row mb-0">
              <dt class="col-5 text-muted">Email</dt>
              <dd class="col-7 mb-2">@if($company->email)<a href="mailto:{{ $company->email }}">{{ $company->email }}</a>@else —@endif</dd>
              <dt class="col-5 text-muted">Phone</dt>
              <dd class="col-7 mb-2">{{ $company->telephone ?? '—' }}</dd>
              <dt class="col-5 text-muted">Website</dt>
              <dd class="col-7">@if($company->website)<a href="{{ $company->website }}" target="_blank">{{ $company->website }}</a>@else —@endif</dd>
            </dl>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="card h-100">
          <div class="card-body">
            <h5 class="card-title text-primary">Legal</h5>
            <dl class="row mb-0">
              <dt class="col-6 text-muted">Tax Number</dt>
              <dd class="col-6 mb-2">{{ $company->tax_number ?? '—' }}</dd>
              <dt class="col-6 text-muted">Reg. Number</dt>
              <dd class="col-6">{{ $company->registration_number ?? '—' }}</dd>
            </dl>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="card h-100">
          <div class="card-body">
            <h5 class="card-title text-primary">Business</h5>
            <dl class="row mb-0">
              <dt class="col-6 text-muted">Credit Limit</dt>
              <dd class="col-6 mb-2">${{ number_format($company->credit_limit, 2) }}</dd>
              <dt class="col-6 text-muted">Payment terms</dt>
              <dd class="col-6 mb-2">{{ $company->payment_terms_days }} days</dd>
              <dt class="col-6 text-muted">Created</dt>
              <dd class="col-6">{{ $company->created_at->format('d M Y') }}</dd>
            </dl>
          </div>
        </div>
      </div>

      <div class="col-12">
        <div class="card">
          <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
              <h5 class="mb-1">Locations</h5>
              <p class="text-muted mb-0">All branches and offices for this company.</p>
            </div>
            <a href="{{ route('companies.locations.create', $company) }}" class="btn btn-primary btn-sm">
              <i class="bi bi-plus-circle"></i> Add Location
            </a>
          </div>
          <div class="card-body p-0">
            @if($company->locations->isNotEmpty())
              <div class="table-responsive">
                <table class="table mb-0">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>City</th>
                      <th>Manager</th>
                      <th>Type</th>
                      <th>Status</th>
                      <th class="text-end">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($company->locations as $location)
                      <tr>
                        <td>{{ $location->name }}</td>
                        <td>{{ $location->city ?? '—' }}</td>
                        <td>{{ $location->manager_name ?? '—' }}</td>
                        <td>@if($location->is_head_office)<span class="badge bg-primary bg-opacity-10 text-primary">Head Office</span>@else<span class="badge bg-secondary bg-opacity-10 text-secondary">Branch</span>@endif</td>
                        <td>@include('companies.partials.status-badge', ['status' => $location->status])</td>
                        <td class="text-end">
                          <a href="{{ route('companies.locations.show', [$company, $location]) }}" class="btn btn-outline-secondary btn-sm me-1">View</a>
                          <a href="{{ route('companies.locations.edit', [$company, $location]) }}" class="btn btn-primary btn-sm">Edit</a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            @else
              <div class="p-4 text-center text-muted">
                No locations yet. <a href="{{ route('companies.locations.create', $company) }}" class="link-primary">Add one</a>.
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection