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
<title>Reporte Enabal Excel</title>
<script language="javascript" src="funciones/pcip_funciones.js"></script>
<body>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
</style></head>
<body>
<form name="frmPrincipal" action="" method="post">
  <table width="100%" border="1" cellpadding="0" cellspacing="0" >
    <tr class="TituloTablaVerde">
      <td width="20%" rowspan="2" align="center"><span class="Estilo9">Flujo / Existencia </span></td>
      <td width="12%" rowspan="2" align="center"><span class="Estilo9">Tipo Dato</span></td>
      <td width="12%" rowspan="2" align="center"><span class="Estilo9">Mes</span></td>
      <td width="8%" rowspan="2" align="center"><span class="Estilo9">Peso Seco [Kg] </span></td>
      <td width="24%" colspan="3" align="center"><span class="Estilo9">Finos</span></td>
      <td width="24%" colspan="3" align="center"><span class="Estilo9">Leyes</span></td>
    </tr>
    <tr class="TituloTablaVerde">
      <td width="8%" align="center"><span class="Estilo9">Cobre [Kg]</span></td>
      <td width="8%" align="center"><span class="Estilo9">Plata [Grs]</span></td>
      <td width="8%" align="center"><span class="Estilo9">Oro [Grs]</span></td>
      <td width="8%" align="center"><span class="Estilo9">Cobre [%]</span></td>
      <td width="8%" align="center"><span class="Estilo9">Plata [Grs/Kg]</span></td>
      <td width="8%" align="center"><span class="Estilo9">Oro [Grs/Kg]</span></td>
    </tr>
    <?
			$Buscar='S';
			if($Buscar=='S')
			{
				if($CmbTipoDatos!='D')
				{
					$TotPeso=0;$TotCobre=0;$TotAg=0;$TotAu=0;					
					$Consulta = "select nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31026' and valor_subclase1='".$CmbTipoDatos."'";			
					$Resp=mysqli_query($link, $Consulta);
					if ($Fila=mysql_fetch_array($Resp))
						$TipoDato=$Fila["nombre_subclase"];
					$Consulta = "select cod_flujo,nom_flujo from pcip_ena_datos_enabal where origen='".$CmbOrigen."' and tipo_mov='".$CmbTipoMov."'";
					if($CmbFlujos!='T')
						$Consulta.=" and cod_flujo='".$CmbFlujos."'";
					$Consulta.=" and ano='".$Ano."' and mes between  '".$Mes."' and '".$MesFin."' and tipo_dato='".$CmbTipoDatos."'";	
					$Consulta.=" group by tipo_mov,cod_flujo";
					//echo $Consulta;
					$Resp=mysqli_query($link, $Consulta);
					while($Fila=mysql_fetch_array($Resp))
					{
						$CantFilas=$MesFin-$Mes;$Cont=1;
						echo "<tr>";
						echo "<td rowspan='".($CantFilas+1)."'>".$Fila[cod_flujo]." - ".$Fila[nom_flujo]."</td>";
						echo "<td rowspan='".($CantFilas+1)."'>".$TipoDato."</td>";
						for($i=$Mes;$i<=$MesFin;$i++)
						{
							if($Cont>1)
								echo "<tr>";
							echo "<td>".$Meses[$i-1]."</td>";	
							$Consulta = "select * from pcip_ena_datos_enabal where origen='".$CmbOrigen."' and tipo_mov='".$CmbTipoMov."'";
							$Consulta.=" and cod_flujo='".$Fila[cod_flujo]."'";
							$Consulta.=" and ano='".$Ano."' and mes =  '".$i."' and tipo_dato='".$CmbTipoDatos."'";	
							//echo $Consulta;
							$Resp2=mysqli_query($link, $Consulta);
							if($Fila2=mysql_fetch_array($Resp2))
							{
								
								echo "<td align='right'>".number_format($Fila2["peso"],0,'','.')."</td>";
								echo "<td align='right'>".number_format($Fila2[cobre],0,'','.')."</td>";
								echo "<td align='right'>".number_format($Fila2[plata],0,'','.')."</td>";
								echo "<td align='right'>".number_format($Fila2[oro],0,'','.')."</td>";
								$TotPeso=$TotPeso+$Fila2["peso"];
								$TotCobre=$TotCobre+$Fila2[cobre];
								$TotAg=$TotAg+$Fila2[plata];
								$TotAu=$TotAu+$Fila2[oro];
								if($Fila2["peso"]>0)
									echo "<td align='right'>".number_format($Fila2[cobre]/$Fila2["peso"],2,',','.')."</td>";
								else
									echo "<td align='right'>0</td>";
								if($Fila2["peso"]>0)
									echo "<td align='right'>".number_format($Fila2[plata]/$Fila2["peso"],2,',','.')."</td>";
								else
									echo "<td align='right'>0</td>";
								if($Fila2["peso"]>0)	
									echo "<td align='right'>".number_format($Fila2[oro]/$Fila2["peso"],3,',','.')."</td>";
								else
									echo "<td align='right'>0</td>";	
							}
							else
								echo "<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>";
							$Cont++;
							echo "</tr>";	
						}
					}
					?>
				  <tr class="TituloTablaVerde">
					<td colspan="3" >TOTALES</td>
					<td align="right"><? echo number_format($TotPeso,0,',','.');?>&nbsp;</td>
					<td align="right"><? echo number_format($TotCobre,0,',','.');?>&nbsp;</td>
					<td align="right"><? echo number_format($TotAg,0,',','.');?>&nbsp;</td>
					<td align="right"><? echo number_format($TotAu,0,',','.');?>&nbsp;</td>
					<td colspan="3" >&nbsp;</td>
				  </tr>
					<?		
				}
				else
				{
					$Diferencias=array();
					$Consulta = "select cod_flujo,nom_flujo from pcip_ena_datos_enabal where origen='".$CmbOrigen."' and tipo_mov='".$CmbTipoMov."'";
					if($CmbFlujos!='T')
						$Consulta.=" and cod_flujo='".$CmbFlujos."'";
					$Consulta.=" and ano='".$Ano."' and mes between  '".$Mes."' and '".$MesFin."'";	
					$Consulta.=" group by tipo_mov,cod_flujo";
					//echo $Consulta;
					$Resp=mysqli_query($link, $Consulta);
					while($Fila=mysql_fetch_array($Resp))
					{
						$CantFilas=abs($MesFin-$Mes)+1;$Cont=1;
						//echo $CantFilas."<br>";
						echo "<tr>";
						echo "<td rowspan='".($CantFilas*3)."'>".$Fila[cod_flujo]." - ".$Fila[nom_flujo]."</td>";
						for($i=$Mes;$i<=$MesFin;$i++)
						{
							if($Cont>1)
								echo "<tr>";
							echo "<td rowspan='3'>".$Meses[$i-1]."</td>";
							reset($Diferencias);
							DatosEnabal($CmbOrigen,$Fila[cod_flujo],$Ano,$i,$CmbTipoMov,'B',$Diferencias);
							echo "<tr>";
							DatosEnabal($CmbOrigen,$Fila[cod_flujo],$Ano,$i,$CmbTipoMov,'F',$Diferencias);
							echo "<tr class='FilaAbeja2'>";
							DatosEnabal($CmbOrigen,$Fila[cod_flujo],$Ano,$i,$CmbTipoMov,'D',$Diferencias);	
							$Cont++;
							echo "</tr>";	
						}
						//echo "</tr>";
					}					
				}
			}
			?>
  </table>
