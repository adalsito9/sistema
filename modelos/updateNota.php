<?php
require_once 'mainModel.php'; // Asegúrate de que este archivo existe y es correcto
require_once 'notasModelo.php'; // Asegúrate de que este archivo existe y es correcto

header('Content-Type: application/json');

if (isset($_POST['noteId']) && isset($_POST['noteTitle']) && isset($_POST['noteContent'])) {
    $idNota = intval($_POST['noteId']);
    $tituloNota = $_POST['noteTitle'];
    $contenidoNota = $_POST['noteContent'];
    $categoriaNota = $_POST['noteCategoria'];
    
    $resultado = NotasModelo::actualizarNota($idNota, $contenidoNota, $tituloNota, $categoriaNota);

    echo json_encode($resultado);
} else {
    echo json_encode(['success' => false, 'message' => 'Datos no proporcionados.']);
}

error_log('Datos recibidos: ' . print_r($_POST, true));
