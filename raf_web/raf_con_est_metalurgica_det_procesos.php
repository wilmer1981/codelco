<? 
	include("../principal/conectar_principal.php");
	$ArrayProcesos =array ("No Ident.","Escoreo","Oxidacion","Reducc. Q","Reducc. T","Moldeo"); 
?>
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
    <td colspan="6"><strong>PROCESOS</strong></td>
  </tr>
  <tr align="center" class="ColorTabla02">
    <td width="14%"><strong>Hornada</strong></td>
    <td width="42%"><strong>Proceso</strong></td>
    <td width="12%"><strong>Fecha</strong></td>
    <td width="10%"><strong>H.Ini</strong></td>
    <td width="10%"><strong>H.Fin</strong></td>
    <td width="12%"><strong>Tiempo</strong></td>
  </tr>
<?  
	$TiempoTotal = 0;
	//CARGA FUSION
	$AcumHora=0;
	$AcumMin=0;
	$TimeCarga = 0;
	$FH_IniCarga = "";
	$FH_FinCarga = "";
	$Consulta = "select distinct hornada, campo1 from raf_web.datos_operacionales ";
	$Consulta.= " where hornada = '".$Hornada."'";
	$Consulta.= " order by hornada, campo1";
	$RespAux = mysql_query($Consulta);
	while ($FilaAux = mysql_fetch_array($RespAux))
	{
		$Consulta = "SELECT * FROM raf_web.datos_operacionales ";
		$Consulta.= " WHERE tipo_report = 1 AND seccion_report = 1";
		$Consulta.= " AND hornada = '".$FilaAux["hornada"]."'";
		$Consulta.= " AND campo1 = '".$FilaAux["campo1"]."'"; 
		$Consulta.= " and tipo_report='1' and seccion_report='1' ";
		$Consulta.= " and (ISNULL(campo4) or campo4<>'S' or campo4='')"; 
		$Consulta.= " and campo1 <> ''";
		$Consulta.= " order by fecha_ini, hora_ini, hora_ter ";
		$Resp2 = mysql_query($Consulta);
		while ($Fila2 = mysql_fetch_array($Resp2))
		{
			$Tiempo = 0;
			$Hora = 0;
			$Min = 0;
			$FechaIniAux = $Fila2["fecha_ini"];
			if (substr($Fila2["hora_ter"],0,2) < substr($Fila2["hora_ini"],0,2))
				$FechaFinAux = date("Y-m-d", mktime(0,0,0,substr($Fila2["fecha_ini"],5,2),intval(substr($Fila2["fecha_ini"],8,2))+1,substr($Fila2["fecha_ini"],0,4)));
			else
				$FechaFinAux = $Fila2["fecha_ini"];
			$FH_IniCarga = $Fila2["fecha_ini"]." ".$Fila2["hora_ini"];
			$FH_FinCarga = $FechaFinAux." ".$Fila2["hora_ter"];
			$Consulta = "select TIMEDIFF('".$FH_FinCarga."', '".$FH_IniCarga."') as diferencia ";				
			$Resp3 = mysql_query($Consulta);
			if ($Fila3 = mysql_fetch_array($Resp3))
			{				
				$Hora = intval(substr($Fila3["diferencia"],0,2));
				$Min = (intval(substr($Fila3["diferencia"],3,2)) / 60);
			}	
			$Tiempo = $Hora + $Min;
			echo "<tr>\n";
			echo "<td align='center'>".substr($FilaAux["hornada"],-4)."-".$FilaAux["campo1"]."</td>\n";
			echo "<td>Carga Fusion</td>\n";
			echo "<td align='center'>".substr($Fila2["fecha_ini"],8,2)."/".substr($Fila2["fecha_ini"],5,2)."</td>\n";
			echo "<td align='center'>".substr($Fila2["hora_ini"],0,5)."</td>\n";
			echo "<td align='center'>".substr($Fila2["hora_ter"],0,5)."</td>\n";
			echo "<td align='right'>".number_format($Tiempo,2,",",".")."</td>\n";
			echo "</tr>\n";	
			$TiempoTotal = $TiempoTotal + $Tiempo;
		}			
	}		
	$Consulta = "select hornada, campo1, fecha_ini, hora_ini, hora_ter, campo2, (campo5 * 1) as ollas, campo7 ";
	$Consulta.= " from raf_web.datos_operacionales ";
	$Consulta.= " where hornada='".$Hornada."'";
	$Consulta.= " and tipo_report='1'";
	$Consulta.= " and seccion_report='5'";
	$Consulta.= " and campo1 <> ''";
	$Consulta.= " and campo2 <> '1'";
	$Consulta.= " order by campo2, campo1, fecha_ini, hora_ini ";
	$Resp = mysql_query($Consulta);
	while ($Fila = mysql_fetch_array($Resp))
	{
		$Tiempo = 0;
		$Hora = 0;
		$Min = 0;
		$FechaIniAux = $Fila["fecha_ini"];
		if (substr($Fila["hora_ter"],0,2) < substr($Fila["hora_ini"],0,2))
			$FechaFinAux = date("Y-m-d", mktime(0,0,0,substr($Fila["fecha_ini"],5,2),intval(substr($Fila["fecha_ini"],8,2))+1,substr($Fila["fecha_ini"],0,4)));
		else
			$FechaFinAux = $Fila["fecha_ini"];
		$FH_IniCarga = $Fila["fecha_ini"]." ".$Fila["hora_ini"];
		$FH_FinCarga = $FechaFinAux." ".$Fila["hora_ter"];
		$Consulta = "select TIMEDIFF('".$FH_FinCarga."', '".$FH_IniCarga."') as diferencia ";				
		$Resp3 = mysql_query($Consulta);
		if ($Fila3 = mysql_fetch_array($Resp3))
		{				
			$Hora = intval(substr($Fila3["diferencia"],0,2));
			$Min = (intval(substr($Fila3["diferencia"],3,2)) / 60);
		}	
		$Tiempo = $Hora + $Min;
		echo "<tr>\n";
		echo "<td align='center'>".substr($Fila["hornada"],-4)."-".$Fila["campo1"]."</td>\n";
		echo "<td>".$ArrayProcesos[$Fila["campo2"]]."</td>\n";
		echo "<td align='center'>".substr($Fila["fecha_ini"],8,2)."/".substr($Fila["fecha_ini"],5,2)."</td>\n";
		echo "<td align='center'>".substr($Fila["hora_ini"],0,5)."</td>\n";
		echo "<td align='center'>".substr($Fila["hora_ter"],0,5)."</td>\n";
		echo "<td align='right'>".number_format($Tiempo,2,",",".")."</td>\n";
		echo "</tr>\n";		
		$TiempoTotal = $TiempoTotal + $Tiempo;
	}
