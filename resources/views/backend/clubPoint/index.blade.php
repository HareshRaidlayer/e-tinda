@extends('backend.layouts.app')

@section('content')
    <div class="aiz-main-content">
        <div class="px-15px px-lg-25px">

            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Convert Point To PowerPay eWallet') }}</h5>
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal"
                                action="{{ route('product_point.update', ['id' => $clubPoint->id]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="type" value="club_point_convert_rate">
                                <div class="form-group row">
                                    <div class="col-lg-4">
                                        <label class="col-from-label fs-15">{{ translate('Set Point For') }}
                                            {{ single_price(1) }}</label>
                                    </div>
                                    <div class="col-lg-5">
                                        <input type="number" min="0" step="0.01" class="form-control"
                                            name="value" value="{{ $clubPoint->value }}" placeholder="10" required="">
                                    </div>
                                    <div class="col-lg-3">
                                        <label class="col-from-label fs-15">{{ translate('Points') }}</label>
                                    </div>
                                </div>
                                <div class="form-group mb-3 text-right">
                                    <button type="submit"
                                        class="btn btn-sm btn-primary fs-15">{{ translate('Save') }}</button>
                                </div>
                            </form>
                            {{-- <i class="fs-12"><b>{{ translate('Note: You need to activate wallet option first before using club point
                                    addon.') }}</b></i> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
