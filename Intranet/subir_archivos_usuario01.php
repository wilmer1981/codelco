<? 

	switch ($Proceso)	
	{
		case "G":
			//echo $Directorio."/".$Archivo_name;
	 	 	if (copy($Archivo, $Directorio."/".$Archivo_name))
	  		{
	   			$Mensaje = "Archivo Copiado Exitosamente";
			}
			else
			{
		  		$Mensaje = "FALLA al Copiar el Archivo";
	  		}
	}
	header("location:subir_archivos_usuario.php?Tipo=".$Tipo."&Mensaje=".$Mensaje);
?>

