<?php
// Iniciar la sesión solo una vez al principio del script
if (session_status() != PHP_SESSION_ACTIVE) session_start();
// Destruir la sesión
session_unset();
session_destroy();

// Redirigir al usuario a la página de inicio de sesión
include("../view/index.php");
exit();
?>
