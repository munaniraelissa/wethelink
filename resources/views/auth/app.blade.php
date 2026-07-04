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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('cms/css/style.css') }}" rel="stylesheet">
    <!-- Auth page stylesheet -->
    <link href="{{ asset('auth/css/auth.css') }}" rel="stylesheet">

    <link rel="icon" type="image/png" href="{{ asset('favicon/favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('favicon/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}" />
    <meta name="apple-mobile-web-app-title" content="wethelink" />
    <link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}" />

    <style>
        body {
            background: #f8f9fa;
        }

        .auth-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 0;
        }

        .auth-card {
            max-width: 540px;
            width: 100%;
            border: 0;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.08);
            border-radius: 1rem;
            overflow: hidden;
        }

        .auth-brand {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
        }

        .auth-brand img {
            height: 48px;
            width: auto;
        }
    </style>
</head>

<body>
    <div class="auth-topbar">
        <a href="{{ route('home') }}" class="auth-brand text-decoration-none text-dark">
            <img src="{{ asset('cms/logo/Logo.png') }}" alt="We thelink logo">
        </a>

        <div class="auth-locale dropdown">
            <button class="btn dropdown-toggle" type="button" id="authLocaleDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ __('cms.locale.label') }} ({{ strtoupper(app()->getLocale()) }})
            </button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="authLocaleDropdown">
                <a class="dropdown-item" href="{{ route('locale.switch', 'en') }}">{{ __('cms.locale.en') }}</a>
                <a class="dropdown-item" href="{{ route('locale.switch', 'rw') }}">{{ __('cms.locale.rw') }}</a>
            </div>
        </div>
    </div>

    <div class="auth-split">
        @yield('content')
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="/cms/lib/easing/easing.min.js"></script>
    <script src="/cms/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="{{ asset('cms/js/main.js') }}"></script>
    <script src="{{ asset('cms/js/auth.js') }}"></script>
    <script src="{{ asset('auth/js/auth.js') }}"></script>  

</body>

</html>
