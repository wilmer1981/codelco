<?php
	include("../principal/conectar_principal.php");
	
	switch($Proceso)
	{
		case "N":
			$Insertar = "INSERT INTO sec_web.parametros_mensual_proyeccion (mes,ano,tonelaje,factor_rechazo,factor_rechazo_prog,dia) VALUES ('$mes','$ano','$tonelaje','".str_replace(",",".",$factor)."','".str_replace(",",".",$factor2)."','".$Dia."')";
			//echo $Insertar."<br>";
			mysqli_query($link, $Insertar);
			break;
		case "M":
			$Actualizar = "UPDATE sec_web.parametros_mensual_proyeccion SET tonelaje='$valortonelaje',factor_rechazo='".str_replace(",",".",$factor)."',factor_rechazo_prog='".str_replace(",",".",$factor2)."',dia='".$Dia."' WHERE ano='$ano_ton' AND mes='$mes_ton'";
			//echo $Actualizar;
			mysqli_query($link, $Actualizar);
			break;
		case "E":
			break;
	}
	echo "<script languaje='JavaScript'>";
	echo "window.opener.document.frmPrincipal.action='sec_modificacion_parametros_proyeccion.php?Buscar=S';";
	echo "window.opener.document.frmPrincipal.submit();";
	echo "window.close();";
	echo "</script>";  

?>