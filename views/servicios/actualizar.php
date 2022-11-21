<h1 class="nombre-pagina">Actualizar Servicio</h1>

<?php
include_once __DIR__ . '/../templates/barra.php';
include_once __DIR__ . '/../templates/alertas.php';
?>

<p class="descripcion-pagina">Modifica los Valores del Formulario</p>

<form method="POST" class="formulario">
    <?php include_once __DIR__ . '/formulario.php' ?>
    <input type="submit" class="boton" value="Actualizar Servicio">
</form>