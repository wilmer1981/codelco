<?php
function RescataPeso($TipoMov,$Producto,$SubProducto,$Flujo,$FechaInicio,$FechaTermino,$PesoAux,$Fino_Cu,$Fino_Ag,$Fino_Au)
{
	$AnoConsulta = substr($FechaTermino,0,4); 
	$MesConsulta = intval(substr($FechaTermino,5,2));
	$Consulta = "select * from proyecto_modernizacion.sub_clase ";
	$Consulta.= " where cod_clase=3004 and cod_subclase =".$MesConsulta;
	$RespAux = mysqli_query($link, $Consulta);
	if ($FilaAux = mysqli_fetch_array($RespAux))
	{
		$Letra = $FilaAux["nombre_subclase"];
	}	
	$PesoFlujo = 0;
	$FinoCu = 0;
	$FinoAg = 0;
	$FinoAu = 0;
	switch ($TipoMov)
	{
		case "0": //PESAJE PRODUCCION
			if ($Producto == 18 && $SubProducto == 1)
			{
				//PAQUETE GRADO A Y STANDARD
				$Consulta = "select sum(peso_paquetes) as peso_produccion  ";
				$Consulta.= " from sec_web.paquete_catodo where cod_producto='18'";
				$Consulta.= " and (cod_subproducto ='2' or cod_subproducto ='40') ";
				$Consulta.= " and cod_paquete='".$Letra."' ";
				$Consulta.= " and year(fecha_creacion_paquete)=".$AnoConsulta;
				$Consulta.= " group by cod_producto "; 
			}
			else
			{
				$Consulta = "select sum(peso_produccion) as peso_produccion ";
				$Consulta.= " from sec_web.produccion_catodo";
				$Consulta.= " where cod_producto = '".$Producto."'";
				$Consulta.= " and cod_subproducto = '".$SubProducto."'";
				$Consulta.= " and fecha_produccion between '".$FechaInicio."' and '".$FechaTermino."'";	
				$Consulta.= " group by cod_producto, cod_subproducto ";
			}
			$RespAux = mysqli_query($link, $Consulta);
			if ($FilaAux = mysqli_fetch_array($RespAux))
			{
				$PesoFlujo = $FilaAux["peso_produccion"];
				RescataFinos($AnoConsulta,$MesConsulta,$AnoConsulta,$MesConsulta,$TipoMov,$Producto,$SubProducto,$Flujo,$PesoFlujo,&$FinoCu, &$FinoAg, &$FinoAu);				
			}
			break;
		case "1": //PESAJE PAQUETES
			$Consulta = "select sum(peso_paquetes) as peso_paquetes  ";
			$Consulta.= " from sec_web.paquete_catodo where cod_producto='".$Producto."'";
			$Consulta.= " and cod_subproducto ='".$SubProducto."' ";
			$Consulta.= " and cod_paquete='".$Letra."' ";
			$Consulta.= " and year(fecha_creacion_paquete)=".$AnoConsulta;
			$Consulta.= " group by cod_producto,cod_subproducto"; 
			$RespAux = mysqli_query($link, $Consulta);
			if ($FilaAux = mysqli_fetch_array($RespAux))
			{
				$PesoFlujo = $FilaAux["peso_paquetes"];
				RescataFinos($AnoConsulta,$MesConsulta,$AnoConsulta,$MesConsulta,$TipoMov,$Producto,$SubProducto,$Flujo,$PesoFlujo,&$FinoCu, &$FinoAg, &$FinoAu);				
			}
			break;
		case "2": //EMBARQUE			
			$Consulta = "select t2.cod_producto, t2.cod_subproducto, sum(t2.peso_paquetes) as peso_embarque, ";
			$Consulta.= " year(t2.fecha_creacion_paquete) as ano, t2.cod_paquete as serie";
			$Consulta.= " from sec_web.guia_despacho_emb t1 inner join sec_web.paquete_catodo t2  ";
			$Consulta.= " on t1.num_guia=t2.num_guia ";
			$Consulta.= " where (t1.cod_estado <>'A') ";
			$Consulta.= " and (t1.fecha_guia between '".$FechaInicio."' and '".$FechaTermino."')";
			$Consulta.= " and (t2.cod_estado = 'c') ";
			$Consulta.= " and (t2.cod_producto='".$Producto."' ";
			$Consulta.= " and t2.cod_subproducto ='".$SubProducto."')";
			$Consulta.= " group by  t2.cod_producto, t2.cod_subproducto, ano, serie";
			$RespAux = mysqli_query($link, $Consulta);			
			while ($FilaAux = mysqli_fetch_array($RespAux))
			{
				$Consulta = "select * from proyecto_modernizacion.sub_clase ";
				$Consulta.= " where cod_clase=3004 and nombre_subclase = '".$FilaAux["serie"]."'";
				$RespAux2 = mysqli_query($link, $Consulta);
				if ($FilaAux2 = mysqli_fetch_array($RespAux2))
				{
					$MesAux = $FilaAux2["cod_subclase"];
				}
				$PesoFlujo = $PesoFlujo + $FilaAux["peso_embarque"];
				RescataFinos($AnoConsulta,$MesConsulta,$FilaAux["ano"],$MesAux,$TipoMov,$Producto,$SubProducto,$Flujo,$FilaAux["peso_embarque"],&$FinoCu, &$FinoAg, &$FinoAu);				
			}
			break;
		case "3": //TRASPASO
			//TABLA MOVIMIENTOS DEL SISTEMA SEA_WEB			
			$Consulta = "select t2.cod_producto, t2.cod_subproducto,sum(t1.peso) as peso_traspaso, ";
			$Consulta.= " year(t2.fecha_creacion_lote) as ano, t2.cod_bulto as serie";
			$Consulta.= " from sea_web.movimientos t1 inner join sec_web.traspaso t2";
			$Consulta.= " on t1.hornada = t2.hornada";
			$Consulta.= "  where t1.cod_producto='".$Producto."'";
			$Consulta.= "  and t1.cod_subproducto = '".$SubProducto."' ";
			$Consulta.= " and t1.tipo_movimiento = '4'";
			$Consulta.= "  and t1.fecha_movimiento ";
			$Consulta.= "  between '".$FechaInicio."' and '".$FechaTermino."'";
			$Consulta.= "  group by t1.cod_producto,t1.cod_subproducto, serie"; 
			//echo $Consulta."<br>";
			$RespAux = mysqli_query($link, $Consulta);
			while ($FilaAux = mysqli_fetch_array($RespAux))
			{
				$PesoTraspaso = $FilaAux["peso_traspaso"];
				$Consulta = "select * from proyecto_modernizacion.sub_clase ";
				$Consulta.= " where cod_clase=3004 and nombre_subclase = '".$FilaAux["serie"]."'";
				$RespAux2 = mysqli_query($link, $Consulta);
				if ($FilaAux2 = mysqli_fetch_array($RespAux2))
				{
					$MesAux = $FilaAux2["cod_subclase"];
				}
				//TABLA STOC_PISO DEL SISTEMA SEA_WEB
				$Consulta = "select sum(peso) as peso_piso from sea_web.stock_piso_raf ";
				$Consulta.= " where fecha between '".$FechaInicio."' and '".$FechaTermino."'";
				$Consulta.= " and cod_producto = '".$Producto."'";
				$Consulta.= " and cod_subproducto = '".$SubProducto."'";
				$Consulta.= " group by cod_producto, cod_subproducto";
				$RespAux2 = mysqli_query($link, $Consulta);
				while ($FilaAux2 = mysqli_fetch_array($RespAux2))
				{
					$PesoTraspaso = $PesoTraspaso - $FilaAux2["peso_piso"];
				}
				
				$PesoFlujo = $PesoFlujo + $PesoTraspaso;
				if ($PesoTraspaso > 0)
				{
					RescataFinos($AnoConsulta,$MesConsulta,$FilaAux["ano"],$MesAux,$TipoMov,$Producto,$SubProducto,$Flujo,$PesoTraspaso,&$FinoCu, &$FinoAg, &$FinoAu);				
				}
			}						
			break;
	}
	$PesoAux = $PesoFlujo;
	//echo "FLUJO=".$Flujo." PROD=".$Producto." SUBPROD=".$SubProducto." ".$PesoFlujo."<br>";
	$Fino_Cu = $Fino_Cu + $FinoCu;
	$Fino_Ag = $Fino_Ag + $FinoAg;
	$Fino_Au = $Fino_Au + $FinoAu;	
}	

