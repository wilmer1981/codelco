<? 
	include("../principal/conectar_pcip_web.php");
	$Encontro=false;
	switch($Opcion)
	{
		case "N":
			
			$Inserta="insert into pcip_svp_productos_etapas (cod_producto_etapa,nom_producto_etapa,cod_tipo_balance,vigente)";
			$Inserta.=" values('".$TxtCodigo."','".strtoupper($TxtProducto)."','".$CmbTipo."','".$CmbVig."')";
			mysql_query($Inserta);
			//echo $Inserta;
			header('location:pcip_mantenedor_producto_balance_proceso.php?Opc=M&Valores='.$TxtCodigo);			
		    break;
		    
		case "M":
			$Actualizar="UPDATE pcip_svp_productos_etapas set nom_producto_etapa='".strtoupper($TxtProducto)."',cod_tipo_balance='".$CmbTipo."',vigente='".$CmbVig."' ";
			$Actualizar.=" where cod_producto_etapa='".$TxtCodigo."'";	
			//echo $Actualizar;
			mysql_query($Actualizar);
			header('location:pcip_mantenedor_producto_balance_proceso.php?Opc=M&Valores='.$TxtCodigo);	
            break;
			
		case "E":
			$Datos=explode('//',$Valor);
			while(list($c,$v)=each($Datos))
			{
				$Eliminar="delete from pcip_svp_productos_etapas where cod_producto_etapa='".$v."'";
				mysql_query($Eliminar);
				//echo $Eliminar;
			}
			header("location:pcip_mantenedor_producto_balance.php?&Buscar=S");
		    break;
	}
?>
