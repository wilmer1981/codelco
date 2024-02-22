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
	$CookieRut= $_COOKIE["CookieRut"];

$Consulta ="select nivel from proyecto_modernizacion.sistemas_por_usuario where rut='".$CookieRut."' and cod_sistema =1";
$Respuesta = mysqli_query($link, $Consulta);
$Fila=mysqli_fetch_array($Respuesta);
$Nivel=$Fila["nivel"];

if(isset($_REQUEST["LimitIni"])) {
	$LimitIni = $_REQUEST["LimitIni"];
}else{
	$LimitIni = 0;
}
if(isset($_REQUEST["LimitFin"])) {
	$LimitFin = $_REQUEST["LimitFin"];
}else{
	$LimitFin = 30;
}
if(isset($_REQUEST["AnoIni"])) {
	$AnoIni = $_REQUEST["AnoIni"];
}else{
	$AnoIni = date("Y");
}
if(isset($_REQUEST["NumIni"])) {
	$NumIni = $_REQUEST["NumIni"];
}else{
	$NumIni = 0;
}
if(isset($_REQUEST["AnoFin"])) {
	$AnoFin = $_REQUEST["AnoFin"];
}else{
	$AnoFin = date("Y");
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
</head>

<body>
  <table width="765" border="0">
    <tr>
      <td width="695" align="center" valign="middle" colspan="9"><strong>Consulta Estados de Solicitud</strong></td>
    </tr>
  </table>
  <br>
  <table width="1000" border="1" cellpadding="0" cellspacing="0" class="TablaDetalle">
    <tr align="center" valign="middle" class="ColorTabla01"> 
      <td width="107"><strong># Solicitud</strong></td>
      <td width="85"><strong>Id. Muestra</strong></td>
      <td width="86"><strong>Fecha Muestra</strong></td>
      <td width="78"><strong>Creada</strong></td>
      <td width="98"><strong>Recep. Muest.</strong></td>
      <td width="96"><strong>Env. Laborat.</strong></td>
      <td width="122"><strong>Recep Laborat.</strong></td>
      <td width="128"><strong>Atend. Quimico</strong></td>
      <td width="83"><strong>Finalizada</strong></td>
      <td width="94"><strong>Ult. Estado</strong></td>
    </tr>
    <?php
	if (!isset($AnoIni))
		$AnoIni = 0;
	if (!isset($NumIni))
		$NumIni = 0;
	if (!isset($AnoFin))
		$AnoFin = 0;
	if (!isset($NumFin))
		$NumFin = 0;
	$SolIni = $AnoIni."000000";
	$SolFin = $AnoFin."000000";
	$SolIni = $SolIni + $NumIni;
	$SolFin = $SolFin + $NumFin;
	$Consulta = "select nro_solicitud,recargo, if(length(recargo)=1,concat('0',recargo),recargo) as recargo_ordenado, id_muestra, ";
	$Consulta.= " rut_funcionario, fecha_hora,fecha_muestra ";
	if($AnoIni<2009 && $AnoIni>0)
		$Consulta.=" from cal_histo.solicitud_analisis_a_".$AnoIni;
		else
		$Consulta.= " ,nro_sa_lims from cal_web.solicitud_analisis ";
		$Consulta.= " where (nro_solicitud between '".$SolIni."' and '".$SolFin."') or (nro_sa_lims between '".$NumIni."' and '".$NumFin."' )";	
	$Consulta.= " order by nro_solicitud,recargo_ordenado";
	$Consulta = $Consulta." LIMIT ".$LimitIni.", ".$LimitFin;
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		echo "<tr align='center' valign='middle'>\n";
		if (is_null($Row["recargo"]) || ($Row["recargo"] == ""))
		{
			$Recargo='N';
			if ($Row["nro_sa_lims"]=='') {
				echo "<td><a href=\"JavaScript:Historial(".$Row["nro_solicitud"].",'".$Recargo."','".$Nivel."')\">\n";
			echo $Row["nro_solicitud"]."</a></td>\n";
			}else{
				echo "<td><a href=\"JavaScript:Historial(".$Row["nro_solicitud"].",'".$Recargo."','".$Nivel."')\">\n";
			echo $Row["nro_sa_lims"]."</a></td>\n";
			}

			//$Recargo='N';
			//echo "<td><a href=\"JavaScript:Historial(".$Row["nro_solicitud"].",'".$Recargo."','".$Nivel."')\">\n";
			//echo $Row["nro_solicitud"]."</a></td>\n";
		}
		else
		{
			if ($Row["nro_sa_lims"]=='') {
				echo "<td><a href=\"JavaScript:Historial(".$Row["nro_solicitud"].",'".$Row["recargo"]."','".$Nivel."')\">\n";
				echo $Row["nro_solicitud"]."-".$Row["recargo"]."</td>\n";
			}else{
				echo "<td><a href=\"JavaScript:Historial(".$Row["nro_solicitud"].",'".$Row["recargo"]."','".$Nivel."')\">\n";
			echo $Row["nro_sa_lims"]."-".$Row["recargo"]."</td>\n";	
			}

			//echo "<td><a href=\"JavaScript:Historial(".$Row["nro_solicitud"].",'".$Row["recargo"]."','".$Nivel."')?????\">\n";
			//echo $Row["nro_solicitud"]."-".$Row["recargo"]."</td>\n";


		}
		echo "<td>".$Row["id_muestra"]."</td>\n";
		//---------FECHA MUESTRA---------------------------------------
				echo "<td align='center'>".substr($Row["fecha_muestra"],8,2)."/".substr($Row["fecha_muestra"],5,2)."/".substr($Row["fecha_muestra"],0,4)." ".substr($Row["fecha_muestra"],11,5)."</td>\n";
		//------------------------------------------------------------
		for ($i = 1;$i <= 6; $i++)
		{
			if($AnoIni<2009 && $AnoIni>0)	
				$Consulta = "select * from cal_histo.estados_por_solicitud_a_".$AnoIni;
				else
				$Consulta = "select * from cal_web.estados_por_solicitud ";
			$Consulta.= " where nro_solicitud = '".$Row["nro_solicitud"]."' ";
			if (is_null($Row["recargo"]) || ($Row["recargo"] == ""))
				$Consulta = $Consulta;
			else	$Consulta.= " and recargo = '".$Row["recargo"]."'";
			$Consulta.= " and cod_estado = '".$i."'";
			$Resp = mysqli_query($link, $Consulta);
			if ($Row2 = mysqli_fetch_array($Resp))
				echo "<td>".substr($Row2["fecha_hora"],8,2)."/".substr($Row2["fecha_hora"],5,2)."/".substr($Row2["fecha_hora"],0,4)."\n".substr($Row2["fecha_hora"],11,5)."</td>\n";
			else	echo "<td>&nbsp;</td>\n";
		}
		if($AnoIni<2009 && $AnoIni>0)
			$Consulta = "select * from cal_histo.solicitud_analisis_a_".$AnoIni." t1 left join proyecto_modernizacion.sub_clase t2 ";
			else
			$Consulta = "select * from cal_web.solicitud_analisis t1 left join proyecto_modernizacion.sub_clase t2 ";
		$Consulta.= " on t2.cod_clase = '1002' and t1.estado_actual = t2.cod_subclase ";		
		$Consulta.= " where nro_solicitud = '".$Row["nro_solicitud"]."'";
		if (is_null($Row["recargo"]) || ($Row["recargo"] == ""))
			$Consulta = $Consulta;
		else	$Consulta.= " and recargo = '".$Row["recargo"]."'";
		$Resp = mysqli_query($link, $Consulta);
		if ($Row2 = mysqli_fetch_array($Resp))
			echo "<td>".$Row2["nombre_subclase"]."</td>\n";
		else	echo "<td>&nbsp;</td>\n";
		echo "</tr>\n";
	}
?>
  </table>
  <table width="760" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td height="25" align="center" valign="middle">Paginas &gt;&gt; 
              <?php		
		$Consulta = "select count(*) as total_registros ";
		if($AnoIni<2009 && $AnoIni>0)
			$Consulta.= " from cal_histo.solicitud_analisis_a_".$AnoIni;
			else
			$Consulta.= " from cal_web.solicitud_analisis ";
		$Consulta.= " where nro_solicitud between '".$SolIni."' and '".$SolFin."'";
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
				$StrPaginas.=  "<a href=JavaScript:Recarga('cal_con_fechas.php','".($i * $LimitFin)."');>";
				$StrPaginas.= ($i + 1)."</a>&nbsp;-&nbsp;\n";
			}
		}
		echo substr($StrPaginas,0,-15);
?>
            </td>
          </tr></table>
</body>
</html>
