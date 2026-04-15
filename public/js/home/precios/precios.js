document.addEventListener('DOMContentLoaded', function () {
    // ==== MANUAL: Precios por cantidad de meses (segundo select) ====
    const preciosPorMes = {
        1: '60.000',
        2: '54.000',
        3: '48.000',
        4: '43.000',
        5: '39.000',
        6: '35.000',
        7: '30.000',
        8: '28.000'
    };

    // ==== Primer Select: Posiciones (cargos) ====
    const cargos = document.getElementById('cargos');
    const mescargo = document.getElementById('mescargoSelect1');
    const valorcargo = document.getElementById('valorcargoSelect1');
    if (cargos && mescargo && valorcargo) {
        cargos.addEventListener('change', function () {
            let selected = cargos.options[cargos.selectedIndex];
            let meses = selected.getAttribute('data-meses') || '';
            let precio = selected.getAttribute('data-precio') || '';
            mescargo.value = meses ? `${meses} meses` : '';
            valorcargo.value = precio ? `S/ ${precio}` : '';
        });
    }

    // ==== Segundo Select: Meses (manual price) ====
    const selectMeses = document.getElementById('selectMeses');
    const precioMes = document.getElementById('precioMes');
    const btnSiguiente = document.getElementById('btnSiguiente');
    if (selectMeses && precioMes && btnSiguiente) {
        selectMeses.addEventListener('change', function () {
            const val = selectMeses.value;
            if (val && preciosPorMes[val]) {
                precioMes.value = `S/ ${preciosPorMes[val]} / mes`;
                btnSiguiente.disabled = false;
                selectMeses.classList.remove('is-invalid');
            } else {
                precioMes.value = 'S/ 60.000 / mes';
                btnSiguiente.disabled = true;
            }
        });
        btnSiguiente.disabled = true;
    }

    // ==== Paso de Step 1 a Step 2 ====
    const step1 = document.getElementById('step1');
    const step2 = document.getElementById('step2');
    if (btnSiguiente && step1 && step2) {
        btnSiguiente.addEventListener('click', function () {
            if (!selectMeses.value) {
                selectMeses.classList.add('is-invalid');
                selectMeses.focus();
                return;
            }
            step1.style.display = '';
            step2.style.display = '';
            setTimeout(() => {
                let f = document.getElementById('nombreInput');
                if (f) f.focus();
            }, 100);
        });
    }
    if (step2) step2.style.display = "none";

    // ==== Validación de formulario (step 2) ====
    const nombre = document.getElementById('nombreInput');
    const apellido = document.getElementById('apellidoInput');
    const correo = document.getElementById('correoInput');
    const clave = document.getElementById('claveInput');
    const telefono = document.getElementById('telefonoInput');
    const btnComprar = document.getElementById('btnComprar');
    const btnPaypal = document.getElementById('btnPaypal');
    const formComprar = document.getElementById('formComprar');

    function isEmail(val) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val);
    }
    function isPhone(val) {
        return /^\d{7,15}$/.test(val.replace(/[^0-9]/g, ''));
    }
    function validarFormulario(marcar = false) {
        let valid = true;

        // Nombre
        if (nombre.value.trim().length < 2) {
            valid = false;
            if (marcar) nombre.classList.add('is-invalid');
        } else {
            nombre.classList.remove('is-invalid');
        }

        // Apellido
        if (apellido.value.trim().length < 2) {
            valid = false;
            if (marcar) apellido.classList.add('is-invalid');
        } else {
            apellido.classList.remove('is-invalid');
        }

        // Correo
        if (!isEmail(correo.value)) {
            valid = false;
            if (marcar) correo.classList.add('is-invalid');
        } else {
            correo.classList.remove('is-invalid');
        }

        // Clave
        if (clave.value.trim().length < 4) {
            valid = false;
            if (marcar) clave.classList.add('is-invalid');
        } else {
            clave.classList.remove('is-invalid');
        }

        // Teléfono
        if (!isPhone(telefono.value)) {
            valid = false;
            if (marcar) telefono.classList.add('is-invalid');
        } else {
            telefono.classList.remove('is-invalid');
        }

        // Meses
        if (!selectMeses.value) {
            valid = false;
            if (marcar) selectMeses.classList.add('is-invalid');
        } else {
            selectMeses.classList.remove('is-invalid');
        }

        if (btnComprar) btnComprar.disabled = !valid;
        if (btnPaypal) btnPaypal.disabled = !valid;
        return valid;
    }

    [nombre, apellido, correo, clave, telefono].forEach(inp => {
        inp.addEventListener('input', function() {
            inp.classList.remove('is-invalid');
            validarFormulario();
        });
    });
    if (selectMeses) selectMeses.addEventListener('change', function() {
        selectMeses.classList.remove('is-invalid');
        validarFormulario();
    });

    // ==== Botones de pago y flujo ====
    const paypal = document.getElementById('pagoPayPal');
    const transferencia = document.getElementById('pagoTransfer');
    const datos = document.getElementById('datos-transferencia');

    function toggleDatos() {
        if (transferencia && datos && transferencia.checked) datos.style.display = '';
        else if (datos) datos.style.display = 'none';
    }
    if (paypal) paypal.addEventListener('change', toggleDatos);
    if (transferencia) transferencia.addEventListener('change', toggleDatos);
    toggleDatos();

    function toggleBotonesPago() {
        if (paypal && paypal.checked) {
            btnComprar.style.display = 'none';
            btnPaypal.style.display = 'block';
        } else {
            btnComprar.style.display = 'block';
            btnPaypal.style.display = 'none';
        }
    }
    if (paypal && transferencia && btnPaypal && btnComprar) {
        paypal.addEventListener('change', toggleBotonesPago);
        transferencia.addEventListener('change', toggleBotonesPago);
        toggleBotonesPago();
    }

    // === Submit normal (transferencia) ===
    if (btnComprar && formComprar) {
        formComprar.addEventListener('submit', function (e) {
            if (!validarFormulario(true)) {
                e.preventDefault();
                btnComprar.classList.add('btn-danger');
                btnComprar.textContent = 'Completa todos los campos';
                setTimeout(() => {
                    btnComprar.classList.remove('btn-danger');
                    btnComprar.textContent = 'COMPRAR';
                }, 2000);
            }
        });
    }

    // === Botón PayPal ===
    if (btnPaypal && formComprar) {
        btnPaypal.addEventListener('click', function (e) {
            if (!validarFormulario(true)) {
                [nombre, apellido, correo, clave, telefono, selectMeses].forEach(inp => {
                    if (inp && !inp.value.trim()) inp.classList.add('is-invalid');
                });
                btnPaypal.classList.add('btn-danger');
                btnPaypal.textContent = 'Completa todos los campos';
                setTimeout(() => {
                    btnPaypal.classList.remove('btn-danger');
                    btnPaypal.textContent = 'PAGAR CON PAYPAL';
                }, 2000);
                return;
            }
            document.getElementById('pagoPayPal').checked = true;
            formComprar.action = formComprar.action; // Default acción
            formComprar.submit();
        });
    }

    // ==== VALIDAR CUPÓN ====
    const cuponInput = document.getElementById('cuponInput');
    const btnValidarCupon = document.getElementById('btnValidarCupon');
    const errorCupon = document.getElementById('errorCupon');

    // Solo muestra el botón si hay texto en el input
    if (cuponInput && btnValidarCupon) {
        cuponInput.addEventListener('input', function () {
            cuponInput.classList.remove('is-invalid');
            errorCupon.textContent = '';
            errorCupon.classList.remove('text-danger', 'text-success');
            if (cuponInput.value.trim().length > 0) {
                btnValidarCupon.style.display = 'inline-block';
            } else {
                btnValidarCupon.style.display = 'none';
            }
        });
        // Valida el cupón vía AJAX (Fetch)
        btnValidarCupon.addEventListener('click', function () {
            const codigo = cuponInput.value.trim();
            if (!codigo) {
                errorCupon.textContent = "Ingresa un código de cupón";
                cuponInput.classList.add('is-invalid');
                return;
            }
            btnValidarCupon.disabled = true;
            errorCupon.textContent = "Validando...";
            errorCupon.classList.remove('text-danger', 'text-success');
            fetch(`/api/validar-cupon?codigo=${encodeURIComponent(codigo)}`)
                .then(resp => resp.json())
                .then(data => {
                    if (data.valido) {
                        errorCupon.textContent = "Cupón válido ✔";
                        errorCupon.classList.remove('text-danger');
                        errorCupon.classList.add('text-success');
                        cuponInput.classList.remove('is-invalid');
                    } else {
                        errorCupon.textContent = "Cupón inválido o no encontrado";
                        errorCupon.classList.remove('text-success');
                        errorCupon.classList.add('text-danger');
                        cuponInput.classList.add('is-invalid');
                    }
                })
                .catch(() => {
                    errorCupon.textContent = "Error al validar cupón";
                    errorCupon.classList.remove('text-success');
                    errorCupon.classList.add('text-danger');
                    cuponInput.classList.add('is-invalid');
                })
                .finally(() => {
                    btnValidarCupon.disabled = false;
                });
        });
    }
    validarFormulario();
});
