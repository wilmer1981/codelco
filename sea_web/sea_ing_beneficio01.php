<?php  include ("funciones.php");
	include("../principal/conectar_sea_web.php");

	if(isset($_REQUEST["proceso"])) {
		$proceso = $_REQUEST["proceso"];
	}else{
		$proceso = "";
	}
	if(isset($_REQUEST["cmbhornada"])) {
		$cmbhornada = $_REQUEST["cmbhornada"];
	}else{
		$cmbhornada = "";
	}
	if(isset($_REQUEST["cmbproducto"])) {
		$cmbproducto = $_REQUEST["cmbproducto"];
	}else{
		$cmbproducto = "";
	}
	if(isset($_REQUEST["cmbtipo"])) {
		$cmbtipo = $_REQUEST["cmbtipo"];
	}else{
		$cmbtipo = "";
	}
	if(isset($_REQUEST["dia"])) {
		$dia = $_REQUEST["dia"];
	}else{
		$dia = "";
	}
	if(isset($_REQUEST["mes"])) {
		$mes = $_REQUEST["mes"];
	}else{
		$mes =  "";
	}
	if(isset($_REQUEST["ano"])) {
		$ano = $_REQUEST["ano"];
	}else{
		$ano =  "";
	}

	if(isset($_REQUEST["txtunidstock"])) {
		$txtunidstock = $_REQUEST["txtunidstock"];
	}else{
		$txtunidstock =  "";
	}
	if(isset($_REQUEST["txtunidbenef"])) {
		$txtunidbenef = $_REQUEST["txtunidbenef"];
	}else{
		$txtunidbenef =  "";
	}
	if(isset($_REQUEST["txtpesobenef"])) {
		$txtpesobenef = $_REQUEST["txtpesobenef"];
	}else{
		$txtpesobenef =  "";
	}
		
	if(isset($_REQUEST["unid_rech"])) {
		$unid_rech = $_REQUEST["unid_rech"];
	}else{
		$unid_rech =  "";
	}
	if(isset($_REQUEST["peso_rech"])) {
		$peso_rech = $_REQUEST["peso_rech"];
	}else{
		$peso_rech =  "";
	}
	if(isset($_REQUEST["peso_benef"])) {
		$peso_benef = $_REQUEST["peso_benef"];
	}else{
		$peso_benef =  "";
	}
	if(isset($_REQUEST["unidad_benef"])) {
		$unidad_benef = $_REQUEST["unidad_benef"];
	}else{
		$unidad_benef =  "";
	}

	if(isset($_REQUEST["Hora"])) {
		$Hora = $_REQUEST["Hora"];
	}else{
		$Hora = date("G");
	}
	if(isset($_REQUEST["Minutos"])) {
		$Minutos = $_REQUEST["Minutos"];
	}else{
		$Minutos = date("i");
	}

	if(isset($_REQUEST["marcacheckbox"])) {
		$marcacheckbox = $_REQUEST["marcacheckbox"];
	}else{
		$marcacheckbox = "";
	}


	if ($proceso == "B")
	{
		//Busca las Unidades Disponibles.
		echo "INGRESOOOOO:::";
		$stock_actual = StockActual($cmbhornada,17,$cmbproducto,$link);
		$stock_rechazo = 0;//StockRechazo($cmbhornada,17,$cmbproducto);
		$peso_faltante = PesoFaltante(17,$cmbproducto,$cmbhornada,$link);
		$unidad_raf = 0;
		$peso_raf = 0;		
		$fecha = $ano."-".$mes."-".$dia;
		
		//Busca el Peso Promedio de la Hornada hasta el dia.
		$consulta = "SELECT SUM(peso_unidades) AS peso_recep , SUM(unidades) AS unidad_recep";
		$consulta = $consulta." FROM sea_web.hornadas WHERE cod_producto = 17 AND cod_subproducto = ".$cmbproducto;
		$consulta = $consulta." AND hornada_ventana = ".$cmbhornada;
		echo "UNO".$consulta."<br>";
		$rs	= mysqli_query($link, $consulta);
		$row = mysqli_fetch_array($rs);
		//Nuevo para revisar pesos promedios
		$consultaj= "SELECT SUM(unidades) as unidad_mov, SUM(peso) as peso_mov";
		$consultaj= $consultaj." FROM sea_web.movimientos WHERE cod_producto = 17 AND cod_subproducto = ".$cmbproducto;
	    $consultaj= $consultaj." AND (tipo_movimiento = 2 or tipo_movimiento = 4 or tipo_movimiento = 9) AND hornada = ".$cmbhornada;
		echo "DOS".$consultaj."<br>";
		$rj = mysqli_query($link, $consultaj);
		$rowj = mysqli_fetch_array($rj);
		
		$consultar= "SELECT SUM(unidades) as unidad_rec, SUM(peso) as peso_rec";
		$consultar.=" FROM sea_web.movimientos WHERE cod_producto = 17 AND cod_subproducto = ".$cmbproducto;
	    $consultar.=" AND tipo_movimiento = 1 and (sub_tipo_movim = '2' or sub_tipo_movim = '4')";
		$consultar.=" AND hornada = ".$cmbhornada;
		//echo "tre".$consultar."<br>";
		$rr = mysqli_query($link, $consultar);
		$rowr = mysqli_fetch_array($rr);
		$peso_rc  = $rowr["peso_rec"];
		$unidad_rc = $rowr["unidad_rec"];
		$peso_h1 	= $row["peso_recep"];
		$unidad_h1 	= $row["unidad_recep"];
		$peso_m1 	= $rowj["peso_mov"];
		$unidad_m1	= $rowj["unidad_mov"];
		$peso_h1 	= $peso_h1 - ($peso_m1 + $peso_rc);
		$unidad_h1 	= $unidad_h1 - ($unidad_m1 + $unidad_rc);
		//echo "aa".$peso_h1."bb".$unidad_h1."cc".$peso_m1."dd".$unidad_m1."<br>";
		if($stock_actual!=0)
			$promedio   = round(($peso_faltante / $stock_actual),10);
		
	//aqui para sacar unidades a raf

		$consulta = "SELECT sum(unidades) as unidades, sum(peso) as peso from sea_web.movimientos where tipo_movimiento = 4 and ";
		$consulta.="  cod_producto = 17 and cod_subproducto = '".$cmbproducto."' and hornada = ".$cmbhornada;
		//echo $consulta."<br>";
		$rs	= mysqli_query($link, $consulta);
		if ($row = mysqli_fetch_array($rs))
		{
			$peso_raf = $row["peso"];
			$unidad_raf = $row["unidades"];
		}	
		$parametros = "cmbtipo=".$cmbtipo."&cmbproducto=".$cmbproducto."&dia=".$dia."&mes=".$mes."&ano=".$ano."&Hora=".$Hora."&Minutos=".$Minutos."&cmbhornada=".$cmbhornada;
		//$parametros = $parametros."&unid_rech=".$stock_rechazo."&peso_faltante=".$peso_faltante;
		$parametros = $parametros."&unid_rech=".$unidad_rc."&peso_rc=".$peso_rc."&peso_faltante=".$peso_faltante;
		$parametros = $parametros."&recargapag4=S&cmbgrupo=".$cmbgrupo."&campo1=".$campo1;
		$parametros = $parametros."&txtunidstock=".$stock_actual."&pesopromedio=".$promedio."&recargapag1=S&recargapag2=S&recargapag3=S";
		$parametros = $parametros."&activa_fecha2=".$marcacheckbox."&dia2=".$dia2."&mes2=".$mes2."&ano2=".$ano2;
		$parametros = $parametros."&unidad_raf=".$unidad_raf."&peso_raf=".$peso_raf;
		//echo "jjj".$parametros;
		header("Location:sea_ing_beneficio.php?".$parametros);				
	}
	
	if ($proceso == "G")
	{
		//*******************************************************************************//
			//Valida que no se realicen cambios de movimientos, en la fecha ingresada.
			
			$valida_fecha_movimiento = $ano."-".$mes."-".$dia;
			include("sea_valida_mes.php");
			$fecha_hora = $ano."-".$mes."-".$dia." ".$Hora.":".$Minutos;

		//*******************************************************************************//	
		
		//*******************************************************************************//
			//Valida que no se realicen cambios de movimientos, en la fecha ingresada.
			
			if ($marcacheckbox == "S")
			{
				$valida_fecha_movimiento = $ano2."-".$mes2."-".$dia2;
				include("sea_valida_mes.php");
			}
		//*******************************************************************************//		
		
		$linea = "recargapag1=S&recargapag2=S&cmbtipo=".$cmbtipo."&cmbproducto=".$cmbproducto."&dia=".$dia."&mes=".$mes."&ano=".$ano;
		$linea = $linea."&recargapag4=S&cmbgrupo=".$cmbgrupo."&campo1=".$campo1;

		$fecha = $ano.'-'.$mes.'-'.$dia;
		if ($marcacheckbox == "S")
			$fecha2 = $ano2.'-'.$mes2.'-'.$dia2;
		else
			$fecha2 = '0000-00-00';
		
		  
		//Busca el flujo Asociado al producto y proceso.		
		$consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 2 AND cod_producto = 17";
		$consulta = $consulta." AND cod_subproducto = ".$cmbproducto;

		$rs1 = mysqli_query($link, $consulta);
		if ($row1 = mysqli_fetch_array($rs1))
			$flujo = $row1["flujo"];
		else 
			$flujo = 0;

		$consulta = "SELECT * FROM sea_web.movimientos WHERE tipo_movimiento = 2 AND cod_producto = 17 AND cod_subproducto = ".$cmbproducto;	
		$consulta = $consulta." AND fecha_movimiento = '".$fecha."' AND campo2 = '".$cmbgrupo."' AND campo1 = '".$campo1."'" ;
		$consulta = $consulta." AND numero_recarga = 0 AND hornada = ".$cmbhornada;
 		//echo "UNO". $consulta;
		$rs2 = mysqli_query($link, $consulta);
		if ($row2 = mysqli_fetch_array($rs2)) //Existe.
		{
			echo '<script language="JavaScript">';
			echo 'if (confirm("Ya existe beneficio de esta hornada, Desea Acumular"))';
			echo '{';
			echo 'document.location = "sea_ing_beneficio01.php?proceso=A&txtunidbenef='.$txtunidbenef.'&txtpesobenef='.$peso_benef.'&cmbhornada='.$cmbhornada.'&txtunidstock='.$txtunidstock.'&'.$linea.'";';
			echo '}';
			echo 'else';
			echo '{';
			echo 'document.location = "sea_ing_beneficio.php?'.$linea.'"';
			echo '}';
			echo '</script>';				
		}		
		else 
		{
			//Graba el Beneficio.	  
			if ($marcacheckbox == "S")
			{
				$insertar = "INSERT INTO sea_web.movimientos (tipo_movimiento,cod_producto,cod_subproducto,hornada,numero_recarga,fecha_movimiento,campo1,campo2,unidades,flujo,fecha_benef,peso,hora,sub_tipo_movim)";
				$insertar = $insertar." VALUES (2,17,".$cmbproducto.",".$cmbhornada.",0,'".$fecha2."','".$campo1;
				$insertar = $insertar."','".$cmbgrupo."',".$txtunidbenef.",".$flujo.",'".$fecha."',".$peso_benef.",'$fecha_hora','1')";	
				//echo "IN".$insertar;		
				mysqli_query($link, $insertar);
			}		
			else 
			{
				$insertar = "INSERT INTO sea_web.movimientos (tipo_movimiento,cod_producto,cod_subproducto,hornada,numero_recarga,fecha_movimiento,campo1,campo2,unidades,flujo,fecha_benef,peso,hora,sub_tipo_movim)";
				$insertar = $insertar." VALUES (2,17,".$cmbproducto.",".$cmbhornada.",0,'".$fecha."','".$campo1;
				$insertar = $insertar."','".$cmbgrupo."',".$txtunidbenef.",".$flujo.",'".$fecha2."',".$peso_benef.",'$fecha_hora','1')";		
				//echo "RRR".$insertar;	
				mysqli_query($link, $insertar);
			}

/*		
			//Graba los Rechazos a N.E.		
			if ($txtunidbenef > $txtunidstock)
			{			
				$diferencia = $txtunidbenef - $txtunidstock;
				
				$insertar = "INSERT INTO sea_web.movimientos (tipo_movimiento,cod_producto,cod_subproducto,hornada,numero_recarga,fecha_movimiento,campo1,campo2,unidades,flujo)";
				$insertar = $insertar." VALUES (8,17,".$cmbproducto.",".$cmbhornada.",0,'".$fecha."','".$campo1;
				$insertar = $insertar."','".$cmbgrupo."',".$diferencia.",0)";		
				mysqli_query($link, $insertar);			
			}
*/		
			header("Location:sea_ing_beneficio.php?".$linea);
		}
		header("Location:sea_ing_beneficio.php?".$linea);
	}				
	
	
	//Si Existe un benefio de una hornada, en el mismo lugar (grupo y lado � cuba), acumular y arreglar los movimientos que se generaron.
	if ($proceso == "A")
	{
		//*******************************************************************************//
			//Valida que no se realicen cambios de movimientos, en la fecha ingresada.
			
			$valida_fecha_movimiento = $ano."-".$mes."-".$dia;
			include("sea_valida_mes.php");
		//*******************************************************************************//	
	
		$fecha = $ano.'-'.$mes.'-'.$dia;

		$actualizar = "UPDATE sea_web.movimientos SET unidades = (unidades + ".$txtunidbenef."), peso = (peso + ".$txtpesobenef.")";
		$actualizar = $actualizar." WHERE tipo_movimiento = 2 AND cod_producto = 17 AND cod_subproducto = ".$cmbproducto;
		$actualizar = $actualizar." AND hornada = ".$cmbhornada." AND numero_recarga = 0 AND fecha_movimiento = '".$fecha."'";
		$actualizar = $actualizar." AND campo1 = '".$campo1."' AND campo2 = '".$cmbgrupo."'";
		mysqli_query($link, $actualizar);

/*		
		//Graba los Rechazos a N.E.		
		if ($txtunidbenef > $txtunidstock)
		{
			$diferencia = $txtunidbenef - $txtunidstock;
			$peso_aux = round(($txtpesobenef / $txtunidbenef) * diferencia);
		
			$actualizar = "UPDATE sea_web.movimientos SET unidades = (unidades + ".$diferencia."), peso = (peso + ".$peso_aux.")";
			$actualizar = $actualizar." WHERE tipo_movimiento = 8 AND cod_producto = 17 AND cod_subproducto = ".$cmbproducto;
			$actualizar = $actualizar." AND hornada = ".$cmbhornada." AND numero_recarga = 0 AND fecha_movimiento = '".$fecha."'";
			$actualizar = $actualizar." AND campo1 = '".$campo1."' AND campo2 = '".$cmbgrupo."'";
			mysqli_query($link, $actualizar);
		}
*/	
		
		$linea = "recargapag1=S&recargapag2=S&cmbtipo=".$cmbtipo."&cmbproducto=".$cmbproducto."&dia=".$dia."&mes=".$mes."&ano=".$ano;
		$linea = $linea."&recargapag4=S&cmbgrupo=".$cmbgrupo."&campo1=".$campo1;
		header("Location:sea_ing_beneficio.php?".$linea);		
	}
	
	
	include("../principal/cerrar_sea_web.php");
?>
