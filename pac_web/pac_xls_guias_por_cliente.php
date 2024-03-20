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

	$CmbClientes      = isset($_REQUEST["CmbClientes"])?$_REQUEST["CmbClientes"]:"";

?>
<html>
<head>
<title>Planta de &Aacute;cido</title>
</head>
<body>
<form name="FrmConsultaGuiasClientes" action="" method="post">
  <table width='750'>
    <tr> 
      <td align="center">Guia</td>
      <td align='center'>Patente</td>
      <td align='center'>Fecha</td>
	  <td align='center'>EK Origen</td>
      <td align='center'>Toneladas</td>
    </tr>
    <?php	
		if ($Mostrar=='S')
		{
			  $FechaInicio=$CmbAno."-".$CmbMes."-".$CmbDias." 00:00:01";
			  $FechaTermino=$CmbAnoT."-".$CmbMesT."-".$CmbDiasT." 23:59:59";
			  $Consulta="SELECT t1.num_guia,t1.nro_patente,t1.fecha_hora,t2.nombre_subclase as estanque,t1.toneladas ";
			  $Consulta=$Consulta."from pac_web.guia_despacho t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase=9001 and t2.cod_subclase=t1.cod_estanque where rut_cliente='".$CmbClientes."' and fecha_hora between '".$FechaInicio."' and '".$FechaTermino."'";
			  $Respuesta=mysqli_query($link, $Consulta);			  
			  while($Fila=mysqli_fetch_array($Respuesta))
			  {
				  echo "<tr>";
				  echo "<td align='center'>".$Fila["num_guia"]."</td>";
				  echo "<td align='center'>".$Fila["nro_patente"]."</td>";
				  echo "<td align='center'>".$Fila["fecha_hora"]."</td>";
				  echo "<td align='center'>".$Fila["estanque"]."</td>";
				  echo "<td align='center'>".$Fila["toneladas"]."</td>";
				  echo "</tr>";				  
			  } 	
		}		
	?>
  </table>		
</form>		
</body>
</html>
