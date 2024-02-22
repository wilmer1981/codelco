<?php
	//PRODUCICION.
	
	//Campo Oculto.
	echo '<input name="fecha_aux" type="hidden" value="'.$ano.'-'.$mes.'-'.$dia.'">';
	echo '<input name="hora_aux" type="hidden" value="'.$hora_aux.'">';
	
	$letras = array(1=>'A',2=>'B',3=>'C',4=>'D',5=>'E',6=>'F',7=>'G',8=>'H',9=>'I',10=>'J',11=>'L',12=>'M');
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
      &nbsp;</td>
</tr>
</table>
<br>
<table width="600" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr> 
    <td width="130"> Peso Automático</td>
    <td width="458"> <input name="checkpeso" type="checkbox" id="checkpeso" value="checkbox" <?php echo $peso_auto ?>> 
    </td>
  </tr>
</table>
<br>
<?php
	if (($cmbproducto == 48) and ($cmbsubproducto == 2))
	{
?>
<table width="600" height="49" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
  <tr> 
    <td width="147" height="49"><p> A: Enero<br>
        B: Febrero<br>
        C: Marzo<br>
        D: Abril
    </td>
    <td width="149">E: Mayo<br>
      F: Junio<br>
      G: Julio<br>
      H: Agosto</td>
    <td width="286">I: Septiembre<br>
      J: Octubre<br>
      L: Noviembre<br>
      M: Diciembre</td>
  </tr>
</table>
<?php	
	}
