<?php
	$CodigoDeSistema=15;
	$CodigoDePantalla=41;
	$TxtFechaCanje=date('Y-m-d');
	include("../principal/conectar_principal.php");
	//$Mostrar='N';
	$Mostrar          = isset($_REQUEST["Mostrar"])?$_REQUEST["Mostrar"]:"N";
	$TxtLote          = isset($_REQUEST["TxtLote"])?$_REQUEST["TxtLote"]:"";
	$CodSubProducto   = isset($_REQUEST["CodSubProducto"])?$_REQUEST["CodSubProducto"]:"";
	$RutProveedor     = isset($_REQUEST["RutProveedor"])?$_REQUEST["RutProveedor"]:"";
	$Calcular         = isset($_REQUEST["Calcular"])?$_REQUEST["Calcular"]:"";
	$Valores          = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	$SeguimientoHVL   = isset($_REQUEST["SeguimientoHVL"])?$_REQUEST["SeguimientoHVL"]:"";
	$CodFaena        = isset($_REQUEST["CodFaena"])?$_REQUEST["CodFaena"]:"";
	$NombreFaena     = isset($_REQUEST["NombreFaena"])?$_REQUEST["NombreFaena"]:"";
	$EstOpe          = isset($_REQUEST["EstOpe"])?$_REQUEST["EstOpe"]:"";
	$Proc            = isset($_REQUEST["Proc"])?$_REQUEST["Proc"]:"";
	$NewRec          = isset($_REQUEST["NewRec"])?$_REQUEST["NewRec"]:"";
	$TipoConsulta    = isset($_REQUEST["TipoConsulta"])?$_REQUEST["TipoConsulta"]:"";
	$EstadoInput     = isset($_REQUEST["EstadoInput"])?$_REQUEST["EstadoInput"]:"";
	$NombreSubProducto  = isset($_REQUEST["NombreSubProducto"])?$_REQUEST["NombreSubProducto"]:"";
	$NombrePrv          = isset($_REQUEST["NombrePrv"])?$_REQUEST["NombrePrv"]:"";
	$CmbPlantLimPart    = isset($_REQUEST["CmbPlantLimPart"])?$_REQUEST["CmbPlantLimPart"]:"";
	$CmbLaboratorios    = isset($_REQUEST["CmbLaboratorios"])?$_REQUEST["CmbLaboratorios"]:"";
	$TieneArb           = isset($_REQUEST["TieneArb"])?$_REQUEST["TieneArb"]:"";	
	$TxtConjunto        = isset($_REQUEST["TxtConjunto"])?$_REQUEST["TxtConjunto"]:"";
	$TxtFechaCanje      = isset($_REQUEST["TxtFechaCanje"])?$_REQUEST["TxtFechaCanje"]:date("Y-m-d");
	$TxtOrdenEnsaye     = isset($_REQUEST["TxtOrdenEnsaye"])?$_REQUEST["TxtOrdenEnsaye"]:"";
	$TxtFechaSolPqts    = isset($_REQUEST["TxtFechaSolPqts"])?$_REQUEST["TxtFechaSolPqts"]:"";
	$ClaseProducto      = isset($_REQUEST["ClaseProducto"])?$_REQUEST["ClaseProducto"]:"";
	$Recepcion          = isset($_REQUEST["Recepcion"])?$_REQUEST["Recepcion"]:"";
	$PesoRetalla        = isset($_REQUEST["PesoRetalla"])?$_REQUEST["PesoRetalla"]:"";
	$PesoMuestra        = isset($_REQUEST["PesoMuestra"])?$_REQUEST["PesoMuestra"]:"";
	$EstadoCierre  = isset($_REQUEST["EstadoCierre"])?$_REQUEST["EstadoCierre"]:"";
	$EsPopup       = isset($_REQUEST["EsPopup"])?$_REQUEST["EsPopup"]:"";	
	$Mensaje       = isset($_REQUEST["Mensaje"])?$_REQUEST["Mensaje"]:"";
	$Habilitado   = isset($_REQUEST["Habilitado"])?$_REQUEST["Habilitado"]:""; 
	if ($TxtLote!="")
	{
		$EstadoInput = "";
		$Consulta ="select t1.fecha_sol_pqts,t1.fecha_canje,t1.canjeable,t1.fin_canje,t1.lote,t1.peso_muestra,t1.peso_retalla,t1.cod_subproducto,t3.descripcion as nom_subproducto,t1.rut_proveedor,t4.NOMPRV_A as nom_prv,t1.num_conjunto,";
		$Consulta.="t1.cod_faena,t5.nommin_a as nom_faena,t6.nombre_subclase as nom_estado_lote,t7.valor_subclase1 as nom_clase_producto,t8.nombre_subclase as nom_recepcion,t1.laboratorio_externo,t1.orden_ensaye ";
		$Consulta.="from age_web.lotes t1 left join ";
		$Consulta.="proyecto_modernizacion.subproducto t3 on t3.cod_producto='1' and t1.cod_subproducto=t3.cod_subproducto left join ";
		$Consulta.="rec_web.proved t4 on t1.rut_proveedor=t4.RUTPRV_A left join ";
		$Consulta.="rec_web.minaprv t5 on t1.cod_faena=t5.codmin_a left join ";
		$Consulta.="proyecto_modernizacion.sub_clase t6 on t6.cod_clase='15003' and t1.estado_lote=t6.cod_subclase left join ";
		$Consulta.="proyecto_modernizacion.sub_clase t7 on t7.cod_clase='15001' and t1.clase_producto=t7.nombre_subclase left join ";
		$Consulta.="proyecto_modernizacion.sub_clase t8 on t8.cod_clase='3104' and t1.cod_recepcion=t8.nombre_subclase ";
		$Consulta.= "where t1.lote = '".$TxtLote."' and t1.estado_lote <>'6'";
		//echo $Consulta;
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Resp))
		{
			//DATOS DEL LOTE
			$Mensaje='';
			if($Fila["canjeable"]!='N')
			{	
				$Mostrar='S';
				$TxtLote = $Fila["lote"];
				$CodSubProducto = $Fila["cod_subproducto"];
				$NombreSubProducto=$Fila["nom_subproducto"];
				$RutProveedor = $Fila["rut_proveedor"];
				$NombrePrv=$Fila["nom_prv"];
				$CodFaena=$Fila["cod_faena"];
				$NombreFaena = $Fila["nom_faena"];
				$Recepcion = $Fila["nom_recepcion"];
				$ClaseProducto = $Fila["nom_clase_producto"];
				$TxtConjunto = $Fila["num_conjunto"];
				$EstadoLote = $Fila["nom_estado_lote"];
				$PesoRetalla=$Fila["peso_retalla"];
				$PesoMuestra=$Fila["peso_muestra"];
				$CmbLaboratorios=$Fila["laboratorio_externo"];
				$TxtOrdenEnsaye=$Fila["orden_ensaye"];
				$TxtFechaCanje=$Fila["fecha_canje"];
				$TxtFechaSolPqts=$Fila["fecha_sol_pqts"];
				//echo "OD:".$TxtOrdenEnsaye;
				//if($TxtOrdenEnsaye==''||$TxtOrdenEnsaye=='ninguno')
				//{
					$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase='15010' and cod_subclase='1'";
					$Resp2=mysqli_query($link, $Consulta);
					$Fila2=mysqli_fetch_array($Resp2);
					//echo $Consulta;
					$TxtOrdenEnsaye=$Fila2["valor_subclase1"];				
				//}	
				if($CmbLaboratorios==''||$CmbLaboratorios=='S')
				{
					$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase='15010' and cod_subclase='2'";
					$Resp2=mysqli_query($link, $Consulta);
					$Fila2=mysqli_fetch_array($Resp2);
					//echo $Consulta;
					$CmbLaboratorios=$Fila2["valor_subclase1"];				
				}
				if($TxtFechaCanje==''||$TxtFechaCanje=='0000-00-00')
				{
					$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase='15010' and cod_subclase='3'";
					$Resp2=mysqli_query($link, $Consulta);
					$Fila2=mysqli_fetch_array($Resp2);
					//echo $Consulta;
					$TxtFechaCanje=$Fila2["valor_subclase1"];				
				}
				if($TxtFechaSolPqts==''||$TxtFechaSolPqts=='0000-00-00')
				{
					$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase='15010' and cod_subclase='4'";
					$Resp2=mysqli_query($link, $Consulta);
					$Fila2=mysqli_fetch_array($Resp2);
					//echo $Consulta;
					$TxtFechaSolPqts=$Fila2["valor_subclase1"];				
				}	
				
				$Habilitado='';
				
				if($Fila["fin_canje"]=='S')
				{
					$EstadoCierre='Lote Cerrado Comercial';
					
					$Habilitado='disabled';
				}	
				else
					$EstadoCierre='';	
				//SE OBTIENE LAS LEYES A CANJEAR DEPENDIENDO DEL PRODUCTO
				$ArrayLeyes=array();
				$EncontroLeyes=true;
				if($EncontroLeyes==true)
				{
					$Leyes="in ('02','04','05')";
					$valorcu = 0;
					$valorag = 0;
					$valorau = 0;
					reset($ArrayLeyes);
					$Consulta="select t1.recargo,t1.cod_leyes,t1.valor,t1.valor2,t1.cod_unidad,t2.abreviatura,t3.abreviatura as nomley from age_web.leyes_por_lote t1 ";
					$Consulta.="left join proyecto_modernizacion.unidades t2 on t1.cod_unidad=t2.cod_unidad left join proyecto_modernizacion.leyes t3 on t1.cod_leyes=t3.cod_leyes ";
					$Consulta.="where lote='$TxtLote' and recargo in ('0','R') and t1.cod_leyes ".$Leyes;
					//echo $Consulta;
					$RespLeyes=mysqli_query($link, $Consulta);
					while($FilaLeyes=mysqli_fetch_array($RespLeyes))
					{
						switch($FilaLeyes["recargo"])
						{
							case "0":
								if ($FilaLeyes["cod_leyes"]=='02') 
										$valorcu = $FilaLeyes["valor"];
								if ($FilaLeyes["cod_leyes"]=='04') 
										$valorag = $FilaLeyes["valor"];
								if ($FilaLeyes["cod_leyes"]=='05') 
										$valorau = $FilaLeyes["valor"];
								$ArrayLeyes[$FilaLeyes["cod_leyes"]][0]=$FilaLeyes["nomley"];
								$ArrayLeyes[$FilaLeyes["cod_leyes"]][1]=$FilaLeyes["abreviatura"];
								$provisional = isset($FilaLeyes["provisional"])?$FilaLeyes["provisional"]:"";
								if($provisional!='N')//CUANDO NO ES VIRTUAL
									$ArrayLeyes[$FilaLeyes["cod_leyes"]][2]=$FilaLeyes["valor"];//VALOR LEY PQTE 1 
								else
									$ArrayLeyes[$FilaLeyes["cod_leyes"]][2]=$FilaLeyes["valor2"];//VALOR LEY PROVISIONAL
								$ArrayLeyes[$FilaLeyes["cod_leyes"]][3]='';//VALOR LEY PQTE 2 
								$ArrayLeyes[$FilaLeyes["cod_leyes"]][4]='';//VALOR LEY PQTE 3 
								$ArrayLeyes[$FilaLeyes["cod_leyes"]][5]='';//VALOR LEY PQTE 4 
								$ArrayLeyes[$FilaLeyes["cod_leyes"]][6]='';//LEY RETALLA
								$ArrayLeyes[$FilaLeyes["cod_leyes"]][7]='';//INCIDENCIA RETALLA
								$ArrayLeyes[$FilaLeyes["cod_leyes"]][8]='';//LEY CANJE
								$ArrayLeyes[$FilaLeyes["cod_leyes"]][9]='';//LEY PAGO
								$ArrayLeyes[$FilaLeyes["cod_leyes"]][10]='1';//NUM PAQUETE
								$ArrayLeyes[$FilaLeyes["cod_leyes"]][11]='';//SEGUIMIENTO DEL CANJE
								$ArrayLeyes[$FilaLeyes["cod_leyes"]][15]=$FilaLeyes["cod_unidad"];//COD_UNIDAD
								break;
							case "R":
								$ArrayLeyes[$FilaLeyes["cod_leyes"]][6]=$FilaLeyes["valor"];
								break;		
						}
					}
	
					//PARA SABER SI ESTE LOTE YA TIENE CANJE GUARDADO
					$Consulta="select * from age_web.leyes_por_lote_canje where lote='$TxtLote'";
					$Respuesta=mysqli_query($link, $Consulta);
					while($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($Fila["cod_leyes"]=='02' && ($Fila["valor1"] != $valorcu) && $valorcu > 0)
						{
							$Fila["valor1"] = $valorcu;
						}
						if ($Fila["cod_leyes"]=='04' && ($Fila["valor1"] != $valorag) && $valorag > 0)
						{
							$Fila["valor1"] = $valorag;
						}
						if ($Fila["cod_leyes"]=='05' && ($Fila["valor1"] != $valorau) && $valorau > 0)
						{
							$Fila["valor1"] = $valorau;
						}
						$ArrayLeyes[$Fila["cod_leyes"]][2]=$Fila["valor1"]*1;//VALOR LEY PQTE 1 
						$ArrayLeyes[$Fila["cod_leyes"]][3]=$Fila["valor2"]*1;//VALOR LEY PQTE 2 
						$ArrayLeyes[$Fila["cod_leyes"]][4]=$Fila["valor3"]*1;//VALOR LEY PQTE 3 		
						$ArrayLeyes[$Fila["cod_leyes"]][4]=$Fila["valor3"]*1;//VALOR LEY PQTE 3 
						$ArrayLeyes[$Fila["cod_leyes"]][5]=$Fila["valor4"]*1;//VALOR LEY PQTE 4 
						$ArrayLeyes[$Fila["cod_leyes"]][6]=$Fila["valor_retalla"]*1;//LEY RETALLA
						$ArrayLeyes[$Fila["cod_leyes"]][7]=$Fila["inc_retalla"]*1;//INCIDENCIA RETALLA
						$ArrayLeyes[$Fila["cod_leyes"]][8]=$Fila["ley_canje"]*1;//LEY CANJE
						$ArrayLeyes[$Fila["cod_leyes"]][9]=($Fila["inc_retalla"]+$Fila["ley_canje"])*1;//LEY PAGO
						$ArrayLeyes[$Fila["cod_leyes"]][10]=$Fila["paquete_canje"]*1;//NUM PAQUETE
						$ArrayLeyes[$Fila["cod_leyes"]][11]=$Fila["observacion"];//SEGUIMIENTO DE LA LEY
						$ArrayLeyes[$Fila["cod_leyes"]][15]=$Fila["cod_unidad"];//COD_UNIDAD
						$ArrayLeyes[$Fila["cod_leyes"]][20]=$Fila["pendiente"];//SI ES ARBITRAL
						$ArrayLeyes[$Fila["cod_leyes"]][30]=$Fila["ley_forzada"];//SI LA LEY 2 ES FORZADA
						$CmbPlantLimPart=$Fila["plantilla_limite"];
					}
					if($CmbPlantLimPart=='')//PLANTILLA POR DEFECTO)
						$CmbPlantLimPart=1;	
				}	
			}
			else
			{	
				$Mensaje='El Lote Ingresado NO es Canjeable';
				$Habilitado='disabled';
			}	
		}
	}
	if($CodSubProducto==17&&$RutProveedor=='1100-2')//SE CALCULA LAS LEYES PONDERADAS DE TODOS LOS LOTES DEL MES PARA VERIFICAR SI ESTAN DETRO O FUERA DEL LIMITE DE PARTICION DE HVL
	{
		$LoteIni=substr($TxtLote,0,4)."0001";
		$LoteFin=substr($TxtLote,0,4)."9999";
		$Consulta ="select lote from age_web.lotes t1 ";
		$Consulta.=" where t1.lote between '".$LoteIni."' and '".$LoteFin."' ";
		$Consulta.=" and t1.cod_producto = '1' and t1.cod_subproducto ='17' and t1.rut_proveedor='1100-2'";
		//echo $Consulta;
		$RespHvl=mysqli_query($link, $Consulta);$LotesSinLeyesEnami='';
		$CantLotesHVL=mysqli_num_rows($RespHvl);
		//echo "CANT.".$CantLotesHVL."<BR>";
		$ContCu=0;$ContAg=0;$ContAu=0;$AcumCu1=0;$AcumCu2=0;$AcumPesoLote=0;
		while($FilaHVL=mysqli_fetch_assoc($RespHvl))
		{
			$Consulta ="select ifnull(sum(peso_neto),0) as peso from age_web.detalle_lotes ";
			$Consulta.=" where lote = '".$FilaHVL["lote"]."' group by lote";
			//echo $Consulta."<br>";
			$RespPesoLoteHvl=mysqli_query($link, $Consulta);
			$FilaPesoLoteHvl=mysqli_fetch_assoc($RespPesoLoteHvl);
			$PesoLote=isset($FilaPesoLoteHvl["peso"])?$FilaPesoLoteHvl["peso"]:0;
			$AcumPesoLote=$AcumPesoLote+$PesoLote;
			$Consulta ="select cod_leyes, valor1, valor2 from age_web.leyes_por_lote_canje ";
			$Consulta.=" where lote = '".$FilaHVL["lote"]."' and valor2<>0";
			//echo $Consulta;
			$RespLeyesHvl=mysqli_query($link, $Consulta);
			$AcumAg1=0;
			$AcumAg2=0;
			$AcumAu1=0;
			$AcumAu2=0;
			while($FilaLeyesHVL=mysqli_fetch_array($RespLeyesHvl))
			{
				switch($FilaLeyesHVL["cod_leyes"])
				{
					case "02":
						$ContCu++;
						$LeyCu1=str_replace(',','.',$FilaLeyesHVL["valor1"]);
						$LeyCu2=str_replace(',','.',$FilaLeyesHVL["valor2"]);
						$AcumCu1=$AcumCu1+round((($PesoLote*$LeyCu1)/100),3);
						$AcumCu2=$AcumCu2+round((($PesoLote*$LeyCu2)/100),3);
					break;	
					case "04":
						$ContAg++;
						$LeyAg1=str_replace(',','.',$FilaLeyesHVL["valor1"]);
						$LeyAg2=str_replace(',','.',$FilaLeyesHVL["valor2"]);
						$AcumAg1=$AcumAg1+round((($PesoLote*$LeyAg1)/1000),3);
						$AcumAg2=$AcumAg2+round((($PesoLote*$LeyAg2)/1000),3);
					break;	
					case "05":
						$LeyAu1=str_replace(',','.',$FilaLeyesHVL["valor1"]);
						$LeyAu2=str_replace(',','.',$FilaLeyesHVL["valor2"]);
						$AcumAu1=$AcumAu1+round((($PesoLote*$LeyAu1)/1000),3);
						$AcumAu2=$AcumAu2+round((($PesoLote*$LeyAu2)/1000),3);
						$ContAu++;
					break;	
				}	
			}
			$Consulta ="select cod_leyes, valor1, valor2 from age_web.leyes_por_lote_canje ";
			$Consulta.=" where lote = '".$FilaHVL["lote"]."' and valor2=0";
			//echo $Consulta;
			$RespLeyesHvl=mysqli_query($link, $Consulta);
			while($FilaLeyesHVL=mysqli_fetch_array($RespLeyesHvl))
			{
				$LotesSinLeyesEnami=$LotesSinLeyesEnami.$FilaHVL["lote"];
				switch($FilaLeyesHVL["cod_leyes"])
				{
					case "02":
						$LotesSinLeyesEnami=$LotesSinLeyesEnami." Ley Cu, ";	
					break;
					case "04":
						$LotesSinLeyesEnami=$LotesSinLeyesEnami." Ley Ag, ";	
					break;
					case "05":
						$LotesSinLeyesEnami=$LotesSinLeyesEnami." Ley Au, ";	
					break;
				}
			}
		}	
		//echo "CantLotesHVL:".($CantLotesHVL*3)."<br>";
		//echo "CantAnalisisHVL:".($ContCu+$ContAg+$ContAu)."<br>";
		$SeguimientoHVL='';
		if(($CantLotesHVL*3)==($ContCu+$ContAg+$ContAu))
		{	
			$AcumCu1=round($AcumCu1);
			$PondCodelcoCu=round(($AcumCu1/$AcumPesoLote)*100,3);
			$AcumCu2=round($AcumCu2);
			$PondEnamiCu=round(($AcumCu2/$AcumPesoLote)*100,3);
			$AcumAg1=round($AcumAg1);
			$PondCodelcoAg=round(($AcumAg1/$AcumPesoLote)*1000,3);
			$AcumAg2=round($AcumAg2);
			$PondEnamiAg=round(($AcumAg2/$AcumPesoLote)*1000,3);
			$AcumAu1=round($AcumAu1);
			$PondCodelcoAu=round(($AcumAu1/$AcumPesoLote)*1000,3);
			$AcumAu2=round($AcumAu2);
			$PondEnamiAu=round(($AcumAu2/$AcumPesoLote)*1000,3);

			//echo "TODAS LEYES INGRESADAS<br>";
			/*echo "Acum Codelco Cu: ".$AcumCu1."<br>";
			echo "Pond Codelco Cu: ".$PondCodelcoCu."<br>";
			echo "Acum Enami Cu: ".$AcumCu2."<br>";
			echo "Pond Enami Cu: ".$PondEnamiCu."<br>";*/
			$DifCu=abs($PondCodelcoCu-$PondEnamiCu);
			$DifAg=abs($PondCodelcoAg-$PondEnamiAg);
			$DifAu=abs($PondCodelcoAu-$PondEnamiAu);
			//echo "Dif Codelco - Enami Cu: ".number_format($DifCu,3,',','')."<br>";
			/*echo "Acum Codelco Ag: ".$AcumAg1."<br>";
			echo "Pond Codelco Ag: ".$PondCodelcoAg."<br>";
			echo "Acum Enami Ag: ".$AcumAg2."<br>";
			echo "Pond Enami Ag: ".$PondEnamiAg."<br>";*/
			//echo "Dif Codelco - Enami Ag: ".number_format($DifAg,3,',','')."<br>";
			/*echo "Acum Codelco Au: ".$AcumAu1."<br>";
			echo "Pond Codelco Ag: ".$PondCodelcoAu."<br>";
			echo "Acum Enami Au: ".$AcumAu2."<br>";
			echo "Pond Enami Au: ".$PondEnamiAu."<br>";*/
			//echo "Dif Codelco - Enami Au: ".number_format($DifAu,3,',','')."<br>";
			$Consulta="select * from age_web.limites_particion where cod_plantilla='$CmbPlantLimPart' and cod_ley='02' and limite_particion >=".$DifCu;
			//echo $Consulta."<br>";
			$Respuesta=mysqli_query($link, $Consulta);$PartibleCu='N';
			if($Fila=mysqli_fetch_array($Respuesta))
				$PartibleCu='S';
			$Consulta="select * from age_web.limites_particion where cod_plantilla='$CmbPlantLimPart' and cod_ley='04' and limite_particion >=".$DifAg;
			//echo $Consulta."<br>";
			$Respuesta=mysqli_query($link, $Consulta);$PartibleAg='N';
			if($Fila=mysqli_fetch_array($Respuesta))
				$PartibleAg='S';
			$Consulta="select * from age_web.limites_particion where cod_plantilla='$CmbPlantLimPart' and cod_ley='05' and limite_particion >=".$DifAu;
			//echo $Consulta."<br>";
			$Respuesta=mysqli_query($link, $Consulta);$PartibleAu='N';
			if($Fila=mysqli_fetch_array($Respuesta))
				$PartibleAu='S';
		}
		else
		{
			$SeguimientoHVL="Faltan Leyes Enami [".($ContCu+$ContAg+$ContAu)."/".($CantLotesHVL*3)."], ";
			$SeguimientoHVL.=$LotesSinLeyesEnami;
		}
	}
	if($Calcular=='S')//CALCULA EL CANJE
	{
		$Datos=explode('//',$Valores);
		foreach($Datos as $c=>$v)
		{
			$Datos2=explode('~~',$v);
			$CodLey   =isset($Datos2[0])?$Datos2[0]:"";
			$NomLey   =isset($Datos2[1])?$Datos2[1]:"";
			$NomUnidad=isset($Datos2[2])?$Datos2[2]:"";
			$Datos23=isset($Datos2[3])?$Datos2[3]:0;
			$Datos24=isset($Datos2[4])?$Datos2[4]:0;
			$Datos25=isset($Datos2[5])?$Datos2[5]:0;
			$Datos26=isset($Datos2[6])?$Datos2[6]:0;
			$Datos27=isset($Datos2[7])?$Datos2[7]:0;
			$Datos28=isset($Datos2[8])?$Datos2[8]:0;
			$Datos29=isset($Datos2[9])?$Datos2[9]:0;
			$Datos210=isset($Datos2[10])?$Datos2[10]:0;
			$Datos211=isset($Datos2[11])?$Datos2[11]:0;
			$Datos215=isset($Datos2[15])?$Datos2[15]:0;

			$ValorLey1=(float)$Datos23*1;
			$ValorLey2=(float)$Datos24*1;
			$ValorLey3=(float)$Datos25*1;
			$ValorLey4=(float)$Datos26*1;
			$ValorLeyR=(float)$Datos27*1;
			$ValorIncR=(float)$Datos28*1;
			$ValorLeyC=(float)$Datos29*1;
			$ValorLeyF=(float)$Datos210*1;
			$NumPqte=$Datos211;
			$ForzarLey2=$Datos215;
			$Seguimiento='';
			switch($NumPqte)
			{
				case "1":
					$ArrayLeyes[$CodLey][0]=$NomLey;
					$ArrayLeyes[$CodLey][1]=$NomUnidad;
					$LeyCanje=$ValorLey1;
					//echo "LEY:".$ValorLeyR."<BR>"; 	
					if($ValorLeyR!=0)
						$IncRetalla=(($ValorLeyR-$LeyCanje)*$PesoRetalla)/$PesoMuestra;
					else
						$IncRetalla=0;
					//echo "INC_RETALLA:".$IncRetalla."<BR>";
					$ArrayLeyes[$CodLey][7]=number_format($IncRetalla,4,',','');//INCIDENCIA RETALLA
					$ArrayLeyes[$CodLey][8]=$LeyCanje;//LEY CANJE
					$ArrayLeyes[$CodLey][9]=number_format($LeyCanje+$IncRetalla,4,',','');
					$ArrayLeyes[$CodLey][10]='1';//NUM_PAQUETE
					$Seguimiento='TOMA LEY DEL PQTE 1<br>';
					break;
				case "2":
					$Entrar=true;
					if($ForzarLey2=='S')
					{
						$ArrayLeyes[$CodLey][0]=$NomLey;
						$ArrayLeyes[$CodLey][1]=$NomUnidad;
						$ArrayLeyes[$CodLey][8]=$ValorLey2;//LEY CANJE
						$ArrayLeyes[$CodLey][9]=number_format($ValorLey2,4,',','');
						$ArrayLeyes[$CodLey][10]='2';//NUM_PAQUETE
						$ArrayLeyes[$CodLey][30]='S';//LEY FORZADA
						$Seguimiento='TOMA LEY DEL PQTE 2<br>';
						$Entrar=false;
					}
					if($Entrar==true)
					{
						$ArrayLeyes[$CodLey][3]=$ValorLey2;//LEY CANJE
						if($CodSubProducto=='17'&&$RutProveedor=='1100-2')//CANJE LEYES ANODOS HVL
						{
							switch($CodLey)
							{
								case "02":
									if($PartibleCu=='S')
									{
										$Seguimiento='LEY CU PARTIBLE ENTRE PQTE1 Y PQTE2 PORQUE LEY POND. DEL CONJ.LOTES DEL MES ES MENOR O IGUAL A LIM.PART<br>';
										$LeyCanje=($ValorLey1+$ValorLey2)/2;
									}
									else
									{
										$Dif=abs($ValorLey1-$ValorLey2);
										$Consulta="select * from age_web.limites_particion where cod_plantilla='$CmbPlantLimPart' and cod_ley='".$CodLey."' and limite_particion >=".$Dif;
										//echo $Consulta."<br>";
										$Respuesta=mysqli_query($link, $Consulta);
										if($Fila=mysqli_fetch_array($Respuesta))
										{
											$Seguimiento='LEY CU PARTIBLE ENTRE PQTE1 Y PQTE2 PORQUE DIF. ES MENOR O IGUAL A LIM.PART<br>';
											$LeyCanje=($ValorLey1+$ValorLey2)/2;
										}
										else
										{
											$Seguimiento='DIFERENCIA ENTRE PQTE1 Y PQTE2 ES MAYOR A LIM.PART, POR LO TANTO ANALISIS ARBITRAL<br>';
											$LeyCanje=0;//LEY CANJE
										}
									}
								break;
								case "04":
									if($PartibleAg=='S')
									{
										$Seguimiento='LEY AG PARTIBLE ENTRE PQTE1 Y PQTE2 PORQUE LEY POND. DEL CONJ.LOTES DEL MES ES MENOR O IGUAL A LIM.PART<br>';
										$LeyCanje=($ValorLey1+$ValorLey2)/2;
									}
									else
									{
										$Dif=abs($ValorLey1-$ValorLey2);
										$Consulta="select * from age_web.limites_particion where cod_plantilla='$CmbPlantLimPart' and cod_ley='".$CodLey."' and limite_particion >=".$Dif;
										//echo $Consulta."<br>";
										$Respuesta=mysqli_query($link, $Consulta);
										if($Fila=mysqli_fetch_array($Respuesta))
										{
											$Seguimiento='LEY AG PARTIBLE ENTRE PQTE1 Y PQTE2 PORQUE DIF. ES MENOR O IGUAL A LIM.PART<br>';
											$LeyCanje=($ValorLey1+$ValorLey2)/2;
										}
										else
										{
											$Seguimiento='DIFERENCIA ENTRE PQTE1 Y PQTE2 ES MAYOR A LIM.PART, POR LO TANTO ANALISIS ARBITRAL<br>';
											$LeyCanje=0;//LEY CANJE
										}
									}
								break;
								case "05":
									//echo "Partible AU:".$PartibleAu;
									if($PartibleAu=='S')
									{
										$Seguimiento='LEY AU PARTIBLE ENTRE PQTE1 Y PQTE2 PORQUE LEY POND. DEL CONJ.LOTES DEL MES ES MENOR O IGUAL A LIM.PART<br>';
										$LeyCanje=($ValorLey1+$ValorLey2)/2;
									}
									else
									{
										$Dif=abs($ValorLey1-$ValorLey2);
										$Consulta="select * from age_web.limites_particion where cod_plantilla='$CmbPlantLimPart' and cod_ley='".$CodLey."' and limite_particion >=".$Dif;
										//echo $Consulta."<br>";
										$Respuesta=mysqli_query($link, $Consulta);
										if($Fila=mysqli_fetch_array($Respuesta))
										{
											$Seguimiento='LEY AU PARTIBLE ENTRE PQTE1 Y PQTE2 PORQUE DIF. ES MENOR O IGUAL A LIM.PART<br>';
											$LeyCanje=($ValorLey1+$ValorLey2)/2;
										}
										else
										{
											$Seguimiento='DIFERENCIA ENTRE PQTE1 Y PQTE2 ES MAYOR A LIM.PART, POR LO TANTO ANALISIS ARBITRAL<br>';
											$LeyCanje=0;//LEY CANJE
										}
									}
								break;

							}
						}
						else
						{
							$Consulta="select * from age_web.limites_particion where cod_plantilla='$CmbPlantLimPart' and cod_ley='$CodLey' and ".$ValorLey1." between rango1 and rango2";
							//echo $Consulta."<br>";
							$Respuesta=mysqli_query($link, $Consulta);
							if(!$Fila=mysqli_fetch_array($Respuesta))
							{
								$Consulta="select * from age_web.limites_particion where cod_plantilla='$CmbPlantLimPart' and cod_ley='$CodLey' and rango1='0' and rango2='0'";
								//echo $Consulta."<br>";
								$Respuesta2=mysqli_query($link, $Consulta);
								$Fila2=mysqli_fetch_array($Respuesta2);
								$limite_particion = isset($Fila2["limite_particion"])?$Fila2["limite_particion"]:0;
								$LimParticion=($ValorLey1*$limite_particion*1)/100;
							}
							else
								$LimParticion=$Fila["limite_particion"]*1;
							$Dif=abs($ValorLey1-$ValorLey2)*1;
							$Seguimiento='TOMA LEY DEL PQTE 2<br>';
							$Seguimiento.='LIMITE PARTICION:'.number_format($LimParticion,4,',','.')."<br>DIFERENCIA(PQTE1-PQTE2):".number_format($Dif,4,',','.')."<br>";
							/*echo "LEY1:".$ValorLey1."<BR>";
							echo "LEY2:".$ValorLey2."<BR>";
							echo "DIFERENCIA ENTRE Ley1-Ley2:".$Dif."<BR>";*/
							//echo "LIM:".$LimParticion."<BR>";
							if((doubleval($Dif+1-1) <= doubleval($LimParticion+1-1))||(intval($Dif*100000)==intval($LimParticion*100000)))
							{
								$LeyCanje=($ValorLey1+$ValorLey2)/2;//LEY CANJE
								$Seguimiento.='DIFERENCIA ENTRE PQTE1 Y PQTE2 ES MENOR O IGUAL A LIM.PART, POR LO TANTO LEY DE CANJE ES PROMEDIO ENTRE PQTE1 Y PQTE2<br>';
							}	
							else
							{
								if($ValorLey1<=$ValorLey2)
								{	
									$LeyCanje=$ValorLey1;//LEY CANJE
									$Seguimiento.='DIFERENCIA ENTRE PQTE1 Y PQTE2 ES MAYOR A LIM.PART Y PQTE1 ES MENOR O IGUAL A PQTE2, POR LO TANTO LEY DE CANJE ES LA LEY DEL PQTE1<br>';
									$Seguimiento.="SIEMPRE Y CUANDO EL VENDEDOR RENUNCIE AL ANALISIS ARBITRAL (LEY PQTE3)";
								}	
								else
								{	
									$LeyCanje=$ValorLey2;//LEY CANJE
									$Seguimiento.='DIFERENCIA ENTRE PQTE1 Y PQTE2 ES MAYOR A LIM.PART Y PQTE1 ES MAYOR A PQTE2, POR LO TANTO LEY DE CANJE ES LA LEY DEL PQTE2<br>';
									$Seguimiento.="SIEMPRE Y CUANDO EL VENDEDOR RENUNCIE AL ANALISIS ARBITRAL (LEY PQTE3)";
								}
							}
						}
						if($ValorLeyR!=0)
							$IncRetalla=(($ValorLeyR-$LeyCanje)*$PesoRetalla)/$PesoMuestra;
						else
							$IncRetalla=0;
						$ArrayLeyes[$CodLey][7]=number_format($IncRetalla,4,',','');//INCIDENCIA RETALLA
						$ArrayLeyes[$CodLey][8]=$LeyCanje;
						$ArrayLeyes[$CodLey][9]=number_format($LeyCanje+$IncRetalla,4,',','');
						$ArrayLeyes[$CodLey][10]='2';//NUM_PAQUETE
					}	
					break;
				case "3":
					$Seguimiento='TOMA LEY DEL PQTE 3<br>';
					$ArrayValorLeyes=array($ValorLey1,$ValorLey2,$ValorLey3);
					sort($ArrayValorLeyes);
					if($CodSubProducto==17&&$RutProveedor=='1100-2')
					{
						if((($ValorLey3<=$ValorLey1)&&($ValorLey3>=$ValorLey2))||(($ValorLey3>=$ValorLey1)&&($ValorLey3<=$ValorLey2)))
						{
							$Dif1=abs($ValorLey3-$ValorLey2)*1;
							$Dif2=abs($ValorLey3-$ValorLey1)*1;
							$Seguimiento='TOMA LEY DEL PROMEDIO ENTRE PQTE 3 Y PQTE 2<br>';
							if(doubleval($Dif1+1-1)<doubleval($Dif2+1-1))
								$LeyCanje=($ValorLey3+$ValorLey2)/2;
							else
							{
								$Seguimiento='TOMA LEY DEL PQTE 3, DIFERENCIA ES LA MISMA ENTRE PQT1 Y PQTE2<br>';
								if(doubleval($Dif1+1-1)==doubleval($Dif2+1-1))
									$LeyCanje=$ValorLey3;
								else
								{
									$Seguimiento='TOMA LEY DEL PROMEDIO ENTRE PQTE 3 Y PQTE 1<br>';
									$LeyCanje=($ValorLey3+$ValorLey1)/2;	
								}
							}
						}
						else
						{
							$Dif1=abs($ValorLey3-$ValorLey2)*1;
							$Dif2=abs($ValorLey3-$ValorLey1)*1;
							$Seguimiento='TOMA LEY DEL PQTE 2 QUE ESTA MAS CERCA DEL PQTE 3<br>';
							//echo "if(".doubleval($Dif1+1-1)."<".doubleval($Dif2+1-1).")<br>"; 
							if(doubleval($Dif1+1-1)<doubleval($Dif2+1-1))
								$LeyCanje=$ValorLey2;
							else
							{
								if(doubleval($Dif1+1-1)==doubleval($Dif2+1-1))
								{
									$Seguimiento='TOMA LEY DEL PQTE 3,DIFERENCIA ES LA MISMA ENTRE PQT1 Y PQTE2<br>';
									$LeyCanje=$ValorLey3;	
								}
								else
								{
									$Seguimiento='TOMA LEY DEL PQTE 1 QUE ESTA MAS CERCA DEL PQTE 3<br>';
									$LeyCanje=$ValorLey1;	
								}
							}
						}
						
					}
					else
					{
						if(($ValorLey3>$ValorLey2)||($ValorLey3<$ValorLey1))
						{
							$Consulta="select * from age_web.limites_particion where cod_plantilla='$CmbPlantLimPart' and cod_ley='$CodLey' and ".$ValorLey1." between rango1 and rango2";
							$Respuesta=mysqli_query($link, $Consulta);
							if(!$Fila=mysqli_fetch_array($Respuesta))
							{
								$Consulta="select * from age_web.limites_particion where cod_plantilla='$CmbPlantLimPart' and cod_ley='$CodLey' and rango1='0' and rango2='0'";
								$Respuesta2=mysqli_query($link, $Consulta);
								$Fila2=mysqli_fetch_array($Respuesta2);
								$LimParticion=($ValorLey1*$Fila2["limite_particion"]*1)/100;
							}
							else
								$LimParticion=$Fila["limite_particion"]*1;
							$Seguimiento.='LIMITE PARTICION:'.number_format($LimParticion,4,',','.')."<br>";
							$Dif1=abs($ValorLey3-$ValorLey2)*1;
							$Dif2=abs($ValorLey3-$ValorLey1)*1;
							if(doubleval($Dif1+1-1)<doubleval($Dif2+1-1))
							{
								if(doubleval($Dif1+1-1) > doubleval($LimParticion+1-1))
									$Seguimiento.='LA DIF.'.number_format($Dif1,4,',','.').' ENTRE LA LEY DEL PQTE3 Y LA MAS PROXIMA ES EL PQTE2. ES MAYOR AL LIM.PARTICION POR LO TANTO SE PUEDE RECURRIR AL PQTE4. EN CASO CONTRARIO <br>';
							}
							else
							{
								if(doubleval($Dif2+1-1) > doubleval($LimParticion+1-1))
									$Seguimiento.='LA DIF.'.number_format($Dif2,4,',','.').' ENTRE LA LEY DEL PQTE3 Y LA MAS PROXIMA ES EL PQTE1. ES MAYOR AL LIM.PARTICION POR LO TANTO SE PUEDE RECURRIR AL PQTE4. EN CASO CONTRARIO <br>';																			
							}						
						}
						$Seguimiento.='LEY ORDENADAS:'.$ArrayValorLeyes[0].' - '.$ArrayValorLeyes[1].' - '.$ArrayValorLeyes[2].'<br>';
						$LeyCanje=$ArrayValorLeyes[1];//LA LEY DEL MEDIO
						$Seguimiento.='LA LEY QUE ESTA AL CENTRO DEL ORDENAMIENTO ES LEY DEL CANJE<BR>';
					}
					$ArrayLeyes[$CodLey][3]=$ValorLey2;//LEY CANJE	1		
					$ArrayLeyes[$CodLey][4]=$ValorLey3;//LEY CANJE	2
					if($ValorLeyR!=0)
						$IncRetalla=(($ValorLeyR-$LeyCanje)*$PesoRetalla)/$PesoMuestra;
					else
						$IncRetalla=0;
					$ArrayLeyes[$CodLey][7]=number_format($IncRetalla,4,',','');//INCIDENCIA RETALLA
					$ArrayLeyes[$CodLey][8]=$LeyCanje;
					$ArrayLeyes[$CodLey][9]=number_format($LeyCanje+$IncRetalla,4,',','');
					$ArrayLeyes[$CodLey][10]='3';//NUM_PAQUETE
					break;
				case "4":
					$Seguimiento='TOMA LEY DEL PQTE 4<br>';
					$ArrayValorLeyes=array($ValorLey1,$ValorLey2,$ValorLey4);
					sort($ArrayValorLeyes);
					if(($ValorLey4>$ValorLey2)||($ValorLey4<$ValorLey1))
					{
						$Consulta="select * from age_web.limites_particion where cod_plantilla='$CmbPlantLimPart' and cod_ley='$CodLey' and ".$ValorLey1." between rango1 and rango2";
						$Respuesta=mysqli_query($link, $Consulta);
						if(!$Fila=mysqli_fetch_array($Respuesta))
						{
							$Consulta="select * from age_web.limites_particion where cod_plantilla='$CmbPlantLimPart' and cod_ley='$CodLey' and rango1='0' and rango2='0'";
							$Respuesta2=mysqli_query($link, $Consulta);
							$Fila2=mysqli_fetch_array($Respuesta2);
							$LimParticion=($ValorLey1*$Fila2["limite_particion"]*1)/100;
						}
						else
							$LimParticion=$Fila["limite_particion"]*1;
						$Seguimiento.='LIMITE PARTICION:'.number_format($LimParticion,4,',','')."<br>";
						$Dif1=abs($ValorLey4-$ValorLey2)*1;
						$Dif2=abs($ValorLey4-$ValorLey1)*1;
						if(doubleval($Dif1+1-1)<doubleval($Dif2+1-1))
						{
							if(doubleval($Dif1+1-1) > doubleval($LimParticion+1-1))
								$Seguimiento.='LA DIF.'.number_format($Dif1,4,',','.').' ENTRE LA LEY DEL PQTE4 Y LA MAS PROXIMA ES EL PQTE2. ES MAYOR AL LIM.PARTICION POR LO TANTO <br>';
						}
						else
						{
							if(doubleval($Dif2+1-1) > doubleval($LimParticion+1-1))
								$Seguimiento.='LA DIF.'.number_format($Dif2,4,',','.').' ENTRE LA LEY DEL PQTE4 Y LA MAS PROXIMA ES EL PQTE1. ES MAYOR AL LIM.PARTICION POR LO TANTO <br>';																			
						}						
					}
					$Seguimiento.='LEY ORDENADAS:'.$ArrayValorLeyes[0].' - '.$ArrayValorLeyes[1].' - '.$ArrayValorLeyes[2].'<br>';
					$LeyCanje=$ArrayValorLeyes[1];//LA LEY DEL MEDIO
					$Seguimiento.='LA LEY QUE ESTA AL CENTRO DEL ORDENAMIENTO ES LEY DEL CANJE<BR>';
					$ArrayLeyes[$CodLey][3]=$ValorLey2;//LEY CANJE 2			
					$ArrayLeyes[$CodLey][4]=$ValorLey3;//LEY CANJE 3
					$ArrayLeyes[$CodLey][5]=$ValorLey4;//LEY CANJE 4
					if($ValorLeyR!=0)
						$IncRetalla=(($ValorLeyR-$LeyCanje)*$PesoRetalla)/$PesoMuestra;
					else
						$IncRetalla=0;
					$ArrayLeyes[$CodLey][7]=number_format($IncRetalla,4,',','');//INCIDENCIA RETALLA
					$ArrayLeyes[$CodLey][8]=$LeyCanje;
					$ArrayLeyes[$CodLey][9]=number_format($LeyCanje+$IncRetalla,4,',','');				
					$ArrayLeyes[$CodLey][10]='4';//NUM_PAQUETE
					break;
			}
			$ArrayLeyes[$CodLey][11]=$Seguimiento;
		}
	}
