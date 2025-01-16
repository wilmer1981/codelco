<?php 
include("../principal/conectar_sea_web.php");

if(isset($_REQUEST["Proceso"])) {
	$Proceso = $_REQUEST["Proceso"];
}else{
	$Proceso = "";
}
if(isset($_REQUEST["dia"])) {
	$dia = $_REQUEST["dia"];
}else{
	$dia = date("d");
}
if(isset($_REQUEST["mes"])) {
	$mes = $_REQUEST["mes"];
}else{
	$mes =  date("m");
}
if(isset($_REQUEST["ano"])) {
	$ano = $_REQUEST["ano"];
}else{
	$ano =  date("Y");
}
if(isset($_REQUEST["dia_t"])) {
	$dia_t = $_REQUEST["dia_t"];
}else{
	$dia_t = date("d");
}
if(isset($_REQUEST["mes_t"])) {
	$mes_t = $_REQUEST["mes_t"];
}else{
	$mes_t =  date("m");
}
if(isset($_REQUEST["ano_t"])) {
	$ano_t = $_REQUEST["ano_t"];
}else{
	$ano_t =  date("Y");
}
if(isset($_REQUEST["mes_i"])) {
	$mes_i = $_REQUEST["mes_i"];
}else{
	$mes_i =  date("m");
}
if(isset($_REQUEST["ano_i"])) {
	$ano_i = $_REQUEST["ano_i"];
}else{
	$ano_i =  date("Y");
}

if(isset($_REQUEST["mes2"])) {
	$mes2 = $_REQUEST["mes2"];
}else{
	$mes2 =  date("m");
}
if(isset($_REQUEST["ano2"])) {
	$ano2 = $_REQUEST["ano2"];
}else{
	$ano2 =  date("Y");
}


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

function Imprimir()
{
	window.print();
}

</script>

</head>

<body class="TablaPrincipal">
<table width="320" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr class="ColorTabla01">
    <td align="center">STOCK PISO RAF</td>
  </tr>
  <tr class="ColorTabla02"> 
    <td align="center">PERIODO: 
	<?php if($Proceso != 'V' && $Proceso != 'V1')
	 		echo $mes_t.'/'.$ano_t; 
	   if($Proceso == 'V')
	   	    echo $mes2.'/'.$ano2; 	
	   if($Proceso == 'V1')
	   	    echo $mes.'/'.$ano; 	
	?>
	</td>
  
  </tr>
</table>
<br>


<?php
	$fecha_ini = $ano_i.'-'.$mes_i.'-01';
	$fecha_ter = $ano_t.'-'.$mes_t.'-31';		
?>	

<?php
	if($Proceso == 'V')
	{	
		$fecha_ini = $ano2.'-'.$mes2.'-01';
		$fecha_ter = $ano2.'-'.$mes2.'-31';			
	}

	if($Proceso == 'V1')
	{	
		$fecha_ini = $ano.'-'.$mes.'-01';
		$fecha_ter = $ano.'-'.$mes.'-31';			
	}
?>

<?php
$largo = 400; //Largo de la Tabla.

echo '<table width="'.$largo.'"  border="0" cellspacing="0" cellpadding="0" align="center">';
echo '<tr class="ColorTabla02">';
echo '<td colspan="3" align="center">&Aacute;NODOS EN PISO DE RAF</td>';
echo '</tr>';
echo '<tr class="ColorTabla01">';
echo '<td width="180" align="center">TIPO ANODO</td>';
echo '<td width="100"align="center">CANTIDAD</td>';
echo '<td width="100" align="center">PESO KGS.</td>';
echo '</tr></table>';
$TotalCantidad = 0;
$TotalPeso     = 0;
$consulta = "SELECT distinct cod_subproducto FROM sea_web.stock_piso_raf WHERE cod_producto = 17";
$consulta = $consulta." AND fecha BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
$consulta = $consulta." ORDER BY fecha";		
$rs8 = mysqli_query($link, $consulta);

echo '<table width="'.$largo.'" border="0" cellspacing="0" cellpadding="0" align = "center">'; 

