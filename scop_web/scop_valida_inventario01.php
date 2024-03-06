<?  
	include("../principal/conectar_scop_web.php");
	include("funciones/scop_funciones.php");	
	$Encontro=false;
	$Rut=$CookieRut;
	$Fecha=date('Y-m-d H:i:s');
		//ENVIO DE CORREOS
	switch($Opcion)
	{
		case "E":	
			$Datos=explode("~",$Valores);
			$Consulta="select * from scop_carry_cost where ano='".$Datos[1]."' and mes='".$Datos[2]."'";
			$Resp=mysql_query($Consulta);
			if($Fila=mysql_fetch_array($Resp))
			{
				//ELIMINO PARCIALIZACIONES CREADAS
				$EliminarCarryCost="delete from scop_carry_cost where corr='".$Fila["corr"]."'";
				//echo $EliminarCarryCost."<br>";
				mysql_query($EliminarCarryCost);

				//ELIMINO LOS VALORES GUARDADOS PARA ESE CORRELATIVO Y PARCIALIZACION
				$EliminarCarryCostProceso="delete from scop_carry_cost_proceso where corr='".$Fila["corr"]."'";
				mysql_query($EliminarCarryCostProceso);
				
				//ELIMINO LOS CONTRATOS PARA ESE CORRELATIVO
				$EliminarCarryCostContratos="delete from scop_carry_cost_por_contratos where corr='".$Fila["corr"]."";
				mysql_query($EliminarCarryCostContratos);
				
			}	
			$EliminarEstado="delete from scop_inventario where cod_contrato='".$Datos[0]."' and ano='".$Datos[1]."' and mes='".$Datos[2]."'";
			//echo $EliminarEstado."<br>";
			mysql_query($EliminarEstado);		
			//ACA EN IDENTIFICACION GUARDAR TIPO CONTRATO - ANO - MES
			$InsertarRe="INSERT INTO scop_registro_estado (cod_estado,identificacion,tipo_estado,rut,fecha_hora,observacion)";
			$InsertarRe.=" values ('1','".$Datos[0]."-".$Datos[1]."-".$Datos[2]."','','".$Rut."','".$Fecha."','desvalidado')";	
			mysql_query($InsertarRe);
			$MEli='S';														
			header('location:scop_valida_inventario.php?CmbTipoContr='.$CmbTipoContr.'&CmbContrato='.$CmbContrato.'&CmbMes='.$CmbMes.'&Buscar=S&MEli='.$MEli);
		break;
		case "ET":	
			$Datos=explode("~",$Valores);
			foreach($Datos as $c => $v)	
			{		
				$Consulta="select * from scop_inventario where ano='".$Ano."' and cod_contrato='".$v."' and cod_estado='2'";
				if($CmbMes!='T')
					$Consulta.=" and mes='".$CmbMes."'";
				$Resp=mysql_query($Consulta);
				if($Fila=mysql_fetch_array($Resp))
				{
					$Consulta2="select * from scop_inventario where ano='".$Ano."' and cod_contrato='".$Fila["cod_contrato"]."' and cod_estado='3'";
					if($CmbMes!='T')
						$Consulta2.=" and mes='".$CmbMes."'";
					$Resp2=mysql_query($Consulta2);
					if($Fila2=mysql_fetch_array($Resp2))
					{
						//echo "contrato".$Fila2["cod_contrato"]."no se puede eliminar hay carry ingresado";
					}
					else
					{
						//echo "contrato".$Fila["cod_contrato"]."&nbsp;se puede eliminar ya que no tiene carry ingresado";
						$Consulta3="select * from scop_carry_cost where ano='".$Fila["ano"]."' and mes='".$Fila["mes"]."'";
						$Resp3=mysql_query($Consulta3);
						if($Fila3=mysql_fetch_array($Resp3))
						{
							//ELIMINO PARCIALIZACIONES CREADAS
							$EliminarCarryCost="delete from scop_carry_cost where corr='".$Fila3["corr"]."'";
							mysql_query($EliminarCarryCost);
			
							//ELIMINO LOS VALORES GUARDADOS PARA ESE CORRELATIVO Y PARCIALIZACION
							$EliminarCarryCostProceso="delete from scop_carry_cost_proceso where corr='".$Fila3["corr"]."'";
							mysql_query($EliminarCarryCostProceso);
							
							//ELIMINO LOS CONTRATOS PARA ESE CORRELATIVO
							$EliminarCarryCostContratos="delete from scop_carry_cost_por_contratos where corr='".$Fila3["corr"]."";
							mysql_query($EliminarCarryCostContratos);
							$MEli='S';	
						
							$EliminarEstado="delete from scop_inventario where cod_contrato='".$v."' and ano='".$Fila3["ano"]."' and mes='".$Fila3["mes"]."'";
							mysql_query($EliminarEstado);		
							//ACA EN IDENTIFICACION GUARDAR TIPO CONTRATO - ANO - MES
							$InsertarRe="INSERT INTO scop_registro_estado (cod_estado,identificacion,tipo_estado,rut,fecha_hora,observacion)";
							$InsertarRe.=" values ('1','".$v."-".$Fila3["ano"]."-".$Fila3["mes"]."','','".$Rut."','".$Fecha."','desvalidado')";	
							mysql_query($InsertarRe);
						}
						else
						{
							$EliminarEstado="delete from scop_inventario where cod_contrato='".$v."' and ano='".$Fila["ano"]."' and mes='".$Fila["mes"]."'";
							mysql_query($EliminarEstado);		
						}
					}
				}
			}																			
			header('location:scop_valida_inventario.php?CmbTipoContr='.$CmbTipoContr.'&CmbContrato='.$CmbContrato.'&CmbMes='.$CmbMes.'&Buscar=S&MEli='.$MEli);
		break;
		case "VPI":
			$Valores=explode("~",$Valores);
			$Inserta="INSERT INTO scop_inventario (cod_estado,cod_contrato,rut,fecha_hora,ano,mes,observacion)";
			$Inserta.=" values('1','".$Valores[2]."','".$Rut."','".$Fecha."','".$Valores[0]."','".$Valores[1]."','Contrato Validado')";
			mysql_query($Inserta);
			$Val='S';				
			header('location:scop_valida_inventario.php?Buscar=S&CmbTipoContr='.$CmbTipoContr.'&CmbContrato='.$CmbContrato.'&Ano='.$Ano.'&CmbMes='.$CmbMes.'&Val='.$Val);	
		break;
	}
?>
