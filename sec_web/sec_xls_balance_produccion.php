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
	if (!isset($DiaIni))
	{
		$DiaIni = "01";
		$MesIni = $MesFin;
		$AnoIni = $AnoFin;
		$DiaFin = "31";
	}
	include("../principal/conectar_principal.php");
	include("sec_con_func_produccion.php");
?>
<html>
<head>
<title>Sistema Estadistico de Catodos</title>
</head>

<body>
<form name="frmPrincipal" action="" method="post">
  <table width="523" border="1" cellpadding="3" cellspacing="0" class="TablaInterior">
    <tr> 
      <td colspan="5"><strong>PESAJE PRODUCCION</strong></td>
    </tr>
    <tr> 
      <td colspan="5">&nbsp;</td>
    </tr>
    <tr> 
      <td width="120" colspan="2"><strong>PRODUCTO</strong></td>
      <td width="387" colspan="3"> 
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
      <td colspan="2"><strong>SUBPRODUCTO</strong></td>
      <td colspan="3"> 
        <?php
		$Consulta = "select * from proyecto_modernizacion.subproducto ";
		$Consulta.= " where cod_producto = '".$Producto."'";
		$Consulta.= " and cod_subproducto = '".$SubProducto."'";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Respuesta))
		{
			echo strtoupper($Fila["descripcion"]);
		}
