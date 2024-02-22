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
	$CodigoDeSistema = 3;
	$CodigoDePantalla =16; 
	include("../principal/conectar_principal.php")
?>
<html>
<head>
<title>Sistema Estadistico de Catodos</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body>
<form name="frmPrincipal" action="" method="post">
  <table width="523" border="1" cellpadding="3" cellspacing="0" class="TablaInterior">
    <tr> 
      <td colspan="2"><strong>EMBARQUE</strong></td>
    </tr>
    <tr> 
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr> 
      <td width="120"><strong>PRODUCTO</strong></td>
      <td width="387"> 
        <?php
		$Consulta = "select * from proyecto_modernizacion.productos ";
		$Consulta.= " where cod_producto = '".$Producto."'";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Respuesta))
		{
			echo strtoupper($Fila["descripcion"]);
		}
?>
      </td>
    </tr>
    <tr> 
      <td><strong>SUBPRODUCTO</strong></td>
      <td> 
        <?php
		if ($Producto == 64 && ($SubProducto == 5 || $SubProducto == 1))
		{
			echo "SULFATO DE COBRE PTE Y PLAMEN";
		}
		else
		{
			$Consulta = "select * from proyecto_modernizacion.subproducto ";
			$Consulta.= " where cod_producto = '".$Producto."'";
			$Consulta.= " and cod_subproducto = '".$SubProducto."'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Respuesta))
			{
				echo strtoupper($Fila["descripcion"]);
			}
		}
?>
      </td>
    </tr>
    <tr> 
      <td><strong>PERIODO</strong></td>
      <td> 
        <?php 
		echo str_pad($DiaIni,2, "0", STR_PAD_LEFT)."/".str_pad($MesIni, 2, "0", STR_PAD_LEFT)."/".$AnoIni." AL ".str_pad($DiaFin, 2, "0", STR_PAD_LEFT)."/".str_pad($MesFin, 2, "0", STR_PAD_LEFT)."/".$AnoFin;
	?>
      </td>
    </tr>
    <tr> 
      <td colspan="2"><strong> 
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
        </strong></td>
    </tr>
  </table>
<br>
<?php
	$ArrLeyes = array();
	$FechaAux = $AnoIni."-".str_pad($MesIni,2, "0", STR_PAD_LEFT)."-".str_pad($DiaIni,2, "0", STR_PAD_LEFT);
	$FechaInicio = $FechaAux;
	$FechaTermino = $AnoFin."-".str_pad($MesFin,2, "0", STR_PAD_LEFT)."-".str_pad($DiaFin,2, "0", STR_PAD_LEFT);
	//-------------------------LEYES DE CALIDAD-----------------------------
	$Consulta = "select distinct t3.cod_leyes, t3.abreviatura ";
	$Consulta.= " from cal_web.solicitud_analisis t1 inner join ";
	$Consulta.= " cal_web.leyes_por_solicitud  t2 on t1.nro_solicitud = t2.nro_solicitud ";
	$Consulta.= " and t1.fecha_hora = t2.fecha_hora and t1.rut_funcionario = t2.rut_funcionario and t1.recargo = t2.recargo ";
	$Consulta.= " inner join proyecto_modernizacion.leyes t3 on t2.cod_leyes = t3.cod_leyes";
	$Consulta.= " where t1.estado_actual <> '16' and t1.estado_actual <> '7'";
	$Consulta.= " and t1.frx <> 'S' and t1.cod_analisis = '1'";
	if ($Producto == "48")
		$Consulta.= " and t1.cod_periodo = '2'";
	else
		$Consulta.= " and t1.cod_periodo = '1'";
	if (($Producto == "48") || ($Producto == "18" && $SubProducto != "5"))
	{
		$Consulta.= " and t1.cod_producto = '18'";
		if ((($Producto == "18") && (intval($Fila3["cod_grupo"]) < 50)) || ($Producto == "48"))
		{
			$Consulta.= " and t1.cod_subproducto = '1'";
		}
	}
	else
	{	
		if ($Producto == 64 && ($SubProducto == 5 || $SubProducto == 1))
		{
			$Consulta.= " and t1.cod_producto = '64'";
			$Consulta.= " and (t1.cod_subproducto = '1' || t1.cod_subproducto = '5')";
		}
		else
		{			
			$Consulta.= " and t1.cod_producto = '".$Producto."'";
			$Consulta.= " and t1.cod_subproducto = '".$SubProducto."'";
		}
	}
	$Consulta.= " order by t3.cod_leyes ";
	$Respuesta2 = mysqli_query($link, $Consulta);
	$ArrLeyes["02"][0] = "02";
	$ArrLeyes["02"][1] = "Cu";
	$ArrLeyes["02"][2] = "";   
	while ($Fila2 = mysqli_fetch_array($Respuesta2))
	{
		$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase = '3009' ";
		$Consulta.= " and nombre_subclase = '".$Fila2["cod_leyes"]."'";
		$Respuesta3 = mysqli_query($link, $Consulta);				
		if ($Fila3 = mysqli_fetch_array($Respuesta3))
		{	
			$ArrLeyes[$Fila2["cod_leyes"]][0] = $Fila2["cod_leyes"];
			$ArrLeyes[$Fila2["cod_leyes"]][1] = $Fila2["abreviatura"];
			$ArrLeyes[$Fila2["cod_leyes"]][2] = "";   
		}	
	}
	$LargoTabla = 300 + (count($ArrLeyes) * 25);
