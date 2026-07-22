@extends('dashboard.app')
@section('content')
<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-building" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">{{ __('messages.brand_management') }}</p>
          <h1 class="h3 mb-1">{{ __('messages.brands') }}</h1>
          <p class="text-muted mb-0">{{ __('messages.manage_your_brands') }}</p>
        </div>
      </div>
      <div class="heading-actions">
        @can('brand-create')
        <a class="btn btn-primary btn-sm" href="{{ route('brands.create') }}">
          <i class="bi bi-plus-circle" aria-hidden="true"></i> {{ __('messages.add_brand') }}
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
          <h2 class="h5 mb-1 section-title"><i class="bi bi-table" aria-hidden="true"></i><span>{{ __('messages.brand_list') }}</span></h2>
          <p class="text-muted mb-0">{{ __('messages.search_and_filter') }} {{ __('messages.brands') }}</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
          <form action="{{ route('brands.index') }}" method="GET" class="d-flex gap-2">
            <input class="form-control form-control-sm table-search" type="search" name="search" placeholder="{{ __('messages.search_brands') }}" value="{{ request('search') }}" aria-label="Search">
            <select class="form-control form-control-sm" name="status">
              <option value="">{{ __('messages.all_status') }}</option>
              <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>{{ __('messages.active') }}</option>
              <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>{{ __('messages.inactive') }}</option>
            </select>
            <button type="submit" class="btn btn-primary btn-sm">{{ __('messages.search') }}</button>
            <a href="{{ route('brands.index') }}" class="btn btn-secondary btn-sm">{{ __('messages.clear') }}</a>
          </form>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead>
            <tr>
              <th scope="col">{{ __('messages.logo') }}</th>
              <th scope="col">{{ __('messages.name') }}</th>
              <th scope="col">{{ __('messages.status') }}</th>
              <th scope="col" class="text-end">{{ __('messages.actions') }}</th>
            </tr>
          </thead>
          <tbody>
            @forelse($brands as $brand)
              <tr>
                <td>
                  @if($brand->logo)
                    <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                  @else
                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                      <i class="bi bi-image text-muted"></i>
                    </div>
                  @endif
                </td>
                <td>
                  <p class="fw-semibold mb-0">{{ $brand->name }}</p>
                  <small class="text-muted">{{ $brand->slug }}</small>
                </td>
                <td>
                  @if($brand->is_active)
                    <span class="badge text-bg-success">{{ __('messages.active') }}</span>
                  @else
                    <span class="badge text-bg-danger">{{ __('messages.inactive') }}</span>
                  @endif
                </td>
                <td class="text-end">
                  @can('brand-edit')
                  <a class="btn btn-light btn-sm" href="{{ route('brands.edit', $brand->id) }}">
                    {{ __('messages.edit') }}
                  </a>
                  @endcan
                  @can('brand-delete')
                  <form action="{{ route('brands.destroy', $brand->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('messages.are_you_sure_delete_brand') }}');">
                      {{ __('messages.delete') }}
                    </button>
                  </form>
                  @endcan
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="text-center py-4">
                  <p class="text-muted">{{ __('messages.no_items') }}</p>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      @if($brands->hasPages())
        <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mt-3">
          <p class="text-muted small mb-0">
            {{ __('messages.showing') }} {{ $brands->firstItem() }} {{ __('messages.to') }} {{ $brands->lastItem() }} {{ __('messages.of') }} {{ $brands->total() }}
          </p>
          {{ $brands->links() }}
        </div>
      @endif
    </section>
  </div>
</main>
@endsection
