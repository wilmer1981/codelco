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
	include("sec_con_balance_crea_cetif_virtual.php");
	$AnoIni  = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:"";
	$MesIni  = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:"";
	$DiaIni  = isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:"01";
	$AnoFin  = isset($_REQUEST["AnoFin"])?$_REQUEST["AnoFin"]:"";
	$MesFin  = isset($_REQUEST["MesFin"])?$_REQUEST["MesFin"]:"";
	$DiaFin  = isset($_REQUEST["DiaFin"])?$_REQUEST["DiaFin"]:"31";

	$Producto     = isset($_REQUEST["Producto"])?$_REQUEST["Producto"]:"";
	$SubProducto  = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";
	$FinoLeyes    = isset($_REQUEST["FinoLeyes"])?$_REQUEST["FinoLeyes"]:"";
	if ($DiaIni=="")
	{
		//$DiaFin = "31";
		$MesFin = str_pad($MesFin,2, "0", STR_PAD_LEFT);
		$AnoFin = $AnoFin;
		//$DiaIni = "01";
		$MesIni = $MesFin;
		$AnoIni = $AnoFin;		
	}
	$FechaInicio = $AnoIni."-".$MesIni."-".$DiaIni;	
	$FechaTermino = $AnoFin."-".$MesFin."-".$DiaFin;
	$Ano = $AnoFin;
?>
<html>
<head>
<title>Sistema Estadistico de Catodos</title>
</head>

<body>
<form name="frmPrincipal" action="" method="post">
  <table width="523" border="1" cellpadding="3" cellspacing="0" class="TablaInterior">
    <tr align="center">
      <td height="30" colspan="10"><strong>TIPO DE MOVIMIENTO PESAJE DE PAQUETES</strong></td>
    </tr>
    <tr> 
      <td width="120" colspan="3"><strong>PRODUCTO</strong></td>
      <td width="387" colspan="7"> 
CATODOS      </td>
    </tr>
    <tr> 
      <td colspan="3"><strong>SUBPRODUCTO</strong></td>
      <td colspan="7">CATODOS DESC. NORMAL (GRADO A, B-115, RECHAZO) </td>
    </tr>
    <tr> 
      <td colspan="3"><strong>PERIODO</strong></td>
      <td colspan="7"> 
        <?php 
		echo str_pad($DiaIni,2, "0", STR_PAD_LEFT)."/".str_pad($MesIni, 2, "0", STR_PAD_LEFT)."/".$AnoIni." AL ".str_pad($DiaFin, 2, "0", STR_PAD_LEFT)."/".str_pad($MesFin, 2, "0", STR_PAD_LEFT)."/".$AnoFin;
	?>
      </td>
    </tr>
    <tr> 
      <td colspan="10"><strong>
	  <?php
	switch ($FinoLeyes)
	{
		case "L":
			echo "LEYES";
			break;
		case "F":
			echo "FINOS";
			break;
	}
	?></strong>
	  </td>	  
    </tr>
  </table>
