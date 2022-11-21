<?php

namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class CitaController
{
    public static function index(Router $router)
    {
        // Verifica si el usuario es un administrador y redirecciona
        // Esto debido a que este es un panel de usuario corriente
        $isAdmin = $_SESSION['admin'] ?? null;

        if ($isAdmin) header('Location: /admin');

        $router->render('cita/index', [
            'nombre' => $_SESSION['nombre'] ?? '',
            'id' => $_SESSION['id'] ?? ''
        ]);
    }

    public static function ver(Router $router)
    {
        // Verifica si el usuario es un administrador y redirecciona
        // Esto debido a que este es un panel de usuario corriente
        $isAdmin = $_SESSION['admin'] ?? null;

        if ($isAdmin) header('Location: /admin');

        // Consulta las citas 
        $consulta = "SELECT citas.id, citas.hora, citas.fecha, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
        $consulta .= " FROM citas  ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON citas.usuarios_id=usuarios.id  ";
        $consulta .= " LEFT OUTER JOIN citas_has_servicios ";
        $consulta .= " ON citas_has_servicios.citas_id=citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id=citas_has_servicios.servicios_id ";
        $consulta .= " WHERE usuarios_id =  '${_SESSION['id']}' ";
        $consulta .= " ORDER BY fecha ASC";

        $citas = AdminCita::SQL($consulta);

        $router->render('cita/ver', [
            'nombre' => $_SESSION['nombre'] ?? '',
            'citas' => $citas
        ]);
    }
}
