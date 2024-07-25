<?php include("../principal/conectar_sea_web.php") ?>

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
    <td align="center">BLISTER A N.E.</td>
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

	$fecha_ini = $ano_i.'-'.$mes_i.'-'.$dia_i;
	$fecha_ter = $ano_t.'-'.$mes_t.'-'.$dia_t;


	if ($radio2 != "P")	
	{

		$consulta ="SELECT DISTINCT t2.cod_leyes AS codigo,t2.abreviatura as ab1, CASE WHEN t1.cod_leyes = '02' THEN 100 ELSE";
  		$consulta = $consulta." CASE WHEN t1.cod_leyes = '04' OR t1.cod_leyes = '05' then 1000 else 1000000 END END AS conversion,";	
 		$consulta = $consulta." CASE WHEN t1.cod_leyes = '02' THEN '%' ELSE";
 		$consulta = $consulta." CASE WHEN t1.cod_leyes = '04' OR t1.cod_leyes = '05' THEN 'g/t' ELSE 'ppm' END END AS ab2";
 		$consulta = $consulta." FROM cal_web.leyes_por_solicitud as t1";
 		$consulta = $consulta." INNER JOIN proyecto_modernizacion.leyes AS t2 ON t1.cod_leyes = t2.cod_leyes";
 		$consulta = $consulta." WHERE t1.cod_producto = 16 AND t1.valor <> ''"; 
		$consulta = $consulta." ORDER BY t2.orden_sea";
	}
	$largo = 200; //Largo de la Tabla.
	
	$rs4 = mysqli_query($link, $consulta);
	
	if ($radio2 != "P")
	{	
		if (mysqli_num_rows($rs4) <> 0)
		{
			$largo = $largo + (40 * (mysqli_num_rows($rs4) - 3));
			if ($radio2 == "L")
				$largo = $largo + 120;
			else 
				$largo = $largo + 180;
		}
	}


	echo '<table width="'.$largo.'"  border="1" cellspacing="0" cellpadding="0" align="center">';
    echo '<tr class="ColorTabla01"><td width="40" align="center">D�a </td>';
    echo '<td width="50" align="center">Lote</td>';
    echo '<td width="50" align="center">Cant.</td>';
    echo '<td width="60" align="center">Peso<br>Kgs.</td>';
	
	$det_leyes = array(); //Detalles de las leyes por Flujo � Producto.
	$total_leyes = array(); //Totales de las leyes por Flujo � Producto.
	$total_dia = array(); // Total por Dia.	
	$total_horno = array(); //Totales de las leyes por Horno (Solo para Ventanas). 
	
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
		}
	}
    echo '</tr>';	
?>	

<?php		
		
