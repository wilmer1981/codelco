<?php 
	$CodigoDeSistema = 99;
	$CodigoDePantalla = 8;
	include("conectar_principal.php");

	if(isset($_POST["Sistema"])){
		$Sistema = $_POST["Sistema"];
	}else{
		$Sistema = "";
	}
	if(isset($_POST["Producto"])){
		$Producto = $_POST["Producto"];
	}else{
		$Producto = "";
	}
?>
<html>
<head>
<title>Administrador de Sistemas</title>
<link href="estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "G":
			if (f.Sistema.value=="T")
			{
				alert("Debe Seleccionar Sistema");
				return;
			}
			if (f.Producto.value=="T")
			{
				alert("Debe Seleccionar Producto");
				return;
			}
			f.action = "productos_por_sistema01.php?Proceso=G";
			f.submit();
			break;
		case "ET":
			if (f.Sistema.value!="T")
			{
				var msg=confirm("�Desea Eliminar Toda la Relacion del Sistema?");
				if (msg==true)
				{
					f.action = "productos_por_sistema01.php?Proceso=ET";
					f.submit();
				}
				else
				{
					return;
				}
			}
			else
			{
				alert("No hay nada seleccionado");
				return;
			}
			break;
		case "E":
			var Valor = "";
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="ChkProducto" && f.elements[i].checked==true)
				{
					Valor = f.elements[i].value;
				}
			}
			if (Valor!="")
			{
				var msg=confirm("�Desea Eliminar esta Relacion?");
				if (msg==true)
				{
					f.action = "productos_por_sistema01.php?Proceso=E&Valor="+Valor;
					f.submit();
				}
				else
				{
					return;
				}
			}
			else
			{
				alert("No hay nada seleccionado");
				return;
			}
			break;
		case "I":
			window.print();
			break;
		case "R":
			f.action = "productos_por_sistema.php";
			f.submit();
			break;
		case "S":
			f.action = "sistemas_usuario.php?CodSistema=99&Nivel=0";
			f.submit();
			break;
	}
}
</script>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style></head>

<body>
<form name="frmPrincipal" method="post" action="">
<?php include("encabezado.php");?> 
<table width="770" height="330" border="0" cellspacing="0" cellpadding="0" class="TablaPrincipal">
    <tr>
      <td height="161" valign="top"><br>
<table width="500" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
  <tr> 
      <td width="21%">Sistema </td>
      <td width="79%"><select name="Sistema" onChange="Proceso('R')">
	  <option value="T">SELECCIONAR</option>
<?php
	$Consulta = "select * from proyecto_modernizacion.sistemas order by nombre ";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{
		if ($Sistema == $Fila["cod_sistema"])
			echo "<option selected value='".$Fila["cod_sistema"]."'>".strtoupper($Fila["nombre"])."</option>\n";
		else
			echo "<option value='".$Fila["cod_sistema"]."'>".strtoupper($Fila["nombre"])."</option>\n";
	}
?>	  
      </select></td>
    </tr>
    <tr> 
      <td>Producto</td>
      <td><select name="Producto" onChange="Proceso('R')">
	  <option value="T">SELECCIONAR</option>
<?php
	$Consulta = "select * from proyecto_modernizacion.productos order by descripcion ";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{
		if ($Producto == $Fila["cod_producto"])
			echo "<option selected value='".$Fila["cod_producto"]."'>".strtoupper($Fila["descripcion"])."</option>\n";
		else
			echo "<option value='".$Fila["cod_producto"]."'>".strtoupper($Fila["descripcion"])."</option>\n";
	}
?>	  
	  
      </select> 
      </td>
    </tr>
    <tr> 
      <td>SubProducto</td>
      <td><select name="SubProducto">	  
<?php
	if (isset($Producto) && $Producto!="T")
		echo "<option value='T'>TODOS</option>\n";
	else
		echo "<option value='T'>SELECCIONAR</option>\n";
	$Consulta = "select * from proyecto_modernizacion.subproducto where cod_producto='".$Producto."' order by descripcion ";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{
		if ($SubProducto == $Fila["cod_subproducto"])
			echo "<option selected value='".$Fila["cod_subproducto"]."'>".strtoupper($Fila["descripcion"])."</option>\n";
		else
			echo "<option value='".$Fila["cod_subproducto"]."'>".strtoupper($Fila["descripcion"])."</option>\n";
	}
?>		  
      </select></td>
    </tr>
    <tr align="center" valign="middle"> 
      <td height="20" colspan="2"> 
          <input name="BtnGrabar" type="button" id="BtnGrabar" style="width:70px" onClick="Proceso('G')" value="Grabar" >
          &nbsp; 
          <input name="btneliminar" type="button" value="Eliminar" onClick="Proceso('E')" style="width:70px" > 
           &nbsp;
           <input name="BtnEliminar2" type="button" id="BtnEliminar2" style="width:90px" onClick="Proceso('ET')" value="Eliminar Todo" >
          &nbsp;
          <input name="BtnImprimir" type="button" id="BtnImprimir" style="width:70px" onClick="Proceso('I')" value="Imprimir">
              &nbsp; 
            <input name="btnSalir" type="button" value="Salir" onClick="Proceso('S')" style="width:70px"></td>
    </tr>    
  </table>
<br>
<table width="700"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
  <tr align="center" class="ColorTabla01">
    <td width="50">Eliminar</td>
    <td width="69">Producto</td>
    <td width="229">Descripcion</td>
    <td width="71">SubProducto</td>
    <td width="248">Descripcion</td>
  </tr>
<?php  
	$Consulta = "select t1.cod_producto, t1.cod_subproducto, t2.descripcion as nom_prod, t3.descripcion as nom_subprod ";
	$Consulta.= " from proyecto_modernizacion.productos_sistema t1 inner join proyecto_modernizacion.productos t2 on ";
	$Consulta.= " t1.cod_producto = t2.cod_producto inner join proyecto_modernizacion.subproducto t3 on ";
	$Consulta.= " t1.cod_producto = t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto";
	$Consulta.= " where cod_sistema='".$Sistema."'";
	$Resp =  mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{
		$Valor = str_pad($Fila["cod_producto"],3,"0",STR_PAD_LEFT)."".str_pad($Fila["cod_subproducto"],3,"0",STR_PAD_LEFT);
		echo "<tr>\n";
		echo "<td align='center'><input name='ChkProducto' type='radio' value='".$Valor."'></td>\n";
		echo "<td>".$Fila["cod_producto"]."</td>\n";
		echo "<td>".$Fila["nom_prod"]."</td>\n";
		echo "<td>".$Fila["cod_subproducto"]."</td>\n";
		echo "<td>".$Fila["nom_subprod"]."</td>\n";
		echo "</tr>\n";
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
