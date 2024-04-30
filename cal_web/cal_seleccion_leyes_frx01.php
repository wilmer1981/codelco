<?php
include("../principal/conectar_principal.php");
$Fecha_Hora=date("Y-m-d h:i:s");
	switch ($Proceso)
	{
		case "M":
			if ($Recargo!='N')
			{
				$Consulta="select * from cal_web.leyes_por_solicitud where nro_solicitud=".$SA." and recargo ='".$Recargo."' and cod_leyes='".$Ley."'";
				$Respuesta = mysqli_query($link, $Consulta);
				$Fila=mysqli_fetch_array($Respuesta);
				$Rut_F=$Fila["rut_funcionario"];
				if (is_null($Fila[Valor]))
				{
					$Valor='NULL';
				}	
				else
				{
					$Valor=$Fila[Valor];
				}
				$Unidad=$Fila[cod_unidad];
				$Candado=$Fila[candado];
				$Signo=$Fila["signo"];
				$Rut_Proceso=$Fila[rut_proceso];
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
				if (is_null($Fila[Valor]))
				{
					$Valor='NULL';
				}	
				else
				{
					$Valor=$Fila[Valor];
				}
				$Unidad=$Fila[cod_unidad];
				$Candado=$Fila[candado];
				$Signo=$Fila["signo"];
				$Rut_Proceso=$Fila[rut_proceso];
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
				if (is_null($Fila[Valor]))
				{
					$Valor='NULL';
				}	
				else
				{
					$Valor=$Fila[Valor];
				}
				$Prod=$Fila["cod_producto"];
				$SubPro=$Fila["cod_subproducto"];
				$Muestra=$Fila["id_muestra"];
				$Unidad=$Fila[cod_unidad];
				$Candado=$Fila[candado];
				$Signo=$Fila["signo"];
				$Rut_Proceso=$Fila[rut_proceso];
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
				if (is_null($Fila[Valor]))
				{
					$Valor='NULL';
				}	
				else
				{
					$Valor=$Fila[Valor];
				}
				$Prod=$Fila["cod_producto"];
				$SubPro=$Fila["cod_subproducto"];
				$Muestra=$Fila["id_muestra"];
				$Unidad=$Fila[cod_unidad];
				$Candado=$Fila[candado];
				$Signo=$Fila["signo"];
				$Rut_Proceso=$Fila[rut_proceso];
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
			if ($Recargo!='N')
			{
				$Consulta="select * from cal_web.leyes_por_solicitud where nro_solicitud=".$SA." and recargo ='".$Recargo."' and cod_leyes='".$Ley."'";
				$Respuesta = mysqli_query($link, $Consulta);
				$Fila=mysqli_fetch_array($Respuesta);
				$Rut_F=$Fila["rut_funcionario"];
				if (is_null($Fila[Valor]))
				{
					$Valor='NULL';
				}	
				else
				{
					$Valor=$Fila[Valor];
				}
				$Unidad=$Fila[cod_unidad];
				$Candado=$Fila[candado];
				$Insertar="insert into cal_web.registro_leyes(rut_funcionario,fecha_hora,nro_solicitud,recargo,cod_leyes,valor,cod_unidad,candado,signo,rut_proceso) values (";
				$Insertar=$Insertar."'$Rut_F','$Fecha_Hora',$SA,'$Recargo','$Ley',$Valor,'$Unidad','$Candado','E','$CookieRut')";
				mysqli_query($link, $Insertar);
				$Eliminar="delete from cal_web.leyes_por_solicitud where nro_solicitud=".$SA." and recargo = '".$Recargo."' and cod_leyes='".$Ley."'"; 
				mysqli_query($link, $Eliminar);
			}
			else
			{
				$Consulta="select * from cal_web.leyes_por_solicitud where nro_solicitud=".$SA." and cod_leyes='".$Ley."'";
				$Respuesta = mysqli_query($link, $Consulta);
				$Fila=mysqli_fetch_array($Respuesta);
				$Rut_F=$Fila["rut_funcionario"];
				if (is_null($Fila[Valor]))
				{
					$Valor='NULL';
				}	
				else
				{
					$Valor=$Fila[Valor];
				}
				$Unidad=$Fila[cod_unidad];
				$Candado=$Fila[candado];
				$Insertar="insert into cal_web.registro_leyes(rut_funcionario,fecha_hora,nro_solicitud,cod_leyes,valor,cod_unidad,candado,signo,rut_proceso) values (";
				$Insertar=$Insertar."'$Rut_F','$Fecha_Hora',$SA,'$Ley',$Valor,'$Unidad','$Candado','E','$CookieRut')";
				mysqli_query($link, $Insertar);
				$Eliminar="delete from cal_web.leyes_por_solicitud where nro_solicitud=".$SA." and cod_leyes='".$Ley."'"; 
				mysqli_query($link, $Eliminar);
			}
			break;
	}
	if ($Proceso=='E')
	{
		header("location:cal_ingreso_valor_leyes_frx.php?ValoresSA=".$ValoresSA);
	}
	else
	{
		echo "<script languaje='JavaScript'>";		
		echo " window.opener.document.FrmIngresoValorLeyes.action='cal_ingreso_valor_leyes_frx.php?ValoresSA=".$ValoresSA."';";
		echo " window.opener.document.FrmIngresoValorLeyes.submit();";		
		echo " window.close();</script>";
	}	
?>
