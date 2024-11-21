<?php

require_once "mainModel.php";

class departamentoModelo extends mainModel {
    
    public function insertarDepa($nombreDepartamento, $idArea) {
        try {
            $conexion = mainModel::conectar();
    
            // Verificar si el departamento ya existe
            $sqlCheck = "SELECT COUNT(*) FROM Tbl_Departamentos WHERE NombreDepartamento = :nombreDepartamento";
            $stmtCheck = $conexion->prepare($sqlCheck);
            $stmtCheck->bindParam(':nombreDepartamento', $nombreDepartamento, PDO::PARAM_STR);
            $stmtCheck->execute();
    
            if ($stmtCheck->fetchColumn() > 0) {
                // Si ya existe, puedes manejarlo como prefieras
                echo '
                <script>
                    Swal.fire({
                        title: "Departamento Duplicado",
                        text: "El departamento ya existe.",
                        type: "warning",
                        confirmButtonText: "Aceptar"
                    });
                </script>
                ';
                return false; // No se inserta el registro
            }
    
            // Si no existe, se procede a insertar
            $sql = "INSERT INTO Tbl_Departamentos (NombreDepartamento, IdArea) 
                    VALUES (:nombreDepartamento, :idArea)";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':nombreDepartamento', $nombreDepartamento, PDO::PARAM_STR);
            $stmt->bindParam(':idArea', $idArea, PDO::PARAM_INT);
            $stmt->execute();
    
            // Verificar si la inserción fue exitosa
            return $stmt->rowCount() > 0;
    
        } catch (PDOException $e) {
            // Manejo de errores de la base de datos
            echo '
            <script>
                Swal.fire({
                    title: "Ocurrió un error inesperado",
                    text: "NO SE PUDO INSERTAR EL REGISTRO",
                    type: "error",
                    confirmButtonText: "Aceptar"
                });
            </script>
            ';
            return false;
        }
    }
    


    public function obtenerAreas() {
        try {
            $conexion = mainModel::conectar();

            $sql = "SELECT IdArea, NombreArea FROM Tbl_Areas ORDER BY NombreArea ASC;";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $areas = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $areas;
        } catch (PDOException $e) {
     
            return [];
        }
}
public function actualizarDepa($idDepartamento, $nombreDepartamento, $idArea) {
    try {
        $conexion = mainModel::conectar(); // Conectar a la base de datos

        $sql = "UPDATE Tbl_Departamentos 
                SET NombreDepartamento = :nombreDepartamento, IdArea = :idArea 
                WHERE IdDepartamento = :idDepartamento";
                
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':nombreDepartamento', $nombreDepartamento, PDO::PARAM_STR);
        $stmt->bindParam(':idArea', $idArea, PDO::PARAM_INT);
        $stmt->bindParam(':idDepartamento', $idDepartamento, PDO::PARAM_INT);
        $stmt->execute();

        // Verificar si la actualización fue exitosa
        if ($stmt->rowCount() > 0) {
            return true; // Éxito al actualizar
        } else {
            return false; // No se actualizó ningún registro (puede ser que no haya cambios)
        }
    } catch (PDOException $e) {
        // Manejo de errores de la base de datos
        echo '
        <script>
            Swal.fire({
                title: "Ocurrió un error inesperado",
                text: "NO SE PUDO ACTUALIZAR EL REGISTRO",
                type: "error",
                confirmButtonText: "Aceptar"
            });
        </script>
        ';
        // Opcionalmente, podrías registrar el error en un archivo de registro
        // error_log("Error en actualizarDepa: " . $e->getMessage());
        return false;
    }
}

public static function obtenerDepartamentos() {
    try {
        $conexion = mainModel::conectar();

        $sql = "SELECT * FROM 
        Tbl_Departamentos where IdDepartamento = idDepartamento";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        $depAreas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $depAreas;
    } catch (PDOException $e) {
 
        return [];
    }
}


public static function obtenerDatosSeleccionadoDepartamento($idDepartamento) {
    try {
        $conexion = mainModel::conectar();
        $sql = "SELECT * FROM Tbl_Departamentos WHERE IdDepartamento = :idDepartamento";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':idDepartamento', $idDepartamento, PDO::PARAM_INT);
        $stmt->execute();
        $depaSeleccionado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $depaSeleccionado;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return null;
    }
}


}


/*class departamentoModelo extends mainModel{
    // Método para obtener todas las áreas
    public function obtenerAreas() {
        try {
            $conexion = self::conectar();

            $sql = "SELECT IdArea, NombreArea FROM Tbl_Areas";
            $stmt = $conexion->query($sql);

            $areas = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $conexion = null; // Cerrar conexión
            
            return $areas;
        } catch (PDOException $e) {
            die("Error al obtener áreas: " . $e->getMessage());
        }
    }
}*/
