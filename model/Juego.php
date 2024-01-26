<?php

namespace JUEGOSMESA\model;

use PDOException;

/**
 * 
*/

class Juego
{
    public static function get_juego_pag($pdo, $num_pag, $id_juego, $orden, $filtro)
    {
        // POR HACER
    }

    // Método que devuelve todas las entradas en la tabla juegos
    public static function get_juegos($pdo)
    {
        try {
            $query = "SELECT * FROM juegos";

            $resultado = $pdo->query($query);

            $result_set = $resultado->fetchAll();
        } catch (PDOException $e) { // Manejo posibles excepciones de PDO
            print "<p>ERROR: " . $e->getMessage() . ".</p></br>";
            die();
        }
        // Devuelvo el resultado
        return $result_set;
    }

    // Método que borra la entrada de la tabla juegos con el identificador especificado
    public static function del_juego($pdo, $id_juego)
    {
        try {
            // Código SQL para buscar y eliminar el juego de identificador id_juego
            $query = "DELETE FROM juegos WHERE id_juego=:id_juego";
            // Preparo la query
            $stmt = $pdo->prepare($query);
            // Reemplazo id_juego en la query por el valor de la variable
            $stmt->bindValue(':id_juego', $id_juego);
            // Ejecuto la query
            $stmt->execute();
            // Para devolver feedback devuelvo la cantidad de filas afectadas
            $filas_afectadas = $stmt->rowCount();
            // Devuelvo la cantidad de filas afectadas. Si es 0, no se encontró, si es mayor que 0 (1) se encontró y eliminó
            return $filas_afectadas;
        } catch (PDOException $e) { // Manejo posibles excepciones de PDO
            print "<p>ERROR: " . $e->getMessage() . ".</p></br>";
            die();
        } finally {
            $pdo = null;
        }
    }

    // Método para modificar los datos de un juego
    public static function update_juego($pdo, $juego)
    {
        try {
            // Query para modificar
            $query = "UPDATE juegos set";

            // Si no se da nada que modificar devolvemos un error
            if (count($juego) == 0) {
                return -1;
            }

            $coma = false;

            if (isset($juego["nombre"])) {
                $query .= " nombre = :nombre";
                $coma = true;
            }

            if (isset($juego["min_jugadores"])) {
                if ($coma) $query .= ",";
                $query .= " min_jugadores=:min_jugadores";
                $coma = true;
            }

            if (isset($juego["max_jugadores"])) {
                if ($coma) $query .= ",";
                $query .= " max_jugadores=:max_jugadores";
                $coma = true;
            }

            if (isset($juego["pegi"])) {
                if ($coma) $query .= ",";
                $query .= " pegi=:pegi";
                $coma = true;
            }

            if (isset($juego["idioma"])) {
                if ($coma) $query .= ",";
                $query .= " idioma=:idioma";
                $coma = true;
            }

            if (isset($juego["descripcion"])) {
                if ($coma) $query .= ",";
                $query .= " descripcion=:descripcion";
            }

            if (isset($juego["precio"])) {
                if ($coma) $query .= ",";
                $query .= " precio=:precio";
            }

            if (isset($juego["id_juego"])) {
                $query .= " WHERE id_juego=:id_juego";
            }

            // Depuración mostrar query
            // echo "<p>$query</p></br>";

            $stmt = $pdo->prepare($query);

            // Asociamos a los campos de la query los valores
            if (isset($juego["nombre"])) {
                $stmt->bindValue(":nombre", $juego["nombre"]);
            }
            if (isset($juego["min_jugadores"])) {
                $stmt->bindValue(":min_jugadores", $juego["min_jugadores"]);
            }
            if (isset($juego["max_jugadores"])) {
                $stmt->bindValue(":max_jugadores", $juego["max_jugadores"]);
            }
            if (isset($juego["pegi"])) {
                $stmt->bindValue(":pegi", $juego["pegi"]);
            }
            if (isset($juego["idioma"])) {
                $stmt->bindValue(":idioma", $juego["idioma"]);
            }
            if (isset($juego["descripcion"])) {
                $stmt->bindValue(":descripcion", $juego["descripcion"]);
            }
            if (isset($juego["precio"])) {
                $stmt->bindValue(":precio", $juego["precio"]);
            }
            if (isset($juego["id_juego"])) {
                $stmt->bindValue(":id_juego", $juego["id_juego"]);
            }

            // Ejecutamos la query
            $stmt->execute();

            // Sacamos la cantidad de filas afectadas
            $filas_afectadas = $stmt->rowCount();

            return $filas_afectadas;
        } catch (PDOException $e) {
            print "<p>ERROR: " . $e->getMessage() . ".</p></br>";
            return -1;
        } finally {
            $pdo = null;
        }
    }

    // Método para crear una nueva entrada en la tabla juegos
    public static function insert_juego($pdo, $juego)
    {
        try {
            // Query para insertar los datos recibidos como un juego nuevo
            $query = "INSERT INTO juegos (nombre,min_jugadores,max_jugadores,pegi,idioma,descripcion) VALUES (:nombre,:min_jugadores,:max_jugadores,:pegi,:idioma,:descripcion)";
            // Preparo la query
            $stmt = $pdo->prepare($query);
            // Asignamos los valores de las variables
            $stmt->bindValue("nombre", $juego["nombre"]);
            $stmt->bindValue("min_jugadores", $juego["min_jugadores"]);
            $stmt->bindValue("max_jugadores", $juego["max_jugadores"]);
            $stmt->bindValue("pegi", $juego["pegi"]);
            $stmt->bindValue("idioma", $juego["idioma"]);
            $stmt->bindValue("descripcion", $juego["descripcion"]);
            // Ejecutamos la query
            $stmt->execute();
        } catch (PDOException $e) { // Manejo posibles excepciones de PDO
            print "<p>ERROR: " . $e->getMessage() . ".</p></br>";
            die();
        } finally {
            $pdo = null;
        }
    }
}
