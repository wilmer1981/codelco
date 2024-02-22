<?php 
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
	<td align="center">Minutos Desconexion</td>
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
		$consulta_dif_dia="select ifnull(hour(PERIOD_DIFF(t1.fecha_conexion,t1.fecha_desconexion)),0) as dif_dia, ";
		$consulta_dif_dia.="hour(right(t1.fecha_conexion,8)) as hora_c2,hour(right(t1.fecha_desconexion,8)) as hora_d2 , ";
		$consulta_dif_dia.="minute(right(t1.fecha_conexion,8)) as minuto_c2,minute(right(t1.fecha_desconexion,8)) as minuto_d2 ";
        $consulta_dif_dia.="from sec_web.cortes_refineria as t1 ";
        $consulta_dif_dia.="where t1.fecha_desconexion= '".$row[fecha_desconexion]."' and t1.cod_grupo='".$row["cod_grupo"]."' ";
		$rs_dif_dia = mysqli_query($link, $consulta_dif_dia);
		$row_dd = mysqli_fetch_array($rs_dif_dia);
		if (abs($row_dd[dif_dia])<=1)
		   {
		     $resta_minuto=$row_dd[minuto_c2] - $row_dd[minuto_d2];
			 if ($resta_minuto >=0)
			     {
				    $resta_minuto=abs($row_dd[minuto_c2] - $row_dd[minuto_d2]);
					$resta_hora=abs($row_dd[hora_c2] - $row_dd[hora_d2]);
					$total_desconexion=($resta_hora*60)+ $resta_minuto;
					echo '<td width="89" align="center">'.$total_desconexion.'&nbsp</td>';
				 }
			     else{$resta_minuto=abs($row_dd[minuto_c2] - $row_dd[minuto_d2]);
					  $resta_hora=abs($row_dd[hora_c2] - $row_dd[hora_d2]);
					  $total_desconexion=(($resta_hora)*60)- $resta_minuto;
					  echo '<td width="89" align="center">'.$total_desconexion.'&nbsp</td>';} 	 
				
			   }
			   else  {
			           $resta_minuto=$row_dd[minuto_c2] - $row_dd[minuto_d2];
					   if ($resta_minuto >=0)
				         {
						   $resta_hora12=24-($row_dd[hora_d2]);
						   $resta_hora00=$row_dd[hora_c2];
						   $resta_minuto=abs($row_dd[minuto_c2] - $row_dd[minuto_d2]);
						   $resta_hora=$resta_hora12+$resta_hora00;
						   $total_desconexion=($resta_hora*60)+$resta_minuto;
						   echo '<td width="89" align="center">'.$total_desconexion.'&nbsp</td>'; 	 
					 
					    }
						else { $resta_hora12=24-($row_dd[hora_d2]);
						       $resta_hora00=$row_dd[hora_c2];
						       $resta_minuto=abs($row_dd[minuto_c2] - $row_dd[minuto_d2]);
							   $total_desconexion=(($resta_hora-1)*60)+ $resta_minuto;
							   echo '<td width="89" align="center">'.$total_desconexion.'&nbsp</td>'; 	 
							 } 
			         }
					
			echo '</tr>';
		
	}
?>
</table>
</body>
</html>
<?php include("../principal/cerrar_sec_web.php"); ?>