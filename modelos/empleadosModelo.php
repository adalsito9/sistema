<?php

require_once "mainModel.php";

class empleadosModelo extends mainModel {
    public function insertarEmp($nombreEmpleado, $idDepartamento, $nominaEmpleado, $puestoEmpleado, $correoEmpleado, $telefonoEmpleado, $empleadoExtensionTel, $empleadoContra, $empleadoRed, $correoContra) {
        try {
            $conexion = mainModel::conectar();
    
            $sql = "INSERT INTO Tbl_Empleados (Nombre, Nomina, Puesto, IdDepartamento, Correo, Telefono, ExtensionTelefonica, UsuarioRed, ContraseñaRed, ContraseñaCorreo) 
                    VALUES (:nombre_empleado, :empleado_nomina, :empleado_puesto, :idDepartamento, :empleado_correo, :empleado_telefono, :empleado_extensionTel,:empleado_red, :empleado_contra, :correo_contra)";
            
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':nombre_empleado', $nombreEmpleado, PDO::PARAM_STR);
            $stmt->bindParam(':empleado_nomina', $nominaEmpleado, PDO::PARAM_STR);
            $stmt->bindParam(':empleado_puesto', $puestoEmpleado, PDO::PARAM_STR);
            $stmt->bindParam(':idDepartamento', $idDepartamento, PDO::PARAM_INT);
            $stmt->bindParam(':empleado_correo', $correoEmpleado, PDO::PARAM_STR);
            $stmt->bindParam(':empleado_telefono', $telefonoEmpleado, PDO::PARAM_STR);
            $stmt->bindParam(':empleado_red', $empleadoRed, PDO::PARAM_STR);
            $stmt->bindParam(':empleado_contra', $empleadoContra, PDO::PARAM_STR);
            $stmt->bindParam(':empleado_extensionTel', $empleadoExtensionTel, PDO::PARAM_STR);
            $stmt->bindParam(':correo_contra', $correoContra, PDO::PARAM_STR);

            
    
            $stmt->execute();
    
            if ($stmt->rowCount() > 0) {
                return true; // Éxito al insertar
            } else {
                echo '
                <script>
                    Swal.fire({
                        title: "Error",
                        text: "No se pudo insertar el empleado",
                        icon: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>
                ';
                return false;
            }
        } catch (PDOException $e) {
            // Manejo de errores de la base de datos
            echo '
            <script>
                Swal.fire({
                    title: "Error",
                    text: "No se pudo insertar el empleado",
                    icon: "error",
                    confirmButtonText: "Aceptar"
                });
            </script>
            ';
            // Opcionalmente, podrías registrar el error en un archivo de registro
            // error_log("Error en insertarEmp: " . $e->getMessage());
            return false;
        }
    }
    public function nombreEmpleadoExiste($nombreEmpleado) {
        try {
            $conexion = mainModel::conectar();
            $sql = "SELECT COUNT(*) FROM Tbl_Empleados WHERE Nombre = :nombre_empleado";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':nombre_empleado', $nombreEmpleado, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            // Manejo de errores de la base de datos
            return false;
        }
    }



   /* public function eliminarEmp($idEmpleado) {
        try {
            $conexion = mainModel::conectar();
    
            $sql = "DELETE FROM Tbl_Empleados WHERE IdEmpleado = :idEmpleado";
                
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':idEmpleado', $idEmpleado, PDO::PARAM_INT);
            
            $stmt->execute();
    
            // Verificar si la eliminación fue exitosa
            if ($stmt->rowCount() > 0) {
                return true; // Éxito al eliminar
            } else {
                return false; // No se encontró el registro para eliminar
            }
        } catch (PDOException $e) {
            // Manejo de errores de la base de datos
            // Aquí podrías registrar el error en un archivo de registro o manejarlo de otra manera
            error_log("Error en eliminarEmp: " . $e->getMessage());
            return false;
        }
    }*/

    public static function eliminarEmpleado($idEmpleado) {
        try {
            $conexion = mainModel::conectar();
            
            // Desactivar el modo estricto de SQL para evitar errores con las relaciones
            $conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
            // Iniciar una transacción
            $conexion->beginTransaction();
    
            // Eliminar registros de la otra tabla relacionada
            $sqlRelacionada = "DELETE FROM Tbl_EqComputo WHERE IdEquipo =:idEmpleado";
            $stmtRelacionada = $conexion->prepare($sqlRelacionada);
            $stmtRelacionada->bindParam(':idEmpleado', $idEmpleado, PDO::PARAM_INT);
            $stmtRelacionada->execute();
    
            // Después de eliminar de la tabla relacionada, eliminar de la tabla de empleados
            $sqlEmpleado = "DELETE FROM Tbl_Empleados WHERE IdEmpleado = :idEmpleado";
            $stmtEmpleado = $conexion->prepare($sqlEmpleado);
            $stmtEmpleado->bindParam(':idEmpleado', $idEmpleado, PDO::PARAM_INT);
            $stmtEmpleado->execute();
    
            // Confirmar la transacción
            $conexion->commit();
    
            // Verificar si se eliminaron registros en ambas tablas
            if ($stmtRelacionada->rowCount() > 0 && $stmtEmpleado->rowCount() > 0) {
                return true; // Éxito al eliminar
            } else {
                return false; // No se encontró el registro para eliminar o falló la eliminación
            }
        } catch (PDOException $e) {
            // Cancelar la transacción en caso de error
            $conexion->rollBack();
            error_log('Error en eliminarEmpleado del modelo: ' . $e->getMessage());
            throw new PDOException('Error en eliminarEmpleado del modelo: ' . $e->getMessage());
        } catch (Exception $e) {
            // Captura de otras excepciones generales
            $conexion->rollBack();
            error_log('Error general en eliminarEmpleado del modelo: ' . $e->getMessage());
            throw new Exception('Error general en eliminarEmpleado del modelo: ' . $e->getMessage());
        }
    }
    

    public function obtenerDepa() {
        try {
            $conexion = mainModel::conectar();

            $sql = "SELECT IdDepartamento, NombreDepartamento FROM Tbl_Departamentos";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            $departamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $departamentos;
        } catch (PDOException $e) {
     
            return [];
        }

    }

   public static function obtenerDepartamentos() {
    try {
        $conexion = mainModel::conectar();

        $sql = "SELECT * FROM Tbl_Departamentos WHERE IdDepartamento = idDepartamento ORDER BY NombreDepartamento ASC";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        $departamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $departamentos;
    } catch (PDOException $e) {
        return [];
    }
}


public static function obtenerEmpleados() {
    try {
        $conexion = mainModel::conectar();
        $sql = "SELECT emp.*, dep.NombreDepartamento
        FROM Tbl_Empleados emp
        LEFT JOIN Tbl_Departamentos dep ON emp.IdDepartamento = dep.IdDepartamento;
        ";
        $stmt = $conexion->query($sql);
        $empleados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $empleados;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return []; // Retornar un arreglo vacío en caso de error
    }
}

public static function obtenerDatosSeleccionado($idEmpleado) {
    try {
        $conexion = mainModel::conectar();
        $sql = "SELECT * FROM Tbl_Empleados WHERE IdEmpleado = :idEmpleado";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':idEmpleado', $idEmpleado, PDO::PARAM_INT);
        $stmt->execute();
        $empleadoSeleccionado = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($empleadoSeleccionado) {
            $empleadoSeleccionado['ContraseñaRed'] = trim($empleadoSeleccionado['ContraseñaRed']);
        }
        return $empleadoSeleccionado;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return null;
    }
    
}

