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
	$Consulta.= " AND campo1='".$Letra."' ";
	$Consulta.= " AND campo2='".$cmbturno."' ";
	$Consulta.= " AND tipo_report = 1 ";
	$Consulta.= " AND seccion_report = '".$Seccion."'";
	$rs = mysql_query($Consulta);
	if($row = mysql_fetch_array($rs))
	{
		$Saldo = $row["campo3"];

		$Dia = substr($row[fecha_ini],8,2);
		$Mes = substr($row[fecha_ini],5,2);					  			
		$Ano = substr($row[fecha_ini],0,4);	
		
		$hhIni = intval(substr($row[hora_ini],0,2));
		$mmIni = intval(substr($row[hora_ini],3,2));
		$hhTer = intval(substr($row[hora_ter],0,2));
		$mmTer = intval(substr($row[hora_ter],3,2));
	}
					
}


if($Proceso == "E")
{
	$Elimina = "DELETE FROM raf_web.datos_operacionales ";
	$Elimina.= " WHERE fecha='".$Fecha."'";
	$Elimina.= " AND hornada = '".$Hornada."' ";
	$Elimina.= " AND campo1='".$Letra."' ";
	$Elimina.= " AND campo2='".$cmbturno."' ";
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
	$Elimina.= " AND campo1='".$Letra."' ";
	$Elimina.= " AND campo2='".$cmbturno."' ";
	$Elimina.= " AND tipo_report = 1 ";
	$Elimina.= " AND seccion_report = '".$Seccion."'";
	mysql_query($Elimina);

	$hora_ini = $hhIni.':'.$mmIni;
	$hora_ter = $hhTer.':'.$mmTer;
	$Ano = substr($Fecha,0,4);
	$Fecha_Ini = $Ano.'-'.$Mes.'-'.$Dia;
	$Insertar = "INSERT INTO raf_web.datos_operacionales (hornada,fecha,tipo_report,seccion_report,";
	$Insertar.= " campo1,campo2,campo3)";
	$Insertar.= " values('".$Hornada."','".$Fecha."','".$Report."','".$Seccion."','".$Letra."','".$cmbturno."','".$Saldo."')";
	echo $Insertar;	
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
		    if(f.cmbturno.value == -1)			
			{
				alert("Debe Seleccionar El Turno")
				f.cmbturno.focus();
				return
			}
			f.action = "raf_ing_popup11.php?Proceso=G&LetraC=" + f.Letra.value;
			f.submit();
			break							

		case "B":
		    if(f.cmbturno.value == -1)			
			{
				alert("Debe Seleccionar El Turno")
				f.cmbturno.focus();
				return
			}
			f.action = "raf_ing_popup11.php?Proceso=B&LetraC=" + f.Letra.value;
			f.submit();
			break							

		case "E":
		    if(f.cmbturno.value == -1)			
			{
				alert("Debe Seleccionar El Turno")
				f.cmbturno.focus();
				return
			}
			f.action = "raf_ing_popup11.php?Proceso=E&LetraC=" + f.Letra.value;
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
            <td width="54">Turno:</td>
            <td width="217"> <select name="cmbturno">
                <?
				echo"<option value='-1' selected>Turnos</option>";
				echo"<option value='0'>-------</option>";
				if($cmbturno == "A")
					echo"<option value='A' selected>Turno A</option>";
				else
					echo"<option value='A'>Turno A</option>";
				if($cmbturno == "B")
					echo"<option value='B' selected>Turno B</option>";
				else
					echo"<option value='B'>Turno B</option>";
				if($cmbturno == "C")
					echo"<option value='C' selected>Turno C</option>";
				else
					echo"<option value='C'>Turno C</option>";
				
			?>
              </select> <input type="button" name="BtnOk2" size="20" style="width:70px" value="Buscar" onClick="Proceso('B');"> 
            </td>
          </tr>
          <tr> 
            <td>Saldo:</td>
            <td><input name="Saldo" size="10" value="<? echo $Saldo; ?>"></td>
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
