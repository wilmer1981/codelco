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
	$CodigoDeSistema = 15;
	$CodigoDePantalla = 37;
	include("../principal/conectar_principal.php");
	include("age_funciones.php");

	$Mostrar    = isset($_REQUEST["Mostrar"])?$_REQUEST["Mostrar"]:"";
	$Mes        = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("m");
	$Ano        = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");
	$SubProducto  = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";
	$Proveedor    = isset($_REQUEST["Proveedor"])?$_REQUEST["Proveedor"]:"";
	$CmbPlantilla     = isset($_REQUEST["CmbPlantilla"])?$_REQUEST["CmbPlantilla"]:"";
	$Busq             = isset($_REQUEST["Busq"])?$_REQUEST["Busq"]:"";
	$TxtFiltroPrv     = isset($_REQUEST["TxtFiltroPrv"])?$_REQUEST["TxtFiltroPrv"]:"";
	
?>
<html>
<head>
<title>AGE-Consulta Comparacion Muestra Paralela</title>
</head>

<body leftmargin="3" topmargin="5">
<form name="frmPrincipal" action="" method="post">
<input type="hidden" name="Valores" value="">
<br>
        <br>
        <table width="750" border="1" align="center" cellpadding="2" cellspacing="0">
<?php		
		
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
	$Consulta = "select distinct t1.cod_producto, t1.cod_subproducto, t1.rut_proveedor, t2.descripcion, t3.nomprv_a ";
	$Consulta.= " from age_web.lotes t1 inner join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto ";
	$Consulta.= " and t1.cod_subproducto=t2.cod_subproducto inner join rec_web.proved t3 on t1.rut_proveedor=t3.rutprv_a";
	$Consulta.= " where t1.lote between '".$LoteIni."' and '".$LoteFin."' ";
	$Consulta.= " and t1.muestra_paralela <>'' ";
	if ($SubProducto!="S")
		$Consulta.= " and t1.cod_producto='1' and t1.cod_subproducto='".$SubProducto."'";
	if ($Proveedor!="S")
		$Consulta.= " and t1.rut_proveedor='".$Proveedor."'";		
	$Consulta.= " order by lpad(t1.cod_subproducto,4,'0'), lpad(t1.rut_proveedor,11,'0') ";
	$Resp = mysqli_query($link, $Consulta);
	$Cont=0;
	while ($Fila = mysqli_fetch_array($Resp))
	{
		Titulo($Fila["cod_subproducto"],$Fila["descripcion"],$Fila["rut_proveedor"],$Fila["nomprv_a"]);
		//CONSULTA RECARGOS CON PARALELA
		$Consulta = "select distinct t1.lote, t1.muestra_paralela, t1.remuestreo, t1.num_lote_remuestreo, t1.estado_lote, t2.recargo ";
		$Consulta.= " from age_web.lotes t1 inner join age_web.leyes_por_lote t2 on t1.muestra_paralela=t2.lote ";
		$Consulta.= " where t1.lote  between '".$LoteIni."' and '".$LoteFin."' ";		
		$Consulta.= " and t1.muestra_paralela <>'' and t1.cod_producto='".$Fila["cod_producto"]."' ";
		$Consulta.= " and t1.cod_subproducto='".$Fila["cod_subproducto"]."' and t1.rut_proveedor='".$Fila["rut_proveedor"]."'";
		$Consulta.= " order by lpad(t1.cod_subproducto,4,'0'), lpad(t1.rut_proveedor,11,'0') ";
		$Resp2 = mysqli_query($link, $Consulta);
		//echo $Consulta."<br>";
		while ($Fila2 = mysqli_fetch_array($Resp2))
		{
			$Lote=$Fila2["lote"];
			if ($Fila2["estado_lote"]=="6")//ANULADA POR REMUESTREO			
			{					
				$Consulta = "select * from age_web.lotes where num_lote_remuestreo='".$Lote."'";
				$Resp3=mysqli_query($link, $Consulta);
				if ($Fila3=mysqli_fetch_array($Resp3))
					$LoteR=$Fila3["lote"];
			}
			else
			{
				$LoteR="";
			}
			$Cu_Pri=0;
			$Ag_Pri=0;
			$Au_Pri=0;
			$Cu_Par=0;
			$Ag_Par=0;
			$Au_Par=0;
			$SA_Pri="";
			$SA_Par="";
			$Val = Leyes($Lote,$Fila2["muestra_paralela"],$Cu_Pri,$Ag_Pri,$Au_Pri,$Cu_Par,$Ag_Par,$Au_Par,$SA_Pri,$SA_Par, $Ano,$link);
			//echo $Val;
			$Cu_Pri = $Val[0];
			$Ag_Pri = $Val[1];
			$Au_Pri = $Val[2];
			$Cu_Par = $Val[3];
			$Ag_Par = $Val[4];
			$Au_Par = $Val[5];
			$SA_Pri = $Val[6];
			$SA_Par = $Val[7];			
			$Cu_Dif=(float)$Cu_Pri-(float)$Cu_Par;
			$Ag_Dif=(float)$Ag_Pri-(float)$Ag_Par;
			$Au_Dif=(float)$Au_Pri-(float)$Au_Par;
			$Valores = $Fila2["lote"]."~~".$Fila2["recargo"];
			echo "<tr align=\"center\">\n";
			echo "<td>".$Fila2["lote"]."</td>\n";
			echo "<td align=\"right\">".number_format((float)$Cu_Pri,3,",",".")."</td>\n";
			echo "<td align=\"right\">".number_format((float)$Ag_Pri,3,",",".")."</td>\n";
			echo "<td align=\"right\">".number_format((float)$Au_Pri,3,",",".")."</td>\n";
			echo "<td>".$Fila2["muestra_paralela"]."</td>\n";
			echo "<td align=\"right\">".number_format((float)$Cu_Par,3,",",".")."</td>\n";
			echo "<td align=\"right\">".number_format((float)$Ag_Par,3,",",".")."</td>\n";
			echo "<td align=\"right\">".number_format((float)$Au_Par,3,",",".")."</td>\n";

			$Seg_Cu="";$Seg_Ag="";$Seg_Au="";
			$ColorCu="";$ColorAg=""; $ColorAu="";
			if ($Cu_Par!=0)
			{
				$Val = ControlMuestra("02", $Cu_Pri, $Cu_Par, $Cu_Dif, $CmbPlantilla, $Seg_Cu, $ColorCu,$link);
				$Seg_Cu = $Val[0];
				$ColorCu = $Val[1];							
				echo "<td bgcolor='".$ColorCu."'>".number_format(abs($Cu_Dif),3,",",".")."</td>";
				$Cont++;
			}
			else
				echo "<td align=\"right\">&nbsp;</td>\n";
			if ($Ag_Par!=0)
			{				
				$Val = ControlMuestra("04", $Ag_Pri, $Ag_Par, $Ag_Dif, $CmbPlantilla, $Seg_Ag, $ColorAg,$link);
				$Seg_Ag = $Val[0];
				$ColorAg = $Val[1];	
				echo "<td bgcolor='".$ColorAg."'>".number_format(abs($Ag_Dif),3,",",".")."</td>";
				$Cont++;
			}
			else
				echo "<td align=\"right\">&nbsp;</td>\n";
			if ($Au_Par!=0)
			{
				$Val = ControlMuestra("05", $Au_Pri, $Au_Par, $Au_Dif, $CmbPlantilla, $Seg_Au, $ColorAu,$link);
				$Seg_Au = $Val[0];
				$ColorAu = $Val[1];
				echo "<td bgcolor='".$ColorAu."'>".number_format(abs($Au_Dif),3,",",".")."</td>";
				$Cont++;
			}
			else
				echo "<td align=\"right\">&nbsp;</td>\n";
			$TxtRemuestreo=$LoteR;			
			if ($TxtRemuestreo!="")
				echo "<td align=\"center\">S</td>\n";
			else
				echo "<td align=\"center\">&nbsp;</td>\n";
			echo "<td align=\"center\">".$TxtRemuestreo."</td>\n";
			echo "</tr>\n";
		}
	}
}//FIN MOSTRAR = S	

