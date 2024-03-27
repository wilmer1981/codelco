<?
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

	include("../principal/conectar_pcip_web.php");
	include("funciones/pcip_funciones.php");

if(!isset($Ano))
 	$Ano=date('Y');
if(!isset($Mes))
 	$Mes=date('m');
if(!isset($AnoFin))
 	$AnoFin=date('Y');
if(!isset($MesFin))
 	$MesFin=date('m');
if(!isset($CmbMostrar))
	$CmbMostrar='P';			
?>
<html>
<head>
<title>Reporte Inventario Svp Excel</title>
<link href="estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo9 {font-size: 11px}
-->
</style>
<body>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
</style></head>
<body>
<form name="frmPrincipal" action="" method="post">
  <table width="100%" border="1" cellpadding="0" cellspacing="0" >
    <tr>
      <td width="7%" rowspan="2" align="center">Orden de Producci&oacute;n </td>
      <td width="25%" rowspan="2" align="center">Descripcion Orden Co </td>
      <td width="21%" colspan="3" align="center">Cantidad [TMF]</td>
      <td width="21%" colspan="3" align="center">Valor [US$] </td>
      <td width="21%" colspan="3" align="center">Costo Unitario [US$/TMF]</td>
    </tr>
    <tr>
      <td width="7%" align="center">Inicial</td>
      <td width="7%" align="center">Final</td>
      <td width="7%" align="center">Variaci&oacute;n</td>
      <td width="7%" align="center">Inicial</td>
      <td width="7%" align="center">Final</td>
      <td width="7%" align="center">Variaci&oacute;n</td>
      <td width="7%" align="center">Inicial</td>
      <td width="7%" align="center">Final</td>
      <td width="7%" align="center">Variaci&oacute;n</td>
    </tr>
    <?
		  if($CmbMostrar=='M')
		  {
		  ?>
    <tr>
      <td width="7%" rowspan="2" align="center">Orden de Producci&oacute;n </td>
      <td width="25%" rowspan="2" align="center">Descripcion Orden Co </td>
      <?
			for($i=1;$i<=12;$i++)
			{
		       	echo "<td width='21%' colspan='3' align='center'>".$Meses[$i-1]." ".$Ano."</td>";
			}
			?>
    </tr>
    <tr>
      <?
 			for($i=1;$i<=12;$i++)
			{
			?>
      <td width="7%" align="center">Inventario</td>
      <td width="7%" align="center">Valor</td>
      <td width="7%" align="center">C.Unitario</td>
      <?
			}
			?>
    </tr>
    <?
		  }
		  
		  ?>
    <?			$Buscar='S';
		  	if($Buscar=='S')
			{
				$CmbMostrar='P';
				if($CmbMostrar=='P')
				{
					$MesAux=$Mes;
					$AnoAux=$Ano;
					if($Mes==1)
					{
						$MesAnt=12;
						$AnoAnt=$Ano-1;
					}
					else
					{	
						$MesAnt=$Mes-1;
						$AnoAnt=$Ano;
					}
					if($Mes==1)
					{
						$MesAux=12;
						$AnoAux=$Ano-1;
					}
					else
						$MesAux=$Mes-1;
					
					$Consulta="SELECT t1.VPorden,t2.OPdescripcion FROM pcip_svp_valorizacproduccion t1 inner join pcip_svp_ordenesproduccion t2 on t1.VPorden=t2.OPorden WHERE t1.VPtm='25' and ((t1.VPa�o = '".$Ano."' and t1.VPmes='".$Mes."') or (t1.VPa�o = '".$AnoFin."' and t1.VPmes='".$MesFin."')or (t1.VPa�o = '".$AnoAnt."' and t1.VPmes='".$MesAnt."'))";
					if($CmbOrdenProd!='-1')
						$Consulta.=" AND t1.VPorden = '".$CmbOrdenProd."'";
					if($CmbMaterial!='T')
						$Consulta.=" AND t1.VPtipinv='".$CmbMaterial."'";
					$Consulta.=" group by t1.VPorden";
					//echo $Consulta;
					$Resp=mysqli_query($link, $Consulta);
					while($Fila=mysql_fetch_array($Resp))
					{
						$TotCantIni=0;$TotCantFin=0;$TotValorIni=0;$TotValorFin=0;
						echo "<tr >";
						echo "<td>".$Fila[VPorden]."</td>";
						echo "<td colspan='10'>".$Fila[OPdescripcion]."</td>";
						echo "</tr>";
						$Consulta="SELECT t1.VPorden,t2.OPdescripcion,t1.VPtipinv FROM pcip_svp_valorizacproduccion t1 inner join pcip_svp_ordenesproduccion t2 on t1.VPorden=t2.OPorden WHERE t1.VPtm='25' and ((t1.VPa�o = '".$Ano."' and t1.VPmes='".$Mes."') or (t1.VPa�o = '".$AnoFin."' and t1.VPmes='".$MesFin."') or (t1.VPa�o = '".$AnoAnt."' and t1.VPmes='".$MesAnt."'))";
						//if($CmbOrdenProd!='-1')
							$Consulta.=" AND t1.VPorden = '".$Fila[VPorden]."'";
						if($CmbMaterial!='T')
							$Consulta.=" AND t1.VPtipinv='".$CmbMaterial."'";
						$Consulta.=" group by t1.VPorden,t1.VPtipinv";
						//echo $Consulta;
						$RespO=mysqli_query($link, $Consulta);
						while($FilaO=mysql_fetch_array($RespO))
						{
							echo "<tr>";
							echo "<td>&nbsp;</td>";
							$Consulta="SELECT TIdescripcion FROM pcip_svp_tiposinventarios WHERE TIcodigo='".$FilaO[VPtipinv]."'";
							$RespTipoInv=mysqli_query($link, $Consulta);
							$FilaTipoInv=mysql_fetch_array($RespTipoInv);

							$Consulta="SELECT t1.VPcantidad,t1.VPvalor FROM pcip_svp_valorizacproduccion t1 inner join pcip_svp_tiposinventarios t2 on t1.VPtipinv=t2.TIcodigo WHERE t1.VPtm='25' and (t1.VPa�o = '".$AnoAux."' and t1.VPmes='".$MesAux."')";
							$Consulta.=" AND VPorden = '".$FilaO[VPorden]."'";
							$Consulta.=" AND VPtipinv='".$FilaO[VPtipinv]."'";
							//echo $Consulta."<br>";
							$RespIni=mysqli_query($link, $Consulta);
							$FilaIni=mysql_fetch_array($RespIni);
							echo "<td>".str_pad($FilaO[VPtipinv],3,'0',STR_PAD_LEFT)." ".$FilaTipoInv[TIdescripcion]."</td>";
							$Consulta="SELECT VPcantidad,VPvalor FROM pcip_svp_valorizacproduccion WHERE VPtm='25' and (VPa�o = '".$AnoFin."' and VPmes='".$MesFin."')";
							$Consulta.=" AND VPorden = '".$FilaO[VPorden]."'";
							$Consulta.=" AND VPtipinv='".$FilaO[VPtipinv]."'";
							$RespFin=mysqli_query($link, $Consulta);
							$FilaFin=mysql_fetch_array($RespFin);
							echo "<td align='right'>".number_format($FilaIni[VPcantidad],3,',','.')."</td>";
							echo "<td align='right'>".number_format($FilaFin[VPcantidad],3,',','.')."</td>";
							echo "<td align='right'>".number_format(($FilaFin[VPcantidad]-$FilaIni[VPcantidad]),3,',','.')."</td>";
							echo "<td align='right'>".number_format($FilaIni[VPvalor],2,',','.')."</td>";
							echo "<td align='right'>".number_format($FilaFin[VPvalor],2,',','.')."</td>";
							echo "<td align='right'>".number_format(($FilaFin[VPvalor]-$FilaIni[VPvalor]),2,',','.')."</td>";
							$CantCostoIni=$FilaIni[VPcantidad];
							$ValorCostoIni=$FilaIni[VPvalor];
							if($CantCostoIni>0)
								$CostoIni=$ValorCostoIni/$CantCostoIni;
							else
								$CostoIni=0;
							echo "<td align='right'>".number_format($CostoIni,5,',','.')."</td>";
							$CantCostoFin=$FilaFin[VPcantidad];
							$ValorCostoFin=$FilaFin[VPvalor];
							if($CantCostoFin>0)
								$CostoFin=$ValorCostoFin/$CantCostoFin;
							else
								$CostoFin=0;	
							echo "<td align='right'>".number_format($CostoFin,5,',','.')."</td>";
							echo "<td align='right'>".number_format($CostoFin-$CostoIni,5,',','.')."</td>";
							echo "</tr>";
							$TotCantIni=$TotCantIni+$FilaIni[VPcantidad];
							$TotCantFin=$TotCantFin+$FilaFin[VPcantidad];
							$TotValorIni=$TotValorIni+$FilaIni[VPvalor];
							$TotValorFin=$TotValorFin+$FilaFin[VPvalor];
						}
						echo "<tr >";
						echo "<td colspan='2' align='right'>Totales</td>";
						echo "<td align='right'>".number_format($TotCantIni,3,',','.')."</td>";
						echo "<td align='right'>".number_format($TotCantFin,3,',','.')."</td>";
						echo "<td align='right'>".number_format($TotCantFin-$TotCantIni,3,',','.')."</td>";
						echo "<td align='right'>".number_format($TotValorIni,2,',','.')."</td>";
						echo "<td align='right'>".number_format($TotValorFin,2,',','.')."</td>";
						echo "<td align='right'>".number_format($TotValorFin-$TotValorIni,2,',','.')."</td>";
						if($TotCantIni>0)
							$CostoUniIni=$TotValorIni/$TotCantIni;
						else
							$CostoUniIni=0;
						if($TotCantFin>0)
							$CostoUniFin=$TotValorFin/$TotCantFin;
						else
							$CostoUniFin=0;
						if($TotCantIni>0&&$TotCantFin>0)
							$CostoVar=($TotValorFin/$TotCantFin)-($TotValorIni/$TotCantIni);
						else
							$CostoVar=0;
						echo "<td align='right'>".number_format($CostoUniIni,5,',','.')."</td>";
						echo "<td align='right'>".number_format($CostoUniFin,5,',','.')."</td>";
						echo "<td align='right'>".number_format($CostoVar,5,',','.')."</td>";
						echo "</tr>";
					}
				}
				/*if($CmbMostrar=='M')
				{
					$Consulta="SELECT t1.VPorden,t2.OPdescripcion FROM pcip_svp_valorizacproduccion t1 inner join pcip_svp_ordenesproduccion t2 on t1.VPorden=t2.OPorden WHERE t1.VPtm='25' and t1.VPa&ntilde;o = '".$Ano."'";
					if($CmbOrdenProd!='-1')
						$Consulta.=" AND t1.VPorden = '".$CmbOrdenProd."'";
					if($CmbMaterial!='T')
						$Consulta.=" AND t1.VPtipinv='".$CmbMaterial."'";
					$Consulta.=" group by t1.VPorden";
					//echo $Consulta;
					$Resp=mysqli_query($link, $Consulta);
					while($Fila=mysql_fetch_array($Resp))
					{
						echo "<tr class='FilaAbeja2'>";
						echo "<td>".$Fila[VPorden]."</td>";
						echo "<td colspan='39'>".$Fila[OPdescripcion]."</td>";
						echo "</tr>";
						$Consulta="SELECT t1.VPorden,t2.OPdescripcion,t1.VPtipinv FROM pcip_svp_valorizacproduccion t1 inner join pcip_svp_ordenesproduccion t2 on t1.VPorden=t2.OPorden WHERE t1.VPtm='25' and t1.VPa&ntilde;o = '".$Ano."'";
						if($CmbOrdenProd!='-1')
							$Consulta.=" AND t1.VPorden = '".$Fila[VPorden]."'";
						if($CmbMaterial!='T')
							$Consulta.=" AND t1.VPtipinv='".$CmbMaterial."'";
						$Consulta.=" group by t1.VPorden,t1.VPtipinv";
						//echo $Consulta;
						array($ArrayTot);
						for($i=1;$i<=12;$i++)
						{
							$ArrayTot[$i][0]='';
							$ArrayTot[$i][1]='';
						}
						//reset($ArrayTot);
						$RespO=mysqli_query($link, $Consulta);
						while($FilaO=mysql_fetch_array($RespO))
						{
							echo "<tr>";
							echo "<td>&nbsp;</td>";
							$Consulta="SELECT t2.TIdescripcion FROM pcip_svp_valorizacproduccion t1 inner join pcip_svp_tiposinventarios t2 on t1.VPtipinv=t2.TIcodigo WHERE t1.VPtm='25' and t1.VPa&ntilde;o = '".$Ano."'";
							$Consulta.=" AND VPorden = '".$FilaO[VPorden]."'";
							$Consulta.=" AND VPtipinv='".$FilaO[VPtipinv]."'";
							$Consulta.=" group by t1.VPa&ntilde;o,t1.VPmes";
							//echo $Consulta;
							$RespMat=mysqli_query($link, $Consulta);
							$FilaMat=mysql_fetch_array($RespMat);
							echo "<td>".str_pad($FilaO[VPtipinv],3,'0',STR_PAD_LEFT)." ".$FilaMat[TIdescripcion]."</td>";
							echo "<td>TMS</td>";
							for($i=1;$i<=12;$i++)
							{
								$Consulta="SELECT t1.VPcantidad,t1.VPvalor,t2.TIdescripcion FROM pcip_svp_valorizacproduccion t1 inner join pcip_svp_tiposinventarios t2 on t1.VPtipinv=t2.TIcodigo WHERE t1.VPtm='25' and t1.VPa&ntilde;o = '".$Ano."' and t1.VPmes='".$i."'";
								$Consulta.=" AND VPorden = '".$FilaO[VPorden]."'";
								$Consulta.=" AND VPtipinv='".$FilaO[VPtipinv]."'";
								$Consulta.=" group by t1.VPa&ntilde;o,t1.VPmes";
								//echo $Consulta."<BR>";
								$RespMeses=mysqli_query($link, $Consulta);
								if($FilaMeses=mysql_fetch_array($RespMeses))
								{
									echo "<td align='right'>".number_format($FilaMeses[VPcantidad],3,',','.')."</td>";
									echo "<td align='right'>".number_format($FilaMeses[VPvalor],2,',','.')."</td>";
									echo "<td align='right'>".number_format(($FilaMeses[VPvalor]/$FilaMeses[VPcantidad]),2,',','.')."</td>";
									//echo $ArrayTot[$i][0]."<br>";
									$ArrayTot[$i][0]=$ArrayTot[$i][0]+$FilaMeses[VPcantidad];
									$ArrayTot[$i][1]=$ArrayTot[$i][1]+$FilaMeses[VPvalor];
								}
								else
								{
									echo "<td>&nbsp;</td>";
									echo "<td>&nbsp;</td>";
									echo "<td>&nbsp;</td>";
								}
							}	
							echo "</tr>";	
						}
						echo "<tr class='FilaAbeja2'>";
						echo "<td colspan='2' align='right'>Totales</td>";
						echo "<td>TMS</td>";
						reset($ArrayTot);
						for($i=1;$i<=12;$i++)
						{
							if($ArrayTot[$i][0]!=''&&$ArrayTot[$i][0]!=0)
								$Var=$ArrayTot[$i][1]/$ArrayTot[$i][0];
							else
								$Var='';	
							echo "<td align='right'>".number_format($ArrayTot[$i][0],5,',','.')."</td>";
							echo "<td align='right'>".number_format($ArrayTot[$i][1],5,',','.')."</td>";
							echo "<td align='right'>".number_format($Var,5,',','.')."</td>";
							//echo "<td align='right'>".number_format(0,3,',','.')."</td>";
							//echo "<td align='right'>".number_format(0,3,',','.')."</td>";
							//echo "<td align='right'>".number_format(0,3,',','.')."</td>";
							$ArrayTot[$i][0]='';
							$ArrayTot[$i][1]='';
						}
						echo "</tr>";
					}
				}
				*/
			}
		  ?>
  </table>
</form>
</body>
</html>