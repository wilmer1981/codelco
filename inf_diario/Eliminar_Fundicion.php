<?
include("conectar.php");

$Fecha =$ano."-".$mes."-".$dia;

$Cod_Tipo="1";

$Eliminar = "DELETE FROM fundicion WHERE Fecha='$Fecha' and Cod_Tipo='$CookieTipoUsuario' " ;
mysql_query($Eliminar);

include("cerrar.php");
header("location:Fundicion.php");

?>
