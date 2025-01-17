<?php 
	ob_end_clean();
	$file_name=basename($_SERVER['PHP_SELF']).".xls";
	$userBrowser = $_SERVER['HTTP_USER_AGENT'];
	$filename = "";
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
	
	$Proceso       = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$listados      = isset($_REQUEST["listados"])?$_REQUEST["listados"]:"";
	$cmbmovimiento = isset($_REQUEST["cmbmovimiento"])?$_REQUEST["cmbmovimiento"]:"";
	$cmblistados   = isset($_REQUEST["cmblistados"])?$_REQUEST["cmblistados"]:"";
	$cmborigen = isset($_REQUEST["cmborigen"])?$_REQUEST["cmborigen"]:"";
	$cmbrestos = isset($_REQUEST["cmbrestos"])?$_REQUEST["cmbrestos"]:"";
	$cmbanodos = isset($_REQUEST["cmbanodos"])?$_REQUEST["cmbanodos"]:"";
	$radio = isset($_REQUEST["radio"])?$_REQUEST["radio"]:"";
	$radio2= isset($_REQUEST["radio2"])?$_REQUEST["radio2"]:"";
	
	$dia_i = isset($_REQUEST["dia_i"])?$_REQUEST["dia_i"]:date("d");
    $mes_i = isset($_REQUEST["mes_i"])?$_REQUEST["mes_i"]:date("m");
	$ano_i = isset($_REQUEST["ano_i"])?$_REQUEST["ano_i"]:date("Y");
	
	$dia_t = isset($_REQUEST["dia_t"])?$_REQUEST["dia_t"]:date("d");
    $mes_t = isset($_REQUEST["mes_t"])?$_REQUEST["mes_t"]:date("m");
	$ano_t = isset($_REQUEST["ano_t"])?$_REQUEST["ano_t"]:date("Y");
 ?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
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
    <td align="center" colspan="4">BENEFICIO TOTAL ANODOS ACUMULADOS</td>
  </tr>
  <tr> 
    <td align="center" colspan="4">PERIODO: <?php echo $dia_i.'/'.$mes_i.'/'.$ano_i ?> AL <?php echo $dia_t.'/'.$mes_t.'/'.$ano_t ?></td>
  </tr>
