<?php
	$CodigoDeSistema=24;
	$CodigoDePantalla=3;
	include("../principal/conectar_principal.php");
	include("funciones.php");	
	require "includes/class.phpmailer.php";

	$SERVER_NAME  = $_SERVER['SERVER_NAME']; //nombre del servidor : localhost
	$REMOTE_ADDR  = gethostbyaddr($_SERVER['REMOTE_ADDR']); //Nombnre completro de la PC : WSALDANA-PERU.sml.sermaluc.cl
	$COMPUTERNAME =  getenv("COMPUTERNAME"); //nombre de la PC : WSALDANA-PERU
	$IP           = getenv("REMOTE_ADDR"); //Obtiene la IP de cada equipo: ::1 

	$RNA     = isset($_REQUEST["RNA"])?$_REQUEST["RNA"]:"";
	$Bloq1   = isset($_REQUEST["Bloq1"])?$_REQUEST["Bloq1"]:"";
	$Bloq2   = isset($_REQUEST["Bloq2"])?$_REQUEST["Bloq2"]:"";
	
	//echo "Bloq1:".$Bloq1."<br>";
	//echo "Bloq2:".$Bloq2."<br>";

	$Mensaje       = isset($_REQUEST["Mensaje"])?$_REQUEST["Mensaje"]:"";
	$BuscarPrv     = isset($_REQUEST["BuscarPrv"])?$_REQUEST["BuscarPrv"]:"";	
	$TipoProceso   = isset($_REQUEST["TipoProceso"])?$_REQUEST["TipoProceso"]:"";
	$Proceso       = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$TxtNumBascula = isset($_REQUEST["TxtNumBascula"])?$_REQUEST["TxtNumBascula"]:"";
	$TxtBasculaAux = isset($_REQUEST["TxtBasculaAux"])?$_REQUEST["TxtBasculaAux"]:"";
	$OptBascula    = isset($_REQUEST["OptBascula"])?$_REQUEST["OptBascula"]:"";
	$TxtNumRomana  = isset($_REQUEST["TxtNumRomana"])?$_REQUEST["TxtNumRomana"]:"";
	$TxtPorcRango  = isset($_REQUEST["TxtPorcRango"])?$_REQUEST["TxtPorcRango"]:"";
	$CmbClase      = isset($_REQUEST["CmbClase"])?$_REQUEST["CmbClase"]:"";
	$TxtRutPrv     = isset($_REQUEST["TxtRutPrv"])?$_REQUEST["TxtRutPrv"]:"";
	
	$AbastMinero = isset($_REQUEST["AbastMinero"])?$_REQUEST["AbastMinero"]:"";
	$TxtPatente  = isset($_REQUEST["TxtPatente"])?$_REQUEST["TxtPatente"]:"";
	$TxtPesoNeto = isset($_REQUEST["TxtPesoNeto"])?$_REQUEST["TxtPesoNeto"]:"";

	$EstPatente = isset($_REQUEST["EstPatente"])?$_REQUEST["EstPatente"]:"";
	$TxtObs = isset($_REQUEST["TxtObs"])?$_REQUEST["TxtObs"]:"";
	$TxtCorrelativo = isset($_REQUEST["TxtCorrelativo"])?$_REQUEST["TxtCorrelativo"]:"";
	$TxtGuia = isset($_REQUEST["TxtGuia"])?$_REQUEST["TxtGuia"]:"";
	
	$CmbGrupoProd = isset($_REQUEST["CmbGrupoProd"])?$_REQUEST["CmbGrupoProd"]:"";
	$CmbSubProducto = isset($_REQUEST["CmbSubProducto"])?$_REQUEST["CmbSubProducto"]:"";	
	$CmbProveedor = isset($_REQUEST["CmbProveedor"])?$_REQUEST["CmbProveedor"]:"";
	$TxtHumedad = isset($_REQUEST["TxtHumedad"])?$_REQUEST["TxtHumedad"]:"";
	$TxtLeyes = isset($_REQUEST["TxtLeyes"])?$_REQUEST["TxtLeyes"]:"";
	$TitCmbCorr = isset($_REQUEST["TitCmbCorr"])?$_REQUEST["TitCmbCorr"]:"";	

	$TxtPesoHistorico = isset($_REQUEST["TxtPesoHistorico"])?$_REQUEST["TxtPesoHistorico"]:"";
	$TxtPesoBruto = isset($_REQUEST["TxtPesoBruto"])?$_REQUEST["TxtPesoBruto"]:"";
	$TxtHoraS = isset($_REQUEST["TxtHoraS"])?$_REQUEST["TxtHoraS"]:"";
	$TxtPesoTara = isset($_REQUEST["TxtPesoTara"])?$_REQUEST["TxtPesoTara"]:"";
	$TxtHoraE = isset($_REQUEST["TxtHoraE"])?$_REQUEST["TxtHoraE"]:"";
	$TxtNombrePrv = isset($_REQUEST["TxtNombrePrv"])?$_REQUEST["TxtNombrePrv"]:"";
	
	$CmbLotes = isset($_REQUEST["CmbLotes"])?$_REQUEST["CmbLotes"]:"";
	$TxtLote  = isset($_REQUEST["TxtLote"])?$_REQUEST["TxtLote"]:"";
	$TxtRecargo = isset($_REQUEST["TxtRecargo"])?$_REQUEST["TxtRecargo"]:"";
	$CmbUltRecargo = isset($_REQUEST["CmbUltRecargo"])?$_REQUEST["CmbUltRecargo"]:"";	
	$CmbConjunto = isset($_REQUEST["CmbConjunto"])?$_REQUEST["CmbConjunto"]:"";
	$TxtPesoTotalNeto = isset($_REQUEST["TxtPesoTotalNeto"])?$_REQUEST["TxtPesoTotalNeto"]:"";
	$TxtPNetoTot = isset($_REQUEST["TxtPNetoTot"])?$_REQUEST["TxtPNetoTot"]:"";
	$TxtImpurezas = isset($_REQUEST["TxtImpurezas"])?$_REQUEST["TxtImpurezas"]:"";
	
	$Valor    = isset($_REQUEST["Valor"])?$_REQUEST["Valor"]:"";
	$TxtFecha = isset($_REQUEST["TxtFecha"])?$_REQUEST["TxtFecha"]:date("Y-m-d");
	$ObjFoco  = isset($_REQUEST["ObjFoco"])?$_REQUEST["ObjFoco"]:"";
	$ValidaPadronMin = isset($_REQUEST["ValidaPadronMin"])?$_REQUEST["ValidaPadronMin"]:"";
	$TxtVencPadron = isset($_REQUEST["TxtVencPadron"])?$_REQUEST["TxtVencPadron"]:"";
	$CmbMinaPlanta = isset($_REQUEST["CmbMinaPlanta"])?$_REQUEST["CmbMinaPlanta"]:"";

	$TxtConjunto     = isset($_REQUEST["TxtConjunto"])?$_REQUEST["TxtConjunto"]:"";
	$TxtAsignacion   = isset($_REQUEST["TxtAsignacion"])?$_REQUEST["TxtAsignacion"]:"";
	$bascula_entrada = isset($_REQUEST["bascula_entrada"])?$_REQUEST["bascula_entrada"]:"";
	$bascula_salida  = isset($_REQUEST["bascula_salida"])?$_REQUEST["bascula_salida"]:"";	

	CerrarLotesMensuales('R',$link);
	$Tolerancia = ToleranciaPesaje($link);
	/*
	if(isset($RNA))
	{
		setcookie("ROMANA",$RNA);
		$TxtNumRomana=$RNA;
	}
	if($RNA!='')	
	{	
		setcookie("ROMANA",$RNA);
		$TxtNumRomana=$RNA;
	}
	if($TxtNumRomana=='')
		$TxtNumRomana=$_COOKIE[ROMANA];
	*/
	
	if(isset($RNA) && $RNA!='')	
	{	
		setcookie("ROMANA",$RNA);
		$TxtNumRomana=$RNA;
	}
	$ROMANAS = isset($_COOKIE["ROMANA"])?$_COOKIE["ROMANA"]:"";
	if($TxtNumRomana==''){
		//$TxtNumRomana = $_COOKIE["ROMANA"];
		$TxtNumRomana = $ROMANAS;
		//$TxtNumRomana = isset($_COOKIE["ROMANA"])?$_COOKIE["ROMANA"]:"";
	}
    //echo "TxtNumRomana:".$TxtNumRomana;
	//echo "<br>TxtNumBascula:".$TxtNumBascula;
	$EstadoInput='';
	switch($TxtNumBascula)
	{
		case "1":
			$EstOptBascula='checked';
			$EstOptBascula2='';
			break;
		case "2":
			$EstOptBascula='';
			$EstOptBascula2='checked';
			break;
		default:
			$EstOptBascula='checked';
			$EstOptBascula2='';
			$TxtNumBascula='1';
			break;		
	}
	$TxtFecha        = date('Y-m-d');
	//$TxtHoraE=date('h:i:s');
	$TxtHoraE        = date('G:i:s');
	//$EstPatente='disabled';
	$EstBtnGrabar    = 'disabled';
	$EstBtnAnular    = 'disabled';
	$EstBtnImprimir  = 'disabled';
	$EstBtnModificar = 'disabled';
	$HabilitarCmb    = '';
	$RutOperador     = $CookieRut;
	$Mensaje = ''; $TotalLote=0;
	if($ObjFoco=="")
		$ObjFoco="TxtPatente";
	$Mostrar='N';$HabilitarText='';
	//DETERMINAR SI ES ENTRADA O SALIDA
	if($TipoProceso=="" && $TxtPatente<>"")
	{
		$Consulta="SELECT * from sipa_web.recepciones where patente = '".trim($TxtPatente)."' and peso_bruto<>'0' and ";
		$Consulta.="peso_tara='0' and peso_neto='0' and estado <> 'A' and tipo<>'A'";
		//echo "<br>".$Consulta;
		$Respuesta=mysqli_query($link, $Consulta);
		//$Fila=mysqli_fetch_array($Respuesta);
		//var_dump($Fila);
		if($Fila=mysqli_fetch_array($Respuesta))
			$TipoProceso='S';
		else
			$TipoProceso='E';
	}	

	function PatenteValida($Patente,$PatenteOk,$EstPatente)
	{
			$EstPatente='readonly';
			/*$Consulta="SELECT * from sipa_web.camion where patente='".$Patente."'";
			$Respuesta=mysqli_query($link, $Consulta);
			if($Fila=mysqli_fetch_array($Respuesta))
			{	
				$PatenteOk=true;
			}	
			else
			{	
				$PatenteOk=false;
				$Mensaje='Patente Camion No Registrada';
			}*/
			$PatenteOk=true;
			$Mensaje='';
			return $PatenteOk;
	}
	/*DEFINE SI ES ENTRADA O SALIDA*/
	//echo "TipoProceso:".$TipoProceso;
	//echo "<br>Proceso:".$Proceso;
	//echo "<br>PatenteOk:".$PatenteOk;
	switch($TipoProceso)
	{
		case "E":
			// echo "<br>Entroooo";
			// echo "<br>Proceso:".$Proceso;
			$EstBtnGrabar='';
			$PatenteOk='';
			$PatenteOk=PatenteValida($TxtPatente,$PatenteOk,$EstPatente);
			//echo "<br>PatenteOk:".$PatenteOk;
			if($PatenteOk==true)
			{ 
				//echo "<br>PPPPatenteOk:".$PatenteOk;
				//echo "<br>Proceso:".$Proceso;
				switch($Proceso)
				{
					case "B1"://LOTE NUEVO
						if($TxtPesoNeto=='')
							$TxtPesoNeto=0;
						if($TxtPesoTara=='')
							$TxtPesoTara=0;
						$AnoMes=substr(date('Y'),2,2).date('m');
						$Consulta="SELECT ifnull(max(lote)+1,'".$AnoMes."0001') as lote_nuevo from sipa_web.correlativo_lote where cod_proceso='R' and lote like '$AnoMes%'";
						//echo $Consulta;
						$Respuesta=mysqli_query($link, $Consulta);
						$Fila=mysqli_fetch_array($Respuesta);
						$TxtLote=str_pad($Fila["lote_nuevo"],8,'0',STR_PAD_LEFT);
						$TxtRecargo=1;
						$Consulta="SELECT ifnull(max(correlativo)+1,1) as correlativo from sipa_web.recepciones";
						$Respuesta=mysqli_query($link, $Consulta);
						$Fila=mysqli_fetch_array($Respuesta);
						$TxtCorrelativo=$Fila["correlativo"];
						$TxtFecha=date('Y-m-d');
						$TxtHoraE=date('G:i:s');
						$CmbLotes=$TxtLote;
						$bascula_entrada='';
						$bascula_salida='';
						$CodMina=explode('~',$CmbMinaPlanta);
						$CodMina1 = isset($CodMina[1])?$CodMina[1]:"";
						/*if($CmbProveedor=='90132000-4'&&$CodMina[1]=='13201.0003-8')
							$RutProveedor='90132000-5';
						else
							$RutProveedor=$CmbProveedor;*/
						$RutProveedor=$CmbProveedor;	
						$SuBProd=explode('~',$CmbSubProducto);
						$SuBProd0 = isset($SuBProd[0])?$SuBProd[0]:"";
						$SuBProd1 = isset($SuBProd[1])?$SuBProd[1]:"";
						CrearArchivoResp('R','E',$TxtCorrelativo,$TxtLote,'1',$CmbUltRecargo,$RutOperador,$TxtNumBascula,'',$TxtFecha,$TxtHoraE,'',$TxtPesoBruto,$TxtPesoTara,$TxtPesoNeto,$CmbProveedor,$CodMina1,$CmbGrupoProd,$SuBProd0,$SuBProd1,$TxtGuia,$TxtPatente,$CmbClase,$CmbConjunto,$TxtObs,'','','','','');
						$Insertar="INSERT INTO sipa_web.recepciones (correlativo,lote,recargo,ult_registro,rut_operador,bascula_entrada,bascula_salida,fecha,";
						$Insertar.="hora_entrada,peso_bruto,peso_tara,peso_neto,rut_prv,cod_mina,cod_grupo,cod_producto,cod_subproducto,guia_despacho,patente,cod_clase,conjunto,observacion) values(";
						$Insertar.="'$TxtCorrelativo','$TxtLote','1','$CmbUltRecargo','".$RutOperador."','$bascula_entrada','$bascula_salida','$TxtFecha',";
						$Insertar.="'$TxtHoraE','$TxtPesoBruto','$TxtPesoTara','$TxtPesoNeto','$RutProveedor','$CodMina1','$CmbGrupoProd','$SuBProd0','$SuBProd1',";
						$Insertar.="'$TxtGuia','".strtoupper(trim($TxtPatente))."','$CmbClase','$CmbConjunto','$TxtObs')";
						//echo $Insertar;
						mysqli_query($link, $Insertar);
						$Actualizar="UPDATE sipa_web.correlativo_lote set lote='$TxtLote' where cod_proceso='R'";
						mysqli_query($link, $Actualizar);
						PesoHistorico2('R',strtoupper(trim($TxtPatente)),$TxtPesoHistorico,$TxtPorcRango,'E',$SuBProd0,$SuBProd1,$link);
						$ObjFoco='TxtGuia';
						break;
					case "B2"://LOTE EXISTENTE ABIERTO
						if($TxtPesoNeto=='')
							$TxtPesoNeto=0;
						if($TxtPesoTara=='')
							$TxtPesoTara=0;
						$TipoProceso='E';//ENTRADA DE CAMION
						$AnoMes=substr(date('Y'),3,1).date('m');
						$Consulta="SELECT  max(lpad(recargo,2,'0'))+1 as recargo_nuevo,cod_producto,cod_subproducto,rut_prv,cod_mina,correlativo,fecha,hora_entrada,hora_salida,conjunto,cod_clase ";
						$Consulta.="from sipa_web.recepciones where lote = '".$CmbLotes."' group by lote";
						//echo $Consulta;
						$Respuesta=mysqli_query($link, $Consulta);
						$Fila=mysqli_fetch_array($Respuesta);
						$TxtLote=$CmbLotes;
						$TxtRecargo=isset($Fila["recargo_nuevo"])?$Fila["recargo_nuevo"]:"";
						$Consulta="SELECT  cod_producto,cod_subproducto,rut_prv,cod_mina,correlativo,fecha,hora_entrada,hora_salida,conjunto,cod_clase ";
						$Consulta.="from sipa_web.recepciones where lote = '".$CmbLotes."' and recargo='1'";
						//echo $Consulta;
						$Respuesta=mysqli_query($link, $Consulta);
						$Fila=mysqli_fetch_array($Respuesta);
						//$TxtFecha=date('Y-m-d');
						//$TxtHoraE=date('h:i:s');
						$cod_producto    = isset($Fila["cod_producto"])?$Fila["cod_producto"]:"";
						$cod_subproducto = isset($Fila["cod_subproducto"])?$Fila["cod_subproducto"]:"";
						$rut_prv         = isset($Fila["rut_prv"])?$Fila["rut_prv"]:"";
						$cod_mina        = isset($Fila["cod_mina"])?$Fila["cod_mina"]:"";
						$conjunto        = isset($Fila["conjunto"])?$Fila["conjunto"]:"";
						$CmbSubProducto  =$cod_producto.'~'.$cod_subproducto;
						$CmbProveedor    = isset($Fila["rut_prv"])?$Fila["rut_prv"]:"";
						$Consulta = "SELECT fecha_padron from sipa_web.minaprv where rut_prv='".$CmbProveedor."' and cod_mina='".$cod_mina."'";
						$RespPadron=mysqli_query($link, $Consulta);
						$FilaPadron=mysqli_fetch_array($RespPadron);
						$TxtVencPadron = isset($FilaPadron["fecha_padron"])?$FilaPadron["fecha_padron"]:"";
						$fecha_padron  = isset($FilaPadron["fecha_padron"])?$FilaPadron["fecha_padron"]:"";
					
						$CmbMinaPlanta=$rut_prv."~".$cod_mina."~".$fecha_padron."~".$conjunto;
						$CmbConjunto=isset($Fila["conjunto"])?$Fila["conjunto"]:"";
						$CmbClase=isset($Fila["cod_clase"])?$Fila["cod_clase"]:"";
						$Consulta="SELECT ifnull(max(correlativo)+1,1) as correlativo from sipa_web.recepciones";
						$Respuesta=mysqli_query($link, $Consulta);
						$Fila=mysqli_fetch_array($Respuesta);
						$TxtCorrelativo=$Fila["correlativo"];
						$CodMina=explode('~',$CmbMinaPlanta);
						$CodMina1 = isset($CodMina[1])?$CodMina[1]:"";
						/*if($CmbProveedor=='90132000-4'&&$CodMina[1]=='13201.0003-8')
							$RutProveedor='90132000-5';
						else
							$RutProveedor=$CmbProveedor;*/
						$RutProveedor=$CmbProveedor;	
						$SuBProd=explode('~',$CmbSubProducto);
						$SuBProd0 = isset($SuBProd[0])?$SuBProd[0]:"";
						$SuBProd1 = isset($SuBProd[1])?$SuBProd[1]:"";
						CrearArchivoResp('R','E',$TxtCorrelativo,$TxtLote,$TxtRecargo,$CmbUltRecargo,$RutOperador,$TxtNumBascula,'',$TxtFecha,$TxtHoraE,'',$TxtPesoBruto,$TxtPesoTara,$TxtPesoNeto,$CmbProveedor,$CodMina1,$CmbGrupoProd,$SuBProd0,$SuBProd1,$TxtGuia,$TxtPatente,$CmbClase,$CmbConjunto,$TxtObs,'','','','','');
						
						$Insertar="INSERT INTO sipa_web.recepciones (correlativo,lote,recargo,ult_registro,rut_operador,bascula_entrada,bascula_salida,fecha,";
						$Insertar.="hora_entrada,peso_bruto,peso_tara,peso_neto,rut_prv,cod_mina,cod_grupo,cod_producto,cod_subproducto,guia_despacho,patente,cod_clase,conjunto,observacion) values(";
						$Insertar.="'$TxtCorrelativo','$TxtLote','$TxtRecargo','$CmbUltRecargo','".$RutOperador."','$bascula_entrada','$bascula_salida','$TxtFecha',";
						$Insertar.="'$TxtHoraE','$TxtPesoBruto','$TxtPesoTara','$TxtPesoNeto','$RutProveedor','$CodMina1','$CmbGrupoProd','$SuBProd0','$SuBProd1',";
						$Insertar.="'$TxtGuia','".strtoupper(trim($TxtPatente))."','$CmbClase','$TxtConjunto','$TxtObs')";
						mysqli_query($link, $Insertar);
						
						PesoHistorico2('R',strtoupper(trim($TxtPatente)),$TxtPesoHistorico,$TxtPorcRango,'E',$SuBProd0,$SuBProd1,$link);
						$ObjFoco='TxtObs';
						break;	
				}
			}
			break;
		case "S"://SALIDA DEL CAMION
			$EstBtnGrabar='';
			$EstBtnAnular='';
			$EstBtnImprimir='';
			$PatenteOk='';
			$PatenteOk = PatenteValida($TxtPatente,$PatenteOk,$EstPatente);
			if($PatenteOk==true)
			{
				$ObjFoco="TxtCorrelativo";
				$TitCmbCorr=" Corr - Lote - Rec - Prod";
				switch($Proceso)
				{
					case "BC"://BUSCAR CORRELATIVO
						if($TxtPesoTara=='')
							$TxtPesoTara=0;

						$Datos=explode('~',$TxtCorrelativo);	
						$Consulta ="SELECT distinct t1.lote,t1.recargo,t1.correlativo,t1.cod_grupo,t1.cod_producto,t1.cod_subproducto,t1.rut_prv,t1.cod_mina,t1.fecha,t1.hora_entrada,t1.hora_salida,t1.conjunto,t1.cod_clase,";
						$Consulta.="t1.peso_bruto,t1.guia_despacho,t1.observacion,t1.ult_registro,t1.leyes,t1.impurezas from sipa_web.recepciones t1 ";
						$Consulta.="where lote = '".$Datos[0]."' and patente='".$TxtPatente."' and correlativo='".$Datos[2]."'";
						//echo $Consulta;
						$Resp2 = mysqli_query($link, $Consulta);
						while($Fila = mysqli_fetch_array($Resp2))
						{
							$TxtCorrelativo=$Fila["lote"].'~'.$Fila["recargo"].'~'.$Fila["correlativo"];
							$TxtGuia=$Fila["guia_despacho"];
							$TxtLote=$Fila["lote"];
							$TxtRecargo=$Fila["recargo"];
							$TxtFecha=$Fila["fecha"];
							$TxtHoraE=$Fila["hora_entrada"];
							$TxtHoraS=date('G:i:s');
							$TxtPesoBruto=$Fila["peso_bruto"];
							$TxtPesoNeto=abs($Fila["peso_bruto"]-$TxtPesoTara);
							$CmbGrupoProd=$Fila["cod_grupo"];
							$CmbSubProducto=$Fila["cod_producto"]."~".$Fila["cod_subproducto"];
							/*if($CmbProveedor=='90132000-5')
								$CmbProveedor='90132000-4';*/
							$CmbProveedor=$Fila["rut_prv"];
							$Consulta = "SELECT fecha_padron from sipa_web.minaprv where rut_prv='".$CmbProveedor."' and cod_mina='".$Fila["cod_mina"]."'";
							//echo $Consulta."<br>";
							$RespPadron=mysqli_query($link, $Consulta);
							$FilaPadron=mysqli_fetch_array($RespPadron);
							$TxtVencPadron=isset($FilaPadron["fecha_padron"])?$FilaPadron["fecha_padron"]:"";
							$rut_prv =isset($Fila["rut_prv"])?$Fila["rut_prv"]:"";
							$cod_mina=isset($Fila["cod_mina"])?$Fila["cod_mina"]:"";
							$conjunto=isset($Fila["conjunto"])?$Fila["conjunto"]:"";
							$CmbMinaPlanta=$rut_prv."~".$cod_mina."~".$TxtVencPadron."~".$conjunto;
							//$CmbMinaPlanta=$Fila["rut_prv"]."~".$Fila["cod_mina"]."~".$FilaPadron["fecha_padron"]."~".$Fila["conjunto"];
							//echo $CmbMinaPlanta;
							$CmbUltRecargo=$Fila["ult_registro"];
							$CmbConjunto=$Fila["conjunto"];
							$CmbClase=$Fila["cod_clase"];
							$TxtLeyes=$Fila["leyes"];
							$TxtImpurezas=$Fila["impurezas"];
							$TxtObs=$Fila["observacion"];
							PesoHistorico('R',$TxtPatente,$TxtPesoHistorico,$TxtPorcRango,'S',$Fila["cod_producto"],$Fila["cod_subproducto"],$link);
							$HabilitarCmb='disabled';
							$HabilitarText='readonly';
							$ObjFoco='TxtObs';
						}	
						break;
				}	
			}	
			break;	
	}
	//if(($TipoProceso=='E')&&(isset($CmbSubProducto)&&isset($CmbProveedor)))
	if(($TipoProceso=='E')&&($CmbSubProducto!="" && $CmbProveedor!=""))
	{
		if($TxtLote=='')
		{
			$SubProd=explode('~',$CmbSubProducto);
			$SubProd0 = isset($SubProd[0])?$SubProd[0]:"";
			$SubProd1 = isset($SubProd[1])?$SubProd[1]:"";
			$Consulta = "SELECT leyes,impurezas from age_web.relaciones ";
			$Consulta.= " where cod_producto='".$SubProd0."' and cod_subproducto='".$SubProd1."' and rut_proveedor='".$CmbProveedor."'";
			$Respuesta=mysqli_query($link, $Consulta);
			if($Fila=mysqli_fetch_array($Respuesta))
			{
				$TxtLeyes=$Fila["leyes"];
				if($TxtHumedad=='S')
					$TxtImpurezas="01~".$Fila["impurezas"];
				else
					$TxtImpurezas=$Fila["impurezas"];
			}					
		}
	}
	//$Proceso='';
	//if(isset($CmbGrupoProd))
	if($CmbGrupoProd!="")
	{
		$Consulta="SELECT abast_minero from sipa_web.grupos_productos where cod_grupo='".$CmbGrupoProd."'";
		$RespGrupo=mysqli_query($link, $Consulta);
		$FilaGrupo=mysqli_fetch_array($RespGrupo);
		$AbastMinero=isset($FilaGrupo["abast_minero"])?$FilaGrupo["abast_minero"]:"";
		if($AbastMinero=='N')
			$BuscarPrv='S';
	}
	//if(isset($BuscarPrv) && $BuscarPrv=='S')
	if($BuscarPrv!="" && $BuscarPrv=='S')
	{
		$Consulta = "SELECT * from sipa_web.proveedores where rut_prv='".$CmbProveedor."'";
		$Respuesta=mysqli_query($link, $Consulta);
		if($Fila=mysqli_fetch_array($Respuesta))
		{
			$TxtNombrePrv=$Fila["nombre_prv"];
			$ObjFoco='CmbLotes';
			if($TipoProceso=='S')
				$ObjFoco='TxtObs';
		}	
		else
			if($CmbSubProducto!='S' && $CmbProveedor!='')
				$ObjFoco='TxtNombrePrv';	
	}
