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
					case "�":
						$Archivo_name=str_replace( "�","a",$Archivo_name);
					break;
					case "�":
						$Archivo_name=str_replace( "�","A",$Archivo_name);
					break;
					case "�":
						$Archivo_name=str_replace( "�","e",$Archivo_name);
					break;
					case "�":
						$Archivo_name=str_replace( "�","E",$Archivo_name);
					break;
					case "�":
						$Archivo_name=str_replace( "�","i",$Archivo_name);
					break;
					case "�":
						$Archivo_name=str_replace( "�","I",$Archivo_name);
					break;
					case "�":
						$Archivo_name=str_replace( "�","o",$Archivo_name);
					break;
					case "�":
						$Archivo_name=str_replace( "�","O",$Archivo_name);
					break;
					case "�":
						$Archivo_name=str_replace( "�","u",$Archivo_name);
					break;
					case "�":
						$Archivo_name=str_replace( "�","U",$Archivo_name);
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