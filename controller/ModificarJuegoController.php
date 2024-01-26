<?php

namespace JUEGOSMESA\controller;

use JUEGOSMESA\model\juego as ModelJuego;
use JUEGOSMESA\model\Utils as ModelUtils;

include('..\model\juego.php');
include('..\model\Utils.php');

// Iniciar la sesión solo una vez al principio del script
session_start();

// Verificar si la sesión está iniciada
if (true) {
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
        $precio = ModelUtils::validar_datos($_POST['precio']);

        // Verificar si todos los datos son válidos antes de proceder
        if (!is_null($id_juego)) {
            // Crear el array asociativo con los datos del juego a modificar
            $juegoModificado = [
                'id_juego' => $id_juego,
                'nombre' => $nombre,
                'max_jugadores' => $max_jugadores,
                'min_jugadores' => $min_jugadores,
                'pegi' => $pegi,
                'idioma' => $idioma,
                'descripcion' => $descripcion,
                'precio' => $precio
            ];

            // Modificar el juego y verificar el resultado
            $modificacionExitosa = ModelJuego::update_juego($pdo, $juegoModificado);
        }
    }
}
