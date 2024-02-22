<?
include("../principal/conectar_raf_web.php");

if(strlen($Mes) == 1)
	$Mes = '0'.$Mes;
if(strlen($Dia) == 1)
	$Dia = '0'.$Dia;
$Ano=substr($Hornada,0,4);
$Mes=substr($Hornada,5,2);
if($Proceso == "E")
{
	$Elimina = "DELETE FROM raf_web.datos_operacionales ";
	$Elimina.= " WHERE fecha='".$Fecha."'";
	$Elimina.= " AND hornada = '".$Hornada."' ";
	$Elimina.= " AND tipo_report = 1 ";
	$Elimina.= " AND seccion_report = '".$Seccion."'";
	mysql_query($Elimina);
					
	$Valores = '?Proceso=M&Hornada='.substr($Hornada,6,4)."&Ano=".$Ano."&Mes=".$Mes;
	echo "<script languaje='JavaScript'>";
	echo "window.opener.document.FrmPrincipal.action = 'raf_report_operacional01.php".$Valores."';";
	echo "window.opener.document.FrmPrincipal.submit();";
	echo "window.close();";										 	
	echo "</script>";

}


if($Proceso == "G")
{
	$Elimina = "DELETE FROM raf_web.datos_operacionales ";
	$Elimina.= " WHERE fecha='".$Fecha."'";
	$Elimina.= " AND hornada = '".$Hornada."' ";
	$Elimina.= " AND tipo_report = 1 ";
	$Elimina.= " AND seccion_report = '".$Seccion."'";
	mysql_query($Elimina);
	
	$Ano = substr($Fecha,0,4);
	//GAS NATURAL
	if ($Q_Gas_Ini != "" || $Q_Gas_Fin != "")
	{
		$Insertar = "INSERT INTO raf_web.datos_operacionales (hornada,fecha,tipo_report,seccion_report,";
		$Insertar.= " campo1,campo2,campo3, campo4, campo5)";
		$Insertar.= " values('".$Hornada."','".$Fecha."','".$Report."','".$Seccion."',";
		$Insertar.= " '".strtoupper($Letra)."','QGI','".str_replace(",",".",$Q_Gas_Ini)."',";
		$Insertar.= " 'QGF','".str_replace(",",".",$Q_Gas_Fin)."')";	
		mysql_query($Insertar);
	}
	if ($Q_Die_Ini != "" || $Q_Die_Fin != "")
	{
		$Insertar = "INSERT INTO raf_web.datos_operacionales (hornada,fecha,tipo_report,seccion_report,";
		$Insertar.= " campo1,campo2,campo3, campo4, campo5)";
		$Insertar.= " values('".$Hornada."','".$Fecha."','".$Report."','".$Seccion."',";
		$Insertar.= " '".strtoupper($Letra)."','QDI','".str_replace(",",".",$Q_Die_Ini)."',";
		$Insertar.= " 'QDF','".str_replace(",",".",$Q_Die_Fin)."')";	
		mysql_query($Insertar);
	}
	//DIESEL
	if ($T_Gas_Ini != "" || $T_Gas_Fin != "")
	{
		$Insertar = "INSERT INTO raf_web.datos_operacionales (hornada,fecha,tipo_report,seccion_report,";
		$Insertar.= " campo1,campo2,campo3, campo4, campo5)";
		$Insertar.= " values('".$Hornada."','".$Fecha."','".$Report."','".$Seccion."',";
		$Insertar.= " '".strtoupper($Letra)."','TGI','".str_replace(",",".",$T_Gas_Ini)."',";
		$Insertar.= " 'TGF','".str_replace(",",".",$T_Gas_Fin)."')";	
		mysql_query($Insertar);
	}
	if ($T_Die_Ini != "" || $T_Die_Fin != "")
	{
		$Insertar = "INSERT INTO raf_web.datos_operacionales (hornada,fecha,tipo_report,seccion_report,";
		$Insertar.= " campo1,campo2,campo3, campo4, campo5)";
		$Insertar.= " values('".$Hornada."','".$Fecha."','".$Report."','".$Seccion."',";
		$Insertar.= " '".strtoupper($Letra)."','TDI','".str_replace(",",".",$T_Die_Ini)."',";
		$Insertar.= " 'TDF','".str_replace(",",".",$T_Die_Fin)."')";	
		mysql_query($Insertar);
	}
	$Valores = '?Proceso=M&Hornada='.substr($Hornada,6,4)."&Ano=".$Ano."&Mes=".$Mes;
	echo "<script languaje='JavaScript'>";
	echo "window.opener.document.FrmPrincipal.action = 'raf_report_operacional01.php".$Valores."';";
	echo "window.opener.document.FrmPrincipal.submit();";
	echo "window.close();";										 	
	echo "</script>";
}

$Consulta = "select * from raf_web.datos_operacionales ";
$Consulta.= " WHERE fecha='".$Fecha."'";
$Consulta.= " AND hornada = '".$Hornada."' ";
$Consulta.= " AND campo1 = '".$LetraC."' ";
$Consulta.= " AND tipo_report = 1 ";
$Consulta.= " AND seccion_report = '".$Seccion."'";
$Resp = mysql_query($Consulta);
while ($Fila = mysql_fetch_array($Resp))
{
	switch ($Fila["campo2"])
	{
		case "QGI":
			$Q_Gas_Ini = $Fila["campo3"];
			$Q_Gas_Fin = $Fila["campo5"];
			break;
		case "QDI":
			$Q_Die_Ini = $Fila["campo3"];
			$Q_Die_Fin = $Fila["campo5"];
			break;
		case "TGI":
			$T_Gas_Ini = $Fila["campo3"];
			$T_Gas_Fin = $Fila["campo5"];
			break;
		case "TDI":
			$T_Die_Ini = $Fila["campo3"];
			$T_Die_Fin = $Fila["campo5"];
			break;
	}
}

