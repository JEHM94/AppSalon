<?php

namespace Model;

class Usuario extends ActiveRecord
{
    // Base DE DATOS
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($array = [])
    {
        $this->id         = $array['id']         ?? null;
        $this->nombre     = $array['nombre']     ?? '';
        $this->apellido   = $array['apellido']   ?? '';
        $this->email      = $array['email']      ?? '';
        $this->password   = $array['password']   ?? '';
        $this->telefono   = $array['telefono']   ?? '';
        $this->admin      = $array['admin']      ?? '0';
        $this->confirmado = $array['confirmado'] ?? '0';
        $this->token      = $array['token']      ?? '';
    }

    // Mensajes de Validación para Crear nueva Cuenta
    public function validar($tipoValidacion)
    {
        switch ($tipoValidacion) {
            case CUENTA_NUEVA:
                // Validación de Nombre de Usuario
                if (!$this->nombre) {
                    self::$alertas[ERROR][] = 'Debe Ingresar su Nombre';
                }
                // Validación de Apellido de Usuario
                if (!$this->apellido) {
                    self::$alertas[ERROR][] = 'Debe Ingresar su Apellido';
                }
                // Validación de Teléfono de Usuario
                if (!$this->telefono) {
                    self::$alertas[ERROR][] = 'Debe Ingresar un Teléfono';
                } else {
                    if (strlen($this->telefono) != 10) {
                        self::$alertas[ERROR][] = 'Número de Teléfono Inválido';
                    }
                }
                // Validación de E-mail de Usuario
                if (!$this->email) {
                    self::$alertas[ERROR][] = 'Debe Ingresar su E-mail';
                }
                // Validación de Contraseña de Usuario
                if (!$this->password) {
                    self::$alertas[ERROR][] = 'Debe Ingresar una Contraseña';
                } else {
                    if (strlen($this->password) < 6) {
                        self::$alertas[ERROR][] = 'La Contraseña debe tener un mínimo de 6 caracteres';
                    }
                }
                break;
            case CUENTA_EXISTENTE:
                // Validación de E-mail de Usuario
                if (!$this->email) {
                    self::$alertas[ERROR][] = 'Debe Ingresar su E-mail';
                }
                // Validación de Contraseña de Usuario
                if (!$this->password) {
                    self::$alertas[ERROR][] = 'Debe Ingresar una Contraseña';
                }
                break;
            case RECUPERAR_CUENTA:
                // Validación de E-mail de Usuario
                if (!$this->email) {
                    self::$alertas[ERROR][] = 'Debe Ingresar su E-mail';
                }
                break;
            case CAMBIAR_PASSWORD:
                // Validación de Contraseña de Usuario
                if (!$this->password) {
                    self::$alertas[ERROR][] = 'Debe Ingresar una Contraseña';
                } else {
                    if (strlen($this->password) < 6) {
                        self::$alertas[ERROR][] = 'La Contraseña debe tener un mínimo de 6 caracteres';
                    }
                }
                break;
            default:
                break;
        }
    }

    // Revisa si el email ya existe
    public function existeUsuario()
    {
        $query = "SELECT * FROM ";
        $query .= self::$tabla;
        $query .= " WHERE email = '";
        $query .= $this->email;
        $query .= "' LIMIT 1";

        $resultado = self::$db->query($query);

        if ($resultado->num_rows) {
            self::$alertas[ERROR][] = 'El E-mail ya se encuentra en uso';
        }

        return $resultado;
    }

    public function hashPassword()
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken()
    {
        $this->token = uniqid();
    }

    public function comprobarPasswordYVerificado($password): bool
    {
        // Verificamos que la contraseña ingresada coincida con la de la BD
        if (!password_verify($password, $this->password)) {
            self::$alertas[ERROR][] = 'Contraseña Incorrecta';
            return false;
        }
        // Si las contraseñas coinciden, procedemos a verificar si el usuario está confirmado
        if (!$this->confirmado) {
            self::$alertas[ERROR][] = 'Debes Verificar tu cuenta antes de iniciar sesión';
            self::$alertas[NEUTRAL][] = 'Has click aquí para reenviar correo de Verificación';
            return false;
        }
        // Si la contraseña es correcta y el usuario está confirmado devolvemos TRUE
        return true;
    }

    public static function verificarToken($token)
    {
        // Obtenemos el token
        $token = s($token);

        // Si no existe ningún token, Redireccionamos
        if (!$token) {
            header('Location: /');
            return;
        }
        // En caso de que exista un token, buscamos si existe algún usuario con el Token ingresado
        $usuario = Usuario::where('token', $token);
        // Si no existe ningún usuario con ese token, Redireccionamos
        if (!$usuario) {
            header('Location: /');
            return;
        }
        return $usuario;
    }
}
