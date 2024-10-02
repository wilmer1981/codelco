<?php 
include("conectar_principal.php");

$cmb_ano = isset($_REQUEST["cmb_ano"])?$_REQUEST["cmb_ano"]:"";
$cmb_mes = isset($_REQUEST["cmb_mes"])?$_REQUEST["cmb_mes"]:"";
$cmb_dia = isset($_REQUEST["cmb_dia"])?$_REQUEST["cmb_dia"]:"";
$cmb_ano_fin = isset($_REQUEST["cmb_ano_fin"])?$_REQUEST["cmb_ano_fin"]:"";
$cmb_mes_fin = isset($_REQUEST["cmb_mes_fin"])?$_REQUEST["cmb_mes_fin"]:"";
$cmb_dia_fin = isset($_REQUEST["cmb_dia_fin"])?$_REQUEST["cmb_dia_fin"]:"";
$HoraIni  = isset($_REQUEST["HoraIni"])?$_REQUEST["HoraIni"]:"";
$MinIni   = isset($_REQUEST["MinIni"])?$_REQUEST["MinIni"]:"";
$HoraFin  = isset($_REQUEST["HoraFin"])?$_REQUEST["HoraFin"]:"";
$MinFin   = isset($_REQUEST["MinFin"])?$_REQUEST["MinFin"]:"";

$USUARIO = isset($_REQUEST["USUARIO"])?$_REQUEST["USUARIO"]:"";
$SISTEMA = isset($_REQUEST["SISTEMA"])?$_REQUEST["SISTEMA"]:"";

?>
<html>
<head>
<title>Sistemas Locales - Control de Acceso</title>
<link rel="stylesheet" href="estilos/css_principal.css">
<script language="JavaScript">
<!--
function Volver()
{
	/*document.FrmPrincipal.action = "control_accesos.php";
	document.FrmPrincipal.submit();*/
	window.history.back();
}
//-->
</script>
</head>

<body bgcolor="#FFFFFF" background="imagenes/fondo3.gif" text="#000000" leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="FrmPrincipal" action="" method="post">
<b><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#000000">Control de Acceso a Usuarios - Sistemas Informaticos Locales</font></b> <br>
<br>
  <img src="imagenes/control.jpg" width="200" height="148" border="4" align="left"><br>
