<?php
	$CodigoDeSistema = 8;
	//$Eje = "Ejes".$Romana;
	//$conexion = odbc_connect($Eje,"","","");
	include("../principal/conectar_rec_web.php");

	if(isset($_REQUEST["DiaIni"])){
		$DiaIni=$_REQUEST["DiaIni"];
	}else{
		$DiaIni=date('d');
	}
	if(isset($_REQUEST["MesIni"])){
		$MesIni=$_REQUEST["MesIni"];
	}else{
		$MesIni=date('m');
	}
	if(isset($_REQUEST["AnoIni"])){
		$AnoIni=$_REQUEST["AnoIni"];
	}else{
		$AnoIni=date('Y');
	}

	if(isset($_REQUEST["DiaFin"])){
		$DiaFin=$_REQUEST["DiaFin"];
	}else{
		$DiaFin=date('d');
	}
	if(isset($_REQUEST["MesFin"])){
		$MesFin=$_REQUEST["MesFin"];
	}else{
		$MesFin=date('m');
	}
	if(isset($_REQUEST["AnoFin"])){
		$AnoFin=$_REQUEST["AnoFin"];
	}else{
		$AnoFin=date('Y');
	}
	if(isset($_REQUEST["Romana"])){
		$Romana=$_REQUEST["Romana"];
	}else{
		$Romana="";
	}

?>
<html>
<head>
<title>Sistema de Recepci&oacute;n (Pesaje de Ejes) </title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">

<?php
 //echo'<link href="../principal/estilos/css_sipa_web.css" rel="stylesheet" type="text/css">';
?>
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
	$Consulta.= " from rec_web.pesajes t1 inner join rec_web.detalle_pesajes t2 on t1.NUMERO = t2.NUMERO and t1.FECHA = t2.FECHA ";
	$Consulta.= " where t1.ROMANA = t2.ROMANA and t1.romana = '".$Romana."' and t1.FECHA between '".$FechaIni."'and '".$FechaFin."'";	
	$Consulta.= " order by t1.NUMERO, t2.NROEJE ";
	//echo $Consulta;
	$Respuesta = mysqli_query($link, $Consulta);
	$NumAnt = "";
	while ($Fila=mysqli_fetch_array($Respuesta))
	{	
		if ($NumAnt != intval($Fila["numero"]))	
		{
			//CAMION
			if ($NumAnt != "")
				echo "</tr>\n";
			echo "<tr>\n";
			echo "<td>".$nombre."&nbsp;</td>\n";
			echo "<td>".intval($Fila["numero"])."&nbsp;</td>\n";
			echo "<td>".$Fila["CODIGO"]."&nbsp;</td>\n";
			echo "<td>".$Fila["patente"]."&nbsp;</td>\n";
			echo "<td>".$Fila["tipo"]."&nbsp;</td>\n";
			echo "<td align='center'>".$Fila["LARGO"]."&nbsp;</td>\n";
			echo "<td>".$Fila["PRODUCTO"]."&nbsp;</td>\n";
			echo "<td>".$Fila["EMPRESA"]."&nbsp;</td>\n";
			echo "<td align='right'>".$Fila["guia"]."&nbsp;</td>\n";
			echo "<td align='right'>".$Fila["hora"]."&nbsp;</td>\n";
			echo "<td>".$Fila["fecha"]."&nbsp;</td>\n";
			echo "<td align='right'>".intval($Fila["BRUTO"])."&nbsp;</td>\n";
			echo "<td align='right'>".intval($Fila["TARA"])."&nbsp;</td>\n";
			echo "<td align='right'>".intval($Fila["NETO"])."&nbsp;</td>\n";
			echo "<td align='right'>".intval($Fila["SOBREPESO"])."&nbsp;</td>\n";
			//EJES (PRIMER EJE)
			echo "<td align='right'>".intval($Fila["PESEJE"])."&nbsp;</td>\n";
			echo "<td align='right'>".intval($Fila["PESTAN"])."&nbsp;</td>\n";
		}
		else
		{			
			//EJES
			echo "<td align='right'>".intval($Fila["PESEJE"])."&nbsp;</td>\n";
			echo "<td align='right'>".intval($Fila["PESTAN"])."&nbsp;</td>\n";			
		}
		$NumAnt = intval($Fila["numero"]);
	}

/*	reemplazado 24-05-2006  JCF

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
	*/
?>
  </table>
</form>
</body>
</html>
