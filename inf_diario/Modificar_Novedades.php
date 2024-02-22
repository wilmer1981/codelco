<?
include("conectar.php");
$Texto = str_replace("'"," ",$Texto);
$Texto = str_replace('"',' ',$Texto);
$Modificar = "UPDATE novedades SET Fecha='$CookieFecha', Rut='$CookieUsuario', Cod_Tipo='$CookieTipoUsuario', Nombre='$CookieNombreUsuario', Texto='$Texto' WHERE Fecha='$CookieFecha' and Cod_Tipo='$CookieTipoUsuario'";
mysql_query($Modificar);
	 
if ($CookieTipoUsuario == "1")
header("location:Fundicion.php");
if ($CookieTipoUsuario == "2")
header("location:Refino.php");
if ($CookieTipoUsuario == "3")
header("location:PlantaAcid.php");
if ($CookieTipoUsuario == "4")
header("location:TermOxig.php");

?>
