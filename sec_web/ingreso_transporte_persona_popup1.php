<?php
	include("../principal/conectar_principal.php");	
?>
<html>
<head>
<title>Patentes Ingresadas</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(opc,Valores,Valor)
{	
	var f = document.FrmDetallePopUp;
	var linea='';
	
	switch (opc) 
	{
		case 'C':
			linea = "Proceso=IP&Valores="+ Valores +"&Patente="+Valor;
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
  <table width="206" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
    <tr align="center"> 
      <td width="197" colspan="2">Patentes Ingresadas </td>
    </tr>
  </table>
  <br>
  <table width="146" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
    <tr class="ColorTabla01"> 
      <td width="20" height="20" align="center">&nbsp;</td>
      <td width="120" align="center">Patente Camion </td>
    </tr>
<?php	
	$Datos=explode('//',$Valores);
	$TxtRutTransportista=$Datos[0];
	$consulta = "SELECT distinct patente_transporte FROM sec_web.transporte ";
	$consulta.= " WHERE rut_transportista='$TxtRutTransportista' ";
	$consulta.= " ORDER BY patente_transporte";
	$rs = mysqli_query($link, $consulta);
	while($row = mysqli_fetch_array($rs))
	{
		echo '<tr>';
      	echo '<td align="left"><input type="radio" name="radio" onClick="Proceso(\'C\',\''.$Valores.'\', \''.$row[patente_transporte].'\')"></td>';
      	echo '<td align="left">&nbsp;'.$row[patente_transporte].'</td>';
    	echo '</tr>';
	}
?>
  </table>
  <br>
  <table width="207" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
    <tr>
      <td width="293" align="center"><input name="btnsalir" type="button" id="btnsalir" value="Salir" style="width=80" onClick="Proceso('S', '','')"></td>
    </tr>
  </table>
</form>
</body>
</html>
