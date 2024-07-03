<?php 
	$CodigoDeSistema = 2;
	//$CodigoDePantalla = 1;
	$CodigoDePantalla = 2;

	if(isset($_REQUEST["recargapag"])) {
		$recargapag = $_REQUEST["recargapag"];
	}else{
		$recargapag =  "";
	}
	if(isset($_REQUEST["cmbcircuito"])) {
		$cmbcircuito = $_REQUEST["cmbcircuito"];
	}else{
		$cmbcircuito =  "";
	}
	if(isset($_REQUEST["cmbgrupo"])) {
		$cmbgrupo = $_REQUEST["cmbgrupo"];
	}else{
		$cmbgrupo =  "";
	}
	if(isset($_REQUEST["txtvalor"])) {
		$txtvalor = $_REQUEST["txtvalor"];
	}else{
		$txtvalor =  "";
	}
	
?>

<html>
<head>
<title>Sistema de Anodos</title>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function ValidaCampos(f)
{
	if (f.cmbcircuito.value == -1)
	{
		alert("Debe Seleccionar Circuito");
		return false;
	}
	
	if (f.txtvalor.value == "")
	{
		alert("Debe Ingresar el Valor del Factor");
		return false ;
	}
	
	if (isNaN(parseInt(f.txtvalor.value)))			
	{
		alert("El Valor del Factor no es Vlido");
		return false;
	}	
	
	return true;
}
//*********************//
function Grabar(f)
{
	if (ValidaCampos(f))
	{
		f.action = "sea_ing_factor01.php?proceso=G";
		f.submit();
	}
}
//*******************//
function ValidaSeleccion(f,Nombre)
{
	var LargoForm = f.elements.length;
	var Valores = "";
	for (i = 0; i < LargoForm; i++)
	{
		if ((f.elements[i].name == Nombre) && (f.elements[i].checked == true))
		{
			Valores =  Valores + f.elements[i].value + "/";
		}
	}
	return Valores;
}
//*******************//
function Eliminar(f)
{
	parametros = ValidaSeleccion(f,'checkbox');
	if (parametros == "")
	{
		alert("Debe Seleccionar Casillas");
		return;
	}
	else
	{
		f.action = "sea_ing_factor01.php?proceso=E&parametros=" + parametros;
		f.submit();
	}
}
//******************//
function Recarga(f)
{
	f.action = "sea_ing_factor.php?recargapag=S&cmbcircuito=" + f.cmbcircuito.value;
	f.submit();
}
/****************/
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=2&Nivel=1&CodPantalla=30";
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>

<body leftmargin="3" topmargin="5">

<form name="frm1" action="" method="post">
<?php include("../principal/encabezado.php") ?>
<?php include("../principal/conectar_principal.php") ?> 

  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
      <td width="762" align="center" valign="middle">

<table width="450" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr>
    <td width="215">N&deg; Circuito</td>
    <td width="279"><SELECT name="cmbcircuito" id="cmbcircuito" onChange="JavaScript:Recarga(this.form)">
        <?php
			echo '<option value="-1">SELECCIONAR</option>';
			$consulta = "SELECT * FROM sub_clase WHERE cod_clase = 2003 ORDER BY nombre_subclase";
			$rs = mysqli_query($link, $consulta);
			while ($row = mysqli_fetch_array($rs))
			{
				if ($row["cod_subclase"] == $cmbcircuito)
			        echo '<option value="'.$row["cod_subclase"].'" SELECTed>'.$row["nombre_subclase"].'</option>';		
				else 
			        echo '<option value="'.$row["cod_subclase"].'">'.$row["nombre_subclase"].'</option>';		
			}
		?>
      </SELECT></td>
  </tr>
  <tr>
    <td>Grupos Asociados</td>
    <td><SELECT name="cmbgrupo" id="cmbgrupo">
        <?php
          	echo '<option value="-1">Grupos</option>';
			if ($recargapag == "S")
			{
				$consulta = "SELECT * FROM sub_clase WHERE cod_clase = 2004 AND valor_subclase1 = '".$cmbcircuito."'";
				$rs = mysqli_query($link, $consulta);
				while ($row = mysqli_fetch_array($rs))
				{
		          	echo '<option>'.$row["nombre_subclase"].'</option>';
				}
			}
		?>
      </SELECT></td>
  </tr>
  <tr>
    <td>Valor Factor (%)</td>
    <td><input name="txtvalor" type="text" id="txtvalor" size="10" maxlength="10"></td>
  </tr>
</table>
<br>
<table width="450" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><input name="btngrabar" type="button" value="Grabar" style="width=50" onClick="JavaScript:Grabar(this.form)"></td>
  </tr>
</table>
<br>
<table width="450" border="0" cellspacing="0" cellpadding="0" class="ColorTabla01">
  <tr>
    <td width="150" height="20" align="center">Circuitos</td>
    <td width="150" align="center">Grupos Asociados</td>
            <td width="150" align="center">Valor Factor (%)</td>
  </tr>
</table>

<?php
	echo '<table width="450" border="1" cellspacing="0" cellpadding="3" class="ColorTabla02">';
	$consulta = "SELECT * FROM sub_clase WHERE cod_clase = 2003 ORDER BY nombre_subclase";
	$rs1 = mysqli_query($link, $consulta);
	while($row1 = mysqli_fetch_array($rs1))
	{		
	    echo '<tr>';
    	echo '<td width="150" align="center">'.$row1["nombre_subclase"].'</td>';
		echo '<td width="150" align="center"><SELECT name="SELECT"><option>Grupos</option>';
		
		$consulta = "SELECT * FROM sub_clase WHERE cod_clase = 2004 AND valor_subclase1 = '".$row1["cod_subclase"]."'";
		$rs2 = mysqli_query($link, $consulta);
		while ($row2 = mysqli_fetch_array($rs2))
		{
	    	echo '<option>'.$row2["nombre_subclase"].'</option>';	
		}
		echo '</SELECT></td>';
	    echo '<td width="150" align="center">'.$row1["valor_subclase1"].'</td>';
	    echo '</tr>';
	}
  	echo '</table>';
?>
<br>
<table width="450" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><input name="btnsalir" type="button" value="Salir" style="width=70" onClick="JavaScript:Salir()"></td>
  </tr>
</table>

</td>
</tr>
</table>
<?php include ("../principal/pie_pagina.php") ?> 

</form>
</body>
</html>
<?php include("../principal/cerrar_principal.php") ?>