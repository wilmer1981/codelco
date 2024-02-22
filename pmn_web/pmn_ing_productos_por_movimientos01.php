<?php
	include("../principal/conectar_pmn_web.php");
	
	//-------.
	if ($proceso == "G")
	{	
		$fecha = $ano.'-'.$mes.'-'.$dia;
	
		$consulta = "SELECT * FROM pmn_web.productos_por_movimientos";
		$consulta.= " WHERE tipo_mov = '".$cmbmovimiento."' AND fecha = '".$fecha."' AND id = '".$txtid."'";
		$consulta.= " AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
		//echo $consulta."<br>";
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
			$insertar = "INSERT INTO pmn_web.productos_por_movimientos (tipo_mov,fecha,cod_producto,cod_subproducto,id,fino_cu,fino_ag,fino_au,unid_cu,unid_ag,unid_au,signo,peso_seco,signo_cu,signo_ag,signo_au)";
			$insertar.= " VALUES ('".$cmbmovimiento."','".$fecha."','".$cmbproducto."','".$cmbsubproducto."','".$txtid."',";
			$insertar.= "'".str_replace(',','.',$txtleycu)."','".str_replace(',','.',$txtleyag)."','".str_replace(',','.',$txtleyau)."',";
			$insertar.= "'".str_replace(',','.',$cmbunidcu)."','".str_replace(',','.',$cmbunidag)."','".str_replace(',','.',$cmbunidau)."','".$radiotipo."', '".str_replace(',','.',$txtpeso)."',";
			$insertar.= "'".$cmbsignocu."', '".$cmbsignoag."', '".$cmbsignoau."')";
			//echo $insertar."<br>";		
			mysqli_query($link, $insertar);
		}
		
		$linea = "recargapag1=S&recargapag2=S&recargapag3=S&cmbmovimiento=".$cmbmovimiento."&cmbproducto=".$cmbproducto."&cmbsubproducto=".$cmbsubproducto;
		$linea.= "&ano=".$ano."&mes=".$mes."&dia=".$dia;
		header("Location:pmn_ing_productos_por_movimientos.php?".$linea);
	}
	
	//------.
	if ($proceso == "M")
	{
		$fecha = $ano.'-'.$mes.'-'.$dia;
	
		$actualizar = "UPDATE pmn_web.productos_por_movimientos SET";
		$actualizar.= " fecha = '".$fecha."',";
		$actualizar.= " fino_cu = '".str_replace(',','.',$txtleycu)."',";
		$actualizar.= " fino_ag = '".str_replace(',','.',$txtleyag)."',";
		$actualizar.= " fino_au = '".str_replace(',','.',$txtleyau)."',";
		$actualizar.= " unid_cu = '".str_replace(',','.',$cmbunidcu)."',";
		$actualizar.= " unid_ag = '".str_replace(',','.',$cmbunidag)."',";
		$actualizar.= " unid_au = '".str_replace(',','.',$cmbunidau)."',";
		$actualizar.= " peso_seco = '".str_replace(',','.',$txtpeso)."',";
		$actualizar.= " signo = '".$radiotipo."',";
		$actualizar.= " signo_cu = '".$cmbsignocu."',";
		$actualizar.= " signo_ag = '".$cmbsignoag."',";
		$actualizar.= " signo_au = '".$cmbsignoau."',";
		$actualizar.= " id = '".$txtid."'";						
		$actualizar.= " WHERE tipo_mov = '".$tipo_aux."' AND cod_producto = '".$prod_aux."'";
		$actualizar.= " AND cod_subproducto = '".$subprod_aux."' AND id = '".$id_aux."'";		
		$actualizar.= " AND fecha = '".$fecha_aux."' AND signo = '".$signo_aux."'";
		//echo $actualizar."<br>";
		mysqli_query($link, $actualizar);
		
		$linea = "recargapag1=S&recargapag2=S&recargapag3=S&cmbmovimiento=".$tipo_aux."&cmbproducto=".$prod_aux."&cmbsubproducto=".$subprod_aux;
		$linea.= "&ano=".$ano."&mes=".$mes."&dia=".$dia;		
		header("Location:pmn_ing_productos_por_movimientos.php?".$linea);		
	}
	
	//---------.
	if ($proceso == "E")
	{
		$eliminar = "DELETE FROM pmn_web.productos_por_movimientos";
		$eliminar.= " WHERE tipo_mov = '".$tipo_aux."' AND cod_producto = '".$prod_aux."'";
		$eliminar.= " AND cod_subproducto = '".$subprod_aux."' AND id = '".$id_aux."'";
		$eliminar.= " AND fecha = '".$fecha_aux."' AND signo = '".$signo_aux."'";				
		//echo $eliminar."<br>";
		mysqli_query($link, $eliminar);
		
		$linea = "recargapag1=S&recargapag2=S&recargapag3=S&cmbmovimiento=".$tipo_aux."&cmbproducto=".$prod_aux."&cmbsubproducto=".$subprod_aux;		
		$linea.= "&ano=".$ano."&mes=".$mes."&dia=".$dia;
		header("Location:pmn_ing_productos_por_movimientos.php?".$linea);		
	}
?>