<?php
	include("../principal/conectar_ref_web.php");

	    if ($proceso == "M")
	{
		$actualizar = "UPDATE ref_web.tratamiento_electrolito SET volumen_pte = '".$txt_volumen_pte."'";
		$actualizar.= " WHERE fecha = '".$txt_fecha."'";
		$actualizar.= " and circuito_pte= '".$txt_circuito."' and destino_pte='".$txt_destino."' and turno='".$txt_turno1."'";
		//echo $actualizar;
    	mysqli_query($link, $actualizar);		
       	header("Location:traspasos.php?fecha=$txt_fecha");		
	}

	if ($proceso == "E")
	{
		$valores = explode("-",$parametros);
		while(list($c,$v) = each($valores))
		{
			$eliminar = "DELETE FROM ref_web.tratamiento_electrolito ";
			$eliminar.= " WHERE circuito_pte= '".$v."'";
			$eliminar.= " and fecha='".$fecha."'";
			mysqli_query($link, $eliminar);						
		}
		
		$mensaje = "Grupo(s) Eliminado(s) Correctamente";
		header("Location:traspasos.php?fecha=".$txt_fecha);				
	}
?>