<?php
header('Content-Type: application/json');
 // Archivo de configuración
 require_once "mainModel.php";

require_once 'notasModelo.php'; // Incluye la clase NotasModelo

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idNota = intval($_GET['id']);
    $notaSelect = NotasModelo::obtenerDatosSeleccionadoNotas($idNota);
    
    if ($notaSelect) {
        echo json_encode($notaSelect);
    } else {
        echo json_encode(['error' => 'Nota no encontrada.']);
    }
} else {
    echo json_encode(['error' => 'ID nota no proporcionado o inválido.']);
}




// require_once 'notasModelo.php'; // Incluye tu modelo aquí
// require_once 'controladores/NotasControlador.php'; // Incluye tu controlador aquí

// if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
//     $idNota = $_GET['id'];
//     $nota = NotasModelo::obtenerDatosSeleccionadoNotas($idNota);

//     if ($nota) {
//         echo json_encode([
//             'success' => true,
//             'idNota' => $nota['IdNota'],
//             'titulo' => htmlspecialchars($nota['Titulo']),
//             'contenido' => htmlspecialchars($nota['Contenido'])
//         ]);
//     } else {
//         echo json_encode(['success' => false, 'message' => 'No se encontraron datos']);
//     }
// } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $controlador = new NotasControlador();
//     $controlador->editarNota();
// } else {
//     echo json_encode(['success' => false, 'message' => 'Solicitud inválida']);
// }

