<?php
namespace JUEGOSMESA\controller;

use JUEGOSMESA\model\Juego as ModelJuego;
use JUEGOSMESA\model\Utils as ModelUtils;

include_once('..\model\Juego.php');
include_once('..\model\Utils.php');

// Iniciar la sesión solo una vez al principio del script
if (session_status() != PHP_SESSION_ACTIVE) session_start();

// Verificar si la sesión está iniciada
if (isset($_SESSION["user"])) {
    // Conectar a la base de datos
    $pdo = ModelUtils::conectar();

    // Verificar la conexión exitosa antes de proceder
    if ($pdo) {
        // Cargar los datos de los juegos
        $datos_juegos = ModelJuego::get_juegos($pdo);
    }
    // Verificar el tiempo de inactividad
    $inactividad = 300; // 5 minutos en segundos

    if (isset($_SESSION['tiempo']) && (time() - $_SESSION['tiempo'] > $inactividad)) {
        // Si ha pasado más de 5 minutos de inactividad, destruir la sesión
        session_unset();
        session_destroy();
        include('../view/index.php'); // Redirigir al usuario a la página de inicio de sesión
        exit();
    } else {
        // Si el usuario está activo, actualiza el tiempo de actividad
        $_SESSION['tiempo'] = time();
    }

    include("../view/Mostrar_juegos.php");
} else {
    // La sesión no está iniciada, incluir la página de inicio de sesión
    include('../view/login.php');
    exit();
}
