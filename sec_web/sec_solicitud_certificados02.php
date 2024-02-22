<?php
	include("../principal/conectar_principal.php");	

	$CodBulto = isset($_REQUEST["CodBulto"])?$_REQUEST["CodBulto"]:"";
	$NumBulto = isset($_REQUEST["NumBulto"])?$_REQUEST["NumBulto"]:"";
	$CodCliente = isset($_REQUEST["CodCliente"])?$_REQUEST["CodCliente"]:"";
	$IE = isset($_REQUEST["IE"])?$_REQUEST["IE"]:"";
	$CorrCanje = isset($_REQUEST["CorrCanje"])?$_REQUEST["CorrCanje"]:"";

?>
<html>
<head>
<title>Sistema de Catodos</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<style type="text/css">
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
</style>
<script language="javascript">
function Proceso(opt)
{
	var f = document.frmCliente;
	switch (opt)
	{
		case "G":			
			f.action = "sec_solicitud_certificados01.php?Proceso=G_Cliente";
			f.submit();
			break;
		case "S":
			window.opener.document.FrmProceso.action = "sec_solicitud_certificados.php?Estado=T&Mostrar=S";
			window.opener.document.FrmProceso.submit();
			window.close();
			break;
	}
}
</script>
</head>

<body>
<form name="frmCliente" action="" method="post">
<input type="hidden" name="CodBulto" value="<?php echo $CodBulto; ?>">
<input type="hidden" name="NumBulto" value="<?php echo $NumBulto; ?>">
<input type="hidden" name="IE" value="<?php echo $IE; ?>">
<!--<input type="hidden" name="CorrCanje" value="<?php echo $CorrCanje; ?>">-->
<input type="hidden" name="CodCliente" value="<?php echo $CodCliente; ?>">
<table width="350" border="1" align="center" class="TablaDetalle">
  <tr align="center">
    <td colspan="2"><strong>Cambio de Cliente</strong></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td width="104">I.E.:</td>
    <td width="229"><?php echo $IE; ?></td>
  </tr>
  <tr>
    <td>Cliente:</td>
    <td><?php
		$NomCliente = "";
		$Consulta="SELECT * from sec_web.nave where cod_nave ='".$CodCliente."'";
		$Respuesta2=mysqli_query($link, $Consulta);
		if($Fila2=mysqli_fetch_array($Respuesta2))
		{
			$NomCliente=$Fila2["nombre_nave"];
		}
		else
		{
			$Consulta="SELECT * from sec_web.cliente_venta where cod_cliente ='".$CodCliente."'";
			$Respuesta2=mysqli_query($link, $Consulta);
			if($Fila2=mysqli_fetch_array($Respuesta2))
			{
				$NomCliente=$Fila2["sigla_cliente"];
			}
		}
		if ($NomCliente == "")
			echo "&nbsp;";
		else
			echo $NomCliente;
	?></td>
  </tr>
  <tr>
    <td height="29">Dest. Certificado : </td>
    <td><select name="Cliente">
	<option value="N">NINGUNO</option>
	<?php
		//CONSULTA SI YA TIENE UN CLIENTE ASIGADO
		$Consulta = "SELECT * from sec_web.solicitud_certificado ";
		$Consulta.= " where cod_bulto = '".$CodBulto."' and num_bulto='".$NumBulto."' and corr_enm = '".$IE."'";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Respuesta))
		{
			if ($Fila["cod_cliente2"] != "")
				$Cliente = $Fila["cod_cliente2"];
		}
		//FIN
		$Consulta = "SELECT * from sec_web.cliente_venta where sigla_cliente <> '' order by sigla_cliente";
		$Respuesta = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Respuesta))
		{
			 if ($Fila["cod_cliente"] == $Cliente)
				echo "<option selected value='".$Fila["cod_cliente"]."'>".strtoupper($Fila["sigla_cliente"])."</option>\n";
			else
				echo "<option value='".$Fila["cod_cliente"]."'>".strtoupper($Fila["sigla_cliente"])."</option>\n";
		}
	?>
    </select></td>
  </tr>
  <tr align="center">
    <td colspan="2"><input name="BtnGrabar" type="button" id="BtnGrabar" value="Grabar" style="width:70px " onClick="Proceso('G')">
    <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
  </tr>
</table>
</form>
</body>
</html>
