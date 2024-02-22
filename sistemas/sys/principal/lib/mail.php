<?php
require "class.phpmailer.php";
require "class.smtp.php";
function ClaseEnvioMail($To,$Address,$cuerpoMsj,$NumOCCorreo,$NemoCorreo)
{
	global $Correo_CC;

	$Correo_CC = trim($Correo_CC);

	$Mail = new PHPMailer(); 
	$Mail->IsSMTP();
	$Mail->Host = 'smtp.gmail.com';
	$Mail->SMTPDebug = 2; //no olvides quitar el debug
	$Mail->SMTPAuth = true;
	$Mail->SMTPSecure = 'tls';
	$Mail->Port = 587;
	$Mail->Username = 'aggro1986@gmail.com';
	$Mail->Password = 'lambofgod1986-';
	$Mail->Priority = 1;
	$Mail->CharSet = 'UTF-8';
	$Mail->Encoding = '8bit';
	$Mail->Subject = 'Mensaje de prueba Gmail';
	$Mail->ContentType = 'text/html; charset=utf-8\r\n';
	$Mail->From = 'aggro1986@gmail.com';
	$Mail->FromName = 'quien lo envia';
	$Mail->WordWrap = 900;
	
	$Address = explode(';',$Address);
	while(list($c,$v)=each($Address)) 
		$Mail->AddAddress($v);
	
	if($Correo_CC != '')
	{
		$Correo_CC = explode(';',$Correo_CC);
		while(list($c,$v)=each($Correo_CC)) 		
			$Mail->AddCC($v);
	}

	$Mail->isHTML(TRUE);
	$Mail->Body = 'Hola este es mi mensaje';
	$Mail->Send();
	$Mail->SmtpClose();
	 
	if ($Mail->IsError()) {
	    echo "ERROR<br /><br />";
	} else {
	    echo "OK<br /><br />";
	}

	return $Retorno;
}
?>