function RescataLeyes($Ano, $Mes)
{
	$Consulta = "select * from proyecto_modernizacion.sub_clase ";
	$Consulta.= " where cod_clase=3004 and cod_subclase =".$Mes;
	$RespAux = mysqli_query($link, $Consulta);
	if ($FilaAux = mysqli_fetch_array($RespAux))
	{
		$Letra = $FilaAux["nombre_subclase"];
	}

	$Eliminar = "delete from sec_web.leyes_anexo";
	mysqli_query($link, $Eliminar);
	
	$Mensaje = "";
	$Msg = CalculaLeyesComerciales($Letra, $Ano, $Mes);
	$Mensaje = $Mensaje."".$Msg."<br>";
	$Msg = CalculaLeyesDescParcial($Letra, $Ano, $Mes);
	$Mensaje = $Mensaje."".$Msg."<br>";
	$Msg = CalculaLeyesExternos($Letra, $Ano, $Mes);
	$Mensaje = $Mensaje."".$Msg."<br>";
	$Msg = CalculaLeyesEW($Letra, $Ano, $Mes);
	$Mensaje = $Mensaje."".$Msg."<br>";
	$Msg = RescataLeyesPorSerie($Letra, $Ano, $Mes);
	$Mensaje = $Mensaje."".$Msg."<br>";
	if ($Mensaje != "")
	{
		echo "&nbsp;";
		VentanaAlerta($Mensaje, 230, 60);
	}
}

