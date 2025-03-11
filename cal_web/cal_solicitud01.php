<?php 
	$CodigoDeSistema=1;
	include ("../Principal/conectar_principal.php");
	$CookieRut = $_COOKIE["CookieRut"];	
	$proceso   = isset($_REQUEST["proceso"])?$_REQUEST["proceso"]:'';
	$ValorAnalisis   = isset($_REQUEST["ValorAnalisis"])?$_REQUEST["ValorAnalisis"]:'';
	$ValorMuestreo   = isset($_REQUEST["ValorMuestreo"])?$_REQUEST["ValorMuestreo"]:'';
	$Muestras   = isset($_REQUEST["Muestras"])?$_REQUEST["Muestras"]:'';
	$Valor   = isset($_REQUEST["Valor"])?$_REQUEST["Valor"]:'';
	$Periodo = isset($_REQUEST["Periodo"])?$_REQUEST["Periodo"]:'';
	$CmbAgrupacion = isset($_REQUEST["CmbAgrupacion"])?$_REQUEST["CmbAgrupacion"]:'';
	$CmbTipo = isset($_REQUEST["CmbTipo"])?$_REQUEST["CmbTipo"]:'';
	$Enabal = isset($_REQUEST["Enabal"])?$_REQUEST["Enabal"]:'';
	$TxtMuestra = isset($_REQUEST["TxtMuestra"])?$_REQUEST["TxtMuestra"]:'';
	$CmbCCosto = isset($_REQUEST["CmbCCosto"])?$_REQUEST["CmbCCosto"]:'';
	$CmbAreasProceso = isset($_REQUEST["CmbAreasProceso"])?$_REQUEST["CmbAreasProceso"]:'';
	$CmbPeriodo = isset($_REQUEST["CmbPeriodo"])?$_REQUEST["CmbPeriodo"]:'';
	$TxtObs = isset($_REQUEST["TxtObs"])?$_REQUEST["TxtObs"]:'';
	$Modificando = isset($_REQUEST["Modificando"])?$_REQUEST["Modificando"]:'';
	$CmbProductos = isset($_REQUEST["CmbProductos"])?$_REQUEST["CmbProductos"]:'';
	$CmbSubProducto = isset($_REQUEST["CmbSubProducto"])?$_REQUEST["CmbSubProducto"]:'';
	$CmbTipoAnalisis = isset($_REQUEST["CmbTipoAnalisis"])?$_REQUEST["CmbTipoAnalisis"]:'';
	$FechaHora = isset($_REQUEST["FechaHora"])?$_REQUEST["FechaHora"]:'';
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
	$control = 0;
    //$FechaHora = date("Y-m-d H:i");
	$Entrar=true;//USADO PARA NO HACER DOS HEADER CON LA OPCION L Y S(TIENES SUS PROPIOS HEADER)
	switch ($proceso)
	{
		case "P"://PERIODO HOY
			$control = 2;
			for ($j = 0;$j <= strlen($Muestras); $j++)
			{
				if (substr($Muestras,$j,2) == "//")
				{
					$MuestraFecha = substr($Muestras,0,$j);
					for ($x=0;$x<=strlen($MuestraFecha);$x++)
					{
						if (substr($MuestraFecha,$x,2) == "~~")
						{
							$Muestra = substr($MuestraFecha,0,$x);			
							$Fecha = substr($MuestraFecha,$x+2,19);
							$Eliminar="delete from cal_web.periodos_solicitud_analisis where rut_funcionario ='".$Rut."' and fecha_hora='".$Fecha."' and id_muestra ='".$Muestra."'";	
							mysqli_query($link, $Eliminar);
							$Insertar = "insert into cal_web.periodos_solicitud_analisis (rut_funcionario,fecha_hora,id_muestra,cod_periodo) values ('$Rut','$Fecha','$Muestra','$Periodo')";
							mysqli_query($link, $Insertar);
							$Actualizar = "UPDATE cal_web.solicitud_analisis set cod_periodo='".$Periodo."'";
							$Actualizar = $Actualizar." where rut_funcionario = '".$Rut."' and fecha_hora ='".$Fecha."' and id_muestra ='".$Muestra."'";
							mysqli_query($link, $Actualizar);
						}
					}
				$Muestras = substr($Muestras,$j + 2);
				$j = 0;
				}
			}					
			break;			
		case "L":
			$control = 3;
			if ($Pagina != "")
			{
				header("location:cal_solicitud.php?poly=4&Pagina=".$Pagina."&".$Variables);		
			}
			else
			{
				header("location:cal_solicitud.php?poly=5");
			}
			$Entrar=false;
			break;
		case "S":
			header("location:../principal/sistemas_usuario.php?CodSistema=1");
			$Entrar=false;
			break;
		case "N"://INGRESA UN NUEVO REGISTRO EN SOLICITUD ANALISIS
		
			$Consulta="select id_muestra from cal_web.solicitud_analisis where id_muestra='".$TxtMuestra."' and year(fecha_hora) = YEAR(curdate())";
			$Resultado = mysqli_query($link, $Consulta);
			if ($Fila=mysqli_fetch_array($Resultado))
			{		
					$MsjIdMuestra="S";
				//header ("location:cal_solicitud.php?poly=".$control."&CmbProductos=".$CmbProductos."&CmbSubProducto=".$CmbSubProducto."&CmbTipoAnalisis=".$CmbTipoAnalisis."&ValorAnalisis=".$ValorAnalisis."&ValorMuestreo=".$ValorMuestreo."&FechaHora=".$FechaHora."&ValorCheck=".$ValCheck."&MsjIdMuestra=".$MsjIdMuestra);		

			}
			else
			{
				$MsjIdMuestra="N";
			}

			if ($MsjIdMuestra=="N")
			{
					$control = 4;
					$TxtMuestra=str_replace('~','-',$TxtMuestra);
					$TxtMuestra=str_replace('/','-',$TxtMuestra);
					$TxtMuestra=str_replace('|','-',$TxtMuestra);
					$TxtMuestra=str_replace('','-',$TxtMuestra);
					$TxtMuestra=str_replace('�','-',$TxtMuestra);
					$TxtMuestra=str_replace('�','-',$TxtMuestra);
					$TxtMuestra=str_replace('@','-',$TxtMuestra);
					$Insertar = "insert into cal_web.solicitud_analisis(rut_funcionario,fecha_hora,id_muestra,cod_producto,cod_subproducto,";
					$Insertar = $Insertar."cod_analisis,cod_tipo_muestra,tipo_solicitud,agrupacion,tipo,enabal) values ('";
					$Insertar = $Insertar.$Rut."','";
					$Insertar = $Insertar.$FechaHora."','";
					$Insertar = $Insertar.$TxtMuestra."','";	
					$Insertar = $Insertar.$CmbProductos."','";					
					$Insertar = $Insertar.$CmbSubProducto."','";			
					$Insertar = $Insertar.$CmbTipoAnalisis."','";			
					$Insertar = $Insertar.$TipoMuestra."','R','$CmbAgrupacion','$CmbTipo','$Enabal')";
					//echo "QUERY:".$Insertar."<br>";
					mysqli_query($link, $Insertar);
			}

			break;
		case "M"://MODIFICA LOS DATOS CHEQUEADOS (CC[1],AREAS[2].PERIODO[3]) 
			$control = 5;
			for ($j = 0;$j <= strlen($Muestras); $j++)
			{
				if (substr($Muestras,$j,2) == "//")
				{
					$MuestraFecha = substr($Muestras,0,$j);
					for ($x=0;$x<=strlen($MuestraFecha);$x++)
					{
						if (substr($MuestraFecha,$x,2) == "~~")
						{
							$Muestra = substr($Muestras,0,$x);			
							$Fecha = substr($Muestras,$x+2,19);
							$Actualizar = "UPDATE cal_web.solicitud_analisis ";
							switch ($Valor)
							{
								case "1":
									$Actualizar =$Actualizar."set cod_ccosto = '".$CmbCCosto."'";
									break;
								case "2":
									$Actualizar =$Actualizar."set cod_area ='".$CmbAreasProceso."'";					
									break;
								case "3":
									$Actualizar =$Actualizar."set cod_periodo ='".$CmbPeriodo."'";					
									break;
							}		
							$Actualizar = $Actualizar." where rut_funcionario ='".$Rut."' and fecha_hora ='".$Fecha."' and id_muestra ='".$Muestra."'";
							mysqli_query($link, $Actualizar);
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
					$MuestraFecha = substr($Muestras,0,$j);
					for ($x=0;$x<=strlen($MuestraFecha);$x++)
					{
						if (substr($MuestraFecha,$x,2) == "~~")
						{
							$Muestra = substr($MuestraFecha,0,$x);			
							$Fecha = substr($MuestraFecha,$x+2,19);
							$Consulta = "select nro_solicitud from cal_web.solicitud_analisis where rut_funcionario ='".$Rut."' and fecha_hora ='".$Fecha."' and id_muestra='".$Muestra."'";
							$Respuesta=mysqli_query($link, $Consulta);
							$Fila = mysqli_fetch_array($Respuesta);
							$NroSA = $Fila["nro_solicitud"];
							if (!is_null($NroSA) or ($NroSA!=''))
							{
								$Eliminar = "delete from cal_web.estados_por_solicitud where rut_funcionario ='".$Rut."' and fecha_hora ='".$Fecha."' and nro_solicitud='".$NroSA."'";
								mysqli_query($link, $Eliminar);
								$Eliminar = "delete from cal_web.leyes_por_solicitud where rut_funcionario ='".$Rut."' and fecha_hora ='".$Fecha."' and nro_solicitud='".$NroSA."'";
								mysqli_query($link, $Eliminar);
							}	
							$Eliminar = "delete from cal_web.solicitud_analisis where rut_funcionario ='".$Rut."' and fecha_hora ='".$Fecha."' and id_muestra='".$Muestra."'";
							mysqli_query($link, $Eliminar);
							$Eliminar = "delete from cal_web.periodos_solicitud_analisis where rut_funcionario ='".$Rut."' and fecha_hora ='".$Fecha."' and id_muestra='".$Muestra."'";
							mysqli_query($link, $Eliminar);
						}
					}
				$Muestras = substr($Muestras,$j + 2);
				$j = 0;
				}
			}
			//SE PREGUNTA SI EXISTE ALGUNA SOLICITUD CON ESTE FUNCIONARIO Y ESTA FECHA
			//SI NO HAY REGISTRO SE PROCEDE A ELIMINAR LA OBS ASOCIADAS A LAS SOLICITUDES ELIMINADAS
			$Consulta = "select * from cal_web.solicitud_analisis where rut_funcionario ='".$Rut."' and fecha_hora ='".$FechaHora."'";
			$Resultado = mysqli_query($link, $Consulta);
			if (!$Fila=mysqli_fetch_array($Resultado))
			{
				$Eliminar = "delete from cal_web.solicitud_analisis_obs where rut_funcionario ='".$Rut."' and fecha_hora ='".$FechaHora."'";
				mysqli_query($link, $Eliminar);
			}
			break;
		case "G":
					$control = 6;

			//GENERA LOS NRO. DE LAS SOLICITUDES Y INSERTA UN REGISTRO CON ESTADO CREADAS DE TODOS LOS ELEMENTOS DE LA LISTA CHEQUEADOS 
			//INSERTA UN REGISTRO CON LA OBSERVACION EN LA TABLA SOLICITUD_ANALISIS_OBX
			for ($j = 0;$j <= strlen($Muestras); $j++)
			{
				if (substr($Muestras,$j,2) == "//")
				{
					$MuestraFecha = substr($Muestras,0,$j);
					for ($x=0;$x<=strlen($MuestraFecha);$x++)
					{
						if (substr($MuestraFecha,$x,2) == "~~")
						{
							$Muestra = substr($MuestraFecha,0,$x);			
							$Fecha = substr($MuestraFecha,$x+2,19);
							$NroSA = "";
							$Consulta = "select nro_solicitud,leyes,impurezas,cod_tipo_muestra from cal_web.solicitud_analisis  where rut_funcionario ='".$Rut."' and fecha_hora ='".$Fecha."' and id_muestra='".$Muestra."'";
							$Resultado=mysqli_query($link, $Consulta);
							$Fila = mysqli_fetch_array($Resultado);
							if ((is_null($Fila["nro_solicitud"])) or ($Fila["nro_solicitud"]==''))
							{
								//SE OBTIENE EL NUMERO MAYOR DE LAS SOLICITUDES
								$Consulta = "select max(nro_solicitud) as NroMayor from cal_web.solicitud_analisis";
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
								$Insertar = "insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,cod_estado,fecha_hora,rut_proceso) values(";
								if ($Fila["cod_tipo_muestra"]==1)
								{
									$Actualizar = "UPDATE cal_web.solicitud_analisis set nro_solicitud =".$NroSA.",estado_actual='12' where rut_funcionario ='".$Rut."' and fecha_hora ='".$Fecha."' and id_muestra='".$Muestra."'";
									$Insertar=$Insertar."'$Rut','$NroSA','12','$FechaHora','$Rut')";
									$Insertar2="insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,cod_estado,fecha_hora,rut_proceso) values(";
									$Insertar2=$Insertar2."'$Rut','$NroSA','1','$FechaHora','$Rut')";
									mysqli_query($link, $Insertar2);
								}
								else
								{
									$Actualizar = "UPDATE cal_web.solicitud_analisis set nro_solicitud =".$NroSA.",estado_actual='1' where rut_funcionario ='".$Rut."' and fecha_hora ='".$Fecha."' and id_muestra='".$Muestra."'";
									$Insertar = $Insertar."'$Rut','$NroSA','1','$FechaHora','$Rut')";
								}
								mysqli_query($link, $Actualizar);
								mysqli_query($link, $Insertar);
							}
							$Actualizar = "UPDATE cal_web.solicitud_analisis set observacion='".$TxtObs."' where rut_funcionario ='".$Rut."' and fecha_hora ='".$Fecha."' and id_muestra='".$Muestra."'";
							mysqli_query($link, $Actualizar);
							//SE BORRAN Y DESPUES SE INSERTAN LAS LEYES ALMACENADAS EN EL CAMPO LEYES DE LA TABLA
							//SOLICITUDES_ANALISIS EN LA TABLA LEYES_POR_SOLICITUD
							if ($NroSA=="")
							{
								$NroSA = $Fila["nro_solicitud"];
								$Eliminar = "delete from cal_web.leyes_por_solicitud where rut_funcionario ='".$Rut."' and fecha_hora ='".$Fecha."' and nro_solicitud = ".$NroSA."";
								mysqli_query($link, $Eliminar);
							}
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
												$Insertar = "insert into cal_web.leyes_por_solicitud (rut_funcionario,fecha_hora,nro_solicitud,cod_leyes,cod_unidad,cod_producto,cod_subproducto,id_muestra) values ('$Rut','$Fecha','$NroSA','$Ley','$Unidad','$CmbProductos','$CmbSubProducto','$Muestra')";
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
												$Insertar = "insert into cal_web.leyes_por_solicitud (rut_funcionario,fecha_hora,nro_solicitud,cod_leyes,cod_unidad,cod_producto,cod_subproducto,id_muestra) values ('$Rut','$Fecha','$NroSA','$Impureza','$Unidad','$CmbProductos','$CmbSubProducto','$Muestra')";
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
		case "A"://ASIGNAR RECARGOS A LA SOLICITUD	
			$CantRecargosAux = $CantRecargos;
			$control= 9;
			for ($j = 0;$j <= strlen($Muestras); $j++)
			{
				if (substr($Muestras,$j,2) == "//")
				{
					$MuestraFecha = substr($Muestras,0,$j);
					for ($x=0;$x<=strlen($MuestraFecha);$x++)
					{
						if (substr($MuestraFecha,$x,2) == "~~")
						{
							$Muestra = substr($MuestraFecha,0,$x);										
							$Fecha = substr($MuestraFecha,$x+2,19);
							$Actualizar ="UPDATE cal_web.solicitud_analisis set tipo_solicitud='A',recargo='0' where rut_funcionario ='".$Rut."' and fecha_hora ='".$Fecha."' and id_muestra='".$Muestra."'";
							mysqli_query($link, $Actualizar);
							$Actualizar ="UPDATE cal_web.leyes_por_solicitud set recargo ='0' where rut_funcionario ='".$Rut."' and fecha_hora ='".$Fecha."' and id_muestra='".$Muestra."'";
							mysqli_query($link, $Actualizar);
							$Consulta = "select * from cal_web.solicitud_analisis where rut_funcionario ='".$Rut."' and fecha_hora ='".$Fecha."' and id_muestra='".$Muestra."' and recargo = '0'";
							$Respuesta=mysqli_query($link, $Consulta);
							$Fila = mysqli_fetch_array($Respuesta);
							$CmbProductos = $Fila["cod_producto"];
							$CmbSubProducto= $Fila["cod_subproducto"];
							$FechaHora= $Fecha;

							$Actualizar ="UPDATE cal_web.leyes_por_solicitud set recargo ='0' where rut_funcionario ='".$Rut."' and fecha_hora ='".$Fecha."'  and nro_solicitud = '".$Fila["nro_solicitud"]."'";
							mysqli_query($link, $Actualizar);
							$Actualizar ="UPDATE cal_web.estados_por_solicitud set recargo ='0' where rut_funcionario ='".$Rut."' and fecha_hora ='".$Fecha."'  and nro_solicitud = '".$Fila["nro_solicitud"]."'";
							mysqli_query($link, $Actualizar);
							$CantRecargos = $CantRecargosAux;
							if (substr($CantRecargos,strlen($CantRecargos),1)!=",")
							{
								$CantRecargos=$CantRecargos.",";								
							}							
							for ($i=1;$i<strlen($CantRecargos);$i++)
							{
								if (substr($CantRecargos,$i,1)==",")
								{
									$Recargo=substr($CantRecargos,0,$i);
									if ((is_null($Fila["peso_retalla"]))||($Fila["peso_retalla"]==""))
									{
										$PesoR = "NULL";
									}
									else
									{
										$PesoR = $Fila["peso_retalla"];
									}
									if ((is_null($Fila["nro_semana"]))||($Fila["nro_semana"]==""))
									{
										$NroSemana="NULL";
									}
									else
									{
										$NroSemana=$Fila["nro_semana"];
									}
									if ((is_null($Fila["año"]))||($Fila["año"]==""))
									{
										$Año="NULL";
									}
									else
									{
										$Año=$Fila["año"];
									}
									if ((is_null($Fila["mes"]))||($Fila["mes"]==""))
									{
										$Mes="NULL";
									}
									else
									{
										$Mes=$Fila["mes"];
									}
									if ((is_null($Fila["peso_muestra"]))||($Fila["peso_muestra"]==""))
									{
										$PesoM="NULL";
									}
									else
									{
										$PesoM=$Fila["peso_muestra"];
									}
									$insertar = "insert into cal_web.solicitud_analisis(rut_funcionario,fecha_hora,id_muestra,peso_muestra,recargo,";
									$insertar =$insertar." cod_producto,cod_subproducto,leyes,cod_analisis,cod_tipo_muestra,tipo_solicitud,";
									$insertar =$insertar." nro_solicitud,cod_area,cod_ccosto,cod_periodo,estado_actual,rut_proveedor,peso_retalla,observacion,agrupacion,fecha_muestra,nro_semana,año,mes,tipo)";
									$insertar =$insertar." values ('".$Fila["rut_funcionario"]."','".$Fila["fecha_hora"]."','".$Fila["id_muestra"]."',".$PesoM.",";
									$insertar =$insertar." '".$Recargo."','".$Fila["cod_producto"]."','".$Fila["cod_subproducto"]."','01~~1//',";
									$insertar =$insertar." '".$Fila["cod_analisis"]."','".$Fila["cod_tipo_muestra"]."','".$Fila["tipo_solicitud"]."',";
									$insertar =$insertar." '".$Fila["nro_solicitud"]."','".$Fila["cod_area"]."','".$Fila["cod_ccosto"]."','".$Fila["cod_periodo"]."',";
									$insertar =$insertar." '".$Fila["estado_actual"]."','".$Fila["rut_proveedor"]."',".$PesoR.",'".$Fila["observacion"]."', ";
									$insertar =$insertar." '".$Fila["agrupacion"]."','".$Fila["fecha_muestra"]."',".$NroSemana.",".$Año.",".$Mes.",".$Fila["tipo"].")";
									//echo $insertar."<br>";
									mysqli_query($link, $insertar);
									$insertar ="insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,ult_atencion,rut_proceso)";
									$insertar.="values ('".$Fila["rut_funcionario"]."','".$Fila["nro_solicitud"]."','".$Recargo."','1','".$Fila["fecha_hora"]."','N','".$Rut."')";
									mysqli_query($link, $insertar);		
									if ($Fila["estado_actual"]=='12')
									{
										//para estados por solictud
										$insertar ="insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,ult_atencion,rut_proceso)";
										$insertar.="values ('".$Fila["rut_funcionario"]."','".$Fila["nro_solicitud"]."','".$Recargo."','".$Fila["estado_actual"]."','".$Fila["fecha_hora"]."','N','".$Rut."')";
										mysqli_query($link, $insertar);		
									}
									$insertar = "insert into cal_web.leyes_por_solicitud (rut_funcionario,fecha_hora,nro_solicitud,";
									$insertar.=" cod_leyes,cod_unidad,cod_producto,cod_subproducto,id_muestra,recargo) values ('".$Fila["rut_funcionario"]."','".$Fila["fecha_hora"]."',";
									$insertar.=" '".$Fila["nro_solicitud"]."','01','1','".$Fila["cod_producto"]."','".$Fila["cod_subproducto"]."','".$Fila["id_muestra"]."',".$Recargo.")";
									mysqli_query($link, $insertar);
									$CantRecargos=substr($CantRecargos,$i+1);
									$i=0;	
								}
							}
							$NroSA = $Fila["nro_solicitud"];
						}
					}
				$Muestras = substr($Muestras,$j + 2);
				$j = 0;
				}
			}
			/*echo "<script languaje='JavaScript'>";
			echo "document.FrmSolicitud.action='cal_solicitud.php?poly=1&CmbProductos=".$CmbProductos."&CmbSubProducto=".$CmbSubProducto."&CmbTipoAnalisis=".$CmbTipoAnalisis."&ValorAnalisis=".$ValorAnalisis."&ValorMuestreo=".$ValorMuestreo."&FechaHora=".$FechaHora."&ValorCheck=".$ValCheck."';";
			echo "document.FrmSolicitud.submit();";
			echo "</script>";
			break;*/
	}

	if ($control==9)
	{
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.FrmSolicitud.action='cal_solicitud.php?CmbProductos=".$CmbProductos."&CmbSubProducto=".$CmbSubProducto."&CmbTipoAnalisis=".$CmbTipoAnalisis."&ValorAnalisis=".$ValorAnalisis."&ValorMuestreo=".$ValorMuestreo."&FechaHora=".$FechaHora."&ValorCheck=".$ValCheck."';";
			echo "window.opener.document.FrmSolicitud.submit();";
			echo "window.close();</script>";
			
	}		


	if ($Entrar==true)
	{
		if ($Modificando!="")
		{
		
			header ("location:cal_solicitud.php?poly=2&Productos=".$CmbProductos."&SubProducto=".$CmbSubProducto."&FechaBusqueda=".$FechaHora."&Modificar=".$Modificando."&ValorCheck=".$ValCheck);
		}
		else
		{ 
		
			header ("location:cal_solicitud.php?poly=".$control."&CmbProductos=".$CmbProductos."&CmbSubProducto=".$CmbSubProducto."&CmbTipoAnalisis=".$CmbTipoAnalisis."&ValorAnalisis=".$ValorAnalisis."&ValorMuestreo=".$ValorMuestreo."&FechaHora=".$FechaHora."&ValorCheck=".$ValCheck."&MsjIdMuestra=".$MsjIdMuestra);	
		}	
	}	
?>
<html>
<head>
<title></title>
</head>
<body>
</body>
</html>
