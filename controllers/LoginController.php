<?php

namespace Controller;

use MVC\Router;
use Model\Usuario;
use Class\Email;

class LoginController {

    public static function login(Router $router) {

        $auth = new Usuario();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $auth = new Usuario($_POST);

            $alertas = $auth->validarLogin();
            if (empty($alertas)) {

                $usuario = Usuario::where('email', $auth->email);
                if ($usuario) {

                    $login = $usuario->confirmaClaveConfirmado($auth->password);

                    if ($login) {
                        session_start(); // Ya está en el router
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . ' ' . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;
    
                        if ($usuario->admin == 1) {
                            $_SESSION['admin'] = $usuario->admin;
                            header('Location: /admin');
                        }
                        else header('Location: /cita');
                    }
                }
                else {
                    Usuario::setAlerta('error', 'Cuenta no registrada.');
                }
            }
        }
        $alertas = Usuario::getAlertas();

        $router->view('auth/login', [
            'auth' => $auth,
            'alertas' => $alertas
        ]); 
    }

    public static function logout() {

        session_start();

        $_SESSION = [];

        header('Location: /');
    }

    public static function olvide(Router $router) {

        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $auth = new Usuario($_POST);

            $alertas = $auth->validarEmail();

            if (empty($alertas)) {

                $usuario = Usuario::where('email', $auth->email);

                if ($usuario && $usuario->confirmado == 1) {

                    $usuario->crearToken();
                    $usuario->guardar();

                    $mail = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $mail->mailOlvide();

                    Usuario::setAlerta('exito', 'Se ha enviado un correo para reestablecer su contraseña.');
                }
                else {
                    Usuario::setAlerta('error', 'Este correo no está registrado o confirmado.');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->view('auth/olvide', [

            'alertas' => $alertas

        ]);
    }

    public static function recuperar(Router $router) {

        $token = s($_GET['token']);
        $error = false;
        // Buscar usuario por su token
        $usuario = Usuario::where('token', $token);

        if (!$usuario) {
            Usuario::setAlerta('error', 'Token no válido');
            $error = true;
        }
        else {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $clave = new Usuario($_POST);
                
                $alertas = $clave->validarClave();

                if (empty($alertas)) {
                    
                    $usuario->password = $clave->password;

                    $usuario->hashearClave();

                    $usuario->token = null;

                    $resultado = $usuario->guardar();

                    if ($resultado) header('Location: /');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->view('auth/recuperar', [

            'alertas' => $alertas,
            'error' => $error
        ]);
    }

    
    public static function signup(Router $router) {

        $usuario = new Usuario;
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $usuario->sincronizar($_POST);

            $alertas = $usuario->validarNuevaCuenta();

            if (empty($alertas)) {
                // Verificar correo
                $resultado = $usuario->existeUsuario();

                if ($resultado->num_rows) { // Correo ya registrado
                    $alertas = Usuario::getAlertas();
                }
                else {
                    $usuario->hashearClave();
                    $usuario->crearToken();

                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->mailSignup();

                    $resultado = $usuario->guardar(); // sin id guardar llama a crear()

                    if ($resultado) header('Location: /mensaje');

                    // $alertas['exito'][] = 'Se ha registrado con éxito, confirme su cuenta con el link enviado a su correo.' ;
                }
            }
        }
        $router->view('auth/signup', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]); 
    }


    public static function mensaje(Router $router) {

        $router->view('auth/mensaje', [

        ]);
    }


    public static function confirmar(Router $router) {

        $token = s($_GET['token']);
        
        $usuario = Usuario::where('token', $token);

        if (empty($usuario)) Usuario::setAlerta('error', 'Token no válido.');
    
        else {            
            $usuario->confirmado = 1;
            $usuario->token = null;
            $usuario->guardar();

            Usuario::setAlerta('exito', 'Su cuenta ha sido confirmada.');
        }
        
        $alertas = Usuario::getAlertas();

        $router->view('auth/confirmar', [
            'alertas' => $alertas

        ]);
    }
}