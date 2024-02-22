<?php
	//PAQUETE.

	if ($opcion == "M")
	{
		$ano = $ano2;
		$mes = $mes2;
		$dia = $dia2;
	}
	
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
	echo '<input name="paq_inicial" type="hidden" value="'.$paq_inicial.'">';
	
	if ($opcion == "M")
		echo '<input name="peso_aux" type="hidden" value="'.$peso.'">';
	
	if ($encontro_ie == "S")
		echo '<input name="tipo_ie" type="hidden" value="'.$tipo_ie.'">';
	else
		echo '<input name="tipo_ie" type="hidden" value="">';
		
		
	if ($activa_sipa == "S")	
		echo '<input name="tipo_ie" type="hidden" value="S">';
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
    </td>
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
    <td>Unid. Medida</td>
    <td>
	<?php
		if ($cmbproducto == 64 /*and ($cmbsubproducto == 8 or $cmbsubproducto == 7)*/)		
		{
			if ($opcion == "M")
				echo '<select name="cmbmedida" disabled>';
			else
				echo '<select name="cmbmedida">';
			echo '<option value="-1">SELECCIONAR</option>';		
			
			$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase";
			$consulta.= " WHERE cod_clase = '3015'";
			$consulta.= " ORDER BY cod_subclase";
			$rs = mysqli_query($link, $consulta);
			while ($row = mysqli_fetch_array($rs))
			{
				if ($opcion == "M")
				{
					if ($row["cod_subclase"] == $medida)
						echo '<option value="'.$row["cod_subclase"].'" selected>'.$row["nombre_subclase"].'</option>';				
					else
						echo '<option value="'.$row["cod_subclase"].'">'.$row["nombre_subclase"].'</option>';								
				}
				else
				{
					if ($row["cod_subclase"] == $cmbmedida)
						echo '<option value="'.$row["cod_subclase"].'" selected>'.$row["nombre_subclase"].'</option>';				
					else
						echo '<option value="'.$row["cod_subclase"].'">'.$row["nombre_subclase"].'</option>';				
				}
			}
	     	echo '</select>';
		}
	?>
	  </td>
  </tr>
  <tr> 
    <td width="72" height="29">I.E.</td>
    <td width="216"> 
