<?
include("conectar.php");

$Fecha =$ano."-".$mes."-".$dia;
$Texto = str_replace("'"," ",$Texto);
$Texto = str_replace('"',' ',$Texto);
$Modificar = "UPDATE novedades SET Fecha='$Fecha', Rut='$CookieUsuario', Cod_Tipo='$CookieTipoUsuario', Nombre='$CookieNombreUsuario', Texto='$Texto' WHERE Fecha='$Fecha' and Cod_Tipo='$CookieTipoUsuario'";
mysql_query($Modificar);
	 
header("Location:Novedades_Ref.php");

?>
