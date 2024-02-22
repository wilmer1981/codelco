<?php
	$Eliminar = "delete from sec_web.tmp_tipo_mov_cab ";
	mysqli_query($link, $Eliminar);
	$Eliminar = "delete from sec_web.tmp_tipo_mov_det ";
	mysqli_query($link, $Eliminar);
	if ($Producto == 48)
	{
		$ProductoCons = 18;
		$SubProductoCons = 1;
	}
	else
	{
		$ProductoCons = $Producto;
		$SubProductoCons = $SubProducto;
	}
	$FechaInicio = $AnoIni."-".str_pad($MesIni,2, "0", STR_PAD_LEFT)."-".str_pad($DiaIni,2, "0", STR_PAD_LEFT);
	$FechaTermino = $AnoFin."-".str_pad($MesFin,2, "0", STR_PAD_LEFT)."-".str_pad($DiaFin,2, "0", STR_PAD_LEFT);	

	//-------------------------PROCESO DE LLENADO DE TABLAS-----------------------------	
	//DATOS DIARIOS
	$FechaAux = $FechaInicio;		
	while (date($FechaAux) <= date($FechaTermino))
	{
		$Fecha1 = date("Y-m-d",mktime(0,0,0,substr($FechaAux,5,2),(substr($FechaAux,8,2)),substr($FechaAux,0,4)));
		$Fecha2 = date("Y-m-d",mktime(0,0,0,substr($FechaAux,5,2),(substr($FechaAux,8,2)),substr($FechaAux,0,4)));										
		//---------------------------------SACA PESOS Y LEYES----------------------------------
		SacaLeyesDiarias($Producto, $SubProducto, $ProductoCons, $SubProductoCons, $Fecha1, $Fecha2);		
		$FechaAux = $Fecha2;
		$FechaAux = date("Y-m-d", mktime(0,0,0,substr($FechaAux,5,2),intval(substr($FechaAux,8,2)) + 1,substr($FechaAux,0,4)));
	}
	//DATOS SEMANALES
	$FechaAux = $FechaInicio;	
	while (date($FechaAux) <= date($FechaTermino))
	{
		if (intval(substr($FechaAux,8,2)) <= 7)
		{
			$Fecha1 = substr($FechaAux,0,7)."-01";					
			$Fecha2 = substr($FechaAux,0,7)."-07";
		}
		else
		{
			if ((intval(substr($FechaAux,8,2)) >= 8) && (intval(substr($FechaAux,8,2)) <= 14))
			{					
				$Fecha1 = substr($FechaAux,0,7)."-08";					
				$Fecha2 = substr($FechaAux,0,7)."-14";
			}
			else
			{
				if ((intval(substr($FechaAux,8,2)) >= 15) && (intval(substr($FechaAux,8,2)) <= 21))
				{					
					$Fecha1 = substr($FechaAux,0,7)."-15";					
					$Fecha2 = substr($FechaAux,0,7)."-21";
				}
				else
				{
					if ((intval(substr($FechaAux,8,2)) >= 22) && (intval(substr($FechaAux,8,2)) <= 31))
					{				
						$Fecha1 = substr($FechaAux,0,7)."-22";					
						$Fecha2 = substr($FechaAux,0,7)."-31";
					}
				}							
			}
		}					
		//---------------------------------SACA PESOS Y LEYES----------------------------------
		SacaLeyesSemanales($Producto, $SubProducto, $ProductoCons, $SubProductoCons, $Fecha1, $Fecha2);		
		$FechaAux = $Fecha2;
		$FechaAux = date("Y-m-d", mktime(0,0,0,substr($FechaAux,5,2),intval(substr($FechaAux,8,2)) + 1,substr($FechaAux,0,4)));
	}
	//DATOS QUINCENALES
	$FechaAux = $FechaInicio;		
	while (date($FechaAux) <= date($FechaTermino))
	{
		if (intval(substr($FechaAux,8,2)) <= 15)
		{
			$Fecha1 = substr($FechaAux,0,7)."-01";					
			$Fecha2 = substr($FechaAux,0,7)."-15";
		}
		else
		{					
			$Fecha1 = substr($FechaAux,0,7)."-16";					
			$Fecha2 = substr($FechaAux,0,7)."-31";
		}
		//---------------------------------SACA PESOS Y LEYES----------------------------------
		SacaLeyesQuincenales($Producto, $SubProducto, $ProductoCons, $SubProductoCons, $Fecha1, $Fecha2);		
		$FechaAux = $Fecha2;
		$FechaAux = date("Y-m-d", mktime(0,0,0,substr($FechaAux,5,2),intval(substr($FechaAux,8,2)) + 1,substr($FechaAux,0,4)));
	}				
	//DATOS MENSUALES
	$FechaAux = $FechaInicio;		
	while (date($FechaAux) <= date($FechaTermino))
	{
		$Fecha1 = date("Y-m-d",mktime(0,0,0,substr($FechaAux,5,2),01,substr($FechaAux,0,4)));
		$Fecha2 = date("Y-m-d",mktime(0,0,0,substr($FechaAux,5,2)+1,01-1,substr($FechaAux,0,4)));					
		//---------------------------------SACA PESOS Y LEYES----------------------------------
		SacaLeyesMensuales($Producto, $SubProducto, $ProductoCons, $SubProductoCons, $Fecha1, $Fecha2);
		$FechaAux = $Fecha2;
		$FechaAux = date("Y-m-d", mktime(0,0,0,substr($FechaAux,5,2),intval(substr($FechaAux,8,2)) + 1,substr($FechaAux,0,4)));
	}								

