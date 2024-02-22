<?php 

$CmbSubProductoAux = $_REQUEST['CmbSubProductoAux'];
//$CmbSubProducto    = $_REQUEST['CmbSubProducto'];
$CmbProveedorAux   = $_REQUEST['CmbProveedorAux'];
$CmbProveedor      = $_REQUEST['CmbProveedor'];

$CmbAno     = $_REQUEST['CmbAno'];
$CmbMes     = $_REQUEST['CmbMes'];
//$Plantilla     = $_REQUEST['Plantilla'];
//$PopUp = $_REQUEST['PopUp'];

//$CmbAnoIni      = $_REQUEST['CmbAnoIni'];
//$CmbAnoFin      = $_REQUEST['CmbAnoFin']; 


ob_end_clean();
$file_name=basename($_SERVER['PHP_SELF']).".xls";
$userBrowser = $_SERVER['HTTP_USER_AGENT'];
$filename="";
if ( preg_match( '/MSIE/i', $userBrowser ) ) 
{
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
	$MesActual=intval(date("m"));
	$MesAnt=intval(date("m"))-1;
	$A�oActual=date("Y");
	//---------------LLENA ARREGLO DE LEYES----------------
	//SELECCIONA LAS LEYES QUE TIENEN VALOR	
	$ArrLeyes = array();
	$Consulta = "select cod_producto";
	for ($i=1;$i<=60;$i++)
	{
		$Consulta.= ",sum(c_".str_pad($i,2,'0',STR_PAD_LEFT).") as c_".str_pad($i,2,'0',STR_PAD_LEFT)."";
	}
	$Consulta.= " from age_web.historico ";
	$Consulta.= " where ano='".$CmbAno."' and mes='".$CmbMes."'";
	$Consulta.= " and cod_producto='1' and cod_subproducto='".$CmbSubProductoAux."'";
	$Consulta.= " and rut_proveedor='".$CmbProveedorAux."'";
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
	$Consulta.= " and cod_producto='1' and cod_subproducto='".$CmbSubProductoAux."'";
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
	if ($CmbProveedorAux!="S")
	{
		//BUSCO POR PROVEEDOR
		$Consulta = "select distinct t1.cod_leyes, t2.abreviatura, t1.decimales, t1.cod_unidad, t3.abreviatura as nombre_unidad, t3.conversion ";
		$Consulta.= " from age_web.param_leyes t1 inner join  proyecto_modernizacion.leyes t2 on t1.cod_leyes=t2.cod_leyes ";
		$Consulta.= " inner join proyecto_modernizacion.unidades t3 on t1.cod_unidad=t3.cod_unidad ";
		$Consulta.= " where t1.tipo='L' ";
		$Consulta.= " and cod_producto='1' and cod_subproducto='".$CmbSubProductoAux."'";
		$Consulta.= " and rut_proveedor='".$CmbProveedorAux."'";
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
<input type="hidden" name="CmbAno" value="<?php echo $CmbAno; ?>">
<input type="hidden" name="CmbMes" value="<?php echo $CmbMes; ?>">
<input type="hidden" name="CmbSubProductoAux" value="<?php echo $CmbSubProductoAux; ?>">
<input type="hidden" name="CmbProveedorAux" value="<?php echo $CmbProveedorAux; ?>">
  <table width="500" border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
    <tr align="center" class="ColorTabla01"> 
      <td height="20" colspan="10"><strong><font>CONSULTA LEYES HISTORICAS POR LOTE </font></strong></td>
    </tr>
    <tr> 
      <td colspan="10">&nbsp;</td>
    </tr>
    <tr> 
      <td width="94" colspan="3">SubProducto:</td>
      <td width="391" colspan="7"> 
        <?php
	$Consulta = "select * from proyecto_modernizacion.subproducto ";
	$Consulta.= " where cod_producto='1' and cod_subproducto='".$CmbSubProductoAux."'";	
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
	$Consulta = "select rutprv_a, nomprv_a from rec_web.proved where rutprv_a='".$CmbProveedorAux."'";	
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
      <td colspan="3">Periodo:</td>
    <td colspan="7"><?php echo strtoupper($Meses[$CmbMes-1])."/".$CmbAno; ?></td>
    </tr>
  </table>
  <br>
  <br>  
			
<?php		
		$ArrTotal = array();
		$TotalPesoHum = 0;
		$CantLotes = 0;
		echo "<table width='700' border='1' cellpadding='2' cellspacing='0' class='TablaDetalle' align='center'>\n";
        echo "<tr class='ColorTabla01'> \n";
		echo "<td width=60 align='center'>LOTE</td>\n";
		switch ($CmbSubProductoAux)
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
		//while (list($k,$v)=each($ArrLeyes))
		foreach ($ArrLeyes as $k => $v)  
		{
			//if ($v["usada"]=="S")
			if (isset($v["usada"]) && $v["usada"]=="S")
			{
				echo "<td width=60 align='center'>".$v["abreviatura"]."<br>(".$v["nom_unidad"].")</td>\n";
				$ColSpan++;
			}
		}		
        echo "</tr>\n";
		$Consulta = "select ano, mes, cod_producto, cod_subproducto, rut_proveedor, lote, nomprv_a as nom_proveedor,sum(peso_humedo) as peso_humedo, sum(peso_seco) as peso_seco ";
		for ($i=1;$i<=60;$i++)
		{
			$Consulta.= " , (sum(peso_seco * c_".str_pad($i,2,'0',STR_PAD_LEFT).") / sum(peso_seco)) as c_".str_pad($i,2,'0',STR_PAD_LEFT)." ";
		}
		$Consulta.= " from age_web.historico t1 inner join rec_web.proved t2 on t1.rut_proveedor=t2.rutprv_a ";
		$Consulta.= " where ano='".$CmbAno."' and mes='".$CmbMes."' ";
		$Consulta.= " and cod_producto='1' and cod_subproducto='".$CmbSubProductoAux."'";
		if ($CmbProveedorAux!="S")
			$Consulta.= " and rut_proveedor='".$CmbProveedorAux."'";
		$Consulta.= " group by ano, mes, lote ";
		$Consulta.= " order by ano, lpad(mes,2,'0'), lote ";		
		$Resp = mysqli_query($link, $Consulta);
		$Clase = "ColorTabla02";
		$ProvAnt="";
		while ($Fila = mysqli_fetch_array($Resp))
		{
			if ($ProvAnt!=$Fila["rut_proveedor"])
			{
				$ColSpan=$ColSpan+2; 
				echo "<tr class='ColorTabla01'><td colspan='".$ColSpan."'>".strtoupper($Fila["nom_proveedor"])."</td></tr>\n";
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
			echo "<td align='right'>".$Fila["lote"]."</td>\n";
			echo "<td align='right'>".number_format($Fila["peso_humedo"],0,',','.')."</td>\n";
			for ($i=1; $i<=60; $i++)
			{
				$CodLey=str_pad($i,2,'0',STR_PAD_LEFT);
				$ArrLeyes[$CodLey]["valor"] = $Fila["c_".str_pad($i,2,'0',STR_PAD_LEFT).""];				
			}		
			reset($ArrLeyes);
			//while (list($k,$v)=each($ArrLeyes))
			
			foreach ($ArrLeyes as $k => $v) 
			{
				//if ($v["usada"]=="S")
				$ArrTotales =0;
				if (isset($v["usada"]) && $v["usada"]=="S")
				{
					echo "<td align='right'>";
					if (($Fila["ano"] == $A�oActual) && ( $Fila["mes"]==$MesActual || $Fila["mes"]==$MesAnt ))
						if(($v["cod_leyes"]== '02')|| $v["cod_leyes"]== '05' || $v["cod_leyes"]== '04')
						{
							echo "&nbsp;";
							$ArrTotal[$v["cod_leyes"]]["valor"] = "&nbsp";
							$ArrTotal[$v["cod_leyes"]]["usada"] = "X";
							$ArrTotal[$v["cod_leyes"]]["conversion"] = "&nbsp";
							$ArrTotal[$v["cod_leyes"]]["decimales"] = "&nbsp";
						}
						else
						{
							echo number_format($v["valor"],$v["decimales"],",",".");
							$ArrTotal[$v["cod_leyes"]]["valor"] = $ArrTotal[$v["cod_leyes"]]["valor"] + (($v["valor"]*$Fila["peso_humedo"])/$v["conversion"]);
							$ArrTotal[$v["cod_leyes"]]["usada"] = "S";
							$ArrTotal[$v["cod_leyes"]]["conversion"] = $v["conversion"];
							$ArrTotal[$v["cod_leyes"]]["decimales"] = $v["decimales"];
						}
					else
					{
						echo number_format($v["valor"],$v["decimales"],",",".");
						if(isset($ArrTotal[$v["cod_leyes"]]["valor"])){
							$ArrTotales = $ArrTotal[$v["cod_leyes"]]["valor"];
						}
						$ArrTotal[$v["cod_leyes"]]["valor"] = $ArrTotales + (($v["valor"]*$Fila["peso_humedo"])/$v["conversion"]);
						$ArrTotal[$v["cod_leyes"]]["usada"] = "S";
						$ArrTotal[$v["cod_leyes"]]["conversion"] = $v["conversion"];
						$ArrTotal[$v["cod_leyes"]]["decimales"] = $v["decimales"];
					}		
					echo "</td>\n";
				}
			}
			echo "</tr>\n";
			$ProvAnt=$Fila["rut_proveedor"];
			$TotalPesoHum=$TotalPesoHum+$Fila["peso_humedo"];
			$CantLotes++;
		}		
		//TOTALES
		echo "<tr>\n";
		echo "<td align='center'><strong>".number_format($CantLotes,0,',','.')."</strong></td>\n";
		echo "<td align='right'>".number_format($TotalPesoHum,0,',','.')."</td>\n";
		reset($ArrTotal);
		//while (list($k,$v)=each($ArrTotal))	
		foreach ($ArrLeyes as $k => $v) 
		{
			//if ($v["usada"]=="S")
			if (isset($v["usada"]) && $v["usada"]=="S")
			{
				echo "<td align='right'>".number_format(($v["valor"]/$TotalPesoHum)*$v["conversion"],$v["decimales"],",",".")."</td>\n";				
			}
			else
				//if($v["usada"]=="X")
				if (isset($v["usada"]) && $v["usada"]=="X")
					echo "<td align='right'>&nbsp;</td>\n";				
		}
		echo "</tr>\n";
		echo "</table>\n";
?>
              
             
<br>
</form>
</body>
</html>
