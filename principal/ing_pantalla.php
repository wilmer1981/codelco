<?php
include("conectar_principal.php");

$CodigoDeSistema = 99;
$CodigoDePantalla = 3;

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
if(isset($_GET["Orden"])){
	$Orden = $_GET["Orden"];
}else{
	$Orden = "";
}
			
?>
<html>
<head>
<title>Administrador de Sistema</title>
<link href="estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/funciones_java.js"></script>
<script language="javascript">
function Proceso(opt,valor)
{
	var f = frmPrincipal;
	var Valores = "";
	switch (opt)
	{
		case "N":
		    if (f.Sistema.value=="S")
			{
				alert("Debe Seleccionar Sistema");
				f.Sistema.focus();
				return;				
			}
			window.open("ing_pantalla02.php?Proceso=N&Sistema=" + f.Sistema.value,"","top=130,left=50,width=650,height=300,scrollbars=yes,resizable = yes");							
			break;			
		case "E":
			for (i = 0; i < f.elements.length; i++)
			{
				if ((f.elements[i].name == "ChkPantalla") && (f.elements[i].checked == true))
				{
					Valores = Valores + f.elements[i].value + "/";
				}
			}
			if (Valores=="")
			{
				alert("No hay ninguna Pantalla Seleccionada para Eliminar");
				return;
			}
			else
			{
				var msg=confirm("¿Seguro que desea Eliminar Estas Pantallas?");
				if (msg==true)
				{
					//var Largo = Valores.length;
					//Valores = Valores.substring(0,Largo-1);				
					f.action = "ing_pantalla01.php?Proceso=E&Valores=" + Valores;
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
				if ((f.elements[i].name == "ChkPantalla") && (f.elements[i].checked == true))
				{
					Valores = Valores + f.elements[i].value;
					break;
				}
			}
			if (Valores=="")
			{
				alert("No hay ninguna Pantalla Seleccionada para Modificar");
				return;
			}
			else
			{		
				window.open("ing_pantalla02.php?Proceso=M&Sistema=" + f.Sistema.value + "&CodPantalla=" + Valores,"","top=130,left=50,width=650,height=300,scrollbars=yes,resizable = yes");							
			}
			break;
		case "AS": //ASIGNA NIVELES
			for (i = 0; i < f.elements.length; i++)
			{
				if ((f.elements[i].name == "ChkPantalla") && (f.elements[i].checked == true))
				{
					Valores = Valores + f.elements[i].value;
					break;
				}
			}
			if (Valores=="")
			{
				alert("No hay ninguna Pantalla Seleccionada para Asignar Niveles");
				return;
			}
			else
			{		
				var URL = "seg_pagina.php?CodSistema=" + f.Sistema.value + "&CodPantalla=" + Valores;
				window.open(URL,"","top=30,left=30,width=700,height=400,menubar=no,resizable=yes,scrollbars=yes")				
			}
			break;
		case "I":
			window.print();
			break;
		case "S":
			f.action = "sistemas_usuario.php?CodSistema=99&Nivel=0";
			f.submit();
			break;
		case "O":
			f.action = "ing_pantalla.php?Orden=" + valor;
			f.submit();
			break;
		case "R":			
			f.action = "ing_pantalla.php?Sistema=" + f.Sistema.value;
			f.submit();
			break;
	}
}

</script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">

body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}

</style></head>

