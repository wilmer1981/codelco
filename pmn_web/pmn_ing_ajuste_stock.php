<?php
	$CodigoDeSistema = 6;
	$CodigoDePantalla = 132;
	
	include("../principal/conectar_pmn_web.php");				
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Recarga1()
{
	var f = document.frmPrincipal;
	
	f.action = "pmn_ing_ajuste_stock.php?recargapag1=S";
	f.submit();
}
/******************/
function ValidaCampos()
{
	var f = document.frmPrincipal;
	
	if (f.cmbproducto.value == -1)
	{
		alert("Debe Seleccionar El Producto");
		return false;
	}	
	
	if (f.cmbsubproducto.value == -1)
	{
		alert("Debe Seleccionar El SubProducto");
		return false;
	}
	
	if (f.cmbturno.value == -1)
	{
		alert("Debe Seleccionar El Turno");
		return false;
	}	
	
	if (isNaN(parseInt(f.txtpeso.value)))
	{
		alert("El Peso No Es Valido");
		return false;
	}
	
	return true;
}
/******************/
function Grabar()
{	
	var f = document.frmPrincipal;
	
	if (ValidaCampos())
	{
		f.action = "pmn_ing_ajuste_stock01.php?proceso=G";
		f.submit();
	}
}
/***************/
function Modificar()
{
	var f = document.frmPrincipal;
	
	linea = "cmbproducto=" + f.cmbproducto.value + "&cmbsubproducto=" + f.cmbsubproducto.value;
	f.action = "pmn_ing_ajuste_stock01.php?proceso=M&" + linea;
	f.submit();
}
/***************/
function Eliminar()
{
	var f = document.frmPrincipal;
	
	linea = "cmbproducto=" + f.cmbproducto.value + "&cmbsubproducto=" + f.cmbsubproducto.value;	
	f.action = "pmn_ing_ajuste_stock01.php?proceso=E&" + linea;
	f.submit();
}
/******************/
function Consultar()
{
	var f = document.frmPrincipal;
	var linea = 'cmbproducto=' + f.cmbproducto.value + '&cmbsubproducto=' + f.cmbsubproducto.value;
	
	window.open("pmn_ing_ajuste_stock_popup.php?"+linea,"","top=100,left=180,width=540,height=350,scrollbars=no,resizable=no");
}
/******************/
function Cancelar()
{
	document.location = 'pmn_ing_ajuste_stock.php';	
}
/******************/
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=6&Nivel=1&CodPantalla=131";
}
</script>
</head>

<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="frmPrincipal" method="post" action="">
<?php include("../principal/encabezado.php")?>

<?php
	//Campos Ocultos.
	echo '<input name="fecha_aux" type="hidden" value="'.$fecha_aux.'">';
	echo '<input name="turno_aux" type="hidden" value="'.$turno_aux.'">';
