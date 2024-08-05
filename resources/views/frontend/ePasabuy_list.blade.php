@extends('frontend.layouts.app')

@section('content')
    <style>
        .shopee-top-ptodict {
            display: none;
        }
    </style>
    <section class="mb-5 mt-3">
        <div class="container">
            <!-- Top Section -->
            @foreach ($flash_deal as $deal)
                <div class="pt-2 pt-lg-4 mb-2 mb-lg-4 d-flex">
                    <!-- Title -->
                    <h1 class="fw-700 fs-20 fs-md-24 text-dark"></h1>
                    <div class="aiz-count-down-box-div ml-3">
                        <div class="aiz-count-down-box align-items-center mb-2 mb-lg-0"
                            data-date="{{ date('Y/m/d H:i:s', $deal->end_date) }}"></div>
                    </div>
                </div>

                <div class="row gutters-16">
                    <!-- Flash Deals Products -->
                    <div class="col-xxl-12 col-lg-12">
                        @if ($deal->status == 1 && strtotime(date('Y-m-d H:i:s')) <= $deal->end_date)
                            <div class="px-3 z-5">
                                <div
                                    class="row row-cols-xxl-5 row-cols-xl-5 row-cols-md-5 row-cols-sm-2 row-cols-2 gutters-16 border-top border-left">
                                    @foreach ($deal->flash_deal_products as $key => $flash_deal_product)
                                        @php
                                            $product = get_single_product($flash_deal_product->product_id);
                                        @endphp
                                        @if ($product != null && $product->published != 0)
                                            @php
                                                $product_url = route('product', $product->slug);
                                                if ($product->auction_product == 1) {
                                                    $product_url = route('auction-product', $product->slug);
                                                }
                                            @endphp
                                            <div
                                                class="col text-center border-right border-bottom has-transition hov-shadow-out z-1">
                                                @include(
                                                    'frontend.' .
                                                        get_setting('homepage_select') .
                                                        '.partials.product_box_1',
                                                    ['product' => $product]
                                                )
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="text-center text-dark">
                                <p class="h4">{{ translate('This offer has been expired.') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
