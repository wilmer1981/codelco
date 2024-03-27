<?
include("../principal/conectar_raf_web.php");

$FechaIni = $Ano."-".$Mes."-".$Dia;
if($Proceso == "B")
{
	$Consulta = "SELECT * FROM raf_web.datos_operacionales ";
	$Consulta.= " WHERE fecha='".$Fecha."'";
	$Consulta.= " AND hornada = '".$Hornada."' ";
	$Consulta.= " AND campo1='".$Letra."' ";
	$Consulta.= " AND campo2='".$etapa."' ";
	$Consulta.= " AND tipo_report = 1 ";
	$Consulta.= " AND seccion_report = '".$Seccion."' ";
	$Consulta.= " AND fecha_ini='".$FechaIni."' ";
	$Consulta.= " AND hora_ini='".$hhIni.":".$mmIni.":00' ";
	$Consulta.= " AND hora_ter='".$hhTer.":".$mmTer.":00' ";
	$rs = mysqli_query($link, $Consulta);
	if($row = mysql_fetch_array($rs))
	{
		$GasIni = $row[campo3];
		$GasFinal = $row[campo4];
		$Ollas = $row[campo5];
		$Destino = $row[campo7];

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
		$GasIni = "";
		$GasFinal = "";
		$Ollas = "";
	}
					
}


if($Proceso == "E")
{
	$Elimina = "DELETE FROM raf_web.datos_operacionales ";
	$Elimina.= " WHERE fecha='".$Fecha."'";
	$Elimina.= " AND hornada = '".$Hornada."' ";
	$Elimina.= " AND campo1='".$Letra."' ";
	$Elimina.= " AND campo2='".$etapa."' ";
	$Elimina.= " AND tipo_report = 1 ";
	$Elimina.= " AND seccion_report = '".$Seccion."'";
	$Elimina.= " AND fecha_ini='".$FechaIni."' ";
	$Elimina.= " AND hora_ini='".$hhIni.":".$mmIni.":00'";
	$Elimina.= " AND hora_ter='".$hhTer.":".$mmTer.":00'";
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
	$Elimina.= " AND campo2='".$etapa."' ";
	$Elimina.= " AND tipo_report = 1 ";
	$Elimina.= " AND seccion_report = '".$Seccion."'";
	$Elimina.= " AND fecha_ini='".$FechaIni."' ";
	$Elimina.= " AND hora_ini='".$hhIni.":".$mmIni.":00'";
	$Elimina.= " AND hora_ter='".$hhTer.":".$mmTer.":00'";
	mysql_query($Elimina);

	$hora_ini = $hhIni.':'.$mmIni;
	$hora_ter = $hhTer.':'.$mmTer;
	$Ano = substr($Fecha,0,4);
	$Fecha_Ini = $Ano.'-'.$Mes.'-'.$Dia;
	$gt = strtoupper($gt);
	//INSERTA EL PESO DE LA OLLA DE ESC. BASC.
	$Eliminar = "delete from proyecto_modernizacion.sub_clase ";
	$Eliminar.= " where cod_clase = '12003'";
	mysql_query($Eliminar);
	
	$Insertar = "insert into proyecto_modernizacion.sub_clase(cod_clase, cod_subclase, nombre_subclase) ";
	$Insertar.= " values('12003','1','".$PesoOllasBasc."')";
	mysql_query($Insertar);
	
	$PesoOllas = str_replace(",",".",$Ollas) * $PesoOllasBasc;
	
	$Insertar = "INSERT INTO raf_web.datos_operacionales (hornada,fecha,tipo_report,seccion_report,";
	$Insertar.= " campo1, campo2, fecha_ini, hora_ini, hora_ter, campo3, campo4, campo5, campo6, campo7)";
	$Insertar.= " values('".$Hornada."','".$Fecha."','".$Report."','".$Seccion."','".$Letra."',";
	$Insertar.= " '".$etapa."', '".$FechaIni."', '".$hora_ini."', '".$hora_ter."', '".$GasIni."', '".$GasFinal."', '".str_replace(",",".",$Ollas)."', '".$PesoOllas."', '".$Destino."')";	
	mysql_query($Insertar);

	$Valores = '?Proceso=M&Hornada='.substr($Hornada,6,4)."&Ano=".$Ano."&Mes=".$Mes;
	echo "<script languaje='JavaScript'>";
	echo "window.opener.document.FrmPrincipal.action = 'raf_report_operacional01.php".$Valores."';";
	echo "window.opener.document.FrmPrincipal.submit();";
	echo "window.close();";										 	
	echo "</script>";

}

