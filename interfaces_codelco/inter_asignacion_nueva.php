<?php
	$CodigoDeSistema = 21;
	$CodigoDePantalla = 7;
	include("../principal/conectar_principal.php");

?>
<html>
<head>
<title>Ingreso de Proyecciones</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opc)
{
	var f = document.FrmPrincipal;

	switch(opc)
	{
		case "G": 
			f.action="sea_ing_proyecciones01.php?Proceso=G";
			f.submit();
			break;		
		case "S":
			document.location = "../principal/sistemas_usuario.php?CodSistema=21&Nivel=3&CodPantalla=6";										 	
			break;
	}

}
</script>
<style type="text/css">
<!--
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>

<body>
<form name="FrmPrincipal" method="post" action="">
<?php include("../principal/encabezado.php")?>
<table width="770" height="330" border="0" class="TablaPrincipal"> 
<tr> 
	<td align="center" valign="top">
	  <p><b>C R E A C I O N  &nbsp;&nbsp;D E &nbsp;&nbsp;A S I G N A C I O N </b></p>
        <table width="320" border="1" cellspacing="0" cellpadding="0" class="TablaDetalle">
		<tr>
		  <td>RUT PROVEEDOR</td>
		  <td><input type="text" name="rut" style="width:80px" value="<?php echo $rut; ?>"></td>  
		</tr>
		<tr>
		  <td>ASIGNACION</td>
		  <td><input type="text" name="asigna" style="width:80px" value="<?php echo $asigna; ?>"></td>
		</tr>
		<tr>
		  <td>ENTRADA</td>
		  <td><input type="text" name="entra" style="width:80px" value="<?php echo $entra; ?>"></td>
		</tr>
		<tr>
		  <td>SALIDA</td>
		  <td><input type="text" name="sale" style="width:80px" value="<?php echo $sale; ?>"></td>
		</tr>
	  </table>
	  <br>
	  <table width="320" border="1" cellspacing="0" cellpadding="0" class="TablaDetalle">
		<tr>
		  <td width="319" align="center">
		  <input type="button" name="BtnGrabar" value="Grabar" style="width:70px" onClick="Proceso('G');">
		  <input type="button" name="BtnSalir" value="Salir" style="width:70px" onClick="Proceso('S');">
		  </td>
		</tr>
	  </table>	</td>
</tr>
</table>
<?php include("../principal/pie_pagina.php")?>
</form>

</body>
</html>
