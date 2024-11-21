<?php
	

$peticionAjax=true;
require_once "../config/APP.php";

if(isset($_POST['usuario'])){

    /*--------- Instancia al controlador ---------*/
    require_once "../controladores/loginControlador.php";
    $ins_login = new loginControladorFun();
}
	