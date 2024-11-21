<?php
// obtener_detalle_equipo.php
require_once "mainModel.php";

// Incluir tu archivo donde está definida la función obtenerEquipos()
require_once 'activosModelo.php';

// Obtener el ID del equipo desde la solicitud POST
$idEquipo = $_POST['idEquipo'];

// Llamar a la función obtenerEquipos() para obtener los detalles del equipo específico
$equipos = activosModelo::obtenerEquipos();
$detalleEquipo = buscarEquipoPorId($equipos, $idEquipo);

// Mostrar los detalles del equipo dentro del modal
echo '<div class="container-fluid">';   
echo '    <div class="row">';
echo '        <div class="col">';
echo '            <div class="card mt-3">';
echo '                <div class="card-body">';
// echo '                    <p class="card-text"><strong>ID:</strong> ' . $detalleEquipo['IdEquipo'] . '</p>';
// echo '                    <p class="card-text"><strong>IP del Equipo:</strong> ' . $detalleEquipo['IP'] . '</p>';
echo '                    <p class="card-text"><strong>Proveedor:</strong> ' . (!empty($nombreProveedor) ? $nombreProveedor : 'No disponible.') . '</p>';
echo '                    <p class="card-text"><strong>Folio de Factura:</strong> ' . (!empty($detalleEquipo['FolioFactura']) ? $detalleEquipo['FolioFactura'] : 'No disponible.') . '</p>';
echo '                    <p class="card-text"><strong>Velocidad del procesador:</strong> ' . $detalleEquipo['VelocidadProcesador'] . '</p>';
echo '                    <p class="card-text"><strong>Procesador:</strong> ' . $detalleEquipo['Procesador'] . '</p>';
echo '                    <p class="card-text"><strong>Ram del equipo:</strong> ' . $detalleEquipo['Ram'] . '</p>';
echo '                    <p class="card-text"><strong>Disco Duro:</strong> ' . $detalleEquipo['DiscoDuro'] . '</p>';
echo '                    <p class="card-text"><strong>Sistema Operativo:</strong> ' . $detalleEquipo[ 'SistemaOperativo'] . '</p>';
echo '                    <p class="card-text"><strong>Office:</strong> ' . $detalleEquipo['Office'] . '</p>';
// echo '                    <p class="card-text"><strong>Service Tag:</strong> ' . $detalleEquipo['ServiceTag'] . '</p>';
echo '                </div>';
echo '            </div>';
echo '        </div>';
echo '    </div>';
echo '</div>';


// Función para buscar un equipo por su ID (ejemplo)
function buscarEquipoPorId($equipos, $idEquipo) {
    foreach ($equipos as $equipo) {
        if ($equipo['IdEquipo'] == $idEquipo) {
            return $equipo;
        }
    }
    return null; // Manejar caso cuando no se encuentra el equipo
}



                  