<?php
	//PAQUETE. (SOLO PARA LODOS)
	
	//Asigna a un arreglo los codigos de paqutes.
	$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 3004";
	$rs = mysqli_query($link, $consulta);
	$cod_paq = array();
	while ($row = mysqli_fetch_array($rs))
	{
		$cod_paq[$row["cod_subclase"]] = $row["nombre_subclase"];
	}		
	
	//Campo Ocultos.
	echo '<input name="fecha_aux" type="hidden" value="'.$ano.'-'.$mes.'-'.$dia.'">';
	echo '<input name="encontro_ie" type="hidden" value="'.$encontro_ie.'">';
	echo '<input name="genera_lote" type="hidden" value="'.$genera_lote.'">';
	echo '<input name="agrega_paq" type="hidden" value="'.$agrega_paq.'">';
	echo '<input name="peso_prog_ok" type="hidden" value="'.$peso_prog_ok.'">';
	echo '<input name="paq_inicial" type="hidden" value="'.$paq_inicial.'">';
	echo '<input name="etapa" type="text" value="'.$etapa.'">';
	
	if ($encontro_ie == "S")
		echo '<input name="tipo_ie" type="hidden" value="'.$tipo_ie.'">';
	else
		echo '<input name="tipo_ie" type="hidden" value="">';
		
?>
<table width="600" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
	 <tr> 
		
    <td width="260">Fecha de Pesaje</td>
		
    <td width="328"> 
      <select name="dia" size="1">
			<?php
		$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		for ($i=1;$i<=31;$i++)
		{	
			if (($mostrar == "S") && ($i == $dia))			
				echo "<option selected value= '".$i."'>".$i."</option>";				
			else if (($i == date("j")) and ($mostrar != "S")) 
					echo "<option selected value= '".$i."'>".$i."</option>";											
			else					
				echo "<option value='".$i."'>".$i."</option>";												
		}		
	?>
		  </select>
		  <select name="mes" size="1" id="select">
			<?php
		for($i=1;$i<13;$i++)
		{
			if (($mostrar == "S") && ($i == $mes))
				echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
			else if (($i == date("n")) && ($mostrar != "S"))
					echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
			else
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";			
		}		  
	?>
		  </select>
		  <select name="ano" size="1">
			<?php
		for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
		{
			if (($mostrar == "S") && ($i == $ano))
				echo "<option selected value ='$i'>$i</option>";
			else if (($i == date("Y")) && ($mostrar != "S"))
				echo "<option selected value ='$i'>$i</option>";
			else	
				echo "<option value='".$i."'>".$i."</option>";
		}
	?>
		  </select>
      &nbsp; 
      <select name="hh" id="select5">
        <?php
		 	for($i=0; $i<=23; $i++)
			{
				if (($mostrar == "S") && ($i == $hh))
					echo '<option selected value ="'.$i.'">'.$i.'</option>';
				else if (($i == date("H")) && ($mostrar != "S"))
					echo '<option selected value="'.$i.'">'.$i.'</option>';
				else	
					echo '<option value="'.$i.'">'.$i.'</option>';
			}
		?>
      </select>
      : 
      <select name="mm">
        <?php
		 	for($i=0; $i<=59; $i++)
			{
				if (($mostrar == "S") && ($i == $mm))
					echo '<option selected value ="'.$i.'">'.$i.'</option>';
				else if (($i == date("i")) && ($mostrar != "S"))
					echo '<option selected value ="'.$i.'">'.$i.'</option>';
				else	
					echo '<option value="'.$i.'">'.$i.'</option>';
			}
		?>
      </select> </td>
</tr>
</table>
<br>
<table width="600" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr> 
    <td width="130"> Peso Autom&aacute;tico</td>
    <td width="458"> <input name="checkpeso" type="checkbox" id="checkpeso" value="checkbox" <?php echo $peso_auto ?>>
      Lodos </td>
  </tr>
