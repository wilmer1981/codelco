<?php
require_once('json_contructor.php');

switch ($_GET["Opcion"]) {
	case 'cargar_solicitud':

		$separaPlantilla=explode('_', $_POST["plantilla"]);

		$id_muestra=$separaPlantilla[0];
		$cod_producto=$separaPlantilla[1];
		$cod_subproducto=$separaPlantilla[2];
		$fecha=$_POST["fechaHora"];


		$resp1=$fx->obtenerPlantillas($_SESSION["CodSistemaSel"],$separaPlantilla[1],$separaPlantilla[2],$separaPlantilla[0]);
			if($Fila=mysqli_fetch_assoc($resp1))
			{
				
				for ($i=1; $i <= $_POST["cantidad"]; $i++) { 
					$fx->insertarSolicitud($Fila,$i,$_POST["fechaHora"]);
	 			}

			}
		$_SESSION["fechaCreacion"]=$_POST["fechaHora"];
		$json["sucess"] = true;
		$json["p"] = "JForm";
		$json["MuestraMensaje"] = false;
				echo json_encode($json);
			exit();
		break;
	 
	default:
		# code...
		break;
}

?>