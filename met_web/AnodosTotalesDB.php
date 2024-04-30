<?
	$CodigoDeSistema=25;
	$CodigoDePantalla=3;
?>
<html>
<head>
	<title>Datos Base - Anodos Totales</title>
	<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
	<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
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

	if(f.txtfecha6.value=='')
	{
		alert ("Debe ingresar fecha de inicio");
		f.txtfecha6.focus();
		return false;
	}
	if(f.txtfecha7.value=='')
	{
		alert ("Debe ingresar fecha final");
		f.txtfecha7.focus();
		return false;
	}			

	switch (opt)
	{
		case "W":
			f.action="AnodosTotalesDB.php?buscarOPT=S" ;
			f.submit();
			break;
		case "E":
			f.action="AnodosTotalesDB_excel.php?buscarOPT=S" ;
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
	include("../principal/encabezado.php");
	include("conectar.php");
?>
<table width="770" height="330" border="0" cellpadding="0" cellspacing="0" class="TablaPrincipal">
  <tr>
    <td align="center" valign="top" class="TablaPrincipal"><table width="457" border="1" align="center">
      <tr align="center" class="Detalle03">
        <td colspan="2"><strong>Anodos Totales </strong></td>
      </tr>
      <tr>
        <td width="225" align="center"><div align="center">Desde:
              <input name="txtfecha6" type="text" id="txtfecha62"  value="<? echo"$txtfecha6"; ?>"size="12">
              <img src="ico_cal.gif" alt="Pulse Aqui Para Seleccionar Fecha" width="16" height="16" align="absmiddle" onClick="popFrame.fPopCalendar(txtfecha6,txtfecha6,popCal);return false"></div></td>
        <td width="216"><div align="center">Hasta:
              <input name="txtfecha7" type="text" id="txtfecha72" value="<? echo"$txtfecha7"; ?>" size="12">
              <img src="ico_cal.gif" alt="Pulse Aqui Para Seleccionar Fecha" width="16" height="16" align="absmiddle" onClick="popFrame.fPopCalendar(txtfecha7,txtfecha7,popCal);return false" ></div></td>
        </tr>
    </table>
      <br>
      <table width="433" border="0" align="center">
        <tr>
          <td align="center"><input name="BtnBusca" type="button" id="BtnBusca" value="Buscar" onClick="Buscar('W')">            
          <input name="BtnImpri" type="submit" id="BtnImpri" value="Imprimir" onClick="imprimir()">            
          <input name="BtnPlan" type="submit" id="BtnPlan" value="Planilla Excel" onclick="Buscar('E')">            
          <input name="BtnVol" type="submit" id="BtnVol" style="width:70px " onClick="Volver()" value="Volver"></td>
          </tr>
      </table>
      <br>
      <table width="579" border="1" align="center" class="TablaDetalle">
        <tr align="center" class="ColorTabla01">
          <td colspan="4">ANODOS TOTALES </td>
        </tr>
        <tr class="ColorTabla01">
          <td width="132">PESO SECO (Kg) </td>
          <td width="136">FINO COBRE (Kg) </td>
          <td width="139">FINO PLATA (gr) </td>
          <td width="144">FINO ORO (gr) </td>
          <?
		  if ($buscarOPT=="S")
		  {
					$consult= "SELECT SUM(P_SECO) AS PESOSECO, SUM(F_COBRE) AS FINOCOBRE,SUM(F_PLATA) AS FINOPLATA, SUM(F_ORO) AS FINOORO FROM enabal_base WHERE T_MOV='2' AND (N_FLUJO='92' OR N_FLUJO='93' OR N_FLUJO='95' OR N_FLUJO='99' OR N_FLUJO='129' OR N_FLUJO='131') AND FECHA BETWEEN '$txtfecha6' AND '$txtfecha7'";
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
      <table width="700" border="1" class="TablaDetalle">
        <tr align="center" class="ColorTabla01">
          <td colspan="8">POR FECHA </td>
        </tr>
        <tr align="center" class="ColorTabla01">
          <td width="141">Fecha</td>
          <td width="35">Flujo </td>
          <td width="309">Nombre Producto </td>
          <td width="83">Peso Seco (Kg) </td>
          <td width="89">Fino Cobre (Kg) </td>
          <td width="81">Fino Plata (gr) </td>
          <td width="81">Fino Oro (gr) </td>
          <?
		  if ($buscarOPT=="S")
		  {
				$cons= "SELECT * FROM enabal_base WHERE T_MOV='2' AND (N_FLUJO='92' OR N_FLUJO='93' OR N_FLUJO='95' OR N_FLUJO='99' OR N_FLUJO='129' OR N_FLUJO='131') AND FECHA BETWEEN '$txtfecha6' AND '$txtfecha7'";
				$resultados = mysql_query($cons);
					while($line=mysql_fetch_array($resultados))
					{
						echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>" ;
						echo "<td>".$line["FECHA"]."</td>";
						echo "<td>".$line[N_FLUJO]."</td>";
						echo "<td>".$line[NOM_PRODUCTO]."</td>";
						echo "<td>".$formato=number_format($line[P_SECO],'0',',','.')."</td>";
						echo "<td>".$formato=number_format($line[F_COBRE],'0',',','.')."</td>";
						echo "<td>".$formato=number_format($line[F_PLATA],'0',',','.')."</td>";
						echo "<td>".$formato=number_format($line[F_ORO],'0',',','.')."</td>";
						echo "</tr>";
					}
		  }
		  ?>
        </tr>
      </table></td>
  </tr>
</table>
<?
	include("cerrarconexion.php");
	include("../principal/pie_pagina.php");
?>
</form>

</body>
</html>
