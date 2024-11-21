<?php   
require_once "./modelos/usuarioModelo.php"; // Asegúrate de incluir el modelo


class usuarioControl  {

       /*--------- Controlador agregar usuario ---------*/
       
    public function insertarUs() {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {


            
            // Verificar que los campos no estén vacíos
            if (empty($_POST["Nombres"]) || empty($_POST["Usuario"])|| empty($_POST["Contrasena"])) {
                echo '
                <script>
                    Swal.fire({
                        title: "Error",
                        text: "Todos los campos son obligatorios",
                        type: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>
                ';
                return; // Terminar la ejecución del método si hay campos vacíos
            }

            // Recibir datos del formulario
            $nombres = $_POST["Nombres"];
            $usuario = $_POST["Usuario"];
            $contrasena = $_POST["Contrasena"];

        
            // Crear una instancia del modelo
            $modelo = new usuarioModelo();
        
            // Llamar al método insertarArea del modelo
            $resultado = $modelo->insertarUsuario($nombres, $usuario, $contrasena);
        
            // Mostrar resultado al usuario
            if ($resultado === true) {
                echo '  
                <script>
                    Swal.fire({
                        title: "Guardado!",
                        text: "Se registró el usuario correctamente",
                        type: "success",
                        confirmButtonText: "Aceptar"
                    }).then(function() {
                        window.location.href = "'.SERVERURL.'user-list/";
                    });
                </script>
                ';
            } else {
                echo '
                <script>
                    Swal.fire({
                        title: "Ocurrió un error inesperado",
                        text: "No se pudo agregar el usuario",
                        type: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>
                ';
            }
        }
    }

    
    public function eliminarUsuario() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] == 'eliminar' && isset($_POST['idUsuario'])) {
           
            $idUsuario = $_POST['idUsuario'];
    
            try {
                // Llamar al método eliminarEmpleado del modelo
                $resultado = usuarioModelo::eliminarUsuario($idUsuario);
    
                // Enviar una respuesta al cliente
                if ($resultado) {
                    echo '
                    <script>
                        Swal.fire({
                             title: "Usuario eliminado",
    text: "El usuario se ha eliminado correctamente.",
                            type: "success",
                            confirmButtonText: "Aceptar"
                        }).then(function() {
    location.reload(); // Recarga la página actual
});

                    </script>
                    ';
                } else {
                   
                }
            } catch (PDOException $e) {
                // Manejo de errores de la base de datos desde el modelo
                error_log('Error en eliminarEmpleado del controlador: ' . $e->getMessage());
                echo 'Error en la base de datos al intentar eliminar el empleado.';
            } 
        } 
    }
    public function editarUsuario() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Verificar que los campos no estén vacíos
            if (empty($_POST["IdUsuario"]) || empty($_POST["Nombres"]) || empty($_POST["Usuario"]) || empty($_POST["Contrasena"])) {
                echo '
                <script>
                    Swal.fire({
                        title: "Error",
                        text: "Todos los campos son obligatorios",
                        type: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>
                ';
                return; // Terminar la ejecución del método si hay campos vacíos
            }
    
            // Recibir datos del formulario
            $idUsuario = $_POST["IdUsuario"];
            $nombres = $_POST["Nombres"];
            $usuario = $_POST["Usuario"];
            $contrasena = $_POST["Contrasena"];
    
            // Crear una instancia del modelo
            $modelo = new usuarioModelo();
    
            // Llamar al método actualizarUsuario del modelo
            $resultado = $modelo->actualizarUsuario($idUsuario, $nombres, $usuario, $contrasena);
    
            // Mostrar resultado al usuario
            if ($resultado === true) {
                echo '  
                <script>
                    Swal.fire({
                        title: "Guardado!",
                        text: "Se actualizó el usuario correctamente",
                        type: "success",
                        confirmButtonText: "Aceptar"
                    }).then(function() {
                        window.location.href = "'.SERVERURL.'user-list/";
                    });
                </script>
                ';
            } else {
                echo '
                <script>
                    Swal.fire({
                        title: "Ocurrió un error inesperado",
                        text: "No se pudo actualizar el usuario",
                        type: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>
                ';
            }
        }
    }
    
   

    
}