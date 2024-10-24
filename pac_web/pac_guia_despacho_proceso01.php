<?php
	require_once('lib/nusoap.php');
	include("../principal/conectar_pac_web.php");

	$HoraI = date("h:i".':00'); 
	$HoraT = date("h:i".':00');

	$CookieRut   = $_COOKIE["CookieRut"];
	$Proceso     = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$NG          = isset($_REQUEST["NG"])?$_REQUEST["NG"]:"";
	$Ver         = isset($_REQUEST["Ver"])?$_REQUEST["Ver"]:"";
	$Valores     = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	$Correlativo = isset($_REQUEST["Correlativo"])?$_REQUEST["Correlativo"]:"";
	$FechaHoraRomana = isset($_REQUEST["FechaHoraRomana"])?$_REQUEST["FechaHoraRomana"]:"";
	$checkbox = isset($_REQUEST["checkbox"])?$_REQUEST["checkbox"]:"";

	$dia = isset($_REQUEST["dia"])?$_REQUEST["dia"]:date("d");
	$mes = isset($_REQUEST["mes"])?$_REQUEST["mes"]:date("m");
	$ano = isset($_REQUEST["ano"])?$_REQUEST["ano"]:date("Y");
	$hh = isset($_REQUEST["hh"])?$_REQUEST["hh"]:date("H");
	$mm = isset($_REQUEST["mm"])?$_REQUEST["mm"]:date("i");
	
	$CmbMes = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:date("m");
	$CmbAno = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:date("Y");
	$CmbTipoGuia = isset($_REQUEST["CmbTipoGuia"])?$_REQUEST["CmbTipoGuia"]:""; 

	$TxtObs = isset($_REQUEST["TxtObs"])?$_REQUEST["TxtObs"]:"";
	$CmbOri = isset($_REQUEST["CmbOri"])?$_REQUEST["CmbOri"]:"";
	$CmbTransp = isset($_REQUEST["CmbTransp"])?$_REQUEST["CmbTransp"]:"";
	$CmbCliente = isset($_REQUEST["CmbCliente"])?$_REQUEST["CmbCliente"]:"";
	$CmbChofer = isset($_REQUEST["CmbChofer"])?$_REQUEST["CmbChofer"]:"";
	$CmbPatente = isset($_REQUEST["CmbPatente"])?$_REQUEST["CmbPatente"]:"";
	$CmbPatenteRampla = isset($_REQUEST["CmbPatenteRampla"])?$_REQUEST["CmbPatenteRampla"]:"";
	$Toneladas        = isset($_REQUEST["Toneladas"])?$_REQUEST["Toneladas"]:"";
	$TxtMts           = isset($_REQUEST["TxtMts"])?$_REQUEST["TxtMts"]:"";
	$TxtCorrRomana = isset($_REQUEST["TxtCorrRomana"])?$_REQUEST["TxtCorrRomana"]:"";

	$TxtRutCliente = isset($_REQUEST["TxtRutCliente"])?$_REQUEST["TxtRutCliente"]:"";
	$CorrInternoCliente = isset($_REQUEST["CorrInternoCliente"])?$_REQUEST["CorrInternoCliente"]:"";
	$TxtNombreCli = isset($_REQUEST["TxtNombreCli"])?$_REQUEST["TxtNombreCli"]:"";
	$TxtCiudadCli = isset($_REQUEST["TxtCiudadCli"])?$_REQUEST["TxtCiudadCli"]:"";
	$TxtVUnitario = isset($_REQUEST["TxtVUnitario"])?$_REQUEST["TxtVUnitario"]:0;
	$TxtDireccionCli = isset($_REQUEST["TxtDireccionCli"])?$_REQUEST["TxtDireccionCli"]:"";
	$TxtObserCliente = isset($_REQUEST["TxtObserCliente"])?$_REQUEST["TxtObserCliente"]:"";
	$TxtDivSAp       = isset($_REQUEST["TxtDivSAp"])?$_REQUEST["TxtDivSAp"]:"";
	$TxtAlmacenSap   = isset($_REQUEST["TxtAlmacenSap"])?$_REQUEST["TxtAlmacenSap"]:"";
	$TxtCliIndicador = isset($_REQUEST["TxtCliIndicador"])?$_REQUEST["TxtCliIndicador"]:"";
	$TxtGiroCliente  = isset($_REQUEST["TxtGiroCliente"])?$_REQUEST["TxtGiroCliente"]:"";
	$TxtContrato     = isset($_REQUEST["TxtContrato"])?$_REQUEST["TxtContrato"]:"";
	
	$TxtRutChofer  = isset($_REQUEST["TxtRutChofer"])?$_REQUEST["TxtRutChofer"]:"";
	$CmbFPago      = isset($_REQUEST["CmbFPago"])?$_REQUEST["CmbFPago"]:"";
	$TxtTranspGiro = isset($_REQUEST["TxtTranspGiro"])?$_REQUEST["TxtTranspGiro"]:"";
	$CmbUnidad     = isset($_REQUEST["CmbUnidad"])?$_REQUEST["CmbUnidad"]:"";
	$TxtObservacionAUX = isset($_REQUEST["TxtObservacionAUX"])?$_REQUEST["TxtObservacionAUX"]:"";
	$TxtObservacionFun = isset($_REQUEST["TxtObservacionFun"])?$_REQUEST["TxtObservacionFun"]:"";
	$txtorinombre = isset($_REQUEST["txtorinombre"])?$_REQUEST["txtorinombre"]:"";
	$txtorilugar  = isset($_REQUEST["txtorilugar"])?$_REQUEST["txtorilugar"]:"";
	$txtoridivsap = isset($_REQUEST["txtoridivsap"])?$_REQUEST["txtoridivsap"]:"";
	$txtorialmacensap = isset($_REQUEST["txtorialmacensap"])?$_REQUEST["txtorialmacensap"]:"";
	$TxtTranspRut = isset($_REQUEST["TxtTranspRut"])?$_REQUEST["TxtTranspRut"]:"";
	$TxtTranspNombre = isset($_REQUEST["TxtTranspNombre"])?$_REQUEST["TxtTranspNombre"]:"";
	$TxtNombreChofer = isset($_REQUEST["TxtNombreChofer"])?$_REQUEST["TxtNombreChofer"]:"";
	$TxtPatenteC = isset($_REQUEST["TxtPatenteC"])?$_REQUEST["TxtPatenteC"]:"";
	$TxtPatenteR = isset($_REQUEST["TxtPatenteR"])?$_REQUEST["TxtPatenteR"]:"";
	$TxtCodSapProducto = isset($_REQUEST["TxtCodSapProducto"])?$_REQUEST["TxtCodSapProducto"]:"";
	$TxtProductoNombre = isset($_REQUEST["TxtProductoNombre"])?$_REQUEST["TxtProductoNombre"]:"";
	$VarConcentracion  = isset($_REQUEST["VarConcentracion"])?$_REQUEST["VarConcentracion"]:"";
	$VarNU     = isset($_REQUEST["VarNU"])?$_REQUEST["VarNU"]:"";
	$TxtSellos = isset($_REQUEST["TxtSellos"])?$_REQUEST["TxtSellos"]:"";
	$msjAnular = isset($_REQUEST["msjAnular"])?$_REQUEST["msjAnular"]:"";
	$NumGuia   = isset($_REQUEST["NumGuia"])?$_REQUEST["NumGuia"]:"";
	$CmbBrazo  = isset($_REQUEST["CmbBrazo"])?$_REQUEST["CmbBrazo"]:"";
	$CmbEstanque = isset($_REQUEST["CmbEstanque"])?$_REQUEST["CmbEstanque"]:"";
	$CmbProd     = isset($_REQUEST["CmbProd"])?$_REQUEST["CmbProd"]:"";
	$VUnitario   = isset($_REQUEST["VUnitario"])?$_REQUEST["VUnitario"]:"";

	$rut =$CookieRut;
	//$Toneladas = str_replace(",","",$Toneladas);
	//echo "Toneladas 1:".$Toneladas."<br>";
	if(trim($Toneladas)=='')
		$Toneladas=0;
	if(trim($TxtMts)=='')
		$TxtMts=0;
	if(trim($FechaHoraRomana)=='undefined')
		$FechaHoraRomana='0000-00-00 00:00:00';
	if(trim($FechaHoraRomana)=='')
		$FechaHoraRomana='0000-00-00 00:00:00';
		
	if(strlen($FechaHoraRomana)>25)
		$FechaHoraRomana=trim(substr($FechaHoraRomana,0,20));
		
		$ArCliente=explode('~',$CmbCliente);
		$CmbCliente=$ArCliente[0];
		//Parametros fijos para xml
		$SISTEMA_ORIGEN=$RUT_EMISOR=$RAZON_SOCIAL_RECEPTOR=$TIPO_DESPACHO=$FORMA_PAGO='';
		$PesoBruto=$PesoTara=$PesoNeto='';

		$ConsultaUser = "select * from proyecto_modernizacion.funcionarios ";
			$ConsultaUser.= " where rut='".$CookieRut."'";
			$Resp=mysqli_query($link, $ConsultaUser);
			$Favoritos="";
			if ($Fila=mysqli_fetch_array($Resp))
			{
				$Favoritos=$Fila["favoritos"];
				$PrimerNombre=$Fila["nombres"];
				for ($i=0;$i<=strlen($PrimerNombre);$i++)
				{
					if (substr($PrimerNombre,$i,1)==" ")
					{
						$PrimerNombre=trim(substr($PrimerNombre,0,$i));
						break;
					}
				}
				$NombreUser = ucwords(strtolower($PrimerNombre))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".strtoupper(substr($Fila["apellido_materno"],0,1)).".";
				$Caduca=$Fila["caduca"];
			}
		
		$FechaHora=$ano."-".$mes."-".$dia." ".$hh.":".$mm.":00";
		$fechaEmision=$dia."-".$mes."-".$ano;
		$TxtRutCliente = str_replace(".", "", $TxtRutCliente);	
		$TxtRutChofer = str_replace(".", "", $TxtRutChofer);		
		//PARAMETROS DUROS
		$consulParam = "select nombre, valor1, valor2 from pac_web.parametros where codigo > '17'";
		$respParams=mysqli_query($link, $consulParam);
		//print_r(mysql_fetch_assoc($respParams));exit();
		$params = array();
		
		while ($FilaParam=mysqli_fetch_assoc($respParams)){
			$params[$FilaParam["nombre"]] = $FilaParam["valor1"];

		}

		$DIRECCION_WS_GDE       = $params["DIRECCION_WS_GDE"];
		$DIRECCION_WS_GDE_ANULA = $params["DIRECCION_WS_GDE_ANULA"];
		$usuario   = $params["USUARIO"];
		$password  = $params["PASSWORD"];

		if ($TxtCliIndicador==5) {
				$TIPO_DESPACHO="3";				
			}elseif ($TxtCliIndicador==6) {
				$TIPO_DESPACHO="2";				
			}else{
				$TIPO_DESPACHO="2";				
			}
			$FORMA_PAGO=$CmbFPago;
			
	$ConsulFechaPesos = "select max(fecha) as fecha from sipa_web.despachos where correlativo='".$TxtCorrRomana."'";
	$RespFecha=mysqli_query($link, $ConsulFechaPesos);
	$FilaPesosFecha=mysqli_fetch_array($RespFecha);
	$PesosFecha = $FilaPesosFecha["fecha"];
	//$PesoBruto = "0";
	//$PesoTara = "0";
	//$PesoNeto = "";
	$ConsulPesos = "select peso_bruto,peso_tara,peso_neto from sipa_web.despachos where correlativo='".$TxtCorrRomana."'";
	$RespPesos=mysqli_query($link, $ConsulPesos);
	$FilaPesos=mysqli_fetch_array($RespPesos);
	
	$PesoBruto = isset($FilaPesos["peso_bruto"])?$FilaPesos["peso_bruto"]:0;
	$PesoTara = isset($FilaPesos["peso_tara"])?$FilaPesos["peso_tara"]:0;
	$PesoNeto = isset($FilaPesos["peso_neto"])?$FilaPesos["peso_neto"]:0;

	if (!$TxtDivSAp) {
		$TxtDivSAp="";
	}
	if (!$TxtAlmacenSap) {
		$TxtAlmacenSap="";
	}
	if (!$TxtTranspGiro) {
		$TxtTranspGiro="SinGiro";
	}
	if (!$TxtGiroCliente) {
		$TxtGiroCliente="SinGiro";
	}
	if (!$CmbUnidad) {
		$CmbUnidad = 1;
		$txtUnidadNm = "KG";
	}
