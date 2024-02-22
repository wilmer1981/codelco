<?php
	include("../principal/conectar_principal.php");
	switch ($Proceso)
	{
		case "G":
			$Eliminar = "delete from sea_web.stock_programado ";
			$Eliminar.= " where fecha between '".$Ano."-".$Mes."-01' and '".$Ano."-".$Mes."-31'";
			mysqli_query($link, $Eliminar);
			$Datos = explode("~~",$Valores);
			foreach($Datos as $k => $v)
			{
				$Dia = substr($v,0,2);
				$Peso = substr($v,4);
				if ($Dia!="")
				{
					$Insertar =  "insert into sea_web.stock_programado (fecha, peso)";
					$Insertar.= " VALUES('".$Ano."-".$Mes."-".$Dia."','".$Peso."')";
					mysqli_query($link, $Insertar);
				}
			}
			header("location:sea_ing_stock_programado.php?Ano=".$Ano."&Mes=".$Mes);			
			break;
		case "E":
			$Eliminar = "delete from sea_web.stock_programado ";
			$Eliminar.= " where fecha between '".$Ano."-".$Mes."-01' and '".$Ano."-".$Mes."-31'";
			mysqli_query($link, $Eliminar);
			header("location:sea_ing_stock_programado.php?Ano=".$Ano."&Mes=".$Mes);
			break;
	}
?>