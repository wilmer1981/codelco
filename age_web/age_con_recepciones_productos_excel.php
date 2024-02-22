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
	$Humedad = true;
	$Consulta = "select distinct cod_leyes, abreviatura ";
	$Consulta.= " from  proyecto_modernizacion.leyes  ";
	$Consulta.= " where cod_leyes in('01','02','04','05') ";		
	$Consulta.= " order by cod_leyes";
	$Resp = mysqli_query($link, $Consulta);
	$CantLeyes = 0;
	while ($Fila = mysqli_fetch_array($Resp))
	{
		$ArrLeyes[$Fila["cod_leyes"]][0] = $Fila["cod_leyes"]; //CODIGO
		$ArrLeyes[$Fila["cod_leyes"]][1] = $Fila["abreviatura"]; //ABREVIATURA
		$ArrLeyes[$Fila["cod_leyes"]][2] = "";//VALOR
		$ArrLeyes[$Fila["cod_leyes"]][3] = "";//COD UNIDAD
		$ArrLeyes[$Fila["cod_leyes"]][4] = "";//NOM UNIDAD
		$ArrLeyes[$Fila["cod_leyes"]][5] = "";//CONVERSION		
		//PARA ACUMULAR EL TOTAL DEL LOTE
		$ArrLoteLeyes[$Fila["cod_leyes"]][0] = $Fila["cod_leyes"]; //CODIGO
		$ArrLoteLeyes[$Fila["cod_leyes"]][1] = $Fila["abreviatura"]; //ABREVIATURA
		$ArrLoteLeyes[$Fila["cod_leyes"]][2] = "";//VALOR
		$ArrLoteLeyes[$Fila["cod_leyes"]][3] = "";//COD UNIDAD
		$ArrLoteLeyes[$Fila["cod_leyes"]][4] = "";//NOM UNIDAD
		$ArrLoteLeyes[$Fila["cod_leyes"]][5] = "";//CONVERSION	
		//PARA ACUMULAR EL SUB-TOTAL 
		$ArrSubTotalLeyes[$Fila["cod_leyes"]][0] = $Fila["cod_leyes"]; //CODIGO
		$ArrSubTotalLeyes[$Fila["cod_leyes"]][1] = $Fila["abreviatura"]; //ABREVIATURA
		$ArrSubTotalLeyes[$Fila["cod_leyes"]][2] = "";//VALOR
		$ArrSubTotalLeyes[$Fila["cod_leyes"]][3] = "";//COD UNIDAD
		$ArrSubTotalLeyes[$Fila["cod_leyes"]][4] = "";//NOM UNIDAD
		$ArrSubTotalLeyes[$Fila["cod_leyes"]][5] = "";//CONVERSION	
		//PARA ACUMULAR EL STOTAL 
		$ArrTotalLeyes[$Fila["cod_leyes"]][0] = $Fila["cod_leyes"]; //CODIGO
		$ArrTotalLeyes[$Fila["cod_leyes"]][1] = $Fila["abreviatura"]; //ABREVIATURA
		$ArrTotalLeyes[$Fila["cod_leyes"]][2] = "";//VALOR
		$ArrTotalLeyes[$Fila["cod_leyes"]][3] = "";//COD UNIDAD
		$ArrTotalLeyes[$Fila["cod_leyes"]][4] = "";//NOM UNIDAD
		$ArrTotalLeyes[$Fila["cod_leyes"]][5] = "";//CONVERSION	
		$CantLeyes++;
	}
	
?>
<html>
<head>
<title>Sistema de Agencia</title></head>