//	echo "Toneladas ".$Toneladas."<br>";
	$Toneladas=$Toneladas;
	if($PesoNeto==0)
		$PesoNeto=$Toneladas*1000;
	$descripcion = $TxtObservacionAUX.'\n'.$TxtObservacionFun;
	$TotalItem=intval($PesoNeto*$TxtVUnitario);
	$Toneladas=number_format(doubleval($Toneladas),3 ); // linea que convierte en miles con 3 decimales ejemplo: 1300 = 1,300.000

	
	$Precio="PRECIO: ".$TxtVUnitario." USD^";
	$xmlHeaderGDE="<soapenv:Envelope xmlns:soapenv='http://schemas.xmlsoap.org/soap/envelope/' xmlns:urn='urn:cdch:Legado:CrearGuiaDespacho:SAPECC'>
   <soapenv:Header/>";
	$xmlBodyGDE="<soapenv:Body>
      <urn:MT_Legado_Request_CrearGuiaDespacho>
         <ORIGINADOR>
            <SISTEMA_ORIGEN>".$params["SISTEMA_ORIGEN"]."</SISTEMA_ORIGEN>
            <ORIGINADOR>".$txtorinombre."</ORIGINADOR>
            <LUGAR_EMISION>".$txtorilugar."</LUGAR_EMISION>
            <USUARIO_EMISOR>".$NombreUser."</USUARIO_EMISOR>
            <DIVISION_ORIGEN_SAP>".$txtoridivsap."</DIVISION_ORIGEN_SAP>
            <ALMACEN_ORIGEN_SAP>".$txtorialmacensap."</ALMACEN_ORIGEN_SAP>
         </ORIGINADOR>
         <EMISOR>
            <RUT_EMISOR>".$params["RUT_EMISOR"]."</RUT_EMISOR>
         </EMISOR>
         <RECEPTOR>
            <RUT_RECEPTOR>".$TxtRutCliente."</RUT_RECEPTOR>
            <RAZON_SOCIAL_RECEPTOR>".$TxtNombreCli."</RAZON_SOCIAL_RECEPTOR>
            <GIRO_RECEPTOR>".$TxtGiroCliente."</GIRO_RECEPTOR>
            <DIRECCION_RECEPTOR>".$TxtDireccionCli."</DIRECCION_RECEPTOR>
            <COMUNA_RECEPTOR>".$TxtCiudadCli."</COMUNA_RECEPTOR>
            <CIUDAD_RECEPTOR>".$TxtCiudadCli."</CIUDAD_RECEPTOR>
         </RECEPTOR>
         <DATOS_CABECERA_GUIA>
            <FECHA_EMISION>".$fechaEmision."</FECHA_EMISION>
            <TIPO_DTE>".$params["TIPO_DTE"]."</TIPO_DTE>
            <INDICADOR_TRASLADO>".$TxtCliIndicador."</INDICADOR_TRASLADO>
            <TIPO_DESPACHO>".$TIPO_DESPACHO."</TIPO_DESPACHO>
            <FORMA_PAGO>".$FORMA_PAGO."</FORMA_PAGO>
         </DATOS_CABECERA_GUIA>
         <TRANSPORTISTA>
            <RUT_TRANSPORTISTA>".$TxtTranspRut."</RUT_TRANSPORTISTA>
            <RAZON_SOCIAL_TRANSPORTISTA>".$TxtTranspNombre."</RAZON_SOCIAL_TRANSPORTISTA>
            <GIRO_TRANSPORTISTA>".$TxtTranspGiro."</GIRO_TRANSPORTISTA>
         </TRANSPORTISTA>
         <TRANSPORTE>
            <RUT_CHOFER>".$TxtRutChofer."</RUT_CHOFER>
            <NOMBRE_CHOFER>".$TxtNombreChofer."</NOMBRE_CHOFER>
            <PATENTE>".$TxtPatenteC."</PATENTE>
            <PATENTE_CARRO>".$TxtPatenteR."</PATENTE_CARRO>
         </TRANSPORTE>
         <DESTINO_MERCANCIA>
            <DIRECCION_DESTINO>".$TxtDireccionCli."</DIRECCION_DESTINO>
            <COMUNA_DESTINO>".$TxtCiudadCli."</COMUNA_DESTINO>
            <CIUDAD_DESTINO>".$TxtCiudadCli."</CIUDAD_DESTINO>
            <DIVISION_DESTINO_SAP>".$TxtDivSAp."</DIVISION_DESTINO_SAP>
            <ALMACEN_DESTINO_SAP>".$TxtAlmacenSap."</ALMACEN_DESTINO_SAP>
         </DESTINO_MERCANCIA>
         <TOTALES>
		 <MONTO_TOTAL>".$TotalItem."</MONTO_TOTAL>    
         </TOTALES>
         <POSICION_GDE>
            <NUMERO_ITEM>1</NUMERO_ITEM>
            <CODIGO_MATERIAL_SAP>".$TxtCodSapProducto."</CODIGO_MATERIAL_SAP>
            <NOMBRE_ITEM>".$TxtProductoNombre."</NOMBRE_ITEM>
 			<CANTIDAD_ITEM>".$PesoNeto."</CANTIDAD_ITEM>
            <UNIDAD_ITEM>".$txtUnidadNm."</UNIDAD_ITEM>
            <PRECIO_UNITARIO_ITEM>".$TxtVUnitario."</PRECIO_UNITARIO_ITEM>
            <TOTAL_ITEM>".$TotalItem."</TOTAL_ITEM>
            <DESCRIPCION_ITEM>^ ^CONTRATO : ".$TxtContrato." ^CONCENTRACION :  ".str_replace('.',',',$VarConcentracion)."%               N.U ".$VarNU."^MTS. CUB: ".str_replace('.',',',$TxtMts)."^CORRELATIVO ROMANA : ".$TxtCorrRomana."^SELLOS : ".$TxtSellos."^".$Precio." ^PESO BRUTO : ".$PesoBruto."^TARA : ".$PesoTara."^CARGA : ".$PesoNeto."^ ^Observaciones: ^".$TxtObservacionFun." ^ ^Funcionario. ".$NombreUser."</DESCRIPCION_ITEM>           
         </POSICION_GDE>
      </urn:MT_Legado_Request_CrearGuiaDespacho>
   </soapenv:Body>
