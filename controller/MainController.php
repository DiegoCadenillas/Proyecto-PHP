<?php

namespace JUEGOSMESA\controller;

use JUEGOSMESA\model\Juego as ModelJuego;
use JUEGOSMESA\model\Usuario as ModelUsuario;
use JUEGOSMESA\model\Utils as ModelUtils;

include_once('..\model\Juego.php');
include_once('..\model\Usuario.php');
include_once('..\model\Utils.php');

// Iniciar la sesión solo una vez al principio del script
if (session_status() != PHP_SESSION_ACTIVE) session_start();

// Verificar si la sesión está iniciada
if (isset($_SESSION["user"])) {
    // Conectar a la base de datos
    $pdo = ModelUtils::conectar();

    // Verificar la conexión exitosa antes de proceder
    if ($pdo) {
        $email = $_SESSION["user"];
        if (ModelUsuario::es_activo($pdo, $email)) {
            // Verifico si está puesta la página actual, si no lo está por defecto será la primera del array ([0])
            $pag_actual = (isset($_POST["pag_actual"])) ? $_POST["pag_actual"] : 0;
            // Verifico si está puesto el valor de $num_juegos_pagina, si no lo está por defecto le pondremos 4
            $num_juegos_pagina = (isset($_POST["num_juegos_pagina"])) ? $_POST["num_juegos_pagina"] : 4;
            // Cargar los datos de los juegos
            $array_paginas = ModelJuego::get_juegos_pag($pdo, $num_juegos_pagina);
            include("../view/Mostrar_juegos.php");
        } else {
            include("../view/exito.php");
        }
    }

} else {
    // La sesión no está iniciada, incluir la página de inicio de sesión
    include('../view/login.php');
    exit();
}
