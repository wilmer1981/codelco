<?php
	include("../principal/conectar_sea_web.php");

$codigo = substr($proveedor,0,1);
function RegistroActividad($Obs)
{
	$FechaRegistro=date('Y-m-d G:i:s');
	$Insertar="Insert Into sea_registro_actividad(rut,fecha_registro,accion) ";
	$Insertar.=" values('".$_COOKIE["CookieRut"]."','".$FechaRegistro."','".$Obs."') ";
	mysqli_query($link, $Insertar);
	
	
}
//ANODOS
if (($Proceso == 'M' || $Proceso == 'G') && $codigo == "A")
{
    $fecha = $ano.'-'.$mes.'-'.$dia;
	$fecha_hora = $ano."-".$mes."-".$dia." ".$Hora.":".$Minutos;
	reset($unidades);	
	while (list($clave,$valor) = each($unidades))
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
				$Insertar = "$Insertar  VALUES(1,17,$producto[$clave],$hornadas,$recargo[$clave],'$fecha','".$guia[$clave]."','TRENANGLO',$unidades[$clave],$flujo,$peso_recep,$estado,'".$lote_ventana[$clave]."',$peso_origen[$clave],'$fecha_hora',1)";
				mysqli_query($link, $Insertar);
		
				RegistroActividad("Inserta Movimiento para guia $guia[$clave];  Recargo:$recargo[$clave] ;Lote V: $lote_ventana[$clave]; hornada: $hornadas; fecha mov.:$fecha ; Unidades : $unidades[$clave]; Peso :$peso_recep ");
		
				if($GrabarTTE=='S')
				{
					$Actualizar="UPDATE sea_web.recepcion_externa_anglo set peso_recep=peso_recep+".$peso_recep.",piezas_recep=piezas_recep+".$unidades[$clave];
					$Actualizar.=" where cod_producto='17' and cod_subproducto='".$producto[$clave]."' and lote_ventana='".$lote_ventana[$clave]."' and guia='".$guia[$clave]."'";
					mysqli_query($link, $Actualizar);
				//	echo " A 1 ".$Actualizar."<br>";
				
					$Actualizar="UPDATE sipa_web.recepciones set fecha='$fecha',peso_neto='".$peso_recep."',observacion='".$unidades[$clave]."' where lote='".$lote_ventana[$clave]."' and recargo='".$recargo[$clave]."'";
					mysqli_query($link, $Actualizar);
				//	echo " A 2 ".$Actualizar."<br>";
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
						$Actualizo = "Update sea_web.hornadas set unidades = $fila[unid], peso_unidades = $fila[pes] WHERE cod_producto = 17 AND hornada_ventana = $hornadas";
						mysqli_query($link, $Actualizo);
					//	echo " A 3 ".$Actualizo."<br>";
					}
				} 
				else
				{
					$Insertar2 = "INSERT INTO sea_web.hornadas";
					$Insertar2 = "$Insertar2 (cod_producto,cod_subproducto,hornada_ventana,unidades,peso_unidades)";			
					$Insertar2 = "$Insertar2 VALUES(17,$producto[$clave],$hornadas,$unidades[$clave],$peso_recep)";
					mysqli_query($link, $Insertar2);
					RegistroActividad("Inserta Hornada para guia $guia[$clave];  Recargo:$recargo[$clave] ;Lote V:$lote_ventana[$clave]; hornada: $hornadas; fecha mov.:$fecha ; Unidades : $unidades[$clave]; Peso :$peso_recep ");
		
				}
		}
	}
}
if ($Proceso == 'CL')//CERRAR LOTE
{
	$Actualizar="UPDATE sea_web.recepcion_externa_anglo set estado='C'";
	$Actualizar.=" where cod_producto='17' and cod_subproducto='$SubProducto' and lote_ventana='$LoteVentana' and guia='$Guia' ";
	mysqli_query($link, $Actualizar);
	RegistroActividad("Cierra LOTE  Movimiento para guia $Guia; Lote V: $LoteVentana;");
		
}
if ($Proceso == 'CT')//CERRAR ANGLO Y TRASPASAR AL MES SIGUIENTE
{
	$Actualizar="UPDATE sea_web.recepcion_externa_anglo set peso='$PesoR',piezas='$UnidR',estado='C'";
	$Actualizar.=" where cod_producto='17' and cod_subproducto='$SubProducto' and lote_ventana='$LoteVentana' and guia='$Guia' ";
	mysqli_query($link, $Actualizar);
	$NuevoPeso=intval($PesoO)-intval($PesoR);
	$NuevaUnid=intval($UnidO)-intval($UnidR);
	$Consulta = "SELECT * from sea_web.recepcion_externa_anglo where lote_origen='".str_replace('-','',$LoteOrigen)."' and substring(fecha,1,7)='".date('Y')."-".str_pad(date('m'),2,'0',STR_PAD_LEFT)."'";
	$RespAux = mysqli_query($link, $Consulta);
	if(!$FilaAux=mysqli_fetch_array($RespAux))
	{
		//OBTENER LOTE SIPA "PROCESO I<br>";
		$AnoMes = substr(date('Y'),2,2).str_pad(date('m'),2,'0',STR_PAD_LEFT);
		$Consulta = "SELECT ifnull(max(lote)+1,'".$AnoMes."0001') as lote_nuevo from sipa_web.correlativo_lote where cod_proceso='R' and lote like '".$AnoMes."%'";
		$RespLote=mysqli_query($link, $Consulta);
		$FilaLote=mysqli_fetch_array($RespLote);
		$LoteVentana = str_pad($FilaLote[lote_nuevo],8,"0",STR_PAD_LEFT);
		$Actualizar = "UPDATE sipa_web.correlativo_lote set lote='".$LoteVentana."' where cod_proceso='R'";
		mysqli_query($link, $Actualizar);	
		
		$Consulta = "SELECT IFNULL(MAX(ciclo),0) AS ciclo FROM sea_web.relaciones WHERE cod_origen = 3";
		$RespAux = mysqli_query($link, $Consulta);
		$FilaAux=mysqli_fetch_array($RespAux);
		$CicloAux = $FilaAux[ciclo];
		$Consulta = "SELECT MAX(hornada_ventana) AS hornada_max FROM sea_web.relaciones";
		$Consulta.=" WHERE cod_origen = 3 AND ciclo = ".$CicloAux;
		$RespAux = mysqli_query($link, $Consulta);
		$FilaAux=mysqli_fetch_array($RespAux);
		if(is_null($FilaAux[hornada_max])||(substr($FilaAux[hornada_max],6,3) == "999"))
		//if(substr($FilaAux[hornada_max],6,3) = "999")
		{
			$Consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2005 AND cod_subclase = 2";
			$RespAux = mysqli_query($link, $Consulta);
			$FilaAux=mysqli_fetch_array($RespAux);
			$Hornada = $FilaAux[valor_subclase];
		}	
		else
			$Hornada = substr(($FilaAux[hornada_max] + 1), 6, 6);
		$Hornada = date('Y').str_pad(date('m'),2,"0",STR_PAD_LEFT).$Hornada;
		$Consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2005 AND cod_subclase = 2";
		$RespAux = mysqli_query($link, $Consulta);
		$FilaAux=mysqli_fetch_array($RespAux);
		if (substr($Hornada, 6, 4) == $FilaAux["valor_subclase1"])
			$Ciclo = $CicloAux + 1;
		else
			$Ciclo = $CicloAux;
		$Insertar = "INSERT INTO sea_web.relaciones (cod_origen,lote_ventana,lote_origen,hornada_ventana,marca,ciclo)";
		$Insertar.=" VALUES (3,'".$LoteVentana."','".$LoteOrigen."',".$Hornada;
		$Insertar.=",'".substr($Marca, 0, 2)."',".$Ciclo.")";
		mysqli_query($link, $Insertar);
	
		$Insertar = "insert into sea_web.recepcion_externa_anglo(guia,cod_producto,cod_subproducto,lote_origen,lote_ventana,peso,peso_recep,piezas,piezas_recep,marca,fecha,estado,fecha_guia) values('".$Guia."','17','3','".str_replace('-','',$LoteOrigen)."','".$LoteVentana."',";
		$Insertar.= "'".$NuevoPeso."',0,'".$NuevaUnid."','0','".substr($Marca, 0, 2)."','".date('Y-m-d')."','','".$FechaGuia."')";
		mysqli_query($link, $Insertar);

		$Consulta = "SELECT ifnull(max(correlativo)+1,1) as correlativo from sipa_web.recepciones";
		$RespCorr = mysqli_query($link, $Consulta);
		$FilaCorr=mysqli_fetch_array($RespCorr);
		$Corr = $FilaCorr[correlativo];
		
		$Insertar = "insert into sipa_web.recepciones (correlativo,lote,recargo,ult_registro,rut_operador,bascula_entrada,bascula_salida,fecha,";
		$Insertar.="rut_prv,cod_mina,cod_grupo,cod_producto,cod_subproducto,guia_despacho,patente,cod_clase,conjunto,observacion,tipo) values(";
		$Insertar.="'".$Corr."','".$LoteVentana."','1','N','9999999-9','0','0','".date('Y-m-d')."',";
		$Insertar.="'77762940-9','05506.0003-5','2','1','17',";
		$Insertar.="'".$Guia."','','M','','','A')";
		mysqli_query($link, $Insertar);
		RegistroActividad("Cierra LOTE Y PASA A MES SIGUIENTE  para guia $Guia; Lote V: $LoteVentana; Lote Origen: $LoteOrigen ; Hornada :$Hornada;");

	}
	else
	{
		//echo "PROCESO II<br>";
		$LoteVentana = $FilaAux[lote_ventana];
		$Consulta = "SELECT * from sea_web.recepcion_externa_anglo where guia='".$Guia."' and lote_origen='".str_replace('-','',$LoteOrigen)."'";
		$RespAux = mysqli_query($link, $Consulta);
		if($Fila=mysqli_fetch_array($RespAux))
		{
			$Insertar = "insert into sea_web.recepcion_externa_anglo(guia,cod_producto,cod_subproducto,lote_origen,lote_ventana,peso,peso_recep,piezas,piezas_recep,marca,fecha,estado,fecha_guia) values('".$Guia."','17','3','".str_replace('-','',$LoteOrigen)."','".$LoteVentana."',";
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
			$Insertar.="'77762940-9','05506.0003-5','2','1','17',";
			$Insertar.="'".$Guia."','','M','','','A')";
			mysqli_query($link, $Insertar);
			RegistroActividad("Cierra LOTE Y PASA A MES SIGUIENTE  para guia $Guia; Lote V: $LoteVentana; Lote Origen: $LoteOrigen ; Hornada :$Hornada;");

		}
	}	
}

