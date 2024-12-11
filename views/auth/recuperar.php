<h1 class="nombre-pagina">Recuperar clave</h1>

<?php include_once __DIR__ . '/../templates/alertas.php' ?>

<?php if ($error) return ?>

<p class="descripcion-pagina">Escribe tu nueva clave a continuación</p>

<form class="formulario" method="POST">
    <div class="campo">
        <label for="password">Clave nueva</label>
        <input
            type="password"
            id="password"
            name="password"
            placeholder="*****"
        >
    </div>
    <input type="submit" class="boton" value="Guardar nueva clave" >
</form>

<div class="acciones">
    <a href="/">Iniciar sesión</a>
    <a href="/signup">Crear cuenta</a>
</div>