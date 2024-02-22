<?php
	include("../principal/conectar_principal.php");
	include("funciones.php");
	include("../principal/funciones/class.ezpdf.php");

	window.open("rec_adm_lote_boleta.php?Valores="+TxtLotes+"&TipoReg="+f.CmbTipoRegistro.value+"
	&TxtNumRomana="+f.TxtNumRomana.value,"","top=0,left=0,width=770,height=520,scrollbars=yes,resizable = yes");

	$Valores = $_REQUEST["Valores"];
	$TipoReg = $_REQUEST["TipoReg"];
	$TxtNumRomana = $_REQUEST["TxtNumRomana"];
	
	$pdf =& new Cezpdf('a4');
    $pdf->SELECTFont('../principal/funciones/fonts/Helvetica.afm');

	$Datos=explode('//',$Valores);
	foreach($Datos as $c => $v)
	{
		$Datos2=explode('-',$v);
		$Lote = $Datos2[0];
		$Recargo = $Datos2[1];
		switch($TipoReg)
		{
			case "R"://RECEPCION
				$NombreTabla='sipa_web.recepciones';
				break;
			case "D"://DESPACHOS
				$NombreTabla='sipa_web.despachos';
				break;
			case "O"://OTROS PESAJE
				$NombreTabla='sipa_web.otros_pesaje';
				break;
			default:
				$NombreTabla='sipa_web.recepciones';
				break;	
		}
		$Consulta = "SELECT t1.bascula_entrada, t1.bascula_salida, t1.rut_operador, t1.correlativo, t1.peso_bruto,  ";
		$Consulta.= " t1.hora_entrada, t1.fecha, t1.peso_tara, t1.hora_salida, t1.peso_neto, t1.conjunto, ";
		$Consulta.= "  ";
		switch($TipoReg)
		{
			case "R"://RECEPCION
				$Consulta.= " t1.lote,t1.recargo,t1.ult_registro,t6.fecha_padron,t6.nombre_mina as nom_faena, t6.comuna,t1.cod_mina,t5.descripcion as nom_subproducto, ";
				$Consulta.= " t1.cod_clase,t1.leyes, t1.impurezas,t3.nombre_prv as nom_proveedor, t1.rut_prv,t1.cod_producto, t1.cod_subproducto,t9.abast_minero,";
				break;
			case "D"://DESPACHOS
				$Consulta.= " t1.lote,t1.recargo,t1.ult_registro,t6.nombre_subclase as tipo_despacho,t3.nombre_prv as nom_proveedor, t1.rut_prv,t5.descripcion as nom_subproducto, ";
				break;
			case "O"://OTROS PASAJES	
				$Consulta.= " t1.nombre as nom_proveedor, t1.descripcion as nom_subproducto,";
				break;
		}
		$Consulta.= "  t1.observacion, t1.patente, t1.guia_despacho"; 
		$Consulta.= " from ".$NombreTabla." t1";
		switch($TipoReg)
		{
			case "R"://RECEPCION
				$Consulta.= " left join sipa_web.proveedores t3 on t1.rut_prv=t3.rut_prv  ";
				$Consulta.= " left join sipa_web.minaprv t6 on t1.cod_mina=t6.cod_mina and t1.rut_prv=t6.rut_prv ";
				$Consulta.= " inner join proyecto_modernizacion.subproducto t5 on t1.cod_producto=t5.cod_producto and t1.cod_subproducto=t5.cod_subproducto ";
				$Consulta.= " left join sipa_web.grupos_productos t9 on t1.cod_grupo=t9.cod_grupo ";
				$Consulta.= " where t1.lote = '".$Lote."' and t1.recargo='".$Recargo."'";
				break;
			case "D"://DESPACHOS
				$Consulta.= " left join sipa_web.proveedores t3 on t1.rut_prv=t3.rut_prv  ";
				$Consulta.= " left join proyecto_modernizacion.sub_clase t6 on t6.cod_clase='24000' and t6.valor_subclase1=t1.cod_despacho ";
				$Consulta.= " inner join proyecto_modernizacion.subproducto t5 on t1.cod_producto=t5.cod_producto and t1.cod_subproducto=t5.cod_subproducto ";
				$Consulta.= " where t1.lote = '".$Lote."' and t1.recargo='".$Recargo."'";
				break;
			case "O":
				$Consulta.= " where t1.correlativo = '".$Lote."'";
				break;	
		}
		$Resp = mysqli_query($link, $Consulta);
		//echo $Consulta;
		if ($Fila = mysqli_fetch_array($Resp))
		{
			//SEPARA PASTAS E IMPUREZAS EN ARREGLOS
			$Pastas = explode('~',$Fila["leyes"]);;
			$Impurezas = explode('~',$Fila["impurezas"]);
			$ArrPastas=array();
			$ArrImpurezas=array();
			if (strlen($Pastas)>1)
			{
				while(list($c,$v)=each($Pastas))
				{
					$ArrPastas[$v][0]=$v;
					$ArrPastas[$v][1]="S";
				}
			}
			if (strlen($Impurezas)>1)
			{
				foreach($Impurezas as $c => $v)
				{
					$ArrImpurezas[$v][0]=$v;
					$ArrImpurezas[$v][1]="S";
				}
			}			
			$pdf->SELECTFont('../principal/funciones/fonts/Helvetica-Bold.afm');
			$pdf->ezText("BOLETA DE PESAJE\n",16,array('justification'=>'center'));
			$pdf->addText(0,770,26,"CODELCO",0,0);
			$pdf->addText(480,770,26,"N�",0,0);
			$pdf->SELECTFont('../principal/funciones/fonts/Helvetica.afm');
			
			$pdf->rectangle(0,700, 35,30);
			$pdf->line(0,715,35,715);
			$pdf->addTextWrap(0,720,35,8,"CODIGO",$justification='center',0,0);
			
			$pdf->rectangle(45,700, 235,30);
			$pdf->line(45,715,280,715);
			$pdf->addTextWrap(45,720,235,8,"AGENCIA",$justification='center',0,0);			
			
			$pdf->rectangle(310,700, 80,30);
			$pdf->line(310,715,390,715);
			$pdf->addTextWrap(310,720,80,8,"BASCULA ENTRADA",$justification='center',0,0);	
			
			$pdf->rectangle(420,700, 80,30);
			$pdf->line(420,715,500,715);
			$pdf->addTextWrap(420,720,80,8,"BASCULA SALIDA",$justification='center',0,0);	
						
			$pdf->rectangle(510,700, 80,30);
			$pdf->line(510,715,590,715);
			$pdf->addTextWrap(510,720,80,8,"OPERADOR",$justification='center',0,0);	
			
			$pdf->rectangle(0,665, 70,30);
			$pdf->line(0,680,70,680);
			$pdf->addTextWrap(0,685,70,8,"N� LOTE",$justification='center',0,0);			
			
			$pdf->rectangle(80,665, 100,30);
			$pdf->line(80,680,180,680);
			$pdf->addTextWrap(80,685,100,8,"CORRELATIVO",$justification='center',0,0);			
			
			$pdf->rectangle(310,665, 80,30);
			$pdf->line(310,680,390,680);
			$pdf->addTextWrap(310,685,80,8,"PESO BRUTO",$justification='center',0,0);			
			
			$pdf->rectangle(420,665, 80,30);
			$pdf->line(420,680,500,680);
			$pdf->addTextWrap(420,685,80,8,"HORA",$justification='center',0,0);	
						
			$pdf->rectangle(510,665, 80,30);
			$pdf->line(510,680,590,680);
			$pdf->addTextWrap(510,685,80,8,"FECHA",$justification='center',0,0);				
			
			$pdf->rectangle(15,630, 50,30);
			$pdf->line(15,645,65,645);
			$pdf->addTextWrap(15,650,50,8,"RECARGO",$justification='center',0,0);			
			
			$pdf->rectangle(110,630, 35,30);
			$pdf->line(110,645,145,645);
			$pdf->addTextWrap(110,650,35,8,"ULT.",$justification='center',0,0);	
			
			$pdf->rectangle(190,630, 90,50);
			$pdf->line(190,645,280,645);
			$pdf->line(190,660,280,660);
			$pdf->addTextWrap(190,665,90,8,"EMPADRONAMIENTO",$justification='center',0,0);				
			$pdf->addTextWrap(190,650,90,8,"FECHA VENCIMIENTO",$justification='center',0,0);								

			$pdf->rectangle(310,630, 80,30);
			$pdf->line(310,645,390,645);
			$pdf->addTextWrap(310,650,80,8,"PESO TARA",$justification='center',0,0);			
			
			$pdf->rectangle(420,630, 80,30);
			$pdf->line(420,645,500,645);
			$pdf->addTextWrap(420,650,80,8,"HORA",$justification='center',0,0);	
						
			$pdf->rectangle(510,630, 80,30);
			$pdf->line(510,645,590,645);
			$pdf->addTextWrap(510,650,80,8,"PESO NETO",$justification='center',0,0);
			
			//$pdf->addTextWrap(420,620,100,9,"PESO TOTAL LOTE:",$justification='center',0,0);
			
			$pdf->rectangle(0,585, 445,30);
			$pdf->line(0,600,445,600);
			$pdf->addTextWrap(0,605,445,8,"NOMBRE",$justification='center',0,0);			
			
			$pdf->rectangle(455,585, 135,30);
			$pdf->line(455,600,590,600);
			$pdf->addTextWrap(455,605,135,8,"RUT",$justification='center',0,0);			
			
			$pdf->rectangle(0,545, 250,30);
			$pdf->line(0,560,250,560);
			$pdf->addTextWrap(0,565,250,8,"FAENA",$justification='center',0,0);				
			
			$pdf->rectangle(260,545, 185,30);
			$pdf->line(260,560,445,560);
			$pdf->addTextWrap(260,565,185,8,"SIERRA/COMUNA",$justification='center',0,0);
			
			$pdf->rectangle(455,545, 135,30);
			$pdf->line(455,560,590,560);
			$pdf->addTextWrap(455,565,135,8,"CODIGO FAENA",$justification='center',0,0);						
			
			$pdf->rectangle(0,490, 220,45);
			$pdf->rectangle(0,490, 30,30);
			$pdf->line(0,520,220,520);
			$pdf->line(0,505,220,505);
			$pdf->addTextWrap(0,525,220,8,"PRODUCTO",$justification='center',0,0);
			$pdf->addTextWrap(0,510,30,8,"COD.",$justification='center',0,0);
			$pdf->addTextWrap(30,510,200,8,"DESCRIPCION",$justification='center',0,0);
			
			$pdf->rectangle(230,490, 80,45);
			$pdf->line(230,520,310,520);
			$pdf->line(230,505,310,505);				
			$pdf->addTextWrap(230,525,80,8,"TIPO",$justification='center',0,0);				
			$pdf->addTextWrap(230,510,80,8,"PESAJE",$justification='center',0,0);	

			$pdf->rectangle(320,490, 60,45);
			$pdf->rectangle(320,490, 20,30);
			$pdf->rectangle(340,490, 20,30);
			$pdf->line(320,520,380,520);
			$pdf->line(320,505,380,505);				
			$pdf->addTextWrap(320,525,60,8,"CLASE",$justification='center',0,0);				
			$pdf->addTextWrap(320,510,20,8,"C",$justification='center',0,0);
			$pdf->addTextWrap(340,510,20,8,"G",$justification='center',0,0);
			$pdf->addTextWrap(360,510,20,8,"O",$justification='center',0,0);
			
			$pdf->rectangle(390,490, 110,45);
			$pdf->rectangle(390,490, 55,30);
			$pdf->line(390,520,500,520);
			$pdf->line(390,505,500,505);				
			$pdf->addTextWrap(390,525,110,8,"ENTREGA #",$justification='center',0,0);				
			$pdf->addTextWrap(390,510,55,8,"CONJUNTO",$justification='center',0,0);
			$pdf->addTextWrap(445,510,55,8,"CANCHA",$justification='center',0,0);				

			$pdf->rectangle(510,490, 80,45);
			$pdf->line(510,520,590,520);
			$pdf->line(510,505,590,505);				
			$pdf->addTextWrap(510,525,80,8,"DESCARGA",$justification='center',0,0);				
			$pdf->addTextWrap(510,510,80,8,"POR",$justification='center',0,0);

			$pdf->rectangle(0,435, 140,45);
			$pdf->rectangle(0,435, 20,30);
			$pdf->rectangle(0,435, 40,30);
			$pdf->rectangle(0,435, 60,30);
			$pdf->rectangle(0,435, 80,30);
			$pdf->rectangle(0,435, 100,30);
			$pdf->rectangle(0,435, 120,30);
			$pdf->rectangle(0,435, 140,30);
			$pdf->line(0,450,140,450);
			$pdf->addTextWrap(0,470,140,8,"ELEMENTOS",$justification='center',0,0);
			$pdf->addTextWrap(0,455,20,8,"Cul.",$justification='center',0,0);
			$pdf->addTextWrap(20,455,20,8,"CuS",$justification='center',0,0);
			$pdf->addTextWrap(40,455,20,8,"CuT",$justification='center',0,0);
			$pdf->addTextWrap(60,455,20,8,"Ag",$justification='center',0,0);
			$pdf->addTextWrap(80,455,20,8,"Au",$justification='center',0,0);
			$pdf->addTextWrap(100,455,20,8,"SIO2",$justification='center',0,0);
			$pdf->addTextWrap(120,455,20,8,"CaO",$justification='center',0,0);
			$pdf->line(150,450,590,450);
			$pdf->rectangle(150,435, 440,45);
			$pdf->rectangle(150,435, 25,30);
			$pdf->rectangle(175,435, 25,30);
			$pdf->rectangle(200,435, 25,30);
			$pdf->rectangle(225,435, 25,30);
			$pdf->rectangle(250,435, 25,30);
			$pdf->rectangle(275,435, 25,30);
			$pdf->rectangle(300,435, 25,30);
			$pdf->rectangle(325,435, 25,30);
			$pdf->rectangle(350,435, 25,30);
			$pdf->rectangle(375,435, 25,30);
			$pdf->rectangle(400,435, 25,30);
			$pdf->rectangle(425,435, 25,30);
			$pdf->rectangle(450,435, 25,30);
			$pdf->rectangle(475,435, 25,30);
			$pdf->rectangle(500,435, 25,30);
			$pdf->rectangle(525,435, 32,30);
			$pdf->rectangle(557,435, 33,30);

			$pdf->addTextWrap(150,470,440,8,"IMPUREZAS",$justification='center',0,0);
			$pdf->addTextWrap(150,455,25,8,"H2SO4.",$justification='center',0,0);
			$pdf->addTextWrap(175,455,25,8,"H2O",$justification='center',0,0);
			$pdf->addTextWrap(200,455,25,8,"As",$justification='center',0,0);
			$pdf->addTextWrap(225,455,25,8,"Sb",$justification='center',0,0);
			$pdf->addTextWrap(250,455,25,8,"Zn",$justification='center',0,0);
			$pdf->addTextWrap(275,455,25,8,"Pb",$justification='center',0,0);
			$pdf->addTextWrap(300,455,25,8,"CI",$justification='center',0,0);
			$pdf->addTextWrap(325,455,25,8,"MgO",$justification='center',0,0);
			$pdf->addTextWrap(350,455,25,8,"Cr2O3",$justification='center',0,0);
			$pdf->addTextWrap(375,455,25,8,"FeO",$justification='center',0,0);
			$pdf->addTextWrap(400,455,25,8,"CaO",$justification='center',0,0);
			$pdf->addTextWrap(425,455,25,8,"Al2O3",$justification='center',0,0);
			$pdf->addTextWrap(450,455,25,8,"SiO2",$justification='center',0,0);
			$pdf->addTextWrap(475,455,25,8,"Cd",$justification='center',0,0);
			$pdf->addTextWrap(500,455,25,8,"Hg",$justification='center',0,0);
			$pdf->addTextWrap(525,455,32,8,"S",$justification='center',0,0);
			$pdf->addTextWrap(557,455,33,8,"Te",$justification='center',0,0);
			
			$pdf->rectangle(0,395, 320,30);
			$pdf->line(0,410,320,410);
			$pdf->addTextWrap(0,415,320,8,"OBSERVACIONES",$justification='center',0,0);				
			
			$pdf->rectangle(330,395, 80,30);
			$pdf->line(330,410,410,410);
			$pdf->addTextWrap(330,415,80,8,"PATENTE",$justification='center',0,0);
			
			$pdf->rectangle(420,395, 80,30);
			$pdf->line(420,410,500,410);
			$pdf->addTextWrap(420,415,80,8,"GUIA DESPACHO",$justification='center',0,0);
			
			$pdf->rectangle(510,395, 80,30);
			$pdf->line(510,410,590,410);
			$pdf->addTextWrap(510,415,80,8,"CONTRATO",$justification='center',0,0);									
			/*DESPLIEGUE DE CAMPOS DE BD*/
			$pdf->SELECTFont('../principal/funciones/fonts/Helvetica-Bold.afm');
			$pdf->addTextWrap(0,705,35,9,"02",$justification='center',0,0);
			$pdf->addTextWrap(45,705,235,9,"FUNDICION Y REFINERIA VENTANAS",$justification='center',0,0);
			$pdf->addTextWrap(310,705,70,9,str_pad($Fila["bascula_entrada"],2,'0',STR_PAD_LEFT),$justification='center',0,0);
			$pdf->addTextWrap(420,705,80,9,str_pad($Fila["bascula_salida"],2,'0',STR_PAD_LEFT),$justification='center',0,0);
			$pdf->addTextWrap(510,705,80,9,$Fila["rut_operador"],$justification='center',0,0);
			$pdf->addTextWrap(0,670,70,9,$Fila["lote"],$justification='center',0,0);
			$pdf->addTextWrap(80,670,100,9,$Fila["correlativo"],$justification='center',0,0);
			$pdf->addTextWrap(310,670,70,9,$Fila["peso_bruto"],$justification='center',0,0);
			$pdf->addTextWrap(420,670,80,9,$Fila["hora_entrada"],$justification='center',0,0);
			$pdf->addTextWrap(510,670,80,9,$Fila["fecha"],$justification='center',0,0);
			$pdf->addTextWrap(15,635,50,9,$Fila["recargo"],$justification='center',0,0);
			$pdf->addTextWrap(110,635,35,9,$Fila["ult_registro"],$justification='center',0,0);
			$pdf->addTextWrap(190,635,90,9,substr($Fila["fecha_padron"],8,2)."/".substr($Fila["fecha_padron"],5,2)."/".substr($Fila["fecha_padron"],0,4),$justification='center',0,0);
			$pdf->addTextWrap(310,635,70,9,$Fila["peso_tara"],$justification='center',0,0);
			$pdf->addTextWrap(420,635,80,9,$Fila["hora_salida"],$justification='center',0,0);
			$pdf->addTextWrap(510,635,80,9,$Fila["peso_neto"],$justification='center',0,0);
			if($Fila["ult_registro"]=='S')//ACUMULAR PESO TOTAL LOTE
			{
				$Consulta = "SELECT sum(peso_neto) as tot_peso_lote from ".$NombreTabla."  where lote='".$Fila["lote"]."' group by lote";
				//echo $Consulta."<br>";
				$Resp2 = mysqli_query($link, $Consulta);
				$Fila2 = mysqli_fetch_array($Resp2);
				//pdf_show_boxed($g,"PESO TOTAL LOTE: ".$Fila2["tot_peso_lote"],460,-223,220,15,left);
				$pdf->addTextWrap(420,620,160,9,"PESO TOTAL LOTE: ".$Fila2["tot_peso_lote"],$justification='center',0,0);
			}
			switch($TipoReg)
			{
				case "R"://RECEPCION
					$Proveedor=$Fila["nom_proveedor"];
					$RutPrv=$Fila["rut_prv"];
					break;
				case "D"://DESPACHOS
					ObtenerProveedorDespacho('D',$Fila["rut_prv"],$Fila["correlativo"],$Fila["guia_despacho"],&$RutProved,&$NombreProved);
					$Proveedor=$NombreProved;
					$RutPrv=$Fila["rut_prv"];
					break;
				case "O":	
					$Proveedor=$Fila["nom_proveedor"];
					break;
			}						
			$pdf->addTextWrap(0,590,445,9,$Fila["nom_proveedor"],$justification='center',0,0);
			$pdf->addTextWrap(455,590,135,9,$RutPrv,$justification='center',0,0);
			$pdf->addTextWrap(0,550,250,9,$Fila["nom_faena"],$justification='center',0,0);
			$pdf->addTextWrap(260,550,260,9,strtoupper($Fila["sierra"]." / ".$Fila["comuna"]),$justification='center',0,0);
			$pdf->addTextWrap(455,550,135,9,$Fila["cod_mina"],$justification='center',0,0);
			$pdf->addTextWrap(0,495,30,9,str_pad($Fila["cod_subproducto"],2,'0',STR_PAD_LEFT),$justification='center',0,0);
			$pdf->addTextWrap(30,495,200,9,strtoupper($Fila["nom_subproducto"]),$justification='center',0,0);
			switch($TipoReg)
			{
				case "R"://RECEPCION
					$Consulta="SELECT * from sipa_web.rut_asignacion where rut_prv='".$Fila["rut_prv"]."'";
					$RespAsig=mysqli_query($link, $Consulta);
					if($FilaAsig=mysqli_fetch_array($RespAsig))
						$Asignacion=$FilaAsig["asignacion"];
					else
						$Asignacion="MAQ ENM";
					break;
				case "D"://DESPACHOS
					$Asignacion=$Fila["tipo_despacho"];
					break;
			}			
			$pdf->addTextWrap(230,495,80,9,strtoupper($Asignacion),$justification='center',0,0);
			if ($Fila["clase_producto"]=="C")
				$pdf->addTextWrap(320,495,20,9,"X",$justification='center',0,0);
			if ($Fila["clase_producto"]=="G")
				$pdf->addTextWrap(340,495,20,9,"X",$justification='center',0,0);
			if ($Fila["clase_producto"]!="C" && $Fila["clase_producto"]!="G")
				$pdf->addTextWrap(360,495,20,9,"X",$justification='center',0,0);
			$pdf->addTextWrap(390,495,55,9,$Fila["conjunto"],$justification='center',0,0);	
			$pdf->addTextWrap(455,495,55,9,$Fila["cancha"],$justification='center',0,0);
			$pdf->addTextWrap(510,495,80,9,$Fila["nom_descarga"],$justification='center',0,0);
			//ELEMENTOS
			if ($ArrPastas["03"][1]=="S")
				$pdf->addTextWrap(0,440,20,9,"X",$justification='center',0,0);
			if ($ArrPastas["07"][1]=="S")
				$pdf->addTextWrap(20,440,20,9,"X",$justification='center',0,0);
			if ($ArrPastas["02"][1]=="S")
				$pdf->addTextWrap(40,440,20,9,"X",$justification='center',0,0);
			if ($ArrPastas["04"][1]=="S")
				$pdf->addTextWrap(60,440,20,9,"X",$justification='center',0,0);
			if ($ArrPastas["05"][1]=="S")
				$pdf->addTextWrap(80,440,20,9,"X",$justification='center',0,0);
			if ($ArrPastas["41"][1]=="S")
				$pdf->addTextWrap(100,440,20,9,"X",$justification='center',0,0);
			if ($ArrPastas["28"][1]=="S")
				$pdf->addTextWrap(120,440,20,9,"X",$justification='center',0,0);
			//IMPUREZAS	
			if ($ArrImpurezas["06"][1]=="S")
				$pdf->addTextWrap(150,440,25,9,"X",$justification='center',0,0);
			if ($ArrImpurezas["01"][1]=="S")
				$pdf->addTextWrap(175,440,25,9,"X",$justification='center',0,0);
			if ($ArrImpurezas["08"][1]=="S")
;				$pdf->addTextWrap(200,440,25,9,"X",$justification='center',0,0);
			if ($ArrImpurezas["09"][1]=="S")
				$pdf->addTextWrap(225,440,25,9,"X",$justification='center',0,0);
			if ($ArrImpurezas["10"][1]=="S")
				$pdf->addTextWrap(250,440,25,9,"X",$justification='center',0,0);
			if ($ArrImpurezas["39"][1]=="S")
				$pdf->addTextWrap(275,440,25,9,"X",$justification='center',0,0);
			if ($ArrImpurezas["11"][1]=="S")
				$pdf->addTextWrap(300,440,25,9,"X",$justification='center',0,0);
			if ($ArrImpurezas["12"][1]=="S")
				$pdf->addTextWrap(325,440,25,9,"X",$justification='center',0,0);
			if ($ArrImpurezas["13"][1]=="S")
				$pdf->addTextWrap(350,440,25,9,"X",$justification='center',0,0);
			if ($ArrImpurezas["31"][1]=="S")
				$pdf->addTextWrap(375,440,25,9,"X",$justification='center',0,0);
			if ($ArrImpurezas["28"][1]=="S")
				$pdf->addTextWrap(400,440,25,9,"X",$justification='center',0,0);
			if ($ArrImpurezas["25"][1]=="S")
				$pdf->addTextWrap(425,440,25,9,"X",$justification='center',0,0);
			if ($ArrImpurezas["41"][1]=="S")
				$pdf->addTextWrap(450,440,25,9,"X",$justification='center',0,0);
			if ($ArrImpurezas["58"][1]=="S")
				$pdf->addTextWrap(475,440,25,9,"X",$justification='center',0,0);
			if ($ArrImpurezas["34"][1]=="S")
				$pdf->addTextWrap(500,440,25,9,"X",$justification='center',0,0);
			if ($ArrImpurezas["26"][1]=="S")
				$pdf->addTextWrap(525,440,32,9,"X",$justification='center',0,0);		
			if ($ArrImpurezas["44"][1]=="S")
				$pdf->addTextWrap(557,440,33,9,"X",$justification='center',0,0);	
			$pdf->addTextWrap(0,400,320,9,$Fila["observacion"],$justification='center',0,0);
			$pdf->addTextWrap(330,400,80,9,$Fila["patente"],$justification='center',0,0);
			$pdf->addTextWrap(420,400,80,9,$Fila["guia_despacho"],$justification='center',0,0);
			$pdf->addTextWrap(510,400,80,9,$Fila["contrato"],$justification='center',0,0);
		}
	}
	$pdf->ezStream();
	$pdf->Output();			
?>