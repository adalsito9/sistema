
<?php


echo '
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@10.0.0/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.0.0/dist/sweetalert2.all.min.js"></script>
';
// Incluir el archivo del modelo
require_once './modelos/mantenimientoModelo.php';

class mantenimientoControlador {
   
    public function insertarMantenimiento() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
            // Verificar que todos los campos requeridos estén presentes
            if (empty($_POST["Id_Equipo"]) || empty($_POST["FechaMantenimiento"]) || empty($_POST["DetallesMantenimiento"])) {
                echo '
                <script>
                    Swal.fire({
                        title: "Error",
                        text: "Todos los campos son obligatorios",
                        icon: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>
                ';
                return; // Terminar la ejecución del método si hay campos vacíos
            }
    
            // Obtener y sanitizar los datos del formulario
            $idEquipo = intval($_POST["Id_Equipo"]); // Convertir a entero si es necesario
            $fechaMantenimiento = $_POST["FechaMantenimiento"];
            $detallesMantenimiento = $_POST["DetallesMantenimiento"];
            $realizadoPor = isset($_POST["RealizadoPor"]) ? $_POST["RealizadoPor"] : ''; // Opcional
    
            // Verificar que los datos son válidos
            if ($idEquipo > 0 && !empty($fechaMantenimiento) && !empty($detallesMantenimiento)) {
                // Llamar al método insertarMantenimiento del modelo
                $modelo = new mantenimientoModelo();
                $resultado = $modelo->insertarMantenimiento($idEquipo, $fechaMantenimiento, $detallesMantenimiento, $realizadoPor);
                
                if ($resultado) {
                    // Éxito al insertar el mantenimiento
                    echo '
                    <script>
                        Swal.fire({
                            title: "Guardado!",
                            text: "Se ha registrado correctamente.",
                            icon: "success",
                            confirmButtonText: "Aceptar"
                        }).then(function() {
                            window.location.href = "'.SERVERURL.'mantto-list/";
                        });
                    </script>
                    ';
                } else {
                    // Error al insertar el mantenimiento
                    echo '
                    <script>
                        Swal.fire({
                            title: "Error",
                            text: "No se pudo registrar",
                            icon: "error",
                            confirmButtonText: "Aceptar"
                        });
                    </script>
                    ';
                }
            } else {
                // Error de validación
                echo '
                <script>
                    Swal.fire({
                        title: "Error",
                        text: "Datos proporcionados no son válidos",
                        icon: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>
                ';
            }
        }
    }    public function actualizarDepa() {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["nombreDepartamento"]) && isset($_POST["Id_Area"]) && isset($_POST["idDepartamento"])) {
                // Obtener valores de los campos
                $nombreDepartamento = $_POST["nombreDepartamento"];
                $idArea = intval($_POST["Id_Area"]); // Convertir a entero si es necesario
                $idDepartamento = intval($_POST["idDepartamento"]); // Convertir a entero si es necesario
        
                // Verifica que los datos estén presentes y sean válidos
                if (!empty($nombreDepartamento) && $idArea > 0 && $idDepartamento > 0) {
                    // Llamar al método actualizarDepa del modelo
                    $modelo = new departamentoModelo();
                    $resultado = $modelo->actualizarDepa($idDepartamento, $nombreDepartamento, $idArea);
        
                    if ($resultado) {
                        // Éxito al actualizar el departamento
                        echo '
                        <script>
                            Swal.fire({
                                title: "Guardado!",
                                text: "Departamento actualizado correctamente",
                                type: "success",
                                confirmButtonText: "Aceptar"
                            }).then(function() {
                                window.location.href = "'.SERVERURL.'departamentos-list/"; // Redirige a la lista de departamentos o donde sea necesario
                            });
                        </script>
                        ';
                    } else {
                        // Error al actualizar el departamento
                        echo '
                        <script>
                            Swal.fire({
                                title: "Error",
                                text: "No se pudo actualizar el departamento",
                                type: "error",
                                confirmButtonText: "Aceptar"
                            });
                        </script>
                        ';
                    }
                } else {
                    echo '
                    <script>
                        Swal.fire({
                            title: "Error",
                            text: "Todos los campos son obligatorios",
                            type: "error",
                            confirmButtonText: "Aceptar"
                        });
                    </script>
                    ';
                }
            } else {
                echo '
                <script>
                    Swal.fire({
                        title: "Error",
                        text: "Faltan datos en el formulario",
                        type: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>
                ';
            }
        }
    }        
    
}