</table>
<br>
<table width="599" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr>
    <td height="29">&nbsp;</td>
    <td>
	<?php
		if (($recargapag4 == "S") and ($listar_ie == "P"))		
			echo '<input type="radio" name="radio" onClick="Listar_IE(P)" checked>';
		else
			echo '<input type="radio" name="radio" onClick="Listar_IE(\'P\')">';
	?>
      Prog. 
	<?php
   		if (($recargapag4 == "S") and ($listar_ie == "V"))
			echo '<input type="radio" name="radio" onClick="Listar_IE(\'V\')" checked>';
		else
			echo '<input type="radio" name="radio" onClick="Listar_IE(\'V\')">';
	?>
      Virtual </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td width="50" height="29">I.E.</td>
    <td width="226"> 
<?php
	//Crea tabla temporal.
	$temporal = "CREATE TEMPORARY TABLE IF NOT EXISTS sec_web.instrucciones";
	$temporal.= " (corr_ie bigint(8), cod_producto varchar(10), cod_subproducto varchar(10), peso_programado bigint(12),";
	$temporal.= " promedio_paquete bigint(12), fecha date)";
	//echo $temporal."<br>";
	mysqli_query($link, $temporal);

	if (($recargapag4 == "S") and ($listar_ie == "P"))
	{
		
		//Instrucciones de Enami.
		$consulta = "SELECT corr_enm, cod_producto,cod_subproducto, (cantidad_embarque * 1000) AS cantidad_embarque, estado2, fecha_disponible";
		$consulta.= " FROM sec_web.programa_enami";
		$consulta.= " WHERE ((estado1 = '' AND estado2 NOT IN ('A','C') AND NOT ISNULL(num_prog_loteo))";
		$consulta.= " OR (estado1 = 'R' and estado2 = 'P')) AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
		$consulta.= " ORDER BY fecha_disponible";
		$rs = mysqli_query($link, $consulta);
		//echo $consulta."<br>";

		while ($row = mysqli_fetch_array($rs))
		{	
			$promedio = 0;
			//Consulta si tiene paqutes esa intruccion.
			if ($row["estado2"] == "P")
			{				
				$consulta = "SELECT IFNULL(SUM(t2.peso_paquetes),0) AS peso, COUNT(*) AS cantidad FROM sec_web.lote_catodo AS t1";
				$consulta.= " INNER JOIN sec_web.paquete_catodo AS t2";
				$consulta.= " ON t1.cod_paquete = t2.cod_paquete AND t1.num_paquete = t2.num_paquete AND t2.cod_estado = 'a'";				
				$consulta.= " WHERE t1.corr_enm = '".$row["corr_enm"]."' AND t1.disponibilidad = 'P'";
				//echo $consulta."<br>";
				$rs1 = mysqli_query($link, $consulta);
				$row1 = mysqli_fetch_array($rs1);
	
				if ($row1[cantidad] == 0)
					$promedio = 0;
				else
					$promedio = round($row1["peso"] / $row1[cantidad]);							
			}
			$insertar = "INSERT INTO sec_web.instrucciones (corr_ie,cod_producto,cod_subproducto,peso_programado,promedio_paquete,fecha)";
			$insertar.= " VALUES ('".$row["corr_enm"]."', '".$row["cod_producto"]."', '".$row["cod_subproducto"]."', '".$row[cantidad_embarque]."',";
			$insertar.= " '".$promedio."', '".$row["fecha_disponible"]."')";
			//echo $insertar."<br>";
			mysqli_query($link, $insertar);
		}
		
		//Intrucciones de Codelco.
		$consulta = "SELECT corr_codelco, cod_producto,cod_subproducto, (cantidad_programada * 1000) AS cantidad_programada, estado2, fecha_disponible";
		$consulta.= " FROM sec_web.programa_codelco";
		$consulta.= " WHERE ((estado1 = '' AND estado2 NOT IN ('A','C') AND NOT ISNULL(num_prog_loteo))";
		$consulta.= " OR (estado1 = 'R' and estado2 = 'P')) AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
		$consulta.= " ORDER BY fecha_disponible";		
		$rs = mysqli_query($link, $consulta);
		//echo $consulta."<br>";

		while ($row = mysqli_fetch_array($rs))
		{
			$promedio = 0;
			//Consulta si tiene paquetes esa intruccion.
			if ($row["estado2"] == "P")
			{				
				$consulta = "SELECT IFNULL(SUM(t2.peso_paquetes),0) AS peso, COUNT(*) AS cantidad FROM sec_web.lote_catodo AS t1";
				$consulta.= " INNER JOIN sec_web.paquete_catodo AS t2";
				$consulta.= " ON t1.cod_paquete = t2.cod_paquete AND t1.num_paquete = t2.num_paquete AND t2.cod_estado = 'a'";				
				$consulta.= " WHERE t1.corr_enm = '".$row["corr_codelco"]."' AND t1.disponibilidad = 'P'";
				//echo $consulta."<br>";
				$rs1 = mysqli_query($link, $consulta);
				$row1 = mysqli_fetch_array($rs1);
				if ($row1[cantidad] == 0)
					$promedio = 0;
				else	
					$promedio = round($row1["peso"] / $row1[cantidad]);							
			}
			$insertar = "INSERT INTO sec_web.instrucciones (corr_ie,cod_producto,cod_subproducto,peso_programado,promedio_paquete,fecha)";
			$insertar.= " VALUES ('".$row["corr_codelco"]."', '".$row["cod_producto"]."', '".$row["cod_subproducto"]."', '".$row[cantidad_embarque]."',";
			$insertar.= " '".$promedio."', '".$row["fecha_disponible"]."')";
			//echo $insertar."<br>";
			mysqli_query($link, $insertar);		
		}
	}
	
	if (($recargapag4 == "S") and ($listar_ie == "V"))	
	{
		$consulta = "SELECT * FROM sec_web.instruccion_virtual";
		$consulta.= " WHERE cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
		$consulta.= " AND estado <> 'T'";
		$consulta.= " ORDER BY fecha_embarque, corr_virtual";
		//echo $consulta."<br>";
		$rs = mysqli_query($link, $consulta);
		while ($row = mysqli_fetch_array($rs))
		{
			$consulta = "SELECT IFNULL(SUM(t2.peso_paquetes),0) AS peso, COUNT(*) AS cantidad FROM sec_web.lote_catodo AS t1";
			$consulta.= " INNER JOIN sec_web.paquete_catodo AS t2";
			$consulta.= " ON t1.cod_paquete = t2.cod_paquete AND t1.num_paquete = t2.num_paquete AND t2.cod_estado = 'a'";				
			$consulta.= " WHERE t1.corr_enm = '".$row[corr_virtual]."' AND t1.disponibilidad = 'P'";
			//echo $consulta."<br>";
			$rs1 = mysqli_query($link, $consulta);
			$row1 = mysqli_fetch_array($rs1);
			if ($row1[cantidad] == 0)
				$promedio = 0;
			else	
				$promedio = round($row1["peso"] / $row1[cantidad]);		
		
		
			$insertar = "INSERT INTO sec_web.instrucciones (corr_ie,cod_producto,cod_subproducto,peso_programado,promedio_paquete,fecha)";
			$insertar.= " VALUES ('".$row[corr_virtual]."', '".$row["cod_producto"]."', '".$row["cod_subproducto"]."', '".$row["peso_programado"]."',";
			$insertar.= "'".$promedio."', '".$row["fecha_embarque"]."')";
			//echo $insertar."<br>";
			mysqli_query($link, $insertar);
		}
				
	}	
								
	echo '<select name="cmbinstruccion" onChange="BuscarIE_Lodo()">';
	echo '<option value="-1">I.E - Prom. Paq</option>';
	
	$consulta = "SELECT corr_ie, promedio_paquete FROM sec_web.instrucciones ORDER BY fecha";
	$rs3 = mysqli_query($link, $consulta);
	while ($row3 = mysqli_fetch_array($rs3))
	{		
		if (strlen($row3["corr_ie"]) == 4)
		{ 
			$linea = "0".$row3["corr_ie"]." - ".$row3[promedio_paquete];		
		}
		else
			$linea = $row3["corr_ie"]." - ".$row3[promedio_paquete];
			
		if ($cmbinstruccion == $row3["corr_ie"])
			echo '<option value="'.$row3["corr_ie"].'" selected>'.$linea.'</option>';
		else	
			echo '<option value="'.$row3["corr_ie"].'">'.$linea.'</option>';
	}
	echo '</select>';
	
	$temporal = "DROP TABLE sec_web.instrucciones";
	mysqli_query($link, $temporal);
