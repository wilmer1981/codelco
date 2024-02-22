<?php 	
	include("inter_funciones.php");
	include("fico_funciones1.php");
	if ($CreaArchivo=="S")
		FicoCreaArchivoFacPrv(&$NomArchivo);
	if ($CargaArchivo=="S")
		FicoCargaArchivoFacVen();		
?>
<html>
<head>
<title>fico_maestro_procomi</title>
<script language="javascript" src="inter_funciones_js.js"></script>
</head>

<body>
<form name="frmFicoProcomi" method="post" action="">
  <table width="90%"  border="0" align="center">
    <tr>
      <td colspan="3" class="titulo_cafe">Facturas de Ventas </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>1</td>
      <td>Carga Archivo CVS: </td>
      <td><input name="imageField222" type="image" class="SinBorde" onClick="Enviar(this.form,'inter_menu.php?CargaArchivo=S&Pagina=fico_fac_ven.php','');" src="archivos/aceptar.gif" align="middle" width="113" height="26" border="0"></td>
    </tr>
    <tr>
      <td width="4%">2.-</td>
      <td width="21%">Nombre Archivo: </td>
      <td width="75%"><input name="NomArchivo" type="text" id="NomArchivo" value="<?php echo $NomArchivo; ?>">
      <input name="imageField22" type="image" class="SinBorde" onClick="Enviar(this.form,'inter_menu.php?CreaArchivo=S&Pagina=fico_fac_ven.php','');" src="archivos/crear_archivo.gif" align="middle" width="113" height="26" border="0"></td>
    </tr>
    <tr align="center">
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr align="center">
      <td colspan="3"><input class="SinBorde" name="imageField3" type="image" src="archivos/volver.gif" width="113" height="26" border="0" onClick="Enviar(this.form,'inter_menu.php?Pagina=fico_genera.php','');"></td>
    </tr>
  </table>
</form>
</body>
</html>
