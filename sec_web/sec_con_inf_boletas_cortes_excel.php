<?php
	        ob_end_clean();
        $file_name=basename($_SERVER['PHP_SELF']).".xls";
        $userBrowser = $_SERVER['HTTP_USER_AGENT'];
		$filename = "";
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
		include("../principal/conectar_principal.php"); 

		$cmbconsulta = isset($_REQUEST["cmbconsulta"])?$_REQUEST["cmbconsulta"]:"";
		$DiaIni = isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:date('d');
		$MesIni = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:date('m');
		$AnoIni = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:date('Y');
		$DiaFin = isset($_REQUEST["DiaFin"])?$_REQUEST["DiaFin"]:date('d');
		$MesFin = isset($_REQUEST["MesFin"])?$_REQUEST["MesFin"]:date('m');
		$AnoFin = isset($_REQUEST["AnoFin"])?$_REQUEST["AnoFin"]:date('Y');

		$Producto = isset($_REQUEST["Producto"])?$_REQUEST["Producto"]:"";
		$SubProducto = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";
		$NumSolicitud = isset($_REQUEST["NumSolicitud"])?$_REQUEST["NumSolicitud"]:"";

	/*
	if (!isset($DiaIni))
	{
		$DiaIni = date("d");
		$MesIni = date("m");
		$AnoIni = date("Y");
		$DiaFin = date("d");
		$MesFin = date("m");
		$AnoFin = date("Y");
	}
	*/
	if ($DiaIni < 10)
		$DiaIni = "0".$DiaIni;
	if ($MesIni < 10)
		$MesIni = "0".$MesIni;
	if ($DiaFin < 10)
		$DiaFin = "0".$DiaFin;
	if ($MesFin < 10)
		$MesFin = "0".$MesFin;

 	$FechaInicio = $AnoIni."-".$MesIni."-".$DiaIni;
	$FechaTermino = $AnoFin."-".$MesFin."-".$DiaFin;
?>
<html>
<head>
<title>Sistema Estadistico de Catodos</title>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
  <table width="750" border="0" align="center" cellpadding="2" cellspacing="0">
    <?php		
	if ($cmbconsulta == "8")
	{
		echo "<tr>\n";
		echo "<td width='78'>Producto</td>\n";
		echo "<td width='263'><SELECT name='Producto' style='width:250px;' onChange='Recarga()'>\n";     
		echo "<option SELECTed value='S'>Seleccionar</option>\n";
		$Consulta = "SELECT * from proyecto_modernizacion.productos order by descripcion";     
		$Respuesta = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Respuesta))                   
		{
			if ($Fila["cod_producto"] == $Producto)
				echo "<option SELECTed value='".$Fila["cod_producto"]."'>".$Fila["descripcion"]."</option>\n";
			else
				echo "<option value='".$Fila["cod_producto"]."'>".$Fila["descripcion"]."</option>\n";
		}
		echo "</SELECT></td>\n";
		echo "<td width='99'>SubProducto</td>\n";
		echo "<td width='241'><SELECT name='SubProducto' style='width:250px;' onChange='Recarga()'>\n";    
		echo "<option SELECTed value='S'>Seleccionar</option>\n";
		$Consulta = "SELECT * from proyecto_modernizacion.subproducto where cod_producto = '".$Producto."' order by descripcion";     
		$Respuesta = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Respuesta))                   
		{
			if ($Fila["cod_subproducto"] == $SubProducto)
				echo "<option SELECTed value='".$Fila["cod_subproducto"]."'>".$Fila["descripcion"]."</option>\n";
			else
				echo "<option value='".$Fila["cod_subproducto"]."'>".$Fila["descripcion"]."</option>\n";
		}        
		echo "</SELECT></td>\n";
		echo "</tr>\n";
	}
	if ($cmbconsulta == "9")
	{
		echo "<tr>\n";
		echo "<td>Nro. Solicitud:</td>\n";
		echo "<td><input name='NumSolicitud' size='10' type='text' value='".$NumSolicitud."'></td>\n";
		echo "<td>&nbsp;</td>\n";
		echo "<td>&nbsp;</td>\n";
		echo "</tr>\n";
	}
?>
    <tr align="center"> 
      <td colspan="10"><strong>INFORME DIGITACION BOLETAS DE PESAJE</strong></td>
    </tr>
  </table>
<br>
<table width="786" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="45">GRUPO</td>
    <td width="73">TIPO DESC.</td>
    <td width="86">NUM. CIRC.</td>
    <td width="96">HORA DESC.</td>
    <td width="80">KAH DIR. D</td>
    <td width="74">KAH INV. D</td>
    <td width="94">FECHA CONEX.</td>
    <td width="80">HORA CONEX.</td>
    <td width="63">KAH DIR.C</td>
    <td width="72">KAH INV.C</td>
  </tr>  
  <?php
	$Consulta = "SELECT * from sec_web.cortes_refineria t1 inner join sec_web.grupo_electrolitico2 t2 ";
	$Consulta.= " on t1.cod_grupo = t2.cod_grupo";
	$Consulta.= " where fecha_desconexion between '".$FechaInicio." 00:00:00' and '".$FechaTermino." 23:59:59' ";
	$Consulta.= " group by t1.cod_grupo,t1.tipo_desconexion order by fecha_desconexion";

	//$Consulta.= " order by fecha_desconexion";	
	$Respuesta = mysqli_query($link, $Consulta);
	$TotalCortes = 0;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		echo "<tr>\n";
		echo "<td align='center'>".$Fila["cod_grupo"]."</td>\n";
		echo "<td align='center'>".$Fila["tipo_desconexion"]."</td>\n";
		echo "<td align='center'>".$Fila["cod_circuito"]."</td>\n";
		echo "<td align='center'>".substr($Fila["fecha_desconexion"],11,5)."</td>\n";
		if (($Fila["kahdird"] == "") || is_null($Fila["kahdird"]))
			echo "<td align='right'>0</td>\n";
		else
			echo "<td align='right'>".$Fila["kahdird"]."</td>\n";
		if (($Fila["kahinvd"] == "") || is_null($Fila["kahinvd"]))
			echo "<td align='right'>0</td>\n";
		else
			echo "<td align='right'>".$Fila["kahinvd"]."</td>\n";
		echo "<td align='center'>".substr($Fila["fecha_desconexion"],8,2)."/".substr($Fila["fecha_desconexion"],5,2)."/".substr($Fila["fecha_desconexion"],0,4)."</td>\n";
		echo "<td align='center'>".substr($Fila["fecha_conexion"],11,5)."</td>\n";
		if (($Fila["kahdirc"] == "") || is_null($Fila["kahdirc"]))
			echo "<td align='right'>0</td>\n";
		else
			echo "<td align='right'>".$Fila["kahdirc"]."</td>\n";
		if (($Fila["kahinvc"] == "") || is_null($Fila["kahinvc"]))
			echo "<td align='right'>0</td>\n";
		else
			echo "<td align='right'>".$Fila["kahinvc"]."</td>\n";
		echo "</tr>\n";
		$TotalCortes++;
	}
	?>
	
  <tr> 
    <td colspan="10"><strong>TOTAL CORTES EN PERIODO <?php echo $DiaIni."/".$MesIni."/".$AnoFin." al ".$DiaFin."/".$MesFin."/".$AnoFin ?>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
      <?php echo $TotalCortes ?> </strong></td>
  </tr>
</table>
</form>
</body>
</html>
