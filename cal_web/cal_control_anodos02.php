<?php
	include("../principal/conectar_principal.php");

	if(isset($_REQUEST["TipoProducto"])) {
		$TipoProducto = $_REQUEST["TipoProducto"];
	}else{
		$TipoProducto ="";
	}
	if(isset($_REQUEST["Valores"])) {
		$Valores = $_REQUEST["Valores"];
	}else{
		$Valores ="";
	}
	if(isset($_REQUEST["TxtCodigo"])) {
		$TxtCodigo = $_REQUEST["TxtCodigo"];
	}else{
		$TxtCodigo ="";
	}
	if(isset($_REQUEST["TxtDescripcion"])) {
		$TxtDescripcion = $_REQUEST["TxtDescripcion"];
	}else{
		$TxtDescripcion ="";
	}
	

	if (!isset($TxtCodigo) || $TxtCodigo=="")
	{
		$Consulta = "SELECT max(corr) as ultimo from sea_web.limites ";
		$Resp=mysqli_query($link, $Consulta);
		if ($Fila=mysqli_fetch_array($Resp))
			$TxtCodigo=$Fila["ultimo"]+1;
		else
			$TxtCodigo=1;
	}
?>	
<html>
<head>
<title>CAL-Control de Anodos</title>
<link href="../principal/estilos/css_rec_web.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<script language="javascript">
function Proceso(opt)
{
	var f=document.frmPopUp;
	switch (opt)
	{
		case "G":
			if  (f.TxtCodigo.value=="")
			{
				alert("No hay Codigo Seleccionado");
				return;
			}
			if  (f.TxtDescripcion.value=="")
			{
				alert("Debe Ingresar Descripcion");
				f.TxtDescripcion.focus();
				return;
			}
			f.action="cal_control_anodos01.php?Proceso=G";
			f.submit();
			break;
		case "S":
			window.close();
			break;
	}
}
</script>
<style type="text/css">
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
</style></head>

<body>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="frmPopUp" action="" method="post">
<input type="hidden" name="Valores" value="<?php echo $Valores; ?>">
<input type="hidden" name="TipoProducto" value="<?php echo $TipoProducto; ?>">
<table width="413" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#000000">
  <tr>
    <td colspan="2" align="center" bgcolor="#FFFFFF" class="ColorTabla01">NUIEVA PLANTILLA </td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td width="90" bgcolor="#FFFFFF">Codigo:</td>
    <td width="399" bgcolor="#FFFFFF"><input name="TxtCodigo" type="text" class="InputColor" id="TxtCodigo" value="<?php echo $TxtCodigo; ?>" size="7" maxlength="5" readonly></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">Descripcion:</td>
    <td bgcolor="#FFFFFF"><input name="TxtDescripcion" type="text" id="TxtDescripcion" value="<?php echo $TxtDescripcion; ?>" size="50" maxlength="100"></td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr align="center">
    <td colspan="2" bgcolor="#FFFFFF" class="Detalle02"><input name="BtnGrabar" type="button" id="BtnGrabar" value="Grabar" style="width:70px " onClick="Proceso('G')">
      <input name="BtnCerrar" type="button" id="BtnCerrar" value="Cerrar" style="width:70px " onClick="Proceso('S')"></td>
  </tr>
</table>
</form>
</body>
</html>