</soapenv:Envelope>";

$xmlEnvioGDE=$xmlHeaderGDE.$xmlBodyGDE;
	echo $DIRECCION_WS_GDE."***".$DIRECCION_WS_GDE_ANULA."***".$usuario."****".$password;
	exit();
	//echo $xmlEnvioGDE;
	//exit();
switch ($Proceso)
{
	
	    case "GDE":
			ModificarPAC($link);
			GenerarGDE($xmlEnvioGDE);	
		
			$codRespuesta = $result["DATOS_RESPUESTA"]["CODIGO_RESPUESTA"];
			$menRespuesta = $result["DATOS_RESPUESTA"]["MENSAJE_RESPUESTA"];
			$NumGuia = $result["DATOS_RESPUESTA"]["FOLIO_GENERADO"];
			$urlGde = $result["DATOS_RESPUESTA"]["URL_GDE"];
			$urlGdeLocal = $result["DATOS_RESPUESTA"]["URL_GDE_LOCAL"];
			if ($msj!='') {
				echo "<script languaje='JavaScript'>";
				echo "alert('".$msj."');";
				echo "window.close();";
				echo "</script>";
			}
			else{
	
				if ($codRespuesta=="OK"){
					$RespuestaWS = "<CODIGO_RESPUESTA>: ".$codRespuesta."<MENSAJE_RESPUESTA>: ".$menRespuesta."<FOLIO_GENERADO>: ".$NumGuia."<URL_GDE>: ".$urlGde."<URL_GDE_LOCAL>: ".$urlGdeLocal;
					
					$Insertar2="insert into pac_web.pac_logs (nro_guia,fecha_emision_acepta,url_gde,url_gde_local,xml_emitido,xml_recepcionado,rut,fecha_hora_registro) values (";
					$Insertar2 = $Insertar2."'".$NumGuia."','".$FechaHora."','".$urlGde."','".$urlGdeLocal."','".$xmlBodyGDE."','".$RespuestaWS."','".$rut."','".$fechaEmision."')";
					
					$resultInsertLog = mysqli_query($link, $Insertar2);
					if (!$resultInsertLog) {
					die('No se pudo registrar la guia en logs: ' . mysql_error());
					}
					
					$Modificar="UPDATE pac_web.guia_despacho set num_guia='".$NumGuia."' where correlativo = '".$Correlativo."' ";
					mysqli_query($link, $Modificar);
					
					//Actualiza la informacion en SIPA una vez generada la GDE 
					// LUIS CASTILLO 17-03-2022
					$Consulta ="select t3.cod_sipa,t1.rut_transportista,t1.descripcion,t1.sellos,t1.num_guia,t1.corr_interno_cliente,t1.nro_patente,t1.rut_chofer,t2.nombre,t1.rut_cliente from pac_web.guia_despacho t1 ";
					$Consulta.="left join pac_web.choferes t2 on t1.rut_chofer=t2.rut_chofer ";									
					$Consulta.="left join pac_web.pac_productos t3 on t1.cod_producto=t3.cod_producto ";									
					$Consulta.="where t1.num_guia='".$NumGuia."' and t1.nro_patente ='".$TxtPatenteC."'  order by fecha_hora desc";
					$RespPac=mysqli_query($link, $Consulta);
					$FilaPac=mysqli_fetch_array($RespPac);				
					$SubProd=explode('~',$FilaPac["cod_sipa"]);
					$CodProd=$SubProd[0];
					$CodSub=$SubProd[1];
					
					
					$Consulta="select distinct cod_grupo from sipa_web.grupos_prod_subprod  where cod_producto='46' and cod_subproducto='1'";
					$RespGrupo=mysqli_query($link, $Consulta);
					$FilaGrupo=mysqli_fetch_array($RespGrupo);
					$CmbGrupoProd=$FilaGrupo["cod_grupo"];
					$CmbProveedor=$FilaPac["rut_cliente"].'~'.$FilaPac["corr_interno_cliente"];
					$CmbTipoDespacho='V';
					$TxtRutChofer=$FilaPac["rut_chofer"];
					$TxtNomChofer=$FilaPac["nombre"];
					$Consulta ="select nombre from pac_web.transportista where rut_transportista='".$FilaPac["rut_transportista"]."'";
					$RespTransP = mysqli_query($link, $Consulta);
					$FilaTransP = mysqli_fetch_array($RespTransP);
					$TxtTransp=$FilaTransP["nombre"];
					$Modificar="UPDATE sipa_web.despachos set guia_despacho='".$NumGuia."',rut_prv='".$CmbProveedor."',rut_chofer='".$TxtRutChofer."',nombre_chofer='".$TxtNomChofer."',transportista='".$TxtTransp."',";
					$Modificar.="cod_producto='".$CodProd."', cod_subproducto='".$CodSub."'  where correlativo = '".$TxtCorrRomana."' ";			
					mysqli_query($link, $Modificar);
					//FIN DE MANTENCION LUIS CASTILLO 17-03-2022
				
					echo "<script languaje='JavaScript'>";
					echo "alert('".$menRespuesta." Nro. ".$NumGuia."');";
					echo "window.open('".$urlGdeLocal."','','top=0,left=0,width=770,height=480,scrollbars=yes,resizable = yes,status=yes');";
					echo "window.opener.document.FrmGuia.action='pac_guia_despacho.php';";
					echo "window.opener.document.FrmGuia.submit();";
					echo "window.close();";
					echo "</script>";
				}
				elseif(trim($codRespuesta)=="ERROR"){
			
				$menRespuesta=str_replace("'","",$menRespuesta);
				$menRespuesta=str_replace("{http://www.sii.cl/SiiDte}","",$menRespuesta);
					echo "<script languaje='JavaScript'>";
					echo "alert('ERROR DESDE SII :\\n- ".$menRespuesta."');";
					echo "</script>";
			
		    	}
				else
				{
					echo "XML ".$xmlEnvioGDE."<br>";
					echo "<font color='#FF0000'>ERROR EN COMUNICACION AL WS SII </font><br><br><br> ".print_r($result)."<br>";
				}
		
			}
		break;	
		case "N":				
				if ($Ver=='C')//Graba Para los Camiones  
				{
					$Consulta="select * from pac_web.guia_despacho where num_guia='".$NumGuia."' and num_guia!=''";
					$Respuesta=mysqli_query($link, $Consulta);
					/*echo $Consulta;exit();*/
					if ($Fila=mysqli_fetch_array($Respuesta))
					{
						header("location:pac_guia_despacho_proceso.php?Mostrar=S");
					}
					else
					{   					
					/*echo "toy aki";exit();*/
					//echo "<br>Toneladas 2:".$Toneladas;
					$Toneladas = str_replace(",","",$Toneladas);
					//echo "<br>Toneladas:".$Toneladas;
					//echo "<br>Mts:".$TxtMts;
					$Insertar="insert into pac_web.guia_despacho (num_guia,nro_patente,nro_patente_rampla,rut_transportista,rut_cliente,fecha_hora, ";
					$Insertar.=" brazo_carga,toneladas,volumen_m3,descripcion,estado,cod_estanque,rut_funcionario,tipo_guia,valor_unitario,rut_chofer,fecha_hora_romana,corr_romana,div_sap,almacen_sap,sellos,cod_producto,cod_unidad,cod_originador,corr_interno_cliente) values ";
					$Insertar.=" ('".$NumGuia."','".$CmbPatente."','".$CmbPatenteRampla."','".$CmbTransp."','".$CmbCliente."','".$FechaHora."','".$CmbBrazo."', ";
					$Insertar.=" '".$Toneladas."','".str_replace(",",".",$TxtMts)."','".$descripcion."','S','".$CmbEstanque."','".$rut."','C','".str_replace(",",".",$VUnitario)."','$CmbChofer','$FechaHoraRomana','$TxtCorrRomana','$TxtDivSAp','$TxtAlmacenSap','$TxtSellos','$CmbProd','$CmbUnidad','$CmbOri','$CorrInternoCliente')";
					//$Insertar.=" '".str_replace(",",".",$Toneladas)."','".str_replace(",",".",$TxtMts)."','".$descripcion."','S','".$CmbEstanque."','".$rut."','C','".str_replace(",",".",$VUnitario)."','$CmbChofer','$FechaHoraRomana','$TxtCorrRomana','$TxtDivSAp','$TxtAlmacenSap','$TxtSellos','$CmbProd','$CmbUnidad','$CmbOri','$CorrInternoCliente')";
					//echo $Insertar;
					$result = mysqli_query($link, $Insertar);
					if (!$result) {
    				die('No se pudo crear la guia en el sistema: ' . mysql_error()."<br><br>".$Insertar);
					}
					$msg="Registro de Guia Camion Guardado Correctamente";
					//echo "Inser ".$Insertar."<br>";
								
					$Insertar="insert into pac_web.movimientos(fecha_hora,toneladas,volumen_m3,cod_estanque_origen,tipo_movimiento,rut_funcionario, ";
					$Insertar.= " hora_inicio,hora_final) values ";
					$Insertar.=" ('".$FechaHora."','".str_replace(",",".",$Toneladas)."','".str_replace(",",".",$TxtMts)."','".$CmbEstanque."','5','".$rut."','".$HoraI."','".$HoraT."')  ";
					$result = mysqli_query($link, $Insertar);
					if (!$result) {
    				die('No se pudo registrar el movimento en el sistema: ' . mysql_error());
					}
					//echo "Inser ".$Insertar."<br>";
					$Actualiza ="UPDATE sipa_web.datos_ejes set cod_transportista='".substr($CmbTransp, 0, strlen($CmbTransp) - 2)."',";
					$Actualiza.="nom_transportista='',";
					$Actualiza.= "guia='".trim($NumGuia)."',";
					$Actualiza.= "cod_tipo_carga='5',";
					$Actualiza.= "tipo_carga='LIQUIDA',";
					$Actualiza.= "validar_tolerancia='N' ";
					$Actualiza.= "where patente='".trim($CmbPatente)."' and folio='".trim($TxtCorrRomana)."'";
					$result2 = mysqli_query($link, $Actualiza);
					if (!$result2) {
    				die('No se actualizo los registro del SIPA: ' . mysql_error());
					}
					//echo "Actualiza ".$Actualiza."<br>";
												
					}
				}
				else//Graba en caso de buque    
				{
							$Consulta="select * from pac_web.guia_despacho where num_guia='".$NumGuia."'";
							$Respuesta=mysqli_query($link, $Consulta);
							if ($Fila=mysqli_fetch_array($Respuesta))
							{
								header("location:pac_guia_despacho_proceso.php?Mostrar=S");
							}
							else
							{
								$Insertar="insert into pac_web.guia_despacho (num_guia,nro_patente,rut_transportista,rut_cliente,fecha_hora, ";
								$Insertar.=" brazo_carga,toneladas,volumen_m3,descripcion,estado,cod_estanque,rut_funcionario,tipo_guia,valor_unitario) values ";
								$Insertar.=" ('".$NumGuia."','".$CmbPatente."','".$CmbTransp."','".$CmbCliente."','".$FechaHora."','".$CmbBrazo."', ";
								$Insertar.=" '".str_replace(",",".",$Toneladas)."','".str_replace(",",".",$TxtMts)."','".$descripcion."','S','','".$rut."','B','".str_replace(",",".",$VUnitario)."')";
								mysqli_query($link, $Insertar);
								$Consulta="select valor1 from pac_web.parametros where codigo='1'";
								$Respuesta=mysqli_query($link, $Consulta);
								$Fila=mysqli_fetch_array($Respuesta);
								$Densidad=str_replace('.',',',$Fila["valor1"]);						
								if($TxtEK1!='')
								{
									$TxtMts=((str_replace(",",".",$TxtEK1)*10000)/$Densidad)/10000;
									$Insertar="insert into pac_web.movimientos(fecha_hora,toneladas,volumen_m3,cod_estanque_origen,tipo_movimiento,rut_funcionario, ";
									$Insertar.= " hora_inicio,hora_final) values ";
									$Insertar.=" ('".$FechaHora."','".str_replace(",",".",$TxtEK1)."','".str_replace(",",".",$TxtMts)."','1','7','".$rut."','".$HoraI."','".$HoraT."')  ";
									mysqli_query($link, $Insertar);
									//echo $Insertar;
								}
								if($TxtEK2!='')
								{
									$TxtMts=((str_replace(",",".",$TxtEK2)*10000)/$Densidad)/10000;
									$Insertar="insert into pac_web.movimientos(fecha_hora,toneladas,volumen_m3,cod_estanque_origen,tipo_movimiento,rut_funcionario, ";
									$Insertar.= " hora_inicio,hora_final) values ";
									$Insertar.=" ('".$FechaHora."','".str_replace(",",".",$TxtEK2)."','".str_replace(",",".",$TxtMts)."','2','7','".$rut."','".$HoraI."','".$HoraT."')  ";
									mysqli_query($link, $Insertar);
									//echo $Insertar;
								}
								if($TxtEK3!='')
								{
									$TxtMts=((str_replace(",",".",$TxtEK3)*10000)/$Densidad)/10000;
									$Insertar="insert into pac_web.movimientos(fecha_hora,toneladas,volumen_m3,cod_estanque_origen,tipo_movimiento,rut_funcionario, ";
									$Insertar.= " hora_inicio,hora_final) values ";
									$Insertar.=" ('".$FechaHora."','".str_replace(",",".",$TxtEK3)."','".str_replace(",",".",$TxtMts)."','3','7','".$rut."','".$HoraI."','".$HoraT."')  ";
									mysqli_query($link, $Insertar);
									//echo $Insertar;
								}
								if($TxtEK4!='')
								{
									$TxtMts=((str_replace(",",".",$TxtEK4)*10000)/$Densidad)/10000;
									$Insertar="insert into pac_web.movimientos(fecha_hora,toneladas,volumen_m3,cod_estanque_origen,tipo_movimiento,rut_funcionario, ";
									$Insertar.= " hora_inicio,hora_final) values ";
									$Insertar.=" ('".$FechaHora."','".str_replace(",",".",$TxtEK4)."','".str_replace(",",".",$TxtMts)."','4','7','".$rut."','".$HoraI."','".$HoraT."')  ";
									mysqli_query($link, $Insertar);
									//echo $Insertar;
									$msg="Registro de Guia Buque Guardado Correctamente";
								}
								
							}
				}
				
			
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.FrmGuia.action='pac_guia_despacho.php';";
			echo "window.opener.document.FrmGuia.submit();";
			echo "window.close();";
			echo "</script>";
	
		break;
		case "M":
		
			ModificarPAC($link);
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.FrmGuia.action='pac_guia_despacho.php';";
			echo "window.opener.document.FrmGuia.submit();";
			echo "window.close();";
			echo "</script>";
			
			break;
		case "A":

		/*		
		echo $NG." <br>";
		echo $TxtObs;
		exit();*/
		$consultaGDE ="select * from pac_web.guia_despacho where num_guia ='".$NG."'";
		$respuesta=mysqli_query($link, $consultaGDE);
		$fila1=mysqli_fetch_array($respuesta);
		$rutCliente=$fila1["rut_cliente"];
		$codOri=$fila1["cod_originador"];
		$fechaEmision=$fila1["fecha_hora"];
		
		$consultaGDE ="select peso_neto from sipa_web.despachos where guia_despacho ='".$NG."'";
		$respuesta=mysqli_query($link, $consultaGDE);
		$fila3=mysqli_fetch_array($respuesta);

		$consulOri ="select rut from pac_web.pac_originador where cod_originador ='".$codOri."'";
		$respOri=mysqli_query($link, $consulOri);
		$fila2=mysqli_fetch_array($respOri);
		$rutEmisor=$fila2["rut"];
		
		$vUni=$fila1["valor_unitario"];
		$ton=$fila3["peso_neto"];

		$montoTotal=$ton*$vUni;
		$fechaActual=date("d-m-Y H:i:s");
		/*echo $fechaActual;exit();*/
//".$NG."
$xmlHeaderAnular="<soapenv:Envelope xmlns:soapenv='http://schemas.xmlsoap.org/soap/envelope/' xmlns:urn='urn:cdch:Legado:AnularGuiaDespacho:SAPECC'>
   <soapenv:Header/>";
   $xmlBodyAnular="<soapenv:Body>
      <urn:MT_Legado_Request_AnularGuiaDespacho>
         <ANULACION_GDE>
            <RUT_EMISOR>".$rutEmisor."</RUT_EMISOR>
            <FECHA_SOLICITUD>".$fechaActual."</FECHA_SOLICITUD>
            <TIPO_DTE>".$params["TIPO_DTE"]."</TIPO_DTE>
            <FOLIO>".$NG."</FOLIO>
            <MOTIVO_ANULACION>DVEN-PAC: ".$TxtObs."</MOTIVO_ANULACION>
            <RAZON_SOCIAL_RECEPTOR>".$rutCliente."</RAZON_SOCIAL_RECEPTOR>
            <RUT_RECEPTOR>".str_replace(".", "", $rutCliente)."</RUT_RECEPTOR>
            <MONTO_TOTAL>".$montoTotal."</MONTO_TOTAL>
            <TEXTO_CODIGO_ANULACION>".$params["ANULACION_ASUNTO"]."</TEXTO_CODIGO_ANULACION>
            <CODIGO_ANULACION>".$params["CODIGO_ANULACION"]."</CODIGO_ANULACION>
            <MAIL_RECEPTOR>".$params["ANULACION_CORREO_RECEPTOR"]."</MAIL_RECEPTOR>
            <MAIL_EMISOR>".$params["ANULACION_CORREO_EMISOR"]."</MAIL_EMISOR>
            <ASUNTO_MAIL>".$params["TEXTO_CODIGO_ANULACION"]."</ASUNTO_MAIL> 
         </ANULACION_GDE>
      </urn:MT_Legado_Request_AnularGuiaDespacho>
   </soapenv:Body>
</soapenv:Envelope>
";
	$xmlEnvioAnular=$xmlHeaderAnular.$xmlBodyAnular;


		AnularGDE($xmlEnvioAnular);
		
		/*echo "<br><br>";
		echo $xmlEnvioAnular;exit();*/
		$codRespuesta = $resultAnular["DATOS_RESPUESTA"]["CODIGO_RESPUESTA"];
		$menRespuesta = $resultAnular["DATOS_RESPUESTA"]["MENSAJE_RESPUESTA"];

		$respuestaWS = "<DATOS_RESPUESTA><CODIGO_RESPUESTA>".$codRespuesta."</CODIGO_RESPUESTA><MENSAJE_RESPUESTA>".$menRespuesta."</MENSAJE_RESPUESTA></DATOS_RESPUESTA>";

		if ($msjAnular!='') {
			echo "<script languaje='JavaScript'>";
			echo "alert('No se pudo anular la guia -> ".$msjAnular."');";
			echo "window.close();";
			echo "</script>";
		}
		else{

			if ($codRespuesta=="OK"){

					$Guia=$NG;
					/*echo $Guia;exit();*/
					$Actualizar ="UPDATE pac_web.guia_despacho set estado ='N'  where num_guia ='".$Guia."'";
					$result =mysqli_query($link, $Actualizar);
					if (!$result) {
    				die('No se pudo anular la guia en el sistema: ' . mysql_error());
					}
					$Consulta=" select fecha_hora from pac_web.guia_despacho where num_guia = '".$Guia."'  ";
					$Respuesta=mysqli_query($link, $Consulta);
					$Fila=mysqli_fetch_array($Respuesta);   
					$Eliminar ="delete from pac_web.movimientos where fecha_hora = '".$Fila["fecha_hora"]."' and tipo_movimiento = '5' ";
					$delete = mysqli_query($link, $Eliminar);
					if (!$delete) {
    				die('No se registro la guia anulada: ' . mysql_error());
					}

				$Insertar2="insert into pac_web.pac_anulacion_guia (nro_guia,fecha_emision_acepta,xml_emitido,xml_recepcionado,rut,fecha_hora_registro,observacion) values (";
				$Insertar2 = $Insertar2."'".$Guia."','".$fechaEmision."','".$xmlBodyAnular."','".$respuestaWS."','".$rutEmisor."','".$fechaActual."','".$TxtObs."')";

				$resultInsertLog = mysqli_query($link, $Insertar2);
				if (!$resultInsertLog) {
				echo $Insertar2;
    			die('No se pudo registrar la guia en logs: ' . mysql_error());
				}
/*					echo "Se creo bien la guia oe     <br>";
					echo $Insertar2;exit();*/

					$msg="Guia anulada en el sistema";
			}else{
					echo "<script languaje='JavaScript'>";
					echo "alert('".$menRespuesta." Mensaje de error de generacion');";
					echo "window.close();";
					echo "</script>";
			}

		}	
			echo "<script languaje='JavaScript'>";
			echo "alert('".$msg."');";
			echo "alert('".$menRespuesta."');";
			echo "window.opener.document.FrmGuia.action='pac_guia_despacho.php';";
			echo "window.opener.document.FrmGuia.submit();";
			echo "window.close();";
			echo "</script>";
			ob_start();
			//header("location:pac_guia_despacho.php?CmbTipoGuia=V");
			break;

		case "I":
			$Datos=$Valores;
			for ($i=0;$i<=strlen($Datos);$i++)
			{
				if (substr($Datos,$i,2)=="//")
				{
					$Guia=substr($Datos,0,$i);
					$Actualizar="UPDATE pac_web.guia_despacho set estado ='I' where num_guia = '".$Guia."'";
					mysqli_query($link, $Actualizar);
					$Datos=substr($Datos,$i+2);
					$i=0;
				}
			}	
		header("location:pac_guia_despacho.php?Proceso=".$Proceso);
		break;
		case "S":
			header("location:pac_guia_despacho.php?Proceso=G");
		break;

		case "E":
			$ArrayCodPAC=explode('//',$Valores);
			//echo $Valores;
			foreach( $ArrayCodPAC as $value )
			{
    	   		if( $value!= '' )
    	   		{
	       			$Actualizar="delete from pac_web.guia_despacho where correlativo = '".$value."' ";
	       			//echo $Actualizar;
	       			mysqli_query($link, $Actualizar);
    	   		}
			}	
			header("location:pac_guia_despacho.php?CmbTipoGuia=".$CmbTipoGuia."&CmbMes=".$CmbMes."&CmbAno=".$CmbAno);
			    			
		break;

}

