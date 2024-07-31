@if (count(get_featured_products()) > 0)
    <section class="mb-2 mb-md-3 mt-2 mt-md-3">
        <div class="container">
            <div class="card p-3">
                <!-- Top Section -->
                <div class="card-header">
                    <div class="">
                        <!-- Title -->
                        <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                            <span class="text-primary">{{ translate('DAILY DISCOVER') }}</span>
                        </h3>
                        <!-- Links -->
                        {{-- <div class="d-flex">
                            <a type="button" class="arrow-prev slide-arrow link-disable text-secondary mr-2" onclick="clickToSlide('slick-prev','section_featured')"><i class="las la-angle-left fs-20 fw-600"></i></a>
                            <a type="button" class="arrow-next slide-arrow text-secondary ml-2" onclick="clickToSlide('slick-next','section_featured')"><i class="las la-angle-right fs-20 fw-600"></i></a>
                        </div> --}}
                    </div>
                </div>
            </div>
                <!-- Products Section -->
                <div class="px-sm-3">
                    {{-- <div class="aiz-carousel sm-gutters-16 arrow-none" data-items="6" data-xl-items="5" data-lg-items="4"  data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true' data-infinite='false'>
                        @foreach (get_featured_products() as $key => $product)
                        <div class="carousel-box position-relative px-0 has-transition hov-animate-outline border-right border-top border-bottom @if($key == 0) border-left @endif">
                            <div class="px-3">
                                @include('frontend.'.get_setting('homepage_select').'.partials.product_box_1',['product' => $product])
                            </div>
                        </div>
                        @endforeach
                    </div> --}}
                <div class="row">
                    @foreach (get_featured_products() as $key => $product)
                    <div class="col-xxl-2 col-lg-2 col-md-3 col-6">
                        <div class="carousel-box position-relative px-0 has-transition hov-animate-outline border-right border-top border-bottom @if($key == 0) border-left @endif">
                            <div class="">
                                @include('frontend.'.get_setting('homepage_select').'.partials.product_box_1',['product' => $product])
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                </div>

        </div>
    </section>
@endif