?>	
<html><head>
<title>Recepcion v6 20161215 - Tolerancia <?php echo $Tolerancia; ?></title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script src="../principal/funciones/libs/jquery-3.5.1/jquery.min.js"></script>
<script src="../principal/funciones/funciones_java.js" language="javascript"></script>

<script language="javascript">
var OK;
var OTS = "";
ns4 = (document.layers)? true:false;
ie4 = (document.all)? true:false;
var digitos=20; //cantidad de digitos buscados 
var puntero=0; 
var buffer=new Array(digitos); //declaraci�n del array Buffer 
var cadena="";
let valor22;
valor22 = setInterval(RestaurarBascula,1000);
console.log(valor22);
function Habilita(Bascula)
{
	//var f = document.FrmRecepcion;
	document.getElementById(Bascula).src = "btn_verde.png";
	document.getElementById(Bascula).alt = "Bascula Habilitada";
	//f.TxtPesoBruto.value = '';	
		
}
function Deshabilita(Bascula)
{
	document.getElementById(Bascula).src = "btn_rojo.png";
	document.getElementById(Bascula).alt = "Bascula Ocupada";
		
}
function RestaurarBascula()
{
	var Bas2=0;
    var Bas1=0;
	var f = document.FrmRecepcion;
	//var Bas1=LeerArchivo2(''); //C:\\PesoMatic2.txt
	//var Bas2=LeerArchivo('');//C:\\PesoMatic.txt
	//var bascula = f.TxtBasculaAux.value; //
	var bascula = f.TxtNumBascula.value; //
	var Romana  = f.TxtNumRomana.value; //
	//alert("bascula:"+bascula);
	//alert("Romana:"+Romana);
	if(Romana==1){
		console.log("Roma1");
		Bas1 = LeerArchivo('configuracion_pesaje','PesoMatic2_1.txt',0,'S');
		Bas2 = LeerArchivo('configuracion_pesaje','PesoMatic_1.txt',0,'S');
	}
	
	if(Romana==2){
		console.log("Roma2");
		Bas1 = LeerArchivo('configuracion_pesaje','PesoMatic2_2.txt',0,'S');
		Bas2 = LeerArchivo('configuracion_pesaje','PesoMatic_2.txt',0,'S');
	}

   // alert("Tolerancia:"+Tolerancia);
	//alert("Bas1:"+Bas1+" Bas2:"+Bas2);
	//alert("Bas2:"+Bas2);
	console.log("Romana:"+Romana);
	console.log("Bascula:"+bascula);
	console.log("Bas1:"+Bas1);
	console.log("Bas2:"+Bas2);
	console.log("Tolerancia:"+<?php echo $Tolerancia; ?>);
	console.log("TipoProceso:"+f.TipoProceso.value);
	if(Bas1 <= parseInt('<?php echo $Tolerancia; ?>'))
	{
		f.Bloq1.value='';
		Habilita('BasculaA');
		console.log("BasculaA Habilitado");
		if(f.TipoProceso.value=='E' && Bas1 == '0' && bascula =='1')
		{
			console.log("Lipiar PB");
			f.TxtPesoBruto.value = '';
		}
		if(f.TipoProceso.value=='S' && Bas1 == '0' && bascula =='1')
		{
			console.log("Lipiar PT");
			f.TxtPesoTara.value = '';
			f.TxtPesoNeto.value  = f.TxtPesoBruto.value;
			f.TxtPNetoTot.value  = f.TxtPesoBruto.value;
		}
		
	}
	if(Bas2 <= parseInt('<?php echo $Tolerancia; ?>'))
	{
		f.Bloq2.value='';	
		Habilita('BasculaB');
		console.log("BasculaB Habilitado");
		if(f.TipoProceso.value=='E' && Bas2 == '0' && bascula =='2')
		{
			f.TxtPesoBruto.value = '';
		}
		if(f.TipoProceso.value=='S' && Bas2 == '0' && bascula =='2')
		{
			console.log("Lipiar PT");
			f.TxtPesoTara.value = '';
			f.TxtPesoNeto.value  = f.TxtPesoBruto.value;
			f.TxtPNetoTot.value  = f.TxtPesoBruto.value;
		}

	}
	if(f.TipoProceso.value=='E') //Entrada P.Bruto
	{
		if(f.TxtNumBascula.value=='1') 
		{	
			if(f.Bloq1.value=='')	
			{	f.BtnPBruto.disabled=false;
			
			}
		}
		if(f.TxtNumBascula.value=='2')
		{
			if(f.Bloq2.value=='')	
			{
					f.BtnPBruto.disabled=false;
			}
		}
	}
	if(f.TipoProceso.value=='S') //salida P.Tara
	{
		if(f.TxtNumBascula.value=='1')
		{
			if( f.Bloq1.value=='')	
			{
				f.BtnPTara.disabled=false;
			}
		}
		if(f.TxtNumBascula.value=='2')
		{
			if(f.Bloq2.value=='')	
			{
				f.BtnPTara.disabled=false;
			}
		}
	}
	
}