while($row8 = mysqli_fetch_array($rs8))
{
	$consulta = "SELECT * FROM subproducto WHERE cod_producto = '17' and cod_subproducto = '".$row8["cod_subproducto"]."'";
	include("../principal/conectar_principal.php");
	$rs3 = mysqli_query($link, $consulta);
	if($row3 = mysqli_fetch_array($rs3))
	{
			//Crea el detalle.					
			echo '<tr class="ColorTabla02"><td width="180"><center>'.$row3['abreviatura'].'</center></td>';

			echo '<td width="100" align="center">';

			$consulta = "SELECT SUM(unidades) as unidades FROM sea_web.stock_piso_raf";
			$consulta = $consulta." WHERE cod_producto = 17";
			$consulta = $consulta." AND cod_subproducto = '".$row8["cod_subproducto"]."' AND fecha BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
			$rs_u = mysqli_query($link, $consulta);
			if($row_u = mysqli_fetch_array($rs_u))
			{ 
				echo $row_u["unidades"].'</td>';
                $TotalCantidad = $TotalCantidad + $row_u["unidades"];
			}

			echo '<td width="100" align="center">';

			$consulta = "SELECT SUM(peso) as peso FROM sea_web.stock_piso_raf";
			$consulta = $consulta." WHERE cod_producto = 17";
			$consulta = $consulta." AND cod_subproducto = '".$row8["cod_subproducto"]."' AND fecha BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
			$rs_p = mysqli_query($link, $consulta);
			
			if($row_p = mysqli_fetch_array($rs_p))
			{ 
				echo $row_p["peso"].'</td>';
                $TotalPeso = $TotalPeso + $row_p["peso"];
			}

	}

}
	echo '<tr class="Detalle02">';
	echo '<td width="180">TOTAL ACUMULADO</td>';
	echo '<td width="100"align="center">'.$TotalCantidad.'</td>';
	echo '<td width="100" align="center">'.$TotalPeso.'</td></tr>';
	echo '</table><br>';

//Restos
$largo = 400;
echo '<table width="'.$largo.'"  border="0" cellspacing="0" cellpadding="0" align="center">';
echo '<tr class="ColorTabla02">';
echo '<td colspan="3" align="center">RESTOS EN PISO DE RAF</td>';
echo '</tr>';
echo '<tr class="ColorTabla01">';
echo '<td width="180" align="center">GRUPO</td>';
echo '<td width="100"align="center">CANTIDAD</td>';
echo '<td width="100" align="center">PESO KGS.</td></tr></table>';
		
$consulta = "SELECT DISTINCT grupo";
$consulta = $consulta." FROM sea_web.stock_piso_raf WHERE cod_producto = 19";
$consulta = $consulta." AND fecha BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
$consulta = $consulta." ORDER BY grupo";
$rs2 = mysqli_query($link, $consulta);		
				

$TotalCantidad = 0;
$TotalPeso = 0; 
	//Crea el detalle.					
	echo '<table width="'.$largo.'" border="0" cellspacing="0" cellpadding="0" align = "center">'; 
	while ($row2 = mysqli_fetch_array($rs2))
	{												 

		echo '<tr class="ColorTabla02">';

		echo '<td width="180" align="center">'.$row2["grupo"].'</td>';

		echo '<td width="100" align="center">';

		$consulta = "SELECT SUM(unidades) as unidades FROM sea_web.stock_piso_raf";
		$consulta = $consulta." WHERE cod_producto = 19";
		$consulta = $consulta." AND grupo = '".$row2["grupo"]."' AND fecha BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
		$rs_u = mysqli_query($link, $consulta);
		if($row_u = mysqli_fetch_array($rs_u))
		{ 
			echo $row_u["unidades"].'</td>';
			$TotalCantidad = $TotalCantidad + $row_u["unidades"];
		}

		echo '<td width="100" align="center">';

		$consulta = "SELECT SUM(peso) as peso FROM sea_web.stock_piso_raf";
		$consulta = $consulta." WHERE cod_producto = 19";
		$consulta = $consulta." AND grupo = '".$row2["grupo"]."' AND fecha BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
		$rs_p = mysqli_query($link, $consulta);
		
		if($row_p = mysqli_fetch_array($rs_p))
		{ 
			echo $row_p["peso"].'</td>';
			$TotalPeso = $TotalPeso + $row_p["peso"];
		}

	}
	echo '<tr class="Detalle02">';
	echo '<td width="180">TOTAL ACUMULADO</td>';
	echo '<td width="100"align="center">'.$TotalCantidad.'</td>';
	echo '<td width="100" align="center">'.$TotalPeso.'</td></tr>';
	echo '</table><br>';
			
?>
<?php
$largo = 400; //Largo de la Tabla.

