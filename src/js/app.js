let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

document.addEventListener('DOMContentLoaded', function () {
    iniciarApp();
});

function iniciarApp() {
    // Mostramos el Paso que está activo (let paso = 1;)
    mostrarSeccion();
    // Cambia la sección cuando se presionen los tabs
    tabs();
    // Agrega o quita los botones del paginador
    botonesPaginador();
    // Cambio de Páginas con los botones del paginador
    paginaAnterior();
    paginaSiguiente();

}

function mostrarSeccion() {
    // Primero Ocultamos la sección que tenga la clase de .mostrar
    const seccionAnterior = document.querySelector('.mostrar');
    if (seccionAnterior) {
        seccionAnterior.classList.remove('mostrar');
    }


    // Seleccionamos la sección con el paso...
    const pasoSelector = `#paso-${paso}`;
    const seccion = document.querySelector(pasoSelector);
    // Una vez seleccionada la Sección, agregamos la clase de .mostrar
    seccion.classList.add('mostrar');

    // quita la clase de .actual al tab anterior
    const tabAnterior = document.querySelector('.actual');
    if (tabAnterior) {
        tabAnterior.classList.remove('actual');
    }


    // Resalta el Tab Actual
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add('actual');
}

function tabs() {
    // Seleccionamos todos los tabs
    const botones = document.querySelectorAll('.tabs button');
    // Iteramos el resultado y Asignamos evento de click a cada elemento
    botones.forEach(boton => {
        boton.addEventListener('click', function (e) {
            paso = parseInt(e.target.dataset.paso);

            mostrarSeccion();
            botonesPaginador();
        });
    });
}

function botonesPaginador() {
    // Seleccionamos los Botones del paginador
    const botonAnterior = document.querySelector('#anterior');
    const botonSiguiente = document.querySelector('#siguiente');

    if (paso === 1) {
        botonAnterior.classList.add('ocultar');
        botonSiguiente.classList.remove('ocultar');
    } else if (paso === 3) {
        botonAnterior.classList.remove('ocultar');
        botonSiguiente.classList.add('ocultar');
    } else {
        botonAnterior.classList.remove('ocultar');
        botonSiguiente.classList.remove('ocultar');
    }

    mostrarSeccion();
}

function paginaAnterior() {
    const botonAnterior = document.querySelector('#anterior');
    botonAnterior.addEventListener('click', function () {
        if (paso <= pasoInicial) return;
        paso--;
        botonesPaginador();
    });
}

function paginaSiguiente() {
    const botonSiguiente = document.querySelector('#siguiente');
    botonSiguiente.addEventListener('click', function () {
        if (paso >= pasoFinal) return;
        paso++;
        botonesPaginador();
    });
}