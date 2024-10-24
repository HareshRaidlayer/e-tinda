@extends('frontend.layouts.app')

@section('content')

    <!-- Steps -->
    <section class="pt-5 mb-0">
        <div class="container">

        </div>
    </section>

    <!-- Order Confirmation -->
    <section class="py-4">
        <div class="container text-left">
            <div class="row">
                <div class="col-xl-8 mx-auto">
                    @php
                        $first_order = $combined_order->orders->first();
                        // dd($first_order);exit;
                    @endphp
                    <!-- Order Confirmation Text-->
                    <div class="text-center py-4 mb-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36" class=" mb-3">
                            <g id="Group_23983" data-name="Group 23983" transform="translate(-978 -481)">
                              <circle id="Ellipse_44" data-name="Ellipse 44" cx="18" cy="18" r="18" transform="translate(978 481)" fill="#85b567"/>
                              <g id="Group_23982" data-name="Group 23982" transform="translate(32.439 8.975)">
                                <rect id="Rectangle_18135" data-name="Rectangle 18135" width="11" height="3" rx="1.5" transform="translate(955.43 487.707) rotate(45)" fill="#fff"/>
                                <rect id="Rectangle_18136" data-name="Rectangle 18136" width="3" height="18" rx="1.5" transform="translate(971.692 482.757) rotate(45)" fill="#fff"/>
                              </g>
                            </g>
                        </svg>
                        <h1 class="mb-2 fs-28 fw-500 text-success">{{ translate('Thank You for Booking!')}}</h1>

                    </div>
                    <!-- Order Summary -->
                    <div class="mb-4 bg-white p-4 border">
                        <h5 class="fw-600 mb-3 fs-16 text-soft-dark pb-2 border-bottom">{{ translate('Booking Summary')}}</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table fs-14 text-soft-dark">
                                    <tr>
                                        <td class="w-50 fw-600 border-top-0 pl-0 py-2">{{ translate('Booking date')}}:</td>
                                        <td class="border-top-0 py-2">{{ date('d-m-Y H:i A', $first_order->date) }}</td>
                                    </tr>


                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table">

                                    <tr>
                                        <td class="w-50 fw-600 border-top-0 py-2">{{ translate('Total order amount')}}:</td>
                                        <td class="border-top-0 pr-0 py-2">{{ single_price($combined_order->grand_total) }}</td>
                                    </tr>

                                    <tr>
                                        <td class="w-50 fw-600 border-top-0 py-2">{{ translate('Payment method')}}:</td>
                                        <td class="border-top-0 pr-0 py-2">{{ translate(ucfirst(str_replace('_', ' ', $first_order->payment_type))) }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div>
                        <a href="{{route('bookingDetails')}}" class="btn btn-link fs-14 fw-700 px-0">
                            <i class="las la-arrow-left fs-16"></i>
                            See Booking Details
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    @if (get_setting('facebook_pixel') == 1)
    <!-- Facebook Pixel purchase Event -->
    <script>
        $(document).ready(function(){
            var currend_code = '{{ get_system_currency()->code }}';
            var amount = 'single_price($combined_order->grand_total) }}';
            fbq('track', 'Purchase',
                {
                    value: amount,
                    currency: currend_code,
                    content_type: 'product'
                }
            );
        });
    </script>
    <!-- Facebook Pixel purchase Event -->
    @endif
@endsection

