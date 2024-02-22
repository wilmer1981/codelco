<? 
	include("../principal/conectar_pcip_web.php");
    switch ($Opc)
	{
		 case "G": 
			$Inserta="insert into pcip_eec_equipos_por_sistema (cod_sistema,cod_equipo)";
			$Inserta.=" values('".$CmbSistema."','".strtoupper($CmbEquipo)."')";
			mysql_query($Inserta);
			//echo $Inserta;
			header('location:pcip_mantenedor_asigna_equipos.php?CmbSistema='.$CmbSistema);			
		    break;
			
		case "E":
			$Eliminar="delete from pcip_eec_equipos_por_sistema where cod_equipo='".$Cod."' and cod_sistema='".$CmbSistema."'";
			mysql_query($Eliminar);
			//echo $Eliminar;
			header("location:pcip_mantenedor_asigna_equipos.php?CmbSistema=".$CmbSistema);
		    break;
			
	}
?>
