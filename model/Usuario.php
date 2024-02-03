<?php

namespace JUEGOSMESA\model;

use PDOException;
use PHPMailer\PHPMailer\PHPMailer;

require "../vendor/autoload.php";

/**
 * 
 */

class Usuario
{
    // Función que recibe como parámetros el nombre, correo y contraseña de una cuenta a crear
    public static function crear_usuario($pdo, $nombre, $email, $contrasena)
    {
        // Encriptar la contraseña
        $contrasena_encriptada = password_hash($contrasena, PASSWORD_BCRYPT);

        // Generar un código de activación único
        $activation_token = bin2hex(random_bytes(4));

        // Preparar una consulta SQL para insertar los datos en la tabla de usuarios
        $stmt = $pdo->prepare("INSERT INTO Usuario (nombre, email, password_hash, activation_token, activo) VALUES (:nombre, :correo, :password_hash, :activation_token, 0)");

        // Vincular los parámetros
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":correo", $email);
        $stmt->bindParam(":password_hash", $contrasena_encriptada);
        $stmt->bindParam(":activation_token", $activation_token);

        // Ejecutar la consulta
        $stmt->execute();

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

    // Función que comprueba si existe ya una cuenta con un nombre y/o correo asociado
    public static function existe_usuario($pdo, $email)
    {
        $stmt = $pdo->prepare("SELECT nombre, email FROM Usuario WHERE email=:email");

        // Vinculo los parámetros
        $stmt->bindParam(":email", $email);

        // Ejecuto la query
        $stmt->execute();

        // Si la cantidad de filas afectadas es mayor que 0 devuelvo true, caso contrario devuelvo false
        $result = ($stmt->rowCount() > 0) ? true : false;
        return $result;
    }

    // Función para activar un usuario con correo y código de activación recibidos
    public static function activar_usuario($pdo, $email, $activation_token)
    {
        // Aunque podemos asumir que el código de activación es correcto dado que se llama a esta función mediante el formulario preescrito en crear_usuario(), puede ser buena práctica verificar que el código es correcto de todas maneras
        // Preparo una query para conseguir de la BDD al usuario con email dado
        $stmt = $pdo->prepare("SELECT activation_token FROM Usuario WHERE email=:email");

        // Vinculo los parámetros
        $stmt->bindParam(":email", $email);

        // Ejecuto la query
        $stmt->execute();
        $result = $stmt->fetch();
        // El primer código de activación que encontremos es el de la cuenta deseada dado que sólo existe una cuenta por correo
        if (isset($result[0])) $activation_token_guardado = $result[0];
        else $activation_token_guardado = "";

        // Si el código de activación es correcto activo la cuenta
        if ($activation_token == $activation_token_guardado) {
            // Preparo una query para actualizar el campo "activado" del usuario con email dado
            $stmt = $pdo->prepare("UPDATE Usuario SET activo = 1 WHERE email=:email");

            // Vinculo los parámetros
            $stmt->bindParam(":email", $email);

            // Ejecuto la query
            $stmt->execute();

            // Variable que indica la activación con éxito
            $activado = true;
        } else {
            $activado = false;
        }

        // Indico el resultado de la llamada
        return $activado;
    }

    // Función que verifica si el usuario indicado está activado o no
    public static function es_activo($pdo, $email) {
        // Preparo la query para recoger el estado de la cuenta
        $stmt = $pdo->prepare("SELECT activo FROM Usuario WHERE email=:email");

        // Vinculo los parámetros
        $stmt->bindParam(":email", $email);

        // Ejecuto la query y recojo el estado de la cuenta
        $stmt->execute();
        $result = $stmt->fetch();

        // Si el estado de la cuenta es activo, devuelvo true, de lo contrario devuelvo false
        $es_activo = (isset($result[0]) && $result[0] == 1) ? true : false;
        return $es_activo;
    }

    // Función que recibe el correo y contraseña con los cuales se intenta iniciar sesión. Devuelve true si se inicia sesión correctamente, false en caso contrario
    public static function iniciar_sesion($pdo, $email, $contrasena)
    {
        // Asumimos al principio que la sesión no se inicia
        $inicio_sesion = false;

        try {
            // Preparamos la query
            $stmt = $pdo->prepare("SELECT password_hash FROM Usuario WHERE email=:email");

            // Asignamos las variables
            $stmt->bindValue(":email", $email);

            // La ejecutamos y cogemos el resultado
            $stmt->execute();
            $result = $stmt->fetch();
            // La contraseña primera que encontremos es la única que nos hace falta dado que no hay más cuentas con este correo
            if (isset($result[0])) $contrasena_encriptada = $result[0];
            else $contrasena_encriptada = "";
        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
        }

        // Comparamos la contraseña recibida con la guardada en la BDD
        if (password_verify($contrasena, $contrasena_encriptada)) {
            $inicio_sesion = true;
        }

        return $inicio_sesion;
    }
}
