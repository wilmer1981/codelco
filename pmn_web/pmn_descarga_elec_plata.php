<?php
	$CodigoDeSistema = 6;
	$CodigoDePantalla = 10;
	include("../principal/conectar_pmn_web.php");
	//include('funciones/pmn_funciones.php'); 
	if(isset($AElect2))
	{
		$Ano=$AElect2;
		$Mes=$MElect2;
		$Dia=$DElect2;
	}
	if ($VerElect2=="O")
	{
		$Grupo="";
		$HorasProceso="";
		//$NumElectrolisis="";
		$JefeTurno="";
		$Operador="";
		$Obs="";
		$Kwh="";
		$CantOrejas="";
		$PesoResto="";
		$PesoCrudo="";
		$Humedad="";
		$NumElectrolisis=$ElectDesc;
	}
	if ($MostrarElect2 == "S")
	{
		$Ano=$AElect2;
		$Mes=$MElect2;
		$Dia=$DElect2;
		if ($VerElect2=="S")
		{
			$Ano=$AElect2;
			$Mes=$MElect2;
			$Dia=$DElect2;
			$Turno=$TElect2;
			$NumElectrolisis=$NumElectrolisis2;
		}
		$Consulta = "select * from pmn_web.descarga_electrolisis_plata ";
		$Consulta.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
		$Consulta.= " and turno = '".$Turno."'";
		$Consulta.= " and num_electrolisis = '".$NumElectrolisis."'";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Row = mysqli_fetch_array($Respuesta))
		{
			$HorasProceso = $Row[hrs_proceso];
			$Kwh = $Row[kwh];
			$Obs = $Row["observacion"];
			$Operador = $Row[operador];
			$CantOrejas = $Row[cant_orejas];
			$PesoResto = $Row[peso_resto];
			$JefeTurno= $Row[jefe_turno];
			$Grupo=$Row["grupo"];
			$PesoCrudo = $Row[peso_aurifero];
			$Humedad = $Row[humedad];
		}
	}
	if (($VerElect2=="O")||($VerElect2=="S"))
	{
		$Grupo="";
		$HorasProceso="";
		//$NumElectrolisis="";
		$JefeTurno="";
		$Operador="";
		$Obs="";
		$Kwh="";
		$CantOrejas="";
		$PesoResto="";
		$PesoCrudo="";
		$Humedad = "";
	}
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function ProcesoElect2(opt)
{
	var f = document.frmPrincipalElect2;
	switch (opt)
	{
		case "G": //GRABAR
			if (f.Grupo.value == "")
			{
				alert("Debe Ingresar Grupo");
				f.Grupo.focus();
				return;
			}
			if (f.NumElectrolisis.value == "")
			{
				alert("Debe Ingresar Num. Electrolisis");
				f.NumElectrolisis.focus();
				return;
			}
			if (f.HorasProceso.value == "")
			{
				alert("Debe Ingresar Horas de Proceso");
				f.HorasProceso.focus();
				return;
			}
			if (f.Operador.value == "S")
			{
				alert("Debe seleccionar Operador");
				f.Operador.focus();
				return;
			}
			if (f.CantOrejas.value == "")
			{
				alert("Debe Ingresar Cantidad de Orejas");
				f.CantOrejas.focus();
				return;
			}
			if (f.PesoResto.value == "")
			{
				alert("Debe Ingresar Peso Resto");
				f.PesoResto.focus();
				return;
			}			
			f.action= "pmn_descarga_elec_plata01.php?Proceso=G";
	 		f.submit();
			break;
		case "M": //MODIFICAE
			f.action= "pmn_descarga_elec_plata01.php?Proceso=M";
	 		f.submit();
			break;
		case "E": //ELIMINAR
			f.action= "pmn_descarga_elec_plata01.php?Proceso=E";
	 		f.submit();
			break;
		case "C": //CANCELAR
			f.action= "pmn_descarga_elec_plata01.php?Proceso=C";
	 		f.submit();
			break;
		case "B": //CANCELAR
			var URL ="pmn_descarga_elect_plata03.php?DiaIniCon=" + f.Dia.value + "&MesIniCon=" + f.Mes.value + "&AnoIniCon=" + f.Ano.value + "&DiaFinCon=" + f.Dia.value + "&MesFinCon=" + f.Mes.value + "&AnoFinCon=" + f.Ano.value;
			window.open(URL,"","top=120,left=30,width=700,height=350,menubar=no,resizable=yes,scrollbars=yes");
			//f.action= "pmn_descarga_elec_plata.php?";
	 		//f.submit();
			break;
		case "S": //SALIR
			f.action= "../principal/sistemas_usuario.php?CodSistema=6&Nivel=1&CodPantalla=104";
	 		f.submit();
			break;
		case "Ver":
			var URL = "pmn_descarga_elect_plata02.php?Electrolisis="+f.NumElectrolisis.value;
			window.open(URL,"","top=120,left=30,width=700,height=350,menubar=no,resizable=yes,scrollbars=yes");
			break;
	
	}
}
function TeclaPulsada1Elect2(salto) 
{ 
	var f = document.frmPrincipalElect2;
	var teclaCodigo = event.keyCode; 
	//alert (teclaCodigo);	
	if (teclaCodigo == 13)
	{		
		eval("f." + salto + ".focus();");
	}
}

