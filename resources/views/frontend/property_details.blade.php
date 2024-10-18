@extends('frontend.layoutsShopee.app')



@section('meta')
@endsection

@section('content')
    <style>
        .aiz-refresh {
            display: none;
        }
    </style>
    <section class="mb-4 pt-3">
        <div class="container">
            <div class="bg-white py-3">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="row">
                    <!-- Product Image Gallery -->
                    <div class="col-xl-5 col-lg-6 mb-4">
                        <div class="sticky-top z-3 row gutters-10">

                            <!-- Gallery Images -->
                            <div class="col-12">
                                <div class="aiz-carousel product-gallery arrow-inactive-transparent arrow-lg-none"
                                    data-nav-for='.service-gallery-thumb' data-fade='true' data-auto-height='true'
                                    data-arrows='true'>
                                    @if ($hotels)
                                        {{-- @foreach ($detailedService as $key => $stock)
                                            @if ($stock->image != null) --}}
                                        <div class="carousel-box img-zoom rounded-0">
                                            <img class="img-fluid h-auto lazyload mx-auto"
                                                src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                data-src="{{ uploaded_asset($hotels->image) }}"
                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                        </div>
                                        {{-- @endif
                                        @endforeach --}}
                                    @endif



                                </div>
                            </div>
                            <!-- Thumbnail Images -->
                            <div class="col-12 mt-3 d-none d-lg-block">
                                <div class="aiz-carousel half-outside-arrow product-gallery-thumb" data-items='7'
                                    data-nav-for='.product-gallery' data-focus-select='true' data-arrows='true'
                                    data-vertical='false' data-auto-height='true'>
                                </div>
                            </div>


                        </div>
                    </div>

                    <!-- Product Details -->
                    <div class="col-xl-7 col-lg-6">
                        <div class="text-left">
                            <!-- Product Name -->
                            <h2 class="mb-4 fs-16 fw-700 text-dark">
                                {{ $hotels->name }}
                            </h2>
                            <p>{{ $hotels->description }} </p>

                            <!-- In stock -->

                        </div>

                        <div class="d-flex flex-wrap align-items-center mb-1">
                            <span class="text-secondary fs-14 fw-400 mr-4 ">Address</span><br>
                            <a class="text-reset hov-text-primary fs-14 fw-700">{{ $hotels->address ?? '' }}</a>
                        </div>
                        <div class="d-flex flex-wrap align-items-center mb-1">
                            <span class="text-secondary fs-14 fw-400 mr-4 ">City</span><br>
                            <a class="text-reset hov-text-primary fs-14 fw-700">{{ get_city_name($hotels->city) }}</a>
                        </div>
                        <div class="d-flex flex-wrap align-items-center mb-3">
                            <span class="text-secondary fs-14 fw-400 mr-4 ">State</span><br>
                            <a class="text-reset hov-text-primary fs-14 fw-700">{{ get_state_name($hotels->state) }}</a>
                        </div>
                        <div class="d-flex flex-wrap align-items-center mb-3">
                            <span class="text-secondary fs-14 fw-400 mr-4 ">Country</span><br>
                            <a class="text-reset hov-text-primary fs-14 fw-700">
                                {{ get_country_name($hotels->country) }}</a>
                        </div>
                        <hr>

                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

    <section class="container mb-4">
        <div class="row gutters-16">
            <div class="col-lg-12">
                <div class="bg-white mb-4 border p-3 p-sm-4">
                    <p class="mr-5 pb-2 fs-16 fw-700 text-reset active show">Rooms Details</p>

                    <!-- Description -->
                    @foreach ($hotels->rooms as $room)
                        <div class="card">
                            <div class="row">
                                <div class="col-4">
                                    <img class="img-fluid w-100 lazyload "
                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                        data-src="{{ uploaded_asset($room->images) }}"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                </div>
                                <div class="col-7">
                                    <div class="py-3">
                                        <p class="mr-5 pb-2 fs-16 fw-700 text-reset active show">{{ $room->room_number }}
                                        </p>
                                        <p>{!! $room->description ?? '' !!}</p>
                                        <p class="mr-5 pb-2 fs-16 fw-700 text-reset">{{ single_price($room->price) }} <span
                                                class="fs-14 fw-500">/room /day</span></p>
                                        <div class="mt-3">
                                            <button type="button"
                                                class="btn btn-primary buy-now fw-600 add-to-cart min-w-150px rounded-0"
                                                @if (Auth::check() || get_Setting('guest_checkout_activation') == 1) onclick="bookRooms({{ $room->id }})" @else onclick="showLoginModal()" @endif>
                                                Book This Room
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection

