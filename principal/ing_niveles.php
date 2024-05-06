<?php
	include("conectar_principal.php");

	$Error  = isset($_REQUEST["Error"])?$_REQUEST["Error"]:"";
	$Proceso  = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Sistema  = isset($_REQUEST["Sistema"])?$_REQUEST["Sistema"]:"";
	$Modificar= isset($_REQUEST["Modificar"])?$_REQUEST["Modificar"]:"";
	$Orden    = isset($_REQUEST["Orden"])?$_REQUEST["Orden"]:"";
	$NivelSistema  = isset($_REQUEST["NivelSistema"])?$_REQUEST["NivelSistema"]:"";
	$NomSistema  = isset($_REQUEST["NomSistema"])?$_REQUEST["NomSistema"]:"";
	$Mensaje = isset($_REQUEST["Mensaje"])?$_REQUEST["Mensaje"]:"";

	$Descripcion="";
	
	$Consulta = "select * from proyecto_modernizacion.sistemas ";
	$Consulta.= " where cod_sistema = '".$Sistema."' ";
	$Resp = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Resp))
		$NomSistema = $Fila["nombre"];

	if ($Modificar=="S")
	{
		$Sistema = $_POST["Sistema"];	
		$NomSistema = $_POST["NomSistema"];	
		
		$Consulta = "select * from proyecto_modernizacion.niveles_por_sistema";
		$Consulta.= " where cod_sistema='".$Sistema."' and nivel='".$NivelSistema."'";
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Resp))
		{
			$Descripcion = $Fila["descripcion"];
			$Nivel = $Fila["nivel"];
		}
	}
