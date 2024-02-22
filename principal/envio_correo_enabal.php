<?php
	include("conectar_principal.php");
	require "includes/class.phpmailer.php";
	
	$Asunto='Aviso Traspaso desde Sistema Enabal';
	$Titulo='Envio de Correo Sistema Enabal';	
	$Mensaje='<font face="Arial" size="2">Estimado:';
	$Mensaje.='<br><br>';
	$Mensaje.='Archivos Traspasados Mae28.dat, Mbe28.dat, Balance Frv Finos';
	$Mensaje.='<br><BR>';
	$Obs='';$FechaTrasp='';
	$Consulta = "select nombre_subclase as obs,valor_subclase1 as datos from proyecto_modernizacion.sub_clase where cod_clase='31047' and cod_subclase='2'";
	$Resp= mysqli_query($link, $Consulta);
	while($Fila=mysqli_fetch_array($Resp))
	{
		$Valores=$Fila[datos];
		$Obs=$Fila[obs];
	}
	if($Valores!='')
	{	$Datos=explode('~',$Valores);
		$Mensaje.="Fecha Proceso Cierre:".$Datos[1]." ".$Datos[2]."<br><br>";
	}
	else
		$Mensaje.="Fecha Proceso Cierre:<br><br>";
	$Mensaje.="Fecha Hora de Traspaso:".$Datos[0]."<br><br>";
	$Mensaje.=$Obs;
	$Mensaje.='<br><br></font>';
	$cuerpoMsj = '<html>';
	$cuerpoMsj.= '<head>';
	$cuerpoMsj.= '<title>'.$Titulo.'</title>';
	$cuerpoMsj.= '</head>';
	$cuerpoMsj.= '<body>';
	$cuerpoMsj.= ''.$Mensaje.'';
	$cuerpoMsj.= "<br><br>";
	$cuerpoMsj.="Por Su Atención Muchas Gracias";
	$cuerpoMsj.= "<br>";
	$cuerpoMsj.="Servicio Automatico de Sistema Balance Metalurgico (ENABAL)";
	$cuerpoMsj.= "<br>";
	$cuerpoMsj.= '</body></html>';
	//echo $cuerpoMsj."<br>";
	$mail = new phpmailer();
	//$mail->AddEmbeddedImage("includes/logo_seti.jpg","logo","includes/logo_seti.jpg","base64","image/jpg");
	$mail->PluginDir = "includes/";
	//$mail->Mailer = "smtp";
	$mail->Host = "VEFVEX03.codelco.cl";
	$mail->From = "ENABAL";
	$mail->FromName = "ENABAL - Sistemas Balance Metalurgico ";
	$mail->Subject = $Asunto;
	$mail->Body=$cuerpoMsj;
	$mail->IsHTML(true);
	$mail->AltBody =str_replace('<br>','\n',$cuerpoMsj);
	$Correo='';
	$Consulta = "select valor_subclase1 as email from proyecto_modernizacion.sub_clase where cod_clase='31047' and cod_subclase='1'";
	$Resp= mysqli_query($link, $Consulta);
	while($Fila=mysqli_fetch_array($Resp))
	{
		//echo $Fila[email]."<br>";
		//$Correo=$Correo.$Fila[email].',';
		$Correo=$Fila[email];
	}
	
	//if($Correo!='')
	//	$Correo=substr($Correo,0,strlen($Correo)-1);
	$mail->AddAddress($Correo);
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
?>	

<body onLoad="Exit()">

<script language="javascript">
function Exit()
{
	cadena=navigator.appVersion
	var Vers=cadena.substr(22,1)
	if(Vers>6)
	{
		window.open('','_parent','');
		window.close();
	}
	else
	{
		window.opener=self;
		window.close();
	} 
}
</script>
