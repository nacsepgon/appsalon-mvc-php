<?php

namespace Controller;

use MVC\Router;
use Model\Servicio;

class ServicioController {

    public static function index(Router $router) {

        session_start();
        isAdmin();

        $servicios = Servicio::all();
        
        $router->view('servicios/index', [
            'id' => $_SESSION['id'] ?? '',
            'nombre' => $_SESSION['nombre'] ?? '',
            'servicios' => $servicios

        ]);
    }

    public static function crear(Router $router) {
        
        session_start();
        isAdmin();

        $servicio = new Servicio;

        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $servicio->sincronizar($_POST);

            $alertas = $servicio->validar();

            if (empty($alertas)) {
                $servicio->guardar();
                header('Location: /servicios');
            }
        }

        $router->view('servicios/crear', [
            
            'id' => $_SESSION['id'] ?? '',
            'nombre' => $_SESSION['nombre'] ?? '',
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }


    public static function actualizar(Router $router) {

        session_start();
        isAdmin();

        $id = $_GET['id'] ?? '';

        if (!is_numeric($id)) header('Location: /servicios');

        $servicio = Servicio::find($id);

        if (!$servicio) header('Location: /servicios');

        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $servicio->sincronizar($_POST);

            $alertas = $servicio->validar();

            if (empty($alertas)) {
                $servicio->guardar();
                header('Location: /servicios');
            }
            
        }

        $router->view('servicios/actualizar', [

            'nombre' => $_SESSION['nombre'] ?? '',
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }


    public static function eliminar() {

        session_start();
        isAdmin();        

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $id = $_POST['id'];

            if (!is_numeric($id)) header('Location: /servicios');

            $servicio = Servicio::find($id);

            if ($servicio) $servicio->eliminar();

            header('Location: /servicios');
        }
    }  
}