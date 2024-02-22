<?php
	include("../principal/conectar_principal.php");
	
	if(isset($_REQUEST["Pantalla"])) {
		$Pantalla = $_REQUEST["Pantalla"];
	}else{
		$Pantalla =  "";
	}
	if(isset($_REQUEST["TxtLeyes"])) {
		$TxtLeyes = $_REQUEST["TxtLeyes"];
	}else{
		$TxtLeyes =  "";
	}

	echo "<script languaje='JavaScript'>";
	switch ($Pantalla)
	{
		case "40":
			echo " window.opener.document.FrmConsultaAnalisisProducto.action='cal_consulta_analisis_producto.php?Leyes=".substr($TxtLeyes,0,strlen($TxtLeyes)-1)."';";			
			break;
		case "41":
			echo " window.opener.document.FrmConsultaAnalisisProducto.action='cal_consulta_leyes_producto.php?Leyes=".substr($TxtLeyes,0,strlen($TxtLeyes)-1)."';";			
			break;
	}	
	echo " window.opener.document.FrmConsultaAnalisisProducto.submit();";	
	echo " window.close();</script>";
?>
