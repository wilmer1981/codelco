<?php
include("../principal/conectar_sea_web.php");

$Proceso  = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
$Ano      = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");
$Mes      = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("m");
$Dia      = isset($_REQUEST["Dia"])?$_REQUEST["Dia"]:date("d");
$hora     = isset($_REQUEST["hora"])?$_REQUEST["hora"]:date("H");
$minuto   = isset($_REQUEST["minuto"])?$_REQUEST["minuto"]:date("i");

$Fis_Vent   = isset($_REQUEST["Fis_Vent"])?$_REQUEST["Fis_Vent"]:"";
$Quim_Vent  = isset($_REQUEST["Quim_Vent"])?$_REQUEST["Quim_Vent"]:"";
$Calaf_Vent = isset($_REQUEST["Calaf_Vent"])?$_REQUEST["Calaf_Vent"]:"";
$Ana_Vent   = isset($_REQUEST["Ana_Vent"])?$_REQUEST["Ana_Vent"]:"";

$Fis_HMadres   = isset($_REQUEST["Fis_HMadres"])?$_REQUEST["Fis_HMadres"]:"";
$Quim_HMadres  = isset($_REQUEST["Quim_HMadres"])?$_REQUEST["Quim_HMadres"]:"";
$Calaf_HMadres = isset($_REQUEST["Calaf_HMadres"])?$_REQUEST["Calaf_HMadres"]:"";
$Ana_HMadres   = isset($_REQUEST["Ana_HMadres"])?$_REQUEST["Ana_HMadres"]:"";

$Fis_Teniente   = isset($_REQUEST["Fis_Teniente"])?$_REQUEST["Fis_Teniente"]:"";
$Quim_Teniente  = isset($_REQUEST["Quim_Teniente"])?$_REQUEST["Quim_Teniente"]:"";
$Calaf_Teniente = isset($_REQUEST["Calaf_Teniente"])?$_REQUEST["Calaf_Teniente"]:"";
$Ana_Teniente   = isset($_REQUEST["Ana_Teniente"])?$_REQUEST["Ana_Teniente"]:"";

$Fis_FHVL   = isset($_REQUEST["Fis_FHVL"])?$_REQUEST["Fis_FHVL"]:"";
$Quim_FHVL  = isset($_REQUEST["Quim_FHVL"])?$_REQUEST["Quim_FHVL"]:"";
$Calaf_FHVL = isset($_REQUEST["Calaf_FHVL"])?$_REQUEST["Calaf_FHVL"]:"";
$Ana_FHVL   = isset($_REQUEST["Ana_FHVL"])?$_REQUEST["Ana_FHVL"]:"";

$Fis_Disputada   = isset($_REQUEST["Fis_Disputada"])?$_REQUEST["Fis_Disputada"]:"";
$Quim_Disputada  = isset($_REQUEST["Quim_Disputada"])?$_REQUEST["Quim_Disputada"]:"";
$Calaf_Disputada = isset($_REQUEST["Calaf_Disputada"])?$_REQUEST["Calaf_Disputada"]:"";
$Ana_Disputada   = isset($_REQUEST["Ana_Disputada"])?$_REQUEST["Ana_Disputada"]:"";

$Fis_Restos   = isset($_REQUEST["Fis_Restos"])?$_REQUEST["Fis_Restos"]:"";
$Quim_Restos  = isset($_REQUEST["Quim_Restos"])?$_REQUEST["Quim_Restos"]:"";
$Calaf_Restos = isset($_REQUEST["Calaf_Restos"])?$_REQUEST["Calaf_Restos"]:"";
$Ana_Restos   = isset($_REQUEST["Ana_Restos"])?$_REQUEST["Ana_Restos"]:"";

$Fis_Expo   = isset($_REQUEST["Fis_Expo"])?$_REQUEST["Fis_Expo"]:"";
$Quim_Expo  = isset($_REQUEST["Quim_Expo"])?$_REQUEST["Quim_Expo"]:"";
$Calaf_Expo = isset($_REQUEST["Calaf_Expo"])?$_REQUEST["Calaf_Expo"]:"";
$Ana_Expo   = isset($_REQUEST["Ana_Expo"])?$_REQUEST["Ana_Expo"]:"";

