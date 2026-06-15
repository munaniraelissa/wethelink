@extends('cms.app')
@section('content')
    
    <!-- Featured Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Quality Product</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                    <h5 class="font-weight-semi-bold m-0">Free Shipping</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">14-Day Return</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">24/7 Support</h5>
                </div>
            </div>
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
    <div class="container-fluid offer pt-5">
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
    </div>
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
                            <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0" style="height: 300px;">
                                @php $featured = $product->images->where('is_featured', true)->first() ?? $product->images->first(); @endphp
                                @if($featured)
                                    <img class="img-fluid w-100" src="{{ asset('storage/' . $featured->image) }}" alt="{{ $product->name }}">
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
                                <h6>
                                    @if($product->discount_price)
                                        <span class="text-decoration-line-through text-muted"><del>{{ number_format($product->price, 2) }}RWF</del></span>
                                        <span class="text-success fw-bold">{{ number_format($product->discount_price, 2) }}RWF</span>
                                    @else
                                        {{ number_format($product->price, 2) }}RWF
                                    @endif
                                </h6>
                            </div>
                            <p>
                                
                               MOQ: ({{ $product->minimum_order_quantity }}{{ $product->unit }})<br>
                                {{ $product->company ? $product->company->name : '-' }}
                                @if($product->company)
                                    @if($product->company->status === 'active')
                                        <i class="fas fa-check-circle text-primary" title="Active"></i>
                                    @elseif($product->company->status === 'inactive')
                                        <i class="fas fa-times-circle text-danger" title="Inactive"></i>
                                    @endif
                                @endif
                            </p>
                        </div>
                        <div class="card-footer d-flex justify-content-between bg-light border">
                            <a href="{{ route('product.detail', $product->slug) }}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $product->company->telephone ?? '') }}?text={{ urlencode($product->short_description ?? 'Hello, I am interested in ' . $product->name) }}" class="btn btn-sm text-dark p-0" target="_blank"><i class="fab fa-whatsapp text-success mr-1"></i>Chat Now</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">No products found Here.</p>
                </div>
            @endforelse

            <div class="col-12 pb-1">
                {{ $trendyProducts->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
    <!-- Products End -->


    <!-- Subscribe Start -->
    <div class="container-fluid bg-secondary my-5">
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
    </div>
    <!-- Subscribe End -->


    <!-- Products Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Just Arrived</span></h2>
        </div>
        <div class="row px-xl-5 pb-3">
            @forelse($newArrivals as $product)
                <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                    <div class="card product-item border-0 mb-4">
                        <a href="{{ route('product.detail', $product->slug) }}">
                            <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0" style="height: 300px;">
                                @php $featured = $product->images->where('is_featured', true)->first() ?? $product->images->first(); @endphp
                                @if($featured)
                                    <img class="img-fluid w-100" src="{{ asset('storage/' . $featured->image) }}" alt="{{ $product->name }}">
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
                                <h6>
                                    @if($product->discount_price)
                                        <span class="text-decoration-line-through text-muted"><del>{{ number_format($product->price, 2) }}RWF</del></span>
                                        <span class="text-success fw-bold">{{ number_format($product->discount_price, 2) }}RWF</span>
                                    @else
                                        {{ number_format($product->price, 2) }}RWF
                                    @endif
                                </h6>
                            </div>
                            <p>
                                
                               MOQ: ({{ $product->minimum_order_quantity }}{{ $product->unit }})<br>
                                {{ $product->company ? $product->company->name : '-' }}
                                @if($product->company)
                                    @if($product->company->status === 'active')
                                        <i class="fas fa-check-circle text-primary" title="Active"></i>
                                    @elseif($product->company->status === 'inactive')
                                        <i class="fas fa-times-circle text-danger" title="Inactive"></i>
                                    @endif
                                @endif
                            </p>
                        </div>
                        <div class="card-footer d-flex justify-content-between bg-light border">
                            <a href="{{ route('product.detail', $product->slug) }}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $product->company->telephone ?? '') }}?text={{ urlencode($product->short_description ?? 'Hello, I am interested in ' . $product->name) }}" class="btn btn-sm text-dark p-0" target="_blank"><i class="fab fa-whatsapp text-success mr-1"></i>Chat Now</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">No products found Here.</p>
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
                    <div class="vendor-item border p-4">
                        <img src="{{ asset('cms/img/vendor-1.jpg') }}" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="{{ asset('cms/img/vendor-2.jpg') }}" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="{{ asset('cms/img/vendor-3.jpg') }}" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="{{ asset('cms/img/vendor-4.jpg') }}" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="{{ asset('cms/img/vendor-5.jpg') }}" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="{{ asset('cms/img/vendor-6.jpg') }}" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="{{ asset('cms/img/vendor-7.jpg') }}" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="{{ asset('cms/img/vendor-8.jpg') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Vendor End -->
@endsection