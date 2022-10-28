<h1 class="nombre-pagina">Recuperar Contraseña</h1>

<p class="descripcion-pagina">Para reestablecer tu Contraseña escribie tu E-mail a continuación</p>

<form action="/olvide" class="formulario" method="POST">
    <div class="campo">
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" placeholder="Ingresa tu E-mail">
    </div><!-- .campo -->

    <input type="submit" class="boton" value="Reestablecer Contraseña">
</form>

<div class="acciones">
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? ¡Regístrate Ahora!</a>
    <a href="/">¿Ya tienes una cuenta? ¡Inicia Sesión!</a>
</div>