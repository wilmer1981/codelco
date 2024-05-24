<?php
	include("../principal/conectar_pmn_web.php");

	$NumLote = isset($_REQUEST["NumLote"])?$_REQUEST["NumLote"]:"";
	$Producto  = isset($_REQUEST["Producto"])?$_REQUEST["Producto"]:"";
	$SubProducto  = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";

	$ArrLeyes = array();
	if ($Producto=="25" && $SubProducto=="1")//RESCATA BAD
	{		
		//CONSULTA LEYES
		$Consulta = " select DISTINCT  t3.cod_leyes, t4.abreviatura ";
		$Consulta.= " FROM pmn_web.pmn_pesa_bad_cabecera t1  ";
		$Consulta.= " INNER JOIN cal_web.solicitud_analisis t2 on t1.lote=t2.id_muestra ";
		$Consulta.= " INNER JOIN cal_web.leyes_por_solicitud t3 ";
		$Consulta.= " on t2.nro_solicitud = t3.nro_solicitud and t2.recargo=t3.recargo ";
		$Consulta.= " INNER JOIN proyecto_modernizacion.leyes t4 on t3.cod_leyes=t4.cod_leyes ";
		$Consulta.= " WHERE t2.cod_producto = '25' AND t2.cod_subproducto = '1'";
		$Consulta.= " and t1.lote='".$NumLote."'";
		$Consulta.= " ORDER BY t3.cod_leyes ";
		$Resp2 = mysqli_query($link, $Consulta);
		//echo $Consulta;
		while ($Fila2 = mysqli_fetch_array($Resp2))
		{
			$ArrLeyes[$Fila2["cod_leyes"]]["cod_leyes"] = $Fila2["cod_leyes"];
			$ArrLeyes[$Fila2["cod_leyes"]]["valor"] = "";
			$ArrLeyes[$Fila2["cod_leyes"]]["cod_unidad"] = "";
			$ArrLeyes[$Fila2["cod_leyes"]]["nom_leyes"] = $Fila2["abreviatura"];
		}
	}

	if ($Producto=="34" && $SubProducto=="2")//RESCATA ORO
	{		
		//CONSULTA LEYES
		$Consulta = " select DISTINCT  t3.cod_leyes, t4.abreviatura ";
		$Consulta.= " FROM pmn_web.carga_fusion_oro t1  ";
		$Consulta.= " INNER JOIN cal_web.solicitud_analisis t2 on (t1.num_electrolisis=t2.id_muestra or t1.num_barra=t2.id_muestra) ";
		$Consulta.= " INNER JOIN cal_web.leyes_por_solicitud t3 ";
		$Consulta.= " on t2.nro_solicitud = t3.nro_solicitud and t2.recargo=t3.recargo ";
		$Consulta.= " INNER JOIN proyecto_modernizacion.leyes t4 on t3.cod_leyes=t4.cod_leyes ";
		$Consulta.= " WHERE t2.cod_producto = '34' AND t2.cod_subproducto = '2'";
		$Consulta.= " and t1.num_barra='".$NumLote."'";
		$Consulta.= " ORDER BY t3.cod_leyes ";
		$Resp2 = mysqli_query($link, $Consulta);
		//echo $Consulta;
		while ($Fila2 = mysqli_fetch_array($Resp2))
		{
			$ArrLeyes[$Fila2["cod_leyes"]]["cod_leyes"] = $Fila2["cod_leyes"];
			$ArrLeyes[$Fila2["cod_leyes"]]["valor"] = "";
			$ArrLeyes[$Fila2["cod_leyes"]]["cod_unidad"] = "";
			$ArrLeyes[$Fila2["cod_leyes"]]["nom_leyes"] = $Fila2["abreviatura"];
		}
	}
	if ($Producto=="29" && $SubProducto=="4")//EMBARQUE PLATA
	{			
		$Datos=explode("~~",$NumLote);
		$NumLote = $Datos[0];
		$NumActa = $Datos[1];
		//CONSULTO LEYES
		$Consulta = " select DISTINCT  t5.cod_leyes, t6.abreviatura ";
		$Consulta.= " FROM pmn_web.embarque_plata AS t1";
		$Consulta.= " LEFT JOIN pmn_web.detalle_embarque_plata AS t2";
		$Consulta.= " ON t1.num_acta = t2.num_acta AND YEAR(t1.fecha) = t2.ano AND MONTH(t1.fecha) = t2.mes";
		$Consulta.= " LEFT JOIN cal_web.solicitud_analisis AS t3";
		$Consulta.= " ON t2.num_electrolisis = t3.id_muestra AND t3.cod_producto = '29' AND t3.cod_subproducto = '4'";
		$Consulta.= " AND t3.cod_periodo = '1' AND t3.agrupacion = '5'";
		$Consulta.= " LEFT JOIN cal_web.leyes_por_solicitud AS t5";
		$Consulta.= " ON t3.nro_solicitud = t5.nro_solicitud AND t3.recargo = t5.recargo";
		$Consulta.= " INNER JOIN proyecto_modernizacion.leyes t6 ON t5.cod_leyes=t6.cod_leyes";
		$Consulta.= " WHERE YEAR(t1.fecha) = '".$AnoAux."'";// AND MONTH(t1.fecha) = '".$MesAux."'";
		$Consulta.= " AND t2.num_electrolisis = '".$NumLote."'";
		$Consulta.= " AND t1.num_acta = '".$NumActa."'";
		$Consulta.= " ORDER BY t2.num_electrolisis ";
		$Resp2 = mysqli_query($link, $Consulta);
		//echo $Consulta;
		while ($Fila2 = mysqli_fetch_array($Resp2))
		{			
			$ArrLeyes[$Fila2["cod_leyes"]]["cod_leyes"] = $Fila2["cod_leyes"];
			$ArrLeyes[$Fila2["cod_leyes"]]["valor"] = "";
			$ArrLeyes[$Fila2["cod_leyes"]]["cod_unidad"] = "";
			$ArrLeyes[$Fila2["cod_leyes"]]["nom_leyes"] = $Fila2["abreviatura"];
		}			
	}
	
	if (($Producto=="31" && $SubProducto=="1") || ($Producto=="47" && $SubProducto=="1") || ($Producto=="28" && $SubProducto=="1") || ($Producto=="28" && $SubProducto=="6") ||
	($Producto=="33" && $SubProducto=="2"))
	{
		//PALADIO-PLATINO, ESCORIA, SELENI, TELURO
		//TABLA PRODUCCION_SUBPRODUCTOS
		//CONSULTA LEYES


		$Consulta = " select distinct t3.cod_leyes, t4.abreviatura ";
		$Consulta.= " FROM pmn_web.produccion_subproductos AS t1";
		$Consulta.= " INNER JOIN cal_web.solicitud_analisis AS t2";
		$Consulta.= " ON t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto and ";
		$Consulta.= " case when t1.cod_producto='31' and t1.cod_subproducto='1' ";
		$Consulta.= " then t2.id_muestra=t1.numero ";
		$Consulta.= " else t2.nro_solicitud=t1.id_analisis end ";
		 $Consulta.= " AND t2.cod_periodo = '1' AND (t2.recargo = '0' or t2.recargo = '' or t2.recargo='1')";
		//$Consulta.= " AND t2.cod_periodo = '1' AND  t2.recargo='1'";
		$Consulta.= " INNER JOIN cal_web.leyes_por_solicitud AS t3";
		$Consulta.= " ON t2.nro_solicitud = t3.nro_solicitud AND t2.recargo = t3.recargo ";
		$Consulta.= " INNER JOIN proyecto_modernizacion.leyes t4 on t3.cod_leyes=t4.cod_leyes ";
		$Consulta.= " WHERE t1.cod_producto = '".$Producto."' AND t1.cod_subproducto = '".$SubProducto."'";
		$Consulta.= " AND t1.fecha_venta BETWEEN '".$AnoAux."-".$MesAux."-01' AND '".$AnoAux."-".$MesAux."-31' ";
		$Consulta.= " AND t1.numero='".$NumLote."'";
		$Consulta.= " ORDER BY t3.cod_leyes";	
		//echo "cc".$Consulta;
		$Encontro=false;
		$Resp2 = mysqli_query($link, $Consulta);			
		while ($Fila2 = mysqli_fetch_array($Resp2))
		{
			$Encontro=true;
			$ArrLeyes[$Fila2["cod_leyes"]]["cod_leyes"] = $Fila2["cod_leyes"];
			$ArrLeyes[$Fila2["cod_leyes"]]["valor"] = "";
			$ArrLeyes[$Fila2["cod_leyes"]]["cod_unidad"] = "";
			$ArrLeyes[$Fila2["cod_leyes"]]["nom_leyes"] = $Fila2["abreviatura"];
		}
		//TABLA PRODUCTOS POR MOVIMIENTO
		if (!$Encontro)
		{
			$Consulta = "select * from pmn_web.productos_por_movimientos ";
			$Consulta.= " where fecha between '".$AnoAux."-".$MesAux."-01' and '".$AnoAux."-".$MesAux."-31'";
			$Consulta.= " and tipo_mov='4' and id not like '%aju%' and ";
			$Consulta.= " ((cod_producto='33' and cod_subproducto='2') or ";
			$Consulta.= " (cod_producto='31' and cod_subproducto='1') or ";
			$Consulta.= " (cod_producto='47' and cod_subproducto='1') or ";
			$Consulta.= " (cod_producto='28' and cod_subproducto='1') or ";
			$Consulta.= " (cod_producto='28' and cod_subproducto='6'))";
			$Consulta.= " order by lpad(cod_producto,3,'0'), lpad(cod_subproducto,3,'0')";
			$RespAux = mysqli_query($link, $Consulta);	
			while ($FilaAux = mysqli_fetch_array($RespAux))
			{
				$Consulta = " select t1.cod_leyes, t1.abreviatura ";
				$Consulta.= " FROM proyecto_modernizacion.leyes t1 where t1.cod_leyes in('02','04','05') ";
				$Consulta.= " ORDER BY t1.cod_leyes";					
				$Resp2 = mysqli_query($link, $Consulta);			
				while ($Fila2 = mysqli_fetch_array($Resp2))
				{
					$ArrLeyes[$Fila2["cod_leyes"]]["cod_leyes"] = $Fila2["cod_leyes"];
					$ArrLeyes[$Fila2["cod_leyes"]]["valor"] = "";
					$ArrLeyes[$Fila2["cod_leyes"]]["cod_unidad"] = "";
					$ArrLeyes[$Fila2["cod_leyes"]]["nom_leyes"] = $Fila2["abreviatura"];
				}
			}
		}
	}

