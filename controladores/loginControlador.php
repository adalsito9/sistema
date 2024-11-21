<?php

	require_once "./modelos/loginModelo.php";


	
	class loginControladorFun extends loginModeloFun{
		public function index() {
			session_start();

			
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				// Si se envió un formulario POST para iniciar sesión
				if(isset($_POST['usuario']) && isset($_POST['contrasena'])) {
					$usuario = $_POST['usuario'];
					$contrasena = $_POST['contrasena'];
					
					// Llama al método para autenticar al usuario
					$usuarioAutenticado = $this->autenticarUsuario($usuario, $contrasena);

					if ($usuarioAutenticado) {
						
						// Inicio de sesión exitoso, redirecciona a la página de bienvenida
						$_SESSION['usuario'] = $usuarioAutenticado;

						header("Location: ".SERVERURL."home/");
						exit();
					} else {
						echo '
			<script>
				Swal.fire({
					title: "Error",
					text: "El USUARIO o CONTRASEÑA son incorrectos",
					type: "error",
					confirmButtonText: "Aceptar"
				});
			</script>
			';
					}
				}
			} else {
				// Si es una solicitud GET, puedes cargar la vista del formulario de inicio de sesión
				// Por ejemplo:
				// include 'ruta_a_tu_vista/login_view.php';
			}
		}
	
		// Método para autenticar al usuario en el modelo
		public function autenticarUsuario($usuario, $contrasena) {
			// Crear una instancia del modelo de login
			$loginModel = new loginModeloFun();
	
			// Llamar al método para autenticar el usuario en el modelo
			return $loginModel->autenticarUsuario($usuario, $contrasena);
		}
	}
		
		

		




	
	
	


	



