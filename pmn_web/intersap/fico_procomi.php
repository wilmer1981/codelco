<?php 	
	include("inter_funciones.php");
	include("fico_funciones.php");
	if ($ProcesaTablas=="S")
		FicoCreaTablaProcomi();	
	if ($CreaArchivo=="S")
		FicoCreaArchivoProcomi(&$NomArchivo);	
	if ($CreaArchivoMaProv=="S")
		FicoCreaArchivoMaProv(&$NomArchivoOficial);		
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
      <td colspan="3" class="titulo_cafe">Archivo Preliminar (solo Rut, tipo, cod_banco, cta_cte) </td>
    </tr>
    <tr>
      <td width="4%">1.-</td>
      <td width="19%">Juntar Tablas:</td>
      <td width="77%"><input class="SinBorde" name="imageField" type="image" src="archivos/aceptar.gif" width="113" height="26" border="0" onClick="Enviar(this.form,'inter_menu.php?ProcesaTablas=S&Pagina=fico_procomi.php','');">
      </td>
    </tr>
    <tr>
      <td>2.-</td>
      <td align="right">Nombre Archivo: </td>
      <td><input name="NomArchivo" type="text" id="NomArchivo" value="<?php echo $NomArchivo; ?>">
      <input name="imageField23" type="image" class="SinBorde" onClick="Enviar(this.form,'inter_menu.php?CreaArchivo=S&Pagina=fico_procomi.php','');" src="archivos/crear_archivo.gif" align="middle" width="113" height="26" border="0"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr align="center">
      <td colspan="3">&nbsp;        </td>
    </tr>
    <tr>
      <td colspan="3" class="titulo_cafe">Archivo Oficial </td>
    </tr>
    <tr>
      <td>1.-</td>
      <td>Nombre Archivo: </td>
      <td><input name="NomArchivoOficial" type="text" id="NomArchivoOficial" value="<?php echo $NomArchivoOficial; ?>">
      <input name="imageField22" type="image" class="SinBorde" onClick="Enviar(this.form,'inter_menu.php?CreaArchivoMaProv=S&Pagina=fico_procomi.php','');" src="archivos/crear_archivo.gif" align="middle" width="113" height="26" border="0"></td>
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
