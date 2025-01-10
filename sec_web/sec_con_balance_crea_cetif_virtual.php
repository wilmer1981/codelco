<?php
function CertifVirtual($Mes, $Lote, $Ano,$link)
{	
	$DiasMenos=3;
	$DiasMas=4;
	//if($CodProducto==18 && $CodSubProducto==57)
	//{							
		$Consulta="select * from proyecto_modernizacion.sub_clase where cod_clase='3111' and  cod_subclase='1' ";
		$Respuesta = mysqli_query($link,$Consulta);
		if ($Fila = mysqli_fetch_array($Respuesta))
		{
			$DiasMenos=$Fila["valor_subclase1"];
		}
		$Consulta="select * from proyecto_modernizacion.sub_clase where cod_clase='3111' and  cod_subclase='2' ";
		$Respuesta = mysqli_query($link,$Consulta);
		if ($Fila = mysqli_fetch_array($Respuesta))
		{
			$DiasMas=$Fila["valor_subclase1"];
		}

	//}
	include("../principal/conectar_principal.php");
	$FechaActual = date("Y-m-d H:i:s");
	
	//TABLA PAQUETE_CATODO
	$Consulta = "select distinct t2.cod_producto, t2.cod_subproducto,t1.fecha_creacion_lote";
	$Consulta.= " from sec_web.lote_catodo t1	inner join";
	$Consulta.= " sec_web.paquete_catodo t2 on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete";
	$Consulta.= " where t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and  t1.cod_bulto = '".$Mes."'";
	$Consulta.= " and t1.num_bulto = '".$Lote."' and year(t1.fecha_creacion_lote) = '".$Ano."'";
	$Consulta.= " order by t2.cod_producto, t2.cod_subproducto";	
	//echo "CERTIFC ".$Consulta."<br>";
	$Respuesta = mysqli_query($link,$Consulta);
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		$FechaLote   = $Fila["fecha_creacion_lote"];
		$CodProducto = $Fila["cod_producto"];
		$CodSubProducto = $Fila["cod_subproducto"];
	}	
	$Error = "";
	$ArrProd = array();
	if ($Lote!="")
	{
		$Eliminar = "delete from sec_web.tmp_leyes_grupos";
		mysqli_query($link,$Eliminar);
		if ($CodProducto == "18" && ($CodSubProducto == "3" || $CodSubProducto == "42" || $CodSubProducto == "43" || $CodSubProducto == "44"))  
		{
			//PARA DESCOBRIZADOS
			//TABLA PAQUETE_CATODO
			$Consulta = "select distinct ifnull(t1.grupo,'00') as cod_grupo, t1.fecha_produccion, peso_produccion ";
			$Consulta.= " from sec_web.catodos_desc_normal t1";
			$Consulta.= " where t1.cod_bulto = '".$Mes."'";
			$Consulta.= " and t1.num_bulto = '".$Lote."'";
			$Consulta.= " order by t1.fecha_produccion, t1.grupo ";
			$Respuesta = mysqli_query($link,$Consulta);
			//echo $Consulta."<br>";
			if($Fila = mysqli_fetch_array($Respuesta))
			//while ($Fila = mysqli_fetch_array($Respuesta))
			{
				$Consulta = "select * from sec_web.produccion_catodo ";
				$Consulta.= " where cod_grupo = '".$Fila["cod_grupo"]."'";
				$Consulta.= " and fecha_produccion = '".$Fila["fecha_produccion"]."'";
				$Consulta.= " and cod_muestra <> 'S' "; 
				$Consulta.= " and cod_producto = '18' "; 
				$Consulta.= " and cod_subproducto in (3,42,43,44) "; 
				$Consulta.= " order by fecha_produccion, cod_grupo, cod_cuba ";
				$Respuesta2 = mysqli_query($link,$Consulta);
				//echo $Consulta."<br>";
				while ($Fila2 = mysqli_fetch_array($Respuesta2))
				{					
					$Consulta = " SELECT t2.nro_solicitud,t2.cod_leyes, t2.valor, t2.signo, t2.cod_unidad, t1.estado_actual from cal_web.solicitud_analisis as t1";
					$Consulta.= " INNER JOIN cal_web.leyes_por_solicitud AS t2"; 
					$Consulta.= " ON t1.nro_solicitud = t2.nro_solicitud ";
					$Consulta.= " AND t1.fecha_hora = t2.fecha_hora ";
					$Consulta.= " AND t1.rut_funcionario = t2.rut_funcionario ";
					$Consulta.= " AND t1.id_muestra = t2.id_muestra ";
					$Consulta.= " AND t1.recargo = t2.recargo ";
					$Consulta.= " AND left(t2.id_muestra,5) like '%".intval($Fila2["cod_grupo"])."%'";
					$Consulta.= " WHERE t1.cod_producto = 18 AND left(t1.fecha_muestra,10) = '".$Fila2["fecha_produccion"]."'";
					$Consulta.= " AND left(t1.id_muestra,5) like '%".intval($Fila2["cod_grupo"])."%' AND right(t1.id_muestra,2) like '%".intval($Fila2["cod_cuba"])."%'";
					$Consulta.= " AND t2.valor != '' "; //AND t2.cod_leyes != 48";
					$Consulta.= " AND t1.cod_periodo='1' ";
					$Consulta.= " AND t1.tipo='1' ";
					$Consulta.= " AND t1.cod_analisis='1' ";
					$Consulta.= " AND t1.estado_actual <> '7'";	
					$Respuesta3 = mysqli_query($link,$Consulta);
					while($Fila3 = mysqli_fetch_array($Respuesta3))
					{
						//echo "Nro. SA = ".$Fila3["nro_solicitud"]." LEY = ".$Fila3["cod_leyes"]." VALOR = ".$Fila3["valor"]."<br>";
						$Insertar = "insert into sec_web.tmp_leyes_grupos (cod_grupo, fecha, cod_leyes, valor, signo, ";
						$Insertar.= " fecha_creacion_paquete, nro_solicitud, cod_cuba, peso_produccion) ";
						$Insertar.= " values('".$Fila["cod_grupo"]."','".$Fila["fecha_produccion"]."','".$Fila3["cod_leyes"]."','".$Fila3["valor"]."', ";
						$Insertar.= " '".$Fila3["signo"]."', '".$Fila["fecha_produccion"]."', '".$Fila3["nro_solicitud"]."', '".$Fila2["cod_cuba"]."', '".$Fila["peso_produccion"]."')";
						mysqli_query($link,$Insertar);
					//	echo "<br>LEYES GRUPO AAAAA ".$Insertar."<br>";
						
						
					}
				}								
			}
		}
		else
		{
			if ($CodProducto == "18" && $CodSubProducto == "4")//DESC. PARCIAL
			{
				$Consulta = "select distinct ifnull(t2.cod_grupo,'00') as cod_grupo, t2.fecha_creacion_paquete ";
				$Consulta.= " from sec_web.lote_catodo t1	inner join";
				$Consulta.= " sec_web.paquete_catodo t2 on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete";
				$Consulta.= " where t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and t1.cod_bulto = '".$Mes."'";
				$Consulta.= " and t1.num_bulto = '".$Lote."'";
				$Consulta.= " order by t2.cod_grupo";
				//echo $Consulta."<br>";
				$Respuesta = mysqli_query($link,$Consulta);
				$i = 0;
				while ($Fila = mysqli_fetch_array($Respuesta))
				{			
					$Consulta = "select max(fecha_produccion) as fecha_produccion";
					$Consulta.= " from sec_web.produccion_catodo ";
					$Consulta.= " where cod_grupo = '".$Fila["cod_grupo"]."'";
					$Consulta.= " and fecha_produccion <= '".$Fila["fecha_creacion_paquete"]."'";
					$Respuesta2 = mysqli_query($link,$Consulta);
					if ($Fila2 = mysqli_fetch_array($Respuesta2))
					{
						$ArrProd[$i][0] = $Fila["cod_grupo"];
						if ($Fila2["fecha_produccion"] == "" || is_null($Fila2["fecha_produccion"]))
							$ArrProd[$i][1] = $Fila["fecha_creacion_paquete"];
						else
							$ArrProd[$i][1] = $Fila2["fecha_produccion"];
						$ArrProd[$i][2] = $Fila["fecha_creacion_paquete"];
						$i++;
						//echo $Fila["cod_grupo"]."  ".$Fila2["fecha_produccion"]."  ". $Fila["fecha_creacion_paquete"]."<br>";
					}
				}
				reset($ArrProd);
				$SeriePaquetes = "";
				$CodPaqueteAnt = "";
				$NumPaqueteAnt = 0;
				$i = 0;
				foreach($ArrProd as $k=>$v)
				{	
					$DiaAux = intval(substr($v[2],8,2));
					if ($DiaAux >=1 && $DiaAux <= 15)
					{
						$Fecha1 = substr($v[2],0,4)."-".substr($v[2],5,2)."-01";
						$Fecha2 = substr($v[2],0,4)."-".substr($v[2],5,2)."-15";
					}
					else
					{
						if ($DiaAux >=16 && $DiaAux <= 31)
						{
							$Fecha1 = substr($v[2],0,4)."-".substr($v[2],5,2)."-16";
							$Fecha2 = substr($v[2],0,4)."-".substr($v[2],5,2)."-31";
						}
					}
					$Consulta = "select max(t1.fecha_muestra) as fecha_muestra";
					$Consulta.= " from cal_web.solicitud_analisis t1 inner join ";
					$Consulta.= " cal_web.leyes_por_solicitud  t2 on t1.nro_solicitud = t2.nro_solicitud ";
					$Consulta.= " and t1.fecha_hora = t2.fecha_hora and t1.rut_funcionario = t2.rut_funcionario and t1.recargo = t2.recargo ";						
					$Consulta.= " where t1.cod_periodo = '5'";
					$Consulta.= " and t1.fecha_muestra between '".$Fecha1." 00:00:00' and '".$Fecha2." 23:59:59' ";
					$Consulta.= " and t1.estado_actual <> '16' and t1.estado_actual <> '7'";
					$Consulta.= " and t1.frx <> 'S' and t1.cod_analisis = '1' and t1.tipo = 1";
					$Consulta.= " and t1.cod_producto = '18' and t1.cod_subproducto = '4'";
					$Consulta.= " order by t1.fecha_muestra desc, t1.nro_solicitud, t2.cod_leyes ";
					$Respuesta2 = mysqli_query($link,$Consulta);
					$Fila2 = mysqli_fetch_array($Respuesta2);
					$FechaAux = $Fila2["fecha_muestra"];
					//echo $Consulta."<br>";
					//-------------------------LEYES DE CALIDAD-----------------------------
					$Consulta = "select t2.cod_leyes, t2.valor, t1.fecha_muestra, ";
					$Consulta.= " t2.signo, t1.nro_solicitud ";
					$Consulta.= " from cal_web.solicitud_analisis t1 inner join ";
					$Consulta.= " cal_web.leyes_por_solicitud  t2 on t1.nro_solicitud = t2.nro_solicitud ";
					$Consulta.= " and t1.fecha_hora = t2.fecha_hora and t1.rut_funcionario = t2.rut_funcionario and t1.recargo = t2.recargo ";						
					$Consulta.= " where t1.cod_periodo = '5'";
					$Consulta.= " and t1.fecha_muestra = '".$FechaAux."'";
					$Consulta.= " and t1.estado_actual <> '16' and t1.estado_actual <> '7'";
					$Consulta.= " and t1.frx <> 'S' and t1.cod_analisis = '1' and t1.tipo = 1";
					$Consulta.= " and t1.cod_producto = '18' and t1.cod_subproducto = '4'";
					$Consulta.= " order by t1.fecha_muestra desc, t1.nro_solicitud, t2.cod_leyes ";
					//echo $Consulta."<br>";
					$Respuesta2 = mysqli_query($link,$Consulta);
					$Encontro = false;
					while ($Fila2 = mysqli_fetch_array($Respuesta2))
					{
						$Encontro = true;
						$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase = '3009' ";
						$Consulta.= " and nombre_subclase = '".$Fila2["cod_leyes"]."'";
						$Respuesta3 = mysqli_query($link,$Consulta);				
						if ($Fila3 = mysqli_fetch_array($Respuesta3) || ($CodProducto == 18 && $CodSubProducto==4 && $Fila2["cod_leyes"]=="02"))
						{
							$Insertar = "insert into sec_web.tmp_leyes_grupos (cod_grupo, fecha, cod_leyes, valor, signo, fecha_creacion_paquete, nro_solicitud) ";
							$Insertar.= " values('00',";														
							$Insertar.= "'".$v[1]."',";
							$Insertar.= "'".$Fila2["cod_leyes"]."','".$Fila2["valor"]."','".$Fila2["signo"]."', '".$v[2]."', '".$Fila2["nro_solicitud"]."')";
							//echo $Insertar."<br>";
							mysqli_query($link,$Insertar);				
						}
					}		
				}		
			}
			else
			{
				//EL RESTO DE LOS CATODOS
				//TABLA PAQUETE_CATODO
				$Consulta = "select distinct ifnull(t2.cod_grupo,'00') as cod_grupo, t2.fecha_creacion_paquete,t1.cod_bulto,t1.num_bulto ";
				$Consulta.= " from sec_web.lote_catodo t1	inner join";
				$Consulta.= " sec_web.paquete_catodo t2 on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete";
				$Consulta.= " where t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and t1.cod_bulto = '".$Mes."'";
				$Consulta.= " and t1.num_bulto = '".$Lote."' and year(t1.fecha_creacion_lote) = '".$Ano."'";
				$Consulta.= " order by t2.cod_grupo";
			//	echo "AQUIIIII ".$Consulta."<br>";
				$Respuesta = mysqli_query($link,$Consulta);
				$i = 0;
				while ($Fila = mysqli_fetch_array($Respuesta))
				{			
					$Consulta = "select max(fecha_produccion) as fecha_produccion";
					$Consulta.= " from sec_web.produccion_catodo ";
					$Consulta.= " where cod_grupo = '".$Fila["cod_grupo"]."'";
					$Consulta.= " and fecha_produccion <= '".$Fila["fecha_creacion_paquete"]."'";
					$Respuesta2 = mysqli_query($link,$Consulta);
					if ($Fila2 = mysqli_fetch_array($Respuesta2))
					{
						
						$ArrProd[$i][0] = $Fila["cod_grupo"];
							if($CodProducto==18 && $CodSubProducto==57)
								$ArrProd[$i][4] = $Fila["cod_bulto"]."-".$Fila["num_bulto"];
							
						
						if ($Fila2["fecha_produccion"] == "" || is_null($Fila2["fecha_produccion"]) || ($CodProducto == 18 && $CodSubProducto == 5))
							$ArrProd[$i][1] = $Fila["fecha_creacion_paquete"];
						else
							$ArrProd[$i][1] = $Fila2["fecha_produccion"];
						$ArrProd[$i][2] = $Fila["fecha_creacion_paquete"];
						$i++;
						//echo $Fila["cod_grupo"]."  ".$Fila2["fecha_produccion"]."  ". $Fila["fecha_creacion_paquete"]."<br>";
					}
				}
				reset($ArrProd);
				$SeriePaquetes = "";
				$CodPaqueteAnt = "";
				$NumPaqueteAnt = 0;
				$i = 0;
				foreach($ArrProd as $k=>$v)
				{	
					if ((($v[0] == "00") || ($v[0] == "0") || ($v[0] == "")) && ($CodProducto == 18 && $CodSubProducto!=5))
					{					
						//CONSULTA LOTE EXTERNO	
					//	echo "<br><br>EXTERNO<br><br>";
					
						$Consulta = "SELECT distinct t2.lote_origen ";
						$Consulta.= "FROM sec_web.lote_catodo t1 inner join sec_web.paquete_catodo_externo t2 ";
						$Consulta.= "on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete ";
						$Consulta.= " WHERE t1.cod_bulto = '".$Mes."'  ";
						$Consulta.= " and t1.num_bulto = '".$Lote."' and year(t1.fecha_creacion_lote) = '".$Ano."'";
						$Consulta.= " order by t2.cod_paquete, t2.num_paquete, t2.lote_origen ";
						//echo $Consulta;
						$Respuesta = mysqli_query($link,$Consulta);
						while ($Fila = mysqli_fetch_array($Respuesta))
						{					
							//---------------------
							$Consulta = "select t2.cod_leyes, t2.valor, t1.fecha_muestra, ";
							$Consulta.= " t2.signo, t1.nro_solicitud ";
							$Consulta.= " from cal_web.solicitud_analisis t1 inner join ";
							$Consulta.= " cal_web.leyes_por_solicitud  t2 on t1.nro_solicitud = t2.nro_solicitud ";
							$Consulta.= " and t1.fecha_hora = t2.fecha_hora and t1.rut_funcionario = t2.rut_funcionario and t1.recargo = t2.recargo ";
							$Consulta.= " where ((t1.tipo = 1 and t1.id_muestra = '".$Fila["lote_origen"]."') ";
							$Consulta.= " or (tipo = '2' and t1.id_muestra = '".$Fila["lote_origen"]."-R')) ";				
							$Consulta.= " and t1.estado_actual <> '16' and t1.estado_actual <> '7'";
							$Consulta.= " and t1.frx <> 'S' and t1.cod_analisis = '1'";
							$Consulta.= " and t1.cod_producto = '18'";
							$Consulta.= "order by t1.fecha_muestra desc, t1.nro_solicitud, t2.cod_leyes ";
							//if ($Fila["lote_origen"]=='07070049')
							//echo $Consulta;
							$Respuesta2 = mysqli_query($link,$Consulta);
							$Encontro = false;
							while ($Fila2 = mysqli_fetch_array($Respuesta2))
							{
								$Encontro = true;
								$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase = '3009' ";
								$Consulta.= " and nombre_subclase = '".$Fila2["cod_leyes"]."'";
								$Respuesta3 = mysqli_query($link,$Consulta);				
								if ($Fila3 = mysqli_fetch_array($Respuesta3))
								{
									$Insertar = "insert into sec_web.tmp_leyes_grupos (cod_grupo, fecha, cod_leyes, valor, signo, ";
									$Insertar.= " fecha_creacion_paquete, nro_solicitud) ";
									$Insertar.= " values('".$Fila["lote_origen"]."', '".$v[1]."',";
									//$Insertar.= " values('".$Fila["lote_origen"]."', '".$v[2]."',";
									$Insertar.= " '".$Fila2["cod_leyes"]."','".$Fila2["valor"]."','".$Fila2["signo"]."', '".$v[2]."',";
									$Insertar.= " '".$Fila2["nro_solicitud"]."')";
									//if ($Fila2["nro_solicitud"]=='2007037263' || $Fila2["nro_solicitud"]=='2007037264')
							//		echo $Insertar."</br>";
									mysqli_query($link,$Insertar);		

								}	
							}
						}
						break;
					}
					else
					{
					//	echo "<br><br>CALIDADDDD<br><br>";
						//-------------------------LEYES DE CALIDAD-----------------------------
						$Consulta = "select t2.cod_leyes, t2.valor, t1.fecha_muestra, ";
						$Consulta.= " t2.signo, t1.nro_solicitud ";
						$Consulta.= " from cal_web.solicitud_analisis t1 inner join ";
						$Consulta.= " cal_web.leyes_por_solicitud  t2 on t1.nro_solicitud = t2.nro_solicitud ";
						$Consulta.= " and t1.fecha_hora = t2.fecha_hora and t1.rut_funcionario = t2.rut_funcionario and t1.recargo = t2.recargo ";
						if ($CodProducto == 18 && $CodSubProducto == 5)
						{							
							$Consulta.= " where t1.cod_periodo=1 and t1.cod_subproducto='5'";
						}
						else
						{
							if($CodProducto==18 && $CodSubProducto==57)
							{	

					 									$Consulta.= " where t1.tipo = 1 and t1.id_muestra = '".$v[4]."'  ";
							}else
							{	
								$Consulta.= " where ((t1.tipo = 1 and (t1.id_muestra = '".$v[0]."' or t1.id_muestra = '".intval($v[0])."')) ";
								$Consulta.= " or (tipo = '2' and (t1.id_muestra = '".$v[0]."-R' or t1.id_muestra = '".intval($v[0])."-R'))) ";
							}
							
						}
						if ($v[0] >= 50)
						{ 
							//CUANDO SON VIRTUALES TRABAJO CON LA FECHA CREACION PAQUETE								
							$Fecha1 = date("Y-m-d",mktime(0,0,0,substr($v[2],5,2),substr($v[2],8,2),substr($v[2],0,4)));
							$Fecha2 = date("Y-m-d",mktime(0,0,0,substr($Fecha1,5,2),substr($Fecha1,8,2) + 15,substr($Fecha1,0,4)));
							if ((intval(substr($Fecha1,5,2)) == intval(substr($Fecha2,5,2))) && (intval(substr($Fecha2,8,2)) < 31))
								$Fecha2 = substr($Fecha1,0,7)."-31";
							$Consulta.= " and t1.fecha_muestra between '".substr($Fecha1,0,7)."-01 00:00:00' and '".$Fecha2." 23:59:59'";
						}
						else
						{
							
							if($CodProducto==18 && $CodSubProducto==57)
							{	
								$Fecha1 = date("Y-m-d",mktime(0,0,0,substr($v[1],5,2),(substr($v[1],8,2)-$DiasMenos),substr($v[1],0,4)));
								$Fecha2 = date("Y-m-d",mktime(0,0,0,substr($v[1],5,2),(substr($v[1],8,2)+$DiasMas),substr($v[1],0,4)));
								$Consulta.= " and t1.fecha_muestra between '".$Fecha1." 00:00:00' and '".$Fecha2." 23:59:59'";
							}else
							{
								$Fecha1 = date("Y-m-d",mktime(0,0,0,substr($v[1],5,2),(substr($v[1],8,2)-3),substr($v[1],0,4)));
								$Fecha2 = date("Y-m-d",mktime(0,0,0,substr($v[1],5,2),(substr($v[1],8,2)+4),substr($v[1],0,4)));
								$Consulta.= " and t1.fecha_muestra between '".$Fecha1." 00:00:00' and '".$Fecha2." 23:59:59'";
							}
						}
						$Consulta.= " and t1.estado_actual <> '16' and t1.estado_actual <> '7'";
						$Consulta.= " and t1.frx <> 'S' and t1.cod_analisis = '1'";
						$Consulta.= " and t1.cod_producto = '18'  and t1.cod_subproducto='".$CodSubProducto ."'";
						$Consulta.= " order by t1.fecha_muestra desc, t1.nro_solicitud, t2.cod_leyes ";
						//echo "<br>AKI ".$Consulta."<br>";
						$Respuesta2 = mysqli_query($link,$Consulta);
						$Encontro = false;
						while ($Fila2 = mysqli_fetch_array($Respuesta2))
						{
							$Encontro = true;
							$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase = '3009' ";
							$Consulta.= " and nombre_subclase = '".$Fila2["cod_leyes"]."'";
							$Respuesta3 = mysqli_query($link,$Consulta);				
							if ($Fila3 = mysqli_fetch_array($Respuesta3) || ($CodProducto == 18 && $CodSubProducto==5 && $Fila2["cod_leyes"]=="02"))
							{
								$Insertar = "insert into sec_web.tmp_leyes_grupos (cod_grupo, fecha, cod_leyes, valor, signo, fecha_creacion_paquete, nro_solicitud) ";
								if ($CodProducto == 18 && $CodSubProducto==5)
									$Insertar.= " values('00',";
								else
									$Insertar.= " values('".$v[0]."',";
								if ($v[0] >= 50)
									$Insertar.= "'".$v[2]."',";
								else
									$Insertar.= "'".$v[1]."',";
								$Insertar.= "'".$Fila2["cod_leyes"]."','".$Fila2["valor"]."','".$Fila2["signo"]."', '".$v[2]."', '".$Fila2["nro_solicitud"]."')";
								//echo "<br>LEYES GRUPO BBBBB ".$Insertar."</br>";
								mysqli_query($link,$Insertar);				
							}
						}
						if (($v[0] >= 50) && ($Encontro == false))
						{
							$Consulta = "select max(t1.fecha_muestra) as fecha_muestra";
							$Consulta.= " from cal_web.solicitud_analisis t1 inner join ";
							$Consulta.= " cal_web.leyes_por_solicitud  t2 on t1.nro_solicitud = t2.nro_solicitud ";
							$Consulta.= " and t1.fecha_hora = t2.fecha_hora and t1.rut_funcionario = t2.rut_funcionario and t1.recargo = t2.recargo ";
							if ($CodProducto == 18 && $CodSubProducto == 5)
							{
								//$Consulta.= " where ((t1.tipo = 1 and t1.id_muestra like '%EW%') ";
								//$Consulta.= " or (tipo = '2' and t1.id_muestra like '%EW%')) ";
								$Consulta.= " where t1.cod_periodo=1 and t1.cod_subproducto='5'";
							}
							else
							{
							
								if($CodProducto==18 && $CodSubProducto==57)
								{	$Consulta.= " where t1.tipo = 1 and t1.id_muestra = '".$v[4]."'  ";
								
								
								}else
								{	
									$Consulta.= " where ((t1.tipo = 1 and (t1.id_muestra = '".$v[0]."' or t1.id_muestra = '".intval($v[0])."')) ";
									$Consulta.= " or (tipo = '2' and (t1.id_muestra = '".$v[0]."-R' or t1.id_muestra = '".intval($v[0])."-R'))) ";				
								}
							
							}
							$Consulta.= " and t1.estado_actual <> '16' and t1.estado_actual <> '7'";
							$Consulta.= " and t1.fecha_muestra < '".substr($Fecha1,0,7)."-01 00:00:00' ";
							$Consulta.= " and t1.frx <> 'S' and t1.cod_analisis = '1'";
							$Consulta.= " and t1.cod_producto = '18'  and t1.cod_subproducto='".$CodSubProducto."'";
							$Respuesta3 = mysqli_query($link,$Consulta);
							while ($Fila3 = mysqli_fetch_array($Respuesta3))
							{
								$Consulta = "select t2.cod_leyes, t2.valor, t1.fecha_muestra, ";
								$Consulta.= " t2.signo, t1.nro_solicitud ";
								$Consulta.= " from cal_web.solicitud_analisis t1 inner join ";
								$Consulta.= " cal_web.leyes_por_solicitud  t2 on t1.nro_solicitud = t2.nro_solicitud ";
								$Consulta.= " and t1.fecha_hora = t2.fecha_hora and t1.rut_funcionario = t2.rut_funcionario and t1.recargo = t2.recargo ";
								if ($CodProducto == 18 && $CodSubProducto == 5)
								{
									//$Consulta.= " where ((t1.tipo = 1 and t1.id_muestra like '%EW%') ";
									//$Consulta.= " or (tipo = '2' and t1.id_muestra like '%EW%')) ";
									$Consulta.= " where t1.cod_periodo=1 and t1.cod_subproducto='5'";
								}
								else
								{	
									if($CodProducto==18 && $CodSubProducto==57)
									{	$Consulta.= " where t1.tipo = 1 and t1.id_muestra = '".$v[4]."'  ";
									
									
									}else
									{	
										$Consulta.= " where ((t1.tipo = 1 and (t1.id_muestra = '".$v[0]."' or t1.id_muestra = '".intval($v[0])."')) ";
										$Consulta.= " or (tipo = '2' and (t1.id_muestra = '".$v[0]."-R' or t1.id_muestra = '".intval($v[0])."-R'))) ";				
									}
										
									}
								$Consulta.= " and t1.estado_actual <> '16' and t1.estado_actual <> '7'";
								$Consulta.= " and t1.fecha_muestra < '".$Fila["fecha_muestra"]."' "; //FECHA MAXIMA ENCONTRADA (DESDE LA FECHA QUE NO ENCONTRO)
								$Consulta.= " and t1.frx <> 'S' and t1.cod_analisis = '1'";
								$Consulta.= " and t1.cod_producto = '18' and t1.cod_subproducto='".$CodSubProducto ."' ";
								$Consulta.= " order by t2.cod_leyes";
								$Respuesta4 = mysqli_query($link,$Consulta);
								while ($Fila4 = mysqli_fetch_array($Respuesta4))
								{
									$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase = '3009' ";
									$Consulta.= " and nombre_subclase = '".$Fila4["cod_leyes"]."'";
									$Respuesta5 = mysqli_query($link,$Consulta);				
									if ($Fila5 = mysqli_fetch_array($Respuesta5) || ($CodProducto == 18 && $CodSubProducto==5 && $Fila4["cod_leyes"]=="02"))
									{
										$Insertar = "insert into sec_web.tmp_leyes_grupos (cod_grupo, fecha, cod_leyes, valor, signo, fecha_creacion_paquete, nro_solicitud) ";
										if ($CodProducto == 18 && $CodSubProducto==5)
											$Insertar.= " values('00',";
										else
											$Insertar.= " values('".$v[0]."',";
										$Insertar.= "'".$v[2]."','".$Fila4["cod_leyes"]."','".$Fila4["valor"]."','".$Fila4["signo"]."', '".$v[2]."', '".$Fila4["nro_solicitud"]."')";
										mysqli_query($link,$Insertar);	
								//		echo "<br>LEYES GRUPO CCCCC ".$Insertar."<br>";			
									}
								}
							}
						}
						//LEYES DE Ag, Au Mensual para los Cat. E.W. Ventanas
						if ($CodProducto == 18 && $CodSubProducto == 5)
						{
							//-------------------------LEYES DE CALIDAD-----------------------------
							$Consulta = "select t2.cod_leyes, t2.valor, t1.fecha_muestra, ";
							$Consulta.= " t2.signo, t1.nro_solicitud ";
							$Consulta.= " from cal_web.solicitud_analisis t1 inner join ";
							$Consulta.= " cal_web.leyes_por_solicitud  t2 on t1.nro_solicitud = t2.nro_solicitud ";
							$Consulta.= " and t1.fecha_hora = t2.fecha_hora and t1.rut_funcionario = t2.rut_funcionario and t1.recargo = t2.recargo ";													
							$Consulta.= " where t1.cod_periodo=3 ";
							$Consulta.= " and t1.cod_producto='18' and t1.cod_subproducto='5'";																											
							$Consulta.= " and t1.año='".substr($v[1],0,4)."' and t1.mes='".intval(substr($v[1],5,2))."'";							
							$Consulta.= " and t1.estado_actual <> '16' and t1.estado_actual <> '7'";
							$Consulta.= " and t1.frx <> 'S' and t1.cod_analisis = '1'";
							$Consulta.= " and t1.tipo = '1' and t2.cod_leyes in(04,05) ";
							$Consulta.= " order by t1.fecha_muestra desc, t1.nro_solicitud, t2.cod_leyes ";
						//	echo "LEYES GRUPO ".$Consulta."<br>";
							$Respuesta2 = mysqli_query($link,$Consulta);
							$Encontro = false;
							while ($Fila2 = mysqli_fetch_array($Respuesta2))
							{
								$Encontro = true;
								$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase = '3009' ";
								$Consulta.= " and nombre_subclase = '".$Fila2["cod_leyes"]."'";
								$Respuesta3 = mysqli_query($link,$Consulta);				
								if ($Fila3 = mysqli_fetch_array($Respuesta3) || ($CodProducto == 18 && $CodSubProducto==5 && $Fila2["cod_leyes"]=="02"))
								{
									$Insertar = "insert into sec_web.tmp_leyes_grupos (cod_grupo, fecha, cod_leyes, valor, signo, fecha_creacion_paquete, nro_solicitud) ";
									if ($CodProducto == 18 && $CodSubProducto==5)
										$Insertar.= " values('00',";
									else
										$Insertar.= " values('".$v[0]."',";									
									$Insertar.= "'".$v[1]."',";
									$Insertar.= "'".$Fila2["cod_leyes"]."','".$Fila2["valor"]."','".$Fila2["signo"]."', '".$v[2]."', '".$Fila2["nro_solicitud"]."')";
								//	echo "<br>LEYES GRUPO DDDDDD".$Insertar."<br>";
									mysqli_query($link,$Insertar);				
								}//END IF
							}//END WHILE
						}//END IF
					}//END ELSE
				}//FIN WHILE			
			}//FIN ELSE
		}//FIN ELSE
	}
	//	LUEGO QUE TENGO LOS DATOS DEL DETALLE GENERO EL CERTIFICADO VIRTUAL	
	$Eliminar = "delete from sec_web.`tmp_certificacion_catodos`";
	mysqli_query($link,$Eliminar);
	//CALCULO TOTALES DEL LOTE
	//TABLA PAQUETE_CATODO
	$Consulta = "SHOW TABLES FROM `sec_web`";
	$Respuesta = mysqli_query($link,$Consulta);
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
		if ($Fila["Tables_in_sec_web"] == "tmp_leyes_catodos")
		{
			$Eliminar = "DROP TABLE `sec_web`.`tmp_leyes_catodos`";
			mysqli_query($link,$Eliminar);
		}
	}
	if ($CodProducto == "18" && ($CodSubProducto == "3" || $CodSubProducto == "42" || $CodSubProducto == "43" || $CodSubProducto == "44"))  
	{	
		$Consulta = "create table `sec_web`.`tmp_leyes_catodos` (key ind01(cod_paquete,num_paquete)) as ";
		$Consulta.= " select t1.cod_grupo as cod_paquete, t1.fecha as num_paquete, t1.peso_produccion as peso_paquete, ";
		$Consulta.= " t1.cod_leyes, t1.valor, t1.signo ";
		$Consulta.= " from sec_web.tmp_leyes_grupos t1 ";
		//echo $Consulta;
	}
	else
	{
		if (($CodProducto == 18 && $CodSubProducto==5))
		{
			$Grupo = "EW";
		}
		else
		{
			if (($CodProducto == 18 && $CodSubProducto==4))
			{
				$Grupo = "DP";
			}
			else
			{
				$Consulta = "select distinct ifnull(t2.cod_grupo,'00') as cod_grupo ";
				$Consulta.= " from sec_web.lote_catodo t1	inner join";
				$Consulta.= " sec_web.paquete_catodo t2 on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete";
				$Consulta.= " where t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and t1.cod_bulto = '".$Mes."'";
				$Consulta.= " and t1.num_bulto = '".$Lote."' and year(t1.fecha_creacion_lote)='".$Ano."'";
				$Consulta.= " order by t2.cod_grupo";
				$Respuesta = mysqli_query($link,$Consulta);
				$Grupo = 0;
				if ($Fila = mysqli_fetch_array($Respuesta))
					$Grupo = $Fila["cod_grupo"];
			}
		}
		//if (($Grupo == "00") || ($Grupo == "0") || ($Grupo == "")) -> LOTE
		//else -> GRUPO
		if (($Grupo == "00") || ($Grupo == "0") || ($Grupo == ""))
		{
			$Consulta = "create table `sec_web`.`tmp_leyes_catodos` (key ind01(cod_paquete,num_paquete)) as ";
			$Consulta.= " select t1.cod_paquete, t1.num_paquete, t2.peso_paquete as peso_paquete, ";
			$Consulta.= " t3.cod_leyes, t3.valor, t2.cod_grupo, t3.signo ";
			$Consulta.= " from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo_externo t2  ";
			$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete  ";
			$Consulta.= " inner join sec_web.tmp_leyes_grupos t3 on t2.lote_origen = t3.cod_grupo ";
			//$Consulta.= " and t2.fecha_creacion_paquete = t3.fecha_creacion_paquete ";
			$Consulta.= " where t1.cod_bulto = '".$Mes."' and t1.num_bulto = '".$Lote."'  ";
			$Consulta.= " order by t1.cod_paquete, t1.num_paquete, t3.cod_leyes ";
			//echo "linea 502 : ".$Consulta."<br>";
		}
		else
		{
			$Consulta = "create table `sec_web`.`tmp_leyes_catodos` (key ind01(cod_paquete,num_paquete)) as ";
			$Consulta.= " select t1.cod_paquete, t1.num_paquete, t2.peso_paquetes as peso_paquete, ";
			$Consulta.= " t3.cod_leyes, t3.valor, t2.cod_grupo, t3.signo ";
			$Consulta.= " from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2  ";
			$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete  ";
			$Consulta.= " inner join sec_web.tmp_leyes_grupos t3 on ";
			if ($CodProducto == 18 && ($CodSubProducto==4 || $CodSubProducto==5))
				$Consulta.= " t3.cod_grupo = '00' and ";
			else
				$Consulta.= " t2.cod_grupo = t3.cod_grupo and ";
			$Consulta.= " t2.fecha_creacion_paquete = t3.fecha_creacion_paquete ";
			$Consulta.= " where t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and t1.cod_bulto = '".$Mes."' and t1.num_bulto = '".$Lote."' and year(t1.fecha_creacion_lote)='".$Ano."' ";
			$Consulta.= " order by t1.cod_paquete, t1.num_paquete, t3.cod_leyes ";		
		}
	}
