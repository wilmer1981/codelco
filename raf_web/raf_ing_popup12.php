<?
include("../principal/conectar_raf_web.php");

if(strlen($Mes) == 1)
	$Mes = '0'.$Mes;
if(strlen($Dia) == 1)
	$Dia = '0'.$Dia;

$fecha = $Ano.'-'.$Mes.'-'.$Dia;

if($Proceso == "B")
{
	$Consulta = "SELECT * FROM raf_web.datos_operacionales ";
	$Consulta.= " WHERE fecha='".$Fecha."'";
	$Consulta.= " AND hornada = '".$Hornada."' ";
	$Consulta.= " AND tipo_report = 1 ";
	$Consulta.= " AND seccion_report = '".$Seccion."'";
	$rs = mysqli_query($link, $Consulta);
	if($row = mysql_fetch_array($rs))
	{		
		$SB = $row["campo2"];
		$AS = $row["campo3"];
	}
	else
	{
		$SB = "";
		$AS = "";
	}
					
}


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
	
	$hora_ini = $hhIni.':'.$mmIni;
	$hora_ter = $hhTer.':'.$mmTer;
	$Ano = substr($Fecha,0,4);
	$Fecha_Ini = $Ano.'-'.$Mes.'-'.$Dia;
	$Insertar = "INSERT INTO raf_web.datos_operacionales (hornada,fecha,tipo_report,seccion_report,";
	$Insertar.= " campo1,campo2,campo3)";
	$Insertar.= " values('".$Hornada."','".$Fecha."','".$Report."','".$Seccion."','".strtoupper($Letra)."','".str_replace(",",".",$SB)."','".str_replace(",",".",$AS)."')";	
	mysql_query($Insertar);
	$Valores = '?Proceso=M&Hornada='.substr($Hornada,6,4)."&Ano=".$Ano."&Mes=".$Mes;
	echo "<script languaje='JavaScript'>";
	echo "window.opener.document.FrmPrincipal.action = 'raf_report_operacional01.php".$Valores."';";
	echo "window.opener.document.FrmPrincipal.submit();";
	echo "window.close();";										 	
	echo "</script>";
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

			f.action = "raf_ing_popup12.php?Proceso=G&LetraC=" + f.Letra.value;
			f.submit();
			break							

		case "B":

			f.action = "raf_ing_popup12.php?Proceso=B&LetraC=" + f.Letra.value;
			f.submit();
			break							

		case "E":

			f.action = "raf_ing_popup12.php?Proceso=E&LetraC=" + f.Letra.value;
			f.submit();
			break							
	
		case "S":
			document.location = "../principal/sistemas_usuario.php?CodSistema=12&Nivel=1&CodPantalla=10";										 	
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
 
        <table width="282" border="0" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
          <tr align="center"> 
            <td colspan="2" class="ColorTabla02"><strong>HORNADA:</strong> <? echo substr($Hornada,-4)."-".$LetraC; ?></td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="2" align="center" class="ColorTabla01">MUESTRA</td>
          </tr>
          <tr> 
            <td width="42">Sb:</td>
            <td width="229"> <input name="SB" size="10" value="<? echo $SB; ?>"></td>
          </tr>
          <tr> 
            <td>As:</td>
            <td><input name="AS" size="10" value="<? echo $AS; ?>"></td>
          </tr>
          <tr align="center">
            <td height="30" colspan="2"><input type="button" name="BtnOk" size="20" style="width:70px" value="Grabar" onClick="Proceso('G');">
              <input type="button" name="BtnOk22" size="20" style="width:70px" value="Eliminar" onClick="Proceso('E');">
              <input type="button" name="BtnSalir" size="20"  style="width:70px" value="Salir" onClick="self.close()"></td>
          </tr>
  </table>
		</form>
</body>
</html>
