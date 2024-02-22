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
<title>Reporte Asignaciones Svp Excel</title>
<link href="estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
.Estilo11 {font-size: 11px}
</style></head>
<body>
<form name="frmPrincipal" action="" method="post">
  <table width="100%" border="1" cellpadding="0" cellspacing="1" >
    <tr>
      <?
			  $Col=1;
			  if($CmbMostrar=='D')
					$Col=2;
			?>
      <td width="74%"  colspan="<? echo $Col;?>" rowspan="2" align="center"><span class="Estilo11">Asignaciones Reales de Producci&oacute;n </span></td>
      <td width="74%"  rowspan="2" align="center">Unidad</td>
      <?
			$Consulta="select t1.cod_negocio,t2.nom_negocio from pcip_svp_asignaciones_titulos t1 inner join pcip_svp_negocios t2 on t1.cod_negocio=t2.cod_negocio where t1.cod_asignacion='".$CmbProd."' and t1.vigente='1' and t1.mostrar_asig='1' and t2.cod_negocio<>'4' and t2.mostrar_asig='1' group by t1.cod_asignacion,t1.cod_negocio order by t2.orden";
			$Resp=mysql_query($Consulta);
			while($Fila=mysql_fetch_array($Resp))
			{			    
				$NumCols=NumOrdenesPorNegocio($CmbProd,$Fila[cod_negocio]);
			?>
      <td width="11%"  colspan="<? echo $NumCols;?>" align="center"><span class="Estilo11"><? echo $Fila[nom_negocio]?></span></td>
      <?	
			}
			?>
      <td width="13%"  rowspan="2" align="center"><span class="Estilo11">TOTAL</span></td>
    </tr>
    <tr>
      <?			 
			$Consulta="select t1.cod_titulo,t1.nom_titulo from pcip_svp_asignaciones_titulos t1 inner join pcip_svp_negocios t2 on t1.cod_negocio=t2.cod_negocio ";
			$Consulta.="where t1.cod_asignacion='".$CmbProd."' and t1.vigente='1' and t1.mostrar_asig='1' and t2.cod_negocio<>'4' and t2.mostrar_asig='1' group by t1.cod_titulo order by t2.orden,t1.orden";
			//echo $Consulta;
			$Resp=mysql_query($Consulta);
			while($Fila=mysql_fetch_array($Resp))
			{
			?>
      <td><? echo $Fila[nom_titulo];?>&nbsp;</td>
      <?
			}
			?>
    </tr>
    <?
		  if($CmbMostrar=='D')
		  {
		  	for($i=$Mes;$i<=$MesFin;$i++)
			{
				//$Consulta="select * from pcip_svp_asignaciones_productos where cod_asignacion='".$CmbProd."' and tipo='SVP' order by orden";
				$Consulta="select distinct t1.cod_asignacion,t1.cod_producto,t1.nom_asignacion,t1.orden,t1.tipo,t1.vigente,t1.origen,t1.cod_unidad from pcip_svp_asignaciones_productos t1 inner join pcip_svp_productos_procedencias t2 on t2.cod_procedencia=t1.cod_producto";
				$Consulta.=" where t1.cod_asignacion='".$CmbProd."' and t1.tipo='SVP' group by t1.cod_asignacion,t1.cod_producto order by t1.orden";
				//echo $Consulta;
				$Resp=mysql_query($Consulta);
				$Cant=1;
				while($Fila=mysql_fetch_array($Resp))
				{
					$TotalProd=0;
					if($Cant==1)
					{
						$CantFilas=0;
						$Consulta="select count(*) as tot_fil from pcip_svp_asignaciones_productos t1 inner join  pcip_svp_productos_procedencias t2 on t1.cod_producto=t2.cod_procedencia";
						$Consulta.=" where t1.cod_asignacion='".$CmbProd."' and t1.tipo='SVP' group by t1.cod_asignacion,t1.cod_producto order by t1.orden";
						//echo $Consulta."<br>";
						$RespCant=mysql_query($Consulta);
						while($FilaCant=mysql_fetch_array($RespCant))
							$CantFilas++;
						echo "<tr>";
						echo "<td rowspan='".$CantFilas."'>".$Meses[$i-1]."</td>";
					}
					 
					echo "<td>".$Fila[nom_asignacion]."</td>";
					echo"<td align='center'>".$Fila[cod_unidad]."&nbsp;</td>";					
					//$Consulta="select cod_titulo as cod_tit,orden from pcip_svp_asignaciones_titulos where vigente='1' and cod_asignacion='".$CmbProd."' and cod_negocio<>'4' order by orden";
					$Consulta="select t1.cod_titulo as cod_tit,t1.orden,t2.cod_negocio from pcip_svp_asignaciones_titulos t1 inner join pcip_svp_negocios t2 on t1.cod_negocio=t2.cod_negocio ";
					$Consulta.="where t1.cod_asignacion='".$CmbProd."' and t1.vigente='1' and t1.mostrar_asig='1' and t2.cod_negocio<>'4' and t2.mostrar_asig='1' group by t1.cod_titulo order by t2.orden,t1.orden";
					$RespTit=mysql_query($Consulta);
					while($FilaTit=mysql_fetch_array($RespTit))
					{
						$Clase='';
						if($FilaTit[cod_negocio]=='1')
							$Clase="CorteAmarillo";
						if($FilaTit[cod_negocio]=='2')
							$Clase="FilaAbeja";				
						if($FilaTit[cod_negocio]=='3')
							$Clase="texto_bold";	
						$Consulta="select t1.cod_negocio,t2.origen,t2.nodo,t2.signo,t2.factor,t2.num_orden,t2.num_orden_relacionada,t2.cod_material,t2.consumo_interno,t2.vptm from pcip_svp_negocios t1 inner join pcip_svp_productos_procedencias t2 on t1.cod_negocio=t2.cod_negocio and t2.origen in ('SVP','CDV','ENA','PMN')";
						$Consulta.="where t2.cod_asignacion='".$CmbProd."' and t2.ano='".$Ano."' and t2.cod_procedencia='".$Fila["cod_producto"]."' and t2.cod_titulo='".$FilaTit[cod_tit]."' and t1.vigente='1' and t1.cod_negocio<>'4' and t1.mostrar_asig='1' order by t1.orden";
						//echo $Consulta."<br>";
						$Resp2=mysql_query($Consulta);$Cantidad=0;
						while($Fila2=mysql_fetch_array($Resp2))
						{
						  //echo "entrooooo<br>";
							if($Fila2[cod_negocio]=='1')
								$Clase="CorteAmarillo";
							if($Fila2[cod_negocio]=='2')
								$Clase="FilaAbeja";				
							if($Fila2[cod_negocio]=='3')
								$Clase="texto_bold";	
						    switch($Fila2[origen])							
							{
							  case "SVP":
										$Consulta="select VPcantidad from pcip_svp_valorizacproduccion where VPorden='".$Fila2[num_orden]."' and VPa�o='".$Ano."' and VPmes='".$i."' ";
										if(!is_null($Fila2[num_orden_relacionada])&&$Fila2[num_orden_relacionada]!=0)
											$Consulta.=" and VPordenrel='".$Fila2[num_orden_relacionada]."'";
										if(!is_null($Fila2[cod_material]))
											$Consulta.=" and VPmaterial='".$Fila2[cod_material]."'";
										if(!is_null($Fila2[consumo_interno]))
											$Consulta.=" and VPordes='".$Fila2[consumo_interno]."'";
										if(!is_null($Fila2[vptm])&&$Fila2[vptm]<>0)
											$Consulta.=" and vptm='".$Fila2[vptm]."'";
										//echo "SVP:   ".$Consulta."<br>"; 
										$Resp3=mysql_query($Consulta);$CantidadAux=0;$Cantidad=0;
										while($Fila3=mysql_fetch_array($Resp3))
										{
											$CantidadAux=($Fila3[VPcantidad])*$Fila2[factor];	
											if($Fila2[signo]=='')
												$Fila2[signo]='+';
											if($Fila2[signo]=='+')
												$Cantidad=$Cantidad+$CantidadAux;
											else
											   	$Cantidad=$Cantidad-$CantidadAux;
										}
							  break;	
							  case "CDV":		
								$Consulta="select sum(kilos_finos) as kilos_finos from pcip_cdv_cuadro_diario_ventas where cod_producto='".$Fila2[num_orden]."' and ano='".$Ano."' and mes='".$i."' and ajuste='N' and tipo_venta='8'";
								$Resp3=mysql_query($Consulta);
								//echo "CDV:   ".$Consulta."<br>";
								while($Fila3=mysql_fetch_array($Resp3))
								{
									if($Fila2[signo]=='')
										$Fila2[signo]='+';
								    if($Fila2[signo]=='+')
										$Cantidad=($Cantidad+$Fila3[kilos_finos])*$Fila2[factor];
									else	
										$Cantidad=($Cantidad-$Fila3[kilos_finos])*$Fila2[factor];
								}
								if($Cantidad!='0')
									$Cantidad=$Cantidad/1000;
							  break;
							  case "ENA":
							  case "PMN":		
								$Consulta="select ";
								switch($Fila2[num_orden_relacionada])
								{
									case "1":
										$Consulta.=" cobre ";
										break;
									case "2":
										$Consulta.=" plata ";
										break;
									case "3":
										$Consulta.=" oro ";
										break;										
									default:
										$Consulta.=" cobre ";
										break;
								}
								$Consulta.=" as kilos_finos from pcip_ena_datos_enabal where origen='".$Fila2[origen]."' and cod_flujo='".$Fila2[num_orden]."' and ano='".$Ano."' and mes='".$i."' and tipo_dato='F' and tipo_mov='".$Fila2["nodo"]."'";
								$Resp3=mysql_query($Consulta);
								//echo "ENA PMN:   ".$Consulta."<br>";
								while($Fila3=mysql_fetch_array($Resp3))
								{
									if($Fila2[signo]=='')
										$Fila2[signo]='+';
								    if($Fila2[signo]=='+')
										$Cantidad=($Cantidad+$Fila3[kilos_finos])*$Fila2[factor];
									else	
										$Cantidad=($Cantidad-$Fila3[kilos_finos])*$Fila2[factor];
								}
								if($Cantidad!='0' && ($Fila2[num_orden_relacionada]==2 ||$Fila2[num_orden_relacionada]==3))
									$Cantidad=$Cantidad/1000;
							  break;
							}		
						}
						if($Cantidad!=0)
						{	 						   					
							echo "<td align='right'>".number_format($Cantidad,3,',','.')."</td>";
							$TotalProd=$TotalProd+$Cantidad;
						}
						else
							echo "<td>&nbsp;</td>";	
					}
					echo "<td align='right'>".number_format($TotalProd,3,',','.')."</td>";	
					echo "</tr>";
					$Cant++;
				}
			}
		  }
		  if($CmbMostrar=='R')
		  {
				$Consulta="select distinct t1.cod_asignacion,t1.cod_producto,t1.nom_asignacion,t1.orden,t1.tipo,t1.vigente,t1.origen,t1.cod_unidad from pcip_svp_asignaciones_productos t1 inner join pcip_svp_productos_procedencias t2 on t1.cod_producto=t2.cod_procedencia";
				$Consulta.=" where t1.cod_asignacion='".$CmbProd."' and t1.tipo='SVP' group by t1.cod_asignacion,t1.cod_producto order by t1.orden";
				//echo $Consulta;
				$Resp=mysql_query($Consulta);
				$Cant=1;
				while($Fila=mysql_fetch_array($Resp))
				{
					//echo $EncontroValor."<br>";
					$TotalProd=0;
					echo "<td>".$Fila[nom_asignacion]."</td>";
					echo"<td align='center'>".$Fila[cod_unidad]."&nbsp;</td>";					
					//$Consulta="select cod_titulo as cod_tit,orden from pcip_svp_asignaciones_titulos where vigente='1' and cod_asignacion='".$CmbProd."' and cod_negocio<>'4' order by orden";
					$Consulta="select t2.cod_negocio,t1.cod_titulo as cod_tit,t1.orden from pcip_svp_asignaciones_titulos t1 inner join pcip_svp_negocios t2 on t1.cod_negocio=t2.cod_negocio ";
					$Consulta.="where t1.cod_asignacion='".$CmbProd."' and t1.vigente='1' and t1.mostrar_asig='1' and t2.cod_negocio<>'4' and t2.mostrar_asig='1' group by t1.cod_titulo order by t2.orden,t1.orden";
					$RespTit=mysql_query($Consulta);
					//echo $Consulta."<br>";
					while($FilaTit=mysql_fetch_array($RespTit))
					{
						$Clase='';
						if($FilaTit[cod_negocio]=='1')
							$Clase="CorteAmarillo";
						if($FilaTit[cod_negocio]=='2')
							$Clase="FilaAbeja";				
						if($FilaTit[cod_negocio]=='3')
							$Clase="texto_bold";	
						$Consulta="select t2.origen,t2.signo,t2.factor,t2.nodo,t2.num_orden,t2.num_orden_relacionada,t2.cod_material,t2.consumo_interno,t2.vptm from pcip_svp_negocios t1 inner join pcip_svp_productos_procedencias t2 on t1.cod_negocio=t2.cod_negocio and t2.origen in ('SVP','CDV','ENA','PMN')";
						$Consulta.="where t2.cod_asignacion='".$CmbProd."' and t2.ano='".$Ano."' and t2.cod_procedencia='".$Fila["cod_producto"]."' and t2.cod_titulo='".$FilaTit[cod_tit]."' and t1.vigente='1' and t1.cod_negocio<>'4' and t1.mostrar_asig='1' order by t1.orden";
						//if($Fila[nom_asignacion]=='CATODOS GRADO A')
						//echo $Consulta."<br>";
						$Resp2=mysql_query($Consulta);$Encontro='N';$Cantidad=0;
						while($Fila2=mysql_fetch_array($Resp2))
						{												
							switch($Fila2[origen])
							{
								case "SVP":								
										$Consulta="select VPcantidad from pcip_svp_valorizacproduccion where VPorden='".$Fila2[num_orden]."' and VPa�o='".$Ano."' and VPmes>='".$Mes."' and VPmes<='".$MesFin."'";
										if(!is_null($Fila2[num_orden_relacionada])&&$Fila2[num_orden_relacionada]!=0)
											$Consulta.=" and VPordenrel='".$Fila2[num_orden_relacionada]."'";
										if(!is_null($Fila2[cod_material]))
											$Consulta.=" and VPmaterial='".$Fila2[cod_material]."'";
										if(!is_null($Fila2[consumo_interno]))
											$Consulta.=" and VPordes='".$Fila2[consumo_interno]."'";
										if(!is_null($Fila2[vptm])&&$Fila2[vptm]<>0)
											$Consulta.=" and vptm='".$Fila2[vptm]."'";
										$Resp3=mysql_query($Consulta);
										while($Fila3=mysql_fetch_array($Resp3))
										{
											if($Fila2[signo]=='')
												$Fila2[signo]='+';
											if($Fila2[signo]=='+')
												$Cantidad=$Cantidad+$Fila3[VPcantidad];
											else	
												$Cantidad=$Cantidad-$Fila3[VPcantidad];
										}
								break;	
								case "CDV":
										$Consulta="select kilos_finos from pcip_cdv_cuadro_diario_ventas where cod_producto='".$Fila2[num_orden]."' and ano='".$Ano."' and mes>='".$Mes."' and mes<='".$MesFin."' and ajuste='N' and tipo_venta='8'";
										//echo $Consulta."<br>";
										$Resp3=mysql_query($Consulta);
										while($Fila3=mysql_fetch_array($Resp3))
										{
											if($Fila2[signo]=='')
												$Fila2[signo]='+';
											if($Fila2[signo]=='+')
												$Cantidad=$Cantidad+$Fila3[kilos_finos];
											else
												$Cantidad=$Cantidad-$Fila3[kilos_finos];
										}
										if($Cantidad!='0')
											$Cantidad=$Cantidad/1000;
								break;	
								case "ENA":
								case "PMN";
										$Consulta="select ";
										switch($Fila2[num_orden_relacionada])
										{
											case "1":
												$Consulta.=" cobre ";
												break;
											case "2":
												$Consulta.=" plata ";
												break;
											case "3":
												$Consulta.=" oro ";
												break;										
											default:
												$Consulta.=" cobre ";
												break;
										}
										$Consulta.=" as kilos_finos from pcip_ena_datos_enabal where origen='".$Fila2[origen]."' and cod_flujo='".$Fila2[num_orden]."' and ano='".$Ano."' and mes='".$Mes."' and tipo_dato='F' and tipo_mov='".$Fila2[nodo]."'";
										$Resp3=mysql_query($Consulta);
										//echo $Consulta."<br>";
										while($Fila3=mysql_fetch_array($Resp3))
										{
											if($Fila2[signo]=='')
												$Fila2[signo]='+';
											if($Fila2[signo]=='+')
												$Cantidad=($Cantidad+$Fila3[kilos_finos])*$Fila2[factor];
											else	
												$Cantidad=($Cantidad-$Fila3[kilos_finos])*$Fila2[factor];
										}
										if($Cantidad!='0' && ($Fila2[num_orden_relacionada]==2 ||$Fila2[num_orden_relacionada]==3))
											$Cantidad=$Cantidad/1000;
								break;
							}	
						}
						if($Cantidad!=0)
						{
							echo "<td align='right'>".number_format($Cantidad,3,',','.')."</td>";
							$TotalProd=$TotalProd+$Cantidad;
						}
						else
							echo "<td>&nbsp;</td>";
					}									
					echo "<td align='right'>".number_format($TotalProd,3,',','.')."</td>";	
					echo "</tr>";
				}
		  }		  
		  ?>
  </table>
</form>
</body>
</html>
<?
function NumOrdenesPorNegocio($CodAsig,$CodNeg)
{
	$Consulta="select count(*) as cantidad from pcip_svp_asignaciones_titulos where vigente='1' and cod_asignacion='".$CodAsig."' and cod_negocio='".$CodNeg."' and mostrar_asig='1'";
	//echo $Consulta;
	$Resp=mysql_query($Consulta);
	if($Fila=mysql_fetch_array($Resp))
		return($Fila[cantidad]);
	else
		return(0);	
		
}

?>