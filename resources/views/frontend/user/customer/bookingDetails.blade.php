@extends('frontend.layouts.user_panel')

@section('panel_content')
    <div class="row gutters-16">
        <div class="col-xl-12 col-md-6 mb-4">
            @foreach ($bookings as $booking)
                <div class="card mt-3 p-3">
                    <table class="w-full">
                        <tr>
                            <td><p class="fs-18 fw-700 text-dark mb-1">Hotel Name: <span class="fs-16 fw-500">{{ $booking->hotel->name}}</span></p></td>
                            <td><p class="fs-18 fw-700 text-dark mb-1">Room Number: <span class="fs-16 fw-500">{{ $booking->room->room_number}}</span></p></td>
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
