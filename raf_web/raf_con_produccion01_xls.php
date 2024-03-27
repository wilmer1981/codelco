<?
 header("Content-Type:application/vnd.ms-excel");
 header("Expires:0");
 header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
include("../principal/conectar_raf_web.php");

$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			

if(strlen($Mes) == 1)
	$Mes = '0'.$Mes;
	
	$HornadaIni = $Ano.$Mes.'1000';
	$HornadaTer = $Ano.$Mes.'1999';

$Fecha = $Ano.'-'.$Mes;
?>
<html>
<head>
<title>Sistema RAF</title>
</head>

<body>
<form name="FrmPrincipal" method="post" action="">
  <table width="300" align="center" border="1" cellspacing="0" cellpadding="0" class="TablaDetalle">
    <tr> 
      <td align="center" colspan="23">P R O D U C C I O N&nbsp;&nbsp;E N&nbsp;&nbsp; R A F</td>
	</tr>	
  </table>
  <br>
  <table width="150" align="center" border="1" cellspacing="0" cellpadding="0" class="TablaDetalle">
    <tr> 
      <td colspan="23">Periodo : <? echo ucwords(strtolower($Meses[$Mes - 1])).' '.$Ano?></td>
	</tr>	
  </table>
  <br>
  <table width="1000" border="1" cellspacing="0" cellpadding="0" class="TablaDetalle">
    <tr class="ColorTabla02">
      <td colspan="23">Producci&oacute;n Refino # 1</td>
    </tr>
    <tr class="ColorTabla01"> 
      <td width="52" align="center">Fecha</td>
      <td align="center">N&deg;</td>
      <td colspan="3" align="center">Produccion Anodos</td>
      <td colspan="5" align="center">Circulantes</td>
      <td colspan="6" align="center">Tiempo (Hrs)</td>
      <td colspan="6" align="center">Combustible(m3) </td>
      <td width="55" align="center">Troncos</td>
    </tr>
    <tr class="ColorTabla01"> 
      <td align="center">Carga</td>
      <td align="center">Horn</td>
      <td width="51" align="center">Com</td>
      <td width="54" align="center">H.Madres</td>
      <td width="54" align="center">Total</td>
      <td width="52" align="center">Cu.An.Ci</td>
      <td width="62" align="center">Moldes</td>
      <td width="27" align="center">Esc.Rev</td>
      <td width="41" align="center">Oxid.Cu</td>
      <td width="44" align="center">Total</td>
      <td width="66" align="center">Carg/fus.</td>
      <td width="55" align="center">Reducc</td>
      <td width="44" align="center">Escor</td>
      <td width="63" align="center">Moldeo</td>
      <td width="46" align="center">Vacio</td>
      <td width="44" align="center">Total</td>
      <td width="66" align="center">Carg/Fus.</td>
      <td width="45" align="center">Reducc.</td>
      <td width="32" align="center">Escor.</td>
      <td width="28" align="center">Moldeo</td>
      <td width="14" align="center">Vacio</td>
      <td width="15" align="center">Total</td>
      <td align="center">Unid</td>
    </tr>
    <?
		$Consulta = "SELECT distinct hornada FROM raf_web.datos_operacionales WHERE left(fecha,7) = '$Fecha'";
		$Consulta.= " AND hornada BETWEEN $HornadaIni AND $HornadaTer";
		$resp = mysqli_query($link, $Consulta);
		while($Fila = mysql_fetch_array($resp))
		{			
		    $Consulta = "SELECT MIN(fecha) as fecha FROM raf_web.datos_operacionales";
		    $Consulta.= " WHERE hornada = $Fila["hornada"]";	
		    $respuesta = mysqli_query($link, $Consulta);
			$fila = mysql_fetch_array($respuesta);
			$Fecha = substr($fila["fecha"],0,10);
			$Dia = substr($fila["fecha"],8,2);
			$Ano = substr($fila["fecha"],0,4);
			$Mes = substr($fila["fecha"],5,2);					  						
			$Fecha_Post = date("Y-m-d",mktime(7,59,59,$Mes,($Dia + 1),$Ano));
			//$fecha = substr($fila["fecha"],5,5);
			$fecha1 = substr($fila["fecha"],0,10);
			$fecha = $Dia."-".$Mes."-".$Ano;

			$hornada = substr($Fila["hornada"],6,4);
			$CargaDiaria = '';
			echo'<tr>';
			  echo "<td align='center'>".substr($fecha,0,2)."/".substr($fecha,3,2)."</td>";
			  echo'<td align="center">'.$hornada.'</td>';

			  $Consulta = "SELECT * FROM raf_web.datos_operacionales";	
		      $Consulta.= " WHERE tipo_report = 2 AND seccion_report = 'C2' AND campo1 = '1' AND hornada = ".$Fila["hornada"];
			  $rs = mysqli_query($link, $Consulta);
			  $fil = mysql_fetch_array($rs);
			  echo "<td align='right'>".number_format($fil[campo3],0,",",".")."</td>\n";
			  $AcumCom = $AcumCom + $fil[campo3];
			  
			  $Consulta = "SELECT * FROM raf_web.datos_operacionales";	
		      $Consulta.= " WHERE tipo_report = 2 AND seccion_report = 'C2' AND campo1 = '3' AND hornada = ".$Fila["hornada"];
			  $rs = mysqli_query($link, $Consulta);
			  $fil = mysql_fetch_array($rs);
			  echo "<td align='right'>".number_format($fil[campo3],0,",",".")."</td>\n";
			  $AcumHm = $Acumhm + $fil[campo3];

			  //Total Prod. Anodos	
			  $Consulta = "SELECT sum(campo3) as total FROM raf_web.datos_operacionales";	
		      $Consulta.= " WHERE tipo_report = 2 AND seccion_report = 'C2' AND hornada = ".$Fila["hornada"];
			  $rs = mysqli_query($link, $Consulta);
			  $fil = mysql_fetch_array($rs);
			  $total = $fil["total"];			  
			 echo "<td align='right'>".number_format($total,0,",",".")."</td>\n";
			  $AcumTotal_1 = $AcumTotal_1 + $total;

			  $Consulta = "SELECT SUM(peso) as peso FROM raf_web.det_carga WHERE hornada = ".$Fila["hornada"];
			  $Consulta.= " AND cod_producto = 42 AND cod_subproducto = 74";	
			  $res = mysqli_query($link, $Consulta);
			  $fil = mysql_fetch_array($res);
			  $AnodCirc = $fil["peso"];			 	

			  echo "<td align='right'>".number_format($AnodCirc,0,",",".")."</td>\n";
			  $AcumAnodCirc = $AcumAnodCirc + $AnodCirc;

			  $Consulta = "SELECT SUM(peso) as peso FROM raf_web.det_carga WHERE hornada = ".$Fila["hornada"];
			  $Consulta.= " AND cod_producto = 42 AND cod_subproducto = 73";
			  $res = mysqli_query($link, $Consulta);
			  $fil = mysql_fetch_array($res);
              if($fil["peso"] != '') 			
				  $Moldes = $fil["peso"]; // * 1850;			 	
			  echo "<td align='right'>".number_format($Moldes,0,",",".")."</td>\n";
			  $AcumMoldes = $AcumMoldes + $Moldes;

			  $Consulta = "SELECT SUM(peso) as peso FROM raf_web.det_carga WHERE hornada = ".$Fila["hornada"];
			  $Consulta.= " AND cod_producto = 42 AND cod_subproducto = 31";	
			  $res = mysqli_query($link, $Consulta);
			  $fil = mysql_fetch_array($res);
			  $Esc = $fil["peso"];			 	
			  echo "<td align='right'>".number_format($EscRev,0,",",".")."</td>\n";
			  $AcumEscRev = $AcumEscRev + $EscRev;

			  echo "<td align='right'>".number_format($OxidCu,0,",",".")."</td>\n";

			  $Total = $total + $AnodCirc + $Moldes + $EscRev + $OxidCu;	
			  echo "<td align='right'>".number_format($Total,0,",",".")."</td>\n";
			  $AcumTotal_2 = $AcumTotal_2 + $Total;

			  //T C.Fusion	
			  $Consulta = "SELECT hora_ini, hora_ter FROM raf_web.datos_operacionales";	
		      $Consulta.= " WHERE tipo_report = 2 AND seccion_report = 'A1' AND hornada = ".$Fila["hornada"];
			  $rs = mysqli_query($link, $Consulta);
			  while($fil = mysql_fetch_array($rs))
			  {
				 $hh =  substr($fil[hora_ter],0,2) - substr($fil[hora_ini],0,2);	
			     $mm =  substr($fil[hora_ter],3,2) - substr($fil[hora_ini],3,2);	

				 $real = date("H:i",mktime($hh,$mm));	  

			     $mm =  abs(((substr($real,0,2) * 60) + substr($real,3,2)));		  

				 $AcumMM = $AcumMM + $mm;
			  }
				 $AcumHora = $AcumMM/60;
				 $AcumTotalHora = $AcumTotalHora + $AcumMM;				  
			  echo "<td align='right'>".number_format($AcumHora,2,",",".")."</td>\n";
              $AcumFusion = $AcumFusion + $AcumHora;

			  //T Reducc
			  $Consulta = "SELECT hora_ini, hora_ter FROM raf_web.datos_operacionales";	
		      $Consulta.= " WHERE tipo_report = 2 AND seccion_report = 'B1' AND campo1 = '4' AND hornada = ".$Fila["hornada"];
			  $rs = mysqli_query($link, $Consulta);
			  $AcumMM = 0;
			  while($fil = mysql_fetch_array($rs))
			  {
				 $hh =  substr($fil[hora_ter],0,2) - substr($fil[hora_ini],0,2);	
			     $mm =  substr($fil[hora_ter],3,2) - substr($fil[hora_ini],3,2);	

				 $real = date("H:i",mktime($hh,$mm));	  

			     $mm =  abs(((substr($real,0,2) * 60) + substr($real,3,2)));		  

				 $AcumMM = $AcumMM + $mm;
			  }
				 $AcumHora = $AcumMM/60;				  
				 $AcumTotalHora = $AcumTotalHora + $AcumMM;				  

			  echo "<td align='right'>".number_format($AcumHora,2,",",".")."</td>\n";
              $AcumReduc = $AcumReduc + $AcumHora;

			  //T Escoreo
			  $Consulta = "SELECT hora_ini, hora_ter FROM raf_web.datos_operacionales";	
		      $Consulta.= " WHERE tipo_report = 2 AND seccion_report = 'B1' AND campo1 = '2' AND hornada = ".$Fila["hornada"];
			  $rs = mysqli_query($link, $Consulta);
			  $AcumMM = 0;
			  while($fil = mysql_fetch_array($rs))
			  {
				 $hh =  substr($fil[hora_ter],0,2) - substr($fil[hora_ini],0,2);	
			     $mm =  substr($fil[hora_ter],3,2) - substr($fil[hora_ini],3,2);	

				 $real = date("H:i",mktime($hh,$mm));	  

			     $mm =  abs(((substr($real,0,2) * 60) + substr($real,3,2)));		  

				 $AcumMM = $AcumMM + $mm;
			  }
				 $AcumHora = $AcumMM/60;				  
				 $AcumTotalHora = $AcumTotalHora + $AcumMM;				  

			  echo "<td align='right'>".number_format($AcumHora,2,",",".")."</td>\n";
              $AcumEsc = $AcumEsc + $AcumHora;

			  //T Moldeo
			  $Consulta = "SELECT hora_ini, hora_ter FROM raf_web.datos_operacionales";	
		      $Consulta.= " WHERE tipo_report = 2 AND seccion_report = 'B1' AND campo1 = '6' AND hornada = ".$Fila["hornada"];
			  $rs = mysqli_query($link, $Consulta);
			  $AcumMM = 0;
			  while($fil = mysql_fetch_array($rs))
			  {
				 $hh =  substr($fil[hora_ter],0,2) - substr($fil[hora_ini],0,2);	
			     $mm =  substr($fil[hora_ter],3,2) - substr($fil[hora_ini],3,2);	

				 $real = date("H:i",mktime($hh,$mm));	  

			     $mm =  abs(((substr($real,0,2) * 60) + substr($real,3,2)));		  

				 $AcumMM = $AcumMM + $mm;
			  }
				 $AcumHora = $AcumMM/60;				  
				 $AcumTotalHora = $AcumTotalHora + $AcumMM;				  

			  echo "<td align='right'>".number_format($AcumHora,2,",",".")."</td>\n";
              $AcumMoldeo = $AcumMoldeo + $AcumHora;

			  //T Vacio
			  $Consulta = "SELECT hora_ini, hora_ter FROM raf_web.datos_operacionales";	
		      $Consulta.= " WHERE tipo_report = 2 AND seccion_report = 'B1' AND campo1 = '7' AND hornada = ".$Fila["hornada"];
			  $rs = mysqli_query($link, $Consulta);
			  $AcumMM = 0;
			  while($fil = mysql_fetch_array($rs))
			  {
				 $hh =  substr($fil[hora_ter],0,2) - substr($fil[hora_ini],0,2);	
			     $mm =  substr($fil[hora_ter],3,2) - substr($fil[hora_ini],3,2);	

				 $real = date("H:i",mktime($hh,$mm));	  

			     $mm =  abs(((substr($real,0,2) * 60) + substr($real,3,2)));		  

				 $AcumMM = $AcumMM + $mm;
			  }
				 $AcumHora = $AcumMM/60;				  
				 $AcumTotalHora = $AcumTotalHora + $AcumMM;				  

			  echo "<td align='right'>".number_format($AcumHora,2,",",".")."</td>\n";
              $AcumVacio = $AcumVacio + $AcumHora;

			  $AcumTotalHora = $AcumTotalHora/60;				  
			  echo "<td align='right'>".number_format($AcumTotalHora,2,",",".")."</td>\n";
			  $AcumTotal_3 = $AcumTotal_3 + $AcumTotalHora;				  

			  //Combus. C.Fusion
			  $Consulta = "SELECT sum(campo2) comb1, sum(campo3) comb2 FROM raf_web.datos_operacionales";	
		      $Consulta.= " WHERE tipo_report = 2 AND seccion_report = 'C1' AND campo1 BETWEEN 1 AND 6 AND hornada = ".$Fila["hornada"];
			  $rs = mysqli_query($link, $Consulta);
			  $AcumComb = 0;
			  if($fil = mysql_fetch_array($rs))
			  {
				  $AcumComb = abs($fil[comb1] - $fil[comb2]);	  	
				  $AcumFusion2 = $AcumFusion2 + $AcumComb;					
			  }
				 $AcumTotalComb = $AcumTotalComb + $AcumComb;				  

			  echo "<td align='right'>".number_format($AcumComb,0,",",".")."</td>\n";
			  //Combus. Reducc
			  $Consulta = "SELECT sum(campo2) comb1, sum(campo3) comb2 FROM raf_web.datos_operacionales";	
		      $Consulta.= " WHERE tipo_report = 2 AND seccion_report = 'C1' AND campo1 = 10 AND hornada = ".$Fila["hornada"];
			  $rs = mysqli_query($link, $Consulta);
			  $AcumComb = 0;
			  if($fil = mysql_fetch_array($rs))
			  {
				  $AcumComb = abs($fil[comb1] - $fil[comb2]);	  	
				  $AcumReduc2 = $AcumReduc2 + $AcumComb;					
					
			  }
				 $AcumTotalComb = $AcumTotalComb + $AcumComb;				  

			  echo "<td align='right'>".number_format($AcumComb,0,",",".")."</td>\n";

			  //Combus. Escoreo
			  $Consulta = "SELECT sum(campo2) comb1, sum(campo3) comb2 FROM raf_web.datos_operacionales";	
		      $Consulta.= " WHERE tipo_report = 2 AND seccion_report = 'C1' AND campo1 = 8 AND hornada = ".$Fila["hornada"];
			  $rs = mysqli_query($link, $Consulta);
			  $AcumComb = 0;
			  if($fil = mysql_fetch_array($rs))
			  {
				  $AcumComb = abs($fil[comb1] - $fil[comb2]);	  	
				  $AcumEsc2 = $AcumEsc2 + $AcumComb;					
					
			  }
				 $AcumTotalComb = $AcumTotalComb + $AcumComb;				  

			  echo "<td align='right'>".number_format($AcumComb,0,",",".")."</td>\n";

			  //Combus. Moldeo
			  $Consulta = "SELECT sum(campo2) comb1, sum(campo3) comb2 FROM raf_web.datos_operacionales";	
		      $Consulta.= " WHERE tipo_report = 2 AND seccion_report = 'C1' AND campo1 = 12 AND hornada = ".$Fila["hornada"];
			  $rs = mysqli_query($link, $Consulta);
			  $AcumComb = 0;
			  if($fil = mysql_fetch_array($rs))
			  {
				  $AcumComb = abs($fil[comb1] - $fil[comb2]);	  	
				  $AcumMoldeo2 = $AcumMoldeo2 + $AcumComb;					
					
			  }
				 $AcumTotalComb = $AcumTotalComb + $AcumComb;				  

			  echo "<td align='right'>".number_format($AcumComb,0,",",".")."</td>\n";

			  //Combus. Vacio
			  $Consulta = "SELECT sum(campo2) comb1, sum(campo3) comb2 FROM raf_web.datos_operacionales";	
		      $Consulta.= " WHERE tipo_report = 2 AND seccion_report = 'C1' AND campo1 = 13 AND hornada = ".$Fila["hornada"];
			  $rs = mysqli_query($link, $Consulta);
			  $AcumComb = 0;
			  if($fil = mysql_fetch_array($rs))
			  {
				  $AcumComb = abs($fil[comb1] - $fil[comb2]);	  	
				  $AcumVacio2 = $AcumVacio2 + $AcumComb;					
					
			  }
				 $AcumTotalComb = $AcumTotalComb + $AcumComb;				  

			  echo "<td align='right'>".number_format($AcumComb,0,",",".")."</td>\n";

			  echo "<td align='right'>".number_format($AcumTotalComb,0,",",".")."</td>\n";
			
			  $AcumTotal_4 = $AcumTotal_4 + $AcumTotalComb;					

			  $Consulta = "SELECT sum(campo2) as troncos FROM raf_web.datos_operacionales";	
		      $Consulta.= " WHERE tipo_report = 2 AND seccion_report = 'B3' AND hornada = ".$Fila["hornada"];
			  $rs = mysqli_query($link, $Consulta);
			  if($fil = mysql_fetch_array($rs))
			  {
				  $Troncos = $fil[troncos];	  	
				  $AcumTroncos = $AcumTroncos + $Troncos;
			  }

 			  echo "<td align='right'>".number_format($Troncos,0,",",".")."</td>\n";
			echo'</tr>';
		}
    ?>
    <tr class="ColorTabla02"> 
      <td align="left" colspan="2"><b>TOTALES</b></td>
      <td align="right"><? echo number_format($AcumCom,0,",","."); ?></td>
      <td align="right"><? echo number_format($AcumHm,0,",","."); ?></td>
      <td align="right"><? echo number_format($AcumTotal_1,0,",","."); ?></td>
      <td align="right"><? echo number_format($AcumAnodCirc,0,",","."); ?></td>
      <td align="right"><? echo number_format($AcumMoldes,0,",","."); ?></td>
      <td align="right"><? echo number_format($AcumEscRev,0,",","."); ?></td>
      <td align="right"><? echo number_format($AcumOxidCu,0,",","."); ?></td>
      <td align="right"><? echo number_format($AcumTotal_2,0,",","."); ?></td>
      <td align="right"><? echo number_format($AcumFusion,2,",","."); ?></td>
      <td align="right"><? echo number_format($AcumReduc,2,",","."); ?></td>
      <td align="right"><? echo number_format($AcumEsc,2,",","."); ?></td>
      <td align="right"><? echo number_format($AcumMoldeo,2,",","."); ?></td>
      <td align="right"><? echo number_format($AcumVacio,2,",","."); ?></td>
      <td align="right"><? echo number_format($AcumTotal_3,2,",","."); ?></td>
      <td align="right"><? echo number_format($AcumFusion2,0,",","."); ?></td>
      <td align="right"><? echo number_format($AcumReduc2,0,",","."); ?></td>
      <td align="right"><? echo number_format($AcumEsc2,0,",","."); ?></td>
      <td align="right"><? echo number_format( $AcumMoldeo2,0,",","."); ?></td>
      <td align="right"><? echo number_format($AcumVacio2,0,",","."); ?></td>
      <td align="right"><? echo number_format($AcumTotal_4,0,",","."); ?></td>
      <td align="right" class="Detalle02"><? echo number_format($AcumTroncos,0,",","."); ?></td>
    </tr>
  </table>
  </form>

</body>
</html>
