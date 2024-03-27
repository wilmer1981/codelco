<?	 
	header("Content-Type:application/vnd.ms-excel");
	 header("Expires:0");
	 header("Cache-Control: must-revalidate, post-check=0, pre-check=0");	
	include("../principal/conectar_raf_web.php");
	$Consulta = "SELECT * FROM raf_web.movimientos ";
	$Consulta.= " WHERE hornada = '".$Ano.str_pad($Mes,2,"0",STR_PAD_LEFT).$Hornada."'";
	//$Consulta.= " and campo1 = '".$Letra."'";
	$rs = mysqli_query($link, $Consulta);
	$row = mysql_fetch_array($rs);
	$DiaC = substr($row[fecha_carga],8,2);
	$MesC = substr($row[fecha_carga],5,2);  			
	$AnoC = substr($row[fecha_carga],0,4);
	$Fecha = $row["fecha_carga"];
	$Solera = $row["solera"];
	$hornada = $row["hornada"];
	if($hornada == '')
	{
		echo '<script language="JavaScript">';
		echo 'alert("La Hornada No Existe hornada='.$hornada.'");';
		//echo 'window.history.back()';
		echo '</script>';
	}
   $procesos =array ("Carga Fusion","Escoreo","Oxidacion","Reducc. Q","Reducc. T","Moldeo");   
?>
<html>
<head>
<title>Sistema de RAF</title>
</head>