</table>
<br>
<table width="320" border="0" cellpadding="0" cellspacing="0" align="center" class="ColorTabla01">
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
		
	$fecha_ini = $ano_i.'-'.$mes_i.'-'.$dia_i; //.' 00:00:00';
	$fecha_ter = $ano_t.'-'.$mes_t.'-'.$dia_t; //.' 23:59:59';

	$largo = 80 * 4; //Largo de la Tabla

	if ($radio2 != "P")
	{
		$consulta = "SELECT DISTINCT t1.cod_leyes AS codigo, t2.abreviatura AS ab1, t3.abreviatura AS ab2, t3.conversion FROM sea_web.leyes_por_hornada AS t1";
		$consulta = $consulta." INNER JOIN proyecto_modernizacion.leyes AS t2 ON t1.cod_leyes = t2.cod_leyes";
		$consulta = $consulta." INNER JOIN proyecto_modernizacion.unidades AS t3 ON t1.cod_unidad = t3.cod_unidad";
		$consulta = $consulta." WHERE t1.valor <> '' AND t1.cod_producto = 17";		
		$consulta = $consulta." ORDER BY t2.orden_sea";
		
		$rs4 = mysqli_query($link,$consulta);
		
		if (mysqli_num_rows($rs4) <> 0)
			$largo = $largo + (70 * mysqli_num_rows($rs4));
	}
	
	echo '<table width="'.$largo.'"  border="0" cellspacing="0" cellpadding="0" align="center" class="ColorTabla01"><tr>';
    echo '<td width="80" align="center">DIA </td>';
    echo '<td width="80" align="center">N&deg; HORNADA</td>';
    echo '<td width="80" align="center">CANT.</td>';
    echo '<td width="80" align="center">PESO<br>KGS.</td>';
	
	$det_leyes = array(); //Detalles de las leyes por Flujo ó Producto.
	$total_dia = array(); //Totales de las por Dia.
	$total_leyes = array(); //Totales de las leyes por Flujo ó Producto.	

	if ($radio2 != "P")
	{
		while ($row4 = mysqli_fetch_array($rs4))
		{
			echo '<td width="70" align="center">'.$row4["ab1"].'<br>'.$row4["ab2"].'</td>';
			$det_leyes[$row4["codigo"]][0] = 0; //ley.
			$det_leyes[$row4["codigo"]][1] = $row4["conversion"]; //unidad de conversion.
			
			$total_dia[$row4["codigo"]][0] = 0; //Valor Ley
			$total_dia[$row4["codigo"]][1] = $row4["conversion"]; //Unidad de conversion.
			
			$total_leyes[$row4["codigo"]][0] = 0; //Acumulador por cada Ley.
			$total_leyes[$row4["codigo"]][1] = $row4["conversion"]; //Unidad de conversion.		
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
		$consulta = "SELECT * FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso in (2,4)";	
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
					$consulta = $consulta." AND cod_subproducto = ".$cmbrestos.")";
				 }
			else if (($cmbanodos != "T") and ($cmbrestos == "T"))
				 {
				 	$consulta = "SELECT * FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_origen = ".$cmborigen;
					$consulta = $consulta." AND cod_proceso = 2 AND cod_subproducto = ".$cmbanodos;
				 }
			else if (($cmbanodos != "T") and ($cmbrestos != "T"))
				 {
				 	$consulta = "SELECT * FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_origen = ".$cmborigen." AND cod_proceso = 2 ";
					$consulta = $consulta." AND cod_subproducto = ".$cmbanodos;
				 }
		}													
		else //Radio Flujo
		{
			if (($cmbflujo == "T") and ($cmbflujorestos == "T"))
			{
				$consulta = "SELECT * FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_proceso in (2,4) AND cod_origen = ".$cmborigen;
			}
			else if (($cmbflujo == "T") and ($cmbflujorestos != "T"))				 
				 {
				 	$consulta = "SELECT * FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_origen = ".$cmborigen." AND (cod_proceso = 2 OR ";
					$consulta = $consulta."(cod_proceso = 4 AND flujo = ".$cmbflujorestos."))";				 
				 }	 
			else if (($cmbflujo != "T") and ($cmbflujorestos == "T"))
				 {
					$consulta = "SELECT * FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_origen = ".$cmborigen." AND (cod_proceso = 4 OR ";
					$consulta = $consulta."(cod_proceso = 2 AND flujo = ".$cmbflujo."))";				 	
				 }
			else if (($cmbflujo != "T") and ($cmbflujorestos != "T"))
				 {
				 	$consulta = "SELECT * FROM proyecto_modernizacion.relacion_prod_flujo_nodo WHERE cod_origen = ".$cmborigen." AND ((cod_proceso = 2 AND";
					$consulta = $consulta." flujo = ".$cmbflujo.") OR (cod_proceso = 4 AND flujo = ".$cmbflujorestos."))";
				 }
		}
	}		
		
	$consulta = $consulta." ORDER BY flujo";		

	//Ejecuta la consulta.
	$rs1 = mysqli_query($link,$consulta); 
	
	//Llena el arreglo con los flujos y subproductos; y el inicio de hornada en el caso de Ventanas(Representa al horno).
	while ($row1 = mysqli_fetch_array($rs1))
	{
		$arreglo[] = array($row1["flujo"], $row1["cod_producto"], $row1["cod_subproducto"], $row1["cod_proceso"]);
	}


	// Saca todos los movimientos de recepcion afectados.
	reset($arreglo);
	// (0: flujo, 1: cod_producto, 2: cod_subproducto, 3: cod_proceso)
	foreach($arreglo as $clave => $valor)
	{
		//Limpia el arreglo de los Totales de las Leyes.
		reset($total_leyes);
		foreach($total_leyes as $c1 => $v1)
		{	
			$total_leyes[$c1][0] = 0; //Acumulador.				
		}
		
		$consulta = "SELECT * FROM sea_web.movimientos WHERE tipo_movimiento = 2 AND cod_producto = ".$valor[1];
		$consulta = $consulta." AND cod_subproducto = ".$valor[2]." AND flujo = ".$valor[0];
		$consulta = $consulta." AND ((fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."')";
		$consulta = $consulta." OR (fecha_benef BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'))";		
		$rs8 = mysqli_query($link,$consulta);

		if (mysqli_num_rows($rs8) != 0) //Si existen datos escribir flujo.
		{
			$row8 = mysqli_fetch_array($rs8);
			
			//Si hay movimientos escribe el Producto ó Flujo.
			echo '<table width="320" border="0" cellspacing="0" cellpadding="0" align="center" class="ColorTabla01">';
			echo '<tr><td align="center" colspan="4">';
		
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
			
			$rs4 = mysqli_query($link,$consulta);
						
			if ($row4 = mysqli_fetch_array($rs4))
				echo $row4["nombre"];									
			echo '</td></tr></table><br>';
		
						
			$fecha_aux = $fecha_ini;
			while (date($fecha_aux) <= date($fecha_ter)) //Recorre los dias.
			{
				//Limpia el arreglo de los Totales por Dia de las Leyes.
				reset($total_dia);
				foreach($total_dia as $c1 => $v1)
				{	
					$total_dia[$c1][0] = 0; //Acumulador.				
				}		

				$consulta = "SELECT distinct hornada,cod_producto,cod_subproducto,";
				$consulta = $consulta."CASE WHEN fecha_benef <> '0000-00-00' THEN 'D' ELSE 'N' END AS tipo_reg";
				$consulta = $consulta." FROM sea_web.movimientos";
				$consulta = $consulta." WHERE tipo_movimiento = 2 AND cod_producto = ".$valor[1];
				$consulta = $consulta." AND cod_subproducto = ".$valor[2]." AND flujo = ".$valor[0];
				$consulta = $consulta." AND ((fecha_movimiento = '".$fecha_aux."' AND fecha_benef = '0000-00-00')";
				$consulta = $consulta." OR (fecha_benef = '".$fecha_aux."'))";
				$consulta = $consulta." ORDER BY hornada";				
							
				$rs2 = mysqli_query($link,$consulta);
	
				if (mysqli_num_rows($rs2) != 0) //Si la Consulta devuelve datos.
				{	
					//Crea el detalle.					
					echo '<table width="'.$largo.'" border="1" cellspacing="0" cellpadding="0" align="center" class="ColorTabla02">'; 
					while ($row2 = mysqli_fetch_array($rs2))
					{												  
						echo '<tr><td width="80">'.$fecha_aux.'</td>';
						echo '<td width="80 "align="center">'.substr($row2["hornada"],6,6).'</td>';
						echo '<td width="80" align="center">';				
						
						$consulta = "SELECT SUM(unidades) as unidades,SUM(peso) as peso";	
						$consulta = $consulta." FROM sea_web.movimientos";
						$consulta = $consulta." WHERE tipo_movimiento = 2 AND cod_producto = ".$valor[1]." AND cod_subproducto = ".$valor[2]." AND flujo = ".$valor[0];
						$consulta = $consulta." AND hornada='".$row2["hornada"]."' AND ";
						if ($row2["tipo_reg"] == "N")
					 		$consulta = $consulta." fecha_movimiento = '".$fecha_aux."'";
						else 
							$consulta = $consulta." fecha_benef = '".$fecha_aux."'";
							
						$consulta = $consulta." ORDER BY hornada";
						$rs_p = mysqli_query($link,$consulta);
						if($row_p = mysqli_fetch_array($rs_p))
						{
							$unidades = $row_p["unidades"];				
							$peso = $row_p["peso"];				
						}

						echo $unidades.'</td>';
						echo '<td width="80" align="center">';
						echo $peso.'</td>';
					
						if ($radio2 != "P")
						{
							//Limpio el arreglo.
							reset($det_leyes);
							foreach($det_leyes as $c1 => $v1)
							{	
								$det_leyes[$c1][0] = 0;
							}
																
							//Consulta las Leyes en Control de Calidad
							$consulta = "SELECT t1.valor, t1.cod_leyes FROM sea_web.leyes_por_hornada AS t1";
							$consulta = $consulta." INNER JOIN proyecto_modernizacion.leyes AS t2 ON t1.cod_leyes = t2.cod_leyes";
							$consulta = $consulta." INNER JOIN proyecto_modernizacion.unidades AS t3 ON t2.cod_unidad = t3.cod_unidad";
							$consulta = $consulta." WHERE t1.cod_producto = ".$valor[1]." AND t1.cod_subproducto = ".$valor[2];
							$consulta = $consulta." AND t1.hornada = ".$row2["hornada"]." AND t1.valor <> ''";
						
							$rs5 = mysqli_query($link,$consulta);
																		
							//Traspaso las leyes de cada hornada a un arreglo, para que mantengan la estructura de la tabla.
							while ($row5 = mysqli_fetch_array($rs5))
							{
								if ($radio2 == "L") //Si son Leyes
									$det_leyes[$row5["cod_leyes"]][0] = $row5["valor"];
								else 
									$det_leyes[$row5["cod_leyes"]][0] = ($peso * $row5["valor"] / $det_leyes[$row5["cod_leyes"]][1]); //Si son Finos.
								//echo $det_leyes[$row5["cod_leyes"]][0]."<br>";
								
								//Se ingresan los totales de cada Ley. (Por Dia)
								$total_dia[$row5["cod_leyes"]][0] = $total_dia[$row5["cod_leyes"]][0] + ($peso * $row5["valor"] / $det_leyes[$row5["cod_leyes"]][1]);
								
								//Se ingresan los totales de cada Ley. (Por Flujo)
								$total_leyes[$row5["cod_leyes"]][0] = $total_leyes[$row5["cod_leyes"]][0] + ($peso * $row5["valor"] / $det_leyes[$row5["cod_leyes"]][1]);							
							}																	
						}
								
						//Genero las columnas de leyes que estan en el arreglo.
						reset($det_leyes);
						foreach($det_leyes as $c1 => $v1)
						{
							if (($c1 == '02') or ($c1 == '05'))
								echo '<td width="70" align="right">'.number_format($v1[0],2,",","").'</td>';
							else
								echo '<td width="70" align="right">'.number_format($v1[0],1,",","").'</td>';
						}						    
						echo '</tr>';				
					}				
					echo '</table><br>';
																									
					//*** TOTAL POR DIA ***//
					$consulta = "SELECT SUM(unidades) AS unid, SUM(peso) AS peso";
					$consulta = $consulta." FROM sea_web.movimientos";
					$consulta = $consulta." WHERE tipo_movimiento = 2 AND cod_producto = ".$valor[1];
					$consulta = $consulta." AND cod_subproducto = ".$valor[2]." AND flujo = ".$valor[0];
					$consulta = $consulta." AND ((fecha_movimiento = '".$fecha_aux."' AND fecha_benef = '0000-00-00')";
					$consulta = $consulta." OR (fecha_benef = '".$fecha_aux."'))";					
	
					$rs7 = mysqli_query($link,$consulta);	
					$row7 = mysqli_fetch_array($rs7);
					
					echo '<table width="'.$largo.'" border="1" cellspacing="0" cellpadding="0" align="center" class="Detalle02">'; 				
					echo '<tr><td width="160" colspan="2">SUBTOTAL DIA</td>'; 
					echo '<td width="80" align="center">';
					echo $row7["unid"].'</td>';
					echo '<td width="80" align="center">';
					echo $row7["peso"].'</td>';
					
					//Genero las columnas de leyes que estan en el arreglo.
					reset($total_dia);
					foreach($total_dia as $c1 => $v1)
					{
						if ($radio2 == "L") //Leyes.
						{
							if ($v1[1] == 0)
								echo '<td width="70">0</td>';
							else
							{
								if (($c1 == '02') or ($c1 == '05'))
									echo '<td width="70" align="right">'.number_format(($v1[0] * $v1[1] / $row7["peso"]),2,",","").'</td>';
								else
									echo '<td width="70" align="right">'.number_format(($v1[0] * $v1[1] / $row7["peso"]),1,",","").'</td>';
							}
						}
						else //Finos.
						{
							echo '<td width="70" align="right">'.number_format($v1[0],0,"","").'</td>';
						}
					}						    				
					echo '</tr></table><br>';
					
																
				}
				//Incrementa la fecha en 1 Dia.
				$vector = explode("-",$fecha_aux); //0: ano, 1: mes, 2: dia.			
				$fecha_aux = date("Y-m-d",mktime(1,0,0,$vector[1],($vector[2]+1),$vector[0]));
			}
			//TOTALES POR FLUJO
			$consulta = "SELECT SUM(unidades) AS unid, SUM(peso) AS peso";
			$consulta = $consulta." FROM sea_web.movimientos";
			$consulta = $consulta." WHERE tipo_movimiento = 2 AND cod_producto = ".$valor[1];
			$consulta = $consulta." AND cod_subproducto = ".$valor[2]." AND flujo = ".$valor[0];
			$consulta = $consulta." AND ((fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."')";
			$consulta = $consulta." OR (fecha_benef BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'))";			
			
			$rs3 = mysqli_query($link,$consulta);
			
			echo '<table width="'.$largo.'" border="1" cellspacing="0" cellpadding="0" align="center" class="Detalle02">';
           	echo '<tr><td width="160" colspan="2">'; 
     		if ($radio == "P")
		        echo 'TOTAL PRODUCTO</td>';
			else
				echo 'TOTAL FLUJO</td>';
			
			$row3 = mysqli_fetch_array($rs3);
			if (!is_null($row3["unid"]))					
			{  
                echo '<td width="80" align="center">';
				echo $row3["unid"].'</td>';				
                echo '<td width="80" align="center">';
				echo $row3["peso"].'</td>';
			
				//Genero las columnas con los totales de las Leyes.
				reset($total_leyes);
				foreach($total_leyes as $c1 => $v1)
				{
					if ($radio2 == "L") //Leyes.
					{
						if ($v1[1] == 0)
							echo '<td width="70">0</td>';
						else
							if (($c1 == '02') or ($c1 == '05'))
								echo '<td width="70" align="right">'.number_format(($v1[0] * $v1[1] / $row3["peso"]),2,",","").'</td>';
							else
								echo '<td width="70" align="right">'.number_format(($v1[0] * $v1[1] / $row3["peso"]),1,",","").'</td>';
					}
					else //Finos.
					{
						echo '<td width="70" align="right">'.number_format($v1[0],0,"","").'</td>';
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