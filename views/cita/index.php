<h1 class="nombre-pagina">Agenda tu cita</h1>

<p class="descripcion-pagina">Escoge tus servicios</p>

<?php include_once __DIR__ . '/../templates/barra.php' ?>

<div class="app">

    <nav class="tabs">
        <button type="button" data-paso="1">Servicios</button> <!-- data-atributo personalizado-->
        <button type="button" data-paso="2">Datos y citas</button>
        <button type="button" data-paso="3">Resumen</button>
    </nav>

    <div class="seccion" id="paso-1">
        <h2>Servicios</h2>
        <p class="txt-center">Elige tus servicios</p>
        <div class="listado-servicios" id="servicios"></div>
    </div>

    <div class="seccion" id="paso-2">
        <h2>Datos y cita</h2>
        <p class="txt-center">Coloca tus datos y fecha de la cita</p>
        <form class="formulario">
        <div class="campo">
                <label for="nombre">Nombre</label>
                <input
                    type="text"
                    name="nombre"
                    id="nombre"
                    placeholder="Nicolás Charri"
                    value = "<?php echo $nombre ?>"
                    disabled
                >
            </div>
            <div class="campo">
                <label for="fecha">Fecha</label>
                <input
                    type="date"
                    name="fecha"
                    id="fecha"
                    min="<?php echo date('Y-m-d', strtotime('+1 day')) ?>"
                >
            </div>
            <div class="campo">
                <label for="hora">Fecha</label>
                <input
                    type="time"
                    name="hora"
                    id="hora"
                >
            </div>
            <input type="hidden" id=id value="<?php echo $id ?>">
        </form>
    </div>

    <div class="seccion resumen" id="paso-3">
        <h2>Resumen</h2>
        <p class="txt-center">Verifica que la información sea correcta</p>
    </div>

    <div class="paginacion">
        <button id="anterior" class="boton">&laquo; Anterior</button>
        <button id="siguiente" class="boton">Siguiente &raquo;</button>
    </div>
    
</div>

<?php $script = "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script src='build/js/app.js'></script>
    "
?>