//---------------------------FUNCIONES--------------------------------

function SacaLeyesDiarias($Producto, $SubProducto, $ProductoCons, $SubProductoCons, $Fecha1, $Fecha2)
{
	//-------------------------CONSULTA PESO-----------------------------						
	$Consulta = "SELECT cod_grupo, cod_cuba, sum(peso_produccion) as peso ";
	$Consulta.= " from sec_web.produccion_catodo";
	$Consulta.= " where cod_producto = '".$Producto."'";
	$Consulta.= " and cod_subproducto = '".$SubProducto."'";
	$Consulta.= " and fecha_produccion between '".$Fecha1."' and '".$Fecha2."'";
	if (($Producto == 18) && ($SubProducto == 3))
		$Consulta.= " group by cod_grupo, cod_cuba ";
	else
		$Consulta.= " group by cod_grupo";
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		$CodGrupo = $Fila["cod_grupo"];
		$CodCuba = $Fila["cod_cuba"];
		//-------------------------INSERTA EN LA CABECERA-----------------------------
		$Insertar = "INSERT INTO sec_web.tmp_tipo_mov_cab (tipo_mov, cod_producto, cod_subproducto, cod_periodo, fecha1, ";
		$Insertar.= " fecha2, num_envio, lote, nro_sa, num_certificado, grupo, cuba, peso)  ";
		$Insertar.= "  VALUES ";
		$Insertar.= " ('P', '".$Producto."', '".$SubProducto."', '1', '".$Fecha1."', '".$Fecha2."', ";
		$Insertar.= " '', '', '', '', '".$Fila["cod_grupo"]."', '".$Fila["cod_cuba"]."', '".$Fila["peso"]."')";
		mysqli_query($link, $Insertar);
		//---------------------------LEYES DE CALIDAD---------------------------------
		$FechaAux1 = date("Y-m-d",mktime(0,0,0,substr($Fecha1,5,2),(substr($Fecha1,8,2)) - 3,substr($Fecha1,0,4)));
		$FechaAux2 = date("Y-m-d",mktime(0,0,0,substr($Fecha2,5,2),(substr($Fecha2,8,2)) + 3,substr($Fecha2,0,4)));
		$Consulta = "SELECT t2.cod_leyes, t2.valor, t1.fecha_muestra, ";
		$Consulta.= " t2.signo, t1.nro_solicitud, t3.abreviatura ";
		$Consulta.= " from cal_web.solicitud_analisis t1 inner join ";
		$Consulta.= " cal_web.leyes_por_solicitud  t2 on t1.nro_solicitud = t2.nro_solicitud ";
		$Consulta.= " and t1.fecha_hora = t2.fecha_hora and t1.rut_funcionario = t2.rut_funcionario and t1.recargo = t2.recargo ";
		$Consulta.= " inner join proyecto_modernizacion.leyes t3 on t2.cod_leyes = t3.cod_leyes";					
		$Consulta.= " where t1.fecha_muestra between '".$FechaAux1." 00:00:00' and '".$FechaAux2." 23:59:59'";			
		if (($Producto == 18) && ($SubProducto == 3)) //DESC. NORMAL (DIARIA POR GRUPO CUBA)
		{
			$Grupo = $CodGrupo;
			$Cuba = $CodCuba;								
			if(substr($Grupo,0,1) == 0)
				$Grupo = substr($Grupo,1,1);						
			if(substr($Cuba,0,1) == 0 AND substr($Cuba,1,1) != 0)
				$Cuba = substr($Cuba,1,1);									
			$Consulta.= " and (t1.tipo = 1 and ";
			$Consulta.= " left(t1.id_muestra,5) like '%".$Grupo."%'";
			$Consulta.= " AND right(t1.id_muestra,2) like '%".$Cuba."%') ";	 
		}
		else
		{
			if (($Producto == 18) && ($SubProducto == 5)) //CAT E.W.
			{
				//
			}
			else
			{			
				$Consulta.= " and ((t1.tipo = 1 and (t1.id_muestra = '".$CodGrupo."' or t1.id_muestra = '".intval($CodGrupo)."')) ";
				$Consulta.= " or (t1.tipo = '2' and (t1.id_muestra = '".$CodGrupo."-R' or t1.id_muestra = '".intval($CodGrupo)."-R'))) ";								
			}
		}
		$Consulta.= " and cod_periodo = '1' ";			
		$Consulta.= " and t1.estado_actual <> '16' and t1.estado_actual <> '7'";
		$Consulta.= " and t1.frx <> 'S' and t1.cod_analisis = '1'";
		$Consulta.= " and t1.cod_producto = '".$ProductoCons."' ";
		if ($SubProducto != "3")
			$Consulta.= " and t1.cod_subproducto = '".$SubProductoCons."'";
		$Consulta.= " order by t1.fecha_muestra desc, t1.nro_solicitud, t2.cod_leyes ";
		//echo $Consulta."<br>";
		$Respuesta2 = mysqli_query($link, $Consulta);	
		while ($Fila2 = mysqli_fetch_array($Respuesta2))
		{	
			//INSERTA VALOR EN BD
			$Insertar = "INSERT INTO sec_web.tmp_tipo_mov_det (tipo_mov, cod_producto, cod_subproducto, cod_periodo, fecha1, ";
			$Insertar.= " fecha2, num_envio, lote, nro_sa, num_certificado, grupo, cuba,  ";
			$Insertar.= " cod_leyes, valor, unidad, peso) VALUES ";
			$Insertar.= " ('P', '".$Producto."', '".$SubProducto."', '1', '".$Fecha1."', '".$Fecha2."', ";
			$Insertar.= " '', '', '".$Fila2["nro_solicitud"]."', '', '".$CodGrupo."', '".$CodCuba."', ";
			$Insertar.= " '".$Fila2["cod_leyes"]."', '".$Fila2["valor"]."', '','".$Fila["peso"]."')";				
			//echo $Insertar."<br>";
			mysqli_query($link, $Insertar);
		}	
	}		
}

