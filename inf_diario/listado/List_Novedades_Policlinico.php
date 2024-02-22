
<?
include("conectar.php");

$Fecha =$ano."-".$mes."-".$dia;

$Cod_Tipo7="7";

   $sql = "SELECT * FROM novedades WHERE Fecha LIKE '%$Fecha%'and Cod_Tipo LIKE '%$Cod_Tipo7%' ";
   $result = mysql_query($sql, $link);


   if ($row = mysql_fetch_array($result))
   {

       $Nombre_pol = $row["Nombre"];
       $Texto_pol = strtoupper($row["Texto"]);
   }
    include("cerrar.php"); 
?>
