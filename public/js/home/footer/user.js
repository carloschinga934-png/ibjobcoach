// public/js/home/footer/user.js
(() => {
    document.addEventListener("DOMContentLoaded", () => {
        // WOW animations
        if (typeof WOW === 'function') new WOW().init();

        // POPUP FOOTER ALERT (solo para el popup del ebook)
        const ebookAlert = document.getElementById("footerAlert");
        const closeBtn  = document.getElementById("closeFooterAlert");
        if (ebookAlert && closeBtn) {
            closeBtn.addEventListener("click", () => {
                ebookAlert.style.display = "none";
            });
            // Opcional: autocierre a los 15 segundos
            setTimeout(() => {
                if (ebookAlert.style.display !== "none") {
                    ebookAlert.style.display = "none";
                }
            }, 15000);
        }
    });
})();
