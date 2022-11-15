<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController
{
    public static function login(Router $router)
    {
        // Verifica que no exista una sesión activa antes de iniciar el proceso de login
        $isAuth = $_SESSION['login'] ?? null;

        if ($isAuth) {
            header('Location: /cita');
            return;
        }

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
                    Usuario::setAlerta(ERROR, 'El E-mail no se encuentra registrado');
                    return;
                } else {
                    // Usuario encontrado, se Procede a verificar la Contraseña
                    $verificado = $usuario->comprobarPasswordYVerificado($auth->password);
                    // Si el Usuario ha sido verificado correctamente procedemos a Iniciar Sesión
                    if ($verificado) {
                        // Autenticamos al usuario
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
                            // Retornamos para evitar que se ejecute el siguiente 
                            // header('Location: /cita'); sustituyendo al de Admin
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
            'alertas' => $alertas,
            'usuario' => $usuario ?? null
        ]);
    }

    public static function logout()
    {
        $_SESSION = [];
        header('Location: /');
    }

    public static function olvide(Router $router)
    {
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtenemos el Email e instanciamos un nuevo Usuario
            $auth =  new Usuario($_POST);
            // Validamos el Inicio de Sesión
            $auth->validar(RECUPERAR_CUENTA);
            // Obtener las Alertas de validación de formulario
            $alertas = Usuario::getAlertas();
            // Revisar que el Usuario pase la validación del Formulario
            if (empty($alertas)) {
                // Buscamos el usuario
                $usuario = Usuario::where('email', $auth->email);
                // Comprobamos si el usuario existe y si está confirmado
                if ($usuario && $usuario->confirmado === '1') {
                    // Generamos un nuevo Token para Reestablecer la contraseña
                    $usuario->crearToken();
                    // Actualizamos el usuario en la DB
                    $resultado = $usuario->guardar();

                    if ($resultado) {
                        //**  Instanciamos y Enviamos E-mail de Reestablecimiento de contraseña
                        $email = new Email($usuario->email, $usuario->nombre, $usuario->apellido, $usuario->token);
                        if ($email->enviarConfirmacion(RECUPERAR_CUENTA)) {
                            // Si el Email se envía correctamente, Generamos Alerta de éxito
                            Usuario::setAlerta(EXITO, 'Las instrucciones para reestablecer su contraseña han sido enviadas a su e-mail');
                        }
                    }
                } else {
                    // Generamos Alerta de error
                    Usuario::setAlerta(ERROR, 'El e-mail no existe o no está confirmado');
                }
            }
        }
        // Obtener las Alertas de validación de formulario
        $alertas = Usuario::getAlertas();

        $router->render('auth/olvide-password', [
            'alertas' => $alertas
        ]);
    }

    public static function recuperar(Router $router)
    {
        $alertas = [];
        $confirmado = true;
        $actualizado = false;

        // Verificamos el Token ingresado
        $usuario = Usuario::verificarToken($_GET['token'] ?? null);
        // Si existe un usuario y su token es válido, Comprobamos que su E-mail ya esté confirmado.
        // En caso contrario, Mostramos una Alerta de Eror
        if ($usuario->confirmado === '0') {
            Usuario::setAlerta(ERROR, 'Su dirección de E-mail aún no ha sido Verificada');
            $confirmado = false;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Leer la nueva Contraseña y guardarla
            $password = new Usuario($_POST);
            // Validamos la nueva Contraseña
            $password->validar(CAMBIAR_PASSWORD);
            // Obtenemos las alertas
            $alertas = Usuario::getAlertas();
            if (!$alertas) {
                // Si no hay alertas reasignamos el Password y lo Hasheamos
                $usuario->password = $password->password;
                $usuario->hashPassword();
                // Eliminamos el Token
                $usuario->token = null;
                // Actualizamos la Password en la DB
                if ($usuario->guardar()) {
                    $actualizado = true;
                    // Creamos Alerta de Exito
                    Usuario::setAlerta(EXITO, 'Contraseña cambiada Exitosamente');
                }
            }
        }

        // Obtenemos las alertas
        $alertas = Usuario::getAlertas();

        $router->render('auth/recuperar-password', [
            'alertas' => $alertas,
            'confirmado' => $confirmado,
            'actualizado' => $actualizado,
            'usuario' => $usuario
        ]);
    }

    public static function reenviar(Router $router)
    {
        $alertas = [];
        // Verificamos el Token ingresado
        $usuario = Usuario::verificarToken($_GET['token'] ?? null);

        // Si el Usuario ya está confirmado, Redireccionamos
        if ($usuario->confirmado === '1') {
            header('Locaion: /');
        }
        // Si el usuario aún no está confirmado procedemos a renovar el token y enviar el e-mail de verificación
        // Renovamos el Token
        $usuario->crearToken();
        // Actualizamos el usuario en la DB
        $resultado = $usuario->guardar();
        if ($resultado) {
            // Creamos el e-mail
            $email = new Email($usuario->email, $usuario->nombre, $usuario->apellido, $usuario->token);
            // Enviamos
            if ($email->enviarConfirmacion(CUENTA_NUEVA)) {
                // Si el Email se envía correctamente, Generamos Alerta de éxito
                Usuario::setAlerta(EXITO, 'Revisa tu E-mail y sigue las instrucciones que fueron enviadas');
            }
        }
        // Obtenemos las alertas
        $alertas = Usuario::getAlertas();

        $router->render('auth/reenviar-token', [
            'alertas' => $alertas
        ]);
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
            Usuario::setAlerta(ERROR, 'Token no válido');
            $textoBoton = 'Regresar';
        } else {
            // Modificar el Estado del Usuario a confirmado
            $usuario->confirmado = 1;
            // Eliminamos el Token para que no pueda ser utilizado en otras transsaciones
            $usuario->token = null;
            // Actualizamos el Estado del Usuario en la DB
            $usuario->guardar();
            // Mostrar mensaje de Éxito
            Usuario::setAlerta(EXITO, '¡Cuenta Verificada Correctamente!');
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
                        $email->enviarConfirmacion(CUENTA_NUEVA);

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