?>
      </td>
    </tr>
    <tr> 
      <td colspan="2"><strong>PERIODO</strong></td>
      <td colspan="3"> 
        <?php
		$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase = '2' and cod_subclase = '".$Periodo."'";	  
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Respuesta))
		{
			$DescPeriodo = $Fila["nombre_subclase"];
			echo $DescPeriodo;
		}
	  ?>
      </td>
    </tr>
    <tr> 
      <td colspan="2">&nbsp;</td>
      <td colspan="3"> 
        <?php 
		echo str_pad($DiaIni,2, "0", STR_PAD_LEFT)."/".str_pad($MesIni, 2, "0", STR_PAD_LEFT)."/".$AnoIni." AL ".str_pad($DiaFin, 2, "0", STR_PAD_LEFT)."/".str_pad($MesFin, 2, "0", STR_PAD_LEFT)."/".$AnoFin;
	?>
      </td>
    </tr>
    <tr> 
      <td colspan="5"><strong> 
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
$Consulta = "select count(*) as reg ";
$Consulta.= " from sec_web.tmp_tipo_mov_det ";
$Consulta.= " where cod_periodo = '".$Periodo."'";
$Respuesta = mysqli_query($link, $Consulta);
//echo $Consulta;
$Fila = mysqli_fetch_array($Respuesta);
if ($Fila["reg"] != 0)
{
  	echo "<table width='469' border='1' cellpadding='3' cellspacing='0' class='TablaDetalle'>\n";
	echo "<tr align='center' class='ColorTabla01'> \n";
	echo "<td width='18' align='center'>FECHA</td>\n";	
	echo "<td width='19' align='center'>S.A.</td>\n";
	if ($Periodo == 1)
	{
		echo "<td width='15' align='center'>GRUPO</td>\n";
		echo "<td width='15' align='center'>CUBA</td>\n";
	}
	echo "<td width='23' align='center'>P.HUM<br>kg</td>\n";
	echo "<td width='24' align='center'>H2O<br>%</td>\n";
	echo "<td width='23' align='center'>P.SECO<br>kg</td>\n";
	$ArrLeyes = array();
	$Consulta = "select distinct t1.cod_leyes, t2.abreviatura from sec_web.tmp_tipo_mov_det t1 inner join proyecto_modernizacion.leyes t2 ";
	$Consulta.= " on t1.cod_leyes = t2.cod_leyes ";
	$Consulta.= " where cod_periodo = '".$Periodo."'";
	$Consulta.= " order by t1.cod_leyes";
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		$ArrLeyes[$Fila["cod_leyes"]][0] = $Fila["cod_leyes"];
		$ArrLeyes[$Fila["cod_leyes"]][1] = $Fila["abreviatura"];
		echo "<td align='center'>".$Fila["abreviatura"]."<br>";
		if ($FinoLeyes == "F")
		{			
			switch ($Fila["cod_leyes"])
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
			switch ($Fila["cod_leyes"])
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
	$ContLeyes = count($ArrLeyes);	
    echo "</tr>\n";
	$CambiaColor = "N";
	$TotalPesoHumedo = 0;
	$TotalPesoSeco = 0;	
	if ($CambiaColor == "N")
		$CambiaColor = "S";
	else
		$CambiaColor = "N";		
	$Consulta = "select distinct tipo_mov, cod_producto, cod_subproducto, cod_periodo, fecha1, fecha2, ";
	$Consulta.= " grupo, cuba, num_envio, lote, nro_sa, num_certificado, grupo, cuba, peso ";
	$Consulta.= " from sec_web.tmp_tipo_mov_cab ";
	$Consulta.= " where cod_periodo = '".$Periodo."'";
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		$Consulta = "select nro_sa from sec_web.tmp_tipo_mov_det ";
		$Consulta.= " where fecha1 = '".$Fila["fecha1"]."'";
		$Consulta.= " and fecha2 = '".$Fila["fecha2"]."'";
		$Consulta.= " and num_envio = '".$Fila["num_envio"]."'";
		$Consulta.= " and lote = '".$Fila["lote"]."'";
		$Consulta.= " and num_certificado = '".$Fila["num_certificado"]."'";
		$Consulta.= " and grupo = '".$Fila["grupo"]."'";
		$Consulta.= " and cuba = '".$Fila["cuba"]."'";
		$Resp2 = mysqli_query($link, $Consulta);
		$NroSA = "";
		if ($Fila2 = mysqli_fetch_array($Resp2))
			$NroSA = $Fila2["nro_sa"];
		if ($CambiaColor == "N")
			echo "<tr>\n";
		else
			echo "<tr bgcolor='white'>\n";
		if ($Fila["fecha1"] == $Fila["fecha2"])
		{
			echo "<td align='center'>".substr($Fila["fecha1"],8,2)."/".substr($Fila["fecha1"],5,2)."/".substr($Fila["fecha1"],0,4)."</td></td>\n";
		}
		else
		{
			echo "<td align='center'>".substr($Fila["fecha1"],8,2)."/".substr($Fila["fecha1"],5,2)."/".substr($Fila["fecha1"],0,4)."";
			echo " al ".substr($Fila["fecha2"],8,2)."/".substr($Fila["fecha2"],5,2)."/".substr($Fila["fecha2"],0,4)."</td></td>\n";
		}
		if (trim($NroSA) != "" && !is_null($NroSA) && $NroSA != " ")
			echo "<td align='center'><a href=\"JavaScript:Historial(".$NroSA.")\">".$NroSA."</a></td>\n";
		else
			echo "<td align='center'>&nbsp;</td>\n";
		if ($Periodo == 1)
		{
			echo "<td align='center'>".$Fila["grupo"]."</td>\n";
			echo "<td align='center'>".$Fila["cuba"]."</td>\n";
		}
		echo "<td align='right'>&nbsp;</td>\n";
		echo "<td align='right'>&nbsp;</td>\n";
		echo "<td align='right'>".number_format($Fila["peso"],0,",",".")."</td>\n";
		reset($ArrLeyes);
		while (list($k,$v)=each($ArrLeyes))
		{
			$Consulta = "select * from sec_web.tmp_tipo_mov_det ";
			$Consulta.= " where fecha1 = '".$Fila["fecha1"]."'";
			$Consulta.= " and fecha2 = '".$Fila["fecha2"]."'";
			$Consulta.= " and num_envio = '".$Fila["num_envio"]."'";
			$Consulta.= " and lote = '".$Fila["lote"]."'";
			$Consulta.= " and nro_sa = '".$NroSA."'";
			$Consulta.= " and num_certificado = '".$Fila["num_certificado"]."'";
			$Consulta.= " and grupo = '".$Fila["grupo"]."'";
			$Consulta.= " and cuba = '".$Fila["cuba"]."'";
			$Consulta.= " and cod_leyes = '".$v[0]."'";
			$Resp2 = mysqli_query($link, $Consulta);
			if ($Fila2 = mysqli_fetch_array($Resp2))
			{
				$Valor = $Fila2["valor"];
				switch ($v[0])
				{
					case "02":
						$ValorAux = ($Fila2["valor"] * $Fila["peso"]) / 100;
						break;
					case "04":
						$ValorAux = ($Fila2["valor"] * $Fila["peso"]) / 1000;
						break;
					case "05":
						$ValorAux = ($Fila2["valor"] * $Fila["peso"]) / 1000;
						break;
					default:
						$ValorAux = ($Fila2["valor"] * $Fila["peso"]) / 1000000;
						break;
				}
				if ($FinoLeyes == "F")
				{										
					echo "<td align='right'>".number_format($ValorAux,2,",",".")."</td>\n";					
				}
				else
				{					
					echo "<td align='right'>".number_format($Valor,2,",",".")."</td>\n";				
				}
				$ArrTotal[$v[0]][0] = $v[0];				
				$ArrTotal[$v[0]][1] = $ArrTotal[$v[0]][1] + $ValorAux;
			}
			else
			{
				echo "<td align='right'>0</td>\n";				
			}
		}
		$TotalPesoSeco = $TotalPesoSeco + $Fila["peso"];			
	}
    echo "<tr>\n"; 
	if ($Periodo == 1)
	{
		echo "<td colspan='6'><b>TOTAL</b></td>\n";
	}
	else
	{
		echo "<td colspan='4'><b>TOTAL</b></td>\n";
	}
	echo "<td>".number_format($TotalPesoSeco,0,",",".")."</td>\n";
	foreach($ArrTotal as $k => $v)
	{
		echo "<td align='right'>\n";	 
		switch ($FinoLeyes)
		{
			case "L":
				switch ($v[0])
				{
					case "02":
		      			echo number_format(($v[1] / $TotalPesoSeco)*100,2,",",".");
						break;
					case "04":
		      			echo number_format(($v[1] / $TotalPesoSeco)*1000,2,",",".");
						break;
					case "05":
		      			echo number_format(($v[1] / $TotalPesoSeco)*1000,2,",",".");
						break;
					default:
						echo number_format(($v[1] / $TotalPesoSeco)*1000000,2,",",".");
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
	echo "</table>\n";
}
else
{
	echo "<b>NO SE ENCONTRARON ANALISIS QUIMICOS PARA ESTE PERIODO : ".$DescPeriodo."</b>";
}
?>  
  </form>
</body>
</html>
