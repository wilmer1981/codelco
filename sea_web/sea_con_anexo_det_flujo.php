<?php
	include("../principal/conectar_principal.php");

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

	$Consulta = "select * from proyecto_modernizacion.flujos where sistema='SEA' and cod_flujo='".$Flujo."'";
	$Resp = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Resp))
		$NomFlujo = $Fila["descripcion"];
?>
<html>
<head>
<title>Detalle de Flujo - SEA</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
</style></head>

<body>
<div align="center"><strong>FLUJO:&nbsp;<?php echo $Flujo." - ".strtoupper($NomFlujo); ?>
  </strong><br>
  <br>
</div>
<table width="600" border="1" align="center" cellpadding="3" cellspacing="0">
  <tr align="center" valign="middle" class="ColorTabla01">
    <td width="74" rowspan="2">Hornada</td>
    <td width="60" rowspan="2">Peso</td>
    <td colspan="3">Leyes</td>
    <td colspan="3">Fino</td>
  </tr>
  <tr class="ColorTabla01">
    <td width="53" align="center">Cu</td>
    <td width="53" align="center">Ag</td>
    <td width="59" align="center">Au</td>
    <td width="46" align="center">Cu</td>
    <td width="53" align="center">Ag</td>
    <td width="66" align="center">Au</td>
  </tr>
