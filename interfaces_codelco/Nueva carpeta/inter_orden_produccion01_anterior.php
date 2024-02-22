<?php
	include("../principal/conectar_principal.php");
	echo $ValoresAux;
	switch ($Proceso)
	{
		case "G":
			break;
		case "E":
			
			header("location:inter_orden_produccion.php");
			break;
	}
?>