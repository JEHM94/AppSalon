<?php

namespace Controllers;

use MVC\Router;

class CitaController
{
    public static function index(Router $router)
    {
        // Verifica si el usuario es un administrador y redirecciona
        // Esto debido a que un administrador no va a crear citas nuevas
        $isAdmin = $_SESSION['admin'] ?? null;

        if ($isAdmin) {
            header('Location: /admin');
            return;
        }

        $router->render('cita/index', [
            'nombre' => $_SESSION['nombre'] ?? '',
            'id' => $_SESSION['id'] ?? ''
        ]);
    }
}
