<?php
// obtener_detalle_empleado.php
require_once "mainModel.php";

// Incluir tu archivo donde está definida la función obtenerEmpleados()
require_once 'empleadosModelo.php';

// Obtener el ID del empleado desde la solicitud POST
$idEmpleado = $_POST['idEmpleado'];

// Llamar a la función obtenerEmpleados() para obtener los detalles del empleado específico
$empleados = empleadosModelo::obtenerEmpleados();
$detalleEmpleado = buscarEmpleadoPorId($empleados, $idEmpleado);

// Mostrar los detalles del empleado dentro del modal
echo '<div class="container-fluid">';
echo '    <div class="row">';
echo '        <div class="col">';
echo '            <div class="card shadow-sm">';
echo '                <div class="card-body">';
echo '                    <ul class="list-group list-group-flush">';
echo '                        <li class="list-group-item" style="font-size: 1.10rem;"><strong>Nombre:</strong> ' . (!empty($detalleEmpleado['Nombre']) ? htmlspecialchars($detalleEmpleado['Nombre']) : 'No disponible') . '</li>';
echo '                        <li class="list-group-item" style="font-size: 1.10rem;"><strong>Departamento:</strong> ' . (!empty($detalleEmpleado['NombreDepartamento']) ? htmlspecialchars($detalleEmpleado['NombreDepartamento']) : 'No disponible') . '</li>';
echo '                        <li class="list-group-item" style="font-size: 1.10rem;"><strong>Nomina:</strong> ' . (!empty($detalleEmpleado['Nomina']) ? htmlspecialchars($detalleEmpleado['Nomina']) : 'No disponible') . '</li>';
echo '                        <li class="list-group-item" style="font-size: 1.10rem;"><strong>Puesto:</strong> ' . (!empty($detalleEmpleado['Puesto']) ? htmlspecialchars($detalleEmpleado['Puesto']) : 'No disponible') . '</li>';
echo '                        <li class="list-group-item" style="font-size: 1.10rem;"><strong>Usuario Red:</strong> ' . (!empty($detalleEmpleado['UsuarioRed']) ? htmlspecialchars($detalleEmpleado['UsuarioRed']) : 'No disponible') . '</li>';
$contraseñaRed = isset($detalleEmpleado['ContraseñaRed']) && trim($detalleEmpleado['ContraseñaRed']) !== '' ? htmlspecialchars($detalleEmpleado['ContraseñaRed']) : 'No disponible';
echo '                        <li class="list-group-item" style="font-size: 1.10rem;"><strong>Contraseña Red:</strong> ' . $contraseñaRed . '</li>';
echo '                        <li class="list-group-item" style="font-size: 1.10rem;"><strong>Email:</strong> ' . (!empty($detalleEmpleado['Correo']) ? htmlspecialchars($detalleEmpleado['Correo']) : 'No disponible') . '</li>';
$contraseñaCorreo = !empty($detalleEmpleado['ContraseñaCorreo']) ? htmlspecialchars($detalleEmpleado['ContraseñaCorreo']) : 'No disponible';
echo '                        <li class="list-group-item" style="font-size: 1.10rem;"><strong>Contraseña Correo:</strong> ' . $contraseñaCorreo . '</li>';
echo '                        <li class="list-group-item" style="font-size: 1.10rem;"><strong>Celular:</strong> ' . (!empty($detalleEmpleado['Telefono']) ? htmlspecialchars($detalleEmpleado['Telefono']) : 'No disponible') . '</li>';
echo '                        <li class="list-group-item" style="font-size: 1.10rem;"><strong>Extensión Tel.:</strong> ' . (!empty($detalleEmpleado['extensionTelefonica']) ? htmlspecialchars($detalleEmpleado['extensionTelefonica']) : 'No disponible') . '</li>';
echo '                    </ul>';
echo '                </div>';
echo '            </div>';
echo '        </div>';
echo '    </div>';
echo '</div>';
// Función para buscar un empleado por su ID (ejemplo)
function buscarEmpleadoPorId($empleados, $idEmpleado)
{
    foreach ($empleados as $empleado) {
        if ($empleado['IdEmpleado'] == $idEmpleado) {
            return $empleado;
        }
    }
    return null; // Manejar caso cuando no se encuentra el empleado
}
