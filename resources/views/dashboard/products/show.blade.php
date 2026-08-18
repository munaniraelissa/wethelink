@extends('dashboard.app')
@section('content')
    <main class="dashboard-content">
        <div class="container-fluid px-3 px-lg-4 py-4">
            <div class="page-heading">
                <div class="page-heading-copy">
                    <span class="page-icon"><i class="bi bi-box-seam" aria-hidden="true"></i></span>
                    <div>
                        <p class="eyebrow mb-1">{{ __('products.product_management') }}</p>
                        <h1 class="h3 mb-1">{{ $product->name }}</h1>
                        <p class="text-muted mb-0">{{ __('products.product_details') }}</p>
                    </div>
                </div>
                <div class="heading-actions">
                    @can('product-edit')
                        <a class="btn btn-light btn-sm" href="{{ route('products.edit', $product->id) }}">
                            <i class="bi bi-pencil" aria-hidden="true"></i> {{ __('products.edit') }}
                        </a>
                    @endcan
                    <a class="btn btn-secondary btn-sm" href="{{ route('products.index') }}">
                        <i class="bi bi-arrow-left" aria-hidden="true"></i> {{ __('products.back') }}
                    </a>
                </div>
            </div>

            <section class="panel mt-3">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>{{ __('products.basic_information') }}</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th style="width: 30%;">{{ __('products.sku') }}:</th>
                                    <td>{{ $product->sku }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('products.barcode') }}:</th>
                                    <td>{{ $product->barcode ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('products.category') }}:</th>
                                    <td>{{ $product->category ? $product->category->name : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('products.brand') }}:</th>
                                    <td>{{ $product->brand ? $product->brand->name : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('products.status') }}:</th>
                                    <td>
                                        @php
                                            $statusBadges = [
                                                'draft' => 'bg-secondary',
                                                'published' => 'bg-success',
                                                'out_of_stock' => 'bg-warning',
                                                'inactive' => 'bg-danger',
                                            ];
                                        @endphp
                                        <span
                                            class="badge {{ $statusBadges[$product->status] ?? 'bg-secondary' }}">{{ __('products.status_' . $product->status) }}</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>{{ __('products.pricing_inventory') }}</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th style="width: 30%;">{{ __('products.price') }}:</th>
                                    <td>{{ number_format($product->price, 2) }}RWF</td>
                                </tr>
                                {{-- <tr>
                <th>{{ __('products.discount_price') }}:</th>
                <td>{{ $product->discount_price ? '$' . number_format($product->discount_price, 2) : '-' }}</td>
              </tr>
              <tr>
                <th>{{ __('products.cost_price') }}:</th>
                <td>{{ $product->cost_price ? '$' . number_format($product->cost_price, 2) : '-' }}</td>
              </tr>
              <tr>
                <th>{{ __('products.quantity') }}:</th>
                <td>{{ $product->quantity }} {{ $product->unit }}</td>
              </tr> --}}
                                <tr>
                                    <th>{{ __('products.minimum_order_quantity') }}:</th>
                                    <td>{{ $product->minimum_order_quantity }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <h5>{{ __('products.description') }}</h5>
                            <p>{{ $product->short_description ?: '-' }}</p>
                            <p class="text-muted">{{ $product->description ?: '-' }}</p>
                        </div>
                    </div>
                    @if ($product->images->count() > 0)
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <h5>{{ __('products.images') }}</h5>
                                <div class="d-flex gap-2 flex-wrap">
                                    @foreach ($product->images as $image)
                                        <img src="{{ asset('storage/' . $image->image) }}" alt="Product Image"
                                            class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($product->videos->count() > 0)
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <h5>{{ __('products.videos') }}</h5>
                                <div class="d-flex gap-3 flex-wrap">
                                    @foreach ($product->videos as $video)
                                        <video src="{{ asset('storage/' . $video->video) }}" controls
                                            class="rounded border"
                                            style="max-width: 320px; max-height: 240px; background: #000;"></video>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </main>
@endsection
