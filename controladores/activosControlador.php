<?php


// Incluir el archivo del modelo
require_once './modelos/activosModelo.php';


echo '
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@10.0.0/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.0.0/dist/sweetalert2.all.min.js"></script>
';


class activosControlador
{


    public function insertarActivos()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Obtener datos del formulario
            $idTipoEquipo = !empty($_POST["Id_TipoEquipo"]) ? intval($_POST["Id_TipoEquipo"]) : null;
            $idEstatus = intval($_POST["Id_Estatus"]); // Mantener como obligatorio
            $idProveedor = !empty($_POST["Id_Proveedor"]) ? intval($_POST["Id_Proveedor"]) : null;
            $idArea = !empty($_POST["Id_Area"]) ? intval($_POST["Id_Area"]) : null;
            $idEmpleado = !empty($_POST["Id_Empleado"]) ? intval($_POST["Id_Empleado"]) : null;
            $nombreEquipo = htmlspecialchars($_POST["nombreEquipo_act"]);


            $ip = htmlspecialchars($_POST["ip_act"]);
            $procesador = htmlspecialchars($_POST["procesador_act"]);
            $velocidadDelProcesador = htmlspecialchars($_POST["velocidadDelProcesador_act"]);
            $ram = htmlspecialchars($_POST["ram_act"]);
            $discoDuro = htmlspecialchars($_POST["discoDuro_act"]);
            $sistemaOperativo = htmlspecialchars($_POST["sistemaOperativo_act"]);
            $office = htmlspecialchars($_POST["office_act"]);
            $serviceTag = htmlspecialchars($_POST["serviceTag_act"]);

            $folioFactura = htmlspecialchars($_POST["folioFact_act"]);
            $fechaCompra = !empty($_POST["fechaCompra_act"]) ? htmlspecialchars($_POST["fechaCompra_act"]) : null; // Manejar NULL si el campo está vacío



