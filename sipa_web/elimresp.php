<?php
	$UltDiaMes=date('d',mktime(0,0,0,3,1-1,2006));
	echo "ULT DIA MES ANTERIOR:".$UltDiaMes;
	
	if($TipoRegistro=='R')
		$Dir = 'prueba';
	else
		$Dir = 'prueba';
	$Directorio=opendir($Dir);
	$i=0;
	while ($ArchivoElim = readdir($Directorio)) 
	{
		if($ArchivoElim != '..' && $ArchivoElim !='.' && $ArchivoElim !='')
		{ 		
			if (file_exists($Dir."/".$ArchivoElim))
				unlink($Dir."/".$ArchivoElim);
			$i++;	
		}
		
		//echo $ArchivoElim."<br>";
	}
	closedir($Directorio);
	echo "FINALIZO DE BORRAR LOS ARCHIVOS";
	echo "ARCHIVOS BORRADOS:".$i;
	if($TipoRegistro=='R')//BORRA ARCHIVOS RESPALDO DE OTROS PESAJES
	{
		$Dir = 'RespOtrosPesajes';
		$Directorio=opendir($Dir);
		$i=0;
		while ($ArchivoElim = readdir($Directorio)) 
		{
			if($ArchivoElim != '..' && $ArchivoElim !='.' && $ArchivoElim !='')
			{ 		
				if (file_exists($ArchivoElim))
					unlink($ArchivoElim);
			}
			$i++;
		}
		closedir($Directorio);
	}			
?>