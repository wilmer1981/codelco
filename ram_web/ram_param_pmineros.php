<? 
$CodigoDeSistema = 7;
$CodigoDePantalla = 20;
include("../principal/conectar_principal.php");
?>
<html>
<head>
<title>Sistema RAM</title>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frm1;
	switch (opt)
	{
		case "G":
			if (f.Nodo.value=="S")
			{
				alert("Debe Seleccionar Nodo");
				f.Nodo.focus();
				return;
			}
			if (f.Flujo.value=="S")
			{
				alert("Debe Seleccionar Flujo");
				f.Flujo.focus();
				return;
			}
			if (f.Producto.value=="S")
			{
				alert("Debe Seleccionar Producto");
				f.Producto.focus();
				return;
			}
			if (f.SubProducto.value=="S")
			{
				alert("Debe Seleccionar Subproducto");
				f.SubProducto.focus();
				return;
			}
			if (f.Tipo.value=="S")
			{
				alert("Debe Seleccionar Cod. Existencia");
				f.Tipo.focus();
				return;
			}
			if (f.Destino.value=="S")
			{
				alert("Debe Seleccionar Lugar de Destino");
				f.Destino.focus();
				return;
			}
			f.action="ram_param_pmineros01.php?Proceso=G";
			f.submit();
			break;
		case "E":
			var Valores = "";
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name == "ChkFlujo" && f.elements[i].checked==true)
					Valores = f.elements[i].value;
			}
			if (Valores=="")
			{			
				alert("No hay Nada Seleccionado para Eliminar");
				return;
			}
			else
			{
				var msg = confirm("¿Seguro que desea eliminar esta relacion?");
				if (msg==true)
				{				
					f.action="ram_param_pmineros01.php?Proceso=E&Valores=" + Valores;
					f.submit();
				}
				else
				{
					return;
				}
			}
			break;
		case "X":
			f.action = "ram_param_pmineros_excel.php";
			f.submit();
			break;
		case "I":
			window.print();
			break;
		case "R":
			f.action = "ram_param_pmineros.php";
			f.submit();
			break;
		case "S":
			f.action = "../principal/sistemas_usuario.php?CodSistema=7&Nivel=1&CodPantalla=19";
			f.submit();
			break;
	}	
}
</script>
</head>

<body leftmargin="3" topmargin="5">
<form name="frm1" action="" method="post">
<? include("../principal/encabezado.php") ?>
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td width="762" height="313" align="center" valign="top"><table width="71%"  border="1" cellpadding="3" cellspacing="0" class="TablaInterior">
        <tr>
          <td width="23%">Nodo</td>
          <td width="77%"><select name="Nodo" onChange="Proceso('R')">
            <option value="S">SELECCIONAR</option>
            <?
	$Consulta = "select * from proyecto_modernizacion.nodos where sistema='RAM' order by cod_nodo";
	$Resp = mysql_query($Consulta);
	while ($Fila = mysql_fetch_array($Resp))
	{
		if ($Nodo == $Fila["cod_nodo"])
			echo "<option selected value='".$Fila["cod_nodo"]."'>".str_pad($Fila["cod_nodo"],3,"0",str_pad_left)." - ".$Fila["descripcion"]."</option>";
		else
			echo "<option value='".$Fila["cod_nodo"]."'>".str_pad($Fila["cod_nodo"],3,"0",str_pad_left)." - ".$Fila["descripcion"]."</option>";
	}
?>
          </select></td>
        </tr>
        <tr>
          <td>Flujo</td>
          <td><select name="Flujo" onChange="Proceso('R')">
		  <option value="S">SELECCIONAR</option>
<?
	$Consulta = "select * from proyecto_modernizacion.flujos ";
	$Consulta.= " where nodo='".$Nodo."' and sistema='RAM' and esflujo<>'N' order by cod_flujo";
	$Resp = mysql_query($Consulta);
	while ($Fila = mysql_fetch_array($Resp))
	{
		if ($Flujo == $Fila["cod_flujo"])
			echo "<option selected value='".$Fila["cod_flujo"]."'>".str_pad($Fila["cod_flujo"],3,"0",str_pad_left)." - ".$Fila["descripcion"]."</option>";
		else
			echo "<option value='".$Fila["cod_flujo"]."'>".str_pad($Fila["cod_flujo"],3,"0",str_pad_left)." - ".$Fila["descripcion"]."</option>";
	}
?>		  
          </select></td>
        </tr>
        <tr>
          <td>Producto</td>
          <td><select name="Producto" onChange="Proceso('R')">
<option value="S">SELECCIONAR</option>
<?
	$Consulta = "select * from proyecto_modernizacion.productos order by descripcion";
	$Resp = mysql_query($Consulta);
	while ($Fila = mysql_fetch_array($Resp))
	{
		if ($Producto == $Fila["cod_producto"])
			echo "<option selected value='".$Fila["cod_producto"]."'>".$Fila["descripcion"]."</option>";
		else
			echo "<option value='".$Fila["cod_producto"]."'>".$Fila["descripcion"]."</option>";
	}
