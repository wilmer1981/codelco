<?php 
include("../principal/conectar_sea_web.php");

$radio2    = isset($_REQUEST["radio2"])?$_REQUEST["radio2"]:"";
$radio = isset($_REQUEST["radio"])?$_REQUEST["radio"]:"";
$dia_i     = isset($_REQUEST["dia_i"])?$_REQUEST["dia_i"]:date("d");
$mes_i     = isset($_REQUEST["mes_i"])?$_REQUEST["mes_i"]:date("m");
$ano_i     = isset($_REQUEST["ano_i"])?$_REQUEST["ano_i"]:date("Y");
$dia_t     = isset($_REQUEST["dia_t"])?$_REQUEST["dia_t"]:date("d");
$mes_t     = isset($_REQUEST["mes_t"])?$_REQUEST["mes_t"]:date("m");
$ano_t     = isset($_REQUEST["ano_t"])?$_REQUEST["ano_t"]:date("Y");
$cmborigen = isset($_REQUEST["cmborigen"])?$_REQUEST["cmborigen"]:"";
$cmbflujorestos = isset($_REQUEST["cmbflujorestos"])?$_REQUEST["cmbflujorestos"]:"";
$cmbrestos = isset($_REQUEST["cmbrestos"])?$_REQUEST["cmbrestos"]:"";

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
<table width="330" border="0" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
  <tr>
    <td align="center">PRODUCCION ACUMULADA DE RESTOS</td>
  </tr>
  <tr> 
    <td align="center">PERIODO: <?php echo $dia_i.'/'.$mes_i.'/'.$ano_i ?> AL <?php echo $dia_t.'/'.$mes_t.'/'.$ano_t ?></td>
  </tr>
</table>
<br>
<table width="330" border="0" cellpadding="0" cellspacing="0" align="center" class="ColorTabla01">
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

	//$fecha_ini = $ano_i.'-'.$mes_i.'-'.$dia_i;
	//$fecha_ter = $ano_t.'-'.$mes_t.'-'.$dia_t;
	
	$fecha_ini =date("Y-m-d", mktime(1,0,0,$mes_i,$dia_i ,$ano_i));	
	$fecha_ter =date("Y-m-d", mktime(1,0,0,$mes_t,($dia_t +1),$ano_t));	

	//echo "fechaini".$fecha_ini.'-'.$fecha_ter;
	$largo = 190; //Largo de la Tabla.

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
    echo '<td width="40" align="center">Grupo</td>';
	echo '<td width="50" align="center">Horn.</td>';
    echo '<td width="40" align="center">Unid.</td>';
    echo '<td width="60" align="center">Peso</td>';
	
	$total_leyes = array(); //Totales de las leyes por Flujo � Producto.
	
	if ($radio2 != "P")
	{
		while ($row4 = mysqli_fetch_array($rs4))
		{
			if (($radio2 == "F") and (($row4["codigo"] == '02') or ($row4["codigo"] == '04') or ($row4["codigo"] == '05')))
				echo '<td width="60" align="center">'.$row4["ab1"].'<br>'.$row4["ab2"].'</td>';
			else 
				echo '<td width="40" align="center">'.$row4["ab1"].'<br>'.$row4["ab2"].'</td>';
	
			$det_leyes[$row4["codigo"]][0] = 0; //ley.
			$det_leyes[$row4["codigo"]][1] = $row4["conversion"]; //unidad de conversion.

			$total_leyes[$row4["codigo"]][0] = 0; //Acumulador por cada Ley.
			$total_leyes[$row4["codigo"]][1] = $row4["conversion"]; //unidad de conversion.

			$total_dia[$row4["codigo"]][0] = 0; //Valor Ley
			$total_dia[$row4["codigo"]][1] = $row4["conversion"]; //Unidad de conversion.			
		}
	}
?>	

  </tr>
</table>
<br>
<?php
$consulta = "SELECT * FROM sea_web.movimientos WHERE tipo_movimiento = 3 AND cod_producto = 19";
$consulta = $consulta." AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
$consulta = $consulta." and hora between '".$fecha_ini." 08:00:00' and '".$fecha_ter." 07:59:59' ORDER BY fecha_movimiento";		
$rs8 = mysqli_query($link, $consulta);
//echo "con".$consulta;
if (mysqli_num_rows($rs8) != 0) //Si existen datos escribir flujo.
{
   $row8 = mysqli_fetch_array($rs8);
}
	$fecha_aux = $row8["fecha_movimiento"];
