<?php
   include("conectar.php");

   $Fecha =$ano."-".$mes."-".$dia;

   $Cod_Tipo9="9";
   $sql = "SELECT * FROM informe_diario.novedades WHERE Fecha LIKE '%$Fecha%'and Cod_Tipo LIKE '%$Cod_Tipo9%' ";
   $result = mysqli_query($link,$sql);
   $Nombre_Prod_Met="";
   $Texto_Prod_Met ="";
   if ($row = mysqli_fetch_array($result))
   {
       $Nombre_Prod_Met = $row["Nombre"];
       $Texto_Prod_Met = strtoupper($row["Texto"]);
   }
    include("cerrar.php"); 
?>
