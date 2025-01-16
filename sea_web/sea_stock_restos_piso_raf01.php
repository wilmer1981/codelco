<?php
include("../principal/conectar_sea_web.php");
  $Proceso = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
  $dia = isset($_REQUEST["dia"])?$_REQUEST["dia"]:date("d");
  $mes = isset($_REQUEST["mes"])?$_REQUEST["mes"]:date("m");
  $ano = isset($_REQUEST["ano"])?$_REQUEST["ano"]:date("Y"); 
  $dia2 = isset($_REQUEST["dia2"])?$_REQUEST["dia2"]:date("d");
  $mes2 = isset($_REQUEST["mes2"])?$_REQUEST["mes2"]:date("m");
  $ano2 = isset($_REQUEST["ano2"])?$_REQUEST["ano2"]:date("Y"); 
  $cmbgrupo   = isset($_REQUEST["cmbgrupo"])?$_REQUEST["cmbgrupo"]:"";
  $subproducto = isset($_REQUEST["subproducto"])?$_REQUEST["subproducto"]:"";
  $hornada = isset($_REQUEST["hornada"])?$_REQUEST["hornada"]:"";
  $unidades = isset($_REQUEST["unidades"])?$_REQUEST["unidades"]:"";
  $unidades_a = isset($_REQUEST["unidades_a"])?$_REQUEST["unidades_a"]:"";
  $peso = isset($_REQUEST["peso"])?$_REQUEST["peso"]:"";
  $peso_t = isset($_REQUEST["peso_t"])?$_REQUEST["peso_t"]:"";
  $peso_a = isset($_REQUEST["peso_a"])?$_REQUEST["peso_a"]:"";

//*******************************************************************************//
	//Valida que no se realicen cambios de movimientos, en la fecha ingresada.
	
	$valida_fecha_movimiento = $ano2."-".$mes2."-".$dia2;
	include("sea_valida_mes.php");
//*******************************************************************************//

$fecha = $ano2."-".$mes2."-".$dia2;
$fecha2 = $ano."-".$mes."-".$dia;
/******** GUARDAR ***********/
if ($Proceso == 'G')
{
	$porcentaje = ($peso * 100)/$peso_t;

	foreach($a as $clave=>$valor)
	{

	    $consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 4 AND cod_producto = 19";
	    $consulta = $consulta." AND cod_subproducto = ".$subproducto[$clave];
	    $rs1 = mysqli_query($link,$consulta);

	    if ($row1 = mysqli_fetch_array($rs1))
		   $flujo = $row1["flujo"];
	    else 
		   $flujo = 0;

        $unidades = round(($unidades_a[$clave] * $porcentaje)/100);
        $peso = round(($peso_a[$clave] * $porcentaje)/100);

		$grupo = substr($cmbgrupo,11,2);
		$Insertar = "INSERT INTO sea_web.stock_piso_raf";
		$Insertar = $Insertar." (fecha,cod_producto,cod_subproducto,flujo,hornada,grupo,unidades,peso,fecha_trasp)";
		$Insertar = $Insertar." VALUES('".$fecha."',19,".$subproducto[$clave].",".$flujo.",".$hornada[$clave].",".$grupo.",".$unidades.",".$peso.",'".$fecha2."')";
		//echo $Insertar."<br>";
		mysqli_query($link,$Insertar);
	}			
    $valores = "Mensaje=1"."&Proceso=R"."&cmbgrupo=".$cmbgrupo."&dia2=".$dia2."&mes2=".$mes2."&ano2=".$ano2;  
	$valores = $valores."&ano=".$ano."&mes=".$mes."&dia=".$dia;

    header("Location:sea_stock_restos_piso_raf.php?".$valores); 

}

/******** MODIFICAR ***********/
if ($Proceso == 'M')
{

	foreach($a as $clave=>$valor)
	{
        $peso = $peso_grupo;
		//calculo las unidades segun el porcentaje
		//$unidades = ($valor_u * $unidades)/100; 
		$Actualizar1 = "UPDATE sea_web.stock_piso_raf SET unidades = $unidades WHERE cod_producto = 19 AND cod_subproducto =  $subproducto[$clave] 
		                 AND fecha='$fecha' AND hornada= $hornada[$clave]";
		 mysqli_query($link,$Actualizar1);

		//calculo el peso segun el porcentaje
		$peso = ($valor_p * $peso)/100; 

		$Actualizar2 = "UPDATE sea_web.stock_piso_raf set peso = $peso WHERE cod_producto = 19 AND cod_subproducto =  $subproducto[$clave] 
		                 AND fecha='$fecha' AND hornada= $hornada[$clave]";
		mysqli_query($link,$Actualizar2);
	}					
 
    $valores = "Mensaje=2"."&Proceso=R"."&cmbgrupo=".$cmbgrupo."&dia2=".$dia2."&mes2=".$mes2."&ano2=".$ano2;  
	$valores = $valores."&ano=".$ano."&mes=".$mes."&dia=".$dia;

    header("Location:sea_stock_restos_piso_raf.php?".$valores); 


}

/******** ELIMINAR ***********/
if ($Proceso == 'E')
{

	foreach($a as $clave=>$valor)
	{

		$Eliminar = "DELETE FROM sea_web.stock_piso_raf WHERE cod_producto = 19 AND cod_subproducto =  $subproducto[$clave] 
		             AND fecha='$fecha' AND hornada= $hornada[$clave]";
		//echo $Eliminar;	
		mysqli_query($link,$Eliminar);
	}

    $valores = "Proceso=R"."&cmbgrupo=".$cmbgrupo."&dia2=".$dia2."&mes2=".$mes2."&ano2=".$ano2;  
	$valores = $valores."&ano=".$ano."&mes=".$mes."&dia=".$dia;

    header("Location:sea_stock_restos_piso_raf.php?".$valores); 

}	

?>