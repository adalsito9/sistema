<?php

require_once "mainModel.php";

class activosModelo extends mainModel
{

    public function insertarActivos(
        $idTipoEquipo,
        $idEstatus,
        $idProveedor,
        $idArea,
        $idEmpleado,
        $ip,
        $procesador,
        $velocidadDelProcesador,
        $ram,
        $discoDuro,
        $sistemaOperativo,
        $office,
        $serviceTag,
        $nombreEquipo,
        $folioFactura,
        $fechaCompra
    ) {
        try {
            $conexion = mainModel::conectar();
            $sql = "INSERT INTO Tbl_EqComputo (IdTipoEquipo, IdEstatus, IdProveedor, IdArea, IdEmpleado, IP, 
            Procesador, VelocidadProcesador, Ram, DiscoDuro, SistemaOperativo, Office, ServiceTag, NombreEquipo, FolioFactura, FechaCompra) 
            VALUES (:idTipoEquipo, :idEstatus, :idProveedor, :idArea, :idEmpleado, :ip, 
            :procesador, :velocidadDelProcesador, :ram, :discoDuro, :sistemaOperativo, :office, :serviceTag, :nombreEquipo, :folioFactura, :fechaCompra)";

            $stmt = $conexion->prepare($sql);

            // Vincular parámetros
            $stmt->bindValue(":idTipoEquipo", !empty($idTipoEquipo) ? $idTipoEquipo : null, PDO::PARAM_INT);
            $stmt->bindValue(":idEstatus", $idEstatus, PDO::PARAM_INT);
            $stmt->bindValue(":idProveedor", !empty($idProveedor) ? $idProveedor : null, PDO::PARAM_INT); // Manejar NULL si es opcional
            $stmt->bindValue(":idArea", !empty($idArea) ? $idArea : null, PDO::PARAM_INT);
            $stmt->bindValue(":idEmpleado", !empty($idEmpleado) ? $idEmpleado : null, PDO::PARAM_INT);
            $stmt->bindValue(":ip", $ip);
            $stmt->bindValue(":procesador", $procesador);
            $stmt->bindValue(":velocidadDelProcesador", $velocidadDelProcesador);
            $stmt->bindValue(":ram", $ram);
            $stmt->bindValue(":discoDuro", $discoDuro);
            $stmt->bindValue(":sistemaOperativo", $sistemaOperativo);
            $stmt->bindValue(":office", $office);
            $stmt->bindValue(":serviceTag", $serviceTag);
            $stmt->bindValue(":nombreEquipo", $nombreEquipo);
            $stmt->bindValue(":folioFactura", $folioFactura);
             // Manejar fechaCompra como NULL si está vacía
        if ($fechaCompra === null || $fechaCompra === '') {
            $stmt->bindValue(":fechaCompra", null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(":fechaCompra", $fechaCompra);
        }

            // Ejecutar consulta
            $stmt->execute();

            // Verificar si la inserción fue exitosa
            if ($stmt->rowCount() > 0) {
                return true; // Éxito al insertar
            } else {
                return false; // Error al insertar
            }
        } catch (PDOException $e) {
            // Manejo de errores de la base de datos
            throw new Exception("Error en el modelo insertarActivos: " . $e->getMessage());
        }
    }

