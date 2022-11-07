<h1 class="nombre-pagina">Reestablecer Contraseña</h1>

<?php include_once __DIR__ . '/../templates/alertas.php' ?>

<?php
// Si el usuario aún no ha verificado su E-mail, Muestra la notificación
if (!$confirmado) : ?>
    <p class="descripcion-pagina">Primero debe verificar su cuenta de E-mail para poder reestablecer su contraseña.</p>
    <p class="descripcion-pagina">Si no recibió ningún correo electrónico al momento de crear su cuenta, haga click a continuación.</p>
    <a href="/reenviar?token=<?php echo $usuario->token; ?>" class="boton">Reenviar E-mail de Verificación</a>
<?php
    return;
endif;
// Si la contraseña fue cambiada exitosamente, Muestra la notificación
if ($actualizado) : ?>
    <p class="descripcion-pagina">Tu contraseña ha sido cambiada</p>
    <p class="descripcion-pagina">Ya puedes iniciar sesión con tu nueva contraseña.</p>
    <a href="/" class="boton">Iniciar Sesión</a>
<?php
    return;
endif;
?>
<p class="descripcion-pagina">Ingresa una nueva contraseña a continuación.</p>

<form class="formulario" method="POST">
    <div class="campo">
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" placeholder="Nueva Contraseña">
    </div><!-- .campo -->

    <input type="submit" class="boton" value="Cambiar Contraseña">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? ¡Inicia Sesión!</a>
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? ¡Regístrate Ahora!</a>
</div>