function CalculaLeyesComerciales($Letra, $AnoConsulta, $MesConsulta)
{	
	$Mensaje = "";
	for ($i=1; $i<=4; $i++)
	{
		switch ($i)
		{
			case 1:
				$Fecha1 = $AnoConsulta."-".$MesConsulta."-01";
				$Fecha2 = $AnoConsulta."-".$MesConsulta."-07";
				break;
			case 2:
				$Fecha1 = $AnoConsulta."-".$MesConsulta."-08";
				$Fecha2 = $AnoConsulta."-".$MesConsulta."-14";
				break;
			case 3:
				$Fecha1 = $AnoConsulta."-".$MesConsulta."-15";
				$Fecha2 = $AnoConsulta."-".$MesConsulta."-21";
				break;
			case 4:
				$Fecha1 = $AnoConsulta."-".$MesConsulta."-22";
				$Fecha2 = $AnoConsulta."-".$MesConsulta."-31";
				break;
		}
		$Consulta = "select sum(peso_produccion) as peso_produccion ";
		$Consulta.= " from sec_web.produccion_catodo";
		$Consulta.= " where cod_producto = '18'";//CATODOS COMERCIALES
		$Consulta.= " and cod_subproducto = '1'";
		$Consulta.= " and fecha_produccion between '".$Fecha1."' and '".$Fecha2."'";	
		$Consulta.= " group by cod_producto, cod_subproducto ";
		$RespAux = mysqli_query($link, $Consulta);
		if ($FilaAux = mysqli_fetch_array($RespAux))
		{			
			$PesoSemana = $FilaAux["peso_produccion"];
			$PesoMes = $PesoMes + $PesoSemana;
			//-------------------------LEYES DE CALIDAD-----------------------------
			$Consulta = "select t2.cod_leyes, t2.valor, t1.fecha_muestra, ";
			$Consulta.= " t2.signo, t1.nro_solicitud, t3.abreviatura ";
			$Consulta.= " from cal_web.solicitud_analisis t1 inner join ";
			$Consulta.= " cal_web.leyes_por_solicitud  t2 on t1.nro_solicitud = t2.nro_solicitud ";
			$Consulta.= " and t1.fecha_hora = t2.fecha_hora and t1.rut_funcionario = t2.rut_funcionario and t1.recargo = t2.recargo ";
			$Consulta.= " inner join proyecto_modernizacion.leyes t3 on t2.cod_leyes = t3.cod_leyes";				
			$Consulta.= " where t1.fecha_muestra between '".$Fecha1." 00:00:00' and '".$Fecha2." 23:59:59'";
			$Consulta.= " and t1.estado_actual <> '16' and t1.estado_actual <> '7'";
			$Consulta.= " and t1.frx <> 'S' and t1.cod_analisis = '1'";
			$Consulta.= " and t1.cod_periodo = '2'";			
			//$Consulta.= " and ((t1.tipo = 1 and (t1.id_muestra = '".$Fila3["cod_grupo"]."' or t1.id_muestra = '".intval($Fila3["cod_grupo"])."')) ";			
			$Consulta.= " and t1.cod_producto = '18' and t1.cod_subproducto = '1'";
			$Consulta.= " and (t2.cod_leyes = '02' or t2.cod_leyes = '04' or t2.cod_leyes = '05')";
			$Consulta.= " order by t1.fecha_muestra desc, t1.nro_solicitud, t2.cod_leyes ";
			$RespAux2 = mysqli_query($link, $Consulta);
			$Encontro = "N";								
			while ($FilaAux2 = mysqli_fetch_array($RespAux2))
			{
				$Encontro = "S";
				switch ($FilaAux2["cod_leyes"])
				{					
					case "04":
						$FinoAg = $FinoAg + ($PesoSemana * $FilaAux2["valor"]);
						break;
					case "05":
						$FinoAu = $FinoAu + ($PesoSemana * $FilaAux2["valor"]);
						break;
				}						
			}
			if ($Encontro == "N")
			{
				$Mensaje.= "Faltan Leyes de Catodos Comerciales de la ";
				$Mensaje.= " Semana del  ".$Fecha1." al ".$Fecha2."<br>";
			}
			//------------------------------------------------------------------------
		}	
	}
	$FinoCu = 99.99;	
	if ($FinoAg > 0 && $PesoMes > 0)
		$FinoAg = $FinoAg / $PesoMes;
	if ($FinoAu > 0 && $PesoMes > 0)
		$FinoAu = $FinoAu / $PesoMes;
	//INSERTA LEYES COMERCIALES
	$Insertar = "INSERT INTO sec_web.leyes_anexo ";
	$Insertar.= " (ano, mes, cod_producto, cod_subproducto, serie, peso, cu, ag, au) ";
	$Insertar.= " VALUES ('".$AnoConsulta."', '".$MesConsulta."', '18', '1', '".$Letra."', '".$PesoMes."', '".$FinoCu."', '".$FinoAg."', '".$FinoAu."')";
	mysqli_query($link, $Insertar);
	
	return $Mensaje;
}