?>
<table width="770" height="330" border="0" class="TablaPrincipal">
<tr>
      <td align="center" valign="top"><table width="600" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="196" align="left">Fecha</td>
            <td width="389" align="left">               
                <?php
		$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

		echo '<select name="dia" size="1">';
		for ($i=1;$i<=31;$i++)
		{	
			if (($mostrar == "S") && ($i == $dia))			
				echo "<option selected value= '".$i."'>".$i."</option>";				
			else if (($i == date("j")) and ($mostrar != "S")) 
					echo "<option selected value= '".$i."'>".$i."</option>";											
			else					
				echo "<option value='".$i."'>".$i."</option>";												
		}
		echo '</select>';

	?>
          <select name="mes" size="1" id="select">
                <?php
		for($i=1;$i<13;$i++)
		{
			if (($mostrar == "S") && ($i == $mes))
				echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
			else if (($i == date("n")) && ($mostrar != "S"))
					echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
			else
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";			
		}		  
	?>
              </select> <select name="ano" size="1">
                <?php
		for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
		{
			if (($mostrar == "S") && ($i == $ano))
				echo "<option selected value ='$i'>$i</option>";
			else if (($i == date("Y")) && ($mostrar != "S"))
				echo "<option selected value ='$i'>$i</option>";
			else	
				echo "<option value='".$i."'>".$i."</option>";
		}
	?>
              </select></td>
          </tr>
        </table> 
        <br>
        <table width="600" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="195">Producto</td>
            <td width="390">
			<?php
				if ($mostrar == "S")
					echo '<select name="cmbproducto" onChange="Recarga1()" disabled>';
				else
					echo '<select name="cmbproducto" onChange="Recarga1()">';
			?>
                <option value="-1">SELECCIONAR</option>
                <?php
					$consulta = "SELECT * FROM proyecto_modernizacion.productos";
					$consulta.= " WHERE cod_producto IN ('25','36')";
					$rs = mysqli_query($link, $consulta);
					while ($row = mysqli_fetch_array($rs))
					{
						if ($row["cod_producto"] == $cmbproducto)
							echo '<option value="'.$row["cod_producto"].'" selected>'.$row["descripcion"].'</option>';
						else
							echo '<option value="'.$row["cod_producto"].'">'.$row["descripcion"].'</option>';
					}
				?>
              </select></td>
          </tr>
          <tr> 
            <td>SubProducto</td>
            <td>
			<?php
				if ($mostrar == "S")
					echo '<select name="cmbsubproducto" disabled>';
				else				
					echo '<select name="cmbsubproducto">';
			?>
                <option value="-1">SELECCIONAR</option>
				<?php
					if ($recargapag1 == "S")
					{
						$consulta = "SELECT * FROM proyecto_modernizacion.subproducto";
						$consulta.= " WHERE cod_producto = '".$cmbproducto."'";
						$rs1 = mysqli_query($link, $consulta);
						while ($row1 = mysqli_fetch_array($rs1))
						{
							if (($row1["cod_producto"] == '25' and $row1["cod_subproducto"] == '1') or ($row1["cod_producto"] == '36' and $row1["cod_subproducto"] == '1'))
							{
								if ($row1["cod_subproducto"] == $cmbsubproducto)
									echo '<option value="'.$row1["cod_subproducto"].'" selected>'.$row1["descripcion"].'</option>';
								else
									echo '<option value="'.$row1["cod_subproducto"].'">'.$row1["descripcion"].'</option>';
							}
						}
					}
				?>
              </select></td>
          </tr>
        </table> 
        <br>
        <table width="600" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr>
            <td>Turno</td>
            <td><select name="cmbturno">
                <option value="-1">SELECCIONAR</option>
				<?php
					$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase"; 
					$consulta.= " WHERE cod_clase = '1'";
					$rs = mysqli_query($link, $consulta);
					while ($row = mysqli_fetch_array($rs))
					{
						if ($row["cod_subclase"] == $cmbturno)
							echo '<option value="'.$row["cod_subclase"].'" selected>'.$row["nombre_subclase"].'</option>';
						else
							echo '<option value="'.$row["cod_subclase"].'">'.$row["nombre_subclase"].'</option>';						
					}
				?>				
				
              </select></tr>
          <tr> 
            <td width="260">Tipo Ajuste</td>
            <td width="325"> 
              <?php
				if ($radiotipo == '-')
				{
					echo '<input name="radiotipo" type="radio" value="+">(+) Positivo &nbsp;&nbsp;';
            		echo '<input name="radiotipo" type="radio" value="-" checked>(-) Negativo</td>';
				}
				else
				{
					echo '<input name="radiotipo" type="radio" value="+" checked>(+) Positivo &nbsp;&nbsp;';
            		echo '<input name="radiotipo" type="radio" value="-">(-) Negativo</td>';					
				}
				
			?>
          </tr>
          <tr> 
            <td>Peso</td>
            <td><input name="txtpeso" type="text" value="<?php echo $txtpeso ?>"></td>
          </tr>
        </table> 
        <br>
        <table width="600" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr>
            <td align="center">
			<?php
				if ($mostrar == "S")
					echo '<input name="btnmodificar" type="button" value="Modificar" style="width:70" onClick="Modificar()">';
				else
					echo '<input name="btngrabar" type="button" value="Grabar" style="width:70" onClick="Grabar()">';
			?>
            <input name="btneliminar" type="button" value="Eliminar" style="width:70" onClick="Eliminar()">
            <input name="btnconsultar" type="button" value="Consultar" style="width:70" onClick="Consultar()">
              <input name="btncancelar" type="button" style="width:70" value="Cancelar" onClick="Cancelar()">
              <input name="btnsalir" type="button" value="Salir" style="width:70" onClick="Salir()"></td>
          </tr>
      </table> </td>
</tr>
</table>

<?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
<?php 	include("../principal/cerrar_pmn_web.php"); ?>