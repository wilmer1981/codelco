<?php
include("conectar.php");

$Fecha =$ano."-".$mes."-".$dia;

$Cod_Tipo5="5";

   $sql = "SELECT * FROM informe_diario.novedades WHERE Fecha LIKE '%$Fecha%'and Cod_Tipo LIKE '%$Cod_Tipo5%' ";
   $result = mysqli_query($link,$sql);
   $Nombre_ref="";
   $Texto_ref="";
   if ($row = mysqli_fetch_array($result))
   {
       $Nombre_ref = $row["Nombre"];
       $Texto_ref = strtoupper($row["Texto"]);
   }
    include("cerrar.php"); 
?>
