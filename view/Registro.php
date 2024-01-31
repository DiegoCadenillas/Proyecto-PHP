<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Registro</title>
  <link rel="stylesheet" href="../view/registro.css" />
</head>

<body>
  <?php
  if (isset($error_usuario)) {
    print("<div class='error'><b>ERROR:</b> El nombre y/o correo electrónico dado(s) ya está(n) en uso.</div>");
  }
  ?>
  <div class="container">
    <h2>Registrar una cuenta nueva</h2>
    <form method="post" action="../controller/RegistrarUsuarioController.php">
      <label for="nombre">Nombre:</label>
      <input type="text" name="nombre" required /><br />

      <label for="correo">Correo Electrónico:</label>
      <input type="email" name="email" required /><br />

      <label for="contrasena">Contraseña:</label>
      <input type="password" name="contrasena" required /><br />

      <input type="submit" value="Registrarse" />

    </form>
  </div>
</body>

</html>