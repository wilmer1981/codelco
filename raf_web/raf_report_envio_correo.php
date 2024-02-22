<?		
	include("../principal/conectar_principal.php");
  $diassemana = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
  $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
  
  $Fecha= $diassemana[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
  //echo $Fecha."<br>";
  //Salida: Miercoles 05 de Septiembre del 2016

// Obtenemos datos de Tabla Subclase de Correo
$Consulta = "SELECT valor_subclase1 FROM proyecto_modernizacion.sub_clase where cod_clase='12013' and cod_subclase='1'";
$Resultado = mysql_query($Consulta);
$Resultado = mysql_fetch_array($Resultado);	
$DE = $Resultado[0];
//echo "DEEEEEE: " . $DE;

$Consulta = "SELECT valor_subclase1 FROM proyecto_modernizacion.sub_clase where cod_clase='12013' and cod_subclase='2'";
$Resultado = mysql_query($Consulta);
$Resultado = mysql_fetch_array($Resultado);	
$PARA = $Resultado[0];
//echo "DEEEEEE: " . $DE;

$Consulta = "SELECT valor_subclase1 FROM proyecto_modernizacion.sub_clase where cod_clase='12013' and cod_subclase='3'";
$Resultado = mysql_query($Consulta);
$Resultado = mysql_fetch_array($Resultado);	
$COPIA = $Resultado[0];
//echo "DEEEEEE: " . $DE;

// Obtenemos datos de Tabla Mensaje id = 1 Primera Parte del mensaje 
		
$ASUNTO = "Habilitar Transito de Camiones, Porton Acceso PVSA.";

$MENSAJE = "Estimado jefe de Protecci&oacute;n Industrial,<br><br>Agradeceremos a Ud., instruya mantener abierto port&oacute;n de acceso a PVSA para dar cumplimiento a programas de recepci&oacute;n de concentrados, ".$Fecha." desde 08:30 a 19:00 horas.<br><br><br>";
$MENSAJE.= "Desde antemano, Muchas gracias,<br><br>";
$MENSAJE.= "Saludos cordiales,";
 

//Incluimos la clase de PHPMailer
require_once('../sipa_web/phpmailer/class.phpmailer.php');
 
$correo = new PHPMailer(); //Creamos una instancia en lugar usar mail()
 
//Usamos el SetFrom para decirle al script quien envia el correo
//$correo->SetFrom("mfuentes@codelco.cl", "Persona");
$correo->SetFrom($DE, "");
 
//Usamos el AddReplyTo para decirle al script a quien tiene que responder el correo
$correo->AddReplyTo($PARA,"");
 
//Usamos el AddAddress para agregar un destinatario
//$correo->AddAddress("mfuentes@codelco.cl", "");

$EnvCorreos = explode( ";", $COPIA );
foreach( $EnvCorreos as $destino ) {
	  //echo " correoss = " . $destino;
      $correo->AddAddress($destino,"" );
}  

//$correo->AddCC("mfuentes@codelco.cl");
//$correo->AddCC($DirCorreos);
 
//Ponemos el asunto del mensaje
$correo->Subject = $ASUNTO; //." ".$NombArch;
 
/*
 * Si deseamos enviar un correo con formato HTML utilizaremos MsgHTML:
 * $correo->MsgHTML("<strong>Mi Mensaje en HTML</strong>");
 * Si deseamos enviarlo en texto plano, haremos lo siguiente:
 * $correo->IsHTML(false);
 * $correo->Body = "Mi mensaje en Texto Plano";
 */
//$correo->MsgHTML("Mensaje en <strong>HTML</strong>");
$correo->MsgHTML($MENSAJE);
 
//Si deseamos agregar un archivo adjunto utilizamos AddAttachment
// ----- $correo->AddAttachment("GenSalida/DetSIMM-".$NombArch.".xls");
 
//Enviamos el correo
if(!$correo->Send()) {
  echo "Hubo un error: " . $correo->ErrorInfo;
} 


?>
