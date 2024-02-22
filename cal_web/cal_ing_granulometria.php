<?php 
	include("../principal/conectar_principal.php");
	if ($Recargo == "N")
		$Recargo = "";
	$Consulta = "select t1.cod_producto, t1.cod_subproducto, t2.descripcion as prod, t3.descripcion as subprod from cal_web.solicitud_analisis t1 inner join proyecto_modernizacion.productos t2 ";
	$Consulta.= " on t1.cod_producto = t2.cod_producto inner join proyecto_modernizacion.subproducto t3 ";
	$Consulta.= " on t1.cod_producto = t3.cod_producto and t1.cod_subproducto = t3.cod_subproducto ";
	$Consulta.= " where t1.nro_solicitud = '".$SA."'";
	$Consulta.= " and t1.recargo = '".$Recargo."'";
	$Respuesta = mysqli_query($link, $Consulta);	
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		$Producto = $Fila["cod_producto"];
		$SubProducto = $Fila["cod_subproducto"];
		$NomProducto = $Fila["prod"];
		$NomSubProducto = $Fila["subprod"];
	}
	if (isset($Num))
		$NumDetalle = $Num;
	else
		$NumDetalle = 1;
	//PESO TOTAL
	$Consulta = "select distinct peso_muestra as peso_total, cod_estado as estado from cal_web.granulometria where nro_solicitud = '".$SA."' and recargo = '".$Recargo."' order by corr";	
	$Respuesta = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		$PesoMuestra = $Fila["peso_total"];
		$Estado = $Fila["estado"];
	}
	//-----------
?>
<html>
<head>
<title>Ing. Granulometria</title>
<link href="../Principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(o)
{
	var f = document.frmGranulometria;
	var Valores = "";
	switch (o)
	{
		case "G":
			for (i=1;i<f.elements.length;i++)
			{
				                                               //Id, Signo, Malla, Unidad, Peso
				if (f.elements[i].name=="Id")
					var Valores = Valores + f.elements[i].value + "///" + f.elements[i+1].value + "///" +  f.elements[i+2].value.replace("+","MAS") + "///" +  f.elements[i+3].value + "///" + f.elements[i+4].value + "~~";									
			}
			var LargoStr = Valores.length;
			Valores = Valores.substring(0,LargoStr-2);	
			f.action = "cal_ing_granulometria01.php?Proceso=G&Valores=" + Valores;
			f.submit();
			break;
		case "GP": //GUARDA PLANTILLA
			for (i=1;i<f.elements.length;i++)
			{
				//Signo, Malla, Unidad				
				if (f.elements[i].name=="Id" && f.elements[i+1].value=="MAS" && f.elements[i+2].value!="")
				{					
					var Valores = Valores + f.elements[i+1].value + "///" +  f.elements[i+2].value.replace("+","MAS") + "///" +  f.elements[i+3].value + "~~";									
				}
			}
			var LargoStr = Valores.length;
			Valores = Valores.substring(0,LargoStr-2);	
			var DescPlantilla = prompt("Ingrese Nombre para la Nueva Plantilla");
			while (DescPlantilla == "")
			{
				alert("Debe Ingresar una Descripcion");
				var DescPlantilla = prompt("Ingrese Descripcion para la Nueva Plantilla");
			}
			f.action = "cal_ing_granulometria01.php?DescPlantilla=" + DescPlantilla + "&GeneraCorr=S&Proceso=GP&Valores=" + Valores;
			f.submit();
			break;
		case "CP": //CARGA PLANTILLA		
			if (f.PesoMuestra.value == 0 || f.PesoMuestra.value == "")
			{
				alert("Debe ingresar peso total de la muestra");	
				f.PesoMuestra.focus();
				return;
			}
			else
			{
				for (i=1;i<f.elements.length;i++)
				{
																   //Id, Signo, Malla, Unidad, Peso
					if (f.elements[i].name=="Id")
						var Valores = Valores + f.elements[i].value + "///" + f.elements[i+1].value + "///" +  f.elements[i+2].value.replace("+","MAS") + "///" +  f.elements[i+3].value + "///" + f.elements[i+4].value + "~~";									
				}
				var LargoStr = Valores.length;
				Valores = Valores.substring(0,LargoStr-2);	
				f.action = "cal_ing_granulometria_carga_plantilla.php?PesoMuestra=" + f.PesoMuestra.value + "&Estado=" + f.Estado.value + "&SA=" + f.SA.value + "&Recargo=" + f.Recargo.value;
				f.submit();
			}
			break;
		case "S":
			window.close();
			break;
		case "A":
			f.action = "cal_ing_granulometria.php?Num=" + (parseInt(f.NumDetalle.value) + 1);
			f.submit();
			break;
		case "E":
			for (i=1;i<f.elements.length;i++)
			{
				//Id
				if (f.elements[i].name=="Id" && f.elements[i].checked)
					var Valores = Valores + f.elements[i].value + "~~";									
			}
			var LargoStr = Valores.length;
			Valores = Valores.substring(0,LargoStr-2);	
			f.action = "cal_ing_granulometria01.php?Proceso=E&Valores=" + Valores;
			f.submit();
			break;
	}
}

