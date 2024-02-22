<?
include("conectar.php");
$Fecha =$ano."-".$mes."-".$dia;
$Cod_Tipo="8";

$sql = "SELECT Fecha, Cod_Tipo FROM novedades WHERE Fecha = '$Fecha' and Cod_Tipo = '$Cod_Tipo'";
$result = mysql_query($sql, $link);

 if ($row = mysql_fetch_array($result))
 {
 $Texto = str_replace("'"," ",$Texto);
 $Texto = str_replace('"',' ',$Texto);
$Modificar = "UPDATE novedades SET Fecha='$Fecha', Rut='$CookieUsuario', Cod_Tipo='$CookieTipoUsuario', Nombre='$CookieNombreUsuario', Texto='$Texto' WHERE Fecha='$Fecha' and Cod_Tipo='$CookieTipoUsuario'";
mysql_query($Modificar);
	 
header("Location:Novedades_segi.php");
}	 
else 
    {
    $Texto = str_replace("'"," ",$Texto);
    $Texto = str_replace('"',' ',$Texto);
    $Insertar = "INSERT INTO novedades";
    $Insertar = "$Insertar (Fecha, Rut, Cod_Tipo, Nombre, Texto)";
    $Insertar = "$Insertar VALUES ('$Fecha', '$CookieUsuario', '$CookieTipoUsuario', '$CookieNombreUsuario', '$Texto')";
    mysql_query($Insertar);
    include("cerrar.php");
	header("location:Novedades_segi.php");
    }
?>
