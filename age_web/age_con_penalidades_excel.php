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
	$ContLeyes=0;
	$ArrLeyes=array();
	$ArrLeyesAux=array();
	$ArrTotalesPrv=array();
	$ArrTotalesAsig=array();
	$ArrTotalesProd=array();
	$Datos=explode('//',$TxtCodLeyes);
	$ExisteAgua="N";	
	foreach($Datos as $c => $v)
	{
		$Datos2=explode('~',$v);
		if($Datos2[0]!='')
		{
			$ArrLeyesAux[$Datos2[0]][0]=$Datos2[0];//CODIGO LEY
			$ArrLeyesAux[$Datos2[0]][1]=$Datos2[1];//NOMBRE LEY
			$ArrLeyesAux[$Datos2[0]][2]=$Datos2[2];//LIMITE MINIMO
			$ArrLeyesAux[$Datos2[0]][3]=$Datos2[3];//LIMITE MEDIO
			$ArrLeyesAux[$Datos2[0]][4]=$Datos2[4];//LIMITE MAXIMO
			$ArrLeyesAux[$Datos2[0]][5]=$Datos2[5];//COD UNIDAD
			$ArrLeyesAux[$Datos2[0]][6]=$Datos2[6];//CONVERSION
			$ArrLeyesAux[$Datos2[0]][7]=$Datos2[7];//NOMBRE UNIDAD
			$ArrLeyesAux[$Datos2[0]][8]=$Datos2[8];//DECIMALES
			$ArrLeyes[$Datos2[0]][0]=$Datos2[0];//CODIGO LEY
			$ArrLeyes[$Datos2[0]][1]=$Datos2[1];//NOMBRE LEY
			if($Datos2[0]=="01")
				$ExisteAgua="S";
			$ArrTotalesPrv[$Datos2[0]][0]=$Datos2[0];//CODIGO LEY
			$ArrTotalesPrv[$Datos2[0]][1]=0;//SUMA DOLARES
			$ArrTotalesAsig[$Datos2[0]][0]=$Datos2[0];//CODIGO LEY
			$ArrTotalesAsig[$Datos2[0]][1]=0;//SUMA DOLARES
			$ArrTotalesProd[$Datos2[0]][0]=$Datos2[0];//CODIGO LEY
			$ArrTotalesProd[$Datos2[0]][1]=0;//SUMA DOLARES
			$ContLeyes=$ContLeyes+1;
		}	
		//echo $Datos2[0]."-".$Datos2[1]."-".$Datos2[2]."-".$Datos2[3]."-".$Datos2[4]."<br>";
	}
	if($ExisteAgua=="N")
	{
		$ArrLeyes["01"][0]="01";//CODIGO LEY
		$ArrLeyes["01"][1]="H2O";//NOMBRE LEY
	}	
?>
<html>
<head>
<title>AGE-Penalidades</title>
</head>

