@php
    $cart_added = [];
@endphp
<div class="aiz-card-box h-auto bg-white py-3 hov-scale-img">
    <div class="position-relative h-140px h-md-200px img-fit overflow-hidden">
        @php
            $product_url = route('propertyDetails', $hotel->id);
        @endphp
        <!-- Image -->
        <a href="{{ $product_url }}" class="d-block h-100">
            <img class="lazyload mx-auto img-fit has-transition"
                src="{{ uploaded_asset($hotel->image) }}"
                alt="{{ $hotel->name }}" title="{{ $hotel->name }}"
                >
        </a>
    </div>

    <div class="p-2 p-md-3 text-left">
        <!-- Product name -->
        <h3 class="fw-400 fs-13 text-truncate-2 lh-1-4 mb-0 h-35px text-center">
            <a href="{{ $product_url }}" class="d-block text-reset hov-text-primary"
                title="{{ $hotel->name }}">{{ $hotel->name }}</a>
        </h3>
    </div>
    <div class="fs-14 d-flex justify-content-center">
            <!-- Bid Amount -->
            <div class="">
                <span class="fw-700 text-primary">
                    <?php foreach ($hotel->rooms as $room) {
                       echo single_price($room->price);
                        break;
                    }
                    ?>
                </span>
            </div>
    </div>
</div>
