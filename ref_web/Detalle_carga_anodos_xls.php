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
	
	include("../principal/conectar_ref_web.php");

	$dia    = isset($_REQUEST["dia"])?$_REQUEST["dia"]:date("d");
	$mes    = isset($_REQUEST["mes"])?$_REQUEST["mes"]:date("m");
	$ano    = isset($_REQUEST["ano"])?$_REQUEST["ano"]:date("Y");
	
	$fecha  = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
	$grupo  = isset($_REQUEST["grupo"])?$_REQUEST["grupo"]:"";
?>


<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
</head>

<body class="TablaPrincipal">
<form name="frmPoPup" method="post" action="">
  <table width="670" border="0" cellspacing="0" cellpadding="0" align="center" class="TablaDetalle">
    <tr class="ColorTabla01"> 
      <td colspan="5" align="center">Datos Ingresados</td>
    </tr>
    <tr> 
      <td colspan="5" align="center">&nbsp;</td>
    </tr>
    <tr class="ColorTabla02"> 
      <td width="46"><strong>Fecha: &nbsp;</strong></td>
      <td width="129"> 
        <?php
	  if(strlen($dia) == 1)
		 $dia="0".$dia;
	  if(strlen($mes) == 1)
		 $mes="0".$mes;
			
	   echo $fecha;
	   echo '<input type="hidden" name="ano" value="'.$ano.'">';
	   echo '<input type="hidden" name="mes" value="'.$mes.'">';
	   echo '<input type="hidden" name="dia" value="'.$dia.'">';
	   echo '<input type="hidden" name="fecha" value="'.$fecha.'">';
	   ?>
      </td>
      <td width="65"><strong>Grupo: &nbsp;</strong></td>
      <td width="55"> 
        <?php 
	  		echo $grupo;
			echo '<input type="hidden" name="grupo" value="'.$grupo.'">';
	  ?>
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="5" align="center">&nbsp;</td>
    </tr>
  </table>
  <br>
  <table width="670" border="1" cellspacing="0" cellpadding="0" align="center" class="TablaDetalle">
    <tr class="ColorTabla01"> 
      <td width="23%" align="center">Hornada</td>
      <td width="37%" align="center">Tipo</td>
      <td width="25%" align="center">Unidades</td>
      <td width="15%" align="center">Peso Unidades</td>
    </tr>
    <?php
	
	$Consulta = "SELECT * FROM sea_web.movimientos WHERE fecha_movimiento = '$fecha' AND campo2='".$grupo."' and cod_producto='17' ";
	$rs = mysqli_query($link, $Consulta);
	$unidades_t=0;
	$peso_t=0;
	while ($row = mysqli_fetch_array($rs))
	{
		 echo'<tr>'; 
		 	echo '<td align="center">'.$row["hornada"].'</td>';
			$consulta_tipo="select descripcion from proyecto_modernizacion.subproducto descripcion where cod_producto='17' and cod_subproducto='".$row["cod_subproducto"]."'";     
			$rs_tipo = mysqli_query($link, $consulta_tipo);
	        $row_tipo = mysqli_fetch_array($rs_tipo);
			echo '<td align="center">'.$row_tipo["descripcion"].'</td>';		
			echo '<td align="center">'.$row["unidades"].'</td>';
			echo '<input type="hidden" name="unidades" value="'.$row["unidades"].'">';
			echo '<td align="center">'.$row["peso"].'</td>';
			echo '<input type="hidden" name="peso" value="'.$row["peso"].'">';
       		echo '<input type="hidden" name="recup_menor" value="'.$row_tipo["descripcion"].'">';
    		echo'</tr>';			
				
			$unidades_t = $unidades_t + $row["unidades"];	
			$peso_t = $peso_t + $row["peso"];	
			
	}
		echo'<tr class="Detalle02">';
			echo'<td colspan="2">Totales</td>'; 
			echo'<td align="center">'.$unidades_t.'</td>'; 
			echo'<td align="center">'.$peso_t.'</td>'; 
			echo'<td align="center">&nbsp</td>'; 
			
		echo'</tr>';			

?>
  </table>
  <br>
</form>
</body>
</html>