@extends('backend.layouts.app')

@section('content')

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-auto">
                <h1 class="h3">{{ translate('All Church') }}</h1>
            </div>
            @if ($type != 'Seller' && auth()->user()->can('add_new_product'))
                <div class="col text-right">
                    <a href="{{ route('church.create') }}" class="btn btn-circle btn-info">
                        <span>{{ translate('Add New Church') }}</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
    <br>

    <div class="card">
        <form class="" id="sort_products" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col">
                    <h5 class="mb-md-0 h6">{{ translate('All Church') }}</h5>
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

                @if ($type == 'Seller')
                    <div class="col-md-2 ml-auto">
                        <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" id="user_id"
                            name="user_id" onchange="sort_products()">
                            <option value="">{{ translate('All Sellers') }}</option>
                            @foreach (App\Models\User::where('user_type', '=', 'seller')->get() as $key => $seller)
                                <option value="{{ $seller->id }}" @if ($seller->id == $seller_id) selected @endif>
                                    {{ $seller->shop->name }} ({{ $seller->name }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif
                @if ($type == 'All' && get_setting('vendor_system_activation') == 1)
                    <div class="col-md-2 ml-auto">
                        <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" id="user_id"
                            name="user_id" onchange="sort_products()">
                            <option value="">{{ translate('All Sellers') }}</option>
                            @foreach (App\Models\User::where('user_type', '=', 'admin')->orWhere('user_type', '=', 'seller')->get() as $key => $seller)
                                <option value="{{ $seller->id }}" @if ($seller->id == $seller_id) selected @endif>
                                    {{ $seller->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
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
                            @if (auth()->user()->can('product_delete'))
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
                            @else
                                <th data-breakpoints="lg">#</th>
                            @endif
                            <th>{{ translate('Name') }}</th>
                            <th data-breakpoints="lg">{{ translate('Added By') }}</th>
                            <th data-breakpoints="lg">{{ translate('Published') }}</th>
                            <th data-breakpoints="sm" class="text-right">{{ translate('Options') }}</th>
                            {{-- <th data-breakpoints="md">{{ translate('Total Stock') }}</th>
                            <th data-breakpoints="lg">{{ translate('Todays Deal') }}</th>
                            @if (get_setting('product_approve_by_admin') == 1 && $type == 'Seller')
                                <th data-breakpoints="lg">{{ translate('Approved') }}</th>
                            @endif
                            <th data-breakpoints="lg">{{ translate('Featured') }}</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($churches as $key => $product)
                            <tr>
                                @if (auth()->user()->can('product_delete'))
                                    <td>
                                        <div class="form-group d-inline-block">
                                            <label class="aiz-checkbox">
                                                <input type="checkbox" class="check-one" name="id[]"
                                                    value="{{ $product->id }}">
                                                <span class="aiz-square-check"></span>
                                            </label>
                                        </div>
                                    </td>
                                @else
                                    <td>{{ $key + 1 + ($churches->currentPage() - 1) * $churches->perPage() }}</td>
                                @endif
                                <td>
                                    <div class="row gutters-5 w-200px w-md-300px mw-100">
                                        <div class="col-auto">
                                            <img src="{{ uploaded_asset($product->thumbnail_img) }}" alt="Image"
                                                class="size-50px img-fit">
                                        </div>
                                        <div class="col">
                                            <span class="text-muted text-truncate-2">{{ $product->name }}</span>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <span class="text-muted text-truncate-2">{{ $product->added_by }}</span>
                                </td>
                                <td>
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input onchange="update_published(this)" value="{{ $product->id }}"
                                            type="checkbox" {{ $product->status == 1 ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                                <td class="text-right">
                                    {{-- <a class="btn btn-soft-success btn-icon btn-circle btn-sm"
                                        href="{{ route('product', $product->slug) }}" target="_blank"
                                        title="{{ translate('View') }}">
                                        <i class="las la-eye"></i>
                                    </a> --}}
                                    @can('product_edit')
                                        @if ($type == 'Seller')
                                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                                href="{{ route('church.edit', ['id' => $product->id]) }}"
                                                title="{{ translate('Edit') }}">
                                                <i class="las la-edit"></i>
                                            </a>
                                        @else
                                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                                href="{{ route('church.edit', ['id' => $product->id]) }}"
                                                title="{{ translate('Edit') }}">
                                                <i class="las la-edit"></i>
                                            </a>
                                        @endif
                                    @endcan
                                    {{-- @php
                                        $product_url = route('church.index');
                                    @endphp
                                    @can('product_duplicate')
                                        <a class="btn btn-soft-warning btn-icon btn-circle btn-sm" href="javascript:void(0);"
                                            title="{{ translate('Copy Link') }}"
                                            onclick="copyProductUrl('{{ $product_url }}')">
                                            <i class="las la-copy"></i>
                                        </a>
                                    @endcan --}}
                                    @can('product_delete')
                                        <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                            data-href="{{ route('church.destroy', $product->id) }}"
                                            title="{{ translate('Delete') }}">
                                            <i class="las la-trash"></i>
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- <div class="aiz-pagination">
                    {{ $products->appends(request()->input())->links() }}
                </div> --}}
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

        $(document).ready(function() {
            //$('#container').removeClass('mainnav-lg').addClass('mainnav-sm');
        });

        function update_todays_deal(el) {

            if ('{{ env('DEMO_MODE') }}' == 'On') {
                AIZ.plugins.notify('info', '{{ translate('Data can not change in demo mode.') }}');
                return;
            }

            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('products.todays_deal') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function(data) {
                if (data == 1) {
                    AIZ.plugins.notify('success', '{{ translate('Todays Deal updated successfully') }}');
                } else {
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }

        function update_published(el) {
            var status = el.checked ? 1 : 0;

            $.post('{{ route('church.published') }}', {
                    _token: '{{ csrf_token() }}',
                    id: el.value,
                    status: status
                })
                .done(function(data) {
                    if (data == 1) {
                        AIZ.plugins.notify('success', '{{ translate('Published church updated successfully') }}');
                    } else {
                        AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                    }
                })
                .fail(function(xhr, status, error) {
                    console.error('Error:', error);
                    console.error('Status:', status);
                    console.error('Response:', xhr.responseText);
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                });
        }

        function sort_products(el) {
            $('#sort_products').submit();
        }

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
