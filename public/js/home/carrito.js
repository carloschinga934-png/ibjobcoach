//VARIABLES GLOBALES
let cart = [];
let valor_carrito = null;
let isLoggedIn = window.isLoggedIn || false;


document.addEventListener("DOMContentLoaded", () => {
    cart = JSON.parse(localStorage.getItem("cart")) || [];
    valor_carrito = document.querySelector(".nro_notificacion");

    if (valor_carrito) valor_carrito.textContent = cart.length;

    isLoggedIn = window.isLoggedIn || false;
    console.log("isLoggedIn es: ", isLoggedIn);
});
function openCartModal() {
    const modalElement = document.getElementById('cartModal');
    if (!modalElement) {
        console.error("❌ No se encontró el modal con id='cartModal'");
        return;
    }

    let modal = new bootstrap.Modal(modalElement);
    modal.show();
}

function addToCart(id, titulo, precio) {
    if (!cart.find(item => item.id === id)) {
        cart.push({ id, titulo, precio });
        localStorage.setItem("cart", JSON.stringify(cart));
        if (valor_carrito) valor_carrito.textContent = cart.length;
        updateCartView();
        openCartModal();
    }
}

function updateCartView() {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    const cartDiv = document.getElementById('cart-items');
    const valor_carrito = document.querySelector(".nro_notificacion");

    if (!cartDiv || !valor_carrito) return;

    if (cart.length === 0) {
        valor_carrito.textContent = 0;
        cartDiv.innerHTML = '<p>No hay ebooks en el carrito.</p>';
        document.getElementById('checkoutBtn').disabled = true;
        document.getElementById('cart-total').textContent = '0.00';
        return;
    }

    valor_carrito.textContent = cart.length;
    let total = cart.reduce((sum, item) => sum + item.precio, 0);
    cartDiv.innerHTML = '<ul class="list-group mb-2">' +
        cart.map(item => `
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>${item.titulo}</span>
                <span>S/ ${item.precio.toFixed(2)}</span>
                <button type="button" class="btn btn-sm btn-danger ms-2" onclick="removeFromCart(${item.id})">Quitar</button>
            </li>
        `).join('') +
        '</ul>';

    document.getElementById('cart-total').textContent = total.toFixed(2);
    document.getElementById('checkoutBtn').disabled = false;
}

function removeFromCart(id) {
    cart = cart.filter(item => item.id !== id);
    localStorage.setItem("cart", JSON.stringify(cart));
    updateCartView();
}

document.addEventListener("DOMContentLoaded", () => {
    const checkoutBtn = document.getElementById('checkoutBtn');
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', async function () {
            if (cart.length === 0) return;
            //Si no está logueado le llevará al login
            // if (!isLoggedIn) {
            //     //Si no está logueado lo tiene que llevar ahí
            //     window.location.href = checkoutRedirectURL;
            //     return;
            // }


            //Enviar pago (click pagar con las credenciales puestas)
            const response = await fetch(checkoutRoute, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ ebooks: cart })
            });
            const data = await response.json();
            if (data.url) {
                window.location.href = data.url;
            } else {
                alert('Error al crear el pago.');
            }
        });
    }

    updateCartView();
});
