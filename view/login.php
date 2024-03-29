<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicia Sesión</title>
    <link rel="stylesheet" href="../view/registro.css">

</head>

<body>
    <div class="container">
        <form method="post" action="../controller/IniciarSesionController.php">
            <?php
            if (isset($error_usuario)) {
                print("<div class='error'><div class='contenido-error'><b>ERROR:</b> Ha habido un error al iniciar la sesión. Por favor, verifica tus credenciales.</div></div>");
            }
            ?>
            <h2>Iniciar Sesión</h2>
            <label for="usuario">Correo electrónico:</label>
            <input type="email" name="email" required><br>

            <label for="contrasena">Contraseña:</label>
            <input type="password" name="contrasena" required><br>

            <input type="submit" value="Iniciar Sesión">
            <p>¿No tienes una cuenta? <a href="../view/Registro.php">Regístrate aquí</a>.</p>
        </form>


    </div>
</body>

</html>