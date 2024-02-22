<?php
	include("../principal/conectar_principal.php");	

	if(isset($_GET["Valores"])){
		$Valores = $_GET["Valores"];
	}else{
		$Valores = "";
	}
?>
<html>
<head>
<title>Detalle SubProducto</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso()
{	
	window.close();
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmDetallePopUp" action="" method="post">
<input name="nodo" type="hidden" value="<?php echo $nodo; ?>">
<input name="sistema" type="hidden" value="<?php echo $sistema; ?>">
  <table width="450" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
    <tr align="center"> 
      <td colspan="2">SubProductos Asociados</td>
    </tr>
  </table>
  <br>
  <table width="500" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
    <tr class="ColorTabla01"> 
      <td width="21" align="center">Cod</td>
      <td width="204" align="center">Descripcion SubProducto</td>
	  <td width="74" align="center">Abreviatura</td>
	  <td width="82" align="center">Rut Proveedor </td>
      </tr>
<?php
	$Datos=explode('//',$Valores);
	$TxtCodigo=$Datos[0];
	$consulta = "SELECT * FROM proyecto_modernizacion.subproducto";
	$consulta.= " WHERE cod_producto='$TxtCodigo'";
	$consulta.= " ORDER BY cod_producto";
	$rs = mysqli_query($link, $consulta);
	while($row = mysqli_fetch_array($rs))
	{
		echo '<tr>';
      	echo '<td align="right">'.$row["cod_subproducto"].'</td>';
      	echo '<td align="left">&nbsp;'.$row["descripcion"].'</td>';
		echo '<td align="left">&nbsp;'.$row["abreviatura"].'</td>';
		echo '<td align="left">&nbsp;'.$row["rut_prov"].'</td>';
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
