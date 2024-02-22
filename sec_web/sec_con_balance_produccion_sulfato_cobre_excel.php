<?php 	
	        ob_end_clean();
        $file_name=basename($_SERVER['PHP_SELF']).".xls";
        $userBrowser = $_SERVER['HTTP_USER_AGENT'];
        if ( preg_match( '/MSIE/i', $userBrowser ) ) {
        $filename = urlencode($filename);
        }
        $filename = iconv('UTF-8', 'gb2312', $filename);
        $file_name = str_replace(".php", "", $file_name);
        header("<meta http-equiv='X-UA-Compatible' content='IE=Edge'>");
        header("<meta http-equiv='content-type' content='text/html;charset=uft-8'>");
        
        header("content-disposition: attachment;filename={$file_name}");
        header( "Cache-Control: public" );
        header( "Pragma: public" );
        header( "Content-type: text/csv" ) ;
        header( "Content-Dis; filename={$file_name}" ) ;
        header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");	
	include("../principal/conectar_sec_web.php");
	if ($FinoLeyes == "F")
		$Unidad = "kg";
	else	$Unidad = "%";	
	if (!isset($DiaIni))
	{
		$DiaFin = "31";
		$MesFin = str_pad($MesFin,2, "0", STR_PAD_LEFT);
		$AnoFin = $AnoFin;
		$DiaIni = "01";
		$MesIni = $MesFin;
		$AnoIni = $AnoFin;		
	}
	$FechaInicio = $AnoIni."-".$MesIni."-".$DiaIni;	
	$FechaTermino = $AnoFin."-".$MesFin."-".$DiaFin;
