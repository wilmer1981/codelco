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
<title>PMN - Consulta Tipo Mov.</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Abrir()
{	
	var f = frmListado;	
	if (confirm("Esta Seguro De Abrir El Mes, Para Ser Modificado"))
	{
		linea = "&FechaIni=" + f.FechaIni.value + "&FechaFin=" + f.FechaFin.value;
		linea = linea + "&cmbmovimiento=" + f.cmbmovimiento.value + "&cmbproducto=" + f.cmbproducto.value + "&cmbsubproducto=" + f.cmbsubproducto.value;
		linea = linea + "&ano1=" + f.ano1.value + "&mes1=" + f.mes1.value + "&TipoCalculo=" +f.TipoCalculo.value;
		window.open("ing_cierra_mes_popup.php?proceso=AL" + linea, "","top=200 left=200 menubar=no resizable=no width=403 height=205");		
	}
}
/******************/
function Guardar()
{
	var f = document.frmListado;
	
	if (confirm("Esta Seguro De Guardar Los Datos Para Cerrar"))	
	{	
		f.action = "pmn_con_balance_recepcion_metal_dore_florida.php?proceso=G";
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
    <td width="468" align="left">Recepcion Metal Dore Florida</td>
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
	else
	{
		echo '<input name="btnabrir" type="button" value="Abrir Mes" style="width:70" onClick="Abrir()">';
	}
?>	 	
	  <input name="btnimprimir" type="button" id="btnimprimir" value="Imprimr" style="width:70" onClick="Imprimir()"> 
      <input name="btnsalir" type="button" id="btnsalir" value="Salir" style="width:70" onClick="Salir()"> 
    </td>
  </tr>
</table>

<br>
<table width="1100" border="1" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr class="ColorTabla01"> 
    <td width="79" rowspan="2" align="center">Fecha</td>
    <td width="73" rowspan="2" align="center">N&ordm; Lote</td>
      <td width="63" rowspan="2" align="center">N&ordm; Anodo</td>
    <td width="83" rowspan="2" align="center">Id. Muestra</td>
	<td width="100" rowspan="2" align="center">Peso Bruto</td>
      <td width="103" rowspan="2" align="center">Peso Seco (Kg)</td>
    <td colspan="10" align="center">
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
    <td width="50" align="center">Cu<br>
      %</td>
    <td width="86" align="center">Ag<br>
        g/T </td>
    <td width="90" align="center">Au<br>
        g/T </td>
    <td width="47" align="center">Zn<br>
      %</td>
    <td width="47" align="center">Fe<br>
      %</td>
    <td width="51" align="center">Pt<br>
      ppm</td>
    <td width="54" align="center">Pd<br>
      ppm</td>
    <td width="49" align="center">Pb<br>
      %</td>
    <td width="46" align="center">Se<br>
      %</td>
    <td width="56" align="center">Cd<br>
      %</td>	
<?php
	}
	else
	{
?>
    <td width="50" align="center">Cu<br>
      Kg.</td>
    <td width="86" align="center">Ag<br>
      Kg.</td>
    <td width="90" align="center">Au<br>
      Kg.</td>
    <td width="47" align="center">Zn<br>
      Kg.</td>
    <td width="47" align="center">Fe<br>
      Kg.</td>
    <td width="51" align="center">Pt<br>
      Kg.</td>
    <td width="54" align="center">Pd<br>
      Kg.</td>
    <td width="49" align="center">Pb<br>
      Kg.</td>
    <td width="46" align="center">Se<br>
      Kg.</td>
    <td width="56" align="center">Cd<br>
      Kg.</td>
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
		$consulta.= " peso_humedo double(10,4), humedad double(10,4),  peso_seco double(10,4),";
		$consulta.= " bloquedo char(1), conversion int(10), num_caja varchar(20), hornada varchar(20),";
		$consulta.= " num_barra varchar(20), num_electrolisis varchar(20), num_anodos double(10,4),";
		$consulta.= " peso_total double(10,4), peso_muestra double(10,4), cod_leyes char(3), valor double(10,5), fino double(10,5))";
	
		
		$consulta.= " SELECT t1.fecha, '".$cmbmovimiento."' AS tipo_mov, '".$cmbproducto."' AS cod_producto, '".$cmbsubproducto."' AS cod_subproducto, '' AS correlativo,";	
		$consulta.= " t9.flujo, '' AS num_lixiviacion, '' AS lixiviador, t1.id_producto AS lote, t1.referencia AS tambor, t2.id_muestra,";
		$consulta.= " '' AS peso_humedo, '' AS humedad,  ROUND((t1.peso_bruto - t1.peso_resta) + 0.0001,3) AS peso_seco, 'N' AS bloqueado,";
		$consulta.= " CASE WHEN t3.cod_leyes IN ('04','05','37','38') THEN 1000000 ELSE 100 END AS conversion,";
		$consulta.= " '' AS num_caja, '' AS horanada, '' AS num_barra, '' AS num_electrolisis, '' AS num_anodos,";
		$consulta.= " '' AS peso_total, '' AS peso_muestra, t3.cod_leyes, t3.valor, ROUND((t3.valor * ROUND((t1.peso_bruto - t1.peso_resta) + 0.0001,3) / CASE WHEN t3.cod_leyes IN ('04','05','37','38') THEN 1000000 ELSE 100 END) + 0.0001,3) AS fino";								
		$consulta.= " FROM pmn_web.productos_externos t0 inner join pmn_web.detalle_productos_externos AS t1 on t0.id_producto=t1.id_producto ";
		$consulta.= " LEFT JOIN cal_web.solicitud_analisis AS t2";
		$consulta.= " ON t1.cod_producto = t2.cod_producto AND t1.cod_subproducto = t2.cod_subproducto";
		//$consulta.= " AND SUBSTRING(t2.observacion,1,6) = t1.id_producto";
		//$consulta.= " AND t1.referencia BETWEEN SUBSTRING(t2.observacion,10,2) AND SUBSTRING(t2.observacion,13,2)";
		$consulta.= " AND t0.lote_ventana=t2.id_muestra ";
		$consulta.= " AND t2.cod_periodo = '1' AND t2.agrupacion = '6'";
		$consulta.= " LEFT JOIN cal_web.leyes_por_solicitud AS t3";
		$consulta.= " ON t2.nro_solicitud = t3.nro_solicitud AND t2.id_muestra = t3.id_muestra";
		$consulta.= " AND t2.fecha_hora = t3.fecha_hora AND t2.rut_funcionario = t3.rut_funcionario";
		$consulta.= " AND t2.cod_producto = t3.cod_producto AND t2.cod_subproducto = t3.cod_subproducto";
		$consulta.= " LEFT JOIN pmn_web.relacion_flujo AS t9";
		$consulta.= " ON t9.cod_producto = '".$cmbproducto."' AND t9.cod_subproducto = '".$cmbsubproducto."' AND t9.tipo_mov = '".$cmbmovimiento."'";			
		$consulta.= " WHERE t1.cod_producto = '".$cmbproducto."' AND t1.cod_subproducto = '".$cmbsubproducto."'";
		$consulta.= " AND t1.fecha BETWEEN '".$FechaIni."' AND '".$FechaFin."'";
		$consulta.= " ORDER BY t1.fecha, t1.id_producto, t1.referencia, t3.cod_leyes";
		//echo $consulta."<br><br>";
	
		mysqli_query($link, $consulta); //Se executa para llenar las tablas.			
		
		//----.
		//Llena tabla resultado_productos.
		$consulta = "CREATE TABLE IF NOT EXISTS pmn_web.resultado_productos ";
		$consulta.= " (fecha date, tipo_mov char(3), cod_producto varchar(10), cod_subproducto varchar(10),";
		$consulta.= " correlativo int(10), flujo int(3), num_lixiviacion varchar(20), lixiviador varchar(20),";
		$consulta.= " lote varchar(20), tambor varchar(20), id_muestra varchar(20),";
		$consulta.= " peso_humedo double(10,4), humedad double(10,4),  peso_seco double(10,4),";
		$consulta.= " bloquedo char(1), conversion int(10), num_caja varchar(20), hornada varchar(20),";
		$consulta.= " num_barra varchar(20), num_electrolisis varchar(20), num_anodos double(10,4),";
		$consulta.= " peso_total double(10,4), peso_muestra double(10,4), cod_leyes char(3), valor double(10,5), fino double(10,5))";
				
		//Se Incluye datos de la otra tabla (Productos Por Movimientos).
		$consulta.= " SELECT t1.fecha, t1.tipo_mov, '".$cmbproducto."' AS cod_producto, '".$cmbsubproducto."' AS cod_subproducto, '' AS correlativo,";
		$consulta.= " t9.flujo, '' AS num_lixiviacion, '' AS lixiviador, '' AS lote, t1.id AS tambor, '' AS id_muestra,";
		$consulta.= " '' AS peso_humedo, '' AS humedad, CASE WHEN t1.signo = '-' THEN (-1 * t1.peso_seco) ELSE t1.peso_seco END AS peso_seco,";		
		$consulta.= " 'N' AS bloqueado,";		
		$consulta.= " CASE WHEN t2.cod_leyes = '02' THEN t1.unid_cu ELSE";
		$consulta.= " CASE WHEN t2.cod_leyes = '04' THEN t1.unid_ag ELSE";
		$consulta.= " CASE WHEN t2.cod_leyes = '05' THEN t1.unid_au END END END AS unidad,";
		$consulta.= " '' AS num_caja, '' AS hornada, '' AS num_barra, '' AS num_electrolisis, '' AS num_anodos,";					
		$consulta.= " '' AS peso_total, '' AS peso_muestra, t2.cod_leyes, ";				
		$consulta.= " CASE WHEN t2.cod_leyes = '02' THEN CASE WHEN t1.signo_cu = '-' THEN -1 * (t1.fino_cu * unid_cu / CASE WHEN t1.signo = '-' THEN -1 * t1.peso_seco ELSE t1.peso_seco END) ELSE (t1.fino_cu * unid_cu / CASE WHEN t1.signo = '-' THEN -1 * t1.peso_seco ELSE t1.peso_seco END) END";
		$consulta.= " ELSE CASE WHEN t2.cod_leyes = '04' THEN CASE WHEN t1.signo_ag = '-' THEN -1 * (t1.fino_ag * unid_ag / CASE WHEN t1.signo = '-' THEN -1 * t1.peso_seco ELSE t1.peso_seco END) ELSE (t1.fino_ag * unid_ag / CASE WHEN t1.signo = '-' THEN -1 * t1.peso_seco ELSE t1.peso_seco END) END";
		$consulta.= " ELSE CASE WHEN t2.cod_leyes = '05' THEN CASE WHEN t1.signo_au = '-' THEN -1 * (t1.fino_au * unid_au / CASE WHEN t1.signo = '-' THEN -1 * t1.peso_seco ELSE t1.peso_seco END) ELSE (t1.fino_au * unid_au / CASE WHEN t1.signo = '-' THEN -1 * t1.peso_seco ELSE t1.peso_seco END) END";
		$consulta.= " END END END AS valor,";		
		$consulta.= " CASE WHEN t2.cod_leyes = '02' THEN (CASE WHEN t1.signo_cu = '-' THEN -1 * t1.fino_cu ELSE t1.fino_cu END) ELSE CASE WHEN t2.cod_leyes = '04' THEN (CASE WHEN t1.signo_ag = '-' THEN -1 * t1.fino_ag ELSE t1.fino_ag END) ELSE CASE WHEN t2.cod_leyes = '05' THEN (CASE WHEN t1.signo_au = '-' THEN -1 * t1.fino_au ELSE t1.fino_au END) END END END AS fino";
					
		$consulta.= " FROM pmn_web.productos_por_movimientos AS t1";
		$consulta.= " LEFT JOIN proyecto_modernizacion.leyes AS t2";
		$consulta.= " ON t2.cod_leyes IN ('02', '04', '05')";
		$consulta.= " LEFT JOIN pmn_web.relacion_flujo AS t9";
		$consulta.= " ON t9.cod_producto = '".$cmbproducto."' AND t9.cod_subproducto = '".$cmbsubproducto."' AND t9.tipo_mov = t1.tipo_mov";				
		$consulta.= " WHERE t1.fecha BETWEEN '".$FechaIni."' AND '".$FechaFin."'";
		$consulta.= " AND t1.cod_producto = '".$cmbproducto."' AND t1.cod_subproducto = '".$cmbsubproducto."' AND t1.tipo_mov In ('".$cmbmovimiento."')";	
		$consulta.= " ORDER BY t1.id,t2.cod_leyes";
		//echo $consulta."<br><br><br>";		
		mysqli_query($link, $consulta);		
	}


	$consulta = "SELECT t1.fecha, t1.lote AS id_producto, t1.tambor AS referencia, t1.id_muestra,  t1.cod_leyes, t1.valor, t1.peso_seco AS peso, conversion AS unidad, t1.fino";
	$consulta.= " FROM pmn_web.resultado_productos AS t1 ";
	$consulta.= " WHERE YEAR(t1.fecha) = '".$ano1."' AND MONTH(t1.fecha) = '".$mes1."'";
	$consulta.= " AND t1.cod_producto = '".$cmbproducto."' AND t1.cod_subproducto = '".$cmbsubproducto."' AND t1.tipo_mov = '".$cmbmovimiento."'";
	$consulta.= " ORDER BY t1.fecha, t1.lote, CEILING(t1.tambor), t1.cod_leyes";		
	//echo $consulta."<br>";

	//---.
	$Finos = array('02'=>0, '04'=>0, '05'=>0, '10'=>0, '31'=>0, '37'=>0, '38'=>0, '39'=>0, '40'=>0, '58'=>0); //La Posicion Cero(0), es para almacenar el peso. 
	$Unidad = array('02'=>100, '04'=>1000000, '05'=>1000000, '10'=>100, '31'=>100, '37'=>1000000, '38'=>1000000, '39'=>100, '40'=>100, '58'=>100);
	$TotalPesoHumedo = 0;
	$TotalPesoSeco = 0;
	$TotalPesoBruto = 0;
	$TotalHumedad = 0;
	$CantidadReg = 0; 
	//---.
	
	$IdProductoAnt = "";
	$ReferenciaAnt = "";
	$Cont = 0;
	$rs = mysqli_query($link, $consulta);  
	while($row = mysqli_fetch_array($rs))
	{
	
		
		if (($IdProductoAnt != $row[id_producto]) or ($ReferenciaAnt != $row[referencia]))
		{
		/*POLY*/
			$consulta1 = "select * from pmn_web.detalle_productos_externos";
			$consulta1.=" where cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
			$consulta1.=" and fecha = '".$row["fecha"]."' and id_producto = '".$row[id_producto]."' and referencia = '".$row[referencia]."'";
			$rrw = mysqli_query($link, $consulta1);
			while($row9 = mysqli_fetch_array($rrw))
			{
				$pesob = $row9[peso_bruto];
			}	
			$IdProductoAnt = $row[id_producto];
			$ReferenciaAnt = $row[referencia];
		
			echo '<tr>';
			echo '<td>'.$row["fecha"].'</td>';
			if ($row[id_producto] == '')
			{
				echo '<td colspan="4">'.$row[referencia].'</td>';
			}
			else
			{
				echo '<td>'.$row[id_producto].'</td>';
				echo '<td>'.$row[referencia].'</td>';
				echo '<td align="center">'.$row["id_muestra"].'</td>';
				echo '<td align="right">'.number_format($pesob,4,",","").'</td>';
			}
			//poly agrego peso bruto//
				
		
			echo '<td align="right">'.number_format($row["peso"],3,",","").'</td>';
			
			//---.
			$TotalPesoSeco = $TotalPesoSeco + $row["peso"];
			$TotalPesoBruto = $TotalPesoBruto + $pesob;			
			//---.			
		}

		if ($row["cod_leyes"] == "")
		{
			echo '<td>&nbsp;</td>';
			echo '<td>&nbsp;</td>';
			echo '<td>&nbsp;</td>';
			echo '<td>&nbsp;</td>';
			echo '<td>&nbsp;</td>';
			echo '<td>&nbsp;</td>';
			echo '<td>&nbsp;</td>';
			echo '<td>&nbsp;</td>';
			echo '<td>&nbsp;</td>';
			echo '<td>&nbsp;</td>';			
		}
		else
		{		
			if ($TipoCalculo == "L")
			{
				if (($row["cod_leyes"] == '04') or ($row["cod_leyes"] == '05'))
					echo '<td align="right">'.number_format($row["valor"],0,",","").'</td>';
				else
					echo '<td align="right">'.number_format($row["valor"],3,",","").'</td>';
			}
			else
				echo '<td align="right">'.number_format($row[fino],3,",","").'</td>';
			$Cont++;
			
			//---.
			$Finos[$row["cod_leyes"]] = $Finos[$row["cod_leyes"]] + $row[fino];			
			//---.			
		}
				
		if ($Cont == 10)
		{
			echo '</tr>';
			$Cont = 0;
		}
	}
	
	//---.
	//TOTALES.
	echo '<tr class="Detalle02">';
	echo '<td align="left" colspan="4">TOTALES</td>';
	echo '<td align="right">'.number_format($TotalPesoBruto,3,",","").'</td>'; 
	echo '<td align="right">'.number_format($TotalPesoSeco,3,",","").'</td>';
	
	if ($TipoCalculo == "L")
	{
		if ($TotalPesoSeco == 0)
		{
			echo '<td align="right">0,000</td>';
			echo '<td align="right">0,000</td>';
			echo '<td align="right">0,000</td>';
			echo '<td align="right">0,000</td>';
			echo '<td align="right">0,000</td>';
			echo '<td align="right">0,000</td>';
			echo '<td align="right">0,000</td>';
			echo '<td align="right">0,000</td>';
			echo '<td align="right">0,000</td>';
			echo '<td align="right">0,000</td>';							
		}
		else
		{
			echo '<td align="right">'.number_format(($Finos['02'] / $TotalPesoSeco * $Unidad['02']),3,",","").'</td>';
			echo '<td align="right">'.number_format(($Finos['04'] / $TotalPesoSeco * $Unidad['04']),3,",","").'</td>';
			echo '<td align="right">'.number_format(($Finos['05'] / $TotalPesoSeco * $Unidad['05']),3,",","").'</td>';
			echo '<td align="right">'.number_format(($Finos['10'] / $TotalPesoSeco * $Unidad['10']),3,",","").'</td>';
			echo '<td align="right">'.number_format(($Finos['31'] / $TotalPesoSeco * $Unidad['31']),3,",","").'</td>';
			echo '<td align="right">'.number_format(($Finos['37'] / $TotalPesoSeco * $Unidad['37']),3,",","").'</td>';
			echo '<td align="right">'.number_format(($Finos['38'] / $TotalPesoSeco * $Unidad['38']),3,",","").'</td>';
			echo '<td align="right">'.number_format(($Finos['39'] / $TotalPesoSeco * $Unidad['39']),3,",","").'</td>';
			echo '<td align="right">'.number_format(($Finos['40'] / $TotalPesoSeco * $Unidad['40']),3,",","").'</td>';
			echo '<td align="right">'.number_format(($Finos['58'] / $TotalPesoSeco * $Unidad['58']),3,",","").'</td>';									
		}
	}
	else
	{	
		echo '<td align="right">'.number_format($Finos['02'],3,",","").'</td>';
		echo '<td align="right">'.number_format($Finos['04'],3,",","").'</td>';
		echo '<td align="right">'.number_format($Finos['05'],3,",","").'</td>';
		echo '<td align="right">'.number_format($Finos['10'],3,",","").'</td>';
		echo '<td align="right">'.number_format($Finos['31'],3,",","").'</td>';
		echo '<td align="right">'.number_format($Finos['37'],3,",","").'</td>';
		echo '<td align="right">'.number_format($Finos['38'],3,",","").'</td>';
		echo '<td align="right">'.number_format($Finos['39'],3,",","").'</td>';
		echo '<td align="right">'.number_format($Finos['40'],3,",","").'</td>';
		echo '<td align="right">'.number_format($Finos['58'],3,",","").'</td>';							
	}
	
	echo '</tr>';	
	//---.	
?>
</table>
</form>
</body>
</html>
