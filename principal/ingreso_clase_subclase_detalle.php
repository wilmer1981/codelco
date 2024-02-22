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
<title>Detalle SubClase</title>
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
<input name="nodo" type="hidden" value="<?php echo $nodo ?>">
<input name="sistema" type="hidden" value="<?php echo $sistema ?>">
  <table width="450" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
    <tr align="center"> 
      <td colspan="2">SubClases Asociadas</td>
    </tr>
  </table>
  <br>
  <table width="500" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
    <tr class="ColorTabla01"> 
      <td width="22" align="center">Cod</td>
      <td width="170" align="center">Nombre SubClase</td>
	  <td width="77" align="center">Valor1</td>
	  <td width="82" align="center">Valor2</td>
      <td width="66" align="center">Valor3</td>
      <td width="68" align="center">Valor4</td>
    </tr>
<?php
	$Datos=explode('//',$Valores);
	$TxtCodigo=$Datos[0];
	$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase";
	$consulta.= " WHERE cod_clase='$TxtCodigo'";
	$consulta.= " ORDER BY cod_subclase";
	$rs = mysqli_query($link, $consulta);
	while($row = mysqli_fetch_array($rs))
	{
		echo '<tr>';
      	echo '<td align="right">'.$row["cod_subclase"].'</td>';
      	echo '<td align="left">&nbsp;'.$row["nombre_subclase"].'</td>';
		echo '<td align="left">&nbsp;'.$row["valor_subclase1"].'</td>';
		echo '<td align="left">&nbsp;'.$row["valor_subclase2"].'</td>';
		echo '<td align="left">&nbsp;'.$row["valor_subclase3"].'</td>';
		echo '<td align="left">&nbsp;'.$row["valor_subclase4"].'</td>';
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
