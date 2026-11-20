@extends('cms.app')

@section('title', $sector['title'])
@section('meta_description', $sector['description'])
@section('meta_keywords', implode(', ', array_merge($sector['primary_keywords'], $sector['secondary_keywords'])))
@section('canonical', route('sector', $slug))
@if ($products->currentPage() > 1)
    {{-- Page 2+ of the product list: keep crawling links, but rank page 1 only. --}}
    @section('robots', 'noindex, follow')
@endif

@push('seo')
    @php
        $faqSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => collect($sector['faqs'])->map(fn ($answer, $question) => [
                '@type' => 'Question',
                'name' => $question,
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $answer],
            ])->values()->all(),
        ];
        $breadcrumbSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('home')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => $sector['name'], 'item' => route('sector', $slug)],
            ],
        ];
    @endphp
    <script type="application/ld+json">@json($faqSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG)</script>
    <script type="application/ld+json">@json($breadcrumbSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG)</script>
@endpush

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center text-center px-3" style="min-height: 260px">
            <h1 class="font-weight-semi-bold mb-3">{{ $sector['heading'] }}</h1>
            <nav class="d-inline-flex" aria-label="breadcrumb">
                <p class="m-0"><a href="{{ route('home') }}">{{ __('cms.page.home') }}</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">{{ $sector['name'] }}</p>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Intro Start -->
    <div class="container-fluid pb-3">
        <div class="row px-xl-5">
            <div class="col-lg-10">
                @foreach ($sector['intro'] as $paragraph)
                    <p class="mb-3">{{ $paragraph }}</p>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Intro End -->

    <!-- Products Start -->
    <div class="container-fluid pt-3">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">{{ $sector['name'] }} Products &amp; Suppliers</span></h2>
        </div>
        <div class="row px-xl-5 pb-3">
            @forelse ($products as $product)
                <div class="col-lg-3 col-md-4 col-6 pb-1">
                    @include('cms.product_card', ['product' => $product])
                </div>
            @empty
                <div class="col-12 text-center pb-4">
                    <p class="text-muted mb-3">New {{ strtolower($sector['name']) }} suppliers are joining Wethelink. Browse all products or list your own.</p>
                    <a href="{{ route('shop') }}" class="btn btn-primary mr-2">Browse all products</a>
                    <a href="{{ route('company.registration.form') }}" class="btn btn-outline-primary">Register your company</a>
                </div>
            @endforelse
        </div>
        @if ($products->hasPages())
            <div class="row px-xl-5">
                <div class="col-12 pb-4">
                    {{ $products->links('vendor.pagination.shop') }}
                </div>
            </div>
        @endif
    </div>
    <!-- Products End -->

    <!-- FAQ Start -->
    <div class="container-fluid py-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Frequently Asked Questions</span></h2>
        </div>
        <div class="row px-xl-5">
            <div class="col-lg-10 mx-auto">
                <div class="accordion" id="sectorFaq">
                    @foreach ($sector['faqs'] as $question => $answer)
                        <div class="card border-0 mb-2">
                            <div class="card-header bg-light p-3" id="sectorFaqHeading{{ $loop->index }}">
                                <h3 class="h6 mb-0">
                                    <button class="btn btn-link text-left text-dark p-0" type="button" data-toggle="collapse"
                                        data-target="#sectorFaq{{ $loop->index }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                        aria-controls="sectorFaq{{ $loop->index }}">{{ $question }}</button>
                                </h3>
                            </div>
                            <div id="sectorFaq{{ $loop->index }}" class="collapse {{ $loop->first ? 'show' : '' }}"
                                aria-labelledby="sectorFaqHeading{{ $loop->index }}" data-parent="#sectorFaq">
                                <div class="card-body">{{ $answer }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- FAQ End -->

    <!-- Related searches Start -->
    <div class="container-fluid pb-4">
        <div class="row px-xl-5">
            <div class="col-12">
                <h2 class="h5 font-weight-semi-bold mb-3">Popular {{ $sector['name'] }} searches</h2>
                <div class="d-flex flex-wrap">
                    @foreach (array_merge($sector['primary_keywords'], $sector['secondary_keywords']) as $keyword)
                        <span class="border bg-light text-dark small px-2 py-1 mr-2 mb-2">{{ $keyword }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Related searches End -->

    <!-- Other sectors Start -->
    <div class="container-fluid pb-5">
        <div class="row px-xl-5">
            <div class="col-12">
                <h2 class="h5 font-weight-semi-bold mb-3">Explore other sectors</h2>
                <div class="d-flex flex-wrap">
                    @foreach ($otherSectors as $otherSlug => $other)
                        <a href="{{ route('sector', $otherSlug) }}" class="btn btn-sm btn-outline-primary mr-2 mb-2">
                            <i class="{{ $other['icon'] }} mr-1"></i>{{ $other['name'] }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Other sectors End -->
@endsection
