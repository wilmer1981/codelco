<?php
	include("../principal/conectar_sec_web.php");
	
	if ($proceso == "G")
	{	
		$consulta = "SELECT * FROM sec_web.cubas_proveedor";
		$consulta.= " WHERE cod_circuito = '".$cmbcircuito."' AND cod_grupo = '".$cmbgrupo."' AND cod_cuba = '".$cmbcuba."'";
		//echo $consulta."<br>";
		$rs = mysqli_query($link, $consulta);
		
		if ($row = mysqli_fetch_array($rs)) //Actualizar.
		{
			$actualizar = "UPDATE sec_web.cubas_proveedor SET cod_proveedor = '".$cmbproveedor."'";
			$actualizar.= " WHERE cod_circuito = '".$cmbcircuito."' AND cod_grupo = '".$cmbgrupo."' AND cod_cuba = '".$cmbcuba."'";
			//echo $actualizar."<br>";
			mysqli_query($link, $actualizar);
		}
		else //Grabar
		{
			$insertar = "INSERT INTO sec_web.cubas_proveedor (cod_circuito,cod_grupo,cod_cuba,cod_proveedor)";
			$insertar.= " VALUES ('".$cmbcircuito."','".$cmbgrupo."','".$cmbcuba."','".$cmbproveedor."')";
			//echo $insertar."<br>";			
			mysqli_query($link, $insertar);
		}
		
		header("Location:sec_ing_cubas_proveedor.php");
	}	
	
	include("../principal/cerrar_sec_web.php");
?>