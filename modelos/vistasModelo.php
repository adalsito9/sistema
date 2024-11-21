<?php
	
	class vistasModelo{

		/*--------- Modelo obtener vistas ---------*/
		protected static function obtener_vistas_modelo($vistas){
			$listaBlanca=["client-list","client-new","client-search","client-update","company","home","item-list","item-new","item-search","item-update","reservation-list","reservation-new","reservation-pending","reservation-search","reservation-update","user-list","reservation-reservation","user-new","user-search","user-update", "activos-new","activos-list","activos-search","area-new", "proveedores-new", "departamento-new", "acti-new", "activos-update", "bitacora-new","departamentos-areas-list","proveedores-list","usuarios-update", "departamentos-list", "areas-list", "client-update","proveedores-update", "departamentos-update","areas-update", "notas-new", "mantenimiento-new", "notas-list","mantto-new", "mantto-list"];
			if(in_array($vistas, $listaBlanca)){
				if(is_file("./vistas/contenidos/".$vistas."-view.php")){
					$contenido="./vistas/contenidos/".$vistas."-view.php";
				}else{
					$contenido="404";
				}
			}elseif($vistas=="login" || $vistas=="index"){
				$contenido="login";
			}else{
				$contenido="404";
			}
			return $contenido;
		}
	}