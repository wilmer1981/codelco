<?php
error_reporting(0);
$servidor_LDAP = ParametrosGenerales(18);
$servidor_dominio = ParametrosGenerales(19);
$ldap_dn = ParametrosGenerales(20);

function ValidarCuentaLDAP($Cuenta,$Password)
{
    global $servidor_LDAP;
    global $servidor_dominio;
    global $ldap_dn;
	$Datos = array("Nombre"=>'',"Apellido"=>'',"Usuario"=>'');
	$Retorno = array("Estado"=>false, "Mensaje"=>"No Conectado", "Datos"=>$Datos);
   //echo $servidor_LDAP." - ".$servidor_dominio." - ".$ldap_dn."<br>";
   
   $conectado_LDAP = ldap_connect($servidor_LDAP);
   ldap_set_option($conectado_LDAP, LDAP_OPT_PROTOCOL_VERSION, 3);
   ldap_set_option($conectado_LDAP, LDAP_OPT_REFERRALS, 0);
   if ($conectado_LDAP) 
   {
	   $autenticado_LDAP = ldap_bind($conectado_LDAP,$Cuenta. "@" .$servidor_dominio, $Password);
	   if ($autenticado_LDAP)
	   {
		   $sr=ldap_search($conectado_LDAP,"dc=codelco,dc=cl", "(mailnickname=".$Cuenta.")");  
		   $info = ldap_get_entries($conectado_LDAP, $sr);
		   for ($i=0; $i<$info["count"]; $i++) 
		   {
						  $Datos['Nombre']=$info[$i]["givenname"][0];
						  $Datos['Apellido']=$info[$i]["sn"][0];
						  $Datos['Usuario']=$Cuenta;
		   }
		   $Retorno = array("Estado"=>true, "Mensaje"=>utf8_decode("(".$Cuenta.") Aprobada"), "Datos"=>$Datos);
	   }
	   else
	   {
		   $Retorno = array("Estado"=>false, "Mensaje"=>utf8_decode("(".$Cuenta.") Rechazada, verifique cuenta y contraseña"), "Datos"=>$Datos);
	   }
	   ldap_close($conectado_LDAP);
   }
   else
   {
	   $Retorno = array("Estado"=>false, "Mensaje"=>utf8_decode("Error de conexión con servidor: ".$servidor_LDAP), "Datos"=>$Datos);
   } 
   return($Retorno);
}
function ExisteCuentaLDAP($Cuenta)
{
	global $servidor_LDAP;
	global $servidor_dominio;
	global $ldap_dn;
	
	$Datos = array("Nombre"=>'',"Apellido"=>'',"Usuario"=>'');
	$Retorno = array("Estado"=>false, "Mensaje"=>"No Conectado", "Datos"=>$Datos);

	$conectado_LDAP = ldap_connect($servidor_LDAP);
	ldap_set_option($conectado_LDAP, LDAP_OPT_PROTOCOL_VERSION, 3);
	ldap_set_option($conectado_LDAP, LDAP_OPT_REFERRALS, 0);
	if ($conectado_LDAP) 
	{		
		$sr=ldap_search($conectado_LDAP,$ldap_dn, "mailnickname=".$Cuenta."");  
		$info = ldap_get_entries($conectado_LDAP, $sr);
		for ($i=0; $i<$info["count"]; $i++) 
		{
				$Datos['Nombre']=$info[$i]["givenname"][0];
				$Datos['Apellido']=$info[$i]["sn"][0];
				
		}
		$Retorno = array("Estado"=>true, "Mensaje"=>utf8_decode("(".$Cuenta.") Aprobada"), "Datos"=>$Datos);
		ldap_close($conectado_LDAP);
	}
	else
	{
		$Retorno = array("Estado"=>false, "Mensaje"=>utf8_decode("Error de conexión con servidor: ".$servidor_LDAP), "Datos"=>$Datos);
	} 
	return($Retorno);
}
?>