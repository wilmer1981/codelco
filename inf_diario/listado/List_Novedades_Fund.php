<?php
include("conectar.php");

	$Fecha =$ano."-".$mes."-".$dia;
	$Cod_Tipo1="1";

   $sql = "SELECT * FROM informe_diario.novedades WHERE Fecha LIKE '%$Fecha%'and Cod_Tipo LIKE '%$Cod_Tipo1%' ";
   $result = mysqli_query($link,$sql);

   $Nombre_f="";
   $Texto_f = "";
   if ($row = mysqli_fetch_array($result))
   {
       $Nombre_f = $row["Nombre"];
       $Texto_f = strtoupper($row["Texto"]);
   }
    include("cerrar.php");
?>
