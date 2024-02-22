<?
include("../principal/conectar_scop_web.php");
include("funciones/scop_funciones.php");
	if(!isset($Ano))
		$Ano=date('Y');	
	if(!isset($CmbMes))
		$CmbMes=date('m');	

?>
<html>
<head>
<title>Inventarios Validados</title>
<link href="../scop_web/estilos/css_scop_web.css" rel="stylesheet" type="text/css">
<form name="FrmPrincipal" method="post" action="">
  <table width="950" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
   <tr>
  <td><img src="../scop_web/archivos/images/interior/esq1em.gif" width="15" /></td>
  <td width="920" background="../scop_web/archivos/images/interior/form_arriba.gif"><img src="../scop_web/archivos/images/interior/transparent.gif" width="4" /></td>
  <td ><img src="../scop_web/archivos/images/interior/esq2em.gif" width="15" /></td>
   	</tr>
      <tr>
       <td background="../scop_web/archivos/images/interior/form_izq.gif">&nbsp;</td>
        <td align="center"><table border="1" cellpadding="0" cellspacing="0">
          <tr height="24">
            <td width="93" rowspan="2" align="center" class="TituloTablaVerdeActiva"> Tipo Producto</td>
            <td height="24" colspan="4" align="center" class="TituloTablaVerdeActiva">Stock Inicial </td>
            <td colspan="3" align="center" class="TituloTablaVerdeActiva">Finos Inventario</td>
            <td colspan="4" align="center" class="TituloTablaVerdeActiva">Recepcion</td>
            <td colspan="4" align="center" class="TituloTablaVerdeActiva">Beneficio / embarque</td>
            <td colspan="4" align="center" class="TituloTablaVerdeActiva">Stock Final </td>
			<td width="50" colspan="1" rowspan="2" align="center" class="TituloTablaVerdeActiva">Valid.</td>
          </tr>
          <tr height="24">
            <td width="48" height="24" align="center" class="TituloTablaVerdeActiva">kg</td>
            <td width="48" align="center" class="TituloTablaVerdeActiva">Cu(%)</td>
            <td width="50" align="center" class="TituloTablaVerdeActiva">Ag (gr/TM)</td>
            <td width="60" align="center" class="TituloTablaVerdeActiva">Au(gr/TM)</td>
            <td width="24" align="center" class="TituloTablaVerdeActiva">Cu (Kg)</td>
            <td width="24" align="center" class="TituloTablaVerdeActiva">Ag (grs)</td>
            <td width="24" align="center" class="TituloTablaVerdeActiva">Au (grs)</td>
            <td width="18" align="center" class="TituloTablaVerdeActiva">kg</td>
            <td width="31" align="center" class="TituloTablaVerdeActiva">Cu(%)</td>
            <td width="41" align="center" class="TituloTablaVerdeActiva">Ag (gr/TM)</td>
            <td width="56" align="center" class="TituloTablaVerdeActiva">Au(gr/TM)</td>
            <td width="28" align="center" class="TituloTablaVerdeActiva">kg</td>
            <td width="31" align="center" class="TituloTablaVerdeActiva">Cu(%)</td>
            <td width="41" align="center" class="TituloTablaVerdeActiva">Ag (gr/TM)</td>
            <td width="56" align="center" class="TituloTablaVerdeActiva">Au(gr/TM)</td>
            <td width="33" align="center" class="TituloTablaVerdeActiva">kg</td>
            <td width="31" align="center" class="TituloTablaVerdeActiva">Cu (Tm)</td>
            <td width="28" align="center" class="TituloTablaVerdeActiva">Ag (grs)</td>
            <td width="57" align="center" class="TituloTablaVerdeActiva">Au (grs)</td>
		  </tr>
		  <?
		  	$Buscar='S';
		  	if($Buscar=='S')
			{
				$ConsultaMes="select distinct mes from scop_datos_enabal where ano='".$Ano."'";
				if($Mes!='T')
					$ConsultaMes.=" and mes='".$Mes."'";
				$RespMes=mysql_query($ConsultaMes);
				if($FilaMes=mysql_fetch_array($RespMes))
				{	
					$Cont=1;
					//LOS TIPOS DE CONTRATOS ARGUPADOS 								
					$Consulta="select t2.cod_subclase as cod_tipo_contr,t1.cod_contrato,t2.nombre_subclase as nom_tipo_contr,t1.descrip_contrato from scop_contratos t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='33002' and t1.cod_tipo_contr=t2.cod_subclase ";
					$Consulta.=" inner join scop_contratos_flujos t3 on t1.cod_contrato=t3.cod_contrato where t1.cod_tipo_contr<>''";
					if($TipoContr!='T')
						$Consulta.=" and t1.cod_tipo_contr='".$TipoContr."'";
					$Consulta.=" group by t1.cod_tipo_contr ";	
					$Resp1=mysql_query($Consulta);
					while ($Fila1=mysql_fetch_array($Resp1))
					{						
						$NomTipoContrato1=$Fila1[nom_tipo_contr];
						$CodTipoContrato1=$Fila1[cod_tipo_contr];
						$CodContrato1=$Fila1["cod_contrato"];
						?>
						  <tr height="24">
							<td height="24" colspan="24" class="TituloTablaNaranja"><? echo $NomTipoContrato1;?></td>
						  </tr>				  
						<?						
						$ArrFinos=array();
						//LOS CONTRATOS PARA LOS TIPOS DE CONTRATOS
						$Consulta1="select t1.cod_contrato,t1.descrip_contrato,t1.num_contrato,t2.nombre_subclase as nom_tipo_contr,t2.cod_subclase as cod_tipo_contr from scop_contratos t1 inner join proyecto_modernizacion.sub_clase t2 on t1.cod_tipo_contr=t2.cod_subclase ";
						$Consulta1.=" inner join scop_contratos_flujos t3 on t1.cod_contrato=t3.cod_contrato where t1.cod_tipo_contr='".$CodTipoContrato1."'";
						$Consulta1.=" group by cod_contrato ";
						$Resp=mysql_query($Consulta1);$Datos=0;
						while ($Fila=mysql_fetch_array($Resp))
						{
							$Datos=1;
							$NomTipoContrato=$Fila[nom_tipo_contr];
							$CodTipoContrato=$Fila[cod_tipo_contr];
							$NumContrato=$Fila[num_contrato];
							$CodContrato=$Fila["cod_contrato"];
							$NomContrato=$Fila[descrip_contrato];
							//$Cu=$Fila[acuerdo_cu];$Ag=$Fila[acuerdo_ag];$Au=$Fila[acuerdo_au];
						  ?>			  	
							  <tr height="24">
								<td height="24" colspan="24" class="cab_tabla">								
								<? echo $NumContrato." - ".$NomContrato;?></td>
							  </tr>
						  <?
								if($Mes!='T')//MESES PARA SABER DE DONDE HASTA DONDE LLEGA LA CONSULTA POR EL RESULTADO DEL COMBO MESES.
								{
									$k=$Mes;
									$m=$Mes;
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
												  //A LA FUNCION LA CUAL ENTREGAR� LOS VALORES CONSULTADOS										
												  $ValorPeso=DatosEnabalFlujos($Ano,$j,$Contrato,$TipoFlujo,$CodFlujo,&$ArrFinos,$i);
											}
										}
											$Det=$CodContrato."~".$Ano."~".$j."~".$CodTipoContrato;
										?>
								      <tr bgcolor="#FFFFFF" class="formulario">
										<td><? echo $Meses[$j-1];?></td>
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
												if($i==1)
												{
												?>
													<td align="right" class="texto_bold"><? echo number_format($ArrFinos[$i][Cu],0,',','.');?>&nbsp;</td>
													<td align="right" class="texto_bold"><? echo number_format($ArrFinos[$i][Ag],0,',','.');?>&nbsp;</td>
													<td align="right" class="texto_bold"><? echo number_format($ArrFinos[$i][Au],0,',','.');?>&nbsp;</td>
												<?
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
										   $ConsultaEstado="select t1.ano,t1.mes,t1.cod_estado,t1.tipo_contrato,t2.nombre_subclase as nom_estado from scop_inventario t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='33000' and t1.cod_estado=t2.cod_subclase";
										   $ConsultaEstado.=" where t1.tipo_contrato='".$CodTipoContrato."' and t1.ano='".$Ano."' and t1.mes='".$j."'";		
										   $RespEstado=mysql_query($ConsultaEstado);
										   if($FilaEstado=mysql_fetch_array($RespEstado))
										   {	
												$Vuelta=$Vuelta+1;												   		
												if($FilaEstado["cod_estado"]=='1')//creado
												{
													echo "<td align='center'>&nbsp;</td>";
												}
												if($FilaEstado["cod_estado"]=='2')//validado
												{
													$Cod=$FilaEstado[tipo_contrato]."~".$Ano."~".$j;
													echo "<td align='center'><img src='archivos/acepta.png' alt='".$FilaEstado[nom_estado]."'  border='0' align='absmiddle' /></td>";
												}	
										   }	
										   else
										   {
												if($ResultadoCero<0)
													$ResultadoCero=0;
												echo "<td align='center'>".number_format($ResultadoCero,0,',','.')."<input type='hidden' name='ResultadoCero' value='".$ResultadoCero."'></td>";
												$Suma=$Suma+$ResultadoCero;
										   }	
											?> 												
									   </tr>
						<?
								 }//FOR DE MESES PARA LA CONSULTA
						 }//FIN CONTRATO
								 echo "<td align='center'><input type='hidden' name='Sumado' value='".$Suma."'></td>";
						?>
						<tr  class="glosa_tablas_blanco">
							<td colspan="24">&nbsp;</td>
						</tr>
						<?
					}//tipo de inventarios
				}//FIN BUSCAR	
			}//FIN DE CONSULTA SI EXISTE VALORES PARA EL MES CONSULTADO	
			else
				$Cont=0;
		  ?>
        </table></td>
 </td>
   <td width="10" background="../scop_web/archivos/images/interior/form_der.gif">&nbsp;</td>
   </tr>
    <tr>
      <td width="15"><img src="../scop_web/archivos/images/interior/esq3em.gif" width="15" height="15" /></td>
      <td height="1"background="../scop_web/archivos/images/interior/form_abajo.gif"><img src="../scop_web/archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15"><img src="../scop_web/archivos/images/interior/esq4em.gif" width="15" height="15" /></td>
    </tr>
  </table>	
</form>
</body>
</html>
<?
	if($Mensaje=='S')
   {
?>
	<script language="javascript">
	alert("No se pueden Eliminar el dato, existen relaciones ")
	</script>
<? }
	if($Buscar=='S'&&$Cont==0)
   {
?>
	<script language="javascript">
	alert("No Existen valores para el Mes consultado")
	</script>
<? }
	if($MEli=='S')
   {
?>
	<script language="javascript">
	alert("Validaci�n Eliminada con Exito")
	</script>
<? }

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
			$ArrFinos[$i]["peso"]=$ArrFinos[$i]["peso"]+$Peso;
			$ArrFinos[$i][Cu]=$ArrFinos[$i][Cu]+$Cu;
			$ArrFinos[$i][Ag]=$ArrFinos[$i][Ag]+$Ag;
			$ArrFinos[$i][Au]=$ArrFinos[$i][Au]+$Au;
		}			
	}
	
}
?>