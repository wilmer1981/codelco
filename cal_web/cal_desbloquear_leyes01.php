<?php 
include("../principal/conectar_principal.php");
$CookieRut=$_COOKIE["CookieRut"];
$RutQ=$CookieRut;
$Fecha=date("Y-m-d H:i:s");
$Fecha2=date("Y-m-d H:i");


$Proceso = $_REQUEST["Proceso"];
$Valores = $_REQUEST["Valores"];
$ValoresSA = $_REQUEST["ValoresSA"];
$Tipo = $_REQUEST["Tipo"];
$PW = $_REQUEST["PW"];

$ValoresAux=$Valores;
for ($i=0;$i<=strlen($Valores);$i++)
{
	if (substr($Valores,$i,2)=="~~")
	{
		$SA = substr($Valores,0,$i);
		$RutLeyesRecargoValor = substr($Valores,$i+2);
		for ($j=0;$j<=strlen($RutLeyesRecargoValor);$j++)
		{
			if (substr($RutLeyesRecargoValor,$j,2)=="||")
			{
				$Rut=substr($RutLeyesRecargoValor,0,$j);
				$LeyesRecargoValor=substr($RutLeyesRecargoValor,$j+2);
				for ($k=0;$k<=strlen($LeyesRecargoValor);$k++)
				{
					if (substr($LeyesRecargoValor,$k,2)=="")
					{
						$Leyes=substr($LeyesRecargoValor,0,$k);
						$RecargoValor=substr($LeyesRecargoValor,$k+2);
						for ($l=0;$l<=strlen($RecargoValor);$l++)
						{
							if (substr($RecargoValor,$l,2)=="//")
							{
								$Recargo=substr($RecargoValor,0,$l);
								$Valor=substr($RecargoValor,l+3);
								$Valor=substr($Valor,0,strlen($Valor)-2);
								$Valores="";
							}
						}		
					}
				}	
			}
		}	
	}
}
$Entrar=true;
switch ($Proceso)
{
	case "A"://DESBLOQUEA LA LEY PREVIA AUTORIZACION DEL JEFE
		$Consulta = "select count(*) as existe from proyecto_modernizacion.funcionarios where rut ='".$CookieRut."' and password2 = md5('".strtoupper(trim($PW))."')";
		$Respuesta=mysqli_query($link, $Consulta);
		$Fila= mysqli_fetch_array($Respuesta);
		if ($Fila[existe] == 0)
		{
			header("location:cal_desbloquear_leyes.php?PWValida=N&Valores=".$ValoresAux."&ValoresSA=".$ValoresSA."&Tipo=".$Tipo);
			$Entrar=false;
			break;
		}
		if ($Recargo!='N')
		{
			$Actualizar="UPDATE cal_web.leyes_por_solicitud set candado='0',rut_quimico='".$RutQ."' where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."' and recargo='".$Recargo."'";
			$Consulta = "select valor,cod_unidad,signo,(case when peso_humedo is null then 'NULL' else peso_humedo end) as peso_humedo,(case when peso_seco is null then 'NULL' else peso_seco end) as peso_seco from cal_web.leyes_por_solicitud where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."' and recargo='".$Recargo."'";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$Insertar="insert into cal_web.registro_leyes(nro_solicitud,recargo,fecha_hora,rut_funcionario,cod_leyes,peso_humedo,peso_seco,valor,cod_unidad,candado,rut_proceso,signo) values(";
			$Insertar=$Insertar.$SA.",'";
			$Insertar=$Insertar.$Recargo."','";
			$Insertar=$Insertar.$Fecha."','";
			$Insertar=$Insertar.$Rut."','";
			$Insertar=$Insertar.$Leyes."',";
			$Insertar=$Insertar.$Fila["peso_humedo"].",";
			$Insertar=$Insertar.$Fila["peso_seco"].",";
			$Insertar=$Insertar.$Fila["valor"].",'";
			$Insertar=$Insertar.$Fila["cod_unidad"]."',";
			$Insertar=$Insertar."'0','".$RutQ."','".$Fila["signo"]."')";
			$Consulta = "select * from cal_web.estados_por_solicitud where (nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and recargo='".$Recargo."' and cod_estado='6')";
			$Respuesta=mysqli_query($link, $Consulta);
			if ($Fila= mysqli_fetch_array($Respuesta))
			{
				$Eliminar="delete from cal_web.estados_por_solicitud where (nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and recargo='".$Recargo."' and cod_estado='6')";
				mysqli_query($link, $Eliminar);
				$Actualizar2= "UPDATE  cal_web.solicitud_analisis set estado_actual ='5' where rut_funcionario = '".$Rut."' and nro_solicitud = '".$SA."' and recargo='".$Recargo."'";
				mysqli_query($link, $Actualizar2);
			}
		}
		else
		{
			$Actualizar="UPDATE cal_web.leyes_por_solicitud set candado='0',rut_quimico='".$RutQ."' where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."'";		
			$Consulta = "select valor,cod_unidad,signo,(case when peso_humedo is null then 'NULL' else peso_humedo end) as peso_humedo,(case when peso_seco is null then 'NULL' else peso_seco end) as peso_seco from cal_web.leyes_por_solicitud where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."'";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$Insertar="insert into cal_web.registro_leyes(nro_solicitud,fecha_hora,rut_funcionario,cod_leyes,peso_humedo,peso_seco,valor,cod_unidad,candado,rut_proceso,signo) values(";
			$Insertar=$Insertar.$SA.",'";
			$Insertar=$Insertar.$Fecha."','";
			$Insertar=$Insertar.$Rut."','";
			$Insertar=$Insertar.$Leyes."',";
			$Insertar=$Insertar.$Fila["peso_humedo"].",";
			$Insertar=$Insertar.$Fila["peso_seco"].",";
			$Insertar=$Insertar.$Fila["valor"].",'";
			$Insertar=$Insertar.$Fila["cod_unidad"]."',";
			$Insertar=$Insertar."'0','".$RutQ."','".$Fila["signo"]."')";
			$Consulta = "select * from cal_web.estados_por_solicitud where (nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_estado='6')";
			$Respuesta=mysqli_query($link, $Consulta);
			if ($Fila= mysqli_fetch_array($Respuesta))
			{
				$Eliminar="delete from cal_web.estados_por_solicitud where (nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_estado='6')";
				mysqli_query($link, $Eliminar);
				$Actualizar2= "UPDATE  cal_web.solicitud_analisis set estado_actual ='5' where rut_funcionario = '".$Rut."' and nro_solicitud = '".$SA."'";
				mysqli_query($link, $Actualizar2);
			}
		}	
		mysqli_query($link, $Actualizar);
		mysqli_query($link, $Insertar);
		break;
	/*case "G"://SE ASIGNA EL CANDADO 
		if ($Recargo!='N')
		{
			$Actualizar="UPDATE cal_web.leyes_por_solicitud set candado='1',rut_quimico='".$RutQ."' where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."' and recargo='".$Recargo."'";
			mysqli_query($link, $Actualizar);//ACTUALIZA EL CANDADO
			$Consulta = "select valor,cod_unidad,(case when peso_humedo is null then 'NULL' else peso_humedo end) as peso_humedo,(case when peso_seco is null then 'NULL' else peso_seco end) as peso_seco from cal_web.leyes_por_solicitud where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."' and recargo='".$Recargo."'";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$Insertar="insert into cal_web.registro_leyes(nro_solicitud,recargo,fecha_hora,rut_funcionario,cod_leyes,peso_humedo,peso_seco,valor,cod_unidad,candado,rut_proceso) values(";
			$Insertar=$Insertar.$SA.",'";
			$Insertar=$Insertar.$Recargo."','";
			$Insertar=$Insertar.$Fecha."','";
			$Insertar=$Insertar.$Rut."','";
			$Insertar=$Insertar.$Leyes."',";
			$Insertar=$Insertar.$Fila["peso_humedo"].",";
			$Insertar=$Insertar.$Fila["peso_seco"].",";
			$Insertar=$Insertar.$Fila["valor"].",'";
			$Insertar=$Insertar.$Fila["cod_unidad"]."',";
			$Insertar=$Insertar."'1','".$RutQ."')";
			mysqli_query($link, $Insertar);//INSERTA EL REGISTRO DE LEYES
			//SE PREGUNTA PARA SABER SI HAY QUE FINALIZAR LA SOLICITUD 
			$Consulta = "select count(*) as existe from cal_web.leyes_por_solicitud where (nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and recargo='".$Recargo."' and candado <> '1')";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila= mysqli_fetch_array($Respuesta);
			if ($Fila["existe"]== 0)
			{
				$Consulta = "select count(*) as existe_at_quimico from cal_web.estados_por_solicitud where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and recargo='".$Recargo."' and cod_estado = '5'";
				$Respuesta2=mysqli_query($link, $Consulta);
				$Fila2= mysqli_fetch_array($Respuesta2);
				if ($Fila2["existe_at_quimico"]==0)
				{
					$insertar3 ="insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,rut_proceso)";
					$insertar3.="values ('".$Rut."','".$SA."','".$Recargo."','5','".$Fecha2."','".$RutQ."')";
					mysqli_query($link, $insertar3);					
				}
				$insertar2 ="insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,recargo,cod_estado,fecha_hora,rut_proceso)";
				$insertar2.="values ('".$Rut."','".$SA."','".$Recargo."','6','".$Fecha2."','".$RutQ."')";
				$Actualizar2= "UPDATE  cal_web.solicitud_analisis set estado_actual ='6' where rut_funcionario = '".$Rut."' and nro_solicitud = '".$SA."' and recargo='".$Recargo."'";
				mysqli_query($link, $insertar2);
				mysqli_query($link, $Actualizar2);
			}
		}
		else//SIN RECARGOS
		{
			$Actualizar="UPDATE cal_web.leyes_por_solicitud set candado='1',rut_quimico='".$RutQ."' where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."'";		
			mysqli_query($link, $Actualizar);//ACTUALIZA EL CANDADO
			$Consulta = "select valor,cod_unidad,(case when peso_humedo is null then 'NULL' else peso_humedo end) as peso_humedo,(case when peso_seco is null then 'NULL' else peso_seco end) as peso_seco from cal_web.leyes_por_solicitud where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_leyes ='".$Leyes."'";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$Insertar="insert into cal_web.registro_leyes(nro_solicitud,fecha_hora,rut_funcionario,cod_leyes,peso_humedo,peso_seco,valor,cod_unidad,candado,rut_proceso) values(";
			$Insertar=$Insertar.$SA.",'";
			$Insertar=$Insertar.$Fecha."','";
			$Insertar=$Insertar.$Rut."','";
			$Insertar=$Insertar.$Leyes."',";
			$Insertar=$Insertar.$Fila["peso_humedo"].",";
			$Insertar=$Insertar.$Fila["peso_seco"].",";
			$Insertar=$Insertar.$Fila["valor"].",'";
			$Insertar=$Insertar.$Fila["cod_unidad"]."',";
			$Insertar=$Insertar."'1','".$RutQ."')";
			mysqli_query($link, $Insertar);//INSERTA EL REGISTRO DE LEYES
			//SE PREGUNTA PARA SABER SI HAY QUE FINALIZAR LA SOLICITUD 
			$Consulta = "select count(*) as existe from cal_web.leyes_por_solicitud where (nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and candado <> '1')";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila= mysqli_fetch_array($Respuesta);
			if ($Fila["existe"] == 0)
			{
				$Consulta = "select count(*) as existe_at_quimico from cal_web.estados_por_solicitud where nro_solicitud=".$SA." and rut_funcionario ='".$Rut."' and cod_estado = 5";
				$Respuesta2=mysqli_query($link, $Consulta);
				$Fila2= mysqli_fetch_array($Respuesta2);
				if ($Fila2["existe_at_quimico"]==0)
				{
					$insertar3 ="insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,cod_estado,fecha_hora,rut_proceso)";
					$insertar3.="values ('".$Rut."','".$SA."','5','".$Fecha2."','".$RutQ."')";
					mysqli_query($link, $insertar3);
				}
				$insertar2 ="insert into cal_web.estados_por_solicitud (rut_funcionario,nro_solicitud,cod_estado,fecha_hora,rut_proceso) ";
				$insertar2.="values ('".$Rut."','".$SA."','6','".$Fecha2."','".$RutQ."')";
				$Actualizar2= "UPDATE  cal_web.solicitud_analisis set estado_actual ='6' where rut_funcionario = '".$Rut."' and nro_solicitud = '".$SA."'";
				mysqli_query($link, $insertar2);
				mysqli_query($link, $Actualizar2);
			}
		}	
		break;*/
}
if ($Entrar==true)
{
	if(($Proceso=='A') or ($Proceso=='S'))
	{
		echo "<script languaje='JavaScript'>";
		switch ($Tipo)
		{
			case "L":
				echo " window.opener.document.FrmIngresoValorLeyes.action='cal_ingreso_valor_leyes.php?ValoresSA=".$ValoresSA."';";
				echo " window.opener.document.FrmIngresoValorLeyes.submit();";		
				break;
			case "I":
				echo " window.opener.document.FrmIngresoValorImpureza.action='cal_ingreso_valor_impurezas.php?ValoresSA=".$ValoresSA."';";			
				echo " window.opener.document.FrmIngresoValorImpureza.submit();";
				break;
			case "H":
				echo " window.opener.document.FrmIngresoValorHum.action='cal_ingreso_valor_humedad.php?ValoresSA=".$ValoresSA."&CheckT=N';";			
				echo " window.opener.document.FrmIngresoValorHum.submit();";
				break;
			case "R":
				echo " window.opener.document.FrmIngresoValorRetalla.action='cal_ingreso_valor_retalla.php?ValoresSA=".$ValoresSA."';";
				echo " window.opener.document.FrmIngresoValorRetalla.submit();";		
				break;
		}
		echo "window.close();</script>";
	}
	else
	{
		switch ($Tipo)
		{
			case "L":
				header ("location:cal_ingreso_valor_leyes.php?ValoresSA=".$ValoresSA);
				break;
			case "I":
				header ("location:cal_ingreso_valor_impurezas.php?ValoresSA=".$ValoresSA);
				break;
			case "H":
				header ("location:cal_ingreso_valor_humedad.php?ValoresSA=".$ValoresSA);
				break;
			case "R":
				header ("location:cal_ingreso_valor_retalla.php?ValoresSA=".$ValoresSA);
				break;
		}		
	}	
}

?>