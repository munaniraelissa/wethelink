@extends('cms.app')
@section('content')

<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 260px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">{{ __('cms.manufacturers.title') }}</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="{{ route('home') }}">{{ __('cms.page.home') }}</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">{{ __('cms.manufacturers.title') }}</p>
        </div>
    </div>
</div>

<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <div class="col-12">
            <div class="text-center mb-5">
                <h4 class="font-weight-semi-bold">{{ __('cms.manufacturers.intro') }}</h4>
            </div>
            <div class="row">
                @forelse($manufacturers as $manufacturer)
                    <div class="col-12 mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="row align-items-start">
                                    <div class="col-lg-4 mb-4 mb-lg-0">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mr-3" style="width:64px;height:64px;overflow:hidden;">
                                                @if($manufacturer->logo)
                                                    <img src="{{ asset('storage/' . $manufacturer->logo) }}" alt="{{ $manufacturer->name }}" class="img-fluid w-100 h-100">
                                                @else
                                                    <i class="fas fa-industry fa-lg text-primary"></i>
                                                @endif
                                            </div>
                                            <div>
                                                <h4 class="font-weight-bold mb-1">{{ $manufacturer->name }}</h4>
                                                <div class="small text-muted">{{ $manufacturer->industry ?: __('cms.manufacturers.industry_default') }}</div>
                                            </div>
                                        </div>

                                        @if($manufacturer->status === 'active')
                                            <span class="badge badge-success mb-3">{{ __('cms.manufacturers.verified') }}<i class="fas fa-check-circle text-primary" title="Active"></i></span>
                                        @else
                                            <span class="badge badge-secondary mb-3">{{ $manufacturer->status }}</span>
                                        @endif

                                        <div class="mb-3">
                                            <h6 class="font-weight-semi-bold">{{ __('cms.manufacturers.company_info') }}</h6>
                                            
                                        </div>

                                        <p class="text-muted">{{ \Illuminate\Support\Str::limit($manufacturer->description ?? __('cms.manufacturers.no_description'), 220) }}</p>

                                        <div class="d-flex flex-wrap gap-2">
                                            <a href="{{ route('shop', ['manufacturer' => $manufacturer->id]) }}" class="btn btn-primary btn-sm">{{ __('cms.manufacturers.explore') }}</a>
                                        </div>
                                    </div>

                                    <div class="col-lg-8">
                                        <div class="row">
                                            @forelse($manufacturer->products->take(3) as $product)
                                                <div class="col-lg-4 col-md-6 col-sm-12 pb-1">
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
                                                                class="btn btn-sm text-dark p-0" target="_blank">
                                                                <i class="fab fa-whatsapp text-success mr-1"></i>Order on WhatsApp
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="col-12 text-center py-5">
                                                    <p class="text-muted mb-0">{{ __('cms.manufacturers.no_products') }}</p>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">{{ __('cms.manufacturers.no_manufacturers') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection
