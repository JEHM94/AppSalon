<?php

namespace Model;

class Servicio extends ActiveRecord
{
    // Base DE DATOS
    protected static $tabla = 'servicios';
    protected static $columnasDB = ['id', 'nombre', 'precio'];

    public $id;
    public $nombre;
    public $precio;

    public function __construct($array = [])
    {
        $this->id = $array['id'] ?? null;
        $this->nombre = $array['nombre'] ?? '';
        $this->precio = $array['precio'] ?? '';
    }
}