function CalculaLeyesDescParcial($Letra, $AnoConsulta, $MesConsulta)
{	
	$Mensaje = "";
	for ($i=1; $i<=2; $i++)
	{
		switch ($i)
		{
			case 1:
				$Fecha1 = $AnoConsulta."-".$MesConsulta."-01";
				$Fecha2 = $AnoConsulta."-".$MesConsulta."-15";
				break;
			case 2:
				$Fecha1 = $AnoConsulta."-".$MesConsulta."-16";
				$Fecha2 = $AnoConsulta."-".$MesConsulta."-31";
				break;			
		}
		$Consulta = "select sum(peso_produccion) as peso_paquetes  ";
		$Consulta.= " from sec_web.produccion_catodo";
		$Consulta.= " where cod_producto='18'";
		$Consulta.= " and cod_subproducto ='4' ";//CAT. DESC. PARCIAL
		//$Consulta.= " and cod_paquete='".$Letra."' ";
		//$Consulta.= " and year(fecha_creacion_paquete)=".$AnoConsulta;
		$Consulta.= " and fecha_produccion between '".$Fecha1."' and '".$Fecha2."'";
		$Consulta.= " group by cod_producto,cod_subproducto"; 
		$RespAux = mysqli_query($link, $Consulta);
		while ($FilaAux = mysqli_fetch_array($RespAux))
		{					
			$PesoQuincena = $FilaAux["peso_paquetes"];
			$PesoMes = $PesoMes + $PesoQuincena;
			//-------------------------LEYES DE CALIDAD-----------------------------
			$Consulta = "select t2.cod_leyes, t2.valor, t1.fecha_muestra, ";
			$Consulta.= " t2.signo, t1.nro_solicitud, t3.abreviatura ";
			$Consulta.= " from cal_web.solicitud_analisis t1 inner join ";
			$Consulta.= " cal_web.leyes_por_solicitud  t2 on t1.nro_solicitud = t2.nro_solicitud ";
			$Consulta.= " and t1.fecha_hora = t2.fecha_hora and t1.rut_funcionario = t2.rut_funcionario and t1.recargo = t2.recargo ";
			$Consulta.= " inner join proyecto_modernizacion.leyes t3 on t2.cod_leyes = t3.cod_leyes";				
			$Consulta.= " where t1.fecha_muestra between '".$Fecha1." 00:00:00' and '".$Fecha2." 23:59:59'";
			$Consulta.= " and t1.estado_actual <> '16' and t1.estado_actual <> '7'";
			$Consulta.= " and t1.frx <> 'S' and t1.cod_analisis = '1'";
			$Consulta.= " and t1.cod_periodo = '5'";			
			$Consulta.= " and t1.cod_producto = '18' and t1.cod_subproducto = '4'";
			$Consulta.= " and (t2.cod_leyes = '02' or t2.cod_leyes = '04' or t2.cod_leyes = '05')";
			$Consulta.= " order by t1.fecha_muestra desc, t1.nro_solicitud, t2.cod_leyes ";
			$RespAux2 = mysqli_query($link, $Consulta);
			$Encontro = "N";								
			while ($FilaAux2 = mysqli_fetch_array($RespAux2))
			{
				$Encontro = "S";
				switch ($FilaAux2["cod_leyes"])
				{
					case "02":
						$FinoCu = $FinoCu + ($PesoQuincena * $FilaAux2["valor"]);
						break;
					case "04":
						$FinoAg = $FinoAg + ($PesoQuincena * $FilaAux2["valor"]);
						break;
					case "05":
						$FinoAu = $FinoAu + ($PesoQuincena * $FilaAux2["valor"]);
						break;
				}						
			}
			if ($Encontro == "N")
			{
				$Mensaje.= "Faltan Leyes de Catodos Descobrizacion Parcial de la ";
				$Mensaje.= " Quincena del  ".$Fecha1." al ".$Fecha2."<br>";
			}
			//------------------------------------------------------------------------
		}	
	}
	if ($FinoCu > 0 && $PesoMes > 0)
		$FinoCu = $FinoCu / $PesoMes;
	if ($FinoAg > 0 && $PesoMes > 0)
		$FinoAg = $FinoAg / $PesoMes;
	if ($FinoAu > 0 && $PesoMes > 0)
		$FinoAu = $FinoAu / $PesoMes;
	//INSERTA LEYES CAT. DESC. PARCIAL
	$Insertar = "INSERT INTO sec_web.leyes_anexo ";
	$Insertar.= " (ano, mes, cod_producto, cod_subproducto, serie, peso, cu, ag, au) ";
	$Insertar.= " VALUES ('".$AnoConsulta."', '".$MesConsulta."', '18', '4', '".$Letra."', '".$PesoMes."', '".$FinoCu."', '".$FinoAg."', '".$FinoAu."')";
	mysqli_query($link, $Insertar);
	
	return $Mensaje;
}

