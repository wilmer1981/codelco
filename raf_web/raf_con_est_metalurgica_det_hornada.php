<? include("../principal/conectar_principal.php");?>
<html>
<head>
<title>Sistema RAF</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
-->
</style></head>

<body>
<table width="350"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
  <tr class="ColorTabla01">
    <td colspan="6"><strong>Detalle Hornada: <? echo substr($Hornada,-4)?></strong></td>
  </tr>
  <tr align="center" class="ColorTabla02">
    <td colspan="6"><strong>CARGA</strong></td>
  </tr>
  <tr align="center" class="ColorTabla02">
    <td width="16%"><strong>Hornada</strong></td>
    <td width="13%"><strong>Fecha</strong></td>
    <td width="16%"><strong>H.Ini</strong></td>
    <td width="14%"><strong>H.Fin</strong></td>
    <td width="14%"><strong>Ollas</strong></td>
    <td width="27%"><strong>Origen</strong></td>
  </tr>
<?  
	$OllasCarga=0;
	$Consulta = "select hornada, campo1, fecha_ini, hora_ini, hora_ter, (campo2 * 1) as ollas, campo3 ";
	$Consulta.= " from raf_web.datos_operacionales ";
	$Consulta.= " where hornada='".$Hornada."'";
	$Consulta.= " and tipo_report='1'";
	$Consulta.= " and seccion_report='1'";
	$Consulta.= " and (ISNULL(campo4) or campo4<>'S' or campo4='')"; 
	$Consulta.= " and campo1 <> ''";
	$Consulta.= " order by campo1, fecha_ini, hora_ini ";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysql_fetch_array($Resp))
	{
		echo "<tr>\n";
		echo "<td align='center'>".substr($Fila["hornada"],-4)."-".$Fila["campo1"]."</td>\n";
		echo "<td align='center'>".substr($Fila["fecha_ini"],8,2)."/".substr($Fila["fecha_ini"],5,2)."</td>\n";
		echo "<td align='center'>".substr($Fila["hora_ini"],0,5)."</td>\n";
		echo "<td align='center'>".substr($Fila["hora_ter"],0,5)."</td>\n";
		echo "<td align='right'>".number_format($Fila["ollas"],2,",",".")."</td>\n";
		echo "<td align='center'>".$Fila["campo3"]."</td>\n";
		echo "</tr>\n";
		$OllasCarga = $OllasCarga + ($Fila["ollas"]*1);
	}
?>  
  <tr class="ColorTabla02">
    <td colspan="4"><strong>CARGA </strong></td>
    <td align="right"><? echo number_format($OllasCarga,2,",","."); ?></td>
    <td align="right"><? echo number_format(($OllasCarga*30000),0,",","."); ?></td>
  </tr>
</table>

<br>
<table width="350"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
  <tr align="center" class="ColorTabla02">
    <td colspan="6"><strong>TRAVASE</strong></td>
  </tr>
  <tr align="center" class="ColorTabla02">
    <td width="16%"><strong>Hornada</strong></td>
    <td width="13%"><strong>Fecha</strong></td>
    <td width="16%"><strong>H.Ini</strong></td>
    <td width="14%"><strong>H.Fin</strong></td>
    <td width="14%"><strong>Ollas</strong></td>
    <td width="27%"><strong>Destino</strong></td>
  </tr>
  <?
  	$OllasTrasvase = 0;  
	$Consulta = "select hornada, campo1, fecha_ini, hora_ini, hora_ter, (campo2 * 1) as ollas, campo3 ";
	$Consulta.= " from raf_web.datos_operacionales ";
	$Consulta.= " where hornada='".$Hornada."'";
	$Consulta.= " and tipo_report='1'";
	$Consulta.= " and seccion_report='6'";
	$Consulta.= " and (ISNULL(campo4) or campo4<>'S' or campo4='')"; 
	$Consulta.= " and campo1 <> ''";
	$Consulta.= " order by campo1, fecha_ini, hora_ini ";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysql_fetch_array($Resp))
	{
		echo "<tr>\n";
		echo "<td align='center'>".substr($Fila["hornada"],-4)."-".$Fila["campo1"]."</td>\n";
		echo "<td align='center'>".substr($Fila["fecha_ini"],8,2)."/".substr($Fila["fecha_ini"],5,2)."</td>\n";
		echo "<td align='center'>".substr($Fila["hora_ini"],0,5)."</td>\n";
		echo "<td align='center'>".substr($Fila["hora_ter"],0,5)."</td>\n";
		echo "<td align='right'>".number_format($Fila["ollas"],2,",",".")."</td>\n";
		echo "<td align='center'>".$Fila["campo3"]."</td>\n";
		echo "</tr>\n";
		$OllasTrasvase = $OllasTrasvase + ($Fila["ollas"]*1);
	}
?>
  <tr class="ColorTabla02">
    <td colspan="4"><strong>TRASVASE </strong></td>
    <td align="right"><? echo number_format($OllasTrasvase,2,",","."); ?></td>
    <td align="right"><? echo number_format(($OllasTrasvase*30000),0,",","."); ?></td>
  </tr>
</table>
<br>
<table width="350"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
  <tr class="ColorTabla02">
    <td><strong>TOTAL CARGA:&nbsp;<? echo number_format($OllasCarga - $OllasTrasvase,2,",","."); ?></strong>&nbsp;Ollas
	Con un Peso de&nbsp;<strong><? echo number_format((($OllasCarga - $OllasTrasvase)*30000),0,",","."); ?></strong>&nbsp;kg</td>
  </tr>
</table>
</body>
</html>
