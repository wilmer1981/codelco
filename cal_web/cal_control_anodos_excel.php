<?php
	        ob_end_clean();
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

	$TipoProducto = $_REQUEST["TipoProducto"];
	$TxtFechaIni = $_REQUEST["TxtFechaIni"];
	$TxtFechaFin = $_REQUEST["TxtFechaFin"];
	$TxtDescripcion = $_REQUEST["TxtDescripcion"];
	$Valores = $_REQUEST["Valores"];

	//echo "Tipo Producto:".$TipoProducto;

	$Datos = explode("-",$TipoProducto);
	$Producto = $Datos[0];
	$SubProducto = $Datos[1];
	//PRODUCTO
	$Consulta = "select * from proyecto_modernizacion.productos where cod_producto='".$Producto."'";
	$Respuesta = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		$NomProducto = $Fila["descripcion"];
	}
	//SUB-PRODUCTO
	$Consulta = "select * from proyecto_modernizacion.subproducto where cod_producto='".$Producto."' and cod_subproducto='".$SubProducto."'";
	$Respuesta = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		$NomSubProducto = $Fila["descripcion"];
	}	
	//PERIODO
	$FechaIni = $TxtFechaIni;
	$FechaFin = $TxtFechaFin;
	$Periodo = substr($FechaIni,8,2)."-".substr($FechaIni,5,2)."-".substr($FechaIni,0,4);
	$Periodo.= " AL ".substr($FechaFin,8,2)."-".substr($FechaFin,5,2)."-".substr($FechaFin,0,4);
	
	//LEYES
	$ArrLeyes = array();
	$ArrLimites = array();
	$Datos = explode("//",$Valores);
	$i=1;
	$LimitesCons = "";
	//foreach($Datos as $k => $v)
	foreach($Datos as $k => $v )
	{
		$Datos2 = explode("~~",$v);
		if ($Datos2[0]=="AS/SB")
		{
			$Abrev = "As/Sb";
		}
		else
		{
			$Consulta = "select * from proyecto_modernizacion.leyes where cod_leyes = '".$Datos2[0]."'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Respuesta))
			{
				$Abrev = $Fila["abreviatura"];
			}		
		}
		//ARREGLO LEYES
		$ArrLeyes[$Datos2[0]][0] = $Datos2[0]; //COD_LEYES
		if ($Datos2[2] > 0)
			$ArrLeyes[$Datos2[0]][1] = $Datos2[1]; //SIGNO
		else
			$ArrLeyes[$Datos2[0]][1] = ""; //SIGNO
		$ArrLeyes[$Datos2[0]][2] = str_replace(",",".",$Datos2[2]); //VALOR
		$ArrLeyes[$Datos2[0]][3] = $Abrev;     //ABREVIATURA 
		//ARREGLO LIMITES
		if ($Datos2[2] > 0)
		{
			$ArrLimites[$Datos2[0]][0] = $Datos2[0]; //COD_LEYES
			$ArrLimites[$Datos2[0]][1] = $Datos2[1]; //SIGNO
			$ArrLimites[$Datos2[0]][2] = str_replace(",",".",$Datos2[2]); //VALOR
			$ArrLimites[$Datos2[0]][3] = $Abrev;     //ABREVIATURA 
			$LimitesCons.= $Abrev.$Datos2[1].$Datos2[2]."; ";
		}		
		$i++;
	}
	$LimitesCons = substr($LimitesCons,0,strlen($LimitesCons)-2);
	$LargoTabla = 240 + ($i*40);
?>
<html>
<head>
<title>CAL-Control de Anodos</title>
</head>

<body>
<form name="frmPrincipal" action="" method="post">
<table width="500" border="0" align="center" cellpadding="1" cellspacing="1">
  <tr align="center" bgcolor="#CCCCCC" class="ColorTabla01">
    <td colspan="10">CONTROL DE ANODOS </td>
    </tr>
  <tr bgcolor="#FFFFFF">
    <td width="124" colspan="3">Tipo de Producto:</td>
    <td width="458" colspan="7"><?php echo $NomSubProducto; ?></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td colspan="3">Periodo:</td>
    <td colspan="7"><?php echo $Periodo; ?></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td colspan="3">Limites Consultados:</td>
    <td colspan="7"><?php echo $LimitesCons; ?></td>
  </tr>
</table>
<BR><BR>
<table wi border="1" align="center" cellpadding="2" cellspacing="0">
  <tr align="center" bgcolor="#CCCCCC" class="ColorTabla01">
  	<td width="100">Fecha</td>
	<td width="80">Solicitud</td>
    <td width="80">Id.Muestra</td>
    <?php	
	//foreach($ArrLeyes as $k=>$v)
	foreach($ArrLeyes as $k => $v )
	{
		if ($v[1]!="")
			echo "<td width='40'>".$v[3]."<br>".$v[1]."".$v[2]."</td>\n";
		else
			echo "<td width='40'>".$v[3]."</td>\n";
	}
