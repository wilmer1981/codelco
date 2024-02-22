<?
include("../principal/conectar_raf_web.php");

if(strlen($Mes) == 1)
	$Mes = '0'.$Mes;
if(strlen($Dia) == 1)
	$Dia = '0'.$Dia;
$Anito=substr($Hornada,0,4);
$MesJ=substr($Hornada,4,2);
$fecha = $Ano.'-'.$Mes.'-'.$Dia;

if($Proceso != "G" && $Proceso != "E")
{
	$Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE fecha='$Fecha'";
	$Consulta.= " AND hornada = $Hornada AND tipo_report = 2 AND seccion_report = '$Seccion'";
	$rs = mysql_query($Consulta);
	if($row = mysql_fetch_array($rs))
	{
		$observacion = $row[campo8];				
	}
}					

if($Proceso == "E")
{
	$Elimina = "DELETE FROM raf_web.datos_operacionales WHERE fecha='$Fecha'";
	$Elimina.= " AND hornada = $Hornada AND tipo_report = 2 AND seccion_report = '$Seccion'";
	mysql_query($Elimina);
	$Ano = substr($Fecha,0,4);
	$Valores = '?Proceso=M&Hornada='.substr($Hornada,6,4).'&Anito='.$Anito.'&MesJ='.$MesJ;
	echo "<script languaje='JavaScript'>";
	echo "window.opener.document.FrmPrincipal.action = 'raf_report_operacional02.php".$Valores."';";
	echo "window.opener.document.FrmPrincipal.submit();";
	echo "window.close();";										 	
	echo "</script>";

}


if($Proceso == "G")
{
	$Elimina = "DELETE FROM raf_web.datos_operacionales WHERE fecha='$Fecha'";
	$Elimina.= " AND hornada = $Hornada AND tipo_report = 2 AND seccion_report = '$Seccion'";
	mysql_query($Elimina);

	$Insertar = "INSERT INTO raf_web.datos_operacionales (hornada,fecha,tipo_report,seccion_report,campo8)";
	$Insertar.= " values($Hornada,'$Fecha','$Report','$Seccion','$observacion')";	
	mysql_query($Insertar);
	$Ano = substr($Fecha,0,4);
	$Valores = '?Proceso=M&Hornada='.substr($Hornada,6,4).'&Anito='.$Anito.'&MesJ='.$MesJ;
	echo "<script languaje='JavaScript'>";
	echo "window.opener.document.FrmPrincipal.action = 'raf_report_operacional02.php".$Valores."';";
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
			f.action = "raf_ing_popup4.php?Proceso=G";
			f.submit();
			break							

		case "B":
			f.action = "raf_ing_popup4.php?Proceso=B";
			f.submit();
			break							

		case "E":
			f.action = "raf_ing_popup4.php?Proceso=E";
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
<input name="Report" type="hidden" value="<? echo $Report?>">
<input name="Seccion" type="hidden" value="<? echo $Seccion?>">
<input name="Hornada" type="hidden" value="<? echo $Hornada?>">
<input name="Fecha" type="hidden" value="<? echo $Fecha?>">
  <table width="503" height="160" border="0" class="TablaPrincipal">
    <tr> 
      <td width="495" height="154" align="center">
        <table width="482" border="0" cellspacing="0" cellpadding="0" class="TablaDetalle">
          <tr> 
            <td align="center"><b>Incidentes Operacionales</b></td>
          </tr>
          <tr> 
            <td align="center"> <textarea name="observacion" cols="70" rows="5" wrap="VIRTUAL"><? echo $observacion;?></textarea></td>
          </tr>
        </table>
		<br>
        <br>	
			<table width="282" border="1" cellspacing="" cellpadding="0" class="TablaInterior">
				<tr>
				  <td width="366" align="center">
					<input type="button" name="BtnOk" size="20" style="width:70px" value="Grabar" onClick="Proceso('G');">
              <input type="button" name="BtnOk22" size="20" style="width:70px" value="Eliminar" onClick="Proceso('E');">
              <input type="button" name="BtnSalir" size="20"  style="width:70px" value="Salir" onClick="self.close()">
				  </td>	
				</tr>
		    </table>		
	  </td>	
   </tr>
</table>
 </form>
</body>
</html>
