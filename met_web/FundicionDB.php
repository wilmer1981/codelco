<?
	$CodigoDeSistema=25;
	$CodigoDePantalla=3;
?>
<html>
<head>
<title>Datos Finales - Flujos Historicos Fundicion</title>
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
	if(f.txtflujo.value=='')
	{
		alert ("Debe Ingresar Numero de Flujo");
		f.txtflujo.focus();
		return false;
	}
	if(isNaN(parseInt(f.txtflujo.value)))
	{
		alert ("Número de Flujo sólo acepta el ingreso de números");
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
			f.action="FundicionDF.php?buscarOPT=S" ;
			f.submit();
			break;
		case "E":
			f.action="FundicionDF_excel.php?buscarOPT=S" ;
			f.submit();
			break;
	}
	
	
}
function Recarga()
{	
	var f=document.form1;
	f.action="FundicionDF.php?buscarOPT=S&txtflujo="+f.productos.value ;
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

function Volver(){
	var f=document.form1;
	f.action='../principal/sistemas_usuario.php?CodSistema=25&Nivel=1&CodPantalla=2';
	f.submit();	
}

</script>
<script language="javascript">
function buscarpro()
{	
	var f=document.form1;
	f.action="FundicionDF.php?buscarproOPT=S" ;
	f.submit();
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
</script>
<body>
<form name="form1" method="post" action="">
<?
include("../principal/encabezado.php");
include("conectar.php");
?>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<table width="770" height="330" border="1" class="TablaPrincipal">
  <tr>
    <td align="center" valign="top"><table width="700" height="123" border="1" align="center">
        <tr align="center" class="Detalle03">
          <td height="18" colspan="5"><strong>Flujos Historicos Fundicion</strong> </td>
        </tr>
        <tr>
          <td width="112" height="26">N&uacute;mero de Flujo: </td>
          <td colspan="2"><input name="txtflujo" type="text" id="txtflujo2" size="2" value="<? echo $txtflujo;?>">
              <input name="Button" type="submit" id="Button" value="Buscar Producto" onClick="buscarpro()"></td>
          <td width="313" colspan="2"><select name="productos" onChange="Rescatar()">
              <?
		$sql1 = "SELECT DISTINCT NOM_PRODUCTO,N_FLUJO FROM enabal_base ";
		if($txtflujo!='')
			$sql1.= "where N_FLUJO='".$txtflujo."'";
		$resultados = mysql_query($sql1);
		while($columna=mysql_fetch_array($resultados))
		{
			if($productos==$columna[N_FLUJO]."~".$columna[NOM_PRODUCTO])
			{
				echo "<option value='".$columna[N_FLUJO]."~".$columna[NOM_PRODUCTO]."'selected>".$columna[NOM_PRODUCTO]."</option>";
				$TxtNomProd=$columna[NOM_PRODUCTO];
			}	
			else
				echo "<option value='".$columna[N_FLUJO]."~".$columna[NOM_PRODUCTO]."'>".$columna[NOM_PRODUCTO]."</option>";
		}
	?>
            </select>
              <input name="TxtNomProd" type="hidden" value="<? echo $TxtNomProd;?>"></td>
        </tr>
        <tr>
          <td height="26" align="left">Tipo Movimiento:</td>
          <td width="85" colspan="-2"><select name="select2" size="1">
<?
	switch ($select2)
	{
		case "2":
			echo "<option selected>2</option>\n";
            echo "<option>3</option>\n";
			break;
		case "3":
			echo "<option>2</option>\n";
            echo "<option selected>3</option>\n";
			break;
		default:
			echo "<option selected>2</option>\n";
            echo "<option>3</option>\n";
			break;
	}
?>		
        </select></td>
          <td width="112" colspan="-3" align="center">Desde:</td>
          <td colspan="2"><input name="txtfecha3" type="text" value="<? echo $txtfecha3;?>" size="12">
              <img src="ico_cal.gif" alt="Pulse Aqui Para Seleccionar Fecha" width="16" height="16" border="0" align="top" onClick="popFrame.fPopCalendar(txtfecha3,txtfecha3,popCal);return false"> </td>
        </tr>
        <tr>
          <td height="24">&nbsp;</td>
          <td colspan="-2">&nbsp;</td>
          <td colspan="-3" align="center">Hasta:</td>
          <td colspan="2"><input name="txtfecha4" type="text" value="<? echo $txtfecha4;?>" size="12">
              <img src="ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="top" onClick="popFrame.fPopCalendar(txtfecha4,txtfecha4,popCal);return false"></td>
        </tr>
        <tr>
          <td height="26" colspan="5" align="center"><input name="BtnBusca" type="button" id="BtnBusca" onClick="Buscar('W')" value="Buscar">
              <input name="BtnImpri" type="submit" id="Imprimir2" value="Imprimir" onClick="imprimir()">
              <input name="BtnPlan" type="submit" id="planilla2" value="PlanillaExcel" onClick="Buscar('E')">
              <input name="BtnVol" type="submit" id="BtnVol" style="width:70px " onClick="Volver()" value="Volver"></td>
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
        <br>
        <br>
      </table>
        <br>
        <table width="484" border="1" align="center" class="TablaDetalle">
          <tr class="ColorTabla01">
            <td width="105">Peso Seco (Kg) </td>
            <td width="123">Fino Cobre (Kg) </td>
            <td width="128">Fino Plata (gr) </td>
            <td width="100">Fino Oro (gr) </td>
          </tr>
          <?
	if ($buscarOPT=="S")
	{
		$sql = "SELECT SUM(P_SECO) as PESOSECO, SUM(F_COBRE) as FINOCOBRE, SUM(F_PLATA) as FINOPLATA, SUM(F_ORO) as FINORO FROM enabal_base where N_FLUJO='$txtflujo' AND NOM_PRODUCTO='$TxtNomProd' and T_MOV='$select2' AND FECHA BETWEEN '$txtfecha3' and '$txtfecha4'"; 
		$resultados = mysql_query($sql);
		while($linea=mysql_fetch_array($resultados))
		{
			echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>" ;
			echo "<td>".$formato=number_format ($linea[PESOSECO],'0',',','.')."</td>";
		    echo "<td>".$formato=number_format ($linea[FINOCOBRE],'0',',','.')."</td>";
			echo "<td>".$formato=number_format ($linea[FINOPLATA],'0',',','.')."</td>";
			echo "<td>".$formato=number_format ($linea[FINORO],'0',',','.')."</td>";
			echo "</tr>";
			echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>" ;
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
        <table width="578" border="1" align="center" class="TablaDetalle">
          <tr align="center" class="ColorTabla01">
            <td width="135">Fecha</td>
            <td width="107">Peso Seco (Kg) </td>
            <td width="114">Fino Cobre (Kg) </td>
            <td width="94">Fino Plata (gr) </td>
            <td width="94">Fino Oro (gr) </td>
          </tr>
          <?
	if ($buscarOPT=="S")
	{
		$sql = "SELECT * FROM enabal_base where N_FLUJO='$txtflujo' AND  T_MOV='$select2' and NOM_PRODUCTO='$TxtNomProd' and FECHA BETWEEN '$txtfecha3' and '$txtfecha4' ORDER BY FECHA"; 	
		$resultados = mysql_query($sql);
		while($fila=mysql_fetch_array($resultados))
		{
			echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>" ;
			echo "<td>".substr($fila[FECHA],0,7)."</td>";				
			echo "<td>".$formato=number_format ($fila[P_SECO],'0',',','.')."</td>";
			echo "<td>".$formato=number_format ($fila[F_COBRE],'0',',','.')."</td>";
			echo "<td>".$formato=number_format ($fila[F_PLATA],'0',',','.')."</td>";
			echo "<td>".$formato=number_format ($fila[F_ORO],'0',',','.')."</td>";
			echo "</tr>";
		}
	}
	?>
      </table></td>
  </tr>
</table>
</form>
<?
	include("cerrarconexion.php");
	include("../principal/pie_pagina.php");
?>
</body>
</html>