?>  
 <!-- <tr class="ColorTabla02">
    <td colspan="5"><strong>TOTAL</strong></td>
    <td align="right"><? echo number_format($TiempoTotal,2,",","."); ?></td>
  </tr>-->
</table>

<br>
<table width="350"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
  <tr align="center" class="ColorTabla02">
    <td colspan="7"><strong>PRODUCCION ESC. ANODICA </strong></td>
  </tr>
  <tr align="center" class="ColorTabla02">
    <td width="16%"><strong>Hornada</strong></td>
    <td width="13%"><strong>Proceso</strong></td>
    <td width="13%"><strong>Fecha</strong></td>
    <td width="16%"><strong>H.Ini</strong></td>
    <td width="14%"><strong>H.Fin</strong></td>
    <td width="14%"><strong>Ollas</strong></td>
    <td width="27%"><strong>Destino</strong></td>
  </tr>
  <?  
	$OllasCarga=0;
	$Consulta = "select hornada, campo1, fecha_ini, hora_ini, hora_ter, campo2, (campo5 * 1) as ollas, campo7 ";
	$Consulta.= " from raf_web.datos_operacionales ";
	$Consulta.= " where hornada='".$Hornada."'";
	$Consulta.= " and tipo_report='1'";
	$Consulta.= " and seccion_report='5'";
	$Consulta.= " and campo1 <> ''";
	$Consulta.= " and campo2 = '1'";
	$Consulta.= " order by campo1, fecha_ini, hora_ini ";
	$Resp = mysql_query($Consulta);
	while ($Fila = mysql_fetch_array($Resp))
	{
		echo "<tr>\n";
		echo "<td align='center'>".substr($Fila["hornada"],-4)."-".$Fila["campo1"]."</td>\n";
		echo "<td align='center'>".$ArrayProcesos[$Fila["campo2"]]."</td>\n";
		echo "<td align='center'>".substr($Fila["fecha_ini"],8,2)."/".substr($Fila["fecha_ini"],5,2)."</td>\n";
		echo "<td align='center'>".substr($Fila["hora_ini"],0,5)."</td>\n";
		echo "<td align='center'>".substr($Fila["hora_ter"],0,5)."</td>\n";
		echo "<td align='right'>".number_format($Fila["ollas"],2,",",".")."</td>\n";
		if (!is_null($Fila["campo7"]) && $Fila["campo7"]!="" )
			echo "<td align='center'>".$Fila["campo7"]."</td>\n";
		else
			echo "<td align='center'>&nbsp;</td>\n";
		echo "</tr>\n";
		$OllasCarga = $OllasCarga + ($Fila["ollas"]*1);
	}
