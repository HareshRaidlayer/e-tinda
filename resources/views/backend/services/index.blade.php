@extends('backend.layouts.app')

@section('content')
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-auto">
                <h1 class="h3">{{ translate('All Services') }}</h1>
            </div>
        </div>
    </div>

    <div class="card">
        <form class="" id="sort_products" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col">
                    <h5 class="mb-md-0 h6">{{ translate('All Services') }}</h5>
                </div>
            </div>
            <div class="card-body">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <th width="30%">{{ translate('Name') }}</th>
                            {{-- <th data-breakpoints="md">{{ translate('Category')}}</th> --}}
                            <th>{{ translate('Base Price') }}</th>
                            <th>{{ translate('Redeem Points') }}</th>
                            <th data-breakpoints="md">{{ translate('Warranty') }}</th>
                            <th data-breakpoints="md">{{ translate('Status') }}</th>
                            <th data-breakpoints="md" class="text-right">{{ translate('Options') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($services as $key => $product)
                            @php
                                $product_id = $product['id'];
                            @endphp
                            <tr>
                                <td>
                                    <a href="{{ route('service', $product['slug']) }}" target="_blank" class="text-reset">
                                        {{ $product['name'] }}
                                    </a>
                                </td>

                                <td>{{ $product['price'] }}</td>
                                <td>{{ $product['earn_point'] }}</td>
                                <td>{{ $product['warranty'] }}</td>

                                <td>
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input onchange="update_featured(this)" value="{{ $product_id }}" type="checkbox"
                                            <?php if ($product['status'] == 1) {
                                                echo 'checked';
                                            } ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </td>

                                <td class="text-right">
                                    <a class="btn btn-soft-info btn-icon btn-circle btn-sm"
                                        href="{{ route('service.edit', ['id' => $product_id, 'lang' => env('DEFAULT_LANGUAGE')]) }}"
                                        title="{{ translate('Edit') }}">
                                        <i class="las la-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        function update_featured(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('service.featured') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function(data) {
                if (data == 1) {
                    AIZ.plugins.notify('success', '{{ translate('Status updated successfully') }}');
                } else {
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                    location.reload();
                }
            });
        }
    </script>
@endsection
