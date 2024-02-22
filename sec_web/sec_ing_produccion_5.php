<?php
	//NUEVO PESAJE DE LODOS DE REFINERIA.

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
	echo '<input name="fecha_lodo" type="hidden" value="'.$fecha_pesaje_lodo.'">';
	echo '<input name="etapa" type="hidden" value="1">';
	echo '<input name="fecha_aux" type="hidden" value="'.$ano.'-'.$mes.'-'.$dia.'">';
	echo '<input name="encontro_ie" type="hidden" value="'.$encontro_ie.'">';
	echo '<input name="genera_lote" type="hidden" value="'.$genera_lote.'">';
	echo '<input name="agrega_paq" type="hidden" value="'.$agrega_paq.'">';
	echo '<input name="peso_prog_ok" type="hidden" value="'.$peso_prog_ok.'">';
	echo '<input name="paq_inicial" type="hidden" value="'.$paq_inicial.'">';
	
	echo '<input name="txtgrupo" type="hidden" value="">';
	
	if ($opcion == "M")
	{
		echo '<input name="peso_aux" type="hidden" value="'.$peso.'">';
	}
	
	
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
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
			if ($cmbsubproducto == 11)
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
					$insertar = "INSERT INTO sec_web.instrucciones (corr_ie,cod_producto,cod_subproducto,peso_programado,fecha)";
					$insertar.= " VALUES ('".$row["corr_enm"]."', '".$row["cod_producto"]."', '".$row["cod_subproducto"]."', '".$row[cantidad_embarque]."',";
					$insertar.= " '".$row["fecha_disponible"]."')";
					//echo $insertar."<br>";
					mysqli_query($link, $insertar);
				}
				
				/*
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
					$insertar = "INSERT INTO sec_web.instrucciones (corr_ie,cod_producto,cod_subproducto,peso_programado,fecha)";
					$insertar.= " VALUES ('".$row["corr_codelco"]."', '".$row["cod_producto"]."', '".$row["cod_subproducto"]."', '".$row["cantidad_programada"]."',";
					$insertar.= "  '".$row["fecha_disponible"]."')";
					//echo $insertar."<br>";
					mysqli_query($link, $insertar);		
				}
				*/
			}
			else
			{
				$consulta = "SELECT DISTINCT corr_ie";
				$consulta.= " FROM sec_web.pesaje_lodos";
				$consulta.= " WHERE cod_estado = 'P'";				
				$consulta.= " GROUP BY corr_ie,cod_bulto,num_bulto,cod_paquete,num_paquete";
				$consulta.= " HAVING COUNT(*) = 1";
				$consulta.= " ORDER BY corr_ie ASC";
				//echo $consulta."<br>";
				
				$rs = mysqli_query($link, $consulta);
				while ($row = mysqli_fetch_array($rs))
				{
					$insertar = "INSERT INTO sec_web.instrucciones (corr_ie,cod_producto,cod_subproducto)";
					$insertar.= " VALUES ('".$row["corr_ie"]."', '".$row["cod_producto"]."', '".$row["cod_subproducto"]."')";
					//echo $insertar."<br>";
					mysqli_query($link, $insertar);
				}							
			}
		}
		
		if (($recargapag4 == "S") and ($listar_ie == "V"))	
		{
			if ($cmbsubproducto == 11) //1� Pesada.
			{
				$consulta = "SELECT * FROM sec_web.instruccion_virtual";
				$consulta.= " WHERE cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
				$consulta.= " AND estado <> 'T'";
				$consulta.= " ORDER BY fecha_embarque, corr_virtual";
			}
			else //2� Pesada.
			{
				$consulta = "SELECT DISTINCT corr_ie AS corr_virtual";
				$consulta.= " FROM sec_web.pesaje_lodos";
				$consulta.= " WHERE cod_estado = 'V'";
				$consulta.= " GROUP BY corr_ie,cod_bulto,num_bulto,cod_paquete,num_paquete";
				$consulta.= " HAVING COUNT(*) = 1";
				$consulta.= " ORDER BY corr_ie ASC";
			}
			//echo $consulta."<br>";
			
			$rs = mysqli_query($link, $consulta);
			while ($row = mysqli_fetch_array($rs))
			{		
				$insertar = "INSERT INTO sec_web.instrucciones (corr_ie,cod_producto,cod_subproducto,peso_programado,fecha)";
				$insertar.= " VALUES ('".$row[corr_virtual]."', '".$row["cod_producto"]."', '".$row["cod_subproducto"]."', '".$row["peso_programado"]."',";
				$insertar.= " '".$row["fecha_embarque"]."')";
				//echo $insertar."<br>";
				mysqli_query($link, $insertar);
			}
					
		}	
		
		if ($cmbsubproducto == 11)							
			echo '<select name="cmbinstruccion" onChange="BuscarIE()">'; //1� Pesada.
		else
			echo '<select name="cmbinstruccion" onChange="BuscarIE_Lodo()">'; //2� Pesada.
		
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
	<?php    
		if ($cmbsubproducto == 11) //Pesada 1.		
			echo '<input name="btnvirtual" type="button" value="I.E. Virtual" onClick="CreaVirtual()">';
	?>
	</td>
    <td width="79"> Peso Prog.(Kgrs)</td>
    <td width="208">
	<?php
		$txtpesoprog = 0;
		//Consulta el peso de la I.E.			
		if ($listar_ie == "P") //Del Programa.
		{
			if ($opcion == "M")
			{
				if ($cmbsubproducto == 12)				
				{
					$consulta = "SELECT * FROM sec_web.programa_enami";
					$consulta.= " WHERE corr_enm = '".$instruccion."' AND estado1 = 'R'";
					$consulta.= " AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '11'";								
				}
				else
				{
					$consulta = "SELECT * FROM sec_web.programa_enami";
					$consulta.= " WHERE corr_enm = '".$instruccion."' AND estado1 = 'R'";
					$consulta.= " AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";				
				}
			}
			else if ($opcion == "L")
			{
				$consulta = "SELECT * FROM sec_web.programa_enami";
				$consulta.= " WHERE corr_enm = '".$cmbinstruccion."' AND estado1 = 'R'";
				$consulta.= " AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '11'";				
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
			/*	
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
			*/
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
			$consulta.= " ON t1.cod_paquete = t2.cod_paquete AND t1.num_paquete = t2.num_paquete AND t2.cod_estado = 'a'";
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
		if (($opcion == "M") or ($opcion == "L") or (($genera_lote == "S") and ($paq_inicial == "S")) or ($agrega_paq == "S"))		
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
			echo '<input name="txtmarca" type="text" value="'.$marca.'">';
		else
			echo '<input name="txtmarca" type="text" value="'.$txtmarca.'">';
	?>
	<input type="button" name="Button" value="marca" onClick="VerMarca()"></td>
  </tr>
</table>
<br>
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
	
<table width="600" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr> 
    <td width="298">Codigo de Serie</td>
    <td width="296">
	<?php // echo $opcion."<br>";?>
	<select name="cmbcodpaq">
	<option value="-1">CODIGO</option> 
	<?php
		if (($opcion == "M") or ($opcion == "L") or (($genera_lote == "S") and ($paq_inicial == "S")) or ($agrega_paq == "S"))
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
		if (($opcion == "M") or ($opcion == "L"))
			echo '<input name="txtnumpaq" type="text" id="txtnumpaq"  value="'.$numpaq.'" size="10" maxlength="10">';
		else 
			echo '<input name="txtnumpaq" type="text" id="txtnumpaq"  value="'.$txtnumpaq.'" size="10" maxlength="10">';
	?>
	<?php   
	  	if ($opcion == "L")
	  		echo '<input name="txtbuscar" type="button" value="Buscar" onClick="BusarSerieLodo()">';
	?>
	 </td>
	
  </tr>
</table>
<br>

<table width="600" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr> 
    <td width="143">Unidades (Bolsas)</td>
    <td width="145">
	<?php
		if ($opcion == "M")
			echo '<input name="txtunidades" type="text" size="10" maxlength="10" value="'.$unidades.'">'; 
		else
			echo '<input name="txtunidades" type="text" size="10" maxlength="10" value="'.$txtunidades.'">'; 
	?>
	</td>
    <td width="121">Peso Tara</td>
    <td width="167">
	<?php
		if ($opcion == "M")
			echo '<input name="txtpesotara" type="text" size="10" maxlength="10" value="'.$pesotara.'">';
		else
		{
			if ($cmbsubproducto == 11)
				echo '<input name="txtpesotara" type="text" size="10" maxlength="10" value="'.$txtpesotara.'" onBlur="CalculaPesoNetoLodo()">';
			else
				echo '<input name="txtpesotara" type="text" size="10" maxlength="10" value="'.$txtpesotara.'">';
		}
	?>
      &nbsp; 
	<?php
		if ($cmbsubproducto == 12)
			echo '<input name="btnrecalcula" type="button" id="btnrecalcula" onClick="ReCalculaCajon()" value="Calcular">';			
	?>
	 </td>
  </tr>
</table>


<br>
<table width="600" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr> 
    <td width="144">Peso Neto</td>
    <td width="144">
	<?php
	if ($opcion == "M")
		echo '<input name="txtpesoneto" type="text" size="10" maxlength="10" value="'.$pesoneto.'">'; 	
	else		
		echo '<input name="txtpesoneto" type="text" size="10" maxlength="10" value="'.$txtpesoneto.'">'; 
	?>
	</td>
    <td width="122">Peso Bruto</td>
    <td width="166">
<?php	
	if ($opcion == "M")
		echo '<input name="txtpeso" type="text" size="10" value="'.$peso.'"></td>';
	else
	{
		if ($cmbsubproducto == 11)
			echo '<input name="txtpeso" type="text" size="10" onKeyDown="TeclaPulsada3(4)" onBlur="CalculaPesoNetoLodo()"></td>';
		else
			echo '<input name="txtpeso" type="text" size="10" onKeyDown="TeclaPulsada3(4)"></td>';
	}
?>
  </tr>
	<?php
		//Activa la Funcion JavaScript para poner el Peso Automaticamente.
		echo '<script language="JavaScript"> PesoAutomatico(); </script>';		
	?>	  
</table>
<br>