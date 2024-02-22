<?php         ob_end_clean();
        $file_name=basename($_SERVER['PHP_SELF']).".xls";
        $userBrowser = $_SERVER['HTTP_USER_AGENT'];
		$filename="";
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
	$CodigoDeSistema = 1;
	$CookieRut= $_COOKIE["CookieRut"];
	include("../principal/conectar_principal.php");
	$Rut =$CookieRut;

	if(isset($_REQUEST["LimitIni"])) {
		$LimitIni = $_REQUEST["LimitIni"];
	}else{
		$LimitIni = 0;
	}
	if(isset($_REQUEST["LimitFin"])) {
		$LimitFin = $_REQUEST["LimitFin"];
	}else{
		$LimitFin = 10;
	}
	
	if(isset($_REQUEST["DiaIni"])) {
		$DiaIni = $_REQUEST["DiaIni"];
	}else{
		$DiaIni = date("d");
	}
	if(isset($_REQUEST["MesIni"])) {
		$MesIni = $_REQUEST["MesIni"];
	}else{
		$MesIni = date("m");
	}
	if(isset($_REQUEST["AnoIni"])) {
		$AnoIni = $_REQUEST["AnoIni"];
	}else{
		$AnoIni = date("Y");
	}
	if(isset($_REQUEST["DiaFin"])) {
		$DiaFin = $_REQUEST["DiaFin"];
	}else{
		$DiaFin = date("d");
	}
	if(isset($_REQUEST["MesFin"])) {
		$MesFin = $_REQUEST["MesFin"];
	}else{
		$MesFin = date("m");
	}
	if(isset($_REQUEST["AnoFin"])) {
		$AnoFin = $_REQUEST["AnoFin"];
	}else{
		$AnoFin = date("Y");
	}
	
	if(isset($_REQUEST["CmbAgrupacion"])) {
		$CmbAgrupacion = $_REQUEST["CmbAgrupacion"];
	}else{
		$CmbAgrupacion = "";
	}
	if(isset($_REQUEST["CmbTipo"])) {
		$CmbTipo = $_REQUEST["CmbTipo"];
	}else{
		$CmbTipo = "";
	}
	if(isset($_REQUEST["CmbPeriodo"])) {
		$CmbPeriodo = $_REQUEST["CmbPeriodo"];
	}else{
		$CmbPeriodo = "";
	}
	if(isset($_REQUEST["IdMuestra"])) {
		$IdMuestra = $_REQUEST["IdMuestra"];
	}else{
		$IdMuestra = "";
	}
	if(isset($_REQUEST["CmbUsuarios"])) {
		$CmbUsuarios = $_REQUEST["CmbUsuarios"];
	}else{
		$CmbUsuarios = "";
	}
	if(isset($_REQUEST["AnoIni2"])) {
		$AnoIni2 = $_REQUEST["AnoIni2"];
	}else{
		$AnoIni2 = "";
	}
	if(isset($_REQUEST["AnoFin2"])) {
		$AnoFin2 = $_REQUEST["AnoFin2"];
	}else{
		$AnoFin2 = "";
	}
	if(isset($_REQUEST["NumIni"])) {
		$NumIni = $_REQUEST["NumIni"];
	}else{
		$NumIni = 0;
	}
	if(isset($_REQUEST["NumFin"])) {
		$NumFin = $_REQUEST["NumFin"];
	}else{
		$NumFin = 0;
	}

?>
<html>
<head>
<title>Control de Calidad</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">

</head>
<body>
<form name="frmPrincipal" action="" method="post">
<?php
/*
	if (!isset($LimitIni))
		$LimitIni = 0;
	if (!isset($LimitFin))
		$LimitFin = 10;*/
?>
<input type="hidden" name="LimitIni" value="<?php echo $LimitIni; ?>">
  <table width="765" border="0">
    <tr> 
      <td width="695" align="center" valign="middle"><strong>Consulta de Solicitudes</strong></td>
    </tr>
  </table>
  <br>
  <table width="314" border="0" >
    <tr> 
      <td height="24">Fecha Inicio</td>
      <td><font size="2"><?php echo $DiaIni."/".$MesIni."/".$AnoIni;?></font></td>
    </tr>
    <tr> 
      <td width="153" height="24">Fecha Termino</td>
      <td width="148"><font size="2"><?php echo $DiaFin."/".$MesFin."/".$AnoFin;?></font> 
      </td>
    </tr>
    <tr> 
      <td height="24">Agrupacion</td>
      <td>
	  <?php 
	  	$Consulta ="select * from proyecto_modernizacion.sub_clase where cod_clase = '1004' and cod_subclase = '".$CmbAgrupacion."'";
		$Respuesta=mysqli_query($link, $Consulta);
		if ($Fila=mysqli_fetch_array($Respuesta))
		{
			echo $Fila["nombre_subclase"];
		}
	   ?> </td>
    </tr>
  </table>
  <br>
