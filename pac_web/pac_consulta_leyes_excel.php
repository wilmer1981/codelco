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

	$Buscar = isset($_REQUEST["Buscar"])?$_REQUEST["Buscar"]:"";
	$CmbMes       = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:date("m");
	$CmbAno       = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:date("Y");

	$CmbOpcion  = isset($_REQUEST["CmbOpcion"])?$_REQUEST["CmbOpcion"]:"";
	$CmbEK      = isset($_REQUEST["CmbEK"])?$_REQUEST["CmbEK"]:"";
	$Leyes      = isset($_REQUEST["Leyes"])?$_REQUEST["Leyes"]:"";

?>
<html>
<head>
<title>Consulta Leyes Excel</title>
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmLeyes" method="post" action="" >
 <?php
    echo "<table width='740' border='1' cellpadding='0' cellspacing='0'align='center'>";
    echo "<tr>";
	echo "<td align='center'>EK</td>";
	echo "<td align='center'>Fecha</td>";
	echo "<td align='center'>Descripcion</td>";
	echo "<td align='center'>Valor</td>";
	echo "<td align='center'>Unidad</td>";
	echo "</tr>";
	if ($Buscar=='S')
	{
		$FechaInicio=$CmbAno."-".$CmbMes."-01";
		$FechaTermino=$CmbAno."-".$CmbMes."-31";
		$Consulta="select t1.correlativo,t4.nombre_subclase as estanque,t2.abreviatura as cod_ley,t1.fecha,t1.valor,t2.nombre_leyes,t2.abreviatura,t3.abreviatura from pac_web.leyes_por_estanques t1 ";
		$Consulta.="left join proyecto_modernizacion.leyes t2 on t1.cod_leyes=t2.cod_leyes left join proyecto_modernizacion.unidades t3 ";
		$Consulta.="on t1.cod_unidad=t3.cod_unidad left join proyecto_modernizacion.sub_clase t4 on t1.cod_estanque=t4.cod_subclase and t4.cod_clase='9001' ";
		switch ($CmbOpcion)
		{
			case "E"://POR ESTANQUE
				$Consulta.= " where (t1.fecha between '".$FechaInicio."' and '".$FechaTermino."') and t1.cod_estanque='".$CmbEK."'";
				break;
			case "L"://POR LEYES
				$Consulta.= " where (t1.fecha between '".$FechaInicio."' and '".$FechaTermino."') and t1.cod_leyes='".$Leyes."'";
				break;
		}
		$Resultado=mysqli_query($link, $Consulta);
		while ($Fila=mysqli_fetch_array($Resultado))
		{
			echo "<tr>"; 
			echo "<td align='center'>".$Fila["estanque"]."</td>";
			echo "<td align='center'>".$Fila["fecha"]."</td>";
			echo "<td>&nbsp;".$Fila["nombre_leyes"]."&nbsp;(".$Fila["cod_ley"].")</td>";
			echo "<td align='right'>".$Fila["valor"]."</td>";
			echo "<td>".$Fila["abreviatura"]."</td>";
			echo "</tr>";
		}
	}	
	echo "</table>";
	?>
</form>
</body>
</html>