//Si hay movimientos escribe el Producto � Flujo.
$fecha_aux = $fecha_ini;
while (date($fecha_aux) <= date($fecha_ter)) //Recorre los dias.
{				

	$AcumUniDia = 0;
	$AcumPesoDia = 0;

	reset($total_dia);
	while (list($c1, $v1) = each($total_dia))
	{	
		$total_dia[$c1][0] = 0; //Acumulador.				
	}		

	//Limpia el arreglo de los Totales por Dia de las Leyes.
	$consulta = "SELECT distinct t1.fecha_movimiento, t1.hornada";
	$consulta = $consulta." FROM sea_web.movimientos AS t1";
	$consulta = $consulta." WHERE t1.tipo_movimiento = 2 AND t1.cod_producto = 16";
	$consulta = $consulta." AND t1.fecha_movimiento = '".$fecha_aux."'";

	$rs2 = mysqli_query($link, $consulta);				

	if (mysqli_num_rows($rs2) != 0) //Si la Consulta devuelve datos.
	{																										
		//Crea el detalle.					
		while ($row2 = mysqli_fetch_array($rs2))
		{												  
			$lote = substr($row2["hornada"],3,6);
			echo '<tr><td width="30">'.substr($row2[fecha_movimiento],8,2).'</td>';
			echo '<td width="40" align="center">'.$lote.'</td>';
			echo '<td width="35" align="right">';

			$consulta = "SELECT sum(unidades) AS unidades, sum(t1.peso) AS peso";
			$consulta = $consulta." FROM sea_web.movimientos AS t1";
			$consulta = $consulta." WHERE t1.tipo_movimiento = 2 AND t1.cod_producto = 16";
			$consulta = $consulta." AND t1.fecha_movimiento = '".$fecha_aux."' AND hornada = ".$row2["hornada"];
			$rs3 = mysqli_query($link, $consulta);

			if($row3 = mysqli_fetch_array($rs3))
			{
				$unidades = $row3["unidades"];
				$peso = $row3["peso"];
			}

			echo $unidades.'</td>';
			echo '<td width="65" align="right">';
			echo $peso.'</td>';
			
			if($radio2 != "P")
			{
				$consulta = "SELECT t1.valor, t1.cod_leyes FROM cal_web.leyes_por_solicitud AS t1";
				$consulta = $consulta." INNER JOIN proyecto_modernizacion.leyes AS t2 ON t1.cod_leyes = t2.cod_leyes";
				$consulta = $consulta." INNER JOIN proyecto_modernizacion.unidades AS t3 ON t2.cod_unidad = t3.cod_unidad";
				$consulta = $consulta." WHERE t1.cod_producto = 16";
				$consulta = $consulta." AND t1.id_muestra = ".$lote." AND t1.valor <> ''";
					
			}	
									
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
				if (($radio2 == "L") or ($radio2 == "P"))//Si son Leyes
					$det_leyes[$row5["cod_leyes"]][0] = $row5["valor"];
				else 
					$det_leyes[$row5["cod_leyes"]][0] = ($row3["peso"] * $row5["valor"] / $det_leyes[$row5["cod_leyes"]][1]); //Si son Finos.
						
				//Se ingresan los totales de cada Ley (Pero son los Totales de Finos).
				if($det_leyes[$row5["cod_leyes"]][1] != 0)
				{
					$total_leyes[$row5["cod_leyes"]][0] = $total_leyes[$row5["cod_leyes"]][0] + ($row3["peso"] * $row5["valor"] / $det_leyes[$row5["cod_leyes"]][1]);								
					
					//Se ingresan los totales de cada Ley.
					$total_dia[$row5["cod_leyes"]][0] = $total_dia[$row5["cod_leyes"]][0] + ($row3["peso"] * $row5["valor"] / $det_leyes[$row5["cod_leyes"]][1]);					
				}
			}

			
			//Genero las columnas de leyes que estan en el arreglo.
			reset($det_leyes);
			while (list($c1, $v1) = each($det_leyes))
			{
				if ($radio2 == "L")//Leyes.
				{
					if ($c1 == '02')  
						echo '<td width="40" align="right">'.number_format($v1[0],2,",","").'</td>';
					else if ($c1 == '05')
						echo '<td width="40" align="right">'.number_format($v1[0],1,",","").'</td>';
					else if ($c1 == '04')
						echo '<td width="40" align="right">'.number_format($v1[0],0,",","").'</td>';
					else 
						echo '<td width="40" align="right">'.number_format($v1[0],0,",","").'</td>';
				}
				elseif ($radio2 == "F") //Finos.
				{
					if (($c1 == '02') or ($c1 == '04') or ($c1 == '05'))
						echo '<td width="60" align="right">'.number_format($v1[0],0,",","").'</td>';
					else 
						echo '<td width="40" align="right">'.number_format($v1[0],0,",","").'</td>';																
				}
			}			
			echo'</tr>';
			
			$AcumUniDia = $AcumUniDia + $unidades;
			$AcumPesoDia = $AcumPesoDia + $peso;
		}																	

		echo '<tr class="Detalle02"><td colspan="2">Total Dia</td>'; 
		echo '<td width="35" align="right">';
		echo $AcumUniDia.'</td>';
		echo '<td width="65" align="right">';
		echo $AcumPesoDia.'</td>';

		//Genero las columnas de leyes que estan en el arreglo.
		reset($total_dia);
		while (list($c1, $v1) = each($total_dia))
		{
			if ($radio2 == "L")//Leyes.
			{
				if ($v1[1] == 0)
					echo '<td width="40" align="right">0</td>';
				else
				{

					if ($c1 == '02') 
						echo '<td width="40" align="right">'.number_format(($v1[0] * $v1[1] / $AcumPesoDia),2,".","").'</td>';
					else if ($c1 == '05')
						echo '<td width="40" align="right">'.number_format(($v1[0] * $v1[1] / $AcumPesoDia),1,".","").'</td>';
					else if ($c1 == '04')
						echo '<td width="40" align="right">'.number_format(($v1[0] * $v1[1] / $AcumPesoDia),0,".","").'</td>';
					else
						echo '<td width="40" align="right">'.number_format(($v1[0] * $v1[1] / $AcumPesoDia),0,".","").'</td>';
		
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

	}

	//Incrementa la fecha en 1 Dia.
	$consulta = "SELECT DATE_ADD('".$fecha_aux."',INTERVAL 1 DAY) AS fecha";
	$rs10 = mysqli_query($link, $consulta);
	$row10 = mysqli_fetch_array($rs10);
	$fecha_aux = $row10["fecha"];				
	
echo '</tr>';
}							

echo '</table><br>';																									

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