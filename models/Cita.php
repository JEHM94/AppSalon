<?php

namespace Model;

class Cita extends ActiveRecord
{
    // Base DE DATOS
    protected static $tabla = 'citas';
    protected static $columnasDB = ['id', 'fecha', 'hora', 'usuarios_id'];

    public $id;
    public $fecha;
    public $hora;
    public $usuarios_id;

    public function __construct($array = [])
    {
        $this->id = $array['id'] ?? null;
        $this->fecha = $array['fecha'] ?? '';
        $this->hora = $array['hora'] ?? '';
        $this->usuarios_id = $array['usuarios_id'] ?? '';
    }
}
