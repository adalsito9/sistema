<?php 

    require_once "mainModel.php";
    class Modelo extends mainModel {
        public static function obtenerEquipoPorId($idEquipo) {
            // Implementar la lógica para consultar la base de datos y obtener el equipo con el ID especificado
            // Ejemplo:
            $conexion = mainModel::conectar();
            $sql = "SELECT * FROM Tbl_EqComputo WHERE IdEquipo = :idEquipo";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([':idEquipo' => $idEquipo]); // Corregido: añade dos puntos ':' antes de 'idEquipo'
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }










/*
class editarActivo extends mainModel {
    
    public function editarActivos($idEquipo, $idTipoEquipo, $idEstatus, $idProveedor, $idArea, $idEmpleado, $ip, 
    $procesador, $velocidadDelProcesador, $ram, $discoDuro, 
    $sistemaOperativo, $office, $serviceTag) {
        try {
            $conexion = mainModel::conectar();
            $sql = "UPDATE Tbl_EqComputo SET 
                    IdTipoEquipo = :idTipoEquipo,
                    IdEstatus = :idEstatus,
                    IdProveedor = :idProveedor,
                    IdArea = :idArea,
                    IdEmpleado = :idEmpleado,
                    IP = :ip,
                    Procesador = :procesador,
                    VelocidadProcesador = :velocidadDelProcesador,
                    Ram = :ram,
                    DiscoDuro = :discoDuro,
                    SistemaOperativo = :sistemaOperativo,
                    Office = :office,
                    ServiceTag = :serviceTag
                    WHERE IdEquipo = :idEquipo";

            $stmt = $conexion->prepare($sql);
            // Vincular parámetros
            $stmt->bindParam(":idEquipo", $idEquipo);
            $stmt->bindParam(":idTipoEquipo", $idTipoEquipo);
            $stmt->bindParam(":idEstatus", $idEstatus);
            $stmt->bindParam(":idProveedor", $idProveedor);
            $stmt->bindParam(":idArea", $idArea);
            $stmt->bindParam(":idEmpleado", $idEmpleado);
            $stmt->bindParam(":ip", $ip);
            $stmt->bindParam(":procesador", $procesador);
            $stmt->bindParam(":velocidadDelProcesador", $velocidadDelProcesador);
            $stmt->bindParam(":ram", $ram);
            $stmt->bindParam(":discoDuro", $discoDuro);
            $stmt->bindParam(":sistemaOperativo", $sistemaOperativo);
            $stmt->bindParam(":office", $office);
            $stmt->bindParam(":serviceTag", $serviceTag);

            // Ejecutar consulta
            $stmt->execute();

            // Verificar si la actualización fue exitosa
            if ($stmt->rowCount() > 0) {
                return true; // Éxito al actualizar
            } else {
                echo '
                <script>
                    Swal.fire({
                        title: "Ocurrió un error inesperado",
                        text: "NO SE PUDO ACTUALIZAR EL REGISTRO",
                        icon: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>
                ';
            }
        } catch (PDOException $e) {
            // Manejo de errores de la base de datos
            echo '
            <script>
                Swal.fire({
                    title: "Ocurrió un error inesperado",
                    text: "NO SE PUDO ACTUALIZAR EL REGISTRO",
                    icon: "error",
                    confirmButtonText: "Aceptar"
                });
            </script>
            ';
            // Opcionalmente, podrías registrar el error en un archivo de registro
            // error_log("Error en editarActivos: " . $e->getMessage());
            return false;
        }
    }
    public static function obtenerEquipos() {
        try {
            $conexion = mainModel::conectar();
    
            $sql = "SELECT * FROM Tbl_EqComputo WHERE IdEquipo = :id";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':id', $idEquipo, PDO::PARAM_INT);
            $stmt->execute();
    
            if ($stmt->rowCount() > 0) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                // Manejar el caso donde no se encontraron datos del equipo
                return null;
            }
        } catch (PDOException $e) {
            echo "Error en la consulta SQL: " . $e->getMessage();
            return null;
        }
    }
    public function obtenerEquipoParaEditar($idEquipo) {

        try {
            $conexion = mainModel::conectar();
            $sql = "SELECT * FROM Tbl_EqComputo WHERE IdEquipo = :id";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':id', $idEquipo, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                // Manejar el caso donde no se encontraron datos del equipo
                return null;
            }
        } catch (PDOException $e) {
            echo "Error en la consulta SQL: " . $e->getMessage();
            return null;
        }
    }
}*/