function CalculaLeyesEW($Letra, $AnoConsulta, $MesConsulta)
{	
	$Mensaje = "";
	$LeyAg = 0;
	$LeyAu = 0;
	$FechaInicio = $AnoConsulta."-".$MesConsulta."-01";
	$FechaTermino = $AnoConsulta."-".$MesConsulta."-31";
	//-------LEYES DE CALIDAD MENSUAL DE Ag, Au -----------------------------
	$Consulta = "select t2.cod_leyes, t2.valor, t1.fecha_muestra, ";
	$Consulta.= " t2.signo, t1.nro_solicitud, t3.abreviatura ";
	$Consulta.= " from cal_web.solicitud_analisis t1 inner join ";
	$Consulta.= " cal_web.leyes_por_solicitud  t2 on t1.nro_solicitud = t2.nro_solicitud ";
	$Consulta.= " and t1.fecha_hora = t2.fecha_hora and t1.rut_funcionario = t2.rut_funcionario and t1.recargo = t2.recargo ";
	$Consulta.= " inner join proyecto_modernizacion.leyes t3 on t2.cod_leyes = t3.cod_leyes";				
	$Consulta.= " where t1.fecha_muestra between '".$FechaInicio." 00:00:00' and '".$FechaTermino." 23:59:59'";
	$Consulta.= " and t1.estado_actual <> '16' and t1.estado_actual <> '7'";
	$Consulta.= " and t1.frx <> 'S' and t1.cod_analisis = '1'";
	$Consulta.= " and t1.cod_periodo = '3'";			
	//$Consulta.= " and ((t1.tipo = 1 and (t1.id_muestra = '".$Fila3["cod_grupo"]."' or t1.id_muestra = '".intval($Fila3["cod_grupo"])."')) ";			
	$Consulta.= " and t1.cod_producto = '18' and t1.cod_subproducto = '5'";
	$Consulta.= " and (t2.cod_leyes = '04' or t2.cod_leyes = '05')";
	$Consulta.= " order by t1.fecha_muestra desc, t1.nro_solicitud, t2.cod_leyes ";
	$RespAux2 = mysqli_query($link, $Consulta);
	$Encontro = "N";								
	while ($FilaAux2 = mysqli_fetch_array($RespAux2))
	{
		$Encontro = "S";
		switch ($FilaAux2["cod_leyes"])
		{				
			case "04":
				$LeyAg = $FilaAux2["valor"];
				break;
			case "05":
				$LeyAu = $FilaAux2["valor"];
				break;
		}						
	}
	if ($Encontro == "N")
	{
		$Mensaje.= "Faltan Leyes Mensuales de Ag y Au de Catodos Electrowining del Mes ".$MesConsulta."<br>";
	}
	//---------------------------------------------------------------------	
	$Consulta = "select sum(peso_produccion) as peso_paquetes, fecha_produccion as fecha_creacion_paquete  ";
	$Consulta.= " from sec_web.produccion_catodo ";
	$Consulta.= " where cod_producto='18'";
	$Consulta.= " and cod_subproducto ='5' ";
	//$Consulta.= " and cod_paquete='".$Letra."' ";
	//$Consulta.= " and year(fecha_creacion_paquete)=".$AnoConsulta;
	$Consulta.= " and fecha_produccion between '".$FechaInicio."' and '".$FechaTermino."'";
	$Consulta.= " group by fecha_produccion"; 		
	$Consulta.= " order by fecha_produccion"; 	
	$RespAux = mysqli_query($link, $Consulta);
	$FinoCu = 0;
	while ($FilaAux = mysqli_fetch_array($RespAux))
	{					
		$PesoPaquete = $FilaAux["peso_paquetes"];
		$PesoMes = $PesoMes + $PesoPaquete;
		$Fecha1 = date("Y-m-d",mktime(0,0,0,substr($FilaAux["fecha_creacion_paquete"],5,2),(substr($FilaAux["fecha_creacion_paquete"],8,2)-1),substr($FilaAux["fecha_creacion_paquete"],0,4)));
		$Fecha2 = date("Y-m-d",mktime(0,0,0,substr($FilaAux["fecha_creacion_paquete"],5,2),(substr($FilaAux["fecha_creacion_paquete"],8,2)+1),substr($FilaAux["fecha_creacion_paquete"],0,4)));				
		//-------LEYES DE CALIDAD DIARIAS DE Cu -----------------------------
		$Consulta = "select t2.cod_leyes, t2.valor, t1.fecha_muestra, ";
		$Consulta.= " t2.signo, t1.nro_solicitud, t3.abreviatura ";
		$Consulta.= " from cal_web.solicitud_analisis t1 inner join ";
		$Consulta.= " cal_web.leyes_por_solicitud  t2 on t1.nro_solicitud = t2.nro_solicitud ";
		$Consulta.= " and t1.fecha_hora = t2.fecha_hora and t1.rut_funcionario = t2.rut_funcionario and t1.recargo = t2.recargo ";
		$Consulta.= " inner join proyecto_modernizacion.leyes t3 on t2.cod_leyes = t3.cod_leyes";				
		$Consulta.= " where t1.fecha_muestra between '".$Fecha1." 00:00:00' and '".$Fecha2." 23:59:59'";
		$Consulta.= " and t1.estado_actual <> '16' and t1.estado_actual <> '7'";
		$Consulta.= " and t1.frx <> 'S' and t1.cod_analisis = '1'";
		$Consulta.= " and t1.cod_periodo = '1'";			
		$Consulta.= " and t1.cod_producto = '18' and t1.cod_subproducto = '5'";
		$Consulta.= " and t2.cod_leyes = '02'";
		$Consulta.= " order by t1.fecha_muestra desc, t1.nro_solicitud, t2.cod_leyes ";
		$RespAux2 = mysqli_query($link, $Consulta);
		$Encontro = "N";								
		while ($FilaAux2 = mysqli_fetch_array($RespAux2))
		{
			$Encontro = "S";
			switch ($FilaAux2["cod_leyes"])
			{
				case "02":
					$FinoCu = $FinoCu + ($PesoPaquete * $FilaAux2["valor"]);
					break;						
			}									
		}
		if ($Encontro == "N")
		{
			$Mensaje = "Falta Ley Diario de Cu de Catodos Electrowining de la fecha de Produccion  ".$FilaAux["fecha_creacion_paquete"]."<br>";
		}		
		//------------------------------------------------------------------------
	}
	if ($FinoCu > 0 && $PesoMes > 0)
		$FinoCu = $FinoCu / $PesoMes;
	//INSERTA LEYES CAT. DESC. PARCIAL
	$Insertar = "INSERT INTO sec_web.leyes_anexo ";
	$Insertar.= " (ano, mes, cod_producto, cod_subproducto, serie, peso, cu, ag, au) ";
	$Insertar.= " VALUES ('".$AnoConsulta."', '".$MesConsulta."', '18', '5', '".$Letra."', '".$PesoMes."', '".$FinoCu."', '".$LeyAg."', '".$LeyAu."')";
	mysqli_query($link, $Insertar);
	
	return $Mensaje;
}

