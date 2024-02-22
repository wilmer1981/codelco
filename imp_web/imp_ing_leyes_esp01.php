<?php
	include("../principal/conectar_imp_web.php");

	if(isset($_REQUEST["Proceso"])){
		$Proceso = $_REQUEST["Proceso"];
	}else {
		$Proceso = "";
	}

	if(isset($_REQUEST["Leyes"])){
		$Leyes = $_REQUEST["Leyes"];
	}else {
		$Leyes = "";
	}
	if(isset($_REQUEST["Valor"])){
		$Valor = $_REQUEST["Valor"];
	}else {
		$Valor = "";
	}
	if(isset($_REQUEST["FechaProceso"])){
		$FechaProceso = $_REQUEST["FechaProceso"];
	}else {
		$FechaProceso = "";
	}
	if(isset($_REQUEST["Unidad"])){
		$Unidad = $_REQUEST["Unidad"];
	}else {
		$Unidad = "";
	}
	if(isset($_REQUEST["Producto"])){
		$Producto = $_REQUEST["Producto"];
	}else {
		$Producto = "";
	}
	if(isset($_REQUEST["Proveedor"])){
		$Proveedor = $_REQUEST["Proveedor"];
	}else {
		$Proveedor = "";
	}
	if(isset($_REQUEST["ID"])){
		$ID= $_REQUEST["ID"];
	}else {
		$ID = "";
	}
	if(isset($_REQUEST["FechaMuestra"])){
		$FechaMuestra = $_REQUEST["FechaMuestra"];
	}else {
		$FechaMuestra = "";
	}


	
	switch ($Proceso)
	{
		case "REC":
			header("location:imp_ing_leyes_esp.php");
			break;
		case "GL":
			$sql = "SELECT * from leyes_especiales where ";
			$sql.= " id_muestra = '".$ID."'";
			$sql.= " and tipo_producto = '".$Producto."'";
			$sql.= " and rut_proveedor = '".$Proveedor."'";
			$sql.= " and cod_leyes = '".$Leyes."'";
			$result=mysqli_query($link, $sql);
			if ($row = mysqli_fetch_array($result))
			{
				echo "<script language='JavaScript'>alert('LEY YA EXISTE !!');window.history.back();</script>";
			}
			else
			{
				$Valor=str_replace(",",".",$Valor);
				$Insertar = "insert into leyes_especiales";
				$Insertar.= "(id_muestra,tipo_producto, rut_proveedor, cod_leyes, fecha, valor,cod_unidad)";
				$Insertar.= "values(";
				$Insertar.= "'".$ID."',";
				$Insertar.= "'".$Producto."',";
				$Insertar.= "'".$Proveedor."',";
				$Insertar.= "'".$Leyes."',";
				$Insertar.= "'".$FechaProceso."',";
				$Insertar.= $Valor.",";
				$Insertar.= "'".$Unidad."')";				
				mysqli_query($link, $Insertar);
				echo "<script language='JavaScript'>";
				echo "window.opener.document.frmPrincipal.action='imp_ing_leyes_esp.php?Carga=S';";
				echo "window.opener.document.frmPrincipal.submit();";
				echo "window.close();";				
				echo "</script>";
			}
			break;
		case "ML":
			$Valor=str_replace(",",".",$Valor);
			$Actualizar = "UPDATE leyes_especiales set ";
			$Actualizar.= " valor = ".$Valor.",";
			$Actualizar.= " cod_unidad = '".$Unidad."'";
			$Actualizar.= " where ";
			$Actualizar.= " id_muestra = '".$ID."'";
			$Actualizar.= " and tipo_producto = '".$Producto."'";
			$Actualizar.= " and rut_proveedor = '".$Proveedor."'";
			$Actualizar.= " and cod_leyes = '".$Leyes."'";
			mysqli_query($link, $Actualizar);
			echo "<script language='JavaScript'>";
			echo "window.opener.document.frmPrincipal.action='imp_ing_leyes_esp.php?Carga=S';";
			echo "window.opener.document.frmPrincipal.submit();";
			echo "window.close();";				
			echo "</script>";
			break;
		case "EL":
			$Ley     = $_REQUEST["Ley"];
			$Producto = $_REQUEST["Productos"];
			/*
			echo "<br>ID:".$ID;
			echo "<br>Producto:".$Producto;
			echo "<br>Proveedor:".$Proveedor;
			echo "<br>Leyes:".$Ley;
			exit();
			*/
			$Eliminar = "delete from leyes_especiales where ";
			$Eliminar.= " id_muestra = '".$ID."'";			
			$Eliminar.= " and tipo_producto = '".$Producto."'";
			$Eliminar.= " and rut_proveedor = '".$Proveedor."'";
			$Eliminar.= " and cod_leyes = '".$Ley."'";
			mysqli_query($link, $Eliminar);
			header("location:imp_ing_leyes_esp.php?Carga=S&ID=".$ID."&Productos=".$Producto."&Proveedor=".$Proveedor);
			break;
	}
?>