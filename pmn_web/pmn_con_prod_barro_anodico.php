<?php
	include("../principal/conectar_pmn_web.php");
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f= document.frmPrincipal;
	switch (opt)
	{
		case "I":
			window.print();
			break;
		case "S":
			window.history.back();
			break;
	}
}
function Excel(FechaI,FechaT,T)
{
	var f=document.frmPrincipal;
	f.action="pmn_xls_prod_barro_anodico.php?FechaIni="+FechaI + "&FechaFin="+FechaT + "&Turno="+T;
	f.submit();
}

</script>
</head>

<body class="TituloCabeceraOz" leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form action="" method="post" name="frmPrincipal">
  <?php
  $FechaIni = $AnoIniCon."-".$MesIniCon."-".$DiaIniCon;
  $FechaFin = $AnoFinCon."-".$MesFinCon."-".$DiaFinCon;
  ?>
  <table width="665" border="0" cellspacing="0" cellpadding="3">
    <tr> 
      <td width="386" align="center" valign="middle" class="titulo_azul"><strong>PRODUCCION BARRO 
        ANODICO DESCOBRIZADO</strong> </td>
      <td width="167" align="center" valign="middle"><input name="BtnExcel" type="button" style="width:70px" value="Excel" onClick="Excel('<?php echo $FechaIni; ?>','<?php echo $FechaFin; ?>','<?php echo $Turno;  ?>');">
        &nbsp; 
        <input name="BtnImprimir" type="button" style="width:70px" onClick="Proceso('I');" value="Imprimir"> 
      </td>
      <td width="94" align="center" valign="middle"><input type="button" name="BtnSalir" value="Salir" style="width:70px" onClick="Proceso('S');"></td>
    </tr>
  </table>
