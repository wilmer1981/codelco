<?php
include("conectar.php");

$Fecha =$ano."-".$mes."-".$dia;

$Cod_Tipo="3";

   $sql = "SELECT * FROM informe_diario.novedades WHERE Fecha LIKE '%$Fecha%'and Cod_Tipo LIKE '%$Cod_Tipo%' ";
   $result = mysqli_query($link,$sql);
    $Nombre_a="";
    $Texto_a ="";
   if ($row = mysqli_fetch_array($result))
   {
       $Nombre_a = $row["Nombre"];
       $Texto_a = strtoupper($row["Texto"]);
   }
    include("cerrar.php"); 
?>
