<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController
{
    public static function login(Router $router)
    {
        $auth = new Usuario();
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtenemos el Email y Password e instanciamos un nuevo Usuario
            $auth =  new Usuario($_POST);
            // Validamos el Inicio de Sesión
            $auth->validar(CUENTA_EXISTENTE);
            // Obtener las Alertas de validación de formulario
            $alertas = Usuario::getAlertas();
            // Revisar que el Usuario pase la validación del Formulario
            if (empty($alertas)) {
                // Buscamos si existe algún usuario con el Email ingresado
                $usuario = Usuario::where('email', $auth->email);
                // Si no existe el usuario Generamos el Error
                if (empty($usuario)) {
                    Usuario::setAlerta('error', 'El E-mail no se encuentra registrado');
                    return;
                } else {
                    // Usuario encontrado, se Procede a verificar la Contraseña
                    $verificado = $usuario->comprobarPasswordYVerificado($auth->password);
                    // Si el Usuario ha sido verificado correctamente procedemos a Iniciar Sesión
                    if ($verificado) {
                        // Autenticamos al usuario
                        session_start();
                        // Asignamos los datos de la cuenta a la sesión
                        $_SESSION['id'] =  $usuario->id;
                        $_SESSION['nombre'] =  $usuario->nombre . ' ' .  $usuario->apellido;
                        $_SESSION['email'] =  $usuario->email;
                        $_SESSION['login'] =  true;
                        // Redireccionamos al Usuario

                        if ($usuario->admin === "1") {
                            // Si el usuario es un administrador, agregamos Admin a la sesión
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            // Redireccionamos a Admin
                            header('Location: /admin');
                            return;
                        }
                        // Si es un usuario regular, Redireccionamos a la página de Citas
                        header('Location: /cita');
                    }
                }
            }
        }

        // Obtener las Alertas de validación de formulario
        $alertas = Usuario::getAlertas();

        $router->render('auth/login', [
            'auth' => $auth,
            'alertas' => $alertas
        ]);
    }

    public static function logout()
    {
        echo 'desde logout';
    }

    public static function olvide(Router $router)
    {
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        }

        $router->render('auth/olvide-password', [
            'alertas' => $alertas
        ]);
    }

    public static function recuperar()
    {
        echo 'desde recuperar';
    }

    public static function confirmar(Router $router)
    {
        $alertas = [];
        // Obtenemos el Token
        $token = s($_GET['token'] ?? null);

        if (empty($token)) {
            // Si no hay un token para buscar, se redirecciona de vuelta
            header('Location: /');
        }
        // Buscamos si existe algún usuario con el Token ingresado
        $usuario = Usuario::where('token', $token);
        if (empty($usuario)) {
            // Si no se encuantra ningún usuario, creamos alerta de Error
            Usuario::setAlerta('error', 'Token no válido');
            $textoBoton = 'Regresar';
        } else {
            // Modificar el Estado del Usuario a confirmado
            $usuario->confirmado = 1;
            // Eliminamos el Token para que no pueda ser utilizado en otras transsaciones
            $usuario->token = null;
            // Actualizamos el Estado del Usuario en la DB
            $usuario->guardar();
            // Mostrar mensaje de Éxito
            Usuario::setAlerta('exito', '¡Cuenta Verificada Correctamente!');
            $textoBoton = 'Iniciar Sesión';
        }

        // Obtenemos las Alertas generadas
        $alertas = Usuario::getAlertas();

        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas,
            'textoBoton' => $textoBoton
        ]);
    }

    public static function mensaje(Router $router)
    {
        $router->render('auth/mensaje');
    }

    public static function crear(Router $router)
    {
        // Crea un Nuevo Usuario
        $usuario = new Usuario();
        // Crear alertas
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sincroniza los datos enviados en POST con el Usuario creado
            $usuario->sincronizar($_POST);
            // Validamos La información ingresada en el formulario
            $usuario->validar(CUENTA_NUEVA);
            // Obtener las Alertas de validación de formulario
            $alertas = Usuario::getAlertas();
            // Revisar que el Usuario pase la validación del Formulario
            if (empty($alertas)) {
                // Revisar que el E-mail no este Registrado en el Sistema
                $resultado = $usuario->existeUsuario();
                // Obtener las Alertas de Usuario Existente
                if ($resultado->num_rows) {
                    $alertas = Usuario::getAlertas();
                } else {
                    // El E-mail no está registrado
                    // Hashear el Password
                    $usuario->hashPassword();
                    // Generamos un nuevo Token de Verificación
                    $usuario->crearToken();
                    // Creamos el usuario
                    $resultado = $usuario->guardar();
                    if ($resultado) {
                        // Enviamos el E-mail de Confirmación de cuenta
                        $email = new Email($usuario->email, $usuario->nombre, $usuario->apellido, $usuario->token);
                        $email->enviarConfirmacion();

                        header('Location: /mensaje');
                    }
                }
            }
        }

        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }
}
