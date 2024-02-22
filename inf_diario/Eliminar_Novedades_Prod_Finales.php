<?
include("conectar.php");

$Fecha =$ano."-".$mes."-".$dia;


$Eliminar = "DELETE FROM novedades WHERE Fecha='$Fecha'and Cod_Tipo='$CookieTipoUsuario' ";
mysql_query($Eliminar);

header("Location:Novedades_Prod_Finales.php");
?>