?>
<html>
<head>
<title>AGE-Adm. Canje Leyes</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<script language="javascript">
var OK;
var OTS = "";
ns4 = (document.layers)? true:false
ie4 = (document.all)? true:false
function muestra(numero) 
{
 	if (ns4){ 
 		eval("document. " + numero + ".visibility = 'show'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'visible'");
			eval("Txt" + numero + ".style.left = 50 ");
		}
	}
}
function oculta(numero) 
{
	if (ns4){ 
 		eval("document. " + numero + ".visibility = hide'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'hidden'");
		}
	}
}
function RecuperarValores()
{
	var Frm = document.frmPrincipal;
	var Valor='';var CodLey='';var NomLey='';var NomUnidad='';var CodUnidad='';var Seguimiento='';var Arbitral='';var LeyCheck='';var CantLeyes='';var Variable3='';var NumPqte='';
	var Forzar='';var Ley1='';var Ley2='';var Ley3='';var Ley4='';var LeyR='';var IncR='';var LeyC='';var LeyF='';
	var CodLab='';var OrdenEnsaye='';var ValLab='N';var ValOrdenEns='N';
	for(i=1;i<Frm.CodLey.length;i++)
	{
		CantLeyes=eval("Frm.Opt"+Frm.CodLey[i].value+".length");
		for(j=0;j<CantLeyes;j++)
		{
			LeyCheck=eval("Frm.Opt"+Frm.CodLey[i].value+"["+j+"].checked");
			if(LeyCheck==true)
			{
				CodLey=Frm.CodLey[i].value
				NomLey=Frm.NomLey[i].value
				NomUnidad=Frm.NomUnidad[i].value
				CodUnidad=Frm.CodUnidad[i].value
				Seguimiento=Frm.Seguimiento[i].value
				Ley1=eval("Frm.Txt"+Frm.CodLey[i].value+"[0].value");
				Ley2=eval("Frm.Txt"+Frm.CodLey[i].value+"[1].value");
				Ley3=eval("Frm.Txt"+Frm.CodLey[i].value+"[2].value");
				Ley4=eval("Frm.Txt"+Frm.CodLey[i].value+"[3].value");
				LeyR=eval("Frm.Txt"+Frm.CodLey[i].value+"[4].value");
				IncR=eval("Frm.Txt"+Frm.CodLey[i].value+"[5].value");
				LeyC=eval("Frm.Txt"+Frm.CodLey[i].value+"[6].value");
				LeyF=eval("Frm.Txt"+Frm.CodLey[i].value+"[7].value");
				NumPqte=eval("Frm.Opt"+Frm.CodLey[i].value+"["+j+"].value");
				Arbitral='N';
				if(Frm.CheckArbitral[i].checked==true)
					Arbitral='S';
				Forzar='N';	
				if(Frm.CheckForzarLey[i].checked==true)
					Forzar='S';
				if(Arbitral=='S')
				{
					if(Frm.CmbLaboratorios.value=='S')
						ValLab='S';
					else
						CodLab=Frm.CmbLaboratorios.value;					
					if(Frm.TxtOrdenEnsaye.value=='')
						ValOrdenEns='S';
					else
						OrdenEnsaye=Frm.TxtOrdenEnsaye.value;		
				}
				Valor=Valor+CodLey+"~~"+NomLey+"~~"+NomUnidad+"~~"+Ley1+"~~"+Ley2+"~~"+Ley3+"~~"+Ley4+"~~"+LeyR+"~~"+IncR+"~~"+LeyC+"~~"+LeyF+"~~"+NumPqte+"~~"+Seguimiento+"~~"+CodUnidad+"~~"+Arbitral+"~~"+Forzar+"~~"+CodLab+"~~"+OrdenEnsaye+"//";
			}	
		}	
	}
	Valor=Valor.substr(0,Valor.length-2);
	if(ValLab=='S')
	{
		Valor='';
		alert('Debe  Seleccionar Laboratorio Externo');
		Frm.CmbLaboratorios.focus();	
	}
	if(ValOrdenEns=='S')
	{
		Valor='';
		alert('Debe Ingresar Orden de Ensaye');
		Frm.TxtOrdenEnsaye.focus();
	}
	return(Valor);
}
function Proceso(opt,opt2)
{
	var f = document.frmPrincipal;
	var Valores='';
	switch (opt)
	{
		case "G"://GRABAR
			Valores=RecuperarValores();
			if(Valores!='')
			{	
				//alert(Valores);
				f.action = "age_adm_canje_leyes01.php?Valores="+Valores+"&Proceso=G";
				f.submit();	
			}
			else
				alert('Valores no Grabados');
			break;
		case "MC"://MODIFICAR CIERRE OPERACIONAL
			if(confirm('Esta seguro de Modificar Cierre Comercial'))
			{
				f.action = "age_adm_canje_leyes01.php?Proceso=MC";
				f.submit();	
			}	
			break;
		case "C"://CALCULAR
			if(f.CmbPlantLimPart.value!='-1')
			{
				Valores=RecuperarValores();
				f.action = "age_adm_canje_leyes.php?Valores="+Valores+"&Calcular=S";
				f.submit();	
			}
			else
			{
				alert('Debe Seleccionar Plantilla de Limite Particion');
				f.CmbPlantLimPart.focus();
			}	
			break;
		case "CMC"://CERRAR MES COMERCIAL
			if(confirm('Esta seguro de Cerrar Mes Comercial'))
			{
				f.action = "age_adm_canje_leyes01.php?Proceso=CMC";
				f.submit();	
			}	
			break;
		case "CL"://CERTIFICADO DE LEYES		
			window.open("age_certificado_leyes.php?Valores="+f.TxtLote.value,"","top=0,left=0,width=770,height=520,scrollbars=yes,resizable = yes");
			break;
		case "CLC_ENM"://CERTIFICADO DE LEYES CANJE ENM		
			window.open("age_certificado_leyes_canje_enm.php?Valores="+f.TxtLote.value,"","top=0,left=0,width=770,height=520,scrollbars=yes,resizable = yes");
			break;
		case "CL_ENM"://CERTIFICADO DE LEYES ENM		
			window.open("age_certificado_leyes_enm.php?Valores="+f.TxtLote.value,"","top=0,left=0,width=770,height=520,scrollbars=yes,resizable = yes");
			break;
		case "CLC"://CERTIFICADO DE LEYES CANJE		
			window.open("age_certificado_leyes_canje.php?Valores="+f.TxtLote.value,"","top=0,left=0,width=770,height=520,scrollbars=yes,resizable = yes");
			break;
		case "MLC"://MANTENEDOR LEYES CANJE				
			window.open("age_leyes_canje_proceso.php","","top=130,left=120,width=550,height=180,scrollbars=no,resizable = no");
			break;
		case "MLP"://MANTENEDOR LIMITE DE PARTICION
			window.open("age_limite_particion_proceso.php?TipoProceso=CANJE","","top=100,left=120,width=770,height=400,scrollbars=yes,resizable = yes");
			break;
		case "MOE"://MANTENEDOR ORDEN DE ENSAYE
			window.open("age_mod_orden_ensaye.php","","top=100,left=120,width=600,height=350,scrollbars=yes,resizable = yes");
			break;
		case "I"://IMPRIMIR			
			if (f.TxtLote.value==""){
				alert("Debe Ingresar Num. Lote");
				f.TxtLote.focus();
				return;}
			Valores=RecuperarValores();	
			window.open("age_adm_canje_leyes_imprimir.php?TxtLote="+f.TxtLote.value+"&Calcular=S&Valores="+Valores,"","top=30,left=2,width=770,heiht=500,scrollbars=yes,resizable=yes");
			break;
		case "E"://EXCEL	
			if (f.TxtLote.value==""){
				alert("Debe Ingresar Num. Lote");
				f.TxtLote.focus();
				return;}
			f.action="age_adm_canje_leyes_excel.php?TxtLote="+f.TxtLote.value+"&Calcular=S&Valores="+Valores;
			f.submit();
			break;		
		case "R"://RECARGA					
			f.action = "age_adm_canje_leyes.php";
			f.submit();
			break
		case "S"://SALIR
			if(opt2=='S')
				window.close();
			else
			{	
				frmPrincipal.action = "../principal/sistemas_usuario.php?CodSistema=15&Nivel=1&CodPantalla=40";
				frmPrincipal.submit();
			}	
			break;			
		case "MT": //MARCA TODO
			var ValorChk = false;
			if (f.ChkMarcaTodo.checked)
				ValorChk = true;
			for (i=1;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="ChkRecargo")
				{
					f.elements[i].checked=ValorChk;
					CCA(f.elements[i],'CL03');
				}
			}
			break;
		case "L":
			if (f.TxtLote.value==""){
				alert("Debe Ingresar Num. Lote");
				f.TxtLote.focus();
				return;}
			window.open("age_adm_lotes_leyes.php?TxtLote="+f.TxtLote.value,"","top=10,left=70,width=550,height=500,scrollbars=yes,resizable=yes");
			break;
		case "ELI"://ELIMINAR REGISTRO DE LA LEYE DE CANJE PARA TOMAR VALORES ORIGINALES
			if(confirm('Esta seguro de eliminar registro canje'))
			{
				//alert(opt2);
				f.action = "age_adm_canje_leyes01.php?Proceso=ELI&CodLeyEli="+opt2;
				f.submit();	
			}
			break;
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style></head>
<body onLoad="window.document.frmPrincipal.TxtLote.focus();">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="frmPrincipal" action="" method="post">
<input type="hidden" name="Proc" value="<?php echo $Proc; ?>">
<input type="hidden" name="NewRec" value="<?php echo $NewRec; ?>">
<input type="hidden" name="TipoConsulta" value="<?php echo $TipoConsulta; ?>">

<?php include("../principal/encabezado.php") ?>
<table class="TablaPrincipal" width="770" height="330" cellpadding="0" cellspacing="0" >
	<tr>
	  <td width="760" height="330" align="center" valign="top"><br>
<table width="1000"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
  <tr class="ColorTabla02">
    <td colspan="4"><strong>INGRESO LOTE CANJE </strong></td>
  </tr>
<?php
	if ($EstOpe != "")
	{  
		switch ($EstOpe)
		{
			case "S":
				$Clase="ErrorSI";
				break;
			case "N":
				$Clase="ErrorNO";
				break;
		}
		echo "<tr class='ColorTabla02'>\n";
    	echo "<td colspan='4' class='Colum01' align='center'><font class='".$Clase."'>".$Mensaje."</font></td>\n";
    	echo "</tr>\n";
	}
?>
  <tr class="Colum01">
    <td width="128" class="Colum01">Lote:</td>
    <td width="282" class="Colum01"><input <?php echo $EstadoInput; ?> name="TxtLote" type="text" class="InputCen" id="TxtLote" value="<?php echo $TxtLote; ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('S',true,this.form,'BtnOK');">
    <input name="BtnOK" type="button" id="BtnOK" value="OK" onClick="Proceso('R')"  onFocus="Proceso('R')">&nbsp;&nbsp;&nbsp;<font color="#FF3300"><strong><?php echo $EstadoCierre;?></strong></font>
    <td width="135" align="right" class="Colum01">Num.Conjunto:</td>
    <td width="178" class="Colum01"><?php if($TxtConjunto!="") echo $TxtConjunto."&nbsp;"; else echo "&nbsp;";?></td>
  </tr>
  <tr class="Colum01">
    <td class="Colum01">SubProducto:</td>
    <td class="Colum01"><?php if($CodSubProducto!="") echo $CodSubProducto." - ".$NombreSubProducto; else echo "&nbsp;";?></td>
    <td align="right" class="Colum01">Clase Producto:</td>
    <td class="Colum01"><?php if($ClaseProducto!="") echo $ClaseProducto; else echo "&nbsp;";?></td>
  </tr>
  <tr class="Colum01">
    <td class="Colum01">Proveedor:</td>
    <td class="Colum01"><?php if($RutProveedor!="") echo $RutProveedor." - ".$NombrePrv; else echo "&nbsp;";?></td>
    <td align="right" class="Colum01">Cod.Recepcion:</td>
    <td class="Colum01"><?php if($Recepcion!="") echo $Recepcion; else echo "&nbsp;";?></td>
  </tr>
  <tr class="Colum01">
    <td class="Colum01">Cod Faena: </td>
    <td class="Colum01"><?php if($CodFaena!="") echo $CodFaena." - ".$NombreFaena; else echo "&nbsp;";?></td>
    <td align="right" class="Colum01">Peso Retalla: </td>
    <td class="Colum01"><?php if($PesoRetalla!="") echo number_format($PesoRetalla,4,',','.')."&nbsp;&nbsp;Grs."; else echo "&nbsp;";?></td>
  </tr>
  <tr class="Colum01">
    <td class="Colum01">Estado Lote:</td>
    <td class="Colum01"><strong><font color="#FF3300"><?php if(isset($EstadoLote)) echo strtoupper($EstadoLote); else echo "&nbsp;";?></font></strong></td>
    <td align="right" class="Colum01">Peso Muestra: </td>
    <td class="Colum01"><?php if($PesoMuestra!="") echo number_format($PesoMuestra,0,',','.')."&nbsp;&nbsp;Grs."; else echo "&nbsp;";?></td>
  </tr>
  <tr class="Colum01">
    <td class="Colum01">Plantilla Lim. Particion</td>
    <td class="Colum01"><select name="CmbPlantLimPart" style="width:180">
      <option value="-1">SELECCIONAR</option>
      <?php
			$Consulta="select distinct cod_plantilla,nombre_plantilla from age_web.limites_particion where proceso='CANJE' order by cod_plantilla";
			$Respuesta=mysqli_query($link, $Consulta);
			while($Fila=mysqli_fetch_array($Respuesta))
			{
				if($CmbPlantLimPart==$Fila["cod_plantilla"])
					echo "<option value='".$Fila["cod_plantilla"]."' selected>".$Fila["nombre_plantilla"]."</option>";
				else
					echo "<option value='".$Fila["cod_plantilla"]."'>".$Fila["nombre_plantilla"]."</option>";
			}
	  ?>
    </select><?php //echo "&nbsp;".$SeguimientoHVL;?></td>
    <td colspan="2" align="right" class="Colum01">
	<input name="BtnCertLeyesCanjeEnm2" type="button" value="Cert. Leyes ENM" style="width:140px " onClick="Proceso('CL_ENM')">
      <input name="BtnCertLeyesCanjeEnm" type="button" value="Cert. Leyes Canje ENM" style="width:140px " onClick="Proceso('CLC_ENM')"></td>
  </tr>
  
	<tr align="center" class="Colum01">
	  <td height="30" colspan="4" class="Colum01">
		<input name="BtnCalcular" type="button" value="Calcular" style="width:70px " onClick="Proceso('C')" <?php echo $Habilitado;?> >
		<!--<input name="BtnLeyesCanje" type="button" value="Mant. Leyes Canje" style="width:140px " onClick="Proceso('MLC')">-->
		<input name="BtnLimites" type="button" value="Mant. Limites Particion" style="width:140px " onClick="Proceso('MLP')">
		<input name="BtnCertLeyes" type="button" value="Cert. de Leyes" style="width:125px " onClick="Proceso('CL')">
		<input name="BtnCertLeyesCanje" type="button" value="Cert. de Leyes Canje" style="width:125px " onClick="Proceso('CLC')">
		<input name="BtnCerrarMes" type="button" value="Cerrar Lote Comercial" style="width:140px " onClick="Proceso('CMC')" <?php echo $Habilitado;?>>
	  </td>
	</tr>
	</table>
	<br>
	<table width="1000"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
	  <tr class="ColorTabla01" align="center">
		<td width="28">Eli</td>
        <td width="28">Ley</td>
		<td width="29">Unid</td>
		<td width="71">Ley 1ra</td>
		<td width="73">Ley 2da</td>
		<td width="5">F</td>
		<td width="71">Ley 3era</td>
		<td width="71">Ley 4ta</td>
		<td width="73">Ley Retalla</td>
		<td width="74">Inc. Retalla</td>
		<td width="72">Ley Canje</td>
		<td width="72">Ley Final</td>
		<td width="42">Arb</td>
	  </tr>
	  <?php
	  if ($Mostrar=='S')
	  {
		  echo "<input type='hidden' name='CodLey'>";
		  echo "<input type='hidden' name='NomLey'>";
		  echo "<input type='hidden' name='NomUnidad'>";
		  echo "<input type='hidden' name='CodUnidad'>";
		  echo "<input type='hidden' name='Seguimiento'>";
		  echo "<input type='hidden' name='TxtLey'>";
		  echo "<input type='hidden' name='OptLey'>";
		  echo "<input type='hidden' name='CheckArbitral'>";
		  echo "<input type='hidden' name='CheckForzarLey'>";
		  $Cont=0;//WSO
		  foreach($ArrayLeyes as $c=>$v)
		  { $v0 = isset($v[0])?$v[0]:"";
			if ($v0!='')
			{
				$Cont++;
				echo "<tr align='left'>";
				echo "<td><input type='button' name='BtnEliminar' value='X' onClick=Proceso('ELI','".$c."') $Habilitado></td>";
				echo "<td onMouseOver='JavaScript:muestra(".$Cont.");' onMouseOut='JavaScript:oculta(".$Cont.");' class='Detalle02'>";
				echo "<div id='Txt".$Cont."' ";
				echo " style=\"FILTER: alpha(opacity=75);  background-color:#fff4cf; VISIBILITY: hidden; WIDTH: 500px; POSITION: absolute; moz-opacity: .75; opacity: .75; border:solid 1px Black\">";
				//echo " style= 'position:Absolute; background-color:#fff4cf; visibility:hidden; border:solid 1px Black;width:500px'>\n";
				echo "<font face='courier' color='#000000' size=1><b>$v[11]<br></b>";
				echo "</div>&nbsp;&nbsp;$v[0]<input type='hidden' name='CodLey' value='$c'><input type='hidden' name='NomLey' value='$v[0]'><input type='hidden' name='NomUnidad' value='$v[1]'><input type='hidden' name='CodUnidad' value='$v[15]'><input type='hidden' name='Seguimiento' value='$v[11]'></td>";
				echo  "<td align='center'>$v[1]</td>";
				$NombreOpt='Opt'.$c;$NombreTxt='Txt'.$c;//$NombreCheck='Check'.$c;
				//INDICA EL NUMERO DE PAQUETE
				switch($v[10]) 
				{
					case "1"://PAQUETE PRIMERO
						$ClaseInput1="style ='background:#66CCFF'";$ClaseInput2="";$ClaseInput3="";$ClaseInput4="";
						$Chekeado1='checked';$Chekeado2='';$Chekeado3='';$Chekeado4='';
						break;
					case "2"://PAQUETE SEGUNDO
					    $ClaseInput1='';$ClaseInput2="style ='background:#66CCFF'";$ClaseInput3="";$ClaseInput4="";
						$Chekeado1='';$Chekeado2='checked';$Chekeado3='';$Chekeado4='';
						break;
					case "3"://PAQUETE TERCERO
					 	$ClaseInput1='';$ClaseInput2='';$ClaseInput3="style ='background:#66CCFF'";$ClaseInput4='';
						$Chekeado1='';$Chekeado2='';$Chekeado3='checked';$Chekeado4='';
						break;
					case "4"://PAQUETE CUARTO
					    $ClaseInput1='';$ClaseInput2='';$ClaseInput3='';$ClaseInput4="style ='background:#66CCFF'";
						$Chekeado1='';$Chekeado2='';$Chekeado3='';$Chekeado4='checked';
						break;
				}
				echo "<td><input type='radio' name='$NombreOpt' value='1' $Chekeado1><input type='text' name='$NombreTxt' size='6' value='$v[2]' class='InputCen' readonly=true></td>";
				echo "<td colspan='2'><input type='radio' name='$NombreOpt' value='2' $Chekeado2><input type='text' name='$NombreTxt' size='6' value='$v[3]' class='InputCen' $ClaseInput2>";
				$v30 = isset($v[30])?$v[30]:"";
				if($v30=='S')
					echo "<input type='checkbox' name='CheckForzarLey' value='' checked></td>";
				else
					echo "<input type='checkbox' name='CheckForzarLey' value=''></td>";
				echo "<td><input type='radio' name='$NombreOpt' value='3' $Chekeado3><input type='text' name='$NombreTxt' size='6' value='$v[4]' class='InputCen' $ClaseInput3></td>";
				echo "<td><input type='radio' name='$NombreOpt' value='4' $Chekeado4><input type='text' name='$NombreTxt' size='6' value='$v[5]' class='InputCen' $ClaseInput4></td>";
				echo "<td><input type='text' name='$NombreTxt' size='10' value='$v[6]' class='InputCen' readonly=true></td>";
				echo "<td><input type='text' name='$NombreTxt' size='10' value='$v[7]' class='InputCen' readonly=true></td>";
				echo "<td><input type='text' name='$NombreTxt' size='10' value='$v[8]' style ='background:#FFFFCC' class='InputCen'></td>";
				echo "<td><input type='text' name='$NombreTxt' size='12' value='$v[9]' style ='background:#FFFF99' class='InputCen'></td>";
				$v20 = isset($v[20])?$v[20]:"";
				if($v20=='S')
				{
					$TieneArb='S';
					echo "<td><input type='checkbox' name='CheckArbitral' size='12' value='' class='InputCen' checked></td>";
				}	
				else
					echo "<td><input type='checkbox' name='CheckArbitral' size='12' value='' class='InputCen'></td>";
				echo "</tr>";
			}	
		  }
	  } 
	  ?>
  	</table><br><br><br>
	<table width="1000"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
	 <tr>
	 <td colspan="3"><strong>Laboratorios Externo</strong></td>
	 <td colspan="7">
	 <select name="CmbLaboratorios" style="width:150">
	 <?php
	 	if($TieneArb=='S')
			echo "<option value='S'>Seleccionar</option>";
		else
			echo "<option value='S'>Ninguno</option>";
		$Consulta="select * from proyecto_modernizacion.sub_clase where cod_clase=15009";
		$RespLab=mysqli_query($link, $Consulta);
		while($FilaLab=mysqli_fetch_array($RespLab))
		{
			if($FilaLab["cod_subclase"]==$CmbLaboratorios)
				echo "<option value='".$FilaLab["cod_subclase"]."' selected>".$FilaLab["nombre_subclase"]."</option>";
			else
				echo "<option value='".$FilaLab["cod_subclase"]."'>".$FilaLab["nombre_subclase"]."</option>";
			
		}
	 ?>
	 </select>
	 (Solo para Arbitral)
	 </td>
	 <td width="94"><strong>Orden de Ensaye</strong></td>
	 <td width="250"><input type="text" name="TxtOrdenEnsaye" value="<?php echo trim($TxtOrdenEnsaye);?>" size="15">&nbsp;
	   <input name="BtnModOrdenEnsaye" type="button" value="Param. Canje" style="width:120px " onClick="Proceso('MOE')"></td>
	 </tr>
	 <tr>
	   <td colspan="3"><strong>Fecha Canje </strong></td>
	   <td colspan="7"><input name="TxtFechaCanje" type="text" class="InputCen" id="TxtFechaCanje" value="<?php echo $TxtFechaCanje; ?>" size="15" maxlength="10" readOnly>
         <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaCanje,TxtFechaCanje,popCal);return false"></td>
	 <td width="94"><strong>Fecha Solic. Pqts.</strong></td>
	 <td width="229">
       <input name="TxtFechaSolPqts" type="text" class="InputCen" value="<?php echo $TxtFechaSolPqts; ?>" size="15" maxlength="10" readOnly>
       <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaSolPqts,TxtFechaSolPqts,popCal);return false"> </td>
	 </tr>
	    
	</table>
	<BR>
	<table width="1000"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
	  <tr>
	  <td  align="center">
		<input name="BtnGrabar" type="button" value="Grabar" style="width:70px " onClick="Proceso('G')" <?php echo $Habilitado;?>>
		<input name="BtnImprimir" type="button" value="Imprimir" style="width:70px " onClick="Proceso('I')">
		<input name="BtnExcel" type="button" value="Excel" style="width:70px " onClick="Proceso('E')">
		<input name="BtnModCierreC" type="button" value="Mod.Cierre Comer." style="width:120px " onClick="Proceso('MC')">
		<input name="BtnSalir" type="button" value="Salir" style="width:70px " onClick="Proceso('S','<?php echo $EsPopup;?>')">
	  </td>
	</table>  
</td>
</tr>
</table>
<?php include("../principal/pie_pagina.php") ?>
</form>
</body>
</html>
<?php
if($Mensaje!='')
{
	echo "<script language='JavaScript'>";
	echo "alert('$Mensaje')";
	echo "</script>";
}
if($Calcular=='S'&&$CodSubProducto==17&&$RutProveedor=='1100-2'&&$SeguimientoHVL!='')
{
	echo "<script language='JavaScript'>";
	echo "alert('".$SeguimientoHVL."')";
	echo "</script>";
}

?>