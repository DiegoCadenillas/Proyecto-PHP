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
        // Cargar los datos de los juegos
        $datosJuego = ModelJuego::getJuegos($pdo);

        // Cargar la vista
        include('../view/MostrarJuegos.php');
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