<br>
<?php
	$ArrLeyes = array();
	$FechaAux = $AnoIni."-".str_pad($MesIni,2, "0", STR_PAD_LEFT)."-".str_pad($DiaIni,2, "0", STR_PAD_LEFT);
	$FechaInicio = $FechaAux;
	$FechaTermino = $AnoFin."-".str_pad($MesFin,2, "0", STR_PAD_LEFT)."-".str_pad($DiaFin,2, "0", STR_PAD_LEFT);
	//-------------------------LEYES DE CALIDAD-----------------------------
	$Consulta = "SELECT distinct t3.cod_leyes, t3.abreviatura ";
	$Consulta.= " from cal_web.solicitud_analisis t1 inner join ";
	$Consulta.= " cal_web.leyes_por_solicitud  t2 on t1.nro_solicitud = t2.nro_solicitud ";
	$Consulta.= " and t1.fecha_hora = t2.fecha_hora and t1.rut_funcionario = t2.rut_funcionario and t1.recargo = t2.recargo ";
	$Consulta.= " inner join proyecto_modernizacion.leyes t3 on t2.cod_leyes = t3.cod_leyes";
	$Consulta.= " where t1.estado_actual <> '16' and t1.estado_actual <> '7'";
	$Consulta.= " and t1.frx <> 'S' and t1.cod_analisis = '1'";	
	$Consulta.= " and t1.cod_producto = '18'";
	//$Consulta.= " and t1.cod_subproducto in(42,43,44)";
	$Consulta.= " order by t3.cod_leyes ";
	//echo $Consulta;
	$Respuesta2 = mysqli_query($link, $Consulta);
	$ArrLeyes["02"][0] = "02";
	$ArrLeyes["02"][1] = "Cu";
	if (($Producto == "18") || ($Producto == "48"))
		$ArrLeyes["02"][2] = "99.99";   
	else
		$ArrLeyes["02"][2] = ""; 
	while ($Fila2 = mysqli_fetch_array($Respuesta2))
	{
		$Consulta = "SELECT * from proyecto_modernizacion.sub_clase where cod_clase = '3009' ";
		$Consulta.= " and nombre_subclase = '".$Fila2["cod_leyes"]."'";
		$Respuesta3 = mysqli_query($link, $Consulta);				
		if ($Fila3 = mysqli_fetch_array($Respuesta3))
		{	
			$ArrLeyes[$Fila2["cod_leyes"]][0] = $Fila2["cod_leyes"];
			$ArrLeyes[$Fila2["cod_leyes"]][1] = $Fila2["abreviatura"];
			$ArrLeyes[$Fila2["cod_leyes"]][2] = ""; 
			$ArrLeyes[$Fila2["cod_leyes"]][3] = "";   
		}	
	}
	$LargoTabla = 500 + (count($ArrLeyes) * 25);
?>
  <table width="<?php echo $LargoTabla; ?>" border="1" cellpadding="3" cellspacing="0" class="TablaDetalle">
    <tr align="center" class="ColorTabla01"> 
      <td width="150" rowspan="2">LOTE</td>
      <td width="170" rowspan="2">SUBPRODUCTO</td>
      <td width="60" rowspan="2">N.ENVIO</td>
      <td width="40" rowspan="2">N.CERT</td>
      <td width="80" rowspan="2" align="center">PESO Kg</td>
      <?php	
	reset($ArrLeyes);
	foreach($ArrLeyes as $k => $v)
	{
		echo "<td width='25'>".$v[1]."<br>";
		if ($FinoLeyes == "F")
		{			
			switch ($v[0])
			{
				case "02":
					echo "kg";
					break;
				default:
					echo "grs";
					break;
			}
		}
		else
		{
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
		}
		echo "</td>\n";
	}
