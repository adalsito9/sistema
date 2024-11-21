<?php
    require_once ("./modelos/editarActivoModelo.php");

    

class EquiposController extends Modelo {
    
    public function editarEquipo() {
        // Verificar si se ha enviado un ID válido por GET
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            // Obtener el ID del equipo a editar desde la URL
            $idEquipo = $_GET['id'];

            // Obtener los datos del equipo desde el modelo
            $equipo = Modelo::obtenerEquipoPorId($idEquipo);

            // Incluir la vista para mostrar el formulario de edición
        }
    }
}




/*
echo '
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@10.0.0/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.0.0/dist/sweetalert2.all.min.js"></script>
';
// Incluir el modelo necesario
require_once './modelos/editarActivo.php';
// Función para procesar la solicitud de edición de activos
function editarActivosController() {
    // Verificar si se ha enviado el formulario de edición
    if (isset($_POST['editarActivo'])) {
        // Obtener los datos del formulario
        $idEquipo = $_POST['idEquipo']; // Id del equipo a editar
        $idTipoEquipo = $_POST['idTipoEquipo'];
        $idEstatus = $_POST['idEstatus'];
        $idProveedor = $_POST['idProveedor'];
        $idArea = $_POST['idArea'];
        $idEmpleado = $_POST['idEmpleado'];
        $ip = $_POST['ip'];
        $procesador = $_POST['procesador'];
        $velocidadDelProcesador = $_POST['velocidadDelProcesador'];
        $ram = $_POST['ram'];
        $discoDuro = $_POST['discoDuro'];
        $sistemaOperativo = $_POST['sistemaOperativo'];
        $office = $_POST['office'];
        $serviceTag = $_POST['serviceTag'];

        // Instanciar el modelo
        $modelo = new editarActivo();

        // Llamar al método para editar activos
        $resultado = $modelo->editarActivos($idEquipo, $idTipoEquipo, $idEstatus, $idProveedor, $idArea, 
                                            $idEmpleado, $ip, $procesador, $velocidadDelProcesador, 
                                            $ram, $discoDuro, $sistemaOperativo, $office, $serviceTag);

        // Verificar el resultado de la operación
        if ($resultado) {
            // Éxito al editar
            echo '<script>
                    Swal.fire({
                        title: "Éxito",
                        text: "Registro actualizado correctamente",
                        icon: "success",
                        confirmButtonText: "Aceptar"
                    })
                  </script>';
        } else {
            // Error al editar (el error se maneja en el modelo, así que normalmente no deberías llegar aquí)
            echo '<script>
                    Swal.fire({
                        title: "Error",
                        text: "No se pudo actualizar el registro",
                        icon: "error",
                        confirmButtonText: "Aceptar"
                    });
                  </script>';
        }
    } 
}
*/

