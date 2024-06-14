<?php
	include("../principal/conectar_pmn_web.php");

	$xls         = isset($_REQUEST["xls"])?$_REQUEST["xls"]:"";
	$NumLote     = isset($_REQUEST["NumLote"])?$_REQUEST["NumLote"]:"";
	$Producto    = isset($_REQUEST["Producto"])?$_REQUEST["Producto"]:"";
	$SubProducto = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";


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


?>
<html>
<head>
<title>PTBA</title>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
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
.Estilo7 {font-size: 14px}
</style></head>

<body>
<form name="frmListado" action="" method="post">
  <div align="center"><strong>REGISTRO DE LEYES</strong> <br>
    <br>
    <table width="650" align="center"  border="0" cellpadding="0"  cellspacing="0">
      <tr>
        <td height="1%"><img src="archivos/images/interior/esq3.png"/></td>
        <td width="98%" height="15" background="archivos/images/interior/arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
        <td height="1%"><img src="archivos/images/interior/esq2.png" /></td>
      </tr>
      <tr>
        <td width="1%" background="archivos/images/interior/izquierdo.png"></td>
        <td align="center"><table width="700" border="1" align="center" cellpadding="3" cellspacing="0" class="TituloCabeceraAzul">
          <tr align="center" class="ColorTabla01">
            <td width="200px">Fecha</td>
            <td>Num.Lote</td>
            <td>Peso</td>
            <td>S.A.</td>
            <?php
	reset($ArrLeyes);
	//foreach($ArrLeyes as $k=>$v)
	foreach ($ArrLeyes as $k => $v)
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
		$Consulta.= " where ";//t2.fecha_embarque between '".$AnoAux."-".$MesAux."-01 00:00:00' and '".$AnoAux."-".$MesAux."-31 23:59:59' 
		$Consulta.= " t1.lote='".$NumLote."' group by t1.lote";
		$RespAux = mysqli_query($link, $Consulta);
		$i=0;
		if ($FilaAux = mysqli_fetch_array($RespAux))
		{
			$peso_neto_barra = isset($FilaAux["peso_neto_barra"])?$FilaAux["peso_neto_barra"]:0;
			echo "<tr>\n";	
			echo "<td align='center' width='200px'>".substr($FilaAux["fecha_embarque"],0,10)."</td>\n";
			echo "<td align='center'>".$NumLote."</td>";			
			echo "<td align='right'>".number_format($FilaAux["peso_neto"],1,",",".")."</td>";	
			//CONSULTA LEYES
			$Consulta = " select distinct t2.nro_solicitud, t3.cod_leyes, t3.valor, t3.cod_unidad, t4.abreviatura, t5.conversion ";
			$Consulta.= " FROM cal_web.solicitud_analisis t2 ";
			$Consulta.= " INNER JOIN cal_web.leyes_por_solicitud t3 ";
			$Consulta.= " on t2.nro_solicitud = t3.nro_solicitud and t2.recargo=t3.recargo ";
			$Consulta.= " INNER JOIN proyecto_modernizacion.leyes t4 on t3.cod_leyes=t4.cod_leyes ";
			$Consulta.= " INNER JOIN proyecto_modernizacion.unidades t5 on t4.cod_unidad=t5.cod_unidad ";
			$Consulta.= " WHERE t2.cod_producto = '25' AND t2.cod_subproducto = '1'";
			$Consulta.= " and t2.id_muestra='".$NumLote."'";
			$Consulta.= " ORDER BY t3.cod_leyes ";
			$Resp2 = mysqli_query($link, $Consulta);
			$i=1;
			//echo $Consulta;
			$SA=0;
			while ($Fila2 = mysqli_fetch_array($Resp2))
			{
				$SA = $Fila2["nro_solicitud"];
				$valor      = isset($Fila2["valor"])?$Fila2["valor"]:0;
				$conversion = isset($Fila2["conversion"])?$Fila2["conversion"]:0;
				$ArrLeyes[$Fila2["cod_leyes"]]["cod_leyes"] = $Fila2["cod_leyes"];
				$ArrLeyes[$Fila2["cod_leyes"]]["valor"] = $Fila2["valor"];
				$ArrLeyes[$Fila2["cod_leyes"]]["cod_unidad"] = $Fila2["cod_unidad"];
				$ArrLeyes[$Fila2["cod_leyes"]]["nom_leyes"] = $Fila2["abreviatura"];
				$ArrLeyes[$Fila2["cod_leyes"]]["conversion"] = $Fila2["conversion"];
				//ARREGLO TOTALES
				$ATFilcod_leyes_valor = isset($ArrTotales[$Fila2["cod_leyes"]]["valor"])?$ArrTotales[$Fila2["cod_leyes"]]["valor"]:0;
				$ArrTotales[$Fila2["cod_leyes"]]["cod_leyes"] = $Fila2["cod_leyes"];
				$ArrTotales[$Fila2["cod_leyes"]]["valor"] = $ATFilcod_leyes_valor + (($valor * $peso_neto_barra)/$conversion);
				$ArrTotales[$Fila2["cod_leyes"]]["cod_unidad"] = $Fila2["cod_unidad"];
				$ArrTotales[$Fila2["cod_leyes"]]["nom_leyes"] = $Fila2["abreviatura"];
				$ArrTotales[$Fila2["cod_leyes"]]["conversion"] = $Fila2["conversion"];
			}									
			echo "<td align='center'>".substr($SA,4)."</td>";
			reset($ArrLeyes);
			//while (list($k,$f)=each($ArrLeyes))
			foreach ($ArrLeyes as $k => $f)
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
	
	
?>
        </table></td>
        <td width="1%" background="archivos/images/interior/derecho.png"></td>
      </tr>
      <tr>
        <td width="1%" height="15"><img src="archivos/images/interior/esq1.png"/></td>
        <td height="15" background="archivos/images/interior/abajo.png"></td>
        <td width="1%" height="15"><img src="archivos/images/interior/esq4.png"></td>
      </tr>
    </table>
  </div>
  <div align="center"><br>
    <br>
    <a href="javascript:window.print()"><img src="archivos/btn_imprimir.png" alt='Imprimir' border="0" align="absmiddle" /></a>
	<a href="JavaScript:Proceso('S')"><img src="archivos/btn_volver2.png"  alt=" Volver " width="25" height="25"  border="0" align="absmiddle" /></a>
  </div>
</form>
</body>
</html>