<body>
<form name="frmPrincipal" action="" method="post">
  <table width="620" border="0" align="center">
    <tr>
      <td width="294">EMPRESA NACIONAL DE MINERIA </td>
      <td width="296" align="right">FECHA:&nbsp;<?php echo date("d-m-Y")?></td>
    </tr>
    <tr align="center">
      <td height="30" colspan="2"><strong><u>RECEPCION DE PRODUCTOS </u></strong></td>
    </tr>
    <tr align="center">
      <td colspan="2"><?php echo substr($TxtFechaIni,8,2)."-".substr($TxtFechaIni,5,2)."-".substr($TxtFechaIni,0,4)." al ".substr($TxtFechaFin,8,2)."-".substr($TxtFechaFin,5,2)."-".substr($TxtFechaFin,0,4) ?></td>
    </tr>
    <tr align="center">
      <td colspan="2">&nbsp;</td>
    </tr>
  </table>
  <br>
  <?php
$ColSpan01 = 5;
$LargoTabla=350;
if ($OptLeyes == "S")
{	
	$ColSpan01=$ColSpan01+3;
	$LargoTabla=$LargoTabla + 150;
}
if ($OptFinos == "S")
{
	$ColSpan01=$ColSpan01+3;		  
	$LargoTabla=$LargoTabla + 150;
}
echo "<table width='".$LargoTabla."'  border='0' align='center' cellpadding='3' cellspacing='0'>\n";
$Consulta = "select distinct t1.rut_proveedor  ";
$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
$Consulta.= " on t1.lote = t2.lote ";
$Consulta.= " where t1.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."' ";
if ($CmbSubProducto != "S")
{
	$Consulta.= " and t1.cod_producto = '1' ";
	$Consulta.= " and t1.cod_subproducto = '".$CmbSubProducto."' ";
}
if ($CmbProveedor != "S")
	$Consulta.= " and t1.rut_proveedor = '".$CmbProveedor."' ";
