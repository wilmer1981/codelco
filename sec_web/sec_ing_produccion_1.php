<?php
	//RECEPCION.
	
	//Asigna a un arreglo los codigos de paqutes.
	$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 3004";
	$rs = mysqli_query($link, $consulta);
	$cod_paq = array();
	while ($row = mysqli_fetch_array($rs))
	{
		$cod_paq[$row["cod_subclase"]] = $row["nombre_subclase"];
	}		
	
	//Campo Ocultos.
	echo '<input name="etapa" type="hidden" value="1">';
	echo '<input name="fecha_aux" type="hidden" value="'.$ano.'-'.$mes.'-'.$dia.'">';
	echo '<input name="encontro_ie" type="hidden" value="'.$encontro_ie.'">';
	echo '<input name="genera_lote" type="hidden" value="'.$genera_lote.'">';
	echo '<input name="agrega_paq" type="hidden" value="'.$agrega_paq.'">';
	echo '<input name="peso_prog_ok" type="hidden" value="'.$peso_prog_ok.'">';
	echo '<input name="pantalla" type="hidden" value="'.$tipo_reg.'">';
	
	if ($opcion == "M")
		echo '<input name="peso_aux" type="hidden" value="'.$txtpeso.'">';	
	
	if ($encontro_ie == "S")
		echo '<input name="tipo_ie" type="hidden" value="'.$tipo_ie.'">';
	else
		echo '<input name="tipo_ie" type="hidden" value="">';	
	
	
	
	
	
	//Campo Ocultos.
	echo '<input type="hidden" name="tipo_reg" value="'.$tipo_reg.'">'; //Lote ó Paquete.
	echo '<input name="fecha_aux" type="hidden" value="'.$ano.'-'.$mes.'-'.$dia.'">';

	if ($existe_sec == "S")
		echo '<input name="existe_sec" type="hidden" value="S">';
	else 
		echo '<input name="existe_sec" type="hidden" value="N">';
		
	if ($existe_rec == "S")
		echo '<input name="existe_rec" type="hidden" value="S">';
	else
		echo '<input name="existe_rec" type="hidden" value="N">';	
			
