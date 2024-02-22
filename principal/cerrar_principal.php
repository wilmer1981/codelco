<?php
	include("conectar_principal.php");
	/*
	setcookie('CookieRut','',time()-100);
	setcookie('CookieRutAUX','',time()-100);
	setcookie('EncontroPortalX','',time()-100);
	setcookie('CookieOpcion','',time()-100);
	
    //sirve para desbloquear al usuario
	unset($_SESSION["rutIntento"]);
	*/

	mysqli_close($link);
?>