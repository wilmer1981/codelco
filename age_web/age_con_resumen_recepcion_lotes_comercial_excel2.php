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
	$CmbMes = str_pad($CmbMes,2,"0",STR_PAD_LEFT);
	$TxtFechaIni = $CmbAno."-".$CmbMes."-01";
	$TxtFechaFin = date("Y-m-d", mktime(0,0,0,$CmbMes+1,1,$CmbAno));
	$TxtFechaFin = date("Y-m-d", mktime(0,0,0,substr($TxtFechaFin,5,2),1-1,substr($TxtFechaFin,0,4)));
	$ArrLeyes=array();
	$ArrLeyesAux=array();
	$ArrLeyesAux["01"][0]="01";
	$ArrLeyesAux["01"][1]="H2O";
	$ArrLeyesAux["01"][2]="1";
	$ArrLeyesAux["01"][3]="100";
	$ArrLeyesAux["01"][5]=4;
	$ArrLeyes["01"][0]="01";
	$Datos=explode('//',$TxtCodLeyes);
	$ContLeyes=0;
	foreach($Datos as $c => $v)
	{
		$ContLeyes++;
		$Datos2=explode('~',$v);
		$ArrLeyesAux[$Datos2[0]][0]=$Datos2[0];//CODIGO LEY
		$ArrLeyesAux[$Datos2[0]][1]=$Datos2[1];//NOMBRE LEY
		$ArrLeyesAux[$Datos2[0]][2]=$Datos2[2];//CODIGO UNIDAD
		$ArrLeyesAux[$Datos2[0]][3]=$Datos2[3];//CONVERSION	
		$ArrLeyesAux[$Datos2[0]][4]=$Datos2[4];//NOMBRE UNIDAD
		if ($ArrLeyesAux[$Datos2[0]][2]==1)
			$ArrLeyesAux[$Datos2[0]][5]=3;// 02 DECIMALES a los porcentajes (%)
		else
			$ArrLeyesAux[$Datos2[0]][5]=$Datos2[5];//DECIMALES
		$ArrLeyes[$Datos2[0]][0]=$Datos2[0];
		if(intval($Datos2[0])>5)
			$HayImpurezas=true;
	}
?>
<html>
<head>
<title>AGE-Resumen Recepcion Lotes Comercial</title>
<!--<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">-->
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
</head>

