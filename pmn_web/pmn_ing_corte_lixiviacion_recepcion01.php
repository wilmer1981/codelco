<?php
	include("../principal/conectar_pmn_web.php");
	
	if ($proceso == 'G')
	{	
		$fecha = $ano.'-'.$mes.'-01';
		
		$consulta = "SELECT * FROM pmn_web.corte_lixiviacion";
		$consulta.= " WHERE fecha = '".$fecha."'";
		$rs = mysqli_query($link, $consulta);
		if ($row = mysqli_fetch_array($rs))
		{
			$mensaje = "Los Datos Ingresados Ya Existen";
			
			echo '<script language="JavaScript">';
			echo 'alert("'.$mensaje.'");';
			echo 'window.history.back()';
			echo '</script>';
			break;		
		}
		else
		{
			$insertar = "INSERT INTO pmn_web.corte_lixiviacion (fecha, num_lixiviacion)";
			$insertar.= " VALUES ('".$fecha."', '".$txtlix."')";
			//echo $insertar."<br>";
			mysqli_query($link, $insertar);
		}
		
		header("Location:pmn_ing_corte_lixiviacion_recepcion.php");
	}
	
	//---.
	if ($proceso == "M")
	{
		$fecha = $ano.'-'.$mes.'-01';
			
		$actualizar = "UPDATE pmn_web.corte_lixiviacion SET num_lixiviacion = '".$txtlix."'";		
		$actualizar.= " WHERE fecha = '".$fecha."'";
		mysqli_query($link, $actualizar);
		
		header("Location:pmn_ing_corte_lixiviacion_recepcion.php");
	}
	
	//---.
	if ($proceso == "E")
	{
		$fecha = $ano.'-'.$mes.'-01';
			
		$eliminar = "DELETE FROM pmn_web.corte_lixiviacion";
		$eliminar.= " WHERE fecha = '".$fecha."'";
		mysqli_query($link, $eliminar);
		
		header("Location:pmn_ing_corte_lixiviacion_recepcion.php");
	}
?>