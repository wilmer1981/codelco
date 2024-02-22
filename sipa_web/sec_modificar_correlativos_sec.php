<?php
	echo date('h:i:s')."<BR>";
	echo date('G:i:s')."<BR>";
	include("../principal/conectar_principal.php");
	include("funciones.php");
	if(!isset($TxtFechaIni))
		$TxtFechaIni=date('Y-m-d');
	$TxtFechaIniMes=substr(date('Y-m-d'),0,7)."-01";	
	//$TxtFechaFin=date('Y-m-d');
		
	/*if ($OpcConsulta == "P" || $OpcConsulta == "C")
	{
		$CmbMes = str_pad($CmbMes,2,"0",STR_PAD_LEFT);
		$TxtFechaIni = $CmbAno."-".$CmbMes."-01";
		$TxtFechaFin = date("Y-m-d", mktime(0,0,0,$CmbMes+1,1,$CmbAno));
		$TxtFechaFin = date("Y-m-d", mktime(0,0,0,substr($TxtFechaFin,5,2),1-1,substr($TxtFechaFin,0,4)));
	}*/
?>
<html>
<head>
<title>Informe Recepciones por Producto</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{		
		case "C":
			f.action = "rec_con_conjuntos_web.php?Buscar=S";
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
			f.action = "../principal/sistemas_usuario.php?CodSistema=24";
			f.submit();
			break;
	}
}
</script>
<style type="text/css">
<!--
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
.Estilo1 {color: #0000FF}
-->
</style></head>

<body>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="frmPrincipal" action="" method="post">
<table width="600"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr align="center" class="ColorTabla02">
  	<?php
		switch($CmbTipoRegistro)
		{
			case "R"://RECEPCION
				$NombreCons='RECEPCIONES';
				break;
			case "D"://DESPACHOS
				$NombreCons='DESPACHOS';
				break;
		}	
	?>
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
	$TotalRecep=0;
	$Consulta="SELECT * from sec_web.guia_despacho_emb ";
	$Consulta.="where fecha_guia='".$TxtFechaIni."'";
	//echo $Consulta;
	$RespSec=mysqli_query($link, $Consulta);
	while($FilaSec=mysqli_fetch_array($RespSec))
	{
		echo "<tr>";
		echo "<td align='center'>".$FilaSec["patente"]."</td>";
		echo "<td align='right'>".$FilaSec["guia"]."</td>";
		echo "<td align='center'>".$FilaSec["correlativo"]."</td>";
		echo "<td>".$FilaSec["cod_bulto"]."</td>";
		echo "<td align='center'>".$FilaSec["num_bulto"]."</td>";
		echo "<td align='right'>".$FilaSec["num_envio"]."</td>";
		echo "</tr>";			
	}
}
?>
</table>
</form>
</body>
</html>