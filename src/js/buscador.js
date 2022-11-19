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

function alertaEliminarCita() {
    const botonEliminar = document.querySelectorAll('.boton-eliminar');
    botonEliminar.forEach(boton => {
        const citaId = boton.id;
        boton.addEventListener('click', function () {
            Swal.fire({
                title: `¿Está seguro que desea eliminar la Cita ID: ${citaId}?`,
                text: "¡No Podrá deshacer esta acción!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Eliminar.',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    eliminarCita(citaId);
                }
            })
        });
    });
}

async function eliminarCita(citaID) {
    // URL Para eliminación de citas
    const url = 'http://127.0.0.1:3000/api/eliminar';
    // Contruye el FormData con el id de la cita a eliminar
    const datos = new FormData();
    datos.append('citaId', citaID);

    try {
        // Envía la petición a la url con los datos del FormData
        const respuesta = await fetch(url, {
            method: 'POST',
            body: datos
        });
        const resultado = await respuesta.json();

        // Alerta cita fue eliminada exitosamente
        if (resultado.resultado) {
            Swal.fire({
                icon: 'success',
                title: '¡Eliminado!',
                text: 'La cita ha sido eliminada exitosamente.',
            }).then(() => {
                window.location.reload();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Ha ocurrido un error al eliminar la cita. Por favor, intentelo más tarde.'
            })
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Ha ocurrido un error al eliminar la cita. Por favor, intentelo más tarde.'
        })
    }
}