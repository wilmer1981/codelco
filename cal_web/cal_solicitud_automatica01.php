<?php
	$CodigoDeSistema=1;
	include("../principal/conectar_cal_web.php");

	
	$TipoMuestra = "";
	$ValCheck = $Muestras;//RECIBE LOS ELEMENTOS CHEQUEADOS PARA VOLVERLOS A MARCAR
	if (($ValorAnalisis==1) && ($ValorMuestreo==1))		
	{
		$TipoMuestra=3;
	}
	else
		if ($ValorAnalisis==1)
		{
			$TipoMuestra=1;
		}
		else
		{
			$TipoMuestra=2;
		}
	$Rut = $CookieRut;
	$Entrar=true;//USADO PARA NO HACER DOS HEADER CON LA OPCION L Y S(TIENES SUS PROPIOS HEADER)
	switch ($proceso)
	{
		case "P"://PERIODO HOY
			for ($j = 0;$j <= strlen($Muestras); $j++)
			{
				if (substr($Muestras,$j,2) == "//")
				{
					$MuestraFechaRecargo = substr($Muestras,0,$j);
					for ($x=0;$x<=strlen($MuestraFechaRecargo);$x++)
					{
						if (substr($MuestraFechaRecargo,$x,2) == "~~")
						{
							$Muestra = substr($MuestraFechaRecargo,0,$x);			
							$Fecha = substr($MuestraFechaRecargo,$x+2,19);
							$Recargo = substr($MuestraFechaRecargo,$x+21,strlen($MuestraFechaRecargo));
							if ($Recargo=='N')		
							{
								$Eliminar="delete from cal_web.periodos_solicitud_analisis where rut_funcionario ='".$Rut."' and fecha_hora='".$Fecha."' and id_muestra ='".$Muestra."'";	
								mysqli_query($link, $Eliminar);
								$Insertar = "insert into cal_web.periodos_solicitud_analisis (rut_funcionario,fecha_hora,id_muestra,cod_periodo) values ('$Rut','$Fecha','$Muestra','$Periodo')";
								mysqli_query($link, $Insertar);
								$Actualizar = "UPDATE cal_web.solicitud_analisis set cod_periodo='".$Periodo."'";
								$Actualizar = $Actualizar." where rut_funcionario = '".$Rut."' and fecha_hora ='".$Fecha."' and id_muestra ='".$Muestra."'";
								mysqli_query($link, $Actualizar);
							}
							else
							{
								$Eliminar="delete from cal_web.periodos_solicitud_analisis where rut_funcionario ='".$Rut."' and fecha_hora='".$Fecha."' and id_muestra ='".$Muestra."' and recargo ='".$Recargo."'";	
								mysqli_query($link, $Eliminar);
								$Insertar = "insert into cal_web.periodos_solicitud_analisis (rut_funcionario,fecha_hora,id_muestra,recargo,cod_periodo) values ('$Rut','$Fecha','$Muestra','$Recargo','$Periodo')";
								mysqli_query($link, $Insertar);
								$Actualizar = "UPDATE cal_web.solicitud_analisis set cod_periodo='".$Periodo."'";
								$Actualizar = $Actualizar." where rut_funcionario = '".$Rut."' and fecha_hora ='".$Fecha."' and id_muestra ='".$Muestra."' and recargo='".$Recargo."'";							
								mysqli_query($link, $Actualizar);
							}		
						}
					}
				$Muestras = substr($Muestras,$j + 2);
				$j = 0;
				}
			}					
			break;			
		case "L":
			header("location:cal_solicitud_automatica.php");
			$Entrar=false;
			break;
		case "S":
			header("location:../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=10");
			$Entrar=false;
			break;
		case "N"://INGRESA UN NUEVO REGISTRO EN SOLICITUD ANALISIS
			//SI EL PRODUCTO ES MINERO SE MANEJAN LOS RECARGOS
			if ($CmbProductos == 1)
			{
				for ($i=0;$i<=strlen($Muestras_Check);$i++)
				{
					if(substr($Muestras_Check,$i,2) == "//")
					{
						$MuestraRecargoFin = substr($Muestras_Check,0,$i);
						for ($j=0;$j<=strlen($MuestraRecargoFin);$j++)
						{
							if(substr($MuestraRecargoFin,$j,2) == "~~")
							{
								$Muestra = substr($MuestraRecargoFin,0,$j);
								$Recargo = substr($MuestraRecargoFin,$j+2,strlen($MuestraRecargoFin));
								$Recargo = substr($Recargo,0,strlen($Recargo)-1);
								$Fin = substr($MuestraRecargoFin,strlen($MuestraRecargoFin)-1,1);
								if (($ConHum=='N')&&($Fin=='S'))
								{
									$GrabarHum=false;
								}
								else
								{
									$GrabarHum=true;								
								}
								//VERIFICA SI EXISTE OTRO RECARGO CON NRO DE SOLICITUD PARA TOMAR SUS VALORES E INSERTARLO EN FORMA AUTOMATICA
								$Consulta = "select rut_funcionario,nro_solicitud,fecha_hora,cod_analisis,cod_tipo_muestra,cod_ccosto,cod_periodo,estado_actual,cod_area,observacion,fecha_muestra,a�o,mes,nro_semana,rut_proveedor,cod_producto,cod_subproducto,id_muestra from cal_web.solicitud_analisis where id_muestra = ".$Muestra." and cod_producto =".$CmbProductos." and cod_subproducto =".$CmbSubProducto." and tipo_solicitud = 'A' and ((nro_solicitud is not null) or (nro_solicitud <> '')) order by recargo";
								$Respuesta = mysqli_query($link, $Consulta);
								if ($Fila=mysqli_fetch_array($Respuesta))
								{
									if ($GrabarHum==true)
									{
										$Insertar = "insert into cal_web.solicitud_analisis(rut_funcionario,fecha_hora,id_muestra,recargo,cod_producto,cod_subproducto,";
										$Insertar = $Insertar."leyes,cod_analisis,cod_tipo_muestra,tipo_solicitud,nro_solicitud,cod_area,cod_ccosto,cod_periodo,estado_actual,rut_proveedor,observacion,agrupacion,fecha_muestra,a�o,mes,nro_semana) values ('";
										$Insertar = $Insertar.$Fila["rut_funcionario"]."','";
										$Insertar = $Insertar.$Fila["fecha_hora"]."','";
										$Insertar = $Insertar.$Muestra."','";	
										$Insertar = $Insertar.$Recargo."','";	
										$Insertar = $Insertar.$CmbProductos."','";					
										$Insertar = $Insertar.$CmbSubProducto."',";			
										$Insertar = $Insertar."'01~~1//','";			
										$Insertar = $Insertar.$Fila["cod_analisis"]."','";			
										$Insertar = $Insertar.$Fila["cod_tipo_muestra"]."','A',";
										$Insertar = $Insertar.$Fila["nro_solicitud"].",";
										$Insertar = $Insertar.$Fila["cod_area"].",'";
										$Insertar = $Insertar.$Fila["cod_ccosto"]."','";
										$Insertar = $Insertar.$Fila["cod_periodo"]."',";	
										$Insertar = $Insertar."'1','";
										$Insertar = $Insertar.$Fila["rut_proveedor"]."','";
										$Insertar = $Insertar.$Fila["observacion"]."',1,'";
										$Insertar = $Insertar.$Fila["fecha_muestra"]."','";
										$Insertar = $Insertar.$Fila["a�o"]."','";
										$Insertar = $Insertar.$Fila["mes"]."','";
										$Insertar = $Insertar.$Fila["nro_semana"]."')";									
										mysqli_query($link, $Insertar);
										if ($Fila["cod_tipo_muestra"]==1)
										{
											//SE INSERTA EL ESTADO DE LA SOLICITUD EN FORMA AUTOMATICA
											$Insertar2="insert into cal_web.estados_por_solicitud(rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,ult_atencion,rut_proceso) values ('";
											$Insertar2 = $Insertar2.$Fila["rut_funcionario"]."',";
											$Insertar2 = $Insertar2.$Fila["nro_solicitud"].",'";
											$Insertar2 = $Insertar2.$Recargo."',";
											$Insertar2 = $Insertar2."'12','";	
											$Insertar2 = $Insertar2.$Fila["fecha_hora"]."',";
											$Insertar2 = $Insertar2."'N','".$Fila["rut_funcionario"]."')";
											mysqli_query($link, $Insertar2);
											$Insertar2="insert into cal_web.estados_por_solicitud(rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,ult_atencion,rut_proceso) values ('";
											$Insertar2 = $Insertar2.$Fila["rut_funcionario"]."',";
											$Insertar2 = $Insertar2.$Fila["nro_solicitud"].",'";
											$Insertar2 = $Insertar2.$Recargo."',";
											$Insertar2 = $Insertar2."'1','";	
											$Insertar2 = $Insertar2.$Fila["fecha_hora"]."',";
											$Insertar2 = $Insertar2."'N','".$Fila["rut_funcionario"]."')";
											mysqli_query($link, $Insertar2);
										}
										else
										{
											$Insertar2="insert into cal_web.estados_por_solicitud(rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,ult_atencion,rut_proceso) values ('";
											$Insertar2 = $Insertar2.$Fila["rut_funcionario"]."',";
											$Insertar2 = $Insertar2.$Fila["nro_solicitud"].",'";
											$Insertar2 = $Insertar2.$Recargo."',";
											$Insertar2 = $Insertar2."'1','";	
											$Insertar2 = $Insertar2.$Fila["fecha_hora"]."',";
											$Insertar2 = $Insertar2."'N','".$Fila["rut_funcionario"]."')";
											mysqli_query($link, $Insertar2);
										}	
										//SE INSERTA LA LEY DE HUMEDAD EN FORMA AUTOMATICA
										$Insertar2="insert into cal_web.leyes_por_solicitud(rut_funcionario,fecha_hora,nro_solicitud,recargo,cod_leyes,cod_unidad,cod_producto,cod_subproducto,id_muestra) values ('";
										$Insertar2 = $Insertar2.$Fila["rut_funcionario"]."','";
										$Insertar2 = $Insertar2.$Fila["fecha_hora"]."',";
										$Insertar2 = $Insertar2.$Fila["nro_solicitud"].",'";
										$Insertar2 = $Insertar2.$Recargo."',";
										$Insertar2 = $Insertar2."'01',";
										$Insertar2 = $Insertar2."'1','";
										$Insertar2 = $Insertar2.$Fila["cod_producto"]."','";
										$Insertar2 = $Insertar2.$Fila["cod_subproducto"]."','";
										$Insertar2 = $Insertar2.$Fila["id_muestra"]."')";
										mysqli_query($link, $Insertar2);
										$Actualizar = "UPDATE sipa_web.recepciones set sa_asignada = ".$Fila["nro_solicitud"]." where lote='".$Muestra."' and recargo='".$Recargo."'";
										mysqli_query($link, $Actualizar);
									}	
									//SI ES FIN SE INSERTA UNA NUEVA MUESTRA CON RECARGO 0
									if ($Fin=='S')
									{
										$Insertar = "insert into cal_web.solicitud_analisis(rut_funcionario,fecha_hora,nro_solicitud,id_muestra,recargo,cod_producto,cod_subproducto,";
										$Insertar = $Insertar."cod_analisis,cod_tipo_muestra,tipo_solicitud,cod_area,cod_ccosto,cod_periodo,estado_actual,rut_proveedor,observacion,agrupacion,fecha_muestra,a�o,mes,nro_semana) values ('";
										$Insertar = $Insertar.$Fila["rut_funcionario"]."','";
										$Insertar = $Insertar.$Fila["fecha_hora"]."',";
										$Insertar = $Insertar.$Fila["nro_solicitud"].",'";
										$Insertar = $Insertar.$Muestra."',";	
										$Insertar = $Insertar."'0','";	
										$Insertar = $Insertar.$CmbProductos."','";					
										$Insertar = $Insertar.$CmbSubProducto."','";			
										$Insertar = $Insertar.$Fila["cod_analisis"]."','";			
										$Insertar = $Insertar.$Fila["cod_tipo_muestra"]."','A',";
										$Insertar = $Insertar.$Fila["cod_area"].",'";
										$Insertar = $Insertar.$Fila["cod_ccosto"]."','";
										$Insertar = $Insertar.$Fila["cod_periodo"]."',";	
										$Insertar = $Insertar."'1','";
										$Insertar = $Insertar.$Fila["rut_proveedor"]."','";
										$Insertar = $Insertar.$Fila["observacion"]."',1,'";
										$Insertar = $Insertar.$Fila["fecha_muestra"]."','";
										$Insertar = $Insertar.$Fila["a�o"]."','";
										$Insertar = $Insertar.$Fila["mes"]."','";
										$Insertar = $Insertar.$Fila["nro_semana"]."')";									
										mysqli_query($link, $Insertar);
										$FechaHora=$Fila["fecha_hora"];
										if ($Fila["cod_tipo_muestra"]==1)
										{
											//SE INSERTA EL ESTADO DE LA SOLICITUD EN FORMA AUTOMATICA
											$Insertar2="insert into cal_web.estados_por_solicitud(rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,ult_atencion,rut_proceso) values ('";
											$Insertar2 = $Insertar2.$Fila["rut_funcionario"]."',";
											$Insertar2 = $Insertar2.$Fila["nro_solicitud"].",";
											$Insertar2 = $Insertar2."'0',";
											$Insertar2 = $Insertar2."'12','";	
											$Insertar2 = $Insertar2.$Fila["fecha_hora"]."',";
											$Insertar2 = $Insertar2."'N','".$Fila["rut_funcionario"]."')";
											mysqli_query($link, $Insertar2);
											$Insertar2="insert into cal_web.estados_por_solicitud(rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,ult_atencion,rut_proceso) values ('";
											$Insertar2 = $Insertar2.$Fila["rut_funcionario"]."',";
											$Insertar2 = $Insertar2.$Fila["nro_solicitud"].",";
											$Insertar2 = $Insertar2."'0',";
											$Insertar2 = $Insertar2."'1','";	
											$Insertar2 = $Insertar2.$Fila["fecha_hora"]."',";
											$Insertar2 = $Insertar2."'N','".$Fila["rut_funcionario"]."')";
											mysqli_query($link, $Insertar2);
										}
										else
										{
											$Insertar2="insert into cal_web.estados_por_solicitud(rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,ult_atencion,rut_proceso) values ('";
											$Insertar2 = $Insertar2.$Fila["rut_funcionario"]."',";
											$Insertar2 = $Insertar2.$Fila["nro_solicitud"].",";
											$Insertar2 = $Insertar2."'0',";
											$Insertar2 = $Insertar2."'1','";	
											$Insertar2 = $Insertar2.$Fila["fecha_hora"]."',";
											$Insertar2 = $Insertar2."'N','".$Fila["rut_funcionario"]."')";
											mysqli_query($link, $Insertar2);
										}
									}
								}
								else
								{
									//ENTRA ACA SI ES EL PRIMER RECARGO Y TOMA ALGUNOS VALORES POR DEFECTO 
									$Consulta = "select * from proyecto_modernizacion.valores_por_defecto where cod_producto =".$CmbProductos." and cod_subproducto =".$CmbSubProducto." and rut='".$CmbRutPrv."'";
									$Respuesta2=mysqli_query($link, $Consulta);
									if($Fila2=mysqli_fetch_array($Respuesta2))
									{
										if ($GrabarHum==true)
										{
											$Insertar = "insert into solicitud_analisis(rut_funcionario,fecha_hora,id_muestra,recargo,cod_producto,cod_subproducto,";
											$Insertar = $Insertar."leyes,cod_analisis,cod_tipo_muestra,tipo_solicitud,cod_area,cod_ccosto,cod_periodo,rut_proveedor,agrupacion,fecha_muestra) values ('";
											$Insertar = $Insertar.$Rut."','";
											$Insertar = $Insertar.$FechaHora."','";
											$Insertar = $Insertar.$Muestra."','";	
											$Insertar = $Insertar.$Recargo."','";	
											$Insertar = $Insertar.$CmbProductos."','";					
											$Insertar = $Insertar.$CmbSubProducto."',";			
											$Insertar = $Insertar."'01~~1//','";			
											$Insertar = $Insertar.$CmbTipoAnalisis."','";			
											$Insertar = $Insertar.$TipoMuestra."','A',";
											$Insertar = $Insertar.$Fila2["cod_area"].",'";
											$Insertar = $Insertar.$Fila2["cod_cc"]."','";
											$Insertar = $Insertar.$Fila2["cod_periodo"]."','";
											$Insertar = $Insertar.$CmbRutPrv."',1,'";
											$Insertar = $Insertar.$FechaHora."')";
											mysqli_query($link, $Insertar);
										}	
										//SI FIN DE RECARGO SE CREA LA MUESTRA CON RECARGO O
										if ($Fin=='S')
										{
											$Insertar = "insert into solicitud_analisis(rut_funcionario,fecha_hora,id_muestra,recargo,cod_producto,cod_subproducto,";
											$Insertar = $Insertar."cod_analisis,cod_tipo_muestra,tipo_solicitud,cod_area,cod_ccosto,cod_periodo,rut_proveedor,agrupacion,fecha_muestra) values ('";
											$Insertar = $Insertar.$Rut."','";
											$Insertar = $Insertar.$FechaHora."','";
											$Insertar = $Insertar.$Muestra."',";	
											$Insertar = $Insertar."'0','";	
											$Insertar = $Insertar.$CmbProductos."','";					
											$Insertar = $Insertar.$CmbSubProducto."','";			
											$Insertar = $Insertar.$CmbTipoAnalisis."','";			
											$Insertar = $Insertar.$TipoMuestra."','A',";
											$Insertar = $Insertar.$Fila2["cod_area"].",'";
											$Insertar = $Insertar.$Fila2["cod_cc"]."','";
											$Insertar = $Insertar.$Fila2["cod_periodo"]."','";
											$Insertar = $Insertar.$CmbRutPrv."',1,'";
											$Insertar = $Insertar.$FechaHora."')";	
											mysqli_query($link, $Insertar);
										}
									}
									else
									{
										//SI NO TIENE VALORES POR DEFECTO 
										if ($GrabarHum==true)
										{
											$Insertar = "insert into solicitud_analisis(rut_funcionario,fecha_hora,id_muestra,recargo,cod_producto,cod_subproducto,";
											$Insertar = $Insertar."leyes,cod_analisis,cod_tipo_muestra,tipo_solicitud,cod_periodo,rut_proveedor,agrupacion,fecha_muestra) values ('";
											$Insertar = $Insertar.$Rut."','";
											$Insertar = $Insertar.$FechaHora."','";
											$Insertar = $Insertar.$Muestra."','";	
											$Insertar = $Insertar.$Recargo."','";	
											$Insertar = $Insertar.$CmbProductos."','";					
											$Insertar = $Insertar.$CmbSubProducto."',";			
											$Insertar = $Insertar."'01~~1//','";			
											$Insertar = $Insertar.$CmbTipoAnalisis."','";			
											$Insertar = $Insertar.$TipoMuestra."','A',";
											$Insertar = $Insertar."'1','";
											$Insertar = $Insertar.$CmbRutPrv."',1,'";
											$Insertar = $Insertar.$FechaHora."')";
											mysqli_query($link, $Insertar);
										}	
										//SI FIN DE RECARGO SE CREA LA MUESTRA CON RECARGO O
										if ($Fin=='S')
										{
											$Insertar = "insert into solicitud_analisis(rut_funcionario,fecha_hora,id_muestra,recargo,cod_producto,cod_subproducto,";
											$Insertar = $Insertar."cod_analisis,cod_tipo_muestra,tipo_solicitud,cod_periodo,rut_proveedor,agrupacion,fecha_muestra) values ('";
											$Insertar = $Insertar.$Rut."','";
											$Insertar = $Insertar.$FechaHora."','";
											$Insertar = $Insertar.$Muestra."',";	
											$Insertar = $Insertar."'0','";	
											$Insertar = $Insertar.$CmbProductos."','";					
											$Insertar = $Insertar.$CmbSubProducto."','";
											$Insertar = $Insertar.$CmbTipoAnalisis."','";			
											$Insertar = $Insertar.$TipoMuestra."','A',";
											$Insertar = $Insertar."'1','";
											$Insertar = $Insertar.$CmbRutPrv."',1,'";
											$Insertar = $Insertar.$FechaHora."')";	
											mysqli_query($link, $Insertar);
										}
									}
								}
								//EsBusqueda INDICA SI SE USO LA OPCION DE BUSQUEDA. Y SI ES ASI ACTUALIZA EL REGISTRO EN REC_WEB.RECEPCIONES 
								//PARA NO VOLVER A MOSTRAR LA MUESTRA 
								if ($EsBusqueda == "S")
								{
									if (is_null($Fila["nro_solicitud"]))
									{
										$Actualizar = "UPDATE sipa_web.recepciones set activo = 'N' where lote='".$Muestra."' and recargo='".$Recargo."'";
										mysqli_query($link, $Actualizar);
									}
									else
									{
										$Actualizar = "UPDATE sipa_web.recepciones set sa_asignada=".$Fila["nro_solicitud"].",activo = 'N' where lote='".$Muestra."' and recargo='".$Recargo."'";
										mysqli_query($link, $Actualizar);
									}
								}
							}
						}
						$Muestras_Check = substr($Muestras_Check,$i+2);
						$i=0;
					}	
				}
			}		
			else//HORNADAS
			{
				for ($i=0;$i<=strlen($Muestras_Check);$i++)
				{
					if(substr($Muestras_Check,$i,4) == "~~//")
					{
						$Muestra = substr($Muestras_Check,0,$i);
						$Insertar = "insert into solicitud_analisis(rut_funcionario,fecha_hora,id_muestra,cod_producto,cod_subproducto,";
						$Insertar = $Insertar."cod_analisis,cod_tipo_muestra,tipo_solicitud,agrupacion) values ('";
						$Insertar = $Insertar.$Rut."','";
						$Insertar = $Insertar.$FechaHora."','";
						$Insertar = $Insertar.$Muestra."','";	
						$Insertar = $Insertar.$CmbProductos."','";					
						$Insertar = $Insertar.$CmbSubProducto."','";			
						$Insertar = $Insertar.$CmbTipoAnalisis."','";			
						$Insertar = $Insertar.$TipoMuestra."','A',3)";
						mysqli_query($link, $Insertar);
						if ($EsBusqueda == "S")
						{
							$Actualizar = "UPDATE sea_web.hornadas set analizada='S' where cod_producto=".$CmbProductos." and cod_subproducto=".$CmbSubProducto." and hornada_ventana=".$Muestra;
							mysqli_query($link, $Actualizar);									
						}
						$Muestras_Check = substr($Muestras_Check,$i+4);
						$i=0;
					}	
				}
			}
			break;
		case "M"://MODIFICA LOS DATOS CHEQUEADOS (CC[1],AREAS[2].PERIODO[3]) 
			for ($j = 0;$j <= strlen($Muestras); $j++)
			{
				if (substr($Muestras,$j,2) == "//")
				{
					$MuestraFechaRecargo = substr($Muestras,0,$j);
					for ($x=0;$x<=strlen($MuestraFechaRecargo);$x++)
					{
						if (substr($MuestraFechaRecargo,$x,2) == "~~")
						{
							$Muestra = substr($MuestraFechaRecargo,0,$x);			
							$Fecha = substr($MuestraFechaRecargo,$x+2,19);
							$Recargo = substr($MuestraFechaRecargo,$x+21,strlen($MuestraFechaRecargo));
							$Actualizar = "UPDATE solicitud_analisis ";
							switch ($Valor)
							{
								case "1":
									$Actualizar =$Actualizar."set cod_ccosto = '".$CmbCCosto."'";
									if ($Recargo=='N')		
									{
										$Actualizar = $Actualizar." where rut_funcionario = '".$Rut."' and fecha_hora ='".$Fecha."' and id_muestra ='".$Muestra."'";
									}
									else
									{
										$Actualizar = $Actualizar." where rut_funcionario = '".$Rut."' and fecha_hora ='".$Fecha."' and id_muestra ='".$Muestra."' and recargo='".$Recargo."'";							
									}		
									mysqli_query($link, $Actualizar);

									break;
								case "2":
									$Actualizar =$Actualizar."set cod_area = ".$CmbAreasProceso;					
									if ($Recargo=='N')		
									{
										$Actualizar = $Actualizar." where rut_funcionario = '".$Rut."' and fecha_hora ='".$Fecha."' and id_muestra ='".$Muestra."'";
									}
									else
									{
										$Actualizar = $Actualizar." where rut_funcionario = '".$Rut."' and fecha_hora ='".$Fecha."' and id_muestra ='".$Muestra."' and recargo='".$Recargo."'";							
									}		
									mysqli_query($link, $Actualizar);
									break;
							}
						}
					}
				$Muestras = substr($Muestras,$j + 2);
				$j = 0;
				}
			}					
			break;
		case "E"://ELIMINA LOS DATOS CHEQUEADOS
			for ($j = 0;$j <= strlen($Muestras); $j++)
			{
				if (substr($Muestras,$j,2) == "//")
				{
					$MuestraFechaRecargo = substr($Muestras,0,$j);
					for ($x=0;$x<=strlen($MuestraFechaRecargo);$x++)
					{
						if (substr($MuestraFechaRecargo,$x,2) == "~~")
						{
							$Muestra = substr($MuestraFechaRecargo,0,$x);			
							$Fecha = substr($MuestraFechaRecargo,$x+2,19);
							$Recargo = substr($MuestraFechaRecargo,$x+21,strlen($MuestraFechaRecargo));
							if($Recargo=='N')
							{
								$Criterio="";
							}
							else
							{
								$Criterio=" and recargo ='".$Recargo."'";
							}
							$Consulta = "select nro_solicitud from solicitud_analisis where rut_funcionario ='".$Rut."' and fecha_hora ='".$Fecha."' and id_muestra='".$Muestra."'".$Criterio;
							$Respuesta=mysqli_query($link, $Consulta);
							$Fila = mysqli_fetch_array($Respuesta);
							$NroSA = $Fila["nro_solicitud"];
							if (!is_null($NroSA) or ($NroSA!=''))
							{
								$Eliminar = "delete from estados_por_solicitud where rut_funcionario ='".$Rut."' and fecha_hora ='".$Fecha."' and nro_solicitud='".$NroSA."'".$Criterio;
								mysqli_query($link, $Eliminar);
								$Eliminar = "delete from leyes_por_solicitud where rut_funcionario ='".$Rut."' and fecha_hora ='".$Fecha."' and nro_solicitud='".$NroSA."'".$Criterio;
								mysqli_query($link, $Eliminar);
							}
								
							$Eliminar = "delete from solicitud_analisis where rut_funcionario ='".$Rut."' and fecha_hora ='".$Fecha."' and id_muestra='".$Muestra."'".$Criterio;
							mysqli_query($link, $Eliminar);
							$Eliminar = "delete from periodos_solicitud_analisis where rut_funcionario ='".$Rut."' and fecha_hora ='".$Fecha."' and id_muestra='".$Muestra."'".$Criterio;
							mysqli_query($link, $Eliminar);
							if ($Recargo!='N')
							{
								if ($Recargo=='0')
								{
									$Consulta = "select recargo from sipa_web.recepciones where lote='".$Muestra."' and ult_registro = 'S'";
									$Respuesta= mysqli_query($link, $Consulta);
									if ($Fila=mysqli_fetch_array($Respuesta))
									{
										if (!is_null($NroSA) or ($NroSA!=''))
										{
											$Eliminar = "delete from estados_por_solicitud where rut_funcionario ='".$Rut."' and fecha_hora ='".$Fecha."' and nro_solicitud='".$NroSA."' and recargo ='".$Fila["recargo"]."'";
											mysqli_query($link, $Eliminar);
											$Eliminar = "delete from leyes_por_solicitud where rut_funcionario ='".$Rut."' and fecha_hora ='".$Fecha."' and nro_solicitud='".$NroSA."' and recargo ='".$Fila["recargo"]."'";
											mysqli_query($link, $Eliminar);
										}	
										$Eliminar = "delete from solicitud_analisis where rut_funcionario ='".$Rut."' and fecha_hora ='".$Fecha."' and id_muestra='".$Muestra."' and recargo ='".$Fila["recargo"]."'";
										mysqli_query($link, $Eliminar);
										$Eliminar = "delete from periodos_solicitud_analisis where rut_funcionario ='".$Rut."' and fecha_hora ='".$Fecha."' and id_muestra='".$Muestra."' and recargo ='".$Fila["recargo"]."'";
										mysqli_query($link, $Eliminar);
										$Actualizar = "UPDATE sipa_web.recepciones set activo = 'S',sa_asignada=NULL where rut_prv ='".$CmbRutPrv."' and lote='".$Muestra."' and recargo ='".$Fila["recargo"]."'";
										mysqli_query($link, $Actualizar);
									}	
								}
								else
								{		
									$Actualizar = "UPDATE sipa_web.recepciones set activo = 'S',sa_asignada=NULL where rut_prv ='".$CmbRutPrv."' and lote='".$Muestra."' and recargo='".$Recargo."'";
									mysqli_query($link, $Actualizar);
								}	
							}
							else
							{
								$Actualizar2 = "UPDATE sea_web.hornadas set analizada = 'N' where hornada_ventana='".$Muestra."' and cod_producto='".$CmbProductos."' and cod_subproducto='".$CmbSubProducto."'";
								mysqli_query($link, $Actualizar2);
							}
						}
					}
				$Muestras = substr($Muestras,$j + 2);
				$j = 0;
				}
			}
			//SE PREGUNTA SI EXISTE ALGUNA SOLICITUD CON ESTE FUNCIONARIO Y ESTA FECHA
			//SI NO HAY REGISTRO SE PROCEDE A ELIMINAR LA OBS ASOCIADAS A LAS SOLICITUDES ELIMINADAS
			$Consulta = "select * from solicitud_analisis where rut_funcionario ='".$Rut."' and fecha_hora ='".$FechaHora."'";
			$Resultado = mysqli_query($link, $Consulta);
			if (!$Fila=mysqli_fetch_array($Resultado))
			{
				$Eliminar = "delete from solicitud_analisis_obs where rut_funcionario ='".$Rut."' and fecha_hora ='".$FechaHora."'";
				mysqli_query($link, $Eliminar);
			}
			break;
		case "G":
			//GENERA LOS NRO. DE LAS SOLICITUDES Y INSERTA UN REGISTRO CON ESTADO CREADAS DE TODOS LOS ELEMENTOS DE LA LISTA CHEQUEADOS 
			//INSERTA UN REGISTRO CON LA OBSERVACION EN LA TABLA SOLICITUD_ANALISIS_OBX
			//EL CICLO NOS ENTREGA LAS MUESTRAS SELECCIONADAS
			for ($j = 0;$j <= strlen($Muestras); $j++)
			{
				if (substr($Muestras,$j,2) == "//")
				{
					$MuestraFechaRecargo = substr($Muestras,0,$j);
					for ($x=0;$x<=strlen($MuestraFechaRecargo);$x++)
					{
						if (substr($MuestraFechaRecargo,$x,2) == "~~")
						{
							$Muestra = substr($MuestraFechaRecargo,0,$x);			
							$Fecha = substr($MuestraFechaRecargo,$x+2,19);
							$Recargo=substr($MuestraFechaRecargo,$x+21,strlen($MuestraFechaRecargo));
							$NroSA = "";
							//SI EL VALOR DEL RECARGO ES "N" ES UNA MUESTRA Y NO UN LOTE 
							if ($Recargo=='N')
							{
								$Consulta = "select nro_solicitud,leyes,impurezas,cod_tipo_muestra from solicitud_analisis  where rut_funcionario ='".$Rut."' and fecha_hora ='".$Fecha."' and id_muestra='".$Muestra."'";
								$Resultado=mysqli_query($link, $Consulta);
								$Fila = mysqli_fetch_array($Resultado);
								//SI YA FUE CREADA LA SOLICITUD NO ENTRA AL IF 
								if ((is_null($Fila["nro_solicitud"])) or ($Fila["nro_solicitud"]==''))
								{
									//SE OBTIENE EL NUMERO MAYOR DE LAS SOLICITUDES
									$Consulta = "select max(nro_solicitud) as NroMayor from solicitud_analisis";
									$Respuesta = mysqli_query($link, $Consulta);
									if ($Fila2 = mysqli_fetch_array($Respuesta))
									{
										if ((substr($Fila2["NroMayor"],0,4)) == (date("Y")))
										{
											$NroSA =$Fila2["NroMayor"]+1;										
										}
										else
										{
											$NroSA=date("Y")."000001";	
										}
									}
									else
									{
										$NroSA=date("Y")."000001";	
									}
									//SE INSERTA EL ESTADO 1(CREADAS) O 12(ENVIADA A C.CALIDAD) EN LA TABLA ESTADOS_POR_SOLICITUD
									$Insertar = "insert into estados_por_solicitud (rut_funcionario,nro_solicitud,cod_estado,fecha_hora,rut_proceso) values(";
									if ($Fila["cod_tipo_muestra"]==1)
									{
										$Actualizar = "UPDATE solicitud_analisis set nro_solicitud ='".$NroSA."',estado_actual='12',observacion='".$TxtObs."' where rut_funcionario ='".$Rut."' and fecha_hora ='".$Fecha."' and id_muestra='".$Muestra."'";
										$Insertar = $Insertar."'$Rut','$NroSA','12','$FechaHora','$Rut')";
										$Insertar2="insert into estados_por_solicitud (rut_funcionario,nro_solicitud,cod_estado,fecha_hora,rut_proceso) values(";
										$Insertar2=$Insertar2."'$Rut','$NroSA','1','$FechaHora','$Rut')";
										mysqli_query($link, $Insertar2);
									}
									else
									{
										$Actualizar = "UPDATE solicitud_analisis set nro_solicitud ='".$NroSA."',estado_actual='1',observacion='".$TxtObs."' where rut_funcionario ='".$Rut."' and fecha_hora ='".$Fecha."' and id_muestra='".$Muestra."'";
										$Insertar = $Insertar."'$Rut','$NroSA','1','$FechaHora','$Rut')";
									}
									mysqli_query($link, $Actualizar);
									mysqli_query($link, $Insertar);
								}	
							}
							else
							{
								//------>MUESTRAS CON RECARGOS
								$Consulta = "select nro_solicitud,leyes,impurezas,cod_tipo_muestra from solicitud_analisis  where rut_funcionario ='".$Rut."' and id_muestra='".$Muestra."'";
								$Resultado=mysqli_query($link, $Consulta);
								$NroSA="";
								while($Fila = mysqli_fetch_array($Resultado))
								{
									$CodTipoMuestra=$Fila["cod_tipo_muestra"];
									if ((!is_null($Fila["nro_solicitud"])) and ($Fila["nro_solicitud"]<>''))
									{									
										$NroSA=$Fila["nro_solicitud"];
										break;
									}
									
								}
								//SI YA FUE CREADA LA SOLICITUD NO ENTRA AL IF A OBTENER LA NRO. SA
								if ($NroSA=="")
								{
									//SE OBTIENE EL NUMERO MAYOR DE LAS SOLICITUDES
									$Consulta = "select max(nro_solicitud) as NroMayor from solicitud_analisis";
									$Respuesta = mysqli_query($link, $Consulta);
									if ($Fila2 = mysqli_fetch_array($Respuesta))
									{
										if ((substr($Fila2["NroMayor"],0,4)) == (date("Y")))
										{
											$NroSA =$Fila2["NroMayor"]+1;										
										}
										else
										{
											$NroSA=date("Y")."000001";	
										}
									}
									else
									{
										$NroSA=date("Y")."000001";	
									}
									
									//SE INSERTA EL ESTADO 1(CREADAS) O 12(ENVIADA A C.CALIDAD) EN LA TABLA ESTADOS_POR_SOLICITUD
									$Insertar = "insert into estados_por_solicitud (rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,rut_proceso) values(";
									if ($CodTipoMuestra==1)
									{
										$Actualizar = "UPDATE solicitud_analisis set nro_solicitud =".$NroSA.",estado_actual='12',observacion='".$TxtObs."' where rut_funcionario ='".$Rut."' and fecha_hora ='".$Fecha."' and id_muestra='".$Muestra."' and recargo='".$Recargo."'";
										$Insertar = $Insertar."'$Rut','$NroSA','$Recargo','12','$FechaHora','$Rut')";
										$Insertar2="insert into estados_por_solicitud (rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,rut_proceso) values(";
										$Insertar2=$Insertar2."'$Rut','$NroSA','$Recargo','1','$FechaHora','$Rut')";
										mysqli_query($link, $Insertar2);
									}
									else
									{
										$Actualizar = "UPDATE solicitud_analisis set nro_solicitud =".$NroSA.",estado_actual='1',observacion='".$TxtObs."' where rut_funcionario ='".$Rut."' and fecha_hora ='".$Fecha."' and id_muestra='".$Muestra."' and recargo='".$Recargo."'";
										$Insertar = $Insertar."'$Rut','$NroSA','$Recargo','1','$FechaHora','$Rut')";
									}
									mysqli_query($link, $Actualizar);
									mysqli_query($link, $Insertar);
									//ACTUALIZA EL CAMPO SA_ASIGNADO DE LA TABLA REC_WEB.RECEPCIONES
									$Actualizar = "UPDATE sipa_web.recepciones set sa_asignada = ".$NroSA." where lote='".$Muestra."' and recargo='".$Recargo."'";
									mysqli_query($link, $Actualizar);
								}	
								else
								{
									//A LA MUESTRA CON RECARGO LE PONE EL NRO SOLICITUD DE ALGUN RECARGO
									//ANTERIOR DE LA MISMA MUESTRA
									$Consulta = "select nro_solicitud,leyes,impurezas,cod_tipo_muestra from solicitud_analisis  where rut_funcionario ='".$Rut."' and fecha_hora ='".$Fecha."' and id_muestra='".$Muestra."' and recargo='".$Recargo."'";
									$Respuesta = mysqli_query($link, $Consulta);
									$Fila=mysqli_fetch_array($Respuesta);
									if ((is_null($Fila["nro_solicitud"]))or($Fila["nro_solicitud"]==''))
									{
										//SE INSERTA EL ESTADO 1(CREADAS) O 3(ENVIADA A C.CALIDAD) EN LA TABLA ESTADOS_POR_SOLICITUD
										$Insertar = "insert into estados_por_solicitud (rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,rut_proceso) values(";
										if ($Fila["cod_tipo_muestra"]==1)
										{
											$Actualizar = "UPDATE solicitud_analisis set nro_solicitud ='".$NroSA."',estado_actual='12',observacion='".$TxtObs."' where rut_funcionario ='".$Rut."' and fecha_hora ='".$Fecha."' and id_muestra='".$Muestra."' and recargo='".$Recargo."'";
											$Insertar = $Insertar."'$Rut','$NroSA','$Recargo','12','$FechaHora','$Rut')";
											$Insertar2="insert into estados_por_solicitud (rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,rut_proceso) values(";
											$Insertar2=$Insertar2."'$Rut','$NroSA','$Recargo','1','$FechaHora','$Rut')";
											mysqli_query($link, $Insertar2);
										}
										else
										{
											$Actualizar = "UPDATE solicitud_analisis set nro_solicitud ='".$NroSA."',estado_actual='1',observacion='".$TxtObs."' where rut_funcionario ='".$Rut."' and fecha_hora ='".$Fecha."' and id_muestra='".$Muestra."' and recargo='".$Recargo."'";
											$Insertar = $Insertar."'$Rut','$NroSA','$Recargo','1','$FechaHora','$Rut')";
										}
										mysqli_query($link, $Actualizar);
										mysqli_query($link, $Insertar);
										$Actualizar = "UPDATE sipa_web.recepciones set sa_asignada = ".$NroSA." where lote='".$Muestra."' and recargo='".$Recargo."'";
										mysqli_query($link, $Actualizar);
									}
									else
									{
										$NroSA="";
									}  
								}
							}	
							//SE BORRAN Y DESPUES SE INSERTAN LAS LEYES ALMACENADAS EN EL CAMPO LEYES DE LA TABLA
							//SOLICITUDES_ANALISIS EN LA TABLA LEYES_POR_SOLICITUD
							if ($Recargo=='N')
							{
								$Consulta="select  * from cal_web.solicitud_analisis where rut_funcionario ='".$Rut."' and fecha_hora ='".$Fecha."' and id_muestra='".$Muestra."'";
								$Respuesta = mysqli_query($link, $Consulta);
								$Fila=mysqli_fetch_array($Respuesta);
								$Eliminar = "delete from leyes_por_solicitud where rut_funcionario ='".$Rut."' and fecha_hora ='".$Fecha."' and nro_solicitud = '".$Fila["nro_solicitud"]."'";
							}
							else
							{
								$Consulta="select  * from cal_web.solicitud_analisis where rut_funcionario ='".$Rut."' and fecha_hora ='".$Fecha."' and id_muestra='".$Muestra."' and recargo='".$Recargo."'";
								$Respuesta = mysqli_query($link, $Consulta);
								$Fila=mysqli_fetch_array($Respuesta);
								$Eliminar = "delete from leyes_por_solicitud where rut_funcionario ='".$Rut."' and fecha_hora ='".$Fecha."' and nro_solicitud = '".$Fila["nro_solicitud"]."' and recargo='".$Recargo."'";	
							}	
							mysqli_query($link, $Eliminar);
							if (!is_null($Fila["leyes"]) or ($Fila["leyes"] !=''))
							{
								$Leyes =$Fila["leyes"];
								for ($k = 0;$k <= strlen($Leyes); $k++)
								{
									if (substr($Leyes,$k,2) == "//")
									{
										$LeyesUnidades = substr($Leyes,0,$k);
										for ($f=0;$f<=strlen($LeyesUnidades);$f++)
										{
											if (substr($LeyesUnidades,$f,2) == "~~")
											{
												$Ley = substr($LeyesUnidades,0,$f);			
												$Unidad = substr($LeyesUnidades,$f+2,strlen($LeyesUnidades));
												if($Recargo=='N')
												{
													$Insertar = "insert into leyes_por_solicitud (rut_funcionario,fecha_hora,nro_solicitud,cod_leyes,cod_unidad,cod_producto,cod_subproducto,id_muestra) values ('$Rut','$Fecha','".$Fila["nro_solicitud"]."','$Ley','$Unidad','$CmbProductos','$CmbSubProducto','$Muestra')";
												}
												else
												{
													$Insertar = "insert into leyes_por_solicitud (rut_funcionario,fecha_hora,nro_solicitud,recargo,cod_leyes,cod_unidad,cod_producto,cod_subproducto,id_muestra) values ('$Rut','$Fecha','".$Fila["nro_solicitud"]."','$Recargo','$Ley','$Unidad','$CmbProductos','$CmbSubProducto','$Muestra')";												
												}													
												mysqli_query($link, $Insertar);
											}
										}
									$Leyes = substr($Leyes,$k + 2);
									$k = 0;
									}
								}		
							}//SE INSERTAN LAS IMPUREZAS ALMACENADAS EN EL CAMPO IMPUREZAS DE LA TABLA SOLICITUDES_ANALISIS 
							//EN LA TABLA LEYES_POR_SOLICITUD									
							$Impurezas =$Fila["impurezas"];
							if (!is_null($Fila["impurezas"]) or ($Fila["impurezas"] !=''))
							{
								for ($k = 0;$k <= strlen($Impurezas); $k++)
								{
									if (substr($Impurezas,$k,2) == "//")
									{
										$ImpurezasUnidades = substr($Impurezas,0,$k);
										for ($f=0;$f<=strlen($ImpurezasUnidades);$f++)
										{
											if (substr($ImpurezasUnidades,$f,2) == "~~")
											{
												$Impureza = substr($ImpurezasUnidades,0,$f);			
												$Unidad = substr($ImpurezasUnidades,$f+2,strlen($ImpurezasUnidades));
												if($Recargo=='N')
												{
													$Insertar = "insert into leyes_por_solicitud (rut_funcionario,fecha_hora,nro_solicitud,cod_leyes,cod_unidad,cod_producto,cod_subproducto,id_muestra) values ('$Rut','$Fecha','".$Fila["nro_solicitud"]."','$Impureza','$Unidad','$CmbProductos','$CmbSubProducto','$Muestra')";
												}
												else
												{
													$Insertar = "insert into leyes_por_solicitud (rut_funcionario,fecha_hora,nro_solicitud,recargo,cod_leyes,cod_unidad,cod_producto,cod_subproducto,id_muestra) values ('$Rut','$Fecha','".$Fila["nro_solicitud"]."','$Recargo','$Impureza','$Unidad','$CmbProductos','$CmbSubProducto','$Muestra')";												
												}													
												mysqli_query($link, $Insertar);
											}
										}
									$Impurezas = substr($Impurezas,$k + 2);
									$k = 0;
									}
								}
							}
						}
					}
				$Muestras = substr($Muestras,$j + 2);
				$j = 0;
				}
			}
			/*$Consulta="select  * from solicitud_analisis_obs where rut_funcionario ='".$Rut."' and fecha_hora ='".$FechaHora."'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Fila=mysqli_fetch_array($Respuesta))
			{
				$Actualizar = "UPDATE solicitud_analisis_obs set observacion = '$TxtObs' where rut_funcionario ='".$Rut."' and fecha_hora ='".$FechaHora."'";
				mysqli_query($link, $Actualizar);
			}
			else
			{
				$Insertar = "insert into solicitud_analisis_obs (rut_funcionario,fecha_hora,cod_producto,cod_subproducto,Observacion) values ('$Rut','$Fecha','$CmbProductos','$CmbSubProducto','$TxtObs')";
				mysqli_query($link, $Insertar);
			}*/
			break;
			case "B":
				$Datos=explode('//',$Muestras_Check);
				while(list($c,$v)=each($Datos))
				{
					$Datos2=explode('~~',$v);
					$Muestra = $Datos2[0];
					$Recargo = $Datos2[1];
					$Actualizar="UPDATE sipa_web.recepciones set activo = 'N' where lote ='".$Muestra."' and recargo='".$Recargo."'";
					mysqli_query($link, $Actualizar);
				}
				break;
			case "C":
				$Actualizar="UPDATE sipa_web.recepciones set ult_registro='S' where lote ='".$Lote_a."' and recargo='".$Recarg_a."'";
				mysqli_query($link, $Actualizar);
				break;
	}
	if ($Entrar==true)
	{
		if (isset($Modificando))
		{
			header ("location:cal_solicitud_automatica.php?Productos=".$CmbProductos."&SubProducto=".$CmbSubProducto."&FechaBusqueda=".$FechaHora."&Modificar=".$Modificando."&ValorCheck=".$ValCheck."&TxtSolicitudOculta=".$TxtSolicitudOculta);
		}
		else
		{
			if (isset($Asignado))
			{
				echo "<script languaje='JavaScript'>";
				echo "window.opener.document.FrmSolicitudAut.action='cal_solicitud_Automatica.php?CmbProductos=".$CmbProductos."&CmbSubProducto=".$CmbSubProducto."&Buscar=".$BuscarDetalle."&BuscarPrv=".$BuscarPrv."';";
				echo "window.opener.document.FrmSolicitudAut.submit();";
				echo "window.close();</script>";
			}	
			else
			{
				header ("location:cal_solicitud_automatica.php?CmbProductos=".$CmbProductos."&CmbSubProducto=".$CmbSubProducto."&CmbTipoAnalisis=".$CmbTipoAnalisis."&ValorAnalisis=".$ValorAnalisis."&ValorMuestreo=".$ValorMuestreo."&FechaHora=".$FechaHora."&ValorCheck=".$ValCheck."&TxtNomPrv=".$TxtNomPrv."&Buscar=S&BuscarPrv=S&CmbRutPrv=".$CmbRutPrv."&TxtSolicitudOculta=".$TxtSolicitudOculta);
			}	
		}
	}	
?>