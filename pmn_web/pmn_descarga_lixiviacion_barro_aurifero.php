<?php
	$CodigoDeSistema = 6;
	$CodigoDePantalla = 13;
	include("../principal/conectar_pmn_web.php");
	if ($Ver == "S")
	{
		$AnoLixiA = $A;
		$MesLixiA = $M;
		$DiaLixiA = $D;
		
		$PesoSeco = "";
		$Muestra01 = "";
		$Obs = "";
		$Operador = "";
		$CmbCorrelativo = "";
		$Turno = "";
		$Electrolisis = "";		
	}
	
	if ($Mostrar == "S")
	{
		$Consulta = "select * from pmn_web.descarga_lixiviacion_barro_aurifero ";
		$Consulta.= " where fecha = '".$AnoLixiA."-".$MesLixiA."-".$DiaLixiA."'";
		$Consulta.= " and turno = '".$Turno."'";
		$Consulta.= " and num_electrolisis = '".$Electrolisis."'";
		$Consulta.= " and correlativo = '".$CmbCorrelativo."'";
		//echo $Consulta."<br>";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Row = mysqli_fetch_array($Respuesta))
		{
			$Hora = substr($HoraAux,0,2);
			$Minuto = substr($HoraAux,3,2);
			$PesoSeco = $Row[peso_seco];
			$Muestra01 = $Row[muestra01];
			$Obs = $Row["observacion"];
			$Operador = $Row[operador];
			$CmbCorrelativo = $Row[correlativo];
		}
	}
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function ProcesoLixi2(opt)
{
	var f = document.frmBarroAuriDesc;
	switch (opt)
	{
		case "G": //GRABAR
			if (f.Electrolisis.value == "")
			{
				alert("Debe Ingresar Electrolisis");
				f.Electrolisis.focus();
				return;
			}		
			if (f.PesoSeco.value == "")
			{
				alert("Debe Ingresar Peso Seco");
				f.PesoSeco.focus();
				return;
			}
			if (f.Muestra01.value == "")
			{
				alert("Debe Ingresar Muestra");
				f.Muestra01.focus();
				return;
			}
			if (f.Operador.value == "S")
			{
				alert("Debe seleccionar Operador");
				f.Operador.focus();
				return;
			}
			f.action= "pmn_descarga_lixiviacion_barro_aurifero01.php?Proceso=G";
	 		f.submit();
			break;
		case "M": //MODIFICAE
			f.action= "pmn_descarga_lixiviacion_barro_aurifero01.php?Proceso=M";
	 		f.submit();
			break;
		case "E": //ELIMINAR
			f.action= "pmn_descarga_lixiviacion_barro_aurifero01.php?Proceso=E";
	 		f.submit();
			break;
		case "C": //CANCELAR
			f.action= "pmn_descarga_lixiviacion_barro_aurifero01.php?Proceso=C";
	 		f.submit();
			break;
		case "B":
			var URL = "pmn_descarga_lixiviacion_barro_aurifero03.php?DiaIniCon=" + f.DiaLixiA.value + "&MesIniCon=" + f.MesLixiA.value + "&AnoIniCon=" + f.AnoLixiA.value + "&DiaFinCon=" + f.DiaLixiA.value + "&MesFinCon=" + f.MesLixiA.value + "&AnoFinCon=" + f.AnoLixiA.value;
			window.open(URL,"","top=120,left=30,width=670,height=350,menubar=no,resizable=yes,scrollbars=yes");
			break;
		case "S": //SALIR
			f.action= "../principal/sistemas_usuario.php?CodSistema=6&Nivel=1&CodPantalla=106";
	 		f.submit();
			break;	
	}
}
/********************/
function RecargaLixi2()
{
	var f = document.frmBarroAuriDesc;
	
	f.action = "pmn_descarga_lixiviacion_barro_aurifero01.php?Proceso=R";
	f.submit();
}
function TeclaPulsada1Lixi2(salto) 
{ 
	var f = document.frmBarroAuriDesc;
	var teclaCodigo = event.keyCode; 
		
	if (teclaCodigo == 13)
	{		
		eval("f." + salto + ".focus();");
	}
}
function TeclaPulsada2Lixi2(salto) 
{ 
	var f = document.frmBarroAuriDesc;
	var teclaCodigo = event.keyCode; 
	
	if (teclaCodigo == 0)
	{		
		eval("f." + salto + ".focus();");
	}
}


</script>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0"> 
<form name="frmBarroAuriDesc" method="post" action="">
<?php //include("../principal/encabezado.php")?>
  <table width="98%" height="330" border="0" class="TituloCabeceraOz">
    <tr>
