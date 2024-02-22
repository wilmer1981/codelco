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
	if($SubProducto == 8)
		$subproducto = "ARSENIATO FERRICO";
	else	
		$subproducto = "HIDROXIDO DE NIQUEL";
	
?>
<html>
<head>
<title>Sistema Estadistico de Catodos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body >
<form name="formulario" method="post" action="">
  <?php 
  
  ?>
  <table width="622" border="1" cellspacing="0" cellpadding="2" class="TablaInterior">
    <tr align="center"> 
      <td height="30" colspan="12"><strong>TIPO DE MOVIMIENTO PESAJE DE PRODUCCION</strong></td>
    </tr>
    <tr> 
      <td width="127"  colspan="3"><strong>PRODUCTO</strong></td>
      <td width="232" colspan="9">SALES</td>
    </tr>
    <tr>
      <td  colspan="3"><strong>SUBPRODUCTO</strong></td>
      <td colspan="9"><?php echo $subproducto; ?></td>
    </tr>
    <tr> 
      <td  colspan="3"><strong>PERIODO</strong></td>
      <td colspan="9">
        <?php 
	  	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	  	echo $Meses[$MesFin - 1]." del ".$AnoFin; 
	?>
      </td>
    </tr>
  </table>
  <br>
  <table width="683" height="24" border="1" cellpadding="2" cellspacing="0" class="TablaDetalle">
    <?php
    	if($FinoLeyes == "F")	
		{
			 echo'<tr>
				  <td align="center" colspan="12">F I N O S</td>
				  </tr>';
		}
		else
		{
			 echo'<tr>
				  <td align="center" colspan="12">L E Y E S</td>
				  </tr>';
		}
   ?>
    <tr class="ColorTabla01"> 
      <td align="center">Fecha </td>
      <td align="center">Cant.</td>
      <td align="center">P. Humedo</td>
      <td align="center">S.A/Certif</td>
      <td align="center">Humed.<br>
        %</td>
      <td align="center">P. Seco</td>
      <td align="center">Cu<br><?php echo $Unidad; ?></td>
      <td align="center">As<br><?php echo $Unidad; ?></td>
      <td align="center">Sb<br><?php echo $Unidad; ?></td>
      <td align="center">Fe<br><?php echo $Unidad; ?></td>
      <td align="center">Ni<br><?php echo $Unidad; ?></td>
      <td align="center">Pb<br><?php echo $Unidad; ?></td>
    </tr>
    
    <?php
$fecha_ini = $AnoIni.'-'.$MesIni.'-'.$DiaIni;
$fecha_ter = $AnoFin.'-'.$MesFin.'-'.$DiaFin;

