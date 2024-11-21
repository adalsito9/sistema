<?php
	require_once "mainModel.php";

	class loginModeloFun extends mainModel {
		public function autenticarUsuario($usuario, $contrasena) {
			// Llamar al método conectar() de mainModel para obtener la conexión
			$conexion = mainModel::conectar();
	
			// Consulta SQL para verificar las credenciales
			$query = "SELECT * FROM Tbl_Usuarios WHERE Usuario = ? AND Contrasena = ?";
			$stmt = $conexion->prepare($query);
			$stmt->execute([$usuario, $contrasena]);
			$usuario = $stmt->fetch();
			
			return $usuario;
		}
	}