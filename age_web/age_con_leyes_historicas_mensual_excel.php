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
	include("../principal/conectar_principal.php");
	//---------------LLENA ARREGLO DE LEYES----------------	
	//SELECCIONA LAS LEYES QUE TIENEN VALOR	
	$ArrLeyes = array();
	$Consulta = "select cod_producto";
	for ($i=1;$i<=60;$i++)
	{
		$Consulta.= ",sum(c_".str_pad($i,2,'0',STR_PAD_LEFT).") as c_".str_pad($i,2,'0',STR_PAD_LEFT)."";
	}
	$Consulta.= " from age_web.historico ";
	$Consulta.= " where ano between '".$CmbAnoIni."' and '".$CmbAnoFin."' ";
	$Consulta.= " and cod_producto='1' and cod_subproducto='".$CmbSubProducto."'";
	if ($CmbProveedor!="S")
		$Consulta.= " and rut_proveedor='".$CmbProveedor."'";
	$Consulta.= " group by cod_producto ";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{
		for ($i=1;$i<=60;$i++)
		{
			if ($Fila["c_".str_pad($i,2,'0',STR_PAD_LEFT).""]>0)
			{
				$CodLey=str_pad($i,2,'0',STR_PAD_LEFT);				
				$ArrLeyes[$CodLey]["usada"]="S";
			}
		}
	}
	//BUSCO LA GENERAL;
	$Consulta = "select distinct t1.cod_leyes, t2.abreviatura, t1.decimales, t1.cod_unidad, t3.abreviatura as nombre_unidad, t3.conversion ";
	$Consulta.= " from age_web.param_leyes t1 inner join  proyecto_modernizacion.leyes t2 on t1.cod_leyes=t2.cod_leyes ";
	$Consulta.= " inner join proyecto_modernizacion.unidades t3 on t1.cod_unidad=t3.cod_unidad ";
	$Consulta.= " where t1.tipo='L' ";
	$Consulta.= " and cod_producto='1' and cod_subproducto='0'";
	$Consulta.= " and rut_proveedor='99999999-9'";
	$Consulta.= " order by cod_leyes";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{
		$ArrLeyes[$Fila["cod_leyes"]]["cod_leyes"]=$Fila["cod_leyes"];
		$ArrLeyes[$Fila["cod_leyes"]]["abreviatura"]=$Fila["abreviatura"];
		$ArrLeyes[$Fila["cod_leyes"]]["valor"]="";
		$ArrLeyes[$Fila["cod_leyes"]]["cod_unidad"]=$Fila["cod_unidad"];
		$ArrLeyes[$Fila["cod_leyes"]]["nom_unidad"]=$Fila["nombre_unidad"];
		$ArrLeyes[$Fila["cod_leyes"]]["conversion"]=$Fila["conversion"];
		$ArrLeyes[$Fila["cod_leyes"]]["decimales"]=$Fila["decimales"];
	}
	//BUSCO POR SUBPRODUCTO
	$Consulta = "select distinct t1.cod_leyes, t2.abreviatura, t1.decimales, t1.cod_unidad, t3.abreviatura as nombre_unidad, t3.conversion ";
	$Consulta.= " from age_web.param_leyes t1 inner join  proyecto_modernizacion.leyes t2 on t1.cod_leyes=t2.cod_leyes ";
	$Consulta.= " inner join proyecto_modernizacion.unidades t3 on t1.cod_unidad=t3.cod_unidad ";
	$Consulta.= " where t1.tipo='L' ";
	$Consulta.= " and cod_producto='1' and cod_subproducto='".$CmbSubProducto."'";
	$Consulta.= " and rut_proveedor='99999999-9'";
	$Consulta.= " order by cod_leyes";
	$Resp = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Resp))
	{
		$ArrLeyes[$Fila["cod_leyes"]]["cod_leyes"]=$Fila["cod_leyes"];
		$ArrLeyes[$Fila["cod_leyes"]]["abreviatura"]=$Fila["abreviatura"];
		$ArrLeyes[$Fila["cod_leyes"]]["valor"]="";
		$ArrLeyes[$Fila["cod_leyes"]]["cod_unidad"]=$Fila["cod_unidad"];
		$ArrLeyes[$Fila["cod_leyes"]]["nom_unidad"]=$Fila["nombre_unidad"];
		$ArrLeyes[$Fila["cod_leyes"]]["conversion"]=$Fila["conversion"];
		$ArrLeyes[$Fila["cod_leyes"]]["decimales"]=$Fila["decimales"];
	}
	if ($CmbProveedor!="S")
	{
		//BUSCO POR PROVEEDOR
		$Consulta = "select distinct t1.cod_leyes, t2.abreviatura, t1.decimales, t1.cod_unidad, t3.abreviatura as nombre_unidad, t3.conversion ";
		$Consulta.= " from age_web.param_leyes t1 inner join  proyecto_modernizacion.leyes t2 on t1.cod_leyes=t2.cod_leyes ";
		$Consulta.= " inner join proyecto_modernizacion.unidades t3 on t1.cod_unidad=t3.cod_unidad ";
		$Consulta.= " where t1.tipo='L' ";
		$Consulta.= " and cod_producto='1' and cod_subproducto='".$CmbSubProducto."'";
		$Consulta.= " and rut_proveedor='".$CmbProveedor."'";
		$Consulta.= " order by cod_leyes";
		$Resp = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Resp))
		{
			$ArrLeyes[$Fila["cod_leyes"]]["cod_leyes"]=$Fila["cod_leyes"];
			$ArrLeyes[$Fila["cod_leyes"]]["abreviatura"]=$Fila["abreviatura"];
			$ArrLeyes[$Fila["cod_leyes"]]["valor"]="";
			$ArrLeyes[$Fila["cod_leyes"]]["cod_unidad"]=$Fila["cod_unidad"];
			$ArrLeyes[$Fila["cod_leyes"]]["nom_unidad"]=$Fila["nombre_unidad"];
			$ArrLeyes[$Fila["cod_leyes"]]["conversion"]=$Fila["conversion"];
			$ArrLeyes[$Fila["cod_leyes"]]["decimales"]=$Fila["decimales"];
		}
	}

