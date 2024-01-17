<?php

namespace controller;

use model\Utils as ModelUtils;

// Incluir el archivo juego.php
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
        // Validar y procesar el ID del juego a eliminar
        $idJuego = ModelUtils::validarDatos($_POST['idJuego']);

        // Verificar si el ID es válido antes de proceder
        if (is_numeric($idJuego)) {
            // Eliminar el juego y verificar el resultado
            $eliminacionExitosa = \model\juego::eliminarJuego($pdo, $idJuego);

            if ($eliminacionExitosa) {
                // Redirigir a la página principal de juegos
                header('Location: ../view/MostrarJuegos.php');
                exit();
            } else {
                echo "Error al eliminar el juego.";
                // Puedes redirigir o mostrar un mensaje de error adecuado
            }
        } else {
            echo "ID del juego no válido.";
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
