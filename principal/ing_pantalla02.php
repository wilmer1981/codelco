<?php
	include("conectar_principal.php");

$Error    = isset($_REQUEST["Error"])?$_REQUEST["Error"]:"";
$Proceso  = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
$Sistema  = isset($_REQUEST["Sistema"])?$_REQUEST["Sistema"]:"";
$Orden    = isset($_REQUEST["Orden"])?$_REQUEST["Orden"]:"";
$Rec      = isset($_REQUEST["Rec"])?$_REQUEST["Rec"]:"";
$CodPantalla  = isset($_REQUEST["CodPantalla"])?$_REQUEST["CodPantalla"]:"";
$TipoPag      = isset($_REQUEST["TipoPag"])?$_REQUEST["TipoPag"]:"";
$Mensaje      = isset($_REQUEST["Mensaje"])?$_REQUEST["Mensaje"]:"";
$Descripcion  = isset($_REQUEST["Descripcion"])?$_REQUEST["Descripcion"]:"";
$Link         = isset($_REQUEST["Link"])?$_REQUEST["Link"]:"";


	$Consulta = "select * from proyecto_modernizacion.sistemas ";
	$Consulta.= " where cod_sistema = '".$Sistema."' ";
	$Resp = mysqli_query($link, $Consulta);

	//echo "Consulta:".$Consulta;
	if ($Fila = mysqli_fetch_array($Resp))
		$NomSistema = $Fila["nombre"];
		//echo "<br>NomSistema:".$NomSistema;

	//if ((isset($Sistema)) && ($Sistema != "S") && ($Proceso == "N"))
	if ($Sistema!="" && $Sistema != "S" && $Proceso == "N")
	{

		//$Sistema   = $_POST["Sistema"];
		//$NomSistema = $_POST["NomSistema"];	
		//echo "<br>Proceso=N";

		$Consulta = "select max(cod_pantalla) as ult_pantalla ";
		$Consulta.= " from proyecto_modernizacion.pantallas ";
		$Consulta.= " where cod_sistema = '".$Sistema."' ";
		$Resp = mysqli_query($link, $Consulta);
		//echo "<br>Consulta:".$Consulta;
		if ($Fila = mysqli_fetch_array($Resp))
		{
			$CodPantalla = 1 + $Fila["ult_pantalla"];
			$Orden = $CodPantalla;
		}
	}
	else
	{

		if ($Proceso == "M" && $Rec != "S")
		{
			//$Sistema = $_POST["Sistema"];
			//$CodPantalla = $_POST["CodPantalla"];

			$Consulta = "SELECT * ";
			$Consulta.= " FROM proyecto_modernizacion.pantallas ";
			$Consulta.= " WHERE cod_sistema = '".$Sistema."' AND cod_pantalla = '".$CodPantalla."' ";
			$Resp = mysqli_query($link, $Consulta);
			//echo "Consulta: ".$Consulta;
			if ($Fila = mysqli_fetch_array($Resp))
			{
				$Descripcion = $Fila["descripcion"];
				$Link = $Fila["link"];	
				$TipoPag = $Fila["tipo"];
				$EstPag = $Fila["estado"];
				$Orden = $Fila["orden"];
			}else{
				echo "no se encuentra la Informacion de la Pantalla";
			}
		}else{
			if ($Rec != "S")
				$CodPantalla = "";
		}
	}
	if ($TipoPag==3)
	{
		switch ($Sistema)
		{
			case "99":
				$Link = "sistemas_usuario.php?CodSistema=".$Sistema."&Nivel=1&CodPantalla=".$CodPantalla;
				break;
			default:
				$Link = "../principal/sistemas_usuario.php?CodSistema=".$Sistema."&Nivel=1&CodPantalla=".$CodPantalla;
				break;
		}		
	}
