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
	include("../principal/conectar_sec_web.php");

	$FinoLeyes   = isset($_REQUEST["FinoLeyes"])?$_REQUEST["FinoLeyes"]:"";
	$AnoIni  = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:date("Y");
	$MesIni  = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:date("m");
	$DiaIni  = isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:"01";
	$AnoFin  = isset($_REQUEST["AnoFin"])?$_REQUEST["AnoFin"]:date("Y");
	$MesFin  = isset($_REQUEST["MesFin"])?$_REQUEST["MesFin"]:date("m");
	$DiaFin  = isset($_REQUEST["DiaFin"])?$_REQUEST["DiaFin"]:"30";
	$dia = isset($_REQUEST["dia"])?$_REQUEST["dia"]:"";

	$Producto     = isset($_REQUEST["Producto"])?$_REQUEST["Producto"]:"";
	$SubProducto  = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";

	if ($FinoLeyes == "F")
		$Unidad = "kg";
	else	$Unidad = "%";
	if ($DiaIni=="")
	{
		//$DiaFin = "30";
		$MesFin = str_pad($MesFin,2, "0", STR_PAD_LEFT);
		$AnoFin = $AnoFin;
		//$DiaIni = "01";
		$MesIni = $MesFin;
		$AnoIni = $AnoFin;		
	}
	$FechaInicio = $AnoIni."-".$MesIni."-".$DiaIni;	
	$FechaTermino = $AnoFin."-".$MesFin."-".$DiaFin;
	$Consulta = "SELECT * from proyecto_modernizacion.subproducto where cod_producto = '".$Producto."' and cod_subproducto = '".$SubProducto."'";	
	$Respuesta = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		$subproducto = $Fila["descripcion"];
	}
	else
	{
		$subproducto = "";
	}
	
?>
<html>
<head>
<title>Sistema Estadistico de Catodos</title>
</head>
<body>
<form name="formulario" method="post" action="">
  <?php 
  
  ?>
  <table width="622" border="1" cellspacing="0" cellpadding="2" class="TablaInterior">
    <tr align="center">
      <td height="30" colspan="10"><strong>TIPO DE MOVIMIENTO PESAJE DE PRODUCCION</strong></td>
    </tr>
    <tr> 
      <td width="127" colspan="3"><strong>PRODUCTO</strong></td>
      <td width="232" colspan="7">BARROS REFINERIA </td>
    </tr>
    <tr>
      <td colspan="3"><strong>SUBPRODUCTO</strong></td>
      <td colspan="7"><?php echo $subproducto; ?></td>
    </tr>
    <tr> 
      <td colspan="3"><strong>PERIODO</strong></td>
      <td colspan="7">
        <?php 
	  	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	  	echo $Meses[$MesFin - 1]." del ".$AnoFin; 
		?>
      </td>
    </tr>
  </table>
  <br>
<?php
	$ArrLeyes = array();
	$fecha_ini = $AnoIni.'-'.$MesIni.'-'.$DiaIni;
	$fecha_ter = $AnoFin.'-'.$MesFin.'-'.$DiaFin; 
	$Consulta="SELECT distinct t1.cod_leyes, t2.abreviatura, t2.cod_unidad, t3.abreviatura as unidad ";
	$Consulta=$Consulta." from cal_web.leyes_por_solicitud t1 inner join proyecto_modernizacion.leyes t2 ";
	$Consulta=$Consulta." on t1.cod_leyes = t2.cod_leyes inner join proyecto_modernizacion.unidades t3 on t1.cod_unidad = t3.cod_unidad";
	$Consulta=$Consulta." where t1.cod_producto = '".$Producto."' ";
	$Consulta=$Consulta." and t1.cod_subproducto = '".$SubProducto."' ";
	$Consulta=$Consulta." and t1.fecha_hora between '".$fecha_ini."' and '".$fecha_ter."'";
	$Consulta=$Consulta." and t1.cod_leyes <> '01'";
	$Consulta=$Consulta." order by t1.cod_leyes";
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Respuesta))
	{		
		$ArrLeyes[$Fila["cod_leyes"]][0] = $Fila["cod_leyes"];
		$ArrLeyes[$Fila["cod_leyes"]][1] = ""; //VALOR
		$ArrLeyes[$Fila["cod_leyes"]][2] = $Fila["abreviatura"];
		$ArrLeyes[$Fila["cod_leyes"]][3] = ""; //CONVERSION
		$ArrLeyes[$Fila["cod_leyes"]][4] = $Fila["unidad"];
		$ArrLeyes[$Fila["cod_leyes"]][5] = "";//MENSUAL
		$ArrLeyes[$Fila["cod_leyes"]][6] = "";//SEMANAL
	}	
	$Largo = 500 + (count($ArrLeyes)*50);
	$ColSpan = count($ArrLeyes) + 7;
