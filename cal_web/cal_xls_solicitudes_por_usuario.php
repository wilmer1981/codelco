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
	include("../principal/conectar_principal.php");
$CodigoDeSistema = 1;
$CookieRut= $_COOKIE["CookieRut"];

$Consulta ="select nivel from proyecto_modernizacion.sistemas_por_usuario where rut='".$CookieRut."' and cod_sistema =1";
$Respuesta = mysqli_query($link, $Consulta);
$Fila=mysqli_fetch_array($Respuesta);
$Nivel=$Fila["nivel"];
$Rut =$CookieRut;



if(isset($_REQUEST["LimitIni"])) {
	$LimitIni = $_REQUEST["LimitIni"];
}else{
	$LimitIni = 0;
}
if(isset($_REQUEST["LimitFin"])) {
	$LimitFin = $_REQUEST["LimitFin"];
}else{
	$LimitFin = 20;
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

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
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
  <table width="283" border="0" >
    <tr> 
      <td width="100" height="24">Fecha Inicio</td>
      <td width="170"><font size="2"><?php echo $DiaIni."/".$MesIni."/".$AnoIni;?></font> 
      </td>
    </tr>
    <tr> 
      <td height="24">Fecha Termino</td>
      <td><font size="2"><?php echo $DiaFin."/".$MesFin."/".$AnoFin;?></font></td>
    </tr>
    <tr> 
      <td height="24">#SA</td>
      <td><?php //echo $TxtSA;  ?></td>
    </tr>
  </table>
  <br>
<?php
	$SolIni = $AnoIni2."000000";
	$SolFin = $AnoFin2."000000";
	$SolIni = $SolIni + $NumIni;
	$SolFin = $SolFin + $NumFin;
	$FechaIni = $AnoIni."-".$MesIni."-".$DiaIni;
	$FechaFin = $AnoFin."-".$MesFin."-".$DiaFin;
?>	    
  <table width="<?php echo $Total;  ?>" border="1" cellpadding="0" cellspacing="0" class="TablaDetalle">
    <tr align="center" valign="middle" class="ColorTabla01"> 
      <td width="125"><strong># Solicitud</strong></td>
      <td width="81"><strong>Agrupacion</strong></td>
	  <td width="81"><strong>Id. Muestra</strong></td>
      <td width="132"><strong>Fecha Muestra</strong></td>
      <td width="68"><strong>Producto</strong></td>
      <td width="86"><strong>SubProducto</strong></td>
      <td width="78"><strong>Estado</strong></td>
      <?php
    echo "</tr>";
	$Consulta = "select fecha_muestra,nro_solicitud,recargo, if(length(recargo)=1,concat('0',recargo),recargo) as recargo_ordenado, id_muestra, ";
	$Consulta.= " rut_funcionario, fecha_hora,agrupacion ";
	if($AnoIni<2009 && $AnoIni>0)
		$Consulta.= " from cal_histo.solicitud_analisis_a_".$AnoIni." t1 ";
		else
		$Consulta.= " ,nro_sa_lims from cal_web.solicitud_analisis t1 ";
	if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5'))
	{
		$Consulta.= " where fecha_muestra between '".$FechaIni." 00:00:00' and '".$FechaFin." 23:59:59'";
	}
	else
	{
		$Consulta.= " where fecha_muestra between '".$FechaIni." 00:00:00' and '".$FechaFin." 23:59:59' and t1.cod_producto <> 1 ";
	}
	if (($Nivel ==1)|| ($Nivel==2)||($Nivel ==3) || ($Nivel==6))
	{
		$Consulta.= " and (not isnull(nro_solicitud) or nro_solicitud = '') and (t1.cod_periodo = '".$CmbPeriodo."') ";
		 if($CmbUsuarios!="-1" && $CmbUsuarios!="")
		 	$Consulta.=" and rut_funcionario = '".$CmbUsuarios."'";
	}
	else
	{	
		$Consulta.= " and (not isnull(nro_solicitud) or nro_solicitud = '') and (t1.cod_periodo = '".$CmbPeriodo."') ";
		if($Rut!= "")
			$Consulta.=" and rut_funcionario = '".$Rut."'";
	}
		
	$Consulta.= " order by nro_solicitud,recargo_ordenado";
	//echo $Consulta."<br>";
	$Consulta = $Consulta." LIMIT ".$LimitIni.", ".$LimitFin;
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		echo "<tr align='left' valign='middle'>\n";
		if (is_null($Row["recargo"]) || ($Row["recargo"] == ""))
		{

			$Recargo='N';
			if ($Row["nro_sa_lims"]=='') {
				echo "<td><a href=\"JavaScript:Historial(".$Row["nro_solicitud"].",'".$Recargo."')\">\n";
				echo $Row["nro_solicitud"]."</a></td>\n";
			}else{
				echo "<td><a href=\"JavaScript:Historial(".$Row["nro_solicitud"].",'".$Recargo."')\">\n";
				echo $Row["nro_sa_lims"]."</a></td>\n";
			}
			//$Recargo='N';
			//echo "<td><a href=\"JavaScript:Historial(".$Row["nro_solicitud"].",'".$Recargo."')\">\n";
			//echo $Row["nro_solicitud"]."</a></td>\n";
		}
		else
		{

			if ($Row["nro_sa_lims"]=='') {
				echo "<td><a href=\"JavaScript:Historial(".$Row["nro_solicitud"].",'".$Row["recargo"]."')\">\n";
				echo $Row["nro_solicitud"]."-".$Row["recargo"]."</td>\n";
			}else{
				echo "<td><a href=\"JavaScript:Historial(".$Row["nro_solicitud"].",'".$Row["recargo"]."')\">\n";
				echo $Row["nro_sa_lims"]."-".$Row["recargo"]."</td>\n";
			}


			//echo "<td><a href=\"JavaScript:Historial(".$Row["nro_solicitud"].",'".$Row["recargo"]."')\">\n";
			//echo $Row["nro_solicitud"]."-".$Row["recargo"]."</td>\n";
		}
		$Consulta ="select * from proyecto_modernizacion.sub_clase where cod_clase = 1004 and cod_subclase = '".$Row["agrupacion"]."'";
		$Resp1=mysqli_query($link, $Consulta);
		$Fil1=mysqli_fetch_array($Resp1);
		echo "<td>".$Fil1["nombre_subclase"]."</td>\n";
		echo "<td>".$Row["id_muestra"]."</td>\n";
		if ((!is_null($Row["fecha_muestra"])) && ($Row["fecha_muestra"] != ""))
				echo "<td align='center'>".substr($Row["fecha_muestra"],8,2)."/".substr($Row["fecha_muestra"],5,2)."/".substr($Row["fecha_muestra"],0,4)." ".substr($Row["fecha_muestra"],11,5)."</td>\n";
		else
			echo "<td align='center'>&nbsp;</td>\n";
		//----------------------Producto y  Subproducto --------------------------------------
		$Consulta = "select t2.abreviatura as AbrevProducto,t3.abreviatura as AbrevSubProducto";
		if($AnoIni<2009 && $AnoIni>0)
			$Consulta.=" from cal_histo.solicitud_analisis_a_".$AnoIni." t1 ";
			else
			$Consulta.=" from cal_web.solicitud_analisis t1 ";
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
		if($AnoIni<2009 && $AnoIni>0)
			$Consulta = "select * from cal_histo.solicitud_analisis_a_".$AnoIni." t1 left join proyecto_modernizacion.sub_clase t2 ";
			else
			$Consulta = "select * from cal_web.solicitud_analisis t1 left join proyecto_modernizacion.sub_clase t2 ";
		$Consulta.= " on t2.cod_clase = '1002' and t1.estado_actual = t2.cod_subclase ";		
		$Consulta.= " where nro_solicitud = '".$Row["nro_solicitud"]."'";
		if (is_null($Row["recargo"]) || ($Row["recargo"] == ""))
			$Consulta = $Consulta;
		else	$Consulta.= " and recargo = '".$Row["recargo"]."'";
		//echo $Consulta;
		$Resp = mysqli_query($link, $Consulta);
		if ($Row2 = mysqli_fetch_array($Resp))
			echo "<td>".$Row2["nombre_subclase"]."</td>\n";
		else	echo "<td>&nbsp;</td>\n";
		//-------------------------------------------------------
		
		echo "</tr>\n";
	}
