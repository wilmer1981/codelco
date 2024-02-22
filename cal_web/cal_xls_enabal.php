<?php 	        ob_end_clean();
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
include("../principal/conectar_principal.php");
$Fecha_Hora = date("d-m-Y h:i");
$CookieRut=$_COOKIE["CookieRut"];
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
if(isset($_REQUEST["CmbFlujos"])) {
	$CmbFlujos = $_REQUEST["CmbFlujos"];
}else{
	$CmbFlujos = "";
}
if(isset($_REQUEST["CmbPeriodo"])) {
	$CmbPeriodo = $_REQUEST["CmbPeriodo"];
}else{
	$CmbPeriodo = "";
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
<link>
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
  <?php
	  $Consulta="SELECT flujos from proyecto_modernizacion.subproducto where not isnull(flujos)";
	  $Respuesta=mysqli_query($link, $Consulta);
	  while($Fila=mysqli_fetch_array($Respuesta))
	  {
	  	//$Pregunta=$Pregunta."t4.flujos='".$Fila["flujos"]."' or ";
		$Pregunta="t4.flujos='".$Fila["flujos"]."' or ";
	  }
	  ?></select>
  <?php
	$FechaIni = $AnoIni."-".$MesIni."-".$DiaIni;
	$FechaFin = $AnoFin."-".$MesFin."-".$DiaFin;
	$Consulta = "select distinct(t2.cod_leyes), t3.abreviatura ";
	$Consulta = $Consulta." from cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t2 on t1.nro_solicitud = t2.nro_solicitud ";
	$Consulta = $Consulta." and t1.recargo = t2.recargo ";
	$Consulta = $Consulta." inner join proyecto_modernizacion.leyes t3 on t2.cod_leyes = t3.cod_leyes ";
	$Consulta = $Consulta."inner join proyecto_modernizacion.subproducto t4 on t1.cod_producto= t4.cod_producto and t1.cod_subproducto= t4.cod_subproducto";
	$Consulta = $Consulta." where (t1.fecha_muestra between '".$FechaIni." 00:00:00' and '".$FechaFin." 23:59:59')  ";
	if ($CmbPeriodo == "-1")//todos los periodos
	{
		if ($CmbFlujos=="-1")
		{
			$Pregunta=substr($Pregunta,0,strlen($Pregunta)-3);
			$Consulta = $Consulta." and (".$Pregunta.") order by t2.cod_leyes ";
		}
		else
		{
			$Consulta = $Consulta." and (t4.flujos = '".$CmbFlujos."') order by t2.cod_leyes ";
		}
	}
	else
	{
		if($CmbFlujos =="-1")
		{
			$Pregunta=substr($Pregunta,0,strlen($Pregunta)-3);
			$Consulta = $Consulta." and (".$Pregunta.") and (t1.cod_periodo = '".$CmbPeriodo."')  order by t2.cod_leyes ";
		}
		else
		{
			$Consulta = $Consulta." and (t4.flujos = '".$CmbFlujos."') and (t1.cod_periodo = '".$CmbPeriodo."') order by t2.cod_leyes";
		}
	}
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
  <table width="<?php echo $Total; ?>" border="1" cellpadding="0" cellspacing="0" >
    <tr align="center" valign="middle" > 
      <td width="136"><strong># Solicitud</strong></td>
      <td width="79"><strong>Agrupacion</strong></td>
	  <td width="120"><strong>Id. Muestra</strong></td>
      <td width="90"><strong>Flujos</strong></td>
	  <td width="144"><strong>Fecha Muestra</strong></td>
      <td width="90"><strong>Producto</strong></td>
      <td width="90"><strong>SubProducto</strong></td>
      <td width="75"><strong>Estado</strong></td>
    <?php
	for ($i = 0; $i < $LargoArreglo; $i++)
	{
		echo "<td>Signo</td>";
		echo "<td>".$ArregloLeyes[$i][1]."</td>\n";
		echo "<td>Unidad</td>";
	}
	?>
    </tr>
    <?php	
	$Consulta = "select fecha_muestra,nro_solicitud,recargo, if(length(recargo)=1,concat('0',recargo),recargo) as recargo_ordenado, id_muestra, ";
	$Consulta = $Consulta." rut_funcionario, fecha_hora,t1.agrupacion,t4.flujos ";
	$Consulta = $Consulta." , t1.nro_sa_lims from cal_web.solicitud_analisis t1 ";
	$Consulta = $Consulta."inner join proyecto_modernizacion.subproducto t4 on t1.cod_producto= t4.cod_producto and t1.cod_subproducto= t4.cod_subproducto";
	$Consulta = $Consulta." where (fecha_muestra between '".$FechaIni." 00:00:00' and '".$FechaFin." 23:59:59')";
	$Consulta = $Consulta." and (not isnull(nro_solicitud) or nro_solicitud = '') ";
	if ($CmbPeriodo == "-1")//todos los periodos
	{
		if ($CmbFlujos=="-1")
		{
			$Consulta = $Consulta." and (".$Pregunta.") order by t1.nro_solicitud,recargo_ordenado ";
		}
		else
		{
			$Consulta = $Consulta." and (t4.flujos = '".$CmbFlujos."') order by t1.nro_solicitud,recargo_ordenado ";
		}	
	}
	else
	{
		if($CmbFlujos =="-1")
		{
			$Consulta = $Consulta." and (".$Pregunta.") and (t1.cod_periodo = '".$CmbPeriodo."') order by t1.nro_solicitud,recargo_ordenado ";
		}
		else
		{
			$Consulta = $Consulta." and (t4.flujos = '".$CmbFlujos."') and (t1.cod_periodo = '".$CmbPeriodo."') order by t1.nro_solicitud,recargo_ordenado ";
		}
	}
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		echo "<tr align='left' valign='middle'>\n";
		if (is_null($Row["recargo"]) || ($Row["recargo"] == ""))
		{
			if ($Row["nro_sa_lims"]=='') {
				echo "<td>".$Row["nro_solicitud"]."</td>\n";
			}else{
				echo "<td>".$Row["nro_sa_lims"]."</td>\n";
			}

			//echo "<td>".$Row["nro_solicitud"]."</td>\n";
		}
		else
		{
			if ($Row["nro_sa_lims"]=='') {
				echo "<td>".$Row["nro_solicitud"]."-".$Row["recargo"]."</td>\n";
			}else{
				echo "<td>".$Row["nro_sa_lims"]."-".$Row["recargo"]."</td>\n";
			}


			//echo "<td>".$Row["nro_solicitud"]."-".$Row["recargo"]."</td>\n";
		}
		$Consulta ="select * from proyecto_modernizacion.sub_clase where cod_clase = 1004 and cod_subclase = '".$Row["agrupacion"]."'";
		$Resp1=mysqli_query($link, $Consulta);
		$Fil1=mysqli_fetch_array($Resp1);
		echo "<td>".$Fil1["nombre_subclase"]."</td>\n";
		echo "<td>".$Row["id_muestra"]."</td>\n";
		echo "<td>Flujos ".$Row["flujos"]."</td>\n";
		//---------FECHA MUESTRA---------------------------------------
		if ((!is_null($Row["fecha_muestra"])) && ($Row["fecha_muestra"] != ""))
			echo "<td align='center'>".substr($Row["fecha_muestra"],8,2)."/".substr($Row["fecha_muestra"],5,2)."/".substr($Row["fecha_muestra"],0,4)." ".substr($Row["fecha_muestra"],11,5)."</td>\n";
		else
			echo "<td align='center'>&nbsp;</td>\n";
		//----------------------Producto y  Subproducto --------------------------------------
		$Consulta = "select t2.abreviatura as AbrevProducto,t3.abreviatura as AbrevSubProducto from cal_web.solicitud_analisis t1 ";
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
		//-------------------------------------------------------
		for ($i = 0; $i < $LargoArreglo; $i++)
		{
			$Consulta = "select *,t2.abreviatura from cal_web.leyes_por_solicitud t1";
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
						echo "<td width='15'>&nbsp;</td>\n";
						echo "<td width='70'>&nbsp;&nbsp;</td>\n";
						echo "<td width='15'>&nbsp;</td>\n";
					}
					else
					{	
						if ($Row2["signo"] == '=')
						{
							echo "<td width='15'>&nbsp;</td>\n";
						}
						else
						{
							echo "<td width='15'>".$Row2["signo"]."</td>\n";
						}
						echo "<td>".number_format($Row2["valor"],3,",","")."</td>\n";
						echo "<td>".$Row2["abreviatura"]."</td>\n";
					}
				}
				else
				{
					echo "<td width='15'>&nbsp;</td>\n";
					echo "<td  width='70' align='center'>X</td>\n";
					echo "<td width='15'>&nbsp;</td>\n";
				}			
		}
		echo "</tr>\n";
	}
?>
  </table>
  <table width="760" border="0" cellpadding="0" cellspacing="0">
          <tr>
            
      <td height="25" align="center" valign="middle">&nbsp;</td>
          </tr></table>
</form>
</body>
</html>