if ($Proceso == 'EL')//ELIMINAR LOTE
{
	$Eliminar="delete from sea_web.recepcion_externa_anglo ";
	$Eliminar.=" where cod_producto='17' and cod_subproducto='$SubProducto' and lote_ventana='$LoteVentana' and guia='$Guia'";
	mysqli_query($link, $Eliminar);
	
	$Consulta="SELECT * from sea_web.recepcion_externa_anglo where cod_producto='17' and cod_subproducto='$SubProducto' ";
	$Consulta.="and guia='$Guia'";
	$RespDetalle=mysqli_query($link, $Consulta);
	if(!$FilaDetalle=mysqli_fetch_array($RespDetalle))
	{
		$Eliminar="delete from sea_web.recepcion_externa_detalle_anglo ";
		$Eliminar.=" where guia='$Guia'";
		mysqli_query($link, $Eliminar);
	}
	$Eliminar="delete from sea_web.recepcion_externa_anglo ";
	$Eliminar.=" where cod_producto='17' and cod_subproducto='$SubProducto' and lote_ventana='$LoteVentana' and guia='$Guia'";
	mysqli_query($link, $Eliminar);

	$Eliminar="delete from sipa_web.recepciones ";
	$Eliminar.=" where lote='$LoteVentana' and recargo='$Rec' and guia_despacho='$Guia'";
	mysqli_query($link, $Eliminar);
	RegistroActividad("Elimina Lote para guia $guia[$clave];  Recargo:$recargo[$clave] ;Lote V: $lote_ventana; hornada: $hornadas; fecha mov.:$fecha ; Unidades : $unidades[$clave]; Peso :$peso_recep ");
		
}
RecalcularSipa();
	$valores = 'Mostrar=S&Est=A'.'&ano='.$ano.'&mes='.$mes.'&dia='.$dia.'&proveedor='.$proveedor; 
	header("Location:sea_ing_recep_inter_anglo.php?".$valores);
	include("../principal/cerrar_sea_web.php");		

