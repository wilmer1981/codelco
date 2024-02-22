<?
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	include("conectar.php");
?>
<html>
<head>
<title>Datos Finales - Anodos Rechazados</title>
<style type="text/css">
<!--
.Estilo1 {font-size: 10px}
.Estilo2 {font-family: Verdana, Arial, Helvetica, sans-serif}
-->
</style>
<link href="css_principal.css" rel="stylesheet" type="text/css">
<body>
<form name="form1" method="post" action="">
<table width="770" border="0" class="TablaPrincipal">
  <tr>
    <td width="924">
      <br>
	  <br>
	  
	  <table width="577" border="1" align="center" class="TablaDetalle">
        <tr align="center" class="ColorTabla01">
          <td colspan="4"><span class="Estilo1">ANODOS RECHAZADOS </span></td>
          </tr>
        <tr class="ColorTabla01">
          <td width="132"><span class="Estilo1">PESO SECO (Kg) </span></td>
          <td width="136">FINO COBRE (Kg) </td>
          <td width="140">FINO PLATA (gr) </td>
          <td width="141">FINO ORO (gr) </td>
		  
		  <?
		  $FechaIni=$ano."-".$mes."-01";
		  $FechaFin=$ano2."-".$mes2."-01";
		  if ($buscarOPT=="S")
		  {
		  			
					$consultar= "SELECT SUM(P_SECO) AS PESOSEECO, SUM(F_COBRE) AS FINOCOBRE,SUM(F_PLATA) AS FINOPLATA, SUM(F_ORO) AS FINORO FROM enabal WHERE ((T_MOV='2') AND (N_FLUJO='404' OR N_FLUJO='402' OR N_FLUJO='145') AND FECHA BETWEEN '$FechaIni' AND '$FechaFin') ORDER BY N_FLUJO";
					$resultados = mysql_query($consultar);
				while($lineas=mysql_fetch_array($resultados))
					{
						echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>" ;
						echo "<td>".$formato=number_format($lineas[PESOSECO],'0',',','.')."</td>";
						echo "<td>".$formato=number_format($lineas[FINOCOBRE],'0',',','.')."</td>";
						echo "<td>".$formato=number_format($lineas[FINOPLATA],'0',',','.')."</td>";
						echo "<td>".$formato=number_format($lineas[FINORO],'0',',','.')."</td>";
						echo "</tr>";
						if($lineas[PESOSECO]==0)
							{
								$uno=0;$dos=0;$tres=0;				
							}
						else
							{
								$uno=$lineas[FINOCOBRE]/$lineas[PESOSECO]*100;
								$dos=$lineas[FINOPLATA]/$lineas[PESOSECO]*1000;
								$tres=$lineas[FINORO]/$lineas[PESOSECO]*1000;						
							}
					echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>" ;
					echo "<td>LEY</td>";
					echo "<td>".$english_format_number = number_format($uno, 2, ',', '')."</td>";
					echo "<td>".$english_format_number = number_format($dos, 3, ',', '')."</td>";
					echo "<td>".$english_format_number = number_format($tres, 3, ',', '')."</td>";
					echo "</tr>";
				}
		  }
		  ?>
        </tr>
      </table>
	  <br>
	  <br>
	  <table width="700" border="1" align="center">
        <tr align="center" class="ColorTabla01">
          <td width="154"><span class="Estilo2">Fecha</span></td>
          <td width="42"><span class="Estilo2"> Flujo </span></td>
          <td width="298"><span class="Estilo2">Nombre Producto </span></td>
          <td width="99"><span class="Estilo2">Peso Seco (Kg) </span></td>
          <td width="78"><span class="Estilo2">Fino Cobre (Kg) </span></td>
          <td width="81"><span class="Estilo2">Fino Plata (gr) </span></td>
          <td width="70"><span class="Estilo2">Fino Oro (gr) </span></td>
		  <?
		  if ($buscarOPT=="S")
		  {			
				$consultas= "SELECT DISTINCT FECHA FROM enabal WHERE ((T_MOV='2') AND (N_FLUJO='404' OR N_FLUJO='402' OR N_FLUJO='145') AND FECHA BETWEEN '$FechaIni' AND '$FechaFin')";
				//echo $consultas."<br>";
				$RespFecha = mysql_query($consultas);
				while($FilaFecha=mysql_fetch_array($RespFecha))
				{
					$TotMesPSeco=0;$TotMesFCobre=0;$TotMesFPlata=0;$TotMesFOro=0;
					$consultas= "SELECT * FROM enabal WHERE ((T_MOV='2') AND (N_FLUJO='404' OR N_FLUJO='402' OR N_FLUJO='145') AND FECHA ='$FilaFecha[FECHA]')";
					$resultados = mysql_query($consultas);
					while($codigo=mysql_fetch_array($resultados))
					{
							echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>" ;
							echo "<td>".$codigo[FECHA]."</td>";
							echo "<td>".$codigo[N_FLUJO]."</td>";
							echo "<td>".$codigo[NOM_PRODUCTO]."</td>";
							echo "<td>".$formato=number_format($codigo[P_SECO],'0',',','.')."</td>";
							echo "<td>".$formato=number_format($codigo[F_COBRE],'0',',','.')."</td>";
							echo "<td>".$formato=number_format($codigo[F_PLATA],'0',',','.')."</td>";
							echo "<td>".$formato=number_format($codigo[F_ORO],'0',',','.')."</td>";
							$TotMesPSeco=$TotMesPSeco+$codigo[P_SECO];
							$TotMesFCobre=$TotMesFCobre+$codigo[F_COBRE];
							$TotMesFPlata=$TotMesFPlata+$codigo[F_PLATA];
							$TotMesFOro=$TotMesFOro+$codigo[F_ORO];
							echo "</tr>";
							echo"<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>";
							echo"</tr>";
					}
					echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFFF' align='center'>" ;
					echo "<td colspan='3' align='right'>TOTALES</td>";
					echo "<td>".$formato=number_format($TotMesPSeco,'0',',','.')."</td>";
					echo "<td>".$formato=number_format($TotMesFCobre,'0',',','.')."</td>";
					echo "<td>".$formato=number_format($TotMesFPlata,'0',',','.')."</td>";
					echo "<td>".$formato=number_format($TotMesFOro,'0',',','.')."</td>";
					echo "</tr>";
					echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFFF' align='center'>" ;
					echo "<td colspan='3' align='right'>LEY</td>";
					
					if($TotMesPSeco>0)
					{
					echo"<td></td>";
					echo "<td>".$formato=number_format(($TotMesFCobre*100)/$TotMesPSeco,'2',',','.')."</td>";
					echo "<td>".$formato=number_format(($TotMesFPlata*1000)/$TotMesPSeco,'3',',','.')."</td>";
					echo "<td>".$formato=number_format(($TotMesFOro*1000)/$TotMesPSeco,'3',',','.')."</td>";
					
					}
					else{
					
					echo "<td> 0 </td>";
					echo "<td> 0 </td>";//echo "<td>".$formato=number_format(($TotMesFPlata*1000)/$TotMesPSeco,'3',',','.')."</td>";
					echo "<td> 0 </td>";//echo "<td>".$formato=number_format(($TotMesFOro*1000)/$TotMesPSeco,'3',',','.')."</td>";
					echo "</tr>";
					
					}
					//echo "<tr> </tr>";
				}	
		  }
		  ?>
        </tr>
      </table>    
	
  </tr>
</table>
</form>
</body>
</html>
