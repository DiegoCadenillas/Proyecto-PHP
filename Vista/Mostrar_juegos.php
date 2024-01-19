<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>TableGames</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Pricing</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">Disabled</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container-sm">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">NOMBRE</th>
                    <th scope="col">DESCRIPCION</th>
                    <th scope="col">NUMERO DE JUGADORES MINIMO</th>
                    <th scope="col">NUMERO DE JUGADORES MAXIMO</th>
                    <th scope="col">PEGI</th>
                    <th scope="col">num_jugadores_max</th>
                    <th scope="col">IDIOMA</th>

                </tr>
            </thead>

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

                //Boton para modificar el producto
                print("<form action=../Vista/Ver_juegos.php method=POST>\n");
                print("<input type='hidden' name='accion' value='Modificar'>");
                print("<input type=hidden name='id_juegos' value='" . $datos_juegos[$i]['id_juegos'] . "'>");
                print("<input type=hidden name='nombre' value='" . $datos_juegos[$i]['nombre'] . "'>");
                print("<input type=hidden name='descripcion' value='" . $datos_juegos[$i]['descripcion'] . "'>");
                print("<input type=hidden name='num_jugadores_min' value='" . $datos_juegos[$i]['num_jugadores_min'] . "'>");
                print("<input type=hidden name='num_jugadores_max' value='" . $datos_juegos[$i]['num_jugadores_max'] . "'>");
                print("<input type=hidden name='pegi' value='" . $datos_juegos[$i]['pegi'] . "'>");
                print("<input type=hidden name='precio' value='" . $datos_juegos[$i]['precio'] . "'>");
                print("<input type=hidden name='idioma' value='" . $datos_juegos[$i]['idioma'] . "'>");
                print("<td><button type=submit>Modificar</button></td>");
                print("</form>");

                //Boton para Eliminar el producto
                print("<form action=EliminarDatosController.php method=POST>\n");
                print("<input type=hidden name='id_juegos' value='" . $datos_juegos[$i]['id_juegos'] . "'>");
                print("<td><button type=submit>Eliminar</button></td>");
                print("</form>");

                print("</tr>\n");
            }
            ?>
</body>

</html>