echo '<table width="'.$largo.'"  border="0" cellspacing="0" cellpadding="0" align="center">';
echo '<tr class="ColorTabla02">';
echo '<td colspan="3" align="center">BLISTER EN PISO DE RAF</td>';
echo '</tr>';
echo '<tr class="ColorTabla01">';
echo '<td width="180" align="center">TIPO BLISTER</td>';
echo '<td width="100"align="center">CANTIDAD</td>';
echo '<td width="100" align="center">PESO KGS.</td>';
echo '</tr></table>';

$consulta = "SELECT distinct cod_subproducto FROM sea_web.stock_piso_raf WHERE cod_producto = 16";
$consulta = $consulta." AND fecha BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
$consulta = $consulta." ORDER BY fecha";		
$rs8 = mysqli_query($link, $consulta);
echo '<table width="'.$largo.'" border="0" cellspacing="0" cellpadding="0" align = "center">'; 

while($row8 = mysqli_fetch_array($rs8))
{
	$consulta = "SELECT * FROM subproducto WHERE cod_producto = '16' and cod_subproducto = '".$row8["cod_subproducto"]."'";
	include("../principal/conectar_principal.php");
	$rs3 = mysqli_query($link, $consulta);
	if($row3 = mysqli_fetch_array($rs3))
	{
			//Crea el detalle.					
			echo '<tr class="ColorTabla02"><td width="180"><center>'.$row3['abreviatura'].'</center></td>';

			echo '<td width="100" align="center">';

			$consulta = "SELECT SUM(unidades) as unidades FROM sea_web.stock_piso_raf";
			$consulta = $consulta." WHERE cod_producto = 16";
			$consulta = $consulta." AND cod_subproducto = '".$row8["cod_subproducto"]."' AND fecha BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
			$rs_u = mysqli_query($link, $consulta);
			if($row_u = mysqli_fetch_array($rs_u))
			{ 
				echo $row_u["unidades"].'</td>';
			}

			echo '<td width="100" align="center">';

			$consulta = "SELECT SUM(peso) as peso FROM sea_web.stock_piso_raf";
			$consulta = $consulta." WHERE cod_producto = 16";
			$consulta = $consulta." AND cod_subproducto = '".$row8["cod_subproducto"]."' AND fecha BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
			$rs_p = mysqli_query($link, $consulta);
			
			if($row_p = mysqli_fetch_array($rs_p))
			{ 
				echo $row_p["peso"].'</td>';
			}

	}

}
	echo '</tr></table><br>';
?>

<?php
// esto se agrega para poder revisar stock de catodos 3-6-2004 JCF
$largo = 400; //Largo de la Tabla.

echo '<table width="'.$largo.'"  border="0" cellspacing="0" cellpadding="0" align="center">';
echo '<tr class="ColorTabla02">';
echo '<td colspan="3" align="center">CATODOS EN PISO DE RAF</td>';
echo '</tr>';
echo '<tr class="ColorTabla01">';
echo '<td width="180" align="center">TIPO CATODO</td>';
echo '<td width="100"align="center">CANTIDAD</td>';
echo '<td width="100" align="center">PESO KGS.</td>';
echo '</tr></table>';
$TotalCantidad = 0;
$TotalPeso = 0;
$consulta = "SELECT distinct cod_subproducto FROM sea_web.stock_piso_raf WHERE cod_producto = 18";
$consulta = $consulta." AND fecha BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
$consulta = $consulta." ORDER BY fecha";
$rs8 = mysqli_query($link, $consulta);
echo '<table width="'.$largo.'" border="0" cellspacing="0" cellpadding="0" align = "center">';

