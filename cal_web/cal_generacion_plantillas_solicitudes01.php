<?php 
	$CodigoDeSistema=1;
	include ("../Principal/conectar_principal.php");
	
	$CookieRut = $_COOKIE["CookieRut"];		
	$proceso = isset($_REQUEST["proceso"])?$_REQUEST["proceso"]:'';
	$Muestras = isset($_REQUEST["Muestras"])?$_REQUEST["Muestras"]:'';
	$ValorAnalisis = isset($_REQUEST["ValorAnalisis"])?$_REQUEST["ValorAnalisis"]:'';
	$GenerarVal = isset($_REQUEST["GenerarVal"])?$_REQUEST["GenerarVal"]:'';
	$Producto = isset($_REQUEST["Producto"])?$_REQUEST["Producto"]:'';
	$Modificando = isset($_REQUEST["Modificando"])?$_REQUEST["Modificando"]:'';
	$FechaBusqueda = isset($_REQUEST["FechaBusqueda"])?$_REQUEST["FechaBusqueda"]:'';
	$FechaBuscar = isset($_REQUEST["FechaBuscar"])?$_REQUEST["FechaBuscar"]:'';
	$FechaHora = isset($_REQUEST["FechaHora"])?$_REQUEST["FechaHora"]:'0000-00-00 00:00';
	$Modificar = isset($_REQUEST["Modificar"])?$_REQUEST["Modificar"]:'';
	$CmbProductos = isset($_REQUEST["CmbProductos"])?$_REQUEST["CmbProductos"]:'';
	$CmbSubProducto = isset($_REQUEST["CmbSubProducto"])?$_REQUEST["CmbSubProducto"]:'';
	$Productos = isset($_REQUEST["Productos"])?$_REQUEST["Productos"]:'';
	$SubProducto = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:'';
	$Flujo = isset($_REQUEST["Flujo"])?$_REQUEST["Flujo"]:'';
	$CmbTipo = isset($_REQUEST["CmbTipo"])?$_REQUEST["CmbTipo"]:'';
	$CmbPeriodo = isset($_REQUEST["CmbPeriodo"])?$_REQUEST["CmbPeriodo"]:'';
	$CmbAgrupacion = isset($_REQUEST["CmbAgrupacion"])?$_REQUEST["CmbAgrupacion"]:'';
	$GenerarValidacion = isset($_REQUEST["GenerarValidacion"])?$_REQUEST["GenerarValidacion"]:'';
	$TxtMuestra = isset($_REQUEST["TxtMuestra"])?$_REQUEST["TxtMuestra"]:'';
	$CmbTipoAnalisis  = isset($_REQUEST["CmbTipoAnalisis"])?$_REQUEST["CmbTipoAnalisis"]:'';
	$ValorAnalisis  = isset($_REQUEST["ValorAnalisis"])?$_REQUEST["ValorAnalisis"]:'';
	$ValorMuestreo = isset($_REQUEST["ValorMuestreo"])?$_REQUEST["ValorMuestreo"]:'';
	$CmbCCosto = isset($_REQUEST["CmbCCosto"])?$_REQUEST["CmbCCosto"]:'';
	$ValorCheck = isset($_REQUEST["ValorCheck"])?$_REQUEST["ValorCheck"]:'';
	$TxtPlantilla = isset($_REQUEST["TxtPlantilla"])?$_REQUEST["TxtPlantilla"]:'';
	$TxtValDes = isset($_REQUEST["TxtValDes"])?$_REQUEST["TxtValDes"]:'';
	$CmbAreasProceso = isset($_REQUEST["CmbAreasProceso"])?$_REQUEST["CmbAreasProceso"]:'';
	$TxtIdMuestra = isset($_REQUEST["TxtIdMuestra"])?$_REQUEST["TxtIdMuestra"]:'';
	$Valor = isset($_REQUEST["Valor"])?$_REQUEST["Valor"]:'';
	$Enabal = isset($_REQUEST["Valor"])?$_REQUEST["Enabal"]:'';
	 
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
		if ($Modificando!="")
		{
			header ("location:cal_generacion_plantillas_solicitudes.php?Productos=".$CmbProductos."&SubProducto=".$CmbSubProducto."&FechaBusqueda=".$FechaHora."&Modificar=".$Modificando."&ValorCheck=".$ValCheck);
		}
		else
		{
			header ("location:cal_generacion_plantillas_solicitudes.php?CmbProductos=".$CmbProductos."&CmbSubProducto=".$CmbSubProducto."&CmbTipoAnalisis=".$CmbTipoAnalisis."&ValorAnalisis=".$ValorAnalisis."&ValorMuestreo=".$ValorMuestreo."&FechaHora=".$FechaHora."&ValorCheck=".$ValCheck);
		}	
	}	

?>