function CalculaLeyesExternos($Letra, $AnoConsulta, $MesConsulta)
{
	$Mensaje = "";
	for ($i=1; $i<=5; $i++)
	{
		switch ($i)
		{
			case 1:
				$SubProducto = 6;				
				break;
			case 2:
				$SubProducto = 8;				
				break;
			case 3:
				$SubProducto = 9;				
				break;			
			case 4:
				$SubProducto = 10;				
				break;			
			case 5:
				$SubProducto = 12;				
				break;						
		}		
		$Consulta = "select sum(t1.peso_paquete) as peso_externos, t1.lote_origen, t2.descripcion";
		$Consulta.= " from sec_web.paquete_catodo_externo t1 inner join proyecto_modernizacion.subproducto t2";
		$Consulta.= " on t1.cod_producto = t2.cod_producto and t1.cod_subproducto = t2.cod_subproducto";
		$Consulta.= " where year(t1.fecha_creacion_paquete) = '".$AnoConsulta."'";
		$Consulta.= " and t1.cod_paquete = '".$Letra."'";
		$Consulta.= " and t1.cod_producto = '18' and t1.cod_subproducto = '".$SubProducto."'";
		$Consulta.= " group by t1.lote_origen";
		$Consulta.= " order by t1.lote_origen";
		$RespAux = mysqli_query($link, $Consulta);
		$FinoCu = 0;
		$FinoAg = 0;
		$FinoAu = 0;
		$PesoTotal = 0;
		while ($FilaAux = mysqli_fetch_array($RespAux))
		{					
			$PesoLote = $FilaAux["peso_externos"];
			$PesoTotal = $PesoTotal + $PesoLote;
			//-------------------------LEYES DE CALIDAD-----------------------------
			$Consulta = "select t2.cod_leyes, t2.valor, t1.fecha_muestra, ";
			$Consulta.= " t2.signo, t1.nro_solicitud, t3.abreviatura ";
			$Consulta.= " from cal_web.solicitud_analisis t1 inner join ";
			$Consulta.= " cal_web.leyes_por_solicitud  t2 on t1.nro_solicitud = t2.nro_solicitud ";
			$Consulta.= " and t1.fecha_hora = t2.fecha_hora and t1.rut_funcionario = t2.rut_funcionario and t1.recargo = t2.recargo ";
			$Consulta.= " inner join proyecto_modernizacion.leyes t3 on t2.cod_leyes = t3.cod_leyes";
			$Consulta.= " where t1.tipo = 1 and t1.id_muestra = '".$FilaAux["lote_origen"]."'";			
			$Consulta.= " and t1.estado_actual <> '16' and t1.estado_actual <> '7'";
			$Consulta.= " and t1.frx <> 'S' and t1.cod_analisis = '1'";
			$Consulta.= " and ((t1.cod_producto = '18' and t1.cod_subproducto = '".$SubProducto."') or (t1.cod_producto = '16')) ";
			$Consulta.= " order by t1.fecha_muestra desc, t1.nro_solicitud, t2.cod_leyes ";
			$RespAux2 = mysqli_query($link, $Consulta);
			$Encontro = "N";								
			while ($FilaAux2 = mysqli_fetch_array($RespAux2))
			{
				$Encontro = "S";
				switch ($FilaAux2["cod_leyes"])
				{
					case "02":
						$FinoCu = $FinoCu + ($PesoLote * $FilaAux2["valor"]);
						break;
					case "04":
						$FinoAg = $FinoAg + ($PesoLote * $FilaAux2["valor"]);
						break;
					case "05":
						$FinoAu = $FinoAu + ($PesoLote * $FilaAux2["valor"]);
						break;
				}						
			}
			if ($Encontro == "N")
			{
				$Mensaje.= "Faltan Leyes del Lote Externo: ".$FilaAux["cod_bulto"]."-".$FilaAux["num_bulto"]." ";
				$Mensaje.= ", Lote Origen: ".$FilaAux["lote_origen"]."<br>";
			}
			//------------------------------------------------------------------------
		}
		if ($FinoCu > 0 && $PesoTotal > 0)
			$FinoCu = $FinoCu / $PesoTotal;
		if ($FinoAg > 0 && $PesoTotal > 0)
			$FinoAg = $FinoAg / $PesoTotal;
		if ($FinoAu > 0 && $PesoTotal > 0)
			$FinoAu = $FinoAu / $PesoTotal;
		//INSERTA LEYES CAT. EXTERNOS
		$Insertar = "INSERT INTO sec_web.leyes_anexo ";
		$Insertar.= " (ano, mes, cod_producto, cod_subproducto, serie, peso, cu, ag, au) ";
		$Insertar.= " VALUES ('".$AnoConsulta."', '".$MesConsulta."', '18', '".$SubProducto."', '".$Letra."', '".$PesoTotal."', '".$FinoCu."', '".$FinoAg."', '".$FinoAu."')";
		mysqli_query($link, $Insertar);
	}
	
	return $Mensaje;			
}

function RescataFinos($AnoActual,$MesActual,$Ano,$Mes,$TipoMov,$Producto,$SubProducto,$Flujo,$PesoFlujo,$FinoCu,$FinoAg,$FinoAu)
{		
	if (($Producto == 18 && ($SubProducto == 1 || $SubProducto == 2 || $SubProducto == 3 || $SubProducto == 40 
		|| $SubProducto == 42 || $SubProducto == 43 || $SubProducto == 44)) || ($Producto == 48))
	{
		$ProductoCons = 18;
		$SubProductoCons = 1;
	}
	else
	{
		$ProductoCons = $Producto;
		$SubProductoCons = $SubProducto;
	}
	$Consulta = "select * from sec_web.leyes_anexo ";
	$Consulta.= " where ano = '".$Ano."'";
	$Consulta.= " and mes = '".$Mes."'";
	$Consulta.= " and cod_producto = '".$ProductoCons."'";
	$Consulta.= " and cod_subproducto = '".$SubProductoCons."'";
	$RespAux = mysqli_query($link, $Consulta);
	$Encontro = false;
	while ($FilaAux = mysqli_fetch_array($RespAux))
	{
		$Encontro = true;
		$FinoCu = $FinoCu + (($FilaAux["cu"] * $PesoFlujo));
		$FinoAg = $FinoAg + (($FilaAux["ag"] * $PesoFlujo));
		$FinoAu = $FinoAu + (($FilaAux["au"] * $PesoFlujo));
	}			
	if (!$Encontro)
	{
		$Consulta = "select * from sec_web.leyes_anexo ";
		$Consulta.= " where ano = '".$Ano."'";
		$Consulta.= " and mes = '".$Mes."'";
		$Consulta.= " and cod_producto = '".$Producto."'";
		$Consulta.= " and cod_subproducto = '".$SubProducto."'";
		$RespAux = mysqli_query($link, $Consulta);
		while ($FilaAux = mysqli_fetch_array($RespAux))
		{
			$FinoCu = $FinoCu + (($FilaAux["cu"] * $PesoFlujo));
			$FinoAg = $FinoAg + (($FilaAux["ag"] * $PesoFlujo));
			$FinoAu = $FinoAu + (($FilaAux["au"] * $PesoFlujo));
		}
	}	
}

