<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Modal</title>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>

<body>

    <!-- Modal -->
    <div class="modal fade" id="show_donate_money" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ translate('Donate Money') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body gry-bg px-3 pt-3" style="overflow-y: inherit;">
                    <form action="{{ route('church.donate',['church' => $church->id])}}" method="post">
                        @csrf
                        <input type="hidden" name="church_id" value="{{ $church->id }}">

                        @if (Auth::check() && get_setting('wallet_system') == 1)
                        <input type="hidden" id="valute_Balanse" value="{{Auth::user()->balance}}">
                        <div class="py-4 px-4 text-center bg-soft-secondary-base mt-4">
                            <div class="fs-14 mb-3">
                                <span class="opacity-80">{{ translate('Or, Your PowerPay eWallet balance :') }}</span>
                                <span class="fw-700">{{ single_price(Auth::user()->balance) }}</span>
                            </div>
                        </div>
                        @endif

                        {{-- <h1 class="mb-3 fs-16 fw-700 text-dark">
                            {{ translate('Select Church') }}
                        </h1>
                        <select class="form-control" name="church_branch">
                            <option value="">Select a Church Branch</option>
                            @foreach ($churchBranches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                            @endforeach
                        </select> --}}
                        <div class="row mb-3 mt-3">
                            <div class="col-md-4">
                                <label for="church_branch">{{ translate('Select a Church Branch') }} <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-control" name="church_branch">
                                    <option value="">Select a Church Branch</option>
                                    @foreach ($churchBranches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3 mt-3">
                            <div class="col-md-4">
                                <input type="hidden" name="payment_option" value="">
                                <label for="amount">{{ translate('Amount') }} <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-8">
                                <input type="number" id="amount" lang="en" class="form-control mb-3 rounded-0"
                                    name="amount" placeholder="{{ translate('Enter Amount') }}" required>
                            </div>
                        </div>

                        <div id="card-element" class="hidden mb-3">
                            <!-- A Stripe Element will be inserted here. -->
                        </div>
                        <div id="card-errors" role="alert" class="text-danger hidden"></div>

                        <div class="form-group text-right">
                            <button type="submit" id="submit-btn" class="btn btn-sm btn-primary rounded-0 transition-3d-hover mr-1" disabled>{{ translate('Confirm') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const amountInput = document.getElementById('amount');
            const submitBtn = document.getElementById('submit-btn');
            const walletBalance = parseFloat(document.getElementById('valute_Balanse').value);

            amountInput.addEventListener('input', function () {
                const amount = parseFloat(amountInput.value);
                if (amount <= walletBalance && !isNaN(amount)) {
                    submitBtn.disabled = false;
                } else {
                    submitBtn.disabled = true;
                }
            });
        });
    </script>

</body>

</html>
