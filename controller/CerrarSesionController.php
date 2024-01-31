<?php
namespace JUEGOSMESA\controller;

// Iniciar la sesión solo una vez al principio del script
if (session_status() != PHP_SESSION_ACTIVE) session_start();

// Verificar si el usuario está logado
if (isset($_SESSION['user'])) {
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
} 

?>
