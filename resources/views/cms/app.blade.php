<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>Wethelink.com- Online Marketplace Company.</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="Find Trusted Manufacturers, Suppliers, Retailers, Wholesalers, Buyers, Importers, and Exporters Across Rwanda, East Africa & Africa. Discover verified businesses, factory-direct products, and new trade opportunities on Wethelink.com, Rwanda's trusted B2B marketplace.">
    <meta name="keywords" content="Trusted B2B Marketplace in Rwanda, Verified Suppliers Rwanda, Rwanda Wholesale Suppliers, Factory Price Products Rwanda, Direct Suppliers Rwanda, Rwanda Manufacturers Directory, Find Suppliers in Rwanda, Trusted B2B Marketplace, Wholesale Products Rwanda, Buy Wholesale in Rwanda, Munanira Elissa, Elissa Munanira, elissamunanira, elissa, munanira, Rwanda Retailers and Suppliers, Rwanda Factory Direct Products, Wholesale Prices Rwanda, Textile Suppliers Rwanda, Fabric Manufacturers Rwanda, Clothing Manufacturers Rwanda, Jeans Manufacturers Rwanda, Quality Denim Suppliers, Best B2B Platform Rwanda, Connect with Rwanda Manufacturers, Trusted B2B Marketplace East Africa, East Africa Wholesale Suppliers, Verified East Africa Businesses, Find Manufacturers in East Africa, B2B Trade Platform East Africa, Factory Price Products East Africa, Direct Suppliers East Africa, Trusted African B2B Marketplace, African Wholesale Network, Verified African Suppliers, African Manufacturers Directory, Gorilla Textile Jeans, Rwanda Jeans Manufacturer">
    <meta name="author" content="Wethelink">
    <meta name="color-scheme" content="light">

    <!-- Favicon -->
    {{-- <link href="{{ asset('cms/img/favicon.ico') }}" rel="icon"> --}}

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


    {{-- favicaon --}}

    <link rel="icon" type="image/png" href="{{ asset('favicon/favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('favicon/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}" />
    <meta name="apple-mobile-web-app-title" content="wethelink" />
    <link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}" />

    <style>
        .social-icon-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            margin: 0 0.2rem;
            border-radius: 50%;
            color: #0d6efd;
            background: rgba(13, 110, 253, 0.08);
            transition: all 0.2s ease-in-out;
        }

        .social-icon-link:hover {
            color: #ffffff;
            background: #0d6efd;
            text-decoration: none;
        }

        .social-icon-link i {
            font-size: 14px;
        }

        .navbar-vertical .dropdown-wrapper {
            position: relative;
        }

        .navbar-vertical .dropdown-wrapper .submenu {
            display: none;
            position: absolute;
            left: 100%;
            top: 0;
            min-width: 220px;
            background: #ffffff;
            border: 1px solid #dee2e6;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            z-index: 1060;
        }

        .navbar-vertical .dropdown-wrapper:hover>.submenu,
        .navbar-vertical .dropdown-wrapper:focus-within>.submenu {
            display: block;
        }

        .navbar-vertical .submenu .nav-link {
            padding-left: 1.25rem;
        }
    </style>

