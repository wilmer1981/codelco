<?php include("../principal/conectar_sec_web.php");
	$opcion="E";
	if ($opcion=="E")
	  {
	 
	   $valores = explode("~",$parametros);
		while(list($c,$v) = each($valores))
		{   
	
			$eliminar = "DELETE FROM ref_web.detalle_produccion ";
			$eliminar.= " WHERE fecha = '".$v."'";
			mysqli_query($link, $eliminar);						
		}
			$mensaje = "Lectura Rectificador(s) Eliminada(s) Correctamente";
		    //header("Location:lectura_rectificador_proceso.php?activar=&fecha=".$fecha);
			 header("Location:datos_consumo.php?mensaje=".$mensaje);
	  
	  }	






 ?>