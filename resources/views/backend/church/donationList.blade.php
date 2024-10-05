@extends('backend.layouts.app')

@section('content')
<style>
    .bd-indigo-200 {
    color: #fff;
    background-color: #c29ffa;
    }
    .bd-pink-300 {
        color: #fff;
        background-color: #e685b5;
    }
</style>

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-auto">
                <h1 class="h3">{{ translate('All Donation') }}</h1>
            </div>
        </div>
    </div>
    <br>
<?php # print_r($churches);exit;?>
    <div class="row">
        @php
            $count=1;
        @endphp
        @foreach ($churches as $church)
            <div class="col-2">
                @php
                  $className = ($count % 2 == 0) ? "bd-indigo-200" : "bd-pink-300";
                @endphp
                <div class="card p-2  {{$className}}">
                    <p>{{$church['name']}}</p>
                    <p>Total Amount to Donate : <span class="fs-13  fw-700 text-white"> {{$church['total_donations'] ?? 0}} </span></p>
                    <a class="p-1 text-center but btn-info"> Clear Donation</a>
                    <p>Click this button to Clear Donation</p>

                </div>
            </div>
            @php
            $count++;
        @endphp
        @endforeach


    </div>
    <div class="card">

        <form class="" id="sort_products" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col">
                    <h5 class="mb-md-0 h6">{{ translate('All Donation') }}</h5>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-0">
                        <select class="form-control form-control-sm" name="donation_status" id="donation_status">
                            <option value="">{{ translate('Select Donation status') }}</option>
                            <option value="0" {{ isset($donation_status) && $donation_status == '0' ? 'selected' : '' }}>
                                {{ translate('Pending') }}
                            </option>
                            <option value="1" {{ isset($donation_status) && $donation_status == '1' ? 'selected' : '' }}>
                                {{ translate('Success') }}
                            </option>
                        </select>
                    </div>
                </div>

                @can('product_delete')
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
                            <th >{{ translate('Name') }}</th>
                            <th>{{ translate('Amount') }}</th>
                            <th>{{ translate('User id') }}</th>
                            <th>{{ translate('Donation status') }}</th>
                            <th data-breakpoints="sm" class="text-right">{{ translate('Options') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($donations as $key => $donation)
                            <tr>
                                <td>
                                    <div class="form-group d-inline-block">
                                        <label class="aiz-checkbox">
                                            <input type="checkbox" class="check-one" name="id[]"
                                                value="{{ $donation->id }}">
                                            <span class="aiz-square-check"></span>
                                        </label>
                                    </div>
                                </td>

                                <td>
                                    <span class="text-muted text-truncate-2">{{ $donation->church_name }}</span>
                                </td>

                                <td>
                                    <span class="text-muted text-truncate-2">{{ $donation->amount }}</span>
                                </td>
                                <td>
                                    <span class="text-muted text-truncate-2">{{ $donation->user_id }}</span>
                                </td>
                                <td>
                                    @if ($donation->is_donatated == 0)
                                        <span class="badge badge-inline badge-warning text-white">Pending</span>
                                    @else
                                    <span class="badge badge-inline badge-success text-white">Success</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    @can('product_delete')
                                        <a href="" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                            data-href="{{ route('church.donationdelete', $donation->id) }}"
                                            title="{{ translate('Delete') }}">
                                            <i class="las la-trash"></i>
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
$(document).ready(function(){
    $('#donation_status').on('change', function() {
        $('#sort_products').submit();
    });
})

</script>

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

    $(document).ready(function() {
        //$('#container').removeClass('mainnav-lg').addClass('mainnav-sm');
    });

    function bulk_delete() {
        var data = new FormData($('#sort_products')[0]);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('bulk-product-delete') }}",
            type: 'POST',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response == 1) {
                    location.reload();
                }
            }
        });
    }
</script>
@endsection
