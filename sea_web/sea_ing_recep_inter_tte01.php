<?php
	include("../principal/conectar_sea_web.php");
//*******************************************************************************//
	//Valida que no se realicen cambios de movimientos, en la fecha ingresada.
//*******************************************************************************/
//Proceso=CL&SubProducto="+SP+"&LoteVentana="+Lote+"&Guia="+Guia;

if(isset($_REQUEST["Proceso"])) {
	$Proceso = $_REQUEST["Proceso"];
}else{
	$Proceso = '';
}
if(isset($_REQUEST["SubProducto"])) {
	$SubProducto = $_REQUEST["SubProducto"];
}else{
	$SubProducto = '';
}
if(isset($_REQUEST["LoteVentana"])) {
	$LoteVentana = $_REQUEST["LoteVentana"];
}else{
	$LoteVentana = '';
}
if(isset($_REQUEST["Guia"])) {
	$Guia = $_REQUEST["Guia"];
}else{
	$Guia = '';
}
if(isset($_REQUEST["GrabarTTE"])) {
	$GrabarTTE = $_REQUEST["GrabarTTE"];
}else{
	$GrabarTTE = '';
}
if(isset($_REQUEST["DatosRecep"])) {
	$DatosRecep = $_REQUEST["DatosRecep"];
}else{
	$DatosRecep = '';
}

if(isset($_REQUEST["proveedor"])) {
	$proveedor = $_REQUEST["proveedor"];
}else{
	$proveedor = '';
}

