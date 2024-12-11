<?php

namespace Model;

class Usuario extends Active {

    protected static $tabla = 'usuarios',
    $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password','telefono', 'admin', 'confirmado', 'token'];

    public $id, $nombre, $apellido, $email, $password, $telefono, $admin, $confirmado, $token;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? 0;
        $this->confirmado = $args['confirmado'] ?? 0;
        $this->token = $args['token'] ?? '';
    }

    public function validarNuevaCuenta() {
        if (!$this->nombre) self::$alertas['error'][] = 'El nombre es obligatorio.';
        if (!$this->apellido)  self::$alertas['error'][] = 'El apellido es obligatorio.';
        if (!$this->email) self::$alertas['error'][] = 'El correo es obligatorio.';
        if (!$this->telefono) self::$alertas['error'][] = 'El número de teléfono es obligatorio.';

        if (!$this->password) self::$alertas['error'][] = 'Escribe una clave.';

        else if (strlen($this->password) < 6) self::$alertas['error'][] = 'La clave debe contener 6 carácteres o más.';

        return self::$alertas;
    }

    public function validarLogin() {

        if (!$this->email) self::$alertas['error'][] = 'Escribe el correo registrado.';

        if (!$this->password) self::$alertas['error'][] = 'Digita la clave.';

        return self::$alertas;
    }

    public function validarEmail() {
        
        if (!$this->email) self::$alertas['error'][] = 'Escribe el correo registrado.';

        return self::$alertas;
    }

    public function validarClave() {

        if (!$this->password) self::$alertas['error'][] = 'Escribe la nueva clave.';

        else if (strlen($this->password) < 6) self::$alertas['error'][] = 'La clave debe contener 6 carácteres o más.';

        return self::$alertas;
    }

    public function existeUsuario() {
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

        $resultado = self::$db->query($query);

        if($resultado->num_rows) {
            self::$alertas['error'][] = 'El correo ya está registrado';
        }
        return $resultado;
    }


    public function hashearClave() { $this->password = password_hash($this->password, PASSWORD_BCRYPT); }

    public function crearToken() { $this->token = uniqid(); }


    public function confirmaClaveConfirmado($clave) {
        
        $resultado = password_verify($clave, $this->password);

        if (!$resultado) self::$alertas['error'][] = 'Clave incorrecta.';

        else if (!$this->confirmado) self::$alertas['error'][] = 'Cuenta no confirmada, revise su correo.'; 
        
        else return true;
    }

}

