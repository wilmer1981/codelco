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


		$dia_t = $_REQUEST["dia_t"];
		$mes_t = $_REQUEST["mes_t"];
		$ano_t = $_REQUEST["ano_t"];
?>
<html>
<head>
<title>Informe Diario Prooducci&oacute;n</title>

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
<table width="374" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr class="ColorTabla01">
    <td width="374" align="center" colspan="3">INFORME DIARIO DE PRODUCCION DE &Aacute;NODOS</td>
  </tr>
  <tr class="ColorTabla02"> 
    <td align="center" colspan="3">FECHA:  <?php echo $dia_t.'/'.$mes_t.'/'.$ano_t ?></td>
  </tr>
</table>
<br>


<?php
	$fecha_ter = $ano_t.'-'.$mes_t.'-'.$dia_t.' 23:59:00';		
	$fecha_ini =date("Y-m-d", mktime(1,0,0,$mes_t,$dia_t ,$ano_t));	
	$fecha_ter =date("Y-m-d", mktime(1,0,0,$mes_t,($dia_t +1),$ano_t));	


?>	
	<table width="500"  border="1" cellspacing="0" cellpadding="0" align="center" class="ColorTabla01">
	  <tr>
    	<td width="33%" align="center">GRUPO</td>
    	<td width="33%" align="center">% RESTOS</td>
      </tr>
	</table>
<?php

$Consulta = "SELECT DISTINCT CASE WHEN LENGTH(campo2)=1 THEN CONCAT('0',campo2) ELSE campo2 END AS grupo , campo2";
$Consulta = $Consulta."	FROM sea_web.movimientos WHERE tipo_movimiento = 3 AND cod_producto = 19 ";//
$Consulta = $Consulta."	AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' and hora between '".$fecha_ini." 08:00:00' and '".$fecha_ter." 07:59:59' ORDER BY grupo";
$rs = mysqli_query($link, $Consulta);

echo'<table width="500"  border="1" cellspacing="0" cellpadding="0" align="center">';
	
while($row = mysqli_fetch_array($rs))
{       
		$peso_benef = 0;       
        $porc_peso = 0; 

		$consulta = "SELECT valor_subclase1 FROM sub_clase WHERE cod_clase = 2004 AND cod_subclase = '".$row["campo2"]."'";
		include("../principal/conectar_principal.php"); 
		$rs4 = mysqli_query($link, $consulta);
		if($row4 = mysqli_fetch_array($rs4))
		{
			$consulta = "SELECT valor_subclase1 FROM sub_clase WHERE cod_clase = 2003 AND cod_subclase = '".$row4["valor_subclase1"]."'";
			$rs5 = mysqli_query($link, $consulta);
			if($row5 = mysqli_fetch_array($rs5))
			{
				$factor = $row5["valor_subclase1"];
			}
		}
		
		$consulta = "SELECT numero_recarga, fecha_benef";
		$consulta = $consulta." FROM sea_web.movimientos";
		$consulta = $consulta." WHERE tipo_movimiento = 3 AND cod_producto = 19";
		$consulta = $consulta." AND campo2 = '".$row["campo2"]."' and fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' and hora between '".$fecha_ini." 08:00:00' and '".$fecha_ter." 07:59:59'";
        $rs1 = mysqli_query($link, $consulta);

		while($row1 = mysqli_fetch_array($rs1))
		{		
        	$consulta = "SELECT peso from sea_web.movimientos";
			$consulta = $consulta." WHERE tipo_movimiento = 2 AND cod_producto in (17,19) AND cod_subproducto != 8";
			$consulta = $consulta." AND campo2 = '".$row["campo2"]."' AND hornada = '".$row1["numero_recarga"]."' AND fecha_movimiento = '".$row1["fecha_benef"]."'";
	        $rs3 = mysqli_query($link, $consulta);

			while($row3 = mysqli_fetch_array($rs3))
			{
				$peso_benef = $peso_benef + $row3["peso"];
			}
		}

		$consulta = "SELECT SUM(peso) AS peso";
		$consulta = $consulta." FROM sea_web.movimientos";
		$consulta = $consulta." WHERE tipo_movimiento = 3 AND cod_producto = 19";
		$consulta = $consulta." AND campo2 = '".$row["campo2"]."' AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' and hora between '".$fecha_ini." 08:00:00' and '".$fecha_ter." 07:59:59'";
		$consulta = $consulta." GROUP BY campo2 ORDER BY campo2";				
        $rs2 = mysqli_query($link, $consulta);
		
		if($row2 = mysqli_fetch_array($rs2))
		{            
   			$peso_porcent = ($row2["peso"] * $factor)/100;			
			$peso_prod = $row2["peso"] - $peso_porcent;  
           
		    $porc_peso = round(($peso_prod * 100)/ $peso_benef,1);  
			
			echo '<tr><td width="33%" align="center">'.$row["campo2"].'</td>';
			echo '<td width="33%" align="center">'.number_format($porc_peso,1,',','').'</td></tr>';
		}
}
echo'</table><br>';
?>

	<table width="500"  border="1" cellspacing="0" cellpadding="0" align="center">
	  <tr class="ColorTabla02">
    	<td align="center" colspan="3">Detalle</td>
      </tr>
	  <tr class="ColorTabla01">
    	<td width="33%" align="center">GRUPO</td>
    	<td width="33%" align="center">PESO BENEFICIO</td>
    	<td width="33%" align="center">PESO PRODUCCION</td>
      </tr>
	</table>

