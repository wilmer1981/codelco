<? 
	include("../principal/conectar_pcip_web.php");
	$Encontro=false;
	switch($Opcion)
	{
		case "N":
		    $Mensaje=false;	
			$Consulta= " select rut_proveedor from pcip_fac_proveedores  where rut_proveedor='".$TxtRut."'";
			$Resp = mysql_query($Consulta);
			if(!$Fila=mysql_fetch_array($Resp))
			{	
			    $Mensaje1=false;			
				$Inserta="insert into pcip_fac_proveedores (rut_proveedor,nom_proveedor,vigente)";
				$Inserta.=" values('".$TxtRut."','".strtoupper($TxtProveedor)."','".$CmbVig."')";
				mysql_query($Inserta);
				$Mensaje1=true;
			}
			else
			{
			$Mensaje=true;			
			}				
			//echo $Inserta;
			header('location:pcip_mantenedor_proveedores_facturas_proceso.php?Opc=M&Valores='.$TxtRut.'&Mensaje='.$Mensaje);			
		    break;
		    
		case "M":
			$Mensaje2=false;
			$Actualizar="UPDATE pcip_fac_proveedores set nom_proveedor = '".strtoupper($TxtProveedor)."', vigente='".$CmbVig."'";
			$Actualizar.=" where rut_proveedor='".$TxtRut."'";	
			//echo $Actualizar;
			mysql_query($Actualizar);
			$Mensaje2=true;			
			header('location:pcip_mantenedor_proveedores_facturas_proceso.php?Opc=M&Valores='.$TxtRut.'&Mensaje2='.$Mensaje2);	
            break;
			
		case "E":
			$Mensaje='N';
			$Datos = explode("//",$Valor);
			while (list($clave,$TxtRut)=each($Datos))
			{								
				$Consulta="select * from pcip_fac_productos_por_proveedores where rut_proveedor='".$TxtRut."'";
				$Respuesta=mysql_query($Consulta);
				//echo $Consulta;
				if(!$Fila=mysql_fetch_array($Respuesta))
				{
					$Mensaje1='N';		
					$Eliminar="delete from pcip_fac_proveedores where rut_proveedor='".$TxtRut."'";
					mysql_query($Eliminar);
					//echo $Eliminar;
				    $Mensaje1='S';
				}
				else
				{
					$Mensaje="S";
					break;	
				}	
		    }		    
			header('location:pcip_mantenedor_proveedores_facturas.php?Buscar=S&CmbProveedor=T&Mensaje='.$Mensaje.'&Mensaje1='.$Mensaje1);
		    break;

		case "NI":				
				header('location:pcip_mantenedor_proveedores_facturas_proceso.php?Opc=N');	
				break;		
			
	}
?>
