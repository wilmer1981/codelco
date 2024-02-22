<?php 
	include ("../Principal/conectar_cal_web.php");
	$TipoMuestra = "";
	$ValCheck = $Muestras;//RECIBE LOS ELEMENTOS CHEQUEADOS PARA VOLVERLOS A MARCAR
	$Rut = $CookieRut;
	$Entrar=true;//USADO PARA NO HACER DOS HEADER CON LA OPCION L Y S(TIENES SUS PROPIOS HEADER)
	switch ($proceso)
	{
		case "L":
			if ($Pagina != "")
			{
				header("location:cal_solicitud_rutinaria.php?Pagina=".$Pagina."&".$Variables);		
			}
			else
			{
				header("location:cal_solicitud_rutinaria.php");
			}
			$Entrar=false;
			break;
		case "S":
			header("location:../principal/sistemas_usuario.php?CodSistema=1");
			$Entrar=false;
			break;
		case "N"://INSERTA LOS DATOS DE LA PLANTILLA DE LA SOLICITUD
			$Entrar=false;
			$Consulta="select * from cal_web.plantilla_solicitud_analisis ";
			$Consulta=$Consulta." where cod_producto=".$CmbProductos." and cod_subproducto=".$CmbSubProducto." and fecha_hora='".$FechaTraspaso."'";
			$Resultado=mysqli_query($link, $Consulta);
			while ($Fila=mysqli_fetch_array($Resultado))
			{
				$Insertar = "insert into cal_web.solicitud_analisis(rut_funcionario,fecha_hora,id_muestra,cod_producto,cod_subproducto,";
				$Insertar = $Insertar."cod_analisis,cod_tipo_muestra,tipo_solicitud,agrupacion,tipo,enabal,cod_ccosto,cod_area,leyes,impurezas) values ('";
				$Insertar = $Insertar.$Rut."','";
				$Insertar = $Insertar.$FechaHora."','";
				$Insertar = $Insertar.$Fila["id_muestra"]."','";	
				$Insertar = $Insertar.$Fila["cod_producto"]."','";					
				$Insertar = $Insertar.$Fila["cod_subproducto"]."','";			
				$Insertar = $Insertar.$Fila["cod_analisis"]."','";
				$Insertar = $Insertar.$Fila[cod_tipo_muestra]."','";
				$Insertar = $Insertar.$Fila[tipo_solicitud]."','";
				$Insertar = $Insertar.$Fila[agrupacion]."','";
				$Insertar = $Insertar.$Fila[tipo]."','";
				$Insertar = $Insertar.$Fila[enabal]."','";			
				$Insertar = $Insertar.$Fila[cod_ccosto]."',";			
				$Insertar = $Insertar.$Fila[cod_area].",'";
				$Insertar = $Insertar.$Fila[leyes]."','";
				$Insertar = $Insertar.$Fila[impurezas]."')";	
				//echo 	$Insertar;	
				mysqli_query($link, $Insertar);
				$CodPeriodo=$Fila[cod_periodo];
			}
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.FrmSolicitudRutinaria.action='cal_solicitud_rutinaria.php?CmbProductos=".$CmbProductos."&CmbSubProducto=".$CmbSubProducto."&FechaHora=".$FechaHora."&NombrePlantillaSA=".$NombrePlantillaSA."&PeriodoX=".$CodPeriodo."';";
			echo "window.opener.document.FrmSolicitudRutinaria.submit();";
			echo "window.close();</script>";
			break;
		case "M"://MODIFICA LOS DATOS CHEQUEADOS (CC[1],AREAS[2].PERIODO[3]) 
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
			break;
		case "C"://MODIFICAR ID_MUESTRA
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
							$Consulta="select cod_periodo from cal_web.solicitud_analisis where rut_funcionario ='".$Rut."' and fecha_hora ='".$Fecha."' and id_muestra='".$Muestra."'";
							$Respuesta=mysqli_query($link, $Consulta);
							$Fila=mysqli_fetch_array($Respuesta);
							$Periodo=$Fila[cod_periodo];
							$Actualizar ="UPDATE cal_web.solicitud_analisis set id_muestra='".$TxtCambiaID."' where rut_funcionario ='".$Rut."' and fecha_hora ='".$Fecha."' and id_muestra='".$Muestra."'";
							mysqli_query($link, $Actualizar);
							$Consulta = "select nro_solicitud from cal_web.solicitud_analisis where rut_funcionario ='".$Rut."' and fecha_hora ='".$Fecha."' and id_muestra='".$Muestra."'";
							$Respuesta=mysqli_query($link, $Consulta);
							$Fila = mysqli_fetch_array($Respuesta);
							if (!is_null($Fila["nro_solicitud"]))
							{
								$Actualizar ="UPDATE cal_web.leyes_por_solicitud set id_muestra ='".$TxtCambiaID."' where rut_funcionario ='".$Rut."' and fecha_hora ='".$Fecha."' id_muestra='".$Muestra."' and nro_solicitud='".$Fila["nro_solicitud"]."'";
								mysqli_query($link, $Actualizar);
								$Actualizar ="UPDATE cal_web.estados_por_solicitud set recargo ='0' where rut_funcionario ='".$Rut."' and id_muestra='".$Muestra."' and nro_solicitud = '".$Fila["nro_solicitud"]."'";
								mysqli_query($link, $Actualizar);
							}	
						}
					}
				$Muestras = substr($Muestras,$j + 2);
				$j = 0;
				}
			}
			$Entrar=false;
			header ("location:cal_solicitud_rutinaria.php?CmbProductos=".$CmbProductos."&CmbSubProducto=".$CmbSubProducto."&CmbTipoAnalisis=".$CmbTipoAnalisis."&ValorAnalisis=".$ValorAnalisis."&ValorMuestreo=".$ValorMuestreo."&FechaHora=".$FechaHora."&ValorCheck=&PeriodoX=".$PeriodoO."&NombrePlantillaSA=".$NombrePlantillaSA);			
			/*echo "<script languaje='JavaScript'>";
			echo "window.opener.document.FrmSolicitudRutinaria.action='cal_solicitud.php?CmbProductos=".$CmbProductos."&CmbSubProducto=".$CmbSubProducto."&CmbTipoAnalisis=".$CmbTipoAnalisis."&ValorAnalisis=".$ValorAnalisis."&ValorMuestreo=".$ValorMuestreo."&FechaHora=".$FechaHora."&ValorCheck=".$ValCheck."';";
			echo "window.opener.document.FrmSolicitudRutinaria.submit();";
			echo "window.close();</script>";*/
			break;
	}
	if ($Entrar==true)
	{
		if (isset($Modificando))
		{
			header ("location:cal_solicitud_rutinaria.php?Productos=".$CmbProductos."&SubProducto=".$CmbSubProducto."&FechaBusqueda=".$FechaHora."&Modificar=".$Modificando."&ValorCheck=".$ValCheck."&PeriodoX=".$PeriodoO."&NombrePlantillaSA=".$NombrePlantillaSA);
		}
		else
		{
			header ("location:cal_solicitud_rutinaria.php?CmbProductos=".$CmbProductos."&CmbSubProducto=".$CmbSubProducto."&CmbTipoAnalisis=".$CmbTipoAnalisis."&ValorAnalisis=".$ValorAnalisis."&ValorMuestreo=".$ValorMuestreo."&FechaHora=".$FechaHora."&ValorCheck=".$ValCheck."&PeriodoX=".$PeriodoO."&NombrePlantillaSA=".$NombrePlantillaSA);
		}	
	}	
?>
