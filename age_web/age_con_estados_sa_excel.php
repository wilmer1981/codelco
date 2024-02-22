<?php
	        ob_end_clean();
        $file_name=basename($_SERVER['PHP_SELF']).".xls";
        $userBrowser = $_SERVER['HTTP_USER_AGENT'];
		$filename="";
        if ( preg_match( '/MSIE/i', $userBrowser ) ) {
        $filename = urlencode($filename);
        }
        $filename = iconv('UTF-8', 'gb2312', $filename);
        $file_name = str_replace(".php", "", $file_name);
        header("<meta http-equiv='X-UA-Compatible' content='IE=Edge'>");
        header("<meta http-equiv='content-type' content='text/html;charset=uft-8'>");
        
        header("content-disposition: attachment;filename={$file_name}");
        header( "Cache-Control: public" );
        header( "Pragma: public" );
        header( "Content-type: text/csv" ) ;
        header( "Content-Dis; filename={$file_name}" ) ;
        header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	include("../principal/conectar_principal.php");
	if(isset($_REQUEST["Mostrar"])) {
		$Mostrar = $_REQUEST["Mostrar"];
	}else{
		$Mostrar = "";
	}
	if(isset($_REQUEST["Sistema"])) {
		$Sistema = $_REQUEST["Sistema"];
	}else{
		$Sistema = "";
	}
	if(isset($_REQUEST["ChkSolicitud"])) {
		$ChkSolicitud = $_REQUEST["ChkSolicitud"];
	}else{
		$ChkSolicitud = "S";
	}
	if(isset($_REQUEST["Mes"])) {
		$Mes = $_REQUEST["Mes"];
	}else{
		$Mes = date("m");
	}
	if(isset($_REQUEST["Ano"])) {
		$Ano = $_REQUEST["Ano"];
	}else{
		$Ano = date("Y");
	}
	if(isset($_REQUEST["SubProducto"])) {
		$SubProducto = $_REQUEST["SubProducto"];
	}else{
		$SubProducto ="";
	}
	if(isset($_REQUEST["Proveedor"])) {
		$Proveedor = $_REQUEST["Proveedor"];
	}else{
		$Proveedor ="";
	}
	if(isset($_REQUEST["CmbEstado"])) {
		$CmbEstado = $_REQUEST["CmbEstado"];
	}else{
		$CmbEstado ="";
	}
	if(isset($_REQUEST["TxtFiltroPrv"])) {
		$TxtFiltroPrv = $_REQUEST["TxtFiltroPrv"];
	}else{
		$TxtFiltroPrv ="";
	}
	if(isset($_REQUEST["Orden"])) {
		$Orden = $_REQUEST["Orden"];
	}else{
		$Orden ="";
	}
	if(isset($_REQUEST["Busq"])) {
		$Busq = $_REQUEST["Busq"];
	}else{
		$Busq ="";
	}



?>
<html>
<head>
<title>AGE-Consulta Comparacion Muestra Paralela</title>

</head>

<body leftmargin="3" topmargin="5">
<form name="frmPrincipal" action="" method="post">
<input type="hidden" name="Valores" value="">
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td width="762" height="313" align="center" valign="top">        <br>
        <table width="750" border="1" align="center" cellpadding="2" cellspacing="0">
		<tr class="ColorTabla01">
			<td>Producto</a></td>
			<td>Proveedor</a></td>
			<td>Lote</a></td> 
			<td>Recep.Lote</td>
			<td>Recep.Mue</td>
			<td>Recep.Lab</td>
			<td>Finaliz</td>
			<td>Solicitud</td> 
			<td>Estado</td>
			<td>Retalla</td> 
			<td>Estado</td>
			<td>Paralela</td>
			<td>Estado</td>			
		</tr>		
<?php		
$ContLotes=0;
$ContSA=0;
$ContSA_Fin=0;	

