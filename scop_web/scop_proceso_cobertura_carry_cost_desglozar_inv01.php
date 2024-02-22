<?
	include("../principal/conectar_scop_web.php");
	include("funciones/scop_funciones.php");
	$Encontro=false;
	$Rut=$CookieRut;
	$Fecha=date('Y-m-d H:i:s');
	switch($Opcion)
	{
		case "RE"://Guardar Numero redondeado
				$Dato=explode("~",$Datos);
				$ActualizarRedondeo="UPDATE scop_carry_cost_proceso set valor='".$ValorRedondeo."' ";
				$ActualizarRedondeo.=" where corr='".$Dato[0]."' and parcializacion='".$Dato[1]."' and cod_tipo_titulo='1' and cod_ley='".$CmbInventario."'";
				//echo $ActualizarRedondeo."<br><br>";
				mysql_query($ActualizarRedondeo);
				$Mensaje='R';
				header('location:scop_proceso_cobertura_carry_cost_desglozar_inv.php?Opc=N&Datos='.$Datos.'&TipoEst='.$TipoEst.'&Acu='.$Acu.'&CPO='.$CPO.'&Mensaje='.$Mensaje);			
		break;
		case "PA"://Guardar Numero Parcializado m
			   $Dato=explode("~",$Datos);
			   $Consulta="select * from scop_carry_cost where corr='".$Dato[0]."' and ano='".$Dato[2]."' and mes='".$Dato[3]."' order by parcializacion desc";					   
			   $Resp=mysql_query($Consulta);
			   if($Fila=mysql_fetch_array($Resp))
			   {
			   		$Parcializacion=$Fila[parcializacion]+1;
					
				   $InsertarCostParcializa="INSERT INTO scop_carry_cost (corr,parcializacion,ano,mes,acuerdo_contractual,acuerdo_contractual_qp_cu,acuerdo_contractual_qp_ag,acuerdo_contractual_qp_au,tipo_cobertura,estado,precio_fijo_cu,precio_fijo_ag,precio_fijo_au)";
				   $InsertarCostParcializa.=" values ('".$Dato[0]."','".$Parcializacion."','".$Dato[2]."','".$Dato[3]."','".$Fila[acuerdo_contractual]."','".$Fila[acuerdo_contractual_qp_cu]."','".$Fila[acuerdo_contractual_qp_ag]."','".$Fila[acuerdo_contractual_qp_au]."','".$Fila[tipo_cobertura]."','".$Fila["estado"]."','".$Fila[precio_fijo_cu]."','".$Fila[precio_fijo_ag]."','".$Fila[precio_fijo_au]."')"; 	
				   mysql_query($InsertarCostParcializa);	
				  
				   $ValorParcializar=str_replace(".","",$ValorParcializar);
				   $ValorParcializar=str_replace(",",".",$ValorParcializar);
				   $ValorRestaParcializa=$ValorProcesado-$ValorParcializar;
				   $ActualizaParcializa="UPDATE scop_carry_cost_proceso set valor='".$ValorRestaParcializa."' ";
				   $ActualizaParcializa.=" where corr='".$Dato[0]."' and parcializacion='".$Dato[1]."' and cod_tipo_titulo='1' and cod_ley='".$CmbInventario."'";
				   mysql_query($ActualizaParcializa);	
				
				   $InsertarParcializa="INSERT INTO scop_carry_cost_proceso (corr,parcializacion,cod_tipo_titulo,cod_ley,cod_unidad,valor)";
				   $InsertarParcializa.=" values ('".$Dato[0]."','".$Parcializacion."','1','".$CmbInventario."','3','".$ValorParcializar."')"; 	
				   mysql_query($InsertarParcializa);	
			   }
			   $Mensaje='P';		
			   header('location:scop_proceso_cobertura_carry_cost_desglozar_inv.php?Opc=N&Datos='.$Datos.'&TipoEst='.$TipoEst.'&Acu='.$Acu.'&CPO='.$CPO.'&Mensaje='.$Mensaje);			
		break; 
		case "M":
				if($Check=='1')
				{
					$Dato=explode("~",$Datos);
					$ValorRedondeo=str_replace(".","",$ValorRedondeo);
					$ValorRedondeo=str_replace(",",".",$ValorRedondeo);
					$ActualizarRedondeo="UPDATE scop_carry_cost_proceso set valor='".$ValorRedondeo."' ";
					$ActualizarRedondeo.=" where corr='".$Dato[0]."' and parcializacion='".$Dato[1]."' and cod_tipo_titulo='1' and cod_ley='".$CmbInventario."'";
					//echo $ActualizarRedondeo."<br><br>";
					mysql_query($ActualizarRedondeo);
				}
				else
				{
				   $Dato=explode("~",$Datos);
				   $Consulta="select * from scop_carry_cost where corr='".$Dato[0]."' and ano='".$Dato[2]."' and mes='".$Dato[3]."' order by parcializacion desc";					   
				   $Resp=mysql_query($Consulta);
				   if($Fila=mysql_fetch_array($Resp))
				   {
						$Parcializacion=$Fila[parcializacion]+1;
						
					   $InsertarCostParcializa="INSERT INTO scop_carry_cost (corr,parcializacion,ano,mes,acuerdo_contractual,acuerdo_contractual_qp,tipo_cobertura,estado)";
					   $InsertarCostParcializa.=" values ('".$Dato[0]."','".$Parcializacion."','".$Dato[2]."','".$Dato[3]."','".$Fila[acuerdo_contractual]."','".$Fila[acuerdo_contractual_qp]."','".$Fila[tipo_cobertura]."','".$Fila["estado"]."')"; 	
					   mysql_query($InsertarCostParcializa);	
					  
					   $ValorRestaParcializa=str_replace(".","",$ValorRestaParcializa);
					   $ValorRestaParcializa=str_replace(",",".",$ValorRestaParcializa);
					   
					   $ValorRestaParcializa=$ValorProcesado-$ValorParcializar;
					   $ActualizaParcializa="UPDATE scop_carry_cost_proceso set valor='".$ValorRestaParcializa."' ";
					   $ActualizaParcializa.=" where corr='".$Dato[0]."' and parcializacion='".$Dato[1]."' and cod_tipo_titulo='1' and cod_ley='".$CmbInventario."'";
					   //echo $ActualizaParcializa."<br>";
					   mysql_query($ActualizaParcializa);	
					
					   $InsertarParcializa="INSERT INTO scop_carry_cost_proceso (corr,parcializacion,cod_tipo_titulo,cod_ley,cod_unidad,valor)";
					   $InsertarParcializa.=" values ('".$Dato[0]."','".$Parcializacion."','1','".$CmbInventario."','3','".$ValorParcializar."')"; 	
					   //echo $InsertarParcializa."<br>";
					   mysql_query($InsertarParcializa);	
				   }		
				}	
				header('location:scop_proceso_cobertura_carry_cost_desglozar_inv.php?Opc=N&Datos='.$Datos.'&TipoEst='.$TipoEst.'&Acu='.$Acu.'&CPO='.$CPO);			
		break;
		case "E":
				$Dato=explode("~",$Datos);
				$Consulta="select * from scop_carry_cost where corr='".$Dato[0]."' and ano='".$Dato[2]."' and mes='".$Dato[3]."' and parcializacion>'".$Dato[1]."'";
			    //echo $Consulta."<br>";
				$Resp=mysql_query($Consulta);
			    if($Fila=mysql_fetch_array($Resp))
			    {
					$Mensaje='NE';
				}
				else
				{
					$Consulta="select * from scop_carry_cost_proceso where corr='".$Dato[0]."' and parcializacion='".$Dato[1]."' and cod_tipo_titulo='1' and cod_ley='".$CmbInventario."'";
					$Resp=mysql_query($Consulta);
					if($Fila=mysql_fetch_array($Resp))
							$ValorReal=$Fila["valor"];
					$ValorSumado=$ValorProcesado+$ValorReal;			
												
				    $ActualizaParcializa="UPDATE scop_carry_cost_proceso set valor='".$ValorSumado."' ";
				    $ActualizaParcializa.=" where corr='".$Dato[0]."' and parcializacion='1' and cod_tipo_titulo='1' and cod_ley='".$CmbInventario."'";
				    //echo $ActualizaParcializa."<br>";
				    mysql_query($ActualizaParcializa);
						
					$EliminarCost="delete from scop_carry_cost where corr='".$Dato[0]."' and parcializacion='".$Dato[1]."' and ano='".$Dato[2]."' and mes='".$Dato[3]."'";
					mysql_query($EliminarCost);
					
					$Eliminar="delete from scop_carry_cost_proceso where corr='".$Dato[0]."' and parcializacion='".$Dato[1]."' and cod_tipo_titulo='1' and cod_ley='".$CmbInventario."'";
					mysql_query($Eliminar);	
					$Mensaje='EE';
				}
				$Datos=$Dato[0]."~1~".$Dato[2]."~".$Dato[3]."~".$CmbInventario;
				header('location:scop_proceso_cobertura_carry_cost_desglozar_inv.php?Opc=N&Datos='.$Datos.'&TipoEst='.$TipoEst.'&Acu='.$Acu.'&CPO='.$CPO.'&Mensaje='.$Mensaje);			
		break;  
		case "VVO"://VOLVER EL VALOR A ORIGINAL
				$Valores2=explode("~",$Valores);
				$ValorOriginal=str_replace(".","",$ValorOriginal);
				$ValorOriginal=str_replace(",",".",$ValorOriginal);
			    $ActualizaParcializa="UPDATE scop_carry_cost_proceso set valor='".$ValorOriginal."'";
				$ActualizaParcializa.=" where corr='".$Valores2[0]."' and parcializacion='".$Valores2[1]."' and cod_tipo_titulo='1' and cod_ley='".$CmbInventario."'";
				//echo $ActualizaParcializa."<br>";
				mysql_query($ActualizaParcializa);
				$Mensaje='VVO';				
				header('location:scop_proceso_cobertura_carry_cost_desglozar_inv.php?Opc=N&Datos='.$Valores.'&TipoEst='.$TipoEst.'&Acu='.$Acu.'&CPO='.$CPO.'&Mensaje='.$Mensaje);			
		break;
	}			
?>		