<body>
<form name="frmPrincipal" action="" method="post">
<?php include("encabezado.php"); ?>
  <table width="770" height="330" border="0" cellpadding="0" cellspacing="0" class="TablaPrincipal">

    <tr> 
      <td height="470" align="center" valign="top"> 
        <br>
        <table width="550" height="60" border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="57" height="30">Sistema:</td>
            <td width="578"><select name="Sistema" style="width:300" onChange="Proceso('R');">
                <option value="S">Seleccionar</option>
                <?php
			$sql = "select * from sistemas order by cod_sistema";
			$result = mysqli_query($link, $sql);
			while ($row = mysqli_fetch_array($result))
			{
				if ($Sistema == $row["cod_sistema"])
				{
					echo "<option value='".$row["cod_sistema"]."' selected>".strtoupper($row["nombre"])." - ".ucwords(strtolower($row["descripcion"]))."</option>\n";
				}
				else
				{
					echo "<option value='".$row["cod_sistema"]."'>".strtoupper($row["nombre"])." - ".ucwords(strtolower($row["descripcion"]))."</option>\n";
				}
			}
		?>
              </select>              </td>
          </tr>
          <tr align="center">
            <td colspan="2"><input name="BtnNuevo" type="button" id="BtnNuevo" style="width:70px" onClick="JavaScript:Proceso('N')" value="Nuevo";>			
              <input name="BtnModificar" type="button" id="BtnModificar" style="width:70px" onClick="JavaScript:Proceso('M');" value="Modificar">
              <input name="BtnAsigna" type="button" id="BtnAsigna" style="width:100px" onClick="JavaScript:Proceso('AS');" value="Asigna Niveles">
              <input name="BtnEliminar" type="button" id="BtnEliminar" style="width:70px" onClick="JavaScript:Proceso('E');" value="Eliminar">
            <input name="btnSalir" type="button" value="Salir" style="width:70px" onClick="JavaScript:Proceso('S');"></td>
          </tr>
        </table>
        <br>
		<div style="position:absolute; left: 90px; top: 125px; overflow: auto; width: 606px; height: 380px;"> 
          <table width="550" height="21" border="1" cellpadding="1" cellspacing="0" class="TablaDetalle">
          <tr class="ColorTabla01"> 
			<td width="43"><strong>Selec.</strong></td>
			<td width="30"><a href="JavaScript:Proceso('O','C');" class="LinkBlanco"><strong>Cod</strong></a></td>
			<td width="35"><a href="JavaScript:Proceso('O','T');" class="LinkBlanco"><strong>Tipo</strong></a></td>
			<td width="321"><a href="JavaScript:Proceso('O','D');" class="LinkBlanco"><strong>Descrip/T&iacute;tulo</strong></a></td>            
			<td width="43"><a href="JavaScript:Proceso('O','O');" class="LinkBlanco"><strong>Orden</strong></a></td>
			<!--<td width="200" align="center"><strong>Niveles Asociados</strong></td>-->
			<td width="51" align="center"><a href="JavaScript:Proceso('O','E');" class="LinkBlanco"><strong>Estado</strong></a></td>
          </tr>
<?php	
if ((isset($Sistema)) && ($Sistema != "S"))	  
{
	$Consulta = "select * from proyecto_modernizacion.pantallas ";
	$Consulta.= " where cod_sistema = '".$Sistema."'";
	switch ($Orden)
	{
		case "C":
			$Consulta.= " order by cod_pantalla ";
			break;
		case "T":
			$Consulta.= " order by tipo";
			break;
		case "D":
			$Consulta.= " order by descripcion";
			break;
		case "O":
			$Consulta.= " order by orden";
			break;
		case "E":
			$Consulta.= " order by estado";
			break;
		default:
			$Consulta.= " order by orden";
			break;
	}		
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{
		echo "<tr onMouseOver=\"CCA(this,'CL01')\" onMouseOut=\"CCA(this,'CL02')\">\n";
		echo "<td align='center'><input type='checkbox' name='ChkPantalla' value='".$Fila["cod_pantalla"]."' onClick=\"CCA(this,'CL03')\"></td>\n";
		echo "<td align='center'>".$Fila["cod_pantalla"]."</td>\n";			
		echo "<td align='center'>";
		switch ($Fila["tipo"])
		{
			case "0":
				echo "<img src='imagenes/img_no.gif'>\n";
				break;
			case "1":
				echo "<img src='imagenes/img_ingreso.gif' width='16' height='16'>\n";
				break;
			case "2":
				echo "<img src='imagenes/img_listado.gif'>\n";
				break;
			case "3":
				echo "<img src='imagenes/ico_carpeta.gif'>\n";
				break;
		}
		echo "</td>\n";
		echo "<td>".ucwords(strtolower($Fila["descripcion"]))."&nbsp;</td>\n";			
		echo "<td align='center'>".$Fila["orden"]."&nbsp;</td>\n";
		echo "<td align='center'>";
		switch ($Fila["estado"])
		{
			case "L":
				echo "<img src='imagenes/ico_ok.gif'>\n";
				break;
			case "N":
				echo "<img src='imagenes/img_no.gif'>\n";
				break;
			case "T":
				echo "<img src='imagenes/img_trabajo.gif'>\n";
				break;
		}
		echo "</td>\n";
		echo "</tr>\n";
	}
}
?>
        </table></div>      </td>
    </tr>
  </table>
<?php include("pie_pagina.php");?>
</form>
</body>
</html>
