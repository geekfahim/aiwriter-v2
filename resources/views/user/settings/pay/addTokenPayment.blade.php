<!DOCTYPE html>
<html>
<head>
    <title>Add Token</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <style>
        .ProductSummary-name {
            word-break: break-word;
            font-size: 16px;
            font-weight: 500;
            color: gray;
            padding: 0px;
            margin: 0px;
        }
    </style>
</head>
<body>
    <div class="row d-flex justify-content-center">
        <div class="col-12 col-md-6 mt-5">
            <div class="card">
                <div class="card-header text-center">
                    <h3>Additional Token Payment<h3>
                </div>
                <div class="card-body">
                    <p class='ProductSummary-name'>Add Token</p>
                    <h1 class='fw-bold m-0 p-0'>US${{ number_format($amount, 2) }}</h1>
                    <p class="ProductSummary-name">For More Prompts<p>
                    <div id="card-element" class="form-control" ></div>
                    <div class="col-12 col-md-12 text-center">
                        <form method="POST" action="{{ url('add-token-details') }}" id="productForm">
                            @csrf
                            <input type='hidden' name='stripeToken' id="stripe-token-id">
                            <input type='hidden' name='secret_key' value="{{ $is_serialized['secret_key'] }}">
                            <input type="hidden" name="token" value="{{ $token }}">
                            <input type="hidden" name="amount" value="{{ $amount }}">
                        </form>
                        <button id='pay-btn' class="btn btn-success mt-3" type="button" style="margin-top: 20px; width: 15%;padding: 7px;" onclick="createToken()">Pay </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://js.stripe.com/v3/"></script>
<script>
    var stripe = Stripe('{{ $is_serialized["publishable_key"] }}');
    var elements = stripe.elements();
    var cardElement = elements.create('card');
    cardElement.mount('#card-element');

    function createToken() {
        document.getElementById("pay-btn").disabled = true;
        stripe.createToken(cardElement).then(function(result) {

              
            if(typeof result.error != 'undefined') {
                document.getElementById("pay-btn").disabled = false;
                alert(result.error.message);
            }

            // creating token success
            if(typeof result.token != 'undefined') {
                // document.getElementById("pay-btn").prepend('<i class="fa fa-spinner fa-spin"></i>');
                document.getElementById("stripe-token-id").value = result.token.id;
                document.getElementById('productForm').submit();
            }
        });
    }

</script>
</html>
