<?php
	include("conectar_principal.php");
	if(isset($_GET["Error"])){
		$Error = $_GET["Error"];
	}else{
		$Error = "";
	}
	if(isset($_GET["Proceso"])){
		$Proceso = $_GET["Proceso"];
	}else{
		$Proceso = "";
	}
	if(isset($_GET["Sistema"])){
		$Sistema = $_GET["Sistema"];
	}else{
		$Sistema = "";
	}

	if(isset($_GET["Modificar"])){
		$Modificar = $_GET["Modificar"];
	}else{
		$Modificar = "";
	}
	if(isset($_GET["Orden"])){
		$Orden = $_GET["Orden"];
	}else{
		$Orden = "";
	}

	if(isset($_GET["RutModif"])){
		$RutModif = $_GET["RutModif"];
	}else{
		$RutModif = "";
	}


	$Consulta = "select * from proyecto_modernizacion.sistemas ";
	$Consulta.= " where cod_sistema = '".$Sistema."' ";
	$Resp = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Resp))
		$NomSistema = $Fila["nombre"];

	if ($Modificar=="S")
	{
		$Sistema = $_POST["Sistema"];
		$NomSistema = $_POST["NomSistema"];		

		$Consulta = "select * from proyecto_modernizacion.sistemas_por_usuario";
		$Consulta.= " where cod_sistema='".$Sistema."' and rut='".$RutModif."'";
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Resp))
		{
			$Usuario = $Fila["rut"];
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
		case "G":
			if (f.Usuario.value=="S")
			{
				alert("Debe Seleccionar Usuario");
				f.Usuario.focus();
				return;
			}
			if (f.Nivel.value=="S")
			{
				alert("Debe Seleccionar Nivel");
				f.Nivel.focus();
				return;
			}			
			f.action = "mantenedor_sistemas01.php?Proceso=IU";
			f.submit();
			break;	
		case "GM":
			if (f.Usuario.value=="S")
			{
				alert("Debe Seleccionar Usuario");
				f.Usuario.focus();
				return;
			}
			if (f.Nivel.value=="S")
			{
				alert("Debe Seleccionar Nivel");
				f.Nivel.focus();
				return;
			}			
			f.action = "mantenedor_sistemas01.php?Proceso=MU";
			f.submit();
			break;	
		case "E":
			for (i = 0; i < f.elements.length; i++)
			{
				if ((f.elements[i].name == "RutUser") && (f.elements[i].checked == true))
				{
					Valores = Valores + f.elements[i].value + "/";
				}
			}
			if (Valores=="")
			{
				alert("No hay ningun Usuarios Seleccionado para Eliminar");
				return;
			}
			else
			{
				var msg=confirm("�Seguro que desea Eliminar Estos Usuarios?");
				if (msg==true)
				{
					var Largo = Valores.length;
					Valores = Valores.substring(0,Largo-1);				
					f.action = "mantenedor_sistemas01.php?Proceso=EU&Valores=" + Valores;
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
				if ((f.elements[i].name == "RutUser") && (f.elements[i].checked == true))
				{
					Valores = Valores + f.elements[i].value;
					break;
				}
			}
			if (Valores=="")
			{
				alert("No hay ningun Usuarios Seleccionado para Modificar");
				return;
			}
			else
			{				
				f.action = "ing_usuario.php?Modificar=S&RutModif=" + Valores;
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
			f.action = "ing_usuario.php?Orden=" + valor;
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
	color: #FFFFFF;
}
a:visited {
	color: #FFFFFF;
}
a:hover {
	color: #FFFFFF;
}
a:active {
	color: #FFFF00;
}
</style>
</head>

<body>
<form name="frmMantSistema" action="" method="post">
<input type="hidden" name="Sistema" value="<?php  echo $Sistema; ?>">
<input type="hidden" name="NomSistema" value="<?php  echo $NomSistema; ?>">
<table width="500" border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr align="center" class="ColorTabla02">
    <td colspan="2"><strong> USUARIOS DEL SISTEMA <?php echo $NomSistema; ?></strong></td>
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
        <td width="97">Nuevo Usuario:</td>
        <td width="338"><select name="Usuario" id="Usuario">
		<option value="S">SELECCIONAR</option>
<?php
	$Consulta = "select * from proyecto_modernizacion.funcionarios order by apellido_paterno, apellido_materno, nombres ";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{
		if ($Usuario==$Fila["rut"])
			echo "<option selected value='".$Fila["rut"]."'>".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"]))." ".ucwords(strtolower($Fila["nombres"]))."</option>\n";			
		else
	 		echo "<option value='".$Fila["rut"]."'>".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"]))." ".ucwords(strtolower($Fila["nombres"]))."</option>\n";
	}
?>		
        </select></td>
      </tr>
  <tr>
    <td>Nivel:</td>
    <td>
      <select name="Nivel" id="Nivel">
		<option value="S">SELECCIONAR</option>
			<?php
				$Consulta = "select * from proyecto_modernizacion.niveles_por_sistema where cod_sistema = '".$Sistema."' order by nivel ";		
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
                  

					if ($Nivel==$Fila["nivel"])
						echo "<option selected value='".$Fila["nivel"]."'>".str_pad($Fila["nivel"],2,"0",STR_PAD_LEFT)."-".ucwords(strtolower($Fila["descripcion"]))."</option>\n";			
					else
						echo "<option value='".$Fila["nivel"]."'>".str_pad($Fila["nivel"],2,"0",STR_PAD_LEFT)."-".ucwords(strtolower($Fila["descripcion"]))."</option>\n";			
				}
			?>		
      </select>
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
<table width="550"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
  <tr class="ColorTabla01">
    <td width="47"><strong>Mod/Eli</strong></td>
    <td width="88"><strong><a href="JavaScript:Proceso('O','R');">Rut</a></strong></td>
    <td width="243"><strong><a href="JavaScript:Proceso('O','N');">Usuario</a></strong></td>
    <td width="145"><strong><a href="JavaScript:Proceso('O','V');">Nivel</a></strong></td>
  </tr>
<?php  
	$Consulta = "select t1.rut, t2.nombres, t2.apellido_paterno, t2.apellido_materno, t3.descripcion ";
	$Consulta.= " from proyecto_modernizacion.sistemas_por_usuario t1 ";
	$Consulta.= " inner join proyecto_modernizacion.funcionarios t2 on t1.rut=t2.rut";
	$Consulta.= " inner join proyecto_modernizacion.niveles_por_sistema t3 on t1.cod_sistema=t3.cod_sistema ";
	$Consulta.= " and t1.nivel=t3.nivel";
	$Consulta.= " where t1.cod_sistema = '".$Sistema."'";
	switch ($Orden)
	{
		case "R":
			$Consulta.= " order by  t2.rut";
			break;
		case "N":
			$Consulta.= " order by  t2.apellido_paterno, t2.apellido_materno, t2.nombres";
			break;
		case "V":
			$Consulta.= " order by  t3.descripcion";
			break;
		default:
			$Consulta.= " order by  t2.apellido_paterno, t2.apellido_materno, t2.nombres";
			break;
	}
	$Resp = mysqli_query($link, $Consulta);
	$TotalUsuarios = 0;
	while ($Fila = mysqli_fetch_array($Resp))
	{
		echo "<tr>\n";
		echo "<td align='center'><input name='RutUser' type='checkbox' value='".$Fila["rut"]."' onClick=\"CCA(this,'CL03')\"></td>\n";
		echo "<td>".$Fila["rut"]."</td>\n";
		echo "<td>".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"]))." ".ucwords(strtolower($Fila["nombres"]))."</td>\n";
		echo "<td>".ucwords(strtolower($Fila["descripcion"]))."</td>\n";
		echo "</tr>\n";
		$TotalUsuarios++;
	}
?>  
  <tr class="ColorTabla02">
    <td colspan="4"><strong>TOTAL USUARIOS: <?php echo $TotalUsuarios; ?></strong></td>
    </tr>
</table>
</form>
</body>
</html>