<body>
<form name="frmPrincipal" action="" method="post">
  <table width="620" border="0" align="center">
    <tr>
      <td width="294" colspan="3">CODELCO CHILE<br>
        DIVISION VENTANAS    V-1   <br> </td>
      <td width="296" align="right" colspan="3">FECHA:&nbsp;<?php echo date("d-m-Y")?></td>
    </tr>
    <tr align="center">
      <td height="30" colspan="6"><strong><u>INFORME PENALIDADES</u></strong></td>
    </tr>
    <tr align="center">
      <td colspan="6">MES: <?php echo $CmbMes."-".$CmbAno; ?></td>
    </tr>
  </table>
  <br>
	<?php
	$ColSpan=3;
	reset($ArrLeyesAux);
	while(list($c,$v)=each($ArrLeyesAux))
	{
		if($c!='')
			$ColSpan=$ColSpan+2;
	}
	echo "<table width=\"750\"  border=\"1\" align=\"center\" cellpadding=\"3\" cellspacing=\"0\">\n";
	//CONSULTA LOS TIPOS DE RECEPCION
	$Consulta = "select distinct t1.cod_recepcion, t3.nombre_subclase as desc_a";
	$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
	$Consulta.= " on t1.lote = t2.lote left join proyecto_modernizacion.sub_clase t3 on t3.cod_clase ='3104' and t1.cod_recepcion=t3.nombre_subclase ";
	$Consulta.= " where t1.lote<>'' ";
	$Consulta.= " and t2.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."'";			
	if ($CmbRecepcion!='S')
		$Consulta.= " and t1.cod_recepcion= '".$CmbRecepcion."' ";
	if ($CmbSubProducto != "S")
	{
		$Consulta.= " and t1.cod_producto = '1' ";
		$Consulta.= " and t1.cod_subproducto = '".$CmbSubProducto."' ";
	}
	if ($CmbProveedor != "S")
		$Consulta.= " and t1.rut_proveedor = '".$CmbProveedor."' ";
	$Consulta.= " order by t1.cod_recepcion ";
	//echo $Consulta."<br>";
	$RutPrv2='';
	$RespTipoRecep = mysqli_query($link, $Consulta);
	while ($FilaTipoRecep = mysqli_fetch_array($RespTipoRecep))
	{					
		//TITULO COD RECEPCION
		echo "<tr class='ColorTabla01' >\n";
		if ($ChkDetalle!="L")
			$ColSpan = $ColSpan + 2;	
		if ($FilaTipoRecep["desc_a"] == "" || is_null($FilaTipoRecep["desc_a"]))
			echo "<td align=\"left\" colspan=\"".$ColSpan."\">&nbsp;</td>\n";				
		else
			echo "<td align=\"left\" colspan=\"".$ColSpan."\">".strtoupper($FilaTipoRecep["desc_a"])."</td>\n";		
		echo "</tr>\n";
		reset($ArrTotalesAsig);
		do {			 
			$key = key ($ArrTotalesAsig);
			$ArrTotalesAsig[$key][1] = 0;
		} while (next($ArrTotalesAsig));	
		//TITULO						
		echo "<tr class=\"ColorTabla02\">\n";		
		if ($ChkDetalle=="L")
		{							
			echo "<td align=\"center\" rowspan=\"2\">Lote</td>\n";
			echo "<td align=\"center\" rowspan=\"2\">F.Recep.</td>\n";		
			echo "<td align=\"center\" rowspan=\"2\">P.Seco.<br>(Kg)</td>\n";
			echo "<td align=\"center\" rowspan=\"2\">Merma</td>\n";
			echo "<td align=\"center\" rowspan=\"2\">F.Merma</td>\n";
		}
		else
		{
			echo "<td align=\"center\" rowspan=\"2\" colspan=\"4\">Proveedor</td>\n";
			echo "<td align=\"center\" rowspan=\"2\">Merma</td>\n";
			echo "<td align=\"center\" rowspan=\"2\">F.Merma</td>\n";
		}
		echo "<td align=\"center\" colspan=\"".($ContLeyes*2)."\">Penalidades</td>\n";
		echo "</tr>";
		echo "<tr class=\"ColorTabla02\">\n";
		$Anito = substr($TxtFechaIni,0,4);
		$Mesi = substr($TxtFechaIni,5,2);
		reset($ArrLeyesAux);
		while(list($c,$v)=each($ArrLeyesAux))
		{
			if($c!='')
			{
				echo "<td align=\"center\">".$v[1]."(".$v[7].")</td>\n";
				echo "<td align=\"center\">(US$)</td>\n";
			}	
		}
		echo "</tr>\n";
		$Consulta = "select distinct t1.cod_producto, t1.cod_subproducto, lpad(t1.cod_subproducto,4,'0') as orden ,recepcion ";
		$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
		$Consulta.= " on t1.lote = t2.lote inner join proyecto_modernizacion.subproducto t3 on t1.cod_producto=t3.cod_producto ";
		$Consulta.= " and t1.cod_subproducto=t3.cod_subproducto ";
		$Consulta.= " where t1.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."' ";
		if ($CmbRecepcion!='S')
			$Consulta.= " and t1.cod_recepcion= '".$FilaTipoRecep[cod_recepcion]."' ";
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
			echo "<tr bgcolor=\"#CCCCCC\">\n";			
			$Consulta = "select * from proyecto_modernizacion.subproducto ";
			$Consulta.= "where cod_producto = '".$Fila01["cod_producto"]."' and cod_subproducto='".$Fila01["cod_subproducto"]."'";		
			$RespAux2 = mysqli_query($link, $Consulta);
			if ($FilaAux2 = mysqli_fetch_array($RespAux2))
			{
				$NomSubProd = $FilaAux2["descripcion"];
			}
			else
				$NomSubProd = "SIN IDENTIFICACION";
			 if ($ChkDetalle!="L")
				$ColSpan = $ColSpan + 1;
			echo "<td align=\"left\" colspan=\"".$ColSpan."\">".str_pad($Fila01["cod_subproducto"],2,'0',STR_PAD_LEFT)." - ".$NomSubProd."</td>";					
			echo "</tr>\n";
			reset($ArrTotalesProd);
			do {			 
				$key = key ($ArrTotalesProd);
				$ArrTotalesProd[$key][1] = 0;
			} while (next($ArrTotalesProd));
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
				if ($ChkDetalle=="L")
				{		
					echo "<tr class=\"Detalle01\">\n";
					echo "<td align=\"left\" colspan=\"".$ColSpan."\">".$FilaAux["rut_proveedor"]."&nbsp;&nbsp;".substr(strtoupper($NomProveedor),0,30)."</td>\n";
					echo "</tr>\n";				
				}
				reset($ArrTotalesPrv);
				do {			 
					$key = key ($ArrTotalesPrv);
					$ArrTotalesPrv[$key][1] = 0;
				} while (next($ArrTotalesPrv));	
				$CodLoteIni=substr($CmbAno,3,1).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."000";
				$CodLoteFin=substr($CmbAno,3,1).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."999";		
				$Consulta = "select distinct t1.lote, t2.recargo, t1.rut_proveedor, t2.peso_neto as peso_hum,  ";
				$Consulta.= " lpad(t2.recargo,2,'0') as orden, t2.fecha_recepcion, t1.tipo_remuestreo ";		
				$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
				$Consulta.= " on t1.lote = t2.lote ";			
				$Consulta.= " where t1.cod_producto = '".$Fila01["cod_producto"]."' ";
				$Consulta.= " and t1.cod_subproducto = '".$Fila01["cod_subproducto"]."' ";
				$Consulta.= " and t1.rut_proveedor = '".$FilaAux["rut_proveedor"]."' ";
				$Consulta.= " and t1.cod_recepcion = '".$FilaAux["cod_recepcion"]."' ";					
				//$Consulta.= " and (t1.estado_lote <>'6'  or (t1.estado_lote='6' and t1.mostrar_lote='S')) ";
				//$Consulta.= " and ((t2.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."' and t1.tipo_remuestreo <>'A')  or (t1.tipo_remuestreo='A' and substring(t1.num_lote_remuestreo,1,3)='".substr($CodLoteIni,0,3)."'))";	
				$Consulta.= " and (t1.estado_lote <>'6'  or (t1.estado_lote='6' and t1.mostrar_lote='S')) ";
				$Consulta.= " and (t1.tipo_remuestreo <>'A'  or (t1.tipo_remuestreo='A' and substring(t1.num_lote_remuestreo,1,3)='".substr($CodLoteIni,0,3)."'))";				
				$Consulta.= " and t2.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."'";
				$Consulta.= " group by t1.lote order by t1.lote, orden";
				$RespLote = mysqli_query($link, $Consulta);
				//echo $Consulta."<br>";
				$PorcMerma=0;$SiMerma=0;$VarMerma=0;$PrvMerma=0;$FechaM="";$FechaM1="";
				$Consulta1 = "select ifnull(porc,0) as merma,rut_proveedor, fecha  from age_web.mermas ";
				$Consulta1.= " where cod_producto='".$Fila01["cod_producto"]."' ";
				$Consulta1.= " and cod_subproducto='".$Fila01["cod_subproducto"]."' ";
				$Consulta1.=" and ((year(fecha) < '".$CmbAno."') or (year(fecha) = '".$CmbAno."' and month(fecha) <= '".$CmbMes."'))";
				$RespMerma=mysqli_query($link, $Consulta1);
				while ($FilaMerma=mysqli_fetch_array($RespMerma))
				{
					if($FilaMerma["rut_proveedor"]=="")
					{
						$VarMerma=$FilaMerma[merma];
						$FechaM=substr($FilaMerma["fecha"],5,2)."-".substr($FilaMerma["fecha"],0,4);
					}
					$Consulta2= "select ifnull(porc,0) as mermas, fecha  from age_web.mermas ";
					$Consulta2.= " where cod_producto='".$Fila01["cod_producto"]."' ";
					$Consulta2.= " and cod_subproducto='".$Fila01["cod_subproducto"]."' ";
					$Consulta2.= " and rut_proveedor = '".$FilaAux["rut_proveedor"]."' ";
					$Consulta2.=" and ((year(fecha) < '".$CmbAno."') or (year(fecha) = '".$CmbAno."' and month(fecha) <= '".$CmbMes."'))";
					$RespM=mysqli_query($link, $Consulta2);
					if ($FilaM=mysqli_fetch_array($RespM))
					{
						$SiMerma = 1;
						$PrvMerma = $FilaM[merma];
						$FechaM1=substr($FilaM["fecha"],5,2)."-".substr($FilaM["fecha"],0,4);
					}
				}
				if($SiMerma==1)
				{
					$PorcMerma=str_replace(',','.',$PrvMerma);
					$FMerma = $FechaM1;
				}
				else
				{
					$PorcMerma=str_replace(',','.',$VarMerma);
					$FMerma = $FechaM;
				}

				while($FilaLote=mysqli_fetch_array($RespLote))
				{
					if ($ChkDetalle=="L")
					{
						echo "<tr>";
						echo "<td align=\"center\">".$FilaLote[lote]."</td>";
						echo "<td align=\"center\">".substr($FilaLote[fecha_recepcion],8,2)."/".substr($FilaLote[fecha_recepcion],5,2)."/".substr($FilaLote[fecha_recepcion],0,4)."</td>";
					}
					$DatosLote= array();
					reset($ArrLeyes);
					do {			 
						$key = key ($ArrLeyes);
						$ArrLeyes[$key][2] = "";	
						$ArrLeyes[$key][23] = "";							
					} while (next($ArrLeyes));
					reset($ArrLeyes);
					if ($FilaLote["tipo_remuestreo"]=="A")
					{
						$TxtFechaIniAux=substr($FilaLote[fecha_recepcion],0,4)."-".substr($FilaLote[fecha_recepcion],5,2)."-01";
						$TxtFechaFinAux=substr($FilaLote[fecha_recepcion],0,4)."-".substr($FilaLote[fecha_recepcion],5,2)."-31";;
						$DatosLote["penalidades"]="S";
					}
					else
					{
						$TxtFechaIniAux=$TxtFechaIni;
						$TxtFechaFinAux=$TxtFechaFin;
					}
					//echo $TxtFechaIniAux." / ".$TxtFechaFinAux."<br>";
					$DatosLote["lote"]=$FilaLote[lote];					
					LeyesLote(&$DatosLote,&$ArrLeyes,"N","S","S",$TxtFechaIniAux,$TxtFechaFinAux,"");
					$PesoLoteS=$DatosLote["peso_seco"];
					$PesoLoteS2=$DatosLote["peso_seco2"];
					$PesoLoteH=$DatosLote["peso_humedo"];
					$CantDecPeso=0;$CantDecLF=0;
					if($Fila01[recepcion]=='PMN')
						$CantDecPeso=4;$CantDecLF=0;
					if ($ChkDetalle=="L")
					{
						echo "<td align=\"right\">".number_format($PesoLoteS,0,',','.')."</td>";
						if ($PorcMerma!=0)
						{
							echo "<td align=\"right\">".number_format($PorcMerma,2,',','.')."</td>";
							echo "<td align=\"right\">".$FMerma."</td>";
						}
						else
						{
							echo "<td align=\"right\">&nbsp;</td>";
							echo "<td align=\"right\">&nbsp;</td>";
						}
						
					}
					reset($ArrLeyes);
					while(list($c,$v)=each($ArrLeyes))
					{				
						if($c!=''&&$v[1]!=''&&$PesoLoteS>0)
						{							
							$Mostrar=true;
							if ($c=="01"&&$ExisteAgua=='N')
								$Mostrar=false;
							if($Mostrar==true)
							{	
								if ($c=="01")
								{
									$FinoAux=$v[20]*$PesoLoteS/100;
									$ValorPorc=($FinoAux*$ArrLeyesAux[$v[0]][6])/$PesoLoteS;
									$ValorPorcAux=($FinoAux*$ArrLeyesAux[$v[0]][6])/$PesoLoteS2;
								}
								else
								{
									$ValorPorc=($v[23]*$ArrLeyesAux[$v[0]][6])/$PesoLoteS;
									$ValorPorcAux=($v[23]*$ArrLeyesAux[$v[0]][6])/$PesoLoteS2;
								}
								if ($ChkDetalle=="L")
								{
									if ($c=="01")
										echo "<td align=\"right\">".number_format($v[20],4,',','.')."</td>\n";
									else
										echo "<td align=\"right\">".number_format($v[2],4,',','.')."</td>\n";
								}
								$Dif=$ValorPorc-$ArrLeyesAux[$v[0]][3];
								if($ValorPorc>$ArrLeyesAux[$v[0]][3]&&$Dif>0)
								{
									if ($c=="01")
										$PesoAux=$PesoLoteH; //PESO HUMEDO
									else
										$PesoAux=$PesoLoteS; //PESO SECO
									if($ArrLeyesAux[$v[0]][2]!='0')
										$Cant=$Dif/$ArrLeyesAux[$v[0]][2];
									//else
										//$Cant=0;
									$PesoSecoTon=$PesoAux/1000;
									$ValorDolar=$Cant*$ArrLeyesAux[$v[0]][4]*$PesoSecoTon;
									if ($ChkDetalle=="L")
									{
											/*EXCEPCION DEBIDO QUE EL ARSENICO SE DISPARA Y GENERA PENALIDAD, 19-02-2016
										  Luis Adan Castillo - Intellego
											*/
										if($FilaLote[lote]=='15120527' && $v[0]=='08') 
										{
											echo "<td align=\"right\">0</td>\n";
											$ValorDolar=0;
											
										}else
										{
											echo "<td align=\"right\" bgcolor='FFFF00' onMouseOver=\"JavaScript:muestra('".$Cont."');\" onMouseOut=\"JavaScript:oculta('".$Cont."');\">";
											echo "".number_format($ValorDolar,2,",",".")."</td>\n";
										}
									
									}
									$Cont++;
									$ArrTotalesPrv[$v[0]][1]=$ArrTotalesPrv[$v[0]][1]+($ValorDolar);//SUMA DE DOLARES
									$ArrTotalesAsig[$v[0]][1]=$ArrTotalesAsig[$v[0]][1]+($ValorDolar);//SUMA DE DOLARES
									$ArrTotalesProd[$v[0]][1]=$ArrTotalesProd[$v[0]][1]+($ValorDolar);//SUMA DE DOLARES
								}	
								else
								{
									if ($ChkDetalle=="L")
									{
										echo "<td align=\"right\">0</td>\n";
									}
								}
							}	
						}	
					}
					if ($ChkDetalle=="L")
					{
						echo "</tr>";						
					}
				}
				if ($ChkDetalle=="L")
				{
					echo "<tr class=\"Detalle01\">\n";				
					echo "<td align=\"left\" colspan=\"5\">TOTAL US$ :".$NomProveedor."</td>";
				}
				else
				{	
					echo "<tr>\n";				
					echo "<td align=\"left\" colspan=\"5\">".$NomProveedor."</td>";
				}
				reset($ArrTotalesPrv);
				while(list($c,$v)=each($ArrTotalesPrv))
				{
					if($c!='') //&&$v[0]!='')
					{
						echo "<td align=\"right\">&nbsp;</td>\n";
						echo "<td align=\"right\">".number_format($v[1],2,",",".")."</td>\n";
					}				
				}
				echo "</tr>\n";
			}
			echo "<tr bgcolor=\"#CCCCCC\"><td align=\"left\" colspan=\"5\">TOTAL US$ :".str_pad($Fila01["cod_subproducto"],2,'0',STR_PAD_LEFT)." ".strtoupper($NomSubProd)."</td>\n";
			reset($ArrTotalesProd);
			while(list($c,$v)=each($ArrTotalesProd))
			{
				if($c!='')  //&&$v[0]!='')
				{
					echo "<td align=\"right\">&nbsp;</td>\n";
					echo "<td align=\"right\">".number_format($v[1],2,",",".")."</td>\n";
				}				
			}
			echo "</tr>\n";	
		}//FIN PRODUCTOS
		echo "<tr class=\"ColorTabla01\"><td align=\"left\" colspan=\"5\">TOTAL US$ :".strtoupper($FilaTipoRecep["desc_a"])."</td>\n";
		reset($ArrTotalesAsig);
		while(list($c,$v)=each($ArrTotalesAsig))
		{
			if($c!='') //&&$v[0]!='')
			{
				echo "<td align=\"right\">&nbsp;</td>\n";
				echo "<td align=\"right\">".number_format($v[1],2,",",".")."</td>\n";
			}				
		}
		echo "</tr>\n";
	}//FIN TIPO RECEPCION
	echo "</table>\n";
	?>  
</form>
</body>
</html>