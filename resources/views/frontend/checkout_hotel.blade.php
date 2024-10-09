@extends('frontend.layouts.app')

@section('content')

    <section class="my-4 gry-bg">
        <div class="container">
            <div class="row cols-xs-space cols-sm-space cols-md-space">
                <div class="col-xxl-8 col-xl-10 mx-auto">
                    <form class="form-default" data-toggle="validator" action="{{ route('payment.checkoutBooking') }}" role="form"
                        method="POST" id="checkout-form">
                        @csrf

                        <div class="accordion" id="accordioncCheckoutInfo">

                            <!-- Payment Info -->
                            <div class="card rounded-0 mb-0 border shadow-none">
                                <div class="card-header border-bottom-0 py-3 py-xl-4" id="headingPaymentInfo" type="button"
                                    data-toggle="collapse" data-target="#collapsePaymentInfo" aria-expanded="true"
                                    aria-controls="collapsePaymentInfo">
                                    <div class="d-flex align-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 20 20">
                                            <path id="Path_42357" data-name="Path 42357"
                                                d="M58,48A10,10,0,1,0,68,58,10,10,0,0,0,58,48ZM56.457,61.543a.663.663,0,0,1-.423.212.693.693,0,0,1-.428-.216l-2.692-2.692.856-.856,2.269,2.269,6-6.043.841.87Z"
                                                transform="translate(-48 -48)" fill="#9d9da6" />
                                        </svg>
                                        <span class="ml-2 fs-19 fw-700">{{ translate('Payment') }}</span>
                                    </div>
                                    <i class="las la-angle-down fs-18"></i>
                                </div>
                                <div id="collapsePaymentInfo" class="collapse show" aria-labelledby="headingPaymentInfo"
                                    data-parent="#accordioncCheckoutInfo">
                                    <div class="card-body" id="payment_info">
                                        <div class="mb-4">
                                            <p class="mr-5 pb-2 fs-16 fw-700 text-reset">Total price : {{single_price($total)}}</p>
                                            <h3 class="fs-16 fw-700 text-dark">
                                                {{ translate('Any additional info?') }}
                                            </h3>
                                            <textarea name="additional_info" rows="5" class="form-control rounded-0"
                                                placeholder="{{ translate('Type your text...') }}"></textarea>
                                        </div>
                                        <div>
                                            <h3 class="fs-16 fw-700 text-dark">
                                                {{ translate('Select a payment option') }}
                                            </h3>
                                            <div class="row gutters-10">
                                                @foreach (get_activate_payment_methods() as $payment_method)
                                                    <div class="col-xl-4 col-md-6">
                                                        <label class="aiz-megabox d-block mb-3">
                                                            <input value="{{ $payment_method->name }}" class="online_payment" type="radio"
                                                                name="payment_option" checked>
                                                            <span class="d-flex align-items-center justify-content-between aiz-megabox-elem rounded-0 p-3">
                                                                <span class="d-block fw-400 fs-14">{{ ucfirst(translate($payment_method->name)) }}</span>
                                                                <span class="rounded-1 h-40px overflow-hidden">
                                                                    <img src="{{ static_asset('assets/img/cards/'.$payment_method->name.'.png') }}"
                                                                    class="img-fit h-70">
                                                                </span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                @endforeach

                                            </div>

                                            <!-- Wallet Payment -->
                                            @if (Auth::check() && get_setting('wallet_system') == 1)
                                                <div class="py-4 px-4 text-center bg-soft-secondary-base mt-4">
                                                    <div class="fs-14 mb-3">
                                                        <span class="opacity-80">{{ translate('Or, Your wallet balance :') }}</span>
                                                        <span class="fw-700">{{ single_price(Auth::user()->balance) }}</span>
                                                    </div>
                                                    @if (Auth::user()->balance < $total)
                                                        <button type="button" class="btn btn-secondary" disabled>
                                                            {{ translate('Insufficient balance') }}
                                                        </button>
                                                    @else
                                                        <button type="button" onclick="use_wallet()"
                                                            class="btn btn-primary fs-14 fw-700 px-5 rounded-0">
                                                            {{ translate('Pay with wallet') }}
                                                        </button>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Agree Box -->
                                        <div class="pt-2rem fs-14">
                                            <label class="aiz-checkbox">
                                                <input type="checkbox" required id="agree_checkbox"
                                                    onchange="stepCompletionPaymentInfo()">
                                                <span class="aiz-square-check"></span>
                                                <span>{{ translate('I agree to the') }}</span>
                                            </label>
                                            <a href="{{ route('terms') }}"
                                                class="fw-700">{{ translate('terms and conditions') }}</a>,
                                            <a href="{{ route('returnpolicy') }}"
                                                class="fw-700">{{ translate('return policy') }}</a> &
                                            <a href="{{ route('privacypolicy') }}"
                                                class="fw-700">{{ translate('privacy policy') }}</a>
                                        </div>
                                        <input type="hidden" name="amount" value="{{ $total }}">
                                        <div class="row align-items-center pt-3 mb-4">
                                            <!-- Return to shop -->
                                            <div class="col-6">
                                                <a href="{{ route('home') }}" class="btn btn-link fs-14 fw-700 px-0">
                                                    <i class="las la-arrow-left fs-16"></i>
                                                    {{ translate('Return to shop') }}
                                                </a>
                                            </div>
                                            <!-- Complete Ordert -->
                                            <div class="col-6 text-right">
                                                <button type="button" onclick="submitOrder(this)" id="submitOrderBtn"
                                                    class="btn btn-primary fs-14 fw-700 rounded-0 px-4">{{ translate('Complete Order') }}</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>