var ROMA = '<?php echo LeerRomana($IP,$link); ?>'; 

function muestra(numero) 
{
 	if (ns4){ 
 		eval("document. " + numero + ".visibility = 'show'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'visible'");
			eval("Txt" + numero + ".style.left = 450 ");
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
function PesoAutomatico()
{
	setTimeout("CapturaPeso()",500);
	//setTimeout(CapturaPeso,500);
}	
/*****************/
function CapturaPeso(tipo)
{
	var f = document.FrmRecepcion;
	var PesoRangoIni =0;
	var PesoRangoFin =0;
	var PorcPeso =0;
	var valor = 0;
	//f.TxtNumRomana
	//alert("Tipo Proceso:"+tipo);
	switch(tipo)
	{
		case "PB":
			f.TipoProceso.value="E";
			if(f.TxtNumRomana.value=='1')
			{
				if(f.TxtNumBascula.value=='1')
				{	
					if(f.Bloq1.value=='S')
					{
						alert("Báscula "+f.TxtBasculaAux.value+" Debe estabilizarse en cero antes de continuar. \nSolicite sacar vehiculo de la báscula.")
					}else{				
						//f.TxtPesoBruto.value = '<?php echo LeerArchivo('configuracion_pesaje','PesoMatic2_1.txt'); ?>';
						valor = LeerArchivo('configuracion_pesaje','PesoMatic2_1.txt',0,'S');
					    f.TxtPesoBruto.value = valor;
						f.Bloq1.value='S';
						Deshabilita('BasculaA');
						f.BtnPBruto.disabled=true;			
					}
				}else{
					if(f.Bloq2.value=='S')
					{
						alert("Báscula "+f.TxtBasculaAux.value+" Debe estabilizarse en cero antes de continuar. \nSolicite sacar vehiculo de la báscula.")
					}
					else
					{
						//f.TxtPesoBruto.value = '<?php echo LeerArchivo('configuracion_pesaje','PesoMatic_1.txt'); ?>';
						valor = LeerArchivo('configuracion_pesaje','PesoMatic_1.txt',0,'S');
					    f.TxtPesoBruto.value = valor;
						f.Bloq2.value='S';
						Deshabilita('BasculaB');					
						f.BtnPBruto.disabled=true;
					}					
				}
			}
			
			if(f.TxtNumRomana.value=='2')
			{
				if(f.TxtNumBascula.value=='1')
				{	
					if(f.Bloq1.value=='S')
					{
						alert("Báscula "+f.TxtBasculaAux.value+" Debe estabilizarse en cero antes de continuar. \nSolicite sacar vehiculo de la báscula.")
					}else{				
						//f.TxtPesoBruto.value = '<?php echo LeerArchivo('configuracion_pesaje','PesoMatic2_2.txt'); ?>';
						valor = LeerArchivo('configuracion_pesaje','PesoMatic2_2.txt',0,'S');
					    f.TxtPesoBruto.value = valor;
						f.Bloq1.value='S';
						Deshabilita('BasculaA');
						f.BtnPBruto.disabled=true;			
					}
				}else{
					//alert("BASCULA 2(4) SELECCIONADA");
					if(f.Bloq2.value=='S')
					{
						alert("Báscula "+f.TxtBasculaAux.value+" Debe estabilizarse en cero antes de continuar. \nSolicite sacar vehiculo de la báscula.")
					}
					else
					{
						//f.TxtPesoBruto.value = '<?php echo LeerArchivo('configuracion_pesaje','PesoMatic_2.txt'); ?>';
						valor = LeerArchivo('configuracion_pesaje','PesoMatic_2.txt',0,'S');
					    f.TxtPesoBruto.value = valor;
						f.Bloq2.value='S';
						Deshabilita('BasculaB');					
						f.BtnPBruto.disabled=true;
					}					
				}
			}
			
			if(parseInt(f.TxtPesoHistorico.value)!=0)
			{	
				PorcPeso=parseInt((f.TxtPorcRango.value*f.TxtPesoHistorico.value)/100);
				//alert(PorcPeso);
				PesoRangoIni=parseInt(parseInt(f.TxtPesoHistorico.value)-PorcPeso);
				PesoRangoFin=parseInt(parseInt(f.TxtPesoHistorico.value)+PorcPeso);
				//alert('Rangos Taras:'+PesoRangoIni+' '+PesoRangoFin);
				if((parseInt(f.TxtPesoBruto.value)<PesoRangoIni)||(parseInt(f.TxtPesoBruto.value)>PesoRangoFin))			
				{
					alert('ATENCION!!!! Peso Bruto no esta dentro del Rango de Peso Bruto Historico');
				}
			}				
			//if(f.TxtPesoBruto.value!=0&&f.TxtPesoTara.value!=0)	
			//	f.TxtPesoNeto.value=f.TxtPesoBruto.value-f.TxtPesoTara.value;
			CalculaPNeto();
			if(f.CmbLotes.disabled==true)
				f.BtnGrabar.focus();	
			else
				f.CmbLotes.focus();	
			break;
		case "PT":
			f.TipoProceso.value="S";
			if(f.TxtNumRomana.value=='1')
			{
				if(f.TxtNumBascula.value=='1')
				{	
					if(f.Bloq1.value=='S')
					{
						alert("Báscula "+f.TxtBasculaAux.value+" Debe estabilizarse en cero antes de continuar. \nSolicite sacar vehiculo de la báscula.")
					}else{
						//f.TxtPesoTara.value ='<?php echo LeerArchivo('configuracion_pesaje','PesoMatic2_1.txt'); ?>';
						valor = LeerArchivo('configuracion_pesaje','PesoMatic2_1.txt',0,'S');
					    f.TxtPesoTara.value = valor;
						f.Bloq1.value='S';
						Deshabilita('BasculaA');					
						f.BtnPTara.disabled=true;		
					}
				}else{
					if(f.Bloq2.value=='S')
					{
						alert("Báscula "+f.TxtBasculaAux.value+" Debe estabilizarse en cero antes de continuar. \nSolicite sacar vehiculo de la báscula.")
					}
					else
					{
						//f.TxtPesoTara.value ='<?php echo LeerArchivo('configuracion_pesaje','PesoMatic_1.txt'); ?>';
						valor = LeerArchivo('configuracion_pesaje','PesoMatic_1.txt',0,'S');
						f.TxtPesoTara.value = valor;
						f.Bloq2.value='S';
						Deshabilita('BasculaB');					
						f.BtnPTara.disabled=true;
					}					
				}
			}
			
			if(f.TxtNumRomana.value=='2')
			{  //alert("ROMANA 2");
				if(f.TxtNumBascula.value=='1')
				{	
					if(f.Bloq1.value=='S')
					{
						alert("Báscula "+f.TxtBasculaAux.value+" Debe estabilizarse en cero antes de continuar. \nSolicite sacar vehiculo de la báscula.")
					}else{
						//f.TxtPesoTara.value ='<?php echo LeerArchivo('configuracion_pesaje','PesoMatic2_2.txt'); ?>';
						valor = LeerArchivo('configuracion_pesaje','PesoMatic2_2.txt',0,'S');
					    f.TxtPesoTara.value = valor;
						f.Bloq1.value='S';
						Deshabilita('BasculaA');					
						f.BtnPTara.disabled=true;		
					}
				}else{
					if(f.Bloq2.value=='S')
					{
						alert("Báscula "+f.TxtBasculaAux.value+" Debe estabilizarse en cero antes de continuar. \nSolicite sacar vehiculo de la báscula.")
					}
					else
					{
7						//f.TxtPesoTara.value ='<?php echo LeerArchivo('configuracion_pesaje','PesoMatic_2.txt'); ?>';
						valor = LeerArchivo('configuracion_pesaje','PesoMatic_2.txt',0,'S');
						f.TxtPesoTara.value = valor;
						f.Bloq2.value='S';
						Deshabilita('BasculaB');					
						f.BtnPTara.disabled=true;
					}					
				}
			}
			
			
		/*	if(f.TxtNumBascula.value=='1')			
				f.TxtPesoTara.value = LeerArchivo2(f.TxtPesoTara.value);
			else
				f.TxtPesoTara.value = LeerArchivo(f.TxtPesoTara.value);*/
			if(parseInt(f.TxtPesoHistorico.value)!=0)
			{	
				PorcPeso=parseInt((f.TxtPorcRango.value*f.TxtPesoHistorico.value)/100);
				//alert(PorcPeso);
				PesoRangoIni=parseInt(parseInt(f.TxtPesoHistorico.value)-PorcPeso);
				PesoRangoFin=parseInt(parseInt(f.TxtPesoHistorico.value)+PorcPeso);
				//alert('Rangos Taras:'+PesoRangoIni+' '+PesoRangoFin);
				if((parseInt(f.TxtPesoTara.value)<PesoRangoIni)||(parseInt(f.TxtPesoTara.value)>PesoRangoFin))			
				{
					alert('ATENCION!!!! Peso Tara no esta dentro del Rango de Peso Tara Historico');
				}
			}	
			//if(f.TxtPesoBruto.value!=0&&f.TxtPesoTara.value!=0)	
			//	f.TxtPesoNeto.value=f.TxtPesoBruto.value-f.TxtPesoTara.value;
			CalculaPNeto();
			f.BtnGrabar.focus();	
			break;
	}	
	//setTimeout("CapturaPeso()",200);
	f.TxtPatente.disabled='';
	
		
}

function buscar_op(obj,objfoco,InicioBusq,Recargar){ 
   var f = document.FrmRecepcion;
   var letra = String.fromCharCode(event.keyCode) 
   if(puntero >= digitos){ 
       cadena=""; 
       puntero=0; 
    }
   //si se presiona la tecla ENTER, borro el array de teclas presionadas y salto a otro objeto... 
   if (event.keyCode == 13||event.keyCode == 27)
   { 
       borrar_buffer(); 
       if(event.keyCode != 27&&objfoco!=0) //evita foco a otro objeto si objfoco=0 
		if(Recargar=='S')
			Recarga(objfoco);	   
		else
		   objfoco.focus(); 
    } 
   //sino busco la cadena tipeada dentro del combo... 
   else{ 
       buffer[puntero]=letra; 
       //guardo en la posicion puntero la letra tipeada 
       cadena=cadena+buffer[puntero]; //armo una cadena con los datos que van ingresando al array 
       puntero++; 

       //barro todas las opciones que contiene el combo y las comparo la cadena... 
       for (var opcombo=0;opcombo < obj.length;opcombo++){ 
          if(obj[opcombo].text.substr(InicioBusq,puntero).toLowerCase()==cadena.toLowerCase()){ 
          obj.SELECTedIndex=opcombo; 
          } 
       } 
    } 
   event.returnValue = false; //invalida la acci�n de pulsado de tecla para evitar busqueda del primer caracter 

} 

function borrar_buffer(){ 
   //inicializa la cadena buscada 
    cadena=""; 
    puntero=0;
}
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
function Proceso(opt,ObjFoco,opt2)
{
	var f = document.FrmRecepcion;
	var Valores='';
	//alert(f.TipoProceso.value);
	switch (opt)
	{
		case "R"://REINICIAR
		     f.TxtPesoTara.value ='<?php echo LeerArchivo('configuracion_pesaje','PesoMatic2_1.txt',0,'S'); ?>';
			break;
		case "G"://ACTUALIZAR RECEPCION
			if(ValidarCampos('G'))
			{
				if(f.ValidaPadronMin.value=='S'&&f.TxtVencPadron.value+"31" < '<?php echo date("Y-m-d");?>')
				{
				
					alert('La Fecha de Padron Minero Se Encuentra Vencida');
					//return;
				}
				//else
				//{
					f.BtnGrabar.disabled=true;
					f.action = "rec_recepcion01.php?Proceso="+opt2;
					f.submit();	
				//}			
			}
			break;
		case "B"://BUSCA LOTE NUEVO O LOTE EXISTENTE
			if(ValidarCampos(''))
			{
				//alert("OHH");
				if(f.CmbLotes.value=='S')
					return;
				if(f.CmbLotes.value=='-1')//ES LOTE NUEVO
					f.action = "rec_recepcion.php?Proceso=B1";
				else
					f.action = "rec_recepcion.php?Proceso=B2";//LOTE INGRESADO
				f.submit();	
			}
			break;
		case "BC":
			if(f.TxtCorrelativo.value!='S')
			{
				f.action = "rec_recepcion.php?Proceso=BC&ObjFoco="+ObjFoco.name;//BUSCAR CORRELATIVO
				f.submit();	
			}	
			break;	
		case "I"://IMPRIMIR
			f.action = "rec_recepcion01.php?Proceso=I";
			f.submit();	

			/*if(f.TxtLote.value=='')
			{
				alert('No hay Correlativo para Imprimir');
				f.TxtCorrelativo.focus();
				return;
			}
			else
			{
				f.action = "rec_recepcion01.php?Proceso=I";
				f.submit();	
			}					*/
			break;	
		case "S"://SALIR
			f.action = "../principal/sistemas_usuario.php?CodSistema=24";
			f.submit();
			break;
		case "C"://CANCELAR
			f.action = "rec_recepcion01.php?Proceso=C";
			f.submit();	
			break;
		case "M"://MODIFICAR
			f.TipoProceso.value="S";
			if(f.TxtLote.value=='')
			{
				alert('No hay Correlativo para Modificar');
				f.TxtCorrelativo.focus();
				return;
			}
			else
			{
				f.action = "rec_recepcion01.php?Proceso=M";
				f.submit();	
			}	
			break;
		case "A"://ANULAR
			if(f.TxtLote.value=='')
			{
				alert('No hay Correlativo para Anular');
				f.TxtCorrelativo.focus();
				return;
			}
			else
			{
				f.action = "rec_recepcion01.php?Proceso=A";
				f.submit();	
			}	
			break;
	}
}
function Recarga(ObjFoco,Tipo)
{
	var f = document.FrmRecepcion;
	
	if(f.TxtPatente.value==''&&Tipo=='S')
		return true;
	f.action = "rec_recepcion.php?ObjFoco="+ObjFoco.name;
	f.submit();		
}
function ValidarCampos(ProcesoValid)
{
	var f = document.FrmRecepcion;
	var Validado=true;

	if((ProcesoValid)=='G' && (f.TxtCorrelativo.value==''||f.TxtCorrelativo.value=='S'))
	{
		alert('No hay Correlativo para Grabar');
		f.TxtPatente.focus();
		Validado=false;
		return;
	}
	if(f.TxtPatente.value=='')
	{
		alert('Debe Ingresar Patente');
		f.TxtPatente.focus();
		Validado=false;
		return;
	}

	if(f.TxtGuia.value=='')
	{
		alert('Debe Ingresar Guia de Despacho');
		f.TxtGuia.focus();
		Validado=false;
		return;
	}
	if(f.TipoProceso.value=='E' && f.TxtPesoBruto.value=='')
	{
		alert('Debe Ingresar Peso Bruto');
		f.BtnPBruto.focus();
		f.CmbLotes.SELECTedIndex=0; 
		Validado=false;
		return;
	}
	if(f.TipoProceso.value=='S' && f.TxtPesoTara.value=='')
	{
		alert('Debe Ingresar Peso Tara');
		f.BtnPTara.focus();
		Validado=false;
		return;
	}
	if(f.CmbSubProducto.value=='S')
	{
		alert('Debe Seleccionar Producto');
		f.CmbSubProducto.focus();
		Validado=false;
		return;
	}

	if(f.CmbProveedor.value=='S'||f.CmbProveedor.value=='')
	{
		alert('Debe Seleccionar Proveedor');
		f.CmbProveedor.focus();
		Validado=false;
		return;
	}
	try
	{
		if(f.CmbMinaPlanta.value=='S')
		{
			alert('Debe Seleccionar Mina/Planta');
			f.CmbMinaPlanta.focus();
			Validado=false;
			return;
		}
		if(f.CmbConjunto.value=='')
		{
			alert('Conjunto No Asociado a Mina/Planta');
			f.CmbConjunto.focus();
			Validado=false;
			return;
		}
		if(f.TxtLeyes.value=='')
		{
			alert('No hay leyes registradas para este Producto y Proveedor');
			f.CmbLotes.value='S';
			f.CmbLotes.focus();
			return;
		}
	}	
	catch (e)
	{
	}	
	return(Validado);
}
function ObtenerFecPadronConj()
{
	var f = document.FrmRecepcion;
	if(f.CmbMinaPlanta.value!='S')
	{
		var Datos=f.CmbMinaPlanta.value.split('~');
		f.TxtVencPadron.value=Datos[2];
		f.CmbConjunto.value=Datos[3];
	}	
}
function MM_jumpMenu(targ,selObj,restore)
{ //v3.0
  eval(targ+".location='"+selObj.options[selObj.SELECTedIndex].value+"'");
  if (restore) selObj.SELECTedIndex=0;
}
function SeleccionRomana(tipo)
{
	var f = document.FrmRecepcion;
	f.BtnPBruto.disabled=true;
	f.BtnPTara.disabled=true;
	window.open("rec_seleccion_romana.php?tipo="+tipo+"&Frm="+f.name,"","top=210,left=200,width=400,height=200,scrollbars=no,resizable=no,status=yes");
	
}
function SeleccionBascula(NumBascula)
{
	var f = document.FrmRecepcion;
	f.TxtNumBascula.value=NumBascula;
	if(f.TxtNumRomana.value=='1' && f.TxtNumBascula.value=='1')	
	{	//f.TxtBasculaAux.style.background='#FF0000';
		f.TxtBasculaAux.value=1;
	}
	if(f.TxtNumRomana.value=='1' && f.TxtNumBascula.value=='2')	
	{	//f.TxtBasculaAux.style.background='#009933';
		f.TxtBasculaAux.value=2;
	}
	if(f.TxtNumRomana.value=='2' && f.TxtNumBascula.value=='1')	
	{	//f.TxtBasculaAux.style.background='#FF0000';
		f.TxtBasculaAux.value=3;
	}
	if(f.TxtNumRomana.value=='2' && f.TxtNumBascula.value=='2')	
	{	//f.TxtBasculaAux.style.background='#009933';
		f.TxtBasculaAux.value=4;
	}
	if(f.TipoProceso.value=='E')
	{
		f.TxtPesoBruto.value="";
		f.BtnPBruto.disabled=false;
		if(f.TxtNumBascula.value=='1' && f.Bloq1.value=='S')
		{	f.BtnPBruto.disabled=true;
	
		}
		if(f.TxtNumBascula.value=='2' && f.Bloq2.value=='S')
		{	f.BtnPBruto.disabled=true;
	
		}
	}
	if(f.TipoProceso.value=='S')
	{
		f.TxtPesoTara.value='';
		f.BtnPTara.disabled=false;

		if(f.TxtNumBascula.value=='1' && f.Bloq1.value=='S')
		{	f.BtnPTara.disabled=true;
		
		}if(f.TxtNumBascula.value=='2' && f.Bloq2.value=='S')
		{
			f.BtnPTara.disabled=true;
		}
	}
	
}
function BuscarProveedor()
{
	var f = document.FrmRecepcion;
	
	if(f.CmbProveedor.value!='S'&&f.CmbProveedor.value!='')
	{
		f.action = "rec_recepcion.php?BuscarPrv=S";
		f.submit();		
	}	
}
function CalculaPNeto()
{
	var f = document.FrmRecepcion;

	if(f.TxtPesoBruto.value!=''&&f.TxtPesoTara.value!='')
		f.TxtPesoNeto.value = f.TxtPesoBruto.value-f.TxtPesoTara.value;
	CalculaPNetoTotal();
}
function CalculaPNetoTotal()
{
	var f = document.FrmRecepcion;
	
	if(f.TxtPesoTotalNeto.value!='' && f.TxtPesoNeto.value!='')
		f.TxtPNetoTot.value=parseInt(f.TxtPesoTotalNeto.value)+parseInt(f.TxtPesoNeto.value);
	else
		if(f.TxtPesoTotalNeto.value!='')
			f.TxtPNetoTot.value=parseInt(f.TxtPesoTotalNeto.value);
}
function SelecLeyes()
{
	var f = document.FrmRecepcion;

	URL="rec_seleccion_leyes.php?CodLeyes="+f.TxtLeyes.value+"&CodImpurezas="+f.TxtImpurezas.value;
	window.open(URL,"","top=30,left=30,width=600,height=500,status=yes,scrollbars=yes,resizable=yes");
	
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.Estilo2 {color: #FF0000}
</style></head>
<body <?php echo 'onload=window.document.FrmRecepcion.'.$ObjFoco.'.focus()'?>>
<form action="" method="post" name="FrmRecepcion" >
<?php
	include("../principal/encabezado.php");
	if($TipoProceso=="")
		echo "<input type='hidden' name='TipoProceso' value=''>";
	else
		echo "<input type='hidden' name='TipoProceso' value='$TipoProceso'>";
?>
<table class="TablaPrincipal" width="770" height="330" cellpadding="0" cellspacing="0" >
	<tr>
	  <td width="760" height="330" align="center" valign="top"><br>
<table width="700"  border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#000000" class="TablaInterior">
  <tr class="ColorTabla01">
    <td colspan="6"><strong>RECEPCION:
	<?php
		if($TipoProceso!='S')
		{	echo "ENTRADA DEL CAMION";
			$Testo="ENTRADA";
		}
		else
		{	echo "SALIDA DEL CAMION";
			$Testo="SALIDA";
		}
	//echo "<br>TxtNumBascula:".$TxtNumBascula;	
	//echo "<br>Bloq1:".$Bloq1."<br>";
	//echo "Bloq2:".$Bloq2."<br>";
		?>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PESANDO EN BASCULA DE <?php echo $Testo;?>:
	<?php
    //echo "<br>TxtNumBascula:".$TxtNumBascula;	
	//echo "<br>Bloq1:".$Bloq1."<br>";
	//echo "Bloq2:".$Bloq2."<br>";
		?>
    <input type="hidden" id="Bloq1" name="Bloq1" class="InputCen" value="<?php echo $Bloq1;?>" size="2"  >	
	<input type="hidden" id="Bloq2" name="Bloq2" class="InputCen" value="<?php echo $Bloq2;?>" size="2"  >	
	<input type="hidden" name="TxtNumBascula" class="InputCen" value="<?php echo $TxtNumBascula;?>" size="2" > 
	<?php	
		switch($TxtNumRomana)
		{
			case 1:
				$BasculaA='1';
				$BasculaB='2';
			break;
			case 2:
				$BasculaA='3';
				$BasculaB='4';
			break;
			default:
					$BasculaA='S/N';
					$BasculaB='S/N';
			break;
		}	
		$Color='000000';
	if($TxtNumRomana==1 && $TxtNumBascula==1)	
		{$Valor=1;$Color='FF0000';}
	if($TxtNumRomana==1 && $TxtNumBascula==2)	
		{$Valor=2;$Color='009933';}
	if($TxtNumRomana==2 && $TxtNumBascula==1)	
		{$Valor=3;$Color='FF0000';}
	if($TxtNumRomana==2 && $TxtNumBascula==2)	
		{$Valor=4;$Color='009933';}
			
		
	?>
	<input type="text" name="TxtBasculaAux" class="InputCen" value="<?php echo $Valor;?>" size="2" readonly  style="background:#F90">	
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	<?php	

	
	echo $BasculaA;?>
    
	<input name="OptBascula" type="radio" value="radiobutton" onClick="SeleccionBascula('1')" <?php echo $EstOptBascula;?>><?php if($Bloq1=='S'){?><img  align="absmiddle" id="BasculaA" src="btn_rojo.png" alt="Bascula Bloqueada"><?php }else{ ?> <img align="absmiddle" src="btn_verde.png" id="BasculaA" alt="Bascula Habilitada"><?php } ?>
   
     &nbsp;&nbsp;&nbsp;&nbsp;
    
	<?php echo $BasculaB;?>
	<input name="OptBascula" type="radio" value="radiobutton" onClick="SeleccionBascula('2')" <?php echo $EstOptBascula2;?>><?php if($Bloq2=='S'){?><img align="absmiddle" id="BasculaB" src="btn_rojo.png"  alt="Bascula Bloqueada"><?php }else{ ?> <img  align="absmiddle" src="btn_verde.png" id="BasculaB" alt="Bascula Habilitada"><?php } ?>
 
  <input type="hidden" name="TxtNumRomana" class="InputCen" value="<?php echo $TxtNumRomana;?>" size="2" readonly >
	<input name="TxtPorcRango" type="hidden" value="<?php echo $TxtPorcRango; ?>" size="2">
	<input name="TxtPesoHistorico" type="text" class="InputCen" value="<?php echo $TxtPesoHistorico; ?>" size="8" readonly></strong> 
  </td></tr>

  <tr>
    <td width="91" align="right" class="ColorTabla02">Patente:</td>
    <td width="156" class="ColorTabla02" ><input name="TxtPatente" type="text" class="InputCen" id="TxtPatente2" value="<?php echo strtoupper($TxtPatente); ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('N',true,this.form,'TxtGuia');" onBlur="Recarga(TxtGuia,'S')" <?php echo $EstPatente;?>>    
    <td width="91" align="right" class="ColorTabla02">Fecha:</td>
    <td width="106" class="ColorTabla02" ><input name="TxtFecha" type="text" class="InputCen" value="<?php echo $TxtFecha; ?>" size="12" maxlength="10" readonly ></td>
    <td width="111" align="right" class="ColorTabla02">Peso Bruto :
	</td>	
    <td width="111" class="ColorTabla02">
	<input <?php echo $EstadoInput; ?> name="TxtPesoBruto" type="text" class="InputCen" value="<?php echo $TxtPesoBruto; ?>" size="10" maxlength="10" onBlur="CalculaPNeto()" readonly ></td>
  </tr>
  <tr>
    <td align="right" class="ColorTabla02">Correlativo:</td>
	<td class="ColorTabla02">
	<?php
	if($TipoProceso=="" || $TipoProceso=='E')	
	{
		//echo "prueba info";
		//echo "TipoProcesooooo:".$TipoProceso;
	?>
    <input <?php echo $EstadoInput; ?> name="TxtCorrelativo" type="text" class="InputCen" id="TxtCorrelativo" value="<?php echo $TxtCorrelativo; ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('S',true,this.form,'BtnOK');" readonly>      
    <?php
	}
	else
	{
	?>
    <SELECT name="TxtCorrelativo" onChange="Proceso('BC',TxtObs)" onkeypress="buscar_op(this,TxtCorrelativo,0,'S')" onBlur="borrar_buffer()" onclick="borrar_buffer()" <?php //echo $HabilitarCmb;?>>
    <option value="S" SELECTed class="NoSelec"><?php echo $TitCmbCorr;?></option>
    <?php
		$AnoMes=substr(date('Y'),2,2).date('m');
		$Consulta ="SELECT distinct t1.lote,t1.recargo,t1.correlativo,t1.cod_subproducto from sipa_web.recepciones t1 ";
		$Consulta.="where patente='$TxtPatente' and peso_neto=0 and estado<>'A' order by t1.correlativo desc";
		$RespCorr=mysqli_query($link, $Consulta);
		while($FilaCorr=mysqli_fetch_array($RespCorr))
		{
			$Datos=explode('~',$TxtCorrelativo);
			if($Datos[0]==$FilaCorr["lote"]&&$Datos[1]==$FilaCorr["recargo"]&&$Datos[2]==$FilaCorr["correlativo"])
			{
				echo "<option value='".$FilaCorr["lote"]."~".$FilaCorr["recargo"]."~".$FilaCorr["correlativo"]."' SELECTed>".str_pad($FilaCorr["correlativo"],4,0,STR_PAD_LEFT)." - ".$FilaCorr["lote"]." - ".str_pad($FilaCorr["recargo"],2,0,STR_PAD_LEFT)." - ".str_pad($FilaCorr["cod_subproducto"],2,0,STR_PAD_LEFT)."</option>";
			}
			else
			{
				echo "<option value='".$FilaCorr["lote"]."~".$FilaCorr["recargo"]."~".$FilaCorr["correlativo"]."'>".str_pad($FilaCorr["correlativo"],4,0,STR_PAD_LEFT)." - ".$FilaCorr["lote"]." - ".str_pad($FilaCorr["recargo"],2,0,STR_PAD_LEFT)." - ".str_pad($FilaCorr["cod_subproducto"],2,0,STR_PAD_LEFT)."</option>";			
			}
		}
				
	?></SELECT>
	<?php
		}
	?>
	</td>
	<td align="right" class="ColorTabla02">Hora Entrada:</td>
    <td class="ColorTabla02"><input name="TxtHoraE" type="text" class="InputCen" value="<?php echo $TxtHoraE; ?>" size="10" maxlength="10" readonly ></td>
    <td align="right" class="ColorTabla02">Peso Tara :</td>
    <td class="ColorTabla02"><input <?php echo $EstadoInput; ?> name="TxtPesoTara" type="text" class="InputCen" id="TxtPesoTara" value="<?php echo $TxtPesoTara; ?>" size="10" maxlength="10" onBlur="CalculaPNeto()" readonly></td>
  </tr>
  <tr>
    <td align="right" class="ColorTabla02">Guia Despacho :</td>
    <td class="ColorTabla02"><input <?php echo $EstadoInput; ?> name="TxtGuia" type="text" class="InputCen" id="TxtGuia" value="<?php echo $TxtGuia; ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('S',true,this.form,'TxtGuia2');">
	<input <?php echo $EstadoInput; ?> name="TxtGuia2" type="text" class="Ghost" size='1' onKeypress="TeclaPulsada2('S',true,this.form,'CmbGrupoProd');" readonly></td>
    <td align="right" class="ColorTabla02">Hora Salida:</td>
    <td class="ColorTabla02"><input <?php echo $EstadoInput; ?> name="TxtHoraS" type="text" class="InputCen" id="TxtHoraS2" value="<?php echo $TxtHoraS; ?>" size="10" maxlength="10" readonly></td>
    <td align="right" class="ColorTabla02">Peso Neto:</td>
    <td class="ColorTabla02"><input <?php echo $EstadoInput; ?> name="TxtPesoNeto" type="text" class="InputCen" id="TxtNeto" value="<?php echo $TxtPesoNeto; ?>" size="10" maxlength="10" readonly></td>
  </tr>
  <tr>
    <td align="right" class="ColorTabla02"> Producto: </td>
    <td colspan="5" class="ColorTabla02">
	<SELECT name="CmbGrupoProd" style="width:150" onChange="Recarga(CmbSubProducto)" onkeypress="buscar_op(this,CmbSubProducto,0,'S')" onBlur="borrar_buffer()" onclick="borrar_buffer()" <?php echo $HabilitarCmb;?>>
      <option value="S" SELECTed class="NoSelec">Seleccionar</option>
      <?php
				$Consulta = "SELECT * from sipa_web.grupos_productos order by descripcion_grupo ";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbGrupoProd == $Fila["cod_grupo"])
					{	
						echo "<option SELECTed value='".$Fila["cod_grupo"]."'>".strtoupper($Fila["descripcion_grupo"])."</option>";
						$ValidaPadronMin=$Fila["abast_minero"];					
					}
					else
						echo "<option value='".$Fila["cod_grupo"]."'>".strtoupper($Fila["descripcion_grupo"])."</option>";
				}
			  ?>
    </SELECT>&nbsp;<input name="ValidaPadronMin" type="hidden" class="InputCen" value="<?php echo $ValidaPadronMin; ?>" size="1" readonly>
	<SELECT name="CmbSubProducto" style="width:300" onChange="Recarga(CmbProveedor)" onkeypress="buscar_op(this,CmbProveedor,0,'S')" onBlur="borrar_buffer()" onclick="borrar_buffer()" <?php echo $HabilitarCmb;?>>
      <option value="S" SELECTed class="NoSelec">Seleccionar</option>
      <?php
				$Consulta="SELECT  t1.cod_producto,t1.cod_subproducto,t2.abreviatura as nom_prod,t2.descripcion as nom_subprod,humedad, ";
				$Consulta.= " case when length(t1.cod_subproducto)<2 then concat('0',t1.cod_subproducto) else t1.cod_subproducto end as orden ";
				$Consulta.="from sipa_web.grupos_prod_subprod t1 inner join proyecto_modernizacion.subproducto t2 on t1.cod_producto =t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
				$Consulta.="where t1.cod_grupo='$CmbGrupoProd' order by nom_subprod";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($CmbSubProducto == $Fila["cod_producto"]."~".$Fila["cod_subproducto"])
					{	
						echo "<option SELECTed value='".$Fila["cod_producto"]."~".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["nom_subprod"])."</option>";
						$TxtHumedad=$Fila["humedad"];
					}	
					else
						echo "<option value='".$Fila["cod_producto"]."~".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["nom_subprod"])."</option>";
				}
			  ?>
    </SELECT>&nbsp;&nbsp;Hum:
      <input name="TxtHumedad" type="text" class="InputCen" value="<?php echo $TxtHumedad; ?>" size="2" readonly>
	  
	  </td>
	  
    </tr>
  <tr>
    <td align="right" class="ColorTabla02">Rut Proveedor :</td>
	<?php
		if($AbastMinero=='S')
		{
	?>
    <td colspan="5" class="ColorTabla02">
	  <input <?php echo $EstadoInput; ?> name="TxtRutPrv" type="hidden" class="InputCen" value="<?php echo $TxtRutPrv; ?>" size="14" maxlength="10" onKeyDown="TeclaPulsada2('N',true,this.form,'CmbProveedor');">
      <SELECT name="CmbProveedor" style="width:300" onkeypress=buscar_op(this,CmbMinaPlanta,0,'S') onBlur="borrar_buffer()" onclick="borrar_buffer()" <?php echo $HabilitarCmb;?>>
        <option class="NoSelec" value="S">Seleccionar</option>
        <?php
				//if(isset($CmbProveedor))
				if($CmbProveedor!="")
				{
					$SubProd=explode('~',$CmbSubProducto);
					$SubProd0 = isset($SubProd[0])?$SubProd[0]:"";
					$SubProd1 = isset($SubProd[1])?$SubProd[1]:"";
					$Consulta = "SELECT distinct rut_prv,nombre_prv from sipa_web.proveedores t1 inner join age_web.relaciones t2 ";
					$Consulta.= " on t1.rut_prv=t2.rut_proveedor ";
					$Consulta.= " where t2.cod_producto='".$SubProd0."' and t2.cod_subproducto='".$SubProd1."'";// and t1.rut_prv <>'90132000-5'";
					$Consulta.= " order by t1.nombre_prv";
					$Resp = mysqli_query($link, $Consulta);
					while ($Fila = mysqli_fetch_array($Resp))
					{
						if ($CmbProveedor == $Fila["rut_prv"])
							echo "<option SELECTed value='".$Fila["rut_prv"]."'>".str_pad($Fila["rut_prv"],10,"0",STR_PAD_LEFT)."-".$Fila["nombre_prv"]."</option>\n";
						else
							echo "<option value='".$Fila["rut_prv"]."'>".str_pad($Fila["rut_prv"],10,"0",STR_PAD_LEFT)."-".$Fila["nombre_prv"]."</option>\n";
					}
				}	
			?>
      </SELECT>
      Venc.Padron:	<input name="TxtVencPadron" type="text" class="InputCen" id="TxtVencPadron" value="<?php echo $TxtVencPadron; ?>" size="12" maxlength="10" readonly >
	  </td>
	  <?php }
	  else
	  {
	     echo "<td colspan='5' class='ColorTabla02'>";
		 if($CmbProveedor=='S')
			$CmbProveedor='';
		 echo "<input name='CmbProveedor' type='textbox' class='InputIzq' value='$CmbProveedor' size='14' maxlength='10' onKeyDown=\"TeclaPulsada2('N',true,this.form,'TxtNombrePrv');\" onblur='BuscarProveedor()'>&nbsp;&nbsp;Nombre:&nbsp;"; 
		 echo "<input name='TxtNombrePrv' type='textbox' class='InputIzq' value='$TxtNombrePrv' size='50' maxlength='25' onKeyDown=\"TeclaPulsada2('N',true,this.form,'CmbLotes');\">";
	  	echo "</td>";
	  }
	   ?>
    </tr>
	<?php	
	if($AbastMinero=='S')
	{
					//echo "CmbMinaPlanta:".$CmbMinaPlanta."<br><br>";
    ?>
  <tr>
    <td align="center" class="ColorTabla02">Mina/Planta:</td>
    <td colspan="5" bgcolor="#FFFFCC" class="Detalle03">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Codigo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nombre Faena&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sierra&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Comuna </td>
    </tr>
  <tr>
    <td align="right" class="ColorTabla02">&nbsp;</td>
    <td colspan="5" class="ColorTabla02">
	<SELECT name="CmbMinaPlanta" style="width:570" onChange="ObtenerFecPadronConj()" onKeypress="TeclaPulsada2('S',true,this.form,'BtnPBruto');" <?php echo $HabilitarCmb;?>>
      <option value="S" SELECTed class="NoSelec">Seleccionar</option>
	  <?php
	  		//if(isset($CmbMinaPlanta))
			//10432707-9~05203.2212-4~2014-03-~415
			if($CmbMinaPlanta!="")
			{
				$SubProd=explode('~',$CmbSubProducto);
				$SubProd1 = isset($SubProd[1])?$SubProd[1]:"";

				$Datos=explode('~',$CmbMinaPlanta);
				$Datos0 = isset($Datos[0])?$Datos[0]:"";
				$Datos1 = isset($Datos[1])?$Datos[1]:"";
				$Datos2 = isset($Datos[2])?$Datos[2]:"";
				$Datos3 = isset($Datos[3])?$Datos[3]:"";

				$Consulta = "SELECT  t1.rut_prv,t1.cod_mina,t1.nombre_mina,t1.sierra,t1.comuna,t1.fecha_padron,t3.conjunto from sipa_web.minaprv t1 ";
				$Consulta.= "left join sipa_web.grupos_prod_prv t2 on t2.cod_producto='1' and t2.cod_subproducto='".$SubProd1."' ";
				$Consulta.= "and t2.rut_prv='".$CmbProveedor."' and t2.cod_mina=t1.cod_mina ";
				$Consulta.= "left join sipa_web.grupos_conjunto t3 on t3.cod_grupo=t2.cod_grupo ";
				$Consulta.= "where t1.rut_prv='".$CmbProveedor."' ";
				$Consulta.= "order by t1.rut_prv,t1.cod_mina,t1.nombre_mina";
				echo "<br>".$Consulta;
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($Datos0 == $Fila["rut_prv"]&&$Datos1 == $Fila["cod_mina"]&&$Datos2 == $Fila["fecha_padron"]&&$Datos3 == $Fila["conjunto"])
						echo "<option SELECTed value='".$Fila["rut_prv"]."~".$Fila["cod_mina"]."~".$Fila["fecha_padron"]."~".$Fila["conjunto"]."'>".$Fila["cod_mina"]." | ".$Fila["nombre_mina"]." | ".$Fila["sierra"]." | ".$Fila["comuna"]."</option>\n";
					else
						echo "<option value='".$Fila["rut_prv"]."~".$Fila["cod_mina"]."~".$Fila["fecha_padron"]."~".$Fila["conjunto"]."'>".$Fila["cod_mina"]." | ".$Fila["nombre_mina"]." | ".$Fila["sierra"]." | ".$Fila["comuna"]."</option>\n";
				}			
			}
	  ?>
    </SELECT><?php //echo $Consulta;?></td>
    </tr>
  <tr>
    <td align="right" class="ColorTabla02">Tipo Recep. :</td>
    <td class="ColorTabla02">
	<?php
		//if(isset($CmbProveedor))
		if($CmbProveedor!="")
		{
			$Consulta="SELECT * from sipa_web.rut_asignacion where rut_prv='$CmbProveedor'";
			$Resp=mysqli_query($link, $Consulta);
			if($Fila=mysqli_fetch_array($Resp))
				$TxtAsignacion=$Fila["asignacion"];
			else
				$TxtAsignacion="MAQ ENM";
		}
	?>
	<input name="TxtAsignacion" type="text" class="InputCen" value="<?php echo $TxtAsignacion; ?>" size="12" readonly >
	</td>
    <td align="right" class="ColorTabla02">Conjunto:</td>
    <td align="left" class="ColorTabla02">
	<?php 
	//echo $CmbConjunto."<br>";
	//echo $Consulta;?>
    <input name="CmbConjunto" type="text" class="InputCen" value="<?php echo $CmbConjunto; ?>" size="12" maxlength="10" readonly >	</td>
    <td align="right" class="ColorTabla02">Clase:</td>
    <td align="left" class="ColorTabla02"><SELECT name="CmbClase" style="width:100" onkeypress=buscar_op(this,CmbLotes,0,'N') onBlur="borrar_buffer()" onclick="borrar_buffer()" >
      
	  <!--<option SELECTed value="G">GRANZA</option>-->
      <?php
			$CodProdSub=explode('~',$CmbSubProducto);
			if($CodProdSub[0]=='1')
			{	
				switch($CodProdSub[1])
				{
					case "1":
					case "2":
					case "4":
					case "5":
					case "6":
					case "9":
					case "13":
						$CmbClase='G';
						break;
					case "17":
					case "18":
					case "16":
						$CmbClase='M';
						break;
					default:
						$CmbClase='O';
						break;
				}
			}	
			$Consulta="SELECT * from proyecto_modernizacion.sub_clase where cod_clase='15001' ";
			if($CmbClase=='O')
				$Consulta.="and nombre_subclase='O' ";//OTRA
			$Consulta.="order by nombre_subclase";
			$RespAsig=mysqli_query($link, $Consulta);
			while($FilaAsig=mysqli_fetch_array($RespAsig))
			{
				if($FilaAsig["nombre_subclase"]==$CmbClase)
					echo "<option value='".$FilaAsig["nombre_subclase"]."'SELECTed>".$FilaAsig["valor_subclase1"]."</option>";
				else
					echo "<option value='".$FilaAsig["nombre_subclase"]."'>".$FilaAsig["valor_subclase1"]."</option>";
			}
		?>
    </SELECT></td>
  </tr>
	<?php
	}
	?>
  <tr>
    <td align="right" class="ColorTabla02">Lote:</td>
    <td colspan="5" class="ColorTabla02">
	  <SELECT name="CmbLotes" style="width:100" onChange="Proceso('B',TxtLote)" <?php echo $HabilitarCmb;?>>
	    <option SELECTed value="S">Seleccionar</option>
		<option value="-1">Nuevo Lote</option>
		<?php
			$AnoMes=substr(date('Y'),2,2).date('m');
			$SubProd=explode('~',$CmbSubProducto);
			$SubProd0 = isset($SubProd[0])?$SubProd[0]:"";
			$SubProd1 = isset($SubProd[1])?$SubProd[1]:"";
			$Consulta = "SELECT distinct t1.lote,t1.cod_subproducto,t1.rut_prv as rutprv from sipa_web.recepciones t1 where ";
			$Consulta.="t1.estado<>'A' and cod_producto='".$SubProd0."' and cod_subproducto='".$SubProd1."' and rut_prv='".$CmbProveedor."' and ";
			$Consulta.=" lote like '$AnoMes%' and ult_registro <> 'S' ";
			$Consulta.=" and t1.recargo=(SELECT max((t2.recargo)*1) from sipa_web.recepciones t2 where t2.lote=t1.lote) ";
			$Consulta.=" group by lote";
			$Resp = mysqli_query($link, $Consulta);
			while ($FilaLote = mysqli_fetch_array($Resp))
			{
				if($FilaLote["lote"]==$CmbLotes)
					echo "<option value='".$FilaLote["lote"]."'SELECTed>".$FilaLote["lote"]."</option>";
				else
					echo "<option value='".$FilaLote["lote"]."'>".$FilaLote["lote"]."</option>";
			}
		?>
	  </SELECT>&nbsp;&nbsp;&nbsp;
	<input <?php echo $EstadoInput; ?> name="TxtLote" type="text" class="InputCen" id="TxtLote" value="<?php echo $TxtLote; ?>" size="10" maxlength="10" onKeyDown="TeclaPulsada2('S',true,this.form,'BtnOK');" readonly>      &nbsp;&nbsp;Rec.:
      <input <?php echo $EstadoInput; ?> name="TxtRecargo" type="text" class="InputCen" id="TxtRecargo" value="<?php echo $TxtRecargo; ?>" size="4" maxlength="2" onKeyDown="TeclaPulsada2('S',true,this.form,'BtnOK');" readonly>
      &nbsp;&nbsp;Ult.Rec.:
	  <SELECT name="CmbUltRecargo" style="width:35" <?php //echo $HabilitarCmb;?>>
		<?php
			switch($CmbUltRecargo)
			{
				case "S":
					echo "<option value='N'>N</option>";
					echo "<option value='S' SELECTed>S</option>";
					break;
				case "N":
					echo "<option value='N' SELECTed>N</option>";
					echo "<option value='S'>S</option>";
					break;
				default:
					echo "<option value='N' SELECTed>N</option>";
					echo "<option value='S'>S</option>";
					break;	
			}		
		?>
	    </SELECT>
	<?php	
	if($AbastMinero!='S')
		echo "&nbsp;&nbsp;&nbsp;Conj.&nbsp;<input name='CmbConjunto' type='text' class='InputCen' value='$CmbConjunto' size='12' maxlength='10'>";	
    ?>
	</td>
    </tr>
  <tr>
    <td align="right" class="ColorTabla02">Observacion:</td>
    <td colspan="5" class="ColorTabla02">
    <input name="TxtObs" type="text" class="InputIzq" id="TxtObs" onKeyDown="TeclaPulsada2('N',true,this.form,'BtnGrabar');" value="<?php echo $TxtObs; ?>" size="100" <?php echo $EstadoInput; ?>></td>
    </tr>
	<?php	
	if($AbastMinero=='S')
	{
    ?>
  <tr>
    <td align="right" class="ColorTabla02">Elementos:</td>
    <td colspan="2" class="ColorTabla02"><input name="TxtLeyes" type="text" value="<?php echo $TxtLeyes; ?>" size="24" readonly >
      <input type="button" name="BtnLeyes" value="..." onClick="SelecLeyes();" size="4"></td>
    <td align="left" class="ColorTabla02">&nbsp;</td>
    <td colspan="2" align="right" class="ColorTabla02">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" class="ColorTabla02">Ensayes:</td>
    <td class="ColorTabla02"><input name="TxtImpurezas" type="text" value="<?php echo $TxtImpurezas; ?>" size="24" readonly ></td>
    <td align="left" class="ColorTabla02">&nbsp;</td>
    <td align="right" class="ColorTabla02">&nbsp;</td>
    <td colspan="2" align="left" class="ColorTabla02">
	</td>
  </tr>
  <?php
  }
  ?>
  <tr>
    <td align="right" class="ColorTabla02">&nbsp;</td>
    <td class="ColorTabla02">&nbsp;</td>
    <td align="right" class="ColorTabla02">&nbsp;</td>
    <td align="right" class="ColorTabla02">&nbsp;</td>
	<?php
		//SE CALCULA EL PESO NETO DEL LOTE
		$TotalLote=0;
		$Consulta="SELECT sum(peso_neto) as total_neto from sipa_web.recepciones where lote ='$TxtLote' group by lote";
		$Respuesta=mysqli_query($link, $Consulta);
		if($Fila=mysqli_fetch_array($Respuesta))
			$TxtPesoTotalNeto=$Fila["total_neto"];
	?>
    <td colspan="2" align="left" class="ColorTabla02"><span class="Estilo2">TOTAL PESO NETO LOTE: </span>
	<input type="hidden" name="TxtPesoTotalNeto" value="<?php echo $TxtPesoTotalNeto;?>">
	<input type="text" name="TxtPNetoTot" value="<?php echo $TxtPNetoTot;?>" class="InputDer" size="8" readonly>
	 </td>
  </tr>
	</table>
	<br>
	<table width="700" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#000000" class="TablaInterior">
	  <tr bgcolor="#FFFFFF">
	  <td align="center" class="ColorTabla02">
	  	<?php  switch($TipoProceso)
			{
				case "E":
					$EstBtnPBruto='';
					$EstBtnPTara='disabled';
					if($TxtNumBascula=='1' && $Bloq1=="S")
					{
						$EstBtnPBruto='disabled';
						//$EstBtnPBruto='';   //WSO  
					}	
					if($TxtNumBascula=='2' && $Bloq2=="S")
					{
						$EstBtnPBruto='disabled';
						//$EstBtnPBruto='';   //WSO
					}									
					break;
				case "S":
					$EstBtnPBruto='disabled';
					$EstBtnPTara='';		
					if($TxtNumBascula=='1' && $Bloq1=="S")
					{
						$EstBtnPTara='disabled';
					}	
					if($TxtNumBascula=='2' && $Bloq2=="S")
					{
						$EstBtnPTara='disabled';
					}								
					break;
				default:	
					$EstBtnPBruto='disabled';
					$EstBtnPTara='disabled';									
					break;
			}			
		?>
      <!-- 	<input type="hidden" name="TipoProceso" value="<?php //echo $TipoProceso;?>">
	 -->
        <input name="BtnPBruto" type="button" id="BtnPBruto" style="width:70px " onClick="CapturaPeso('PB')" value="P.Bruto" <?php echo $EstBtnPBruto;?>>
        <input name="BtnPTara" type="button" id="BtnPTara" style="width:70px " onClick="CapturaPeso('PT')" value="P.Tara" <?php echo $EstBtnPTara;?>>
		<input name="BtnGrabar" type="button" value="Grabar" style="width:70px " onClick="Proceso('G','','<?php echo $TipoProceso;?>')" <?php echo $EstBtnGrabar;?>>
		<input name="BtnModificar" type="button" id="BtnModificar" style="width:70px " onClick="Proceso('M')" value="Modificar" <?php echo $EstBtnModificar;?>>
		<input name="BtnCancelar" type="button" id="BtnCancelar" style="width:70px " onClick="Proceso('C')" value="Cancelar">
		<input name="BtnAnular" type="button" style="width:70px " onClick="Proceso('A')" value="Anular" <?php echo $EstBtnAnular;?>>
		<input name="BtnImprimir" type="button" value="Imprimir" style="width:70px " onClick="Proceso('I')" <?php echo $EstBtnImprimir;?>>
		<input name="BtnSalir" type="button" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
		<!--<input name="BtnReiniciar" type="button" value="Reinicar" style="width:70px " onClick="Proceso('R')"></td>-->

