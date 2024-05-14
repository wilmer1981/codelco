<?php

	include("../principal/conectar_principal.php");
	$Proceso      = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Valores      = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";

	switch ($Proceso)
	{	
		case "G":
			$Datos=explode("//",$Valores);
			foreach($Datos as $k => $v)
			{
				$Datos2=explode("~~",$v);
				$Actualizar = "UPDATE age_web.lotes set muestra_paralela='$Datos2[0]' where lote = '$Datos2[1]' ";
				mysqli_query($link, $Actualizar);
				//echo $Actualizar."<br>";
			}
			header("location:age_ing_muestra_paralela.php?Mostrar=S&SubProducto=".$SubProducto."&Mes=".$Mes."&Ano=".$Ano);
			break;
	}
?>	