$Consulta.= " order by t1.rut_proveedor ";
//echo $Consulta."<br>";
$Resp01 = mysqli_query($link, $Consulta);
while ($Fila01 = mysqli_fetch_array($Resp01))	
{			
	echo "<tr class='ColorTabla01'>\n";			
	$Datos = explode("-",$Fila01["rut_proveedor"]);
	$RutAux = ($Datos[0]*1)."-".$Datos[1];
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
	echo "<td align='left' colspan='".$ColSpan01."'>".str_pad($RutAux,10,'0',STR_PAD_LEFT)." - ".$NomProveedor."</td>";					
	echo "</tr>\n";
	//TITULO						
	echo "<tr class='ColorTabla02'>\n";		
	echo "<td align='center'>Lote</td>\n";		
	echo "<td align='center'>F.Cierre</td>\n";			
	echo "<td align='center'>P.Hum.</td>\n";
	//if ($OptFinos=="S")
		echo "<td align='center'>P.Seco</td>\n";
	//if ($OptLeyes=="S")
		echo "<td align='center'>Hum</td>\n";
	if ($OptLeyes=="S")
	{		
		echo "<td align='center'>Ley.Cu</td>\n";
		echo "<td align='center'>Ley.Ag</td>\n";
		echo "<td align='center'>Ley.Au</td>\n";
	}
	if ($OptFinos=="S")
	{
		echo "<td align='center'>Fino.Cu</td>\n";
		echo "<td align='center'>Fino.Ag</td>\n";
		echo "<td align='center'>Fino.Au</td>\n";
		
	}	
	echo "</tr>\n";
	//CONSULTA LOS TIPOS DE RECEPCION
	$Consulta = "select distinct t1.cod_recepcion, t3.desc_a  ";
	$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
	$Consulta.= " on t1.lote = t2.lote left join rec_web.tipos t3 on t1.cod_recepcion=t3.cod_c ";
	$Consulta.= " where t1.lote<>'' ";
	$Consulta.= " and t2.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."'";	
	if ($CmbSubProducto != "S")
	{
		$Consulta.= " and t1.cod_producto = '1' ";
		$Consulta.= " and t1.cod_subproducto = '".$CmbSubProducto."' ";
	}	
	$Consulta.= " and t1.rut_proveedor = '".$Fila01["rut_proveedor"]."' ";
	$Consulta.= " order by t1.cod_recepcion ";
	//echo $Consulta."<br>";
	$RespTipoRecep = mysqli_query($link, $Consulta);
	while ($FilaTipoRecep = mysqli_fetch_array($RespTipoRecep))
	{					
		//TITULO COD RECEPCION
		echo "<tr bgcolor='#CCCCCC'>\n";	
		if ($FilaTipoRecep["desc_a"] == "" || is_null($FilaTipoRecep["desc_a"]))
			echo "<td align='left' colspan='".$ColSpan01."'>&nbsp;</td>\n";				
		else
			echo "<td align='left' colspan='2'>".strtoupper($FilaTipoRecep["desc_a"])."</td>\n";
		echo "<td align='center' colspan='".($ColSpan01-2)."'>&nbsp;</td>\n";		
		echo "</tr>\n";
		//CONSULTA LOS PROVEEDOR DE UN PRODUCTO Y UN TIPO DE RECEPCION
		$Consulta = "select distinct t1.cod_producto, t1.cod_subproducto, t3.descripcion  ";
		$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
		$Consulta.= " on t1.lote = t2.lote inner join proyecto_modernizacion.subproducto t3 ";
		$Consulta.= " on t1.cod_producto=t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto ";
		$Consulta.= " where t1.lote<>'' ";
		$Consulta.= " and t2.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."'";			
		if ($CmbSubProducto != "S")
		{
			$Consulta.= " and t1.cod_producto = '1' ";
			$Consulta.= " and t1.cod_subproducto = '".$CmbSubProducto."' ";
		}
		$Consulta.= " and t1.rut_proveedor = '".$Fila01["rut_proveedor"]."' ";
		$Consulta.= " and t1.cod_recepcion = '".$FilaTipoRecep["cod_recepcion"]."' ";
		$Consulta.= " order by t1.cod_producto, lpad(t1.cod_subproducto,4,'0') ";
		//echo $Consulta."<br>";
		$CodRecepAnt = "";
		$RespAux = mysqli_query($link, $Consulta);
		while ($FilaAux = mysqli_fetch_array($RespAux))
		{						
			//TITULO SUBPRODUCTO
			echo "<tr class='Detalle01'>\n";	
			if ($FilaAux["descripcion"] == "" || is_null($FilaAux["descripcion"]))
				echo "<td align='left' colspan='".$ColSpan01."'>&nbsp;</td>\n";				
			else
				echo "<td align='left' colspan='".$ColSpan01."'>".str_pad($FilaAux["cod_subproducto"],2,'0',STR_PAD_LEFT)." - ".strtoupper($FilaAux["descripcion"])."</td>\n";
			echo "</tr>\n";
			$Consulta = "select distinct t1.lote, t2.recargo, t1.rut_proveedor, t2.peso_neto as peso_hum,  ";
			$Consulta.= " lpad(t2.recargo,2,'0') as orden, t2.fecha_recepcion ";		
			$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
			$Consulta.= " on t1.lote = t2.lote ";			
			$Consulta.= " where t1.cod_producto = '".$FilaAux["cod_producto"]."' ";
			$Consulta.= " and t1.cod_subproducto = '".$FilaAux["cod_subproducto"]."' ";
			$Consulta.= " and t2.fecha_recepcion between '".$TxtFechaIni."' and '".$TxtFechaFin."'";
			$Consulta.= " and t1.rut_proveedor = '".$Fila01["rut_proveedor"]."' ";
			$Consulta.= " and t1.cod_recepcion = '".$FilaTipoRecep["cod_recepcion"]."' ";					
			$Consulta.= " order by t1.lote, orden";
			$Resp = mysqli_query($link, $Consulta);
			//echo $Consulta."<br><br>";
			for ($i = 0; $i <=mysqli_num_rows($Resp) - 1; $i++)
			{
				if (mysql_data_seek ($Resp, $i)) 
				{
					if ($Fila = mysql_fetch_row($Resp))  
					{        				
						$Lote = $Fila[0];
						$Recargo = $Fila[1];
						$PesoHum = $Fila[3];
						$F_Recep = $Fila[5];																								
						//CONSULTA LEYES DE LOTES		
						$PorcHum=0;		
						$Consulta = "select distinct t1.cod_leyes, t1.valor, t2.abreviatura as nom_unidad, t2.conversion";
						$Consulta.= " from age_web.leyes_por_lote t1 left join proyecto_modernizacion.unidades t2 on ";
						$Consulta.= " t1.cod_unidad=t2.cod_unidad ";
						$Consulta.= " where t1.lote='".$Lote."' ";
						if (is_null($Recargo) || $Recargo==1 || $Recargo=="0")
							$Consulta.= " and (t1.recargo='".$Recargo."' or t1.recargo='0')";
						else
							$Consulta.= " and t1.recargo='".$Recargo."'";
						$Consulta.= " and t1.cod_leyes in('01','02','04','05') ";
						$Consulta.= " order by t1.cod_leyes";
						//echo $Consulta;
						$Resp2 = mysqli_query($link, $Consulta);
						while ($Fila2 = mysqli_fetch_array($Resp2))
						{			
							$ArrLeyes[$Fila2["cod_leyes"]][2] = $Fila2["valor"];//VALOR
							$ArrLeyes[$Fila2["cod_leyes"]][3] = $Fila2["cod_unidad"];//COD UNIDAD
							$ArrLeyes[$Fila2["cod_leyes"]][4] = $Fila2["nom_unidad"];//NOM UNIDAD
							$ArrLeyes[$Fila2["cod_leyes"]][5] = $Fila2["conversion"];//CONVERSION
							if ($Fila2["cod_leyes"]=="01")
								$PorcHum = $Fila2["valor"];
							//TOTAL DEL LOTE
							$ArrLoteLeyes[$Fila2["cod_leyes"]][2] = $Fila2["valor"];//VALOR
							$ArrLoteLeyes[$Fila2["cod_leyes"]][3] = $Fila2["cod_unidad"];//COD UNIDAD
							$ArrLoteLeyes[$Fila2["cod_leyes"]][4] = $Fila2["nom_unidad"];//NOM UNIDAD	
							$ArrLoteLeyes[$Fila2["cod_leyes"]][5] = $Fila2["conversion"];//CONVERSION	
						}
						$PesoSeco = $PesoHum - ($PesoHum*$PorcHum)/100;					
						//TOTAL LOTE
						$TotalLotePesoHum = $TotalLotePesoHum + $PesoHum;
						$TotalLotePesoSeco = $TotalLotePesoSeco + $PesoSeco;
						//CONSULTO POR EL LOTE QUE SIGUE
						$Totalizar=true;	
						$i++;
						if ($i<=mysqli_num_rows($Resp)-1)
						{
							if (mysql_data_seek($Resp, $i))
							{
								if ($Fila = mysql_fetch_row($Resp))	
								{	 
									$Sgte = $Fila[0]; //LOTE									
									if ($Lote==$Sgte)
										$Totalizar=false;																				
								}								
							}								
							$i--;
						}					
						if ($Totalizar)//TOTAL LOTE
						{
							if ($TotalLotePesoSeco>0 && $TotalLotePesoHum>0)
								$TotalLoteHumedad = 100 - (($TotalLotePesoSeco * 100)/$TotalLotePesoHum);
							else
								$TotalLoteHumedad = 0;	
							$Consulta = "select * from age_web.detalle_lotes ";
							$Consulta.= " where lote='".$Lote."' ";
							$Consulta.= " and recargo=(select max(recargo) from age_web.detalle_lotes where lote='".$Lote."')";	
							$RespCierre = mysqli_query($link, $Consulta);
							if ($FilaCierre = mysqli_fetch_array($RespCierre))
								$FechaCierre = substr($FilaCierre["fecha_recepcion"],8,2)."/".substr($FilaCierre["fecha_recepcion"],5,2)."/".substr($FilaCierre["fecha_recepcion"],0,4);
							else
								$FechaCierre = "&nbsp;";
							echo "<tr>\n";
							echo "<td align='center'>".$Lote."</td>\n";
							echo "<td align='center'>".$FechaCierre."</td>\n";							
							echo "<td align='right'>".number_format($TotalLotePesoHum,0,",",".")."</td>\n";
							echo "<td align='right'>".number_format($TotalLotePesoSeco,0,",",".")."</td>\n";
							echo "<td align='right'>".number_format($TotalLoteHumedad,4,",",".")."</td>\n";
							$LineaLeyes = "";
							$LineaFinos = "";
							reset($ArrLoteLeyes);
							while (list($k,$v)=each($ArrLoteLeyes))
							{
								if ($k!="01")
								{
									if ($k!="")
									{
										$Ley = 0;
										$Fino = 0;
										if ($v[2]>0 && $TotalLotePesoSeco>0 && $v[5]>0)
										{
											$Fino = ($v[2] * $TotalLotePesoSeco)/$v[5];
											$Ley = ($Fino / $TotalLotePesoSeco)*$ArrParamLeyes[$k][1];
										}
										if ($OptLeyes == "S")
											$LineaLeyes.= "<td align='right'>".number_format($Ley,$ArrParamLeyes[$k][2],",",".")."</td>\n";												
										if ($OptFinos == "S")
											$LineaFinos.= "<td align='right'>".number_format($Fino,$ArrParamLeyes[$k][4],",",".")."</td>\n";	
									}
									else
									{
										if ($OptLeyes == "S")
											$LineaLeyes.= "<td align='right'>".number_format(0,$ArrParamLeyes[$k][2],",",".")."</td>\n";	
										if ($OptFinos == "S")
											$LineaFinos.= "<td align='right'>".number_format(0,$ArrParamLeyes[$k][4],",",".")."</td>\n";
									}
								}			
													
								//TOTAL PROVEEDOR
								if ($TotalLotePesoSeco>0 && $v[2]>0 && $v[5]>0) 
									$ArrSubTotalLeyes[$v[0]][2] = $ArrSubTotalLeyes[$v[0]][2] + (($TotalLotePesoSeco * $v[2])/$v[5]);//VALOR
								else
									$ArrSubTotalLeyes[$v[0]][2] = $ArrSubTotalLeyes[$v[0]][2] + 0;
								$ArrSubTotalLeyes[$v[0]][3] = $ArrParamLeyes[$v[0]][0];//COD UNIDAD
								$ArrSubTotalLeyes[$v[0]][4] = $ArrParamLeyes[$v[0]][3];//NOM UNIDAD
								$ArrSubTotalLeyes[$v[0]][5] = $ArrParamLeyes[$v[0]][1];//CONVERSION
								$Fino = "";
								$Ley = "";
							}
							if ($OptLeyes=="S")
								echo $LineaLeyes;							
							if ($OptFinos=="S")
								echo $LineaFinos;		
							$ArrSubTotalLeyes[$v[0]][3] = $ArrParamLeyes[$v[0]][0];//COD UNIDAD
							$ArrSubTotalLeyes[$v[0]][4] = $ArrParamLeyes[$v[0]][3];//NOM UNIDAD
							$ArrSubTotalLeyes[$v[0]][5] = $ArrParamLeyes[$v[0]][1];//CONVERSION
							$Fino = "";
							$Ley = "";
							$SubTotalPesoHum = $SubTotalPesoHum + $TotalLotePesoHum;
							$SubTotalPesoSeco = $SubTotalPesoSeco + $TotalLotePesoSeco;
							$TotalLotePesoHum = 0;
							$TotalLotePesoSeco = 0;
							$TotalLoteHumedad = 0;
							//LIMPIA ARREGLO DE LEYES POR RECARGO
							reset($ArrLeyes);
							do {			 
							  $key = key ($ArrLeyes);
							  $ArrLeyes[$key][2] = 0;
							  $ArrLeyes[$key][3] = "";
							  $ArrLeyes[$key][4] = "";
							  $ArrLeyes[$key][5] = "";
							} while (next($ArrLeyes));
							//LIMPIA ARREGLO DE TOTAL DE LEYES POR LOTE
							reset($ArrLoteLeyes);
							do {			 
							  $key = key ($ArrLoteLeyes);
							  $ArrLoteLeyes[$key][2] = 0;
							  $ArrLoteLeyes[$key][3] = "";
							  $ArrLoteLeyes[$key][4] = "";
							  $ArrLoteLeyes[$key][5] = "";
							} while (next($ArrLoteLeyes));							
						}//FIN TOTAL LOTE
					}
				}
			}
			//TOTAL PRODUCTO
			if ($SubTotalPesoSeco>0 && $SubTotalPesoHum>0)
				$SubTotalHumedad = 100 - (($SubTotalPesoSeco * 100)/$SubTotalPesoHum);
			else
				$SubTotalHumedad = 0;		
			echo "<tr bgcolor='#FFFFFF'><td align='left' colspan='2'>TOTAL PRODUCTO ".str_pad($FilaAux["cod_subproducto"],2,'0',STR_PAD_LEFT)."</td>\n";
			echo "<td align='right'>".number_format($SubTotalPesoHum,0,",",".")."</td>\n";
			echo "<td align='right'>".number_format($SubTotalPesoSeco,0,",",".")."</td>\n";		
			echo "<td align='right'>".number_format($SubTotalHumedad,4,",",".")."</td>\n";							
			$LineaLeyes = "";
			$LineaFinos = "";
			reset($ArrSubTotalLeyes);
			while (list($k,$v)=each($ArrSubTotalLeyes))
			{
				if ($k!="01" && $k!="")
				{
					if ($k!="")
					{
						$Ley = 0;
						$Fino = $v[2];
						if ($Fino>0 && $ArrParamLeyes[$k][1]>0 && $SubTotalPesoSeco>0)
							$Ley = ($Fino*$ArrParamLeyes[$k][1])/$SubTotalPesoSeco;		
						if ($OptLeyes == "S")
							$LineaLeyes.= "<td align='right'>".number_format($Ley,$ArrParamLeyes[$k][2],",",".")."</td>\n";				
						if ($OptFinos == "S")
							$LineaFinos.= "<td align='right'>".number_format($Fino,$ArrParamLeyes[$k][4],",",".")."</td>\n";				
					}
					else
					{
						if ($OptLeyes == "S")
							$LineaLeyes.= "<td align='right'>".number_format(0,$ArrParamLeyes[$k][2],",",".")."</td>\n";	
						if ($OptFinos == "S")
							$LineaFinos.= "<td align='right'>".number_format(0,$ArrParamLeyes[$k][4],",",".")."</td>\n";
					}		
				}
				//TOTAL TIPO RECEPCION
				if ($SubTotalPesoSeco>0 && $v[2]>0 && $v[5]>0) 
					$ArrTotalTipo[$k][2] = $ArrTotalTipo[$k][2] + (($SubTotalPesoSeco * $Ley)/$ArrParamLeyes[$k][1]);//VALOR
				else
					$ArrTotalTipo[$k][2] = $ArrTotalTipo[$k][2] + 0;
				$ArrTotalTipo[$k][3] = $ArrParamLeyes[$k][0];//COD UNIDAD
				$ArrTotalTipo[$k][4] = $ArrParamLeyes[$k][3];//NOM UNIDAD
				$ArrTotalTipo[$k][5] = $ArrParamLeyes[$k][1];//CONVERSION
			}
			if ($OptLeyes=="S")
				echo $LineaLeyes;							
			if ($OptFinos=="S")
				echo $LineaFinos;		
			echo "</tr>\n";
			$TotalTipoPesoHum = $TotalTipoPesoHum + $SubTotalPesoHum;
			$TotalTipoPesoSeco = $TotalTipoPesoSeco + $SubTotalPesoSeco;
			$SubTotalPesoHum = 0;
			$SubTotalPesoSeco = 0;
			$SubTotalHumedad=0;
			//LIMPIA ARREGLO DE TOTAL DE LEYES POR RECARGO
			reset($ArrSubTotalLeyes);
			do {			 
			  $key = key ($ArrSubTotalLeyes);
			  $ArrSubTotalLeyes[$key][2] = "";
			  $ArrSubTotalLeyes[$key][3] = "";
			  $ArrSubTotalLeyes[$key][4] = "";
			  $ArrSubTotalLeyes[$key][5] = "";
			} while (next($ArrSubTotalLeyes));	
		}
		//TOTAL TIPO RECEPCION
		if ($TotalTipoPesoSeco>0 && $TotalTipoPesoHum>0)
			$TotalTipoHumedad = 100 - (($TotalTipoPesoSeco * 100)/$TotalTipoPesoHum);
		else
			$TotalTipoHumedad = 0;
		echo "<tr bgcolor='#CCCCCC'><td align='left' colspan='2'>TOTAL&nbsp;".strtoupper($FilaTipoRecep["desc_a"])."</td>\n";
		echo "<td align='right'>".number_format($TotalTipoPesoHum,0,",",".")."</td>\n";
		echo "<td align='right'>".number_format($TotalTipoPesoSeco,0,",",".")."</td>\n";		
		echo "<td align='right'>".number_format($TotalTipoHumedad,4,",",".")."</td>\n";		
		$LineaLeyes="";
		$LineaFinos="";
		reset($ArrTotalTipo);
		while (list($k,$v)=each($ArrTotalTipo))
		{
			if ($k!="01" && $k!="")
			{
				if ($k!="")
				{
					$Ley = 0;
					$Fino = $v[2];
					if ($Fino>0 && $ArrParamLeyes[$k][1]>0 && $TotalTipoPesoSeco>0)
						$Ley = ($Fino*$ArrParamLeyes[$k][1])/$TotalTipoPesoSeco;		
					if ($OptLeyes == "S")
						$LineaLeyes.= "<td align='right'>".number_format($Ley,$ArrParamLeyes[$k][2],",",".")."</td>\n";				
					if ($OptFinos == "S")
						$LineaFinos.= "<td align='right'>".number_format($Fino,$ArrParamLeyes[$k][4],",",".")."</td>\n";				
				}
				else
				{
					if ($OptLeyes == "S")
						$LineaLeyes.= "<td align='right'>".number_format(0,$ArrParamLeyes[$k][2],",",".")."</td>\n";	
					if ($OptFinos == "S")
						$LineaFinos.= "<td align='right'>".number_format(0,$ArrParamLeyes[$k][4],",",".")."</td>\n";
				}
			}
			//TOTAL PRODUCTO
			if ($TotalTipoPesoSeco>0 && $v[2]>0 && $v[5]>0) 
				$ArrTotalLeyes[$k][2] = $ArrTotalLeyes[$k][2] + (($TotalTipoPesoSeco * $Ley)/$ArrParamLeyes[$k][1]);//VALOR
			else
				$ArrTotalLeyes[$k][2] = $ArrTotalLeyes[$k][2] + 0;
			$ArrTotalLeyes[$k][3] = $ArrParamLeyes[$k][0];//COD UNIDAD
			$ArrTotalLeyes[$k][4] = $ArrParamLeyes[$k][3];//NOM UNIDAD
			$ArrTotalLeyes[$k][5] = $ArrParamLeyes[$k][1];//CONVERSION
		}
		if ($OptLeyes=="S")
			echo $LineaLeyes;							
		if ($OptFinos=="S")
			echo $LineaFinos;	
		echo "</tr>\n";
		$TotalPesoHum = $TotalPesoHum + $TotalTipoPesoHum;
		$TotalPesoSeco = $TotalPesoSeco + $TotalTipoPesoSeco;			
		$TotalTipoPesoSeco = 0;
		$TotalTipoPesoHum = 0;
		$TotalTipoHumedad = 0;
		//LIMPIA ARREGLO DE TOTAL DE LEYES POR PRODUCTO
		reset($ArrTotalTipo);
		do {			 
		  $key = key ($ArrTotalTipo);
		  $ArrTotalTipo[$key][2] = "";
		  $ArrTotalTipo[$key][3] = "";
		  $ArrTotalTipo[$key][4] = "";
		  $ArrTotalTipo[$key][5] = "";
		} while (next($ArrTotalTipo));	
	}//FIN TIPO RECEPCION
	//TOTAL PRODUCTO
	if ($TotalPesoSeco>0 && $TotalPesoHum>0)
		$TotalHumedad = 100 - (($TotalPesoSeco * 100)/$TotalPesoHum);
	else
		$TotalHumedad = 0;
	echo "<tr class='ColorTabla02'><td align='left' colspan='2'>TOTAL PROVEEDOR</td>\n";
	echo "<td align='right'>".number_format($TotalPesoHum,0,",",".")."</td>\n";
	echo "<td align='right'>".number_format($TotalPesoSeco,0,",",".")."</td>\n";		
	echo "<td align='right'>".number_format($TotalHumedad,4,",",".")."</td>\n";	
	$LineaLeyes="";
	$LineaFinos="";
	reset($ArrTotalLeyes);
	while (list($k,$v)=each($ArrTotalLeyes))
	{
		if ($k!="01" && $k!="")
		{
			if ($k!="")
			{
				$Ley = 0;
				$Fino = $v[2];
				if ($Fino>0 && $ArrParamLeyes[$k][1]>0 && $TotalPesoSeco>0)
					$Ley = ($Fino*$ArrParamLeyes[$k][1])/$TotalPesoSeco;		
				if ($OptLeyes == "S")
					$LineaLeyes.= "<td align='right'>".number_format($Ley,$ArrParamLeyes[$k][2],",",".")."</td>\n";				
				if ($OptFinos == "S")
					$LineaFinos.= "<td align='right'>".number_format($Fino,$ArrParamLeyes[$k][4],",",".")."</td>\n";				
			}
			else
			{
				if ($OptLeyes == "S")
					$LineaLeyes.= "<td align='right'>".number_format(0,$ArrParamLeyes[$k][2],",",".")."</td>\n";	
				if ($OptFinos == "S")
					$LineaFinos.= "<td align='right'>".number_format(0,$ArrParamLeyes[$k][4],",",".")."</td>\n";
			}
		}
	}
	if ($OptLeyes=="S")
		echo $LineaLeyes;							
	if ($OptFinos=="S")
		echo $LineaFinos;
	echo "</tr>\n";	
	$TotalPesoSeco = 0;
	$TotalPesoHum = 0;
	$TotalHumedad = 0;
	//LIMPIA ARREGLO DE TOTAL DE LEYES POR PRODUCTO
	reset($ArrTotalLeyes);
	do {			 
	  $key = key ($ArrTotalLeyes);
	  $ArrTotalLeyes[$key][2] = "";
	  $ArrTotalLeyes[$key][3] = "";
	  $ArrTotalLeyes[$key][4] = "";
	  $ArrTotalLeyes[$key][5] = "";
	} while (next($ArrTotalLeyes));
}//FIN PRODUCTOS
echo "</table>\n";
?>  

</form>
</body>
</html>