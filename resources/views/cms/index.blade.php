@extends('cms.app')
@section('content')
    
    <!-- Featured Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
            @foreach($featuredItems as $item)
                <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                    <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                        <h1 class="{{ $item->icon_class ?? 'fa fa-check' }} text-primary m-0 mr-3"></h1>
                        <div>
                            <h5 class="font-weight-semi-bold m-0">{{ $item->title }}</h5>
                            @if(!empty($item->description))
                                <p class="small text-muted mb-0">{{ $item->description }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Featured End -->


    <!-- Categories Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
            @foreach($categories as $category)
                <div class="col-lg-4 col-md-6 pb-1">
                    <div class="cat-item d-flex flex-column border mb-4" style="padding: 30px;">
                        <p class="text-right">{{ $category->products_count }} Products</p>
                        <a href="{{ route('shop', ['category' => $category->id]) }}" class="cat-img position-relative overflow-hidden mb-3">
                            <img class="img-fluid w-100 category-img"
                                src="{{ $category->image ? asset('storage/' . $category->image) : '/cms/img/cat-1.jpg' }}"
                                alt="{{ $category->name }}">
                        </a>
                        <h5 class="font-weight-semi-bold m-0">{{ $category->name }}</h5>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Categories End -->


    <!-- Offer Start -->
    {{-- <div class="container-fluid offer pt-5">
        <div class="row px-xl-5">
            <div class="col-md-6 pb-4">
                <div class="position-relative bg-secondary text-center text-md-right text-white mb-2 py-5 px-5">
                    <img src="{{ asset('cms/img/offer-1.png') }}" alt="">
                    <div class="position-relative" style="z-index: 1;">
                        <h5 class="text-uppercase text-primary mb-3">20% off the all order</h5>
                        <h1 class="mb-4 font-weight-semi-bold">Spring Collection</h1>
                        <a href="" class="btn btn-outline-primary py-md-2 px-md-3">Shop Now</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 pb-4">
                <div class="position-relative bg-secondary text-center text-md-left text-white mb-2 py-5 px-5">
                    <img src="{{ asset('cms/img/offer-2.png') }}" alt="">
                    <div class="position-relative" style="z-index: 1;">
                        <h5 class="text-uppercase text-primary mb-3">20% off the all order</h5>
                        <h1 class="mb-4 font-weight-semi-bold">Winter Collection</h1>
                        <a href="" class="btn btn-outline-primary py-md-2 px-md-3">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- Offer End -->


    <!-- Products Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Trendy Products</span></h2>
        </div>
        <div class="row px-xl-5 pb-3">
            @forelse($trendyProducts as $product)
                <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                    <div class="card product-item border-0 mb-4">
                        <a href="{{ route('product.detail', $product->slug) }}">
                            <div class="card-header product-img position-relative overflow-hidden bg-white border p-0" style="height: 300px;">
                                @php $featured = $product->images->where('is_featured', true)->first() ?? $product->images->first(); @endphp
                                @if($featured)
                                    <img class="img-fluid w-100 h-100" src="{{ asset('storage/' . $featured->image) }}" alt="{{ $product->name }}">
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
                                <!-- @if($product->discount_price)
                                    <h6 class="text-muted ml-2"><del>{{ number_format($product->price) }}RWF</del></h6>
                                @endif -->
                            </div>
                            <p>
                                {{ $product->minimum_order_quantity }} {{ $product->unit }} (MOQ) <BR>
                                {{ $product->company ? $product->company->name : '-' }}
                                @if($product->company)
                                    @if($product->company->status === 'active')
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
                            <a href="{{ route('product.detail', $product->slug) }}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $product->company->telephone ?? '') }}?text={{ urlencode('I want the ' . ($product->category->name ?? $product->name) . ' with barcode ' . $product->barcode) }}"
                                        class="btn btn-sm text-dark p-0" target="_blank"><i
                                            class="fab fa-whatsapp text-success mr-1"></i>Chat Now</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">{{ __('cms.product.no_products_found') }}</p>
                </div>
            @endforelse

            <div class="col-12 pb-1">
                {{ $trendyProducts->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
    <!-- Products End -->


    <!-- Subscribe Start -->
    {{-- <div class="container-fluid bg-secondary my-5">
        <div class="row justify-content-md-center py-5 px-xl-5">
            <div class="col-md-6 col-12 py-5">
                <div class="text-center mb-2 pb-2">
                    <h2 class="section-title px-5 mb-3"><span class="bg-secondary px-2">Stay Updated</span></h2>
                    <p>Amet lorem at rebum amet dolores. Elitr lorem dolor sed amet diam labore at justo ipsum eirmod duo labore labore.</p>
                </div>
                <form action="">
                    <div class="input-group">
                        <input type="text" class="form-control border-white p-4" placeholder="Email Goes Here">
                        <div class="input-group-append">
                            <button class="btn btn-primary px-4">Subscribe</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}
    <!-- Subscribe End -->


    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">{{ __('cms.product.new_arrivals') }}</span></h2>
        </div>
        <div class="row px-xl-5 pb-3">
            @forelse($newArrivals as $product)
                <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                    <div class="card product-item border-0 mb-4">
                        <a href="{{ route('product.detail', $product->slug) }}">
                            <div class="card-header product-img position-relative overflow-hidden bg-white border p-0" style="height: 300px;">
                                @php $featured = $product->images->where('is_featured', true)->first() ?? $product->images->first(); @endphp
                                @if($featured)
                                    <img class="img-fluid w-100 h-100" src="{{ asset('storage/' . $featured->image) }}" alt="{{ $product->name }}">
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
                                <!-- @if($product->discount_price)
                                    <h6 class="text-muted ml-2"><del>{{ number_format($product->price) }}RWF</del></h6>
                                @endif -->
                            </div>
                            <p>
                                {{ $product->minimum_order_quantity }} {{ $product->unit }} (MOQ) <BR>
                                {{ $product->company ? $product->company->name : '-' }}
                                @if($product->company)
                                    @if($product->company->status === 'active')
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
                            <a href="{{ route('product.detail', $product->slug) }}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $product->company->telephone ?? '') }}?text={{ urlencode('I want the ' . ($product->category->name ?? $product->name) . ' with barcode ' . $product->barcode) }}"
                                        class="btn btn-sm text-dark p-0" target="_blank"><i
                                            class="fab fa-whatsapp text-success mr-1"></i>Chat Now</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">{{ __('cms.product.no_products_found') }}</p>
                </div>
            @endforelse

            <div class="col-12 pb-1">
                {{ $newArrivals->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
    <!-- Products End -->


    <!-- Vendor Start -->
    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel vendor-carousel">
                    @foreach($companies as $company)
                        <div class="vendor-item border p-4 text-center">
                            <div class="d-flex align-items-center justify-content-center" style="height: 120px;">
                                @if($company->logo)
                                    <img src="{{ asset('storage/' . $company->logo) }}" alt="{{ $company->name }}" style="max-height: 100px; max-width: 100%; object-fit: contain;">
                                @else
                                    <div class="text-center text-muted">
                                        <i class="fas fa-building fa-3x mb-2"></i>
                                        <div class="small">{{ $company->name }}</div>
                                    </div>
                                @endif
                            </div>
                            <div class="mt-3 font-weight-bold text-dark">{{ $company->name }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Vendor End -->
@endsection