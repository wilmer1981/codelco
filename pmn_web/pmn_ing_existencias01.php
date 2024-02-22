<?php
	include("../principal/conectar_pmn_web.php");
	
	if ($proceso == "G")
	{
		$consulta = "SELECT * FROM pmn_web.existencia_nodo";		
		$consulta.= " WHERE ano = '".$ano1."' AND mes = '".$mes1."' AND nodo = '".$cmbnodo."' AND prod = '".$cmbprod."'";
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
			$insertar = "INSERT INTO pmn_web.existencia_nodo (ano,mes,nodo,prod,peso,fino_ag,fino_au)";
			$insertar.= " VALUES ('".$ano1."', '".$mes1."', '".$cmbnodo."', '".$cmbprod."', '".str_replace(',','.',$txtpeso)."', '".str_replace(',','.',$txtag)."', '".str_replace(',','.',$txtau)."')";
			//echo $insertar;
			mysqli_query($link, $insertar);
		}
		
		$linea = "recargapag1=S&ano1=".$ano1."&mes1=".$mes1;
		header("Location:pmn_ing_existencias.php?".$linea);
	}
	
	//---.
	if ($proceso == "M")
	{
		$actualizar = "UPDATE pmn_web.existencia_nodo SET ";		
		$actualizar.= " peso = '".str_replace(',','.',$txtpeso)."',";
		$actualizar.= " fino_ag = '".str_replace(',','.',$txtag)."',";
		$actualizar.= " fino_au = '".str_replace(',','.',$txtau)."'";
		$actualizar.= " WHERE ano = '".$ano_aux."' AND mes = '".$mes_aux."' AND nodo = '".$nodo_aux."' AND prod = '".$prod_aux."'";
		//echo $actualizar;
		mysqli_query($link, $actualizar);
				
		header("Location:pmn_ing_existencias.php");		
	}
	
	//---.
	if ($proceso == "E")
	{
		$eliminar = "DELETE FROM pmn_web.existencia_nodo";
		$eliminar.= " WHERE ano = '".$ano_aux."' AND mes = '".$mes_aux."' AND nodo = '".$nodo_aux."' AND prod = '".$prod_aux."'";
		mysqli_query($link, $eliminar);
		
		header("Location:pmn_ing_existencias.php");			
	}
?>