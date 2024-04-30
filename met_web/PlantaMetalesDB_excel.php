<?
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
?>
<html>
<head>
<title>DATOS BASES - Flujos Historicos PMN</title>
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

	if(f.txtflujo.value=='')
	{
		alert ("Debe Ingresar Numero de Flujo");
		f.txtflujo.focus();
		return false;
	}
	if(isNaN(parseInt(f.txtflujo.value)))
	{
		alert ("N�mero de Flujo s�lo acepta el ingreso de n�meros");
		return false;
	}		
	if(f.txtfecha3.value=='')
	{
		alert ("Debe ingresar fecha de inicio");
		f.txtfecha3.focus();
		return false;
	}
	if(f.txtfecha4.value=='')
	{
		alert ("Debe ingresar fecha final");
		f.txtfecha4.focus();
		return false;
	}			
	

	switch (opt)
	{
		case "W":
			f.action="PlantaMetalesDB.php?buscarOPT=S" ;
			f.submit();
			break;
		case "E":
			f.action="PlantaMetalesDB_excel.php?buscarOPT=S" ;
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
		f.BtnVol.style.visibility='hidden';
		window.print();
		f.BtnBusca.style.visibility='';
		f.BtnImpri.style.visibility='';
		f.BtnPlan.style.visibility='';
		f.BtnVol.style.visibility='';
}

function Volver()
{
	var f=document.form1;
	f.action='../principal/sistemas_usuario.php?CodSistema=25&Nivel=1&CodPantalla=1';
	f.submit();	
}

function Recarga()
{
	var f=document.form1;
	f.action="PlantaMetalesDB_excel.php?buscarOPT=S&txtflujo="+f.productos.value ;
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
	f.action="PlantaMetalesDB_excel.php?buscarproOPT=S" ;
	f.submit();
}
</script>
<body>

<form name="form1" method="post" action="">
<?
	include("conectar.php");
?>

<table width="770" height="330" border="0">
  <tr>
    <td width="762" align="center" valign="top"><table width="747" height="96" border="1" align="center">
      <tr align="center">
        <td height="21" colspan="5"><strong>Flujos Historicos Planta de Metales Nobles</strong></td>
      </tr>
      <tr>
        <td width="109" height="22"><strong>N&uacute;mero de Flujo: </strong></td>
        <td colspan="2"><div align="left"><? echo $txtflujo;?></div>
          </td>
        <td width="389" colspan="2"><div align="left"><? echo $TxtNomProd;?></div>
          </select>
          </td>
      </tr>
      <tr>
        <td height="22" align="left"><strong>Tipo Movimiento: </strong></td>
        <td width="146" colspan="-2"><div align="left"><? echo $select2; ?></div></td>
        <td width="75" colspan="-3" align="center"><strong> Desde:</strong></td>
        <td colspan="2"><div align="left"><? echo $txtfecha3;?></div> </td>
      </tr>
      <tr>
        <td height="19">&nbsp;</td>
        <td colspan="-2">&nbsp;</td>
        <td colspan="-3" align="center"><strong>Hasta:</strong></td>
        <td colspan="2"><div align="left"><? echo $txtfecha4;?></div>
          </td>
      </tr>
      <?
	
	if ($buscarproOPT=="S")
	{
		$sql = "SELECT NOM_PRODUCTO FROM enabalpmn_base where N_FLUJO='$txtflujo'"; 
		$resultados = mysql_query($sql);
		if($columna=mysql_fetch_array($resultados))
		{
			//echo "<option name=productos selected>".$columna[NOM_PRODUCTO]."</option>";
		}
	}	
	?>
      <br>
      <br>
    </table>
      <br>
      <table width="491" border="1" align="center">
        <tr>
          <td width="105"><strong>Peso Seco (Kg) </strong></td>
          <td width="123"><strong>Fino Cobre (Kg) </strong></td>
          <td width="128"><strong>Fino Plata (gr) </strong></td>
          <td width="107"><strong>Fino Oro (gr) </strong></td>
        </tr>
        <?
	if ($buscarOPT=="S")
	{
		$sql = "SELECT SUM(P_SECO) as PESOSECO, SUM(F_COBRE) as FINOCOBRE, SUM(F_PLATA) as FINOPLATA, SUM(F_ORO) as FINOORO FROM enabalpmn_base where N_FLUJO='$txtflujo' AND T_MOV='$select2' AND NOM_PRODUCTO='$TxtNomProd' and FECHA BETWEEN '$txtfecha3' and '$txtfecha4'"; 
		$resultados = mysql_query($sql);
		while($linea=mysql_fetch_array($resultados))
		{
			echo "<tr>" ;		
			echo "<td>".$formato=number_format($linea[PESOSECO],0,',','.')."</td>";
			echo "<td>".$formato=number_format($linea[FINOCOBRE],0,',','.')."</td>";
			echo "<td>".$formato=number_format($linea[FINOPLATA],0,',','.')."</td>";
			echo "<td>".$formato=number_format($linea[FINOORO],0,',','.')."</td>";
			echo "</tr>";
			
			if($linea[PESOSECO]==0)
			{
				$uno=0;$dos=0;$tres=0;		
			}else{
				$uno=$linea[FINOCOBRE]/$linea[PESOSECO]*100;
				$dos=$linea[FINOPLATA]/$linea[PESOSECO]*1000;
				$tres=$linea[FINOORO]/$linea[PESOSECO]*1000;
			}
			echo "<tr>" ;
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
      <table width="700" border="1">
        <tr align="center">
          <td width="145"><strong>Fecha</strong></td>
          <td width="104"><strong>Peso Seco (Kg) </strong></td>
          <td width="110"><strong>Fino Cobre (Kg) </strong></td>
          <td width="93"><strong>Fino Plata (gr) </strong></td>
          <td width="91"><strong>Fino Oro (gr) </strong></td>
        </tr>
        <?
	if ($buscarOPT=="S")
	{	
		$sql = "SELECT * FROM enabalpmn_base where N_FLUJO='$txtflujo' and T_MOV='$select2' and NOM_PRODUCTO='$TxtNomProd' and FECHA BETWEEN '$txtfecha3' and '$txtfecha4'";
		$resultados = mysql_query($sql);
		while($fila=mysql_fetch_array($resultados))
		{		
			echo "<tr>" ;
			echo "<td>".$fila["FECHA"]."</td>";
			echo "<td>".$formato=number_format($fila[P_SECO],0,',','.')."</td>";
			echo "<td>".$formato=number_format($fila[F_COBRE],0,',','.')."</td>";
			echo "<td>".$formato=number_format($fila[F_PLATA],0,',','.')."</td>";
			echo "<td>".$formato=number_format($fila[F_ORO],0,',','.')."</td>";
			echo "</tr>";
		}
	}
	?>
      </table></td>
  </tr>
</table>
  <?
		include("cerrarconexion.php");
		
?>
</form>

<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>


</body>
</html>
