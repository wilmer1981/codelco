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
	
	$FechaInicio =date("Y-m-d", mktime(1,0,0,$MesIni,$DiaIni ,$AnoIni));	

	$FechaTermino =date("Y-m-d", mktime(1,0,0,$MesFin,($DiaFin +1),$AnoFin));	
	//	echo "FEcha".$FechaTermino;

	//poly 24-08-2004 $FechaInicio = $AnoIni."-".$MesIni."-".$DiaIni;
	//$FechaTermino = $AnoFin."-".$MesFin."-".$DiaFin;//

?>
<html>
<head>
<title>Sistema Estadistico de Catodos</title>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="frmPrincipal" method="post" action="">
  <br>
   <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center"><strong>RESUMEN DE PASEJE DE PRODUCCION</strong></td>
    </tr>
  </table>
    <br>
  <table width="800" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr> 

      <td width="800">Fecha Inicio: <?php echo $DiaIni."-".$MesIni."-".$AnoIni?>&nbsp; Fecha Termino:<?php echo $DiaFin."-".$MesFin."-".$AnoFin ; ?> </td>
	</tr>
  </table>
  <br>
 <table width="800" border="1" align="center" cellpadding="2" cellspacing="1" >
  
    <td align="center" width="20">DIA</td>
    <td width="45">PROD.</td>
    <td align="center" width="230">DESCRIPCION</td>
    <td width="52">GRUPO</td>
    <td width="54">LADO-P</td>
    <td width="54">LADO-T</td>
    <td align="center" width="67">MUESTRA</td>
    <td align="center" width="74">TOT-PESO</td>
    <td width="60">COL-PARC</td>
    <td width="60">COL-TOTAL</td>
    <td width="60">TOT-COLI</td>
  </tr>

