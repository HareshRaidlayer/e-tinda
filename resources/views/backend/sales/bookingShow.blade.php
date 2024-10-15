@extends('backend.layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        <h1 class="h2 fs-16 mb-0">{{ translate('Booking Details') }}</h1>
    </div>

    <div class="card-body">
        <div class="row gutters-5">
            <div class="col text-md-left text-center">
            </div>
            @php
                $delivery_status = $order->delivery_status;
                $payment_status = $order->payment_status;
            @endphp
            @if (get_setting('product_manage_by_admin') == 0)
                <div class="col-md-3 ml-auto">
                    <label for="update_payment_status">{{ translate('Payment Status') }}</label>
                    @if (($order->payment_type == 'cash_on_delivery' || (addon_is_activated('offline_payment') == 1 && $order->manual_payment == 1)) && $payment_status == 'unpaid')
                        <select class="form-control aiz-selectpicker" data-minimum-results-for-search="Infinity"
                            id="update_payment_status">
                            <option value="unpaid" @if ($payment_status == 'unpaid') selected @endif>
                                {{ translate('Unpaid') }}</option>
                            <option value="paid" @if ($payment_status == 'paid') selected @endif>
                                {{ translate('Paid') }}</option>
                        </select>
                    @else
                        <input type="text" class="form-control" value="{{ translate($payment_status) }}" disabled>
                    @endif
                </div>
                <div class="col-md-3 ml-auto">
                    <label for="update_delivery_status">{{ translate('Booking Status') }}</label>
                    @if ($delivery_status != 'booked' && $delivery_status != 'cancelled')
                        <select class="form-control aiz-selectpicker" data-minimum-results-for-search="Infinity"
                            id="update_delivery_status">
                            <option value="pending" @if ($delivery_status == 'pending') selected @endif>
                                {{ translate('Pending') }}</option>
                            <option value="confirmed" @if ($delivery_status == 'confirmed') selected @endif>
                                {{ translate('Confirmed') }}</option>
                            <option value="booked" @if ($delivery_status == 'booked') selected @endif>
                                {{ translate('Booked') }}</option>
                            <option value="cancelled" @if ($delivery_status == 'cancelled') selected @endif>
                                {{ translate('Cancel') }}</option>
                        </select>
                    @else
                        <input type="text" class="form-control" value="{{ translate(ucfirst(str_replace('_', ' ', $delivery_status))) }}" disabled>
                    @endif
                </div>
            @endif
        </div>
        <div class="row gutters-5 mt-2">
            <div class="col text-md-left text-center">
                @if(json_decode($order->shipping_address))
                    <address>
                        <strong class="text-main">
                            {{ json_decode($order->shipping_address)->name }}
                        </strong><br>
                        {{ json_decode($order->shipping_address)->email ?? '' }}<br>
                        {{ json_decode($order->shipping_address)->phone ?? ''}}<br>
                        {{ json_decode($order->shipping_address)->country }}
                    </address>
                @else
                    <address>
                        <strong class="text-main">
                            {{ $order->user->name }}
                        </strong><br>
                        {{ $order->user->email }}<br>
                        {{ $order->user->phone }}<br>
                    </address>
                @endif
                @if ($order->manual_payment && is_array(json_decode($order->manual_payment_data, true)))
                    <br>
                    <strong class="text-main">{{ translate('Payment Information') }}</strong><br>
                    {{ translate('Name') }}: {{ json_decode($order->manual_payment_data)->name }},
                    {{ translate('Amount') }}:
                    {{ single_price(json_decode($order->manual_payment_data)->amount) }},
                    {{ translate('TRX ID') }}: {{ json_decode($order->manual_payment_data)->trx_id }}
                    <br>
                    <a href="{{ uploaded_asset(json_decode($order->manual_payment_data)->photo) }}"
                        target="_blank"><img
                            src="{{ uploaded_asset(json_decode($order->manual_payment_data)->photo) }}" alt=""
                            height="100"></a>
                @endif
            </div>
            <div class="col-md-4 ml-auto">
                <table>
                    <tbody>
                        <tr>
                            <td class="text-main text-bold">{{ translate('Order #') }}</td>
                            <td class="text-info text-bold text-right">{{ $order->code }}</td>
                        </tr>
                        <tr>
                            <td class="text-main text-bold">{{ translate('Order Status') }}</td>
                            <td class="text-right">
                                @if ($delivery_status == 'delivered')
                                    <span
                                        class="badge badge-inline badge-success">{{ translate(ucfirst(str_replace('_', ' ', $delivery_status))) }}</span>
                                @else
                                    <span
                                        class="badge badge-inline badge-info">{{ translate(ucfirst(str_replace('_', ' ', $delivery_status))) }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-main text-bold">{{ translate('Check in Date') }}</td>
                            <td class="text-right">{{ $booking->check_in_date }}</td>
                        </tr>
                        <tr>
                            <td class="text-main text-bold">{{ translate('Check Out Date') }}</td>
                            <td class="text-right">{{ $booking->check_out_date }}</td>
                        </tr>
                        <tr>
                            <td class="text-main text-bold">{{ translate('Total amount') }}</td>
                            <td class="text-right">
                                {{ single_price($order->grand_total) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-main text-bold">{{ translate('Payment method') }}</td>
                            <td class="text-right">
                                {{ translate(ucfirst(str_replace('_', ' ', $order->payment_type))) }}</td>
                        </tr>

                        <tr>
                            <td class="text-main text-bold">{{ translate('Additional Info') }}</td>
                            <td class="text-right">{{ $order->additional_info }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <hr class="new-section-sm bord-no">
        <div class="row">
            <div class="col-lg-12 table-responsive">
                <table class="table-bordered aiz-table invoice-summary table">
                    <thead>
                        <tr class="bg-trans-dark">
                            <th width="10%">{{ translate('Photo') }}</th>
                            <th class="text-uppercase">{{ translate('Hotel Name') }}</th>
                            <th  class="min-col text-uppercase text-center">
                                {{ translate('Number Of Rooms') }}
                            </th>
                            <th  class="min-col text-uppercase text-center">
                                {{ translate('Price') }}</th>
                            <th  class="min-col text-uppercase text-right">
                                {{ translate('Total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                @if ($booking->hotel->image != null)
                                    <a href=""><img height="50"
                                            src="{{ uploaded_asset($booking->hotel->image) }}"></a>
                                @else
                                    <strong>{{ translate('N/A') }}</strong>
                                @endif
                            </td>
                            <td>
                                @if ($booking->hotel->name)
                                    <strong>{{ $booking->hotel->name }}</strong>
                                @else
                                    <strong>{{ translate('Product Unavailable') }}</strong>
                                @endif
                            </td>
                            <td class="text-center">{{ $booking->number_of_rooms }}</td>
                            <td class="text-center">
                                {{ single_price($booking->room->price) }}</td>
                            <td class="text-center">{{ single_price($booking->total_price) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="clearfix float-right">
            <table class="table">
                <tbody>
                    <tr>
                        <td>
                            <strong class="text-muted">{{ translate('Sub Total') }} :</strong>
                        </td>
                        <td>
                            {{ single_price($booking->total_price) }}
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <strong class="text-muted">{{ translate('Coupon') }} :</strong>
                        </td>
                        <td>
                            {{ single_price($order->coupon_discount) }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong class="text-muted">{{ translate('TOTAL') }} :</strong>
                        </td>
                        <td class="text-muted h5">
                            {{ single_price($order->grand_total) }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="no-print text-right">
                <a href="{{ route('invoice.booking', $booking->id) }}" type="button"
                    class="btn btn-icon btn-light"><i class="las la-print"></i></a>
            </div>
        </div>

    </div>
</div>
@endsection

@section('modal')

    <!-- confirm payment Status Modal -->
    <div id="confirm-payment-status" class="modal fade">
        <div class="modal-dialog modal-md modal-dialog-centered" style="max-width: 540px;">
            <div class="modal-content p-2rem">
                <div class="modal-body text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="72" height="64" viewBox="0 0 72 64">
                        <g id="Octicons" transform="translate(-0.14 -1.02)">
                          <g id="alert" transform="translate(0.14 1.02)">
                            <path id="Shape" d="M40.159,3.309a4.623,4.623,0,0,0-7.981,0L.759,58.153a4.54,4.54,0,0,0,0,4.578A4.718,4.718,0,0,0,4.75,65.02H67.587a4.476,4.476,0,0,0,3.945-2.289,4.773,4.773,0,0,0,.046-4.578Zm.6,52.555H31.582V46.708h9.173Zm0-13.734H31.582V23.818h9.173Z" transform="translate(-0.14 -1.02)" fill="#ffc700" fill-rule="evenodd"/>
                          </g>
                        </g>
                    </svg>
                    <p class="mt-3 mb-3 fs-16 fw-700">{{translate('Are you sure you want to change the payment status?')}}</p>
                    <button type="button" class="btn btn-light rounded-2 mt-2 fs-13 fw-700 w-150px" data-dismiss="modal">{{ translate('Cancel') }}</button>
                    <button type="button" onclick="update_payment_status()" class="btn btn-success rounded-2 mt-2 fs-13 fw-700 w-150px">{{translate('Confirm')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script type="text/javascript">
        $('#assign_deliver_boy').on('change', function() {
            var order_id = {{ $order->id }};
            var delivery_boy = $('#assign_deliver_boy').val();
            $.post('{{ route('orders.delivery-boy-assign') }}', {
                _token: '{{ @csrf_token() }}',
                order_id: order_id,
                delivery_boy: delivery_boy
            }, function(data) {
                AIZ.plugins.notify('success', '{{ translate('Delivery boy has been assigned') }}');
            });
        });
        $('#update_delivery_status').on('change', function() {
            var order_id = {{ $order->id }};
            var status = $('#update_delivery_status').val();
            $.post('{{ route('orders.update_delivery_status') }}', {
                _token: '{{ @csrf_token() }}',
                order_id: order_id,
                status: status
            }, function(data) {
                AIZ.plugins.notify('success', '{{ translate('Delivery status has been updated') }}');
            });
        });

        // Payment Status Update
        function confirm_payment_status(value){
            $('#confirm-payment-status').modal('show');
        }

        function update_payment_status(){
            $('#confirm-payment-status').modal('hide');
            var order_id = {{ $order->id }};
            $.post('{{ route('orders.update_payment_status') }}', {
                _token: '{{ @csrf_token() }}',
                order_id: order_id,
                status: 'paid'
            }, function(data) {
                $('#update_payment_status').prop('disabled', true);
                AIZ.plugins.bootstrapSelect('refresh');
                AIZ.plugins.notify('success', '{{ translate('Payment status has been updated') }}');
            });
        }

        $('#update_tracking_code').on('change', function() {
            var order_id = {{ $order->id }};
            var tracking_code = $('#update_tracking_code').val();
            $.post('{{ route('orders.update_tracking_code') }}', {
                _token: '{{ @csrf_token() }}',
                order_id: order_id,
                tracking_code: tracking_code
            }, function(data) {
                AIZ.plugins.notify('success', '{{ translate('Order tracking code has been updated') }}');
            });
        });
    </script>
@endsection
