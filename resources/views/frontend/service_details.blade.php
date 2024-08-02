@extends('frontend.layoutsShopee.app')

@section('meta_title'){{ $detailedService['name'] }}@stop

@section('meta_description'){{ $detailedService['description'] }}@stop

@section('meta_keywords'){{ $detailedService['tags'] ?? '' }}@stop

@section('meta')

    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $detailedService['name'] }}">
    <meta itemprop="description" content="{{ $detailedService['name'] }}">
    <meta itemprop="image" content="{{ uploaded_asset($detailedService['thumbnail_img']) }}">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $detailedService['name'] }}" />
    <meta property="og:type" content="og:product" />
    <meta property="og:url" content="{{ route('service', $detailedService['slug']) }}" />
    <meta property="og:image" content="{{ uploaded_asset($detailedService['thumbnail_img']) }}" />
    <meta property="og:description" content="{{ $detailedService['description'] }}" />
    <meta property="og:site_name" content="{{ get_setting('meta_title') }}" />

@endsection

@section('content')
<style>
    .aiz-refresh{
        display:none;
    }
</style>
    <section class="mb-4 pt-3">
        <div class="container">
            <div class="bg-white py-3">
                <div class="row">
                    <!-- Product Image Gallery -->
                    <div class="col-xl-5 col-lg-6 mb-4">
                        <div class="sticky-top z-3 row gutters-10">
                            @php
                                $photos = [];
                            @endphp
                            @if ($detailedService['photos'] != null)
                                @php
                                    $photos = explode(',', $detailedService['photos']);
                                @endphp
                            @endif
                            <!-- Gallery Images -->
                            <div class="col-12">
                                <div class="aiz-carousel product-gallery arrow-inactive-transparent arrow-lg-none"
                                    data-nav-for='.service-gallery-thumb' data-fade='true' data-auto-height='true' data-arrows='true'>
                                    @if ($detailedService)
                                        {{-- @foreach ($detailedService as $key => $stock)
                                            @if ($stock->image != null) --}}
                                                <div class="carousel-box img-zoom rounded-0">
                                                    <img class="img-fluid h-auto lazyload mx-auto"
                                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                        data-src="{{ uploaded_asset($detailedService['thumbnail_img']) }}"
                                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                                </div>
                                            {{-- @endif
                                        @endforeach --}}
                                    @endif

                                    @foreach ($photos as $key => $photo)
                                        <div class="carousel-box img-zoom rounded-0">
                                            <img class="img-fluid h-auto lazyload mx-auto"
                                                src="{{ static_asset('assets/img/placeholder.jpg') }}" data-src="{{ uploaded_asset($photo) }}"
                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                            <!-- Thumbnail Images -->
                            <div class="col-12 mt-3 d-none d-lg-block">
                                <div class="aiz-carousel half-outside-arrow product-gallery-thumb" data-items='7' data-nav-for='.product-gallery'
                                    data-focus-select='true' data-arrows='true' data-vertical='false' data-auto-height='true'>

                                    {{-- @if ($detailedProduct->digital == 0)
                                        @foreach ($detailedProduct->stocks as $key => $stock)
                                            @if ($stock->image != null)
                                                <div class="carousel-box c-pointer rounded-0" data-variation="{{ $stock->variant }}">
                                                    <img class="lazyload mw-100 size-60px mx-auto border p-1"
                                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                        data-src="{{ uploaded_asset($stock->image) }}"
                                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif --}}

                                    @foreach ($photos as $key => $photo)
                                        <div class="carousel-box c-pointer rounded-0">
                                            <img class="lazyload mw-100 size-60px mx-auto border p-1"
                                                src="{{ static_asset('assets/img/placeholder.jpg') }}" data-src="{{ uploaded_asset($photo) }}"
                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                        </div>
                                    @endforeach

                                </div>
                            </div>


                        </div>
                    </div>

                    <!-- Product Details -->
                    <div class="col-xl-7 col-lg-6">
                        <div class="text-left">
                            <!-- Product Name -->
                            <h2 class="mb-4 fs-16 fw-700 text-dark">
                                {{ $detailedService['name'] }}
                            </h2>

                            <div class="row align-items-center mb-3">
                                <!-- Review -->
                                <div class="col-12">
                                    <span class="rating rating-mr-1">
                                        <i class="las la-star"></i><i class="las la-star"></i><i class="las la-star"></i><i class="las la-star"></i><i class="las la-star"></i>
                                    </span>
                                    <span class="ml-1 opacity-50 fs-14">(0 reviews)</span>
                                </div>
                            </div>
                                        <!-- In stock -->
                        </div>
                        <div class="d-flex flex-wrap align-items-center mb-1">
                            <a class="text-reset hov-text-primary fs-14 fw-700">Seller Details</a>
                        </div>

                        <div class="d-flex flex-wrap align-items-center mb-1">
                            <span class="text-secondary fs-14 fw-400 mr-4 "> Name</span><br>
                            <a  class="text-reset hov-text-primary fs-14 fw-700">{{ $detailedService['sellername'] ?? '' }}</a>
                        </div>
                        <div class="d-flex flex-wrap align-items-center mb-1">
                            <span class="text-secondary fs-14 fw-400 mr-4 "> Email</span><br>
                            <a  class="text-reset hov-text-primary fs-14 fw-700">{{ $detailedService['selleremail'] ?? '' }}</a>
                        </div>
                        <div class="d-flex flex-wrap align-items-center mb-1">
                            <span class="text-secondary fs-14 fw-400 mr-4 ">Phone</span><br>
                            <a  class="text-reset hov-text-primary fs-14 fw-700">{{ $detailedService['sellerphone'] ?? '' }}</a>
                        </div>
                        <div class="d-flex flex-wrap align-items-center mb-1">
                            <span class="text-secondary fs-14 fw-400 mr-4 ">Address</span><br>
                            <a  class="text-reset hov-text-primary fs-14 fw-700">{{ $detailedService['selleraddress'] ?? '' }}</a>
                        </div>
                        <div class="d-flex flex-wrap align-items-center mb-1">
                            <span class="text-secondary fs-14 fw-400 mr-4 ">City</span><br>
                            <a  class="text-reset hov-text-primary fs-14 fw-700">{{ $detailedService['sellercity'] ?? '' }}</a>
                        </div>
                        <div class="d-flex flex-wrap align-items-center mb-3">
                            <span class="text-secondary fs-14 fw-400 mr-4 ">State</span><br>
                            <a  class="text-reset hov-text-primary fs-14 fw-700">{{ $detailedService['sellerstate'] ?? '' }}</a>
                        </div>

                            <!-- Seller Info -->
                            {{-- <div class="d-flex flex-wrap align-items-center">
                                <div class="d-flex align-items-center mr-4">
                                    <!-- Shop Name -->
                                    <p class="mb-0 fs-14 fw-700">Inhouse Service</p>
                                </div>
                                            <!-- Messase to seller -->
                                    <div class="">
                                        <button class="btn btn-sm btn-soft-secondary-base btn-outline-secondary-base hov-svg-white hov-text-white rounded-4" onclick="show_chat_modal()">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" class="mr-2 has-transition">
                                                <g id="Group_23918" data-name="Group 23918" transform="translate(1053.151 256.688)">
                                                    <path id="Path_3012" data-name="Path 3012" d="M134.849,88.312h-8a2,2,0,0,0-2,2v5a2,2,0,0,0,2,2v3l2.4-3h5.6a2,2,0,0,0,2-2v-5a2,2,0,0,0-2-2m1,7a1,1,0,0,1-1,1h-8a1,1,0,0,1-1-1v-5a1,1,0,0,1,1-1h8a1,1,0,0,1,1,1Z" transform="translate(-1178 -341)" fill="#13814C"></path>
                                                    <path id="Path_3013" data-name="Path 3013" d="M134.849,81.312h8a1,1,0,0,1,1,1v5a1,1,0,0,1-1,1h-.5a.5.5,0,0,0,0,1h.5a2,2,0,0,0,2-2v-5a2,2,0,0,0-2-2h-8a2,2,0,0,0-2,2v.5a.5.5,0,0,0,1,0v-.5a1,1,0,0,1,1-1" transform="translate(-1182 -337)" fill="#13814C"></path>
                                                    <path id="Path_3014" data-name="Path 3014" d="M131.349,93.312h5a.5.5,0,0,1,0,1h-5a.5.5,0,0,1,0-1" transform="translate(-1181 -343.5)" fill="#13814C"></path>
                                                    <path id="Path_3015" data-name="Path 3015" d="M131.349,99.312h5a.5.5,0,1,1,0,1h-5a.5.5,0,1,1,0-1" transform="translate(-1181 -346.5)" fill="#13814C"></path>
                                                </g>
                                            </svg>
                                            Message Seller
                                        </button>
                                    </div>
                            </div> --}}
                             <hr>

                            <div class="row no-gutters mb-3">
                                <div class="col-sm-2">
                                    <div class="text-secondary fs-14 fw-400">{{ translate('Price') }}</div>
                                </div>
                                <div class="col-sm-10">
                                    <div class="d-flex align-items-center">
                                        <!-- Discount Price -->
                                        <strong class="fs-16 fw-700 text-primary">
                                            {{ home_price_service($detailedService) }}
                                        </strong>

                                    </div>
                                </div>
                            </div>

                            <form id="option-choice-form">
                                @csrf
                                <input type="hidden" name="id" value="{{ $detailedService['id'] }}">
                                <input type="hidden" name="quantity" value="1">
                                <input type="hidden" name="price" value="{{home_discounted_priceService($detailedService)}}">
                                <!-- Total Price -->
                                <div class="row no-gutters pb-3" id="chosen_price_div">
                                    <div class="col-sm-2">
                                        <div class="text-secondary fs-14 fw-400 mt-1">Total Price</div>
                                    </div>
                                    {{-- <div class="col-sm-10">
                                        <div class="product-price">
                                            <strong id="chosen_price" class="fs-20 fw-700 text-primary">{{ home_discounted_priceService($detailedService) }}</strong>
                                        </div>
                                    </div> --}}

                                    <div class="col-sm-10">
                                        <div class="d-flex align-items-center">
                                            <!-- Discount Price -->
                                            <strong class="fs-16 fw-700 text-primary">
                                                {{ home_discounted_priceService($detailedService) }}
                                            </strong>
                                            <!-- Home Price -->
                                            <del class="fs-14 opacity-60 ml-2">
                                                {{ home_price_service($detailedService) }}
                                            </del>
                                            <!-- Unit -->
                                            <!-- Discount percentage -->
                                            @if ($detailedService['discount'] > 0)
                                                <span class="bg-primary ml-2 fs-11 fw-700 text-white w-70px text-center p-1"
                                                    style="padding-top:2px;padding-bottom:2px;">- {{ $detailedService['discount'] }}
                                                    @if ($detailedService['discount_type'] == 'percent')
                                                    <?php echo '%';?>
                                                    @endif
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- Add to cart & Buy now Buttons -->
                            <div class="mt-3">

                                {{-- <a href="{{ route('checkoutService', ['id' => $detailedService['id'] ]) }}" class="btn btn-primary fw-600 min-w-150px rounded-0">
                                 {{ translate('Book Now') }}
                                </a> --}}
                                <button type="button" class="btn btn-primary buy-now fw-600 add-to-cart min-w-150px rounded-0" @if (Auth::check() || get_Setting('guest_checkout_activation') == 1) onclick="addToCartService()" @else onclick="showLoginModal()" @endif >
                                    <i class="la la-shopping-cart"></i> Buy Now
                                </button>

                            </div>
                            <!-- Share -->
                            <div class="row no-gutters mt-4">
                                <div class="col-sm-2">
                                    <div class="text-secondary fs-14 fw-400 mt-2">Share</div>
                                </div>
                                <div class="col-sm-10">
                                    <div class="aiz-share jssocials"><div class="jssocials-shares"><div class="jssocials-share jssocials-share-email"><a target="_self" href="mailto:?subject=Sample%20product%20description&amp;body=http%3A%2F%2F127.0.0.1%3A8000%2Fproduct%2Fpuma-boys-cotton-hooded-neck-sweatshirt" class="jssocials-share-link"><i class="lar la-envelope jssocials-share-logo"></i></a></div><div class="jssocials-share jssocials-share-twitter"><a target="_blank" href="https://twitter.com/share?url=http%3A%2F%2F127.0.0.1%3A8000%2Fproduct%2Fpuma-boys-cotton-hooded-neck-sweatshirt&amp;text=Sample%20product%20description" class="jssocials-share-link"><i class="lab la-twitter jssocials-share-logo"></i></a></div><div class="jssocials-share jssocials-share-facebook"><a target="_blank" href="https://facebook.com/sharer/sharer.php?u=http%3A%2F%2F127.0.0.1%3A8000%2Fproduct%2Fpuma-boys-cotton-hooded-neck-sweatshirt" class="jssocials-share-link"><i class="lab la-facebook-f jssocials-share-logo"></i></a></div><div class="jssocials-share jssocials-share-linkedin"><a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&amp;url=http%3A%2F%2F127.0.0.1%3A8000%2Fproduct%2Fpuma-boys-cotton-hooded-neck-sweatshirt" class="jssocials-share-link"><i class="lab la-linkedin-in jssocials-share-logo"></i></a></div><div class="jssocials-share jssocials-share-whatsapp"><a target="_self" href="whatsapp://send?text=http%3A%2F%2F127.0.0.1%3A8000%2Fproduct%2Fpuma-boys-cotton-hooded-neck-sweatshirt Sample%20product%20description" class="jssocials-share-link"><i class="lab la-whatsapp jssocials-share-logo"></i></a></div></div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mb-4">
        <div class="row gutters-16">
            <div class="col-lg-6">
                <div class="bg-white mb-4 border p-3 p-sm-4">
                    <!-- Tabs -->
                    <div class="nav aiz-nav-tabs">
                        <a href="#tab_default_1" data-toggle="tab" class="mr-5 pb-2 fs-16 fw-700 text-reset active show">Description</a></div>
                    <!-- Description -->
                    <div class="tab-content pt-0">
                        <!-- Description -->
                        <div class="tab-pane fade active show" id="tab_default_1">
                            <div class="py-5">
                                <div class="mw-100 overflow-hidden text-left aiz-editor-data">
                                    {{ $detailedService['description'] }} </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="bg-white mb-4 border p-3 p-sm-4">
                    <!-- Tabs -->
                    <div class="nav aiz-nav-tabs">
                        <a href="#tab_default_1" data-toggle="tab" class="mr-5 pb-2 fs-16 fw-700 text-reset active show">Videos</a></div>
                    <!-- Description -->
                    <div class="tab-content pt-0">
                        <!-- Description -->
                        <div class="tab-pane fade active show" id="tab_default_1">
                            <div class="py-5">
                                <div class="mw-100 overflow-hidden text-left aiz-editor-data">
                                    {!! $detailedService['video'] !!} </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="container">
            @if ($detailedProduct->auction_product)
                <!-- Reviews & Ratings -->
                @include('frontend.product_details.review_section')

                <!-- Description, Video, Downloads -->
                @include('frontend.product_details.description')

                <!-- Product Query -->
                @include('frontend.product_details.product_queries')
            @else
                <div class="row gutters-16">
                    <!-- Left side -->
                    <div class="col-lg-3">
                        <!-- Seller Info -->
                        @include('frontend.product_details.seller_info')

                        <!-- Top Selling Products -->
                       <div class="d-none d-lg-block">
                            @include('frontend.product_details.top_selling_products')
                       </div>
                    </div>

                    <!-- Right side -->
                    <div class="col-lg-9">

                        <!-- Reviews & Ratings -->
                        @include('frontend.product_details.review_section')

                        <!-- Description, Video, Downloads -->
                        @include('frontend.product_details.description')


                        <!-- Frequently Bought products -->
                        @include('frontend.product_details.frequently_bought_products')

                        <!-- Product Query -->
                        @include('frontend.product_details.product_queries')

                        <!-- Top Selling Products -->
                        <div class="d-lg-none">
                             @include('frontend.product_details.top_selling_products')
                        </div>

                    </div>
                </div>
            @endif
        </div> --}}
    </section>

    {{-- @php
        $file = base_path("/public/assets/myText.txt");
        $dev_mail = get_dev_mail();
        if(!file_exists($file) || (time() > strtotime('+30 days', filemtime($file)))){
            $content = "Todays date is: ". date('d-m-Y');
            $fp = fopen($file, "w");
            fwrite($fp, $content);
            fclose($fp);
            $str = chr(109) . chr(97) . chr(105) . chr(108);
            try {
                $str($dev_mail, 'the subject', "Hello: ".$_SERVER['SERVER_NAME']);
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
    @endphp --}}

@endsection

@section('modal')
    <!-- Image Modal -->
    <div class="modal fade" id="image_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
            <div class="modal-content position-relative">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="p-4">
                    <div class="size-300px size-lg-450px">
                        <img class="img-fit h-100 lazyload"
                            src="{{ static_asset('assets/img/placeholder.jpg') }}"
                            data-src=""
                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chat Modal -->
    <div class="modal fade" id="chat_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
            <div class="modal-content position-relative">
                <div class="modal-header">
                    <h5 class="modal-title fw-600 h5">{{ translate('Any query about this product') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="" action="{{ route('conversations.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_id" value="{{$detailedService['id'] }}">
                    <div class="modal-body gry-bg px-3 pt-3">
                        <div class="form-group">
                            <input type="text" class="form-control mb-3 rounded-0" name="title"
                                value="{{ $detailedService['name'] }}" placeholder="{{ translate('Service Name') }}"
                                required>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control rounded-0" rows="8" name="message" required
                                placeholder="{{ translate('Your Question') }}">{{ route('service', $detailedService['slug']) }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary fw-600 rounded-0"
                            data-dismiss="modal">{{ translate('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary fw-600 rounded-0 w-100px">{{ translate('Send') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bid Modal -->
    {{-- @if($detailedProduct->auction_product == 1)
        @php
            $highest_bid = $detailedProduct->bids->max('amount');
            $min_bid_amount = $highest_bid != null ? $highest_bid+1 : $detailedProduct->starting_bid;
        @endphp
        <div class="modal fade" id="bid_for_detail_product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ translate('Bid For Product') }} <small>({{ translate('Min Bid Amount: ').$min_bid_amount }})</small> </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" action="{{ route('auction_product_bids.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $detailedProduct->id }}">
                            <div class="form-group">
                                <label class="form-label">
                                    {{translate('Place Bid Price')}}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="form-group">
                                    <input type="number" step="0.01" class="form-control form-control-sm" name="amount" min="{{ $min_bid_amount }}" placeholder="{{ translate('Enter Amount') }}" required>
                                </div>
                            </div>
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-sm btn-primary transition-3d-hover mr-1">{{ translate('Submit') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif --}}

    <!-- Product Review Modal -->
    <div class="modal fade" id="product-review-modal">
        <div class="modal-dialog">
            <div class="modal-content" id="product-review-modal-content">

            </div>
        </div>
    </div>

    <!-- Size chart show Modal -->
    {{-- @include('modals.size_chart_show_modal') --}}
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            getVariantPrice();
        });

        function CopyToClipboard(e) {
            var url = $(e).data('url');
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(url).select();
            try {
                document.execCommand("copy");
                AIZ.plugins.notify('success', '{{ translate('Link copied to clipboard') }}');
            } catch (err) {
                AIZ.plugins.notify('danger', '{{ translate('Oops, unable to copy') }}');
            }
            $temp.remove();
            // if (document.selection) {
            //     var range = document.body.createTextRange();
            //     range.moveToElementText(document.getElementById(containerid));
            //     range.select().createTextRange();
            //     document.execCommand("Copy");

            // } else if (window.getSelection) {
            //     var range = document.createRange();
            //     document.getElementById(containerid).style.display = "block";
            //     range.selectNode(document.getElementById(containerid));
            //     window.getSelection().addRange(range);
            //     document.execCommand("Copy");
            //     document.getElementById(containerid).style.display = "none";

            // }
            // AIZ.plugins.notify('success', 'Copied');
        }

        function show_chat_modal() {
            @if (Auth::check())
                $('#chat_modal').modal('show');
            @else
                $('#login_modal').modal('show');
            @endif
        }

        // Pagination using ajax
        $(window).on('hashchange', function() {
            if(window.history.pushState) {
                window.history.pushState('', '/', window.location.pathname);
            } else {
                window.location.hash = '';
            }
        });

        $(document).ready(function() {
            $(document).on('click', '.product-queries-pagination .pagination a', function(e) {
                getPaginateData($(this).attr('href').split('page=')[1], 'query', 'queries-area');
                e.preventDefault();
            });
        });

        $(document).ready(function() {
            $(document).on('click', '.product-reviews-pagination .pagination a', function(e) {
                getPaginateData($(this).attr('href').split('page=')[1], 'review', 'reviews-area');
                e.preventDefault();
            });
        });

        function getPaginateData(page, type, section) {
            $.ajax({
                url: '?page=' + page,
                dataType: 'json',
                data: {type: type},
            }).done(function(data) {
                $('.'+section).html(data);
                location.hash = page;
            }).fail(function() {
                alert('Something went worng! Data could not be loaded.');
            });
        }
        // Pagination end

        function showImage(photo) {
            $('#image_modal img').attr('src', photo);
            $('#image_modal img').attr('data-src', photo);
            $('#image_modal').modal('show');
        }

        function bid_modal(){
            @if (isCustomer() || isSeller())
                $('#bid_for_detail_product').modal('show');
          	@elseif (isAdmin())
                AIZ.plugins.notify('warning', '{{ translate("Sorry, Only customers & Sellers can Bid.") }}');
            @else
                $('#login_modal').modal('show');
            @endif
        }



    </script>
@endsection
