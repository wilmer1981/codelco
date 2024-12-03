<?php
include("conectar.php");

$Fecha =$ano."-".$mes."-".$dia;

$Cod_Tipo="4";

   $sql = "SELECT * FROM informe_diario.novedades WHERE Fecha LIKE '%$Fecha%'and Cod_Tipo LIKE '%$Cod_Tipo%' ";
   $result = mysqli_query($link,$sql);
   $Nombre_t="";
   $Texto_t ="";
   if ($row = mysqli_fetch_array($result))
   {

       $Nombre_t = $row["Nombre"];
       $Texto_t = strtoupper($row["Texto"]);
   }
    include("cerrar.php"); 
?>
