@extends("shared.layout")
@section("content")
  @section("title")
    Pagar con Stripe
  @endsection
  @push("styles")
    <style>
    body {
    background-color: #f8f9fa;
    font-family: 'Segoe UI', sans-serif;
    }

    .payment-card {
    max-width: 420px;
    margin: 50px auto;
    padding: 30px 25px;
    background-color: #ffffff;
    border: 1px solid #dee2e6;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .payment-card h4 {
    font-weight: 600;
    color: #000000;
    }

    .form-label {
    font-weight: 500;
    margin-bottom: 8px;
    display: block;
    color: #000000;
    }

    .StripeElement {
    background-color: #fff;
    padding: 12px 16px;
    border-radius: 6px;
    border: 1px solid #ced4da;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    transition: box-shadow 150ms ease, border-color 150ms ease;
    }

    .StripeElement--focus {
    border-color: #dc3545;
    /* rojo */
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }

    .StripeElement--invalid {
    border-color: #dc3545;
    }

    #card-errors {
    color: #dc3545;
    margin-top: 8px;
    font-size: 14px;
    }

    .btn-pay {
    width: 100%;
    background-color: #dc3545;
    /* rojo corporativo */
    border: none;
    padding: 12px;
    font-size: 16px;
    color: #fff;
    font-weight: 600;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    }

    .btn-pay:hover {
    background-color: #b02a37;
    }
    </style>
    <script src="https://js.stripe.com/v3/"></script>
  @endpush

  @if (session('success_message'))
    <div class="alert alert-success text-center">
    {{ session('success_message') }}
    </div>
  @endif

  @if (session('error_message'))
    <div class="alert alert-danger text-center">
    {{ session('error_message') }}
    </div>
  @endif

  <div class="payment-card">
    <h4 class="text-center mb-4">Ingresa los datos de tu tarjeta</h4>

    <form action="{{ route('stripe.charge') }}" method="post" id="payment-form">
    @csrf

    <div class="form-group mb-3">
      <label for="card-element" class="form-label">Tarjeta de crédito o débito</label>
      <div id="card-element" class="form-control">
      <!-- Stripe inyecta aquí el input -->
      </div>
      <div id="card-errors" role="alert"></div>
    </div>

    <button type="submit" class="btn-pay" id="pagar">Pagar</button>
    </form>
  </div>


  @push("scripts")
    <script>
    var stripe = Stripe("{{ env('STRIPE_KEY') }}");
    var elements = stripe.elements();

    var style = {
    base: {
      color: "#32325d",
      lineHeight: "1.5",
      fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
      fontSmoothing: "antialiased",
      fontSize: "16px",
      "::placeholder": {
      color: "#aab7c4"
      }
    },
    invalid: {
      color: "#fa755a",
      iconColor: "#fa755a"
    }
    };

    var card = elements.create("card", { style: style });
    card.mount("#card-element");

    card.addEventListener("change", function (event) {
    var displayError = document.getElementById("card-errors");
    if (event.error) {
      displayError.textContent = event.error.message;
    } else {
      displayError.textContent = "";
    }
    });

    var form = document.getElementById("payment-form");
    form.addEventListener("submit", function (event) {
    event.preventDefault();

    stripe.createToken(card).then(function (result) {
      if (result.error) {
      var errorElement = document.getElementById("card-errors");
      errorElement.textContent = result.error.message;
      } else {
      stripeTokenHandler(result.token);
      }
    });
    });

    function stripeTokenHandler(token) {
    var form = document.getElementById("payment-form");
    var hiddenInput = document.createElement("input");
    hiddenInput.setAttribute("type", "hidden");
    hiddenInput.setAttribute("name", "stripeToken");
    hiddenInput.setAttribute("value", token.id);
    form.appendChild(hiddenInput);
    form.submit();
    }
    </script>
  @endpush

@endsection

<!-- <script>
    const stripe = Stripe('pk_test_TU_CLAVE_PUBLICA'); // Reemplaza con tu clave pública

    document.getElementById('pagar').addEventListener('click', function () {
      stripe.redirectToCheckout({
      lineItems: [{ price: 'price_1234', quantity: 1 }],
      mode: 'payment',
      successUrl: 'https://tusitio.com/exito',
      cancelUrl: 'https://tusitio.com/cancelado',
      });
    });
    </script> -->