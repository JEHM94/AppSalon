<?php

namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController
{

    public static function index(Router $router)
    {
        // Obtiene la fecha ingresada
        $fecha = $_GET['fecha'] ?? null;

        if ($fecha) {
            // Crea un array separando la fecha por "-"
            $fechaValida = explode('-', $fecha);

            // Si el array no contiene 3 posiciones separadas por "-" (2000-12-22), redirecciona
            if (sizeof($fechaValida) !== 3) header('Location: /admin');

            // Verifica que los elementos del array no esten vacíos
            foreach ($fechaValida as $elemento) if (!$elemento) header('Location: /admin');

            // Verifica que sea una fecha válida o redirecciona
            if (!checkdate($fechaValida[1], $fechaValida[2], $fechaValida[0])) header('Location: /admin');
        } else {
            // Si no fue ingresada ninguna fecha
            // Asigna la fecha actual para mostrar las citas de ese día por defecto
            date_default_timezone_set("America/Mexico_City");
            $fecha = date('Y-m-d');
        }



        // Consulta las citas 
        $consulta = "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
        $consulta .= " FROM citas  ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON citas.usuarios_id=usuarios.id  ";
        $consulta .= " LEFT OUTER JOIN citas_has_servicios ";
        $consulta .= " ON citas_has_servicios.citas_id=citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id=citas_has_servicios.servicios_id ";
        $consulta .= " WHERE fecha =  '${fecha}' ";

        $citas = AdminCita::SQL($consulta);

        $router->render('admin/index', [
            'nombre' => $_SESSION['nombre'] ?? '',
            'citas' => $citas,
            'fecha' => $fecha
        ]);
    }
}
