<?php
	$CodigoDeSistema = 3;
	$CodigoDePantalla =16; 
	include("../principal/conectar_principal.php");

	$CodBulto = isset($_REQUEST["CodBulto"])?$_REQUEST["CodBulto"]:"";
	$NumBulto = isset($_REQUEST["NumBulto"])?$_REQUEST["NumBulto"]:"";

	$AnoIni  = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:"";
	$MesIni  = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:"";
	$DiaIni  = isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:"";
	$AnoFin  = isset($_REQUEST["AnoFin"])?$_REQUEST["AnoFin"]:"";
	$MesFin  = isset($_REQUEST["MesFin"])?$_REQUEST["MesFin"]:"";
	$DiaFin  = isset($_REQUEST["DiaFin"])?$_REQUEST["DiaFin"]:"";

	//if (!isset($DiaIni))
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
	//TABLA PAQUETE_CATODO
	$Consulta = "SELECT distinct t2.cod_producto, t2.cod_subproducto, year(t1.fecha_creacion_lote) as ano";
	$Consulta.= " from sec_web.lote_catodo t1	inner join";
	$Consulta.= " sec_web.paquete_catodo t2 on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete";
	$Consulta.= " where t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and  t1.cod_bulto = '".$CodBulto."'";
	$Consulta.= " and t1.num_bulto = '".$NumBulto."'";
	$Consulta.= " order by t2.cod_producto, t2.cod_subproducto";
	$Respuesta = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		$Producto = $Fila["cod_producto"];
		$SubProducto = $Fila["cod_subproducto"];
		$AnoCreacion = $Fila["ano"];
	}	
	//SEPARA LOS SUBLOTES INVOLUCRADOS
	$Consulta = "SELECT  distinct cod_paquete,num_paquete ";
	$Consulta.=" from sec_web.lote_catodo ";
	$Consulta.=" where cod_bulto='".$CodBulto."' and num_bulto='".$NumBulto."' and substring(fecha_creacion_lote,1,4)='".$AnoCreacion."' ";
	$Consulta.=" order by fecha_creacion_lote desc,cod_paquete,num_paquete ";
	$Respuesta = mysqli_query($link, $Consulta);
	$cont=1;
	$arreglo=array();
	$i=0;
	while ($Fila=mysqli_fetch_array($Respuesta))
	{
		$arreglo[$i]=	array($Fila["cod_paquete"],$Fila["num_paquete"]);
		$i++;
	}
	reset($arreglo);
	$sw=0;
	$vector=array();
	$a=0;
	$i=0;
	while ($i < count($arreglo))
	{		
		if ($arreglo[$i][0]==$arreglo[$i+1][0])
		{
			if($arreglo[$i][1]==($arreglo[$i+1][1]-1))
			{
				if($sw==0)
				{
					$vector[$a][0]=$arreglo[$i][0]."-".$arreglo[$i][1];//inicial
					$sw=1;
				}
				else
				{
					if ($arreglo[$i+1][1]!=($arreglo[$i+2][1]-1))
					{
						$vector[$a][1]=$arreglo[$i+1][0]."-".$arreglo[$i+1][1];//final
						$sw=0;
						$a++;
						$i++;
					}
				}
			}
			else
			{
				if ($sw==0)
				{	
					$vector[$a][0]=$arreglo[$i][0]."-".$arreglo[$i][1];//inicial
					$vector[$a][1]=$arreglo[$i][0]."-".$arreglo[$i][1];//final
					$a++;
				}
				else
				{
					$vector[$a][1]=$arreglo[$i][0]."-".$arreglo[$i][1];//final
					$sw=0;
					$a++;
				}
			}
		}
		else
		{
			if ((count($arreglo)-$i)<=1)//fin del arreglo
			{
				if ($vector[$a][0]=="")
				{
					$vector[$a][0]=$arreglo[$i][0]."-".$arreglo[$i][1];//inicial
				}
				$vector[$a][1]=$arreglo[$i][0]."-".$arreglo[$i][1];//final
			}		
			else
			{
				if ($sw==1)
				{
					$vector[$a][1]=$arreglo[$i][0]."-".$arreglo[$i][1];//final
					$a++;
					$sw=0;
				}
				else
				{
					$vector[$a][0]=$arreglo[$i][0]."-".$arreglo[$i][1];//inicial
					$vector[$a][1]=$arreglo[$i][0]."-".$arreglo[$i][1];//final
					$a++;
				}
			}
		}
		$i++;
	}		
	reset($vector);
	echo "<input name ='checkbox' type='hidden' ><input name ='MesPaqueteI' type='hidden' ><input name ='NumPaqueteI' type='hidden' ><input name ='MesPaqueteF' type='hidden' ><input name ='NumPaqueteF' type='hidden' >";
	$i=0;
	$ArrLotes = array();
	foreach($vector as $Clave => $Valor)
	{
		$Inicial=explode("-",$Valor[0]);
		$Final=explode("-",$Valor[1]);
		//RESCATA PESO
		$Consulta = "SELECT ifnull(t2.cod_bulto,'') as cod_bulto, ifnull(t2.num_bulto,'0') as num_bulto, sum(t1.peso_paquetes) as peso";
		$Consulta.= " from sec_web.paquete_catodo t1 left join sec_web.lote_catodo t2";
		$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete";
		$Consulta.= " and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete ";
		$Consulta.= " where  t2.cod_bulto = '".$CodBulto."'";	
		$Consulta.= " and t2.num_bulto = '".$NumBulto."'";	
		$Consulta.= " and t1.cod_paquete = '".$Inicial[0]."'";	
		$Consulta.= " and t1.cod_producto = '".$Producto."' and t1.cod_subproducto = '".$SubProducto."'";
		$Consulta.= " group by t2.cod_bulto,  t2.num_bulto";
		$Respuesta = mysqli_query($link, $Consulta);
		//echo $Consulta."<br>";
		$Peso = 0;
		if ($Fila = mysqli_fetch_array($Respuesta))
			$Peso = $Fila["peso"];
		$ArrLotes[$i][1] = $Inicial[0]; // MesPaqueteI
		$ArrLotes[$i][2] = $Inicial[1]; // NumPaqueteI
		$ArrLotes[$i][3] = $Peso; // Peso
		$i++;
	}	
			
