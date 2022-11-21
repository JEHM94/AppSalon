<div class="campo">
    <label for="nombre">Servicio</label>
    <input type="text" id="nombre" name="nombre" placeholder="Nombre del Servicio" value="<?php echo s($servicio->nombre); ?>">
</div><!-- .campo -->

<div class="campo">
    <label for="precio">Precio($)</label>
    <input type="number" id="precio" name="precio" placeholder="Costo del Servicio" value="<?php echo s($servicio->precio); ?>" min=0>
</div><!-- .campo -->