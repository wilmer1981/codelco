<?php
	$CodigoDeSistema = 6;
	$CodigoDePantalla = 142;
	
	include("../principal/conectar_pmn_web.php");				
	if (!isset($mes1))
	{
		$mes1 = date("n",mktime(0,0,0,date("n"),1-1,date("Y")));
		$ano1 = date("Y",mktime(0,0,0,date("n"),1-1,date("Y")));
	}
	$txtpeso = "";
	$txtag = "";
	$txtau = "";
	if ($proceso == "B")
	{			
		$consulta = "SELECT * FROM pmn_web.existencia_nodo";
		$consulta.= " WHERE ano = '".$ano."' AND mes = '".$mes."' AND nodo = '".$nodo."' AND prod = '".$prod."'";						
	}	
	else
	{			
		$consulta = "SELECT * FROM pmn_web.existencia_nodo";
		$consulta.= " WHERE ano = '".$ano1."' AND mes = '".$mes1."' AND nodo = '".$cmbnodo."'";						
	}
	//echo $consulta;
	$rs = mysqli_query($link, $consulta);
	if ($row = mysqli_fetch_array($rs))
	{
		$ano1 = $row[ano];
		$mes1 = $row[mes];
		$cmbnodo = $row["nodo"];
		$cmbprod = $row[prod];
		$txtpeso = number_format($row["peso"],3,",","");
		$txtag = number_format($row[fino_ag],3,",","");
		$txtau = number_format($row[fino_au],3,",","");
		//VARIABLES PARA MODIFICAR
		$proceso="B";
		$opc = "M";
		$recargapag=1;		
	}
	
	if (!isset($activar))
		$FuncInicio = 'onLoad="Inicio(1)"';
	else
		$FuncInicio = 'onLoad="Inicio(2)"';
?>
<html>
<head>
<title>PLAMEN - Ingreso de Existencias</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function Recarga1()
{
	var f = document.frmPrincipal;
	
	var linea = "recargapag1=S&activar=";
	
	f.action = "pmn_ing_existencias.php?" + linea;
	f.submit();
}
/*****************/
function ValidaCampos()
{
	var f = document.frmPrincipal;
	
	if (f.cmbnodo.value == -1)
	{
		alert("Debe Seleccionar Nodo");
		f.txtnodo.focus();
		return false;
	}		
	
	if (f.cmbnodo.value == 7)
	{
		if (f.cmbprod.value == -1)
		{
			alert("Debe Seleccionar El Producto");
			return false;
		}
	}
	
	if (isNaN(parseFloat(f.txtpeso.value)))
	{
		alert("El Peso No Es Valido");
		f.txtpeso.focus();
		return false;
	}
	
	if (isNaN(parseFloat(f.txtag.value)))
	{
		alert("El Fino Ag No Es Valido");
		f.txtag.focus();
		return false;
	}
	
	if (isNaN(parseFloat(f.txtau.value)))
	{
		alert("El Fino Au No Es Valido");
		f.txtau.focus();
		return false;
	}
		
	return true;
}
/******************/
function SeleccionarNodo()
{	
	var f = document.frmPrincipal;

	if (f.txtnodo.value == '')
		return;
		
	for (i=1; i< f.cmbnodo.options.length; i++)
	{
		if ((f.cmbnodo.options[i].value) == f.txtnodo.value)
		{
			f.cmbnodo.value = f.cmbnodo.options[i].value;
			Recarga1();
			return;
		}
	}
	
	f.txtnodo.focus();	
}
/******************/
function Grabar()
{	
	var f = document.frmPrincipal;
	
	if (ValidaCampos())
	{
		f.action = "pmn_ing_existencias01.php?proceso=G";
		f.submit();
	}
}
/******************/
function Modificar()
{	
	var f = document.frmPrincipal;
	
	if (ValidaCampos())
	{
		f.action = "pmn_ing_existencias01.php?proceso=M";
		f.submit();
	}
}
/******************/
function Eliminar()
{	
	var f = document.frmPrincipal;
	
	if (confirm("Esta Seguro De Eliminar El Registro"))
	{
		f.action = "pmn_ing_existencias01.php?proceso=E";
		f.submit();
	}
}
/******************/
function Consultar()
{
	var f = document.frmPrincipal;	

	var linea = '';
	
	window.open("pmn_ing_existencias_popup.php?"+linea,"","top=100,left=80,width=650,height=380,scrollbars=no,resizable=no");
}
/******************/
function Cancelar()
{
	document.location = 'pmn_ing_existencias.php';	
}
/******************/
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=6&Nivel=1&CodPantalla=143";
}
/****************/
function TeclaPulsada(salto)
{
	var f = document.frmPrincipal;
	var teclaCodigo = event.keyCode; 
	
	if (teclaCodigo == 13)
	{
		switch (salto) {
			case 0: f.txtpeso.focus();
					break;
			case 1: f.txtag.focus();
					break;
			case 2: f.txtau.focus();
					break;
			case 3: f.btngrabar.focus();
					break;
			case 4: f.txtnodo.focus();
					break;
		}
	}
}
/****************/
function Inicio(opc)
{
	var f = document.frmPrincipal;
	
	switch (opc){
		case 1: f.txtnodo.focus();
				break;
		case 2: f.txtpeso.focus();
				break;
	}			
}
</script>
</head>

