<?php

	include("../principal/conectar_principal.php");
	$Proceso      = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Valores      = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	$SubProducto  = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";
	$Mes        = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("m");
	$Ano        = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");

	switch ($Proceso)
	{	
		case "G":
			$Datos=explode("//",$Valores);
			//var_dump($Datos);
			//exit();
			foreach($Datos as $k => $v)
			{
				$Datos2=explode("~~",$v);
				$Actualizar = "UPDATE age_web.lotes set muestra_paralela='$Datos2[0]' where lote = '$Datos2[1]' ";
				mysqli_query($link, $Actualizar);
				echo $Actualizar."<br>";
			}
			//header("location:age_ing_muestra_paralela.php?Mostrar=S&SubProducto=".$SubProducto."&Mes=".$Mes."&Ano=".$Ano);
			break;
	}
?>	