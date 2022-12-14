<h1 class="nombre-pagina">Crear Nueva Cita</h1>

<p class="descripcion-pagina">Elige tus servicios y coloca tus datos</p>

<?php include_once __DIR__ . '/../templates/barra.php' ?>

<div class="app">
    <nav class="tabs">
        <button type="button" data-paso="1" class="actual">Servicios</button>
        <button type="button" data-paso="2">Datos de la Cita</button>
        <button type="button" data-paso="3">Resumen</button>
    </nav><!-- .tabs -->

    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <p class="centrar-texto">Elige tus servicios a continuación</p>
        <div id="servicios" class="listado-servicios"></div> <!-- .listado-servicios -->
    </div> <!-- .seccion -->

    <div id="paso-2" class="seccion">
        <h2>Datos de la Cita</h2>
        <p class="centrar-texto">Coloca tus datos y fecha de la cita</p>

        <form class="formulario">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" placeholder="Ingresa tu Nombre" value="<?php echo $nombre; ?>" disabled>
            </div><!-- .campo -->

            <div class="campo">
                <label for="fecha">Fecha</label>
                <input type="date" id="fecha" name="fecha" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
            </div><!-- .campo -->

            <div class="campo">
                <label for="hora">Hora</label>
                <input type="time" id="hora" name="hora">
            </div><!-- .campo -->

            <input type="hidden" id="id" value="<?php echo $id ?>">
        </form>
    </div> <!-- .seccion -->

    <div id="paso-3" class="seccion contenido-resumen">
        <h2>Resumen</h2>
        <p class="centrar-texto">Verifica que la información sea correcta</p>
    </div> <!-- .seccion -->

    <div class="paginacion">
        <button id="anterior" class="boton">&laquo; Anterior</button>
        <button id="siguiente" class="boton">Siguiente &raquo;</button>
    </div>
</div> <!-- .app -->

<?php
$script = '
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="build/js/app.js"></script>
'; ?>