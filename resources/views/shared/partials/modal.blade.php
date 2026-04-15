<!-- Modal del carrito Bootstrap 5 puro -->
<div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cartModalLabel">Carrito de eBooks</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="cart-items">
                <!-- Los eBooks agregados se mostrarán aquí -->
            </div>
            <div class="modal-footer d-flex flex-column align-items-stretch">
                <div class="mb-2 text-end">
                    <span class="fw-bold">Total: S/ <span id="cart-total">0.00</span></span>
                </div>
                <form action="{{ route("stripe.checkout") }}">
                    <button id="checkoutBtn" type="submit" class="btn btn-primary" disabled>Pagar con Stripe</button>
                </form>
            </div>
        </div>
    </div>
</div>