<? 
header("Content-Type:  application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

include("../principal/conectar_scop_web.php");
$KoolControlsFolder="KoolPHPSuite/KoolControls";
require $KoolControlsFolder."/KoolAjax/koolajax.php";
$koolajax->scriptFolder = $KoolControlsFolder."/KoolAjax";


if($koolajax->isCallback)
{
	sleep(1); //Slow down 1s to see loading effect
}
echo $koolajax->Render();

?>
<html>
<head>
<title>Inventario para Cobertura Excel</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<form name="FrmPopupProceso" method="post">
  <table width="100%"  border="1" align="center" cellpadding="3"  cellspacing="0">
    <?
					$arreglo=array();
					$Datos = explode("~",$TipoEst);
					$x=0;
					foreach($Datos as $clave => $Codigo)
					{
						$arreglo[$x][0]=$Codigo;
						$x=$x+1; 
					}	
					for($i=0;$i<=$x;$i++)
					{
						if('Cu'==$arreglo[$i][0])
							$Cu=1;$Colspan=2;	
						if('Ag'==$arreglo[$i][0])
							$Ag=2;$Colspan=$Colspan+2;
						if('Au'==$arreglo[$i][0])
							$Au=3;$Colspan=$Colspan+2;	
					}
					if(!isset($Buscar))
						echo "<input type='hidden' name='Grabar' value='2'>";		
				  ?>
				<tr>
				  <td align="left">Ano/Mes</td>
				  <td  align="left"><? echo $Ano."/".$Meses[$CmbMes-1];?></td>
				</tr>
				<tr>
				  <td align="left">Acuerdo Contractual</td>
				  <?
				   if($CmbAcuerdo=='-1'&&$CmbAcuerdo!='P'&&$CmbAcuerdo!='T')
				   		$Mes='Mes&nbsp;'.$CmbAcuerdo;
				   if($CmbAcuerdo!='-1'&&$CmbAcuerdo!='P'&&$CmbAcuerdo!='T')
						$Mes='Mes&nbsp;+'.$CmbAcuerdo;	
				   if($CmbAcuerdo=='P')
						$Mes='Precio Fijo';	
				   if($CmbAcuerdo=='T')
						$Mes='Todos';	
				  ?>
				  <td align="left"><? echo $Mes;?></td>
				</tr><br>
				<tr>
				  <td  colspan="3" align="center">Inventario</td>
				  <td width="125"  colspan="<? echo $Colspan;?>" align="center">&nbsp;</td>
				</tr>
				<tr >
				  <td colspan="3">Contratos</td>
				  <? 
					$arregloContr=array();
					$DatosContr = explode("~",$ContInvo);
					$c=0;
					while (list($clave,$CodigoContr)=each($DatosContr))
					{
						$arregloContr[$c][0]=$CodigoContr;
						$c=$c+1; 
					}	
					
					$arreglo=array();
					$Datos = explode("~",$TipoEst);
					$x=0;
					foreach($Datos as $clave => $Codigo)
					{
						$arreglo[$x][0]=$Codigo;
						$x=$x+1; 
					}	
					for($i=0;$i<=$x;$i++)
					{				
						if($CmbAcuerdo!='P')
							$Tipo='1';
						else
							$Tipo='2';						
						if('Cu'==$arreglo[$i][0])
							$Dato.=" t2.tipo_cu='".$Tipo."' or";									
						if('Ag'==$arreglo[$i][0])
							$Dato.=" t2.acuerdo_ag='".$CmbAcuerdo."' or";									
						if('Au'==$arreglo[$i][0])
							$Dato.=" t2.acuerdo_au='".$CmbAcuerdo."' or";									
					}
					if($Dato!='')
						$Dato=substr($Dato,0,strlen($Dato)-2);
						
						$Cobre="[OZ]";$Plata="[OZ]";$Oro="[OZ]";
						if($Cu==1)
						{
						?>
						  <td width="125" align='center'>Cobre [Kg]</td>
						  <td width="108" align='center'>Cobre <? echo $Cobre;?></td>
						  <?
						}
						if($Ag==2)
						{
						?>
						  <td width="101" align='center'>PLata [Grs]</td>
						  <td width="99" align='center'>PLata <? echo $Plata;?></td>
						  <?
						}
						if($Au==3)
						{
						?>
						  <td width="96" align='center'>Oro [Grs]</td>
						  <td width="91" align='center'>Oro <? echo $Oro;?></td>
						  <?
						}
					?>
	</tr>
					<?
							$ArrFinos=array();
							$Consulta="select * from scop_inventario t1 inner join scop_contratos t2 on t1.cod_contrato=t2.cod_contrato where t1.mes='".$CmbMes."' and t1.cod_estado='2'";
							if($CmbAcuerdo!=='T')
								$Consulta.=" $TipoCon $Dato";
						    $Consulta.="and t2.vigente='1' group by t2.cod_contrato";
							$Resp=mysql_query($Consulta);$Contratos='';
							while ($Fila=mysql_fetch_array($Resp))
							{	
								$Consulta2=" select * from scop_contratos t1 inner join scop_contratos_flujos t2 on t1.cod_contrato=t2.cod_contrato where t2.cod_contrato='".$Fila["cod_contrato"]."' and t2.tipo_inventario='4' and t1.vigente='1'";
								$Resp2=mysql_query($Consulta2);$ArrFinos[1][Cu]='';$ArrFinos[2][Ag]='';$ArrFinos[3][Au]='';
								while($Fila2=mysql_fetch_array($Resp2))
								{	
									$TipoInventario=$Fila2[tipo_inventario];
									$TipoFlujo=$Fila2[tipo_flujo];
									$CodFlujo=$Fila2["flujo"];
									$Contrato=$Fila2["cod_contrato"];
									
									$Buscar2='S';
									$ValorPeso=DatosEnabalFlujos($Ano,$CmbMes,$Contrato,$TipoFlujo,$CodFlujo,&$ArrFinos,'4');
									
								}
								$Contratos=$Contratos.$Fila["cod_contrato"]."~";								
									echo "<tr bgcolor='#FFFFFF'>";
									$CheckedCtto="";
									if(!isset($ContInvo))
										$CheckedCtto="checked";	
									for($i=0;$i<=$c;$i++)
									{
										//echo $arregloContr[$i][0];
										if($Fila["cod_contrato"]==$arregloContr[$i][0])
											$CheckedCtto="checked";	
									}
									$DetalleContrato=$Ano."~".$CmbMes."~".$CmbAcuerdo;
									if($CmbAcuerdo=='P')
									{
										for($i=0;$i<=$x;$i++)
										{
											if('Cu'==$arreglo[$i][0])
												$PF="<span class='formulario'>&nbsp;&nbsp;P.F Cu:  ".$Fila[acuerdo_cu]."&nbsp;cUSD/Lb</span>,";
											if('Ag'==$arreglo[$i][0])
												$PF=$PF."<span class='formulario'>&nbsp;&nbsp;P.F Ag:   ".$Fila[acuerdo_ag]."&nbsp;USD/Oz</span>,";
											if('Au'==$arreglo[$i][0])
												$PF=$PF."<span class='formulario'>&nbsp;&nbsp;P.F Au:  ".$Fila[acuerdo_au]."&nbsp;USD/Oz</span>,";
										}
									}
									if($PF!='')
										$PF=substr($PF,0,strlen($PF)-1);
									echo "<td>".$Fila["num_contrato"]."</td>";									
									echo "<td>".$PF."</td>";
									echo "<td width='287'>".$Fila[descrip_contrato]."</td>";
									echo "</td>";$ValorCobre=0;$ValorPLata=0;$ValorOro=0;
									$arreglo=array();
									$Datos = explode("~",$TipoEst);
									$x=0;
									foreach($Datos as $clave => $Codigo)
									{
										$arreglo[$x][0]=$Codigo;
										$x=$x+1; 
									}	
									for($i=0;$i<=$x;$i++)
									{
										if('Cu'==$arreglo[$i][0])
										{
											if($CmbAcuerdo!='P'&&$CmbAcuerdo!='T')
											{
												if($Fila[acuerdo_cu]==$CmbAcuerdo)
												{													
													echo "<td align='right'>".number_format($ArrFinos[1][Cu],3,',','.')."</td>";	
													$ValorCobreOZ=Convertir($ArrFinos[1][Cu],'Cobre');
													echo "<td align='right'>".number_format($ValorCobreOZ,3,',','.')."<input type='hidden' size='12' class='SinBorde' class='InputDer' value=".number_format($ValorCobreOZ,3,',','.').">";				
												}
												else
												{
													echo "<td align='right'>".number_format(0,3,',','.')."</td>";	
													echo "<td align='right'>".number_format(0,3,',','.')."";				
												}	
											}
											if($CmbAcuerdo=='P')
											{
												echo "<td align='right'>".number_format($ArrFinos[1][Cu],3,',','.')."</td>";	
												$ValorCobreOZ=Convertir($ArrFinos[1][Cu],'Cobre');
												echo "<td align='right'>".number_format($ValorCobreOZ,3,',','.')."<input type='hidden' size='12' class='SinBorde' class='InputDer' value=".number_format($ValorCobreOZ,3,',','.').">";				
											}
											if($CmbAcuerdo=='T')
											{
												echo "<td align='right'>".number_format($ArrFinos[1][Cu],3,',','.')."</td>";	
												$ValorCobreOZ=Convertir($ArrFinos[1][Cu],'Cobre');
												echo "<td align='right'>".number_format($ValorCobreOZ,3,',','.')."<input type='hidden' size='12' class='SinBorde' class='InputDer' value=".number_format($ValorCobreOZ,3,',','.').">";				
											}
										}
										if('Ag'==$arreglo[$i][0])
										{									
											if($CmbAcuerdo!='P'&&$CmbAcuerdo!='T')
											{
												if($Fila[acuerdo_ag]==$CmbAcuerdo)
												{
													echo "<td align='right'>".number_format($ArrFinos[2][Ag],3,',','.')."</td>";	
													$ValorPLataOZ=Convertir($ArrFinos[2][Ag],'PLata');
													echo "<td align='right'>".number_format($ValorPLataOZ,3,',','.')."<input type='hidden' size='12' class='SinBorde' class='InputDer' value=".number_format($ValorPLataOZ,3,',','.').">";				
												}
												else
												{
													echo "<td align='right'>".number_format(0,3,',','.')."</td>";	
													echo "<td align='right'>".number_format(0,3,',','.')."";				
												}
											}
											if($CmbAcuerdo=='P')		
											{
												echo "<td align='right'>".number_format($ArrFinos[2][Ag],3,',','.')."</td>";	
												$ValorPLataOZ=Convertir($ArrFinos[2][Ag],'PLata');
												echo "<td align='right'>".number_format($ValorPLataOZ,3,',','.')."<input type='hidden' size='12' class='SinBorde' class='InputDer' value=".number_format($ValorPLataOZ,3,',','.').">";				
											}
											if($CmbAcuerdo=='T')		
											{
												echo "<td align='right'>".number_format($ArrFinos[2][Ag],3,',','.')."</td>";	
												$ValorPLataOZ=Convertir($ArrFinos[2][Ag],'PLata');
												echo "<td align='right'>".number_format($ValorPLataOZ,3,',','.')."<input type='hidden' size='12' class='SinBorde' class='InputDer' value=".number_format($ValorPLataOZ,3,',','.').">";				
											}
										}
										if('Au'==$arreglo[$i][0])
										{
											if($CmbAcuerdo!='P'&&$CmbAcuerdo!='T')
											{
												if($Fila[acuerdo_au]==$CmbAcuerdo)
												{
													echo "<td align='right'>".number_format($ArrFinos[3][Au],3,',','.')."</td>";	
													$ValorOroOZ=Convertir($ArrFinos[3][Au],'Oro');
													echo "<td align='right'>".number_format($ValorOroOZ,3,',','.')."<input type='hidden' size='12' class='SinBorde' class='InputDer' value=".number_format($ValorOroOZ,3,',','.').">";				
												}
												else
												{
													echo "<td align='right'>".number_format(0,3,',','.')."</td>";	
													echo "<td align='right'>".number_format(0,3,',','.')."";				
												}	
											}	
											if($CmbAcuerdo=='P')
											{
													echo "<td align='right'>".number_format($ArrFinos[3][Au],3,',','.')."</td>";	
													$ValorOroOZ=Convertir($ArrFinos[3][Au],'Oro');
													echo "<td align='right'>".number_format($ValorOroOZ,3,',','.')."<input type='hidden' size='12' class='SinBorde' class='InputDer' value=".number_format($ValorOroOZ,3,',','.').">";				
											}	
											if($CmbAcuerdo=='T')
											{
													echo "<td align='right'>".number_format($ArrFinos[3][Au],3,',','.')."</td>";	
													$ValorOroOZ=Convertir($ArrFinos[3][Au],'Oro');
													echo "<td align='right'>".number_format($ValorOroOZ,3,',','.')."<input type='hidden' size='12' class='SinBorde' class='InputDer' value=".number_format($ValorOroOZ,3,',','.').">";				
											}	
										}
									}
								  echo "</tr>";	
								  $AcuerdoCU=$Fila2[acuerdo_cu];$AcuerdoAG=$Fila2[acuerdo_ag];$AcuerdoAU=$Fila2[acuerdo_au];						  
							}	
					$Consulta="select * from scop_inventario t1 inner join scop_contratos t2 on t1.cod_contrato=t2.cod_contrato where t1.mes='".$CmbMes."' and t1.cod_estado='2'";
					if($CmbAcuerdo!=='T')
						$Consulta.=" $TipoCon $Dato";
					$Consulta.=" and t2.vigente='1'";
					$Resp=mysql_query($Consulta);
					if($Fila=mysql_fetch_array($Resp))
					{	
							echo "<tr>";
								echo "<td align='right' colspan='3'>Total</td>";	
									if(!isset($ContInvo))	
									{
										if($Contratos!='')
											$Contratos=substr($Contratos,0,strlen($Contratos)-1);
										echo "<input type='hidden' name='ConSelec' value='".$Contratos."'>";
										$Contratos = explode("~",$Contratos);
										$c=0;
										while (list($clave,$CodigoContr)=each($Contratos))
										{
											$arregloContr[$c][0]=$CodigoContr;
											$c=$c+1; 
										}	
									}
									else
									{
										$arregloContr=array();
										$DatosContr = explode("~",$ContInvo);
										$c=0;
										while (list($clave,$CodigoContr)=each($DatosContr))
										{
											$arregloContr[$c][0]=$CodigoContr;
											$c=$c+1; 
										}	
									}
									$ValorCobre2=0;$ValorPLata2=0;$ValorOro2=0;
									for($i=0;$i<=$c;$i++)
									{
										$ConsultaFlujos="select * from scop_contratos_flujos t1 inner join scop_contratos t2 on t1.cod_contrato=t2.cod_contrato where t1.cod_contrato='".$arregloContr[$i][0]."' and t1.tipo_inventario='4' and t2.vigente='1'";
										$RespFlujos = mysql_query($ConsultaFlujos);
										while($FilaFlujos=mysql_fetch_array($RespFlujos))
										{
											$ConsultaEnabal="select cobre,plata,oro";
											$ConsultaEnabal.=" from scop_datos_enabal where ano='".$Ano."' and mes='".$CmbMes."' and origen='".$FilaFlujos[tipo_flujo]."' and cod_flujo='".$FilaFlujos["flujo"]."' and tipo_mov='3' and tipo_dato='F'";		
											$RespEnabal=mysql_query($ConsultaEnabal);
											while($FilaEnabal=mysql_fetch_array($RespEnabal))
											{
												if($CmbAcuerdo!='P'&&$CmbAcuerdo!='T')
												{
													if($FilaFlujos[tipo_cu]==$CmbAcuerdo)
														$ValorCobre2=$ValorCobre2+$FilaEnabal[cobre];
													else
														$ValorCobre2=$ValorCobre2+0;	
													if($FilaFlujos[acuerdo_ag]==$CmbAcuerdo)
														$ValorPLata2=$ValorPLata2+$FilaEnabal[plata];
													else
														$ValorPLata2=$ValorPLata2+0;		
													if($FilaFlujos[acuerdo_au]==$CmbAcuerdo)
														$ValorOro2=$ValorOro2+$FilaEnabal[oro];
													else
														$ValorOro2=$ValorOro2+0;												
												}
												else
												{
													$ValorCobre2=$ValorCobre2+$FilaEnabal[cobre];
													$ValorPLata2=$ValorPLata2+$FilaEnabal[plata];
													$ValorOro2=$ValorOro2+$FilaEnabal[oro];
												}													
											}
										}												
									}
									$ValorCobreOZ=Convertir($ValorCobre2,'Cobre');
									$ValorPlataOZ=Convertir($ValorPLata2,'PLata');
									$ValorOroOZ=Convertir($ValorOro2,'Oro');	
									$arreglo=array();
									$Datos = explode("~",$TipoEst);
									$x=0;
									foreach($Datos as $clave => $Codigo)
									{
										$arreglo[$x][0]=$Codigo;
										$x=$x+1; 
									}	
									for($i=0;$i<=$x;$i++)
									{
										if('Cu'==$arreglo[$i][0])
										{
												echo "<td align='right'>".number_format($ValorCobre2,3,',','.')."</td>";				
												echo "<td align='right'>".number_format($ValorCobreOZ,3,',','.')."<input type='hidden' size='12' class='SinBorde' class='InputDer' name='InventarioCu' value=".number_format($ValorCobreOZ,3,',','.')."></td>";				
										}
										if('Ag'==$arreglo[$i][0])
										{
												echo "<td align='right'>".number_format($ValorPLata2,3,',','.')."</td>";		
												echo "<td align='right'>".number_format($ValorPlataOZ,3,',','.')."<input type='hidden' size='12' class='SinBorde' class='InputDer' name='InventarioAg' value=".number_format($ValorPlataOZ,3,',','.')."></td>";	
										}
										if('Au'==$arreglo[$i][0])
										{
												echo "<td align='right'>".number_format($ValorOro2,3,',','.')."</td>";				
												echo "<td align='right'>".number_format($ValorOroOZ,3,',','.')."<input type='hidden' size='12' class='SinBorde' class='InputDer' name='InventarioAu' value=".number_format($ValorOroOZ,3,',','.')."></td>";	
										}
									}
								echo "</tr>";		
					 }				
					?>
  </table>
</form>
</body>
</html>
<?
function DatosEnabalFlujos($AnoFlujo,$MesFlujo,$Contrato,$TipoFlujo,$CodFlujo,$ArrFinos,$i)
{
	$Consulta="select * from scop_contratos_flujos where cod_contrato='".$Contrato."' and  tipo_inventario='".$i."' and flujo='".$CodFlujo."'";
	$Resp=mysql_query($Consulta);
	while($Fila=mysql_fetch_array($Resp))
	{	
		if($Fila[tipo_inventario]=='1')
		{
			if($MesFlujo==1)
			{
				$AnoFlujo=$AnoFlujo-1;
				$MesFlujo=12;
			}
			else
				$MesFlujo=$MesFlujo-1;
		}
		if($Fila[tipo_inventario]=='1'||$Fila[tipo_inventario]=='4')
			$TipoMovimiento=3;
		else
			$TipoMovimiento=2;		
		$Flujo= $Fila["flujo"];
		$Consulta="select cobre,plata,oro from scop_datos_enabal where ano='".$AnoFlujo."' and cod_flujo='".$Flujo."' and origen='".$TipoFlujo."' and tipo_mov='".$TipoMovimiento."' and tipo_dato='F'";		
		$Consulta.=" and mes='".$MesFlujo."'";
		$RespValor=mysql_query($Consulta);
		while($FilaValor=mysql_fetch_array($RespValor))
		{
			$Cu=$FilaValor[cobre];
			$Ag=$FilaValor[plata];
			$Au=$FilaValor[oro];
			if($Fila["signo"]==1)
			{
				$ArrFinos[1][Cu]=$ArrFinos[1][Cu]+$Cu;
				$ArrFinos[2][Ag]=$ArrFinos[2][Ag]+$Ag;
				$ArrFinos[3][Au]=$ArrFinos[3][Au]+$Au;
			}
			else
			{
				$ArrFinos[1][Cu]=$ArrFinos[1][Cu]-$Cu;
				$ArrFinos[2][Ag]=$ArrFinos[2][Ag]-$Ag;
				$ArrFinos[3][Au]=$ArrFinos[3][Au]-$Au;
			}
		}			
	}	
}
function Convertir($Valor,$Dato)
{
	switch($Dato)
	{
		case "Cobre"://DE KG A lb
				$ValorSalida=$Valor*2.2;
		break;
		case "PLata"://de grs a OZ
		case "Oro"://de grs a OZ
				$ValorSalida=$Valor*0.032150746568628;
		break;
	}
	return($ValorSalida);
}
?>