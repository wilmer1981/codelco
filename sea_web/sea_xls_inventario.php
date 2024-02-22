<?php         ob_end_clean();
        $file_name=basename($_SERVER['PHP_SELF']).".xls";
        $userBrowser = $_SERVER['HTTP_USER_AGENT'];
		$filename="";
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
 header("Expires:0");
 header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
 set_time_limit(5000);
 include("../principal/conectar_sea_web.php");


	$mes = $_REQUEST["mes"];
	$ano = $_REQUEST["ano"];
	$mostrar = $_REQUEST["mostrar"];


//----------AGREGADO POR RENE 26-09-2013-----
	//consultamos el horario que se encuentra seleccionado en a subclase
	$Consulta="SELECT valor_subclase2,valor_subclase3 from proyecto_modernizacion.sub_clase where cod_clase='2018' and valor_subclase1='S'";
	$R=mysqli_query($link, $Consulta);$Hora1='08:00:00';$Hora2='07:59:59';
	if($F=mysqli_fetch_assoc($R))
	{	$Hora1=$F["valor_subclase2"];
		$Hora2=$F["valor_subclase3"];}	
	$SumaDia='N';
	if(intval(substr($Hora1,0,2)) > intval(substr($Hora2,0,2)))
	{	$mes1=date('m',mktime(0,0,0,$mes+1,1,$ano));$SumaDia='S';$Dia1='01';}
	else
	{	$mes1=$mes;		$Dia1='31';}
	$ano1=date('Y',mktime(0,0,0,$mes+1,1,$ano));
