<?php

namespace JUEGOSMESA\model;

use PDOException;

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
        $codigo_activacion = bin2hex(random_bytes(4));

        // Preparar una consulta SQL para insertar los datos en la tabla de usuarios
        $stmt = $pdo->prepare("INSERT INTO Usuario (nombre, email, password_hash, activation_token, activo) VALUES (:nombre, :correo, :password_hash, :activation_token, 0)");

        // Vincular los parámetros
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":correo", $email);
        $stmt->bindParam(":password_hash", $contrasena_encriptada);
        $stmt->bindParam(":activation_token", $codigo_activacion);

        // Ejecutar la consulta
        $stmt->execute();

        // Enviar el correo de activación
        // ...
    }

    // Función que comprueba si existe ya una cuenta con un nombre y/o correo asociado
    public static function existe_usuario($pdo, $nombre, $email)
    {
        $stmt = $pdo->prepare("SELECT nombre, email FROM Usuario WHERE nombre=:nombre OR email=:email");

        // Vincular los parámetros
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":email", $email);

        // Ejecuto la query
        $stmt->execute();

        // Si la cantidad de filas afectadas es mayor que 0 devuelvo true, caso contrario devuelvo false
        $result = ($stmt->rowCount() > 0) ? true : false;
        return $result;
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
