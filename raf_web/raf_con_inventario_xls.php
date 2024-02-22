<?
 header("Content-Type:application/vnd.ms-excel");
 header("Expires:0");
 header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
include("../principal/conectar_raf_web.php");

$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			

if(strlen($Mes) == 1)
	$Mes = '0'.$Mes;

if(strlen($MesTer) == 1)
	$MesTer = '0'.$MesTer;

if(strlen($Dia) == 1)
	$Dia = '0'.$Dia;

if(strlen($DiaTer) == 1)
	$DiaTer = '0'.$DiaTer;
	
$Fecha_Ini = $Ano.'-'.$Mes.'-'.$Dia;

$Fecha_Ter = $AnoTer.'-'.$MesTer.'-'.$DiaTer;


?>
<html>
<head>
<title>Sistema RAF</title>


</head>

<body >
<form name="FrmPrincipal" method="post" action="">
  <table width="476" align="center" border="1" cellspacing="0" cellpadding="0" class="TablaDetalle">
    <tr> 
      <td width="471" align="center">INVENTARIO FISICO NAVE DE HORNOS </td>
	</tr>	
  </table>
  <br>
  <table width="320" align="center" border="1" cellspacing="0" cellpadding="0" class="TablaDetalle">
    <tr> 
      <td>Mes: <? echo ucwords(strtolower($Fecha_Ini))?> Al <? echo ucwords(strtolower($Fecha_Ter))?></td>
    </tr>
  </table>
  <br>
  <table width="750" border="1" cellspacing="0" cellpadding="0" class="TablaDetalle" align="center">
    <tr class="ColorTabla01"> 
      <td width="135" rowspan="2" align="center">Productos</td>
      <td width="138" rowspan="2" align="center">Stock Ini</td>
      <td width="160" rowspan="2" align="center">Traspasos</td>
      <td width="166" rowspan="2" align="center">Beneficios</td>
      <td colspan="2" align="center">Stock Final </td>
    </tr>
    <tr class="ColorTabla01">
      <td align="center">Unid</td>
      <td align="center">Peso</td>
    </tr>    
    <?
		$FechaAux = date("Y-m-d", mktime(0,0,0,$Mes-1,1,$Ano));
		$MesAnt = intval(substr($FechaAux,5,2));
		$AnoAnt = intval(substr($FechaAux,0,4));		
		$FechaT = date('Y-m-d', mktime(1,0,0,intval(substr($Fecha_Ter, 5, 2)) ,intval(substr($Fecha_Ter, 8, 2)) + 1,intval(substr($Fecha_Ter, 0, 4))));
		$FechaHI = $Fecha_Ini." 08:00:00";
		$FechaHT = $FechaT." 07:59:59";

		echo "<tr>";
		echo "<td align='left' class='Detalle02'>Restos de Anodos</td>";
		//STOCK INICIAL
		$Consulta = "SELECT * FROM raf_web.stock ";
		$Consulta.= " WHERE ano = '".$AnoAnt."' AND mes = '".$MesAnt."' ";
		$Consulta.= " AND cod_producto = '19'";
		$rs = mysql_query($Consulta);
		while($Fila = mysql_fetch_array($rs))
		{
			$Valores = $Valores."Gr. ".str_pad($Fila["hornada"],2,"0",STR_PAD_LEFT)." Peso ".number_format($Fila["peso"],0,",",".")."<br>";	  			  
			$AcumPeso = $AcumPeso + $Fila["peso"]; 
			$AcumUnid = $AcumUnid + $Fila["unidades"]; 	 	
		}
		$StIniRestos = $AcumPeso;
		$StIniRestosUnid = $AcumUnid;
		echo "<td align='left'>".$Valores."<b>Total: ".number_format($AcumPeso,0,",",".")."</b></td>";
	   
		$Valores = "";
		$AcumPeso = "";
		$AcumUnid = "";
		$Consulta = "SELECT distinct campo2 FROM sea_web.movimientos";
		$Consulta.= " WHERE tipo_movimiento = 4 AND cod_producto = 19";
		$Consulta.= " AND (fecha_movimiento BETWEEN '".$Fecha_Ini."' AND '".$FechaT."') and ";
		$Consulta.=" (hora between '".$FechaHI."' and '".$FechaHT."')";
		$rs = mysql_query($Consulta);
		while($Fila = mysql_fetch_array($rs))
		{
			$Consulta = "SELECT sum(peso) as peso, sum(unidades) as unidades FROM sea_web.movimientos";
			$Consulta.= " WHERE tipo_movimiento = 4 AND cod_producto = 19";
			$Consulta.= " AND campo2 = '$Fila[campo2]'";
			$Consulta.= " AND (fecha_movimiento BETWEEN '".$Fecha_Ini."' AND '".$FechaT."') and ";
			$Consulta.=" (hora between '".$FechaHI."' and '".$FechaHT."')";
			$resp = mysql_query($Consulta);
			$row = mysql_fetch_array($resp);
			$Valores = $Valores."Gr. ".str_pad($Fila[campo2],2,"0",STR_PAD_LEFT)." Peso ".number_format($row["peso"],0,",",".")."<br>";	  	
			$AcumPeso = $AcumPeso + $row["peso"]; 	
			$AcumUnid = $AcumUnid + $row["unidades"]; 
		} 
		echo "<td align='left'>".$Valores."<b>Total: ".number_format($AcumPeso,0,",",".")."</b></td>";
		$TraspRestos = $AcumPeso;
		$TraspRestosUnid = $AcumUnid;					

		$Consulta = "SELECT distinct hornada FROM raf_web.det_carga";
		$Consulta.= " WHERE cod_producto = 19";
		$Consulta.= " AND fecha BETWEEN '".$FechaHI."' AND '".$FechaHT."'";
		$rs = mysql_query($Consulta);
		$Valores = "";
		$AcumPeso = "";
		$AcumUnid = "";
		while($Fila = mysql_fetch_array($rs))
		{
			$Consulta = "SELECT SUM(peso) as peso, sum(unidades) as unidades FROM raf_web.det_carga";
			$Consulta.= " WHERE cod_producto = 19";
			$Consulta.= " AND hornada = '".$Fila["hornada"]."'";
			$resp = mysql_query($Consulta);
			$row = mysql_fetch_array($resp);
			$Valores = $Valores."Hor. ".substr($Fila["hornada"],6,4)." Peso ".number_format($row["peso"],0,",",".")."<br>";	  	
			$AcumPeso = $AcumPeso + $row["peso"]; 	
			$AcumUnid = $AcumUnid + $row["unidades"]; 
		}	
		$BenefRestos = $AcumPeso;
		$BenefRestosUnid = $AcumUnid;
		
		echo "<td align='left'>".$Valores."<b>Total: ".number_format($AcumPeso,0,",",".")."</b></td>";
		$TotalRestos = (StIniRestos + $TraspRestos) - $BenefRestos;	
		$TotalRestosUnid = (StIniRestosUnid + $TraspRestosUnid) - $BenefRestosUnid;	
		echo "<td align='center' class='Detalle02'>".number_format($TotalRestosUnid,0,",",".")."</td>";
		echo "<td align='center' class='Detalle02'>".number_format($TotalRestos,0,",",".")."</td>";
		echo "</tr>";
		
    ?>
	<? //BLISTER
		$Consulta = "SELECT distinct cod_producto, cod_subproducto FROM sea_web.movimientos WHERE tipo_movimiento = 4 AND cod_producto = 16";
		$rs = mysql_query($Consulta);
		while($Fila = mysql_fetch_array($rs))
		{			 
			$Consulta = "SELECT abreviatura FROM proyecto_modernizacion.subproducto"; 
			$Consulta.= " WHERE cod_producto = ".$Fila["cod_producto"];
			$Consulta.= " AND cod_subproducto = ".$Fila[cod_subproducto];
			$resp = mysql_query($Consulta);
			$Fil = mysql_fetch_array($resp);
			echo "<tr>";
			echo "<td align='left' class='Detalle01'>".$Fil["abreviatura"]."</td>";
			//Stock Inicial
			$Consulta = "SELECT ifnull(peso,0) as peso, ifnull(unidades,0) as unidades FROM raf_web.stock ";
			$Consulta.= " WHERE ano = '".$AnoAnt."' AND mes = '".$MesAnt."' ";
			$Consulta.= " AND cod_producto = '".$Fila["cod_producto"]."' AND cod_subproducto = '".$Fila[cod_subproducto]."'";
			$resp = mysql_query($Consulta);
			$row = mysql_fetch_array($resp);
			$StIniBlister = $row["peso"];	
			$StIniBlister2 = $StIniBlister2 + $row["peso"];
			$StIniBlisterUnid = $row["unidades"];	
			$StIniBlisterUnid2 = $StIniBlisterUnid2 + $row["unidades"];		
			echo "<td align='right'>".number_format($StIniBlister,0,",",".")."</td>";
			//traspaso
			$Consulta = "SELECT SUM(peso) as peso, SUM(unidades) as unidades FROM sea_web.movimientos";
			$Consulta.= " WHERE tipo_movimiento = 4 AND cod_producto = $Fila["cod_producto"] AND cod_subproducto = $Fila[cod_subproducto]";
			$Consulta.= " AND (fecha_movimiento BETWEEN '".$Fecha_Ini."' AND '".$FechaT."') and ";
			$Consulta.=" (hora between '".$FechaHI."' and '".$FechaHT."')";
			$resp = mysql_query($Consulta);
			$row = mysql_fetch_array($resp);
			$TraspBlister = $row["peso"];	
			$TraspBlister2 = $TraspBlister2 + $row["peso"];	
			$TraspBlisterUnid = $row["unidades"];	
			$TraspBlisterUnid2 = $TraspBlisterUnid2 + $row["unidades"];
			echo "<td align='right'>".number_format($row["peso"],0,",",".")."</td>";
			
			//Benef
			$Consulta = "SELECT SUM(peso) as peso, sum(unidades) as unidades FROM raf_web.det_carga";
			$Consulta.= " WHERE cod_producto = $Fila["cod_producto"] AND cod_subproducto = $Fila[cod_subproducto]";
			$Consulta.= " AND fecha BETWEEN '".$FechaHI."' AND '".$FechaHT."'";
			$resp = mysql_query($Consulta);
			$row = mysql_fetch_array($resp);
			$BenefBlister = $row["peso"];	
			$BenefBlister2 = $BenefBlister2 + $row["peso"];	
			$BenefBlisterUnid = $row["unidades"];	
			$BenefBlisterUnid2 = $BenefBlisterUnid2 + $row["unidades"];
			echo "<td align='right'>".number_format($row["peso"],0,",",".")."</td>";
			
			$TotalBlister = $StIniBlister + $TraspBlister - $BenefBlister;
			$TotalBlister2 = $TotalBlister2 + $TotalBlister;
			$TotalBlisterUnid = $StIniBlisterUnid + $TraspBlisterUnid - $BenefBlisterUnid;
			$TotalBlisterUnid2 = $TotalBlisterUnid2 + $TotalBlisterUnid;
			echo "<td align='right' class='Detalle02'>".number_format($TotalBlisterUnid,0,",",".")."</td>";
			echo "<td align='right' class='Detalle02'>".number_format($TotalBlister,0,",",".")."</td>";
			echo "</tr>";
		}		
	?>

	<? //ANODOS
		$Consulta = "SELECT distinct cod_producto, cod_subproducto FROM sea_web.movimientos WHERE tipo_movimiento = 4 AND cod_producto = 17";
		$rs = mysql_query($Consulta);
		while($Fila = mysql_fetch_array($rs))
		{
			$Consulta = "SELECT abreviatura FROM proyecto_modernizacion.subproducto"; 
			$Consulta.= " WHERE cod_producto = ".$Fila["cod_producto"];
			$Consulta.= " AND cod_subproducto = ".$Fila[cod_subproducto];
			$resp = mysql_query($Consulta);
			$Fil = mysql_fetch_array($resp);
			echo "<tr>";
			echo "<td align='left' class='Detalle01'>".$Fil["abreviatura"]."</td>";
			
			//Stock Inicial
			$Consulta = "SELECT ifnull(peso,0) as peso, ifnull(unidades,0) as unidades FROM raf_web.stock ";
			$Consulta.= " WHERE ano = '".$AnoAnt."' AND mes = '".$MesAnt."' ";
			$Consulta.= " AND cod_producto = '".$Fila["cod_producto"]."' AND cod_subproducto = '".$Fila[cod_subproducto]."'";
			$resp = mysql_query($Consulta);
			$row = mysql_fetch_array($resp);
			$StIniAnod = $row["peso"];	
			$StIniAnod2 = $StIniAnod2 + $row["peso"];	
			$StIniAnodUnid = $row["unidades"];	
			$StIniAnodUnid2 = $StIniAnodUnid2 + $row[Unid];	
			echo "<td align='right'>".number_format($row["peso"],0,",",".")."</td>";
			//traspaso
			$Consulta = "SELECT SUM(peso) as peso, sum(unidades) as unidades FROM sea_web.movimientos";
			$Consulta.= " WHERE tipo_movimiento = 4 AND cod_producto = $Fila["cod_producto"] AND cod_subproducto = $Fila[cod_subproducto]";
			$Consulta.= " AND (fecha_movimiento BETWEEN '".$Fecha_Ini."' AND '".$FechaT."') and ";
			$Consulta.=" (hora between '".$FechaHI."' and  '".$FechaHT."')";
			$resp = mysql_query($Consulta);
			$row = mysql_fetch_array($resp);
			$TraspAnod = $row["peso"];	
			$TraspAnod2 = $TraspAnod2 + $row["peso"];	
			$TraspAnodUnid = $row["unidades"];	
			$TraspAnodUnid2 = $TraspAnodUnid2 + $row["unidades"];
			echo "<td align='right'>".number_format($row["peso"],0,",",".")."</td>";
			
			//Benef
			$Consulta = "SELECT SUM(peso) as peso, sum(unidades) as unidades FROM raf_web.det_carga";
			$Consulta.= " WHERE cod_producto = $Fila["cod_producto"] AND cod_subproducto = $Fila[cod_subproducto]";
			$Consulta.= " AND fecha BETWEEN '".$FechaHI."' AND '".$FechaHT."'";
			$resp = mysql_query($Consulta);
			$row = mysql_fetch_array($resp);
			$BenefAnod = $row["peso"];	
			$BenefAnod2 = $BenefAnod2 + $row["peso"];	
			$BenefAnodUnid = $row["unidades"];	
			$BenefAnodUnid2 = $BenefAnodUnid2 + $row["unidades"];	
			echo "<td align='right'>".number_format($row["peso"],0,",",".")."</td>";
			
			$TotalAnod = $StIniAnod + $TraspAnod - $BenefAnod;	
			$TotalAnod2 = $TotalAnod2 + $TotalAnod;	
			$TotalAnodUnid = $StIniAnodUnid + $TraspAnodUnid - $BenefAnodUnid;	
			$TotalAnodUnid2 = $TotalAnodUnid2 + $TotalAnodUnid;	
			echo "<td align='right' class='Detalle02'>".number_format($TotalAnodUnid,0,",",".")."</td>";
			echo "<td align='right' class='Detalle02'>".number_format($TotalAnod,0,",",".")."</td>";
			echo "</tr>";
		}		
	?>
	
	<? //CIRCULANTES
		$Consulta = "SELECT distinct cod_producto, cod_subproducto FROM raf_web.det_carga WHERE cod_producto = 42";
		$rs = mysql_query($Consulta);
		while($Fila = mysql_fetch_array($rs))
		{
			$Consulta = "SELECT abreviatura FROM proyecto_modernizacion.subproducto"; 
			$Consulta.= " WHERE cod_producto = ".$Fila["cod_producto"];
			$Consulta.= " AND cod_subproducto = ".$Fila[cod_subproducto];
			$resp = mysql_query($Consulta);
			$Fil = mysql_fetch_array($resp);
			echo "<tr>";
			echo "<td align='left' class='Detalle02'>".$Fil["abreviatura"]."</td>";
			
			//Stock Inicial
			$Consulta = "SELECT ifnull(peso,0) as peso, ifnull(unidades,0) as unidades FROM raf_web.stock ";
			$Consulta.= " WHERE ano = '".$AnoAnt."' AND mes = '".$MesAnt."' ";
			$Consulta.= " AND cod_producto = '".$Fila["cod_producto"]."' AND cod_subproducto = '".$Fila[cod_subproducto]."'";
			$resp = mysql_query($Consulta);
			$row = mysql_fetch_array($resp);
			$StIniCirc = $row["peso"];	
			$StIniCirc2 = $StIniCirc2 + $row["peso"];
			$StIniCircUnid = $row["unidades"];	
			$StIniCircUnid2 = $StIniCircUnid2 + $row["unidades"];	
			echo "<td align='right'>".number_format($row["peso"],0,",",".")."</td>";
			
			//traspaso
			$Consulta = "SELECT SUM(peso) as peso, sum(unidades) as unidades FROM raf_web.det_carga";
			$Consulta.= " WHERE cod_producto = ".$Fila["cod_producto"]." AND cod_subproducto = ".$Fila[cod_subproducto]." ";
			$Consulta.= " AND fecha BETWEEN '".$FechaHI."' AND '".$FechaHT."'";
			$resp = mysql_query($Consulta);
			$row = mysql_fetch_array($resp);
			$TraspCirc = $row["peso"];		
			$TraspCirc2 = $TraspCirc2 + $row["peso"];	
			$TraspCircUnid = $row["unidades"];		
			$TraspCircUnid2 = $TraspCircUnid2 + $row["unidades"];		
			echo "<td align='right'>".number_format($row["peso"],0,",",".")."</td>";
			
			//Benef
			$Consulta = "SELECT SUM(peso) as peso, sum(unidades) as unidades FROM raf_web.det_carga";
			$Consulta.= " WHERE cod_producto = ".$Fila["cod_producto"]." AND cod_subproducto = ".$Fila[cod_subproducto]." ";
			$Consulta.= " AND fecha BETWEEN '".$FechaHI."' AND '".$FechaHT."'";
			$resp = mysql_query($Consulta);
			$row = mysql_fetch_array($resp);
			$BenefCirc = $row["peso"];		
			$BenefCirc2 = $BenefCirc2 + $row["peso"];		
			$BenefCircUnid = $row["unidades"];		
			$BenefCircUnid2 = $BenefCircUnid2 + $row["unidades"];	
			echo "<td align='right'>".number_format($row["peso"],0,",",".")."</td>";
			
			$TotalCirc = ($StIniCirc + $TraspCirc) - $BenefCirc;
			$TotalCirc2 = $TotalCirc2 + $TotalCirc;
			$TotalCircUnid = ($StIniCircUnid + $TraspCircUnid) - $BenefCircUnid;
			$TotalCircUnid2 = $TotalCircUnid2 + $TotalCircUnid;
			echo "<td align='right' class='Detalle02'>".number_format($TotalCircUnid,0,",",".")."</td>";
			echo "<td align='right' class='Detalle02'>".number_format($TotalCirc,0,",",".")."</td>";
			echo "</tr>";
		}		
	?>
	<? //BLISTER LIQUIDO
		$Consulta = "SELECT distinct cod_producto, cod_subproducto FROM raf_web.det_carga";
		$Consulta.= " WHERE cod_producto = 16 AND cod_subproducto IN('40','41','42')";
		$rs = mysql_query($Consulta);
		while($Fila = mysql_fetch_array($rs))
		{
			$Consulta = "SELECT abreviatura FROM proyecto_modernizacion.subproducto"; 
			$Consulta.= " WHERE cod_producto = ".$Fila["cod_producto"];
			$Consulta.= " AND cod_subproducto = ".$Fila[cod_subproducto];
			$resp = mysql_query($Consulta);
			$Fil = mysql_fetch_array($resp);
			echo "<tr>";
			echo "<td align='left' class='Detalle02'>".$Fil["abreviatura"]."</td>";
			
			//Stock Inicial
			$Consulta = "SELECT ifnull(peso,0) as peso, ifnull(unidades,0) as unidades FROM raf_web.stock ";
			$Consulta.= " WHERE ano = '".$AnoAnt."' AND mes = '".$MesAnt."' ";
			$Consulta.= " AND cod_producto = '".$Fila["cod_producto"]."' AND cod_subproducto = '".$Fila[cod_subproducto]."'";
			$resp = mysql_query($Consulta);
			$row = mysql_fetch_array($resp);
			$StIniLiquid = $row["peso"];	
			$StIniLiquid2 = $StIniLiquid2 + $row["peso"];	
			$StIniLiquidUnid = $row["unidades"];	
			$StIniLiquidUnid2 = $StIniLiquidUnid2 + $row["unidades"];
			echo "<td align='right'>".number_format($row["peso"],0,",",".")."</td>";
			
			//traspaso
			$Consulta = "SELECT SUM(peso) as peso, sum(unidades) as unidades FROM raf_web.det_carga";
			$Consulta.= " WHERE cod_producto = ".$Fila["cod_producto"]." AND cod_subproducto = ".$Fila[cod_subproducto]." ";
			$Consulta.= " AND fecha BETWEEN '".$FechaHI."' AND '".$FechaHT."'";
			$resp = mysql_query($Consulta);
			$row = mysql_fetch_array($resp);
			$TraspLiquid = $row["peso"];	
			$TraspLiquid2 = $TraspLiquid2 + $row["peso"];	
			$TraspLiquidUnid = $row["unidades"];	
			$TraspLiquidUnid2 = $TraspLiquidUnid2 + $row["unidades"];
			echo "<td align='right'>".number_format($row["peso"],0,",",".")."</td>";
			
			//Benef
			$Consulta = "SELECT SUM(peso) as peso, sum(unidades) as unidades FROM raf_web.det_carga";
			$Consulta.= " WHERE cod_producto = ".$Fila["cod_producto"]." AND cod_subproducto = ".$Fila[cod_subproducto]." ";
			$Consulta.= " AND fecha BETWEEN '".$FechaHI."' AND '".$FechaHT."'";
			$resp = mysql_query($Consulta);
			$row = mysql_fetch_array($resp);
			$BenefLiquid = $row["peso"];	
			$BenefLiquid2 = $BenefLiquid2 + $row["peso"];	
			$BenefLiquidUnid = $row["unidades"];	
			$BenefLiquidUnid2 = $BenefLiquidUnid2 + $row["unidades"];	
			echo "<td align='right'>".number_format($row["peso"],0,",",".")."</td>";
			
			$TotalLiquid = $StIniLiquid + $TraspLiquid - $BenefLiquid;	
			$TotalLiquid2 = $TotalLiquid2 + $TotalLiquid;
			$TotalLiquidUnid = $StIniLiquidUnid + $TraspLiquidUnid - $BenefLiquidUnid;	
			$TotalLiquidUnid2 = $TotalLiquidUnid2 + $TotalLiquidUnid;
			echo "<td align='right' class='Detalle02'>".number_format($TotalLiquidUnid,0,",",".")."</td>";	
			echo "<td align='right' class='Detalle02'>".number_format($TotalLiquid,0,",",".")."</td>";
			echo "</tr>";
		}		
	?>
	<? //CATODOS
		$Consulta = "SELECT distinct cod_producto, cod_subproducto FROM sea_web.movimientos WHERE tipo_movimiento = 4 AND cod_producto = 18";
		$rs = mysql_query($Consulta);
		while($Fila = mysql_fetch_array($rs))
		{
			$Consulta = "SELECT abreviatura FROM proyecto_modernizacion.subproducto"; 
			$Consulta.= " WHERE cod_producto = ".$Fila["cod_producto"];
			$Consulta.= " AND cod_subproducto = ".$Fila[cod_subproducto];
			$resp = mysql_query($Consulta);
			$Fil = mysql_fetch_array($resp);
			echo "<tr>";
			echo "<td align='left'>".$Fil["abreviatura"]."</td>";
			
			//Stock Inicial
			$Consulta = "SELECT ifnull(peso,0) as peso, ifnull(unidades,0) as unidades FROM raf_web.stock ";
			$Consulta.= " WHERE ano = '".$AnoAnt."' AND mes = '".$MesAnt."' ";
			$Consulta.= " AND cod_producto = '".$Fila["cod_producto"]."' AND cod_subproducto = '".$Fila[cod_subproducto]."'";
			$resp = mysql_query($Consulta);
			$row = mysql_fetch_array($resp);
			$StIniCat = $row["peso"];	
			$StIniCat2 = $StIniCat2 + $row["peso"];	
			$StIniCatUnid = $row["unidades"];	
			$StIniCatUnid2 = $StIniCatUnid2 + $row["unidades"];	
			echo "<td align='right'>".number_format($row["peso"],0,",",".")."</td>";
			
			//traspaso
			$Consulta = "SELECT SUM(peso) as peso, sum(unidades) as unidades FROM sea_web.movimientos";
			$Consulta.= " WHERE tipo_movimiento = 4 AND cod_producto = $Fila["cod_producto"] AND cod_subproducto = $Fila[cod_subproducto]";
			$Consulta.= " AND (fecha_movimiento BETWEEN '".$Fecha_Ini."' AND '".$FechaT."') and ";
			$Consulta.=" (hora between '".$FechaHI."' and '".$FechaHT."')";
			$resp = mysql_query($Consulta);
			$row = mysql_fetch_array($resp);
			$TraspCat = $row["peso"];	
			$TraspCat2 = $TraspCat2 + $row["peso"];	
			$TraspCatUnid = $row["unidades"];	
			$TraspCatUnid2 = $TraspCatUnid2 + $row["unidades"];
			echo "<td align='right'>".number_format($row["peso"],0,",",".")."</td>";
			
			//Benef
			$Consulta = "SELECT SUM(peso) as peso, sum(unidades) as unidades FROM raf_web.det_carga";
			$Consulta.= " WHERE cod_producto = $Fila["cod_producto"] AND cod_subproducto = $Fila[cod_subproducto]";
			$Consulta.= " AND fecha BETWEEN '".$FechaHI."' AND '".$FechaHT."'";
			$resp = mysql_query($Consulta);
			$row = mysql_fetch_array($resp);
			$BenefCat = $row["peso"];	
			$BenefCat2 = $BenefCat2 + $row["peso"];	
			$BenefCatUnid = $row["unidades"];	
			$BenefCatUnid2 = $BenefCatUnid2 + $row["unidades"];	
			echo "<td align='right'>".number_format($row["peso"],0,",",".")."</td>";
			
			$TotalCat = $StIniCat + $TraspCat - $BenefCat;
			$TotalCat2 = $TotalCat2 + $TotalCat;
			$TotalCatUnid = $StIniCatUnid + $TraspCatUnid - $BenefCatUnid;
			$TotalCatUnid2 = $TotalCatUnid2 + $TotalCatUnid;
			echo "<td align='right' class='Detalle02'>".number_format($TotalCatUnid,0,",",".")."</td>";
			echo "<td align='right' class='Detalle02'>".number_format($TotalCat,0,",",".")."</td>";
			echo "</tr>";
		}		

		$AcumIni = $StIniCat2 + $StIniLiquid2 + $StIniCirc2 + $StIniAnod2 + $StIniBlister2 + $StIniRestos; 
		$AcumTrasp = $TraspCat2 + $TraspLiquid2 + $TraspCirc2 + $TraspAnod2 + $TraspBlister2 + $TraspRestos; 
		$AcumBenef = $BenefCat2 + $BenefLiquid2 + $BenefCirc2 + $BenefAnod2 + $BenefBlister2 + $BenefRestos;
		$AcumTer = $TotalCat2 + $TotalLiquid2 + $TotalCirc2 + $TotalAnod2 + $TotalBlister2 + $TotalRestos;
		
		$AcumTerUnid = $TotalCatUnid2 + $TotalLiquidUnid2 + $TotalCircUnid2 + $TotalAnodUnid2 + $TotalBlisterUnid2 + $TotalRestosUnid;
	?>

    <tr class="ColorTabla02"> 
      <td align="left"><strong>TOTAL</strong></td>
      <td align="right"><? echo number_format($AcumIni,0,",","."); ?></td>
      <td align="right"><? echo number_format($AcumTrasp,0,",","."); ?></td>
      <td align="right"><? echo number_format($AcumBenef,0,",","."); ?></td>
      <td width="54" align="right" class="Detalle02"><? echo number_format($AcumTerUnid,0,",","."); ?></td>
      <td width="82" align="right" class="Detalle02"><? echo number_format($AcumTer,0,",","."); ?></td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>

</body>
</html>