function SacaLeyesSemanales($Producto, $SubProducto, $ProductoCons, $SubProductoCons, $Fecha1, $Fecha2)
{
	//-------------------------CONSULTA PESO-----------------------------						
	$Consulta = "SELECT sum(peso_produccion) as peso ";
	$Consulta.= " from sec_web.produccion_catodo";
	$Consulta.= " where cod_producto = '".$Producto."'";
	$Consulta.= " and cod_subproducto = '".$SubProducto."'";
	$Consulta.= " and fecha_produccion between '".$Fecha1."' and '".$Fecha2."'";	
	$Consulta.= " group by cod_producto, cod_subproducto ";
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Respuesta))
	{		
		//-------------------------INSERTA EN LA CABECERA-----------------------------
		$Insertar = "INSERT INTO sec_web.tmp_tipo_mov_cab (tipo_mov, cod_producto, cod_subproducto, cod_periodo, fecha1, ";
		$Insertar.= " fecha2, num_envio, lote, nro_sa, num_certificado, grupo, cuba, peso)  ";
		$Insertar.= "  VALUES ";
		$Insertar.= " ('P', '".$Producto."', '".$SubProducto."', '2', '".$Fecha1."', '".$Fecha2."', ";
		$Insertar.= " '', '', '', '', '', '', '".$Fila["peso"]."')";
		mysqli_query($link, $Insertar);
		//---------------------------LEYES DE CALIDAD---------------------------------
		$Consulta = "SELECT t2.cod_leyes, t2.valor, t1.fecha_muestra, ";
		$Consulta.= " t2.signo, t1.nro_solicitud, t3.abreviatura ";
		$Consulta.= " from cal_web.solicitud_analisis t1 inner join ";
		$Consulta.= " cal_web.leyes_por_solicitud  t2 on t1.nro_solicitud = t2.nro_solicitud ";
		$Consulta.= " and t1.fecha_hora = t2.fecha_hora and t1.rut_funcionario = t2.rut_funcionario and t1.recargo = t2.recargo ";
		$Consulta.= " inner join proyecto_modernizacion.leyes t3 on t2.cod_leyes = t3.cod_leyes";					
		$Consulta.= " where t1.fecha_muestra between '".$Fecha1." 00:00:00' and '".$Fecha2." 23:59:59'";				
		$Consulta.= " and cod_periodo = '2' ";				
		$Consulta.= " and t1.estado_actual <> '16' and t1.estado_actual <> '7'";
		$Consulta.= " and t1.frx <> 'S' and t1.cod_analisis = '1'";
		$Consulta.= " and t1.cod_producto = '".$ProductoCons."' ";
		//if ($SubProducto != "3")
			$Consulta.= " and t1.cod_subproducto = '".$SubProductoCons."'";
		$Consulta.= " order by t1.fecha_muestra desc, t1.nro_solicitud, t2.cod_leyes ";
		$Respuesta2 = mysqli_query($link, $Consulta);			
		while ($Fila2 = mysqli_fetch_array($Respuesta2))
		{	
			//INSERTA VALOR EN BD
			$Insertar = "INSERT INTO sec_web.tmp_tipo_mov_det (tipo_mov, cod_producto, cod_subproducto, cod_periodo, fecha1, ";
			$Insertar.= " fecha2, num_envio, lote, nro_sa, num_certificado, grupo, cuba, ";
			$Insertar.= " cod_leyes, valor, unidad, peso) VALUES ";
			$Insertar.= " ('P', '".$Producto."', '".$SubProducto."', '2', '".$Fecha1."', '".$Fecha2."', ";
			$Insertar.= " '', '', '".$Fila2["nro_solicitud"]."', '', '', '', ";
			$Insertar.= " '".$Fila2["cod_leyes"]."', '".$Fila2["valor"]."', '','".$Fila["peso"]."')";				
			mysqli_query($link, $Insertar);
		}
	}
}