?>
<html>
<head>
<title>Sistema de Agencia</title>
</head>

<body>
<form name="frmPrincipal" action="" method="post">
<input type="hidden" name="CmbAnoIni" value="<?php echo $CmbAnoIni; ?>">
<input type="hidden" name="CmbAnoFin" value="<?php echo $CmbAnoFin; ?>">
<input type="hidden" name="CmbSubProducto" value="<?php echo $CmbSubProducto; ?>">
<input type="hidden" name="CmbProveedor" value="<?php echo $CmbProveedor; ?>">
  <table width="500" border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
    <tr align="center" class="ColorTabla01"> 
      <td height="20" colspan="10"><strong><font>CONSULTA LEYES HISTORICAS MENSUAL </font></strong></td>
    </tr>
    <tr> 
      <td colspan="10">&nbsp;</td>
    </tr>
    <tr> 
      <td width="94" colspan="3">SubProducto:</td>
      <td width="391" colspan="7"> 
        <?php
	$Consulta = "select * from proyecto_modernizacion.subproducto ";
	$Consulta.= " where cod_producto='1' and cod_subproducto='".$CmbSubProducto."'";	
	$Resp = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Resp))
		echo $Fila["cod_subproducto"]." - ".strtoupper($Fila["descripcion"]);
	else
		echo "&nbsp;";
	?>
      </td>
    </tr>
    <tr> 
      <td colspan="3">Proveedor:</td>
      <td colspan="7"> 
        <?php
if ($CmbProveedor=="S")
{
	echo "TODOS";
}
else
{		
	$Consulta = "select rutprv_a, nomprv_a from rec_web.proved where rutprv_a='".$CmbProveedor."'";	
	$Resp = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Resp))
		echo str_pad($Fila["rutprv_a"],10,'0')." - ".strtoupper($Fila["nomprv_a"]);
	else
		echo "&nbsp;";
}		
	?>
      </td>
    </tr>
    <tr>
      <td colspan="3">Rango:</td>
    <td colspan="7"><?php echo $CmbAnoIni." al ".$CmbAnoFin; ?></td>
    </tr>
  </table>
  <br>
  <br>
  <strong><font size="1">Seleccione Mes ver el Detalle de los Lotes</font></strong><br>  
			
