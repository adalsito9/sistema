<?php
require_once 'empleadosModelo.php';

// Obtener el ID del empleado desde la solicitud POST
$idEmpleado = isset($_POST['idEmpleado']) ? intval($_POST['idEmpleado']) : 0;

// Llamar a la función obtenerEmpleados() para obtener los detalles del empleado específico
$empleados = empleadosModelo::obtenerEmpleados();
$detalleEmpleado = buscarEmpleadoPorId($empleados, $idEmpleado);

// Mostrar los detalles del empleado dentro del modal
if ($detalleEmpleado) {
    echo '<div class="container-fluid">';
    echo '    <div class="row">';
    echo '        <div class="col">';
    echo '            <div class="card shadow-sm">';
    echo '                <div class="card-body">';
    echo '                    <ul class="list-group list-group-flush">';
    echo '                        <li class="list-group-item" style="font-size: 1.10rem;"><strong>Nombre:</strong> ' . htmlspecialchars($detalleEmpleado['Nombre']) . '</li>';
    echo '                        <li class="list-group-item" style="font-size: 1.10rem;"><strong>Departamento:</strong> ' . htmlspecialchars($detalleEmpleado['NombreDepartamento']) . '</li>';
    echo '                        <li class="list-group-item" style="font-size: 1.10rem;"><strong>Nomina:</strong> ' . htmlspecialchars($detalleEmpleado['Nomina']) . '</li>';
    echo '                        <li class="list-group-item" style="font-size: 1.10rem;"><strong>Puesto:</strong> ' . htmlspecialchars($detalleEmpleado['Puesto']) . '</li>';
    echo '                        <li class="list-group-item" style="font-size: 1.10rem;"><strong>Usuario Red:</strong> ' . htmlspecialchars($detalleEmpleado['UsuarioRed']) . '</li>';
    echo '                        <li class="list-group-item" style="font-size: 1.10rem;"><strong>Contraseña Red:</strong> ' . htmlspecialchars($detalleEmpleado['ContraseñaRed']) . '</li>';
    echo '                        <li class="list-group-item" style="font-size: 1.10rem;"><strong>Email:</strong> ' . htmlspecialchars($detalleEmpleado['Correo']) . '</li>';
    $contraseñaCorreo = !empty($detalleEmpleado['ContraseñaCorreo']) ? htmlspecialchars($detalleEmpleado['ContraseñaCorreo']) : 'No disponible';
    echo '                        <li class="list-group-item" style="font-size: 1.10rem;"><strong>Contraseña Correo:</strong> ' . $contraseñaCorreo . '</li>';
    echo '                        <li class="list-group-item" style="font-size: 1.10rem;"><strong>Celular:</strong> ' . htmlspecialchars($detalleEmpleado['Telefono']) . '</li>';
    echo '                        <li class="list-group-item" style="font-size: 1.10rem;"><strong>Extensión Tel.:</strong> ' . htmlspecialchars($detalleEmpleado['extensionTelefonica']) . '</li>';
    echo '                    </ul>';
    echo '                </div>';
    echo '            </div>';
    echo '        </div>';
    echo '    </div>';
    echo '</div>';
} else {
    echo 'Empleado no encontrado.';
}

// Función para buscar un empleado por su ID
function buscarEmpleadoPorId($empleados, $idEmpleado)
{
    foreach ($empleados as $empleado) {
        if ($empleado['IdEmpleado'] == $idEmpleado) {
            return $empleado;
        }
    }
    return null; // Manejar caso cuando no se encuentra el empleado
}