function SacaLeyesQuincenales($Producto, $SubProducto, $ProductoCons, $SubProductoCons, $Fecha1, $Fecha2)
{
	//-------------------------CONSULTA PESO-----------------------------						
	$Consulta = "SELECT sum(peso_produccion) as peso ";
	$Consulta.= " from sec_web.produccion_catodo";
	$Consulta.= " where cod_producto = '".$Producto."'";
	$Consulta.= " and cod_subproducto = '".$SubProducto."'";
	$Consulta.= " and fecha_produccion between '".$Fecha1."' and '".$Fecha2."'";	
	$Consulta.= " group by cod_producto, cod_subproducto ";
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Respuesta))
	{		
		//-------------------------INSERTA EN LA CABECERA-----------------------------
		$Insertar = "INSERT INTO sec_web.tmp_tipo_mov_cab (tipo_mov, cod_producto, cod_subproducto, cod_periodo, fecha1, ";
		$Insertar.= " fecha2, num_envio, lote, nro_sa, num_certificado, grupo, cuba, peso)  ";
		$Insertar.= "  VALUES ";
		$Insertar.= " ('P', '".$Producto."', '".$SubProducto."', '5', '".$Fecha1."', '".$Fecha2."', ";
		$Insertar.= " '', '', '', '', '', '', '".$Fila["peso"]."')";
		mysqli_query($link, $Insertar);
		//---------------------------LEYES DE CALIDAD---------------------------------
		$Consulta = "SELECT t2.cod_leyes, t2.valor, t1.fecha_muestra, ";
		$Consulta.= " t2.signo, t1.nro_solicitud, t3.abreviatura ";
		$Consulta.= " from cal_web.solicitud_analisis t1 inner join ";
		$Consulta.= " cal_web.leyes_por_solicitud  t2 on t1.nro_solicitud = t2.nro_solicitud ";
		$Consulta.= " and t1.fecha_hora = t2.fecha_hora and t1.rut_funcionario = t2.rut_funcionario and t1.recargo = t2.recargo ";
		$Consulta.= " inner join proyecto_modernizacion.leyes t3 on t2.cod_leyes = t3.cod_leyes";					
		$Consulta.= " where t1.fecha_muestra between '".$Fecha1." 00:00:00' and '".$Fecha2." 23:59:59'";				
		$Consulta.= " and cod_periodo = '5' ";				
		$Consulta.= " and t1.estado_actual <> '16' and t1.estado_actual <> '7'";
		$Consulta.= " and t1.frx <> 'S' and t1.cod_analisis = '1'";
		$Consulta.= " and t1.cod_producto = '".$ProductoCons."' ";
		//if ($SubProducto != "3")
			$Consulta.= " and t1.cod_subproducto = '".$SubProductoCons."'";
		$Consulta.= " order by t1.fecha_muestra desc, t1.nro_solicitud, t2.cod_leyes ";
		$Respuesta2 = mysqli_query($link, $Consulta);	
		while ($Fila2 = mysqli_fetch_array($Respuesta2))
		{	
			//INSERTA VALOR EN BD
			$Insertar = "INSERT INTO sec_web.tmp_tipo_mov_det (tipo_mov, cod_producto, cod_subproducto, cod_periodo, fecha1, ";
			$Insertar.= " fecha2, num_envio, lote, nro_sa, num_certificado, grupo, cuba, ";
			$Insertar.= " cod_leyes, valor, unidad, peso) VALUES ";
			$Insertar.= " ('P', '".$Producto."', '".$SubProducto."', '5', '".$Fecha1."', '".$Fecha2."', ";
			$Insertar.= " '', '', '".$Fila2["nro_solicitud"]."', '', '', '', ";
			$Insertar.= " '".$Fila2["cod_leyes"]."', '".$Fila2["valor"]."', '', '".$Fila["peso"]."')";				
			mysqli_query($link, $Insertar);
		}
	}
}

