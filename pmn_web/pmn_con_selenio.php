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
	f.action="pmn_xls_selenio.php?FechaIni="+FechaI + "&FechaFin="+FechaT + "&Turno="+T;
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
      
      <td width="477" align="center" valign="middle"><strong class="titulo_azul">SELENIO</strong></td>
      <td width="76" align="center" valign="middle"><input name="BtnExcel" type="button" style="width:70px" value="Excel" onClick="Excel('<?php echo $FechaIni; ?>','<?php echo $FechaFin; ?>','<?php echo $Turno;  ?>');"></td>
      <td width="178" align="center" valign="middle"><div align="left">
          <input name="BtnImprimir" type="button" style="width:70px" onClick="Proceso('I');" value="Imprimir">
          <input type="button" name="BtnSalir" value="Salir" style="width:70px" onClick="Proceso('S');">
        </div></td>
    </tr>
  </table>
  
  <br>
  <table width="1100" border="1" cellspacing="0" cellpadding="0" class="TituloCabeceraAzul">
    <tr class="ColorTabla01">
      <td width="82" align="center">Fecha Prod.</td>
      <td width="71" align="center">N&ordm; Lote</td>
      <td width="109" align="center">Peso</td>
      <td width="93" align="center">Fecha Venta</td>
      <td width="47" align="center">
<p>Se <br>
          % </p>
      </td>
      <td width="54" align="center">Cu<br>
        ppm</td>
      <td width="54" align="center">Fe<br>
        ppm</td>
      <td width="57" align="center">Ni<br>
        ppm</td>
      <td width="54" align="center">As<br>
        ppm</td>
      <td width="64" align="center">Sb<br>
        ppm</td>
      <td width="59" align="center">Pb<br>
        ppm</td>
      <td width="55" align="center">Te<br>
        ppm</td>
      <td width="48" align="center">S<br>
        %</td>
      <td width="51" align="center">H20<br>
        %</td>
      <td width="55" align="center">Au<br>
        g/t</td>
      <td width="56" align="center">Ag<br>
        g/t</td>
      <td width="54" align="center">H2S04<br>
        %</td>
    </tr>
<?php
	$consulta = "SELECT * FROM pmn_web.produccion_subproductos";
	$consulta.= " WHERE cod_producto = '31' AND cod_subproducto = '1'";
	$consulta.= " AND fecha_produccion BETWEEN '".$FechaIni."' AND '".$FechaFin."'";
	$consulta.= " ORDER BY CEILING(numero)";
	//echo $consulta."<br>";
	$rs = mysqli_query($link, $consulta);
	while ($row = mysqli_fetch_array($rs))
	{
    	echo '<tr>';
      	echo '<td height="20" align="center">'.substr($row[fecha_produccion],8,2).'-'.substr($row[fecha_produccion],5,2).'-'.substr($row[fecha_produccion],0,4).'</td>';
      	echo '<td align="center">'.$row["numero"].'</td>';
      	echo '<td align="right">'.number_format($row["peso"],4,",","").'</td>';
		
		if ($row[fecha_venta] == '0000-00-00')		
			echo '<td align="center">&nbsp;</td>';
		else
	      	echo '<td align="center">'.substr($row[fecha_venta],8,2).'-'.substr($row[fecha_venta],5,2).'-'.substr($row[fecha_venta],0,4).'</td>';
		
		//LEYES.
		$leyes = array('40'=>'', '02'=>'', '31'=>'', '36'=>'', '08'=>'', '09'=>'', '39'=>'', '44'=>'', '26'=>'', '01'=>'', '05'=>'','04'=>'','22'=>''); //Se-Cu-Fe-Ni-As-Sb-Pb-Te-S-H20-Au-Ag-H2S04.
		
		$consulta = "SELECT t2.cod_leyes, CASE WHEN isnull(valor) THEN 'ND' ELSE valor END AS valor";
		$consulta.= " FROM cal_web.solicitud_analisis AS t1";
		$consulta.= " INNER JOIN cal_web.leyes_por_solicitud AS t2";
		$consulta.= " ON t1.nro_solicitud = t2.nro_solicitud AND t1.fecha_hora = t2.fecha_hora";
		$consulta.= " AND t1.id_muestra = t2.id_muestra AND t1.recargo = t2.recargo AND t1.estado_actual <> 7";
		$consulta.= " WHERE  t1.cod_producto = '".$row["cod_producto"]."' AND t1.cod_subproducto = '".$row["cod_subproducto"]."'";
		$consulta.= " AND t1.id_muestra = '".$row["numero"]."' AND t1.cod_periodo = '1'";		
		$consulta.= " AND t2.cod_leyes IN ('40', '02', '31', '36', '08', '09', '39', '44', '26', '01', '05', '04', '22')";
		$consulta.= " AND !(t2.cod_leyes = '01' AND t2.recargo = '0')";
		//echo $consulta."<br>";
		$rs1 = mysqli_query($link, $consulta);
		while ($row1 = mysqli_fetch_array($rs1))
		{
			$leyes[$row1["cod_leyes"]] = $row1["valor"];
		}
		
		reset($leyes);
		while (list($c,$v) = each($leyes))
		{
			if ($v == 'ND')
				echo '<td align="right">'.$v.'</td>';
			else
				echo '<td align="right">'.number_format($v,3,",","").'</td>';		
		}		
				
		echo '</tr>';
	}
?>
  </table>
  <br>
</form>
</body>
</html>