    // Método para obtener el número de equipos de computo asignados a un empleado
    public function obtenerNumeroEquiposEmpleado($idEmpleado)
    {
        try {
            $conexion = mainModel::conectar();
            $sql = "SELECT COUNT(*) AS numEquipos FROM Tbl_EqComputo WHERE IdEmpleado = :idEmpleado";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':idEmpleado', $idEmpleado);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            return $resultado['numEquipos'];
        } catch (PDOException $e) {
            // Manejo de errores
            echo "Error al obtener número de equipos del empleado: " . $e->getMessage();
            return 0; // Retornar 0 en caso de error
        }
    }
    public function obtenerDatos()
    {
        try {
            $conexion = mainModel::conectar();
            $datos_complejos = [];

            // Consulta para la tabla 1
            $sql1 = "SELECT IdTipoEquipo, NombreTipoEquipo FROM Tbl_TiposEq";
            $stmt1 = $conexion->prepare($sql1);
            $stmt1->execute();
            $datos_tabla1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
            $datos_complejos['tabla1'] = $datos_tabla1;

            // Consulta para la tabla 2
            $sql2 = "SELECT IdEstatus, NombreEstatus FROM Tbl_EstatusEq";
            $stmt2 = $conexion->prepare($sql2);
            $stmt2->execute();
            $datos_tabla2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
            $datos_complejos['tabla2'] = $datos_tabla2;

            // Consulta para la tabla 3
            $sql3 = "SELECT IdProveedor, NombreProveedor FROM Tbl_Proveedores";
            $stmt3 = $conexion->prepare($sql3);
            $stmt3->execute();
            $datos_tabla3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);
            $datos_complejos['tabla3'] = $datos_tabla3;

            // Consulta para la tabla 4
            $sql4 = "SELECT IdArea, NombreArea FROM Tbl_Areas ORDER BY NombreArea ASC";
            $stmt4 = $conexion->prepare($sql4);
            $stmt4->execute();
            $datos_tabla4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);
            $datos_complejos['tabla4'] = $datos_tabla4;

            // Consulta para la tabla 4
            $sql4 = "SELECT emp.*, dep.NombreDepartamento
