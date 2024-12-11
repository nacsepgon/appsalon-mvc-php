<h1 class="nombre-pagina">Olvidé mi contraseña</h1>
<p class="descripcion-pagina">Escribe tu correo para reestablecer clave</p>

<?php include_once __DIR__ . '/../templates/alertas.php' ?>

<form class="formulario" method="post">
   
<div class="campo">
        <label for="email">Correo</label>
        <input
            type="email"
            name="email"
            id="email"
            placeholder="nicocharri@gmail.com"
        >
    </div>

    <input type="submit" class="boton" value="Reestablecer">
</form>

<div class="acciones">
    <a href="/">Iniciar sesión.</a>
    <a href="/signup">Crear cuenta.</a>
</div>