<? 
	include("../principal/conectar_sget_web.php");
	include("funciones/sget_funciones.php");
	$Fecha_Creacion= date("Y-m-d G:i:s");
	switch($Opcion)
	{
		case "N"://NUEVO EVALUACION
			$Datos=explode('||',$Valores);
			foreach($Datos as $c => $v)
			{
				$Codigos=explode('~~',$v);
				$Insertar="Insert Into sget_evaluacion_adm(cod_contrato,nro_evaluacion,cod_evaluacion,cod_nota,fecha,tipo)";
				$Insertar.="values('".$CmbContrato."','".$CmbNumEval."','".$Codigos[0]."','".$Codigos[1]."','".date('Y-m-d')."','C')";
				mysql_query($Insertar);
				//echo $Insertar."<br>";
			}
			header("location:sget_evaluacion_adm_proceso.php?Mensaje=1&Opcion=M&Recarga=S&CmbContrato=".$CmbContrato."&CmbNumEval=".$CmbNumEval);
		break;
		case "M"://MODIFICAR EVALUACION
			$Eliminar="delete from sget_evaluacion_adm where cod_contrato='".$CmbContrato."' and nro_evaluacion='".$CmbNumEval."'";
			mysql_query($Eliminar);
			$Datos=explode('||',$Valores);
			foreach($Datos as $c => $v)
			{
				$Codigos=explode('~~',$v);
				$Insertar="Insert Into sget_evaluacion_adm(cod_contrato,nro_evaluacion,cod_evaluacion,cod_nota,fecha,tipo)";
				$Insertar.="values('".$CmbContrato."','".$CmbNumEval."','".$Codigos[0]."','".$Codigos[1]."','".date('Y-m-d')."','C')";
				mysql_query($Insertar);
				//echo $Actualizar;
			}
			header("location:sget_evaluacion_adm_proceso.php?Mensaje=1&Opcion=M&Recarga=S&CmbContrato=".$CmbContrato."&CmbNumEval=".$CmbNumEval);
		break;
		case "E"://ELIMINAR EVALUACION
			$Datos=explode('||',$Valores);
			foreach($Datos as $c => $v)
			{
				$Codigos=explode('~~',$v);
				$Eliminar="delete from sget_evaluacion_adm where cod_contrato='".$Codigos[0]."' and nro_evaluacion='".$Codigos[1]."'";
				//echo $Eliminar;
				mysql_query($Eliminar);	
			}
			header("location:sget_evaluacion_adm.php?Buscar=S");
		break;
	}
?>
