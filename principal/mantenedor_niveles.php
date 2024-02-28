<?php 
	$CodigoDeSistema = 99;
	$CodigoDePantalla = 2;
?>
<?php 
	include("conectar_principal.php");
// SI LA OPCION ES MODIFICAR
	if ($Mostrar=="S")
	{
			$sql = "select * from niveles_por_sistema where cod_sistema = ".$cmbsistema." and nivel = ".$Valor;
			$result = mysqli_query($link, $sql);
			if ($row=mysqli_fetch_array($result))
			{
				$cmbsistema = $row[cod_sistema];
				$txtnivel = $row[nivel];
				$txtdescripcion = $row["descripcion"];
			}			
			else
			{
				echo "Error No se encuntran los registros";
			}
	}
// SI HAY ALGUN MENSAJE QUE MOSTRAR	
	if (isset($mensaje))
		echo '<script> alert("'.$mensaje.'") </script>';
?>

<html>
<head>
<title>Administrador de Sistemas</title>
<link href="estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function valida_campos(f)
{
	if (f.cmbsistema.value == -1)
	{
		alert("Debe Seleccionar un Sistema");
		return false;
	}

	if (f.txtnivel.value == "") //||
	{
		alert("Debe Ingresar Nivel");
		return false;
	}
    
	if (isNaN(parseInt(f.txtnivel.value)))			
	{
		alert("El Nivel no es V�lido");
		return false;
	}		
			
	if (f.txtdescripcion.value == "")
	{	
		alert("Debe Ingresar Descripcion");
		return false;
	}
	return true;	
}
//**************************//
function ValidaSeleccion(f,Nombre)
{
	var LargoForm = f.elements.length;
	var Valores = "";
	for (i = 0; i < LargoForm; i++)
	{
		if ((f.elements[i].name == Nombre) && (f.elements[i].checked == true))
		{
			Valores = Valores + f.elements[i].value + '/';
		}
	}
	return Valores;
}
//**************************//
function grabar(f,opt)
{
	if (valida_campos(f))
	{
		//grabar
		f.action = 'mantenedor_niveles01.php?opc=' + opt;
		f.submit();	
	}
}
//***************************//
function eliminar(f)
{	
	var parametros = ValidaSeleccion(f,'checkbox');	

	if (parametros == "")
	{	
		alert("Debe Seleccionar un CheckBox para Eliminar");
		return;
	}
	else
	{
		f.action = 'mantenedor_niveles01.php?opc=E&parametros='+parametros;
		f.submit();
	}
}
//***************************//
//***************************//
function Modificar(f)
{		
	var LargoForm = f.elements.length;
	var Valores = "";
	var Marcados = 0;
	for (i = 0; i < LargoForm; i++)
	{
		if ((f.elements[i].name == "checkbox") && (f.elements[i].checked == true))
		{
			Valores = f.elements[i].value;
			Marcados++;
		}
	}
	if (Marcados == 0)
	{	
		alert("Debe Seleccionar un Registro para Modificar");
		return;
	}
	else
	{
		if (Marcados > 1)
		{
			alert("Debe Seleccionar solo un registro para Modificar");
			return;
		}
		else
		{
			f.action = "mantenedor_niveles.php?Mostrar=S&Valor=" + Valores;
			f.submit();		
		}
	}	
}
//***************************//
function recarga(f)
{
	f.action = "mantenedor_niveles.php?recargapag=1";
	f.submit();
}
function Cancelar(f)
{
	window.location="mantenedor_niveles.php?";
}

function Salir(f)
{
	f.action = "sistemas_usuario.php?CodSistema=99";
	f.submit();
}
//-->
</script>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body leftmargin="3" topmargin="2">
<form name="form1" method="post" action="">
<?php include("encabezado.php");?> 
<table width="770" border="0" cellspacing="0" cellpadding="5" class="TablaPrincipal">
    <tr>
      <td height="161">
