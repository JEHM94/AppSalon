<?php

namespace Model;

class AdminCita extends ActiveRecord
{
    // Base DE DATOS
    protected static $tabla = 'citas_has_servicios';
    protected static $columnasDB = ['id', 'hora', 'fecha', 'cliente', 'email', 'telefono', 'servicio', 'precio'];

    public $id;
    public $hora;
    public $fecha;
    public $cliente;
    public $email;
    public $telefono;
    public $servicio;
    public $precio;

    public function __construct($array = [])
    {
        $this->id = $array['id'] ?? null;
        $this->hora = $array['hora'] ?? '';
        $this->fecha = $array['fecha'] ?? '';
        $this->cliente = $array['cliente'] ?? '';
        $this->email = $array['email'] ?? '';
        $this->telefono = $array['telefono'] ?? '';
        $this->servicio = $array['servicio'] ?? '';
        $this->precio = $array['precio'] ?? '';
    }
}
