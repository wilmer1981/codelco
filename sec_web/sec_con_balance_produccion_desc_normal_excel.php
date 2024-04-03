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

	$FinoLeyes    = isset($_REQUEST["FinoLeyes"])?$_REQUEST["FinoLeyes"]:"";
	$Producto     = isset($_REQUEST["Producto"])?$_REQUEST["Producto"]:"";
	$SubProducto  = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";

	$AnoIni  = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:"";
	$MesIni  = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:"";
	$DiaIni  = isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:"";
	$AnoFin  = isset($_REQUEST["AnoFin"])?$_REQUEST["AnoFin"]:"";
	$MesFin  = isset($_REQUEST["MesFin"])?$_REQUEST["MesFin"]:"";
	$DiaFin  = isset($_REQUEST["DiaFin"])?$_REQUEST["DiaFin"]:"";

	if ($FinoLeyes == "F")
		$Unidad = "kg";
	else	
		$Unidad = "%";

	if ($DiaIni=="")
	{
		$DiaFin = "31";
		$MesFin = str_pad($MesFin,2, "0", STR_PAD_LEFT);
		$AnoFin = $AnoFin;
		$DiaIni = "01";
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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
      <td width="232" colspan="7">CATODOS</td>
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
	$Consulta = "SELECT distinct t1.cod_leyes, t2.abreviatura, t2.cod_unidad, t3.abreviatura as unidad ";
	$Consulta.= " from cal_web.solicitud_analisis t0 inner join cal_web.leyes_por_solicitud t1 ";
	$Consulta.= " on t1.rut_funcionario = t0.rut_funcionario and t1.nro_solicitud = t0.nro_solicitud and t1.recargo = t0.recargo ";
	$Consulta.= " inner join proyecto_modernizacion.leyes t2 ";
	$Consulta.= " on t1.cod_leyes = t2.cod_leyes inner join proyecto_modernizacion.unidades t3 on t1.cod_unidad = t3.cod_unidad";
	$Consulta.= " where t0.cod_producto = '".$Producto."' ";
	$Consulta.= " and t0.cod_subproducto = '".$SubProducto."' ";
	$Consulta.= " and t0.fecha_muestra between '".$fecha_ini."' and '".$fecha_ter."'";
	$Consulta.= " and t1.cod_leyes <> '01'";
	$Consulta.= " and t0.cod_analisis = '1'";
	$Consulta.= " and t0.frx <> 'S'";
	$Consulta.= " and t0.tipo = '1'";
	$Consulta.= " order by t1.cod_leyes";
	//echo $Consulta;
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Respuesta))
	{		
		$ArrLeyes[$Fila["cod_leyes"]][0] = $Fila["cod_leyes"];
		$ArrLeyes[$Fila["cod_leyes"]][1] = ""; //VALOR
		$ArrLeyes[$Fila["cod_leyes"]][2] = $Fila["abreviatura"];
		$ArrLeyes[$Fila["cod_leyes"]][3] = ""; //CONVERSION
		$ArrLeyes[$Fila["cod_leyes"]][4] = $Fila["unidad"];
		$ArrLeyes[$Fila["cod_leyes"]][5] = "";//Acum. Fino Mensual
		$ArrLeyes[$Fila["cod_leyes"]][6] = "";//Acum. Fino Semanal
	}	
	$Largo = 550 + (count($ArrLeyes)*40);
	$ColSpan = count($ArrLeyes) + 5;
?>  
  <table width="<?php echo $Largo ?>" height="24" border="1" cellpadding="2" cellspacing="0" class="TablaDetalle">
    <?php
    	if($FinoLeyes == "F")	
		{
			 echo'<tr align="center">
				  <td colspan="'.$ColSpan.'">F I N O S</td>
				  </tr>';
		}
		else
		{
			 echo'<tr align="center">
				  <td colspan="'.$ColSpan.'">L E Y E S</td>
				  </tr>';
		}
   ?>
    <tr class="ColorTabla01"> 
      <td align="center" width="100">Fecha </td>
      <td align="center" width="50">Grupo</td>
	  <td align="center" width="50">Cuba</td>
      <td align="center" width="50">P.Seco</td>
	  <td align="center" width="100">S.A</td>
