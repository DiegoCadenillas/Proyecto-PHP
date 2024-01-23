<?php
// Generar un salt aleatorio único
$salt = bin2hex(random_bytes(16));

// Obtener datos del formulario
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];

// Combinar la contraseña con el salt y encriptarla
$contrasena_encriptada = password_hash($contrasena . $salt, PASSWORD_BCRYPT);

// Guardar los datos en la base de datos
try {
    // Establecer la conexión a la base de datos
    $pdo = new PDO('mysql:host=localhost;dbname=nombre_de_la_base_de_datos', 'usuario', 'contrasena');
    
    // Preparar una consulta SQL para insertar los datos en la tabla de usuarios
    $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, correo, contrasena, salt, codigo_activacion, estado_cuenta) VALUES (:nombre, :correo, :contrasena, :salt, :codigo_activacion, 'inactivo')");
    
    // Generar un código de activación único
    $codigo_activacion = bin2hex(random_bytes(32));
    
    // Vincular los parámetros
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':contrasena', $contrasena_encriptada);
    $stmt->bindParam(':salt', $salt);
    $stmt->bindParam(':codigo_activacion', $codigo_activacion);
    
    // Ejecutar la consulta
    $stmt->execute();
    
    // Enviar el correo de activación
    $mensaje = "¡Gracias por registrarte en nuestro sitio! Haz clic en el siguiente enlace para activar tu cuenta:\n";
    $mensaje .= "http://tu-sitio.com/activar.php?codigo=$codigo_activacion";
    
    // Configurar PHPMailer y enviar el correo (debes configurar PHPMailer previamente)
    // ...
    
    // Redirigir al usuario a una página de éxito o inicio de sesión
    header('Location: exito.php');
    exit();
} catch (PDOException $e) {
    // Manejar errores de la base de datos (puedes mostrar un mensaje de error personalizado)
    echo 'Error al registrar el usuario: ' . $e->getMessage();
}
?>