FROM Tbl_Empleados emp
LEFT JOIN Tbl_Departamentos dep ON emp.IdDepartamento = dep.IdDepartamento
ORDER BY emp.Nombre ASC
            ";

            // CONSULTA SI QUIERO FILTRAR LOS EMPLEADOS DISPONIBLES PARA ASIGNAR A UN EQUIPO DE COMPUTO

            //                     SELECT e.IdEmpleado, e.Nombre, e.Nomina
            // FROM Tbl_Empleados e
            // LEFT JOIN Tbl_EqComputo c ON e.IdEmpleado = c.IdEmpleado
            // WHERE c.IdEmpleado IS NULL;

            $stmt4 = $conexion->prepare($sql4);
            $stmt4->execute();
            $datos_tabla5 = $stmt4->fetchAll(PDO::FETCH_ASSOC);
            $datos_complejos['tabla5'] = $datos_tabla5;

            return $datos_complejos;
        } catch (PDOException $e) {
            return []; // En caso de error, retornar un arreglo vacío o manejar el error según sea necesario
        }
    }
    public static function verificarNombreEquipo($nombre)
    {
        try {
            $conexion = mainModel::conectar();
    
            // Preparar la consulta SQL
            $sql = "SELECT COUNT(*) as count FROM Tbl_EqComputo WHERE NombreEquipo = :nombre";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->execute();
    
            // Obtener el resultado
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['count'] > 0; // Devuelve true si existe, false si no
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false; // Retorna false en caso de error
        }
    }
    public static function obtenerEquipos()
    {
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

            $stmt = $conexion->query($sql);
            $equipos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $equipos;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return []; // Retornar un arreglo vacío en caso de error
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
     emp.Nombre AS Nombre,  -- Cambiado para reflejar la tabla de empleados
     hm.FechaMantenimiento,
     hm.DetallesMantenimiento,
     hm.RealizadoPor
 FROM 
     Tbl_EqComputo e
 JOIN 
     Tbl_HistorialManttoEq hm ON e.IdEquipo = hm.IdEquipo
     LEFT JOIN 
 Tbl_Empleados emp ON e.IdEmpleado = emp.IdEmpleado 
 ORDER BY 
     e.NombreEquipo, hm.FechaMantenimiento DESC";

            $stmt = $conexion->query($sql);
            $equiposMto = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $equiposMto;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return []; // Retornar un arreglo vacío en caso de error
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


    public static function obtenerDetallesEquipo($idEquipo)
    {
        try {
            $conexion = mainModel::conectar();
            $sql = "SELECT 
            ec.IdEquipo, 
            es.NombreEstatus, 
            ec.NombreEquipo, 
            ec.IdTipoEquipo, 
            te.NombreTipoEquipo, 
            ec.IP, 
            ec.Procesador, 
            ec.VelocidadProcesador, 
            ec.Ram, 
            ec.DiscoDuro, 
            ec.SistemaOperativo, 
            ec.Office, 
            ec.ServiceTag,
            prov.NombreProveedor,
            ec.FolioFactura,
            ec.FechaCompra,
            a.NombreArea,
            emp.Nombre,
            ec.IdEstatus  -- Asegúrate de seleccionar el IdEstatus
        FROM Tbl_EqComputo ec
        INNER JOIN Tbl_TiposEq te ON ec.IdTipoEquipo = te.IdTipoEquipo
        INNER JOIN Tbl_EstatusEq es ON ec.IdEstatus = es.IdEstatus  
        LEFT JOIN Tbl_Proveedores prov ON ec.IdProveedor = prov.IdProveedor
        LEFT JOIN Tbl_Areas a ON ec.IdArea = a.IdArea
        LEFT JOIN Tbl_Empleados emp ON ec.IdEmpleado = emp.IdEmpleado
        WHERE ec.IdEquipo = :idEquipo"; // Filtrar por el ID del equipo

            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':idEquipo', $idEquipo, PDO::PARAM_INT);
            $stmt->execute();

            $detalleEquipo = $stmt->fetch(PDO::FETCH_ASSOC); // Usar fetch en lugar de fetchAll

            return $detalleEquipo;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null; // Retornar null en caso de error
        }
    }

    public static function obtenerDatosSeleccionado($idEquipo)
    {
        try {
            $conexion = mainModel::conectar();
            $sql = "SELECT * FROM Tbl_EqComputo WHERE IdEquipo = :idEquipo";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':idEquipo', $idEquipo, PDO::PARAM_INT);
            $stmt->execute();
            $detalleEquipo = $stmt->fetch(PDO::FETCH_ASSOC);
            return $detalleEquipo;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    public static function actualizarEquipo(
        $idEquipo,
        $idTipoEquipo,
        $idEstatus,
        $idProveedor,
        $idArea,
        $idEmpleado,
        $ip,
        $procesador,
        $velocidadDelProcesador,
        $ram,
        $discoDuro,
        $sistemaOperativo,
        $office,
        $serviceTag,
        $nombreEquipo,
        $folioFactura,
        $fechaCompra
    ) {
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
                        ServiceTag = :serviceTag, 
                        NombreEquipo = :nombreEquipo, 
                        FolioFactura = :folioFactura, 
                        FechaCompra = :fechaCompra 
                    WHERE IdEquipo = :idEquipo";

            $stmt = $conexion->prepare($sql);

            // Vincular parámetros
            $stmt->bindValue(":idEquipo", $idEquipo, PDO::PARAM_INT);
            $stmt->bindValue(":idTipoEquipo", !empty($idTipoEquipo) ? $idTipoEquipo : null, PDO::PARAM_INT);
            $stmt->bindValue(":idEstatus", $idEstatus, PDO::PARAM_INT);
            $stmt->bindValue(":idProveedor", !empty($idProveedor) ? $idProveedor : null, PDO::PARAM_INT);
            $stmt->bindValue(":idArea", !empty($idArea) ? $idArea : null, PDO::PARAM_INT);
            $stmt->bindValue(":idEmpleado", !empty($idEmpleado) ? $idEmpleado : null, PDO::PARAM_INT);
            $stmt->bindValue(":ip", $ip);
            $stmt->bindValue(":procesador", $procesador);
            $stmt->bindValue(":velocidadDelProcesador", $velocidadDelProcesador);
            $stmt->bindValue(":ram", $ram);
            $stmt->bindValue(":discoDuro", $discoDuro);
            $stmt->bindValue(":sistemaOperativo", $sistemaOperativo);
            $stmt->bindValue(":office", $office);
            $stmt->bindValue(":serviceTag", $serviceTag);
            $stmt->bindValue(":nombreEquipo", $nombreEquipo);
            $stmt->bindValue(":folioFactura", $folioFactura);
            // Manejar fechaCompra como NULL si está vacía
        if ($fechaCompra === null || $fechaCompra === '') {
            $stmt->bindValue(":fechaCompra", null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(":fechaCompra", $fechaCompra);
        }
            // Ejecutar consulta
            $stmt->execute();

            // Verificar si la actualización fue exitosa
            if ($stmt->rowCount() > 0) {
                return true; // Éxito al actualizar
            } else {
                return false; // Error al actualizar (ninguna fila afectada)
            }
        } catch (PDOException $e) {
            // Manejo de errores de la base de datos
            throw new Exception("Error en el modelo actualizarEquipo: " . $e->getMessage());
        }
    }



    public static function marcarEquipoInactivo($idEquipo)
    {
        try {
            $conexion = mainModel::conectar(); // Establecer conexión a la base de datos
            $sql = "UPDATE Tbl_EqComputo SET IdEstatus = :idEstatus WHERE IdEquipo = :idEquipo";

            $stmt = $conexion->prepare($sql);

            // Parámetros
            $idEstatus = 2; // ID de estatus 'Inactivo'
            $stmt->bindValue(":idEstatus", $idEstatus, PDO::PARAM_INT);
            $stmt->bindValue(":idEquipo", $idEquipo, PDO::PARAM_INT);

            // Ejecutar consulta
            $stmt->execute();

            // Verificar si la actualización fue exitosa
            if ($stmt->rowCount() > 0) {
                return true; // Éxito al marcar como inactivo
            } else {
                return false; // Error al marcar como inactivo (ninguna fila afectada)
            }
        } catch (PDOException $e) {
            // Manejo de errores de la base de datos
            error_log("Error en el modelo marcarEquipoInactivo: " . $e->getMessage()); // Registrar el error en el log
            return false; // Indicar error en la actualización
        }
    }

    public static function obtenerEstatusEquipo($idEquipo)
    {
        try {
            $conexion = mainModel::conectar();
            $sql = "SELECT IdEstatus FROM Tbl_EqComputo WHERE IdEquipo = :idEquipo";
            $stmt = $conexion->prepare($sql);
            $stmt->bindValue(":idEquipo", $idEquipo, PDO::PARAM_INT);
            $stmt->execute();

            // Obtener el resultado
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($resultado) {
                return $resultado['IdEstatus']; // Devolver el estatus
            } else {
                return false; // Equipo no encontrado
            }
        } catch (PDOException $e) {
            error_log("Error en el modelo obtenerEstatusEquipo: " . $e->getMessage());
            return false;
        }
    }
    public static function obtenerProcesadores()
    {
        try {
            $conexion = mainModel::conectar();
            $sql = "SELECT nombreProcesador FROM Tbl_Procesadores";

            $stmt = $conexion->query($sql);
            $procesadores = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $procesadores;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return []; // Retornar un arreglo vacío en caso de error
        }
    }

    public static function obtenerSistemasOperativos()
    {
        try {
            $conexion = mainModel::conectar();
            $sql = "SELECT nombreSistemaOperativo FROM Tbl_SistemasOperativos";

            $stmt = $conexion->query($sql);
            $operativos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $operativos;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return []; // Retornar un arreglo vacío en caso de error
        }
    }
    public static function obtenerOffice()
    {
        try {
            $conexion = mainModel::conectar();
            $sql = "SELECT nombreVersion FROM Tbl_Office";

            $stmt = $conexion->query($sql);
            $offices = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $offices;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return []; // Retornar un arreglo vacío en caso de error
        }
    }

    public static function obtenerDiscoDuro()
    {
        try {
            $conexion = mainModel::conectar();
            $sql = "SELECT tamañoDiscoDuro FROM Tbl_DiscoDuro";

            $stmt = $conexion->query($sql);
            $discosDuros = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $discosDuros;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return []; // Retornar un arreglo vacío en caso de error
        }
    }

    public static function obtenerEquiposFiltrados()
    {
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
                ec.FechaCompra,
                ec.FolioFactura,
                emp.Nombre AS Nombre,
                prov.NombreProveedor AS NombreProveedor,
                area.NombreArea
            FROM 
                Tbl_EqComputo ec
            INNER JOIN 
                Tbl_TiposEq te ON ec.IdTipoEquipo = te.IdTipoEquipo
            INNER JOIN 
                Tbl_EstatusEq es ON ec.IdEstatus = es.IdEstatus
            LEFT JOIN 
                Tbl_Empleados emp ON ec.IdEmpleado = emp.IdEmpleado
            LEFT JOIN 
                Tbl_Proveedores prov ON ec.IdProveedor = prov.IdProveedor
            LEFT JOIN 
                Tbl_Areas area ON ec.IdArea = area.IdArea
            ORDER BY 
                ec.IdEquipo DESC";

            $stmt = $conexion->query($sql);
            $equipos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $equipos;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return []; // Retornar un arreglo vacío en caso de error
        }
    }

    // activosModelo.php

    static public function obtenerEquiposRef($estatus = '', $fechaInicio = '', $fechaFin = '')
    {
        try {
            $conexion = mainModel::conectar();

            // Construcción dinámica de la consulta SQL
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
            ec.FechaCompra,
            ec.FolioFactura,
            emp.Nombre AS Nombre,
            prov.NombreProveedor AS NombreProveedor,
            area.NombreArea
        FROM 
            Tbl_EqComputo ec
        INNER JOIN 
            Tbl_TiposEq te ON ec.IdTipoEquipo = te.IdTipoEquipo
        INNER JOIN 
            Tbl_EstatusEq es ON ec.IdEstatus = es.IdEstatus
        LEFT JOIN 
            Tbl_Empleados emp ON ec.IdEmpleado = emp.IdEmpleado
        LEFT JOIN 
            Tbl_Proveedores prov ON ec.IdProveedor = prov.IdProveedor
        LEFT JOIN 
            Tbl_Areas area ON ec.IdArea = area.IdArea
        WHERE 1=1"; // Usamos WHERE 1=1 para simplificar la adición de condiciones

            // Añadir condiciones según los parámetros
            if ($estatus) {
                $sql .= " AND es.NombreEstatus = :estatus";
            }
            if ($fechaInicio && $fechaFin) {
                $sql .= " AND ec.FechaCompra BETWEEN :fechaInicio AND :fechaFin";
            }

            $sql .= " ORDER BY ec.IdEquipo DESC";

            $stmt = $conexion->prepare($sql);

            // Vincular parámetros
            if ($estatus) {
                $stmt->bindParam(':estatus', $estatus, PDO::PARAM_STR);
            }
            if ($fechaInicio && $fechaFin) {
                $stmt->bindParam(':fechaInicio', $fechaInicio, PDO::PARAM_STR);
                $stmt->bindParam(':fechaFin', $fechaFin, PDO::PARAM_STR);
            }

            $stmt->execute();
            $equipos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $equipos;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
    public static function obtenerEquiposPorEstatus($estatus = '')
    {
        try {
            $conexion = mainModel::conectar();
            
            // Construir la consulta SQL con filtro opcional para estatus
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
                        ec.FechaCompra,
                        ec.FolioFactura,
                        emp.Nombre AS Nombre,
                        prov.NombreProveedor AS NombreProveedor,
                        area.NombreArea
                    FROM 
                        Tbl_EqComputo ec
                    INNER JOIN 
                        Tbl_TiposEq te ON ec.IdTipoEquipo = te.IdTipoEquipo
                    INNER JOIN 
                        Tbl_EstatusEq es ON ec.IdEstatus = es.IdEstatus
                    LEFT JOIN 
                        Tbl_Empleados emp ON ec.IdEmpleado = emp.IdEmpleado
                    LEFT JOIN 
                        Tbl_Proveedores prov ON ec.IdProveedor = prov.IdProveedor
                    LEFT JOIN 
                        Tbl_Areas area ON ec.IdArea = area.IdArea
                    WHERE 1=1"; // Facilita la adición de condiciones
    
            // Añadir filtro opcional de estatus
            if (!empty($estatus)) {
                $sql .= " AND es.NombreEstatus LIKE :estatus";
            }
    
            $sql .= " ORDER BY ec.FechaCompra DESC;";
            
            $stmt = $conexion->prepare($sql);
    
            // Asignar el parámetro de búsqueda para estatus
            if (!empty($estatus)) {
                $stmt->bindValue(':estatus', "%$estatus%");
            }
    
            $stmt->execute();
            $equipos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $equipos;
        } catch (PDOException $e) {
            return [];
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
    
    
    // public static function obtenerEquiposFilt($estatus, $tipoEquipo, $area, $fecha_inicio, $fecha_fin)
    // {
    //     try {
    //         $conexion = mainModel::conectar();
    //         $sql = "SELECT * FROM Tbl_EqComputo WHERE 1=1"; // 1=1 para facilitar la concatenación de condiciones
    
    //         // Agregar condiciones según los parámetros proporcionados
    //         if ($estatus !== '') {
    //             $sql .= " AND IdEstatus = :estatus";
    //         }
    //         if ($tipoEquipo !== '') {
    //             $sql .= " AND Tipo = :tipoEquipo";
    //         }
    //         if ($area !== '') {
    //             $sql .= " AND IdArea = :area";
    //         }
    //         if ($fecha_inicio !== '') {
    //             $sql .= " AND Fecha >= :fecha_inicio";
    //         }
    //         if ($fecha_fin !== '') {
    //             $sql .= " AND Fecha <= :fecha_fin";
    //         }
    
    //         $stmt = $conexion->prepare($sql);
    
    //         // Vincular parámetros
    //         if ($estatus !== '') {
    //             $stmt->bindValue(":estatus", $estatus, PDO::PARAM_STR);
    //         }
    //         if ($tipoEquipo !== '') {
    //             $stmt->bindValue(":tipoEquipo", $tipoEquipo, PDO::PARAM_STR);
    //         }
    //         if ($area !== '') {
    //             $stmt->bindValue(":area", $area, PDO::PARAM_INT);
    //         }
    //         if ($fecha_inicio !== '') {
    //             $stmt->bindValue(":fecha_inicio", $fecha_inicio, PDO::PARAM_STR);
    //         }
    //         if ($fecha_fin !== '') {
    //             $stmt->bindValue(":fecha_fin", $fecha_fin, PDO::PARAM_STR);
    //         }
    
    //         $stmt->execute();
    
    //         // Obtener los resultados
    //         return $stmt->fetchAll(PDO::FETCH_ASSOC);
    //     } catch (PDOException $e) {
    //         error_log("Error en el modelo obtenerEquiposFilt: " . $e->getMessage());
    //         return false;
    //     }
    // }
    

    // public static function obtenerEquiposFilt($estatus, $area, $fecha_inicio, $fecha_fin, $tipoEquipo)
    // {
    //     try {
    //         $conexion = mainModel::conectar();
    //         $sql = "SELECT * FROM Tbl_EqComputo WHERE 1=1";
            
    //         if ($estatus) {
    //             $sql .= " AND IdEstatus = :estatus";
    //         }
    //         if ($area) {
    //             $sql .= " AND Area = :area";
    //         }
    //         if ($fecha_inicio) {
    //             $sql .= " AND Fecha >= :fecha_inicio";
    //         }
    //         if ($fecha_fin) {
    //             $sql .= " AND Fecha <= :fecha_fin";
    //         }
    //         if ($tipoEquipo) {
    //             $sql .= " AND TipoEquipo = :tipoEquipo";
    //         }
    
    //         $stmt = $conexion->prepare($sql);
            
    //         // Vincular parámetros
    //         if ($estatus) $stmt->bindValue(":estatus", $estatus, PDO::PARAM_INT);
    //         if ($area) $stmt->bindValue(":area", $area, PDO::PARAM_STR);
    //         if ($fecha_inicio) $stmt->bindValue(":fecha_inicio", $fecha_inicio, PDO::PARAM_STR);
    //         if ($fecha_fin) $stmt->bindValue(":fecha_fin", $fecha_fin, PDO::PARAM_STR);
    //         if ($tipoEquipo) $stmt->bindValue(":tipoEquipo", $tipoEquipo, PDO::PARAM_STR);
            
    //         $stmt->execute();
    //         return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos los equipos encontrados
    //     } catch (PDOException $e) {
    //         error_log("Error en el modelo obtenerEquiposFilt: " . $e->getMessage());
    //         return false;
    //     }
    // }
    
    public static function obtenerEquiposFilt($estatus = '', $area = '', $fecha_inicio = '', $fecha_fin = '', $tipoEquipo = '')
    {
        try {
            $conexion = mainModel::conectar();
    
            $sql = "SELECT 
                        ec.IdEquipo, 
                        es.NombreEstatus, 
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
                        ec.FechaCompra,
                        ec.FolioFactura,
                        emp.Nombre AS Nombre,
                        prov.NombreProveedor AS NombreProveedor,
                        area.NombreArea
                    FROM 
                        Tbl_EqComputo ec
                    INNER JOIN 
                        Tbl_TiposEq te ON ec.IdTipoEquipo = te.IdTipoEquipo
                    INNER JOIN 
                        Tbl_EstatusEq es ON ec.IdEstatus = es.IdEstatus
                    LEFT JOIN 
                        Tbl_Empleados emp ON ec.IdEmpleado = emp.IdEmpleado
                    LEFT JOIN 
                        Tbl_Proveedores prov ON ec.IdProveedor = prov.IdProveedor
                    LEFT JOIN 
                        Tbl_Areas area ON ec.IdArea = area.IdArea
                    WHERE 1=1";
    
            // Añadir filtros de estatus
            if (!empty($estatus)) {
                $sql .= " AND es.NombreEstatus = :estatus";
            }
            // Añadir filtros de área
            if (!empty($area)) {
                $sql .= " AND area.IdArea = :area";
            }
            // Añadir filtros de tipo de equipo
            if (!empty($tipoEquipo)) {
                $sql .= " AND te.IdTipoEquipo = :tipoEquipo"; // Asegúrate de usar IdTipoEquipo
            }
    
            // Añadir filtro de fecha
            if (!empty($fecha_inicio) && !empty($fecha_fin)) {
                $sql .= " AND ec.FechaCompra BETWEEN :fecha_inicio AND :fecha_fin";
            } elseif (!empty($fecha_inicio)) {
                $sql .= " AND ec.FechaCompra >= :fecha_inicio";
            }
    
            $stmt = $conexion->prepare($sql);
    
            // Asignar los parámetros de búsqueda
            if (!empty($tipoEquipo)) {
                $stmt->bindValue(':tipoEquipo', $tipoEquipo);
            }
            if (!empty($estatus)) {
                $stmt->bindValue(':estatus', $estatus);
            }
            if (!empty($area)) {
                $stmt->bindValue(':area', $area);
            }
            if (!empty($fecha_inicio)) {
                $stmt->bindValue(':fecha_inicio', $fecha_inicio);
            }
            if (!empty($fecha_fin)) {
                $stmt->bindValue(':fecha_fin', $fecha_fin);
            }
    
            $stmt->execute();
            $equipos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $equipos;
        } catch (PDOException $e) {
            return [];
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
