<?php 	
	include("inter_funciones.php");
	include("fico_funciones.php");
	if ($CreaArchivoFacBolPen=="S")
		FicoCreaArchivoFacBolPen(&$NomArchivoOficial);		
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
      <td colspan="3" class="titulo_cafe"> Boletas de Garantias Pendientes </td>
    </tr>
    <tr>
      <td width="4%">1.-</td>
      <td width="19%">xxxxxxxNombre Archivo: </td>
      <td width="77%"><input name="NomArchivoOficial" type="text" id="NomArchivoOficial" value="<?php echo $NomArchivoOficial; ?>">
      <input name="imageField22" type="image" class="SinBorde" onClick="Enviar(this.form,'inter_menu.php?CreaArchivoFacBolPen=S&Pagina=fico_facbol_pendientes.php','');" src="archivos/crear_archivo.gif" align="middle" width="113" height="26" border="0"></td>
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
