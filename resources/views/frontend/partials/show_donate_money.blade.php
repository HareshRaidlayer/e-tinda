<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Modal</title>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <style>
        .hidden { display: none; }
    </style>
</head>
<body>

<!-- Modal -->
<div class="modal fade" id="show_donate_money" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ translate('Donate Money') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body gry-bg px-3 pt-3" style="overflow-y: inherit;">
                <form id="payment-form">
                    @csrf
                    <input type="hidden" name="church_id" value="{{ $church->id }}">

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="payment_option">{{ translate('Payment Method') }} <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-8">
                            <div class="mb-3">
                                <select id="payment_option" class="form-control rounded-0" name="payment_option" required>
                                    <option selected>select payment option</option>
                                    <option value="stripe">Stripe</option>
                                    <option value="razorpay">Razorpay</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="amount">{{ translate('Amount') }} <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-8">
                            <input type="number" id="amount" lang="en" class="form-control mb-3 rounded-0" name="amount" placeholder="{{ translate('Enter Amount') }}" required>
                        </div>
                    </div>

                    <div id="card-element" class="hidden mb-3">
                        <!-- A Stripe Element will be inserted here. -->
                    </div>
                    <div id="card-errors" role="alert" class="text-danger hidden"></div>

                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-sm btn-primary rounded-0 transition-3d-hover mr-1">{{ translate('Confirm') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
const stripe = Stripe('{{ env('STRIPE_KEY') }}');

let card;  // Define card element globally

document.getElementById('payment_option').addEventListener('change', function(event) {
    const cardElement = document.getElementById('card-element');
    const cardErrors = document.getElementById('card-errors');
console.log(321);

    if (this.value == 'stripe') {
        // Display card element and errors container
        cardElement.classList.remove('hidden');
        cardErrors.classList.remove('hidden');

        if (!card) {
            const elements = stripe.elements();
            card = elements.create('card');
            card.mount('#card-element');
        }
    } else {
        // Hide card element and errors container
        cardElement.classList.add('hidden');
        cardErrors.classList.add('hidden');

        if (card) {
            card.unmount();
            card = null;
        }
    }
});


document.getElementById('payment-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const amount = document.getElementById('amount').value;
    const paymentOption = document.getElementById('payment_option').value;

    fetch('{{ route('church.donate', $church->id) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        },
        body: JSON.stringify({
            payment_option: paymentOption,
            amount: amount
        })
    })
    .then(response => response.json())
    .then(data => {
        if (paymentOption === 'stripe') {
            handleStripePayment(data.clientSecret);
        } else if (paymentOption === 'razorpay') {
            handleRazorpayPayment(data.orderId, amount);
        }
    })
    .catch(error => console.error('Error:', error));
});

function handleStripePayment(clientSecret) {
    if (!card) {
        console.error("Stripe Card Element is not mounted.");
        return;
    }

    stripe.confirmCardPayment(clientSecret, {
        payment_method: {
            card: card
        }
    }).then(result => {
        if (result.error) {
            document.getElementById('card-errors').textContent = result.error.message;
            document.getElementById('card-errors').classList.remove('hidden');
        } else {
            if (result.paymentIntent.status === 'succeeded') {
                window.location.href = '/dashboard'; // Redirect or handle success
            }
        }
    });
}

function handleRazorpayPayment(orderId, amount) {
    var options = {
        "key": '{{ env('RAZOR_KEY') }}',
        "amount": amount * 100, // Amount in paise
        "currency": "INR",
        "name": "Your Company Name",
        "order_id": orderId,
        "handler": function (response) {
            // Payment success
            window.location.href = '/dashboard'; // Redirect or handle success
        },
        "prefill": {
            "name": "Your Name",
            "email": "your_email@example.com"
        }
    };
    var rzp = new Razorpay(options);
    rzp.open();
}
</script>

<!-- Include Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

</body>
</html>
