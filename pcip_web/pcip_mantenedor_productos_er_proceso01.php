<? 
	include("../principal/conectar_pcip_web.php");
	$Encontro=false;
	switch($Opcion)
	{
		case "N":
			$Consulta="select cuenta_ingreso from pcip_ere_productos where cuenta_ingreso='".$TxtIngreso."'";
			$Resp=mysqli_query($link, $Consulta);
			if(!$Fila=mysql_fetch_array($Resp))
			{
				$Mensaje=false;
				$Inserta="insert into pcip_ere_productos (cod_producto,nom_producto,cuenta_ingreso,cuenta_costos,vigente)";
				$Inserta.=" values('".$TxtCodigoPro."','".strtoupper($TxtProducto)."','".$TxtIngreso."','".$TxtCostos."','".$CmbVig."')";
				mysql_query($Inserta);
				//echo $Inserta;
				$Mensaje=true;
			}	
			else
			{
				$Consulta="select * from pcip_ere_productos where cuenta_ingreso='".$TxtIngreso."'";
				$Resp=mysqli_query($link, $Consulta);
				//echo $Consulta."<br>";
				if($Fila=mysql_fetch_array($Resp))
				{
					$TxtCodigoPro=$Fila["cod_producto"];
				}			 
			    $MensajeExiste=1;
			}
			header('location:pcip_mantenedor_productos_er_proceso.php?Opc=M&Valores='.$TxtCodigoPro.'&Mensaje='.$Mensaje.'&MensajeExiste=1');			
		    break;
		    
		case "M":
		    $Mensaje1=false;
			$Actualizar="UPDATE pcip_ere_productos set  nom_producto= '".strtoupper($TxtProducto)."', cuenta_ingreso='".$TxtIngreso."', cuenta_costos='".$TxtCostos."', vigente='".$CmbVig."'";
			$Actualizar.=" where cod_producto='".$TxtCodigoPro."'";	
			//echo $Actualizar;
			$Mensaje1=true;
			mysql_query($Actualizar);
			header('location:pcip_mantenedor_productos_er_proceso.php?Opc=M&Valores='.$TxtCodigoPro.'&Mensaje1='.$Mensaje1);	
            break;
			
		case "E":
		    $Mensaje2='N';
		    $Datos=explode('//',$Valor);
			while(list($c,$v)=each($Datos))
			{
				$Eliminar="delete from pcip_ere_productos where cod_producto='".$v."'";
				mysql_query($Eliminar);
				//echo $Eliminar;
            }
            $Mensaje2='S'; 			
			header("location:pcip_mantenedor_productos_er.php?Buscar=S&CmbProducto=-1&Mensaje2=".$Mensaje2);
		    break;
	}
?>
