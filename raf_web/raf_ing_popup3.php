<?
include("../principal/conectar_raf_web.php");
$Anito=substr($Hornada,0,4);
$MesJ=substr($Hornada,4,2);

if($Proceso == "B")
{
	$Consulta = "SELECT * FROM raf_web.datos_operacionales WHERE fecha='$Fecha'";
	$Consulta.= " AND hornada = $Hornada AND campo1='$etapa' ";
	$Consulta.= " AND tipo_report = 2 AND seccion_report = '$Seccion'";
	$Consulta.= " AND fecha_ini='".$Ano."-".$Mes."-".$Dia."'";
	$Consulta.= " AND hora_ini='".$hhIni.":".$mmIni.":00'";
	$Consulta.= " AND hora_ter='".$hhTer.":".$mmTer.":00'";
	$rs = mysqli_query($link, $Consulta);
	if($row = mysql_fetch_array($rs))
	{
		$etapa = $row["campo1"];
				
		$Dia = substr($row["fecha_ini"],8,2);
		$Mes = substr($row["fecha_ini"],5,2);					  			
		$Ano = substr($row["fecha_ini"],0,4);
				
		$hhIni = intval(substr($row[hora_ini],0,2));
		$mmIni = intval(substr($row[hora_ini],3,2));
		$hhTer = intval(substr($row[hora_ter],0,2));
		$mmTer = intval(substr($row[hora_ter],3,2));
	}
					
}


if($Proceso == "E")
{
	$Elimina = "DELETE FROM raf_web.datos_operacionales ";
	$Elimina.= " WHERE fecha='$Fecha'";
	$Elimina.= " AND hornada = $Hornada AND campo1='$etapa' ";
	$Elimina.= " AND tipo_report = 2 AND seccion_report = '$Seccion'";
	$Elimina.= " AND fecha_ini='".$Ano."-".$Mes."-".$Dia."'";
	$Elimina.= " AND hora_ini='".$hhIni.":".$mmIni.":00'";
	$Elimina.= " AND hora_ter='".$hhTer.":".$mmTer.":00'";
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
	$Elimina = "DELETE FROM raf_web.datos_operacionales ";
	$Elimina.= " WHERE fecha='$Fecha'";
	$Elimina.= " AND hornada = $Hornada AND campo1='$etapa' ";
	$Elimina.= " AND tipo_report = 2 AND seccion_report = '$Seccion'";
	$Elimina.= " AND fecha_ini='".$Ano."-".$Mes."-".$Dia."'";
	$Elimina.= " AND hora_ini='".$hhIni.":".$mmIni.":00'";
	$Elimina.= " AND hora_ter='".$hhTer.":".$mmTer.":00'";
	mysql_query($Elimina);

	$FechaIni = $Ano."-".$Mes."-".$Dia;
	
	$hora_ini = $hhIni.':'.$mmIni;
	$hora_ter = $hhTer.':'.$mmTer;

	$Insertar = "INSERT INTO raf_web.datos_operacionales (hornada,fecha,tipo_report,seccion_report,";
	$Insertar.= " campo1, fecha_ini, hora_ini, hora_ter)";
	$Insertar.= " values($Hornada,'$Fecha','$Report','$Seccion','$etapa','".$FechaIni."','$hora_ini','$hora_ter')";	
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
			f.action = "raf_ing_popup3.php?Proceso=G";
			f.submit();
			break							

		case "B":
		    if(f.etapa.value == -1)			
			{
				alert("Debe Seleccionar la Etapa")
				f.etapa.focus();
				return
			}		
			f.action = "raf_ing_popup3.php?Proceso=B";
			f.submit();
			break							

		case "E":
		    if(f.etapa.value == -1)			
			{
				alert("Debe Seleccionar la Etapa")
				f.etapa.focus();
				return
			}
			f.action = "raf_ing_popup3.php?Proceso=E";
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
  
        <table width="350" border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
         <tr align="center"> 
            <td colspan="2" class="ColorTabla02"><strong>HORNADA:</strong> <? echo substr($Hornada,-4); ?></td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr> 
            <td width="62">Etapas:</td>
            <td width="277"> <select name="etapa">
                <?
				echo '<option value="-1" selected>Seleccionar</option>';
					if($etapa == "1")
						echo '<option value="1" selected>Carga 1</option>';
					else
						echo '<option value="1">Carga 1</option>';
					if($etapa == "2")
						echo '<option value="2" selected>Fusion 1</option>';
					else
						echo '<option value="2">Fusion 1</option>';
					if($etapa == "3")
						echo '<option value="3" selected>Carga 2</option>';
					else
						echo '<option value="3">Carga 2</option>';
					if($etapa == "4")
						echo '<option value="4" selected>Fusion 2</option>';
					else
						echo '<option value="4">Fusion 2</option>';
					if($etapa == "5")
						echo '<option value="5" selected>Carga 3</option>';
					else
						echo '<option value="5">Carga 3</option>';
					if($etapa == "6")
						echo '<option value="6" selected>Fusion 3</option>';
					else
						echo '<option value="6">Fusion 3</option>';
					if($etapa == "7")
						echo '<option value="7" selected>Calenta 1</option>';
					else
						echo '<option value="7">Calenta 1</option>';
					if($etapa == "8")
						echo '<option value="8" selected>Escoreo</option>';
					else
						echo '<option value="8">Escoreo</option>';
					if($etapa == "9")
						echo '<option value="9" selected>Calenta 2</option>';
					else
						echo '<option value="9">Calenta 2</option>';
					if($etapa == "10")
						echo '<option value="10" selected>Reduccion</option>';
					else
						echo '<option value="10">Reduccion</option>';
					if($etapa == "11")
						echo '<option value="11" selected>Calenta 3</option>';
					else
						echo '<option value="11">Calenta 3</option>';
					if($etapa == "12")
						echo '<option value="12"selected>Moldeo</option>';
					else
						echo '<option value="12">Moldeo</option>';
					if($etapa == "13")
						echo '<option value="13" selected>Vac. Sell.</option>';
					else
						echo '<option value="13">Vac. Sell.</option>';
			?>
              </select> <input type="button" name="BtnOk2" size="20" style="width:70px" value="Buscar" onClick="Proceso('B');"> 
            </td>
          </tr>
          <tr>
            <td>Fecha:</td>
            <td><select name="Dia" style="width:50px;">
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
              </select>
                <select name="Mes" style="width:90px;">
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
                </select>
                <select name="Ano">
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
          <tr align="center">
            <td height="30" colspan="2"><input type="button" name="BtnOk" size="20" style="width:70px" value="Grabar" onClick="Proceso('G');">
              <input type="button" name="BtnOk22" size="20" style="width:70px" value="Eliminar" onClick="Proceso('E');">
              <input type="button" name="BtnSalir" size="20"  style="width:70px" value="Salir" onClick="self.close()"></td>
          </tr>
        </table>
</form>
</body>
</html>
