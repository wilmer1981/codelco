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
	include("../age_web/age_funciones.php");	
	$CmbMes         = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:date('m');
	$CmbAno         = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:date("Y");
	$CmbRecepcion   = isset($_REQUEST["CmbRecepcion"])?$_REQUEST["CmbRecepcion"]:"";
	$CmbSubProducto = isset($_REQUEST["CmbSubProducto"])?$_REQUEST["CmbSubProducto"]:"";
	$CmbProveedor   = isset($_REQUEST["CmbProveedor"])?$_REQUEST["CmbProveedor"]:"";
	$ChkDetalle     = isset($_REQUEST["ChkDetalle"])?$_REQUEST["ChkDetalle"]:"";

	$SubProducto   = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";
	$Proveedor     = isset($_REQUEST["Proveedor"])?$_REQUEST["Proveedor"]:"";
	$Plantilla     = isset($_REQUEST["Plantilla"])?$_REQUEST["Plantilla"]:"";

	$TxtFiltroPrv  = isset($_REQUEST["TxtFiltroPrv"])?$_REQUEST["TxtFiltroPrv"]:"";
	$TxtFiltroPrv2  = isset($_REQUEST["TxtFiltroPrv2"])?$_REQUEST["TxtFiltroPrv2"]:"";
	$TxtLeyesMuestra  = isset($_REQUEST["TxtLeyesMuestra"])?$_REQUEST["TxtLeyesMuestra"]:""; 
	$TxtCodLeyes      = isset($_REQUEST["TxtCodLeyes"])?$_REQUEST["TxtCodLeyes"]:""; 
	$ChkDetalle       = isset($_REQUEST["ChkDetalle"])?$_REQUEST["ChkDetalle"]:"L";
	$EncontroRelacion = isset($_REQUEST["EncontroRelacion"])?$_REQUEST["EncontroRelacion"]:"";

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
			//echo $Datos2[0]." / ".$Datos2[2]." / ".$Datos2[3]." / ".$Datos2[4]."<br>";			
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
			
			$ArrTotalesAsig[$Datos2[0]][2]=0;//SUMA peso seco poly
			
			$ArrTotalesProd[$Datos2[0]][0]=$Datos2[0];//CODIGO LEY
			$ArrTotalesProd[$Datos2[0]][1]=0;//SUMA DOLARES
			$ArrTotalesProd[$Datos2[0]][2]=0;//SUMA (PESO*LEY)
			$ArrTotalesProd[$Datos2[0]][3]=0;//SUMA PESO
			$ContLeyes=$ContLeyes+1;
		}	
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

