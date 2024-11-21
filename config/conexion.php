<?php 




    class Cconexion{

        function ConexionDB(){
            $host='localhost';
            $dbname='SYSTEM';
            $username='root';
            $pasword='1234';
            $puerto= 1433;


            try{
                $conn=new PDO("sqlsrv:Server=$host, $puerto;Database=$dbname",$username, $pasword);
                
            } catch(PDOException $exp) {

                echo ("No se logro conectar: $dbname, error: $exp");


            }
            return $conn;

        }         
    }

/*    class login{
       public function iniciar_sesion(){
            
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Obtiene los datos del formulario
                $Nombre = $_POST["Nombre"];
                $Usuario = $_POST["Usuario"];
                $Contrasena = $_POST["Contrasena"];
            
                // Crea una instancia de la clase Cconexion
                $conexion = new Cconexion();
            
                // Llama a la función ConexionDB() para establecer la conexión
                $conn = $conexion->ConexionDB();
            
                // Consulta SQL para verificar las credenciales
                $query = "SELECT * FROM Tbl_Usuarios WHERE Nombre = :Nombre AND Usuario = :Usuario AND Contrasena = :Contrasena";
                $statement = $conn->prepare($query);
                $statement->bindParam(":Nombre", $Nombre);
                $statement->bindParam(":Usuario", $Usuario);
                $statement->bindParam(":Contrasena", $Contrasena);
                $statement->execute();
            
                // Verifica si se encontró algún registro
                if ($statement->rowCount() == 1) {
                    // Inicio de sesión exitoso, redirige al usuario a una página de inicio
                    header("Location: home-view.php");
                    exit();
                } else {
                    // Credenciales incorrectas, muestra un mensaje de error
                    $mensaje_error = "Credenciales incorrectas. Por favor, inténtalo de nuevo.";
                }
            }
        }
    } */
    

    /* protected static function paginador_tablas($pagina,$Npaginas,$url,$botones){
        $tabla='<nav aria-label="Page navigation example"><ul class="pagination justify-content-center">';

        if($pagina==1){
            $tabla.='<li class="page-item disabled"><a class="page-link"><i class="fas fa-angle-double-left"></i></a></li>';
        }else{
            $tabla.='
            <li class="page-item"><a class="page-link" href="'.$url.'1/"><i class="fas fa-angle-double-left"></i></a></li>
            <li class="page-item"><a class="page-link" href="'.$url.($pagina-1).'/">Anterior</a></li>
            ';
        }


        $ci=0;
        for($i=$pagina; $i<=$Npaginas; $i++){
            if($ci>=$botones){
                break;
            }

            if($pagina==$i){
                $tabla.='<li class="page-item"><a class="page-link active" href="'.$url.$i.'/">'.$i.'</a></li>';
            }else{
                $tabla.='<li class="page-item"><a class="page-link" href="'.$url.$i.'/">'.$i.'</a></li>';
            }

            $ci++;
        }


        if($pagina==$Npaginas){
            $tabla.='<li class="page-item disabled"><a class="page-link"><i class="fas fa-angle-double-right"></i></a></li>';
        }else{
            $tabla.='
            <li class="page-item"><a class="page-link" href="'.$url.($pagina+1).'/">Siguiente</a></li>
            <li class="page-item"><a class="page-link" href="'.$url.$Npaginas.'/"><i class="fas fa-angle-double-right"></i></a></li>
            ';
        }

        $tabla.='</ul></nav>';
        return $tabla;
    }

    } */

