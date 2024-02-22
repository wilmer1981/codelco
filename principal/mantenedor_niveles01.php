<?php
	include("conectar_principal.php");
	
	if ($opc == "G") // GRABAR	
	{
		$insertar = "INSERT INTO niveles_por_sistema (cod_sistema,nivel,descripcion) VALUES ";
		$insertar = $insertar."(".$cmbsistema.",".$txtnivel.",'".ucwords(strtolower($txtdescripcion))."')";
	
		mysqli_query($link, $insertar);
		$mensaje = "Nivel Grabado Correctamente";
		header("Location:mantenedor_niveles.php?mensaje=".$mensaje."&recargapag=1&cmbsistema=".$cmbsistema);
	}
	if ($opc == "A")  //MODIFICAR (ACTUALIZAR)	
	{
		$Actualizar = "UPDATE niveles_por_sistema set ";
		$Actualizar.= " descripcion = '".$txtdescripcion."' ";
		$Actualizar.= " where cod_sistema = ".$cmbsistema." and nivel = ".$txtnivel;	
		mysqli_query($link, $Actualizar);
		$mensaje = "Nivel Actualizado Correctamente";
		header("Location:mantenedor_niveles.php?mensaje=".$mensaje."&recargapag=1&cmbsistema=".$cmbsistema);
	}
	if ($opc == "E") //ELIMINAR
	{
		$largo = strlen($parametros);
		for ($i=0; $i < $largo; $i++)
		{
			if (substr($parametros,$i,1) == "/")
			{				
				$valor = substr($parametros,0,$i);				
				$parametros = substr($parametros,$i+1);
				$i = 0;			
				$eliminar = "DELETE FROM niveles_por_sistema WHERE cod_sistema = ".$cmbsistema." and nivel = ".$valor;
				mysqli_query($link, $eliminar);
			}	
		}	
		$mensaje = "Nivel(es) Eliminado(s) Correctamente";
		header("Location:mantenedor_niveles.php?mensaje=".$mensaje."&recargapag=1&cmbsistema=".$cmbsistema);
	}
	
	include("cerrar_principal.php");
?>	