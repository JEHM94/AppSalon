// Variable del Paginador
let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;
// Variable para crear la Cita
const cita = {
    id: '',
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
};


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
    // Consulta la API en el backend de PHP
    consultarAPI();
    // Obtiene el id del Cliente y lo Asigna al objeto de Cita
    idCliente();
    // Obtiene el nombre del Cliente y lo Asigna al objeto de Cita
    nombreCliente();
    // Agrega la fecha al Objeto de Cita
    seleccionarFecha();
    // Agrega la hora al Objeto de Cita
    seleccionarHora();
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
        // Muestra el resumen de la cita
        mostrarResumen();
    } else {
        botonAnterior.classList.remove('ocultar');
        botonSiguiente.classList.remove('ocultar');
    }
    // Mostramos la sección
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

async function consultarAPI() {
    try {
        // EndPoint de la API
        const url = 'http://127.0.0.1:3000/api/servicios';
        // Consultamos el EndPoint y obtenemos resultando en formato Json
        const resultado = await fetch(url);
        const servicios = await resultado.json();
        // Nostramos los resultados
        mostrarServicios(servicios);
    } catch (error) {
        console.log(error);
    }
}

function mostrarServicios(servicios) {
    // Iteramos los resultados del JSON
    servicios.forEach(servicio => {
        // Aplicamos Destructuring para separar los datos
        const { id, nombre, precio } = servicio;

        // Creamos el Párrafo que contiene el nombre del servicio
        const nombreServicio = document.createElement('P');
        // Asignamos su clase CSS
        nombreServicio.classList.add('nombre-servicio');
        // Agregamos el texto del Párrafo
        nombreServicio.textContent = nombre;

        // Creamos el Párrafo que contiene el precio del servicio
        const precioServicio = document.createElement('P');
        // Asignamos su clase CSS
        precioServicio.classList.add('precio-servicio');
        // Agregamos el texto del Párrafo
        precioServicio.textContent = `$${precio}`;

        // Creamos el Div que va a contener a cada Servicio
        const servicioDiv = document.createElement('DIV');
        // Asignamos su clase CSS
        servicioDiv.classList.add('servicio');
        // Agregamos su ID data-id-servicio = id
        servicioDiv.dataset.idServicio = id;
        // Asigamos el evento click al div
        servicioDiv.onclick = function () {
            seleccionarServicio(servicio);
        };

        // Agregamos los Párrafos al Div
        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);

        // Agregamos El Div del servicio al div principal de Servicios
        document.querySelector('#servicios').appendChild(servicioDiv);
    });
}

