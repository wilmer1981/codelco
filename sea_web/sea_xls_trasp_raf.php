<?php 
	        ob_end_clean();
        $file_name=basename($_SERVER['PHP_SELF']).".xls";
        $userBrowser = $_SERVER['HTTP_USER_AGENT'];
        if ( preg_match( '/MSIE/i', $userBrowser ) ) {
        $filename = urlencode($filename);
        }
        $filename = iconv('UTF-8', 'gb2312', $filename);
        $file_name = str_replace(".php", "", $file_name);
        header("<meta http-equiv='X-UA-Compatible' content='IE=Edge'>");
        header("<meta http-equiv='content-type' content='text/html;charset=uft-8'>");
        
        header("content-disposition: attachment;filename={$file_name}");
        header( "Cache-Control: public" );
        header( "Pragma: public" );
        header( "Content-type: text/csv" ) ;
        header( "Content-Dis; filename={$file_name}" ) ;
        header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	include("../principal/conectar_sea_web.php");
 ?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<?php
  //<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
?>
<script language="JavaScript">
function Salir()
{
	window.history.back();
}

function Imprimir()
{
	window.print();
}
</script>
</head>
<body class="TablaPrincipal">
<table width="320" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr class="ColorTabla01">
   <?php
   	$buscar = "SELECT descripcion from proyecto_modernizacion.subproducto where cod_producto = '19' and ";
	$buscar.=" cod_subproducto = '".$cmbrestos."' ";
	$resp = mysqli_query($link, $buscar);
	if ($row=mysqli_fetch_array($resp))
	{
		$descripcion = $row["descripcion"];
	}

  ?>
    <td align="center">TRASPASO DE <?php echo $descripcion; ?>  A RAF</td>
  </tr>
  <tr class="ColorTabla02"> 
    <td align="center" colspan="4">PERIODO: <?php echo $dia_i.'/'.$mes_i.'/'.$ano_i ?> AL <?php echo $dia_t.'/'.$mes_t.'/'.$ano_t ?></td>
  </tr>
</table>
<br>

<table width="330" border="0" cellpadding="0" cellspacing="0" align="center" class="ColorTabla01">
  <tr>
<?php
	if ($radio2 == "L")
		echo '<td align="center" colspan="4">LEYES</td>';
	else if ($radio2 == "F")
		echo '<td align="center" colspan="4">FINOS</td>';
	else
		echo '<td align="center" colspan="4">PESOS</td>';
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

	$largo = 300; //Largo de la Tabla.

	if ($radio2 != "P")	
	{
			
		$consulta = "SELECT DISTINCT t1.cod_leyes AS codigo, t2.abreviatura AS ab1, t3.abreviatura AS ab2, t3.conversion FROM sea_web.leyes_por_hornada AS t1";
		$consulta = $consulta." INNER JOIN proyecto_modernizacion.leyes AS t2 ON t1.cod_leyes = t2.cod_leyes";
		$consulta = $consulta." INNER JOIN proyecto_modernizacion.unidades AS t3 ON t1.cod_unidad = t3.cod_unidad";
		$consulta = $consulta." WHERE t1.cod_producto = 17 AND t1.valor <> '' ";
		$consulta = $consulta." ORDER BY t2.orden_sea";			
		$rs4 = mysqli_query($link, $consulta);		
	
		if (mysqli_num_rows($rs4) <> 0)
			$largo = $largo + (45 * mysqli_num_rows($rs4));
	}
	
	echo '<table width="'.$largo.'"  border="0" cellspacing="0" cellpadding="0" align="center" class="ColorTabla01"><tr>';
    echo '<td width="100" align="center">GRUPO</td>';
    echo '<td width="100" align="center">UNIDADES</td>';
    echo '<td width="100" align="center">PESO</td>';
	
	$total_grupo = array(); //Totales de las leyes por Flujo � Producto.
	$total_dia = array();
	$det_leyes = array();
	
	if ($radio2 != "P")
	{
		while ($row4 = mysqli_fetch_array($rs4))
		{
			echo '<td width="45" align="center">'.$row4[ab1].'<br>'.$row4[ab2].'</td>';
	
			$det_leyes[$row4[codigo]][0] = 0; //ley.
			$det_leyes[$row4[codigo]][1] = $row4["conversion"]; //unidad de conversion.

			$total_grupo[$row4[codigo]][0] = 0; //Acumulador por cada Ley.
			$total_grupo[$row4[codigo]][1] = $row4["conversion"]; //unidad de conversion.

			$total_dia[$row4[codigo]][0] = 0; //Valor Ley
			$total_dia[$row4[codigo]][1] = $row4["conversion"]; //Unidad de conversion.			
		}
	}	