?>  
  <table width="<?php echo $Largo ?>" height="24" border="1" cellpadding="2" cellspacing="0" class="TablaDetalle">
    <?php
    	if($FinoLeyes == "F")	
		{
			 echo'<tr>
				  <td align="center" colspan="'.$ColSpan.'">F I N O S</td>
				  </tr>';
		}
		else
		{
			 echo'<tr>
				  <td align="center" colspan="'.$ColSpan.'">L E Y E S</td>
				  </tr>';
		}
   ?>
    <tr class="ColorTabla01"> 
      <td align="center" width="100">Fecha </td>
      <td align="center" width="50">Cant.</td>
      <td align="center" width="50">P. Humedo</td>
      <td align="center" width="100">S.A/Certif</td>
      <td align="center" width="50">Humed.<br>%</td>
      <td align="center" width="50">P. Seco</td>
	  <td align="center" width="100">S.A</td>
<?php	
	reset($ArrLeyes);
	foreach($ArrLeyes as $v => $k)
	{
		echo "<td align='center' width='50'>".$k[2]."<br>".$k[4]."</td>\n";	
	}
?>	  
    </tr>    
<?php
$fecha_aux = $fecha_ini;
$Cont = 0;
$TotalPHum = 0;
$TotalPSeco = 0;
$TotalCant = 0;
$TotalCu = 0;
$TotalAs = 0;
$TotalSb = 0;
$TotalFe = 0;
$TotalNi = 0;
$TotalPb = 0;
while(date($fecha_aux) <= date($fecha_ter)) //Recorre los dias.
{
		//******************************CORTE DE SEMANAS******************************************
		if($dia == '07' || $dia == '14' || $dia == '21' || $dia == '30')
		{  	
			if ($dia == 7)
			{
				$Fecha1 = $AnoFin."-".$MesFin."-01";					
				$Fecha2 = $AnoFin."-".$MesFin."-07";
			}
			else
			{
				if ($dia == 14)
				{					
					$Fecha1 = $AnoFin."-".$MesFin."-08";					
					$Fecha2 = $AnoFin."-".$MesFin."-14";
				}
				else
				{
					if ($dia == 21)
					{					
						$Fecha1 = $AnoFin."-".$MesFin."-15";					
						$Fecha2 = $AnoFin."-".$MesFin."-21";
					}
					else
					{
						if (($dia >= 22) && ($dia <= 30))
						{				
							$Fecha1 = $AnoFin."-".$MesFin."-22";					
							$Fecha2 = $AnoFin."-".$MesFin."-30";
						}
					}							
				}								
			}
			if ($SumPesoSeco > 0 && $SumPesoHumedo > 0)
				$PorcHumedad = abs(100 - (($SumPesoSeco/$SumPesoHumedo)*100));
			else
				$PorcHumedad = 0;
			echo'<tr class="detalle01">';
			echo'<td>Total Semana</td>';
			echo'<td align="center">'.number_format($CantSemana,0,",",".").'</td>';
			echo'<td align="center">'.number_format($SumPesoHumedo,0,",",".").'</td>';
			echo'<td align="center">&nbsp;</td>';
			echo'<td align="center">'.number_format($PorcHumedad,2,",",".").'</td>';
			echo'<td align="center">'.number_format($SumPesoSeco,0,",",".").'</td>';
			echo'<td align="center">&nbsp;</td>';			
			reset($ArrLeyes);
			foreach($ArrLeyes as $v => $k)
			{					
				switch ($FinoLeyes)
				{
					case "F":
						echo "<td align='center'>".number_format($k[6],2,",",".")."</td>";	
						break;
					case "L":
						if ($SumPesoSeco>0 && $k[6]>0 && $k[3]>0)
							$Fino = (($k[6]/$SumPesoSeco)*$k[3]);
						else
							$Fino=0;
						echo "<td align='center'>".number_format($Fino,2,",",".")."</td>";
						break;
				}
				$ArrLeyes[$k[0]][5] = $ArrLeyes[$k[0]][5] + $k[6];
			}			
			//Acumuladores		
			$PorcHumedad = "";
			$SumPesoSeco = "";
			$CantSemana = "";
			$SumPesoHumedo = "";
			$Cont = 0;
			//LIMPIA ARREGLO DE LEYES
			reset($ArrLeyes);
			foreach($ArrLeyes as $key => $values)
			{				
				$ArrLeyes[$key][6] = "";				
			}
		}
		//FIN SEMANAS
		$dia = substr($fecha_aux,8,2);
		$Consulta = "SELECT t1.fecha_produccion,sum(t1.peso_produccion) as peso_produccion, sum(t1.peso_tara) as peso_tara, count(*) as cant ";
		$Consulta.= " from sec_web.produccion_catodo t1";
		$Consulta.= " where t1.cod_producto = '".$Producto."' ";
		$Consulta.= " and t1.cod_subproducto = '".$SubProducto."' ";
		$Consulta.= " and t1.fecha_produccion ='".$fecha_aux."'";
		$Consulta.= " group by fecha_produccion";		
		$Rs = mysqli_query($link, $Consulta);
		while($Fila = mysqli_fetch_array($Rs))
		{			
			//LIMPIA ARREGLO LEYES	
			$Consulta = "SELECT t2.nro_solicitud, ifnull(t3.valor,0)as valor";
			$Consulta.= " from cal_web.solicitud_analisis t2 ";
			$Consulta.= " inner join cal_web.leyes_por_solicitud t3 on t2.fecha_hora=t3.fecha_hora ";
			$Consulta.= " and t2.nro_solicitud=t3.nro_solicitud and t3.cod_producto=t2.cod_producto ";
			$Consulta.= " and t3.cod_subproducto=t2.cod_subproducto ";
			$Consulta.= " where t2.cod_producto = '".$Producto."' ";
			$Consulta.= " and t2.cod_subproducto = '".$SubProducto."' ";
			$Consulta.= " and left(t2.fecha_muestra,10) ='".$fecha_aux."'";
			$Consulta.= " and t3.cod_leyes='01' ";
			$Consulta.= " and t2.estado_actual <> '16' and t2.estado_actual <> '7'";
			$Consulta.= " and t2.frx <> 'S' and t2.cod_analisis = '1' and t2.tipo = '1'";	
			$Rs2 = mysqli_query($link, $Consulta);
			if($Fila2 = mysqli_fetch_array($Rs2))
			{
				$NroSA = $Fila2["nro_solicitud"];
				$PorcHum = $Fila2["valor"];
			}
			else
			{
				$NroSA = "";
				$PorcHum = 0;
			}
			reset($ArrLeyes);
			do {			 
			  $key = key ($ArrLeyes);
			  $ArrLeyes[$key][1] = "";
			} while (next($ArrLeyes));				
			echo'<tr>';
			echo'<td align="center">'.$Fila["fecha_produccion"].'</td>';
			echo'<td align="center">'.$Fila["cant"].'</td>';
			$TotalCant = $TotalCant + $Fila["cant"];
			$CantSemana = $CantSemana + $Fila["cant"];
			echo'<td align="center">'.number_format($Fila["peso_produccion"]-$Fila["peso_tara"],0,",",".").'</td>';
			if ($NroSA=="")
				echo'<td align="center">&nbsp;</td>';
			else
				echo'<td align="center">'.$NroSA.'</td>';
			echo'<td align="center">'.number_format($PorcHum,2,",",".").'</td>';					  
			$PesoHum = (($Fila["peso_produccion"]-$Fila["peso_tara"])*$PorcHum)/100;
			$PesoSeco = ($Fila["peso_produccion"]-$Fila["peso_tara"]) - $PesoHum;
			$TotalPHum = $TotalPHum + ($Fila["peso_produccion"]-$Fila["peso_tara"]);
			$TotalPSeco = $TotalPSeco + $PesoSeco;
			$SumPesoHumedo = $SumPesoHumedo + ($Fila["peso_produccion"]-$Fila["peso_tara"]);
			$SumPesoSeco = $SumPesoSeco + $PesoSeco;		
			echo'<td align="center">'.number_format($PesoSeco,0,",",".").'</td>';
			//RESCATA LEYES DE CALIDAD
		 	$Consulta = " SELECT t1.fecha_produccion, t2.nro_solicitud, t3.cod_leyes, ifnull(t3.valor,0) as valor, t3.cod_unidad, t4.conversion ";
			$Consulta.= " from sec_web.produccion_catodo t1";
			$Consulta.= " left join cal_web.solicitud_analisis t2 on t1.fecha_produccion=left(t2.fecha_muestra,10) and ";
			$Consulta.= " t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
			$Consulta.= " left join cal_web.leyes_por_solicitud t3 on t2.fecha_hora=t3.fecha_hora ";
			$Consulta.= " and t2.nro_solicitud=t3.nro_solicitud and t3.cod_producto=t2.cod_producto ";
			$Consulta.= " and t3.cod_subproducto=t2.cod_subproducto inner join proyecto_modernizacion.unidades t4 ";
			$Consulta.= " on t3.cod_unidad = t4.cod_unidad ";
			$Consulta.= " where t1.cod_producto = '".$Producto."' ";
			$Consulta.= " and t1.cod_subproducto = '".$SubProducto."' ";
			$Consulta.= " and t1.fecha_produccion ='".$fecha_aux."'";
			$Consulta.= " and t2.cod_periodo = '1' ";
			$Consulta.= " and t2.estado_actual <> '16' and t2.estado_actual <> '7'";
			$Consulta.= " and t2.frx <> 'S' and t2.cod_analisis = '1' and t2.tipo = '1'";
			$Consulta.= " AND t3.cod_leyes IN(";
			reset($ArrLeyes);
			foreach($ArrLeyes as $v => $k)
			{
				$Consulta.= "'".$k[0]."',";
			}
			$Consulta = substr($Consulta,0,strlen($Consulta)-1);
			$Consulta.= ")";
			$Consulta.= " ORDER BY t3.cod_leyes";	
			$Resp2 = mysqli_query($link, $Consulta);
			$SA = "";			
			while ($Fila2 = mysqli_fetch_array($Resp2))
			{
				$SA = $Fila2["nro_solicitud"];
				$ArrLeyes[$Fila2["cod_leyes"]][1] = $Fila2["valor"];
				$ArrLeyes[$Fila2["cod_leyes"]][3] = $Fila2["conversion"];
				$ArrLeyes[$Fila2["cod_leyes"]][6] = $ArrLeyes[$Fila2["cod_leyes"]][6] + (($PesoSeco*$Fila2["valor"])/$Fila2["conversion"]);
			}
			if ($SA != "")
				echo'<td align="center">'.$SA.'</td>';
			else
				echo'<td align="center">&nbsp;</td>';
			reset($ArrLeyes);
			foreach($ArrLeyes as $v => $k)
			{
				switch ($FinoLeyes)
				{
					case "L":
						echo "<td align='center'>".number_format($k[1],2,",",".")."</td>";	
						break;
					case "F":
						if ($PesoSeco>0 && $k[1]>0 && $k[3]>0)
							$Fino = (($PesoSeco*$k[1])/$k[3]);
						else
							$Fino=0;
						echo "<td align='center'>".number_format($Fino,2,",",".")."</td>";
						break;
				}													
			}			
			//Vars. Acumuladores
			$Cont++;					  	
			echo'</tr>';
		}

		$consulta = "SELECT DATE_ADD('".$fecha_aux."',INTERVAL 1 DAY) AS fecha";
		$rs10 = mysqli_query($link, $consulta);
		$row10 = mysqli_fetch_array($rs10);
		$fecha_aux = $row10["fecha"];		
}	//******************************CORTE PARA LA ULTIMA SEMANA******************************************
	if($dia == '07' || $dia == '14' || $dia == '21' || $dia == '30')
	{  	
		if ($dia == 7)
		{
			$Fecha1 = $AnoFin."-".$MesFin."-01";					
			$Fecha2 = $AnoFin."-".$MesFin."-07";
		}
		else
		{
			if ($dia == 14)
			{					
				$Fecha1 = $AnoFin."-".$MesFin."-08";					
				$Fecha2 = $AnoFin."-".$MesFin."-14";
			}
			else
			{
				if ($dia == 21)
				{					
					$Fecha1 = $AnoFin."-".$MesFin."-15";					
					$Fecha2 = $AnoFin."-".$MesFin."-21";
				}
				else
				{
					if (($dia >= 22) && ($dia <= 30))
					{				
						$Fecha1 = $AnoFin."-".$MesFin."-22";					
						$Fecha2 = $AnoFin."-".$MesFin."-30";
					}
				}							
			}								
		}
		if ($SumPesoSeco > 0 && $SumPesoHumedo > 0)
			$PorcHumedad = abs(100 - (($SumPesoSeco/$SumPesoHumedo)*100));
		else
			$PorcHumedad = 0;
		echo'<tr class="detalle01">';
		echo'<td>Total Semana</td>';
		echo'<td align="center">'.number_format($CantSemana,0,",",".").'</td>';
		echo'<td align="center">'.number_format($SumPesoHumedo,0,",",".").'</td>';
		echo'<td align="center">&nbsp;</td>';
		echo'<td align="center">'.number_format($PorcHumedad,2,",",".").'</td>';
		echo'<td align="center">'.number_format($SumPesoSeco,0,",",".").'</td>';
		echo'<td align="center">&nbsp;</td>';			
		reset($ArrLeyes);
		foreach($ArrLeyes as $v => $k)
		{					
			switch ($FinoLeyes)
			{
				case "F":
					echo "<td align='center'>".number_format($k[6],2,",",".")."</td>";	
					break;
				case "L":
					if ($SumPesoSeco>0 && $k[6]>0 && $k[3]>0)
						$Fino = (($k[6]/$SumPesoSeco)*$k[3]);
					else
						$Fino=0;
					echo "<td align='center'>".number_format($Fino,2,",",".")."</td>";
					break;
			}
			$ArrLeyes[$k[0]][5] = $ArrLeyes[$k[0]][5] + $k[6];
		}			
		//Acumuladores		
		$PorcHumedad = "";
		$SumPesoSeco = "";
		$CantSemana = "";
		$SumPesoHumedo = "";
		$Cont = 0;
		//LIMPIA ARREGLO DE LEYES
		reset($ArrLeyes);
		foreach($ArrLeyes as $key => $values)
		{				
			$ArrLeyes[$key][6] = "";				
		}		
	}		
