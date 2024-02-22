<? 
	include("../principal/conectar_pcip_web.php");
    switch ($Opc)
	{
		 case "G": 
			$Inserta="insert into pcip_cdv_productos_ventas_por_ordenes (cod_orden,cod_producto)";
			$Inserta.=" values('".$CmbOrden."','".$CmbProducto."')";
			mysql_query($Inserta);
			//echo $Inserta;
			header('location:pcip_mantenedor_asigna_productos_ventas_por_ordenes.php?CmbProducto='.$CmbProducto);			
		    break;
			
		case "E":
			$Eliminar="delete from pcip_cdv_productos_ventas_por_ordenes where cod_producto='".$Cod."'";
			mysql_query($Eliminar);
			echo $Eliminar;
			header("location:pcip_mantenedor_asigna_productos_ventas_por_ordenes.php");
		    break;
			
	}
?>
