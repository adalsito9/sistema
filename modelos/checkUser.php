<?php
require_once 'mainModel.php'; // Asegúrate de que este archivo exista y sea correcto
require_once 'empleadosModelo.php'; // Asegúrate de que este archivo exista y sea correcto

header('Content-Type: application/json');

if (isset($_POST['empleado_nombre'])) {
    $nombreEmpleado = trim($_POST['empleado_nombre']);
    
    try {
        $empControl = new empleadosControlador();
        $exists = $empControl->verificarUsuario($nombreEmpleado);
        echo json_encode(['exists' => $exists]);
    } catch (Exception $e) {
        error_log('Error al verificar el usuario: ' . $e->getMessage());
        echo json_encode(['exists' => false]);
    }
} else {
    echo json_encode(['exists' => false]);
}

