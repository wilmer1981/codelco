<? 
	include("../principal/conectar_pcip_web.php");
	switch($Opcion)
	{
		case "N"://INGRESO EVALUACION DE NEGOCIOS		
			$Consulta="select ifnull(max(corr)+1,1) as Corr from pcip_eva_negocios ";
			$Resp=mysqli_query($link, $Consulta);
			$Fila=mysql_fetch_array($Resp);
			$CorrNew=$Fila[Corr];
			$Venta='';
			if($CmbOrigen=='2')
				$Venta=1;
			$Analisis=$Venta."||".$OptAnalisis1."||".$OptAnalisis2;
			if($CmbDiv!='-1')
				$Analisis.="||".$OptAnalisis3."~".$CmbDiv;
			if($CmbDiv2!='-1')
				$Analisis.="||".$OptAnalisis3."~".$CmbDiv2;
			$Insertar="insert into pcip_eva_negocios(corr,ano,mes,nom_archivo,cod_material,tipo_origen,analisis)values(";
			$Insertar.="'".$CorrNew."','".$Ano."','".$Mes."','".$TxtNombre."','".$CmbMaterial."','".$CmbOrigen."','".$Analisis."')";
			//echo $Insertar;
			mysql_query($Insertar);
			$Mensaje='Datos Grabados Exitosamente';
			header('location:pcip_evaluacion_negocio_proceso.php?Opc=M&Cod='.$CorrNew.'&Mensaje='.$Mensaje);			
			break;
		case "M"://MODIFICACION EVALUACION DE NEGOCIOS
			$Venta='';
			if($CmbOrigen=='2')
				$Venta=1;
			$Analisis=$Venta."||".$OptAnalisis1."||".$OptAnalisis2;
			if($CmbDiv!='-1')
				$Analisis.="||".$OptAnalisis3."~".$CmbDiv;
			if($CmbDiv2!='-1')
				$Analisis.="||".$OptAnalisis3."~".$CmbDiv2;
			$Actualizar="UPDATE pcip_eva_negocios set ano='".$Ano."',mes='".$Mes."',nom_archivo='".$TxtNombre."',cod_material='".$CmbMaterial."',tipo_origen='".$CmbOrigen."',analisis='".$Analisis."' where corr='".$Cod."'";	
			mysql_query($Actualizar);
			$Consulta = "select cod_subclase as cod_analisis from proyecto_modernizacion.sub_clase where cod_clase='31034'";			
			$Resp=mysqli_query($link, $Consulta);		
			while ($Fila=mysql_fetch_array($Resp))
			{
				$Encontro='N';
				$Datos=explode('||',$Analisis);
				while(list($c,$v)=each($Datos))
				{
					$Datos2=explode('~',$v);
					$CodAnalisis=$Datos2[0];
					//echo trim($Fila["cod_analisis"])."     ==         ".trim($CodAnalisis)."<br>";
					if(trim($Fila["cod_analisis"])==trim($CodAnalisis))
						$Encontro='S';
					//echo $Encontro."<br><br>";	
				}
				if($Encontro=='N')
				{
					$Eliminar="delete from pcip_eva_negocios_deduc_recup where corr='".$Cod."' and cod_tipo_analisis='".$Fila["cod_analisis"]."'";
					mysql_query($Eliminar);
					$Eliminar="delete from pcip_eva_negocios_costos where corr='".$Cod."' and cod_tipo_analisis='".$Fila["cod_analisis"]."'";
					mysql_query($Eliminar);
					$Eliminar="delete from pcip_eva_negocios_castigos where corr='".$Cod."' and cod_tipo_analisis='".$Fila["cod_analisis"]."'";
					mysql_query($Eliminar);
					$Eliminar="delete from pcip_eva_negocios_transporte where corr='".$Cod."' and cod_tipo_analisis='".$Fila["cod_analisis"]."'";
					mysql_query($Eliminar);
					$Eliminar="delete from pcip_eva_negocios_precios where corr='".$Cod."' and cod_tipo_analisis='".$Fila["cod_analisis"]."'";
					mysql_query($Eliminar);
				}
			}			
			$Mensaje='Datos Modificados Exitosamente';
			header('location:pcip_evaluacion_negocio_proceso.php?Opc=M&Cod='.$Cod.'&Mensaje='.$Mensaje);			
			break;	
		case "E";///ELIMINACION EVALUACION DE NEGOCIOS
			$Eliminar="delete from pcip_eva_negocios where corr='".$Cod."'";	
			mysql_query($Eliminar);
			$Eliminar="delete from pcip_eva_negocios_material where corr='".$Cod."'";
			mysql_query($Eliminar);
			$Eliminar="delete from pcip_eva_negocios_deduc_recup where corr='".$Cod."'";
			mysql_query($Eliminar);
			$Eliminar="delete from pcip_eva_negocios_costos where corr='".$Cod."'";
			mysql_query($Eliminar);
			$Eliminar="delete from pcip_eva_negocios_castigos where corr='".$Cod."'";
			mysql_query($Eliminar);
			$Eliminar="delete from pcip_eva_negocios_transporte where corr='".$Cod."'";
			mysql_query($Eliminar);
			$Eliminar="delete from pcip_eva_negocios_precios where corr='".$Cod."'";
			mysql_query($Eliminar);
			$Mensaje='Datos Eliminados Exitosamente';
			header('location:pcip_evaluacion_negocio.php?Mensaje='.$Mensaje);			
			break;
		case "GN"://GUARDAR UNA COPIA YA EXISTEMTE DE ANALISIS
			$Mensaje='Copia Realizada Exitosamente';
			$Consulta="select ifnull(max(corr)+1,1) as Corr from pcip_eva_negocios ";
			$Resp=mysqli_query($link, $Consulta);
			$Fila=mysql_fetch_array($Resp);
			$CorrNew=$Fila[Corr];
			$Consulta="select * from pcip_eva_negocios where corr='".$Cod."'";	
			$Resp=mysqli_query($link, $Consulta);
			$Fila=mysql_fetch_array($Resp);
			$Insertar="insert into pcip_eva_negocios(corr,ano,mes,nom_archivo,cod_material,tipo_origen,analisis,tms,tmh)values(";
			$Insertar.="'".$CorrNew."','".$Ano."','".$Mes."','".$TxtNombre."','".$Fila[cod_material]."','".$Fila[tipo_origen]."','".$Fila[analisis]."','".$Fila[tms]."','".$Fila[tmh]."')";
			//echo $Insertar;
			mysql_query($Insertar);
			$Consulta="select * from pcip_eva_negocios_material where corr='".$Cod."'";
			$Resp=mysqli_query($link, $Consulta);
			while($Fila=mysql_fetch_array($Resp))
			{
				$Insertar="insert into pcip_eva_negocios_material(corr,cod_ley,cod_unidad,cod_division,valor)values(";
				$Insertar.="'".$CorrNew."','".$Fila[cod_ley]."','".$Fila[cod_unidad]."','".$Fila[cod_division]."','".str_replace(',','.',$Fila[valor])."')";
				//echo $Insertar;
				mysql_query($Insertar);
			}
			$Consulta="select * from pcip_eva_negocios_deduc_recup where corr='".$Cod."'";
			$Resp=mysqli_query($link, $Consulta);
			while($Fila=mysql_fetch_array($Resp))
			{
				$Insertar="insert into pcip_eva_negocios_deduc_recup(corr,cod_tipo_analisis,cod_ley,cod_unidad,cod_tipo,valor)values(";
				$Insertar.="'".$CorrNew."','".$Fila[cod_tipo_analisis]."','".$Fila[cod_ley]."','".$Fila[cod_unidad]."','".$Fila[cod_tipo]."','".str_replace(',','.',$Fila[valor])."')";
				//echo $Insertar;
				mysql_query($Insertar);
				
			}
			$Consulta="select * from pcip_eva_negocios_costos where corr='".$Cod."'";
			$Resp=mysqli_query($link, $Consulta);
			while($Fila=mysql_fetch_array($Resp))
			{
				$Insertar="insert into pcip_eva_negocios_costos(corr,cod_tipo_analisis,cod_tipo_costo,cod_unidad,cod_tipo,valor)values(";
				$Insertar.="'".$CorrNew."','".$Fila[cod_tipo_analisis]."','".$Fila[cod_tipo_costo]."','".$Fila[cod_unidad]."','".$Fila[cod_tipo]."','".str_replace(',','.',$Fila[valor])."')";
				//echo $Insertar;
				mysql_query($Insertar);
			}
			$Consulta="select * from pcip_eva_negocios_castigos where corr='".$Cod."'";
			$Resp=mysqli_query($link, $Consulta);
			while($Fila=mysql_fetch_array($Resp))
			{
				$Insertar="insert into pcip_eva_negocios_castigos(corr,cod_tipo_analisis,cod_unidad,cod_tipo,valor)values(";
				$Insertar.="'".$CorrNew."','".$Fila[cod_tipo_analisis]."','".$Fila[cod_unidad]."','".$Fila[cod_tipo]."','".str_replace(',','.',$Fila[valor])."')";
				//echo $Insertar;
				mysql_query($Insertar);
			}
			$Consulta="select * from pcip_eva_negocios_transporte where corr='".$Cod."'";
			$Resp=mysqli_query($link, $Consulta);
			while($Fila=mysql_fetch_array($Resp))
			{
				$Insertar="insert into pcip_eva_negocios_transporte(corr,cod_tipo_analisis,cod_unidad,cod_origen,cod_destino,cod_proceso_previo,valor)values(";
				$Insertar.="'".$CorrNew."','".$Fila[cod_tipo_analisis]."','".$Fila[cod_unidad]."','".$Fila[cod_origen]."','".$Fila[cod_destino]."','".$Fila[cod_proceso_previo]."','".str_replace(',','.',$Fila[valor])."')";
				//echo $Insertar;
				mysql_query($Insertar);
			}
			$Consulta="select * from pcip_eva_negocios_precios where corr='".$Cod."'";
			$Resp=mysqli_query($link, $Consulta);
			while($Fila=mysql_fetch_array($Resp))
			{
				$Insertar="insert into pcip_eva_negocios_precios(corr,cod_tipo_analisis,cod_unidad,cod_tipo,valor,valor2)values(";
				$Insertar.="'".$CorrNew."','".$Fila[cod_tipo_analisis]."','".$Fila[cod_unidad]."','".$Fila[cod_tipo]."','".str_replace(',','.',$Fila[valor])."','".str_replace(',','.',$Fila[valor2])."')";
				//echo $Insertar;
				mysql_query($Insertar);
			}
			header('location:pcip_evaluacion_negocio_proceso.php?Opc=M&Cod='.$CorrNew.'&Mensaje='.$Mensaje);			
			break;	
		//PESTA�A CARACTERISTCAS MATERIAL		
		case "NMAT"://AGREGAR MATERIAL
			if(trim($TxtValor)=='')
				$TxtValor=0;
			if($CmbUnidad==1&&trim($TxtTMS)!=''&&$TxtTMS!=0)//SI EL VALOR ESTA EN TONELADAS(SIGNIFICA QUE INGRESARON EL VALOR EN FINO) TRANSFORMAR A %
			{
				$TxtValor=str_replace(',','.',$TxtValor);
				$TxtValor=($TxtValor*100)/$TxtTMS;
				$CmbUnidad=20;
			}	
			$Insertar="insert into pcip_eva_negocios_material(corr,cod_ley,cod_unidad,cod_division,valor)values(";
			$Insertar.="'".$Cod."','".$CmbLey."','".$CmbUnidad."','".$CmbDivMat."','".str_replace(',','.',$TxtValor)."')";
			//echo $Insertar;
			mysql_query($Insertar);
			$Mensaje='Datos Grabados Exitosamente';
			header('location:pcip_evaluacion_negocio_proceso.php?Opc=M&Cod='.$Cod.'&Mensaje='.$Mensaje.'&Ptl1=CM');			
			break;	
		case "MMAT"://MODIFICAR PESOS DEL MATERIAL
			if(trim($TxtTMH)=='')
				$TxtTMH=0;
			if(trim($TxtTMS)=='')
				$TxtTMS=0;
			$Actualizar="UPDATE pcip_eva_negocios set tmh='".$TxtTMH."',tms='".$TxtTMS."' where corr='".$Cod."'";
			mysql_query($Actualizar);
			$Mensaje='Datos Grabados Exitosamente';
			header('location:pcip_evaluacion_negocio_proceso.php?Opc=M&Cod='.$Cod.'&Mensaje='.$Mensaje.'&Ptl1=CM');			
			break;	
		case "EMAT"://ELIMINAR MATERIAL
			$Datos=explode('~',$Valores);
			$Eliminar="delete from pcip_eva_negocios_material where corr='".$Datos[0]."' and cod_ley='".$Datos[1]."' and cod_division='".$Datos[2]."'";
			//echo $Insertar;
			mysql_query($Eliminar);
			$Mensaje='Datos Eliminado Exitosamente';
			header('location:pcip_evaluacion_negocio_proceso.php?Opc=M&Cod='.$Cod.'&Mensaje='.$Mensaje.'&Ptl1=CM');			
			break;
		//PESTA�A CARACTERISTCAS MATERIAL CONCENTRADOS		
		case "NMATCONS"://AGREGAR MATERIAL CONCENTRADOS
			if(trim($TxtValor)=='')
				$TxtValor=0;
			/*if($CmbUnidad==1&&trim($TxtTMS)!=''&&$TxtTMS!=0)//SI EL VALOR ESTA EN TONELADAS(SIGNIFICA QUE INGRESARON EL VALOR EN FINO) TRANSFORMAR A %
			{
				$TxtValor=str_replace(',','.',$TxtValor);
				$TxtValor=($TxtValor*100)/$TxtTMS;
				$CmbUnidad=20;
			}*/	
			$Insertar="insert into pcip_eva_negocios_material(corr,cod_ley,cod_unidad,cod_division,valor)values(";
			$Insertar.="'".$Cod."','".$CmbLey."','".$CmbUnidad."','".$Ano.$Mes."','".str_replace(',','.',$TxtValor)."')";
			//echo $Insertar;
			mysql_query($Insertar);
			$Mensaje='Datos Grabados Exitosamente';
			header('location:pcip_evaluacion_negocio_proceso.php?Opc=M&Cod='.$Cod.'&Mensaje='.$Mensaje.'&Ptl1=CM&CmbLey=T');			
			break;	
		case "MMATCONS"://MODIFICAR PESOS DEL MATERIAL CONCENTRADOS
			if(trim($TxtTMH)=='')
				$TxtTMH=0;
			if(trim($TxtTMS)=='')
				$TxtTMS=0;
			$TxtTMH=str_replace('.','',$TxtTMH);
			$TxtTMH=str_replace(',','.',$TxtTMH);
			$TxtTMS=str_replace('.','',$TxtTMS);
			$TxtTMS=str_replace(',','.',$TxtTMS);
			$Actualizar="UPDATE pcip_eva_negocios set tmh='".str_replace(',','.',$TxtTMH)."',tms='".str_replace(',','.',$TxtTMS)."',porc_hum='".str_replace(',','.',$TxtHum)."' where corr='".$Cod."'";
			//echo $Actualizar;
			mysql_query($Actualizar);
			$Mensaje='Datos Grabados Exitosamente';
			header('location:pcip_evaluacion_negocio_proceso.php?Opc=M&Cod='.$Cod.'&Mensaje='.$Mensaje.'&Ptl1=CM');			
			break;	
		case "EMATCONS"://ELIMINAR MATERIAL CONCENTRADOS
			$Datos=explode('~',$Valores);
			$Eliminar="delete from pcip_eva_negocios_material where corr='".$Datos[0]."' and cod_ley='".$Datos[1]."' and cod_division='".$Datos[2]."'";
			//echo $Insertar;
			mysql_query($Eliminar);
			$Mensaje='Datos Eliminado Exitosamente';
			header('location:pcip_evaluacion_negocio_proceso.php?Opc=M&Cod='.$Cod.'&Mensaje='.$Mensaje.'&Ptl1=CM&CmbLey=T');			
			break;
		//PESTA�AS ANALISIS		
		case "NVER"://AGREGAR VENTA RECUPERACION
			if($TxtValor=='')
				$TxtValor=0;
			if($TxtDes=='')
				$TxtDes=0;	
			if($CmbMaterial=='2')	
			{
				$Consulta="select max(orden+1) as maximo from pcip_eva_negocios_deduc_recup";
				$Resp=mysqli_query($link, $Consulta);
				//echo $Consulta."<br>";
				if($Fila=mysql_fetch_array($Resp))
				{
					$TxtOrden=$Fila["maximo"];
				}
				$Insertar="insert into pcip_eva_negocios_deduc_recup(corr,cod_tipo_analisis,cod_ley,cod_unidad,cod_tipo,valor,orden,descuento)values(";
				$Insertar.="'".$Cod."','".$CodTipoAnalisis."','".$CmbLey."','".$CmbUnidad."','".$CmbRecup."','".str_replace(',','.',$TxtValor)."','".$TxtOrden."','".$TxtDes."')";
				//echo $Insertar;
				mysql_query($Insertar);
				$Mensaje='Datos Grabados Exitosamente';
			}
			else
			{
				$Insertar="insert into pcip_eva_negocios_deduc_recup(corr,cod_tipo_analisis,cod_ley,cod_unidad,cod_tipo,valor,orden,descuento)values(";
				$Insertar.="'".$Cod."','".$CodTipoAnalisis."','".$CmbLey."','".$CmbUnidad."','".$CmbRecup."','".str_replace(',','.',$TxtValor)."','0','0')";
				//echo $Insertar;
				mysql_query($Insertar);
				$Mensaje='Datos Grabados Exitosamente';
			}
			$Petalo=RetornaPetalo($CodTipoAnalisis);
			header('location:pcip_evaluacion_negocio_proceso.php?Opc=M&Cod='.$Cod.'&Mensaje='.$Mensaje.'&Ptl='.$Petalo.'&MostrarRec=S');			
			break;	
		case "EVER"://ELIMINAR VENTA RECUPERACION
			$Datos=explode('~',$Valores);
			$Eliminar="delete from pcip_eva_negocios_deduc_recup where corr='".$Datos[0]."' and cod_tipo_analisis='".$CodTipoAnalisis."' and cod_ley='".$Datos[1]."' and cod_tipo='".$Datos[2]."'";
			//echo $Insertar;
			mysql_query($Eliminar);
			$Mensaje='Datos Eliminado Exitosamente';
			$Petalo=RetornaPetalo($CodTipoAnalisis);
			header('location:pcip_evaluacion_negocio_proceso.php?Opc=M&Cod='.$Cod.'&Mensaje='.$Mensaje.'&Ptl='.$Petalo.'&MostrarRec=S');			
			break;
		case "NVEMERM":// AGREGAR VENTA MERMA
		   $ConsultaMerma=" select * from pcip_eva_merma where corr='".$Cod."' and cod_tipo_analisis='".$CodTipoAnalisis."'";
		   $Resp=mysql_query($ConsultaMerma);
		   //echo $ConsultaMerma;
		   if(!$Fila=mysql_fetch_array($Resp))
		   {
				$InsertarMerma="insert into pcip_eva_merma(corr,cod_tipo_analisis,cod_unidad,valor)values(";
				$InsertarMerma.="'".$Cod."','".$CodTipoAnalisis."','%','".str_replace(',','.',$ValorMerma)."')";
				//echo $InsertarMerma;
				mysql_query($InsertarMerma);
				$Mensaje='Datos Grabados Exitosamente';
				$Petalo=RetornaPetalo($CodTipoAnalisis);
				header('location:pcip_evaluacion_negocio_proceso.php?Opc=M&Cod='.$Cod.'&Mensaje='.$Mensaje.'&Ptl='.$Petalo);			
			}
			else
			{	
				$Mensaje='No se puede ingresar m�s de una Merma por Analisis';
				$Petalo=RetornaPetalo($CodTipoAnalisis);
				header('location:pcip_evaluacion_negocio_proceso.php?Opc=M&Cod='.$Cod.'&Mensaje='.$Mensaje.'&Ptl='.$Petalo);			
			}
		 	break;
		case "EVEMERM"://VENTA MERMA
			$Datos=explode('~',$Valores);
			$EliminarMerma="delete from pcip_eva_merma where corr='".$Datos[0]."' and cod_tipo_analisis='".$CodTipoAnalisis."'";
			//echo $EliminarMerma;
			mysql_query($EliminarMerma);
			$Mensaje='Datos Eliminado Exitosamente';
			$Petalo=RetornaPetalo($CodTipoAnalisis);
			header('location:pcip_evaluacion_negocio_proceso.php?Opc=M&Cod='.$Cod.'&Mensaje='.$Mensaje.'&Ptl='.$Petalo);			
		 	break;
		case "NVECCA"://AGREGAR VENTA COSTO CARGO
			if($TxtValor2=='')
				$TxtValor2=0;
			if($CmbMaterial=='2')
			{
				if($Lote1TMS=='')
					$Lote1TMS=0;
				if($Dolar=='')
					$Dolar=0;	
				$Insertar="insert into pcip_eva_negocios_costos(corr,cod_tipo_analisis,cod_tipo_costo,cod_unidad,cod_tipo,valor,lote,dolar,observacion,cod_ley)values(";
				$Insertar.="'".$Cod."','".$CodTipoAnalisis."','1','".$CmbUnidad2."','".$CmbCargo."','".str_replace(',','.',$TxtValor2)."','".str_replace(',','.',$Lote1TMS)."','".str_replace(',','.',$Dolar)."','".$Observacion."','".$CmbLeyCar."')";
				//echo $Insertar;
				mysql_query($Insertar);
				$Mensaje='Datos Grabados Exitosamente';
			}
			else
			{
				$Insertar="insert into pcip_eva_negocios_costos(corr,cod_tipo_analisis,cod_tipo_costo,cod_unidad,cod_tipo,valor,lote,dolar,observacion,cod_ley)values(";
				$Insertar.="'".$Cod."','".$CodTipoAnalisis."','1','".$CmbUnidad2."','".$CmbCargo."','".str_replace(',','.',$TxtValor2)."','0','0','','0')";
				//echo $Insertar;
				mysql_query($Insertar);
				$Mensaje='Datos Grabados Exitosamente';
			}							
			$Petalo=RetornaPetalo($CodTipoAnalisis);
			header('location:pcip_evaluacion_negocio_proceso.php?Opc=M&Cod='.$Cod.'&Mensaje='.$Mensaje.'&Ptl='.$Petalo.'&MostrarCosto=S');			
			break;	
		case "EVECCA"://ELIMINAR VENTA COSTO CARGO
			$Datos=explode('~',$Valores);
			$Eliminar="delete from pcip_eva_negocios_costos where corr='".$Datos[0]."' and cod_tipo_analisis='".$CodTipoAnalisis."' and cod_tipo='".$Datos[1]."' and cod_tipo_costo='1' and cod_ley='".$Datos[2]."'";
			//echo $Insertar;
			mysql_query($Eliminar);
			$Mensaje='Datos Eliminado Exitosamente';
			$Petalo=RetornaPetalo($CodTipoAnalisis);
			header('location:pcip_evaluacion_negocio_proceso.php?Opc=M&Cod='.$Cod.'&Mensaje='.$Mensaje.'&Ptl='.$Petalo.'&MostrarCosto=S');			
			break;	
		case "NVECC0"://AGREGAR VENTA COSTO CONTABLE
			if($TxtValor3=='')
				$TxtValor3=0;
			$Insertar="insert into pcip_eva_negocios_costos(corr,cod_tipo_analisis,cod_tipo_costo,cod_unidad,cod_tipo,valor,lote,dolar,cod_ley)values(";
			$Insertar.="'".$Cod."','".$CodTipoAnalisis."','2','".$CmbUnidad3."','".$CmbContable."','".str_replace(',','.',$TxtValor3)."','0','0','0')";
			//echo $Insertar;
			mysql_query($Insertar);
			$Mensaje='Datos Grabados Exitosamente';
			$Petalo=RetornaPetalo($CodTipoAnalisis);
			header('location:pcip_evaluacion_negocio_proceso.php?Opc=M&Cod='.$Cod.'&Mensaje='.$Mensaje.'&Ptl='.$Petalo.'&MostrarCosto=S');			
			break;	
		case "EVECC0"://ELIMINAR VENTA COSTO CONTABLE
			$Datos=explode('~',$Valores);
			$Eliminar="delete from pcip_eva_negocios_costos where corr='".$Datos[0]."' and cod_tipo_analisis='".$CodTipoAnalisis."' and cod_tipo='".$Datos[1]."' and cod_tipo_costo='2'";
			//echo $Insertar;
			mysql_query($Eliminar);
			$Mensaje='Datos Eliminado Exitosamente';
			$Petalo=RetornaPetalo($CodTipoAnalisis);
			header('location:pcip_evaluacion_negocio_proceso.php?Opc=M&Cod='.$Cod.'&Mensaje='.$Mensaje.'&Ptl='.$Petalo.'&MostrarCosto');			
			break;
		case "NVECAS"://AGREGAR VENTA CASTIGO
			if($TxtValor4=='')
				$TxtValor4=0;
			if($CmbMaterial=='2')
			{	
				if($Euro=='')
					$Euro=0;
				else
					$Euro;	
				$Insertar="insert into pcip_eva_negocios_castigos(corr,cod_tipo_analisis,cod_unidad,cod_tipo,valor,observacion,cada,sobre,cod_ley,euro)values(";
				$Insertar.="'".$Cod."','".$CodTipoAnalisis."','".$CmbUnidad4."','".$CmbCastigo."','".str_replace(',','.',$TxtValor4)."','".$ObservacionCas."','".$Cada."','".$Sobre."','".$CmbLeyCast."','".$Euro."')";
				//echo $Insertar;
				mysql_query($Insertar);
				$Mensaje='Datos Grabados Exitosamente';
			}
			else
			{
				$Insertar="insert into pcip_eva_negocios_castigos(corr,cod_tipo_analisis,cod_unidad,cod_tipo,valor,cod_ley,euro)values(";
				$Insertar.="'".$Cod."','".$CodTipoAnalisis."','".$CmbUnidad4."','".$CmbCastigo."','".str_replace(',','.',$TxtValor4)."','0','0')";
				//echo $Insertar;
				mysql_query($Insertar);
				$Mensaje='Datos Grabados Exitosamente';
			}
			$Petalo=RetornaPetalo($CodTipoAnalisis);
			header('location:pcip_evaluacion_negocio_proceso.php?Opc=M&Cod='.$Cod.'&Mensaje='.$Mensaje.'&Ptl='.$Petalo.'&MostrarCast=S');			
			break;	
		case "EVECAS"://ELIMINAR VENTA CASTIGO
			$Datos=explode('~',$Valores);
			$Eliminar="delete from pcip_eva_negocios_castigos where corr='".$Datos[0]."' and cod_tipo_analisis='".$CodTipoAnalisis."' and cod_tipo='".$Datos[1]."' and cod_ley='".$Datos[2]."'";
			//echo $Insertar;
			mysql_query($Eliminar);
			$Mensaje='Datos Eliminado Exitosamente';
			$Petalo=RetornaPetalo($CodTipoAnalisis);
			header('location:pcip_evaluacion_negocio_proceso.php?Opc=M&Cod='.$Cod.'&Mensaje='.$Mensaje.'&Ptl='.$Petalo.'&MostrarCast=S');			
			break;	
		case "NVEFAC":	//AGREGA NUEVO FACTORES
			if($TxtValor8=='')
				$TxtValor8=0;
			if($TxtEuro=='')
				$TxtEuro=0;
			$Insertar="insert into pcip_eva_negocios_factores(corr,cod_tipo_analisis,cod_unidad,cod_tipo,valor,euro)values(";
			$Insertar.="'".$Cod."','".$CodTipoAnalisis."','".$CmbUnidad7."','".$CmbFactores."','".str_replace(',','.',$TxtValor8)."','".str_replace(',','.',$TxtEuro)."')";
			//echo $Insertar;
			mysql_query($Insertar);
			$Mensaje='Datos Grabados Exitosamente';
			$Petalo=RetornaPetalo($CodTipoAnalisis);
			header('location:pcip_evaluacion_negocio_proceso.php?Opc=M&Cod='.$Cod.'&Mensaje='.$Mensaje.'&Ptl='.$Petalo.'&MostrarFact=S');			
			break;	
		case "EVEFAC"://ELIMINAR FACTORES
			$Datos=explode('~',$Valores);
			$Eliminar="delete from pcip_eva_negocios_factores where corr='".$Datos[0]."' and cod_tipo_analisis='".$CodTipoAnalisis."' and cod_tipo='".$Datos[1]."'";
			//echo $Insertar;
			mysql_query($Eliminar);
			$Mensaje='Datos Eliminado Exitosamente';
			$Petalo=RetornaPetalo($CodTipoAnalisis);
			header('location:pcip_evaluacion_negocio_proceso.php?Opc=M&Cod='.$Cod.'&Mensaje='.$Mensaje.'&Ptl='.$Petalo.'&MostrarFact=S');			
			break;	
		case "NVEPREM"://AGREGAR VENTA PREMIO
			if($TxtValor8=='')
				$TxtValor8=0;
			if($TxtEuro=='')
				$TxtEuro=0;
			$Insertar="insert into pcip_eva_premios(corr,cod_tipo_analisis,cod_unidad,cod_tipo,valor,euro)values(";
			$Insertar.="'".$Cod."','".$CodTipoAnalisis."','".$CmbUnidad8."','".$CmbPremios."','".str_replace(',','.',$TxtValor8)."','".str_replace(',','.',$TxtEuroPre)."')";
			//echo $Insertar;
			mysql_query($Insertar);
			$Mensaje='Datos Grabados Exitosamente';
			$Petalo=RetornaPetalo($CodTipoAnalisis);
			header('location:pcip_evaluacion_negocio_proceso.php?Opc=M&Cod='.$Cod.'&Mensaje='.$Mensaje.'&Ptl='.$Petalo.'&MostrarPrem=S');			
			break;	
		case "EVEPREM"://ELIMINAR VENTA PREMIO
			$Datos=explode('~',$Valores);
			$Eliminar="delete from pcip_eva_premios where corr='".$Datos[0]."' and cod_tipo_analisis='".$CodTipoAnalisis."' and cod_tipo='".$Datos[1]."'";
			//echo $Insertar;
			mysql_query($Eliminar);
			$Mensaje='Datos Eliminado Exitosamente';
			$Petalo=RetornaPetalo($CodTipoAnalisis);
			header('location:pcip_evaluacion_negocio_proceso.php?Opc=M&Cod='.$Cod.'&Mensaje='.$Mensaje.'&Ptl='.$Petalo.'&MostrarPrem=S');			
			break;	
		case "NVETRANS"://AGREGAR VENTA TRANSPORTE
			if($TxtValor5=='')
				$TxtValor5=0;
			if($CmbMaterial=='2')
			{		
				$Insertar="insert into pcip_eva_negocios_transporte(corr,cod_tipo_analisis,cod_unidad,cod_origen_destino,cod_proceso_previo,valor,cod_ley)values(";
				$Insertar.="'".$Cod."','".$CodTipoAnalisis."','".$CmbUnidad5."','".$CmbOrigenDestinoTrans."','0','".str_replace(',','.',$TxtValor5)."','".$CmbLey."')";
				//echo $Insertar;
				mysql_query($Insertar);
				$Mensaje='Datos Grabados Exitosamente';
			}
			else
			{
				$Insertar="insert into pcip_eva_negocios_transporte(corr,cod_tipo_analisis,cod_unidad,cod_origen_destino,cod_proceso_previo,valor,cod_ley)values(";
				$Insertar.="'".$Cod."','".$CodTipoAnalisis."','".$CmbUnidad5."','".$CmbOrigenDestinoTrans."','0','".str_replace(',','.',$TxtValor5)."','0')";
				//echo $Insertar;
				mysql_query($Insertar);
				$Mensaje='Datos Grabados Exitosamente';
			}	
			$Petalo=RetornaPetalo($CodTipoAnalisis);
			header('location:pcip_evaluacion_negocio_proceso.php?Opc=M&Cod='.$Cod.'&Mensaje='.$Mensaje.'&Ptl='.$Petalo.'&MostrarTras=S');			
			break;	
		case "EVETRANS"://ELIMINAR VENTA TRANSPORTE
			$Datos=explode('~',$Valores);
			$Eliminar="delete from pcip_eva_negocios_transporte where corr='".$Datos[0]."' and cod_tipo_analisis='".$CodTipoAnalisis."' and cod_origen_destino='".$Datos[1]."' and cod_ley='".$CmbLey."'";
			//echo $Insertar;
			mysql_query($Eliminar);
			$Mensaje='Datos Eliminado Exitosamente';
			$Petalo=RetornaPetalo($CodTipoAnalisis);
			header('location:pcip_evaluacion_negocio_proceso.php?Opc=M&Cod='.$Cod.'&Mensaje='.$Mensaje.'&Ptl='.$Petalo.'&MostrarTras=S');			
			break;	
		case "NVEPRE"://AGREGAR VENTA PRECIO
			if($TxtValor6=='')
				$TxtValor6=0;
			if($TxtValor7=='')
				$TxtValor7=0;
			$TxtValor6=str_replace(',','.',$TxtValor6);
			$TxtValor7=str_replace(',','.',$TxtValor7);
			if($CmbMaterial=='2')	
			{			
				if($CmbDatosBuscar==1)
				{
					if($CmbUnidad6==3)	
						$CmbUnidad6=6;
					if($CmbUnidad6==2)	
						$CmbUnidad6=4;
					if($CmbUnidad6==1)	
						$CmbUnidad6=7;
				}
				$Insertar="insert into pcip_eva_negocios_precios(corr,cod_tipo_analisis,cod_unidad,cod_tipo,valor,valor2,cod_ley,QP)values(";
				$Insertar.="'".$Cod."','".$CodTipoAnalisis."','".$CmbUnidad6."','".$CmbPrecios."','".str_replace(',','.',$TxtValor6)."','".str_replace(',','.',$TxtValor7)."','".$CmbPrecios."','".$CmbQP."')";
				//echo $Insertar;
				mysql_query($Insertar);
				$Mensaje='Datos Grabados Exitosamente';
			}
			else
			{
				$Insertar="insert into pcip_eva_negocios_precios(corr,cod_tipo_analisis,cod_unidad,cod_tipo,valor,valor2,cod_ley)values(";
				$Insertar.="'".$Cod."','".$CodTipoAnalisis."','".$CmbUnidad6."','".$CmbPrecios."','".str_replace(',','.',$TxtValor6)."','".str_replace(',','.',$TxtValor7)."','0')";
				//echo $Insertar;
				mysql_query($Insertar);
				$Mensaje='Datos Grabados Exitosamente';
			}
			$Petalo=RetornaPetalo($CodTipoAnalisis);
			header('location:pcip_evaluacion_negocio_proceso.php?Opc=M&Cod='.$Cod.'&Mensaje='.$Mensaje.'&Ptl='.$Petalo.'&MostrarPre=S');			
			break;	
		case "EVEPRE"://ELIMINAR VENTA PRECIO
			$Datos=explode('~',$Valores);
			$Eliminar="delete from pcip_eva_negocios_precios where corr='".$Datos[0]."' and cod_tipo_analisis='".$CodTipoAnalisis."' and cod_tipo='".$Datos[1]."'";
			//echo $Insertar;
			mysql_query($Eliminar);
			$Mensaje='Datos Eliminado Exitosamente';
			$Petalo=RetornaPetalo($CodTipoAnalisis);
			header('location:pcip_evaluacion_negocio_proceso.php?Opc=M&Cod='.$Cod.'&Mensaje='.$Mensaje.'&Ptl='.$Petalo.'&MostrarPre=S');			
			break;	
	}

function RetornaPetalo($CodAnalisis)
{
	switch(substr($CodAnalisis,0,1))
	{
		case "1":
			$Pet='CO';
			break;
		case "2":
			$Pet='PP';
			break;
		case "3":
			$Pet='VE';
			break;
		case "4":
			$Pet='MA'.substr($CodAnalisis,1);
			break;
	}
	return($Pet);
} 	
?>
