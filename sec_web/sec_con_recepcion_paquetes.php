<?php	
include("../principal/conectar_sec_web.php"); 
$producto    = isset($_REQUEST["producto"])?$_REQUEST["producto"]:"";
$subproducto = isset($_REQUEST["subproducto"])?$_REQUEST["subproducto"]:"";
$recargo     = isset($_REQUEST["recargo"])?$_REQUEST["recargo"]:"";
$lote        = isset($_REQUEST["lote"])?$_REQUEST["lote"]:"";

?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Imprimir()
{
	window.print();
}
/**************/
function Salir()
{
	window.close();
}
</script>
</head>

<body background="../Principal/imagenes/fondo3.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="450" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td align="center"><strong>RECEPCION EXTERNA DE PAQUETES</strong></td>
  </tr>
  <tr> 
    <td align="center"><strong>
	<?php
		
		$consulta = "SELECT * FROM proyecto_modernizacion.subproducto";
		$consulta.= " WHERE cod_producto = '".$producto."' AND cod_subproducto = '".$subproducto."'"; 
		$rs = mysqli_query($link,$consulta);
		$row = mysqli_fetch_array($rs);
		echo $row["descripcion"];		
	?>
	</strong></td>
  </tr>
</table>
<br>
<table width="450" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
  <tr class="ColorTabla01">
    <td width="200" align="center"><strong>Cod. Paquete</strong></td>
    <td width="200" align="center"><strong>Unidades</strong></td>
    <td width="200" align="center"><strong>Peso</strong></td>
  </tr>
  
<?php
	$consulta = "SELECT * FROM sec_web.paquete_catodo_externo";
	$consulta.= " WHERE lote_origen = '".$lote."' AND recargo = '".$recargo."'";
	$rs1 = mysqli_query($link,$consulta);
	
	$cant_paq = 0;
	$cant_unid = 0;
	$cant_peso = 0;
	while ($row1 = mysqli_fetch_array($rs1))
	{
		echo '<tr>';
		echo '<td  align="center">'.$row1["cod_paquete"].' - '.$row1["num_paquete"].'</td>';
		echo '<td  align="center">'.$row1["num_unidades"].'</td>';
		echo '<td  align="center">'.$row1["peso_paquete"].'</td>';
		echo '</tr>';
			
		$cant_paq++;
		$cant_unid = $cant_unid + $row1["num_unidades"];
		$cant_peso = $cant_peso + $row1["peso_paquete"];
	}
?>  
</table>
<br>
<table width="450" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
  <tr>
    <td width="147"><strong>Total Paquetes</strong></td>
    <td width="297"><?php echo $cant_paq ?></td>
  </tr>
  <tr>
    <td><strong>Total Unidades</strong></td>
    <td><?php echo $cant_unid ?></td>
  </tr>
  <tr>
    <td><strong>Total Peso</strong></td>
    <td><?php echo $cant_peso ?></td>
  </tr>
</table>
<br>
<table width="450" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td align="center"><input name="btninprimir" type="button" style="width:70" value="Imprimir" onClick="Imprimir()">
      <input name="btnsalir" type="button" style="width:70" value="Salir" onClick="Salir()"></td>
  </tr>
</table>
</body>
</html>
<?php include("../principal/cerrar_sec_web.php") ?>