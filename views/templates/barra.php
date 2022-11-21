<div class="barra">
    <p><span>Usuario:</span> <?php echo $nombre ?? ''; ?></p>
    <a class="boton" href="/logout">Cerrar Sesión</a>
</div><!-- .barra -->

<?php
$isAdmin = $_SESSION['admin'] ?? null;
if ($isAdmin) :
?>
    <div class="barra-servicios">
        <a class="boton" href="/admin">Ver Citas</a>
        <a class="boton" href="/servicios">Ver Servicios</a>
        <a class="boton" href="/servicios/crear">Nuevo Servicio</a>
    </div>
<?php
else :
?>
    <div class="barra-servicios">
        <a class="boton" href="/cita">Nueva Cita</a>
        <a class="boton" href="/cita/ver">Ver Citas</a>
    </div>
<?php
endif;
?>