<?php
	include("../principal/conectar_principal.php");

	$Proceso = $_REQUEST["Proceso"];
	$Valores = $_REQUEST["Valores"];
	$ano = $_REQUEST["ano"];
	$mes = $_REQUEST["mes"];
	$dia = $_REQUEST["dia"];
	$hh = $_REQUEST["hh"];
	$mm = $_REQUEST["mm"];

	switch($Proceso)
	{
		case "M":
			$Fecha=$ano."-".$mes."-".$dia;
			$Hora =$Fecha." ".$hh.":".$mm;
			$Datos=explode('|',$Valores);
			$Hornada=$Datos[0];
			$FechaTrasp=$Datos[1];
			$Prod=$Datos[2];
			$SubProd=$Datos[3];
			$Actualizar="UPDATE sea_web.movimientos set fecha_movimiento='$Fecha',hora='$Hora' where tipo_movimiento='1' and hornada='$Hornada' and cod_producto='$Prod' and cod_subproducto='$SubProd'";
			//echo $Actualizar."<br>";
			mysqli_query($link, $Actualizar);
			$Actualizar="UPDATE sec_web.traspaso set fecha_traspaso='$Fecha' where hornada='$Hornada' and cod_producto='$Prod' and cod_subproducto='$SubProd'";
			mysqli_query($link, $Actualizar);
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.FrmProgLoteo.action='sec_consulta_traspasadas.php';";
			echo "window.opener.document.FrmProgLoteo.submit();";
			echo "window.close();";
			echo "</script>";
			break;
		case "E":
			$Datos=explode('|',$Valores);
			$Hornada=$Datos[0];
			$FechaTrasp=$Datos[1];
			$Prod=$Datos[2];
			$SubProd=$Datos[3];
			$Eliminar="delete from sea_web.movimientos where tipo_movimiento='1' and hornada='$Hornada' and cod_producto='$Prod' and cod_subproducto='$SubProd'";
			//echo $Eliminar."<br>";
			mysqli_query($link, $Eliminar);
			$Eliminar="delete from sec_web.traspaso where hornada='$Hornada' and cod_producto='$Prod' and cod_subproducto='$SubProd'";
			//echo $Eliminar."<br>";
			mysqli_query($link, $Eliminar);
			header('location:sec_consulta_traspasadas.php');
			break;
	}
	
?>