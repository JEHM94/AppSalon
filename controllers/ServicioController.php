<?php

namespace Controllers;

use Model\Servicio;
use MVC\Router;

class ServicioController
{
    public static function index(Router $router)
    {
        // Busca todos los servicios
        $servicios = Servicio::all();

        $router->render('servicios/index', [
            'nombre' => $_SESSION['nombre'] ?? '',
            'servicios' => $servicios,

        ]);
    }

    public static function crear(Router $router)
    {
        // Crea una nueva instancia del servicio para pasarlo a la vista
        $servicio = new Servicio();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Instancia un nuevo servicio con los datos del formulario
            $servicio->sincronizar($_POST);
            // Valida los datos
            $servicio->validar();
            // Obtener las Alertas de validación de formulario
            $alertas = Servicio::getAlertas();
            // Revisar que el Usuario pase la validación del Formulario
            if (empty($alertas)) {
                // Almacena el servicio en la DB
                $resultado = $servicio->guardar();

                if ($resultado) {
                    Servicio::setAlerta(EXITO, '¡Servicio Creado Correctamente!');
                    $servicio->nombre = '';
                    $servicio->precio = '';
                }
            }
        }
        $alertas = Servicio::getAlertas();

        $router->render('servicios/crear', [
            'nombre' => $_SESSION['nombre'] ?? '',
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }

    public static function actualizar(Router $router)
    {
        // Verifica que sea un ID válido
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        // Si el id no es un número entero, redirecciona
        if (!$id) header('Location: /');
        // Busca el servicio con el id ingresado
        $servicio = Servicio::find($id);

        // Si no encuentra el servicio, redirecciona
        if (!$servicio) header('Location: /');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Instancia un nuevo servicio con los datos del formulario
            $servicio->sincronizar($_POST);
            // Valida los datos
            $servicio->validar();
            // Obtener las Alertas de validación de formulario
            $alertas = Servicio::getAlertas();
            // Revisar que el Usuario pase la validación del Formulario
            if (empty($alertas)) {
                // Actualiza el servicio en la DB
                $resultado = $servicio->guardar();

                if ($resultado) {
                    Servicio::setAlerta(EXITO, '¡Servicio Actualizado Correctamente!');
                }
            }
        }

        $alertas = Servicio::getAlertas();

        $router->render('servicios/actualizar', [
            'nombre' => $_SESSION['nombre'] ?? '',
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }
}
