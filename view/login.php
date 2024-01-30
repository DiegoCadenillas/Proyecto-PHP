<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicia Sesión</title>
    <link rel="stylesheet" href="login.css">

</head>
<header>
    <h1>Tablegames</h1>
</header>

<body>
    <h2>Iniciar Sesión</h2>
    <form method="post" action="../controller/IniciarSesion.php">
        <label for="usuario">Usuario:</label>
        <input type="email" name="email" required><br>

        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" required><br>

        <input type="submit" value="Iniciar Sesión">
    </form>

    <p>¿No tienes una cuenta? <a href="Registro.html">Regístrate aquí</a>.</p>
</body>
<footer>

</footer>

</html>