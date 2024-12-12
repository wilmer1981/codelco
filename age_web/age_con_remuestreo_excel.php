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
	include("age_funciones.php");

	$Mostrar       = isset($_REQUEST["Mostrar"])?$_REQUEST["Mostrar"]:"";
	$SubProducto   = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";
	$Proveedor     = isset($_REQUEST["Proveedor"])?$_REQUEST["Proveedor"]:"";
	$Mes        = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("m");
	$Ano        = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");

?>
<html>
<head>
<title>Sistema de Agencia</title>
</head>

<body leftmargin="3" topmargin="5">
<form name="frmPrincipal" action="" method="post">
<input type="hidden" name="Valores" value="">
<br>
        <br>
        <table width="864" border="1" align="center" cellpadding="2" cellspacing="0">
<?php		
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
	//CONSULTA LOS DISTINTOS PRODUCTOS Y PROVEEDORES CON REMUESTREO="S"
	$Consulta = "select distinct t1.cod_producto, t1.cod_subproducto, t1.rut_proveedor, t2.descripcion, t3.nomprv_a ";
	$Consulta.= " from age_web.lotes t1 inner join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto ";
	$Consulta.= " and t1.cod_subproducto=t2.cod_subproducto inner join rec_web.proved t3 on t1.rut_proveedor=t3.rutprv_a";
	$Consulta.= " where t1.lote between '".$LoteIni."' and '".$LoteFin."' ";
	$Consulta.= " and t1.remuestreo ='S' ";
	if ($SubProducto!="S")
		$Consulta.= " and t1.cod_producto='1' and t1.cod_subproducto='".$SubProducto."'";
	if ($Proveedor!="S")
		$Consulta.= " and t1.rut_proveedor='".$Proveedor."'";		
	$Consulta.= " order by lpad(t1.cod_subproducto,4,'0'), lpad(t1.rut_proveedor,11,'0') ";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{
		Titulo($Fila["cod_subproducto"],$Fila["descripcion"],$Fila["rut_proveedor"],$Fila["nomprv_a"]);
		//CONSULTA RECARGOS CON REMUESTREO
		$Consulta = "select distinct t1.lote, t1.muestra_paralela, t1.remuestreo, t1.num_lote_remuestreo ";
		$Consulta.= " from age_web.lotes t1  ";
		$Consulta.= " where t1.lote  between '".$LoteIni."' and '".$LoteFin."' ";		
		$Consulta.= " and t1.remuestreo ='S' and t1.cod_producto='".$Fila["cod_producto"]."' ";
		$Consulta.= " and t1.cod_subproducto='".$Fila["cod_subproducto"]."' and t1.rut_proveedor='".$Fila["rut_proveedor"]."'";
		$Consulta.= " order by lpad(t1.cod_subproducto,4,'0'), lpad(t1.rut_proveedor,11,'0') ";
		$Resp2 = mysqli_query($link, $Consulta);
		while ($Fila2 = mysqli_fetch_array($Resp2))
		{			
			$Lote = $Fila2["num_lote_remuestreo"];
			$LoteNuevo = $Fila2["lote"];
			
			$Consulta = "select * from age_web.lotes where lote='".$Lote."' ";		
			$Resp3 = mysqli_query($link, $Consulta);			
			$M_Paralela="";
			if ($Fila3 = mysqli_fetch_array($Resp3))
				$M_Paralela=$Fila3["muestra_paralela"];
			
			$Cu_Pri=0;$Ag_Pri=0;$Au_Pri=0;
			$Cu_Par=0;$Ag_Par=0;$Au_Par=0;
			$SA_Pri="";$Rec_Pri ="";
			$SA_Par="";$Rec_Par="";	
			
			//echo $Lote." - ".$M_Paralela."<br>";
			//Leyes($Lote,$M_Paralela,$Cu_Pri,$Ag_Pri,$Au_Pri,$Cu_Par,$Ag_Par,$Au_Par,$SA_Pri,$Rec_Pri,$SA_Par,$Rec_Par,$Ano,$link);
			$ResVal = Leyes($Lote,$M_Paralela,$Cu_Pri,$Ag_Pri,$Au_Pri,$Cu_Par,$Ag_Par,$Au_Par,$SA_Pri,$Rec_Pri,$SA_Par,$Rec_Par,$Ano,$link);
			//var_dump($ResVal);
			$Val1    = explode("/",$ResVal);
			$Val11   = $Val1[0]; //
     		$Val111  = explode("-",$Val11);
			$SA_Pri  = $Val111[0];
			$Rec_Pri = $Val111[1];
			$SA_Par  = $Val111[2];
			$Rec_Par = $Val111[3];
			
			$Val12   = $Val1[1];//
			$Val     = explode("-",$Val12);
			$Cu_Pri  = $Val[0];
			$Ag_Pri  = $Val[1];
			$Au_Pri  = $Val[2];		
			$Cu_Par  = $Val[3];
			$Ag_Par  = $Val[4];
			$Au_Par  = $Val[5];
			
			$Cu_Dif=0;$Ag_Dif=0;$Au_Dif=0;
			
			$Cu_Dif=$Cu_Pri-$Cu_Par;
			$Ag_Dif=$Ag_Pri-$Ag_Par;
			$Au_Dif=$Au_Pri-$Au_Par;
			//$Valores = $Fila2["lote"]."~~".$Fila2["recargo"];
			echo "<tr align=\"center\">\n";
			echo "<td>".$Fila2["num_lote_remuestreo"]."</td>\n";
			echo "<td align=\"right\">".number_format($Cu_Pri,2,",",".")."</td>\n";
			echo "<td align=\"right\">".number_format($Ag_Pri,2,",",".")."</td>\n";
			echo "<td align=\"right\">".number_format($Au_Pri,2,",",".")."</td>\n";
			echo "<td>".$M_Paralela."</td>\n";
			if ($Cu_Par!="")
				echo "<td align=\"right\">".number_format($Cu_Par,2,",",".")."</td>\n";
			else
				echo "<td align=\"right\">&nbsp;</td>\n";
			if ($Ag_Par!="")
				echo "<td align=\"right\">".number_format($Ag_Par,2,",",".")."</td>\n";
			else
				echo "<td align=\"right\">&nbsp;</td>\n";
			if ($Au_Par!="")
				echo "<td align=\"right\">".number_format($Au_Par,2,",",".")."</td>\n";
			else
				echo "<td align=\"right\">&nbsp;</td>\n";
			if ($Cu_Par!="")
				echo "<td align=\"right\">".number_format(abs($Cu_Dif),2,",",".")."</td>\n";
			else
				echo "<td align=\"right\">&nbsp;</td>\n";
			if ($Ag_Par!="")
				echo "<td align=\"right\">".number_format(abs($Ag_Dif),2,",",".")."</td>\n";
			else
				echo "<td align=\"right\">&nbsp;</td>\n";
			if ($Au_Par!="")
				echo "<td align=\"right\">".number_format(abs($Au_Dif),2,",",".")."</td>\n";
			else
				echo "<td align=\"right\">&nbsp;</td>\n";
			$Cu_Rem=0;$Ag_Rem=0;$Au_Rem=0;
			$SA_Rem="";$Rec_Rem="";
			//echo $Lote." - ".$M_Paralela."<br>";
			//Leyes($LoteNuevo,"",$Cu_Rem,$Ag_Rem,$Au_Rem,$Cu_Par,$Ag_Par,$Au_Par,$SA_Rem,$Rec_Rem,$SA_Par,$Rec_Par,$Ano,$link);	
			$ResVal = Leyes($LoteNuevo,"",$Cu_Rem,$Ag_Rem,$Au_Rem,$Cu_Par,$Ag_Par,$Au_Par,$SA_Rem,$Rec_Rem,$SA_Par,$Rec_Par,$Ano,$link);	
			$Val1    = explode("/",$ResVal);
			$Val11   = $Val1[0]; 
			$Val12   = $Val1[1];
     		$Val111  = explode("-",$Val11);
			$SA_Rem  = $Val111[0];
			$Rec_Rem = $Val111[1];
			$SA_Par  = $Val111[2];
			$Rec_Par = $Val111[3];

			$Val     = explode("-",$Val12);
			$Cu_Rem  = $Val[0];
			$Ag_Rem  = $Val[1];
			$Au_Rem  = $Val[2];		
			$Cu_Par  = $Val[3];
			$Ag_Par  = $Val[4];
			$Au_Par  = $Val[5];	
			
			$Cu_Dif_Rem=0;$Ag_Dif_Rem=0;$Au_Dif_Rem=0;
			$Cu_Dif_Rem=$Cu_Rem-$Cu_Pri;
			$Ag_Dif_Rem=$Ag_Rem-$Ag_Pri;
			$Au_Dif_Rem=$Au_Rem-$Au_Pri;

			echo "<td>".$LoteNuevo."</td>\n";
			if ($Cu_Rem!="")
				echo "<td align=\"right\">".number_format($Cu_Rem,2,",",".")."</td>\n";
			else
				echo "<td align=\"right\">&nbsp;</td>\n";
			if ($Ag_Rem!="")
				echo "<td align=\"right\">".number_format($Ag_Rem,2,",",".")."</td>\n";
			else
				echo "<td align=\"right\">&nbsp;</td>\n";
			if ($Au_Rem!="")
				echo "<td align=\"right\">".number_format($Au_Rem,2,",",".")."</td>\n";
			else
				echo "<td align=\"right\">&nbsp;</td>\n";
			if ($Cu_Pri!="" && $Cu_Rem!="")
				echo "<td align=\"right\" bgcolor=\"#FFFFFF\">".number_format(abs($Cu_Dif_Rem),2,",",".")."</td>\n";
			else
				echo "<td align=\"right\" bgcolor=\"#FFFFFF\">&nbsp;</td>\n";
			if ($Ag_Pri!="" && $Ag_Rem!="")
				echo "<td align=\"right\" bgcolor=\"#FFFFFF\">".number_format(abs($Ag_Dif_Rem),2,",",".")."</td>\n";
			else
				echo "<td align=\"right\" bgcolor=\"#FFFFFF\">&nbsp;</td>\n";
			if ($Au_Pri!="" && $Au_Rem!="")
				echo "<td align=\"right\" bgcolor=\"#FFFFFF\">".number_format(abs($Au_Dif_Rem),2,",",".")."</td>\n";
			else
				echo "<td align=\"right\" bgcolor=\"#FFFFFF\">&nbsp;</td>\n";
			echo "</tr>\n";
		}
	}


