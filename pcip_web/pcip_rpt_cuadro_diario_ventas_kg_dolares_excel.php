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
<title>Consulta Cuadro Diario Kg - US$</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
</style></head>
<body>
<form name="frmPrincipal" action="" method="post">
<table width="100%" border="1" cellpadding="0" cellspacing="0" >
          <tr class="TituloTablaVerde">
            <td width="5%" align="center" rowspan="2"><span class="Estilo9">Codigo</span></td>
            <td width="3%"align="center" rowspan="2"><span class="Estilo9">Nombre Producto</span></td>
			<?
			for($i=$Mes;$i<=$MesFin;$i++)
			{
			$ArrFinos[$i][0]=0;
			$ArrDolares[$i][0]=0;
			$ArrTotalFinos[$i][0]=0;
			$ArrTotalDolares[$i][0]=0;
			
			    if($CmbMostrar=='T')
				     $Colspan='2';
				else
				   	 $Colspan='1';
		       	echo"<td width='2%' align='center' colspan=".$Colspan."><span class='Estilo9'>".substr($Meses[$i-1],0,3)."</span></td>";
			}
			?>
			<td width="3%"align="center" colspan="<? echo $Colspan;?>"><span class="Estilo9">Acumulado</span></td>
			<?
				if($CmbMostrar=='T')
				{
				//echo "enreo a T  ";
			        echo"<tr class='TituloTablaVerde'>";
					for($i=$Mes;$i<=$MesFin;$i++)
					{
						echo"<td align='center' class='Estilo9'><span class='Estilo9'>Valor Kg</span></td>";
						echo"<td align='center' class='Estilo9'><span class='Estilo9'>Valor US$</span></td>";
					}
					echo"<td align='center' class='Estilo9'><span class='Estilo9'>Valor Kg</span></td>";
					echo"<td align='center' class='Estilo9'><span class='Estilo9'>Valor US$</span></td>";
					echo"</tr>";
					
				}
				if($CmbMostrar=='1')
				{
				//echo "entro a 1";
				    echo"<tr class='TituloTablaVerde'>";
					for($i=$Mes;$i<=$MesFin;$i++)
					{
						echo"<td align='center'><span class='Estilo9'>Valor Kg</span></td>";
					}
					echo"<td align='center'><span class='Estilo9'>Valor Kg</span></td>";
					echo"</tr>";
				}
				if($CmbMostrar=='2')
				{
				// echo "entro a 2";
			 		echo"<tr class='TituloTablaVerde'>";
					for($i=$Mes;$i<=$MesFin;$i++)
					{
						echo"<td align='center'><span class='Estilo9'>Valor US$</span></td>";
					}
					echo"<td align='center'><span class='Estilo9'>Valor US$</span></td>";
					echo"</tr>";
				}
			?>
          </tr>
		  <?
	   $Buscar='S';
		  	if($Buscar=='S')
			{
				$Totales=array();
				$Consulta = "select distinct t1.cod_producto,t2.nom_producto";
				$Consulta.= " from pcip_cdv_cuadro_diario_ventas t1";
				$Consulta.= " inner join pcip_cdv_productos_ventas t2 on t1.cod_producto=t2.cod_producto";
				$Consulta.= " where t1.cod_producto<>'' ";
				if($CmbProd!='T')
					$Consulta.= "and  t1.cod_producto='".$CmbProd."'";
				$Consulta.=" and t1.ano='".$Ano."' and t1.mes between '".$Mes."' and '".$MesFin."'";						
				$Consulta.= " order by t1.cod_producto ";
				//echo $Consulta."<br>";			
				$Resp=mysql_query($Consulta);
				while($Fila=mysql_fetch_array($Resp))
				{
					$Total=0;
					echo "<tr>";
					echo "<td align='center'><span class='Estilo9'>".$Fila["cod_producto"]."</span></td>";
					echo "<td align='left'><span class='Estilo9'>".$Fila["nom_producto"]."&nbsp;</span></td>";
					for($i=$Mes;$i<=$MesFin;$i++)
					{
						$Consulta1 = "select t1.cod_producto,t2.nom_producto";
						if($CmbMostrar=='T')
							$Consulta1.= " ,sum(t1.kilos_finos) as kilos_finos,sum(t1.valor_cif_neto) as valor_cif_neto";
						if($CmbMostrar=='1')
							$Consulta1.= " ,sum(t1.kilos_finos) as kilos_finos";
						if($CmbMostrar=='2')
							$Consulta1.= " ,sum(t1.valor_cif_neto) as valor_cif_neto";    	
						$Consulta1.= " from pcip_cdv_cuadro_diario_ventas t1";
						$Consulta1.= " inner join pcip_cdv_productos_ventas t2 on t1.cod_producto=t2.cod_producto";
						$Consulta1.= " where t1.cod_producto<>'' ";
						$Consulta1.= "and  t1.cod_producto='".$Fila["cod_producto"]."'";
						$Consulta1.=" and t1.ano='".$Ano."' and t1.mes='".$i."' and ajuste='N'";	
						$Consulta1.=" group by t1.cod_producto";		
						//echo $Consulta1."<br>";	
						$Resp1=mysql_query($Consulta1);
						if($Fila1=mysql_fetch_array($Resp1))
						{						
							if($CmbMostrar=='T')
							{
								echo "<td align='right'><span class='Estilo9'>".number_format($Fila1[kilos_finos],0,',','.')."</span></td>";
								echo "<td align='right'><span class='Estilo9'>".number_format($Fila1[valor_cif_neto],0,',','.')."</span></td>";
							}
							if($CmbMostrar=='1')
							{
								echo "<td align='right'><span class='Estilo9'>".number_format($Fila1[kilos_finos],0,',','.')."</span></td>";
							}
							if($CmbMostrar=='2')
							{
								echo "<td align='right'><span class='Estilo9'>".number_format($Fila1[valor_cif_neto],0,',','.')."</span></td>";
							}
							$ArrFinos[$i][0]=$ArrFinos[$i][0]+$Fila1[kilos_finos];
							$ArrDolares[$i][0]=$ArrDolares[$i][0]+$Fila1[valor_cif_neto];
							$Encontro=='S';
						}
						else
						{
							if($CmbMostrar=='T')
							{
								echo "<td align='right'>0</td>";
								echo "<td align='right'>0</td>";
							}
							else
								echo "<td align='right'>0</td>";
						}
					}
					TotalesAcumulados($CmbMostrar,$Ano,$Fila["cod_producto"],$MesFin,'N');
					echo "</tr>";
				}
					//TOTALES
					if($CmbMostrar=='T')
					{
					    if($CmbConAjuste=='S')
						{	
							echo "<tr class='TituloTablaNaranja'>";
							echo "<td align='right' colspan='2' class='TituloTablaNaranja'>SUB-TOTAL</td>";	
							for($i=$Mes;$i<=$MesFin;$i++)
							{
							    $TotalesFinos=$ArrFinos[$i][0];
							    $TotalesDolares=$ArrDolares[$i][0];
								echo "<td align='right'><span class='Estilo9'>".number_format($TotalesFinos,0,',','.')."</span></td>";
								echo "<td align='right'><span class='Estilo9'>".number_format($TotalesDolares,0,',','.')."</span></td>";
								$ArrTotalFinos[$i][0]=$ArrTotalFinos[$i][0]+abs($TotalesFinos);
								$ArrTotalDolares[$i][0]=$ArrTotalDolares[$i][0]+abs($TotalesDolares);							
							}
							TotalesAcumulados($CmbMostrar,$Ano,'',$MesFin,'N');
							echo "</tr>";
							echo "<tr class='TituloTablaNaranja'>";
							echo "<td align='right' colspan='2' class='TituloTablaNaranja'>TOTAL AJUSTE</td>";	
							for($i=$Mes;$i<=$MesFin;$i++)
							{
								$Kilos=SacarValoresAjuste($Ano,$i,$MesFin,$CmbProd,$CmbMostrar,'K');
								$Dolares=SacarValoresAjuste($Ano,$i,$MesFin,$CmbProd,$CmbMostrar,'D');
								echo "<td align='right'><span class='Estilo9'>".number_format($Kilos,0,',','.')."</span></td>";
								echo "<td align='right'><span class='Estilo9'>".number_format($Dolares,0,',','.')."</span></td>";
								$ArrTotalFinos[$i][0]=$ArrTotalFinos[$i][0]+$Kilos;
								$ArrTotalDolares[$i][0]=$ArrTotalDolares[$i][0]+abs($Dolares);							
							}
							TotalesAcumulados($CmbMostrar,$Ano,'',$MesFin,'S');
							echo "</tr>";
							echo "<tr class='TituloTablaNaranja'>";
							echo "<td align='right' colspan='2' class='TituloTablaNaranja'>TOTAL</td>";	
							for($i=$Mes;$i<=$MesFin;$i++)
							{
							    $TotalFinos=$ArrTotalFinos[$i][0];
							    $TotalDolares=$ArrTotalDolares[$i][0];
								echo "<td align='right'><span class='Estilo9'>".number_format($TotalFinos,0,',','.')."</span></td>";
								echo "<td align='right'><span class='Estilo9'>".number_format($TotalDolares,0,',','.')."</span></td>";
							}
							TotalesAcumulados($CmbMostrar,$Ano,'',$MesFin,'');
							echo "</tr>";
						}
						else	
						{	
							echo "<tr class='TituloTablaNaranja'>";
							echo "<td align='right' colspan='2'>TOTAL</td>";	
							for($i=$Mes;$i<=$MesFin;$i++)
							{
							    $TotalesFinos=$ArrFinos[$i][0];
							    $TotalesDolares=$ArrDolares[$i][0];
								echo "<td align='right'><span class='Estilo9'>".number_format($TotalesFinos,0,',','.')."</span></td>";
								echo "<td align='right'><span class='Estilo9'>".number_format($TotalesDolares,0,',','.')."</span></td>";
							}
							TotalesAcumulados($CmbMostrar,$Ano,'',$MesFin,'N');
							echo "</tr>";
						}	
					}
					if($CmbMostrar=='1')
					{
					    if($CmbConAjuste=='S')
						{	
							echo "<tr class='TituloTablaNaranja'>";
							echo "<td align='right' colspan='2'>TOTAL</td>";	
							for($i=$Mes;$i<=$MesFin;$i++)
							{
							    $TotalesFinos=$ArrFinos[$i][0];
								echo "<td align='right'><span class='Estilo9'>".number_format($TotalesFinos,0,',','.')."</span></td>";
								$ArrTotalFinos[$i][0]=$ArrTotalFinos[$i][0]+$TotalesFinos;
							}
							TotalesAcumulados($CmbMostrar,$Ano,'',$MesFin,'N');
							echo "</tr>";
							echo "<tr class='TituloTablaNaranja'>";
							echo "<td align='right' colspan='2'>TOTAL AJUSTE</td>";	
							for($i=$Mes;$i<=$MesFin;$i++)
							{
								$Kilos=SacarValoresAjuste($Ano,$i,$MesFin,$CmbProd,$CmbMostrar,'K');
								echo "<td align='right'><span class='Estilo9'>".number_format($Kilos,0,',','.')."</span></td>";
								$ArrTotalFinos[$i][0]=$ArrTotalFinos[$i][0]+$Kilos;
							}
							TotalesAcumulados($CmbMostrar,$Ano,'',$MesFin,'S');
							echo "</tr>";
							echo "<tr class='TituloTablaNaranja'>";
							echo "<td align='right' colspan='2'>TOTAL</td>";	
							for($i=$Mes;$i<=$MesFin;$i++)
							{
							    $TotalFinos=$ArrTotalFinos[$i][0];
								echo "<td align='right'><span class='Estilo9'>".number_format($TotalFinos,0,',','.')."</span></td>";
							}
							TotalesAcumulados($CmbMostrar,$Ano,'',$MesFin,'');
							echo "</tr>";
							
						}
						else	
						{	
							echo "<tr class='TituloTablaNaranja'>";
							echo "<td align='right' colspan='2'>TOTAL</td>";	
							for($i=$Mes;$i<=$MesFin;$i++)
							{
								$TotalesFinos=$ArrFinos[$i][0];
								echo "<td align='right'><span class='Estilo9'>".number_format(TotalesFinos,0,',','.')."</span></td>";
							}
							TotalesAcumulados($CmbMostrar,$Ano,'',$MesFin,'N');
							echo "</tr>";
						}	
					}
					if($CmbMostrar=='2')
					{
					    if($CmbConAjuste=='S')
						{	
							echo "<tr class='TituloTablaNaranja'>";
							echo "<td align='right' colspan='2'>TOTAL</td>";	
							for($i=$Mes;$i<=$MesFin;$i++)
							{
							    $TotalesDolares=$ArrDolares[$i][0];
								echo "<td align='right'><span class='Estilo9'>".number_format($TotalesDolares,0,',','.')."</span></td>";
								$ArrTotalDolares[$i][0]=$ArrTotalDolares[$i][0]+$TotalesDolares;	
							}
							TotalesAcumulados($CmbMostrar,$Ano,'',$MesFin,'N');
							echo "</tr>";
							echo "<tr class='TituloTablaNaranja'>";
							echo "<td align='right' colspan='2'>TOTAL AJUSTE</td>";	
							for($i=$Mes;$i<=$MesFin;$i++)
							{
								$Dolares=SacarValoresAjuste($Ano,$i,$MesFin,$CmbProd,$CmbMostrar,'D');
								echo "<td align='right'><span class='Estilo9'>".number_format($Dolares,0,',','.')."</span></td>";
								$ArrTotalDolares[$i][0]=$ArrTotalDolares[$i][0]+$Dolares;
							}
							TotalesAcumulados($CmbMostrar,$Ano,'',$MesFin,'S');
							echo "</tr>";
							echo "<tr class='TituloTablaNaranja'>";
							echo "<td align='right' colspan='2'>TOTAL REAL</td>";	
							for($i=$Mes;$i<=$MesFin;$i++)
							{
							    $TotalDolares=$ArrTotalDolares[$i][0];
								echo "<td align='right'><span class='Estilo9'>".number_format($TotalDolares,0,',','.')."</span></td>";
							}
							TotalesAcumulados($CmbMostrar,$Ano,'',$MesFin,'');
							echo "</tr>";
						}
						else	
						{	
							echo "<tr class='TituloTablaNaranja'>";
							echo "<td align='right' colspan='2'>TOTAL</td>";	
							for($i=$Mes;$i<=$MesFin;$i++)
							{
							    $TotalesDolares=$ArrDolares[$i][0];
								echo "<td align='right'><span class='Estilo9'>".number_format($TotalesDolares,0,',','.')."</span></td>";
							}
							TotalesAcumulados($CmbMostrar,$Ano,'',$MesFin,'N');
							echo "</tr>";
						}	
					}
					echo "</tr>";
			}
		  ?>			   	
  </table>
  <tr><td width="15">&nbsp;</td>
  </tr>
