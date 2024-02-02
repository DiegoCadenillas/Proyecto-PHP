<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>TableGames</title>
    <link rel="stylesheet" href="../view/index.css">
    <link rel="stylesheet" href="./Fuentes/MedievalSharp.css">


</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <img src="../view/Imagenes/Logotipo.jpg" alt="logotipo">

        <a class="navbar-brand" href="#">Bienvenido, <?= $_SESSION["user"] ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <form action="CerrarSesionController.php" method="post">
                    <input type="submit" value="Cerrar sesión">
                </form>


            </ul>
        </div>
    </nav>
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">NOMBRE</th>
                    <th scope="col">NUMERO DE JUGADORES MINIMO</th>
                    <th scope="col">NUMERO DE JUGADORES MAXIMO</th>
                    <th scope="col">PEGI</th>
                    <th scope="col">PRECIO</th>
                    <th scope="col">IDIOMA</th>
                    <th scope="col">DESCRIPCION</th>

                </tr>
            </thead>
            <h1>Esta es nuestra lista de juegos:</h1>
            <div class="tabla">
                <tbody>
                    <?php
                    //Recorremos todos los registros de la base de datos
                    for ($i = 0; $i < count($datos_juegos); $i++) {
                        //Para cada registro de BD hay que crear una fila de la tabla
                        print("<tr>\n");
                        //Recorremos todos los datos de este registro
                        for ($j = 0; $j < count($datos_juegos[$i]) / 2; $j++) {
                            //Para cada dato del registro creamos una celda
                            print("<td>" . $datos_juegos[$i][$j] . "</td>\n");
                        }


                        print("<form action=../view/Ver_juegos.php method=POST>\n");
                        //Boton para modificar el producto
                        print("<input type='hidden' name='controller' value='modificar'>");
                        print("<input type=hidden name='id_juego' value='" . $datos_juegos[$i]['id_juego'] . "'>");
                        print("<input type=hidden name='nombre' value='" . $datos_juegos[$i]['nombre'] . "'>");
                        print("<input type=hidden name='descripcion' value='" . $datos_juegos[$i]['descripcion'] . "'>");
                        print("<input type=hidden name='min_jugadores' value='" . $datos_juegos[$i]['min_jugadores'] . "'>");
                        print("<input type=hidden name='max_jugadores' value='" . $datos_juegos[$i]['max_jugadores'] . "'>");
                        print("<input type=hidden name='pegi' value='" . $datos_juegos[$i]['pegi'] . "'>");
                        print("<input type=hidden name='precio' value='" . $datos_juegos[$i]['precio'] . "'>");
                        print("<input type=hidden name='idioma' value='" . $datos_juegos[$i]['idioma'] . "'>");
                        print("<td><button type=submit>Modificar</button></td>");
                        print("</form>");
                        //Boton para eliminar

                        print("<form action=../controller/EliminarJuegoController.php method=POST>\n");
                        print("<input type=hidden name='id_juego' value='" . $datos_juegos[$i]['id_juego'] . "'>");
                        print("<td><button type=submit>Eliminar</button></td>");
                        print("</form>");

                        print("</tr>\n");
                    }

                    ?>
        </table>
        </tbody>

        <!-- Boton para añadir los productos -->
        <form action='../view/Ver_juegos.php' method='POST'>
            <input type='hidden' name='controller' value='insertar'>
            <input type='hidden' name='id_juego' value='1'>
            <button type='submit'>Añadir Producto</button>
        </form>
    </div>
</body>

</html>