$fecha_aux = $fecha_ini;
$Cont = 0;
$TotalPHum = 0;
$TotalPSeco = 0;
$TotalCant = 0;
$TotalCu = 0;
$TotalAs = 0;
$TotalSb = 0;
$TotalFe = 0;
$TotalNi = 0;
$TotalPb = 0;
while(date($fecha_aux) <= date($fecha_ter)) //Recorre los dias.
{
		$dia = substr($fecha_aux,8,2);
		$Consulta = "SELECT t1.fecha_produccion,sum(t1.peso_produccion) as peso_produccion, sum(t1.peso_tara) as peso_tara, count(*) as cant ";
		$Consulta.= " from sec_web.produccion_catodo t1"; 
		$Consulta.= " where t1.cod_producto = '".$Producto."' ";
		$Consulta.= " and t1.cod_subproducto = '".$SubProducto."' ";
		$Consulta.= " and t1.fecha_produccion ='".$fecha_aux."'";
		$Consulta=$Consulta." group by fecha_produccion";		
		$Rs = mysqli_query($link, $Consulta);
		while($Fila = mysqli_fetch_array($Rs))
		{
			$Consulta = "SELECT t2.nro_solicitud,ifnull(t3.valor,0)as valor";
			$Consulta.= " from cal_web.solicitud_analisis t2 ";
			$Consulta.= " inner join cal_web.leyes_por_solicitud t3 on t2.fecha_hora=t3.fecha_hora ";
			$Consulta.= " and t2.nro_solicitud=t3.nro_solicitud and t3.cod_producto=t2.cod_producto ";
			$Consulta.= " and t3.cod_subproducto=t2.cod_subproducto ";
			$Consulta.= " where t2.cod_producto = '".$Producto."' ";
			$Consulta.= " and t2.cod_subproducto = '".$SubProducto."' ";
			$Consulta.= " and left(t2.fecha_muestra,10) ='".$fecha_aux."'";
			$Consulta.= " AND t2.cod_periodo = '1'"; //DIARIO
			$Consulta.= " AND t2.cod_analisis = '1'"; //QUIMICO
			$Consulta.= " AND t2.tipo = '1'"; //NORMAL
			$Consulta.= " AND (t2.estado_actual <> '7' and t2.estado_actual <> '16')"; // <> ELIMINADA,ANULADA
			$Consulta.= " and t3.cod_leyes='01' ";
			$Rs2 = mysqli_query($link, $Consulta);
			if($Fila2 = mysqli_fetch_array($Rs2))
			{
				$NroSA = $Fila2["nro_solicitud"];
				$PorcHum = $Fila2["valor"];
			}
			else
			{
				$NroSA = "";
				$PorcHum = 0;
			}
			echo'<tr>';
			  echo'<td align="center">'.$Fila[fecha_produccion].'</td>';
			  echo'<td align="center">'.$Fila["cant"].'</td>';
			  $TotalCant = $TotalCant + $Fila["cant"];
			  $CantSemana = $CantSemana + $Fila["cant"];
			  echo'<td align="center">'.number_format($Fila[peso_produccion]-$Fila["peso_tara"],0,",",".").'</td>';
			  if ($NroSA == "")
			  	echo'<td align="center">&nbsp;</td>';
			  else
			  	echo'<td align="center">'.$NroSA.'</td>';
			  echo'<td align="center">'.number_format($PorcHum,2,",",".").'</td>';					  
			  $PesoHum = (($Fila[peso_produccion]-$Fila["peso_tara"])*$PorcHum)/100;
			  $PesoSeco = ($Fila[peso_produccion]-$Fila["peso_tara"]) - $PesoHum;
			  $TotalPHum = $TotalPHum + ($Fila[peso_produccion]-$Fila["peso_tara"]);
			  $TotalPSeco = $TotalPSeco + $PesoSeco;
			  echo'<td align="center">'.number_format($PesoSeco,0,",",".").'</td>';
			  echo'<td align="center">&nbsp;</td>';
			  echo'<td align="center">&nbsp;</td>';
			  echo'<td align="center">&nbsp;</td>';
			  echo'<td align="center">&nbsp;</td>';
			  echo'<td align="center">&nbsp;</td>';
			  echo'<td align="center">&nbsp;</td>';

			  //Vars. Acumuladores
			  $Cont++;
			  $SumUnid = $SumUnid + $row[unid];
			  $SumPesoHumedo = $SumPesoHumedo + ($Fila[peso_produccion]-$Fila["peso_tara"]);
			  $AcumHumedad = $AcumHumedad + number_format($Fila2["valor"],2,".","");
			  $SumPesoSeco = $SumPesoSeco + number_format($PesoSeco,0,"","");				  	
			  
			 
			  }
 			 if($dia == '07' || $dia == '14' || $dia == '21' || $dia == '30')
			  {  	
					if ($dia == 7)
					{
						$Fecha1 = $AnoFin."-".$MesFin."-01";					
						$Fecha2 = $AnoFin."-".$MesFin."-07";
					}
					else
					{
						if ($dia == 14)
						{					
							$Fecha1 = $AnoFin."-".$MesFin."-08";					
							$Fecha2 = $AnoFin."-".$MesFin."-14";
						}
						else
						{
							if ($dia == 21)
							{					
								$Fecha1 = $AnoFin."-".$MesFin."-15";					
								$Fecha2 = $AnoFin."-".$MesFin."-21";
							}
							else
							{
								if (($dia >= 22) && ($dia <= 31))
								{				
									$Fecha1 = $AnoFin."-".$MesFin."-22";					
									$Fecha2 = $AnoFin."-".$MesFin."-31";
								}
							}							
						}								
					}	
				  /* desde aqui  */
				  $ConsultaN = "SELECT distinct t1.nro_solicitud as solicitud ";
				  $ConsultaN.= " FROM cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t2";
				  $ConsultaN.= " on t1.fecha_hora = t2.fecha_hora and t1.rut_funcionario = t2.rut_funcionario and ";
				  $ConsultaN.= " t1.nro_solicitud = t2.nro_solicitud and t1.recargo = t2.recargo ";
				  $ConsultaN.= " WHERE t1.cod_producto = ".$Producto."";
				  $ConsultaN.= " AND t1.cod_subproducto = ".$SubProducto." ";
				  $ConsultaN.= " AND t1.fecha_muestra between '".$Fecha1." 00:00:00' and '".$Fecha2." 23:59:59'";
				  $ConsultaN.= " AND t2.cod_leyes IN('02','08','09','31','36','39')"; 
				  $ConsultaN.= " AND t1.cod_periodo = '2'"; //SEMANAL
				  $ConsultaN.= " AND t1.cod_analisis = '1'"; //QUIMICO
				  $ConsultaN.= " AND t1.tipo = '1'"; //NORMAL
				  $ConsultaN.= " AND (t1.estado_actual <> '7' and t1.estado_actual <> '16')"; // <> ELIMINADA,ANULADA
				  $ConsultaN.= " ORDER BY t2.cod_leyes";	
				  $RspN = mysqli_query($link, $ConsultaN);
				  while ($FilaN = mysqli_fetch_array($RspN))
				  {
				  /* hasta aqui */	
				  	$Consulta = "SELECT t1.nro_solicitud, t2.cod_leyes, t2.valor ";
				  	$Consulta.= " FROM cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t2";
				  	$Consulta.= " on t1.fecha_hora = t2.fecha_hora and t1.rut_funcionario = t2.rut_funcionario and ";
				  	$Consulta.= " t1.nro_solicitud = t2.nro_solicitud and t1.recargo = t2.recargo ";
				  	$Consulta.= " WHERE  t1.nro_solicitud = ".$FilaN[solicitud]." and t1.cod_producto = ".$Producto."";
				  	$Consulta.= " AND t1.cod_subproducto = ".$SubProducto." ";
				  	$Consulta.= " AND t1.fecha_muestra between '".$Fecha1." 00:00:00' and '".$Fecha2." 23:59:59'";
				  	$Consulta.= " AND t2.cod_leyes IN('02','08','09','31','36','39')"; 
				  	$Consulta.= " AND t1.cod_periodo = '2'"; //SEMANAL
				  	$Consulta.= " AND t1.cod_analisis = '1'"; //QUIMICO
				  	$Consulta.= " AND t1.tipo = '1'"; //NORMAL
				  	$Consulta.= " AND (t1.estado_actual <> '7' and t1.estado_actual <> '16')"; // <> ELIMINADA,ANULADA
				  	$Consulta.= "  ORDER BY t2.cod_leyes";	
				  	$Result = mysqli_query($link, $Consulta);
				  	$Result2 = mysqli_query($link, $Consulta);
				  	$Fil = mysqli_fetch_array($Result2);
					
				  //Acumuladores
				  	echo'<tr class="detalle01">';
				  	echo'<td>Total Semana</td>';
				  	echo'<td align="center">'.$CantSemana.'</td>';
				  	echo'<td align="center">'.number_format($SumPesoHumedo,0,",",".").'</td>';
				  	echo'<td align="center">'.$Fil["nro_solicitud"].'</td>';
				  	if ($AcumHumedad<>0)
				  	{
				  		echo'<td align="center">'.number_format($AcumHumedad/$Cont,2,",",".").'</td>';
				  	}
				  	else
				  	{
				  		echo'<td align="center">'.number_format($AcumHumedad,2,",",".").'</td>';
				  	}
				  	echo'<td align="center">'.number_format($SumPesoSeco,0,",",".").'</td>';						

				  //Leyes-Finos
				  	$Cant = 0;
					$var10 = 0;
					$j = 0;
					$c = 0;	
				  	while($FILA = mysqli_fetch_array($Result))
				  	{
						$j++;
						switch ($FILA["cod_leyes"])
						{
							case "02":
								$c = 1;										
								$TotalCu = $TotalCu + ($SumPesoSeco * $FILA["valor"])/100;
								break;
							case "08":
								$c = 2;
								$TotalAs = $TotalAs + ($SumPesoSeco * $FILA["valor"])/100;
								break;
							case "09":
								$c = 3;
								$TotalSb = $TotalSb + ($SumPesoSeco * $FILA["valor"])/100;
								break;
							case "31":
								$c = 4;
								$TotalFe = $TotalFe + ($SumPesoSeco * $FILA["valor"])/100;
								break;
							case "36":
								$c = 5;
								$TotalNi = $TotalNi + ($SumPesoSeco * $FILA["valor"])/100;
								break;
							case "39":
								$c = 6;
								$TotalPb = $TotalPb + ($SumPesoSeco * $FILA["valor"])/100;
								break;
						}		
						if($FinoLeyes == "L")
						{
							if($c>$j)
							{
								$j = $c;
								echo'<td align="center">'.number_format($var10,2,",",".").'</td>';
								echo'<td align="center">'.number_format($FILA["valor"],2,",",".").'</td>';
							}
							else
							{
								echo'<td align="center">'.number_format($FILA["valor"],2,",",".").'</td>';
							}
						}
						else
						{  
							if($FILA["cod_leyes"] == '02')
							{
								$Fino = ($SumPesoSeco * $FILA["valor"])/100;
								echo'<td align="center">'.number_format($Fino,0,",",".").'</td>';
							}
							else
							{
								$Fino = ($SumPesoSeco * $FILA["valor"])/100;										
								echo'<td align="center">'.number_format($Fino,3,",",".").'</td>';
							}
						}
						$Cant++;								
				  }
				  if ($Cant>0)
				  {						
					  for ($j=0;$j<6-$Cant;$j++)
					  {
						 echo "<td align='right'>&nbsp;</td>";	
					  }
				  }
				  else
				  {
					  for ($j=0;$j<6;$j++)
					  {
						 echo "<td align='right'>&nbsp;</td>";	
					  }
				  }	
				   //Acumuladores
				 /*  $SumUnid = '';
				   $SumPesoHumedo = '';
				   $AcumHumedad = '';
				   $SumPesoSeco = '';
				   $Cont = 0;
				   $CantSemana = 0;*/
			echo'</tr>';
			}
			//Acumuladores
			$SumUnid = '';
			$SumPesoHumedo = '';
			$AcumHumedad = '';
			$SumPesoSeco = '';
			$Cont = 0;
			$CantSemana = 0;

		}

		$consulta = "SELECT DATE_ADD('".$fecha_aux."',INTERVAL 1 DAY) AS fecha";
		$rs10 = mysqli_query($link, $consulta);
		$row10 = mysqli_fetch_array($rs10);
		$fecha_aux = $row10["fecha"];						
}
?>
<tr>
      <td align="center"><strong>TOTAL</strong></td>
      <td align="center"><?php echo number_format($TotalCant,0,",","."); ?></td>
      <td align="center"><?php echo number_format($TotalPHum,0,",","."); ?></td>
      <td align="center">&nbsp;</td>
      <td align="center"><?php echo number_format((($TotalPHum-$TotalPSeco)*100)/$TotalPHum,2,",","."); ?></td>
      <td align="center"><?php echo number_format($TotalPSeco,0,",","."); ?></td>
      <td align="center"><?php 
	  	
	  	if($FinoLeyes == "L")
	  		echo number_format((($TotalCu/$TotalPSeco)*100),2,",","."); 
		else
			echo number_format($TotalCu,2,",","."); 
		?></td>
      <td align="center"><?php 
	  	if($FinoLeyes == "L")
	 		echo number_format((($TotalAs/$TotalPSeco)*100),2,",","."); 
		else
			echo number_format($TotalAs,2,",","."); 
			?></td>
      <td align="center"><?php 
	  	if($FinoLeyes == "L")
			echo number_format((($TotalSb/$TotalPSeco)*100),2,",","."); 
		else
			echo number_format($TotalSb,2,",","."); 
			?></td>
      <td align="center"><?php 
	  	if($FinoLeyes == "L")
			echo number_format((($TotalFe/$TotalPSeco)*100),2,",","."); 
		else
			echo number_format($TotalFe,2,",","."); 
			?></td>
      <td align="center"><?php 
	  	if($FinoLeyes == "L")
			echo number_format((($TotalNi/$TotalPSeco)*100),2,",","."); 
		else
			echo number_format($TotalNi,2,",","."); 
			?></td>
      <td align="center"><?php 
	  	if($FinoLeyes == "L")
			echo number_format((($TotalPb/$TotalPSeco)*100),2,",","."); 
		else
			echo number_format($TotalPb,2,",","."); 
			?></td>
    </tr>
  </table>
</form>
</body>
</html>
