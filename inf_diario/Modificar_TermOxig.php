<?
include("conectar.php");

$Cod_Tipo = "4";
$Seccion = "4";

$Unidad1 = "Ton/día";
$Descripcion1 = "Producción LOX";

$Unidad2 = "Ton/dia";
$Descripcion2 = "Producción GOX";

$Unidad3 = "KNm3/hr";
$Descripcion3 = "Consumo Real (FQI 165-B)";

$Unidad4 = "Lts.";
$Descripcion4 = "Nivel BO1";

$Unidad5 = "KNm3/hr";
$Descripcion5 = "Consignas Planta GOX";

$Unidad6 = "KNm3/hr";
$Descripcion6 = "Consignas LOX";

$Unidad7 = "KNm3/hr";
$Descripcion7 = "Flujo Turbina (FIC 540)";

$Unidad8 = "Kpa-g";
$Descripcion8 = "PDI (540/542)";

$Unidad9 = "Ton/dia";
$Descripcion9 = "K-3";

$Unidad10 = "Ton/dia";
$Descripcion10 = "K-4";

$Unidad11 = "Ton/dia";
$Descripcion11 = "K-5";

$Unidad12 = "F/S";
$Descripcion12 = "K-3";

$Unidad13 = "F/S";
$Descripcion13 = "K-4";

$Unidad14 = "F/S";
$Descripcion14 = "K-5";

$Unidad15 = "--";
$Descripcion15 = "Factor de Potencia (COSPI)";


$Fecha =$ano."-".$mes."-".$dia;


$Modificar = "UPDATE fundicion SET Fecha='$Fecha', Rut='$CookieUsuario', Nombre='$CookieNombreUsuario', Cod_Tipo='$Cod_Tipo', Seccion='$Seccion', Campo1='$Campo1', Unidad1='$Unidad1', Descripcion1='$Descripcion1', Campo2='$Campo2', Unidad2='$Unidad2', Descripcion2='$Descripcion2', Campo3='$Campo3', Unidad3='$Unidad3', Descripcion3='$Descripcion3', Campo4='$Campo4', Unidad4='$Unidad4', Descripcion4='$Descripcion4', Campo5='$Campo5', Unidad5='$Unidad5', Descripcion5='$Descripcion5', Campo6='$Campo6', Unidad6='$Unidad6', Descripcion6='$Descripcion6', Campo7='$Campo7', Unidad7='$Unidad7', Descripcion7='$Descripcion7', Campo8='$Campo8', Unidad8='$Unidad8', Descripcion8='$Descripcion8', Campo9='$Campo9', Unidad9='$Unidad9', Descripcion9='$Descripcion9', Campo10='$Campo10', Unidad10='$Unidad10', Descripcion10='$Descripcion10', Campo11='$Campo11', Unidad11='$Unidad11', Descripcion11='$Descripcion11', Campo12='$Campo12', Unidad12='$Unidad12', Descripcion12='$Descripcion12', Campo13='$Campo13', Unidad13='$Unidad13', Descripcion13='$Descripcion13', Campo14='$Campo14', Unidad14='$Unidad14', Descripcion14='$Descripcion14', Campo15='$Campo15', Unidad15='$Unidad15', Descripcion15='$Descripcion15' WHERE Fecha='$Fecha' and Cod_Tipo='$CookieTipoUsuario'  ";


mysql_query($Modificar);

header("location:TermOxig.php");

?>