?>
<table width="<?php echo $LargoTabla; ?>" border="1" cellpadding="3" cellspacing="0" class="TablaDetalle">
  <tr align="center" class="ColorTabla01"> 
    <td width="88" rowspan="2">LOTE</td>
    <td width="36" rowspan="2">N.ENVIO</td>	
	<td width="37" rowspan="2">&nbsp;</td>
	<td width="73" rowspan="2">N.CERT</td>
	<td width="73" rowspan="2">PESO </td>
    <?php	
	reset($ArrLeyes);
	while (list($k,$v)=each($ArrLeyes))
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
	<?php
		switch ($FinoLeyes)
		{
			case "F":
      			echo "<td colspan='".count($ArrLeyes)."' align='center'>Finos</td>\n";
				break;
			case "L":
      			echo "<td colspan='".count($ArrLeyes)."' align='center'>Leyes</td>\n";
				break;
		}
	 ?>
	 </tr>
  <?php  
  	$ArrTotal = array();	
	$Color = "";
	$TotalPeso = 0;
	if ($Color == "")
		$Color = "WHITE";
	else
		$Color = "";
	$Consulta = "select sum(t1.peso_paquetes) as peso,t2.cod_bulto,t2.num_bulto, t1.corr_enm ";
	$Consulta.= "from sec_web.paquete_catodo t1 ";
	$Consulta.=" inner join sec_web.guia_despacho_emb t2 on t1.num_guia=t2.num_guia	";
	$Consulta.= " where t2.fecha_guia between '".$FechaInicio."' and '".$FechaTermino."'";
	if ($Producto == 64 && ($SubProducto == 5 || $SubProducto == 1))
	{
		$Consulta.= " and t1.cod_producto = '64' and (t1.cod_subproducto = '1' || t1.cod_subproducto = '5')";
	}
	else	
	{
		$Consulta.= " and t1.cod_producto = '".$Producto."' and t1.cod_subproducto = '".$SubProducto."'	";
	}
	$Consulta.= " group by t2.cod_bulto,t2.num_bulto";
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		if ($Color == "")
			$Color = "WHITE";
		else
			$Color = "";
		echo "<tr bgcolor = '".$Color."'>\n";
		reset($ArrLeyes);	
		while (list($k,$v)=each($ArrLeyes))
		{
			$v[2] = "";
		}		
		echo "<td align='center'>".strtoupper($Fila["cod_bulto"])."-".str_pad($Fila["num_bulto"],6,0,STR_PAD_LEFT)."</td>\n";
		$Consulta = "select num_envio from sec_web.embarque_ventana where cod_bulto = '".$Fila["cod_bulto"]."' and num_bulto = '".$Fila["num_bulto"]."'";
		$Resp2 = mysqli_query($link, $Consulta);
		if ($Fila2 = mysqli_fetch_array($Resp2))
			echo "<td align='center'>".str_pad($Fila2["num_envio"],5, "0", STR_PAD_LEFT)."</td>\n";
		else
			echo "<td align='center'>&nbsp;</td>\n";
		//ORDEN DE EMBARQUE
		echo "<td align='center'>".$Fila["corr_enm"]."</td>\n";
		$NumCertificado = "";
		$Certif = false;
		//-----------------------BUSCA LEYES EN CERTIFICADO---------------------
		$Consulta = "select t2.cod_leyes, t2.valor, t2.fecha, ";
		$Consulta.= " t2.signo, t3.abreviatura, t2.num_certificado, t2.version ";
		$Consulta.= " from sec_web.solicitud_certificado t1 inner join sec_web.certificacion_catodos t2 ";
		$Consulta.= " on t1.corr_enm = t2.corr_enm inner join proyecto_modernizacion.leyes t3";
		$Consulta.= " on t2.cod_leyes = t3.cod_leyes";
		$Consulta.= " where t1.cod_bulto = '".$Fila["cod_bulto"]."' and t1.num_bulto = '".$Fila["num_bulto"]."'";
		$Consulta.= " and t2.version = (select max(t2.version) from sec_web.solicitud_certificado t1 ";
		$Consulta.= " inner join sec_web.certificacion_catodos t2 ";
		$Consulta.= " on t1.corr_enm = t2.corr_enm ";
		$Consulta.= " where t1.cod_bulto = '".$Fila["cod_bulto"]."' and t1.num_bulto = '".$Fila["num_bulto"]."')";
		$Consulta.= " order by t2.cod_leyes";
		$Respuesta2 = mysqli_query($link, $Consulta);
		$Encontro = false;
		while ($Fila2 = mysqli_fetch_array($Respuesta2))
		{
			$Certif = true;
			$Encontro = true;
			$ArrLeyes[$Fila2["cod_leyes"]][2] = $Fila2["valor"];
			$NumCertificado = $Fila2["num_certificado"];					
		}
		//----------------------------------------------------------------------
		//---------------------BUSCA LEYES EN CALIDAD---------------------------
		if ($Encontro == false)
		{
			if ($Producto == "18" && ($SubProducto == 6 || $SubProducto == 8 || $SubProducto == 9 || $SubProducto == 10 || $SubProducto == 12))
			{//LOTE EXTERNO
				$Consulta = "select distinct t1.lote_origen as cod_grupo, sum(t1.peso_paquete) as peso_paquetes, fecha_creacion_paquete";
				$Consulta.= " from sec_web.paquete_catodo_externo t1 inner join sec_web.lote_catodo t2 ";
				$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete ";
				$Consulta.= " where t1.cod_producto = '".$Producto."' and t1.cod_subproducto = '".$SubProducto."'";
				$Consulta.= " and t2.cod_bulto = '".$Fila["cod_bulto"]."' and t2.num_bulto = '".$Fila["num_bulto"]."' ";
				$Consulta.= " group by t1.lote_origen";
			}
			else
			{//LOTE VENTANA			
				$Consulta = "select distinct t1.cod_grupo, sum(t1.peso_paquetes) as peso_paquetes, t1.fecha_creacion_paquete";
				$Consulta.= " from sec_web.paquete_catodo t1 inner join sec_web.lote_catodo t2 ";
				$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete ";
				$Consulta.= " and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete ";
				$Consulta.= " where t1.cod_producto = '".$Producto."' and t1.cod_subproducto = '".$SubProducto."'";
				$Consulta.= " and t2.cod_bulto = '".$Fila["cod_bulto"]."' and t2.num_bulto = '".$Fila["num_bulto"]."' ";
				$Consulta.= " group by t1.cod_grupo";
			}			
			$Respuesta3 = mysqli_query($link, $Consulta);
			$ArrGrupos = array();			
			$i = 0;
			while ($Fila3 = mysqli_fetch_array($Respuesta3))
			{												
				//-------------------------LEYES DE CALIDAD-----------------------------
				$Consulta = "select t2.cod_leyes, t2.valor, t1.fecha_muestra, ";
				$Consulta.= " t2.signo, t1.nro_solicitud, t3.abreviatura ";
				$Consulta.= " from cal_web.solicitud_analisis t1 inner join ";
				$Consulta.= " cal_web.leyes_por_solicitud  t2 on t1.nro_solicitud = t2.nro_solicitud ";
				$Consulta.= " and t1.fecha_hora = t2.fecha_hora and t1.rut_funcionario = t2.rut_funcionario and t1.recargo = t2.recargo ";
				$Consulta.= " inner join proyecto_modernizacion.leyes t3 on t2.cod_leyes = t3.cod_leyes";
				$Consulta.= " where t1.estado_actual <> '16' and t1.estado_actual <> '7'";
				if (($Producto == "18") && ($SubProducto != "5"))					
				{
					$Consulta.= " and ((t1.tipo = 1 and (t1.id_muestra = '".$Fila3["cod_grupo"]."' or t1.id_muestra = '".intval($Fila3["cod_grupo"])."')) ";
					$Consulta.= " or (tipo = '2' and (t1.id_muestra = '".$Fila3["cod_grupo"]."-R' or t1.id_muestra = '".intval($Fila3["cod_grupo"])."-R'))) ";
				}
				if (($Producto == "18") && (intval($Fila3["cod_grupo"]) >= 50))
				{
					$Fecha1 = date("Y-m-d",mktime(0,0,0,substr($Fila3["fecha_creacion_paquete"],5,2),(substr($Fila3["fecha_creacion_paquete"],8,2)+15),substr($Fila3["fecha_creacion_paquete"],0,4)));
					$ConsFechaMax = "select max(fecha_muestra) as fecha_muestra from cal_web.solicitud_analisis t1";
					$ConsFechaMax.= " where  ((t1.tipo = 1 and (t1.id_muestra = '".$Fila3["cod_grupo"]."' or t1.id_muestra = '".intval($Fila3["cod_grupo"])."')) ";
					$ConsFechaMax.= " or (tipo = '2' and (t1.id_muestra = '".$Fila3["cod_grupo"]."-R' or t1.id_muestra = '".intval($Fila3["cod_grupo"])."-R'))) ";
					$ConsFechaMax.= " and t1.estado_actual <> '16' and t1.estado_actual <> '7'";
					$ConsFechaMax.= " and t1.frx <> 'S' and t1.cod_analisis = '1'";
					$ConsFechaMax.= " and t1.cod_periodo = '1'";
					$ConsFechaMax.= " and t1.cod_producto = '18'";
					$ConsFechaMax.= " and t1.fecha_muestra <= '".$Fecha1."'";
					$ConsFechaMax.= " order by t1.fecha_muestra desc ";
					$RespFechaMax = mysqli_query($link, $ConsFechaMax);
					if ($FilaF = mysqli_fetch_array($RespFechaMax))
					{
						$Fecha1 = substr($FilaF["fecha_muestra"],0,10);
						$Fecha2 = substr($FilaF["fecha_muestra"],0,10);
					}
					else
					{
						$Fecha1 = date("Y-m-d",mktime(0,0,0,substr($Fila3["fecha_creacion_paquete"],5,2),(substr($Fila3["fecha_creacion_paquete"],8,2)-4),substr($Fila3["fecha_creacion_paquete"],0,4)));
						$Fecha2 = date("Y-m-d",mktime(0,0,0,substr($Fila3["fecha_creacion_paquete"],5,2),(substr($Fila3["fecha_creacion_paquete"],8,2)+4),substr($Fila3["fecha_creacion_paquete"],0,4)));						
					}
				}
				else
				{
					if ($Producto == "48") //LEY SEMANAL
					{ 
						if (intval(substr($Fila3["fecha_creacion_paquete"],8,2)) <= 7)
						{
							$Fecha1 = substr($FechaAux,0,7)."-01";					
							$Fecha2 = substr($FechaAux,0,7)."-07";
						}
						else
						{
							if ((intval(substr($Fila3["fecha_creacion_paquete"],8,2)) >= 8) && (intval(substr($Fila3["fecha_creacion_paquete"],8,2)) <= 14))
							{					
								$Fecha1 = substr($FechaAux,0,7)."-08";					
								$Fecha2 = substr($FechaAux,0,7)."-14";
							}
							else
							{
								if ((intval(substr($Fila3["fecha_creacion_paquete"],8,2)) >= 22) && (intval(substr($Fila3["fecha_creacion_paquete"],8,2)) <= 31))
								{					
									$Fecha1 = substr($FechaAux,0,7)."-22";					
									$Fecha2 = substr($FechaAux,0,7)."-31";
								}							
							}
						}					
					}
					else
					{
						$Fecha1 = date("Y-m-d",mktime(0,0,0,substr($Fila3["fecha_creacion_paquete"],5,2),(substr($Fila3["fecha_creacion_paquete"],8,2)-4),substr($Fila3["fecha_creacion_paquete"],0,4)));
						$Fecha2 = date("Y-m-d",mktime(0,0,0,substr($Fila3["fecha_creacion_paquete"],5,2),(substr($Fila3["fecha_creacion_paquete"],8,2)+4),substr($Fila3["fecha_creacion_paquete"],0,4)));						
					}
				}	
				$Consulta.= " and t1.fecha_muestra between '".$Fecha1." 00:00:00' and '".$Fecha2." 23:59:59'";								
				$Consulta.= " and t1.frx <> 'S' and t1.cod_analisis = '1'";
				if ($Producto == "48")
					$Consulta.= " and t1.cod_periodo = '2'";
				else
					$Consulta.= " and t1.cod_periodo = '1'";
				if (($Producto == "48") || ($Producto == "18" && $SubProducto != "5"))
				{
					$Consulta.= " and t1.cod_producto = '18'";
					if ((($Producto == "18") && (intval($Fila3["cod_grupo"]) < 50)) || ($Producto == "48"))
					{
						$Consulta.= " and t1.cod_subproducto = '1'";
					}
				}
				else
				{				
					$Consulta.= " and t1.cod_producto = '".$Producto."'";
					$Consulta.= " and t1.cod_subproducto = '".$SubProducto."'";
				}
				$Consulta.= " order by t1.fecha_muestra desc, t1.nro_solicitud, t2.cod_leyes ";
				$Respuesta2 = mysqli_query($link, $Consulta);						
				while ($Fila2 = mysqli_fetch_array($Respuesta2))
				{
					reset($ArrLeyes);	
					while (list($k,$v)=each($ArrLeyes))
					{							
						if ($v[0] == $Fila2["cod_leyes"])
						{	
							$ArrGrupos[$Fila2["cod_leyes"]][0] = strtoupper($Fila["cod_bulto"])."-".str_pad($Fila["num_bulto"],6,0,STR_PAD_LEFT);
							$ArrGrupos[$Fila2["cod_leyes"]][1] = $ArrGrupos[$Fila2["cod_leyes"]][1] + $Fila3["peso_paquetes"];
							$ArrGrupos[$Fila2["cod_leyes"]][2] = $Fila2["cod_leyes"];
							$ArrGrupos[$Fila2["cod_leyes"]][3] = $ArrGrupos[$Fila2["cod_leyes"]][3] + $Fila2["valor"];
							$ArrGrupos[$Fila2["cod_leyes"]][4] = $ArrGrupos[$Fila2["cod_leyes"]][4] + ($Fila2["valor"] * $Fila3["peso_paquetes"]);					
						}
					}
				}
				reset($ArrGrupos);
				while (list($k,$v)=each($ArrGrupos))
				{							
					$ArrLeyes[$v[2]][2] = $v[4] / $v[1];				
				}
			}									
		}
		//----------------------------------------------------------------------
		if ($NumCertificado == "" || $NumCertificado == "0")
			echo "<td align='right'>&nbsp;</td>\n";
		else
			echo "<td align='right'>".str_pad($NumCertificado,5, "0", STR_PAD_LEFT)."</td>\n";
		echo "<td align='right'>".number_format($Fila["peso"],0,",",".")."</td>\n";
		if ($Certif == true)
		{
			$SumaImpurezas = "";
			reset($ArrLeyes);
			while (list($k,$v)=each($ArrLeyes))
			{
				if ($v[0] != "48")
				{
					if ($v[0] != "04" || $v[0] != "05")			
						$SumaImpurezas = $SumaImpurezas + ($v[2] / 10000);
					else
						$SumaImpurezas = $SumaImpurezas + ($v[2] / 10000);
				}
			}
			if ((100 - $SumaImpurezas) > 99.980)
				$ArrLeyes["02"][2] = "99.99";
			else
				$ArrLeyes["02"][2] = 100 - $SumaImpurezas;			
		}	
		/*if (($Producto == "18" && $SubProducto != "5") || ($Producto == "48"))
		{			
			$ArrLeyes["02"][2] = 99.99;
		}*/						
		reset($ArrLeyes);
		while (list($k,$v)=each($ArrLeyes))
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
				$ArrTotal[$v[0]][0] = $v[0];
				$ArrTotal[$v[0]][1] = $ArrTotal[$v[0]][1] + $Valor;
			}					
			if ($v[0] == "02") 
				echo "<td align='right'>".number_format($Valor,2,",",".")."</td>";
			else
				echo "<td align='right'>".number_format($Valor,1,",",".")."</td>";
		}			
		//------------------------------------------------------------------------------------------------					
		echo "</tr>\n";
		$TotalPeso = $TotalPeso + $Fila["peso"];		
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
