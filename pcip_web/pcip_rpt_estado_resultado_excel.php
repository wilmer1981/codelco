<?
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");	

	include("../principal/conectar_pcip_web.php");
	include("funciones/pcip_funciones.php");
	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

if(!isset($Ano))
 	$Ano=date('Y');
if(!isset($Mes))
 	$Mes=date('m');
if(!isset($AnoFin))
 	$AnoFin=date('Y');
if(!isset($MesFin))
 	$MesFin=date('m');

?>
<html>
<head>
<title>Reporte Estado Resultado Excel</title>
<style type="text/css">
<!--
body {
	background-image: url();
	background-color: #f9f9f9;
}
-->
</style>
<link href="estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<body>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
</style></head>
<body>
<form name="frmPrincipal" action="" method="post">
  <table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
    <tr>
      <td width="26%" align="center" >Resumen por Producto </td>
      <?
			for($i=$Mes;$i<=$MesFin;$i++)
			{
		  ?>
      <td align="center" colspan="3"><? echo $Meses[$i-1];?></td>
      <?	
			}
		  ?>
      <td align="center" colspan="3">Acumulado</td>
    </tr>
    <tr>
      <td width="26%" align="center" >&nbsp;</td>
      <?
			for($i=$Mes;$i<=$MesFin;$i++)
			{
		  ?>
      <td width="12%" align="center" >Ingreso</td>
      <td width="12%" align="center">Costos</td>
      <td width="24%" align="center">Margen</td>
      <?	
			}
		  ?>
      <td width="8%"  align="center" >Ingreso</td>
      <td width="10%"  align="center">Costos</td>
      <td width="8%"  align="center">Margen</td>
    </tr>
    <?
			?>
    <tr>
      <td colspan="37">1. Cobre</td>
    </tr>
    <?			$Buscar='S';
			 if($Buscar=='S')
			 {			    
				$ArrayTot=array();$ArrayTotalCobre1=array();$ArrayTotalCobre2=array();$ArrayTotalCobre3=array();$ValorMaquilas=array();				
				$Consulta ="select nombre_subclase  as nom_grupo,cod_subclase as cod_grupo from proyecto_modernizacion.sub_clase";
				$Consulta.=" where cod_clase='31019' and valor_subclase1='C' and cod_subclase not in ('21','23','24','25')";
				$Consulta.= " group by cod_grupo";	
				//echo $Consulta; 	
				$Resp=mysql_query($Consulta);
				while($Fila=mysql_fetch_array($Resp))
				{
						$NomGrupo=$Fila[nom_grupo];
						$CodGrupo=$Fila["cod_grupo"];
						?>
    <tr >
      <td rowspan="1" align="left"><? echo $NomGrupo;?></td>
      <?
						for($i=$Mes;$i<=$MesFin;$i++)
						{						
							$Consulta =" select sum(t3.valor) as ValorIngreso,sum(t4.valor) as ValorCosto from pcip_ere_productos t1";
							$Consulta.=" inner join pcip_ere_productos_por_grupo t2 on t1.cod_producto=t2.cod_producto ";
							$Consulta.=" left join pcip_ere_estado_resultado t3 on  t1.cuenta_ingreso=t3.cod_cuenta and t3.ano='".$Ano."' and t3.mes='".$i."' ";
							$Consulta.=" left join pcip_ere_estado_resultado t4 on  t1.cuenta_costos=t4.cod_cuenta and t4.ano='".$Ano."' and t4.mes='".$i."' ";
							$Consulta.=" where t2.cod_grupo='".$CodGrupo."' ";
							$Consulta.=" group by t2.cod_grupo ";
							//if($CodGrupo=='19'&&$i==1)
							//echo $Consulta."<br>";
							$Valor=0;$Valor1=0;$Valor2=0;
							$Resp2=mysql_query($Consulta); 
							if($Fila2=mysql_fetch_array($Resp2))
							{
								$Valor=$Fila2[ValorIngreso];
								$Valor1=$Fila2[ValorCosto];
								$Valor2=$Fila2[ValorIngreso]+$Fila2[ValorCosto];
								$ArrayTot[$i][1]=$ArrayTot[$i][1]+$Valor;
								$ArrayTot[$i][2]=$ArrayTot[$i][2]+$Valor1;
								$ArrayTot[$i][3]=$ArrayTot[$i][3]+$Valor2;
								echo "<td align='right'>".number_format($Valor,0,',','.')."</td>";
								echo "<td align='right'>".number_format($Valor1,0,',','.')."&nbsp;</td>";
								echo "<td align='right'>".number_format($Valor2,0,',','.')."&nbsp;</td>";	
							}
							else
							{	$Valor=0;
								echo "<td align='right'>".number_format($Valor,0,',','.')."</td>";
								echo "<td align='right'>".number_format($Valor1,0,',','.')."&nbsp;</td>";
								echo "<td align='right'>".number_format($Valor2,0,',','.')."&nbsp;</td>";		
							}		
						}		
							$Consulta =" select sum(t3.valor) as ValorIngreso,sum(t4.valor) as ValorCosto from pcip_ere_productos t1";
							$Consulta.=" inner join pcip_ere_productos_por_grupo t2 on t1.cod_producto=t2.cod_producto ";
							$Consulta.=" left join pcip_ere_estado_resultado t3 on  t1.cuenta_ingreso=t3.cod_cuenta and t3.ano='".$Ano."' and t3.mes between '1' and '".$MesFin."'";
							$Consulta.=" left join pcip_ere_estado_resultado t4 on  t1.cuenta_costos=t4.cod_cuenta and t4.ano='".$Ano."' and t4.mes between '1' and '".$MesFin."' ";
							$Consulta.=" where t2.cod_grupo='".$CodGrupo."' ";
							$Consulta.=" group by t2.cod_grupo ";
							//if($CodGrupo=='19'&&$i==1)
							//echo $Consulta."<br>";
							$ValorAcumulado1=0;$ValorAcumulado2=0;$ValorAcumuladoMargen=0;
							$Resp2=mysql_query($Consulta); 
							if($Fila2=mysql_fetch_array($Resp2))
							{
							   $ValorAcumulado1=$Fila2[ValorIngreso];
							   $ValorAcumulado2=$Fila2[ValorCosto];
							   $ValorAcumuladoMargen=$Fila2[ValorIngreso]+$Fila2[ValorCosto];							   
						       //MARGEN
								echo "<td align='right'>".number_format($ValorAcumulado1,0,',','.')."</td>";
								echo "<td align='right'>".number_format($ValorAcumulado2,0,',','.')."&nbsp;</td>";
								echo "<td align='right'>".number_format($ValorAcumuladoMargen,0,',','.')."&nbsp;</td>";	
								$TotalCobre1=$TotalCobre1+$ValorAcumulado1;
								$TotalCobre2=$TotalCobre2+$ValorAcumulado2;
								$TotalCobre3=$TotalCobre3+$ValorAcumuladoMargen;
							}	
					?>
    </tr>
    <?
				 }  
				 ?>
    <tr>
      <td>Total Cobre</td>
      <?
					reset($ArrayTot);
					for($i=$Mes;$i<=$MesFin;$i++)
					{
					?>
      <td align='right'><? echo number_format($ArrayTot[$i][1],0,',','.');?></td>
      <td align='right'><? echo number_format($ArrayTot[$i][2],0,',','.');?>.&nbsp;</td>
      <td align='right'><? echo number_format($ArrayTot[$i][3],0,',','.');?>.&nbsp;</td>
      <?
					}	
					   //MARGEN
					 ?>
      <td align='right'><? echo number_format($TotalCobre1,0,',','.');?></td>
      <td align='right'><? echo number_format($TotalCobre2,0,',','.');?>&nbsp;</td>
      <td align='right'><? echo number_format($TotalCobre3,0,',','.');?>&nbsp;</td>
      <?	
						$ArrayTotalCobre1[$i][0]=$ArrayTotalCobre1[$i][0]+$TotalCobre1;
						$ArrayTotalCobre2[$i][0]=$ArrayTotalCobre2[$i][0]+$TotalCobre2;
						$ArrayTotalCobre3[$i][0]=$ArrayTotalCobre3[$i][0]+$TotalCobre3;	
					?>
    </tr>
    <? //ELEMENTOS AGREGADOS DESPUES ANTES DE SERVICIOS DE MAQUILA
					$Consulta ="select nombre_subclase  as nom_grupo,cod_subclase as cod_grupo from proyecto_modernizacion.sub_clase";
					$Consulta.=" where cod_clase='31019' and valor_subclase1='C' and cod_subclase in ('23','24','25')";
					$Consulta.= " group by cod_grupo";	
					//echo $Consulta; 	
					$Resp=mysql_query($Consulta);
					while($Fila=mysql_fetch_array($Resp))
					{
							$NomGrupo=$Fila[nom_grupo];
							$CodGrupo=$Fila["cod_grupo"];
							?>
    <tr>
      <td rowspan="1" align="left"><? echo $NomGrupo;?></td>
      <?
							for($i=$Mes;$i<=$MesFin;$i++)
							{						
								$Consulta =" select sum(t3.valor) as ValorIngreso,sum(t4.valor) as ValorCosto from pcip_ere_productos t1";
								$Consulta.=" inner join pcip_ere_productos_por_grupo t2 on t1.cod_producto=t2.cod_producto ";
								$Consulta.=" left join pcip_ere_estado_resultado t3 on  t1.cuenta_ingreso=t3.cod_cuenta and t3.ano='".$Ano."' and t3.mes='".$i."' ";
								$Consulta.=" left join pcip_ere_estado_resultado t4 on  t1.cuenta_costos=t4.cod_cuenta and t4.ano='".$Ano."' and t4.mes='".$i."' ";
								$Consulta.=" where t2.cod_grupo='".$CodGrupo."' ";
								$Consulta.=" group by t2.cod_grupo ";
								//if($CodGrupo=='19'&&$i==1)
								//echo $Consulta."<br>";
								$Valor=0;$Valor1=0;$Valor2=0;
								$Resp2=mysql_query($Consulta); 
								if($Fila2=mysql_fetch_array($Resp2))
								{
									$Valor=$Fila2[ValorIngreso];
									$Valor1=$Fila2[ValorCosto];
									$Valor2=$Fila2[ValorIngreso]+$Fila2[ValorCosto];
									$ArrayTot[$i][1]=$ArrayTot[$i][1]+$Valor;
									$ArrayTot[$i][2]=$ArrayTot[$i][2]+$Valor1;
									$ArrayTot[$i][3]=$ArrayTot[$i][3]+$Valor2;
									$ValorMaquilas[$i][1]=$ValorMaquilas[$i][1]+$Valor;
									$ValorMaquilas[$i][2]=$ValorMaquilas[$i][2]+$Valor1;
									$ValorMaquilas[$i][3]=$ValorMaquilas[$i][3]+$Valor2;
									echo "<td align='right'>".number_format($Valor,0,',','.')."</td>";
									echo "<td align='right'>".number_format($Valor1,0,',','.')."&nbsp;</td>";
									echo "<td align='right'>".number_format($Valor2,0,',','.')."&nbsp;</td>";	
								}
								else
								{	$Valor=0;
									echo "<td align='right'>".number_format($Valor,0,',','.')."</td>";
									echo "<td align='right'>".number_format($Valor1,0,',','.')."&nbsp;</td>";
									echo "<td align='right'>".number_format($Valor2,0,',','.')."&nbsp;</td>";		
								}		
							}		
								$Consulta =" select sum(t3.valor) as ValorIngreso,sum(t4.valor) as ValorCosto from pcip_ere_productos t1";
								$Consulta.=" inner join pcip_ere_productos_por_grupo t2 on t1.cod_producto=t2.cod_producto ";
								$Consulta.=" left join pcip_ere_estado_resultado t3 on  t1.cuenta_ingreso=t3.cod_cuenta and t3.ano='".$Ano."' and t3.mes between '1' and '".$MesFin."'";
								$Consulta.=" left join pcip_ere_estado_resultado t4 on  t1.cuenta_costos=t4.cod_cuenta and t4.ano='".$Ano."' and t4.mes between '1' and '".$MesFin."' ";
								$Consulta.=" where t2.cod_grupo='".$CodGrupo."' ";
								$Consulta.=" group by t2.cod_grupo ";
								//if($CodGrupo=='19'&&$i==1)
								//echo $Consulta."<br>";
								$ValorAcumulado1=0;$ValorAcumulado2=0;$ValorAcumuladoMargen=0;
								$Resp2=mysql_query($Consulta); 
								if($Fila2=mysql_fetch_array($Resp2))
								{
								   $ValorAcumulado1=$Fila2[ValorIngreso];
								   $ValorAcumulado2=$Fila2[ValorCosto];
								   $ValorAcumuladoMargen=$Fila2[ValorIngreso]+$Fila2[ValorCosto];
								   $ValorAcumulado[$i][1]=$ValorAcumulado[$i][1]+$ValorAcumulado1;							   
								   $ValorAcumulado[$i][2]=$ValorAcumulado[$i][2]+$ValorAcumulado2;						   
								   $ValorAcumulado[$i][3]=$ValorAcumulado[$i][3]+$ValorAcumuladoMargen;							   
								   //MARGEN
								   ?>
      <td align='right'><? echo number_format($ValorAcumulado1,0,',','.');?>&nbsp;</td>
      <td align='right'><? echo number_format($ValorAcumulado2,0,',','.');?>&nbsp;</td>
      <td align='right'><? echo number_format($ValorAcumuladoMargen,0,',','.');?>&nbsp;</td>
      <?
									$TotalCobre1=$TotalCobre1+$ValorAcumulado1;
									$TotalCobre2=$TotalCobre2+$ValorAcumulado2;
									$TotalCobre3=$TotalCobre3+$ValorAcumuladoMargen;								
								}	
								else
								{
								   ?>
									<td align='right'><? echo number_format($ValorAcumulado1,0,',','.');?>&nbsp;</td>
									<td align='right'><? echo number_format($ValorAcumulado2,0,',','.');?>&nbsp;</td>
									<td align='right'><? echo number_format($ValorAcumuladoMargen,0,',','.');?>&nbsp;</td>	
								   <?

								}	
						?>
    </tr>
    <?
					 }  
					 ?>
    <? /*servicio de maquila*/
					$Consulta ="select nombre_subclase  as nom_grupo,cod_subclase as cod_grupo from proyecto_modernizacion.sub_clase";
					$Consulta.=" where cod_clase='31019' and valor_subclase1='C' and cod_subclase in ('21')";
					$Consulta.= " group by cod_grupo";	
					//echo $Consulta; 	
					$Resp=mysql_query($Consulta);
					while($Fila=mysql_fetch_array($Resp))
					{
							$NomGrupo=$Fila[nom_grupo];
							$CodGrupo=$Fila["cod_grupo"];
							?>
    <tr>
      <td rowspan="1" align="left"><? echo $NomGrupo;?></td>
      <?
							for($i=$Mes;$i<=$MesFin;$i++)
							{						
									$Valor=$Valor+$ValorMaquilas[$i][1];
									$Valor1=$Valor1+$ValorMaquilas[$i][2];
									$Valor2=$Valor2+$ValorMaquilas[$i][3];
									echo "<td align='right'>".number_format($Valor,0,',','.')."</td>";
									echo "<td align='right'>".number_format($Valor1,0,',','.')."&nbsp;</td>";
									echo "<td align='right'>".number_format($Valor2,0,',','.')."&nbsp;</td>";		

							}
								   $ValorAcumulado1=$ValorAcumulado[$i][1];
								   $ValorAcumulado2=$ValorAcumulado[$i][2];
								   $ValorAcumuladoMargen=$ValorAcumulado[$i][3];							   
								   //MARGEN
									echo "<td align='right'>".number_format($ValorAcumulado1,0,',','.')."</td>";
									echo "<td align='right'>".number_format($ValorAcumulado2,0,',','.')."&nbsp;</td>";
									echo "<td align='right'>".number_format($ValorAcumuladoMargen,0,',','.')."&nbsp;</td>";	
									$ArrayTotalCobre1[$i][0]=$ArrayTotalCobre1[$i][0]+$ValorAcumulado1;
									$ArrayTotalCobre2[$i][0]=$ArrayTotalCobre2[$i][0]+$ValorAcumulado2;
									$ArrayTotalCobre3[$i][0]=$ArrayTotalCobre3[$i][0]+$ValorAcumuladoMargen;	

								$TotalCobreAbajo1=$ArrayTotalCobre1[$i][0];
								$TotalCobreAbajo2=$ArrayTotalCobre2[$i][0];
								$TotalCobreAbajo3=$ArrayTotalCobre3[$i][0];
								//echo 	"arriba   ".$TotalCobre1."<br>";
						?>
    </tr>
    <?
					 }  
					 ?>
    <tr>
      <td colspan="37">3. SubProductos</td>
    </tr>
    <?
					        $ArrayTot2=array();$ArrayTot3=array();
							$Consulta ="select nombre_subclase  as nom_grupo,cod_subclase as cod_grupo from proyecto_modernizacion.sub_clase";
							$Consulta.=" where cod_clase='31019' and valor_subclase1='S'";
							$Consulta.= " group by cod_grupo";	
							//echo $Consulta; 	
							$Resp=mysql_query($Consulta);
							while($Fila=mysql_fetch_array($Resp))
							{
								$NomGrupo=$Fila[nom_grupo];
								$CodGrupo=$Fila["cod_grupo"];
								?>
    <tr>
      <td rowspan="1" align="left"><? echo $NomGrupo;?></td>
      <?	
								for($i=$Mes;$i<=$MesFin;$i++)
								{
									$Consulta =" select sum(t3.valor) as ValorIngreso,sum(t4.valor) as ValorCosto from pcip_ere_productos t1";
									$Consulta.=" inner join pcip_ere_productos_por_grupo t2 on t1.cod_producto=t2.cod_producto ";
									$Consulta.=" left join pcip_ere_estado_resultado t3 on  t1.cuenta_ingreso=t3.cod_cuenta and t3.ano='".$Ano."' and t3.mes='".$i."' ";
									$Consulta.=" left join pcip_ere_estado_resultado t4 on  t1.cuenta_costos=t4.cod_cuenta and t4.ano='".$Ano."' and t4.mes='".$i."' ";
									$Consulta.=" where t2.cod_grupo='".$CodGrupo."' ";
									$Consulta.=" group by t2.cod_grupo ";
									//if($i==1&&$CodGrupo=='7')
									//	echo $Consulta;
								    $ValorS=0;$ValorS1=0;$ValorS2=0;						
									$Resp2=mysql_query($Consulta);
									if($Fila2=mysql_fetch_array($Resp2))
									{
										$ValorS=$Fila2[ValorIngreso];
										$ValorS1=$Fila2[ValorCosto];
										$ValorS2=$Fila2[ValorIngreso]+$Fila2[ValorCosto];
										$ArrayTot2[$i][1]=$ArrayTot2[$i][1]+$ValorS;
										$ArrayTot2[$i][2]=$ArrayTot2[$i][2]+$ValorS1;
										$ArrayTot2[$i][3]=$ArrayTot2[$i][3]+$ValorS2;
										echo "<td align='right'>".number_format($ValorS,0,',','.')."</td>";
										echo "<td align='right'>".number_format($ValorS1,0,',','.')."&nbsp;</td>";
										echo "<td align='right'>".number_format($ValorS2,0,',','.')."&nbsp;</td>";	
										$TotalSuno=$TotalSuno+$ValorS;
										$TotalSdos=$TotalSdos+$ValorS1;
										$TotalStres=$TotalStres+$ValorS2;
									}
									else
									{
								        $ValorS=0;$ValorS1=0;$ValorS2=0;						
										echo "<td align='right'>".number_format($ValorS,0,',','.')."</td>";
										echo "<td align='right'>".number_format($ValorS1,0,',','.')."&nbsp;</td>";
										echo "<td align='right'>".number_format($ValorS2,0,',','.')."&nbsp;</td>";	
									}	
								}
									$Consulta =" select sum(t3.valor) as ValorIngreso,sum(t4.valor) as ValorCosto from pcip_ere_productos t1";
									$Consulta.=" inner join pcip_ere_productos_por_grupo t2 on t1.cod_producto=t2.cod_producto ";
									$Consulta.=" left join pcip_ere_estado_resultado t3 on  t1.cuenta_ingreso=t3.cod_cuenta and t3.ano='".$Ano."' and t3.mes between '1' and '".$MesFin."'";
									$Consulta.=" left join pcip_ere_estado_resultado t4 on  t1.cuenta_costos=t4.cod_cuenta and t4.ano='".$Ano."' and t4.mes between '1' and '".$MesFin."' ";
									$Consulta.=" where t2.cod_grupo='".$CodGrupo."' ";
									$Consulta.=" group by t2.cod_grupo ";
									//if($CodGrupo=='19'&&$i==1)
									//echo $Consulta."<br>";
									$ValorAcumulado1=0;$ValorAcumulado2=0;$ValorAcumuladoMargen=0;
									$Resp2=mysql_query($Consulta); 
									if($Fila2=mysql_fetch_array($Resp2))
									{
									   $ValorAcumulado1=$Fila2[ValorIngreso];
									   $ValorAcumulado2=$Fila2[ValorCosto];
									   $ValorAcumuladoMargen=$Fila2[ValorIngreso]+$Fila2[ValorCosto];							   
									   //MARGEN
										echo "<td align='right'>".number_format($ValorAcumulado1,0,',','.')."</td>";
										echo "<td align='right'>".number_format($ValorAcumulado2,0,',','.')."&nbsp;</td>";
										echo "<td align='right'>".number_format($ValorAcumuladoMargen,0,',','.')."&nbsp;</td>";	
										$TotalSubPro1=$TotalSubPro1+$ValorAcumulado1;
										$TotalSubPro2=$TotalSubPro2+$ValorAcumulado2;
										$TotalSubPro3=$TotalSubPro3+$ValorAcumuladoMargen;
									}	
								?>
    </tr>
    <?
							}
						
						?>
    <tr>
      <td>Total Subproductos</td>
      <?
						reset($ArrayTot2);
						for($i=$Mes;$i<=$MesFin;$i++)
						{						
								echo "<td align='right'>".number_format($ArrayTot2[$i][1],0,',','.')."</td>";
								echo "<td align='right'>".number_format($ArrayTot2[$i][2],0,',','.')."&nbsp;</td>";
								echo "<td align='right'>".number_format($ArrayTot2[$i][3],0,',','.')."&nbsp;</td>";		
						}
								//MARGEN
								echo "<td align='right'>".number_format($TotalSubPro1,0,',','.')."</td>";
								echo "<td align='right'>".number_format($TotalSubPro2,0,',','.')."&nbsp;</td>";
								echo "<td align='right'>".number_format($TotalSubPro3,0,',','.')."&nbsp;</td>";	
						?>
    </tr>
    <tr>
      <td>Total Margen Explotaci&oacute;n</td>
      <?	
						for($i=$Mes;$i<=$MesFin;$i++)
						{				
						   	$ArrayTot3[$i][1]=$ArrayTot2[$i][1]+$ArrayTot[$i][1];
							$ArrayTot3[$i][2]=$ArrayTot2[$i][2]+$ArrayTot[$i][2];
							$ArrayTot3[$i][3]=$ArrayTot2[$i][3]+$ArrayTot[$i][3];
							echo "<td align='right'>".number_format($ArrayTot3[$i][1],0,',','.')."</td>";
							echo "<td align='right'>".number_format($ArrayTot3[$i][2],0,',','.')."&nbsp;</td>";
							echo "<td align='right'>".number_format($ArrayTot3[$i][3],0,',','.')."&nbsp;</td>";	
							$TotalMar1=$TotalCobreAbajo1+$TotalSubPro1;
							$TotalMar2=$TotalCobreAbajo2+$TotalSubPro2;
							$TotalMar3=$TotalCobreAbajo3+$TotalSubPro3;
						}	
							//MARGEN
							echo "<td align='right'>".number_format($TotalMar1,0,',','.')."</td>";
							echo "<td align='right'>".number_format($TotalMar2,0,',','.')."&nbsp;</td>";
							echo "<td align='right'>".number_format($TotalMar3,0,',','.')."&nbsp;</td>";	
			 }
			 ?>
    </tr>
  </table>
</form>
<? 
    echo "<script languaje='JavaScript'>";
	if ($Mensaje=='1')
		echo "alert('Variaciones Inventario (s) Eliminado(s) Correctamente');";
	echo "</script>";
?>	
</body>
</html>