?>
<?php
	if (($cmbproducto == "18") or ($cmbproducto == "48"))
	{
?>

<?php
	if ($cmbproducto == '18')
	{
	
		$grupos = array();			
	
		$consulta = "SELECT DISTINCT cod_grupo, fecha_produccion FROM sec_web.produccion_catodo";
		$consulta.= " WHERE fecha_produccion = left(NOW(),10)";
		$consulta.= " AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
		$consulta.= " ORDER BY cod_grupo";
		//echo $consulta."<br>";

		$rs = mysqli_query($link, $consulta);
		while ($row = mysqli_fetch_array($rs))
		{
			$consulta = "SELECT * FROM sec_web.control_grupo_pesaje";
			$consulta.= " WHERE grupo = '".$row["cod_grupo"]."' AND fecha = left(NOW(),10)";
			//echo $consulta."<br>";
			$row30 = mysqli_query($link, $consulta);
			if (!$row30 = mysqli_fetch_array($row30))
			{			
				$consulta = "SELECT count(*) AS cant_cubas, cod_lado, cod_grupo, MIN(cod_cuba) AS minimo, MAX(cod_cuba) AS maximo FROM sec_web.produccion_catodo";
				$consulta.= " WHERE fecha_produccion = '".$row[fecha_produccion]."' AND cod_grupo = '".$row["cod_grupo"]."' AND cod_cuba <> '00'";
				$consulta.= " AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";		
				$consulta.= " GROUP BY cod_lado";
				$consulta.= " HAVING cant_cubas < 21";
				//echo $consulta."<br>";
				
				$rs1 = mysqli_query($link, $consulta);
				if ($row1 = mysqli_fetch_array($rs1))
				{
					$grupos[$row1["cod_grupo"]][0] = $row1["cod_grupo"]; //Grupo.
					$grupos[$row1["cod_grupo"]][1] = $row1[cod_lado]; //Lado. 
				
				
					//Ultima Cuba Ingresada.
					$consulta = "SELECT cod_cuba FROM sec_web.produccion_catodo";
					$consulta.= " WHERE fecha_produccion = '".$row[fecha_produccion]."' AND cod_grupo = '".$row["cod_grupo"]."' AND cod_lado = '".$row1[cod_lado]."'";
					$consulta.= " AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
					$consulta.= " ORDER BY hora DESC";
					$consulta.= " LIMIT 0,1";
					//echo $consulta."<br>";
					
					$rs2 = mysqli_query($link, $consulta);
					if ($row2 = mysqli_fetch_array($rs2))	
						$grupos[$row1["cod_grupo"]][2] = $row2[cod_cuba]; //Ultima Cuba Ingresada.
							
							
					//Primera Cuba Ingresada Del Lado.
					$consulta = "SELECT cod_cuba FROM sec_web.produccion_catodo";
					$consulta.= " WHERE fecha_produccion = '".$row[fecha_produccion]."' AND cod_grupo = '".$row["cod_grupo"]."' AND cod_lado = '".$row1[cod_lado]."'";
					$consulta.= " AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
					$consulta.= " ORDER BY hora ASC";
					$consulta.= " LIMIT 0,1";
					$rs4 = mysqli_query($link, $consulta);
					$row4 = mysqli_fetch_array($rs4);
											
					if (($row4[cod_cuba] >= '01') and ($row4[cod_cuba] <= '04'))
					{
						$grupos[$row1["cod_grupo"]][3] = 'A'; //Ascendente;
						$grupos[$row1["cod_grupo"]][4] = 1; //Minimo;
						$grupos[$row1["cod_grupo"]][5] = 21; //Maximo;
						$grupos[$row1["cod_grupo"]][6] = ''; //Proxima Cuba;
					}	
					else if (($row4[cod_cuba] <= '21') and ($row4[cod_cuba] >= '18'))
						{
							$grupos[$row1["cod_grupo"]][3] = 'D'; //Descendente;
							$grupos[$row1["cod_grupo"]][4] = 1; //Minimo;
							$grupos[$row1["cod_grupo"]][5] = 21; //Maximo;
							$grupos[$row1["cod_grupo"]][6] = ''; //Proxima Cuba;						
						}
						else if (($row4[cod_cuba] >= '22') and ($row4[cod_cuba] <= '25'))
							{	
								$grupos[$row1["cod_grupo"]][3] = 'A'; //Ascendente;
								$grupos[$row1["cod_grupo"]][4] = 22; //Minimo;
								$grupos[$row1["cod_grupo"]][5] = 42; //Maximo;							
								$grupos[$row1["cod_grupo"]][6] = ''; //Proxima Cuba;							
							}
							else if (($row4[cod_cuba] <= '42') and ($row4[cod_cuba] >= '39'))
								{
									$grupos[$row1["cod_grupo"]][3] = 'D'; //Descendente;
									$grupos[$row1["cod_grupo"]][4] = 22; //Minimo;
									$grupos[$row1["cod_grupo"]][5] = 42; //Maximo;								
									$grupos[$row1["cod_grupo"]][6] = ''; //Proxima Cuba;								
								}
											
					$cubas = array();
					for ($i=$grupos[$row1["cod_grupo"]][4]; $i <= $grupos[$row1["cod_grupo"]][5]; $i++)
					{
						$cubas[$i] = "";
					}
															
					$consulta = "SELECT cod_cuba FROM sec_web.produccion_catodo";
					$consulta.= " WHERE fecha_produccion = '".$row[fecha_produccion]."' AND cod_grupo = '".$row["cod_grupo"]."' AND cod_lado = '".$row1[cod_lado]."'";
					$consulta.= " AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";		
					$rs3 = mysqli_query($link, $consulta);
					//echo $consulta."<br>";		
					while ($row3 = mysqli_fetch_array($rs3))
					{	
						$cubas[intval($row3[cod_cuba])] = 'ok';
					}
					
					//Ordeno el arreglo segun corresponda. (Ascendente ó Descendente).
					if ($grupos[$row1["cod_grupo"]][3] == 'A')
						ksort($cubas);
					else
						krsort($cubas);		
					
					//----.
					
					//Asigna la siguiente cuba.
					$aux = intval($grupos[$row1["cod_grupo"]][2]);
					if ($grupos[$row1["cod_grupo"]][3] == 'D')
					{
						if (($grupos[$row1["cod_grupo"]][4] = 1) and ($aux > 1)) //Minimo.
							$aux--;
						else if (($grupos[$row1["cod_grupo"]][4] = 21) and ($aux > 21)) //Minimo.
								$aux--;
					}
					else
					{
						if (($grupos[$row1["cod_grupo"]][5] = 21) and ($aux < 21)) //Maximo.
							$aux++;
						else if (($grupos[$row1["cod_grupo"]][5] = 42) and ($aux < 42)) //Maximo.
							$aux++;
					}
					
					if (strlen($aux) == 1)
						$grupos[$row1["cod_grupo"]][6] = '0'.$aux;
					else
						$grupos[$row1["cod_grupo"]][6] = $aux;
					
					//----.
					
					/*
					//Recorro el arreglo de las cubas para saber cual es la siguiente.
					reset($cubas);
					while (list($c,$v) = each($cubas))
					{					
						if ($v == "")
						{
							if (strlen($c) == 1)
								$grupos[$row1["cod_grupo"]][6] = '0'.$c; //Proxima Cuba, Segun El Grupo.						
							else
								$grupos[$row1["cod_grupo"]][6] = $c;
							break;
						}					
					}
					*/
				}
			}
		}
	
		
		echo '<input name="valores" type="hidden" value="">'; //Por Defecto.
		//Genero Las Cubas Posibles Para Cada Grupo.
		reset($grupos);
		while (list($c,$v) = each($grupos))
		{
			echo '<input name="valores" type="hidden" value="'.$v[0].'-'.$v[6].'-'.$v[1].'">'; //Grupo-CubaPosible-Lado.
		}
		
		if  (count($grupos) > 0)
		{	
			echo '<br>';
			echo '<table width="236" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">';
			echo '<tr>';
			echo '<td width="50">Grupo</td>';
			
			reset($grupos);
			while (list($c,$v) = each($grupos))
			{
				echo '<td width="51">'.$v[0].'</td>';
			}
			echo '</tr>';
			echo '<tr>';
			echo '<td>Cuba</td>';
			
			reset($grupos);
			while (list($c,$v) = each($grupos))
			{
				echo '<td>'.$v[2].'</td>';
			}
			echo '</tr>';
			echo '</table>';
		}
	}
?>

<br>

<table width="600" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
<?php
	if (($cmbproducto == 18) or (($cmbproducto == 48) and ($cmbsubproducto != 8) and ($cmbsubproducto != 9) and ($cmbsubproducto != 3) and ($cmbsubproducto != 6) and ($cmbsubproducto != 10)))
	{	
?>
    <tr>
      <td width="144">
	  <?php
	  	if (($cmbproducto == 48) and ($cmbsubproducto == 2))
			echo "Mes";
		else
			echo "Grupo";
	  ?>
	  </td>
      <td width="144">
		<?php 
			if ($cmbproducto == '18')
			{
				if ($opcion == "M")
					echo '<input name="txtgrupo" type="text" size="5" maxlength="2" value="'.$txtgrupo.'" disabled>';
				else 
					echo '<input name="txtgrupo" type="text" size="5" maxlength="2" onBlur="ValGrupo()" onKeyDown="TeclaPulsada(1)">';
			}
			
			if ($cmbproducto == '48')
			{
				if ($opcion == "M")
					echo '<input name="txtgrupo" type="text" size="5" maxlength="2" value="'.$txtgrupo.'" disabled>';
				else 
				{
					if ($cmbsubproducto == '2') // Orejas.
						$valor = $letras[date("n")];
					if ($cmbsubproducto == '6') //Laminas Standard.
						$valor = '04';
					
					echo '<input name="txtgrupo" type="text" size="5" maxlength="2" value="'.$valor.'" onBlur="ValGrupo()" onKeyDown="TeclaPulsada(1)">';			
				}
			}			
		?>
       
	</td>
            
    <td width="135">
	<?php
	if ($cmbmovimiento == '2' and $cmbproducto == '48' and $cmbsubproducto == '2')
		echo 'Correlativo';
	else
		echo 'Cuba';
	?>
	</td>
    <td width="153"> 
      <?php		
		if ($cmbproducto == '18')
		{
			if ($opcion == "M")
				echo '<input name="txtcuba" type="text" size="5" maxlength="2" value="'.$txtcuba.'" disabled>';
			else
				echo '<input name="txtcuba" type="text" size="5" maxlength="2" onBlur="ValCuba()" onKeyDown="TeclaPulsada(2)">';		
		}
		
		if ($cmbproducto == '48')
		{
			if ($opcion == "M")
				echo '<input name="txtcuba" type="text" size="5" maxlength="2" value="'.$txtcuba.'" disabled>';
			else
			{
				$consulta = "SELECT CASE WHEN LENGTH((IFNULL(MAX(CEILING(cod_cuba)),0)+1)) = 1 THEN CONCAT('0',(IFNULL(MAX(CEILING(cod_cuba)),0)+1)) ELSE (IFNULL(MAX(CEILING(cod_cuba)),0)+1) END AS correlativo FROM sec_web.produccion_catodo";
				$consulta.= " WHERE LEFT(fecha_produccion,7) = LEFT(NOW(),7) ";
				$consulta.= " AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
				//echo $consulta."<br>";
				
				$rs = mysqli_query($link, $consulta);
				$row = mysqli_fetch_array($rs);
				
				echo '<input name="txtcuba" type="text" size="5" maxlength="2" value="'.$row[correlativo].'" onKeyDown="TeclaPulsada(2)" onBlur="ValCuba()">';
			}
		}
	?></SELECT>
      &nbsp; F: Finaliza Grupo</td>
    </tr>
	<?php
		}
	?>
	
	<?php 	if ($cmbproducto == '18')
		{
	?>
    <tr>      
    <td>Lado (P / T)</td>
      <td>
	<?php	
		if ($opcion == "M")
			echo '<input name="txtlado" type="text" size="5" maxlength="1" value="'.$txtlado.'" disabled>';
		else
			echo '<input name="txtlado" type="text" size="5" maxlength="1" onBlur="ValLado()" onKeyDown="TeclaPulsada(3)">';
	?>
		</td>
      
    <td>Muetsra (S / N)</td>
      
    <td>
	<?php
		if ($opcion == "M")
			echo '<input name="txtmuestra" type="text" size="5" maxlength="1" value="'.$txtmuestra.'" disabled>';
		else
			echo '<input name="txtmuestra" type="text" size="5" maxlength="1" value="N" onBlur="ValMuestra()" onKeyDown="TeclaPulsada(4)">';
			
	?>
	</td>	
    </tr>
	<?php } ?>
  </table>
  <br>
<?php
	}
