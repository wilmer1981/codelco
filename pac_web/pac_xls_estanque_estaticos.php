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

	$CmbEK      = isset($_REQUEST["CmbEK"])?$_REQUEST["CmbEK"]:"";

?>
<html>
<head>
<title>Planta de &Aacute;cido</title>
</head>
<body>
<form name="FrmConsultaMov" action="" method="post">
  <table>
    <tr> 
      <td align="center">EK</td>
      <td align='center'>Fecha Movimiento Anterior</td>
      <td align='left'>Tipo Movimiento Anterior</td>
	  <td align='left'>Fecha Movimiento Siguiente</td>
      <td align='center'>Tipo Movimiento Siguiente</td>
	  <td align='center'>Dif.Dias</td>
    </tr>
    <?php
		if ($Mostrar=='S')
		{
			if ($CmbEK=='-1')
			{
				$Filtro='';
			}
			else
			{
				$Filtro= " and (cod_estanque_origen='".$CmbEK."' or cod_estanque_destino='".$CmbEK."')";
			}
			$FechaInicio=$CmbAno."-".$CmbMes."-".$CmbDias." 00:00:01";
			$FechaTermino=$CmbAnoT."-".$CmbMesT."-".$CmbDiasT." 23:59:59";
			$Consulta="select t1.fecha_hora,t1.tipo_movimiento,if(isnull(t1.cod_estanque_origen),t3.nombre_subclase,t2.nombre_subclase)as estanque from pac_web.movimientos t1 ";
			$Consulta=$Consulta." left join proyecto_modernizacion.sub_clase t2 on t2.cod_clase=9001 and t1.cod_estanque_origen = t2.cod_subclase ";
			$Consulta=$Consulta." left join proyecto_modernizacion.sub_clase t3 on t3.cod_clase=9001 and t1.cod_estanque_destino = t3.cod_subclase ";
			$Consulta=$Consulta." where fecha_hora between '".$FechaInicio."' and '".$FechaTermino."'".$Filtro." order by estanque,fecha_hora";
			$Respuesta=mysqli_query($link, $Consulta);
			$FechaAnt=0;
			while($Fila=mysqli_fetch_array($Respuesta))
			{
				$FechaReal=$Fila["fecha_hora"];
				$Consulta="select (DAYOFYEAR('".$FechaReal."')-DAYOFYEAR('".$FechaAnt."')) as difdia";
				$RespuestaDif=mysqli_query($link, $Consulta);
				$FilaDif=mysqli_fetch_array($RespuestaDif);
				if ((!is_null($FilaDif["difdia"]))&&($FilaDif["difdia"]>2))
				{
					$Consulta="select nombre_subclase as mov from proyecto_modernizacion.sub_clase where cod_clase=9000 and cod_subclase=".$MovAnt;
					$RespuestaMov=mysqli_query($link, $Consulta);
					$FilaMov=mysqli_fetch_array($RespuestaMov);
					$DescripMov1=$FilaMov["mov"];
					$Consulta="select nombre_subclase as mov from proyecto_modernizacion.sub_clase where cod_clase=9000 and cod_subclase=".$Fila["tipo_movimiento"];
					$RespuestaMov=mysqli_query($link, $Consulta);
					$FilaMov=mysqli_fetch_array($RespuestaMov);
					$DescripMov2=$FilaMov["mov"];
					echo "<tr>";
					echo "<td align='center'>".$Fila["estanque"]."</td>";
					echo "<td align='center'>".$Fecha2."</td>";
					echo "<td align='left'>".$DescripMov1."</td>";
					echo "<td align='center'>".$Fila["fecha_hora"]."</td>";
					echo "<td align='left'>".$DescripMov2."</td>";
					echo "<td align='right'>".$FilaDif["difdia"]."</td>";
					echo "</tr>";
				}
				$FechaAnt=$Fila["fecha_hora"];	
				$Fecha2=$Fila["fecha_hora"];
				$MovAnt=$Fila["tipo_movimiento"];
			}
		}				
	?>
  </table>		
</form>		
</body>
</html>
