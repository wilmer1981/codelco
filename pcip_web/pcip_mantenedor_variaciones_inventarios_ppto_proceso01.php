<? 
	include("../principal/conectar_pcip_web.php");
	$Encontro=false;
	//echo $Opcion;
	
	switch($Opcion)
	{
		case "N"://INGRESO/MODIFICACION VARIACIONES INVENTARIO PPTO
            
			$Datos = explode("~",$Valores);	
			$Cont=0;
			
			while (list($clave,$Codigo)=each($Datos))
			{
				$Cont=$Cont+1;
				if($Codigo!='')
				{
					$Valor=str_replace(',','.',$Codigo);
					$Consulta="select * from pcip_svp_variacion_inventario_ppto";
					$Consulta.=" where cod_asignacion='".$CmbAsig."' and cod_area='".$CmbArea."' and cod_maquila='".$CmbMaqui."'";
					$Consulta.=" and cod_producto='".$CmbProd."' and ano='".$Ano."' and mes='".$Cont."'";
					$Resp=mysqli_query($link, $Consulta);
					if($Fila=mysql_fetch_array($Resp))
					{
					$Actualizar="UPDATE pcip_svp_variacion_inventario_ppto set valor_ppto='".$Valor."'";
					$Actualizar.=" where cod_asignacion='".$CmbAsig."' and cod_area='".$CmbArea."' and cod_maquila='".$CmbMaqui."' and cod_producto='".$CmbProd."' and ano='".$Ano."' and mes='".$Cont."'";
					//echo $Actualizar."<br>";
					mysql_query($Actualizar);					
					}
					else
					{
						$Inserta="insert into pcip_svp_variacion_inventario_ppto (cod_asignacion,cod_area,cod_maquila,cod_producto,ano,mes,valor_ppto)";
						$Inserta.=" values('".$CmbAsig."','".$CmbArea."','".$CmbMaqui."','".$CmbProd."','".$Ano."','".$Cont."','".$Valor."')";
						//echo $Inserta."<br>";
						mysql_query($Inserta);
					}
				}
			}	
			$Aux=$CmbAsig."~".$CmbArea."~".$CmbMaqui."~".$CmbProd."~".$Ano; 			     
			header('location:pcip_mantenedor_variaciones_inventarios_ppto_proceso.php?Opcion=M&Cod='.$Aux);			
		    break;
			
/*		case "M"://MODIFICACION VARIACIONES INVENTARIO PPTO
			$Valor=explode('~',$Aux);
			$Actualizar="UPDATE pcip_svp_variacion_inventario set valor_ppto='".$Valor."'";
			$Actualizar.=" where cod_asignacion='".$CmbAsig."' and cod_area='".$CmbArea."' and cod_maquila='".$CmbMaqui."' and cod_producto='".$CmbProd."' and ano='".$Ano."' and mes='".$Cont."'";
			echo $Actualizar;
			mysql_query($Actualizar);
			header('location:pcip_mantenedor_variaciones_inventarios_proceso.php?Opcion=M&Cod='.$Aux);	
            break;			
*/			
		case "E"://ELIMINACION VARIACIONES INVENTARIOS PPTO
		    $Valores=explode('~',$Cod);	
			$Eliminar="delete from pcip_svp_variacion_inventario where cod_asignacion='".$Valores[0]."' and cod_area='".$Valores[1]."' and cod_maquila='".$Valores[2]."' and cod_producto='".$Valores[3]."' and ano='".$Valores[4]."'";
			mysql_query($Eliminar);
			//echo $Eliminar;
			header("location:pcip_mantenedor_variaciones_inventarios_ppto.php?Mensaje=".$Mensaje."&Buscar=S");
			break;
	}
?>