function TeclaPulsada2Elect2(salto) 
{ 
	var f = document.frmPrincipalElect2;
	var teclaCodigo = event.keyCode; 
	//alert (teclaCodigo);	
	if (teclaCodigo == 0)
	{		
		eval("f." + salto + ".focus();");
	}
}

</script>

</head>

<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0" >
<form name="frmPrincipalElect2" method="post" action="">
  <table width="98%" height="330" border="0" class="TituloCabeceraOz">
    <tr>
    <td align="center" valign="top"><table width="100%" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="148" height="30" class="titulo_azul">Fecha:</td>
            <td colspan="2"> 
              <?php 
				if ($VerElect2=="O")
				{
					$Ano=$AElect2;
					$Mes=$MElect2;
					$Dia=$DElect2;
				}
				if (($MostrarElect2 == "S")||($VerElect2=="O"))
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
            <td>&nbsp;</td>
            <td width="120"><input name="ver" type="button" style="width:70" value="Consultar" onClick="ProcesoElect2('B');"> 
            </td>
            <td width="134">&nbsp;</td>
          </tr>
          <tr> 
            <td class="titulo_azul">Grupo:</td>
			<?php
				if ($MostrarElect2 != "S")
				{
			?>	
            	<td colspan="2"><input name="Grupo" type="text" id="Grupo" onKeyDown="TeclaPulsada1Elect2('Turno')" value="<?php echo $Grupo;?>"></td>
           		<td class="titulo_azul">Turno: </td>
            	<td colspan="2"> 
            <?php
				}
				else
				{
			?>
            	<td colspan="2"><input name="Grupo" type="text" id="Grupo" onKeyDown="TeclaPulsada1Elect2('HorasProceso2')" value="<?php echo $Grupo;?>"></td>
           		<td class="titulo_azul">Turno: </td>
            	<td colspan="2"> 
			<?php
				}
			?>	
		
              <?php
				if ($MostrarElect2 == "S")
				{
					$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase = '1' and cod_subclase = '".$Turno."'";
					$Respuesta = mysqli_query($link, $Consulta);
					if ($Row = mysqli_fetch_array($Respuesta))
					{
						echo strtoupper($Row["nombre_subclase"])."<input type='hidden' name='Turno' value='".$Row["cod_subclase"]."'>";
					}
				}
				else
				{
					echo "<select name='Turno' id='Turno'  style='width:50px'>\n";
					$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase = 1 and cod_subclase not in('2') order by cod_subclase";
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
          </tr>
          <tr> 
            <td width="148" class="titulo_azul">Horas de Proceso:</td>
            <td colspan="2"><input name="HorasProceso" type="text" id="HorasProceso2" onKeyDown="TeclaPulsada1Elect2('NumElectrolisis')" value="<?php echo number_format($HorasProceso,2,',','.');?>"></td>
            <td width="105" class="titulo_azul">Num. Electrolisis:</td>
            <td><input name="NumElectrolisis" type="text" id="NumElectrolisis3" onKeyDown="TeclaPulsada1Elect2('JefeTurno')" value="<?php echo $NumElectrolisis;?>"></td>
            <td><input name="BtnElectrisis" type="button" id="BtnElectrisis" value="Ver Elect" onClick="ProcesoElect2('Ver');" ></td>
          </tr>
          <tr> 
            <td class="titulo_azul">Jefe Turno</td>
            <td colspan="2"><select name="JefeTurno" id="JefeTurno" onChange="TeclaPulsada1Elect2('Operador')" style="width:220px">
              <option value="S">Seleccionar</option>
              <?php
				//LlenaCombosPersonalPmn(&$JefeTurno,'1');
				$sql = "select t2.rut, t2.apellido_paterno, t2.apellido_materno, t2.nombres ";
				$sql.= " from proyecto_modernizacion.sub_clase t1 inner join  proyecto_modernizacion.funcionarios t2 ";
				$sql.= " on t1.nombre_subclase = t2.rut ";
				$sql.= " where t1.cod_clase = '6015' and t1.valor_subclase1='1' ";
				$sql.= " order by t2.apellido_paterno, t2.apellido_materno, t2.nombres";
				$resultComboPMN = mysqli_query($link, $sql);
				while ($rowComboPMN = mysqli_fetch_array($resultComboPMN))
				{
					$Nombre = ucwords(strtolower($rowComboPMN["apellido_paterno"]." ".$rowComboPMN["apellido_materno"]." ".$rowComboPMN["nombres"]));
					if ($rowComboPMN[rut] == $JefeTurno)
					{
						echo "<option selected value='".$rowComboPMN[rut]."'>".$Nombre."</option>\n";
					}
					else
					{
						echo "<option value='".$rowComboPMN[rut]."'>".$Nombre."</option>\n";
					}
				}
				?>
            </select></td>
            <td class="titulo_azul">Operador Elec AG.:</td>
            <td colspan="2"><select name="Operador" onChange="TeclaPulsada1Elect2('Obs')" style="width:220px">
              <option value="S">Seleccionar</option>
              <?php
				//LlenaCombosPersonalPmn(&$Operador,'5');
				$sql = "select t2.rut, t2.apellido_paterno, t2.apellido_materno, t2.nombres ";
				$sql.= " from proyecto_modernizacion.sub_clase t1 inner join  proyecto_modernizacion.funcionarios t2 ";
				$sql.= " on t1.nombre_subclase = t2.rut ";
				$sql.= " where t1.cod_clase = '6015' and t1.valor_subclase1='5' ";
				$sql.= " order by t2.apellido_paterno, t2.apellido_materno, t2.nombres";
				$resultComboPMN = mysqli_query($link, $sql);
				while ($rowComboPMN = mysqli_fetch_array($resultComboPMN))
				{
					$Nombre = ucwords(strtolower($rowComboPMN["apellido_paterno"]." ".$rowComboPMN["apellido_materno"]." ".$rowComboPMN["nombres"]));
					if ($rowComboPMN[rut] == $Operador)
					{
						echo "<option selected value='".$rowComboPMN[rut]."'>".$Nombre."</option>\n";
					}
					else
					{
						echo "<option value='".$rowComboPMN[rut]."'>".$Nombre."</option>\n";
					}
				}
				?>
            </select></td>
          </tr>
          <tr> 
            <td class="titulo_azul">Observaci&oacute;n:</td>
            <td colspan="5"><input name="Obs" type="text" id="Obs" onKeyDown="TeclaPulsada1Elect2('Kwh')" value="<?php echo $Obs;?>" size="80" maxlength="80"></td>
          </tr>
          <tr> 
            <td class="titulo_azul">Consumo E.E. (amp-hr):</td>
            <td width="127"><input name="Kwh" type="text" id="CantOrejas3" onKeyDown="SoloNumeros(true,this)" value="<?php echo number_format($Kwh,2,',','.');?>" size="20" maxlength="20"></td>
            <td width="88" class="titulo_azul">Unidad Restos :</td>
            <td><input name="CantOrejas" type="text" id="CantOrejas2" onKeyDown="TeclaPulsada1Elect2('PesoResto')" value="<?php echo $CantOrejas;?>" size="20" maxlength="20"></td>
            <td class="titulo_azul">Peso Resto:</td>
            <td><input name="PesoResto" type="text" id="PesoResto" onKeyDown="SoloNumeros(true,this)" value="<?php echo number_format($PesoResto,2,',','.');?>" size="15" maxlength="15"></td>
          </tr>
          <tr>
            <td class="titulo_azul">Peso Aurifero Crudo</td>
            <td><input name="PesoCrudo" type="text" id="PesoCrudo" onKeyDown="SoloNumeros(true,this)" size="15" maxlength="15" value="<?php echo number_format($PesoCrudo,2,',','.') ?>"></td>
            <td class="titulo_azul">&nbsp;</td>
            <td><input name="Humedad" type="hidden" id="Humedad" onKeyDown="TeclaPulsada1Elect2('BtnGrabar')" size="15" maxlength="15" value="<?php echo "0";?>"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <br> 
        <table width="761" border="0" class="TablaInterior">
          <tr align="center" valign="middle"> 
            <td width="726" colspan="7"> <input name="BtnGrabar" type="button" id="BtnGrabar" value="Grabar" style="width:60px;" onClick="ProcesoElect2('G');"> 
              <input name="BtnModificar" type="button" id="BtnModificar" value="Modificar" style="width:60px;" onClick="ProcesoElect2('M');"> 
              <input name="BtnEliminar" type="button" id="BtnEliminar" value="Eliminar" style="width:60px;" onClick="ProcesoElect2('E');"> 
            <input name="BtnCancelar" type="button" id="BtnCancelar" value="Cancelar" style="width:60px;" onClick="ProcesoElect2('C');"></td>
          </tr>
        </table>
        <br> 
        <table width="761" border="1" cellpadding="3" cellspacing="0" class="TablaDetalle">
          <tr align="center" valign="middle" class="TituloCabeceraAzul"> 
            <td width="45" height="15">&nbsp;</td>
            <td width="60"><strong>Turno</strong></td>
            <td width="83"><strong>Grupo</strong></td>
            <td width="104"><strong>Num. Elec.</strong></td>
            <td width="111"><strong>Horas Proceso</strong></td>
            <td width="82"><strong>Amp-hr</strong></td>
            <td width="101"><strong>Cant. Orejas</strong></td>
            <td width="108"><strong>Peso Resto</strong></td>
            <td width="108"><strong>Peso Aurifero</strong></td>
            <td width="108"><strong>Humedad</strong></td>
          </tr>
          <?php	
	
	$Consulta = "select * from pmn_web.descarga_electrolisis_plata ";
	$Consulta.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";	
	$Consulta.= " and num_electrolisis = '".$NumElectrolisis."'";
	$Consulta.= " order by turno, num_electrolisis, grupo";
	$Respuesta = mysqli_query($link, $Consulta);
	$i=1;
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		echo "<tr>\n";
		echo "<td align='center'><input type='checkbox' name='ChkTurno[".$i."]' class='SinBorde' value='".$Row[turno]."'>\n";
		echo "<input type='hidden' name='ChkGrupo[".$i."]' value='".$Row["grupo"]."'>\n";
		echo "<input type='hidden' name='ChkNumElec[".$i."]' value='".$Row[num_electrolisis]."'>\n";
		echo "</td>\n";
		$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase = 1 and cod_subclase = ".$Row[turno];
		$Resp2 = mysqli_query($link, $Consulta);
		if ($Row2 = mysqli_fetch_array($Resp2))
		{
			echo "<td align='center'>".strtoupper($Row2["nombre_subclase"])."</td>\n";
		}
		else
		{
			echo "<td>&nbsp;</td>\n";
		}
		echo "<td align='center'>".$Row["grupo"]."</td>\n";
		echo "<td align='right'>".$Row[num_electrolisis]."</td>\n";
		echo "<td align='right'>".number_format($Row[hrs_proceso],4,",","")."</td>\n";
		echo "<td align='right'>".number_format($Row[kwh],4,",","")."</td>\n";
		echo "<td align='right'>".$Row[cant_orejas]."</td>\n";
		echo "<td align='right'>".number_format($Row[peso_resto],4,",","")."</td>\n";
		echo "<td align='right'>".number_format($Row[peso_aurifero],4,",","")."</td>\n";
		echo "<td align='right'>".number_format($Row[humedad],4,",","")."</td>\n";				
		echo "</tr>\n";
		$i++;
	}
?>
      </table></td>
  </tr>
</table>
</form>
</body>
</html>
