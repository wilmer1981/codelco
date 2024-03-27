<? 
	include("../principal/conectar_pcip_web.php");
	$Encontro=false;
	switch($Opcion)
	{
		case "N":	
			$Consulta= " select ano,mes,cod_fino from pcip_fac_compra_precios where ano='".$Ano."' and mes='".$Mes."' and cod_fino='".$CmbFino."'";
			$Resp = mysqli_query($link, $Consulta);
			if(!$Fila=mysql_fetch_array($Resp))
			{
//			   if($CmbMoneda=='2')
//			   {
//                $TxtValor=($TxtValor/31.103477)*1000; 
//				$CmbMoneda='3';			
//			   }	
				$TxtValor=str_replace('.','',$TxtValor);
				$TxtValor=str_replace(',','.',$TxtValor);
			    $Mensaje1=false;	
				$Inserta="insert into pcip_fac_compra_precios (ano,mes,cod_fino,valor,cod_moneda)";
				$Inserta.=" values('".$Ano."','".$Mes."','".$CmbFino."','".$TxtValor."','".$CmbMoneda."')";
				mysql_query($Inserta);
			    $Mensaje1=true;
			}			
			else
			{
			$Mensaje=true;			
			}
			//echo $Inserta;
			$Clave=$Ano."~".$Mes."~".$CmbFino;
			header('location:pcip_mantenedor_facturas_compras_precios_proceso.php?Opc=M&Valores='.$Clave.'&Mensaje='.$Mensaje.'&Mensaje1='.$Mensaje1);	
		    break;
		    
		case "M":
		    //if($CmbMoneda=='2')
		    //{
		//	 $TxtValor=($TxtValor/31.103477)*1000; 
			 //$CmbMoneda='3';			
		    //}		
			$Mensaje2=false;					
			$Actualizar="UPDATE pcip_fac_compra_precios set valor = '".$TxtValor."', cod_moneda='".$CmbMoneda."'";
			$Actualizar.=" where ano='".$Ano."' and mes='".$Mes."' and cod_fino='".$CmbFino."'";	
			//echo $Actualizar;
			mysql_query($Actualizar);
			$Mensaje2=true;					
			$Clave=$Ano."~".$Mes."~".$CmbFino;			
			header('location:pcip_mantenedor_facturas_compras_precios_proceso.php?Opc=M&Valores='.$Clave.'&Mensaje2='.$Mensaje2);	
            break;
			
		case "E":		
		    $Datos = explode("//",$Valor);	
			$Cont=0;			
			while (list($clave,$Codigo)=each($Datos))
			{
				$Cont=$Cont+1;
				if($Codigo!='')
				{
				 	$Valores=explode('~',$Codigo);	
					$Eliminar="delete from pcip_fac_compra_precios where ano='".$Valores[0]."' and mes='".$Valores[1]."' and cod_fino='".$Valores[2]."'";
					mysql_query($Eliminar);
				}		
		   }		   
			header("location:pcip_mantenedor_facturas_compras_precios.php?&Buscar=S");
		    break;

	case "NI":				
			header('location:pcip_mantenedor_facturas_compras_precios_proceso.php?Opc=N');	
            break;		
	}
?>