?>
      <input name="btnvirtual" type="button" value="I.E. Virtual" onClick="CreaVirtual()"></td>
    <td width="88"> Peso Prog.(Kgrs)</td>
    <td width="211"> <input name="txtpesoprog" type="text" value="<?php echo $txtpesoprog ?>" size="12" maxlength="12"> 
      <input name="btnok2" type="button" value="OK" onClick="AgregaPeso()"> &nbsp; 
      <?php
		if (($cmbinstruccion <> "-1") and ($encontro_ie == "S"))
		{
			$consulta = "SELECT IFNULL(SUM(peso_paquetes),0) AS peso FROM sec_web.lote_catodo AS t1";
			$consulta.= " INNER JOIN sec_web.paquete_catodo AS t2";
			$consulta.= " ON t1.cod_paquete = t2.cod_paquete AND t1.num_paquete = t2.num_paquete AND t2.cod_estado = 'a'";
			//$consulta.= " WHERE t1.cod_bulto = '".$cod_paq[$cmbcodlote]."' AND t1.num_bulto = '".$txtnumlote."'";
			$consulta.= " WHERE t1.corr_enm = '".$cmbinstruccion."'";
			//echo $consulta."<br>";
		
			$rs = mysqli_query($link, $consulta);
			$row = mysqli_fetch_array($rs);
			$pesoacumulado = $row["peso"];
		}
		else 
			$pesoacumulado = 0;
		
			  	
		echo '<input name="pesoacumulado" type="text" size="10" maxlength="10" value="'.$pesoacumulado.'">';
	?>
    </td>
  </tr>
  <tr> 
    <td height="29">Lote</td>
    <td><select name="cmbcodlote">
        <?php
		$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase";
		$consulta.= " WHERE cod_clase = '3004'";		
		$rs = mysqli_query($link, $consulta);
		while ($row = mysqli_fetch_array($rs))
		{	
			if ($row["cod_subclase"] == date("n"))		
				echo '<option value="'.$row["cod_subclase"].'" selected>'.$row["nombre_subclase"].'</option>';
			else 			
				echo '<option value="'.$row["cod_subclase"].'">'.$row["nombre_subclase"].'</option>';				
		}
	?>
      </select>
      - 
      <input name="txtnumlote" type="text" size="10" maxlength="10" onBlur="ValidaLote()" value="<?php echo $txtnumlote ?>"></td>
    <td>Marca</td>
    <td> <input name="txtmarca" type="text" value="<?php echo $txtmarca ?>"> <input type="button" name="Button" value="marca" onClick="VerMarca()"></td>
  </tr>
