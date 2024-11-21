<?php

require_once "mainModel.php";

class NotasModelo extends mainModel
{

    // Obtener todas las notas
    public static function obtenerNotas()
    {
        try {
            $conexion = mainModel::conectar();

            $sql = "SELECT IdNota, Contenido, FechaCreacion, Titulo, Categoria
            FROM Tbl_Notas
            ORDER BY FechaCreacion DESC;";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $notas = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $notas;
        } catch (PDOException $e) {
            return [];
        }
    }

    // Insertar una nueva nota
    public static function insertarNota($contenidoNota, $tituloNota, $categoriaNota)
    {
        try {
            $conexion = mainModel::conectar();

            $sql = "INSERT INTO Tbl_Notas (Contenido, FechaCreacion, Titulo, Categoria) VALUES (:contenido_Nota, GETDATE(), :titulo_Nota, :categoria_Nota)";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(":contenido_Nota", $contenidoNota);
            $stmt->bindValue(":titulo_Nota", $tituloNota); 
            $stmt->bindValue(":categoria_Nota", $categoriaNota);
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function buscarNotas($search)
    {
        try {
            $conexion = mainModel::conectar();

            // Preparar la consulta SQL
            $sql = "SELECT IdNota, Contenido, FechaCreacion FROM Tbl_Notas WHERE Contenido LIKE :search";
            $stmt = $conexion->prepare($sql);

            // Vincular el parámetro de búsqueda
            $searchTerm = "%$search%";
            $stmt->bindValue(':search', $searchTerm, PDO::PARAM_STR);

            // Ejecutar la consulta
            $stmt->execute();
            $notas = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $notas;
        } catch (PDOException $e) {
            // Manejo de errores
            return [];
        }
    }
    public static function obtenerCategoria()
    {
        try {
            $conexion = mainModel::conectar();
            $sql = "SELECT IdCategoria, NombreCategoria FROM Tbl_NotasCategoria"; // Asegúrate de seleccionar 'IdCategoria' también
    
            $stmt = $conexion->query($sql);
            $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $categorias;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return []; // Retornar un arreglo vacío en caso de error
        }
    }
    


    // Actualizar una nota existente
    // public static function actualizarNota($idNota, $contenidoNota, $tituloNota) {
    //     try {
    //         $conexion = mainModel::conectar();
    //         $sql = "UPDATE Tbl_Notas
    //                 SET Contenido = :contenido_Nota, Titulo = :titulo_Nota
    //                 WHERE IdNota = :idNota";
    //         $stmt = $conexion->prepare($sql);
    //         $stmt->bindParam(':contenido_Nota', $contenidoNota);
    //         $stmt->bindParam(':titulo_Nota', $tituloNota);
    //         $stmt->bindParam(':idNota', $idNota);

    //         $resultado = $stmt->execute();

    //         return ['success' => $resultado, 'message' => $resultado ? 'Nota actualizada con éxito' : 'Error al actualizar la nota'];
    //     } catch (PDOException $e) {
    //         // Manejo de errores
    //         return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
    //     }
    // }
    public static function actualizarNota($idNota, $contenidoNota, $tituloNota, $categoriaNota)
{
    try {
        $conexion = mainModel::conectar();
        $sql = "UPDATE Tbl_Notas 
                SET 
                    Contenido = :noteContent, 
                    Titulo = :noteTitle,
                    FechaCreacion = GETDATE(),
                    Categoria=:noteCategoria
                WHERE IdNota = :noteId";
                
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':noteContent', $contenidoNota);
        $stmt->bindParam(':noteTitle', $tituloNota);
        $stmt->bindParam(':noteCategoria', $categoriaNota);

        $stmt->bindParam(':noteId', $idNota, PDO::PARAM_INT);
        

        $resultado = $stmt->execute();

        if (!$resultado) {
            $errorInfo = $stmt->errorInfo();
            return ['success' => false, 'message' => 'Error: ' . $errorInfo[2]];
        }

        return ['success' => $resultado, 'message' => '¡Se ha editado correctamente!'];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
    }
}


    



    // Elimina una nota
    public static function eliminarNota($idNota)
    {
        try {
            $conexion = mainModel::conectar();
            $sql = "DELETE FROM Tbl_Notas WHERE IdNota = :idNota";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':idNota', $idNota, PDO::PARAM_INT);

            // Ejecuta la consulta
            $resultado = $stmt->execute();

            // Verifica si la eliminación fue exitosa
            if ($resultado) {
                return ['success' => true, 'message' => 'Nota eliminada con éxito'];
            } else {
                return ['success' => false, 'message' => 'Error al eliminar la nota'];
            }
        } catch (PDOException $e) {
            // Maneja errores
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }




    public static function obtenerDatosSeleccionadoNotas($idNota)
    {
        try {
            $conexion = mainModel::conectar();
            $sql = "SELECT * FROM Tbl_Notas WHERE IdNota = :idNota";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':idNota', $idNota, PDO::PARAM_INT);
            $stmt->execute();
            $notaSelect = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if (!$notaSelect) {
                // Si no se encuentra la nota, puedes registrar un mensaje
                error_log("Nota con ID $idNota no encontrada.");
            }
    
            return $notaSelect;
        } catch (PDOException $e) {
            // Registra el error en el log
            error_log("Error en obtenerDatosSeleccionadoNotas: " . $e->getMessage());
            return null;
        }
    }

   
    public static function obtenerNotasFil($categoria = '')
{
    try {
        $conexion = mainModel::conectar();
        
        $sql = "SELECT IdNota, Contenido, FechaCreacion, Titulo, Categoria
                FROM Tbl_Notas
                WHERE 1=1";

        if (!empty($categoria)) {
            $sql .= " AND Categoria LIKE :categoria";
        }
       
        // if (!empty($fecha_inicio)) {
        //     $sql .= " AND FechaCreacion >= :fecha_inicio";
        // }
        
        $sql .= " ORDER BY FechaCreacion DESC;";
        
        $stmt = $conexion->prepare($sql);

        if (!empty($categoria)) {
            $stmt->bindValue(':categoria', "%$categoria%");
        }
       
        // if (!empty($fecha_inicio)) {
        //     $stmt->bindValue(':fecha_inicio', $fecha_inicio . ' 00:00:00');
        // }
        
       
        $stmt->execute();
        $notas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $notas;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return [];
    }
}

}