<?php
	echo '<input type="hidden" name="Opc" value="'.$Opc.'">';	
	if ($Opc == '')
	{
		echo '<input type="hidden" name="CorrelativoAux" value="'.$CmbCorrelativo.'">';
		echo '<input type="hidden" name="ElectrolisisAux" value="'.$Electrolisis.'">';
	}
	else
	{
		echo '<input type="hidden" name="CorrelativoAux" value="'.$CorrelativoAux.'">';
		echo '<input type="hidden" name="ElectrolisisAux" value="'.$ElectrolisisAux.'">';	
	}
	
?>
		
		
      <td align="center" valign="top"><table width="100%" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="106" height="30" class="titulo_azul">Fecha:</td>
            <td colspan="2"> 
              <?php 
				if ($Mostrar == "S")
				{
					echo "<input type='hidden' name='DiaLixiA' value='".$DiaLixiA."'>\n";
					echo "<input type='hidden' name='MesLixiA' value='".$MesLixiA."'>\n";
					echo "<input type='hidden' name='AnoLixiA' value='".$AnoLixiA."'>\n";
					printf("%'02d",$DiaLixiA);
					echo "-";
					printf("%'02d",$MesLixiA);
					echo "-";
					printf("%'04d",$AnoLixiA);
				}
				else
				{
					echo "<select name='DiaLixiA' style='width:50px'>\n";				
					for ($i=1;$i<=31;$i++)
					{
						if (isset($DiaLixiA))
						{
							if ($i == $DiaLixiA)
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
				  echo "</select> <select name='MesLixiA' style='width:100px'>\n";
					for ($i=1;$i<=12;$i++)
					{
						if (isset($MesLixiA))
						{
							if ($i == $MesLixiA)
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
				  echo "</select> <select name='AnoLixiA' style='width:60px'>\n";
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (isset($AnoLixiA))
						{
							if ($i == $AnoLixiA)
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
            <td><input name="ver" type="button" style="width:70" value="Consultar" onClick="ProcesoLixi2('B');"></td>
            <td width="32">&nbsp; </td>
            <td width="231">&nbsp;</td>
          </tr>
          <tr> 
            <td width="106" class="titulo_azul">Turno: </td>
            <td width="38"> 
              <?php
				if ($Mostrar == "S")
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
					echo "<select name='Turno' style='width:50px'>\n";
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
            <td width="193">&nbsp;</td>
            <td width="122" class="titulo_azul">Hora:</td>
            <td colspan="2"><select name="Hora" id="Hora">
                <?php
				for ($i=0;$i<=23;$i++)
				{
					if (isset($Hora))
					{
						if ($i == $Hora)
							echo "<option selected value='".$i."'>".$i."</option>";
						else
							echo "<option value='".$i."'>".$i."</option>";
					}
					else
					{
						if ($i == intval(date("H")))
							echo "<option selected value='".$i."'>".$i."</option>";
						else
							echo "<option value='".$i."'>".$i."</option>";
					}
				}
			?>
              </select>
              : 
              <select name="Minuto" id="Minuto">
                <?php
				for ($i=0;$i<=59;$i++)
				{
					if (isset($Minuto))
					{
						if ($i == $Minuto)
							echo "<option selected value='".$i."'>".$i."</option>";
						else
							echo "<option value='".$i."'>".$i."</option>";
					}
					else
					{
						if ($i == intval(date("i")))
							echo "<option selected value='".$i."'>".$i."</option>";
						else
							echo "<option value='".$i."'>".$i."</option>";
					}
				}
			?>
              </select></td>
          </tr>
          <tr> 
            <td class="titulo_azul">Correlativo</td>
            <td colspan="2">
			<input name="CmbCorrelativo" type="text" id="CmbCorrelativo" onKeyDown="TeclaPulsada1('Electrolisis')" size='10' onBlur="RecargaLixi2()" value= "<?php echo $CmbCorrelativo;?>"></td>
            <td class="titulo_azul">Electrolisis</td>
            <td colspan="2"> 
              
			<input name="Electrolisis" type="text" id="Electrolisis"   value="<?php echo $Electrolisis;?>"></td>
          </tr>
          <tr> 
            <td class="titulo_azul">Peso Seco:</td>
            <td colspan="2"><input name="PesoSeco" type="text" id="PesoSeco2" onKeyDown="SoloNumeros(true,this)" value="<?php echo number_format($PesoSeco,4,',','');?>"></td>
            <td class="titulo_azul">Operador:</td>
            <td colspan="2"><select name="Operador" onChange="TeclaPulsada2Lixi2('Muestra01')" style="width:220px">
                <option value="S">Seleccionar</option>
                <?php
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
            <td class="titulo_azul">Muestra:</td>
            <td colspan="2"><input name="Muestra01" type="text" id="Muestra01" onKeyDown="TeclaPulsada1Lixi2('Obs')" value="<?php echo number_format($Muestra01,4,',','');?>"></td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr> 
            <td class="titulo_azul">Observaci&oacute;n:</td>
            <td colspan="5"><input name="Obs" type="text" id="Obs2" onKeyDown="TeclaPulsada1Lixi2('BtnGrabar')" value="<?php echo $Obs;?>" size="80" maxlength="80"></td>
          </tr>
        </table>
        <br>
        <table width="100%" border="0" class="TablaInterior">
          <tr align="center" valign="middle"> 
            <td colspan="7"> <input name="BtnGrabar" type="button" id="BtnGrabar" value="Grabar" style="width:60px;" onClick="ProcesoLixi2('G');"> 
              <input name="BtnModificar" type="button" id="BtnModificar" value="Modificar" style="width:60px;" onClick="ProcesoLixi2('M');"> 
              <input name="BtnEliminar" type="button" id="BtnEliminar" value="Eliminar" style="width:60px;" onClick="ProcesoLixi2('E');"> 
            <input name="BtnCancelar" type="button" id="BtnCancelar" value="Cancelar" style="width:60px;" onClick="ProcesoLixi2('C');"></td>
          </tr>
        </table>
        <br>
        <table width="761" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
          <tr class="TituloCabeceraAzul"> 
            <td width="45" height="15" >&nbsp;</td>
            <td width="81" align="center"><strong>Electrolisis</strong></td>
            <td width="90" align="center"><strong>Turno</strong></td>
            <td width="100" align="center"><strong>Correlativo</strong></td>
            <td width="129" align="center"><strong>Peso Seco</strong></td>
            <td width="93" align="center"><strong>Muestra </strong></td>
            <td width="207" align="center"><strong>Operador</strong></td>
          </tr>
          <?php	
	$Consulta = "select * from pmn_web.descarga_lixiviacion_barro_aurifero ";
	$Consulta.= " where fecha = '".$AnoLixiA."-".$MesLixiA."-".$DiaLixiA."'";	  
	$Consulta.= " order by turno, hora";
	//echo $Consulta."<br>";
	$Respuesta = mysqli_query($link, $Consulta);
	$i=1;
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		$Elect="";
		echo "<tr>\n";
		echo "<td align='center'><input type='checkbox' class='SinBorde' name='ChkTurno[".$i."]' value='".$Row[turno]."'>\n";
		echo "<input type='hidden' name='ChkHora[".$i."]' value='".$Row[hora]."'>\n";
		echo "<input type='hidden' name='ChkPesoSeco[".$i."]' value='".$Row[PesoSeco]."'>\n";
		echo "<input type='hidden' name='ChkMuestra01[".$i."]' value='".$Row[muestra01]."'>\n";
		echo "<input type='hidden' name='ChkMuestra02[".$i."]' value='".$Row[muestra02]."'>\n";
		echo "<input type='hidden' name='ChkCorrelativo[".$i."]' value='".$Row[correlativo]."'>\n";
		echo "<input type='hidden' name='ChkElectrolisis[".$i."]' value='".$Row[num_electrolisis]."'>\n";						
		echo "</td>\n";
		
		echo "<td align='center'>".$Row[num_electrolisis]."</td>\n";		
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
		
		echo "<td align='center'>".$Row[correlativo]."</td>\n";

		echo "<td align='center'>".number_format($Row[peso_seco],4,",","")."</td>\n";
		echo "<td align='center'>".number_format($Row[muestra01],4,",","")."</td>\n";
		
		$consulta = "select apellido_paterno, apellido_materno, nombres ";
		$consulta.= " from proyecto_modernizacion.funcionarios t2 ";
		$consulta.= " where rut = '".$Row[operador]."'";
		$rs = mysqli_query($link, $consulta);
		$row = mysqli_fetch_array($rs);
		echo "<td align='left'>".ucwords(strtolower($row["apellido_paterno"]." ".$row["apellido_materno"]." ".$row["nombres"]))."</td>\n";		
		echo "</tr>\n";
		$i++;
	}
?>
      </table> </td>
	</tr>
</table>
<?php //include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
