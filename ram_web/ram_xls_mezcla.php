<?  
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
    include("../principal/conectar_ram_web.php"); 
?>
<html>
<head>
<title>Movimientos Mezcla</title>
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
<?
	//<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
?>
</head>

<body class="TablaPrincipal">
<table width="320" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr class="ColorTabla01">
    <td align="center" colspan="10">INFORME MOVIMIENTO DE MEZCLAS</td>
  </tr>
  <tr class="ColorTabla02"> 
    <td align="center" colspan="10">FECHA:  <? echo $dia.'/'.$mes.'/'.$ano ?></td>
  </tr>
</table>
<br>

<?
	if(strlen($dia) == 1)
		$dia = '0'.$dia;
	
	if(strlen($mes) == 1)
		$mes = '0'.$mes;
			
	$fecha_ini = $ano.'-'.$mes.'-'.$dia.' 08:00:00';
	$fecha_ter = date("Y-m-d",mktime(7,59,59,$mes,($dia + 1),$ano))." 07:59:59";	
	
	$consulta = "SELECT distinct CONJUNTO_DESTINO FROM ram_web.movimiento_conjunto WHERE FECHA_MOVIMIENTO BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' AND cod_conjunto_destino = 2 order by CONJUNTO_DESTINO ASC ";
	$rs = mysql_query($consulta);

	while($row = mysql_fetch_array($rs))
	{
		echo '<table width="300" border="0" cellspacing="0" cellpadding="0" align="center">';
		echo'<tr class="ColorTabla02">';
		echo '<td width="50%" align="right" colspan="2"><strong>MEZCLA :</strong></td>';

		$consulta = "SELECT * FROM ram_web.conjunto_ram WHERE num_conjunto = $row[CONJUNTO_DESTINO]";
		$rs2 = mysql_query($consulta);
		
		if($row2 = mysql_fetch_array($rs2))
		{
			echo '<td width="60%">'.$row2[num_conjunto].' - '.$row2[descripcion].'</td>';
		}
		echo '</tr></table>';

		echo '<table width="730"  border="1" cellspacing="0" cellpadding="0" align="center">';
		echo'<tr class="ColorTabla01">';
		echo '<td width="12%" align="center">COD.</td>';
		echo '<td width="22%" align="center">CONJ. ORIGEN</td>';
//		echo '<td width="18%" align="center">TIPO MOV.</td>';
		echo '<td width="20%" align="center">FECHA MOVIMIENTO</td>';
		echo '<td width="10%"align="center">PESO HUMEDO</td>';
		echo '<td width="10%"align="center">VALIDACIÓN</td>';
		echo '<td width="10%" align="center">PESO TOTAL</td>';
		echo '</tr>';

		$consulta = "SELECT COD_EXISTENCIA,COD_CONJUNTO,NUM_CONJUNTO,FECHA_MOVIMIENTO,PESO_HUMEDO_MOVIDO,ESTADO_VALIDACION FROM movimiento_conjunto
		 WHERE FECHA_MOVIMIENTO BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' AND CONJUNTO_DESTINO = $row2[num_conjunto] AND cod_conjunto_destino = 2 ORDER BY FECHA_MOVIMIENTO";
		$rs3 = mysql_query($consulta);
				            
		while ($row3 = mysql_fetch_array($rs3))
		{												  

		    	echo '<tr><td width="8%">'.$row3[COD_CONJUNTO].' * '.$row3[NUM_CONJUNTO].'</td>';

				$consulta = "SELECT * FROM conjunto_ram where cod_conjunto = $row3[COD_CONJUNTO] AND num_conjunto = $row3[NUM_CONJUNTO]"; 
				$rs5 = mysql_query($consulta);
	
				if($row5 = mysql_fetch_array($rs5))
				{
	 			    	echo '<td width="22%">'.$row5[descripcion].'</td>';
				}


/*				$consulta = "SELECT nombre_existencia FROM atributo_existencia where cod_existencia = $row3[COD_EXISTENCIA]"; 
				$rs6 = mysql_query($consulta);
				if($row6 = mysql_fetch_array($rs6))
				{
	 			    	echo '<td width="10%" align="center">'.$row6[nombre_existencia].'</td>';
				}
*/
				echo '<td width="20%" align="center">'.$row3[FECHA_MOVIMIENTO].'</td>';
				echo '<td width="10%" align="center">'.number_format($row3[PESO_HUMEDO_MOVIDO]/1000,3,",","").'</td>';
				$validacion = $row3[ESTADO_VALIDACION];
				echo '<td width="10%" align="center">'.number_format($validacion/1000,3,",","").'</td>';
				$Total = $row3[PESO_HUMEDO_MOVIDO] + $validacion;
				echo '<td width="10%" align="center">'.number_format($Total/1000,3,",","").'</td>';
				
		}
     	echo '</tr>';
		
		$consulta = "SELECT SUM(PESO_HUMEDO_MOVIDO) AS Total_Humedo FROM movimiento_conjunto WHERE FECHA_MOVIMIENTO BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' AND CONJUNTO_DESTINO = $row[CONJUNTO_DESTINO]";
		$rs7 = mysql_query($consulta);

		if($row7 = mysql_fetch_array($rs7))
		{
			$Total_Humedo = $row7[Total_Humedo];
		}

		$consulta = "SELECT SUM(ESTADO_VALIDACION) AS Validacion FROM movimiento_conjunto WHERE FECHA_MOVIMIENTO BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' AND CONJUNTO_DESTINO = $row[CONJUNTO_DESTINO]";
		$rs8 = mysql_query($consulta);

		if($row8 = mysql_fetch_array($rs8))
		{
				$Total_val = $row8[Validacion];
		}

				echo '<tr class="Detalle02">';
					echo '<td width="70%" colspan="3"><strong>Totales</strong></td>';			        
					echo '<td width="10%"><center>'.number_format($Total_Humedo/1000,3,",","").'</center></td>';
					$Total_Final = $Total_Humedo + $Total_val;			        								        
					echo '<td width="10%"><center>'.number_format($Total_val/1000,3,",","").'</center></td>';			        
					echo '<td width="10%"><center>'.number_format($Total_Final/1000,3,",","").'</center></td>';
				echo '</tr>';
			echo '</table><br>'; 								        

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
<? include("../principal/cerrar_ram_web.php") ?>