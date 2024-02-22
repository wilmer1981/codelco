<? 
	include("../principal/conectar_pcip_web.php");
    switch ($Opc)
	{
		 case "G": 
			$Inserta="insert into pcip_fac_productos_por_proveedores (rut_proveedor,cod_producto)";
			$Inserta.=" values('".$CmbProveedor."','".strtoupper($CmbProducto)."')";
			mysql_query($Inserta);
			//echo $Inserta;
			header('location:pcip_mantenedor_asigna_productos_proveedor.php?CmbProveedor='.$CmbProveedor);			
		    break;
			
		case "E":
			$Eliminar="delete from pcip_fac_productos_por_proveedores where cod_producto='".$Cod."' and rut_proveedor='".$CmbProveedor."'";
			mysql_query($Eliminar);
			//echo $Eliminar;
			header("location:pcip_mantenedor_asigna_productos_proveedor.php?CmbProveedor=".$CmbProveedor);
		    break;
			
	}
?>
