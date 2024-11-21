<?php
  require_once ("./config/APP.php");
// Incluir la configuración de conexión y otros modelos si es necesario // Asegúrate de incluir el archivo correcto aquí
require_once "./modelos/mainModel.php";

class empleadosBorrar extends mainModel{
    
    public function eliminarEmpleado() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $idEmpleado = $_POST['id'];
    
            try {
                // Conectar a la base de datos
                $conexion = mainModel::conectar(); // Asegúrate de que mainModel::conectar() esté correctamente definido
                
                // Consulta SQL para eliminar el empleado
                $sql = "DELETE FROM Tbl_Empleados WHERE IdEmpleado = :idEmpleado";
                
                // Preparar la consulta
                $stmt = $conexion->prepare($sql);
                $stmt->bindParam(':idEmpleado', $idEmpleado, PDO::PARAM_INT);
                
                // Ejecutar la consulta
                $stmt->execute();
    
                // Verificar si se eliminó algún registro
                if ($stmt->rowCount() > 0) {
                    echo 'Empleado eliminado correctamente.';
                } else {
                    echo 'Error al intentar eliminar el empleado.';
                }
    
            } catch (PDOException $e) {
                // Manejo de errores de PDO
                error_log("Error en eliminarEmpleado: " . $e->getMessage());
                echo 'Error en la base de datos al intentar eliminar el empleado.';
            }
        }
    }
}


