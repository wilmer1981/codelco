
<?
include("conectar.php");

$Fecha =$ano."-".$mes."-".$dia;

$Cod_Tipo6="8";

   $sql = "SELECT * FROM novedades WHERE Fecha LIKE '%$Fecha%'and Cod_Tipo LIKE '%$Cod_Tipo6%' ";
   $result = mysql_query($sql, $link);


   if ($row = mysql_fetch_array($result))
   {

       $Nombre_segi = $row["Nombre"];
       $Texto_segi = strtoupper($row["Texto"]);
   }
    include("cerrar.php"); 
?>
