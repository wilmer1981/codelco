<? 
	$ArchRuta="c:\programas\sapmm\LeerExcel.txt";
	$var=file($ArchRuta);
	$var[1]="Mant".$CmbAno.str_pad($CmbMes,2,'0',STR_APD_LEFT)."\r\n";
	/*while(list($c,$v)=each($var))
	{
		echo "Valor: ".$v."<br>";
	}*/
	reset($var);
	$ArchSal = fopen($ArchRuta,"w+");
	while(list($c,$v)=each($var))
	{
		fwrite($ArchSal,$v);
	}
	if($Archivo_name!='none')
	{
		$Extension=explode('.',$Archivo_name);
		if(strtoupper($Extension[1])!='EXE'&&strtoupper($Extension[1])!='ZIP'&&strtoupper($Extension[1])!='RAR')
		{
			$Directorio="c:/programas/sapmm/";
			$NombreArchivo="Mant".$CmbAno.str_pad($CmbMes,2,'0',STR_APD_LEFT).".xls";
			if (copy($Archivo, $Directorio."".$NombreArchivo))
				$Mensaje = "Archivo Copiado Exitosamente";
			else
				$Mensaje = "FALLA al Copiar el Archivo";
		}
	}
	header('location:sube_archivos_sam_web.php?Mensaje='.$Mensaje);
?>
