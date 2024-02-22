<?php
include("../principal/conectar_principal.php");

$CookieRut=$_COOKIE["CookieRut"];

if(isset($_REQUEST["Error"])){
	$Error	= $_REQUEST["Error"];
}else{
	$Error	= "";
}
if(isset($_REQUEST["Reescribir"])){
	$Reescribir	= $_REQUEST["Reescribir"];
}else{
	$Reescribir	= "";
}
if(isset($_REQUEST["CorrENM"])){
	$CorrENM	= $_REQUEST["CorrENM"];
}else{
	$CorrENM	= "";
}

?>
<html>
<head>
<title>Sistema Estadistico de Catodos</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<script language="JavaScript">
function Proceso(opt,valor)
{
	var f = document.frmPopUp;
	switch (opt)
	{
		case "G":
			f.action = "sec_con_certificado03.php?Idioma=<?php echo $Idioma?>&Valor=" + valor;
			f.submit();
			break;
		case "S":
			window.close();
			break;
	}
}
</script>
<body background="../Principal/imagenes/fondo3.gif">
<form name="frmPopUp" action="" method="post">
<?php
	switch ($Error)
	{
		case "B":
			echo "<br><br><center><strong><font color='BLACK'>El Certificado para el Lote solicitado no es posible generarlo<br>";
			echo "Ya que no tiene instruccion de embarque asociada</font></strong></center>";
			echo "<br><br>";
			echo "<center><input name='BtnSalir' type='button' value='Salir' style='width:50' onClick=Proceso('S','0');></center>";
			break;
		case "E":
			echo "<br><br><center><strong><font color='RED'>DEBE INGRESAR SU CONTRASE�A DE VERIFICACION PARA SOBREESCRIBIR <BR>";
			echo "EL CERTIFICADO GENERADO ANTERIORMENTE.</font></strong></center>";
			echo "<br><br>";
			if ($Reescribir == "N")
			{
				echo "<br><br><center><strong><font color='RED'>CONTRASE�A INCORRECTA O NO TIENE AUTORIZACION.</font></strong></center>";
				echo "<br><br>";
			}
			echo "<table align='center' width='400' height='200' border='0' cellpadding='5' class='TablaPrincipal'>\n";
			echo "<tr> \n";
			echo "<td><div align='center'></div>\n";
			echo "<table width='380' border='0' cellpadding='3' class='ColorTabla01'>\n";
			echo "<tr> \n";
			echo "<td><div align='center'>Sobreescribir Certificado</div></td>\n";
			echo "</tr>\n";
			echo "</table>\n";
			echo "<br> <table width='380' border='0' cellpadding='5' class='TablaInterior'>\n";
			echo "<tr> \n";
			echo "<td>Usuario:  \n"; 
			$Consulta = "SELECT  * from proyecto_modernizacion.funcionarios where rut = '".$CookieRut."'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Respuesta))
			{
				echo $CookieRut." ".ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"]));
			}
			echo "</td>\n";
			echo "</tr>\n";
			echo "</table>\n";
			echo "<br> <table width='380' border='0' cellspacing='0' cellpadding='0'>\n";
			echo "<tr> \n";
			echo "<td width='58' height='36'>Password</td>\n";
			echo "&nbsp; \n";
			echo "<td width='322'>&nbsp;\n";
			echo "<input name='TxtPassword' type='password' style='width:80' onfocus=foco='BtnOk';> \n";
			echo "<input name='BtnOk' type='button' value='Ok' onClick=Proceso('G','".$CorrENM."'); onFocus=Proceso('G','".$CorrENM."');></td>\n";
			echo "</tr>\n";
			echo "</table>\n";
			echo "<br> <table width='380' height='27' border='0' cellpadding='0' cellspacing='0'>\n";
			echo "<tr> \n";
			echo "<td><div align='center'> \n";
			echo "<input name='BtnSalir' type='button' value='Salir' style='width:50' onClick=Proceso('S','0');>\n";
			echo "</div></td>\n";
			echo "</tr>\n";
			echo "</table></td>\n";
			echo "</tr>\n";
			echo "</table>\n";
			break;
		case "G":
			echo "<br><br><center><strong><font color='BLACK'>El Certificado para el Lote solicitado no es posible generarlo<br>";
			echo "Ya que algunos grupos NO tienen leyes (ver en Vista Previa)</font></strong></center>";
			echo "<br><br>";
			echo "<center><input name='BtnSalir' type='button' value='Salir' style='width:50' onClick=Proceso('S','0');></center>";
			break;
		case "A":
			echo "<br><br><center><strong><font color='BLACK'>El Certificado para el Lote solicitado no es posible generarlo<br>";
			echo "Ya que la solicitud ha sido ANULADA</font></strong></center>";
			echo "<br><br>";
			echo "<center><input name='BtnSalir' type='button' value='Salir' style='width:50' onClick=Proceso('S','0');></center>";
			break;
	}
?>	
</form>
</body>
</html>
