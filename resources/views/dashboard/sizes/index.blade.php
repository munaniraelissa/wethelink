@extends('dashboard.app')
@section('content')
<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-aspect-ratio" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">{{ __('messages.sizes') }}</p>
          <h1 class="h3 mb-1">{{ __('messages.sizes') }}</h1>
          <p class="text-muted mb-0">{{ __('messages.manage_your_sizes') ?? 'Manage your product sizes' }}</p>
        </div>
      </div>
      <div class="heading-actions">
        @can('size-create')
        <a class="btn btn-primary btn-sm" href="{{ route('sizes.create') }}">
          <i class="bi bi-plus-circle" aria-hidden="true"></i> {{ __('messages.add_size') }}
        </a>
        @endcan
      </div>
    </div>

    @if ($message = Session::get('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ __('messages.success') }}!</strong> {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <section class="panel mt-3">
      <div class="panel-header">
        <div>
          <h2 class="h5 mb-1 section-title"><i class="bi bi-table" aria-hidden="true"></i><span>{{ __('messages.sizes') }}</span></h2>
          <p class="text-muted mb-0">{{ __('messages.search_and_filter') ?? 'Search and filter sizes' }}</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
          <form action="{{ route('sizes.index') }}" method="GET" class="d-flex gap-2">
            <input class="form-control form-control-sm table-search" type="search" name="search" placeholder="{{ __('messages.search') }}" value="{{ request('search') }}" aria-label="Search">
            <select class="form-control form-control-sm" name="status">
              <option value="">{{ __('messages.all_status') ?? 'All Status' }}</option>
              <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>{{ __('messages.active') ?? 'Active' }}</option>
              <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>{{ __('messages.inactive') ?? 'Inactive' }}</option>
            </select>
            <button type="submit" class="btn btn-primary btn-sm">{{ __('messages.search') }}</button>
            <a href="{{ route('sizes.index') }}" class="btn btn-secondary btn-sm">{{ __('messages.clear') }}</a>
          </form>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead>
            <tr>
              <th scope="col">{{ __('messages.name') }}</th>
              <th scope="col">{{ __('messages.code') }}</th>
              <th scope="col">{{ __('messages.sort_order') }}</th>
              <th scope="col">{{ __('messages.is_active') }}</th>
              <th scope="col" class="text-end">{{ __('messages.actions') }}</th>
            </tr>
          </thead>
          <tbody>
            @forelse($sizes as $size)
              <tr>
                <td>
                  <p class="fw-semibold mb-0">{{ $size->name }}</p>
                </td>
                <td>{{ $size->code ?? '-' }}</td>
                <td>{{ $size->sort_order }}</td>
                <td>
                  @if($size->is_active)
                    <span class="badge text-bg-success">{{ __('messages.yes') }}</span>
                  @else
                    <span class="badge text-bg-danger">{{ __('messages.no') }}</span>
                  @endif
                </td>
                <td class="text-end">
                  @can('size-edit')
                  <a class="btn btn-light btn-sm" href="{{ route('sizes.edit', $size->id) }}">
                    {{ __('messages.edit') }}
                  </a>
                  @endcan
                  @can('size-delete')
                  <form action="{{ route('sizes.destroy', $size->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('messages.are_you_sure') }}');">
                      {{ __('messages.delete') }}
                    </button>
                  </form>
                  @endcan
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center py-4">
                  <p class="text-muted">{{ __('messages.no_items') ?? 'No sizes found' }}</p>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      @if($sizes->hasPages())
        <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mt-3">
          <p class="text-muted small mb-0">
            {{ __('messages.showing') ?? 'Showing' }} {{ $sizes->firstItem() }} {{ __('messages.to') ?? 'to' }} {{ $sizes->lastItem() }} {{ __('messages.of') ?? 'of' }} {{ $sizes->total() }}
          </p>
          {{ $sizes->links() }}
        </div>
      @endif
    </section>
  </div>
</main>
@endsection
