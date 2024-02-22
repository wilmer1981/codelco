<?php
	        ob_end_clean();
        $file_name=basename($_SERVER['PHP_SELF']).".xls";
        $userBrowser = $_SERVER['HTTP_USER_AGENT'];
        if ( preg_match( '/MSIE/i', $userBrowser ) ) {
        $filename = urlencode($filename);
        }
        $filename = iconv('UTF-8', 'gb2312', $filename);
        $file_name = str_replace(".php", "", $file_name);
        header("<meta http-equiv='X-UA-Compatible' content='IE=Edge'>");
        header("<meta http-equiv='content-type' content='text/html;charset=uft-8'>");
        
        header("content-disposition: attachment;filename={$file_name}");
        header( "Cache-Control: public" );
        header( "Pragma: public" );
        header( "Content-type: text/csv" ) ;
        header( "Content-Dis; filename={$file_name}" ) ;
        header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	$CodigoDeSistema = 8;
	$Eje = "Ejes".$Romana;
	$conexion = odbc_connect($Eje,"","","");
?>
<html>
<head>
<title>Sistema de Recepci&oacute;n</title>
<link href="../principal/estilos/css_sipa_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "S":
			window.history.back();
			break;
	}
}
</script>
</head>

<body background="../Principal/imagenes/fondo3.gif">
<form name="frmPrincipal" action="" method="post">
  <table width="700" border="0" cellspacing="1" cellpadding="1" class="TablaInterior">
    <tr> 
      <td width="110">Fecha Consulta:</td>
      <td width="456"> &nbsp; 
        <?php
	echo $DiaIni."/".$MesIni."/".$AnoIni." AL ";
	echo $DiaFin."/".$MesFin."/".$AnoFin;
	?>
      </td>
      <td width="121" align="center"> <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px;" onClick="Proceso('S')"> 
      </td>
    </tr>
  </table>
