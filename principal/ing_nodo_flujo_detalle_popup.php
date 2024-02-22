<?php
	//include("../principal/conectar_comet_web.php");
	include("../principal/conectar_principal.php");

	$nodo			=$_REQUEST["nodo"];
	$sistema		=$_REQUEST["sistema"];

?>
<html>
<head>
<title>Detalle Flujo</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(opc, valor, tipo)
{	
	var f = document.FrmDetallePopUp;
	
	switch (opc) {
		case 'C':
			linea = "opc=M&nodo=" + f.nodo.value + "&sistema=" + f.sistema.value + "&flujo=" + valor + "&tipo2=" + tipo;
			window.opener.document.FrmDetalle.action = "ing_nodo_flujo_detalle.php?" + linea;
			window.opener.document.FrmDetalle.submit();
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
  <table width="450" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
    <tr align="center"> 
      <td colspan="2">Flujos Asociados</td>
    </tr>
  </table>
  <br>
  <table width="450" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
    <tr class="ColorTabla01"> 
      <td width="65" height="20" align="center">Flujo</td>
      <td width="252" align="center">Descripcion</td>
      <td width="58" align="center">Tipo</td>
    </tr>
<?php
	$consulta = "SELECT * FROM proyecto_modernizacion.flujos";
	$consulta.= " WHERE sistema = '".$sistema."' and nodo = '".$nodo."' AND cod_flujo NOT IN ('A+', 'A-')";
	$consulta.= " ORDER BY tipo, orden2,orden";

	$rs = mysqli_query($link, $consulta);
	while($row = mysqli_fetch_array($rs))
	{
		echo '<tr>';
      	echo '<td align="left"><input type="radio" name="radio" onClick="Proceso(\'C\',\''.$row["cod_flujo"].'\', \''.$row["tipo"].'\')">'.$row["cod_flujo"].'</td>';
      	echo '<td align="left">'.$row["descripcion"].'</td>';
      	echo '<td align="center">'.$row["tipo"].'</td>';
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
