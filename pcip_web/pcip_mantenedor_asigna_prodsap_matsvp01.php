<? 
	include("../principal/conectar_pcip_web.php");
    switch ($Opc)
	{
		 case "G": 
			$Inserta="insert into pcip_svp_relmateriales (RMmaterial,RMmaterialequivalente,tipo_movimiento_svp)";
			$Inserta.=" values('".$CmbMaterial."','".$CmbProd."','".$CmbTipoMov."')";
			mysql_query($Inserta);
			//echo $Inserta;
			header('location:pcip_mantenedor_asigna_prodsap_matsvp.php?CmbProd='.$CmbProd);			
		    break;
			
		case "E":
			$Eliminar="delete from pcip_svp_relmateriales where RMmaterial='".$Cod."' and RMmaterialequivalente='".$CmbProd."'";
			mysql_query($Eliminar);
			//echo $Eliminar;
			header("location:pcip_mantenedor_asigna_prodsap_matsvp.php?CmbProd=".$CmbProd);
		    break;
			
	}
?>
