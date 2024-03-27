<? 
	include("../principal/conectar_pcip_web.php");
	$Encontro=false;
	switch($Opcion)
	{
		case "N":
		    $Mensaje=false;	
			$Consulta= " select cod_unidad from pcip_unidades where cod_unidad='".$TxtCodigo."'";
			//echo $Consulta."<br>";
			$Resp = mysqli_query($link, $Consulta);
			if(!$Fila=mysql_fetch_array($Resp))
			{				
				$Inserta="insert into pcip_unidades (cod_unidad,nom_unidad,vigente)";
				$Inserta.=" values('".strtoupper($TxtCodigo)."','".strtoupper($TxtUnidad)."','".$CmbVig."')";
				mysql_query($Inserta);
			   //echo $Inserta."<br>";
			}
			else
			{
			$Mensaje=true;			
			}				
			header('location:pcip_mantenedor_unidades_proceso.php?Opc=M&Valores='.$TxtCodigo.'&Mensaje='.$Mensaje);			
		    break;
		    
		case "M":
			$Actualizar="UPDATE pcip_unidades set nom_unidad = '".strtoupper($TxtUnidad)."',vigente='".$CmbVig."' ";
			$Actualizar.=" where cod_unidad='".$TxtCodigo."'";	
			//echo $Actualizar;
			mysql_query($Actualizar);
			header('location:pcip_mantenedor_unidades_proceso.php?Opc=M&Valores='.$TxtCodigo);	
            break;
			
		case "E":
			$Mensaje1='N';
			$Datos = explode("//",$Valor);
			while (list($clave,$TxtCodigo)=each($Datos))
			{							
					$Eliminar="delete from pcip_unidades where cod_unidad='".$TxtCodigo."'";
					mysql_query($Eliminar);
					//echo $Eliminar;
					$Mensaje1='S';
		    }
			header("location:pcip_mantenedor_unidades.php?Mensaje1=".$Mensaje1."&Buscar=S");
		break;
	}
?>
