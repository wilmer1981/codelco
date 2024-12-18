<?php 
include("../principal/conectar_principal.php");

$CookieRut       = $_COOKIE["CookieRut"];
$CmbProductos    = isset($_REQUEST["CmbProductos"])?$_REQUEST["CmbProductos"]:"";
$CmbSubProducto  = isset($_REQUEST["CmbSubProducto"])?$_REQUEST["CmbSubProducto"]:"";
$Leyes           = isset($_REQUEST["Leyes"])?$_REQUEST["Leyes"]:"";

	if($CmbProductos=='T'){
		mysqli_query($link, "delete from cal_web.exclusion_leyes_electroplasma");
	}else{
		if($CmbSubProducto=='T'){	
			mysqli_query($link, "delete from cal_web.exclusion_leyes_electroplasma where cod_producto='".$CmbProductos."'");
		}else{
			mysqli_query($link, "delete from cal_web.exclusion_leyes_electroplasma where cod_producto='".$CmbProductos."' and  cod_subproducto='".$CmbSubProducto."'");
		}  
	}
	$Consulta="select cod_producto,descripcion from proyecto_modernizacion.productos  ";
	if($CmbProductos!='T')
		$Consulta.=" where cod_producto='".$CmbProductos."'  ";	 
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Fila=mysqli_fetch_array($Respuesta))
	{
		//echo "PRODUCTOS";
		$Consulta2="select cod_subproducto,descripcion from proyecto_modernizacion.subproducto where cod_producto = '".$Fila["cod_producto"]."'"; 
		if($CmbSubProducto!='T')
			$Consulta2.=" and cod_subproducto='".$CmbSubProducto."'  ";
		//echo "SUB PRODUCTOS ".$Consulta2;
		$Respuesta2 = mysqli_query($link, $Consulta2);
		while ($Fila2=mysqli_fetch_array($Respuesta2))
		{//echo "SUB PRODUCTOS";		
			$CadenaValor=explode(';',$Leyes);
			foreach($CadenaValor as $clave => $Codigo)
			{
				if($Codigo!='')
				{
				$Insertar="insert into cal_web.exclusion_leyes_electroplasma(cod_leyes,cod_producto,cod_subproducto,fecha_registro,operador)";
				$Insertar.=" values('".$Codigo."','".$Fila["cod_producto"]."','".$Fila2["cod_subproducto"]."','".date('Y-m-d H:i:s')."','".$CookieRut."')";
				mysqli_query($link, $Insertar);
			//	echo $Insertar."<br>";
				}
			}
		}
	}
header("location:cal_mantenedor_exclusion_leyes_producto.php?CmbSubProducto=".$CmbSubProducto."&CmbProductos=".$CmbProductos);
	