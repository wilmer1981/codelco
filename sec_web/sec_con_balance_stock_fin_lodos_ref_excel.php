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
	$AnoFin  = isset($_REQUEST["AnoFin"])?$_REQUEST["AnoFin"]:"";
	$MesFin  = isset($_REQUEST["MesFin"])?$_REQUEST["MesFin"]:"";
	$DiaFin  = isset($_REQUEST["DiaFin"])?$_REQUEST["DiaFin"]:"31";
	$AnoIni  = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:$AnoFin;
	$MesIni  = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:$MesFin;
	$DiaIni  = isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:"01";

	$Producto     = isset($_REQUEST["Producto"])?$_REQUEST["Producto"]:"";
	$SubProducto  = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";
	$FinoLeyes    = isset($_REQUEST["FinoLeyes"])?$_REQUEST["FinoLeyes"]:"";
	if (!isset($DiaIni))
	{
		//$DiaIni = "01";
		//$MesIni = $MesFin;
		//$AnoIni = $AnoFin;
		//$DiaFin = "31";
	}
	$FechaAux = $AnoIni."-".str_pad($MesIni,2, "0", STR_PAD_LEFT)."-".str_pad($DiaIni,2, "0", STR_PAD_LEFT);	
	$FechaTermino = $AnoFin."-".str_pad($MesFin,2, "0", STR_PAD_LEFT)."-".str_pad($DiaFin,2, "0", STR_PAD_LEFT);
	$FechaAux = date("Y-m-d", mktime(0,0,0,substr($FechaAux,5,2) + 1,01,substr($FechaAux,0,4)));
	$FechaInicio = $FechaAux;
	$FechaTermino = date("Y-m-d", mktime(0,0,0,substr($FechaAux,5,2) + 1,01,substr($FechaAux,0,4)));
	$FechaTermino = date("Y-m-d", mktime(0,0,0,substr($FechaTermino,5,2),intval(substr($FechaTermino,8,2)) - 1,substr($FechaTermino,0,4)));	 
?>
<html>
<head>
<title>Sistema Estadistico de Catodos</title>
</head>
<body >
<form name="frmPrincipal" action="" method="post">
  <table width="523" border="1" cellpadding="3" cellspacing="0" class="TablaInterior">
    <tr align="center">
      <td height="30" colspan="10"><strong>TIPO DE MOVIMIENTO PESAJE DE PAQUETES</strong></td>
    </tr>
    <tr> 
      <td width="120" colspan="3"><strong>PRODUCTO</strong></td>
      <td width="387" colspan="7"> 
        <?php
		$Consulta = "SELECT * from proyecto_modernizacion.productos ";
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
      <td colspan="3"><strong>SUBPRODUCTO</strong></td>
      <td colspan="7"> 
        <?php		
			$Consulta = "SELECT * from proyecto_modernizacion.subproducto ";
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
	$ArrLeyesFinal = array();
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
	if ($SubProducto == 12)		
		$LargoTabla = 500 + (count($ArrLeyes) * 25);
	else
		$LargoTabla = 800 + (count($ArrLeyes) * 25);
	
?>
  <table width="<?php echo $LargoTabla; ?>" border="1" cellpadding="3" cellspacing="0" class="TablaDetalle">
    <tr align="center" class="ColorTabla01"> 
      <td width="150" rowspan="2">LOTE</td>
<?php
	if ($SubProducto == 12)	
	{
		echo "<td width='100' rowspan='2'>N.ENVIO</td>\n";
		echo "<td width='80' rowspan='2'>N.CERT.HUM</td>\n";
	  	echo "<td width='80' rowspan='2'>P.HUM Kg</td>\n";
	  	echo "<td width='80' rowspan='2'>H2O (%)</td>\n";
      	echo "<td width='80' rowspan='2' align='center'>P.SECO Kg</td>\n";
		echo "<td width='80' rowspan='2'>N.CERT.</td>\n";
	}
	else
	{
		echo "<td width='80' rowspan='2'>N.CERT</td>\n";
	  	echo "<td width='80' rowspan='2'>P.HUM Kg</td>\n";
	  	echo "<td width='80' rowspan='2'>H2O (%)</td>\n";
      	echo "<td width='80' rowspan='2' align='center'>P.SECO Kg</td>\n";
	}
