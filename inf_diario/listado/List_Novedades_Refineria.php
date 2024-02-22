
<?
include("conectar.php");

$Fecha =$ano."-".$mes."-".$dia;

$Cod_Tipo5="5";

   $sql = "SELECT * FROM novedades WHERE Fecha LIKE '%$Fecha%'and Cod_Tipo LIKE '%$Cod_Tipo5%' ";
   $result = mysql_query($sql, $link);


   if ($row = mysql_fetch_array($result))
   {

       $Nombre_ref = $row["Nombre"];
       $Texto_ref = strtoupper($row["Texto"]);
   }
    include("cerrar.php"); 
?>
