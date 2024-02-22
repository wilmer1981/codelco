<?php
	include("../principal/conectar_principal.php");
	//include("sec_anexo_sec_funciones.php");
	$Consulta = "SELECT * from proyecto_modernizacion.flujos where cod_flujo = '".$Flujo."'";
	$Resp2 = mysqli_query($link, $Consulta);
	$Descripcion = "&nbsp;";
	if ($Fila2 = mysqli_fetch_array($Resp2))
	{
		$Descripcion = $Fila2["descripcion"];		
	}	
?>
<html>
<head>
<title>Sistema Estadistico de Catodos</title>
<link href="../Principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body background="../Principal/imagenes/fondo3.gif">
<strong>DETALLE DEL FLUJO: <?php echo $Flujo." - ".$Descripcion ?></strong><br>
<br>
<table width="568" border="1" align="center" cellpadding="2" cellspacing="0">
  <tr align="center" class="ColorTabla01"> 
    <td width="161" rowspan="2">PRODUCCIONES</td>
    <td width="75" rowspan="2">PESO</td>
    <td colspan="3" align="center">LEYES</td>
    <!--<td colspan="3" align="center">FINO</td>-->
  </tr>
  <tr class="ColorTabla01"> 
    <td width="63" height="25" align="center">Cu</td>
    <td width="62" align="center">Ag</td>
    <td width="53" align="center">Au</td>
    <!--<td width="27" align="center">Cu</td>
    <td width="27" align="center">Ag</td>
    <td width="36" align="center">Au</td>-->
  </tr>
  <?php
  	$FinoAg = 0;
	$FinoAu = 0;
	$FechaInicio = $Ano."-".$Mes."-01";
	$FechaTermino = $Ano."-".$Mes."-31";
	$AnoConsulta = $Ano; 
	$MesConsulta = $Mes;
	//-------LEYES DE CALIDAD MENSUAL DE Ag, Au -----------------------------
	$Consulta = "SELECT t2.cod_leyes, t2.valor, t1.fecha_muestra, ";
	$Consulta.= " t2.signo, t1.nro_solicitud, t3.abreviatura ";
	$Consulta.= " from cal_web.solicitud_analisis t1 inner join ";
	$Consulta.= " cal_web.leyes_por_solicitud  t2 on t1.nro_solicitud = t2.nro_solicitud ";
	$Consulta.= " and t1.fecha_hora = t2.fecha_hora and t1.rut_funcionario = t2.rut_funcionario and t1.recargo = t2.recargo ";
	$Consulta.= " inner join proyecto_modernizacion.leyes t3 on t2.cod_leyes = t3.cod_leyes";				
	$Consulta.= " where t1.fecha_muestra between '".$FechaInicio." 00:00:00' and '".$FechaTermino." 23:59:59'";
	$Consulta.= " and t1.estado_actual <> '16' and t1.estado_actual <> '7'";
	$Consulta.= " and t1.frx <> 'S' and t1.cod_analisis = '1'";
	$Consulta.= " and t1.cod_periodo = '3'";			
	$Consulta.= " and t1.cod_producto = '18' and t1.cod_subproducto = '5'";
	$Consulta.= " and (t2.cod_leyes = '04' or t2.cod_leyes = '05')";
	$Consulta.= " order by t1.fecha_muestra desc, t1.nro_solicitud, t2.cod_leyes ";
	$RespAux2 = mysqli_query($link, $Consulta);						
	while ($FilaAux2 = mysqli_fetch_array($RespAux2))
	{
		switch ($FilaAux2["cod_leyes"])
		{				
			case "04":
				$FinoAg = $FilaAux2["valor"];
				break;
			case "05":
				$FinoAu = $FilaAux2["valor"];
				break;
		}						
	}			
	$Consulta = "SELECT * from proyecto_modernizacion.sub_clase ";
	$Consulta.= " where cod_clase=3004 and cod_subclase =".$MesConsulta;
	$RespAux = mysqli_query($link, $Consulta);
	if ($FilaAux = mysqli_fetch_array($RespAux))
	{
		$Letra = $FilaAux["nombre_subclase"];
	}
	$PesoTotal = 0;
	$TotalFinoCu = 0;
	$TotalFinoAg = $FinoAg;
	$TotalFinoAu = $FinoAu;
	//echo $TotalFinoAg." / ".$TotalFinoAu;
	$Consulta = "SELECT sum(peso_produccion) as peso_produccion, fecha_produccion  ";
	$Consulta.= " from sec_web.produccion_catodo ";
	$Consulta.= " where cod_producto='18'";
	$Consulta.= " and cod_subproducto ='5' ";
	$Consulta.= " and fecha_produccion between '".$FechaInicio."' and '".$FechaTermino."' ";		
	$Consulta.= " group by fecha_produccion";
	$Consulta.= " order by fecha_produccion"; 		
	$RespAux = mysqli_query($link, $Consulta);	
	while ($FilaAux = mysqli_fetch_array($RespAux))
	{					
		$Peso = $FilaAux["peso_produccion"];
		$PesoMes = $PesoMes + $Peso;
		$Fecha1 = date("Y-m-d",mktime(0,0,0,substr($FilaAux["fecha_produccion"],5,2),(substr($FilaAux["fecha_produccion"],8,2)-1),substr($FilaAux["fecha_produccion"],0,4)));
		$Fecha2 = date("Y-m-d",mktime(0,0,0,substr($FilaAux["fecha_produccion"],5,2),(substr($FilaAux["fecha_produccion"],8,2)+1),substr($FilaAux["fecha_produccion"],0,4)));				
		//-------LEYES DE CALIDAD DIARIAS DE Cu -----------------------------
		$Consulta = "SELECT t2.cod_leyes, t2.valor, t1.fecha_muestra, ";
		$Consulta.= " t2.signo, t1.nro_solicitud, t3.abreviatura ";
		$Consulta.= " from cal_web.solicitud_analisis t1 inner join ";
		$Consulta.= " cal_web.leyes_por_solicitud  t2 on t1.nro_solicitud = t2.nro_solicitud ";
		$Consulta.= " and t1.fecha_hora = t2.fecha_hora and t1.rut_funcionario = t2.rut_funcionario and t1.recargo = t2.recargo ";
		$Consulta.= " inner join proyecto_modernizacion.leyes t3 on t2.cod_leyes = t3.cod_leyes";				
		$Consulta.= " where t1.fecha_muestra between '".$Fecha1." 00:00:00' and '".$Fecha2." 23:59:59'";
		$Consulta.= " and t1.estado_actual <> '16' and t1.estado_actual <> '7'";
		$Consulta.= " and t1.frx <> 'S' and t1.cod_analisis = '1'";
		$Consulta.= " and t1.cod_periodo = '1'";			
		$Consulta.= " and t1.cod_producto = '18' and t1.cod_subproducto = '5'";
		$Consulta.= " and t2.cod_leyes = '02'";
		$Consulta.= " order by t1.fecha_muestra desc, t1.nro_solicitud, t2.cod_leyes ";
		$RespAux2 = mysqli_query($link, $Consulta);
		$FinoCu = 0;						
		while ($FilaAux2 = mysqli_fetch_array($RespAux2))
		{			
			switch ($FilaAux2["cod_leyes"])
			{
				case "02":
					$FinoCu = $FinoCu + ($Peso * $FilaAux2["valor"]);
					break;						
			}									
		}				
		//------------------------------------------------------------------------			
		echo "<tr> \n";
		echo "<td align='center'>".substr($FilaAux["fecha_produccion"],8,2)."/".substr($FilaAux["fecha_produccion"],5,2)."/".substr($FilaAux["fecha_produccion"],0,4)."</td>\n";		
		echo "<td align='right'>".number_format($Peso,0,",",".")."</td>\n";
		if ($FinoCu > 0 && $Peso > 0)
		{					
			echo "<td align='right'>".substr(number_format(($FinoCu/$Peso),4,",","."),0,5)."</td>\n";
			echo "<td align='right'>0</td>\n";
			echo "<td align='right'>0</td>\n";
			$FinoCu = $FinoCu / 100;
		}
		else
		{
			echo "<td align='right'>0</td>\n";
			echo "<td align='right'>0</td>\n";
			echo "<td align='right'>0</td>\n";
			$FinoCu = 0;
		}		
		echo "</tr>\n";
		$TotalFinoCu = $TotalFinoCu + $FinoCu;		
	}