<strong> <br>
<br>
</strong> 
  <table width="1136" border="1" cellspacing="0" cellpadding="3" class="TablaDetalle">
    <tr align="center" valign="middle" class="TituloCabeceraAzul"> 
      <td >LIXIV.</td>
      <td rowspan="2">N&ordm; Lix</td>
      <td>ACIDO</td>
      <td rowspan="2">FECHA CARGA</td>
      <td rowspan="2">HORA CARGA</td>
      <td rowspan="2">FECHA ANALISIS</td>
      <td rowspan="2">HORA <br>
        ANALISIS</td>
      <td rowspan="2">% Cu</td>
      <td rowspan="2">%H<sub>2</sub>O</td>
      <td rowspan="2" align="center">FECHA FILTRACION</td>
      <td >HORA</td>
      <td >PROD.</td>
      <td colspan="3">ANALISIS QUIMICO</td>
      <td  rowspan="2">JEFE DE <br>
        TURNO</td>
      <td  rowspan="2">OPERADOR</td>
    </tr>
    <tr class="TituloCabeceraAzul"> 
      <td  align="center" valign="middle" class="TituloCabeceraAzul">N&ordm;</td>
      <td align="center" valign="middle">LTS.</td>
      <td align="center" valign="middle">FILTR.</td>
      <td align="center" valign="middle">PESO HDO</td>
      <td align="center">Cu</td>
      <td align="center">Ag</td>
      <td align="center">Au</td>
    </tr>
    <?php 
	$Consulta = "select * from pmn_web.lixiviacion_barro_anodico ";
	$Consulta.= " where fecha between '".$FechaIni."' and '".$FechaFin."' ";
	/*if ($Turno != "S")
		$Consulta.= " and turno = '".$Turno."'";*/
	$Consulta.= " order by fecha,num_lixiviacion ";
	$Respuesta = mysqli_query($link, $Consulta);
	$FechaAnt = "";
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		echo "<tr>\n";
		/*if ($FechaAnt != $Row["fecha"])	
		{	
			$Consulta = "select count(*) as total from pmn_web.lixiviacion_barro_anodico ";
			$Consulta.= " where fecha = '".$Row["fecha"]."' ";
			if ($Turno != "S")
				$Consulta.= " and turno = '".$Turno."'";
			$Consulta.= " order by fecha, turno ";
			$Resp2 = mysqli_query($link, $Consulta);
			$Row2 = mysqli_fetch_array($Resp2);
			$TotalFilas = $Row2["total"];*/
			
		//}
		/*switch ($Row[turno])
		{
			case 1:
				echo "<td align='center'>A</td>\n";
				break;
			case 2:
				echo "<td align='center'>B</td>\n";
				break;
			case 3:
				echo "<td align='center'>C</td>\n";
				break;
		}*/		
		echo "<td align='center'>".$Row[num_lixiviacion]."</td>\n";
		echo "<td align='center'>".$Row[lixiviador]."</td>";
		echo "<td align='right'>".round($Row[acidc],0)."</td>\n";
		echo "<td align='center'>".substr($Row[fecha_carga],8,2)."/".substr($Row[fecha_carga],5,2)."/".substr($Row[fecha_carga],0,4)."</td>\n";
		echo "<td align='center'>".substr($Row[hora_carga],0,5)."</td>\n";
		echo "<td align='center' style='width:90'>".substr($Row[fecha_analisis],8,2)."/".substr($Row[fecha_analisis],5,2)."/".substr($Row[fecha_analisis],0,4)."</td>\n";
		echo "<td align='center'>".substr($Row[hora_analisis],0,5)."</td>\n";
		echo "<td align='right'>".$Row[porc_cobre]."</td>\n";
		echo "<td align='right'>".$Row[porc_agua]."</td>\n";
		echo "<td align='center' style='width:90'>".substr($Row[fecha_filtracion],8,2)."/".substr($Row[fecha_filtracion],5,2)."/".substr($Row[fecha_filtracion],0,4)."</td>\n";
		echo "<td align='center'>".substr($Row[hora_filtracion],0,5)."</td>\n";
		echo "<td align='right'>".round($Row[bad],0)."</td>\n";
		
		//LEYES.
		$leyes = array('02'=>'', '04'=>'', '05'=>''); //Cu-Ag.
		$consulta = "SELECT t2.cod_leyes, CASE WHEN isnull(valor) THEN 'ND' ELSE valor END AS valor";
		$consulta.= " FROM cal_web.solicitud_analisis AS t1";
		$consulta.= " INNER JOIN cal_web.leyes_por_solicitud AS t2";
		$consulta.= " ON t1.nro_solicitud = t2.nro_solicitud AND t1.fecha_hora = t2.fecha_hora";
		$consulta.= " AND t1.id_muestra = t2.id_muestra";
		$consulta.= " WHERE  t1.cod_producto = '25' AND t1.cod_subproducto = '1'";
		$consulta.= " AND t1.id_muestra = '".$Row[num_lixiviacion]."' AND t1.cod_periodo = '1' AND t1.agrupacion = '4'";		
		$consulta.= " AND t2.cod_leyes IN ('02', '04', '05')";
		//echo $consulta."<br>";
		$rs3 = mysqli_query($link, $consulta);
		while ($row3 = mysqli_fetch_array($rs3))
		{
			$leyes[$row3["cod_leyes"]] = $row3["valor"];
		}
		
		reset($leyes);
		while (list($c,$v) = each($leyes))
		{
			if ($v == 'ND')
				echo '<td align="right">'.$v.'</td>';
			else
				echo '<td align="right">'.number_format($v,2,",","").'</td>';		
		}					
		
		$Consulta = "select * from proyecto_modernizacion.funcionarios where rut = '".$Row[jefe_turno_analisis]."'";
		$Resp2 = mysqli_query($link, $Consulta);
		if ($Row2 = mysqli_fetch_array($Resp2))
			echo "<td align='left'>".strtoupper(substr($Row2["nombres"],0,1)).". ".ucwords(strtolower($Row2["apellido_paterno"]))."</td>\n";
		else
			echo "<td align='left'>&nbsp;</td>\n";
		$Consulta = "select * from proyecto_modernizacion.funcionarios where rut = '".$Row[operador_analisis]."'";
		$Resp2 = mysqli_query($link, $Consulta);
		if ($Row2 = mysqli_fetch_array($Resp2))
			echo "<td align='left'>".strtoupper(substr($Row2["nombres"],0,1)).". ".ucwords(strtolower($Row2["apellido_paterno"]))."</td>\n";
		else
			echo "<td align='left'>&nbsp;</td>\n";
		echo "</tr>\n";
		$FechaAnt = $Row["fecha"];
	}
?>
  </table>
</form>
</body>
</html>