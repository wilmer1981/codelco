<?php
include("../principal/conectar_cal_web.php");

$CookieRut = $_COOKIE["CookieRut"];	
$BtnMuestras  = isset($_REQUEST["BtnMuestras"])?$_REQUEST["BtnMuestras"]:'';
$Plantilla    = isset($_REQUEST["Plantilla"])?$_REQUEST["Plantilla"]:'';
$SolAut = isset($_REQUEST["SolAut"])?$_REQUEST["SolAut"]:'';
$SolEsp = isset($_REQUEST["SolEsp"])?$_REQUEST["SolEsp"]:'';
$Rut = isset($_REQUEST["Rut"])?$_REQUEST["Rut"]:'';
$BuscarDetalle = isset($_REQUEST["BuscarDetalle"])?$_REQUEST["BuscarDetalle"]:'';
$BuscarPrv = isset($_REQUEST["BuscarPrv"])?$_REQUEST["BuscarPrv"]:'';
$CmbRutPrv = isset($_REQUEST["CmbRutPrv"])?$_REQUEST["CmbRutPrv"]:'';
$Modificando = isset($_REQUEST["Modificando"])?$_REQUEST["Modificando"]:'';

$ValCheck = $BtnMuestras;
$RutF = $CookieRut;
$Consulta = "select t1.cod_leyes,t1.cod_unidad ";
$Consulta = $Consulta."from cal_web.leyes_por_plantillas t1 inner join proyecto_modernizacion.leyes t2 on t1.cod_leyes = t2.cod_leyes and t2.tipo_leyes=0 ";
$Consulta = $Consulta."where t1.rut_funcionario='".$Rut."' and t1.cod_plantilla ='".$Plantilla."'"; 
$Respuesta = mysqli_query($link, $Consulta);
$ValoresLeyes="";
while ($Fila=mysqli_fetch_array($Respuesta))
{
	$ValoresLeyes=$ValoresLeyes.$Fila["cod_leyes"]."~~".$Fila["cod_unidad"]."//"; 
}
$Consulta = "select t1.cod_leyes,t1.cod_unidad ";
$Consulta = $Consulta."from cal_web.leyes_por_plantillas t1 inner join proyecto_modernizacion.leyes t2 on t1.cod_leyes = t2.cod_leyes and (t2.tipo_leyes=1 or t2.tipo_leyes=3) ";
$Consulta = $Consulta."where t1.rut_funcionario='".$Rut."' and t1.cod_plantilla ='".$Plantilla."'"; 
$Respuesta = mysqli_query($link, $Consulta);
$ValoresImpurezas="";
while ($Fila=mysqli_fetch_array($Respuesta))
{
	$ValoresImpurezas=$ValoresImpurezas.$Fila["cod_leyes"]."~~".$Fila["cod_unidad"]."//"; 
}
$ValoresLeyImp=$ValoresLeyes.$ValoresImpurezas;
$Valores=$ValoresLeyImp;
$Fecha="";
$Muestra="";
$Muestras=$BtnMuestras;
if ($SolAut=='S')//S.A AUTOMATICA O RUTINARIA
{
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
						$Eliminar = "delete from cal_web.leyes_por_solicitud where rut_funcionario = '".$RutF."' and id_muestra='".$Muestra."' and fecha_hora ='".$Fecha."'";
						mysqli_query($link, $Eliminar);	
						$Actualiza="UPDATE cal_web.solicitud_analisis set leyes ='".$ValoresLeyes."',impurezas='".$ValoresImpurezas."' where rut_funcionario = '".$RutF."' and id_muestra='".$Muestra."' and fecha_hora ='".$Fecha."'"; 
						mysqli_query($link, $Actualiza);
						//VERIFICA SI LA MUESTRA YA TIENE NRO_SOLICITUD, SI ES ASI INSERTA LAS LEYES EN LEYES_POR_SOLICITUD
						$Consulta = "select * from cal_web.solicitud_analisis where rut_funcionario = '".$RutF."' and id_muestra='".$Muestra."' and fecha_hora ='".$Fecha."'";
						$Respuesta=mysqli_query($link, $Consulta);
						$Fila=mysqli_fetch_array($Respuesta);
						if ((!is_null($Fila["nro_solicitud"])) || ($Fila["nro_solicitud"]!=''))
						{
							$Valores=$ValoresLeyImp;
							for($i=0;$i<=strlen($Valores);$i++)
							{
								if (substr($Valores,$i,2)=="//")
								{
									$LeyUnidad=substr($Valores,0,$i);
									for ($k=0;$k<=strlen($LeyUnidad);$k++)
									{
										if (substr($LeyUnidad,$k,2)=="~~")
										{
											$Ley = substr($LeyUnidad,0,$k);			
											$Unidad = substr($LeyUnidad,$k+2,strlen($LeyUnidad)-2);
											$Insertar="insert into cal_web.leyes_por_solicitud(rut_funcionario,fecha_hora,nro_solicitud,cod_producto,cod_subproducto,id_muestra,cod_leyes,cod_unidad) values('";
											$Insertar=$Insertar.$RutF."','";
											$Insertar=$Insertar.$Fecha."',";
											$Insertar=$Insertar.$Fila["nro_solicitud"].",'";
											$Insertar=$Insertar.$Fila["cod_producto"]."','";
											$Insertar=$Insertar.$Fila["cod_subproducto"]."','";
											$Insertar=$Insertar.$Muestra."','";
											$Insertar=$Insertar.$Ley."','";
											$Insertar=$Insertar.$Unidad."')";
											mysqli_query($link, $Insertar);
										}
									}		
									$Valores=substr($Valores,$i + 2);
									$i = 0;
								}
							}			
						}
						
					}
					else
					{
						$Eliminar = "delete from cal_web.leyes_por_solicitud where rut_funcionario = '".$RutF."' and id_muestra='".$Muestra."' and fecha_hora ='".$Fecha."' and recargo='".$Recargo."'";
						mysqli_query($link, $Eliminar);	
						$Actualiza="UPDATE cal_web.solicitud_analisis set leyes ='".$ValoresLeyes."',impurezas='".$ValoresImpurezas."' where rut_funcionario = '".$RutF."' and id_muestra='".$Muestra."' and fecha_hora ='".$Fecha."' and recargo ='".$Recargo."'"; 				
						mysqli_query($link, $Actualiza);
						//VERIFICA SI EL RECARGO YA TIENE NRO_SOLICITUD, SI ES ASI INSERTA LAS LEYES EN LEYES_POR_SOLICITUD
						$Consulta = "select * from cal_web.solicitud_analisis where rut_funcionario = '".$RutF."' and id_muestra='".$Muestra."' and fecha_hora ='".$Fecha."' and recargo='".$Recargo."'";
						$Respuesta=mysqli_query($link, $Consulta);
						$Fila=mysqli_fetch_array($Respuesta);
						if ((!is_null($Fila["nro_solicitud"])) || ($Fila["nro_solicitud"]!=''))
						{
							$Valores=$ValoresLeyImp;
							for($i=0;$i<=strlen($Valores);$i++)
							{
								if (substr($Valores,$i,2)=="//")
								{
									$LeyUnidad=substr($Valores,0,$i);
									for ($k=0;$k<=strlen($LeyUnidad);$k++)
									{
										if (substr($LeyUnidad,$k,2)=="~~")
										{
											$Ley = substr($LeyUnidad,0,$k);			
											$Unidad = substr($LeyUnidad,$k+2,strlen($LeyUnidad)-2);
											$Insertar="insert into cal_web.leyes_por_solicitud(rut_funcionario,fecha_hora,nro_solicitud,cod_producto,cod_subproducto,id_muestra,recargo,cod_leyes,cod_unidad) values('";
											$Insertar=$Insertar.$RutF."','";
											$Insertar=$Insertar.$Fecha."',";
											$Insertar=$Insertar.$Fila["nro_solicitud"].",'";
											$Insertar=$Insertar.$Fila["cod_producto"]."','";
											$Insertar=$Insertar.$Fila["cod_subproducto"]."','";
											$Insertar=$Insertar.$Muestra."','";
											$Insertar=$Insertar.$Recargo."','";
											$Insertar=$Insertar.$Ley."','";
											$Insertar=$Insertar.$Unidad."')";
											mysqli_query($link, $Insertar);
										}
									}		
									$Valores=substr($Valores,$i + 2);
									$i = 0;
								}
							}			
						}
					}	
				}
			}
		$Muestras = substr($Muestras,$j + 2);
		$j = 0;
		}
	}
	if ($Modificando!="" and($Modificando=='S'))
	{			
		echo "<script languaje='JavaScript'>";
		echo " window.opener.document.FrmSolicitudAut.action='cal_solicitud_automatica.php?Productos=".$TxtProducto."&SubProducto=".$TxtSubProducto."&ValorCheck=".$ValCheck."&Modificar=".$Modificando."';";
		echo " window.opener.document.FrmSolicitudAut.submit();";
		echo "window.close();</script>";
	}
	else
	{
		echo "<script languaje='JavaScript'>";
		echo " window.opener.document.FrmSolicitudAut.action='cal_solicitud_automatica.php?ValorCheck=".$ValCheck."&Buscar=".$BuscarDetalle."&BuscarPrv=".$BuscarPrv."&CmbRutPrv=".$CmbRutPrv."';";
		echo " window.opener.document.FrmSolicitudAut.submit();";
		echo "window.close();</script>";
	}
}
else//S.A ESPECIAL
{
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
					$Eliminar = "delete from cal_web.leyes_por_solicitud where rut_funcionario = '".$RutF."' and id_muestra='".$Muestra."' and fecha_hora ='".$Fecha."'";
					mysqli_query($link, $Eliminar);	
					$Actualiza="UPDATE cal_web.solicitud_analisis set leyes ='".$ValoresLeyes."',impurezas='".$ValoresImpurezas."' where rut_funcionario = '".$RutF."' and id_muestra='".$Muestra."' and fecha_hora ='".$Fecha."'"; 
					mysqli_query($link, $Actualiza);
					//VERIFICA SI LA MUESTRA YA TIENE NRO_SOLICITUD, SI ES ASI INSERTA LAS LEYES EN LEYES_POR_SOLICITUD
					$Consulta = "select * from cal_web.solicitud_analisis where rut_funcionario = '".$RutF."' and id_muestra='".$Muestra."' and fecha_hora ='".$Fecha."'";
					$Respuesta=mysqli_query($link, $Consulta);
					$Fila=mysqli_fetch_array($Respuesta);
					if ((!is_null($Fila["nro_solicitud"])) || ($Fila["nro_solicitud"]!=''))
					{
						$Valores=$ValoresLeyImp;
						for($i=0;$i<=strlen($Valores);$i++)
						{
							if (substr($Valores,$i,2)=="//")
							{
								$LeyUnidad=substr($Valores,0,$i);
								for ($k=0;$k<=strlen($LeyUnidad);$k++)
								{
									if (substr($LeyUnidad,$k,2)=="~~")
									{
										$Ley = substr($LeyUnidad,0,$k);			
										$Unidad = substr($LeyUnidad,$k+2,strlen($LeyUnidad)-2);
										$Insertar="insert into cal_web.leyes_por_solicitud(rut_funcionario,fecha_hora,nro_solicitud,cod_producto,cod_subproducto,id_muestra,cod_leyes,cod_unidad) values('";
										$Insertar=$Insertar.$RutF."','";
										$Insertar=$Insertar.$Fecha."',";
										$Insertar=$Insertar.$Fila["nro_solicitud"].",'";
										$Insertar=$Insertar.$Fila["cod_producto"]."','";
										$Insertar=$Insertar.$Fila["cod_subproducto"]."','";
										$Insertar=$Insertar.$Muestra."','";
										$Insertar=$Insertar.$Ley."','";
										$Insertar=$Insertar.$Unidad."')";
										mysqli_query($link, $Insertar);
									}
								}		
								$Valores=substr($Valores,$i + 2);
								$i = 0;
							}
						}			
					}
				}
			}
		$Muestras = substr($Muestras,$j + 2);
		$j = 0;
		}
	}
	if ($Modificando!="" and ($Modificando=='S'))
	{			
		echo "<script languaje='JavaScript'>";
		echo " window.opener.document.FrmSolicitud.action='cal_solicitud_frx.php?Productos=".$TxtProducto."&SubProducto=".$TxtSubProducto."&ValorCheck=".$ValCheck."&Modificar=".$Modificando."';";
		echo " window.opener.document.FrmSolicitud.submit();";
		echo "window.close();</script>";
	}
	else
	{
		echo "<script languaje='JavaScript'>";
		echo " window.opener.document.FrmSolicitud.action='cal_solicitud_frx.php?ValorCheck=".$ValCheck."';";
		echo " window.opener.document.FrmSolicitud.submit();";
		echo "window.close();</script>";
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
