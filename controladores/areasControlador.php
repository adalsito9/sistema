<?php

// Incluir el archivo del modelo
require_once './modelos/areasModelo.php';
    echo '
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@10.0.0/dist/sweetalert2.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.0.0/dist/sweetalert2.all.min.js"></script>
    ';

// Verificar si se enviaron datos desde el formulario
class areasControlador {
    
    public function insertarAr() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Verificar que los campos no estén vacíos
            if (empty($_POST["NombreArea"]) || empty($_POST["Ubicacion"])) {
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
    
        // Recibir datos del formulario
$nombreArea = trim($_POST["NombreArea"]);
$ubicacion = trim($_POST["Ubicacion"]);

            // Crear una instancia del modelo
            $modelo = new areasModelo();
    
            // Intentar insertar el área
            $resultado = $modelo->insertarArea($nombreArea, $ubicacion);
    
            // Mostrar resultado al usuario
            if ($resultado === 'success') {
                echo '
                <script>
                    Swal.fire({
                        title: "Guardado!",
                        text: "Se insertó el área correctamente. ¿Qué deseas hacer ahora?",
                        icon: "success",
                        showCancelButton: true,
                        showDenyButton: true,
                        confirmButtonText: "Agregar otra área",
                        denyButtonText: "Agregar un departamento",
                        cancelButtonText: "Ver lista de áreas",
                        customClass: {
                            confirmButton: "btn-confirm",
                            cancelButton: "btn-cancel",
                            denyButton: "btn-deny"
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirigir a agregar otra área
                        } else if (result.isDenied) {
                            // Redirigir a agregar un departamento
                            window.location.href = "'.SERVERURL.'departamento-new/";
                        } else {
                            // Redirigir a la lista de áreas
                            window.location.href = "'.SERVERURL.'areas-list/";
                        }
                    });
                </script>
                ';
            } elseif ($resultado === 'existe') {
                echo '
                <script>
                    Swal.fire({
                        title: "Error",
                        text: "El área ya existe.",
                        icon: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>
                ';
            } else {
                echo '
                <script>
                    Swal.fire({
                        title: "Error",
                        text: "Ocurrió un error al agregar el área",
                        icon: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>
                ';
            }
        }
    }
        public function editarAr() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Verificar que los campos no estén vacíos
            if (empty($_POST["NombreArea"]) || empty($_POST["idArea"])) {
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
    
            // Recibir datos del formulario
          // Recibir datos del formulario
$idArea = intval($_POST["idArea"]); // Convertir a entero
$nombreArea = trim($_POST["NombreArea"]); // Eliminar espacios en blanco
$ubicacion = trim($_POST["Ubicacion"]); // Eliminar espacios en blanco

            // Crear una instancia del modelo
            $modelo = new areasModelo();
    
            // Intentar actualizar el área
            $resultado = $modelo->editarArea($idArea, $nombreArea, $ubicacion);
    
            // Mostrar resultado al usuario
            if ($resultado === 'success') {
                echo '
                <script>
                    Swal.fire({
                        title: "Guardado!",
                        text: "Se actualizó el área correctamente.",
                        icon: "success",
                        confirmButtonText: "Aceptar"
                    }).then(function() {
                        window.location.href = "'.SERVERURL.'areas-list/";
                    });
                </script>
                ';
            } elseif ($resultado === 'no_existe') {
                echo '
                <script>
                    Swal.fire({
                        title: "Error",
                        text: "El área no existe",
                        icon: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>
                ';
            } elseif ($resultado === 'no_changes') {
                echo '
                <script>
                    Swal.fire({
                        title: "Aviso",
                        text: "No se realizaron cambios en el área",
                        icon: "info",
                        confirmButtonText: "Aceptar"
                    });
                </script>
                ';
            } else {
                echo '
                <script>
                    Swal.fire({
                        title: "Error",
                        text: "Ocurrió un error al actualizar el área",
                        icon: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>
                ';
            }
        }
    }
    
    
}


