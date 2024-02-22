<?php
	include("../principal/conectar_principal.php");

	if(isset($_REQUEST["Flujo"])){
		$Flujo = $_REQUEST["Flujo"];
	}else{
		$Flujo = "";
	}

	if(isset($_REQUEST["Ano"])){
		$Ano = $_REQUEST["Ano"];
	}else{
		$Ano = date("Y");
	}
	if(isset($_REQUEST["Mes"])){
		$Mes = $_REQUEST["Mes"];
	}else{
		$Mes = date("m");
	}



	$Consulta = "select * from proyecto_modernizacion.flujos where sistema='RAM' and cod_flujo='".$Flujo."'";
	$Resp = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Resp))
		$NomFlujo = $Fila["descripcion"];
	$FechaIniTra = $Ano."-".str_pad($Mes,2,"0",STR_PAD_LEFT)."-01 08:00:00";
	$FechaFinTra = date("Y-m-d H:i:s", mktime(7,59,00,intval($Mes)+1,1,$Ano));
	$FechaIniRec = $Ano."-".str_pad($Mes,2,"0",STR_PAD_LEFT)."-01";
	$FechaFinRec = date("Y-m-d", mktime(0,0,0,intval($Mes)+1,1,$Ano));
	$FechaFinRec = date("Y-m-d", mktime(0,0,0,intval(substr($FechaFinRec,5,2)),1-1,intval(substr($FechaFinRec,0,4))));
?>
<html>
<head>
<title>Detalle de Flujo</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
</style></head>

<body>
<div align="center"><strong>FLUJO:&nbsp;<?php echo strtoupper($NomFlujo); ?>
  </strong><br>
  <br>
</div>
<table width="700" border="1" align="center" cellpadding="3" cellspacing="0">
  <tr align="center" valign="middle" class="ColorTabla01">
    <td width="62" rowspan="2">Rut</td>
    <td width="177" rowspan="2">Descripcion</td>
    <td width="67" rowspan="2">Peso</td>
    <td colspan="3">Leyes</td>
    <td colspan="3">Fino</td>
  </tr>
  <tr class="ColorTabla01">
    <td width="49" align="center">Cu</td>
    <td width="44" align="center">Ag</td>
    <td width="57" align="center">Au</td>
    <td width="53" align="center">Cu</td>
    <td width="56" align="center">Ag</td>
    <td width="61" align="center">Au</td>
  </tr>
