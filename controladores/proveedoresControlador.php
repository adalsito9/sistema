<?php

    // Incluir el archivo del modelo
    require_once './modelos/proveedoresModelo.php';
    
    class proveedoresControlador {
       
        public function insertarProv() {
    
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                
                // Validación de campos vacíos (puedes descomentar si deseas)
                
                if (empty($_POST["Nombre_Proveedor"]) || empty($_POST["Domicilio_Proveedor"]) || empty($_POST["Prov_Cont"])) {
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
                    return; // Terminar la ejecución del método si hay campos vacíos
                }
                
                
                // Obtener datos del formulario
                $nombreProveedor = $_POST["Nombre_Proveedor"];
                $domicilioProveedor = $_POST["Domicilio_Proveedor"];
                $proCont = $_POST["Prov_Cont"];
                 
                         
                
                // Verificar que los datos están presentes y son válidos antes de llamar al modelo
                if (!empty($nombreProveedor) > 0) {
                    // Llamar al método insertarEmp del modelo
                    $modelo = new proveedoresModelo();
                    $resultado = $modelo->insertarProv($nombreProveedor,$domicilioProveedor,$proCont);
                    if ($resultado) {
                        // Éxito al insertar el empleado
                        echo '
                        <script>
                            Swal.fire({
                                title: "Guardado!",
                                text: "Proveedor registrado correctamente",
                                type: "success",
                                confirmButtonText: "Aceptar"
                            })
                            .then(function() {
                                window.location.href = "'.SERVERURL.'proveedores-list/";
                            });
                        </script>
                        ';
                    } else {
                        // Error al insertar el empleado
                        echo '
                        <script>
                            Swal.fire({
                                title: "Error",
                                text: "No se pudo insertar el empleado",
                                type: "error",
                                confirmButtonText: "Aceptar"
                            });
                        </script>
                        ';
                    }
                }
            }
        }
        public function actualizarProveedor() {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Validación de campos vacíos
                if (empty($_POST["Id_Proveedor"]) || empty($_POST["Nombre_Proveedor"]) || empty($_POST["Domicilio_Proveedor"]) || empty($_POST["Prov_Cont"])) {
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
        
                // Obtener datos del formulario
                $idProveedor = $_POST["Id_Proveedor"];
                $nombreProveedor = $_POST["Nombre_Proveedor"];
                $domicilioProveedor = $_POST["Domicilio_Proveedor"];
                $proCont = $_POST["Prov_Cont"];
        
                // Verificar que los datos están presentes y son válidos antes de llamar al modelo
                if (!empty($idProveedor) && !empty($nombreProveedor) && !empty($domicilioProveedor) && !empty($proCont)) {
                    // Llamar al método actualizarProv del modelo
                    $modelo = new proveedoresModelo();
                    $resultado = $modelo->actualizarProv($idProveedor, $nombreProveedor, $domicilioProveedor, $proCont);
                    if ($resultado) {
                        // Éxito al insertar el empleado
                        echo '
                        <script>
                            Swal.fire({
                                title: "Guardado!",
                                text: "Proveedor actualizado correctamente",
                                type: "success",
                                confirmButtonText: "Aceptar"
                            })
                            .then(function() {
                                window.location.href = "'.SERVERURL.'proveedores-list/";
                            });
                        </script>
                        ';
                    } else {
                        // Error al insertar el empleado
                        echo '
                        <script>
                            Swal.fire({
                                title: "Error",
                                text: "No se pudo actualizar la informacion del proveedor",
                                type: "error",
                                confirmButtonText: "Aceptar"
                            });
                        </script>
                        ';
                    }
                }
            }
        }
        
    }
    
    


/*
// Incluir el archivo del modelo
require_once './modelos/proveedoresModelo.php';

class proveedoresControlador {
   
    public function insertarProv() {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            // Validación de campos vacíos (puedes descomentar si deseas)
            
            if (empty($_POST["Nombre_Proveedor"]) || empty($_POST["Domicilio_Proveedor"]) || empty($_POST["Fecha_prov"]) || empty($_POST["Folio_Factura"])) {
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
                return; // Terminar la ejecución del método si hay campos vacíos
            }
            
            
            // Obtener datos del formulario
            $nombreProveedor = $_POST["Nombre_Proveedor"];
            $domicilioProveedor = $_POST["Domicilio_Proveedor"];
            $fechaProveedor = $_POST["Fecha_prov"];
            $folioFactura = $_POST["Folio_Factura"];
             
                     
            
            // Verificar que los datos están presentes y son válidos antes de llamar al modelo
            if (!empty($nombreProveedor) > 0) {
                // Llamar al método insertarEmp del modelo
                $modelo = new proveedoresModelo();
                $resultado = $modelo->insertarProv($nombreProveedor,$domicilioProveedor,$fechaProveedor,$folioFactura);
                if ($resultado) {
                    // Éxito al insertar el empleado
                    echo '
                    <script>
                        Swal.fire({
                            title: "Éxito",
                            text: "Proveedor insertado correctamente",
                            type: "success",
                            confirmButtonText: "Aceptar"
                        });
                    </script>
                    ';
                } else {
                    // Error al insertar el empleado
                    echo '
                    <script>
                        Swal.fire({
                            title: "Error",
                            text: "No se pudo insertar el empleado",
                            type: "error",
                            confirmButtonText: "Aceptar"
                        });
                    </script>
                    ';
                }
            }
        }
    }
}*/