<?php

	$Fecha2 =date("Y-m-d", mktime(1,0,0,$MesFin,($DiaFin +1),$AnoFin));	

	//echo "hola".$FechaInicio."-".$Fecha2;	
	//$Fechainiturno = $FechaInicio;
	for ($Fechainiturno = $FechaInicio; $Fechainiturno < $Fecha2;) 
	{
		$Fechafturno = date("Y-m-d", mktime(1,0,0,intval(substr($Fechainiturno, 5, 2)) ,intval(substr($Fechainiturno, 8, 2)) + 1,intval(substr($Fechainiturno, 0, 4))));
		$Consulta = " SELECT distinct t1.fecha_produccion, CONCAT(t1.fecha_produccion,' ',hora) as poly ,t1.cod_producto, t2.cod_subproducto, t2.descripcion, t1.cod_grupo ";
		$Consulta.= " from sec_web.produccion_catodo t1 inner join proyecto_modernizacion.subproducto t2 "; 
		$Consulta.= " on t1.cod_producto = t2.cod_producto and t1.cod_subproducto = t2.cod_subproducto  ";
		$Consulta.= " where CONCAT(t1.fecha_produccion,' ',hora) BETWEEN '".$Fechainiturno." 08:00:00' and '".$Fechafturno." 07:59:59'";
		//$Consulta.= " where (t1.fecha_produccion>='".$Fechainiturno."' and hora >='08:00:00' and t1.fecha_produccion<='".$Fechafturno."' and hora<='07:59:59')";
		$Consulta.= " group by   t1.cod_producto, t2.cod_subproducto, t1.cod_grupo ";
		$Consulta.= " order by t1.fecha_produccion, t1.cod_producto, t2.cod_subproducto, t1.cod_grupo  ";
	//	echo "con".$Consulta;
		$Respuesta = mysqli_query($link, $Consulta);
		$TotalColParc = 0;
		$TotalColTotal = 0;
		$TotalColillas = 0;	
		while ($Fila = mysqli_fetch_array($Respuesta))
		{
			$TotPesoGrupo = 0;
			echo "<tr>";
			//echo "<td>".substr($Fila["fecha_produccion"],8,2)."/".substr($Fila["fecha_produccion"],5,2)."/".substr($Fila["fecha_produccion"],0,4)."</td>\n";
			echo "<td align ='center'>".substr($Fechainiturno,8,2)."/".substr($Fechainiturno,5,2)."/".substr($Fechainiturno,0,4)."</td>";
			echo "<td align='center'>".$Fila["cod_producto"]."</td>";
			echo "<td>".$Fila["descripcion"]."</td>";
			echo "<td align='center'>".$Fila["cod_grupo"]."</td>";
			$Consulta = " SELECT t1.cod_producto, t1.cod_subproducto, t1.cod_grupo, t1.cod_lado, ";
			$Consulta.= " ifnull(sum(t1.peso_produccion),0) as peso, ifnull(sum(t1.peso_tara),0) as peso_tara, count(*) as colillas, t1.fecha_produccion ";
			$Consulta.= " from sec_web.produccion_catodo t1 ";
			$Consulta.= " where CONCAT(t1.fecha_produccion,' ',hora) BETWEEN '".$Fechainiturno." 08:00:00' and '".$Fechafturno." 07:59:59'";
			//$Consulta.= " where (t1.fecha_produccion>='".$Fechainiturno."' and hora >='08:00:00' and t1.fecha_produccion<='".$Fechafturno."' and hora<='07:59:59')";
			//$Consulta.= " where t1.fecha_produccion = '".$Fila["fecha_produccion"]."' ";
			$Consulta.= " and t1.cod_producto = '".$Fila["cod_producto"]."' and t1.cod_subproducto = '".$Fila["cod_subproducto"]."' ";
			$Consulta.= " and t1.cod_grupo = '".$Fila["cod_grupo"]."' and t1.cod_lado = 'P'";
			$Consulta.= " group by   t1.cod_producto, t1.cod_subproducto, t1.cod_grupo, t1.cod_lado ";
			//echo "con".$Consulta;
			$Respuesta2 = mysqli_query($link, $Consulta);
			if ($Fila2 = mysqli_fetch_array($Respuesta2))
			{			
				echo "<td align='right'>".number_format($Fila2["peso"],0,",",".")."</td>";
				$TotPesoGrupo = $TotPesoGrupo + ($Fila2["peso"]);
				$ColParc = $Fila2["colillas"];
			}
			else
			{
				echo "<td>&nbsp;</td>";
				$ColParc = 0;
			}
			$Consulta = " SELECT t1.cod_producto, t1.cod_subproducto, t1.cod_grupo, t1.cod_lado, ";
			$Consulta.= " ifnull(sum(t1.peso_produccion),0) as peso, count(*) as colillas,t1.fecha_produccion ";
			$Consulta.= " from sec_web.produccion_catodo t1 ";
			$Consulta.= " where CONCAT(t1.fecha_produccion,' ',hora) BETWEEN '".$Fechainiturno." 08:00:00' and '".$Fechafturno." 07:59:59'";
			//$Consulta.= " where (t1.fecha_produccion>='".$Fechainiturno."' and hora >='08:00:00' and t1.fecha_produccion<='".$Fechafturno."' and hora<='07:59:59')";
			//$Consulta.= " where t1.fecha_produccion = '".$Fila["fecha_produccion"]."' ";
			$Consulta.= " and t1.cod_producto = '".$Fila["cod_producto"]."' and t1.cod_subproducto = '".$Fila["cod_subproducto"]."' ";
			$Consulta.= " and t1.cod_grupo = '".$Fila["cod_grupo"]."' and t1.cod_lado = 'T'";
			$Consulta.= " group by  t1.cod_producto, t1.cod_subproducto, t1.cod_grupo, t1.cod_lado ";
			//echo "con".$Consulta;
			$Respuesta2 = mysqli_query($link, $Consulta);
			if ($Fila2 = mysqli_fetch_array($Respuesta2))
			{			
				echo "<td align='right'>".number_format($Fila2["peso"],0,",",".")."</td>";
				$TotPesoGrupo = $TotPesoGrupo + $Fila2["peso"];
				$ColTotal = $Fila2["colillas"];
			}
			else
			{
				echo "<td>&nbsp;</td>";
				$ColTotal = 0;
			}
			$Consulta = " SELECT t1.cod_producto, t1.cod_subproducto, t1.cod_grupo, t1.cod_lado, ";
			$Consulta.= " ifnull(sum(t1.peso_produccion),0) as peso, ifnull(sum(t1.peso_tara),0) as peso_tara,t1.fecha_produccion ";
			$Consulta.= " from sec_web.produccion_catodo t1 ";
			$Consulta.= " where CONCAT(t1.fecha_produccion,' ',hora) BETWEEN '".$Fechainiturno." 08:00:00' and '".$Fechafturno." 07:59:59'";
			//$Consulta.= " where (t1.fecha_produccion>='".$Fechainiturno."' and hora >='08:00:00' and t1.fecha_produccion<='".$Fechafturno."' and hora<='07:59:59'";
			//$Consulta.= " where t1.fecha_produccion = '".$Fila["fecha_produccion"]."' ";
			$Consulta.= " and t1.cod_producto = '".$Fila["cod_producto"]."' and t1.cod_subproducto = '".$Fila["cod_subproducto"]."' ";
			/*poly 28-04-2004
			$Consulta.= " and t1.cod_grupo = '".$Fila["cod_grupo"]."' and t1.cod_lado = ''";*/
			$Consulta.= " and t1.cod_grupo = '".$Fila["cod_grupo"]."' and (t1.cod_lado is null or t1.cod_lado = '')";
	
			$Consulta.= " group by  t1.cod_producto, t1.cod_subproducto, t1.cod_grupo, t1.cod_lado ";
			//echo "con".$Consulta;
			$Respuesta2 = mysqli_query($link, $Consulta);
			if ($Fila2 = mysqli_fetch_array($Respuesta2))
			{			
				echo "<td align='right'>".number_format(($Fila2["peso"] - $Fila2["peso_tara"]),0,",",".")."</td>";
				$TotPesoGrupo = $TotPesoGrupo + ($Fila2["peso"]-$Fila2["peso_tara"]);
			}
			else
			{
				echo "<td>&nbsp;</td>";
			}
			echo "<td align='right'>".number_format($TotPesoGrupo,0,",",".")."</td>";
			echo "<td align='right'>".number_format($ColParc,0,",",".")."</td>";
			echo "<td align='right'>".number_format($ColTotal,0,",",".")."</td>";
			echo "<td align='right'>".number_format(($ColParc + $ColTotal),0,",",".")."</td>";
			echo "</tr>";
		}
		$Fechainiturno = date("Y-m-d", mktime(1,0,0,intval(substr($Fechainiturno, 5, 2)) ,intval(substr($Fechainiturno, 8, 2)) + 1,intval(substr($Fechainiturno, 0, 4))));
	}
