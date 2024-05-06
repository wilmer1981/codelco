<?php
	include("conectar_principal.php");

	$Error  = isset($_REQUEST["Error"])?$_REQUEST["Error"]:"";
	$Proceso  = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Sistema  = isset($_REQUEST["Sistema"])?$_REQUEST["Sistema"]:"";
	$Mensaje = isset($_REQUEST["Mensaje"])?$_REQUEST["Mensaje"]:"";
	
	$Modificar= isset($_REQUEST["Modificar"])?$_REQUEST["Modificar"]:"";
	$Orden    = isset($_REQUEST["Orden"])?$_REQUEST["Orden"]:"";
	$NivelSistema  = isset($_REQUEST["NivelSistema"])?$_REQUEST["NivelSistema"]:"";
	$NomSistema  = isset($_REQUEST["NomSistema"])?$_REQUEST["NomSistema"]:"";
	$Descripcion =isset($_REQUEST["Descripcion"])?$_REQUEST["Descripcion"]:"";
	
	
	$EstadoInput ="";


	switch ($Proceso)
	{
		case "NS":
			$Consulta = "select max(cod_sistema) as max_sistema from proyecto_modernizacion.sistemas ";
			$Consulta.= " where cod_sistema <> '99' ";
			$Resp = mysqli_query($link,$Consulta);
			if ($Fila = mysqli_fetch_array($Resp))
				$Sistema = $Fila["max_sistema"] + 1;
			else
				$Sistema = 1;
				$Anexo = "N";
				$NomSistema = "";
				$Descripcion = "";
			break;
		case "MS":
			$EstadoInput = "readonly";
			$Consulta = "select * from proyecto_modernizacion.sistemas ";
			$Consulta.= " where cod_sistema = '".$Sistema."' ";
			$Resp = mysqli_query($link,$Consulta);
			if ($Fila = mysqli_fetch_array($Resp))
			{
				$Sistema    = $Fila["cod_sistema"];
				$Anexo      = $Fila["cierre"];
				$NomSistema = $Fila["nombre"];
				$Descripcion = $Fila["descripcion"];
			}
			else
			{
				$Sistema = "";
				$Anexo = "N";
				$NomSistema = "";
				$Descripcion = "";
			}
			break;
	}
?>
<html>
<head>
<title>Administraci&oacute;n de Sistema</title>
<link href="estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/funciones_java.js"></script>
<script language="javascript">
function Proceso(opt)
{
	var f = frmMantSistema;
	var Valores = "";
	switch (opt)
	{
		case "G":
			if (f.Sistema.value=="")
			{
				alert("Debe Ingresar Codigo de Sistema");
				f.Sistema.focus();
				return;
			}
			if (f.NomSistema.value=="")
			{
				alert("Debe Ingresar Nombre de Sistema");
				f.NomSistema.focus();
				return;
			}
			if (f.Descripcion.value=="")
			{
				alert("Debe Ingresar Descripcion de Sistema");
				f.Descripcion.focus();
				return;
			}
			f.action = "mantenedor_sistemas01.php?Proceso=NS";
			f.submit();
			break;
		case "M":
			if (f.Sistema.value=="")
			{
				alert("Debe Ingresar Codigo de Sistema");
				f.Sistema.focus();
				return;
			}
			if (f.NomSistema.value=="")
			{
				alert("Debe Ingresar Nombre de Sistema");
				f.NomSistema.focus();
				return;
			}
			if (f.Descripcion.value=="")
			{
				alert("Debe Ingresar Descripcion de Sistema");
				f.Descripcion.focus();
				return;
			}
			f.action = "mantenedor_sistemas01.php?Proceso=MS";
			f.submit();
			break;
		case "S":
			window.opener.document.FrmMantenedor.action = "mantenedor_sistemas.php";
			window.opener.document.FrmMantenedor.submit();
			window.close();
			break;
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
body {
	background-image: url(imagenes/fondo3.gif);
}
</style>
</head>

<body>
<form name="frmMantSistema" action="" method="post">
<table width="450" border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr align="center" class="ColorTabla02">
    <td colspan="2"><strong>MANTENEDOR DE SISTEMA </strong></td>
  </tr>
  <tr align="center">
    <td colspan="2"><strong>
<?php
	if ($Error == "S")
		echo "<font color='BLUE'>".$Mensaje."</font>";
	else
		echo "&nbsp;";
?>	
	</strong></td>
    </tr>
    <td>C&oacute;digo de Sistema:</td>
      <td><input name="Sistema" <?php echo $EstadoInput; ?> type="text" id="cod_sistema2" value="<?php echo $Sistema;?>" size="10" maxlength="4">
      </td>
      </tr>
  <tr>
    <td>Nombre de Sistema:</td>
    <td>
      <input name="NomSistema" type="text" id="NomSistema" value="<?php echo $NomSistema;?>" size="50" maxlength="50">
    </td>
  </tr>
  <tr>
    <td>Descrip de Sistema:</td>
    <td><input name="Descripcion" type="text" id="Descripcion" value="<?php echo $Descripcion;?>" size="50" maxlength="255"></td>
  </tr>
  <tr valign="middle">
    <td>Tiene Anexo: </td>
    <td height="18">
<?php
	if ($Anexo=="S")
	{	
		echo "<input checked name='Anexo' type='radio' value='S'>SI&nbsp;\n";
    	echo "<input name='Anexo' type='radio' value='N'>NO\n";
	}
	else
	{
		echo "<input name='Anexo' type='radio' value='S'>SI&nbsp;\n";
    	echo "<input checked name='Anexo' type='radio' value='N'>NO\n";
	}
?>
	</td>
  </tr>
  <tr align="center" valign="middle">
    <td height="40" colspan="2">
<?php
	if ($Proceso == "NS")	
		echo "<input name='BtnGrabar' type='button' style='width:80px' onClick=\"Proceso('G')\"  value='Grabar'>\n";
	else
		echo "<input name='BtnModificar' type='button' style='width:80px' onClick=\"Proceso('M')\"  value='Modificar'>\n";
?>	  

      <input name="BtnSalir" type="button" id="BtnSalir" style="width:70px" onClick="Proceso('S')" value="Salir">
    </td>
  </tr>
</table>
</form>
</body>
</html>
