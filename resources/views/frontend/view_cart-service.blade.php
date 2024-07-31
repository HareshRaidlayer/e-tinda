@extends('frontend.layouts.app')

@section('content')
    <!-- Cart Details -->
    <section class="my-4" id="cart-details">

        <div class="container">

            @if(!empty($carts) )
                <div class="row">
                    <div class="col-lg-8">
                        <div class="bg-white p-3 p-lg-4 text-left">
                            <div class="mb-4">
                                <div class="form-group mb-2 border-bottom">
                                    <div class="aiz-checkbox-inline mb-3">

                                    </div>
                                </div>
                                <!-- Cart Items -->
                                <ul class="list-group list-group-flush">
                                    @php
                                        $total = 0;
                                        $admin_products = array();
                                        $seller_products = array();
                                        $admin_product_variation = array();
                                        $seller_product_variation = array();
                                        // foreach ($carts as $key => $cartItem){
                                        //     $product = get_single_product($cartItem['product_id']);

                                        //     if($product->added_by == 'admin'){
                                        //         array_push($admin_products, $cartItem['product_id']);
                                        //         $admin_product_variation[] = $cartItem['variation'];
                                        //     }
                                        //     else{
                                        //         $product_ids = array();
                                        //         if(isset($seller_products[$product->user_id])){
                                        //             $product_ids = $seller_products[$product->user_id];
                                        //         }
                                        //         array_push($product_ids, $cartItem['product_id']);
                                        //         $seller_products[$product->user_id] = $product_ids;
                                        //         $seller_product_variation[] = $cartItem['variation'];
                                        //     }
                                        // }
                                    @endphp

                                    <!-- Inhouse Products -->
                                    {{-- @if (!empty($admin_products)) --}}
                                        {{-- @php
                                            $all_admin_products = true;
                                            if(count($admin_products) != count($carts->toQuery()->active()->whereIn('product_id', $admin_products)->get())){
                                                $all_admin_products = false;
                                            }
                                        @endphp --}}
                                        <div class="pt-3 px-0">
                                            <div class="aiz-checkbox-inline">
                                                <label class="aiz-checkbox d-block">
                                                    {{-- <input type="checkbox" class="check-one check-seller" value="admin" @if($all_admin_products) checked @endif> --}}
                                                    {{-- <span class="fs-16 fw-700 text-dark ml-3 pb-3 d-block border-left-0 border-top-0 border-right-0 border-bottom border-dashed">
                                                        {{ translate('Inhouse Products') }} ({{ count($admin_products) }})
                                                    </span> --}}
                                                    <span class="aiz-square-check"></span>
                                                </label>
                                            </div>
                                        </div>

                                            @foreach ($carts as $key => $cartItem)
                                            @php
                                                $product = get_single_service($cartItem['product_id']);
                                                // print_r($product);exit;
                                            @endphp
                                                <li class="list-group-item px-0 border-md-0">
                                                    <div class="row gutters-5 align-items-center">
                                                        <!-- select -->
                                                        <div class="col-auto">
                                                            <div class="aiz-checkbox pl-0">
                                                                <label class="aiz-checkbox">
                                                                    <input type="checkbox" class="check-one check-one-admin" name="id[]" value="{{ $cartItem['product_id'] }}" @if($cartItem->status == 1) checked @endif>
                                                                    <span class="aiz-square-check"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <!-- Product Image & name -->
                                                        <div class="col-md-5 col-10 d-flex align-items-center mb-2 mb-md-0">
                                                            <span class="mr-2 ml-0">
                                                                <img src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                                    class="img-fit size-64px"
                                                                    alt="{{ $product->name  }}"
                                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                                            </span>
                                                            <span>
                                                                <span class="fs-14 fw-400 text-dark text-truncate-2 mb-2">{{ $product->name }}</span>
                                                                {{-- @if ($admin_product_variation[$key] != '')
                                                                    <span class="fs-12 text-secondary">{{ translate('Variation') }}: {{ $admin_product_variation[$key] }}</span>
                                                                @endif --}}
                                                            </span>
                                                        </div>
                                                        <!-- Price & Tax -->
                                                        <div class="col-md col-4 ml-4 ml-sm-0 my-3 my-md-0 d-flex flex-column ml-sm-5 ml-md-0">
                                                            <span class="fs-12 text-secondary">{{ translate('Price')}}</span>
                                                            <span class="fw-700 fs-14 mb-2">{{ $cartItem['service_price'] }}</span>
                                                            {{-- <span>
                                                                <span class="opacity-90 fs-12">{{ translate('Tax')}}: {{ cart_product_tax($cartItem, $product) }}</span>
                                                            </span> --}}
                                                        </div>
                                                        <!-- Quantity & Total -->


                                                    </div>
                                                </li>
                                            @endforeach
                                        {{-- @endif --}}


                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Cart Summary -->
                    <div class="col-lg-4 mt-lg-0 mt-4" id="cart_summary">
                        {{-- @include('frontend.partials.cart.cart_summary', ['proceed' => 1, 'carts' => $carts]) --}}
                        <div class="z-3 sticky-top-lg">
                            <div class="card rounded-0 border">

                                @php
                                    $subtotal_for_min_order_amount = 0;
                                    $subtotal = 0;
                                    $tax = 0;
                                    $product_shipping_cost = 0;
                                    $shipping = 0;
                                    $coupon_code = null;
                                    $coupon_discount = 0;
                                    $total_point = 0;
                                @endphp
                                @foreach ($carts as $key => $cartItem)
                                    @php
                                        // $product = get_single_product($cartItem['product_id']);
                                        $subtotal_for_min_order_amount += $cartItem['service_price'];
                                        $subtotal += $cartItem['service_price'];
                                        $tax +=$cartItem['txt'];
                                        $product_shipping_cost = $cartItem['shipping_cost'];
                                        $shipping += $product_shipping_cost;
                                        if ((get_setting('coupon_system') == 1) && ($cartItem->coupon_applied == 1)) {
                                            $coupon_code = $cartItem->coupon_code;
                                            $coupon_discount = $carts->sum('discount');
                                        }
                                        // if (addon_is_activated('club_point')) {
                                        //     $total_point += $product->earn_point * $cartItem['quantity'];
                                        // }
                                    @endphp
                                @endforeach

                                <div class="card-header pt-4 pb-1 border-bottom-0">
                                    <h3 class="fs-16 fw-700 mb-0">{{ translate('Order Summary') }}</h3>
                                    <div class="text-right">
                                        <!-- Minimum Order Amount -->
                                        @if (get_setting('minimum_order_amount_check') == 1 && $subtotal_for_min_order_amount < get_setting('minimum_order_amount'))
                                            <span class="badge badge-inline badge-warning fs-12 rounded-0 px-2">
                                                {{ translate('Minimum Order Amount') . ' ' . single_price(get_setting('minimum_order_amount')) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="card-body pt-2">

                                    <div class="row gutters-5">
                                        <!-- Total Products -->
                                        <div class="@if (addon_is_activated('club_point')) col-6 @else col-12 @endif">
                                            <div class="d-flex align-items-center justify-content-between bg-primary p-2">
                                                <span class="fs-13 text-white">{{ translate('Total Products') }}</span>
                                                <span class="fs-13 fw-700 text-white">{{ sprintf("%02d", count($carts)) }}</span>
                                            </div>
                                        </div>
                                        @if (addon_is_activated('club_point'))
                                            <!-- Total Clubpoint -->
                                            <div class="col-6">
                                                <div class="d-flex align-items-center justify-content-between bg-secondary-base p-2">
                                                    <span class="fs-13 text-white">{{ translate('Total Clubpoint') }}</span>
                                                    <span class="fs-13 fw-700 text-white">{{ sprintf("%02d", $total_point) }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <input type="hidden" id="sub_total" value="{{ $subtotal }}">

                                    <table class="table my-3">
                                        <tfoot>
                                            <!-- Subtotal -->
                                            <tr class="cart-subtotal">
                                                <th class="pl-0 fs-14 fw-400 pt-0 pb-2 text-dark border-top-0">{{ translate('Subtotal') }} ({{ sprintf("%02d", count($carts)) }} {{ translate('Products') }})</th>
                                                <td class="text-right pr-0 fs-14 pt-0 pb-2 text-dark border-top-0">{{ single_price($subtotal) }}</td>
                                            </tr>
                                            <!-- Tax -->
                                            <tr class="cart-tax">
                                                <th class="pl-0 fs-14 fw-400 pt-0 pb-2 text-dark border-top-0">{{ translate('Tax') }}</th>
                                                <td class="text-right pr-0 fs-14 pt-0 pb-2 text-dark border-top-0">{{ single_price($tax) }}</td>
                                            </tr>
                                            {{-- @if ($proceed != 1)
                                            <!-- Total Shipping -->
                                            <tr class="cart-shipping">
                                                <th class="pl-0 fs-14 fw-400 pt-0 pb-2 text-dark border-top-0">{{ translate('Total Shipping') }}</th>
                                                <td class="text-right pr-0 fs-14 pt-0 pb-2 text-dark border-top-0">{{ single_price($shipping) }}</td>
                                            </tr>
                                            @endif --}}
                                            <!-- Redeem point -->
                                            @if (Session::has('club_point'))
                                                <tr class="cart-club-point">
                                                    <th class="pl-0 fs-14 fw-400 pt-0 pb-2 text-dark border-top-0">{{ translate('Redeem point') }}</th>
                                                    <td class="text-right pr-0 fs-14 pt-0 pb-2 text-dark border-top-0">{{ single_price(Session::get('club_point')) }}</td>
                                                </tr>
                                            @endif
                                            <!-- Coupon Discount -->
                                            @if ($coupon_discount > 0)
                                                <tr class="cart-coupon-discount">
                                                    <th class="pl-0 fs-14 fw-400 pt-0 pb-2 text-dark border-top-0">{{ translate('Coupon Discount') }}</th>
                                                    <td class="text-right pr-0 fs-14 pt-0 pb-2 text-dark border-top-0">{{ single_price($coupon_discount) }}</td>
                                                </tr>
                                            @endif

                                            @php
                                                $total = $subtotal + $tax + $shipping;
                                                if (Session::has('club_point')) {
                                                    $total -= Session::get('club_point');
                                                }
                                                if ($coupon_discount > 0) {
                                                    $total -= $coupon_discount;
                                                }
                                            @endphp
                                            <!-- Total -->
                                            <tr class="cart-total">
                                                <th class="pl-0 fs-14 text-dark fw-700 border-top-0 pt-3 text-uppercase">{{ translate('Total') }}</th>
                                                <td class="text-right pr-0 fs-16 fw-700 text-primary border-top-0 pt-3">{{ single_price($total) }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>

                                    <!-- Coupon System -->
                                    @if (get_setting('coupon_system') == 1)
                                        @if ($coupon_discount > 0 && $coupon_code)
                                            <div class="mt-3">
                                                <form class="" id="remove-coupon-form" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="proceed" value="{{ $proceed ?? '' }}">
                                                    <div class="input-group">
                                                        <div class="form-control">{{ $coupon_code }}</div>
                                                        <div class="input-group-append">
                                                            <button type="button" id="coupon-remove"
                                                                class="btn btn-primary">{{ translate('Change Coupon') }}</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        @else
                                            <div class="mt-3">
                                                <form class="" id="apply-coupon-form" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="proceed" value="{{ $proceed ?? '' }}">
                                                    <div class="error" style="color: red;"> Coupon system disabled for service. </div>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control rounded-0" name="code" disabled
                                                            onkeydown="return event.key != 'Enter';"
                                                            placeholder="{{ translate('Have coupon code? Apply here') }}" required>
                                                        <div class="input-group-append">
                                                            <button type="button" id="coupon-apply"
                                                                class="btn btn-primary rounded-0" disabled>{{ translate('Apply') }}</button>
                                                        </div>
                                                    </div>
                                                    @if (!auth()->check())
                                                        <small>{{ translate('You must Login as customer to apply coupon') }}</small>
                                                    @endif

                                                </form>
                                            </div>
                                        @endif
                                    @endif

                                    {{-- @if ($proceed == 1) --}}
                                    <!-- Continue to Shipping -->
                                    <div class="mt-4">
                                        <a href="{{ route('checkoutService') }}" class="btn btn-primary btn-block fs-14 fw-700 rounded-0 px-4">
                                            {{ translate('Proceed to Checkout')}} ({{ sprintf("%02d", count($carts)) }})
                                        </a>
                                    </div>
                                    {{-- @endif --}}

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-xl-8 mx-auto">
                        <div class="border bg-white p-4">
                            <!-- Empty cart -->
                            <div class="text-center p-3">
                                <i class="las la-frown la-3x opacity-60 mb-3"></i>
                                <h3 class="h4 fw-700">{{translate('Your Cart is empty')}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>


    </section>

@endsection

@section('script')
    <script type="text/javascript">
        function removeFromCartView(e, key) {
            e.preventDefault();
            removeFromCart(key);
        }

        function updateQuantity(key, element) {
            $.post('{{ route('cart.updateQuantity') }}', {
                _token: AIZ.data.csrf,
                id: key,
                quantity: element.value
            }, function(data) {
                updateNavCart(data.nav_cart_view, data.cart_count);
                $('#cart-details').html(data.cart_view);
                AIZ.extra.plusMinus();
            });
        }

        // Cart item selection
        $(document).on("change", ".check-all", function() {
            $('.check-one:checkbox').prop('checked', this.checked);
            updateCartStatus();
        });
        $(document).on("change", ".check-seller", function() {
            var value = this.value;
            $('.check-one-'+value+':checkbox').prop('checked', this.checked);
            updateCartStatus();
        });
        $(document).on("change", ".check-one[name='id[]']", function(e) {
            e.preventDefault();
            updateCartStatus();
        });
        function updateCartStatus() {
            $('.aiz-refresh').addClass('active');
            let product_id = [];
            $(".check-one[name='id[]']:checked").each(function() {
                product_id.push($(this).val());
            });

            $.post('{{ route('cart.updateCartStatus') }}', {
                _token: AIZ.data.csrf,
                product_id: product_id
            }, function(data) {
                $('#cart-details').html(data);
                AIZ.extra.plusMinus();
                $('.aiz-refresh').removeClass('active');
            });
        }

        // coupon apply
        $(document).on("click", "#coupon-apply", function() {
            @if (Auth::check())
                @if(Auth::user()->user_type != 'customer')
                    AIZ.plugins.notify('warning', "{{ translate('Please Login as a customer to apply coupon code.') }}");
                    return false;
                @endif

                var data = new FormData($('#apply-coupon-form')[0]);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: "POST",
                    url: "{{ route('checkout.apply_coupon_code') }}",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data, textStatus, jqXHR) {
                        AIZ.plugins.notify(data.response_message.response, data.response_message.message);
                        $("#cart_summary").html(data.html);
                    }
                });
            @else
                $('#login_modal').modal('show');
            @endif
        });

        // coupon remove
        $(document).on("click", "#coupon-remove", function() {
            @if (Auth::check() && Auth::user()->user_type == 'customer')
                var data = new FormData($('#remove-coupon-form')[0]);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: "POST",
                    url: "{{ route('checkout.remove_coupon_code') }}",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data, textStatus, jqXHR) {
                        $("#cart_summary").html(data);
                    }
                });
            @endif
        });

    </script>
@endsection
