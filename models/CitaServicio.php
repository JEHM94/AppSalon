<?php

namespace Model;

class CitaServicio extends ActiveRecord
{
    // Base DE DATOS
    protected static $tabla = 'citas_has_servicios';
    protected static $columnasDB = ['id', 'citas_id', 'servicios_id'];

    public $id;
    public $citas_id;
    public $servicios_id;

    public function __construct($array = [])
    {
        $this->id = $array['id'] ?? null;
        $this->citas_id = $array['citas_id'] ?? '';
        $this->servicios_id = $array['servicios_id'] ?? '';
    }
}