function SacaLeyesMensuales($Producto, $SubProducto, $ProductoCons, $SubProductoCons, $Fecha1, $Fecha2)
{
	//-------------------------CONSULTA PESO-----------------------------						
	$Consulta = "SELECT sum(peso_produccion) as peso ";
	$Consulta.= " from sec_web.produccion_catodo";
	$Consulta.= " where cod_producto = '".$Producto."'";
	$Consulta.= " and cod_subproducto = '".$SubProducto."'";
	$Consulta.= " and fecha_produccion between '".$Fecha1."' and '".$Fecha2."'";	
	$Consulta.= " group by cod_producto, cod_subproducto ";
	$Respuesta = mysqli_query($link, $Consulta);
	while ($Fila = mysqli_fetch_array($Respuesta))
	{		
		//-------------------------INSERTA EN LA CABECERA-----------------------------
		$Insertar = "INSERT INTO sec_web.tmp_tipo_mov_cab (tipo_mov, cod_producto, cod_subproducto, cod_periodo, fecha1, ";
		$Insertar.= " fecha2, num_envio, lote, nro_sa, num_certificado, grupo, cuba, peso)  ";
		$Insertar.= "  VALUES ";
		$Insertar.= " ('P', '".$Producto."', '".$SubProducto."', '3', '".$Fecha1."', '".$Fecha2."', ";
		$Insertar.= " '', '', '', '', '', '', '".$Fila["peso"]."')";
		mysqli_query($link, $Insertar);
		//---------------------------LEYES DE CALIDAD---------------------------------
		$Consulta = "SELECT t2.cod_leyes, t2.valor, t1.fecha_muestra, ";
		$Consulta.= " t2.signo, t1.nro_solicitud, t3.abreviatura ";
		$Consulta.= " from cal_web.solicitud_analisis t1 inner join ";
		$Consulta.= " cal_web.leyes_por_solicitud  t2 on t1.nro_solicitud = t2.nro_solicitud ";
		$Consulta.= " and t1.fecha_hora = t2.fecha_hora and t1.rut_funcionario = t2.rut_funcionario and t1.recargo = t2.recargo ";
		$Consulta.= " inner join proyecto_modernizacion.leyes t3 on t2.cod_leyes = t3.cod_leyes";					
		$Consulta.= " where t1.fecha_muestra between '".$Fecha1." 00:00:00' and '".$Fecha2." 23:59:59'";				
		$Consulta.= " and t1.cod_periodo = '3' ";				
		$Consulta.= " and t1.estado_actual <> '16' and t1.estado_actual <> '7'";
		$Consulta.= " and t1.frx <> 'S' and t1.cod_analisis = '1'";
		$Consulta.= " and t1.cod_producto = '".$ProductoCons."' ";
		//if ($SubProducto != "3")
			$Consulta.= " and t1.cod_subproducto = '".$SubProductoCons."'";
		$Consulta.= " order by t1.fecha_muestra desc, t1.nro_solicitud, t2.cod_leyes ";
		$Respuesta2 = mysqli_query($link, $Consulta);	
		while ($Fila2 = mysqli_fetch_array($Respuesta2))
		{	
			//INSERTA VALOR EN BD
			$Insertar = "INSERT INTO sec_web.tmp_tipo_mov_det (tipo_mov, cod_producto, cod_subproducto, cod_periodo, fecha1, ";
			$Insertar.= " fecha2, num_envio, lote, nro_sa, num_certificado, grupo, cuba, ";
			$Insertar.= " cod_leyes, valor, unidad, peso) VALUES ";
			$Insertar.= " ('P', '".$Producto."', '".$SubProducto."', '3', '".$Fecha1."', '".$Fecha2."', ";
			$Insertar.= " '', '', '".$Fila2["nro_solicitud"]."', '', '', '', ";
			$Insertar.= " '".$Fila2["cod_leyes"]."', '".$Fila2["valor"]."', '', '".$Fila["peso"]."')";				
			mysqli_query($link, $Insertar);
		}
	}
}

?>