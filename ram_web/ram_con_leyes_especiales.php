<?php
	include("../principal/conectar_principal.php");
?>	
<html>
<head>
<title>Sistema de RAM</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body background="../Principal/imagenes/fondo3.gif">
<table width="900" border="1" cellpadding="2" cellspacing="0" class="TablaDetalle">
  <tr class="ColorTabla01">
    <td>PRODUCTO</td>
    <td>SUBPRODUCTO</td>
    <td>COD CNJTO</td>
    <td>CONJUNTO</td>
	<td>FECHA</td>
    <td>TIPO LEY</td>
    <td>H2O</td>
    <td>Cu</td>
    <td>Ag</td>
    <td>Au</td>
    <td>As</td>
    <td>S</td>
    <td>Pb</td>
    <td>Fe</td>
    <td>Si</td>
    <td>CaO</td>
    <td>Al2O3</td>
    <td>MgO</td>
    <td>Sb</td>
    <td>Cd</td>
    <td>Hg</td>
    <td>Te</td>
    <td>Zn</td>
    <td>Fe3O4</td>
  </tr>
<?php
	$Consulta = "select * from ram_web.leyes_especiales ";
	$Consulta.= " order by cod_producto, cod_subproducto, cod_conjunto, num_conjunto, tipo_ley";
	$Respuesta = mysqli_query($link,$Consulta);
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		$Consulta = "select * from proyecto_modernizacion.productos where cod_producto = '".$Fila["cod_producto"]."'";
		$Respuesta2 = mysqli_query($link,$Consulta);
		if ($Fila2 = mysqli_fetch_array($Respuesta2))
			$Producto = $Fila2["descripcion"];
		else
			$Producto = "";
		$Consulta = "select * from proyecto_modernizacion.subproducto ";
		$Consulta.= " where cod_producto = '".$Fila["cod_producto"]."' and cod_subproducto = '".$Fila["cod_subproducto"]."'";
		$Respuesta2 = mysqli_query($link,$Consulta);
		if ($Fila2 = mysqli_fetch_array($Respuesta2))
			$SubProducto = $Fila2["descripcion"];
		else
			$SubProducto = "";
		echo "<tr>\n";
		echo "<td>".$Producto."</td>\n";
		echo "<td>".$SubProducto."</td>\n";
		echo "<td>".$Fila["cod_conjunto"]."</td>\n";
		echo "<td>".$Fila["num_conjunto"]."</td>\n";
		echo "<td>".substr($Fila["fecha"],5,2)."/".substr($Fila["fecha"],0,4)."</td>\n";
		if ($Fila["tipo_ley"] == "S")
			$TipoLey = "STOCK INICIAL";
		else
			$TipoLey = "OPERACIONAL";
		echo "<td>".$TipoLey."</td>\n";
		echo "<td>".$Fila["v_h2o"]."</td>\n";
		echo "<td>".$Fila["v_cu"]."</td>\n";
		echo "<td>".$Fila["v_ag"]."</td>\n";
		echo "<td>".$Fila["v_au"]."</td>\n";
		echo "<td>".$Fila["v_as"]."</td>\n";
		echo "<td>".$Fila["v_s"]."</td>\n";
		echo "<td>".$Fila["v_pb"]."</td>\n";
		echo "<td>".$Fila["v_fe"]."</td>\n";
		echo "<td>".$Fila["v_si"]."</td>\n";
		echo "<td>".$Fila["v_cao"]."</td>\n";
		echo "<td>".$Fila["v_al2o3"]."</td>\n";
		echo "<td>".$Fila["v_mgo"]."</td>\n";
		echo "<td>".$Fila["v_sb"]."</td>\n";
		echo "<td>".$Fila["v_cd"]."</td>\n";
		echo "<td>".$Fila["v_hg"]."</td>\n";
		echo "<td>".$Fila["v_te"]."</td>\n";
		echo "<td>".$Fila["v_zn"]."</td>\n";
		echo "<td>".$Fila["v_fe3o4"]."</td>\n";
		echo "</tr>\n";
	}
?>  
</table>
<div align="center"><br>
  <br>
  <input name="btnCerrar" type="button" id="btnCerrar" value="Cerrar" onClick="window.close()">
</div>
</body>
</html>
