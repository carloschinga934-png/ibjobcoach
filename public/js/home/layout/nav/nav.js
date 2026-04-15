document.addEventListener('DOMContentLoaded', function () {
    const trigger = document.querySelector('.dropdown-bandera > a');
    const menu = document.querySelector('.banderas-dropdown');

    if (trigger && menu) {
        trigger.addEventListener('click', function (e) {
            e.preventDefault();
            menu.classList.toggle('show');
        });

        document.addEventListener('click', function (e) {
            if (!trigger.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.remove('show');
            }
        });
    }
    // Elimina backdrop si existe
    document.querySelectorAll('.modal-backdrop').forEach(e => e.remove());
});