function ControlMuestra($CodLey, $Ley_Pri, $Ley_Par, $Dif, $Plantilla, $Seguimiento, $ResultControl, $link)
{
	$Consulta = "select t1.limite_particion,t2.abreviatura,t1.descripcion ";
	$Consulta.= " from age_web.limites_particion t1 inner join proyecto_modernizacion.unidades t2 ";
	$Consulta.= " on t1.cod_unidad =t2.cod_unidad ";
	$Consulta.= " where proceso='REMUESTREO' and cod_plantilla='".$Plantilla."' ";
	$Consulta.= " and cod_ley = '".$CodLey."' and '".$Ley_Pri."' between rango1 and rango2";
	//echo $Consulta."<br>";
	$RespPar=mysqli_query($link, $Consulta);
	if($FilaPar=mysqli_fetch_array($RespPar))
	{
		$LimControl=$FilaPar["limite_particion"]*1;
		$Seguimiento="M.PARALELA: ".$FilaPar["descripcion"]."<BR>";
		$Seguimiento.="LIMITE CONTROL: ".$LimControl."&nbsp;(".$FilaPar["abreviatura"].")<br>";
		//echo "LIMITE CONTROL:".$LimControl."<br>";
		$Dif=abs((float)$Ley_Pri-(float)$Ley_Par)*1;
		$Seguimiento.="DIF.LEY FINAL Y M.PAREL :".number_format($Dif,3,',','.')."<br>";
		//echo "DIF:".$Dif."<br>";
		if(doubleval($Dif+1-1) > doubleval($LimControl+1-1))
		{
			$ResultControl="YELLOW";
			$Seguimiento.="MUESTRA FUERA DE RANGO<BR>";
		}	
		else
		{
			$ResultControl="WHITE";
			$Seguimiento.="MUESTRA OK";
		}	
	}
	$valor = $Seguimiento."**".$ResultControl;
	return $valor;	
}

