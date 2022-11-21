document.addEventListener('DOMContentLoaded', function () {
    iniciarApp();
});

function iniciarApp() {
    mostrarFecha();
    buscarPorFecha();
    alertaEliminarCita();
}

function mostrarFecha() {
    const fecha = document.querySelector('#fecha').value;
    // Formatea la Fecha para mostrar un formato más amigable para el usuario
    const fechaObj = new Date(fecha);
    const m = fechaObj.getMonth();
    // Le sumamos 2 para compensar el desfase de new Date
    const d = fechaObj.getDate() + 2;
    const y = fechaObj.getFullYear();

    // Instanciamos un nuevo objeto de fecha
    const fechaUTC = new Date(Date.UTC(y, m, d));
    // Opciones para el formateo de la fecha
    const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    const fechaFormateada = fechaUTC.toLocaleDateString('es-MX', opciones);

    // Párrafo la fecha de la cita
    const fechaCita = document.createElement('H4');
    fechaCita.innerHTML = fechaFormateada;

    document.querySelector('.formulario').appendChild(fechaCita);
}

function buscarPorFecha() {
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('input', function (e) {
        const fechaSeleccionada = e.target.value;

        if (fechaSeleccionada) {
            window.location = `?fecha=${fechaSeleccionada}`;
        }
    });
}

