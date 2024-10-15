@extends('seller.layouts.app')

@section('panel_content')
    <div class="aiz-titlebar mt-2 mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{ translate('Hotel booking') }}</h1>
            </div>
        </div>
    </div>


    <div class="card">
        <form class="" id="sort_hotels" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col">
                    <h5 class="mb-md-0 h6">{{ translate('All Hotel booking') }}</h5>
                </div>

                @can('hotels_delete')
                    <div class="dropdown mb-2 mb-md-0">
                        <button class="btn border dropdown-toggle" type="button" data-toggle="dropdown">
                            {{ translate('Bulk Action') }}
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item confirm-alert" href="javascript:void(0)" data-target="#bulk-delete-modal">
                                {{ translate('Delete selection') }}</a>
                        </div>
                    </div>
                @endcan
                <div class="col-md-2">
                    <div class="form-group mb-0">
                        <input type="text" class="form-control form-control-sm" id="search"
                            name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset
                            placeholder="{{ translate('Type & Enter') }}">
                    </div>
                </div>
            </div>

            <div class="card-body">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>
                                <div class="form-group">
                                    <div class="aiz-checkbox-inline">
                                        <label class="aiz-checkbox">
                                            <input type="checkbox" class="check-all">
                                            <span class="aiz-square-check"></span>
                                        </label>
                                    </div>
                                </div>
                            </th>
                            <th  class="text-right">{{ translate('FullName') }}</th>
                            <th>{{ translate('Booking code') }}</th>
                            <th >{{ translate('CheckIn Date') }}</th>
                            <th >{{ translate('Total Price') }}</th>
                            <th class="text-center">{{ translate('Action') }}</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookingDetails as $key => $hotel)
                            <tr>
                                <td>
                                    <div class="form-group d-inline-block">
                                        <label class="aiz-checkbox">
                                            <input type="checkbox" class="check-one" name="id[]"
                                                value="{{ $hotel->id }}">
                                            <span class="aiz-square-check"></span>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-muted text-truncate-2">{{ $hotel->full_name }}</span>
                                </td>
                                <td>
                                    <span class="text-muted text-truncate-2">{{ $hotel->code }}</span>
                                </td>
                                <td>
                                    <span class="text-muted text-truncate-2">{{ $hotel->check_in_date }}</span>
                                </td>
                                <td>
                                    <span class="text-muted text-truncate-2">{{ $hotel->grand_total }}</span>
                                </td>

                                <td class="text-right">
                                    <a href="{{ route('seller.hotelBookingDetails', encrypt($hotel->id)) }}"
                                        class="btn btn-soft-info btn-icon btn-circle btn-sm"
                                        title="{{ translate('Order Details') }}">
                                        <i class="las la-eye"></i>
                                    </a>
                                    <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                        data-href=""
                                        title="{{ translate('Delete') }}">
                                        <i class="las la-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination">
                    {{ $bookingDetails->links() }}
                </div>
            </div>
        </form>
    </div>
@endsection

@section('modal')
    <!-- Delete modal -->
    @include('modals.delete_modal')
    <!-- Bulk Delete modal -->
    @include('modals.bulk_delete_modal')
@endsection

@section('script')

    <script type="text/javascript">
        $(document).on("change", ".check-all", function() {
            if (this.checked) {
                // Iterate each checkbox
                $('.check-one:checkbox').each(function() {
                    this.checked = true;
                });
            } else {
                $('.check-one:checkbox').each(function() {
                    this.checked = false;
                });
            }

        });



    </script>
@endsection
