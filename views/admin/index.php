<h1 class="nombre-pagina">Panel de Administración</h1>

<?php include_once __DIR__ . '/../templates/barra.php' ?>

<h2>Buscar Citas</h2>
<div class="busqueda">
    <form class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="fecha" value="<?php echo $fecha; ?>">
        </div><!-- .campo -->
    </form>
</div>

<div id="citas-admin">
    <ul class="citas">
        <?php
        if (count($citas) === 0) {
            echo "<h3>No hay Citas en esta Fecha</h3>";
        }

        $idCita = 0;
        foreach ($citas as $key => $cita) :
            if ($idCita !== $cita->id) :
                $total = 0;
        ?>
                <li>
                    <p>ID: <span><?php echo $cita->id; ?></span></p>
                    <p>Hora: <span><?php echo $cita->hora; ?> Hrs.</span></p>
                    <p>Cliente: <span><?php echo $cita->cliente; ?></span></p>
                    <p>E-mail: <span><?php echo $cita->email; ?></span></p>
                    <p>Teléfono: <span><?php echo $cita->telefono; ?></span></p>
                    <h3>Servicios</h3>
                <?php
                $idCita = $cita->id;
            endif;
                ?>
                <p class="servicio"><span><?php echo $cita->servicio; ?></span> $<?php echo $cita->precio; ?></p>
                <?php
                $total += $cita->precio;
                $idActual = $cita->id;
                $idProximo = $citas[$key + 1]->id ?? 0;

                if ($idActual !== $idProximo) :
                ?>
                    <p class="total">Total a pagar: $<?php echo $total; ?></p>
                    
                    <input type="button" id="<?php echo $cita->id; ?>" class="boton-eliminar" value="Eliminar Cita">
            <?php
                endif;
            endforeach;
            ?>
    </ul>
</div>

<?php
$script = '
    <script src="build/js/buscador.js"></script>
    <script src="build/js/eliminar.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
'; ?>