<?php
	//************************************** FLUJOS ********************************************			
	$Unidades = array('02'=>100,'04'=>1000,'05'=>1000);
	$Fecha_Ini = $Ano."-".str_pad($Mes,2,"0",STR_PAD_LEFT)."-01";
	//$Fecha_Ter = $Ano."-".str_pad($Mes,2,"0",STR_PAD_LEFT)."-31";
	$Fecha_Ini_Hora = $Ano."-".str_pad($Mes,2,"0",STR_PAD_LEFT)."-01 08:00:00";
	//$Fecha_Ter = $Ano."-".str_pad($Mes,2,"0",STR_PAD_LEFT)."-31";
	if($Mes==12)
	{
		$Fecha_Ter = ($Ano+1)."-".str_pad(1,2,"0",STR_PAD_LEFT)."-01";
		$Fecha_Ter_Hora = ($Ano+1)."-".str_pad(1,2,"0",STR_PAD_LEFT)."-01 07:59:59";
	}	
	else
	{
		$Fecha_Ter = $Ano."-".str_pad(($Mes+1),"0",STR_PAD_LEFT)."-01";
		$Fecha_Ter2 = $Ano."-".str_pad($Mes,"0",STR_PAD_LEFT)."-31";
		$Fecha_Ter_Hora = $Ano."-".str_pad(($Mes+1),"0",STR_PAD_LEFT)."-01 07:59:59";
	}	
	
	//Consulta si el flujo representa el movimiento de beneficio
	$Consulta = "SELECT * FROM proyecto_modernizacion.relacion_prod_flujo_nodo";
	$Consulta.= " WHERE flujo = '".$Flujo."'";	
	$Resp3 = mysqli_query($link, $Consulta);
	if ($Fila3 = mysqli_fetch_array($Resp3))
	{
		if ($Fila3["cod_proceso"] == 2)			
			$Beneficio = "S";
		else					
			$Beneficio = "N";
	}
	else
	{		
		$Beneficio = "N";
	}					
		
	//Calcula los finos
	if ($Beneficio == "S")
	{
		$Consulta = "SELECT t1.cod_producto, t1.cod_subproducto, t1.hornada,";
		$Consulta.= " t1.fecha_movimiento, sum(t1.peso) AS peso_hornada";
		$Consulta.= " FROM sea_web.movimientos AS t1";
		$Consulta.= " WHERE t1.flujo = '".$Flujo."'";
		$Consulta.= " AND ((t1.fecha_movimiento BETWEEN '".$Fecha_Ini."' AND '".$Fecha_Ter."' and hora between '$Fecha_Ini_Hora' and '$Fecha_Ter_Hora'";
		$Consulta.= " AND t1.fecha_benef = '0000-00-00')";
		$Consulta.= " OR (t1.fecha_benef BETWEEN '".$Fecha_Ini."' AND '".$Fecha_Ter."'))";
		$Consulta.= " GROUP BY t1.hornada";
		$Consulta.= " ORDER BY t1.hornada";
	}
	else
	{
		$Consulta = "SELECT t1.cod_producto, t1.cod_subproducto, t1.hornada,";
		$Consulta.= " t1.fecha_movimiento, sum(t1.peso) AS peso_hornada";
		$Consulta.= " FROM sea_web.movimientos AS t1";
		$Consulta.= " WHERE t1.flujo = '".$Flujo."'";
		$Consulta.= " AND t1.fecha_movimiento BETWEEN '".$Fecha_Ini."' AND '".$Fecha_Ter."' and hora between '$Fecha_Ini_Hora' and '$Fecha_Ter_Hora'";
		$Consulta.= " GROUP BY t1.hornada";		
		$Consulta.= " ORDER BY t1.hornada";		
	}
	//if($Flujo=='123')
	//	echo $Consulta."<br>";
	//echo $Consulta."<br>";
	$Registros = array();
	$Resp7 = mysqli_query($link, $Consulta);
	while ($Fila7 = mysqli_fetch_array($Resp7))		
	{
		//STOCK PISO RAF
		$Consulta = "SELECT SUM(peso) AS peso_piso FROM sea_web.stock_piso_raf";
		$Consulta.= " where cod_producto='".$Fila7["cod_producto"]."' ";
		$Consulta.= " and cod_subproducto='".$Fila7["cod_subproducto"]."' ";
		$Consulta.= " and hornada='".$Fila7["hornada"]."'";
		$Consulta.= " AND fecha BETWEEN '".$Fecha_Ini."' AND '".$Fecha_Ter2."'";
		$Consulta.= " AND flujo='".$Fila["cod_flujo"]."'";
		$RespPiso = mysqli_query($link, $Consulta);
	//if($Flujo=='123')
	//	echo $Consulta."<br>";
		if ($FilaPiso = mysqli_fetch_array($RespPiso))
			$PesoPiso = $FilaPiso["peso_piso"];
		else
			$PesoPiso = 0;
		$PesoH = ($Fila7["peso_hornada"] - $PesoPiso);
		//LEYES DE HORNADA
		$Consulta = "select * from sea_web.leyes_por_hornada ";
		$Consulta.= " where cod_producto='".$Fila7["cod_producto"]."' ";
		$Consulta.= " and cod_subproducto='".$Fila7["cod_subproducto"]."' ";
		$Consulta.= " and hornada='".$Fila7["hornada"]."'";
		$Consulta.= " and cod_leyes in('02','04','05')";
		$RespLeyes = mysqli_query($link, $Consulta);
		$Entro = false;
		while ($FilaLeyes = mysqli_fetch_array($RespLeyes))
		{							
			$Registros[$Fila7["hornada"]][10] = $Fila7["hornada"];
			$Registros[$Fila7["hornada"]][11] = $PesoH;
			$Registros[$Fila7["hornada"]][12] = $Fila7["fecha_movimiento"];
			$Registros[$Fila7["hornada"]][$FilaLeyes["cod_leyes"]] = $FilaLeyes["valor"];
		}
		if (!$Entro)
		{
			$Registros[$Fila7["hornada"]][10] = $Fila7["hornada"];
			$Registros[$Fila7["hornada"]][11] = $PesoH;
			$Registros[$Fila7["hornada"]][12] = $Fila7["fecha_movimiento"];
			$Registros[$Fila7["hornada"]][02] = 0;

			$Registros[$Fila7["hornada"]][10] = $Fila7["hornada"];
			$Registros[$Fila7["hornada"]][11] = $PesoH;
			$Registros[$Fila7["hornada"]][12] = $Fila7["fecha_movimiento"];
			$Registros[$Fila7["hornada"]][04] = 0;

			$Registros[$Fila7["hornada"]][10] = $Fila7["hornada"];
			$Registros[$Fila7["hornada"]][11] = $PesoH;
			$Registros[$Fila7["hornada"]][12] = $Fila7["fecha_movimiento"];
			$Registros[$Fila7["hornada"]][05] = 0;
		}	
	}
	
	reset($Registros);
	//while (list($k,$v)=each($Registros))
	$TotalAg=0; //WSO
	$TotalAu=0; //WSO
	$TotalPeso=0; //WSO
	$TotalCu=0; //WSO
	foreach($Registros as $k => $v )
	{
		if ($v[11]>0)
		{
			if(isset($v["02"])){
			  $v02=$v["02"];
			}else{
				$v02=0;
			}
			if(isset($v["04"])){
				$v04=$v["04"];
			  }else{
				  $v04=0;
			  }
			  if(isset($v["05"])){
				$v05=$v["05"];
			  }else{
				  $v05=0;
			  }
			echo"<tr>";
			//echo"<td align='center'>".substr($v[12],8,2)."-".substr($v[12],5,2)."-".substr($v[12],0,4)."</td>";
			echo"<td align='center'>".substr($v[10],6)."</td>";
			echo"<td align='right'>".number_format($v[11],0,",",".")."</td>";		
			echo"<td align='right'>".number_format($v02,2,",",".")."</td>";		
			echo"<td align='right'>".number_format($v04,2,",",".")."</td>";
			echo"<td align='right'>".number_format($v05,2,",",".")."</td>";
			echo"<td align='right'>".number_format(($v02*$v[11])/$Unidades["02"],0,",",".")."</td>";		
			echo"<td align='right'>".number_format(($v04*$v[11])/$Unidades["04"],0,",",".")."</td>";
			echo"<td align='right'>".number_format(($v05*$v[11])/$Unidades["05"],0,",",".")."</td>";
			echo"</tr>";
			$TotalPeso = $TotalPeso + $v[11];
			$TotalCu = $TotalCu + ($v02*$v[11])/$Unidades["02"];
			$TotalAg = $TotalAg + ($v04*$v[11])/$Unidades["04"];
			$TotalAu = $TotalAu + ($v05*$v[11])/$Unidades["05"];
		}
	}
	
	//INCLUYE EL STOCK PISO DEL MES ANTERIOR EN LOS TRASPASOS Y LUEGO RESTA EL STOCK PISO DEL MES ACTUAL
	$Registros = array();
	$Consulta = "SELECT * FROM sea_web.stock_piso_raf";
	$Consulta.= " WHERE flujo = '".$Flujo."'";	
 	$Consulta.= " AND fecha BETWEEN SUBDATE('".$Fecha_Ini."', INTERVAL 1 MONTH)";
 	$Consulta.= " AND SUBDATE('".$Fecha_Ini."', INTERVAL 1 DAY)";
	$Resp8 = mysqli_query($link, $Consulta);
	//if($Flujo=='123')
	//	echo $Consulta."<br>";				
	//echo $Consulta;
	while ($Fila8 = mysqli_fetch_array($Resp8))
	{
		$Consulta = "SELECT IFNULL(SUM(peso),0) AS peso FROM sea_web.stock_piso_raf";
		$Consulta.= " WHERE flujo = '".$Flujo."'";
		$Consulta.= " AND fecha BETWEEN '".$Fecha_Ini."' AND '".$Fecha_Ter2."'";
		$Consulta.= " AND cod_producto = '".$Fila8["cod_producto"]."'";
		$Consulta.= " AND cod_subproducto = '".$Fila8["cod_subproducto"]."'";
		$Consulta.= " AND hornada = '".$Fila8["hornada"]."'";
		$Resp9 = mysqli_query($link, $Consulta);
		$Fila9= mysqli_fetch_array($Resp9);
		//if($Flujo=='402')
		//	echo $Consulta."<br>";			
		$Consulta = "SELECT cod_leyes, valor FROM sea_web.leyes_por_hornada";
		$Consulta.= " WHERE cod_producto = '".$Fila8["cod_producto"]."'";
		$Consulta.= " AND cod_subproducto = '".$Fila8["cod_subproducto"]."'";
		$Consulta.= " AND hornada = '".$Fila8["hornada"]."'";
		$Consulta.= " AND cod_leyes IN ('02','04','05')";
		$Resp10 = mysqli_query($link, $Consulta);
		
		if ($Fila8["peso"] == $Fila9["peso"])
		{
			while ($Fila10 = mysqli_fetch_array($Resp10))
			{				
				$PesoH = $Fila8["peso"];
				//echo $PesoH."<br>"					;
				$Registros[$Fila8["hornada"]][10] = $Fila8["hornada"];
				$Registros[$Fila8["hornada"]][11] = $PesoH;
				$Registros[$Fila8["hornada"]][12] = $Fila8["fecha"];
				$Registros[$Fila8["hornada"]][$Fila10["cod_leyes"]] = $Fila10["valor"];
			}
		}
		else
		{
			while ($Fila10 = mysqli_fetch_array($Resp10))
			{				
				$PesoH = ($Fila8["peso"] - $Fila9["peso"]);					
				$Registros[$Fila8["hornada"]][10] = $Fila8["hornada"];
				$Registros[$Fila8["hornada"]][11] = $PesoH;
				$Registros[$Fila8["hornada"]][12] = $Fila8["fecha"];
				$Registros[$Fila8["hornada"]][$Fila10["cod_leyes"]] = $Fila10["valor"];
			}
		}						
	}		
	reset($Registros);
	//while (list($k,$v)=each($Registros))
	foreach($Registros as $k => $v )
	{
		echo"<tr>";
		//echo"<td align='center'>".substr($v[12],8,2)."-".substr($v[12],5,2)."-".substr($v[12],0,4)."</td>";
		echo"<td align='center'>".substr($v[10],6)."</td>";
		echo"<td align='right'>".number_format($v[11],0,",",".")."</td>";		
		echo"<td align='right'>".number_format($v["02"],2,",",".")."</td>";		
		echo"<td align='right'>".number_format($v["04"],2,",",".")."</td>";
		echo"<td align='right'>".number_format($v["05"],2,",",".")."</td>";
		echo"<td align='right'>".number_format(($v["02"]*$v[11])/$Unidades["02"],0,",",".")."</td>";		
		echo"<td align='right'>".number_format(($v["04"]*$v[11])/$Unidades["04"],0,",",".")."</td>";
		echo"<td align='right'>".number_format(($v["05"]*$v[11])/$Unidades["05"],0,",",".")."</td>";
		echo"</tr>";
		$TotalPeso = $TotalPeso + $v[11];
		$TotalCu = $TotalCu + ($v["02"]*$v[11])/$Unidades["02"];
		$TotalAg = $TotalAg + ($v["04"]*$v[11])/$Unidades["04"];
		$TotalAu = $TotalAu + ($v["05"]*$v[11])/$Unidades["05"];
	}   							
?>  
  <tr align="right">
    <td><strong>TOTAL</strong></td>
    <td><?php echo number_format($TotalPeso,0,",","."); ?></td>
    <td><?php echo number_format(($TotalCu/$TotalPeso)*$Unidades["02"],2,",","."); ?></td>
    <td><?php echo number_format(($TotalAg/$TotalPeso)*$Unidades["04"],2,",","."); ?></td>
    <td><?php echo number_format(($TotalAu/$TotalPeso)*$Unidades["05"],2,",","."); ?></td>
    <td><?php echo number_format($TotalCu,0,",","."); ?></td>
    <td><?php echo number_format($TotalAg,0,",","."); ?></td>
    <td><?php echo number_format($TotalAu,0,",","."); ?></td>
  </tr>
</table>
</body>
</html>
