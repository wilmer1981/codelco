<?php
   	ob_end_clean();
$file_name=basename($_SERVER['PHP_SELF']).".xls";
$userBrowser = $_SERVER['HTTP_USER_AGENT'];
if ( preg_match( '/MSIE/i', $userBrowser ) ) 
{
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
 	include("../principal/conectar_pmn_web.php");
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
</head>

<body>
<form name="frmConsulta" action="" method="post">
  <table width="686" border="1" cellpadding="3" cellspacing="0" class="TablaDetalle">
    <tr class="ColorTabla01"> 
	<?php
		$consulta = "SELECT * FROM proyecto_modernizacion.productos";
		$consulta.= " WHERE cod_producto = '".$Producto."'";
		$rs = mysqli_query($link, $consulta);
		$row = mysqli_fetch_array($rs);
	?>
      <td width="200" align="left"><strong>Producto:</strong></td>
      <td width="" align="left" colspan="6"><strong><?php echo $row["descripcion"] ?></strong></td>
	</tr>
    <tr class="ColorTabla01"> 
	<?php
		$consulta = "SELECT * FROM proyecto_modernizacion.subproducto";
		$consulta.= " WHERE cod_producto = '".$Producto."' AND cod_subproducto = '".$Subproducto."'";
		$rs1 = mysqli_query($link, $consulta);
		$row1 = mysqli_fetch_array($rs1);
	?>	
      <td width="200" align="center"><strong>SubProducto:</strong></td>
      <td width="" align="center"><strong><?php echo $row1["descripcion"] ?></strong></td>
	</tr>	
</table>
<br>
<?php	
	if (!(($Producto == '44') && ($Subproducto == '2')))
	{
?>	
  <table width="686" border="1" cellpadding="3" cellspacing="0" class="TablaDetalle">
    <tr class="ColorTabla01"> 
      <!--  <td width="57">&nbsp;</td>-->
      <td width="76" align="center"><strong>Fecha</strong></td>
      <td width="75" align="center"><strong>Tambor/Ref</strong></td>
      <td width="99" align="center"><strong>Producto</strong></td>
      <td width="130" align="center"><strong>SubProducto</strong></td>
      <td width="80" align="center"><strong>Peso Bruto</strong></td>
      <td width="91" align="center"><strong>Peso Tambor</strong></td>
      <td width="76" align="center"><strong>Peso Neto</strong></td>
    </tr>
    <?php  
		$Consulta ="select t1.fecha,t1.id_producto,t1.referencia,t2.abreviatura as DesProducto,t3.abreviatura as DesSubproducto,t1.peso_bruto,t1.peso_resta,t1.peso_final,t3.mostrar2 from pmn_web.detalle_productos_externos t1  ";
		$Consulta.=" inner join proyecto_modernizacion.productos t2 on t1.cod_producto = t2.cod_producto ";
		$Consulta.=" inner join proyecto_modernizacion.subproducto t3 on t1.cod_subproducto = t3.cod_subproducto and t2.cod_producto = t3.cod_producto ";

		if (($Producto != '-1') && ($Subproducto != '-1'))
		{
			$Consulta.=" where t1.cod_producto = '".$Producto."' and t1.cod_subproducto = '".$Subproducto."' AND fecha BETWEEN '".$FechaIni."' AND '".$FechaFin."' order by id_producto,referencia"; 
		} 
		if (($Producto != '-1')&&($Subproducto == '-1'))
		{
			$Consulta.=" where t1.cod_producto = '".$Producto."' AND fecha BETWEEN '".$FechaIni."' AND '".$FechaFin."' order by id_producto,referencia";
		}		
		
		if (($Producto == '-1')&&($Subproducto == '-1'))
		{
			$Consulta.=" order by id_producto,referencia ";
		}

		//echo $Consulta."<br>";
		$Respuesta = mysqli_query($link, $Consulta);

		while ($Row = mysqli_fetch_array($Respuesta))
		{
			echo "<tr>\n";
			echo "<td>".$Row["fecha"]."</td>\n";			
			echo "<td>".$Row[id_producto]." ".$Row[referencia]."</td>\n";
			echo "<td>".$Row[DesProducto]."</td>\n";
			echo "<td>".$Row[DesSubproducto]."</td>\n";
			echo "<td align='right'>".number_format($Row[peso_bruto],$Row[mostrar2],',','')."</td>\n";
			echo "<td align='right'>".number_format($Row[peso_resta],$Row[mostrar2],',','')."</td>\n";
			echo "<td align='right'>".$Row[peso_resta]."</td>\n";
			$PesoFinal=$Row[peso_bruto]-$Row[peso_resta];
			echo "<td align='right'>".number_format($PesoFinal,$Row[mostrar2],',','')."</td>\n";
			echo "</tr>\n";
		}  
?>
  </table>
<?php
	}
	else
	{
?>    
  <table width="500" border="1" cellpadding="3" cellspacing="0" class="TablaDetalle">
    <tr class="ColorTabla01"> 
      <td width="86" align="center">Fecha</td>
      <td width="122" align="center">Num. Lote</td>
      <td width="152" align="center">Num. Barra</td>
      <td width="130" align="center">Peso</td>
 </tr>
<?php
	if ($Mostrar=='S')
	{
		$consulta = "select * from pmn_web.ingreso_metal_dore";
		$consulta.= " WHERE fecha BETWEEN '".$FechaIni."' AND '".$FechaFin."'";
		$consulta.= " order by fecha,num_lote,num_barra";
		//echo $consulta."<br>";
		
		$rs = mysqli_query($link, $consulta);
		while ($row = mysqli_fetch_array($rs))
		{
			echo '<tr>';
			echo '<td>'.$row["fecha"].'</td>';
			echo '<td align="center">'.$row[num_lote].'</td>';
			echo '<td align="center">'.$row[num_barra].'</td>';
			echo '<td align="right">'.number_format($row[peso_barra],2,",","").'</td>';
			echo '</tr>';
		}
	}
?>
</table>
<?php
	}
?>  
</form>
</body>
</html>