?>
<html>
<head>
<title>Interfaces Codelco</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="javascript">
function Proceso(opt)
{
	var f = document.frmListado;
	switch (opt)
	{
		case "I":
			f.BtnImprimir.style.visivility = "hidden";
			f.BtnSalir.style.visivility = "hidden";
			window.print();
			f.BtnImprimir.style.visivility = "visible";
			f.BtnSalir.style.visivility = "visible";
			break;
		case "S":
			window.close();
			break;			
	}
}
</script>
<style type="text/css">
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
</style></head>

<body>
<form name="frmListado" action="" method="post">
  <div align="center"><strong>REGISTRO DE LEYES</strong> <br>
    <br>
  </div>
  <table width="650" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
	<tr align="center" class="ColorTabla01"> 
	<td>Fecha</td>
	<td>Num.Lote</td>	
	<td>Peso</td>
	<td>S.A.</td>
<?php
	reset($ArrLeyes);
	foreach($ArrLeyes as $k=>$v)
	{
		echo "<td align='center'>".$v["nom_leyes"]."</td>\n";
	}
?>	
	</tr>
<?php		

	$ArrLeyes = array();
	$ArrTotales = array();
	
	//RESCATA BAD
	if ($Producto=="25" && $SubProducto=="1")
	{	
		$TotalPeso = 0;	
		$Consulta = "select t1.lote,t1.fecha_hora,t2.fecha_embarque,sum(pneto) as peso_neto,count(*) as unidades from pmn_web.pmn_pesa_bad_cabecera t1 inner join  pmn_web.pmn_pesa_bad_detalle t2 on t1.lote=t2.lote ";
		$Consulta.= " where t2.fecha_embarque between '".$AnoAux."-".$MesAux."-01 00:00:00' and '".$AnoAux."-".$MesAux."-31 23:59:59' ";
		$Consulta.= " and t1.lote='".$NumLote."' group by t1.lote";
		$RespAux = mysqli_query($link, $Consulta);
		$i=0;
		while ($FilaAux = mysqli_fetch_array($RespAux))
		{
			echo "<tr>\n";	
			echo "<td align='center'>".substr($FilaAux["fecha_embarque"],0,10)."</td>\n";
			echo "<td align='center'>".$FilaAux["lote"]."</td>";			
			echo "<td align='right'>".number_format($FilaAux["peso_neto"],1,",",".")."</td>";	
			//CONSULTA LEYES
			$Consulta = " select distinct t2.nro_solicitud, t3.cod_leyes, t3.valor, t3.cod_unidad, t4.abreviatura, t5.conversion ";
			$Consulta.= " FROM pmn_web.pmn_pesa_bad_cabecera t1  ";
			$Consulta.= " INNER JOIN cal_web.solicitud_analisis t2 on t1.lote=t2.id_muestra ";
			$Consulta.= " INNER JOIN cal_web.leyes_por_solicitud t3 ";
			$Consulta.= " on t2.nro_solicitud = t3.nro_solicitud and t2.recargo=t3.recargo ";
			$Consulta.= " INNER JOIN proyecto_modernizacion.leyes t4 on t3.cod_leyes=t4.cod_leyes ";
			$Consulta.= " INNER JOIN proyecto_modernizacion.unidades t5 on t4.cod_unidad=t5.cod_unidad ";
			$Consulta.= " WHERE t2.cod_producto = '25' AND t2.cod_subproducto = '1'";
			$Consulta.= " and t1.lote='".$NumLote."'";
			$Consulta.= " ORDER BY t3.cod_leyes ";
			$Resp2 = mysqli_query($link, $Consulta);
			$i=1;
			//echo $Consulta;
			while ($Fila2 = mysqli_fetch_array($Resp2))
			{
				$SA = $Fila2["nro_solicitud"];
				$ArrLeyes[$Fila2["cod_leyes"]]["cod_leyes"] = $Fila2["cod_leyes"];
				$ArrLeyes[$Fila2["cod_leyes"]]["valor"] = $Fila2["valor"];
				$ArrLeyes[$Fila2["cod_leyes"]]["cod_unidad"] = $Fila2["cod_unidad"];
				$ArrLeyes[$Fila2["cod_leyes"]]["nom_leyes"] = $Fila2["abreviatura"];
				$ArrLeyes[$Fila2["cod_leyes"]]["conversion"] = $Fila2["conversion"];
				//ARREGLO TOTALES
				$ArrTotales[$Fila2["cod_leyes"]]["cod_leyes"] = $Fila2["cod_leyes"];
				$ArrTotales[$Fila2["cod_leyes"]]["valor"] = $ArrTotales[$Fila2["cod_leyes"]]["valor"] + (($Fila2["valor"] * $FilaAux["peso_neto_barra"])/$Fila2["conversion"]);
				$ArrTotales[$Fila2["cod_leyes"]]["cod_unidad"] = $Fila2["cod_unidad"];
				$ArrTotales[$Fila2["cod_leyes"]]["nom_leyes"] = $Fila2["abreviatura"];
				$ArrTotales[$Fila2["cod_leyes"]]["conversion"] = $Fila2["conversion"];
			}									
			echo "<td align='center'>".substr($SA,4)."</td>";
			reset($ArrLeyes);
			foreach($ArrLeyes as $k=>$f)
			{			
				echo "<td align='center'>".number_format($f["valor"],3,",",".")."</td>\n";
			}							
			echo "</tr>\n";	
			$TotalPeso = $TotalPeso + $FilaAux["peso_neto"];						
			reset($ArrLeyes);
			do {			 
			  $key = key ($ArrLeyes);
			  $ArrLeyes[$key]["valor"] = "";
			  $ArrLeyes[$key]["cod_unidad"] = "";
			} while (next($ArrLeyes));	
		}
	}
	//RESCATA ORO
	if ($Producto=="34" && $SubProducto=="2")
	{	
		$TotalPeso = 0;	
		$Consulta = "select * from pmn_web.embarque_oro ";
		$Consulta.= " where fecha between '".$AnoAux."-".$MesAux."-01' and '".$AnoAux."-".$MesAux."-31'";
		$Consulta.= " and num_barra='".$NumLote."'";
		$RespAux = mysqli_query($link, $Consulta);
		$i=0;
		while ($FilaAux = mysqli_fetch_array($RespAux))
		{
			echo "<tr>\n";	
			echo "<td align='center'>".$FilaAux["fecha"]."</td>\n";
			echo "<td align='center'>".$FilaAux["num_barra"]."</td>";			
			echo "<td align='right'>".number_format($FilaAux["peso_neto_barra"],4,",",".")."</td>";	
			//CONSULTA LEYES
			$Consulta = " select distinct t2.nro_solicitud, t3.cod_leyes, t3.valor, t3.cod_unidad, t4.abreviatura, t5.conversion ";
			$Consulta.= " FROM pmn_web.carga_fusion_oro t1  ";
			$Consulta.= " INNER JOIN cal_web.solicitud_analisis t2 on (t1.num_electrolisis=t2.id_muestra or t1.num_barra=t2.id_muestra) ";
			$Consulta.= " INNER JOIN cal_web.leyes_por_solicitud t3 ";
			$Consulta.= " on t2.nro_solicitud = t3.nro_solicitud and t2.recargo=t3.recargo ";
			$Consulta.= " INNER JOIN proyecto_modernizacion.leyes t4 on t3.cod_leyes=t4.cod_leyes ";
			$Consulta.= " INNER JOIN proyecto_modernizacion.unidades t5 on t4.cod_unidad=t5.cod_unidad ";
			$Consulta.= " WHERE t2.cod_producto = '34' AND t2.cod_subproducto = '2'";
			$Consulta.= " and t1.num_barra='".$NumLote."'";
			$Consulta.= " ORDER BY t3.cod_leyes ";
			$Resp2 = mysqli_query($link, $Consulta);
			$i=1;
			//echo $Consulta;
			while ($Fila2 = mysqli_fetch_array($Resp2))
			{
				$SA = $Fila2["nro_solicitud"];
				$ArrLeyes[$Fila2["cod_leyes"]]["cod_leyes"] = $Fila2["cod_leyes"];
				$ArrLeyes[$Fila2["cod_leyes"]]["valor"] = $Fila2["valor"];
				$ArrLeyes[$Fila2["cod_leyes"]]["cod_unidad"] = $Fila2["cod_unidad"];
				$ArrLeyes[$Fila2["cod_leyes"]]["nom_leyes"] = $Fila2["abreviatura"];
				$ArrLeyes[$Fila2["cod_leyes"]]["conversion"] = $Fila2["conversion"];
				//ARREGLO TOTALES
				$ArrTotales[$Fila2["cod_leyes"]]["cod_leyes"] = $Fila2["cod_leyes"];
				$ArrTotales[$Fila2["cod_leyes"]]["valor"] = $ArrTotales[$Fila2["cod_leyes"]]["valor"] + (($Fila2["valor"] * $FilaAux["peso_neto_barra"])/$Fila2["conversion"]);
				$ArrTotales[$Fila2["cod_leyes"]]["cod_unidad"] = $Fila2["cod_unidad"];
				$ArrTotales[$Fila2["cod_leyes"]]["nom_leyes"] = $Fila2["abreviatura"];
				$ArrTotales[$Fila2["cod_leyes"]]["conversion"] = $Fila2["conversion"];
			}									
			echo "<td align='center'>".substr($SA,4)."</td>";
			reset($ArrLeyes);
			foreach($ArrLeyes as $k=>$f)
			{			
				echo "<td align='center'>".number_format($f["valor"],3,",",".")."</td>\n";
			}							
			echo "</tr>\n";	
			$TotalPeso = $TotalPeso + $FilaAux["peso_neto_barra"];						
			reset($ArrLeyes);
			do {			 
			  $key = key ($ArrLeyes);
			  $ArrLeyes[$key]["valor"] = "";
			  $ArrLeyes[$key]["cod_unidad"] = "";
			} while (next($ArrLeyes));	
		}
	}
	
	if ($Producto=="29" && $SubProducto=="4")//EMBARQUE PLATA
	{			
		$TotalPeso = 0;
		$Peso=0;$peso=0;$cantidad=0;
		$Consulta = " select t1.num_acta, t1.fecha, t2.num_electrolisis, t2.cantidad, t2.caja_ini, t2.caja_fin,";
		$Consulta.=" t1.peso as peso, t1.cantidad as cantidad";
		$Consulta.= " FROM pmn_web.embarque_plata AS t1";
		$Consulta.= " LEFT JOIN pmn_web.detalle_embarque_plata AS t2";
		$Consulta.= " ON t1.num_acta = t2.num_acta AND YEAR(t1.fecha) = t2.ano AND MONTH(t1.fecha) = t2.mes";		
		$Consulta.= " WHERE YEAR(t1.fecha) = '".$AnoAux."'";// AND MONTH(t1.fecha) = '".$MesAux."'";
		$Consulta.= " AND t2.num_electrolisis = '".$NumLote."'";
		$Consulta.= " AND t1.num_acta = '".$NumActa."'";
		$Consulta.= " ORDER BY t2.num_electrolisis ";
		$RespAux = mysqli_query($link, $Consulta);
		//echo $Consulta;
		$ContCajas=0;
		while ($FilaAux = mysqli_fetch_array($RespAux))
		{			
			//CONSULTO LEYES
			$peso = $FilaAux["peso"];
			$cantidad = $FilaAux["cantidad"];
			$Consulta = " select t1.num_acta, t1.fecha, t2.num_electrolisis, t3.nro_solicitud, t2.cantidad, t5.cod_leyes, ";
			$Consulta.= " t5.valor, t5.cod_unidad, t6.abreviatura, t7.conversion,t1.peso as pesag, t1.cantidad as catiag ";
			$Consulta.= " FROM pmn_web.embarque_plata AS t1";
			$Consulta.= " LEFT JOIN pmn_web.detalle_embarque_plata AS t2";
			$Consulta.= " ON t1.num_acta = t2.num_acta AND YEAR(t1.fecha) = t2.ano AND MONTH(t1.fecha) = t2.mes ";
			$Consulta.= " LEFT JOIN cal_web.solicitud_analisis AS t3";
			$Consulta.= " ON t2.num_electrolisis = t3.id_muestra AND t3.cod_producto = '29' AND t3.cod_subproducto = '4'";
			$Consulta.= " AND t3.cod_periodo = '1' AND t3.agrupacion = '5'";
			$Consulta.= " LEFT JOIN cal_web.leyes_por_solicitud AS t5";
			$Consulta.= " ON t3.nro_solicitud = t5.nro_solicitud AND t3.recargo = t5.recargo";
			$Consulta.= " INNER JOIN proyecto_modernizacion.leyes t6 ON t5.cod_leyes=t6.cod_leyes ";
			$Consulta.= " INNER JOIN proyecto_modernizacion.unidades t7 ON t5.cod_unidad=t7.cod_unidad";
			$Consulta.= " WHERE YEAR(t1.fecha) = '".$AnoAux."'";// AND MONTH(t1.fecha) = '".$MesAux."'";
			$Consulta.= " AND t2.num_electrolisis = '".$FilaAux["num_electrolisis"]."'";
			$Consulta.= " AND t1.num_acta = '".$NumActa."'";
			$Consulta.= " ORDER BY t2.num_electrolisis ";
			$Resp2 = mysqli_query($link, $Consulta);
			//echo $Consulta;
			while ($Fila2 = mysqli_fetch_array($Resp2))
			{
				$SA = $Fila2["nro_solicitud"];
				$ArrLeyes[$Fila2["cod_leyes"]]["cod_leyes"] = $Fila2["cod_leyes"];
				$ArrLeyes[$Fila2["cod_leyes"]]["valor"] = $Fila2["valor"];
				$ArrLeyes[$Fila2["cod_leyes"]]["cod_unidad"] = $Fila2["cod_unidad"];
				$ArrLeyes[$Fila2["cod_leyes"]]["nom_leyes"] = $Fila2["abreviatura"];
				//ARREGLO TOTALES
				$ArrTotales[$Fila2["cod_leyes"]]["cod_leyes"] = $Fila2["cod_leyes"];
				$ArrTotales[$Fila2["cod_leyes"]]["valor"] = $ArrTotales[$Fila2["cod_leyes"]]["valor"] + (($Fila2["valor"] * $Peso)/$Fila2["conversion"]);				
				$ArrTotales[$Fila2["cod_leyes"]]["cod_unidad"] = $Fila2["cod_unidad"];
				$ArrTotales[$Fila2["cod_leyes"]]["nom_leyes"] = $Fila2["abreviatura"];
				$ArrTotales[$Fila2["cod_leyes"]]["conversion"] = $Fila2["conversion"];
			}		
			$Peso = $peso / $cantidad; //$Peso = 25;//$FilaAux["cantidad"]*25;
			for ($i=$FilaAux["caja_ini"];$i<=$FilaAux["caja_fin"];$i++)
			{
				echo "<tr>\n";	
				echo "<td align='center'>".$FilaAux["fecha"]."</td>\n";
				echo "<td align='center'>".$i."</td>";			
				echo "<td align='right'>".number_format($Peso,0,",",".")."</td>";						
				echo "<td align='center'>".substr($SA,4)."</td>";
				reset($ArrLeyes);
				foreach($ArrLeyes as $k=>$f)
				{			
					echo "<td align='center'>".number_format($f["valor"],3,",",".")."</td>\n";
				}							
				echo "</tr>\n";	
				$TotalPeso = $TotalPeso + $Peso;	
				$ContCajas++;
			}
			reset($ArrLeyes);
			do {			 
			  $key = key ($ArrLeyes);
			  $ArrLeyes[$key]["valor"] = "";
			  $ArrLeyes[$key]["cod_unidad"] = "";
			} while (next($ArrLeyes));	
		}				
	}
	
	if (($Producto=="31" && $SubProducto=="1") || ($Producto=="47" && $SubProducto=="1") || ($Producto=="28" && $SubProducto=="1") || ($Producto=="28" && $SubProducto=="6") || 
	($Producto=="33" && $SubProducto=="2"))
	{
		$TotalPeso = 0;
		$valor_real = 0;	
			
		//PALADIO-PLATINO, ESCORIA, SELENI, TELURO
		//TABLA PRODUCCION_SUBPRODUCTOS		
		//CONSULTA LEYES

		$Consulta = " select * ";
		$Consulta.= " FROM pmn_web.produccion_subproductos AS t1";
		$Consulta.= " INNER JOIN cal_web.solicitud_analisis AS t2";
		$Consulta.= " ON t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto and ";
		$Consulta.= " case when t1.cod_producto='31' and t1.cod_subproducto='1' ";
		$Consulta.= " then t2.id_muestra=t1.numero ";
		$Consulta.= " else t2.nro_solicitud=t1.id_analisis end ";
		$Consulta.= " AND t2.cod_periodo = '1' AND "; 

		if ($Producto=="31" && $SubProducto=="1")
			$Consulta.= " t2.recargo = '0'";
		else
			$Consulta.= " (t2.recargo = '0' or t2.recargo = '' or t2.recargo='1')";


		
		//$Consulta.= " AND t2.cod_periodo = '1' AND t2.recargo = '0'";

		$Consulta.= " INNER JOIN cal_web.leyes_por_solicitud AS t3";
		$Consulta.= " ON t2.nro_solicitud = t3.nro_solicitud AND t2.recargo = t3.recargo ";
		$Consulta.= " INNER JOIN proyecto_modernizacion.leyes t4 on t3.cod_leyes=t4.cod_leyes ";
		$Consulta.= " INNER JOIN proyecto_modernizacion.unidades t5 on t3.cod_unidad=t5.cod_unidad ";
		$Consulta.= " WHERE t1.cod_producto = '".$Producto."' AND t1.cod_subproducto = '".$SubProducto."'";
		$Consulta.= " AND t1.fecha_venta BETWEEN '".$AnoAux."-".$MesAux."-01' AND '".$AnoAux."-".$MesAux."-31' ";
		$Consulta.= " AND t1.numero='".$NumLote."' and t2.estado_actual <> '16' and t2.estado_actual <>'7'";
		$Consulta.= " ORDER BY t3.cod_leyes";			
		$Encontro=false;

		$Resp2 = mysqli_query($link, $Consulta);
			

		while ($Fila2 = mysqli_fetch_array($Resp2))
		{
			$FechaVenta = $Fila2["fecha_produccion"];
			$Encontro=true;
			$Peso = $Fila2["peso"];
			$SA = $Fila2["nro_solicitud"];
			$RR= $Fila2["recargo"];
			
			if ($Fila2["cod_leyes"]=="01")
				$LeyHum = $Fila2["valor"];

			$ArrLeyes[$Fila2["cod_leyes"]]["cod_leyes"]  = $Fila2["cod_leyes"];
			$ArrLeyes[$Fila2["cod_leyes"]]["valor"]      = $Fila2["valor"];
			$ArrLeyes[$Fila2["cod_leyes"]]["cod_unidad"] = $Fila2["cod_unidad"];
			$ArrLeyes[$Fila2["cod_leyes"]]["nom_leyes"]  = $Fila2["abreviatura"];
			$ArrLeyes[$Fila2["cod_leyes"]]["conversion"] = $Fila2["conversion"];			
		}	
		if ($Encontro)
		{			
			$Peso = $Peso - (($Peso*$LeyHum)/100);			
			echo "<tr>\n";	
			echo "<td align='center'>".$FechaVenta."</td>\n";
			echo "<td align='center'>".$NumLote."</td>";			
			echo "<td align='right'>".number_format($Peso,4,",",".")."</td>";	
			echo "<td align='center'>".substr($SA,4)."</td>";
			reset($ArrLeyes);
			foreach($ArrLeyes as $k=>$f)
			{			
				echo "<td align='center'>".number_format($f["valor"],3,",",".")."</td>\n";
				//ARREGLO TOTALES
				$ArrTotales[$k]["cod_leyes"] = $k;
				$ArrTotales[$k]["valor"] = $ArrTotales[$k]["valor"] + (($f["valor"] * $Peso)/$f["conversion"]);
				$ArrTotales[$k]["cod_unidad"] = $f["cod_unidad"];
				$ArrTotales[$k]["nom_leyes"] = $f["abreviatura"];
				$ArrTotales[$k]["conversion"] = $f["conversion"];
			}							
			echo "</tr>\n";	
			$TotalPeso = $TotalPeso + $Peso;	
			reset($ArrLeyes);
			do {			 
			  $key = key ($ArrLeyes);
			  $ArrLeyes[$key]["valor"] = "";
			  $ArrLeyes[$key]["cod_unidad"] = "";
			} while (next($ArrLeyes));	
		}
		//TABLA PRODUCTOS POR MOVIMIENTO
		if (!$Encontro)
		{
			$Consulta = "select * from pmn_web.productos_por_movimientos ";
			$Consulta.= " where fecha between '".$AnoAux."-".$MesAux."-01' and '".$AnoAux."-".$MesAux."-31'";
			$Consulta.= " and tipo_mov='4' and id not like '%aju%' and ";
			$Consulta.= " ((cod_producto='33' and cod_subproducto='2') or ";
			$Consulta.= " (cod_producto='31' and cod_subproducto='1') or ";
			$Consulta.= " (cod_producto='47' and cod_subproducto='1') or ";
			$Consulta.= " (cod_producto='28' and cod_subproducto='1'))";
			$Consulta.= " order by lpad(cod_producto,3,'0'), lpad(cod_subproducto,3,'0')";
			//echo $Consulta;
			$RespAux = mysqli_query($link, $Consulta);	
			while ($FilaAux = mysqli_fetch_array($RespAux))
			{
				$FechaVenta = $FilaAux["fecha"];
				$Peso = $FilaAux["peso_seco"];
				//Cu
				$ArrLeyes["02"]["cod_leyes"] = "02";
				$ArrLeyes["02"]["valor"] = $FilaAux["fino_cu"];
				switch ($FilaAux["unid_cu"])
				{
					case "100":
						$ArrLeyes["02"]["cod_unidad"] = "1";
						break;
					case "1000":
						$ArrLeyes["02"]["cod_unidad"] = "4";
						break;
					case "1000000":
						$ArrLeyes["02"]["cod_unidad"] = "2";
						break;
				}
				//Ag
				$ArrLeyes["04"]["cod_leyes"] = "04";
				$ArrLeyes["04"]["valor"] = $FilaAux["fino_ag"];
				switch ($FilaAux["unid_ag"])
				{
					case "100":
						$ArrLeyes["04"]["cod_unidad"] = "1";
						break;
					case "1000":
						$ArrLeyes["04"]["cod_unidad"] = "4";
						break;
					case "1000000":
						$ArrLeyes["04"]["cod_unidad"] = "2";
						break;
				}
				//Au
				$ArrLeyes["05"]["cod_leyes"] = "05";
				$ArrLeyes["05"]["valor"] = $FilaAux["fino_au"];
				switch ($FilaAux["unid_au"])
				{
					case "100":
						$ArrLeyes["05"]["cod_unidad"] = "1";
						break;
					case "1000":
						$ArrLeyes["05"]["cod_unidad"] = "4";
						break;
					case "1000000":
						$ArrLeyes["05"]["cod_unidad"] = "2";
						break;
				}					
			}
			echo "<tr>\n";	
			echo "<td align='center'>".$FechaVenta."</td>\n";
			echo "<td align='center'>".$NumLote."</td>";			
			echo "<td align='right'>".number_format($Peso,0,",",".")."</td>";	
			echo "<td align='center'>&nbsp;</td>";
			reset($ArrLeyes);
			foreach($ArrLeyes as $k=>$f)
			{			
				echo "<td align='center'>".number_format($f["valor"],3,",",".")."</td>\n";
			}							
			echo "</tr>\n";	
			$TotalPeso = $TotalPeso + $Peso;	
			reset($ArrLeyes);
			do {			 
			  $key = key ($ArrLeyes);
			  $ArrLeyes[$key]["valor"] = "";
			  $ArrLeyes[$key]["cod_unidad"] = "";
			} while (next($ArrLeyes));	
		}
	}echo "<tr>\n";	
	echo "<td align='center' colspan='2'><strong>TOTAL&nbsp;";
	if ($Producto=="29" && $SubProducto=="4")//EMBARQUE PLATA
	{
		if($Peso==25)
			echo $ContCajas."&nbsp;Cajas";
			else
			echo $ContCajas."&nbsp;Bolsas";
	}
	echo "</strong></td>\n";
	echo "<td align='right'>".number_format($TotalPeso,4,",",".")."</td>";	
	echo "<td align='right'>&nbsp;</td>";	
	reset($ArrTotales);
	foreach($ArrTotales as $k=>$v)
	{
		
		echo "<td align='center'>".number_format(($v["valor"]/$TotalPeso)*$v["conversion"],3,",",".")."</td>\n";
	}
	
?>
</table>
  <div align="center"><br>
    <br>
    <input name="BtnImprimir" type="button" id="BtnImprimir" value="Imprimir" style="width:70px " onClick="Proceso('I')">
    <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')">
  </div>
</form>
</body>
</html>