?>
<html>
<head>
<title>Sistema Estadistico de Catodos</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
</head>

<body background="../Principal/imagenes/fondo3.gif">
<form name="frmPrincipal" action="" method="post">
<?php
	$ArrLeyesFinal = array();	
	//-------------------------LEYES DE CALIDAD-----------------------------
	$Consulta = "SELECT distinct t3.cod_leyes, t3.abreviatura ";
	$Consulta.= " from cal_web.solicitud_analisis t1 inner join ";
	$Consulta.= " cal_web.leyes_por_solicitud  t2 on t1.nro_solicitud = t2.nro_solicitud ";
	$Consulta.= " and t1.fecha_hora = t2.fecha_hora and t1.rut_funcionario = t2.rut_funcionario and t1.recargo = t2.recargo ";
	$Consulta.= " inner join proyecto_modernizacion.leyes t3 on t2.cod_leyes = t3.cod_leyes";
	$Consulta.= " where t1.estado_actual <> '16' and t1.estado_actual <> '7'";
	$Consulta.= " and t1.frx <> 'S' and t1.cod_analisis = '1' and t2.cod_leyes<>'01'";	
	$Consulta.= " and t1.cod_producto = ".$Producto." and t1.cod_subproducto in(11,12)";
	$Consulta.= " order by t3.cod_leyes ";
	//echo $Consulta;
	$Respuesta2 = mysqli_query($link, $Consulta);	
	while ($Fila2 = mysqli_fetch_array($Respuesta2))
	{		
		$ArrLeyesFinal[$Fila2["cod_leyes"]][0] = $Fila2["cod_leyes"];
		$ArrLeyesFinal[$Fila2["cod_leyes"]][1] = $Fila2["abreviatura"];
		$ArrLeyesFinal[$Fila2["cod_leyes"]][2] = ""; 
		$ArrLeyesFinal[$Fila2["cod_leyes"]][3] = "";   		
	}
	$LargoTabla = 350 + (count($ArrLeyesFinal) * 25);
	
?>
<strong>LOTE: <?php echo strtoupper($CodBulto)."-".str_pad($NumBulto, 6, "0", STR_PAD_LEFT) ?></strong>
<br><br><table width="<?php echo $LargoTabla; ?>" border="1" cellpadding="3" cellspacing="0" class="TablaDetalle">
    <tr align="center" class="ColorTabla01"> 
      <td width="150" rowspan="2">LOTE</td>      
	  <td width="80" rowspan="2">P.HUM Kg</td>
	  <td width="80" rowspan="2">H2O (%)</td>
      <td width="80" rowspan="2" align="center">P.SECO Kg</td>
      <?php	
	reset($ArrLeyesFinal);
	foreach($ArrLeyesFinal as $k => $v)
	{	
		echo "<td width='25'>".$v[1]."<br>";
		switch ($v[0])
		{
			case "02":
				echo "%";
				break;
			case "04":
				echo "gr/t";
				break;
			case "05":
				echo "gr/t";
				break;
			default:
				echo "ppm";
				break;
		}
		echo "</td>\n";
	}
