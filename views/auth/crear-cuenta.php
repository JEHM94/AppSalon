<h1 class="nombre-pagina">Crear Cuenta</h1>

<p class="descripcion-pagina">Llena el siguiente formulario para crear una cuenta</p>

<?php include_once __DIR__ . '/../templates/alertas.php' ?>

<form class="formulario" method="POST">
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" placeholder="Ingresa tu Nombre" value="<?php echo s($usuario->nombre); ?>">
    </div><!-- .campo -->

    <div class="campo">
        <label for="apellido">Apellido</label>
        <input type="text" id="apellido" name="apellido" placeholder="Ingresa tu Apellido" value="<?php echo s($usuario->apellido); ?>">
    </div><!-- .campo -->

    <div class="campo">
        <label for="telefono">Teléfono</label>
        <input type="tel" id="telefono" name="telefono" placeholder="Ingresa tu Teléfono" value="<?php echo s($usuario->telefono); ?>">
    </div><!-- .campo -->

    <div class="campo">
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" placeholder="Ingresa tu E-mail" value="<?php echo s($usuario->email); ?>">
    </div><!-- .campo -->

    <div class="campo">
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" placeholder="Ingresa tu Contraseña">
    </div><!-- .campo -->

    <input type="submit" class="boton" value="Crear Cuenta">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? ¡Inicia Sesión!</a>
    <a href="/olvide">¿Olvidaste tu Contraseña? ¡Has Click Aquí!</a>
</div>