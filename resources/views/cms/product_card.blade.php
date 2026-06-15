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
            <h6>{{ number_format($product->price, 2) }}RWF</h6>
            @if($product->discount_price)
                <h6 class="text-muted ml-2"><del>{{ number_format($product->price, 2) }}RWF</del></h6>
            @endif
        </div>
        <p>
            MOQ({{ $product->minimum_order_quantity }}{{ $product->unit }}) <BR>
            {{ $product->company ? $product->company->name : '-' }}
            @if($product->company && $product->company->status === 'active')
                <i class="fas fa-check-circle text-primary" title="Active"></i>
            @endif
        </p>
    </div>
    <div class="card-footer d-flex justify-content-between bg-light border">
        <a href="{{ route('product.detail', $product->slug) }}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $product->company->telephone ?? '') }}?text={{ 'I am interested in ' . urlencode($product->barcode ?? $product->name) }}" class="btn btn-sm text-dark p-0" target="_blank"><i class="fab fa-whatsapp text-success mr-1"></i>Chat Now</a>
    </div>
</div>