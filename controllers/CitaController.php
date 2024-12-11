<?php
namespace Controller;
use MVC\Router;

class CitaController {

    public static function index(Router $router) {

        session_start();

        isAuth();

        $router->view('cita/index', [
            'nombre' => $_SESSION['nombre'] ?? '',
            'id' => $_SESSION['id'] ?? ''
        ]);
    }

}