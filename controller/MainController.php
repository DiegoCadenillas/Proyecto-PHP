<?php

namespace JUEGOSMESA\controller;

use JUEGOSMESA\model\Juego as ModelJuego;
use JUEGOSMESA\model\Utils as ModelUtils;

include('..\model\Juego.php');
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
        $datosJuego = ModelJuego::get_juegos($pdo);

        // Cargar la vista
        include('../view/Mostrar_juegos.php');
    }
} else {
    // Redirigir a la página de inicio de sesión si no hay una sesión iniciada
    include('Location: ../view/Login.php');
    exit();
}
?>
