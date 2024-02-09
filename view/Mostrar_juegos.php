<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    if (!isset($_SESSION['user']))
        header('location:../controller/MainController.php');
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>TableGames</title>
    <link rel="stylesheet" href="../view/index.css">
    <link rel="stylesheet" href="./Fuentes/MedievalSharp.css">
    <!-- Cierre de sesión automático tras 5 minutos -->
    <meta http-equiv="refresh" content="300;url=../controller/CerrarSesionController.php">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <img src="../view/Imagenes/Logotipo.jpg" alt="logotipo">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Inicio <span class="sr-only">(actual)</span></a>
                </li>
                <form action="../controller/CerrarSesionController.php" method="post">
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
                    <th scope="col-group" colspan="2">
                        <form action="../view/index.php" method=POST>
                            <select name="num_juegos_pagina" onchange="this.form.submit()">
                                <option value="4" default">Nº de juegos por página</option>
                                <?php for ($i = 2; $i <= 6; $i++) print("<option value=$i>$i</option>"); ?>
                            </select>
                        </form>
                    </th>
                </tr>
            </thead>
            <h1>Esta es nuestra lista de juegos:</h1>
            <div class="tabla">
                <tbody>
                    <?php
                    // Si existe al menos una página
                    if (isset($array_paginas[0])) {
                        for ($i = 0; $i < count($array_paginas[$pag_actual]); $i++) {
                            //Para cada registro de BD hay que crear una fila de la tabla
                            print("<tr>\n");
                            //Recorremos todos los datos de este registro
                            for ($j = 0; $j < count($array_paginas[$pag_actual][$i]) / 2; $j++) {
                                //Para cada dato del registro creamos una celda
                                print("<td>" . $array_paginas[$pag_actual][$i][$j] . "</td>\n");
                            }


                            print("<form action=../view/Ver_juegos.php method=POST>\n");
                            //Boton para modificar el producto
                            print("<input type='hidden' name='controller' value='modificar'>");
                            print("<input type=hidden name='id_juego' value='" . $array_paginas[$pag_actual][$i]['id_juego'] . "'>");
                            print("<input type=hidden name='nombre' value='" . $array_paginas[$pag_actual][$i]['nombre'] . "'>");
                            print("<input type=hidden name='descripcion' value='" . $array_paginas[$pag_actual][$i]['descripcion'] . "'>");
                            print("<input type=hidden name='min_jugadores' value='" . $array_paginas[$pag_actual][$i]['min_jugadores'] . "'>");
                            print("<input type=hidden name='max_jugadores' value='" . $array_paginas[$pag_actual][$i]['max_jugadores'] . "'>");
                            print("<input type=hidden name='pegi' value='" . $array_paginas[$pag_actual][$i]['pegi'] . "'>");
                            print("<input type=hidden name='precio' value='" . $array_paginas[$pag_actual][$i]['precio'] . "'>");
                            print("<input type=hidden name='idioma' value='" . $array_paginas[$pag_actual][$i]['idioma'] . "'>");
                            print("<td><button type=submit>Modificar</button></td>");
                            print("</form>");
                            //Boton para eliminar

                            print("<form action=../controller/EliminarJuegoController.php method=POST>\n");
                            print("<input type=hidden name='id_juego' value='" . $array_paginas[$pag_actual][$i]['id_juego'] . "'>");
                            print("<td><button type=submit>Eliminar</button></td>");
                            print("</form>");

                            print("</tr>\n");
                        }
                    }
                    ?>
                </tbody>
        </table>

        <!-- Botones de cambio de página -->
        <div>
            <?php
            // switch para mostrar por pantalla las páginas que hay
            print("<form class='contenedor-botones' action='../view/index.php' method=POST>");
            print("<input type='hidden' name='num_juegos_pagina' value='$num_juegos_pagina'/>");
            switch ($pag_actual) {
                    // Caso en el que estemos en la primera página
                case 0:
                    // Muestro la página actual
                    print("<button class='boton-pag' type='button'>" . ($pag_actual + 1) . "</button>");
                    // Si hay más páginas
                    if (count($array_paginas) > 1) {
                        // Indico que hay más páginas
                        print("<p>...</p>");
                        // Muestro un botón a la última página
                        print("<button class='boton-pag' type='submit' name='pag_actual' value='" . (count($array_paginas) - 1) . "'>" . (count($array_paginas)) . "</button>");
                        // Muestro un botón a la siguiente página
                        print("<button type='submit' name='pag_actual' value='" . ($pag_actual + 1) . "'> > </button>");
                    }
                    break;
                    // Caso en el que estemos en la última página
                case (count($array_paginas) - 1):
                    // Muestro un botón a la página anterior
                    print("<button type='submit' name='pag_actual' value='" . ($pag_actual - 1) . "'> < </button>");
                    // Muestro un botón a la primera página
                    print("<button class='boton-pag' type='submit' name='pag_actual' value='0'>1</button>");
                    // Indico que hay más páginas
                    print("<p>...</p>");
                    // Muestro la página actual
                    print("<button class='boton-pag' type='button'>" . ($pag_actual + 1) . "</button>");
                    break;
                    // Caso en el que nos encontramos en una página del medio
                default:
                    // Muestro un botón a la página anterior
                    print("<button type='submit' name='pag_actual' value='" . ($pag_actual - 1) . "'> < </button>");
                    // Muestro un botón a la primera página
                    print("<button class='boton-pag' type='submit' name='pag_actual' value='0'>1</button>");
                    // Indico que hay más páginas
                    print("<p>...</p>");
                    // Muestro un botón a la página actual
                    print("<button class='boton-pag' type='button'>" . ($pag_actual + 1) . "</button>");
                    // Indico que hay más páginas
                    print("<p>...</p>");
                    // Muestro un botón a la última página
                    print("<button class='boton-pag' type='submit' name='pag_actual' value='" . (count($array_paginas) - 1) . "'>" . (count($array_paginas)) . "</button>");
                    // Muestro un botón a la siguiente página
                    print("<button type='submit' name='pag_actual' value='" . ($pag_actual + 1) . "'> > </button>");
            }
            print("</form>");
            ?>
        </div>

        <!-- Boton para añadir los productos -->
        <form action='../view/Ver_juegos.php' method='POST'>
            <input type='hidden' name='controller' value='insertar'>
            <input type='hidden' name='id_juego' value='1'>
            <button type='submit'>Añadir Producto</button>
        </form>
    </div>
</body>

</html>