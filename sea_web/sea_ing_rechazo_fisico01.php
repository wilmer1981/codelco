<?php
include("../principal/conectar_sea_web.php");

if($Proceso ==G)
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