$fecha_ter1 =date("Y-m-d", mktime(1,0,0,$mes_t,($dia_t +1),$ano_t));	
//poy hoy while (date($fecha_aux) <= date($fecha_ter)) //Recorre los dias.
//echo "FT".$fecha_ter1;
//while (date($fecha_aux) <= date($fecha_ter1)) //Recorre los dias.
while (date($fecha_aux) < date($fecha_ter1)) //Recorre los dias.
{
	//echo "FT".$fecha_aux."-".$fecha_ter1;
    //Limpia el arreglo de los Totales por Dia de las Leyes.
	if ($radio2 != "P")
	{
		reset($total_dia);
		//while (list($c1, $v1) = each($total_dia))
		foreach($total_dia as $c1=>$v1)
		{	
			$total_dia[$c1][0] = 0; //Acumulador.				
		}	

	}			
		
		$TotalCantidad = 0;
		$TotalPeso = 0;

		$consulta = "SELECT DISTINCT CASE WHEN LENGTH(campo2)=1 THEN CONCAT('0',campo2) ELSE campo2 END AS grupo , campo2";
		$consulta = $consulta."	FROM sea_web.movimientos WHERE tipo_movimiento = 3 AND cod_producto = 19";
		$consulta = $consulta." AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
		$consulta = $consulta." and hora between '".$fecha_ini." 08:00:00' and '".$fecha_ter." 07:59:59' ORDER BY grupo";		

		
		
		//$consulta = $consulta."	AND fecha_movimiento = '".$fecha_aux."' ORDER BY grupo";
		//echo "con".$consulta;
		
		$rs2 = mysqli_query($link, $consulta);
		
		if (mysqli_num_rows($rs2) != 0)
		{

			echo '<table width="100" border="0" cellspacing="0" cellpadding="0" align = "center">'; 
		    echo '<tr class="ColorTabla01">';
			echo '<td><center>'.$fecha_aux.'</center></td>';
			echo '</tr>';
			echo '</table>';

			echo '<table width="'.$largo.'"  border="0" cellspacing="0" cellpadding="0" align="center" class="ColorTabla02">';
		
			while ($row2 = mysqli_fetch_array($rs2)) //Ciclo por campo2 (Grupo).
			{
				//Limpia el arreglo de los Totales de las Leyes.
				reset($total_leyes);
				//while (list($c1, $v1) = each($total_leyes))
				foreach($total_leyes as $c1=>$v1)
				{	
					$total_leyes[$c1][0] = 0; //Acumulador.
					$total_leyes[$c1][2] = 0; //peso.				
				}		
	
				$consulta = "SELECT cod_producto, cod_subproducto, hornada, SUM(peso) AS peso";
				$consulta = $consulta." FROM sea_web.movimientos ";
				$consulta = $consulta." WHERE tipo_movimiento = 3 AND cod_producto = 19";
				//$consulta = $consulta." AND fecha_movimiento = '".$fecha_aux."' AND campo2 = '".$row2["campo2"]."'";
				$consulta = $consulta." AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
				$consulta = $consulta." and hora between '".$fecha_ini." 08:00:00' and '".$fecha_ter." 07:59:59'";		

				$consulta = $consulta." GROUP BY cod_producto, cod_subproducto, hornada";
				//echo $consulta."<br>";
				
				$rs3 = mysqli_query($link, $consulta);
				
				if (mysqli_num_rows($rs3) != 0)		
				{
					if ($radio2 != "P")
					{
						while ($row3 = mysqli_fetch_array($rs3))
						{																					
							//Consulta las Leyes.	
							$consulta = "SELECT t1.valor, t1.cod_leyes FROM sea_web.leyes_por_hornada AS t1";
							$consulta = $consulta." INNER JOIN proyecto_modernizacion.leyes AS t2 ON t1.cod_leyes = t2.cod_leyes";
							$consulta = $consulta." INNER JOIN proyecto_modernizacion.unidades AS t3 ON t2.cod_unidad = t3.cod_unidad";
							$consulta = $consulta." WHERE t1.cod_producto = ".$row3["cod_producto"]." AND t1.cod_subproducto = '".$row3["cod_subproducto"]."'";
							$consulta = $consulta." AND t1.hornada = ".$row3["hornada"]." AND t1.valor <> ''";
							//echo $consulta."<br><br>";
							
							$rs5 = mysqli_query($link, $consulta);
							
							//Traspaso las leyes de cada hornada a un arreglo, para que mantengan la estructura de la tabla.
							while ($row5 = mysqli_fetch_array($rs5))
							{
								if ($radio2 == "L") //Si son Leyes
									$det_leyes[$row5["cod_leyes"]][0] = $row5["valor"];
								else 
									$det_leyes[$row5["cod_leyes"]][0] = ($row3["peso"] * $row5["valor"] / $det_leyes[$row5["cod_leyes"]][1]); //Si son Finos.
								//Se ingresan los totales de cada Ley. (Por Grupo)
								$total_leyes[$row5["cod_leyes"]][0] = $total_leyes[$row5["cod_leyes"]][0] + ($row3["peso"] * $row5["valor"] / $total_leyes[$row5["cod_leyes"]][1]);
								$total_leyes[$row5["cod_leyes"]][2] = $total_leyes[$row5["cod_leyes"]][2] + $row3["peso"];														
								
								$total_dia[$row5["cod_leyes"]][0] = $total_dia[$row5["cod_leyes"]][0] + ($row3["peso"] * $row5["valor"] / $det_leyes[$row5["cod_leyes"]][1]);

							}
						}
					}
					
					//Escribir Detalle. (El peso de produccion).
					$consulta = "SELECT hornada, campo2, SUM(unidades) AS unid, SUM(peso) AS peso";
					$consulta = $consulta." FROM sea_web.movimientos ";
					$consulta = $consulta." WHERE tipo_movimiento = 3 AND cod_producto = 19";
					$consulta = $consulta." AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
					$consulta = $consulta." and hora between '".$fecha_ini." 08:00:00' and '".$fecha_ter." 07:59:59'";		
					$consulta = $consulta." AND campo2 = '".$row2["campo2"]."'";

					//$consulta = $consulta." AND campo2 = '".$row2["campo2"]."' AND fecha_movimiento = '".$fecha_aux."'";
					$consulta = $consulta." GROUP BY campo2 ";				
					//echo $consulta."<br>";
					
					$rs6 = mysqli_query($link, $consulta);
					
					$row6 = mysqli_fetch_array($rs6)	;
					
					$TotalCantidad = $TotalCantidad + $row6["unid"];
					$TotalPeso = $TotalPeso + $row6["peso"];

					echo '<tr><td width="40" align="center">'.$row6["campo2"].'</td>';
					echo '<td width="50" align="center">'.substr($row6["hornada"],6,6).'</td>';					
					echo '<td width="40" align="right">'.$row6["unid"].'</td>';
					echo '<td width="60" align="right">'.$row6["peso"].'</td>';
					
					reset($total_leyes);
					//while (list($c1, $v1) = each($total_leyes))
					foreach($total_leyes as $c1=>$v1)
					{
						if ($radio2 == "L") //Leyes.
						{
							if ($v1[0] == 0)
								echo '<td width="40" align="right">0</td>';
							else
							{
								if ($c1 == '02')
									echo '<td width="40" align="right">'.number_format(($v1[0] * $v1[1] / $v1[2]),2,",","").'</td>';
								else if ($c1 == '04')
									echo '<td width="40" align="right">'.number_format(($v1[0] * $v1[1] / $v1[2]),0,",","").'</td>';
								else if ($c1 == '05')
									echo '<td width="40" align="right">'.number_format(($v1[0] * $v1[1] / $v1[2]),1,",","").'</td>';
								else
									echo '<td width="40" align="right">'.number_format(($v1[0] * $v1[1] / $v1[2]),0,",","").'</td>';
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
					echo '</tr>';			
				}
			}
	     	//echo '</table>';

			//*** TOTALES ***//
			$consulta = "SELECT SUM(unidades) AS unid, SUM(peso) AS peso";
			$consulta = $consulta." FROM sea_web.movimientos";
			$consulta = $consulta." WHERE tipo_movimiento = 3 AND cod_producto = 19";
			$consulta = $consulta." AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
			$consulta = $consulta." and hora between '".$fecha_ini." 08:00:00' and '".$fecha_ter." 07:59:59'";		

			//$consulta = $consulta." AND fecha_movimiento = '".$fecha_aux."'";					
			
			$rs7 = mysqli_query($link, $consulta);	
			$row7 = mysqli_fetch_array($rs7);
			
			//echo '<table width="'.$largo.'" border="1" cellspacing="0" cellpadding="0" align="center" class="Detalle02">'; 				
			echo '<tr class="Detalle02"><td colspan="2" align="left">T. Dia</td>'; 
			echo '<td width="40" align="right">';
			echo $row7["unid"].'</td>';
			echo '<td width="60" align="right">';
			echo $row7["peso"].'</td>';
			
			//Genero las columnas de leyes que estan en el arreglo.
		  if($radio2 != "P")
	      {
			reset($total_dia);
			//while (list($c1, $v1) = each($total_dia))
			foreach($total_dia as $c1=>$v1)
			{
				if ($radio2 == "L") //Leyes.
				{
					if ($v1[1] == 0)
						echo '<td width="40" align="right">0</td>';
					else
					{
						if ($c1 == '02')
							echo '<td width="40" align="right">'.number_format(($v1[0] * $v1[1] / $row7["peso"]),2,",","").'</td>';
						else if ($c1 == '04')
							echo '<td width="40" align="right">'.number_format(($v1[0] * $v1[1] / $row7["peso"]),0,",","").'</td>';
						else if ($c1 == '05')
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
		  }							    				
			echo '</tr></table><br>';

		}
		
			//Incrementa la fecha en 1 Dia.
			$consulta = "SELECT DATE_ADD('".$fecha_aux."',INTERVAL 1 DAY) AS fecha";
			$rs10 = mysqli_query($link, $consulta);
			$row10 = mysqli_fetch_array($rs10);
			$fecha_aux = $row10["fecha"];				
		//echo "hora".$fecha_aux;

}
?>
<br>
<table width="330" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
	<td align="center"><input name="btnimprimir" type="button" value="Imprimir" style="width:70;" onClick="JavaScript:Imprimir()">
      <input name="btnsalir" type="button" style="width:70;" onClick="JavaScript:Salir()" value="Salir"></td>
  </tr>
</table>
</body>
</html>
<?php include("../principal/cerrar_sea_web.php") ?>