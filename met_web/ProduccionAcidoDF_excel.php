<?
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
?>
<html>
<head>
<title>Datos Finales - Produccion de Acido</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>

<script language="javascript" type="text/JavaScript">

function Buscar(opt)
{	
	var f=document.form1;
	switch (opt)
	{
		case "W":
			f.action="ProduccionAcidoDF.php?buscarOPT=S" ;
			f.submit();
			break;
		case "E":
			f.action="ProduccionAcidoDF_excel.php?buscarOPT=S" ;
			f.submit();
			break;
	}
	
	
}
function imprimir()
{
	var f=document.form1;
		f.BtnBusca.style.visibility='hidden';
		f.BtnImpri.style.visibility='hidden';
		f.BtnPlan.style.visibility='hidden';
		f.BtnGra.style.visibility='hidden';
		f.BtnVol.style.visibility='hidden';
		window.print();
		f.BtnBusca.style.visibility='';
		f.BtnImpri.style.visibility='';
		f.BtnPlan.style.visibility='';
		f.BtnGra.style.visibility='';
		f.BtnVol.style.visibility='';
}

function Volver(){
	var f=document.form1;
	f.action='../principal/sistemas_usuario.php?CodSistema=25&Nivel=1&CodPantalla=2';
	f.submit();	
}

</script>
</head>

<body>
<form name="form1" method="post" action="">
<?
	include("conectar.php");
?>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>

  <table width="755" border="0">
    <tr>
      <td><table width="564" border="1" align="center">
        <tr align="center">
          <td width="343"> <bgcolor='#FFFFCC'> <strong> Produccion Acido Sulfurico </strong></td>
        </tr>
      </table>
        <p>
          <?php  

 	
 	if($buscarOPT=="S")
	 $FechaIni=$ano."-".$mes."-01";
	 $FechaFin=$ano2."-".$mes2."-01";
	
 	{
			$consulta= "SELECT ENABAL.FECHA, ENABAL.T_MOV, ENABAL.N_FLUJO, ENABAL.NOM_PRODUCTO, ENABAL.P_SECO, ENABAL.F_COBRE, ENABAL.F_PLATA, ENABAL.F_ORO FROM ENABAL 
			WHERE ((ENABAL.FECHA BETWEEN '$FechaIni' AND '$FechaFin') AND ENABAL.T_MOV=2 AND ((ENABAL.N_FLUJO=6) or (ENABAL.N_FLUJO=499) or (ENABAL.N_FLUJO=500)))";										
	
			$sumAcido="SELECT Sum(P_SECO) AS SUMA FROM ENABAL WHERE (ENABAL.T_MOV=2 AND ((ENABAL.N_FLUJO=6) or (ENABAL.N_FLUJO=499)) AND (ENABAL.FECHA BETWEEN '$FechaIni' AND '$FechaFin'))";
			
			$resAcido="SELECT Sum(P_SECO) AS RESTA FROM ENABAL WHERE (ENABAL.T_MOV=2 AND (ENABAL.N_FLUJO=500) AND (ENABAL.FECHA BETWEEN '$FechaIni' AND '$FechaFin'))";
		
		$totalsuma = mysql_query($sumAcido);			
		if($filauno=mysql_fetch_array($totalsuma))
		{	
			$Sum=$filauno[SUMA];
	 	}else
			$Sum=0;
		
		$totalresta = mysql_query($resAcido);
		if($filados=mysql_fetch_array($totalresta))
		{
			 $Res=$filados[RESTA];			 	
		}else		
			$Res=0;
			
		$TOTAL=$Sum-$Res;//echo $res;
		
		echo "<table border='1' width='402' bgcolor='#FFFFCC' align='center'>";
		echo "<tr align='center'>";
 		echo "<td width='351'><strong>Total Produccion de Acido Sulfurico:</strong></td>";	
		echo "<td width='181'><strong>".$formato=number_format($TOTAL,'0',',','.')."</strong></td>";
		echo "</tr>";
		echo "</table>";
		echo "<br>";
		echo "<table width='700' border='1' align='center'>";
    	echo "<tr align='center' class='ColorTabla01'>";
    	echo "<td width='30' align='center'>Fecha</td>";
    	echo "<td width='10' align='center'>Num Flujo </td>";
    	echo  "<td width='30' align='center'>Producto</td>";
    	echo "<td width='20' align='center'>Peso Seco (kg)</td>";					
    	echo "</tr>";
		
		$consulta1="SELECT DISTINCT FECHA FROM ENABAL WHERE ((ENABAL.FECHA BETWEEN '$FechaIni' AND '$FechaFin') AND ENABAL.T_MOV=2 AND ((ENABAL.N_FLUJO=6) or (ENABAL.N_FLUJO=499) or (ENABAL.N_FLUJO=500)))";									
		$RespFecha = mysql_query($consulta1);
			while($FilaFecha=mysql_fetch_array($RespFecha))
				{
					$consulta = "SELECT ENABAL.FECHA, ENABAL.T_MOV, ENABAL.N_FLUJO, ENABAL.NOM_PRODUCTO, ENABAL.P_SECO, ENABAL.F_COBRE, ENABAL.F_PLATA, ENABAL.F_ORO FROM ENABAL 
							WHERE ((FECHA = '$FilaFecha[FECHA]') AND ENABAL.T_MOV=2 AND ((ENABAL.N_FLUJO=6) or (ENABAL.N_FLUJO=499) or (ENABAL.N_FLUJO=500)))";									
				
					$SA="SELECT Sum(P_SECO) AS SUMA FROM ENABAL WHERE (ENABAL.T_MOV=2 AND ((ENABAL.N_FLUJO=6) or (ENABAL.N_FLUJO=499)) AND (ENABAL.FECHA = '$FilaFecha[FECHA]'))";
					$RA="SELECT Sum(P_SECO) AS RESTA FROM ENABAL WHERE (ENABAL.T_MOV=2 AND (ENABAL.N_FLUJO=500) AND (ENABAL.FECHA = '$FilaFecha[FECHA]'))";
			
					$resultadosdos = mysql_query($consulta);
					$resultadosSA = mysql_query($SA);			
					$resultadosRA = mysql_query($RA);					
					while($fila=mysql_fetch_array($resultadosdos))
					{
						echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFaa' align='center'>";
						echo "<td>".$fila[FECHA]."</td>";
						echo "<td>".$fila[N_FLUJO]."</td>";
						echo "<td>".$fila[NOM_PRODUCTO]."</td>";			
						echo "<td>".$formato=number_format($fila[P_SECO],'0',',','.')."</td>";									
						echo "</tr>";
						
					}
					while($filaSA=mysql_fetch_array($resultadosSA))
					{
						$SumaPesoSeco=$filaSA[SUMA];
						
					}
					while($filaRA=mysql_fetch_array($resultadosRA))
					{
						$RestaPesoSeco=$filaRA[SUMA];
						
					}
					$PAMES=$SumaPesoSeco-$RestaPesoSeco;
					
					echo "<tr bordercolor='#FFffff' bgcolor='#ffffea' align='center'>";
					echo "<td>".$fila[FECHA]."</td>";
					echo "<td>----</td>";
					echo "<td> PRODUCCION MENSUAL </td>";			
					echo "<td>".$formato=number_format($PAMES,'0',',','.')."</td>";									
					echo "</tr>";
				}
	}
  ?>
	
      </td>
    </tr>
  </table>
  <?
		include("cerrarconexion.php");

?>
</form>
</body>
</html>
