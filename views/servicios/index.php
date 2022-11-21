<h1 class="nombre-pagina">Administración de Servicios</h1>

<?php include_once __DIR__ . '/../templates/barra.php' ?>

<p class="descripcion-pagina">Servicios</p>

<ul class="servicios">
    <?php
    foreach ($servicios as $servicio) :
    ?>
        <li>
            <p>Nombre: <span><?php echo $servicio->nombre; ?></span></p>
            <p>Precio: <span>$<?php echo $servicio->precio; ?></span></p>
            <div class="acciones">
                <a class="boton" href="/servicios/actualizar?id=<?php echo  $servicio->id ?>">Actualizar</a>

                <input type="button" id="<?php echo $servicio->id; ?>" data-nombreServicio="<?php echo $servicio->nombre; ?>" class="boton-eliminar" value="Eliminar">
            </div>
        </li>
    <?php
    endforeach;
    ?>
</ul>

<?php
$script = '
    <script src="build/js/servicios.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
'; ?>