</table>
<br>
<?php
/*
?>
<table width="600" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr> 
    <td width="90">Peso Faltante</td>
    <td width="89"> 
      <?php	  	  
	  	if (($cmbinstruccion <> "-1") and ($encontro_ie == "S"))
		{		
			$consulta = "SELECT IFNULL(SUM(peso_paquetes),0) AS peso FROM sec_web.lote_catodo AS t1";
			$consulta.= " INNER JOIN sec_web.paquete_catodo AS t2";
			$consulta.= " ON t1.cod_paquete = t2.cod_paquete AND t1.num_paquete = t2.num_paquete AND t2.cod_estado = 'a'";
			//$consulta.= " WHERE t1.cod_bulto = '".$cod_paq[$cmbcodlote]."' AND t1.num_bulto = '".$txtnumlote."'";
			$consulta.= " WHERE t1.corr_enm = '".$cmbinstruccion."'";
			//echo $consulta;
			$rs = mysqli_query($link, $consulta);
			$row = mysqli_fetch_array($rs);
			$pesofaltante = ($txtpesoprog - $row["peso"]);
		}
		else
			$pesofaltante = 0;
	  	
		echo '<input name="pesofaltante" type="text" size="10" maxlength="10" value="'.$pesofaltante.'">';
	?>
    </td>
    <td width="98">Cant. Paquetes</td>
    <td width="100">
      <input name="txtcantiadad" type="text" id="txtcantidad" onBlur="CalculaPromedio()" size="10">
	</td>
    <td width="98">Prom. Paquete</td>
    <td width="89"><input name="txtpromedio" type="text" id="txtpromedio" size="10"></td>
  </tr>
</table>
<br>
<?php
*/
?>	
<table width="600" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr> 
    <td width="298">Codigo de Serie</td>
    <td width="296">
	<select name="cmbcodpaq">
	<option value="-1">CODIGO</option> 
	<?php
		if (($opcion == "M") or (($genera_lote == "S") and ($paq_inicial == "S")) or ($agrega_paq == "S"))
		{
			$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase";
			$consulta.= " WHERE cod_clase = '3004'";		
			$rs = mysqli_query($link, $consulta);
			while ($row = mysqli_fetch_array($rs))
			{
				if (($row["nombre_subclase"] == $cmbcodpaq) or ($row["cod_subclase"] == $cmbcodpaq))
					echo '<option value="'.$row["cod_subclase"].'" selected>'.$row["nombre_subclase"].'</option>';
				else
					echo '<option value="'.$row["cod_subclase"].'">'.$row["nombre_subclase"].'</option>';
			}			
		}		
		else
		{
			echo '<option>aqui</option>';
			$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase";
			$consulta.= " WHERE cod_clase = '3004'";		
			$rs = mysqli_query($link, $consulta);
			while ($row = mysqli_fetch_array($rs))
			{	
				if ($row["cod_subclase"] == date("n"))		
				{
					echo '<option value="'.$row["cod_subclase"].'" selected>'.$row["nombre_subclase"].'</option>';
					$consulta = "SELECT IFNULL(MAX(num_paquete)+1,1) AS serie FROM sec_web.paquete_catodo";
					$consulta.= " WHERE cod_paquete = '".$row["nombre_subclase"]."'";
					$consulta.= " AND YEAR(fecha_creacion_paquete) = YEAR(NOW())";
					$rs1 = mysqli_query($link, $consulta);
					$row1 = mysqli_fetch_array($rs1);
					$txtnumpaq = $row1[serie];
				}
				else 			
					echo '<option value="'.$row["cod_subclase"].'">'.$row["nombre_subclase"].'</option>';				
			}		
		}		
	?>
   	</select></td>
  </tr>
  <tr>
    <td>N&deg; de Serie</td>
    <td><input name="txtnumpaq" type="text" id="txtnumpaq"  value="<?php echo $txtnumpaq ?>" size="10" maxlength="10"></td>
  </tr>
