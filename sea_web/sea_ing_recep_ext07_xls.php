<?php 
	include("../principal/conectar_principal.php");
	        ob_end_clean();
        $file_name=basename($_SERVER['PHP_SELF']).".xls";
        $userBrowser = $_SERVER['HTTP_USER_AGENT'];
		$filename="";
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

	  if(isset($_REQUEST["Proceso"])) {
		$Proceso = $_REQUEST["Proceso"];
	}else{
		$Proceso =  "";
	}
	if(isset($_REQUEST["cmbproductos"])) {
		$cmbproductos = $_REQUEST["cmbproductos"];
	}else{
		$cmbproductos =  "";
	}
	if(isset($_REQUEST["Todos"])) {
		$Todos = $_REQUEST["Todos"];
	}else{
		$Todos =  "";
	}

	if(isset($_REQUEST["TxtFechaIni"])) {
		$TxtFechaIni = $_REQUEST["TxtFechaIni"];
	}else{
		$TxtFechaIni = date("Y-m-d");
	}
	if(isset($_REQUEST["TxtFechaFin"])) {
		$TxtFechaFin = $_REQUEST["TxtFechaFin"];
	}else{
		$TxtFechaFin = date("Y-m-d");
	}


?>

<html>
<head>
<title>Recepci�n de Productos Externos Excel</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
</head>
<body>
<form name="frmPoPup" method="post" action="">
<?php
if($cmbproductos =="-1")
	$Todos = "S";

if($Proceso == "B")
{
	
	echo'<div align="center"><table cellpadding="3" cellspacing="0" width="630" border="1" bordercolor="#b26c4a" class="TablaPrincipal" align="center">
      	<tr class="ColorTabla02"> 
        	<td colspan="9"><div align="center"><strong>Recepci�n de Productos de Terceros</strong></div></td>
      	</tr>
		</table><br>';
}
if(($Todos == "S" || $cmbproductos == "2") && $Proceso =="B")
{
	$cmbproductos = "2";
	$total_unidades = 0;
	$total_peso = 0;
	echo'<div align="center"><table cellpadding="0" cellspacing="0"  width="630" border="1" bordercolor="#b26c4a" class="TablaPrincipal" align="center">
    <tr class="ColorTabla02"><td colspan="9"><div align="center">�nodos Teniente</div></td></tr>
    <tr class="ColorTabla01"> 
        <td><div align="center">Guia</div></td>
		<td><div align="center">Lote Origen</div></td>
        <td><div align="center">Lote Ventana</div></td>
        <td><div align="center">Marca</div></td>
        <td><div align="center">Peso Origen</div></td>
        <td><div align="center">Peso Recep.</div></td>
        <td><div align="center">Piezas Origen</div></td>
		<td><div align="center">Piezas Recep.</div></td>
		<td><div align="center">Estado Guia</div></td>
    </tr>';
    //$fecha = $ano.'-'.$mes.'-'.$dia;
	$Consulta="SELECT * from sea_web.recepcion_externa where fecha between '".$TxtFechaIni."' and '".$TxtFechaFin."'";
	$RespGuias=mysqli_query($link, $Consulta);
	while($FilaGuias=mysqli_fetch_array($RespGuias))
	{
		echo "<tr>";
		echo "<td align='center'>".$FilaGuias["guia"]."</td>";
		echo "<td align='center'>".$FilaGuias["lote_origen"]."</td>";
		echo "<td align='center'>".$FilaGuias["lote_ventana"]."</td>";
		echo "<td align='center'>".$FilaGuias["marca"]."</td>";
		echo "<td align='right'>".number_format($FilaGuias["peso"],0,'','.')."</td>";
		echo "<td align='right'>".number_format($FilaGuias["peso_recep"],0,'','.')."</td>";
		echo "<td align='right'>".number_format($FilaGuias["piezas"],0,'','.')."</td>";
		echo "<td align='right'>".number_format($FilaGuias["piezas_recep"],0,'','.')."</td>";
		if(($FilaGuias["estado"]=='C') || ($FilaGuias["estado"]!='X' && intval($FilaGuias["peso"])==intval($FilaGuias["peso_recep"])))
		{
			echo "<td align='center'>C</td>";
			$total_unidades = $total_unidades+$FilaGuias["peso_recep"];
			$total_peso = $total_peso+$FilaGuias["piezas_recep"];
		}	
		else
			if($FilaGuias["estado"]=='X')
				echo "<td align='center'>Anulada</td>";
			else
				echo "<td align='center'>A</td>";
		echo "</tr>";
	}
    echo'<tr>'; 
      		echo'<td colspan="5"><strong>TOTAL ACUMULADO</strong></td>';
      		echo'<td><div align="right">'.number_format($total_unidades,0,'','.').'</div></td>';
			echo'<td><div align="center">&nbsp;</div></td>';
      		echo'<td><div align="right">'.number_format($total_peso,0,'','.').'</div></td>';
			echo'<td><div align="center">&nbsp;</div></td>';
    echo'</tr>
	</table></div><br>';  
}
?>
</form>
</body>
</html>
<?php include("../principal/cerrar_sea_web.php") ?>
