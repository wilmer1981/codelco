<?
include("conectar.php");
  
$sql = "SELECT * FROM novedades WHERE Fecha = '$CookieFecha' and Cod_Tipo = '$CookieTipoUsuario'";
$result = mysql_query($sql, $link);

 if ($row = mysql_fetch_array($result))
 {
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
/*     include("cerrar.php");
	 echo "<Script>
     alert('Ya hay datos ingresados por un Usuario');  
     JavaScript:window.history.back();
	</Script>";*/
 }
 else 
  {
      $Texto = str_replace("'"," ",$Texto);
      $Texto = str_replace('"',' ',$Texto);
      
   $Insertar = "INSERT INTO novedades";
   $Insertar = "$Insertar (Fecha, Rut, Cod_Tipo, Nombre, Texto)";
   $Insertar = "$Insertar VALUES ('$CookieFecha', '$CookieUsuario', '$CookieTipoUsuario', '$CookieNombreUsuario', '$Texto')";
   mysql_query($Insertar);


if ($CookieTipoUsuario == "1")
header("location:Fundicion.php");
if ($CookieTipoUsuario == "2")
header("location:Refino.php");
if ($CookieTipoUsuario == "3")
header("location:PlantaAcid.php");
if ($CookieTipoUsuario == "4")
header("location:TermOxig.php");

}

?>
