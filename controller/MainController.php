<?php
namespace JUEGOSMESA\controller;

use JUEGOSMESA\model\Juego as ModelJuego;
use JUEGOSMESA\model\Utils as ModelUtils;

include_once('..\model\Juego.php');
include_once('..\model\Utils.php');

// Iniciar la sesión solo una vez al principio del script
if (session_status() != PHP_SESSION_ACTIVE) session_start();

// Verificar si la sesión está iniciada
if (true) {
    // Conectar a la base de datos
    $pdo = ModelUtils::conectar();

    // Verificar la conexión exitosa antes de proceder
    if ($pdo) {
        // Cargar los datos de los juegos
        $datos_juegos = ModelJuego::get_juegos($pdo);
    }

    include("../view/Mostrar_juegos.php");
} else {
    // La sesión no está iniciada, incluir la página de inicio de sesión
    include('../view/login.php');
    exit();
}