function Titulo($Prod, $NomProd, $Proved, $NomProved)
{
	echo "<tr class=\"ColorTabla02\">\n";
	echo "<td colspan=\"7\">Producto:&nbsp;".str_pad($Prod,2,'0',STR_PAD_LEFT)."-".strtoupper($NomProd)."</td>\n";
	echo "<td colspan=\"6\">Proveedor:&nbsp;".str_pad($Proved,10,'0',STR_PAD_LEFT)."-".strtoupper($NomProved)."</td>\n";
	echo "</tr>\n";
	echo "<tr align=\"center\" class=\"ColorTabla01\">\n";
	echo "<td width=\"40\" rowspan=\"2\">Lote</td> \n";
	echo "<td colspan=\"3\">Paquete Primero</td>\n";
	echo "<td width=\"57\" rowspan=\"2\">Paralela</td>\n";
	echo "<td colspan=\"3\">Muestra Paralela</td>\n";
	echo "<td colspan=\"3\">Diferencia</td>\n";
	echo "<td colspan=\"2\">Remuestreo</td>\n";
	echo "</tr>\n";
	echo "<tr class=\"ColorTabla01\" align=\"center\">\n";
	echo "<td width=\"57\">Cu</td>\n";
	echo "<td width=\"57\">Ag</td>\n";
	echo "<td width=\"57\">Au</td>\n";
	echo "<td width=\"57\">Cu</td>\n";
	echo "<td width=\"57\">Ag</td>\n";
	echo "<td width=\"57\">Au</td>\n";
	echo "<td width=\"57\">Cu</td>\n";
	echo "<td width=\"57\">Ag</td>\n";
	echo "<td width=\"57\">Au</td>\n";
	echo "<td width=\"57\">S/N</td>\n";
	echo "<td>Num.</td>\n";
	echo "</tr>\n";
}//FIN FUNCION TITULO

