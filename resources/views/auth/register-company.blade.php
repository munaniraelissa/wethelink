@extends('auth.app')

@section('content')
    <div class="container-fluid pb-5" style="min-height: calc(100vh - 120px);">
        <div class="row no-gutters align-items-stretch">
            <div class="col-lg-7 d-none d-lg-flex">
                <div class="h-100 w-100 d-flex flex-column justify-content-center text-white px-5"
                    style="background: linear-gradient(135deg, #ff8a00 0%, #ffc45f 100%);">
                    <h1 class="display-4 font-weight-bold mb-3">
                        {{ __('cms.auth.register_company_title') ?? 'Register Your Company' }}</h1>
                    <p class="lead mb-4" style="max-width: 520px;">
                        {{ __('cms.auth.register_company_subtitle') ?? 'Join thousands of businesses using our platform to grow their network.' }}
                    </p>
                    <div class="d-flex flex-wrap">
                        <div class="mr-4 mb-3">
                            <h5 class="font-weight-bold mb-2">{{ __('cms.auth.feature_easy_setup') ?? 'Easy Setup' }}</h5>
                            <p class="mb-0">
                                {{ __('cms.auth.feature_easy_setup_desc') ?? 'Get your company up and running in minutes.' }}
                            </p>
                        </div>
                        <div class="mb-3">
                            <h5 class="font-weight-bold mb-2">
                                {{ __('cms.auth.feature_instant_access') ?? 'Instant Access' }}</h5>
                            <p class="mb-0">
                                {{ __('cms.auth.feature_instant_access_desc') ?? 'Start managing your business immediately after registration.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 bg-white d-flex align-items-center">
                <div class="w-100 p-4 p-md-5">
                    <div class="text-center mb-4">
                        <h3 class="font-weight-bold mb-1">{{ __('cms.auth.register_company') ?? 'Register Company' }}</h3>
                        <p class="text-muted mb-0">
                            {{ __('cms.auth.register_company_desc') ?? 'Fill in your company details below' }}</p>
                    </div>

                    <!-- Progress Indicator -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <small class="font-weight-bold">
                                {{ __('cms.auth.step') ?? 'Step' }} <span id="currentStep">1</span>
                                {{ __('cms.auth.of') ?? 'of' }} 3
                            </small>
                            <small id="stepLabel" class="text-muted">Company Details</small>
                        </div>
                        <div class="progress" style="height: 4px;">
                            <div id="progressBar" class="progress-bar bg-primary" role="progressbar" style="width: 33%"
                                aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <div id="errorAlert" class="alert alert-danger alert-dismissible fade hide" role="alert"
                        style="display: none;">
                        <strong>Error!</strong> <span id="errorMessage"></span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div id="successAlert" class="alert alert-success alert-dismissible fade hide" role="alert"
                        style="display: none;">
                        <strong>Success!</strong> <span id="successMessage"></span>
                    </div>

                    <form id="companyRegistrationForm">
                        <!-- Step 1: Company Details -->
                        <div id="step1" class="form-step">
                            <div class="form-group">
                                <label for="company_name"
                                    class="font-weight-bold">{{ __('cms.auth.company_name') ?? 'Company Name' }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="company_name" name="company_name"
                                    class="form-control form-control-lg"
                                    placeholder="{{ __('cms.auth.company_name_placeholder') ?? 'Your Company Name' }}"
                                    required>
                                <small class="text-muted">Your official company name</small>
                            </div>
                            <div class="form-group">
                                <label for="company_email"
                                    class="font-weight-bold">{{ __('cms.auth.company_email') ?? 'Company Email' }}</label>
                                <input type="email" id="company_email" name="company_email"
                                    class="form-control form-control-lg"
                                    placeholder="{{ __('cms.auth.email') ?? 'company@example.com' }}">
                                <small class="text-muted">General company email address</small>
                            </div>
                            <div class="form-group">
                                <label for="company_telephone"
                                    class="font-weight-bold">{{ __('cms.auth.company_telephone') ?? 'Company Telephone' }}</label>
                                <input type="tel" id="company_telephone" name="company_telephone"
                                    class="form-control form-control-lg"
                                    placeholder="{{ __('cms.auth.telephone') ?? '+1 (555) 000-0000' }}">
                                <small class="text-muted">Main company phone number</small>
                            </div>
                            <div class="form-group">
                                <label for="company_website"
                                    class="font-weight-bold">{{ __('cms.auth.company_website') ?? 'Website' }}</label>
                                <input type="url" id="company_website" name="company_website"
                                    class="form-control form-control-lg" placeholder="https://example.com">
                                <small class="text-muted">Your company website</small>
                            </div>
                            <div class="form-group">
                                <label for="company_industry"
                                    class="font-weight-bold">{{ __('cms.auth.industry') ?? 'Industry' }}</label>
                                <select id="company_industry" name="company_industry" class="form-control form-control-lg">
                                    <option value="">{{ __('cms.auth.select_industry') ?? 'Select Industry' }}
                                    </option>
                                    <option value="technology">{{ __('cms.auth.industry_technology') ?? 'Technology' }}
                                    </option>
                                    <option value="retail">{{ __('cms.auth.industry_retail') ?? 'Retail' }}</option>
                                    <option value="wholesale">{{ __('cms.auth.industry_wholesale') ?? 'Wholesale' }}
                                    </option>
                                    <option value="manufacturing">
                                        {{ __('cms.auth.industry_manufacturing') ?? 'Manufacturing' }}</option>
                                    <option value="services">{{ __('cms.auth.industry_services') ?? 'Services' }}</option>
                                    <option value="other">{{ __('cms.auth.industry_other') ?? 'Other' }}</option>
                                </select>
                                <small class="text-muted">Type of business</small>
                            </div>
                            <div class="form-group">
                                <label for="company_tax_number"
                                    class="font-weight-bold">{{ __('cms.auth.tax_number') ?? 'Tax Number' }}</label>
                                <input type="text" id="company_tax_number" name="company_tax_number"
                                    class="form-control form-control-lg"
                                    placeholder="{{ __('cms.auth.tax_number_placeholder') ?? 'Tax ID / VAT Number' }}">
                                <small class="text-muted">Tax identification number</small>
                            </div>
                            <div class="form-group">
                                <label for="company_registration_number"
                                    class="font-weight-bold">{{ __('cms.auth.registration_number') ?? 'Registration Number' }}</label>
                                <input type="text" id="company_registration_number" name="company_registration_number"
                                    class="form-control form-control-lg"
                                    placeholder="{{ __('cms.auth.registration_number_placeholder') ?? 'Business Registration Number' }}">
                                <small class="text-muted">Business registration number</small>
                            </div>
                        </div>

                        <!-- Step 2: Location Details -->
                        <div id="step2" class="form-step" style="display: none;">
                            <div class="form-group">
                                <label for="location_name"
                                    class="font-weight-bold">{{ __('cms.auth.location_name') ?? 'Location Name' }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="location_name" name="location_name"
                                    class="form-control form-control-lg"
                                    placeholder="{{ __('cms.auth.location_name_placeholder') ?? 'Head Office' }}"
                                    required>
                                <small class="text-muted">Name of this location/branch</small>
                            </div>
                            <div class="form-group">
                                <label for="location_address"
                                    class="font-weight-bold">{{ __('cms.auth.address') ?? 'Address' }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="location_address" name="location_address"
                                    class="form-control form-control-lg"
                                    placeholder="{{ __('cms.auth.address_placeholder') ?? '123 Main Street' }}" required>
                                <small class="text-muted">Street address</small>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="location_city"
                                        class="font-weight-bold">{{ __('cms.auth.city') ?? 'City' }}</label>
                                    <input type="text" id="location_city" name="location_city"
                                        class="form-control form-control-lg"
                                        placeholder="{{ __('cms.auth.city_placeholder') ?? 'City' }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="location_district"
                                        class="font-weight-bold">{{ __('cms.auth.district') ?? 'District' }}</label>
                                    <input type="text" id="location_district" name="location_district"
                                        class="form-control form-control-lg"
                                        placeholder="{{ __('cms.auth.district_placeholder') ?? 'District' }}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="location_province"
                                        class="font-weight-bold">{{ __('cms.auth.province') ?? 'Province' }}</label>
                                    <input type="text" id="location_province" name="location_province"
                                        class="form-control form-control-lg"
                                        placeholder="{{ __('cms.auth.province_placeholder') ?? 'Province' }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="location_country"
                                        class="font-weight-bold">{{ __('cms.auth.country') ?? 'Country' }}</label>
                                    <input type="text" id="location_country" name="location_country"
                                        class="form-control form-control-lg"
                                        placeholder="{{ __('cms.auth.country_placeholder') ?? 'Country' }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="location_email"
                                    class="font-weight-bold">{{ __('cms.auth.location_email') ?? 'Location Email' }}</label>
                                <input type="email" id="location_email" name="location_email"
                                    class="form-control form-control-lg"
                                    placeholder="{{ __('cms.auth.email') ?? 'location@example.com' }}">
                            </div>
                            <div class="form-group">
                                <label for="location_telephone"
                                    class="font-weight-bold">{{ __('cms.auth.location_telephone') ?? 'Location Telephone' }}</label>
                                <input type="tel" id="location_telephone" name="location_telephone"
                                    class="form-control form-control-lg"
                                    placeholder="{{ __('cms.auth.telephone') ?? '+1 (555) 000-0000' }}">
                            </div>
                            <div class="form-group">
                                <label for="location_manager_name"
                                    class="font-weight-bold">{{ __('cms.auth.manager_name') ?? 'Location Manager Name' }}</label>
                                <input type="text" id="location_manager_name" name="location_manager_name"
                                    class="form-control form-control-lg"
                                    placeholder="{{ __('cms.auth.manager_name_placeholder') ?? 'Manager Name' }}">
                            </div>
                        </div>

                        <!-- Step 3: Admin User Details -->
                        <div id="step3" class="form-step" style="display: none;">
                            <h5 class="mb-3 font-weight-bold">
                                {{ __('cms.auth.admin_account') ?? 'Admin Account Details' }}</h5>
                            <p class="text-muted mb-4">
                                {{ __('cms.auth.admin_account_desc') ?? 'This account will be your primary admin account for managing the company.' }}
                            </p>

                            <div class="form-group">
                                <label for="firstname"
                                    class="font-weight-bold">{{ __('cms.auth.first_name') ?? 'First Name' }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="firstname" name="firstname"
                                    class="form-control form-control-lg"
                                    placeholder="{{ __('cms.auth.first_name') ?? 'John' }}" required>
                            </div>
                            <div class="form-group">
                                <label for="lastname"
                                    class="font-weight-bold">{{ __('cms.auth.last_name') ?? 'Last Name' }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="lastname" name="lastname"
                                    class="form-control form-control-lg"
                                    placeholder="{{ __('cms.auth.last_name') ?? 'Doe' }}" required>
                            </div>
                            <div class="form-group">
                                <label for="email" class="font-weight-bold">{{ __('cms.auth.email') ?? 'Email' }}
                                    <span class="text-danger">*</span></label>
                                <input type="email" id="email" name="email" class="form-control form-control-lg"
                                    placeholder="{{ __('cms.auth.email_placeholder') ?? 'admin@example.com' }}" required>
                                <small class="text-muted">Used for login and communications</small>
                            </div>
                            <div class="form-group">
                                <label for="telephone"
                                    class="font-weight-bold">{{ __('cms.auth.telephone') ?? 'Telephone' }} <span
                                        class="text-danger">*</span></label>
                                <input type="tel" id="telephone" name="telephone"
                                    class="form-control form-control-lg"
                                    placeholder="{{ __('cms.auth.telephone_placeholder') ?? '+1 (555) 000-0000' }}"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="password"
                                    class="font-weight-bold">{{ __('cms.auth.password') ?? 'Password' }} <span
                                        class="text-danger">*</span></label>
                                <input type="password" id="password" name="password"
                                    class="form-control form-control-lg"
                                    placeholder="{{ __('cms.auth.password_placeholder') ?? 'At least 6 characters' }}"
                                    required minlength="6">
                                <small
                                    class="text-muted">{{ __('cms.auth.password_requirements') ?? 'Must be at least 6 characters' }}</small>
                            </div>
                            <div class="form-group">
                                <label for="password_confirm"
                                    class="font-weight-bold">{{ __('cms.auth.confirm_password') ?? 'Confirm Password' }}
                                    <span class="text-danger">*</span></label>
                                <input type="password" id="password_confirm" name="password_confirm"
                                    class="form-control form-control-lg"
                                    placeholder="{{ __('cms.auth.confirm_password_placeholder') ?? 'Confirm your password' }}"
                                    required minlength="6">
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="agreeTerms"
                                        name="agreeTerms" required>
                                    <label class="custom-control-label" for="agreeTerms">
                                        {{ __('cms.auth.agree_terms') ?? 'I agree to the terms and conditions' }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="d-flex gap-2 mt-4">
                            <button type="button" id="prevBtn" class="btn btn-outline-secondary btn-lg flex-grow-1"
                                style="display: none;">
                                {{ __('cms.auth.back') ?? 'Back' }}
                            </button>
                            <button type="button" id="nextBtn" class="btn btn-primary btn-lg flex-grow-1">
                                {{ __('cms.auth.next') ?? 'Next' }}
                            </button>
                            <button type="submit" id="submitBtn" class="btn btn-success btn-lg flex-grow-1"
                                style="display: none;">
                                {{ __('cms.auth.register_company') ?? 'Register Company' }}
                            </button>
                        </div>
                    </form>

                    <p class="text-center text-muted mt-4 mb-0">
                        {{ __('cms.auth.already_have_account') ?? 'Already have an account?' }}
                        <a href="{{ route('login') }}"
                            class="text-decoration-none">{{ __('cms.auth.sign_in') ?? 'Sign In' }}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <style>
        .form-step {
            animation: fadeIn 0.3s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .gap-2 {
            gap: 0.5rem;
        }

        .btn:disabled {
            cursor: not-allowed;
            opacity: 0.6;
        }
    </style>

    <script>
        const form = document.getElementById('companyRegistrationForm');
        const nextBtn = document.getElementById('nextBtn');
        const prevBtn = document.getElementById('prevBtn');
        const submitBtn = document.getElementById('submitBtn');
        const errorAlert = document.getElementById('errorAlert');
        const errorMessage = document.getElementById('errorMessage');
        const successAlert = document.getElementById('successAlert');
        const successMessage = document.getElementById('successMessage');
        const progressBar = document.getElementById('progressBar');
        const currentStepSpan = document.getElementById('currentStep');
        const stepLabel = document.getElementById('stepLabel');

        let currentStep = 1;
        const totalSteps = 3;

        const stepLabels = {
            1: '{{ __('cms.auth.company_details') ?? 'Company Details' }}',
            2: '{{ __('cms.auth.location_details') ?? 'Location Details' }}',
            3: '{{ __('cms.auth.admin_details') ?? 'Admin Details' }}'
        };

        function updateStep() {
            currentStepSpan.textContent = currentStep;
            stepLabel.textContent = stepLabels[currentStep];

            for (let i = 1; i <= totalSteps; i++) {
                const stepElement = document.getElementById(`step${i}`);
                stepElement.style.display = i === currentStep ? 'block' : 'none';
            }

            prevBtn.style.display = currentStep > 1 ? 'inline-block' : 'none';
            nextBtn.style.display = currentStep < totalSteps ? 'inline-block' : 'none';
            submitBtn.style.display = currentStep === totalSteps ? 'inline-block' : 'none';

            const progressWidth = (currentStep / totalSteps) * 100;
            progressBar.style.width = progressWidth + '%';
            progressBar.setAttribute('aria-valuenow', progressWidth);

            errorAlert.style.display = 'none';
        }

        function validateStep(step) {
            const inputs = document.querySelectorAll(`#step${step} input[required], #step${step} select[required]`);
            let isValid = true;

            inputs.forEach(input => {
                if (!input.value.trim()) {
                    input.classList.add('is-invalid');
                    isValid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            // Special validation for step 3
            if (step === 3) {
                const password = document.getElementById('password').value;
                const passwordConfirm = document.getElementById('password_confirm').value;

                if (password !== passwordConfirm) {
                    errorMessage.textContent = '{{ __('cms.auth.passwords_do_not_match') ?? 'Passwords do not match' }}';
                    errorAlert.style.display = 'block';
                    isValid = false;
                }

                if (!document.getElementById('agreeTerms').checked) {
                    errorMessage.textContent =
                        '{{ __('cms.auth.must_agree_terms') ?? 'You must agree to the terms and conditions' }}';
                    errorAlert.style.display = 'block';
                    isValid = false;
                }
            }

            return isValid;
        }

        nextBtn.addEventListener('click', () => {
            if (validateStep(currentStep)) {
                if (currentStep < totalSteps) {
                    currentStep++;
                    updateStep();
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }
            }
        });

        prevBtn.addEventListener('click', () => {
            if (currentStep > 1) {
                currentStep--;
                updateStep();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }
        });

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            if (!validateStep(currentStep)) {
                return;
            }

            const formData = new FormData(form);
            const data = {
                company_name: formData.get('company_name'),
                company_email: formData.get('company_email'),
                company_telephone: formData.get('company_telephone'),
                company_website: formData.get('company_website'),
                company_industry: formData.get('company_industry'),
                company_tax_number: formData.get('company_tax_number'),
                company_registration_number: formData.get('company_registration_number'),
                location_name: formData.get('location_name'),
                location_address: formData.get('location_address'),
                location_city: formData.get('location_city'),
                location_district: formData.get('location_district'),
                location_province: formData.get('location_province'),
                location_country: formData.get('location_country'),
                location_email: formData.get('location_email'),
                location_telephone: formData.get('location_telephone'),
                location_manager_name: formData.get('location_manager_name'),
                firstname: formData.get('firstname'),
                lastname: formData.get('lastname'),
                email: formData.get('email'),
                telephone: formData.get('telephone'),
                password: formData.get('password'),
            };

            submitBtn.disabled = true;
            submitBtn.innerHTML =
                '<span class="spinner-border spinner-border-sm mr-2"></span>{{ __('cms.auth.registering') ?? 'Registering...' }}';
            errorAlert.style.display = 'none';

            try {
                const response = await fetch('/api/register-company', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(data)
                });

                const responseData = await response.json();

                if (!response.ok) {
                    const errors = responseData.errors || {};
                    let errorMsg = responseData.message ||
                        '{{ __('cms.auth.error_registration') ?? 'Registration failed' }}';
                    if (Object.keys(errors).length > 0) {
                        errorMsg = Object.values(errors).flat().join(', ');
                    }
                    throw new Error(errorMsg);
                }

                // Store token and user data
                localStorage.setItem('auth_token', responseData.token);
                localStorage.setItem('user', JSON.stringify(responseData.user));
                localStorage.setItem('company', JSON.stringify(responseData.company));

                successMessage.textContent =
                    '{{ __('cms.auth.company_registered_success') ?? 'Company registered successfully! Redirecting...' }}';
                successAlert.style.display = 'block';

                // Redirect after 2 seconds
                setTimeout(() => {
                    window.location.href = '/main-dashboard';
                }, 2000);
            } catch (error) {
                errorMessage.textContent = error.message ||
                    '{{ __('cms.auth.error_occurred') ?? 'An error occurred' }}';
                errorAlert.style.display = 'block';
                submitBtn.disabled = false;
                submitBtn.innerHTML = '{{ __('cms.auth.register_company') ?? 'Register Company' }}';
            }
        });

        // Initialize
        updateStep();

        // Add input event listeners to remove error styling
        document.querySelectorAll('input, select').forEach(input => {
            input.addEventListener('input', () => {
                input.classList.remove('is-invalid');
            });
        });
    </script>
@endsection
