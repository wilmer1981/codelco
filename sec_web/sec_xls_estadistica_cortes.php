<?php 
	        ob_end_clean();
        $file_name=basename($_SERVER['PHP_SELF']).".xls";
        $userBrowser = $_SERVER['HTTP_USER_AGENT'];
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
	
	include("../principal/conectar_sec_web.php");
	
	function FormatoFecha($f)
	{
		$fecha = substr($f,8,2)."/".substr($f,5,2)."/".substr($f,0,4)."  ".substr($f,11,2).":".substr($f,14,2);
		return $fecha;
	}
?>
<html>
<head></head>
<body>
<table width="600" border="0" cellspacing="0" cellpadding="2">
  <tr> 
    <td align="center" colspan="6"><strong>INFORME DIGITACION BOLETAS DE CORTES</strong></td>
  </tr>
  <tr> 
    <td colspan="6" align="center"><strong>PERIODO:&nbsp; 
      <?php 
	printf("%02d",$dia1);
	echo "/";
	printf("%02d",$mes1);
	echo "/".$ano1." AL ";
	printf("%02d",$dia2);
	echo "/";
	printf("%02d",$mes2);	 
	echo "/".$ano2;		
	
?>
      </strong></td>
  </tr>
</table>
<br>

<table width="600" border="1" cellspacing="0" cellpadding="0">
  <tr> 
    <td align="center">Grupo</td>
    <td align="center">Tipo Desconexion</td>
    <td align="center">Fecha y Hora Desconexion</td>
    <td align="center">Kah dir d.</td>
    <td align="center">Fecha y Hora Conexion</td>
    <td align="center">Kah dir c.</td>
  </tr>
</table>

<table width="600" border="1" cellspacing="0" cellpadding="0">
<?php
	$desde = $ano1.'-';
	if (strlen($mes1) == 1)
		$desde = $desde.'0';
	$desde = $desde.$mes1.'-';
	if (strlen($dia1) == 1)
		$desde = $desde.'0';
	$desde = $desde.$dia1;

	$hasta = $ano2.'-';
	if (strlen($mes2) == 1)
		$hasta = $hasta.'0';
	$hasta = $hasta.$mes2.'-';
	if (strlen($dia2) == 1)
		$hasta = $hasta.'0';
	$hasta = $hasta.$dia2;						

	$consulta = "SELECT * FROM sec_web.cortes_refineria AS t1";
	$consulta = $consulta." INNER JOIN proyecto_modernizacion.sub_clase AS t2";
	$consulta = $consulta." ON t1.tipo_desconexion = t2.valor_subclase1";
	$consulta = $consulta." WHERE t2.cod_clase = 3000";
	$consulta = $consulta." AND t1.fecha_desconexion BETWEEN '".$desde." 00:00:00' AND '".$hasta." 23:59:59'";
	$consulta = $consulta." ORDER BY t1.fecha_desconexion DESC";
	$rs = mysqli_query($link, $consulta);
	
	while ($row = mysqli_fetch_array($rs))
	{		
		echo '<tr>';
		echo '<td width="54" align="center">'.$row["cod_grupo"].'</td>';
		echo '<td width="82" align="center">'.$row["nombre_subclase"].'</td>';			
		echo '<td width="166" align="center">'.FormatoFecha($row[fecha_desconexion]).'</td>';
		echo '<td width="95" align="center">'.$row[kahdird].'</td>';
		echo '<td width="165" align="center">'.FormatoFecha($row[fecha_conexion]).'</td>';
		echo '<td width="89" align="center">'.$row[kahdirc].'</td>';
		echo '</tr>';
	}
?>
</table>
</body>
</html>
<?php include("../principal/cerrar_sec_web.php"); ?>