<?php
	
	$CodigoDeSistema = 6;
	$CodigoDePantalla = 9;
	include("../principal/conectar_pmn_web.php");
	//echo $Mostrar."<br>";
	if (($Mostrar == "S")|| ($Mostrar =='C'))
	{
		
		if ($Ver=="S")
		{
			$Año=$A;
			$Mes=$M;
			$Dia=$D;
		}
		if ($Ver=="O")
		{
			$Año=$A;
			$Mes=$M;
			$Dia=$D;
			$TxtElectrolisis=$E;
		}
		$Consulta = "select * from pmn_web.produccion_nitrato_ag ";
		$Consulta.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
		$Consulta.= " and turno = '".$Turno."'";
		if ($Mostrar!="C")
		{
			$Consulta.= " and num_electrolisis = '".$TxtElectrolisis."'";
		}
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Row = mysqli_fetch_array($Respuesta))
		{
			$TxtElectrolisis = $Row[num_electrolisis];
			$TxtStock	=	$Row[stock_disp];		
		}
	}
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "O": //GRABAR
			if (f.TxtElectrolisis.value == "")
			{
				alert("Debe Ingresar Num. Electrolisis");
				f.TxtElectrolisis.focus();
				return;
			}
			if (f.TxtStock.value == "")
			{
				alert("Debe Ingresar Stock");
				f.TxtStock.focus();
				return;
			}
			f.action= "pmn_produccion_de_nitrato_de_ag01.php?Proceso=O";
	 		f.submit();
			break;
		case "G": //GRABAR
			f.action= "pmn_produccion_de_nitrato_de_ag01.php?Proceso=G";
	 		f.submit();
			break;	
		case "M": //MODIFICAE
			f.action= "pmn_produccion_de_nitrato_de_ag01.php?Proceso=M";
	 		f.submit();
			break;
		case "E": //ELIMINAR datos GRILLA
			f.action= "pmn_produccion_de_nitrato_de_ag01.php?Proceso=E";
	 		f.submit();
			break;
		case "E2"://Elimina Todo
			var mensaje = confirm("¿Seguro que desea Eliminar?");
			if (mensaje==true)
			{
				f.action= "pmn_produccion_de_nitrato_de_ag01.php?Proceso=E2";
		 		f.submit();
			}
			else
			{
				return;
			}
		break;
		case "C": //CANCELAR
			f.action= "pmn_produccion_de_nitrato_de_ag01.php?Proceso=C";
	 		f.submit();
			break;
		case "B"://Consultar
			var URL ="pmn_produccion_de_nitrato_de_ag03.php?DiaIniCon=" + f.Dia.value + "&MesIniCon=" + f.Mes.value + "&AnoIniCon=" + f.Ano.value + "&DiaFinCon=" + f.Dia.value + "&MesFinCon=" + f.Mes.value + "&AnoFinCon=" + f.Ano.value;
			window.open(URL,"","top=120,left=30,width=700,height=350,menubar=no,resizable=yes,scrollbars=yes");
			//f.action= "pmn_produccion_de_nitrato_de_ag.php?Mostrar=C";
	 		//f.submit();
			break;
		case "S": //SALIR
			f.action= "../principal/sistemas_usuario.php?CodSistema=6&Nivel=1&CodPantalla=104";
	 		f.submit();
			break;
		case "Ver":
			var URL = "pmn_produccion_de_nitrato_de_ag02.php?Electrolisis="+f.TxtElectrolisis.value;
			window.open(URL,"","top=120,left=30,width=700,height=350,menubar=no,resizable=yes,scrollbars=yes");
			//f.action="pmn_carga_elect_plata02.php?Electrolisis="+f.NumElectrolisis.value;
	 		//f.submit();
			break;
	
	}
}
</script>
</head>
<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="frmPrincipal" method="post" action="">
<?php include("../principal/encabezado.php")?>
  <table width="770" border="0" class="TablaPrincipal">
    <tr>
		
      <td width="762"><table width="761" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="100" height="30">Fecha:</td>
            <td colspan="2"> 
              <?php 
				if (($Mostrar == "S") || ($Mostrar == "C"))
				{
					echo "<input type='hidden' name='Dia' value='".$Dia."'>\n";
					echo "<input type='hidden' name='Mes' value='".$Mes."'>\n";
					echo "<input type='hidden' name='Ano' value='".$Ano."'>\n";
					printf("%'02d",$Dia);
					echo "-";
					printf("%'02d",$Mes);
					echo "-";
					printf("%'04d",$Ano);
				}
				else
				{
					echo "<select name='Dia' style='width:50px'>\n";				
					for ($i=1;$i<=31;$i++)
					{
						if (isset($Dia))
						{
							if ($i == $Dia)
								echo "<option selected value='".$i."'>".$i."</option>\n";
							else	echo "<option value='".$i."'>".$i."</option>\n";
						}
						else
						{
							if ($i == $DiaActual)
								echo "<option selected value='".$i."'>".$i."</option>\n";
							else	echo "<option value='".$i."'>".$i."</option>\n";
						}
					}
				  echo "</select> <select name='Mes' style='width:100px'>\n";
					for ($i=1;$i<=12;$i++)
					{
						if (isset($Mes))
						{
							if ($i == $Mes)
								echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
							else	echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
						}
						else
						{
							if ($i == $MesActual)
								echo "<option selected value='".$i."'>".$Meses[$i-1]."</option>\n";
							else	echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
						}
					}
				  echo "</select> <select name='Ano' style='width:60px'>\n";
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (isset($Ano))
						{
							if ($i == $Ano)
								echo "<option selected value='".$i."'>".$i."</option>\n";
							else	echo "<option value='".$i."'>".$i."</option>\n";
						}
						else
						{
							if ($i == $AnoActual)
								echo "<option selected value='".$i."'>".$i."</option>\n";
							else	echo "<option value='".$i."'>".$i."</option>\n";
						}
					}
					echo "</select>\n";
				}
			?>
            </td>
            <td>Turno: </td>
            <td width="101"> 
              <?php
				if (($Mostrar == "S") || ($Mostrar == 'C'))
				{
					$Consulta = "select * from sub_clase where cod_clase = '1' and cod_subclase = '".$Turno."'";
					$Respuesta = mysqli_query($link, $Consulta);
					if ($Row = mysqli_fetch_array($Respuesta))
					{
						echo strtoupper($Row["nombre_subclase"])."<input type='hidden' name='Turno' value='".$Row["cod_subclase"]."'>";
					}
				}
				else
				{
					echo "<select name='Turno' style='width:50px'>\n";
					$Consulta = "select * from sub_clase where cod_clase = 1";
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Row = mysqli_fetch_array($Respuesta))
					{
						if ($Row["cod_subclase"] == $Turno)
							echo "<option selected value='".strtoupper($Row["cod_subclase"])."'>".strtoupper($Row["nombre_subclase"])."</option>";
						else 	echo "<option value='".strtoupper($Row["cod_subclase"])."'>".strtoupper($Row["nombre_subclase"])."</option>";
					}
					echo "</select>\n";
				}
			?>
            </td>
            <td width="150"><input name="BtnConsultar" type="button" id="BtnConsultar" style="width:70" onClick="Proceso('B');" value="Consultar"></td>
          </tr>
          <tr> 
            <td width="100">#Electrolisis:</td>
            <td width="127"> 
              <?php
			 if (($Mostrar == "S") || ($Mostrar == "C"))
			 {
			 	echo $TxtElectrolisis."<input name='TxtElectrolisis' type='hidden'  value='$TxtElectrolisis' size='20' maxlength='20'></td>";
			 }
			 else
			 {
			 	 echo "<input name='TxtElectrolisis' type='text'  value='$TxtElectrolisis' size='20' maxlength='20'></td>";
             }
			?>
            <td width="111"><input name="BtnElectrisis" type="button" id="BtnElectrisis" value="Ver Elect" onClick="Proceso('Ver');" > 
            <td width="133">Stock Disp Preparacion</td>
            <?php
			if (($Mostrar == "S") || ($Mostrar == "C"))
			{
				echo "<td>".$TxtStock."<input name='TxtStock' size='20' type='hidden'  value='$TxtStock'></td>";
			}
			else
			{
				echo "<td><input name='TxtStock' type='text' size='20' value='$TxtStock'></td>";
			}
			if (($Mostrar != "S") && ($Mostrar != "C"))
			{ 
			 echo "<td><input name='BtnOk' type='button'  value='Ok'  onClick=\"Proceso('O');\"></td>";
          	}
			?>
          </tr>
        </table>
        <br>
        <table width="759" border="0" class="TablaInterior">
          <tr> 
            <td width="750"><div align="center"> 
                <input name="BtnEliminar2" type="button" id="BtnEliminar2" value="Eliminar" style="width:60px;" onClick="Proceso('E2');">
                <input name="BtnCancelar" type="button" id="BtnCancelar" value="Cancelar" style="width:60px;" onClick="Proceso('C');">
                <input name="BtnSalir2" type="button" id="BtnSalir2" value="Salir" style="width:60px;" onClick="Proceso('S');">
              </div></td>
          </tr>
        </table>
        <br>
        <table width="761" border="0" class="TablaInterior">
          <tr> 
            <td width="21">&nbsp;</td>
            <td width="90">Peso Cristales:</td>
            <td width="133"><input name="PesoCristales" type="text" id="PesoCristales" value="<?php echo $PesoCristales;?>" size="15" maxlength="15"></td>
            <td width="94">Volumen Acido:</td>
            <td width="85"><input name="VolumenAcido" type="text" id="VolumenAcido" value="<?php echo $VolumenAcido;?>" size="15" maxlength="15"></td>
            <td width="94">Volumen Final:</td>
            <td width="127"><input name="VolumenFinal" type="text" id="VolumenFinal" value="<?php echo $VolumenFinal; ?>" size="20" maxlength="20"></td>
            <td width="80" align="center" valign="middle">&nbsp; </td>
          </tr>
        </table>
        &nbsp; <br>
        <table width="761" border="0" cellpadding="0" cellspacing="0" class="TablaDetalle">
          <tr class="ColorTabla01"> 
            <td width="26" height="15">&nbsp;</td>
            <td width="102"><div align="left"><strong>Turno</strong></div></td>
            <td width="155"><div align="left"><strong>Num. Elec.</strong></div></td>
            <td width="156"><div align="left"><strong>Peso Cristales</strong></div></td>
            <td width="134"> <div align="left"><strong>Volumen Acido</strong></div></td>
            <td width="185"><strong>Volumen Final</strong></td>
          </tr>
          <?php	
	$Consulta = "select * from pmn_web.produccion_nitrato_ag ";
	$Consulta.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";	  
	$Consulta.= " order by turno,num_electrolisis";
	$Respuesta = mysqli_query($link, $Consulta);
	$i=1;
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		echo "<tr>\n";
		echo "<td align='center' width='45'><input type='checkbox' name='ChkTurno[".$i."]' value='".$Row[turno]."'>\n";
		echo "<input type='hidden' name='ChkNumElec[".$i."]' value='".$Row[num_electrolisis]."'>\n";
		echo "<input type='hidden' name='ChkPeso[".$i."]' value='".$Row[peso_cristales]."'>\n";
		echo "<input type='hidden' name='ChkVolumenA[".$i."]' value='".$Row[volumen_acido_nitrico]."'>\n";
		echo "<input type='hidden' name='ChkVolumenF[".$i."]' value='".$Row[volumen_final]."'>\n";
		echo "</td>\n";
		$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase = 1 and cod_subclase = ".$Row[turno];
		$Resp2 = mysqli_query($link, $Consulta);
		if ($Row2 = mysqli_fetch_array($Resp2))
		{
			echo "<td width='85'>".strtoupper($Row2["nombre_subclase"])."</td>\n";
		}
		else
		{
			echo "<td>&nbsp;</td>\n";
		}
		echo "<td width='156'>".$Row[num_electrolisis]."</td>\n";
		echo "<td width='268' >".$Row[peso_cristales]."</td>\n";
		echo "<td width ='207'>".$Row[volumen_acido_nitrico]."</td>\n";
		echo "<td width ='207'>".$Row[volumen_final]."</td>\n";
		echo "</tr>\n";
		$i++;
	}
?>
        </table> 
        &nbsp; 
        <table width="760" border="0" class="TablaInterior">
          <tr>
            <td><div align="center">
                <input name="BtnGrabar" type="button" id="BtnGrabar3" value="Grabar" style="width:60px;" onClick="Proceso('G');">
                <input name="BtnModificar" type="button" id="BtnModificar3" value="Modificar" style="width:60px;" onClick="Proceso('M');">
                <input name="BtnEliminar" type="button" id="BtnEliminar3" value="Eliminar" style="width:60px;" onClick="Proceso('E');">
                <input name="BtnSalir" type="button" id="BtnSalir3" value="Salir" style="width:60px;" onClick="Proceso('S');">
              </div></td>
          </tr>
        </table></td>
	</tr>
</table>
<?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