if($Proceso == 'G')
{
	if($Fis_Vent == '')
		$Fis_Vent = 0;		
	
	if($Quim_Vent == '')
		$Quim_Vent = 0;
	
	if($Calaf_Vent == '')
		$Calaf_Vent = 0;	

	if($Ana_Vent == '')
		$Ana_Vent = 0;	

	if($Fis_HMadres == '')
		$Fis_HMadres = 0;	
		
	if($Quim_HMadres == '')
		$Quim_HMadres = 0;	

	if($Calaf_HMadres == '')
		$Calaf_HMadres = 0;	

	if($Ana_HMadres == '')
		$Ana_HMadres = 0;

	if($Fis_Teniente == '')
		$Fis_Teniente = 0;	

	if($Quim_Teniente == '')
		$Quim_Teniente = 0;	

	if($Calaf_Teniente == '')
		$Calaf_Teniente = 0;	

	if($Ana_Teniente == '')
		$Ana_Teniente = 0;	

	if($Fis_FHVL == '')
		$Fis_FHVL = 0;	

	if($Quim_FHVL == '')
		$Quim_FHVL = 0;	

	if($Calaf_FHVL == '')
		$Calaf_FHVL = 0;	

	if($Ana_FHVL == '')
		$Ana_FHVL = 0;	

	if($Fis_Disputada == '')
		$Fis_Disputada = 0;
			
	if($Quim_Disputada == '')
		$Quim_Disputada = 0;

	if($Calaf_Disputada == '')
		$Calaf_Disputada = 0;

	if($Ana_Disputada == '')
		$Ana_Disputada = 0;

	if($Fis_Restos == '')
		$Fis_Restos = 0;

	if($Quim_Restos == '')
		$Quim_Restos = 0;

	if($Calaf_Restos == '')
		$Calaf_Restos = 0;	

	if($Ana_Restos == '')
		$Ana_Restos = 0;
  
 	if($Fis_Expo == '')
		$Fis_Expo = 0;

	if($Quim_Expo == '')
		$Quim_Expo = 0;

	if($Calaf_Expo == '')
		$Calaf_Expo = 0;

	if($Ana_Expo == '')
		$Ana_Expo = 0;

	if(strlen($Mes) == 1)
		$Mes = '0'.$Mes;
	
	$Fecha = $Ano.'-'.$Mes.'-'.$Dia;
	$fecha_hora = $Ano."-".$Mes."-".$Dia." ".$hora.":".$minuto;

	//$Consulta = "SELECT * FROM sea_web.inf_rechazos WHERE fecha = '$Fecha' and hora = '$fecha_hora'";
	$Consulta = "SELECT * FROM sea_web.inf_rechazos WHERE fecha = '$Fecha'";
	$rs = mysqli_query($link, $Consulta);
	if($row = mysqli_fetch_array($rs))
	{

		$Actualiza = "UPDATE sea_web.inf_rechazos SET";
		$Actualiza.= " Fis_Vent 	 = $Fis_Vent,		Quim_Vent 		= $Quim_Vent,		Calaf_Vent 		= $Calaf_Vent,		Ana_Vent 	  = $Ana_Vent,";
		$Actualiza.= " Fis_HMadres 	 = $Fis_HMadres,	Quim_HMadres 	= $Quim_HMadres,	Calaf_HMadres 	= $Calaf_HMadres,	Ana_HMadres   = $Ana_HMadres,";
		$Actualiza.= " Fis_FHVL 	 = $Fis_FHVL,		Quim_FHVL 		= $Quim_FHVL,		Calaf_FHVL 		= $Calaf_FHVL,		Ana_FHVL 	  = $Ana_FHVL,";
		$Actualiza.= " Fis_Teniente  = $Fis_Teniente,	Quim_Teniente 	= $Quim_Teniente,	Calaf_Teniente 	= $Calaf_Teniente,	Ana_Teniente  = $Ana_Teniente,";
		$Actualiza.= " Fis_Disputada = $Fis_Disputada,	Quim_Disputada 	= $Quim_Disputada,	Calaf_Disputada = $Calaf_Disputada,	Ana_Disputada = $Ana_Disputada,";
		$Actualiza.= " Fis_Restos 	 = $Fis_Restos,		Quim_Restos 	= $Quim_Restos,		Calaf_Restos 	= $Calaf_Restos,	Ana_Restos 	  = $Ana_Restos,";
		$Actualiza.= " Fis_Expo 	 = $Fis_Expo,		Quim_Expo  	    = $Quim_Expo,	    Calaf_Expo 	    = $Calaf_Expo,	    Ana_Expo 	  = $Ana_Expo,";
		$Actualiza.= " hora          ='$fecha_hora'";
		$Actualiza.= " WHERE fecha 	 = '$Fecha' and hora = '$fecha_hora'";
		mysqli_query($link, $Actualiza);
	}
    else   
    {

		$Inserta = "INSERT INTO sea_web.inf_rechazos (Fecha,Fis_Vent,Quim_Vent,Calaf_Vent,Ana_Vent,";
		$Inserta.= "Fis_HMadres,Quim_HMadres,Calaf_HMadres,Ana_HMadres,Fis_Teniente,Quim_Teniente,Calaf_Teniente,Ana_Teniente,";
		$Inserta.= "Fis_FHVL,Quim_FHVL,Calaf_FHVL,Ana_FHVL,Fis_Disputada,Quim_Disputada,Calaf_Disputada,Ana_Disputada,";
		$Inserta.= "Fis_Restos,Quim_Restos,Calaf_Restos,Ana_Restos,Fis_Expo,Quim_Expo,Calaf_Expo,Ana_Expo,hora)";
		$Inserta.= " VALUES('$Fecha',$Fis_Vent,$Quim_Vent,$Calaf_Vent,$Ana_Vent,";
		$Inserta.= "$Fis_HMadres,$Quim_HMadres,$Calaf_HMadres,$Ana_HMadres,$Fis_Teniente,$Quim_Teniente,$Calaf_Teniente,$Ana_Teniente,";
		$Inserta.= "$Fis_FHVL,$Quim_FHVL,$Calaf_FHVL,$Ana_FHVL,$Fis_Disputada,$Quim_Disputada,$Calaf_Disputada,$Ana_Disputada,";
		$Inserta.= "$Fis_Restos,$Quim_Restos,$Calaf_Restos,$Ana_Restos,$Fis_Expo,$Quim_Expo,$Calaf_Expo,$Ana_Expo,'$fecha_hora')";
		mysqli_query($link, $Inserta);
		
	}
		
	
		$linea = "Proceso=B&Ano=".$Ano."&Mes=".$Mes."&Dia=".$Dia;
		header("Location:sea_ing_rechazo_fisico.php?".$linea);
	
}
?>