function RescataLeyesPorSerie($Letra, $AnoConsulta, $MesConsulta)
{
	$FechaInicio = $AnoConsulta."-".$MesConsulta."-01";
	$FechaTermino = $AnoConsulta."-".$MesConsulta."-31";
	for ($i=1;$i<=2;$i++)
	{
		if ($i==1)
		{
			$TipoMovimiento = 2;	
			$Consulta = "select distinct t2.cod_producto, t2.cod_subproducto, year(t2.fecha_creacion_paquete) as ano, cod_paquete as serie";
			$Consulta.= " from sec_web.guia_despacho_emb t1 inner join sec_web.paquete_catodo t2  ";
			$Consulta.= " on t1.num_guia=t2.num_guia ";
			$Consulta.= " where (t1.cod_estado <>'A') ";
			$Consulta.= " and (t1.fecha_guia between '".$FechaInicio."' and '".$FechaTermino."')";
			$Consulta.= " and (t2.cod_estado = 'c') ";
			$Consulta.= " group by  t2.cod_producto, t2.cod_subproducto, ano, serie";
			$Consulta.= " order by  ano, serie, t2.cod_producto, t2.cod_subproducto";
		}
		else
		{
			$TipoMovimiento = 3;
			$Consulta = "select t2.cod_producto, t2.cod_subproducto, year(t2.fecha_creacion_lote) as ano, t2.cod_bulto as serie";
			$Consulta.= " from sea_web.movimientos t1 inner join sec_web.traspaso t2";
			$Consulta.= " on t1.hornada = t2.hornada";
			$Consulta.= "  where t1.tipo_movimiento = '4'";
			$Consulta.= "  and t1.fecha_movimiento ";
			$Consulta.= "  between '".$FechaInicio."' and '".$FechaTermino."'";
			$Consulta.= "  group by t1.cod_producto,t1.cod_subproducto, serie"; 
		}
		$RespAux = mysqli_query($link, $Consulta);
		while ($FilaAux = mysqli_fetch_array($RespAux))
		{
			if ($FilaAux["serie"] == $Letra && $FilaAux["ano"] == $AnoConsulta)
			{
				//MES ACTUAL, LAS LEYES YA ESTAN
			}
			else
			{
				$FinoCu = 0;
				$FinoAg = 0;
				$FinoAu = 0;
				$Consulta = "select * from proyecto_modernizacion.sub_clase ";
				$Consulta.= " where cod_clase=3004 and nombre_subclase = '".$FilaAux["serie"]."'";
				$RespAux2 = mysqli_query($link, $Consulta);
				if ($FilaAux2 = mysqli_fetch_array($RespAux2))
				{
					$MesAux = $FilaAux2["cod_subclase"];
				}
				$FechaCons = $FilaAux["ano"]."-".$MesAux."-01";
				$Consulta = "select * from sec_web.relacion_flujo ";
				$Consulta.= " where tipo_mov = '".$TipoMovimiento."'";
				$Consulta.= " and cod_producto = '".$FilaAux["cod_producto"]."'";
				$Consulta.= " and cod_subproducto = '".$FilaAux["cod_subproducto"]."'";
				$RespAux2 = mysqli_query($link, $Consulta);								
				while ($FilaAux2 = mysqli_fetch_array($RespAux2))
				{
					$Consulta = "select * from sec_web.flujos_mes ";	
					$Consulta.= " where ano = '".$AnoConsulta."'";
					$Consulta.= " and mes = '".$MesAux."'";
					$Consulta.= " and flujo = '".$FilaAux2["flujo"]."'";
					$RespAux3 = mysqli_query($link, $Consulta);
					$Encontro = false;
					while ($FilaAux3 = mysqli_fetch_array($RespAux3))
					{
						$Encontro = true;								
						$FinoCu = ($FilaAux3["fino_cu"] / $FilaAux3["peso"]) * 100;								
						$FinoAg = ($FilaAux3["fino_ag"] / $FilaAux3["peso"]) * 1000;								
						$FinoAu = ($FilaAux3["fino_au"] / $FilaAux3["peso"]) * 1000;
					}
					if ($Encontro == false)
					{
						//APLICA LEYES DEL MES ANTERIOR
						$MesConsAux = date("m", mktime(0,0,0,$MesConsulta - 1,1,$AnoConsulta));
						$Consulta = "select * FROM sec_web.flujos_mes ";	
						$Consulta.= " where ano = '".$AnoConsulta."'";
						$Consulta.= " and mes = '".$MesConsAux."'";
						$Consulta.= " and flujo = '".$FilaAux2["flujo"]."'";
						$RespAux3 = mysqli_query($link, $Consulta);
						while ($FilaAux3 = mysqli_fetch_array($RespAux3))
						{			
							$FinoCu = ($FilaAux3["fino_cu"] / $FilaAux3["peso"]) * 100;								
							$FinoAg = ($FilaAux3["fino_ag"] / $FilaAux3["peso"]) * 1000;								
							$FinoAu = ($FilaAux3["fino_au"] / $FilaAux3["peso"]) * 1000;			
						}
					}		
				}				
				//INSERTA LEYES DE SERIES ANTERIORES
				$Consulta = "select * from sec_web.leyes_anexo ";
				$Consulta.= " where ano = '".$FilaAux["ano"]."'";
				$Consulta.= " and mes = '".$MesAux."'";
				$Consulta.= " and cod_producto = '".$FilaAux["cod_producto"]."'";
				$Consulta.= " and cod_subproducto = '".$FilaAux["cod_subproducto"]."'";
				$Consulta.= " and serie = '".$FilaAux["serie"]."'";
				$RespAux3 = mysqli_query($link, $Consulta);
				$Encontro = false;
				if ($FilaAux3 = mysqli_fetch_array($RespAux3))
				{
					$Encontro = true;
				}
				if (!$Encontro)
				{
					$Insertar = "INSERT INTO sec_web.leyes_anexo ";
					$Insertar.= " (ano, mes, cod_producto, cod_subproducto, serie, peso, cu, ag, au) ";
					$Insertar.= " VALUES ('".$FilaAux["ano"]."', '".$MesAux."', '".$FilaAux["cod_producto"]."',";
					$Insertar.= "'".$FilaAux["cod_subproducto"]."', '".$FilaAux["serie"]."', '', '".$FinoCu."', '".$FinoAg."', '".$FinoAu."')";
					mysqli_query($link, $Insertar);
				}
			}
		}
	}	
}

