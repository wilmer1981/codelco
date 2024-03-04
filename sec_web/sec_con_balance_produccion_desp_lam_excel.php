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

	$AnoIni  = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:date("Y");
	$MesIni  = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:date("m");
	$DiaIni  = isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:"01";
	$AnoFin  = isset($_REQUEST["AnoFin"])?$_REQUEST["AnoFin"]:date("Y");
	$MesFin  = isset($_REQUEST["MesFin"])?$_REQUEST["MesFin"]:date("m");
	$DiaFin  = isset($_REQUEST["DiaFin"])?$_REQUEST["DiaFin"]:"31";

	$FinoLeyes   = isset($_REQUEST["FinoLeyes"])?$_REQUEST["FinoLeyes"]:"";
	$ProdCons    = isset($_REQUEST["ProdCons"])?$_REQUEST["ProdCons"]:"";
	$SubProdCons = isset($_REQUEST["SubProdCons"])?$_REQUEST["SubProdCons"]:"";
	$FechaCons = isset($_REQUEST["FechaCons"])?$_REQUEST["FechaCons"]:date("Y-m-d");
	$Peso = isset($_REQUEST["Peso"])?$_REQUEST["Peso"]:0;

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
	

	
?>
<html>
<head>
<title>Sistema Estadistico de Catodos</title></head>
<body>
<form name="frmPrincipal" action="" method="post">
  <table width="622" border="1" cellspacing="0" cellpadding="2">
    <tr>
      <td height="30" colspan="10" align="center"><strong>TIPO DE MOVIMIENTO PESAJE
      DE PRODUCCION</strong></td>
    </tr>
    <tr> 
      <td width="153" colspan="3"><strong>PRODUCTO</strong></td>
      <td width="455" colspan="7">DESPUNTE Y LAMINAS</td>
    </tr>
    <tr> 
      <td colspan="3"><strong>SUBPRODUCTO</strong></td>
      <td colspan="7">TODOS</td>
    </tr>
    <tr> 
      <td colspan="3" width="153" height="25"><strong>PERIODO</strong></td>
      <td colspan="7"> 
        <?php 
	  	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	  	echo $Meses[$MesFin - 1]." del ".$AnoFin; 
	?>
      </td>
    </tr>
  </table>    
  <br>