?>		       
      
      <?php	
	reset($ArrLeyesFinal);
	foreach($ArrLeyesFinal as $k => $v)
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
      <td width="38" colspan="<?php echo count($ArrLeyesFinal); ?>" align="center"> 
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
	//$ArrLeyesFinal = array();
	$ArrTotal = array();
  	$Consulta = "SELECT * from proyecto_modernizacion.sub_clase ";
	$Consulta.= " where cod_clase = '3004' and cod_subclase = '".intval(substr($FechaAux,5,2))."'"	;
	$Respuesta = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		$MesConsulta = $Fila["nombre_subclase"];
	}
	$Color = "";
	$TotalPeso = 0;	
	$Eliminar = "DROP TABLE `sec_web`.`tmp_stock_ini`";
	mysqli_query($link, $Eliminar);
	$Consulta = " create table sec_web.tmp_stock_ini as ";
	$Consulta.= " SELECT t2.cod_bulto, t2.num_bulto, year(t2.fecha_creacion_lote) as ano_creacion, sum(t1.peso_paquetes) as peso ";
	$Consulta.= " from sec_web.paquete_catodo t1 inner join sec_web.lote_catodo t2 ";	
	$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete ";
	$Consulta.= " and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete ";
	$Consulta.= " where ";
	$Consulta.= " t1.cod_producto = '57' and t1.cod_subproducto = '11' ";
	$Consulta.= " and t1.cod_estado = 'a' ";
	$Consulta.= " and (year(t1.fecha_creacion_paquete) <= ".$AnoFin." ";
	if (strtoupper($MesConsulta)=='A')
		$Consulta.= " and t1.cod_paquete <= 'M' ";
	else
		$Consulta.= " and t1.cod_paquete < '".$MesConsulta."' ";
	$Consulta.= " or year(t1.fecha_creacion_paquete) < ".$AnoFin.") ";
	$Consulta.= " group by t2.cod_bulto, t2.num_bulto ";
	$Consulta.= " order by ano_creacion, t2.cod_bulto, t2.num_bulto";
	mysqli_query($link, $Consulta);	
	$Consulta = " SELECT sum(t1.peso_paquetes) as peso,t2.cod_bulto,t2.num_bulto ";
	$Consulta.= " from sec_web.paquete_catodo t1  ";
	$Consulta.= " inner join sec_web.guia_despacho_emb t2 on t1.num_guia=t2.num_guia ";
	$Consulta.= " where t2.fecha_guia between '".$FechaInicio."' and '".$FechaTermino."' ";
	$Consulta.= " and t1.cod_producto = '57' and t1.cod_subproducto = '11' ";
	$Consulta.= " and (year(t1.fecha_creacion_paquete) = ".$AnoFin."  ";
	if (strtoupper($MesConsulta)=='A')
		$Consulta.= " and t1.cod_paquete <= 'M' ";
	else
		$Consulta.= " and t1.cod_paquete < '".$MesConsulta."' ";
	$Consulta.= " or year(t1.fecha_creacion_paquete) < ".$AnoFin.")  ";
	$Consulta.= " group by t2.cod_bulto,t2.num_bulto ";
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		$Insertar = "insert into sec_web.tmp_stock_ini (cod_bulto, num_bulto, ano_creacion, peso) ";
		$Insertar.= "values('".$Fila["cod_bulto"]."','".$Fila["num_bulto"]."','','".$Fila["peso"]."')";
		mysqli_query($link, $Insertar);
	}
	$Consulta = "SELECT * from sec_web.tmp_stock_ini order by cod_bulto, num_bulto";
	$Respuesta = mysqli_query($link, $Consulta);
	$TotalPeso = 0;
	$TotalHumedo=0;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
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
		if ($Fila["cod_bulto"] == "")
		{
			echo "<td align='center'>Sin Lote</td>\n";
		}
		else
		{
			$Consulta = "SELECT cod_bulto, num_bulto, fecha_creacion_lote ";
			$Consulta.= "from sec_web.lote_catodo ";
			$Consulta.= " where cod_bulto = '".$Fila["cod_bulto"]."' and num_bulto='".$Fila["num_bulto"]."'";
			$Resp2 = mysqli_query($link, $Consulta);
			if ($Fila2 = mysqli_fetch_array($Resp2))
			{
				$FechaCreacionLote = substr($Fila2["fecha_creacion_lote"],0,4);
			}
			echo "<td align='center'>";				
			echo strtoupper($Fila["cod_bulto"])."-".str_pad($Fila["num_bulto"],6,0,STR_PAD_LEFT)."</td>\n";						
		}
		//ENVIO
		if ($SubProducto == 12)
		{
			$Consulta = "SELECT num_envio from sec_web.embarque_ventana where cod_bulto = '".$Fila["cod_bulto"]."' and num_bulto = '".$Fila["num_bulto"]."'";
			$Resp2 = mysqli_query($link, $Consulta);
			if ($Fila2 = mysqli_fetch_array($Resp2))
				echo "<td align='center'>".str_pad($Fila2["num_envio"],5, "0", STR_PAD_LEFT)."</td>\n";
			else
				echo "<td align='center'>&nbsp;</td>\n";
		}
		$NumCertificado = "";		
		//PESOS Y LEYES
		$Humedad = 0;
		$NroHumedad = "";
		$NroSA = "";
		if ($SubProducto == 11)
		{
			BuscaLeyesProduccion($Fila["cod_bulto"],$Fila["num_bulto"],$ArrLeyesFinal,$link);
			$Humedad = 0;
			reset($ArrLeyesFinal);		
			foreach($ArrLeyesFinal as $v => $k)
			{
				if ($k[0]=="01")
					$Humedad = $k[4];
			}		
		}
		else
		{
			BuscaLeyesAnalisis($Fila["cod_bulto"],$Fila["num_bulto"],$ArrLeyesFinal,$Humedad,$NroHumedad,$NroSA,$link);			
		}
		$PesoHumedo = $Fila["peso"];
		$PesoSeco = abs($PesoHumedo - (($PesoHumedo*$Humedad)/100));
		//CERTIFICADO
		if ($SubProducto == 12)
		{			
			if ($NroHumedad != "")			
				echo "<td align='center'>".$NroHumedad."</td>\n";
			else
				echo "<td align='center'>&nbsp;</td>\n";
		}
		else
		{	
			echo "<td align='center' bgcolor='yellow'>Ponderado</td>\n";	
		}				
		echo "<td align='right'>".number_format($PesoHumedo,0,",",".")."</td>\n";
		echo "<td align='right'>".number_format($Humedad,2,",",".")."</td>\n";		
		echo "<td align='right'>".number_format($PesoSeco,0,",",".")."</td>\n";		
		if ($SubProducto == 12)
		{		
			if ($NroSA != "")			
				echo "<td align='center'>".str_pad($NroSA,5, "0", STR_PAD_LEFT)."</td>\n";
			else
				echo "<td align='center'>&nbsp;</td>\n";				
		}
		reset($ArrLeyesFinal);			
		while (list($k,$v)=each($ArrLeyesFinal))
		{
			if ($v[0]!="01")
			{
				if ($FinoLeyes == "L")
				{
					$Valor = $v[4];
					switch ($v[0])
					{
						case "02":
							$ValorAux = ($v[4] * $PesoSeco) / 100;
							break;
						case "04":
							$ValorAux = ($v[4] * $PesoSeco) / 1000;
							break;
						case "05":
							$ValorAux = ($v[4] * $PesoSeco) / 1000;
							break;
						default:
							$ValorAux = ($v[4] * $PesoSeco) / 1000000;
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
							$Valor = ($v[4] * $PesoSeco) / 100;
							break;
						case "04":
							$Valor = ($v[4] * $PesoSeco) / 1000;
							break;
						case "05":
							$Valor = ($v[4] * $PesoSeco) / 1000;
							break;
						default:
							$Valor = ($v[4] * $PesoSeco) / 1000000;
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
		}
		$TotalHumedo = $TotalHumedo + $PesoHumedo;	
		$TotalPeso = $TotalPeso + $PesoSeco;			
		//------------------------------------------------------------------------------------------------			
	}		
	//TOTALES
	if ($TotalPeso>0 && $TotalHumedo>0)
		$Humedad = 100 - (($TotalPeso/$TotalHumedo)*100);
	else
		$Humedad = 0;
    echo "<tr>\n";
	if ($SubProducto==11) 
	    echo "<td colspan='2'>TOTAL</td>\n";
	else
		echo "<td colspan='3'>TOTAL</td>\n";
    echo "<td align='right'>".number_format($TotalHumedo,0,",",".")."</td>\n";
	echo "<td align='right'>".number_format($Humedad,2,",",".")."</td>\n";
	echo "<td align='right'>".number_format($TotalPeso,0,",",".")."</td>\n";
	if ($SubProducto==12) 
		echo "<td align='center'>&nbsp;</td>\n";
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
<?php
function BuscaLeyesProduccion($CodBulto, $NumBulto, $Arreglo, $link)
{
	//SELECCIONA LAS DISTINTAS SERIES CON SUS PESOS
	$Consulta = "SELECT t2.cod_paquete, SUM(t2.peso_paquetes) as peso_sublote, year(t2.fecha_creacion_paquete) as ano, t3.cod_subclase as mes ";
	$Consulta.= " from sec_web.lote_catodo t1 inner join";
	$Consulta.= " sec_web.paquete_catodo t2 on t1.cod_paquete = t2.cod_paquete and";
	$Consulta.= " t1.num_paquete = t2.num_paquete and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete";
	$Consulta.= " inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase = '3004'";
	$Consulta.= " where t1.cod_bulto = '".$CodBulto."'";
	$Consulta.= " and t1.num_bulto = '".$NumBulto."'";
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
		while (list($v,$k)=each($Arreglo))
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

function BuscaLeyesAnalisis($CodBulto, $NumBulto, $Arreglo, $LeyHum, $SAHum, $SA, $link)
{
	//PESO DEL LOTE
	$Consulta = "SELECT ifnull(t2.cod_bulto,'') as cod_bulto, ifnull(t2.num_bulto,'0') as num_bulto, sum(t1.peso_paquetes) as peso";
	$Consulta.= " from sec_web.paquete_catodo t1 left join sec_web.lote_catodo t2";
	$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete";
	$Consulta.= " and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete ";
	$Consulta.= " where t2.cod_bulto = '".$CodBulto."'";	
	$Consulta.= " and t2.num_bulto = '".$NumBulto."'";					
	$Consulta.= " and t1.cod_producto = '57' and t1.cod_subproducto = '11'";
	$Consulta.= " group by t2.cod_bulto,  t2.num_bulto";
	//echo $Consulta;
	$Respuesta = mysqli_query($link, $Consulta);
	$Peso = 0;
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		$Peso = $Fila["peso"];
	}
	//---------------------
	$Consulta = "SELECT t2.cod_leyes, t2.valor, t1.fecha_muestra, ";
	$Consulta.= " t2.signo, t1.nro_solicitud ";
	$Consulta.= " from cal_web.solicitud_analisis t1 inner join ";
	$Consulta.= " cal_web.leyes_por_solicitud  t2 on t1.nro_solicitud = t2.nro_solicitud ";
	$Consulta.= " and t1.fecha_hora = t2.fecha_hora and t1.rut_funcionario = t2.rut_funcionario and t1.recargo = t2.recargo ";
	$Consulta.= " where t1.tipo = 1 and (t1.id_muestra like '%".$Peso."%' ";
	$Consulta.= " or t1.id_muestra like '%".number_format($Peso,0,",",".")."%' or t1.id_muestra like '%".number_format($Peso,0,".",",")."%') ";	
	$Consulta.= " and t1.estado_actual <> '16' and t1.estado_actual <> '7'";
	$Consulta.= " and t1.frx <> 'S' and t1.cod_analisis = '1'";
	$Consulta.= " and t1.cod_producto = '57' and t1.cod_subproducto = '11'";
	$Consulta.= "order by t1.fecha_muestra desc, t1.nro_solicitud, t2.cod_leyes ";
	$Resp2 = mysqli_query($link, $Consulta);
	//echo $Consulta;
	while ($Fila2 = mysqli_fetch_array($Resp2))
	{			
		if ($Fila2["cod_leyes"] == "01")
		{
			$LeyHum = $Fila2["valor"];
			$SAHum = $Fila2["nro_solicitud"];
		}
		else
		{									
			$Arreglo[$Fila2["cod_leyes"]][0] = $Fila2["cod_leyes"];	
			$Arreglo[$Fila2["cod_leyes"]][1] = $Fila2["valor"];
			$Arreglo[$Fila2["cod_leyes"]][3] = $Fila2["conversion"];			
			$Arreglo[$Fila2["cod_leyes"]][4] = $Fila2["valor"];
			$Arreglo[$Fila2["cod_leyes"]][5] = $Fila2["nro_solicitud"];
			$SA = $Fila2["nro_solicitud"];
		}
	}
}
?>
