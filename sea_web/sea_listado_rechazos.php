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
    <td align="center">RECHAZO DE �NODOS</td>
  </tr>
  <tr class="ColorTabla02"> 
    <td align="center">FECHA:  <?php echo $dia_t.'/'.$mes_t.'/'.$ano_t ?></td>
  </tr>
</table>
<br>


<?php
	$fecha = $ano_t.'-'.$mes_t.'-'.$dia_t;
	$largo = 80 * 4;		

			echo '<table width="320" border="0" cellspacing="0" cellpadding="0" align="center">';
			echo '<tr class="ColorTabla01"><td><center>';

			$consulta = "SELECT descripcion AS nombre FROM subproducto WHERE cod_producto = 17 AND cod_subproducto = ".$cmbproducto;
		
			echo "PRODUCTO: ";

			include("../principal/conectar_principal.php");
			$rs4 = mysqli_query($link, $consulta);

						
			if ($row4 = mysqli_fetch_array($rs4))
				echo $row4["nombre"];									

			echo '</center></td></tr></table><br>';
		   	echo '<table width="'.$largo.'"  border="1" cellspacing="0" cellpadding="0" align="center"><tr class="ColorTabla01">';
		    echo '<td width="80" align="center">FECHA</td>';
		    echo '<td width="80" align="center">N&deg; HORNADA</td>';
		    echo '<td width="80"align="center">CANTIDAD</td>';
		    echo '<td width="80" align="center">PESO<br>KGS.</td></tr></table';

?>	

  </tr>
</table>
<br>


<?php
    $subproducto = $cmbproducto;


	include("../principal/conectar_sea_web.php");
     
	 $consulta = "SELECT distinct t1.hornada, t1.cod_subproducto, t1.cod_producto FROM movimientos as t1 inner join hornadas as t2 
	               ON t1.hornada = t2.hornada_ventana AND t1.cod_producto = t2.cod_producto AND t1.cod_subproducto = t2.cod_subproducto   
	               WHERE t1.tipo_movimiento = 6 AND t1.fecha_movimiento =  '$fecha' AND t1.cod_producto = 17 AND 
				         t1.cod_subproducto = $cmbproducto AND t2.estado = 0"; 
						 
	 $rs = mysqli_query($link, $consulta);						 

  while ($row = mysqli_fetch_array($rs))
  {	
   		$hornada=$row[hornada];

			//consulto peso en hornadas
			$consulta7 = "SELECT * FROM hornadas WHERE hornada_ventana = ".$hornada;
			$consulta7 = $consulta7." and cod_producto = 17 and cod_subproducto = $subproducto";

	        include("../principal/conectar_sea_web.php");
	 	    $rs7 = mysqli_query($link, $consulta7);

	/*		//consulto rechazos
			include("funciones.php"); //funciones de stock		
            $unidades = StockRechazo($hornada,$producto,$subproducto);//llamo a la funcion de rechazos
    */

			$consulta = "SELECT SUM(t1.unidades) AS unid, SUM(t1.unidades * (t2.peso_unidades / t2.unidades)) AS peso";
			$consulta = $consulta." FROM movimientos AS t1 INNER JOIN hornadas AS t2";
			$consulta = $consulta." ON t1.hornada = t2.hornada_ventana AND";
			$consulta = $consulta." t1.cod_producto = t2.cod_producto AND t1.cod_subproducto = t2.cod_subproducto";
			$consulta = $consulta." WHERE t1.hornada = $hornada AND t1.tipo_movimiento = 6 AND t1.cod_producto = 17 AND t1.cod_subproducto = $subproducto AND t1.fecha_movimiento = '$fecha'";
	        
	        include("../principal/conectar_sea_web.php");
			$rs3 = mysqli_query($link, $consulta);
			include("../principal/cerrar_sea_web.php");

		/*	if ($row7 = mysqli_fetch_array($rs7))
			{
			$peso_unidad = $row7[peso_unidades] / $row7["unidades"];
			$peso = $unidades * $peso_unidad; 
			$peso = number_format($peso,1,"",""); 
			} */
             
        
		    //Crea el detalle.					
			echo '<table width="'.$largo.'" border="1" cellspacing="0" cellpadding="0" align = "center">'; 
												  
			$row3 = mysqli_fetch_array($rs3);
			if (!is_null($row3[unid]))					
			{  
			    echo '<tr class="ColorTabla02"><td width="80"><center>'.$fecha.'</center></td>';
			    echo '<td width="80" align="center">'.substr($hornada,6,6).'</td>';
			    echo '<td width="80" align="center">';
				printf("%'�8d",$row3[unid].'</td>');
			    echo '<td width="80" align="center">';
				printf("%'�10d",$ro["peso"]o].'</td>');
            }	   	
    		echo '</table>';
  
  } 

			//consulto el total del producto
			$consulta = "SELECT SUM(t1.unidades) AS unid, SUM(t1.unidades * (t2.peso_unidades / t2.unidades)) AS peso";
			$consulta = $consulta." FROM movimientos AS t1 INNER JOIN hornadas AS t2";
			$consulta = $consulta." ON t1.hornada = t2.hornada_ventana AND";
			$consulta = $consulta." t1.cod_producto = t2.cod_producto AND t1.cod_subproducto = t2.cod_subproducto";
			$consulta = $consulta." WHERE t1.tipo_movimiento = 6 AND t1.cod_producto = 17 AND t1.cod_subproducto = $subproducto AND t1.fecha_movimiento = '".$fecha."'";

			
			include("../principal/conectar_sea_web.php");
			$rs3 = mysqli_query($link, $consulta);
			include("../principal/cerrar_sea_web.php");

			echo '<table width="'.$largo.'" border="1" cellspacing="0" cellpadding="0" align="center" class="Detalle02">';
           	echo '<tr><td width=160">'; 

		        echo 'TOTAL PRODUCTO</td>';
			
			$row3 = mysqli_fetch_array($rs3);
			if (!is_null($row3[unid]))					
			{  
                echo '<td width="80" align="center">';
				printf("%'�8d",$row3[unid].'</td>');
                echo '<td width="80" align="center">';
				printf("%'�10d",$ro["peso"]o].'</td>');
			
            } 

     		echo '</tr></table><br>';

?>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
	<td align="center">
    <input name="btnimprimir" type="button" value="Imprimir" style="width:70;" onClick="JavaScript:Imprimir()">
	<input name="btnsalir" type="button" style="width:70" onClick="JavaScript:Salir()" value="Salir"></td>
  </tr>
</table>
