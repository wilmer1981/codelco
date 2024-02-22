<?php
	include("../principal/conectar_principal.php");
	//include("sec_anexo_sec_funciones.php");

	if(isset($_REQUEST["Flujo"])){
		$Flujo = $_REQUEST["Flujo"];
	}else{
		$Flujo = "";
	}
	if(isset($_REQUEST["Ano"])){
		$Ano = $_REQUEST["Ano"];
	}else{
		$Ano = "";
	}
	if(isset($_REQUEST["Mes"])){
		$Mes = $_REQUEST["Mes"];
	}else{
		$Mes = "";
	}

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
<table width="510" border="1" align="center" cellpadding="2" cellspacing="0">
  <tr align="center" class="ColorTabla01"> 
    <td width="154" rowspan="2">QUINCENA</td>
    <td width="93" rowspan="2">PESO</td>
    <td colspan="3" align="center">LEYES</td>
    <!--<td colspan="3" align="center">FINO</td>-->
  </tr>
  <tr class="ColorTabla01"> 
    <td width="96" height="25" align="center">Cu</td>
    <td width="71" align="center">Ag</td>
    <td width="64" align="center">Au</td>
    <!--<td width="27" align="center">Cu</td>
    <td width="27" align="center">Ag</td>
    <td width="36" align="center">Au</td>-->
  </tr>
  <?php
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
	$TotalFinoCu = 0;
	$TotalFinoAg = 0;
	$TotalFinoAu = 0;
	for ($i=1;$i<=2;$i++)
	{
		switch ($i)
		{
			case 1:
				$Fecha1 = $Ano."-".$Mes."-01";
				$Fecha2 = $Ano."-".$Mes."-15";
				break;
			case 2:
				$Fecha1 = $Ano."-".$Mes."-16";
				$Fecha2 = $Ano."-".$Mes."-31";
				break;			
		}
		$Producto = 18;
		$SubProducto = 4;		
		$Consulta = "SELECT sum(peso_produccion) as peso_paquetes  ";
		$Consulta.= " from sec_web.produccion_catodo";
		$Consulta.= " where cod_producto='18'";
		$Consulta.= " and cod_subproducto ='4' ";//CAT. DESC. PARCIAL
		//$Consulta.= " and cod_paquete='".$Letra."' ";
		//$Consulta.= " and year(fecha_creacion_paquete)=".$AnoConsulta;
		$Consulta.= " and fecha_produccion between '".$Fecha1."' and '".$Fecha2."'";
		$Consulta.= " group by cod_producto,cod_subproducto"; 
		$RespAux = mysqli_query($link, $Consulta);
		$PesoMes=0; //WSO
		while ($FilaAux = mysqli_fetch_array($RespAux))
		{					
			$PesoQuincena = $FilaAux["peso_paquetes"];
			$PesoMes = $PesoMes + $PesoQuincena;
			//-------------------------LEYES DE CALIDAD-----------------------------
			$Consulta = "SELECT t2.cod_leyes, t2.valor, t1.fecha_muestra, ";
			$Consulta.= " t2.signo, t1.nro_solicitud, t3.abreviatura ";
			$Consulta.= " from cal_web.solicitud_analisis t1 inner join ";
			$Consulta.= " cal_web.leyes_por_solicitud  t2 on t1.nro_solicitud = t2.nro_solicitud ";
			$Consulta.= " and t1.fecha_hora = t2.fecha_hora and t1.rut_funcionario = t2.rut_funcionario and t1.recargo = t2.recargo ";
			$Consulta.= " inner join proyecto_modernizacion.leyes t3 on t2.cod_leyes = t3.cod_leyes";				
			$Consulta.= " where t1.fecha_muestra between '".$Fecha1." 00:00:00' and '".$Fecha2." 23:59:59'";
			$Consulta.= " and t1.estado_actual <> '16' and t1.estado_actual <> '7'";
			$Consulta.= " and t1.frx <> 'S' and t1.cod_analisis = '1'";
			$Consulta.= " and t1.cod_periodo = '5'";			
			$Consulta.= " and t1.cod_producto = '18' and t1.cod_subproducto = '4'";
			$Consulta.= " and (t2.cod_leyes = '02' or t2.cod_leyes = '04' or t2.cod_leyes = '05')";
			$Consulta.= " order by t1.fecha_muestra desc, t1.nro_solicitud, t2.cod_leyes ";
			$RespAux2 = mysqli_query($link, $Consulta);		
			while ($FilaAux2 = mysqli_fetch_array($RespAux2))
			{
				switch ($FilaAux2["cod_leyes"])
				{
					case "02":
						$FinoCu = $FinoCu + ($PesoQuincena * $FilaAux2["valor"]);
						break;
					case "04":
						$FinoAg = $FinoAg + ($PesoQuincena * $FilaAux2["valor"]);
						break;
					case "05":
						$FinoAu = $FinoAu + ($PesoQuincena * $FilaAux2["valor"]);
						break;
				}						
			}
			echo "<tr> \n";
			echo "<td align='center'>".$i."</td>\n";		
			echo "<td align='right'>".number_format($PesoQuincena,0,",",".")."</td>\n";
			if ($FinoCu > 0 && $PesoQuincena > 0)
			{					
				echo "<td align='right'>".substr(number_format(($FinoCu/$PesoQuincena),4,",","."),0,5)."</td>\n";
				$FinoCu = $FinoCu / 100;
			}
			else
			{
				echo "<td align='right'>0</td>\n";
				$FinoCu = 0;
			}
			if ($FinoAg > 0 && $PesoQuincena > 0)					
			{
				echo "<td align='right'>".number_format(($FinoAg/$PesoQuincena),2,",",".")."</td>\n";
				$FinoAg = $FinoAg / 1000;
			}
			else
			{
				echo "<td align='right'>0</td>\n";
				$Fino_Ag = 0;
			}
			if ($FinoAu > 0 && $PesoQuincena > 0)					
			{
				echo "<td align='right'>".number_format(($FinoAu/$PesoQuincena),2,",",".")."</td>\n";
				$FinoAu = $FinoAu / 1000;
			}
			else
			{
				echo "<td align='right'>0</td>\n";
				$FinoAu = 0;
			}
			/*echo "<td align='right'>".number_format($FinoCu,0,",",".")."</td>\n";
			echo "<td align='right'>".number_format($FinoAg,0,",",".")."</td>\n";
			echo "<td align='right'>".number_format($FinoAu,0,",",".")."</td>\n";*/
			echo "</tr>\n";
			$TotalFinoCu = $TotalFinoCu + $FinoCu;
			$TotalFinoAg = $TotalFinoAg + $FinoAg;
			$TotalFinoAu = $TotalFinoAu + $FinoAu;
			$FinoCu = 0;
			$FinoAg = 0;
			$FinoAu = 0;
		}			
	}
