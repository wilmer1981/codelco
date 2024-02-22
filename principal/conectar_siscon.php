<?php
	include_once('config.inc.php');
$link = mysql_connect(CONEXION_HOST_BD,CONEXION_HOST_USER,CONEXION_HOST_PWD);
	mysql_select_db("siscon", $link);
	$IP_SERV = $HTTP_HOST;
	$IP_USER = $REMOTE_ADDR;
	$Dias = array("Domingo","Lunes","Martes","Mi&eacute;rcoles","Jueves","Viernes","Sábado");
	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	//ARREGLO DE PARAMETROS DE LEYES PARA SISTEMA DE AGENCIA, PROD. MINEROS
	$ArrParamLeyes = array();
	$ArrParamLeyes["01"][0] = 1; //COD_UNIDAD
	$ArrParamLeyes["01"][1] = ""; //CONVERSION
	$ArrParamLeyes["01"][2] = 2; //CANT DECIMALES LEYES
	$ArrParamLeyes["01"][3] = ""; //ABREVIATURA UNIDAD
	$ArrParamLeyes["01"][4] = 0; //CANT DECIMALES FINOS
	
	$ArrParamLeyes["02"][0] = 1;
	$ArrParamLeyes["02"][2] = 2;
	$ArrParamLeyes["02"][4] = 0;
	
	$ArrParamLeyes["04"][0] = 4;
	$ArrParamLeyes["04"][2] = 0;	
	$ArrParamLeyes["04"][4] = 0;
	
	$ArrParamLeyes["05"][0] = 4;
	$ArrParamLeyes["05"][2] = 1;
	$ArrParamLeyes["05"][4] = 0;
	
	$ArrParamLeyes["07"][0] = 1;
	$ArrParamLeyes["07"][2] = 0;
	$ArrParamLeyes["07"][4] = 0;
	
	$ArrParamLeyes["08"][0] = 2;
	$ArrParamLeyes["08"][2] = 0;
	$ArrParamLeyes["08"][4] = 0;
	
	$ArrParamLeyes["09"][0] = 2;
	$ArrParamLeyes["09"][2] = 0;
	$ArrParamLeyes["09"][4] = 0;
	
	$ArrParamLeyes["10"][0] = 2;
	$ArrParamLeyes["10"][2] = 0;
	$ArrParamLeyes["10"][4] = 0;
	
	$ArrParamLeyes["11"][0] = 2;
	$ArrParamLeyes["11"][2] = 0;
	$ArrParamLeyes["11"][4] = 0;
	
	$ArrParamLeyes["117"][0] = 2;
	$ArrParamLeyes["117"][2] = 0;
	$ArrParamLeyes["117"][4] = 0;
	
	$ArrParamLeyes["118"][0] = 1;
	$ArrParamLeyes["118"][2] = 0;
	$ArrParamLeyes["118"][4] = 0;
	
	$ArrParamLeyes["12"][0] = 2;
	$ArrParamLeyes["12"][2] = 0;
	$ArrParamLeyes["12"][4] = 0;
	
	$ArrParamLeyes["25"][0] = 1;
	$ArrParamLeyes["25"][2] = 0;
	$ArrParamLeyes["25"][4] = 0;
	
	$ArrParamLeyes["26"][0] = 1;
	$ArrParamLeyes["26"][2] = 0;
	$ArrParamLeyes["26"][4] = 0;
	
	$ArrParamLeyes["27"][0] = 2;
	$ArrParamLeyes["27"][2] = 0;
	$ArrParamLeyes["27"][4] = 0;
	
	$ArrParamLeyes["30"][0] = 2;
	$ArrParamLeyes["30"][2] = 0;
	$ArrParamLeyes["30"][4] = 0;
	
	$ArrParamLeyes["31"][0] = 1;
	$ArrParamLeyes["31"][2] = 0;
	$ArrParamLeyes["31"][4] = 0;
	
	$ArrParamLeyes["34"][0] = 2;
	$ArrParamLeyes["34"][2] = 0;
	$ArrParamLeyes["34"][4] = 0;
	
	$ArrParamLeyes["36"][0] = 2;
	$ArrParamLeyes["36"][2] = 0;
	$ArrParamLeyes["36"][4] = 0;
	
	$ArrParamLeyes["39"][0] = 2;
	$ArrParamLeyes["39"][2] = 0;
	$ArrParamLeyes["39"][4] = 0;
	
	$ArrParamLeyes["40"][0] = 2;
	$ArrParamLeyes["40"][2] = 0;
	$ArrParamLeyes["40"][4] = 0;
	
	$ArrParamLeyes["41"][0] = 1;
	$ArrParamLeyes["41"][2] = 0;
	$ArrParamLeyes["41"][4] = 0;
	
	$ArrParamLeyes["44"][0] = 2;
	$ArrParamLeyes["44"][2] = 0;
	$ArrParamLeyes["44"][4] = 0;	
										
	$ArrParamLeyes["48"][0] = 2;
	$ArrParamLeyes["48"][2] = 0;
	$ArrParamLeyes["48"][4] = 0;
	
	$ArrParamLeyes["50"][0] = 1;
	$ArrParamLeyes["50"][2] = 0;
	$ArrParamLeyes["50"][4] = 0;
	
	$ArrParamLeyes["54"][0] = 1;
	$ArrParamLeyes["54"][2] = 0;
	$ArrParamLeyes["54"][4] = 0;
	
	$ArrParamLeyes["58"][0] = 2;
	$ArrParamLeyes["58"][2] = 0;
	$ArrParamLeyes["58"][4] = 0;
	
	$ArrParamLeyes["82"][0] = 1;
	$ArrParamLeyes["82"][2] = 0;
	$ArrParamLeyes["82"][4] = 0;
	reset($ArrParamLeyes);
	while (list($k,$v)=each($ArrParamLeyes))
	{
		$ConsultaX = "select * from proyecto_modernizacion.unidades where cod_unidad='".$v[0]."'";
		$RespX = mysqli_query($link, $ConsultaX);
		if ($FilaX = mysqli_fetch_array($RespX))
		{
			$ArrParamLeyes[$k][1] = $FilaX["conversion"];
			$ArrParamLeyes[$k][3] = $FilaX["abreviatura"];
		}
	}
?>
