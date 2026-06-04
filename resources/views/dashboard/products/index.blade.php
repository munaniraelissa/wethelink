@extends('dashboard.app')
@section('content')
<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-box-seam" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">Product Management</p>
          <h1 class="h3 mb-1">Products</h1>
          <p class="text-muted mb-0">Manage your products</p>
        </div>
      </div>
      <div class="heading-actions">
        <a class="btn btn-primary btn-sm" href="{{ route('products.create') }}">
          <i class="bi bi-plus-circle" aria-hidden="true"></i> Add Product
        </a>
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
          <h2 class="h5 mb-1 section-title"><i class="bi bi-table" aria-hidden="true"></i><span>Product List</span></h2>
          <p class="text-muted mb-0">Search and filter products</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
          <form action="{{ route('products.index') }}" method="GET" class="d-flex gap-2 flex-wrap">
            <input class="form-control form-control-sm table-search" type="search" name="search" placeholder="Search products" value="{{ request('search') }}" aria-label="Search">
            <select class="form-control form-control-sm" name="category">
              <option value="">All Categories</option>
              @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
              @endforeach
            </select>
            <select class="form-control form-control-sm" name="brand">
              <option value="">All Brands</option>
              @foreach($brands as $brand)
                <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
              @endforeach
            </select>
            <select class="form-control form-control-sm" name="status">
              <option value="">All Status</option>
              @foreach($statuses as $status)
                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
              @endforeach
            </select>
            <button type="submit" class="btn btn-primary btn-sm">Search</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">Clear</a>
          </form>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead>
            <tr>
              <th scope="col">Featured</th>
              <th scope="col">Name</th>
              <th scope="col">Category</th>
              <th scope="col">Brand</th>
              <th scope="col">Price</th>
              <th scope="col">Stock</th>
              <th scope="col">Status</th>
              <th scope="col" class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($products as $product)
              <tr>
                <td>
                  @if($product->featured_image)
                    <img src="{{ asset('storage/' . $product->featured_image) }}" alt="{{ $product->name }}" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                  @else
                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                      <i class="bi bi-image text-muted"></i>
                    </div>
                  @endif
                </td>
                <td>
                  <p class="fw-semibold mb-0">{{ $product->name }}</p>
                  <small class="text-muted">SKU: {{ $product->sku }}</small>
                </td>
                <td>{{ $product->category ? $product->category->name : '-' }}</td>
                <td>{{ $product->brand ? $product->brand->name : '-' }}</td>
                <td>
                  @if($product->discount_price)
                    <span class="text-decoration-line-through text-muted">${{ number_format($product->price, 2) }}</span>
                    <span class="text-success fw-bold">${{ number_format($product->discount_price, 2) }}</span>
                  @else
                    ${{ number_format($product->price, 2) }}
                  @endif
                </td>
                <td>{{ $product->quantity }}</td>
                <td>
                  @php
                    $statusBadges = [
                        'draft' => 'bg-secondary',
                        'published' => 'bg-success',
                        'out_of_stock' => 'bg-warning',
                        'inactive' => 'bg-danger'
                    ];
                  @endphp
                  <span class="badge {{ $statusBadges[$product->status] ?? 'bg-secondary' }}">{{ ucfirst(str_replace('_', ' ', $product->status)) }}</span>
                </td>
                <td class="text-end">
                  <a class="btn btn-light btn-sm" href="{{ route('products.show', $product->id) }}">View</a>
                  <a class="btn btn-light btn-sm" href="{{ route('products.edit', $product->id) }}">Edit</a>
                  <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?');">
                      Delete
                    </button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="text-center py-4">
                  <p class="text-muted">No products found</p>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      @if($products->hasPages())
        <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mt-3">
          <p class="text-muted small mb-0">
            Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }}
          </p>
          {{ $products->links() }}
        </div>
      @endif
    </section>
  </div>
</main>
@endsection
