<?php

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $nombre = $_POST['nombre'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    // Encriptar la contraseña
    $contrasena_encriptada = password_hash($contrasena, PASSWORD_BCRYPT);

    // Generar un código de activación único
    $codigo_activacion = bin2hex(random_bytes(32));

    try {
        // Establecer la conexión a la base de datos
        $pdo = new PDO('mysql:host=localhost;dbname=juegosmesasdb', 'usuario', 'contrasena');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Preparar una consulta SQL para insertar los datos en la tabla de usuarios
        $stmt = $pdo->prepare("INSERT INTO Usuario (nombre, email, password_hash, activation_token, activo) VALUES (:nombre, :correo, :password_hash, :activation_token, 0)");

        // Vincular los parámetros
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':password_hash', $contrasena_encriptada);
        $stmt->bindParam(':activation_token', $codigo_activacion);

        // Ejecutar la consulta
        $stmt->execute();

        // Enviar el correo de activación
        // ...

        // Redirigir al usuario a una página de éxito
        include '../view/exito.php';
        exit();
    } catch (PDOException $e) {
        echo 'Error al registrar el usuario: ' . $e->getMessage();
    }
} else {
    include '../view/Registro.html';
    exit();
}
?>
