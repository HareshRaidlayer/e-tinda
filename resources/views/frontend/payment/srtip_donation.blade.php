<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Complete Donation</title>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
    <h1>Complete Your Donation</h1>
    <form id="payment-form">
        <div id="card-element"></div>
        <button type="submit">Pay</button>
    </form>

    <script>
        var stripe = Stripe('your-publishable-key'); // Your Stripe publishable key
        var clientSecret = '{{ $clientSecret }}';

        var elements = stripe.elements();
        var card = elements.create('card');
        card.mount('#card-element');

        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            stripe.confirmCardPayment(clientSecret, {
                payment_method: {
                    card: card
                }
            }).then(function(result) {
                if (result.error) {
                    // Show error in payment form
                    alert(result.error.message);
                } else {
                    // Payment succeeded
                    if (result.paymentIntent.status === 'succeeded') {
                        alert('Donation successful!');
                        window.location.href = '{{ route("church.home") }}'; // Redirect or show success message
                    }
                }
            });
        });
    </script>
</body>
</html>
