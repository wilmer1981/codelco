<?phpphp
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

//require('lib/PHPMailer.php'); 
require('lib/class.phpmailer.php'); 
include("../principal/conectar_principal.php");
?>
<html>
<head>

<script language="JavaScript">

function Salir()
{
	window.history.back();
}

function Imprimir()
{
	window.print();
}

</script>

<?phpphp

	$Clase='3113';
	$Subclase='1';
	$Folio_Inicial="";
	$Folio_Final="";
	$Porcentaje="";
	$Correos="";
	$GuiaEnami="";
	$Consulta= " Select * from proyecto_modernizacion.sub_clase where cod_clase='".$Clase."' and cod_subclase='".$Subclase."'";
	$Resp = mysqli_query($link, $Consulta);	
	if ($Fila = mysqli_fetch_array($Resp))
	{
		$Correos=$Fila["valor_subclase1"];
		$Folio_Inicial=$Fila["valor_subclase2"];
		$Folio_Final=$Fila["valor_subclase3"];
		$Porcentaje=$Fila["valor_subclase4"];
	}
	$Consulta2= " select nro_guia from sec_web.sec_logs where tipo='E' order by fecha_hora_registro desc limit 1,1";
	$Resp2 = mysqli_query($link, $Consulta2);	
	if ($FilaEnami = mysqli_fetch_array($Resp2))
	{
		$GuiaEnami=$FilaEnami["nro_guia"];
	}
	$DiferenciaPorcentaje=$Folio_Final-$Folio_Inicial;
	$CantidadAlerta=($DiferenciaPorcentaje*$Porcentaje)/100;
	
	$Faltante=$Folio_Final-$GuiaEnami;
	
	
	if($CantidadAlerta<=$Faltante)
	{
		try{
		
		$cuerpoMsj="Estimado.<br> <br>
		Se informa que a la fecha (".date("d-m-Y")."), la cantidad de folios para la generaci&oacute;n de GDE para <b>Enami</b>. <br>
		<br>Se encuentra bajo el 10%, quedando aproximadamente menos de ".$Faltante." folios. 
		<br>
		<br><br>Favor de gestionar la actualizaci&oacute;n de los folios a representante de Artikos.
		<br>
		
		<br>Dar aviso a Codelco Logistica de las numeraciones nuevas para actualizar registro de control.
		<br>
		<br><br>Gracias.
		<br>
		";
		
	$mail = new phpmailer();
					$mail->IsSMTP();
					$mail->SMTPAuth = true;
					$mail->Host ="relayds.codelco.cl";
					$mail->From = 'seca@codelco.cl';
					$mail->Username = 'Tecasinos';
					$mail->Password = 'codelco2014';
					$mail->FromName = 'Sistemas SEC-WEB ';
					$mail->SetFrom('seca@codelco.cl',"Sistemas SEC-WEB");
					$Correo=explode(";",$Correos);
					while(list($c,$v)=each($Correo))
					{
						if($v!='')
						{
							if(filter_var($v,FILTER_VALIDATE_EMAIL)){
							$mail->AddAddress($v);
							}
						}
					}
					$mail->Subject="Alerta Folios Enami "; 
					$mail->MsgHTML($cuerpoMsj);
					 if(!$mail->send()){ // Send email
            echo 'Hubo un problema. Contacta a un administrador sistema WEB. ' . $mail->ErrorInfo; 
        }else{
            echo 'El correo fue enviado correctamente.'; 
        }
		/*$mail = new PHPMailer(true);
		$mail->SMTPDebug=2;
		$mail->IsSMTP();
		$mail->Host = "relayds.codelco.cl";
		$mail->SMTPAuth =true;
		$mail->CharSet = 'UTF-8';

		//$mail->SMTPAutoTLS = true; 
		//$mail->Username = "lcast036@contratistas.codelco.cl";
		$mail->Username = 'Tecasinos';
		$mail->Password = 'codelco2014';	
		//$mail->SMTPSecure='tls';	
		$mail->Port = 25;
		//$mail->setFrom('seca@codelco.cl ','Sistema SECA-WEB'); // De quien viene  el Correo
     	$mail->From = "seca@codelco.cl";
		$mail->SetFrom = "seca@codelco.cl";
		$mail->FromName = "Alerta Folios Enami";
		$mail->Subject = "Alerta Folios Enami ";
	
		$mail->SMTPOptions = array(
		'ssl' => array(
		'verify_peer' => false,
		'verify_peer_name' => false,
		'allow_self_signed' => true
		)
		);
		
		//	$mail->isSMTP();
		//	$mail->SMTPAuth = true;
		//	$mail->SMTPAutoTLS = true; 
		$mail->isHTML(true);
		$mail->Body=$cuerpoMsj;
		
			$Correo=explode(";",$Correos);
			while(list($c,$v)=each($Correo))
			{
				if($v!='')
				{
					if(filter_var($v,FILTER_VALIDATE_EMAIL)){
					$mail->AddAddress($v);
					}
				}
			}

		 if(!$mail->send()){ // Send email
            echo 'Hubo un problema. Contacta a un administrador sistema WEB. ' . $mail->ErrorInfo; 
        }else{
            echo 'El correo fue enviado correctamente.'; 
        }*/
		$mail->ClearAddresses();
			
		}catch (Exception $e)
		{
			print_r($e);
			echo "hubo un error al enviuar mensaje".$mail->ErrorInfo;
		}
		
		
	}
	else
	{
		echo "Procesado sin envio de Correo";
	}
	
	?>


</head>
<SCRIPT LANGUAGE="JavaScript">
function cerrar_sin()
{  
 window.open('','_parent','');
 window.close(); 
} 
</script> 

<body  onload="cerrar_sin();" >

</body>


</html>
	
	