</table>
<br>


<?php
	if (($etapa == 2) or ($etapa == 3))
	{
?>
<table width="600" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr> 
    <td width="126">Unidades</td>
    <td width="119"> 
      <?php
		echo '<input name="txtunidades" type="text" value="'.$txtunidades.'" size="5" maxlength="2" onBlur="CalculaPesoBolsa()">';
	?>
    </td>
    <td width="163">Peso Unitario Bolsa</td>
    <td width="168"><input name="txtpesounitario" type="text" value="0.083" size="10" maxlength="10"></td>
  </tr>
  <tr> 
    <td>Peso Bolsas</td>
    <td><input name="txtpesobolsa" type="text" size="10" maxlength="10" value="<?php echo $txtpesobolsa ?>"></td>
    <td>Peso Tara</td>
    <td><input name="txtpesotara" type="text" size="10" value="<?php echo $txtpesotara ?>">
	<?php
		if ($etapa == 3)
      		echo '<input name="btnok2" type="button" id="btnok2" value="OK" onClick="ReCalculaCajon()">';
	?>	  
	  </td>
  </tr>
</table>
<?php
	}
?>

<br>
<table width="600" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr> 
<?php
	if (($etapa == 2) or ($etapa == 3))
	{
?>  
    <td width="127">Peso Neto</td>
    <td width="121">
<?php
	if ($opcion == "M")
		echo '<input name="txtpesoneto" type="text" size="10" value="'.$txtpesoneto.'"></td>';
	else 
		echo '<input name="txtpesoneto" type="text" size="10" value="'.$txtpesoneto.'"></td>';	
?>
<?php
	}
?>
    <td width="161">Peso Bruto</td>
    <td width="167">
<?php	
	if ($opcion == "M")
		echo '<input name="txtpeso" type="text" size="10" value="'.$txtpeso.'" onKeyDown="TeclaPulsada3(4)"></td>';
	else
		echo '<input name="txtpeso" type="text" size="10" onKeyDown="TeclaPulsada3(4)"></td>';
?>
  </tr>
	<?php
		//Activa la Funcion JavaScript para poner el Peso Automaticamente.
		echo '<script language="JavaScript"> PesoAutomatico(); </script>';
	?>	  
</table>
<br>