</table>  
</td>
</tr>
</table>
<?php include("../principal/pie_pagina.php") ?>
</form>
</body>
</html>
<?php
$GETHOST_NAME  =  gethostname();
$GETHOSTBYNAME =  gethostbyname($_SERVER['REMOTE_ADDR']);
$userIp = getUserIP(); 
$realIp = getRealIP();
//$ip     = $_SERVER['HTTP_CLIENT_IP'];
//echo "CLIENT_IP:".$realIp;

//echo "<br>GETHOST_NAME:".$GETHOST_NAME;
//echo "<br>GETHOSTBYNAME:".$GETHOSTBYNAME;

//echo "<br>COMPUTERNAME:".$COMPUTERNAME;
//echo "<br>SERVER_NAME:".$SERVER_NAME;
//echo "<br>REMOTE_ADDR:".$REMOTE_ADDR;
echo "<br>USER_IP:".$IP ;

//$Romana = LeerRomana($REMOTE_ADDR,$link);
$Romana = LeerRomana($IP,$link);
echo "<br>ROMANA: ".$Romana;

if($Mensaje!='')
{
	echo "<script language='JavaScript'>";
	echo "alert('$Mensaje');";
	echo "var f = document.FrmRecepcion;";
	//echo "f.TxtPatente.focus();";
	echo "</script>";
}
echo "<script language='JavaScript'>";
echo "var f = document.FrmRecepcion;";
/////////// SE LEE LA ROMANA ////////////
//echo "f.TxtNumRomana.value = LeerRomana(f.TxtNumRomana.value);";
//$Romana = LeerArchivo('PesaMatic','ROMANA.txt');
//echo"COMPUTERNAME:".$COMPUTERNAME;
echo "f.TxtNumRomana.value=".$Romana.";";
echo "CalculaPNetoTotal();";
//echo "alert(f.TxtNumRomana.value);";
echo "</script>";

