<?php

namespace Controller;

use MVC\Router;
use Model\AdminCita;

class AdminController {

    public static function index(Router $router) {

        session_start();
        isAuth();
        isAdmin();

        // Fecha seleccionada y si no, la del servidor
        $fecha =  $_GET['fecha'] ?? date('Y-m-d');

        $fechas = explode('-', $fecha);
        
        if (!checkdate($fechas[1], $fechas[2], $fechas[0])) {
            header('Location: /404');
        }

        $q = "SELECT citas.id, citas.hora, CONCAT(usuarios.nombre, ' ', usuarios.apellido) AS cliente, ";
        $q .= "servicios.nombre AS servicio, precio, email, telefono FROM citas ";
        $q .= "LEFT JOIN usuarios ON usuarios.id = citas.usuarioId ";
        $q .= "LEFT JOIN citasservicios ON citaId = citas.id ";
        $q .= "LEFT JOIN servicios ON servicios.id = servicioId ";
        $q .= "WHERE fecha = '{$fecha}'";

        $citas = AdminCita::SQL($q);


        $router->view('admin/index', [
            'id' => $_SESSION['id'] ?? '',
            'nombre' => $_SESSION['nombre'] ?? '',
            'citas' => $citas,
            'fecha' => $fecha
            
        ]);

    }
}