//-------------------------------------------	
?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
</head>
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
	<?php        	
			//Busca las leyes para trabajar.			
			$consulta = "SELECT DISTINCT t1.cod_leyes AS codigo, t2.abreviatura AS ab1, t3.abreviatura AS ab2, t3.conversion FROM sea_web.leyes_por_hornada AS t1";
			$consulta = $consulta." INNER JOIN proyecto_modernizacion.leyes AS t2 ON t1.cod_leyes = t2.cod_leyes";
			$consulta = $consulta." INNER JOIN proyecto_modernizacion.unidades AS t3 ON t2.cod_unidad = t3.cod_unidad";
			$consulta = $consulta." WHERE t1.cod_producto = 17 AND t1.valor <> '' AND t1.cod_leyes IN ('02','04','05')";
			$consulta = $consulta." ORDER BY t2.orden_sea";
			$rs = mysqli_query($link, $consulta);
			
			while ($row = mysqli_fetch_array($rs))
			{	
				$det_leyes[$row["codigo"]][0] = 0; //ley.
				$det_leyes[$row["codigo"]][1] = $row["conversion"]; //Unidad de conversion.				
				
				$total_leyes[$row["codigo"]][0] = 0; //ley.
				$total_leyes[$row["codigo"]][1] = $row["conversion"]; //Unidad de conversion.								
				$total_leyes[$row["codigo"]][2] = 0; //Peso.
			}
		
		
		
			$grupos1 = array(); // (Sin Produccion).
			$grupos2 = array(); // (Con Produccion).
	
			//Busca los grupos cargados, la ultima carga del mes (Sin Produccion) y la anterior a �sta (Con Produccion).
			$consulta = "SELECT cod_subclase AS grupo FROM proyecto_modernizacion.sub_clase";
			$consulta = $consulta." WHERE cod_clase = 2004 AND cod_subclase NOT IN (1,2,7) ORDER BY cod_subclase";
			$rs = mysqli_query($link, $consulta);
			
			while ($row = mysqli_fetch_array($rs))
			{
				$consulta = "SELECT fecha_movimiento, campo1, campo2 FROM sea_web.movimientos ";
				$consulta = $consulta."WHERE tipo_movimiento = 2 AND campo2 = '".$row["grupo"]."'";
				//----------MODIFICADO POR RENE 25-09-2013-----
				//$consulta = $consulta." AND MONTH(fecha_movimiento) = ".$mes." AND YEAR(fecha_movimiento) = ".$ano;
				//$consulta = $consulta."and hora between '".$ano."-".$mes."-01 08:00:00' and '".$ano."-".$mes1."-01 07:59:59'";
				$consulta = $consulta."and hora between '".$ano."-".$mes."-01 ".$Hora1."' and '".$ano1."-".$mes1."-".$Dia1." ".$Hora2."'";
				//-----------------------------------------
				$consulta = $consulta." AND campo1 IN ('M','T')";
				$consulta = $consulta." GROUP BY fecha_movimiento";
				$consulta = $consulta." ORDER BY fecha_movimiento DESC";
				$consulta = $consulta." LIMIT 0,2";
				$rs1 = mysqli_query($link, $consulta);
				
				$i = 0; 
				while ($row1 = mysqli_fetch_array($rs1))
				{	
					if ($i == 1)
					{
						$grupos2[$row1["campo2"]][0] = $row1["fecha_movimiento"];
						$grupos2[$row1["campo2"]][1] = $row1["campo1"];					
					}
					else
					{
						$grupos1[$row1["campo2"]][0] = $row1["fecha_movimiento"];
						$grupos1[$row1["campo2"]][1] = $row1["campo1"];
					}
					$i++;					
				}															
			}

			//Genero los datos de los Grupos Sin Produccion.
			if (count($grupos1) != 0)						
			{
				echo '<br><br><br>';
				echo '<table width="600" height="25" align="center" border="0" cellspacing="0" cellpadding="0">';			
				echo '<tr>';
				echo '<td align="center" colspan="8">GRUPOS SIN PRODUCCION</td>';
				echo '</tr>';
				echo '</table><br>';			
				
				echo '<table width="600" height="25" border="0" cellspacing="0" cellpadding="0" class="ColorTabla01">';
				echo '<tr>';
				echo '<td width="100" align="center">Fecha</td>';				
				echo '<td width="50" align="center">Grupo</td>';
				echo '<td width="50" align="center">Lado</td>';
				echo '<td width="80" align="center">Unidades</td>';
				echo '<td width="80" align="center">Peso</td>';
				echo '<td width="80" align="center">Cu</td>';
				echo '<td width="80" align="center">Ag</td>';
				echo '<td width="80" align="center">Au</td>';
				echo '</tr>';
				echo '</table>';
			}			
			
			echo '<table width="600" height="25" border="1" cellspacing="0" cellpadding="0">';
			
			reset($grupos1);
			//while (list($c,$v) = each($grupos1))
			foreach($grupos1 as $c=>$v)
			{		
				//Limpio el arreglo.
				reset($total_leyes);
				//while (list($c1, $v1) = each($total_leyes))
				foreach($total_leyes as $c1=>$v1)
				{	
					$total_leyes[$c1][0] = 0;
					$total_leyes[$c1][2] = 0;					
				}			
			
				$consulta = "SELECT * FROM sea_web.movimientos";
				$consulta = $consulta." WHERE tipo_movimiento = 2";
				$consulta = $consulta." AND ((fecha_movimiento = '".$v[0]."' AND fecha_benef = '0000-00-00')";
				$consulta = $consulta." OR (fecha_movimiento = '".$v[0]."' AND MONTH(fecha_benef) = MONTH('".$v[0]."')))";
				$consulta = $consulta." AND campo2 = '".$c."' AND campo1 = '".$v[1]."' AND cod_producto = 17";
				$rs3 = mysqli_query($link, $consulta);
							
				while ($row3 = mysqli_fetch_array($rs3))
				{					
					//Limpio el arreglo.
					reset($det_leyes);
					//while (list($c1, $v1) = each($det_leyes))
					foreach($det_leyes as $c1=>$v1)
					{	
						$det_leyes[$c1][0] = 0;
					}				
				
					//Consulta las Leyes para los Ponderados.
					$consulta = "SELECT t1.valor, t1.cod_leyes FROM sea_web.leyes_por_hornada AS t1";
					$consulta = $consulta." STRAIGHT_JOIN proyecto_modernizacion.leyes AS t2 ON t1.cod_leyes = t2.cod_leyes";
					$consulta = $consulta." STRAIGHT_JOIN proyecto_modernizacion.unidades AS t3 ON t2.cod_unidad = t3.cod_unidad";
					$consulta = $consulta." WHERE t1.cod_producto =' ".$row3["cod_producto"]."' AND t1.cod_subproducto = '".$row3["cod_subproducto"]."' ";
					$consulta = $consulta." AND t1.hornada = '".$row3["hornada"]."' AND t1.cod_leyes IN ('02','04','05') AND t1.valor <> '' and t1.cod_unidad <> ''";					
					$rs4 = mysqli_query($link, $consulta);
									
					//Traspaso las leyes de cada hornada a un arreglo, para que mantengan la estructura de la tabla.					
					while ($row4 = mysqli_fetch_array($rs4))
					{	
						$det_leyes[$row4["cod_leyes"]][0] = ($row3["peso"] * $row4["valor"] / $det_leyes[$row4["cod_leyes"]][1]); //Si son Finos.
						
						//Se ingresan los totales de cada Ley (Pero son los Totales de Finos).
						$total_leyes[$row4["cod_leyes"]][0] = $total_leyes[$row4["cod_leyes"]][0] + ($row3["peso"] * $row4["valor"] / $det_leyes[$row4["cod_leyes"]][1]);

						//Se ingresa el peso, solo para las hornada, en la cual sus leyes tengan algun valor valor.
						$total_leyes[$row4["cod_leyes"]][2] = $row3["peso"] + $total_leyes[$row4["cod_leyes"]][2];						
					}										
				}
				
				$consulta = "SELECT SUM(unidades) AS unidades, SUM(peso) AS peso FROM sea_web.movimientos";
				$consulta = $consulta." WHERE tipo_movimiento = 2";
				$consulta = $consulta." AND ((fecha_movimiento = '".$v[0]."' AND fecha_benef = '0000-00-00')";
				$consulta = $consulta." OR (fecha_movimiento = '".$v[0]."' AND MONTH(fecha_benef) = MONTH('".$v[0]."')))";
				$consulta = $consulta." AND campo2 = '".$c."' AND campo1 = '".$v[1]."' AND cod_producto = 17";
				$rs6 = mysqli_query($link, $consulta);
				
				if ($row6 = mysqli_fetch_array($rs6))
				{								
					echo '<tr>';
					echo '<td width="100" align="center">'.$v[0].'</td>';					
					echo '<td width="50" align="center">'.$c.'</td>';
					echo '<td width="50" align="center">'.$v[1].'</td>';
					echo '<td width="80" align="center">'.$row6["unidades"].'</td>';
					echo '<td width="80" align="center">'.$row6["peso"].'</td>';
						
					//Escribe el arreglo de los totales.
					reset($total_leyes);
					//while (list($c1, $v1) = each($total_leyes))
					foreach($total_leyes as $c1=>$v1)
					{	
						if ($v1[2] == 0)
							echo '<td width="80" align="center">0,00</td>';
						else 
							echo '<td width="80" align="center">'.number_format(($v1[0] * $v1[1] / $v1[2]),2,",","").'</td>';
					}						
					
					echo '</tr>';
				}				
			}
			echo '</table>';
			
			
			//Genero los datos de los Grupos Con Produccion.
			if (count($grupos2) != 0)
			{
				echo '<br><br><br>';			
				echo '<table width="600" height="25" align="center" border="0" cellspacing="0" cellpadding="0">';			
				echo '<tr>';
				echo '<td align="center" colspan="8">GRUPOS CON PRODUCCION</td>';
				echo '</tr>';
				echo '</table><br>';			
			
				echo '<table width="600" height="25" border="0" cellspacing="0" cellpadding="0" class="ColorTabla01">';
				echo '<tr>';
				echo '<td width="100" align="center">Fecha</td>';				
				echo '<td width="50" align="center">Grupo</td>';
				echo '<td width="50" align="center">Lado</td>';
				echo '<td width="80" align="center">Unidades</td>';
				echo '<td width="80" align="center">Peso</td>';
				echo '<td width="80" align="center">Cu</td>';
				echo '<td width="80" align="center">Ag</td>';
				echo '<td width="80" align="center">Au</td>';
				echo '</tr>';
				echo '</table>';			
			}			
			
			echo '<table width="600" height="25" border="1" cellspacing="0" cellpadding="0">';
			
			reset($grupos2);
			//while (list($c,$v) = each($grupos2))
			foreach($grupos2 as $c=>$v)
			{		
				//Limpio el arreglo.
				reset($total_leyes);
				//while (list($c1, $v1) = each($total_leyes))
				foreach($total_leyes as $c1=>$v1)
				{	
					$total_leyes[$c1][0] = 0;
					$total_leyes[$c1][2] = 0;					
				}			
			
				$consulta = "SELECT * FROM sea_web.movimientos";
				$consulta = $consulta." WHERE tipo_movimiento = 2";
				$consulta = $consulta." AND ((fecha_movimiento = '".$v[0]."' AND fecha_benef = '0000-00-00')";
				$consulta = $consulta." OR (fecha_movimiento = '".$v[0]."' AND MONTH(fecha_benef) = MONTH('".$v[0]."')))";
				$consulta = $consulta." AND campo2 = '".$c."' AND campo1 = '".$v[1]."' AND cod_producto = 17";
				
				$rs3 = mysqli_query($link, $consulta);
							
				while ($row3 = mysqli_fetch_array($rs3))
				{					
					//Limpio el arreglo.
					reset($det_leyes);
					//while (list($c1, $v1) = each($det_leyes))
					foreach($det_leyes as $c1=>$v1)
					{	
						$det_leyes[$c1][0] = 0;
					}				
				
					//Consulta las Leyes para los Ponderados.
					$consulta = "SELECT t1.valor, t1.cod_leyes FROM sea_web.leyes_por_hornada AS t1";
					$consulta = $consulta." STRAIGHT_JOIN proyecto_modernizacion.leyes AS t2 ON t1.cod_leyes = t2.cod_leyes";
					$consulta = $consulta." STRAIGHT_JOIN proyecto_modernizacion.unidades AS t3 ON t2.cod_unidad = t3.cod_unidad";
					$consulta = $consulta." WHERE t1.cod_producto = '".$row3["cod_producto"]."' AND t1.cod_subproducto = '".$row3["cod_subproducto"]."'";
					$consulta = $consulta." AND t1.hornada = '".$row3["hornada"]."' AND t1.cod_leyes IN ('02','04','05') AND t1.valor <> '' and t1.cod_unidad <> ''";					
					$rs4 = mysqli_query($link, $consulta);
									
					//Traspaso las leyes de cada hornada a un arreglo, para que mantengan la estructura de la tabla.					
					while ($row4 = mysqli_fetch_array($rs4))
					{	
						$det_leyes[$row4["cod_leyes"]][0] = ($row3["peso"] * $row4["valor"] / $det_leyes[$row4["cod_leyes"]][1]); //Si son Finos.
						
						//Se ingresan los totales de cada Ley (Pero son los Totales de Finos).
						$total_leyes[$row4["cod_leyes"]][0] = $total_leyes[$row4["cod_leyes"]][0] + ($row3["peso"] * $row4["valor"] / $det_leyes[$row4["cod_leyes"]][1]);

						//Se ingresa el peso, solo para las hornada, en la cual sus leyes tengan algun valor valor.
						$total_leyes[$row4["cod_leyes"]][2] = $row3["peso"] + $total_leyes[$row4["cod_leyes"]][2];						
					}										
				}
				
				$consulta = "SELECT SUM(unidades) AS unidades, SUM(peso) AS peso FROM sea_web.movimientos";
				$consulta = $consulta." WHERE tipo_movimiento = 2";
				$consulta = $consulta." AND ((fecha_movimiento = '".$v[0]."' AND fecha_benef = '0000-00-00')";
				$consulta = $consulta." OR (fecha_movimiento = '".$v[0]."' AND MONTH(fecha_benef) = MONTH('".$v[0]."')))";
				$consulta = $consulta." AND campo2 = '".$c."' AND campo1 = '".$v[1]."' AND cod_producto = 17";
				$rs6 = mysqli_query($link, $consulta);
				
				if ($row6 = mysqli_fetch_array($rs6))
				{								
					echo '<tr>';
					echo '<td width="100" align="center">'.$v[0].'</td>';					
					echo '<td width="50" align="center">'.$c.'</td>';
					echo '<td width="50" align="center">'.$v[1].'</td>';
					echo '<td width="80" align="center">'.$row6["unidades"].'</td>';
					echo '<td width="80" align="center">'.$row6["peso"].'</td>';
						
					//Escribe el arreglo de los totales.
					reset($total_leyes);
					//while (list($c1, $v1) = each($total_leyes))
					foreach($total_leyes as $c1=>$v1)
					{	
						if ($v1[2] == 0)
							echo '<td width="80" align="center">0,00</td>';
						else 
							echo '<td width="80" align="center">'.number_format(($v1[0] * $v1[1] / $v1[2]),2,",","").'</td>';
					}						
					
					echo '</tr>';
				}				
			}
			echo '</table>';
			


			//Genero los datos del los Grupos de Hojas Madres.
			echo '<br><br><br>';			
			echo '<table width="500" height="25" align="center" border="0" cellspacing="0" cellpadding="0">';			
			echo '<tr>';
			echo '<td align="center" colspan="8">GRUPOS H.M.</td>';
			echo '</tr>';
			echo '</table><br>';			
		
			echo '<table width="500" height="25" border="0" cellspacing="0" cellpadding="0" class="ColorTabla01">';
			echo '<tr>';			
			echo '<td width="50" align="center">Grupo</td>';
			echo '<td width="50" align="center">Lado</td>';
			echo '<td width="80" align="center">Unidades</td>';
			echo '<td width="80" align="center">Peso</td>';
			echo '<td width="80" align="center">Cu</td>';
			echo '<td width="80" align="center">Ag</td>';
			echo '<td width="80" align="center">Au</td>';
			echo '</tr>';
			echo '</table>';						

			echo '<table width="500" height="25" border="1" cellspacing="0" cellpadding="0">';
			
			//Grupos de Hojas Madres.
			//Corresponde a los ponderados de la segunda mitad del mes, desde del dia 15 en adelante.
			
			$arreglo = array(1=>1, 2=>2, 7=>7, 8=>8); //Contiene los grupos de H.M.
			
			reset($arreglo);
			//while (list($c,$v) = each($arreglo))
			foreach($arreglo as $c=>$v)
			{
				//Limpio el arreglo.
				reset($total_leyes);
				//while (list($c1, $v1) = each($total_leyes))
				foreach($total_leyes as $c1=>$v1)
				{	
					$total_leyes[$c1][0] = 0;
					$total_leyes[$c1][2] = 0;					
				}				
				
				$consulta = "SELECT * FROM sea_web.movimientos ";
				$consulta = $consulta." WHERE tipo_movimiento = 2 AND  campo2 = '".$v."'";
				$consulta = $consulta." AND fecha_movimiento BETWEEN '".$ano."-".$mes."-15' AND '".$ano."-".$mes."-31'";
				$rs3 = mysqli_query($link, $consulta);
				
				while ($row3 = mysqli_fetch_array($rs3))
				{					
					//Limpio el arreglo.
					reset($det_leyes);
					//while (list($c1, $v1) = each($det_leyes))
					foreach($det_leyes as $c1=>$v1)
					{	
						$det_leyes[$c1][0] = 0;
					}				
				
					//Consulta las Leyes para los Ponderados.
					$consulta = "SELECT t1.valor, t1.cod_leyes FROM sea_web.leyes_por_hornada AS t1";
					$consulta = $consulta." STRAIGHT_JOIN proyecto_modernizacion.leyes AS t2 ON t1.cod_leyes = t2.cod_leyes";
					$consulta = $consulta." STRAIGHT_JOIN proyecto_modernizacion.unidades AS t3 ON t2.cod_unidad = t3.cod_unidad";
					$consulta = $consulta." WHERE t1.cod_producto = '".$row3["cod_producto"]."' AND t1.cod_subproducto = '".$row3["cod_subproducto"]."'";
					$consulta = $consulta." AND t1.hornada = '".$row3["hornada"]."' AND t1.valor <> '' AND t1.cod_leyes IN ('02','04','05')";
					
					$rs4 = mysqli_query($link, $consulta);
									
					//Traspaso las leyes de cada hornada a un arreglo, para que mantengan la estructura de la tabla.					
					while ($row4 = mysqli_fetch_array($rs4))
					{	
						$det_leyes[$row4["cod_leyes"]][0] = ($row3["peso"] * $row4["valor"] / $det_leyes[$row4["cod_leyes"]][1]); //Si son Finos.
						
						//Se ingresan los totales de cada Ley (Pero son los Totales de Finos).
						$total_leyes[$row4["cod_leyes"]][0] = $total_leyes[$row4["cod_leyes"]][0] + ($row3["peso"] * $row4["valor"] / $det_leyes[$row4["cod_leyes"]][1]);

						//Se ingresa el peso, solo para las hornada, en la cual sus leyes tengan algun valor valor.
						$total_leyes[$row4["cod_leyes"]][2] = $row3["peso"] + $total_leyes[$row4["cod_leyes"]][2];						
					}										
				}
				
				$consulta = "SELECT SUM(unidades) AS unidades, SUM(peso) AS peso FROM sea_web.movimientos";
				$consulta = $consulta." WHERE tipo_movimiento = 2 AND fecha_movimiento BETWEEN '".$ano."-".$mes."-15' AND '".$ano."-".$mes."-31'";
				$consulta = $consulta." AND campo2 = '".$v."'";				
				$rs6 = mysqli_query($link, $consulta);
				
				if ($row6 = mysqli_fetch_array($rs6))
				{								
					echo '<tr>';					
					echo '<td width="50" align="center">'.$c.'</td>';
					echo '<td width="50" align="center">&nbsp;</td>';
					echo '<td width="80" align="center">'.$row6["unidades"].'</td>';
					echo '<td width="80" align="center">'.$row6["peso"].'</td>';
						
					//Escribe el arreglo de los totales.
					reset($total_leyes);
					//while (list($c1, $v1) = each($total_leyes))
					foreach($total_leyes as $c1=>$v1)
					{	
						if ($v1[2] == 0)
							echo '<td width="80" align="center">0,00</td>';
						else 
							echo '<td width="80" align="center">'.number_format(($v1[0] * $v1[1] / $v1[2]),2,",","").'</td>';
					}						
					
					echo '</tr>';
				}								
			}
			echo '</table>';

	?>
</body>
</html>
<?php include("../principal/cerrar_sea_web.php") ?>