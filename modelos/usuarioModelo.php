
<?php

require_once "mainModel.php";

	class usuarioModelo extends mainModel{

        /*--------- Modelo agregar usuario ---------*/
          public function insertarUsuario($nombres, $usuario, $contrasena) {
                $conexion = mainModel::conectar();
        
                $sql = "INSERT INTO Tbl_Usuarios (Nombres,Usuario,Contrasena)
                        VALUES (?, ?, ?)";
                    
                $stmt = $conexion->prepare($sql);
                $stmt->execute([$nombres, $usuario, $contrasena]);
        
                // Verificar si la inserción fue exitosa
                if ($stmt->rowCount() > 0) {
                    return true; // Éxito al insertar
                } else {
                    echo '
                    <script>
                        Swal.fire({
                            title: "Ocurrió un error inesperado",
                            text: "No se pudo insertar correctamente",
                            type: "error",
                            confirmButtonText: "Aceptar"
                        });
                    </script>
                    ';
                }
            }
        

            public static function obtenerDatosSeleccionadoUsuario($idUsuario) {
                try {
                    $conexion = mainModel::conectar();
                    $sql = "SELECT * FROM Tbl_Usuarios WHERE IdUsuario = :idUsuario";
                    $stmt = $conexion->prepare($sql);
                    $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
                    $stmt->execute();
                    $usuarioSeleccionado = $stmt->fetch(PDO::FETCH_ASSOC);
                    return $usuarioSeleccionado;
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                    return null;
                }
            }
            
    
        public static function obtenerDatosUsuario() {
            try {
                $conexion = mainModel::conectar();
                $sql = "SELECT * FROM Tbl_Usuarios";  
                $stmt = $conexion->query($sql);
                $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $usuarios;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
                return []; // Retornar un arreglo vacío en caso de error
            }
        }
        
        public static function eliminarUsuario($idUsuario) {
            try {
                // Conectar a la base de datos
                $conexion = mainModel::conectar();
                
                // Preparar la sentencia SQL
                $sql = "DELETE FROM Tbl_Usuarios WHERE IdUsuario = :idUsuario";
                $stmt = $conexion->prepare($sql);
                
                // Enlazar el parámetro
                $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
                
                // Ejecutar la sentencia
                $stmt->execute();
                
                // Verificar si se eliminaron filas
                if ($stmt->rowCount() > 0) {
                    return true; // Retorna true si se eliminaron filas
                } else {
                    return false; // Retorna false si no se eliminaron filas (puede ser que no haya encontrado el usuario)
                }
            } catch (PDOException $e) {
                // Manejo de errores
                echo "Error: " . $e->getMessage();
                return false; // Retornar false en caso de error
            }
        }
        public function actualizarUsuario($idUsuario, $nombres, $usuario, $contrasena) {
            $conexion = mainModel::conectar();
        
            // Sentencia SQL para actualizar un usuario existente
            $sql = "UPDATE Tbl_Usuarios SET Nombres=?, Usuario=?, Contrasena=? WHERE IdUsuario=?";
                            
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$nombres, $usuario, $contrasena, $idUsuario]);
        
            // Verificar si la actualización fue exitosa
            if ($stmt->rowCount() > 0) {
                return true; // Éxito al actualizar
            } else {
                echo '
                <script>
                    Swal.fire({
                        title: "Ocurrió un error inesperado",
                        text: "No se pudo actualizar correctamente",
                        type: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>
                ';
                return false; // Error al actualizar
            }
        }
        
    }   