?>
  </table>
  <table width="667" border="0" cellpadding="0" cellspacing="0">
          <tr>
            
      <td width="667" height="25" align="center" valign="middle"><strong> </strong>Paginas 
        &gt;&gt; 
        <?php		
		$Consulta = "select count(*) as total_registros ";
		if($AnoIni<2009 && $AnoIni>0)
			$Consulta.= " from cal_histo.solicitud_analisis_a_".$AnoIni." t1 ";
			else
			$Consulta.= " from cal_web.solicitud_analisis t1 ";
		if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5'))
		{
			$Consulta.= " where fecha_muestra between '".$FechaIni." 00:00:00' and '".$FechaFin." 23:59:59'";
		}
		else
		{
			$Consulta.= " where fecha_muestra between '".$FechaIni." 00:00:00' and '".$FechaFin." 23:59:59' and t1.cod_producto <> 1 ";
		}
		if (($Nivel ==1)|| ($Nivel==2)||($Nivel ==3) || ($Nivel ==6))
		{
			$Consulta.= " and (not isnull(nro_solicitud) or nro_solicitud = '') and (t1.cod_periodo = '".$CmbPeriodo."') and rut_funcionario = '".$CmbUsuarios."'";
		}
		else
		{	
			$Consulta.= " and (not isnull(nro_solicitud) or nro_solicitud = '') and (t1.cod_periodo = '".$CmbPeriodo."') and rut_funcionario = '".$Rut."'";
		}
		//echo $Consulta."<br>";
		$Respuesta = mysqli_query($link, $Consulta);
		$Row = mysqli_fetch_array($Respuesta);
		$Coincidencias = $Row["total_registros"];
		$NumPaginas = ($Coincidencias / $LimitFin);
		$LimitFinAnt = $LimitIni;
		$StrPaginas = "";
		for ($i = 0; $i <= $NumPaginas; $i++)
		{
			$LimitIni = ($i * $LimitFin);
			if ($LimitIni == $LimitFinAnt)
			{
				$StrPaginas.= "<strong>".($i + 1)."</strong>&nbsp;-&nbsp;\n";
			}
			else
			{
				$StrPaginas.=  "<a href=JavaScript:Recarga('cal_con_solicitudes_por_usuario.php','".($i * $LimitFin)."');>";
				$StrPaginas.= ($i + 1)."</a>&nbsp;-&nbsp;\n";
			}
		}
		echo substr($StrPaginas,0,-15);
?>
  </table>
  
</form>
</body>
</html>
