<? 
	include("../principal/conectar_pcip_web.php");
    switch ($Opc)
	{
		 case "G": 
			$Inserta="insert into pcip_eec_centros_costos_por_sistema (cod_sistema,cod_cc)";
			$Inserta.=" values('".$CmbSistema."','".strtoupper($CmbCostos)."')";
			mysql_query($Inserta);
			//echo $Inserta;
			header('location:pcip_mantenedor_asigna_costos_por_sistema.php?CmbSistema='.$CmbSistema);			
		    break;
			
		case "E":
			$Eliminar="delete from pcip_eec_centros_costos_por_sistema where cod_cc='".$Cod."' and cod_sistema='".$CmbSistema."'";
			mysql_query($Eliminar);
			//echo $Eliminar;
			header("location:pcip_mantenedor_asigna_costos_por_sistema.php?CmbSistema=".$CmbSistema);
		    break;
			
	}
?>
