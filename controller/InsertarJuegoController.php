<?php

namespace JUEGOSMESA\controller;

use JUEGOSMESA\model\Juego as ModelJuego;
use JUEGOSMESA\model\Utils as ModelUtils;

include '..\model\Juego.php';
include '..\model\Utils.php';


// Iniciar la sesión solo una vez al principio del script
session_start();

// Verificar si la sesión está iniciada
if (isset($_SESSION['user'])) {
    // Conectar a la base de datos
    $pdo = ModelUtils::conectar();

    // Verificar la conexión exitosa antes de proceder
    if ($pdo) {
        // Validar y procesar los datos del formulario
        $id_juego = ModelUtils::validar_datos($_POST['id_juego']);
        $nombre = ModelUtils::validar_datos($_POST['nombre']);
        $max_jugadores = ModelUtils::validar_datos($_POST['max_jugadores']);
        $min_jugadores = ModelUtils::validar_datos($_POST['min_jugadores']);
        $pegi = ModelUtils::validar_datos($_POST['pegi']);
        $idioma = ModelUtils::validar_datos($_POST['idioma']);
        $descripcion = ModelUtils::validar_datos($_POST['descripcion']);

        // Verificar si todos los datos son válidos antes de proceder
        if ($id_juego && $nombre && is_numeric($max_jugadores) && is_numeric($min_jugadores) && is_numeric($pegi) && $idioma && $descripcion) {
            // Crear el array asociativo con los datos del juego
            $nuevoJuego = ['id_juego' => $id_juego, 'nombre' => $nombre, 'max_jugadores' => $max_jugadores, 'min_jugadores' => $min_jugadores, 'pegi' => $pegi, 'idioma' => $idioma, 'descripcion' => $descripcion];

            //Insertamos el producto
            //Habria que comprobar que se ha insertado bien
            ModelJuego::insert_juego($pdo, $nuevoJuego);

            //Cargamos la vista principal
            //Cargamos los datos de los productos
            $datos_juegos = ModelJuego::get_juegos($pdo);

            //Cargamos la vista
            include '../view/Mostrar_juegos.php';
        }
    }
}
