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
    $contrasena = $_POST["contrasena"];

    // Conectar a la base de datos
    $pdo = ModelUtils::conectar();

    // Verificar la conexión exitosa antes de proceder
    if ($pdo) {
        // Intentar iniciar sesión
        $inicio_sesion = ModelUsuario::iniciar_sesion($pdo, $email, $contrasena);

        if ($inicio_sesion) {
            // La sesión se ha iniciado correctamente
            $_SESSION['user'] = $email; // Establecer una variable de sesión para el usuario
            // Redirigir al usuario a la página de inicio
            include('../view/index.php');
            exit();
        } else {
            // La autenticación falló, muestra un mensaje de error o redirige al usuario a la página de inicio de sesión
            echo "Autenticación fallida. Por favor, verifica tus credenciales.";
            // Puedes redirigir al usuario a la página de inicio de sesión si lo deseas
            // header('Location: ../view/InicioSesion.php');
            // exit();
        }
    } else {
        // Error en la conexión a la base de datos
        echo "Error al conectar a la base de datos.";
        // Puedes redirigir o mostrar un mensaje de error adecuado
    }
}
?>
