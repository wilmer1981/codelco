<? 
	include("../principal/conectar_pcip_web.php");
    switch ($Opc)
	{
		 case "G": 
		 	if($CmbUltVersion=='S')
			{
				$Actualizar="UPDATE pcip_ppc_version set ult_version='N' where ano='".$Ano."'";
				mysql_query($Actualizar);
			}
			$Inserta="insert into pcip_ppc_version (version,ano,mes,fecha_creacion,descripcion,ult_version)";
			$Inserta.=" values('".$TxtVersion."','".$Ano."','".$Mes."','".date('Y-m-d')."','".strtoupper($TxtDescripcion)."','".$CmbUltVersion."')";
			mysql_query($Inserta);
			//echo $Inserta;
			header('location:pcip_mantenedor_versiones_ppc.php');			
		    break;
	    case "M"://MODIFICAR INDICADOR
			$Actualizar="UPDATE pcip_ppc_version set mes='".$Mes."',descripcion = '".strtoupper($TxtDescripcion)."',fecha_creacion='".$FCreacion."',ult_version='".$CmbUltVersion."'";
			$Actualizar.=" where version='".$TxtVersion."' and ano='".$Ano."' and mes='".$Mes."'" ;	
			//echo $Actualizar;
			mysql_query($Actualizar);
			$Mensaje='Versi�n Modificada Exitosamente';
			header('location:pcip_mantenedor_versiones_ppc.php?Mensaje='.$Mensaje);	
            break;
			
		case "E":
			$Mensaje='';
			$Consulta="select * from pcip_ppc_detalle where version='".$Cod."' and ano='".$Ano."'";
			$Resp=mysql_query($Consulta);
			if(!$Fila=mysql_fetch_array($Resp))
			{
				$Eliminar="delete from pcip_ppc_version where version='".$Cod."'  and ano='".$Ano."'";
				mysql_query($Eliminar);
				//echo $Eliminar;
			}
			else
				$Mensaje='No se puede Eliminar Version, Existen Datos Relacionados ';
			header("location:pcip_mantenedor_versiones_ppc.php?Mensaje=".$Mensaje);
		    break;
		case "D":
			$Mensaje='';
			$Consulta = "select ifnull(max(version)+1,1) as nueva_version from pcip_ppc_version where ano='".$Ano."'";			
			$Resp = mysql_query($Consulta);
			if($Fila=mysql_fetch_array($Resp))
				$TxtVersion=$Fila[nueva_version];
				
			$Actualizar="UPDATE pcip_ppc_version set ult_version='N' where ano='".$Ano."'";
			mysql_query($Actualizar);			 
				
			$Inserta="insert into pcip_ppc_version (version,ano,mes,fecha_creacion,descripcion,ult_version)";
			$Inserta.=" values('".$TxtVersion."','".$Ano."','".$Mes."','".date('Y-m-d')."','','S')";
			mysql_query($Inserta);
			//echo $Inserta."<br>";

			$Consulta="select * from pcip_ppc_detalle where version='".$Cod."' and ano='".$Ano."'";
			$Resp=mysql_query($Consulta);
			while($Fila=mysql_fetch_array($Resp))
			{
				$Insertar="insert into pcip_ppc_detalle (version,ano,mes,cod_asignacion,cod_procedencia,tipo,cod_negocio,cod_titulo,valor) values ";
				$Insertar.="('".$TxtVersion."','".$Fila[ano]."','".$Fila[mes]."','".$Fila[cod_asignacion]."','".$Fila[cod_procedencia]."','".$Fila[tipo]."',".$Fila[cod_negocio].",".$Fila[cod_titulo].",'".str_replace(',','.',$Fila[valor])."')";
				//echo $Insertar."<br>";
				mysql_query($Insertar);
				$Mensaje='Versi�n Duplicada con Exito';
			}			
			header("location:pcip_mantenedor_versiones_ppc.php?Mensaje=".$Mensaje);
		    break;
	}
?>