?>
</table>

<br>
<br>
<br>
<table width="579" border="1" cellpadding="0" cellspacing="0" align="center">

<?php
	echo "<tr>";
	$Consulta = "SELECT distinct t1.fecha_produccion, t1.cod_producto, t2.cod_subproducto,  ";
	$Consulta.= " t2.descripcion, sum(t1.peso_produccion)as peso, sum(t1.peso_tara)as peso_tara  ";
	$Consulta.= " from sec_web.produccion_catodo t1 inner join proyecto_modernizacion.subproducto t2  ";
	$Consulta.= " on t1.cod_producto = t2.cod_producto and t1.cod_subproducto = t2.cod_subproducto  ";
	$Consulta.= " where CONCAT(t1.fecha_produccion,' ',hora) BETWEEN '".$FechaInicio." 08:00:00' and '".$FechaTermino." 07:59:59'";
	$Consulta.= " group by t1.cod_producto, t2.cod_subproducto ";
	$Consulta.= " order by t1.cod_producto, t2.cod_subproducto  ";
	$Respuesta = mysqli_query($link, $Consulta);
	//echo $Consulta;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		echo "<td width='472' colspan='5'>A LA FECHA DEL PERIODO, PRODUCTO <strong>".$Fila["cod_producto"]." ".$Fila["descripcion"]."</strong></td>";
		echo "<td width='83' colspan='2 align='right'>".number_format(($Fila["peso"]-$Fila["peso_tara"]),0,",",".")."</td>";
		echo "</tr>";
	}
?>
</table>

<br>
<table width="579" border="1" cellpadding="0" cellspacing="0"  align="center">
<?php
	echo "<tr>";
	$Consulta = "SELECT distinct t1.fecha_produccion, t1.cod_producto, t2.cod_subproducto,  ";
	$Consulta.= " t2.descripcion, sum(t1.peso_produccion)as peso, sum(t1.peso_tara)as peso_tara  ";
	$Consulta.= " from sec_web.produccion_catodo t1 inner join proyecto_modernizacion.subproducto t2  ";
	$Consulta.= " on t1.cod_producto = t2.cod_producto and t1.cod_subproducto = t2.cod_subproducto  ";
	$Consulta.= " where CONCAT(t1.fecha_produccion,' ',hora) BETWEEN '".substr($FechaInicio,0,4)."-" .substr($FechaInicio,5,2)."-01 08:00:00' and '".$FechaTermino." 07:59:59'";
	//$Consulta.= " where (t1.fecha_produccion>='".$FechaInicio."' and hora >='08:00:00' and t1.fecha_produccion<='".$FechaTermino."' and hora<='07:59:59')";
	//$Consulta.= " where t1.fecha_produccion BETWEEN '".substr($FechaInicio,0,4)."-".substr($FechaInicio,5,2)."-01' and '".$FechaTermino."'  ";
	$Consulta.= " group by t1.cod_producto, t2.cod_subproducto ";
	$Consulta.= " order by t1.cod_producto, t2.cod_subproducto  ";
	//echo "con".$Consulta;
	$Respuesta = mysqli_query($link, $Consulta);
	//echo "total mes".$Consulta;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		echo "<td width='472' colspan='5'>TOTAL DEL MES, PRODUCTO <strong>".$Fila["cod_producto"]." ".$Fila["descripcion"]."</strong></td>\n";
		echo "<td width='83' colspan='2'  align='right'>".number_format(($Fila["peso"]-$Fila["peso_tara"]),0,",",".")."</td>\n";
		echo "</tr>";
	}
?>
</table>     
</form>
</body>
</html>
