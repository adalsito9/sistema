<?php
require_once "mainModel.php";
require_once 'activosModelo.php';

header('Content-Type: application/json');

$estatus = isset($_GET['estatus']) ? $_GET['estatus'] : '';
$fechaInicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : '';
$fechaFin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : '';

// Llama a la función del modelo para obtener los equipos
$equipos = activosModelo::obtenerEquiposRef($estatus, $fechaInicio, $fechaFin);

// Verifica si la consulta fue exitosa y devuelve los datos en formato JSON
if ($equipos === false) {
    echo json_encode(['error' => 'Error al consultar los datos.']);
} else {
    echo json_encode($equipos);
}
