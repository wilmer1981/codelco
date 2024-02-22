<?
include("conectar.php");


   $Eliminar = "DELETE FROM novedades WHERE Fecha='$CookieFecha'and Rut='$CookieUsuario' ";
    mysql_query($Eliminar);


if ($CookieTipoUsuario == "1")
header("location:Fundicion.php");
if ($CookieTipoUsuario == "2")
header("location:Refino.php");
if ($CookieTipoUsuario == "3")
header("location:PlantaAcid.php");
if ($CookieTipoUsuario == "4")
header("location:TermOxig.php");

?>

