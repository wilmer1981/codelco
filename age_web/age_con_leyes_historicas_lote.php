<?php 
	include("../principal/conectar_principal.php");
	//COLORES DE LIMITES
	$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase='15007'";
	$Resp=mysqli_query($link, $Consulta);
	while ($Fila=mysqli_fetch_array($Resp))
	{
		switch ($Fila["cod_subclase"])
		{
			case 1:
				$BajoMin=$Fila["valor_subclase1"];
				break;
			case 2:
				$SobreMax=$Fila["valor_subclase1"];
				break;
		}
	}
	//ARREGLO DE LIMITES
	$ArrLimites=array();
	if (isset($Plantilla) && $Plantilla!="S")
	{		
		$Consulta = "select * from age_web.limites where cod_plantilla='".$Plantilla."'";
		$Resp = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Resp))
		{
			$ArrLimites[$Fila["cod_leyes"]]["min"]=$Fila["limite_minimo"];
			$ArrLimites[$Fila["cod_leyes"]]["med"]=$Fila["limite_medio"];
			$ArrLimites[$Fila["cod_leyes"]]["max"]=$Fila["limite_maximo"];
			$ArrLimites[$Fila["cod_leyes"]]["usada"]="S";
		}
	}	
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
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
<!--
var OK;
ns4 = (document.layers)? true:false
ie4 = (document.all)? true:false
function muestra(numero) 
{
 	if (ns4){ 
 		eval("document. " + numero + ".visibility = 'show'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'visible'");
			//eval("Txt" + numero + ".style.left = 50 ");
		}
	}
}

function oculta(numero) 
{
	if (ns4){ 
 		eval("document. " + numero + ".visibility = hide'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'hidden'");
		}
	}
}

function Proceso(opcion)
{
	var f = document.frmPrincipal;
	switch (opcion)
	{
		case "S":
			f.action = "age_con_leyes_historicas_mensual.php?CmbAnoIni=<?php echo $CmbAnoIni; ?>&CmbAnoFin=<?php echo $CmbAnoFin; ?>&CmbSubProducto=<?php echo $CmbSubProducto; ?>&CmbProveedor=<?php echo $CmbProveedor; ?>&Plantilla=<?php echo $Plantilla; ?>";			
			f.submit();
			break;	
		case "E":
			f.action = "age_con_leyes_historicas_lote_excel.php";			
			f.submit();
			break;
		case "I":
			f.BtnImprimir.style.visibility = "hidden";
			f.BtnExcel.style.visibility = "hidden";
			f.BtnSalir.style.visibility = "hidden";
			window.print();
			f.BtnImprimir.style.visibility = "visible";
			f.BtnExcel.style.visibility = "visible";
			f.BtnSalir.style.visibility = "visible";
			break;
	}
}

//-->
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><style type="text/css">
<!--
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
-->
</style></head>

<body>
<form name="frmPrincipal" action="" method="post">
<input type="hidden" name="CmbAno" value="<?php echo $CmbAno; ?>">
<input type="hidden" name="CmbMes" value="<?php echo $CmbMes; ?>">
<input type="hidden" name="CmbSubProductoAux" value="<?php echo $CmbSubProductoAux; ?>">
<input type="hidden" name="CmbProveedorAux" value="<?php echo $CmbProveedorAux; ?>">
  <table width="500" border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
    <tr align="center" class="ColorTabla01"> 
      <td height="20" colspan="2"><strong><font>CONSULTA LEYES HISTORICAS POR LOTE </font></strong></td>
    </tr>
    <tr> 
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr> 
      <td width="94">SubProducto:</td>
      <td width="391"> 
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
      <td>Proveedor:</td>
      <td> 
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
      <td>Periodo:</td>
    <td><?php echo strtoupper($Meses[$CmbMes-1])."/".$CmbAno; ?></td>
    </tr>
