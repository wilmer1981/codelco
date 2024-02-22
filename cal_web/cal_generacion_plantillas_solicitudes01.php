<?php 
	$CodigoDeSistema=1;
	include ("../Principal/conectar_principal.php");
	//include ("../Principal/conectar_cal_web.php");
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
    //$FechaHora = date("Y-m-d H:i");
	$Entrar=true;//USADO PARA NO HACER DOS HEADER CON LA OPCION L Y S(TIENES SUS PROPIOS HEADER)
	switch ($proceso)
	{
		case "L":
			if ($Pagina != "")
			{
				header("location:cal_generacion_plantillas_solicitudes?Pagina=".$Pagina."&".$Variables);		
			}
			else
			{
				header("location:cal_generacion_plantillas_solicitudes.php");
			}
			$Entrar=false;
			break;
		case "S":
			header("location:../principal/sistemas_usuario.php?CodSistema=1");
			$Entrar=false;
			break;
		case "N"://INGRESA UN NUEVO REGISTRO EN SOLICITUD ANALISIS
			$TxtMuestra=str_replace('~','-',$TxtMuestra);
			$TxtMuestra=str_replace('/','-',$TxtMuestra);
			$TxtMuestra=str_replace('|','-',$TxtMuestra);
			$TxtMuestra=str_replace('','-',$TxtMuestra);
			$TxtMuestra=str_replace('�','-',$TxtMuestra);
			$TxtMuestra=str_replace('�','-',$TxtMuestra);
			$TxtMuestra=str_replace('@','-',$TxtMuestra);
		    $Insertar = "insert into cal_web.plantilla_solicitud_analisis(fecha_hora,id_muestra,cod_producto,cod_subproducto,";
			$Insertar = $Insertar."cod_analisis,cod_tipo_muestra,tipo_solicitud,agrupacion,tipo,enabal) values ('";
			$Insertar = $Insertar.$FechaHora."','";
			$Insertar = $Insertar.$TxtMuestra."','";	
			$Insertar = $Insertar.$CmbProductos."','";					
			$Insertar = $Insertar.$CmbSubProducto."','";			
			$Insertar = $Insertar.$CmbTipoAnalisis."','";			
			$Insertar = $Insertar.$TipoMuestra."','R','$CmbAgrupacion','$CmbTipo','$Enabal')";
			mysqli_query($link, $Insertar);
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
							$Actualizar = "UPDATE cal_web.plantilla_solicitud_analisis ";
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
							$Actualizar = $Actualizar." where  fecha_hora ='".$Fecha."' and id_muestra ='".$Muestra."'";
							//echo $Actualizar."<br>";
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
							$Eliminar = "delete from cal_web.plantilla_solicitud_analisis where fecha_hora ='".$Fecha."' and id_muestra='".$Muestra."'";
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
							$Actualizar = "UPDATE cal_web.plantilla_solicitud_analisis set descripcion='".$TxtPlantilla."' where  fecha_hora ='".$Fecha."' and id_muestra='".$Muestra."'";
							mysqli_query($link, $Actualizar);
						}
					}
				$Muestras = substr($Muestras,$j + 2);
				$j = 0;
				}
			}
			break;
	}
	if ($Entrar==true)
	{
		if (isset($Modificando))
		{
			header ("location:cal_generacion_plantillas_solicitudes.php?Productos=".$CmbProductos."&SubProducto=".$CmbSubProducto."&FechaBusqueda=".$FechaHora."&Modificar=".$Modificando."&ValorCheck=".$ValCheck);
		}
		else
		{
			header ("location:cal_generacion_plantillas_solicitudes.php?CmbProductos=".$CmbProductos."&CmbSubProducto=".$CmbSubProducto."&CmbTipoAnalisis=".$CmbTipoAnalisis."&ValorAnalisis=".$ValorAnalisis."&ValorMuestreo=".$ValorMuestreo."&FechaHora=".$FechaHora."&ValorCheck=".$ValCheck);
		}	
	}	

?>