?>
<?php
	if ($cmbproducto == "18") 
	{
?>

<table width="600" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
	 <tr> 
		
    <td width="261">Fecha de Pesaje</td>
		
    <td width="327"> 
<SELECT name="dia" size="1">
			<?php
		$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		for ($i=1;$i<=31;$i++)
		{	
			if (($mostrar == "S") && ($i == $dia))			
				echo "<option SELECTed value= '".$i."'>".$i."</option>";				
			else if (($i == date("j")) and ($mostrar != "S")) 
					echo "<option SELECTed value= '".$i."'>".$i."</option>";											
			else					
				echo "<option value='".$i."'>".$i."</option>";												
		}		
	?>
		  </SELECT>
		  <SELECT name="mes" size="1" id="SELECT">
			<?php
		for($i=1;$i<13;$i++)
		{
			if (($mostrar == "S") && ($i == $mes))
				echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
			else if (($i == date("n")) && ($mostrar != "S"))
					echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
			else
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";			
		}		  
	?>
		  </SELECT>
		  <SELECT name="ano" size="1">
			<?php
		for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
		{
			if (($mostrar == "S") && ($i == $ano))
				echo "<option SELECTed value ='$i'>$i</option>";
			else if (($i == date("Y")) && ($mostrar != "S"))
				echo "<option SELECTed value ='$i'>$i</option>";
			else	
				echo "<option value='".$i."'>".$i."</option>";
		}
	?>
		  </SELECT>
      &nbsp; 
      <SELECT name="hh" id="SELECT5">
        <?php
		 	for($i=0; $i<=23; $i++)
			{
				if (($mostrar == "S") && ($i == $hh))
					echo '<option SELECTed value ="'.$i.'">'.$i.'</option>';
				else if (($i == date("H")) && ($mostrar != "S"))
					echo '<option SELECTed value="'.$i.'">'.$i.'</option>';
				else	
					echo '<option value="'.$i.'">'.$i.'</option>';
			}
		?>
      </SELECT>
      : 
      <SELECT name="mm">
        <?php
		 	for($i=0; $i<=59; $i++)
			{
				if (($mostrar == "S") && ($i == $mm))
					echo '<option SELECTed value ="'.$i.'">'.$i.'</option>';
				else if (($i == date("i")) && ($mostrar != "S"))
					echo '<option SELECTed value ="'.$i.'">'.$i.'</option>';
				else	
					echo '<option value="'.$i.'">'.$i.'</option>';
			}
		?>
      </SELECT> &nbsp; </td>
</tr>
</table>
<br>
<table width="600" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr> 
    <td width="130"> Peso Automático</td>
    <td width="458">
	<input name="checkpeso" type="checkbox" id="checkpeso" value="checkbox" <?php echo $peso_auto ?>>
	</td>
  </tr>
</table>
<br>
<table width="600" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr> 
    <td width="294">N&deg; de Lote Ventana</td>
    <td width="118"> 
      <?php	
	  //echo "EE".$existe_rec;
		if (($existe_rec == "S") or ($opcion == "M"))   
		{
		//'".str_pad($txtlote,8,'0',STR_PAD_LEFT)."'
			echo '<input name="txtlote" type="text" size="10" value="'.str_pad($txtlote,8,'0',STR_PAD_LEFT).'" maxlength="8"> - ';
			echo '<input name="txtrecargo" type="text" size="1" value="'.$txtrecargo.'" maxlength="1">';
		}
		else
		{
			echo '<input name="txtlote" type="text" size="10" maxlength="10"> - ';		
			echo '<input name="txtrecargo" type="text" size="1" maxlength="1">';
		}
	
	  ?>
    <td width="170"><input name="btnbuscar" type="button" value="Buscar" onClick="Buscar()"></td>
  </tr>
  
</table>
<br>

<?php
	if ((($existe_sec == "S") and ($existe_rec == "S")) or (($opcion == "M") and ($tipo_reg == "P")))
	{ 
?>
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
    <td width="70" height="29">I.E.</td>
    <td width="214"> 
      <?php
	if ($opcion == "M")	
	{
		echo '<SELECT name="cmbinstruccion">';
		echo '<option value="'.$cmbinstruccion.'">'.$cmbinstruccion.'</option>';
		echo '</SELECT>';
	}
	else
	{
		//Crea tabla temporal.
		$temporal = "CREATE TEMPORARY TABLE IF NOT EXISTS sec_web.instrucciones";
		$temporal.= " (corr_ie bigint(8), cod_producto varchar(10), cod_subproducto varchar(10), peso_programado bigint(12), fecha date)";
		//echo $temporal."<br>";
		mysqli_query($link, $temporal);
	
		if (($recargapag4 == "S") and ($listar_ie == "P"))
		{
			
			//Instrucciones de Enami.
			$consulta = "SELECT corr_enm, cod_producto,cod_subproducto, (cantidad_embarque * 1000) AS cantidad_embarque, estado2, fecha_disponible";
			$consulta.= " FROM sec_web.programa_enami";
			$consulta.= " WHERE ((estado1 = '' AND estado2 NOT IN ('A','C') AND NOT ISNULL(num_prog_loteo))";
			$consulta.= " OR (estado1 = 'R' and estado2 = 'P') OR (estado1 = 'R' AND estado2 = 'A') OR (estado1 = 'R' AND estado2 = 'M')) AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
			$consulta.= " ORDER BY fecha_disponible";
			$rs = mysqli_query($link, $consulta);
			//echo $consulta."<br>";
	
			while ($row = mysqli_fetch_array($rs))
			{	
				/*
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
				*/
				$insertar = "INSERT INTO sec_web.instrucciones (corr_ie,cod_producto,cod_subproducto,peso_programado,fecha)";
				$insertar.= " VALUES ('".$row["corr_enm"]."', '".$row["cod_producto"]."', '".$row["cod_subproducto"]."', '".$row[cantidad_embarque]."',";
				$insertar.= " '".$row["fecha_disponible"]."')";
				//echo $insertar."<br>";
				mysqli_query($link, $insertar);
			}
			
			//Intrucciones de Codelco.
			$consulta = "SELECT corr_codelco, cod_producto,cod_subproducto, (cantidad_programada * 1000) AS cantidad_programada, estado2, fecha_disponible";
			$consulta.= " FROM sec_web.programa_codelco";
			$consulta.= " WHERE ((estado1 = '' AND estado2 NOT IN ('A','C') AND NOT ISNULL(num_prog_loteo))";
			$consulta.= " OR (estado1 = 'R' and estado2 = 'P') OR (estado1 = 'R' AND estado2 = 'A') OR (estado1 = 'R' AND estado2 = 'M')) AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
			$consulta.= " ORDER BY fecha_disponible";
			$rs = mysqli_query($link, $consulta);
			//echo $consulta."<br>";
	
			while ($row = mysqli_fetch_array($rs))
			{
				/*
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
				*/
				$insertar = "INSERT INTO sec_web.instrucciones (corr_ie,cod_producto,cod_subproducto,peso_programado,fecha)";
				$insertar.= " VALUES ('".$row["corr_codelco"]."', '".$row["cod_producto"]."', '".$row["cod_subproducto"]."', '".$row["cantidad_programada"]."',";
				$insertar.= "  '".$row["fecha_disponible"]."')";
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
				/*
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
				*/
			
				$insertar = "INSERT INTO sec_web.instrucciones (corr_ie,cod_producto,cod_subproducto,peso_programado,fecha)";
				$insertar.= " VALUES ('".$row[corr_virtual]."', '".$row["cod_producto"]."', '".$row["cod_subproducto"]."', '".$row["peso_programado"]."',";
				$insertar.= " '".$row["fecha_embarque"]."')";
				//echo $insertar."<br>";
				mysqli_query($link, $insertar);
			}
					
		}	
									
		echo '<SELECT name="cmbinstruccion" onChange="BuscarIE()">';
		echo '<option value="-1">I.E</option>';
		
		$consulta = "SELECT corr_ie FROM sec_web.instrucciones ORDER BY fecha";
		$rs3 = mysqli_query($link, $consulta);
		while ($row3 = mysqli_fetch_array($rs3))
		{		
			if (strlen($row3["corr_ie"]) == 4)
			{ 
				$linea = "0".$row3["corr_ie"];		
			}
			else
				$linea = $row3["corr_ie"];
				
			if ($cmbinstruccion == $row3["corr_ie"])
				echo '<option value="'.$row3["corr_ie"].'" SELECTed>'.$linea.'</option>';
			else	
				echo '<option value="'.$row3["corr_ie"].'">'.$linea.'</option>';
		}
		echo '</SELECT>';
		
		$temporal = "DROP TABLE sec_web.instrucciones";
		mysqli_query($link, $temporal);
	}
?>
      <input name="btnvirtual" type="button" value="I.E. Virtual" onClick="CreaVirtual()"></td>
    <td width="90"> Peso Prog.(Kgrs)</td>
    <td width="201"> 
	<?php
	/*
		if ($opcion == "M")
			echo '<input name="txtpesoprog" type="text" value="'.$txtpesoprog.'" size="12" maxlength="12">';
		else
*/
		$txtpesoprog = 0;
		//Consulta el peso de la I.E.			
		if ($listar_ie == "P") //Del Programa.
		{
			$consulta = "SELECT * FROM sec_web.programa_enami";
			$consulta.= " WHERE corr_enm = '".$cmbinstruccion."' AND estado1 = 'R'";
			$consulta.= " AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
			//echo $consulta."<br>";
			$rs = mysqli_query($link, $consulta);
			if ($row = mysqli_fetch_array($rs))
			{
				$txtpesoprog = ($row[cantidad_embarque] * 1000);
			}
			else
			{	
				$consulta = "SELECT * FROM sec_web.programa_codelco";
				$consulta.= " WHERE corr_codelco = '".$cmbinstruccion."' AND estado1 = 'R'";
				$consulta.= " AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
				//echo $consulta."<br>";				
				$rs1 = mysqli_query($link, $consulta);				
				if ($row1 = mysqli_fetch_array($rs1))
					$txtpesoprog = ($row1["cantidad_programada"] * 1000);
				else
					$txtpesoprog = 0;	
			}
		}
		else //Virtual.
		{
			$consulta = "SELECT * FROM sec_web.instruccion_virtual";
			$consulta.= " WHERE corr_virtual = '".$cmbinstruccion."'";			
			//echo $consulta."<br>";
			$rs = mysqli_query($link, $consulta);
			if ($row = mysqli_fetch_array($rs))
				$txtpesoprog = $row["peso_programado"];
			else
				$txtpesoprog = 0;				
		}
		
		echo '<input name="txtpesoprog" type="text" value="'.$txtpesoprog.'" size="12" maxlength="12">';
	?>
	
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
		
			  	
		echo '<input name="pesoacumulado" type="text" size="10" maxlength="10" value="'.$pesoacumulado.'" readonly>';
	?>
    </td>
  </tr>
  <tr> 
    <td height="29">Lote Inicial</td>
    <td><SELECT name="cmbcodlote">
        <?php
/*		
		$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase";
		$consulta.= " WHERE cod_clase = '3004'";		
		$rs = mysqli_query($link, $consulta);
		while ($row = mysqli_fetch_array($rs))
		{	
			if ($row["cod_subclase"] == date("n"))		
				echo '<option value="'.$row["cod_subclase"].'" SELECTed>'.$row["nombre_subclase"].'</option>';
			else 			
				echo '<option value="'.$row["cod_subclase"].'">'.$row["nombre_subclase"].'</option>';				
		}
*/
       
		if (($opcion == "M") or (($genera_lote == "S") and ($paq_inicial == "S")) or ($agrega_paq == "S"))
		{
			$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase";
			$consulta.= " WHERE cod_clase = '3004'";		
			$rs = mysqli_query($link, $consulta);
			while ($row = mysqli_fetch_array($rs))
			{
				if (($row["cod_subclase"] == $cmbcodlote) or ($row["nombre_subclase"] == $cmbcodlote))
					echo '<option value="'.$row["cod_subclase"].'" SELECTed>'.$row["nombre_subclase"].'</option>';
				else
					echo '<option value="'.$row["cod_subclase"].'">'.$row["nombre_subclase"].'</option>';
			}		
		}		
		else
		{
			$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase";
			$consulta.= " WHERE cod_clase = '3004'";		
			$rs = mysqli_query($link, $consulta);
			while ($row = mysqli_fetch_array($rs))
			{	
				if ($row["cod_subclase"] == date("n"))		
					echo '<option value="'.$row["cod_subclase"].'" SELECTed>'.$row["nombre_subclase"].'</option>';
				else 			
					echo '<option value="'.$row["cod_subclase"].'">'.$row["nombre_subclase"].'</option>';				
			}
		}		
	?>
      </SELECT>
      - 
      <input name="txtnumlote" type="text" size="10" maxlength="10" onBlur="ValidaLote()" value="<?php echo $txtnumlote ?>"></td>
    <td>Marca</td>
    <td> <input name="txtmarca" type="text" value="<?php echo $txtmarca ?>"> <input type="button" name="Button" value="marca" onClick="VerMarca()"></td>
  </tr>
</table>
<br>
<table width="600" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr> 
    <td width="298">Codigo de Serie</td>
    <td width="296"> <SELECT name="cmbcodpaq">  
        <option value="-1">CODIGO</option>
        <?php
		if (($opcion == "M") or (($genera_lote == "S") and ($paq_inicial == "S")) or ($agrega_paq == "S"))
		{
			$var1=$opcion;
			$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase";
			$consulta.= " WHERE cod_clase = '3004'";		
			$rs = mysqli_query($link, $consulta);
			while ($row = mysqli_fetch_array($rs))
			{
				if (($row["nombre_subclase"] == $cmbcodpaq) or ($row["cod_subclase"] == $cmbcodpaq))
					echo '<option value="'.$row["cod_subclase"].'" SELECTed>'.$row["nombre_subclase"].'</option>';
				else
					echo '<option value="'.$row["cod_subclase"].'">'.$row["nombre_subclase"].'</option>';
			}			
		}		
		else
		{
			$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase";
			$consulta.= " WHERE cod_clase = '3004'";		
			$rs = mysqli_query($link, $consulta);
			while ($row = mysqli_fetch_array($rs))
			{	
				if ($row["cod_subclase"] == date("n"))		
				{
					echo '<option value="'.$row["cod_subclase"].'" SELECTed>'.$row["nombre_subclase"].'</option>';
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
		
		$cod = $cmbcodpaq;
	?>
      </SELECT></td>
  </tr>
  <tr>   
    <td>N&deg; de Serie</td>
<?php	
	//echo "CCC----".$codlote;
	echo '<input name="codigopaquete" type="hidden" size="10" maxlength="10" value="'.$cod.'" >';	?>

    <td><input name="txtnumpaq" type="text" id="txtnumpaq"  value="<?php echo $txtnumpaq ?>" size="10" maxlength="10"></td>
  </tr>
</table>
<br>
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
	  	
		echo '<input name="pesofaltante" type="text" size="10" maxlength="10" value="'.$pesofaltante.'" readonly>';
	?>
    </td>
    <td width="98">Cant. Paquetes</td>
    <td width="100">
	<?php     
	 	//<input name="txtcantiadad" type="text" id="txtcantidad" onBlur="CalculaPromedio()" size="10">
		
		$consulta = "SELECT IFNULL(SUM(t2.peso_paquetes),0) AS peso, COUNT(*) AS cantidad FROM sec_web.lote_catodo AS t1";
		$consulta.= " INNER JOIN sec_web.paquete_catodo AS t2";
		$consulta.= " ON t1.cod_paquete = t2.cod_paquete AND t1.num_paquete = t2.num_paquete AND t2.cod_estado = 'a'";				
		$consulta.= " WHERE t1.corr_enm = '".$cmbinstruccion."' AND t1.disponibilidad = 'P'";
		$rs = mysqli_query($link, $consulta);
		$row = mysqli_fetch_array($rs);
		
		$peso_prom_paq = 0;
		if ($row["peso"] != 0)		
		{
			$peso_prom_paq = round($row["peso"] / $row[cantidad]);
			//echo $peso_prom_paq."<br>"; //promedio legal por paquete acumulado.
			//echo $pesofaltante."<br>";
			
			if ($peso_prom_paq != 0)
				$cant_paq_prom = round($pesofaltante / $peso_prom_paq);
			else
				$cant_paq_prom = 0;
				
			if ($cant_paq_prom != 0)	
				$peso_prom_paq = floor($pesofaltante / $cant_paq_prom);
				
			echo '<input name="txtcantiadad" type="text" size="10" value="'.$cant_paq_prom.'" readonly>';
		}
		else
			echo '<input name="txtcantidad" type="text" size="10" value="" readonly>';
	?>	  	
	</td>
    <td width="98">Prom. Paquete</td>
    <td width="89">
	<?php
		echo '<input name="txtpromedio" type="text" size="10" value="'.$peso_prom_paq.'" readonly>';
	?>	
	</td>
  </tr>
</table>
<br>
<?php
	}
?>

<?php
	if ((($existe_sec == "N") and ($existe_rec == "S")) or (($opcion == "M") and ($tipo_reg == "L")))
	{	
?>
<table width="600" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr> 
    <td width="147">N° Guia</td>
    <td width="143"><input name="txtguia" type="text" size="12" value="<?php echo $txtguia ?>" readonly></td>
    <td width="148">Patente Camión</td>
    <td width="138"><input name="txtpatente" type="text" size="12" value="<?php echo $txtpatente ?>" readonly></td>
  </tr>
  <tr> 
    <td>Rut</td>
    <td><input name="txtrut" type="text" size="12" value="<?php echo $txtrut ?>" readonly></td>
    <td>Peso Ventana</td>
    <td><input name="txtorigen" type="text" size="12" value="<?php echo $txtorigen ?>" readonly></td>
  </tr>
</table>
<br>
<?php
	}
?>
  
  
<table width="600" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr> 
  	<?php
		if (($existe_sec == "S") or (($opcion == "M") and ($tipo_reg == "P")))
		{
			echo '<td width="294">Unidades</td>';
			echo '<td width="294"><input name="txtunidades" type="text" size="10" value="'.$txtunidades.'"></td>';
		}
		
		if (($existe_sec == "N") and ($existe_rec == "S"))
		{
			echo '<td width="294">N° Paqutes</td>';
		    echo '<td width="294"><input name="txtpaquete" type="text" size="10" value="" maxlength="10"></td>';		
		}		
	?>
    <td width="294">Peso Origen</td>
    <td width="294"> <input name="txtpeso" type="text" value="<?php echo $txtpeso ?>" size="10" maxlength="10"></td>
	<?php
	  	if ((($existe_sec == "N") and ($existe_rec == "S")) or (($opcion == "M") and ($tipo_reg == "L")))
		{
			echo '<td width="294">Peso Zuncho</td>';
		    echo '<td width="294"><input name="txtzuncho" type="text" size="10" value="'.$txtzuncho.'" maxlength="10"></td>';
		}
	?>
	
	<?php
		//Activa la Funcion JavaScript para poner el Peso Automaticamente.
		echo '<script language="JavaScript"> PesoAutomatico(); </script>';
	?>	
  </tr>
</table>
  <br>
<?php
	}
?>    
