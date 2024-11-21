<?php

require_once "mainModel.php";

class areasModelo extends mainModel {
    
    public function existeAreaPorNombre($nombreArea) {
        try {
            $conexion = mainModel::conectar();

            $sql = "SELECT COUNT(*) as count FROM Tbl_Areas WHERE NombreArea = :nombreArea";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':nombreArea', $nombreArea, PDO::PARAM_STR);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            return $resultado['count'] > 0;
        } catch (PDOException $e) {
            error_log('Error en existeAreaPorNombre del modelo: ' . $e->getMessage());
            return false; // Devolver false en caso de error
        }
    }

    public function insertarArea($nombreArea, $ubicacion) {
        try {
            $conexion = mainModel::conectar();
    
            // Verificar si el área ya existe antes de insertar
            if ($this->existeAreaPorNombre($nombreArea)) {
                return 'existe'; // Indicar que el área ya existe
            }
    
            // Preparar la consulta SQL para la inserción
            $sql = "INSERT INTO Tbl_Areas (NombreArea, Ubicacion) 
                    VALUES (:nombreArea, :ubicacion)";
            
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':nombreArea', $nombreArea, PDO::PARAM_STR);
            $stmt->bindParam(':ubicacion', $ubicacion, PDO::PARAM_STR);
            $stmt->execute();
    
            // Verificar si la inserción fue exitosa
            if ($stmt->rowCount() > 0) {
                return 'success'; // Éxito al insertar
            } else {
                return 'sin cambios'; // Si la consulta se ejecutó pero no se insertó nada
            }
        } catch (PDOException $e) {
            error_log('Error en insertarArea del modelo: ' . $e->getMessage());
            return 'error'; // Devolver error en caso de excepción
        }
    }
    
        public static function obtenerAreas() {
            try {
                $conexion = mainModel::conectar();
                $sql = "SELECT * FROM Tbl_Areas";
                $stmt = $conexion->prepare($sql);
                $stmt->execute();
                $areas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
                return $areas;
            } catch (PDOException $e) {
        
                return [];
            }
        }
    

            // FUNCION PARA OBTENER DATOS DEL AREA SELECCIONADO PARA EDITAR
            public static function obtenerDatosSeleccionadoArea($idArea) {
                try {
                    $conexion = mainModel::conectar();
                    $sql = "SELECT * FROM Tbl_Areas WHERE IdArea = :idArea";
                    $stmt = $conexion->prepare($sql);
                    $stmt->bindParam(':idArea', $idArea, PDO::PARAM_INT);
                    $stmt->execute();
                    $areaSeleccionado = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    // Limpiar espacios en blanco
                    if ($areaSeleccionado) {
                        $areaSeleccionado['NombreArea'] = trim($areaSeleccionado['NombreArea']);
                        $areaSeleccionado['Ubicacion'] = trim($areaSeleccionado['Ubicacion']);
                    }
            
                    return $areaSeleccionado;
                } catch (PDOException $e) {
                    // Manejo del error
                    error_log("Error en obtenerDatosSeleccionadoArea: " . $e->getMessage(), 3, "/path/a/tu/logs/error.log");
                    return null;
                }
            }
            
            
    public function editarArea($idArea, $nombreArea, $ubicacion) {
        try {
            $conexion = mainModel::conectar(); // Conectar a la base de datos

            // Verificar si el área existe
            $sql = "SELECT COUNT(*) FROM Tbl_Areas WHERE IdArea = :idArea";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':idArea', $idArea, PDO::PARAM_INT);
            $stmt->execute();
            $count = $stmt->fetchColumn();

            if ($count == 0) {
                return 'no_existe'; // El área no existe
            }

            // Actualizar el registro
            $sql = "UPDATE Tbl_Areas SET NombreArea = :nombreArea, Ubicacion = :ubicacion WHERE IdArea = :idArea";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':nombreArea', $nombreArea, PDO::PARAM_STR);
            $stmt->bindParam(':ubicacion', $ubicacion, PDO::PARAM_STR);
            $stmt->bindParam(':idArea', $idArea, PDO::PARAM_INT);
            $stmt->execute();

            // Verificar si la actualización fue exitosa
            if ($stmt->rowCount() > 0) {
                return 'success'; // Éxito al actualizar
            } else {
                return 'no_changes'; // No se actualizó ningún registro (puede ser que no haya cambios)
            }
        } catch (PDOException $e) {
            // Manejo de errores
            return 'error'; // En caso de error, retorna 'error'
        }
    }
    }
    