?>
    </tr>
    <tr class="ColorTabla01"> 
      <td width="38" colspan="<?php echo count($ArrLeyes); ?>" align="center"> 
        <?php
	switch ($FinoLeyes)
	{
		case "L":
			echo "LEYES";
			break;
		case "F":
			echo "FINOS";
			break;
	}
	?>
      </td>
    </tr>
    <?php  
	$ArrTotal = array();
	$ArrSubTotal = array();
  	$Consulta = "SELECT * from proyecto_modernizacion.sub_clase ";
	$Consulta.= " where cod_clase = '3004' and cod_subclase = '".intval(substr($FechaAux,5,2))."'"	;
	$Respuesta = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		$MesConsulta = $Fila["nombre_subclase"];
	}
	$Color = "";
	$TotalPeso = 0;	
	$Consulta = "SELECT t1.cod_producto, t1.cod_subproducto, ifnull(t2.cod_bulto,'') as cod_bulto, ifnull(t2.num_bulto,'0') as num_bulto, sum(t1.peso_paquetes) as peso";
	$Consulta.= " from sec_web.paquete_catodo t1 left join sec_web.lote_catodo t2";
	$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete";
	$Consulta.= " and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete ";
	$Consulta.= " where year(t1.fecha_creacion_paquete) = year('".$FechaAux."')";
	$Consulta.= " and t1.cod_paquete = '".$MesConsulta."'";	
	$Consulta.= " and t1.cod_producto = '18' and t1.cod_subproducto in(42,43,44) ";
	$Consulta.= " group by t1.cod_producto, t1.cod_subproducto, t2.cod_bulto,  t2.num_bulto";
	$Respuesta = mysqli_query($link, $Consulta);
	$TotalPeso = 0;
	$Cont = 1;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		$CodProducto = $Fila["cod_producto"];
		$CodSubProducto = $Fila["cod_subproducto"];
		$SubProductoActual = $CodSubProducto;
		if ($SubProductoAnt != $SubProductoActual && $Cont!=1)
		{
			//ESCRIBE SUBTOTALES
			echo "<tr bgcolor='#FFFFFF'>\n"; 
			echo "<td colspan='4'>TOTAL</td>\n"; 
			echo "<td align='right'>".number_format($SubTotalPeso,0,",",".")."</td>\n"; 			
			while (list($k,$v) = each($ArrSubTotal))
			{
				echo "<td align='right'>\n";	 
				switch ($FinoLeyes)
				{
					case "L":
						switch ($v[0])
						{
							case "02":
								echo number_format(($v[1] / $SubTotalPeso)*100,2,",",".");
								break;
							case "04":
								echo number_format(($v[1] / $SubTotalPeso)*1000,1,",",".");
								break;
							case "05":
								echo number_format(($v[1] / $SubTotalPeso)*1000,1,",",".");
								break;
							default:
								echo number_format(($v[1] / $SubTotalPeso)*1000000,1,",",".");
								break;
						}
						break;
					case "F":
						echo number_format($v[1],0,",",".");
						break;
				}
				echo "</td>\n";
			}
			echo "</tr>\n";
			//LIMPIA ARREGLO DE SUBTOTALES
			$ArrSubTotal = array();
			$SubTotalPeso = 0;	
			//FIN SUBTOTALES
		}
		
		if ($Color == "")
			$Color = "";
		else
			$Color = "";
		echo "<tr bgcolor = '".$Color."'>\n";		
		if ($Fila["cod_bulto"] == "")
		{
			echo "<td align='center'>Sin Lote</td>\n";
		}
		else
		{
			$Consulta = "SELECT cod_bulto, num_bulto, fecha_creacion_lote ";
			$Consulta.= "from sec_web.lote_catodo ";
			$Consulta.= " where cod_bulto = '".$Fila["cod_bulto"]."' and num_bulto='".$Fila["num_bulto"]."'";
			$Consulta.=" and year(fecha_creacion_lote) = '".$Ano."'";
			$Resp2 = mysqli_query($link, $Consulta);
			if ($Fila2 = mysqli_fetch_array($Resp2))
			{
				$FechaCreacionLote = substr($Fila2["fecha_creacion_lote"],0,4);
			}
			echo "<td align='center'><a href=\"JavaScript:Detalle('".$Producto."','".$Fila["cod_subproducto"]."','".$FechaCreacionLote."','".$Fila["cod_bulto"]."','".$Fila["num_bulto"]."');\">";				
			echo strtoupper($Fila["cod_bulto"])."-".str_pad($Fila["num_bulto"],6,0,STR_PAD_LEFT)."</a></td>\n";						
		}
		$Consulta = "SELECT num_envio from sec_web.embarque_ventana where cod_bulto = '".$Fila["cod_bulto"]."' and num_bulto = '".$Fila["num_bulto"]."'";
		$Resp2 = mysqli_query($link, $Consulta);
		$Consulta = "SELECT * from proyecto_modernizacion.subproducto where cod_producto = '".$Fila["cod_producto"]."' and cod_subproducto='".$Fila["cod_subproducto"]."'";
		$Resp2 = mysqli_query($link, $Consulta);
		if ($Fila2 = mysqli_fetch_array($Resp2))		
			echo "<td align='center'>".strtoupper($Fila2["abreviatura"])."</td>\n";
		else	
			echo "<td align='center'>&nbsp;</td>\n";
		if ($Fila2 = mysqli_fetch_array($Resp2))
			echo "<td align='center'>".str_pad($Fila2["num_envio"],5, "0", STR_PAD_LEFT)."</td>\n";
		else
			echo "<td align='center'>&nbsp;</td>\n";
		$NumCertificado = "";
		//LIMPIA ARREGLO DE LEYES
		reset($ArrLeyes);
		foreach($ArrLeyes as $key => $values)
		{				
			$ArrLeyes[$key][2] = "";		
		}
		//-----------------------BUSCA LEYES EN CERTIFICADO---------------------
		$Consulta = "SELECT t2.cod_leyes, t2.valor, t2.fecha, ";
		$Consulta.= " t2.signo, t3.abreviatura, t2.num_certificado, t2.version ";
		$Consulta.= " from sec_web.solicitud_certificado t1 inner join sec_web.certificacion_catodos t2 ";
		$Consulta.= " on t1.corr_enm = t2.corr_enm inner join proyecto_modernizacion.leyes t3";
		$Consulta.= " on t2.cod_leyes = t3.cod_leyes";
		$Consulta.= " where t1.cod_bulto = '".$Fila["cod_bulto"]."' and t1.num_bulto = '".$Fila["num_bulto"]."'";
		$Consulta.= " and t2.version = (SELECT max(t2.version) from sec_web.solicitud_certificado t1 ";
		$Consulta.= " inner join sec_web.certificacion_catodos t2 ";
		$Consulta.= " on t1.corr_enm = t2.corr_enm ";
		$Consulta.= " where t1.cod_bulto = '".$Fila["cod_bulto"]."' and t1.num_bulto = '".$Fila["num_bulto"]."')";
		$Consulta.= " order by t2.cod_leyes";
		$Respuesta2 = mysqli_query($link, $Consulta);
		$Encontro = false;
		while ($Fila2 = mysqli_fetch_array($Respuesta2))
		{
			$Encontro = true;
			$ArrLeyes[$Fila2["cod_leyes"]][2] = $Fila2["valor"];
			$NumCertificado = $Fila2["num_certificado"];					
		}
		//----------------------------------------------------------------------
		//---------------------BUSCA LEYES EN CALIDAD---------------------------
		if ($Encontro == false)
		{
			//CREA CERTIFICADO VIRTUAL			
			CertifVirtual($Fila["cod_bulto"],$Fila["num_bulto"],$Ano);			
			//CONSULTA LA TABLA TEMPORAL
			$Consulta = "SELECT t1.cod_leyes, t1.valor, t1.signo ";
			$Consulta.= " from sec_web.tmp_certificacion_catodos t1";
			$Consulta.= " where t1.cod_lote = '".$Fila["cod_bulto"]."' ";
			$Consulta.= " and t1.num_lote = '".$Fila["num_bulto"]."'";
			$Consulta.= " order by t1.cod_leyes";
			//echo "<br><br>".$Consulta;
			$Respuesta2 = mysqli_query($link, $Consulta);
			$Encontro = false;
			while ($Fila2 = mysqli_fetch_array($Respuesta2))
			{
				$Encontro = true;
				$ArrLeyes[$Fila2["cod_leyes"]][2] = $Fila2["valor"];									
			}	
			if ($Encontro)		
				$NumCertificado = "Virtual";						
			else
				$NumCertificado = "No Creado";
			$Eliminar = "delete from `sec_web`.`tmp_certificacion_catodos`";
			mysqli_query($link, $Eliminar);		
		}
		//--------------------------------------------------------------
		if (($NumCertificado == "Virtual") || ($NumCertificado == "No Creado"))
		{
			echo "<td align='center' bgcolor='yellow'><a href=\"JavaScript:Informacion('".$Fila["cod_bulto"]."','".$Fila["num_bulto"]."','".$Ano."');\">";				
			echo $NumCertificado."</a></td>\n";						
		}
		else
		{
			echo "<td align='center'><a href=\"JavaScript:Informacion('".$Fila["cod_bulto"]."','".$Fila["num_bulto"]."','".$Ano."');\">";
			echo str_pad($NumCertificado,5, "0", STR_PAD_LEFT)."</a></td>\n";
		}
		echo "<td align='right'>".number_format($Fila["peso"],0,",",".")."</td>\n";
		if ((($Producto == "18") && (($Fila["cod_subproducto"] != "4") && ($Fila["cod_subproducto"] != "5"))) || ($Fila["cod_subproducto"] == "48"))
		{										
			$ArrLeyes["02"][2] = 99.99;				
		}									
		reset($ArrLeyes);			
		foreach($ArrLeyes as $k => $v)
		{
			if ($FinoLeyes == "L")
			{
				$Valor = $v[2];
				switch ($v[0])
				{
					case "02":
						$ValorAux = ($v[2] * $Fila["peso"]) / 100;
						break;
					case "04":
						$ValorAux = ($v[2] * $Fila["peso"]) / 1000;
						break;
					case "05":
						$ValorAux = ($v[2] * $Fila["peso"]) / 1000;
						break;
					default:
						$ValorAux = ($v[2] * $Fila["peso"]) / 1000000;
						break;
				}
				//SUBTOTALES
				$ArrSubTotal[$v[0]][0] = $v[0];				
				$ArrSubTotal[$v[0]][1] = $ArrSubTotal[$v[0]][1] + $ValorAux;
				//TOTALES
				$ArrTotal[$v[0]][0] = $v[0];				
				$ArrTotal[$v[0]][1] = $ArrTotal[$v[0]][1] + $ValorAux;
			}
			else
			{
				switch ($v[0])
				{
					case "02":
						$Valor = ($v[2] * $Fila["peso"]) / 100;
						break;
					case "04":
						$Valor = ($v[2] * $Fila["peso"]) / 1000;
						break;
					case "05":
						$Valor = ($v[2] * $Fila["peso"]) / 1000;
						break;
					default:
						$Valor = ($v[2] * $Fila["peso"]) / 1000000;
						break;
				}
				//SUBTOTALES
				$ArrSubTotal[$v[0]][0] = $v[0];
				$ArrSubTotal[$v[0]][1] = $ArrSubTotal[$v[0]][1] + $Valor;
				//TOTALES
				$ArrTotal[$v[0]][0] = $v[0];
				$ArrTotal[$v[0]][1] = $ArrTotal[$v[0]][1] + $Valor;
				
			}					
			if ($v[0] == "02") 
				echo "<td align='right'>".number_format($Valor,2,",",".")."</td>";
			else
				echo "<td align='right'>".number_format($Valor,1,",",".")."</td>";
		}
		$TotalPeso = $TotalPeso + $Fila["peso"];	
		$SubTotalPeso = $SubTotalPeso + $Fila["peso"];	
		$SubProductoAnt = $CodSubProducto;	
		$Cont++;
		//------------------------------------------------------------------------------------------------			
	}	
	if ($SubProductoAnt == $SubProductoActual)
	{
		//ESCRIBE SUBTOTALES
		echo "<tr bgcolor='#FFFFFF'>\n"; 
		echo "<td colspan='4'>TOTAL</td>\n"; 
		echo "<td align='right'>".number_format($SubTotalPeso,0,",",".")."</td>\n"; 			
		while (list($k,$v) = each($ArrSubTotal))
		{
			echo "<td align='right'>\n";	 
			switch ($FinoLeyes)
			{
				case "L":
					switch ($v[0])
					{
						case "02":
							echo number_format(($v[1] / $SubTotalPeso)*100,2,",",".");
							break;
						case "04":
							echo number_format(($v[1] / $SubTotalPeso)*1000,1,",",".");
							break;
						case "05":
							echo number_format(($v[1] / $SubTotalPeso)*1000,1,",",".");
							break;
						default:
							echo number_format(($v[1] / $SubTotalPeso)*1000000,1,",",".");
							break;
					}
					break;
				case "F":
					echo number_format($v[1],0,",",".");
					break;
			}
			echo "</td>\n";
		}
		echo "</tr>\n";
		//LIMPIA ARREGLO DE SUBTOTALES
		$ArrSubTotal = array();
		$SubTotalPeso = 0;	
		//FIN SUBTOTALES
	}	
?>
    <tr> 
      <td colspan="4">TOTAL</td>
      <td align="right"><?php echo number_format($TotalPeso,0,",","."); ?></td>
      <?php
	foreach($ArrTotal as $k => $v)
	{
		echo "<td align='right'>\n";	 
		switch ($FinoLeyes)
		{
			case "L":
				switch ($v[0])
				{
					case "02":
		      			echo number_format(($v[1] / $TotalPeso)*100,2,",",".");
						break;
					case "04":
		      			echo number_format(($v[1] / $TotalPeso)*1000,1,",",".");
						break;
					case "05":
		      			echo number_format(($v[1] / $TotalPeso)*1000,1,",",".");
						break;
					default:
						echo number_format(($v[1] / $TotalPeso)*1000000,1,",",".");
						break;
				}
				break;
			case "F":
				echo number_format($v[1],0,",",".");
				break;
		}
		echo "</td>\n";
	}
	
?>
    </tr>
  </table>
</form>
</body>
</html>
