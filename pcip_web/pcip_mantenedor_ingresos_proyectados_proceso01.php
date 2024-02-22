<? 
	include("../principal/conectar_pcip_web.php");
	$Encontro=false;
	switch($Opc)
	{
		case "N":
		    $Datos=explode('//',$Valores2);
			while(list($c,$v)=each($Datos))			
			{			
 			    $Valor=explode('~',$v);
				$Consulta="select * from pcip_inp_precios";
				$Consulta.=" where ano='".$Ano."' and cod_producto='".$CmbProducto."' and cod_deduccion='".$Valor[0]."'";
				//echo $Consulta;
				$Resp=mysql_query($Consulta);
				if($Fila=mysql_fetch_array($Resp))
				{
				    if($Valor[1]=='')
						$Valor[1]=0;
					else
					   	$Valor[1];
				    if($Valor[2]=='')
						$Valor[2]=0;
					else
					   	$Valor[2];						
					$Valor2=str_replace(",",".",$Valor[1]);	
					$ValorPena=str_replace(",",".",$Valor[2]);	
					$Actualizar="UPDATE pcip_inp_precios set valor='".$Valor2."', unidad='".$Valor[3]."',valor_pena='".$ValorPena."'";
					$Actualizar.=" where ano='".$Ano."' and cod_producto='".$CmbProducto."' and cod_deduccion='".$Valor[0]."'";
					//echo $Actualizar."<br>";
					mysql_query($Actualizar);					
				}
				else
				{
				    if($Valor[1]=='')
						$Valor[1]=0;
					else
					   	$Valor[1];
				    if($Valor[2]=='')
						$Valor[2]=0;
					else
					   	$Valor[2];						
					$Valor2=str_replace(",",".",$Valor[1]);						
					$ValorPena=str_replace(",",".",$Valor[2]);	
					$Inserta="insert into pcip_inp_precios (ano,cod_producto,cod_deduccion,valor,unidad,valor_pena)";
					$Inserta.=" values('".$Ano."','".$CmbProducto."','".$Valor[0]."','".$Valor2."','".$Valor[3]."','".$ValorPena."')";
					//echo $Inserta."<br>";
					mysql_query($Inserta);
				}
			}	
			header('location:pcip_mantenedor_ingresos_proyectados.php?Ano='.$Ano.'&Mes='.$Mes.'&CmbProducto='.$CmbProducto.'&Recarga=S');			
		    break;		    
	}
?>
