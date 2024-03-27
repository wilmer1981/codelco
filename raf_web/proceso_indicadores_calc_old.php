<?
	include("../principal/conectar_principal.php");
	set_time_limit(450);
    mysql_select_db("raf_web",$link);


	$FechaHoraActual=date('Y-m-d G:i:s');
	if(!isset($TxtFechaIni))
	{
		$FechaIni=date('Y-m-d');
		$FechaFinReproceso=date("Y-m-d", mktime(1,0,0,substr($FechaIni,5,2),substr($FechaIni,8,2)-2,substr($FechaIni,0,4)));
		//FECHA INI DIA ANTERIOR A EJECUCION DEL PROCESO EN FORMA AUTOMATICA
		$FechaIni=date("Y-m-d", mktime(1,0,0,substr($FechaIni,5,2),substr($FechaIni,8,2)-1,substr($FechaIni,0,4)))." ".date('G:i:s');
		$FechaIniReporte=date("Y-m-d", mktime(1,0,0,substr($FechaIni,5,2),substr($FechaIni,8,2),substr($FechaIni,0,4)));
	}
	else
	{
		$FechaFinReproceso=date("Y-m-d", mktime(1,0,0,substr($TxtFechaIni,5,2),substr($TxtFechaIni,8,2)-1,substr($TxtFechaIni,0,4)));
		//FECHA INI EJECUCION DEL PROCESO DESDE LA INTERFAZ WEB
		$FechaIniReporte=$TxtFechaIni;
		$FechaIni=$TxtFechaIni." ".date('G:i:s');
	}
	//printf("Fecha fuera del ciclo: %s\n", $FechaIni."<br>");

	$FechaHoraIni = date("Y-m-d", mktime(1,0,0,substr($FechaIni,5,2),substr($FechaIni,8,2),substr($FechaIni,0,4)))." 08:00:00";
	$FechaHoraFin = date("Y-m-d", mktime(1,0,0,substr($FechaIni,5,2),substr($FechaIni,8,2)+1,substr($FechaIni,0,4)))." 07:59:59";
		
	$Eliminar="delete from raf_web.ti_indicadores where Fecha_reporte = '".$FechaIniReporte." 08:00:00'";
	mysql_query($Eliminar);
	//echo $Eliminar."<br>";

	$Obs='';
	//PROCESO Nº 1  Concentrado procesado seco(sistema ram)
	$Valor=proceso_cp_seco($FechaHoraIni,$FechaHoraFin,"PS");
	proceso_insertar_data(1,$FechaIniReporte,$FechaHoraActual,$Valor,"Concentrado procesado seco (Kgs.)");
	//------------------------------------------------------
	//PROCESO Nº 3  Cobre nuevo moldeado (blíster) - Moldeo horno basculante
	$Valor=proceso_prod_anodos($FechaHoraIni,$FechaHoraFin,'4');
	proceso_insertar_data(3,$FechaIniReporte,$FechaHoraActual,$Valor,"Cobre nuevo moldeado (blister) - Moldeo horno basculante (Kgs.)");
	//------------------------------------------------------
	//PROCESO Nº 4  Produccion Anodos totales..( Cobre moldeado)
	$Valor1=proceso_prod_anodos($FechaHoraIni,$FechaHoraFin,'1');
	$Valor2=proceso_prod_anodos($FechaHoraIni,$FechaHoraFin,'2');
	//$Valor3=proceso_prod_anodos($FechaHoraIni,$FechaHoraFin,'4');
	$Valor=$Valor1+$Valor2;
	proceso_insertar_data(4,$FechaIniReporte,$FechaHoraActual,$Valor,"Produccion Anodos totales (Cobre moldeado) (Kgs.)");
	//------------------------------------------------------	
	//PROCESO Nº 5 Catodos produccion
	$Valor=proceso_cat_prod($FechaHoraIni,$FechaHoraFin);
	proceso_insertar_data(5,$FechaIniReporte,$FechaHoraActual,$Valor,"Catodos produccion diaria (Ton.)");
	//------------------------------------------------------
	//PROCESO Nº 6 Catodos comerciales producidos acumulado
	$Valor=proceso_cat_prod_acum($FechaHoraIni,$FechaHoraFin);
	proceso_insertar_data(6,$FechaIniReporte,$FechaHoraActual,$Valor,"Catodos comercial produccion acumulada (Ton.)");
	//------------------------------------------------------
	//PROCESO Nº 8 Calidad cátodos grado A
	$Valor=proceso_calidad_cat_A($FechaHoraIni,$FechaHoraFin);
	proceso_insertar_data(8,$FechaIniReporte,$FechaHoraActual,$Valor,"Calidad catodos grado A (%)");
	//------------------------------------------------------
	//PROCESO Nº 9  Concentrado procesado fino-cu(sistema ram)
	$Valor=proceso_cp_seco($FechaHoraIni,$FechaHoraFin,"PF");
	proceso_insertar_data(9,$FechaIniReporte,$FechaHoraActual,$Valor,"Concentrado procesado fino-cu (Kgs.)");
	//------------------------------------------------------
	//PROCESO Nº 10  traspaso de Restos de anodos
	$Valor=proceso_traspaso_restos($FechaHoraIni,$FechaHoraFin);
	proceso_insertar_data(10,$FechaIniReporte,$FechaHoraActual,$Valor,"traspaso de Restos de anodos (Kgs.)");
	//------------------------------------------------------
	//PROCESO Nº 11 Catodos produccion Comercial diaria
	$Valor=proceso_cat_prod_comercial($FechaHoraIni,$FechaHoraFin);
	proceso_insertar_data(11,$FechaIniReporte,$FechaHoraActual,$Valor,"Catodos produccion comercial diaria (Kgs.)");
	//------------------------------------------------------
	//PROCESO Nº 12 Catodos produccion Comercial acumulado
	$Valor=proceso_cat_prod_comercial_acum($FechaHoraIni,$FechaHoraFin);
	proceso_insertar_data(12,$FechaIniReporte,$FechaHoraActual,$Valor,"Catodos produccion comercial diaria Acum. (Kgs.)");

	//REPROCESO PARA LOS DIAS DEFINIDOS EN LA CLASE DEL SISTEMA RAF
	//recupero de las clases sistema RAF dias de reproceso
	$consulta = "select IFNULL(valor1,0) as dias from proyecto_modernizacion.clase where cod_clase=12007";
	$Resp=mysql_query($consulta);
	//echo $consulta."<br>";
	if($Fila = mysql_fetch_array($Resp))
	{
		$DiasRepro=$Fila["dias"];	
	}
	//$DiasRepro=0;
	if($DiasRepro>0)
	{
		//echo "Dias Reproceso:".$DiasRepro."<br>";
		$DiasRepro=$DiasRepro-1;
		$consulta = "select DATE_SUB('".$FechaFinReproceso."',INTERVAL ".$DiasRepro." DAY) as fecha_ini";
		$Resp=mysql_query($consulta);
		//echo $consulta."<br>";
		if($Fila = mysql_fetch_array($Resp))
		{
			$fechaInicio=$Fila["fecha_ini"];
		}
		# Fecha como segundos

		$tiempoInicio = strtotime($fechaInicio);
		$tiempoFin = strtotime($FechaFinReproceso);
		# 24 horas * 60 minutos por hora * 60 segundos por minuto
		$dia = 86400;
		while($tiempoInicio <= $tiempoFin){
			# Podemos recuperar la fecha actual y formatearla
			$FechaIni = date("Y-m-d", $tiempoInicio);
			$FechaIniReporte=$FechaIni;
			//printf("Fecha dentro del ciclo: %s\n", $FechaIni."<br>");

			$FechaHoraIni = date("Y-m-d", mktime(1,0,0,substr($FechaIni,5,2),substr($FechaIni,8,2),substr($FechaIni,0,4)))." 08:00:00";
			$FechaHoraFin = date("Y-m-d", mktime(1,0,0,substr($FechaIni,5,2),substr($FechaIni,8,2)+1,substr($FechaIni,0,4)))." 07:59:59";
				
			$Eliminar="delete from raf_web.ti_indicadores where Fecha_reporte = '".$FechaIniReporte." 08:00:00'";
			mysql_query($Eliminar);
			//echo $Eliminar."<br>";
		
			$Obs='';
			//PROCESO Nº 1  Concentrado procesado seco(sistema ram)
			$Valor=proceso_cp_seco($FechaHoraIni,$FechaHoraFin,"PS");
			proceso_insertar_data(1,$FechaIniReporte,$FechaHoraActual,$Valor,"Concentrado procesado seco (Kgs.)");
			//------------------------------------------------------
			//PROCESO Nº 3  Cobre nuevo moldeado (blíster) - Moldeo horno basculante
			$Valor=proceso_prod_anodos($FechaHoraIni,$FechaHoraFin,'4');
			proceso_insertar_data(3,$FechaIniReporte,$FechaHoraActual,$Valor,"Cobre nuevo moldeado (blister) - Moldeo horno basculante (Kgs.)");
			//------------------------------------------------------
			//PROCESO Nº 4  Produccion Anodos totales..( Cobre moldeado)
			$Valor1=proceso_prod_anodos($FechaHoraIni,$FechaHoraFin,'1');
			$Valor2=proceso_prod_anodos($FechaHoraIni,$FechaHoraFin,'2');
			//$Valor3=proceso_prod_anodos($FechaHoraIni,$FechaHoraFin,'4');
			$Valor=$Valor1+$Valor2;
			proceso_insertar_data(4,$FechaIniReporte,$FechaHoraActual,$Valor,"Produccion Anodos totales (Cobre moldeado) (Kgs.)");
			//------------------------------------------------------	
			//PROCESO Nº 5 Catodos produccion
			$Valor=proceso_cat_prod($FechaHoraIni,$FechaHoraFin);
			proceso_insertar_data(5,$FechaIniReporte,$FechaHoraActual,$Valor,"Catodos produccion diaria (Ton.)");
			//------------------------------------------------------
			//PROCESO Nº 6 Catodos comerciales producidos acumulado
			$Valor=proceso_cat_prod_acum($FechaHoraIni,$FechaHoraFin);
			proceso_insertar_data(6,$FechaIniReporte,$FechaHoraActual,$Valor,"Catodos comercial produccion acumulada (Ton.)");
			//------------------------------------------------------
			//PROCESO Nº 8 Calidad cátodos grado A
			$Valor=proceso_calidad_cat_A($FechaHoraIni,$FechaHoraFin);
			proceso_insertar_data(8,$FechaIniReporte,$FechaHoraActual,$Valor,"Calidad catodos grado A (%)");
			//------------------------------------------------------
			//PROCESO Nº 9  Concentrado procesado fino-cu(sistema ram)
			$Valor=proceso_cp_seco($FechaHoraIni,$FechaHoraFin,"PF");
			proceso_insertar_data(9,$FechaIniReporte,$FechaHoraActual,$Valor,"Concentrado procesado fino-cu (Kgs.)");
			//PROCESO Nº 10  traspaso de Restos de anodos
			$Valor=proceso_traspaso_restos($FechaHoraIni,$FechaHoraFin);
			proceso_insertar_data(10,$FechaIniReporte,$FechaHoraActual,$Valor,"traspaso de Restos de anodos (Kgs.)");
			//PROCESO Nº 11 Catodos produccion Comercial diaria
			$Valor=proceso_cat_prod_comercial($FechaHoraIni,$FechaHoraFin);
			proceso_insertar_data(11,$FechaIniReporte,$FechaHoraActual,$Valor,"Catodos produccion comercial diaria (Kgs.)");
			//PROCESO Nº 12 Catodos produccion Comercial acumulado
			$Valor=proceso_cat_prod_comercial_acum($FechaHoraIni,$FechaHoraFin);
			proceso_insertar_data(12,$FechaIniReporte,$FechaHoraActual,$Valor,"Catodos produccion comercial diaria Acum. (Kgs.)");

			# Sumar el incremento para que en algún momento termine el ciclo
			$tiempoInicio += $dia;
		}
	}
	//FUNCIONES ------
	function proceso_insertar_data ($CodProc,$FechaIniReporte,$FechaHoraActual,$Valor,$Obs)
	{
		$Insertar="insert into raf_web.ti_indicadores (cod_proceso,fecha_reporte,fecha_hora,valor,observacion) values ($CodProc,'".$FechaIniReporte." 08:00:00','".$FechaHoraActual."',$Valor,'".$Obs."')";
		mysql_query($Insertar);
		//echo $Insertar."<br>";	
	}
	function proceso_prod_anodos($FechaHoraIni,$FechaHoraFin,$Horno)
	{
		$fecha=substr($FechaHoraIni,0,10);
		$fecha2=substr($FechaHoraFin,0,10);
		/*$fecha_ini=substr($FechaHoraIni,0,10);
		$consulta = "SELECT IFNULL(SUM(t1.unidades),0) AS unid, IFNULL(SUM(peso),0) AS peso";
		$consulta = $consulta." FROM sea_web.movimientos AS t1";
		$consulta = $consulta." WHERE t1.tipo_movimiento = 1 AND t1.cod_producto = 17";
		$consulta = $consulta." AND t1.cod_subproducto in (4,8,11)";
		$consulta = $consulta." AND t1.fecha_movimiento = '".$fecha_ini."'";
		//$consulta = $consulta." and hora between '".$FechaHoraIni."' and '".$FechaHoraFin."' ";
		$consulta = $consulta." and hora between '".$fecha_ini." 00:00:00' and '".$FechaHoraFin."' ";							
		$consulta = $consulta." AND RIGHT(t1.hornada,4) LIKE '".$Horno."%'";*/
		$consulta = "select IFNULL(SUM(peso),0) AS peso FROM sea_web.movimientos WHERE tipo_movimiento = 1 AND fecha_movimiento between '".$fecha."' and ";
		$consulta.=" '".$fecha2."' AND cod_producto = 17 AND cod_subproducto in (4,8,11) and hora between '".$FechaHoraIni."' and '".$FechaHoraFin."' and "; 
		$consulta.=" RIGHT(hornada,4) LIKE '".$Horno."%'";
		//$consulta.=" group by cod_producto ";
		$Resp=mysql_query($consulta);$Valor=0;
		//echo $consulta."<br>";
		if($Fila = mysql_fetch_array($Resp))
		{
			$Valor=$Fila["peso"];	
		}
		return round($Valor,0);

	}
	function proceso_cp_seco($FechaHoraIni,$FechaHoraFin,$ValorRetorno)
	{
		$Valor=0;
		$Consulta = " SELECT Sum(t1.peso_seco) AS peso_seco,Sum(t1.fino_cu) AS fino_cu ";
		$Consulta.= " FROM ram_web.movimiento_proveedor t1 INNER JOIN ram_web.conjunto_ram t2 ON (t1.num_conjunto = t2.num_conjunto)";
		$Consulta.= " AND (t1.cod_conjunto = t2.cod_conjunto) INNER JOIN ram_web.movimiento_conjunto t3 ON (t1.num_conjunto = t3.num_conjunto) ";
		$Consulta.= " AND (t1.conjunto_destino = t3.conjunto_destino) AND (t1.fecha_movimiento = t3.fecha_movimiento)";
		$Consulta.= " AND case when t1.cod_conjunto='03' then (t3.cod_lugar_destino <= 12 OR t3.cod_lugar_destino >= 26) AND (t3.cod_existencia = 6 OR t3.cod_existencia = 15) ";
		$Consulta.= " else (t3.cod_lugar_destino > 12 OR t3.cod_lugar_destino < 26) AND (t3.cod_existencia = 6 OR t3.cod_existencia = 15) end ";					
		$Consulta.= " WHERE t1.cod_conjunto in (01) and t2.estado='a' ";	
		$Consulta.= " and t1.peso_humedo > 0";
		$Consulta.= " and (t1.cod_existencia in(05,12,15,16))";	
		$Consulta.= " and t1.fecha_movimiento BETWEEN '".$FechaHoraIni."' and '".$FechaHoraFin."' and t2.cod_subproducto not in (92)";
		$Consulta.= " GROUP BY t1.cod_conjunto";						
		//$Consulta.= " GROUP BY t2.cod_producto, t2.cod_subproducto,t1.cod_conjunto,t1.num_conjunto";
		$Resp=mysqli_query($link, $Consulta);$Valor=0;
		if($Fila = mysql_fetch_array($Resp))
		{
			if($ValorRetorno=="PS")
				$Valor=$Fila["peso_seco"];
			else
				$Valor=$Fila["fino_cu"];	
		}
		/*echo $Consulta."<br>";
		while($Fila = mysql_fetch_array($Resp))
		{
			$Valor=$Valor+$Fila["peso_seco"];

		}*/
		//$Valor=number_format($Valor,0,",","");
		return round($Valor,0);
	}
	function proceso_cat_prod($FechaHoraIni,$FechaHoraFin)
	{
		$Valor=0;
		$Consulta = "select sum(t1.peso_produccion)as peso ";
		$Consulta.= " from sec_web.produccion_catodo t1 inner join proyecto_modernizacion.subproducto t2  ";
		$Consulta.= " on t1.cod_producto = t2.cod_producto and t1.cod_subproducto = t2.cod_subproducto  ";
		$Consulta.= " where CONCAT(t1.fecha_produccion,' ',hora) BETWEEN '".$FechaHoraIni."' and '".$FechaHoraFin."'";
		$Consulta.= " and (t1.cod_producto in (18) or (t1.cod_producto='48' and t1.cod_subproducto <> '10'))  order by t1.cod_producto";
		//echo "a la fecha".$Consulta;
		$Respuesta = mysqli_query($link, $Consulta);
		while ($Fila = mysql_fetch_array($Respuesta))
		{
			$Valor=$Valor+$Fila["peso"];	
		}
		if($Valor>0)
			$Valor=$Valor/1000;
		return round($Valor,0);
	}
	function proceso_cat_prod_comercial($FechaHoraIni,$FechaHoraFin)
	{
		$Valor=0;
		$Consulta = "select sum(t1.peso_produccion)as peso ";
		$Consulta.= " from sec_web.produccion_catodo t1 inner join proyecto_modernizacion.subproducto t2  ";
		$Consulta.= " on t1.cod_producto = t2.cod_producto and t1.cod_subproducto = t2.cod_subproducto  ";
		$Consulta.= " where CONCAT(t1.fecha_produccion,' ',hora) BETWEEN '".$FechaHoraIni."' and '".$FechaHoraFin."'";
		$Consulta.= " and t1.cod_producto = 18 and t1.cod_subproducto='1'";
		//echo "a la fecha".$Consulta;
		$Respuesta = mysqli_query($link, $Consulta);
		while ($Fila = mysql_fetch_array($Respuesta))
		{
			$Valor=$Valor+$Fila["peso"];	
		}
		//if($Valor>0)
		//	$Valor=$Valor/1000;
		return round($Valor,0);
	}
	function proceso_cat_prod_comercial_acum($FechaHoraIni,$FechaHoraFin)
	{
		$Valor=0;
		$Consulta = "select sum(t1.peso_produccion)as peso ";
		$Consulta.= " from sec_web.produccion_catodo t1 inner join proyecto_modernizacion.subproducto t2  ";
		$Consulta.= " on t1.cod_producto = t2.cod_producto and t1.cod_subproducto = t2.cod_subproducto  ";
		$Consulta.= " where CONCAT(t1.fecha_produccion,' ',hora) BETWEEN '".substr($FechaHoraIni,0,4)."-" .substr($FechaHoraIni,5,2)."-01 08:00:00' and '".$FechaHoraFin."'";
		$Consulta.= " and t1.cod_producto = 18 and t1.cod_subproducto='1'";
		//echo "a la fecha".$Consulta;
		$Respuesta = mysqli_query($link, $Consulta);
		while ($Fila = mysql_fetch_array($Respuesta))
		{
			$Valor=$Valor+$Fila["peso"];	
		}
		//if($Valor>0)
		//	$Valor=$Valor/1000;
		return round($Valor,0);
	}
	function proceso_cat_prod_acum($FechaHoraIni,$FechaHoraFin)
	{
		$Valor=0;
		$Consulta = "select distinct t1.fecha_produccion, t1.cod_producto, t2.cod_subproducto,  ";
		$Consulta.= " t2.descripcion, sum(t1.peso_produccion)as peso, sum(t1.peso_tara)as peso_tara  ";
		$Consulta.= " from sec_web.produccion_catodo t1 inner join proyecto_modernizacion.subproducto t2  ";
		$Consulta.= " on t1.cod_producto = t2.cod_producto and t1.cod_subproducto = t2.cod_subproducto  ";
		$Consulta.= " where CONCAT(t1.fecha_produccion,' ',hora) BETWEEN '".substr($FechaHoraIni,0,4)."-" .substr($FechaHoraIni,5,2)."-01 08:00:00' and '".$FechaHoraFin."'";
		$Consulta.= " and t1.cod_producto in (18) and t2.cod_subproducto in (1) group by t1.cod_producto, t2.cod_subproducto ";
		//echo $Consulta;
		$Respuesta = mysqli_query($link, $Consulta);
		while ($Fila = mysql_fetch_array($Respuesta))
		{
			$Valor=$Valor+$Fila["peso"];	
		}
		if($Valor>0)
			$Valor=$Valor/1000;
		return round($Valor,0);
	}
	function proceso_calidad_cat_A($FechaHoraIni,$FechaHoraFin)
	{
		//echo $FechaHoraIni."<br>";
		//echo $FechaHoraFin."<br><br>";
		$Valor=0;$ComercialAcumulado=0;
		$FechaHoraIniAux = date("Y-m-d", mktime(1,0,0,substr($FechaHoraIni,5,2),substr($FechaHoraIni,8,2)-1,substr($FechaHoraIni,0,4)))." 08:00:00";
		$FechaHoraFinAux = date("Y-m-d", mktime(1,0,0,substr($FechaHoraIni,5,2),substr($FechaHoraIni,8,2),substr($FechaHoraIni,0,4)))." 07:59:59";
		
		//echo $FechaHoraIniAux."<br>";
		//echo $FechaHoraFinAux."<br>";

		$FechaAux = substr($FechaHoraIniAux,0,7)."-01";
		$FechaAux2 = substr($FechaHoraFinAux,0,10);
		$Consulta="select cod_subproducto as subprod,fecha_produccion as fecha, hour(hora) as horita, sum(peso_produccion) as peso";
		$Consulta.=" from sec_web.produccion_catodo";
		$Consulta.= " where CONCAT(fecha_produccion,' ',hora) BETWEEN '".$FechaAux." 08:00:00' AND '".$FechaAux2." 07:59:59'";
		$Consulta.= " and cod_producto = '18' and cod_subproducto in (1,4,5) ";
		$Consulta.= " group by cod_subproducto,fecha_produccion, hour(hora)";
		//echo $Consulta."</br>";
		$Respuesta = mysqli_query($link, $Consulta);
		while($Fila = mysql_fetch_array($Respuesta))
		{
			if($Fila["subprod"]==1)
			{
				$ComercialAcumulado = $ComercialAcumulado + $Fila["peso"];
			}
		}
		$FechaInf=substr($FechaHoraIniAux,0,10);
		$Consulta = "select * from proyecto_modernizacion.sub_clase ";
		$Consulta.= " where cod_clase = '3004' and cod_subclase = '".intval(substr($FechaInf,5,2))."'";
		//echo $Consulta."<br>";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Fila = mysql_fetch_array($Respuesta))
		{	
			$MesConsulta = $Fila["nombre_subclase"];
			$Letra = $Fila["nombre_subclase"];
		}			
		$Consulta = "select * from sec_web.informe_diario ";
		$Consulta.= " where fecha = '".$FechaInf."'";
		$Resp = mysqli_query($link, $Consulta);
		//echo $Consulta."<br>";
		if ($Fila = mysql_fetch_array($Resp))
		{
					
			$PaqStandard = $Fila["peso_paquete_standard"];
			$PaqStandardGranel = $Fila["peso_standard_granel"];
		}
		$Consulta = " SELECT sum(peso_paquetes) as peso FROM sec_web.paquete_catodo ";
		$Consulta.= " where CONCAT(fecha_creacion_paquete,' ',hora) BETWEEN '".$FechaAux." 08:00:00' AND '".$FechaHoraFinAux."'";
		$Consulta.= " and cod_producto = '18'";
		$Consulta.= " and cod_paquete = '".$Letra."'";
		$Consulta.= " and cod_subproducto in  ('46','2','18')";
		//echo $Consulta."<br>";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Fila = mysql_fetch_array($Respuesta))
		{
			$PesadoEmbarque = $Fila["peso"];
		}
		$PqtesSinPesarGranel = ($PaqStandard + $PaqStandardGranel) * 1000;
		$StandardAcumulado = $PesadoEmbarque + $PqtesSinPesarGranel;
		//PORCENTAJE DE STANDARD
		/*echo "PaqStandard: ".$PaqStandard."<br>";
		echo "PaqStandardGranel: ".$PaqStandardGranel."<br>";
		echo "PesadoEmbarque: ".$PesadoEmbarque."<br>";
		echo "StandardAcumulado: ".$StandardAcumulado."<br>";
		echo "ComercialAcumulado :".$ComercialAcumulado."<br>";*/
		$PorcStandard=0;
		if($ComercialAcumulado>0)
		{	
			$PorcStandard = 100 * ($StandardAcumulado/$ComercialAcumulado);
			//echo "% ".$PorcStandard."<br>";
			$PorcStandard = 100-(100 * ($StandardAcumulado/$ComercialAcumulado));
		}
		return $PorcStandard;
	}
	function proceso_traspaso_restos($FechaHoraIni,$FechaHoraFin)
	{
		$Valor=0;
		$fecha=substr($FechaHoraIni,0,10);
		$fecha2=substr($FechaHoraFin,0,10);
		$consulta = "SELECT ifnull(sum(peso),0) as peso FROM sea_web.movimientos ";
		$consulta.= " WHERE cod_producto = '19' ";
		$consulta.= " AND fecha_movimiento between '".$fecha."' and '".$fecha2."' ";
	    $consulta.= " AND tipo_movimiento in ('4')";
	    $consulta.= " AND hora between '".$FechaHoraIni."' and '".$FechaHoraFin."'";
		$consulta.= " GROUP BY cod_producto ";
		//echo $consulta."<br>";
		$Respuesta = mysql_query($consulta);
		if ($Fila = mysql_fetch_array($Respuesta))
		{
			$Valor = $Fila["peso"];
		}
		return $Valor;
	}	
	switch ($Opcion)
	{
		case "WEB":
			header("location:proceso_indicadores.php?TxtFechaIni=".$TxtFechaIni."&Msj=Datos Procesados");
			break;
		case "AUT":
			echo "<script>window.open('','_parent','');";
			echo "var ventana = window.self;";
			echo "ventana.opener = window.self;";
			echo "ventana.close();</script>";
			break;
	}
?>