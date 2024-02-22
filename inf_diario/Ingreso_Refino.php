<?
  include("conectar.php");
  
$Fecha =$ano."-".$mes."-".$dia;

$Cod_Tipo ="2" ;

$sql = "SELECT Fecha, Cod_Tipo FROM fundicion WHERE Fecha = '$Fecha' and Cod_Tipo = '$Cod_Tipo'";
$result = mysql_query($sql, $link);

 if ($row = mysql_fetch_array($result))
 {
$Cod_Tipo = "2";
$Seccion = "2";

$Unidad1 = "T/Ds";
$Descripcion1 = "Caldera Raf-1";

$Unidad2 = "T/Ds";
$Descripcion2 = "Caldera Raf-2";

$Unidad3 = "F/S";
$Descripcion3 = "Caldera Raf-1";

$Unidad4 = "F/S";
$Descripcion4 = "Caldera Raf-2";

$Unidad5 = "Hornad/Sol";
$Descripcion5 = "Horno 1";

$Unidad6 = "Hornad/Sol";
$Descripcion6 = "Horno 2";

$Unidad7 = "Hornad/Sol";
$Descripcion7 = "H. basculante";

$Unidad8 = "Hornad/Sol";
$Descripcion8 = "H. basculante";

$Unidad9 = "Prog. Hrs.";
$Descripcion9 = "Horno 1";

$Unidad10 = "Prog. Hrs.";
$Descripcion10 = "Horno 2";

$Unidad11 = "Prog. Hrs.";
$Descripcion11 = "H. Basculante";

$Unidad12 = "Prog. Hrs.";
$Descripcion12 = "H. Basculante";

$Unidad13 = "Real Hrs.";
$Descripcion13 = "Horno 1";

$Unidad14 = "Real Hrs.";
$Descripcion14 = "Horno 2";

$Unidad15 = "Real Hrs.";
$Descripcion15 = "H. Basculante";

$Unidad16 = "Real Hrs.";
$Descripcion16 = "H. Basculante";

$Unidad17 = "Retraso Hrs.";
$Descripcion17 = "Horno 1";

$Unidad18 = "Retraso Hrs.";
$Descripcion18 = "Horno 2";

$Unidad19 = "Retraso Hrs.";
$Descripcion19 = "H. Basculante";

$Unidad20 = "Retraso Hrs.";
$Descripcion20 = "H. Basculante 2";

$Unidad21 = "As";
$Descripcion21 = "Horno 1";

$Unidad22 = "As";
$Descripcion22 = "Horno 2";

$Unidad23 = "As";
$Descripcion23 = "H. Basculante";

$Unidad24 = "As";
$Descripcion24 = "H. Basculante 2";

$Unidad25 = "Sb";
$Descripcion25 = "Horno 1";

$Unidad26 = "Sb";
$Descripcion26 = "Horno 2";

$Unidad27 = "Sb";
$Descripcion27 = "H. Basculante";

$Unidad28 = "Sb";
$Descripcion28 = "H. Basculante 2";

$Unidad29 = "Ollas";
$Descripcion29 = "Ollas Escoria Horno Retencion";

$Unidad30 = "Ollas";
$Descripcion30 = "Ollas Escoria Horno Basculante";

$Unidad31 = "Ollas";
$Descripcion31 = "H.Retén";
$Unidad32 = "Ollas";
$Descripcion32 = "H.Basculante";
$Unidad33 = "Ton.";
$Descripcion33 = "Horno1";
$Unidad34 = "Ton.";
$Descripcion34 = "Horno2";
$Unidad35 = "Ton.";
$Descripcion35 = "Blister,Restos y Rechazos";

$Modificar = "UPDATE fundicion SET Fecha='$Fecha', Rut='$CookieUsuario', Nombre='$CookieNombreUsuario', Cod_Tipo='$Cod_Tipo', Seccion='$Seccion', Campo1='$Campo1', Unidad1='$Unidad1', Descripcion1='$Descripcion1', Campo2='$Campo2', Unidad2='$Unidad2', Descripcion2='$Descripcion2', Campo3='$Campo3', Unidad3='$Unidad3', Descripcion3='$Descripcion3', Campo4='$Campo4', Unidad4='$Unidad4', Descripcion4='$Descripcion4', Campo5='$Campo5', Unidad5='$Unidad5', Descripcion5='$Descripcion5', Campo6='$Campo6', Unidad6='$Unidad6', Descripcion6='$Descripcion6', Campo7='$Campo7', Unidad7='$Unidad7', Descripcion7='$Descripcion7', Campo8='$Campo8', Unidad8='$Unidad8', Descripcion8='$Descripcion8', Campo9='$Campo9', Unidad9='$Unidad9', Descripcion9='$Descripcion9', Campo10='$Campo10', Unidad10='$Unidad10', Descripcion10='$Descripcion10', Campo11='$Campo11', Unidad11='$Unidad11', Descripcion11='$Descripcion11', Campo12='$Campo12', Unidad12='$Unidad12', Descripcion12='$Descripcion12', Campo13='$Campo13', Unidad13='$Unidad13', Descripcion13='$Descripcion13', Campo14='$Campo14', Unidad14='$Unidad14', Descripcion14='$Descripcion14', Campo15='$Campo15', Unidad15='$Unidad15', Descripcion15='$Descripcion15', Campo16='$Campo16', Unidad16='$Unidad16', Descripcion16='$Descripcion16', Campo17='$Campo17', Unidad17='$Unidad17', Descripcion17='$Descripcion17', Campo18='$Campo18', Unidad18='$Unidad18', Descripcion18='$Descripcion18', Campo19='$Campo19', Unidad19='$Unidad19', Descripcion19='$Descripcion19', Campo20='$Campo20', Unidad20='$Unidad20', Descripcion20='$Descripcion20', Campo21='$Campo21', Unidad21='$Unidad21', Descripcion21='$Descripcion21', Campo22='$Campo22', Unidad22='$Unidad22', Descripcion22='$Descripcion22', Campo23='$Campo23', Unidad23='$Unidad23', Descripcion23='$Descripcion23', Campo24='$Campo24', Unidad24='$Unidad24', Descripcion24='$Descripcion24', Campo25='$Campo25', Unidad25='$Unidad25', Descripcion25='$Descripcion25', Campo26='$Campo26', Unidad26='$Unidad26', Descripcion26='$Descripcion26', Campo27='$Campo27', Unidad27='$Unidad27', Descripcion27='$Descripcion27', Campo28='$Campo28', Unidad28='$Unidad28', Descripcion28='$Descripcion28', Campo29='$Campo29', Unidad29='$Unidad29', Descripcion29='$Descripcion29', Campo30='$Campo30', Unidad30='$Unidad30', Descripcion30='$Descripcion30', Campo31='$Campo31', Unidad31='$Unidad31', Descripcion31='$Descripcion31', Campo32='$Campo32', Unidad32='$Unidad32', Descripcion32='$Descripcion32', Campo33='$Campo33', Unidad33='$Unidad33', Descripcion33='$Descripcion33', Campo34='$Campo34', Unidad34='$Unidad34', Descripcion34='$Descripcion34', Campo35='$Campo35', Unidad35='$Unidad35', Descripcion35='$Descripcion35' WHERE Fecha='$Fecha' and Cod_Tipo='$CookieTipoUsuario'  ";
//echo $Modificar;
mysql_query($Modificar);
header("location:Refino.php");

 }
 else 
  {
$Cod_Tipo = "2";
$Seccion = "2";

$Unidad1 = "T/Ds";
$Descripcion1 = "Caldera Raf-1";

$Unidad2 = "T/Ds";
$Descripcion2 = "Caldera Raf-2";

$Unidad3 = "F/S";
$Descripcion3 = "Caldera Raf-1";

$Unidad4 = "F/S";
$Descripcion4 = "Caldera Raf-2";

$Unidad5 = "Hornad/Sol";
$Descripcion5 = "Horno 1";

$Unidad6 = "Hornad/Sol";
$Descripcion6 = "Horno 2";

$Unidad7 = "Hornad/Sol";
$Descripcion7 = "H. basculante";

$Unidad8 = "Hornad/Sol";
$Descripcion8 = "H. basculante";

$Unidad9 = "Prog. Hrs.";
$Descripcion9 = "Horno 1";

$Unidad10 = "Prog. Hrs.";
$Descripcion10 = "Horno 2";

$Unidad11 = "Prog. Hrs.";
$Descripcion11 = "H. Basculante";

$Unidad12 = "Prog. Hrs.";
$Descripcion12 = "H. Basculante";

$Unidad13 = "Real Hrs.";
$Descripcion13 = "Horno 1";

$Unidad14 = "Real Hrs.";
$Descripcion14 = "Horno 2";

$Unidad15 = "Real Hrs.";
$Descripcion15 = "H. Basculante";

$Unidad16 = "Real Hrs.";
$Descripcion16 = "H. Basculante";

$Unidad17 = "Retraso Hrs.";
$Descripcion17 = "Horno 1";

$Unidad18 = "Retraso Hrs.";
$Descripcion18 = "Horno 2";

$Unidad19 = "Retraso Hrs.";
$Descripcion19 = "H. Basculante";

$Unidad20 = "Retraso Hrs.";
$Descripcion20 = "H. Basculante 2";

$Unidad21 = "As";
$Descripcion21 = "Horno 1";

$Unidad22 = "As";
$Descripcion22 = "Horno 2";

$Unidad23 = "As";
$Descripcion23 = "H. Basculante";

$Unidad24 = "As";
$Descripcion24 = "H. Basculante 2";

$Unidad25 = "Sb";
$Descripcion25 = "Horno 1";

$Unidad26 = "Sb";
$Descripcion26 = "Horno 2";

$Unidad27 = "Sb";
$Descripcion27 = "H. Basculante";

$Unidad28 = "Sb";
$Descripcion28 = "H. Basculante 2";

$Unidad29 = "Ollas";
$Descripcion29 = "Ollas Escoria Horno Retencion";

$Unidad30 = "Ollas";
$Descripcion30 = "Ollas Escoria Horno Basculante";

$Unidad31 = "Ollas";
$Descripcion31 = "H.Retén";
$Unidad32 = "Ollas";
$Descripcion32 = "H.Basculante";
$Unidad33 = "Ton.";
$Descripcion33 = "Horno1";
$Unidad34 = "Ton.";
$Descripcion34 = "Horno2";
$Unidad35 = "Ton.";
$Descripcion35 = "Blister,Restos y Rechazos";

$Fecha =$ano."-".$mes."-".$dia;


$Insertar = "INSERT INTO fundicion";
$Insertar = "$Insertar (Fecha, Rut, Nombre, Cod_Tipo, Seccion, Campo1, Unidad1, Descripcion1, Campo2, Unidad2, Descripcion2, Campo3, Unidad3, Descripcion3,Campo4, Unidad4, Descripcion4, Campo5, Unidad5, Descripcion5, Campo6, Unidad6, Descripcion6, Campo7, Unidad7, Descripcion7, Campo8, Unidad8, Descripcion8, Campo9, Unidad9, Descripcion9,Campo10, Unidad10, Descripcion10, Campo11, Unidad11, Descripcion11, Campo12, Unidad12, Descripcion12, Campo13, Unidad13, Descripcion13, Campo14, Unidad14, Descripcion14, Campo15, Unidad15, Descripcion15, Campo16, Unidad16, Descripcion16, Campo17, Unidad17, Descripcion17, Campo18, Unidad18, Descripcion18, Campo19, Unidad19, Descripcion19, Campo20, Unidad20, Descripcion20, Campo21, Unidad21, Descripcion21, Campo22, Unidad22, Descripcion22, Campo23, Unidad23, Descripcion23, Campo24, Unidad24, Descripcion24, Campo25, Unidad25, Descripcion25, Campo26, Unidad26, Descripcion26, Campo27, Unidad27, Descripcion27, Campo28, Unidad28, Descripcion28, Campo29, Unidad29, Descripcion29, Campo30, Unidad30, Descripcion30, Campo31, Unidad31, Descripcion31, Campo32, Unidad32, Descripcion32, Campo33, Unidad33, Descripcion33, Campo34, Unidad34, Descripcion34, Campo35, Unidad35, Descripcion35)";

$Insertar = "$Insertar VALUES ('$Fecha', '$CookieUsuario', '$CookieNombreUsuario', '$Cod_Tipo', '$Seccion', '$Campo1', '$Unidad1', '$Descripcion1', '$Campo2', '$Unidad2', '$Descripcion2', '$Campo3', '$Unidad3', '$Descripcion3', '$Campo4', '$Unidad4', '$Descripcion4', '$Campo5', '$Unidad5', '$Descripcion5', '$Campo6', '$Unidad6', '$Descripcion6', '$Campo7', '$Unidad7', '$Descripcion7', '$Campo8', '$Unidad8', '$Descripcion8', '$Campo9', '$Unidad9', '$Descripcion9', '$Campo10', '$Unidad10', '$Descripcion10', '$Campo11', '$Unidad11', '$Descripcion11', '$Campo12', '$Unidad12', '$Descripcion12', '$Campo13', '$Unidad13', '$Descripcion13', '$Campo14', '$Unidad14', '$Descripcion14', '$Campo15', '$Unidad15', '$Descripcion15', '$Campo16', '$Unidad16', '$Descripcion16', '$Campo17', '$Unidad17', '$Descripcion17', '$Campo18', '$Unidad18', '$Descripcion18', '$Campo19', '$Unidad19', '$Descripcion19', '$Campo20', '$Unidad20', '$Descripcion20', '$Campo21', '$Unidad21', '$Descripcion21', '$Campo22', '$Unidad22', '$Descripcion22', '$Campo23', '$Unidad23', '$Descripcion23', '$Campo24', '$Unidad24', '$Descripcion24', '$Campo25', '$Unidad25', '$Descripcion25', '$Campo26', '$Unidad26', '$Descripcion26', '$Campo27', '$Unidad27', '$Descripcion27', '$Campo28', '$Unidad28', '$Descripcion28', '$Campo29', '$Unidad29', '$Descripcion29', '$Campo30', '$Unidad30', '$Descripcion30', '$Campo31', '$Unidad31', '$Descripcion31', '$Campo32', '$Unidad32', '$Descripcion32', '$Campo33', '$Unidad33', '$Descripcion33', '$Campo34', '$Unidad34', '$Descripcion34', '$Campo35', '$Unidad35', '$Descripcion35')";

mysql_query($Insertar);
include("cerrar.php");
header("location:Refino.php");
}   

?>   