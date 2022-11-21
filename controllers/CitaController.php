<?php

namespace Controllers;

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

        $citas = [];

        $router->render('cita/ver', [
            'nombre' => $_SESSION['nombre'] ?? '',
            'id' => $_SESSION['id'] ?? '',
            'citas' => $citas
        ]);
    }
}