//-------------------------------------------------

function ModificarPAC($link)
{
	
	global $FechaHoraRomana;
	global $Correlativo;
	global $Toneladas;
	global $NumGuia;
	global $rut;
	global $HoraI;
	global $HoraT;
	global $VUnitario;
	global $Ver;
	global $CmbChofer;
	global $descripcion;
	global $CmbEstanque;
	global $CmbCliente;
	global $CmbTransp;
	global $TxtMts;
	global $CmbPatenteRampla;
	global $CmbPatente;
	global $CmbBrazo;
	global $TxtCorrRomana;
	
	//$Toneladas = str_replace(",","",$Toneladas);
	if(strlen($FechaHoraRomana)>25)
		$FechaHoraRomana=trim(substr($FechaHoraRomana,0,20));
			if ($Ver=='C')
			{
				$Modificar="UPDATE pac_web.guia_despacho set num_guia='".$NumGuia."',nro_patente='".$CmbPatente."',nro_patente_rampla='".$CmbPatenteRampla."',rut_transportista='".$CmbTransp."',rut_cliente='".$CmbCliente."', ";
				$Modificar.=" brazo_carga = '".$CmbBrazo."',toneladas = '".str_replace(",","",$Toneladas)."',volumen_m3='".str_replace(",",".",$TxtMts)."', descripcion ='".$descripcion."',cod_estanque='".$CmbEstanque."',valor_unitario='".str_replace(",",".",$VUnitario)."',rut_chofer='$CmbChofer',corr_romana='$TxtCorrRomana' ";
				if($FechaHoraRomana!='0000-00-00 00:00:00')
					$Modificar.=",fecha_hora_romana='$FechaHoraRomana'";
				$Modificar.=" where correlativo = '".$Correlativo."' ";
				mysqli_query($link, $Modificar);
				$Consulta=" select fecha_hora from pac_web.guia_despacho where correlativo = '".$Correlativo."'  ";
				$Respuesta1=mysqli_query($link, $Consulta);
				$Fila1=mysqli_fetch_array($Respuesta1);   
				$Modificar="UPDATE pac_web.movimientos set toneladas = '".str_replace(",","",$Toneladas)."',volumen_m3='".str_replace(",",".",$TxtMts)."',cod_estanque_origen = '".str_replace(",",".",$CmbEstanque)."' where fecha_hora = '".$Fila1["fecha_hora"]."' ";
				mysqli_query($link, $Modificar);
				//echo $Modificar."<br>";
			}
			else
			{
				$Modificar="UPDATE pac_web.guia_despacho set num_guia='".$NumGuia."',rut_transportista='".$CmbTransp."',rut_cliente='".$CmbCliente."',nro_patente='".$CmbPatente."',";
				$Modificar.=" brazo_carga = '".$CmbBrazo."',toneladas = '".str_replace(",","",$Toneladas)."',volumen_m3='".str_replace(",",".",$TxtMts)."',descripcion ='".$descripcion."',cod_estanque='".$CmbEstanque."',valor_unitario='".str_replace(",",".",$VUnitario)."'";
				$Modificar.=" where correlativo= '".$Correlativo."' ";
				mysqli_query($link, $Modificar);
			//	echo $Modificar."<br>";
				$Consulta=" select fecha_hora from pac_web.guia_despacho where correlativo = '".$Correlativo."'  ";
				$Respuesta1=mysqli_query($link, $Consulta);
				$Fila1=mysqli_fetch_array($Respuesta1);
				$Consulta="consulta * from pac_web.movimientos where fecha_hora = '".$Fila1["fecha_hora"]."' ";
				$Respuesta2=mysqli_query($link, $Consulta);
				$Fila2=mysqli_fetch_array($Respuesta2);
				$HoraI = $Fila2["hora_inicio"];
				$HoraT = $Fila2["hora_final"];
				$Eliminar="delete from pac_web.movimientos where fecha_hora = '".$Fila1["fecha_hora"]."' ";
				mysqli_query($link, $Eliminar);
				$Consulta="select valor1 from pac_web.parametros where codigo='1'";
				$Respuesta=mysqli_query($link, $Consulta);
				$Fila=mysqli_fetch_array($Respuesta);
				$Densidad=str_replace('.',',',$Fila["valor1"]);						
				if($TxtEK1!='')
				{
					$TxtMts=((str_replace(",",".",$TxtEK1)*10000)/$Densidad)/10000;
					$Insertar="insert into pac_web.movimientos(fecha_hora,toneladas,volumen_m3,cod_estanque_origen,tipo_movimiento,rut_funcionario, ";
					$Insertar.= " hora_inicio,hora_final) values ";
					$Insertar.=" ('".$Fila1["fecha_hora"]."','".str_replace(",",".",$TxtEK1)."','".str_replace(",",".",$TxtMts)."','1','7','".$rut."','".$HoraI."','".$HoraT."')  ";
					mysqli_query($link, $Insertar);
				//echo "INSERtAR  1".$Insertar;
				}
				if($TxtEK2!='')
				{
					$TxtMts=((str_replace(",",".",$TxtEK2)*10000)/$Densidad)/10000;
					$Insertar="insert into pac_web.movimientos(fecha_hora,toneladas,volumen_m3,cod_estanque_origen,tipo_movimiento,rut_funcionario, ";
					$Insertar.= " hora_inicio,hora_final) values ";
					$Insertar.=" ('".$Fila1["fecha_hora"]."','".str_replace(",",".",$TxtEK2)."','".str_replace(",",".",$TxtMts)."','2','7','".$rut."','".$HoraI."','".$HoraT."')  ";
					mysqli_query($link, $Insertar);
				//		echo "INSERtAR 2".$Insertar;
				}
				if($TxtEK3!='')
				{
					$TxtMts=((str_replace(",",".",$TxtEK3)*10000)/$Densidad)/10000;
					$Insertar="insert into pac_web.movimientos(fecha_hora,toneladas,volumen_m3,cod_estanque_origen,tipo_mo
					vimiento,rut_funcionario, ";
					$Insertar.= " hora_inicio,hora_final) values ";
					$Insertar.=" ('".$Fila1["fecha_hora"]."','".str_replace(",",".",$TxtEK3)."','".str_replace(",",".",$TxtMts)."','3','7','".$rut."','".$HoraI."','".$HoraT."')  ";
					mysqli_query($link, $Insertar);
				//	echo "INSERtAR 3".$Insertar;
				}
				if($TxtEK4!='')
				{
					$TxtMts=((str_replace(",",".",$TxtEK4)*10000)/$Densidad)/10000;
					$Insertar="insert into pac_web.movimientos(fecha_hora,toneladas,volumen_m3,cod_estanque_origen,tipo_movimiento,rut_funcionario, ";
					$Insertar.= " hora_inicio,hora_final) values ";
					$Insertar.=" ('".$Fila1["fecha_hora"]."','".str_replace(",",".",$TxtEK4)."','".str_replace(",",".",$TxtMts)."','4','7','".$rut."','".$HoraI."','".$HoraT."')  ";
					mysqli_query($link, $Insertar);
				//	echo "INSERtAR 4".$Insertar;
				}
			}
	}
