<table width="850" border="1" align="center" cellpadding="2" cellspacing="0">
<tr class="ColorTabla01">
	<td align="center">Producto</td>
	<td align="center">Sub-Producto</td>
	<td align="center">ID. Muestra</td> 
	<td align="center"><a href="JavaScript:Proceso('O','F');" class="LinksBlancoRaya">Fec.Muestra.</a></td>
	<td>Recep.Mue</td>
	<td>Recep.Lab</td>
	<td align="center">Finaliz.</td>
	<td><a href="JavaScript:Proceso('O','S');" class="LinksBlancoRaya">Solicitud</a></td> 
	<td>Est</td>
</tr>		

<?php
	$FecIni = $Ano."-".str_pad($Mes,2,'0',STR_PAD_LEFT)."-01 00:00:00";
	$FecFin = $Ano."-".str_pad($Mes,2,'0',STR_PAD_LEFT)."-31 23:59:59";

	//CONSULTA LOS DISTINTOS PRODUCTOS Y PROVEEDORES CON MUESTRA PARALELA
	$Consulta = "select STRAIGHT_JOIN  distinct t1.cod_producto, t1.cod_subproducto, t1.id_muestra,t1.rut_proveedor,t1.nro_solicitud,t3.descripcion as nom_subprd,t4.descripcion as nom_prod,t1.estado_actual,t1.fecha_muestra ";
	if($Ano<2009 && $Ano>0)
		$Consulta.= " from cal_histo.solicitud_analisis_a_".$Ano." t1 ";
		else
		$Consulta.= " from cal_web.solicitud_analisis t1 ";
	$Consulta.= " left join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='1002' and t1.estado_actual=t2.cod_subclase ";
	$Consulta.= " left join proyecto_modernizacion.subproducto t3";
	if($CmbProductos!='S')
		$Consulta.= " on t3.cod_producto='".$CmbProductos."' and t3.cod_subproducto=t1.cod_subproducto ";
	else
		$Consulta.= " on t3.cod_producto<>'1' and t3.cod_subproducto=t1.cod_subproducto ";	
	$Consulta.= " left join proyecto_modernizacion.productos t4 on t4.cod_producto=t1.cod_producto ";
	$Consulta.= " where t1.nro_solicitud<>'' and t1.cod_producto<>'1' and t1.estado_actual not in ('7','16') and t1.fecha_hora between '".$FecIni."' and '".$FecFin."' ";
	if ($CmbProductos!="S")
		$Consulta.= " and t1.cod_producto='".$CmbProductos."'";
	if ($CmbSubProducto!="S")
		$Consulta.= " and t1.cod_subproducto='".$CmbSubProducto."'";
	if ($CmbProductos=="1")
	{		
		if ($Proveedor!="S")
			$Consulta.= " and t1.rut_proveedor='".$Proveedor."'";		
	}	
	if ($CmbEstado!="S")
		$Consulta.= " and t1.estado_actual='".$CmbEstado."' ";
	switch ($Orden)
	{
		case "F"://POR FECHA MUESTRA
			$Consulta.= " order by t1.fecha_muestra ";
			break;
		case "S"://POR SOLICITUD
			$Consulta.= " order by t1.nro_solicitud ";
			break;
		default:
			$Consulta.= " order by t1.cod_producto,t1.cod_subproducto,t1.id_muestra ";
			break;
	}	
	$Resp = mysqli_query($link, $Consulta);
	$ContSA=0;
	$ContLotes=0;
	$ContSA_Fin=0;
	//echo $Consulta;
	while ($Fila = mysqli_fetch_array($Resp))
	{
		//SOLICITUD DEL LOTE
		$Consulta = "select STRAIGHT_JOIN distinct t1.nro_solicitud ,t1.recargo , t1.estado_actual, t2.nombre_subclase";
		if($Ano<2009 && $Ano>0)
			$Consulta.= " from cal_histo.solicitud_analisis_a_".$Ano." t1 ";
			else
			$Consulta.= " ,t1.nro_sa_lims from cal_web.solicitud_analisis t1 ";
		$Consulta.= " inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='1002' and t2.cod_subclase=t1.estado_actual  ";
		$Consulta.= " where t1.nro_solicitud='".$Fila["nro_solicitud"]."' and t1.estado_actual not in ('7','16')";			
		$RespAux = mysqli_query($link, $Consulta);
		if ($FilaAux=mysqli_fetch_array($RespAux))
		{


			if ($FilaAux["nro_sa_lims"]=='') {
				$SA=$FilaAux["nro_solicitud"];
				$SALims='';
			}else{
				$SA=$FilaAux["nro_solicitud"];
				$SALims=$FilaAux["nro_sa_lims"];
			}


			//$SA=$FilaAux["nro_solicitud"];
			$Recargo=$FilaAux["recargo"];
			$EstadoSA=$FilaAux["nombre_subclase"];
			$CodEstadoSA=$FilaAux["estado_actual"];
		}
		else
		{
			$SA="";
			$Recargo="";
			$EstadoSA="";
			$CodEstadoSA="";
		}
		
		//FECHA RECEPCION DE MUESTREO
		$Consulta = "select * ";
		if($Ano<2009 && $Ano>0)
			$Consulta.= " from cal_histo.estados_por_solicitud_a_".$Ano." t1 ";
			else
			$Consulta.= " from cal_web.estados_por_solicitud t1 ";
		$Consulta.= " where t1.nro_solicitud = '".$SA."' ";			
		$Consulta.= " and t1.cod_estado='2' "; //RECEPCIONADO muestrera	
		$RespAux1 = mysqli_query($link, $Consulta);
		if ($FilaAux1=mysqli_fetch_array($RespAux1))
		{
			$FechaRecepMuest=$FilaAux1["fecha_hora"];
		}
		else
		{
			$FechaRecepMuest="";
		}		

		//FECHA RECEPCION LABORATORIO
		$Consulta = "select * ";
		if($Ano<2009 && $Ano>0)
			$Consulta.= " from cal_histo.estados_por_solicitud_a_".$Ano." t1 ";
			else
			$Consulta.= " from cal_web.estados_por_solicitud t1 ";
		$Consulta.= " where t1.nro_solicitud = '".$SA."' ";			
		$Consulta.= " and t1.cod_estado='4' "; //RECEPCIONADO LABORATORIO	
		$RespAux = mysqli_query($link, $Consulta);
		if ($FilaAux=mysqli_fetch_array($RespAux))
		{
			$FechaRecepLab=$FilaAux["fecha_hora"];
		}
		else
		{
			$FechaRecepLab="";
		}		
		
		//CALCULA SI TODAS SUS SOLICITUDES ESTAN FINALIZADAS SA, RETALLA, PARALELA
		//FECHA FINALIZADA SA
		$FechaFinalizSA="";
		$FechaFinalizRetalla="";
		$FechaFinalizParalela="";
		$Consulta = "select * ";
		if($Ano<2009 && $Ano>0)
			$Consulta.= " from cal_histo.estados_por_solicitud_a_".$Ano." t1 ";
			else
			$Consulta.= " from cal_web.estados_por_solicitud t1 ";
		$Consulta.= " where t1.nro_solicitud = '".$SA."' ";			
		$Consulta.= " and t1.cod_estado='6' "; //RECEPCIONADO LABORATORIO	
		$RespAux = mysqli_query($link, $Consulta);
		if ($FilaAux=mysqli_fetch_array($RespAux))
		{
			$FechaFinaliz=$FilaAux["fecha_hora"];
		}
		else
		{
			$FechaFinaliz="";
		}		
		//------------------------------------------------------
		echo "<tr align=\"center\">\n";
		echo "<td align=\"left\">".substr($Fila["nom_prod"],0,20)."&nbsp;</td>\n";
		echo "<td align=\"left\">".substr($Fila["nom_subprd"],0,20)."&nbsp;</td>\n";
		echo "<td align='left'>".$Fila["id_muestra"]."</td>\n";
		echo "<td>".substr($Fila["fecha_muestra"],8,2)."/".substr($Fila["fecha_muestra"],5,2)."/".substr($Fila["fecha_muestra"],0,4)." ".substr($Fila["fecha_muestra"],10,6)."</td>\n";
		//fecha recepcion muestrera
		
		if ($FechaRecepMuest=="")
		
			echo "<td>&nbsp;</td>\n";
		else
			echo "<td>".substr($FechaRecepMuest,8,2)."/".substr($FechaRecepMuest,5,2)."/".substr($FechaRecepMuest,0,4)." ".substr($FechaRecepMuest,10,6)."</td>\n";

		if ($FechaRecepLab=="")
			echo "<td>&nbsp;</td>\n";
		else
			echo "<td>".substr($FechaRecepLab,8,2)."/".substr($FechaRecepLab,5,2)."/".substr($FechaRecepLab,0,4)." ".substr($FechaRecepLab,10,6)."</td>\n";
		if ($FechaFinaliz=="")
			echo "<td>&nbsp;</td>\n";
		else
			echo "<td>".substr($FechaFinaliz,8,2)."/".substr($FechaFinaliz,5,2)."/".substr($FechaFinaliz,0,4)." ".substr($FechaFinaliz,10,6)."</td>\n";
			
		if 	($SA=="")
			echo "<td>&nbsp;</td>\n";		
		else
		{
			if ($SA!=""){

				if ($SALims!='') {
					echo "<td><a href=\"JavaScript:Historial('".$SA."','".$Recargo."')\" class=\"LinksAzul\">".$SALims."</a></td>\n";
				}else{
					echo "<td><a href=\"JavaScript:Historial('".$SA."','".$Recargo."')\" class=\"LinksAzul\">".substr($SA,4)."</a></td>\n";
				}
			}


				//echo "<td><a href=\"JavaScript:Historial('".$SA."','".$Recargo."')\" class=\"LinksAzul\">".substr($SA,4)."</a></td>\n";
		}			
		if ($CodEstadoSA!=6 && $EstadoSA!="")
			echo "<td bgcolor='yellow'><a href=\"JavaScript:DetalleAnalisis('".$SA."','".$Recargo."')\" class=\"LinksAzul\">".substr($EstadoSA,0,3)."</a>&nbsp;</td>\n";
		else
		{
			if ($EstadoSA!="")
				echo "<td bgcolor='#FFFFFF'>".substr($EstadoSA,0,3)."&nbsp;</td>\n";
			else
				echo "<td>&nbsp;</td>\n";
		}
		echo "</tr>\n";
		$ContLotes++;
		if ($Fila["nro_solicitud"]!="")
			$ContSA++;				
		if ($Fila["estado_actual"]=="6")
			$ContSA_Fin++;
	}
?>
	<tr align="center">
		<td colspan="12"><strong>TOTAL:&nbsp;&nbsp;<?php echo number_format($ContLotes,0,",","."); ?></strong> Registros con <strong><?php echo number_format($ContSA,0,",","."); ?></strong> Solicitudes y <strong><?php echo number_format($ContSA_Fin,0,",","."); ?></strong> Finalizadas </td>
		</tr>
</table>	  