<br>
  <table width="856" border="1" cellspacing="0" cellpadding="2">
    <tr align="center" class="ColorTabla01"> 
      <td width="110" rowspan="2">FECHA</td>
      <td width="80" rowspan="2">Guillotinas y Laminas Rechazadas</td>
      <td width="81" rowspan="2">Laminas Standard</td>
      <td width="86" rowspan="2">Pesada</td>
	  <td width="86" rowspan="2">Despuntes de Orejas</td>
      <td width="71" rowspan="2">S.A.</td>
      <td colspan="2"><?php if ($FinoLeyes == "F") echo "Finos"; else echo "Leyes"; ?></td>
      <td width="58" rowspan="2">Subtotal</td>
      <td width="74" rowspan="2">Barrido N.E.</td>
      <td width="54" rowspan="2">TOTAL</td>
    </tr>
    <tr class="ColorTabla01"> 
      <td width="53" align="center">S <?php if ($FinoLeyes == "F") echo "(kg)"; else echo "(ppm)"; ?></td>
      <td width="47" align="center">O <?php if ($FinoLeyes == "F") echo "(kg)"; else echo "(ppm)"; ?></td>
    </tr>
    <?php   
	$FechaInicio = $AnoFin."-".str_pad($MesFin,2, "0", STR_PAD_LEFT)."-".str_pad("01",2, "0", STR_PAD_LEFT);
	$FechaTermino = $AnoFin."-".str_pad($MesFin,2, "0", STR_PAD_LEFT)."-".str_pad("31",2, "0", STR_PAD_LEFT);
	$FechaAux = $FechaInicio;
	$TotalGuillotina = 0;
	$TotalLaminas = 0;
	$TotalOrejas = 0;
	$TotalBarrido = 0;
	$Total = 0;
	$PesoGuillotina=0;
	$PesoRechazConOreja=0;
	$PesoRechazSinOreja=0;
	$PesoLaminas=0;
	$PesoBarrido=0;
	$SA="";
	$Ley_S="";
	$Ley_O="";
	$PesoOrejas = 0;
	while ($FechaAux <= $FechaTermino)
	{
		// RESCATA PESOS
		RescataPeso(48, 1, $FechaAux, $PesoGuillotina, $SA, $Ley_S, $Ley_O, $link);
		RescataPeso(48, 6, $FechaAux, $PesoLaminas, $SA, $Ley_S, $Ley_O, $link);
		//RescataPeso(48, 2, $FechaAux, &$PesoOrejas, &$SA, &$Ley_S, &$Ley_O);
		RescataPeso(48, 10, $FechaAux, $PesoBarrido, $SA, $Ley_S, $Ley_O, $link);
		$SubTotal = $PesoGuillotina + $PesoLaminas + $PesoOrejas;
		$Total = $Total + $SubTotal;
		$TotalGuillotina = $TotalGuillotina + $PesoGuillotina;
		$TotalLaminas = $TotalLaminas + $PesoLaminas;
		$TotalOrejas = $TotalOrejas + $PesoOrejas;
		$TotalBarrido = $TotalBarrido + $PesoBarrido;		
		//CONSULTA CANTIDAD DE PESADAS DEL DIA
		$Consulta = "SELECT distinct cod_grupo, cod_cuba, count(*) as cant_pesadas";
		$Consulta.= " from sec_web.produccion_catodo";
		$Consulta.= " where cod_producto = '48'";
		$Consulta.= " and cod_subproducto = '2'";
		$Consulta.= " and fecha_produccion between '".$FechaAux."' and '".$FechaAux."'";				
		$Consulta.= " group by cod_producto, cod_subproducto ";
		$Respuesta = mysqli_query($link, $Consulta);
		$rowSpan = 0;
		if ($Fila = mysqli_fetch_array($Respuesta))
		{
			$rowSpan = $Fila["cant_pesadas"];
		}
		//---------------------------------------
		echo "<tr> \n";
		echo "<td align='center' rowspan='".$rowSpan."'>".substr($FechaAux,8,2)."/".substr($FechaAux,5,2)."/".substr($FechaAux,0,4)."</td> \n";				
		echo "<td align='right' rowspan='".$rowSpan."'>".number_format($PesoGuillotina,0,",",".")."</td> \n";
		echo "<td align='right' rowspan='".$rowSpan."'>".number_format($PesoLaminas,0,",",".")."</td> \n";
		//CONSULTA PESO OREJAS Y LEYES
		$Consulta = "SELECT cod_grupo, cod_cuba, sum(peso_produccion) as peso_produccion ";
		$Consulta.= " from sec_web.produccion_catodo";
		$Consulta.= " where cod_producto = '48'";
		$Consulta.= " and cod_subproducto = '2'";
		$Consulta.= " and fecha_produccion between '".$FechaAux."' and '".$FechaAux."'";				
		$Consulta.= " group by cod_grupo, cod_cuba ";
		$Respuesta = mysqli_query($link, $Consulta);
		$i = 1;
		$Entro=false;
		while ($Fila = mysqli_fetch_array($Respuesta))
		{			
			if ($i > 1)			
				echo "<tr>";						
			echo "<td align='right' bgcolor='#FFFF66'>".strtoupper($Fila["cod_grupo"])."-".str_pad($Fila["cod_cuba"],2,"0",STR_PAD_LEFT)."</td> \n";
			echo "<td align='right' bgcolor='#FFFF66'>".number_format($Fila["peso_produccion"],0,",",".")."</td> \n";
			$TotalOrejas = $TotalOrejas + $Fila["peso_produccion"];				
			$Entro = true;
			$Consulta = "SELECT t1.nro_solicitud, t1.fecha_muestra, t2.cod_leyes, t2.valor, t2.cod_unidad";
			$Consulta.= " from cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t2";
			$Consulta.= " on t1.rut_funcionario = t2.rut_funcionario and t1.nro_solicitud = t2.nro_solicitud";
			$Consulta.= " and t1.recargo = t2.recargo";
			$Consulta.= " where t1.cod_producto = '48'";
			$Consulta.= " and t1.cod_subproducto = '2'";
			$Consulta.= " and (t1.cod_periodo = '1' or t1.cod_periodo = '4')";
			$Consulta.= " and (t1.estado_actual <> '16' and t1.estado_actual <> '7')";
			$Consulta.= " and (t1.id_muestra LIKE '%".$Fila["cod_grupo"]."-".str_pad($Fila["cod_cuba"],2,"0",STR_PAD_LEFT)."%' or ";
			$Consulta.= " t1.id_muestra LIKE '%".$Fila["cod_grupo"]."-".intval($Fila["cod_cuba"])."%' or t1.id_muestra LIKE '%".$Fila["cod_grupo"]."".str_pad($Fila["cod_cuba"],2,"0",STR_PAD_LEFT)."%' or ";
			$Consulta.= " t1.id_muestra LIKE '%".$Fila["cod_grupo"]."".intval($Fila["cod_cuba"])."%')"; 
			$Consulta.= " and (t2.cod_leyes = '48' or t2.cod_leyes = '26')";
			//$Consulta.= " and t2.valor <> 0 ";
			$Consulta.= " order by cod_leyes ";
			$Resp2 = mysqli_query($link, $Consulta);	
			$NroSA = "";					
			$Ley1 = 0;
			$Ley2 = 0;
			while ($Fila2 = mysqli_fetch_array($Resp2))
			{								
				$NroSA = $Fila2["nro_solicitud"];
				switch ($Fila2["cod_leyes"])
				{
					case "26":
						$Ley1 = $Fila2["valor"];
						break;
					case "48":
						$Ley2 = $Fila2["valor"];
						break;
				}
			}
			if ($NroSA=="")
				echo "<td align='center' bgcolor='#FFFF66'>&nbsp;</td> \n";
			else
				echo "<td align='center' bgcolor='#FFFF66'><a href=\"JavaScript:Historial(".$NroSA.")\">".$NroSA."</a></td> \n";
			echo "<td align='right' bgcolor='#FFFF66'>".number_format($Ley1,0,",",".")."</td> \n";
			echo "<td align='right' bgcolor='#FFFF66'>".number_format($Ley2,0,",",".")."</td> \n";
			if ($i==1)
			{
				echo "<td rowspan='".$rowSpan."' align='right'>".number_format($SubTotal,0,",",".")."</td> \n";
				echo "<td rowspan='".$rowSpan."' align='right' bgcolor='#FFCC99'>".number_format($PesoBarrido,0,",",".")."</td> \n";				
				echo "<td rowspan='".$rowSpan."' align='right' bgcolor='#FFCC99'>".number_format($SubTotal + $PesoBarrido,0,",",".")."</td> \n";				
			}
			echo "</tr>";
			$i++;
		}
		if (!$Entro)
		{
			echo "<td align='center' bgcolor='#FFFF66'>&nbsp;</td> \n";			
			echo "<td align='right' bgcolor='#FFFF66'>&nbsp;</td> \n";					
			echo "<td align='right' bgcolor='#FFFF66'>&nbsp;</td> \n";
			echo "<td align='center' bgcolor='#FFFF66'>&nbsp;</td> \n";			
			echo "<td align='right' bgcolor='#FFFF66'>&nbsp;</td> \n";					
			echo "<td rowspan='".$rowSpan."' align='right'>".number_format($SubTotal,0,",",".")."</td> \n";
			echo "<td rowspan='".$rowSpan."' align='right' bgcolor='#FFCC99'>".number_format($PesoBarrido,0,",",".")."</td> \n";				
			echo "<td rowspan='".$rowSpan."' align='right' bgcolor='#FFCC99'>".number_format($SubTotal + $PesoBarrido,0,",",".")."</td> \n";				
			echo "</tr>";	
		}
		$FechaAux = date("Y-m-d", mktime(0,0,0,substr($FechaAux,5,2),substr($FechaAux,8,2) + 1,substr($FechaAux,0,4)));
	}
