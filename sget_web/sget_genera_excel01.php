<?
ob_start("ob_gzhandler");
include("../principal/conectar_sget_web.php");
set_time_limit(1000);
include("funciones/sget_funciones.php");
$Fecha_Sistema= date("Y-m-d");
$Fecha_Creacion= date("Y-m-d G:i:s");
$Rut=$CookieRut;
$Consulta="Select * from sget_ruta_archivo where rut='".$CookieRut."'";
$Resp0= mysql_query($Consulta);
if($Fila0 = mysql_fetch_array($Resp0))
{
	//$RutaOrigen=$Fila0[origen];//'C:\SGEPVB';
	$RutaDestino=$Fila0[destino_apache];//'Z:\Apache2\htdocs\proyecto\sget_web\archivos';
	$Cuenta=$Fila0[cuenta];
}
$Actualiza="UPDATE sget_ruta_archivo set password='".$txtpassword."' where rut='".$CookieRut."'";
//echo $Actualiza;
mysql_query($Actualiza);

$VarContratista=AdmCttoContratista($Ctto);
$array=explode('~',$VarContratista);
$Actualiza="UPDATE sget_administrador_contratistas set email='".strtoupper($EMail)."' where rut_adm_contratista='".$array[0]."'";
mysql_query($Actualiza);
$Doc=$Ctto.".xls";
$Archivo=$RutaDestino."/".$Doc;

    //creamos un array que estar� formado por las direcciones de destino
      if ($EMail)
		$direcciones["direccion1"]=$EMail;
      //pasamos a enviar el correo

      // primero hay que incluir la clase phpmailer para poder instanciar 
      //un objeto de la misma
      require "includes/class.phpmailer.php";

      //instanciamos un objeto de la clase phpmailer al que llamamos 
      //por ejemplo mail
      $mail = new phpmailer();

      //Definimos las propiedades y llamamos a los m�todos 
      //correspondientes del objeto mail

      //Con PluginDir le indicamos a la clase phpmailer donde se 
      //encuentra la clase smtp que como he comentado al principio de 
      //este ejemplo va a estar en el subdirectorio includes
      $mail->PluginDir = "includes/";

      //Con la propiedad Mailer le indicamos que vamos a usar un 
      //servidor smtp                            
      $mail->Mailer = "smtp";

      //Asignamos a Host el nombre de nuestro servidor smtp
      $mail->Host = "VEFVEX03.codelco.cl";
      
      //Le indicamos que el servidor smtp requiere autenticaci�n
      $mail->SMTPAuth = true;

      //Le decimos cual es nuestro nombre de usuario y password
      $mail->Username = $Cuenta;
      //$mail->Password = "joa022021";
      $mail->Password = $txtpassword;
      //Indicamos cual es nuestra direcci�n de correo y el nombre que 
      //queremos que vea el usuario que lee nuestro correo
      $mail->From = $Cuenta;

      $mail->FromName = "Gesti�n de Terceros Codelco Ventanas";

      //Asignamos asunto y cuerpo del mensaje
      //El cuerpo del mensaje lo ponemos en formato html, haciendo 
      //que se vea en negrita
	  $Salto="\n";
      $mail->Subject = "HOJA DE RUTA DIGITAL DE INGRESO PERSONAL CONTRATISTA";
	  $cuerpo.= "Estimado se adjunta documento excel para el ingreso de personal a la Hoja de Ruta".$Salto;
	  $cuerpo.= $Salto;
	  $cuerpo.= $Salto;
 	  $cuerpo.= "Atte".$Salto;
	  $cuerpo.= $Salto;
	  $cuerpo.= "                Departamento de Gesti�n de Terceros".$Salto;; 
	  
  
      $mail->Body = "Estimado se adjunta documento excel para el ingreso de personal a la Hoja de Ruta, tambiem se adjunta instructivo(PlantillaExcel.doc) para solucion de errores ";
	  //$mail->Body = $cuerpo;

      //Definimos AltBody por si el destinatario del correo no admite 
      //email con formato html
      $mail->AltBody ="Departamento de Gesti�n de Terceros";

      //el valor por defecto 10 de Timeout es un poco escaso dado que voy a usar 
      //una cuenta gratuita y voy a usar attachments, por tanto lo pongo a 120  
      $mail->Timeout=120;

      //Indicamos el fichero a adjuntar si el usuario seleccion� uno en el formulario
      if ($achivo !="none")
	  {
		  $mail->AddAttachment('excel_generado/'.$Doc,$Doc);
		  $Doc2='PlantillaExcel.doc';
		  $mail->AddAttachment('archivos/'.$Doc2,$Doc2);
      }
      //Indicamos cuales son las direcciones de destino del correo y enviamos 
      //los mensajes
      reset($direcciones);
      while (list($clave, $valor)=each($direcciones)) {
	$mail->AddAddress($valor);

	//se envia el mensaje, si no ha habido problemas la variable $success 
	//tendra el valor true
	$exito = $mail->Send();

	//Si el mensaje no ha podido ser enviado se realizaran 4 intentos mas 
	//como mucho para intentar enviar el mensaje, cada intento se hara 5 s
	//segundos despues del anterior, para ello se usa la funcion sleep
 	$intentos=1; 
   	while((!$exito)&&($intentos<10)&&($mail->ErrorInfo!="SMTP Error: Data not accepted")){
	   sleep(5);
     	   //echo $mail->ErrorInfo;
     	   $exito = $mail->Send();
     	   $intentos=$intentos+1;				
   	}

	//La clase phpmailer tiene un peque�o bug y es que cuando envia un mail con
	//attachment la variable ErrorInfo adquiere el valor Data not accepted, dicho 
	//valor no debe confundirnos ya que el mensaje ha sido enviado correctamente
	if ($mail->ErrorInfo=="SMTP Error: Data not accepted") {
	   $exito=true;
        }
		
	if(!$exito)
	{
	   $Msj="Problemas enviando correo electr�nico a ".$valor;
	   //echo "Problemas enviando correo electr�nico a ".$valor;
	   //echo "<br/>".$mail->ErrorInfo;	
	}
	else
	{
	   $Msj="El Correo a Sido Enviado Correctamente";
	   //Mostramos un mensaje indicando las direccion de 
	   //destino y fichero  adjunto enviado en el mensaje	
	   /*$mensaje="<p>Has enviado un mensaje a:<br/>";
	   $mensaje.=$valor." ";
	   if ($archivo !="none") {
		$mensaje.="Con un fichero adjunto llamado ".$Doc;
	   }
	   $mensaje.="</p>";
     	   echo $mensaje;*/
		

	}
	// Borro las direcciones de destino establecidas anteriormente
    	$mail->ClearAddresses();
	
	}
	//echo "<a href='$PHP_SELF'> VOLVER AL FORMULARIO</a>";
 
    header("location:sget_genera_excel.php?Ctto=".$Ctto."&Empresa=".$Empresa."&Mensaje=".$Msj);

	
	/*echo "<script languaje=\"JavaScript\">";
		//echo "window.opener.document.frmPrincipal.action=\"sict_menu.php?Pagina=\"+window.opener.document.FrmMenu.Pagina.value;";
		//echo "window.opener.document.frmPrincipal.submit();";
		echo "alert('".$Msj."');";
		echo "window.close();";
	echo "</script>";*/
ob_end_flush();


?>