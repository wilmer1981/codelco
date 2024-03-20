<?php
	include("../principal/conectar_pac_web.php");

	$Proceso      = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Valores      = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";

	$CmbDia       = isset($_REQUEST["CmbDia"])?$_REQUEST["CmbDia"]:"";
	$CmbMes       = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:"";
	$CmbAno       = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:"";

	$CmbEK      = isset($_REQUEST["CmbEK"])?$_REQUEST["CmbEK"]:"";
	$Leyes      = isset($_REQUEST["Leyes"])?$_REQUEST["Leyes"]:"";
	$Valor      = isset($_REQUEST["Valor"])?$_REQUEST["Valor"]:"";
	$Unidad      = isset($_REQUEST["Unidad"])?$_REQUEST["Unidad"]:"";

	$Fecha=$CmbAno."-".$CmbMes."-".$CmbDia;
	switch ($Proceso)
	{
		case "N":
			$sql = "select * from pac_web.leyes_por_estanques where ";
			$sql.= " cod_estanque = '".$CmbEK."'";
			$sql.= " and fecha= '".$Fecha."'";
			$sql.= " and cod_leyes = '".$Leyes."'";
			$result=mysqli_query($link, $sql);
			if ($row = mysqli_fetch_array($result))
			{
				$Mensaje="Ley Ya Fue Ingresada";		
				header("location:pac_ing_leyes_esp02.php?Mensaje=".$Mensaje."&Proceso=".$Proceso);
				/*echo "<script language='JavaScript'>alert('LEY YA EXISTE !!');window.history.back();</script>";*/
			}
			else
			{
				$Valor=str_replace(",",".",$Valor);
				$Insertar = "insert into pac_web.leyes_por_estanques";
				$Insertar.= "(cod_estanque,fecha,cod_leyes,valor,cod_unidad)";
				$Insertar.= "values('$CmbEK','$Fecha','$Leyes','$Valor','$Unidad')";
				mysqli_query($link, $Insertar);
				echo "<script language='JavaScript'>";
				echo "window.opener.document.FrmIngLeyes.action='pac_ing_leyes_esp.php';";
				echo "window.opener.document.FrmIngLeyes.submit();";
				echo "window.close();";				
				echo "</script>";
			}
			break;
		case "M":
			$Datos=explode('/',$Valores);
			$Correlativo=$Datos[0];
			$Valor=str_replace(",",".",$Valor);
			$Actualizar = "UPDATE pac_web.leyes_por_estanques set ";
			$Actualizar.= " cod_estanque = '".$CmbEK."',";
			$Actualizar.= " fecha = '".$Fecha."',";
			$Actualizar.= " cod_leyes = '".$Leyes."',";
			$Actualizar.= " valor = ".$Valor.",";
			$Actualizar.= " cod_unidad = '".$Unidad."' ";
			$Actualizar.= " where correlativo = '".$Correlativo."'";
			mysqli_query($link, $Actualizar);
			echo "<script language='JavaScript'>";
			echo "window.opener.document.FrmIngLeyes.action='pac_ing_leyes_esp.php';";
			echo "window.opener.document.FrmIngLeyes.submit();";
			echo "window.close();";				
			echo "</script>";
			break;
		case "E":
			$Datos=explode('/',$Valores);
			foreach($Datos as $Clave => $Valor)
			{
				$Correlativo=$Valor;
				$Eliminar = "delete from pac_web.leyes_por_estanques where ";
				$Eliminar.= " correlativo = '".$Correlativo."'";			
				mysqli_query($link, $Eliminar);
			}
			header("location:pac_ing_leyes_esp.php");
			break;
	}
?>