<? 
header("Content-Type:  application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

include("../principal/conectar_scop_web.php");
?>
<html>
<head>
<title>Detalle por Contratos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<form name="FrmPopupProceso" method="post" action="">
  <table width="100%" border="1" cellpadding="0" cellspacing="0">
	<tr height="24">
	  <td width="8%" height="24" >A&ntilde;o/Mes</td>
	  <td width="92%" height="24" colspan="16">&nbsp;<? echo $Ano."/".$Meses[$CmbMes-1]?></td>
	</tr>
		<tr height="24">
		  <td height="24">Acuerdo Contractual</td>
		  <?
		   if($CmbAcuerdo=='-1'&&$CmbAcuerdo!='P')
				$Mes='Mes&nbsp;'.$CmbAcuerdo;
		   if($CmbAcuerdo!='-1'&&$CmbAcuerdo!='P')
				$Mes='Mes&nbsp;+'.$CmbAcuerdo;	
		   if($CmbAcuerdo=='P')
				$Mes='Precio Fijo';	
		  ?>
		  <td height="24" colspan="16">&nbsp;<? echo $Mes;?></td>
		</tr>
  </table>
  <table width="100%" border="1" cellpadding="0" cellspacing="0">
    <tr>
      <td rowspan="2" align="center" >Contratos</td>
      <td height="30" colspan="4" align="center" >Stock Inicial </td>
      <td height="20" colspan="4" align="center" >Recepcion</td>
      <td height="20" colspan="4" align="center" >Beneficio / embarque</td>
      <td height="20" colspan="4" align="center" >Stock Final </td>
    </tr>
    <tr height="24">
      <td  height="24" align="center" >kg</td>
      <td  align="center" >Cu(%)</td>
      <td  align="center" >Ag (gr/TM)</td>
      <td  align="center" >Au(gr/TM)</td>
      <td  align="center" >kg</td>
      <td  align="center" >Cu(%)</td>
      <td  align="center" >Ag (gr/TM)</td>
      <td  align="center" >Au(gr/TM)</td>
      <td  align="center" >kg</td>
      <td  align="center" >Cu(%)</td>
      <td  align="center" >Ag (gr/TM)</td>
      <td  align="center" >Au(gr/TM)</td>
      <td  align="center" >kg</td>
      <td  align="center" >Cu (Tm)</td>
      <td  align="center" >Ag (grs)</td>
      <td  align="center" >Au (grs)</td>
    </tr>
    <?
		$DatosContrato=explode("~",$Contratos);
		while(list($c,$v)=each($DatosContrato))
		{
				$ConsultaMes="select distinct mes from scop_datos_enabal where ano='".$Ano."'";
				if($CmbMes!='T')
					$ConsultaMes.=" and mes='".$CmbMes."'";
				$RespMes=mysql_query($ConsultaMes);
				if($FilaMes=mysql_fetch_array($RespMes))
				{	
					$Cont=1;
					//LOS TIPOS DE CONTRATOS ARGUPADOS 
					$ConsultaInven="select * from scop_inventario where ano='".$Ano."' and mes='".$CmbMes."' and cod_estado in ('1','2') and cod_contrato='".$v."'";					
					$RespInven=mysql_query($ConsultaInven);
					while ($FilaInven=mysql_fetch_array($RespInven))
					{						
						$Consulta="select t2.cod_subclase as cod_tipo_contr,t1.cod_contrato,t2.nombre_subclase as nom_tipo_contr,t1.descrip_contrato from scop_contratos t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='33002' and t1.cod_tipo_contr=t2.cod_subclase ";
						$Consulta.=" inner join scop_contratos_flujos t3 on t1.cod_contrato=t3.cod_contrato where t1.cod_contrato='".$FilaInven["cod_contrato"]."' and t1.vigente='1'";
						$Consulta.=" group by t1.cod_tipo_contr ";	
						$Resp1=mysql_query($Consulta);
						while ($Fila1=mysql_fetch_array($Resp1))
						{						
							$NomTipoContrato1=$Fila1[nom_tipo_contr];
							$CodTipoContrato1=$Fila1[cod_tipo_contr];
							$CodContrato1=$Fila1["cod_contrato"];

							$ArrFinos=array();
							//LOS CONTRATOS PARA LOS TIPOS DE CONTRATOS
							$Consulta1="select t1.cod_contrato,t1.descrip_contrato,t1.num_contrato,t2.nombre_subclase as nom_tipo_contr,t2.cod_subclase as cod_tipo_contr from scop_contratos t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='33002' and t1.cod_tipo_contr=t2.cod_subclase ";
							$Consulta1.=" inner join scop_contratos_flujos t3 on t1.cod_contrato=t3.cod_contrato where t1.cod_contrato='".$FilaInven["cod_contrato"]."' and t1.vigente='1'";					
							$Consulta1.=" group by cod_contrato ";
							$Resp=mysql_query($Consulta1);$Datos=0;
							while ($Fila=mysql_fetch_array($Resp))
							{
								$Datos=1;
								$NomTipoContrato=$Fila[nom_tipo_contr];
								$CodTipoContrato=$Fila[cod_tipo_contr];
								$NumContrato=$Fila["num_contrato"];
								$CodContrato=$Fila["cod_contrato"];
								$NomContrato=$Fila[descrip_contrato];
	
								//$Cu=$Fila[acuerdo_cu];$Ag=$Fila[acuerdo_ag];$Au=$Fila[acuerdo_au];
									if($CmbMes!='T')//MESES PARA SABER DE DONDE HASTA DONDE LLEGA LA CONSULTA POR EL RESULTADO DEL COMBO MESES.
									{
										$k=$CmbMes;
										$m=$CmbMes;
									}
									else
									{
										$k=1;
										//SACO EL ULTIMO MES CON DATOS EN LA TABLA
										$ConsultaMes="select distinct mes from scop_datos_enabal where ano='".$Ano."' order by mes desc";
										$RespMes=mysql_query($ConsultaMes);
										if($FilaMes=mysql_fetch_array($RespMes))
										{
											$m=$FilaMes["mes"];
										}
									}
									for($j=$k;$j<=$m;$j++)
									{								  
										   $Validacion=$Ano."~".$j."~".$CodContrato;
										   reset($ArrFinos);
										   for($i=1;$i<=4;$i++)
										   {
												$ArrFinos[$i]["peso"]='';$ArrFinos[$i][Cu]='';$ArrFinos[$i][Au]='';$ArrFinos[$i][Ag]='';
										   }						   					 
										   for($i=1;$i<=4;$i++)
										   {
												$ConsultaFlujo=" select * from scop_contratos_flujos where cod_contrato='".$CodContrato."' and tipo_inventario='".$i."'";
												$RespFlujo=mysql_query($ConsultaFlujo);
												while($FilaFlujo=mysql_fetch_array($RespFlujo))
												{
													$TipoInventario=$FilaFlujo[tipo_inventario];
													$TipoFlujo=$FilaFlujo[tipo_flujo];
													$CodFlujo=$FilaFlujo["flujo"];
													$Contrato=$FilaFlujo["cod_contrato"];
													  //A LA FUNCION LA CUAL ENTREGAR&Aacute; LOS VALORES CONSULTADOS										
													  $ValorPeso=DatosEnabalFlujos($Ano,$j,$Contrato,$TipoFlujo,$CodFlujo,&$ArrFinos,$i);
												}
											}
												$Det=$CodContrato."~".$Ano."~".$j."~".$CodTipoContrato;
											?>
											<tr bgcolor="#FFFFFF" >
												<td align="left"><? echo $NumContrato."&nbsp;-&nbsp;".$NomContrato;?>&nbsp;</td>
											  <? reset($ArrFinos);
													   for($i=1;$i<=1;$i++)
													   {
															$InventarioInicial=$ArrFinos[$i]["peso"];
															if($InventarioInicial==0)
																$InventarioInicial=0;
													   }	
													   for($i=2;$i<=2;$i++)
													   {
															$InventarioRecepcion=$ArrFinos[$i]["peso"];
															if($InventarioRecepcion==0)
																$InventarioRecepcion=0;
													   }	
													   for($i=3;$i<=3;$i++)
													   {
															$InventarioBeneficio=$ArrFinos[$i]["peso"];
															if($InventarioBeneficio==0)
																$InventarioBeneficio=0;
													   }	
													   for($i=4;$i<=4;$i++)
													   {
															$InventarioStockFinal=$ArrFinos[$i]["peso"];
															if($InventarioStockFinal==0)
																$InventarioStockFinal=0;
													   }
													   $ResultadoCero=$InventarioInicial+$InventarioRecepcion-$InventarioBeneficio-$InventarioStockFinal;
													   for($i=1;$i<=4;$i++)
													   {	
															if($i!=4)
															{	
																if($ArrFinos[$i]["peso"]>0)
																{																
															?>
																  <td align="right"><? echo number_format($ArrFinos[$i]["peso"],0,',','.');?>&nbsp;</td>
																  <td align="right"><? echo number_format(($ArrFinos[$i][Cu]/$ArrFinos[$i]["peso"])*100,2,',','.');?>&nbsp;</td>
																  <td align="right"><? echo number_format(($ArrFinos[$i][Ag]/$ArrFinos[$i]["peso"])*1000,2,',','.');?>&nbsp;</td>
																  <td align="right"><? echo number_format(($ArrFinos[$i][Au]/$ArrFinos[$i]["peso"])*1000,2,',','.');?>&nbsp;</td>
																  <?
																}
																else
																{
																	?>
																	  <td align="right">0</td>
																	  <td align="right">0</td>
																	  <td align="right">0</td>
																	  <td align="right">0</td>
																	  <?
																}
															}
															if($i==4)
															{
															?>
															  <td align="right"><? echo number_format($ArrFinos[$i]["peso"],0,',','.');?>&nbsp;</td>
															  <td align="right"><? echo number_format($ArrFinos[$i][Cu],0,',','.');?>&nbsp;</td>
															  <td align="right"><? echo number_format($ArrFinos[$i][Ag],0,',','.');?>&nbsp;</td>
															  <td align="right"><? echo number_format($ArrFinos[$i][Au],0,',','.');?>&nbsp;</td>
															  <?
															}				
													   }
													?>
													</tr>
													<?
									 }//FOR DE MESES PARA LA CONSULTA
							 }//FIN CONTRATO
							?>
							<?
						}//tipo de inventarios						
					}//FIN BUSCAR	
				}
		}
		  ?>
  </table>
</form>
</body>
</html>
<? 
	echo "<script languaje='JavaScript'>";
	if ($Mensaje==1)
		echo "alert('Envio y Validaci�n de Contrato Exitoso');";
	if ($Mensaje==2)
		echo "alert('No se puede Validar Contrato, Flujos no Asociados');";
	echo "</script>";
?>
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
		$Consulta="select peso,cobre,plata,oro from scop_datos_enabal where ano='".$AnoFlujo."' and cod_flujo='".$Flujo."' and origen='".$TipoFlujo."' and tipo_mov='".$TipoMovimiento."' and tipo_dato='F'";		
		if($MesFlujo!='T')
			$Consulta.=" and mes='".$MesFlujo."'";
		$RespValor=mysql_query($Consulta);
		while($FilaValor=mysql_fetch_array($RespValor))
		{
			$Peso=$FilaValor["peso"];
			$Cu=$FilaValor[cobre];
			$Ag=$FilaValor[plata];
			$Au=$FilaValor[oro];
			if($Fila["signo"]==1)
			{
				$ArrFinos[$i]["peso"]=$ArrFinos[$i]["peso"]+$Peso;
				$ArrFinos[$i][Cu]=$ArrFinos[$i][Cu]+$Cu;
				$ArrFinos[$i][Ag]=$ArrFinos[$i][Ag]+$Ag;
				$ArrFinos[$i][Au]=$ArrFinos[$i][Au]+$Au;
			}
			else
			{
				$ArrFinos[$i]["peso"]=$ArrFinos[$i]["peso"]-$Peso;
				$ArrFinos[$i][Cu]=$ArrFinos[$i][Cu]-$Cu;
				$ArrFinos[$i][Ag]=$ArrFinos[$i][Ag]-$Ag;
				$ArrFinos[$i][Au]=$ArrFinos[$i][Au]-$Au;
			}
		}			
	}
	
}
?>