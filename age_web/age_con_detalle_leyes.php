<?php
	include("../principal/conectar_principal.php");
	$Consulta = "select t1.nro_solicitud, t1.recargo, t1.id_muestra, t1.cod_producto, t1.cod_subproducto, ";
	$Consulta.= " t2.descripcion as nom_prod, t3.descripcion as nom_subprod ";
	$Consulta.= " from cal_web.solicitud_analisis t1 inner join proyecto_modernizacion.productos t2 ";
	$Consulta.= " on t1.cod_producto=t2.cod_producto inner join proyecto_modernizacion.subproducto t3 ";
	$Consulta.= " on t1.cod_producto=t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto ";
	$Consulta.= " where nro_solicitud='".$SA."'";
	$Consulta.= " and recargo='".$Recargo."'";
	$Resp=mysqli_query($link, $Consulta);
	if ($Fila=mysqli_fetch_array($Resp))
	{
		$IdMuestra=$Fila["id_muestra"];
		$NomProducto=$Fila["cod_producto"]." - ".$Fila["nom_prod"];
		$NomSubProducto=$Fila["cod_subproducto"]." - ".$Fila["nom_subprod"];
	}
?>
<html>
<head>
<title>Detalle Leyes</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
-->
</style></head>

<body>
<table width="330" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#666666" class="TablaDetalle">
  <tr align="center">
    <td colspan="4" class="ColorTabla01">DETALLE ANALISIS DE SOLICITUDES </td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td colspan="4" class="Detalle01">&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td width="73">Nro Solicitud : </td>
    <td width="106"><?php echo $SA; ?></td>
    <td width="56">Recargo:</td>
    <td width="71"><?php
	if ($Recargo!="")
		echo $Recargo;
	else
		echo "0";	
	?></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td>Id_Muestra:</td>
    <td colspan="3"><?php echo $IdMuestra; ?></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td>Producto:</td>
    <td colspan="3"><?php echo strtoupper($NomProducto); ?></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td>SubProducto:</td>
    <td colspan="3"><?php echo strtoupper($NomSubProducto); ?></td>
  </tr>
  <tr align="center" bgcolor="#FFFFFF">
    <td colspan="4" class="Detalle02"><input name="BtnImprimir" type="button" id="BtnImprimir" value="Imprimir" style="width:70px " onClick="window.print();">
    <input name="BtnCerrar" type="button" id="BtnCerrar" value="Cerrar" style="width:70px " onClick="window.close();"></td>
  </tr>
</table>
  <br>
  <table width="300" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#666666" class="TablaDetalle">
  <tr align="center" class="ColorTabla01">
    <td width="74">Ley</td>
    <td width="70">Valor</td>
    <td width="64">Unidad</td>
    <td width="68">Candado</td>
  </tr>
<?php  
	$Consulta = "select t1.cod_leyes, t1.cod_unidad, t1.valor, t2.abreviatura, t3.abreviatura as nom_unidad, t1.candado ";
	$Consulta.= " from cal_web.leyes_por_solicitud t1 inner join proyecto_modernizacion.leyes t2 on t1.cod_leyes=t2.cod_leyes ";
	$Consulta.= " inner join proyecto_modernizacion.unidades t3 on t1.cod_unidad=t3.cod_unidad ";
	$Consulta.= " where t1.nro_solicitud='".$SA."'";
	$Consulta.= " and t1.recargo='".$Recargo."'";
	$Consulta.= " order by t1.cod_leyes";
	$Resp=mysqli_query($link, $Consulta);
	//echo $Consulta;
	while ($Fila=mysqli_fetch_array($Resp))
	{
		if ($Fila["candado"]!="1")
			echo "<tr bgcolor='YELLOW'>\n";
		else
			echo "<tr bgcolor='white'>\n";
		if ($Fila["abreviatura"]=="")
			echo "<td>&nbsp;</td>\n";
		else
			echo "<td align=\"center\">".$Fila["abreviatura"]."</td>\n";
		if ($Fila["valor"]!="")
			echo "<td align=\"right\">".$Fila["valor"]."</td>\n";
		else
			echo "<td >&nbsp;</td>\n";
		if ($Fila["cod_unidad"]!="")
			echo "<td align=\"center\">".$Fila["nom_unidad"]."</td>\n";
		else
			echo "<td align=\"center\">&nbsp;</td>\n";
		echo "<td align=\"center\">";
		if ($Fila["candado"]!="1")
			echo "<img src=\"../principal/imagenes/cand_abierto.gif\">";
		else
			echo "<img src=\"../principal/imagenes/cand_cerrado.gif\">";
		echo "</td>\n";
		echo "</tr>\n";
	}
?>  
</table>
</body>
</html>