//PESO OLLAS ESCORIA RETEN
$Consulta = "select * from proyecto_modernizacion.sub_clase ";
$Consulta.= " where cod_clase = '12003'";
$Resp = mysqli_query($link, $Consulta);
if ($Fila = mysql_fetch_array($Resp))
{
	$PesoOllasBasc = $Fila["nombre_subclase"];
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
		    if(f.etapa.value == 0)			
			{
				alert("Debe Seleccionar la Etapa")
				f.etapa.focus();
				return
			}
			f.action = "raf_ing_popup9.php?Proceso=G&LetraC=" + f.Letra.value;
			f.submit();
			break							

		case "B":
		    if(f.etapa.value == 0)			
			{
				alert("Debe Seleccionar la Etapa")
				f.etapa.focus();
				return
			}
			f.action = "raf_ing_popup9.php?Proceso=B&LetraC=" + f.Letra.value;
			f.submit();
			break							

		case "E":
		    if(f.etapa.value == 0)			
			{
				alert("Debe Seleccionar la Etapa")
				f.etapa.focus();
				return
			}
			f.action = "raf_ing_popup9.php?Proceso=E&LetraC=" + f.Letra.value;
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
  
        <table width="380" border="0" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
          <tr align="center"> 
            <td colspan="3" class="ColorTabla02"><strong>HORNADA:</strong> <? echo substr($Hornada,-4)."-".$LetraC; ?></td>
          </tr>
          <tr>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="3" align="center" class="ColorTabla01">Tiempo Operaci&oacute;n</td>
          </tr>
          <tr> 
            <td width="73">Proceso</td>
            <td colspan="2"> <select name="etapa">
                <?
				echo '<option value="0" selected>Seleccionar</option>';					
					if($etapa == "1")
						echo '<option value="1" selected>Escoreo</option>';
					else
						echo '<option value="1">Escoreo</option>';
					if($etapa == "2")
						echo '<option value="2" selected>Oxidacion</option>';
					else
						echo '<option value="2">Oxidacion</option>';
					if($etapa == "3")
						echo '<option value="3" selected>Reducc. Q</option>';
					else
						echo '<option value="3">Reducc. Q</option>';
					if($etapa == "4")
						echo '<option value="4" selected>Reducc. T</option>';
					else
						echo '<option value="4">Reducc. T</option>';
					if($etapa == "5")
						echo '<option value="5" selected>Moldeo</option>';
					else
						echo '<option value="5">Moldeo</option>';						
			?>
              </select>  
            </td>
          </tr>
         <tr> 
            <td width="73">Fecha Ini:</td>
           <td colspan="2"><select name="Dia" style="width:50px;">
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
            </td>
          </tr>
          <tr> 
            <td>Hora Ini</td>
            <td colspan="2"> <select name="hhIni">
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
            <td>Hora Ter</td>
            <td width="187"> <select name="hhTer">
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
              </select>              </td>
            <td width="105" align="center"><input type="button" name="BtnOk2" size="20" style="width:70px" value="Buscar" onClick="Proceso('B');"></td>
          </tr>
          <tr> 
            <td colspan="3" class="ColorTabla01" align="center">Integrador de 
              Gas</td>
          </tr>
          <tr> 
            <td>Inicio</td>
            <td colspan="2"><input name="GasIni" size="10" value="<? echo $GasIni; ?>"></td>
          </tr>
          <tr> 
            <td>Final</td>
            <td colspan="2"><input name="GasFinal" size="10" value="<? echo $GasFinal; ?>"></td>
          </tr>
          <tr> 
            <td>Ollas</td>
            <td colspan="2"><input name="Ollas" size="10" value="<? echo $Ollas; ?>"></td>
          </tr>
          <tr>
            <td>Peso Olla Escoria Basc. </td>
            <td colspan="2"><input name="PesoOllasBasc" readonly value="<? echo $PesoOllasBasc; ?>" size="10"> 
            (Este es un Peso Referencial) </td>
          </tr>
          <tr>
            <td>Destino</td>
            <td colspan="2"><select name="Destino">
			<option value="">Seleccionar</option>;
              <?
	$Consulta = "select * from proyecto_modernizacion.sub_clase ";
	$Consulta.= " where cod_clase='12001' order by cod_subclase ";	
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysql_fetch_array($Resp))
	{
		if ($Destino == $Fila["nombre_subclase"])
			echo "<option selected value='".$Fila["nombre_subclase"]."'>".$Fila["nombre_subclase"]."</option>\n";
		else
			echo "<option value='".$Fila["nombre_subclase"]."'>".$Fila["nombre_subclase"]."</option>\n";
	}
?>
            </select></td>
          </tr>
          <tr align="center">
            <td height="30" colspan="3"><input type="button" name="BtnOk" size="20" style="width:70px" value="Grabar" onClick="Proceso('G');">
              <input type="button" name="BtnOk22" size="20" style="width:70px" value="Eliminar" onClick="Proceso('E');">
              <input type="button" name="BtnSalir" size="20"  style="width:70px" value="Salir" onClick="self.close()"></td>
          </tr>
  </table>
		</form>
</body>
</html>