function Calcula(pos)
{
	var f = document.frmGranulometria;	
	//f.TotalPeso.value = parseFloat(f.TotalPeso.value) - parseFloat(f.ValorIni.value);
	f.TotalPeso.value = parseFloat(f.TotalPeso.value) + parseFloat(f.elements[pos].value);	
}

function GuardaValor(pos)
{
	var f = document.frmGranulometria;
	f.ValorIni.value = f.elements[pos].value;	
}
</script>
</head>

<body background="../Principal/imagenes/fondo3.gif">
<form name="frmGranulometria" action="" method="post">
<input type="hidden" name="SA" value="<?php echo $SA; ?>">
<input type="hidden" name="Recargo" value="<?php echo $Recargo; ?>">
<input type="hidden" name="Producto" value="<?php echo $Producto; ?>">
<input type="hidden" name="SubProducto" value="<?php echo $SubProducto; ?>">
<input name="NumDetalle" type="hidden" value="<?php echo $NumDetalle; ?>"> 
  <table width="500" border="1" cellpadding="3" cellspacing="0" class="TablaInterior">
    <tr> 
      <td width="22%">Producto:</td>
      <td colspan="3"><?php echo $NomProducto; ?></td>
    </tr>
    <tr> 
      <td>SubProducto:</td>
      <td colspan="3"><?php echo $NomSubProducto; ?></td>
    </tr>
    <tr> 
      <td>Solicitud:</td>
      <td width="36%"><?php echo $SA; ?></td>
      <td width="14%" align="right">Recargo:</td>
      <td width="28%"><?php if ($Recargo == "") echo "&nbsp;"; else echo $Recargo; ?></td>
    </tr>
    <tr>
      <td>Peso</td>
      <td colspan="3"><input name="PesoMuestra" type="text" id="PesoMuestra" value="<?php echo round($PesoMuestra,2); ?>" size="15"></td>
    </tr>
    <tr> 
      <td>Estado Granul.</td>
      <td colspan="3"><select name="Estado">
<?php
	$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase = '1008' order by cod_subclase";
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		if ($Estado == $Fila["nombre_subclase"])
			echo "<option selected value='".$Fila["nombre_subclase"]."'>".$Fila["valor_subclase1"]."</option>\n";	
		else
			echo "<option value='".$Fila["nombre_subclase"]."'>".$Fila["valor_subclase1"]."</option>\n";	
	}
