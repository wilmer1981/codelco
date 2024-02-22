<? 
	include("../principal/conectar_pcip_web.php");
	$Encontro=false;
	switch($Opcion)
	{
		case "N"://INGRESO ASIGNACIONES PRODUCTOS
			$Inserta="insert into pcip_svp_asignaciones_productos (cod_asignacion,cod_producto,nom_asignacion,orden,tipo,vigente,mostrar_ppc,mostrar_cu_elect,cod_unidad)";
			$Inserta.=" values('".$CmbAsig."','".$TxtCodigo."','".strtoupper($TxtProd)."','".$TxtOrden."','SVP','".$CmbVig."','".$CmbMPpc."','".$CmbMCuElect."','".$CmbUnidad."')";
			mysql_query($Inserta);
			//echo $Inserta;
			$Mensaje=1;
			header('location:pcip_mantenedor_asignaciones_productos_proceso.php?Opc=M&Valores='.$TxtCodigo.'&Mensaje=1');			
		    break;
		    
		case "M"://MODIFICACION ASIGNACIONES PRODUCTOS
			$Actualizar="UPDATE pcip_svp_asignaciones_productos set cod_asignacion='".$CmbAsig."',nom_asignacion='".strtoupper($TxtProd)."',orden='".$TxtOrden."',tipo='SVP', vigente='".$CmbVig."',mostrar_ppc='".$CmbMPpc."',mostrar_cu_elect='".$CmbMCuElect."',cod_unidad='".$CmbUnidad."'";
			$Actualizar.=" where cod_producto='".$TxtCodigo."'";	
			//echo $Actualizar;
			mysql_query($Actualizar);
			$Mensaje=2;
			header('location:pcip_mantenedor_asignaciones_productos_proceso.php?Opc=M&Valores='.$TxtCodigo.'&Mensaje=2');	
            break;
			
		case "E"://ELIMINACION ASIGNACIONES PRODUCTOS	
			$Datos=explode('//',$Valor);
			while(list($c,$v)=each($Datos))
			{
				$Eliminar="delete from pcip_svp_asignaciones_productos where cod_producto='".$v."'";
				mysql_query($Eliminar);
				//echo $Eliminar;
			}
			header("location:pcip_mantenedor_asignaciones_productos.php?Mensaje=".$Mensaje."&BuscarAux=S&CmbVig=-1&CmbAsig=-1&CmbProd=-1");
			break;
	}
?>
