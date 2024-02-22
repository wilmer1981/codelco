<?php
	session_register("arreglo");
	
	$Largo = count($a);
	echo $Largo."<br><br>";
	
	while (list($clave,$valor) = each($a))
	{
	/*
		echo $arreglo[$clave][0]."-".$arreglo[$clave][1]."-".$arreglo[$clave][2]."-".$arreglo[$clave][3]."-";
		echo $arreglo[$clave][4]."-".$arreglo[$clave][5]."-".$arreglo[$clave][6]."<br>";
	*/
		echo $unidades[$clave];
	}		
		
?>