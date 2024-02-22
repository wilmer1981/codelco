<?php
	include("../principal/conectar_pmn_web.php");
?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
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
	f.action="pmn_xls_escoria_fusion.php?FechaIni="+FechaI + "&FechaFin="+FechaT + "&Turno="+T;
	f.submit();
}

</script>
</head>

<body background="../Principal/imagenes/fondo3.gif" leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="frm1" action="" method="post">
<?php
 	$FechaIni = $AnoIniCon."-".$MesIniCon."-".$DiaIniCon;
	$FechaFin = $AnoFinCon."-".$MesFinCon."-".$DiaFinCon;
?>
<table width="749" border="0" cellspacing="0" cellpadding="3">
    <tr> 
      
      <td width="477" align="center" valign="middle"><strong>ESCORIA FUSION H. 
        TROF </strong></td>
      <td width="76" align="center" valign="middle"><input name="BtnExcel" type="button" style="width:70px" value="Excel" onClick="Excel('<?php echo $FechaIni; ?>','<?php echo $FechaFin; ?>','<?php echo $Turno;  ?>');"></td>
      <td width="178" align="center" valign="middle"><div align="left">
          <input name="BtnImprimir" type="button" style="width:70px" onClick="Proceso('I');" value="Imprimir">
          <input type="button" name="BtnSalir" value="Salir" style="width:70px" onClick="Proceso('S');">
        </div></td>
    </tr>
  </table>
  <br>
  <table width="850" border="1" cellspacing="0" cellpadding="0" class="TablaDetalle">
    <tr class="ColorTabla01"> 
      <td width="78" align="center">Fecha Prod.</td>
      <td width="75" align="center">Lote</td>
      <td width="80" align="center">N&ordm; Cajon</td>
      <td width="102" align="center">Peso</td>
      <td width="86" align="center">Fecha Venta</td>
      <td width="58" align="center">H2O<br>
        %</td>
      <td width="55" align="center">Cu<br>
        %</td>
      <td width="69" align="center">Ag<br>
        Kg/Ton.</td>
      <td width="65" align="center">Au<br>
        Kg/Ton.</td>
      <td width="53" align="center">As<br>
        %</td>
      <td width="52" align="center">Sb<br>
        %</td>
      <td width="50" align="center">Pb<br>
        %</td>
    </tr>
    <?php	
	$consulta = "SELECT * FROM pmn_web.produccion_subproductos";
	$consulta.= " WHERE cod_producto = '28' AND cod_subproducto = '1'";
	$consulta.= " AND fecha_produccion BETWEEN '".$FechaIni."' AND '".$FechaFin."'";
	$consulta.= " ORDER BY CEILING(id_analisis), CEILING(numero)";
	//echo $consulta."<br>";
	$rs = mysqli_query($link, $consulta);
	while ($row = mysqli_fetch_array($rs))
	{
    	echo '<tr>';
      	echo '<td height="20" align="center">'.substr($row[fecha_produccion],8,2).'-'.substr($row[fecha_produccion],5,2).'-'.substr($row[fecha_produccion],0,4).'</td>';
      	echo '<td align="center">'.$row[id_analisis].'</td>';
      	echo '<td align="center">'.$row["numero"].'</td>';
      	echo '<td align="right">'.number_format($row["peso"],4,",","").'</td>';
		
		if ($row[fecha_venta] == '0000-00-00')
	      	echo '<td align="center">&nbsp;</td>';		
		else
    	  	echo '<td align="center">'.substr($row[fecha_venta],8,2).'-'.substr($row[fecha_venta],5,2).'-'.substr($row[fecha_venta],0,4).'</td>';
		
		//LEYES.
		$leyes = array('01'=>'', '02'=>'', '04'=>'','05'=>'','08'=>'', '09'=>'','39'=>'');				
		
		$consulta = "SELECT t2.cod_leyes, CASE WHEN isnull(valor) THEN 'ND' ELSE valor END AS valor";
		$consulta.= " FROM cal_web.solicitud_analisis AS t1";
		$consulta.= " INNER JOIN cal_web.leyes_por_solicitud AS t2";
		$consulta.= " ON t1.nro_solicitud = t2.nro_solicitud AND t1.fecha_hora = t2.fecha_hora";
		$consulta.= " AND t1.id_muestra = t2.id_muestra AND t1.recargo = t2.recargo";
		$consulta.= " WHERE  t1.cod_producto = '".$row["cod_producto"]."' AND t1.cod_subproducto = '".$row["cod_subproducto"]."'";
		$consulta.= " AND t1.id_muestra = '".$row[id_analisis]."' AND t1.cod_periodo = '1'";		
		$consulta.= " AND t2.cod_leyes IN ('01', '02', '04', '05', '08', '09', '39')";
		$consulta.= " AND !(t2.recargo = 'R')";		
		
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
	}
?>
  </table>
</form>
</body>
</html>     