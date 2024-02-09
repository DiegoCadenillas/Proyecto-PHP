<?php

namespace JUEGOSMESA\model;

use PDOException;
use PHPMailer\PHPMailer\PHPMailer;

require "../vendor/autoload.php";

class Mail
{
    public static function enviar_correo_activacion($email, $nombre, $activation_token)
    {
        // Enviar el correo de activación
        // Inicializo un nuevo objeto PHPMailer
        $mail = new PHPMailer();

        // Especificamos que vamos a usar un servidor SMTP
        $mail->isSMTP();

        // Indicamos el nombre de nuestro host SMTP
        $mail->Host = "in-v3.mailjet.com";

        // Nuestro host necesita autenticación
        $mail->SMTPAuth = true;

        // Credenciales (Usamos la API Key de nuestro SMTP Host, Mailjet)
        $mail->Username = "a769f0f3210ecc7e27bc68c4461ea985";
        $mail->Password = "09d43bf78455d7b9996df884b7adb2e1";

        // Conexión por TCP
        $mail->Port = 25;

        // Construcción del correo
        $mail->CharSet = "UTF-8";
        $mail->From = "proyectophp.daw2324@gmail.com";
        $mail->FromName = "TableGames";
        $mail->addAddress($email, $nombre);
        $mail->isHTML(true);
        $mail->Subject = "Activación de Cuenta TableGames";
        $mail->Body = "<h3>Bienvenid@, $nombre!</h3>";
        $mail->Body .= "\nFalta un último paso para que pueda usar su nueva cuenta TableGames...";
        $mail->Body .= "\nSólo debe dar click al enlace para activar su cuenta.";
        // Esto es direccionamiento absoluto. En práctica estaría bien: nuestra página web tendría un dominio y un servidor estáticos, no estaría cambiando por cada usuario...
        $mail->Body .= "\n<br><form method='post' action='localhost/DES/Proyecto-PHP/controller/ActivarUsuarioController.php'>";
        $mail->Body .= "<input type=hidden name='email' value='$email'/>";
        $mail->Body .= "<input type=hidden name='activation_token' value='$activation_token'/>";
        $mail->Body .= "<button type='submit' style='background-color:black;color:white;padding:5px;border-radius:3px;'>Activar cuenta</button>";
        $mail->Body .= "</form>";
        if (!$mail->send()) echo "Error al mandar el correo..." . $mail->ErrorInfo;
    }
}