<?php
	$FechaIni = $AnoIni."-".$MesIni."-".$DiaIni;
	$FechaFin = $AnoFin."-".$MesFin."-".$DiaFin;
	$Consulta = "select distinct(t2.cod_leyes), t3.abreviatura ";
	$Consulta = $Consulta." from cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t2 on t1.nro_solicitud = t2.nro_solicitud ";
	$Consulta = $Consulta." and t1.recargo = t2.recargo ";
	$Consulta = $Consulta." inner join proyecto_modernizacion.leyes t3 on t2.cod_leyes = t3.cod_leyes ";
	$Consulta = $Consulta." where (t1.fecha_muestra between '".$FechaIni." 00:00:00' and '".$FechaFin." 23:59:59')  ";
	if ($CmbPeriodo == "-1")//todos los periodos
	{
		$Consulta = $Consulta." and (t1.agrupacion = '".$CmbAgrupacion."') order by t2.cod_leyes ";
	}
	else
	{
		$Consulta = $Consulta." and (t1.agrupacion = '".$CmbAgrupacion."') and (t1.cod_periodo = '".$CmbPeriodo."') order by t2.cod_leyes";
	}
	$Respuesta = mysqli_query($link, $Consulta);
	$LargoArreglo = 0;
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		$ArregloLeyes[$LargoArreglo][0] = $Row["cod_leyes"];
		$ArregloLeyes[$LargoArreglo][1] = $Row["abreviatura"];
		$LargoArreglo++;
	}
	$Total = ($LargoArreglo * 70) +800;
	
?>	    
  <table width="<?php echo $Total; ?>" border="1" cellpadding="0" cellspacing="0" >
    <tr align="center" valign="middle" > 
      <td width="125"><strong># Solicitud</strong></td>
      <td width="81"><strong>Agrupacion</strong></td>
	  <td width="81"><strong>Id. Muestra</strong></td>
      <td width="132"><strong>Fecha Muestra</strong></td>
      <td width="68"><strong>Producto</strong></td>
      <td width="86"><strong>SubProducto</strong></td>
      <td width="66"><strong>Estado</strong></td>
      <?php
	for ($i = 0; $i < $LargoArreglo; $i++)
	{
		
	//	echo "<td width='10'>Signo</td>";
		echo "<td width='70'>".$ArregloLeyes[$i][1]."</td>";
		echo "<td width='10'>Unidad</td>";
	}
