<? 
	include("../principal/conectar_pcip_web.php");
    switch ($Opc)
	{
			
		case "G": //GRABAR RELACION
			$Inserta="insert into pcip_eec_sistemas_por_indicadores (cod_indicador,cod_sistema,cod_divisor)";
			$Inserta.=" values('".$CmbIndica."','".strtoupper($CmbSistema)."','".$CmbDivisor."')";
			mysql_query($Inserta);
			//echo $Inserta;
			header("location:pcip_mantenedor_asigna_sistemas_por_indicadores.php?CmbSistema=".$CmbSistema);			
		    break;
			
		case "E":// ELIMINAR RELACION
			$Eliminar="delete from pcip_eec_sistemas_por_indicadores where cod_indicador='".$Cod."' and cod_sistema='".$CmbSistema."'";
			mysql_query($Eliminar);
			//echo $Eliminar;
			header("location:pcip_mantenedor_asigna_sistemas_por_indicadores.php?CmbSistema=".$CmbSistema);
		    break;
	    
		case "GI"://GRABAR INDICADOR
		    $Inserta="insert into pcip_eec_indicadores (cod_indicador,nom_indicador,vigente)";
			$Inserta.=" values('".$TxtCodigo."','".strtoupper($TxtNuevo)."','".$CmbVig."')";
			mysql_query($Inserta);
			//echo $Inserta;
			header("location:pcip_mantenedor_asigna_sistemas_por_indicadores_nuevo_proceso.php");			
		    break;
			
	    case "MI"://MODIFICAR INDICADOR
			$Actualizar="UPDATE pcip_eec_indicadores set nom_indicador = '".strtoupper($TxtNuevo)."',vigente='".$CmbVig."'";
			$Actualizar.=" where cod_indicador='".$TxtCodigo."'" ;	
			//echo $Actualizar;
			mysql_query($Actualizar);
			header('location:pcip_mantenedor_asigna_sistemas_por_indicadores_nuevo_proceso.php');	
            break;

		case "EI":
			$Eliminar="delete from pcip_eec_indicadores where cod_indicador='".$Cod."'";
			mysql_query($Eliminar);
			//echo $Eliminar;
			header("location:pcip_mantenedor_asigna_sistemas_por_indicadores_nuevo_proceso.php");
		    break;			
	}
?>
