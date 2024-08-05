@php
    $cart_added = [];
@endphp
<div class="aiz-card-box h-auto bg-white py-3 hov-scale-img">
    <div class="position-relative h-140px h-md-200px img-fit overflow-hidden">
        @php
            $product_url = route('service', $product->slug);

        @endphp
        <!-- Image -->
        <a href="{{ $product_url }}" class="d-block h-100">
            <img class="lazyload mx-auto img-fit has-transition"
                src="{{ get_image($product->thumbnail) }}"
                alt="{{ $product->name }}" title="{{ $product->name }}"
                >
        </a>
        <!-- Discount percentage tag -->
                @if ($product->discount)
                <span class="absolute-top-right bg-primary ml-1 mt-1 fs-11 fw-700 text-white w-35px text-center"
                style="padding-top:2px;padding-bottom:2px;">{{ $product->discount }}
                @if ($product->discount_type == 'percent')
                <?php echo '%';?>
                @endif
                </span>
                @endif


        @if (
            $product->auction_product == 1 &&
                $product->auction_start_date <= strtotime('now') &&
                $product->auction_end_date >= strtotime('now'))
            <!-- Place Bid -->
            @php
                $carts = get_user_cart();
                if (count($carts) > 0) {
                    $cart_added = $carts->pluck('product_id')->toArray();
                }
                $highest_bid = $product->bids->max('amount');
                $min_bid_amount = $highest_bid != null ? $highest_bid + 1 : $product->starting_bid;
            @endphp
            <a class="cart-btn absolute-bottom-left w-100 h-35px aiz-p-hov-icon text-white fs-13 fw-700 d-flex flex-column justify-content-center align-items-center @if (in_array($product->id, $cart_added)) active @endif"
                href="javascript:void(0)" onclick="bid_single_modal({{ $product->id }}, {{ $min_bid_amount }})">
                <span class="cart-btn-text">{{ translate('Place Bid') }}</span>
                <span><i class="las la-2x la-gavel"></i></span>
            </a>
        @endif
    </div>

    <div class="p-2 p-md-3 text-left">
        <!-- Product name -->
        <h3 class="fw-400 fs-13 text-truncate-2 lh-1-4 mb-0 h-35px text-center">
            <a href="{{ $product_url }}" class="d-block text-reset hov-text-primary"
                title="{{ $product->name }}">{{ $product->name }}</a>
        </h3>
        <div class="fs-14 d-flex justify-content-center mt-3">
            @if ($product->auction_product == 0)
                <!-- Previous price -->
                    <div class="disc-amount has-transition">
                        <del class="fw-400 text-secondary mr-1">{{ home_price_service($product) }}</del>
                    </div>


                <!-- price -->
                <div class="">
                    <span class="fw-700 text-primary">{{home_discounted_priceService($product) }}</span>
                </div>
            @endif
            @if ($product->auction_product == 1)
                <!-- Bid Amount -->
                <div class="">
                    <span class="fw-700 text-primary">{{ single_price($product->starting_bid) }}</span>
                </div>
            @endif
        </div>
    </div>
</div>
