document.addEventListener("DOMContentLoaded", function () {

    var masthead = document.querySelector('#mastheadCarousel');
    if (masthead) {
        new bootstrap.Carousel(masthead, {
            interval: 4000, // Cambia cada 4 segundos
            wrap: true
        });
    }

    var testimonios = document.querySelector('#testimoniosCarousel');
    if (testimonios) {
        new bootstrap.Carousel(testimonios, {
            interval: 4000, // Cambia cada 4 segundos
            wrap: true
        });
    }
});
