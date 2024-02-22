<?php
	include("../principal/conectar_principal.php");
	set_time_limit(2000);
	include("sec_anexo_sec_funciones.php");
	//Nodo=77&Ano=2020&Mes=3
	if(isset($_REQUEST["Nodo"])){
		$Nodo = $_REQUEST["Nodo"];
	}else{
		$Nodo = "";
	}
	if(isset($_REQUEST["Ano"])){
		$Ano = $_REQUEST["Ano"];
	}else{
		$Ano = "";
	}
	if(isset($_REQUEST["Mes"])){
		$Mes = $_REQUEST["Mes"];
	}else{
		$Mes = "";
	}

	$Consulta = "SELECT * from proyecto_modernizacion.nodos where cod_nodo = '".$Nodo."'";
	$Resp2 = mysqli_query($link, $Consulta);
	$Descripcion = "&nbsp;";
	if ($Fila2 = mysqli_fetch_array($Resp2))
	{
		$Descripcion = $Fila2["descripcion"];
	}	
?>
<html>
<head>
<title>Sistema Estadistico de Catodos</title>
<link href="../Principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body background="../Principal/imagenes/fondo3.gif">
<strong>DETALLE DEL NODO: <?php echo $Nodo." - ".$Descripcion ?></strong><br>
<br>
<br>
<table width="500" border="1" align="center" cellpadding="2" cellspacing="0">
<tr align="center" class="ColorTabla01">
    <td colspan="9">DETALLE EXISTENCIA FINAL</td>
  </tr>
<tr align="center" class="ColorTabla01">
  <td width="50" height="19">Cod.Lote</td> 
      <td width="61">Num.Lote</td>
      <td width="99">Peso</td>
      <td colspan="3" align="center">Leyes</td>
      <td colspan="3" align="center">Fino</td>
    </tr>
    <tr class="ColorTabla01">
      <td>&nbsp;</td> 
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td width="51" align="center">Cu</td>
      <td width="47" align="center">Ag</td>
      <td width="37" align="center">Au</td>
      <td width="32" align="center">Cu</td>
      <td width="30" align="center">Ag</td>
      <td width="37" align="center">Au</td>
    </tr>
