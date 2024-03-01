<?php
	include("../principal/conectar_sec_web.php");	

	$Valores  = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
?>
<html>
<head>
<title>Detalle Transporte</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso()
{	
	window.close();
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmDetalleTrans" action="" method="post">
<input name="nodo" type="hidden" value="<?php echo $nodo ?>">
<input name="sistema" type="hidden" value="<?php echo $sistema ?>">
  <table width="450" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
    <tr align="center"> 
      <td colspan="2">Detalle Transporte </td>
    </tr>
  </table>
  <br>
  <table width="500" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
    <tr class="ColorTabla01"> 
      <td width="100" align="center">Rut Chofer</td>
      <td width="200" align="center">Nombre Chofer</td>
	  <td width="100" align="center">Fono Chofer</td>
	  <td width="100" align="center">Patente Camion</td>
    </tr>
<?php
	$Datos=explode('//',$Valores);
	$TxtRutTransportista=$Datos[0];
	$consulta = "SELECT distinct t2.patente_camion, t2.rut_chofer, t3.nombre_persona, t3.fono1_persona ";
	$consulta.= "FROM sec_web.transporte t1 left join sec_web.transporte_persona t2 on t1.rut_transportista=t2.rut_transportista left join ";
	$consulta.= " sec_web.persona t3 on t2.rut_chofer=t3.rut_persona ";
	$consulta.= " WHERE t1.rut_transportista='$TxtRutTransportista' ";
	$consulta.= " ORDER BY t2.rut_chofer";
	//echo $consulta;
	$rs = mysqli_query($link, $consulta);
	while($row = mysqli_fetch_array($rs))
	{
		echo '<tr>';
      	echo '<td align="right">'.$row["rut_chofer"].'</td>';
      	echo '<td align="left">&nbsp;'.$row["nombre_persona"].'</td>';
		echo '<td align="left">&nbsp;'.$row["fono1_persona"].'</td>';
		echo '<td align="left">&nbsp;'.$row["patente_camion"].'</td>';
    	echo '</tr>';
	}
?>
  </table>
  <br>
  <table width="450" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
    <tr>
      <td align="center"><input name="btnsalir" type="button" id="btnsalir" value="Salir" style="width=80" onClick="Proceso()"></td>
    </tr>
  </table>
</form>
</body>
</html>
