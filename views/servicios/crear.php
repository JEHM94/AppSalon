<h1 class="nombre-pagina">Nuevo Servicio</h1>

<?php 
include_once __DIR__ . '/../templates/barra.php';
include_once __DIR__ . '/../templates/alertas.php';
?>

<p class="descripcion-pagina">Llena todos los campos para añadir un nuevo servicio</p>

<form method="POST" class="formulario">
    <?php include_once __DIR__ . '/formulario.php' ?>
    <input type="submit" class="boton" value="Crear Servicio">
</form>