?>
    </tr>
    <tr class="ColorTabla01"> 
      <td width="38" colspan="<?php echo count($ArrLeyesFinal); ?>" align="center">LEYES</td>
    </tr>
    <?php  
	//$ArrLeyesFinal = array();
	$ArrTotal = array();  	
	$MesConsulta = $CodBulto;
	$Color = "";
	$TotalPeso = 0;				
	$TotalPeso = 0;
	reset($ArrLotes);	
	foreach($ArrLotes as $Clave => $Valor)
	{		
		$Cod_Lote = $Valor[1];
		$Num_Lote = $Valor[2];
		$PesoHumedo = $Valor[3];
		if ($Color == "")
			$Color = "WHITE";
		else
			$Color = "";
		echo "<tr bgcolor = '".$Color."'>\n";
		reset($ArrLeyesFinal);
		do {			 
			$key = key ($ArrLeyesFinal);
		 	$ArrLeyesFinal[$key][1] = "";
			$ArrLeyesFinal[$key][2] = "";
			$ArrLeyesFinal[$key][3] = "";
			$ArrLeyesFinal[$key][4] = "";
		} while (next($ArrLeyesFinal));
		//LOTE
		if ($Cod_Lote == "")
		{
			echo "<td align='center'>Sin Lote</td>\n";
		}
		else
		{
			$Consulta = "SELECT cod_bulto, num_bulto, fecha_creacion_lote ";
			$Consulta.= "from sec_web.lote_catodo ";
			$Consulta.= " where cod_bulto = '".$Cod_Lote."' and num_bulto='".$Num_Lote."'";
			$Resp2 = mysqli_query($link, $Consulta);
			if ($Fila2 = mysqli_fetch_array($Resp2))
			{
				$FechaCreacionLote = substr($Fila2["fecha_creacion_lote"],0,4);
			}
			echo "<td align='center'>".strtoupper($Cod_Lote)."-".str_pad($Num_Lote,6,0,STR_PAD_LEFT)."</a></td>\n";						
		}				
		//PESOS Y LEYES
		//$ArrLeyesFinal = array();
		BuscaLeyesProduccion($CodBulto,$NumBulto,+$ArrLeyesFinal,$Cod_Lote);
		$Humedad = 0;
		reset($ArrLeyesFinal);		
		foreach($ArrLeyesFinal as $v => $k)
		{
			if ($k[0]=="01")
				$Humedad = $k[4];
		}						
		$PesoSeco = abs($PesoHumedo - (($PesoHumedo*$Humedad)/100));
		echo "<td align='right'>".number_format($PesoHumedo,0,",",".")."</td>\n";
		echo "<td align='right'>".number_format($Humedad,2,",",".")."</td>\n";		
		echo "<td align='right'>".number_format($PesoSeco,0,",",".")."</td>\n";		
		reset($ArrLeyesFinal);			
		foreach($ArrLeyesFinal as $k => $v)
		{
			if ($v[0]!="01")
			{				
				$Valor = $v[4];		
				$ArrTotal[$v[0]][0] = $v[0];
				if ($v>0 && $PesoSeco>0 && $v[2]>0)
					$ArrTotal[$v[0]][1] = $ArrTotal[$v[0]][1] + (($Valor*$PesoSeco)/$v[2]);
				else
					$ArrTotal[$v[0]][1] = 0;
				$ArrTotal[$v[0]][2] = $v[2];			
				echo "<td align='right'>".number_format($Valor,1,",",".")."</td>";				
			}
		}
		$TotalHumedo = $TotalHumedo + $PesoHumedo;	
		$TotalPeso = $TotalPeso + $PesoSeco;			
		//------------------------------------------------------------------------------------------------			
	}		
	//TOTALES
	$Humedad = 100 - (($TotalPeso/$TotalHumedo)*100);
    echo "<tr>\n";
	echo "<td colspan='1'><strong>TOTAL</strong></td>\n";	
    echo "<td align='right'><strong>".number_format($TotalHumedo,0,",",".")."</strong></td>\n";
	echo "<td align='right'><strong>".number_format($Humedad,2,",",".")."</strong></td>\n";
	echo "<td align='right'><strong>".number_format($TotalPeso,0,",",".")."</strong></td>\n";
	foreach($ArrTotal as $k => $v)
	{
		echo "<td align='right'><strong>\n";	
		if ($v[1]>0 && $TotalPeso>0 && $v[2]>0) 		
			echo number_format(($v[1] / $TotalPeso)*$v[2],1,",",".");
		else
			echo number_format(0,2,",",".");
		echo "</strong></td>\n";
	}
	
