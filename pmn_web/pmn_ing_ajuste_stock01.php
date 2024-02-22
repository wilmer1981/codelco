<?php
	include("../principal/conectar_pmn_web.php");
	
	//---------
	if ($proceso == "B")
	{					
		$vector = explode('-',$fecha);
		
		$linea = "mostrar=S&recargapag1=S&cmbproducto=".$producto."&cmbsubproducto=".$subproducto."&radiotipo=".$tipo."&txtpeso=".$peso;
		$linea.= "&ano=".$vector[0]."&mes=".$vector[1]."&dia=".$vector[2]."&fecha_aux=".$fecha."&cmbturno=".$turno."&turno_aux=".$turno;
		header("Location:pmn_ing_ajuste_stock.php?".$linea);
	}

	$fecha = $ano.'-'.$mes.'-'.$dia;	
	//----------
	if ($proceso == "G")
	{
		$consulta = "SELECT * FROM pmn_web.ajuste_stock";
		$consulta.= " WHERE fecha = '".$fecha."' AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
		$consulta.= " AND cod_turno = '".$cmbturno."'";
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
			$insertar = "INSERT INTO pmn_web.ajuste_stock (fecha,cod_producto,cod_subproducto,tipo,peso,cod_turno)";
			$insertar.= " VALUES ('".$fecha."', '".$cmbproducto."', '".$cmbsubproducto."', '".$radiotipo."', '".$txtpeso."', '".$cmbturno."')";
			mysqli_query($link, $insertar);
		}
		
		header("Location:pmn_ing_ajuste_stock.php");
	}
		
	//----------
	if ($proceso == "M")
	{
		$actualizar = "UPDATE pmn_web.ajuste_stock SET tipo = '".$radiotipo."', peso = '".$txtpeso."', fecha = '".$fecha."', cod_turno = '".$cmbturno."'";
		$actualizar.= " WHERE fecha = '".$fecha_aux."' AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";		
		$actualizar.= " AND cod_turno = '".$turno_aux."'";
		mysqli_query($link, $actualizar);
		
		header("Location:pmn_ing_ajuste_stock.php");
	}
	
	//---------
	if ($proceso == "E")		
	{	
		$eliminar = "DELETE FROM pmn_web.ajuste_stock";
		$eliminar.= " WHERE fecha = '".$fecha_aux."' AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
		$eliminar.= " AND cod_turno = '".$cmbturno."'";
		//echo $eliminar;
		mysqli_query($link, $eliminar);
		
		header("Location:pmn_ing_ajuste_stock.php");
	}
			
	include("../principal/cerrar_pmn_web.php");
?>