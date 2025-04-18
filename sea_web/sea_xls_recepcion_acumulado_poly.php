<?php 
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	include("../principal/conectar_sea_web.php");
 ?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<?php 
	//echo'<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">';
?>
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
    <td align="center" colspan="5">PRODUCCION - RECEPCION ANODOS</td>
  </tr>
  <tr> 
    <td align="center" colspan="5">PERIODO: <?php echo $dia_i.'/'.$mes_i.'/'.$ano_i ?> AL <?php echo $dia_t.'/'.$mes_t.'/'.$ano_t ?></td>
  </tr>
</table>
<br>
<table width="320" border="0" cellpadding="0" cellspacing="0" align="center" class="ColorTabla01">
  <tr>
<?php
	if ($radio2 == "L")
		echo '<td align="center" colspan="5">LEYES</td>';
	else if ($radio2 == "F")
		echo '<td align="center" colspan="5">FINOS</td>';
	else
		echo '<td align="center" colspan="5">PESOS</td>';
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

	$fecha_ini =date("Y-m-d", mktime(1,0,0,$mes_i,$dia_i ,$ano_i));	
	$fecha_ter =date("Y-m-d", mktime(1,0,0,$mes_t,($dia_t +1),$ano_t));	

		$TotalUnidades = 0;
		$TotalPeso = 0;
		$TotalUnidadesAcum= 0;
		$TotalPesoAcum = 0;

	//$fecha_ini = $ano_i.'-'.$mes_i.'-'.$dia_i; //.' 00:00:00';
	//$fecha_ter = $ano_t.'-'.$mes_t.'-'.$dia_t; //.' 23:59:59';

	$largo = 220; //Largo de la Tabla.

	if ($radio2 != "P")	
	{
		$consulta = "SELECT DISTINCT t1.cod_leyes AS codigo, t2.abreviatura AS ab1, t3.abreviatura AS ab2, t3.conversion FROM sea_web.leyes_por_hornada AS t1";
		$consulta = $consulta." INNER JOIN proyecto_modernizacion.leyes AS t2 ON t1.cod_leyes = t2.cod_leyes";
		$consulta = $consulta." INNER JOIN proyecto_modernizacion.unidades AS t3 ON t1.cod_unidad = t3.cod_unidad";
		$consulta = $consulta." WHERE t1.cod_producto = 17 AND t1.valor <> '' ";
		$consulta = $consulta." ORDER BY t2.orden_sea";
		
		$rs4 = mysqli_query($link, $consulta);
	
		if (mysqli_num_rows($rs4) <> 0)
		{
			$largo = $largo + (40 * (mysqli_num_rows($rs4) - 3));
			if ($radio2 == "L")
				$largo = $largo + 120;
			else 
				$largo = $largo + 180;			
		}
	}
	
	echo '<table width="'.$largo.'"  border="1" cellspacing="0" cellpadding="0" align="center" class="ColorTabla01"><tr>';
    echo '<td width="30" align="center">Dia</td>';
    echo '<td width="35" align="center">Horn.</td>';
    echo '<td width="35" align="center">Lote</td>';
    echo '<td width="35" align="left">Cant.</td>';
    echo '<td width="65" align="center">Peso<br>Kgs.</td>';
	
	$det_leyes = array(); //Detalles de las leyes por Flujo oducto.
	$total_leyes = array(); //Totales de las leyes por Flujo oducto.
	$total_dia = array(); // Total por Dia.	
	$total_horno = array(); //Totales de las leyes por Horno (Solo para Ventanas). 
	$limite = array(); //Totales de las leyes por Horno (Solo para Ventanas). 
	
	if ($radio2 != "P")
	{
		while ($row4 = mysqli_fetch_array($rs4))
		{
			if (($radio2 == "F") and (($row4[codigo] == '02') or ($row4[codigo] == '04') or ($row4[codigo] == '05')))
				echo '<td width="60" align="center">'.$row4[ab1].'<br>'.$row4[ab2].'</td>';
			else 
				echo '<td width="40" align="center">'.$row4[ab1].'<br>'.$row4[ab2].'</td>';
				
			$det_leyes[$row4[codigo]][0] = 0; //ley.
			$det_leyes[$row4[codigo]][1] = $row4["conversion"]; //Unidad de conversion.
			
			$total_leyes[$row4[codigo]][0] = 0; //Acumulador por cada Ley.
			$total_leyes[$row4[codigo]][1] = $row4["conversion"]; //Unidad de conversion.
			
			$total_dia[$row4[codigo]][0] = 0; //Acumulador por cada Ley.
			$total_dia[$row4[codigo]][1] = $row4["conversion"]; //Unidad de conversion.			
			
			$total_horno[$row4[codigo]][0] = 0; //Acumulador por cada Ley.
			$total_horno[$row4[codigo]][1] = $row4["conversion"]; //Unidad de conversion.
			
			$limite[$row4[codigo]][0] = ""; //limite.
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
		$consulta = "SELECT * FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_producto = 17 AND cod_proceso = 1";
		$consulta = $consulta." ORDER BY cod_origen, horno_inicial, cod_subproducto";		
	}
	else
	{
		if ($radio == "P") //Radio Producto.
		{
			if ($cmbanodos == "T") //Todos los subproducto de un proveedor.
			{
				$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2002 AND cod_subclase = ".$cmborigen;
				$rs = mysqli_query($link, $consulta);
				$row = mysqli_fetch_array($rs);
				$codigos = $row["valor_subclase1"].",".$row[valor_subclase2].",".$row["valor_subclase3"];
			
				$consulta = "SELECT * FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_producto = 17 AND cod_proceso = 1";
				$consulta = $consulta." AND cod_subproducto in (".$codigos.")";
				$consulta = $consulta." ORDER BY cod_origen, horno_inicial, cod_subproducto";		
			}
			else
			{
				$consulta = "SELECT * FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_producto = 17 AND cod_proceso = 1 AND";
				$consulta = $consulta." cod_subproducto = ".$cmbanodos;
				$consulta = $consulta." ORDER BY cod_origen, horno_inicial, cod_subproducto";		
			}
		}
		else //Radio Flujo.
		{
			if ($cmbflujo == "T")
			{
				$consulta = "SELECT * FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 1 AND cod_origen = ".$cmborigen;
				$consulta = $consulta." ORDER BY cod_origen, horno_inicial, cod_subproducto";		
			}
			else 
			{
				$consulta = "SELECT * FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 1 AND flujo = ".$cmbflujo;
				$consulta = $consulta." AND cod_origen = ".$cmborigen;
				$consulta = $consulta." ORDER BY cod_origen, horno_inicial, cod_subproducto";		
			}
		}
	}
	
	//Ejecuta la consulta.
	$rs1 = mysqli_query($link, $consulta); 
	
	//Llena el arreglo con los flujos y subproductos; y el inicio de hornada en el caso de Ventanas(Representa al horno).
	while ($row1 = mysqli_fetch_array($rs1))
	{
		$arreglo[] = array($row1["flujo"], $row1["cod_producto"], $row1["cod_subproducto"], $row1[horno_inicial]);
	}

	$escribe_encabezado = "S";
	$escribe_total = "N";
	$sw = "S";
	
	$fecha_aux = $fecha_ini;
	$fecha_ter1 =date("Y-m-d", mktime(1,0,0,$mes_t,($dia_t +1),$ano_t));	

	while (date($fecha_ini) < date($fecha_ter1)) //Recorre los dias.
	{
		
		$consulta = "SELECT DATE_ADD('".$fecha_ini."',INTERVAL 1 DAY) AS fecha";
		$rs10 = mysqli_query($link, $consulta);
		$row10 = mysqli_fetch_array($rs10);
		$fecha_aux = $row10["fecha"];				

	
	
	// Saca todos los movimientos de recepcion afectados.
	reset($arreglo);
	while (list($clave, $valor) = each($arreglo)) // (0: flujo, 1: cod_producto, 2: cod_subproducto, 3: horno_inicial)
	{	
		//Limpia el arreglo de los Totales de las Leyes.
		reset($total_leyes);
		while (list($c1, $v1) = each($total_leyes))
		{	
			$total_leyes[$c1][0] = 0; //Acumulador.				
		}	
		
		$consulta = "SELECT * ";
		$consulta = $consulta." FROM sea_web.movimientos AS t1";
		$consulta = $consulta." WHERE t1.tipo_movimiento = 1 AND t1.cod_producto = 17 AND t1.cod_subproducto = ".$valor[2];
		$consulta = $consulta." AND t1.flujo = ".$valor[0]." AND t1.fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_aux."'";
		$consulta = $consulta." and hora between '".$fecha_ini." 08:00:00' and '".$fecha_aux." 07:59:59' ";

		
		/*$consulta = "SELECT * ";
		$consulta = $consulta." FROM sea_web.movimientos AS t1";
		$consulta = $consulta." WHERE t1.tipo_movimiento = 1 AND t1.cod_producto = 17 AND t1.cod_subproducto = ".$valor[2];
		$consulta = $consulta." AND t1.flujo = ".$valor[0]." AND t1.fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";*/
				
		if (($valor[2] == 4) or ($valor[2] == 8) or ($valor[2] == 11)) //Si es Ventanas Buscar del Horno Correspondiente.
			$consulta = $consulta." AND RIGHT(t1.hornada,4) LIKE '".$valor[3]."%'";
		
		$rs9 = mysqli_query($link, $consulta);
		
		if (mysqli_num_rows($rs9) != 0) //Si existen datos escribir flujo.
		{
			//Si es Ventanas indicar el Horno.(Escribe los Encabezados de los Hornos).
			if (($valor[2] == 4) or ($valor[2] == 8) or ($valor[2] == 11))
			{
				if ($sw == "S") //Asigna el primer Horno que encuentre.
				{	
					$num_horno = $valor[3];
					$sw = "N";
				}
				
				if (($num_horno == $valor[3]) and ($escribe_encabezado == "S"))
				{
					//escribir el encabezado del horno.
					if ($valor[3] == 1) //Horno 1
					{
						echo '<table width="320" border="0" cellspacing="0" cellpadding="0" align="center" class="ColorTabla01"><tr><td colspan="5">';
						echo 'HORNO ORIGEN: ANODOS HORNO 1</td></tr></table><br>';

						$num_horno = 2;
						$horno_anterior = 1;
					}
					else if ($valor[3] == 2) //Horno 2
						 {

							 echo '<table width="320" border="0" cellspacing="0" cellpadding="0" align="center" class="ColorTabla01"><tr><td colspan="5">';
							 echo 'HORNO ORIGEN: ANODOS HORNO 2</td></tr></table><br>';	

							 $num_horno = 4;
							 $horno_anterior = 2;					 						 
						 }
					else if ($valor[3] == 4) //Horno 3 (Basculante);
						 {

							 echo '<table width="320" border="0" cellspacing="0" cellpadding="0" align="center" class="ColorTabla01"><tr><td colspan="5">';
							 echo 'HORNO ORIGEN: ANODOS HORNO 3</td></tr></table><br>';

							 $num_horno = 0;
							 $horno_anterior = 4;
						 }		
				}			
			}				
		
		
		
		
			//Si hay movimientos escribe el Producto ujo.
			echo '<table width="320" border="0" cellspacing="0" cellpadding="0" align="center" class="ColorTabla01">';
			echo '<tr><td align="center" colspan="5">';
			
			if ($radio == "P") //Producto	
			{		
				$consulta = "SELECT descripcion AS nombre FROM proyecto_modernizacion.subproducto WHERE cod_producto = 17 AND cod_subproducto = ".$valor[2];
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

			if ($radio2 == "L") //Producto	
			{		
	            reset($limite);
				echo '<table width="'.$largo.'"  border="0" cellspacing="0" cellpadding="0" align="center" class="ColorTabla01"><tr>';
				echo '<td width="225" colspan="5">Limites Establecidos</td>';
								
				$consulta = "SELECT * FROM sea_web.limites";
				$consulta = $consulta." WHERE cod_producto = 17 AND cod_subproducto = ".$valor[2];
				$rs9 = mysqli_query($link, $consulta);
					
				while($row9 = mysqli_fetch_array($rs9))
				{
					$limite[$row9["cod_leyes"]][0] = $row9[limite];
				}
					
				while(list($c1,$v1) = each($limite))	
				{
				
					if ($v1[0] == "")
						echo '<td width="40" align="right">&nbsp;</td>';
					else
						echo '<td width="40" align="right">'.$v1[0].'</td>';
				}
				
				echo '</tr></table>';
			}
							
				$consulta = "SELECT t1.fecha_movimiento, t1.hornada, sum(t1.unidades) AS unidades, sum(t1.peso) AS peso";
				$consulta = $consulta." FROM sea_web.movimientos AS t1";
				$consulta = $consulta." WHERE t1.tipo_movimiento = 1 AND t1.cod_producto = 17 AND t1.cod_subproducto = ".$valor[2];
				$consulta = $consulta." AND t1.flujo = ".$valor[0]." AND t1.fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_aux."'";		
				$consulta = $consulta." and hora between '".$fecha_ini." 08:00:00' and '".$fecha_aux." 07:59:59' ";

							
				/*$consulta = "SELECT t1.fecha_movimiento, t1.hornada, sum(t1.unidades) AS unidades, sum(t1.peso) AS peso";
				$consulta = $consulta." FROM sea_web.movimientos AS t1";
				$consulta = $consulta." WHERE t1.tipo_movimiento = 1 AND t1.cod_producto = 17 AND t1.cod_subproducto = ".$valor[2];
				$consulta = $consulta." AND t1.flujo = ".$valor[0]." AND t1.fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";*/
				
				
				if (($valor[2] == 4) or ($valor[2] == 8) or ($valor[2] == 11)) //Si es Ventanas Buscar del Horno Correspondiente.
					$consulta = $consulta." AND RIGHT(t1.hornada,4) LIKE '".$valor[3]."%'";
				
				$consulta = $consulta." GROUP BY t1.hornada";
				$consulta = $consulta." ORDER BY t1.hornada";
		
				$rs2 = mysqli_query($link, $consulta);				
		
				if (mysqli_num_rows($rs2) != 0) //Si la Consulta devuelve datos.
				{					
			
																		
					//Crea el detalle.					
					echo '<table width="'.$largo.'" border="0" cellspacing="0" cellpadding="0" align="center" class="ColorTabla02">'; 
					while ($row2 = mysqli_fetch_array($rs2))
					{												  
						echo '<tr><td width="30">'.substr($row2[fecha_movimiento],8,2).'</td>';
						echo '<td width="35" align="center">'.substr($row2[hornada],6,6).'</td>';

						//Lote
						$Consulta = "SELECT * FROM sea_web.relaciones WHERE hornada_ventana = ".$row2[hornada];
						$rs = mysqli_query($link, $Consulta);
						if ($row = mysqli_fetch_array($rs))
						{ 
							if($valor[2] == 1)
								echo '<td width="60" align="center">'.$row[lote_origen].'</td>';
							if($valor[2] != 1)
								echo '<td width="60" align="center">'.$row[lote_ventana].'</td>';
							
						}
						else
						{
							echo '<td width="60" align="center">S/N</td>';
						}

						echo '<td width="35" align="right">';
						echo $row2["unidades"].'</td>';
						echo '<td width="65" align="right">';
						echo $row2["peso"].'</td>';
						
						if ($radio2 != "P")
						{
							//Consulta las Leyes en Control de Calidad
							$consulta = "SELECT t1.valor, t1.cod_leyes FROM sea_web.leyes_por_hornada AS t1";
							$consulta = $consulta." INNER JOIN proyecto_modernizacion.leyes AS t2 ON t1.cod_leyes = t2.cod_leyes";
							$consulta = $consulta." INNER JOIN proyecto_modernizacion.unidades AS t3 ON t2.cod_unidad = t3.cod_unidad";
							$consulta = $consulta." WHERE t1.cod_producto = 17 AND t1.cod_subproducto = ".$valor[2];
							$consulta = $consulta." AND t1.hornada = ".$row2[hornada]." AND t1.valor <> ''";	
												
							$rs5 = mysqli_query($link, $consulta);
							
							//Limpio el arreglo.
							reset($det_leyes);
							while (list($c1, $v1) = each($det_leyes))
							{	
								$det_leyes[$c1][0] = 0;
							}				
											
							//Traspaso las leyes de cada hornada a un arreglo, para que mantengan la estructura de la tabla.
							while ($row5 = mysqli_fetch_array($rs5))
							{
								if ($radio2 == "L") //Si son Leyes
									$det_leyes[$row5["cod_leyes"]][0] = $row5["valor"];
								else 
									$det_leyes[$row5["cod_leyes"]][0] = ($row2["peso"] * $row5["valor"] / $det_leyes[$row5["cod_leyes"]][1]); //Si son Finos.
									
								//Se ingresan los totales de cada Ley (Pero son los Totales de Finos).
								if($det_leyes[$row5["cod_leyes"]][1] != 0)
								{
									$total_leyes[$row5["cod_leyes"]][0] = $total_leyes[$row5["cod_leyes"]][0] + ($row2["peso"] * $row5["valor"] / $det_leyes[$row5["cod_leyes"]][1]);								
								
									//Se ingresan los totales de cada Ley.
									$total_dia[$row5["cod_leyes"]][0] = $total_dia[$row5["cod_leyes"]][0] + ($row2["peso"] * $row5["valor"] / $det_leyes[$row5["cod_leyes"]][1]);					
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
								else if ($c1 == '04')
									echo '<td width="40" align="right">'.number_format($v1[0],0,",","").'</td>';
								else if ($c1 == '05')
									echo '<td width="40" align="right">'.number_format($v1[0],1,",","").'</td>';
								else 
									echo '<td width="40" align="right">'.number_format($v1[0],0,",","").'</td>';
							}
							else //Finos.
							{
								if (($c1 == '02') or ($c1 == '04') or ($c1 == '05'))
									echo '<td width="60" align="right">'.number_format($v1[0],0,",","").'</td>';
								else
									echo '<td width="40" align="right">'.number_format($v1[0],0,",","").'</td>';
							}
						}						    
						echo '</tr>';
					}										
					echo '</table>';
					
			   }
			}
		
						
		//Saca los totales por flujo ﯲoducto, de las unidades y pesos.					

		/*$consulta = "SELECT IFNULL(SUM(t1.unidades),0) AS unid, IFNULL(SUM(peso),0) AS peso";
		$consulta = $consulta." FROM sea_web.movimientos AS t1";
		$consulta = $consulta." WHERE t1.tipo_movimiento = 1 AND t1.cod_producto = 17";
		$consulta = $consulta." AND t1.cod_subproducto = ".$valor[2]." AND t1.flujo = ".$valor[0];
		$consulta = $consulta." AND t1.fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_aux."'";*/

		$consulta = "SELECT IFNULL(SUM(t1.unidades),0) AS unid, IFNULL(SUM(peso),0) AS peso";
		$consulta = $consulta." FROM sea_web.movimientos AS t1";
		$consulta = $consulta." WHERE t1.tipo_movimiento = 1 AND t1.cod_producto = 17";
		$consulta = $consulta." AND t1.cod_subproducto = ".$valor[2]." AND t1.flujo = ".$valor[0];
		$consulta = $consulta." AND t1.fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_aux."'";
		$consulta = $consulta." and hora between '".$fecha_ini." 08:00:00' and '".$fecha_aux." 07:59:59' ";


		if (($valor[2] == 4) or ($valor[2] == 8) or ($valor[2] == 11)) //Si es Ventanas Buscar del Horno Correspondiente.
			$consulta = $consulta." AND RIGHT(t1.hornada,4) LIKE '".$valor[3]."%'";					
		
		$rs3 = mysqli_query($link, $consulta);
		$row3 = mysqli_fetch_array($rs3);
		
		if ($row3[unid] != 0)
		{
			echo '<table width="'.$largo.'" border="0" cellspacing="0" cellpadding="0" align="center" class="Detalle02">';
			echo '<tr><td width="180" colspan="3">'; 
			if ($radio == "P")
				echo 'Total Prod.</td>';
			else
				echo 'Total Flujo</td>';
			
			echo '<td width="35" align="right">';
			echo $row3[unid].'</td>';				
			echo '<td width="55" align="right">';
			echo $row3["peso"].'</td>';
		
		$TotalUnidades = $TotalUnidades +  $row3[unid];
		$TotalPeso = $TotalPeso +  $row3["peso"];
		$TotalUnidadesAcum = $TotalUnidadesAcum +  $row3[unid];
		$TotalPesoAcum = $TotalPesoAcum +  $row3["peso"];

		
			//Genero las columnas con los totales de las Leyes.
			reset($total_leyes);
			while (list($c1, $v1) = each($total_leyes))
			{
				if ($radio2 == "L") //Leyes.
				{
					if ($v1[1] == 0)
						echo '<td width="40" align="right">0</td>';
					else
					{
						if ($c1 == '02')
							echo '<td width="40" align="right">'.number_format(($v1[0] * $v1[1] / $row3["peso"]),2,",","").'</td>';
						else if ($c1 == '04')
							echo '<td width="40" align="right">'.number_format(($v1[0] * $v1[1] / $row3["peso"]),0,",","").'</td>';
						else if ($c1 == '05')
							echo '<td width="40" align="right">'.number_format(($v1[0] * $v1[1] / $row3["peso"]),1,",","").'</td>';
						else
							echo '<td width="40" align="right">'.number_format(($v1[0] * $v1[1] / $row3["peso"]),0,",","").'</td>';
					}
				}
				else //Finos.
				{
					if (($c1 == '02') or ($c1 == '04') or ($c1 == '05'))
						echo '<td width="60" align="right">'.number_format($v1[0],0,",","").'</td>';
					else 
						echo '<td width="40" align="right">'.number_format($v1[0],0,",","").'</td>';
				}
			}										  
	
			echo '</tr></table><br>';
		}
	}
			echo '<table width="'.$largo.'" border="0" cellspacing="0" cellpadding="0" align="center" class="Detalle02">';
			echo '<tr><td width="180">'; 
			if ($radio == "P")
				echo 'Total Dia </td>';
			else
				echo 'Total Flujo</td>';
			echo '<td width="35" align="right">';
			echo $TotalUnidades.'</td>';				
			echo '<td width="64" align="right">';
			echo $TotalPeso.'</td>';
			echo '</tr></table><br>';
		$consulta = "SELECT DATE_ADD('".$fecha_ini."',INTERVAL 1 DAY) AS fecha";
		$rs10 = mysqli_query($link, $consulta);
		$row10 = mysqli_fetch_array($rs10);
		$fecha_ini = $row10["fecha"];				
		$TotalUnidades = 0;
		$TotalPeso = 0;
	}
	
			echo '<table width="'.$largo.'" border="0" cellspacing="0" cellpadding="0" align="center" class="Detalle02">';
			echo '<tr><td width="180">'; 
			if ($radio == "P")
				echo 'Total Acumulado </td>';
			else
				echo 'Total Flujo Acumulado</td>';
			echo '<td width="35" align="right">';
			echo $TotalUnidadesAcum.'</td>';				
			echo '<td width="64" align="right">';
			echo $TotalPesoAcum.'</td>';
			echo '</tr></table><br>';

	
?>	

<table width="320" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
	<td align="center"><input name="btnimprimir" type="button" style="width:70;" value="Imprimir" onClick="JavaScript:Imprimir()">
      <input name="btnsalir" type="button" style="width:70;" onClick="JavaScript:Salir()" value="Salir"></td>
  </tr>
</table>

</body>
</html>
<?php include("../principal/cerrar_sea_web.php") ?>