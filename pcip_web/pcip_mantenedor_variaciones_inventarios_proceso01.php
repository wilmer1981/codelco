<? 
	include("../principal/conectar_pcip_web.php");
	$Encontro=false;
	switch($Opcion)
	{
		case "N"://INGRESO VARIACIONES INVENTARIO
			if($CmbOrdenRel=='-1')
			    $CmbOrdenRel=0;
			if($TxtMaterial=='')
			    $TxtMaterial='0';
			if($TxtConsumo=='')
		 	    $TxtConsumo='0';
			if($TxtVPtm=='')
			    $TxtVPtm='0';
			if($TxtVPti=='')
				$TxtVPti='0';
				
			$Consulta="select * from pcip_svp_variacion_inventario";
			$Consulta.=" where cod_asignacion='".$CmbAsig."' and cod_area='".$CmbArea."' and cod_maquila='".$CmbMaqui."'";
			$Consulta.=" and cod_producto='".$CmbProd."' and num_orden='".$CmbOrden."'";
			$Consulta.=" and num_orden_relacionada='".$CmbOrdenRel."' and cod_material='".$TxtMaterial."' and consumo_interno='".$TxtConsumo."' and vptm='".$TxtVPtm."' and vptipinv='".$TxtVPti."'";
			$Resp=mysqli_query($link, $Consulta);
			if($Fila=mysql_fetch_array($Resp))
			{
				$Actualizar="UPDATE pcip_svp_variacion_inventario set num_orden_relacionada='".$CmbOrdenRel."', cod_material='".$TxtMaterial."',consumo_interno='".$TxtConsumo."', vptm='".$TxtVPtm."', vptipinv='".$TxtVPti."'";
				$Actualizar.=" where cod_asignacion='".$CmbAsig."' and cod_area='".$CmbArea."' and cod_maquila='".$CmbMaqui."' and cod_producto='".$CmbProd."' and num_orden='".$CmbOrden."'";
				//echo $Actualizar."<br>";
				mysql_query($Actualizar);					
			}
			else
			{
				$Inserta="insert into pcip_svp_variacion_inventario (cod_asignacion,cod_area,cod_maquila,cod_producto,num_orden,num_orden_relacionada,cod_material,consumo_interno,vptm,vptipinv)";
				$Inserta.=" values('".$CmbAsig."','".$CmbArea."','".$CmbMaqui."','".$CmbProd."','".$CmbOrden."','".$CmbOrdenRel."','".$TxtMaterial."','".$TxtConsumo."','".$TxtVPtm."','".$TxtVPti."')";
				//echo $Inserta;
				mysql_query($Inserta);
			}
			$Cod=$CmbAsig."~".$CmbArea."~".$CmbMaqui."~".$CmbProd."~".$CmbOrden;
			header('location:pcip_mantenedor_variaciones_inventarios_proceso.php?Opc=M&Cod='.$Cod);			
		    break;
		    
		case "M"://MODIFICACION VARIACIONES INVENTARIO
		
			$Valores=explode('~',$Cod);	
			if($CmbOrdenRel=='-1')
			    $CmbOrdenRel=0;
			if($TxtMaterial=='')
			    $TxtMaterial='0';
			if($TxtConsumo=='')
		 	    $TxtConsumo='0';
			if($TxtVPtm=='')
			    $TxtVPtm='0';
			if($TxtVPti=='')
				$TxtVPti='0';
					
			$Actualizar="UPDATE pcip_svp_variacion_inventario set num_orden_relacionada='".$CmbOrdenRel."', cod_material='".$TxtMaterial."', consumo_interno='".$TxtConsumo."', vptm='".$TxtVPtm."', vptipinv='".$TxtVPti."'";
			$Actualizar.=" where cod_asignacion='".$Valores[0]."' and cod_area='".$Valores[1]."' and cod_maquila='".$Valores[2]."' and cod_producto='".$Valores[3]."'  and num_orden='".$Valores[4]."'";
			//echo $Actualizar;
			mysql_query($Actualizar);
			header('location:pcip_mantenedor_variaciones_inventarios_proceso.php?Opc=M&Cod='.$Cod);	
            break;
			
		case "E"://ELIMINACION VARIACIONES INVENTARIOS
		   
		   $Datos = explode("//",$Cod);	
			$Cont=0;
			
			while (list($clave,$Codigo)=each($Datos))
			{
				$Cont=$Cont+1;
				if($Codigo!='')
				{
				 	$Valores=explode('~',$Codigo);	
					$Eliminar="delete from pcip_svp_variacion_inventario where cod_asignacion='".$Valores[0]."' and cod_area='".$Valores[1]."' and cod_maquila='".$Valores[2]."' and cod_producto='".$Valores[3]."'  and num_orden='".$Valores[4]."'";
					mysql_query($Eliminar);
				}		
		   }
		   
			header("location:pcip_mantenedor_variaciones_inventarios.php?Mensaje=".$Mensaje."&BuscarAux=S");
			break;

		case "NI":				
				header('location:pcip_mantenedor_variaciones_inventarios_proceso.php?Opc=N');	
				break;		
			
	}
?>