<table width="500" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
  <tr> 
      <td width="21%">Sistema </td>
      <td width="79%"><?php
			if ($Mostrar != "S")
			{		
				  echo "<select name='cmbsistema' onChange='JavaScript:recarga(this.form)' style='width:300px'>\n";
				  echo '<option value="-1">SELECCIONAR</option>';
				  $consulta = "SELECt cod_sistema, nombre FROM  sistemas ORDER BY nombre";
				  $rs = mysqli_query($link, $consulta);
				  while ($row = mysqli_fetch_array($rs))		  
				  {	
					if ($row[cod_sistema] == $cmbsistema)
					  echo '<option value='.$row[cod_sistema].' selected>'.$row["nombre"].'</option>';		  				  			
					else
					  echo '<option value='.$row[cod_sistema].'>'.$row["nombre"].'</option>';		  				  
				  }		  
				  echo "</select>\n";
			}
			else
			{
				echo "<input type='hidden' name='cmbsistema' value='".$cmbsistema."'>";
				$consulta = "select cod_sistema, nombre FROM  sistemas where cod_sistema = ".$cmbsistema."  ORDER BY nombre";
				$rs = mysqli_query($link, $consulta);
				if ($row = mysqli_fetch_array($rs))
				{
					echo $row["nombre"];
				}
				else
				{
					echo "Sistema NO encontrado";
				}
			}
		?></td>
    </tr>
    <tr> 
      <td>Nivel</td>
      <td> 
        <?php
			if ($Mostrar != "S")
			{
				if ($recargapag == "1")
				{
					$consulta = "SELECT MAX(nivel) AS maximo FROM niveles_por_sistema WHERE cod_sistema = ".$cmbsistema;
					$rs = mysqli_query($link, $consulta);
					$row = mysqli_fetch_array($rs);
					if ($row["maximo"] == "")
						$num = "";
					else 	
						$num = $row[maximo] + 1;
					echo '<input name="txtnivel" type="text" size="4" maxlength="4" value='.$num.'>';			
				}
				else
					echo "<input name='txtnivel' type='text' size='4' maxlength='4' value='".$txtnivel."'>";			
			}
			else
			{
				echo "<input name='txtnivel' type='hidden' size='4' maxlength='4' value='".$txtnivel."'>";
				echo $txtnivel;
			}
	  ?>
      </td>
    </tr>
    <tr> 
      <td>Descripcion</td>
      <td><input name="txtdescripcion" type="text" id="txtdescripcion" value="<?php echo $txtdescripcion; ?>" size="60" maxlength="60"></td>
    </tr>
    <tr align="center" valign="middle"> 
      <td height="20" colspan="2"><?php
	  	if ($Mostrar != "S")
		{
	  		echo "<input name='btngrabar' type='button' value='Grabar' style='width:80px' onClick=JavaScrip:grabar(this.form,'G');>\n";
		}
		else
		{
			echo "<input name='btnModificar' type='button' value='OK' style='width:80px' onClick=JavaScrip:grabar(this.form,'A');>\n";
		}
		?>
          &nbsp; 
          <input name="btnModif" type="button" value="Modificar" onClick="JavaScrip:Modificar(this.form)" style="width:80px" >
          &nbsp; 
          <input name="btneliminar" type="button" value="Eliminar" onClick="JavaScript:eliminar(this.form)" style="width:80px" >
          &nbsp;
          <input name="btnCancelar" type="button" style="width:80px" onClick="JavaScript:Cancelar(this.form)" value="Cancelar">
              &nbsp; 
              <input name="btnSalir" type="button" value="Salir" onClick="JavaScript:Salir(this.form);" style="width:80px"></td>
    </tr>    
  </table>
<br>
<table width="658" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
  <tr align="center" valign="middle" class="ColorTabla01"> 
      <td height="18" colspan="3"><strong>Detalles de los Niveles</strong></td>
    </tr>
    <?php
		if (isset($cmbsistema))
		{
			echo "<tr class='ColorTabla01'>\n";
	  		echo "<td width=41>&nbsp;</td>\n";
      		echo "<td width=107 height=16 align='center'>Nivel</td>\n";
      		echo "<td width=576 height=18 align='center' valign='middle'>Descripcion</td>\n";
    		echo "</tr>\n";
			$consulta = "SELECT * FROM niveles_por_sistema WHERE cod_sistema = ".$cmbsistema." order by nivel";
			$rs = mysqli_query($link, $consulta);
			$ColorTabla = "Tabla03";
			while ($row = mysqli_fetch_array($rs))
			{
				if ($ColorTabla == "Tabla03")
					$ColorTabla = "Tabla02";
				else	$ColorTabla = "Tabla03";
				echo "<tr class='".$ColorTabla."'>\n";
				echo "<td align='center'><input type='checkbox' name='checkbox' value='".$row[nivel]."'></td>\n";
				echo "<td align='center'>".$row[nivel]."</td>\n";
				echo "<td>".ucwords(strtolower($row["descripcion"]))."</td>\n";
				echo "</tr>\n";
			}
		}
	?>
</table>
</td>
    </tr>
  </table>
<?php include("pie_pagina.php");?>
</form>
</body>
</html>
<?php include ("cerrar_principal.php") ?>
