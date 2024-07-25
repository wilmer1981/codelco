<?php include("../principal/conectar_sea_web.php");
   set_time_limit(900); 
?>


<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Salir()
{
	window.history.back();
}
/***********/
function Imprimir()
{
	window.print();
}
</script>
</head>

<body class="TablaPrincipal">
<table width="320" border="0" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
  <tr>
    <td align="center">CARGA A NAVE ELECTROLITICA ACUMULADA</td>
  </tr>
  <tr> 
    <td align="center">PERIODO: <?php echo $dia_i.'/'.$mes_i.'/'.$ano_i ?> AL <?php echo $dia_t.'/'.$mes_t.'/'.$ano_t ?></td>
  </tr>
</table>
<br>
<table width="320" border="0" cellpadding="0" cellspacing="0" align="center" class="ColorTabla01">
  <tr>
<?php
	if ($radio2 == "L")
		echo '<td align="center">LEYES</td>';
	else if ($radio2 == "F")
		echo '<td align="center">FINOS</td>';
	else
		echo '<td align="center">PESOS</td>';
?>
  </tr>
</table>
<br>

<?php
	if (strlen($mes_i) == 1)
		$mes_i = "0".$mes_i;
	if (strlen($mes_t) == 1)
		$mes_t = "0".$mes_t;
	if (strlen($dia_i) == 1)
		$dia_i = "0".$dia_i;
	if (strlen($dia_t) == 1)
		$dia_t = "0".$dia_t;
		
	//$fecha_ini = $ano_i.'-'.$mes_i.'-'.$dia_i; //.' 00:00:00';
	//$fecha_ter = $ano_t.'-'.$mes_t.'-'.$dia_t; //.' 23:59:59';
	$fecha_ini =date("Y-m-d", mktime(1,0,0,$mes_i,$dia_i ,$ano_i));	
	$fecha_ter =date("Y-m-d", mktime(1,0,0,$mes_t,($dia_t +1),$ano_t));	


	$largo = 180; //Largo de la Tabla

	if ($radio2 != "P")
	{
		$consulta = "SELECT DISTINCT t1.cod_leyes AS codigo, t2.abreviatura AS ab1, t3.abreviatura AS ab2, t3.conversion FROM sea_web.leyes_por_hornada AS t1";
		$consulta = $consulta." INNER JOIN proyecto_modernizacion.leyes AS t2 ON t1.cod_leyes = t2.cod_leyes";
		$consulta = $consulta." INNER JOIN proyecto_modernizacion.unidades AS t3 ON t1.cod_unidad = t3.cod_unidad";
		$consulta = $consulta." WHERE t1.valor <> '' AND t1.cod_producto = 17";		
		$consulta = $consulta." ORDER BY t2.orden_sea";
		
		$rs4 = mysqli_query($link, $consulta);
		
		if (mysqli_num_rows($rs4) <> 0)
			$largo = $largo + (40 * (mysqli_num_rows($rs4)-3));
			if ($radio2 == "L")
				$largo = $largo + 120;
			else 
				$largo = $largo + 180;				
	}
	
	echo '<table width="'.$largo.'"  border="1" cellspacing="0" cellpadding="0" align="center" class="ColorTabla01"><tr>';
		echo '<td width="25" align="center">Dia </td>';
		echo '<td width="45" align="center">Horn</td>';
        echo '<td width="20" align="center">Lad<br>Cub</td>';
		echo '<td width="30" align="center">Cant.</td>';
		echo '<td width="60" align="center">Peso<br>Kgs.</td>';
	
	$det_leyes = array(); //Detalles de las leyes por Flujo oducto.
	$total_grupo = array();//Totales Grupo
	$total_dia = array(); //Totales de las por Dia.
	$total_leyes = array(); //Totales de las leyes por Flujo oducto.	

	if ($radio2 != "P")
	{
		while ($row4 = mysqli_fetch_array($rs4))
		{
			if (($radio2 == "F") and (($row4[codigo] == '02') or ($row4[codigo] == '04') or ($row4[codigo] == '05')))
				echo '<td width="60" align="center">'.$row4[ab1].'<br>'.$row4[ab2].'</td>';
			else
				echo '<td width="40" align="center">'.$row4[ab1].'<br>'.$row4[ab2].'</td>';
				
			$det_leyes[$row4[codigo]][0] = 0; //ley.
			$det_leyes[$row4[codigo]][1] = $row4["conversion"]; //unidad de conversion.
			
			$total_grupo[$row6[codigo]][0] = 0;
			$total_grupo[$row6[codigo]][1] = $row4["conversion"]; //unidad de conversion.
			
			$total_dia[$row4[codigo]][0] = 0; //Valor Ley
			$total_dia[$row4[codigo]][1] = $row4["conversion"]; //Unidad de conversion.
			
			$total_leyes[$row4[codigo]][0] = 0; //Acumulador por cada Ley.
			$total_leyes[$row4[codigo]][1] = $row4["conversion"]; //Unidad de conversion.		
		}
	}
