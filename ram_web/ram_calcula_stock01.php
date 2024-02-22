<?php
	//GRABA ARCHIVO DE CONFIGURACION
	if ($DiaIni < 10)
	{
		$DiaIni = "0".$DiaIni;
	}
	if ($MesIni < 10)
	{
		$MesIni = "0".$MesIni;
	}
	if ($DiaFin < 10)
	{
		$DiaFin = "0".$DiaFin;
	}
	if ($MesFin < 10)
	{
		$MesFin = "0".$MesFin;
	}
	$FechaInicio = $AnoIni."-".$MesIni."-".$DiaIni;
	$FechaTermino = $AnoFin."-".$MesFin."-".$DiaFin;
	$Archivo = "ram.txt";
	if ($Arr = file($Archivo)) 
	{
		$i = 0;
    	while (list ($Linea, $Contenido) = each ($Arr)) 
		{
			switch ($i)
			{
				case 0:
					$Linea0 = $Contenido;
					break;
				case 1:
					$Linea1 = $Contenido;
					break;
				case 2:
					$Linea2 = $Contenido;
					break;
				case 3:
					$Linea3 = $Contenido;
					break;
				case 4:
					$Linea4 = $Contenido;
					break;
			}
			$i++;
        	//echo "Linea Nº ".$Linea." = ".$Contenido."<br>";
    	}
	}
	$Salto = CHR(13);
	$ArchivoNuevo = fopen("ram.txt","w+");
	fwrite($ArchivoNuevo,$Linea0);
	fwrite($ArchivoNuevo,$Linea1);
	fwrite($ArchivoNuevo,$FechaInicio.$Salto);
	fwrite($ArchivoNuevo,$FechaTermino.$Salto);
	fwrite($ArchivoNuevo,$Linea4);
	fclose($ArchivoNuevo);
	//EJECUTA PROGRAMA EN EL SERVIDOR
	$str = system("AutomaticoRam.exe");
	/*if(strlen($str)>1)
	{
 		$Mensaje = "Programa Ejecutado";
	}
	else
	{
     	$Mensaje = "Programa NO Ejecutado";      
  	}*/
	header("location:ram_calcula_stock.php?Mensaje=".$Mensaje);	
	
	// OTRAS COSAS
		//$par= "my_parameter";
    //$test=`c:\ram.exe`;
	//$$test = shell_exec('ram.exe');
	//echo "<pre>$test</pre>";
	//$out = exec("C:\Archivos de programa\Apache Group\Apache\htdocs\proyecto\ram.exe",$arr);
	//echo $arr[0];
  //$str=exec("ping -c 1 -w 1 10.56.11.7",$a,$a1);
  /*$str=shell_exec("ejecutar.bat",$a,$a1);
  $Largo = $a;
  for ($i=0;$i<=Largo;$i++)
  {
  	echo $a[$i]."$i<br>";
  }
  echo $a;
  //echo $al;
  print "<table>";
  if(strlen($str)>1){
     print"<tr><td>present</td></tr>";  
  }else{
     print"<tr><td>Not present</td></tr>";      
  }
 print "</table> ";*/
?>