<?
include("conectar.php");
//$CookieUsuario='06616973-1';
$CookieTipoUsuario = '1';

$Cod_Tipo = "1";
$Seccion = "1";

$Unidad1 = "TMS";
$Descripcion1 = "Carga Total";

$Unidad2 = "TMS";
$Descripcion2 = "Carga N.U.INY";

$Unidad3 = "TMS";
$Descripcion3 = "Circulante";

$Unidad4 = "Hrs";
$Descripcion4 = "Tiempo Soplado";

$Unidad5 = "Hrs";
$Descripcion5 = "Tpo. Soplado c/Iny";

$Unidad6 = "F/S";
$Descripcion6 = "Carga Total";

$Unidad7 = "Ollas";
$Descripcion7 = "Metal Blanco";

$Unidad8 = "%";
$Descripcion8 = "Leyes CU M. Blanco";

$Unidad9 = "TMH";
$Descripcion9 = "Alimentacion Secado";

$Unidad10 = "F/S";
$Descripcion10 = "Alimentacion Secado";

$Unidad11 = "Hrs";
$Descripcion11 = "Tpo. Soplado";

$Unidad12 = "TMS";
$Descripcion12 = "Carga Fria (S/PRECIPITADO)";

$Unidad13 = "TMS";
$Descripcion13 = "Precipitado";

$Unidad14 = "D";
$Descripcion14 = "N�mero Cargas C_1";

$Unidad15 = "AC";
$Descripcion15 = "N�mero Cargas C_1";

$Unidad16 = "F/S";
$Descripcion16 = "Carga Fria (S/PRECIPITADO)";

$Unidad17 = "F/S";
$Descripcion17 = "N�mero Cargas C_1";

$Unidad18 = "D";
$Descripcion18 = "N�mero Cargas C_2";

$Unidad19 = "AC";
$Descripcion19 = "N�mero Cargas C_2";

$Unidad20 = "D";
$Descripcion20 = "N�mero Cargas C_3";

$Unidad21 = "AC";
$Descripcion21 = "N�mero Cargas C_3";

$Unidad22 = "t/d";
$Descripcion22 = "Blister Total Trasp.";

$Unidad23 = "F/S";
$Descripcion23 = "N�mero Cargas C_2";

$Unidad24 = "F/S";
$Descripcion24 = "N�mero Cargas C_3";

$Unidad25 = "Ollas";
$Descripcion25 = "Escoria CT Tratada";

$Unidad26 = "T/d�a";
$Descripcion26 = "Circulante";

$Unidad27 = "Ollas";
$Descripcion27 = "Metal Blanco";

$Unidad28 = "%";
$Descripcion28 = "Ley CU Metal Blanco";

$Unidad29 = "%";
$Descripcion29 = "Ley CU Escoria";

$Unidad30 = "%";
$Descripcion30 = "Ley Fe3o4 Escoria";

$Unidad31 = "Ollas";
$Descripcion31 = "Ollas MB a Pozo";

$Unidad32 = "Ollas";
$Descripcion32 = "Ollas Oxido a CT";

$Unidad33 = "Ollas";
$Descripcion33 = "Ollas ox. CPS. a Pozo";

$Unidad34 = "Ollas";
$Descripcion34 = "Ollas Fund.+ Raf a Pozo";

$Unidad35 = "Ollas";
$Descripcion35 = "Escoria CT";

$Unidad36 = "Ollas";
$Descripcion36 = "Escoria HETE";

$Unidad37 = "Ollas";
$Descripcion37 = "Scrap";

$Unidad38 = "Ollas";
$Descripcion38 = "Tonelaje Scrap";


$Fecha =$ano."-".$mes."-".$dia;

