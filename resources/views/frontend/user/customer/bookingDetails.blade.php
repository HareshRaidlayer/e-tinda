@extends('frontend.layouts.user_panel')

@section('panel_content')

    <div class="row gutters-16">
        <div class="col-xl-12 col-md-6 mb-4">
            <a class="back-button" href="{{route('dashboard')}}"><i class="las la-angle-left fs-14"></i> Back</a>
            @if ($bookings)
            @foreach ($bookings as $booking)
            <div class="card mt-3 p-3">
                <table class="w-full">
                    <tr>
                        <td><p class="fs-18 fw-700 text-dark mb-1">Hotel Name: <span class="fs-16 fw-500">{{ $booking->hotel->name}}</span></p></td>
                        <td><p class="fs-18 fw-700 text-dark mb-1">Room Number: <span class="fs-16 fw-500">{{ $booking->room->room_number}}</span></p></td>
                        <td><a class="btn btn-soft-secondary-base btn-icon btn-circle btn-sm hov-svg-white mt-2 mt-sm-0" href="{{ route('invoice.booking',['order_id'=>$booking->id])}}" title="Download Invoice">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12.001" viewBox="0 0 12 12.001">
                                <g id="Group_24807" data-name="Group 24807" transform="translate(-1341 -424.999)">
                                  <path id="Union_17" data-name="Union 17" d="M13936.389,851.5l.707-.707,2.355,2.355V846h1v7.1l2.306-2.306.707.707-3.538,3.538Z" transform="translate(-12592.95 -421)" fill="#f3af3d"></path>
                                  <rect id="Rectangle_18661" data-name="Rectangle 18661" width="12" height="1" transform="translate(1341 436)" fill="#f3af3d"></rect>
                                </g>
                            </svg>
                        </a></td>
                    </tr>
                    <tr>
                        <td><p class="fs-18 fw-700 text-dark mb-1">CheckIn Date: <span class="fs-16 fw-500">{{ $booking->check_in_date}}</span></p></td>
                        <td><p class="fs-18 fw-700 text-dark mb-1">CheckOut Date: <span class="fs-16 fw-500">{{ $booking->check_out_date}}</span></p></td>
                    </tr>
                    <tr>
                        <td><p class="fs-18 fw-700 text-dark mb-1">Total Price: <span class="fs-16 fw-500">{{ single_price($booking->total_price)}}</span></p></td>
                        <td><p class="fs-18 fw-700 text-dark mb-1">Booking code: <span class="fs-16 fw-500 text-primary">{{ $booking->code}}</span></p></td>
                    </tr>
                </table>
            </div>
        @endforeach
            @else
            <p class="fs-18 fw-700 text-dark mb-1">Booking Details not found!</p>
            @endif

        </div>
    </div>
@endsection

@section('modal')
    <!-- Wallet Recharge Modal -->
    @include('frontend.partials.wallet_modal')
    <script type="text/javascript">
        function show_wallet_modal() {
            $('#wallet_modal').modal('show');
        }
    </script>

    <!-- Transfer Wallet Modal -->
    @include('frontend.partials.transfer_wallet_modal')
    <script type="text/javascript">
        function show_transfer_wallet_modal() {
            $('#transfer_wallet_modal').modal('show');
        }
    </script>

    <!-- Address modal Modal -->
    @include('frontend.partials.address.address_modal')
@endsection

@section('script')
    @include('frontend.partials.address.address_js')

    @if (get_setting('google_map') == 1)
        @include('frontend.partials.google_map')
    @endif
@endsection
