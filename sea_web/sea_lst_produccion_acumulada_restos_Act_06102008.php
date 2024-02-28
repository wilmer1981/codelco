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
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr class="ColorTabla01">
    <td align="center">PRODUCCION ACUMULADA DE RESTOS</td>
  </tr>
  <tr class="ColorTabla02"> 
    <td align="center">PERIODO: <?php echo $dia_i.'/'.$mes_i.'/'.$ano_i ?> AL <?php echo $dia_t.'/'.$mes_t.'/'.$ano_t ?></td>
  </tr>
</table>
<br>
<table width="300" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr class="ColorTabla01">
<?php
	if ($radio2 == "L")
		echo '<td><center>LEYES</center></td>';
	else if ($radio2 == "F")
		echo '<td><center>FINOS</center></td>';
	else 
		echo '<td><center>PESOS</center></td>';
	
?>
  </tr>
</table>
<br>

<?php
	//$fecha_ini = $ano_i.'-'.$mes_i.'-'.$dia_i.' 00:00:00';
	//$fecha_ter = $ano_t.'-'.$mes_t.'-'.$dia_t.' 23:59:59';
	
	$fecha_ini =date("Y-m-d", mktime(1,0,0,$mes_i,$dia_i ,$ano_i));	
	$fecha_ter =date("Y-m-d", mktime(1,0,0,$mes_t,($dia_t +1),$ano_t));	
	
?>	

  </tr>
</table>
<br>

