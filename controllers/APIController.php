<?php
namespace Controller;

use Model\Servicio;
use Model\Cita;
use Model\CitaServicio;

class APIController {

    public static function index() {

        $servicios = Servicio::all();
        
        echo json_encode($servicios);
    }

    public static function guardar() { // /cita POST
        
        $cita = new Cita($_POST);
        // Se guarda en tabla citas
        $resultado = $cita->guardar();
        
        // Guardar cita retorna insert_id
        $id = $resultado['id'];

        // String de servicios a array
        $idServicios = explode(',', $_POST['servicios']);

        // Una cita con distintos servicios
        foreach ($idServicios as $idServicio) {
            $args = [
                'citaId' => $id,
                'servicioId' => $idServicio
            ];
            $citaServicio = new CitaServicio($args);
            // Se guarda en tabla citasservicios
            $citaServicio->guardar();
        }

        echo json_encode(['guardado' => $resultado]);
    }


    public static function eliminar() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $cita = Cita::find($_POST['id']);

            if ($cita) $cita->eliminar();

            header('Location: ' . $_SERVER['HTTP_REFERER']); // Vuelve a la página anterior

        }
    }
}