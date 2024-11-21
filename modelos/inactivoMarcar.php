<?php
// obtener_detalle_equipo.php
require_once "mainModel.php";

// Incluir tu archivo donde está definida la función obtenerEquipos()
require_once 'activosModelo.php';

if (isset($_POST['idEquipo'])) {
    $idEquipo = $_POST['idEquipo'];

    // Llamar a la función para marcar el equipo como inactivo
    $exito = activosModelo::marcarEquipoInactivo($idEquipo);

    // Enviar una respuesta JSON
    if ($exito) {
        echo json_encode(['success' => true, 'message' => 'El equipo se ha dado de baja correctamente.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'No se pudo dar de baja el equipo.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID de equipo no proporcionado.']);
}



