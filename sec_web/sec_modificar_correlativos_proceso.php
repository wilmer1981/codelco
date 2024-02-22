<?php
	include("../principal/conectar_principal.php");
	if(!isset($PatenteOri))
	  $PatenteOri=$Patente;

?>
<html>
<head>
<title>Proceso</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript">
function Proceso(opt)
{
	var f = document.frmProceso;
	switch (opt)
	{
		case "G":
			f.action = "sec_modificar_correlativos_proceso01.php";
			f.submit();
			break;
		case "S":
		    window.opener.document.frmPrincipal.action = 'sec_modificar_correlativos.php?Buscar=S';
			window.opener.document.frmPrincipal.submit();
			window.close();
			break;
	}
}
</script>
<style type="text/css">
<!--
body {
	background-image: url(../principal/imagenes/fondo3.gif);
	margin-left: 10px;
	margin-top: 10px;
	margin-right: 3px;
	margin-bottom: 6px;
}
-->
</style><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body>
<form name="frmProceso" method="post" action="">
<table width="500"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr class="ColorTabla01">
    <td colspan="2"><strong>MODIFICACION CORRELATIVO</strong></td>
  </tr>
  <tr class="Colum01">
    <td class="Colum01">Patente</td>
    <td class="Colum01">      <input type="text" name="PatenteOri" value="<?php echo $PatenteOri;?>" readonly="true" size="12"></td>
  </tr>
  <tr class="Colum01">
    <td width="87" class="Colum01">Guia</td>
    <td width="398" class="Colum01"><input type="text" name="TxtGuia" value="<?php echo $Guia;?>" readonly="true" size="12"></td>
    </tr>
  <tr class="ColorTabla02">
    <td colspan="2" class="Colum01"><strong>VALORES A MODIFICAR </strong></td>
    </tr>
  <tr class="Colum01">
    <td class="Colum01">Patente</td>
    <td class="Colum01"><input type="text" name="TxtPatente" value="<?php echo $Patente;?>" size="12"></td>
  </tr>
  <tr class="Colum01">
    <td class="Colum01">Correlativo Sipa </td>
    <td class="Colum01"><input name="TxtCorr" type="text" class="InputDer" value="<?php echo $TxtCorr; ?>" size="12" maxlength="8" onKeyDown="TeclaPulsada2('S',false,this.form,'BtnGuardar');"></td>
  </tr>
  <tr class="Colum01">
    <td class="Colum01">&nbsp;</td>
    <td class="Colum01">&nbsp;</td>
  </tr>
  <tr align="center" class="Colum01">
    <td height="30" colspan="2" class="Colum01"><input name="BtnGuardar" type="button" id="BtnGuardar3" value="Guardar" style="width:70px " onClick="Proceso('G')">      
      <input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
    </tr>
</table>
</form>
</body>
</html>
