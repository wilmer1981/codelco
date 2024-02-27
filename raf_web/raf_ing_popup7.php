<?
include("../principal/conectar_raf_web.php");

if($Proceso == "B")
{
	$Consulta = "SELECT * FROM raf_web.datos_operacionales ";
	$Consulta.= " WHERE fecha='".$Fecha."'";
	$Consulta.= " AND fecha_ini='".$Ano."-".$Mes."-".$Dia."'";
	$Consulta.= " AND hora_ini='".$hhIni.":".$mmIni.":00'";
	$Consulta.= " AND hora_ter='".$hhTer.":".$mmTer.":00'";
	$Consulta.= " AND hornada = '".$Hornada."' AND campo1='".$Letra."' ";
	$Consulta.= " AND tipo_report = 1 AND seccion_report = '".$Seccion."'";
	$rs = mysql_query($Consulta);
	if($row = mysql_fetch_array($rs))
	{		
		$ollas = $row["campo2"];
		$desde = $row["campo3"];
		$Saldo = $row["campo4"];

		$Dia = substr($row["fecha_ini"],8,2);
		$Mes = substr($row["fecha_ini"],5,2);					  			
		$Ano = substr($row["fecha_ini"],0,4);	
		
		$hhIni = intval(substr($row[hora_ini],0,2));
		$mmIni = intval(substr($row[hora_ini],3,2));
		$hhTer = intval(substr($row[hora_ter],0,2));
		$mmTer = intval(substr($row[hora_ter],3,2));
	}
	else
	{
		$ollas = "";
		$desde = "";
	}
					
}


