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

    public static function get_juegos($pdo)
    {
        try {
            $query = "SELECT * FROM juegosmesadb";

            $resultado = $pdo->query($query);

            $result_set = $resultado->fetchAll();
        } catch (PDOException $e) {
            print "<p>ERROR: " . $e->getMessage() . ".</p></br>";
            die();
        }

        return $result_set;
    }

    public static function del_juego($pdo, $id_juego)
    {
        try {
            $query = "DELETE FROM juegosmesadb WHERE id_juego=:id_juego";

            $stmt = $pdo->prepare($query);

            $stmt->bindValue(':id_juego', $id_juego);

            $stmt->execute();

            $filas_afectadas = $stmt->rowCount();

            return $filas_afectadas;
        } catch (PDOException $e) {
            print "<p>ERROR: " . $e->getMessage() . ".</p></br>";
            die();
        } finally {
            $pdo = null;
        }
    }

    public static function update_juego($pdo, $juego)
    {
        try {
            // Query para modificar
            $query = "UPDATE juegosmesadb set";

            // Si no se da nada que modificar devolvemos un error
            if (count($juego) == 0) {
                return -1;
            }

            $coma = false;

            if (isset($juego["nombre"])) {
                $query = $query . " nombre = :nombre";
                $coma = true;
            }

            if (isset($juego["min_jugadores"])) {
                $query = $query . ($coma) ? "," : "" . " min_jugadores=:min_jugadores";
                $coma = true;
            }

            if (isset($juego["max_jugadores"])) {
                $query = $query . ($coma) ? "," : "" . " max_jugadores=:max_jugadores";
                $coma = true;
            }

            if (isset($juego["pegi"])) {
                $query = $query . ($coma) ? "," : "" . " pegi=:pegi";
                $coma = true;
            }

            if (isset($juego["idioma"])) {
                $query = $query . ($coma) ? "," : "" . " idioma=:idioma";
                $coma = true;
            }

            if (isset($juego["descripcion"])) {
                $query = $query . ($coma) ? "," : "" . " descripcion=:descripcion";
            }

            if (isset($juego["id_juego"])) {
                $query = $query . " WHERE id_juego=:id_juego";
            }

            // Depuración mostrar query
            echo "<p>$query</p></br>";

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

    public static function insert_juego($pdo, $juego)
    {
        try {
            $query = "INSERT INTO juegosmesadb (nombre,min_jugadores,max_jugadores,pegi,idioma,descripcion) VALUES (:nombre,:min_jugadores,:max_jugadores,:pegi,:idioma,:descripcion)";

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
        } catch (PDOException $e) {
            print "<p>ERROR: " . $e->getMessage() . ".</p></br>";
            die();
        } finally {
            $pdo = null;
        }
    }
}