<br>
<?php

	$Fecha1 = $cmb_ano."-".$cmb_mes."-".$cmb_dia;
	$Fecha2 = $cmb_ano_fin."-".$cmb_mes_fin."-".$cmb_dia_fin;
	$Hora1 = $HoraIni.":".$MinIni.":00";
	$Hora2 = $HoraFin.":".$MinFin.":59";
	if ($USUARIO == "S")
	{
		$Consulta = "SELECT DISTINCT(RUT) FROM proyecto_modernizacion.CONTROL_ACCESO ";
	}
	else
	{
		$Consulta = "SELECT RUT, FECHA_HORA, SISTEMA, PC, IP FROM proyecto_modernizacion.CONTROL_ACCESO ";
	}
	if ($SISTEMA == "S")
	{
		if ($USUARIO != "S")
		{
			$Consulta = "$Consulta  WHERE RUT = '".$USUARIO."' ";
			$Consulta = "$Consulta  AND FECHA_HORA BETWEEN '".$Fecha1." ".$Hora1."' AND '".$Fecha2." ".$Hora2."'";
		}
		else
		{
			$Consulta = "$Consulta  WHERE FECHA_HORA BETWEEN '".$Fecha1." ".$Hora1."' AND '".$Fecha2." ".$Hora2."'";
		}
	}
	else
	{
		if ($USUARIO != "S")
		{
			$Consulta = "$Consulta  WHERE RUT = '".$USUARIO."' ";
			$Consulta = "$Consulta  AND SISTEMA = '".$SISTEMA."' ";
			$Consulta = "$Consulta  AND FECHA_HORA BETWEEN '".$Fecha1." ".$Hora1."' AND '".$Fecha2." ".$Hora2."'";
		}
		else
		{
			$Consulta = "$Consulta  WHERE SISTEMA = '".$SISTEMA."' ";
			$Consulta = "$Consulta  AND FECHA_HORA BETWEEN '".$Fecha1." ".$Hora1."' AND '".$Fecha2." ".$Hora2."'";
		}
	}
	//echo $Consulta."<br>";
	$Respuesta = mysqli_query($link, $Consulta);
	if ($USUARIO != "S")
	{
		$Row = mysqli_fetch_array($Respuesta);
		$RUT = isset($Row["RUT"])?$Row["RUT"]:"";
		// -----------------------------CONTADOR DE ACCESOS----------------------
		if ($SISTEMA != "S")
		{
			$ConsAccesos = "SELECT COUNT(*) AS ACCESOS FROM proyecto_modernizacion.CONTROL_ACCESO ";
			$ConsAccesos = "$ConsAccesos WHERE RUT = '".$RUT."' ";
			$ConsAccesos = "$ConsAccesos AND SISTEMA = '".$SISTEMA."' ";
			$ConsAccesos = "$ConsAccesos AND FECHA_HORA BETWEEN '".$Fecha1." ".$Hora1."' AND '".$Fecha2." ".$Hora2."' ORDER BY IP";
		}
		else
		{
			$ConsAccesos = "SELECT COUNT(*) AS ACCESOS FROM proyecto_modernizacion.CONTROL_ACCESO WHERE RUT = '".$RUT."' AND FECHA_HORA BETWEEN '#".$Fecha1." ".$Hora1."#' AND '#".$Fecha2." ".$Hora2."#' ORDER BY IP";
		}
		$RespAccesos = mysqli_query($link, $ConsAccesos);
		$RowAccesos = mysqli_fetch_array($RespAccesos);
		$TotalFilas = $RowAccesos["ACCESOS"] + 1;
		//--------------------------------------------------------------------
		echo "<table width=500 border=0 cellspacing=0 cellpadding=0 bordercolor=#CCCCCC style='border:solid 1px black' align='center'>\n";
		echo "<tr align='center'>\n";
		$Consulta = "select RUT, concat(apellido_paterno, ' ', apellido_materno, ' ', nombres) as NOMBRE ";
		$Consulta.= " from proyecto_modernizacion.funcionarios ";
		$Consulta.= " where rut = '".$RUT."'";
		$Resp2 = mysqli_query($link, $Consulta);
		if ($Row2 = mysqli_fetch_array($Resp2))
			echo "<td  colspan=4 bgcolor=#009900 ><b><font color=#FFFFFF size=1 face='Verdana, Arial, Helvetica, sans-serif'>".trim($Row2["RUT"])." ".trim($Row2["NOMBRE"])." - TotalAccesos = ".($TotalFilas - 1)."</font></b></td>\n";
		else
			echo "<td  colspan=4 bgcolor=#009900 ><b><font color=#FFFFFF size=1 face='Verdana, Arial, Helvetica, sans-serif'>NO IDENTIFICADO - TotalAccesos = ".($TotalFilas - 1)."</font></b></td>\n";
		echo "</tr>\n";
		echo "<tr align='center'>\n";		
		echo "<td width=208 bgcolor='#FFFFCC'><b><font color=#666666 size=1 face='Verdana, Arial, Helvetica, sans-serif'>PC</font></b></td>\n";
		echo "<td width=200 bgcolor='#FFFFCC'><b><font color=#666666 size=1 face='Verdana, Arial, Helvetica, sans-serif'>IP</font></b></td>\n";
		echo "<td width=249 bgcolor='#FFFFCC'><b><font color=#666666 size=1 face='Verdana, Arial, Helvetica, sans-serif'>FECHA_HORA</font></b></td>\n";
		echo "<td width=196 bgcolor='#FFFFCC'><b><font color=#666666 size=1 face='Verdana, Arial, Helvetica, sans-serif'>SISTEMA</font></b></td>\n";
		echo "</tr>\n";
		if ($SISTEMA != "S")
		{
			$ConsAccesos = "SELECT T1.FECHA_HORA, T1.IP, T1.RUT, T2.NOMBRE AS SISTEMA, T1.PC  ";
			$ConsAccesos.= " FROM proyecto_modernizacion.CONTROL_ACCESO T1 INNER JOIN proyecto_modernizacion.SISTEMAS T2 ON T1.SISTEMA = T2.COD_SISTEMA";
			$ConsAccesos.= " WHERE T1.RUT = '".$RUT."' ";
			$ConsAccesos.= " AND T1.SISTEMA = '".$SISTEMA."' ";
			$ConsAccesos.= " AND T1.FECHA_HORA BETWEEN '".$Fecha1." ".$Hora1."' AND '".$Fecha2." ".$Hora2."' ORDER BY T1.IP";
		}
		else
		{
			$ConsAccesos = "SELECT T1.FECHA_HORA, T1.IP, T1.RUT, T2.NOMBRE AS SISTEMA, T1.PC  ";
			$ConsAccesos.= " FROM proyecto_modernizacion.CONTROL_ACCESO T1 INNER JOIN proyecto_modernizacion.SISTEMAS T2 ON T1.SISTEMA = T2.COD_SISTEMA";
			$ConsAccesos.= " WHERE T1.RUT = '".$RUT."' ";
			$ConsAccesos.= " AND T1.FECHA_HORA BETWEEN '".$Fecha1." ".$Hora1."' AND '".$Fecha2." ".$Hora2."' ORDER BY T1.IP DESC";
		}	
		//echo $ConsAccesos."<br>";
		$RespAccesos = mysqli_query($link, $ConsAccesos);
		while ($RowAccesos = mysqli_fetch_array($RespAccesos))
		{
			echo "<tr align='center'>\n";
			echo "<td width=208 bgcolor='#FFFFFF' ALIGN='CENTER'><font color=#000000 size=1 face='Verdana, Arial, Helvetica, sans-serif'>&nbsp;".$RowAccesos["PC"]."</font></td>\n";
			echo "<td width=200 bgcolor='#FFFFFF' ALIGN='LEFT'><font color=#000000 size=1 face='Verdana, Arial, Helvetica, sans-serif'>&nbsp;".$RowAccesos["IP"]."</font></td>\n";
			echo "<td width=249 bgcolor='#FFFFFF'><font color=#000000 size=1 face='Verdana, Arial, Helvetica, sans-serif'>&nbsp;".$RowAccesos["FECHA_HORA"]."</font></td>\n";
			echo "<td width=196 bgcolor='#FFFFFF' ALIGN='CENTER'><font color=#000000 size=1 face='Verdana, Arial, Helvetica, sans-serif'>&nbsp;".$RowAccesos["SISTEMA"]."</font></td>\n";
			echo "</tr>\n";
		}
		echo "</table><br>\n";
	}
	else
	{
		while ($Row = mysqli_fetch_array($Respuesta))
		{
			//---------CONTADOR DE ACCESOS---------------------
			if ($SISTEMA != "S")
			{
				$ConsAccesos = "SELECT COUNT(*) AS ACCESOS FROM proyecto_modernizacion.CONTROL_ACCESO ";
				$ConsAccesos = "$ConsAccesos WHERE RUT = '".$Row["RUT"]."' ";
				$ConsAccesos = "$ConsAccesos AND SISTEMA = '".$SISTEMA."' ";
				$ConsAccesos = "$ConsAccesos AND FECHA_HORA BETWEEN '".$Fecha1." ".$Hora1."' AND '".$Fecha2." ".$Hora2."' ORDER BY IP";
			}
			else
			{
				$ConsAccesos = "SELECT COUNT(*) AS ACCESOS FROM proyecto_modernizacion.CONTROL_ACCESO WHERE RUT = '".$Row["RUT"]."' AND FECHA_HORA BETWEEN '".$Fecha1." ".$Hora1."' AND '".$Fecha2." ".$Hora2."' ORDER BY IP";
			}
			$RespAccesos = mysqli_query($link, $ConsAccesos);
			$RowAccesos = mysqli_fetch_array($RespAccesos);
			$TotalFilas = $RowAccesos["ACCESOS"] + 1;
			//---------------------------------------------------
			echo "<table width=500 border=0 cellspacing=0 cellpadding=0 bordercolor=#CCCCCC style='border:solid 1px black' align='center'>\n";
			echo "<tr align='center'>\n";
			$Consulta = "select RUT, concat(apellido_paterno, ' ', apellido_materno, ' ', nombres) as NOMBRE ";
			$Consulta.= " from proyecto_modernizacion.funcionarios ";
			$Consulta.= " where rut = '".$Row["RUT"]."'";
			$Resp2 = mysqli_query($link, $Consulta);
			if ($Row2 = mysqli_fetch_array($Resp2))
				echo "<td colspan=4 bgcolor=#009900 ><b><font color=#FFFFFF size=1 face='Verdana, Arial, Helvetica, sans-serif'>".trim($Row2["RUT"])." ".trim($Row2["NOMBRE"])." - TotalAccesos = ".($TotalFilas - 1)."</font></b></td>\n";
			else
				echo "<td colspan=4 bgcolor=#009900 ><b><font color=#FFFFFF size=1 face='Verdana, Arial, Helvetica, sans-serif'>NO IDENTIFICADO - TotalAccesos = ".($TotalFilas - 1)."</font></b></td>\n";
			echo "</tr>\n";
			echo "<tr align='center'>\n";			
			echo "<td width=208 bgcolor='#FFFFCC'><b><font color=#666666 size=1 face='Verdana, Arial, Helvetica, sans-serif'>PC</font></b></td>\n";
			echo "<td width=200 bgcolor='#FFFFCC'><b><font color=#666666 size=1 face='Verdana, Arial, Helvetica, sans-serif'>IP</font></b></td>\n";
			echo "<td width=249 bgcolor='#FFFFCC'><b><font color=#666666 size=1 face='Verdana, Arial, Helvetica, sans-serif'>FECHA_HORA</font></b></td>\n";
			echo "<td width=196 bgcolor='#FFFFCC'><b><font color=#666666 size=1 face='Verdana, Arial, Helvetica, sans-serif'>SISTEMA</font></b></td>\n";
			echo "</tr>\n";
			if ($SISTEMA != "S")
			{
				$ConsAccesos = "SELECT T1.FECHA_HORA, T1.IP, T1.RUT, T2.NOMBRE AS SISTEMA, T1.PC ";
				$ConsAccesos.= " FROM proyecto_modernizacion.CONTROL_ACCESO T1 INNER JOIN proyecto_modernizacion.SISTEMAS T2 ON T1.SISTEMA = T2.COD_SISTEMA";
				$ConsAccesos.= " WHERE T1.RUT = '".$Row["RUT"]."' ";
				$ConsAccesos.= " AND T1.SISTEMA = '".$SISTEMA."' ";
				$ConsAccesos.= " AND T1.FECHA_HORA BETWEEN '".$Fecha1." ".$Hora1."' AND '".$Fecha2." ".$Hora2."' ORDER BY IP";
			}
			else
			{
				$ConsAccesos = "SELECT T1.FECHA_HORA, T1.IP, T1.RUT, T2.NOMBRE AS SISTEMA, T1.PC ";
				$ConsAccesos.= " FROM proyecto_modernizacion.CONTROL_ACCESO T1 INNER JOIN proyecto_modernizacion.SISTEMAS T2 ON T1.SISTEMA = T2.COD_SISTEMA";
				$ConsAccesos.= " WHERE T1.RUT = '".$Row["RUT"]."' ";
				$ConsAccesos.= " AND T1.FECHA_HORA BETWEEN '".$Fecha1." ".$Hora1."' AND '".$Fecha2." ".$Hora2."' ORDER BY T1.IP DESC";
			}
			$RespAccesos = mysqli_query($link, $ConsAccesos);
			while ($RowAccesos = mysqli_fetch_array($RespAccesos))
			{
				echo "<tr align='center'>\n";
				echo "<td width=208 bgcolor='#FFFFFF' ALIGN='CENTER'><font color=#000000 size=1 face='Verdana, Arial, Helvetica, sans-serif'>&nbsp;".$RowAccesos["PC"]."</font></td>\n";
				echo "<td width=200 bgcolor='#FFFFFF' ALIGN='LEFT'><font color=#000000 size=1 face='Verdana, Arial, Helvetica, sans-serif'>&nbsp;".$RowAccesos["IP"]."</font></td>\n";
				echo "<td width=249 bgcolor='#FFFFFF'><font color=#000000 size=1 face='Verdana, Arial, Helvetica, sans-serif'>&nbsp;".$RowAccesos["FECHA_HORA"]."</font></td>\n";
				echo "<td width=196 bgcolor='#FFFFFF' ALIGN='CENTER'><font color=#000000 size=1 face='Verdana, Arial, Helvetica, sans-serif'>&nbsp;".$RowAccesos["SISTEMA"]."</font></td>\n";
				echo "</tr>\n";
			}
			echo "</table><br>\n";
		}
	}
?>
<div align="center"><br>
  <input type="button" name="BtnVolver" value="Volver" onClick="JavaScript:Volver();">
</div>
</form>
</body>
</html>