</form>
<?
function SacarValoresAjuste($Ano,$Mes,$MesFin,$CodProd,$Mostrar,$Tipo)
{
	$Consulta1 = "select t1.cod_producto,t2.nom_producto";
	if($Mostrar=='T')
		$Consulta1.= " ,sum(t1.kilos_finos) as kilos_finos,sum(t1.valor_cif_neto) as valor_cif_neto";
	if($Mostrar=='1')
		$Consulta1.= " ,sum(t1.kilos_finos) as kilos_finos";
	if($Mostrar=='2')
		$Consulta1.= " ,sum(t1.valor_cif_neto) as valor_cif_neto";    	
	$Consulta1.= " from pcip_cdv_cuadro_diario_ventas t1";
	$Consulta1.= " inner join pcip_cdv_productos_ventas t2 on t1.cod_producto=t2.cod_producto";
	$Consulta1.= " where t1.cod_producto<>'' ";
	if($CodProd!='T')
		$Consulta1.= "and  t1.cod_producto='".$Fila["cod_producto"]."'";
	$Consulta1.=" and t1.ano='".$Ano."' and t1.mes='".$Mes."' and ajuste='S'";	
	$Consulta1.=" group by t1.cod_producto";		
	//echo $Consulta1."<br>";	
	$Resp1=mysql_query($Consulta1);
	while($Fila1=mysql_fetch_array($Resp1))
	{
	  if($Mostrar=='T')
	  {
		 $ValorKilos=$ValorKilos+$Fila1[kilos_finos];
		 $ValorDolares=$ValorDolares+$Fila1[valor_cif_neto];
	  }
	  if($Mostrar=='1')
		 $ValorKilos=$ValorKilos+$Fila1[kilos_finos];
	  if($Mostrar=='2')	
		 $ValorDolares=$ValorDolares+$Fila1[valor_cif_neto];
	}
	if($Tipo=='K')
		return($ValorKilos);
	if($Tipo=='D') 
		return($ValorDolares);
}
function TotalesAcumulados($CmbMostrar,$Ano,$CodProd,$MesFin,$Ajuste)
{
	$Consulta1 = "select t1.cod_producto,t2.nom_producto";
	if($CmbMostrar=='T')
		$Consulta1.= " ,sum(t1.kilos_finos) as kilos_finos,sum(t1.valor_cif_neto) as valor_cif_neto";
	if($CmbMostrar=='1')
		$Consulta1.= " ,sum(t1.kilos_finos) as kilos_finos";
	if($CmbMostrar=='2')
		$Consulta1.= " ,sum(t1.valor_cif_neto) as valor_cif_neto";    	
	$Consulta1.= " from pcip_cdv_cuadro_diario_ventas t1";
	$Consulta1.= " inner join pcip_cdv_productos_ventas t2 on t1.cod_producto=t2.cod_producto";
	$Consulta1.= " where t1.cod_producto<>'' ";
	$Consulta1.=" and t1.ano='".$Ano."' and t1.mes between '1' and '".$MesFin."'";
	if($Ajuste!='')
		$Consulta1.=" and ajuste='".$Ajuste."'";	
	if($CodProd!='')
	{
		$Consulta1.= "and  t1.cod_producto='".$CodProd."'";
		$Consulta1.=" group by t1.cod_producto";		
	}
	else
		$Consulta1.=" group by t1.ano";	
	//echo $Consulta1."<br>";	
	$Resp1=mysql_query($Consulta1);
	if($Fila1=mysql_fetch_array($Resp1))
	{						
		if($CmbMostrar=='T')
		{
			echo "<td align='right'><span class='Estilo9'>".number_format($Fila1[kilos_finos],0,',','.')."</span></td>";
			echo "<td align='right'><span class='Estilo9'>".number_format($Fila1[valor_cif_neto],0,',','.')."</span></td>";
		}
		if($CmbMostrar=='1')
		{
			echo "<td align='right'><span class='Estilo9'>".number_format($Fila1[kilos_finos],0,',','.')."</span></td>";
		}
		if($CmbMostrar=='2')
		{
			echo "<td align='right'><span class='Estilo9'>".number_format($Fila1[valor_cif_neto],0,',','.')."</span></td>";
		}
	}
	else
		if($CmbMostrar=='T')
		{
			echo "<td align='right'><span class='Estilo9'>0</span></td>";
			echo "<td align='right'><span class='Estilo9'>0</span></td>";
		}
		else
			echo "<td align='right'><span class='Estilo9'>0</span></td>";
}
?>
</body>
</html>