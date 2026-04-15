// Elementos
const modal = document.getElementById("mi_modal");
const btnAbrir = document.getElementById("abrirModal");
const btnCerrar = document.querySelector(".cerrar");

// Mostrar modal
btnAbrir.onclick = function () {
  modal.style.display = "block";
};

// Cerrar modal al hacer clic en la X
btnCerrar.onclick = function () {
  modal.style.display = "none";
};

// Cerrar modal al hacer clic fuera del contenido
window.onclick = function (event) {
  if (event.target === modal) {
    modal.style.display = "none";
  }
};


//ASl seleccionar en las tab de la izquierda cambia el contenido de la derecha
let buttons = document.querySelectorAll(".modal_contenido_ebook_body .col1 button");
let secciones = document.querySelectorAll(".modal_contenido_ebook_body .col2")
console.log(secciones)

buttons.forEach(
  button => button.addEventListener("click", function () {
    //quitar clase "activado" a todos los botones
    buttons.forEach(b => b.classList.remove("activado"))
    button.classList.add("activado")

    //ocultar todas las secciones
    secciones.forEach(secc => secc.classList.remove("activado"))
    
    //Mostrar la sección específica
    let tabId = button.getAttribute("data-tab") //1 2 3
    console.log(tabId)
    document.getElementById("tab-" + tabId).classList.add("activado")

  }))