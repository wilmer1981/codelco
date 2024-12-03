
<?php
include("conectar.php");

$Fecha =$ano."-".$mes."-".$dia;

$Cod_Tipo9="10";
   $sql = "SELECT * FROM informe_diario.novedades WHERE Fecha LIKE '%$Fecha%'and Cod_Tipo LIKE '%$Cod_Tipo9%' ";
   $result = mysqli_query($link, $sql);
   $Nombre_Prod_Finales="";
   $Texto_Prod_Finales="";
   if ($row = mysqli_fetch_array($result))
   {
       $Nombre_Prod_Finales = $row["Nombre"];
       $Texto_Prod_Finales= strtoupper($row["Texto"]);
   }
    include("cerrar.php"); 
?>
