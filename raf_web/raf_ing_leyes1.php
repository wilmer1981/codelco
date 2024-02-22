<?
	$CodigoDeSistema = 5;
	$CodigoDePantalla = 3;
	include("file://///S-WEB/proyecto/principal/conectar_principal.php");
?>	
<html>
<head>
<title>Sistema de RAM</title>
<link href="file://///S-WEB/proyecto/principal/estilos/css_imp_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
<!--
function Proceso(opt)
{
	var f=document.frmPrincipal;
	switch (opt)
	{
		case "G": // GRABA o MODIFICA
			if (f.Productos.value == "S")
			{
				alert("Debe seleccionar Producto");
				f.Productos.focus();
				return;
			}
			if (f.SubProductos.value == "S")
			{
				alert("Debe seleccionar Sub-Producto");
				f.SubProductos.focus();
				return;
			}
			if (f.Conjunto.value == "S")
			{
				alert("Debe seleccionar Conjunto");
				f.Conjunto.focus();
				return;
			}
			f.action = "ram_ing_leyes_esp01.php?Proceso=G";
			f.submit();
			break;
		case "E": // ELIMINAR
			if (f.Productos.value == "S")
			{
				alert("Debe seleccionar Producto");
				f.Productos.focus();
				return;
			}
			if (f.SubProductos.value == "S")
			{
				alert("Debe seleccionar Sub-Producto");
				f.SubProductos.focus();
				return;
			}
			if (f.Conjunto.value == "S")
			{
				alert("Debe seleccionar Conjunto");
				f.Conjunto.focus();
				return;
			}
			f.action = "ram_ing_leyes_esp01.php?Proceso=E";
			f.submit();
			break;
		case "R": //RECARGA PAGINA			
			f.action = "ram_ing_leyes_esp.php?";
			f.submit();
			break;
		case "S":  //SALIR
			f.action = "../principal/sistemas_usuario.php?CodSistema=7";
			f.submit();
			break;
		case "C":
			var URL = "ram_con_leyes_especiales.php";
			window.open(URL,"","top=35,left=10,width=750,height=460,scrollbars=yes,resizable = YES");
			break;			 			 			
	}
}
//-->
</script>
<body leftmargin="3" topmargin="2" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
<? 
	include("file://///S-WEB/proyecto/principal/encabezado.php");
?>
  <table width="770" border="0" cellspacing="0" cellpadding="5" class="TablaPrincipal">
    <tr>
      <td height="380" align="center" valign="top"> 
        <table width="650" height="49" border="0" cellpadding="1" cellspacing="1" class="TablaInterior">
          <tr> 
            <td width="15" height="23" align="right"><img src="file://///S-WEB/proyecto/principal/imagenes/left-flecha.gif" width="11" height="11"> 
            </td>
            <td width="55">Producto</td>
            <td width="371"><select name="Productos" style="width:350" onChange="Proceso('R');">
                <option selected value="S">Seleccionar</option>
                <?
	$Consulta = "select * from proyecto_modernizacion.productos order by descripcion";
	$result = mysql_query($Consulta);
	while ($Row = mysql_fetch_array($result))
	{
		if ($Productos == $Row["cod_producto"])
		{
			echo "<option selected value='".$Row["cod_producto"]."'>".$Row["cod_producto"]."&nbsp;-&nbsp;".ucwords(strtolower($Row["descripcion"]))."</option>\n";
		}
		else
		{
			echo "<option value='".$Row["cod_producto"]."'>".$Row["cod_producto"]."&nbsp;-&nbsp;".ucwords(strtolower($Row["descripcion"]))."</option>\n";
		}
	}
?>
              </select> </td>
            <td width="222" align="center" valign="middle"><input type="button" name="BtnGrabar" value="Grabar" onClick="Proceso('G');" style="width:70px"> 
              <input name="BtnEliminar" type="button" id="BtnEliminar" style="width:70px" onClick="Proceso('E');" value="Eliminar"></td>
          </tr>
          <tr> 
            <td height="23" align="right"><img src="file://///S-WEB/proyecto/principal/imagenes/left-flecha.gif" width="11" height="11"></td>
            <td>SubProducto</td>
            <td><select name="SubProductos" style="width:350" onChange="Proceso('R');">
                <option selected value="S">Seleccionar</option>
                <?
	$Consulta = "select * from proyecto_modernizacion.subproducto where cod_producto = '".$Productos."' order by descripcion";
	$result = mysql_query($Consulta);
	while ($Row = mysql_fetch_array($result))
	{
		if ($SubProductos == $Row[cod_subproducto])
		{
			echo "<option selected value='".$Row[cod_subproducto]."'>".$Row[cod_subproducto]."&nbsp;-&nbsp;".ucwords(strtolower($Row["descripcion"]))."</option>\n";
		}
		else
		{
			echo "<option value='".$Row[cod_subproducto]."'>".$Row[cod_subproducto]."&nbsp;-&nbsp;".ucwords(strtolower($Row["descripcion"]))."</option>\n";
		}
	}
