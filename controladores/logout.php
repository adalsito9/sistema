<?php
    require_once ("../config/APP.php");

    // Iniciar la sesión si no está iniciada
    session_start();

    // Destruir todas las variables de sesión
    $_SESSION = array();

    // Finalmente, destruir la sesión
    session_destroy();

    // Redirigir al usuario a la página de inicio de sesión u otra página relevante
    header("Location: ".SERVERURL."login/");
    exit; 


   