<body>
<form name="FrmPrincipal" method="post" action="">
	<input type="hidden" name="Ano" value="<? echo $Ano; ?>">
	<input type="hidden" name="Mes" value="<? echo $Mes; ?>">
  <table width="499" align="center" border="1" cellspacing="0" cellpadding="0" class="TablaDetalle">
    <tr> 
      <td height="20" colspan="2" align="center"><strong>Report Operacional Horno Basculante y Horno 
        Reten. </strong></td>
    </tr>
    <tr class="ColorTabla02">
      <td width="227" height="20">Hornada : <? echo $Hornada." - ".$Letra." - ".$Solera.'<strong></strong>' ?>
        <input type="hidden" name="hornada" value="<? echo $hornada;?>">
        <input type="hidden" name="Letra" value="<? echo $Letra;?>"></td>
      <td width="265">Fecha : <? echo $DiaC."-".$MesC."-".$AnoC ?>
        <input type="hidden" name="fecha" value="<? echo $AnoC."-".$MesC."-".$DiaC ?>"></td>
    </tr>
  </table>
  <br>
  <table width="400" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
	<tr>
      <td align="center" colspan="7">Carga Horno Basculante</td>
	</tr>
    <tr class="ColorTabla01"> 
      <td width="51" align="center">Fecha</td>
      <td width="48" align="center">Inicio</td>
      <td width="47" align="center">Fin</td>
      <td width="43" align="center">Ollas</td>
      <td width="52" align="center">Acumul.</td>
      <td width="97" align="center">Origen</td>
      <td width="45" align="center">Saldo</td>
    </tr>
    <?
	$Consulta = "SELECT * FROM raf_web.datos_operacionales ";
	$Consulta.= " WHERE tipo_report = 1 AND seccion_report = 1";
	$Consulta.= " AND Hornada = '".$hornada."'"; 
	$Consulta.= " and campo1 = '".$Letra."'";
	$Consulta.= " order by fecha_ini, hora_ini";
	$rs = mysqli_query($link, $Consulta);
	$Acum_Ollas = "";
	while($Fila = mysql_fetch_array($rs))
	{
		echo "<tr>\n";
		$dia = substr($Fila["fecha_ini"],8,2);
		$mes = substr($Fila["fecha_ini"],5,2);					  			
		
		echo "<td align='center'>".$dia."-".$mes."</td>\n";
		echo "<td align='center'>".substr($Fila[hora_ini],0,5)."</td>\n";
		echo "<td align='center'>".substr($Fila[hora_ter],0,5)."</td>\n";
		echo "<td align='right'>".$Fila[campo2]."</td>\n";
		$Acum_Ollas = $Acum_Ollas + $Fila[campo2];
		echo "<td align='right'>".$Acum_Ollas."</td>\n";
		echo "<td align='center'>".strtoupper($Fila[campo3])."</td>\n";
		if ($Fila[campo4]=="S")
			echo "<td align='center' bgcolor='yellow'>SI</td>\n";
		else
			echo "<td align='center'>&nbsp;</td>\n";
		echo "</tr>\n";
	}
  ?>	
  </table>
  <br>
  <table width="400" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
	<tr>
      <td align="center" colspan="6">Carga Horno Reten</td>
	</tr>
    <tr class="ColorTabla01"> 
      <td width="52" align="center">Fecha</td>
      <td width="49" align="center">Inicio</td>
      <td width="48" align="center">Fin</td>
      <td width="44" align="center">Ollas</td>
      <td width="53" align="center">Acumul.</td>
      <td width="139" align="center">Origen</td>
    </tr>
    <?
	$Consulta = "SELECT * FROM raf_web.datos_operacionales ";
	$Consulta.= " WHERE tipo_report = 1 AND seccion_report = 2";
	$Consulta.= " AND Hornada = '".$hornada."'"; 
	$Consulta.= " and campo1 = '".$Letra."'"; 
	$Consulta.= " order by fecha_ini, hora_ini";
	$rs = mysqli_query($link, $Consulta);
	$Acum_Ollas = "";
	while($Fila = mysql_fetch_array($rs))
	{
		echo "<tr>\n";
		$dia = substr($Fila["fecha_ini"],8,2);
		$mes = substr($Fila["fecha_ini"],5,2);					  			
		
		echo "<td align='right'>".$dia."-".$mes."&nbsp;</td>\n";
		echo "<td align='right'>".substr($Fila[hora_ini],0,5)."&nbsp;</td>\n";
		echo "<td align='right'>".substr($Fila[hora_ter],0,5)."&nbsp;</td>\n";
		echo "<td align='right'>".$Fila[campo2]."&nbsp;</td>\n";
		$Acum_Ollas = $Acum_Ollas + $Fila[campo2];
		echo "<td align='right'>".$Acum_Ollas."&nbsp;</td>\n";
		echo "<td align='right'>".strtoupper($Fila[campo3])."&nbsp;</td>\n";
		echo "</tr>\n";
	}
	?>
  </table>
  <br>
  <table width="330" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
    <tr> 
      <td align="center" colspan="3">Produccion Moldeo</td>
      <td width="22" rowspan="7" align="center">&nbsp;</td>
      <td align="center" colspan="3">Muestra Hora</td>
    </tr>
    <?		
		$HornadaSEA = $Ano."".str_pad($Mes,2,"0",STR_PAD_LEFT)."".$Hornada;
		$UnidComer = 0;
		$PesoComer = 0;
		$UnidEsp = 0;
		$PesoEsp = 0;
		$UnidHM = 0;
		$PesoHM = 0;
		//COMERCIALES		
		$Consulta = "SELECT * FROM raf_web.datos_operacionales ";
		$Consulta.= " WHERE tipo_report = 1 AND seccion_report = 3";
		$Consulta.= " AND hornada = '".$HornadaSEA."'"; 
		$Consulta.= " AND campo1 = '".$Letra."'"; 
		$Consulta.= " AND campo2 = '1'"; 
		$Resp2 = mysqli_query($link, $Consulta);			
		if($Fila2 = mysql_fetch_array($Resp2))
		{			
			$UnidComer = $Fila2["campo3"];
			$PesoComer = $Fila2["campo4"]; 
		}
		/*else
		{
			$Consulta = "select sum(peso) as peso, sum(unidades) as unidades from sea_web.movimientos ";
			$Consulta.= " where tipo_movimiento = '1'";
			$Consulta.= " and cod_producto = '17'";
			$Consulta.= " and cod_subproducto = '4' ";
			$Consulta.= " and hornada = '".$HornadaSEA."' ";
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila = mysql_fetch_array($Resp))
			{
				$Elimina = "DELETE FROM raf_web.datos_operacionales ";
				$Elimina.= " WHERE hornada = '".$HornadaSEA."'";	
				$Elimina.= " AND tipo_report = 1 AND seccion_report = '3'";
				$Elimina.= " AND campo1='".$Letra."' AND campo2 = '1'";
				mysql_query($Elimina);
				
				$Insertar = "INSERT INTO raf_web.datos_operacionales ";
				$Insertar.= " (hornada,fecha,tipo_report,seccion_report, campo1,campo2,campo3,campo4)";
				$Insertar.= " values('".$HornadaSEA."','".$Fecha."','1','3','".strtoupper($Letra)."','1','".$Fila["unidades"]."','".$Fila["peso"]."')";	
				mysql_query($Insertar);
				
				$UnidComer = $Fila["unidades"];
				$PesoComer = $Fila["peso"];								
			}
		}*/
		//ESPECIALES
		$Consulta = "SELECT * FROM raf_web.datos_operacionales ";
		$Consulta.= " WHERE tipo_report = 1 AND seccion_report = 3";
		$Consulta.= " AND hornada = '".$HornadaSEA."'"; 
		$Consulta.= " AND campo1 = '".$Letra."'"; 
		$Consulta.= " AND campo2 = '2'"; 
		$Resp2 = mysqli_query($link, $Consulta);			
		if($Fila2 = mysql_fetch_array($Resp2))
		{			
			$UnidEsp = $Fila2["campo3"];
			$PesoEsp = $Fila2["campo4"];
		}				
		/*else
		{
			$Consulta = "select sum(peso) as peso, sum(unidades) as unidades from sea_web.movimientos ";
			$Consulta.= " where tipo_movimiento = '1'";
			$Consulta.= " and cod_producto = '17'";
			$Consulta.= " and cod_subproducto = '11' ";
			$Consulta.= " and hornada = '".$HornadaSEA."' ";
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila = mysql_fetch_array($Resp))
			{
				$Elimina = "DELETE FROM raf_web.datos_operacionales ";
				$Elimina.= " WHERE hornada = '".$HornadaSEA."'";	
				$Elimina.= " AND tipo_report = 1 AND seccion_report = '3'";
				$Elimina.= " AND campo1='".$Letra."' AND campo2 = '2'";
				mysql_query($Elimina);
				
				$Insertar = "INSERT INTO raf_web.datos_operacionales ";
				$Insertar.= " (hornada,fecha,tipo_report,seccion_report, campo1,campo2,campo3,campo4)";
				$Insertar.= " values('".$HornadaSEA."','".$Fecha."','1','3','".strtoupper($Letra)."','2','".$Fila["unidades"]."','".$Fila["peso"]."')";	
				mysql_query($Insertar);
			
				$UnidEsp = $Fila["unidades"];
				$PesoEsp = $Fila["peso"];
			}
		}*/
		//H.M.
		$Consulta = "SELECT * FROM raf_web.datos_operacionales ";
		$Consulta.= " WHERE tipo_report = 1 AND seccion_report = 3";
		$Consulta.= " AND hornada = '".$HornadaSEA."'"; 
		$Consulta.= " AND campo1 = '".$Letra."'"; 
		$Consulta.= " AND campo2 = '3'"; 
		$Resp2 = mysqli_query($link, $Consulta);			
		if($Fila2 = mysql_fetch_array($Resp2))
		{			
			$UnidHM = $Fila2["campo3"];
			$PesoHM = $Fila2["campo4"];
		}				
		/*else
		{
			$Consulta = "select sum(peso) as peso, sum(unidades) as unidades from sea_web.movimientos ";
			$Consulta.= " where tipo_movimiento = '1'";
			$Consulta.= " and cod_producto = '17'";
			$Consulta.= " and cod_subproducto = '8' ";
			$Consulta.= " and hornada = '".$HornadaSEA."' ";
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila = mysql_fetch_array($Resp))
			{
				$Elimina = "DELETE FROM raf_web.datos_operacionales ";
				$Elimina.= " WHERE hornada = '".$HornadaSEA."'";	
				$Elimina.= " AND tipo_report = 1 AND seccion_report = '3'";
				$Elimina.= " AND campo1='".$Letra."' AND campo2 = '3'";
				mysql_query($Elimina);
				
				$Insertar = "INSERT INTO raf_web.datos_operacionales ";
				$Insertar.= " (hornada,fecha,tipo_report,seccion_report, campo1,campo2,campo3,campo4)";
				$Insertar.= " values('".$HornadaSEA."','".$Fecha."','1','3','".strtoupper($Letra)."','3','".$Fila["unidades"]."','".$Fila["peso"]."')";	
				mysql_query($Insertar);
			
				$UnidHM = $Fila["unidades"];
				$PesoHM = $Fila["peso"];
			}
		}*/
		// ESC. ANODICA
		$Consulta = "SELECT SUM(campo5) as campo5, sum(campo6) as campo6 FROM raf_web.datos_operacionales ";
		$Consulta.= " WHERE tipo_report = 1 AND seccion_report = 5";
		$Consulta.= " AND hornada = '".$HornadaSEA."'"; 
		$Consulta.= " AND campo1 = '".$Letra."'"; 
		$Consulta.= " AND campo2 = '1'"; 
		$Resp2 = mysqli_query($link, $Consulta);			
		if($Fila2 = mysql_fetch_array($Resp2))
		{			
			$UnidEsc = $Fila2["campo5"];
			$PesoEsc = $Fila2["campo6"];
		}								
		$AcumUnid = $UnidComer + $UnidEsp + $UnidHM;
		$AcumPeso = $PesoComer + $PesoEsp + $PesoHM;
	?>
    <tr class="ColorTabla01"> 
      <td width="90" align="center">Anodos</td>
      <td width="51" align="center">Unidad</td>
      <td width="55" align="center">Peso</td>
      <td colspan="2" align="center">&nbsp;</td>
      <td width="43" align="center">&nbsp;</td>
    </tr>
    <tr> 
      <td>COMERC.</td>
      <td align="center"><? echo number_format($UnidComer,0,",",".");?>&nbsp;</td>
      <td align="center"><? echo number_format($PesoComer,0,",",".");?>&nbsp;</td>
	  <? 
	  	$Consulta = "select * from raf_web.datos_operacionales ";
		$Consulta.= " where seccion_report='4' and hornada='".$HornadaSEA."'";
		$Consulta.= " and tipo_report='1'";
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysql_fetch_array($Resp))
		{
			$Consulta = "SELECT * FROM raf_web.datos_operacionales ";
			$Consulta.= " WHERE tipo_report = 1 AND seccion_report = 4";
			$Consulta.= " AND Hornada = '".$HornadaSEA."'";
			$Consulta.= " AND campo1 = '".$Letra."'";
			$rs = mysqli_query($link, $Consulta);
			if($Fila = mysql_fetch_array($rs))
			{
				$SB = $Fila["campo2"];
				$AS = $Fila["campo3"];	
			}
		}
		/*else
		{
			$Consulta = "select * from sea_web.leyes_por_hornada ";
			$Consulta.= " where hornada = '".$HornadaSEA."'";
			$Consulta.= " and cod_producto='17' and cod_subproducto='4'";
			$Consulta.= " and cod_leyes in(08,09)";
			$Resp = mysqli_query($link, $Consulta);
			while ($Fila = mysql_fetch_array($Resp))
			{
				if ($Fila["cod_leyes"]=="08")
					$AS = $Fila["valor"];
				if ($Fila["cod_leyes"]=="09")
					$SB = $Fila["valor"];
			}
		}*/
	?>	
      <td colspan="2" align="center">Sb</td>
      <td align="center"><? echo number_format($SB,0,",",".");?>&nbsp;</td>
    </tr>
    <tr> 
      <td>ESPECIAL</td>
      <td align="center"><? echo number_format($UnidEsp,0,",",".");?>&nbsp;</td>
      <td align="center"><? echo number_format($PesoEsp,0,",",".");?>&nbsp;</td>
      <td colspan="2" align="center">As</td>
      <td align="center"><? echo number_format($AS,0,",",".");?>&nbsp;</td>
    </tr>
    <tr> 
      <td>H MADRES</td>
      <td align="center"><? echo number_format($UnidHM,0,",",".");?>&nbsp;</td>
      <td align="center"><? echo number_format($PesoHM,0,",",".");?>&nbsp;</td>
      <td colspan="3" rowspan="3" align="center">&nbsp;</td>
    </tr>
    <tr> 
      <td><strong>T. PRODUCC.</strong></td>
      <td align="center"><strong><? echo number_format($AcumUnid,0,",",".");?>&nbsp;</strong></td>
      <td align="center"><strong><? echo number_format($AcumPeso,0,",",".");?>&nbsp;</strong></td>
    </tr>
    <tr>
      <td>ESC. ANODICA </td>
      <td align="center"><? echo number_format($UnidEsc,2,",",".");?></td>
      <td align="center"><? echo number_format($PesoEsc,0,",",".");?></td>
    </tr>
  </table>   
  <br>  
  <table width="600" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
	<tr>
      <td align="center" rowspan="2">Proceso H. Basc.</td>
      <td align="center" rowspan="2">Fecha</td>
      <td align="center" colspan="3">Tiempo Operaci&oacute;n</td>
      <td align="center" colspan="3">Integrador de Gas</td>
      <td align="center" rowspan="2">Ollas</td>
	  <td align="center" rowspan="2">Destino</td>
	</tr>
    <tr class="ColorTabla01"> 
      <td align="center">Inicio</td>
      <td align="center">Fin</td>
      <td align="center">Tiempo</td>
      <td align="center">Inicio</td>
      <td align="center">Fin</td>
      <td align="center">Total</td>
    </tr>
	<?
		$Consulta = "SELECT * FROM raf_web.datos_operacionales ";
		$Consulta.= " WHERE tipo_report = 1 AND seccion_report = 5";
		$Consulta.= " AND Hornada = '".$hornada."'"; 		
		$Consulta.= " and campo1 = '".$Letra."'";
		$Consulta.= " order by fecha_ini, hora_ini ";
		$rs = mysqli_query($link, $Consulta);
		$Real = "";
		$TotalGas = "";
		while($Fila = mysql_fetch_array($rs))
		{			
			echo "<tr>\n"; 
			echo "<td>".$procesos[$Fila[campo2]]."</td>\n";
			echo "<td align='right'>".substr($Fila["fecha_ini"],8,2)."-".substr($Fila["fecha_ini"],5,2)."&nbsp;</td>\n";
			echo "<td align='right'>".substr($Fila[hora_ini],0,5)."&nbsp;</td>\n";
			echo "<td align='right'>".substr($Fila[hora_ter],0,5)."&nbsp;</td>\n";
			
			$hh =  substr($Fila[hora_ter],0,2) - substr($Fila[hora_ini],0,2);	
			$mm =  substr($Fila[hora_ter],3,2) - substr($Fila[hora_ini],3,2);	
			$Real = date("H:i",mktime($hh,$mm));	  
			
			echo "<td align='right'>".$Real."&nbsp;</td>\n";
			
			echo "<td align='right'>".$Fila[campo3]."&nbsp;</td>\n";
			echo "<td align='right'>".$Fila[campo4]."&nbsp;</td>\n";
			
			$AcumGas = abs($Fila[campo3] - $Fila[campo4]);
			echo "<td align='right'>".$AcumGas."&nbsp;</td>\n";
			echo "<td align='right'>".$Fila[campo5]."&nbsp;</td>\n";
			echo "<td align='center'>".$Fila[campo7]."&nbsp;</td>\n";
			echo "</tr>\n";
		}	
    ?>
  </table>
  <br>
  <table width="600" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
	<tr>
      <td align="center" colspan="8">Trasvase Horno Basculante</td>
	</tr>
    <tr class="ColorTabla01"> 
      <td width="53" align="center">Fecha</td>
      <td width="52" align="center">Inicio</td>
      <td width="42" align="center">Fin</td>
      <td width="43" align="center">Ollas</td>
      <td width="89" align="center">Destino</td>
      <td width="44" align="center">Saldo</td>
      <td width="260" align="center">Observacion</td>
    </tr>
	<?
	$Consulta = "SELECT * FROM raf_web.datos_operacionales ";
	$Consulta.= " WHERE tipo_report = 1 AND seccion_report = 6";
	$Consulta.= " AND Hornada = '".$hornada."'"; 	
	$Consulta.= " and campo1 = '".$Letra."'";
	$rs = mysqli_query($link, $Consulta);
   
	while($Fila = mysql_fetch_array($rs))
	{
		echo "<tr>\n";
		$dia = substr($Fila["fecha_ini"],8,2);
		$mes = substr($Fila["fecha_ini"],5,2);					  			
		
		echo "<td align='right'>".$dia."-".$mes."&nbsp;</td>\n";
		echo "<td align='right'>".substr($Fila[hora_ini],0,5)."&nbsp;</td>\n";
		echo "<td align='right'>".substr($Fila[hora_ter],0,5)."&nbsp;</td>\n";
		echo "<td align='right'>".$Fila[campo2]."&nbsp;</td>\n";
		echo "<td align='right'>".$Fila[campo3]."&nbsp;</td>\n";
		echo "<td align='right'>".$Fila[campo4]."&nbsp;</td>\n";
		echo "<td align='right'>".$Fila[campo5]."&nbsp;</td>\n";
		echo "</tr>\n";
	}
	?>
  </table>
  <br>
  <table width="600" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
	<tr>
      <td align="center" colspan="8">Escoreo Horno Reten</td>
	</tr>
    <tr class="ColorTabla01"> 
      <td width="53" align="center">Fecha</td>
      <td width="52" align="center">Inicio</td>
      <td width="42" align="center">Fin</td>
      <td width="43" align="center">Ollas</td>
      <td width="89" align="center">Destino</td>
      <td width="44" align="center">Acum</td>
      <td width="260" align="center">Observacion</td>
    </tr>
	<?
	$Consulta = "SELECT * FROM raf_web.datos_operacionales ";
	$Consulta.= " WHERE tipo_report = 1 AND seccion_report = 7";
	$Consulta.= " AND hornada = '".$hornada."'"; 
	$Consulta.= " and campo1 = '".$Letra."'";
	$rs = mysqli_query($link, $Consulta);
	while($Fila = mysql_fetch_array($rs))
	{
		echo "<tr>\n";
		$dia = substr($Fila["fecha_ini"],8,2);
		$mes = substr($Fila["fecha_ini"],5,2);					  			
		
		echo "<td align='right'>".$dia."-".$mes."&nbsp;</td>\n";
		echo "<td align='right'>".substr($Fila[hora_ini],0,5)."&nbsp;</td>\n";
		echo "<td align='right'>".substr($Fila[hora_ter],0,5)."&nbsp;</td>\n";
		echo "<td align='right'>".$Fila[campo2]."&nbsp;</td>\n";
		echo "<td align='right'>".$Fila[campo3]."&nbsp;</td>\n";
		echo "<td align='right'>".$Fila[campo4]."&nbsp;</td>\n";
		echo "<td align='right'>".$Fila[campo5]."&nbsp;</td>\n";
		echo "</tr>\n";
	}
	?>
  </table>
  <br>
  <table width="600" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
	<tr>
      <td align="center" colspan="8">Trasvase Horno Reten</td>
	</tr>
    <tr class="ColorTabla01"> 
      <td width="53" align="center">Fecha</td>
      <td width="52" align="center">Inicio</td>
      <td width="42" align="center">Fin</td>
      <td width="43" align="center">Ollas</td>
      <td width="89" align="center">Destino</td>
      <td width="44" align="center">Acum</td>
      <td width="260" align="center">Observacion</td>
    </tr>
	<?
	$Consulta = "SELECT * FROM raf_web.datos_operacionales ";
	$Consulta.= " WHERE tipo_report = 1 AND seccion_report = 8";
	$Consulta.= " AND Hornada = '".$hornada."'"; 
	$Consulta.= " and campo1 = '".$Letra."'";
	$rs = mysqli_query($link, $Consulta);   
	while($Fila = mysql_fetch_array($rs))
	{
		echo "<tr>";
		$dia = substr($Fila["fecha_ini"],8,2);
		$mes = substr($Fila["fecha_ini"],5,2);					  			
		
		echo "<td align='right'>".$dia."-".$mes."&nbsp;</td>\n";
		echo "<td align='right'>".substr($Fila[hora_ini],0,5)."&nbsp;</td>\n";
		echo "<td align='right'>".substr($Fila[hora_ter],0,5)."&nbsp;</td>\n";
		echo "<td align='right'>".$Fila[campo2]."&nbsp;</td>\n";
		echo "<td align='right'>".$Fila[campo3]."&nbsp;</td>\n";
		echo "<td align='right'>".$Fila[campo4]."&nbsp;</td>\n";
		echo "<td align='right'>".$Fila[campo5]."&nbsp;</td>\n";
		echo "</tr>\n";
	}
	?>
  </table>
  <br>
  <table width="306" border="1" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
    <tr> 
      <td align="center" colspan="7">Saldo De Cobre Blister Por Turno Horno Reten</td>
    </tr>
    <?
	$Consulta = "SELECT * FROM raf_web.datos_operacionales ";
	$Consulta.= " WHERE tipo_report = 1 AND seccion_report = 9";
	$Consulta.= " AND Hornada = '".$hornada."'";
	$Consulta.= " and campo1 = '".$Letra."'"; 
	$Consulta.= " ORDER BY campo2"; 
	$rs = mysqli_query($link, $Consulta);
    while($Fila = mysql_fetch_array($rs))
	{
		echo "<tr>\n";
		echo "<td width='124' align='center'>Turno&nbsp;".$Fila[campo2]."</td>\n";
		echo "<td width='175' align='center'>".$Fila[campo3]."&nbsp;</td>\n";
		echo "</tr>\n";	
	}
	?>
  </table>
  <p>&nbsp;</p>
</form>

</body>
</html>
