<?php
include("../principal/conectar_principal.php");
$CookieRut=$_COOKIE["CookieRut"];
$Fecha_Hora=date("Y-m-d h:i:s");

$Pantalla = $_REQUEST["Pantalla"];
$ValoresSA = $_REQUEST["ValoresSA"];
$ValoresCheck = $_REQUEST["ValoresCheck"];
$LeyNueva = $_REQUEST["LeyNueva"];
$UnidadNueva = $_REQUEST["UnidadNueva"];
$SA = $_REQUEST["SA"];
$Ley = $_REQUEST["Ley"];
$Recargo = $_REQUEST["Recargo"];
$Proceso = $_REQUEST["Proceso"];

	switch ($Proceso)
	{
		case "M":
			if ($Recargo!='N')
			{
				$Consulta="select * from cal_web.leyes_por_solicitud where nro_solicitud=".$SA." and recargo ='".$Recargo."' and cod_leyes='".$Ley."'";
				$Respuesta = mysqli_query($link, $Consulta);
				$Fila=mysqli_fetch_array($Respuesta);
				$Rut_F=$Fila["rut_funcionario"];
				if (is_null($Fila["valor"]))
				{
					$Valor='NULL';
				}	
				else
				{
					$Valor=$Fila["valor"];
				}
				$Unidad=$Fila["cod_unidad"];
				$Candado=$Fila["candado"];
				$Signo=$Fila["signo"];
				$Rut_Proceso=$Fila["rut_proceso"];
				$Insertar="insert into cal_web.registro_leyes(rut_funcionario,fecha_hora,nro_solicitud,recargo,cod_leyes,valor,cod_unidad,candado,signo,rut_proceso) values (";
				$Insertar=$Insertar."'$Rut_F','$Fecha_Hora',$SA,'$Recargo','$Ley',$Valor,'$Unidad','$Candado','M','$CookieRut')";
				mysqli_query($link, $Insertar);
				$Insertar="insert into cal_web.registro_leyes(rut_funcionario,fecha_hora,nro_solicitud,recargo,cod_leyes,valor,cod_unidad,candado,signo,rut_proceso) values (";
				$Insertar=$Insertar."'$Rut_F','$Fecha_Hora',$SA,'$Recargo','$LeyNueva',$Valor,'$UnidadNueva','$Candado','$Signo','$CookieRut')";
				mysqli_query($link, $Insertar);
				$Actualizar="UPDATE cal_web.leyes_por_solicitud set cod_leyes='".$LeyNueva."',cod_unidad='".$UnidadNueva."' where nro_solicitud=".$SA." and recargo ='".$Recargo."' and cod_leyes='".$Ley."'"; 
				mysqli_query($link, $Actualizar);
			}
			else
			{
				$Consulta="select * from cal_web.leyes_por_solicitud where nro_solicitud=".$SA." and cod_leyes='".$Ley."'";
				$Respuesta = mysqli_query($link, $Consulta);
				$Fila=mysqli_fetch_array($Respuesta);
				$Rut_F=$Fila["rut_funcionario"];
				if (is_null($Fila["valor"]))
				{
					$Valor='NULL';
				}	
				else
				{
					$Valor=$Fila["valor"];
				}
				$Unidad=$Fila["cod_unidad"];
				$Candado=$Fila["candado"];
				$Signo=$Fila["signo"];
				$Rut_Proceso=$Fila["rut_proceso"];
				$Insertar="insert into cal_web.registro_leyes(rut_funcionario,fecha_hora,nro_solicitud,cod_leyes,valor,cod_unidad,candado,signo,rut_proceso) values (";
				$Insertar=$Insertar."'$Rut_F','$Fecha_Hora',$SA,'$Ley',$Valor,'$Unidad','$Candado','M','$CookieRut')";
				mysqli_query($link, $Insertar);
				$Insertar="insert into cal_web.registro_leyes(rut_funcionario,fecha_hora,nro_solicitud,cod_leyes,valor,cod_unidad,candado,signo,rut_proceso) values (";
				$Insertar=$Insertar."'$Rut_F','$Fecha_Hora',$SA,'$LeyNueva',$Valor,'$UnidadNueva','$Candado','$Signo','$CookieRut')";
				mysqli_query($link, $Insertar);
				$Actualizar="UPDATE cal_web.leyes_por_solicitud set cod_leyes='".$LeyNueva."',cod_unidad='".$UnidadNueva."' where nro_solicitud=".$SA." and cod_leyes='".$Ley."'"; 
				mysqli_query($link, $Actualizar);
			}	
			break;
		case "A":
			if ($Recargo!='N')
			{
				$Consulta="select * from cal_web.leyes_por_solicitud where nro_solicitud=".$SA." and recargo ='".$Recargo."' and cod_leyes='".$Ley."'";
				$Respuesta = mysqli_query($link, $Consulta);
				$Fila=mysqli_fetch_array($Respuesta);
				$Rut_F=$Fila["rut_funcionario"];
				if (is_null($Fila["valor"]))
				{
					$Valor='NULL';
				}	
				else
				{
					$Valor=$Fila["valor"];
				}
				$Prod=$Fila["cod_producto"];
				$SubPro=$Fila["cod_subproducto"];
				$Muestra=$Fila["id_muestra"];
				$Unidad=$Fila["cod_unidad"];
				$Candado=$Fila["candado"];
				$Signo=$Fila["signo"];
				$Rut_Proceso=$Fila["rut_proceso"];
				$Insertar="insert into cal_web.registro_leyes(rut_funcionario,fecha_hora,nro_solicitud,recargo,cod_leyes,cod_unidad,signo,rut_proceso) values (";
				$Insertar=$Insertar."'$Rut_F','$Fecha_Hora',$SA,'$Recargo','$LeyNueva','$UnidadNueva','A','$CookieRut')";
				mysqli_query($link, $Insertar);
				$Fecha_Hora=$Fila["fecha_hora"];
				$Insertar="insert into cal_web.leyes_por_solicitud(rut_funcionario,fecha_hora,nro_solicitud,recargo,cod_leyes,cod_unidad,rut_quimico,cod_producto,cod_subproducto,id_muestra) values (";
				$Insertar=$Insertar."'$Rut_F','$Fecha_Hora',$SA,'$Recargo','$LeyNueva','$UnidadNueva','$CookieRut','$Prod','$SubPro','$Muestra')";
				mysqli_query($link, $Insertar);
			}
			else
			{
				$Consulta="select * from cal_web.leyes_por_solicitud where nro_solicitud=".$SA." and cod_leyes='".$Ley."'";
				$Respuesta = mysqli_query($link, $Consulta);
				$Fila=mysqli_fetch_array($Respuesta);
				$Rut_F=$Fila["rut_funcionario"];
				if (is_null($Fila["valor"]))
				{
					$Valor='NULL';
				}	
				else
				{
					$Valor=$Fila["valor"];
				}
				$Prod=$Fila["cod_producto"];
				$SubPro=$Fila["cod_subproducto"];
				$Muestra=$Fila["id_muestra"];
				$Unidad=$Fila["cod_unidad"];
				$Candado=$Fila["candado"];
				$Signo=$Fila["signo"];
				$Rut_Proceso=$Fila["rut_proceso"];
				$Insertar="insert into cal_web.registro_leyes(rut_funcionario,fecha_hora,nro_solicitud,cod_leyes,cod_unidad,signo,rut_proceso) values (";
				$Insertar=$Insertar."'$Rut_F','$Fecha_Hora',$SA,'$LeyNueva','$UnidadNueva','A','$CookieRut')";
				mysqli_query($link, $Insertar);
				$Fecha_Hora=$Fila["fecha_hora"];				
				$Insertar="insert into cal_web.leyes_por_solicitud(rut_funcionario,fecha_hora,nro_solicitud,cod_leyes,cod_unidad,rut_quimico,cod_producto,cod_subproducto,id_muestra) values (";
				$Insertar=$Insertar."'$Rut_F','$Fecha_Hora',$SA,'$LeyNueva','$UnidadNueva','$CookieRut','$Prod','$SubPro','$Muestra')";
				mysqli_query($link, $Insertar);
			}	
			break;
		case "E":
			for ($f=0;$f<=strlen($ValoresCheck);$f++)
			{
				if (substr($ValoresCheck,$f,2)=="//")
				{
					$SARecargoLey=substr($ValoresCheck,0,$f);
					for ($i=0;$i<=strlen($SARecargoLey);$i++)
					{
						if (substr($SARecargoLey,$i,2)=="~~")
						{
							$SA=substr($SARecargoLey,0,$i);
							$RecargoLey=substr($SARecargoLey,$i+2);
							for ($j=0;$j<=strlen($RecargoLey);$j++)
							{
								if (substr($RecargoLey,$j,2)=="||")
								{
									$Recargo=substr($RecargoLey,0,$j);
									$Ley=substr($RecargoLey,$j+2);
									if ($Recargo!='N')
									{
										$Consulta="select * from cal_web.leyes_por_solicitud where nro_solicitud=".$SA." and recargo ='".$Recargo."' and cod_leyes='".$Ley."'";
										$Respuesta = mysqli_query($link, $Consulta);
										$Fila=mysqli_fetch_array($Respuesta);
										$Rut_F=$Fila["rut_funcionario"];
										if (is_null($Fila["valor"]))
										{
											$Valor='NULL';
										}	
										else
										{
											$Valor=$Fila["valor"];
										}
										$Fecha2=$Fila["fecha_hora"];				
										$Unidad=$Fila["cod_unidad"];
										$Candado=$Fila["candado"];
										$Insertar="insert into cal_web.registro_leyes(rut_funcionario,fecha_hora,nro_solicitud,recargo,cod_leyes,valor,cod_unidad,candado,signo,rut_proceso) values (";
										$Insertar=$Insertar."'$Rut_F','$Fecha_Hora',$SA,'$Recargo','$Ley',$Valor,'$Unidad','$Candado','E','$CookieRut')";
										mysqli_query($link, $Insertar);
										$Eliminar="delete from cal_web.leyes_por_solicitud where nro_solicitud=".$SA." and recargo = '".$Recargo."' and cod_leyes='".$Ley."'"; 
										mysqli_query($link, $Eliminar);
										//FINALIZAR SA EN CASO QUE SE ELIMINEN LEYES Y LAS DEMAS ESTAN CON CANDADOS
										$Consulta = "select count(*) as existe from cal_web.leyes_por_solicitud where nro_solicitud=".$SA." and rut_funcionario ='".$Rut_F."' and recargo='".$Recargo."' and candado <> '1'";
										$Respuesta=mysqli_query($link, $Consulta);
										$Fila= mysqli_fetch_array($Respuesta);
										if ($Fila["existe"]== 0)
										{
											$insertar2 ="insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,rut_proceso)";
											$insertar2.="values ('".$Rut_F."','".$SA."','".$Recargo."','6','".$Fecha2."','$CookieRut')";
											mysqli_query($link, $insertar2);
											$Actualizar2= "UPDATE  cal_web.solicitud_analisis set estado_actual ='6' where rut_funcionario = '".$Rut_F."' and nro_solicitud = '".$SA."' and recargo='".$Recargo."'";
											mysqli_query($link, $Actualizar2);
										}
									}
									else
									{
										$Consulta="select * from cal_web.leyes_por_solicitud where nro_solicitud=".$SA." and cod_leyes='".$Ley."'";
										$Respuesta = mysqli_query($link, $Consulta);
										$Fila=mysqli_fetch_array($Respuesta);
										$Rut_F=$Fila["rut_funcionario"];
										if (is_null($Fila["valor"]))
										{
											$Valor='NULL';
										}	
										else
										{
											$Valor=$Fila["valor"];
										}
										$Fecha2=$Fila["fecha_hora"];				
										$Unidad=$Fila["cod_unidad"];
										$Candado=$Fila["candado"];
										$Insertar="insert into cal_web.registro_leyes(rut_funcionario,fecha_hora,nro_solicitud,cod_leyes,valor,cod_unidad,candado,signo,rut_proceso) values (";
										$Insertar=$Insertar."'$Rut_F','$Fecha_Hora',$SA,'$Ley',$Valor,'$Unidad','$Candado','E','$CookieRut')";
										mysqli_query($link, $Insertar);
										$Eliminar="delete from cal_web.leyes_por_solicitud where nro_solicitud=".$SA." and cod_leyes='".$Ley."'"; 
										mysqli_query($link, $Eliminar);
										//FINALIZAR SA EN CASO QUE SE ELIMINEN LEYES Y LAS DEMAS ESTAN CON CANDADOS
										$Consulta = "select count(*) as existe from cal_web.leyes_por_solicitud where nro_solicitud=".$SA." and rut_funcionario ='".$Rut_F."' and candado <> '1'";
										$Respuesta=mysqli_query($link, $Consulta);
										$Fila= mysqli_fetch_array($Respuesta);
										if ($Fila["existe"]== 0)
										{
											$insertar2 ="insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,cod_estado,fecha_hora,rut_proceso)";
											$insertar2.="values ('".$Rut_F."','".$SA."','6','".$Fecha2."','$CookieRut')";
											mysqli_query($link, $insertar2);
											$Actualizar2= "UPDATE  cal_web.solicitud_analisis set estado_actual ='6' where rut_funcionario = '".$Rut_F."' and nro_solicitud = '".$SA."'";
											mysqli_query($link, $Actualizar2);
										}
									}
									$RecargoLey=substr($RecargoLey,$j+2);
									$j=0;		
								}
							}
							$SARecargoLey=substr($SARecargoLey,$i+2);
							$i=0;
						}
					}
					$ValoresCheck=substr($ValoresCheck,$f+2);
					$f=0;
				}
			}						
			break;
	}
	switch ($Pantalla)
	{
		case "L":
			if ($Proceso=='E')
			{
				header("location:cal_ingreso_valor_leyes.php?ValoresSA=".$ValoresSA);
			}
			else
			{
				echo "<script languaje='JavaScript'>";		
				echo " window.opener.document.FrmIngresoValorLeyes.action='cal_ingreso_valor_leyes.php?ValoresSA=".$ValoresSA."';";
				echo " window.opener.document.FrmIngresoValorLeyes.submit();";		
				echo " window.close();</script>";
			}
			break;
		case "R":
			if ($Proceso=='E')
			{
				header("location:cal_ingreso_valor_retalla.php?ValoresSA=".$ValoresSA);
			}
			else
			{
				echo "<script languaje='JavaScript'>";		
				echo " window.opener.document.FrmIngresoValorRetalla.action='cal_ingreso_valor_retalla.php?ValoresSA=".$ValoresSA."';";
				echo " window.opener.document.FrmIngresoValorRetalla.submit();";		
				echo " window.close();</script>";
			}
			break;
		case "H":
			if ($Proceso=='E')
			{
				header("location:cal_ingreso_valor_humedad.php?ValoresSA=".$ValoresSA);
			}
			else
			{
				echo "<script languaje='JavaScript'>";		
				echo " window.opener.document.FrmIngresoValorHum.action='cal_ingreso_valor_humedad.php?ValoresSA=".$ValoresSA."';";
				echo " window.opener.document.FrmIngresoValorHum.submit();";		
				echo " window.close();</script>";
			}
			break;
	}		
				
?>