?>
    <tr> 
      <td><strong>TOTAL</strong></td>
      <td align="right"><?php echo number_format($TotalGuillotina,0,",","."); ?></td>
      <td align="right"><?php echo number_format($TotalLaminas,0,",","."); ?></td>      
      <td align="right" bgcolor="#FFFF66">&nbsp;</td>
	  <td align="right" bgcolor="#FFFF66"><?php echo number_format($TotalOrejas,0,",","."); ?></td>
      <td align="right" bgcolor="#FFFF66">&nbsp;</td>
      <td align="right" bgcolor="#FFFF66">&nbsp;</td>
	  <td align="right" bgcolor="#FFFF66">&nbsp;</td>
      <td align="right"><?php echo number_format($Total,0,",","."); ?></td>
      <td align="right" bgcolor="#FFCC99"><?php echo number_format($TotalBarrido,0,",","."); ?></td>
      <td align="right" bgcolor="#FFCC99"><?php echo number_format(($Total + $TotalBarrido),0,",","."); ?></td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
    //function RescataPeso($ProdCons, $SubProdCons, $FechaCons, $Peso, $link)
	function RescataPeso($ProdCons, $SubProdCons, $FechaCons, $Peso, $SA, $Ley_S, $Ley_O, $link)
	{
		//PESO DEL PRODUCTO-SUBPRODUCTO						
		$Consulta = "SELECT cod_producto, cod_subproducto, sum(peso_produccion) as peso ";
		$Consulta.= " FROM sec_web.produccion_catodo";
		$Consulta.= " WHERE cod_producto = '".$ProdCons."'";
		$Consulta.= " AND cod_subproducto = '".$SubProdCons."'";
		$Consulta.= " AND fecha_produccion between '".$FechaCons."' and '".$FechaCons."'";				
		$Consulta.= " GROUP BY cod_producto, cod_subproducto ";
		$Respuesta = mysqli_query($link, $Consulta);
		$Peso = 0;
		if ($Fila = mysqli_fetch_array($Respuesta))
		{
			$Peso = $Fila["peso"];		
		}
	}

?>