</form>
</body>
</html>
<?
function DatosEnabal($Origen,$CodFlujo,$AnoAux,$MesAux,$TipoMov,$TipoDato,&$Diferencias)
{
	switch($TipoDato)
	{
		case "B":
			echo "<td>Datos Base</td>";
		break;
		case "F":
			echo "<td>Datos Finales</td>";
		break;
		case "D":
			echo "<td>Diferencia</td>";
			echo "<td align='right'>".number_format($Diferencias[B][0]-$Diferencias[F][0],0,'','.')."</td>";
			echo "<td align='right'>".number_format($Diferencias[B][1]-$Diferencias[F][1],0,'','.')."</td>";
			echo "<td align='right'>".number_format($Diferencias[B][2]-$Diferencias[F][2],0,'','.')."</td>";
			echo "<td align='right'>".number_format($Diferencias[B][3]-$Diferencias[F][3],0,'','.')."</td>";
			echo "<td align='right'>".number_format($Diferencias[B][4]-$Diferencias[F][4],2,',','.')."</td>";
			echo "<td align='right'>".number_format($Diferencias[B][5]-$Diferencias[F][5],2,',','.')."</td>";
			echo "<td align='right'>".number_format($Diferencias[B][6]-$Diferencias[F][6],3,',','.')."</td>";
		break;
	}
	if($TipoDato!='D')
	{
		$Consulta = "select * from pcip_ena_datos_enabal where origen='".$Origen."' and tipo_dato='".$TipoDato."' and tipo_mov='".$TipoMov."'";
		$Consulta.=" and cod_flujo='".$CodFlujo."'";
		$Consulta.=" and ano='".$AnoAux."' and mes =  '".$MesAux."'";	
		//echo $Consulta;
		$Resp2=mysqli_query($link, $Consulta);
		if($Fila2=mysql_fetch_array($Resp2))
		{
			echo "<td align='right'>".number_format($Fila2["peso"],0,'','.')."</td>";
			echo "<td align='right'>".number_format($Fila2[cobre],0,'','.')."</td>";
			echo "<td align='right'>".number_format($Fila2[plata],0,'','.')."</td>";
			echo "<td align='right'>".number_format($Fila2[oro],0,'','.')."</td>";
			if($Fila2["peso"]>0)
				echo "<td align='right'>".number_format($Fila2[cobre]/$Fila2["peso"],2,',','.')."</td>";
			else
				echo "<td align='right'>0</td>";
			if($Fila2["peso"]>0)
				echo "<td align='right'>".number_format($Fila2[plata]/$Fila2["peso"],2,',','.')."</td>";
			else
				echo "<td align='right'>0</td>";
			if($Fila2["peso"]>0)	
				echo "<td align='right'>".number_format($Fila2[oro]/$Fila2["peso"],3,',','.')."</td>";
			else
				echo "<td align='right'>0</td>";
			$Diferencias[$TipoDato][0]=$Fila2["peso"];
			$Diferencias[$TipoDato][1]=$Fila2[cobre];
			$Diferencias[$TipoDato][2]=$Fila2[plata];
			$Diferencias[$TipoDato][3]=$Fila2[oro];
			if($Fila2["peso"]>0)
			{
				$Diferencias[$TipoDato][4]=$Fila2[cobre]/$Fila2["peso"];
				$Diferencias[$TipoDato][5]=$Fila2[plata]/$Fila2["peso"];
				$Diferencias[$TipoDato][6]=$Fila2[oro]/$Fila2["peso"];
			}	
			else
			{
				$Diferencias[$TipoDato][4]=0;
				$Diferencias[$TipoDato][5]=0;
				$Diferencias[$TipoDato][6]=0;
			}
		}
		else
			echo "<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>";
	}
}

?>