<body>
<form  name="frmPrincipal" action="" method="post">

  <table width="620" border="0" align="center">
    <tr>
      <td width="294">CODELCO CHILE<br>
        DIVISION VENTANAS       <br> </td>
      <td width="296" align="right">FECHA:&nbsp;<?php echo date("d-m-Y")?></td>
    </tr>
    <tr align="center">
      <td height="30" colspan="2"><strong><u>INFORME PENALIDADES</u></strong></td>
    </tr>
    <tr align="center">
      <td colspan="2">MES: <?php echo $CmbMes."-".$CmbAno; ?></td>
    </tr>
    <tr align="center">
      <td colspan="2"><input name="BtnImprimir" type="button" id="BtnImprimir" value="Imprimir" style="width:70px " onClick="Proceso('I')">
      <input name="BtnSalir"   type="button"  id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
    </tr>
  </table>  

  <br>
	<?php
	$ColSpan=3;
	reset($ArrLeyesAux);
	foreach($ArrLeyesAux as $c=>$v)
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
		}
		else
		{
			echo "<td align=\"center\" rowspan=\"2\" colspan=\"3\">Proveedor</td>\n";
		}
		echo "<td align=\"center\" colspan=\"".($ContLeyes*2)."\">Penalidades</td>\n";
		echo "</tr>";
		echo "<tr class=\"ColorTabla02\">\n";
		reset($ArrLeyesAux);
		foreach($ArrLeyesAux as $c=>$v)
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
			$Consulta.= " and t1.cod_recepcion= '".$FilaTipoRecep["cod_recepcion"]."' ";
		if ($CmbSubProducto!="S")
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

                    $ResultadoH2O =0;
                   $TotalHumedo = 0;
                   $ResultadoAs = 0;
                   $TotalSeco1  = 0;
                    $TotalSeco = 0;
                   $ResultadoSb = 0;
                   $TotalSeco2  = 0;
                   $ResultadoZn =  0;
                   $TotalSeco3  =  0;
                   $ResultadoPb =  0;
                   $TotalSeco4  =  0;
                   $ResultadoHg =  0;
                   $TotalSeco5  =  0;
                   $ResultadoCd =  0;
                   $TotalSeco6  =  0;
			echo "<tr bgcolor=\"#CCCCCC\">\n";			
			$Consulta = "select * from proyecto_modernizacion.subproducto ";
			$Consulta.= "where cod_producto = '".$Fila01["cod_producto"]."' and cod_subproducto='".$Fila01["cod_subproducto"]."'";		
			$RespAux2 = mysqli_query($link, $Consulta);
			if ($FilaAux2 = mysqli_fetch_array($RespAux2))
				$NomSubProd = $FilaAux2["descripcion"];
			else
				$NomSubProd = "SIN IDENTIFICACION";		
			echo "<td align=\"left\" colspan=\"".$ColSpan."\">".str_pad($Fila01["cod_subproducto"],2,'0',STR_PAD_LEFT)." - ".$NomSubProd."</td>";					
			echo "</tr>\n";
			reset($ArrTotalesProd);
			do {			 
				$key = key ($ArrTotalesProd);
				$ArrTotalesProd[$key][1] = 0;
				$ArrTotalesProd[$key][2] = 0;
				$ArrTotalesProd[$key][3] = 0;
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
				$Consulta = "select rut_prv as RUTPRV_A, nombre_prv as NOMPRV_A";
				$Consulta.= " from sipa_web.proveedores ";
				$Consulta.= " where rut_prv = '".$RutAux."'";
				$RespProv = mysqli_query($link, $Consulta);	
				//echo $Consulta."<br>";ptoveedores
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
				//if ($CmbAno<2006)
				//{
					$CodLoteIni=substr($CmbAno,3,1).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."000";
					$CodLoteFin=substr($CmbAno,3,1).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."999";	
				/*}
				else
				{
					$CodLoteIni=substr($CmbAno,2,2).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."0000";
					$CodLoteFin=substr($CmbAno,2,2).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."9999";	
				}	*/
					
				//CONSULTA LOS LOTES
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
				$Consulta.= " and (t1.tipo_remuestreo <>'A'  or (t1.tipo_remuestreo='A' ";
				//if ($CmbAno<2006)
					$Consulta.= " and substring(t1.num_lote_remuestreo,1,3)='".substr($CodLoteIni,0,3)."'))";
				//else
					//$Consulta.= " and substring(t1.num_lote_remuestreo,1,4)='".substr($CodLoteIni,0,4)."'))";
				$Consulta.= " and t2.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."' ";
				//$Consulta.= " and t1.lote='07040376'";
				$Consulta.= " group by t1.lote order by t1.lote, orden";
				$RespLote = mysqli_query($link, $Consulta);
				//echo $Consulta."<br>";
				while($FilaLote=mysqli_fetch_array($RespLote))
				{
					if ($ChkDetalle=="L")
					{
						echo "<tr>";
						echo "<td align=\"center\">".$FilaLote["lote"]."</td>";
						

						echo "<td align=\"center\">".substr($FilaLote["fecha_recepcion"],8,2)."/".substr($FilaLote["fecha_recepcion"],5,2)."/".substr($FilaLote["fecha_recepcion"],0,4)."</td>";
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
						$TxtFechaIniAux=substr($FilaLote["fecha_recepcion"],0,4)."-".substr($FilaLote["fecha_recepcion"],5,2)."-01";
						$TxtFechaFinAux=substr($FilaLote["fecha_recepcion"],0,4)."-".substr($FilaLote["fecha_recepcion"],5,2)."-31";;
						$DatosLote["penalidades"]="S"; 
					}
					else
					{
						$TxtFechaIniAux=$TxtFechaIni;
						$TxtFechaFinAux=$TxtFechaFin;
					}
					//echo $TxtFechaIniAux." / ".$TxtFechaFinAux."<br>";
					$DatosLote["lote"]=$FilaLote["lote"];					
					$DatosLote = LeyesLote($DatosLote,$ArrLeyes,"N","S","S",$TxtFechaIniAux,$TxtFechaFinAux,"","",$link);
					$ArrLeyes  = LeyesLote($DatosLote,$ArrLeyes,"N","S","S",$TxtFechaIniAux,$TxtFechaFinAux,"","L",$link);
					//echo $ArrLeyes[08][2]." / ".$ArrLeyes[09][2];
					$PesoLoteS=$DatosLote["peso_seco"];
					//echo $DatosLote["lote"]."-".$DatosLote["peso_seco"];
					$PesoLoteS2=$DatosLote["peso_seco2"];
					$PesoLoteH=$DatosLote["peso_humedo"];
					$CantDecPeso=0;$CantDecLF=0;
					if($Fila01["recepcion"]=='PMN')
					{
						$CantDecPeso=4;$CantDecLF=0;
					}	
					if ($ChkDetalle=="L")
					{
						echo "<td align=\"right\">".number_format($PesoLoteS,0,',','.')."</td>";
					}
					reset($ArrLeyes);
					foreach($ArrLeyes as $c=>$v)
					{	$v20 = isset($v[20])?$v[20]:0;
						$v0 = isset($v[0])?$v[0]:0;
						$v1 = isset($v[1])?$v[1]:"";
						$v2 = isset($v[2])?$v[2]:0;
						$v23 = isset($v[23])?$v[23]:0;
						$ArrLeyesAux02 = isset($ArrLeyesAux[$v0][2])?$ArrLeyesAux[$v0][2]:0;
						$ArrLeyesAux03 = isset($ArrLeyesAux[$v0][3])?$ArrLeyesAux[$v0][3]:0;
						$ArrLeyesAux04 = isset($ArrLeyesAux[$v0][4])?$ArrLeyesAux[$v0][4]:0;
						$ArrLeyesAux06 = isset($ArrLeyesAux[$v0][6])?$ArrLeyesAux[$v0][6]:0;
						if($c!=''&&$v1!=''&&$PesoLoteS>0)
						{							
							$Mostrar=true;
							if ($c=="01"&&$ExisteAgua=='N')
								$Mostrar=false;
							if($Mostrar==true)
							{	
								if ($c=="01")
								{
									$FinoAux=(float)$v20*$PesoLoteS/100;
									//$ValorPorc=round(($FinoAux*$ArrLeyesAux[$v[0]][6])/$PesoLoteS,4);
									$ValorPorc=($FinoAux*$ArrLeyesAux06)/$PesoLoteS;
									$ValorPorcAux=($FinoAux*$ArrLeyesAux06)/$PesoLoteS2;
								}
								else
								{
									//echo $FilaLote["lote"]."<br>";
									//echo $v[23]."<br>";
									//echo $ArrLeyesAux[$v[0]][6]."<br>";
									//echo $PesoLoteS."<br>";
								//	$ValorPorc=round(($v[23]*$ArrLeyesAux[$v[0]][6])/$PesoLoteS,4);
									$ValorPorc=((float)$v23*(float)$ArrLeyesAux06)/$PesoLoteS;
									//echo $ValorPorc."<br>";
									$ValorPorcAux=((float)$v23*(float)$ArrLeyesAux06)/$PesoLoteS2;
								}
							
								if ($ChkDetalle=="L")
								{
									if ($c=="01")
										echo "<td align=\"right\">".number_format((float)$v20,4,',','.')."</td>\n";
									else
										echo "<td align=\"right\">".number_format((float)$v2,4,',','.')."</td>\n";
								}
								$Dif=$ValorPorc-$ArrLeyesAux03;
								//echo $ValorPorc."<br>";
								//echo $Dif."<br>";
								//echo $ArrLeyesAux[$v[0]][3]."<br><br>";	
								$Cont=0;
								if($ValorPorc>$ArrLeyesAux03&&$Dif>0)
								{
									
									
									if ($c=="01")
									{
										$PesoAux=$PesoLoteH; //PESO HUMEDO
									}
									else
									{
										$PesoAux=$PesoLoteS; //PESO SECO
									}
									if($ArrLeyesAux[$v[0]][2]!='0')
										$Cant=$Dif/$ArrLeyesAux[$v[0]][2];
									$PesoSecoTon=$PesoAux/1000;
									$ValorDolar=$Cant * $ArrLeyesAux[$v[0]][4]*$PesoSecoTon;
								
																		//echo "peso---".$ValorDolar;
									if ($ChkDetalle=="L")
									{
										
										/*EXCEPCION DEBIDO QUE EL ARSENICO SE DISPARA Y GENERA PENALIDAD, 19-02-2016
										  Luis Adan Castillo - Intellego
											*/
										if($FilaLote["lote"]=='15120527' && $v[0]=='08') 
										{
											echo "<td align=\"right\">0</td>\n";
											$ValorDolar=0;
											
										}else
										{
											echo "<td align=\"right\" bgcolor='FFFF00' onMouseOver=\"JavaScript:muestra('".$Cont."');\" onMouseOut=\"JavaScript:oculta('".$Cont."');\">";
											echo "".number_format($ValorDolar,2,",",".")."</td>\n";
										}
										//echo "<td>" .number_format($ValorDolar,2,",",".")."</td>";
									}

								//aqui
                                  if ($ValorDolar > 0 && $v[1]=="H2O")
                                         {
                                            //echo  "FF".$suma=$suma + $PesoLoteH."---------".$ResultadoH2O = $ResultadoH2O + (($PesoLoteH * $v[20])/100);"</br>";

                                          // echo "--".$suma = $suma + ($DatosLote["peso_seco"] * $v[20]);
                                         //  $ResultadoH2O = $ResultadoH2O + (($PesoLoteH * $v[20])/100);
                                         $ResultadoH2O = $ResultadoH2O + ($DatosLote["peso_seco"] * $v[20]);
                                         $TotalHumedo = $TotalHumedo + $DatosLote["peso_seco"];
                                         $TotalSeco = $TotalSeco +  $DatosLote["peso_seco"];
                                           //$TotalHumedo = $TotalHumedo +   $ResultadoH2O;

                                    }
                                    if ($ValorDolar > 0 && $v[1]=="As")
                                    {
                                          $ResultadoAs = $ResultadoAs + ($DatosLote["peso_seco"] * $v[2])/100;
                                          $TotalSeco1  =   $TotalSeco1 + $DatosLote["peso_seco"];
                                    }
                                    if ($ValorDolar > 0 && $v[1]=="Sb")
                                    {
                                           $ResultadoSb = $ResultadoSb + ($DatosLote["peso_seco"] * $v[2])/100;
                                           $TotalSeco2  =   $TotalSeco2 + $DatosLote["peso_seco"];
                                    }
                                    if ($ValorDolar > 0 && $v[1]=="Zn")
                                    {
                                            $ResultadoZn = $ResultadoZn + ($DatosLote["peso_seco"] * $v[2])/100;
                                            $TotalSeco3  =   $TotalSeco3 + $DatosLote["peso_seco"];
                                    }

                                    if ($ValorDolar > 0 && $v[1]=="Pb")
                                    {
                                           $ResultadoPb = $ResultadoPb + ($DatosLote["peso_seco"] * $v[2])/100;
                                           $TotalSeco4  =   $TotalSeco4 + $DatosLote["peso_seco"];

                                    }
                                    if ($ValorDolar > 0 && $v[1]=="Hg")
                                    {
                                           $ResultadoHg = $ResultadoHg + ($DatosLote["peso_seco"] * $v[2])/100;
                                           $TotalSeco5  =   $TotalSeco5 + $DatosLote["peso_seco"];

                                    }
                                    if ($ValorDolar > 0 && $v[1]=="Cd")
                                    {
                                           $ResultadoCd = $ResultadoCd + ($DatosLote["peso_seco"] * $v[2])/100;
                                           $TotalSeco6  =   $TotalSeco6 + $DatosLote["peso_seco"];

                                    }
         //aqui
									$Cont++;
									$ArrTotalesAsig03 = isset($ArrTotalesAsig[$v[0]][3])?$ArrTotalesAsig[$v[0]][3]:0;
									$ArrTotalesPrv[$v[0]][1]=$ArrTotalesPrv[$v[0]][1]+($ValorDolar);//SUMA DE DOLARES
									$ArrTotalesAsig[$v[0]][1]=$ArrTotalesAsig[$v[0]][1]+($ValorDolar);//SUMA DE DOLARES
									$ArrTotalesProd[$v[0]][1]=$ArrTotalesProd[$v[0]][1]+($ValorDolar);//SUMA DE DOLARES
									$ArrTotalesProd[$v[0]][2]=$ArrTotalesProd[$v[0]][2]+($PesoLoteS);//SUMA DE DOLARES
									//Yo
									$ArrTotalesProd[$v[0]][3]=$ArrTotalesProd[$v[0]][3]+($PesoLoteH);//SUMA PESO HUMEDO
									
									//yo
									$ArrTotalesAsig[$v[0]][2]=$ArrTotalesAsig[$v[0]][2]+($PesoLoteS);//SUMA PESO SECO
									$ArrTotalesAsig[$v[0]][3]=$ArrTotalesAsig03+($PesoLoteH);//SUMA PESO HUMEDO
									if ($c=="01")
										$ArrTotalesProd[$v[0]][3]=$ArrTotalesProd[$v[0]][3]+(round($PesoLoteS)*round($v[20],4));//SUMA DE DOLARES
									else
										$ArrTotalesProd[$v[0]][3]=$ArrTotalesProd[$v[0]][3]+(round($PesoLoteS)*round($v[2],4));//SUMA DE DOLARES
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
					echo "<td align=\"left\" colspan=\"3\">TOTAL US$ :".$NomProveedor."</td>";
				}
				else
				{	
					echo "<tr>\n";				
					echo "<td align=\"left\" colspan=\"3\">".$NomProveedor."</td>";
				}
				reset($ArrTotalesPrv);
				foreach($ArrTotalesPrv as $c=>$v)
				{
					if($c!=''&&$v[0]!='')
					{
						echo "<td align=\"right\">&nbsp;</td>\n";
						//echo "<td align=\"right\">".number_format($v[1],2,",",".")."</td>\n";
						echo "<td align=\"right\">".number_format($v[1],2,",",".")."</td>\n";
					}				
				}
				echo "</tr>\n";
			}
//   echo "peso seco".$TotalSeco1;
			echo "<tr bgcolor=\"#CCCCCC\"><td align=\"left\" colspan=\"3\">TOTAL US$ ".str_pad($Fila01["cod_subproducto"],2,'0',STR_PAD_LEFT)." ".strtoupper($NomSubProd)."</td>\n";
			reset($ArrTotalesProd);
			foreach($ArrTotalesProd as $c=>$v)
			{
             	if($c!=''&&$v[0]!='')
				{
					  if($v[1]!=0)
                      {
                           if($v[0] =="01")
                              $var1 =  ($ResultadoH2O / $TotalHumedo);//* 100;
                           if($v[0] =="08")
                              $var1 = ($ResultadoAs / $TotalSeco1)* 100;
                           if($v[0] =="09")
                              $var1 = ($ResultadoSb / $TotalSeco2)* 100;
                           if($v[0] =="10")
                              $var1 =  ($ResultadoZn / $TotalSeco3)* 100;
                           if($v[0] =="34")
                              $var1 = ($ResultadoHg /  $TotalSeco5)* 100;
                           if($v[0] =="39")
                              $var1 = ($ResultadoPb /  $TotalSeco4)* 100;
                           if($v[0] =="58")
                              $var1 = ($ResultadoCd /  $TotalSeco6)* 100;

                          echo "<td align=\"center\"><strong>  Ley   ".number_format($var1,3,",",".")."</strong></td>\n";
                      }
			          else
                      {
						echo "<td align=\"right\">&nbsp;</td>\n";
                      }
                  echo "<td align=\"center\"><strong>  Dolar ".number_format($v[1],2,",",".")."</td>\n";   //dolar
				}
			}
			echo "</tr>\n";
   
               echo "<tr bgcolor=\"#CCCCCC\"><td align=\"left\" colspan=\"3\">Peso Seco </td>\n";
                    echo "<td align=\"center\"><strong>".number_format($TotalSeco,0,",",".")."</strong></td>\n";  //peso  seco
					if ($TotalSeco1 > 0)
					{
                    	echo "<td align=\"right\">&nbsp;</td>\n";
                    	echo "<td align=\"center\"><strong>".number_format($TotalSeco1,0,",",".")."</strong></td>\n";  //peso  seco
					}
					if ($TotalSeco2 > 0)
					{
                    	echo "<td align=\"right\">&nbsp;</td>\n";
                    	echo "<td align=\"center\"><strong>".number_format($TotalSeco2,0,",",".")."</strong></td>\n";  //peso  seco
					}
					if ($TotalSeco3 > 0)
					{
                    	echo "<td align=\"right\">&nbsp;</td>\n";
                    	echo "<td align=\"center\"><strong>".number_format($TotalSeco3,0,",",".")."</strong></td>\n";  //peso  seco
					}
					if ($TotalSeco5 > 0)
					{
                    	echo "<td align=\"right\">&nbsp;</td>\n";
                    	echo "<td align=\"center\"><strong>".number_format($TotalSeco5,0,",",".")."</strong></td>\n";  //peso  seco
					}
					if ($TotalSeco4 > 0)
					{
                    	echo "<td align=\"right\">&nbsp;</td>\n";
                    	echo "<td align=\"center\"><strong>".number_format($TotalSeco4,0,",",".")."</strong></td>\n";  //peso  seco
					}
					if ($TotalSeco6 > 0)
					{
                    	echo "<td align=\"right\">&nbsp;</td>\n";
                    	echo "<td align=\"center\"><strong>".number_format($TotalSeco6,0,",",".")."</strong></td>\n";  //peso  seco
					}
                    echo "<td align=\"right\">&nbsp;</td>\n";
           echo "</tr>\n";
   
    }

		//FIN PRODUCTOS

		echo "<tr class=\"ColorTabla01\"><td align=\"left\" colspan=\"3\">TOTAL PESO VS VALOR US$ :".strtoupper($FilaTipoRecep["desc_a"])."</td>\n";
		
		
		reset($ArrTotalesAsig);
		foreach($ArrTotalesAsig as $c=>$v)
		{
			if($c!=''&&$v[0]!='')
			{
				if ($c== 01)
				{
                    echo "<td align=\"center\"><strong>P. Seco ".number_format($v[2])."</td>\n";
					echo "<td align=\"center\"><strong>  Dolar ".number_format($v[1],2,",",".")."</td>\n";

					//echo "<td align=\"right\">".number_format($v[1],2,",",".")."</td>\n";
				}
				else
				{
					echo "<td align=\"center\"><strong>P. Seco ".number_format($v[2])."</td>\n";
					echo "<td align=\"center\"><strong>  Dolar ".number_format($v[1],2,",",".")."</td>\n";
					//echo "<td align=\"right\">".number_format($v[1],2,",",".")."</td>\n";
				}
				
			}				
		}
		echo "</tr>\n";
		//echo $var1."--".$var2."--".$var3."--".$var4;
	}//FIN TIPO RECEPCION
	echo "</table>\n";

	?>  
	
</form>
</body>
</html>
	


