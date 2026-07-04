@extends('cms.app')
@section('content')


    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">{{ $product->name }}</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="{{ route('home') }}">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Product Detail</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Shop Detail Start -->
    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <div class="col-lg-5 pb-5">
                @php
                    $mediaItems = collect();
                    foreach ($product->images as $image) {
                        $src = asset('storage/' . $image->image);
                        $mediaItems->push(['type' => 'image', 'src' => $src, 'thumb' => $src]);
                    }
                    foreach ($product->videos as $video) {
                        $src = asset('storage/' . $video->video);
                        $mediaItems->push([
                            'type' => 'video',
                            'src' => $src,
                            'thumb' => $video->thumbnail ? asset('storage/' . $video->thumbnail) : null,
                        ]);
                    }
                    $hasMedia = $mediaItems->isNotEmpty();
                @endphp

                @if($hasMedia)
                    <div class="product-gallery d-flex">
                        <div class="product-gallery-thumbs mr-3">
                            @foreach($mediaItems as $index => $item)
                                <button type="button"
                                        class="product-gallery-thumb {{ $index === 0 ? 'active' : '' }}"
                                        data-index="{{ $index }}"
                                        data-type="{{ $item['type'] }}"
                                        data-src="{{ $item['src'] }}"
                                        aria-label="View media {{ $index + 1 }}">
                                    @if($item['type'] === 'image')
                                        <img src="{{ $item['thumb'] }}" alt="{{ $product->name }}">
                                    @elseif($item['thumb'])
                                        <img src="{{ $item['thumb'] }}" alt="{{ $product->name }} video">
                                        <span class="product-gallery-thumb-play"><i class="fas fa-play"></i></span>
                                    @else
                                        <span class="product-gallery-thumb-video">
                                            <i class="fas fa-play"></i>
                                        </span>
                                    @endif
                                </button>
                            @endforeach
                        </div>

                        <div class="product-gallery-main flex-grow-1">
                            @php $first = $mediaItems->first(); @endphp
                            <div class="product-gallery-stage product-media-trigger"
                                 data-index="0"
                                 data-type="{{ $first['type'] }}"
                                 data-src="{{ $first['src'] }}"
                                 title="Click to view full size">
                                <img id="productMainImage"
                                     class="{{ $first['type'] === 'image' ? '' : 'd-none' }}"
                                     src="{{ $first['type'] === 'image' ? $first['src'] : '' }}"
                                     alt="{{ $product->name }}">
                                <div id="productMainVideoWrap" class="{{ $first['type'] === 'video' ? '' : 'd-none' }} w-100 h-100 position-relative">
                                    <video id="productMainVideo"
                                           class="w-100 h-100"
                                           src="{{ $first['type'] === 'video' ? $first['src'] : '' }}"
                                           style="object-fit: contain; pointer-events: none;"
                                           muted
                                           loop
                                           playsinline></video>
                                    <div class="product-gallery-stage-play">
                                        <span><i class="fas fa-play"></i></span>
                                    </div>
                                </div>
                                <span class="product-gallery-zoom-hint"><i class="fas fa-search-plus"></i></span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="product-gallery-main">
                        <div class="product-gallery-stage d-flex align-items-center justify-content-center bg-light">
                            <i class="fas fa-image fa-5x text-muted"></i>
                        </div>
                    </div>
                @endif
            </div>

            <div class="modal fade" id="productMediaModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                    <div class="modal-content bg-transparent border-0">
                        <div class="modal-body p-0 position-relative">
                            <button type="button" class="product-lightbox-close" data-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times"></i>
                            </button>
                            @if($hasMedia && $mediaItems->count() > 1)
                                <button type="button" class="product-lightbox-nav product-lightbox-prev" aria-label="Previous">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button type="button" class="product-lightbox-nav product-lightbox-next" aria-label="Next">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                                <span class="product-lightbox-counter"></span>
                            @endif
                            <div class="product-lightbox-content text-center">
                                <img id="productMediaModalImage" class="img-fluid d-none mx-auto" alt="{{ $product->name }}">
                                <video id="productMediaModalVideo" class="w-100 d-none" controls playsinline></video>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($hasMedia)
            <style>
                .product-gallery-thumbs {
                    display: grid;
                    grid-template-columns: repeat(2, 72px);
                    gap: 8px;
                    flex-shrink: 0;
                }
                .product-gallery-thumb {
                    width: 72px;
                    height: 90px;
                    padding: 0;
                    border: 2px solid transparent;
                    background: #fff;
                    overflow: hidden;
                    cursor: pointer;
                    position: relative;
                    transition: border-color 0.2s;
                }
                .product-gallery-thumb.active {
                    border-color: #111;
                }
                .product-gallery-thumb img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                }
                .product-gallery-thumb-video,
                .product-gallery-thumb-play {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    width: 100%;
                    height: 100%;
                    background: #f3f3f3;
                    color: #333;
                }
                .product-gallery-thumb-play {
                    position: absolute;
                    inset: 0;
                    background: rgba(0, 0, 0, 0.25);
                    color: #fff;
                    font-size: 14px;
                }
                .product-gallery-main {
                    min-width: 0;
                }
                .product-gallery-stage {
                    position: relative;
                    height: 600px;
                    background: #fff;
                    border: 1px solid #eee;
                    cursor: zoom-in;
                    overflow: hidden;
                }
                .product-gallery-stage img,
                .product-gallery-stage video {
                    width: 100%;
                    height: 100%;
                    object-fit: contain;
                }
                .product-gallery-zoom-hint {
                    position: absolute;
                    right: 12px;
                    bottom: 12px;
                    width: 36px;
                    height: 36px;
                    border-radius: 50%;
                    background: rgba(255, 255, 255, 0.92);
                    color: #333;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 14px;
                    pointer-events: none;
                    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.12);
                }
                .product-gallery-stage-play {
                    position: absolute;
                    inset: 0;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    pointer-events: none;
                    background: rgba(0, 0, 0, 0.08);
                }
                .product-gallery-stage-play span {
                    width: 64px;
                    height: 64px;
                    border-radius: 50%;
                    background: rgba(255, 255, 255, 0.92);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: #D19C97;
                    font-size: 22px;
                    padding-left: 4px;
                }
                #productMediaModal .modal-body {
                    min-height: 70vh;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
                #productMediaModal .modal-dialog {
                    max-width: min(1100px, 95vw);
                }
                .product-lightbox-content {
                    width: 100%;
                    max-height: 85vh;
                }
                .product-lightbox-content img,
                .product-lightbox-content video {
                    max-height: 85vh;
                    width: auto;
                    max-width: 100%;
                    margin: 0 auto;
                }
                .product-lightbox-close {
                    position: absolute;
                    top: 12px;
                    right: 12px;
                    z-index: 10;
                    width: 40px;
                    height: 40px;
                    border: none;
                    border-radius: 50%;
                    background: rgba(0, 0, 0, 0.55);
                    color: #fff;
                    font-size: 18px;
                    cursor: pointer;
                }
                .product-lightbox-nav {
                    position: absolute;
                    top: 50%;
                    transform: translateY(-50%);
                    z-index: 10;
                    width: 44px;
                    height: 44px;
                    border: none;
                    border-radius: 50%;
                    background: rgba(0, 0, 0, 0.55);
                    color: #fff;
                    font-size: 16px;
                    cursor: pointer;
                }
                .product-lightbox-prev { left: 12px; }
                .product-lightbox-next { right: 12px; }
                .product-lightbox-counter {
                    position: absolute;
                    bottom: 12px;
                    left: 50%;
                    transform: translateX(-50%);
                    z-index: 10;
                    background: rgba(0, 0, 0, 0.55);
                    color: #fff;
                    padding: 4px 12px;
                    border-radius: 20px;
                    font-size: 13px;
                }
                @media (max-width: 575px) {
                    .product-gallery {
                        flex-direction: column-reverse;
                    }
                    .product-gallery-thumbs {
                        grid-template-columns: repeat(4, 1fr);
                        width: 100%;
                        margin-right: 0 !important;
                        margin-top: 10px;
                    }
                    .product-gallery-thumb {
                        width: 100%;
                        height: 72px;
                    }
                    .product-gallery-stage {
                        height: 420px;
                    }
                }
            </style>
            @endif

            <div class="col-lg-7 pb-5">
                <h3 class="font-weight-semi-bold">{{ $product->name }}</h3>
                <div class="d-flex mb-3">
                    <div class="text-primary mr-2">
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star-half-alt"></small>
                        <small class="far fa-star"></small>
                    </div>
                    <small class="pt-1">({{ count($product->reviews ?? []) }} Reviews)</small>
                </div>
                <h3 class="font-weight-semi-bold mb-4">
                        {{ number_format($product->price) }}RWF
                </h3>
                <p class="mb-4">{{ $product->short_description ?? 'No description available for this product.' }}</p>
                {{-- <div class="d-flex mb-3">
                    <p class="text-dark font-weight-medium mb-0 mr-3">Sizes:</p>
                    <form>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="size-1" name="size">
                            <label class="custom-control-label" for="size-1">XS</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="size-2" name="size">
                            <label class="custom-control-label" for="size-2">S</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="size-3" name="size">
                            <label class="custom-control-label" for="size-3">M</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="size-4" name="size">
                            <label class="custom-control-label" for="size-4">L</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="size-5" name="size">
                            <label class="custom-control-label" for="size-5">XL</label>
                        </div>
                    </form>
                </div>
                <div class="d-flex mb-4">
                    <p class="text-dark font-weight-medium mb-0 mr-3">Colors:</p>
                    <form>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="color-1" name="color">
                            <label class="custom-control-label" for="color-1">Black</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="color-2" name="color">
                            <label class="custom-control-label" for="color-2">White</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="color-3" name="color">
                            <label class="custom-control-label" for="color-3">Red</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="color-4" name="color">
                            <label class="custom-control-label" for="color-4">Blue</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="color-5" name="color">
                            <label class="custom-control-label" for="color-5">Green</label>
                        </div>
                    </form>
                </div> --}}
                <div class="d-flex align-items-center mb-4 pt-2">
                    {{-- <div class="input-group quantity mr-3" style="width: 130px;">
                        <div class="input-group-btn">
                            <button class="btn btn-primary btn-minus" >
                            <i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <input type="text" class="form-control bg-secondary text-center" value="1">
                        <div class="input-group-btn">
                            <button class="btn btn-primary btn-plus">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div> --}}
                                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $product->company->telephone ?? '') }}?text={{ urlencode('I want the ' . ($product->category->name ?? $product->name) . ' with barcode ' . $product->barcode) }}">
                                                        <button class="btn btn-success px-3">
                    {{-- <button class="btn btn-primary px-3"><i class="fa fa-shopping-cart mr-1"></i> {{ __('cms.product.add_to_cart') }}</button> --}}
                </div>
                {{-- <div class="d-flex pt-2">
                    <p class="text-dark font-weight-medium mb-0 mr-2">Share on:</p>
                    <div class="d-inline-flex">
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-pinterest"></i>
                        </a>
                    </div>
                </div> --}}
            </div>
        </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                    <a class="nav-item nav-link active" data-toggle="tab" href="#tab-pane-1">Description</a>
                    {{-- <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-2">Information</a> --}}
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-3">Reviews ({{ count($product->reviews ?? []) }})</a>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-pane-1">
                        <h4 class="mb-3">Product Description</h4>
                        {!! $product->description !!}
                    </div>
                    {{-- Additional Information section --}}
                    {{-- <div class="tab-pane fade" id="tab-pane-2">
                        
                        <h4 class="mb-3">Additional Information</h4>
                        <p>Eos no lorem eirmod diam diam, eos elitr et gubergren diam sea. Consetetur vero aliquyam invidunt duo dolores et duo sit. Vero diam ea vero et dolore rebum, dolor rebum eirmod consetetur invidunt sed sed et, lorem duo et eos elitr, sadipscing kasd ipsum rebum diam. Dolore diam stet rebum sed tempor kasd eirmod. Takimata kasd ipsum accusam sadipscing, eos dolores sit no ut diam consetetur duo justo est, sit sanctus diam tempor aliquyam eirmod nonumy rebum dolor accusam, ipsum kasd eos consetetur at sit rebum, diam kasd invidunt tempor lorem, ipsum lorem elitr sanctus eirmod takimata dolor ea invidunt.</p>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item px-0">
                                        Sit erat duo lorem duo ea consetetur, et eirmod takimata.
                                    </li>
                                    <li class="list-group-item px-0">
                                        Amet kasd gubergren sit sanctus et lorem eos sadipscing at.
                                    </li>
                                    <li class="list-group-item px-0">
                                        Duo amet accusam eirmod nonumy stet et et stet eirmod.
                                    </li>
                                    <li class="list-group-item px-0">
                                        Takimata ea clita labore amet ipsum erat justo voluptua. Nonumy.
                                    </li>
                                  </ul> 
                            </div>
                            <div class="col-md-6">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item px-0">
                                        Sit erat duo lorem duo ea consetetur, et eirmod takimata.
                                    </li>
                                    <li class="list-group-item px-0">
                                        Amet kasd gubergren sit sanctus et lorem eos sadipscing at.
                                    </li>
                                    <li class="list-group-item px-0">
                                        Duo amet accusam eirmod nonumy stet et et stet eirmod.
                                    </li>
                                    <li class="list-group-item px-0">
                                        Takimata ea clita labore amet ipsum erat justo voluptua. Nonumy.
                                    </li>
                                  </ul> 
                            </div>
                        </div>
                    </div> --}}
                    <div class="tab-pane fade" id="tab-pane-3">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="mb-4">{{ count($product->reviews ?? []) }} review(s) for "{{ $product->name }}"</h4>
                                @foreach($product->reviews ?? [] as $review)
                                    <div class="media mb-4">
                                        <img src="{{ asset('cms/img/user.jpg') }}" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
                                        <div class="media-body">
                                            <h6>{{ $review->user->name ?? $review->name }}<small> - <i>{{ $review->created_at->format('d M Y') }}</i></small></h6>
                                            <div class="text-primary mb-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star"></i>
                                                @endfor
                                            </div>
                                            <p>{{ $review->comment }}</p>
                                        </div>
                                    </div>
                                @endforeach
                                @if(!isset($product->reviews) || $product->reviews->isEmpty())
                                    <p class="text-muted">There are no reviews for this product yet.</p>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <h4 class="mb-4">Leave a review</h4>
                                <small>Your email address will not be published. Required fields are marked *</small>
                                @if(session('success'))
                                    <div class="alert alert-success mt-2">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                <form action="{{ url('product/'.$product->id.'/review') }}" method="POST">
                                    @csrf
                                    <div class="d-flex my-3">
                                        <p class="mb-0 mr-2">Your Rating * :</p>
                                        <div class="text-primary">
                                            <select name="rating" class="form-control form-control-sm d-inline-block" style="width: auto;" required>
                                                {{-- <option value="">Select Rating</option> --}}
                                                <option value="5">5 Stars</option>
                                                <option value="4">4 Stars</option>
                                                <option value="3">3 Stars</option>
                                                <option value="2">2 Stars</option>
                                                <option value="1">1 Star</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="message">Your Review *</label>
                                        <textarea id="message" name="comment" cols="30" rows="5" class="form-control" required>{{ old('comment') }}</textarea>
                                    </div>
                                    @guest
                                        <div class="form-group">
                                            <label for="name">Your Name *</label>
                                            <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Your Email *</label>
                                            <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}" required>
                                        </div>
                                    @endguest
                                    <div class="form-group mb-0">
                                        <input type="submit" value="Leave Your Review" class="btn btn-primary px-3">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->


    <!-- Products Start -->
    <div class="container-fluid py-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">You May Also Like</span></h2>
        </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel related-carousel">
                    @foreach($relatedProducts as $related)
                        <div class="card product-item border-0">
                            <a href="{{ route('product.detail', $related->slug) }}">
                                <div class="card-header product-img position-relative overflow-hidden bg-white border p-0" style="height: 300px;">
                                    @php $feat = $related->images->where('is_featured', true)->first() ?? $related->images->first(); @endphp
                                    <img class="img-fluid w-100 h-100" src="{{ $feat ? asset('storage/' . $feat->image) : asset('cms/img/product-1.jpg') }}" alt="{{ $related->name }}">
                                </div>
                            </a>
                            <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                <h6 class="text-truncate mb-3">{{ $related->name }}</h6>
                                <div class="d-flex justify-content-center">
                                    <h6>{{ number_format($related->price) }} RWF</h6>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-between bg-light border">
                                <a href="{{ route('product.detail', $related->slug) }}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                               <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $product->company->telephone ?? '') }}?text={{ urlencode('I want the ' . ($product->category->name ?? $product->name) . ' with barcode ' . $product->barcode) }}"
                                        class="btn btn-sm text-dark p-0" target="_blank"><i
                                            class="fab fa-whatsapp text-success mr-1"></i>Chat Now</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Products End -->

@endsection

@push('scripts')
@if($hasMedia ?? false)
<script>
    $(function () {
        var mediaItems = @json($mediaItems->values());
        var currentIndex = 0;

        var $modal = $('#productMediaModal');
        var $modalImage = $('#productMediaModalImage');
        var $modalVideo = $('#productMediaModalVideo');
        var $mainStage = $('.product-gallery-stage');
        var $mainImage = $('#productMainImage');
        var $mainVideoWrap = $('#productMainVideoWrap');
        var $mainVideo = $('#productMainVideo');
        var $counter = $('.product-lightbox-counter');

        function pauseMainVideo() {
            if ($mainVideo.length && $mainVideo.get(0).src) {
                $mainVideo.get(0).pause();
            }
        }

        function playMainVideo() {
            if (!$mainVideoWrap.hasClass('d-none') && $mainVideo.length) {
                $mainVideo.get(0).play().catch(function () {});
            }
        }

        function setMainMedia(index) {
            var item = mediaItems[index];
            if (!item) {
                return;
            }

            currentIndex = index;
            pauseMainVideo();

            $mainStage.attr('data-index', index).attr('data-type', item.type).attr('data-src', item.src);
            $('.product-gallery-thumb').removeClass('active').eq(index).addClass('active');

            if (item.type === 'image') {
                $mainImage.removeClass('d-none').attr('src', item.src);
                $mainVideoWrap.addClass('d-none');
                $mainVideo.attr('src', '');
            } else {
                $mainImage.addClass('d-none').attr('src', '');
                $mainVideoWrap.removeClass('d-none');
                $mainVideo.attr('src', item.src);
                playMainVideo();
            }
        }

        function openLightbox(index) {
            var item = mediaItems[index];
            if (!item) {
                return;
            }

            currentIndex = index;
            pauseMainVideo();
            $modalImage.addClass('d-none').attr('src', '');
            $modalVideo.addClass('d-none').attr('src', '').get(0).pause();

            if (item.type === 'image') {
                $modalImage.removeClass('d-none').attr('src', item.src);
            } else {
                $modalVideo.removeClass('d-none').attr('src', item.src);
            }

            updateLightboxCounter();
            $modal.modal('show');
        }

        function updateLightboxCounter() {
            if ($counter.length) {
                $counter.text((currentIndex + 1) + ' / ' + mediaItems.length);
            }
        }

        function navigateLightbox(direction) {
            currentIndex = (currentIndex + direction + mediaItems.length) % mediaItems.length;
            setMainMedia(currentIndex);

            var item = mediaItems[currentIndex];
            $modalImage.addClass('d-none').attr('src', '');
            $modalVideo.addClass('d-none').attr('src', '').get(0).pause();

            if (item.type === 'image') {
                $modalImage.removeClass('d-none').attr('src', item.src);
            } else {
                $modalVideo.removeClass('d-none').attr('src', item.src);
                $modalVideo.get(0).play().catch(function () {});
            }

            updateLightboxCounter();
        }

        $('.product-gallery-thumb').on('click', function () {
            setMainMedia(parseInt($(this).data('index'), 10));
        });

        $mainStage.on('click', function () {
            openLightbox(parseInt($(this).attr('data-index'), 10));
        });

        $('.product-lightbox-prev').on('click', function (e) {
            e.stopPropagation();
            navigateLightbox(-1);
        });

        $('.product-lightbox-next').on('click', function (e) {
            e.stopPropagation();
            navigateLightbox(1);
        });

        $modal.on('shown.bs.modal', function () {
            if (!$modalVideo.hasClass('d-none')) {
                $modalVideo.get(0).play().catch(function () {});
            }
        });

        $modal.on('hidden.bs.modal', function () {
            $modalVideo.get(0).pause();
            $modalVideo.attr('src', '');
            $modalImage.attr('src', '');
            playMainVideo();
        });

        $(document).on('keydown', function (e) {
            if (!$modal.hasClass('show')) {
                return;
            }
            if (e.key === 'ArrowLeft') {
                navigateLightbox(-1);
            } else if (e.key === 'ArrowRight') {
                navigateLightbox(1);
            } else if (e.key === 'Escape') {
                $modal.modal('hide');
            }
        });

        playMainVideo();
    });
</script>
@endif
@endpush