<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0" <?php echo $FuncInicio ?>>
<form name="frmPrincipal" method="post" action="">
<?php include("../principal/encabezado.php")?>

<?php
	//Campos Ocultos.
	echo '<input type="hidden" name="ano_aux" value="'.$ano1.'">';
	echo '<input type="hidden" name="mes_aux" value="'.$mes1.'">';	
	echo '<input type="hidden" name="nodo_aux" value="'.$cmbnodo.'">';	
	echo '<input type="hidden" name="prod_aux" value="'.$cmbprod.'">';			
	echo '<input type="hidden" name="peso_aux" value="'.$txtpeso.'">';	
	echo '<input type="hidden" name="ag_aux" value="'.$txtag.'">';	
	echo '<input type="hidden" name="au_aux" value="'.$txtau.'">';
?>
<table width="770" border="0" class="TablaPrincipal">
<tr>
<td height="330" align="center" valign="top">

  <br>
  <table width="600" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="205">Fecha</td>
            <td width="380"> <select name="mes1" size="1">
                <?php
		$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");				
		for($i=1;$i<13;$i++)
		{
			if (isset($mes1))
			{
				if ($mes1==$i)
					echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
				else
					echo "<option value ='".$i."'>".$meses[$i-1]." </option>";
			}
			else
			{
				if ($i==date("n"))
					echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
				else
					echo "<option value ='".$i."'>".$meses[$i-1]." </option>";
			}
		}		  
	?>
              </select> <select name="ano1" size="1">
                <?php
		for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
		{
			if (isset($ano1))
			{
				if ($ano1==$i)
					echo "<option selected value ='".$i."'>".$i." </option>";
				else
					echo "<option value ='".$i."'>".$i." </option>";
			}
			else
			{
				if ($i==date("Y"))
					echo "<option selected value ='".$i."'>".$i." </option>";
				else
					echo "<option value ='".$i."'>".$i." </option>";
			}
		}
	?>
              </select> </td>
          </tr>
          <tr> 
            <td>Nodo</td>
            <td> <input name="txtnodo" type="text" id="txtnodo" size="10" onKeyDown="TeclaPulsada(0)" onBlur="SeleccionarNodo()">
              &nbsp; 
              <select name="cmbnodo" id="cmbnodo" onChange="Recarga1()">
                <option value="-1">SELECCIONAR</option>
                <?php
		$consulta = "SELECT * FROM proyecto_modernizacion.nodos WHERE sistema = 'PMN' AND virtual = 'N'";
		$consulta.= " ORDER BY cod_nodo";
		$rs = mysqli_query($link, $consulta);
		while ($row = mysqli_fetch_array($rs))
		{
			if ($row["cod_nodo"] == $cmbnodo)
				echo '<option value="'.$row["cod_nodo"].'" selected>'.str_pad($row["cod_nodo"],2,'0',STR_PAD_LEFT).' - '.$row["descripcion"].'</option>';
			else
				echo '<option value="'.$row["cod_nodo"].'">'.str_pad($row["cod_nodo"],2,'0',STR_PAD_LEFT).' - '.$row["descripcion"].'</option>';
		}
	?>
              </select></td>
            <?php			  
	if ($cmbnodo == '7')
	{
		echo '</tr>';
		echo '<tr>';
		echo '<td>Producto</td>';
		echo '<td><select name="cmbprod">';
		echo '<option value="-1">SELECCIONAR</option>';
		
		$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase";
		$consulta.= " WHERE cod_clase = '6011' AND valor_subclase1 = '".$cmbnodo."'";
		$consulta.= " ORDER BY cod_subclase";

		$rs = mysqli_query($link, $consulta);
		while ($row = mysqli_fetch_array($rs))
		{
			if ($row["cod_subclase"] == $cmbprod)
				echo '<option value="'.$row["cod_subclase"].'" selected>'.$row["nombre_subclase"].'</option>';
			else
				echo '<option value="'.$row["cod_subclase"].'">'.$row["nombre_subclase"].'</option>';
		}
		echo '</select></td>';		
		echo '</tr>';
	}	
?>
        </table>

        <br>
        <table width="400" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr>
            <td width="171">Peso (Kg):</td>
            <td width="214"><input name="txtpeso" type="text" id="txtpeso" value="<?php echo $txtpeso ?>" onKeyDown="TeclaPulsada(1)"></td>
          </tr>
          <tr>
            <td>Fino Ag (Kg):</td>
            <td><input name="txtag" type="text" id="txtag" value="<?php echo $txtag ?>" onKeyDown="TeclaPulsada(2)"></td>
          </tr>
          <tr>
            <td>Fino Au (Kg):</td>
            <td><input name="txtau" type="text" id="txtau" value="<?php echo $txtau ?>" onKeyDown="TeclaPulsada(3)"></td>
          </tr>
        </table> 
        <br>
        <table width="600" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td align="center"> 
              <?php
				if ($opc == "M")
					echo '<input name="btngrabar" type="button" value="Modificar" style="width:70" onClick="Modificar()">';
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
