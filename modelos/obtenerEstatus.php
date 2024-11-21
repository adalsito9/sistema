<?php
// obtener_detalle_equipo.php
require_once "mainModel.php";

// Incluir tu archivo donde está definida la función obtenerEquipos()
require_once 'activosModelo.php';



if (isset($_POST['idEquipo'])) {
    $idEquipo = $_POST['idEquipo'];
    $estatus = activosModelo::obtenerEstatusEquipo($idEquipo);
    if ($estatus !== false) {
        echo json_encode(['estatus' => $estatus]);
    } else {
        echo json_encode(['error' => 'No se pudo obtener el estatus']);
    }
}


