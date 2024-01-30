<?php
namespace JUEGOSMESA\controller;

use JUEGOSMESA\model\Juego as ModelJuego;
use JUEGOSMESA\model\Utils as ModelUtils;

include('..\model\Juego.php');
include('..\model\Utils.php');

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo random_bytes(8);
    // Obtener datos del formulario
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    
    // Establecer la conexión a la base de datos
    $pdo = ModelUtils::conectar();
    if ($pdo) {

        // Metodo Usuaraio.php

        // Enviar el correo de activación
        // ...

        // Redirigir al usuario a una página de éxito
        include '../view/exito.php';
        exit();
    }
} else {
    include '../view/Registro.html';
    exit();
}
?>
