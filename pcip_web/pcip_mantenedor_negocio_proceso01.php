<? 
	include("../principal/conectar_pcip_web.php");
	$Encontro=false;
	switch($Opcion)
	{
		case "N"://INGRESO DE ASIGNACION 
		    $Consulta=" consulta nom_asignacion from pcip_svp_negocios where nom_negocio='".strtoupper($TxtAsignacion)."'";
			$Resp = mysql_query($Consulta);
			if(!$Fila=mysql_fetch_array($Resp))
			{	
				$Inserta="insert into pcip_svp_negocios (cod_negocio,nom_negocio,orden,vigente,mostrar_asig,mostrar_ppc)";
				$Inserta.=" values('".$TxtCodigo."','".strtoupper($TxtNegocio)."','".$TxtOrden."','".$CmbVig."','".$CmbMAsig."','".$CmbMPpc."')";
				mysql_query($Inserta);
				//echo $Inserta;
				$Mensaje='1';
			}
			else
			   	$Mensaje='2';
			header('location:pcip_mantenedor_negocio_proceso.php?Opc=M&Valores='.$TxtCodigo.'&Mensaje=1&Mensaje=2');			
		    break;
		    
		case "M"://MODIFICACION DE ASIGNACION
			$Actualizar="UPDATE pcip_svp_negocios set nom_negocio='".strtoupper($TxtNegocio)."',orden='".$TxtOrden."',vigente='".$CmbVig."',mostrar_asig='".$CmbMAsig."',mostrar_ppc='".$CmbMPpc."'";
			$Actualizar.=" where cod_negocio='".$TxtCodigo."'";	
			//echo $Actualizar;
			mysql_query($Actualizar);
			$Mensaje='3';
			header('location:pcip_mantenedor_negocio_proceso.php?Opc=M&Valores='.$TxtCodigo.'&Mensaje=3');	
            break;
			
		case "E"://ELIMINACION DE LA ASIGNACION
			$Datos = explode("//",$Valor);
			while (list($clave,$TxtCodigo)=each($Datos))
			{
					$Eliminar="delete from pcip_svp_negocios where cod_negocio='".$TxtCodigo."'";
					mysql_query($Eliminar);
					//echo $Eliminar;
		    }
		header("location:pcip_mantenedor_negocio.php?Mensaje=".$Mensaje."&BuscarAux=S&CmbVig=-1&CmbAsign=-1");
		break;
	}
?>
