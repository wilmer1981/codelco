<?php
	$CodigoDeSistema = 6;
	$CodigoDePantalla = 134;
	include("../principal/conectar_pmn_web.php");
	//include('funciones/pmn_funciones.php'); 
	if ($VerElOro == "K")
	{
		//echo "ano:    ".$AnElOro."<br>";
		$AnoElectOro=$AnoElectOro2;
		$MesElectOro=$MesElectOro2;
		$DiaElectOro=$DiaElectOro2;
	}
	if ($MostrarElOro == "S")
	{
		if ($VerElOro=="S")
		{
			$Correlativo=$Cor;
			$AoElectOro=$A;
			$MesElectOro=$M;
			$DiaElectOro=$D;
			
			$DiaElectOro = $Dia_aux;
			$MesElectOro = $Mes_aux;
			$AnoElectOro = $Ano_aux;
			$Correlativo = $Correlativo_aux;
			$NumElectrolisis = $NumElectrolisis_aux;
			$Colada = $Colada_aux;
			$Turno = $Turno_aux;
		}
		$Consulta = "select * from pmn_web.carga_electrolisis_oro";
		$Consulta.= " where fecha = '".$AnoElectOro."-".$MesElectOro."-".$DiaElectOro."'";
		$Consulta.= " and turno = '".$Turno."'";
		$Consulta.= " and num_electrolisis = '".$NumElectrolisis."'";
		$Consulta.= " and correlativo = '".$Correlativo."'";
		$Consulta.= " and colada = '".$Colada."'";
		//echo $Consulta."<br>";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Row = mysqli_fetch_array($Respuesta))
		{
			$Obs = $Row["observacion"];
			$Operador = $Row[operador];
			$cmbcolor = $Row[color];			
			$CantAnodos = $Row[cant_anodos];
			$PesoAnodos = $Row[peso_anodos];
			$JefeTurno = $Row[jefe_turno];
			$CloruroAurico = $Row[cloruro_aurico];
			$CatodoSeco = $Row[catodos_seco];
			$PesoRestos = $Row[peso_resto];
		}
	}
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="../principal/estilos/css_pmn_web.css" rel="stylesheet" type="text/css">
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function ProcesoElOro(opt)
{
	var f = document.frmPrincipalRpt;
	switch (opt)
	{
		case "G": //GRABAR
			if (f.NumElectrolisis.value == "")
			{
				alert("Debe Ingresar Num. Electrolisis");
				f.NumElectrolisis.focus();
				return;
			}
			if (f.Correlativo.value == "")
			{
				alert("Debe Ingresar Correlativo");
				f.Correlativo.focus();
				return;
			}
			if (f.Operador.value == "S")
			{
				alert("Debe seleccionar Operador");
				f.Operador.focus();
				return;
			}
			if (f.Colada.value == "")
			{
				alert("Debe Ingresar Colada");
				f.Colada.focus();
				return;
			}
			if (f.CantAnodos.value == "")
			{
				alert("Debe Ingresar Cantidad de Anodos");
				f.CantAnodos.focus();
				return;
			}
			if (f.PesoAnodos.value == "")
			{
				alert("Debe Ingresar Peso de los Anodos");
				f.PesoAnodos.focus();
				return;
			}
			f.action= "pmn_carga_elec_oro01.php?Proceso=G";
	 		f.submit();
			break;
		case "M": //MODIFICAE
			f.action= "pmn_carga_elec_oro01.php?Proceso=M";
	 		f.submit();
			break;
		case "E": //ELIMINAR
			if (confirm("Esta Seguro De Eliminar Los Registros"))
			{
				f.action= "pmn_carga_elec_oro01.php?Proceso=E&volver=S";
		 		f.submit();
			}
			break;
		case "C": //CANCELAR
			f.action= "pmn_carga_elec_oro01.php?Proceso=C";
	 		f.submit();
			break;
		case "B": //CANCELAR
			var URL = "pmn_carga_elect_oro03.php?DiaIniCon=" + f.DiaElectOro.value + "&MesIniCon=" + f.MesElectOro.value + "&AnoIniCon=" + f.AnoElectOro.value + "&DiaFinCon=" + f.DiaElectOro.value + "&MesFinCon=" + f.MesElectOro.value + "&AnoFinCon=" + f.AnoElectOro.value;
			window.open(URL,"","top=120,left=30,width=670,height=350,menubar=no,resizable=yes,scrollbars=yes");
			break;
			break;
		case "S": //SALIR
			f.action= "../principal/sistemas_usuario.php?CodSistema=6&Nivel=1&CodPantalla=133";
	 		f.submit();
			break;
		case "Ver":
			var URL = "pmn_carga_elect_oro02.php?Electrolisis="+f.NumElectrolisis.value;
			window.open(URL,"","top=120,left=30,width=700,height=350,menubar=no,resizable=yes,scrollbars=yes");
			//f.action="pmn_carga_elect_plata02.php?Electrolisis="+f.NumElectrolisis.value;
	 		//f.submit();
			break;
	}
}
function TeclaPulsada2ElOro(salto) 
{ 
	var f = document.frmPrincipalRpt;
	var teclaCodigo = event.keyCode; 	
	if (teclaCodigo == 0)
	{		
		eval("f." + salto + ".focus();");
	}
}
function TeclaPulsada1ElOro(salto) 
{ 
	var f = document.frmPrincipalRpt;
	var teclaCodigo = event.keyCode; 	
	if (teclaCodigo == 13)
	{		
		eval("f." + salto + ".focus();");
	}
}
</script>
</head>

