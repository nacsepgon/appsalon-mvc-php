<h1 class="nombre-pagina">Login</h2>
<p class="descripcion-pagina">Iniciar sesión</p>

<?php include_once __DIR__ . '/../templates/alertas.php' ?>

<form class="formulario" method="POST" action="/">

    <div class="campo">
        <label for="email">Correo</label>
        <input
            type="email"
            id="email"
            placeholder="mariadonoso@gmail.com"
            name="email"
            value="<?php echo s($auth->email) ?>"
        >
    </div>

    <div class="campo">
        <label for="password">Clave</label>
        <input
            type="password"
            id="password"
            placeholder="*****"
            name="password"
        >
    </div>

    <input type="submit" class="boton" value="Iniciar sesión">
</form>

<div class="acciones">
    <a href="/signup">Registrarse.</a>
    <a href="/olvide">Olvidé mi contraseña.</a>
</div>