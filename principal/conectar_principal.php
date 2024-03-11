<?php
	include_once('config.inc.php');
	//include_once('config.php');

	//////// agregado por WSO //////////
	
	if(isset($_COOKIE["CookieRut"])){
		$CookieRut = $_COOKIE["CookieRut"]; 
	}else{
		$CookieRut = ""; 
	}

	//$CookieRut = $_COOKIE["CookieRut"]; 

    $link = mysqli_connect(CONEXION_HOST_BD,CONEXION_HOST_USER,CONEXION_HOST_PWD,"proyecto_modernizacion") or die ("Error al conectar con el servidor");
	//mysql_select_db("proyecto_modernizacion", $link);
	$HTTP_HOST = $_SERVER['HTTP_HOST'];
	$IP_SERV = $HTTP_HOST; 

	//$IP_USER = $REMOTE_ADDR;
	$IP_USER = $_SERVER['REMOTE_ADDR'];
		
	$Dias = array("Domingo","Lunes","Martes","Mi&eacute;rcoles","Jueves","Viernes","S�bado");
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
/*
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
*/
	foreach ($ArrParamLeyes as $k => $v){
		$ConsultaX = "select * from proyecto_modernizacion.unidades where cod_unidad='".$v[0]."'";
		//echo "test: ".$ConsultaX."<br>";
		$RespX = mysqli_query($link, $ConsultaX);
		if ($FilaX = mysqli_fetch_array($RespX))
		{
			$ArrParamLeyes[$k][1] = $FilaX["conversion"];
			$ArrParamLeyes[$k][3] = $FilaX["abreviatura"];
		}
	}

    //echo "rut: ".$CookieRut;
	if (isset($CookieRut))
	{
		$DifFecha=0;
		$ConsultaPass = "select max(fecha_hora) as fecha_hora from proyecto_modernizacion.control_acceso ";
		$ConsultaPass.= " where rut='".$CookieRut."' and sistema='0'";
		$RespPass=mysqli_query($link, $ConsultaPass);
		if ($FilaPass=mysqli_fetch_array($RespPass))
		{
			$Fecha1 = $FilaPass["fecha_hora"];
			$Fecha2 = date("Y-m-d H:i:s");
			$DifFecha=0;
			//echo $Fecha1."<br>";
			$AnoAux=substr($Fecha1,0,4);
			$MesAux=substr($Fecha1,5,2);
			$DiaAux=substr($Fecha1,8,2);
			$HoraAux=substr($Fecha1,11,2);
			$MinutoAux=substr($Fecha1,14,2);
			$SegundoAux=substr($Fecha1,17,2);
			//echo $Fecha2."<br>";
			$AnoAux2=substr($Fecha2,0,4);
			$MesAux2=substr($Fecha2,5,2);
			$DiaAux2=substr($Fecha2,8,2);
			$HoraAux2=substr($Fecha2,11,2);
			$MinutoAux2=substr($Fecha2,14,2);
			$SegundoAux2=substr($Fecha2,17,2);
			//echo $Fecha1." - ".$Fecha2."<br>";	
			//echo $HoraAux2."-".$HoraAux.", ".$MinutoAux2."-".$MinutoAux.", ".$SegundoAux2."-".$SegundoAux.", ".$MesAux2."-".$MesAux.", ".$DiaAux2."-".$DiaAux.", ".$AnoAux2."-".$AnoAux."<br>";
			$Fecha1=mktime($HoraAux, $MinutoAux, 0, $MesAux, $DiaAux, $AnoAux);
			$Fecha2=mktime($HoraAux2, $MinutoAux2, 0, $MesAux2, $DiaAux2, $AnoAux2);
			$DifFecha=$Fecha2-$Fecha1;
			$Horas = intval($DifFecha / 3600); 
			$Min = intval(($DifFecha-$Horas*3600)/60); 
			//$Min = (($Min * 100) / 60)/100;	
			//$seg = $DifFecha-$horas*3600-$min*60; 
			$DifFechaHr = $Horas;
			$DifFechaMin = $Min;
			$ValidaTime=true;
			$ConsultaPass2="select * from proyecto_modernizacion.funcionarios where rut='".$CookieRut."'";
			$RespPass2=mysqli_query($link, $ConsultaPass2);			
			if ($FilaPass2=mysqli_fetch_array($RespPass2))
			{
				if ($FilaPass2["caduca"]=="N")
					$ValidaTime=false;
			}
			if (($DifFechaHr>0 && $ValidaTime==true) || ($DifFechaMin>60 && $ValidaTime==true))
			{
				/*$ActualizaActivo="UPDATE proyecto_modernizacion.funcionarios set activo='' where rut='".$CookieRut."'";
				mysqli_query($link, $ActualizaActivo);	*/
				echo "<script languaje=\"JavaScript\">window.location=\"caducado.php?Fecha0".$FilaPass["fecha_hora"]."&Proceso=T_Fuera&DifFechaHr=$DifFechaHr&DifFechaMin=$DifFechaMin\";</script>";
			}
			else
			{
				$ActualizaPass = "UPDATE proyecto_modernizacion.control_acceso set fecha_hora='".date("Y-m-d H:i:s")."' ";
				$ActualizaPass.= " where rut='".$CookieRut."' and sistema='0' and fecha_hora='".$FilaPass["fecha_hora"]."'";
				mysqli_query($link, $ActualizaPass);				
			}
			//echo "Diferencia: $horas Hs:$min Min:$seg Seg"; 
			//$DifFecha=mktime($HoraAux2-$HoraAux, $MinutoAux2-$MinutoAux, $SegundoAux2-$SegundoAux, $MesAux2-$MesAux, $DiaAux2-$DiaAux, $AnoAux2-$AnoAux);
		}	
	}
	

?>