function Titulo($Prod, $NomProd, $Proved, $NomProved)
{
	echo "<tr class=\"ColorTabla02\">\n";
	echo "<td colspan=\"6\">Producto:&nbsp;".str_pad($Prod,2,'0',STR_PAD_LEFT)."-".strtoupper($NomProd)."</td>\n";
	echo "<td colspan=\"12\">Proveedor:&nbsp;".str_pad($Proved,10,'0',STR_PAD_LEFT)."-".strtoupper($NomProved)."</td>\n";
	echo "</tr>\n";
	echo "<tr align=\"center\" class=\"ColorTabla01\">\n";
	echo "<td width=\"40\" rowspan=\"2\">Lote</td> \n";
	echo "<td colspan=\"3\">Paquete Primero</td>\n";
	echo "<td width=\"57\" rowspan=\"2\">Paralela</td>\n";
	echo "<td colspan=\"3\">Muestra Paralela</td>\n";
	echo "<td colspan=\"3\">Diferencia</td>\n";
	echo "<td width=\"57\" rowspan=\"2\">Remuestreo</td>\n";
	echo "<td colspan=\"3\">Remuestreo</td>\n";
	echo "<td colspan=\"3\">Paq.Pri v/s Rem.</td>\n";
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
	echo "<td width=\"57\">Cu</td>\n";
	echo "<td width=\"57\">Ag</td>\n";
	echo "<td width=\"57\">Au</td>\n";
	echo "<td width=\"57\">Cu</td>\n";
	echo "<td width=\"57\">Ag</td>\n";
	echo "<td width=\"57\">Au</td>\n";
	echo "</tr>\n";
}//FIN FUNCION TITULO
function Leyes($Lote,$MuestraParalela,$Cu_Pri,$Ag_Pri,$Au_Pri,$Cu_Par,$Ag_Par,$Au_Par,$SA_Pri,$Rec_Pri,$SA_Par,$Rec_Par,$Ano,$link)
{
	//LEYES DEL PAQUETE PRIMERO
	$DatosLote= array();
	$ArrLeyes=array();
	$DatosLote["lote"]=$Lote;
	/*
	LeyesLote($DatosLote,$ArrLeyes,"N","S","S","","","",$link);
	$PesoLote=$DatosLote["peso_seco"];
	$Cu_Pri=$ArrLeyes["02"][2];
	$Ag_Pri=$ArrLeyes["04"][2];
	$Au_Pri=$ArrLeyes["05"][2];
	*/
	$LeyesL = LeyesLote($DatosLote,$ArrLeyes,"N","S","S","","","",$link);
	//var_dump($LeyesL);
	$PesoLote = isset($DatosLote["peso_seco"])?$DatosLote["peso_seco"]:0;
	$Cu_Pri = isset($LeyesL["02"][2])?$LeyesL["02"][2]:0;
	$Ag_Pri = isset($LeyesL["04"][2])?$LeyesL["04"][2]:0;
	$Au_Pri = isset($LeyesL["05"][2])?$LeyesL["05"][2]:0;	
	//BUSCA DATOS MUESTRA PARALELA
	$Consulta="select * from cal_web.solicitud_analisis where id_muestra='".$MuestraParalela."' and tipo=4 and recargo='R' and year(fecha_muestra)='".$Ano."'";
	$Respuesta=mysqli_query($link, $Consulta);
	$Recargo =0; //WSO
	if($FilaLeyes=mysqli_fetch_array($Respuesta))
	{
		$PesoMuestra=$FilaLeyes["peso_muestra"];
		$PesoRetalla=$FilaLeyes["peso_retalla"];
		$Recargo    =$FilaLeyes["recargo"]; //WSO;
	}
	$Consulta="select * from age_web.leyes_por_lote where lote='".$MuestraParalela."' and recargo='0' and cod_leyes in('02','04','05') and ano='".$Ano."'";
	/*$Cu_Par=0;
	$Ag_Par=0;
	$Au_Par=0;*/
	$Respuesta=mysqli_query($link, $Consulta);
	while($FilaLeyes=mysqli_fetch_array($Respuesta))
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
	$Consulta.= " where t1.lote='".$MuestraParalela."' and t1.ano='".$Ano."'";
	$Consulta.= " and t1.recargo='R'";	
	$Consulta.= " order by t1.cod_leyes";
	//echo $Consulta."<br>";
	$RespLeyes = mysqli_query($link, $Consulta);
	while ($FilaLeyes = mysqli_fetch_array($RespLeyes))
	{									
		//CALCULA LA LEY INCLUYENDO INCIDENCIA DE LA RETALLA
		switch ($FilaLeyes["cod_leyes"])
		{
			case "02":
				if ($PesoRetalla>0 && $PesoMuestra>0 && $FilaLeyes["valor"]>0)
					$IncRetalla = ($FilaLeyes["valor"] - $Cu_Par) * ($PesoRetalla/$PesoMuestra);  //VALOR
				else
					$IncRetalla = 0;  //VALOR					
				$Cu_Par=$Cu_Par + $IncRetalla;
				break;
			case "04":
				if ($PesoRetalla>0 && $PesoMuestra>0 && $FilaLeyes["valor"]>0)
					$IncRetalla = ($FilaLeyes["valor"] - $Ag_Par) * ($PesoRetalla/$PesoMuestra);  //VALOR
				else
					$IncRetalla = 0;  //VALOR
				$Ag_Par=$Ag_Par + $IncRetalla;
				break;
			case "05":
				if ($PesoRetalla>0 && $PesoMuestra>0 && $FilaLeyes["valor"]>0)
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
		$Rec_Pri=$FilaSA["recargo"];
	}
	//CONSULTA LA S.A. MUESTRA PARALELA
	$Consulta = "select distinct t1.id_muestra,t1.nro_solicitud, t1.recargo ";
	$Consulta.= " from cal_web.solicitud_analisis t1 ";
	$Consulta.= " where t1.id_muestra='".$MuestraParalela."' and t1.agrupacion in(1,3,6) and tipo='4' and year(t1.fecha_muestra)='".$Ano."'";// and t1.cod_producto='1' and t1.cod_subproducto='$CodSubProducto'";
	if($Recargo=='')
		$Consulta.= " and (t1.recargo='0' or t1.recargo='')";
	else
		$Consulta.= " and t1.recargo='".$Recargo."'";	
	//echo $Consulta;
	$RespSA=mysqli_query($link, $Consulta);
	if($FilaSA=mysqli_fetch_array($RespSA))
	{
		$SA_Par=$FilaSA["nro_solicitud"];
		$Rec_Par=$FilaSA["recargo"];
	}
	
	/*************** WSO *************************/
	$Valores1 = $SA_Pri."-".$Rec_Pri."-".$SA_Par."-".$Rec_Par;
	$Valores2 = $Cu_Pri."-".$Ag_Pri."-".$Au_Pri."-".$Cu_Par."-".$Ag_Par."-".$Au_Par;
	$Valores = $Valores1."/".$Valores2;
	
	return $Valores;	
	/*********************************************/
	
}

?>
</table>
</form>
</body>
</html>
