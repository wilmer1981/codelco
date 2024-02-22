<?php
 include("../principal/conectar_sec_web.php"); 
?>
<html>
<head>
<title>RESUMEN TOTALES EMBARQUE</title>
<script language="JavaScript">
function Salir()
{
	window.history.back();
}
/***********/
function Imprimir()
{
	window.print();
}
</script><link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
</head>

<body class="TablaPrincipal">
<table width="320" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr class="ColorTabla01">
    <td align="center" colspan="10">RESUMEN TOTALES EMBARQUE</td>
  </tr>
  <tr class="ColorTabla02"> 
    <td align="center" colspan="10">PERIODO:  <?php echo $dia.'/'.$mes.'/'.$ano ?> AL  <?php echo $dia2.'/'.$mes2.'/'.$ano2 ?></td>
  </tr>
</table>
	<br>
<table width="617" height="14"  border="1" align="center" cellpadding="0" cellspacing="0">
  <tr class="ColorTabla01">
	<td width="78" align="center">CODIGO</td>
	<td width="294" align="center">DESCRIPCION PRODUCTO</td>
	<td width="75" align="center">PESO</td>
	<td width="82" align="center">PAQUETES</td>
	<td width="76" align="center">UNIDADES</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>	
  <tr class="ColorTabla02">
    <td colspan="2">TOTAL</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>	
</table>	
	<br>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
	<td align="center">
    <input name="btnimprimir" type="button" value="Imprimir" style="width:70;" onClick="JavaScript:Imprimir()">
	<input name="btnsalir" type="button" style="width:70" onClick="JavaScript:Salir()" value="Salir"></td>
  </tr>
</table>

</body>
</html>
<?php include("../principal/cerrar_ram_web.php") ?>