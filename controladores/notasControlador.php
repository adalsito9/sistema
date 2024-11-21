<?php


require_once './modelos/notasModelo.php';
class NotasControlador {

    // Agregar una nueva nota
      public function agregarNota() {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['titulo_Nota']) && isset($_POST['contenido_Nota'])) {
            if (empty($_POST["titulo_Nota"]) || empty($_POST["contenido_Nota"])) {
                echo '<script>
                    Swal.fire({
                        title: "Error",
                        text: "El campo de título y contenido son obligatorios",
                        type: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>';
                return;
            }

            $tituloNota = $_POST["titulo_Nota"];
            $contenidoNota = $_POST["contenido_Nota"];
            $categoriaNota = $_POST["categoria_Nota"];
            $modeloNotas = new NotasModelo();
            $resultado = $modeloNotas->insertarNota($contenidoNota, $tituloNota, $categoriaNota);

            if ($resultado) {
                echo '<script>
                    Swal.fire({
                        title: "Guardado!",
                        text: "La nota se agregó correctamente",
                        type: "success",
                        confirmButtonText: "Aceptar"
                    }).then(function() {
                        window.location.href = "'.SERVERURL.'notas-list/";
                    });
                </script>';
            } else {
                echo '<script>
                    Swal.fire({
                        title: "Error",
                        text: "Ocurrió un error al agregar la nota",
                        icon: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>';
            }
        }
    }

    // // Actualizar una nota
    // public function actualizarNota() {
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] == 'actualizar' && isset($_POST['idNota']) && isset($_POST['titulo_Nota']) && isset($_POST['contenido_Nota']) && isset($_POST['fechaCreacion'])) {
    //         $idNota = $_POST['idNota'];
    //         $titulo = $_POST['titulo_Nota'];
    //         $contenido = $_POST['contenido_Nota'];
    //         $fechaCreacion = $_POST['fechaCreacion']; // Aunque en la mayoría de los casos no se actualiza
    
    //         try {
    //             $modeloNotas = new NotasModelo();
    //             $resultado = $modeloNotas->actualizarNota($idNota, $contenido, $titulo);
    
    //             echo json_encode($resultado);
    //         } catch (PDOException $e) {
    //             // Manejo de errores de la base de datos desde el controlador
    //             error_log('Error en actualizarNota del controlador: ' . $e->getMessage());
    //             echo json_encode(['success' => false, 'message' => 'Error en la base de datos al intentar actualizar la nota']);
    //         }
    //     } else {
    //         echo json_encode(['success' => false, 'message' => 'Datos incompletos para la actualización']);
    //     }
    // }
    // public function actualizarNota() {
    //     if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['idNota']) && isset($_POST['titulo_Nota']) && isset($_POST['contenido_Nota'])) {
    //         $idNota = $_POST['idNota'];
    //         $tituloNota = $_POST['titulo_Nota'];
    //         $contenidoNota = $_POST['contenido_Nota'];
    
    //         $modeloNotas = new NotasModelo();
    //         $resultado = $modeloNotas->actualizarNota($idNota, $contenidoNota, $tituloNota);
    
    //         echo json_encode($resultado);
    //     } else {
    //         echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    //     }
    // }
    
    public function editarNota() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['noteId']) && isset($_POST['noteTitle']) && isset($_POST['noteContent'])) {
            $idNota = $_POST['noteId'];
            $tituloNota = $_POST['noteTitle'];
            $contenidoNota = $_POST['noteContent'];
            $categoriaNota = $_POST['noteCategoria'];
            $modeloNotas = new NotasModelo();
            $resultado = $modeloNotas->actualizarNota($idNota, $contenidoNota, $tituloNota, $categoriaNota);
    
            if ($resultado['success']) {
                echo json_encode([
                    'success' => true,
                    'message' => $resultado['message'],
                    'idNota' => $idNota,
                    'titulo' => htmlspecialchars($tituloNota),
                    'contenido' => htmlspecialchars($contenidoNota)
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => $resultado['message']
                ]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Datos no proporcionados o incorrectos']);
        }
    }
    
    
    

    // Eliminar una nota
    public function eliminarNota() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] == 'eliminar' && isset($_POST['idNota'])) {
            $idNota = $_POST['idNota'];
    
            try {
                $modeloNotas = new NotasModelo();
                $resultado = $modeloNotas->eliminarNota($idNota);
    
                // Enviar una respuesta JSON al cliente
                echo json_encode($resultado);
            } catch (PDOException $e) {
                // Manejo de errores de la base de datos desde el controlador
                error_log('Error en eliminarNota del controlador: ' . $e->getMessage());
                echo json_encode(['success' => false, 'message' => 'Error en la base de datos al intentar eliminar la nota']);
            }
        } else {
    
        }
    }
    
    // public function listarNotas() {
    //     // Obtener los filtros del formulario
    //     $categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';
    //     $titulo = isset($_GET['titulo']) ? $_GET['titulo'] : '';
    //     $fecha_inicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : '';
    //     $fecha_inicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : '';


    //     // Obtener notas filtradas usando el modelo
    //     $notas = NotasModelo::obtenerNotasFil($categoria, $titulo, $fecha_inicio);

    //     // Incluir la vista con las notas
    // }

}