$Modificar = "UPDATE fundicion SET Fecha='$Fecha', Rut='$CookieUsuario', Nombre='$CookieNombreUsuario', Cod_Tipo='$Cod_Tipo', Seccion='$Seccion', Campo1='$Campo1', Unidad1='$Unidad1', Descripcion1='$Descripcion1', Campo2='$Campo2', Unidad2='$Unidad2', Descripcion2='$Descripcion2', Campo3='$Campo3', Unidad3='$Unidad3', Descripcion3='$Descripcion3', Campo4='".str_replace(",",".",$Campo4)."', Unidad4='$Unidad4', Descripcion4='$Descripcion4', Campo5='$Campo5', Unidad5='$Unidad5', Descripcion5='$Descripcion5', Campo6='$Campo6', Unidad6='$Unidad6', Descripcion6='$Descripcion6', Campo7='$Campo7', Unidad7='$Unidad7', Descripcion7='$Descripcion7', Campo8='$Campo8', Unidad8='$Unidad8', Descripcion8='$Descripcion8', Campo9='$Campo9', Unidad9='$Unidad9', Descripcion9='$Descripcion9', Campo10='$Campo10', Unidad10='$Unidad10', Descripcion10='$Descripcion10', Campo11='$Campo11', Unidad11='$Unidad11', Descripcion11='$Descripcion11', Campo12='$Campo12', Unidad12='$Unidad12', Descripcion12='$Descripcion12', Campo13='$Campo13', Unidad13='$Unidad13', Descripcion13='$Descripcion13', Campo14='$Campo14', Unidad14='$Unidad14', Descripcion14='$Descripcion14', Campo15='$Campo15', Unidad15='$Unidad15', Descripcion15='$Descripcion15', Campo16='$Campo16', Unidad16='$Unidad16', Descripcion16='$Descripcion16', Campo17='$Campo17', Unidad17='$Unidad17', Descripcion17='$Descripcion17', Campo18='$Campo18', Unidad18='$Unidad18', Descripcion18='$Descripcion18', Campo19='$Campo19', Unidad19='$Unidad19', Descripcion19='$Descripcion19', Campo20='$Campo20', Unidad20='$Unidad20', Descripcion20='$Descripcion20', Campo21='$Campo21', Unidad21='$Unidad21', Descripcion21='$Descripcion21', Campo22='$Campo22', Unidad22='$Unidad22', Descripcion22='$Descripcion22', Campo23='$Campo23', Unidad23='$Unidad23', Descripcion23='$Descripcion23', Campo24='$Campo24', Unidad24='$Unidad24', Descripcion24='$Descripcion24', Campo25='$Campo25', Unidad25='$Unidad25', Descripcion25='$Descripcion25', Campo26='$Campo26', Unidad26='$Unidad26', Descripcion26='$Descripcion26', Campo27='$Campo27', Unidad27='$Unidad27', Descripcion27='$Descripcion27', Campo28='$Campo28', Unidad28='$Unidad28', Descripcion28='$Descripcion28', Campo29='$Campo29', Unidad29='$Unidad29', Descripcion29='$Descripcion29', Campo30='$Campo30', Unidad30='$Unidad30', Descripcion30='$Descripcion30', Campo31='$Campo31', Unidad31='$Unidad31', Descripcion31='$Descripcion31', Campo32='$Campo32', Unidad32='$Unidad32', Descripcion32='$Descripcion32', Campo33='$Campo33', Unidad33='$Unidad33', Descripcion33='$Descripcion33', Campo34='$Campo34', Unidad34='$Unidad34', Descripcion34='$Descripcion34', Campo35='$Campo35', Unidad35='$Unidad35', Descripcion35='$Descripcion35', Campo36='$Campo36', Unidad36='$Unidad36', Descripcion36='$Descripcion36',Campo37='$Campo37', Unidad37='$Unidad37', Descripcion37='$Descripcion37', Campo38='$Campo38', Unidad38='$Unidad38', Descripcion38='$Descripcion38'    WHERE Fecha='$Fecha' and Cod_Tipo='$CookieTipoUsuario' ";

mysql_query($Modificar);

 include("cerrar.php");
 header("location:Fundicion.php");

?>

