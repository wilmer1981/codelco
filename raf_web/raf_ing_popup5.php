<?
include("../principal/conectar_raf_web.php");

if(strlen($Mes) == 1)
	$Mes = '0'.$Mes;
if(strlen($Dia) == 1)
	$Dia = '0'.$Dia;

$fecha = $Ano.'-'.$Mes.'-'.$Dia;
$Anito=substr($Hornada,0,4);
$MesJ=substr($Hornada,4,2);
if($Proceso == "B")
{
	$Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE fecha='$Fecha'";
	$Consulta.= " AND hornada = $Hornada AND campo1='$etapa' AND tipo_report = 2 AND seccion_report = '$Seccion'";
	$rs = mysql_query($Consulta);
	if($row = mysql_fetch_array($rs))
	{
		$etapa = $row["campo1"];
		$troncos = $row[campo2];
		$ollas = $row[campo3];
		$temp1 = $row[campo4];
		$temp2 = $row[campo5];
		$oxigeno = $row[campo6];
	}
					
}


if($Proceso == "E")
{
	$Elimina = "DELETE FROM raf_web.datos_operacionales WHERE fecha='$Fecha'";
	$Elimina.= " AND hornada = $Hornada AND campo1='$etapa' AND tipo_report = 2 AND seccion_report = '$Seccion'";
	mysql_query($Elimina);
					
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
	$Elimina.= " AND hornada = $Hornada AND campo1='$etapa' AND tipo_report = 2 AND seccion_report = '$Seccion'";
	mysql_query($Elimina);

	$hora_ini = $hhIni.':'.$mmIni;
	$hora_ter = $hhTer.':'.$mmTer;
	$Ano = substr($Fecha,0,4);
	$Fecha_Ini = $Ano.'-'.$Mes.'-'.$Dia;
	$Insertar = "INSERT INTO raf_web.datos_operacionales (hornada,fecha,tipo_report,seccion_report,";
	$Insertar.= " campo1,campo2,campo3,campo4,campo5,campo6)";
	$Insertar.= " values($Hornada,'$Fecha','$Report','$Seccion','$etapa','$troncos','$ollas','$temp1','$temp2','$oxigeno')";	
	mysql_query($Insertar);

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
		    if(f.etapa.value == -1)			
			{
				alert("Debe Seleccionar la Etapa")
				f.etapa.focus();
				return
			}
			f.action = "raf_ing_popup5.php?Proceso=G";
			f.submit();
			break							

		case "B":
		    if(f.etapa.value == -1)			
			{
				alert("Debe Seleccionar la Etapa")
				f.etapa.focus();
				return
			}
			f.action = "raf_ing_popup5.php?Proceso=B";
			f.submit();
			break							

		case "E":
		    if(f.etapa.value == -1)			
			{
				alert("Debe Seleccionar la Etapa")
				f.etapa.focus();
				return
			}
			f.action = "raf_ing_popup5.php?Proceso=E";
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
  <table width="293" height="160" border="0" class="TablaPrincipal">
    <tr> 
      <td width="285" height="154" align="center">
        <table width="282" border="0" cellspacing="0" cellpadding="0" class="TablaDetalle">
          <tr> 
            <td>Etapas</td>
            <td> <select name="etapa">
                <?
				echo '<option value="-1" selected>Seleccionar</option>';
					if($etapa == "1")
						echo '<option value="1" selected>Calenta 1</option>';
					else
						echo '<option value="1">Calenta 1</option>';
					if($etapa == "2")
						echo '<option value="2" selected>Escoreo</option>';
					else
						echo '<option value="2">Escoreo</option>';
					if($etapa == "3")
						echo '<option value="3" selected>Calenta 2</option>';
					else
						echo '<option value="3">Calenta 2</option>';
					if($etapa == "4")
						echo '<option value="4" selected>Reduccion</option>';
					else
						echo '<option value="4">Reduccion</option>';
					if($etapa == "5")
						echo '<option value="5" selected>Calenta 3</option>';
					else
						echo '<option value="5">Calenta 3</option>';
					if($etapa == "6")
						echo '<option value="6" selected>Moldeo</option>';
					else
						echo '<option value="6">Moldeo</option>';
					if($etapa == "7")
						echo '<option value="7" selected>Vac. Sell.</option>';
					else
						echo '<option value="7">Vac. Sell.</option>';
			?>
              </select> <input type="button" name="BtnOk2" size="20" style="width:70px" value="Buscar" onClick="Proceso('B');">
            </td>
          </tr>
          <tr> 
            <td width="73">Troncos</td>
            <td width="206"><input name="troncos" size="10" value="<? echo $troncos; ?>">
            </td>
          </tr>
          <tr> 
            <td>Ollas</td>
            <td><input name="ollas" size="10" value="<? echo $ollas; ?>"></td>
          </tr>
          <tr> 
            <td>Temp 1&deg; C</td>
            <td>
			<input name="temp1" size="10" value="<? echo $temp1; ?>"> </td>
          </tr>
          <tr> 
            <td>Temp 2&deg; C</td>
            <td>
			<input name="temp2" size="10" value="<? echo $temp2; ?>"></td>
          </tr>
          <tr> 
            <td>Oxig. ppm</td>
            <td>
			<input name="oxigeno" size="10" value="<? echo $oxigeno; ?>"> </td>
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