if(isset($_REQUEST["ano"])) {
	$ano = $_REQUEST["ano"];
}else{
	$ano = "";
}
if(isset($_REQUEST["mes"])) {
	$mes= $_REQUEST["mes"];
}else{
	$mes = "";
}
if(isset($_REQUEST["dia"])) {
	$dia= $_REQUEST["dia"];
}else{
	$dia = "";
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

if(isset($_REQUEST["peso_recepcion"])) {
	$peso_recepcion = $_REQUEST["peso_recepcion"];
}else{
	$peso_recepcion = "";
}
if(isset($_REQUEST["hornada_aux"])) {
	$hornada_aux = $_REQUEST["hornada_aux"];
}else{
	$hornada_aux = "";
}
if(isset($_REQUEST["hornada"])) {
	$hornada = $_REQUEST["hornada"];
}else{
	$hornada = "";
}
if(isset($_REQUEST["peso_origen"])) {
	$peso_origen = $_REQUEST["peso_origen"];
}else{
	$peso_origen = "";
}
if(isset($_REQUEST["unidades"])) {
	$unidades = $_REQUEST["unidades"];
}else{
	$unidades = "";
}

//Proceso=CT&SubProducto="+SP+"&LoteVentana="+Lote+"&Rec="+Rec+"&Guia="+Guia+"&
//UnidR="+UnidR+"&PesoR="+PesoR+"&LoteOrigen="+Origen+"&PesoO="+PesoO+"&UnidO="+UnidO+"
//&FechaGuia="+FechaGuia+"&Marca="+Marca;
if(isset($_REQUEST["Rec"])) {
	$Rec = $_REQUEST["Rec"];
}else{
	$Rec = "";
}
if(isset($_REQUEST["UnidR"])) {
	$UnidR = $_REQUEST["UnidR"];
}else{
	$UnidR = "";
}
if(isset($_REQUEST["PesoR"])) {
	$PesoR = $_REQUEST["PesoR"];
}else{
	$PesoR = "";
}
if(isset($_REQUEST["LoteOrigen"])) {
	$LoteOrigen = $_REQUEST["LoteOrigen"];
}else{
	$LoteOrigen = "";
}
if(isset($_REQUEST["PesoO"])) {
	$PesoO = $_REQUEST["PesoO"];
}else{
	$PesoO = "";
}
if(isset($_REQUEST["UnidO"])) {
	$UnidO = $_REQUEST["UnidO"];
}else{
	$UnidO = "";
}
if(isset($_REQUEST["FechaGuia"])) {
	$FechaGuia = $_REQUEST["FechaGuia"];
}else{
	$FechaGuia = "";
}
if(isset($_REQUEST["Marca"])) {
	$Marca = $_REQUEST["Marca"];
}else{
	$Marca = "";
}

$codigo = substr($proveedor,0,1);

//ANODOS
if (($Proceso == 'M' || $Proceso == 'G') && $codigo == "A")
{
    $fecha = $ano.'-'.$mes.'-'.$dia;
	$fecha_hora = $ano."-".$mes."-".$dia." ".$Hora.":".$Minutos;
	reset($unidades);	
	//while (list($clave,$valor) = each($unidades))
	foreach ($unidades as $clave => $valor)
	{
		$hornadas='';$unidades_total='';$peso_total='';$hornadas='';$unidades_total='';$peso_total='';$peso_unidades='';$unidades_nuevas='';
		if($hornada_aux[$clave]	!= '')
		   $hornadas = $hornada_aux[$clave];
		if($peso_origen[$clave] == '')
			$peso_origen = 0;  
		if($peso_recepcion[$clave] == 0 || $peso_recepcion[$clave] == '')  
		{
		   $peso_recep =  $peso_origen[$clave];
		   $estado = 1;
		}
		else
		{
		   $peso_recep = $peso_recepcion[$clave];
		   $estado = 0;
		}  
		if($unidades[$clave] != ''&&$unidades[$clave]!='0')
		{
				//consulta flujo
				$consulta = "SELECT flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 1 AND cod_producto = 17";
				$consulta = $consulta." AND cod_subproducto = ".$producto[$clave];
				$rs1 = mysqli_query($link, $consulta);
				if ($row1 = mysqli_fetch_array($rs1))
				   $flujo = $row1["flujo"];
				else 
				   $flujo = 0;
				//Inserta en Movimientos
				$Insertar = "INSERT INTO sea_web.movimientos";
				$Insertar = "$Insertar (tipo_movimiento,cod_producto,cod_subproducto,hornada,numero_recarga,fecha_movimiento,campo1,campo2,unidades,flujo,peso,estado,lote_ventana,peso_origen,hora,sub_tipo_movim)";	
				$Insertar = "$Insertar  VALUES(1,17,$producto[$clave],$hornadas,$recargo[$clave],'$fecha','999999','999999',$unidades[$clave],$flujo,$peso_recep,$estado,'".$lote_ventana[$clave]."',$peso_origen[$clave],'$fecha_hora',1)";
				mysqli_query($link, $Insertar);
				if($GrabarTTE=='S')
				{
					$Actualizar="UPDATE sea_web.recepcion_externa set peso_recep=peso_recep+".$peso_recep.",piezas_recep=piezas_recep+".$unidades[$clave];
					$Actualizar.=" where cod_producto='17' and cod_subproducto='".$producto[$clave]."' and lote_ventana='".$lote_ventana[$clave]."' and guia='".$guia[$clave]."'";
					mysqli_query($link, $Actualizar);
					$Actualizar="UPDATE sipa_web.recepciones set fecha='$fecha',peso_neto='".$peso_recep."',observacion='".$unidades[$clave]."' where lote='".$lote_ventana[$clave]."' and recargo='".$recargo[$clave]."'";
					mysqli_query($link, $Actualizar);
				}	
				//consulto en tabla Hornadas
				$Consulta = "SELECT * FROM sea_web.hornadas WHERE hornada_ventana = $hornadas";
				$rs = mysqli_query($link, $Consulta);
				if($row = mysqli_fetch_array($rs))
				{ 
					//actualiza tabla hornadas
					$Consulta = "SELECT SUM(unidades) as unid, SUM(peso) as pes FROM sea_web.movimientos WHERE tipo_movimiento = 1 AND cod_producto = 17 AND hornada = $hornadas";
					$Rs = mysqli_query($link, $Consulta);
					if($fila = mysqli_fetch_array($Rs))
					{
						$Actualizo = "UPDATE sea_web.hornadas SET unidades = $fila["unid"], peso_unidades = $fila["pes"] WHERE cod_producto = 17 AND hornada_ventana = $hornadas";
						mysqli_query($link, $Actualizo);
					}
				} 
				else
				{
					$Insertar2 = "INSERT INTO sea_web.hornadas";
					$Insertar2 = "$Insertar2 (cod_producto,cod_subproducto,hornada_ventana,unidades,peso_unidades)";			
					$Insertar2 = "$Insertar2 VALUES(17,$producto[$clave],$hornadas,$unidades[$clave],$peso_recep)";
					mysqli_query($link, $Insertar2);
				}
		}
	}
}
if ($Proceso == 'CL')//CERRAR LOTE
{
	$Actualizar="UPDATE sea_web.recepcion_externa SET estado='C'";
	$Actualizar.=" where cod_producto='17' and cod_subproducto='".$SubProducto."' and lote_ventana='".$LoteVentana."' and guia='".$Guia."' ";
	mysqli_query($link, $Actualizar);
}
if ($Proceso == 'CT')//CERRAR TENIENTE Y TRASPASAR AL MES SIGUIENTE
{
	$Actualizar="UPDATE sea_web.recepcion_externa SET peso='".$PesoR."',piezas='".$UnidR."',estado='C'";
	$Actualizar.=" where cod_producto='17' and cod_subproducto='".$SubProducto."' and lote_ventana='".$LoteVentana."' and guia='".$Guia."' ";
	mysqli_query($link, $Actualizar);
	$NuevoPeso=intval($PesoO)-intval($PesoR);
	$NuevaUnid=intval($UnidO)-intval($UnidR);
	$Consulta = "SELECT * from sea_web.recepcion_externa where lote_origen='".str_replace('-','',$LoteOrigen)."' and substring(fecha,1,7)='".date('Y')."-".str_pad(date('m'),2,'0',STR_PAD_LEFT)."'";
	$RespAux = mysqli_query($link, $Consulta);
	if(!$FilaAux=mysqli_fetch_array($RespAux))
	{
		//OBTENER LOTE SIPA "PROCESO I<br>";
		$AnoMes = substr(date('Y'),2,2).str_pad(date('m'),2,'0',STR_PAD_LEFT);
		$Consulta = "SELECT ifnull(max(lote)+1,'".$AnoMes."0001') as lote_nuevo from sipa_web.correlativo_lote where cod_proceso='R' and lote like '".$AnoMes."%'";
		$RespLote=mysqli_query($link, $Consulta);
		$FilaLote=mysqli_fetch_array($RespLote);
		$LoteVentana = str_pad($FilaLote["lote_nuevo"],8,"0",STR_PAD_LEFT);
		$Actualizar = "UPDATE sipa_web.correlativo_lote set lote='".$LoteVentana."' where cod_proceso='R'";
		mysqli_query($link, $Actualizar);	
		
		$Consulta = "SELECT IFNULL(MAX(ciclo),0) AS ciclo FROM sea_web.relaciones WHERE cod_origen = 2";
		$RespAux = mysqli_query($link, $Consulta);
		$FilaAux=mysqli_fetch_array($RespAux);
		$CicloAux = $FilaAux["ciclo"];
		$Consulta = "SELECT MAX(hornada_ventana) AS hornada_max FROM sea_web.relaciones";
		$Consulta.=" WHERE cod_origen = 2 AND ciclo = ".$CicloAux;
		$RespAux = mysqli_query($link, $Consulta);
		$FilaAux=mysqli_fetch_array($RespAux);
		if(is_null($FilaAux["hornada_max"])||(substr($FilaAux["hornada_max"],6,3) == "999"))
		//if(substr($FilaAux["hornada_max"],6,3) = "999")
		{
			$Consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2005 AND cod_subclase = 2";
			$RespAux = mysqli_query($link, $Consulta);
			$FilaAux=mysqli_fetch_array($RespAux);
			$Hornada = $FilaAux["valor_subclase"];
		}	
		else
			$Hornada = substr(($FilaAux["hornada_max"] + 1), 6, 6);
		$Hornada = date('Y').str_pad(date('m'),2,"0",STR_PAD_LEFT).$Hornada;
		$Consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2005 AND cod_subclase = 2";
		$RespAux = mysqli_query($link, $Consulta);
		$FilaAux=mysqli_fetch_array($RespAux);
		if (substr($Hornada, 6, 4) == $FilaAux["valor_subclase1"])
			$Ciclo = $CicloAux + 1;
		else
			$Ciclo = $CicloAux;
		$Insertar = "INSERT INTO sea_web.relaciones (cod_origen,lote_ventana,lote_origen,hornada_ventana,marca,ciclo)";
		$Insertar.=" VALUES (2,'".$LoteVentana."','".$LoteOrigen."',".$Hornada;
		$Insertar.=",'".substr($Marca, 0, 2)."',".$Ciclo.")";
		mysqli_query($link, $Insertar);
	
		$Insertar = "insert into sea_web.recepcion_externa(guia,cod_producto,cod_subproducto,lote_origen,lote_ventana,peso,peso_recep,piezas,piezas_recep,marca,fecha,estado,fecha_guia) values('".$Guia."','17','2','".str_replace('-','',$LoteOrigen)."','".$LoteVentana."',";
		$Insertar.= "'".$NuevoPeso."',0,'".$NuevaUnid."','0','".substr($Marca, 0, 2)."','".date('Y-m-d')."','','".$FechaGuia."')";
		mysqli_query($link, $Insertar);

		$Consulta = "SELECT ifnull(max(correlativo)+1,1) as correlativo from sipa_web.recepciones";
		$RespCorr = mysqli_query($link, $Consulta);
		$FilaCorr=mysqli_fetch_array($RespCorr);
		$Corr = $FilaCorr[correlativo];
		
		$Insertar = "insert into sipa_web.recepciones (correlativo,lote,recargo,ult_registro,rut_operador,bascula_entrada,bascula_salida,fecha,";
		$Insertar.="rut_prv,cod_mina,cod_grupo,cod_producto,cod_subproducto,guia_despacho,patente,cod_clase,conjunto,observacion,tipo) values(";
		$Insertar.="'".$Corr."','".$LoteVentana."','1','N','9999999-9','0','0','".date('Y-m-d')."',";
		$Insertar.="'61704005-0','06101.0004-2','2','1','17',";
		$Insertar.="'".$Guia."','','M','','','A')";
		mysqli_query($link, $Insertar);
	}
	else
	{
		//echo "PROCESO II<br>";
		$LoteVentana = $FilaAux[lote_ventana];
		$Consulta = "SELECT * from sea_web.recepcion_externa where guia='".$Guia."' and lote_origen='".str_replace('-','',$LoteOrigen)."'";
		$RespAux = mysqli_query($link, $Consulta);
		if($Fila=mysqli_fetch_array($RespAux))
		{
			$Insertar = "insert into sea_web.recepcion_externa(guia,cod_producto,cod_subproducto,lote_origen,lote_ventana,peso,peso_recep,piezas,piezas_recep,marca,fecha,estado,fecha_guia) values('".$Guia."','17','2','".str_replace('-','',$LoteOrigen)."','".$LoteVentana."',";
			$Insertar.= "'".$NuevoPeso."',0,'".$NuevaUnid."','0','".substr($Marca, 0, 2)."','".date('Y-m-d')."','','".$FechaGuia."')";
			mysqli_query($link, $Insertar);

			$Consulta = "SELECT  max(lpad(recargo,2,'0'))+1 as recargo_nuevo from sipa_web.recepciones where lote = '".$LoteVentana."' group by lote";
			$RespAux = mysqli_query($link, $Consulta);
			$FilaAux=mysqli_fetch_array($RespAux);
			$Rec=$FilaAux[recargo_nuevo];
			
			$Consulta = "SELECT ifnull(max(correlativo)+1,1) as correlativo from sipa_web.recepciones";
			$RespCorr = mysqli_query($link, $Consulta);
			$FilaCorr=mysqli_fetch_array($RespCorr);
			$Corr = $FilaCorr[correlativo];

			$Insertar = "insert into sipa_web.recepciones (correlativo,lote,recargo,ult_registro,rut_operador,bascula_entrada,bascula_salida,fecha,";
			$Insertar.="rut_prv,cod_mina,cod_grupo,cod_producto,cod_subproducto,guia_despacho,patente,cod_clase,conjunto,observacion,tipo) values(";
			$Insertar.="'".$Corr."','".$LoteVentana."','".$Rec."','N','9999999-9','0','0','".date('Y-m-d')."',";
			$Insertar.="'61704005-0','06101.0004-2','2','1','17',";
			$Insertar.="'".$Guia."','','M','','','A')";
			mysqli_query($link, $Insertar);
		}
	}	
	
		
	if($EliminaLote=='S')	//ELIMINAR LOTE
	{	
		$Eliminar="delete from sea_web.recepcion_externa ";
		$Eliminar.=" where cod_producto='17' and cod_subproducto='$SubProducto' and lote_ventana='$LoteVentanaAnterior' and guia='$Guia'";
		mysqli_query($link, $Eliminar);
	
		$Eliminar="delete from sipa_web.recepciones ";
		$Eliminar.=" where lote='$LoteVentanaAnterior' and recargo='$Rec' and guia_despacho='$Guia'";
		mysqli_query($link, $Eliminar);
	}
}

if ($Proceso == 'EL')//ELIMINAR LOTE
{
	
	
	/*  DVS 21-01-2014 AC*/
	
	$LoteVentanaAnterior=$LoteVentana;
	$RecAnterior=$Rec;
		//OBTENER LOTE SIPA "PROCESO I<br>";
		$NuevoPeso=intval($PesoO)-intval($PesoR);
		$NuevaUnid=intval($UnidO)-intval($UnidR);
		$AnoMes = substr(date('Y'),2,2).str_pad(date('m'),2,'0',STR_PAD_LEFT);
		$Consulta = "SELECT ifnull(max(lote)+1,'".$AnoMes."0001') as lote_nuevo from sipa_web.correlativo_lote where cod_proceso='R' and lote like '".$AnoMes."%'";
		$RespLote=mysqli_query($link, $Consulta);
		$FilaLote=mysqli_fetch_array($RespLote);
		$LoteVentana = str_pad($FilaLote["lote_nuevo"],8,"0",STR_PAD_LEFT);
		$Actualizar = "UPDATE sipa_web.correlativo_lote set lote='".$LoteVentana."' where cod_proceso='R'";
		mysqli_query($link, $Actualizar);	
		$Consulta = "SELECT IFNULL(MAX(ciclo),0) AS ciclo FROM sea_web.relaciones WHERE cod_origen = 2";
		$RespAux = mysqli_query($link, $Consulta);
		$FilaAux=mysqli_fetch_array($RespAux);
		$CicloAux = $FilaAux["ciclo"];
		$Consulta = "SELECT MAX(hornada_ventana) AS hornada_max FROM sea_web.relaciones";
		$Consulta.=" WHERE cod_origen = 2 AND ciclo = ".$CicloAux;
		$RespAux = mysqli_query($link, $Consulta);
		$FilaAux=mysqli_fetch_array($RespAux);
		if(is_null($FilaAux["hornada_max"])||(substr($FilaAux["hornada_max"],6,3) == "999"))
		//if(substr($FilaAux["hornada_max"],6,3) = "999")
		{
			$Consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2005 AND cod_subclase = 2";
			$RespAux = mysqli_query($link, $Consulta);
			$FilaAux=mysqli_fetch_array($RespAux);
			$Hornada = $FilaAux["valor_subclase"];
		}	
		else
			$Hornada = substr(($FilaAux["hornada_max"] + 1), 6, 6);
		$Hornada = date('Y').str_pad(date('m'),2,"0",STR_PAD_LEFT).$Hornada;
		$Consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2005 AND cod_subclase = 2";
		$RespAux = mysqli_query($link, $Consulta);
		$FilaAux=mysqli_fetch_array($RespAux);
		if (substr($Hornada, 6, 4) == $FilaAux["valor_subclase1"])
			$Ciclo = $CicloAux + 1;
		else
			$Ciclo = $CicloAux;
		$Insertar = "INSERT INTO sea_web.relaciones (cod_origen,lote_ventana,lote_origen,hornada_ventana,marca,ciclo)";
		$Insertar.=" VALUES (2,'".$LoteVentana."','".$LoteOrigen."',".$Hornada;
		$Insertar.=",'".substr($Marca, 0, 2)."',".$Ciclo.")";
		mysqli_query($link, $Insertar);
	
		$Consulta = "SELECT * from sea_web.recepcion_externa where guia='".$Guia."' and lote_origen='".str_replace('-','',$LoteOrigen)."'";
		$RespAux = mysqli_query($link, $Consulta);
		if($Fila=mysqli_fetch_array($RespAux))
		{
			$Insertar = "insert into sea_web.recepcion_externa(guia,cod_producto,cod_subproducto,lote_origen,lote_ventana,peso,peso_recep,piezas,piezas_recep,marca,fecha,estado,fecha_guia) values('".$Guia."','17','2','".str_replace('-','',$LoteOrigen)."','".$LoteVentana."',";
			$Insertar.= "'".$NuevoPeso."',0,'".$NuevaUnid."','0','".substr($Marca, 0, 2)."','".date('Y-m-d')."','','".$FechaGuia."')";
			mysqli_query($link, $Insertar);
			$Rec=1;
			$Consulta = "SELECT  max(lpad(recargo,2,'0'))+1 as recargo_nuevo from sipa_web.recepciones where lote = '".$LoteVentana."' group by lote";
			$RespAux = mysqli_query($link, $Consulta);
			if($FilaAux=mysqli_fetch_array($RespAux))
			{	
				$Rec=$FilaAux[recargo_nuevo];
			}
			else
			{
				$Rec=1;
			}
			$Consulta = "SELECT ifnull(max(correlativo)+1,1) as correlativo from sipa_web.recepciones";
			$RespCorr = mysqli_query($link, $Consulta);
			$FilaCorr=mysqli_fetch_array($RespCorr);
			$Corr = $FilaCorr[correlativo];

			$Insertar = "insert into sipa_web.recepciones (correlativo,lote,recargo,ult_registro,rut_operador,bascula_entrada,bascula_salida,fecha,";
			$Insertar.="rut_prv,cod_mina,cod_grupo,cod_producto,cod_subproducto,guia_despacho,patente,cod_clase,conjunto,observacion,tipo) values(";
			$Insertar.="'".$Corr."','".$LoteVentana."','".$Rec."','N','9999999-9','0','0','".date('Y-m-d')."',";
			$Insertar.="'61704005-0','06101.0004-2','2','1','17',";
			$Insertar.="'".$Guia."','','M','','','A')";
			mysqli_query($link, $Insertar);
		$Eliminar="delete from sea_web.recepcion_externa ";
		$Eliminar.=" where cod_producto='17' and cod_subproducto='$SubProducto' and lote_ventana='$LoteVentanaAnterior' and guia='$Guia'";
		mysqli_query($link, $Eliminar);
	
		$Eliminar="delete from sea_web.recepcion_externa ";
		$Eliminar.=" where cod_producto='17' and cod_subproducto='$SubProducto' and lote_ventana='$LoteVentanaAnterior' and guia='$Guia'";
		mysqli_query($link, $Eliminar);
	
		$Eliminar="delete from sipa_web.recepciones ";
		$Eliminar.=" where lote='$LoteVentanaAnterior' and recargo='$RecAnterior' and guia_despacho='$Guia'";
		mysqli_query($link, $Eliminar);

		/*AGREGA DVS LTDA 07-06-2018 - ANULA SA CREADA EN FORMA AUTOMATICA*/
		$Actualizar="UPDATE cal_web.solicitud_analisis set estado_actual='7' where id_muestra='$LoteVentanaAnterior' and recargo=''";
		mysqli_query($link, $Actualizar);

		}
	

}

RecalcularSipa($link);
function RecalcularSipa($link)
{
	$FechaAMD=date('Y-m-d');
  $ConsultaR = "SELECT * from sea_web.recepcion_externa where estado not in ('C','X') and peso<>peso_recep";
 $RespRGuia=mysqli_query($link, $ConsultaR);
		while($FilaRGuia=mysqli_fetch_array($RespRGuia))
		{
       		$ConsultaR2 = "SELECT * from sipa_web.recepciones where lote='".$FilaRGuia["lote_ventana"]."' and peso_neto<>'0' ";//and fecha <> '".$FechaAMD."'";
			$RespR2Guia=mysqli_query($link, $ConsultaR2);
			if($FilaR2Guia=mysqli_fetch_array($RespR2Guia))
			{
				$ConsultaR3 = "SELECT  * from sipa_web.recepciones where lote = '".$FilaRGuia["lote_ventana"]."' and peso_neto=0 and guia_despacho='".$FilaRGuia["guia"]."'";
				$RespR3Guia=mysqli_query($link, $ConsultaR3);
				if(!$FilaR3Guia=mysqli_fetch_array($RespR3Guia))
				{
					$ConsultaREC = "SELECT  max(lpad(recargo,2,'0'))+1 as recargo_nuevo from sipa_web.recepciones where lote = '".$FilaRGuia["lote_ventana"]."' group by lote";
					$RespRECGuia=mysqli_query($link, $ConsultaREC);
					if($FilaRECGuia=mysqli_fetch_array($RespRECGuia))
					{ 
						$Rec = $FilaRECGuia["recargo_nuevo"];
					}
					$ConsultaCorr= "SELECT ifnull(max(correlativo)+1,1) as correlativo from sipa_web.recepciones";
				   $RespCorrGuia=mysqli_query($link, $ConsultaCorr);
					if($FilaCorrGuia=mysqli_fetch_array($RespCorrGuia))
					{ 
						$Corr = $FilaCorrGuia["correlativo"];
					}
					$Insertar = "insert into sipa_web.recepciones (correlativo,lote,recargo,ult_registro,rut_operador,bascula_entrada,bascula_salida,fecha,";
					$Insertar.= "rut_prv,cod_mina,cod_grupo,cod_producto,cod_subproducto,guia_despacho,patente,cod_clase,conjunto,observacion,tipo) values(";
					$Insertar.= "'".$Corr."','".$FilaRGuia["lote_ventana"]."','".$Rec."','N','9999999-9','0','0','".$FechaAMD."',";
					$Insertar.="'61704005-0','06101.0004-2','2','1','17',";
					$Insertar.="'".$FilaRGuia["guia"]."','','M','','','A')";
					mysqli_query($link, $Insertar);
				
				}
			   
			}
      
		}
}
	$valores = 'Mostrar=S&Est=A'.'&ano='.$ano.'&mes='.$mes.'&dia='.$dia.'&proveedor='.$proveedor; 
header("Location:sea_ing_recep_inter_tte.php?".$valores);
	include("../principal/cerrar_sea_web.php");		
?>