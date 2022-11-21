document.addEventListener('DOMContentLoaded', function () {
    iniciarApp();
});

function iniciarApp() {
    alertaEliminarServicio();
}

function alertaEliminarServicio() {
    const botonEliminar = document.querySelectorAll('.boton-eliminar');
    botonEliminar.forEach(boton => {
        const servicioId = boton.id;
        const nombreservicio = boton.dataset.nombreservicio;
        boton.addEventListener('click', function () {
            Swal.fire({
                title: `¿Está seguro que desea eliminar este Servicio? ${nombreservicio}.`,
                text: "¡No Podrá deshacer esta acción!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Eliminar.',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    eliminarServicio(servicioId);
                }
            })
        });
    });
}

async function eliminarServicio(servicioId) {
    // URL Para eliminación de citas
    const url = 'http://127.0.0.1:3000/api/eliminar';
    // Contruye el FormData con el id de la cita a eliminar
    const datos = new FormData();
    datos.append('servicioId', servicioId);

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
                text: 'El Servicio ha sido eliminado exitosamente.',
            }).then(() => {
                window.location.reload();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Ha ocurrido un error al eliminar el servicio. Por favor, intentelo más tarde.'
            })
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Ha ocurrido un error al eliminar el servicio. Por favor, intentelo más tarde.'
        })
    }
}