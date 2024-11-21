<?php
    require_once ("./config/APP.php");
    require_once '../modelos/activosModelo.php';



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idEquipo = $_POST['idEquipo'];
    $nuevoEstatus = $_POST['nuevoEstatus'];

    try {

        $conexion = new PDO("sqlsrv:server=localhost;database=SYSTEM", "root", "1234");
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Actualizar el estatus del equipo
        $sql = "UPDATE [dbo].[Tbl_EqComputo] SET [IdEstatus] = :nuevoEstatus WHERE [IdEquipo] = :idEquipo";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':nuevoEstatus', $nuevoEstatus, PDO::PARAM_INT);
        $stmt->bindParam(':idEquipo', $idEquipo, PDO::PARAM_INT);
        $stmt->execute();

        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}