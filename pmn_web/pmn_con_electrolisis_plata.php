<?php
	include("../principal/conectar_pmn_web.php");
?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f= document.frm1;
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
	var f=document.frm1;
	f.action="pmn_xls_electrolisis_plata.php?FechaIni="+FechaI + "&FechaFin="+FechaT + "&Turno="+T;
	f.submit();
}

</script>
</head>

<body class="TituloCabeceraOz" leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="frm1" action="" method="post">
<?php
 	$FechaIni = $AnoIniCon."-".$MesIniCon."-".$DiaIniCon;
	$FechaFin = $AnoFinCon."-".$MesFinCon."-".$DiaFinCon;
?>
<table width="749" border="0" cellspacing="0" cellpadding="3">
    <tr> 
      
    <td width="477" align="center" valign="middle" class="titulo_azul"><strong>ELECTROLISIS DE PLATA</strong></td>
      <td width="76" align="center" valign="middle"><input name="BtnExcel" type="button" style="width:70px" value="Excel" onClick="Excel('<?php echo $FechaIni; ?>','<?php echo $FechaFin; ?>','<?php echo $Turno;  ?>');"></td>
      <td width="178" align="center" valign="middle"><div align="left">
          <input name="BtnImprimir" type="button" style="width:70px" onClick="Proceso('I');" value="Imprimir">
          <input type="button" name="BtnSalir" value="Salir" style="width:70px" onClick="Proceso('S');">
        </div></td>
    </tr>
  </table>

<br>
  <table width="1000" border="1" cellpadding="3" cellspacing="0" class="TituloCabeceraAzul">
    <tr class="ColorTabla01"> 
      <td width="73" rowspan="2" align="center">FECHA</td>
      <td width="37" rowspan="2" align="center">N&ordm; ELECT.</td>
      <td width="42" rowspan="2" align="center">GRUPO</td>
      <td width="80" rowspan="2" align="center">CORRELATIVO</td>
      <td colspan="2" align="center">ANODOS</td>
      <td width="43" rowspan="2" align="center">RESTO</td>
      <td width="74" rowspan="2" align="center">B. AURIFERO CRUDO <br>
        (Kgs h)</td>
      <td width="58" rowspan="2" align="center">Humedad (%)</td>
      <td colspan="6" align="center">ANALISIS QUIMICO</td>
      <td width="81" rowspan="2" align="center">OPERADOR</td>
      <td width="82" rowspan="2" align="center">JEFE TURNO</td>
    </tr>
    <tr class="ColorTabla01"> 
      <td width="57" height="20" align="center">CANTIDAD</td>
      <td width="39" align="center">PESO</td>
      <td width="37" align="center">Cu ppm</td>
      <td width="31" align="center">BI ppm</td>
      <td width="32" align="center">Fe ppm</td>
      <td width="31" align="center">Pb ppm</td>
      <td width="33" align="center">Se ppm</td>
      <td width="31" align="center">Cd ppm</td>
    </tr>
    <?php
	$consulta = "SELECT fecha, num_electrolisis, grupo, correlativo, SUM(cant_anodos) AS cant_anodos, SUM(peso_anodos) AS peso_anodos,";
	$consulta.= " operador, jefe_turno";
	$consulta.= " FROM pmn_web.carga_electrolisis_plata";
	$consulta.= " WHERE fecha BETWEEN '".$FechaIni."' AND '".$FechaFin."'";
	$consulta.= " GROUP BY fecha, num_electrolisis";	
	$consulta.= " ORDER BY fecha, num_electrolisis";
	//echo $consulta."<br>";
	$rs = mysqli_query($link, $consulta);
	while ($row = mysqli_fetch_array($rs))
	{
		echo '<tr>';
		echo '<td>'.substr($row["fecha"],8,2).'-'.substr($row["fecha"],5,2).'-'.substr($row["fecha"],0,4).'</td>';
		echo '<td>'.$row[num_electrolisis].'</td>';
		echo '<td>'.$row["grupo"].'</td>';
		echo '<td>'.$row[correlativo].'</td>';
		echo '<td align="right">'.number_format($row[cant_anodos],1,",","").'</td>';
		echo '<td align="right">'.number_format($row[peso_anodos],3,",","").'</td>';

		
		$consulta = "SELECT SUM(peso_resto) AS peso_resto, SUM(peso_aurifero) AS peso_aurifero, humedad";
		$consulta.= " FROM pmn_web.descarga_electrolisis_plata";
		$consulta.= " WHERE num_electrolisis = '".$row[num_electrolisis]."'";
		//$consulta.= " AND fecha BETWEEN '".$FechaIni."' AND '".$FechaFin."'";
		$consulta.= " GROUP BY num_electrolisis";
		//echo $consulta."<br>";
		$rs3 = mysqli_query($link, $consulta);	
		$row3 = mysqli_fetch_array($rs3);

		echo '<td align="right">'.number_format($row3[peso_resto],3,",","").'</td>';		
		echo '<td align="right">'.number_format($row3[peso_aurifero],3,",","").'</td>';
		echo '<td align="right">'.number_format($row3[humedad],2,",","").'</td>';		
		
		//LEYES.
		$leyes = array('02'=>'', '27'=>'', '31'=>'', '39'=>'', '40'=>'', '58'=>''); //Cu-Bi-Fe-Pb-Se-Cd.
		$consulta = "SELECT t2.cod_leyes, CASE WHEN isnull(valor) THEN 'ND' ELSE valor END AS valor";
		$consulta.= " FROM cal_web.solicitud_analisis AS t1";
		$consulta.= " INNER JOIN cal_web.leyes_por_solicitud AS t2";
		$consulta.= " ON t1.nro_solicitud = t2.nro_solicitud AND t1.fecha_hora = t2.fecha_hora";
		$consulta.= " AND t1.id_muestra = t2.id_muestra";
		$consulta.= " WHERE  t1.cod_producto = '29' AND t1.cod_subproducto = '4'";
		$consulta.= " AND t1.id_muestra LIKE '%".$row[num_electrolisis]."%' AND t1.cod_periodo = '1' AND t1.agrupacion = '5'";		
		$consulta.= " AND t2.cod_leyes IN ('02', '27', '31', '39', '40', '58')";
		//echo $consulta."<br>";
		$rs3 = mysqli_query($link, $consulta);
		while ($row3 = mysqli_fetch_array($rs3))
		{
			$leyes[$row3["cod_leyes"]] = $row3["valor"];
		}
		
		reset($leyes);
		while (list($c,$v) = each($leyes))
		{
			echo '<td align="right">'.number_format($v,2,",","").'</td>';		
		}		
		
		$consulta = "SELECT * FROM proyecto_modernizacion.funcionarios";
		$consulta.= " WHERE rut = '".$row[operador]."'";
		$rs1 = mysqli_query($link, $consulta);
		$row1 = mysqli_fetch_array($rs1);		
		echo '<td>'.strtoupper(substr($row1["nombres"],0,1)).". ".ucwords(strtolower($row1["apellido_paterno"])).'</td>';
		
		$consulta = "SELECT * FROM proyecto_modernizacion.funcionarios";
		$consulta.= " WHERE rut = '".$row[jefe_turno]."'";				
		$rs2 = mysqli_query($link, $consulta);
		$row2 = mysqli_fetch_array($rs2);		
		echo '<td>'.strtoupper(substr($row2["nombres"],0,1)).". ".ucwords(strtolower($row2["apellido_paterno"])).'</td>';
		echo '</tr>';
	}
?>
  </table>
</form>
</body>
</html>
