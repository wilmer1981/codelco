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
      <table width="448" border="1" align="center">
        <tr align="center">
          <td colspan="4"><strong>Anodos Aprobados</strong> </td>
        </tr>
        <tr>
          <td width="126" height="22"><strong>Desde:</strong></td>
          <td width="102"><div align="left"><? echo"$txtfecha6";?></div></td>
          <td width="85"><strong>Hasta:</strong></td>
          <td width="107"><div align="left"><? echo"$txtfecha7";?></div></td>
        </tr>
      </table>
	  <?
		  if ($buscarOPT=="S")
		  {
				$consultt= "SELECT SUM(P_SECO) AS PESOSECO, SUM(F_COBRE) AS FINOCOBRE,SUM(F_PLATA) AS FINOPLATA, SUM(F_ORO) AS FINORO FROM enabal_base WHERE ((T_MOV='2') AND (N_FLUJO='92' OR N_FLUJO='93' OR N_FLUJO='95' OR N_FLUJO='99' OR N_FLUJO='129' OR N_FLUJO='131') AND (FECHA BETWEEN '$txtfecha6' AND '$txtfecha7'))";
				$consultar= "SELECT SUM(P_SECO) AS PESOSECO, SUM(F_COBRE) AS FINOCOBRE,SUM(F_PLATA) AS FINOPLATA, SUM(F_ORO) AS FINORO FROM enabal_base WHERE ((T_MOV='2') AND (N_FLUJO='404' OR N_FLUJO='402' OR N_FLUJO='145') AND (FECHA BETWEEN '$txtfecha6' AND '$txtfecha7'))";
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
        <tr align="center">
          <td colspan="4"><strong>ANODOS APROBADOS </strong></td>
        </tr>
        <tr>
          <td width="132">PESO SECO (Kg)</td>
          <td width="136">FINO COBRE (Kg) </td>
          <td width="136">FINO PLATA (gr) </td>
          <td width="146">FINO ORO (gr) </td>
		    <?php
					echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>" ;
					echo "<td>".$formato=number_format($uno,'0',',','.')."</td>";
					echo "<td>".$formato=number_format($dos,'0',',','.')."</td>";
					echo "<td>".$formato=number_format($tres,'0',',','.')."</td>";
					echo "<td>".$formato=number_format($cuatro,'0',',','.')."</td>";
					echo "</tr>";
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

			?>
        </tr>
      </table>
	  <br>
	  <table width="700" border="1" class="TablaDetalle">
        <tr align="center">
          <td colspan="5"><strong>ANODOS TOTALES </strong></td>
        </tr>
        <tr align="center">
          <td width="150">Fecha</td>
          <td width="35">Flujo </td>
          <td width="293">Nombre Producto </td>
          <td width="78">Peso Seco (Kg) </td>
          <td width="87">Fino Cobre (Kg) </td>
          <td width="74">Fino Plata (gr)</td>
          <td width="74">Fino Oro (gr) </td>
          <?
		  if ($buscarOPT=="S")
		  {
				$sql="SELECT * FROM enabal_base WHERE ((T_MOV='2') AND (N_FLUJO='92' OR N_FLUJO='93' OR N_FLUJO='95' OR N_FLUJO='99' OR N_FLUJO='129' OR N_FLUJO='131') AND (FECHA BETWEEN '$txtfecha6' AND '$txtfecha7'))";
		  		$resultados = mysql_query($sql);
				while($secuencia=mysql_fetch_array($resultados))
					{
						echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>" ;
						echo "<td>".$secuencia["FECHA"]."</td>";
						echo "<td>".$secuencia[N_FLUJO]."</td>";
						echo "<td>".$secuencia[NOM_PRODUCTO]."</td>";
						echo "<td>".$formato=number_format($secuencia[P_SECO],'0',',','.')."</td>";
						echo "<td>".$formato=number_format($secuencia[F_COBRE],'0',',','.')."</td>";
						echo "<td>".$formato=number_format($secuencia[F_PLATA],'0',',','.')."</td>";
						echo "<td>".$formato=number_format($secuencia[F_ORO],'0',',','.')."</td>";
						echo "</tr>";
					}
		  }
		  ?>
        </tr>
      </table>
	  <br>
	  <table width="700" border="1" class="TablaDetalle">
        <tr align="center">
          <td colspan="5"><strong>ANODOS RECHAZADOS </strong></td>
        </tr>
        <tr align="center">
          <td width="148" height="28">Fecha</td>
          <td width="35">Flujo </td>
          <td width="293">Nombre Producto </td>
          <td width="80">Peso Seco (Kg) </td>
          <td width="86">Fino Cobre (Kg) </td>
          <td width="71">Fino Plata (gr) </td>
          <td width="72">Fino Oro (gr) </td>
          <?
		  if ($buscarOPT=="S")
		  {
				$sentencia= "SELECT * FROM enabal_base WHERE (T_MOV='2') AND (N_FLUJO='404' OR N_FLUJO='402' OR N_FLUJO='145') AND FECHA BETWEEN '$txtfecha6' AND '$txtfecha7'";
				$resultados = mysql_query($sentencia);
				while($codigos=mysql_fetch_array($resultados))
					{
						echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>" ;
						echo "<td>".$codigos["FECHA"]."</td>";
						echo "<td>".$codigos[N_FLUJO]."</td>";
						echo "<td>".$codigos[NOM_PRODUCTO]."</td>";
						echo "<td>".$formato=number_format($codigos[P_SECO],'0',',','.')."</td>";
						echo "<td>".$formato=number_format($codigos[F_COBRE],'0',',','.')."</td>";
						echo "<td>".$formato=number_format($codigos[F_PLATA],'0',',','.')."</td>";
						echo "<td>".$formato=number_format($codigos[F_ORO],'0',',','.')."</td>";
						echo "</tr>";
				}
		  }
		  ?>
        </tr>
      </table>
	  <span class="ColorTabla01"><br>
      </span><br>    </td>
  </tr>
</table>
<?
	include("cerrarconexion.php");
?>
	
</form>
</body>
</html>
