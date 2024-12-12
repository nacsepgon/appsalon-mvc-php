<?php

namespace Class;

use PHPMailer\PHPMailer\PHPMailer;

class Email {
    public $nombre, $email, $token;

    public function __construct($nombre, $email, $token) {

        $this->nombre = $nombre;
        $this->email = $email;
        $this->token = $token;

        
    }

    public function mailSignup() {

        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('nachosepgon@gmail.com');
        $mail->addAddress('nachosepgon@gmail.com', 'AppSalon.com');
        $mail->Subject = 'Confirma tu cuenta en AppSalón';

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $msj = "<html>";
        $msj .= "<p>Hola <strong>" . $this->nombre . "</strong>, ";
        $msj .= "has creado tu cuenta en AppSalón, confírmala presionando el siguiente enlace:</p>";
        $msj .= "<p><a href='" . $_ENV['APP_URL'] . "/confirmar?token=" . $this->token . "'>Confirmar cuenta</a></p>";
        $msj .= "<p>Si no solicitaste esta cuenta, puedes ignorar este correo.</p>";
        $msj .= "</html>";

        $mail->Body = $msj;
        $mail->send();
    }

    public function mailOlvide() {

        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('nachosepgon@gmail.com');
        $mail->addAddress('nachosepgon@gmail.com', 'AppSalon.com');
        $mail->Subject = 'Reestablece tu clave en AppSalón';

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $msj = "<html>";
        $msj .= "<p>Hola <strong>" . $this->nombre . "</strong>, ";
        $msj .= "has solicitado reestablecer tu clave en AppSalón, puedes hacerlo presionando el siguiente enlace:</p>";
        $msj .= "<p><a href='" . $_ENV['APP_URL'] . "/recuperar?token=" . $this->token . "'>Reestablecer clave</a></p>";
        $msj .= "<p>Si no solicitaste esto, puedes ignorar este correo.</p>";
        $msj .= "</html>";

        $mail->Body = $msj;
        $mail->send();

    }

}
