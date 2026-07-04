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
                        {{-- <img src="{{ asset('cms/logo/Logo.png') }}" alt="We thelink logo" class="mb-3" style="height: 55px; width: auto;" /> --}}
                        <h3 class="font-weight-bold mb-1">{{ __('cms.auth.create_account') }}</h3>
                        <p class="text-muted mb-0">{{ __('cms.auth.by_continuing') }}</p>
                    </div>
{{-- 
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
                    </div> --}}

                    <div id="successAlert" class="alert alert-info alert-dismissible fade hide" role="alert" style="display: none;">
                        <strong>Info!</strong> <span id="successMessage"></span>
                    </div>

                    <div id="errorAlert" class="alert alert-danger alert-dismissible fade hide" role="alert" style="display: none;">
                        <strong>Error!</strong> <span id="errorMessage"></span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form id="signupForm">
                        <div class="form-group">
                            <label for="firstname" class="font-weight-bold">{{ __('cms.auth.first_name') }}</label>
                            <input type="text" id="firstname" name="firstname" class="form-control form-control-lg" placeholder="{{ __('cms.auth.first_name') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="lastname" class="font-weight-bold">{{ __('cms.auth.last_name') }}</label>
                            <input type="text" id="lastname" name="lastname" class="form-control form-control-lg" placeholder="{{ __('cms.auth.last_name') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="email" class="font-weight-bold">{{ __('cms.auth.email') }}</label>
                            <input type="email" id="email" name="email" class="form-control form-control-lg" placeholder="{{ __('cms.auth.email') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="telephone" class="font-weight-bold">{{ __('cms.auth.telephone') }}</label>
                            <input type="tel" id="telephone" name="telephone" class="form-control form-control-lg" placeholder="{{ __('cms.auth.telephone') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="password" class="font-weight-bold">{{ __('cms.auth.password') }}</label>
                            <input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="{{ __('cms.auth.password') }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block btn-lg py-3" id="submitBtn">{{ __('cms.auth.create_account_button') }}</button>
                    </form>

                    <p class="text-center text-muted mt-4 mb-0">{{ __('cms.auth.have_account') }} <a href="{{ route('login') }}" class="text-decoration-none">{{ __('cms.auth.sign_in') }}</a></p>
                    {{-- <div class="d-flex align-items-center mt-4 mb-0">
                        <div class="border-top flex-grow-1"></div>
                        <span class="px-3 text-muted" style="font-size: 0.875rem;">{{ __('cms.auth.or') }}</span>
                        <div class="border-top flex-grow-1"></div>
                    </div>
                    <p class="text-center text-muted mt-4 mb-0">{{ __('cms.auth.register_company_prompt') ?? 'Want to register your company?' }} <a href="{{ route('company.registration') }}" class="text-decoration-none font-weight-bold">{{ __('cms.auth.register_company') ?? 'Register Here' }}</a></p> --}}
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('signupForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const firstname = document.getElementById('firstname').value;
            const lastname = document.getElementById('lastname').value;
            const email = document.getElementById('email').value;
            const telephone = document.getElementById('telephone').value;
            const password = document.getElementById('password').value;
            const submitBtn = document.getElementById('submitBtn');
            const errorAlert = document.getElementById('errorAlert');
            const errorMessage = document.getElementById('errorMessage');
            const successAlert = document.getElementById('successAlert');
            const successMessage = document.getElementById('successMessage');

            submitBtn.disabled = true;
            submitBtn.textContent = '{{ __("cms.auth.creating_account") }}';
            errorAlert.style.display = 'none';
            successAlert.style.display = 'none';

            try {
                const response = await fetch('/api/register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        firstname,
                        lastname,
                        email,
                        telephone,
                        password,
                    })
                });

                const data = await response.json();

                if (!response.ok) {
                    const errors = data.errors || {};
                    let errorMsg = data.message || '{{ __("cms.auth.error_registration") }}';
                    if (Object.keys(errors).length > 0) {
                        errorMsg = Object.values(errors).flat().join(', ');
                    }
                    throw new Error(errorMsg);
                }

                if (data.requires_approval) {
                    successMessage.textContent = `${data.message} Please contact the admin on ${data.admin_phone || 'the provided contact number'} for assistance.`;
                    successAlert.style.display = 'block';
                    submitBtn.disabled = false;
                    submitBtn.textContent = '{{ __("cms.auth.create_account_button") }}';
                    e.currentTarget.reset();
                    return;
                }

                // Store token
                localStorage.setItem('auth_token', data.token);
                localStorage.setItem('user', JSON.stringify(data.user));

                // Redirect to dashboard
                window.location.href = '/main-dashboard';
            } catch (error) {
                errorMessage.textContent = error.message || '{{ __("cms.auth.error_occurred") }}';
                errorAlert.style.display = 'block';
                submitBtn.disabled = false;
                submitBtn.textContent = '{{ __("cms.auth.create_account_button") }}';
            }
        });
    </script>
@endsection
