<? 
	include("../principal/conectar_pcip_web.php");
	$Encontro=false;
	switch($Opcion)
	{
		case "N":
			
			$Inserta="insert into pcip_eec_sistemas (cod_sistema,nom_sistema,descripcion,vigente,mostrar)";
			$Inserta.=" values('".$TxtCodigo."','".strtoupper($TxtSistema)."','".strtoupper($TxtDescrip)."','".$CmbVig."','".$CmbMostrar."')";
			mysql_query($Inserta);
			//echo $Inserta;
			$Mensaje=1;
			header('location:pcip_mantenedor_nuevo_sistema_proceso.php?Opc=M&Valores='.$TxtCodigo.'&Mensaje=1');			
		    break;
		    
		case "M":
			$Actualizar="UPDATE pcip_eec_sistemas set nom_sistema = '".strtoupper($TxtSistema)."', descripcion='".strtoupper($TxtDescrip)."',vigente='".$CmbVig."',mostrar='".$CmbMostrar."'";
			$Actualizar.=" where cod_sistema='".$TxtCodigo."'";	
			//echo $Actualizar;
			mysql_query($Actualizar);
			$Mensaje=2;
			header('location:pcip_mantenedor_nuevo_sistema_proceso.php?Opc=M&Valores='.$TxtCodigo.'&Mensaje=2');	
            break;
			
		case "E":
			$Mensaje='N';
			$Datos = explode("//",$Valor);
			while (list($clave,$TxtCodigo)=each($Datos))
			{
								
				$Consulta="select * from pcip_eec_equipos_por_sistema where cod_sistema='".$TxtCodigo."'";
				$Respuesta=mysql_query($Consulta);
				//echo $Consulta;
				if(!$Fila=mysql_fetch_array($Respuesta))
				{
							
					$Eliminar="delete from pcip_eec_sistemas where cod_sistema='".$TxtCodigo."'";
					mysql_query($Eliminar);
					//echo $Eliminar;
				
				}
				else
				{
					$Mensaje="S";
					break;	
				}	
		    }
			header("location:pcip_mantenedor_nuevo_sistema.php?Mensaje=".$Mensaje."&Buscar=S&CmbSistema=-1");
		break;
	}
?>
