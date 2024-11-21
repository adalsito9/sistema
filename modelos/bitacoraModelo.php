<?php

require_once "mainModel.php";

class bitacoraModelo extends mainModel {
    
    public static function obtenerDatosBitacora() {
        try {
            $conexion = mainModel::conectar();
            $sql = "SELECT eb.IdBitacora, 
                    COALESCE(ec.NombreEquipo, 'No disponible') AS NombreEquipo, 
                    eb.FechaAsignacion, 
                    COALESCE(em.Nombre, 'Usuario no asignado') AS NombreEmpleado,  -- Modificado aquí
                    eb.Descripcion,
                    eb.IdEmpleado  -- Añadido para recuperar el ID del empleado
                    FROM Tbl_BitacoraEq eb
                    LEFT JOIN Tbl_EqComputo ec ON eb.IdEquipo = ec.IdEquipo
                    LEFT JOIN Tbl_Empleados em ON eb.IdEmpleado = em.IdEmpleado
                    ORDER BY eb.FechaAsignacion DESC;";
            
            $stmt = $conexion->query($sql);
            $bitacoras = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $bitacoras;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return []; // Retornar un arreglo vacío en caso de error
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
