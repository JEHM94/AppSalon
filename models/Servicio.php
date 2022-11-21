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

    public function validar($tipoValidacion = null)
    {
        // Validación de Nombre de Servicio
        if (!$this->nombre) {
            self::$alertas[ERROR][] = 'El nombre del Servicio es obligatorio';
        }

        // Validación de Precio de Servicio
        if (!$this->precio) {
            self::$alertas[ERROR][] = 'El precio del Servicio es obligatorio';
        }
        // Si no es un valor numérico o es menor igual a cero.
        elseif (!is_numeric($this->precio) || $this->precio <= 0) {
            self::$alertas[ERROR][] = 'El precio no es válido';
        }
    }
}
