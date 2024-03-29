<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email
{
    public $email;
    public $nombre;
    public $apellido;
    public $token;

    public function __construct($email, $nombre, $apellido, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->token = $token;
    }

    public function enviarConfirmacion($tipoContenido)
    {
        // Create a new PHPMailer instance
        $mail = new PHPMailer();
        // Config SMTP
        $mail->isSMTP();
        $mail->Host = $_ENV['PHP_MAILER_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['PHP_MAILER_USERNAME'];
        $mail->Password = $_ENV['PHP_MAILER_PASSWORD'];
        $mail->SMTPSecure = 'tls';
        $mail->Port = $_ENV['PHP_MAILER_PORT'];

        // Config email Content
        $mail->setFrom('cuentas@appsalon.com');
        $receptor = $this->nombre . " " . $this->apellido;
        $mail->addAddress($this->email, $receptor);


        // Enable HTML
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $url = 'https://jehm-appsalon.alwaysdata.net';

        switch ($tipoContenido) {

            case CUENTA_NUEVA:
                $mail->Subject = 'AppSalon - Confirma tu cuenta';
                // Email content para Cuentas Nueva
                $contenido =  '<html>';
                $contenido .= '<p><strong>Bienvenido/a ' . $receptor . '.</strong></p>';
                $contenido .= '<p>¡Su cuenta en AppSalon ha sido creada exitosamente!.</p>';
                $contenido .= '<p>Haga click en el siguiente enlace para confirmar su E-mail y poder acceder a su cuenta.</p>';
                $contenido .= '<p><a href="' . $url . '/confirmar-cuenta?token=';
                $contenido .= $this->token;
                $contenido .= '">Confirmar E-mail</a></p>';
                $contenido .= '<p><strong>Si usted no solicitó la información anterior, puede ignorar este mensaje.</strong></p>';
                $contenido .= '</html>';

                // Texto plano alternativo
                $contenidoAlt = 'Bienvenido ' . $receptor . '. Visite el siguiente enlace para poder verificar su cuenta en AppSalon: ' . $url . '/confirmar-cuenta?token=' . $this->token . ' | Si usted no solicitó la información anterior, puede ignorar este mensaje.';

                break;
            case RECUPERAR_CUENTA:
                $mail->Subject = 'AppSalon - Reestablece tu contraseña';
                // Email content para Recuperar Contraseña
                $contenido =  '<html>';
                $contenido .= '<p><strong>Hola ' . $receptor . '.</strong></p>';
                $contenido .= '<p>Se ha solicitado el reestablecimiento de tu Contraseña.</p>';
                $contenido .= '<p>Haga click en el siguiente enlace para reestablecer su contraseña y poder acceder a su cuenta.</p>';
                $contenido .= '<p><a href="' . $url . '/recuperar?token=';
                $contenido .= $this->token;
                $contenido .= '">Reestablecer Contraseña</a></p>';
                $contenido .= '<p><strong>Si usted no solicitó la información anterior, puede ignorar este mensaje.</strong></p>';
                $contenido .= '</html>';

                // Texto plano alternativo
                $contenidoAlt = 'Hola ' . $receptor . '. Visite el siguiente enlace para reestablecer su contraseña en AppSalon: ' . $url . '/recuperar?token=' . $this->token . ' | Si usted no solicitó la información anterior, puede ignorar este mensaje.';
                break;
            default:
                $contenido = '';
                $contenidoAlt = '';
                break;
        }

        $mail->Body = $contenido;
        $mail->AltBody = $contenidoAlt;

        // Send the Email
        return $mail->send();
    }
}
