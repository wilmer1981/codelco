<?php 
include("../principal/conectar_sea_web.php");

$radio2    = isset($_REQUEST["radio2"])?$_REQUEST["radio2"]:"";
$radio = isset($_REQUEST["radio"])?$_REQUEST["radio"]:"";
$dia_i     = isset($_REQUEST["dia_i"])?$_REQUEST["dia_i"]:date("d");
$mes_i     = isset($_REQUEST["mes_i"])?$_REQUEST["mes_i"]:date("m");
$ano_i     = isset($_REQUEST["ano_i"])?$_REQUEST["ano_i"]:date("Y");
$dia_t     = isset($_REQUEST["dia_t"])?$_REQUEST["dia_t"]:date("d");
$mes_t     = isset($_REQUEST["mes_t"])?$_REQUEST["mes_t"]:date("m");
$ano_t     = isset($_REQUEST["ano_t"])?$_REQUEST["ano_t"]:date("Y");
$cmborigen = isset($_REQUEST["cmborigen"])?$_REQUEST["cmborigen"]:"";
$cmbflujorestos = isset($_REQUEST["cmbflujorestos"])?$_REQUEST["cmbflujorestos"]:"";
$cmbrestos = isset($_REQUEST["cmbrestos"])?$_REQUEST["cmbrestos"]:"";

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
    <td align="center">PRODUCCI�N DIARIA DE RESTOS DE �NODOS</td>
  </tr>
  <tr class="ColorTabla02"> 
    <td align="center">FECHA:  <?php echo $dia_t.'/'.$mes_t.'/'.$ano_t ?></td>
  </tr>
</table>
<br>


<?php
	//$fecha_ter = $ano_t.'-'.$mes_t.'-'.$dia_t.' 23:59:00';	
	
	$fecha_ini =date("Y-m-d", mktime(1,0,0,$mes_t,$dia_t ,$ano_t));	
	$fecha_ter =date("Y-m-d", mktime(1,0,0,$mes_t,($dia_t +1),$ano_t));	
?>	


