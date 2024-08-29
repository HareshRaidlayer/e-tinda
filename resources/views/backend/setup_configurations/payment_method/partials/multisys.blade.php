<form class="form-horizontal" action="{{ route('payment_method.update') }}" method="POST">
    @csrf
    <input type="hidden" name="payment_method" value="multiPay">
    <div class="form-group row">
        <input type="hidden" name="types[]" value="MULTIPAY_TOKEN">
        <div class="col-md-4">
            <label class="col-from-label">{{ translate('MultiPay Token') }}</label>
        </div>
        <div class="col-md-8">
            <input type="text" class="form-control" name="MULTIPAY_TOKEN"
                value="{{ env('MULTIPAY_TOKEN') }}" placeholder="{{ translate('MultiPay Token') }}"
                required>
        </div>
    </div>
    <div class="form-group row">
        <input type="hidden" name="types[]" value="MULTIPAY_CODE">
        <div class="col-md-4">
            <label class="col-from-label">{{ translate('MultiPay Code') }}</label>
        </div>
        <div class="col-md-8">
            <input type="text" class="form-control" name="MULTIPAY_CODE"
                value="{{ env('MULTIPAY_CODE') }}" placeholder="{{ translate('MultiPay Code') }}"
                required>
        </div>
    </div>
    <div class="form-group mb-0 text-right">
        <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
    </div>
</form>