function GenerarGDE($envio)
{

	global $DIRECCION_WS_GDE;
	global $usuario;
	global $password;
	global $result;
	global $msj;
   
try{  

$WSDL=$DIRECCION_WS_GDE;
$RRR=$envio;

$client=new nusoap_client($WSDL);
$client->setCredentials($usuario,$password); 
$result =$client->send($RRR,"SI_LEGADO_CrearGuiaDespacho");

$err = $client->getError();
if ($err) {
     echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
     $msj = "Error al generar la guia en estos momentos. Constructor";
}
if ($client->fault) {
    echo 'Falla En Servicio Sonic';
    $msj = "Error al generar la guia en estos momentos. Sonic";
    print_r($result);
   }
else {

		// Check for errors
		$err = $client->getError();
		if ($err) {
			// Display the error
			$msj = "Error al generar la guia en estos momentos. Display";
			echo 'Error:' . $err . '';
		} else {
			// Display the result
	 	  //  print_r($result);
		}
	}
	
	
}catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
    $msj = "Error al generar la guia en estos momentos. Try Catch";
}

}

function AnularGDE($xmlGDE){

	global $DIRECCION_WS_GDE_ANULA;
	global $NAMESPACE_WS_GDE_ANULA;
	global $usuario;
	global $password;
	global $resultAnular;
	global $msjAnular;

try{

$WSDL=$DIRECCION_WS_GDE_ANULA;
$mynamespace=$DIRECCION_WS_GDE_ANULA;
$RRR=$xmlGDE;

$client=new nusoap_client($WSDL);
$client->setCredentials($usuario,$password); 
$resultAnular =$client->send($RRR,"SI_LEGADO_AnularGuiaDespacho");
$err = $client->getError();
if ($err) {
      $msjAnular="Error al anular la guia en estos momentos. ";
}
if ($client->fault) {
    $msjAnular="Error al anular la guia en estos momentos.";
    print_r($resultAnular);
   }
else {

		// Check for errors
		$err = $client->getError();
		if ($err) {
			// Display the error
			$msjAnular = "Error al generar la guia en estos momentos. Display";
			echo 'Error:' . $err . '';
		} else {
			// Display the result
	/* print_r($resultAnular);*/
			
		}
	}
	
	
}catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
    $msj = "Error al generar la guia en estos momentos. Try Catch";
}

}


?>