?>
<html>
<head>
<title>Administraci&oacute;n de Sistema</title>
<link href="estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/funciones_java.js"></script>
<script language="javascript">
function Proceso(opt,valor)
{
	var f = frmMantSistema;
	var Valores = "";
	switch (opt)
	{
		case "DN":
			window.open("consulta_user_nivel.php?NivelCons=" + valor + "&Sistema=" + f.Sistema.value,"","top=80,left=60,width=450,height=350,scrollbars=yes,resizable = yes");					
			break;
		case "G":
			if (f.Nivel.value=="")
			{
				alert("Debe Ingresar Nivel");
				f.Nivel.focus();
				return;
			}
			if (f.Descripcion.value=="S")
			{
				alert("Debe Ingresar Descripcion");
				f.Nivel.focus();
				return;
			}			
			f.action = "mantenedor_sistemas01.php?Proceso=IN";
			f.submit();
			break;	
		case "GM":
			if (f.Nivel.value=="")
			{
				alert("Debe Ingresar Nivel");
				f.Nivel.focus();
				return;
			}
			if (f.Descripcion.value=="S")
			{
				alert("Debe Ingresar Descripcion");
				f.Nivel.focus();
				return;
			}			
			f.action = "mantenedor_sistemas01.php?Proceso=MN";
			f.submit();
			break;	
		case "E":
			for (i = 0; i < f.elements.length; i++)
			{
				if ((f.elements[i].name == "CodNivel") && (f.elements[i].checked == true))
				{
					Valores = Valores + f.elements[i].value + "/";
				}
			}
			if (Valores=="")
			{
				alert("No hay ningun Nivel Seleccionado para Eliminar");
				return;
			}
			else
			{
				var msg=confirm("¿Seguro que desea Eliminar Estos Niveles?");
				if (msg==true)
				{
					var Largo = Valores.length;
					Valores = Valores.substring(0,Largo-1);				
					f.action = "mantenedor_sistemas01.php?Proceso=EN&Valores=" + Valores;
					f.submit();
				}				
				else
				{
					return;
				}
			}
			break;	
		case "M":
			for (i = 0; i < f.elements.length; i++)
			{
				if ((f.elements[i].name == "CodNivel") && (f.elements[i].checked == true))
				{
					Valores = Valores + f.elements[i].value;
					break;
				}
			}
			if (Valores=="")
			{
				alert("No hay ningun Nivel Seleccionado para Modificar");
				return;
			}
			else
			{				
				f.action = "ing_niveles.php?Modificar=S&NivelSistema=" + Valores;
				f.submit()
			}
			break;
		case "I":
			window.print();
			break;
		case "S":
			window.opener.document.FrmMantenedor.action = "mantenedor_sistemas.php";
			window.opener.document.FrmMantenedor.submit();
			window.close();
			break;
		case "O":
			f.action = "ing_niveles.php?Orden=" + valor;
			f.submit();
			break;
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">

body {
	background-image: url(imagenes/fondo3.gif);
}
a:link {
	color: #0000FF;
}
a:visited {
	color: #0000FF;
}
a:hover {
	color: #0000FF;
}
a:active {
	color: #000000;
}

</style>
</head>

<body>
<form name="frmMantSistema" action="" method="post">
<input type="hidden" name="Sistema" value="<?php  echo $Sistema; ?>">
<input type="hidden" name="NomSistema" value="<?php  echo $NomSistema; ?>">
<table width="500" border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr align="center" class="ColorTabla02">
    <td colspan="2"><strong> NIVELES DEL SISTEMA <?php echo $NomSistema; ?></strong></td>
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
          <td width="97">Nuevo Nivel:</td>
          <td width="338">
<?php	
		if ($Modificar=="S")
		{	
			echo "<input name='Nivel' readonly type='text' size='4' maxlength='4' value='".$Nivel."'>";  		
		}
		else
		{
			$Consulta = "SELECT MAX(nivel) AS maximo
			             FROM proyecto_modernizacion.niveles_por_sistema
						 WHERE cod_sistema = '".$Sistema."' ";
			$Resp = mysqli_query($link, $Consulta);
			//echo "Consulta:".$Consulta;
			$Fila = mysqli_fetch_array($Resp);
			if ($Fila["maximo"] == "")
				$Nivel = "";
			else 	
				$Nivel = $Fila["maximo"] + 1;
			echo '<input name="Nivel" type="text" size="4" maxlength="4" value='.$Nivel.'>';					
		}
	  ?></td>
        </tr>
  <tr>
    <td>Nivel:</td>
    <td><input name="Descripcion" type="text" id="Descripcion" value="<?php echo $Descripcion; ?>" size="70" maxlength="255">
</td>
  </tr>
  <tr align="center" valign="middle">
    <td height="40" colspan="2">
<?php
	if ($Modificar != "S")	
		echo "<input name='BtnGrabar' type='button' style='width:80px' onClick=\"Proceso('G')\"  value='Grabar'>\n";
	else
		echo "<input name='BtnModificar' type='button' style='width:120px' onClick=\"Proceso('GM')\"  value='Guardar Cambios'>\n";
?>      
<input name="BtnModificar" type="button"  style="width:70px" onClick="Proceso('M')" value="Modificar">
      <input name="BtnEliminar" type="button"  style="width:70px" onClick="Proceso('E')" value="Eliminar">
      <input name="BtnImprimir" type="button"  style="width:70px" onClick="Proceso('I')" value="Imprimir">
      <input name="BtnSalir" type="button"  style="width:70px" onClick="Proceso('S')" value="Salir">    </td>
  </tr>
</table>
<br>
<table width="500"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
  <tr align="center" class="ColorTabla01">
    <td width="43"><strong>Mod/Eli</strong></td>
    <td width="34"><strong><a href="JavaScript:Proceso('O','N');" class="LinkBlanco"><font class="LinkBlanco">Nivel</font></a></strong></td>
    <td width="360"><strong><a href="JavaScript:Proceso('O','D');"><font class="LinkBlanco">Descripcion</font></a></strong></td>
    <td width="36"><img src='imagenes/Usuarios.gif' width='20' height='20' border='0'></td>
  </tr>
<?php  
	$Consulta = "select case when length(nivel)=1 then concat('0',nivel) else nivel end as orden, nivel, descripcion ";
	$Consulta.= " from proyecto_modernizacion.niveles_por_sistema ";
	$Consulta.= " where cod_sistema = '".$Sistema."'";
	switch ($Orden)
	{
		case "D":
			$Consulta.= " order by  descripcion";
			break;
		case "N":
			$Consulta.= " order by  orden";
			break;
		default:
			$Consulta.= " order by  orden";
			break;
	}
	$Resp = mysqli_query($link, $Consulta);
	$TotalNiveles = 0;
	while ($Fila = mysqli_fetch_array($Resp))
	{
		echo "<tr onMouseOver=\"CCA(this,'CL01')\" onMouseOut=\"CCA(this,'CL02')\">\n";
		echo "<td align='center'><input name='CodNivel' type='checkbox' value='".$Fila["nivel"]."' onClick=\"CCA(this,'CL03')\"></td>\n";
		echo "<td align='center'>".$Fila["nivel"]."</td>\n";
		echo "<td>".ucwords(strtolower($Fila["descripcion"]))."</td>\n";
		$Consulta = "select count(rut) as cant_user ";
		$Consulta.= " from proyecto_modernizacion.sistemas_por_usuario ";
		$Consulta.= " where cod_sistema = '".$Sistema."' ";
		$Consulta.= " and nivel = '".$Fila["nivel"]."' ";
		$Resp2 = mysqli_query($link, $Consulta);
		if ($Fila2 = mysqli_fetch_array($Resp2))
			echo "<td align='center'><a href=\"JavaScript:Proceso('DN','".$Fila["nivel"]."')\">".$Fila2["cant_user"]."</a></td>\n";
		else
			echo "<td align='center'>0</td>\n";
		echo "</tr>\n";
		$TotalNiveles++;
	}
?>  
  <tr class="ColorTabla02">
    <td colspan="4"><strong>TOTAL NIVELES: <?php echo $TotalNiveles; ?></strong></td>
    </tr>
</table>
</form>
</body>
</html>