function VentanaAlerta($Mensaje, $Left, $Top)
{
		echo "<div id='postit' style='left:".$Left."px;top:".$Top."px'>\n";
		echo "<div align='center'><font color='#FFFFFF'><b>".$Mensaje."</b></font><br><br>";		
		echo "&nbsp;&nbsp;<a href='JavaScript:closeit();'><font color='#FFFFFF'><b>CERRAR</b></font></a>\n";
		echo "</font></div>";
		echo "</div>";
echo "<script>\n";
	//
	echo "var once_per_browser=0\n";
	//
	///No modifiques lo que sigue///
	//
	echo "var ns4=document.layers\n";
	echo "var ie4=document.all\n";
	echo "var ns6=document.getElementById&&!document.all\n";
	//
	echo "if (ns4)\n";
	echo "crossobj=document.layers.postit\n";
	echo "else if (ie4||ns6)\n";
	echo "crossobj=ns6? document.getElementById('postit') : document.all.postit\n";
	//
	//
	echo "function closeit(){\n";
	echo "if (ie4||ns6)\n";
	echo "crossobj.style.visibility='hidden'\n";
	echo "else if (ns4)\n";
	echo "crossobj.visibility='hide'\n";
	echo "}\n";
	//
	echo "function get_cookie4(Name) {\n";
	  echo "var search = Name + '='\n";
	  echo "var returnvalue = '';\n";
	  echo "if (document.cookie4.length > 0) {\n";
		echo "offset = document.cookie4.indexOf(search)\n";
		echo "if (offset != -1) {\n"; // if cookie4 exists
		  echo "offset += search.length\n";
		  // set index of beginning of value
		  echo "end = document.cookie4.indexOf(';', offset);\n";
		  // set index of end of cookie4 value
		  echo "if (end == -1)\n";
			 echo "end = document.cookie4.length;\n";
		  echo "returnvalue=unescape(document.cookie4.substring(offset, end))\n";
		  echo "}\n";
	   echo "}\n";
	  echo "return returnvalue;\n";
	echo "}\n";
	//
	echo "function showornot(){\n";
	echo "if (get_cookie4('postdisplay')==''){\n";
	echo "showit()\n";
	echo "document.cookie4='postdisplay=yes'\n";
	echo "}\n";
	echo "}\n";
	//
	echo "function showit(){\n";
	echo "if (ie4||ns6)\n";
	echo "crossobj.style.visibility='visible'\n";
	echo "else if (ns4)\n";
	echo "crossobj.visibility='show'\n";
	echo "}\n";
	//
	echo "if (once_per_browser)\n";
	echo "showornot()\n";
	echo "else\n";
	echo "showit()\n";
	//
	echo "</script>\n";
	//
	echo "<script language='JavaScript1.2'>\n";
	//
	//función arrastrar y soltar para ie4+ y NS6////
	echo "function drag_drop(e){\n";
	echo "if (ie4&&dragapproved){\n";
	echo "crossobj.style.left=tempx+event.clientX-offsetx\n";
	echo "crossobj.style.top=tempy+event.clientY-offsety\n";
	echo "return false\n";
	echo "}\n";
	echo "else if (ns6&&dragapproved){\n";
	echo "crossobj.style.left=tempx+e.clientX-offsetx\n";
	echo "crossobj.style.top=tempy+e.clientY-offsety\n";
	echo "return false\n";
	echo "}\n";
	echo "}\n";
	//
	echo "function initializedrag(e){\n";
	echo "if (ie4&&event.srcElement.id=='postit'||ns6&&e.target.id=='postit'){\n";
	echo "offsetx=ie4? event.clientX : e.clientX\n";
	echo "offsety=ie4? event.clientY : e.clientY\n";
	//
	echo "tempx=parseInt(crossobj.style.left)\n";
	echo "tempy=parseInt(crossobj.style.top)\n";
	//
	echo "dragapproved=true\n";
	echo "document.onmousemove=drag_drop\n";
	echo "}\n";
	echo "}\n";
	echo "document.onmousedown=initializedrag\n";
	echo "document.onmouseup=new Function('dragapproved=false')\n";
	// \n";
	echo "</script>\n";
	// FIN DEL SCRIPT\n";
}
?>