$Dias=1;
$ConsultaCorreo="SELECT * from proyecto_modernizacion.sub_clase where cod_clase='15012' and cod_subclase='1' and valor_subclase3='S'";
$RespCorreo=mysqli_query($link, $ConsultaCorreo);
if($Fila=mysqli_fetch_array($RespCorreo))
{
	$FecUltEjec=explode('-',$Fila["valor_subclase1"]);
	$Dias=intval($Fila["valor_subclase2"]);
	$FechaProx=date('Y-m-d',mktime(0,0,0,$FecUltEjec[1],intval($FecUltEjec[2])+$Dias,$FecUltEjec[0]));	
	$FechaSistema=date('Y-m-d');
	//$FechaSistema="2011-05-17";
	if($FechaProx<$FechaSistema)
	{
		EnvioCorreoControlPadronMinero($link);
		$Actualizar="UPDATE proyecto_modernizacion.sub_clase set valor_subclase1='".$FechaSistema."' where cod_clase='15012' and cod_subclase='1'";
		mysqli_query($link, $Actualizar);
		//echo "ENVIO CORREO<br>";
	}
}

function EnvioCorreoControlPadronMinero($link)
{
	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$ConsultaCorreo="SELECT * from proyecto_modernizacion.sub_clase where cod_clase='15012' and cod_subclase='1'";
	$RespCorreo=mysqli_query($link, $ConsultaCorreo);
	if($Fila=mysqli_fetch_array($RespCorreo))
	{
		$Correos=$Fila["nombre_subclase"];
		$ArrayCorreos=explode(",",$Correos);
	}
	$AnoProx=explode('-',date("Y-m-",mktime(0,0,0,date('m')+1,date('d'),date('Y'))));
	
	$M=date('m');
	if($M==11)
		$M=0;
	//$Correos='lfara@codelco.cl,lcast036@contratistas.codelco.cl';
	$ArrayCorreos=explode(",",$Correos);
	$Asunto='SIPA - Proximos Vencimiento Padrones Mineros';
	//$Mensaje='Se envia Listados de Proveedores con sus Padrones Mineros Proximos a Vencer en el mes de '.$Meses[intval($M)].' del '.$AnoProx[0].'<br><br>';
	$Mensaje='Se envia Listados de Proveedores con sus Padrones Mineros Proximos a Vencer en el mes de '.$AnoProx[1].' del '.$AnoProx[0].'<br><br>';
	$Mensaje.='<table width="90%"  border="1" align="center">';
	$Mensaje.='<tr><td bgcolor="#EE8E0A" align="center">Rut&nbsp;Proveedor</td><td bgcolor="#EE8E0A" align="center">Nombre&nbsp;Proveedor</td><td bgcolor="#EE8E0A" align="center">Nombre&nbsp;Mina</td><td bgcolor="#EE8E0A" align="center">Nro. Mina</td><td bgcolor="#EE8E0A" align="center">Sierra</td><td bgcolor="#EE8E0A" align="center">Comuna</td></tr>';
	$ConsultaPadron="Select t1.*,t2.nombre_prv from sipa_web.minaprv t1 left join sipa_web.proveedores t2 on t1.rut_prv=t2.rut_prv where fecha_padron='".date("Y-m-",mktime(0,0,0,date('m')+1,date('d'),date('Y')))."' order by t2.nombre_prv,t1.nombre_mina";
	$RespPadron=mysqli_query($link, $ConsultaPadron);
	while($FilaPadron=mysqli_fetch_array($RespPadron))
	{
		$Mensaje.='<tr><td>'.$FilaPadron["rut_prv"].'</td><td>'.ucwords(strtolower($FilaPadron["nombre_prv"])).'</td><td>'.ucwords(strtolower($FilaPadron["nombre_mina"])).'</td><td>'.$FilaPadron["cod_mina"].'</td><td>'.ucwords(strtolower($FilaPadron["sierra"])).'</td><td>'.ucwords(strtolower($FilaPadron["comuna"])).'</td></tr>';
	}
	$Mensaje.='</table>';
	$Titulo="";
	foreach($ArrayCorreos as $C =>$Correo2)	
	{
		
		$cuerpoMsj = '<html>';
		$cuerpoMsj.= '<head>';
		$cuerpoMsj.= '<title>'.$Titulo.'</title>';
		$cuerpoMsj.= '</head>';
		$cuerpoMsj.= '<body>';
		$cuerpoMsj.= '<table  width="100%"  border="0" align="center">';
		$cuerpoMsj.= '<tr><td>';
		$cuerpoMsj.= ''.$Mensaje.'';
		$cuerpoMsj.= "<br>";
		$cuerpoMsj.=" Favor no responder este mensaje";
		$cuerpoMsj.= "<br>";
		$cuerpoMsj.="Servicio Automatico de Sistema de Pesaje 'SIPA'";
		$cuerpoMsj.= "<br>";
		$cuerpoMsj.= '</td></tr>';
		$cuerpoMsj.= '</table>';
		$cuerpoMsj.= '</body></html>';
		
		$mail = new phpmailer();
		//$mail->AddEmbeddedImage("includes/logo_seti.jpg","logo","includes/logo_seti.jpg","base64","image/jpg");
		$mail->PluginDir = "includes/";
		//$mail->Mailer = "smtp";
		$mail->Host = "RELAYDS.codelco.cl";
		$mail->From = "SIPA";
		$mail->FromName = "SIPA - Sistemas Pesaje 'SIPA' ";
		$mail->Subject = $Asunto;
		$mail->Body=$cuerpoMsj;
		$mail->IsHTML(true);
		$mail->AltBody =str_replace('<br>','\n',$cuerpoMsj);
		$mail->AddAddress($Correo2);
		$mail->Timeout=120;
		//$mail->AddAttachment($Doc,$Doc);
		$exito = $mail->Send();
		$intentos=1; 
		while((!$exito)&&($intentos<5)&&($mail->ErrorInfo!="SMTP Error: Data not accepted")){
		sleep(5);
		$exito = $mail->Send();
		$intentos=$intentos+1;				
		}
		$mail->ClearAddresses();
	}
}

?>
