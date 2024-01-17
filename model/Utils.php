<?php

namespace JUEGOSMESA\model;

use PDO;
use PDOException;

class Utils
{
    /**
     * Tenemos un método conectar() que crea la conexión con la BD, devuelve la conexión PDO activa o null si hay un fallo
    */

    public static function conectar()
    {
        // Cargamos las variables de la conexión
        include("..\settings.inc");

        try {
            // Nos conectamos a la BD con los datos del fichero settings.inc
            // Controlamos posibles errores con el bloque try catch
            $pdo = new PDO("mysql:host={$host};dbname={$dbname}", $usuario, $password);
        } catch (PDOException $e) {
            print "<p>ERROR: " . $e->getMessage() . ".</p></br>";
            die();
        }
        
        return $pdo;
    }

    public static function validar_datos($str) {
        $data = htmlspecialchars(stripslashes(trim($str)));

        return $data;
    }
}

?>