<?php
	include("../principal/conectar_principal.php");
	include("age_funciones.php");
	include("../principal/funciones/class.ezpdf.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
	if(!isset($CmbAno))
	{
		$CmbAno=date('Y');
		$CmbMes=date('n');
	}
	$pdf =& new Cezpdf('a4');
    $pdf->selectFont('../principal/funciones/fonts/Helvetica.afm');
	$Datos=explode('//',$Valores);
	foreach($Datos as $c => $v)
	{
		$pdf->ezText("<u>CERTIFICADO LEYES CANJE</u>\n",15,array('justification'=>'center'));
		$Lote=$v;
		$Consulta ="select t1.remuestreo,t1.num_lote_remuestreo,t1.lote,t1.peso_muestra,t1.peso_retalla,t1.cod_subproducto,t3.descripcion as nom_subproducto,t1.rut_proveedor,t4.nombre_prv as nom_prv,t1.num_conjunto,";
		$Consulta.="t1.cod_faena,t5.nombre_mina as nom_faena,t5.sierra as sierra ,t6.nombre_subclase as nom_estado_lote,t7.valor_subclase1 as nom_clase_producto,t8.valor_subclase1 as nom_recepcion ";
		$Consulta.="from age_web.lotes t1 left join ";
		$Consulta.="proyecto_modernizacion.subproducto t3 on t3.cod_producto='1' and t1.cod_subproducto=t3.cod_subproducto left join ";
		$Consulta.="sipa_web.proveedores t4 on t1.rut_proveedor=t4.rut_prv left join ";
		$Consulta.="sipa_web.minaprv t5 on t1.rut_proveedor=t5.rut_prv and t1.cod_faena=t5.cod_mina left join ";
		$Consulta.="proyecto_modernizacion.sub_clase t6 on t6.cod_clase='15003' and t1.estado_lote=t6.cod_subclase left join ";
		$Consulta.="proyecto_modernizacion.sub_clase t7 on t7.cod_clase='15001' and t1.clase_producto=t7.nombre_subclase left join ";
		$Consulta.="proyecto_modernizacion.sub_clase t8 on t8.cod_clase='15002' and t1.cod_recepcion=t8.nombre_subclase ";
		$Consulta.= "where t1.lote = '".$Lote."'";
		//echo $Consulta;
		$Resp = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Resp))
		{
			$Lote = $Fila["lote"];
			$CodSubProducto = $Fila["cod_subproducto"];
			$NombreSubProducto=$Fila["nom_subproducto"];
			$RutProveedor = $Fila["rut_proveedor"];
			$NombrePrv=$Fila["nom_prv"];
			$CodFaena=$Fila["cod_faena"];
			$NombreFaena = $Fila["nom_faena"];
			$Sierra = $Fila["sierra"];
			$Recepcion = $Fila["nom_recepcion"];
			$ClaseProducto = $Fila["nom_clase_producto"];
			$TxtConjunto = $Fila["num_conjunto"];
			$EstadoLote = $Fila["nom_estado_lote"];
			$PesoRetalla=$Fila["peso_retalla"];
			$PesoMuestra=$Fila["peso_muestra"];
			if($Fila[remuestreo]=='S')
				$LoteRemuestreo=$Fila[num_lote_remuestreo];
			else
				$LoteRemuestreo='';
			$Consulta="select fecha_recepcion from age_web.detalle_lotes where lote='$Lote' and fin_lote='S'";
			$RespLote=mysqli_query($link, $Consulta);
			$FilaLote=mysqli_fetch_array($RespLote);
			$FechaCierre=$FilaLote["fecha_recepcion"];
			$DatosLote= array();
			$ArrLeyes=array();
			$DatosLote["lote"]=$Lote;
			LeyesLote(&$DatosLote,&$ArrLeyes,"N","S","S","","","");
			$CantDec=0;
			if ($DatosLote["recepcion"]=="PMN")
			{
				$CantDec=4;
				$PesoSecoLote=$DatosLote["peso_seco"];
			}
			else
				$PesoSecoLote=$DatosLote["peso_seco2"];
			$PesoHumLote=$DatosLote["peso_humedo"];
			$Consulta="select t1.recargo,t1.cod_leyes,t1.valor,t1.cod_unidad,t2.abreviatura,t3.abreviatura as nomley from age_web.leyes_por_lote t1 ";
			$Consulta.="left join proyecto_modernizacion.unidades t2 on t1.cod_unidad=t2.cod_unidad left join proyecto_modernizacion.leyes t3 on t1.cod_leyes=t3.cod_leyes ";
			$Consulta.="where lote='$Lote' and recargo='R' and t1.cod_leyes in('02','04','05')";
			$RespLeyes=mysqli_query($link, $Consulta);
			while($FilaLeyes=mysqli_fetch_array($RespLeyes))
			{
				switch($FilaLeyes["cod_leyes"])
				{
					case "02":
						$LeyCu=$FilaLeyes[valor];
						$UnidadCu=$FilaLeyes["abreviatura"];
						break;
					case "04":
						$LeyAg=$FilaLeyes[valor];
						$UnidadAg=$FilaLeyes["abreviatura"];
						break;
					case "05":
						$LeyAu=$FilaLeyes[valor];
						$UnidadAu=$FilaLeyes["abreviatura"];
						break;
				}
			}			
			$pdf->rectangle(0,725, 325,40);
			$pdf->addText(5,750,10,"LABORATORIO",0,0);
			$pdf->addText(100,750,10,":",0,0);
			$pdf->addText(105,750,10,"VENTANAS",0,0);
			$pdf->addText(5,735,10,"AGENCIA",0,0);
			$pdf->addText(100,735,10,":",0,0);	
			$pdf->addText(105,735,10,"VENTANAS",0,0);
			$pdf->rectangle(340,725, 255,40);
			$pdf->addText(345,750,10,"FECHA",0,0);
			$pdf->addText(470,750,10,":",0,0);
			$pdf->addText(475,750,10,date('Y-m-d'),0,0);
			$pdf->addText(345,735,10,"VALOR US$",0,0);
			$pdf->addText(470,735,10,":",0,0);	
			$pdf->addText(475,735,10,"",0,0);
			//DATOS  VENDEDOR
			$pdf->rectangle(0,605, 325,115);
			$pdf->addText(115,710,10,"DATOS VENDEDOR",0,0);
			$pdf->line(0,705,325,705);
			$pdf->addText(5,690,10,"NOMBRE",0,0);
			$pdf->addText(100,690,10,":",0,0);
			$pdf->addText(105,690,10,$NombrePrv,0,0);
			$pdf->addText(5,670,10,"MINA / PLANTA",0,0);
			$pdf->addText(100,670,10,":",0,0);	
			$pdf->addText(105,670,10,$NombreFaena,0,0);
			$pdf->addText(5,650,10,"SIERRA",0,0);
			$pdf->addText(100,650,10,":",0,0);	
			$pdf->addText(105,650,10,$Sierra,0,0);
			$pdf->addText(5,630,10,"PRODUCTO",0,0);
			$pdf->addText(100,630,10,":",0,0);	
			$pdf->addText(105,630,10,$NombreSubProducto,0,0);
			$pdf->addText(5,610,10,"CLASE",0,0);
			$pdf->addText(100,610,10,":",0,0);	
			$pdf->addText(105,610,10,$ClaseProducto,0,0);									
			//DATOS LOTE
			$pdf->rectangle(340,605, 255,115);
			$pdf->addText(430,710,10,"DATOS LOTE",0,0);
			$pdf->line(340,705,595,705);
			$pdf->addText(345,690,10,"FECHA DE CIERRE",0,0);
			$pdf->addText(470,690,10,":",0,0);
			$pdf->addText(475,690,10,$FechaCierre,0,0);
			$pdf->addText(345,670,10,"N� DE MUESTRA",0,0);
			$pdf->addText(470,670,10,":",0,0);	
			$pdf->addText(475,670,10,$Lote,0,0);
			$pdf->addText(345,650,10,"N� DE LOTE",0,0);
			$pdf->addText(470,650,10,":",0,0);	
			$pdf->addText(475,650,10,$Lote,0,0);
			$pdf->addText(345,630,10,"PESO HUMEDO",0,0);
			$pdf->addText(470,630,10,":",0,0);	
			$pdf->addText(475,630,10,number_format($PesoHumLote,$CantDec,',','.'),0,0);
			$pdf->addText(530,630,10,"Kgrs.",0,0);
	
			//DATOS  RETALLA
			$pdf->rectangle(0,485, 325,115);
			$pdf->addText(115,590,10,"DATOS RETALLA",0,0);
			$pdf->line(0,585,325,585);
			$pdf->addText(5,570,10,"PESO MUESTRA",0,0);
			$pdf->addText(100,570,10,":",0,0);
			$pdf->addText(230,570,10,"Grs.",0,0);
			$pdf->addText(5,550,10,"PESO RETALLA",0,0);
			$pdf->addText(100,550,10,":",0,0);	
			$pdf->addText(230,550,10,"Grs.",0,0);
			$pdf->addText(5,530,10,"LEY AU",0,0);
			$pdf->addText(100,530,10,":",0,0);	
			$pdf->addText(230,530,10,$UnidadAu,0,0);
			$pdf->addText(5,510,10,"LEY AG",0,0);
			$pdf->addText(100,510,10,":",0,0);	
			$pdf->addText(230,510,10,$UnidadAg,0,0);
			$pdf->addText(5,490,10,"LEY CU",0,0);
			$pdf->addText(100,490,10,":",0,0);	
			$pdf->addText(230,490,10,$UnidadCu,0,0);			
			
			if($LeyCu==0&&$LeyAg==0&&$LeyAu==0)
			{
				$pdf->addText(185,570,10,number_format(0,4,',','.'),0,0);
				$pdf->addText(185,550,10,number_format(0,4,',','.'),0,0);
				$pdf->addText(185,530,10,number_format(0,4,',','.'),0,0);
				$pdf->addText(185,510,10,number_format(0,4,',','.'),0,0);
				$pdf->addText(185,490,10,number_format(0,4,',','.'),0,0);
			}	
			else
			{
				$pdf->addTextWrap(110,570,60,10,number_format($PesoMuestra,4,',','.'),$justification='right',0,0);
				$pdf->addTextWrap(110,550,60,10,number_format($PesoRetalla,4,',','.'),$justification='right',0,0);
				$pdf->addTextWrap(110,530,60,10,number_format($LeyAu,4,',','.'),$justification='right',0,0);
				$pdf->addTextWrap(110,510,60,10,number_format($LeyAg,4,',','.'),$justification='right',0,0);
				$pdf->addTextWrap(110,490,60,10,number_format($LeyCu,4,',','.'),$justification='right',0,0);
			}	
			//DATOS REMUESTREO
			$pdf->rectangle(340,485, 255,115);
			$pdf->addText(430,590,10,"DATOS REMUESTREO",0,0);
			$pdf->line(340,585,595,585);
			$pdf->addText(345,550,10,"EX-LOTE N�",0,0);
			$pdf->addText(470,550,10,":",0,0);	
			$pdf->addText(475,550,10,$LoteRemuestreo,0,0);
			$pdf->addText(345,530,10,"SOLICITADO POR",0,0);
			$pdf->addText(345,510,10,"DIVISION VENTANA",0,0);
			$pdf->rectangle(450,510, 10,10);
			$pdf->addText(480,510,10,"VENDEDOR",0,0);
			$pdf->rectangle(550,510, 10,10);
			
			//RESULTADOS ENSAYES
			$pdf->rectangle(0,70, 595,405);
			$pdf->addText(250,460,10,"RESULTADOS ENSAYES",0,0);
			$pdf->line(0,455,595,455);
			$pdf->addText(10,435,10,"ENSAYES",0,0);			
			$pdf->addText(130,435,10,"Ley 1era",0,0);
			$pdf->addText(190,435,10,"Ley 2da",0,0);
			$pdf->addText(250,435,10,"Ley 3era",0,0);
			$pdf->addText(310,435,10,"Ley 4ta",0,0);
			$pdf->addText(370,435,10,"Ley Retalla",0,0);
			$pdf->addText(430,435,10,"Inc Retalla",0,0);
			$pdf->addText(490,435,10,"Ley Canje",0,0);
			$pdf->addText(550,435,10,"Ley Final",0,0);			
		
			$Consulta="select t4.valor2,t4.valor3,t4.valor4,t4.paquete_canje,t4.valor_retalla,t4.inc_retalla,t4.ley_canje,t1.recargo,t1.cod_leyes,t1.valor,t1.cod_unidad,";
			$Consulta.="t2.abreviatura,t3.nombre_leyes as nomley,t3.abreviatura as abrev_ley from age_web.leyes_por_lote t1 ";
			$Consulta.="left join proyecto_modernizacion.unidades t2 on t1.cod_unidad=t2.cod_unidad left join proyecto_modernizacion.leyes t3 on t1.cod_leyes=t3.cod_leyes ";
			$Consulta.="left join age_web.leyes_por_lote_canje t4 on t1.lote=t4.lote and t1.recargo=t4.recargo and t1.cod_leyes=t4.cod_leyes ";
			$Consulta.="where t1.lote='$Lote' and t1.recargo = '0' and t1.cod_leyes in('02','04','05')";
			$Pos=420;
			$PosAux=$Pos;
			$Pqte3Canje='';
			$Pqte4Canje='';
			$RespLeyes=mysqli_query($link, $Consulta);
			while($FilaLeyes=mysqli_fetch_array($RespLeyes))
			{
				$pdf->addText(5,$PosAux,10,$FilaLeyes[nomley],0,0);
				$pdf->addText(90,$PosAux,10,$FilaLeyes["abreviatura"],0,0);
				if($FilaLeyes[valor]!=0)
					$pdf->addTextWrap(110,$PosAux,60,10,number_format($FilaLeyes[valor],4,',','.'),$justification='right',0,0);
				else
					$pdf->addTextWrap(110,$PosAux,60,10,'---',$justification='right',0,0);
				if($FilaLeyes[valor2]!=0)	
					$pdf->addTextWrap(165,$PosAux,60,10,number_format($FilaLeyes[valor2],4,',','.'),$justification='right',0,0);
				else
					$pdf->addTextWrap(165,$PosAux,60,10,'---',$justification='right',0,0);
				if($FilaLeyes[valor3]!=0)		
					$pdf->addTextWrap(230,$PosAux,60,10,number_format($FilaLeyes[valor3],4,',','.'),$justification='right',0,0);
				else
					$pdf->addTextWrap(230,$PosAux,60,10,'---',$justification='right',0,0);
				if($FilaLeyes[valor4]!=0)
					$pdf->addTextWrap(280,$PosAux,60,10,number_format($FilaLeyes[valor3],4,',','.'),$justification='right',0,0);
				else
					$pdf->addTextWrap(280,$PosAux,60,10,'---',$justification='right',0,0);
				if($FilaLeyes[valor_retalla]!=0)	
					$pdf->addTextWrap(360,$PosAux,60,10,number_format($FilaLeyes[valor_retalla],4,',','.'),$justification='right',0,0);
				else
					$pdf->addTextWrap(360,$PosAux,60,10,'---',$justification='right',0,0);
				if($FilaLeyes[inc_retalla]!=0)	
					$pdf->addTextWrap(415,$PosAux,60,10,number_format($FilaLeyes[inc_retalla],4,',','.'),$justification='right',0,0);
				else
					$pdf->addTextWrap(415,$PosAux,60,10,'---',$justification='right',0,0);
				if($FilaLeyes[ley_canje]!=0)	
					$pdf->addTextWrap(475,$PosAux,60,10,number_format($FilaLeyes[ley_canje],4,',','.'),$justification='right',0,0);
				else
					$pdf->addTextWrap(475,$PosAux,60,10,'---',$justification='right',0,0);
				if($FilaLeyes[ley_canje]!=0)	
					$pdf->addTextWrap(530,$PosAux,60,10,number_format($FilaLeyes[ley_canje]+$FilaLeyes[inc_retalla],4,',','.'),$justification='right',0,0);
				else
					$pdf->addTextWrap(530,$PosAux,60,10,'---',$justification='right',0,0);
				$Pos=$Pos-15;
				$PosAux=$Pos;
				switch($FilaLeyes[paquete_canje])
				{
					case "3":
						$Pqte3Canje=$Pqte3Canje.$FilaLeyes[abrev_ley].", ";
						break;
					case "4":
						$Pqte4Canje=$Pqte4Canje.$FilaLeyes[abrev_ley].", ";
						break;
				}
			}
			
			$DatosLote= array();
			$ArrLeyes=array();
			$DatosLote["lote"]=$Lote;
			LeyesLote(&$DatosLote,&$ArrLeyes,"N","S","N","","","");
			//$Pos=430;
			$Pos=$Pos-15;
			$PosAux=$Pos;
			//$PosAux="-".$Pos;
			reset($ArrLeyes);
			while(list($c,$v)=each($ArrLeyes))
			{
				if($c!='01'&&$c!='')
				{
					$pdf->addTextWrap(5,$PosAux,60,10,$v[6],$justification='left',0,0);
					$pdf->addTextWrap(110,$PosAux,60,10,number_format($v[2],4,',','.'),$justification='right',0,0);
					$pdf->addTextWrap(90,$PosAux,60,10,$v[4],$justification='left',0,0);
					$Pos=$Pos-15;
					$PosAux=$Pos;
				}	
			}			
			$Pos=$Pos-15;
			$PosAux2=$Pos;
			$PosAux=$Pos;
			$PosCol=5;$ContFilas=0;
			$Consulta="select lpad(t1.recargo,2,'0') as rec,t1.recargo from age_web.detalle_lotes t1 inner join age_web.leyes_por_lote t2 on ";
			$Consulta.="t1.lote=t2.lote and t1.recargo=t2.recargo where t1.lote='$Lote' order by rec";
			$RespRec=mysqli_query($link, $Consulta);
			while($FilaRec=mysqli_fetch_array($RespRec))
			{
				if($ContFilas==8||$ContFilas==20||$ContFilas==30)
				{
					$Pos=$PosAux2;
					$PosAux=$Pos;
					$PosCol=$PosCol+200;
				}	
				$DatosLote= array();
				$ArrLeyes=array();
				$DatosLote["lote"]=$Lote;
				$DatosLote["recargo"]=$FilaRec["recargo"];
				$ArrLeyes["01"][0]="01";
				LeyesLoteRecargo(&$DatosLote,&$ArrLeyes,"N","S","N","","","");
				$pdf->addTextWrap($PosCol,$PosAux,60,10,"R ".$FilaRec[rec],$justification='left',0,0);
				reset($ArrLeyes);
				$pdf->addTextWrap($PosCol+105,$PosAux,60,10,number_format($ArrLeyes["01"][2],4,',','.'),$justification='right',0,0);
				$pdf->addTextWrap($PosCol+85,$PosAux,60,10,$ArrLeyes["01"][4],$justification='left',0,0);
				$Pos=$Pos-15;
				$PosAux=$Pos;
				$ContFilas++;
			}		
		
			$Pqte3Canje=substr($Pqte3Canje,0,strlen($Pqte3Canje)-2);
			$Pqte4Canje=substr($Pqte4Canje,0,strlen($Pqte4Canje)-2);
			if($Pqte3Canje!='')
				$pdf->addText(80,100,14,"3�:                                                            ".$Pqte3Canje,0,0);
			if($Pqte4Canje!='')	
				$pdf->addText(80,80,14,"4�:                                                            ".$Pqte4Canje,0,0);
			$pdf->line(80,40,235,40);
			$pdf->addText(110,25,10,"FIRMA Y TIMBRE",0,0);
			$pdf->addText(130,13,10,"ENAMI",0,0);				
			$pdf->line(405,40,560,40);
			$pdf->addText(440,25,10,"FIRMA Y TIMBRE",0,0);
			$pdf->addText(435,13,10,"DIVISION VENTANA",0,0);
			
		}
		if(isset($GrabarCert)&&$GrabarCert=='S')
		{
			$Fecha=date('d-m-Y');
			$Hora=date('h:i');
			$Fecha=str_replace('-','',$Fecha);
			$Hora=str_replace(':','',$Hora);
			$NombreCertificado=$Lote."_".$Fecha."_".$Hora."_".$Tipo;
			$Actualizar="UPDATE age_web.lotes set certificado='$NombreCertificado' where lote ='".$Lote."'";
			mysqli_query($link, $Actualizar);
		}			
	}
	$pdf->ezStream();
	$pdf->Output();	
	
?>