?>		  		  
          </select></td>
        </tr>
        <tr>
          <td>SubProducto</td>
          <td><select name="SubProducto" onChange="Proceso('R')">
<option value="S">SELECCIONAR</option>		  
		  <?
	$Consulta = "select * from proyecto_modernizacion.subproducto where cod_producto='".$Producto."' order by descripcion";
	$Resp = mysql_query($Consulta);
	while ($Fila = mysql_fetch_array($Resp))
	{
		if ($SubProducto == $Fila["cod_subproducto"])
			echo "<option selected value='".$Fila["cod_subproducto"]."'>".$Fila["descripcion"]."</option>";
		else
			echo "<option value='".$Fila["cod_subproducto"]."'>".$Fila["descripcion"]."</option>";
	}
?>	
          </select></td>
        </tr>
        <tr>
          <td>Proveedor</td>
          <td><select name="Rut">
		  <option value="99999999-9">USAR RUT = 99999999-9</option>
<?
	$Consulta = "select * from ram_web.proveedor order by nombre";	
	$Resp = mysql_query($Consulta);
	while ($Fila = mysql_fetch_array($Resp))
	{
		if ($Rut == $Fila["rut_proveedor"])
			echo "<option selected value='".$Fila["rut_proveedor"]."'>".$Fila["rut_proveedor"]." - ".$Fila["nombre"]."</option>";
		else
			echo "<option value='".$Fila["rut_proveedor"]."'>".$Fila["rut_proveedor"]." - ".$Fila["nombre"]."</option>";
	}
?>		  
          </select></td>
        </tr>
        <tr>
          <td>Cod. Existencia </td>
          <td><select name="Tipo" onChange="Proceso('R')">		
		  <option value="S">SELECCIONAR</option>		  
 <?
	$Consulta = "select * from ram_web.atributo_existencia order by cod_existencia";
	$Resp = mysql_query($Consulta);
	while ($Fila = mysql_fetch_array($Resp))
	{
		if ($Tipo == $Fila["cod_existencia"])
			echo "<option selected value='".$Fila["cod_existencia"]."'>".str_pad($Fila["cod_existencia"],2,"0",str_pad_left)." - ".$Fila["nombre_existencia"]."</option>";
		else
			echo "<option value='".$Fila["cod_existencia"]."'>".str_pad($Fila["cod_existencia"],2,"0",str_pad_left)." - ".$Fila["nombre_existencia"]."</option>";
	}
?>	  
          </select></td>
        </tr>
        <tr>
          <td>Destino</td>
          <td><select name="Destino" onChange="Proceso('R')">
           <option value="S">SELECCIONAR</option>		  
 <?
	$Consulta = "select * from ram_web.tipo_lugar order by cod_tipo_lugar";
	$Resp = mysql_query($Consulta);
	while ($Fila = mysql_fetch_array($Resp))
	{
		if ($Destino == $Fila["cod_tipo_lugar"])
			echo "<option selected value='".$Fila["cod_tipo_lugar"]."'>".str_pad($Fila["cod_tipo_lugar"],2,"0",str_pad_left)." - ".$Fila["descripcion_lugar"]."</option>";
		else
			echo "<option value='".$Fila["cod_tipo_lugar"]."'>".str_pad($Fila["cod_tipo_lugar"],2,"0",str_pad_left)." - ".$Fila["descripcion_lugar"]."</option>";
	}
?>	  
          </select></td>
        </tr>
        <tr align="center">
          <td colspan="2">              <input name="BtnGrabar" type="button" id="BtnGrabar" value="Grabar" style="width:70px " onClick="Proceso('G')">
              <input name="BtnEliminar" type="button" id="BtnEliminar" value="Eliminar" style="width:70px " onClick="Proceso('E')">
              <input name="BtnImprimir" type="button" id="BtnImprimir" value="Imprimir" style="width:70px " onClick="Proceso('I')">
              <input name="BtnExcel" type="button" id="BtnEliminar32" value="Excel" style="width:70px " onClick="Proceso('X')">
              <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')">              </td></tr>
      </table>        
      <br>
        <br>        
		<table width="750"  border="1" cellpadding="3" cellspacing="0" class="TablaDetalle">              
