<?php

namespace JUEGOSMESA\controller;

use JUEGOSMESA\model\Juego as ModelJuego;
use JUEGOSMESA\model\Utils as ModelUtils;

// Incluir el archivo juego.php
include('..\model\juego.php');
include ('..\model\Utils.php');

// Iniciar la sesión solo una vez al principio del script
session_start();

// Verificar si la sesión está iniciada
if (true) {
    // Conectar a la base de datos
    $pdo = ModelUtils::conectar();

    // Verificar la conexión exitosa antes de proceder
    if ($pdo) {
        // Validar y procesar el ID del juego a eliminar
        $idJuego = ModelUtils::validar_datos($_POST['id_juego']);

        // Verificar si el ID es válido antes de proceder
        if (is_numeric($idJuego)) {
            // Eliminar el juego y verificar el resultado
            $eliminacionExitosa = ModelJuego::del_juego($pdo, $idJuego);

         //Cargamos la vista principal
  //Cargamos los datos de los productos
  $datos_juegos = ModelJuego::get_juegos($pdo);

  //Cargamos la vista
  include('../view/Mostrar_juegos.php');

}
}
}
?>
