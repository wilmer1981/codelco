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

	if(isset($_POST["Producto"])){
		$Producto = $_POST["Producto"];
	}else {
		$Producto = "";
	}
	if(isset($_POST["Proveedor"])){
		$Proveedor = $_POST["Proveedor"];
	}else {
		$Proveedor = "";
	}

	if(isset($_POST["CodLeyes"])){
		$CodLeyes = $_POST["CodLeyes"];
	}else {
		$CodLeyes = "";
	}

	if(isset($_POST["Limite"])){
		$Limite = $_POST["Limite"];
	}else {
		$Limite = "";
	}
/*
echo "Proceso:".$Proceso;
echo "<br>Producto:".$Producto;
echo "<br>Proveedor:".$Proveedor;
echo "<br>CodLeyes:".$CodLeyes;
echo "<br>Leyes:".$Leyes;
echo "<br>Limite:".$Limite;
exit();


*/

	switch ($Proceso)
	{
		case "GL":
			if ($Producto == ""){
				$Producto="000";
			}
			if ($Proveedor==""){
				$Proveedor="000000000";
			}
			$sql = "SELECT * from limites where ";
			$sql.= " tipo_producto = '".$Producto."'";
			$sql.= " AND rut_proveedor = '".$Proveedor."'";
			$sql.= " AND cod_leyes = '".$Leyes."'";
			$result=mysqli_query($link, $sql);
			if ($row = mysqli_fetch_array($result))
			{
				echo "<script language='JavaScript'>alert('LEY YA EXISTE !!');window.history.back();</script>";
			}else{
				$Limite=str_replace(",",".",$Limite);
				$Insertar = "insert into limites";
				$Insertar.= "(tipo_producto, rut_proveedor, cod_leyes, limite)";
				$Insertar.= "values(";
				$Insertar.= "'".$Producto."',";
				$Insertar.= "'".$Proveedor."',";
				$Insertar.= "'".$Leyes."',";
				$Insertar.= $Limite.")";
				mysqli_query($link, $Insertar);
				echo "<script language='JavaScript'>";
				echo "window.opener.document.frmPrincipal.action='imp_ing_limites.php';";
				echo "window.opener.document.frmPrincipal.submit();";
				echo "window.close();";				
				echo "</script>";
			}
			break;
		case "ML":
			$Limite=str_replace(",",".",$Limite);
			$Actualizar = "UPDATE limites set ";
			$Actualizar.= " limite = ".$Limite;
			$Actualizar.= " where ";
			$Actualizar.= " tipo_producto = '".$Producto."'";
			if ($Proveedor == "")
				$Actualizar.= " and rut_proveedor = '000000000'";
			else	$Actualizar.= " and rut_proveedor = '".$Proveedor."'";
			$Actualizar.= " and cod_leyes = '".$Leyes."'";
			mysqli_query($link, $Actualizar);
			echo "<script language='JavaScript'>";
			echo "window.opener.document.frmPrincipal.action='imp_ing_limites.php';";
			echo "window.opener.document.frmPrincipal.submit();";
			echo "window.close();";				
			echo "</script>";
			break;
		case "EL":
			//echo "ELIMINAR Producto:".$Producto." Proveedor:".$Proveedor." Leyes:".$Leyes;
			//exit();
			$Eliminar = "DELETE from limites where ";
			$Eliminar.= " tipo_producto = '".$Producto."'";
			if ($Proveedor!=""){
				$Eliminar.= " and rut_proveedor = '".$Proveedor."'";
			}else{
				$Eliminar.= " and rut_proveedor = '000000000'";
			}
			$Eliminar.= " and cod_leyes = '".$Leyes."'";
			mysqli_query($link, $Eliminar);
			header("location:imp_ing_limites.php?Producto=".$Producto."&Proveedor=".$Proveedor);
			break;
	}
?>