<?php

namespace Model;

class CitaServicio extends Active {
    protected static $tabla = 'citasservicios',
    $columnasDB = ['id', 'citaId', 'servicioId'];

    public $id, $citaId, $servicioId;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->citaId = $args['citaId'] ?? '';
        $this->servicioId = $args['servicioId'] ?? '';
        
    }

}