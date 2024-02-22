<?php	
	include("../principal/conectar_principal.php");

	if(isset($_REQUEST["Proceso"])){
		$Proceso = $_REQUEST["Proceso"];
	}else{
		$Proceso = "";
	}
	if(isset($_REQUEST["Valores"])){
		$Valores = $_REQUEST["Valores"];
	}else{
		$Valores = "";
	}
	if(isset($_REQUEST["TipoProducto"])) {
		$TipoProducto = $_REQUEST["TipoProducto"];
	}else{
		$TipoProducto =  "";
	}
	if(isset($_REQUEST["TipoMovimiento"])) {
		$TipoMovimiento = $_REQUEST["TipoMovimiento"];
	}else{
		$TipoMovimiento =  "";
	}

	$Datos = explode("-",$TipoProducto);
	//$Producto = $Datos[0];
	//$SubProducto = $Datos[1];
	if(isset($Datos[0])){
		$Producto = $Datos[0];
	}else{
		$Producto = 0;
	}
	if(isset($Datos[1])){
		$SubProducto = $Datos[1];
	}else{
		$SubProducto = 0;
	}
	switch ($Proceso)
	{
		case "GP":	
			$Eliminar = "DELETE from sea_web.limites ";
			$Eliminar.= " where cod_producto = '".$Producto."'";
			$Eliminar.= " and cod_subproducto = '".$SubProducto."'"; 
			mysqli_query($link, $Eliminar);
			$Datos = explode("//",$Valores);
			//foreach($Datos as $k => $v)
			foreach ($Datos as $k=>$v)
			{    
				$Datos2 = explode("~~",$v);
				$CodLey = $Datos2[0];
				$Signo = $Datos2[1];
				$Valor = str_replace(",",".",$Datos2[2]);
				$Insertar = "INSERT INTO sea_web.limites (cod_producto, cod_subproducto, cod_leyes, signo, limite) ";
				$Insertar.= " values('".$Producto."','".$SubProducto."','".$CodLey."','".$Signo."','".$Valor."')";
				mysqli_query($link, $Insertar);	
			}
			break;
		case "EP":
			$Eliminar = "DELETE from sea_web.limites ";
			$Eliminar.= " where cod_producto = '".$Producto."'";
			$Eliminar.= " and cod_subproducto = '".$SubProducto."'"; 
			mysqli_query($link, $Eliminar);
			break;
	}
	header("location:sea_con_limites.php?TipoProducto=".$TipoProducto."&TipoMovimiento=".$TipoMovimiento);
?>