@extends('cms.app')
@section('title', 'Contact Wethelink – B2B Marketplace in Kigali, Rwanda')
@section('meta_description', 'Contact Wethelink in Kigali, Rwanda. Get help finding suppliers, listing your company or placing wholesale orders. Email info@wethelink.com or call +250 784 360 366.')

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">{{ __('cms.page.contact') }}</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="{{ route('home') }}">{{ __('cms.nav.home') }}</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">{{ __('cms.page.contact') }}</p>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Contact Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">{{ __('cms.contact.header') }}</span></h2>
        </div>
        <div class="row px-xl-5">
            <div class="col-lg-7 mb-5">
                <div class="contact-form">
                    <div id="success" class="alert alert-success" style="display:none;"></div>
                    <div id="error" class="alert alert-danger" style="display:none;"></div>
                    <form id="contactForm" novalidate="novalidate">
                        @csrf
                        <div class="control-group">
                            <input type="text" class="form-control" id="name" name="name" placeholder="{{ __('cms.contact.name') }}"
                                required="required" data-validation-required-message="Please enter your name" />
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="control-group">
                            <input type="email" class="form-control" id="email" name="email" placeholder="{{ __('cms.contact.email') }}"
                                required="required" data-validation-required-message="Please enter your email" />
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="control-group">
                            <input type="text" class="form-control" id="subject" name="subject" placeholder="{{ __('cms.contact.subject') }}"
                                required="required" data-validation-required-message="Please enter a subject" />
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="control-group">
                            <textarea class="form-control" rows="6" id="message" name="message" placeholder="{{ __('cms.contact.message') }}"
                                required="required"
                                data-validation-required-message="Please enter your message"></textarea>
                            <p class="help-block text-danger"></p>
                        </div>
                        <div>
                            <button class="btn btn-primary py-2 px-4" type="submit" id="sendMessageButton">{{ __('cms.contact.send_message') }}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-5 mb-5">
                <h5 class="font-weight-semi-bold mb-3">{{ __('cms.contact.get_in_touch') }}</h5>
                <p>{{ __('cms.contact.marketplace_description') }}</p>
                <div class="d-flex flex-column mb-3">
                    <h5 class="font-weight-semi-bold mb-3">Location</h5>
                    <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>Kigali, Rwanda</p>
                    <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>info@wethelink.com</p>
                    <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>+250 784 360 366</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->

    <script>
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const successDiv = document.getElementById('success');
            const errorDiv = document.getElementById('error');
            const sendButton = document.getElementById('sendMessageButton');

            // Hide previous messages
            successDiv.style.display = 'none';
            errorDiv.style.display = 'none';
            sendButton.disabled = true;
            sendButton.textContent = 'Sending...';

            fetch('{{ route("contact.store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    successDiv.textContent = data.message;
                    successDiv.style.display = 'block';
                    document.getElementById('contactForm').reset();
                } else {
                    errorDiv.textContent = data.message;
                    errorDiv.style.display = 'block';
                }
            })
            .catch(error => {
                errorDiv.textContent = 'An error occurred. Please try again.';
                errorDiv.style.display = 'block';
                console.error('Error:', error);
            })
            .finally(() => {
                sendButton.disabled = false;
                sendButton.textContent = '{{ __("cms.contact.send_message") }}';
            });
        });
    </script>
@endsection