</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid cms-topbar">
        {{-- <div class="row bg-secondary py-2 px-xl-5">
            <div class="col-lg-6 d-none d-lg-block">
                <div class="d-inline-flex align-items-center">
                    <a class="text-dark" href="#">{{ __('cms.topbar.faqs') }}</a>
                    <span class="text-muted px-2">|</span>
                    <a class="text-dark" href="{{ route('help') }}">{{ __('cms.topbar.help') }}</a>
                    <span class="text-muted px-2">|</span>
                    <a class="text-dark" href="#">{{ __('cms.topbar.support') }}</a>
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
                    <a class="social-icon-link" href="https://www.facebook.com/share/1azXLevQkf/" target="_blank"
                        rel="noopener noreferrer" aria-label="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a class="social-icon-link" href="https://x.com/wethelink_com" target="_blank"
                        rel="noopener noreferrer" aria-label="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a class="social-icon-link" href="#" target="_blank" rel="noopener noreferrer"
                        aria-label="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a class="social-icon-link" href="https://www.instagram.com/wethelink_com?igsh=eTlyZHl3YmpmN21v"
                        target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a class="social-icon-link" href="#" target="_blank" rel="noopener noreferrer"
                        aria-label="YouTube">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a class="social-icon-link" href="https://www.tiktok.com/@wethelink_com?_r=1&_t=ZS-97j5RJE7ZnL"
                        target="_blank" rel="noopener noreferrer" aria-label="TikTok">
                        <i class="fab fa-tiktok"></i>
                    </a>
                </div>
            </div>
        </div> --}}
        <div class="row align-items-center py-3 px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a href="{{ route('home') }}" class="text-decoration-none d-inline-block">
                    <img src="{{ asset('cms/logo/Logo.png') }}" alt="We thelink logo" class="img-fluid"
                        style="max-height: 65px;" />
                </a>
            </div>
            <div class="col-lg-6 col-6 text-left">
                <form action="{{ route('shop') }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="{{ __('cms.search.placeholder') }}" value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button type="submit" class="input-group-text bg-transparent text-primary border-0">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            {{-- <div class="col-lg-3 col-6 text-right">
                <a href="#" class="btn border">
                    <i class="fas fa-heart text-primary"></i>
                    <span class="badge">0</span>
                </a>
                <a href="#" class="btn border">
                    <i class="fas fa-shopping-cart text-primary"></i>
                    <span class="badge">0</span>
                </a>
            </div> --}}
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <div class="container-fluid mb-5 cms-navbar">
        <div class="row border-top px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100"
                    data-toggle="collapse" href="#navbar-vertical"
                    style="height: 65px; margin-top: -1px; padding: 0 30px;">
                    <h6 class="m-0">{{ __('cms.categories') }}</h6>
                    <i class="fa fa-angle-down text-dark"></i>
                </a>
                <nav class="collapse {{ Route::is('home') ? 'show' : '' }} navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0 bg-light"
                    id="navbar-vertical"
                    style="{{ Route::is('home') ? '' : 'position: absolute; z-index: 1050; width: calc(100% - 30px);' }}">
                    <div class="navbar-nav w-100" style="max-height: 410px;">
                        @php
                            $topLevelCategories = $categories->whereNull('parent_id')->values();
                        @endphp

                        @foreach ($topLevelCategories as $category)
                            @php
                                $children = $category->children()->where('is_active', true)->orderBy('name')->get();
                            @endphp

                            <div class="dropdown-wrapper">
                                <a href="{{ route('shop', ['category' => $category->id]) }}"
                                    class="nav-item nav-link d-flex justify-content-between align-items-center">
                                    <span>{{ $category->name }}</span>
                                    @if ($children->isNotEmpty())
                                        <i class="fa fa-angle-right text-muted"></i>
                                    @endif
                                </a>

                                @if ($children->isNotEmpty())
                                    <div class="submenu">
                                        @foreach ($children as $child)
                                            <a href="{{ route('shop', ['category' => $child->id]) }}"
                                                class="nav-item nav-link">{{ $child->name }}</a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </nav>
            </div>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                    <a href="{{ route('home') }}" class="text-decoration-none d-block d-lg-none">
                        <img src="{{ asset('cms/logo/Logo.png') }}" alt="We thelink logo" class="img-fluid"
                            style="max-height: 42px;" />
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse"
                        data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="{{ route('home') }}"
                                class="nav-item nav-link {{ Route::is('home') ? 'active' : '' }}">{{ __('cms.nav.home') }}</a>
                            <a href="{{ route('shop') }}" class="nav-item nav-link {{ Route::is('shop') || Route::is('product.detail') ? 'active' : '' }}">{{ __('cms.nav.products') }}</a>
                            <a href="{{ route('manufacturers') }}"
                                class="nav-item nav-link {{ Route::is('manufacturers') ? 'active' : '' }}">{{ __('cms.nav.manufacturers') }}</a>
                            {{-- <a href="{{ route('detail') }}" class="nav-item nav-link">{{ __('cms.nav.detail') }}</a> --}}
                            {{-- <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle"
                                    data-toggle="dropdown">{{ __('cms.nav.pages') }}</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="{{ route('cart') }}" class="dropdown-item">{{ __('cms.nav.cart') }}</a>
                                    <a href="{{ route('checkout') }}"
                                        class="dropdown-item">{{ __('cms.nav.checkout') }}</a>
                                </div>
                            </div> --}}
                            <a href="{{ route('about') }}"
                                class="nav-item nav-link {{ Route::is('about') ? 'active' : '' }}">{{ __('cms.page.about') }}</a>
                            <a href="{{ route('contact') }}"
                                class="nav-item nav-link {{ Route::is('contact') ? 'active' : '' }}">{{ __('cms.nav.contact') }}</a>
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
                            @guest
                                <a href="{{ route('login') }}" class="nav-item nav-link">{{ __('cms.nav.login') }}</a>
                                <a href="{{ route('register') }}"
                                    class="nav-item nav-link">{{ __('cms.nav.register') }}</a>
                            @endguest
                            @auth
                                <div class="nav-item dropdown">
                                    <a href="#" class="nav-link dropdown-toggle"
                                        data-toggle="dropdown">{{ Auth::user()->firstname }}</a>
                                    <div class="dropdown-menu rounded-0 m-0">
                                        <a href="{{ route('dashboard.index') }}"
                                            class="dropdown-item">{{ __('dashboard.sidebar.dashboard') }}</a>
                                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                            @csrf
                                            <button type="submit"
                                                class="dropdown-item">{{ __('cms.auth.logout') }}</button>
                                        </form>
                                    </div>
                                </div>
                            @endauth
                        </div>
                    </div>
                </nav>
                @if (Route::is('home'))
                    <div id="header-carousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($heroSlides as $index => $slide)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}" style="height: 410px;">
                                    <img class="img-fluid"
                                        src="{{ asset($slide->image_path ?? 'cms/img/carousel-1.jpg') }}"
                                        alt="{{ $slide->title }}">
                                    <div
                                        class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                        <div class="p-3" style="max-width: 700px;">
                                            @if (!empty($slide->subtitle))
                                                <h4 class="text-light text-uppercase font-weight-medium mb-3">
                                                    {{ $slide->subtitle }}</h4>
                                            @endif
                                            <h3 class="display-4 text-white font-weight-semi-bold mb-4">
                                                {{ $slide->title }}</h3>
                                            @if (!empty($slide->button_text))
                                                <a href="{{ $slide->button_url ?? '/login' }}"
                                                    class="btn btn-light py-2 px-3">{{ $slide->button_text }}</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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
    <div class="container-fluid bg-secondary text-dark mt-5 pt-5 cms-footer">
        <div class="row px-xl-5 pt-5">
            <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
                <a href="{{ route('home') }}" class="text-decoration-none d-inline-block">
                    <img src="{{ asset('cms/logo/Logo.png') }}" alt="We thelink logo" class="img-fluid mb-4"
                        style="max-height: 65px;" />
                </a>
                {{-- <p>{{ __('cms.footer.about') }}</p> --}}
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>Kigali, Rwanda</p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>info@wethelink.com</p>
                <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>+250 784 360 366</p>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="row">
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">{{ __('cms.footer.quick_links') }}</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-dark mb-2" href="{{ route('home') }}"><i
                                    class="fa fa-angle-right mr-2"></i>{{ __('cms.nav.home') }}</a>
                            <a class="text-dark mb-2" href="{{ route('shop') }}"><i
                                    class="fa fa-angle-right mr-2"></i>{{ __('cms.nav.products') }}</a>
                            <a class="text-dark mb-2" href="{{ route('manufacturers') }}"><i
                                    class="fa fa-angle-right mr-2"></i>{{ __('cms.nav.manufacturers') }}</a>
                            <a class="text-dark mb-2" href="{{ route('about') }}"><i
                                    class="fa fa-angle-right mr-2"></i>{{ __('cms.page.about') }}</a>
                            <a class="text-dark" href="{{ route('contact') }}"><i
                                    class="fa fa-angle-right mr-2"></i>{{ __('cms.nav.contact') }}</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">{{ __('cms.footer.services') }}</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-dark mb-2" href="{{ route('shop') }}"><i
                                    class="fa fa-angle-right mr-2"></i>Quality Product</a>
                            <a class="text-dark mb-2" href="{{ route('shop') }}"><i
                                    class="fa fa-angle-right mr-2"></i>Free Shipping</a>
                            <a class="text-dark mb-2" href="{{ route('shop') }}"><i
                                    class="fa fa-angle-right mr-2"></i>7-Day Return</a>
                            <a class="text-dark" href="{{ route('contact') }}"><i
                                    class="fa fa-angle-right mr-2"></i>24/7 Support</a>
                            <a class="text-dark" href="{{ route('help') }}"><i
                                    class="fa fa-angle-right mr-2"></i>{{ __('cms.topbar.help') }}</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">{{ __('cms.footer.follow_us') }}</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-dark mb-2" href="https://www.facebook.com/share/1azXLevQkf/"
                                target="_blank" rel="noopener noreferrer"><i
                                    class="fab fa-facebook-f text-primary mr-3"></i>Facebook</a>
                            <a class="text-dark mb-2" href="https://x.com/wethelink_com" target="_blank"
                                rel="noopener noreferrer">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 512 512"
                                    fill="currentColor" class="text-primary mr-3" style="display:inline-block; vertical-align:middle;">
                                    <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/>
                                </svg>
                                X
                            </a>
                            <a class="text-dark mb-2" href="https://www.linkedin.com/in/wethelink-group-454884415/" target="_blank" rel="noopener noreferrer"><i class="fab fa-linkedin-in text-primary mr-3"></i>LinkedIn</a>
                            <a class="text-dark mb-2"
                                href="https://www.instagram.com/wethelink_com?igsh=eTlyZHl3YmpmN21v" target="_blank"
                                rel="noopener noreferrer"><i
                                    class="fab fa-instagram text-primary mr-3"></i>Instagram</a>
                            {{-- <a class="text-dark mb-2" href="#" target="_blank" rel="noopener noreferrer"><i class="fab fa-youtube text-primary mr-3"></i>YouTube</a> --}}
                            <a class="text-dark" href="https://www.tiktok.com/@wethelink_com?_r=1&_t=ZS-97j5RJE7ZnL"
                                target="_blank" rel="noopener noreferrer">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 448 512"
                                    fill="currentColor" class="text-primary mr-3" style="display:inline-block; vertical-align:middle;">
                                    <path d="M448,209.91a210.06,210.06,0,0,1-122.77-39.25V349.38A162.55,162.55,0,1,1,185,188.31V278.2a74.62,74.62,0,1,0,52.23,71.18V0l88,0a121.18,121.18,0,0,0,1.86,22.17h0A122.18,122.18,0,0,0,381,102.39a121.43,121.43,0,0,0,67,20.14Z"/>
                                </svg>
                                TikTok
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row border-top border-light mx-xl-5 py-4">
            <div class="col-md-12 px-xl-0">
                <center><p>&copy;  {{ date('Y') }} wethelink.com. All Rights Reserved. <a href="#">Privacy Policy</a></p></center>
                {{-- <p class="mb-md-0 text-center text-md-left text-dark">
                    &copy; <a class="text-dark font-weight-semi-bold" href="/">wethelink.com</a>.
                    {{ __('cms.footer.all_rights') }}.
                    {{ __('cms.footer.designed_by') }}
                    <a class="text-dark font-weight-semi-bold" href="https://elissamunanira.netrify.app/">EM</a>

                </p> --}}
            </div>
            {{-- <div class="col-md-6 px-xl-0 text-center text-md-right">--}}
                {{-- <img class="img-fluid" src="{{ asset('cms/img/payments.png') }}" alt=""> --}}
               {{-- {{ __('cms.footer.distributed_by') }} <a href="https://elissamunanira.netrify.app/"
                    target="_blank">EM
                </a>
            </div> --}}
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
    @stack('scripts')
</body>

</html>
