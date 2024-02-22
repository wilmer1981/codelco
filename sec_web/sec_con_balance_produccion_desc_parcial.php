<?php
	include("../principal/conectar_sec_web.php");
	if ($FinoLeyes == "F")
		$Unidad = "kg";
	else	$Unidad = "%";
	if (!isset($DiaIni))
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
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<body background='../principal/imagenes/fondo3.gif'>

<script language="JavaScript">
function Proceso()
{
	var f = document.formulario;
	f.BtnImprimir.style.visibility = 'hidden';
	f.BtnSalir.style.visibility = 'hidden';
	window.print();
	
}	
function Historial(SA)
{
	window.open("../cal_web/cal_con_registro_leyes.php?SA="+ SA,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}

function Salir()
{
	var f = document.formulario;
	f.action = "sec_con_balance.php";
	f.submit();
}
</script>	

<form name="formulario" method="post" action="">
  <?php 
  
  ?>
  <table width="622" border="1" cellspacing="0" cellpadding="2" class="TablaInterior">
    <tr align="center">
      <td height="30" colspan="2"><strong>TIPO DE MOVIMIENTO PESAJE DE PRODUCCION</strong></td>
    </tr>
    <tr> 
      <td width="127"><strong>PRODUCTO</strong></td>
      <td width="232">CATODOS</td>
    </tr>
    <tr>
      <td><strong>SUBPRODUCTO</strong></td>
      <td><?php echo $subproducto; ?></td>
    </tr>
    <tr> 
      <td><strong>PERIODO</strong></td>
      <td>
        <?php 
	  	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	  	echo $Meses[$MesFin - 1]." del ".$AnoFin; 
	?>
      </td>
    </tr>
    <tr> 
      <td colspan="2" align="center"> <br> <input type="button" name="BtnImprimir" value="Imprimir" style="width:70px" onClick="Proceso();"> 
        <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px;" onClick="Salir();"> 
        <br> </td>
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
	$Largo = 450 + (count($ArrLeyes)*40);
	$ColSpan = count($ArrLeyes) + 3;
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
	$fecha_aux = $fecha_ini;
	$Cont = 0;
	$TotalPSeco = 0;
	while(date($fecha_aux) <= date($fecha_ter)) //Recorre los dias.
	{		
		$dia = substr($fecha_aux,8,2);
		$Consulta = "SELECT cod_grupo, sum(peso_produccion) as peso_produccion, fecha_produccion ";
		$Consulta.= " from sec_web.produccion_catodo";
		$Consulta.= " where cod_producto = '".$Producto."'";
		$Consulta.= " and cod_subproducto = '".$SubProducto."'";
		$Consulta.= " and fecha_produccion between '".$fecha_aux."' and '".$fecha_aux."'";					
		$Consulta.= " group by cod_grupo";				
		$Rs = mysqli_query($link, $Consulta);		
		while($Fila = mysqli_fetch_array($Rs))
		{					
			echo'<tr>';
			echo'<td align="center">'.$Fila["fecha_produccion"].'</td>';
			echo'<td align="center">'.number_format($Fila["peso_produccion"],0,",",".").'</td>';						
			$PesoSeco = $Fila["peso_produccion"];			
			$TotalPSeco = $TotalPSeco + $PesoSeco;						
			echo'<td align="center">&nbsp;</td>';
			reset($ArrLeyes);
			foreach($ArrLeyes as $v => $k)
			{				
				$Fino=0;
				echo "<td align='center'>".number_format($Fino,2,",",".")."</td>";											
			}			
			//Vars. Acumuladores
			$Cont++;
			$SumPesoSeco = $SumPesoSeco + number_format($PesoSeco,0,"","");				  	
			echo'</tr>';
		}
		//******************************CORTE DE QUINCENA******************************************
		if($dia == '15' || $dia == '31')
		{  	
			if ($dia == 15)
			{
				$Fecha1 = $AnoFin."-".$MesFin."-01";					
				$Fecha2 = $AnoFin."-".$MesFin."-15";
			}
			else
			{
				if ($dia == 31)
				{					
					$Fecha1 = $AnoFin."-".$MesFin."-16";					
					$Fecha2 = $AnoFin."-".$MesFin."-31";
				}									
			}
			echo'<tr class="detalle01">';
			echo'<td colspan="1">Total Quincena</td>';
			echo'<td align="center">'.number_format($SumPesoSeco,0,",",".").'</td>';	
			//LIMPIA ARREGLO DE LEYES
			reset($ArrLeyes);
			foreach($ArrLeyes as $key => $values)
			{				
				$ArrLeyes[$key][1] = "";				
			}	
			$Consulta = "SELECT t2.cod_leyes, t2.valor, t1.fecha_muestra, ";
			$Consulta.= " t2.signo, t1.nro_solicitud, t3.abreviatura, t2.cod_unidad, t5.conversion ";
			$Consulta.= " from cal_web.solicitud_analisis t1 inner join ";
			$Consulta.= " cal_web.leyes_por_solicitud  t2 on t1.nro_solicitud = t2.nro_solicitud ";
			$Consulta.= " and t1.fecha_hora = t2.fecha_hora and t1.rut_funcionario = t2.rut_funcionario and t1.recargo = t2.recargo ";
			$Consulta.= " inner join proyecto_modernizacion.leyes t3 on t2.cod_leyes = t3.cod_leyes";					
			$Consulta.= " inner join proyecto_modernizacion.unidades t5 on t2.cod_unidad = t5.cod_unidad";
			$Consulta.= " where t1.fecha_muestra between '".$Fecha1." 00:00:00' and '".$Fecha2." 23:59:59'";				
			$Consulta.= " and cod_periodo = '5' ";				
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
				//ACUMULA LAS LEYES QUINCENALES PARA EL PONDERADO FINAL
				if ($SumPesoSeco>0 && $Fila2["valor"]>0 && $Fila2["conversion"]>0)
					$Fino = (($SumPesoSeco*$Fila2["valor"])/$Fila2["conversion"]);
				else	
					$Fino = 0;				
				$ArrLeyes[$Fila2["cod_leyes"]][5] = $ArrLeyes[$Fila2["cod_leyes"]][5] + $Fino;					
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
						$Fino = $k[1];
						echo "<td align='center'>".number_format($k[1],2,",",".")."</td>";	
						break;
					case "F":
						if ($SumPesoSeco>0 && $k[1]>0 && $k[3]>0)
							$Fino = (($SumPesoSeco*$k[1])/$k[3]);
						else
							$Fino=0;
						echo "<td align='center'>".number_format($Fino,2,",",".")."</td>";
						break;
				}									
			}			
			//Acumuladores			
			$SumPesoSeco = "";
			$Cont = 0;
			//LIMPIA ARREGLO DE LEYES
			reset($ArrLeyes);
			foreach($ArrLeyes as $key => $values)
			{				
				$ArrLeyes[$key][1] = "";				
			}
		}
		//FIN QUINCENA
		$consulta = "SELECT DATE_ADD('".$fecha_aux."',INTERVAL 1 DAY) AS fecha";
		$rs10 = mysqli_query($link, $consulta);
		$row10 = mysqli_fetch_array($rs10);
		$fecha_aux = $row10["fecha"];						
	}
//TOTALES MENSUALES	
	echo'<tr class="detalle01">';
	echo'<td colspan="1">Total Mes</td>';
	echo'<td align="center">'.number_format($TotalPSeco,0,",",".").'</td>';	
	echo'<td align="center">&nbsp;</td>';
	reset($ArrLeyes);
	foreach($ArrLeyes as $v => $k)
	{
		switch ($FinoLeyes)
		{
			case "F":
				echo "<td align='center'>".number_format($k[5],2,",",".")."</td>";	
				break;
			case "L":
				if ($PesoSeco>0 && $k[5]>0 && $k[3]>0)
					$Ley = (($k[5]/$TotalPSeco)*$k[3]);
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
