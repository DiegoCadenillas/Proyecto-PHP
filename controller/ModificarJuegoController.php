<?php

namespace controller;

use model\juego as ModelJuego;
use model\Utils as ModelUtils;

include('..\model\juego.php');
include ('..\model\Utils.php');

// Iniciar la sesión solo una vez al principio del script
session_start();

// Verificar si la sesión está iniciada
if (isset($_SESSION['user'])) {
    // Conectar a la base de datos
    $pdo = ModelUtils::conectar();

    // Verificar la conexión exitosa antes de proceder
    if ($pdo) {
        // Validar y procesar los datos del formulario
        $idJuego = ModelUtils::validarDatos($_POST['idJuego']);
        $nombre = ModelUtils::validarDatos($_POST['nombre']);
        $descripcion = ModelUtils::validarDatos($_POST['descripcion']);
        $peso = ModelUtils::validarDatos($_POST['peso']);
        $precio = ModelUtils::validarDatos($_POST['precio']);
        $tamano = ModelUtils::validarDatos($_POST['tamano']);

        // Verificar si todos los datos son válidos antes de proceder
        if (is_numeric($idJuego) && $nombre && $descripcion && is_numeric($peso) && is_numeric($precio) && $tamano) {
            // Crear el array asociativo con los datos del juego a modificar
            $juegoModificado = [
                'idJuego' => $idJuego,
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'peso' => $peso,
                'precio' => $precio,
                'tamano' => $tamano
            ];

            // Modificar el juego y verificar el resultado
            $modificacionExitosa = ModelJuego::modificarJuego($pdo, $juegoModificado);

            if ($modificacionExitosa) {
                // Redirigir a la página principal de juegos
                header('Location: ../view/MostrarJuegos.php');
                exit();
            } else {
                echo "Error al modificar el juego.";
                // Puedes redirigir o mostrar un mensaje de error adecuado
            }
        } else {
            echo "Datos del formulario no válidos.";
            // Puedes redirigir o mostrar un mensaje de error adecuado
        }
    } else {
        echo "Error al conectar a la base de datos.";
        // Puedes redirigir o mostrar un mensaje de error adecuado
    }
} else {
    // Redirigir a la página de inicio de sesión si no hay una sesión iniciada
    header('Location: ../view/Login.php');
    exit();
}
?>
