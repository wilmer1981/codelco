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
	include("../principal/conectar_principal.php"); 

	$DiaIni = isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:date('d');
	$MesIni = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:date('m');
	$AnoIni = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:date('Y');
	$DiaFin = isset($_REQUEST["DiaFin"])?$_REQUEST["DiaFin"]:date('d');
	$MesFin = isset($_REQUEST["MesFin"])?$_REQUEST["MesFin"]:date('m');
	$AnoFin = isset($_REQUEST["AnoFin"])?$_REQUEST["AnoFin"]:date('Y');

	if ($DiaIni < 10)
		$DiaIni = "0".$DiaIni;
	if ($MesIni < 10)
		$MesIni = "0".$MesIni;
	if ($DiaFin < 10)
		$DiaFin = "0".$DiaFin;
	if ($MesFin < 10)
		$MesFin = "0".$MesFin;
 	$FechaInicio = $AnoIni."-".$MesIni."-".$DiaIni;
	$FechaTermino = $AnoFin."-".$MesFin."-".$DiaFin;
?><html>
<head>
<title>Sistema Estadistico de Catodos</title>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
  <table width="750" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center" colspan="6"><strong>INFORME DE GRUPOS DE PAQUETES</strong></td>
    </tr>
  </table>
  <br>
  <table width="555" border="1" cellpadding="0" cellspacing="0">
    <tr align="center"> 
    <td width="53">COD.</td>
    <td width="71">LOTE</td>
    <td width="85">GRUPO</td>
    <td width="130">FECHA</td>
    <td width="91">UNIDADES</td>
    <td width="110">CANT. PAQUETES</td>
  </tr>
  <?php
	$Consulta = "SELECT distinct t1.cod_bulto, t1.num_bulto, t2.cod_grupo, ";
	$Consulta.= " t1.fecha_creacion_lote, sum(t2.num_unidades) as unidades, count(*) as cant_paquetes";
	$Consulta.= " from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2 ";
	$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete";
	$Consulta.= " where t1.fecha_creacion_lote between '".$FechaInicio."' and '".$FechaTermino."'";
	$Consulta.= " group by t1.cod_bulto, t1.num_bulto";
	$Consulta.= " order by t1.fecha_creacion_lote, t1.cod_bulto, t1.num_bulto";
	$Respuesta = mysqli_query($link, $Consulta);
	$TotalUnidades = 0;
	$TotalPaquetes = 0;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		echo "<tr>\n";
		echo "<td align='center'>".$Fila["cod_bulto"]."</td>\n";
		echo "<td align='center'>".$Fila["num_bulto"]."</td>\n";
		echo "<td align='center'>";
		if ($Fila["cod_grupo"])
			echo $Fila["cod_grupo"];
		else
			echo "&nbsp;";
		echo "</td>\n";
		echo "<td align='center'>".substr($Fila["fecha_creacion_lote"],8,2)."/".substr($Fila["fecha_creacion_lote"],5,2)."/".substr($Fila["fecha_creacion_lote"],0,4)."</td>\n";
		echo "<td align='right'>".number_format($Fila["unidades"],0,",",".")."</td>\n";
		echo "<td align='right'>".number_format($Fila["cant_paquetes"],0,",",".")."</td>\n";		
		echo "</tr>\n";
		$TotalUnidades = $TotalUnidades + $Fila["unidades"];
		$TotalPaquetes = $TotalPaquetes + $Fila["cant_paquetes"];
	}
	?>
  <tr> 
    <td colspan="4"><strong>TOTALES EN PERIODO <?php echo $DiaIni."/".$MesIni."/".$AnoFin." al ".$DiaFin."/".$MesFin."/".$AnoFin ?> </strong></td>
    <td align="right"> <?php echo number_format($TotalUnidades,0,",",".") ?></td>
    <td align="right"> <?php echo number_format($TotalPaquetes,0,",",".") ?></td>
  </tr>
</table>
</form>
</body>
</html>