            // Validar datos obligatorios
            // Aquí se elimina la validación de campos obligatorios
            try {
                // Instanciar modelo
                $modelo = new activosModelo();

                // Llamar al método para insertar activos
                $resultado = $modelo->insertarActivos(
                    $idTipoEquipo,
                    $idEstatus,
                    $idProveedor,
                    $idArea,
                    $idEmpleado,
                    $ip,
                    $procesador,
                    $velocidadDelProcesador,
                    $ram,
                    $discoDuro,
                    $sistemaOperativo,
                    $office,
                    $serviceTag,
                    $nombreEquipo,
                    $folioFactura,
                    $fechaCompra
                );

                if ($resultado) {
                    // Éxito al insertar el activo
                    echo '
                    <script>
                        Swal.fire({
                            title: "Guardado!",
                            text: "Activo registrado correctamente",
                            icon: "success",
                            showCancelButton: true,
                            confirmButtonText: "Ir a la lista de activos",
                            cancelButtonText: "Agregar otro activo"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "' . SERVERURL . 'activos-list/"; // Redirige a la lista de activos
                            } else if (result.isDismissed) {
                                // Aquí puedes agregar lógica adicional si es necesario
                                // Por ejemplo, limpiar el formulario o mantener al usuario en la misma página
                            }
                        });
                    </script>
                ';
                
                } else {
                    // Error al insertar el activo
                    echo '
            <script>
                Swal.fire({
                    title: "Error",
                    text: "No se pudo registrar el activo",
                    icon: "error",
                    confirmButtonText: "Aceptar"
                });
            </script>
        ';
                }
            } catch (Exception $e) {
                // Error de base de datos
                echo '
        <script>
            Swal.fire({
                title: "Error",
                text: "Error en la base de datos: ' . $e->getMessage() . '",
                icon: "error",
                confirmButtonText: "Aceptar"
            });
        </script>
    ';
            }
        }
    }


    // Función para obtener el número de equipos de computo asignados a un empleado
    private function obtenerNumeroEquiposEmpleado($idEmpleado)
    {
        try {
            // Instanciar modelo
            $modelo = new activosModelo();

            // Llamar al método del modelo para obtener el número de equipos del empleado
            return $modelo->obtenerNumeroEquiposEmpleado($idEmpleado);
        } catch (PDOException $e) {
            // Manejo de errores
            echo "Error al obtener el número de equipos del empleado: " . $e->getMessage();
            return 0; // Retornar 0 en caso de error
        }
    }

    public function eliminarActivo()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] == 'eliminar' && isset($_POST['idEmpleado'])) {
            $idEmpleado = $_POST['idEmpleado'];

            try {
                // Llamar al método eliminarEmpleado del modelo
                $resultado = empleadosModelo::eliminarEmpleado($idEmpleado);

                // Enviar una respuesta al cliente
                if ($resultado) {
                    echo 'Empleado eliminado correctamente.';
                } else {
                }
            } catch (PDOException $e) {
                // Manejo de errores de la base de datos desde el modelo
                error_log('Error en eliminarEmpleado del controlador: ' . $e->getMessage());
                echo 'Error en la base de datos al intentar eliminar el empleado.';
            }
        }
    }


    public function editarActivo()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $idEquipo = $_POST['idEquipo'];
            $idTipoEquipo = $_POST['Id_TipoEquipo'];
            $idEstatus = $_POST['Id_Estatus'];
            $idProveedor = $_POST['Id_Proveedor'];
            $idArea = $_POST['Id_Area'];
            $idEmpleado = $_POST['Id_Empleado'];
            $ip = $_POST['ip_act'];
            $procesador = $_POST['procesador_act'];
            $velocidadDelProcesador = $_POST['velocidadDelProcesador_act'];
            $ram = $_POST['ram_act'];
            $discoDuro = $_POST['discoDuro_act'];
            $sistemaOperativo = $_POST['sistemaOperativo_act'];
            $office = $_POST['office_act'];
            $serviceTag = $_POST['serviceTag_act'];
            $nombreEquipo = $_POST['nombreEquipo_act'];
            $folioFactura = $_POST['folioFact_act'];
            $fechaCompra = !empty($_POST["fechaCompra_act"]) ? htmlspecialchars($_POST["fechaCompra_act"]) : null; // Manejar NULL si el campo está vacío

            try {
                // Validar datos obligatorios
                if (
                    empty($idEstatus) || empty($ip) || empty($procesador) || empty($velocidadDelProcesador) || empty($ram) || empty($discoDuro) ||
                    empty($sistemaOperativo) || empty($office) || empty($serviceTag)
                ) {
                    throw new Exception("Por favor completa todos los campos obligatorios.");
                }

                // Llamar al método para actualizar el equipo
                $resultado = activosModelo::actualizarEquipo(
                    $idEquipo,
                    $idTipoEquipo,
                    $idEstatus,
                    $idProveedor,
                    $idArea,
                    $idEmpleado,
                    $ip,
                    $procesador,
                    $velocidadDelProcesador,
                    $ram,
                    $discoDuro,
                    $sistemaOperativo,
                    $office,
                    $serviceTag,
                    $nombreEquipo,
                    $folioFactura,
                    $fechaCompra
                );

                if ($resultado) {
                    // Éxito al actualizar el activo
                    echo '
                        <script>
                            Swal.fire({
                                title: "Guardado!",
                                text: "Activo actualizado correctamente",
                                icon: "success",
                                confirmButtonText: "Aceptar"
                            }).then(function() {
                                window.location.href = "' . SERVERURL . 'activos-list/"; // Redirecciona a la página de equipos
                            });
                        </script>
                    ';
                } else {
                    // Error al actualizar el activo
                    throw new Exception("No se pudo actualizar el activo.");
                }
            } catch (Exception $e) {
                // Error en la base de datos u otra excepción
                echo '
                    <script>
                        Swal.fire({
                            title: "Error",
                            text: "' . $e->getMessage() . '",
                            icon: "error",
                            confirmButtonText: "Aceptar"
                        });
                    </script>
                ';
            }
        }
    }
    public function buscarEquipos()
    {
        // Obtener los parámetros de la solicitud (en este caso, de la URL)
        $estatus = isset($_GET['estatus']) ? $_GET['estatus'] : '';
        $fechaInicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : '';
        $fechaFin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : '';

        // Crear una instancia del modelo
        $modelo = new activosModelo();

        // Obtener los equipos filtrados usando el modelo
        $equipos = $modelo->obtenerEquiposRef($estatus, $fechaInicio, $fechaFin);

        // Establecer el encabezado de tipo de contenido como JSON
        header('Content-Type: application/json');

        // Enviar los datos en formato JSON
        echo json_encode($equipos);
    }
}
