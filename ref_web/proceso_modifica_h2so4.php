<?php
	include("../principal/conectar_ref_web.php");
      
	    if ($proceso == "M")
		
	{   
	   	$actualizar = "UPDATE ref_web.electrolito SET volumen_h2so4 = '".$txt_volumen_h2so4."'";
		$actualizar.= " WHERE fecha = '".$txt_fecha."'";
		$actualizar.= " and circuito_h2so4= '".$txt_circuito."'";
		mysqli_query($link, $actualizar);		
    	header("Location:traspasos.php?fecha=$txt_fecha");		
	}

?>