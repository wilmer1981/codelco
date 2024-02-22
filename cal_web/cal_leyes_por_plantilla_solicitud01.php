<?php
include("../principal/conectar_cal_web.php");
$ValCheck = $Muestras;
$Rut=$CookieRut;
if ($Opcion == 'Generar')
{
	$Fecha="";
	$Muestra="";
	$AuxMuestras=$Muestras;
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
					$Actualiza="UPDATE plantilla_solicitud_analisis set leyes ='".$ValoresLeyes.$ValoresLeyesFisicas."',impurezas='".$ValoresImpurezas."' where  id_muestra='".$Muestra."' and fecha_hora ='".$Fecha."'"; 
					mysqli_query($link, $Actualiza);
				}
			}
		$Muestras = substr($Muestras,$j + 2);
		$j = 0;
		}
	}
	if ($Modificando=='S')
	{
		echo "<script languaje='JavaScript'>";
		echo " window.opener.document.FrmSolicitud.action='cal_generacion_plantillas_solicitudes.php?ValorCheck=".$ValCheck."&Productos=".$Productos."&SubProducto=".$SubProducto."&Modificar=".$Modificando."';";
		echo " window.opener.document.FrmSolicitud.submit();";
		echo "window.close();</script>";
	}
	else
	{
		echo "<script languaje='JavaScript'>";
		echo " window.opener.document.FrmSolicitud.action='cal_generacion_plantillas_solicitudes.php?ValorCheck=".$ValCheck."&Productos=".$Productos."&SubProducto=".$SubProducto."';";
		echo " window.opener.document.FrmSolicitud.submit();";
		echo "window.close();</script>";
	}		
}
else
{
	$Fecha="";
	$Muestra="";
	$AuxMuestras=$Muestras;
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
					$Consulta="select nro_solicitud,cod_producto,cod_subproducto from cal_web.solicitud_analisis where rut_funcionario = '".$Rut."' and id_muestra='".$Muestra."' and fecha_hora ='".$Fecha."'"; 
					$Respuesta = mysqli_query($link, $Consulta);
					$Fila=mysqli_fetch_array($Respuesta);
					if ((!is_null($Fila["nro_solicitud"])) || ($Fila["nro_solicitud"]!=''))
					{
						$Eliminar="delete from cal_web.leyes_por_solicitud where rut_funcionario = '".$Rut."' and nro_solicitud=".$Fila["nro_solicitud"]." and fecha_hora ='".$Fecha."'";
						mysqli_query($link, $Eliminar);
						$Leyes =$ValoresLeyes;
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
										$Insertar = "insert into cal_web.leyes_por_solicitud (rut_funcionario,fecha_hora,nro_solicitud,cod_leyes,cod_unidad,cod_producto,cod_subproducto,id_muestra) values ('";
										$Insertar = $Insertar.$Rut."','";
										$Insertar = $Insertar.$Fecha."',";
										$Insertar = $Insertar.$Fila["nro_solicitud"].",'";
										$Insertar = $Insertar.$Ley."','";
										$Insertar = $Insertar.$Unidad."','";
										$Insertar = $Insertar.$Fila["cod_producto"]."','";
										$Insertar = $Insertar.$Fila["cod_subproducto"]."','";
										$Insertar = $Insertar.$Muestra."')";
										mysqli_query($link, $Insertar);
									}
								}
							$Leyes = substr($Leyes,$k + 2);
							$k = 0;
							}
						}
						$Impurezas=$ValoresImpurezas;		
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
										$Insertar = "insert into cal_web.leyes_por_solicitud (rut_funcionario,fecha_hora,nro_solicitud,cod_leyes,cod_unidad,cod_producto,cod_subproducto,id_muestra) values ('";
										$Insertar = $Insertar.$Rut."','";
										$Insertar = $Insertar.$Fecha."',";
										$Insertar = $Insertar.$Fila["nro_solicitud"].",'";
										$Insertar = $Insertar.$Impureza."','";
										$Insertar = $Insertar.$Unidad."','";
										$Insertar = $Insertar.$Fila["cod_producto"]."','";
										$Insertar = $Insertar.$Fila["cod_subproducto"]."','";
										$Insertar = $Insertar.$Muestra."')";
										mysqli_query($link, $Insertar);
									}
								}
							$Impurezas = substr($Impurezas,$k + 2);
							$k = 0;
							}
						}
						$LeyesFisicas=$ValoresLeyesFisicas;		
						for ($k = 0;$k <= strlen($LeyesFisicas); $k++)
						{
							if (substr($LeyesFisicas,$k,2) == "//")
							{
								$FisicaUnidades = substr($LeyesFisicas,0,$k);
								for ($f=0;$f<=strlen($FisicaUnidades);$f++)
								{
									if (substr($FisicaUnidades,$f,2) == "~~")
									{
										$Fisica = substr($FisicaUnidades,0,$f);			
										$Unidad = substr($FisicaUnidades,$f+2,strlen($FisicaUnidades));
										$Insertar = "insert into cal_web.leyes_por_solicitud (rut_funcionario,fecha_hora,nro_solicitud,cod_leyes,cod_unidad,cod_producto,cod_subproducto,id_muestra) values ('";
										$Insertar = $Insertar.$Rut."','";
										$Insertar = $Insertar.$Fecha."',";
										$Insertar = $Insertar.$Fila["nro_solicitud"].",'";
										$Insertar = $Insertar.$Fisica."','";
										$Insertar = $Insertar.$Unidad."','";
										$Insertar = $Insertar.$Fila["cod_producto"]."','";
										$Insertar = $Insertar.$Fila["cod_subproducto"]."','";
										$Insertar = $Insertar.$Muestra."')";
										mysqli_query($link, $Insertar);
									}
								}
							$LeyesFisicas = substr($LeyesFisicas,$k + 2);
							$k = 0;
							}
						}
					}
					$Actualiza="UPDATE solicitud_analisis set leyes ='".$ValoresLeyes.$ValoresLeyesFisicas."',impurezas='".$ValoresImpurezas."' where rut_funcionario = '".$Rut."' and id_muestra='".$Muestra."' and fecha_hora ='".$Fecha."'"; 
					mysqli_query($link, $Actualiza);
				}
			}
		$Muestras = substr($Muestras,$j + 2);
		$j = 0;
		}
	}
	if ($Modificando=='S')
	{
		echo "<script languaje='JavaScript'>";
		echo " window.opener.document.FrmSolicitudRutinaria.action='cal_solicitud_rutinaria.php?ValorCheck=".$ValCheck."&Productos=".$Productos."&SubProducto=".$SubProducto."&Modificar=".$Modificando."';";
		echo " window.opener.document.FrmSolicitudRutinaria.submit();";
		echo "window.close();</script>";
	}
	else
	{
		echo "<script languaje='JavaScript'>";
		echo " window.opener.document.FrmSolicitudRutinaria.action='cal_solicitud_rutinaria.php?ValorCheck=".$ValCheck."';";
		echo " window.opener.document.FrmSolicitudRutinaria.submit();";
		echo "window.close();</script>";
	}		
}
?>
