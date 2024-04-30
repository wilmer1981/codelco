<?
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
?>
<html>
<head>
<title>DATOS BASE - Flujos Historicos Fundicion</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<style type="text/css">
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
			f.action="FundicionDB.php?buscarOPT=S" ;
			f.submit();
			break;
		case "E":
			f.action="FundicionDB_excel.php?buscarOPT=S" ;
			f.submit();
			break;
	}
	
	
}

function Recarga()
{	
	var f=document.form1;
	f.action="FundicionDB.php?buscarOPT=S&txtflujo="+f.productos.value ;
	f.submit();
}

function Volver(){
	var f=document.form1;
	f.action='../principal/sistemas_usuario.php?CodSistema=25&Nivel=1&CodPantalla=1';
	f.submit();	
}

function Rescatar()
{
	var f=document.form1;
	var Flujo ='';
	Flujo=f.productos.value.split('~');
 	//alert(Flujo[0]);
 	//alert(Flujo[1]);
	f.txtflujo.value=Flujo[0];
	f.TxtNomProd.value=f.productos.options[f.productos.selectedIndex].text;
}
</script>
<script language="javascript">
function buscarpro()
{
	var f=document.form1;
	f.action="FundicionDB.php?buscarproOPT=S" ;
	f.submit();
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
</script>
<body>
<form name="form1" method="post" action="">

<?
	include("conectar.php");
?>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<table width="770" height="330" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top"><br>      <table width="324" height="88" border="1" align="center" cellpadding="0" cellspacing="0">
      <tr align="center">
        <td height="14" colspan="5"><strong>Flujos Historicos Fundicion</strong></td>
      </tr>
      <tr>
        <td height="26"><strong>N&uacute;mero de Flujo : </strong></td>
        <td colspan="2"><div align="left"><? echo $txtflujo;?></div></td>
        <td width="205" colspan="2"><div align="left"><? echo $TxtNomProd;?></div></td>
        </tr>
      <tr>
        <td width="92" height="26" align="left"><strong>Tipo Movimiento : </strong></td>
        <td width="70" colspan="-2"><div align="left"><? echo $select2;?></div></td>
        <td width="60" colspan="-3" align="right"><strong>Desde :</strong></td>
        <td colspan="2"><div align="left"><? echo $txtfecha3;?></div></td>
      </tr>
      <tr>
        <td height="20" colspan="2">&nbsp;</td>
        <td colspan="-3" align="right"><strong>Hasta :</strong></td>
        <td colspan="2"><div align="left"><? echo $txtfecha4;?></div>
          </td>
      </tr>
      <?
	
	if ($buscarproOPT=="S")
	{
		$sql = "SELECT NOM_PRODUCTO FROM enabal_base where N_FLUJO='$txtflujo'"; 
		$resultados = mysql_query($sql);
		if($columna=mysql_fetch_array($resultados))
		{
			//echo "<option name=productos selected>".$columna[NOM_PRODUCTO]."</option>";
		}
	}	
	?>
     
    </table>
	<br>
      <table width="484" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
        <tr align="center">
          <td width="105"><strong>Peso Seco (Kg) </strong></td>
          <td width="123"><strong>Fino Cobre (Kg) </strong></td>
          <td width="128"><strong>Fino Plata (gr) </strong></td>
          <td width="100"><strong>Fino Oro (gr) </strong></td>
        </tr>
        <?
	if ($buscarOPT=="S")
	{
		$sql = "SELECT SUM(P_SECO) as PESOSECO, SUM(F_COBRE) as FINOCOBRE, SUM(F_PLATA) as FINOPLATA, SUM(F_ORO) as FINORO FROM enabal_base where N_FLUJO='$txtflujo' AND T_MOV='$select2' AND NOM_PRODUCTO='$TxtNomProd' AND FECHA BETWEEN '$txtfecha3' and '$txtfecha4'"; 
		$resultados = mysql_query($sql);
		while($linea=mysql_fetch_array($resultados))
		{
			echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>" ;
			echo "<td>".$english_format_number = number_format($linea[PESOSECO],0,',','.')."</td>";
			echo "<td>".$english_format_number = number_format($linea[FINOCOBRE],0,',','.')."</td>"; 
			echo "<td>".$english_format_number = number_format($linea[FINOPLATA],0,',','.')."</td>";
			echo "<td>".$english_format_number = number_format($linea[FINORO],0,',','.')."</td>";
			echo "</tr>";
			if($linea[PESOSECO]==0)
				{
					$uno=0;$dos=0;$tres=0;					
				}
				else
						{
							$uno=$linea[FINOCOBRE]/$linea[PESOSECO]*100;
							$dos=$linea[FINOPLATA]/$linea[PESOSECO]*1000;
							$tres=$linea[FINORO]/$linea[PESOSECO]*1000;
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
      </table>
      <br>
      <br>
      <table width="558" border="1" cellpadding="0" cellspacing="0" class="TablaDetalle">
        <tr align="center">
          <td width="143"><strong>Fecha</strong></td>
          <td width="104"><strong>Peso Seco (Kg) </strong></td>
          <td width="113"><strong>Fino Cobre (Kg) </strong></td>
          <td width="97"><strong>Fino Plata (gr) </strong></td>
          <td width="89"><strong>Fino Oro (gr) </strong></td>
        </tr>
        <?
	if ($buscarOPT=="S")
	{	
		$sql = "SELECT * FROM enabal_base where N_FLUJO='$txtflujo' and T_MOV='$select2' and NOM_PRODUCTO='$TxtNomProd' and FECHA BETWEEN '$txtfecha3' and '$txtfecha4'"; 	
		$resultados = mysql_query($sql);
		while($fila=mysql_fetch_array($resultados))
		{
			echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>" ;
			echo "<td>".substr($fila["FECHA"],0,7)."</td>";	
			echo "<td>".$english_format_number = number_format($fila[P_SECO],0,',','.')."</td>";
			echo "<td>".$english_format_number = number_format($fila[F_COBRE],0,',','.')."</td>";
			echo "<td>".$english_format_number = number_format($fila[F_PLATA],0,',','.')."</td>";
			echo "<td>".$english_format_number = number_format($fila[F_ORO],0,',','.')."</td>";
			echo "</tr>";
		}
	}
	?>
      </table>
      <br></td>
  </tr>
</table>
<td width="1028">      
</td>
<?
	include("cerrarconexion.php");
?>
</form>
</body>
</html>
