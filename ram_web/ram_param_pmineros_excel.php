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
	$Destino     = isset($_REQUEST["Destino"])?$_REQUEST["Destino"]:"";
?>
<html>
<head>
<title>Sistema RAM</title>
</head>

<body leftmargin="3" topmargin="5">
        <br>        
		<table width="750"  border="1" cellpadding="3" cellspacing="0" class="TablaDetalle">              
<?php	
	$Consulta = "select distinct nodo ";
	$Consulta.= " from ram_web.flujo_rut ";
	$Consulta.= " order by nodo";	
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{
		//NOMBRE FLUJO
		$Consulta = "select distinct descripcion from proyecto_modernizacion.nodos ";
		$Consulta.= " where cod_nodo='".$Fila["nodo"]."' and sistema='RAM'";	
		$Resp3 = mysqli_query($link, $Consulta);
		if ($Fila3 = mysqli_fetch_array($Resp3))
			$NomNodo = $Fila3["descripcion"];
		else
			$NomNodo = "&nbsp;";
		echo "<tr class='ColorTabla01'><td colspan='11'>NODO:&nbsp;".$Fila["nodo"]." - ".$NomNodo."</td></tr>\n";
		echo "<tr class='ColorTabla01'>\n";
		echo "<td width='7%'>FLUJO</td>\n";
		echo "<td width='28%'>DESCRIPCION</td>\n";
		echo "<td width='7%'>PROD</td>\n";
		echo "<td width='10%'>SUBPROD</td>\n";
		echo "<td width='35%'>DESCRIPCION</td>\n";
		echo "<td width='35%'>RUT</td>\n";
		echo "<td width='35%'>PROVEEDOR</td>\n";
		echo "<td width='7%'>EXIST</td>\n";
		echo "<td width='7%'>DESCRIP</td>\n";
		echo "<td width='7%'>DESTINO</td>\n";
		echo "<td width='7%'>DESCRIP</td>\n";
		echo "</tr>\n";
		$Consulta = "select * ";
		$Consulta.= " from ram_web.flujo_rut ";
		$Consulta.= " where nodo='".$Fila["nodo"]."'";
		$Consulta.= " order by nodo, flujo, cod_producto, cod_subproducto";	
		$Resp2 = mysqli_query($link, $Consulta);
		while ($Fila2 = mysqli_fetch_array($Resp2))
		{	
			//NOMBRE SUBPROD.
			$Consulta = "select * from proyecto_modernizacion.subproducto ";
			$Consulta.= " where cod_producto='".$Fila2["cod_producto"]."' and cod_subproducto='".$Fila2["cod_subproducto"]."'";	
			$Resp3 = mysqli_query($link, $Consulta);
			if ($Fila3 = mysqli_fetch_array($Resp3))
				$NomSubProd = strtoupper($Fila3["descripcion"]);
			else
				$NomSubProd = "&nbsp;";
			//NOMBRE FLUJO
			$Consulta = "select distinct descripcion from proyecto_modernizacion.flujos ";
			$Consulta.= " where cod_flujo='".$Fila2["flujo"]."' and sistema='RAM'";	
			$Resp3 = mysqli_query($link, $Consulta);
			if ($Fila3 = mysqli_fetch_array($Resp3))
				$NomFlujo = strtoupper($Fila3["descripcion"]);
			else
				$NomFlujo = "&nbsp;";
			echo "<tr>\n";
			//$ValorRadio = $Fila2["cod_existencia"]."//".$Fila2["cod_producto"]."//".$Fila2["cod_subproducto"]."//".$Fila2["rut"]."//".$Fila2["destino"]."//".$Fila2["flujo"]."//".$Fila["nodo"];
			//echo "<td><input name='ChkFlujo' type='radio' value='".$ValorRadio."'></td>\n";
			echo "<td>".$Fila2["flujo"]."</td>\n";
			echo "<td>".$NomFlujo."</td>\n";
			echo "<td>".$Fila2["cod_producto"]."</td>\n";
			echo "<td>".$Fila2["cod_subproducto"]."</td>\n";
			echo "<td>".$NomSubProd."</td>\n";
			//PROVEEDOR
			$Consulta = "select * from ram_web.proveedor ";
			$Consulta.= " where rut_proveedor= '".$Fila2["rut"]."'";	
			$Resp3 = mysqli_query($link, $Consulta);
			if ($Fila3 = mysqli_fetch_array($Resp3))
				$NomProveedor = $Fila3["nombre"];
			else
				$NomProveedor = "&nbsp;";
			echo "<td>".$Fila2["rut"]."</td>\n";
			echo "<td>".$NomProveedor."</td>\n";
			//EXISTENCIA			
			$Consulta = "select * from ram_web.atributo_existencia ";
			$Consulta.= " where cod_existencia= '".$Fila2["cod_existencia"]."'";	
			$Resp3 = mysqli_query($link, $Consulta);
			if ($Fila3 = mysqli_fetch_array($Resp3))
				$NomExist = $Fila3["nombre_existencia"];
			else
				$NomExist = "&nbsp;";
			echo "<td>".$Fila2["cod_existencia"]."</td>\n";
			echo "<td>".$NomExist."</td>\n";
			//LUGAR DESTINO
			$Consulta = "select * from ram_web.tipo_lugar ";
			$Consulta.= " where cod_tipo_lugar = '".$Fila2["destino"]."'";	
			$Resp3 = mysqli_query($link, $Consulta);
			if ($Fila3 = mysqli_fetch_array($Resp3))
				$NomDestino = $Fila3["descripcion_lugar"];
			else
				$NomDestino = "&nbsp;";
			echo "<td>".$Fila2["destino"]."</td>\n";
			echo "<td>".$NomDestino."</td>\n";
			echo "</tr>\n";
		}
	}
?>		
      </table>
</body>
</html>
