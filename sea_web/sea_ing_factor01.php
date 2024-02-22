<?php
	include("../principal/conectar_principal.php");
	
		$proceso = $_REQUEST["proceso"];
		$cmbcircuito = $_REQUEST["cmbcircuito"];
		$cmbgrupo = $_REQUEST["cmbgrupo"];
		$txtvalor = $_REQUEST["txtvalor"];


	
	if ($proceso == "G") //Grabar
	{
		$consulta = "SELECT * FROM sub_clase WHERE cod_clase = 2003 AND cod_subclase = ".$cmbcircuito;
		$rs = mysqli_query($link, $consulta);
		$actualizar = "UPDATE sub_clase SET valor_subclase1 = '".$txtvalor."' WHERE cod_clase = 2003 AND cod_subclase = ".$cmbcircuito;
		mysqli_query($link, $actualizar);
			
		header("Location:sea_ing_factor.php");
	}

/*	
	if ($proceso == "E") //Eliminar
	{
		$largo = strlen($parametros);
		for ($i=0; $i < $largo; $i++)
		{
			if (substr($parametros,$i,1) == "/")
			{				
				$valor = substr($parametros,0,$i);				
				$parametros = substr($parametros,$i+1);
				$i = 0;
				$circ = substr($valor,0,strpos($valor,"-"));
				$grup = substr($valor,strpos($valor,"-")+1,strlen($valor));
				$eliminar = "DELETE FROM factores WHERE circuito = ".$circ." AND grupo = ".$grup;
				mysqli_query($link, $eliminar);
			}	
		}
		$mensaje = "Circuito(s) Eliminado(s) Correctamente"	;
		header("Location:sea_ing_factor.php?mensaje=".$mensaje);
	}
*/	
	include("../principal/cerrar_principal.php");
?>