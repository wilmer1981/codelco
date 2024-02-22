<?php
	include("../principal/conectar_pmn_web.php");

	if ($proceso == "G")
	{			
		//Actualiza los campos Bloqueado y Hay_datos.
		$actualizar = "UPDATE pmn_web.resultado_productos SET bloqueado = 'S'";
		$actualizar.= " WHERE tipo_mov = '".$cmbmovimiento."' AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."' ";
		$actualizar.= " AND YEAR(fecha) = '".$ano1."' AND MONTH(fecha) = '".$mes1."'";
		mysqli_query($link, $actualizar);
		//echo $actualizar."<br>";
	}	
?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Guardar()
{
	var f = document.frmListado;
	
	if (confirm("Esta Seguro De Guardar Los Datos Para Cerrar"))	
	{	
		f.action = "pmn_con_balance_beneficio_bad_ventana.php?proceso=G";
		f.submit();
	}
}
/******************/
function Imprimir()
{
	window.print();
}
/**********/
function Salir()
{
	var f = document.frmListado;

	var linea = "recargapag1=S&recargapag2=S&recargapag3=S&cmbmovimiento=" + f.cmbmovimiento.value + "&cmbproducto=" + f.cmbproducto.value + "&cmbsubproducto=" + f.cmbsubproducto.value;
	linea = linea + "&ano1=" + f.ano1.value + "&mes1=" + f.mes1.value;
	
	document.location = "pmn_con_tipo_movimiento.php?" + linea;
}
</script>
</head>

<body background="../Principal/imagenes/fondo3.gif" leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="frmListado" action="" method="post">
<?php
	//Campos Ocultos.
	echo '<input name="cmbmovimiento" type="hidden" value="'.$cmbmovimiento.'">';
	echo '<input name="cmbproducto" type="hidden" value="'.$cmbproducto.'">';
	echo '<input name="cmbsubproducto" type="hidden" value="'.$cmbsubproducto.'">';
	echo '<input name="FechaIni" type="hidden" value="'.$FechaIni.'">';
	echo '<input name="FechaFin" type="hidden" value="'.$FechaFin.'">';
	echo '<input name="ano1" type="hidden" value="'.$ano1.'">';						
	echo '<input name="mes1" type="hidden" value="'.$mes1.'">';
	echo '<input name="TipoCalculo" type="hidden" value="'.$TipoCalculo.'">';								
?>
<br>
<table width="600" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
  <tr> 
    <td width="113">Informe</td>
    <td width="468" align="left">Beneficio Barro Anodico Descobrizacion En PLASEL</td>
  </tr>
  <tr> 
    <td>Periodo</td>
    <td align="left"><?php echo substr($FechaIni,8,2).'-'.substr($FechaIni,5,2).'-'.substr($FechaIni,0,4).' AL '.substr($FechaFin,8,2).'-'.substr($FechaFin,5,2).'-'.substr($FechaFin,0,4) ?></td>
  </tr>
  <tr align="center"> 
    <td colspan="2"> 
<?php
	//Consulta Si el Mes-Ao esta Bloqueado, si esta Bloqueado(1), entonces se rescatan los datos de una tabla ya creada.
	$consulta = "SELECT CASE WHEN COUNT(*) != 0 THEN 'N' ELSE 'S' END AS activar FROM pmn_web.resultado_productos";
	$consulta.= " WHERE YEAR(fecha) = '".$ano1."' AND MONTH(fecha) = '".$mes1."' AND bloqueado = 'S'";
	$consulta.= " AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."' AND tipo_mov = '".$cmbmovimiento."'";	
	//echo $consulta."<br>";
	$rs5 = mysqli_query($link, $consulta);
	$row5 = mysqli_fetch_array($rs5);
	$Activar = $row5[activar];
		
	if ($Activar == "S")
	{
		echo '<input name="btnguardar" type="button" id="btnguardar" value="Guardar" style="width:70" onClick="Guardar()">';
		$eliminar = "DELETE FROM pmn_web.resultado_productos";
		$eliminar.= " WHERE YEAR(fecha) = '".$ano1."' AND MONTH(fecha) = '".$mes1."'";
		$eliminar.= " AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."' AND tipo_mov = '".$cmbmovimiento."'";			
		//echo $eliminar."<br>";
		mysqli_query($link, $eliminar);	
	}
?>	 	  
	  <input name="btnimprimir" type="button" id="btnimprimir" value="Imprimr" style="width:70" onClick="Imprimir()"> 
      <input name="btnsalir" type="button" id="btnsalir" value="Salir" style="width:70" onClick="Salir()"> 
    </td>
  </tr>
