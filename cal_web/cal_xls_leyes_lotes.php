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
include("../principal/conectar_principal.php");
$CookieRut = $_COOKIE["CookieRut"];
$Rut =$CookieRut;

if(isset($_REQUEST["AnoIni"])) {
	$AnoIni = $_REQUEST["AnoIni"];
}else{
	$AnoIni =  date("Y");
}
if(isset($_REQUEST["MesIni"])) {
	$MesIni = $_REQUEST["MesIni"];
}else{
	$MesIni =  date("m");
}
if(isset($_REQUEST["DiaIni"])) {
	$DiaIni = $_REQUEST["DiaIni"];
}else{
	$DiaIni =  date("d");
}
if(isset($_REQUEST["AnoFin"])) {
	$AnoFin = $_REQUEST["AnoFin"];
}else{
	$AnoFin =  date("Y");
}
if(isset($_REQUEST["MesFin"])) {
	$MesFin = $_REQUEST["MesFin"];
}else{
	$MesFin =  date("m");
}
if(isset($_REQUEST["DiaFin"])) {
	$DiaFin = $_REQUEST["DiaFin"];
}else{
	$DiaFin =  date("d");
}
if(isset($_REQUEST["IdInicial"])) {
	$IdInicial = $_REQUEST["IdInicial"];
}else{
	$IdInicial =  "";
}
if(isset($_REQUEST["IdFinal"])) {
	$IdFinal = $_REQUEST["IdFinal"];
}else{
	$IdFinal =  "";
}
if(isset($_REQUEST["LimitIni"])) {
	$LimitIni = $_REQUEST["LimitIni"];
}else{
	$LimitIni =  0;
}
if(isset($_REQUEST["LimitFin"])) {
	$LimitFin = $_REQUEST["LimitFin"];
}else{
	$LimitFin =  10;
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
	/*if (!isset($LimitIni))
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
  </table>
  <br>
<?php
	$Consulta=" select t1.lote_origen,t1.cod_origen from sea_web.relaciones t1";
	if($AnoIni<2009 && $AnoIni>0)
		$Consulta.= " inner join cal_histo.solicitud_analisis_a_".$AnoIni." t2 on t1.lote_origen = t2.id_muestra";
		else
		$Consulta.= " inner join cal_web.solicitud_analisis t2 on t1.lote_origen = t2.id_muestra";
	$Consulta.=" where (t1.lote_ventana between '".$IdInicial."' and '".$IdFinal."') ";
	//echo $Consulta."<br>";
	$Respuesta=mysqli_query($link, $Consulta);
	$i=0;
	$Encontro=false;
	while ($Fila=mysqli_fetch_array($Respuesta))
	{
		if ($Fila["cod_origen"]=='1')
		{
				if ($i==0)
				{
					$LoteOrigen=$Fila["lote_origen"];
				}
				$LoteFinal=$Fila["lote_origen"];
				$Encontro=true;
				$i++;
		}
	}
	if ($Encontro==true)
	{
		$Pregunta.=" (t1.id_muestra between '".$LoteOrigen."' and '".$LoteFinal."') or (t1.id_muestra between '".$IdInicial."' and '".$IdFinal."')  ";
	}
	else
	{
		$Pregunta = "   (t1.id_muestra between '".$IdInicial."' and '".$IdFinal."')  ";
	}
	$FechaIni = $AnoIni."-".$MesIni."-".$DiaIni;
	$FechaFin = $AnoFin."-".$MesFin."-".$DiaFin;
	$Consulta = "select t2.cod_leyes, t3.abreviatura,t4.lotes ";
	if($AnoIni<2009 && $AnoIni>2009)
		$Consulta = $Consulta." from cal_histo.solicitud_analisis_a_".$AnoIni." t1 inner join cal_histo.leyes_por_solicitud_a_".$AnoIni." t2 on t1.nro_solicitud = t2.nro_solicitud ";
	    else
		$Consulta = $Consulta." from cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t2 on t1.nro_solicitud = t2.nro_solicitud ";
	$Consulta = $Consulta." and t1.recargo = t2.recargo ";
	$Consulta = $Consulta." inner join proyecto_modernizacion.leyes t3 on t2.cod_leyes = t3.cod_leyes ";
	$Consulta = $Consulta." inner join proyecto_modernizacion.subproducto t4 on t1.cod_producto = t4.cod_producto and t1.cod_subproducto = t4.cod_subproducto ";
	$Consulta = $Consulta." where (t1.fecha_muestra between '".$FechaIni." 00:00:00' and '".$FechaFin." 23:59:59')  ";
	$Consulta = $Consulta."  and ((t1.agrupacion = 1)or(t4.lotes='S')) and "; // and (t1.id_muestra between '".$IdInicial."' and '".$IdFinal."') ";
	$Consulta = $Consulta.$Pregunta;
	$Consulta = $Consulta." and (not isnull(t1.nro_solicitud) or t1.nro_solicitud = '')  and (t1.estado_actual ='5' or estado_actual='6')  ";
	$Consulta = $Consulta."  group by t2.cod_leyes order by t3.tipo_leyes,t3.cod_leyes";
	//echo $Consulta."<br>";
	$Respuesta = mysqli_query($link, $Consulta);
	$LargoArreglo = 0;
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		$ArregloLeyes[$LargoArreglo][0] = $Row["cod_leyes"];
		$ArregloLeyes[$LargoArreglo][1] = $Row["abreviatura"];
		$LargoArreglo++;
	}
	$Total = ($LargoArreglo * 70) +650;
	
?>	    
  <table width="<?php echo $Total; ?>" border="1" cellpadding="0" cellspacing="0" class="TablaDetalle">
    <tr align="center" valign="middle" class="ColorTabla01"> 
      <td width="136"><strong># Solicitud</strong></td>
      <td width="79"><strong>Agrupacion</strong></td>
	  <td width="120"><strong>Id. Muestra</strong></td>
      <td width="144"><strong>Fecha Muestra</strong></td>
      <td width="90"><strong>Producto</strong></td>
      <td width="90"><strong>SubProducto</strong></td>
      <td width="75"><strong>Estado</strong></td>
      <?php
	for ($i = 0; $i < $LargoArreglo; $i++)
	{
		echo "<td width='70'>".$ArregloLeyes[$i][1]."</td>\n";
	}
?>
    </tr>
    <?php	
	$Consulta = "select distinct nro_solicitud,recargo,fecha_muestra, if(length(recargo)=1,concat('0',recargo),recargo) as recargo_ordenado, id_muestra, ";
	$Consulta = $Consulta." rut_funcionario, fecha_hora,t1.agrupacion ";
	if($AnoIni<2009 && $AnoIni>0)
		$Consulta = $Consulta." from cal_histo.solicitud_analisis_a_".$AnoIni." t1 ";
		else
		$Consulta = $Consulta." ,nro_sa_lims from cal_web.solicitud_analisis t1 ";
	$Consulta = $Consulta." inner join proyecto_modernizacion.subproducto t2 on t1.cod_producto = t2.cod_producto and t1.cod_subproducto = t2.cod_subproducto  ";
	$Consulta = $Consulta." where (t1.fecha_muestra between '".$FechaIni." 00:00:00' and '".$FechaFin." 23:59:59')  ";
	$Consulta = $Consulta."  and ((t1.agrupacion = 1)or(t2.lotes='S')) and ";// and (t1.id_muestra between '".$IdInicial."' and '".$IdFinal."') ";
	$Consulta = $Consulta.$Pregunta;
	$Consulta = $Consulta." and (not isnull(t1.nro_solicitud) or t1.nro_solicitud = '') and (t1.estado_actual = '5' or t1.estado_actual ='6') ";
	$Consulta = $Consulta." LIMIT ".$LimitIni.", ".$LimitFin;
	//echo $Consulta."<br>";
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
		$Consulta=" select t1.lote_ventana from sea_web.relaciones t1";
		if($AnoIni<2009 && $AnoIni>0)
			$Consulta.= " inner join cal_histo.solicitud_analisis_a_".$AnoIni." t2 on t1.lote_origen = t2.id_muestra";
			else
			$Consulta.= " inner join cal_web.solicitud_analisis t2 on t1.lote_origen = t2.id_muestra";
		$Consulta.=" where (t2.id_muestra='".$Row["id_muestra"]."') ";
		$Resp20=mysqli_query($link, $Consulta);
		if ($Fil20=mysqli_fetch_array($Resp20))
		{
			echo "<td>".$Fil20["lote_ventana"]."</td>\n";
		}
		else
		{	
			echo "<td>".$Row["id_muestra"]."</td>\n";
		}
		//---------FECHA MUESTRA---------------------------------------
		if ((!is_null($Row["fecha_muestra"])) && ($Row["fecha_muestra"] != ""))
			echo "<td align='center'>".substr($Row["fecha_muestra"],8,2)."/".substr($Row["fecha_muestra"],5,2)."/".substr($Row["fecha_muestra"],0,4)." ".substr($Row["fecha_muestra"],11,5)."</td>\n";
		else
			echo "<td align='center'>&nbsp;</td>\n";
		//----------------------Producto y  Subproducto --------------------------------------
		$Consulta = "select t2.abreviatura as AbrevProducto,t3.abreviatura as AbrevSubProducto ";
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
		$Consulta = "select * ";
		if($AnoIni<2009 && $AnoIni>0)
			$Consulta.=" from cal_histo.solicitud_analisis_a_".$AnoIni." t1 left join proyecto_modernizacion.sub_clase t2 ";
			else
			$Consulta.=" from cal_web.solicitud_analisis t1 left join proyecto_modernizacion.sub_clase t2 ";
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
			$Consulta = "select *,t2.abreviatura ";
			if($AnoIni<2009 && $AnoIni>0)
				$Consulta.="  from cal_histo.leyes_por_solicitud_a_".$AnoIni." t1";
				else
				$Consulta.="  from cal_web.leyes_por_solicitud t1";
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
						echo "<td width='70'>ND</td>\n";
					}
					else
					{	
						echo "<td width='70'>&nbsp;</td>\n";
					}
				}
				else	//echo "<td width='70'>".$Row2["valor"]."&nbsp;</td>\n";
					if ($Row2["candado"]== 1)
					{
						if($Row2["signo"]=="=")
						{
							echo "<td width='70'><font color='green'>".number_format($Row2["valor"],3)."&nbsp;".$Row2["abreviatura"]."</font></td>\n";
						}
						else
						{
							echo "<td width='70'><font color='green'>".$Row2["signo"].number_format($Row2["valor"],3)."&nbsp;".$Row2["abreviatura"]."</font></td>\n";
						}
					}
					else
					{
						if($Row2["signo"]=="=")
						{
							echo "<td width='70'>".number_format($Row2["valor"],3)."&nbsp;".$Row2["abreviatura"]."</td>\n";
						}
						else
						{
							echo "<td width='70'>".$Row2["signo"].number_format($Row2["valor"],3)."&nbsp;".$Row2["abreviatura"]."</td>\n";
						}
					}
			}
			else
			{
				echo "<td width='70' align='center'><img src='../principal/imagenes/ico_x.gif'></td>\n";
			}			
		}
		echo "</tr>\n";
	}
?>
  </table>
  <table width="760" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td height="25" align="center" valign="middle">Paginas &gt;&gt; 
            <?php		
			$Consulta = "select count(distinct t1.nro_solicitud,t1.recargo) as total_registros ";
			if($AnoIni<2009 && $AnoIni>0)
				$Consulta.= " from cal_histo.solicitud_analisis_a_".$AnoIni." t1";
				else
				$Consulta.= " from cal_web.solicitud_analisis t1";
			$Consulta.=" inner join proyecto_modernizacion.subproducto t2 on t1.cod_producto = t2.cod_producto and t1.cod_subproducto = t2.cod_subproducto ";
			$Consulta.= " where fecha_muestra between '".$FechaIni." 00:00:00' and '".$FechaFin." 23:59:59'";
			$Consulta.="  and ((t1.agrupacion = 1)or(t2.lotes='S')) and  ";//and (t1.id_muestra between '".$IdInicial."' and '".$IdFinal."') ";
			$Consulta.=$Pregunta;
			$Consulta.= " and (not isnull(nro_solicitud) or nro_solicitud = '') and (t1.estado_actual = '5' or t1.estado_actual ='6')";
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
					$StrPaginas.=  "<a href=JavaScript:Recarga('cal_con_leyes_lotes.php','".($i * $LimitFin)."');>";
					$StrPaginas.= ($i + 1)."</a>&nbsp;-&nbsp;\n";
				}
			}
			echo substr($StrPaginas,0,-15);
			?>
  </table>
  
</form>
</body>
</html>
