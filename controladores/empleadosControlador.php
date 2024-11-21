<?php

// Incluir el archivo del modelo
require_once './modelos/empleadosModelo.php';

echo '
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@10.0.0/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.0.0/dist/sweetalert2.all.min.js"></script>
';
class empleadosControlador {

    public function insertarEmp() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
    
            // Obtener datos del formulario
            $nombreEmpleado = $_POST["empleado_nombre"];
            $nominaEmpleado = $_POST["empleado_nomina"];
            $puestoEmpleado = $_POST["empleado_puesto"];
            $correoEmpleado = $_POST["empleado_correo"];
            $telefonoEmpleado = $_POST["empleado_telefono"];
            $idDepartamento = intval($_POST["IdDepartamento"]);  // Convertir a entero
            $empleadoRed = $_POST["empleado_red"]; // UsuarioRed
            $empleadoContra = $_POST["empleado_contra"]; // ContraseñaRed
            $empleadoExtensionTel = $_POST["empleado_extensionTel"]; // ExtensionTelefonica
            $correoContra = $_POST["correo_contra"];
    
            // Verificar si el nombre del empleado ya existe
            $modelo = new empleadosModelo();
            if ($modelo->nombreEmpleadoExiste($nombreEmpleado)) {
                echo '
                <script>
                    Swal.fire({
                        title: "Error",
                        text: "El nombre del usuario ya existe",
                        icon: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>
                ';
                return;
            }
    
            // Verificar que los datos están presentes y son válidos antes de llamar al modelo
            if (!empty($nombreEmpleado) && $idDepartamento > 0) {
                $resultado = $modelo->insertarEmp($nombreEmpleado, $idDepartamento, $nominaEmpleado, $puestoEmpleado, $correoEmpleado, $telefonoEmpleado, $empleadoExtensionTel, $empleadoContra, $empleadoRed, $correoContra);
                
                if ($resultado) {
                    echo '
                    <script>
                        Swal.fire({
                            title: "Guardado!",
                            text: "Usuario registrado. ¿Qué deseas hacer ahora?",
                            icon: "success",
                            showCancelButton: true,
                            showDenyButton: true,
                            confirmButtonText: "Agregar equipo",
                            cancelButtonText: "Ver lista",
                            denyButtonText: "Agregar otro usuario",
                            customClass: {
                                confirmButton: "btn-confirm",
                                cancelButton: "btn-cancel",
                                denyButton: "btn-deny"
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Redirigir a agregar equipo
                                window.location.href = "'.SERVERURL.'activos-new/";
                            } else if (result.isDenied) {
                                // Redirigir a agregar otro usuario
                                
                            } else {
                                // Redirigir a la lista de usuarios
                                window.location.href = "'.SERVERURL.'client-list/";
                            }
                        });
                    </script>
                    ';
                    

                } else {
                    echo '
                    <script>
                        Swal.fire({
                            title: "Error",
                            text: "No se pudo registrar el usuario",
                            icon: "error",
                            confirmButtonText: "Aceptar"
                        });
                    </script>
                    ';
                }
            }
            
        }
    }
    
    
    
    public function eliminarEmpleado() {
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

    public function editarEmpleado() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Obtener datos del formulario
            $idEmpleado = $_POST["id_empleado"];
            $nombreEmpleado = $_POST["empleado_nombre"];
            $nominaEmpleado = $_POST["empleado_nomina"];
            $puestoEmpleado = $_POST["empleado_puesto"];
            $correoEmpleado = $_POST["empleado_correo"];
            $telefonoEmpleado = $_POST["empleado_telefono"];
            $idDepartamento = intval($_POST["IdDepartamento"]);
            $empleadoRed = $_POST["empleado_red"];
            $empleadoContra = trim($_POST['empleado_contra']);
            $empleadoExtensionTel = $_POST["empleado_extensionTel"]; // ContraseñaRed
            $correoContra =  $_POST["correo_contra"];

    
            try {
                // Validar datos obligatorios
                if (empty($nombreEmpleado) || empty($idDepartamento) || empty($puestoEmpleado) || empty($nominaEmpleado) || empty($empleadoRed)) {
                    throw new Exception("Por favor completa todos los campos obligatorios.");
                }
    
                // Llamar al método para actualizar el empleado
                $resultado = empleadosModelo::actualizarEmp($idEmpleado, $nombreEmpleado, $idDepartamento, $nominaEmpleado, $puestoEmpleado, $correoEmpleado, $telefonoEmpleado, $empleadoContra, $empleadoRed, $empleadoExtensionTel, $correoContra);
                
                if ($resultado) {
                    // Éxito al actualizar el empleado
                    echo '
                        <script>
                            Swal.fire({
                                title: "Guardado!",
                                text: "Usuario actualizado correctamente.",
                                icon: "success",
                                confirmButtonText: "Aceptar"
                            }).then(function() {
                                window.location.href = "'.SERVERURL.'client-list/";
                            });
                        </script>
                    ';
                } else {
                    // Error al actualizar el empleado
                    throw new Exception("No se pudo actualizar el Usuario.");
                }
            } catch (Exception $e) {
                // Error en la base de datos u otra excepción
                echo '
                    <script>
                        Swal.fire({
                            title: "Error",
                            text: "'.$e->getMessage().'",
                            icon: "error",
                            confirmButtonText: "Aceptar"
                        });
                    </script>
                ';
            }
        }
    }
    
    
    }    
  