?>
<html>
<head>
<title>Ingreso de Datos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
function Calcula()
{
	var f = document.FrmPopUp;

	f.Total.value = f.PrecipitadoCu.value * 1 + f.OtrosCirc.value * 1; 
}

function Proceso(opc)
{
	var f = document.FrmPopUp;
	
	switch (opc)
	{
		case "G":
			if (f.Q_Gas_Ini.value=="" && f.Q_Gas_Fin.value=="" && f.Q_Die_Ini.value=="" && f.Q_Die_Fin.value=="" && 
				f.T_Gas_Ini.value=="" && f.T_Gas_Fin.value=="" && f.T_Die_Ini.value=="" && f.T_Die_Fin.value=="")
			{
				alert("No hay Ningun Dato para Grabar");
				return;
			}
			f.action = "raf_ing_popup14.php?Proceso=G&LetraC=" + f.Letra.value;
			f.submit();
			break												
		case "E":
			f.action = "raf_ing_popup12.php?Proceso=E&LetraC=" + f.Letra.value;
			f.submit();
			break							
		case "S":
			window.opener.document.FrmPrincipal.action = "raf_report_operacional01.php?Proceso=M&Hornada=" + f.Hornada.value.substring(6) +"&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value;
			window.opener.document.FrmPrincipal.submit();
			window.close();
			break							
	
	}

}

</script>
</head>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body class="TablaPrincipal">
<form name="FrmPopUp" method="post" action="">
<input name="Report" type="hidden" value="<? echo $Report ?>">
<input name="Seccion" type="hidden" value="<? echo $Seccion ?>">
<input name="Hornada" type="hidden" value="<? echo $Hornada ?>">
<input name="Letra" type="hidden" value="<? echo $LetraC ?>">
<input name="Fecha" type="hidden" value="<? echo $Fecha ?>">
<input type="hidden" name="Ano" value="<? echo $Ano; ?>">
<input type="hidden" name="Mes" value="<? echo $Mes; ?>">
        <table width="300"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
          <tr align="center">
            <td colspan="5" class="ColorTabla02"><span class="ColorTabla02"><strong>HORNADA:</strong> <? echo substr($Hornada,-4)."-".$LetraC; ?></span></td>
          </tr>
          <tr align="center">
            <td colspan="5"><strong>COMBUSTIBLES</strong></td>
          </tr>
          <tr class="ColorTabla01">
            <td width="22%" rowspan="2">&nbsp;</td>
            <td height="16" colspan="2" align="center">Gas Natural </td>
            <td colspan="2" align="center">Diesel</td>
          </tr>
          <tr class="ColorTabla01">
            <td width="18%" align="center">Inicio</td>
            <td width="19%" align="center">Fin</td>
            <td width="20%" align="center">Inicio</td>
            <td width="21%" align="center">Fin</td>
          </tr>
          <tr>
            <td>Quemador:</td>
            <td><input name="Q_Gas_Ini" type="text" id="Q_Gas_Ini" value="<? echo $Q_Gas_Ini; ?>" size="10" maxlength="8"></td>
            <td><input name="Q_Gas_Fin" type="text" id="Q_Gas_Fin" value="<? echo $Q_Gas_Fin; ?>" size="10" maxlength="8"></td>
            <td><input name="Q_Die_Ini" type="text" id="Q_Die_Ini" value="<? echo $Q_Die_Ini; ?>" size="10" maxlength="8"></td>
            <td><input name="Q_Die_Fin" type="text" id="Q_Die_Fin" value="<? echo $Q_Die_Fin; ?>" size="10" maxlength="8"></td>
          </tr>
          <tr>
            <td>Toberas:</td>
            <td><input name="T_Gas_Ini" type="text" id="T_Gas_Ini" value="<? echo $T_Gas_Ini; ?>" size="10" maxlength="8"></td>
            <td><input name="T_Gas_Fin" type="text" id="T_Gas_Fin" value="<? echo $T_Gas_Fin; ?>" size="10" maxlength="8"></td>
            <td><input name="T_Die_Ini" type="text" id="T_Die_Ini" value="<? echo $T_Die_Ini; ?>" size="10" maxlength="8"></td>
            <td><input name="T_Die_Fin" type="text" id="T_Die_Fin" value="<? echo $T_Die_Fin; ?>" size="10" maxlength="8"></td>
          </tr>
          <tr align="center">
            <td height="35" colspan="5"><input type="button" name="BtnOk" size="20" style="width:70px" value="Grabar" onClick="Proceso('G')">
              <input type="button" name="BtnOk22" size="20" style="width:70px" value="Eliminar" onClick="Proceso('E')">
              <input type="button" name="BtnSalir" size="20"  style="width:70px" value="Salir" onClick="Proceso('S')"></td>
          </tr>
        </table>
</form>
</body>
</html>
