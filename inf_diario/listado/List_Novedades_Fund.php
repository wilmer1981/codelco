
<?
include("conectar.php");

$Fecha =$ano."-".$mes."-".$dia;


$Cod_Tipo1="1";

   $sql = "SELECT * FROM novedades WHERE Fecha LIKE '%$Fecha%'and Cod_Tipo LIKE '%$Cod_Tipo1%' ";
   $result = mysql_query($sql, $link);


   if ($row = mysql_fetch_array($result))
   {

       $Nombre_f = $row["Nombre"];
       $Texto_f = strtoupper($row["Texto"]);
   }
    include("cerrar.php");
?>
