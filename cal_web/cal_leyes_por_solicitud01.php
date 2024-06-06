<?php
include("../principal/conectar_cal_web.php");
$CookieRut=$_COOKIE["CookieRut"];

$Opcion      = isset($_REQUEST["Opcion"])?$_REQUEST["Opcion"]:"";
$Rec    = isset($_REQUEST["Rec"])?$_REQUEST["Rec"]:"";
$Sol    = isset($_REQUEST["Sol"])?$_REQUEST["Sol"]:"";

$ValoresLeyes        = isset($_REQUEST["ValoresLeyes"])?$_REQUEST["ValoresLeyes"]:"";
$ValoresImpurezas    = isset($_REQUEST["ValoresImpurezas"])?$_REQUEST["ValoresImpurezas"]:"";
$ValoresLeyesFisicas = isset($_REQUEST["ValoresLeyesFisicas"])?$_REQUEST["ValoresLeyesFisicas"]:"";
$Personalizar        = isset($_REQUEST["Personalizar"])?$_REQUEST["Personalizar"]:"";
$Muestras            = isset($_REQUEST["Muestras"])?$_REQUEST["Muestras"]:"";
$Productos           = isset($_REQUEST["Productos"])?$_REQUEST["Productos"]:"";
$SubProducto         = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";
$NombrePlantilla     = isset($_REQUEST["NombrePlantilla"])?$_REQUEST["NombrePlantilla"]:"";
$CodPlantilla        = isset($_REQUEST["CodPlantilla"])?$_REQUEST["CodPlantilla"]:"";
$Modificando         = isset($_REQUEST["Modificando"])?$_REQUEST["Modificando"]:"";
$Salir               = isset($_REQUEST["Salir"])?$_REQUEST["Salir"]:"";
$SolAut              = isset($_REQUEST["SolAut"])?$_REQUEST["SolAut"]:"";
$BuscarDetalle       = isset($_REQUEST["BuscarDetalle"])?$_REQUEST["BuscarDetalle"]:"";
$BuscarPrv           = isset($_REQUEST["BuscarPrv"])?$_REQUEST["BuscarPrv"]:"";
$CmbRutPrv           = isset($_REQUEST["CmbRutPrv"])?$_REQUEST["CmbRutPrv"]:"";
$VolverAEsp          = isset($_REQUEST["VolverAEsp"])?$_REQUEST["VolverAEsp"]:"";