?>
              </select></td>
            <td align="center" valign="middle"><input name="BtnConsultar" type="button" id="BtnConsultar" style="width:70px" onClick="Proceso('C');" value="Consultar"> 
              <input type="button" name="BtnSalir" value="Salir" onClick="Proceso('S');" style="width:70px"></td>
          </tr>
        </table>
        <br>       
        <table width="288" height="342" border="0" cellpadding="3" cellspacing="0" Class="TablaDetalle">
          <tr align="center" valign="middle" class="ColorTabla01"> 
            <td width="59" height="18"><strong>Ley</strong></td>
            <td width="181"><strong>Valor</strong></td>
            <td width="181">Unid.</td>
          </tr>
          <tr align="center" valign="middle">
            <td height="18">H2O</td>
            <td><input type="text" name="H2O" value="<? echo $H2O; ?>"></td>
            <td>%</td>
          </tr>
          <tr align="center" valign="middle"> 
            <td height="18">Cu</td>
            <td><input type="text" name="Cu" value="<? echo $Cu; ?>"></td>
            <td>%</td>
          </tr>
          <tr align="center" valign="middle"> 
            <td height="18">Ag</td>
            <td><input type="text" name="Ag" value="<? echo $Ag; ?>"></td>
            <td>%</td>
          </tr>
          <tr align="center" valign="middle"> 
            <td height="18">Au</td>
            <td><input type="text" name="Au" value="<? echo $Au; ?>"></td>
            <td>%</td>
          </tr>
          <tr align="center" valign="middle"> 
            <td height="18">As</td>
            <td><input type="text" name="As" value="<? echo $As; ?>"></td>
            <td>ppm</td>
          </tr>
          <tr align="center" valign="middle"> 
            <td height="18">S</td>
            <td><input type="text" name="S" value="<? echo $S; ?>"></td>
            <td>ppm</td>
          </tr>
          <tr align="center" valign="middle"> 
            <td height="18">Pb</td>
            <td><input type="text" name="Pb" value="<? echo $Pb; ?>"></td>
            <td>ppm</td>
          </tr>
          <tr align="center" valign="middle"> 
            <td height="18">Fe</td>
            <td><input type="text" name="Fe" value="<? echo $Fe; ?>"></td>
            <td>ppm</td>
          </tr>
          <tr align="center" valign="middle"> 
            <td height="18">Si</td>
            <td><input type="text" name="Si" value="<? echo $Si; ?>"></td>
            <td>ppm</td>
          </tr>
          <tr align="center" valign="middle"> 
            <td height="18">CaO</td>
            <td><input type="text" name="CaO" value="<? echo $CaO; ?>"></td>
            <td>ppm</td>
          </tr>
          <tr align="center" valign="middle"> 
            <td height="18">Al2O3</td>
            <td><input type="text" name="AL2O3" value="<? echo $AL2O3; ?>"></td>
            <td>ppm</td>
          </tr>
          <tr align="center" valign="middle"> 
            <td height="18">MgO</td>
            <td><input type="text" name="MgO" value="<? echo $MgO; ?>"></td>
            <td>ppm</td>
          </tr>
          <tr align="center" valign="middle"> 
            <td height="18">Sb</td>
            <td><input type="text" name="Sb" value="<? echo $Sb; ?>"></td>
            <td>ppm</td>
          </tr>
          <tr align="center" valign="middle"> 
            <td height="18">Cd</td>
            <td><input type="text" name="Cd" value="<? echo $Cd; ?>"></td>
            <td>ppm</td>
          </tr>
          <tr align="center" valign="middle"> 
            <td height="18">Hg</td>
            <td><input type="text" name="Hg" value="<? echo $Hg; ?>"></td>
            <td>ppm</td>
          </tr>
          <tr align="center" valign="middle"> 
            <td height="18">Te</td>
            <td><input type="text" name="Te" value="<? echo $Te; ?>"></td>
            <td>ppm</td>
          </tr>
          <tr align="center" valign="middle"> 
            <td height="18">Zn</td>
            <td><input type="text" name="Zn" value="<? echo $Zn; ?>"></td>
            <td>ppm</td>
          </tr>
          <tr align="center" valign="middle"> 
            <td height="18">Fe3O4</td>
            <td><input type="text" name="Fe3O4" value="<? echo $Fe3O4; ?>"></td>
            <td>ppm</td>
          </tr>
        </table> 
        <br>
      </td>
    </tr>
  </table>

<? include("file://///S-WEB/proyecto/principal/pie_pagina.php");?>
</form>
</body>
</html>