<?php
	$arreglo = array();
    $total_grupo = array();
	
	//LLENA UN ARREGLO CON LOS FLUJOS Y PRODUCTOS-SUBPRODUCTOS ASOCIADOS.
	//echo "cmborigen - " .$cmborigen; tiene 1

	if ($cmborigen == "T") //Todos los productos.
	{
		$consulta = "SELECT * FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_producto = 19 AND cod_proceso = 3";		
		if ($radio != "P")
			
			$consulta.= " AND cod_subproducto <> 30";
	}
	else
	{
		if ($radio == "P") //Radio Producto.
		{
			if ($cmbrestos == "T") //Todos los subproducto de un proveedor.
			{
				$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2002 AND cod_subclase = ".$cmborigen;
				$rs = mysqli_query($link, $consulta);
				$row = mysqli_fetch_array($rs);
				$codigos = $row["valor_subclase1"].",".$row[valor_subclase2].",".$row["valor_subclase3"];
			
				$consulta = "SELECT * FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_producto = 19 AND cod_proceso = 3";
				$consulta = $consulta." AND cod_subproducto in (".$codigos.")";
			}
			else
			{
				$consulta = "SELECT * FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_producto = 19 AND cod_proceso = 3 AND";
				$consulta = $consulta." cod_subproducto = ".$cmbrestos;
			}
		}
		else //Radio Flujo.
		{
				
				
			if ($cmbflujorestos == "T")
			{
				
				
				$consulta = "SELECT * FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 3 AND cod_origen = ".$cmborigen;
			    $consulta = $consulta." AND cod_subproducto <> 30";
				$consulta = $consulta." ORDER BY cod_origen";		
			}
			else 
			{
				$consulta = "SELECT * FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso = 3 AND flujo = ".$cmbflujorestos;
				$consulta = $consulta." AND cod_origen = ".$cmborigen;
				 $consulta = $consulta." AND cod_subproducto <> 30";
				$consulta = $consulta." ORDER BY cod_subproducto";		
			}
		}
	}
	
	//Ejecuta la consulta.
	$rs1 = mysqli_query($link, $consulta); 
	
	//Llena el arreglo con los flujos y subproductos; y el inicio de hornada en el caso de Ventanas(Representa al horno).
	while ($row1 = mysqli_fetch_array($rs1))
	{
		$arreglo[] = array($row1["flujo"], $row1["cod_producto"], $row1["cod_subproducto"]);
	}


	// Saca todos los movimientos de recepcion afectados.
	reset($arreglo);
	while (list($clave, $valor) = each($arreglo)) // (0: flujo, 1: cod_producto, 2: cod_subproducto, 3: horno_inicial)
	{
			$consulta_g = "SELECT distinct campo2 from sea_web.movimientos WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto =".$valor[2];
			$consulta_g = $consulta_g." AND campo2 != '' AND flujo = ".$valor[0]." AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' ";
			$consulta_g = $consulta_g." and hora between '".$fecha_ini." 08:00:00' and '".$fecha_ter." 07:59:59' ORDER BY campo2 ASC";		

			//$consulta_g = $consulta_g." AND campo2 != '' AND flujo = ".$valor[0]." AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'order by campo2 ASC ";
       		$rs_g = mysqli_query($link, $consulta_g);
			//echo "con".$consulta_g;
/*******/
      if($radio2 != "P")//radio peso 
	 {	
		//consulto las abreviaturas
		$consulta_6 = "SELECT DISTINCT t1.cod_leyes AS codigo, t2.abreviatura AS ab1, t3.abreviatura AS ab2, t3.conversion FROM sea_web.leyes_por_hornada AS t1";
		$consulta_6 = $consulta_6." INNER JOIN proyecto_modernizacion.leyes AS t2 ON t1.cod_leyes = t2.cod_leyes";
		$consulta_6 = $consulta_6." INNER JOIN proyecto_modernizacion.unidades AS t3 ON t1.cod_unidad = t3.cod_unidad";
		$consulta_6 = $consulta_6." WHERE t1.cod_producto = 17 AND t1.valor <> ''";
		$consulta_6 = $consulta_6." ORDER BY t2.orden_sea";
			
		$rs6 = mysqli_query($link, $consulta_6);
		
		$det_leyes = array(); //Detalles de las leyes por Flujo � Producto.
		$total_leyes = array(); //Totales de las leyes por Flujo � Producto.
		
		//Limpia el arreglo de los Totales de las Leyes.
		reset($total_leyes);
		while (list($c1, $v1) = each($total_leyes))
		{	
			$total_leyes[$c1][0] = 0; //Acumulador.				
		}
     }//
/********/
		
		if ($radio == "P")
		{
			$consulta = "SELECT * FROM sea_web.movimientos WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto = ".$valor[2];
			$consulta = $consulta." AND flujo = ".$valor[0]." AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
			$consulta = $consulta." and hora between '".$fecha_ini." 08:00:00' and '".$fecha_ter." 07:59:59'";		
			$consulta = $consulta." ORDER BY hornada";
		}		
		else
		{
			$consulta = "SELECT * FROM sea_web.movimientos WHERE tipo_movimiento = 3 AND cod_producto = 19";
			$consulta = $consulta." AND flujo = ".$valor[0]." AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
			$consulta = $consulta." and hora between '".$fecha_ini." 08:00:00' and '".$fecha_ter." 07:59:59'";		
			$consulta = $consulta." ORDER BY hornada";	
		}	
		$rs1 = mysqli_query($link, $consulta);

	 //Si hay movimientos escribe el Producto � Flujo.
 	 if (mysqli_num_rows($rs1) != 0) //Si la Consulta devuelve datos.
	 {
			echo '<table width="320" border="0" cellspacing="0" cellpadding="0" align="center" class="ColorTabla01">';
			echo '<tr><td align="center">';
			
			if ($radio == "P") //Producto	
			{		
				$consulta = "SELECT descripcion AS nombre FROM proyecto_modernizacion.subproducto WHERE cod_producto = 19 AND cod_subproducto = ".$valor[2];
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

			$largo = 175; //Largo de la Tabla.
		
		 if($radio2 != "P")//radio peso 
		 {	
			$largo = $largo + (40 * (mysqli_num_rows($rs6) - 3));
			if ($radio2 == "L")
				$largo = $largo + 120;
			else 
				$largo = $largo + 180;
		 }//
		 	
			echo '<table width="'.$largo.'" border="1" cellspacing="0" cellpadding="0" align="center" class="ColorTabla01"><tr>';
			echo '<td width="30" align="center">Dia </td>';
			echo '<td width="45" align="center">Horn.</td>';
			echo '<td width="35" align="center">Cant.</td>';
			echo '<td width="65" align="center">Peso<br>Kgs.</td>';

		 if($radio2 != "P")//radio peso 
		 {	
			while ($row6 = mysqli_fetch_array($rs6))
			{
				if (($radio2 == "F") and (($row6[codigo] == '02') or ($row6[codigo] == '04') or ($row6[codigo] == '05')))
					echo '<td width="60" align="center">'.$row6[ab1].'<br>'.$row6[ab2].'</td>';
				else 
					echo '<td width="40" align="center">'.$row6[ab1].'<br>'.$row6[ab2].'</td>';
					
				$det_leyes[$row6[codigo]][0] = 0; //ley.
				$det_leyes[$row6[codigo]][1] = $row6[conversion]; //unidad de conversion.
				
				$total_grupo[$row6[codigo]][0] = 0;
				$total_grupo[$row6[codigo]][1] = $row6[conversion]; //unidad de conversion.
				
				$total_leyes[$row6[codigo]][0] = 0; //Acumulador por cada Ley.
				$total_leyes[$row6[codigo]][1] = $row6[conversion]; //unidad de conversion.
			}
         }//			
 			 echo '</tr></table><br>';					 	

			
     }		

	 //Ciclo Grupos.
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
	  }//
	 
 	        $grupo = $fila['campo2'];
		
			
			if ($radio == "P")
			{
				$consulta = "SELECT distinct hornada, cod_producto,cod_subproducto FROM movimientos";
				$consulta = $consulta." WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto = ".$valor[2]." AND flujo = ".$valor[0];
				$consulta = $consulta." AND campo2=".$grupo." AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";		
				$consulta = $consulta." and hora between '".$fecha_ini." 08:00:00' and '".$fecha_ter." 07:59:59'";		

				$consulta = $consulta." ORDER BY hornada";
			}
			else
			{
				$consulta = "SELECT distinct hornada, cod_producto,cod_subproducto FROM movimientos";
				$consulta = $consulta." WHERE tipo_movimiento = 3 AND cod_producto = 19  and cod_subproducto != 30 AND flujo = ".$valor[0];
				$consulta = $consulta." AND campo2=".$grupo." AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";		
				$consulta = $consulta." and hora between '".$fecha_ini." 08:00:00' and '".$fecha_ter." 07:59:59'";		

				$consulta = $consulta." ORDER BY hornada";
			}
			
			$rs2 = mysqli_query($link, $consulta);				

		if (mysqli_num_rows($rs2) != 0) //Si la Consulta devuelve datos.
		{
	
			//escribe el Grupo.
			echo '<table width="164" border="0" cellspacing="0" cellpadding="0" align="center" class="ColorTabla01">';
			echo '<tr><td align="center">Grupo '.$grupo.'</td>';
			echo '</tr></table>';																

			//Crea el detalle.					
			echo '<table width="'.$largo.'" border="0" cellspacing="0" cellpadding="0" align="center">'; 
			while ($row2 = mysqli_fetch_array($rs2))
			{												  


				if ($radio == "P")
				{
					$consulta = "SELECT * FROM movimientos";
					$consulta = $consulta." WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto = ".$valor[2]." AND flujo = ".$valor[0];
					$consulta = $consulta." AND campo2=".$grupo." AND hornada = $row2[hornada] AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
					$consulta = $consulta." and hora between '".$fecha_ini." 08:00:00' and '".$fecha_ter." 07:59:59'";		

				}
				else
				{
					$consulta = "SELECT * FROM movimientos";
					$consulta = $consulta." WHERE tipo_movimiento = 3 AND cod_producto = 19 AND flujo = ".$valor[0];
					$consulta = $consulta." AND campo2=".$grupo." AND hornada = $row2[hornada] AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
					$consulta = $consulta." and hora between '".$fecha_ini." 08:00:00' and '".$fecha_ter." 07:59:59'";		

				}
				
				$rs_f = mysqli_query($link, $consulta);
				if($row_f = mysqli_fetch_array($rs_f))
				{ 
					$fecha_movimiento = $row_f[fecha_movimiento];	
				}

			    echo '<tr class="ColorTabla02"><td width="30">'.substr($fecha_movimiento,8,2).'</td>';
			    echo '<td width="45" align="center">'.substr($row2[hornada],6,6).'</td>';
			    echo '<td width="35" align="right">';

				if ($radio == "P")
				{
					$consulta = "SELECT SUM(unidades) as unidades FROM movimientos";
					$consulta = $consulta." WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto = ".$valor[2]." AND flujo = ".$valor[0];
					$consulta = $consulta." AND campo2=".$grupo." AND hornada = $row2[hornada] AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
					$consulta = $consulta." and hora between '".$fecha_ini." 08:00:00' and '".$fecha_ter." 07:59:59'";		

				}               
				else
				{
					$consulta = "SELECT SUM(unidades) as unidades FROM movimientos";
					$consulta = $consulta." WHERE tipo_movimiento = 3 AND cod_producto = 19 and cod_subproducto != 30 AND flujo = ".$valor[0];
					$consulta = $consulta." AND campo2=".$grupo." AND hornada = $row2[hornada] AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
					$consulta = $consulta." and hora between '".$fecha_ini." 08:00:00' and '".$fecha_ter." 07:59:59'";		

				}
			    $rs_u = mysqli_query($link, $consulta);
				if($row_u = mysqli_fetch_array($rs_u))
				{ 
					echo $row_u["unidades"].'</td>';
                }

			    echo '<td width="65" align="right">';

				if ($radio == "P")
				{
					$consulta = "SELECT SUM(peso) as peso FROM movimientos";
					$consulta = $consulta." WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto = ".$valor[2]." AND flujo = ".$valor[0];
					$consulta = $consulta." AND campo2=".$grupo." AND hornada = $row2[hornada] AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
					$consulta = $consulta." and hora between '".$fecha_ini." 08:00:00' and '".$fecha_ter." 07:59:59'";		

				}
				else
				{
					$consulta = "SELECT SUM(peso) as peso FROM movimientos";
					$consulta = $consulta." WHERE tipo_movimiento = 3 AND cod_producto = 19 and cod_subproducto != 30 AND flujo = ".$valor[0];
					$consulta = $consulta." AND campo2=".$grupo." AND hornada = $row2[hornada] AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
					$consulta = $consulta." and hora between '".$fecha_ini." 08:00:00' and '".$fecha_ter." 07:59:59'";		

				}
				//echo $consulta."<br>";
                $rs_p = mysqli_query($link, $consulta);
				if($row_p = mysqli_fetch_array($rs_p))
				{ 
					echo $row_p["peso"].'</td>';
				}

			 if($radio2 != "P")//radio peso 
			 {	
				//Consulta las Leyes en Control de Calidad

				if ($radio == "P") //Producto
				{
					$consulta = "SELECT t1.valor, t1.cod_leyes FROM sea_web.leyes_por_hornada AS t1";
					$consulta = $consulta." INNER JOIN proyecto_modernizacion.leyes AS t2 ON t1.cod_leyes = t2.cod_leyes";
					$consulta = $consulta." INNER JOIN proyecto_modernizacion.unidades AS t3 ON t2.cod_unidad = t3.cod_unidad";
					$consulta = $consulta." WHERE t1.cod_producto = 19  AND t1.cod_subproducto = ".$row2["cod_subproducto"];
					$consulta = $consulta." AND t1.hornada = ".$row2[hornada]." AND t1.valor <> ''";
				}
				else
				{
					
					
					$consulta = "SELECT t1.valor, t1.cod_leyes FROM sea_web.leyes_por_hornada AS t1";
					$consulta = $consulta." INNER JOIN proyecto_modernizacion.leyes AS t2 ON t1.cod_leyes = t2.cod_leyes";
					$consulta = $consulta." INNER JOIN proyecto_modernizacion.unidades AS t3 ON t2.cod_unidad = t3.cod_unidad";
					$consulta = $consulta." WHERE t1.cod_producto = 19";
					$consulta = $consulta." AND t1.hornada = ".$row2[hornada]." AND t1.valor <> ''";
				
				}
                //echo $consulta; 		
				
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
						$det_leyes[$row5["cod_leyes"]][0] = ($row_p["peso"] * $row5["valor"] / $det_leyes[$row5["cod_leyes"]][1]); //Si son Finos.
						
					//Se ingresan los totales de cada Ley.
					$total_grupo[$row5["cod_leyes"]][0] = $total_grupo[$row5["cod_leyes"]][0] + ($row_p["peso"] * $row5["valor"] / $det_leyes[$row5["cod_leyes"]][1]);

					$total_leyes[$row5["cod_leyes"]][0] = $total_leyes[$row5["cod_leyes"]][0] + ($row_p["peso"] * $row5["valor"] / $det_leyes[$row5["cod_leyes"]][1]);
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
			 }//	
				echo '</tr>';
		  }
			echo '</table><br>';
	
		}	
		
    }	
			if(mysqli_num_rows($rs1) != 0) //Si la Consulta devuelve datos.
		{


/*			//Saca los totales para el flujo					
			$consulta = "SELECT SUM(unidades) AS unid, SUM(peso) AS peso FROM movimientos WHERE tipo_movimiento = 3 AND cod_producto = 19 AND"; 
			$consulta = $consulta." cod_subproducto = ".$valor[2]." AND flujo = ".$valor[0];
			$consulta = $consulta." AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'"; 
*/

			if ($radio == "P") //Producto
			{			
				$consulta = "SELECT SUM(unidades) AS unid, SUM(peso) AS peso";
				$consulta = $consulta." FROM sea_web.movimientos ";
				$consulta = $consulta." WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto = ".$valor[2]." AND flujo = ".$valor[0];
				$consulta = $consulta." AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
				$consulta = $consulta." and hora between '".$fecha_ini." 08:00:00' and '".$fecha_ter." 07:59:59'";		

			}
			else
			{
				$consulta = "SELECT SUM(unidades) AS unid, SUM(peso) AS peso";
				$consulta = $consulta." FROM sea_web.movimientos ";
				$consulta = $consulta." WHERE tipo_movimiento = 3 AND cod_producto = 19 and cod_subproducto != 30 AND flujo = ".$valor[0];
				$consulta = $consulta." AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
				$consulta = $consulta." and hora between '".$fecha_ini." 08:00:00' and '".$fecha_ter." 07:59:59'";		

			}			
			$rs3 = mysqli_query($link, $consulta);

			echo '<table width="'.$largo.'" border="0" cellspacing="0" cellpadding="0" align="center" class="Detalle02">';
           	echo '<tr><td width="80">'; 

     		if ($radio == "P")
		        echo 'Total Prod.</td>';
			else
				echo 'Total Flujo</td>';
			
			$row3 = mysqli_fetch_array($rs3);
			if (!is_null($row3[unid]))					
			{  
                echo '<td width="35" align="right">'.$row3[unid].'</td>';				
                echo '<td width="65" align="right">'.number_format($row3["peso"],0,'','').'</td>';
				
			  if($radio2 != "P")// radio peso
			  {
				//Genero las columnas con los totales de las Leyes.
				reset($total_leyes);
				while (list($c1, $v1) = each($total_leyes))
				{
					if ($radio2 == "L") //Leyes.
					{
						if ($v1[1] == 0)
							echo '<td width="45" align="right">0</td>';
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
							echo '<td width="60" align="right">'.number_format($v1[0],0,"","").'</td>';
						else 
							echo '<td width="40" align="right">'.number_format($v1[0],0,"","").'</td>';
					}
				}				
              }//			
            } 

     		echo '</tr></table><br>';
      }					
	
}
	
?>	

<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
	<td align="center"><input name="btnimprimir" type="button" value="Imprimir" style="width:70;" onClick="JavaScript:Imprimir()">
      <input name="btnsalir" type="button" style="width:70;" onClick="JavaScript:Salir()" value="Salir"></td>
  </tr>
</table>

</body>
</html>
<?php include("../principal/cerrar_sea_web.php") ?>