</table>
  
<br>
  <table width="750" border="1" align="center"  cellspacing="0" cellpadding="3" class="TablaInterior">
    <tr class="ColorTabla01"> 
      <td width="78" rowspan="2" align="center">N&ordm; Lixiviacion</td>
      <td width="53" rowspan="2" align="center">Prod.</td>
      <td width="69" rowspan="2" align="center">Hornada</td>
      <td width="74" rowspan="2" align="center">Fecha</td>
      <td width="66" rowspan="2" align="center">Peso Humedo </td>
      <td width="65" rowspan="2" align="center">Total Benef.</td>
      <td width="68" rowspan="2" align="center">Total Disp.</td>
      <td colspan="3" align="center"> 
        <?php
	if ($TipoCalculo == "L")
		echo "Leyes";
	else
		echo "Finos";
	?>
      </td>
    </tr>
    <tr class="ColorTabla01"> 
      <?php	
	if ($TipoCalculo == "L")
	{
?>
      <td width="65" align="center">Cu (%)</td>
      <td width="64" align="center">Ag (K/T)</td>
      <td width="65" align="center">Au (K/T)</td>
<?php
	}
	else
	{
?>
    <td width="65" align="center">Cu (Kg)</td>
    <td width="64" align="center">Ag (Kg)</td>
    <td width="65" align="center">Au (Kg)</td>
<?php
	}
