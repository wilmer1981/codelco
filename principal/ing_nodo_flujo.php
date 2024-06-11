<?php
	$CodigoDeSistema = 14;
	$CodigoDePantalla = 5;
	//include("../principal/conectar_comet_web.php");
	include("../principal/conectar_principal.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
	
	$CookieRut = $_COOKIE["CookieRut"];
	$Rut=$CookieRut;
	//echo "RUT:".$Rut;
	$Consulta="select * from proyecto_modernizacion.sistemas_por_usuario where rut='".$Rut."' and cod_sistema=".$CodigoDeSistema;
	$Respuesta=mysqli_query($link, $Consulta);
	$Fila=mysqli_fetch_array($Respuesta);
	//var_dump($Fila);
	if(isset($Fila)){
		$Nivel=$Fila["nivel"];
	}else{
		$Nivel="";
	}
	if(isset($_REQUEST["cmbsistema"])){
		$cmbsistema=$_REQUEST["cmbsistema"];
	}else{
		$cmbsistema="";
	}
	if(isset($_REQUEST["recargapag"])){
		$recargapag=$_REQUEST["recargapag"];
	}else{
		$recargapag="";
	}


?>
<html>
<head>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<title>Ingreso Nodo</title>
<script language="JavaScript">
var fila = 2; //Posicion Inicial de la Fila.
var col = 1; //Cantidad de Columnas. (Elementos).
/**********************/
function Recarga1()
{
	var f = document.FrmNodoFlujo;
	
	f.action = "ing_nodo_flujo.php?recargapag=1";
	f.submit();
}
/********************/
function AlgunChequeado()
{
	try{
		var f = document.FrmNodoFlujo;	
	
		pos = fila; //Posicion del Checkbox que Indica la Primera Fila.
		largo = f.elements.length;
		for (i=pos; i<largo; i=i+col)
		{	
			if (f.elements[i].type != 'checkbox')			 
				return false;
			else if (f.elements[i].checked == true)
					return true;

		}
		return false;
	}catch(e){	
		return false;
	}
}
/***********************/
function ValorCheck()
{
	var f = document.FrmNodoFlujo;
	
	pos = fila; //Posicion del Checkbox que Indica la Primera Fila.
	largo = f.elements.length;
	for (i=pos; i<largo; i=i+col)
	{	
		if (f.elements[i].checked == true)
			return f.elements[i].value;
	}			
}
/************************/
function CantidadChequeados()
{		
	var f = document.FrmNodoFlujo;	
	pos = fila; //Posicion del Primer Checkbox del formulario.
	largo = f.elements.length;
	cont = 0;
	for (i=pos; i<largo; i=i+col)
	{	
		if (f.elements[i].type != 'checkbox')
			return cont;
		else if (f.elements[i].checked)
				cont++;
	}	
	return cont;
}
/********************/
function Proceso(opc, nodo)
{
	var f = document.FrmNodoFlujo;

	var linea = "sistema=" + f.cmbsistema.value;
	var largo = 180;
	
	switch (opc) {
		case 'A': 
			window.open("ing_nodo_flujo_popup.php?" + linea,"","top=170,left=180,width=440,height="+largo+",scrollbars=no,resizable=yes");
			break;
			
		case 'M':
			valor = CantidadChequeados();
			if ((valor == 0) || (valor > 1))
			{	
				alert("Debe Seleccionar Solo Una Casilla");
				return;
			}
			linea = linea + "&nodo=" + ValorCheck() + "&opc=M";
			window.open("ing_nodo_flujo_popup.php?" + linea,"","top=200,left=150,width=440,height="+largo+",scrollbars=no,resizable=yes");
			break;
			
		case 'E':
			if (AlgunChequeado() == false)
			{
				alert("Debe Seleccionar Una Casilla");
				return;
			}

			if (confirm("Esta Seguro de Eliminar el Nodo Y Sus Flujos Asociados"))
			{
				linea = linea + "&proceso=EN"
				f.action = "ing_nodo_flujo01.php?" + linea;
				f.submit();
			}
			break;			
			
		case 'D':
			valor = CantidadChequeados();
			if ((valor == 0) || (valor > 1))
			{	
				alert("Debe Seleccionar Solo Una Casilla");
				return;
			}
			linea = linea + "&nodo=" + ValorCheck();
			window.open("ing_nodo_flujo_detalle.php?" + linea,"","top=170,left=5,width=760,height=390,scrollbars=yes,resizable=yes");
			break;
			
		case 'C':
			linea = linea + "&nodo=" + nodo;
			window.open("ing_nodo_detalle.php?" + linea,"","top=150,left=70,width=620,height=390,scrollbars=yes,resizable=yes");
			break;
			
		case 'S': 
			f.action = "../principal/sistemas_usuario.php?CodSistema=16";
			f.submit();		
			break;		
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="FrmNodoFlujo" action="" method="post">
<?php include("../principal/encabezado.php");?>
<table width="770" height="430" border="0" class="TablaPrincipal">
<tr><td>
<div style="position:absolute; left: 90px; top: 65px; width:518px; height:30px;" id="div1">
<table width="600" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
  <tr>
    <td width="258">Sistema</td>
    <td width="327"><select name="cmbsistema" onChange="Recarga1()">
	<option value='-1'>SELECCIONAR</option>
	<?php
		$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase";
		$consulta.= " WHERE cod_clase = '0' AND valor_subclase3 = 'S'";
		$rs = mysqli_query($link, $consulta);
		while ($row = mysqli_fetch_array($rs))
		{
			if ($row["valor_subclase4"] == $cmbsistema)
				echo '<option value="'.$row["valor_subclase4"].'" selected>'.$row["nombre_subclase"].'</opction>';
			else
				echo '<option value="'.$row["valor_subclase4"].'">'.$row["nombre_subclase"].'</opction>';			
		}
	?>	
    </select>
              &nbsp; 
              <input name="btnok" type="button" id="btnok" value="OK" onClick="Recarga1()"></td>
  </tr>
</table>

</div>

<div style="position:absolute; left: 91px; top: 106px; width:620px; height:32px;" id="div2">
          <table width="600" border="1" align="left" cellpadding="0" cellspacing="0" class="TablaInterior">
            <tr class="ColorTabla01"> 
              <td width="124" align="center" height="25">Nodo</td>
              <td width="234" align="center">Descripcion</td>
            </tr>
          </table>
</div>

<div style="position:absolute; left: 91px; top: 132px; width:620px; height:280px; OVERFLOW: auto;" id="div5">
<table width="600" border="1" align="left" cellpadding="0" cellspacing="0" class="TablaInterior">
<?php			
	$consulta = "SELECT * FROM proyecto_modernizacion.nodos";	
	$consulta.= " WHERE sistema = '".$cmbsistema."'";
	$consulta.= " ORDER BY CEILING(cod_nodo)";
	$rs = mysqli_query($link, $consulta);
	$cont = 0;
	while ($row = mysqli_fetch_array($rs))
	{
		if ($row["valor1"]=='P')//SI ES PROCESO
		{
			echo '<tr class=Detalle01>';	
		}
		else
		{
			echo '<tr>';
		}
		echo '<td width="124" align="left" height="25"><input type="checkbox" name="checkbox['.$cont.']" value="'.$row["cod_nodo"].'">'.$row["cod_nodo"].'</td>';
		echo '<td width="234"><a href="JavaScript:Proceso(\'C\', \''.$row["cod_nodo"].'\')">'.$row["descripcion"].'&nbsp;</a></td>';
		echo '</tr>';
		$cont++;
	}
?>	
</table>
</div>
<div style="position:absolute; left: 90px; top: 440px; width:518px; height:29px;" id="div3">
<table width="600" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
  <tr>
    <td align="center">
	<input name="btnagregar" type="button" id="btnagregar" value="Nuevo" style="width:90" onClick="Proceso('A','')">
    <input name="btnmodificar" type="button" id="btnmodificar" value="Modificar" style="width:90" onClick="Proceso('M','')">
	<?php
		if ($Nivel=='1')
			echo "<input name='btneliminar' type='button' value='Eliminar' style='width:90' onClick=Proceso('E','')>";
	?>
	<input name="btndetalle" type="button" id="btndetalle" value="Agregar/Modif.Flujo" style="width:130" onClick="Proceso('D','')">
	<input name="btnsalir" type="button" id="btnsalir" value="Salir" style="width:90" onClick="Proceso('S','')"></td>
  </tr>
</table>
</div>
</td>
</tr>
</table>
<?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
