<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{  translate('INVOICE') }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="UTF-8">
	<style media="all">
        @page {
			margin: 0;
			padding:0;
		}
		body{
			font-size: 0.875rem;
            font-family: '<?php echo  $font_family ?>';
            font-weight: normal;
            direction: <?php echo  $direction ?>;
            text-align: <?php echo  $text_align ?>;
			padding:0;
			margin:0;
		}
		.gry-color *,
		.gry-color{
			color:#000;
		}
		table{
			width: 100%;
		}
		table th{
			font-weight: normal;
		}
		table.padding th{
			padding: .25rem .7rem;
		}
		table.padding td{
			padding: .25rem .7rem;
		}
		table.sm-padding td{
			padding: .1rem .7rem;
		}
		.border-bottom td,
		.border-bottom th{
			border-bottom:1px solid #eceff4;
		}
		.text-left{
			text-align:<?php echo  $text_align ?>;
		}
		.text-right{
			text-align:<?php echo  $not_text_align ?>;
		}
	</style>
</head>
<body>
	<div>

		@php
			$logo = get_setting('header_logo');
		@endphp

		<div style="background: #eceff4;padding: 1rem;">
			<table>
				<tr>
					<td>
						@if($logo != null)
							<img src="{{ uploaded_asset($logo) }}" height="30" style="display:inline-block;">
						@else
							<img src="{{ static_asset('assets/img/logo.png') }}" height="30" style="display:inline-block;">
						@endif
					</td>
					<td style="font-size: 1.5rem;" class="text-right strong">{{  translate('INVOICE') }}</td>
				</tr>
			</table>
			<table>
				<tr>
					<td style="font-size: 1rem;" class="strong">{{ get_setting('site_name') }}</td>
					<td class="text-right"></td>
				</tr>
				<tr>
					<td class="gry-color small">{{ get_setting('contact_address') }}</td>
					<td class="text-right"></td>
				</tr>
				<tr>
					<td class="gry-color small">{{  translate('Email') }}: {{ get_setting('contact_email') }}</td>
					<td class="text-right small"><span class="gry-color small">{{  translate('Order ID') }}:</span> <span class="strong">{{ $order->code }}</span></td>
				</tr>
				<tr>
					<td class="gry-color small">{{  translate('Phone') }}: {{ get_setting('contact_phone') }}</td>
					<td class="text-right small"><span class="gry-color small">{{  translate('Order Date') }}:</span> <span class=" strong">{{ date('d-m-Y', $order->date) }}</span></td>
				</tr>
				<tr>
					<td class="gry-color small"></td>
					<td class="text-right small">
                        <span class="gry-color small">
                            {{  translate('Payment method') }}:
                        </span>
                        <span class="strong">
                            {{ translate(ucfirst(str_replace('_', ' ', $order->payment_type))) }}
                        </span>
                    </td>
				</tr>
			</table>

		</div>



	    <div style="padding: 1rem;">
			<table class="padding text-left small border-bottom">
				<thead>
	                <tr class="gry-color" style="background: #eceff4;">
	                    <th width="35%" class="text-left">{{ translate('Hotel Name') }}</th>
						<th width="15%" class="text-left">{{ translate('Checkin Date') }}</th>
	                    <th width="10%" class="text-left">{{ translate('Number Of Guests') }}</th>
	                    <th width="15%" class="text-left">{{ translate('Price') }}</th>
	                    <th width="15%" class="text-right">{{ translate('Total') }}</th>
	                </tr>
				</thead>
				<tbody class="strong">

		                @if ($booking != null)
                            <tr class="">
                                <td>
                                    {{ $booking->hotel->name }}
                                </td>
                                <td>{{ $booking->check_in_date }}</td>
                                <td class="">{{ $booking->number_of_guests }}</td>
                                <td class="currency">{{ single_price($booking->room->price) }}</td>
                                <td class="currency">{{ single_price($booking->total_price) }}</td>
                            </tr>
		                @endif

	            </tbody>
			</table>
		</div>

	    <div style="padding:0 1.5rem;">
	        <table class="text-right sm-padding small strong">
	        	<thead>
	        		<tr>
	        			<th width="60%"></th>
	        			<th width="40%"></th>
	        		</tr>
	        	</thead>
		        <tbody>
			        <tr>
			            <td class="text-left">
                            @php
                                $removedXML = '<?xml version="1.0" encoding="UTF-8"?>';
                            @endphp
                            {!! str_replace($removedXML,"", QrCode::size(100)->generate($order->code)) !!}
			            </td>
			            <td>
					        <table class="text-right sm-padding small strong">
						        <tbody>
							        <tr>
							            <th class="gry-color text-left">{{ translate('Sub Total') }}</th>
							            <td class="currency">{{ single_price($booking->room->price) }}</td>
							        </tr>

							        <tr class="border-bottom">
							            <th class="gry-color text-left">{{ translate('Total Tax') }}</th>
							            <td class="currency">{{ single_price($order->orderDetails->sum('tax')) }}</td>
							        </tr>
				                    <tr class="border-bottom">
							            <th class="gry-color text-left">{{ translate('Coupon Discount') }}</th>
							            <td class="currency">{{ single_price($order->coupon_discount) }}</td>
							        </tr>
							        <tr>
							            <th class="text-left strong">{{ translate('Grand Total') }}</th>
							            <td class="currency">{{ single_price($order->grand_total) }}</td>
							        </tr>
						        </tbody>
						    </table>
			            </td>
			        </tr>
		        </tbody>
		    </table>
	    </div>

	</div>
</body>
</html>