@endsection

@section('modal')
    <!-- Address Modal -->
    @if (Auth::check())
        @include('frontend.partials.address.address_modal')
    @endif
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $(".online_payment").click(function() {
                $('#manual_payment_description').parent().addClass('d-none');
            });
            toggleManualPaymentData($('input[name=payment_option]:checked').data('id'));
        });

        var minimum_order_amount_check = {{ get_setting('minimum_order_amount_check') == 1 ? 1 : 0 }};
        var minimum_order_amount =
            {{ get_setting('minimum_order_amount_check') == 1 ? get_setting('minimum_order_amount') : 0 }};

        function use_wallet() {
            $('input[name=payment_option]').val('wallet');
            if ($('#agree_checkbox').is(":checked")) {
                ;
                if (minimum_order_amount_check && $('#sub_total').val() < minimum_order_amount) {
                    AIZ.plugins.notify('danger',
                        '{{ translate('You order amount is less then the minimum order amount') }}');
                } else {
                    $('#checkout-form').submit();
                }
            } else {
                AIZ.plugins.notify('danger', '{{ translate('You need to agree with our policies') }}');
            }
        }

        function submitOrder(el) {
            $(el).prop('disabled', true);
            if ($('#agree_checkbox').is(":checked")) {
                if (minimum_order_amount_check && $('#sub_total').val() < minimum_order_amount) {
                    AIZ.plugins.notify('danger',
                        '{{ translate('You order amount is less then the minimum order amount') }}');
                } else {
                    var offline_payment_active = '{{ addon_is_activated('offline_payment') }}';
                    if (offline_payment_active == '1' && $('.offline_payment_option').is(":checked") && $('#trx_id')
                        .val() == '') {
                        AIZ.plugins.notify('danger', '{{ translate('You need to put Transaction id') }}');
                        $(el).prop('disabled', false);
                    } else {
                        $('#checkout-form').submit();
                    }
                }
            } else {
                AIZ.plugins.notify('danger', '{{ translate('You need to agree with our policies') }}');
                $(el).prop('disabled', false);
            }
        }

        function toggleManualPaymentData(id) {
            if (typeof id != 'undefined') {
                $('#manual_payment_description').parent().removeClass('d-none');
                $('#manual_payment_description').html($('#manual_payment_info_' + id).html());
            }
        }



        function stepCompletionPaymentInfo() {
            var headColor = '#9d9da6';
            var btnDisable = true;
            var payment = false;
            var agree = false;
            var allOk = false;
            var length = $('input[name="payment_option"]:checked').length;
            if (length > 0) {
                if ($('input[name="payment_option"]:checked').hasClass('offline_payment_option')) {
                    if ($('#trx_id').val() != '' && $('#trx_id').val() != undefined && $('#trx_id').val() != null) {
                        payment = true;
                    }
                } else {
                    payment = true;
                }

                if ($('#agree_checkbox').is(":checked")) {
                    agree = true;
                }

                if (payment && agree) {
                    headColor = '#15a405';
                    btnDisable = false;
                    allOk = true;
                }
            }

            $('#headingPaymentInfo svg *').css('fill', headColor);
            $("#submitOrderBtn").prop('disabled', btnDisable);
            return allOk;
        }

        function stepCompletionWalletPaymentInfo() {
            var headColor = '#9d9da6';
            var btnDisable = true;
            var allOk = false;
            if ($('#agree_checkbox').is(":checked")) {
                headColor = '#15a405';
                btnDisable = false;
                allOk = true;
            }

            $('#headingPaymentInfo svg *').css('fill', headColor);
            $("#submitOrderBtn").prop('disabled', btnDisable);
            return allOk;
        }

        $('input[name="payment_option"]').change(function() {
            stepCompletionPaymentInfo();
        });

        $(document).ready(function() {
            stepCompletionShippingInfo();
            stepCompletionDeliveryInfo();
            stepCompletionPaymentInfo();
        });
    </script>

    @include('frontend.partials.address.address_js')


    @if (get_setting('google_map') == 1)
        @include('frontend.partials.google_map')
    @endif
@endsection
