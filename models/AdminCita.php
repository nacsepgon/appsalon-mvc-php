<?php

namespace Model;

class AdminCita extends Active {

    // protected static $tabla = 'citasservicios'; // no se usa (aún)

    protected static $columnasDB = ['id', 'hora', 'cliente', 'servicio', 'precio', 'email', 'telefono'];

    public $id, $hora, $cliente, $servicio, $precio, $email, $telefono;

    public function __construct($args = []) {

        $this->id = $args['id'] ?? null;
        $this->hora = $args['hora'] ?? '';
        $this->cliente = $args['cliente'] ?? '';
        $this->servicio = $args['servicio'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        
    }


}