<?	
	$Consulta = "select distinct nodo ";
	$Consulta.= " from ram_web.flujo_rut ";
	if (isset($Nodo) && $Nodo!="S")
		$Consulta.= " where nodo='".$Nodo."'";
	$Consulta.= " order by nodo";	
	$Resp = mysql_query($Consulta);
	while ($Fila = mysql_fetch_array($Resp))
	{
		//NOMBRE FLUJO
		$Consulta = "select distinct descripcion from proyecto_modernizacion.nodos ";
		$Consulta.= " where cod_nodo='".$Fila["nodo"]."' and sistema='RAM'";	
		$Resp3 = mysql_query($Consulta);
		if ($Fila3 = mysql_fetch_array($Resp3))
			$NomNodo = $Fila3["descripcion"];
		else
			$NomNodo = "&nbsp;";
		echo "<tr class='ColorTabla01'><td colspan='12'>NODO:&nbsp;".$Fila["nodo"]." - ".$NomNodo."</td></tr>\n";
		echo "<tr class='ColorTabla01'>\n";
		echo "<td width='6%'>ELIM.</td>\n";
		echo "<td width='7%'>FLUJO</td>\n";
		echo "<td width='28%'>DESCRIPCION</td>\n";
		echo "<td width='7%'>PROD</td>\n";
		echo "<td width='10%'>SUBPROD</td>\n";
		echo "<td width='35%'>DESCRIPCION</td>\n";
		echo "<td width='35%'>RUT</td>\n";
		echo "<td width='35%'>PROVEEDOR</td>\n";
		echo "<td width='7%'>EXIST</td>\n";
		echo "<td width='7%'>DESCRIP</td>\n";
		echo "<td width='7%'>DESTINO</td>\n";
		echo "<td width='7%'>DESCRIP</td>\n";
		echo "</tr>\n";
		$Consulta = "select * ";
		$Consulta.= " from ram_web.flujo_rut ";
		$Consulta.= " where nodo='".$Fila["nodo"]."'";
		$Consulta.= " order by nodo, flujo, cod_producto, cod_subproducto";	
		$Resp2 = mysql_query($Consulta);
		while ($Fila2 = mysql_fetch_array($Resp2))
		{	
			//NOMBRE SUBPROD.
			$Consulta = "select * from proyecto_modernizacion.subproducto ";
			$Consulta.= " where cod_producto='".$Fila2["cod_producto"]."' and cod_subproducto='".$Fila2["cod_subproducto"]."'";	
			$Resp3 = mysql_query($Consulta);
			if ($Fila3 = mysql_fetch_array($Resp3))
				$NomSubProd = strtoupper($Fila3["descripcion"]);
			else
				$NomSubProd = "&nbsp;";
			//NOMBRE FLUJO
			$Consulta = "select distinct descripcion from proyecto_modernizacion.flujos ";
			$Consulta.= " where cod_flujo='".$Fila2["flujo"]."' and sistema='RAM'";	
			$Resp3 = mysql_query($Consulta);
			if ($Fila3 = mysql_fetch_array($Resp3))
				$NomFlujo = strtoupper($Fila3["descripcion"]);
			else
				$NomFlujo = "&nbsp;";
			echo "<tr>\n";
			$ValorRadio = $Fila2["cod_existencia"]."//".$Fila2["cod_producto"]."//".$Fila2["cod_subproducto"]."//".$Fila2["rut"]."//".$Fila2["destino"]."//".$Fila2["flujo"]."//".$Fila["nodo"];
			echo "<td><input name='ChkFlujo' type='radio' value='".$ValorRadio."'></td>\n";
			echo "<td>".$Fila2["flujo"]."</td>\n";
			echo "<td>".$NomFlujo."</td>\n";
			echo "<td>".$Fila2["cod_producto"]."</td>\n";
			echo "<td>".$Fila2["cod_subproducto"]."</td>\n";
			echo "<td>".$NomSubProd."</td>\n";
			//PROVEEDOR
			$Consulta = "select * from ram_web.proveedor ";
			$Consulta.= " where rut_proveedor= '".$Fila2["rut"]."'";	
			$Resp3 = mysql_query($Consulta);
			if ($Fila3 = mysql_fetch_array($Resp3))
				$NomProveedor = $Fila3["nombre"];
			else
				$NomProveedor = "&nbsp;";
			echo "<td>".$Fila2["rut"]."</td>\n";
			echo "<td>".$NomProveedor."</td>\n";
			//EXISTENCIA			
			$Consulta = "select * from ram_web.atributo_existencia ";
			$Consulta.= " where cod_existencia= '".$Fila2["cod_existencia"]."'";	
			$Resp3 = mysql_query($Consulta);
			if ($Fila3 = mysql_fetch_array($Resp3))
				$NomExist = $Fila3["nombre_existencia"];
			else
				$NomExist = "&nbsp;";
			echo "<td>".$Fila2["cod_existencia"]."</td>\n";
			echo "<td>".$NomExist."</td>\n";
			//LUGAR DESTINO
			$Consulta = "select * from ram_web.tipo_lugar ";
			$Consulta.= " where cod_tipo_lugar = '".$Fila2["destino"]."'";	
			$Resp3 = mysql_query($Consulta);
			if ($Fila3 = mysql_fetch_array($Resp3))
				$NomDestino = $Fila3["descripcion_lugar"];
			else
				$NomDestino = "&nbsp;";
			echo "<td>".$Fila2["destino"]."</td>\n";
			echo "<td>".$NomDestino."</td>\n";
			echo "</tr>\n";
		}
	}
?>		
      </table>
	  
      </td>
    </tr>
</table>
<? include ("../principal/pie_pagina.php") ?>   
</form>
</body>
</html>