?>	

  </tr>
</table>
<br>

<?php
	
	$arreglo = array();
	//LLENA UN ARREGLO CON LOS FLUJOS Y PRODUCTOS-SUBPRODUCTOS ASOCIADOS.
	
	if ($cmborigen == "T") //Todos los productos.
	{
		$consulta = "SELECT * FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 2";	
	}
	else
	{
		if ($radio == "P") //Radio Producto
		{
			if (($cmbanodos == "T") and ($cmbrestos == "T"))
			{
				$consulta = "SELECT * FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 2 AND cod_origen = ".$cmborigen;
			}
			else if (($cmbanodos == "T") and ($cmbrestos != "T"))
				 {
				 	$consulta = "SELECT * FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_origen = ".$cmborigen." AND cod_proceso = 2";
					$consulta = $consulta." AND cod_subproducto = ".$cmbrestos;
				 }
			else if (($cmbanodos != "T") and ($cmbrestos == "T"))
				 {
				 	$consulta = "SELECT * FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_origen = ".$cmborigen." AND cod_proceso = 2";
					$consulta = $consulta." AND cod_subproducto = ".$cmbanodos;
				 }
			else if (($cmbanodos != "T") and ($cmbrestos != "T"))
				 {
				 	$consulta = "SELECT * FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_origen = ".$cmborigen." AND cod_proceso = 2 AND";
					$consulta = $consulta." cod_subproducto = ".$cmbanodos." AND cod_subproducto = ".$cmbrestos;
				 }
		}													
		else //Radio Flujo
		{
			if (($cmbflujo == "T") and ($cmbflujorestos == "T"))
			{
				$consulta = "SELECT * FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 2 AND cod_origen = ".$cmborigen;
			}
			else if (($cmbflujo == "T") and ($cmbflujorestos != "T"))				 
				 {
				 	$consulta = "SELECT * FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_origen = ".$cmborigen." AND cod_proceso = 2";
					$consulta = $consulta." AND flujo = ".$cmbflujorestos;				 
				 }	 
			else if (($cmbflujo != "T") and ($cmbflujorestos == "T"))
				 {
					$consulta = "SELECT * FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_origen = ".$cmborigen." AND cod_proceso = 2";
					$consulta = $consulta." AND flujo = ".$cmbflujo;				 	
				 }
			else if (($cmbflujo != "T") and ($cmbflujorestos != "T"))
				 {
				 	$consulta = "SELECT * FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_origen = ".$cmborigen." AND cod_proceso = 2 AND";
					$consulta = $consulta." flujo = ".$cmbflujo."  AND flujo = ".$cmbflujorestos;
				 }
		}
	}	
	
	$consulta = $consulta." ORDER BY flujo";
	
	//Ejecuta la consulta.
	$rs1 = mysqli_query($link, $consulta); 
	//echo $consulta."<br>";
	//Llena el arreglo con los flujos y subproductos; y el inicio de hornada en el caso de Ventanas(Representa al horno).
	while ($row1 = mysqli_fetch_array($rs1))
	{
		$arreglo[] = array($row1["flujo"], $row1["cod_producto"], $row1["cod_subproducto"], $row1[cod_proceso]);
	}	

	// Saca todos los movimientos de recepcion afectados.
	reset($arreglo);
	while (list($clave, $valor) = each($arreglo)) // (0: flujo, 1: cod_producto, 2: cod_subproducto, 3: cod_proceso)
	{
		//Limpia el arreglo de los Totales de las Leyes.
		reset($total_leyes);
		while (list($c1, $v1) = each($total_leyes))
		{	
			$total_leyes[$c1][0] = 0; //Acumulador.				
		}
		
		$consulta = "SELECT * FROM sea_web.movimientos WHERE tipo_movimiento = 2 AND cod_producto = ".$valor[1];
		$consulta = $consulta." AND cod_subproducto = ".$valor[2]." AND flujo = ".$valor[0];
		$consulta = $consulta." AND ((fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."')";
		$consulta = $consulta." OR (fecha_benef BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'))";
		$consulta = $consulta." and hora between '".$fecha_ini." 08:00:00' and '".$fecha_ter." 07:59:59' ";		
		$consulta = $consulta." ORDER BY campo2,fecha_movimiento";		
		//echo $consulta."<br>";
		$rs8 = mysqli_query($link, $consulta);

		if (mysqli_num_rows($rs8) != 0) //Si existen datos escribir flujo.
		{
			$row8 = mysqli_fetch_array($rs8);
			
			//Si hay movimientos escribe el Producto ujo.
			echo '<table width="320" border="0" cellspacing="0" cellpadding="0" align="center" class="ColorTabla01">';
			echo '<tr><td align="center">';
		
			if ($radio == "P") //Producto	
			{		
				$consulta = "SELECT descripcion AS nombre FROM proyecto_modernizacion.subproducto WHERE cod_producto = ".$valor[1]." AND cod_subproducto = ".$valor[2];
				echo "PRODUCTO: ";
			}
			else //Flujo
			{
				$consulta = "SELECT descripcion AS nombre FROM proyecto_modernizacion.flujos WHERE cod_flujo = ".$valor[0];				
				echo "FLUJO: ".$valor[0]." ";
			}
			
			$rs4 = mysqli_query($link, $consulta);
						
			if ($row4 = mysqli_fetch_array($rs4))
				echo $row4["nombre"];									
			echo '</td></tr></table><br>';
		
						
			//$fecha_aux = $row8[fecha_movimiento];
			$fecha_aux = $fecha_ini;
			
			$fecha_ter1 =date("Y-m-d", mktime(1,0,0,$mes_t,($dia_t +1),$ano_t));	
			
			//echo date($fecha_aux)." < ".date($fecha_ter1);
			while (date($fecha_aux) < date($fecha_ter1)) //Recorre los dias.
			
			//polywhile (date($fecha_aux) <= date($fecha_ter)) //Recorre los dias.
			{
				//Limpia el arreglo de los Totales por Dia de las Leyes.
				reset($total_dia);
				while (list($c1, $v1) = each($total_dia))
				{	
					$total_dia[$c1][0] = 0; //Acumulador.				
				}		
				
				$consulta_g = "SELECT DISTINCT CASE WHEN LENGTH(campo2)=1 THEN CONCAT('0',campo2) ELSE campo2 END AS grupo , campo2"; 
				$consulta_g = $consulta_g." FROM sea_web.movimientos WHERE tipo_movimiento = 2 AND cod_producto = ".$valor[1]." AND cod_subproducto = ".$valor[2];
				$consulta_g = $consulta_g." AND flujo = ".$valor[0];
				$consulta_g = $consulta_g."	AND (fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' ";
				$consulta_g = $consulta_g." OR (fecha_benef BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'))";
				$consulta_g = $consulta_g." and hora between '".$fecha_ini." 08:00:00' and '".$fecha_ter." 07:59:59'";		
				$consulta_g = $consulta_g." ORDER BY grupo,fecha_movimiento ";
				//echo $consulta_g."<br>";
				$rs_g = mysqli_query($link, $consulta_g);
                
				while($fila = mysqli_fetch_array($rs_g))
				{
					  if($radio2 != "P")//radio peso
					  {	
							//Limpio el arreglo.
							reset($total_grupo);
							while (list($c2, $v2) = each($total_grupo))
							{	
								$total_grupo[$c2][0] = 0;	
							}


							//Limpia el arreglo de los Totales por Dia de las Leyes.
							reset($total_dia);
							while (list($c1, $v1) = each($total_dia))
							{	
								$total_dia[$c1][0] = 0; //Acumulador.				
							}		
					  }

						//escribe el Grupo.
						echo '<table width="164" border="0" cellspacing="0" cellpadding="0" align="center">';
						echo '<tr class="ColorTabla01"><td align="center">Grupo '.$fila[campo2].'</td>';
						echo '</tr></table>';																

						$consulta = "SELECT cod_producto, cod_subproducto, fecha_movimiento, fecha_benef, campo1, campo2, hornada, unidades, peso,";
						$consulta = $consulta." CASE WHEN fecha_benef <> '0000-00-00' THEN 'D' ELSE 'N' END AS tipo_reg";
						$consulta = $consulta." FROM sea_web.movimientos";
						$consulta = $consulta." WHERE tipo_movimiento = 2 AND cod_producto = ".$valor[1];
						$consulta = $consulta." AND flujo = ".$valor[0]." AND campo2 = '".$fila[campo2]."'";
						$consulta = $consulta."	AND (fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' ";
						$consulta = $consulta." OR (fecha_benef BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'))";
						$consulta = $consulta." and hora between '".$fecha_ini." 08:00:00' and '".$fecha_ter." 07:59:59'";		
						$consulta = $consulta." ORDER BY hornada";	
									
						//poly $consulta = $consulta." AND ((fecha_movimiento = '".$fecha_aux."' AND fecha_benef = '0000-00-00')";
						//poly $consulta = $consulta." OR (fecha_benef = '".$fecha_aux."'))";	
									
						//echo $consulta."<br>";				
							
						$rs2 = mysqli_query($link, $consulta);
	
						if (mysqli_num_rows($rs2) != 0) //Si la Consulta devuelve datos.
						{	
							//Crea el detalle.					
							echo '<table width="'.$largo.'" border="0" cellspacing="0" cellpadding="0" align="center" class="ColorTabla02">'; 
							while ($row2 = mysqli_fetch_array($rs2))
							{												  
								if ($row2[tipo_reg] == "N")
									echo '<tr><td width="25">'.substr($row2[fecha_movimiento],8,2).'</td>';
								else 
									echo '<tr><td width="25">'.substr($row2[fecha_benef],8,2).'</td>';
									
								echo '<td width="45 "align="center">'.substr($row2[hornada],6,6).'</td>';
								echo '<td width="20" align="center">'.$row2[campo1].'</td>';
								echo '<td width="30" align="right">';
								echo $row2["unidades"].'</td>';
								echo '<td width="60" align="right">';
								echo $row2["peso"].'</td>';
							
								if ($radio2 != "P")
								{
									//Limpio el arreglo.
									reset($det_leyes);
									while (list($c1, $v1) = each($det_leyes))
									{	
										$det_leyes[$c1][0] = 0;
									}
																		
									//Consulta las Leyes en Control de Calidad
									$consulta = "SELECT t1.valor, t1.cod_leyes FROM sea_web.leyes_por_hornada AS t1";
									$consulta = $consulta." INNER JOIN proyecto_modernizacion.leyes AS t2 ON t1.cod_leyes = t2.cod_leyes";
									$consulta = $consulta." INNER JOIN proyecto_modernizacion.unidades AS t3 ON t2.cod_unidad = t3.cod_unidad";
									$consulta = $consulta." WHERE cod_producto = ".$valor[1]." AND t1.cod_subproducto = ".$valor[2];
									$consulta = $consulta." AND t1.hornada = ".$row2[hornada]." AND t1.valor <> ''";		
								
									$rs5 = mysqli_query($link, $consulta);
																				
									//Traspaso las leyes de cada hornada a un arreglo, para que mantengan la estructura de la tabla.
									while ($row5 = mysqli_fetch_array($rs5))
									{
										if ($radio2 == "L") //Si son Leyes
											$det_leyes[$row5["cod_leyes"]][0] = $row5["valor"];
										else 
											$det_leyes[$row5["cod_leyes"]][0] = ($row2["peso"] * $row5["valor"] / $det_leyes[$row5["cod_leyes"]][1]); //Si son Finos.
										//echo $det_leyes[$row5["cod_leyes"]][0]."<br>";
										
										//Se ingresan los totales de cada Ley. (Por Dia)
										if($det_leyes[$row5["cod_leyes"]][1] != 0)
										{

											$total_dia[$row5["cod_leyes"]][0] = $total_dia[$row5["cod_leyes"]][0] + ($row2["peso"] * $row5["valor"] / $det_leyes[$row5["cod_leyes"]][1]);
											
											//Se ingresan los totales de cada Ley. (Por Flujo)
											$total_leyes[$row5["cod_leyes"]][0] = $total_leyes[$row5["cod_leyes"]][0] + ($row2["peso"] * $row5["valor"] / $det_leyes[$row5["cod_leyes"]][1]);							
										}
									}																	
								}
										
								//Genero las columnas de leyes que estan en el arreglo.
								reset($det_leyes);
								while (list($c1, $v1) = each($det_leyes))
								{
									if ($radio2 == "L") //Leyes.
									{
										if ($c1 == '02')
											echo '<td width="40" align="right">'.number_format($v1[0],2,",","").'</td>';
										else if ($c1 == '05')
											echo '<td width="40" align="right">'.number_format($v1[0],1,",","").'</td>';											
										else
											echo '<td width="40" align="right">'.number_format($v1[0],0,",","").'</td>';
									}
									else//Finos
									{
										if (($c1 == '02') or ($c1 == '04') or ($c1 == '05'))
											echo '<td width="60" align="right">'.number_format($v1[0],0,"","").'</td>';
										else 
											echo '<td width="40" align="right">'.number_format($v1[0],0,"","").'</td>';
									}
								}						    
								echo '</tr>';				
							}				
							//echo '</table>';
																									
							//*** TOTAL POR DIA ***//
							$consulta = "SELECT SUM(unidades) AS unid, SUM(peso) AS peso";
							$consulta = $consulta." FROM sea_web.movimientos";
							$consulta = $consulta." WHERE tipo_movimiento = ".$valor[3]." AND cod_producto =".$valor[1];
							$consulta = $consulta." AND cod_subproducto = ".$valor[2]." AND flujo = ".$valor[0];
							$consulta = $consulta." AND campo2 = '".$fila[campo2]."'";
							//$consulta = $consulta." AND fecha_movimiento = '".$fecha_aux."'";
							$consulta = $consulta."	AND (fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' ";
							$consulta = $consulta." OR (fecha_benef BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'))";
							$consulta = $consulta." and hora between '".$fecha_ini." 08:00:00' and '".$fecha_ter." 07:59:59'";		

							
							//poly$consulta = $consulta." AND ((fecha_movimiento = '".$fecha_aux."' AND fecha_benef = '0000-00-00')";
							//poly$consulta = $consulta." OR (fecha_benef = '".$fecha_aux."'))";	
							$consulta = $consulta." GROUP BY campo2";					
			
							$rs7 = mysqli_query($link, $consulta);	
							$row7 = mysqli_fetch_array($rs7);
							
							//echo '<table width="'.$largo.'" border="0" cellspacing="0" cellpadding="0" align="center" class="Detalle02">'; 				
							echo '<tr class="Detalle02"><td colspan="3">Subtotal Dia</td>'; 
							echo '<td width="30" align="right">';
							echo $row7[unid].'</td>';
							echo '<td width="60" align="right">';
							echo $row7["peso"].'</td>';
							
							//Genero las columnas de leyes que estan en el arreglo.
							reset($total_dia);
							while (list($c1, $v1) = each($total_dia))
							{
								if ($radio2 == "L") //Leyes.
								{
									if ($v1[1] == 0)
										echo '<td width="40" align="right">0</td>';
									else
									{
										if ($c1 == '02') 
											echo '<td width="40" align="right">'.number_format(($v1[0] * $v1[1] / $row7["peso"]),2,",","").'</td>';
										else if($c1 == '05')
											echo '<td width="40" align="right">'.number_format(($v1[0] * $v1[1] / $row7["peso"]),1,",","").'</td>';
										else
											echo '<td width="40" align="right">'.number_format(($v1[0] * $v1[1] / $row7["peso"]),0,",","").'</td>';
									}
								}
								else //Finos.
								{
									if (($c1 == '02') or ($c1 == '04') or ($c1 == '05'))
										echo '<td width="60" align="right">'.number_format($v1[0],0,"","").'</td>';
									else 
										echo '<td width="40" align="right">'.number_format($v1[0],0,"","").'</td>';
								}
							}						    				
							echo '</tr></table><br>';
							
																		
						}
					
				}
					//Incrementa la fecha en 1 Dia.
					//echo "Fecha".$fecha_aux;
					/*$consulta = "SELECT DATE_ADD('".$fecha_aux."',INTERVAL 1 DAY) AS fecha";
					$rs10 = mysqli_query($link, $consulta);
					$row10 = mysqli_fetch_array($rs10);
					$fecha_aux = $row10["fecha"];
					echo "Fecha+++1".$fecha_aux;*/
					$fecha_aux=date($fecha_ter1);
			}
					//TOTALES POR FLUJO
					$consulta = "SELECT SUM(unidades) AS unid, SUM(peso) AS peso";
					$consulta = $consulta." FROM sea_web.movimientos";
					$consulta = $consulta." WHERE tipo_movimiento = ".$valor[3]." AND cod_producto = ".$valor[1];
					$consulta = $consulta." AND cod_subproducto = ".$valor[2]." AND flujo = ".$valor[0];
					$consulta = $consulta."	AND (fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' ";
					$consulta = $consulta." OR (fecha_benef BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'))";		
					$consulta = $consulta." and hora between '".$fecha_ini." 08:00:00' and '".$fecha_ter." 07:59:59'";		
					//$consulta = $consulta." GROUP BY campo2,fecha_movimiento";	
//echo "Con".$consulta;
					
					//poly $consulta = $consulta." AND ((fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."')";
					//poly $consulta = $consulta." OR (fecha_benef BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'))";
					//$consulta = $consulta." AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";			
					
					$rs3 = mysqli_query($link, $consulta);
					
					echo '<table width="'.$largo.'" border="0" cellspacing="0" cellpadding="0" align="center" class="Detalle02">';
					echo '<tr><td width="90">'; 
					if ($radio == "P")
						echo 'Total Prod.</td>';
					else
						echo 'Total Flujo</td>';
					
					$row3 = mysqli_fetch_array($rs3);
					if (!is_null($row3[unid]))					
					{  
						echo '<td width="30" align="right">';
						echo $row3[unid].'</td>';				
						echo '<td width="60" align="right">';
						echo $row3["peso"].'</td>';
					
						//Genero las columnas con los totales de las Leyes.
						reset($total_leyes);
						while (list($c1, $v1) = each($total_leyes))
						{
							if ($radio2 == "L") //Leyes.
							{
								if ($v1[1] == 0)
									echo '<td width="40" align="right">0</td>';
								else
									if ($c1 == '02')
										echo '<td width="40" align="right">'.number_format(($v1[0] * $v1[1] / $row3["peso"]),2,",","").'</td>';
									else if ($c1 == '05')
										echo '<td width="40" align="right">'.number_format(($v1[0] * $v1[1] / $row3["peso"]),1,",","").'</td>';
									else
										echo '<td width="40" align="right">'.number_format(($v1[0] * $v1[1] / $row3["peso"]),0,",","").'</td>';
							}
							else //Finos.
							{
								if (($c1 == '02') or ($c1 == '04') or ($c1 == '05'))
									echo '<td width="60" align="right">'.number_format($v1[0],0,"","").'</td>';
								else
									echo '<td width="40" align="right">'.number_format($v1[0],0,"","").'</td>';
							}
						}									       
					}
					echo '</tr></table><br>';						       					
		}
	}		
?>	

<table width="320" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
	<td align="center"><input name="btnimprimir" type="button" value="Imprimir" style="width:70;" onClick="JavaScript:Imprimir()">
      <input name="btnsalir" type="button" style="width:70;" onClick="JavaScript:Salir()" value="Salir"></td>
  </tr>
</table>

</body>
</html>
<?php include("../principal/cerrar_sea_web.php") ?>