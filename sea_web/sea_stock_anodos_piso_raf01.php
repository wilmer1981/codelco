<?php

include("../principal/conectar_sea_web.php");

  $dia = isset($_REQUEST["dia"])?$_REQUEST["dia"]:date("d");
  $mes = isset($_REQUEST["mes"])?$_REQUEST["mes"]:date("m");
  $ano = isset($_REQUEST["ano"])?$_REQUEST["ano"]:date("Y"); 
   $cmbproductos = isset($_REQUEST["cmbproductos"])?$_REQUEST["cmbproductos"]:"";
  $cmbsubproducto = isset($_REQUEST["cmbsubproducto"])?$_REQUEST["cmbsubproducto"]:"";
 $shornada = isset($_REQUEST["shornada"])?$_REQUEST["shornada"]:"";
  $unidades = isset($_REQUEST["unidades"])?$_REQUEST["unidades"]:"";
   $peso = isset($_REQUEST["peso"])?$_REQUEST["peso"]:"";
//*******************************************************************************//
	//Valida que no se realicen cambios de movimientos, en la fecha ingresada.
	
	$valida_fecha_movimiento = $ano."-".$mes."-".$dia;
	include("sea_valida_mes.php");
//*******************************************************************************//

$fecha = $ano."-".$mes."-".$dia;
//echo $shornada;
$cmbhornada = $shornada;
//echo $cmbhornada;
/****** GUARDAR ANODOS *******/
if ($Proceso == 'G' AND substr($cmbproductos,0,2) != 16 AND substr($cmbproductos,0,2) != 18 AND substr($cmbproductos,0,2) != 48)
{
	    $consulta = "SELECT flujo FROM relacion_prod_flujo_nodo WHERE cod_proceso = 4 AND cod_producto = 17";
	    $consulta = $consulta." AND cod_subproducto = ".$cmbproductos;
	    include("../principal/conectar_principal.php");
	    $rs1 = mysqli_query($link,$consulta);

	    if ($row1 = mysqli_fetch_array($rs1))
		   $flujo = $row1["flujo"];
	    else 
		   $flujo = 0;

	  //inserto en stock piso raf
		$Insertar = "INSERT INTO stock_piso_raf (fecha,cod_producto,cod_subproducto,flujo,hornada,unidades,peso)";
		$Insertar.= " VALUES('$fecha',17,$cmbproductos,$flujo,$cmbhornada,$unidades,$peso)";
		include("../principal/conectar_sea_web.php");
		mysqli_query($Insertar);

    $valores = "Mensaje=1"."&Proceso=R"."&cmbproductos=".$cmbproductos."&cmbhornada=".$cmbhornada."&dia=".$dia."&mes=".$mes."&ano=".$ano;  

    header("Location:sea_stock_anodos_piso_raf.php?".$valores); 
}


/****** GUARDAR BLISTER *******/

if ($Proceso == 'G' AND substr($cmbproductos,0,2) == 16)
{
		$apellido = substr($cmbsubproducto,2,2);
					
	    $consulta = "SELECT flujo FROM relacion_prod_flujo_nodo WHERE cod_proceso = 4 AND cod_producto = 16";
	    $consulta = $consulta." AND cod_subproducto = ".$apellido;
		
	    include("../principal/conectar_principal.php");
	    $rs1 = mysqli_query($link,$consulta);

	    if ($row1 = mysqli_fetch_array($rs1))
		   $flujo = $row1["flujo"];
	    else 
		   $flujo = 0;

	  //inserto en stock piso raf
		$Insertar = "INSERT INTO stock_piso_raf";
		$Insertar = "$Insertar (fecha,cod_producto,cod_subproducto,flujo,hornada,unidades,peso)";
		$Insertar = "$Insertar VALUES('$fecha',16,$apellido,$flujo,$cmbhornada,$unidades,$peso)";
		include("../principal/conectar_sea_web.php");
		mysqli_query($Insertar);

    $valores = "Mensaje=1"."&Proceso=R"."&cmbproductos=".$cmbproductos."&cmbsubproducto=".$cmbsubproducto."&cmbhornada=".$cmbhornada."&dia=".$dia."&mes=".$mes."&ano=".$ano;  

    header("Location:sea_stock_anodos_piso_raf.php?".$valores); 
}

/****** GUARDAR CATODOS *******/
if ($Proceso == 'G' AND substr($cmbproductos,0,2) == 18)
{
		$apellido = substr($cmbsubproducto,2,2);
					
	    $consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 4 AND cod_producto = 18";
	    $consulta = $consulta." AND cod_subproducto = ".$apellido;
		
	    include("../principal/conectar_principal.php");
		
	    $rs1 = mysqli_query($link,$consulta);

	    if ($row1 = mysqli_fetch_array($rs1))
		   $flujo = $row1["flujo"];
	    else 
		   $flujo = 0;

	  //inserto en stock piso raf
		$Insertar = "INSERT INTO stock_piso_raf";
		$Insertar = "$Insertar (fecha,cod_producto,cod_subproducto,flujo,hornada,unidades,peso)";
		$Insertar = " $Insertar VALUES('$fecha',18,$apellido,$flujo,$cmbhornada,$unidades,$peso)";
		
		include("../principal/conectar_sea_web.php");
		mysqli_query($link,$Insertar);

    $valores = "Mensaje=1"."&Proceso=R"."&cmbproductos=".$cmbproductos."&cmbsubproducto=".$cmbsubproducto."&cmbhornada=".$cmbhornada."&dia=".$dia."&mes=".$mes."&ano=".$ano;  

    header("Location:sea_stock_anodos_piso_raf.php?".$valores); 
}