function seleccionarServicio(servicio) {
    // Extraemos el id del servicio
    const { id } = servicio;
    // Extraemos el arreglo de servicios
    const { servicios } = cita;
    // Buscamos el Div con el ID del servicio seleccionado
    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`)

    // Comprobamos si un servicio ya fue Agregado
    if (servicios.some(agregado => agregado.id === id)) {
        // Si el Servicio ya existe en la Cita, lo Eliminamos
        cita.servicios = servicios.filter(agregado => agregado.id !== id);
        // Eliminamos la clase CSS de Servicio seleccionado
        divServicio.classList.remove('seleccionado');
    } else {
        // Si el servicio no ha sido agregado a la cita, lo agregamos.
        // Reasignamos el valor de citas.servicios, le asignamos
        // una copida del arreglo de servicios y agregamos el servicio al final
        cita.servicios = [...servicios, servicio];
        // Asignamos su clase CSS de Servicio seleccionado
        divServicio.classList.add('seleccionado');
    }
}

function idCliente() {
    cita.id = document.querySelector('#id').value;

}

function nombreCliente() {
    cita.nombre = document.querySelector('#nombre').value;
}

function seleccionarFecha() {
    // Seleccionamos el input de la Fecha
    const inputFecha = document.querySelector('#fecha');
    // Agregamos el evento cuando el usuario escoga una fecha
    inputFecha.addEventListener('input', function (e) {
        // Fecha Seleccionada
        const fechaCita = e.target.value
        // Verificamos que día fue escogido
        const dia = new Date(fechaCita).getUTCDay();

        // Sabado = 6 | Domingo = 0
        if ([6, 0].includes(dia)) {
            // Si el usuario escoge Sabado o Domingo, enviamos alerta
            e.target.value = '';
            // Esto para limpiar el objeto en caso que tenga una fecha válida anterior
            cita.fecha = '';
            mostrarAlerta('Sábados y Domingos no permitidos', 'error', '#paso-2 p');
            return;
        }

        // Antes de asignar la fecha a la cita, comprobamos que la fecha aún no haya pasado
        if (esFechaPasada(fechaCita)) {
            // Si el usuario escoge Sabado o Domingo, enviamos alerta
            e.target.value = '';
            // Esto para limpiar el objeto en caso que tenga una fecha válida anterior
            cita.fecha = '';
            mostrarAlerta('El día seleccionado ya pasó', 'error', '#paso-2 p');
            return;
        }

        // Si es un día válido y distinto a sabado y domingo entonces lo asignamos a la cita
        cita.fecha = fechaCita;
    });
}

function seleccionarHora() {
    // Seleccionamos el input de la Hora
    const inputHora = document.querySelector('#hora');
    // Agregamos el evento cuando el usuario escoga una Hora
    inputHora.addEventListener('input', function (e) {
        // Hora Seleccionada
        const horaCita = e.target.value;
        // Separamos las Horas de los minutos
        const hora = horaCita.split(":")[0];
        // Establecemos las horas permitidas (Entre las 10am y 7pm)
        if (hora < 10 || hora > 18) {
            // Si el usuario escoge una hora no permitida enviamos alerta
            e.target.value = '';
            // Esto para evitar que persista algún valor anteriormente ingresado
            cita.hora = '';
            mostrarAlerta('Hora fuera del Horario de Trabajo (10am - 07pm)', 'error', '#paso-2 p');
            return;
        }

        // Si es una hora válida entonces la asignamos a la cita
        cita.hora = horaCita;
    });
}

function mostrarAlerta(mensaje, tipo, nombreElemento, desaparece = true) {

    // Si ya existe una alerta, la removemos.
    // Esto para prevenir que se genere más de 1 alerta a la vez.
    removerAlertaPrevia();

    // Scripting para crear la alerta
    // Creamos el Div de la alerta
    const alerta = document.createElement('DIV');
    // Agregamos el mensaje de alerta
    alerta.textContent = mensaje;
    // Agregamos las classes CSS de la alerta
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);
    // Seleccionamos el párrafo dentro del elemento con id=paso-2
    const elemento = document.querySelector(nombreElemento);
    // Insertamos la alerta después del elemento P
    elemento.after(alerta);

    if (desaparece) {
        // Eliminamos la alerta después de 3 segundos
        setTimeout(() => {
            alerta.remove();
        }, 4000);
    }
}

function removerAlertaPrevia() {
    // Busca si existe alguna alerta y la remueve
    const alertaPrevia = document.querySelector('.alerta');
    if (alertaPrevia) {
        alertaPrevia.remove();
    };
}

function esFechaPasada(fecha) {
    // Creamos un objeto con la fecha actual
    let hoy = new Date();
    // Formateamos la fecha Actual YYYY-MM-DD
    const fechaActual = hoy.getFullYear() + "-" + (hoy.getMonth() + 1) + "-" + hoy.getDate();

    return fecha <= fechaActual;
}

function mostrarResumen() {
    const resumen = document.querySelector('.contenido-resumen');
    // Verifica si el usuario seleccionó algún servicio
    if (cita.servicios.length === 0) {
        mostrarAlerta('Debe seleccionar algún servicio', 'error', '.contenido-resumen p', false);
        return;
    }
    // Verifica si el usuario seleccionó la Fecha y Hora de la cita
    if (Object.values(cita).includes('')) {
        mostrarAlerta('Debe seleccionar la fecha y hora de la cita', 'error', '.contenido-resumen p', false);
        return;
    }

    // Al pasar las validacionnes anteriores
    // verificamos  Si existe alguna alerta previa para removerla
    removerAlertaPrevia();

    // Scripting del Resumen
    const { nombre, fecha, hora, servicios } = cita;

    // Heading de servicios
    const headingServicios = document.createElement('H3');
    headingServicios.textContent = 'Servicios Solicitados';
    resumen.appendChild(headingServicios);

    // Div con los Servicios
    servicios.forEach(servicio => {
        const { id, nombre, precio } = servicio;
        const contenedorServicio = document.createElement('DIV');
        contenedorServicio.classList.add('contenedor-servicio');

        // Párrafo con el nombre del servicio
        const textoServicio = document.createElement('P');
        textoServicio.textContent = nombre;

        // Párrafo con el precio del servicio
        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `<span>Precio:</span> $${precio}`;

        // Agregamos los párrafos de nombre y precio al contenedor de servicio
        contenedorServicio.appendChild(textoServicio);
        contenedorServicio.appendChild(precioServicio);

        // Agregamos el contenedor del servicio al resumen
        resumen.appendChild(contenedorServicio);

    });
    // ----------------------------------------------------------

    // Heading de detalles de la cita
    const headingCita = document.createElement('H3');
    headingCita.textContent = 'Detalles de la Cita';
    resumen.appendChild(headingCita);

    // Párrafo con nombre del cliente
    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`;

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
    const fechaCita = document.createElement('P');
    fechaCita.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`;

    // Párrafo con la hora de la cita
    const horaCita = document.createElement('P');
    horaCita.innerHTML = `<span>Hora:</span> ${hora} Horas`;

    // Agrega los Párrafos de nombre, fecha y hora al resumen
    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);
    // ----------------------------------------------------------

    // Botón para reservar la Cita
    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.textContent = 'Reservar Cita';
    botonReservar.onclick = reservarCita;

    // Agrega el Botón al resumen
    resumen.appendChild(botonReservar);
}

async function reservarCita() {
    const { id, fecha, hora, servicios } = cita;

    const idServicio = servicios.map(servicio => servicio.id);

    const datos = new FormData();
    datos.append('usuarios_id', id);
    datos.append('fecha', fecha);
    datos.append('hora', hora);
    datos.append('servicios', idServicio);

    const url = 'http://127.0.0.1:3000/api/citas';

    try {
        const respuesta = await fetch(url, {
            method: 'POST',
            body: datos
        });

        const resultado = await respuesta.json();

        if (resultado.resultado) {

            Swal.fire({
                icon: 'success',
                title: 'Cita Creada',
                text: 'Su cita ha sido reservada correctamente'
            }).then(() => {
                window.location.reload();
            });
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Ha ocurrido un error al guardar la cita. Por favor, intentelo más tarde.'
        })
    }
}