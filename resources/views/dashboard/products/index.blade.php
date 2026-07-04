@extends('dashboard.app')
@section('content')
<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-box-seam" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">{{ __('products.product_management') }}</p>
          <h1 class="h3 mb-1">{{ __('products.products') }}</h1>
          <p class="text-muted mb-0">{{ __('products.manage_your_products') }}</p>
        </div>
      </div>
      <div class="heading-actions">
        @can('product-create')
        <a class="btn btn-primary btn-sm" href="{{ route('products.create') }}">
          <i class="bi bi-plus-circle" aria-hidden="true"></i> {{ __('products.add_product') }}
        </a>
        @endcan
      </div>
    </div>

    @if ($message = Session::get('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ __('products.success') }}</strong> {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <section class="panel mt-3">
      <div class="panel-header">
        <div>
          <h2 class="h5 mb-1 section-title"><i class="bi bi-table" aria-hidden="true"></i><span>{{ __('products.product_list') }}</span></h2>
          <p class="text-muted mb-0">{{ __('products.search_and_filter_products') }}</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
          <form action="{{ route('products.index') }}" method="GET" class="d-flex gap-2 flex-wrap">
            <input class="form-control form-control-sm table-search" type="search" name="search" placeholder="{{ __('products.search_products') }}" value="{{ request('search') }}" aria-label="Search">
            <select class="form-control form-control-sm" name="category">
              <option value="">{{ __('products.all_categories') }}</option>
              @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
              @endforeach
            </select>
            <select class="form-control form-control-sm" name="brand">
              <option value="">{{ __('products.all_brands') }}</option>
              @foreach($brands as $brand)
                <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
              @endforeach
            </select>
            <select class="form-control form-control-sm" name="status">
              <option value="">{{ __('products.all_status') }}</option>
              @foreach($statuses as $status)
                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
              @endforeach
            </select>
            <button type="submit" class="btn btn-primary btn-sm">{{ __('products.search') }}</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">{{ __('products.clear') }}</a>
          </form>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead>
            <tr>
              <th scope="col">{{ __('products.featured') }}</th>
              <th scope="col">{{ __('products.name') }}</th>
              <th scope="col">{{ __('products.category') }}</th>
              <th scope="col">{{ __('products.brand') }}</th>
              <th scope="col">{{ __('products.company') ?? 'Company' }}</th>
              <th scope="col">{{ __('products.moq') ?? 'MOQ' }}</th>
              <th scope="col">{{ __('products.price') }}</th>
              <th scope="col">{{ __('products.stock') }}</th>
              <th scope="col">{{ __('products.status') }}</th>
              <th scope="col" class="text-end">{{ __('products.actions') }}</th>
            </tr>
          </thead>
          <tbody>
            @forelse($products as $product)
              <tr>
                <td>
                  @php
                      $featuredImage = $product->images->where('is_featured', 1)->first();
                  @endphp

                  @if($featuredImage)
                      <img src="{{ asset('storage/' . $featuredImage->image) }}" alt="{{ $product->name }}" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                  @else
                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                      <i class="bi bi-image text-muted"></i>
                    </div>
                  @endif
                </td>
                <td>
                  <p class="fw-semibold mb-0">{{ $product->name }}</p>
                  <small class="text-muted">{{ __('products.sku') }}: {{ $product->sku }}</small>
                </td>
                <td>{{ $product->category ? $product->category->name : '-' }}</td>
                <td>{{ $product->brand ? $product->brand->name : '-' }}</td>
                <td>{{ $product->company ? $product->company->name : '-' }}</td>
                <td>{{ $product->minimum_order_quantity }}</td>
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
                  <span class="badge {{ $statusBadges[$product->status] ?? 'bg-secondary' }}">{{ __('products.status_' . $product->status) }}</span>
                </td>
                <td class="text-end">
                  @can('product-show')
                  <a class="btn btn-light btn-sm" href="{{ route('products.show', $product->id) }}">{{ __('products.view') }}</a>
                  @endcan
                  @can('product-edit')
                  <a class="btn btn-light btn-sm" href="{{ route('products.edit', $product->id) }}">{{ __('products.edit') }}</a>
                  @endcan
                  @can('product-delete')
                  <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('products.delete_confirm') }}');">
                      {{ __('products.delete') }}
                    </button>
                  </form>
                  @endcan
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="text-center py-4">
                  <p class="text-muted">{{ __('messages.no_items') ?? 'No products found.' }}</p>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      @if($products->hasPages())
        <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mt-3">
          <p class="text-muted small mb-0">
            {{ __('products.showing') }} {{ $products->firstItem() }} {{ __('products.to') }} {{ $products->lastItem() }} {{ __('products.of') }} {{ $products->total() }}
          </p>
          {{ $products->links() }}
        </div>
      @endif
    </section>
  </div>
</main>
@endsection
