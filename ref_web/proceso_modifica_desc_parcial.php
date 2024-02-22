<?php
	include("../principal/conectar_ref_web.php");

	    if ($proceso == "M")
	{
		$actualizar = "UPDATE ref_web.desc_parcial SET volumen_dp = '".$txt_volumen_dp."'";
		$actualizar.= " WHERE fecha = '".$txt_fecha."'";
		$actualizar.= " and circuito_dp= '".$txt_circuito."'";
		
    	mysqli_query($link, $actualizar);		
    	header("Location:traspasos.php?fecha=$txt_fecha");		
	}

	if ($proceso == "E")
	{
		$valores = explode("-",$parametros);
		while(list($c,$v) = each($valores))
		{
			$eliminar = "DELETE FROM ref_web.desc_parcial ";
			$eliminar.= " WHERE circuito_dp = '".$v."' ";
			$eliminar.= " and fecha='".$txt_fecha."'";
			mysqli_query($link, $eliminar);						
		}
		
		$mensaje = "Grupo(s) Eliminado(s) Correctamente";
		header("Location:ingreso_cir_eleaux.php?mensaje=".$mensaje);				
	}
?>
