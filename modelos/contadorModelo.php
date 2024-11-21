<?php
require_once "mainModel.php";

    
     class contadorModelo extends mainModel{
    // Función para obtener la cantidad de registros de la tabla BitacoraEq


    public static function obtenerCantidadRegistrosEquipos() {
        try {
            $conexion = mainModel::conectar();
            $sql = "SELECT COUNT(*) AS total FROM Tbl_EqComputo";
            $stmt = $conexion->query($sql);
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado['total'];
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return 0; // Retornar 0 en caso de error
        }
    }

    public static function obtenerCantidadRegistrosDepartamentos() {
        try {
            $conexion = mainModel::conectar();
            $sql = "SELECT COUNT(*) AS total FROM Tbl_Departamentos";
            $stmt = $conexion->query($sql);
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado['total'];
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return 0; // Retornar 0 en caso de error
        }
    }

    public static function obtenerCantidadRegistrosProveedores() {
        try {
            $conexion = mainModel::conectar();
            $sql = "SELECT COUNT(*) AS total FROM Tbl_Proveedores";
            $stmt = $conexion->query($sql);
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado['total'];
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return 0; // Retornar 0 en caso de error
        }
    }

    public static function obtenerCantidadRegistrosUsuarios() {
        try {
            $conexion = mainModel::conectar();
            $sql = "SELECT COUNT(*) AS total
            FROM Tbl_Usuarios
            WHERE IdUsuario <> (
                SELECT MIN(IdUsuario) FROM Tbl_Usuarios
            );";
            $stmt = $conexion->query($sql);
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado['total'];
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return 0; // Retornar 0 en caso de error
        }
    }

    public static function obtenerCantidadRegistrosEmpleados() {
        try {
            $conexion = mainModel::conectar();
            $sql = "SELECT COUNT(*) AS total FROM Tbl_Empleados";
            $stmt = $conexion->query($sql);
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado['total'];
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return 0; // Retornar 0 en caso de error
        }
    }

public static function obtenerCantidadRegistrosBitacora() {
    try {
        $conexion = mainModel::conectar();
        $sql = "SELECT COUNT(*) AS total FROM Tbl_BitacoraEq";
        $stmt = $conexion->query($sql);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado['total'];
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return 0; // Retornar 0 en caso de error
    }
}

public static function obtenerCantidadRegistrosArea() {
    try {
        $conexion = mainModel::conectar();
        $sql = "SELECT COUNT(*) AS total FROM Tbl_Areas";
        $stmt = $conexion->query($sql);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado['total'];
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return 0; // Retornar 0 en caso de error
    }
}


public static function cantidadNotas() {
    try {
        $conexion = mainModel::conectar();
        $sql = "SELECT COUNT(*) AS total FROM Tbl_Notas";
        $stmt = $conexion->query($sql);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado['total'];
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return 0; // Retornar 0 en caso de error
    }
}


public static function cantidadMantenimiento() {
    try {
        $conexion = mainModel::conectar();
        $sql = "SELECT COUNT(*) AS total FROM Tbl_HistorialManttoEq";
        $stmt = $conexion->query($sql);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado['total'];
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return 0; // Retornar 0 en caso de error
    }
}
 }