?>
<html>
<head>
<title>Administrador de Sistemas</title>
<link href="estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/funciones_java.js"></script>
<script language="javascript">
function Proceso(opt,valor)
{
	var f = frmIngPantalla;
	var Valores = "";
	switch (opt)
	{
		case "G":
			if (f.CodPantalla.value=="")
			{
				alert("Debe Ingresar Codigo de Pantalla");
				f.CodPantalla.focus();
				return;
			}
			if (f.Descripcion.value=="")
			{
				alert("Debe Ingresar Descripcion de Pantalla");
				f.Descripcion.focus();
				return;
			}
			if (f.Link.value=="")
			{
				alert("Debe Ingresar Link de Pantalla");
				f.Link.focus();
				return;
			}
			if (f.TipoPag.value=="S")
			{
				alert("Debe Seleccionar Tipo de Pantalla");
				f.TipoPag.focus();
				return;
			}
			if (f.Orden.value=="")
			{
				alert("Debe Ingresar Orden de la Pantalla dentro del Menu");
				f.Orden.focus();
				return;
			}
			if (f.TipoPag.value!=3)
			{
				if (f.EstPag.value=="S")
				{
					alert("Debe Seleccionar Estado de Pantalla");
					f.EstPag.focus();
					return;
				}
			}
			f.action = "ing_pantalla01.php?Proceso=G";
			f.submit();
			break;					
		case "M":
			if (f.CodPantalla.value=="")
			{
				alert("Debe Ingresar Codigo de Pantalla");
				f.CodPantalla.focus();
				return;
			}
			if (f.Descripcion.value=="")
			{
				alert("Debe Ingresar Descripcion de Pantalla");
				f.Descripcion.focus();
				return;
			}
			if (f.Link.value=="")
			{
				alert("Debe Ingresar Link de Pantalla");
				f.Link.focus();
				return;
			}
			if (f.TipoPag.value=="S")
			{
				alert("Debe Seleccionar Tipo de Pantalla");
				f.TipoPag.focus();
				return;
			}
			if (f.Orden.value=="")
			{
				alert("Debe Ingresar Orden de la Pantalla dentro del Menu");
				f.Orden.focus();
				return;
			}
			if (f.TipoPag.value!=3)
			{
				if (f.EstPag.value=="S")
				{
					alert("Debe Seleccionar Estado de Pantalla");
					f.EstPag.focus();
					return;
				}
			}
			f.action = "ing_pantalla01.php?Proceso=A";
			f.submit();
			break;		
		case "S":
			window.opener.document.frmPrincipal.action = "ing_pantalla.php?Sistema=<?php echo $Sistema; ?>";
			window.opener.document.frmPrincipal.submit();
			window.close();
			break;		
		case "R":
			f.action = "ing_pantalla02.php?Rec=S&Proceso=<?php echo $Proceso; ?>&Sistema=<?php echo $Sistema; ?>";
			f.submit();
			break;
	}
}

//-->
</script>
<style type="text/css">

body {
	background-image: url(imagenes/fondo3.gif);
}

</style></head>

