<?php
	include("../principal/conectar_principal.php");

	$Proceso  = $_REQUEST["Proceso"];
	
	$mes      = isset($_REQUEST["mes"])?$_REQUEST["mes"]:date("m");
	$ano      = isset($_REQUEST["ano"])?$_REQUEST["ano"]:date("Y");
	$tonelaje = isset($_REQUEST["tonelaje"])?$_REQUEST["tonelaje"]:0;
	$factor   = isset($_REQUEST["factor"])?$_REQUEST["factor"]:"";
	$factor2  = isset($_REQUEST["factor2"])?$_REQUEST["factor2"]:"";
	$Dia      = isset($_REQUEST["Dia"])?$_REQUEST["Dia"]:"";
	$valortonelaje = isset($_REQUEST["valortonelaje"])?$_REQUEST["valortonelaje"]:"";
	$mes_ton  = isset($_REQUEST["mes_ton"])?$_REQUEST["mes_ton"]:"";
	$ano_ton  = isset($_REQUEST["ano_ton"])?$_REQUEST["ano_ton"]:"";
	
switch($Proceso)
	{
		case "N":
			if($factor=="") $factor=0;
			if($factor2=="") $factor2=0;
			if($Dia=="") $Dia=0;
		    $Consulta = "Select * From sec_web.parametros_mensual_proyeccion Where mes ='".$mes."' and ano='".$ano."' ";
			$Result = mysqli_query($link, $Consulta);
			$cont = mysqli_num_rows($Result);
			if($cont==0){				
				$Insertar = "INSERT INTO sec_web.parametros_mensual_proyeccion (mes,ano,tonelaje,factor_rechazo,factor_rechazo_prog,dia) VALUES ('$mes','$ano',$tonelaje,'".str_replace(",",".",$factor)."','".str_replace(",",".",$factor2)."','".$Dia."')";
				//echo $Insertar."<br>";
				mysqli_query($link, $Insertar);
			}
			break;
		case "M":
			if($valortonelaje=="") $valortonelaje=0;
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