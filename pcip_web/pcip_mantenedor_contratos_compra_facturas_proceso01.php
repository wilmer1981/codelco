<? 
	include("../principal/conectar_pcip_web.php");
	$Encontro=false;
	switch($Opcion)
	{
		case "N":		
		    if($TxtDescripcion=='')
			  $TxtDescripcion='';
			if($TxtFechaContrato=='')
			   $TxtFechaContrato='0000-00-00';  
			if($TxtDuracion=='')
			   $TxtDuracion='0000-00-00';	
			if($CmbAcuerdoCu=='N')
				$CmbAcuerdoCu='';  
			if($CmbAcuerdoAg=='N')
				$CmbAcuerdoAg='';  
			if($CmbAcuerdoAu=='N')
				$CmbAcuerdoAu='';  
			if($CmbOtro=='N')
				$CmbOtro='';  
		    $Mensaje=false;	
			$Consulta= " select cod_contrato from pcip_fac_contratos_compra where cod_contrato='".$TxtContrato."'";
			$Resp = mysqli_query($link, $Consulta);
			if(!$Fila=mysql_fetch_array($Resp))
			{	
			    $Mensaje1=false;							    		
				$Inserta="insert into pcip_fac_contratos_compra (cod_contrato,rut_proveedor,cod_producto,fecha_contrato,duracion,acuerdo_contractual_cu,acuerdo_contractual_ag,acuerdo_contractual_au,vigente,tipo_contrato,cod_mercado,nom_cliente,acuerdo_contractual_otro)";
				$Inserta.=" values('".strtoupper($TxtContrato)."','".$CmbRutProveedor."','".$CmbProducto."','".$TxtFechaContrato."','".$TxtDuracion."','".$CmbAcuerdoCu."','".$CmbAcuerdoAg."','".$CmbAcuerdoAu."','".$CmbVig."','".$CmbTipoContrato."','".$CmbMercado."','".$TxtDescripcion."','".$CmbOtro."')";
				mysql_query($Inserta);				
				$Mensaje1=true;	
			}	
			else
			{
			$Mensaje=true;	
			}
			//echo $Inserta;
			header('location:pcip_mantenedor_contratos_compra_facturas_proceso.php?Opc=M&Valores='.$TxtContrato.'&Mensaje='.$Mensaje.'&Mensaje1='.$Mensaje1);			
		    break;
		    
		case "M":
		    if($TxtDescripcion=='')
			  $TxtDescripcion='';
			if($TxtFechaContrato=='')
			   $TxtFechaContrato='0000-00-00';  
			if($TxtDuracion=='')
			   $TxtDuracion='0000-00-00';	
			if($CmbAcuerdoCu=='N')
				$CmbAcuerdoCu='';  
			if($CmbAcuerdoAg=='N')
				$CmbAcuerdoAg='';  
			if($CmbAcuerdoAu=='N')
				$CmbAcuerdoAu='';  
			if($CmbOtro=='N')
				$CmbOtro='';  		
		    $Mensaje2=false;	
			$Actualizar="UPDATE pcip_fac_contratos_compra set rut_proveedor='".$CmbRutProveedor."', cod_producto='".$CmbProducto."', fecha_contrato='".$TxtFechaContrato."', duracion='".$TxtDuracion."', acuerdo_contractual_cu='".$CmbAcuerdoCu."', acuerdo_contractual_ag='".$CmbAcuerdoAg."', acuerdo_contractual_au='".$CmbAcuerdoAu."' , vigente='".$CmbVig."', tipo_contrato='".$CmbTipoContrato."', cod_mercado='".$CmbMercado."', nom_cliente='".$TxtDescripcion."', acuerdo_contractual_otro='".$CmbOtro."'";
			$Actualizar.=" where cod_contrato='".trim($TxtContrato)."'";	
			//echo $Actualizar;
			mysql_query($Actualizar);
			$Mensaje2=true;	
			header('location:pcip_mantenedor_contratos_compra_facturas_proceso.php?Opc=M&Valores='.$TxtContrato.'&Mensaje2='.$Mensaje2);	
            break;
			
		case "E":
			$Mensaje='1';
			$Datos = explode("//",$Valor);
			while (list($clave,$Codigo)=each($Datos))
			{	
			    $Cadena=explode("~",$Codigo);			
				$Eliminar="delete from pcip_fac_contratos_compra where cod_contrato='".$Cadena[0]."'";
				mysql_query($Eliminar);
				//echo $Eliminar;
			}	
			header("location:pcip_mantenedor_contratos_compra_facturas.php?&Buscar=S&CmbContrato=-1");
		    break;

		case "NI":				
				header('location:pcip_mantenedor_contratos_compra_facturas_proceso.php?Opc=N');	
				break;		
			
	}
?>
