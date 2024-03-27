<? 
	include("../principal/conectar_pcip_web.php");
	$Encontro=false;
	switch($Opcion)
	{
		case "N"://INGRESO DE ASIGNACION 
			$Inserta="insert into pcip_svp_asignacion (cod_asignacion,nom_asignacion,vigente,mostrar_asig,mostrar_ppc)";
			$Inserta.=" values('".$TxtCodigo."','".strtoupper($TxtAsignacion)."','".$CmbVig."','".$CmbMAsig."','".$CmbMPpc."')";
			mysql_query($Inserta);
			//echo $Inserta;
			header('location:pcip_mantenedor_tipo_asignacion_proceso.php?Opc=M&Valores='.$TxtCodigo);			
		    break;
		    
		case "M"://MODIFICACION DE ASIGNACION
			$Actualizar="UPDATE pcip_svp_asignacion set nom_asignacion='".strtoupper($TxtAsignacion)."',vigente='".$CmbVig."',mostrar_asig='".$CmbMAsig."',mostrar_ppc='".$CmbMPpc."'";
			$Actualizar.=" where cod_asignacion='".$TxtCodigo."'";	
			//echo $Actualizar;
			mysql_query($Actualizar);
			header('location:pcip_mantenedor_tipo_asignacion_proceso.php?Opc=M&Valores='.$TxtCodigo);	
            break;
			
		case "E"://ELIMINACION DE LA ASIGNACION
			$Mensaje='N';
			$Datos = explode("//",$Valor);
			while (list($clave,$TxtCodigo)=each($Datos))
			{
								
				$Consulta="select * from pcip_svp_asignaciones_productos where cod_asignacion='".$TxtCodigo."'";
				$Respuesta=mysqli_query($link, $Consulta);
				//echo $Consulta;
				if(!$Fila=mysql_fetch_array($Respuesta))
				{
							
					$Eliminar="delete from pcip_svp_asignacion where cod_asignacion='".$TxtCodigo."'";
					mysql_query($Eliminar);
					//echo $Eliminar;
				}
				else
				{
					$Mensaje="S";
					break;	
				}	
		    }
		header("location:pcip_mantenedor_tipo_asignacion.php?Mensaje=".$Mensaje."&BuscarAux=S&CmbVig=-1&CmbAsign=-1");
		break;
	}
?>
