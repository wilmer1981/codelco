<?php
	include("../principal/conectar_principal.php");
	$Consulta = "SELECT * from proyecto_modernizacion.sub_clase ";
	$Consulta.= " where cod_clase = '2013'";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{
		switch ($Fila["cod_subclase"])
		{
			case "1":
				$PesoCtte = $Fila["valor_subclase1"];
				break;
			case "2":
				$PesoHM = $Fila["valor_subclase1"];
				break;
		}
	}
?>
<html>
<head>
<title>Pesos Promedio de Anodos</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<script language="javascript">
function Proceso(opt)
{
	var f = document.frmPesos;
	switch (opt)
	{
		case "G":	
			if (f.PesoCtte.value == "")
			{
				alert("Debe Ingresar Peso Promedio de Anodos Ctte");
				f.PesoCtte.focus();
				return;
			}
			if (f.PesoHM.value == "")
			{
				alert("Debe Ingresar Peso Promedio de Anodos HM");
				f.PesoHM.focus();
				return;
			}
			f.action = "sea_ing_prod_vent_auto01.php?Proceso=G_PromAnodos";
			f.submit();
			break;
		case "S":
			window.opener.formulario.action = "sea_ing_prod_vent_auto.php";
			window.opener.formulario.submit();
			window.close();
			break;
	}
}
</script>
</head>

<body background="../principal/imagenes/fondo3.gif">
<form name="frmPesos" action="" method="post">
<table width="406" border="0" align="center" cellpadding="4" cellspacing="2" class="TablaInterior">
  <tr align="center">
    <td colspan="2"><strong>PESOS PROMEDIO DE ANODOS CTTE. Y HOJAS MADRE </strong></td>
  </tr>
  <tr>
    <td width="146">&nbsp;</td>
    <td width="235">&nbsp;</td>
  </tr>
  <tr>
    <td>ANODOS CORRIENTES: </td>
    <td><input name="PesoCtte" type="text" id="PesoCtte" value="<?php echo $PesoCtte; ?>" size="10" maxlength="10"></td>
  </tr>
  <tr>
    <td>ANODOS HOJAS MADRE:</td>
    <td><input name="PesoHM" type="text" id="PesoHM" value="<?php echo $PesoHM; ?>" size="10" maxlength="10"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr align="center">
    <td colspan="2">    <input type="button" name="BtnGrabar" value="Grabar" style="width:70px " onClick="Proceso('G')">
    <input type="button" name="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
  </tr>
</table>
</form>
</body>
</html>