/****** GUARDAR LAMINAS *******/
if ($Proceso == 'G' AND substr($cmbproductos,0,2) == 48)
{
		$apellido = substr($cmbsubproducto,2,2);
					
	    $consulta = "SELECT flujo FROM relacion_prod_flujo_nodo WHERE cod_proceso = 4 AND cod_producto = 48";
	    $consulta = $consulta." AND cod_subproducto = ".$apellido;
	    include("../principal/conectar_principal.php");
	    $rs1 = mysqli_query($link,$consulta);

	    if ($row1 = mysqli_fetch_array($rs1))
		   $flujo = $row1["flujo"];
	    else 
		   $flujo = 0;

	  //inserto en stock piso raf
		$Insertar = "INSERT INTO stock_piso_raf";
		$Insertar = "$Insertar (fecha,cod_producto,cod_subproducto,flujo,hornada,unidades,peso)";
		$Insertar = "$Insertar VALUES('$fecha',48,$apellido,$flujo,$cmbhornada,$unidades,$peso)";
		include("../principal/conectar_sea_web.php");
		mysqli_query($link,$Insertar);

    $valores = "Mensaje=1"."&Proceso=R"."&cmbproductos=".$cmbproductos."&cmbsubproducto=".$cmbsubproducto."&cmbhornada=".$cmbhornada."&dia=".$dia."&mes=".$mes."&ano=".$ano;  

    header("Location:sea_stock_anodos_piso_raf.php?".$valores); 
}


/****** ELIMINAR ANODOS *******/
if ($Proceso == 'E' AND substr($cmbproductos,0,2) != 16 AND substr($cmbproductos,0,2) != 18 AND substr($cmbproductos,0,2) != 48)
{
	$Eliminar = "DELETE FROM stock_piso_raf  WHERE fecha = '$fecha' AND cod_producto = 17 AND cod_subproducto = $cmbproductos AND hornada= $cmbhornada";
	mysqli_query($Eliminar);
						

    $valores = "Proceso=R"."&cmbproductos=".$cmbproductos."&cmbhornada=".$cmbhornada."&dia=".$dia."&mes=".$mes."&ano=".$ano;  

    header("Location:sea_stock_anodos_piso_raf.php?".$valores); 
}

/****** ELIMINAR BLISTER *******/
if ($Proceso == 'E' AND substr($cmbproductos,0,2) == 16)
{	
	$apellido = substr($cmbsubproducto,2,2);
    $Eliminar = "DELETE FROM stock_piso_raf  WHERE fecha = '$fecha' AND cod_producto = 16 AND cod_subproducto = $apellido AND hornada= $cmbhornada";
	mysqli_query($link,$Eliminar);
					

    $valores = "Proceso=R"."&cmbproductos=".$cmbproductos."&cmbsubproducto=".$cmbsubproducto."&cmbhornada=".$cmbhornada."&dia=".$dia."&mes=".$mes."&ano=".$ano;  

    header("Location:sea_stock_anodos_piso_raf.php?".$valores); 
}

/****** ELIMINAR CATODOS *******/
if ($Proceso == 'E' AND substr($cmbproductos,0,2) == 18)
{	
	$apellido = substr($cmbsubproducto,2,2);
    $Eliminar = "DELETE FROM stock_piso_raf  WHERE fecha = '$fecha' AND cod_producto = 18 AND cod_subproducto = $apellido AND hornada= $cmbhornada";
	mysqli_query($link,$Eliminar);
					

    $valores = "Proceso=R"."&cmbproductos=".$cmbproductos."&cmbsubproducto=".$cmbsubproducto."&cmbhornada=".$cmbhornada."&dia=".$dia."&mes=".$mes."&ano=".$ano;  

    header("Location:sea_stock_anodos_piso_raf.php?".$valores); 
}

/****** ELIMINAR LAMINAS *******/
if ($Proceso == 'E' AND substr($cmbproductos,0,2) == 48)
{	
	$apellido = substr($cmbsubproducto,2,2);
    $Eliminar = "DELETE FROM stock_piso_raf  WHERE fecha = '$fecha' AND cod_producto = 48 AND cod_subproducto = $apellido AND hornada= $cmbhornada";
	mysqli_query($link,$Eliminar);
					

    $valores = "Proceso=R"."&cmbproductos=".$cmbproductos."&cmbsubproducto=".$cmbsubproducto."&cmbhornada=".$cmbhornada."&dia=".$dia."&mes=".$mes."&ano=".$ano;  

    header("Location:sea_stock_anodos_piso_raf.php?".$valores); 
}
?>