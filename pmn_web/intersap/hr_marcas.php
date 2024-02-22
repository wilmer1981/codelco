<?php 	
	include("inter_funciones.php");
	include("hr_funciones1.php");
	if ($CreaArchivo=="S")
		HrCreaArchivoMarcas(&$NomArchivo);
	/*echo "PRUEBA<br>";
	$timestamp="1131020145";
	echo "DATE = ".date('H:i:s', $timestamp)."<br>";
	echo "DATE(TIMESTAMP) = ".date($timestamp)."<br>"; 	
	echo "DATE()=".date("Y-m-d", $timestamp)."<br><br>";
	echo "TIMESTAMP=".mktime(8,15,45,date("m"),date("d"),date("Y"))."<br><br>";
	$hor=date("H",$timestamp)-6;
	$min=date("i",$timestamp);
	$seg=date("s",$timestamp);
	if($hor>11)
	{
		$ampm="pm";
	}
	else
	{
		$ampm="am";
	}
	echo "HORA=".$hor.":".$min.":".$seg." ".$ampm."<br>"*/

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
      <td colspan="3" class="titulo_cafe">Marcas de Acceso </td>
    </tr>
    <tr>
      <td width="4%">1.-</td>
      <td width="19%">Nombre Archivo: </td>
      <td width="77%"><input name="NomArchivoOficial" type="text" id="NomArchivoOficial" value="<?php echo $NomArchivo; ?>">
      <input name="imageField22" type="image" class="SinBorde" onClick="Enviar(this.form,'inter_menu.php?CreaArchivo=S&Pagina=hr_marcas.php','');" src="archivos/crear_archivo.gif" align="middle" width="113" height="26" border="0"></td>
    </tr>
    <tr align="center">
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr align="center">
      <td colspan="3"><input class="SinBorde" name="imageField3" type="image" src="archivos/volver.gif" width="113" height="26" border="0" onClick="Enviar(this.form,'inter_menu.php?Pagina=hr_genera.php','');"></td>
    </tr>
  </table>
</form>
</body>
</html>