<?php
//Detalle 
$Consulta = "SELECT DISTINCT CASE WHEN LENGTH(campo2)=1 THEN CONCAT('0',campo2) ELSE campo2 END AS grupo , campo2";
$Consulta = $Consulta."	FROM sea_web.movimientos WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto != 8";
$Consulta = $Consulta."	AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' and hora between '".$fecha_ini." 08:00:00' and '".$fecha_ter." 07:59:59' ORDER BY grupo";
$rs = mysqli_query($link, $Consulta);

echo'<table width="500"  border="1" cellspacing="0" cellpadding="0" align="center">';
	
while($row = mysqli_fetch_array($rs))
{       
		$peso_benef = 0;       
        $porc_peso = 0; 

		$consulta = "SELECT valor_subclase1 FROM sub_clase WHERE cod_clase = 2004 AND cod_subclase = '".$row["campo2"]."'";
		include("../principal/conectar_principal.php"); 
		$rs4 = mysqli_query($link, $consulta);
		if($row4 = mysqli_fetch_array($rs4))
		{
			$consulta = "SELECT valor_subclase1 FROM sub_clase WHERE cod_clase = 2003 AND cod_subclase = '".$row4["valor_subclase1"]."'";
			$rs5 = mysqli_query($link, $consulta);
			if($row5 = mysqli_fetch_array($rs5))
			{
				$factor = $row5["valor_subclase1"];
			}
		}
		
		$consulta = "SELECT numero_recarga, fecha_benef";
		$consulta = $consulta." FROM sea_web.movimientos";
		$consulta = $consulta." WHERE tipo_movimiento = 3 AND cod_producto = 19";
		$consulta = $consulta." AND campo2 = '".$row["campo2"]."' AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' and hora between '".$fecha_ini." 08:00:00' and '".$fecha_ter." 07:59:59'";
        $rs1 = mysqli_query($link, $consulta);

		while($row1 = mysqli_fetch_array($rs1))
		{		
        	$consulta = "SELECT peso from sea_web.movimientos";
			$consulta = $consulta." WHERE tipo_movimiento = 2 AND cod_producto in (17,19) AND cod_subproducto != 8";
			$consulta = $consulta." AND campo2 = '".$row["campo2"]."' AND hornada = '".$row1["numero_recarga"]."' AND fecha_movimiento = '".$row1["fecha_benef"]."'";
	        $rs3 = mysqli_query($link, $consulta);


			while($row3 = mysqli_fetch_array($rs3))
			{
				$peso_benef = $peso_benef + $row3["peso"];
			}
		}

		$consulta = "SELECT SUM(peso) AS peso";
		$consulta = $consulta." FROM sea_web.movimientos";
		$consulta = $consulta." WHERE tipo_movimiento = 3 AND cod_producto = 19";
		$consulta = $consulta." AND campo2 = '".$row["campo2"]."' AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' and hora between '".$fecha_ini." 08:00:00' and '".$fecha_ter." 07:59:59'";
		$consulta = $consulta." GROUP BY campo2 ORDER BY campo2";				
        $rs2 = mysqli_query($link, $consulta);
		
		if($row2 = mysqli_fetch_array($rs2))
		{            
   			$peso_porcent = ($row2["peso"] * 5)/100;			
			$peso_prod = $row2["peso"] - $peso_porcent;  
			
			echo '<tr><td width="33%" align="center">'.$row["campo2"].'</td>';
			echo '<td width="33%" align="center">'.number_format($peso_benef,0,'','.').'</td>';
			echo '<td width="33%" align="center">'.number_format($peso_prod,0,'','.').'</td></tr>';
		}
}
echo'</table>';	
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