$ValCheck = $Muestras;
$Rut      = $CookieRut;
if ($Opcion == 3)
{
	if ($Rec == 'N')
	{
		$Consulta="select nro_solicitud,cod_producto,cod_subproducto,fecha_hora,id_muestra,rut_funcionario from cal_web.solicitud_analisis where nro_solicitud ='".$Sol."'"; 
		$Respuesta = mysqli_query($link, $Consulta);
		$Fila=mysqli_fetch_array($Respuesta);
		$Eliminar="delete from cal_web.leyes_por_solicitud where  nro_solicitud=".$Sol." ";
		mysqli_query($link, $Eliminar);
		$Leyes =$ValoresLeyes;
			echo $Leyes."<br>";	
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
							$Insertar = $Insertar.$Fila["rut_funcionario"]."','";
							$Insertar = $Insertar.$Fila["fecha_hora"]."',";
							$Insertar = $Insertar.$Sol.",'";
							$Insertar = $Insertar.$Ley."','";
							$Insertar = $Insertar.$Unidad."','";
							$Insertar = $Insertar.$Fila["cod_producto"]."','";
							$Insertar = $Insertar.$Fila["cod_subproducto"]."','";
							$Insertar = $Insertar.$Fila["id_muestra"]."')";
							mysqli_query($link, $Insertar);
						}
					}
				$Leyes = substr($Leyes,$k + 2);
				$k = 0;
				}
			}
			$Impurezas=$ValoresImpurezas;
			echo $Impurezas."<br>";
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
							$Insertar = $Insertar.$Fila["rut_funcionario"]."','";
							$Insertar = $Insertar.$Fila["fecha_hora"]."',";
							$Insertar = $Insertar.$Sol.",'";
							$Insertar = $Insertar.$Impureza."','";
							$Insertar = $Insertar.$Unidad."','";
							$Insertar = $Insertar.$Fila["cod_producto"]."','";
							$Insertar = $Insertar.$Fila["cod_subproducto"]."','";
							$Insertar = $Insertar.$Fila["id_muestra"]."')";
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
							$Insertar = $Insertar.$Fila["rut_funcionario"]."','";
							$Insertar = $Insertar.$Fila["fecha_hora"]."',";
							$Insertar = $Insertar.$Sol.",'";
							$Insertar = $Insertar.$Fisica."','";
							$Insertar = $Insertar.$Unidad."','";
							$Insertar = $Insertar.$Fila["cod_producto"]."','";
							$Insertar = $Insertar.$Fila["cod_subproducto"]."','";
							$Insertar = $Insertar.$Fila["id_muestra"]."')";
							mysqli_query($link, $Insertar);
						}
					}
				$LeyesFisicas = substr($LeyesFisicas,$k + 2);
				$k = 0;
				}
			}
		
		$Actualiza="UPDATE solicitud_analisis set leyes ='".$ValoresLeyes.$ValoresLeyesFisicas."',impurezas='".$ValoresImpurezas."' where nro_solicitud='".$Sol."'"; 
		mysqli_query($link, $Actualiza);
	}
	else//con recargo
	{
		$Consulta="select nro_solicitud,cod_producto,cod_subproducto,fecha_hora,id_muestra,rut_funcionario from cal_web.solicitud_analisis where nro_solicitud ='".$Sol."' and recargo = '".$Rec."'"; 
		$Respuesta = mysqli_query($link, $Consulta);
		$Fila=mysqli_fetch_array($Respuesta);
		$Eliminar="delete from cal_web.leyes_por_solicitud where  nro_solicitud=".$Sol." and recargo = '".$Rec."' ";
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
							$Insertar = "insert into cal_web.leyes_por_solicitud (rut_funcionario,recargo,fecha_hora,nro_solicitud,cod_leyes,cod_unidad,cod_producto,cod_subproducto,id_muestra) values ('";
							$Insertar = $Insertar.$Fila["rut_funcionario"]."','";
							$Insertar = $Insertar.$Rec."','";
							$Insertar = $Insertar.$Fila["fecha_hora"]."',";
							$Insertar = $Insertar.$Sol.",'";
							$Insertar = $Insertar.$Ley."','";
							$Insertar = $Insertar.$Unidad."','";
							$Insertar = $Insertar.$Fila["cod_producto"]."','";
							$Insertar = $Insertar.$Fila["cod_subproducto"]."','";
							$Insertar = $Insertar.$Fila["id_muestra"]."')";
							//echo $Insertar."<br>";
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
							$Insertar = "insert into cal_web.leyes_por_solicitud (rut_funcionario,recargo,fecha_hora,nro_solicitud,cod_leyes,cod_unidad,cod_producto,cod_subproducto,id_muestra) values ('";
							$Insertar = $Insertar.$Fila["rut_funcionario"]."','";
							$Insertar = $Insertar.$Rec."','";
							$Insertar = $Insertar.$Fila["fecha_hora"]."',";
							$Insertar = $Insertar.$Sol.",'";
							$Insertar = $Insertar.$Impureza."','";
							$Insertar = $Insertar.$Unidad."','";
							$Insertar = $Insertar.$Fila["cod_producto"]."','";
							$Insertar = $Insertar.$Fila["cod_subproducto"]."','";
							$Insertar = $Insertar.$Fila["id_muestra"]."')";
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
							$Insertar = "insert into cal_web.leyes_por_solicitud (rut_funcionario,recargo,fecha_hora,nro_solicitud,cod_leyes,cod_unidad,cod_producto,cod_subproducto,id_muestra) values ('";
							$Insertar = $Insertar.$Fila["rut_funcionario"]."','";
							$Insertar = $Insertar.$Rec."','";
							$Insertar = $Insertar.$Fila["fecha_hora"]."',";
							$Insertar = $Insertar.$Sol.",'";
							$Insertar = $Insertar.$Fisica."','";
							$Insertar = $Insertar.$Unidad."','";
							$Insertar = $Insertar.$Fila["cod_producto"]."','";
							$Insertar = $Insertar.$Fila["cod_subproducto"]."','";
							$Insertar = $Insertar.$Fila["id_muestra"]."')";
							//echo $Insertar."<br>";
							mysqli_query($link, $Insertar);
						}
					}
				$LeyesFisicas = substr($LeyesFisicas,$k + 2);
				$k = 0;
				}
			}
		
		$Actualiza="UPDATE solicitud_analisis set leyes ='".$ValoresLeyes.$ValoresLeyesFisicas."',impurezas='".$ValoresImpurezas."' where nro_solicitud='".$Sol."' and recargo = '".$Rec."'"; 
		mysqli_query($link, $Actualiza);
	
	}