?>	  
      </select></td>
    </tr>
    <tr align="center"> 
      <td colspan="4"> 
        <input name="BrnGrabar" type="button" value="Grabar" style="width:70px" onClick="Proceso('G');">
        <!--<input name="BrnAgregar" type="button" value="Agregar" style="width:70px" onClick="Proceso('A');">-->
        <input name="BtnEliminar" type="button" value="Eliminar" style="width:70px" onClick="Proceso('E');">
        <input name="BtnCerrar" type="button" value="Cerrar" style="width:70px" onClick="Proceso('S');"> </td>
    </tr>
  </table>
  <br>
  <br>
  <table width="500" border="1" cellpadding="3" cellspacing="0" class="TablaDetalle">
    <tr align="center"> 
      <td colspan="5"><input name="BtnCargar" type="button" id="BtnCargar" onClick="Proceso('CP');" value="Cargar Plantilla">
        <input name="BtnGuardar" type="button" value="Guardar Plantilla" onClick="Proceso('GP');"></td>
    </tr>
    <tr align="center" class="ColorTabla01"> 
      <td width="34">Quitar</td>
      <td width="259">Malla</td>
      <td width="52">Peso</td>
      <td width="51">%</td>
      <td width="61">Acumulado</td>
    </tr>
    <?php	
	$Pos = 9;
	$Consulta = "select * from cal_web.granulometria where nro_solicitud = '".$SA."' and recargo = '".$Recargo."' and corr <> 'F' order by corr";	
	$Respuesta = mysqli_query($link, $Consulta);
	$i=0;
	$TotalPeso = 0;
	$TotalPorc = 0;
	$TotalAcum = 0;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		echo "<tr align='center'> \n";
		echo "<td><input type='checkbox' name='Id' value='".$Fila["corr"]."'></td>\n";
		echo "<td>\n";
		echo "<select name='Signo[".$Fila["corr"]."]'>\n";
		if ($Fila["signo"] == "+")
		{
			echo "<option selected value='MAS'>+</option>\n";
			echo "<option value='MENOS'>-</option>\n";
		}
		else
		{
			echo "<option value='MAS'>+</option>\n";
			echo "<option selected value='MENOS'>-</option>\n";
		}
		echo "</select>\n";
		echo "<input name='Malla[".$Fila["corr"]."]' type='text' size='15' value='".$Fila["malla"]."'>\n";
		echo "<select name='Unidad[".$Fila["corr"]."]'>\n";
		$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase = '1007' order by cod_subclase ";
		$Resp2 = mysqli_query($link, $Consulta);
		while ($Fila2 = mysqli_fetch_array($Resp2))
		{
			if ($Fila2["cod_subclase"] == $Fila["cod_unidad"])
				echo "<option selected value='".$Fila2["cod_subclase"]."'>".$Fila2["nombre_subclase"]."</option>\n";
			else
				echo "<option value='".$Fila2["cod_subclase"]."'>".$Fila2["nombre_subclase"]."</option>\n";
		}
		echo "</select></td>\n";
		echo "<td> \n";
		echo "<input name='Peso[".$Fila["corr"]."]' type='text' value='".round($Fila["peso"],2)."' size='10' onFocus='GuardaValor(".($Pos + 3).")'; onBlur='Calcula(".($Pos + 3).")';></td>\n";
		echo "<td> \n";
		if ($PesoMuestra > 0)
		{
			$Porcentaje = round(100*$Fila["peso"]/$PesoMuestra,2);
			$Acum = round($Acum + (100*$Fila["peso"]/$PesoMuestra),2);			
		}
		else
		{
			$Porcentaje = 0;
			$Acum = 0;	
		}
		$TotalPeso = $TotalPeso + $Fila["peso"];
		$TotalPorc = $TotalPorc + $Porcentaje;
		$TotalAcum = $TotalAcum + $Acum;
		echo "<input name='Porc[".$Fila["corr"]."]' type='text' value='".$Porcentaje."' readonly size='10'></td>\n";
		echo "<td> \n";		
		echo "<input name='Acum[".$Fila["corr"]."]' type='text' value='".$Acum."' readonly size='10'></td>\n";
		echo "</tr>\n";
		$Pos = $Pos + 6;
		$i=$Fila["corr"];
		$UltMalla = $Fila["malla"];
		$UltPeso = $Fila["peso"];
		$UltUnidad = $Fila["cod_unidad"];
		$UltSigno = $Fila["signo"];
	}
	//PARA CREAR EL ULTIMO REGISTRO AUTOMATICO
	if (($PesoMuestra - $TotalPeso) != 0)
	{
		$Corr = $i+1;
		$AuxMalla = str_replace("+","-",$UltMalla);
		echo "<tr align='center' bgcolor='#CCCCCC'> \n";
		echo "<td><input type='checkbox' name='Id' value='F'></td>\n";
		echo "<td>\n";
		echo "<select name='Signo[".$i."]'>\n";
		if ($UltSigno == "MAS")
		{
			echo "<option selected value='MAS'>+</option>\n";
			echo "<option value='MENOS'>-</option>\n";
		}
		else
		{
			echo "<option value='MAS'>+</option>\n";
			echo "<option selected value='MENOS'>-</option>\n";
		}
		echo "</select>\n";
		echo "<input name='Malla[".$i."]' type='text' size='15' value='".$AuxMalla."'>\n";
		echo "<select name='Unidad[".$i."]'>\n";
		$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase = '1007' order by cod_subclase ";
		$Resp2 = mysqli_query($link, $Consulta);
		while ($Fila2 = mysqli_fetch_array($Resp2))
		{
			if ($Fila2["cod_subclase"] == $UltUnidad)
				echo "<option selected value='".$Fila2["cod_subclase"]."'>".$Fila2["nombre_subclase"]."</option>\n";
			else
				echo "<option value='".$Fila2["cod_subclase"]."'>".$Fila2["nombre_subclase"]."</option>\n";
		}
		echo "</select></td>\n";
		echo "<td> \n";
		$PesoFin = ($PesoMuestra - $TotalPeso);
		echo "<input name='Peso[".$i."]' type='text' value='".round($PesoFin,2)."' size='10' onFocus='GuardaValor(".($Pos + 3).")'; onBlur='Calcula(".($Pos + 3).")';></td>\n";
		echo "<td> \n";
		if ($PesoMuestra > 0)
		{
			$Porcentaje = round(100*$PesoFin/$PesoMuestra,2);
			$Acum = round($Acum + (100*$PesoFin/$PesoMuestra),2);			
		}
		else
		{
			$Porcentaje = 0;
			$Acum = 0;	
		}
		$TotalPeso = $TotalPeso + $PesoFin;
		$TotalPorc = $TotalPorc + $Porcentaje;
		//$TotalAcum = $TotalAcum + $Acum;
		echo "<input name='Porc[".$i."]' type='text' value='".$Porcentaje."' readonly size='10'></td>\n";
		echo "<td> \n";		
		echo "<input name='Acum[".$i."]' type='text' value='".$Acum."' readonly size='10'></td>\n";
		echo "</tr>\n";
		//GRABA O ACTUALIZA EL ULTIMO REGISTRO
		$Consulta = "select * from cal_web.granulometria ";
		$Consulta.= " where nro_solicitud = '".$SA."' ";
		$Consulta.= " and recargo = '".$Recargo."' ";
		$Consulta.= " and corr = 'F' ";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Respuesta))
		{
			$Actualizar =  "UPDATE cal_web.granulometria SET ";
			$Actualizar.= " `signo` = '-' , ";
			$Actualizar.= " `malla` = '".$AuxMalla."' , ";
			$Actualizar.= " `cod_unidad` = '".$UltUnidad."', ";
			$Actualizar.= " `peso` = '".$PesoFin."', ";
			$Actualizar.= " `peso_muestra` = '".$PesoMuestra."' ";
			$Actualizar.= " where nro_solicitud = '".$SA."' and recargo = '".$Recargo."' and corr = 'F'";
			mysqli_query($link, $Actualizar);
		}
		else
		{
			$Insertar = "INSERT INTO cal_web.granulometria (`nro_solicitud`, `recargo`, `corr`, `signo`,`malla`, `cod_unidad`, `peso`, `peso_muestra`) ";
			$Insertar.= " VALUES ('".$SA."', '".$Recargo."', 'F', '-', '".$AuxMalla."', '".$UltUnidad."','".$PesoFin."', '".$PesoMuestra."')";
			mysqli_query($link, $Insertar);
		}
	}
	//---------------------------------------
	$Ini = (1+intval($i));
	$Fin = ($NumDetalle+intval($i));
	for ($i=$Ini;$i<=$Fin;$i++)
	{		
		echo "<tr align='center'> \n";
		echo "<td><input type='checkbox' name='Id' value='".$i."'></td>\n";
		echo "<td>\n";
		echo "<select name='Signo[".$i."]'>\n";
		echo "<option selected value='MAS'>+</option>\n";
		echo "<option value='MENOS'>-</option>\n";
		echo "<input name='Malla[".$i."]' type='text' size='15'>\n";
		echo "<select name='Unidad[".$i."]'>\n";
		$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase = '1007' order by cod_subclase ";
		$Respuesta = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Respuesta))
		{
			echo "<option value='".$Fila["cod_subclase"]."'>".$Fila["nombre_subclase"]."</option>\n";
		}
		echo "</select></td>\n";
		echo "<td> \n";
		echo "<input name='Peso[".$i."]' type='text' size='10' onFocus='GuardaValor(".($Pos + 3).")'; onBlur='Calcula(".($Pos + 3).")';></td>\n";
		echo "<td> \n";
		echo "<input name='Porc[".$i."]' type='text' readonly size='10'></td>\n";
		echo "<td> \n";
		echo "<input name='Acum[".$i."]' type='text' readonly size='10'></td>\n";
		echo "</tr>\n";
		$Pos = $Pos + 6;
	}
?>
    <tr align="center"> 
      <td align="right" colspan="2"><strong>TOTAL</strong></td>
      <td> <input name="TotalPeso" type="text" readonly size="10" value="<?php echo round($TotalPeso,2); ?>"></td>
      <td> <input name="TotalPorc" type="text" readonly size="10" value="<?php echo round($TotalPorc,2); ?>"></td>
      <td> <input name="TotalAcum" type="text" readonly size="10" value="<?php echo round($Acum,2); ?>"></td>
    </tr>
  </table>
</td>
<input type="hidden" name="ValorIni" value=""> 
</form>
</body>
</html>
