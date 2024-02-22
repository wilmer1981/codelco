<?php
	$CodigoDeSistema = 6;
	$CodigoDePantalla = 12;
	include("../principal/conectar_pmn_web.php");
	if ($Consulta == "S")
	{
		$Mostrar = "S";
		$Dia = $IdDia;
		$Mes = $IdMes;
		$Ano = $IdAno;
		$NumElectrolisis = $IdElectrolisis;
	}
	if ($Mostrar == "S")
	{
		$Consulta = "select * from pmn_web.barro_aurifero_crudo ";
		$Consulta.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
		$Consulta.= " and num_electrolisis = '".$NumElectrolisis."'";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Row = mysqli_fetch_array($Respuesta))
		{
			$Grupo = $Row["grupo"];
			$EnergiaElec = $Row[energia_elec];
			$Operador = $Row[operador];
			$Obs = $Row["observacion"];
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
		case "G": //GRABAR			
			if (f.NumElectrolisis.value == "")
			{
				alert("Debe Ingresar Num. Electrolisis");
				f.NumElectrolisis.focus();
				return;
			}
			if (f.Grupo.value == "")
			{
				alert("Debe Ingresar Grupo");
				f.Grupo.focus();
				return;
			}
			if (f.EnergiaElec.value == "")
			{
				alert("Debe Ingresar Energia Electrica");
				f.EnergiaElec.focus();
				return;
			}
			if (f.Operador.value == "S")
			{
				alert("Debe seleccionar Operador");
				f.Operador.focus();
				return;
			}		
			f.action= "pmn_barro_aurifero_crudo01.php?Proceso=G";
	 		f.submit();
			break;
		case "G2": //GRABAR DETALLE			
			if (f.Bolsa.value == "")
			{
				alert("Debe Ingresar Bolsa");
				f.Bolsa.focus();
				return;
			}
			if (f.PesoHumedo.value == "")
			{
				alert("Debe Ingresar Peso Humedo");
				f.PesoHumedo.focus();
				return;
			}
			if (f.PorcHumedad.value == "")
			{
				alert("Debe Ingresar Porcentaje de Humedad (%)");
				f.PorcHumedad.focus();
				return;
			}					
			f.action= "pmn_barro_aurifero_crudo01.php?Proceso=G2";
	 		f.submit();
			break;
		case "M2": //MODIFICAR DETALLE
			f.action= "pmn_barro_aurifero_crudo01.php?Proceso=M";
	 		f.submit();
			break;
		case "E": //ELIMINAR TODO
			var mensaje = confirm("�Seguro que desea Eliminar?");
			if (mensaje==true)
			{
				f.action= "pmn_barro_aurifero_crudo01.php?Proceso=E";
	 			f.submit();
			}
			else
			{
				return;
			}
			break;
		case "E2": //ELIMINAR
			var mensaje = confirm("�Seguro que desea Eliminar?");
			if (mensaje==true)
			{
				f.action= "pmn_barro_aurifero_crudo01.php?Proceso=E2";
				f.submit();
			}
			else
			{
				return;
			}
			break;
		case "C": //CANCELAR
			f.action= "pmn_barro_aurifero_crudo01.php?Proceso=C";
	 		f.submit();
			break;
		case "B": //CANCELAR
			var URL = "pmn_barro_aurifero_crudo02.php?DiaIniCon=" + f.Dia.value + "&MesIniCon=" + f.Mes.value + "&AnoIniCon=" + f.Ano.value + "&DiaFinCon=" + f.Dia.value + "&MesFinCon=" + f.Mes.value + "&AnoFinCon=" + f.Ano.value;
			window.open(URL,"","top=120,left=30,width=670,height=350,menubar=no,resizable=yes,scrollbars=yes");
			break;
		case "S": //SALIR
			f.action= "../principal/sistemas_usuario.php?CodSistema=6&Nivel=1&CodPantalla=104";
	 		f.submit();
			break;
		case "Ver":
			var URL = "pmn_barro_aurifero_crudo03.php?Electrolisis="+f.NumElectrolisis.value;
			window.open(URL,"","top=120,left=30,width=700,height=350,menubar=no,resizable=yes,scrollbars=yes");
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
    <td><table width="761" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="106" height="30">Fecha:</td>
            <td colspan="2"> 
              <?php 
				if ($Mostrar == "S")
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
            <td>Turno</td>
            <td width="166"> 
              <?php
				if (($Modif == "S")||($Mostrar=='S'))
					{
						$sql = "select * from proyecto_modernizacion.sub_clase where cod_clase=1 and cod_subclase=".$Turno;
						$result2 = mysqli_query($link, $sql);
						if ($row2=mysqli_fetch_array($result2))
							echo "<font>".strtoupper($row2["nombre_subclase"])."</font>";
						else	echo "<font>N</font>";
						echo "<input type='hidden' name='Turno' value='".$Turno."'>";
					}
					else
					{		
						echo "<select name='Turno' style='width:50'>\n";
						$sql = "select * from proyecto_modernizacion.sub_clase where cod_clase = 1 order by cod_subclase";
						$result = mysqli_query($link, $sql);
						while ($row=mysqli_fetch_array($result))
						{
							if ($Turno == $row["cod_subclase"])
								echo "<option selected value='".$row["cod_subclase"]."'>".strtoupper($row["nombre_subclase"])."</option>\n";
							else	echo "<option value='".$row["cod_subclase"]."'>".strtoupper($row["nombre_subclase"])."</option>\n";
						}
						echo "</select>\n";
					}
				?>
            </td>
            <td width="113"><input name="ver" type="button" style="width:70" value="Consultar" onClick="Proceso('B');"></td>
          </tr>
          <tr> 
            <td width="106">Num. Electrolisis:</td>
            <td width="122"> 
              <?php
				if ($Mostrar == "S")
				{
					echo $NumElectrolisis;
					echo "<input name='NumElectrolisis' type='hidden' value='".$NumElectrolisis."'>\n";
				}
				else
				{
              		echo "<input name='NumElectrolisis' type='text' value='".$NumElectrolisis."'>\n";
				}
			  ?>
            </td>
            <td width="123"><input name="BtnElectrisis" type="button" id="BtnElectrisis" value="Ver Elect" onClick="Proceso('Ver');" ></td>
            <td width="98">Grupo:</td>
            <td colspan="2"><input name="Grupo" type="text" id="Grupo2" value="<?php echo $Grupo;?>"></td>
          </tr>
          <tr> 
            <td>Peso Barro Aurifero Crudo:</td>
            <td colspan="2"><input name="EnergiaElec" type="text" id="EnergiaElec" value="<?php echo $EnergiaElec;?>">
              Kilos. </td>
            <td>Operador:</td>
            <td colspan="2"><select name="Operador" style="width:220px">
                <option value="S">Seleccionar</option>
                <?php
				$sql = "select t2.rut, t2.apellido_paterno, t2.apellido_materno, t2.nombres ";
				$sql.= " from proyecto_modernizacion.sistemas_por_usuario t1 inner join  proyecto_modernizacion.funcionarios t2 ";
				$sql.= " on t1.rut = t2.rut ";
				$sql.= " where t1.cod_sistema = '6' ";
				$sql.= " and t1.nivel = '8' ";
				$sql.= " order by t2.apellido_paterno, t2.apellido_materno, t2.nombres";
				echo $sql;
				$result = mysqli_query($link, $sql);
				while ($row = mysqli_fetch_array($result))
				{
					$Nombre = ucwords(strtolower($row["apellido_paterno"]." ".$row["apellido_materno"]." ".$row["nombres"]));
					if ($row[rut] == $Operador)
					{
						echo "<option selected value='".$row[rut]."'>".$Nombre."</option>\n";
					}
					else
					{
						echo "<option value='".$row[rut]."'>".$Nombre."</option>\n";
					}
				}
				echo "<option value='S'>-----------------------------</option>\n";
				$Consulta="select * from proyecto_modernizacion.funcionarios where ((cod_centro_costo='02-35.31')or (cod_centro_costo='02-35.32') ";
				$Consulta.=" or (cod_centro_costo='02-35.33') or (cod_centro_costo='02-35.34') or (cod_centro_costo='02-35.35') or (cod_centro_costo='02-35.36'))order by apellido_paterno,apellido_materno,nombres ";
				$Respuesta=mysqli_query($link, $Consulta);
				while($Fila = mysqli_fetch_array($Respuesta)) 
				{
					$Nombre = ucwords(strtolower($Fila["apellido_paterno"]." ".$Fila["apellido_materno"]." ".$Fila[nombres]));
					if ($Fila[rut] == $Operador)
					{
						echo "<option selected value='".$Fila[rut]."'>".$Nombre."</option>\n";
					}
					else
					{
						echo "<option value='".$Fila[rut]."'>".$Nombre."</option>\n";
					}
				}
			?>
              </select></td>
          </tr>
          <tr> 
            <td>Observaci&oacute;n:</td>
            <td colspan="5"><input name="Obs" type="text" id="Obs" value="<?php echo $Obs;?>" size="80" maxlength="80"></td>
          </tr>
        </table>
		  
        <br>
        <table width="761" border="0" class="TablaInterior">
          <tr align="center" valign="middle"> 
            <td width="726" colspan="7"> <input name="BtnGrabar" type="button" id="BtnGrabar2" value="Grabar" style="width:60px;" onClick="Proceso('G');">
              <input name="BtnEliminar" type="button" id="BtnEliminar2" value="Eliminar" style="width:60px;" onClick="Proceso('E');"> 
              <input name="BtnCancelar" type="button" id="BtnCancelar2" value="Cancelar" style="width:60px;" onClick="Proceso('C');"> 
              <input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:60px;" onClick="Proceso('S');"> 
            </td>
          </tr>
        </table>
        <br>
        <table width="761" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="50">Bolsas:</td>
            <td width="93"><input name="Bolsa" type="text" id="Bolsa" value="<?php echo $Bolsa;?>" size="15" maxlength="15"></td>
            <td width="97">Peso Humedo:</td>
            <td width="80"><input name="PesoHumedo" type="text" value="<?php echo $PesoHumedo;?>" size="15" maxlength="15"></td>
            <td width="94">Humedad (%):</td>
            <td width="96"><input name="PorcHumedad" type="text" value="<?php echo $PorcHumedad;?>" size="15" maxlength="15"></td>
            <td width="206" align="center"><input name="BtnGrabar2" type="button" value="Grabar" style="width:60px;" onClick="Proceso('G2');">
              <input name="BtnModificar2" type="button" value="Modificar" style="width:60px;" onClick="Proceso('M2');">
              <input name="BtnEliminar2" type="button" value="Eliminar" style="width:60px;" onClick="Proceso('E2');"> 
            </td>
          </tr>
        </table>
        <br> 
        <table width="383" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
          <tr align="center" class="ColorTabla01"> 
            <td width="39" height="15">&nbsp;</td>
            <td width="112"><strong>Bolsa</strong></td>
            <td width="108"><strong>Peso Humedo</strong></td>
            <td width="121"><strong>Humedad (%)</strong></td>
          </tr>
          <?php	
	$Consulta = "select * from pmn_web.detalle_barro_aurifero_crudo ";
	$Consulta.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";	  
	$Consulta.= " and num_electrolisis = '".$NumElectrolisis."'";
	$Consulta.= " order by num_bolsa";
	$Respuesta = mysqli_query($link, $Consulta);
	$i=1;
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		echo "<tr>\n";
		echo "<td align='center'><input type='checkbox' name='ChkBolsa[".$i."]' value='".$Row[num_bolsa]."'>\n";
		echo "<input type='hidden' name='ChkPesoHumedo[".$i."]' value='".$Row[peso_humedo]."'>\n";
		echo "<input type='hidden' name='ChkPorcHumedad[".$i."]' value='".$Row[porc_humedad]."'>\n";
		echo "</td>\n";
		echo "<td align='center'>".$Row[num_bolsa]."</td>\n";
		echo "<td align='right'>".$Row[peso_humedo]."</td>\n";
		echo "<td align='right'>".$Row[porc_humedad]."</td>\n";
		echo "</tr>\n";
		$i++;
	}
?>
        </table></td>
  </tr>
</table>

<?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
