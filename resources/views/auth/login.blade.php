@extends('auth.app')

@section('content')
    <div class="container-fluid pb-5" style="min-height: calc(100vh - 120px);">
        <div class="row no-gutters align-items-stretch">
            <div class="col-lg-7 d-none d-lg-flex">
                <div class="h-100 w-100 d-flex flex-column justify-content-center text-white px-5" style="background: linear-gradient(135deg, #ff8a00 0%, #ffc45f 100%);">
                    {{-- <a href="{{ route('home') }}" class="d-inline-flex align-items-center mb-4">
                        <img src="{{ asset('cms/logo/Logo.png') }}" alt="We thelink logo" style="height: 50px; width: auto;" />
                    </a> --}}
                    <h1 class="display-4 font-weight-bold mb-3">{{ __('cms.auth.hero_heading_auth') }}</h1>
                    <p class="lead mb-4" style="max-width: 520px;">{{ __('cms.auth.hero_sub_auth') }}</p>
                    <div class="d-flex flex-wrap">
                        <div class="mr-4 mb-3">
                            <h5 class="font-weight-bold mb-2">{{ __('cms.auth.feature_protection_title') }}</h5>
                            <p class="mb-0">{{ __('cms.auth.feature_protection_desc') }}</p>
                        </div>
                        <div class="mb-3">
                            <h5 class="font-weight-bold mb-2">{{ __('cms.auth.feature_delivery_title') }}</h5>
                            <p class="mb-0">{{ __('cms.auth.feature_delivery_desc') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 bg-white d-flex align-items-center">
                <div class="w-100 p-4 p-md-5">
                    <div class="text-center mb-4">
                        <img src="{{ asset('cms/logo/Logo.png') }}" alt="We thelink logo" class="mb-3" style="height: 55px; width: auto;" />
                        <h3 class="font-weight-bold mb-1">{{ __('cms.auth.signin_or_create') }}</h3>
                        <p class="text-muted mb-0">{{ __('cms.auth.by_continuing') }}</p>
                    </div>

                    <a href="#" class="btn btn-outline-secondary btn-block btn-lg mb-3 text-left btn-social">
                        <i class="fab fa-google mr-2"></i>{{ __('cms.auth.continue_with', ['provider' => 'Google']) }}
                    </a>
                    <a href="#" class="btn btn-outline-secondary btn-block btn-lg mb-3 text-left btn-social">
                        <i class="fab fa-facebook-f mr-2"></i>{{ __('cms.auth.continue_with', ['provider' => 'Facebook']) }}
                    </a>
                    <a href="#" class="btn btn-outline-secondary btn-block btn-lg mb-4 text-left btn-social">
                        <i class="fab fa-linkedin-in mr-2"></i>{{ __('cms.auth.continue_with', ['provider' => 'LinkedIn']) }}
                    </a>

                    <div class="d-flex align-items-center mb-4">
                        <div class="border-top flex-grow-1"></div>
                        <span class="px-3 text-muted">{{ __('cms.auth.or') }}</span>
                        <div class="border-top flex-grow-1"></div>
                    </div>

                    <form action="#" method="POST">
                        <div class="form-group">
                            <label for="email" class="font-weight-bold">{{ __('cms.search.placeholder') }}</label>
                            <input type="email" id="email" name="email" class="form-control form-control-lg" placeholder="{{ __('cms.auth.enter_email') }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block btn-lg py-3">{{ __('cms.auth.continue') }}</button>
                    </form>

                    <p class="text-center text-muted mt-4 mb-0">{{ __('cms.auth.by_continuing') }}</p>
                    <p class="text-center text-muted mt-4 mb-0">{{ __('cms.auth.dont_have_account') }} <a href="{{ route('register') }}" class="text-decoration-none">{{ __('cms.auth.create_account') }}</a></p>
                </div>
                
            </div>
        </div>
    </div>
@endsection
