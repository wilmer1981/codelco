<?
include("conectar.php");

$Fecha =$ano."-".$mes."-".$dia;

$Cod_Tipo="4";

$Eliminar = "DELETE FROM fundicion WHERE Fecha='$Fecha' and Cod_Tipo='$CookieTipoUsuario' " ;

mysql_query($Eliminar);

header("location:TermOxig.php");

?>
