<?php

namespace Model;

class Cita extends Active {

    protected static $tabla = 'citas',
    $columnasDB = ['id', 'fecha', 'hora', 'usuarioId'];

    public $id, $fecha, $hora, $usuarioId;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->fecha = $args['fecha'] ?? '';
        $this->hora = $args['hora'] ?? '';
        $this->usuarioId = $args['usuarioId'] ?? '';
    }

}