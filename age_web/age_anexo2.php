<?php
	$CodigoDeSistema = 16;
	$CodigoDePantalla = 6;
	include("age_funciones.php");
	include("../principal/conectar_principal.php");
	set_time_limit(1000);
	

	if(isset($_REQUEST["Mostrar"])){
		$Mostrar = $_REQUEST["Mostrar"];
	}else{
		$Mostrar = "";
	}
	if(isset($_REQUEST["Ano"])){
		$Ano = $_REQUEST["Ano"];
	}else{
		$Ano = date("Y");
	}
	if(isset($_REQUEST["Mes"])){
		$Mes = $_REQUEST["Mes"];
	}else{
		$Mes = date("m");
	}

	if(isset($_REQUEST["CmbAno"])){
		$CmbAno = $_REQUEST["CmbAno"];
	}else{
		$CmbAno = "";
	}
	

	$AnoA = date("Y");
	$MesA = date("m");
	$DiaA = date("d");

	if (strlen($MesA)==1)
		$MesA = "0".$MesA;

	

	if ($Mostrar == "S")
	{	
		$FechaIni = $Ano."-".str_pad($Mes,2,'0',STR_PAD_LEFT)."-01";
		$FechaFin = $Ano."-".str_pad($Mes,2,'0',STR_PAD_LEFT)."-31";
		$CodLoteIni=substr($FechaIni,3,1).substr($FechaIni,5,2)."000";
		$CodLoteFin=substr($FechaFin,3,1).substr($FechaFin,5,2)."999";	
		if (strlen($Mes)==1)
			$Mes = "0".$Mes;
		$fechaC = $Ano.$Mes;
		$fechaA = $AnoA.$MesA;
		$FechaMer =$Ano.str_pad($Mes,2,'0',STR_PAD_LEFT);
		$Consulta = "SELECT * FROM age_web.flujos_mes ";
		$Consulta.= " WHERE ano = '".$Ano."' AND mes = '".$Mes."'";
		$Consulta.= " AND bloqueado = '1'";
		$Resp2 = mysqli_query($link, $Consulta);
		//echo $Consulta;
		if (!$Fila2 = mysqli_fetch_array($Resp2))
		{
			//LIMPIA TABLAS FLUJOS_MES
			// Ver si se acortan los tiempos de proceso
			$CreaTmp="CREATE TABLE if not exists age_web.tmp_lotes (lote varchar(10) not null default '',";
			$CreaTmp.="cod_producto varchar(10) not null default '', cod_subproducto varchar(10) not null default '',";
			$CreaTmp.="fecha_recepcion date, rut_proveedor varchar(10) not null default '')";
			mysqli_query($link, $CreaTmp);
			
			$BorraTmp="delete from age_web.tmp_lotes";
			mysqli_query($link, $BorraTmp);
			$Consu = "select distinct t1.lote, t1.cod_producto,t1.cod_subproducto,t2.fecha_recepcion, t1.rut_proveedor";
			$Consu.= " from age_web.lotes t1 inner join age_web.detalle_lotes t2 on t1.lote = t2.lote ";	
			$Consu.= " where t1.lote<>'' ";
			//$Consu.= " and (t1.lote not in('15030008','15030071','15030093','15030110','15030135','15030169','15030202','15030215','15030237','15030261','15030319')) ";
			$Consu.= " and (t1.lote not in('15030011','15030073','15030111','15030139','15030170','15030219','15030264','15030289','15030339','15030398','15030426','15030453')) ";
			$Consu.= " and (t1.estado_lote <>'6'  or (t1.estado_lote='6' and t1.mostrar_lote='S')) ";
			$Consu.= " and (t1.tipo_remuestreo <>'A'  or (t1.tipo_remuestreo='A' and substring(t1.lote,1,3)='".substr($CodLoteIni,0,3)."'))";					
			$Consu.= " and t2.fecha_recepcion between '".$FechaIni."' and '".$FechaFin."'";
			$Consu.= " order by t1.lote ";
			//echo $Consu; 
			$respue=mysqli_query($link, $Consu);
			while($Row=mysqli_fetch_array($respue))
			{
				$InserTmp="INSERT INTO age_web.tmp_lotes (lote,cod_producto,cod_subproducto,fecha_recepcion,rut_proveedor)";
				$InserTmp.=" values ('".$Row["lote"]."','".$Row["cod_producto"]."','".$Row["cod_subproducto"]."','".$Row["fecha_recepcion"]."',";
				$InserTmp.="'".$Row["rut_proveedor"]."')";
				mysqli_query($link, $InserTmp);
			}
			
			// hasta aca

			$Eliminar = "DELETE FROM age_web.flujos_mes where ano='".$Ano."' and mes='".$Mes."'";
			mysqli_query($link, $Eliminar);
			$Consulta = "SELECT distinct t1.flujo  ";
			$Consulta.= " FROM age_web.relaciones t1  ";
			$Consulta.= " WHERE t1.flujo<>'' and t1.flujo<>'0'";
			//$Consulta.= " and t1.flujo='277'";
			$Consulta.= " ORDER BY lpad(flujo,3,'0')";	
			$Resp = mysqli_query($link, $Consulta);	
			//echo $Consulta."<br>";
			while ($Fila = mysqli_fetch_array($Resp))
			{	
				$Flujo=$Fila["flujo"];
				$Consulta = "select cod_producto, cod_subproducto, rut_proveedor,flujo from age_web.relaciones where flujo='".$Fila["flujo"]."'";
				//echo $Consulta."<br>";
				$RespFlujo=mysqli_query($link, $Consulta);
				while ($FilaFlujo=mysqli_fetch_array($RespFlujo))
				{
					/* para optimizar tiempos
					$Consulta = "select distinct t1.lote ";
					$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes t2 on t1.lote = t2.lote ";	
					$Consulta.= " where t1.lote<>'' ";
					$Consulta.= " and (t1.estado_lote <>'6'  or (t1.estado_lote='6' and t1.mostrar_lote='S')) ";
					$Consulta.= " and (t1.tipo_remuestreo <>'A'  or (t1.tipo_remuestreo='A' and substring(t1.lote,1,3)='".substr($CodLoteIni,0,3)."'))";					
					$Consulta.= " and t1.cod_producto = '".$FilaFlujo["cod_producto"]."' ";
					$Consulta.= " and t1.cod_subproducto = '".$FilaFlujo["cod_subproducto"]."' ";
					$Consulta.= " and t2.fecha_recepcion between '".$FechaIni."' and '".$FechaFin."'";
					$Consulta.= " and t1.rut_proveedor = '".$FilaFlujo["rut_proveedor"]."' ";
					$Consulta.= " order by t1.lote ";
					*/
				    $Consulta = "select distinct t1.lote ";
					$Consulta.= " from age_web.tmp_lotes t1 ";	
					$Consulta.= " where t1.lote<>'' ";
					$Consulta.= " and t1.cod_producto = '".$FilaFlujo["cod_producto"]."' ";
					$Consulta.= " and t1.cod_subproducto = '".$FilaFlujo["cod_subproducto"]."' ";
					$Consulta.= " and t1.fecha_recepcion between '".$FechaIni."' and '".$FechaFin."'";
					$Consulta.= " and t1.rut_proveedor = '".$FilaFlujo["rut_proveedor"]."' ";
					$Consulta.= " order by t1.lote ";  //hasta aca
					$RespProv=mysqli_query($link, $Consulta);
					$EncLotes ="";
					while ($FilaProv=mysqli_fetch_array($RespProv))
					{
						//echo "ACA<br>";
						$Consulta = "select * from age_web.lotes where lote='".$FilaProv["lote"]."'";
						$RespLote = mysqli_query($link, $Consulta);
						$FilaLote=mysqli_fetch_array($RespLote);
						$EncLotes='S';
						$FinoCu=0;
						$FinoAg=0;
						$FinoAu=0;
						$PesoSecoLote=0;
						$TotalPesoSecLote=0;
						$PorcMerma=0;$SiMerma=0;$VarMerma=0;$PrvMerma=0;
						$Consulta = "select ifnull(porc,0) as merma, rut_proveedor ";
						$Consulta.=" from age_web.mermas  where cod_producto='".$FilaFlujo["cod_producto"]."' ";						
						$Consulta.= " and cod_subproducto='".$FilaFlujo["cod_subproducto"]."' ";
						$Consulta.=" and ((year(fecha) < '".$Ano."') or (year(fecha) = '".$Ano."' and month(fecha) <= '".$Mes."'))";
						$Consulta.=" order by cod_producto,cod_subproducto,rut_proveedor";
						$RespMerma=mysqli_query($link, $Consulta);
						while ($FilaMerma=mysqli_fetch_array($RespMerma))
						{
							if($FilaMerma["rut_proveedor"]=="")
							{
								$VarMerma = $FilaMerma["merma"];
							}	
							$Consulta2 ="SELECT ifnull(porc,0) as mermas ";
							$Consulta2.=" FROM age_web.mermas  WHERE cod_producto='".$FilaFlujo["cod_producto"]."' ";						
							$Consulta2.=" AND cod_subproducto='".$FilaFlujo["cod_subproducto"]."' ";
							$Consulta2.=" AND rut_proveedor = '".$FilaFlujo["rut_proveedor"]."'";
							$Consulta2.=" AND ((year(fecha) < '".$Ano."') or (year(fecha) = '".$Ano."' and month(fecha) <= '".$Mes."'))";
							$RespM=mysqli_query($link, $Consulta2);
							if($Row=mysqli_fetch_array($RespM))
							{
								$SiMerma=1;
								$PrvMerma = $Row["mermas"];
							}
						}
						if($SiMerma==1)
						{
							$PorcMerma = str_replace(',','.',$PrvMerma);
						}
						else
						{
							$PorcMerma = str_replace(',','.',$VarMerma);
						}
				//echo "hoy a".$FilaFlujo["rut_proveedor"]."--".$SiMerma."--".$PrvMerma."==".$VarMerma;


						$LeyCu=0;$LeyAg=0;$LeyAu=0;					
						$Consulta = "select * from age_web.detalle_lotes where lote='".$FilaProv["lote"]."' order by lote, lpad(recargo,4,'0')";
						$ContRecargos = 1;
						$RespDetLote=mysqli_query($link, $Consulta);
						while ($FilaDetLote = mysqli_fetch_array($RespDetLote))
						{					
							$PorcHum=0;
							$PesoHumedoRec = $FilaDetLote["peso_neto"];
							$Consulta = "select distinct t1.cod_leyes, t1.valor,t1.valor2, t2.cod_unidad, t2.abreviatura as nom_unidad, t2.conversion, t3.abreviatura as nom_ley,t3.nombre_leyes as nombre_ley ";
							$Consulta.= " from age_web.leyes_por_lote t1 left join proyecto_modernizacion.unidades t2 on ";
							$Consulta.= " t1.cod_unidad=t2.cod_unidad left join proyecto_modernizacion.leyes t3 on t1.cod_leyes=t3.cod_leyes";
							$Consulta.= " where t1.lote='".$FilaProv["lote"]."' ";
							if ($ContRecargos==1)
								$Consulta.= " and (t1.recargo='".$FilaDetLote["recargo"]."' or t1.recargo='0')";
							else
								$Consulta.= " and t1.recargo='".$FilaDetLote["recargo"]."'";
							$Consulta.= " and t1.cod_leyes in ('01','02','04','05')";	
							$Consulta.= " order by t1.cod_leyes";
							$RespLeyes = mysqli_query($link, $Consulta);
							while ($FilaLeyes = mysqli_fetch_array($RespLeyes))
							{								
								switch ($FilaLeyes["cod_leyes"])
								{
									case "01":
										$PorcHum = ($FilaLeyes["valor"]+$PorcMerma) * 1;
										break;
									case "02":
										$IncRetalla=0;
										if($FilaLote["peso_retalla"]>0&&$FilaLote["peso_muestra"]>0)
											CalcIncRetalla($FilaLote["lote"],"02",$FilaLeyes["valor"],$FilaLote["peso_retalla"],$FilaLote["peso_muestra"],$IncRetalla,$link);
										$LeyCu = $FilaLeyes["valor"]+$IncRetalla;
										break;
									case "04":
										$IncRetalla=0;
										if($FilaLote["peso_retalla"]>0&&$FilaLote["peso_muestra"]>0)
											CalcIncRetalla($FilaLote["lote"],"04",$FilaLeyes["valor"],$FilaLote["peso_retalla"],$FilaLote["peso_muestra"],$IncRetalla,$link);
										$LeyAg = $FilaLeyes["valor"]+$IncRetalla;
										break;
									case "05":
										$IncRetalla=0;
										if($FilaLote["peso_retalla"]>0&&$FilaLote["peso_muestra"]>0)
											CalcIncRetalla($FilaLote["lote"],"05",$FilaLeyes["valor"],$FilaLote["peso_retalla"],$FilaLote["peso_muestra"],$IncRetalla,$link);
										$LeyAu = $FilaLeyes["valor"]+$IncRetalla;
										break;
								}
							}
							if($PorcHum !=0)
							{
								$PesoSecoRec = $PesoHumedoRec - (($PesoHumedoRec*$PorcHum)/100);
								if($Fila01["recepcion"]=='PMN')
									$TotalPesoSecLote=$TotalPesoSecLote+$PesoSecoRec;
								else
									$TotalPesoSecLote=$TotalPesoSecLote+round($PesoSecoRec);
							}	
							if($PorcHum ==0)
							{
								$PesoSecoRec=$PesoHumedoRec;
								$TotalPesoSecLote=$TotalPesoSecLote+$PesoSecoRec;
							}
							$TotalPesoHumLote=$TotalPesoHumLote+$PesoHumedoRec;
							$ContRecargos++;
						}
						$DecPHum=0;$DecPSeco=0;$DecLeyes=2;$DecFinos=0;
						$EsPlamen=false;
						if($Fila01["recepcion"]=='PMN')
						{
							$EsPlamen=true;
							$DecPHum=2;$DecPSeco=2;$DecLeyes=2;$DecFinos=2;
						}
						$PorcHumLote=0;
						if ($TotalPesoHumLote!=0)
							$PorcHumLote = abs(100 - ($TotalPesoSecLote * 100)/$TotalPesoHumLote);
						$FinoCu=0;$FinoAg=0;$FinoAu=0;
						if($LeyCu!=0)
							$FinoCu=($TotalPesoSecLote * $LeyCu)/100;
						if($LeyAg!=0)	
							$FinoAg=($TotalPesoSecLote * $LeyAg)/1000;
						if($LeyAu!=0)	
							$FinoAu=($TotalPesoSecLote * $LeyAu)/1000;
						$TotalFinoCu = $TotalFinoCu + round($FinoCu);
						$TotalFinoAg = $TotalFinoAg + round($FinoAg);
						$TotalFinoAu = $TotalFinoAu + round($FinoAu);
						$TotalPesoSeco= $TotalPesoSeco + $TotalPesoSecLote;	
						$TotalPesoSecLote=0;
					}
				}
				if($EncLotes=='S')
				{
					//AJUSTES DEL MES		
					$Consulta = "select t1.flujo, t1.cod_producto, t1.cod_subproducto, t1.rut_proveedor, ";
					$Consulta.= " t2.peso_seco, t2.fino_cu, t2.fino_ag, t2.fino_au ";
					$Consulta.= " from age_web.relaciones t1 inner join age_web.ajustes t2 on t1.cod_producto=t2.cod_producto ";
					$Consulta.= " and t1.cod_subproducto=t2.cod_subproducto and t1.rut_proveedor=t2.rut_proveedor ";
					$Consulta.= " where t1.flujo='".$Flujo."' ";
					//$Consulta.= " and t1.cod_producto='".$Prod."' and t1.cod_subproducto='".$SubProd."' and t1.rut_proveedor='".$RutProv."'";
					$Consulta.= " and t2.ano='".$Ano."' and t2.mes='".$Mes."'";			
					$Consulta.= " order by t1.flujo, t1.cod_producto, t1.cod_subproducto, lpad(t1.rut_proveedor,10,0) ";
					$RespAjuste=mysqli_query($link, $Consulta);
					while ($FilaAjuste=mysqli_fetch_array($RespAjuste))
					{
						$TotalPesoSeco = $TotalPesoSeco + $FilaAjuste["peso_seco"];	
						$TotalFinoCu = $TotalFinoCu + $FilaAjuste["fino_cu"];
						$TotalFinoAg = $TotalFinoAg + $FilaAjuste["fino_ag"];
						$TotalFinoAu = $TotalFinoAu + $FilaAjuste["fino_au"];
					}
					//GRABA DATOS EN FLUJO MES
					//echo "FLUJO:".$Flujo."<br>";
					if ($Flujo!="0" && $Flujo!="" && !is_null($Flujo) && $Flujo!="S" )
					{
						$Insertar = "INSERT INTO age_web.flujos_mes(ano, mes, flujo, peso, fino_cu, fino_ag, fino_au)";
						$Insertar.= " values('".$Ano."','".$Mes."','".$Flujo."','".$TotalPesoSeco."','".$TotalFinoCu."','".$TotalFinoAg."','".$TotalFinoAu."')";
						mysqli_query($link, $Insertar);
						$TotalPesoSeco=0;$TotalFinoCu=0;$TotalFinoAg=0;$TotalFinoAu=0;
						//echo $Insertar."<br>";
					}
					$TotalPesoSeco=0;$TotalFinoCu=0;$TotalFinoAg=0;$TotalFinoAu=0;$TotalPesoSecLote=0;
				}	
			}//FIN WHILE DE FLUJOS						
			//ELIMINA LOS DATOS DE AGENCIA QUE HABIAN PREVIAMENTE EN EL RAM
			$Eliminar = "delete from ram_web.leyes_agencia where ano='".$Ano."' and mes='".str_pad($Mes,2,"0",STR_PAD_LEFT)."' ";
			mysqli_query($link, $Eliminar);
			$PesoHumedoRec=0;$TotalPesoHumLote=0;
			$Consulta = "select cod_producto, cod_subproducto, rut_proveedor ";
			$Consulta.= " from age_web.relaciones where flujo<>'' and flujo<>'0' order by lpad(rut_proveedor,10,'0')";
			$RespFlujo=mysqli_query($link, $Consulta);
			while ($FilaFlujo=mysqli_fetch_array($RespFlujo))
			{
				$FinoCu=0;$FinoAg=0;$FinoAu=0;$PesoSecoProv=0;$TipoRecep="";
				$RutProv=$FilaFlujo["rut_proveedor"];
				$Prod=$FilaFlujo["cod_producto"];
				$SubProd=$FilaFlujo["cod_subproducto"];
				$Consulta = "select distinct t1.lote, t2.recargo, t1.rut_proveedor, t2.peso_neto as peso_hum,  ";
				$Consulta.= " lpad(t2.recargo,2,'0') as orden, t2.fecha_recepcion, tipo_remuestreo,canjeable,cod_producto,cod_subproducto,peso_retalla,peso_muestra ";		
				$Consulta.= " from age_web.lotes t1 inner join age_web.detalle_lotes  t2 ";
				$Consulta.= " on t1.lote = t2.lote ";

				//$Consulta.= " and (t1.lote not in('15030008','15030071','15030093','15030110','15030135','15030169','15030202','15030215','15030237','15030261','15030319')) ";
				$Consulta.= " and (t1.lote not in('15030011','15030073','15030111','15030139','15030170','15030219','15030264','15030289','15030339','15030398','15030426','15030453')) ";
				
				$Consulta.= " where t2.observacion <>'Ingresado x Abastecimiento' and t1.cod_producto = '".$Prod."' ";
				$Consulta.= " and t1.cod_subproducto = '".$SubProd."' ";
				$Consulta.= " and ((t2.fecha_recepcion between '".$FechaIni."' and '".$FechaFin."' ";
				if($CmbAno=='2005')
				{	
					$Consulta.= " AND left(num_lote_remuestreo,3) in ('".substr($Ano,3,1).str_pad($Mes,2,'0',STR_PAD_LEFT)."',''))";
					$Consulta.= " or (tipo_remuestreo='A' AND left(num_lote_remuestreo,3)='".substr($CmbAno,3,1).str_pad($Mes,2,'0',STR_PAD_LEFT)."'))";
				}
				else
				{	
					$Consulta.= " AND left(num_lote_remuestreo,4) in ('".substr($Ano,2,2).str_pad($Mes,2,'0',STR_PAD_LEFT)."',''))";
					$Consulta.= " or (tipo_remuestreo='A' AND left(num_lote_remuestreo,4)='".substr($Ano,2,2).str_pad($Mes,2,'0',STR_PAD_LEFT)."'))";	
				}	
				$Consulta.= " and t1.rut_proveedor = '".$RutProv."' ";
				$Consulta.= " and t1.estado_lote <>'6' group by t1.lote order by t1.lote, orden";
				$RespLote = mysqli_query($link, $Consulta);
				//echo $Consulta."<br>";
				$Ajuste='N';
				$PorcMerma=0;$SiMerma=0;$VarMerma=0;$PrvMerma=0;
				$TotalPesoHumPrv=0;$TotalPesoSecPrv=0;$TotalFinoCuPrv=0;$TotalFinoAgPrv=0;$TotalFinoAuPrv=0;
				while($FilaLote=mysqli_fetch_array($RespLote))
				{

					$Siesta=0;
					$Porce1=0;
					$Porce2=0;
					$Consulta = "select * from age_web.mermas ";
					$Consulta.= " where cod_producto='".$FilaLote["cod_producto"]."' ";
					$Consulta.= " and cod_subproducto='".$FilaLote["cod_subproducto"]."' ";
					$Consulta.=" and ((year(fecha) < '".$Ano."') or (year(fecha) = '".$Ano."' and month(fecha) <= '".$Mes."'))";
					$RespMerma=mysqli_query($link, $Consulta);
					if($FilaMerma=mysqli_fetch_array($RespMerma))
					{
						$Porce1=str_replace(',','.',$FilaMerma["porc"]);
						$Consulta2 = "select * from age_web.mermas ";
						$Consulta2.= " where cod_producto='".$FilaMerma["cod_producto"]."' ";
						$Consulta2.= " and cod_subproducto='".$FilaMerma["cod_subproducto"]."' ";
						$Consulta2.=" and ((year(fecha) < '".$Ano."') or (year(fecha) = '".$Ano."' and month(fecha) <= '".$Mes."'))";
						$RespM=mysqli_query($link, $Consulta2);
						while($FilaM=mysqli_fetch_array($RespM))
						{
							if ($FilaM["rut_proveedor"]==$RutProv)
							{
								$Siesta=1;
								$Porce2=$FilaM["porc"];
							}
						}
					}
					if ($Siesta==1)
						$PorcMerma=$Porce2;
						else
						$PorcMerma=$Porce1;

						
						
					//echo "hoy".$RutProv."--".$PrvMerma."==".$VarMerma;
					$LeyCu=0;$LeyAg=0;$LeyAu=0;$LeyCuOri=0;$LeyAgOri=0;$LeyAuOri=0;$LeyCuAj=0;$LeyAgAj=0;$LeyAuAj=0;						
					$Consulta = "select * from age_web.detalle_lotes where lote='".$FilaLote["lote"]."' order by lote, lpad(recargo,4,'0')";
					//echo $Consulta."<br>";
					$ContRecargos = 1;
					//$TotalPesoHumPrv=0;//WSO
					//$TotalPesoSecPrv=0;//WSO
					$RespDetLote=mysqli_query($link, $Consulta);
					while ($FilaDetLote = mysqli_fetch_array($RespDetLote))
					{					
						$PorcHum=0;
						$PesoHumedoRec = $FilaDetLote["peso_neto"];
						$Consulta = "select distinct t1.cod_leyes, t1.valor,t1.valor2, t2.cod_unidad, t2.abreviatura as nom_unidad, t2.conversion, t3.abreviatura as nom_ley,t3.nombre_leyes as nombre_ley ";
						$Consulta.= " from age_web.leyes_por_lote t1 left join proyecto_modernizacion.unidades t2 on ";
						$Consulta.= " t1.cod_unidad=t2.cod_unidad left join proyecto_modernizacion.leyes t3 on t1.cod_leyes=t3.cod_leyes";
						$Consulta.= " where t1.lote='".$FilaLote["lote"]."' ";
						if ($ContRecargos==1)
							$Consulta.= " and (t1.recargo='".$FilaDetLote["recargo"]."' or t1.recargo='0')";
						else
							$Consulta.= " and t1.recargo='".$FilaDetLote["recargo"]."'";
						$Consulta.= " and t1.cod_leyes in('01','02','04','05')";	
						$Consulta.= " order by t1.cod_leyes";
						//echo $Consulta."<br>";
						$RespLeyes = mysqli_query($link, $Consulta);
						while ($FilaLeyes = mysqli_fetch_array($RespLeyes))
						{								
							switch ($FilaLeyes["cod_leyes"])
							{
								case "01":
									$PorcHum = ($FilaLeyes["valor"]+$PorcMerma) * 1; 
									break;
								case "02":
									$IncRetalla=0;
									if($FilaLote["peso_retalla"]>0&&$FilaLote["peso_muestra"]>0)
										CalcIncRetalla($FilaLote["lote"],"02",$FilaLeyes["valor"],$FilaLote["peso_retalla"],$FilaLote["peso_muestra"],$IncRetalla,$link);
									$LeyCu = $FilaLeyes["valor"]+$IncRetalla;
									$LeyCuOri = $FilaLeyes["valor"]+$IncRetalla;
									break;
								case "04":
									$IncRetalla=0;
									if($FilaLote["peso_retalla"]>0&&$FilaLote["peso_muestra"]>0)
										CalcIncRetalla($FilaLote["lote"],"04",$FilaLeyes["valor"],$FilaLote["peso_retalla"],$FilaLote["peso_muestra"],$IncRetalla,$link);
									$LeyAg = $FilaLeyes["valor"]+$IncRetalla;
									$LeyAgOri = $FilaLeyes["valor"]+$IncRetalla;
									break;
								case "05":
									$IncRetalla=0;
									if($FilaLote["peso_retalla"]>0&&$FilaLote["peso_muestra"]>0)
										CalcIncRetalla($FilaLote["lote"],"05",$FilaLeyes["valor"],$FilaLote["peso_retalla"],$FilaLote["peso_muestra"],$IncRetalla,$link);
									$LeyAu = $FilaLeyes["valor"]+$IncRetalla;
									$LeyAuOri = $FilaLeyes["valor"]+$IncRetalla;
									break;
							}
						}
						if($PorcHum!=0)
						{
							$PesoSecoRec = $PesoHumedoRec - ($PesoHumedoRec*$PorcHum)/100;
							$TotalPesoSecLote=$TotalPesoSecLote+round($PesoSecoRec);
						}	
						if ($PorcHum==0)
						{
							$PesoSecoRec=$PesoHumedoRec;
							$TotalPesoSecLote=$TotalPesoSecLote+$PesoSecoRec;
						}	
						$TotalPesoHumLote=$TotalPesoHumLote+$PesoHumedoRec;
						$ContRecargos++;
					}
					$PorcHumLote=0;
					if ($TotalPesoHumLote!=0)
						$PorcHumLote = abs(100 - ($TotalPesoSecLote * 100)/$TotalPesoHumLote);
					$FinoCu=0;$FinoAg=0;$FinoAu=0;$FinoCuAj=0;$FinoAgAj=0;$FinoAuAj=0;$FinoCuAux=0;
					if($LeyCu!=0)
						$FinoCu=($TotalPesoSecLote * $LeyCuOri)/100;
					if($LeyAg!=0)	
						$FinoAg=($TotalPesoSecLote * $LeyAgOri)/1000;
					if($LeyAu!=0)	
						$FinoAu=($TotalPesoSecLote * $LeyAuOri)/1000;
					$TotalPesoHumPrv=$TotalPesoHumPrv+$TotalPesoHumLote;
					$TotalPesoSecPrv=$TotalPesoSecPrv+$TotalPesoSecLote;
					$TotalFinoCuPrv=$TotalFinoCuPrv+round($FinoCu);
					$TotalFinoAgPrv=$TotalFinoAgPrv+round($FinoAg);
					$TotalFinoAuPrv=$TotalFinoAuPrv+round($FinoAu);
					$TotalPesoHumLote=0;$TotalPesoSecLote=0;
				}
				//TOTAL PROVEEDOR
				$PorcHumPrv=0;
				if (intval($TotalPesoHumPrv)!=0&&intval($TotalPesoSecPrv)!=0)
					$PorcHumPrv=100-($TotalPesoSecPrv*100)/$TotalPesoHumPrv;
				$LeyCuPrv=0;$LeyAgPrv=0;$LeyAuPrv=0;	
				if (intval($TotalPesoSecPrv)!=0)
				{	
					$LeyCuPrv=($TotalFinoCuPrv*100)/$TotalPesoSecPrv;
					$LeyAgPrv=($TotalFinoAgPrv*1000)/$TotalPesoSecPrv;
					$LeyAuPrv=($TotalFinoAuPrv*1000)/$TotalPesoSecPrv;
					$Insertar = "INSERT INTO ram_web.leyes_agencia(ano, mes,  vended, trecep, ph, pseco, fin_cu, fin_ag, fin_au) ";
					$Insertar.= " VALUES('".$Ano."', '".str_pad($Mes,2,"0",STR_PAD_LEFT)."', '".str_pad($RutProv,10,'0',STR_PAD_LEFT)."', '".str_pad($SubProd,2,"0",STR_PAD_LEFT)."',";
					$Insertar.= " '".$TotalPesoHumPrv."', '".$TotalPesoSecPrv."', '".$LeyCuPrv."', '".$LeyAgPrv."' , '".$LeyAuPrv."')";
					//echo $Insertar."<br>";
					
					if ($fechaA >  $fechaC)
						mysqli_query($link, $Insertar);
				}	
				//$TotalPesoHumPrv=0;$TotalPesoSecPrv=0;$TotalFinoCuPrv=0;$TotalFinoAgPrv=0;$TotalFinoAuPrv=0;
			}
		}//FIN DE BLOQUEADO		
	}//FIN MOSTRAR ="S"
	
