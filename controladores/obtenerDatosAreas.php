<?php 
    require_once "./modelos/mainModel.php";
    class obtenerDatos extends mainModel{
        function obtenerOpcionesAreas($conexion) {

    
    
            // Llamar al método insertarArea del modelo

            $sql_areas = "SELECT IdArea, NombreArea FROM Tbl_Areas";
            $result_areas = $conexion->query($sql_areas);
        
            $options = ''; // Variable para almacenar las opciones de select
        
            if ($result_areas->num_rows > 0) {
                while ($row = $result_areas->fetch_assoc()) {
                    $options .= '<option value="' . $row["IdArea"] . '">' . $row["NombreArea"] . '</option>';
                }
            }
        
            return $options; // Devuelve el HT
        
        }
    }
   