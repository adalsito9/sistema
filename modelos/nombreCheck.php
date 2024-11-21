<?php
// verificar_nombre_equipo.php
require_once "mainModel.php"; // Asegúrate de que este archivo esté configurado correctamente

// Incluir tu archivo donde están definidas las funciones necesarias
require_once 'activosModelo.php'; // Cambia el nombre según tu estructura


// Obtener el nombre del equipo desde la solicitud POST
$nombreEquipo = $_POST['nombreEquipo'];

// Llamar a la función para verificar si el nombre ya existe
$existe = activosModelo::verificarNombreEquipo($nombreEquipo);

// Devuelve el resultado como JSON
header('Content-Type: application/json');
echo json_encode(['existe' => $existe]);



