<?php

// Incluir el archivo del modelo
require_once './modelos/departamentosModelo.php';

echo '
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@10.0.0/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.0.0/dist/sweetalert2.all.min.js"></script>
';

class departamentoControlador {
   
    public function insertarDepa() {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (empty($_POST["nombreDepartamento"]) || empty($_POST["IdArea"])) {
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
            
            $nombreDepartamento = $_POST["nombreDepartamento"];
            $idArea = intval($_POST["IdArea"]); // Convertir a entero si es necesario
            
            // Verificar que los datos están presentes y son válidos antes de llamar al modelo
            if (!empty($nombreDepartamento)) {
                // Llamar al método insertarDepa del modelo
                $modelo = new departamentoModelo();
                $resultado = $modelo->insertarDepa($nombreDepartamento, $idArea);
                
                if ($resultado) {
                    echo '
                    <script>
                        Swal.fire({
                            title: "Guardado!",
                            text: "Departamento registrado correctamente. ¿Qué deseas hacer ahora?",
                            icon: "success",
                            showCancelButton: true,
                            showDenyButton: true,
                            confirmButtonText: "Agregar otro departamento",
                            denyButtonText: "Agregar un usuario",
                            cancelButtonText: "Ver lista de departamentos",
                            customClass: {
                                confirmButton: "btn-confirm",
                                cancelButton: "btn-cancel",
                                denyButton: "btn-deny"
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Redirigir a agregar otro departamento
                            } else if (result.isDenied) {
                                // Redirigir a agregar un usuario
                                window.location.href = "'.SERVERURL.'client-new/";
                            } else {
                                // Redirigir a la lista de departamentos
                                window.location.href = "'.SERVERURL.'departamentos-list/";
                            }
                        });
                    </script>
                    ';
                    
                    
                } else {
                    // Error al insertar el departamento
                    echo '
                    <script>
                        Swal.fire({
                            title: "Error",
                            text: "No se pudo insertar el departamento",
                            icon: "error",
                            confirmButtonText: "Aceptar"
                        });
                    </script>
                    ';
                }
            }
        }
    }
    public function actualizarDepa() {

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
                                icon: "success",
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
                                icon: "error",
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
                            icon: "error",
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
                        icon: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>
                ';
            }
        }
    }        
    
}