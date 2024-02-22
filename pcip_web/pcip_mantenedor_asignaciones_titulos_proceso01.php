<? 
	include("../principal/conectar_pcip_web.php");
	$Encontro=false;
	switch($Opcion)
	{
		case "N"://INGRESO ASIGNACIONES TITULOS
			$Inserta="insert into pcip_svp_asignaciones_titulos(cod_asignacion,cod_negocio,cod_titulo,nom_titulo,orden,vigente,grupo,mostrar_asig,mostrar_ppc)";
			$Inserta.=" values('".$CmbAsig."','".$CmbNeg."','".$TxtCodigo."','".strtoupper($TxtTit)."','".$TxtOrden."','".$CmbVig."','".$CmbGrupo."','".$CmbMostrarAsig."','".$CmbMostrarPpc."')";
			mysql_query($Inserta);
			//echo $Inserta;
			$Mensaje=1;
			header('location:pcip_mantenedor_asignaciones_titulos_proceso.php?Opc=M&Valores='.$TxtCodigo.'&Mensaje=1');			
		    break;
		    
		case "M"://MODIFICACION ASIGNACIONES TITULOS
			$Actualizar="UPDATE pcip_svp_asignaciones_titulos set cod_asignacion='".$CmbAsig."',cod_negocio='".$CmbNeg."',nom_titulo='".strtoupper($TxtTit)."',orden='".$TxtOrden."', vigente='".$CmbVig."', grupo='".$CmbGrupo."',mostrar_asig='".$CmbMostrarAsig."',mostrar_ppc='".$CmbMostrarPpc."'";
			$Actualizar.=" where cod_titulo='".$TxtCodigo."'";	
			//echo $Actualizar;
			mysql_query($Actualizar);
			$Mensaje=2;
			header('location:pcip_mantenedor_asignaciones_titulos_proceso.php?Opc=M&Valores='.$TxtCodigo.'&Mensaje=2');	
            break;
			
		case "E"://ELIMINACION ASIGNACIONES TITULOS	
		    $Datos=explode('//',$Valor);
			while(list($c,$v)=each($Datos))
			{	
				$Eliminar="delete from pcip_svp_asignaciones_titulos where cod_titulo='".$v."'";
				mysql_query($Eliminar);
				$Mensaje=1;
			}
			//echo $Eliminar;			
			header("location:pcip_mantenedor_asignaciones_titulos.php?Mensaje=1&Buscar=S&CmbAsig=".$CmbAsig.'&CmbNeg='.$CmbNeg.'&CmbTit='.$CmbTit.'&CmbVig='.$CmbVig.'&CmbGrupo='.$CmbGrupo);
			break;
	}
?>
