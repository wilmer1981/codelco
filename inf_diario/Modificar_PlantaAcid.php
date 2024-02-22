<?
include("conectar.php");


$Cod_Tipo = "3";
$Seccion = "3";

$Unidad1 = "Hrs/día";
$Descripcion1 = "Tiempo Operación";

$Unidad2 = "Ton";
$Descripcion2 = "Producción";

$Unidad3 = "M3/Hrs";
$Descripcion3 = "Flujo Gases Prom.";

$Unidad4 = "%";
$Descripcion4 = "Conc. SO2 Prom.";

$Unidad5 = "%";
$Descripcion5 = "Conc. Acido Prom.";

$Unidad6 = "ºC";
$Descripcion6 = "Minima";

$Unidad7 = "ºC";
$Descripcion7 = "Máxima";

$Unidad8 = "--";
$Descripcion8 = "K3 (59.4)";

$Unidad9 = "--";
$Descripcion9 = "K5 (83.8)";

$Unidad10 = "--";
$Descripcion10 = "K6 (89.7)";

$Unidad11 = "--";
$Descripcion11 = "Purgas Acido";

$Fecha =$ano."-".$mes."-".$dia;

$Modificar = "UPDATE fundicion SET Fecha='$Fecha', Rut='$CookieUsuario', Nombre='$CookieNombreUsuario', Cod_Tipo='$Cod_Tipo', Seccion='$Seccion', Campo1='$Campo1', Unidad1='$Unidad1', Descripcion1='$Descripcion1', Campo2='$Campo2', Unidad2='$Unidad2', Descripcion2='$Descripcion2', Campo3='$Campo3', Unidad3='$Unidad3', Descripcion3='$Descripcion3', Campo4='$Campo4', Unidad4='$Unidad4', Descripcion4='$Descripcion4', Campo5='$Campo5', Unidad5='$Unidad5', Descripcion5='$Descripcion5', Campo6='$Campo6', Unidad6='$Unidad6', Descripcion6='$Descripcion6', Campo7='$Campo7', Unidad7='$Unidad7', Descripcion7='$Descripcion7', Campo8='$Campo8', Unidad8='$Unidad8', Descripcion8='$Descripcion8', Campo9='$Campo9', Unidad9='$Unidad9', Descripcion9='$Descripcion9', Campo10='$Campo10', Unidad10='$Unidad10', Descripcion10='$Descripcion10', Campo11='$Campo11', Unidad11='$Unidad11', Descripcion11='$Descripcion11' WHERE Fecha='$Fecha' and Cod_Tipo='$CookieTipoUsuario'";

mysql_query($Modificar);

header("location:PlantaAcid.php");

?>
