<?php

switch($_GET["Opcion"])
{
	case "agua_menu":
		require_once("jsonConstructor.php");
		$_SESSION["PagCancel"] = $_GET["Opcion"];
		$json["MuestraMensaje"] = false;
		$json["sucess"] = true;		        	
		$json["p"] = $config['url_path']."/?p=changepass";		
		echo json_encode($json);
		exit();
	break;
	default:
		$pagina->set_var("RUT",$_SESSION["CookieRut"]);
		$pagina->set_var("NOMBRE",$_SESSION["NombreUsu"]);
		$pagina->set_var("PATERNO",$_SESSION["PaternoApe"]);
		$pagina->set_var("MATERNO",$_SESSION["MaternoApe"]);
		$pagina->set_var("PagCancel",$_SESSION["PagCancel"]);
	break;
}

?>