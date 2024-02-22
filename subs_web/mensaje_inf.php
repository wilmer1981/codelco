<? 
//   include("informes.php");     
   if(isset($mensaje)&&($mensaje != "")){
	echo ' <script languaje = "Javascript">';
	echo " alert('".$mensaje."')";
	$mensaje = "";
	echo ' </script>';
	}
 ?>
