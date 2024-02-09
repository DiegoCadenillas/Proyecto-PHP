<?php

namespace JUEGOSMESA\model;

use PDOException;
use JUEGOSMESA\model\Mail;

include_once("../model/Mail.php");

/**
 * 
 */

class Usuario
{
    // Función que recibe como parámetros el nombre, correo y contraseña de una cuenta a crear
    public static function crear_usuario($pdo, $nombre, $email, $contrasena)
    {
        try {
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

            // Envío el correo de activación de la cuenta
            Mail::enviar_correo_activacion($email, $nombre, $activation_token);
        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            die();
        } finally {
            $pdo = null;
        }
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
    public static function es_activo($pdo, $email)
    {
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

            // Comparamos la contraseña recibida con la guardada en la BDD
            if (password_verify($contrasena, $contrasena_encriptada)) {
                $inicio_sesion = true;
            }
        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
        }

        return $inicio_sesion;
    }
}
