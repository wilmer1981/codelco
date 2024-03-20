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

	$Proceso  = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$CmbEstanque  = isset($_REQUEST["CmbEstanque"])?$_REQUEST["CmbEstanque"]:"";
	$AnoIni       = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:"";
	$MesIni       = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:"";
	$AnoFin       = isset($_REQUEST["AnoFin"])?$_REQUEST["AnoFin"]:"";
	$MesFin       = isset($_REQUEST["MesFin"])?$_REQUEST["MesFin"]:"";
?>
<html>
<head>
<title>Planta de &Aacute;cido</title>
</head>
<body>
<form name="FrmVidaEK" action="" method="post">
  <table width='750'>
    <tr> 
      <td align='center'>MES</td>
      <td align='center'>A&Ntilde;O</td>
      <td align='center'>EK</td>
      <td align='right'>Stock-Inicial</td>
      <td align='right'>Recepcion</td>
      <td align='right'>Envio</td>
	  <td align='right'>Signo</td>
      <td align='right'>Ajustes</td>
      <td align='right'>Stock-Actual</td>
    </tr>
    <?php			
		if ($CmbEstanque=='-1')
		{
			$Filtro='';
		}
		else
		{
			$Filtro=" and t1.cod_estanque='".$CmbEstanque."'";		
		}
		$Consulta = "SELECT count(*) as TotalRegistro ";
		$Consulta.= " from pac_web.stock_estanques t1 left join proyecto_modernizacion.sub_clase t2 on ";
		$Consulta.= " t2.cod_clase = 9001 and t1.cod_estanque=t2.cod_subclase ";
		$Consulta.= " where (YEAR(t1.fecha) >= '".$AnoIni."' and YEAR(t1.fecha) <= '".$AnoFin."') ";
		$Consulta.= " and (MONTH(t1.fecha) >= '".$MesIni."' and MONTH(t1.fecha) <= '".$MesFin."')";
		$Respuesta=mysqli_query($link, $Consulta);
		$Fila=mysqli_fetch_array($Respuesta);
		if ($Fila["TotalRegistro"] > 0 )
		{
			$FechaDesde=$Ano."-".$Mes."-01 00:00:01";
			$FechaHasta=$Ano."-".$Mes."-31 23:59:59";
			$Consulta = "SELECT YEAR(t1.fecha) ano,MONTH(t1.fecha) mes,t1.cod_estanque,t1.stock_inicial,t1.stock_actual, t1.ajuste, t1.signo, t1.envio,t1.recepcion, t2.nombre_subclase from pac_web.stock_estanques t1";
			$Consulta.= " LEFT JOIN proyecto_modernizacion.sub_clase t2 ON t2.cod_clase = 9001 and t1.cod_estanque=t2.cod_subclase ";
			$Consulta.= " WHERE ((YEAR(t1.fecha) >= '".$AnoIni."' and (YEAR(t1.fecha) <= '".$AnoFin."') ";
			$Consulta.= " and (MONTH(t1.fecha) >= '".$MesIni."' and MONTH(t1.fecha) <= '".$MesFin."')";
			$Consulta.= " and t2.cod_subclase <> '5' ".$Filtro." order by ano, mes, t1.cod_estanque";
			$Respuesta=mysqli_query($link, $Consulta);
			while($Fila=mysqli_fetch_array($Respuesta))
			{
				echo "<tr>";
				echo "<td align='center'>".$Fila["mes"]."</td>";
				echo "<td align='center'>".$Fila["ano"]."</td>";
				echo "<td align='center'>".$Fila["nombre_subclase"]."</td>";
				echo "<td align='right'>".$Fila["stock_inicial"]."</td>";
				echo "<td align='right'>".$Fila["recepcion"]."</td>";
				echo "<td align='right'>".$Fila["envio"]."</td>";
				echo "<td align='right'>".$Fila["signo"]."</td>";
				echo "<td align='right'>".$Fila["ajuste"]."</td>";
				echo "<td align='right'>".$Fila["stock_actual"]."</td>";
				echo "</tr>";
			}	
		}
	?>
  </table>		
</form>		
</body>
</html>