?>	

  </tr>
</table>
<br>
<?php

$FechaIni = $fecha_ini." 08:00:00";
$FechaFin = date("Y-m-d", mktime(1,0,0,$mes_t,($dia_t + 1),$ano_t))." 07:59:59";

$consulta = "SELECT * FROM sea_web.movimientos WHERE tipo_movimiento = 4 AND cod_producto = 19";
$consulta = $consulta." and cod_subproducto = '".$cmbanodos."'  AND (fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."')";
$consulta = $consulta." and (hora between '".$FechaIni."' and '".$FechaFin."') ORDER BY fecha_movimiento";		
$rs8 = mysqli_query($link, $consulta);
if (mysqli_num_rows($rs8) != 0) //Si existen datos escribir flujo.
{
   $row8 = mysqli_fetch_array($rs8);

}
$fecha_aux = $row8[fecha_movimiento];
while (date($fecha_aux) <= date($fecha_ter)) //Recorre los dias.
{
	$TotalCantidad = 0;
	$TotalPeso = 0;
		
		//Limpia el arreglo de los Totales de las Leyes.
		reset($total_dia);
		while (list($c1, $v1) = each($total_dia))
		{	
			$total_dia[$c1][0] = 0; //Acumulador.
			$total_dia[$c1][2] = 0; //peso.				
		}		
		$Fecha1 = $fecha_aux." 08:00:00";
		$MesA = substr($fecha_aux,5,2);
		$DiaA = substr($fecha_aux,8,2);
		$AnoA = substr($fecha_aux,0,4);
		$Fecha2 = date("Y-m-d", mktime(1,0,0,$MesA,($DiaA +1),$AnoA))." 07:59:59";

		$consulta = "SELECT DISTINCT CASE WHEN LENGTH(campo2)=1 THEN CONCAT('0',campo2) ELSE campo2 END AS grupo , campo2";
		$consulta = $consulta." FROM sea_web.movimientos WHERE tipo_movimiento = 4 AND cod_producto = 19 and cod_subproducto = '".$cmbanodos."' ";
		$consulta = $consulta." AND fecha_movimiento = '".$fecha_aux."' and (hora between '".$Fecha1."' and '".$Fecha2."')";
        $consulta = $consulta." ORDER BY grupo";
		$rs2 = mysqli_query($link, $consulta);		
		if(mysqli_num_rows($rs2) != 0) //Si la Consulta devuelve datos.
		{       	   
			echo '<table width="100" border="0" cellspacing="0" cellpadding="0" align = "center">'; 
		    echo '<tr class="ColorTabla01">';
				echo '<td colspan="4">FECHA: '.$fecha_aux.'</td>';
			echo '</tr>';
			echo '</table><br>';

			//Crea el detalle.					
			echo '<table width="'.$largo.'" border="0" cellspacing="0" cellpadding="0" align = "center">'; 
			while ($row2 = mysqli_fetch_array($rs2))
			{
				//Limpia el arreglo de los Totales de las Leyes.
				reset($total_grupo);
				while (list($c1, $v1) = each($total_grupo))
				{	
					$total_grupo[$c1][0] = 0; //Acumulador.
					$total_grupo[$c1][2] = 0; //peso.				
				}		
															 
				$consulta = "SELECT SUM(unidades) as unidades, sum(peso) as peso FROM movimientos";
				$consulta = $consulta." WHERE tipo_movimiento = 4 AND cod_producto = 19 and cod_subproducto = '".$cmbanodos."' ";
				$consulta = $consulta." AND campo2 = '".$row2[campo2]."' AND fecha_movimiento = '".$fecha_aux."'";
				$consulta.=" and (hora between '".$Fecha1."' and '".$Fecha2."')";
				$rs3 = mysqli_query($link, $consulta);
				$row3 = mysqli_fetch_array($rs3);
			
				$TotalCantidad = $TotalCantidad + $row3["unidades"];
				$TotalPeso = $TotalPeso + $row3["peso"];
								
				echo '<tr class="ColorTabla02">';
				echo '<td width="100" align="center">'.$row2[campo2].'</td>';
				echo '<td width="100" align="center">'.$row3["unidades"].'</td>';
				echo '<td width="100" align="center">'.$row3["peso"].'</td>';

				if ($radio2 != "P")	
				{
					//LEYES.
					$consulta = "SELECT * FROM sea_web.movimientos";
					$consulta = $consulta." WHERE tipo_movimiento = 4 AND cod_producto = 19 and cod_subproducto = '".$cmbanodos."' ";
					$consulta = $consulta." AND campo2 = '".$row2[campo2]."' AND fecha_movimiento = '".$fecha_aux."'";
					$consulta.=" and (hora between '".$Fecha1."' and '".$Fecha2."')";
					$rs4 = mysqli_query($link, $consulta);
					while ($row4 = mysqli_fetch_array($rs4))
					{
						$consulta = "SELECT t1.valor, t1.cod_leyes FROM sea_web.leyes_por_hornada AS t1";
						$consulta = $consulta." INNER JOIN proyecto_modernizacion.leyes AS t2 ON t1.cod_leyes = t2.cod_leyes";
						$consulta = $consulta." INNER JOIN proyecto_modernizacion.unidades AS t3 ON t2.cod_unidad = t3.cod_unidad";
						$consulta = $consulta." WHERE t1.cod_producto = ".$row4["cod_producto"]." AND t1.cod_subproducto = '".$row4["cod_subproducto"]."'";
						$consulta = $consulta." AND t1.hornada = ".$row4[hornada]." AND t1.valor <> ''";
						$rs5 = mysqli_query($link, $consulta);
						
						//Traspaso las leyes de cada hornada a un arreglo, para que mantengan la estructura de la tabla.
						while ($row5 = mysqli_fetch_array($rs5))
						{							
							//Se ingresan los totales de cada Ley. (Por Grupo)
							$total_grupo[$row5["cod_leyes"]][0] = $total_grupo[$row5["cod_leyes"]][0] + ($row4["peso"] * $row5["valor"] / $total_grupo[$row5["cod_leyes"]][1]);
							$total_grupo[$row5["cod_leyes"]][2] = $total_grupo[$row5["cod_leyes"]][2] + $row4["peso"];														
							
							$total_dia[$row5["cod_leyes"]][0] = $total_dia[$row5["cod_leyes"]][0] + ($row4["peso"] * $row5["valor"] / $total_dia[$row5["cod_leyes"]][1]);
							$total_dia[$row5["cod_leyes"]][2] = $total_dia[$row5["cod_leyes"]][2] + $row4["peso"];
						}									
					}
					//Detalle del grupo.
					reset($total_grupo);
					while (list($c1, $v1) = each($total_grupo))
					{
						if ($radio2 == "L") //Leyes.
						{
							if ($v1[0] == 0)
								echo '<td width="45" align="center">0</td>';
							else
							{
								if ($c1 == '02' or $c1 == '05')
									echo '<td width="45" align="center">'.number_format(($v1[0] * $v1[1] / $v1[2]),2,",","").'</td>';
								else
									echo '<td width="45" align="center">'.number_format(($v1[0] * $v1[1] / $v1[2]),1,",","").'</td>';
							}
						}
						else //Finos.
						{
							echo '<td width="45" align="center">'.number_format($v1[0],0,"","").'</td>';
						}
					}									
				}
				echo '</tr>';
			}
			
			echo '<tr class="Detalle02">';
			echo '<td width="100">TOTAL</td>';
			echo '<td width="100" align="center">'.$TotalCantidad.'</td>';
			echo '<td width="100" align="center">'.$TotalPeso.'</td>';
			if($radio2 != "P")
		    {
				reset($total_dia);
				while (list($c1, $v1) = each($total_dia))
				{
					if ($radio2 == "L") //Leyes.
					{
						if ($v1[2] == 0)
							echo '<td width="45" align="center">0</td>';
						else
						{
							if (($c1 == '02') or ($c1 == '05'))
								echo '<td width="45" align="center">'.number_format(($v1[0] * $v1[1] / $v1[2]),2,".","").'</td>';
							else
								echo '<td width="45" align="center">'.number_format(($v1[0] * $v1[1] / $v1[2]),1,".","").'</td>';
						}
					}
					else //Finos.
					{
						echo '<td width="45" align="center">'.number_format($v1[0],0,"","").'</td>';
					}
				}
			  }						
			
			echo '</tr>';
	     	echo '</table><br>';
			
	 }			

	//Incrementa la fecha en 1 Dia.
	$consulta = "SELECT DATE_ADD('".$fecha_aux."',INTERVAL 1 DAY) AS fecha";
	$rs10 = mysqli_query($link, $consulta);
	$row10 = mysqli_fetch_array($rs10);
	$fecha_aux = $row10["fecha"];				
	
}   
?>

<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
	<td align="center">
    <input name="btnimprimir" type="button" value="Imprimir" style="width:70;" onClick="JavaScript:Imprimir()">
	<input name="btnsalir" type="button" style="width:70" onClick="JavaScript:Salir()" value="Salir"></td>
  </tr>
</table>

</body>
</html>
<?php include("../principal/cerrar_sea_web.php") ?>