if($Proceso == "E")
{
	$Elimina = "DELETE FROM raf_web.datos_operacionales ";
	$Elimina.= " WHERE fecha='".$Fecha."'";
	$Elimina.= " AND fecha_ini='".$Ano."-".$Mes."-".$Dia."'";
	$Elimina.= " AND hora_ini='".$hhIni.":".$mmIni.":00'";
	$Elimina.= " AND hora_ter='".$hhTer.":".$mmTer.":00'";
	$Elimina.= " AND hornada = '".$Hornada."' AND campo1='".$Letra."' ";
	$Elimina.= " AND tipo_report = 1 AND seccion_report = '".$Seccion."'";
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
	$Elimina.= " AND tipo_report = 1 ";
	$Elimina.= " AND seccion_report = '".$Seccion."'";
	$Elimina.= " AND fecha_ini='".$Ano."-".$Mes."-".$Dia."'";
	$Elimina.= " AND hora_ini='".$hhIni.":".$mmIni.":00'";
	$Elimina.= " AND hora_ter='".$hhTer.":".$mmTer.":00'";
	mysql_query($Elimina);	

	$hora_ini = $hhIni.":".$mmIni;
	$hora_ter = $hhTer.":".$mmTer;
	$Fecha_Ini = $Ano."-".$Mes."-".$Dia;
	$Insertar = "INSERT INTO raf_web.datos_operacionales ";
	$Insertar.= " (hornada,fecha,tipo_report,seccion_report,campo1,fecha_ini,";
	$Insertar.= " hora_ini, hora_ter, campo2, campo3, campo4)";
	$Insertar.= " values('".$Hornada."','".$Fecha."','1','".$Seccion."',";
	$Insertar.= " '".strtoupper($Letra)."','".$Fecha_Ini."','".$hora_ini."','".$hora_ter."','".$ollas."','".$desde."','".$Saldo."')";	
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
			f.action = "raf_ing_popup7.php?Proceso=G&LetraC=" + f.Letra.value + "&Fecha=" + f.Fecha.value;
			f.submit();
			break							

		case "B":
			f.action = "raf_ing_popup7.php?Proceso=B&LetraC=" + f.Letra.value + "&Fecha=" + f.Fecha.value;
			f.submit();
			break							

		case "E":
			f.action = "raf_ing_popup7.php?Proceso=E&LetraC=" + f.Letra.value + "&Fecha=" + f.Fecha.value;
			f.submit();
			break							
	
		case "S":
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
<input name="Fecha" type="hidden" value="<? echo $Fecha;?>">
        <table width="400" border="0" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
          <tr align="center"> 
            <td colspan="2" class="ColorTabla02"><strong>HORNADA:</strong> <? echo substr($Hornada,-4)."-".$LetraC; ?></td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr> 
            <td width="73">Fecha Ini:</td>
            <td width="286"><select name="Dia" style="width:50px;">
                <?
				for ($i = 1;$i <= 31; $i++)
				{
					if (isset($Dia))
					{
						if ($Dia == $i)
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else	echo "<option value='".$i."'>".$i."</option>\n";
					}
					else
					{
						if ($i == date("j"))
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else	echo "<option value='".$i."'>".$i."</option>\n";
					}
				}
			  ?>
              </select> <select name="Mes" style="width:90px;">
                <?
                $Meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
				for ($i = 1;$i <= 12; $i++)
				{
					if (isset($Mes))
					{
						if ($Mes == $i)
							echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
						else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
					}
					else
					{
						if ($i == date("n"))
							echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
						else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
					}
				}
				?>
              </select> <select name="Ano">
<?
	for ($i=(date("Y")-1);$i<=(date("Y")+1);$i++)
	{
		if (isset($Ano))
		{
			if ($Ano==$i)
				echo "<option selected value='".$i."'>".$i."</option>\n";
			else
				echo "<option value='".$i."'>".$i."</option>\n";
		}
		else
		{
			if ($i==date("Y"))
				echo "<option selected value='".$i."'>".$i."</option>\n";
			else
				echo "<option value='".$i."'>".$i."</option>\n";
		}
	}
?>			  
              </select>
              <input type="button" name="BtnOk2" size="20" style="width:70px" value="Buscar" onClick="Proceso('B');"> 
            </td>
          </tr>
          <tr> 
            <td>Hora Ini:</td>
            <td> <select name="hhIni">
                <?
				for($i=0; $i<=23; $i++)
				{
					if (isset($hhIni))
					{
						if ($hhIni == $i)
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else	echo "<option value='".$i."'>".$i."</option>\n";
					}
					else
					{
						if ($i == date("H"))
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else	echo "<option value='".$i."'>".$i."</option>\n";
					}
				}
			?>
              </select>
              : 
              <select name="mmIni" id="select6">
                <?
				for($i=0; $i<=59; $i++)
				{
					if (isset($mmIni))
					{
						if ($mmIni == $i)
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else	echo "<option value='".$i."'>".$i."</option>\n";
					}
					else
					{
						if ($i == date("i"))
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else	echo "<option value='".$i."'>".$i."</option>\n";
					}
				}
			?>
              </select> </td>
          </tr>
          <tr> 
            <td>Hora Ter:</td>
            <td> <select name="hhTer">
                <?
				for($i=0; $i<=23; $i++)
				{
					if (isset($hhTer))
					{
						if ($hhTer == $i)
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else	echo "<option value='".$i."'>".$i."</option>\n";
					}
					else
					{
						if ($i == date("H"))
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else	echo "<option value='".$i."'>".$i."</option>\n";
					}
				}
			?>
              </select>
              : 
              <select name="mmTer">
                <?
				for($i=0; $i<=59; $i++)
				{
					if (isset($mmTer))
					{
						if ($mmTer == $i)
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else	echo "<option value='".$i."'>".$i."</option>\n";
					}
					else
					{
						if ($i == date("i"))
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else	echo "<option value='".$i."'>".$i."</option>\n";
					}
				}
			?>
              </select></td>
          </tr>
          <tr> 
            <td>Ollas:</td>
            <td><input name="ollas" size="10" value="<? echo $ollas; ?>"></td>
          </tr>
<?	
	if ($Seccion==1)
	{	  
		echo "<tr>\n";
		echo "<td >ES SALDO:</td> \n";
		echo "<td>";
		if ($Saldo == "S")
		{
			echo "<input checked name='Saldo' type='radio' value='S'>Si\n";
			echo "<input name='Saldo' type='radio' value='N'>No</td>\n";
		}
		else
		{
			echo "<input name='Saldo' type='radio' value='S'>Si\n";
			echo "<input checked name='Saldo' type='radio' value='N'>No</td>\n";
		}
		echo "</tr>\n";
	}
	else
	{
		echo "<input name='Saldo' type='hidden' value=''>";
	}
?>		  		  
          <tr> 
            <td>Desde:</td>
            <td><select name="desde">
<?
	$Consulta = "select * from proyecto_modernizacion.sub_clase ";
	$Consulta.= " where cod_clase='12001' order by cod_subclase ";
	$Resp = mysql_query($Consulta);
	while ($Fila = mysql_fetch_array($Resp))
	{
		if ($desde == $Fila["nombre_subclase"])
			echo "<option selected value='".$Fila["nombre_subclase"]."'>".$Fila["nombre_subclase"]."</option>\n";
		else
			echo "<option value='".$Fila["nombre_subclase"]."'>".$Fila["nombre_subclase"]."</option>\n";
	}
?>			
            </select></td>
          </tr>
          <tr align="center">
            <td height="50" colspan="2"><input type="button" name="BtnOk" size="20" style="width:70px" value="Grabar" onClick="Proceso('G');">
              <input type="button" name="BtnOk22" size="20" style="width:70px" value="Eliminar" onClick="Proceso('E');">
              <input type="button" name="BtnSalir" size="20"  style="width:70px" value="Salir" onClick="Proceso('S');"></td>
          </tr>
  </table>
</form>
</body>
</html>
