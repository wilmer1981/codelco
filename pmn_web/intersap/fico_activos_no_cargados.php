<?php
	include("inter_conectar.php");
	$Archivo = fopen("activos_no_cargados.txt","r+");
	$Eliminar="delete from interfaces_sap.fico_activos_no_cargados2 ";
	mysqli_query($link, $Eliminar);
	while (!feof($Archivo))
	{
		$Linea=fgets($Archivo, 512);
		switch (strtoupper(substr($Linea,0,3)))
		{
			case "REG":
				$Valores= explode("->",substr($Linea,10));				
				break;
			case "EMP":
				$NroPersonal = substr($Linea,9,8);
				$Reg=$Valores[0];
				$Clase=$Valores[1];
				$NroAnt=$Valores[2];
				$Nombre=$Valores[3];
				$CC=$Valores[4];
				
				$Insertar = "INSERT INTO interfaces_sap.fico_activos_no_cargados2 (numero_personal, reg, clase_inmoviliario, numero_antiguo, nombre_activo,cc) ";
				$Insertar.= " values('".$NroPersonal."','".$Reg."','".$Clase."','".$NroAnt."','".str_replace("'","",$Nombre)."','".$CC."')";
				mysqli_query($link, $Insertar);
				echo $Insertar;
				break;
		}
		
		//$Linea=str_replace(chr(10),"",$Linea);
	}
	//fwrite($Archivo2,$Linea."\r\n");
	fclose($Archivo);
?>