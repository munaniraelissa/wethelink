<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>{{ __('cms.site_name') }}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="{{ asset('cms/img/favicon.ico') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('cms/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('cms/css/style.css') }}" rel="stylesheet">
    
</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row bg-secondary py-2 px-xl-5">
            <div class="col-lg-6 d-none d-lg-block">
                <div class="d-inline-flex align-items-center">
                    <a class="text-dark" href="#">{{ __('cms.topbar.faqs') }}</a>
                    <span class="text-muted px-2">|</span>
                    <a class="text-dark" href="#">{{ __('cms.topbar.help') }}</a>
                    <span class="text-muted px-2">|</span>
                    <a class="text-dark" href="#">{{ __('cms.topbar.support') }}</a>
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
                    <a class="text-dark px-2" href="#">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a class="text-dark px-2" href="#">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a class="text-dark px-2" href="#">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a class="text-dark px-2" href="#">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a class="text-dark pl-2" href="#">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="row align-items-center py-3 px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a href="{{ route('home') }}" class="text-decoration-none d-inline-block">
                    <img src="{{ asset('cms/logo/Logo.png') }}" alt="We thelink logo" class="img-fluid" style="max-height: 65px;" />
                </a>
            </div>
            <div class="col-lg-6 col-6 text-left">
                <form action="">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="{{ __('cms.search.placeholder') }}">
                        <div class="input-group-append">
                            <span class="input-group-text bg-transparent text-primary">
                                <i class="fa fa-search"></i>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 col-6 text-right">
                <a href="#" class="btn border">
                    <i class="fas fa-heart text-primary"></i>
                    <span class="badge">0</span>
                </a>
                <a href="#" class="btn border">
                    <i class="fas fa-shopping-cart text-primary"></i>
                    <span class="badge">0</span>
                </a>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <div class="container-fluid mb-5">
        <div class="row border-top px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100"
                    data-toggle="collapse" href="#navbar-vertical"
                    style="height: 65px; margin-top: -1px; padding: 0 30px;">
                    <h6 class="m-0">{{ __('cms.categories') }}</h6>
                    <i class="fa fa-angle-down text-dark"></i>
                </a>
                <nav class="collapse {{ Route::is('home') ? 'show' : '' }} navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0 bg-light"
                    id="navbar-vertical" style="{{ Route::is('home') ? '' : 'position: absolute; z-index: 1050; width: calc(100% - 30px);' }}">
                    <div class="navbar-nav w-100 overflow-hidden" style="height: 410px">
                        @foreach($categories as $category)
                            <a href="{{ route('shop', ['category' => $category->id]) }}" class="nav-item nav-link">{{ $category->name }}</a>
                        @endforeach
                    </div>
                </nav>
            </div>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                    <a href="{{ route('home') }}" class="text-decoration-none d-block d-lg-none">
                        <h1 class="m-0 display-5 font-weight-semi-bold"><span
                                class="text-primary font-weight-bold border px-3 mr-1">E</span>Shopper</h1>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse"
                        data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="{{ route('home') }}"
                                class="nav-item nav-link active">{{ __('cms.nav.home') }}</a>
                            <a href="{{ route('shop') }}" class="nav-item nav-link">{{ __('cms.nav.shop') }}</a>
                            <a href="{{ route('detail') }}" class="nav-item nav-link">{{ __('cms.nav.detail') }}</a>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle"
                                    data-toggle="dropdown">{{ __('cms.nav.pages') }}</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="{{ route('cart') }}" class="dropdown-item">{{ __('cms.nav.cart') }}</a>
                                    <a href="{{ route('checkout') }}"
                                        class="dropdown-item">{{ __('cms.nav.checkout') }}</a>
                                </div>
                            </div>
                            <a href="{{ route('contact') }}"
                                class="nav-item nav-link">{{ __('cms.nav.contact') }}</a>
                        </div>
                        <div class="navbar-nav ml-auto py-0">
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle"
                                    data-toggle="dropdown">{{ __('cms.locale.label') }}
                                    ({{ strtoupper(app()->getLocale()) }})</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="{{ route('locale.switch', 'en') }}"
                                        class="dropdown-item">{{ __('cms.locale.en') }}</a>
                                    <a href="{{ route('locale.switch', 'rw') }}"
                                        class="dropdown-item">{{ __('cms.locale.rw') }}</a>
                                </div>
                            </div>
                            <a href="{{ route('login') }}" class="nav-item nav-link">{{ __('cms.nav.login') }}</a>
                            <a href="{{ route('register') }}" class="nav-item nav-link">{{ __('cms.nav.register') }}</a>
                        </div>
                    </div>
                </nav>
                @if(Route::is('home'))
                <div id="header-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active" style="height: 410px;">
                            <img class="img-fluid" src="{{ asset('cms/img/carousel-1.jpg') }}" alt="Image">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h4 class="text-light text-uppercase font-weight-medium mb-3">
                                        {{ __('cms.hero.offer') }}</h4>
                                    <h3 class="display-4 text-white font-weight-semi-bold mb-4">
                                        {{ __('cms.hero.title_1') }}</h3>
                                    <a href="#"
                                        class="btn btn-light py-2 px-3">{{ __('cms.hero.shop_now') }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item" style="height: 410px;">
                            <img class="img-fluid" src="{{ asset('cms/img/carousel-2.jpg') }}" alt="Image">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h4 class="text-light text-uppercase font-weight-medium mb-3">
                                        {{ __('cms.hero.offer') }}</h4>
                                    <h3 class="display-4 text-white font-weight-semi-bold mb-4">
                                        {{ __('cms.hero.title_2') }}</h3>
                                    <a href="#"
                                        class="btn btn-light py-2 px-3">{{ __('cms.hero.shop_now') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
                        <div class="btn btn-dark" style="width: 45px; height: 45px;">
                            <span class="carousel-control-prev-icon mb-n2"></span>
                        </div>
                    </a>
                    <a class="carousel-control-next" href="#header-carousel" data-slide="next">
                        <div class="btn btn-dark" style="width: 45px; height: 45px;">
                            <span class="carousel-control-next-icon mb-n2"></span>
                        </div>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Navbar End -->

    @yield('content')



    <!-- Footer Start -->
    <div class="container-fluid bg-secondary text-dark mt-5 pt-5">
        <div class="row px-xl-5 pt-5">
            <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
                <a href="{{ route('home') }}" class="text-decoration-none d-inline-block">
                    <img src="{{ asset('cms/logo/Logo.png') }}" alt="We thelink logo" class="img-fluid mb-4" style="max-height: 65px;" />
                </a>
                <p>{{ __('cms.footer.about') }}</p>
                <p class="mb-2"><i
                        class="fa fa-map-marker-alt text-primary mr-3"></i>{{ __('cms.footer.address') }}</p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>{{ __('cms.footer.email') }}</p>
                <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>{{ __('cms.footer.phone') }}</p>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="row">
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">{{ __('cms.footer.quick_links') }}</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-dark mb-2" href="{{ route('home') }}"><i
                                    class="fa fa-angle-right mr-2"></i>{{ __('cms.nav.home') }}</a>
                            <a class="text-dark mb-2" href="{{ route('shop') }}"><i
                                    class="fa fa-angle-right mr-2"></i>{{ __('cms.page.shop') }}</a>
                            <a class="text-dark mb-2" href="{{ route('detail') }}"><i
                                    class="fa fa-angle-right mr-2"></i>{{ __('cms.page.detail') }}</a>
                            <a class="text-dark mb-2" href="{{ route('cart') }}"><i
                                    class="fa fa-angle-right mr-2"></i>{{ __('cms.nav.cart') }}</a>
                            <a class="text-dark mb-2" href="{{ route('checkout') }}"><i
                                    class="fa fa-angle-right mr-2"></i>{{ __('cms.nav.checkout') }}</a>
                            <a class="text-dark" href="{{ route('contact') }}"><i
                                    class="fa fa-angle-right mr-2"></i>{{ __('cms.nav.contact') }}</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">{{ __('cms.footer.quick_links') }}</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-dark mb-2" href="{{ route('home') }}"><i
                                    class="fa fa-angle-right mr-2"></i>{{ __('cms.nav.home') }}</a>
                            <a class="text-dark mb-2" href="{{ route('shop') }}"><i
                                    class="fa fa-angle-right mr-2"></i>{{ __('cms.page.shop') }}</a>
                            <a class="text-dark mb-2" href="{{ route('detail') }}"><i
                                    class="fa fa-angle-right mr-2"></i>{{ __('cms.page.detail') }}</a>
                            <a class="text-dark mb-2" href="{{ route('cart') }}"><i
                                    class="fa fa-angle-right mr-2"></i>{{ __('cms.nav.cart') }}</a>
                            <a class="text-dark mb-2" href="{{ route('checkout') }}"><i
                                    class="fa fa-angle-right mr-2"></i>{{ __('cms.nav.checkout') }}</a>
                            <a class="text-dark" href="{{ route('contact') }}"><i
                                    class="fa fa-angle-right mr-2"></i>{{ __('cms.nav.contact') }}</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">{{ __('cms.footer.newsletter') }}</h5>
                        <form action="">
                            <div class="form-group">
                                <input type="text" class="form-control border-0 py-4"
                                    placeholder="{{ __('cms.footer.name_placeholder') }}" required="required" />
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control border-0 py-4"
                                    placeholder="{{ __('cms.footer.email_placeholder') }}" required="required" />
                            </div>
                            <div>
                                <button class="btn btn-primary btn-block border-0 py-3"
                                    type="submit">{{ __('cms.footer.subscribe') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row border-top border-light mx-xl-5 py-4">
            <div class="col-md-6 px-xl-0">
                <p class="mb-md-0 text-center text-md-left text-dark">
                    &copy; <a class="text-dark font-weight-semi-bold"
                        href="#">{{ __('cms.footer.your_site_name') }}</a>. {{ __('cms.footer.all_rights') }}.
                    {{ __('cms.footer.designed_by') }}
                    <a class="text-dark font-weight-semi-bold" href="https://htmlcodex.com">HTML Codex</a><br>
                    {{ __('cms.footer.distributed_by') }} <a href="https://themewagon.com"
                        target="_blank">ThemeWagon</a>
                </p>
            </div>
            <div class="col-md-6 px-xl-0 text-center text-md-right">
                <img class="img-fluid" src="{{ asset('cms/img/payments.png') }}" alt="">
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="/cms/lib/easing/easing.min.js"></script>
    <script src="/cms/lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="{{ asset('cms/mail/jqBootstrapValidation.min.js') }}"></script>
    <script src="{{ asset('cms/mail/contact.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('cms/js/main.js') }}"></script>
</body>

</html>