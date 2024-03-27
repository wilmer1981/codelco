<? 
	include("../principal/conectar_pcip_web.php");
	$Encontro=false;
	switch($Opcion)
	{
		case "N":			
			$Inserta="insert into pcip_eec_equipos (cod_equipo,nom_equipo)";
			$Inserta.=" values('".$TxtCodigo."','".strtoupper($TxtEquipo)."')";
			mysql_query($Inserta);
			//echo $Inserta;
			header('location:pcip_mantenedor_nuevo_equipos_proceso.php?Opc=M&Valores='.$TxtCodigo);			
		    break;
		    
		case "M":
			$Actualizar="UPDATE pcip_eec_equipos set nom_equipo = '".strtoupper($TxtEquipo)."' ";
			$Actualizar.=" where cod_equipo='".$TxtCodigo."'";	
			//echo $Actualizar;
			mysql_query($Actualizar);
			header('location:pcip_mantenedor_nuevo_equipos_proceso.php?Opc=M&Valores='.$TxtCodigo);	
            break;
			
		case "E":
			$Mensaje='N';
			$Datos = explode("//",$Valor);
			while (list($clave,$TxtCodigo)=each($Datos))
			{
								
				$Consulta="select * from pcip_eec_equipos_por_sistema where cod_equipo='".$TxtCodigo."'";
				$Respuesta=mysqli_query($link, $Consulta);
				//echo $Consulta;
				if(!$Fila=mysql_fetch_array($Respuesta))
				{
							
					$Eliminar="delete from pcip_eec_equipos where cod_equipo='".$TxtCodigo."'";
					mysql_query($Eliminar);
					//echo $Eliminar;
				
				}
				else
				{
					$Mensaje="S";
					break;	
				}	
		    }
			header("location:pcip_mantenedor_nuevo_equipos.php?Mensaje=".$Mensaje."&Buscar=S&CmbEquipo=-1");
		break;
	}
?>
