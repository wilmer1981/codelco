<?php 	
	include("../principal/conectar_sec_web.php");	
	$Datos=explode('//',$Valores);
	$CodLote = "";
	$NumLote = "";
	foreach($Datos as $Clave => $Valor)
	{
		$Datos2=explode('~~',$Valor);
		$IE=$Datos2[0];
		$NombreProducto=$Datos2[1];
		$NombreSubProducto=$Datos2[2];
		$CodProducto=$Datos2[3];
		$CodSubProducto=$Datos2[4];
		$Peso=$Datos2[5];
		$TipoIE=$Datos2[6];
		$CodLote = $Datos2[8];
		$NumLote = $Datos2[9];
		$PesoPreparado=$Datos2[7];
		$Marca=$Datos2[10];
		if ($PesoPreparado=='')
		{
			$PesoPreparado=0;
		}
	}
	if (($CodLote == "") || ($NumLote == ""))
	{
		header("location:sec_programa_adm_loteo.php?TipoIE=Normal&Error=S");
	}
	else
	{
		switch ($TipoIE)
		{
			case "E":
				$Actualizar="UPDATE sec_web.programa_enami set estado1='R',estado2='T' where corr_enm=".$IE;
				mysqli_query($link, $Actualizar);
				break;
			case "C":
				$Actualizar="UPDATE sec_web.programa_codelco set estado1='R',estado2='T' where corr_codelco=".$IE;
				mysqli_query($link, $Actualizar);
				break;
		}
		header("location:sec_programa_adm_loteo.php?TipoIE=Normal");	
	}	
?>	