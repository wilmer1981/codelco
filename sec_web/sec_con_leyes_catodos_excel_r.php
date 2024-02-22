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
	include("../principal/conectar_principal.php"); 
	if (!isset($DiaIni))
	{
		$DiaIni = date("j");
		$MesIni = date("n");
		$AnoIni = date("Y");
		$DiaFin = date("j");
		$MesFin = date("n");
		$AnoFin = date("Y");
	}
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
?>
<html>
<head>
<title>Sistema Estadistico de Catodos</title>
<link rel="stylesheet" href="../Principal/estilos/css_principal.css" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f=document.frmPrincipal;
	switch (opt)
	{
		case "C":
			f.action ="sec_con_leyes_catodos.php";
			f.submit();
			break;
		case "E":
			f.action ="sec_con_leyes_catodos_excel.php";
			f.submit();
			break;
		case "S":
			f.action ="../principal/sistemas_usuario.php?CodSistema=3&Nivel=1&CodPantalla=15";
			f.submit();
			break;
		case "I":
			window.print();
			break;
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
<table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td align="center" colspan="10"><strong>CONSULTA DE LEYES DE CATODOS</strong></td>
  </tr>
</table>
<br>
  <br>
<?php
	$FechaAux = $FechaInicio;
	while (date($FechaAux) <= date($FechaTermino))
	{
		echo "<table width='300' border='1' align='center' cellpadding='0' cellspacing='0'>\n";
		echo "<tr>\n";
		echo "<td align='center' colspan='3'><strong>DIA:&nbsp;".substr($FechaAux,8,2)."/".substr($FechaAux,5,2)."/".substr($FechaAux,0,4)."</strong></td>\n";
		echo "</tr>\n";
		echo "</table>\n";
		echo "<br>\n";
		$Consulta = "SELECT distinct t3.cod_leyes,t4.abreviatura";
		$Consulta.= " from cal_web.solicitud_analisis t1 ";
		$Consulta.= " inner join cal_web.leyes_por_solicitud t3 on t1.rut_funcionario=t3.rut_funcionario and t1.fecha_hora = t3.fecha_hora and ";
		$Consulta.= " t1.nro_solicitud = t3.nro_solicitud and t1.recargo = t3.recargo  inner join 	proyecto_modernizacion.leyes t4 on t3.cod_leyes = t4.cod_leyes";
		$Consulta.= " where t1.cod_periodo='1' ";
		$Consulta.= " and t1.tipo='1' ";
		$Consulta.= " and t1.cod_analisis='1' ";
		$Consulta.= " and t1.estado_actual <> '7' ";	
		$Consulta.= " and t1.cod_producto = '18' ";				
		//$Consulta.= " and t1.cod_subproducto ='".$CmbSubProducto."' ";		
		$Consulta.= " and t1.fecha_muestra between '".$FechaAux." 00:00:00' and '".$FechaAux." 23:59:59'";		
		$Consulta.= " order by t3.cod_leyes ";
		$Respuesta = mysqli_query($link, $Consulta);
		$Arreglo = array();
		$AnchoTabla = 380;
		$ContLeyes = 0;
		while($Fila=mysqli_fetch_array($Respuesta))
		{
			$Arreglo[$Fila["cod_leyes"]][0] = $Fila["abreviatura"];
			$Arreglo[$Fila["cod_leyes"]][1] = ""; //VALOR
			$Arreglo[$Fila["cod_leyes"]][2] = ""; //SIGNO
			$Arreglo[$Fila["cod_leyes"]][3] = ""; //UNIDAD
			//echo $Arreglo[$Fila["cod_leyes"]][0]."<br>";
			$AnchoTabla = $AnchoTabla + 50;
			$ContLeyes++;		
		}		
		echo "<table width='".$AnchoTabla."' height='15' border='1' align='center' cellpadding='0' cellspacing='0'>\n";
		echo "<tr> \n";
		echo "<td width='51'>PROD.</td>\n";
		echo "<td width='85'>SUB. PROD.</td>\n";
		echo "<td width='107'>DESCRIPCION</td>\n";
		echo "<td width='64'>GRUPO</td>\n";
		echo "<td width='50'>PESO</td>\n";
		reset($Arreglo);
		foreach($Arreglo as $Clave => $Valor)
		{
			echo "<td width='50'>".$Arreglo[$Clave][0]."</td>\n";				
		}
		echo "</tr>\n";
		$Consulta = "SELECT cod_grupo, cod_producto, cod_subproducto, ";
		$Consulta.= " sum(peso_produccion) as peso_grupo ";
		$Consulta.= " from sec_web.produccion_catodo ";
		$Consulta.= " where fecha_produccion between '".$FechaAux." 00:00:00' and '".$FechaAux." 23:59:59' ";
		$Consulta.= " group by cod_grupo ";
		$Consulta.= " order by cod_grupo ";
		$Respuesta = mysqli_query($link, $Consulta);
		$TotalPeso = 0;	
		while ($Fila = mysqli_fetch_array($Respuesta))
		{
			reset($Arreglo);
			foreach($Arreglo as $Clave => $Valor)
			{
				$Arreglo[$Clave][1] = "";
				$Arreglo[$Clave][2] = "";
				$Arreglo[$Clave][3] = "";
			}
			$Consulta = "SELECT * from proyecto_modernizacion.subproducto ";
			$Consulta.= " where cod_producto = '".$Fila["cod_producto"]."' and cod_subproducto = '".$Fila["cod_subproducto"]."'";
			$Respuesta2 = mysqli_query($link, $Consulta);
			if ($Fila2 = mysqli_fetch_array($Respuesta2))
				$NomSubprod = $Fila2["descripcion"];
			else
				$NomSubprod = "&nbsp;";
			echo "<tr>\n";
			echo "<td align='center'>".$Fila["cod_producto"]."</td>\n";
			echo "<td align='center'>".$Fila["cod_subproducto"]."</td>\n";
			echo "<td>".$NomSubprod."</td>\n";
			echo "<td align='center'>".$Fila["cod_grupo"]."</td>\n";
			echo "<td align='right' >".number_format($Fila["peso_grupo"],0,",",".")."</td>\n";
			$TotalPeso = $TotalPeso + $Fila["peso_grupo"];
			$Consulta = "SELECT t2.cod_leyes, t2.valor, t2.signo, t2.cod_unidad ";
			$Consulta.= " from cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t2 ";
			$Consulta.= " on t1.nro_solicitud = t2.nro_solicitud and t1.recargo = t2.recargo ";
			$Consulta.= " and t1.fecha_hora = t2.fecha_hora and t1.rut_funcionario = t2.rut_funcionario ";
			$Consulta.= " where (";
			$Consulta.= " (t1.id_muestra = '".$Fila["cod_grupo"]."') ";			
			$Consulta.= " or (t1.id_muestra = '".intval($Fila["cod_grupo"])."')";
			$Consulta.= " ) and t1.estado_actual <> '7'";
			$Consulta.= " and t1.cod_periodo='1' ";
			$Consulta.= " and t1.tipo='1' ";
			$Consulta.= " and t1.cod_analisis='1' ";
			$Consulta.= " and t1.estado_actual <> '7' ";	
			$Consulta.= " and t1.cod_producto = '18' ";				
			//$Consulta.= " and t1.cod_subproducto ='".$CmbSubProducto."' ";
			$Fecha1 = date("Y-m-d", mktime(1,0,0,substr($FechaAux,5,2),substr($FechaAux,8,2)-3,substr($FechaAux,0,4)));
			$Fecha2 = date("Y-m-d", mktime(1,0,0,substr($FechaAux,5,2),substr($FechaAux,8,2)+3,substr($FechaAux,0,4)));		
			$Consulta.= " and t1.fecha_muestra between '".$Fecha1." 00:00:00' and '".$Fecha2." 23:59:59' ";		
			//echo $Consulta."<br>";
			$Respuesta2 = mysqli_query($link, $Consulta);
			while ($Fila2 = mysqli_fetch_array($Respuesta2))
			{
				$Arreglo[$Fila2["cod_leyes"]][1] = $Fila2["valor"];
				$Arreglo[$Fila2["cod_leyes"]][2] = $Fila2["signo"];
				$Arreglo[$Fila2["cod_leyes"]][3] = $Fila2["cod_unidad"];
			}
			reset($Arreglo);
			while(list($Clave,$Valor)=each($Arreglo))
			{
				echo "<td width='50' align='right'>".number_format($Arreglo[$Clave][1],1,",",".")."</td>\n";
			}
			echo "</tr>\n";
		}	
		echo "<tr>\n";
		echo "<td align='right' colspan='4'><strong>TOTALES</strong></td>\n";
		echo "<td align='right' ><strong>".number_format($TotalPeso,0,",",".")."</strong></td>\n";
		echo "<td colspan='".$ContLeyes."'>&nbsp;</td>\n";
		echo "</tr>\n";
  		echo "</table><br>\n";		
  		$FechaAux = date("Y-m-d",mktime(1,0,0,substr($FechaAux,5,2),(intval(substr($FechaAux,8,2)) + 1),substr($FechaAux,0,4)));
	}
?>
<br>
</form>
</body>
</html>