<?php	
if ($Plantilla!="S")
{
	echo "<tr>\n";
	echo "<td>Plantilla: </td>\n";
	echo "<td>\n";
	//BUSCO PLANTILLA PARA SUBPRODUCTO PROVEEDOR
	$Consulta = "select DISTINCT cod_plantilla, descripcion ";
	$Consulta.= " from age_web.limites ";
	$Consulta.= " where cod_plantilla='".$Plantilla."'";
	$Consulta.= " order by descripcion ";
	$Resp = mysqli_query($link, $Consulta);
	$Encontro=false;
	if ($Fila = mysqli_fetch_array($Resp))
	{
		$Encontro=true;
		echo strtoupper($Fila["descripcion"]);
	}	
	if (!$Encontro)
		echo "SIN PLANTILLA";				
	echo "</td>\n";
	echo "</tr>\n";
	//COLORES
	echo "<tr align='center'>\n";
	echo "<td colspan='2'><table width='240' border='1' cellpadding='2' cellspacing='0' class='TablaInterior'>\n";
	echo "<tr align='center'>\n";
	echo "<td width='120' bgcolor='".$BajoMin."'>Bajo Min.</td>\n";
	echo "<td width='120' bgcolor='".$SobreMax."'>Sobre Max.</td>\n";
	echo "</tr>\n";
	echo "</table></td>\n";
	echo "</tr>\n";
}	
?>		
    <tr align="center"> 
      <td height="30" colspan="2"><input name="BtnImprimir" type="button" id="BtnImprimir" style="width:70" onClick="JavaScript:Proceso('I');" value="Imprimir">
      <input type="button" name="BtnExcel" value="Excel" style="width:70" onClick="JavaScript:Proceso('E');">
	  <?php
	  	if ($PopUp=="S")
		{
		?>
		<input name="BtnCerrar" type="button" style="width:70" onClick="JavaScript:window.close()" value="Cerrar"></td>
		<?php
		}
		else{
	  ?>
        <input name="BtnSalir" type="button" id="BtnSalir" style="width:70" onClick="JavaScript:Proceso('S');" value="Salir"></td>
	  <?php
	  	}
	  ?>
	  
      
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
		while (list($k,$v)=each($ArrLeyes))   
		{
			if ($v["usada"]=="S")
			{
				if ($ArrLimites[$k]["usada"]=="S")
				{
					echo "<td onMouseOver=\"JavaScript:muestra('".$v["abreviatura"]."');\" onMouseOut=\"JavaScript:oculta('".$v["abreviatura"]."');\">";
					echo "<div id='Txt".$v["abreviatura"]."' style= 'position:Absolute; background-color:#fff4cf; visibility:hidden; border:solid 1px Black;width:140px'>\n";
					echo "<table width='140' border='1' cellpadding='2' cellspacing='0' class='TablaInterior'>";
					echo "<tr class='ColorTabla01'><td colspan=\"3\" align='center'><strong>".$v["abreviatura"]."</strong></td></tr>";
					echo "<tr align='center'><td width='70'>Min.</td><td width='70'>Max.</td></tr>";
					echo "<tr align='center' class='Detalle01'><td>".$ArrLimites[$k]["min"]."</td><td>".$ArrLimites[$k]["max"]."</td></tr>";
					echo "<tr align='center'><td colspan='2'>Prom.Mes</td></tr>";
					echo "<tr align='center' class='Detalle01'><td colspan='2'>".$ArrLimites[$k]["med"]."</td></tr>";
					echo "</table></div>";
				}
				else
				{
					echo "<td width=60 align='center' >\n";
				}
				echo $v["abreviatura"]."<br>(".$v["nom_unidad"].")</td>\n";
				$ColSpan++;
			}
		}		
        echo "</tr>\n";
		$Consulta = "select ano, mes, cod_producto, cod_subproducto, rut_proveedor, lote, nomprv_a as nom_proveedor,sum(peso_humedo) as peso_humedo, sum(peso_seco) as peso_seco ";
		for ($i=1;$i<=60;$i++)
		{
			$Consulta.= " , round(sum(peso_seco * round(c_".str_pad($i,2,'0',STR_PAD_LEFT).",3)) / sum(peso_seco),3) as c_".str_pad($i,2,'0',STR_PAD_LEFT)." ";
		}
		$Consulta.= " from age_web.historico t1 inner join rec_web.proved t2 on t1.rut_proveedor=t2.rutprv_a ";
		$Consulta.= " where ano='".$CmbAno."' and mes='".$CmbMes."' ";
		$Consulta.= " and cod_producto='1' and cod_subproducto='".$CmbSubProductoAux."'";
		if ($CmbProveedorAux!="S")
			$Consulta.= " and rut_proveedor='".$CmbProveedorAux."'";
		$Consulta.= " group by ano, mes, lote ";
		$Consulta.= " order by ano, lpad(mes,2,'0'), lote ";
		//echo $Consulta."<br>";		
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
			while (list($k,$v)=each($ArrLeyes))	
			{
				if ($v["usada"]=="S")
				{
					$Color="";
					AsignaColor("", $v["cod_leyes"], $v["valor"], $ArrLimites, &$Color, $BajoMin, $SobreMax);
					echo "<td align='right' bgcolor='".$Color."'>".number_format($v["valor"],$v["decimales"],",",".")."</td>\n";
					$ArrTotal[$v["cod_leyes"]]["valor"] = $ArrTotal[$v["cod_leyes"]]["valor"] + (($v["valor"]*$Fila["peso_humedo"])/$v["conversion"]);
					$ArrTotal[$v["cod_leyes"]]["usada"] = "S";
					$ArrTotal[$v["cod_leyes"]]["conversion"] = $v["conversion"];
					$ArrTotal[$v["cod_leyes"]]["decimales"] = $v["decimales"];
				}
			}
			echo "</tr>\n";
			$ProvAnt=$Fila["rut_proveedor"];
			$TotalPesoHum=$TotalPesoHum+$Fila["peso_humedo"];
			$CantLotes++;
		}		
		//TOTALES
		echo "<tr bgcolor='#66FFFF'>\n";
		echo "<td align='center'><strong>".number_format($CantLotes,0,',','.')."</strong></td>\n";
		echo "<td align='right'>".number_format($TotalPesoHum,0,',','.')."</td>\n";
		//CALCULO TOTAL
		$Consulta = "select ano, mes, cod_producto, cod_subproducto, rut_proveedor, nomprv_a as nom_proveedor,sum(peso_humedo) as peso_humedo, sum(peso_seco) as peso_seco ";
		for ($i=1;$i<=60;$i++)
		{
			$Consulta.= " , round(sum(peso_seco * round(c_".str_pad($i,2,'0',STR_PAD_LEFT).",3)) / sum(peso_seco),3) as c_".str_pad($i,2,'0',STR_PAD_LEFT)." ";
		}
		$Consulta.= " from age_web.historico t1 inner join rec_web.proved t2 on t1.rut_proveedor=t2.rutprv_a ";
		$Consulta.= " where ano='".$CmbAno."' and mes='".$CmbMes."' ";
		$Consulta.= " and cod_producto='1' and cod_subproducto='".$CmbSubProductoAux."'";
		if ($CmbProveedorAux!="S")
			$Consulta.= " and rut_proveedor='".$CmbProveedorAux."'";
		$Consulta.= " group by ano, mes, rut_proveedor ";
		$Consulta.= " order by rut_proveedor, ano, lpad(mes,2,'0') ";		
		$Resp = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Resp))
		{			
			for ($i=1; $i<=60; $i++)
			{
				$CodLey=str_pad($i,2,'0',STR_PAD_LEFT);			
				$ArrLeyes[$CodLey]["valor"] = $Fila["c_".str_pad($i,2,'0',STR_PAD_LEFT).""];
			}		
			reset($ArrLeyes);
			while (list($k,$v)=each($ArrLeyes))	
			{
				if ($v["usada"]=="S")
				{
					$Color="";
					AsignaColor("PROM", $v["cod_leyes"], $v["valor"], $ArrLimites, &$Color, $BajoMin, $SobreMax);
					echo "<td align='right' bgcolor='".$Color."'>".number_format($v["valor"],$v["decimales"],",",".")."</td>\n";					
				}
			}
		}
		echo "</tr>\n";
		echo "</table>\n";
		
function AsignaColor($Tipo, $CodLey, $Valor, $Limites, $BgColor, $BajoMin, $SobreMax)
{
	if ($Limites[$CodLey]["usada"]=="S")
	{
		switch ($Tipo)
		{
			case "": //LAS DEL MES				
				if ($Valor<$Limites[$CodLey]["min"])
				{
					$BgColor=$BajoMin;
				}				
				else
				{
					if ($Valor>$Limites[$CodLey]["max"] && $Limites[$CodLey]["max"]!=0)
					{
						$BgColor=$SobreMax;
					}
				}				
				break;
			case "PROM": //EL PROMEDIO DEL MES
				if ($Limites[$CodLey]["med"]!=0)
				{
					if ($Valor<$Limites[$CodLey]["med"])
					{
						$BgColor=$BajoMin;
					}				
					else
					{
						if ($Valor>$Limites[$CodLey]["med"])
						{
							$BgColor=$SobreMax;
						}
					}	
				}
				break;
		}	
	}//FIN USADA
}
?>
              
             
<br>
</form>
</body>
</html>
