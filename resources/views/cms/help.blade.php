@extends('cms.app')

@section('content')
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">{{ __('cms.page.help') }}</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="{{ route('home') }}">{{ __('cms.nav.home') }}</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">{{ __('cms.page.help') }}</p>
            </div>
        </div>
    </div>

    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <div class="col-lg-8 mb-5">
                <div class="mb-5">
                    <h2 class="section-title pr-5 mb-4"><span class="pr-2">{{ __('cms.help.title') }}</span></h2>
                    <p class="mb-0">{{ __('cms.help.intro') }}</p>
                </div>

                <div class="mb-5">
                    <h3 class="font-weight-semi-bold mb-4">{{ __('cms.help.faq_heading') }}</h3>
                    <div class="accordion" id="faqAccordion">
                        @php
                            $faqs = [
                                ['question' => __('cms.help.faq_1_question'), 'answer' => __('cms.help.faq_1_answer')],
                                ['question' => __('cms.help.faq_2_question'), 'answer' => __('cms.help.faq_2_answer')],
                                ['question' => __('cms.help.faq_3_question'), 'answer' => __('cms.help.faq_3_answer')],
                                ['question' => __('cms.help.faq_4_question'), 'answer' => __('cms.help.faq_4_answer')],
                                ['question' => __('cms.help.faq_5_question'), 'answer' => __('cms.help.faq_5_answer')],
                                ['question' => __('cms.help.faq_6_question'), 'answer' => __('cms.help.faq_6_answer')],
                            ];
                        @endphp
                        @foreach ($faqs as $index => $faq)
                            <div class="card border-0 mb-2">
                                <div class="card-header bg-light p-3" id="faqHeading{{ $index }}">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link text-left text-dark p-0" type="button" data-toggle="collapse" data-target="#faqCollapse{{ $index }}" aria-expanded="true" aria-controls="faqCollapse{{ $index }}">
                                            {{ $faq['question'] }}
                                        </button>
                                    </h5>
                                </div>
                                <div id="faqCollapse{{ $index }}" class="collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="faqHeading{{ $index }}" data-parent="#faqAccordion">
                                    <div class="card-body">
                                        {{ $faq['answer'] }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mb-5">
                    <h3 class="font-weight-semi-bold mb-4">{{ __('cms.help.terms_heading') }}</h3>
                    <div class="row">
                        @php
                            $terms = [
                                ['title' => __('cms.help.term_b2b_title'), 'desc' => __('cms.help.term_b2b_desc')],
                                ['title' => __('cms.help.term_sme_title'), 'desc' => __('cms.help.term_sme_desc')],
                                ['title' => __('cms.help.term_moq_title'), 'desc' => __('cms.help.term_moq_desc')],
                                ['title' => __('cms.help.term_rfq_title'), 'desc' => __('cms.help.term_rfq_desc')],
                                ['title' => __('cms.help.term_oem_title'), 'desc' => __('cms.help.term_oem_desc')],
                                ['title' => __('cms.help.term_odm_title'), 'desc' => __('cms.help.term_odm_desc')],
                                ['title' => __('cms.help.term_wholesale_title'), 'desc' => __('cms.help.term_wholesale_desc')],
                                ['title' => __('cms.help.term_retail_title'), 'desc' => __('cms.help.term_retail_desc')],
                                ['title' => __('cms.help.term_manufacturer_title'), 'desc' => __('cms.help.term_manufacturer_desc')],
                                ['title' => __('cms.help.term_supplier_title'), 'desc' => __('cms.help.term_supplier_desc')],
                                ['title' => __('cms.help.term_distributor_title'), 'desc' => __('cms.help.term_distributor_desc')],
                                ['title' => __('cms.help.term_sku_title'), 'desc' => __('cms.help.term_sku_desc')],
                                ['title' => __('cms.help.term_lead_time_title'), 'desc' => __('cms.help.term_lead_time_desc')],
                                ['title' => __('cms.help.term_catalog_title'), 'desc' => __('cms.help.term_catalog_desc')],
                                ['title' => __('cms.help.term_verified_supplier_title'), 'desc' => __('cms.help.term_verified_supplier_desc')],
                                ['title' => __('cms.help.term_inquiry_title'), 'desc' => __('cms.help.term_inquiry_desc')],
                                ['title' => __('cms.help.term_bulk_order_title'), 'desc' => __('cms.help.term_bulk_order_desc')],
                                ['title' => __('cms.help.term_made_in_rwanda_title'), 'desc' => __('cms.help.term_made_in_rwanda_desc')],
                                ['title' => __('cms.help.term_buyer_title'), 'desc' => __('cms.help.term_buyer_desc')],
                                ['title' => __('cms.help.term_seller_title'), 'desc' => __('cms.help.term_seller_desc')],
                            ];
                        @endphp
                        @foreach ($terms as $term)
                            <div class="col-md-6 mb-4">
                                <div class="border rounded p-3 h-100">
                                    <h6 class="font-weight-semi-bold mb-2">{{ $term['title'] }}</h6>
                                    <p class="mb-0">{{ $term['desc'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <img src="{{ asset('cms/img/vendor-3.jpg') }}" class="card-img-top" alt="Help center" style="height: 220px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="font-weight-semi-bold mb-3">{{ __('cms.help.support_title') }}</h5>
                        <p class="mb-3">{{ __('cms.help.support_text') }}</p>
                        <a href="{{ route('contact') }}" class="btn btn-primary">{{ __('cms.help.support_button') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