<?php
	$MesCons = $Mes;
	$AnoCons = $Ano;
	$Unidades = array(2=>100,4=>1000,5=>1000);
	$Crear = "CREATE TEMPORARY TABLE sec_web.tmp_existencias (";
	$Crear.= " `id` char(2) NOT NULL default '',";
	$Crear.= " `cod_bulto` char(2) NOT NULL default '',";
	$Crear.= " `num_bulto` int(11) NOT NULL default '0',";
	$Crear.= " `ano_creacion` int(4) NOT NULL default '0',";
	$Crear.= " `peso` double(17,0) default NULL,";
	$Crear.= " `cod_producto` varchar(10) NOT NULL,";
	$Crear.= " `cod_subproducto` varchar(10) NOT NULL,";
	$Crear.= " PRIMARY KEY  (`id`,`cod_bulto`,`num_bulto`,`ano_creacion`),";
	$Crear.= " UNIQUE KEY `Ind01` (`id`,`cod_bulto`,`num_bulto`,`ano_creacion`),";
	$Crear.= " KEY `Ind02` (`cod_bulto`,`num_bulto`),";
	$Crear.= " KEY `Ind03` (`cod_bulto`,`ano_creacion`),";
	$Crear.= " KEY `Ind04` (`cod_producto`,`cod_subproducto`)";
	$Crear.= " )";
	mysqli_query($link, $Crear);

	$Consulta = "SELECT distinct t3.descripcion, t2.cod_producto, t2.cod_subproducto ";
	$Consulta.= " from sec_web.relacion_flujo t2 ";
	$Consulta.= " inner join proyecto_modernizacion.subproducto t3 ";
	$Consulta.= " on t2.cod_producto = t3.cod_producto and t2.cod_subproducto = t3.cod_subproducto";
	$Consulta.= " where t2.flujo = '".$Nodo."' and t2.tipo_mov='4' ";
	//echo $Consulta."<br>";
	$RespAux = mysqli_query($link, $Consulta);
	$PesoTotal=0;
	while ($FilaAux = mysqli_fetch_array($RespAux))
	{				
		$Producto = $FilaAux["cod_producto"];
		$SubProducto = $FilaAux["cod_subproducto"];
		//echo $Producto."-".$SubProducto."<br>";
		$DiaFin = "31";
		$MesFin = str_pad($MesCons,2, "0", STR_PAD_LEFT);
		$AnoFin = $AnoCons;
		$DiaIni = "01";
		$MesIni = $MesFin;
		$AnoIni = $AnoFin;		
		$FechaOri = $AnoIni."-".str_pad($MesIni,2, "0", STR_PAD_LEFT)."-".str_pad($DiaIni,2, "0", STR_PAD_LEFT);
		$FechaAux = $AnoIni."-".str_pad($MesIni,2, "0", STR_PAD_LEFT)."-".str_pad($DiaIni,2, "0", STR_PAD_LEFT);	
		$FechaTermino = $AnoFin."-".str_pad($MesFin,2, "0", STR_PAD_LEFT)."-".str_pad($DiaFin,2, "0", STR_PAD_LEFT);
		$FechaAux = date("Y-m-d", mktime(0,0,0,substr($FechaAux,5,2) + 1,01,substr($FechaAux,0,4)));
		$FechaInicio = $FechaAux;
		$FechaTermino = date("Y-m-d", mktime(0,0,0,substr($FechaAux,5,2) + 1,01,substr($FechaAux,0,4)));
		$FechaTermino = date("Y-m-d", mktime(0,0,0,substr($FechaTermino,5,2),intval(substr($FechaTermino,8,2)) - 1,substr($FechaTermino,0,4)));	 
		$ArrTotal = array();
		$Consulta = "SELECT * from proyecto_modernizacion.sub_clase ";
		$Consulta.= " where cod_clase = '3004' and cod_subclase = '".intval(substr($FechaOri,5,2))."'"	;
		$Respuesta = mysqli_query($link, $Consulta);
		//echo $Consulta;
		if ($Fila = mysqli_fetch_array($Respuesta))
		{
			$MesConsulta = $Fila["nombre_subclase"];
		}
		
		if ($MesConsulta == "A" || $MesConsulta=="M")
			$ano_7 =$AnoFin + 1;
		$MesAct=intval(substr($FechaOri,5,2));
		if($MesAct==12)
			$MesSig=1;
		else
			$MesSig=$MesAct+1;	
		$Consulta = "SELECT * from proyecto_modernizacion.sub_clase ";
		$Consulta.= " where cod_clase = '3004' and cod_subclase = '".$MesSig."'"	;
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Respuesta))
		{
			$MesSig = $Fila["nombre_subclase"];
		}
			
		$Color = "";$TotalPeso = 0;	
		$Consulta= " SELECT t2.cod_bulto, t2.num_bulto, year(t2.fecha_creacion_lote) as ano_creacion, sum(t1.peso_paquetes) as peso ";
		$Consulta.= " ,t1.cod_producto, t1.cod_subproducto,t2.fecha_creacion_lote  ";
		$Consulta.= " from sec_web.paquete_catodo t1 inner join sec_web.lote_catodo t2 ";	
		$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete ";
		$Consulta.= " and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete ";
		$Consulta.= " where ";
		switch($Producto)
		{
			case "64":
				if ($Producto == 64 && ($SubProducto == 5 || $SubProducto == 1))
					$Consulta.= " t1.cod_producto = '64' and (t1.cod_subproducto = '1' || t1.cod_subproducto = '5')";
				else
					$Consulta.= " t1.cod_producto = '".$Producto."' and t1.cod_subproducto = '".$SubProducto."'  ";		
			break;
			case "48":
				$Consulta.= " t1.cod_producto = '48'";
			break;
			default:
				$Consulta.= " t1.cod_producto = '".$Producto."' and t1.cod_subproducto = '".$SubProducto."'  ";				
		}
		//if ($Producto == 64 && ($SubProducto == 5 || $SubProducto == 1))
		//	$Consulta.= " t1.cod_producto = '64' and (t1.cod_subproducto = '1' || t1.cod_subproducto = '5')";
		//else
		//	$Consulta.= " t1.cod_producto = '".$Producto."' and t1.cod_subproducto = '".$SubProducto."'  ";
		$Consulta.= " and year(t1.fecha_creacion_paquete) <= '".$AnoFin."' and ";
		$Consulta.= "(";
		$Consulta.= "(t1.cod_estado = 'a' and t1.fecha_embarque = '0000-00-00' and t1.cod_paquete <>'".$MesSig."') or ";
		$Consulta.= "(t1.cod_estado = 'a'  and year(t1.fecha_creacion_paquete) < '".$AnoFin."' and t1.cod_paquete ='".$MesSig."') or ";
		$Consulta.= "(t1.cod_estado = 'c' and t1.fecha_embarque >= '".$FechaAux."' and t1.cod_paquete <>'".$MesSig."')";
		$Consulta.= ")";
		$Consulta.= " group by t2.cod_bulto, t2.num_bulto ";
		$Consulta.= " order by ano_creacion, t2.cod_bulto, t2.num_bulto";
		$Respuesta = mysqli_query($link, $Consulta);
		//echo $Consulta."<br>";
		while ($Fila = mysqli_fetch_array($Respuesta))
		{
			if($Fila["cod_bulto"]>$MesConsulta&&$Fila["fecha_creacion_lote"]>=$FechaAux)
				$Nada='';
				//echo $MesConsulta." ".$Fila["cod_bulto"]." ".$Fila["num_bulto"]." ".$Fila["ano_creacion"]."<br><br>";
			else
			{
				$Insertar = "insert into sec_web.tmp_existencias  (id, cod_bulto, num_bulto, ano_creacion, peso, cod_producto, cod_subproducto) ";
				$Insertar.= "values('1','".$Fila["cod_bulto"]."','".$Fila["num_bulto"]."','".$Fila["ano_creacion"]."','".$Fila["peso"]."','".$Fila["cod_producto"]."','".$Fila["cod_subproducto"]."')";
				mysqli_query($link, $Insertar);
			}
		}
		//CONSULTA LO QUE SE TRASPASO
		$FechaIniAux = date("Y-m-d", mktime(0,0,0,substr($FechaInicio,5,2)-1,1,substr($FechaInicio,0,4)));
		$FechaFinAux = substr($FechaIniAux,0,4)."-".substr($FechaIniAux,5,2)."-31";
		$Consulta = "SELECT sum(t1.peso_paquetes) as peso,t3.cod_bulto,t3.num_bulto,";
		$Consulta.= " year(t3.fecha_creacion_lote) as ano_creacion, t5.hornada, t4.fecha_traspaso, t5.fecha_movimiento,t1.cod_subproducto, t1.cod_subproducto ";
		$Consulta.= " from sec_web.paquete_catodo t1 ";
		$Consulta.= " inner join sec_web.lote_catodo t3 on t1.cod_paquete = t3.cod_paquete";
		$Consulta.= " and t1.num_paquete = t3.num_paquete and t1.fecha_creacion_paquete = t3.fecha_creacion_paquete";
		$Consulta.= " INNER join sec_web.traspaso t4 on t3.cod_bulto = t4.cod_bulto AND t3.num_bulto = t4.num_bulto and t3.fecha_creacion_lote=t4.fecha_creacion_lote";
		$Consulta.= " left join sea_web.movimientos t5 on t5.tipo_movimiento = 4 and t5.hornada = t4.hornada";
		$Consulta.= " left join sea_web.stock_piso_raf t6 on t5.hornada = t6.hornada";
		$Consulta.= " where t4.fecha_traspaso between '".$FechaIniAux."' and CURDATE() ";
		if ($Producto == 64 && ($SubProducto == 5 || $SubProducto == 1))
		{
			$Consulta.= " and t1.cod_producto = '64' and (t1.cod_subproducto = '1' || t1.cod_subproducto = '5') ";
		}
		else
		{
			$Consulta.= " and t1.cod_producto = '".$Producto."' and t1.cod_subproducto = '".$SubProducto."' ";
		}
		$Consulta.= " and (year(t1.fecha_creacion_paquete) = ".$AnoFin."  ";
		if (strtoupper($MesConsulta)=="A")
			$Consulta.= " and t1.cod_paquete <= 'M' ";
		else
			$Consulta.= " and t1.cod_paquete < '".$MesConsulta."' ";
		$Consulta.= " or year(t1.fecha_creacion_paquete) < ".$AnoFin.")  ";
		$Consulta.= " group by t3.cod_bulto,t3.num_bulto";
		//echo "traspaso".$Consulta."</br>";;
		$Respuesta = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Respuesta))
		{
			if ($Fila["fecha_traspaso"]>$FechaFinAux)
			{
				$Insertar = "insert into sec_web.tmp_existencias  (id, cod_bulto, num_bulto, ano_creacion, peso, cod_producto, cod_subproducto) ";
				$Insertar.= "values('1','".$Fila["cod_bulto"]."','".$Fila["num_bulto"]."','".$Fila["ano_creacion"]."','".$Fila["peso"]."','".$Fila["cod_producto"]."','".$Fila["cod_subproducto"]."')";
				mysqli_query($link, $Insertar);
			}
		}
		//FIN TRASPASO		
		
	}	
	$AcumFinoCu = 0;$AcumFinoAg = 0;$AcumFinoAu = 0;
	if ($Nodo != 77)
	{
		//CONSULTA TABLA CREADA CON LEYES
		$Consulta = "SELECT  cod_bulto, num_bulto, ano_creacion, peso, cod_producto, cod_subproducto ";
		$Consulta.= " from sec_web.tmp_existencias  ";
		//$Consulta.= " WHERE cod_bulto='M' and num_bulto='4185'";
		$Consulta.= " order by ano_creacion,cod_bulto, num_bulto";//group by cod_bulto order by cod_bulto, num_bulto";
		$Respuesta = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Respuesta))
		{
			$Producto=$Fila["cod_producto"];
			$SubProducto=$Fila["cod_subproducto"];
			$Peso = $Fila["peso"];
			$Fino_Cu = 0;$Fino_Ag = 0;$Fino_Au = 0;														
			//LEYES
			$Ano = $Fila["ano_creacion"];
			$Consulta = "SELECT * from proyecto_modernizacion.sub_clase ";
			$Consulta.= " where cod_clase=3004 and nombre_subclase = '".$Fila["cod_bulto"]."'";
			$RespAux2 = mysqli_query($link, $Consulta);
			if ($FilaAux2 = mysqli_fetch_array($RespAux2))
			{
				$Mes = $FilaAux2["cod_subclase"];
			}		
			if (intval($Ano)==intval($AnoCons) && intval($Mes)==intval($MesCons))
			{
				$Consulta = "SELECT t2.flujo from proyecto_modernizacion.flujos t1 ";
				$Consulta.= " inner join sec_web.relacion_flujo t2 ";
				$Consulta.= " on t1.cod_flujo = t2.flujo ";
				$Consulta.= " where t1.nodo='".$Nodo."' ";
				$Consulta.= " and t2.tipo_mov = 1 ";
				$Consulta.= " and t1.esflujo <> 'N' ";
				$RespAux2 = mysqli_query($link, $Consulta);
				$Flujo = "";
				if ($FilaAux2 = mysqli_fetch_array($RespAux2))
				{
					$Flujo = $FilaAux2["flujo"];
				}
				//CONSULTO LEYES DEL MES PEDIDO
				$Consulta = "SELECT * from sec_web.flujos_mes ";
				$Consulta.= " where ano = '".$AnoCons."'";
				$Consulta.= " and mes = '".$MesCons."'";
				$Consulta.= " and flujo = '".$Flujo."'";
				$RespAux2 = mysqli_query($link, $Consulta);
				//echo $Consulta."<br>";
				$Encontro = false;
				while ($FilaAux2 = mysqli_fetch_array($RespAux2))
				{
					$Encontro=true;
					if ($FilaAux2["fino_cu"]>0 && $FilaAux2["peso"]>0)
						$Fino_Cu = ($FilaAux2["fino_cu"] / $FilaAux2["peso"])*100;
					else
						$Fino_Cu = 0;
					if ($FilaAux2["fino_ag"]>0 && $FilaAux2["peso"]>0)
						$Fino_Ag = ($FilaAux2["fino_ag"] / $FilaAux2["peso"])*1000;
					else
						$Fino_Ag = 0;
					if ($FilaAux2["fino_au"]>0 && $FilaAux2["peso"]>0)
						$Fino_Au = ($FilaAux2["fino_au"] / $FilaAux2["peso"])*1000;
					else
						$Fino_Au = 0;
					//echo $Fino_Ag."<br>"; 	
				}			
			}
			else
			{
				$Consulta = "SELECT * from sec_web.relacion_flujo ";
				$Consulta.= " where cod_producto='".$Producto."'";
				$Consulta.= " and cod_subproducto='".$SubProducto."' ";
				$Consulta.= " and tipo_mov='1' ";
				$RespAux2 = mysqli_query($link, $Consulta);
				while ($FilaAux2 = mysqli_fetch_array($RespAux2))
				{					
					$FlujoProd = $FilaAux2["flujo"];
				}
				//echo $Consulta."<br>";
				$Consulta = "SELECT * from sec_web.flujos_mes ";
				$Consulta.= " where ano = '".$Ano."'";
				$Consulta.= " and mes = '".$Mes."'";
				$Consulta.= " and flujo = '".$FlujoProd."'";
				//echo $Consulta;
				$RespAux2 = mysqli_query($link, $Consulta);
				$Encontro=false;
				while ($FilaAux2 = mysqli_fetch_array($RespAux2))
				{
					$Encontro=true;
					if ($FilaAux2["fino_cu"]>0 && $FilaAux2["peso"]>0)
						$Fino_Cu = ($FilaAux2["fino_cu"] / $FilaAux2["peso"])*100;
					else
						$Fino_Cu = 0;
					if ($FilaAux2["fino_ag"]>0 && $FilaAux2["peso"]>0)
						$Fino_Ag = ($FilaAux2["fino_ag"] / $FilaAux2["peso"])*1000;
					else
						$Fino_Ag = 0;
					if ($FilaAux2["fino_au"]>0 && $FilaAux2["peso"]>0)
						$Fino_Au = ($FilaAux2["fino_au"] / $FilaAux2["peso"])*1000;
					else
						$Fino_Au = 0;
				}
			}
			if (!$Encontro)
			{
				$Consulta = "SELECT * from sec_web.relacion_flujo ";
				$Consulta.= " where cod_producto='".$Producto."'";
				$Consulta.= " and cod_subproducto='".$SubProducto."' ";
				$Consulta.= " and tipo_mov='1' ";
				$RespAux2 = mysqli_query($link, $Consulta);
				while ($FilaAux2 = mysqli_fetch_array($RespAux2))
				{					
					$FlujoProd = $FilaAux2["flujo"];
				}
				$FechaAux = date("Y-m-d", mktime(0,0,0,$MesCons-1,1,$AnoCons));
				$AnoAnt = substr($FechaAux,0,4);
				$MesAnt = intval(substr($FechaAux,5,3));
				$Consulta = "SELECT * from sec_web.flujos_mes ";
				$Consulta.= " where ano = '".$AnoAnt."'";
				$Consulta.= " and mes = '".$MesAnt."'";
				$Consulta.= " and flujo = '".$FlujoProd."'";
				$RespAux2 = mysqli_query($link, $Consulta);
				$Encontro = false;
				while ($FilaAux2 = mysqli_fetch_array($RespAux2))
				{
					$Encontro = true;
					if ($FilaAux2["fino_cu"]>0 && $FilaAux2["peso"]>0)
						$Fino_Cu = ($FilaAux2["fino_cu"] / $FilaAux2["peso"])*100;
					else
						$Fino_Cu = 0;
					if ($FilaAux2["fino_ag"]>0 && $FilaAux2["peso"]>0)
						$Fino_Ag = ($FilaAux2["fino_ag"] / $FilaAux2["peso"])*1000;
					else
						$Fino_Ag = 0;
					if ($FilaAux2["fino_au"]>0 && $FilaAux2["peso"]>0)
						$Fino_Au = ($FilaAux2["fino_au"] / $FilaAux2["peso"])*1000;
					else
						$Fino_Au = 0;
				}
				//echo $Fino_Ag."<br>";
			}
			
			//FINOS			
			if ($Fino_Cu > 0 && $Peso > 0)				
				$AcumFinoCu = $AcumFinoCu + (($Fino_Cu*$Peso)/100);					
			if ($Fino_Ag > 0 && $Peso > 0)									
				$AcumFinoAg = $AcumFinoAg + (($Fino_Ag*$Peso)/1000);				
			if ($Fino_Au > 0 && $Peso > 0)									
				$AcumFinoAu = $AcumFinoAu + (($Fino_Au*$Peso)/1000);				
			$PesoTotal = $PesoTotal + $Fila["peso"];			
			echo "<tr> \n";
			echo "<td align='center'>".$Fila["cod_bulto"]."</td>\n";
			echo "<td align='center'>".$Fila["num_bulto"]."</td>\n";
			echo "<td align='right'>".number_format($Peso,0,",",".")."</td>\n";  
			echo "<td align='right'>".number_format($Fino_Cu,3,",",".")."</td>\n";
			echo "<td align='right'>".number_format($Fino_Ag,2,",",".")."</td>\n";
			echo "<td align='right'>".number_format($Fino_Au,2,",",".")."</td>\n"; 
			echo "<td align='right'>";
			if ($Fino_Cu>0 && $Peso>0)
				echo number_format(($Fino_Cu*$Peso)/100,0,",",".");
			else
				echo "0";
			echo "</td>\n";
			echo "<td align='right'>";
			if ($Fino_Ag>0 && $Peso>0)
				echo number_format(($Fino_Ag*$Peso)/1000,0,",",".");
			else
				echo "0";
			echo "</td>\n";
			echo "<td align='right'>";
			if ($Fino_Au>0 && $Peso>0)
				echo number_format(($Fino_Au*$Peso)/1000,0,",",".");
			else
				echo "0";
			echo "</td>\n";			
			echo "</tr>\n";	
		}		
	}//FIN			
	echo "<tr class='ColorTabla02'> \n";
	echo "<td align='center' colspan='2'>TOTAL</td>\n";
	echo "<td align='right'>".number_format($PesoTotal,0,",",".")."</td>\n";   
	echo "<td align='right'>";
	if ($AcumFinoCu>0 && $PesoTotal>0)
	echo number_format(($AcumFinoCu/$PesoTotal)*100,2,",",".");
	else
	 echo "0";
	echo "</td>\n";
	echo "<td align='right'>";
	if ($AcumFinoCu>0 && $PesoTotal>0)
	echo number_format(($AcumFinoAg/$PesoTotal)*1000,2,",",".");
	else
	echo "0";
	echo "</td>\n";
	echo "<td align='right'>";
	if ($AcumFinoCu>0 && $PesoTotal>0)
	echo number_format(($AcumFinoAu/$PesoTotal)*1000,2,",",".");
	else
	echo "0";
	echo "</td>\n";
	echo "<td align='right'>".number_format($AcumFinoCu,0,",",".")."</td>\n";
	echo "<td align='right'>".number_format($AcumFinoAg,0,",",".")."</td>\n";
	echo "<td align='right'>".number_format($AcumFinoAu,0,",",".")."</td>\n";
	echo "</tr>\n";	
	$Eliminar = "drop table sec_web.tmp_existencias";
	mysqli_query($link, $Eliminar);
?>
  </table>
</body>
</html>
