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
	$FechaInicio1 =date("Y-m-d", mktime(1,0,0,$MesIni,$DiaIni,$AnoIni));	

	$Fechainiturno =$FechaInicio;
	$Fechafturno = date("Y-m-d", mktime(1,0,0,intval(substr($Fechainiturno, 5, 2)) ,intval(substr($Fechainiturno, 8, 2)) + 1,intval(substr($Fechainiturno, 0, 4))));

?>
<html>
<head>
<title>Sistema Estadistico de Catodos</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
  <table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center" colspan="5"><strong>DETALLE PESAJE DE PRODUCCION</strong></td>
    </tr>
  </table>
  <?php
	$FechaAux = $FechaInicio;	
	while (date($FechaAux) <= date($FechaTermino))
	{
		$Fechainiturno=$FechaAux;
		$Fechafturno= date("Y-m-d", mktime(1,0,0,substr($FechaAux,5,2),(intval(substr($FechaAux,8,2)) + 1),substr($FechaAux,0,4)));
	
		$Consulta = "SELECT ifnull(count(*),0) as total_reg from sec_web.produccion_catodo t1";
		$Consulta.= " where CONCAT(t1.fecha_produccion,' ',t1.hora) BETWEEN '".$Fechainiturno." 08:00:00' and '".$Fechafturno." 07:59:59'";
//$Consulta.= " and cod_muestra <> 'S'";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Respuesta))
		{
			if ($Fila["total_reg"] <> 0)
			{
				echo "<br><table width='500' border='0' align='center' cellpadding='2' cellspacing='1'>\n";
				echo "<tr> \n";
				echo "<td align='center' colspan='6'><strong>DIA: ".substr($FechaAux,8,2)."/".substr($FechaAux,5,2)."/".substr($FechaAux,0,4)."</strong></td>\n";
				echo "</tr>\n";
				echo "</table>\n";
			}
		}							
		$Consulta = "SELECT distinct t2.cod_producto, t2.cod_subproducto, t2.descripcion ";
		$Consulta.= " from sec_web.produccion_catodo t1 inner join proyecto_modernizacion.subproducto t2 ";
		$Consulta.= " on t1.cod_producto = t2.cod_producto and t1.cod_subproducto = t2.cod_subproducto ";
		$Consulta.= " order by t2.cod_producto, t2.cod_subproducto";
		$Respuesta = mysqli_query($link, $Consulta);
		$TotalDia = 0;
		while ($Fila = mysqli_fetch_array($Respuesta))
		{						
			$Consulta = "SELECT * from sec_web.produccion_catodo ";
			$Consulta.= " where cod_producto = '".$Fila["cod_producto"]."'";
			$Consulta.= " and cod_subproducto = '".$Fila["cod_subproducto"]."'";
			$Consulta.= " and CONCAT(fecha_produccion,' ',hora) BETWEEN '".$Fechainiturno." 08:00:00' and '".$Fechafturno." 07:59:59'";
			$Consulta.= " order by cod_grupo";			
			$Respuesta2 = mysqli_query($link, $Consulta);
			$SubTotalPeso = 0;
			$CodProductoAnt = 0;
  			$CodSubProductoAnt = 0;
			while ($Fila2 = mysqli_fetch_array($Respuesta2))
			{
				if (($Fila2["cod_producto"] != $CodProductoAnt) || ($Fila2["cod_subproducto"] != $CodSubProductoAnt))				
				{
					echo "</table>\n";
					echo "<table width='500' border='1' align='center' cellpadding='0' cellspacing='0'>\n";
					echo "<tr align='center'> \n";
					echo "<td width='57'><strong>".$Fila2["cod_producto"]."</strong></td>\n";
					echo "<td width='330' colspan='5'><strong>".$Fila["descripcion"]."</strong></td>\n";
					echo "</tr> \n";					
					echo "<tr align='center'>";	
					echo "<td width='76'>GRUPO</td>";
					echo "<td width='76'>MUESTRA</td>";
					echo "<td width='62'>LADO</td>";
					echo "<td width='65'>CUBA</td>";
					echo "<td width='87'>PESO</td>";
					echo "<td width='87'>HORA PESADA</td>";
					echo "</tr>";
				}
				echo "<tr>";
				echo "<td align='center'>".$Fila2["cod_grupo"]."</td>";
				echo "<td align='center'>".strtoupper($Fila2["cod_muestra"])."</td>";
				echo "<td align='center'>";
				if ($Fila2["cod_lado"] != "")
					echo strtoupper($Fila2["cod_lado"]);
				else
					echo "&nbsp;";
				echo "</td>\n";
				echo "<td align='center'>".$Fila2["cod_cuba"]."</td>";
				echo "<td align='right'>".number_format($Fila2["peso_produccion"],0,",",".")."</td>";
				echo "<td align='center'>".$Fila2["hora"]."</td>";

				echo "</tr>\n";
				$SubTotalPeso = $SubTotalPeso + $Fila2["peso_produccion"];
				$TotalDia = $TotalDia + $Fila2["peso_produccion"];
				$CodProductoAnt = $Fila2["cod_producto"];
				$CodSubProductoAnt = $Fila2["cod_subproducto"];				
			}
			if ($SubTotalPeso != 0)
			{
				echo "<tr>\n";				
				echo "<td align='right' colspan='4'><strong>SUB TOTAL PRODUCTO</strong></td>\n";
				echo "<td align='right'><strong>".number_format($SubTotalPeso,0,",",".")."</strong></td>\n";
				echo "</tr>\n<br>";						
			}			
		}		
		if ($TotalDia != 0)
		{
			echo "<tr>\n";				
			echo "<td align='right' colspan='4'><strong>TOTAL DIA :".substr($FechaAux,5,2)."/".substr($FechaAux,8,2)."/".substr($FechaAux,0,4)."</strong></td>\n";
			echo "<td align='right'><strong>".number_format($TotalDia,0,",",".")."</strong></td>\n";
			echo "</tr>\n";						
		}
		$FechaAux = date("Y-m-d", mktime(1,0,0,substr($FechaAux,5,2),(intval(substr($FechaAux,8,2)) + 1),substr($FechaAux,0,4)));
		echo "</table>\n";
	}
?>
  <br>
</body>
</html>
