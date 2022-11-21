document.addEventListener('DOMContentLoaded', function () {
    iniciarApp();
});

function iniciarApp() {
    mostrarFecha();
    alertaEliminarCita();
}

function mostrarFecha() {
    const fechas = document.querySelectorAll('#fecha');
    fechas.forEach(fecha => {
        // Formatea la Fecha para mostrar un formato más amigable para el usuario
        const fechaObj = new Date(fecha.textContent);

        const m = fechaObj.getMonth();
        // Le sumamos 2 para compensar el desfase de new Date
        const d = fechaObj.getDate() + 2;
        const y = fechaObj.getFullYear();

        // Instanciamos un nuevo objeto de fecha
        const fechaUTC = new Date(Date.UTC(y, m, d));
        // Opciones para el formateo de la fecha
        const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const fechaFormateada = fechaUTC.toLocaleDateString('es-MX', opciones);
        // Reasigna el valor de la fecha 
        fecha.textContent = fechaFormateada;
    });

}