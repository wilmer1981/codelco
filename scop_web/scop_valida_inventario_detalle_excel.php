<? include("../principal/conectar_scop_web.php");
header("Content-Type:  application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
?>
<html>
<head>
<title>Valida Inventario Detalle Excel</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<form name="FrmPopupProceso" method="post">
  <table width="1023" border="1" cellpadding="0" cellspacing="0">
     <tr>
       <td colspan="3"align="center" class="TituloTablaVerde"></td>
     </tr>
         <?
			$Datos=explode("~",$Valores);
			$Consulta="select nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='33002' and cod_subclase='".$Datos[3]."'";
			$RespTipo=mysql_query($Consulta);
			if($FilaTipo=mysql_fetch_array($RespTipo))
			{				
				 ?>
				 <tr height="24">
				   <td height="24" colspan="24" class="TituloTablaNaranja"><? echo $FilaTipo["nombre_subclase"];?><? echo "&nbsp;&nbsp;(".$Meses[$Datos[2]-1]."&nbsp;".$Datos[1].")";?></td>
				 </tr>
				 <?
			}				
		?>    
	 <tr>
       <td align="center"><table width="1023" border="1" cellpadding="0" cellspacing="0">
         <?
				$ArrFinos=array();
				$Consulta="select t1.num_contrato,t1.cod_contrato,t2.nombre_subclase as nom_tipo_contr,t1.descrip_contrato,t3.tipo_flujo,t3.tipo_inventario from scop_contratos t1";
				$Consulta.=" inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='33002' and t1.cod_tipo_contr=t2.cod_subclase ";
				$Consulta.=" inner join scop_contratos_flujos t3 on t1.cod_contrato=t3.cod_contrato where t1.cod_tipo_contr='".$Datos[3]."' and t1.vigente='1'";
				if($Datos[0]!='T')
					$Consulta.=" and t1.cod_contrato='".$Datos[0]."'";
				$Consulta.=" group by t1.cod_contrato ";
				//echo $Consulta."<br>";
				$Resp=mysql_query($Consulta);
				while ($Fila=mysql_fetch_array($Resp))
				{
					$NomTipoContrato=$Fila[nom_tipo_contr];
					$CodContrato=$Fila["cod_contrato"];
					$NomContrato=$Fila[descrip_contrato];
					$NumContrato=$Fila["num_contrato"];
					$TipoFlujo=$Fila[tipo_flujo];
				  ?>
         <tr height="24">
           <td height="24" colspan="24" class="cab_tabla"><? echo $NumContrato." - ".$NomContrato;?></td>
         </tr>
         <?
							$Consulta="select tipo_flujo,tipo_inventario from scop_contratos_flujos where cod_contrato='".$CodContrato."' group by tipo_inventario";
							$Resp=mysql_query($Consulta);
							while($Fila=mysql_fetch_array($Resp))
							{
								$TipoFlujo2=$Fila[tipo_flujo];
								$TipoInventario=$Fila[tipo_inventario];
								if($TipoInventario=='1'||$TipoInventario=='4')
									$TipoMov='3';	
								else
									$TipoMov='2';	
								$ConsultaExiste=" select t1.tipo_inventario,t1.flujo,t1.tipo_flujo from scop_contratos_flujos t1 inner join scop_datos_enabal t2";
								$ConsultaExiste.=" on t1.flujo=t2.cod_flujo and t1.tipo_flujo=t2.origen where t1.cod_contrato='".$CodContrato."' and t1.tipo_inventario='".$TipoInventario."'  and t2.ano='".$Datos[1]."' and t2.mes='".$Datos[2]."' and tipo_mov='".$TipoMov."'";
								//echo "1:    ".$ConsultaExiste."<br>";
								$RespE=mysql_query($ConsultaExiste);
								if($FilaE=mysql_fetch_array($RespE))
								{																		
									$TipInv=$FilaE[tipo_inventario];
									if($TipInv=='1')	
									{
										?>
         <tr height="24">
           <td width="167" rowspan="2" align="center" class="TituloTablaVerdeActiva"> Flujos</td>
           <td height="24" colspan="4" align="center" class="TituloTablaVerdeActiva">Stock Inicial </td>
           <td colspan="3" align="center" class="TituloTablaVerdeActiva">Finos Inventario</td>
         </tr>
         <tr height="24">
           <td width="59"  align="center" class="TituloTablaVerdeActiva">kg</td>
           <td width="31" align="center" class="TituloTablaVerdeActiva">Cu(%)</td>
           <td width="41" align="center" class="TituloTablaVerdeActiva">Ag (gr/TM)</td>
           <td width="56" align="center" class="TituloTablaVerdeActiva">Au(gr/TM)</td>
           <td width="29" align="center" class="TituloTablaVerdeActiva">Cu (Kg)</td>
           <td width="27" align="center" class="TituloTablaVerdeActiva">Ag (grs)</td>
           <td width="38" align="center" class="TituloTablaVerdeActiva">Au (grs)</td>
         </tr>
         <?														
									}			
									if($TipInv=='2')	
									{
										?>
         <tr height="24">
           <td width="167" rowspan="2" align="center" class="TituloTablaVerdeActiva"> Flujos</td>
           <td colspan="4" align="center" class="TituloTablaVerdeActiva">Recepcion</td>
         </tr>
         <tr height="24">
           <td width="47" align="center" class="TituloTablaVerdeActiva">kg</td>
           <td width="33" align="center" class="TituloTablaVerdeActiva">Cu(%)</td>
           <td width="41" align="center" class="TituloTablaVerdeActiva">Ag (gr/TM)</td>
           <td width="56" align="center" class="TituloTablaVerdeActiva">Au(gr/TM)</td>
         </tr>
         <?
									}
									if($TipInv=='3')	
									{
										?>
         <tr height="24">
           <td width="167" rowspan="2" align="center" class="TituloTablaVerdeActiva"> Flujos</td>
           <td colspan="4" align="center" class="TituloTablaVerdeActiva">Beneficio / embarque</td>
         </tr>
         <tr height="24">
           <td width="30" align="center" class="TituloTablaVerdeActiva">kg</td>
           <td width="34" align="center" class="TituloTablaVerdeActiva">Cu(%)</td>
           <td width="54" align="center" class="TituloTablaVerdeActiva">Ag (gr/TM)</td>
           <td width="56" align="center" class="TituloTablaVerdeActiva">Au(gr/TM)</td>
         </tr>
         <?
									}
									if($TipInv=='4')	
									{
										?>
         <tr height="24">
           <td width="167" rowspan="2" align="center" class="TituloTablaVerdeActiva"> Flujos</td>
           <td colspan="4" align="center" class="TituloTablaVerdeActiva">Stock Final</td>
         </tr>
         <tr height="24">
           <td width="46" align="center" class="TituloTablaVerdeActiva">kg</td>
           <td width="25" align="center" class="TituloTablaVerdeActiva">Cu (Kg)</td>
           <td width="32" align="center" class="TituloTablaVerdeActiva">Ag (grs)</td>
           <td width="33" align="center" class="TituloTablaVerdeActiva">Au (grs)</td>
         </tr>
         <?
									}
									$ConsultaFlujo=" select t1.cod_contrato,t1.tipo_inventario,t1.flujo,t2.nom_flujo,t1.signo,t1.tipo_flujo from scop_contratos_flujos t1 inner join scop_datos_enabal t2";
									$ConsultaFlujo.=" on t1.flujo=t2.cod_flujo and t1.tipo_flujo=t2.origen where t1.cod_contrato='".$CodContrato."' and t1.tipo_inventario='".$TipoInventario."'  and t2.ano='".$Datos[1]."' and t2.mes='".$Datos[2]."' and tipo_mov='".$TipoMov."'";
									 //echo  "flujos::      ".$ConsultaFlujo."<br><br>";
									$RespFlujo=mysql_query($ConsultaFlujo);$TotCu=0;$TotAg=0;$TotAu=0;$Peso=0;$CalCu=0;$CalAg=0;$CalAu=0;$TotalPeso=0;$TotalCu=0;$TotalAg=0;$TotalAu=0;
									while($FilaFlujo=mysql_fetch_array($RespFlujo))
									{
										$TipoInventario1=$FilaFlujo[tipo_inventario];
										$CodFlujo=$FilaFlujo["flujo"];
										$NomFlujo=$FilaFlujo[nom_flujo];
										  //SUMA DE LOS MESES CONTRACTUALES A LOS CUALES DEBERA IR A BUSCAR EL VALOR CADA FLUJO.	
											$ValorPesoIni=DatosEnabalFlujos($Datos[1],$Datos[2],$FilaFlujo["cod_contrato"],$FilaFlujo[tipo_flujo],$CodFlujo,&$ArrFinos,$TipoInventario);
										  if($TipoInventario1=='1')	
										  {
										  	$CalCu=0;$CalAg=0;$CalAu=0;
											$Peso=$ArrFinos[1]["peso"];$CuIni=$ArrFinos[1][Cu];$AgIni=$ArrFinos[1][Ag];$AuIni=$ArrFinos[1][Au];											
											if($Peso>0)
											{
												$CalCu=$CuIni/$Peso*100;$CalAg=$AgIni/$Peso*1000;$CalAu=$AuIni/$Peso*1000;
												$TotalPeso=$TotalPeso+$Peso;
												$TotalCu=$TotalCu+$CuIni;
												$TotalAg=$TotalAg+$AgIni;
												$TotalAu=$TotalAu+$AuIni;
												$TotCu=$TotalCu/$TotalPeso*100;
												$TotAg=$TotalAg/$TotalPeso*1000;
												$TotAu=$TotalAu/$TotalPeso*1000;
											}
										  ?>
         <tr>
           <td><? echo str_pad($CodFlujo,2,'0',STR_PAD_LEFT)."-".$NomFlujo;?></td>
           <td  align="right"><? echo number_format($Peso,0,',','.');?></td>
           <td  align="right"><? echo number_format($CalCu,2,',','.');?></td>
           <td  align="right"><? echo number_format($CalAg,2,',','.');?></td>
           <td  align="right"><? echo number_format($CalAu,2,',','.');?></td>
           <td  align="right"><? echo number_format($ArrFinos[1][Cu],2,',','.');?></td>
           <td  align="right"><? echo number_format($ArrFinos[1][Ag],2,',','.');?></td>
           <td  align="right"><? echo number_format($ArrFinos[1][Au],2,',','.');?></td>
         </tr>
         <?
										  }	
										  if($TipoInventario1=='2')
										  {
											$Peso=$ArrFinos[2]["peso"];$CuIni=$ArrFinos[2][Cu];$AgIni=$ArrFinos[2][Ag];$AuIni=$ArrFinos[2][Au];	
											
											if($Peso>0)
											{
												$CalCu=$CuIni/$Peso*100;$CalAg=$AgIni/$Peso*1000;$CalAu=$AuIni/$Peso*1000;
												$ValCu=$Peso*$CalCu/100;$ValAg=$Peso*$CalAg/1000;$ValAu=$Peso*$CalAu/1000;
												$ValSumaCu=$ValSumaCu+$ValCu;
												$ValSumaAg=$ValSumaAg+$ValAg;
												$ValSumaAu=$ValSumaAu+$ValAu;
												$TotalPeso=$TotalPeso+$Peso;
												$TotCu2=$ValSumaCu*100/$TotalPeso;
												$TotAg2=$ValSumaAg*1000/$TotalPeso;
												$TotAu2=$ValSumaAu*1000/$TotalPeso;
											}
										  ?>
         <tr>
           <td><? echo $CodFlujo."-".$NomFlujo;?></td>
           <td  align="right"><? echo number_format($Peso,0,',','.');?></td>
           <td align="right"><? echo number_format($CalCu,2,',','.');?></td>
           <td  align="right"><? echo number_format($CalAg,2,',','.');?></td>
           <td  align="right"><? echo number_format($CalAu,2,',','.');?></td>
         </tr>
         <?
										  }
										  if($TipoInventario1=='3')
										  {
											$Peso=$ArrFinos[3]["peso"];$CuIni=$ArrFinos[3][Cu];$AgIni=$ArrFinos[3][Ag];$AuIni=$ArrFinos[3][Au];	
											if($Peso>0)
											{
												$CalCu=$CuIni/$Peso*100;$CalAg=$AgIni/$Peso*1000;$CalAu=$AuIni/$Peso*1000;
												$ValCu3=$Peso*$CalCu/100;$ValAg3=$Peso*$CalAg/1000;$ValAu3=$Peso*$CalAu/1000;
												$ValSumaCu3=$ValSumaCu3+$ValCu3;
												$ValSumaAg3=$ValSumaAg3+$ValAg3;
												$ValSumaAu3=$ValSumaAu3+$ValAu3;
												$TotalPeso=$TotalPeso+$Peso;
												$TotCu3=$ValSumaCu3*100/$TotalPeso;
												$TotAg3=$ValSumaAg3*1000/$TotalPeso;
												$TotAu3=$ValSumaAu3*1000/$TotalPeso;
											}
										  ?>
         <tr>
           <td><? echo $CodFlujo."-".$NomFlujo;?></td>
           <td  align="right"><? echo number_format($Peso,0,',','.');?></td>
           <td  align="right"><? echo number_format($CalCu,2,',','.');?></td>
           <td  align="right"><? echo number_format($CalAg,2,',','.');?></td>
           <td  align="right"><? echo number_format($CalAu,2,',','.');?></td>
         </tr>
         <?
										  }
										  if($TipoInventario1=='4')
										  {
											$Peso=$ArrFinos[4]["peso"];$CuFin=$ArrFinos[4][Cu];$AgFin=$ArrFinos[4][Ag];$AuFin=$ArrFinos[4][Au];	
											if($Peso>0)
											{
												$CalCuFin=$CuFin/$Peso*100;$CalAgFin=$AgFin/$Peso*1000;$CalAuFin=$AuFin/$Peso*1000;
												$TotalPeso=$TotalPeso+$Peso;
												$TotCu=$TotCu+$CuFin;
												$TotAg=$TotAg+$AgFin;
												$TotAu=$TotAu+$AuFin;
											}
										  ?>
         <tr>
           <td><? echo $CodFlujo."-".$NomFlujo;?></td>
           <td align="right"><? echo number_format($Peso,0,',','.');?></td>
           <td align="right"><? echo number_format($CuFin,2,',','.');?></td>
           <td align="right"><? echo number_format($AgFin,2,',','.');?></td>
           <td align="right"><? echo number_format($AuFin,2,',','.');?></td>
         </tr>
         <?
										  }
									}
									$Det=$CodContrato."~".$Datos[1]."~".$j;								
									if($TipoInventario=='1')
									{
									?>
         <tr height="24" class="FilaAbeja">
           <td  align="center" >Totales</td>
           <td  align="right"><? echo number_format($TotalPeso,0,',','.');?></td>
           <td  align="right"><? echo number_format($TotCu,2,',','.');?></td>
           <td  align="right"><? echo number_format($TotAg,2,',','.');?></td>
           <td  align="right"><? echo number_format($TotAu,2,',','.');?></td>
           <td  align="right"><? echo number_format($TotalCu,0,',','.');?></td>
           <td  align="right"><? echo number_format($TotalAg,0,',','.');?></td>
           <td  align="right"><? echo number_format($TotalAu,0,',','.');?></td>
         </tr>
         <?
									}
									if($TipoInventario=='2')
									{
									?>
         <tr height="24" class="FilaAbeja">
           <td  align="center" >Totales</td>
           <td  align="right"><? echo number_format($TotalPeso,0,',','.');?></td>
           <td  align="right"><? echo number_format($TotCu2,2,',','.');?></td>
           <td  align="right"><? echo number_format($TotAg2,2,',','.');?></td>
           <td  align="right"><? echo number_format($TotAu2,2,',','.');?></td>
         </tr>
         <?
									}
									if($TipoInventario=='3')
									{
									?>
         <tr height="24" class="FilaAbeja">
           <td align="center" >Totales</td>
           <td  align="right"><? echo number_format($TotalPeso,0,',','.');?></td>
           <td  align="right"><? echo number_format($TotCu3,2,',','.');?></td>
           <td  align="right"><? echo number_format($TotAg3,2,',','.');?></td>
           <td  align="right"><? echo number_format($TotAu3,2,',','.');?></td>
         </tr>
         <?
									}
									if($TipoInventario=='4')
									{
									?>
         <tr height="24" class="FilaAbeja">
           <td  align="center" >Totales</td>
           <td   align="right"><? echo number_format($TotalPeso,0,',','.');?></td>
           <td   align="right"><? echo number_format($TotCu,2,',','.');?></td>
           <td   align="right"><? echo number_format($TotAg,2,',','.');?></td>
           <td  align="right"><? echo number_format($TotAu,2,',','.');?></td>
         </tr>
         <?
									}
								}	
							}	
				 }//FIN CONTRATO
		  ?>
       </table>
       </form>
</body>
</html>
<? 
	echo "<script languaje='JavaScript'>";
	if ($Mensaje==true)
		echo "alert('Este Registro ya Existe');";
	if ($Mensaje1==true)
		echo "alert('Contrato Ingresado Exitosamente');";
	if ($Mensaje2==true)
		echo "alert('Contrato Modificado Exitosamente');";
	echo "</script>";
?>
<?
function DatosEnabalFlujos($AnoFlujo,$MesFlujo,$CodContrato,$TipoFlujo,$CodFlujo,$ArrFinos,$i)
{
	$Consulta="select * from scop_contratos_flujos where cod_contrato='".$CodContrato."' and tipo_inventario='".$i."' and flujo='".$CodFlujo."'";
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
		$Consulta="select peso,cobre,plata,oro from scop_datos_enabal where ano='".$AnoFlujo."' and cod_flujo='".$Flujo."' and origen='".$TipoFlujo."' and tipo_mov='".$TipoMovimiento."'";		
		if($MesFlujo!='T')
			$Consulta.=" and mes='".$MesFlujo."'";
		$RespValor=mysql_query($Consulta);$Peso=0;$Cu=0;$Ag=0;$Au=0;
		if($FilaValor=mysql_fetch_array($RespValor))
		{
			$Peso=$FilaValor["peso"];
			$Cu=$FilaValor[cobre];
			$Ag=$FilaValor[plata];
			$Au=$FilaValor[oro];
			$ArrFinos[$i]["peso"]=$Peso;
			$ArrFinos[$i][Cu]=$Cu;
			$ArrFinos[$i][Ag]=$Ag;
			$ArrFinos[$i][Au]=$Au;
		}			
	}	
}
?>