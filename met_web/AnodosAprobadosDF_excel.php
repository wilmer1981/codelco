<?
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
?>
<html>
<head>
<title>Datos Base - Anodos Aprobados</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>

<body>
<div id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onClick=event.cancelBubble=true>
  <iframe name=popFrame src="popcjs.htm" frameborder=0 width=160 scrolling=no height=180></iframe>
</div>
<script language="javascript">
function Buscar(opt)
{	
	var f=document.form1;
	switch (opt)
	{
		case "W":
			f.action="AnodosAprobadosDB.php?buscarOPT=S" ;
			f.submit();
			break;
		case "E":
			f.action="AnodosAprobadosDB_excel.php?buscarOPT=S" ;
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
	f.action='../principal/sistemas_usuario.php?CodSistema=25&Nivel=1&CodPantalla=1';
	f.submit();	
}


</script>
<form name="form1" method="post" action="">
<?

include ("conectar.php");
?>
<table width="772" border="0">
  <tr>
    <td width="736" height="330" align="center" valign="top">
      <?
		  if ($buscarOPT=="S")
		  {
				$consultt= "SELECT SUM(P_SECO) AS PESOSECO, SUM(F_COBRE) AS FINOCOBRE,SUM(F_PLATA) AS FINOPLATA, SUM(F_ORO) AS FINORO FROM enabal WHERE ((T_MOV='2') AND (N_FLUJO='92' OR N_FLUJO='93' OR N_FLUJO='95' OR N_FLUJO='99' OR N_FLUJO='129' OR N_FLUJO='131') AND (FECHA BETWEEN '$txtfecha6' AND '$txtfecha7'))";
				$consultar= "SELECT SUM(P_SECO) AS PESOSECO, SUM(F_COBRE) AS FINOCOBRE,SUM(F_PLATA) AS FINOPLATA, SUM(F_ORO) AS FINORO FROM enabal WHERE ((T_MOV='2') AND (N_FLUJO='404' OR N_FLUJO='402' OR N_FLUJO='145') AND (FECHA BETWEEN '$txtfecha6' AND '$txtfecha7'))";
				$resultados = mysql_query($consultt);
				$resultados1=mysql_query($consultar);
				if($lineas=mysql_fetch_array($resultados))
				{
					$atpc=$lineas[PESOSECO];
					$atfc=$lineas[FINOCOBRE];
					$atfp=$lineas[FINOPLATA];
					$atfo=$lineas[FINORO];
				}

				if($lineas1=mysql_fetch_array($resultados1))
				{
					$arps=$lineas1[PESOSECO];
					$arfc=$lineas1[FINOCOBRE];
					$arfp=$lineas1[FINOPLATA];
					$arfo=$lineas1[FINORO];
				}				
		}
		$uno=$atpc-$arps;
		$dos=$atfc-$arfc;
		$tres=$atfp-$arfp;
		$cuatro=$atfo-$arfo;

?>
      <br>
	  
	  <table width="578" border="1" class="TablaDetalle">
        <tr align="center" class="ColorTabla01">
          <td colspan="4"><strong>ANODOS APROBADOS  FINALES</strong></td>
        </tr>
        <tr class="ColorTabla01">
          <td width="132">PESO SECO (Kg)</td>
          <td width="136">FINO COBRE (Kg) </td>
          <td width="136">FINO PLATA (gr) </td>
          <td width="146">FINO ORO (gr) </td>
		    <?php
					 if ($buscarOPT=="S")
		  {
			  $FechaIni=$ano."-".$mes."-01";
			  $FechaFin=$ano2."-".$mes2."-01";
				
				
				$consultt= "SELECT SUM(P_SECO) AS PESOSECO, SUM(F_COBRE) AS FINOCOBRE,SUM(F_PLATA) AS FINOPLATA, SUM(F_ORO) AS FINORO FROM enabal WHERE T_MOV='2' AND (N_FLUJO='92' OR N_FLUJO='93' OR N_FLUJO='95' OR N_FLUJO='99' OR N_FLUJO='129' OR N_FLUJO='131') AND FECHA BETWEEN '$FechaIni' AND '$FechaFin'";
				$consultar= "SELECT SUM(P_SECO) AS PESOSECO, SUM(F_COBRE) AS FINOCOBRE,SUM(F_PLATA) AS FINOPLATA, SUM(F_ORO) AS FINORO FROM enabal WHERE T_MOV='2' AND (N_FLUJO='404' OR N_FLUJO='402' OR N_FLUJO='145') AND FECHA BETWEEN '$FechaIni' AND '$FechaFin'";
				$resultados = mysql_query($consultt);
				$resultados1=mysql_query($consultar);
				if($lineas=mysql_fetch_array($resultados))
				{
					$atpc=$lineas[PESOSECO];
					$atfc=$lineas[FINOCOBRE];
					$atfp=$lineas[FINOPLATA];
					$atfo=$lineas[FINORO];
				}
				if($lineas1=mysql_fetch_array($resultados1))
					{
						$arps=$lineas1[PESOSECO];
						$arfc=$lineas1[FINOCOBRE];
						$arfp=$lineas1[FINOPLATA];
						$arfo=$lineas1[FINORO];
					}

			}
			$uno=$atpc-$arps;
			$dos=$atfc-$arfc;
			$tres=$atfp-$arfp;
			$cuatro=$atfo-$arfo;
			
			echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>" ;
			echo "<td>".$formato=number_format($uno,0,',','.')."</td>";
			echo "<td>".$formato=number_format($dos,0,',','.')."</td>";
			echo "<td>".$formato=number_format($tres,0,',','.')."</td>";
			echo "<td>".$formato=number_format($cuatro,0,',','.')."</td>";
			echo "</tr>";
			
		  
		  if ($buscarOPT=="S")
		  {
				$consultar= "SELECT SUM(P_SECO) AS PESOSECO, SUM(F_COBRE) AS FINOCOBRE,SUM(F_PLATA) AS FINOPLATA, SUM(F_ORO) AS FINORO FROM enabal WHERE ((T_MOV='2') AND (N_FLUJO='404' OR N_FLUJO='402' OR N_FLUJO='145') AND FECHA BETWEEN '$FechaIni' AND '$FechaFin') ORDER BY N_FLUJO";
				$resultados = mysql_query($consultar);
				while($lineas=mysql_fetch_array($resultados))
			    {
					if($uno==0)
						{
							$uno1=0;$dos1=0;$tres1=0;				
						}
					else
						{
							$uno1=$dos/$uno*100;
							$dos1=$tres/$uno*1000;
							$tres1=$cuatro/$uno*1000;						
						}
					echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>" ;
					echo "<td>LEY</td>";
					echo "<td>".$english_format_number = number_format($uno1, 2, ',', '')."</td>";
					echo "<td>".$english_format_number = number_format($dos1, 3, ',', '')."</td>";
					echo "<td>".$english_format_number = number_format($tres1, 3, ',', '')."</td>";
					echo "</tr>";
  				}
  			}
			?>
        </tr>
      </table>
	  <br>
	  <table width="700" border="1" class="TablaDetalle">
        <tr align="center" class="ColorTabla01">
          <td colspan="5"><strong> ANODOS APROBADOS POR MES </strong></td>
        </tr>
        <tr align="center" class="ColorTabla01">
          <td width="150">Fecha</td>
	      <td width="78">Peso Seco (Kg) </td>
          <td width="87">Fino Cobre (Kg) </td>
          <td width="74">Fino Plata (gr)</td>
          <td width="74">Fino Oro (gr) </td>
          <?
		  if ($buscarOPT=="S")
		  {			
				$FechaIni=$ano."-".$mes."-01";
			  	$FechaFin=$ano2."-".$mes2."-01";
				
				$consultas= "SELECT DISTINCT FECHA FROM enabal WHERE ((T_MOV='2') AND (N_FLUJO='404' OR N_FLUJO='402' OR N_FLUJO='145') AND FECHA BETWEEN '$FechaIni' AND '$FechaFin')";
				$RespFecha = mysql_query($consultas);
				while($FilaFecha=mysql_fetch_array($RespFecha))
				{		$apps=0;$apco=0;$appl=0;$apor=0;
						$consultt= "SELECT  SUM(P_SECO) AS PESOSECO, SUM(F_COBRE) AS FINOCOBRE,SUM(F_PLATA) AS FINOPLATA, SUM(F_ORO) AS FINORO FROM enabal WHERE ((T_MOV='2') AND (N_FLUJO='92' OR N_FLUJO='93' OR N_FLUJO='95' OR N_FLUJO='99' OR N_FLUJO='129' OR N_FLUJO='131') AND (FECHA = '$FilaFecha[FECHA]'))";
						$consultar= "SELECT  SUM(P_SECO) AS PESOSECO, SUM(F_COBRE) AS FINOCOBRE,SUM(F_PLATA) AS FINOPLATA, SUM(F_ORO) AS FINORO FROM enabal WHERE ((T_MOV='2') AND (N_FLUJO='404' OR N_FLUJO='402' OR N_FLUJO='145') AND (FECHA ='$FilaFecha[FECHA]'))";
						
						$resultados = mysql_query($consultt);
						$resultados1= mysql_query($consultar);
						while($codigo=mysql_fetch_array($resultados))
								{
									$apps=$codigo[PESOSECO];
									$apco=$codigo[FINOCOBRE];
									$appl=$codigo[FINOPLATA];
									$apor=$codigo[FINORO];
								}
												
						while($codigo2=mysql_fetch_array($resultados1))
								{
									$arps=$codigo2[PESOSECO];
									$arco=$codigo2[FINOCOBRE];
									$arpl=$codigo2[FINOPLATA];
									$aror=$codigo2[FINORO];
								
								}
								
						$uno=$apps-$arps;
						$dos=$apco-$arco;
						$tres=$appl-$arpl;
						$cuatro=$apor-$aror;
						
						echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>" ;
						echo "<td>".$FilaFecha[FECHA]."</td>";
						echo "<td>".$formato=number_format($uno,'0',',','.')."</td>";
						echo "<td>".$formato=number_format($dos,'0',',','.')."</td>";
						echo "<td>".$formato=number_format($tres,'0',',','.')."</td>";
						echo "<td>".$formato=number_format($cuatro,'0',',','.')."</td>";
		
				}
			
			} 
		  ?>
        </tr>
      </table>
	   </td>
  </tr>
</table>
<?
	include("cerrarconexion.php");
?>
	
</form>
</body>
</html>