?>
  <tr class="ColorTabla02">
    <td colspan="5"><strong>TOTAL PROD. ESCORIA </strong></td>
    <td align="right"><? echo number_format($OllasCarga,2,",","."); ?></td>
    <td align="right"><? echo number_format(($OllasCarga*12000),0,",","."); ?></td>
  </tr>
</table>
<br>
<table width="350"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
  <tr align="center" class="ColorTabla02">
    <td colspan="4"><strong>PRODUCCION MOLDES Y PLACAS </strong></td>
  </tr>
  <tr align="center" class="ColorTabla02">
    <td width="20%"><strong>Hornada</strong></td>
    <td width="40%"><strong>Tipo Molde </strong></td>
    <td width="17%"><strong>Unid.</strong></td>
    <td width="23%"><strong>Peso</strong></td>
  </tr>
  <?
  	$OllasTrasvase = 0;  
	$Consulta = "select * ";
	$Consulta.= " from raf_web.datos_operacionales t1 inner join proyecto_modernizacion.sub_clase t2 ";
	$Consulta.= " on t1.campo2=t2.cod_subclase and cod_clase='12006'";
	$Consulta.= " where t1.hornada='".$Hornada."'";
	$Consulta.= " and t1.tipo_report='1'";
	$Consulta.= " and t1.seccion_report='10'";
	$Consulta.= " and t1.campo1 <> ''";
	$Consulta.= " order by t1.campo1, t1.campo2 ";
	$Resp = mysql_query($Consulta);
	while ($Fila = mysql_fetch_array($Resp))
	{
		echo "<tr>\n";
		echo "<td align='center'>".substr($Fila["hornada"],-4)."-".$Fila["campo1"]."</td>\n";
		echo "<td align='center'>".$Fila["nombre_subclase"]."</td>\n";
		echo "<td align='right'>".number_format($Fila["campo3"],1,",",".")."</td>\n";
		echo "<td align='right'>".number_format($Fila["campo4"],0,",",".")."</td>\n";
		echo "</tr>\n";
		$TotalUnidMoldes = $TotalUnidMoldes + $Fila["campo3"];
		$TotalPesoMoldes = $TotalPesoMoldes + $Fila["campo4"];
	}
?>
  <tr class="ColorTabla02">
    <td colspan="2"><strong>TOTAL PROD. MOLDES y PLACAS </strong></td>
    <td align="right"><? echo number_format($TotalUnidMoldes,1,",","."); ?></td>
    <td align="right"><? echo number_format($TotalPesoMoldes,0,",","."); ?></td>
  </tr>
</table>
<br>
</body>
</html>