?>
  
<table width="600" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr>   
  <?php  	
	if ($cmbmovimiento == 2 and ($cmbproducto == 57 or $cmbproducto == 64 or $cmbproducto == 66))  
	{
  		echo '<td width="294">Peso Tara</td>';
		echo '<td width="294"><input name="txtpesotara" type="text" size="10" value="'.$txtpesotara.'"></td>';

	}
  ?>
    <td width="294">Peso Produccion</td>
    <td width="294">
<?php	
	if ($cmbproducto==48)
	{
			$valunidad = 0;
			echo "<input type='hidden' name='txtunidades' value='".$valunidad."'>";
	}

	if ($opcion == "M")
		echo '<input name="txtpeso" type="text" size="10" value="'.$txtpeso.'">';
	else
		echo '<input name="txtpeso" type="text" size="10" onKeyDown="TeclaPulsada(4)">';
?>	
	</td>
<?php /*if ($cmbproducto == 48) // revisar si es en este proceso o en el de pesaje de paquetes.
	{
		 echo'<td width="294"><input name="txtunid48" type="text" size="4" value=" 1P" disabled>&nbsp;Unidades</td>';
		 echo'<td width="200"></td>';
	} */	?>
	 
  </tr>
	<?php
		//Activa la Funcion JavaScript para poner el Peso Automaticamente.
		echo '<script language="JavaScript"> PesoAutomatico(); </script>';
	?>	  
</table>
  <br>  