   public static function actualizarEmp($idEmpleado, $nombreEmpleado, $idDepartamento, $nominaEmpleado, $puestoEmpleado, $correoEmpleado, $telefonoEmpleado, $empleadoContra, $empleadoRed, $empleadoExtensionTel, $correoContra) {
    try {
        $conexion = mainModel::conectar();

        $sql = "UPDATE Tbl_Empleados 
                SET Nombre = :nombre_empleado,
                    Nomina = :empleado_nomina,
                    Puesto = :empleado_puesto,
                    IdDepartamento = :idDepartamento,
                    Correo = :empleado_correo,
                    Telefono = :empleado_telefono,
                    UsuarioRed = :empleado_red,
                    ContraseñaRed = :empleado_contra,
                    extensionTelefonica=:empleado_extensionTel,
                    ContraseñaCorreo=:correo_contra
                    WHERE IdEmpleado = :id_empleado";
        
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id_empleado', $idEmpleado, PDO::PARAM_INT);
        $stmt->bindParam(':nombre_empleado', $nombreEmpleado, PDO::PARAM_STR);
        $stmt->bindParam(':empleado_nomina', $nominaEmpleado, PDO::PARAM_STR);
        $stmt->bindParam(':empleado_puesto', $puestoEmpleado, PDO::PARAM_STR);
        $stmt->bindParam(':idDepartamento', $idDepartamento, PDO::PARAM_INT);
        $stmt->bindParam(':empleado_correo', $correoEmpleado, PDO::PARAM_STR);
        $stmt->bindParam(':empleado_telefono', $telefonoEmpleado, PDO::PARAM_STR);
        $stmt->bindParam(':empleado_red', $empleadoRed, PDO::PARAM_STR);
        $stmt->bindParam(':empleado_contra', $empleadoContra, PDO::PARAM_STR);
        $stmt->bindParam(':empleado_extensionTel', $empleadoExtensionTel, PDO::PARAM_STR);
        $stmt->bindParam(':empleado_extensionTel', $empleadoExtensionTel, PDO::PARAM_STR);
        $stmt->bindParam(':correo_contra', $correoContra, PDO::PARAM_STR);


        $stmt->execute();

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
        return false;
    }
}


 public static function generarColorAleatorio() {
    return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
}

public static function obtenerColorDepartamento($idDepartamento) {
    $conexion = mainModel::conectar();
    
    // Intenta obtener el color existente
    $sql = "SELECT Color FROM Tbl_ColoresDepartamentos WHERE IdDepartamento = :idDepartamento";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':idDepartamento', $idDepartamento, PDO::PARAM_INT);
    $stmt->execute();
    
    $color = $stmt->fetchColumn();
    
    if (!$color) {
        // Genera un color aleatorio si no hay color asignado
        $color = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
        
        // Inserta el nuevo color en la tabla
        $sql = "INSERT INTO Tbl_ColoresDepartamentos (IdDepartamento, Color) VALUES (:idDepartamento, :color)";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':idDepartamento', $idDepartamento, PDO::PARAM_INT);
        $stmt->bindParam(':color', $color);
        $stmt->execute();
    }
    
    return $color;
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