@section('modal')
    <!-- Product Review Modal -->
    <div class="modal fade" id="product-review-modal">
        <div class="modal-dialog">
            <div class="modal-content" id="product-review-modal-content">

            </div>
        </div>
    </div>

    <div class="modal fade" id="bookingModel">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size"
            role="document">
            <div class="modal-content position-relative">
                <button type="button"
                    class="close absolute-top-right btn-icon close z-1 btn-circle bg-gray mr-2 mt-2 d-flex justify-content-center align-items-center"
                    data-dismiss="modal" aria-label="Close"
                    style="background: #ededf2; width: calc(2rem + 2px); height: calc(2rem + 2px);">
                    <span aria-hidden="true" class="fs-24 fw-700" style="margin-left: 2px;">&times;</span>
                </button>
                <div class="modal-body px-4 py-5 c-scrollbar-light">
                    <form action="{{ route('propertyBooking') }}" method="POST">
                        @csrf
                        <input type="hidden" name="room_id" id="hotel_room_id" value="">
                        <input type="hidden" name="hotel_id" value="{{ $hotels->id }}">
                        <input type="hidden" name="price" value="{{ $room->price ?? '' }}">
                        <input type="hidden" name="owner_id" value="{{ $hotels->user_id }}">
                        <div class="d-flex">
                            <div class="w-100">
                                <label class="col-lg-8 col-form-label">{{ translate('No of Rooms') }}</label>
                                <div class="col-lg-8 mb-2">
                                    <input type="number" class="form-control" name="noOfRooms"
                                        placeholder="{{ translate('No of Rooms') }}" required>
                                </div>
                            </div>
                            <div class="w-100">
                                <label class="col-lg-8 col-form-label">{{ translate('No of guests') }}</label>
                                <div class="col-lg-8 mb-2">
                                    <input type="number" class="form-control" name="noOfGuests"
                                        placeholder="{{ translate('No of guests') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="w-100">
                                <label class="col-lg-8 col-form-label">{{ translate('Check In') }}</label>
                                <div class="col-lg-8 mb-2">
                                    <input type="date" class="form-control" id="checkIn" name="check_in_date"
                                        min="{{ date('Y-m-d') }}" placeholder="{{ translate('Check In') }}"
                                        value="<?= date('Y-m-d') ?>" required>
                                </div>
                            </div>
                            <div class="w-100">
                                <label class="col-lg-8 col-form-label">{{ translate('Check Out') }}</label>
                                <div class="col-lg-8 mb-2">
                                    <input type="date" class="form-control" id="checkOut" name="check_out_date"
                                        min="{{ date('Y-m-d') }}" placeholder="{{ translate('Check Out') }}" required>
                                    <span id="dateError" class="text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="w-100">
                                <label class="col-lg-8 col-form-label">{{ translate('First Name') }}</label>
                                <div class="col-lg-8 mb-2">
                                    <input type="text" class="form-control" name="firstName"
                                        placeholder="{{ translate('First Name') }}" required>
                                </div>
                            </div>
                            <div class="w-100">
                                <label class="col-lg-8 col-form-label">{{ translate('Last Name') }}</label>
                                <div class="col-lg-8 mb-2">
                                    <input type="text" class="form-control" name="lastName"
                                        placeholder="{{ translate('Last Name') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="w-100">
                                <label class="col-lg-8 col-form-label">{{ translate('Email') }}</label>
                                <div class="col-lg-8 mb-2">
                                    <input type="email" class="form-control" name="email"
                                        placeholder="{{ translate('Email') }}" required>
                                </div>
                            </div>
                            <div class="w-100">
                                <label class="col-lg-8 col-form-label">{{ translate('Phone') }}</label>
                                <div class="col-lg-8 mb-2">
                                    <input type="number" class="form-control" name="phone"
                                        placeholder="{{ translate('Phone') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex mt-4">
                            <div class="col-lg-10 mb-2 text-right">
                                <button type="submit" id="submitBtn"
                                    class="btn btn-primary buy-now fw-600 add-to-cart min-w-150px rounded-0">
                                    Book Now
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
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
            if (window.history.pushState) {
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
                data: {
                    type: type
                },
            }).done(function(data) {
                $('.' + section).html(data);
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

        function bid_modal() {
            @if (isCustomer() || isSeller())
                $('#bid_for_detail_product').modal('show');
            @elseif (isAdmin())
                AIZ.plugins.notify('warning', '{{ translate('Sorry, Only customers & Sellers can Bid.') }}');
            @else
                $('#login_modal').modal('show');
            @endif
        }
    </script>

    <script>
        function bookRooms($id) {
            var model = $('#bookingModel').modal();
            $('#hotel_room_id').val($id);
            model.show();
        }
    </script>
    <script>
        document.getElementById('checkOut').addEventListener('change', function() {
            const checkInDate = new Date(document.getElementById('checkIn').value);
            const checkOutDate = new Date(document.getElementById('checkOut').value);
            const dateError = document.getElementById('dateError');
            const submitBtn = document.getElementById('submitBtn');

            // Check if the Check Out date is greater than the Check In date
            if (checkOutDate <= checkInDate) {
                dateError.textContent = "Check Out date must be greater than Check In date.";
                submitBtn.disabled = true; // Disable the submit button
            } else {
                dateError.textContent = ""; // Clear any error message
                submitBtn.disabled = false; // Enable the submit button
            }
        });

        document.getElementById('checkIn').addEventListener('change', function() {
            const checkInDate = new Date(document.getElementById('checkIn').value);
            const checkOutDate = new Date(document.getElementById('checkOut').value);
            const dateError = document.getElementById('dateError');
            const submitBtn = document.getElementById('submitBtn');

            // Check if the Check Out date is greater than the Check In date
            if (checkOutDate <= checkInDate) {
                dateError.textContent = "Check Out date must be greater than Check In date.";
                submitBtn.disabled = true; // Disable the submit button
            } else {
                dateError.textContent = ""; // Clear any error message
                submitBtn.disabled = false; // Enable the submit button
            }
        });
    </script>
@endsection
