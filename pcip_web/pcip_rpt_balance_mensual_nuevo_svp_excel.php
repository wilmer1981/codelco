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
				$Consulta = "select * from pcip_svp_balance_mensual t1";			
				$Consulta.=" left join pcip_svp_ordenesproduccion t2 on t1.orden=t2.OPorden where orden<>''";
				if($CmbProducto!='-1')
					$Consulta.= " and t1.cod_producto='".$CmbProducto."'";	
				if($CmbNegocio!='-1')
					$Consulta.= " and t1.cod_negocio='".$CmbNegocio."'";
				if($CmbTitulo!='T')
					$Consulta.= " and t1.cod_titulo='".$CmbTitulo."'";
				$Consulta.= "  order by orden ";		
				$RespBal=mysql_query($Consulta);
				while ($FilaBal=mysql_fetch_array($RespBal))
				{
					echo "<tr>";
						echo "<td align='center' colspan='3' >F".$FilaBal[orden]."&nbsp;".$FilaBal[OPdescripcion]."</td>";
					echo "</tr>";
					//CONSULTA TIPOS INICIALES NOMBRES SUBCLASE
					$ConsultaInv=" select * from proyecto_modernizacion.sub_clase where cod_clase='31058'";
					$RespInv=mysql_query($ConsultaInv);
					while($FilaInv=mysql_fetch_array($RespInv))
					{
						echo "<tr>";
							if($FilaInv["cod_subclase"]==1)
							{
								echo "<td align='left'>".$FilaInv["nombre_subclase"]."</td>";
								echo "<td align='center'>Unidad [TMF]</td>";
								echo "<td align='center'>Costo [US$]</td>";
							}
							else
								echo "<td align='left' colspan='3'>".$FilaInv["nombre_subclase"]."</td>";
						echo "</tr>";
						$VPTM=explode(",",$FilaInv["valor_subclase1"]);
						while(list($c,$v)=each($VPTM))
						{
							if($v==1)//Vptm 1 que extraera los valores de los VPTM 25 de mes pasado
							{
								$ConsultaVptm=" select* from proyecto_modernizacion.sub_clase where cod_clase='31059' and valor_subclase1='".$v."'";
								$RespVptm=mysql_query($ConsultaVptm);
								if($FilaVptm=mysql_fetch_array($RespVptm))
								{	
									$NomVPTM=$FilaVptm["nombre_subclase"];
									echo "<tr>";
										echo "<td align='left' colspan='3'>&nbsp;&nbsp;".$NomVPTM."</td>";										
									echo "</tr>";
									$MesMenos=$Mes-1;
									$Consulta2=" select * from pcip_svp_valorizacproduccion t1 ";
									$Consulta2.=" left join pcip_svp_tiposinventarios t3 on t1.VPtipinv=t3.TIcodigo";
									$Consulta2.=" where VPorden='".$FilaBal[orden]."' and VPa�o='".$Ano."' and VPmes='".$MesMenos."' and VPtm='25' ";
									$Resp2=mysql_query($Consulta2);
									while($Fila2=mysql_fetch_array($Resp2))
									{	
									//CONSULTA VPTM NOMBRES SUBCLASE
										echo "<tr>";
											echo "<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;".$Fila2[TIdescripcion]."</td>";										
											echo "<td align='right'>".$Fila2[VPcantidad]."</td>";
											echo "<td align='right'>".$Fila2[VPvalor]."</td>";										
										echo "</tr>";
										$ArrCantidad[0]=$ArrCantidad[0]+$Fila2[VPcantidad];
										$ArrValor[0]=$ArrValor[0]+$Fila2[VPvalor];
									}
								}	
							}
							if($v==4||$v==5)//Tratado o Ajuste VPTM sin Material o Tipo inventario
							{
								$Consulta2=" select * from pcip_svp_valorizacproduccion t1 ";
								$Consulta2.=" where VPorden='".$FilaBal[orden]."' and VPa�o='".$Ano."' and VPmes='".$Mes."' and VPtm='".$v."'";
								//echo $Consulta2."<br>";
								$Resp2=mysql_query($Consulta2);
								while($Fila2=mysql_fetch_array($Resp2))
								{	
									//CONSULTA VPTM NOMBRES SUBCLASE
									$ConsultaVptm=" select * from proyecto_modernizacion.sub_clase where cod_clase='31059' and valor_subclase1='".$v."'";
									$RespVptm=mysql_query($ConsultaVptm);
									if($FilaVptm=mysql_fetch_array($RespVptm))
									{	
										$NomVPTM=$FilaVptm["nombre_subclase"];
										echo "<tr>";
											echo "<td align='left'>&nbsp;&nbsp;".$NomVPTM."</td>";										
											echo "<td align='right'>".$Fila2[VPcantidad]."</td>";
											echo "<td align='right'>".$Fila2[VPvalor]."</td>";										
										echo "</tr>";
										$ArrCantidad[0]=$ArrCantidad[0]+$Fila2[VPcantidad];
										$ArrValor[0]=$ArrValor[0]+$Fila2[VPvalor];
									}
								}	
							}
							if($FilaInv["cod_subclase"]=='2')//recibidos
							{
								if($v==6)//ordenes anteriores
								{
									$NomVPTM="Ordenes Anteriores";
									echo "<tr>";
										echo "<td align='left' colspan='3'>&nbsp;&nbsp;".$NomVPTM."</td>";										
									echo "</tr>";
									$Consulta2=" select * from pcip_svp_valorizacproduccion t1 ";
									$Consulta2.=" left join pcip_svp_materiales t2 on t1.VPmaterial=t2.MAcodigo";
									$Consulta2.=" left join pcip_svp_ordenesproduccion t3 on t1.VPorden=t3.OPorden";
									$Consulta2.=" where VPordenrel='".$FilaBal[orden]."' and VPa�o='".$Ano."' and VPmes='".$Mes."' and VPtm='11'";
									//echo $Consulta2."<br>";
									$Resp2=mysql_query($Consulta2);
									while($Fila2=mysql_fetch_array($Resp2))
									{	
										echo "<tr>";
											echo "<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;".$Fila2[VPorden]."&nbsp;".$Fila2[OPdescripcion]."&nbsp;&nbsp;&nbsp;   Material:  ".$Fila2[MAdescripcion]."</td>";										
											echo "<td align='right'>".$Fila2[VPcantidad]."</td>";
											echo "<td align='right'>".$Fila2[VPvalor]."</td>";										
										echo "</tr>";
										$ArrCantidad[0]=$ArrCantidad[0]+$Fila2[VPcantidad];
										$ArrValor[0]=$ArrValor[0]+$Fila2[VPvalor];
									}	
								}
								if($v==12)//ajuste ordenes anteriores
								{
									$NomVPTM="Ajuste Ordenes Anteriores";
									echo "<tr>";
										echo "<td align='left' colspan='3'>&nbsp;&nbsp;".$NomVPTM."</td>";										
									echo "</tr>";
									$Consulta2=" select * from pcip_svp_valorizacproduccion t1 ";
									$Consulta2.=" left join pcip_svp_materiales t2 on t1.VPmaterial=t2.MAcodigo";
									$Consulta2.=" left join pcip_svp_ordenesproduccion t3 on t1.VPorden=t3.OPorden";
									$Consulta2.=" where VPordenrel='".$FilaBal[orden]."' and VPa�o='".$Ano."' and VPmes='".$Mes."' and VPtm='12'";
									//echo $Consulta2."<br>";
									$Resp2=mysql_query($Consulta2);
									while($Fila2=mysql_fetch_array($Resp2))
									{	
										echo "<tr>";
											echo "<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;".$Fila2[VPorden]."&nbsp;".$Fila2[OPdescripcion]."&nbsp;&nbsp;&nbsp;   Material:  ".$Fila2[MAdescripcion]."</td>";										
											echo "<td align='right'>".$Fila2[VPcantidad]."</td>";
											echo "<td align='right'>".$Fila2[VPvalor]."</td>";										
										echo "</tr>";
										$ArrCantidad[0]=$ArrCantidad[0]+$Fila2[VPcantidad];
										$ArrValor[0]=$ArrValor[0]+$Fila2[VPvalor];
									}	
								}
								if($v==8||$v==9)//Recirculados con y sin ajuste
								{
									if($v==8)												
										$NomVPTM="Recirculados";
									else
										$NomVPTM="Recirculados Ajuste";
									echo "<tr>";
										echo "<td align='left' colspan='3'>&nbsp;&nbsp;".$NomVPTM."</td>";										
									echo "</tr>";
									$Consulta2=" select * from pcip_svp_valorizacproduccion t1 ";
									$Consulta2.=" left join pcip_svp_materiales t2 on t1.VPmaterial=t2.MAcodigo";
									$Consulta2.=" left join pcip_svp_ordenesproduccion t3 on t1.VPordenrel=t3.OPorden";
									$Consulta2.=" where VPorden='".$FilaBal[orden]."' and VPa�o='".$Ano."' and VPmes='".$Mes."' and VPtm='".$v."'";
									//echo $Consulta2."<br>";
									$Resp2=mysql_query($Consulta2);
									while($Fila2=mysql_fetch_array($Resp2))
									{	
										echo "<tr>";
											echo "<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;".$Fila2[VPordenrel]."&nbsp;".$Fila2[OPdescripcion]."&nbsp;&nbsp;&nbsp;   Material:  ".$Fila2[MAdescripcion]."</td>";										
											echo "<td align='right'>".$Fila2[VPcantidad]."</td>";
											echo "<td align='right'>".$Fila2[VPvalor]."</td>";										
										echo "</tr>";
										$ArrCantidad[0]=$ArrCantidad[0]+$Fila2[VPcantidad];
										$ArrValor[0]=$ArrValor[0]+$Fila2[VPvalor];
									}	
								}
							}
							if($v==13||$v==14)//Recirculados
							{
								if($v==13)	
								{
									$v=8;											
									$NomVPTM="Recirculados";
								}
								else
								{
									$v=9;
									$NomVPTM="Recirculados Ajuste";
								}
								echo "<tr>";
									echo "<td align='left' colspan='3'>&nbsp;&nbsp;".$NomVPTM."</td>";										
								echo "</tr>";
								$Consulta2=" select * from pcip_svp_valorizacproduccion t1 ";
								$Consulta2.=" left join pcip_svp_materiales t2 on t1.VPmaterial=t2.MAcodigo";
								$Consulta2.=" left join pcip_svp_ordenesproduccion t3 on t1.VPorden=t3.OPorden";
								$Consulta2.=" where VPordenrel='".$FilaBal[orden]."' and VPa�o='".$Ano."' and VPmes='".$Mes."' and VPtm='".$v."'";
								//echo $Consulta2."<br>";
								$Resp2=mysql_query($Consulta2);
								if($Fila2=mysql_fetch_array($Resp2))
								{	
									echo "<tr>";
										echo "<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;".$Fila2[VPorden]."&nbsp;".$Fila2[OPdescripcion]."&nbsp;&nbsp;&nbsp;   Material:  ".$Fila2[MAdescripcion]."</td>";										
										echo "<td align='right'>".$Fila2[VPcantidad]."</td>";
										echo "<td align='right'>".$Fila2[VPvalor]."</td>";										
									echo "</tr>";
									$ArrCantidad[0]=$ArrCantidad[0]+$Fila2[VPcantidad];
									$ArrValor[0]=$ArrValor[0]+$Fila2[VPvalor];
								}	
							}
							if($v==11||$v==12)//VPTM 
							{
								if($v==11)												
									$NomVPTM="A Ordenes Siguientes";
								else
									$NomVPTM="A Ordenes Siguientes Ajuste";	
								echo "<tr>";
									echo "<td align='left' colspan='3'>&nbsp;&nbsp;".$NomVPTM."</td>";										
								echo "</tr>";
								$Consulta2=" select * from pcip_svp_valorizacproduccion t1 ";
								$Consulta2.=" left join pcip_svp_materiales t2 on t1.VPmaterial=t2.MAcodigo";
								$Consulta2.=" left join pcip_svp_ordenesproduccion t3 on t1.VPordenrel=t3.OPorden";
								$Consulta2.=" where VPorden='".$FilaBal[orden]."' and VPa�o='".$Ano."' and VPmes='".$Mes."' and VPtm='".$v."'";
								//echo $Consulta2."<br>";
								$Resp2=mysql_query($Consulta2);
								while($Fila2=mysql_fetch_array($Resp2))
								{	
									echo "<tr>";
										echo "<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;".$Fila2[VPordenrel]."&nbsp;".$Fila2[OPdescripcion]."&nbsp;&nbsp;&nbsp;   Material:  ".$Fila2[MAdescripcion]."</td>";										
										echo "<td align='right'>".$Fila2[VPcantidad]."</td>";
										echo "<td align='right'>".$Fila2[VPvalor]."</td>";										
									echo "</tr>";
									$ArrCantidad[0]=$ArrCantidad[0]+$Fila2[VPcantidad];
									$ArrValor[0]=$ArrValor[0]+$Fila2[VPvalor];
								}	
							}
							if($v==21||$v==22)//VPTM 8 y sus materiales
							{
								if($v==21)												
									$NomVPTM="Consumo Interno";
								else
								   	$NomVPTM="Consumo Interno Ajuste";
								echo "<tr>";
									echo "<td align='left' colspan='3'>&nbsp;&nbsp;".$NomVPTM."</td>";										
								echo "</tr>";
								$Consulta2=" select * from pcip_svp_valorizacproduccion t1 ";
								$Consulta2.=" left join pcip_svp_ordenesdestino t3 on t1.VPordes=t3.ODorden";
								$Consulta2.=" where VPorden='".$FilaBal[orden]."' and VPa�o='".$Ano."' and VPmes='".$Mes."' and VPtm='".$v."'";
								//echo $Consulta2."<br>";
								$Resp2=mysql_query($Consulta2);
								while($Fila2=mysql_fetch_array($Resp2))
								{	
									echo "<tr>";
										echo "<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;".$Fila2[ODorden]."&nbsp;".ucfirst($Fila2[ODdescripcion])."&nbsp;</td>";										
										echo "<td align='right'>".$Fila2[VPcantidad]."</td>";
										echo "<td align='right'>".$Fila2[VPvalor]."</td>";										
									echo "</tr>";
									$ArrCantidad[0]=$ArrCantidad[0]+$Fila2[VPcantidad];
									$ArrValor[0]=$ArrValor[0]+$Fila2[VPvalor];
								}	
							}
							if($v==24)//24 vptm.
							{
								$Consulta2=" select * from pcip_svp_valorizacproduccion t1 ";
								$Consulta2.=" where VPorden='".$FilaBal[orden]."' and VPa�o='".$Ano."' and VPmes='".$Mes."' and VPtm='".$v."'";
								$Resp2=mysql_query($Consulta2);
								if($Fila2=mysql_fetch_array($Resp2))
								{	
									//CONSULTA VPTM NOMBRES SUBCLASE
									$ConsultaVptm=" select * from proyecto_modernizacion.sub_clase where cod_clase='31059' and valor_subclase1='".$v."'";
									$RespVptm=mysql_query($ConsultaVptm);
									if($FilaVptm=mysql_fetch_array($RespVptm))
									{	
										echo "<tr>";
											echo "<td align='left'>&nbsp;&nbsp;P�rdidas</td>";										
											echo "<td align='right'>".$Fila2[VPcantidad]."</td>";
											echo "<td align='right'>".$Fila2[VPvalor]."</td>";										
										echo "</tr>";
										$ArrCantidad[0]=$ArrCantidad[0]+$Fila2[VPcantidad];
										$ArrValor[0]=$ArrValor[0]+$Fila2[VPvalor];
									}
								}	
							}
							if($v==15||$v==16)//15 16.
							{
								$ConsultaVptm=" select * from proyecto_modernizacion.sub_clase where cod_clase='31059' and valor_subclase1='".$v."'";
								$RespVptm=mysql_query($ConsultaVptm);
								if($FilaVptm=mysql_fetch_array($RespVptm))
								{
									echo "<tr>";
										echo "<td align='left' colspan='3'>&nbsp;&nbsp;".$FilaVptm["nombre_subclase"]."</td>";										
									echo "</tr>";
									$Consulta2=" select * from pcip_svp_valorizacproduccion t1 ";
									$Consulta2.=" where VPorden='".$FilaBal[orden]."' and VPa�o='".$Ano."' and VPmes='".$Mes."' and VPtm='".$v."'";
									$Resp2=mysql_query($Consulta2);
									while($Fila2=mysql_fetch_array($Resp2))
									{	
									//CONSULTA VPTM NOMBRES SUBCLASE
										echo "<tr>";
											echo "<td align='left'>&nbsp;&nbsp;Perdidos</td>";										
											echo "<td align='right'>".$Fila2[VPcantidad]."</td>";
											echo "<td align='right'>".$Fila2[VPvalor]."</td>";										
										echo "</tr>";
										$ArrCantidad[0]=$ArrCantidad[0]+$Fila2[VPcantidad];
										$ArrValor[0]=$ArrValor[0]+$Fila2[VPvalor];
									}
								}	
							}
							if($v==25)//Vptm ! que extraera los valores de los VPTM 25 de mes pasado
							{
								$ConsultaVptm=" select* from proyecto_modernizacion.sub_clase where cod_clase='31059' and valor_subclase1='".$v."'";
								$RespVptm=mysql_query($ConsultaVptm);
								if($FilaVptm=mysql_fetch_array($RespVptm))
								{	
									$NomVPTM=$FilaVptm["nombre_subclase"];
									echo "<tr>";
										echo "<td align='left' colspan='3'>&nbsp;&nbsp;".$NomVPTM."</td>";										
									echo "</tr>";
									
									$MesMenos=$Mes-1;
									$Consulta2=" select * from pcip_svp_valorizacproduccion t1 ";
									$Consulta2.=" left join pcip_svp_tiposinventarios t3 on t1.VPtipinv=t3.TIcodigo";
									$Consulta2.=" where VPorden='".$FilaBal[orden]."' and VPa�o='".$Ano."' and VPmes='".$Mes."' and VPtm='".$v."' ";
									$Resp2=mysql_query($Consulta2);
									while($Fila2=mysql_fetch_array($Resp2))
									{	
									//CONSULTA VPTM NOMBRES SUBCLASE
										echo "<tr>";
											echo "<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;".$Fila2[TIdescripcion]."</td>";										
											echo "<td align='right'>".$Fila2[VPcantidad]."</td>";
											echo "<td align='right'>".$Fila2[VPvalor]."</td>";										
										echo "</tr>";									
										$ArrCantidad[0]=$ArrCantidad[0]+$Fila2[VPcantidad];
										$ArrValor[0]=$ArrValor[0]+$Fila2[VPvalor];
									}
								}	
							}
						}
						$TotalCantidad=$ArrCantidad[0];
						$TotalValor=$ArrValor[0];
						echo "<tr>";//total
							echo "<td align='left'>Totales&nbsp;".$FilaInv["nombre_subclase"]."</td>";										
							echo "<td align='right'>".number_format($TotalCantidad,2,',','.')."</td>";
							echo "<td align='right'>".number_format($TotalValor,2,',','.')."</td>";										
						echo "</tr>";	
						$ArrCantidad[0]=0;
						$ArrValor[0]=0;								
					}				
				}
			}
		  ?>
  </table>
</form>
</body>
</html>