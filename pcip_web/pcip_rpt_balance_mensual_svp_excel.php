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
<title>Reporte Balanace Mensual</title>
<link href="estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<body>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<body>
<form name="frmPrincipal" action="" method="post">
  <table width="100%" border="1" cellpadding="0" cellspacing="0" >
    <?
	 $Buscar='S';
		  	if($Buscar=='S')
			{	
				$Consulta = "select nombre_subclase,cod_subclase as cod_negocio from proyecto_modernizacion.sub_clase where cod_clase='31005' and cod_subclase='".$CmbTipoNegocio."' order by cod_subclase ";			
				//echo $Consulta;
				$RespNeg=mysqli_query($link, $Consulta);
				while ($FilaNeg=mysql_fetch_array($RespNeg))
				{
				   $CodNegocio=$FilaNeg["cod_subclase"];
				   $NomNegocio=$FilaNeg["nombre_subclase"];
					$CantCol=3;
					for($i=$Mes;$i<=$MesFin;$i++)
						$CantCol++;
					echo "<tr>";
					echo "<td colspan='".($CantCol*2)."'><span class='Estilo9'>NEGOCIO: ".strtoupper($NomNegocio)."</strong></td>";
					echo "</tr>";
					$Consulta = "select nombre_subclase,cod_subclase as cod_etapa from proyecto_modernizacion.sub_clase where cod_clase='31004' ";
					if($CmbEtapa!='T')
						$Consulta.="and cod_subclase='".$CmbEtapa."'";
					$Consulta.= "order by cod_subclase ";			
					$RespEtapa=mysqli_query($link, $Consulta);
					while ($FilaEtapa=mysql_fetch_array($RespEtapa))
					{
						$CantCol=3;
						for($i=$Mes;$i<=$MesFin;$i++)
							$CantCol++;
						echo "<tr>";
						echo "<td colspan='".($CantCol*2)."'><span class='Estilo9'>".$FilaEtapa["nombre_subclase"]."</td>";
						echo "</tr>";
						?>
    <tr>
      <td width="10%" rowspan="2" align="center"><span class="Estilo9">Tipos</span></td>
      <?
							for($i=$Mes;$i<=$MesFin;$i++)
							{
								echo "<td width='6%' colspan='2' align='center'><span class='Estilo9'>".substr($Meses[$i-1],0,3)."</span></td>";
							}
							?>
      <td colspan="2" align="center"><span class="Estilo9">ACUMULADO</span></td>
    </tr>
    <tr>
      <?
							for($i=$Mes;$i<=$MesFin;$i++)
							{
								echo "<td width='3%' align='center'><span class='Estilo9'>REAL</span></td>";
								echo "<td width='3%' align='center'><span class='Estilo9'>PROGRAMADA</span></td>";
							}
							?>
      <td width="20%" align="center"><span class="Estilo9">REAL</span></td>
      <td width="20%" align="center"><span class="Estilo9">PROGRAMADA</span></td>
    </tr>
    <?
						$Consulta = "select nombre_subclase,cod_subclase as cod_bal from proyecto_modernizacion.sub_clase where cod_clase='31003' order by valor_subclase1 ";			
						$RespBal=mysqli_query($link, $Consulta);
						while ($FilaBal=mysql_fetch_array($RespBal))
						{
							$CantCol=3;
							for($i=$Mes;$i<=$MesFin;$i++)
								$CantCol++;
							echo "<tr>";
							echo "<td colspan='".($CantCol*2)."'><span class='Estilo9'>".strtoupper($FilaBal["nombre_subclase"])."</td>";
							echo "</tr>";
							$Consulta = "select distinct t1.cod_producto_etapa,t2.nom_producto_etapa from pcip_svp_balance_mensual t1 inner join pcip_svp_productos_etapas t2 on t1.cod_producto_etapa=t2.cod_producto_etapa ";
							$Consulta.= "where t1.cod_etapa='".$FilaEtapa[cod_etapa]."' and t1.cod_tipo_negocio='".$FilaNeg[cod_negocio]."' and t1.cod_tipo_balance='".$FilaBal[cod_bal]."'";
							if($CmbTipoInforme!='-1')
								$Consulta.="and t1.cod_tipo_informe='".$CmbTipoInforme."'";
							if($CmbProd!='T')
								$Consulta.="and t1.cod_producto_etapa='".$CmbProd."'";		
							$Consulta.= "order by cod_producto_etapa ";
							//echo $Consulta."<br>";		
							$RespProd=mysqli_query($link, $Consulta);
							while ($FilaProd=mysql_fetch_array($RespProd))
							{
								echo "<tr>";
								echo "<td>".$FilaProd[nom_producto_etapa]."</td>";
								$Consulta = "select * from pcip_svp_balance_mensual t1 where t1.cod_etapa='".$FilaEtapa[cod_etapa]."' and t1.cod_tipo_negocio='".$FilaNeg[cod_negocio]."' and t1.cod_tipo_balance='".$FilaBal[cod_bal]."' and t1.cod_producto_etapa='".$FilaProd[cod_producto_etapa]."'";
								if($CmbTipoInforme!='-1')
									$Consulta.="and t1.cod_tipo_informe='".$CmbTipoInforme."'";	
								$Consulta.= "order by cod_producto_etapa ";
								//echo $Consulta."<br>";		
								$RespParam=mysqli_query($link, $Consulta);
								while ($FilaParam=mysql_fetch_array($RespParam))
								{
									$Total=0;
									for($i=$Mes;$i<=$MesFin;$i++)
									{
										$Consulta="SELECT VPcantidad FROM pcip_svp_valorizacproduccion WHERE VPa&ntilde;o = '".$Ano."' AND VPmes = '".$i."' AND VPtm = ".$FilaParam[tramo]." AND VPorden = '".$FilaParam[num_orden]."' and VPtipinv='".$FilaParam[tipo_inventario]."' and VPmaterial='".$FilaParam[cod_material]."' and VPordes='".$FilaParam[ordes]."'";
										$Resp2=mysqli_query($link, $Consulta);
										//echo $Consulta."<br>";
										if($Fila2=mysql_fetch_array($Resp2))
											echo "<td align='right'>".number_format($Fila2[VPcantidad],3,',','.')."</td>";
										else
											echo "<td>&nbsp;</td>";
										echo "<td>&nbsp;</td>";	
										$Total=$Total+$Fila2[VPcantidad];
									}
									echo "<td align='right'>".number_format($Total,3,',','.')."</td>";
									echo "<td>&nbsp;</td>";
								}
								echo "</tr>";	
							}
						}
					}
				}	
			}
		  ?>
  </table>
</form>
</body>
</html>