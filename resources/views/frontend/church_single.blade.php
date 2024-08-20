@extends('frontend.layouts.app')

@section('content')
    <section class="mb-4 pt-3">
        <div class="container">
            <div class="bg-white py-3">
                <div class="row ">
                    <div class="col-xl-5 col-lg-6 mb-4">
                        <div class="sticky-top z-3 row gutters-10">
                            @foreach ($singleChurche as $church)
                            @endforeach
                            @if ($church->thumbnail_img != null)
                                @php
                                    $thumbnail_img = explode(',', $church->thumbnail_img);
                                @endphp
                                <!-- Gallery Images -->
                                <div class="col-12">
                                    <div class="aiz-carousel product-gallery arrow-lg-none"
                                        data-nav-for='.product-gallery-thumb' data-fade='true' data-auto-height='true'
                                        data-arrows='true'>
                                        @foreach ($thumbnail_img as $key => $photo)
                                            <div class="carousel-box img-zoom rounded-0">
                                                <img class="img-fluid h-auto lazyload mx-auto"
                                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                    data-src="{{ uploaded_asset($photo) }}"
                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <!-- Thumbnail Images -->
                                {{-- <div class="col-12 mt-3 d-none d-lg-block">
                                    <div class="aiz-carousel product-gallery-thumb" data-items='5'
                                        data-nav-for='.product-gallery' data-focus-select='true' data-arrows='true'
                                        data-vertical='false' data-auto-height='true'>
                                        @foreach ($thumbnail_img as $key => $photo)
                                            <div class="carousel-box c-pointer rounded-0">
                                                <img class="lazyload mw-100 size-60px mx-auto border p-1"
                                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                    data-src="{{ uploaded_asset($photo) }}"
                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                            </div>
                                        @endforeach
                                    </div>
                                </div> --}}
                            @endif
                        </div>
                    </div>

                    <div class="col-xl-7 col-lg-6">
                        <div class="text-left">
                            <!-- church Name -->
                            <h1 class="mb-3 fs-16 fw-700 text-dark">
                                {{ $church->name }}
                            </h1>
                            <div class="d-flex justify-content-end">
                                <button
                                    class="btn btn-block border border-soft-light bg-dark text-white mt-2 mt-md-2 mt-lg-2 mt-xl-4 mt-xxl-4 py-3"
                                    onclick="show_donate_money_modal()"
                                    style="border-radius: 30px; background: rgba(255, 255, 255, 0.1);">
                                    {{ translate('Donate Money') }}
                                </button>
                            </div>

                            {{-- church description --}}
                            <div class="nav aiz-nav-tabs mt-4">
                                <a href="#tab_default_1" data-toggle="tab"
                                    class="mr-5 pb-2 fs-16 fw-700 text-reset  show">{{ translate('Description') }}</a>
                            </div>

                            <div class="tab-content pt-0">
                                <!-- Description -->
                                <div class="tab-pane active show" id="tab_default_1">
                                    <div class="p-2">
                                        <h3 class="fw-400 fs-18  text-start">
                                            {{ strip_tags(html_entity_decode($church->description)) }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Other products -->
    {{-- <section class="mb-4">
        <div class="container">
            <div class="text-left mt-3">
                <div class="row gutters-5 flex-wrap align-items-center">
                    <div class="col-lg col-10">
                        <h1 class="fs-20 fs-md-24 fw-700 text-dark">
                            {{ translate('More Donation Church') }}
                        </h1>
                    </div>
                </div>
            </div>
            <div class="row gutters-16 mt-4">
                <!-- Flash Deals Products -->
                <div class="col-xxl-12 col-lg-12">
                    <div class="px-3 z-5">
                        <div
                            class="row row-cols-xxl-3 row-cols-xl-3 row-cols-md-3 row-cols-sm-2 row-cols-2 gutters-16 border-top border-left">
                            @foreach ($churches as $church)
                                @php
                                    $church_url = route('church.single', $church->id);
                                @endphp
                                <div class="col text-center border-right border-bottom has-transition hov-shadow-out z-1">
                                    <div class="aiz-card-box h-auto bg-white py-3 hov-scale-img">
                                        <div class="position-relative h-140px h-md-200px img-fit overflow-hidden">
                                            <!-- Image -->
                                            <a href="{{ $church_url }}" class="d-block h-100">
                                                <img class="lazyload mx-auto img-fit has-transition"
                                                    src="{{ uploaded_asset($church->thumbnail_img) }}"
                                                    alt="{{ $church->name }}" title="{{ $church->name }}">
                                            </a>
                                        </div>

                                        <div class="p-2 p-md-3 text-left">
                                            <!-- Product name -->
                                            <h1 class="fw-400 fs-16 text-truncate-2 lh-1-4 mb-0 h-35px text-center">
                                                <a href="{{ $church_url }}" class="d-block text-reset hov-text-primary"
                                                    title="{{ $church->name }}">{{ $church->name }}</a>
                                            </h1>
                                            <h3 class="fw-400 fs-14 text-truncate-2 lh-1-4 mb-0 h-35px text-center">
                                                <a href="{{ $church_url }}" class="d-block text-reset hov-text-primary"
                                                    title="{{ strip_tags(html_entity_decode($church->description)) }}">
                                                    {{ Str::limit(strip_tags(html_entity_decode($church->description)), 30, '...') }}
                                                </a>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
@endsection
@section('modal')
    <!-- Transfer Wallet Modal -->
    @include('frontend.partials.show_donate_money')
    <script type="text/javascript">
        function show_donate_money_modal() {
            $('#show_donate_money').modal('show');
        }
    </script>
@endsection


@section('script')
    <script type="text/javascript">
        function show_number(el) {
            $(el).find('.dummy').addClass('d-none');
            $(el).find('.real').removeClass('d-none').addClass('d-block');
        }
    </script>
@endsection
