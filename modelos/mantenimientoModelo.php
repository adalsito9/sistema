<?php

require_once "mainModel.php";

class mantenimientoModelo extends mainModel {
    



    public static function obtenerEquiposMant() {
        try {
            $conexion = mainModel::conectar();
    
            $sql = "SELECT 
            ec.IdEquipo, 
            es.NombreEstatus, 
            es.IdEstatus, 
            emp.IdEmpleado,
            ec.NombreEquipo, 
            te.NombreTipoEquipo, 
            ec.IP, 
            ec.Procesador, 
            ec.VelocidadProcesador, 
            ec.Ram, 
            ec.DiscoDuro, 
            ec.SistemaOperativo, 
            ec.Office, 
            ec.ServiceTag,
            ec.FechaCompra,   -- Nuevo campo agregado
            ec.FolioFactura,  -- Nuevo campo agregado
            emp.Nombre AS Nombre,  -- Cambiado para reflejar la tabla de empleados
            prov.NombreProveedor AS NombreProveedor,  -- Cambiado para reflejar la tabla de proveedores
            area.NombreArea  -- Cambiado para reflejar la tabla de áreas
        FROM 
            Tbl_EqComputo ec
        INNER JOIN 
            Tbl_TiposEq te ON ec.IdTipoEquipo = te.IdTipoEquipo
        INNER JOIN 
            Tbl_EstatusEq es ON ec.IdEstatus = es.IdEstatus
        LEFT JOIN 
            Tbl_Empleados emp ON ec.IdEmpleado = emp.IdEmpleado  -- Ajustar según la relación en tu base de datos
        LEFT JOIN 
            Tbl_Proveedores prov ON ec.IdProveedor = prov.IdProveedor  -- Ajustar según la relación en tu base de datos
        LEFT JOIN 
            Tbl_Areas area ON ec.IdArea = area.IdArea  -- Ajustar según la relación en tu base de datos
        ORDER BY 
            ec.IdEquipo DESC;
        ";
    
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $equipos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $equipos;
        } catch (PDOException $e) {
            // Manejo de errores
            return [];
        }
    }
    
    
    public static function obtenerEquiposMMTO()
    {
        try {
            $conexion = mainModel::conectar();
            $sql = "
            SELECT 
            e.IdEquipo,
            e.NombreEquipo,
            te.NombreTipoEquipo, 
            emp.Nombre AS Nombre,
            hm.FechaMantenimiento,
            hm.DetallesMantenimiento,
            hm.RealizadoPor,
            COUNT(hm.IdMantenimiento) OVER (PARTITION BY e.IdEquipo) AS NumeroMantenimientos,
            CASE 
                WHEN COUNT(hm.IdMantenimiento) OVER (PARTITION BY e.IdEquipo) > 5 THEN 'Advertencia: Renovar equipo'
                WHEN COUNT(hm.IdMantenimiento) OVER (PARTITION BY e.IdEquipo) BETWEEN 3 AND 5 THEN 'Advertencia: Mantenimiento frecuente'
                ELSE 'En buen estado'
            END AS EstadoMantenimiento
        FROM 
            Tbl_EqComputo e
        INNER JOIN 
            Tbl_TiposEq te ON e.IdTipoEquipo = te.IdTipoEquipo
        JOIN 
            Tbl_HistorialManttoEq hm ON e.IdEquipo = hm.IdEquipo
        LEFT JOIN 
            Tbl_Empleados emp ON e.IdEmpleado = emp.IdEmpleado
        ORDER BY 
            e.NombreEquipo, hm.FechaMantenimiento DESC;
        
        ";

            $stmt = $conexion->query($sql);
            $equiposMto = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $equiposMto;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return []; // Retornar un arreglo vacío en caso de error
        }
    }


    public function insertarMantenimiento($idEquipo, $fechaMantenimiento, $detallesMantenimiento, $realizadoPor) {
        try {
            // Establece la conexión a la base de datos
            $conexion = mainModel::conectar();

            // SQL para insertar datos en la tabla de mantenimientos
            $sql = "INSERT INTO Tbl_HistorialManttoEq (IdEquipo, FechaMantenimiento, DetallesMantenimiento, RealizadoPor) 
                    VALUES (:idEquipo, :fechaMantenimiento, :detallesMantenimiento, :realizadoPor)";
                
            // Preparar la consulta SQL
            $stmt = $conexion->prepare($sql);

            // Vincular los parámetros con la consulta
            $stmt->bindParam(':idEquipo', $idEquipo, PDO::PARAM_INT);
            $stmt->bindParam(':fechaMantenimiento', $fechaMantenimiento, PDO::PARAM_STR);
            $stmt->bindParam(':detallesMantenimiento', $detallesMantenimiento, PDO::PARAM_STR);
            $stmt->bindParam(':realizadoPor', $realizadoPor, PDO::PARAM_STR);

            // Ejecutar la consulta
            $stmt->execute();

            // Verificar si la inserción fue exitosa
            if ($stmt->rowCount() > 0) {
                return true; // Éxito al insertar
            } else {
                return false; // No se insertó ningún registro
            }
        } catch (PDOException $e) {
            // Manejo de errores de la base de datos
            echo '
            <script>
                Swal.fire({
                    title: "Ocurrió un error inesperado",
                    text: "NO SE PUDO INSERTAR EL REGISTRO",
                    icon: "error",
                    confirmButtonText: "Aceptar"
                });
            </script>
            ';
            // Opcionalmente, podrías registrar el error en un archivo de registro
            // error_log("Error en insertarMantenimiento: " . $e->getMessage());
            return false;
        }
    }














    public static function obtenerTiposEquipos() {
        try {
            $conexion = mainModel::conectar();
            $sql = "SELECT * FROM Tbl_TiposEq";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $tiposEquipos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $tiposEquipos;
        } catch (PDOException $e) {
            return [];
        }
    }


    public static function obtenerAreasE() {
        try {
            $conexion = mainModel::conectar();
            $sql = "SELECT IdArea, NombreArea FROM Tbl_Areas ORDER BY NombreArea ASC";
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
