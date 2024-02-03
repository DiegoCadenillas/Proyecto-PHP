<?php
namespace JUEGOSMESA\controller;

use JUEGOSMESA\model\Usuario as ModelUsuario;
use JUEGOSMESA\model\Utils as ModelUtils;

include('../model/Usuario.php');
include('../model/Utils.php');

// Iniciar la sesión solo una vez al principio del script
if (session_status() != PHP_SESSION_ACTIVE) session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera los datos del formulario
    $email = $_POST["email"];
    $activation_token = $_POST["activation_token"];

    // Conectar a la base de datos
    $pdo = ModelUtils::conectar();

    // Verificar la conexión exitosa antes de proceder
    if ($pdo) {
        // Intento activar la cuenta
        $activado = ModelUsuario::activar_usuario($pdo, $email, $activation_token);

        if ($activado) {
            // Redirigir al usuario a la página de inicio
            include('../view/index.php');
            exit();
        } else {
            include('../view/login.php');
        }
    } else {
        // Error en la conexión a la base de datos
        echo "Error al conectar a la base de datos.";
    }
}
?>
