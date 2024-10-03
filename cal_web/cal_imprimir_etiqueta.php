<?php
	include("../principal/conectar_cal_web.php");
	include("../principal/funciones/class.ezpdf.php");

	$SA     = isset($_REQUEST["SA"])?$_REQUEST["SA"]:"";

	$ArrayA = explode("//",$SA);
	$LargoA = count($ArrayA);
	//VERIFICA SOLICITUDES QUE TIENEN + DE 1 RECARGO
	$SA = "";
	for ($i = 0; $i < $LargoA-1; $i++)
	{		
		$ArrayB       = explode("~~",$ArrayA[$i]);
		$NumSolicitud = isset($ArrayB[0])?$ArrayB[0]:"";
		$ArrayC       = explode("||",$ArrayB[1]);
		$RutFun       = $ArrayC[0];
		$NumRecargo   = $ArrayC[1];
		if ($NumRecargo == "M")
		{
			$Consulta = "select * from cal_web.solicitud_analisis where nro_solicitud = '".$NumSolicitud."' order by recargo";
			$Respuesta = mysqli_query($link, $Consulta);
			while ($Fila = mysqli_fetch_array($Respuesta))
			{
				$SA = $SA.$NumSolicitud."~~".$Fila["rut_funcionario"]."||".$Fila["recargo"]."//";
			}
		}
		else
		{
			$SA = $SA.$NumSolicitud."~~".$RutFun."||".$NumRecargo."//";
		}
	}
	//----------------------------------------------
	reset($ArrayA);
	reset($ArrayB);
	reset($ArrayC);
	$ArrayA = explode("//",$SA);
	$LargoA = count($ArrayA);
	$ContSolicitudes = 1;
	for ($i = 0; $i < $LargoA-1; $i++)
	{		
		$ArrayB = explode("~~",$ArrayA[$i]);
		$NumSolicitud = $ArrayB[0];
		$ArrayC = explode("||",$ArrayB[1]);
		$NumRecargo = $ArrayC[1];
		//INICIALIZA NUEVA PAGINA
		if ($ContSolicitudes == 1)
			$pdf = new Cezpdf('a4');
	    $pdf->selectFont('../principal/funciones/fonts/Helvetica.afm');	
		#FORMATO CAJA DE TEXTO (objeto, texto, left, top, width, height, align)
		$Datos1=DatosSA($NumSolicitud,$NumRecargo,$link);
		$Leyes1=DatosLeyes($NumSolicitud,$NumRecargo,$link);
		switch ($ContSolicitudes)
		{
			case 1:
				ImprimePdf($Datos1,$Leyes1,$pdf,0,630,10,780,60,55,150,190,192,770,760,740,730,80,82,720,118,750,$ContSolicitudes,200);
				break;
			case 2:
				ImprimePdf($Datos1,$Leyes1,$pdf,300,630,305,780,355,350,460,500,502,770,760,740,730,372,374,720,408,750,$ContSolicitudes,510);
				break;
			case 3:
				ImprimePdf($Datos1,$Leyes1,$pdf,0,430,10,580,60,55,150,190,192,570,560,540,530,80,82,520,118,550,$ContSolicitudes,200);
				break;
			case 4:
				ImprimePdf($Datos1,$Leyes1,$pdf,300,430,305,580,355,350,460,500,502,570,560,540,530,372,374,520,408,550,$ContSolicitudes,510);
				break;
			case 5:
				ImprimePdf($Datos1,$Leyes1,$pdf,0,230,10,380,60,55,150,190,192,370,360,340,330,80,82,320,118,350,$ContSolicitudes,200);
				break;
			case 6:
				ImprimePdf($Datos1,$Leyes1,$pdf,300,230,305,380,355,350,460,500,502,370,360,340,330,372,374,320,408,350,$ContSolicitudes,510);
				break;
			case 7:
				ImprimePdf($Datos1,$Leyes1,$pdf,0,30,10,180,60,55,150,190,192,170,160,140,130,80,82,120,118,150,$ContSolicitudes,200);
				break;
			case 8:
				ImprimePdf($Datos1,$Leyes1,$pdf,300,30,305,180,355,350,460,500,502,170,160,140,130,372,374,120,408,150,$ContSolicitudes,510);
				break;
		}
		if ($ContSolicitudes == 10)
		{
			//$ContSolicitudes = 1;
			$ContSolicitudes++;
		}	
		else
		{
			$ContSolicitudes++;
		}
	}
	$pdf->ezStream();
	$pdf->Output();	
	//include("../principal/cerrar_cal_web.php");
	//header("location:etiqueta.pdf");
	///////////////////////FUNCIONES///////////////////////////////
	function DatosSA($NumSolicitudAux,$NumRecargoAux,$link) 
	{
		$Consulta = "select t1.nro_solicitud, t1.recargo, t1.id_muestra, t1.cod_producto, t2.descripcion as nom_producto, ";
		$Consulta.= " t1.cod_subproducto, t3.descripcion as nom_subproducto, t1.cod_ccosto, t4.descripcion as nom_cc,t1.fecha_muestra ";
		$Consulta.= "from cal_web.solicitud_analisis t1 left join proyecto_modernizacion.productos t2 ";
		$Consulta.= " on t1.cod_producto = t2.cod_producto left join proyecto_modernizacion.subproducto t3 ";
		$Consulta.= " on t1.cod_producto = t3.cod_producto and t1.cod_subproducto = t3.cod_subproducto left join proyecto_modernizacion.centro_costo t4 ";
		$Consulta.= " on t1.cod_ccosto = t4.centro_costo ";
		$Consulta.= " where nro_solicitud = '".$NumSolicitudAux."'";
		if ($NumRecargoAux != "N")
			$Consulta.= " and recargo = '".$NumRecargoAux."'";
		$Respuesta = mysqli_query($link, $Consulta);
		$Row = mysqli_fetch_array($Respuesta);
		$Consulta = "select * from cal_web.estados_por_solicitud where nro_solicitud = '".$Row["nro_solicitud"]."' ";
		$Consulta.= "and recargo = '".$Row["recargo"]."' and cod_estado = '13'";
		$Respuesta2 = mysqli_query($link, $Consulta);		
		if ($Row2 = mysqli_fetch_array($Respuesta2))
			$FechaMuestrera = substr($Row2["fecha_hora"],0,10);
		else 	$FechaMuestrera = "";
		$Var=$Row["nro_solicitud"].'~'.$Row["recargo"].'~'.$Row["id_muestra"].'~'.$Row["cod_producto"].'~'.$Row["nom_producto"].'~'.$Row["cod_subproducto"].'~'.$Row["nom_subproducto"].'~'.$Row["cod_ccosto"].'~'.$Row["nom_cc"].'~'.$FechaMuestrera;
		return($Var);
	}
	function DatosLeyes($NumSolicitudAux,$NumRecargoAux,$link) 
	{
		//CONSULTO LEYES DE LA SOLICITUD
		$Consulta = "select t1.cod_leyes, t2.abreviatura ";
		$Consulta.= " from cal_web.leyes_por_solicitud t1 left join proyecto_modernizacion.leyes t2 ";
		$Consulta.= " on t1.cod_leyes = t2.cod_leyes ";
		$Consulta.= " where t1.nro_solicitud = '".$NumSolicitudAux."'";
		if ($NumRecargoAux != "N")
			$Consulta.= " and t1.recargo = '".$NumRecargoAux."' ";
		$Consulta.= " order by t1.cod_leyes";
		$Respuesta3 = mysqli_query($link, $Consulta);
		$ContLeyes = 0;
		$ContLineas = 0;
		$VarLeyes=""; //WSO
		$CantLeyes = 0;
		while ($Row3 = mysqli_fetch_array($Respuesta3))
		{
			$ContLeyes++;
			if($ContLeyes =='1')
				$VarLeyes=$Row3["abreviatura"];
			else
				$VarLeyes=$VarLeyes.'~'.$Row3["abreviatura"];
		}
		return($VarLeyes);
	}
	//function ImprimePdf($Datos,$Leyes,$pdf,$cero,$seis30,$diez,$siete80,$sesenta,$cincinco,$ciento50,$ciento90,$ciento92,$siete70,$siete60,$siete40,$siete30,$ochenta,$ochenta2,$siete20,$unounoocho,$siete50,$ContSol,$ciento92) 
	function ImprimePdf($Datos,$Leyes,$pdf,$cero,$seis30,$diez,$siete80,$sesenta,$cincinco,$ciento50,$ciento90,$ciento92,$siete70,$siete60,$siete40,$siete30,$ochenta,$ochenta2,$siete20,$unounoocho,$siete50,$ContSol) 
	{
		$pdf->rectangle($cero,$seis30, 275,175);
		$arreglo=explode('~',$Datos);
		$NroSol=$arreglo[0];
		$Recargo=$arreglo[1];
		$Muestra=$arreglo[2];
		$arreglo3 = isset($arreglo[3])?$arreglo[3]:"";
		$arreglo4 = isset($arreglo[4])?$arreglo[4]:"";
		$arreglo5 = isset($arreglo[5])?$arreglo[5]:"";
		$arreglo6 = isset($arreglo[6])?$arreglo[6]:"";
		
		//$DesProd=str_pad('0','2',$arreglo[3],STR_PAD_RIGHT).' '.$arreglo[4]; //cambie 3 x 2 
		//$DesSubProd=str_pad('0','2',$arreglo[5],STR_PAD_RIGHT).' '.$arreglo[6]; //cambie 3 x 2
		$DesProd    = str_pad($arreglo3,'2','0',STR_PAD_RIGHT).' '.$arreglo4; //cambie 3 x 2 
		$DesSubProd = str_pad($arreglo5,'2','0',STR_PAD_RIGHT).' '.$arreglo6; //cambie 3 x 2
		
		$NomCeco=$arreglo[7].' '.$arreglo[8];
		$FechaMuestra=$arreglo[9].'  '.'Laborat. :';
		$pdf->addText($diez,$siete80,10,'S.A',0,0);
		$pdf->addText($sesenta,$siete80,10,$NroSol,0,0);	
		$pdf->addText($cincinco,$siete80,10,':',0,0);
		$pdf->addText($ciento50,$siete80,10,'Recargo',0,0);
		$pdf->addText($ciento90,$siete80,10,':',0,0);
		$pdf->addText($ciento92,$siete80,10,$Recargo,0,0);
		$pdf->addText($diez,$siete70,10,'Ident.',0,0);
		$pdf->addText($cincinco,$siete70,10,':',0,0);
		$pdf->addText($sesenta,$siete70,10,$Muestra,0,0);
		$pdf->addText($diez,$siete60,10,'Producto',0,0);
		$pdf->addText($cincinco,$siete60,10,':',0,0);
		$pdf->addText($sesenta,$siete60,10,$DesProd,0,0);
		$pdf->addText($diez,$siete50,10,'SubProd',0,0);
		$pdf->addText($cincinco,$siete50,10,':',0,0);
		$pdf->addText($sesenta,$siete50,10,$DesSubProd,0,0);
		$pdf->addText($diez,$siete40,10,'C.Costo',0,0);
		$pdf->addText($cincinco,$siete40,10,':',0,0);
		$pdf->addText($sesenta,$siete40,10,$NomCeco,0,0);
		$pdf->addText($diez,$siete30,10,'Fecha Muestra',0,0);
		$pdf->addText($ochenta,$siete30,10,':',0,0);
		$pdf->addText($ochenta2,$siete30,10,$FechaMuestra,0,0);
		$pdf->addText($unounoocho,$siete20,10,'LEYES',0,0);
		$Cont=0;
		
		switch ($ContSol)
		{
			case "1":
				$Fila=710;
				$diez=10;
				$siete5=75;
				$ciento40=140;
				$dosciento5=205;
			break;
			case "2":
				$Fila=710;
				$diez=305;
				$siete5=370;
				$ciento40=435;
				$dosciento5=500;
			break;
			case "3":
				$Fila=510;
				$diez=10;
				$siete5=75;
				$ciento40=140;
				$dosciento5=205;
			break;
			case "4":
				$Fila=510;
				$diez=305;
				$siete5=370;
				$ciento40=435;
				$dosciento5=500;
			break;
			case "5":
				$Fila=310;
				$diez=10;
				$siete5=75;
				$ciento40=140;
				$dosciento5=205;
			break;
			case "6":
				$Fila=310;
				$diez=305;
				$siete5=370;
				$ciento40=435;
				$dosciento5=500;
			break;
			case "7":
				$Fila=110;
				$diez=10;
				$siete5=75;
				$ciento40=140;
				$dosciento5=205;
			break;
			case "8":
				$Fila=110;
				$diez=305;
				$siete5=370;
				$ciento40=435;
				$dosciento5=500;
			break; 
		}	
		$Val=explode('~',$Leyes);
		//while (list($clave,$Codigo)=each($Val))
		foreach($Val as $clave => $Codigo)
		{
			$Cont++;
			if(strlen($Codigo) =='1')
				$CodLey=$Codigo.'  _______';
			else
				$CodLey=$Codigo.'_______';
			if($Cont == '1')
				$pdf->addText($diez,$Fila,10,$CodLey,0,0);
			else
		// cambiada -25-11-2009	 if($Cont =='5' || $Cont =='10' || $Cont =='15' || $Cont =='20' || $Cont =='25' || $Cont =='30' )
			 if($Cont =='5' || $Cont =='9' || $Cont =='13' || $Cont =='17' || $Cont =='21' || $Cont =='25' )
			 {
					$Fila=$Fila-10;
					$pdf->addText($diez,$Fila,10,$CodLey,0,0);
			 }
				else
				{
// cambiada 25-11-2009		if($Cont =='2' || $Cont =='6' || $Cont =='11' || $Cont =='16' || $Cont =='21' || $Cont =='26' || $Cont =='31'  )
					if($Cont =='2' || $Cont =='6' || $Cont =='10' || $Cont =='14' || $Cont =='18' || $Cont =='22' || $Cont =='26'  )
						$pdf->addText($siete5,$Fila,10,$CodLey,0,0);
					else
// cambio 25-11-2009		if($Cont =='3' || $Cont =='7' || $Cont =='12' || $Cont =='17' || $Cont =='22' || $Cont =='27' || $Cont =='32')
						if($Cont =='3' || $Cont =='7' || $Cont =='11' || $Cont =='15' || $Cont =='19' || $Cont =='23' || $Cont =='27')
							$pdf->addText($ciento40,$Fila,10,$CodLey,0,0);
						else
// cambio 25-11-2009		if($Cont =='4' || $Cont =='8' || $Cont =='13' || $Cont =='18' || $Cont =='23' || $Cont =='28' || $Cont =='33')
							if($Cont =='4' || $Cont =='8' || $Cont =='12' || $Cont =='16' || $Cont =='20' || $Cont =='24' || $Cont =='28')
								$pdf->addText($dosciento5,$Fila,10,$CodLey,0,0);								
				}
		}
	}
	
?>