<?php		
	echo "<table width='1000' border='1' cellpadding='2' cellspacing='0' class='TablaDetalle'>\n";
	echo "<tr class='ColorTabla01'> \n";
	echo "<td width=60 align='center'>AÑO</td>\n";
	echo "<td width=60 align='center'>MES</td>\n";
	switch ($CmbSubProducto)
	{
		case "43":
			echo "<td width=60 align='center'>PESO (kg.)</td>\n";
			break;
		case "58":
			echo "<td width=60 align='center'>PESO (kg.)</td>\n";
			break;
		default:
			echo "<td width=60 align='center'>PESO (ton.)</td>\n";
			break;
		
	}    
	reset($ArrLeyes);
	$ColSpan=0;
	foreach($ArrLeyes as $k => $v)   
	{
		if ($v["usada"]=="S")
		{
			echo "<td width=60 align='center'>".$v["abreviatura"]."<br>(".$v["nom_unidad"].")</td>\n";
			$ColSpan++;
		}
	}		
	echo "</tr>\n";
	$Consulta = "select ano, mes, cod_producto, cod_subproducto, rut_proveedor, nomprv_a as nom_proveedor,sum(peso_humedo) as peso_humedo, sum(peso_seco) as peso_seco ";
	for ($i=1;$i<=60;$i++)
	{
		$Consulta.= " , (sum(peso_seco * c_".str_pad($i,2,'0',STR_PAD_LEFT).") / sum(peso_seco)) as c_".str_pad($i,2,'0',STR_PAD_LEFT)." ";
	}
	$Consulta.= " from age_web.historico t1 inner join rec_web.proved t2 on t1.rut_proveedor=t2.rutprv_a ";
	if(isset($MesAnt)&&$MesAnt=='S')
	{
		$FechaAnoMes=$CmbAnoFin.str_pad($Mes,2,"0",STR_PAD_LEFT);
		$Consulta.= " where concat(ano,lpad(mes,2,'0'))<='".$FechaAnoMes."' ";
	}
	else
	{
		$Consulta.= " where ano between '".$CmbAnoIni."' ";
		$Consulta.= " and ".$CmbAnoFin." ";
	}
	$Consulta.= " and cod_producto='1' and cod_subproducto='".$CmbSubProducto."'";
	if ($CmbProveedor!="S")
		$Consulta.= " and rut_proveedor='".$CmbProveedor."'";
	$Consulta.= " group by ano, mes,rut_proveedor ";
	$Consulta.= " order by rut_proveedor, ano, lpad(mes,2,'0') ";		
	$Resp = mysqli_query($link, $Consulta);
	$Clase = "ColorTabla02";
	$ProvAnt="";
	$AnoAnt="";
	$ArrTotal=array();
	while ($Fila = mysqli_fetch_array($Resp))
	{
		if ($Fila["ano"]!=$AnoAnt && $AnoAnt!="")
			TotalAnual($AnoAnt, &$TotalPesoHum, &$ArrTotal);
		if ($ProvAnt!=$Fila["rut_proveedor"])
		{
			$ColSpan=$ColSpan+3; 
			echo "<tr class='ColorTabla01'><td colspan=\"".$ColSpan."\">".strtoupper($Fila["nom_proveedor"])."</td></tr>\n";
		}
		if ($Clase == "ColorTabla02")
		{
			echo "<tr class='".$Clase."'>\n";
			$Clase = "";
		}
		else
		{				
			echo "<tr class='".$Clase."'>\n";	
			$Clase = "ColorTabla02";		
		}
		echo "<td align='center'>".$Fila["ano"]."</td>\n";
		echo "<td align='center'>".strtoupper(substr($Meses[$Fila["mes"]-1],0,3))."</td>\n";
		echo "<td align='right'>".number_format($Fila["peso_humedo"],0,',','.')."</td>\n";
		for ($i=1; $i<=60; $i++)
		{
			$CodLey=str_pad($i,2,'0',STR_PAD_LEFT);			
			$ArrLeyes[$CodLey]["valor"] = $Fila["c_".str_pad($i,2,'0',STR_PAD_LEFT).""];
		}		
		reset($ArrLeyes);
		foreach($ArrLeyes as $k => $v)	
		{
			if ($v["usada"]=="S")
			{
				echo "<td align='right'>".number_format($v["valor"],$v["decimales"],",",".")."</td>\n";
				$ArrTotal[$v["cod_leyes"]]["valor"] = $ArrTotal[$v["cod_leyes"]]["valor"] + (($v["valor"]*$Fila["peso_humedo"])/$v["conversion"]);
				$ArrTotal[$v["cod_leyes"]]["usada"] = "S";
				$ArrTotal[$v["cod_leyes"]]["conversion"] = $v["conversion"];
				$ArrTotal[$v["cod_leyes"]]["decimales"] = $v["decimales"];
			}
		}
		echo "</tr>\n";
		$ProvAnt=$Fila["rut_proveedor"];
		$AnoAnt = $Fila["ano"];
		$TotalPesoHum=$TotalPesoHum+$Fila["peso_humedo"];
	}
	TotalAnual($AnoAnt, &$TotalPesoHum, &$ArrTotal);
	echo "</table>\n";
		
function TotalAnual($Ano, $TotalPesoH, $ArrTotalLeyes)
{
	//TOTALES
	echo "<tr bgcolor='#6699CC'>\n";
	echo "<td align='center' colspan=\"2\"><strong>".$Ano."</strong></td>\n";
	echo "<td align='right'>".number_format($TotalPesoH,0,',','.')."</td>\n";
	reset($ArrTotalLeyes);
	while (list($k,$v)=each($ArrTotalLeyes))	
	{
		if ($v["usada"]=="S")
		{
			echo "<td align='right'>".number_format(($v["valor"]/$TotalPesoH)*$v["conversion"],$v["decimales"],",",".")."</td>\n";				
		}
	}
	echo "</tr>\n";
	$ArrTotalLeyes=array();
	$TotalPesoH=0;
}
?>
              
             
<br>
  <input type="hidden" name="TipoProd" value="<?php echo $TipoProd;?>">
<input type="hidden" name="RutProv" value="<?php echo $RutProv;?>">
</form>
</body>
</html>
