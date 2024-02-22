<?php
	include("../principal/conectar_principal.php");	
?>
<html>
<head>
<title>Persona Asociadas</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(opc,Valores,Valor,Valor2)
{	
	var f = document.FrmDetallePopUp;
	var linea='';
	
	switch (opc) 
	{
		case 'C':
			linea = "Proceso=MP&Valores=" + Valores + "&rut_persona=" + Valor+ "&Patente=" + Valor2;
			window.opener.document.FrmProceso.action = "ingreso_transporte_persona_proceso2.php?" + linea;
			window.opener.document.FrmProceso.submit();
			window.close();
			break;
		case 'S':
			window.close();
			break;		
	}	
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmDetallePopUp" action="" method="post">
<input name="nodo" type="hidden" value="<?php echo $nodo ?>">
<input name="sistema" type="hidden" value="<?php echo $sistema ?>">
  <table width="504" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
    <tr align="center"> 
      <td width="495" colspan="2">Personas Asociadas</td>
    </tr>
  </table>
  <br>
  <table width="504" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
    <tr class="ColorTabla01"> 
      <td width="20" height="20" align="center">&nbsp;</td>
      <td width="92" align="center">Rut Chofer </td>
      <td width="177" align="center">Nombre Chofer </td>
	  <td width="82" align="center">Fono Chofer </td>
	  <td width="120" align="center">Patente Camion </td>
    </tr>
<?php
	$Datos=explode('//',$Valores);
	$TxtRutTransportista=$Datos[0];
	$consulta = "SELECT distinct tp.patente_camion, tp.rut_chofer, p.nombre_persona, p.fono1_persona ";
	$consulta.= "FROM sec_web.persona p, sec_web.transporte_persona tp, sec_web.transporte t ";
	$consulta.= " WHERE t.rut_transportista='$TxtRutTransportista' and t.rut_transportista=tp.rut_transportista and ";
	$consulta.= " tp.rut_chofer=p.rut_persona ";
	$consulta.= " ORDER BY tp.rut_chofer";
	$rs = mysqli_query($link, $consulta);
	while($row = mysqli_fetch_array($rs))
	{
		echo '<tr>';
      	echo '<td align="left"><input type="radio" name="radio" onClick="Proceso(\'C\',\''.$Valores.'\', \''.$row["rut_chofer"].'\', \''.$row[patente_camion].'\')"></td>';
      	echo '<td align="right">'.$row[rut_chofer].'</td>';
      	echo '<td align="left">&nbsp;'.$row[nombre_persona].'</td>';
		echo '<td align="left">&nbsp;'.$row[fono1_persona].'</td>';
		echo '<td align="left">&nbsp;'.$row[patente_camion].'</td>';
    	echo '</tr>';
	}
?>
  </table>
  <br>
  <table width="450" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
    <tr>
      <td align="center"><input name="btnsalir" type="button" id="btnsalir" value="Salir" style="width=80" onClick="Proceso('S', '','')"></td>
    </tr>
  </table>
</form>
</body>
</html>