<br></table>
  <table width="2800" border="1" cellspacing="0" cellpadding="2" class="TablaDetalle">
    <tr align="center" class="ColorTabla01"> 
      <td width="72" rowspan="2">ROMANA</td>
      <td width="72" rowspan="2">NUMERO</td>
      <td width="83" rowspan="2">CODIGO</td>
      <td width="74" rowspan="2">PATENTE</td>
      <td width="60" rowspan="2">TIPO</td>
      <td width="60" rowspan="2">LARGO</td>
      <td width="218" rowspan="2">PRODUCTO</td>
      <td width="233" rowspan="2">EMPRESA</td>
      <td width="88" rowspan="2">GUIA</td>
      <td width="83" rowspan="2">HORA</td>
      <td width="92" rowspan="2">FECHA</td>
      <td width="102" rowspan="2">PESO BRUTO</td>
      <td width="87" rowspan="2">PESO TARA</td>
      <td width="83" rowspan="2">PESO NETO</td>
      <td width="79" rowspan="2">SOBREPESO</td>
      <td colspan="2">EJE 01</td>
      <td colspan="2">EJE 02</td>
      <td colspan="2">EJE 03</td>
      <td colspan="2">EJE 04</td>
      <td colspan="2">EJE 05</td>
      <td colspan="2">EJE 06</td>
      <td colspan="2">EJE 07</td>
      <td colspan="2">EJE 08</td>
    </tr>
    <tr> 
      <td width="83" align="center">PESO EJE</td>
      <td width="82" align="center">PESO TAN</td>
      <td width="73" align="center">PESO EJE</td>
      <td width="90" align="center">PESO TAN</td>
      <td width="76" align="center">PESO EJE</td>
      <td width="80" align="center">PESO TAN</td>
      <td width="75" align="center">PESO EJE</td>
      <td width="83" align="center">PESO TAN</td>
      <td width="68" align="center">PESO EJE</td>
      <td width="70" align="center">PESO TAN</td>
      <td width="58" align="center">PESO EJE</td>
      <td width="77" align="center">PESO TAN</td>
      <td width="91" align="center">PESO EJE</td>
      <td width="102" align="center">PESO TAN</td>
      <td width="70" align="center">PESO EJE</td>
      <td width="91" align="center">PESO TAN</td>
    </tr>
    <?php
	IF ($Romana != "2")
		{
		$nombre ="215";
		}
		else
		{
		$nombre ="216";
		}

	$FechaIni = $AnoIni."-".$MesIni."-".$DiaIni;
	$FechaFin = $AnoFin."-".$MesFin."-".$DiaFin;	
	$Consulta = "SELECT t1.NUMERO, t1.CODIGO, t1.PATENTE,t1.TIPO, t1.LARGO, t1.PRODUCTO, t1.EMPRESA, t1.GUIA, ";
	$Consulta.= " t1.HORA, t1.FECHA, t1.BRUTO, t1.TARA, t1.NETO, t1.SOBREPESO, ";
	$Consulta.= " t2.NROEJE, t2.TIPEJE, t2.PESEJE, t2.LIMEJE, t2.NROTAN, t2.TPOTAN, t2.PESTAN, LIMTAN ";
	$Consulta.= " from pesajes t1 inner join PsjeEjes t2 on t1.NUMERO = t2.NUMERO and t1.FECHA = t2.FECHA ";
	$Consulta.= " where t1.FECHA between #".$FechaIni."# and #".$FechaFin."#";	
	$Consulta.= " order by t1.NUMERO, t2.NROEJE ";
	$Respuesta = odbc_exec($conexion,$Consulta);
	$NumAnt = "";
	while (odbc_fetch_row($Respuesta))
	{	
		if ($NumAnt != intval(odbc_result($Respuesta, 'NUMERO')))	
		{
			//CAMION
			if ($NumAnt != "")
				echo "</tr>\n";
			echo "<tr>\n";
			echo "<td>".$nombre."&nbsp;</td>\n";
			echo "<td>".intval(odbc_result($Respuesta, 'NUMERO'))."&nbsp;</td>\n";
			echo "<td>".odbc_result($Respuesta, 'CODIGO')."&nbsp;</td>\n";
			echo "<td>".odbc_result($Respuesta, 'PATENTE')."&nbsp;</td>\n";
			echo "<td>".odbc_result($Respuesta, 'TIPO')."&nbsp;</td>\n";
			echo "<td align='center'>".odbc_result($Respuesta, 'LARGO')."&nbsp;</td>\n";
			echo "<td>".odbc_result($Respuesta, 'PRODUCTO')."&nbsp;</td>\n";
			echo "<td>".odbc_result($Respuesta, 'EMPRESA')."&nbsp;</td>\n";
			echo "<td align='right'>".odbc_result($Respuesta, 'GUIA')."&nbsp;</td>\n";
			echo "<td align='right'>".odbc_result($Respuesta, 'HORA')."&nbsp;</td>\n";
			echo "<td>".odbc_result($Respuesta, 'FECHA')."&nbsp;</td>\n";
			echo "<td align='right'>".intval(odbc_result($Respuesta, 'BRUTO'))."&nbsp;</td>\n";
			echo "<td align='right'>".intval(odbc_result($Respuesta, 'TARA'))."&nbsp;</td>\n";
			echo "<td align='right'>".intval(odbc_result($Respuesta, 'NETO'))."&nbsp;</td>\n";
			echo "<td align='right'>".intval(odbc_result($Respuesta, 'SOBREPESO'))."&nbsp;</td>\n";
			//EJES (PRIMER EJE)
			echo "<td align='right'>".intval(odbc_result($Respuesta, 'PESEJE'))."&nbsp;</td>\n";
			echo "<td align='right'>".intval(odbc_result($Respuesta, 'PESTAN'))."&nbsp;</td>\n";
		}
		else
		{			
			//EJES
			echo "<td align='right'>".intval(odbc_result($Respuesta, 'PESEJE'))."&nbsp;</td>\n";
			echo "<td align='right'>".intval(odbc_result($Respuesta, 'PESTAN'))."&nbsp;</td>\n";			
		}
		$NumAnt = intval(odbc_result($Respuesta, 'NUMERO'));
	}
	odbc_close_all();
?>
  </table>
</form>
</body>
</html>
