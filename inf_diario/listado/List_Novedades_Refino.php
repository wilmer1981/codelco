
<?
include("conectar.php");

$Fecha =$ano."-".$mes."-".$dia;

$Cod_Tipo="2";

   $sql = "SELECT * FROM novedades WHERE Fecha LIKE '%$Fecha%'and Cod_Tipo LIKE '%$Cod_Tipo%' ";
   $result = mysql_query($sql, $link);


   if ($row = mysql_fetch_array($result))
   {

       $Nombre_r = $row["Nombre"];
       $Texto_r = strtoupper($row["Texto"]);
   }
    include("cerrar.php"); 
?>