?>
    </tr>
    <?php	
	$Consulta = "select fecha_muestra,nro_solicitud,recargo, if(length(recargo)=1,concat('0',recargo),recargo) as recargo_ordenado, id_muestra, ";
	$Consulta = $Consulta." rut_funcionario, fecha_hora,agrupacion, nro_sa_lims ";
	$Consulta = $Consulta." from cal_web.solicitud_analisis t1 ";
	$Consulta = $Consulta." where (fecha_muestra between '".$FechaIni." 00:00:00' and '".$FechaFin." 23:59:59')";
	$Consulta = $Consulta." and (not isnull(nro_solicitud) or nro_solicitud = '') ";
	if ($CmbPeriodo == "-1")//todos los periodos
	{
		$Consulta = $Consulta." and (t1.agrupacion = '".$CmbAgrupacion."')  ";
	}
	else
	{
		$Consulta = $Consulta." and (t1.agrupacion = '".$CmbAgrupacion."') and (t1.cod_periodo = '".$CmbPeriodo."') ";
	}
	$Consulta = $Consulta." LIMIT ".$LimitIni.", ".$LimitFin;
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		echo "<tr align='left' valign='middle'>\n";
		if (is_null($Row["recargo"]) || ($Row["recargo"] == ""))
		{

			$Recargo='N';
			if ($Row["nro_sa_lims"]=='') {
				echo "<td>".$Row["nro_solicitud"]."</a></td>\n";
			}else{
				echo "<td>".$Row["nro_sa_lims"]."</a></td>\n";
			}
			 
			//echo "<td>".$Row["nro_solicitud"]."</a></td>\n";
		}
		else
		{

			if ($Row["nro_sa_lims"]=='') {
				echo "<td>".$Row["nro_solicitud"]."-".$Row["recargo_ordenado"]."</td>\n";
			}else{
				echo "<td>".$Row["nro_sa_lims"]."-".$Row["recargo_ordenado"]."</td>\n";
			}

			//echo "<td><a href=\"JavaScript:Historial(".$Row["nro_solicitud"].")\">\n";
			//echo "<td>".$Row["nro_solicitud"]."-".$Row["recargo_ordenado"]."</td>\n";
		}
		$Consulta ="SELECT * from proyecto_modernizacion.sub_clase where cod_clase = 1004 and cod_subclase = '".$Row["agrupacion"]."'";
		$Resp1=mysqli_query($link, $Consulta);
		$Fil1=mysqli_fetch_array($Resp1);
		echo "<td>".$Fil1["nombre_subclase"]."</td>\n";
		echo "<td>".$Row["id_muestra"]."</td>\n";
		//---------FECHA MUESTRA---------------------------------------
		if ((!is_null($Row["fecha_muestra"])) && ($Row["fecha_muestra"] != ""))
			echo "<td align='center'>".substr($Row["fecha_muestra"],8,2)."/".substr($Row["fecha_muestra"],5,2)."/".substr($Row["fecha_muestra"],0,4)." ".substr($Row["fecha_muestra"],11,5)."</td>\n";
		else
			echo "<td align='center'>&nbsp;</td>\n";
		//----------------------Producto y  Subproducto --------------------------------------
		$Consulta = "SELECT t2.abreviatura as AbrevProducto,t3.abreviatura as AbrevSubProducto from cal_web.solicitud_analisis t1 ";
		$Consulta.= " inner join proyecto_modernizacion.productos t2 on t1.cod_producto = t2.cod_producto  ";
		$Consulta.= " inner join proyecto_modernizacion.subproducto t3 on t2.cod_producto = t3.cod_producto and t1.cod_subproducto = t3.cod_subproducto ";
		$Consulta.= " where t1.nro_solicitud = '".$Row["nro_solicitud"]."' ";
		if (is_null($Row["recargo"]) || ($Row["recargo"] == ""))
		{	
			$Consulta = $Consulta;
		}
		else	
		{
			$Consulta.= " and recargo = '".$Row["recargo"]."'";
		}
		//echo $Consulta."<br>";
		$Resp=mysqli_query($link, $Consulta);
		$Fila=mysqli_fetch_array($Resp);  
		echo "<td align ='center'>".$Fila["AbrevProducto"]."</td>";
		echo "<td align = 'center'>".$Fila["AbrevSubProducto"]."</td>";
		//---------ESTADO ACTUAL---------------------------------------
		$Consulta = "SELECT * from cal_web.solicitud_analisis t1 left join proyecto_modernizacion.sub_clase t2 ";
		$Consulta.= " on t2.cod_clase = '1002' and t1.estado_actual = t2.cod_subclase ";		
		$Consulta.= " where nro_solicitud = '".$Row["nro_solicitud"]."'";
		if (is_null($Row["recargo"]) || ($Row["recargo"] == ""))
			$Consulta = $Consulta;
		else	$Consulta.= " and recargo = '".$Row["recargo"]."'";
		$Resp = mysqli_query($link, $Consulta);
		if ($Row2 = mysqli_fetch_array($Resp))
			echo "<td>".$Row2["nombre_subclase"]."</td>\n";
		else	echo "<td>&nbsp;</td>\n";
		//-------------------------------------------------------
		for ($i = 0; $i < $LargoArreglo; $i++)
		{
			$Consulta = "SELECT *,t2.abreviatura from cal_web.leyes_por_solicitud t1";
			$Consulta.= " inner join proyecto_modernizacion.unidades t2 on t1.cod_unidad = t2.cod_unidad ";  
			$Consulta.= " where t1.nro_solicitud = '".$Row["nro_solicitud"]."'";
			if (!is_null($Row["recargo"]) || ($Row["recargo"] != ""))
			{
				$Consulta.= " and t1.recargo = '".$Row["recargo"]."' ";
			}
			$Consulta.= " and t1.cod_leyes = '".$ArregloLeyes[$i][0]."'";
			$Resp = mysqli_query($link, $Consulta);
			if ($Row2 = mysqli_fetch_array($Resp))
			{
				if ((is_null($Row2["valor"])) || ($Row2["valor"] == ""))
				{
					if ($Row2["signo"]=="N")
					{
						//echo "<td width='15'>&nbsp;</td>\n";
						echo "<td width='70'>ND</td>\n";
						echo "<td width='15'>&nbsp;</td>\n";
					}
					else
					{
						//echo "<td width='15'>&nbsp;</td>\n";
						echo "<td width='70'>&nbsp;&nbsp;</td>\n";
						echo "<td width='15'>&nbsp;</td>\n";
					}
				}
				else
				{	
					if($Row2["signo"]=="=")
					{
						//echo "<td width='15'>&nbsp;</td>\n";
						echo "<td width='70'>".number_format($Row2["valor"],3,",","")."</td>\n";
						echo "<td width='15'>".$Row2["abreviatura"]."</td>\n";
					}
					else
					{
						//echo "<td width='15'>".$Row2["signo"]."</td>\n";
						echo "<td width='70'>".number_format($Row2["valor"],3,",","")."</td>\n";
						echo "<td width='15'>".$Row2["abreviatura"]."</td>\n";
					}
				}
			}
			else
			{
				//echo "<td width='15'>&nbsp;</td>\n";
				echo "<td width='70' align='center'>X</td>\n";
				echo "<td width='15'>&nbsp;</td>\n";
			}				
		}
		echo "</tr>\n";
	}
?>
  </table>
  
</form>
</body>
</html>
