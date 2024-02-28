<?php
	include("../principal/conectar_principal.php");

	$TxtFechaIni = isset($_REQUEST["TxtFechaIni"])?$_REQUEST["TxtFechaIni"]:date('Y-m-d');
	$TxtFechaIniMes=substr(date('Y-m-d'),0,7)."-01";	
	$Buscar  = isset($_REQUEST["Buscar"])?$_REQUEST["Buscar"]:"";
?>
<html>
<head>
<title>Modificacion Correlativo Sipa</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{		
		case "C":
			f.action = "sec_modificar_correlativos.php?Buscar=S";
			f.submit();
			break;
		case "I":
			f.BtnConsultar.style.visibility = "hidden";
			f.BtnImprimir.style.visibility = "hidden";
			f.BtnSalir.style.visibility = "hidden";
			window.print();
			f.BtnConsultar.style.visibility = "visible";
			f.BtnImprimir.style.visibility = "visible";
			f.BtnSalir.style.visibility = "visible";
			break;	
		case "S":
			f.action = "../principal/sistemas_usuario.php?CodSistema=3";
			f.submit();
			break;
	}
}
function ModificarCorr(Patente,Guia,Corr)
{
	//alert(Patente);	
	//alert(Guia);
	window.open("sec_modificar_correlativos_proceso.php?Patente="+Patente+"&Guia="+Guia+"&TxtCorr="+Corr,"","top=60,left=180,width=530,height=250,scrollbars=no,resizable =yes");		
}
</script>
<style type="text/css">
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
.Estilo1 {color: #0000FF}
</style></head>
<body>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="frmPrincipal" action="" method="post">
<table width="600"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr align="center" class="ColorTabla02">
    <td colspan="2"><strong>MODIFICACION DE CORRELATIVOS SISTEMA ESTADISTICO DE CATODOS</strong></td>
  </tr>
  <tr>
    <td width="150" bgcolor="#FFFFFF"><span class="Estilo1">Fecha</span></td>
    <td width="401">
      <input name="TxtFechaIni" type="text" class="InputCen" value="<?php echo $TxtFechaIni; ?>" size="13" maxlength="10" readonly >
      <img name='Calendario1' src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaIni,TxtFechaIni,popCal);return false">
      <!--<input name="TxtFechaFin" type="text" class="InputCen" value="<?php echo $TxtFechaFin; ?>" size="13" maxlength="10" readonly >
      <img name='Calendario1' src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaFin,TxtFechaFin,popCal);return false">-->
	  </td>
  </tr>
  <tr align="center">
    <td height="30" colspan="2">
	<input name="BtnConsultar" type="button" value="Consultar" style="width:70px " onClick="Proceso('C')">
	<input name="BtnImprimir" type="button" id="BtnImprimir" value="Imprimir" style="width:70px " onClick="Proceso('I')">
    <input name="BtnSalir" type="submit" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')"></td></tr>
</table><br>
<table width="600" border="1" align="center" cellpadding="2" cellspacing="0" >
  <tr class="ColorTabla02">
    <td width="20" align="center">&nbsp;</td>
	<td width="60" align="center">PATENTE</td>
    <td width="60" align="center">GUIA</td>
    <td width="60" align="center">CORR</td>
    <td width="60" align="center">COD.BULTO</td>
    <td width="60" align="center">NUM.BULTO</td>
    <td width="60" align="center">NUM.ENVIO</td>
  </tr>
<?php
if($Buscar=='S')
{
	$Consulta="select * from sec_web.guia_despacho_emb ";
	$Consulta.="where fecha_guia='".$TxtFechaIni."' and cod_estado != 'A' order by num_guia";
	//echo $Consulta;
	$RespSec=mysqli_query($link, $Consulta);
	while($FilaSec=mysqli_fetch_array($RespSec))
	{
		echo "<tr>";
		echo "<td align='center'><input type='radio' name='Opt' onclick=ModificarCorr('".trim($FilaSec["patente_guia"])."','".$FilaSec["num_guia"]."','".$FilaSec["num_secuencia"]."')></td>";
		echo "<td align='center'>".$FilaSec["patente_guia"]."</td>";
		echo "<td align='center'>".$FilaSec["num_guia"]."</td>";
		echo "<td align='center'>".$FilaSec["num_secuencia"]."</td>";
		echo "<td align='center'>".$FilaSec["cod_bulto"]."</td>";
		echo "<td align='center'>".$FilaSec["num_bulto"]."</td>";
		echo "<td align='right'>".$FilaSec["num_envio"]."</td>";
		echo "</tr>\n";			
	}
}
?>
</table>
</form>
</body>
</html>