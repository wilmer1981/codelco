<?php include("../principal/conectar_rec_web.php");

$cod_exist  = isset($_REQUEST["cod_exist"])?$_REQUEST["cod_exist"]:"";
$Conjunto   = isset($_REQUEST["Conjunto"])?$_REQUEST["Conjunto"]:"";
$Fecha      = isset($_REQUEST["Fecha"])?$_REQUEST["Fecha"]:"";
$Fecha_ini = isset($_REQUEST["Fecha_ini"])?$_REQUEST["Fecha_ini"]:"";
$Fecha_ter = isset($_REQUEST["Fecha_ter"])?$_REQUEST["Fecha_ter"]:"";
?>

<html>
<head>
<title>Detalle Conjunto</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">

function Imprimir()
{
	window.print();
}


</script>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
</head>

<body class="TablaPrincipal">
<form name="frmPoPup" method="post" action="">
  <div align="center"> 
    
  <table cellpadding="3" cellspacing="0" width="490" border="0" bordercolor="#b26c4a" class="TablaPrincipal" >
    <tr class="ColorTabla01"> 
      <td colspan="2" align="center"> 
        <?php	

		if($cod_exist == 2 || $cod_exist == 17)
			  echo "Recepción Conjunto";
		elseif($cod_exist == 21 || $cod_exist == 22)
		      echo "Validación";
		elseif($cod_exist == 5)
		      echo "Beneficio Directo";
		elseif($cod_exist == 15 || $cod_exist == 6)
		      echo "Traspaso Conjunto";
	  ?>
      </td>
    </tr>
    <tr> 
      <td width="108" height="26">N&uacute;mero Conjunto :</td>
      <td width="328"> <strong> 
        <?php
	     echo $Conjunto;
	  ?>
        </strong> </td>
    </tr>
  </table>
  <br>
  <table cellpadding="3" cellspacing="0" width="490" border="1" bordercolor="#b26c4a" class="TablaPrincipal" >
  	<tr class="ColorTabla01">

  <?php
	if($cod_exist == 2)
	{
	  echo'
  	    <tr class="ColorTabla01">
        <td width="70" align="center">Fecha</td>
	    <td width="120" align="center">Guia</td>
	    <td width="53" align="center">Patente</td>
	    <td width="44" align="center">Lote</td>
	    <td width="45" align="center">Recargo</td>
	    <td width="44" align="center">Peso</td>';
    }
	elseif($cod_exist == 21 || $cod_exist == 22)
	{
	echo'
		<td width="71" align="center">Fecha</td>	
		<td width="56" align="center">Cod Exist</td>	
		<td width="63" align="center">Conj. Dest</td>
		<td width="68" align="center">Lugar Dest.</td>
		<td width="50" align="center">Peso </td>';	
	}		

	elseif($cod_exist == 6 || $cod_exist == 5 || $cod_exist == 15)
	{
	echo'
		<td width="50" align="center">Fecha</td>	
		<td width="56" align="center">Cod Exist</td>	
		<td width="63" align="center">Conj. Dest</td>
		<td width="68" align="center">Lugar Dest.</td>
		<td width="40" align="center">Peso </td>	
		<td width="40" align="center">Val. </td>';	
	}		

	elseif($cod_exist == 17)
	{
	echo'
		<td width="120" align="center">Fecha</td>	
		<td width="80" align="center">Cod Exist</td>	
		<td width="80" align="center">Conj. Origen</td>
		<td width="80" align="center">Peso </td>';	
	}		

	elseif($cod_exist == 11)
	{
	echo'
		<td width="50" align="center">Fecha</td>	
		<td width="56" align="center">Cod Exist</td>	
		<td width="63" align="center">Conj. Orig.</td>
		<td width="64" align="center">Lugar Dest.</td>
		<td width="40" align="center">Peso </td>	
		<td width="40" align="center">Val. </td>';	
	}		

  ?>		
	</tr>
  <?php
	if($cod_exist == 2)
	{
		$Consulta = "SELECT * ";
		$Consulta.= " FROM sipa_web.recepciones ";
		$Consulta.= " WHERE FECHA = '".$Fecha."' ";
		$Consulta.= " AND CONJUNTO = '".$Conjunto."' ORDER BY LOTE,RECARGO ";
		$rs = mysqli_query($link, $Consulta);
		$Peso_Total=0;
		while($row = mysqli_fetch_array($rs))
		{
			echo'<tr>';
			echo'<td align="center">'.$row["fecha"].'</td>';
			echo'<td align="center">'.$row["guia_despacho"].'</td>';
			echo'<td align="center">'.$row["patente"].'</td>';
			echo'<td align="center">'.$row["lote"].'</td>';
			echo'<td align="center">'.$row["recargo"].'</td>';
			echo'<td align="center">'.number_format($row["peso_neto"],0,",",".").'</td>';
			echo'</tr>';
			$Peso_Total = $Peso_Total + $row["peso_neto"];
		}

		echo '<tr class="ColorTabla02">';
			echo '<td colspan="5"><strong>Total</strong></td>';
			echo '<td align="center">'.number_format($Peso_Total,0,",",".").'</td>';
		echo '</tr>';
	}

    
	if($cod_exist == 6 || $cod_exist == 5 || $cod_exist == 15)
	{
		if($cod_exist == 5)
			$Consulta = "SELECT * FROM ram_web.movimiento_conjunto WHERE fecha_movimiento BETWEEN '$Fecha_ini' AND '$Fecha_ter' AND (cod_existencia = '06' OR cod_existencia = 16 OR cod_existencia = '05') AND num_conjunto = $Conjunto";
			
		if($cod_exist == 6)
			$Consulta = "SELECT * FROM ram_web.movimiento_conjunto WHERE fecha_movimiento BETWEEN '$Fecha_ini' AND '$Fecha_ter' AND (cod_existencia = '06' OR cod_existencia = 16 OR cod_existencia = 15) AND num_conjunto = $Conjunto";

		if($cod_exist == 15)
			$Consulta = "SELECT * FROM ram_web.movimiento_conjunto WHERE fecha_movimiento BETWEEN '$Fecha_ini' AND '$Fecha_ter' AND cod_existencia = 15 AND num_conjunto = $Conjunto";
		//echo $Consulta;
		$rs = mysqli_query($link, $Consulta);
		$Peso_Total=0;
		while($row = mysqli_fetch_array($rs))
		{
			echo'<tr>';
			echo'<td align="center">'.$row["fecha_movimiento"].'</td>';
			echo'<td align="center">'.$row["cod_existencia"].'</td>';
			echo'<td align="center">'.$row["conjunto_destino"].'</td>';
			echo'<td align="center">'.$row["lugar_destino"].'</td>';
			$peso = $row["peso_humedo_movido"] + $row["estado_validacion"];
			echo'<td align="center">'.number_format($row["peso_humedo_movido"],0,",",".").'</td>';
			echo'<td align="center">'.$row["estado_validacion"].'</td>';
			echo'</tr>';
			$Peso_Total = $Peso_Total + $row["peso_humedo_movido"] + $row["estado_validacion"];
		}


		echo '<tr class="ColorTabla02">';
			echo '<td colspan="4"><strong>Total</strong></td>';
			echo '<td align="center" colspan="2">'.number_format($Peso_Total,0,",",".").'</td>';
		echo '</tr>';
	}

	if($cod_exist == 11)
	{
		$Consulta = "SELECT * FROM ram_web.movimiento_conjunto WHERE fecha_movimiento BETWEEN '$Fecha_ini' AND '$Fecha_ter' AND (cod_existencia = '06' OR cod_existencia = '05') AND conjunto_destino = $Conjunto";
		$rs = mysqli_query($link, $Consulta);
		$Peso_Total=0;
		while($row = mysqli_fetch_array($rs))
		{
			echo'<tr>';
			echo'<td align="center">'.$row["fecha_movimiento"].'</td>';
			echo'<td align="center">'.$row["cod_existencia"].'</td>';
			echo'<td align="center">'.$row["num_conjunto"].'</td>';
			echo'<td align="center">'.$row["lugar_destino"].'</td>';
			$peso = $row["peso_humedo_movido"] + $row["estado_validacion"];
			echo'<td align="center">'.number_format($row["peso_humedo_movido"],0,",",".").'</td>';
			echo'<td align="center">'.$row["estado_validacion"].'</td>';
			echo'</tr>';
			$Peso_Total = $Peso_Total + $row["peso_humedo_movido"] + $row["estado_validacion"];
		}


		echo '<tr class="ColorTabla02">';
			echo '<td colspan="4"><strong>Total</strong></td>';
			echo '<td align="center" colspan="2">'.number_format($Peso_Total,0,",",".").'</td>';
		echo '</tr>';
	}
	
	if($cod_exist == 17)
	{
		if(strlen($dia) == 1)
		$dia = '0'.$dia;

		if(strlen($mes) == 1)
			$mes = '0'.$mes;
	
		$fecha_ini = $ano.'-'.$mes.'-'.$dia.' 00:00:00';
		$fecha_ter = $ano.'-'.$mes.'-'.$dia.' 23:59:59';

		$fecha_i = $ano.'-'.$mes.'-'.$dia.' 08:00:00';
		$fecha_t = date("Y-m-d",mktime(7,59,59,$mes,($dia + 1),$ano))." 07:59:59";

		$Consulta = "SELECT * FROM ram_web.movimiento_conjunto WHERE (( num_conjunto = $Conjunto  AND cod_existencia = 2 AND fecha_movimiento BETWEEN '$fecha_i' AND '$fecha_t')
		OR (conjunto_destino = $Conjunto AND cod_existencia = 15 AND fecha_movimiento BETWEEN '$fecha_i' AND '$fecha_t'))";
		$rs = mysqli_query($link, $Consulta);
		$Peso_Total=0;
		while($row = mysqli_fetch_array($rs))
		{
			echo'<tr>';
			echo'<td align="center">'.$row["fecha_movimiento"].'</td>';
			echo'<td align="center">'.$row["cod_existencia"].'</td>';
			echo'<td align="center">'.$row["num_conjunto"].'</td>';
			$peso = $row["peso_humedo_movido"] + $row["estado_validacion"];
			echo'<td align="center">'.number_format($peso,0,",",".").'</td>';
			echo'</tr>';
			$Peso_Total = $Peso_Total + $row["peso_humedo_movido"] + $row["estado_validacion"];
		}


		echo '<tr class="ColorTabla02">';
			echo '<td colspan="3"><strong>Total</strong></td>';
			echo '<td align="center">'.number_format($Peso_Total,0,",",".").'</td>';
		echo '</tr>';
	}	

	//validaciones
	if($cod_exist == 21 || $cod_exist == 22)
	{
		if($cod_exist == 21)
			$Consulta = "SELECT * FROM ram_web.movimiento_conjunto WHERE fecha_movimiento BETWEEN '$Fecha_ini' AND '$Fecha_ter' AND (cod_existencia = '06' OR cod_existencia = 16 OR cod_existencia = '05') AND num_conjunto = $Conjunto AND estado_validacion <> 0";

		if($cod_exist == 22)
			$Consulta = "SELECT * FROM ram_web.movimiento_conjunto WHERE fecha_movimiento BETWEEN '$Fecha_ini' AND '$Fecha_ter' AND (cod_existencia = '06' OR cod_existencia = 15 OR cod_existencia = '05') AND num_conjunto = $Conjunto AND estado_validacion <> 0";

//		echo $Consulta
		$rs = mysqli_query($link, $Consulta);
		$Peso_Total=0;
		while($row = mysqli_fetch_array($rs))
		{
			echo'<tr>';
			echo'<td align="center">'.$row["fecha_movimiento"].'</td>';
			echo'<td align="center">'.$row["cod_existencia"].'</td>';
			echo'<td align="center">'.$row["conjunto_destino"].'</td>';
			echo'<td align="center">'.$row["lugar_destino"].'</td>';
			echo'<td align="center">'.$row["estado_validacion"].'</td>';
			echo'</tr>';
			$Peso_Total = $Peso_Total + $row["estado_validacion"];
		}


		echo '<tr class="ColorTabla02">';
			echo '<td colspan="4"><strong>Total</strong></td>';
			echo '<td align="center">'.number_format($Peso_Total,0,",",".").'</td>';
		echo '</tr>';
	}	
	
  ?>	
  </table>
	<p><p>
	<p><p>
    <table cellpadding="3" cellspacing="0" width="500" border="0" align="center">
      <tr>
        <td> <div align="center"> 
            <input name="btnimprimir" type="button" style="width:70;" value="Imprimir" onClick="JavaScript:Imprimir()"> 
            <input name="btnsalir" type="button" style="width:100" value="Cerrar Ventana" onClick="self.close()">
        	</div>
		</td>
      </tr>
    </table>
  </div>
</form>
</body>
</html>
<?php include("../principal/cerrar_rec_web.php") ?>
