<?php

namespace Model;

class Servicio extends Active {

    // Base de datos
    protected static $tabla = 'servicios',
    $columnasDB = ['id', 'nombre', 'precio'];

    public $id, $nombre, $precio;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->precio = $args['precio'] ?? '';
    }

    public function validar() {
        if(!$this->nombre) self::$alertas['error'][] = 'Escribe el nombre del servicio';

        if(!$this->precio) self::$alertas['error'][] = 'El precio es obligatorio';

        else if(!is_numeric($this->precio)) self::$alertas['error'][] = 'Precio no válido';
        
        return self::$alertas;
    }
}