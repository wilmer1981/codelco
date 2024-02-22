<?php
	$CodigoDeSistema = 6;
	$CodigoDePantalla = 16;
	include("../principal/conectar_pmn_web.php");
	if ($Consulta == "S")
	{
		$Mostrar = "S";
		$Dia = $IdDia;
		$Mes = $IdMes;
		$Ano = $IdAno;
		$Hornada = $IdHornada;
	}
	if (($Mostrar == "S") && ($Hornada != ""))
	{
		$Consulta = "select * from pmn_web.produccion_fusion_barro_aurifero ";
		$Consulta.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";
		$Consulta.= " and hornada = '".$Hornada."'";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Row = mysqli_fetch_array($Respuesta))
		{
			$Anodos = $Row[anodos];
			$Peso = $Row["peso"];
			$Colada = $Row[colada];
			$Escoria = $Row[escoria];
			$PorcRecuperacion = $Row[porc_recuperacion];
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
			if (f.Hornada.value == "")
			{
				alert("Debe Ingresar Hornada");
				f.Hornada.focus();
				return;
			}
			if (f.Operador.value == "S")
			{
				alert("Debe Seleccionar Operador");
				f.Operador.focus();
				return;
			}
			if (f.Anodos.value == "")
			{
				alert("Debe Ingresar Anodos");
				f.Anodos.focus();
				return;
			}
			if (f.Peso.value == "")
			{
				alert("Debe Ingresar Peso");
				f.Peso.focus();
				return;
			}
			if (f.Colada.value == "")
			{
				alert("Debe Ingresar Colada");
				f.Colada.focus();
				return;
			}
			if (f.Escoria.value == "")
			{
				alert("Debe Ingresar Escoria");
				f.Escoria.focus();
				return;
			}
			if (f.PorcRecuperacion.value == "")
			{
				alert("Debe Ingresar Porcentaje (%) de Recuperacion");
				f.PorcRecuperacion.focus();
				return;
			}
			f.action= "pmn_prod_fusion_barro_aurifero01.php?Proceso=G";
	 		f.submit();
			break;
		case "G2": //GRABAR DETALLE			
			if (f.NumElectrolisis.value == "")
			{
				alert("Debe Ingresar # Electrolisis");
				f.NumElectrolisis.focus();
				return;
			}
			if (f.Unidades.value == "")
			{
				alert("Debe Ingresar Unidades");
				f.Unidades.focus();
				return;
			}
			if (f.Peso2.value == "")
			{
				alert("Debe Ingresar Peso");
				f.Peso2.focus();
				return;
			}					
			f.action= "pmn_prod_fusion_barro_aurifero01.php?Proceso=G2";
	 		f.submit();
			break;
		case "M2": //MODIFICAR DETALLE
			f.action= "pmn_prod_fusion_barro_aurifero01.php?Proceso=M";
	 		f.submit();
			break;
		case "E": //ELIMINAR TODO
			var mensaje = confirm("�Seguro que desea Eliminar?");
			if (mensaje==true)
			{
				f.action= "pmn_prod_fusion_barro_aurifero01.php?Proceso=E";
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
				f.action= "pmn_prod_fusion_barro_aurifero01.php?Proceso=E2";
				f.submit();
			}
			else
			{
				return;
			}
			break;
		case "C": //CANCELAR
			f.action= "pmn_prod_fusion_barro_aurifero01.php?Proceso=C";
	 		f.submit();
			break;
		case "B": //CANCELAR
			var URL = "pmn_prod_fusion_barro_aurifero02.php?DiaIniCon=" + f.Dia.value + "&MesIniCon=" + f.Mes.value + "&AnoIniCon=" + f.Ano.value + "&DiaFinCon=" + f.Dia.value + "&MesFinCon=" + f.Mes.value + "&AnoFinCon=" + f.Ano.value;
			window.open(URL,"","top=120,left=30,width=670,height=350,menubar=no,resizable=yes,scrollbars=yes");
			break;
		case "S": //SALIR
			f.action= "../principal/sistemas_usuario.php?CodSistema=6&Nivel=1&CodPantalla=107";
	 		f.submit();
			break;
	}

}
function TeclaPulsada (tecla) 
{ 
	var Frm=document.frmPrincipal;
	var teclaCodigo = event.keyCode; 
	if ((teclaCodigo != 188 )&&(teclaCodigo != 37)&&(teclaCodigo != 39))
	{
		if (((teclaCodigo != 8) && (teclaCodigo !=9)) && (teclaCodigo < 48) || (teclaCodigo > 57))
		{
		   if ((teclaCodigo < 96) || (teclaCodigo > 105))
		   {
				event.keyCode=46;
		   }		
		}   
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
            <td width="99" height="30">Fecha:</td>
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
            <td colspan="3"> <input name="ver" type="button" style="width:70" value="Consultar" onClick="Proceso('B');"></td>
          </tr>
          <tr> 
            <td width="99">Num. Hornada:</td>
            <td width="195"> 
              <?php
				if ($Mostrar == "S")
				{
					echo $Hornada;
					echo "<input name='Hornada' type='hidden' value='".$Hornada."'>\n";
				}
				else
				{
              		echo "<input name='Hornada' type='text' value='".$Hornada."'>\n";
				}
			  ?>
            </td>
            <td width="65">Operador:</td>
            <td colspan="3"><select name="Operador" style="width:220px">
                <option value="S">Seleccionar</option>
                <?php
				$sql = "select t2.nombre_subclase as rut, t1.apellido_paterno, t1.apellido_materno, t1.nombres ";
				$sql.= " from proyecto_modernizacion.funcionarios t1,  proyecto_modernizacion.sub_clase t2";
				$sql.= " where t2.cod_clase = 6000 ";
				$sql.= " and t2.valor_subclase1 = '1' ";
				$sql.= " and t2.nombre_subclase = t1.rut ";
				$sql.= " order by t1.apellido_paterno, t1.apellido_materno, t1.nombres";
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
			?>
              </select></td>
          </tr>
          <tr> 
            <td>&Aacute;nodos:</td>
            <td> <input name="Anodos" type="text" id="Anodos" value="<?php echo $Anodos;?>"> 
            </td>
            <td>Peso:</td>
            <td colspan="3"> <input name="Peso" type="text" onKeyDown="TeclaPulsada()" value="<?php echo str_replace(".",",",$Peso);?>"></td>
          </tr>
          <tr> 
            <td>Colada</td>
            <td><input name="Colada" type="text" id="Colada" value="<?php echo $Colada;?>"></td>
            <td>Escoria:</td>
            <td width="148"><input name="Escoria" type="text" id="Anodos3" value="<?php echo $Escoria;?>"></td>
            <td width="114">(%) Recuperacion:</td>
            <td width="101"><input name="PorcRecuperacion" type="text" onKeyDown="TeclaPulsada()" value="<?php echo $PorcRecuperacion?>" size="15" maxlength="15"></td>
          </tr>
          <tr> 
            <td>Observaci&oacute;n:</td>
            <td colspan="5"><input name="Obs" type="text" id="Obs" value="<?php echo $Obs;?>" size="124" maxlength="255"></td>
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
            <td width="82"># Electrolisis:</td>
            <td width="120"><input name="NumElectrolisis" type="text" id="Bolsa2" value="<?php echo $NumElectrolisis;?>" size="15" maxlength="15"></td>
            <td width="66">Unidades:</td>
            <td width="109"><input name="Unidades" type="text" onKeyDown="TeclaPulsada()" value="<?php echo str_replace(".",",",$Unidades);?>" size="15" maxlength="15"></td>
            <td width="54">Peso:</td>
            <td width="93"><input name="Peso2" type="text" onKeyDown="TeclaPulsada()" value="<?php echo str_replace(".",",",$Peso2);?>" size="15" maxlength="15"></td>
            <td width="192" rowspan="2" align="center" valign="middle">
<input name="BtnGrabar2" type="button" value="Grabar" style="width:60px;" onClick="Proceso('G2');"> 
              <input name="BtnModificar2" type="button" value="Modificar" style="width:60px;" onClick="Proceso('M2');"> 
              <input name="BtnEliminar2" type="button" value="Eliminar" style="width:60px;" onClick="Proceso('E2');"> 
            </td>
          </tr>
          <tr> 
            <td>Observaci&oacute;n:</td>
            <td colspan="5"><input name="Obs2" type="text" id="Obs2" value="<?php echo $Obs2;?>" size="90" maxlength="255"></td>
          </tr>
        </table>
        <br> 
        <table width="750" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
          <tr align="center" class="ColorTabla01"> 
            <td width="38" height="15">&nbsp;</td>
            <td width="103"><strong># Electrolisis</strong></td>
            <td width="99"><strong>Unidades</strong></td>
            <td width="116"><strong>Peso</strong></td>
            <td width="381"><strong>Observaci&oacute;n</strong></td>
          </tr>          
          <?php	
	$Consulta = "select * from pmn_web.detalle_prod_fusion_barro_aurifero ";
	$Consulta.= " where fecha = '".$Ano."-".$Mes."-".$Dia."'";	  
	$Consulta.= " and hornada = '".$Hornada."'";
	$Consulta.= " order by hornada";
	$Respuesta = mysqli_query($link, $Consulta);
	$i=1;
	$TotalUnidades = 0;
	$TotalPeso = 0;
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		echo "<tr>\n";
		echo "<td align='center'><input type='checkbox' name='ChkNumElectrolisis[".$i."]' value='".$Row[num_electrolisis]."'>\n";
		echo "<input type='hidden' name='ChkUnidades[".$i."]' value='".$Row["unidades"]."'>\n";
		echo "<input type='hidden' name='ChkPeso[".$i."]' value='".$Row["peso"]."'>\n";
		echo "<input type='hidden' name='ChkObservacion[".$i."]' value='".$Row["observacion"]."'>\n";
		echo "</td>\n";
		echo "<td align='center'>".$Row[num_electrolisis]."</td>\n";
		echo "<td align='right'>".$Row["unidades"]."</td>\n";
		echo "<td align='right'>".$Row["peso"]."</td>\n";
		echo "<td align='right'>".$Row["observacion"]."&nbsp;</td>\n";
		echo "</tr>\n";
		$TotalUnidades = $TotalUnidades + $Row["unidades"];
		$TotalPeso = $TotalPeso + $Row["peso"];
		$i++;
	}
?>
		  <tr align="center"> 
            <td height="15" colspan="2">TOTALES</td>
            <td align="right">&nbsp;<?php echo $TotalUnidades;?></td>
            <td align="right">&nbsp;<?php echo $TotalPeso;?></td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
  </tr>
</table>

<?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