<?php
	if ($opcion == "M")
	{
		echo '<select name="cmbinstruccion">';
		echo '<option value="'.$instruccion.'">'.$instruccion.'</option>';
		echo '</select>';
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
				if (($row["estado2"] == "P") or ($row["estado2"] == "A") or ($row["estado2"] == "M"))
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
			$consulta.= " WHERE ((estado1 = '' AND estado2 NOT IN ('A','C') AND NOT ISNULL(num_prog_loteo) and num_prog_loteo<>'0')";
			$consulta.= " OR (estado1 = 'R' and estado2 = 'P') OR (estado1 = 'R' AND estado2 = 'A') OR (estado1 = 'R' AND estado2 = 'M')) AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
			$consulta.= " ORDER BY fecha_disponible";		
			$rs = mysqli_query($link, $consulta);
			//echo $consulta."<br>";
	
			while ($row = mysqli_fetch_array($rs))
			{
				/*
				$promedio = 0;
				//Consulta si tiene paquetes esa intruccion.
				if (($row["estado2"] == "P") or ($row["estado2"] == "A") or ($row["estado2"] == "M"))
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
									
		echo '<select name="cmbinstruccion" onChange="BuscarIE()">';
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
				echo '<option value="'.$row3["corr_ie"].'" selected>'.$linea.'</option>';
			else	
				echo '<option value="'.$row3["corr_ie"].'">'.$linea.'</option>';
		}
		echo '</select>';
		
		$temporal = "DROP TABLE sec_web.instrucciones";
		mysqli_query($link, $temporal);
	}
	
?>
      <input name="btnvirtual" type="button" value="I.E. Virtual" onClick="CreaVirtual()"></td>
    <td width="79"> Peso Prog.(Kgrs)</td>
    <td width="208">
	<?php
		$txtpesoprog = 0;
		//Consulta el peso de la I.E.			
		if ($listar_ie == "P") //Del Programa.
		{
			if ($opcion == "M")
			{
				$consulta = "SELECT * FROM sec_web.programa_enami";
				$consulta.= " WHERE corr_enm = '".$instruccion."' AND estado1 = 'R'";
				$consulta.= " AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
			}
			else
			{
				$consulta = "SELECT * FROM sec_web.programa_enami";
				$consulta.= " WHERE ((estado1 = '' AND estado2 NOT IN ('A','C') AND NOT ISNULL(num_prog_loteo))";
				$consulta.= " OR (estado1 = 'R' AND (estado2 = 'P' OR estado2 = 'A' OR estado2 = 'M')))";
				$consulta.= " AND corr_enm = '".$cmbinstruccion."'";
				$consulta.= " AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
			}
			//echo $consulta."<br>";
			$rs = mysqli_query($link, $consulta);
			if ($row = mysqli_fetch_array($rs))
			{
				$txtpesoprog = ($row[cantidad_embarque] * 1000);
			}
			else
			{	
				if ($opcion == "M")
				{
					$consulta = "SELECT * FROM sec_web.programa_codelco";
					$consulta.= " WHERE corr_codelco = '".$instruccion."' AND estado1 = 'R'";
					$consulta.= " AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
				}
				else
				{
					$consulta = "SELECT * FROM sec_web.programa_codelco";
					$consulta.= " WHERE ((estado1 = '' AND estado2 NOT IN ('A','C') AND NOT ISNULL(num_prog_loteo))";
					$consulta.= " OR (estado1 = 'R' AND (estado2 = 'P' OR estado2 = 'A' OR estado2 = 'M')))";					
					$consulta.= " AND corr_codelco = '".$cmbinstruccion."'";
					$consulta.= " AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
				}				
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
			if ($opcion == "M")
			{
				$consulta = "SELECT * FROM sec_web.instruccion_virtual";
				$consulta.= " WHERE corr_virtual = '".$instruccion."'";
			}
			else
			{
				$consulta = "SELECT * FROM sec_web.instruccion_virtual";
				$consulta.= " WHERE corr_virtual = '".$cmbinstruccion."'";			
			}
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
		if ($opcion == "M")
		{	
			$consulta = "SELECT IFNULL(SUM(peso_paquetes),0) AS peso FROM sec_web.lote_catodo AS t1";
			$consulta.= " INNER JOIN sec_web.paquete_catodo AS t2";
			$consulta.= " ON t1.cod_paquete = t2.cod_paquete AND t1.num_paquete = t2.num_paquete AND t2.cod_estado = 'a' AND t1.fecha_creacion_paquete = t2.fecha_creacion_paquete";
			//$consulta.= " WHERE t1.cod_bulto = '".$cod_paq[$cmbcodlote]."' AND t1.num_bulto = '".$txtnumlote."'";
			$consulta.= " WHERE t1.corr_enm = '".$instruccion."'";
			//echo $consulta."<br>";
		
			$rs = mysqli_query($link, $consulta);
			$row = mysqli_fetch_array($rs);
			$pesoacumulado = $row["peso"];			
		}
		else
		{
			if (($cmbinstruccion <> "-1") and ($encontro_ie == "S"))
			{
				$consulta = "SELECT IFNULL(SUM(peso_paquetes),0) AS peso FROM sec_web.lote_catodo AS t1";
				$consulta.= " INNER JOIN sec_web.paquete_catodo AS t2";
				$consulta.= " ON t1.cod_paquete = t2.cod_paquete AND t1.num_paquete = t2.num_paquete AND t2.cod_estado = 'a' AND t1.fecha_creacion_paquete = t2.fecha_creacion_paquete";
				//$consulta.= " WHERE t1.cod_bulto = '".$cod_paq[$cmbcodlote]."' AND t1.num_bulto = '".$txtnumlote."'";
				$consulta.= " WHERE t1.corr_enm = '".$cmbinstruccion."'";
				//echo $consulta."<br>";
			
				$rs = mysqli_query($link, $consulta);
				$row = mysqli_fetch_array($rs);
				$pesoacumulado = $row["peso"];
			}
			else 
				$pesoacumulado = 0;
		}
			  	
		echo '<input name="pesoacumulado" type="text" size="10" maxlength="10" value="'.$pesoacumulado.'" readonly>';
	?>
    </td>
  </tr>
  <tr> 
    <td height="29">Lote Inicial</td>
    <td>
	<select name="cmbcodlote">
        <?php
		if (($opcion == "M") or (($genera_lote == "S") and ($paq_inicial == "S")) or ($agrega_paq == "S"))
		{
			echo '<option>aqui</option>';
			
			$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase";
			$consulta.= " WHERE cod_clase = '3004'";		
			$rs = mysqli_query($link, $consulta);
			while ($row = mysqli_fetch_array($rs))
			{
				if (($row["nombre_subclase"] == $codlote) or ($row["nombre_subclase"] == $cmbcodlote))
					echo '<option value="'.$row["cod_subclase"].'" selected>'.$row["nombre_subclase"].'</option>';
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
					echo '<option value="'.$row["cod_subclase"].'" selected>'.$row["nombre_subclase"].'</option>';
				else 			
					echo '<option value="'.$row["cod_subclase"].'">'.$row["nombre_subclase"].'</option>';				
			}
		}
	?>
      </select>
      - 
      <?php
	  	if ($opcion == "M")
			echo '<input name="txtnumlote" type="text" size="10" maxlength="10" value="'.$numlote.'">';
		else
	  		echo '<input name="txtnumlote" type="text" size="10" maxlength="10" onBlur="ValidaLote()" value="'.$txtnumlote.'">';
	  ?>
	  </td>	  
    <td>Marca</td>
    <td> 
	<?php
		if ($opcion == "M")
		{
			echo '<input name="txtmarca" type="text" value="'.$marca.'" readonly>';
			$Consulta="select descripcion from sec_web.marca_catodos where cod_marca='".$marca."'";
		}
		else
		{
			echo '<input name="txtmarca" type="text" value="'.$txtmarca.'" readonly>';
			$Consulta="select descripcion from sec_web.marca_catodos where cod_marca='".$txtmarca."'";
		}
		$RespMarca=mysqli_query($link, $Consulta);
		if($FilaMarca=mysqli_fetch_array($RespMarca))
			$txtnommarca=$FilaMarca["descripcion"];
	?>
	<input name="txtnommarca" type="hidden" value="<?php echo $txtnommarca ?>">
	<input type="button" name="Button" value="marca" onClick="VerMarca()"></td>
  </tr>
</table>
<br>


<?php
	//if (!($cmbproducto == '64' and ($cmbsubproducto == '8' or $cmbsubproducto == '7')))
	//{
?>
<table width="600" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr> 
    <td width="90">Peso Faltante</td>
    <td width="89"> 
      <?php	  	  
	  	if ($opcion == "M")	
		{
			$consulta = "SELECT IFNULL(SUM(peso_paquetes),0) AS peso FROM sec_web.lote_catodo AS t1";
			$consulta.= " INNER JOIN sec_web.paquete_catodo AS t2";
			$consulta.= " ON t1.cod_paquete = t2.cod_paquete AND t1.num_paquete = t2.num_paquete AND t2.cod_estado = 'a'";
			//$consulta.= " WHERE t1.cod_bulto = '".$cod_paq[$cmbcodlote]."' AND t1.num_bulto = '".$txtnumlote."'";
			$consulta.= " WHERE t1.corr_enm = '".$instruccion."'";
			//echo $consulta;
			$rs = mysqli_query($link, $consulta);
			$row = mysqli_fetch_array($rs);
			$pesofaltante = ($txtpesoprog - $row["peso"]);		
		}
		else
		{
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
	  	}
			
		if ($opcion == "M")
			echo '<input name="pesofaltante" type="text" size="10" maxlength="10" value="'.$pesofaltante.'" readonly>';
		else
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
		//echo "VVVV".$consulta;
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
	//}//64. 8-7.
?>	
<table width="601" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr> 
    <td width="294">Codigo de Serie</td>
    <td width="295">
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
				if (($row["nombre_subclase"] == $cmbcodpaq) or ($row["nombre_subclase"] == $codpaq))
					echo '<option value="'.$row["cod_subclase"].'" selected>'.$row["nombre_subclase"].'</option>';
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
    <td>
	<?php
		if ($opcion == "M")
			echo '<input name="txtnumpaq" type="text" id="txtnumpaq"  value="'.$numpaq.'" size="10" maxlength="10">';
		else 
			echo '<input name="txtnumpaq" type="text" id="txtnumpaq"  value="'.$txtnumpaq.'" size="10" maxlength="10">';
	?>
	</td>
  </tr>
</table>
<br>
<?php
	if ($cmbproducto == '64' and ($cmbsubproducto == '8' or $cmbsubproducto == '7'))
	{
?>
<table width="600" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr>
    <td width="155">SIPA</td>
    <td width="433"><select name="cmbsipa" onChange="RecargaSipa()">
        <option value="-1">SELECCIONAR</option>
		<?php
			if ($activa_sipa == "S")
			{
				switch ($cmbsubproducto)
				{
					case 8: $descrip = 'ARSENIATO FERRICO';
							break;
					case 7: $descrip = 'HIDROXIDO DE NIQUEL';		
							break;
				}
			
				$consulta = "SELECT * FROM rec_web.otros_pesajes";
				$consulta.= " WHERE desprd_a LIKE '".$descrip."' AND fecha_a = SUBSTRING(NOW(),1,10)";
				//echo $consulta."<br>";
				$rs = mysqli_query($link, $consulta);
				while ($row = mysqli_fetch_array($rs))
				{
					echo '<option value="'.$row[FECHA_A].'~'.$row[HORA_A].'~'.$row[PATENT_A].'~'.$row[PESONT_A].'">Fecha:'.$row[FECHA_A].' '.$row[HORA_A].'&nbsp;&nbsp;&nbsp;Patente:'.$row[PATENT_A].'&nbsp;&nbsp;&nbsp;Peso:'.$row[PESONT_A].'</option>';
				}
			}			
		?>
      </select>
	  </td>
  </tr>
</table>
<br>
<?php
	}
?>

<?php

if (!($cmbproducto == '64' /*and ($cmbsubproducto == '8' or $cmbsubproducto == '7')*/))
{

	if (($cmbproducto != '48') and ($cmbproducto != '37') and ($cmbproducto != '42'))
	{
		if (($cmbsubproducto != '42') and ($cmbsubproducto != '43') and ($cmbsubproducto != '44'))
		{
?>
<table width="600" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr> 
    <td width="143">Grupo</td>
    <td width="145">
	<?php
		if ($opcion == "M")
			echo '<input name="txtgrupo" type="text" value="'.$grupo.'" size="5" maxlength="2" onBlur="RecargaGrupo()" onKeyDown="TeclaPulsada3(1)">';
		else
			echo '<input name="txtgrupo" type="text" value="'.$txtgrupo.'" size="5" maxlength="2" onBlur="RecargaGrupo()" onKeyDown="TeclaPulsada3(1)">';
	?>
       </td>
    <td width="142">Pesada</td>
    <td width="146">
	<?php	
		if ($opcion == "M")
		{
			echo '<input name="txtcuba" type="text" size="5" maxlength="2" value="'.$cuba.'">';
		}
		else
		{
		if ($recargapag5 == "S")
		{
			$consulta = "SELECT CASE WHEN LENGTH((IFNULL(MAX(cod_cuba),0) + 1)) = 1 THEN CONCAT('0',(IFNULL(MAX(cod_cuba),0) + 1)) ELSE (IFNULL(MAX(cod_cuba),0)+1) END AS correlativo";
			$consulta.= " FROM sec_web.paquete_catodo";
			$consulta.= " WHERE fecha_creacion_paquete = '".$ano.'-'.$mes.'-'.$dia."'";
			$consulta.= " AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
			$consulta.= " AND cod_grupo = '".$txtgrupo."'";
			$rs = mysqli_query($link, $consulta);
			$row = mysqli_fetch_array($rs);
			//echo $consulta."<br>";
			
			$color = "";
			if (($row[correlativo] >= '69') and ($row[correlativo] < '74'))
				$color = 'style="background:#FFA94A"';
			else if ($row[correlativo] >= '74')
				$color = 'style="background:#FB8400"';
			
			echo '<input name="txtcuba" type="text" value="'.$row[correlativo].'" size="5" maxlength="2" '.$color.' onKeyDown="TeclaPulsada3(2)">';
		}
		else	
			echo '<input name="txtcuba" type="text" size="5" maxlength="2" onKeyDown="TeclaPulsada3(2)">';
		}
	?>
      </select></td>
  </tr>
</table>
<?php
		}
	}
}//64. 7-8.
?>
<br>
<table width="600" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr> 
<?php
if (!($cmbproducto == '64' and ($cmbsubproducto == '8' or $cmbsubproducto == '7')))
{	
	if (($cmbproducto != '48') and ($cmbproducto != '37') and ($cmbproducto != '42'))
	{
?>  
    <td width="147">Unidades</td>
    <td width="147">
<?php
	if ($opcion == "M")
		echo '<input name="txtunidades" type="text" size="10" value="'.$unidades.'" onKeyDown="TeclaPulsada3(3)"></td>';
	else 
		if($cmbproducto == '19')
		{
			if ($cmbsubproducto=='26')
				echo '<input name="txtunidades" type="text" size="10" value="18" onKeyDown="TeclaPulsada3(3)"></td>';	
			else
				echo '<input name="txtunidades" type="text" size="10" value="30" onKeyDown="TeclaPulsada3(3)"></td>';	
		}	
		else
			echo '<input name="txtunidades" type="text" size="10" value="20" onKeyDown="TeclaPulsada3(3)"></td>';	
?>

<?php
	}
}//64. 7-8.
?>    
<td width="147">Peso </td>
    <td width="147">
<?php	
	if ($opcion == "M")
		echo '<input name="txtpeso" type="text" size="10" value="'.$peso.'"></td>';
	else
		echo '<input name="txtpeso" type="text" size="10" onKeyDown="TeclaPulsada3(4)"></td>';
	
	if ($cmbproducto == '48')
	{
	   echo '<td width="147"><input name="txtunid48" type="text" size="4" value=" 1P" disabled>&nbsp;Unidades</td>';
	   echo '<input name="txtunidades" type="hidden"  value="'.$txtunidades.'">';
	}
?>
  </tr>
	<?php
		//Activa la Funcion JavaScript para poner el Peso Automaticamente.
		echo '<script language="JavaScript"> PesoAutomatico(); </script>';
	?>	  
</table>
<br>