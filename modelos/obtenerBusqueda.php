<?php
require_once "mainModel.php";
require_once 'activosModelo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los parámetros del formulario
    $estatus = isset($_POST['estatus']) ? $_POST['estatus'] : '';
    $tipoEquipo = isset($_POST['tipoEquipo']) ? $_POST['tipoEquipo'] : '';
    $area = isset($_POST['area']) ? $_POST['area'] : '';
    $fecha_inicio = isset($_POST['fecha_inicio']) ? $_POST['fecha_inicio'] : '';
    $fecha_fin = isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] : '';

    // Llamar a la función que obtiene los equipos filtrados
    $equipos = activosModelo::obtenerEquiposFilt($estatus, $tipoEquipo, $area, $fecha_inicio, $fecha_fin);

    if ($equipos !== false) {
        echo json_encode($equipos);
    } else {
        echo json_encode(['error' => 'No se encontraron equipos.']);
    }
} else {
    echo json_encode(['error' => 'Método no permitido.']);
}
