<?php

require_once "mainModel.php";

class proveedoresModelo extends mainModel {
    
    public function insertarProv($nombreProveedor,$domicilioProveedor,$proCont) {
        $conexion = mainModel::conectar();

        $sql = "INSERT INTO Tbl_Proveedores (NombreProveedor,DomicilioProveedor,Contacto) 
                VALUES (:nombre_Proveedor, :domicilio_Proveedor, :Prov_Cont)";
            
        $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':nombre_Proveedor', $nombreProveedor, PDO::PARAM_STR);
            $stmt->bindParam(':domicilio_Proveedor', $domicilioProveedor, PDO::PARAM_STR);
            $stmt->bindParam(':Prov_Cont', $proCont, PDO::PARAM_STR);
            $stmt->execute();
        
       

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
    public function actualizarProv($idProveedor, $nombreProveedor, $domicilioProveedor, $proCont) {
        // Establecer la conexión a la base de datos
        $conexion = mainModel::conectar();
    
        // Consulta SQL para actualizar el proveedor
        $sql = "UPDATE Tbl_Proveedores
                SET NombreProveedor = :nombre_Proveedor,
                    DomicilioProveedor = :domicilio_Proveedor,
                    Contacto = :Prov_Cont
                WHERE IdProveedor = :id_Proveedor";
        
        // Preparar la consulta
        $stmt = $conexion->prepare($sql);
        
        // Vincular los parámetros
        $stmt->bindParam(':nombre_Proveedor', $nombreProveedor, PDO::PARAM_STR);
        $stmt->bindParam(':domicilio_Proveedor', $domicilioProveedor, PDO::PARAM_STR);
        $stmt->bindParam(':Prov_Cont', $proCont, PDO::PARAM_STR);
        $stmt->bindParam(':id_Proveedor', $idProveedor, PDO::PARAM_INT);
    
        // Ejecutar la consulta
        $stmt->execute();
    
        // Verificar si la actualización fue exitosa
        if ($stmt->rowCount() > 0) {
            return true; // Éxito al actualizar
        } else {
            // Si no se actualizó ninguna fila, puede ser que el registro no existiera o que no se haya realizado ningún cambio
            echo '
            <script>
                Swal.fire({
                    title: "Ocurrió un error inesperado",
                    text: "No se pudo actualizar correctamente",
                    icon: "error",
                    confirmButtonText: "Aceptar"
                });
            </script>
            ';
            return false;
        }
    }
    

    public static function obtenerDatosProveedores() {
        try {
            $conexion = mainModel::conectar();
            $sql = "SELECT * FROM Tbl_Proveedores where IdProveedor = idProveedor";
            $stmt = $conexion->query($sql);
            $proveedores = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $proveedores;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return []; // Retornar un arreglo vacío en caso de error
        }
    }
    public static function obtenerDatosSeleccionadoProveedor($idProveedor) {
        try {
            $conexion = mainModel::conectar();
            $sql = "SELECT * FROM Tbl_Proveedores WHERE IdProveedor = :idProveedor";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':idProveedor', $idProveedor, PDO::PARAM_INT);
            $stmt->execute();
            $proveedorSeleccionado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $proveedorSeleccionado;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
}

