<div class="modal fade" id="show_donate_money" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ translate('Donate Money') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body gry-bg px-3 pt-3" style="overflow-y: inherit;">
                <form class="" action="{{ route('payment.checkout') }}" method="post">
                    @csrf
                    <div class="row">
                        <script src="https://js.stripe.com/v3/"></script>
                        <input type="hidden" name="church_id" value="{{$church->id}}">
                        <div class="col-md-4">
                            <label>{{ translate('Payment Method') }} <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-8">
                            <div class="mb-3">
                                <select class="form-control selectpicker rounded-0"
                                    data-minimum-results-for-search="Infinity" name="payment_option"
                                    data-live-search="true">
                                    @include('partials.online_payment_options')
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label>{{ translate('Amount') }} <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-8">
                            <input type="number" lang="en" class="form-control mb-3 rounded-0" name="amount"
                                placeholder="{{ translate('Enter Amount') }}" required>
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <button type="submit"
                            class="btn btn-sm btn-primary rounded-0 transition-3d-hover mr-1">{{ translate('Confirm') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