?>	
    </tr>
    <?php
	if ($Activar == "S")
	{   
		//Llena tabla resultado_productos.
		$consulta = "CREATE TABLE IF NOT EXISTS pmn_web.resultado_productos ";
		$consulta.= " (fecha date, tipo_mov char(3), cod_producto varchar(10), cod_subproducto varchar(10),";
		$consulta.= " correlativo int(10), flujo int(3), num_lixiviacion varchar(20), lixiviador varchar(20),";
		$consulta.= " lote varchar(20), tambor varchar(20), id_muestra varchar(20),";
		$consulta.= " peso_humedo double(10,4), humedad double(10,4), peso_seco double(10,4),";
		$consulta.= " bloquedo char(1), conversion int(10), num_caja varchar(20), hornada varchar(20),";
		$consulta.= " num_barra varchar(20), num_electrolisis varchar(20), num_anodos double(10,4),";
		$consulta.= " peso_total double(10,4), peso_muestra double(10,4), cod_leyes char(3), valor double(10,5), fino double(10,5))";
		$consulta.= " SELECT t1.fecha, '".$cmbmovimiento."' AS tipo_mov, '".$cmbproducto."' AS cod_producto, '".$cmbsubproducto."' AS cod_subproducto, '' AS correlativo,";	
		$consulta.= " t9.flujo, t1.referencia AS num_lixiviacion, '' AS lixiviador, '' AS lote, '' AS tambor, '' AS id_muestra,";								
		$consulta.= " '' AS peso_humedo, '' AS humedad, SUM(t1.bad) AS peso_seco, 'N' AS bloqueado,";
		$consulta.= " CASE WHEN t3.cod_leyes = '02' THEN 100 ELSE 1000 END AS conversion,";
		$consulta.= " '' AS num_caja, CONCAT(num_horno,'-', num_funda,'-', hornada_total,'-', hornada_parcial) AS horanada, '' AS num_barra, '' AS num_electrolisis, '' AS num_anodos,";
		$consulta.= " '' AS peso_total, '' AS peso_muestra, t3.cod_leyes, t3.valor, (t3.valor * SUM(t1.bad) / CASE WHEN t3.cod_leyes = '02' THEN 100 ELSE 1000 END) AS fino";				
		$consulta.= " FROM pmn_web.detalle_deselenizacion AS t1";
		$consulta.= " LEFT JOIN cal_web.solicitud_analisis AS t2";
		$consulta.= " ON t2.cod_producto = '".$cmbproducto."' AND t2.cod_subproducto = '".$cmbsubproducto."'";
		$consulta.= " AND t1.referencia = t2.id_muestra";
		$consulta.= " AND t2.cod_periodo = '1' AND t2.agrupacion = '4'";
		$consulta.= " LEFT JOIN cal_web.leyes_por_solicitud AS t3";
		$consulta.= " ON t2.nro_solicitud = t3.nro_solicitud AND t2.id_muestra = t3.id_muestra";
		$consulta.= " AND t2.cod_producto = t3.cod_producto AND t2.cod_subproducto = t3.cod_subproducto";
		$consulta.= " AND t2.fecha_hora = t3.fecha_hora AND t2.rut_funcionario = t3.rut_funcionario";		
		$consulta.= " LEFT JOIN pmn_web.relacion_flujo AS t9";
		$consulta.= " ON t9.cod_producto = '".$cmbproducto."' AND t9.cod_subproducto = '".$cmbsubproducto."' AND t9.tipo_mov = '".$cmbmovimiento."'";						
		$consulta.= " WHERE fecha BETWEEN '".$FechaIni."' AND '".$FechaFin."' AND t1.tipo = 'L'"; 
		$consulta.= " AND (t3.cod_leyes IN ('02','04','05') OR ISNULL(t3.cod_leyes))";
		$consulta.= " GROUP BY t1.fecha, t1.referencia, t1.num_horno, t1.num_funda,t1.hornada_total,t1.hornada_parcial, t3.cod_leyes";
		$consulta.= " ORDER BY t1.fecha, t1.referencia, t1.num_horno, t1.num_funda,t1.hornada_total,t1.hornada_parcial, t3.cod_leyes";	
		//echo $consulta."<br><br>";					
		mysqli_query($link, $consulta); //Se executa para llenar las tablas.			
	}
	$consulta = "SELECT t1.fecha, t1.num_lixiviacion AS referencia, hornada,t1.peso_seco AS peso, t1.cod_leyes, t1.valor, t1.conversion AS unidad, t1.fino";
	$consulta.= " FROM pmn_web.resultado_productos AS t1";
	$consulta.= " WHERE YEAR(t1.fecha) = '".$ano1."' AND MONTH(t1.fecha) = '".$mes1."'";
	$consulta.= " AND t1.cod_producto = '".$cmbproducto."' AND t1.cod_subproducto = '".$cmbsubproducto."' AND t1.tipo_mov = '".$cmbmovimiento."'";							
	$consulta.= " ORDER BY t1.num_lixiviacion, t1.hornada, t1.fecha, t1.cod_leyes";
	//echo $consulta."<br>";

	//---.
	$Finos = array('02'=>0, '04'=>0, '05'=>0); //La Posicion Cero(0), es para almacenar el peso. 
	$Unidad = array('02'=>100, '04'=>1000, '05'=>1000);
	$TotalPesoHumedo = 0;
	$TotalPesoSeco = 0;
	$TotalHumedad = 0;
	$TotalTotal = 0;
	$CantidadReg = 0; 
	//---.
	$ReferenciaAnt = "";
	$HornadaAnt = "";
	$Cont = 0;
	$rs = mysqli_query($link, $consulta);	
	while($row = mysqli_fetch_array($rs))
	{
		if ($ReferenciaAnt != $row[referencia])
		{
			$ReferenciaAnt = $row[referencia];
			$HornadaAnt = "";			
			$consulta = "SELECT IFNULL(COUNT(DISTINCT hornada,fecha),0) AS filas";
			$consulta.= " FROM pmn_web.resultado_productos AS t1";
			$consulta.= " WHERE t1.fecha BETWEEN '".$ano1."-".$mes1."-01' AND '".$ano1."-".$mes1."-31' AND t1.cod_producto = '".$cmbproducto."'";
			$consulta.= " AND t1.cod_subproducto = '".$cmbsubproducto."' AND t1.tipo_mov = '".$cmbmovimiento."' and t1.num_lixiviacion = '".$row[referencia]."'";
			//echo $consulta."<br>";			
			$rs1 = mysqli_query($link, $consulta);
			$row1 = mysqli_fetch_array($rs1);
			$TotalFilas = $row1[filas];
			$ContAux = 0;
			$consulta = "SELECT IFNULL(SUM(peso_seco),0) AS total";
			$consulta.= " FROM pmn_web.resultado_productos AS t1";
			$consulta.= " WHERE t1.fecha BETWEEN '".$ano1."-".$mes1."-01' AND '".$ano1."-".$mes1."-31' AND t1.cod_producto = '".$cmbproducto."'";
			$consulta.= " AND t1.cod_subproducto = '".$cmbsubproducto."' AND t1.tipo_mov = '".$cmbmovimiento."' and t1.num_lixiviacion = '".$row[referencia]."'";
			$consulta.= " AND (cod_leyes = '02' or ISNULL(cod_leyes))";
			$rs2 = mysqli_query($link, $consulta);
			$row2 = mysqli_fetch_array($rs2);
			$Total = $row2["total"];
			$sw = true;
			echo '<tr>';
			echo '<td align="center" rowspan="'.$TotalFilas.'">'.$row[referencia].'</td>';
			//Produccion.
			$consulta = "SELECT  fecha, bad FROM pmn_web.lixiviacion_barro_anodico";
			$consulta.= " WHERE num_lixiviacion = '".$row[referencia]."'";
			$cosnulta.= " ORDER BY num_lxiviacion, fecha DESC";
			$rs3 = mysqli_query($link, $consulta);
			$row3 = mysqli_fetch_array($rs3);
			$Prod = $row3[bad];
			
			echo '<td align="center" rowspan="'.$TotalFilas.'">'.number_format($Prod,3,",","").'</td>';
			
			//Beneficio Meses Anterior.
			$consulta = "SELECT IFNULL(SUM(bad),0) AS benef FROM pmn_web.detalle_deselenizacion";
			$consulta.= " WHERE referencia = '".$row[referencia]."' AND fecha BETWEEN '".$row3["fecha"]."' AND SUBDATE('".$ano1."-".$mes1."-31', INTERVAL 1 MONTH) ";
			$rs4 = mysqli_query($link, $consulta);
			$row4 = mysqli_fetch_array($rs4);
			$BenefAnt = $row4[benef];
			
			$TotalDisp  = $Prod - $BenefAnt - $Total;
			
		}

		if ($HornadaAnt != $row["hornada"].$row["fecha"])
		{
			$HornadaAnt = $row["hornada"].$row["fecha"];
			$ContAux++;
			
			echo '<td align="center">'.$row["hornada"].'</td>';
			echo '<td align="center">'.$row["fecha"].'</td>';			
			echo '<td align="right">'.number_format($row["peso"],3,",","").'</td>';
			
			//---.
			$TotalPesoSeco = $TotalPesoSeco + $row["peso"];			
			//---.			
		}
		if ($sw == true)
		{					
			echo '<td rowspan="'.$TotalFilas.'" align="right">'.number_format($Total,3,",","").'</td>';
			echo '<td rowspan="'.$TotalFilas.'" align="right">'.number_format($TotalDisp,3,",","").'</td>';
			$TotalTotal = $TotalTotal +  $TotalDisp;
			 $sw = false;			
		}
		if ($row["cod_leyes"] == "")
		{
			echo '<td>&nbsp;</td>';
			echo '<td>&nbsp;</td>';
			echo '<td>&nbsp;</td>';
			$Cont = 3;											
		}
		else
		{
			if ($TipoCalculo == "L")
				echo '<td align="right">'.number_format($row["valor"],2,",","").'</td>';		
			else
				echo '<td align="right">'.number_format($row[fino],3,",","").'</td>';
			$Cont++;			
			
			//---.
			$Finos[$row["cod_leyes"]] = $Finos[$row["cod_leyes"]] + $row[fino];			
			//---.			
		}
		if ($Cont == 3)
		{
			echo '</tr>';		
			$Cont = 0;
		}
	}
	//---.
	//TOTALES.
	echo '<tr class="Detalle02">';
	echo '<td align="left" colspan="4">TOTALES</td>';
	echo '<td align="right">'.number_format($TotalPesoSeco,3,",","").'</td>';
	echo '<td>&nbsp;</td>';
	echo '<td align="right">'.number_format($TotalTotal,3,",","").'</td>';
	//echo '<td>&nbsp;</td>';
	//echo '<td>&nbsp;</td>';	
	if ($TipoCalculo == "L")
	{
		if ($TotalPesoSeco == 0)
		{
			echo '<td align="right">0,000</td>';
			echo '<td align="right">0,000</td>';
			echo '<td align="right">0,000</td>';					
		}
		else
		{
			echo '<td align="right">'.number_format(($Finos['02'] / $TotalPesoSeco * $Unidad['02']),2,",","").'</td>';
			echo '<td align="right">'.number_format(($Finos['04'] / $TotalPesoSeco * $Unidad['04']),2,",","").'</td>';
			echo '<td align="right">'.number_format(($Finos['05'] / $TotalPesoSeco * $Unidad['05']),2,",","").'</td>';							
		}
	}
	else
	{
		echo '<td align="right">'.number_format($Finos['02'],3,",","").'</td>';
		echo '<td align="right">'.number_format($Finos['04'],3,",","").'</td>';
		echo '<td align="right">'.number_format($Finos['05'],3,",","").'</td>';	
	}
	echo '</tr>';	
	//---.	
?>
  </table>
</form>
</body>
</html>