if ($Mostrar=="S")
{
	if ($Ano<2006)
	{
		$LoteIni = substr($Ano,3,1).str_pad($Mes,2,'0',STR_PAD_LEFT)."000";
		$LoteFin = substr($Ano,3,1).str_pad($Mes,2,'0',STR_PAD_LEFT)."999";
	}
	else
	{
		$LoteIni = substr($Ano,2,2).str_pad($Mes,2,'0',STR_PAD_LEFT)."0000";
		$LoteFin = substr($Ano,2,2).str_pad($Mes,2,'0',STR_PAD_LEFT)."9999";
	}
	//CONSULTA LOS DISTINTOS PRODUCTOS Y PROVEEDORES CON MUESTRA PARALELA
	$Consulta = "select distinct t1.cod_producto, t1.cod_subproducto,t1.lote, t1.muestra_paralela, t1.rut_proveedor, t3.nomprv_a, ";
	$Consulta.= " t4.nro_solicitud, t4.estado_actual, t5.nombre_subclase as estado, t6.abreviatura as nom_prod, ";
	$Consulta.= " t1.fecha_recepcion ";
	$Consulta.= " from age_web.lotes t1 ";
	$Consulta.= " left join rec_web.proved t3 on t1.rut_proveedor=t3.rutprv_a  ";
	$Consulta.= " left join cal_web.solicitud_analisis t4 on t1.lote=t4.id_muestra  ";
	$Consulta.= " left join proyecto_modernizacion.sub_clase t5 on t5.cod_clase='1002' and t4.estado_actual=t5.cod_subclase ";
	$Consulta.= " left join proyecto_modernizacion.subproducto t6 on t6.cod_producto='1' and t6.cod_subproducto=t1.cod_subproducto ";
	$Consulta.= " where t1.lote between '".$LoteIni."' and '".$LoteFin."'  and t4.estado_actual not in ('7','16')";
	if ($SubProducto!="S")
		$Consulta.= " and t1.cod_producto='1' and t1.cod_subproducto='".$SubProducto."'";
	if ($Proveedor!="S")
		$Consulta.= " and t1.rut_proveedor='".$Proveedor."'";		
	$Consulta.= " and (t4.recargo='0' or t4.recargo='' or isnull(t4.recargo)) ";	
	if ($CmbEstado!="S")
		$Consulta.= " and t4.estado_actual='".$CmbEstado."' ";	
	switch ($Orden)
	{
		case "L":
			$Consulta.= " order by t1.lote ";
			break;
		case "S":
			$Consulta.= " order by t4.nro_solicitud ";
			break;
		case "PD":
			$Consulta.= " order by lpad(t1.cod_subproducto,4,'0'), lpad(t1.rut_proveedor,11,'0'), t1.lote ";
			break;
		case "PV":
			$Consulta.= " order by lpad(t1.rut_proveedor,11,'0'), t1.lote ";
			break;
		case "FR":
			$Consulta.= " order by t1.fecha_recepcion, t1.lote ";
			break;
		default:
			$Consulta.= " order by lpad(t1.cod_subproducto,4,'0'), lpad(t1.rut_proveedor,11,'0'), t1.lote ";
			break;
	}	
	$Resp = mysqli_query($link, $Consulta);
	//echo $Consulta;
	$ContSA=0;
	$ContLotes=0;
	$ContSA_Fin=0;
	while ($Fila = mysqli_fetch_array($Resp))
	{
		//SOLICITUD DEL LOTE
		$Consulta = "select distinct t2.nro_solicitud ,t2.recargo , t2.estado_actual, t3.nombre_subclase";
		$Consulta.= " from age_web.lotes t1 ";
		$Consulta.= " inner join cal_web.solicitud_analisis t2 on t1.lote=t2.id_muestra  ";
		$Consulta.= " inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='1002' and t3.cod_subclase=t2.estado_actual  ";
		$Consulta.= " where t1.lote = '".$Fila["lote"]."' and t2.estado_actual not in ('7','16')";			
		$Consulta.= " and (t2.recargo='0' or t2.recargo='') ";	
		$RespAux = mysqli_query($link, $Consulta);
		if ($FilaAux=mysqli_fetch_array($RespAux))
		{
			$SA=$FilaAux["nro_solicitud"];
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
		
		//fecha recep.muestrera (poly)
		$Consulta = "select * ";
		$Consulta.= " from cal_web.estados_por_solicitud t1 ";
		$Consulta.= " where t1.nro_solicitud = '".$SA."' ";			
		$Consulta.= " and t1.recargo='".$Recargo."' ";	
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
		$Consulta.= " from cal_web.estados_por_solicitud t1 ";
		$Consulta.= " where t1.nro_solicitud = '".$SA."' ";			
		$Consulta.= " and t1.recargo='".$Recargo."' ";	
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
		//RETALLA
		$Consulta = "select distinct t2.nro_solicitud, t2.estado_actual, t3.nombre_subclase";
		$Consulta.= " from age_web.lotes t1 ";
		$Consulta.= " inner join cal_web.solicitud_analisis t2 on t1.lote=t2.id_muestra  ";
		$Consulta.= " inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='1002' and t3.cod_subclase=t2.estado_actual  ";
		$Consulta.= " where t1.lote = '".$Fila["lote"]."' ";			
		$Consulta.= " and t2.recargo='R' ";	
		$RespAux = mysqli_query($link, $Consulta);
		if ($FilaAux=mysqli_fetch_array($RespAux))
		{
			$SA_Retalla=$FilaAux["nro_solicitud"];
			$EstadoRetalla=$FilaAux["nombre_subclase"];
			$CodEstadoRetalla=$FilaAux["estado_actual"];
		}
		else
		{
			$SA_Retalla="";
			$EstadoRetalla="";
			$CodEstadoRetalla="";
		}
		//MUESTRA PARALELA
		$Consulta = "select distinct t2.nro_solicitud, t2.estado_actual, t3.nombre_subclase";
		$Consulta.= " from age_web.lotes t1 ";
		$Consulta.= " inner join cal_web.solicitud_analisis t2 on t1.muestra_paralela=t2.id_muestra    and year(t1.fecha_recepcion)=year(t2.fecha_muestra) ";
		$Consulta.= " inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='1002' and t3.cod_subclase=t2.estado_actual  ";
		$Consulta.= " where t1.lote = '".$Fila["lote"]."' ";			
		$Consulta.= " and (t2.recargo='0' or t2.recargo='' or isnull(t2.recargo)) ";	
		$RespAux = mysqli_query($link, $Consulta);
		if ($FilaAux=mysqli_fetch_array($RespAux))
		{
			$SA_Paralela=$FilaAux["nro_solicitud"];
			$EstadoParalela=$FilaAux["nombre_subclase"];
			$CodEstadoParalela=$FilaAux["estado_actual"];
		}
		else
		{
			$SA_Paralela="";
			$EstadoParalela="";
			$CodEstadoParalela="";
		}
		//CALCULA SI TODAS SUS SOLICITUDES ESTAN FINALIZADAS SA, RETALLA, PARALELA
		//FECHA FINALIZADA SA
		$FechaFinalizSA="";
		$FechaFinalizRetalla="";
		$FechaFinalizParalela="";
		$Consulta = "select * ";
		$Consulta.= " from cal_web.estados_por_solicitud t1 ";
		$Consulta.= " where t1.nro_solicitud = '".$SA."' ";			
		$Consulta.= " and t1.recargo='".$Recargo."' ";	
		$Consulta.= " and t1.cod_estado='6' "; //RECEPCIONADO LABORATORIO	
		$RespAux = mysqli_query($link, $Consulta);
		if ($FilaAux=mysqli_fetch_array($RespAux))
		{
			$FechaFinalizSA=$FilaAux["fecha_hora"];
		}		
		//FECHA FINALIZADA RETALLA
		$Consulta = "select * ";
		$Consulta.= " from cal_web.estados_por_solicitud t1 ";
		$Consulta.= " where t1.nro_solicitud = '".$SA_Retalla."' ";			
		$Consulta.= " and t1.recargo='R' ";	
		$Consulta.= " and t1.cod_estado='6' "; //RECEPCIONADO LABORATORIO	
		$RespAux = mysqli_query($link, $Consulta);
		if ($FilaAux=mysqli_fetch_array($RespAux))
		{
			$FechaFinalizRetalla=$FilaAux["fecha_hora"];
		}		
		//FECHA FINALIZADA PARALELA
		$Consulta = "select * ";
		$Consulta.= " from cal_web.estados_por_solicitud t1 ";
		$Consulta.= " where t1.nro_solicitud = '".$SA_Paralela."' ";			
		$Consulta.= " and (t1.recargo='' or t1.recargo='0')";	
		$Consulta.= " and t1.cod_estado='6' "; //RECEPCIONADO LABORATORIO	
		$RespAux = mysqli_query($link, $Consulta);
		if ($FilaAux=mysqli_fetch_array($RespAux))
		{
			$FechaFinalizParalela=$FilaAux["fecha_hora"];
		}		
		$FechaFinaliz="";
		if ($SA_Retalla=="" && $SA_Paralela=="")
		{
			if ($CodEstadoSA=="6")
				$FechaFinaliz=$FechaFinalizSA;
		}
		else
		{
			if ($SA!="" && $SA_Retalla!="" && $SA_Paralela=="")
			{
				if ($CodEstadoSA=="6" && $CodEstadoRetalla=="6")
				{			
					if ($FechaFinalizRetalla > $FechaFinalizSA)
						$FechaFinaliz=$FechaFinalizRetalla;
					else
						$FechaFinaliz=$FechaFinalizSA;
				}
			}
			else
			{
				if ($CodEstadoSA=="6" && $CodEstadoRetalla=="6" && $CodEstadoParalela=="6")
				{					
					if ($FechaFinalizRetalla > $FechaFinalizSA)
					{
						if ($FechaFinalizParalela > $FechaFinalizRetalla)	
							$FechaFinaliz=$FechaFinalizParalela;
						else
							$FechaFinaliz=$FechaFinalizRetalla;
					}
					else
					{
						if ($FechaFinalizParalela > $FechaFinalizSA)
							$FechaFinaliz=$FechaFinalizParalela;
						else
							$FechaFinaliz=$FechaFinalizSA;
					}					
				}				
			}
		}
		//------------------------------------------------------
		echo "<tr align=\"center\">\n";
		echo "<td align=\"left\">".substr($Fila["nom_prod"],0,20)."&nbsp;</td>\n";
		echo "<td align=\"left\">".substr($Fila["nomprv_a"],0,20)."&nbsp;</td>\n";
		echo "<td>".$Fila["lote"]."</td>\n";
		echo "<td>".substr($Fila["fecha_recepcion"],8,2)."/".substr($Fila["fecha_recepcion"],5,2)."/".substr($Fila["fecha_recepcion"],2,2)."</td>\n";
				//fecha recepcion muestrera
		if ($FechaRecepMuest=="")
			echo "<td>&nbsp;</td>\n";
		else
			echo "<td>".substr($FechaRecepMuest,8,2)."/".substr($FechaRecepMuest,5,2)."/".substr($FechaRecepMuest,2,2)."</td>\n";
		if ($FechaRecepLab=="")
			echo "<td>&nbsp;</td>\n";
		else
			echo "<td>".substr($FechaRecepLab,8,2)."/".substr($FechaRecepLab,5,2)."/".substr($FechaRecepLab,2,2)."</td>\n";
		if ($FechaFinaliz=="")
			echo "<td>&nbsp;</td>\n";
		else
			echo "<td>".substr($FechaFinaliz,8,2)."/".substr($FechaFinaliz,5,2)."/".substr($FechaFinaliz,2,2)."</td>\n";

		if 	($SA=="")
			echo "<td>&nbsp;</td>\n";		
		else
		{
			if ($SA!="")
				echo "<td>".substr($SA,4)."</td>\n";
		}			
		if ($CodEstadoSA!=6 && $EstadoSA!="")
			echo "<td bgcolor='yellow'>".substr($EstadoSA,0,3)."&nbsp;</td>\n";
		else
		{
			if ($EstadoSA!="")
				echo "<td bgcolor='#FFFFFF'>".substr($EstadoSA,0,3)."&nbsp;</td>\n";
			else
				echo "<td>&nbsp;</td>\n";
		}
		if 	($SA_Retalla=="")
			echo "<td>&nbsp;</td>\n";		
		else
			echo "<td>".substr($SA_Retalla,4)."</td>\n";
		if ($CodEstadoRetalla!=6 && $EstadoRetalla!="")
			echo "<td bgcolor='yellow'>".substr($EstadoRetalla,0,3)."&nbsp;</td>\n";
		else
			echo "<td>".substr($EstadoRetalla,0,3)."&nbsp;</td>\n";
		if 	($SA_Paralela=="")
			echo "<td>&nbsp;</td>\n";		
		else
			echo "<td>".substr($SA_Paralela,4)."</td>\n";
		if ($CodEstadoParalela!=6 && $EstadoParalela!="")
			echo "<td bgcolor='yellow'>".substr($EstadoParalela,0,3)."&nbsp;</td>\n";
		else
			echo "<td>".substr($EstadoParalela,0,3)."&nbsp;</td>\n";
		echo "</tr>\n";
		$ContLotes++;
		if ($Fila["nro_solicitud"]!="")
			$ContSA++;				
		if ($Fila["estado_actual"]=="6")
			$ContSA_Fin++;
	}
}//FIN MOSTRAR = S	
?>
	<tr align="center">
		<td colspan="12"><strong>TOTAL:&nbsp;&nbsp;<?php echo number_format($ContLotes,0,",","."); ?></strong> Lotes con <strong><?php echo number_format($ContSA,0,",","."); ?></strong> Solicitudes y <strong><?php echo number_format($ContSA_Fin,0,",","."); ?></strong> Finalizadas </td>
		</tr>
</table>	  
        <blockquote>
          <p><br>
            <br>
          </p>
      </blockquote></td></tr>
</table>
</form>
</body>
</html>
