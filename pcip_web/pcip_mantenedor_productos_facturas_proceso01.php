<? 
	include("../principal/conectar_pcip_web.php");
	$Encontro=false;
	switch($Opcion)
	{
		case "N":
		    $Mensaje1=false;$Mensaje3=false;
			$Consulta="select * from pcip_fac_productos_facturas where nom_producto='".strtoupper($TxtProducto)."'";
			$Resp=mysql_query($Consulta);
			if(!$Fila=mysql_fetch_array($Resp))
			{
				$Inserta="insert into pcip_fac_productos_facturas (cod_producto,nom_producto,vigente)";
				$Inserta.=" values('".$TxtCodigo."','".strtoupper($TxtProducto)."','".$CmbVig."')";
				mysql_query($Inserta);
				//echo $Inserta;
				$Mensaje1=true;
				header('location:pcip_mantenedor_productos_facturas_proceso.php?Opc=M&Valores='.$TxtCodigo.'&Mensaje1='.$Mensaje1.'&Mensaje3='.$Mensaje3);			
			}
			else
			{
				$Mensaje3=true;
				header('location:pcip_mantenedor_productos_facturas_proceso.php?Opc=M&Valores='.$Fila["cod_producto"].'&Mensaje3='.$Mensaje3);
			}
		    break;
		case "M":
		    $Mensaje2=false;
			$Actualizar="UPDATE pcip_fac_productos_facturas set nom_producto = '".strtoupper($TxtProducto)."', vigente='".$CmbVig."'";
			$Actualizar.=" where cod_producto='".$TxtCodigo."'";	
			//echo $Actualizar;
			mysql_query($Actualizar);
		    $Mensaje2=true;
			header('location:pcip_mantenedor_productos_facturas_proceso.php?Opc=M&Valores='.$TxtCodigo.'&Mensaje2='.$Mensaje2);	
            break;
		case "E":
			$Datos = explode("//",$Valor);
			while (list($c,$v)=each($Datos))
            {
				$Eliminar="delete from pcip_fac_productos_facturas where cod_producto='".$v."'";
				mysql_query($Eliminar);				
				//echo $Eliminar;
			}	
			header("location:pcip_mantenedor_productos_facturas.php?&Buscar=S&CmbProducto=-1");
		    break;
	}
?>