while($row8 = mysqli_fetch_array($rs8))
{
	$consulta = "SELECT * FROM subproducto WHERE cod_producto = '18' and cod_subproducto = '".$row8["cod_subproducto"]."'";
	include("../principal/conectar_principal.php");
	$rs3 = mysqli_query($link, $consulta);
	if($row3 = mysqli_fetch_array($rs3))
	{
			//Crea el detalle.
			echo '<tr class="ColorTabla02"><td width="180"><center>'.$row3['abreviatura'].'</center></td>';

			echo '<td width="100" align="center">';

			$consulta = "SELECT SUM(unidades) as unidades FROM sea_web.stock_piso_raf";
			$consulta = $consulta." WHERE cod_producto = 18";
			$consulta = $consulta." AND cod_subproducto = '".$row8["cod_subproducto"]."' AND fecha BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
			$rs_u = mysqli_query($link, $consulta);
			if($row_u = mysqli_fetch_array($rs_u))
			{
				echo $row_u["unidades"].'</td>';
                $TotalCantidad = $TotalCantidad + $row_u["unidades"];
			}

			echo '<td width="100" align="center">';

			$consulta = "SELECT SUM(peso) as peso FROM sea_web.stock_piso_raf";
			$consulta = $consulta." WHERE cod_producto = 18";
			$consulta = $consulta." AND cod_subproducto = '".$row8["cod_subproducto"]."' AND fecha BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
			$rs_p = mysqli_query($link, $consulta);

			if($row_p = mysqli_fetch_array($rs_p))
			{
				echo $row_p["peso"].'</td>';
                $TotalPeso = $TotalPeso + $row_p["peso"];
			}

	}

}  	echo '<tr class="Detalle02">';
	echo '<td width="180">TOTAL ACUMULADO</td>';
	echo '<td width="100"align="center">'.$TotalCantidad.'</td>';
	echo '<td width="100" align="center">'.$TotalPeso.'</td></tr>';
	echo '</table><br>';
// hasta aca parrafo de catodos
?>
<?php
// aca se agrega parrafo para ver despuntes y laminas 3-6-2004 JCF
$largo = 400; //Largo de la Tabla.

echo '<table width="'.$largo.'"  border="0" cellspacing="0" cellpadding="0" align="center">';
echo '<tr class="ColorTabla02">';
echo '<td colspan="3" align="center">DESPUNTES Y LAMINAS EN PISO DE RAF</td>';
echo '</tr>';
echo '<tr class="ColorTabla01">';
echo '<td width="180" align="center">TIPO DESPUNTE</td>';
echo '<td width="100"align="center">CANTIDAD</td>';
echo '<td width="100" align="center">PESO KGS.</td>';
echo '</tr></table>';
$TotalPeso = 0;
$TotlaCantidad = 0;
$consulta = "SELECT distinct cod_subproducto FROM sea_web.stock_piso_raf WHERE cod_producto = 48";
$consulta = $consulta." AND fecha BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
$consulta = $consulta." ORDER BY fecha";
$rs8 = mysqli_query($link, $consulta);
echo '<table width="'.$largo.'" border="0" cellspacing="0" cellpadding="0" align = "center">';

while($row8 = mysqli_fetch_array($rs8))
{
	$consulta = "SELECT * FROM subproducto WHERE cod_producto = '48' and cod_subproducto = '".$row8["cod_subproducto"]."'";
	include("../principal/conectar_principal.php");
	$rs3 = mysqli_query($link, $consulta);
	if($row3 = mysqli_fetch_array($rs3))
	{
			//Crea el detalle.
			echo '<tr class="ColorTabla02"><td width="180"><center>'.$row3['abreviatura'].'</center></td>';

			echo '<td width="100" align="center">';

			$consulta = "SELECT SUM(unidades) as unidades FROM sea_web.stock_piso_raf";
			$consulta = $consulta." WHERE cod_producto = 48";
			$consulta = $consulta." AND cod_subproducto = '".$row8["cod_subproducto"]."' AND fecha BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
			$rs_u = mysqli_query($link, $consulta);
			if($row_u = mysqli_fetch_array($rs_u))
			{
				echo $row_u["unidades"].'</td>';
                $TotalCantidad = $TotalCantidad + $row_u["unidades"];
			}

			echo '<td width="100" align="center">';

			$consulta = "SELECT SUM(peso) as peso FROM sea_web.stock_piso_raf";
			$consulta = $consulta." WHERE cod_producto = 48";
			$consulta = $consulta." AND cod_subproducto = '".$row8["cod_subproducto"]."' AND fecha BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
			$rs_p = mysqli_query($link, $consulta);

			if($row_p = mysqli_fetch_array($rs_p))
			{
				echo $row_p["peso"].'</td>';
                $TotalPeso = $TotalPeso + $row_p["peso"];
			}

	}

}
	echo '<tr class="Detalle02">';
	echo '<td width="180">TOTAL ACUMULADO</td>';
	echo '<td width="100"align="center">'.$TotalCantidad.'</td>';
	echo '<td width="100" align="center">'.$TotalPeso.'</td></tr>';
	echo '</table><br>';
//  hasta aca.........
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