<body>
<form name="frmPrincipal" action="" method="post">
  <table width="620" border="0" align="center">
    <tr>
      <td width="294" colspan="6">CODELCO CHILE<br>
        DIVISION VENTANAS    V-1   <br> </td>
      <td width="296" align="right" colspan="6">FECHA:&nbsp;<?php echo date("d-m-Y")?></td>
    </tr>
    <tr align="center">
      <td height="30" colspan="12"><strong><u>INFORME RECEPCION POR LOTES COMERCIAL</u></strong></td>
    </tr>
    <tr align="center" class="12">
      <td colspan="12">MES: <?php echo $CmbMes."-".$CmbAno; ?></td>
    </tr>
  </table>
  <br>
	<?php
	$ColSpan=3+($ContLeyes*2);
	reset($ArrLeyes);
	while(list($c,$v)=each($ArrLeyes))
	{
		if($c!='01')
			$ColSpan=$ColSpan+1;
	}
	echo "<table width=\"600\"  border=\"1\" align=\"center\" cellpadding=\"3\" cellspacing=\"0\">\n";
	$Consulta = "select distinct t1.cod_producto, t1.cod_subproducto, lpad(t1.cod_subproducto,4,'0') as orden ,recepcion ";
	$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
	$Consulta.= " on t1.lote = t2.lote inner join proyecto_modernizacion.subproducto t3 on t1.cod_producto=t3.cod_producto ";
	$Consulta.= " and t1.cod_subproducto=t3.cod_subproducto ";
	$Consulta.= " where t1.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."' ";
	if ($CmbRecepcion!='S')
		$Consulta.= " and t1.cod_recepcion= '$CmbRecepcion' ";
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
		$ColSpan=3;
		if ($OptLeyes=="S")
			$ColSpan=$ColSpan+4;
		if($OptLeyes=="S" && $HayImpurezas==true)		
			$ColSpan=$ColSpan+($ContLeyes-3);
		if ($OptFinos=="S")
			$ColSpan=$ColSpan+4;
		else
			$ColSpan=$ColSpan+1;
		if($OptFinos=="S" && $HayImpurezas==true)		
			$ColSpan=$ColSpan+($ContLeyes-3);

		echo "<td align=\"left\" colspan=\"".$ColSpan."\">".str_pad($Fila01["cod_subproducto"],2,'0',STR_PAD_LEFT)." - ".$NomSubProd."</td>";					
		echo "</tr>\n";
		//TITULO					
		echo "<tr class=\"ColorTabla02\">\n";		
		echo "<td align=\"center\" rowspan=\"2\">Lote</td>\n";
		echo "<td align=\"center\" rowspan=\"2\">F.Cierre</td>\n";		
		echo "<td align=\"center\" rowspan=\"2\">P.Hum.<br>(Kg)</td>\n";
		if ($OptFinos!="S")
			echo "<td align=\"center\" rowspan=\"2\">P.Seco<br>(Kg)</td>\n";
		if ($OptLeyes=="S")
			echo "<td align=\"center\" colspan=\"4\">Leyes</td>\n";
		if($OptLeyes=="S" && $HayImpurezas==true)		
			echo "<td align=\"center\" colspan=\"".($ContLeyes-3)."\">Impurezas</td>\n";		
		if ($OptFinos=="S")
			echo "<td align=\"center\" rowspan=\"2\">P.Seco<br>(Kg)</td>\n";
		if ($OptFinos=="S")
			echo "<td align=\"center\" colspan=\"3\">Fino Ley</td>\n";
		if($OptFinos=="S" && $HayImpurezas==true)		
			echo "<td align=\"center\" colspan=\"".($ContLeyes-3)."\">Fino Impurezas</td>\n";
		echo "</tr>";
		echo "<tr class=\"ColorTabla02\">\n";
		if ($OptLeyes=="S")
		{
			echo "<td align=\"center\">Hum<br>(%)</td>\n";
			reset($ArrLeyesAux);
			while(list($c,$v)=each($ArrLeyesAux))
			{
				if($c!='01')
					echo "<td align=\"center\">".$v[1]."<br>(".$v[4].")</td>\n";
			}
		}
		//echo "<td align=\"center\">P.Seco<br>(Kg)</td>\n";
		if ($OptFinos=="S")
		{
			
			reset($ArrLeyesAux);
			while(list($c,$v)=each($ArrLeyesAux))
			{
				switch ($c)
				{
					case "02":
						$Unidad="Kg";
						break;
					case "04":
						$Unidad="g/t";
						break;
					case "05":
						$Unidad="g/t";
						break;
					default:
						$Unidad="Kg";
						break;
				}
				if($c!='01')
					echo "<td align=\"center\">".$v[1]."<br>(".$Unidad.")</td>\n";
			}
		}	
		echo "</tr>\n";
		//CONSULTA LOS TIPOS DE RECEPCION
		$Consulta = "select distinct t1.cod_recepcion, t3.nombre_subclase as desc_a";
		$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
		$Consulta.= " on t1.lote = t2.lote left join proyecto_modernizacion.sub_clase t3 on t3.cod_clase ='3104' and t1.cod_recepcion=t3.nombre_subclase ";
		$Consulta.= " where t1.lote<>'' ";
		$Consulta.= " and t2.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."'";			
		$Consulta.= " and t1.cod_producto = '".$Fila01["cod_producto"]."' ";
		$Consulta.= " and t1.cod_subproducto = '".$Fila01["cod_subproducto"]."' ";
		if ($CmbRecepcion!='S')
			$Consulta.= " and t1.cod_recepcion= '".$CmbRecepcion."' ";
		if ($CmbProveedor != "S")
			$Consulta.= " and t1.rut_proveedor = '".$CmbProveedor."' ";
		$Consulta.= " order by t1.cod_recepcion ";
		//echo $Consulta."<br>";
		$RutPrv2='';
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
				echo "<tr >\n";
				echo "<td colspan=\"".$ColSpan."\">&nbsp;</td>\n";
				echo "</tr>\n";	
				echo "<tr class=\"Detalle01\">\n";
				echo "<td align=\"left\" colspan=\"".$ColSpan."\">".$FilaAux["rut_proveedor"]."&nbsp;&nbsp;".substr(strtoupper($NomProveedor),0,30)."</td>\n";
				echo "</tr>\n";				
				$Consulta = "select distinct t1.lote, t2.recargo, t1.rut_proveedor, t2.peso_neto as peso_hum,  ";
				$Consulta.= " lpad(t2.recargo,2,'0') as orden, t2.fecha_recepcion,tipo_remuestreo ";		
				$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
				$Consulta.= " on t1.lote = t2.lote ";			
				$Consulta.= " where t1.cod_producto = '".$Fila01["cod_producto"]."' ";
				$Consulta.= " and t1.cod_subproducto = '".$Fila01["cod_subproducto"]."' ";
				//$Consulta.= " and t2.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."'";
				$Consulta.= " and ((t2.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."' ";
				if($CmbAno=='2005')
				{	
					$Consulta.= " AND left(num_lote_remuestreo,3) in ('".substr($CmbAno,3,1).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."',''))";
					$Consulta.= " or (tipo_remuestreo='A' AND left(num_lote_remuestreo,3)='".substr($CmbAno,3,1).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."'))";
				}
				else
				{	
					$Consulta.= " AND left(num_lote_remuestreo,4) in ('".substr($CmbAno,2,2).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."',''))";
					$Consulta.= " or (tipo_remuestreo='A' AND left(num_lote_remuestreo,4)='".substr($CmbAno,2,2).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."'))";	
				}	
				$Consulta.= " and t1.rut_proveedor = '".$FilaAux["rut_proveedor"]."' ";
				$Consulta.= " and t1.cod_recepcion = '".$FilaAux["cod_recepcion"]."' ";					
				$Consulta.= " and t1.estado_lote <>'6' group by t1.lote order by t1.lote, orden";
				$RespLote = mysqli_query($link, $Consulta);
				//echo $Consulta."<br>";
				$EsPlamen=false;
				while($FilaLote=mysqli_fetch_array($RespLote))
				{
					echo "<tr>";
					echo "<td align=\"center\">".$FilaLote["lote"]."</td>";
					echo "<td align=\"center\">".substr($FilaLote[fecha_recepcion],8,2)."/".substr($FilaLote[fecha_recepcion],5,2)."/".substr($FilaLote[fecha_recepcion],0,4)."</td>";
					$DatosLote= array();
					reset($ArrLeyes);
					$DatosLote["lote"]=$FilaLote["lote"];
					LeyesLote(&$DatosLote,&$ArrLeyes,"N","S","S",$TxtFechaIni,$TxtFechaFin,$TxtFechaCon);
					$PesoLoteS_R=$DatosLote["peso_seco"];
					//$PesoLoteS=$DatosLote["peso_seco2"];
					if($FilaLote[tipo_remuestreo]=='A')
					{
						$PesoLoteS=$DatosLote["peso_seco2_ori"];
						$PesoLoteH=$DatosLote["peso_humedo_ori"];
					}	
					else
					{
						$PesoLoteS=$DatosLote["peso_seco2"];
						$PesoLoteH=$DatosLote["peso_humedo"];
					}	
					//$PesoLoteH=$DatosLote["peso_humedo"];
					$CantDecPeso=0;$CantDecLF=0;
					if($Fila01["recepcion"]=='PMN')
					{
						$EsPlamen=true;
						$CantDecPeso=4;$CantDecLF=4;
						$PesoLoteS=$DatosLote["peso_seco"];
					}
					echo "<td align=\"right\">".number_format($PesoLoteH,$CantDecPeso,',','.')."</td>";
					if ($OptFinos != "S")
						echo "<td align=\"right\">".number_format($PesoLoteS,$CantDecPeso,',','.')."</td>";
					//LEYES
					if ($OptLeyes == "S")
					{
						reset($ArrLeyes);
						while(list($c,$v)=each($ArrLeyes))
						{
							if($c!='')
							{
								//if($DatosLote["tipo_remuestreo"]!="A")
								//{
									if($c!='01')
										if($v[10]=='S')
										{
											if ($v[9]>0 && $ArrLeyesAux[$c][3]>0 && $PesoLoteS>0)
												echo "<td align=\"right\">".number_format((($v[9]*$ArrLeyesAux[$c][3])/$PesoLoteS),$ArrLeyesAux[$c][5],',','.')."</td>\n";
											else
												echo "<td align=\"right\">".number_format(0,$ArrLeyesAux[$c][5],',','.')."</td>\n";
										}
										else
										{
											if ($v[23]>0 && $ArrLeyesAux[$c][3]>0 && $PesoLoteS>0)
												echo "<td align=\"right\">".number_format((($v[23]*$ArrLeyesAux[$c][3])/$PesoLoteS),$ArrLeyesAux[$c][5],',','.')."</td>\n";
											else
												echo "<td align=\"right\">".number_format(0,$ArrLeyesAux[$c][5],',','.')."</td>\n";
										}
									else
										if($DatosLote["tipo_remuestreo"]!="A")
											echo "<td align=\"right\">".number_format($v[2],$ArrLeyesAux[$c][5],',','.')."</td>\n";
										else
											echo "<td align=\"right\">".number_format($v[60],$ArrLeyesAux[$c][5],',','.')."</td>\n";
								//}
								//else
								//	echo "<td align=\"right\">".number_format($v[60],$ArrLeyesAux[$c][5],',','.')."</td>\n";	
							}		
						}
					}										
					if ($OptFinos == "S")
						//PESO SECO
						echo "<td align=\"right\">".number_format($PesoLoteS,$CantDecLF,',','.')."</td>";
					//FINOS
					reset($ArrLeyes);
					while(list($c,$v)=each($ArrLeyes))
					{
						if($c!='')
						{
							if ($OptFinos == "S")
								if($c!='01')
									if($v[10]=='S')
									{
										$Ley=(($v[9]*$ArrLeyesAux[$c][3])/$PesoLoteS);
										$Fino=($PesoLoteS_R*$Ley)/$ArrLeyesAux[$c][3];
										//echo "<td align=\"right\">".number_format((($v[8]/$ArrLeyesAux[$c][3])*$PesoLoteS),0,',','.')."</td>\n";
										echo "<td align=\"right\">".number_format($Fino,0,',','.')."</td>\n";
									}	
									else
										echo "<td align=\"right\">".number_format($v[23],0,',','.')."</td>\n";										
						}		
					}					
					reset($ArrLeyes);
					do {			 
						$key = key ($ArrLeyes);
						$ArrLeyes[$key][2] = "";
						$ArrLeyes[$key][23] = "";
						$ArrLeyes[$key][9] = "";
						$ArrLeyes[$key][10] = "";
						$ArrLeyes[$key][8] = "";
					} while (next($ArrLeyes));	
					echo "</tr>";						
				}
				//TOTAL PROVEEDOR
				echo "<tr class=\"Detalle01\">\n";
				echo "<td align=\"left\" colspan=\"2\">TOTAL ".$FilaAux["rut_proveedor"]."</td>";
				$ArrDatos=array();
				$ArrLeyesProv=array();
				reset($ArrLeyes);
				while(list($c,$v)=each($ArrLeyes))
				{
					$ArrLeyesProv[$c][0]=$c;
				}
				reset($ArrLeyesProv);
				LeyesProveedor($FilaAux["cod_recepcion"],$FilaAux["rut_proveedor"],'1',$Fila01["cod_subproducto"],&$ArrDatos,&$ArrLeyesProv,'N','S','S',$TxtFechaIni,$TxtFechaFin,$TxtFechaCon);
				$CantDecPeso=0;$CantDecLF=0;
				$PesoS=$ArrDatos[peso_seco3];
				if($EsPlamen==true)
				{
					$CantDecPeso=4;$CantDecLF=4;
					$PesoS=$ArrDatos["peso_seco"];
				}
				echo "<td align=\"right\">".number_format($ArrDatos["peso_humedo"],$CantDecPeso,',','.')."</td>";
				if ($OptFinos != "S")
					echo "<td align=\"right\">".number_format($PesoS,$CantDecLF,',','.')."</td>";
				//LEYES
				if ($OptLeyes == "S")
				{
					reset($ArrLeyesProv);
					while(list($c,$v)=each($ArrLeyesProv))
					{
						if($c!='')
						{							
							if ($c=="01")
							{
								echo "<td align=\"right\">".number_format($v[2],$ArrLeyesAux[$c][5],',','.')."</td>\n";
							}
							else							
							{
								if($ArrDatos["peso_seco"]!=0)
									if ($c=="02" || $c=="04" || $c=="05")
										echo "<td align=\"right\">".number_format((($v[8]/$ArrDatos["peso_seco"])*$ArrLeyesAux[$c][3]),$ArrLeyesAux[$c][5],',','.')."</td>\n";
									else
										echo "<td align=\"right\">".number_format((($v[23]/$ArrDatos["peso_seco"])*$ArrLeyesAux[$c][3]),$ArrLeyesAux[$c][5],',','.')."</td>\n";
								else
									echo "<td align=\"right\">0</td>\n";
							}
						}														
					}
				}																
				//FINOS
				if ($OptFinos == "S")
					//PESO SECO
					echo "<td align=\"right\">".number_format($PesoS,$CantDecPeso,',','.')."</td>";
				reset($ArrLeyesProv);
				while(list($c,$v)=each($ArrLeyesProv))
				{
					if($c!='')
					{
						if ($OptFinos == "S")
							if($c!='01')
								echo "<td align=\"right\">".number_format($v[8],0,',','.')."</td>\n";
					}		
				}
				reset($ArrLeyesProv);
				do {			 
					$key = key ($ArrLeyesProv);
					$ArrLeyesProv[$key][2] = "";
					$ArrLeyesProv[$key][23] = "";
					$ArrLeyesProv[$key][9] = "";
					$ArrLeyesProv[$key][10] = "";
					$ArrLeyesProv[$key][8] = "";
				} while (next($ArrLeyesProv));	
				
				echo "</tr>\n";
				$RutPrv=$RutPrv."'".$FilaAux["rut_proveedor"]."',";
				$RutPrv2=$RutPrv2."'".$FilaAux["rut_proveedor"]."',";
			}
			//TOTAL TIPO RECEPCION
			//TOTAL TIPO RECEPCION
			echo "<tr bgcolor=\"#CCCCCC\"><td align=\"left\" colspan=\"2\">TOTAL&nbsp;".strtoupper($FilaTipoRecep["desc_a"])."</td>\n";
			$RutPrv=substr($RutPrv,0,strlen($RutPrv)-1);
			$RutPrv="(".$RutPrv.")";
			$ArrDatos=array();
			$ArrLeyesProd=array();
			reset($ArrLeyes);
			while(list($c,$v)=each($ArrLeyes))
			{
				$ArrLeyesProd[$c][0]=$c;
			}
			reset($ArrLeyesProd);
			LeyesProducto('',$RutPrv,$FilaTipoRecep["cod_recepcion"],'1',$Fila01["cod_subproducto"],&$ArrDatos,&$ArrLeyesProd,'N','S','S',$TxtFechaIni,$TxtFechaFin,$TxtFechaCon);
			$CantDecPeso=0;$CantDecLF=0;
			if ($CmbProveedor != "S")
			{	
				$PesoS=$ArrDatos[peso_seco3];
				$PesoT=$ArrDatos[peso_seco3];
			}	
			else
			{
				$PesoS=$ArrDatos["peso_seco"];
				$PesoT=$ArrDatos[peso_seco3];
			}
			if($EsPlamen==true)
			{
				$CantDecPeso=4;$CantDecLF=4;
				$PesoS=$ArrDatos["peso_seco"];
			}
			echo "<td align=\"right\">".number_format($ArrDatos["peso_humedo"],$CantDecPeso,',','.')."</td>";
			if ($OptFinos!="S")
				echo "<td align=\"right\">".number_format($PesoS,$CantDecLF,',','.')."</td>";	
			//LEYES
			if ($OptLeyes == "S")
			{
				reset($ArrLeyesProd);
				while(list($c,$v)=each($ArrLeyesProd))
				{
					if($c!='')
					{					
						if ($c=="01")
						{
							echo "<td align=\"right\">".number_format($v[2],2,',','.')."</td>\n";
						}
						else							
						{
							if ($c=="02" || $c=="04" || $c=="05")
							{
								/*echo $v[8]."<br>";
								echo $ArrDatos[peso_seco3]."<br>";
								echo $ArrLeyesAux[$c][3]."<br>";
								echo ($v[8]/$ArrDatos["peso_seco"])*$ArrLeyesAux[$c][3]."<br>";
								echo $ArrLeyesAux[$c][5]."<br><br>";*/
								echo "<td align=\"right\">".number_format((($v[8]/$ArrDatos["peso_seco"])*$ArrLeyesAux[$c][3]),$ArrLeyesAux[$c][5],',','.')."</td>\n";
							}	
							else
								echo "<td align=\"right\">".number_format((($v[23]/$ArrDatos["peso_seco"])*$ArrLeyesAux[$c][3]),$ArrLeyesAux[$c][5],',','.')."</td>\n";
						}
					}
				}
			}					
			//FINOS
			if ($OptFinos == "S")
				//PESO SECO
				echo "<td align=\"right\">".number_format($PesoT,$CantDecPeso,',','.')."</td>";	
			reset($ArrLeyesProd);
			while(list($c,$v)=each($ArrLeyesProd))
			{
				if($c!='')
				{
					if ($OptFinos == "S")
						if($c!='01')
							echo "<td align=\"right\">".number_format($v[8],0,',','.')."</td>\n";
				}		
			}
			echo "</tr>\n";
		}//FIN TIPO RECEPCION
		//TOTAL PRODUCTO
		echo "<tr class=\"ColorTabla02\" bgcolor=\"#CCCCCC\"><td align=\"left\" colspan=\"2\">TOTAL: ".str_pad($Fila01["cod_subproducto"],2,'0',STR_PAD_LEFT)." ".strtoupper($NomSubProd)."</td>\n";
		reset($ArrLeyes);
		do {			 
			$k = key ($ArrLeyes);			
			$ArrLeyes[$k][2] = "";
			$ArrLeyes[$k][23] = "";
			$ArrLeyes[$k][8] = "";
			$ArrLeyes[$k][9] = "";
			$ArrLeyes[$k][10] = "";
		} while (next($ArrLeyes));	
		$ArrDatos=array();
		$RutPrv2=substr($RutPrv2,0,strlen($RutPrv2)-1);
		$RutPrv2="(".$RutPrv2.")";
		$ArrDatos=array();
		$ArrLeyesProd2=array();
		reset($ArrLeyes);
		while(list($c,$v)=each($ArrLeyes))
		{
			$ArrLeyesProd2[$c][0]=$c;
		}
		reset($ArrLeyesProd2);
		if ($CmbRecepcion!="S")
			LeyesProducto('',$RutPrv2,'','1',$Fila01["cod_subproducto"],&$ArrDatos,&$ArrLeyesProd2,'N','S','S',$TxtFechaIni,$TxtFechaFin,$TxtFechaCon);
		else
			LeyesProducto('',$RutPrv2,$CmbRecepcion,'1',$Fila01["cod_subproducto"],&$ArrDatos,&$ArrLeyesProd2,'N','S','S',$TxtFechaIni,$TxtFechaFin,$TxtFechaCon);
		$CantDecPeso=0;$CantDecLF=0;
		if ($CmbProveedor != "S")
		{	
			$PesoS=$ArrDatos["peso_seco"];
			$PesoT=$ArrDatos[peso_seco3];
		}	
		else
		{
			$PesoS=$ArrDatos["peso_seco"];
			$PesoT=$ArrDatos[peso_seco3];
		}
		if($EsPlamen==true)
		{
			$CantDecPeso=4;$CantDecLF=4;
			$PesoS=$ArrDatos["peso_seco"];
		}
		echo "<td align=\"right\">".number_format($ArrDatos["peso_humedo"],$CantDecPeso,',','.')."</td>";
		if ($OptFinos != "S")
			echo "<td align=\"right\">".number_format($PesoT,$CantDecLF,',','.')."</td>";
		//LEYES
		if ($OptLeyes == "S")
		{
			reset($ArrLeyesProd2);
			while(list($c,$v)=each($ArrLeyesProd2))
			{
				if($c!='')
				{					
					if ($c=="01")
					{
						echo "<td align=\"right\">".number_format($v[2],2,',','.')."</td>\n";
					}
					else							
					{
						if ($c=="02" || $c=="04" || $c=="05")
						{
							/*echo $v[8]."<br>";
							echo $ArrDatos[peso_seco3]."<br>";
							echo $ArrLeyesAux[$c][3]."<br>";
							echo ($v[8]/$ArrDatos["peso_seco"])*$ArrLeyesAux[$c][3]."<br>";
							echo $ArrLeyesAux[$c][5]."<br><br>";*/
							if($ArrDatos["peso_seco"]!=0)
								echo "<td align=\"right\">".number_format((($v[8]/$ArrDatos["peso_seco"])*$ArrLeyesAux[$c][3]),$ArrLeyesAux[$c][5],',','.')."</td>\n";
							else
								echo "<td align=\"right\">0</td>\n";
						}	
						else
							echo "<td align=\"right\">".number_format((($v[23]/$ArrDatos["peso_seco"])*$ArrLeyesAux[$c][3]),$ArrLeyesAux[$c][5],',','.')."</td>\n";
					}
				}
			}
		}		
		//FINOS
		if ($OptFinos == "S")
			//PESO SECO
			echo "<td align=\"right\">".number_format($PesoT,$CantDecLF,',','.')."</td>";
		reset($ArrLeyesProd2);
		while(list($c,$v)=each($ArrLeyesProd2))
		{
			if($c!='')
			{
				if($c!='01')
				{
					$ArrLeyesInf[$c][8]=$ArrLeyesInf[$c][8] + $v[8];
					if ($OptFinos == "S")
					{							
						echo "<td align=\"right\">".number_format($v[8],0,',','.')."</td>\n";
					}
				}
			}		
		}
		$TotInfPesoHum=$TotInfPesoHum + $ArrDatos["peso_humedo"];
		/*if ($CmbProveedor != "S")
			$TotInfPesoSeco=$TotInfPesoSeco + $PesoT;
		else*/
		$TotInfPesoSeco=$TotInfPesoSeco + $PesoS;
		$TotInfPesoSecoAux=$TotInfPesoSecoAux + $PesoT;
		echo "</tr>\n";			
	}//FIN PRODUCTOS
	$Consulta = "select distinct t1.cod_producto, t1.cod_subproducto, lpad(t1.cod_subproducto,4,'0') as orden ,recepcion ";
	$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
	$Consulta.= " on t1.lote = t2.lote inner join proyecto_modernizacion.subproducto t3 on t1.cod_producto=t3.cod_producto ";
	$Consulta.= " and t1.cod_subproducto=t3.cod_subproducto ";
	$Consulta.= " where t1.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."' ";
	if ($CmbRecepcion!='S')
		$Consulta.= " and t1.cod_recepcion= '".$CmbRecepcion."' ";
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
	if ($Fila01 = mysqli_fetch_array($Resp01))	
	{	
		//TOTAL INFORME
		echo "<tr class=\"ColorTabla02\" bgcolor=\"#CCCCCC\"><td align=\"left\" colspan=\"2\">TOTAL INFORME</td>\n";		
		echo "<td align=\"right\">".number_format($TotInfPesoHum,0,',','.')."</td>";
		if ($OptFinos != "S")
			echo "<td align=\"right\">".number_format($TotInfPesoSeco,0,',','.')."</td>";	
		if (round($TotInfPesoHum)!=round($TotInfPesoSeco))
			$TotInfPorcHum=100-($TotInfPesoSeco/$TotInfPesoHum*100);
		else
			$TotInfPorcHum=0;
		echo "<td align=\"right\">".number_format($TotInfPorcHum,2,',','.')."</td>";
		//LEYES
		reset($ArrLeyesInf);
		while(list($c,$v)=each($ArrLeyesInf))
		{
			$Decimales=0;		
			if($c!='')
			{		
				if ($OptLeyes == "S")		
				{
					switch ($c)
					{			
						case "02":
							$Decimales=2;
							if($TotInfPesoSeco!=0)
								$Valor=$v[8]/$TotInfPesoSeco*100;
							else
								$Valor=0;
							break;
						case "04":
							$Decimales=0;
							if($TotInfPesoSeco!=0)
								$Valor=$v[8]/$TotInfPesoSeco*1000;
							else
								$Valor=0;
							break;
						case "05":
							$Decimales=1;
							if($TotInfPesoSeco!=0)							
								$Valor=$v[8]/$TotInfPesoSeco*1000;
							else
								$Valor=0;
							break;
					}
					
					echo "<td align=\"right\">".number_format($Valor,$Decimales,',','.')."</td>\n";
				}
			}
		}
		reset($ArrLeyesInf);		
		//FINOS
		if ($OptFinos == "S")
			echo "<td align=\"right\">".number_format($TotInfPesoSecoAux,0,',','.')."</td>";		
		while(list($c,$v)=each($ArrLeyesInf))
		{
			if($c!='')
			{
				if ($OptFinos == "S")
				{
					if($c!='01')
						echo "<td align=\"right\">".number_format($v[8],$CantDecLF,',','.')."</td>\n";
				}
			}
		}
		echo "</tr>\n";
	}	
	echo "</table>\n";
	?>  
</form>
</body>
</html>