?>
<html>
<head>
<script language="JavaScript">
function Imprimir()
{
	window.print();	
}
function Excel()
{
	var Frm=document.FrmStockSec;
	
	Frm.action="sec_con_balance_produccion_sulfato_cobre_excel";
	Frm.submit();
}
function Salir()
{
	var Frm=document.FrmStockSec;
	Frm.action="sec_con_balance.php";
	Frm.submit();
}
function Historial(SA)
{
	window.open("../cal_web/cal_con_registro_leyes.php?SA="+ SA,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}
</script>
<title>Balance Produccion Sulfatos Cobre</title>
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmStockSec" method="post" action="">
  <table width="622" border="1" cellspacing="0" cellpadding="2">
    <tr align="center"> 
      <td height="30" colspan="12"><strong>TIPO DE MOVIMIENTO PESAJE DE PRODUCCION</strong></td>
    </tr>
    <tr> 
      <td colspan="3"><strong>PRODUCTO</strong></td>
      <td width="464" colspan="9">SALES</td>
    </tr>
    <tr> 
      <td colspan="3"><strong>SUBPRODUCTO</strong></td>
      <td colspan="9">SULFATO DE COBRE PTE Y PLAMEN</td>
    </tr>
    <tr> 
      <td colspan="3"><strong>PERIODO</strong></td>
      <td colspan="9"> 
        <?php 
	  	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	  	echo $Meses[$MesFin - 1]." del ".$AnoFin; 
	?>
      </td>
    </tr>
  </table>
  
	  
  <br>
  <table border="1" cellpadding="0" cellspacing="0" class="TablaDetalle">
    <tr class="ColorTabla01"> 
      <td width="110" align="center">&nbsp;</td>
      <td colspan="2" width='90' align="center">PLAMEN</td>
      <td colspan="2" width='90' align="center">PTE</td>
      <td colspan="10" align="center">&nbsp;</td>
    </tr>
    <tr class="ColorTabla01"> 
      <td width='110'align="center">Fecha Periodo</td>
      <td width='90' align="center">Cant</td>
      <td width='55' align="center">P.HUM</td>
      <td width='90' align="center">Cant</td>
      <td width='55' align="center">P.HUM</td>
      <td width='90' align="center">S.A/CERTIF</td>
      <td width='80' align="center">HUMEDAD<br>
        %</td>
      <td width='80' align="center">P.SECO</td>
      <td width='90' align="center">S.A</td>
      <td width='60' align="center">Cu<br><?php echo $Unidad; ?></td>
      <td width='60' align="center">As<br><?php echo $Unidad; ?></td>
      <td width='60' align="center">Sb<br><?php echo $Unidad; ?></td>
      <td width='60' align="center">Fe<br><?php echo $Unidad; ?></td>
      <td width='60' align="center">Ni<br><?php echo $Unidad; ?></td>
      <td width='60' align="center">Pb<br><?php echo $Unidad; ?></td>
    </tr>
    <?php
			if (strlen($MesFin)==1)
			{
				$MesFin="0".$MesFin;
			}
			$FechaInicio=$AnoFin."-".$MesFin."-01";
			$FechaTermino=$AnoFin."-".$MesFin."-31";
			$Semana1_Ini=$AnoFin."-".$MesFin."-01 00:00:00";
			$Semana1_Fin=$AnoFin."-".$MesFin."-07 23:59:59";
			$Semana2_Ini=$AnoFin."-".$MesFin."-08 00:00:00";
			$Semana2_Fin=$AnoFin."-".$MesFin."-14 23:59:59";
			$Semana3_Ini=$AnoFin."-".$MesFin."-15 00:00:00";
			$Semana3_Fin=$AnoFin."-".$MesFin."-21 23:59:59";
			$Semana4_Ini=$AnoFin."-".$MesFin."-22 00:00:00";
			$Semana4_Fin=$AnoFin."-".$MesFin."-31 23:59:59";
			$SubTotalPSeco=0;
			$TotalPMN = 0;
			$TotalPTE = 0;
			$TotalCantPMN = 0;
			$TotalCantPTE = 0;
			$TotalCu = 0;
			$TotalAs = 0;
			$TotalSb = 0;
			$TotalFe = 0;
			$TotalNi = 0;
			$TotalPb = 0;
			for ($i=1;$i<=31;$i++)
			{
				if (strlen($i)==1)
				{
					$Dia="0".$i;
				}
				else
				{
					$Dia=$i;	
				}
				$FechaProd=$AnoFin."-".$MesFin."-".$Dia;
				echo "<tr>";
				echo "<td>".$FechaProd."</td>";
				//PARA PLANTA DE METALES(PMN)
				$Consulta="SELECT fecha_produccion,sum(peso_produccion) as peso, sum(peso_tara) as peso_tara, count(*) as cant from sec_web.produccion_catodo ";
				$Consulta=$Consulta." where cod_producto='64' and cod_subproducto='5' and fecha_produccion ='".$FechaProd."'";
				$Consulta=$Consulta." group by fecha_produccion";				
				$Respuesta2=mysqli_query($link, $Consulta);
				$Fila2=mysqli_fetch_array($Respuesta2);
				if (!is_null($Fila2[fecha_produccion]))
				{
					$TotalCantPMN = $TotalCantPMN + $Fila2["cant"];
					echo "<td align='right'>".$Fila2["cant"]."</td>";
					echo "<td align='right'>".number_format($Fila2["peso"]-$Fila2["peso_tara"],0,',','.')."</td>";
					$SubTotalPHumPMN=$SubTotalPHumPMN+($Fila2["peso"]-$Fila2["peso_tara"]);
				}
				else
				{
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
				}
				//PARA PLANTA DE TRATAMIENTO ELECTROLITO(PTE)
				$Consulta="SELECT t1.fecha_produccion,sum(t1.peso_produccion) as peso, sum(t1.peso_tara)as peso_tara, count(*) as cant ";
				$Consulta.= " from sec_web.produccion_catodo t1 ";
				$Consulta.= " where t1.cod_producto='64' ";
				$Consulta.= " and t1.cod_subproducto='1' ";
				$Consulta.= " and t1.fecha_produccion ='".$FechaProd."'";
				$Consulta.= " group by fecha_produccion";
				$Respuesta3=mysqli_query($link, $Consulta);
				$Fila3=mysqli_fetch_array($Respuesta3);
				if (!is_null($Fila3[fecha_produccion]))
				{
					//PARA PLANTA DE TRATAMIENTO ELECTROLITO(PTE) HUMEDAD
					$Consulta="SELECT t2.nro_solicitud,ifnull(t3.valor,0)as valor";
					$Consulta.= " from cal_web.solicitud_analisis t2 ";
					$Consulta.= " left join cal_web.leyes_por_solicitud t3 on t2.fecha_hora=t3.fecha_hora ";
					$Consulta.= " and t2.nro_solicitud=t3.nro_solicitud and t3.cod_producto=t2.cod_producto ";
					$Consulta.= " and t3.cod_subproducto=t2.cod_subproducto ";
					$Consulta.= " where t2.cod_producto='64' ";
					$Consulta.= " and t2.cod_subproducto='1' ";
					$Consulta.= " and left(t2.fecha_muestra,10) = '".$FechaProd."'";
					$Consulta.= " and t3.cod_leyes='01' ";
					$Consulta.= " AND t2.cod_periodo in(1,4)"; //DIARIO
					$Consulta.= " AND t2.cod_analisis = '1'"; //QUIMICO
					$Consulta.= " AND t2.tipo = '1'"; //NORMAL
					$Consulta.= " AND (t2.estado_actual <> '7' and t2.estado_actual <> '16')"; // <> ELIMINADA,ANULADA
					$Resp4 = mysqli_query($link, $Consulta);
					if ($Fila4 = mysqli_fetch_array($Resp4))
					{
						$NroSA = $Fila4["nro_solicitud"];				
						$PorcHum = $Fila4["valor"];
					}
					else
					{
						$NroSA = "";
						$PorcHum = 0;
					}
					$TotalCantPTE = $TotalCantPTE + $Fila3["cant"];
					echo "<td align='right'>".$Fila3["cant"]."</td>";
					echo "<td align='right'>".number_format($Fila3["peso"]-$Fila3["peso_tara"],0,',','.')."</td>";					
					if ($NroSA == "")
						echo "<td align='center'>&nbsp;</td>\n";					
					else
						echo "<td align='center'>".$NroSA."</td>\n";					
					echo "<td align='right'>".number_format($PorcHum,3,',','')."</td>";
					$PesoSeco=($Fila3["peso"]-$Fila3["peso_tara"])-((($Fila3["peso"]-$Fila3["peso_tara"])*$PorcHum)/100);
					$SubTotalPHumPTE=$SubTotalPHumPTE + ($Fila3["peso"]-$Fila3["peso_tara"]);
					$SubTotalPSeco=$SubTotalPSeco + $PesoSeco;
					$PondHum = $PondHum+$PorcHum * $PesoSeco;
					echo "<td align='right'>".number_format($PesoSeco,0,',','.')."</td>";
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
				}
				else
				{
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
				}
				echo "</tr>";
				//4 SEMANAS DEL MES
				if (($i=='7')||($i=='14')||($i=='21')||($i=='31'))
				{
					$TotalPHumPMN = $TotalPHumPMN + $SubTotalPHumPMN;
					$TotalPHumPTE = $TotalPHumPTE + $SubTotalPHumPTE;
					$TotalPSecoPTE = $TotalPSecoPTE + $SubTotalPSeco;					
					echo "<tr class='detalle01'>";
					echo "<td align='right'>&nbsp;</td>";
					echo "<td align='right'>&nbsp;</td>";
					echo "<td align='right'>".number_format($SubTotalPHumPMN,0,',','.')."</td>";
					echo "<td align='right'>&nbsp;</td>";
					echo "<td align='right'>".number_format($SubTotalPHumPTE,0,',','.')."</td>";
					echo "<td align='right'>&nbsp;</td>";
					if ($PondHum > 0 && $SubTotalPSeco > 0)
						echo "<td align='right'>".number_format($PondHum/$SubTotalPHumPTE,3,',','.')."</td>";
					else
						echo "<td align='right'>0</td>";					
					echo "<td align='right'>".number_format($SubTotalPSeco,0,',','.')."</td>";
					$Consulta="SELECT t1.nro_solicitud,ifnull(t2.valor,0) as valor,t2.cod_leyes from cal_web.solicitud_analisis t1 left join cal_web.leyes_por_solicitud t2 ";
					$Consulta=$Consulta." on t1.rut_funcionario=t2.rut_funcionario and t1.fecha_hora=t2.fecha_hora and ";
					$Consulta=$Consulta." t1.nro_solicitud=t2.nro_solicitud where t1.estado_actual not in ('7','16','8') and t1.cod_periodo='2' and t1.cod_producto='64' and t1.cod_subproducto='1' and ";
					switch ($i)
					{
						case "7":
							$Consulta=$Consulta." t1.fecha_muestra between '".$Semana1_Ini."' and '".$Semana1_Fin."' and t2.cod_leyes <> '01' and ";
							break;
						case "14":
							$Consulta=$Consulta." t1.fecha_muestra between '".$Semana2_Ini."' and '".$Semana2_Fin."' and t2.cod_leyes <> '01' and ";
							break;
						case "21":
							$Consulta=$Consulta." t1.fecha_muestra between '".$Semana3_Ini."' and '".$Semana3_Fin."' and t2.cod_leyes <> '01' and ";
							break;
						case "31":	
							$Consulta=$Consulta." t1.fecha_muestra between '".$Semana4_Ini."' and '".$Semana4_Fin."' and t2.cod_leyes <> '01' and ";
							break;	
					}
					$Consulta=$Consulta." (t2.cod_leyes in('02','08','09','31','36','39')) ";
					$Consulta.= " AND t1.cod_periodo = '2'"; //SEMANAL
					$Consulta.= " AND t1.cod_analisis = '1'"; //QUIMICO
					$Consulta.= " AND t1.tipo = '1'"; //NORMAL
					$Consulta.= " AND (t1.estado_actual <> '7' and t1.estado_actual <> '16')"; // <> ELIMINADA,ANULADA
					$Consulta.= " order by t1.fecha_muestra desc limit 6";				
					$Respuesta4=mysqli_query($link, $Consulta);
					$Entro=true;
					$Cant=0;
					while($Fila4=mysqli_fetch_array($Respuesta4))
					{
						switch ($Fila4["cod_leyes"])
						{
							case "02":
								$TotalCu = $TotalCu + ($Fila4["valor"] * $SubTotalPSeco);
								break;
							case "08":
								$TotalAs = $TotalAs + ($Fila4["valor"] * $SubTotalPSeco);
								break;
							case "09":
								$TotalSb = $TotalSb + ($Fila4["valor"] * $SubTotalPSeco);
								break;
							case "31":								
								$TotalFe = $TotalFe + ($Fila4["valor"] * $SubTotalPSeco);
								break;
							case "36":
								$TotalNi = $TotalNi + ($Fila4["valor"] * $SubTotalPSeco);
								break;
							case "39":
								$TotalPb = $TotalPb + ($Fila4["valor"] * $SubTotalPSeco);
								break;
						}
						if ($Entro==true)
						{
							echo "<td align='center'>".$Fila4["nro_solicitud"]."</td>\n";					
							$Entro=false;
						}
						if ($FinoLeyes=='L')
						{
							echo "<td align='right'>".number_format($Fila4["valor"],3,',','.')."</td>";	
						}
						else
						{
							if ($Fila4["cod_leyes"]=='02')
							{
								$Fino=number_format((($SubTotalPSeco*$Fila4["valor"])/100),0,',','.');
							}
							else
							{
								$Fino=number_format((($SubTotalPSeco*$Fila4["valor"])/100),3,',','.');
							}	
							echo "<td align='right'>".$Fino."</td>";	
						}
						$Cant++;
					}
					$SubTotalPSeco=0;
					$PondHum=0;
					$SubTotalPHumPTE=0;
					$SubTotalPHumPMN=0;						
					if ($Cant>0)
					{						
						for ($j=0;$j<6-$Cant;$j++)
						{
							echo "<td align='right'>&nbsp;</td>";	
						}
					}
					else
					{
						for ($j=0;$j<7;$j++)
						{
							echo "<td align='right'>&nbsp;</td>";	
						}
					}	
					echo "</tr>";
				}
			}	
		  ?>
    <tr> 
      <td align="center"><strong>TOTAL</strong></td>
      <td align="right"><?php echo number_format($TotalCantPMN,0,",",".");?></td>
      <td align="right"><?php echo number_format($TotalPHumPMN,0,",",".");?></td>
      <td align="right"><?php echo number_format($TotalCantPTE,0,",",".");?></td>
      <td align="right"><?php echo number_format($TotalPHumPTE,0,",",".");?></td>
      <td align="right">&nbsp;</td>
      <td align="right"><?php echo number_format((($TotalPHumPTE-$TotalPSecoPTE) * 100) / $TotalPHumPTE,3,",","."); ?></td>
      <td align="right"><?php echo number_format($TotalPSecoPTE,0,",",".");?></td>
      <td align="right">&nbsp;</td>
      <td align="right"><?php 
	  	if ($FinoLeyes == "L")
	  		echo number_format(($TotalCu/$TotalPSecoPTE),3,",",".");
		else
			echo number_format(($TotalCu/$TotalPSecoPTE)*100,0,",",".");
	  ?></td>
      <td align="right"><?php 
	  	if ($FinoLeyes == "L")	
	  		echo number_format(($TotalAs/$TotalPSecoPTE),3,",",".");
		else
			echo number_format(($TotalAs/$TotalPSecoPTE)*100,0,",",".");
		?></td>
      <td align="right"><?php 
	  	if ($FinoLeyes == "L")	
	  		echo number_format(($TotalSb/$TotalPSecoPTE),3,",",".");
		else
			echo number_format(($TotalSb/$TotalPSecoPTE)*100,3,",",".");
		?></td>
      <td align="right"><?php 
	  	if ($FinoLeyes == "L")	
	  		echo number_format(($TotalFe/$TotalPSecoPTE),3,",",".");
		else
			echo number_format(($TotalFe/$TotalPSecoPTE)*100,3,",",".");
		?></td>
      <td align="right"><?php 
	  	if ($FinoLeyes == "L")	
	  		echo number_format(($TotalNi/$TotalPSecoPTE),3,",",".");
		else
			echo number_format(($TotalNi/$TotalPSecoPTE)*100,3,",",".");
		?></td>
      <td align="right"><?php 
	 	if ($FinoLeyes == "L")	
	  		echo number_format(($TotalPb/$TotalPSecoPTE),3,",",".");
		else
			echo number_format(($TotalPb/$TotalPSecoPTE)*100,3,",",".");
		?></td>
    </tr>
    <tr> 
      <td align="center"><strong>GLOBAL</strong></td>
      <td colspan="3" align="right">PMN(Hum) + PTE(Hum)</td>
      <td align="right"><?php echo number_format($TotalPHumPMN + $TotalPHumPTE,0,",",".");?></td>
      <td colspan="2" align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
    </tr>
  </table>
        <br>
</form>
</body>
</html>