<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="frmPrincipalElOro" method="post" action="">
  <table width="100%" height="330" border="0" class="TituloCabeceraOz">
    <tr>
		
      <td align="center" valign="top"><table width="100%" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="106" height="30" class="titulo_azul">Fecha:</td>
            <td width="262" colspan="2"> 
              <?php 
				if (($MostrarElOro == "S")|| ($VerElOro=="K"))
				{
					echo "<input type='hidden' name='DiaElectOro' value='".$DiaElectOro."'>\n";
					echo "<input type='hidden' name='MesElectOro' value='".$MesElectOro."'>\n";
					echo "<input type='hidden' name='AnoElectOro' value='".$AnoElectOro."'>\n";
					printf("%'02d",$DiaElectOro);
					echo "-";
					printf("%'02d",$MesElectOro);
					echo "-";
					printf("%'04d",$AnoElectOro);
				}
				else
				{
					echo "<select name='DiaElectOro' style='width:50px'>\n";				
					for ($i=1;$i<=31;$i++)
					{
						if (isset($DiaElectOro))
						{
							if ($i == $DiaElectOro)
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
				  echo "</select> <select name='MesElectOro' style='width:100px'>\n";
					for ($i=1;$i<=12;$i++)
					{
						if (isset($MesElectOro))
						{
							if ($i == $MesElectOro)
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
				  echo "</select> <select name='AnoElectOro' style='width:60px'>\n";
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (isset($AnoElectOro))
						{
							if ($i == $AnoElectOro)
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
            <td width="150"><input name="ver" type="button" style="width:70" value="Consultar" onClick="ProcesoElOro('B');"> 
            </td>
            <td width="113">&nbsp;</td>
          </tr>
          <tr> 
            <td width="106" class="titulo_azul">Num. Electrolisis:</td>
            <td width="131"><input name="NumElectrolisis" type="text" id="NumElectrolisis2" onKeyDown="TeclaPulsada1ElOro('Turno')" value="<?php echo $NumElectrolisis;?>"></td>
            <td width="131"><input name="BtnElectrisis" type="button" id="BtnElectrisis" value="Ver Elect" onClick="ProcesoElOro('Ver');" ></td>
            <td width="97" class="titulo_azul">Turno: </td>
            <td colspan="2" class="formulario"> 
              <?php
				if ($MostrarElOro == "S")
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
					echo "<select name='Turno' id = 'Turno' style='width:50px'>\n";
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
            <td class="titulo_azul">Correlativo:</td>
            <td colspan="2"><input name="Correlativo" type="text" id="Correlativo2" onKeyDown="TeclaPulsada1ElOro('JefeTurno')" value="<?php echo $Correlativo;?>"></td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr> 
            <td class="titulo_azul">E.V.P.F.</td>
            <td colspan="2"><select name="JefeTurno" onChange="TeclaPulsada2ElOro('Operador')" style="width:220px">
                <option value="S">Seleccionar</option>
                <?php
				$Consulta="select * from proyecto_modernizacion.sub_clase t1 ";
				$Consulta.=" inner join proyecto_modernizacion.funcionarios t2 on t2.rut = t1.nombre_subclase";
				$Consulta.=" where cod_clase='6000' and valor_subclase4='evpf' order by apellido_paterno DESC ";
				$Respuesta=mysqli_query($link, $Consulta);
				while($Fila = mysqli_fetch_array($Respuesta)) 
				{
					$Nombre = ucwords(strtolower($Fila["apellido_paterno"]." ".$Fila["apellido_materno"]." ".$Fila["nombres"]));
					if ($Fila[rut] == $JefeTurno)
					{
						echo "<option selected value='".$Fila[rut]."'>".$Nombre."</option>\n";
					}
					else
					{
						echo "<option value='".$Fila[rut]."'>".$Nombre."</option>\n";
					}
				}				
				echo "<option value='S'>-----------------------------</option>\n";
				$sql = "select t2.rut, t2.apellido_paterno, t2.apellido_materno, t2.nombres ";
				$sql.= " from proyecto_modernizacion.sistemas_por_usuario t1 inner join  proyecto_modernizacion.funcionarios t2 ";
				$sql.= " on t1.rut = t2.rut ";
				$sql.= " where t1.cod_sistema = '6' ";
				$sql.= " and t1.nivel = '4' ";
				$sql.= " order by t2.apellido_paterno, t2.apellido_materno, t2.nombres";
				$result = mysqli_query($link, $sql);
				while ($row = mysqli_fetch_array($result))
				{
					$Nombre = ucwords(strtolower($row["apellido_paterno"]." ".$row["apellido_materno"]." ".$row["nombres"]));
					if ($row[rut] == $JefeTurno)
					{
						echo "<option selected value='".$row[rut]."'>".$Nombre."</option>\n";
					}
					else
					{
						echo "<option value='".$row[rut]."'>".$Nombre."</option>\n";
					}
				}
				/*
				echo "<option value='S'>-----------------------------</option>\n";
				$Consulta="select * from proyecto_modernizacion.sub_clase t1 ";
				$Consulta.=" inner join proyecto_modernizacion.funcionarios t2 on t2.rut = t1.nombre_subclase";
				$Consulta.=" where cod_clase='6000' and valor_subclase2='S' order by apellido_paterno,apellido_materno,nombres ";
				$Respuesta=mysqli_query($link, $Consulta);
				while($Fila = mysqli_fetch_array($Respuesta)) 
				{
					$Nombre = ucwords(strtolower($Fila["apellido_paterno"]." ".$Fila["apellido_materno"]." ".$Fila["nombres"]));
					if ($Fila[rut] == $JefeTurno)
					{
						echo "<option selected value='".$Fila[rut]."'>".$Nombre."</option>\n";
					}
					else
					{
						echo "<option value='".$Fila[rut]."'>".$Nombre."</option>\n";
					}
				}
				*/
			?>
              </select>
		    </td>
            <td class="titulo_azul">Operador:</td>
            <td colspan="2"><select name="Operador" onChange="TeclaPulsada2ElOro('Obs')" style="width:220px">
              <option value="S">Seleccionar</option>
              <?php
				//LlenaCombosPersonalPmn(&$Operador,'5');
				$sql = "select t2.rut, t2.apellido_paterno, t2.apellido_materno, t2.nombres ";
				$sql.= " from proyecto_modernizacion.sub_clase t1 inner join  proyecto_modernizacion.funcionarios t2 ";
				$sql.= " on t1.nombre_subclase = t2.rut ";
				$sql.= " where t1.cod_clase = '6015' and t1.valor_subclase1='6' ";
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
            <td colspan="5"><input name="Obs" type="text" id="Obs" onKeyDown="TeclaPulsada1ElOro('Colada')" value="<?php echo $Obs;?>" size="80" maxlength="80"></td>
          </tr>
        </table>
        <br>
        <table width="100%" border="0" class="TablaInterior">
          <tr> 
            <td width="84" class="titulo_azul">#Colada:</td>
            <td width="118"><input name="Colada" type="text" id="Colada" onKeyDown="TeclaPulsada1ElOro('CantAnodos')" value="<?php echo $Colada;?>" size="15" maxlength="15"></td>
            <td width="87" class="titulo_azul">Cant. Anodos:</td>
            <td width="105"><input name="CantAnodos" type="text" id="CantAnodos" onKeyDown="SoloNumeros(true,this)" value="<?php echo $CantAnodos;?>" size="15" maxlength="15"></td>
            <td width="40" class="titulo_azul">Peso:</td>
            <td width="127"><input name="PesoAnodos" type="text" id="PesoAnodos" onKeyDown="SoloNumeros(true,this)" value="<?php echo number_format($PesoAnodos,4,',','');?>" size="15" maxlength="15"></td>
            <td width="54" class="titulo_azul">Color </td>
			
			
			
            <td width="109"><select name="cmbcolor" id="cmbcolor" onChange="TeclaPulsada2ElOro('CloruroAurico')">
                <option value="-1">SELECCIONAR</option>
                <?php
				$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase";
				$consulta.= " WHERE cod_clase = 6001";
				$rs = mysqli_query($link, $consulta);				
				while ($row = mysqli_fetch_array($rs))
				{
                	if ($cmbcolor == $row["cod_subclase"])	
						echo '<option value="'.$row["cod_subclase"].'" selected>'.$row["nombre_subclase"].'</option>';
					else
						echo '<option value="'.$row["cod_subclase"].'">'.$row["nombre_subclase"].'</option>';
				}
			?>
              </select></td>
          </tr>
          <tr> 
            <td class="titulo_azul">Cloruro Aurico:</td>
            <td><input name="CloruroAurico" type="text" id="CloruroAurico" onKeyDown="SoloNumeros(true,this)" value="<?php echo number_format($CloruroAurico,4,',','') ?>" size="15" maxlength="15"></td>
            <td class="titulo_azul">Catodos Seco:</td>
            <td><input name="CatodoSeco" type="text" id="CatodoSeco" onKeyDown="SoloNumeros(true,this)" value="<?php echo number_format($CatodoSeco,4,',','') ?>" size="15" maxlength="15"></td>
            <td class="titulo_azul">Restos:<br> </td>
            <td><input name="PesoRestos" type="text" id="PesoRestos" onKeyDown="SoloNumeros(true,this)" value="<?php echo number_format($PesoRestos,4,',','') ?>" size="15" maxlength="15"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <br>
        <table width="760" border="0" cellpadding="0" class="TablaInterior">
          <tr> 
            <td align="center"> <input name="BtnGrabar" type="button" id="BtnGrabar" value="Grabar" style="width:60px;" onClick="ProcesoElOro('G');"> 
              <input name="BtnModificar" type="button" id="BtnModificar2" value="Modificar" style="width:60px;" onClick="ProcesoElOro('M');"> 
              <input name="BtnEliminar" type="button" id="BtnEliminar2" value="Eliminar" style="width:60px;" onClick="ProcesoElOro('E');"> 
            <input name="BtnCancelar" type="button" id="BtnCancelar2" value="Cancelar" style="width:60px;" onClick="ProcesoElOro('C');"></td>
          </tr>
        </table>
        <br>
        <table width="760" border="0" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
          <tr class="TituloCabeceraAzul"> 
            <td width="45" height="15">&nbsp;</td>
            <td width="81"><strong>Turno</strong></td>
            <td width="100" align="center"><strong>Num. Elec.</strong></td>
            <td width="129" align="center"><strong>#Colada</strong></td>
            <td width="93" align="center"><strong>Correlativo</strong></td>
            <td width="108" align="center"><strong>Cant. Anodos</strong></td>
            <td width="112" align="center"><strong>Peso</strong></td>
            <td width="112" align="center"><strong>Cloruro A.</strong></td>
            <td width="112" align="center"><strong>Cat. Seco</strong></td>
            <td width="112" align="center"><strong>Restos</strong></td>
          </tr>
          <?php	
	$Consulta = "select * from pmn_web.carga_electrolisis_oro ";
	$Consulta.= " where fecha = '".$AnoElectOro."-".$MesElectOro."-".$DiaElectOro."'";	  
	$Consulta.= " order by turno, num_electrolisis, colada, correlativo";
	$Respuesta = mysqli_query($link, $Consulta);
	$i=1;
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		echo "<tr>\n";
		echo "<td align='center'><input type='checkbox' name='ChkTurno[".$i."]' value='".$Row[turno]."'>\n";
		echo "<input type='hidden' name='ChkNumElec[".$i."]' value='".$Row[num_electrolisis]."'>\n";
		echo "<input type='hidden' name='ChkColada[".$i."]' value='".$Row[colada]."'>\n";
		echo "<input type='hidden' name='ChkCorrelativo[".$i."]' value='".$Row[correlativo]."'>\n";
		echo "</td>\n";
		$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase = 1 and cod_subclase = ".$Row[turno];
		$Resp2 = mysqli_query($link, $Consulta);
		if ($Row2 = mysqli_fetch_array($Resp2))
		{
			echo "<td>".strtoupper($Row2["nombre_subclase"])."</td>\n";
		}
		else
		{
			echo "<td>&nbsp;</td>\n";
		}
		echo "<td align='center'>".$Row[num_electrolisis]."</td>\n";
		echo "<td align='center'>".$Row[colada]."</td>\n";
		echo "<td align='center'>".$Row[correlativo]."</td>\n";
		echo "<td align='center'>".$Row[cant_anodos]."</td>\n";
		echo "<td align='center'>".$Row[peso_anodos]."</td>\n";
		echo "<td align='center'>".$Row[cloruro_aurico]."</td>\n";
		echo "<td align='center'>".$Row[catodos_seco]."</td>\n";
		echo "<td align='center'>".$Row[peso_resto]."</td>\n";						
		echo "</tr>\n";
		$i++;
	}
?>
      </table> </td>
	</tr>
</table>
</form>
</body>
</html>
