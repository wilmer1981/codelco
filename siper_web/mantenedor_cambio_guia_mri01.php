<?

if($Carga=='S')
{
$Directorio='documento';
$Seg=date("s");

if($Archivo_name!='none')
{
	$Extension=explode('.',$Archivo_name);
	if(strtoupper($Extension[1])=='PDF')
	{
			$Acento=false;
			for ($j = 0;$j <= strlen($Archivo_name); $j++)
			{
				switch(substr($Archivo_name,$j,1))
				{
					case "á":
						$Archivo_name=str_replace( "á","a",$Archivo_name);
					break;
					case "Á":
						$Archivo_name=str_replace( "Á","A",$Archivo_name);
					break;
					case "é":
						$Archivo_name=str_replace( "é","e",$Archivo_name);
					break;
					case "É":
						$Archivo_name=str_replace( "É","E",$Archivo_name);
					break;
					case "í":
						$Archivo_name=str_replace( "í","i",$Archivo_name);
					break;
					case "Í":
						$Archivo_name=str_replace( "Í","I",$Archivo_name);
					break;
					case "ó":
						$Archivo_name=str_replace( "ó","o",$Archivo_name);
					break;
					case "Ó":
						$Archivo_name=str_replace( "Ó","O",$Archivo_name);
					break;
					case "ú":
						$Archivo_name=str_replace( "ú","u",$Archivo_name);
					break;
					case "Ú":
						$Archivo_name=str_replace( "Ú","U",$Archivo_name);
					break;
					case "&":
						$Archivo_name=str_replace( "&","",$Archivo_name);
					break;
					case "$":
						$Archivo_name=str_replace( "$","",$Archivo_name);
					break;
					case "#":
						$Archivo_name=str_replace( "#","",$Archivo_name);
					break;
					case "'":
						$Archivo_name=str_replace( "'","",$Archivo_name);
					break;
				}
			}
			if($Acento==false)
			{
					$NombreArchivo=$Archivo_name;
					unlink($Directorio.'/Guia para calculo de la Magnitud de Riesgo Inicial.pdf');
					if (copy($Archivo, $Directorio.'/'.$NombreArchivo))
					{
						rename( $Directorio.'/'.$NombreArchivo,  $Directorio.'/Guia para calculo de la Magnitud de Riesgo Inicial.pdf');
						$ProcesaArchivo = "S";
						//echo "entrooo<br>";
					}
					else
						$ProcesaArchivo = "N";
			}
	}
	else
		$ProcesaArchivo = "N";
}	
header("location:mantenedor_cambio_guia_mri.php?Msj=".$ProcesaArchivo);	
}
?>