<body>
<form name="frmIngPantalla" action="" method="post">
<input type="hidden" name="NomSistema" value="<?php  echo $NomSistema; ?>">
<table width="590" height="216" border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr align="center" class="ColorTabla02">
    <td height="18" colspan="2"><strong>MANTENEDOR DE PANTALLA </strong></td>
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
  <tr>
    <td width="99" height="18">Sistema:</td>
    <td width="436"><?php echo $NomSistema; ?><input type="hidden" name="Sistema" value="<?php echo $Sistema ?>"></td>
  </tr>
  <tr>
    <td height="24">C&oacute;digo Pantalla:</td>
    <td valign="middle">
      <?php
				if ($Proceso == "M")
				{
			 		echo "<input name='CodPantalla' type='text' readonly value='".$CodPantalla."' size=10 maxlength=10>\n"; 
				}
				else
				{
					echo "<input name='CodPantalla' type='text' value='".$CodPantalla."' size=10 maxlength=10>\n";
				}
			 ?>
    </td>
  </tr>
  <tr>
    <td>Descripci&oacute;n:</td>
    <td><input name="Descripcion" type="text" id="Descripcion" value="<?php echo $Descripcion;?>" size="50" maxlength="255"></td>
  </tr>
  <tr>
    <td height="20">Link:</td>	
    <td><input name="Link" type="text" id="Link" value="<?php echo $Link;?>" size="90" maxlength="255"></td>
  </tr>
  <tr>
    <td height="20">Tipo:</td>
    <td><select name="TipoPag" onChange="Proceso('R')">		
        <?php

		//echo "TipoPag:".$TipoPag;
				switch ($TipoPag)
				{
					case 0:			
						echo "<option selected value='S' selected>Seleccionar</option>\n";			
						echo "<option value='1'>Pantalla de Ingreso</option>\n";
						echo "<option value='2'>Pantalla de Consulta</option>\n";
						echo "<option value='3'>Carpeta de Sub-Nivel</option>\n";
						break;
					case 1:
						echo "<option value='S' selected>Seleccionar</option>\n";			
						echo "<option selected value='1'>Pantalla de Ingreso</option>\n";
						echo "<option value='2'>Pantalla de Consulta</option>\n";
						echo "<option value='3'>Carpeta de Sub-Nivel</option>\n";
						break;
					case 2:
						echo "<option value='S' selected>Seleccionar</option>\n";			
						echo "<option value='1'>Pantalla de Ingreso</option>\n";
						echo "<option selected value='2'>Pantalla de Consulta</option>\n";
						echo "<option value='3'>Carpeta de Sub-Nivel</option>\n";
						break;
					case 3:
						echo "<option value='S' selected>Seleccionar</option>\n";			
						echo "<option value='1'>Pantalla de Ingreso</option>\n";
						echo "<option value='2'>Pantalla de Consulta</option>\n";
						echo "<option selected value='3'>Carpeta de Sub-Nivel</option>\n";
						break;
					default:
						echo "<option selected value='S' selected>Seleccionar</option>\n";			
						echo "<option value='1'>Pantalla de Ingreso</option>\n";
						echo "<option value='2'>Pantalla de Consulta</option>\n";
						echo "<option value='3'>Carpeta de Sub-Nivel</option>\n";
						break;
				}
			?>
    </select></td>
  </tr>
  <tr>
    <td height="20">Num. de Orden:</td>
    <td><input name="Orden" type="text" id="Orden" value="<?php echo $Orden;?>" size="5" maxlength="3"></td>
  </tr>
  
<?php
if ($TipoPag != 3)
{
	echo "<tr>\n";
    echo "<td>Estado:</td>\n";
    echo "<td>\n";
	echo "<select name='EstPag'>";
	switch ($EstPag)
	{
		case "S":			
			echo "<option selected value='S'>Seleccionar</option>\n";	
			echo "<option value='L'>Lista</option>\n";		
			echo "<option value='T'>Trabajando en Ella</option>\n";
			echo "<option value='N'>No Disponible</option>\n";
			break;
		case "L":
			echo "<option value='S'>Seleccionar</option>\n";	
			echo "<option selected value='L'>Lista</option>\n";					
			echo "<option value='T'>Trabajando en Ella</option>\n";
			echo "<option value='N'>No Disponible</option>\n";
			break;
		case "N":
			echo "<option value='S'>Seleccionar</option>\n";	
			echo "<option value='L'>Lista</option>\n";	
			echo "<option value='T'>Trabajando en Ella</option>\n";	
			echo "<option selected value='N'>No Disponible</option>\n";
			break;	
		case "T":
			echo "<option value='S'>Seleccionar</option>\n";	
			echo "<option value='L'>Lista</option>\n";	
			echo "<option selected value='T'>Trabajando en Ella</option>\n";	
			echo "<option value='N'>No Disponible</option>\n";
			break;							
		default:
			echo "<option selected value='S'>Seleccionar</option>\n";	
			echo "<option value='L'>Lista</option>\n";		
			echo "<option value='T'>Trabajando en Ella</option>\n";
			echo "<option value='N'>No Disponible</option>\n";
			break;
	}
	echo "</select>\n";
	echo "</td>\n";
	echo "</tr>\n";
}
else
{
	echo "<input type='hidden' name='EstPag' value='L'>\n";
}
?>
  <tr align="center">
    <td height="20" colspan="2">    
<?php
	if ($Proceso == "M")	
		echo "<input name='BtnModificar' type='button' value='Guardar Cambios' style='width:120px' onClick=\"Proceso('M')\">\n";
	else
		echo "<input name='BtnGrabar' type='button' value='Grabar' style='width:70px' onClick=\"Proceso('G')\">\n";
?>
    <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
  </tr>
</table>
</form>
</body>
</html>