?>
<tr>
      <td align="center"><strong>TOTAL MES</strong></td>
      <td align="center"><?php echo number_format($TotalCant,0,",","."); ?></td>
      <td align="center"><?php echo number_format($TotalPHum,0,",","."); ?></td>
      <td align="center">&nbsp;</td>
      <td align="center"><?php 
	  			if($TotalPHum>0){
					$TotalMes = (($TotalPHum-$TotalPSeco)*100)/$TotalPHum;
				}else{
					$TotalMes = 0;
				}
	 // echo number_format((($TotalPHum-$TotalPSeco)*100)/$TotalPHum,2,",","."); 
	  echo number_format($TotalMes,2,",","."); 
	  ?></td>
      <td align="center"><?php echo number_format($TotalPSeco,0,",","."); ?></td> 
<?php
	 
	reset($ArrLeyes);
	do {			 
	  $key = key ($ArrLeyes);
	  $ArrLeyes[$key][1] = "";
	} while (next($ArrLeyes));	
	$Consulta = " SELECT t2.nro_solicitud, t3.cod_leyes, ifnull(t3.valor,0) as valor, t4.conversion";
	$Consulta.= " from cal_web.solicitud_analisis t2 ";
	$Consulta.= " left join cal_web.leyes_por_solicitud t3 on t2.fecha_hora=t3.fecha_hora ";
	$Consulta.= " and t2.nro_solicitud=t3.nro_solicitud and t3.cod_producto=t2.cod_producto ";
	$Consulta.= " and t3.cod_subproducto=t2.cod_subproducto inner join proyecto_modernizacion.unidades t4 ";
	$Consulta.= " on t3.cod_unidad = t4.cod_unidad ";
	$Consulta.= " where t2.cod_producto = '".$Producto."' ";
	$Consulta.= " and t2.cod_subproducto = '".$SubProducto."' ";
	$Consulta.= " and t2.año = '".intval($AnoFin)."' ";
	$Consulta.= " and t2.mes = '".intval($MesFin)."' ";
	$Consulta.= " and t2.cod_periodo = '3' ";
	$Consulta.= " and t2.estado_actual <> '16' and t2.estado_actual <> '7'";
	$Consulta.= " and t2.frx <> 'S' and t2.cod_analisis = '1' and t2.tipo = '1'";
	$Consulta.= " AND t3.cod_leyes IN(";
	reset($ArrLeyes);
	foreach($ArrLeyes as $v => $k)
	{
		//$Consulta.= "'".$k[0]."',";
		if(isset($k[0])){
			$k0=$k[0];
		}else{
			$k0="";
		}
		$Consulta.= "'".$k0."',";

	}
	$Consulta = substr($Consulta,0,strlen($Consulta)-1);
	$Consulta.= ")";
	$Consulta.= " ORDER BY t3.cod_leyes";	
	$Resp2 = mysqli_query($link, $Consulta);
	$SA = "";
	while ($Fila2 = mysqli_fetch_array($Resp2))
	{
		$SA = $Fila2["nro_solicitud"];
		if ($k[0]!="02" && $k[0]!="04" && $k[0]!="05")
		{
			$ArrLeyes[$Fila2["cod_leyes"]][1] = $Fila2["valor"];
			$ArrLeyes[$Fila2["cod_leyes"]][3] = $Fila2["conversion"];
		}
	}
	if ($SA != "")
		echo'<td align="center">'.$SA.'</td>';
	else
		echo'<td align="center">&nbsp;</td>';
	reset($ArrLeyes);
	foreach($ArrLeyes as $v => $k)
	{
		if(isset($k[0])){
			$k0=$k[0];
		}else{
			$k0="";
		}
		//if ($k[0]=="02" || $k[0]=="04" || $k[0]=="05")
		if ($k0=="02" || $k0=="04" || $k0=="05")
		{
			switch ($FinoLeyes)
			{
				case "F":
					echo "<td align='center'>".number_format($k[5],2,",",".")."</td>";	
					break;
				case "L":
					if ($TotalPSeco>0 && $k[5]>0 && $k[3]>0)
						$Fino = (($k[5]/$TotalPSeco)*$k[3]);
					else
						$Fino=0;
					echo "<td align='center'>".number_format($Fino,2,",",".")."</td>";
					break;
			}
		}
		else
		{
			switch ($FinoLeyes)
			{
				case "L":
					echo "<td align='center'>".number_format((float)$k[1],2,",",".")."</td>";	
					break;
				case "F":
					if ($TotalPSeco>0 && $k[1]>0 && $k[3]>0)
						$Fino = (($TotalPSeco*$k[1])/$k[3]);
					else
						$Fino=0;
					echo "<td align='center'>".number_format($Fino,2,",",".")."</td>";
					break;
			}
		}		
	}								
?></td>      
    
  </table>
</form>
</body>
</html>