function Leyes($Lote,$MuestraParalela,$Cu_Pri,$Ag_Pri,$Au_Pri,$Cu_Par,$Ag_Par,$Au_Par,$SA_Pri,$SA_Par,$Ano,$link)
{
	//LEYES DEL PAQUETE PRIMERO
	$DatosLote= array();
	$ArrLeyes=array();
	$DatosLote["lote"]=$Lote;
	$DatosLote = LeyesLote($DatosLote,$ArrLeyes,"N","S","S","","","","",$link);
	$ArrLeyes  = LeyesLote($DatosLote,$ArrLeyes,"N","S","S","","","","L",$link);
	$PesoLote=$DatosLote["peso_seco"];
	$Cu_Pri=$ArrLeyes["02"][2];
	$Ag_Pri=$ArrLeyes["04"][2];
	$Au_Pri=$ArrLeyes["05"][2];
	//BUSCA
	$Consulta="select * from cal_web.solicitud_analisis ";
	$Consulta.= " where id_muestra='".$MuestraParalela."' and tipo=4 and recargo='R' ";
	$Consulta.= " and year(fecha_muestra)='".substr($DatosLote["fecha_recepcion"],0,4)."'";
	$Respuesta=mysqli_query($link, $Consulta);
	if($FilaLeyes=mysqli_fetch_array($Respuesta))
	{
		$PesoMuestra=$FilaLeyes["peso_muestra"];
		$PesoRetalla=$FilaLeyes["peso_retalla"];
		$Recargo    =$FilaLeyes["recargo"];
	}
	$Consulta="select * from age_web.leyes_por_lote ";
	$Consulta.= " where lote='".$MuestraParalela."' ";
	$Consulta.= " and recargo='0' and cod_leyes in('02','04','05') ";
	$Consulta.= " and ano='".substr($DatosLote["fecha_recepcion"],0,4)."' ";
	$Respuesta=mysqli_query($link, $Consulta);
	while ($FilaLeyes=mysqli_fetch_array($Respuesta))
	{
		switch ($FilaLeyes["cod_leyes"])
		{
			case "02":
				$Cu_Par=$FilaLeyes["valor"];
				break;
			case "04":
				$Ag_Par=$FilaLeyes["valor"];
				break;
			case "05":
				$Au_Par=$FilaLeyes["valor"];
				break;
		}						
	}
	$Consulta = "select distinct t1.cod_leyes, t1.valor, t2.abreviatura as nom_unidad, t2.conversion";
	$Consulta.= " from age_web.leyes_por_lote t1 left join proyecto_modernizacion.unidades t2 on ";
	$Consulta.= " t1.cod_unidad=t2.cod_unidad ";
	$Consulta.= " where t1.lote='".$MuestraParalela."' ";
	$Consulta.= " and t1.recargo='R'";	
	$Consulta.= " and ano='".substr($DatosLote["fecha_recepcion"],0,4)."' ";
	$Consulta.= " order by t1.cod_leyes";
	//echo $Consulta."<br>";
	$RespLeyes = mysqli_query($link, $Consulta);
	while ($FilaLeyes = mysqli_fetch_array($RespLeyes))
	{									
		//CALCULA LA LEY INCLUYENDO INCIDENCIA DE LA RETALLA
		switch ($FilaLeyes["cod_leyes"])
		{
			case "02":
				if ($PesoRetalla>0 && $PesoMuestra>0)
					$IncRetalla = ($FilaLeyes["valor"] - $Cu_Par) * ($PesoRetalla/$PesoMuestra);  //VALOR
				else
					$IncRetalla = 0;  //VALOR					
				$Cu_Par=$Cu_Par + $IncRetalla;
				break;
			case "04":
				if ($PesoRetalla>0 && $PesoMuestra>0)
					$IncRetalla = ($FilaLeyes["valor"] - $Ag_Par) * ($PesoRetalla/$PesoMuestra);  //VALOR
				else
					$IncRetalla = 0;  //VALOR
				$Ag_Par=$Ag_Par + $IncRetalla;
				break;
			case "05":
				if ($PesoRetalla>0 && $PesoMuestra>0)
					$IncRetalla = ($FilaLeyes["valor"] - $Au_Par) * ($PesoRetalla/$PesoMuestra);  //VALOR
				else
					$IncRetalla = 0;  //VALOR				
				$Au_Par=$Au_Par + $IncRetalla;
				break;
		}						
	}
	
	//CONSULTA LA S.A. PAQUETE PRIMERO
	$Consulta = "select distinct t1.id_muestra,t1.nro_solicitud, t1.recargo ";
	$Consulta.= " from cal_web.solicitud_analisis t1 ";
	$Consulta.= " where t1.id_muestra='".$Lote."' and t1.agrupacion in(1,3,6)";// and t1.cod_producto='1' and t1.cod_subproducto='$CodSubProducto'";
	if($Recargo=='')
		$Consulta.= " and (t1.recargo='0' or t1.recargo='')";
	else
		$Consulta.= " and t1.recargo='".$Recargo."'";	
	//echo $Consulta;
	$RespSA=mysqli_query($link, $Consulta);
	if($FilaSA=mysqli_fetch_array($RespSA))
	{
		$SA_Pri=$FilaSA["nro_solicitud"];
	}
	//CONSULTA LA S.A. MUESTRA PARALELA
	$Consulta = "select distinct t1.id_muestra,t1.nro_solicitud, t1.recargo ";
	$Consulta.= " from cal_web.solicitud_analisis t1 ";
	$Consulta.= " where t1.id_muestra='".$MuestraParalela."' and t1.agrupacion in(1,3,6) and tipo='4'";// and t1.cod_producto='1' and t1.cod_subproducto='$CodSubProducto'";
	$Consulta.= " and year(t1.fecha_muestra)='".$Ano."'";
	if($Recargo=='')
		$Consulta.= " and (t1.recargo='0' or t1.recargo='')";
	else
		$Consulta.= " and t1.recargo='".$Recargo."'";	
	//echo $Consulta;
	$RespSA=mysqli_query($link, $Consulta);
	if($FilaSA=mysqli_fetch_array($RespSA))
	{
		$SA_Par=$FilaSA["nro_solicitud"];
	}
	$valores = $Cu_Pri."**".$Ag_Pri."**".$Au_Pri."**".$Cu_Par."**".$Ag_Par."**".$Au_Par."**".$SA_Pri."**".$SA_Par;
    return $valores;
}
?>
</table>
</form>
</body>
</html>
