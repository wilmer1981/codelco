<? 
	include("../principal/conectar_pcip_web.php");
    switch ($Opc)
	{
		 case "G": 
			$Inserta="insert into pcip_ere_productos_por_grupo (cod_grupo,cod_producto)";
			$Inserta.=" values('".$CmbGrupo."','".$CmbProducto."')";
			mysql_query($Inserta);
			$Mensaje=1;
			//echo $Inserta;
			header('location:pcip_mantenedor_asigna_productos_er_por_grupo.php?CmbGrupo='.$CmbGrupo.'&Mensaje=1');			
		    break;
			
		case "E":
			$Eliminar="delete from pcip_ere_productos_por_grupo where cod_producto='".$Cod."'";
			mysql_query($Eliminar);
			//echo $Eliminar;
			$MensajeEliminar=1;
			header('location:pcip_mantenedor_asigna_productos_er_por_grupo.php?CmbGrupo='.$CmbGrupo.'&MensajeEliminar=1');
		    break;
			
	}
?>