?>	
  </tr>
<?php  	
	$Consulta = "select distinct t1.fecha_muestra, t1.id_muestra as hornada, t1.nro_solicitud, t1.recargo ";
	$Consulta.= " from cal_web.solicitud_analisis t1 inner join cal_web.leyes_por_solicitud t2 on t1.nro_solicitud=t2.nro_solicitud ";
	$Consulta.= " and t1.recargo=t2.recargo ";
	$Consulta.= " where t1.cod_producto='".$Producto."' and t1.cod_subproducto='".$SubProducto."'";
	$Consulta.= " and t1.fecha_muestra between '".$FechaIni." 00:00:01' and '".$FechaFin." 23:59:59'";	
	$Consulta.= " and tipo<>'6'";
	$i=1;
	//while (list($k,$v)=each($ArrLimites))
	foreach($ArrLimites as $k => $v )
	{
		if ($v[0]!="AS/SB")
		{
			if ($i==1)
				$Consulta.= " and (";
			$Consulta.= "(t2.cod_leyes = '".$v[0]."') or "; //and t2.valor ".$v[1]." '".$v[2]."') or ";
			$i++;
		}
	}
	//------QUERY SENTENCIA MODIFICADA, YA QUE AL NO ENTRAR AL CICLO ANTERIOR, ELIMINABA 4 ESPACIOS HACIA ATRAS Y LA CONSULTA
	//------QUEDABA DE LA SIGUIENTE MANERA "and tipo<", por lo cual, se agrego un if($i>1) en linea siguiente asi solo elimina esos cuatros espacio
	//------al contener datos del ciclo anterior
	//------DVS / LRC 13-06-2014
	if($i>1)
		$Consulta = substr($Consulta,0,strlen($Consulta)-4);
	if ($i>1)
		$Consulta.= ")";
	if ($Producto != 0)
	{
		$Consulta.= " and t1.cod_producto = '".$Producto."'";
		if ($SubProducto != 0)
			$Consulta.= " and t1.cod_subproducto = '".$SubProducto."'";
	}
	$Consulta.= " order by t1.fecha_muestra, t1.id_muestra ";
	//echo $Consulta;
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		$ClaveChk="";
		echo "<tr bgcolor=\"white\">\n";
		echo "<td align='center'>".substr($Fila["fecha_muestra"],8,2)."/".substr($Fila["fecha_muestra"],5,2)."/".substr($Fila["fecha_muestra"],0,4)."</td>\n";		
		echo "<td align='center'>".intval(substr($Fila["nro_solicitud"],4))."</td>\n";
		echo "<td align='center'>".$Fila["hornada"]."</td>\n";
		$Consulta = "select * from cal_web.leyes_por_solicitud ";
		$Consulta.= " where cod_producto = '".$Producto."'";
		$Consulta.= " and cod_subproducto = '".$SubProducto."'";
		$Consulta.= " and id_muestra = '".$Fila["hornada"]."'";
		$Consulta.= " and nro_solicitud = '".$Fila["nro_solicitud"]."'";
		$Consulta.= " and recargo = '".$Fila["recargo"]."'";
		$Consulta.= " order by cod_leyes";
		$Resp2 = mysqli_query($link, $Consulta);
		while ($Fila2 = mysqli_fetch_array($Resp2))
		{			
			if( $ArrLeyes[$Fila2["cod_leyes"]][0]!="")
				$ArrLeyes[$Fila2["cod_leyes"]][4] = $Fila2["valor"];
		}
		if ($ArrLeyes["08"][4]>0 && $ArrLeyes["09"][4]>0)
			$ArrLeyes["AS/SB"][4] = $ArrLeyes["08"][4]/$ArrLeyes["09"][4];
		else
			$ArrLeyes["AS/SB"][4] = 0;
		reset($ArrLeyes);
		//foreach($ArrLeyes as $k=>$v)
		foreach($ArrLeyes as $k => $v )
		{
			$Color = "";
				if ($v[1] != "")
				{
					switch ($v[1])
					{
						case ">":
							if ($v[4]>$v[2])
								$Color="YELLOW";
							break;
						case "<":
							if ($v[4]<$v[2])
								$Color="YELLOW";
							break;
						case "=":
							if ($v[4]==$v[2])
								$Color="YELLOW";
							break;
					}
				}
				echo "<td align='right' bgcolor='".$Color."'>".number_format($v[4],2,",",".")."</td>\n";	
		}
		echo "</tr>\n";
		reset($ArrLeyes);
		do {			 
			$key = key ($ArrLeyes);
			$ArrLeyes[$key][4] = "";
		} while (next($ArrLeyes));	
	}
?>   
</table>
</form>
</body>
</html>