?>
  <tr class="ColorTabla02"> 
    <td colspan="2"><strong>LEYES PONDERADAS</strong> 
      <?php //echo number_format($PesoMes,0,",","."); ?>
    <td align="right"> 
      <?php 
		if ($TotalFinoCu > 0 && $PesoMes > 0)
			echo number_format((($TotalFinoCu * 100/$PesoMes)),2,",","."); 
		else echo "0";
	?>
    </td>
    <td align="right"> 
      <?php 
		if ($TotalFinoAg > 0 && $PesoMes > 0)
			echo number_format($TotalFinoAg,2,",","."); 
		else echo "0";
			?>
    </td>
    <td align="right"> 
      <?php 
		if ($TotalFinoAu > 0 && $PesoMes > 0)
			echo number_format($TotalFinoAu,2,",","."); 
		else echo "0";
	?>
    </td>
    <!--<td align="right"><?php echo number_format($TotalFinoCu,0,",","."); ?></td>
    <td align="right"><?php echo number_format($TotalFinoAg,0,",","."); ?></td>
    <td align="right"><?php echo number_format($TotalFinoAu,0,",","."); ?></td>-->
  </tr>
</table>
<br>
<table width="650" border="1" align="center" cellpadding="2" cellspacing="0">
  <tr align="center" class="ColorTabla01"> 
    <td rowspan="2">SUBPRODUCTO</td>
    <td rowspan="2">SERIE</td>
    <td rowspan="2">PESO</td>
    <td colspan="3" align="center">LEYES</td>
    <td colspan="3" align="center">FINO</td>
  </tr>
  <tr class="ColorTabla01"> 
    <td height="25" align="center">Cu</td>
    <td align="center">Ag</td>
    <td align="center">Au</td>
    <td align="center">Cu</td>
    <td align="center">Ag</td>
    <td align="center">Au</td>
  </tr>
  <?php
  	$Cu = ($TotalFinoCu/$PesoMes) * 100;
	$Ag = $TotalFinoAg;
	$Au = $TotalFinoAu;
	$FechaInicio = $Ano."-".$Mes."-01";
	$FechaTermino = $Ano."-".$Mes."-31";	
	$AnoConsulta = $Ano; 
	$MesConsulta = $Mes;
	$Consulta = "SELECT * from proyecto_modernizacion.sub_clase ";
	$Consulta.= " where cod_clase=3004 and cod_subclase =".$MesConsulta;
	$RespAux = mysqli_query($link, $Consulta);
	if ($FilaAux = mysqli_fetch_array($RespAux))
	{
		$Letra = $FilaAux["nombre_subclase"];
	}
	$PesoTotal = 0;
	$TotalPondCu = 0;
	$TotalPondAg = 0;
	$TotalPondAu = 0;
	//CAT. E.W.
	$Producto = 18;
	$SubProducto = 5;					
		//CAT. E.W.
		$Consulta = "SELECT sum(peso_paquetes) as peso  ";
		$Consulta.= " from sec_web.paquete_catodo ";
		$Consulta.= " where cod_producto='".$Producto."'";
		$Consulta.= " and cod_subproducto ='".$SubProducto."' ";
		$Consulta.= " and cod_paquete='".$Letra."' ";
		$Consulta.= " and year(fecha_creacion_paquete)=".$AnoConsulta;
		$Consulta.= " group by cod_producto "; 	
		$RespAux = mysqli_query($link, $Consulta);			
		while ($FilaAux = mysqli_fetch_array($RespAux))
		{
			$Consulta = "SELECT * from proyecto_modernizacion.subproducto ";
			$Consulta.= " where cod_producto='".$Producto."' and cod_subproducto = '".$SubProducto."'";
			$RespAux2 = mysqli_query($link, $Consulta);
			if ($FilaAux2 = mysqli_fetch_array($RespAux2))
			{
				$Descripcion = $FilaAux2["descripcion"];
			}			
			$PesoTotal = $PesoTotal + $FilaAux["peso"];			
			$PondCu = ($Cu*$FilaAux["peso"]);
			$PondAg = ($Ag*$FilaAux["peso"]);
			$PondAu = ($Au*$FilaAux["peso"]);						
			echo "<tr> \n";
			echo "<td>".$Descripcion."</td>\n";
			echo "<td align='center'>".$Letra."</td>\n";		
			echo "<td align='right'>".number_format($FilaAux["peso"],0,",",".")."</td>\n";
			if ($PondCu > 0 && $FilaAux["peso"] > 0)
			{					
				echo "<td align='right'>".substr(number_format(($PondCu/$FilaAux["peso"]),4,",","."),0,5)."</td>\n";
				$PondCu = $PondCu / 100;
			}
			else
			{
				echo "<td align='right'>0</td>\n";
				$PondCu = 0;
			}
			if ($PondAg > 0 && $FilaAux["peso"] > 0)					
			{
				echo "<td align='right'>".number_format(($PondAg/$FilaAux["peso"]),2,",",".")."</td>\n";
				$PondAg = $PondAg / 1000;
			}
			else
			{
				echo "<td align='right'>0</td>\n";
				$PondAg = 0;
			}
			if ($PondAu > 0 && $FilaAux["peso"] > 0)					
			{
				echo "<td align='right'>".number_format(($PondAu/$FilaAux["peso"]),2,",",".")."</td>\n";
				$PondAu = $PondAu / 1000;
			}
			else
			{
				echo "<td align='right'>0</td>\n";
				$PondAu = 0;
			}
			echo "<td align='right'>".number_format($PondCu,0,",",".")."</td>\n";
			echo "<td align='right'>".number_format($PondAg,0,",",".")."</td>\n";
			echo "<td align='right'>".number_format($PondAu,0,",",".")."</td>\n";
			echo "</tr>\n";
			$TotalPondCu = $TotalPondCu + $PondCu;
			$TotalPondAg = $TotalPondAg + $PondAg;
			$TotalPondAu = $TotalPondAu + $PondAu;
		}			
	
?>
  <tr class="ColorTabla02"> 
    <td colspan="2" ><strong>TOTAL FLUJO</strong></td>
    <td align="right"><?php echo number_format($PesoTotal,0,",","."); ?></td>
    <td align="right"> 
      <?php 
		if ($TotalPondCu > 0 && $PesoTotal > 0)
			echo number_format((($TotalPondCu * 100/$PesoTotal)),2,",","."); 
		else echo "0";
	?>
    </td>
    <td align="right"> 
      <?php 
		if ($TotalPondAg > 0 && $PesoTotal > 0)
			echo number_format((($TotalPondAg * 1000/$PesoTotal)),2,",","."); 
		else echo "0";
			?>
    </td>
    <td align="right"> 
      <?php 
		if ($TotalPondAu > 0 && $PesoTotal > 0)
			echo number_format((($TotalPondAu * 1000/$PesoTotal)),2,",","."); 
		else echo "0";
	?>
    </td>
    <td align="right"><?php echo number_format($TotalPondCu,0,",","."); ?></td>
    <td align="right"><?php echo number_format($TotalPondAg,0,",","."); ?></td>
    <td align="right"><?php echo number_format($TotalPondAu,0,",","."); ?></td>
  </tr>
</table>
<br>
</body>
</html>