function RecalcularSipa()
{
	$FechaAMD=date("Y-m-d");
  $Consulta = "SELECT * from sea_web.recepcion_externa_anglo where estado not in ('C','X') and peso<>peso_recep";
  $RespAux = mysqli_query($link, $Consulta);
		while($Fila=mysqli_fetch_array($RespAux))
		{
 
        $Consulta2 = "SELECT * from sipa_web.recepciones where lote='".$Fila["lote_ventana"]."' and peso_neto<>'0' ";// and fecha <> '".$FechaAMD."'";
      	$RespAux2 = mysqli_query($link, $Consulta2);
		if($Fila2=mysqli_fetch_array($RespAux2))
		{
 
            $Consulta3 = "SELECT  * from sipa_web.recepciones where lote ='".$Fila["lote_ventana"]."' and peso_neto=0 and guia_despacho='".$Fila["lote_ventana"]."'";
            $RespAux3 = mysqli_query($link, $Consulta3);
			if(!$Fila3=mysqli_fetch_array($RespAux3))
			{
                $ConsultaRecar = "SELECT  max(lpad(recargo,2,'0'))+1 as recargo_nuevo from sipa_web.recepciones where lote ='".$Fila["lote_ventana"]."' group by lote";
                $RespConsultaRecar = mysqli_query($link, $ConsultaRecar);
				if($FilaConsultaRecar=mysqli_fetch_array($RespConsultaRecar))
				{ 
					$Rec = $FilaConsultaRecar["recargo_nuevo"];
				}
				$ConsultaRecar = "SELECT ifnull(max(correlativo)+1,1) as correlativo from sipa_web.recepciones";
                $RespConsultaRecar = mysqli_query($link, $ConsultaRecar);
				if($FilaConsultaRecar=mysqli_fetch_array($RespConsultaRecar))
				{ 
					$Corr = $FilaConsultaRecar["correlativo"];
				}
				$Insertar= "insert into sipa_web.recepciones (correlativo,lote,recargo,ult_registro,rut_operador,bascula_entrada,bascula_salida,fecha,";
				$Insertar.= "rut_prv,cod_mina,cod_grupo,cod_producto,cod_subproducto,guia_despacho,patente,cod_clase,conjunto,observacion,tipo) values(";
				$Insertar.= "'".$Corr."','".$Fila["lote_ventana"]."','".$Rec."','N','9999999-9','0','0','".$FechaAMD."',";
				$Insertar.= "'77762940-9','05506.0003-5','2','1','17',";
				$Insertar.= "'".$Fila["guia"]."','','M','','','A')";
				mysqli_query($link, $Insertar);
			}
		}
		}
		
				
}


?>

