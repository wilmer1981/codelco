<?php	        
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
	include("../principal/conectar_pac_web.php");

	$Mostrar = isset($_REQUEST["Mostrar"])?$_REQUEST["Mostrar"]:"";
	$CmbDias       = isset($_REQUEST["CmbDias"])?$_REQUEST["CmbDias"]:date("d");
	$CmbMes       = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:date("m");
	$CmbAno       = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:date("Y");
	$CmbDiasT      = isset($_REQUEST["CmbDiasT"])?$_REQUEST["CmbDiasT"]:date("d");
	$CmbMesT       = isset($_REQUEST["CmbMesT"])?$_REQUEST["CmbMesT"]:date("m");
	$CmbAnoT      = isset($_REQUEST["CmbAnoT"])?$_REQUEST["CmbAnoT"]:date("Y");

	$CmbEstado      = isset($_REQUEST["CmbEstado"])?$_REQUEST["CmbEstado"]:"";

?>
<html>
<head>
<title>Planta de &Aacute;cido</title>
</head>
<body>
<form name="FrmConsultaMov" action="" method="post">
  <table width='750' border="1">
    <tr> 
      <td align="center">Fecha</td>
      <td align='center'>Cantidad(Ton)</td>
      <td align='center'>Hora Inicio</td>
      <td align='center'>Hora Termino</td>
      <td align='center'>EK Origen</td>
      <td align='center'>EK Destino</td>
      <td align="left" >Operador</td>
	  <?php
	  	if ($CmbEstado=='-1')
		{
			echo "<td align='left'>Movimiento</td>";
		}
		else
		{
			echo "<td width='100' align='left'>&nbsp;</td>";
		}
	  ?>
    </tr>
    <?php
		if ($Mostrar=='S')
		{
			if ($CmbEstado=='-1')
			{
				$Filtro='';
			}
			else
			{
				$Filtro= " and t1.tipo_movimiento='".$CmbEstado."'";
			}
			$FechaInicio=$CmbAno."-".$CmbMes."-".$CmbDias." 00:00:01";
			$FechaTermino=$CmbAnoT."-".$CmbMesT."-".$CmbDiasT." 23:59:59";
			$Consulta="select t1.tipo_movimiento,t1.fecha_hora,t1.toneladas,t1.hora_inicio,t1.hora_final,t2.nombre_subclase as ek_origen,t3.nombre_subclase as ek_destino,t4.valor_subclase1 as operador,t5.nombre_subclase as movimiento ";
			$Consulta=$Consulta." from pac_web.movimientos t1 left join proyecto_modernizacion.sub_clase t2 on t2.cod_clase=9001 and t2.cod_subclase=t1.cod_estanque_origen";
			$Consulta=$Consulta." left join proyecto_modernizacion.sub_clase t3 on t3.cod_clase=9001 and t3.cod_subclase=t1.cod_estanque_destino ";
			$Consulta=$Consulta." left join proyecto_modernizacion.sub_clase t4 on t4.cod_clase=9002 and t4.nombre_subclase=t1.rut_funcionario ";
			$Consulta=$Consulta." left join proyecto_modernizacion.sub_clase t5 on t5.cod_clase=9000 and t5.cod_subclase=t1.tipo_movimiento where fecha_hora between '".$FechaInicio."' and '".$FechaTermino."'".$Filtro;
			$Respuesta=mysqli_query($link, $Consulta);
			$Total=0;
			while($Fila=mysqli_fetch_array($Respuesta))
			{
				echo "<tr>";
				echo "<td width='125' align='center'>".$Fila["fecha_hora"]."</td>";
				echo "<td align='center'>".$Fila["toneladas"]."</td>";
				echo "<td align='center'>".$Fila["hora_inicio"]."</td>";
				echo "<td align='center'>".$Fila["hora_final"]."</td>";
				echo "<td align='center'>".$Fila["ek_origen"]."</td>";
				echo "<td align='center'>".$Fila["ek_destino"]."</td>";
				echo "<td align='left'>".$Fila["operador"]."</td>";
			  	if ($CmbEstado=='-1')
				{
					echo "<td align='left'>".$Fila["movimiento"]."</td>";
				}
				else
				{
					echo "<td width='100' align='left'>&nbsp;</td>";
				}
				echo "</tr>";
				$Total=$Total+$Fila["toneladas"];
			}
			echo "<tr>";
			echo "<td>Total</td>";
			echo "<td>".number_format($Total,'2',',','.')."</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "</tr>";
		}				
	?>
  </table>		
</form>		
</body>
</html>
