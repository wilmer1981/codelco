<?
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	include("conectar.php");
?>
<html>
<head>
<title>Calcular Blister</title>
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
          <td colspan="4"><span class="Estilo1">CALCULO BLISTER NETO </span></td>
          </tr>
        <tr class="ColorTabla01">
          <td width="132"><span class="Estilo1">PESO SECO (Kg) </span></td>
          <td width="136">FINO COBRE (Kg) </td>
          <td width="140">FINO PLATA (gr) </td>
          <td width="141">FINO ORO (gr) </td>
		  
		  <?
		$FechaIni=$ano."-".$mes."-01";
			$FechaFin=$ano2."-".$mes2."-01";
		if($buscarOPT=="I")
		{		
		//SUMA DE OTROS FLUJOS (SE RESTA AL BLISTER TOTAL)
			$sql= "SELECT Sum(P_SECO) AS PESOSECO, Sum(F_COBRE) AS FINOCOBRE, Sum(F_PLATA) AS FINOPLATA, Sum(F_ORO) AS FINOORO from ENABAL where ((FECHA BETWEEN '$FechaIni' AND '$FechaFin') AND 
			(ENABAL.N_FLUJO=77 Or ENABAL.N_FLUJO=144 Or ENABAL.N_FLUJO=139 Or ENABAL.N_FLUJO=249 Or ENABAL.N_FLUJO=376 Or ENABAL.N_FLUJO=257 Or 
			ENABAL.N_FLUJO=88 Or ENABAL.N_FLUJO=150) AND (ENABAL.T_MOV=2))";
			
			
			//BLISTER TOTAL 
			$sqldos="SELECT Sum(P_SECO) AS Sseco, Sum(F_COBRE) AS Scobre, Sum(F_PLATA) AS Splata, Sum(F_ORO) AS Soro FROM ENABAL WHERE ((FECHA BETWEEN '$FechaIni' AND '$FechaFin') AND 
			ENABAL.N_FLUJO=40 AND ENABAL.T_MOV=2)";
						
			$resultados = mysql_query($sql);
			while($fila=mysql_fetch_array($resultados))
			{			
				$resultados2 = mysql_query($sqldos);
				while($fila2=mysql_fetch_array($resultados2))
				{													
					$pseco=$fila2[Sseco]-$fila[PESOSECO];
					$fcobre=$fila2[Scobre]-$fila[FINOCOBRE];
					$fplata=$fila2[Splata]-$fila[FINOPLATA];
					$foro=$fila2[Soro]-$fila[FINOORO];
					
					echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>" ;
					echo "<td>".$formato=number_format($pseco,'0',',','.')."</td>";
					echo "<td>".$formato=number_format($fcobre,'0',',','.')."</td>";
					echo "<td>".$formato=number_format($fplata,'0',',','.')."</td>";
					echo "<td>".$formato=number_format($foro,'0',',','.')."</td>";
					echo "</tr>";
					
					if($fila[PESOSECO]==0)
					{
						$uno=0;$dos=0;$tres=0;					
					}else{
						$uno=$fila2[Scobre]/$fila2[Sseco]*100;
						$dos=$fila2[Splata]/$fila2[Sseco]*1000;
						$tres=$fila2[Soro]/$fila2[Sseco]*1000;
					}
				
					echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>";
					echo "<td> LEYES </td>";
					echo "<td>".$english_format_number = number_format($uno, 2, ',', '')."</td>";
					echo "<td>".$english_format_number = number_format($dos, 3, ',', '')."</td>";
					echo "<td>".$english_format_number = number_format($tres, 3, ',', '')."</td>";
					echo "</tr>";											    				
	    		}
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
		  
		  $FechaIni=$ano."-".$mes."-01";
		  $FechaFin=$ano2."-".$mes2."-01";
	if ($buscarOPT=="I")
	{	  
	
		$consultas=  "SELECT DISTINCT FECHA FROM enabal WHERE  ((ENABAL.T_MOV='2' ) AND (ENABAL.N_FLUJO='40' Or ENABAL.N_FLUJO='77' Or ENABAL.N_FLUJO='144' Or ENABAL.N_FLUJO='139' Or ENABAL.N_FLUJO='249' Or ENABAL.N_FLUJO='376' Or ENABAL.N_FLUJO='257' Or ENABAL.N_FLUJO='88' Or ENABAL.N_FLUJO='150' ) AND (FECHA BETWEEN '$FechaIni' AND '$FechaFin'))";
		$RespFecha = mysql_query($consultas);
				while($FilaFecha=mysql_fetch_array($RespFecha))
					{
						$TotMesPSeco=0;$TotMesFCobre=0;$TotMesFPlata=0;$TotMesFOro=0;
						$consultas= "SELECT FECHA, T_MOV, N_FLUJO, NOM_PRODUCTO, P_SECO, F_COBRE, F_PLATA, F_ORO FROM ENABAL where ((FECHA='$FilaFecha["FECHA"]') AND
									(ENABAL.T_MOV='2') AND (ENABAL.N_FLUJO='40' Or ENABAL.N_FLUJO='77' Or ENABAL.N_FLUJO='144' Or ENABAL.N_FLUJO='139' Or ENABAL.N_FLUJO='249' Or ENABAL.N_FLUJO='376' 
									Or ENABAL.N_FLUJO='257' Or ENABAL.N_FLUJO='88' Or ENABAL.N_FLUJO='150' ))";
			
						$resultados = mysql_query($consultas);
						
						while($codigo=mysql_fetch_array($resultados))
							{
								echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFCC'>";
								echo "<td>".$codigo["FECHA"]."</td>";
								echo "<td>".$codigo[N_FLUJO]."</td>";
								echo "<td>".$codigo[NOM_PRODUCTO]."</td>";			
								echo "<td>".$formato=number_format($codigo[P_SECO],'0',',','.')."</td>";
								echo "<td>".$formato=number_format($codigo[F_COBRE],'0',',','.')."</td>";
								echo "<td>".$formato=number_format($codigo[F_PLATA],'0',',','.')."</td>";
								echo "<td>".$formato=number_format($codigo[F_ORO],'0',',','.')."</td>";
								echo "</tr>";
							}
						//SUMA DE OTROS FLUJOS (SE RESTA AL BLISTER TOTAL)
						
						$sql= "SELECT Sum(P_SECO) AS PESOSECO, Sum(F_COBRE) AS FINOCOBRE, Sum(F_PLATA) AS FINOPLATA, Sum(F_ORO) AS FINOORO from ENABAL WHERE ((FECHA='$FilaFecha["FECHA"]') AND 
						(ENABAL.N_FLUJO=77 Or ENABAL.N_FLUJO=144 Or ENABAL.N_FLUJO=139 Or ENABAL.N_FLUJO=249 Or ENABAL.N_FLUJO=376 Or ENABAL.N_FLUJO=257 Or 
						ENABAL.N_FLUJO=88 Or ENABAL.N_FLUJO=150) AND (ENABAL.T_MOV=2))";
				
				
						//BLISTER TOTAL 
						$sqldos="SELECT Sum(P_SECO) AS Sseco, Sum(F_COBRE) AS Scobre, Sum(F_PLATA) AS Splata, Sum(F_ORO) AS Soro FROM ENABAL WHERE ((FECHA='$FilaFecha["FECHA"]') AND 
						ENABAL.N_FLUJO=40 AND ENABAL.T_MOV=2)";
									
						$resultados = mysql_query($sql);
						$resultados2 = mysql_query($sqldos);
							
							while($fila=mysql_fetch_array($resultados))
								{			
								$mfcobre=$fila[FINOCOBRE];
								$mfplata=$fila[FINOPLATA];
								$mforo=$fila[FINOORO];
								}
							while($fila2=mysql_fetch_array($resultados2))
								{													
								$TPseco=$fila2[Sseco];
								$Tcobre=$fila2[Scobre];
								$Tplata=$fila2[Splata];
								$Toro=$fila2[Soro];
								}
								$BPSeco=0;$Bcobre=0;$Bplata=0;$Boro=0;$Lcobre=0;$Lplata=0;$Loro=0;
								$Bcobre=$Tcobre-$mfcobre;		//Blister Neto Cobre
								$Bplata=$Tplata-$mfplata;		//Blister Neto Plata
								$Boro=$Toro-$mforo;				//Blister Neto Oro
								$Lcobre =$Tcobre/$TPseco*100;	//Ley Cobre
								$BPSeco=$Bcobre/$Lcobre*100;	//Blister Neto Peso seco
								$Lplata=$Bplata/$BPSeco*1000;	//Ley Plata
								$Loro=$Boro/$BPSeco*1000;		//Ley Oro
								
								echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFFF'>";
								echo "<td>  </td>";
								echo "<td>  </td>";
								echo "<td  align='right'>BLISTER NETO</td>";
								echo "<td> ".$formato=number_format($BPSeco,'0',',','.')." </td>";			
								echo "<td>".$formato=number_format($Bcobre,'0',',','.')."</td>";
								echo "<td>".$formato=number_format($Bplata,'0',',','.')."</td>";
								echo "<td>".$formato=number_format($Boro,'0',',','.')."</td>";
								echo "</tr>";
								
								echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFFF'>";
								echo "<td>  </td>";
								echo "<td>  </td>";
								echo "<td  align='right'>LEY</td>";
								echo "<td> </td>";			
								echo "<td>".$formato=number_format($Lcobre,'2',',','.')."</td>";
								echo "<td>".$formato=number_format($Lplata,'2',',','.')."</td>";
								echo "<td>".$formato=number_format($Loro,'2',',','.')."</td>";
								echo "</tr>";
								}
							}
		  ?>
        </tr>
      </table>    
	 </td>
  </tr>
</table>
</form>
</body>
</html>