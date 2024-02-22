<?php 	
	include("inter_funciones.php");
	include("fico_funciones.php");
	if ($CreaArchivoActFijo=="S")
		FicoCreaArchivoPresupuesto(&$NomArchivoOficial);		
	if ($CreaArchivoActFijo2=="S")
		FicoCreaArchivoPresupuestoHistorico(&$NomArchivoOficial);		
	//$N=(80%12);
	//echo $N."<br>";
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
      <td colspan="3" class="titulo_cafe">Presupuesto</td>
    </tr>
    <tr>
      <td width="4%">1.-</td>
      <td width="23%">Nombre Archivo:(2006) </td>
      <td width="73%"><input name="NomArchivoOficial" type="text" id="NomArchivoOficial" value="<?php echo $NomArchivoOficial; ?>">
      <input name="imageField22" type="image" class="SinBorde" onClick="Enviar(this.form,'inter_menu.php?CreaArchivoActFijo=S&Pagina=fico_presupuesto.php','');" src="archivos/crear_archivo.gif" align="middle" width="113" height="26" border="0">
      </td>
    </tr>
    <tr align="center">
      <td><div align="left">2.-</div></td>
      <td><div align="left">Nombre Archivo(Historico) </div></td>
      <td><div align="left">
        <input name="NomArchivoOficial3" type="text" id="NomArchivoOficial3" value="<?php echo $NomArchivoOficial; ?>">
        <input name="imageField222" type="image" class="SinBorde" onClick="Enviar(this.form,'inter_menu.php?CreaArchivoActFijo2=S&Pagina=fico_presupuesto.php','');" src="archivos/crear_archivo.gif" align="middle" width="113" height="26" border="0">
      </div></td>
    </tr>
    <tr align="center">
      <td colspan="3"><input class="SinBorde" name="imageField3" type="image" src="archivos/volver.gif" width="113" height="26" border="0" onClick="Enviar(this.form,'inter_menu.php?Pagina=fico_genera.php','');"></td>
    </tr>
  </table>
</form>
</body>
</html>
