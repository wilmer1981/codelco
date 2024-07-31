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
	include("../principal/conectar_principal.php");
	$Nodo        = isset($_REQUEST["Nodo"])?$_REQUEST["Nodo"]:"";
	$Flujo       = isset($_REQUEST["Flujo"])?$_REQUEST["Flujo"]:"";
	$Producto    = isset($_REQUEST["Producto"])?$_REQUEST["Producto"]:"";
	$SubProducto = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";
	$Rut         = isset($_REQUEST["Rut"])?$_REQUEST["Rut"]:"";
	$Tipo        = isset($_REQUEST["Tipo"])?$_REQUEST["Tipo"]:"";
?>
<html>
<head>
<title>Sistema RAM</title>
</head>

<body leftmargin="3" topmargin="5">
  <br>
        <br>        
		<table width="600"  border="1" cellpadding="3" cellspacing="0" class="TablaDetalle">              
<?php	
	$Consulta = "select distinct nodo ";
	$Consulta.= " from ram_web.param_circulante ";
	$Consulta.= " order by nodo";	
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{		
		//NOMBRE FLUJO
		$Consulta = "select distinct descripcion from proyecto_modernizacion.nodos ";
		$Consulta.= " where cod_nodo='".$Fila["nodo"]."' and sistema='CIR'";	
		$Resp3 = mysqli_query($link, $Consulta);
		if ($Fila3 = mysqli_fetch_array($Resp3))
			$NomNodo = $Fila3["descripcion"];
		else
			$NomNodo = "&nbsp;";
		echo "<tr class='ColorTabla01'><td colspan='6'>NODO:&nbsp;".$Fila["nodo"]." - ".$NomNodo."</td></tr>\n";
		echo "<tr class='ColorTabla01'>\n";
		echo "<td width='7%'>FLUJO</td>\n";
		echo "<td width='28%'>DESCRIPCION</td>\n";
		echo "<td width='7%'>PROD</td>\n";
		echo "<td width='10%'>SUBPROD</td>\n";
		echo "<td width='35%'>DESCRIPCION</td>\n";
		echo "<td width='7%'>TIPO </td>\n";
		echo "</tr>\n";
		$Consulta = "select * ";
		$Consulta.= " from ram_web.param_circulante ";
		$Consulta.= " where nodo='".$Fila["nodo"]."'";
		$Consulta.= " order by nodo, flujo, cod_producto, cod_subproducto, tipo_movimiento";	
		$Resp2 = mysqli_query($link, $Consulta);
		while ($Fila2 = mysqli_fetch_array($Resp2))
		{	
			//NOMBRE SUBPROD.
			$Consulta = "select * from proyecto_modernizacion.subproducto ";
			$Consulta.= " where cod_producto='".$Fila2["cod_producto"]."' and cod_subproducto='".$Fila2["cod_subproducto"]."'";	
			$Resp3 = mysqli_query($link, $Consulta);
			if ($Fila3 = mysqli_fetch_array($Resp3))
				$NomSubProd = $Fila3["descripcion"];
			else
				$NomSubProd = "&nbsp;";
			//NOMBRE FLUJO
			$Consulta = "select distinct descripcion from proyecto_modernizacion.flujos ";
			$Consulta.= " where cod_flujo='".$Fila2["flujo"]."' and sistema='CIR'";	
			$Resp3 = mysqli_query($link, $Consulta);
			if ($Fila3 = mysqli_fetch_array($Resp3))
				$NomFlujo = $Fila3["descripcion"];
			else
				$NomFlujo = "&nbsp;";
			echo "<tr>\n";
			echo "<td>".$Fila2["flujo"]."</td>\n";
			echo "<td>".strtoupper($NomFlujo)."</td>\n";
			echo "<td>".$Fila2["cod_producto"]."</td>\n";
			echo "<td>".$Fila2["cod_subproducto"]."</td>\n";
			echo "<td>".strtoupper($NomSubProd)."</td>\n";
			echo "<td>".$Fila2["tipo_movimiento"]."</td>\n";
			echo "</tr>\n";
		}
	}
?>		
      </table>
</body>
</html>
