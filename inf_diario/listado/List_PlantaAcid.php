<?php
    include("conectar.php");

    $Fecha =$ano."-".$mes."-".$dia;
    $Cod_Tipo="3";

    $sql = "SELECT * FROM informe_diario.fundicion WHERE Fecha LIKE '%$Fecha%'and Cod_Tipo LIKE '%$Cod_Tipo%' ";
    $result = mysqli_query($link,$sql);
	$Nombre_a = "";
	$Campo1_a = "";$Campo2_a = "";$Campo3_a = "";$Campo4_a = "";$Campo5_a = "";
	$Campo6_a = "";$Campo7_a = "";$Campo8_a = "";$Campo9_a = "";$Campo10_a = "";
	$Campo11_a = "";
    if ($row = mysqli_fetch_array($result))
    {
		$Nombre_a = $row["Nombre"];
		$Campo1_a = $row["Campo1"];
		$Campo2_a = $row["Campo2"];
		$Campo3_a = $row["Campo3"];
		$Campo4_a = $row["Campo4"];
		$Campo5_a = $row["Campo5"];
		$Campo6_a = $row["Campo6"];
		$Campo7_a = $row["Campo7"];
		$Campo8_a = $row["Campo8"];
		$Campo9_a = $row["Campo9"];
		$Campo10_a = $row["Campo10"];
		$Campo11_a = $row["Campo11"];
    }
    include("cerrar.php"); 
?>