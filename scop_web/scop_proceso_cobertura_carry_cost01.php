<?
	include("../principal/conectar_scop_web.php");
	include("funciones/scop_funciones.php");
	$Encontro=false;
	$Rut=$CookieRut;
	$Fecha=date('Y-m-d H:i:s');
	switch($Opcion)
	{
		case "N"://GUARDA EL PRIMER PROCESO ANTES DE GRABAR EL CARRY COST
					$Datos1=substr($Datos1,0,strlen($Datos1)-1);
					$Consulta="select max(corr+1) as maximo from scop_carry_cost ";
					$Resp=mysqli_query($link, $Consulta);
					if($Fila=mysql_fetch_array($Resp))
					{
						if($Fila["maximo"]=='')
							$Correlativo=1;	
						else				
							$Correlativo=$Fila["maximo"];
					}
					if($Cober==1)
						$DatoGuardar=$CmbAcuerdoCarry;
					if($Cober==2)
						$DatoGuardar=$ValorPrecioFijo;
					if($CmbTipoCobertura==1)
					{
						$InsertaCost="INSERT INTO scop_carry_cost (corr,parcializacion,ano,mes,acuerdo_contractual,estado,acuerdo_contractual_qp_cu,acuerdo_contractual_qp_ag,acuerdo_contractual_qp_au,tipo_cobertura,precio_fijo_cu,precio_fijo_ag,precio_fijo_au)";
						$InsertaCost.=" values('".$Correlativo."','1','".$Ano."','".$CmbMes."','".$CmbAcuerdo."','2','".$CmbAcuerdoCarryCu."','".$CmbAcuerdoCarryAg."','".$CmbAcuerdoCarryAu."','".$CmbTipoCobertura."','0','0','0')";
						mysql_query($InsertaCost);
						$Carry=$CmbAcuerdoCarryCu.",".$CmbAcuerdoCarryAg.",".$CmbAcuerdoCarryAu.",";
						if($Carry!='')
							$Carry=substr($Carry,0,strlen($Carry)-1);
					}
					if($CmbTipoCobertura==2)
					{
						$arreglo=array();
						$Datos = explode("~",$TipoEst);
						$x=0;
						foreach($Datos as $clave => $Codigo)
						{
							$arreglo[$x][0]=$Codigo;
							$x=$x+1; 
						}	
						for($i=0;$i<=$x;$i++)
						{
							if('Cu'==$arreglo[$i][0])
							{	
								if($ValorPrecioFijoCu!='')						
								{
									$ValorPrecioFijoCu=str_replace(".","",$ValorPrecioFijoCu);
									$ValorPrecioFijoCu=str_replace(",",".",$ValorPrecioFijoCu);
								}
								else
									$ValorPrecioFijoCu=0;
							}
							if(!isset($ValorPrecioFijoCu))
								$ValorPrecioFijoCu=0;
							if('Ag'==$arreglo[$i][0])
							{
								if($ValorPrecioFijoAg!='')						
								{
									$ValorPrecioFijoAg=str_replace(".","",$ValorPrecioFijoAg);
									$ValorPrecioFijoAg=str_replace(",",".",$ValorPrecioFijoAg);
								}
								else
									$ValorPrecioFijoAg=0;
							}
							if(!isset($ValorPrecioFijoAg))
								$ValorPrecioFijoAg=0;
							if('Au'==$arreglo[$i][0])
							{
								if($ValorPrecioFijoAu!='')						
								{
									$ValorPrecioFijoAu=str_replace(".","",$ValorPrecioFijoAu);
									$ValorPrecioFijoAu=str_replace(",",".",$ValorPrecioFijoAu);
								}
								else
									$ValorPrecioFijoAu=0;
							}
							if(!isset($ValorPrecioFijoAu))
								$ValorPrecioFijoAu=0;

						$Carry=$ValorPrecioFijoCu.",".$ValorPrecioFijoAg.",".$ValorPrecioFijoAu.",";
						if($Carry!='')
							$Carry=substr($Carry,0,strlen($Carry)-1);
						}
						$InsertaCost="INSERT INTO scop_carry_cost (corr,parcializacion,ano,mes,acuerdo_contractual,estado,tipo_cobertura,precio_fijo_cu,precio_fijo_ag,precio_fijo_au)";
						$InsertaCost.=" values('".$Correlativo."','1','".$Ano."','".$CmbMes."','".$CmbAcuerdo."','2','".$CmbTipoCobertura."','".$ValorPrecioFijoCu."','".$ValorPrecioFijoAg."','".$ValorPrecioFijoAu."')";
						//echo $InsertaCost."<br>";
						mysql_query($InsertaCost);					
					}					
					$Dato=explode("~",$TipoEst);
					while(list($c,$v)=each($Dato))
					{
						if($v=='Cu')
						{
							$CodLey=1;					
							$InventarioCu=str_replace(".","",$InventarioCu);
							$InventarioCu=str_replace(",",".",$InventarioCu);
							$Valor=$InventarioCu;
						}
						if($v=='Ag')
						{
							$CodLey=2;
							$InventarioAg=str_replace(".","",$InventarioAg);
							$InventarioAg=str_replace(",",".",$InventarioAg);
							$Valor=$InventarioAg;
						}
						if($v=='Au')
						{	
							$CodLey=3;
							$InventarioAu=str_replace(".","",$InventarioAu);
							$InventarioAu=str_replace(",",".",$InventarioAu);
							$Valor=$InventarioAu;
						}
						$InsertaProceso="INSERT INTO scop_carry_cost_proceso (corr,parcializacion,cod_tipo_titulo,cod_ley,cod_unidad,valor)";
						$InsertaProceso.=" values('".$Correlativo."','1','1','".$CodLey."','3','".$Valor."')";
						mysql_query($InsertaProceso);	
					}
					if($ContInvo=='')
					{			
						$Dato1=explode("~",$ConSelec);
						while(list($c,$v)=each($Dato1))
						{
							$InsertaCorrContrato="INSERT INTO scop_carry_cost_por_contratos (corr,cod_contratos)";
							$InsertaCorrContrato.=" values('".$Correlativo."','".$v."')";
							mysql_query($InsertaCorrContrato);	
						}
					}
					else
					{
						$Dato1=explode("~",$ContInvo);
						while(list($c,$v)=each($Dato1))
						{
							$InsertaCorrContrato="INSERT INTO scop_carry_cost_por_contratos (corr,cod_contratos)";
							$InsertaCorrContrato.=" values('".$Correlativo."','".$v."')";	
							mysql_query($InsertaCorrContrato);	
						}					
					}
				if($ContInvo=='')
					$ContInvo=$ConSelec;
				else
					$ContInvo=$ContInvo;
				//ENVIO DE CORREO FUNCION ESTADO 3
				$Consulta="select * from proyecto_modernizacion.sub_clase";
				$Consulta.=" where cod_clase='33007' and nombre_subclase<>''  and not isnull(nombre_subclase) and valor_subclase1='6'";
				$RespCorreo=mysqli_query($link, $Consulta);
				while($FilaCorreo=mysql_fetch_array($RespCorreo))
					$PARA=$PARA.$FilaCorreo["nombre_subclase"].",";
					
				if($PARA!='')
					$PARA=substr($PARA,0,strlen($PARA)-1);					
				EnvioCorreo($PARA,'2',$TipoEst,$Ano,$CmbMes,$Meses,'PIPC',$CmbTipoCobertura,$CmbAcuerdo,$ContInvo,$Carry,'',$CmbComVen);	//ENVIO CORREO GRABA CARRY COST ESTADO 3

				header('location:scop_proceso_cobertura_carry_cost_proceso.php?Buscar=S&Opc=M&Corr='.$Correlativo.'&ContInvo='.$ContInvo.'&TipoEst='.$TipoEst.'&CmbAcuerdoCarry='.$CmbAcuerdoCarry);			
		break;
		case "M"://Modifica proceso de contratos e ingreso del primer proceso de carry cost				
				$Consulta="select corr from scop_carry_cost where ano='".$Ano."' and mes='".$CmbMes."'";
				$Resp=mysqli_query($link, $Consulta);
				if($Fila=mysql_fetch_array($Resp))
						$Correlativo=$Fila["corr"];

				if($Cober==1)
					$DatoGuardar=$CmbAcuerdoCarry;
				if($Cober==2)
					$DatoGuardar=$ValorPrecioFijo;
				if($CmbTipoCobertura==1)
				{
					$ActualizaCost="UPDATE scop_carry_cost set acuerdo_contractual_qp_cu='".$CmbAcuerdoCarryCu."',acuerdo_contractual_qp_ag='".$CmbAcuerdoCarryAg."',acuerdo_contractual_qp_au='".$CmbAcuerdoCarryAu."',tipo_cobertura='".$CmbTipoCobertura."',precio_fijo='0'";
					$ActualizaCost.=" where corr='".$Correlativo."' and parcializacion='1' and ano='".$Ano."' and mes='".$CmbMes."'";
					mysql_query($ActualizaCost);	
				}
				if($CmbTipoCobertura==2)
				{
						$arreglo=array();
						$Datos = explode("~",$TipoEst);
						$x=0;
						foreach($Datos as $clave => $Codigo)
						{
							$arreglo[$x][0]=$Codigo;
							$x=$x+1; 
						}	
						for($i=0;$i<=$x;$i++)
						{
							if('Cu'==$arreglo[$i][0])
							{	
								if($ValorPrecioFijoCu!='')						
								{
									$ValorPrecioFijoCu=str_replace(".","",$ValorPrecioFijoCu);
									$ValorPrecioFijoCu=str_replace(",",".",$ValorPrecioFijoCu);
								}
								else
									$ValorPrecioFijoCu=0;
							}
							if(!isset($ValorPrecioFijoCu))
								$ValorPrecioFijoCu=0;
							if('Ag'==$arreglo[$i][0])
							{
								if($ValorPrecioFijoAg!='')						
								{
									$ValorPrecioFijoAg=str_replace(".","",$ValorPrecioFijoAg);
									$ValorPrecioFijoAg=str_replace(",",".",$ValorPrecioFijoAg);
								}
								else
									$ValorPrecioFijoAg=0;
							}
							if(!isset($ValorPrecioFijoAg))
								$ValorPrecioFijoAg=0;
							if('Au'==$arreglo[$i][0])
							{
								if($ValorPrecioFijoAu!='')						
								{
									$ValorPrecioFijoAu=str_replace(".","",$ValorPrecioFijoAu);
									$ValorPrecioFijoAu=str_replace(",",".",$ValorPrecioFijoAu);
								}
								else
									$ValorPrecioFijoAu=0;
							}
							if(!isset($ValorPrecioFijoAu))
								$ValorPrecioFijoAu=0;
						}
						$ActualizaCost="UPDATE scop_carry_cost set tipo_cobertura='".$CmbTipoCobertura."',precio_fijo_cu='".$ValorPrecioFijoCu."',precio_fijo_ag='".$ValorPrecioFijoAg."',precio_fijo_au='".$ValorPrecioFijoAu."'";
						$ActualizaCost.=" where corr='".$Correlativo."' and parcializacion='1' and ano='".$Ano."' and mes='".$CmbMes."'";
						mysql_query($ActualizaCost);	
				}
				
				$Dato=explode("~",$TipoEst);
				while(list($c,$v)=each($Dato))
				{
					if($v=='Cu')
					{
						$CodLey=1;					
						$InventarioCu=str_replace(".","",$InventarioCu);
						$InventarioCu=str_replace(",",".",$InventarioCu);
						$Valor=$InventarioCu;
					}
					if($v=='Ag')
					{
						$CodLey=2;
						$InventarioAg=str_replace(".","",$InventarioAg);
						$InventarioAg=str_replace(",",".",$InventarioAg);
						$Valor=$InventarioAg;
					}
					if($v=='Au')
					{	
						$CodLey=3;
						$InventarioAu=str_replace(".","",$InventarioAu);
						$InventarioAu=str_replace(",",".",$InventarioAu);
						$Valor=$InventarioAu;
					}
					$ActualizaProceso="UPDATE scop_carry_cost_proceso set valor='".$Valor."'";
					$ActualizaProceso.=" where corr='".$Correlativo."' and parcializacion='1' and cod_tipo_titulo='1' and cod_ley='".$CodLey."'";
					mysql_query($ActualizaProceso);	
				}
				if($ContInvo=='')
				{			
					$Dato1=explode("~",$ConSelec);
					while(list($c,$v)=each($Dato1))
					{
						$Consulta="select * from scop_carry_cost_por_contratos where corr='".$Correlativo."' and cod_contratos='".$v."'";
						$Resp=mysqli_query($link, $Consulta);
						if(!$Fila=mysql_fetch_array($Resp))
						{
							$InsertaCorrContrato="INSERT INTO scop_carry_cost_por_contratos (corr,cod_contratos)";
							$InsertaCorrContrato.=" values('".$Correlativo."','".$v."')";
							mysql_query($InsertaCorrContrato);	
						}
						else
						{
							$ActualizaCorrContrato="UPDATE scop_carry_cost_por_contratos set cod_contratos='".$v."'";
							$ActualizaCorrContrato.=" where corr='".$Correlativo."'";
							mysql_query($ActualizaCorrContrato);	
						}
					}
				}
				else
				{
					$ContInvo=substr($ContInvo,0,strlen($ContInvo)-1);
					$Dato1=explode("~",$ContInvo);
					while(list($c,$v)=each($Dato1))
					{
						$Consulta="select * from scop_carry_cost_por_contratos where corr='".$Correlativo."' and cod_contratos='".$v."'";
						$Resp=mysqli_query($link, $Consulta);
						if(!$Fila=mysql_fetch_array($Resp))
						{
							$InsertaCorrContrato="INSERT INTO scop_carry_cost_por_contratos (corr,cod_contratos)";
							$InsertaCorrContrato.=" values('".$Correlativo."','".$v."')";
							mysql_query($InsertaCorrContrato);	
						}
						else
						{
							$ActualizaCorrContrato="UPDATE scop_carry_cost_por_contratos set cod_contratos='".$v."'";
							$ActualizaCorrContrato.=" where corr='".$Correlativo."'";
							mysql_query($ActualizaCorrContrato);	
						}
					}					
				}
				if($ContInvo=='')
					$ContInvo=$ConSelec;
				else
					$ContInvo=$ContInvo;
				header('location:scop_proceso_cobertura_carry_cost_proceso.php?Buscar=S&Opc=M&Corr='.$Correlativo.'&ContInvo='.$ContInvo.'&TipoEst='.$TipoEst.'&CmbAcuerdoCarry='.$CmbAcuerdoCarry);			
		break;
		case "GC":	// Grabar nuevo Carry Cost y ENVIO DE CORREO
			if($Cober==1)
				$DatoGuardar=$CmbAcuerdoCarry;
			if($Cober==2)
				$DatoGuardar=$ValorPrecioFijo;
			if($Cober==3)	
				$DatoGuardar=$DatoGuardado;	
			$VDPrincipal=explode("//",$DatosPrincipal);
			while(list($c,$VDPConsulta)=each($VDPrincipal))
			{
				$VDPConsulta=explode("~",$VDPConsulta);
				$ConsultaCost="select * from scop_carry_cost where corr='".$VDPConsulta[0]."' and parcializacion='".$VDPConsulta[1]."' and ano='".$VDPConsulta[2]."' and mes='".$VDPConsulta[3]."'";
				$RespCost=mysql_query($ConsultaCost);
				if(!$FilaCost=mysql_fetch_array($RespCost))
				{
					$ActualizarCost="UPDATE scop_carry_cost set ano='".$Ano."',mes='".$VDPConsulta[3]."',tipo_cobertura='".$VDPConsulta[4]."', estado='3'";
					$ActualizarCost.=" where corr='".$VDPConsulta[0]."' and parcializacion='".$VDPConsulta[1]."'";
					//echo "actualiza cost: entra acs   ".$ActualizarCost."<br>";
					mysql_query($ActualizarCost);	
				}
				else
				{
					$ActualizarCost="UPDATE scop_carry_cost set ano='".$Ano."',mes='".$VDPConsulta[3]."',tipo_cobertura='".$VDPConsulta[4]."',estado='3'";
					$ActualizarCost.=" where corr='".$VDPConsulta[0]."' and parcializacion='".$VDPConsulta[1]."'";
					//echo "actualiza cost:   ".$ActualizarCost."<br>"; 
					mysql_query($ActualizarCost);	
				}
			}	
			$Codigo=explode("//",$Codigo);
			while(list($c,$v)=each($Codigo))
			{
				$Datos=explode("_",$v);
				$ValoresDatos=explode("//",$Valores2);
				while(list($c,$Clave)=each($ValoresDatos))
				{
					$DatosValores=explode("_",$Clave);
					if($DatosValores[0]=='Cu')
					{
						$Cod_ley=1;	
						$DatosValores[3]=str_replace(".","",$DatosValores[3]);
						$DatosValores[3]=str_replace(",",".",$DatosValores[3]);
						$Valor=$DatosValores[3];
					}	
					if($DatosValores[0]=='Ag')
					{
						$Cod_ley=2;
						$DatosValores[3]=str_replace(".","",$DatosValores[3]);
						$DatosValores[3]=str_replace(",",".",$DatosValores[3]);
						$Valor=$DatosValores[3];
					}
					if($DatosValores[0]=='Au')
					{	
						$Cod_ley=3;
						$DatosValores[3]=str_replace(".","",$DatosValores[3]);
						$DatosValores[3]=str_replace(",",".",$DatosValores[3]);
						$Valor=$DatosValores[3];
					}
					$Consulta="select * from scop_carry_cost_proceso where corr='".$Datos[0]."' and parcializacion='".$Datos[1]."' and cod_tipo_titulo='2' and cod_ley='".$Cod_ley."'";
					$Resp=mysqli_query($link, $Consulta);
					if(!$Fila=mysql_fetch_array($Resp))
					{
						$InsertaProceso="INSERT INTO scop_carry_cost_proceso (corr,parcializacion,cod_tipo_titulo,cod_ley,cod_unidad,valor)";
						$InsertaProceso.=" values('".$DatosValores[1]."','".$DatosValores[2]."','2','".$Cod_ley."','3','".$Valor."')";
						//echo $InsertaProceso."<br>";
						mysql_query($InsertaProceso);	
					}
					else
					{
						$ActualizarProceso="UPDATE scop_carry_cost_proceso set valor='".$Valor."'";
						$ActualizarProceso.=" where corr='".$DatosValores[1]."' and parcializacion='".$DatosValores[2]."' and cod_tipo_titulo='".$Fila[cod_tipo_titulo]."' and cod_ley='".$Fila["cod_ley"]."'";							
						//echo $ActualizarProceso."<br>";
						mysql_query($ActualizarProceso);	
					}	
				}
			}
			$DatosContratos=explode("~",$Contratos);
			while(list($c,$v)=each($DatosContratos))
			{
				$Consulta="select * from scop_inventario where cod_estado='3' and ano='".$Ano."' and mes='".$Mes."' and cod_contrato='".$v."'";
				$Resp=mysqli_query($link, $Consulta);
				if(!$Fila=mysql_fetch_array($Resp))
				{
					$InsertaEstado="INSERT INTO scop_inventario (cod_estado,ano,mes,cod_contrato,rut,fecha_hora,observacion)";
					$InsertaEstado.=" values('3','".$Ano."','".$Mes."','".$v."','".$Rut."','".$Fecha."','CarryIngresado')";
				    mysql_query($InsertaEstado);	
	
					//EN EL CAMPO IDENTIFICACION VA TIPOCONTRATO-A�O-MES
					$InsertaRegistroEstado="INSERT INTO scop_registro_estado (cod_estado,identificacion,rut,fecha_hora,observacion)";
					$InsertaRegistroEstado.=" values('3','".$v."-".$Ano."-".$Mes."','".$Rut."','".$Fecha."','Carry Cost Ingresado, Envio Correo a Precios Metales')";
					mysql_query($InsertaRegistroEstado);	
				}
			}				
			//ENVIO DE CORREO FUNCION ESTADO 3
			$Consulta="select * from proyecto_modernizacion.sub_clase";
			$Consulta.=" where cod_clase='33007' and nombre_subclase<>''  and not isnull(nombre_subclase) and valor_subclase1='2'";
			$RespCorreo=mysqli_query($link, $Consulta);
			while($FilaCorreo=mysql_fetch_array($RespCorreo))
				$PARA=$PARA.$FilaCorreo["nombre_subclase"].",";
					
			if($PARA!='')
				$PARA=substr($PARA,0,strlen($PARA)-1);					
			EnvioCorreo($PARA,'3',$TipEst,$Ano,$Mes,$Meses,'GC','',$CmbAcuerdo,'','','','');	//ENVIO CORREO GRABA CARRY COST ESTADO 3

			$Enviocc='N';
			$Consulta="select * from proyecto_modernizacion.sub_clase";
			$Consulta.=" where cod_clase='33007' and nombre_subclase<>''  and not isnull(nombre_subclase) and valor_subclase1='2'";
			//echo $Consulta."<br>";
			$RespCorreo=mysqli_query($link, $Consulta);
			if($FilaCorreo=mysql_fetch_array($RespCorreo))
				$Enviocc='S';

			header('location:scop_proceso_cobertura_carry_cost.php?Buscar=S&TipoEst='.$TipoEst.'&Ano='.$Ano.'&CmbAcuerdo='.$CmbAcuerdo.'&Enviocc='.$Enviocc);			
	    break;	
		case "MPCC":
			$Datos=explode("~",$Datos);
			$TxtNuevo=str_replace(",",".",$TxtNuevo);
			$ActualizaProceso="UPDATE scop_carry_cost_proceso set valor='".$TxtNuevo."'";
			$ActualizaProceso.=" where corr='".$Datos[0]."' and parcializacion='".$Datos[1]."' and cod_tipo_titulo='2' and cod_ley='".$Datos[2]."'";
			//echo $ActualizaProceso."<br><br>";
			mysql_query($ActualizaProceso);	
			$Cod=$Datos[0]."~".$Datos[1]."~".$Datos[2];
			$Tipo=$TipoEst;
			header('location:scop_proceso_cobertura_carry_cost_precio.php?Valores='.$Cod.'&TipoEst='.$Tipo);
		break;	    
		case "AC"://ABRIR CANDADO
			$Valores=explode("//",$Valores);
			while(list($c,$Codigo)=each($Valores))
			{
				$Dato=explode("~",$Codigo);
				$InsertaCost="UPDATE scop_carry_cost set estado='2'";
				$InsertaCost.=" where corr='".$Dato[0]."' and parcializacion='".$Dato[1]."' and ano='".$Dato[2]."' and mes='".$Dato[3]."'";
				//echo $InsertaCost."<br><br>";
				mysql_query($InsertaCost);	
				
				$DatosContratos=explode("~",$Contratos);
				while(list($c,$v)=each($DatosContratos))
				{
					$Consulta="select * from scop_inventario where cod_estado='3' and ano='".$Ano."' and mes='".$Mes."' and cod_contrato='".$v."'";
					//echo $Consulta."<br>";
					$Resp=mysqli_query($link, $Consulta);
					if($Fila=mysql_fetch_array($Resp))
					{		
						$EliminarEstado="delete from scop_inventario where cod_estado='3' and ano='".$Ano."' and mes='".$Mes."' and cod_contrato='".$v."'";
						//echo $EliminarEstado."<br>";
						mysql_query($EliminarEstado);	

						//EN EL CAMPO IDENTIFICACION VA TIPOCONTRATO-A�O-MES
						$InsertaRegistroEstado="INSERT INTO scop_registro_estado (cod_estado,identificacion,rut,fecha_hora,observacion)";
						$InsertaRegistroEstado.=" values('3','".$v."-".$Ano."-".$Mes."','".$Rut."','".$Fecha."','Candado Carry Cost Abierto, Ingreso de Nuevos Valores')";
						//echo $InsertaRegistroEstado."<br>";
						mysql_query($InsertaRegistroEstado);	
					}
				}	
			}
			header('location:scop_proceso_cobertura_carry_cost.php?Buscar=S&TipoEst='.$TipoEst.'&Ano='.$Ano.'&CmbAcuerdo='.$CmbAcuerdo);
		break;	
		case "VPM"://VALIDA PRECIOS INGRESADOS EN LA PANTALLA DE PRECIOS DE METALES
			$Valores=explode("//",$Valores);
			while(list($c,$Codigo)=each($Valores))
			{
				$Dato=explode("~",$Codigo);
				$InsertaCost="UPDATE scop_carry_cost set estado='5'";
				$InsertaCost.=" where corr='".$Dato[0]."' and parcializacion='".$Dato[1]."' and ano='".$Dato[2]."' and mes='".$Dato[3]."'";
				//echo $InsertaCost."<br><br>";
				mysql_query($InsertaCost);	

				$InsertaRegistroEstado="INSERT INTO scop_registro_estado (cod_estado,identificacion,rut,fecha_hora,observacion)";
				$InsertaRegistroEstado.=" values('5','".$Dato[0]."-".$Dato[1]."-".$Dato[2]."-".$Dato[3]."','".$Rut."','".$Fecha."','Proceso Validado Para Imputar')";
				//echo $InsertaRegistroEstado."<br>";
				mysql_query($InsertaRegistroEstado);	
			}
			//ENVIO DE CORREO EN FUNCION	Valida Precios Metales
			$Consulta="select * from proyecto_modernizacion.sub_clase";
			$Consulta.=" where cod_clase='33007' and nombre_subclase<>''  and not isnull(nombre_subclase) and valor_subclase1='4'";
			//echo $Consulta."<br>";
			$RespCorreo=mysqli_query($link, $Consulta);
			while($FilaCorreo=mysql_fetch_array($RespCorreo))
				$PARA=$PARA.$FilaCorreo["nombre_subclase"].",";
					
			if($PARA!='')
				$PARA=substr($PARA,0,strlen($PARA)-1);					
			EnvioCorreo($PARA,'5',$TipEst,$Ano,$Mes,$Meses,'VIMP','',$CmbAcuerdo,'','','','');	//Valida para INGRESAR VALORES EN IMPUTACION

			$EnvioPv='N';
			$Consulta="select * from proyecto_modernizacion.sub_clase";
			$Consulta.=" where cod_clase='33007' and nombre_subclase<>''  and not isnull(nombre_subclase) and valor_subclase1='4'";
			//echo $Consulta."<br>";
			$RespCorreo=mysqli_query($link, $Consulta);
			if($FilaCorreo=mysql_fetch_array($RespCorreo))
				$EnvioPv='S';

			header('location:scop_proceso_cobertura_carry_cost.php?Buscar=S&TipoEst='.$TipoEst.'&Ano='.$Ano.'&CmbAcuerdo='.$CmbAcuerdo.'&EnvioPv='.$EnvioPv);
		break;    
		case "DVPM"://DES-VALIDA PRECIOS INGRESADOS EN LA PANTALLA DE PRECIOS DE METALES
			$Valores=explode("//",$Valores);
			while(list($c,$Codigo)=each($Valores))
			{
				$Dato=explode("~",$Codigo);
				$InsertaCost="UPDATE scop_carry_cost set estado='3'";
				$InsertaCost.=" where corr='".$Dato[0]."' and parcializacion='".$Dato[1]."' and ano='".$Dato[2]."' and mes='".$Dato[3]."'";
				//echo $InsertaCost."<br><br>";
				mysql_query($InsertaCost);	

				$InsertaRegistroEstado="INSERT INTO scop_registro_estado (cod_estado,identificacion,rut,fecha_hora,observacion)";
				$InsertaRegistroEstado.=" values('3','".$Dato[0]."-".$Dato[1]."-".$Dato[2]."-".$Dato[3]."','".$Rut."','".$Fecha."','Proceso Validaci�n Desactivada')";
				//echo $InsertaRegistroEstado."<br>";
				mysql_query($InsertaRegistroEstado);	
			}
			header('location:scop_proceso_cobertura_carry_cost.php?Buscar=S&TipoEst='.$TipoEst.'&Ano='.$Ano.'&CmbAcuerdo='.$CmbAcuerdo);
		break;	
	}			
?>		