//echo "CONSULTA LEYESSSSSSSS ".$Consulta;
	mysqli_query($link,$Consulta);
	if ($CodProducto == 18 && ($CodSubProducto == 1 || $CodSubProducto == 3))
	{
		//ACTUALIZA TABLA PARA TRABAJAR CON LOS VALORES <
		$Consulta = "select * ";
		$Consulta.= " from sec_web.tmp_leyes_catodos t1 inner join proyecto_modernizacion.sub_clase t2 ";
		$Consulta.= " on t2.cod_clase = '3009' and t1.cod_leyes = t2.nombre_subclase ";
		$Consulta.= " where not isnull(t2.valor_subclase6) and t2.valor_subclase6 <> '' and t2.valor_subclase6 <> 0";
		$Consulta.= " order by t2.valor_subclase2";
		$Respuesta2 = mysqli_query($link,$Consulta);
		//echo $Consulta;
		while ($Fila2 = mysqli_fetch_array($Respuesta2))
		{
			if (($Fila2["valor"] <= $Fila2["valor_subclase6"]) && ($Fila2["signo"] == "<"))
			{			
				$Actualizar = "update sec_web.tmp_leyes_catodos set ";
				$Actualizar.= " valor = '".$Fila2["valor_subclase7"]."'";
				$Actualizar.= " where cod_paquete = '".$Fila2["cod_paquete"]."'";
				$Actualizar.= " and num_paquete = '".$Fila2["num_paquete"]."'";
				$Actualizar.= " and cod_leyes = '".$Fila2["cod_leyes"]."'";
				mysqli_query($link,$Actualizar);
			}
		}
	}
	//VALOR LEY
	$Consulta = "select t1.cod_leyes, sum(t1.peso_paquete) as peso_paquetes, sum(t1.peso_paquete * t1.valor) as fino";
	$Consulta.= " from sec_web.tmp_leyes_catodos t1 left join proyecto_modernizacion.sub_clase t2 ";
	$Consulta.= " on t2.cod_clase = '3009' and t1.cod_leyes = t2.nombre_subclase ";
	$Consulta.= " group by t1.cod_leyes";
	$Consulta.= " order by t2.valor_subclase2";
	$Respuesta = mysqli_query($link,$Consulta);
	//echo "PRUEBA   ".$Consulta;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{				
		//PESO LOTE
		$PesoLote = 0;
		$Consulta = "select sum(t2.peso_paquetes) as peso_lote";
		$Consulta.= " from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2";
		$Consulta.= " on t1.cod_paquete = t2.cod_paquete and t1.num_paquete = t2.num_paquete ";
		$Consulta.= " where t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and t1.cod_bulto = '".$Mes."' and num_bulto = '".$Lote."' and year(t1.fecha_creacion_lote)='".$Ano."'";
		$Respuesta2 = mysqli_query($link,$Consulta);
		if ($Fila2 = mysqli_fetch_array($Respuesta2))
		{
			$PesoLote = $Fila2["peso_lote"];
		}
		if (($PesoLote != 0) && ($Fila["fino"] != 0))
			$ValorLey = $Fila["fino"] / $Fila["peso_paquetes"];
		else
			$ValorLey = 0;		
		//CANTIDAD DE DECIMALES POR COD_LEYES					
		if (($Fila["cod_leyes"] == "26") || ($Fila["cod_leyes"] == "48"))
		{
			$NumDecimales = 0;
		}						
		else
		{ 
			$NumDecimales = 1;
		}
		//SIGNO
		$Signo    = "=";
		$Consulta = "select * ";
		$Consulta.= " from proyecto_modernizacion.sub_clase ";
		$Consulta.= " where cod_clase = '3009' ";
		$Consulta.= " and (not isnull(valor_subclase6) and valor_subclase6 <> '' and valor_subclase6 <> 0)";
		$Consulta.= " and nombre_subclase = '".$Fila["cod_leyes"]."'";
		$Respuesta2 = mysqli_query($link,$Consulta);
		if ($Fila2 = mysqli_fetch_array($Respuesta2) || ($CodProducto == 18 && ($CodSubProducto==4 || $CodSubProducto==5) && $Fila2["cod_leyes"]=="02"))
		{
			$valor_subclase6 = isset($Fila2["valor_subclase6"])?$Fila2["valor_subclase6"]:0;
			if (round($ValorLey,3) < round(($valor_subclase6 * 1),3))
				$Signo = "<";						
		}
		if ($Signo == "<")		
			$Valor = round($Fila2["valor_subclase6"],1);		
		else
			$Valor = round($ValorLey,1);
		//GRABA DATOS 
		$Insertar = "insert into sec_web.tmp_certificacion_catodos(cod_lote,num_lote,cod_leyes,";
		$Insertar.= " valor,signo,fecha) VALUES('".$Mes."','".$Lote."','".$Fila["cod_leyes"]."',";
		$Insertar.= " '".$Valor."','".$Signo."','".$FechaActual."')";
		mysqli_query($link,$Insertar);		
		//echo "INSERTAR CERTIFICADOS ".$Insertar."<br>";
	}
}			
?>