// require_once "mainModel.php";


// class NotasModelo extends mainModel {

//     // Obtener todas las notas
//    static public function obtenerNotas() {
//         try {
//             $conexion = mainModel::conectar();

//             $sql = "SELECT IdNota, Contenido, FechaCreacion, Titulo FROM Tbl_Notas";
//             $stmt = $conexion->prepare($sql);
//             $stmt->execute();
//             $notas = $stmt->fetchAll(PDO::FETCH_ASSOC);

//             return $notas;
//         } catch (PDOException $e) {
//             return [];
//         }   
//     }

//     // Insertar una nueva nota
//     public function insertarNota($contenidoNota, $tituloNota) {
//         try {
//             $conexion = mainModel::conectar();

//             $sql = "INSERT INTO Tbl_Notas (Contenido, Titulo, FechaCreacion) VALUES (:contenido_Nota, :titulo_Nota, GETDATE())";
//             $stmt = $conexion->prepare($sql);
//             $stmt->bindValue(":contenido_Nota", $contenidoNota);
//             $stmt->bindValue(":titulo_Nota", $tituloNota);

//             $stmt->execute();

//             return $stmt->rowCount() > 0;
//         } catch (PDOException $e) {
//             return false;
//         }
//     }

//     public function buscarNotas($search) {
//         try {
//             $conexion = mainModel::conectar();
    
//             // Preparar la consulta SQL
//             $sql = "SELECT IdNota, Contenido, FechaCreacion FROM Tbl_Notas WHERE Contenido LIKE :search";
//             $stmt = $conexion->prepare($sql);
    
//             // Vincular el parámetro de búsqueda
//             $searchTerm = "%$search%";
//             $stmt->bindValue(':search', $searchTerm, PDO::PARAM_STR);
    
//             // Ejecutar la consulta
//             $stmt->execute();
//             $notas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
//             return $notas;
//         } catch (PDOException $e) {
//             // Manejo de errores
//             return [];
//         }
//     }
    

//       // Actualizar una nota existente
//       public static function actualizarNota($idNota, $contenidoNota, $tituloNota) {
//         try {
//             $conexion = mainModel::conectar();
//             $sql = "UPDATE Tbl_Notas
//                     SET Contenido = :contenido_Nota, Titulo = :titulo_Nota
//                     WHERE IdNota = :idNota";
//             $stmt = $conexion->prepare($sql);
//             $stmt->bindParam(':contenido_Nota', $contenidoNota);
//             $stmt->bindParam(':titulo_Nota', $tituloNota);
//             $stmt->bindParam(':idNota', $idNota);
            
//             // Ejecuta la consulta
//             $resultado = $stmt->execute();

//             // Verifica si la actualización fue exitosa
//             if ($resultado) {
//                 return ['success' => true, 'message' => 'Nota actualizada con éxito'];
//             } else {
//                 return ['success' => false, 'message' => 'Error al actualizar la nota'];
//             }
//         } catch (PDOException $e) {
//             // Maneja errores
//             return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
//         }
//     }

//     // Elimina una nota
//     public static function eliminarNota($idNota) {
//         try {
//             $conexion = mainModel::conectar();
//             $sql = "DELETE FROM Tbl_Notas WHERE IdNota = :idNota";
//             $stmt = $conexion->prepare($sql);
//             $stmt->bindParam(':idNota', $idNota);

//             // Ejecuta la consulta
//             $resultado = $stmt->execute();

//             // Verifica si la eliminación fue exitosa
//             if ($resultado) {
//                 return ['success' => true, 'message' => 'Nota eliminada con éxito'];
//             } else {
//                 return ['success' => false, 'message' => 'Error al eliminar la nota'];
//             }
//         } catch (PDOException $e) {
//             // Maneja errores
//             return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
//         }
//     }
// }