?>
    </tr>
  </table>
</form>
</body>
</html>
<?php
function BuscaLeyesProduccion($CodBulto, $NumBulto, $Arreglo, $Mes, $link)
{
	//SELECCIONA LAS DISTINTAS SERIES CON SUS PESOS
	$Consulta = "SELECT t2.cod_paquete, SUM(t2.peso_paquetes) as peso_sublote, year(t2.fecha_creacion_paquete) as ano, t3.cod_subclase as mes ";
	$Consulta.= " from sec_web.lote_catodo t1 inner join";
	$Consulta.= " sec_web.paquete_catodo t2 on t1.cod_paquete = t2.cod_paquete and";
	$Consulta.= " t1.num_paquete = t2.num_paquete and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete";
	$Consulta.= " inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase = '3004'";
	$Consulta.= " where t1.cod_bulto = '".$CodBulto."'";
	$Consulta.= " and t1.num_bulto = '".$NumBulto."'";
	$Consulta.= " and t2.cod_paquete = '".$Mes."'";
	$Consulta.= " and t3.nombre_subclase = t2.cod_paquete ";
	$Consulta.= " GROUP by t2.cod_paquete";
	$RespAux = mysqli_query($link, $Consulta);
	$PesoProduccion = 0;
	$TotalPesoProd = 0;
	while ($FilaAux = mysqli_fetch_array($RespAux))
	{		
		$ArrLeyes = array();		
		$fecha_aux = $FilaAux["ano"]."-".str_pad($FilaAux["mes"],2,"0",STR_PAD_LEFT)."-01";
		$fecha_ter = $FilaAux["ano"]."-".str_pad($FilaAux["mes"],2,"0",STR_PAD_LEFT)."-31";
		$Cont = 0;
		$TotalPHum = 0;
		$TotalPSeco = 0;	
		$PesoProduccion = $FilaAux["peso_sublote"];
		$TotalPesoProd = $TotalPesoProd + $PesoProduccion;
		while(date($fecha_aux) <= date($fecha_ter)) //Recorre los dias.
		{
			$Consulta = "SELECT t1.fecha_produccion,sum(t1.peso_produccion) as peso_produccion, sum(t1.peso_tara) as peso_tara, count(*) as cant ";
			$Consulta.= " from sec_web.produccion_catodo t1";
			$Consulta.= " where t1.cod_producto = '57' ";
			$Consulta.= " and t1.cod_subproducto = '11' ";
			$Consulta.= " and t1.fecha_produccion ='".$fecha_aux."'";
			$Consulta.= " group by fecha_produccion";		
			$Rs = mysqli_query($link, $Consulta);
			while($Fila = mysqli_fetch_array($Rs))
			{		
				$Consulta = "SELECT t2.nro_solicitud, ifnull(t3.valor,0)as valor,t3.cod_leyes";
				$Consulta.= " from cal_web.solicitud_analisis t2 ";
				$Consulta.= " inner join cal_web.leyes_por_solicitud t3 on t2.fecha_hora=t3.fecha_hora ";
				$Consulta.= " and t2.nro_solicitud=t3.nro_solicitud and t3.cod_producto=t2.cod_producto ";
				$Consulta.= " and t3.cod_subproducto=t2.cod_subproducto ";
				$Consulta.= " where t2.cod_producto = '57' ";
				$Consulta.= " and t2.cod_subproducto = '11' ";
				$Consulta.= " and left(t2.fecha_muestra,10) ='".$fecha_aux."'";
				$Consulta.= " and t3.cod_leyes='01' ";
				$Consulta.= " and t2.estado_actual <> '16' and t2.estado_actual <> '7'";
				$Consulta.= " and t2.frx <> 'S' and t2.cod_analisis = '1' and t2.tipo = '1'";					
				$Rs2 = mysqli_query($link, $Consulta);
				if($Fila2 = mysqli_fetch_array($Rs2))
				{
					$PorcHum = $Fila2["valor"];						
					$PesoHum = (($Fila["peso_produccion"]-$Fila["peso_tara"])*$PorcHum)/100;					
					$PesoSeco = ($Fila["peso_produccion"]-$Fila["peso_tara"]) - $PesoHum;					
					$TotalPHum = $TotalPHum + ($Fila["peso_produccion"]-$Fila["peso_tara"]);
					$TotalPSeco = $TotalPSeco + $PesoSeco;
					$SumPesoHumedo = $SumPesoHumedo + ($Fila["peso_produccion"]-$Fila["peso_tara"]);
					$SumPesoSeco = $SumPesoSeco + $PesoSeco;
					$ArrLeyes[$Fila2["cod_leyes"]][0] = $Fila2["cod_leyes"];
					$ArrLeyes[$Fila2["cod_leyes"]][3] = 100;
					
				}
				else
				{
					$PorcHum = 0;	
					$PesoHum = (($Fila["peso_produccion"]-$Fila["peso_tara"])*$PorcHum)/100;
					$PesoSeco = ($Fila["peso_produccion"]-$Fila["peso_tara"]) - $PesoHum;
					$TotalPHum = $TotalPHum + ($Fila["peso_produccion"]-$Fila["peso_tara"]);
					$TotalPSeco = $TotalPSeco + $PesoSeco;
					$SumPesoHumedo = $SumPesoHumedo + ($Fila["peso_produccion"]-$Fila["peso_tara"]);
					$SumPesoSeco = $SumPesoSeco + $PesoSeco;												  
				}									
				//RESCATA LEYES DE CALIDAD
				$Consulta = " SELECT t1.fecha_produccion, t2.nro_solicitud, t3.cod_leyes, ifnull(t3.valor,0) as valor, t3.cod_unidad, t4.conversion ";
				$Consulta.= " from sec_web.produccion_catodo t1";
				$Consulta.= " left join cal_web.solicitud_analisis t2 on t1.fecha_produccion=left(t2.fecha_muestra,10) and ";
				$Consulta.= " t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
				$Consulta.= " left join cal_web.leyes_por_solicitud t3 on t2.fecha_hora=t3.fecha_hora ";
				$Consulta.= " and t2.nro_solicitud=t3.nro_solicitud and t3.cod_producto=t2.cod_producto ";
				$Consulta.= " and t3.cod_subproducto=t2.cod_subproducto inner join proyecto_modernizacion.unidades t4 ";
				$Consulta.= " on t3.cod_unidad = t4.cod_unidad ";
				$Consulta.= " where t1.cod_producto = '57' ";
				$Consulta.= " and t1.cod_subproducto = '11' ";
				$Consulta.= " and t1.fecha_produccion ='".$fecha_aux."'";
				$Consulta.= " and t2.cod_periodo = '1' ";
				$Consulta.= " and t2.estado_actual <> '16' and t2.estado_actual <> '7'";
				$Consulta.= " and t2.frx <> 'S' and t2.cod_analisis = '1' and t2.tipo = '1'";
				$Consulta.= " AND t3.cod_leyes IN(";
				reset($Arreglo);
				foreach($Arreglo as $v => $k)
				{
					$Consulta.= "'".$k[0]."',";
				}
				$Consulta = substr($Consulta,0,strlen($Consulta)-1);
				$Consulta.= ")";					
				$Consulta.= " ORDER BY t3.cod_leyes";	
				$Resp2 = mysqli_query($link, $Consulta);
				while ($Fila2 = mysqli_fetch_array($Resp2))
				{
					if ($Fila2["cod_leyes"]=="02" || $Fila2["cod_leyes"]=="04" || $Fila2["cod_leyes"]=="05")
					{
						$ArrLeyes[$Fila2["cod_leyes"]][0] = $Fila2["cod_leyes"];
						$ArrLeyes[$Fila2["cod_leyes"]][1] = $ArrLeyes[$Fila2["cod_leyes"]][1] + (($PesoSeco*$Fila2["valor"])/$Fila2["conversion"]);
						$ArrLeyes[$Fila2["cod_leyes"]][3] = $Fila2["conversion"];
					}
				}														
				$Cont++;  	
			}
			$fecha_aux = date("Y-m-d", mktime(0,0,0,substr($fecha_aux,5,2),substr($fecha_aux,8,2) + 1,substr($fecha_aux,0,4)));		
		}		
		//LEYES MENSUALES
		$Consulta = " SELECT t2.nro_solicitud, t3.cod_leyes, ifnull(t3.valor,0) as valor, t4.conversion";
		$Consulta.= " from cal_web.solicitud_analisis t2 ";
		$Consulta.= " left join cal_web.leyes_por_solicitud t3 on t2.fecha_hora=t3.fecha_hora ";
		$Consulta.= " and t2.nro_solicitud=t3.nro_solicitud and t3.cod_producto=t2.cod_producto ";
		$Consulta.= " and t3.cod_subproducto=t2.cod_subproducto inner join proyecto_modernizacion.unidades t4 ";
		$Consulta.= " on t3.cod_unidad = t4.cod_unidad ";
		$Consulta.= " where t2.cod_producto = '57' ";
		$Consulta.= " and t2.cod_subproducto = '11' ";
		$Consulta.= " and t2.año = '".intval($FilaAux["ano"])."' ";
		$Consulta.= " and t2.mes = '".intval($FilaAux["mes"])."' ";
		$Consulta.= " and t2.cod_periodo = '3' ";
		$Consulta.= " and t2.estado_actual <> '16' and t2.estado_actual <> '7'";
		$Consulta.= " and t2.frx <> 'S' and t2.cod_analisis = '1' and t2.tipo = '1'";
		$Consulta.= " AND t3.cod_leyes IN(";
		reset($Arreglo);
		foreach($Arreglo as $v => $k)
		{
			$Consulta.= "'".$k[0]."',";
		}
		$Consulta = substr($Consulta,0,strlen($Consulta)-1);
		$Consulta.= ")";	
		$Consulta.= " ORDER BY t3.cod_leyes";	
		$Resp2 = mysqli_query($link, $Consulta);		
		while ($Fila2 = mysqli_fetch_array($Resp2))
		{							
			if ($Fila2["cod_leyes"]!="01" && $Fila2["cod_leyes"]!="02" && $Fila2["cod_leyes"]!="04" && $Fila2["cod_leyes"]!="05")	
			{		
				$ArrLeyes[$Fila2["cod_leyes"]][0] = $Fila2["cod_leyes"];	
				$ArrLeyes[$Fila2["cod_leyes"]][1] = $ArrLeyes[$Fila2["cod_leyes"]][1] + (($TotalPSeco*$Fila2["valor"])/$Fila2["conversion"]);
				$ArrLeyes[$Fila2["cod_leyes"]][3] = $Fila2["conversion"];			
			}
		}			
		//HUMEDAD	
		do {							
			$key = key ($ArrLeyes);
			if ($ArrLeyes[$key][0]=="01")
			{
				$ArrLeyes[$key][1] = $TotalPSeco;				
			}		
		} while (next($ArrLeyes));
		//	
		reset($ArrLeyes);
		foreach($ArrLeyes as $v => $k)
		{			
			if ($k[0]=="01")
			{
				if ($k[1]>0 && $TotalPHum>0 && $k[3]>0)
				{
					$Ley = ($k[1]/$TotalPHum)*$k[3];
					$Fino = ($PesoProduccion*$Ley)/$k[3];				
				}
				else
				{
					$Fino = 0;
				}
			}
			else
			{			
				if ($k[1]>0 && $TotalPSeco>0 && $k[3]>0)
				{				
					$Ley = ($k[1]/$TotalPSeco)*$k[3];
					$Fino = ($PesoProduccion*$Ley)/$k[3];								
				}
				else
				{
					$Fino = 0;
				}
			}
			$Arreglo[$k[0]][0] = $k[0];	//COD_LEY
			$Arreglo[$k[0]][1] = $Arreglo[$k[0]][1] + $Fino;	//VALOR	
			$Arreglo[$k[0]][2] = $k[3]; //CONVERSION
		}
	}	
	reset($Arreglo);
	do {					
		$key = key ($Arreglo);
		if ($Arreglo[$key][1]>0 && $Arreglo[$key][2]>0 && $TotalPesoProd>0)
		{			
			if ($Arreglo[$key][0] == "01")
				$Arreglo[$key][4] = 100 - (($Arreglo[$key][1]/$TotalPesoProd)*$Arreglo[$key][2]);				
			else
			    $Arreglo[$key][4] =($Arreglo[$key][1]/$TotalPesoProd)*$Arreglo[$key][2];
		}
		else
		{
			$Arreglo[$key][4] = 0;		
		}
	} while (next($Arreglo));	
}
?>