<?php

namespace MVC;

class Router
{
    public array $getRoutes = [];
    public array $postRoutes = [];

    public function get($url, $fn)
    {
        $this->getRoutes[$url] = $fn;
    }

    public function post($url, $fn)
    {
        $this->postRoutes[$url] = $fn;
    }

    public function comprobarRutas()
    {
        //$currentUrl = $_SERVER['REQUEST_URI'] === '' ? '/' : $_SERVER['REQUEST_URI'];
        $currentUrl = strtok($_SERVER['REQUEST_URI'], '?') ?? '/';

        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET') {
            $fn = $this->getRoutes[$currentUrl] ?? null;
        } else {
            $fn = $this->postRoutes[$currentUrl] ?? null;
        }

        //******* RUTAS PROTEGIDAS ******
        session_start();
        // Autenticación del usuario
        $auth = $_SESSION['login'] ?? null;
        $admin = $_SESSION['admin'] ?? null;

        // Array de Rutas Protegidas
        $protectedRoutes = [
            '/cita',
            '/cita/ver',
            '/api/servicios',
            '/api/citas',
            '/api/eliminarCita'

        ];

        // Array de Rutas Protegidas de Administrador
        $adminRoutes = [
            '/admin',
            '/servicios',
            '/servicios/crear',
            '/servicios/actualizar',
            '/api/eliminarServicio'
        ];

        // Si la Url actual es una ruta protegida
        // y el usuario no está autenticado, redirecciona a /
        if (in_array($currentUrl, $protectedRoutes) && !$auth) {
            header('Location: /');
        }

        // Si la Url actual es una ruta de Administrador
        // y el usuario no está autenticado como Admin, redirecciona a /
        if (in_array($currentUrl, $adminRoutes) && !$admin) {
            header('Location: /');
        }



        //******* RUTAS PROTEGIDAS FIN ******

        if ($fn) {
            // Call user fn va a llamar una función cuando no sabemos cual sera
            call_user_func($fn, $this); // This es para pasar argumentos
        } else {
            //echo "Página No Encontrada o Ruta no válida";
            $this->render('no-encontrada');
        }
    }

    public function render($view, $datos = [])
    {

        // Leer lo que le pasamos  a la vista
        foreach ($datos as $key => $value) {
            $$key = $value;  // Doble signo de dolar significa: variable variable, básicamente nuestra variable sigue siendo la original, pero al asignarla a otra no la reescribe, mantiene su valor, de esta forma el nombre de la variable se asigna dinamicamente
        }

        ob_start(); // Almacenamiento en memoria durante un momento...

        // entonces incluimos la vista en el layout
        include_once __DIR__ . "/views/$view.php";
        $contenido = ob_get_clean(); // Limpia el Buffer
        include_once __DIR__ . '/views/layout.php';
    }
}
