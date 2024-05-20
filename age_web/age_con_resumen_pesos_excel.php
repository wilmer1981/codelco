<?php
	        ob_end_clean();
        $file_name=basename($_SERVER['PHP_SELF']).".xls";
        $userBrowser = $_SERVER['HTTP_USER_AGENT'];
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
	include("../age_web/age_funciones.php");	
?>
<html>
<head>
<title>AGE-Resumen Pesos</title></head>

<body>
<form name="frmPrincipal" action="" method="post">
  <table width="620" border="0" align="center">
    <tr>
      <td width="294" colspan="2">CODELCO CHILE<br>
        DIVISION VENTANAS       <br> </td>
      <td width="296" align="right" colspan="2">FECHA:&nbsp;<?php echo date("d-m-Y")?></td>
    </tr>
    <tr align="center">
      <td height="30" colspan="4"><strong><u>RESUMEN DE PESO HUMEDO Y PESO SECO </u></strong></td>
    </tr>
    <tr align="center">
      <td colspan="4">PERIODO: <?php echo substr($TxtFechaIni,8,2)."-".substr($TxtFechaIni,5,2)."-".substr($TxtFechaIni,0,4)." al ".substr($TxtFechaFin,8,2)."-".substr($TxtFechaFin,5,2)."-".substr($TxtFechaFin,0,4); ?></td>
    </tr>
  </table>
  <br>
	<?php
	$ColSpan=4;	
	echo "<table width=\"500\"  border=\"1\" align=\"center\" cellpadding=\"3\" cellspacing=\"0\">\n";
	$Consulta = "select distinct t1.cod_producto, t1.cod_subproducto, lpad(t1.cod_subproducto,4,'0') as orden ,recepcion ";
	$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
	$Consulta.= " on t1.lote = t2.lote inner join proyecto_modernizacion.subproducto t3 on t1.cod_producto=t3.cod_producto ";
	$Consulta.= " and t1.cod_subproducto=t3.cod_subproducto ";
	$Consulta.= " where t1.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."' ";
	if ($CmbRecepcion != "S")
		$Consulta.= " and t1.cod_recepcion = '".$CmbRecepcion."' ";
	if ($CmbSubProducto != "S")
	{
		$Consulta.= " and t1.cod_producto = '1' ";
		$Consulta.= " and t1.cod_subproducto = '".$CmbSubProducto."' ";
	}
	if ($CmbProveedor != "S")
		$Consulta.= " and t1.rut_proveedor = '".$CmbProveedor."' ";
	$Consulta.= " order by t1.cod_producto, orden ";
	//echo $Consulta."<br>";
	$Resp01 = mysqli_query($link, $Consulta);
	while ($Fila01 = mysqli_fetch_array($Resp01))	
	{			
		echo "<tr class=\"ColorTabla01\">\n";			
		$Consulta = "select * from proyecto_modernizacion.subproducto ";
		$Consulta.= "where cod_producto = '".$Fila01["cod_producto"]."' and cod_subproducto='".$Fila01["cod_subproducto"]."'";		
		$RespAux2 = mysqli_query($link, $Consulta);
		if ($FilaAux2 = mysqli_fetch_array($RespAux2))
		{
			$NomSubProd = $FilaAux2["descripcion"];
		}
		else
			$NomSubProd = "SIN IDENTIFICACION";		
		echo "<td align=\"left\" colspan=\"".$ColSpan."\">".str_pad($Fila01["cod_subproducto"],2,'0',STR_PAD_LEFT)." - ".$NomSubProd."</td>";					
		echo "</tr>\n";
		//TITULO						
		echo "<tr class=\"ColorTabla02\">\n";		
		switch ($OptVer)
		{
			case "P":
				echo "<td align=\"center\" width=\"300\">Proveedor</td>\n";
				break;
			case "L":
				echo "<td align=\"center\" width=\"200\">Lote</td>\n";
				break;
		}		
		echo "<td align=\"center\" width=\"80\">P.Hum.<br>(Kg)</td>\n";
		echo "<td align=\"center\" width=\"80\">Hum<br>(%)</td>\n";	
		echo "<td align=\"center\" width=\"80\">P.Seco<br>(Kg)</td>\n";
		echo "</tr>\n";
		//CONSULTA LOS TIPOS DE RECEPCION
		$Consulta = "select distinct t1.cod_recepcion, t3.nombre_subclase as desc_a";
		$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
		$Consulta.= " on t1.lote = t2.lote left join proyecto_modernizacion.sub_clase t3 on t3.cod_clase ='3104' and t1.cod_recepcion=t3.nombre_subclase ";
		$Consulta.= " where t1.lote<>'' ";
		$Consulta.= " and t2.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."'";			
		$Consulta.= " and t1.cod_producto = '".$Fila01["cod_producto"]."' ";
		$Consulta.= " and t1.cod_subproducto = '".$Fila01["cod_subproducto"]."' ";
		if ($CmbRecepcion != "S")
			$Consulta.= " and t1.cod_recepcion = '".$CmbRecepcion."' ";
		if ($CmbProveedor != "S")
			$Consulta.= " and t1.rut_proveedor = '".$CmbProveedor."' ";
		$Consulta.= " order by t1.cod_recepcion ";
		//echo $Consulta."<br>";
		$RespTipoRecep = mysqli_query($link, $Consulta);
		while ($FilaTipoRecep = mysqli_fetch_array($RespTipoRecep))
		{					
			//TITULO COD RECEPCION
			echo "<tr bgcolor=\"#CCCCCC\">\n";	
			if ($FilaTipoRecep["desc_a"] == "" || is_null($FilaTipoRecep["desc_a"]))
				echo "<td align=\"left\" colspan=\"".$ColSpan."\">&nbsp;</td>\n";				
			else
				echo "<td align=\"left\" colspan=\"".$ColSpan."\">".strtoupper($FilaTipoRecep["desc_a"])."</td>\n";		
			echo "</tr>\n";
			//CONSULTA LOS PROVEEDOR DE UN PRODUCTO Y UN TIPO DE RECEPCION
			$Consulta = "select distinct t1.rut_proveedor, t1.cod_recepcion  ";
			$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
			$Consulta.= " on t1.lote = t2.lote ";
			$Consulta.= " where t1.lote<>'' ";
			$Consulta.= " and t2.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."'";			
			$Consulta.= " and t1.cod_producto = '".$Fila01["cod_producto"]."' ";
			$Consulta.= " and t1.cod_subproducto = '".$Fila01["cod_subproducto"]."' ";
			if ($CmbProveedor != "S")
				$Consulta.= " and t1.rut_proveedor = '".$CmbProveedor."' ";
			$Consulta.= " and t1.cod_recepcion = '".$FilaTipoRecep["cod_recepcion"]."' ";
			$Consulta.= " order by t1.cod_recepcion, t1.rut_proveedor ";
			//echo $Consulta."<br>";
			$RutPrv='';
			$RespAux = mysqli_query($link, $Consulta);
			while ($FilaAux = mysqli_fetch_array($RespAux))
			{		
				$Datos = explode("-",$FilaAux["rut_proveedor"]);
				//$RutAux = ($Datos[0]*1)."-".$Datos[1];
				$RutAux = $FilaAux["rut_proveedor"];
				$NomProveedor = "";
				$Consulta = "select * ";
				$Consulta.= " from rec_web.proved ";
				$Consulta.= " where rutprv_a = '".$RutAux."'";
				$RespProv = mysqli_query($link, $Consulta);	
				//echo $Consulta."<br>";
				while ($FilaProv = mysqli_fetch_array($RespProv))
				{
					$NomProveedor = $FilaProv["NOMPRV_A"];
				}		
				if ($OptVer=="L")
				{					
					echo "<tr class=\"Detalle01\">\n";
					echo "<td align=\"left\" colspan=\"".$ColSpan."\">".$FilaAux["rut_proveedor"]."&nbsp;&nbsp;".substr(strtoupper($NomProveedor),0,30)."</td>\n";
					echo "</tr>\n";				
				}
				$Consulta = "select distinct t1.lote, t2.recargo, t1.rut_proveedor, t2.peso_neto as peso_hum,  ";
				$Consulta.= " lpad(t2.recargo,2,'0') as orden, t2.fecha_recepcion ";		
				$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
				$Consulta.= " on t1.lote = t2.lote ";			
				$Consulta.= " where t1.cod_producto = '".$Fila01["cod_producto"]."' ";
				$Consulta.= " and t1.cod_subproducto = '".$Fila01["cod_subproducto"]."' ";
				$Consulta.= " and t2.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."'";
				$Consulta.= " and t1.rut_proveedor = '".$FilaAux["rut_proveedor"]."' ";
				$Consulta.= " and t1.cod_recepcion = '".$FilaAux["cod_recepcion"]."' ";					
				$Consulta.= " and t1.estado_lote <>'6' group by t1.lote order by t1.lote, orden";
				$RespLote = mysqli_query($link, $Consulta);
				//echo $Consulta."<br>";
				while($FilaLote=mysqli_fetch_array($RespLote))
				{
					$DatosLote= array();
					$ArrLeyes=array();
					$DatosLote["lote"]=$FilaLote["lote"];
					$ArrLeyes["01"][0]="01";$ArrLeyes["02"][0]="02";$ArrLeyes["04"][0]="04";$ArrLeyes["05"][0]="05";
					LeyesLote(&$DatosLote,&$ArrLeyes,"S","S","S",$TxtFechaIni,$TxtFechaFin,"");
					$PesoLoteS=$DatosLote["peso_seco2"];
					$PesoLoteH=$DatosLote["peso_humedo"];
					$CantDecPeso=0;$CantDecLF=0;
					if($Fila01["recepcion"]=='PMN')
					{
						$CantDecPeso=4;$CantDecLF=4;
					}
					if ($OptVer=="L")
					{	
						echo "<tr>";
						echo "<td align=\"center\">".$FilaLote["lote"]."</td>";
						//echo "<td align=\"center\">".substr($FilaLote["fecha_recepcion"],8,2)."/".substr($FilaLote["fecha_recepcion"],5,2)."/".substr($FilaLote["fecha_recepcion"],0,4)."</td>";
						echo "<td align=\"right\">".number_format($PesoLoteH,$CantDecPeso,',','.')."</td>";
						echo "<td align=\"right\">".number_format($ArrLeyes["01"][2],4,',','.')."</td>";
						echo "<td align=\"right\">".number_format($PesoLoteS,$CantDecPeso,',','.')."</td>";															
						echo "</tr>";						
					}
				}
				//TOTAL PROVEEDOR
				if ($OptVer=="L")
				{
					echo "<tr  bgcolor=\"#CCCCCC\">\n";
					echo "<td align=\"left\">TOTAL ".str_pad($FilaAux["rut_proveedor"],10,"0",STR_PAD_LEFT)."</td>";
				}
				else
				{
					echo "<tr>\n";
					echo "<td align=\"left\" >".str_pad($FilaAux["rut_proveedor"],10,"0",STR_PAD_LEFT)."&nbsp;&nbsp;".substr(strtoupper($NomProveedor),0,25)."</td>";				
				}
				$ArrDatos=array();
				$ArrLeyesProv=array();
				$ArrLeyesProv["01"][0]="01";$ArrLeyesProv["02"][0]="02";$ArrLeyesProv["04"][0]="04";$ArrLeyesProv["05"][0]="05";
				LeyesProveedor($FilaAux["cod_recepcion"],$FilaAux["rut_proveedor"],'1',$Fila01["cod_subproducto"],&$ArrDatos,&$ArrLeyesProv,'S','S','S',$TxtFechaIni,$TxtFechaFin,"");
				$CantDecPeso=0;$CantDecLF=0;
				if($Fila01["recepcion"]=='PMN')
				{
					$CantDecPeso=4;$CantDecLF=4;
				}
				echo "<td align=\"right\">".number_format($ArrDatos["peso_humedo"],$CantDecPeso,',','.')."</td>";						
				echo "<td align=\"right\">".number_format($ArrLeyesProv["01"][2],4,',','.')."</td>\n";				
				echo "<td align=\"right\">".number_format($ArrDatos["peso_seco"],$CantDecPeso,',','.')."</td>";								
				echo "</tr>\n";
				$RutPrv=$RutPrv."'".$FilaAux["rut_proveedor"]."',";			
				//------ESPACIO---------------
				echo "<tr><td colspan=\"4\">&nbsp;</td></tr>\n";	
			}
			//------ESPACIO---------------
			echo "<tr><td colspan=\"4\">&nbsp;</td></tr>\n";
			//TOTAL TIPO RECEPCION
			echo "<tr class=\"ColorTabla02\" bgcolor=\"#CCCCCC\"><td align=\"left\">TOTAL&nbsp;".strtoupper($FilaTipoRecep["desc_a"])."</td>\n";
			$RutPrv=substr($RutPrv,0,strlen($RutPrv)-1);
			$RutPrv="(".$RutPrv.")";
			$ArrDatos=array();
			$ArrLeyesProd=array();
			$ArrLeyesProd["01"][0]="01";$ArrLeyesProd["02"][0]="02";$ArrLeyesProd["04"][0]="04";$ArrLeyesProd["05"][0]="05";
			LeyesProducto('',$RutPrv,$FilaTipoRecep["cod_recepcion"],'1',$Fila01["cod_subproducto"],&$ArrDatos,&$ArrLeyesProd,'S','S','S',$TxtFechaIni,$TxtFechaFin,"");
			$CantDecPeso=0;$CantDecLF=0;
			if($Fila01["recepcion"]=='PMN')
			{
				$CantDecPeso=4;$CantDecLF=4;
			}
			echo "<td align=\"right\">".number_format($ArrDatos["peso_humedo"],$CantDecPeso,',','.')."</td>";
			echo "<td align=\"right\">".number_format($ArrLeyesProd["01"][2],4,',','.')."</td>\n";
			echo "<td align=\"right\">".number_format($ArrDatos["peso_seco"],$CantDecPeso,',','.')."</td>";						
			echo "</tr>\n";			
		}//FIN TIPO RECEPCION
		//------ESPACIO---------------
		echo "<tr><td colspan=\"4\">&nbsp;</td></tr>\n";
		//TOTAL PRODUCTO
		echo "<tr class=\"ColorTabla02\" bgcolor=\"#CCCCCC\"><td align=\"left\">TOTAL: ".str_pad($Fila01["cod_subproducto"],2,'0',STR_PAD_LEFT)." ".strtoupper($NomSubProd)."</td>\n";
		$ArrDatos=array();
		$ArrLeyesProd=array();
		$ArrLeyesProd["01"][0]="01";$ArrLeyesProd["02"][0]="02";$ArrLeyesProd["04"][0]="04";$ArrLeyesProd["05"][0]="05";
		$RutPrv='';$CodRecep='';
		if($CmbProveedor!='S')
			$RutPrv="('".$CmbProveedor."')";
		if ($CmbRecepcion != "S")
			$CodRecep=$CmbRecepcion;
		LeyesProducto('',$RutPrv,$CodRecep,'1',$Fila01["cod_subproducto"],&$ArrDatos,&$ArrLeyesProd,'S','S','S',$TxtFechaIni,$TxtFechaFin,"");
		$CantDecPeso=0;$CantDecLF=0;
		if($Fila01["recepcion"]=='PMN')
		{
			$CantDecPeso=4;$CantDecLF=4;
		}
		echo "<td align=\"right\">".number_format($ArrDatos[peso_humedo],$CantDecPeso,',','.')."</td>";
		echo "<td align=\"right\">".number_format($ArrLeyesProd["01"][2],4,',','.')."</td>\n";
		echo "<td align=\"right\">".number_format($ArrDatos[peso_seco],$CantDecPeso,',','.')."</td>";				
		echo "</tr>\n";	
	}//FIN PRODUCTOS
	echo "</table>\n";
	?>  
</form>
</body>
</html>