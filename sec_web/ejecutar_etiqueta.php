<?php
	include("../principal/conectar_sec_web.php");
	$Consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 3106 and cod_subclase='1'";
	$rs = mysqli_query($link, $Consulta);
	$row = mysqli_fetch_array($rs);
	$RutaExe=$row["nombre_subclase"];


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>
</head>
<body>
<form name="FrmEtiqueta">
<input name="RutaExe" type="text" value="<?php echo $RutaExe;?>"
</form>
</body>
</html>
<script language="vbscript">

//MsgBox """" & FrmEtiqueta.RutaExe.value  & """"

Set WShell = CreateObject("WScript.Shell")
WShell.Run """" & FrmEtiqueta.RutaExe.value & """"
//WShell.Run """C:\Archivos de programa\ImpresionEtiquetas\ImpresionEtiquetas.exe""" 
</script>

<script language="JavaScript">
window.close();
</script>