<h1 class="nombre-pagina">Crear cuenta</h1>
<p class="descripcion-pagina">Para registrarte llena el siguiente formulario</p>

<?php include_once __DIR__ . '/../templates/alertas.php' ?>

<form class="formulario" method="POST">

    <div class="campo">
        <label for="nombre">Nombre</label>
        <input
            type="text"
            id="nombre"
            name="nombre"
            placeholder="Nicolás"
            value="<?php echo s($usuario->nombre) ?>"
        >     
    </div>

    <div class="campo">
        <label for="apellido">Apellido</label>
        <input
            type="text"
            id="apellido"
            name="apellido"
            placeholder="Charri"
            value="<?php echo s($usuario->apellido) ?>"
        >     
    </div>

    <div class="campo">
        <label for="telefono">Teléfono</label>
        <input
            type="tel"
            id="telefono"
            name="telefono"
            placeholder="912345678"
            value="<?php echo s($usuario->telefono) ?>"
        >     
    </div>

    <div class="campo">
        <label for="email">Correo</label>
        <input
            type="email"
            id="email"
            name="email"
            placeholder="nicocharri@gmail.com"
            value="<?php echo s($usuario->email) ?>"  
        > 
            <!-- autocomplete=".com"  -->
    </div>

    <div class="campo">
        <label for="password">Clave</label>
        <input
            type="password"
            id="password"
            name="password"
            placeholder="*****"
        >     
    </div>

    <input type="submit" value="Registrarse" class="boton">
</form>

<div class="acciones">
    <a href="/">Ya tengo una cuenta.</a>
    <a href="/olvide">Olvidé mi contraseña.</a>
</div>