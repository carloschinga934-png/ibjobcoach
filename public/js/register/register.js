
function togglePassword(id, elem) {
    const input = document.getElementById(id);
    if (input.type === "password") {
        input.type = "text";
        elem.classList.add('activo');
    } else {
        input.type = "password";
        elem.classList.remove('activo');
    }
}

