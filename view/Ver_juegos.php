<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    if (!isset($_POST['controller']))
        header('location:Mostrar_juegos.php');
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>TableGames</title>
    <!-- Cierre de sesión automático tras 5 minutos -->
    <meta http-equiv="refresh" content="300;url=../controller/CerrarSesionController.php">
</head>

<body>
    <div class="container-sm col-sm" style="padding-top:40px;">
        <!--El formulario envia con el metodo post los datos -->
        <form method="post" action="../controller/<?= $_POST["controller"] ?>JuegoController.php">
            <input type="hidden" name="id_juego" value="<?= $_POST["id_juego"] ?>">

            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Nombre: </span>
                <input type="text" name="nombre" value="<?= (isset($_POST['nombre']) ? $_POST['nombre'] : '') ?>" class="form-control" placeholder="Nombre Usuario">
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Descripcion: </span>
                <input type="text" name="descripcion" value="<?= (isset($_POST['descripcion']) ? $_POST['descripcion'] : '') ?>" class="form-control" placeholder="Descripcion">
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Numero de jugadores minimo: </span>
                <input type="text" name="min_jugadores" value="<?= (isset($_POST['min_jugadores']) ? $_POST['min_jugadores'] : '') ?>" class="form-control" placeholder="Numero de jugadores minimos">
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Numero de jugadores máximo: </span>
                <input type="text" name="max_jugadores" value="<?= (isset($_POST['max_jugadores']) ? $_POST['max_jugadores'] : '') ?>" class="form-control" placeholder="Numero de jugadores maximos">
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Pegi: </span>
                <input type="text" name="pegi" value="<?= (isset($_POST['pegi']) ? $_POST['pegi'] : '') ?>" class="form-control" placeholder="pegi">
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Precio: </span>
                <input type="text" name="precio" value="<?= (isset($_POST['precio']) ? $_POST['precio'] : '') ?>" class="form-control" placeholder="Precio">
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Idioma: </span>
                <input type="text" name="idioma" value="<?= (isset($_POST['idioma']) ? $_POST['idioma'] : '') ?>" class="form-control" placeholder="Idioma">
            </div>
            <!-- este boton lanza el formulario al ser tipo submit -->
            <button class="btn btn-primary" type="submit">Enviar</button>
    </div>

    </form>

    </div>



</body>

</html>