<?php
	$arreglo = array();
	
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
			if ($cmbrestos== "T") //Todos los subproducto de un proveedor.
			{
				$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2002 AND cod_subclase = ".$cmborigen;
				$rs = mysqli_query($link, $consulta);
				$row = mysqli_fetch_array($rs);
				$codigos = $row["valor_subclase1"].",".$row["valor_subclase2"].",".$row["valor_subclase3"];
			
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
	
	//Llena el arreglo con los flujos y subproductos
	while ($row1 = mysqli_fetch_array($rs1))
	{
		$arreglo[] = array($row1["flujo"], $row1["cod_producto"], $row1["cod_subproducto"]);
	}

	// Saca todos los movimientos de recepcion afectados.
	reset($arreglo);
	//while (list($clave, $valor) = each($arreglo)) // (0: flujo, 1: cod_producto, 2: cod_subproducto, 3: horno_inicial)
	foreach($arreglo as $clave=>$valor)
	{
	    $consulta_g = "SELECT distinct campo2 from sea_web.movimientos WHERE tipo_movimiento = 3 AND cod_producto = 19  AND cod_subproducto = ".$valor[2];
		$consulta_g = $consulta_g." AND flujo = ".$valor[0]."";

		$consulta_g = $consulta_g." AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
		$consulta_g = $consulta_g." and hora between '".$fecha_ini." 08:00:00' and '".$fecha_ter." 07:59:59' ORDER BY campo2 ASC";		
		
		//$consulta_g = $consulta_g." AND flujo = ".$valor[0]." AND fecha_movimiento = '".$fecha_ter."' order by campo2 ASC ";
	    
        $rs_g = mysqli_query($link, $consulta_g);
		
      	if($radio2 != "P")//radio peso 
	 	{	
			$consulta = "SELECT * FROM sea_web.movimientos WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto = ".$valor[2];
			$consulta = $consulta." AND flujo = ".$valor[0]."";
			//$consulta = $consulta." AND flujo = ".$valor[0]." AND fecha_movimiento = '".$fecha_ter."'";
			$consulta = $consulta." AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
			$consulta = $consulta." and hora between '".$fecha_ini." 08:00:00' and '".$fecha_ter." 07:59:59' ORDER BY hornada";		

			//$consulta = $consulta." ORDER BY hornada";
		}
		else
		{
		
			$consulta = "SELECT * FROM sea_web.movimientos WHERE tipo_movimiento = 3 AND cod_producto = 19";
			$consulta = $consulta." AND flujo = ".$valor[0]."";
			$consulta = $consulta." AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
			$consulta = $consulta." and hora between '".$fecha_ini." 08:00:00' and '".$fecha_ter." 07:59:59' ORDER BY hornada";		

			//$consulta = $consulta." AND flujo = ".$valor[0]." AND fecha_movimiento = '".$fecha_ter."'";
			//$consulta = $consulta." ORDER BY hornada";		
		}		
		$rs2 = mysqli_query($link, $consulta);
				
		if(mysqli_num_rows($rs2) != 0) //Si la Consulta devuelve datos.
		{
			echo '<table width="320" border="0" cellspacing="0" cellpadding="0" align="center">';
			echo '<tr class="ColorTabla01"><td><center>';
		
		    
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
			echo '</center></td></tr></table><br>';
       	   
		   $largo = 80 * 4; //Largo de la Tabla.
            
		   	echo '<table width="'.$largo.'"  border="0" cellspacing="0" cellpadding="0" align="center"><tr class="ColorTabla01">';
		    echo '<td width="80" align="center">NRO. GRUPO</td>';
		    echo '<td width="80" align="center">N&deg; HORNADA</td>';
		    echo '<td width="80"align="center">CANTIDAD</td>';
		    echo '<td width="80" align="center">PESO<br>KGS.</td></tr></table';

	   }
	 while($fila = mysqli_fetch_array($rs_g))
	 {
	    $grupo = $fila['campo2'];
		
      	if($radio2 != "P")//radio peso 
	 	{	
			$consulta = "SELECT distinct hornada,campo2 FROM movimientos";
			$consulta = $consulta." WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto = ".$valor[2]." AND flujo = ".$valor[0];
			$consulta = $consulta." AND campo2=".$grupo." ";		
			$consulta = $consulta." AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
			$consulta = $consulta." and hora between '".$fecha_ini." 08:00:00' and '".$fecha_ter." 07:59:59'";		

			//$consulta = $consulta." AND campo2=".$grupo." AND fecha_movimiento = '".$fecha_ter."'";		
		}
		else
		{
			$consulta = "SELECT distinct hornada,campo2 FROM movimientos";
			$consulta = $consulta." WHERE tipo_movimiento = 3 AND cod_producto = 19 AND flujo = ".$valor[0];
			$consulta = $consulta." AND campo2=".$grupo." ";		
			$consulta = $consulta." AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
			$consulta = $consulta." and hora between '".$fecha_ini." 08:00:00' and '".$fecha_ter." 07:59:59'";		

		}
		$rs2 = mysqli_query($link, $consulta);		

		if(mysqli_num_rows($rs2) != 0) //Si la Consulta devuelve datos.
		{

		//Crea el detalle.					
			echo '<table width="'.$largo.'" border="0" cellspacing="0" cellpadding="0" align = "center">'; 
			while ($row2 = mysqli_fetch_array($rs2))
			{												  

			    echo '<tr class="ColorTabla02"><td width="80"><center>'.$row2["campo2"].'</center></td>';
			    echo '<td width="80" align="center">'.substr($row2["hornada"],6,6).'</td>';
			    echo '<td width="80" align="center">';

				if($radio2 != "P")//radio peso 
				{	
					$consulta = "SELECT SUM(unidades) as unidades FROM movimientos";
					$consulta = $consulta." WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto = ".$valor[2]." AND flujo = ".$valor[0];
					$consulta = $consulta." AND campo2=".$grupo." AND hornada = '".$row2["hornada"]."'";
					$consulta = $consulta." AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
					$consulta = $consulta." and hora between '".$fecha_ini." 08:00:00' and '".$fecha_ter." 07:59:59'";		

					
					//$consulta = $consulta." AND campo2=".$grupo." AND hornada = $row2["hornada"] AND fecha_movimiento = '".$fecha_ter."'";
				}
				else
				{
					$consulta = "SELECT SUM(unidades) as unidades FROM movimientos";
					$consulta = $consulta." WHERE tipo_movimiento = 3 AND cod_producto = 19 AND flujo = ".$valor[0];
					$consulta = $consulta." AND campo2=".$grupo." AND hornada = '".$row2["hornada"]."' ";	
					$consulta = $consulta." AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
					$consulta = $consulta." and hora between '".$fecha_ini." 08:00:00' and '".$fecha_ter." 07:59:59'";		

								
				}
                $rs_u = mysqli_query($link, $consulta);
				if($row_u = mysqli_fetch_array($rs_u))
				{ 
					echo $row_u["unidades"].'</td>';
                }

			    echo '<td width="80" align="center">';

				if($radio2 != "P")//radio peso 
				{	
					$consulta = "SELECT SUM(peso) as peso FROM movimientos";
					$consulta = $consulta." WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto = ".$valor[2]." AND flujo = '".$valor[0]."'" ;
					$consulta = $consulta." AND campo2= '".$grupo."' AND hornada='".$row2["hornada"]."' ";
					$consulta = $consulta." AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
					$consulta = $consulta." and hora between '".$fecha_ini." 08:00:00' and '".$fecha_ter." 07:59:59'";		

				}
				else
				{
					$consulta = "SELECT SUM(peso) as peso FROM movimientos";
					$consulta = $consulta." WHERE tipo_movimiento = 3 AND cod_producto = 19 AND flujo = ".$valor[0];
					$consulta = $consulta." AND campo2=".$grupo." AND hornada = '".$row2["hornada"]."'";
					$consulta = $consulta." AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
					$consulta = $consulta." and hora between '".$fecha_ini." 08:00:00' and '".$fecha_ter." 07:59:59'";		

				}
				$rs_p = mysqli_query($link, $consulta);
				if($row_p = mysqli_fetch_array($rs_p))
				{ 
					 echo $row_p["peso"].'</td>';
				}
			}

	   }	
     			echo '</table>';


   }	  

		if(mysqli_num_rows($rs2) != 0) //Si la Consulta devuelve datos.
		{
			
			if($radio2 != "P")//radio peso 
			{	
				$consulta = "SELECT SUM(unidades) AS unid, SUM(peso) AS peso";
				$consulta = $consulta." FROM sea_web.movimientos";
				$consulta = $consulta." WHERE tipo_movimiento = 3 AND cod_producto = 19 AND cod_subproducto = ".$valor[2]." AND flujo = ".$valor[0];
				$consulta = $consulta." AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
				$consulta = $consulta." and hora between '".$fecha_ini." 08:00:00' and '".$fecha_ter." 07:59:59'";		

				//$consulta = $consulta." AND fecha_movimiento = '".$fecha_ter."'";
			}
			else
			{
				$consulta = "SELECT SUM(unidades) AS unid, SUM(peso) AS peso";
				$consulta = $consulta." FROM sea_web.movimientos";
				$consulta = $consulta." WHERE tipo_movimiento = 3 AND cod_producto = 19 AND flujo = ".$valor[0];
				$consulta = $consulta." AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."'";
				$consulta = $consulta." and hora between '".$fecha_ini." 08:00:00' and '".$fecha_ter." 07:59:59'";		

				//$consulta = $consulta." AND fecha_movimiento = '".$fecha_ter."'";			
			}			
			$rs3 = mysqli_query($link, $consulta);

			echo '<table width="'.$largo.'" border="0" cellspacing="0" cellpadding="0" align="center" class="Detalle02">';
           	echo '<tr><td width=160">'; 

     		if ($radio == "P")
		        echo 'TOTAL PRODUCTO</td>';
			else
				echo 'TOTAL FLUJO</td>';
			
			$row3 = mysqli_fetch_array($rs3);
			if (!is_null($row3["unid"]))					
			{  
                echo '<td width="80" align="center">'.$row3["unid"].'</td>';
                echo '<td width="80" align="center">'.$row3["peso"].'</td>';
			
            } 

     		echo '</tr></table><br>';
      }
   
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