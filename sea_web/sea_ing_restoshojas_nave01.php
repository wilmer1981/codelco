<?php
	include("../principal/conectar_sea_web.php");

	if(isset($_REQUEST["proceso"])) {
		$proceso = $_REQUEST["proceso"];
	}else{
		$proceso =  "";
	}

	if(isset($_REQUEST["dia_b"])) {
		$dia_b = $_REQUEST["dia_b"];
	}else{
		$dia_b = "";
	}
	if(isset($_REQUEST["mes_b"])) {
		$mes_b = $_REQUEST["mes_b"];
	}else{
		$mes_b =  "";
	}
	if(isset($_REQUEST["ano_b"])) {
		$ano_b = $_REQUEST["ano_b"];
	}else{
		$ano_b =  "";
	}
	if(isset($_REQUEST["marcacheckbox"])) {
		$marcacheckbox = $_REQUEST["marcacheckbox"];
	}else{
		$marcacheckbox =  "";
	}
	if(isset($_REQUEST["hornada"])) {
		$hornada = $_REQUEST["hornada"];
	}else{
		$hornada = "";
	}
	if(isset($_REQUEST["subproducto"])) {
		$subproducto = $_REQUEST["subproducto"];
	}else{
		$subproducto = "";
	}
	if(isset($_REQUEST["Hora"])) {
		$Hora = $_REQUEST["Hora"];
	}else{
		$Hora = "";
	}
	if(isset($_REQUEST["Minutos"])) {
		$Minutos = $_REQUEST["Minutos"];
	}else{
		$Minutos = "";
	}
	if(isset($_REQUEST["cmblado"])) {
		$cmblado = $_REQUEST["cmblado"];
	}else{
		$cmblado = "";
	}
	if(isset($_REQUEST["cmbgrupo_d"])) {
		$cmbgrupo_d = $_REQUEST["cmbgrupo_d"];
	}else{
		$cmbgrupo_d = "";
	}
	if(isset($_REQUEST["unidad_beneficio"])) {
		$unidad_beneficio = $_REQUEST["unidad_beneficio"];
	}else{
		$unidad_beneficio = "";
	}
	if(isset($_REQUEST["peso_beneficio"])) {
		$peso_beneficio = $_REQUEST["peso_beneficio"];
	}else{
		$peso_beneficio = "";
	}

//*******************************************************************************//
	//Valida que no se realicen cambios de movimientos, en la fecha ingresada.
	
	$valida_fecha_movimiento = $ano_b."-".$mes_b."-".$dia_b;
	include("sea_valida_mes.php");
//*******************************************************************************//

//*******************************************************************************//
	//Valida que no se realicen cambios de movimientos, en la fecha ingresada.
	
	if ($marcacheckbox == "S")
	{
		$valida_fecha_movimiento = $ano2."-".$mes2."-".$dia2;
		include("sea_valida_mes.php");
	}
//*******************************************************************************//

/***********************************GUARDAR*******************/

	if ($proceso == "G") // GUARDAR
	{
		$fecha_b = $ano_b."-".$mes_b."-".$dia_b;
	    $FechaHora=$fecha_b." ".$Hora.":".$Minutos;
		if ($marcacheckbox == "S")
			$fecha2 = $ano2.'-'.$mes2.'-'.$dia2;
		else
			$fecha2 = '0000-00-00';
		

        /************ consulto flujo *********/ 
					
		$consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 2 AND cod_producto = 19";
		$consulta = $consulta." AND cod_subproducto = '".$subproducto."' ";
		
		$rs1 = mysqli_query($link, $consulta);
		if ($row1 = mysqli_fetch_array($rs1))
			$flujo = $row1["flujo"];
		else 
			$flujo = 0;
			
	    /********** inserto en movimientos **********/

		if ($marcacheckbox == "S")			  
		{
			  $Insertar = "INSERT INTO sea_web.movimientos";
		  	  $Insertar = "$Insertar (tipo_movimiento,cod_producto,cod_subproducto,flujo,hornada,numero_recarga,fecha_movimiento,campo1,campo2,unidades,fecha_benef,peso,hora)";
			  $Insertar = "$Insertar VALUES (2,19,'".$subproducto."', '".$flujo."', '".$hornada."',0,'".$fecha2."','".$cmblado."', '".$cmbgrupo_d."', '".$unidad_beneficio."','".$fecha_b."', '".$peso_beneficio."','".$FechaHora."')";
			  mysqli_query($link, $Insertar);
		}
		else
		{
			  $Insertar = "INSERT INTO sea_web.movimientos";
		  	  $Insertar = "$Insertar (tipo_movimiento,cod_producto,cod_subproducto,flujo,hornada,numero_recarga,fecha_movimiento,campo1,campo2,unidades,fecha_benef,peso,hora)";
			  $Insertar = "$Insertar VALUES (2,19,'".$subproducto."', '".$flujo."', '".$hornada."',0,'".$fecha_b."','".$cmblado."', '".$cmbgrupo_d."', '".$unidad_beneficio."','".$fecha2."', '".$peso_beneficio."','".$FechaHora."')";
			  mysqli_query($link, $Insertar);			
		}

	if(strlen($hornada) == 12)
	    $hornada = substr($hornada,6,6);
	else
	    $hornada = substr($hornada,6,4);
	
	$valores = "mostrar=S"."&hornada_m=".$hornada.'&ano_b='.$ano_b.'&mes_b='.$mes_b.'&dia_b='.$dia_b.'&cmblado='.$cmblado.'&cmbgrupo_d='.$cmbgrupo_d;  
    header("Location:sea_ing_restoshojas_nave.php?".$valores); 

	}		
	include("../principal/cerrar_sea_web.php");
?>