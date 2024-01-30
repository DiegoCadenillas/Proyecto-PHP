<?php

namespace JUEGOSMESA\controller;

use JUEGOSMESA\model\Usuario as ModelUsuario;
use JUEGOSMESA\model\Utils as ModelUtils;

include('..\model\Usuario.php');
include('..\model\Utils.php');

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Establecer la conexión a la base de datos
    $pdo = ModelUtils::conectar();

    // Obtener datos del formulario
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];

    if ($pdo) {
        // Compruebo que el correo y el nombre están disponibles, si es así creo la cuenta
        if (!Modelusuario::existe_usuario($pdo, $nombre, $email)) {
            ModelUsuario::crear_usuario($pdo, $nombre, $email, $contrasena);
            // Redirigir al usuario a una página de éxito
            include '../view/exito.php';
        } else {
            // Mostraremos una advertencia para indicar al usuario que los datos recibidos ya están en uso
            $error_usuario = true;
            include '../view/Registro.php';
        }

        exit();
    }
} else {
    include '../view/Registro.html';
    exit();
}
