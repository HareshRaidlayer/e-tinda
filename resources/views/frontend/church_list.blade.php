@extends('frontend.layouts.app')

@section('content')
    <section class="mb-5 mt-3">
        <div class="container">
            <div class="text-left mt-3">
                <div class="row gutters-5 flex-wrap align-items-center">
                    <div class="col-lg col-10">
                        <h1 class="fs-20 fs-md-24 fw-700 text-dark">
                            {{ translate('All Donation Church') }}
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
    </section>
@endsection
