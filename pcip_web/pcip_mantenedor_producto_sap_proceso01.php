<? 
	include("../principal/conectar_pcip_web.php");
	$Encontro=false;
	switch($Opcion)
	{
		case "N":
			$Inserta="insert into pcip_svp_productos_sap (cod_sap,nom_sap,vigente)";
			$Inserta.=" values('".strtoupper($TxtCodigo)."','".strtoupper($TxtProducto)."','".$CmbVig."')";
			mysql_query($Inserta);
			//echo $Inserta;
			header('location:pcip_mantenedor_producto_sap_proceso.php?Opc=M&Valores='.$TxtCodigo);			
		    break;
		    
		case "M":
			$Actualizar="UPDATE pcip_svp_productos_sap set nom_sap = '".strtoupper($TxtProducto)."',vigente='".$CmbVig."' ";
			$Actualizar.=" where cod_sap='".$TxtCodigo."'";	
			//echo $Actualizar;
			mysql_query($Actualizar);
			header('location:pcip_mantenedor_producto_sap_proceso.php?Opc=M&Valores='.$TxtCodigo);	
            break;
			
		case "E":			
			$Datos = explode("//",$Valor);
			while (list($clave,$TxtCodigo)=each($Datos))
			{
				$Consulta="select * from pcip_svp_relmateriales where RMmaterialequivalente='".$TxtCodigo."'";
				$Respuesta=mysqli_query($link, $Consulta);
				//echo $Consulta;
				if(!$Fila=mysql_fetch_array($Respuesta))
				{
					$Eliminar="delete from pcip_svp_productos_sap where cod_sap='".$TxtCodigo."'";
					mysql_query($Eliminar);
					//echo $Eliminar;
				}
				else
				{
					$Mensaje="S";
					break;	
				}	
		    }
			header("location:pcip_mantenedor_producto_sap.php?Buscar=S&Mensaje=".$Mensaje."&CmbProd=".$CmbProd);
		break;
	}
?>
