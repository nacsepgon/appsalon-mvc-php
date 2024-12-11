<h1 class="nombre-pagina">Panel de administración</h1>

<?php include_once __DIR__ . '/../templates/barra.php' ?>

<h2>Buscar citas</h2>
<div class="busqueda">

    <form class="formulario">

        <div class="campo">
            <label for="fecha">Fecha</label>
            <input
                type="date"
                name="fecha"
                id="fecha"
                value="<?php echo $fecha ?>"
            >
        </div>

    </form>
</div>

<?php
    if (count($citas) === 0) {
        echo '<h3>No hay citas para el ' . $fecha . '.</h3>';
    }
?>

<div id="citas-admin">

    <ul class="citas">
        
        <?php $idCita = 0;
        
        foreach ($citas as $key => $cita) {

            $actual = $cita->id;
            $proximo = $citas[$key + 1]->id ?? 0;

            if ($idCita !== $cita->id) {
                $idCita = $cita->id;
                $total = 0 ?>

                <li>
                    <p>Cita <span><?php echo $cita->id ?></span></p>
                    <p>Hora: <span><?php echo $cita->hora ?></span></p>
                    <p>Cliente: <span><?php echo $cita->cliente ?></span></p>
                    <p>Correo: <span><?php echo $cita->email ?></span></p>
                    <p>Teléfono: <span><?php echo $cita->telefono ?></span></p>
                    <h3>Servicio<?php echo $actual == $proximo ? 's' : '' ?>:</h3> 
            <?php }

            $total += $cita->precio ?>
            
            <p class="servicios"><?php echo $cita->servicio ?> ($<?php echo $cita->precio ?>)</p>
            
            <!-- Último servicio -->
            <?php if ($actual != $proximo) { ?> 

                    <p>Total: <span>$<?php echo $total ?></span></p>

                    <form action="/api/eliminar" method="POST">
                        <input type="hidden" name=id value="<?php echo $cita->id ?>">
                        <input type="submit" class="boton-eliminar" value="Eliminar">
                    </form>

            <?php }
        } ?>
    </ul>
</div>

<?php 
    $script = "<script src='/build/js/buscador.js'></script>"
?>