<?php
	//************************************** FLUJOS ********************************************			
	//ELIMINA TABLA TEMPORALES
	$Eliminar = "DROP TABLE IF EXISTS ram_web.proceso_enabal_1";
	mysqli_query($link, $Eliminar);
	$Eliminar = "DROP TABLE IF EXISTS ram_web.proceso_enabal_2";
	mysqli_query($link, $Eliminar);
	$Eliminar = "DROP TABLE IF EXISTS ram_web.proceso_enabal_3";
	mysqli_query($link, $Eliminar);
	$Eliminar = "DROP TABLE IF EXISTS ram_web.proceso_enabal_general";
	mysqli_query($link, $Eliminar);
	$Eliminar = "DROP TABLE IF EXISTS ram_web.proceso_enabal_final";
	mysqli_query($link, $Eliminar);
	//LIMPIA TABLAS FLUJOS_MES Y EXISTENCIA NODO
	$Eliminar = "DELETE FROM ram_web.flujos_mes where ano='".$Ano."' and mes='".$Mes."'";
	mysqli_query($link, $Eliminar);
	$Eliminar = "DELETE FROM ram_web.existencia_nodo where ano='".$Ano."' and mes='".$Mes."'";
	mysqli_query($link, $Eliminar);
	//PROCESOS
	$FechaIniTra = $Ano."-".str_pad($Mes,2,"0",STR_PAD_LEFT)."-01 08:00:00";
	$FechaFinTra = date("Y-m-d H:i:s", mktime(7,59,00,intval($Mes)+1,1,$Ano));
	$FechaIniRec = $Ano."-".str_pad($Mes,2,"0",STR_PAD_LEFT)."-01";
	$FechaFinRec = date("Y-m-d", mktime(0,0,0,intval($Mes)+1,1,$Ano));
	$FechaFinRec = date("Y-m-d", mktime(0,0,0,intval(substr($FechaFinRec,5,2)),1-1,intval(substr($FechaFinRec,0,4))));
	//PROCESO ENABAL 1
	$Consulta = " CREATE TEMPORARY TABLE ram_web.proceso_enabal_1 AS  SELECT t1.cod_existencia, t2.cod_producto, t2.cod_subproducto,t1.rut_proveedor,";
	$Consulta.= " Sum(t1.peso_humedo) AS SumaDepeso_humedo,Sum(t1.peso_seco) AS SumaDepeso_seco,";
	$Consulta.= " Sum(t1.fino_cu) AS SumaDefino_cu,Sum(t1.fino_ag) AS SumaDefino_ag, Sum(t1.fino_au) AS SumaDefino_au";
	$Consulta.= " FROM ram_web.movimiento_proveedor t1 INNER JOIN ram_web.conjunto_ram_bd t2";
	$Consulta.= " ON t1.num_conjunto = t2.num_conjunto AND t1.cod_conjunto = t2.cod_conjunto";
	$Consulta.= " WHERE t1.fecha_movimiento >= '".$FechaIniRec."' And t1.fecha_movimiento <= '".$FechaFinRec."'";
	$Consulta.= " GROUP BY t1.cod_existencia, t2.cod_producto, t2.cod_subproducto, t1.rut_proveedor";
	$Consulta.= " HAVING t1.cod_existencia='02'";
	mysqli_query($link, $Consulta);
	//echo $Consulta."<br><br>";		
	
	//PROCESO  ENABAL 3
	$Consulta = " CREATE TEMPORARY TABLE ram_web.proceso_enabal_3 AS  SELECT t3.COD_LUGAR_DESTINO, t1.cod_existencia,t2.COD_PRODUCTO, t2.COD_SUBPRODUCTO, t1.rut_proveedor,";
	$Consulta.= " Sum(t1.peso_humedo) AS SumaDepeso_humedo, Sum(t1.peso_seco) AS SumaDepeso_seco,";
	$Consulta.= " Sum(t1.fino_cu) AS SumaDefino_cu, Sum(t1.fino_ag) AS SumaDefino_ag,Sum(t1.fino_au) AS SumaDefino_au";
	$Consulta.= " FROM ram_web.movimiento_conjunto t3 INNER JOIN (ram_web.movimiento_proveedor t1 INNER JOIN ram_web.conjunto_ram_bd t2";
	$Consulta.= " ON t1.num_conjunto = t2.num_conjunto AND t1.cod_conjunto = t2.cod_conjunto)";
	$Consulta.= " ON t3.fecha_movimiento = t1.fecha_movimiento";
	$Consulta.= " WHERE (t1.cod_existencia='12' Or t1.cod_existencia='16'";
	$Consulta.= " Or t1.cod_existencia='15' Or t1.cod_existencia='05')";
	$Consulta.= " AND (t1.fecha_movimiento>='".$FechaIniTra."' And t1.fecha_movimiento<='".$FechaFinTra."')";
	$Consulta.= " GROUP BY t3.cod_lugar_destino, t1.cod_existencia,";
	$Consulta.= " t2.cod_producto, t2.cod_subproducto, t1.rut_proveedor";
	$Consulta.= " HAVING (t3.cod_lugar_destino>='14' And t3.cod_lugar_destino<='25')";
	$Consulta.= " AND (t2.cod_subproducto='2' Or t2.cod_subproducto='3'";
	$Consulta.= " Or t2.cod_subproducto='6' Or t2.cod_subproducto='7' Or t2.cod_subproducto='8'";
	$Consulta.= " Or t2.cod_subproducto='12' Or t2.cod_subproducto='14' Or t2.cod_subproducto='91'";
	$Consulta.= " Or t2.cod_subproducto='92' Or t2.cod_subproducto='54')";
	mysqli_query($link, $Consulta);
	//echo $Consulta."<br><br>";
	
	//PROCESO ENABAL GENERAL
	$Consulta = " CREATE TEMPORARY TABLE ram_web.proceso_enabal_general AS";
	$Consulta.= " SELECT 0 as expr1000, cod_existencia, cod_producto, cod_subproducto, rut_proveedor,";
	$Consulta.= " SumaDepeso_humedo,SumaDepeso_Seco,SumaDefino_cu,SumaDefino_ag,SumaDefino_au";
	$Consulta.= " FROM ram_web.proceso_enabal_1";
	$Consulta.= " UNION SELECT cod_lugar_destino, cod_existencia, cod_producto, cod_subproducto, rut_proveedor,";
	$Consulta.= " SumaDepeso_humedo,SumaDepeso_Seco,SumaDefino_cu,SumaDefino_ag,SumaDefino_au";
	$Consulta.= " FROM ram_web.proceso_enabal_3";
	mysqli_query($link, $Consulta);
	//echo $Consulta."<br><br>";
	//PROCESO ENABAL FINAL
	$Consulta = " CREATE TEMPORARY TABLE ram_web.proceso_enabal_final AS";
	$Consulta.= " SELECT t2.expr1000, t2.cod_existencia,";
	$Consulta.= " case when t2.cod_existencia<'05' then t2.cod_existencia else '03' end AS expr3,t2.cod_producto,";
	$Consulta.= " t2.rut_proveedor,";
	$Consulta.= " case when IsNull(t1.flujo) then (select flujo_rut.flujo from ram_web.flujo_rut";
	$Consulta.= " where t2.expr1000=destino";
	$Consulta.= " and t2.cod_existencia = flujo_rut.cod_existencia";
	$Consulta.= " and t2.cod_producto = flujo_rut.cod_producto";
	$Consulta.= " and t2.cod_subproducto = flujo_rut.cod_subproducto";
	$Consulta.= " and flujo_rut.rut = '99999999-9') else t1.flujo end AS flujo,";
	$Consulta.= " t2.SumaDepeso_humedo,t2.SumaDepeso_seco as peso_seco,";
	$Consulta.= " t2.SumaDefino_cu as fino_cu,t2.SumaDefino_ag as fino_ag, t2.SumaDefino_au as fino_au ";
	$Consulta.= " FROM ram_web.flujo_rut t1 RIGHT JOIN ram_web.proceso_enabal_general t2";
	$Consulta.= " ON t1.cod_subproducto = t2.cod_subproducto AND t1.destino = t2.expr1000 AND t1.rut = t2.rut_proveedor";
	$Consulta.= " AND t1.cod_producto = t2.cod_producto AND t1.cod_existencia = t2.cod_existencia";
	$Consulta.= " order by expr3";
	//echo $Consulta."<br>";
	mysqli_query($link, $Consulta);
	//SELECCIONA TODO DE TABLA FINAL
	$Consulta = "select * from ram_web.proceso_enabal_final where expr3='03'";
	$Resp = mysqli_query($link, $Consulta);
	$TotalFinoCu=0;
	$TotalFinoAg=0;
	$TotalFinoAu=0;
	$TotalPeso=0;
	while ($Fila = mysqli_fetch_array($Resp))
	{
		//echo $Fila["flujo"]." - ".$Fila["flujo"]; 
		if ($Fila["flujo"] == $Flujo)
		{
			$Consulta = "select * from ram_web.proveedor where trim(rut_proveedor) = '".trim($Fila["rut_proveedor"])."'";
			$Resp2 = mysqli_query($link, $Consulta);
			if ($Fila2 = mysqli_fetch_array($Resp2))
				$NomProv = $Fila2["nombre"];
			else
				$NomProv = "&nbsp;";
			echo "<tr>";
			echo "<td align='center'>".$Fila["rut_proveedor"]."</td>";
			echo "<td align='left'>".$NomProv."</td>";		
			echo "<td align='right'>".number_format($Fila["peso_seco"],0,",",".")."</td>";		
			if ($Fila["fino_cu"]>0 && $Fila["peso_seco"]>0)
			{
				echo "<td align='right'>".number_format(($Fila["fino_cu"]/$Fila["peso_seco"])*100,2,",",".")."</td>";
				$TotalFinoCu = $TotalFinoCu + $Fila["fino_cu"];
			}
			else	
			{
				echo "<td align='right'>0</td>";
			}
			if ($Fila["fino_ag"]>0 && $Fila["peso_seco"]>0)
			{
				echo "<td align='right'>".number_format(($Fila["fino_ag"]/$Fila["peso_seco"])*1000,2,",",".")."</td>";
				$TotalFinoAg = $TotalFinoAg + $Fila["fino_ag"];
			}
			else	
			{
				echo "<td align='right'>0</td>";
			}
			if ($Fila["fino_au"]>0 && $Fila["peso_seco"]>0)
			{
				echo "<td align='right'>".number_format(($Fila["fino_au"]/$Fila["peso_seco"])*1000,2,",",".")."</td>";
				$TotalFinoAu = $TotalFinoAu + $Fila["fino_au"];
			}
			else	
			{
				echo "<td align='right'>0</td>";
			}
			echo "<td align='right'>".number_format($Fila["fino_cu"],0,",",".")."</td>";
			echo "<td align='right'>".number_format($Fila["fino_ag"],0,",",".")."</td>";
			echo "<td align='right'>".number_format($Fila["fino_au"],0,",",".")."</td>";
			echo "</tr>";
			$TotalPeso = $TotalPeso + $Fila["peso_seco"];			
		}		
	}
	echo "<tr>";
	echo "<td align='center' colspan='2'>TOTAL</td>";		
	echo "<td align='right'>".number_format($TotalPeso,0,",",".")."</td>";		
	if ($TotalFinoCu>0 && $TotalPeso>0)
		echo "<td align='right'>".number_format(($TotalFinoCu/$TotalPeso)*100,2,",",".")."</td>";
	else	echo "<td align='right'>0</td>";
	if ($TotalFinoAg>0 && $TotalPeso>0)
		echo "<td align='right'>".number_format(($TotalFinoAg/$TotalPeso)*1000,2,",",".")."</td>";
	else	echo "<td align='right'>0</td>";
	if ($TotalFinoAu>0 && $TotalPeso>0)
		echo "<td align='right'>".number_format(($TotalFinoAu/$TotalPeso)*1000,2,",",".")."</td>";
	else	echo "<td align='right'>0</td>";
	echo "<td align='right'>".number_format($TotalFinoCu,0,",",".")."</td>";
	echo "<td align='right'>".number_format($TotalFinoAg,0,",",".")."</td>";
	echo "<td align='right'>".number_format($TotalFinoAu,0,",",".")."</td>";
	echo "</tr>";
	//ELIMINA TABLA TEMPORALES
	$Eliminar = "DROP TABLE IF EXISTS ram_web.proceso_enabal_1";
	mysqli_query($link, $Eliminar);
	$Eliminar = "DROP TABLE IF EXISTS ram_web.proceso_enabal_2";
	mysqli_query($link, $Eliminar);
	$Eliminar = "DROP TABLE IF EXISTS ram_web.proceso_enabal_3";
	mysqli_query($link, $Eliminar);
	$Eliminar = "DROP TABLE IF EXISTS ram_web.proceso_enabal_general";
	mysqli_query($link, $Eliminar);
	$Eliminar = "DROP TABLE IF EXISTS ram_web.proceso_enabal_final";
	mysqli_query($link, $Eliminar);
?>  
</table>
</body>
</html>