?>
<html>
<head>
<title>AGE-Anexo Agencia</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "AM":
			var Pag = "../principal/abrir_mes_anexo.php?Sistema=AGE&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value;
			window.open(Pag,"","top=200,left=175,width=409,height=210,scrollbars=no,resizable = no");	
			break;
		case "CM":
			var msg = confirm("¿Esta seguro que desea guardar esta version del Anexo.AGE?");
			if (msg)
			{
				f.action = "age_anexo01.php?Proceso=G&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value;
				f.submit();
			}
			else
			{
				return;
			}
			break;
		case "S":
			f.action = "../principal/sistemas_usuario.php?CodSistema=16&Nivel=0";
			f.submit();
			break;
		case "I":
			window.print();
			break;
		case "E":
			f.action = "age_anexo_excel2.php?Mostrar=S&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value;
			f.submit(); 
			break;
		case "C":
			f.action = "age_anexo2.php?Mostrar=S";
			f.submit(); 
			break;
	}	
}
function Detalle(flu)
{
	var f = frmPrincipal;		
	window.open("age_anexo_det_flujo2.php?Flujo=" + flu + "&Ano=" + f.Ano.value + "&Mes=" + f.Mes.value,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}
</script></head>

<body leftmargin="3" topmargin="5">
<form name="frmPrincipal" action="" method="post">
<?php include("../principal/encabezado.php") ?>
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td width="762" height="313" align="center" valign="top"><table width="650" border="1" cellspacing="0" cellpadding="3" class="TablaInterior">
        <tr align="center">
          <td height="23" colspan="4" class="ColorTabla02"><strong>ANEXO DE AGENCIA  V-1</strong></td>
        </tr>
        <tr>
          <td width="92" height="23">Mes Anexo</td>
          <td width="166">
            <select name="Mes">
              <?php
			$Meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");				
		 	for($i=1;$i<=12;$i++)
		  	{
				if (!isset($Mes))
				{
					if ($i == date("n"))
						echo "<option selected value ='".$i."'>".$Meses[$i-1]." </option>";
					else	
						echo "<option value ='".$i."'>".$Meses[$i-1]." </option>";
				}
				else
				{
					if ($i == $Mes)
						echo "<option selected value ='".$i."'>".$Meses[$i-1]." </option>";
					else	
						echo "<option value ='".$i."'>".$Meses[$i-1]." </option>";						
				}				
			}		  
		?>
            </select>
            <select name="Ano" size="1">
              <?php
			for ($i=date("Y")-3;$i<=date("Y")+1;$i++)
			{
				if (!isset($Ano))
				{
					if ($i == date("Y"))
						echo "<option selected value ='".$i."'>".$i." </option>";
					else	
						echo "<option value ='".$i."'>".$i." </option>";
				}
				else
				{
					if ($i == $Ano)
						echo "<option selected value ='".$i."'>".$i." </option>";
					else	
						echo "<option value ='".$i."'>".$i." </option>";						
				}				
			}		
		?>
            </select>
          </td>
          <td align="right">Cierre Parcial:</td>
          <td width="183">
            <?php
	//CONSULTO SI SE CERRO DEFINITIVO EL MES
	$Consulta = "select estado, fecha_cierre from proyecto_modernizacion.cierre_mes";
	$Consulta.= " where cod_sistema='15' ";
	$Consulta.= " and ano='".$Ano."' and mes='".$Mes."' and cod_bloqueo='1' and fecha_cierre = (";
	$Consulta.= " select max(fecha_cierre) from proyecto_modernizacion.cierre_mes";
	$Consulta.= " where cod_sistema='15' ";
	$Consulta.= " and ano='".$Ano."' and mes='".$Mes."' and cod_bloqueo='1')";
	//echo $Consulta;
	$Resp = mysqli_query($link, $Consulta);
	$CierreBalance = false;	
	if ($Fila = mysqli_fetch_array($Resp))
	{
		if ($Fila["estado"]=="C")
		{
			$CierreBalance = true;
			echo "<img src='../principal/imagenes/cand_cerrado.gif'>&nbsp;".$Fila["fecha_cierre"];
		}
		else
			echo "<img src='../principal/imagenes/cand_abierto.gif'>";
	}
	else
	{
		echo "<img src='../principal/imagenes/cand_abierto.gif'>";
	}
?></td>
        </tr>
        <tr>
          <td height="23">&nbsp;</td>
          <td height="23">&nbsp;</td>
          <td height="23" align="right">Cierre General:</td>
          <td height="23"><?php
	//CONSULTO SI SE CERRO DEFINITIVO EL MES
	$Consulta = "select estado, fecha_cierre from proyecto_modernizacion.cierre_mes";
	$Consulta.= " where cod_sistema='15' ";
	$Consulta.= " and ano='".$Ano."' and mes='".$Mes."' and cod_bloqueo='2' and fecha_cierre = (";
	$Consulta.= " select max(fecha_cierre) from proyecto_modernizacion.cierre_mes";
	$Consulta.= " where cod_sistema='15' ";
	$Consulta.= " and ano='".$Ano."' and mes='".$Mes."' and cod_bloqueo='2')";
	$Resp = mysqli_query($link, $Consulta);
	$CierreBalance = false;	
	if ($Fila = mysqli_fetch_array($Resp))
	{
		if ($Fila["estado"]=="C")
		{
			$CierreBalance = true;
			echo "<img src='../principal/imagenes/cand_cerrado.gif'>&nbsp;".$Fila["fecha_cierre"];
		}
		else
			echo "<img src='../principal/imagenes/cand_abierto.gif'>";
	}
	else
	{
		echo "<img src='../principal/imagenes/cand_abierto.gif'>";
	}
?></td>
        </tr>
        <tr align="center">
          <td height="23" colspan="4"><input name="btnconsultar" type="button" value="Consultar" onClick="Proceso('C')" style="width:70px;">
              <input name="BtnImprimir" type="button" id="BtnImprimir" style="width:70px;" onClick="Proceso('I')" value="Imprimir">
              <?php
	if ($Mostrar == "S")
	{		
        echo "<input name='BtnExcel' type='button' style='width:70px;' onClick=\"Proceso('E')\" value='Excel'>\n";
	}
	//Consulto si las existencias del mes estab bloqueadas
	$Consulta = "SELECT count(ifnull(bloqueado,0)) AS valor FROM age_web.flujos_mes ";
	$Consulta.= " WHERE ano = '".$Ano."' AND mes = '".$Mes."' AND bloqueado = '1'";    
	$Respuesta = mysqli_query($link, $Consulta);
	$Fila = mysqli_fetch_array($Respuesta);
	if ($Fila["valor"] == "0")
	{
        echo "<input name='BrnCerrar' type='button' value='Cerrar Mes' style='width:70px;' onClick=\"Proceso('CM')\">";
	}
	else
	{
		if ($CierreBalance == false)
			echo "<input name='BrnAbrir' type='button' value='Abrir Mes' style='width:70px;' onClick=\"Proceso('AM')\">";
	}
?>
              <input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:70px;" onClick="Proceso('S')"></td>
        </tr>
      </table>        <br>
        <br>
        <table width="650" border="1" align="center" cellpadding="2" cellspacing="0">
    <tr align="center" class="ColorTabla01"> 
      <td rowspan="2">Flujo</td>
      <td rowspan="2">Descripcion</td>
      <td rowspan="2">Peso</td>
      <td colspan="3" align="center">Leyes</td>
      <td colspan="3" align="center">Fino</td>
    </tr>
    <tr class="ColorTabla01"> 
      <td align="center">Cu</td>
      <td align="center">Ag</td>
      <td align="center">Au</td>
      <td align="center">Cu</td>
      <td align="center">Ag</td>
      <td align="center">Au</td>
    </tr>
<?php	
if ($Mostrar == "S")
{		
	$Consulta = "SELECT t1.flujo, t2.descripcion, t1.peso, t1.fino_cu, t1.fino_ag, t1.fino_au  ";
	$Consulta.= " FROM age_web.flujos_mes t1 LEFT join proyecto_modernizacion.flujos t2 ";
	$Consulta.= " on t1.flujo = t2.cod_flujo and t2.sistema = 'AGE'";
	$Consulta.= " WHERE t1.flujo<>'0' and t1.ano = ".$Ano." AND t1.mes = ".$Mes;
	$Consulta.= " ORDER BY flujo";	
	//echo $Consulta;
	$Resp = mysqli_query($link, $Consulta);	
	while ($row = mysqli_fetch_array($Resp))
	{			
		if ($row["peso"] != 0 || $row["fino_cu"]!=0 || $row["fino_ag"]!=0 || $row["fino_au"]!=0)
		{
			echo '<tr>';
			echo '<td align="center">'.$row["flujo"].'</td>';
			$Consulta = "select * from proyecto_modernizacion.flujos where sistema='RAM' and cod_flujo='".$row["flujo"]."' ";
			$Resp2 = mysqli_query($link, $Consulta);
			if ($Fila2 = mysqli_fetch_array($Resp2))								
				echo '<td align="left"><a href="JavaScript:Detalle('.$row["flujo"].')">'.strtoupper($Fila2["descripcion"]).'</a></td>';
			else
				echo '<td align="center">&nbsp;</td>';			
			echo '<td align="right">'.number_format($row["peso"],0,',','.').'</td>';
			if ($row["fino_cu"]>0 && $row["peso"]>0)
				echo '<td align="right">'.number_format(($row["fino_cu"] / $row["peso"] * 100),2,',','.').'</td>';
			else
				echo '<td align="right">0</td>';
			if ($row["fino_ag"]>0 && $row["peso"]>0)
				echo '<td align="right">'.number_format(($row["fino_ag"] / $row["peso"] * 1000),0,',','.').'</td>';		
			else
				echo '<td align="right">0</td>';
			if ($row["fino_au"]>0 && $row["peso"]>0)
				echo '<td align="right">'.number_format(($row["fino_au"] / $row["peso"] * 1000),1,',','.').'</td>';	
			else
				echo '<td align="right">0</td>';
			echo '<td align="right">'.number_format($row["fino_cu"],0,',','.').'</td>';
			echo '<td align="right">'.number_format($row["fino_ag"],0,',','.').'</td>';
			echo '<td align="right">'.number_format($row["fino_au"],0,',','.').'</td>';										
			echo '</tr>';
		}
		
	}
}	
//FUNCIONES
function CalcIncRetalla($Lote,$CodLey,$Valor,$PesoRetalla,$PesoMuestra,$IncRetalla,$link)
{	
	$Consulta = "select distinct t1.cod_leyes, t1.valor, t2.abreviatura as nom_unidad, t2.conversion";
	$Consulta.= " from age_web.leyes_por_lote t1 left join proyecto_modernizacion.unidades t2 on ";
	$Consulta.= " t1.cod_unidad=t2.cod_unidad ";
	$Consulta.= " where t1.lote='".$Lote."' ";
	$Consulta.= " and t1.recargo='R' and t1.cod_leyes='".$CodLey."'";	
	//echo $Consulta."<br>";
	$RespLeyes = mysqli_query($link, $Consulta);
	$IncRetalla=0;
	if($FilaLeyes = mysqli_fetch_array($RespLeyes))
	{
		if($FilaLeyes["valor"]>0)
			$IncRetalla=($FilaLeyes["valor"] - $Valor) * ($PesoRetalla/$PesoMuestra);  //VALOR
	}	
}	

?>	
</table>	  
        <br>
      <br></td>
    </tr>
</table>
<?php include ("../principal/pie_pagina.php") ?>   
</form>
</body>
</html>
