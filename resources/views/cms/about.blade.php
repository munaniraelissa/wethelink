@extends('cms.app')

@section('content')
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">{{ __('cms.page.about') }}</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="{{ route('home') }}">{{ __('cms.nav.home') }}</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">{{ __('cms.page.about') }}</p>
            </div>
        </div>
    </div>

    <div class="container-fluid py-5">
        <div class="row px-xl-5 align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img src="{{ asset('cms/img/vendor-1.jpg') }}" alt="About Wethelink" class="img-fluid rounded shadow" style="max-height: 420px; object-fit: cover; width: 100%;">
            </div>
            <div class="col-lg-6">
                <h2 class="section-title pr-5 mb-4"><span class="pr-2">{{ __('cms.about.title') }}</span></h2>
                <h4 class="font-weight-semi-bold text-primary mb-4">{{ __('cms.about.subtitle') }}</h4>
                <p class="mb-4">{{ __('cms.about.intro') }}</p>
                <p class="mb-4">{{ __('cms.about.description') }}</p>
                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <div class="border rounded p-3 h-100">
                            <h5 class="font-weight-semi-bold mb-2">{{ __('cms.about.mission_title') }}</h5>
                            <p class="mb-0">{{ __('cms.about.mission_text') }}</p>
                        </div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="border rounded p-3 h-100">
                            <h5 class="font-weight-semi-bold mb-2">{{ __('cms.about.vision_title') }}</h5>
                            <p class="mb-0">{{ __('cms.about.vision_text') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid py-5 bg-light">
        <div class="row px-xl-5">
            <div class="col-12 text-center mb-4">
                <h2 class="section-title px-5"><span class="px-2">{{ __('cms.about.focus_title') }}</span></h2>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h4 class="font-weight-semi-bold text-primary mb-3">🇷🇼 {{ __('cms.about.focus_rwanda') }}</h4>
                        <ul class="mb-0 pl-3">
                            <li>{{ __('cms.about.focus_rwanda_item_1') }}</li>
                            <li>{{ __('cms.about.focus_rwanda_item_2') }}</li>
                            <li>{{ __('cms.about.focus_rwanda_item_3') }}</li>
                            <li>{{ __('cms.about.focus_rwanda_item_4') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h4 class="font-weight-semi-bold text-primary mb-3">🌍 {{ __('cms.about.focus_africa') }}</h4>
                        <ul class="mb-0 pl-3">
                            <li>{{ __('cms.about.focus_africa_item_1') }}</li>
                            <li>{{ __('cms.about.focus_africa_item_2') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h4 class="font-weight-semi-bold text-primary mb-3">🌎 {{ __('cms.about.focus_global') }}</h4>
                        <ul class="mb-0 pl-3">
                            <li>{{ __('cms.about.focus_global_item_1') }}</li>
                            <li>{{ __('cms.about.focus_global_item_2') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <div class="col-lg-7 mb-4">
                <h2 class="section-title pr-5 mb-4"><span class="pr-2">{{ __('cms.about.why_title') }}</span></h2>
                <div class="row">
                    @php
                        $benefits = [
                            __('cms.about.reason_1'),
                            __('cms.about.reason_2'),
                            __('cms.about.reason_3'),
                            __('cms.about.reason_4'),
                            __('cms.about.reason_5'),
                            __('cms.about.reason_6'),
                            __('cms.about.reason_7'),
                        ];
                    @endphp
                    @foreach ($benefits as $benefit)
                        <div class="col-sm-6 mb-3">
                            <div class="d-flex align-items-start">
                                <i class="fa fa-check-circle text-primary mt-1 mr-2"></i>
                                <p class="mb-0">{{ $benefit }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-5">
                <img src="{{ asset('cms/img/vendor-2.jpg') }}" alt="Wethelink business network" class="img-fluid rounded shadow" style="height: 360px; width: 100%; object-fit: cover;">
            </div>
        </div>
    </div>

    <div class="container-fluid py-5 bg-light">
        <div class="row px-xl-5">
            <div class="col-12 text-center mb-4">
                <h2 class="section-title px-5"><span class="px-2">{{ __('cms.about.values_title') }}</span></h2>
            </div>
            <div class="col-lg-5 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <h5 class="font-weight-semi-bold mb-3">{{ __('cms.about.values_heading') }}</h5>
                        <p class="mb-0">{{ __('cms.about.values_text') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-md-6 mb-4">
                <div class="row">
                    @php
                        $values = [
                            __('cms.about.value_trust'),
                            __('cms.about.value_transparency'),
                            __('cms.about.value_innovation'),
                            __('cms.about.value_collaboration'),
                            __('cms.about.value_growth'),
                        ];
                    @endphp
                    @foreach ($values as $value)
                        <div class="col-sm-6 mb-3">
                            <div class="border rounded p-3 h-100 text-center">
                                <h6 class="font-weight-semi-bold mb-0">{{ $value }}</h6>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
