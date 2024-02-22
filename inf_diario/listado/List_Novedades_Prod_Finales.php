
<?
include("conectar.php");

$Fecha =$ano."-".$mes."-".$dia;

$Cod_Tipo9="10";
   $sql = "SELECT * FROM novedades WHERE Fecha LIKE '%$Fecha%'and Cod_Tipo LIKE '%$Cod_Tipo9%' ";
   $result = mysql_query($sql, $link);
   if ($row = mysql_fetch_array($result))
   {
       $Nombre_Prod_Finales = $row["Nombre"];
       $Texto_Prod_Finales= strtoupper($row["Texto"]);
   }
    include("cerrar.php"); 
?>