echo "<script languaje='JavaScript'>";
echo " window.opener.document.FrmModifica.action='cal_modificacion_leyes.php?SolA=".$Sol."&Recargo=".$Rec."';";
echo " window.opener.document.FrmModifica.submit();";
echo "window.close();</script>";
}
else
{
	if ($Personalizar=="")
	{
		if ($SolAut=="")
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
				echo " window.opener.document.FrmSolicitud.action='cal_solicitud.php?ValorCheck=".$ValCheck."&Productos=".$Productos."&SubProducto=".$SubProducto."&Modificar=".$Modificando."';";
				echo " window.opener.document.FrmSolicitud.submit();";
				echo "window.close();</script>";
			}
			else
			{
				echo "<script languaje='JavaScript'>";
				echo " window.opener.document.FrmSolicitud.action='cal_solicitud.php?ValorCheck=".$ValCheck."';";
				echo " window.opener.document.FrmSolicitud.submit();";
				echo "window.close();</script>";
			}		
		}
		else
		{
			$Fecha="";
			$Muestra="";
			$Recargo="";
			$AuxMuestras=$Muestras;
			for ($j = 0;$j <= strlen($Muestras); $j++)
			{
				if (substr($Muestras,$j,2) == "//")
				{
					$MuestraFechaRecargo = substr($Muestras,0,$j);
					for ($x=0;$x<=strlen($MuestraFechaRecargo);$x++)
					{
						if (substr($MuestraFechaRecargo,$x,2) == "~~")
						{
							$Muestra = substr($Muestras,0,$x);			
							$Fecha = substr($Muestras,$x+2,19);
							$Recargo=substr($MuestraFechaRecargo,$x+21,strlen($MuestraFechaRecargo));
							if ($Recargo=='N')
							{
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
							else//CON RECARGO
							{
								$Consulta="select nro_solicitud,cod_producto,cod_subproducto from cal_web.solicitud_analisis where rut_funcionario = '".$Rut."' and id_muestra='".$Muestra."' and fecha_hora ='".$Fecha."' and recargo='".$Recargo."'"; 
								$Respuesta = mysqli_query($link, $Consulta);
								$Fila=mysqli_fetch_array($Respuesta);
								if ((!is_null($Fila["nro_solicitud"])) || ($Fila["nro_solicitud"]!=''))
								{
									$Eliminar="delete from cal_web.leyes_por_solicitud where rut_funcionario = '".$Rut."' and nro_solicitud=".$Fila["nro_solicitud"]." and fecha_hora ='".$Fecha."' and recargo='".$Recargo."'";
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
													$Insertar = "insert into cal_web.leyes_por_solicitud (rut_funcionario,fecha_hora,nro_solicitud,recargo,cod_leyes,cod_unidad,cod_producto,cod_subproducto,id_muestra) values ('";
													$Insertar = $Insertar.$Rut."','";
													$Insertar = $Insertar.$Fecha."',";
													$Insertar = $Insertar.$Fila["nro_solicitud"].",'";
													$Insertar = $Insertar.$Recargo."','";
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
													$Insertar = "insert into cal_web.leyes_por_solicitud (rut_funcionario,fecha_hora,nro_solicitud,recargo,cod_leyes,cod_unidad,cod_producto,cod_subproducto,id_muestra) values ('";
													$Insertar = $Insertar.$Rut."','";
													$Insertar = $Insertar.$Fecha."',";
													$Insertar = $Insertar.$Fila["nro_solicitud"].",'";
													$Insertar = $Insertar.$Recargo."','";
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
													$Insertar = "insert into cal_web.leyes_por_solicitud (rut_funcionario,fecha_hora,nro_solicitud,recargo,cod_leyes,cod_unidad,cod_producto,cod_subproducto,id_muestra) values ('";
													$Insertar = $Insertar.$Rut."','";
													$Insertar = $Insertar.$Fecha."',";
													$Insertar = $Insertar.$Fila["nro_solicitud"].",'";
													$Insertar = $Insertar.$Recargo."','";												
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
								$Actualiza="UPDATE solicitud_analisis set leyes ='".$ValoresLeyes.$ValoresLeyesFisicas."',impurezas='".$ValoresImpurezas."' where rut_funcionario = '".$Rut."' and id_muestra='".$Muestra."' and fecha_hora ='".$Fecha."' and recargo='".$Recargo."'"; 
								mysqli_query($link, $Actualiza);
							}
						}
					}
				$Muestras = substr($Muestras,$j + 2);
				$j = 0;
				}
			}
			if ($VolverAEsp=='S')
			{			
				if ($Modificando=='S')
				{
					echo "<script languaje='JavaScript'>";
					echo " window.opener.document.FrmSolicitud.action='cal_solicitud.php?ValorCheck=".$ValCheck."&Productos=".$Productos."&SubProducto=".$SubProducto."&Modificar=".$Modificando."';";
					echo " window.opener.document.FrmSolicitud.submit();";
					echo "window.close();</script>";
				}
				else
				{
					echo "<script languaje='JavaScript'>";
					echo " window.opener.document.FrmSolicitud.action='cal_solicitud.php?ValorCheck=".$ValCheck."';";
					echo " window.opener.document.FrmSolicitud.submit();";
					echo "window.close();</script>";
				}		
			}
			else
			{
				if ($Modificando=='S')
				{			
					echo "<script languaje='JavaScript'>";
					echo " window.opener.document.FrmSolicitudAut.action='cal_solicitud_Automatica.php?ValorCheck=".$ValCheck."&Productos=".$Productos."&SubProducto=".$SubProducto."&Modificar=".$Modificando."';";
					echo " window.opener.document.FrmSolicitudAut.submit();";
					echo "window.close();</script>";
				}	
				else
				{
					echo "<script languaje='JavaScript'>";
					echo " window.opener.document.FrmSolicitudAut.action='cal_solicitud_Automatica.php?ValorCheck=".$ValCheck."&CmbProductos=".$Productos."&CmbSubProducto=".$SubProducto."&Buscar=".$BuscarDetalle."&BuscarPrv=".$BuscarPrv."&CmbRutPrv=".$CmbRutPrv."';";
					echo " window.opener.document.FrmSolicitudAut.submit();";
					echo "window.close();</script>";
				}	
			}	
		}	
	}
	else
	{
		if ($Personalizar =='S')
		{
			if ($CodPlantilla == "")
			{
				$Consulta = "select max(cod_plantilla) as plantilla from plantillas";
				$Respuesta = mysqli_query($link, $Consulta);
				$Fila=mysqli_fetch_array($Respuesta);
				$CodPlantilla = $Fila["plantilla"] + 1;
			}	
			if ($Rut=='0')
			{
				$Tipo='G';
			}
			else
			{
				$Tipo='P';			
			}
			$Consulta="select * from plantillas where rut_funcionario ='".$Rut."' and cod_plantilla=".$CodPlantilla;
			$Respuesta = mysqli_query($link, $Consulta);
			if (!$Fila=mysqli_fetch_array($Respuesta))
			{
				$Insertar = "insert into plantillas (rut_funcionario,cod_plantilla,nombre_plantilla,cod_producto,cod_subproducto,tipo_plantilla)";
				$Insertar = $Insertar." values ('$Rut','$CodPlantilla','$NombrePlantilla','$Productos','$SubProducto','$Tipo')";
				mysqli_query($link, $Insertar);		
			}
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
							$Consulta="select * from leyes_por_plantillas where rut_funcionario ='".$Rut."' and cod_plantilla=".$CodPlantilla." and cod_leyes='".$Ley."'";
							$Respuesta = mysqli_query($link, $Consulta);
							if (!$Fila=mysqli_fetch_array($Respuesta))
							{
								$Insertar = "insert into leyes_por_plantillas (rut_funcionario,cod_plantilla,cod_leyes,cod_unidad) values ('$Rut','$CodPlantilla','$Ley','$Unidad')";
								mysqli_query($link, $Insertar);
							}	
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
							$Insertar = "insert into leyes_por_plantillas (rut_funcionario,cod_plantilla,cod_leyes,cod_unidad) values ('$Rut','$CodPlantilla','$Impureza','$Unidad')";
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
							$Insertar = "insert into leyes_por_plantillas (rut_funcionario,cod_plantilla,cod_leyes,cod_unidad) values ('$Rut','$CodPlantilla','$Fisica','$Unidad')";
							mysqli_query($link, $Insertar);
						}
					}
				$LeyesFisicas=substr($LeyesFisicas,$k + 2);
				$k = 0;
				}
			}
			echo "<script languaje='JavaScript'>";
			echo " window.opener.document.FrmPersonalizar.action='cal_personalizar_plantilla.php?Plantilla=".$CodPlantilla."&Salir=".$Salir."&NombrePlantilla=".$NombrePlantilla."';";
			echo " window.opener.document.FrmPersonalizar.submit();";
			echo "window.close();</script>";
		}	
	}
}
	
?>
