<?
		header("Content-Type:  application/vnd.ms-excel");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
?>
<html>
<head>
<title>Datos Base - Anodos Rechazados</title>
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

<script language="javascript">
function Buscar(opt)
{	
	var f=document.form1;
	switch (opt)
	{
		case "W":
			f.action="AnodosRechazadosDB.php?buscarOPT=S" ;
			f.submit();
			break;
		case "E":
			f.action="AnodosRechazadosDB_excel.php?buscarOPT=S" ;
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
<body>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<form name="form1" method="post" action="">
<?
	
	include("conectar.php");
?>
  <table width="770" height="330" border="0">
  <tr>
    <td width="911" align="center" valign="top"><table width="700" border="1">
        <tr align="center">
          <td colspan="4">Anodos Rechazados </td>
        </tr>
        <tr>
          <td width="176">Desde:</td>
          <td width="160"><? echo"$txtfecha6"; ?>
              </td>
          <td width="87">Hasta:</td>
          <td width="249"><? echo"$txtfecha7"; ?>
              </td>
        </tr>
      </table>
	  <br>
	  <br>
	  
	  <table width="571" border="1" class="TablaDetalle">
        <tr align="center">
          <td colspan="4">ANODOS RECHAZADOS </td>
        </tr>
        <tr>
          <td width="132">PESO SECO (Kg) </td>
          <td width="136">FINO COBRE (Kg) </td>
          <td width="131">FINO PLATA (gr) </td>
          <td width="144">FINO ORO (gr) </td>
		  
		  <?
		  if ($buscarOPT=="S")
		  {
					$consultar= "SELECT SUM(P_SECO) AS PESOSECO, SUM(F_COBRE) AS FINOCOBRE,SUM(F_PLATA) AS FINOPLATA, SUM(F_ORO) AS FINORO FROM enabal_base WHERE ((T_MOV='2') AND (N_FLUJO='404' OR N_FLUJO='402' OR N_FLUJO='145') AND FECHA BETWEEN '$txtfecha6' AND '$txtfecha7') ORDER BY N_FLUJO";
					$resultados = mysql_query($consultar);
					if($lineas=mysql_fetch_array($resultados))
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
	  <table width="700" border="1" class="TablaDetalle">
        <tr align="center">
          <td width="140">Fecha</td>
          <td width="35">Flujo </td>
          <td width="293">Nombre Producto </td>
          <td width="82">Peso Seco (Kg) </td>
          <td width="96">Fino Cobre (Kg) </td>
          <td width="85">Fino Plata (gr) </td>
          <td width="84">Fino Oro (gr)</td>
		  <?
		  if ($buscarOPT=="S")
		  {
				$consultas= "SELECT * FROM enabal_base WHERE ((T_MOV='2') AND (N_FLUJO='404' OR N_FLUJO='402' OR N_FLUJO='145') AND FECHA BETWEEN '$txtfecha6' AND '$txtfecha7')";
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
						echo "</tr>";
				}
		  }
		  ?>
        </tr>
      </table>
	  <br>
  </table>
	<?
		include("cerrarconexion.php");
		
	?>
</form>
    </td>
  </tr>


</body>
</html>
