<? 
	include("../principal/conectar_pcip_web.php");
	$Encontro=false;
	switch($Opcion)
	{
		case "N"://INGRESO ASIGNACIONES PRODUCTOS
			$Inserta="insert into pcip_svp_asignaciones_productos (cod_asignacion,cod_producto,nom_asignacion,tipo,orden,vigente,mostrar_ppc,cod_unidad,mostrar_cu_elect)";
			$Inserta.=" values('".$CmbAsig."','".$TxtCodigo."','".strtoupper($TxtProd)."','PPC','".$TxtOrden."','".$CmbVig."','1','".$CmbUnidad."','1')";
			mysql_query($Inserta);
			//echo $Inserta;
			header('location:pcip_mantenedor_asignaciones_productos_ppc_proceso.php?Opc=M&Valores='.$TxtCodigo);			
		    break;
		    
		case "M"://MODIFICACION ASIGNACIONES PRODUCTOS
			$Consulta=" select tipo from pcip_svp_asignaciones_productos where cod_producto='".$TxtCodigo."'";	
			$Resp=mysql_query($Consulta);
			if($Fila=mysql_fetch_array($Resp))
			{
				//echo $Fila[tipo]."<br>"; 
				if($Fila[tipo]=='SVP')
				{
					//echo "entrooo a svp";
					$Actualizar="UPDATE pcip_svp_asignaciones_productos set cod_asignacion='".$CmbAsig."',nom_asignacion='".strtoupper($TxtProd)."',orden='".$TxtOrden."', vigente='".$CmbVig."',cod_unidad='".$CmbUnidad."'";
					$Actualizar.=" where cod_producto='".$TxtCodigo."' and tipo='SVP'";	
					//echo $Actualizar;
					$Mensaje1="Producto modificado con Exito";
					mysql_query($Actualizar);
					header('location:pcip_mantenedor_asignaciones_productos_ppc_proceso.php?Opc=M&Valores='.$TxtCodigo.'&Mensaje1='.$Mensaje1);	
				}
				else
				{
					//echo "entrooo a ppc";
					$Actualizar="UPDATE pcip_svp_asignaciones_productos set cod_asignacion='".$CmbAsig."',nom_asignacion='".strtoupper($TxtProd)."',orden='".$TxtOrden."', vigente='".$CmbVig."',cod_unidad='".$CmbUnidad."'";
					$Actualizar.=" where cod_producto='".$TxtCodigo."' and tipo='PPC'";	
					//echo $Actualizar;
					$Mensaje1="Producto modificado con Exito";
					mysql_query($Actualizar);
					header('location:pcip_mantenedor_asignaciones_productos_ppc_proceso.php?Opc=M&Valores='.$TxtCodigo.'&Mensaje1='.$Mensaje1);	
				}
			}
            break;
			
		case "E"://ELIMINACION ASIGNACIONES PRODUCTOS	
			$Datos=explode('//',$Valor);
			while(list($c,$v)=each($Datos))
			{
				$Eliminar="delete from pcip_svp_asignaciones_productos where cod_producto='".$v."'";
				mysql_query($Eliminar);
				//echo $Eliminar;
			}
			header("location:pcip_mantenedor_asignaciones_productos_ppc_proceso.php?Mensaje=".$Mensaje."&BuscarAux=S&CmbVig=-1&CmbAsig=-1&CmbProd=-1");
			break;
	}
?>
