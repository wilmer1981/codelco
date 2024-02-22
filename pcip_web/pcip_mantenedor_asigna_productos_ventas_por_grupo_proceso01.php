<? 
	include("../principal/conectar_pcip_web.php");
    switch ($Opc)
	{
		 case "G": 
			$Inserta="insert into pcip_cdv_productos_ventas_por_grupo (cod_grupo,cod_producto)";
			$Inserta.=" values('".$CmbGrupo."','".$CmbProducto."')";
			mysql_query($Inserta);
			//echo $Inserta;
			header('location:pcip_mantenedor_asigna_productos_ventas_por_grupo.php?CmbGrupo='.$CmbGrupo);			
		    break;
			
		case "E":
			$Eliminar="delete from pcip_cdv_productos_ventas_por_grupo where cod_producto='".$Cod."'";
			mysql_query($Eliminar);
			//echo $Eliminar;
			header("location:pcip_mantenedor_asigna_productos_ventas_por_grupo.php?CmbGrupo=".$CmbGrupo);
		    break;
			
	}
?>
