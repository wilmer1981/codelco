<?php
	//$CodigoDeSistema = 3;
	$CodigoDeSistema = 1;
	$CodigoDePantalla =57; 
	include("../principal/conectar_principal.php");

	
	if(isset($_REQUEST["Lote"])) {
		$Lote = $_REQUEST["Lote"];
	}else{
		$Lote = "";
	}
	if(isset($_REQUEST["Mes"])) {
		$Mes = $_REQUEST["Mes"];
	}else{
		$Mes = date("m");
	}
	if(isset($_REQUEST["Idioma"])) {
		$Idioma = $_REQUEST["Idioma"];
	}else{
		$Idioma = "";
	}
?>
<html>
<head>
<title>Sistema Estadistico de Catodos</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "C":
			if (f.Lote.value == "")
			{
				alert("Debe ingresar Numero de Lote");
				f.Lote.focus;
				return;
			}
			var URL = "sec_con_certificado.php?Reescribir=N&Mes=" + f.Mes.value + "&Lote=" + f.Lote.value + "&Idioma=" + f.Idioma.value;
			window.open(URL,"","top=35,left=10,width=850,height=460,scrollbars=yes,resizable = YES");
			break;
		case "P":
			if (f.Lote.value == "")
			{
				alert("Debe ingresar Numero de Lote");
				f.Lote.focus;
				return;
			}
			var URL = "sec_con_certificado.php?Proceso=P&Mes=" + f.Mes.value + "&Lote=" + f.Lote.value + "&Idioma=" + f.Idioma.value;
			window.open(URL,"","top=35,left=10,width=850,height=460,scrollbars=yes,resizable = YES");
			break;
		case "I":
			if (f.Lote.value == "")
			{
				alert("Debe ingresar Numero de Lote");
				f.Lote.focus;
				return;
			}
			var URL = "sec_con_certificado04.php?Mes=" + f.Mes.value + "&Lote=" + f.Lote.value;
			window.open(URL,"","top=35,left=10,width=850,height=460,scrollbars=yes,resizable = YES");
			break;
		case "V":			
			var URL = "sec_con_certificado05.php";
			window.open(URL,"","top=35,left=10,width=850,height=460,scrollbars=yes,resizable = YES");
			break;	
		case "S":
			f.action = "../principal/sistemas_usuario.php?CodSistema=1";
			f.submit();
			break;
	}
}
</script>
</head>

<body leftmargin="3" topmargin="2" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
<?php include("../principal/encabezado.php"); ?>
<table width="770" border="0" class="TablaPrincipal">
  <tr>
      <td height="315" align="center" valign="top"> 
        <table width="100%" border="0" class="TablaInterior">
          <tr> 
            <td align="center"><img src="../principal/imagenes/letras_codelco_1.jpg" width="170" height="50"></td>
          </tr>
          <tr align="center"> 
            <td height="17"><strong><font style="font-size=18px">EMBARQUE DE PRODUCTOS 
              VENTANAS</font></strong></td>
          </tr>
        </table>
        <br>
        <br>
        <br>
        <table width="482" border="0" class="TablaInterior">
          <tr> 
            <td width="89">Lote</td>
            <td width="220"><SELECT name="Mes">
                <?php
				$Consulta = "SELECT * from proyecto_modernizacion.sub_clase where cod_clase = '3004' order by nombre_subclase";
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Respuesta))
				{
					if ($Mes == $Fila["nombre_subclase"])
						echo "<option SELECTed value='".$Fila["nombre_subclase"]."'>".$Fila["nombre_subclase"]."</option>\n";
					else
						echo "<option value='".$Fila["nombre_subclase"]."'>".$Fila["nombre_subclase"]."</option>\n";
				}
			?>
              </SELECT> <input type="text" name="Lote" value="<?php echo $Lote?>"> 
            </td>
          </tr>
          <tr> 
            <td>Idioma</td>
            <td><SELECT name="Idioma" style="width:100px">
                <?php
				if (($Idioma == "E") || (!isset($Idioma)))
				{
                	echo "<option value='E' SELECTed>Espa&ntilde;ol</option>\n";
	                echo "<option value='I'>Ingles</option>\n";
				}
				else
				{
					echo "<option value='E'>Espa&ntilde;ol</option>\n";
	                echo "<option value='I' SELECTed>Ingles</option>\n";
				}
			?>
              </SELECT></td>
          </tr>
          <tr> 
            <td colspan="2" align="center"> 
              <input name="BtnVistaPrevia" type="button" id="BtnVistaPrevia" style="width:80px" onClick="Proceso('P');" value="Vista Previa"> 
              <input type="button" name="BtnConsultar" value="Generar" style="width:80px" onClick="Proceso('C');"> 
              <input name="BtnInformacion" type="button" id="BtnInformacion" style="width:80px" onClick="Proceso('I');" value="Informacion">
              <input name="BtnVer" type="button" id="BtnVer" style="width:100px" onClick="Proceso('V');" value="Ver Generados">
              <input type="button" name="BtnSalir" value="Salir" style="width:80px" onClick="Proceso('S');"> 
            </td>
          </tr>
          <tr> 
            <td colspan="2" align="center">&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="2">*Al Generar la Solicitud queda asociado el Lote con 
              el Numero de Certificado</td>
          </tr>
        </table>
        <br>
      </td>
		
  </tr>
</table>
<?php include("../principal/pie_pagina.php"); ?>
</form>
</body>
</html>
