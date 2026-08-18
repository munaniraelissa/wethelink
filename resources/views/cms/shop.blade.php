@extends('cms.app')
@section('content')


    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">{{ __('cms.shop.all_products') }}</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="{{ route('home') }}">{{ __('cms.page.home') }}</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">{{ __('cms.nav.products') }}</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Shop Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-12">
                <div class="border-bottom mb-4 pb-4">
                    <h5 class="font-weight-semi-bold mb-4">{{ __('cms.shop.filter_manufacturers') }}</h5>
                    <form action="{{ route('shop') }}" method="GET">
                        @if (request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        @if (request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        <div class="d-flex flex-column">
                            <a href="{{ route('shop') }}"
                                class="text-dark mb-2 {{ !request('manufacturer') ? 'font-weight-bold' : '' }}">{{ __('cms.shop.all_manufacturers') }}</a>
                            @foreach ($manufacturers as $manufacturer)
                                <label class="custom-control custom-radio d-flex align-items-center mb-2">
                                    <input type="radio" class="custom-control-input" name="manufacturer"
                                        value="{{ $manufacturer->id }}"
                                        {{ request('manufacturer') == $manufacturer->id ? 'checked' : '' }}
                                        onchange="this.form.submit()">
                                    <span class="custom-control-label">{{ $manufacturer->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </form>
                </div>

                <div class="mb-5">
                    <h5 class="font-weight-semi-bold mb-4">{{ __('cms.shop.filter_categories') }}</h5>
                    <form action="{{ route('shop') }}" method="GET">
                        @if (request('manufacturer'))
                            <input type="hidden" name="manufacturer" value="{{ request('manufacturer') }}">
                        @endif
                        @if (request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        <div class="d-flex flex-column">
                            <a href="{{ route('shop') }}"
                                class="text-dark mb-2 {{ !request('category') ? 'font-weight-bold' : '' }}">{{ __('cms.shop.all_categories') }}</a>
                            @foreach ($categories as $category)
                                @if ($category->parent_id == null)
                                    <div class="mb-2">
                                        <label class="custom-control custom-radio d-flex align-items-center">
                                            <input type="radio" class="custom-control-input" name="category"
                                                value="{{ $category->id }}"
                                                {{ request('category') == $category->id ? 'checked' : '' }}
                                                onchange="this.form.submit()">
                                            <span class="custom-control-label">{{ $category->name }}</span>
                                        </label>
                                        @if ($category->children->isNotEmpty())
                                            <div class="pl-3 mt-2">
                                                @foreach ($category->children as $child)
                                                    <label
                                                        class="custom-control custom-radio d-flex align-items-center mb-2">
                                                        <input type="radio" class="custom-control-input" name="category"
                                                            value="{{ $child->id }}"
                                                            {{ request('category') == $child->id ? 'checked' : '' }}
                                                            onchange="this.form.submit()">
                                                        <span class="custom-control-label">{{ $child->name }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </form>
                </div>
            </div>
            <!-- Shop Sidebar End -->


            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-12">
                <div class="row pb-3">
                    {{-- @if ($manufacturers->isNotEmpty())
                        <div class="col-12 mb-4">
                            <div class="border rounded p-4 bg-light">
                                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-3">
                                    <div>
                                        <h4 class="font-weight-semi-bold mb-1">{{ __('cms.manufacturers.title') }}</h4>
                                        <p class="text-muted mb-0">{{ __('cms.manufacturers.intro') }}</p>
                                    </div>
                                    <a href="{{ route('manufacturers') }}" class="btn btn-sm btn-primary mt-3 mt-md-0">{{ __('cms.manufacturers.explore') }}</a>
                                </div>
                                <div class="row">
                                    @foreach ($manufacturers->take(4) as $manufacturer)
                                        <div class="col-12 col-lg-6 mb-3">
                                            <div class="border rounded p-3 h-100 bg-white">
                                                <div class="d-flex justify-content-between align-items-start mb-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mr-3" style="width:48px;height:48px;overflow:hidden;">
                                                            @if ($manufacturer->logo)
                                                                <img src="{{ asset('storage/' . $manufacturer->logo) }}" alt="{{ $manufacturer->name }}" class="img-fluid w-100 h-100">
                                                            @else
                                                                <i class="fas fa-industry text-primary"></i>
                                                            @endif
                                                        </div>
                                                        <div>
                                                            <h6 class="font-weight-bold mb-1">{{ $manufacturer->name }}</h6>
                                                            <small class="text-muted">{{ $manufacturer->industry ?: 'Manufacturer' }}</small>
                                                        </div>
                                                    </div>
                                                    @if ($manufacturer->status === 'active')
                                                        <span class="badge badge-success">{{ __('cms.manufacturers.verified') }}</span>
                                                    @else
                                                        <span class="badge badge-secondary">{{ $manufacturer->status }}</span>
                                                    @endif
                                                </div>
                                                <p class="text-muted small mb-3">{{ \Illuminate\Support\Str::limit($manufacturer->description ?? $manufacturer->name, 120) }}</p>
                                                <div class="d-flex flex-wrap gap-2 mb-3">
                                                    <a href="{{ route('shop', ['manufacturer' => $manufacturer->id]) }}" class="btn btn-sm btn-outline-primary">{{ __('cms.manufacturers.explore') }}</a>
                                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $manufacturer->telephone ?? '') }}?text={{ urlencode('Hello, I am interested in your products.') }}" class="btn btn-sm btn-success" target="_blank">{{ __('cms.manufacturers.chat_now') }}</a>
                                                </div>
                                                <div class="row">
                                                    @foreach ($manufacturer->products->take(3) as $featuredProduct)
                                                        <div class="col-4 px-1">
                                                            <a href="{{ route('product.detail', $featuredProduct->slug) }}" class="text-decoration-none">
                                                                <div class="border rounded p-1 bg-light text-center">
                                                                    @php $productImage = $featuredProduct->images->where('is_featured', true)->first() ?? $featuredProduct->images->first(); @endphp
                                                                    @if ($productImage)
                                                                        <img src="{{ asset('storage/' . $productImage->image) }}" alt="{{ $featuredProduct->name }}" class="img-fluid mb-2" style="height:70px;object-fit:cover;width:100%;">
                                                                    @else
                                                                        <div class="bg-white d-flex align-items-center justify-content-center mb-2" style="height:70px;">
                                                                            <i class="fas fa-image text-muted"></i>
                                                                        </div>
                                                                    @endif
                                                                    <div class="small font-weight-bold text-dark text-truncate">{{ $featuredProduct->name }}</div>
                                                                    <div class="small text-muted">{{ number_format($featuredProduct->price) }} RWF</div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif --}}
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <form action="{{ route('shop') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="{{ __('cms.shop.search_name_placeholder') }}"
                                        value="{{ request('search') }}">
                                    @if (request('category'))
                                        <input type="hidden" name="category" value="{{ request('category') }}">
                                    @endif
                                    @if (request('manufacturer'))
                                        <input type="hidden" name="manufacturer" value="{{ request('manufacturer') }}">
                                    @endif
                                    <div class="input-group-append">
                                        <button type="submit"
                                            class="input-group-text bg-transparent text-primary border-0">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            {{-- <div class="dropdown ml-4">
                                <button class="btn border dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                            {{ __('cms.shop.sort_by') }}
                                        </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="triggerId">
                                    <a class="dropdown-item" href="#">{{ __('cms.shop.latest') }}</a>
                                    <a class="dropdown-item" href="#">{{ __('cms.shop.popularity') }}</a>
                                    <a class="dropdown-item" href="#">{{ __('cms.shop.best_rating') }}</a>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    @if (request('search') && ($searchCategories->isNotEmpty() || $searchCompanies->isNotEmpty()))
                        <div class="col-12 mb-4">
                            <div class="border rounded p-3 bg-light">
                                @if ($searchCategories->isNotEmpty())
                                    <div class="mb-3">
                                        <h6 class="font-weight-semi-bold mb-2">{{ __('cms.shop.filter_categories') }}</h6>
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach ($searchCategories as $category)
                                                <a href="{{ route('shop', ['search' => request('search'), 'category' => $category->id]) }}" class="btn btn-sm btn-outline-primary">
                                                    {{ $category->name }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                @if ($searchCompanies->isNotEmpty())
                                    <div>
                                        <h6 class="font-weight-semi-bold mb-2">{{ __('cms.shop.filter_manufacturers') }}</h6>
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach ($searchCompanies as $company)
                                                <a href="{{ route('shop', ['search' => request('search'), 'manufacturer' => $company->id]) }}" class="btn btn-sm btn-outline-secondary">
                                                    {{ $company->name }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    @forelse($products as $product)
                        <div class="col-lg-4 col-md-6 col-6 pb-1">
                            <div class="card product-item border-0 mb-4">
                                <a href="{{ route('product.detail', $product->slug) }}">
                                    <div class="card-header product-img position-relative overflow-hidden bg-white border p-0"
                                        style="height: 300px;">
                                        @php $featured = $product->images->where('is_featured', true)->first() ?? $product->images->first(); @endphp
                                        @if ($featured)
                                            <img class="img-fluid w-100 h-100"
                                                src="{{ asset('storage/' . $featured->image) }}"
                                                alt="{{ $product->name }}">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                                <i class="fas fa-image fa-3x text-muted"></i>
                                            </div>
                                        @endif
                                    </div>
                                </a>
                                <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                    <h6 class="text-truncate mb-3">{{ $product->name }}</h6>
                                    <div class="d-flex justify-content-center">
                                        <h6>{{ number_format($product->price) }}RWF</h6>
                                        <!-- @if ($product->discount_price)
                                            <h6 class="text-muted ml-2"><del>{{ number_format($product->price) }}RWF</del></h6>
                                            @endif -->
                                    </div>
                                    <p>
                                        {{ $product->minimum_order_quantity }} {{ $product->unit }} (MOQ) <BR>
                                        {{ $product->company ? $product->company->name : '-' }}
                                        @if ($product->company)
                                            @if ($product->company->status === 'active')
                                                <i class="fas fa-check-circle text-primary" title="Active"></i>
                                            @elseif($product->company->status === 'inactive')
                                                <i class="fas fa-times-circle text-danger" title="Inactive"></i>
                                            @endif
                                        @endif
                                    <div class="text-primary mr-2">
                                        <small class="fas fa-star"></small>
                                        <small class="fas fa-star"></small>
                                        <small class="fas fa-star"></small>
                                        <small class="fas fa-star-half-alt"></small>
                                        <small class="far fa-star"></small>
                                        <small class="pt-1">({{ count($product->reviews ?? []) }} Reviews)</small>
                                    </div>
                                    </p>
                                </div>
                                <div class="card-footer d-flex justify-content-between bg-light border">
                                    <a href="{{ route('product.detail', $product->slug) }}"
                                        class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View
                                        Detail</a>
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $product->company->telephone ?? '') }}?text={{ urlencode('I want the ' . ($product->category->name ?? $product->name) . ' with barcode ' . $product->barcode) }}"
                                        class="btn btn-sm text-dark p-0" target="_blank"><i
                                            class="fab fa-whatsapp text-success mr-1"></i>Chat Now</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <p class="text-muted">{{ __('cms.shop.no_products_in_category') }}</p>
                        </div>
                    @endforelse

                    <div class="col-12 pb-1">
                        {{ $products->appends(request()->query())->links('vendor.pagination.shop') }}
                    </div>
                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->
@endsection
