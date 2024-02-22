<?php   
include("conectar_principal.php");

if(isset($_REQUEST["funcionarios"])){
	$funcionarios = $_REQUEST["funcionarios"];
}else {
	$funcionarios = "";
}

if(isset($_REQUEST["Mensaje"])){
	$Mensaje = $_REQUEST["Mensaje"];
}else {
	$Mensaje = "";
}

?>
<html>
<head>
<title>Administrador de Sistemas</title>
<link href="estilos/css_principal.css" type="text/css" rel="stylesheet">
<script  language="JavaScript" src="funciones/funciones_java.js"></script>
<script language="JavaScript">

function ValidaSeleccion(Nombre)
{
	var f = document.Formulario; 
	var LargoForm = f.elements.length;
	var valores_sistema = "";
	var valores_niveles = "";
	var valores = "";
	for (i = 0; i < LargoForm; i++)
	{
		if ((f.elements[i].name == Nombre) && (f.elements[i].checked == true))
		{
			valores_sistema = valores_sistema + f.elements[i].value + "/";
			valores_niveles = valores_niveles + f.elements[i+1].value + "/";
		}
	}
	valores = "valores_sistema=" + valores_sistema + "&valores_niveles=" + valores_niveles;
	return valores;
}

function ingresar_datos(opt)
{
	var Frm = Formulario;
	var valores = ValidaSeleccion("checkbox");
	switch (opt)
	{
		case "E":
			var msg = confirm("Seguro que desea Eliminar este(os) Sistema(s) al usuario?");
			if (msg==true)
			{
				//Frm.action = "ing_fun_nivel01.php?Proceso=E&valores_niveles=" +  valores;
				Frm.action = "ing_fun_nivel01.php?Proceso=E&" +  valores;
				Frm.submit();		
			}
			else
			{
				return;
			}
			break;
		case "G":
			Frm.action = "ing_fun_nivel01.php?Proceso=G&" +  valores;
			Frm.submit();
			break;
	}
}

function Recarga(f)
{
	f.action = "ing_fun_nivel.php";
	f.submit();
}

function Salir(f)
{
	window.close();
}

</script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>

<body background="imagenes/fondo3.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="Formulario" method="post" action=""><br> 
<table width="720" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="13" align="center" valign="middle"><img src="imagenes/left-flecha.gif" width="11" height="11"></td>
            <td width="50">Funcionario</td>
            <td width="367"><input name="funcionarios" type="text" value="<?php echo $funcionarios;?>" size="15" readonly="true">
              <?php
				$Consulta = "SELECT  * from funcionarios where rut='".$funcionarios."'"; 
				$result= mysqli_query($link, $Consulta);
				$row = mysqli_fetch_array($result);
				echo "<strong>".ucwords(strtolower($row['apellido_paterno'])).' '.$row['apellido_materno'].'  '.$row['nombres']."</strong>";
			?>
            </td>
            <td width="195">
			  <input name="Guardar" type="button" value="Guardar" onClick="ingresar_datos('G');" style="width:60px">
              <input name="btnEliminar" type="button" value="Eliminar" onClick="JavaScript:ingresar_datos('E');" style="width:60px">
              <input name="btnSalir" type="button" value="Salir" onClick="JavaScript:Salir(this.form);" style="width:60px"> 
            </td>
          </tr>
        </table>
        <br>
        
  <table width="720" align="center" border="1" cellspacing="0" cellpadding="2" class="TablaDetalle">
    <tr class="ColorTabla01"> 
      <td width="43" height="19">&nbsp;</td>
      <td width="59" align="center"><strong>C&oacute;digo</strong></td>
      <td width="135" align="center"><strong>Nombre Sistema</strong></td>
      <td width="200"><strong>Descripci&oacute;n</strong></td>
      <td width="284"><strong>Niveles</strong></td>
    </tr>
    <?php
	$consulta = "SELECT  * from sistemas order by nombre";
	$respuesta = mysqli_query($link, $consulta);
	$ColorTabla = "Tabla03";
	$NivelSistema = "";
	while($Fila = mysqli_fetch_array($respuesta))
	{
		if ($ColorTabla == "Tabla03")
			$ColorTabla = "Tabla02";
		else	$ColorTabla = "Tabla03";
		//echo "<tr class='".$ColorTabla."' onMouseOver=\"CCA(this,'CL01')\" onMouseOut=\"CCA(this,'CL02')\">\n";
		if ($funcionarios != -1)
		{
			$sql = "select * from sistemas_por_usuario ";
			$sql.= " where rut = '".$funcionarios."'";
			$resp2 = mysqli_query($link, $sql);
			$Encontro = false;			
			while ($row2 = mysqli_fetch_array($resp2))
			{
				if ($row2["cod_sistema"] == $Fila["cod_sistema"])
				{
					$Encontro = true;
					$NivelSistema = $row2["nivel"];
					echo "<tr onMouseOver=\"CCA(this,'CL01')\" onMouseOut=\"CCA(this,'CL02')\" class='CL03' >\n";
					echo "<td align='center'><input type='checkbox' checked name='checkbox' value='".$Fila["cod_sistema"]."' onclick=\"CCA(this,'CL03')\"></td>";
				}
			}
			if ($Encontro == false)
			{
				echo "<tr class='".$ColorTabla."' onMouseOver=\"CCA(this,'CL01')\" onMouseOut=\"CCA(this,'CL02')\">\n";
				echo "<td align='center'><input type='checkbox' name='checkbox' value='".$Fila["cod_sistema"]."' onclick=\"CCA(this,'CL03')\"></td>";
			}
		}
		else
		{
			echo "<tr class='".$ColorTabla."' onMouseOver=\"CCA(this,'CL01')\" onMouseOut=\"CCA(this,'CL02')\">\n";
			echo "<td align='center'><input type='checkbox' name='checkbox' value='".$Fila["cod_sistema"]."' onclick=\"CCA(this,'CL03')\"></td>";
		}		
		echo "<td align='center'>".strtoupper($Fila["cod_sistema"])."</td>\n";
		echo "<td>".ucwords(strtolower($Fila["nombre"]))."</td>";
		echo "<td>".ucwords(strtolower($Fila["descripcion"]))."</td>";
		echo "<td align='center'>\n";
		echo "<select name='nivel' style='width:250px'>\n";
		echo "<option value = 'S' >Nivel</option>\n";
		$Consult = "select nivel,cod_sistema, descripcion from niveles_por_sistema "; 
		$Consult.= " where cod_sistema=".$Fila["cod_sistema"];
		$result= mysqli_query($link, $Consult);
		while ($row = mysqli_fetch_array($result))
		{ 
			if (($row["nivel"]==$NivelSistema) && ($row["cod_sistema"] == $Fila["cod_sistema"]) && ($Encontro == true))
			{
				echo "<option selected value = '".$row["nivel"]."' >".$row["nivel"]." - ".ucwords(strtolower($row["descripcion"]))."</option>\n"; 
			}		
			else
			{
				echo "<option value = '".$row["nivel"]."' >".$row["nivel"]." - ".ucwords(strtolower($row["descripcion"]))."</option>\n"; 
			}
		}		 			
		echo"</td></tr>";
    }		
	
   ?>
  </table>
</form>
</body>
</html>
