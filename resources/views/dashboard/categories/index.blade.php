@extends('dashboard.app')
@section('content')
<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-tags" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">Category Management</p>
          <h1 class="h3 mb-1">Categories</h1>
          <p class="text-muted mb-0">Manage your product categories</p>
        </div>
      </div>
      <div class="heading-actions">
        @can('category-create')
        <a class="btn btn-primary btn-sm" href="{{ route('categories.create') }}">
          <i class="bi bi-plus-circle" aria-hidden="true"></i> Add Category
        </a>
        @endcan
      </div>
    </div>

    @if ($message = Session::get('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <section class="panel mt-3">
      <div class="panel-header">
        <div>
          <h2 class="h5 mb-1 section-title"><i class="bi bi-table" aria-hidden="true"></i><span>Category List</span></h2>
          <p class="text-muted mb-0">Search and filter categories</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
          <form action="{{ route('categories.index') }}" method="GET" class="d-flex gap-2">
            <input class="form-control form-control-sm table-search" type="search" name="search" placeholder="Search categories" value="{{ request('search') }}" aria-label="Search">
            <select class="form-control form-control-sm" name="status">
              <option value="">All Status</option>
              <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
              <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            <button type="submit" class="btn btn-primary btn-sm">Search</button>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-sm">Clear</a>
          </form>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead>
            <tr>
              <th scope="col">Image</th>
              <th scope="col">Name</th>
              <th scope="col">Parent</th>
              <th scope="col">Status</th>
              <th scope="col" class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($categories as $category)
              <tr>
                <td>
                  @if($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                  @else
                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                      <i class="bi bi-image text-muted"></i>
                    </div>
                  @endif
                </td>
                <td>
                  <p class="fw-semibold mb-0">{{ $category->name }}</p>
                  <small class="text-muted">{{ $category->slug }}</small>
                </td>
                <td>
                  {{ $category->parent ? $category->parent->name : '-' }}
                </td>
                <td>
                  @if($category->is_active)
                    <span class="badge text-bg-success">Active</span>
                  @else
                    <span class="badge text-bg-danger">Inactive</span>
                  @endif
                </td>
                <td class="text-end">
                  @can('category-edit')
                  <a class="btn btn-light btn-sm" href="{{ route('categories.edit', $category->id) }}">
                    Edit
                  </a>
                  @endcan
                  @can('category-delete')
                  <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this category?');">
                      Delete
                    </button>
                  </form>
                  @endcan
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center py-4">
                  <p class="text-muted">No categories found</p>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      @if($categories->hasPages())
        <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mt-3">
          <p class="text-muted small mb-0">
            Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of {{ $categories->total() }}
          </p>
          {{ $categories->links() }}
        </div>
      @endif
    </section>
  </div>
</main>
@endsection
