<?php
 include("../principal/conectar_ram_web.php"); 

 $ano        = isset($_REQUEST["ano"])?$_REQUEST["ano"]:date("Y");
$mes        = isset($_REQUEST["mes"])?$_REQUEST["mes"]:date("m");
$dia        = isset($_REQUEST["dia"])?$_REQUEST["dia"]:date("d");
?>
<html>

<head>
    <title>Movimientos Mezcla</title>
    <script language="JavaScript">
    function Salir() {
        window.history.back();
    }
    /***********/
    function Imprimir() {
        window.print();
    }
    </script>
    <link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
</head>

<body class="TablaPrincipal">
    <table width="320" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr class="ColorTabla01">
            <td align="center" colspan="10">INFORME MOVIMIENTO DE MEZCLAS</td>
        </tr>
        <tr class="ColorTabla02">
            <td align="center" colspan="10">FECHA: <?php echo $dia.'/'.$mes.'/'.$ano ?></td>
        </tr>
    </table>
    <br>

    <?php
	if(strlen($dia) == 1)
		$dia = '0'.$dia;
	
	if(strlen($mes) == 1)
		$mes = '0'.$mes;
			
	$fecha_ini = $ano.'-'.$mes.'-'.$dia.' 08:00:00';
	$fecha_ter = date("Y-m-d",mktime(7,59,59,$mes,($dia + 1),$ano))." 07:59:59";	

	$consulta = "SELECT distinct CONJUNTO_DESTINO FROM ram_web.movimiento_conjunto WHERE FECHA_MOVIMIENTO BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' AND cod_conjunto_destino = 2 order by CONJUNTO_DESTINO ASC ";
	$rs = mysqli_query($link, $consulta);
	//echo $consulta;
	while($row = mysqli_fetch_array($rs))
	{
		echo '<table width="300" border="0" cellspacing="0" cellpadding="0" align="center">';
		echo'<tr class="ColorTabla02">';
		echo '<td width="20%" align="center"><strong>MEZCLA :</strong></td>';

		$consulta = "SELECT * FROM ram_web.conjunto_ram WHERE num_conjunto = '".$row["CONJUNTO_DESTINO"]."'";
		$rs2 = mysqli_query($link, $consulta);
		
		if($row2 = mysqli_fetch_array($rs2))
		{
			echo '<td width="80%">'.$row2["num_conjunto"].' - '.$row2["descripcion"].'</td>';
		}
		echo '</tr></table>';

		echo '<table width="650"  border="0" cellspacing="0" cellpadding="0" align="center">';
		echo'<tr class="ColorTabla01">';
		echo '<td width="10%" align="center">COD.</td>';
		echo '<td width="27%" align="center">CONJ. ORIGEN</td>';
		echo '<td width="20%" align="center">FECHA MOVIMIENTO</td>';
		echo '<td width="10%"align="center">P. HUMEDO</td>';
		echo '<td width="10%"align="center">VALIDACIÓN</td>';
		echo '<td width="10%" align="center">P. TOTAL</td>';
		echo '</tr>';

		$consulta = "SELECT COD_EXISTENCIA,COD_CONJUNTO,NUM_CONJUNTO,FECHA_MOVIMIENTO,PESO_HUMEDO_MOVIDO,ESTADO_VALIDACION FROM movimiento_conjunto
		 WHERE FECHA_MOVIMIENTO BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' AND CONJUNTO_DESTINO = '".$row2["num_conjunto"]."' AND cod_conjunto_destino = 2 ORDER BY FECHA_MOVIMIENTO";
		$rs3 = mysqli_query($link, $consulta);
		//echo $consulta."<br>";		            
		while ($row3 = mysqli_fetch_array($rs3))
		{												  

		    	echo '<tr><td width="8%">'.$row3["COD_CONJUNTO"].' - '.$row3["NUM_CONJUNTO"].'</td>';

				$consulta = "SELECT * FROM conjunto_ram where cod_conjunto = '".$row3["COD_CONJUNTO"]."' AND num_conjunto = '".$row3["NUM_CONJUNTO"]."'"; 
				$rs5 = mysqli_query($link, $consulta);
	
				if($row5 = mysqli_fetch_array($rs5))
				{
	 			    	echo '<td width="22%">'.$row5["descripcion"].'</td>';
				}


/*				$consulta = "SELECT nombre_existencia FROM atributo_existencia where cod_existencia = $row3[COD_EXISTENCIA]"; 
				$rs6 = mysqli_query($link, $consulta);
				if($row6 = mysqli_fetch_array($rs6))
				{
	 			    	echo '<td width="10%" align="center">'.$row6[nombre_existencia].'</td>';
				}
*/
				echo '<td width="20%" align="center">'.$row3["FECHA_MOVIMIENTO"].'</td>';
				echo '<td width="10%" align="right">'.number_format($row3["PESO_HUMEDO_MOVIDO"]/1000,3,",","").'</td>';
				$validacion = $row3["ESTADO_VALIDACION"];
				echo '<td width="10%" align="right">'.number_format($validacion/1000,3,",","").'</td>';
				$Total = $row3["PESO_HUMEDO_MOVIDO"] + $validacion;
				echo '<td width="10%" align="right">'.number_format($Total/1000,3,",","").'</td>';
				
		}
     	echo '</tr>';
		
		$consulta = "SELECT SUM(PESO_HUMEDO_MOVIDO) AS Total_Humedo FROM movimiento_conjunto WHERE FECHA_MOVIMIENTO BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' AND CONJUNTO_DESTINO = '".$row["CONJUNTO_DESTINO"]."'";
		$rs7 = mysqli_query($link, $consulta);

		if($row7 = mysqli_fetch_array($rs7))
		{
			$Total_Humedo = $row7["Total_Humedo"];
		}

		$consulta = "SELECT SUM(ESTADO_VALIDACION) AS Validacion FROM movimiento_conjunto WHERE FECHA_MOVIMIENTO BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' AND CONJUNTO_DESTINO = '".$row["CONJUNTO_DESTINO"]."'";
		$rs8 = mysqli_query($link, $consulta);

		if($row8 = mysqli_fetch_array($rs8))
		{
				$Total_val = $row8["Validacion"];
		}

				echo '<tr class="Detalle02">';
					echo '<td width="70%" colspan="3"><strong>Totales</strong></td>';			        
					echo '<td width="10%" align="right">'.number_format($Total_Humedo/1000,3,",","").'</td>';
					$Total_Final = $Total_Humedo + $Total_val;			        								        
					echo '<td width="10%" align="right">'.number_format($Total_val/1000,3,",","").'</td>';			        
					echo '<td width="10%" align="right">'.number_format($Total_Final/1000,3,",","").'</td>';
				echo '</tr>';
			echo '</table><br>'; 								        

	} 	



?>
    <table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <input name="btnimprimir" type="button" value="Imprimir" style="width:70;"
                    onClick="JavaScript:Imprimir()">
                <input name="btnsalir" type="button" style="width:70" onClick="JavaScript:Salir()" value="Salir">
            </td>
        </tr>
    </table>

</body>

</html>
<?php include("../principal/cerrar_ram_web.php") ?>