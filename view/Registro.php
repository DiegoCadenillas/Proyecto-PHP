<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Registro</title>
  <link rel="stylesheet" href="../view/registro.css" />
</head>

<body>
  <div class="container">
    <form method="post" action="../controller/RegistrarUsuarioController.php">
      <?php
      if (isset($error_usuario)) {
        print("<div class='error'><b>ERROR:</b> El nombre y/o correo electrónico dado(s) ya está(n) en uso.</div>");
      }
      ?>
      <h2>Registrate</h2>
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