?>
  <tr class="ColorTabla02"> 
    <td colspan="2"><strong>LEYES PONDERADAS</strong> <?php //echo number_format($PesoMes,0,",","."); ?>&nbsp;<td align="right"> 
      <?php 
		if ($TotalFinoCu > 0 && $PesoMes > 0)
			echo number_format((($TotalFinoCu * 100/$PesoMes)),2,",","."); 
		else echo "0";
	?>
    </td>
    <td align="right"> 
      <?php 
		if ($TotalFinoAg > 0 && $PesoMes > 0)
			echo number_format((($TotalFinoAg * 1000/$PesoMes)),2,",","."); 
		else echo "0";
			?>
    </td>
    <td align="right"> 
      <?php 
		if ($TotalFinoAu > 0 && $PesoMes > 0)
			echo number_format((($TotalFinoAu * 1000/$PesoMes)),2,",","."); 
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
  	$Producto = 18;
	$SubProducto = 4;
  	$Cu = ($TotalFinoCu/$PesoMes) * 100;
	$Ag = ($TotalFinoAg/$PesoMes) * 1000;
	$Au = ($TotalFinoAu/$PesoMes) * 1000;
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
	//PRODUCTO CATODOS GRADO A  STANDARD				
		//PAQUETE GRADO A Y STANDARD
		$Consulta = "SELECT sum(peso_paquetes) as peso  ";
		$Consulta.= " from sec_web.paquete_catodo ";
		$Consulta.= " where cod_producto='".$Producto."'";
		$Consulta.= " and cod_subproducto ='".$SubProducto."' ";
		$Consulta.= " and cod_paquete='".$Letra."' ";
		$Consulta.= " and year(fecha_creacion_paquete)=".$Ano;
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
