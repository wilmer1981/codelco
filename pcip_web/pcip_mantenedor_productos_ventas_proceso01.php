<? 
	include("../principal/conectar_pcip_web.php");
	$Encontro=false;
	switch($Opcion)
	{
		case "N":
			$Consulta= " select cod_producto from pcip_cdv_productos_ventas  where cod_producto='".$TxtCodigo."'";
			//echo $Consulta;
			$Resp = mysqli_query($link, $Consulta);
			if(!$Fila=mysql_fetch_array($Resp))
			{		
				$Mensaje2=false;
				$Inserta="insert into pcip_cdv_productos_ventas (cod_producto,nom_producto,vigente)";
				$Inserta.=" values('".$TxtCodigo."','".strtoupper($TxtProducto)."','".$CmbVig."')";
				mysql_query($Inserta);
				$Mensaje2=true;
				//echo $Inserta;			
            }
			else
			{
			$MensajeExiste=true;
			}
			header('location:pcip_mantenedor_productos_ventas_proceso.php?Opc=M&Valores='.$TxtCodigo.'&Mensaje2='.$Mensaje2.'&MensajeExiste='.$MensajeExiste);			
		    break;
		    
		case "M":
		    $Mensaje1=false;
			$Actualizar="UPDATE pcip_cdv_productos_ventas set nom_producto = '".strtoupper($TxtProducto)."', vigente='".$CmbVig."'";
			$Actualizar.=" where cod_producto='".$TxtCodigo."'";
			//echo $Actualizar;
			mysql_query($Actualizar);
			$Mensaje1=true;				
			header('location:pcip_mantenedor_productos_ventas_proceso.php?Opc=M&Valores='.$TxtCodigo.'&Mensaje1='.$Mensaje1);	
            break;
			
		case "E":
		    $Mensaje1='N';
		    $Datos=explode('//',$Valor);
			while(list($c,$v)=each($Datos))
			{
				$Eliminar="delete from pcip_cdv_productos_ventas where cod_producto='".$v."'";
				mysql_query($Eliminar);
				//echo $Eliminar;
				$Mensaje1='S';
            } 
			header("location:pcip_mantenedor_productos_ventas.php?&Buscar=S.'&Mensaje1=".$Mensaje1);
		    break;

		case "NI":				
				header('location:pcip_mantenedor_productos_ventas_proceso.php?Opc=N');	
				break;		
			
	}
?>
