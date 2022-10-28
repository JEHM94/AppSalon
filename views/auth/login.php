<h1 class="nombre-pagina">Login</h1>

<p class="descripcion-pagina">Inicia sesión con tus datos</p>

<form class="formulario" method="POST">
    <div class="campo">
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" placeholder="Ingresa tu E-mail">
    </div><!-- .campo -->

    <div class="campo">
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" placeholder="Ingresa tu Password">
    </div><!-- .campo -->

    <input type="submit" class="boton" value="Iniciar Sesión">
</form>

<div class="acciones">
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? ¡Regístrate Ahora!</a>
    <a href="/olvide">¿Olvidaste tu Contraseña? ¡Has Click Aquí!</a>
</div>