
<?
include("conectar.php");

$Fecha =$ano."-".$mes."-".$dia;
$Fecha_ini=$ano."-".$mes."-01";
$Cod_Tipo="3";
$Acum_prod="0";
$sql = "SELECT SUM(Campo2) as Acum_prod FROM fundicion
        WHERE Cod_Tipo = '$Cod_Tipo' and Fecha BETWEEN '$Fecha_ini' and '$Fecha'";
 $result = mysql_query($sql, $link);
//echo $sql;
if($row = mysql_fetch_array($result))
{
 $Acum_prod = $row[Acum_prod];
 }
    include("cerrar.php");
?>
