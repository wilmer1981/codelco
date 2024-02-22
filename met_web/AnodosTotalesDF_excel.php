<?
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
?>
<html>
<head>
<title>Datos Finales - Anodos Totales</title>
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
	<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
    <style type="text/css">
<!--
.Estilo1 {color: #000000}
.Estilo2 {color: #FFFFFF}
-->
    </style>
</head>
<script language="javascript">
function Buscar(opt)
{	
	var f=document.form1;
	switch (opt)
	{
		case "W":
			f.action="AnodosTotalesDF.php?buscarOPT=S" ;
			f.submit();
			break;
		case "E":
			f.action="AnodosTotalesDF_excel.php?buscarOPT=S" ;
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
<body>
<form name="form1" method="post" action="">
<?
	
	include("conectar.php");
?>

<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>


<table width="770" border="0">
  <tr>
    <td width="920" valign="top">
	    
	    <br>
	    
	  <table width="589" border="1" align="center">
          <tr align="center" class="ColorTabla01">
            <td colspan="4">ANODOS TOTALES </td>
        </tr>
          <tr class="ColorTabla01">
            <td width="132">PESO SECO (Kg) </td>
            <td width="136">FINO COBRE (Kg) </td>
            <td width="150">FINO PLATA (gr) </td>
            <td width="133">FINO ORO (gr) </td>
            <?
		  $FechaIni=$ano."-".$mes."-01";
		  $FechaFin=$ano2."-".$mes2."-01";
		  if ($buscarOPT=="S")
		  {
		  							
					$consult= "SELECT SUM(P_SECO) AS PESOSECO, SUM(F_COBRE) AS FINOCOBRE,SUM(F_PLATA) AS FINOPLATA, SUM(F_ORO) AS FINOORO FROM enabal WHERE ((T_MOV='2') AND (N_FLUJO='92' OR N_FLUJO='93' OR N_FLUJO='95' OR N_FLUJO='99' OR N_FLUJO='129' OR N_FLUJO='131') AND (FECHA BETWEEN '$FechaIni' AND '$FechaFin'))";
					$resultados = mysql_query($consult);
					while($linea=mysql_fetch_array($resultados))
					{
						echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>" ;
						echo "<td>".$formato=number_format($linea[PESOSECO],'0',',','.')."</td>";
						echo "<td>".$formato=number_format($linea[FINOCOBRE],'0',',','.')."</td>";
						echo "<td>".$formato=number_format($linea[FINOPLATA],'0',',','.')."</td>";
						echo "<td>".$formato=number_format($linea[FINOORO],'0',',','.')."</td>";
						echo "</tr>";						
					
						if($linea[PESOSECO]==0)
						{
							$uno=0;$dos=0;$tres=0; 
						}else{
							$uno=$linea[FINOCOBRE]/$linea[PESOSECO]*100;
							$dos=$linea[FINOPLATA]/$linea[PESOSECO]*1000;
							$tres=$linea[FINOORO]/$linea[PESOSECO]*1000;
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
            <td colspan="5">POR FECHA </td>
          </tr>
          <tr align="center" class="ColorTabla01">
            <td width="191" class="ColorTabla01">Fecha</td>
            <td width="131" class="ColorTabla01">Peso Seco (Kg) </td>
            <td width="107" class="ColorTabla01">Fino Cobre (Kg) </td>
            <td width="119" class="ColorTabla01">Fino Plata (gr) </td>
            <td width="118">Fino Oro (gr) </td>
            <?
		  $FechaIni=$ano."-".$mes."-01";
		  $FechaFin=$ano2."-".$mes2."-01";
		
		  if ($buscarOPT=="S")
		  {			
				$consultas= "SELECT FECHA, SUM(P_SECO) AS PESOSECO, SUM(F_COBRE) AS FINOCOBRE,SUM(F_PLATA) AS FINOPLATA, SUM(F_ORO) AS FINORO  FROM enabal WHERE ((T_MOV='2') AND (N_FLUJO='92' OR N_FLUJO='93' OR N_FLUJO='95' OR N_FLUJO='99' OR N_FLUJO='129' OR N_FLUJO='131') AND (FECHA BETWEEN '$FechaIni' AND '$FechaFin' )) GROUP BY FECHA";
				
					
					//$consultas= "SELECT * FROM enabal WHERE ((T_MOV='2') AND (N_FLUJO='92' OR N_FLUJO='93' OR N_FLUJO='95' OR N_FLUJO='99' OR N_FLUJO='129' OR N_FLUJO='131') AND FECHA ='$FilaFecha[FECHA]')";
					$resultados = mysql_query($consultas);
					while($codigo=mysql_fetch_array($resultados))
					{
							echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>" ;
							echo "<td>".$codigo[FECHA]."</td>";
							echo "<td>".$formato=number_format($codigo[PESOSECO],'0',',','.')."</td>";
							echo "<td>".$formato=number_format($codigo[FINOCOBRE],'0',',','.')."</td>";
							echo "<td>".$formato=number_format($codigo[FINOPLATA],'0',',','.')."</td>";
							echo "<td>".$formato=number_format($codigo[FINORO],'0',',','.')."</td>";
							echo "</tr>";
							
					}
					
					
					
		}	
		  
		  ?>
          </tr>
        </table>
        </td></tr>
</table>
<?
	include("cerrarconexion.php");
?>
</form>
</body>
</html>