<?php	
	reset($ArrLeyes);
	foreach($ArrLeyes as $v => $k)
	{
		if ($FinoLeyes == "F")
			echo "<td align='center' width='50'>".$k[2]."<br>kg</td>\n";	
		else
			echo "<td align='center' width='50'>".$k[2]."<br>".$k[4]."</td>\n";	
	}
?>	  
    </tr>    
<?php
	$ArrLeyesMensual = array();
	$fecha_aux = $fecha_ini;
	$Cont = 0;
	$TotalPSeco = 0;
	while(date($fecha_aux) <= date($fecha_ter)) //Recorre los dias.
	{		
		$Dia = substr($fecha_aux,8,2); //GUARDA DIA ACTUAL
		//******************************CORTE DE SEMANAS******************************************
		if(($DiaAnt=='07' && $Dia=='08') || ($DiaAnt=='14' && $Dia=='15') || ($DiaAnt=='21' && $Dia=='22') || ($DiaAnt=='31'))
		{  	
			if ($Dia == 7)
			{
				$Fecha1 = $AnoFin."-".$MesFin."-01";					
				$Fecha2 = $AnoFin."-".$MesFin."-07";
			}
			else
			{
				if ($Dia == 14)
				{					
					$Fecha1 = $AnoFin."-".$MesFin."-08";					
					$Fecha2 = $AnoFin."-".$MesFin."-14";
				}
				else
				{
					if ($Dia == 21)
					{					
						$Fecha1 = $AnoFin."-".$MesFin."-15";					
						$Fecha2 = $AnoFin."-".$MesFin."-21";
					}
					else
					{
						if (($Dia >= 22) && ($Dia <= 31))
						{				
							$Fecha1 = $AnoFin."-".$MesFin."-22";					
							$Fecha2 = $AnoFin."-".$MesFin."-31";
						}
					}							
				}								
			}
			echo'<tr class="detalle01">';
			echo'<td colspan="3">Total Semana</td>';
			echo'<td align="right">'.number_format($SumPesoSeco,0,",",".").'</td>';				
			echo'<td align="center">&nbsp;</td>';
			reset($ArrLeyes);
			foreach($ArrLeyes as $v => $k)
			{				
				switch ($FinoLeyes)
				{
					case "F":
						$Fino = $k[6];
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
				//ACUMULA LAS LEYES DIARIAS PARA EL PONDERADO MENSUAL				
				$ArrLeyesMensual[$k[0]][0] = $k[0]; //CODIGO
				$ArrLeyesMensual[$k[0]][1] = $ArrLeyesMensual[$k[0]][1] + $k[6]; //VALOR
				$ArrLeyesMensual[$k[0]][2] = $k[3]; //CONVERSION			
			}			
			//Acumuladores			
			$SumPesoSeco = "";
			$Cont = 0;
			//LIMPIA ARREGLO DE LEYES
			reset($ArrLeyes);
			foreach($ArrLeyes as $key => $values)
			{				
				$ArrLeyes[$key][6] = "";				
			}
		}
		//FIN SEMANAS
		$Consulta = "SELECT cod_grupo, cod_cuba, sum(peso_produccion) as peso_produccion, fecha_produccion ";
		$Consulta.= " from sec_web.produccion_catodo";
		$Consulta.= " where cod_producto = '".$Producto."'";
		$Consulta.= " and cod_subproducto = '".$SubProducto."'";
		$Consulta.= " and fecha_produccion between '".$fecha_aux."' and '".$fecha_aux."'";		
		$Consulta.= " group by cod_grupo, cod_cuba ";	
		$Consulta.= " order by fecha_produccion, cod_grupo, cod_cuba ";		
		$Rs = mysqli_query($link, $Consulta);		
		while($Fila = mysqli_fetch_array($Rs))
		{		
			if ($Fila["cod_cuba"] == "00")			
			{
				$PesoMuestra = $Fila["peso_produccion"];
			}
			else
			{
				$PesoProd = $Fila["peso_produccion"] + $PesoMuestra;
				$PesoMuestra=0;
				echo'<tr>';
				echo'<td align="center">'.$Fila["fecha_produccion"].'</td>';
				echo'<td align="center">'.str_pad($Fila["cod_grupo"],2,"0",STR_PAD_LEFT).'</td>';		
				echo'<td align="center">'.str_pad($Fila["cod_cuba"],2,"0",STR_PAD_LEFT).'</td>';	
				echo'<td align="right">'.number_format($PesoProd,0,",",".").'</td>';						
				$PesoSeco = $PesoProd;			
				$TotalPSeco = $TotalPSeco + $PesoSeco;			
				//RESCATA LEYES DE CALIDAD
				//LIMPIA ARREGLO DE LEYES
				reset($ArrLeyes);
				foreach($ArrLeyes as $key => $values)
				{				
					$ArrLeyes[$key][1] = "";				
				}
				//---------------------------LEYES DE CALIDAD---------------------------------
				$FechaAux1 = date("Y-m-d",mktime(0,0,0,substr($fecha_aux,5,2),(substr($fecha_aux,8,2)) - 3,substr($fecha_aux,0,4)));
				$FechaAux2 = date("Y-m-d",mktime(0,0,0,substr($fecha_aux,5,2),(substr($fecha_aux,8,2)) + 3,substr($fecha_aux,0,4)));
				$Consulta = "SELECT t2.cod_leyes, t2.valor, t1.fecha_muestra, ";
				$Consulta.= " t2.signo, t1.nro_solicitud, t3.abreviatura, t2.cod_unidad, t5.conversion ";
				$Consulta.= " from cal_web.solicitud_analisis t1 inner join ";
				$Consulta.= " cal_web.leyes_por_solicitud  t2 on t1.nro_solicitud = t2.nro_solicitud ";
				$Consulta.= " and t1.fecha_hora = t2.fecha_hora and t1.rut_funcionario = t2.rut_funcionario and t1.recargo = t2.recargo ";
				$Consulta.= " inner join proyecto_modernizacion.leyes t3 on t2.cod_leyes = t3.cod_leyes";					
				$Consulta.= " inner join proyecto_modernizacion.unidades t5 on t2.cod_unidad = t5.cod_unidad";
				$Consulta.= " where t1.fecha_muestra between '".$FechaAux1." 00:00:00' and '".$FechaAux2." 23:59:59'";										
				if (($Producto == 18) && ($SubProducto == 3)) //DESC. NORMAL (DIARIA POR GRUPO CUBA)
				{
					$Grupo = $Fila["cod_grupo"];
					$Cuba = $Fila["cod_cuba"];								
					if(substr($Grupo,0,1) == 0)
						$Grupo = substr($Grupo,1,1);						
					if(substr($Cuba,0,1) == 0 AND substr($Cuba,1,1) != 0)
						$Cuba = substr($Cuba,1,1);									
					$Consulta.= " and (t1.tipo = 1 and ";
					$Consulta.= " left(t1.id_muestra,5) like '%".$Grupo."%'";
					$Consulta.= " AND right(t1.id_muestra,2) like '%".$Cuba."%') ";	 
				}
				$Consulta.= " and cod_periodo = '1' ";			
				$Consulta.= " and t1.estado_actual <> '16' and t1.estado_actual <> '7'";
				$Consulta.= " and t1.frx <> 'S' and t1.cod_analisis = '1'";
				$Consulta.= " and t1.cod_producto = '".$Producto."' ";			
				$Consulta.= " and t1.cod_subproducto = '".$SubProducto."'";
				$Consulta.= " and t1.tipo = '1'";	
				$Consulta.= " AND t2.cod_leyes IN(";
				reset($ArrLeyes);
				foreach($ArrLeyes as $v => $k)
				{
					$Consulta.= "'".$k[0]."',";
				}
				$Consulta = substr($Consulta,0,strlen($Consulta)-1);
				$Consulta.= ")";
				$Consulta.= " ORDER BY t3.cod_leyes";	
				//echo $Consulta;
				$Resp2 = mysqli_query($link, $Consulta);
				$SA = "";			
				while ($Fila2 = mysqli_fetch_array($Resp2))
				{
					$SA = $Fila2["nro_solicitud"];
					$ArrLeyes[$Fila2["cod_leyes"]][1] = $Fila2["valor"];
					$ArrLeyes[$Fila2["cod_leyes"]][3] = $Fila2["conversion"];					
					//ACUMULA LAS LEYES DIARIAS PARA EL PONDERADO SEMANAL
					if ($PesoSeco>0 && $Fila2["valor"]>0 && $Fila2["conversion"]>0)
						$Fino = (($PesoSeco*$Fila2["valor"])/$Fila2["conversion"]);
					else	
						$Fino = 0;
					$ArrLeyes[$Fila2["cod_leyes"]][6] = $ArrLeyes[$Fila2["cod_leyes"]][6] + $Fino; //SEMANAL
				}
				if ($SA != "")
					echo'<td align="center"><a href=\'JavaScript:Historial('.$SA.')\'>'.$SA.'</a></td>';
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
				$SumPesoSeco = $SumPesoSeco + number_format($PesoSeco,0,"","");				  	
				echo'</tr>';
			}
			
		}
		$DiaAnt = substr($fecha_aux,8,2); //GUARDA DIA ANTERIOR
		$consulta = "SELECT DATE_ADD('".$fecha_aux."',INTERVAL 1 DAY) AS fecha";
		$rs10 = mysqli_query($link, $consulta);
		$row10 = mysqli_fetch_array($rs10);
		$fecha_aux = $row10["fecha"];						
	}
	//************************************PARA LA ULTIMA SEMANA******************************************
	if(($DiaAnt=='07' && $Dia=='08') || ($DiaAnt=='14' && $Dia=='15') || ($DiaAnt=='21' && $Dia=='22') || ($DiaAnt=='31'))
	{  	
		if ($Dia == 7)
		{
			$Fecha1 = $AnoFin."-".$MesFin."-01";					
			$Fecha2 = $AnoFin."-".$MesFin."-07";
		}
		else
		{
			if ($Dia == 14)
			{					
				$Fecha1 = $AnoFin."-".$MesFin."-08";					
				$Fecha2 = $AnoFin."-".$MesFin."-14";
			}
			else
			{
				if ($Dia == 21)
				{					
					$Fecha1 = $AnoFin."-".$MesFin."-15";					
					$Fecha2 = $AnoFin."-".$MesFin."-21";
				}
				else
				{
					if (($Dia >= 22) && ($Dia <= 31))
					{				
						$Fecha1 = $AnoFin."-".$MesFin."-22";					
						$Fecha2 = $AnoFin."-".$MesFin."-31";
					}
				}							
			}								
		}
		echo'<tr class="detalle01">';
		echo'<td colspan="3">Total Semana</td>';
		echo'<td align="right">'.number_format($SumPesoSeco,0,",",".").'</td>';				
		echo'<td align="center">&nbsp;</td>';
		reset($ArrLeyes);
		foreach($ArrLeyes as $v => $k)
		{
			switch ($FinoLeyes)
			{
				case "F":
					$Fino = $k[6];
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
			//ACUMULA LAS LEYES DIARIAS PARA EL PONDERADO MENSUAL			
			$ArrLeyesMensual[$k[0]][0] = $k[0]; //CODIGO
			$ArrLeyesMensual[$k[0]][1] = $ArrLeyesMensual[$k[0]][1] + $k[6]; //VALOR
			$ArrLeyesMensual[$k[0]][2] = $k[3]; //CONVERSION					
		}			
		//Acumuladores			
		$SumPesoSeco = "";
		$Cont = 0;		
	}
	//FIN SEMANAS
//TOTALES MENSUALES	
	echo'<tr class="detalle01">';
	echo'<td colspan="3">Total Mes</td>';
	echo'<td align="right">'.number_format($TotalPSeco,0,",",".").'</td>';	
	echo'<td align="center">&nbsp;</td>';
	reset($ArrLeyesMensual);
	foreach($ArrLeyesMensual as $v => $k)
	{
		switch ($FinoLeyes)
		{
			case "F":
				echo "<td align='center'>".number_format($k[1],2,",",".")."</td>";	
				break;
			case "L":
				if ($PesoSeco>0 && $k[1]>0 && $k[2]>0)
					$Ley = (($k[1]/$TotalPSeco)*$k[2]);
				else
					$Ley=0;
				echo "<td align='center'>".number_format($Ley,2,",",".")."</td>";
				break;
		}													
	}			
?>
</td>      
    
  </table>
</form>
</body>
</html>
