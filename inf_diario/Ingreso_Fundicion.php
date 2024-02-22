<?
include("conectar.php");

$Fecha =$ano."-".$mes."-".$dia;

$Cod_Tipo="1";
$cod_tipo="";
/*poly sacar
  $CookieUsuario='06616973-1'; 
$CookieNombreUsuario = '06616973-1 POLY';
poly sacar*/

$sql = "SELECT Fecha, Cod_Tipo FROM fundicion WHERE Fecha = '$Fecha' and Cod_Tipo = '$Cod_Tipo'";
$result = mysql_query($sql, $link);

 if ($row = mysql_fetch_array($result))
 {
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
$Descripcion14 = "Número Cargas C_1";

$Unidad15 = "AC";
$Descripcion15 = "Número Cargas C_1";

$Unidad16 = "F/S";
$Descripcion16 = "Carga Fria (S/PRECIPITADO)";

$Unidad17 = "F/S";
$Descripcion17 = "Número Cargas C_1";

$Unidad18 = "D";
$Descripcion18 = "Número Cargas C_2";

$Unidad19 = "AC";
$Descripcion19 = "Número Cargas C_2";

$Unidad20 = "D";
$Descripcion20 = "Número Cargas C_3";

$Unidad21 = "AC";
$Descripcion21 = "Número Cargas C_3";

$Unidad22 = "t/d";
$Descripcion22 = "Blister Total Trasp.";

$Unidad23 = "F/S";
$Descripcion23 = "Número Cargas C_2";

$Unidad24 = "F/S";
$Descripcion24 = "Número Cargas C_3";

$Unidad25 = "Ollas";
$Descripcion25 = "Escoria CT Tratada";

$Unidad26 = "T/día";
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

$Unidad36 = "Ollas";
$Descripcion36 = "Escoria HETE";

$Unidad37 = "Ollas";
$Descripcion37 = "Scrap";

$Unidad38 = "T/d";
$Descripcion38 = "Tonelaje Scrap";



$Fecha =$ano."-".$mes."-".$dia;


$Modificar = "UPDATE fundicion SET Fecha='$Fecha', Rut='$CookieUsuario', Nombre='$CookieNombreUsuario', Cod_Tipo='$Cod_Tipo',";
$Modificar.= " Seccion='$Seccion', Campo1='$Campo1', Unidad1='$Unidad1', Descripcion1='$Descripcion1', Campo2='$Campo2',"; 
$Modificar.= " Unidad2='$Unidad2', Descripcion2='$Descripcion2', Campo3='$Campo3', Unidad3='$Unidad3', Descripcion3='$Descripcion3',";
$Modificar.= " Campo4='$Campo4', Unidad4='$Unidad4', Descripcion4='$Descripcion4', Campo5='$Campo5', Unidad5='$Unidad5',";
$Modificar.= " Descripcion5='$Descripcion5', Campo6='$Campo6', Unidad6='$Unidad6', Descripcion6='$Descripcion6', Campo7='$Campo7',";
$Modificar.= " Unidad7='$Unidad7', Descripcion7='$Descripcion7', Campo8='$Campo8', Unidad8='$Unidad8', Descripcion8='$Descripcion8',";
$Modificar.= " Campo9='$Campo9', Unidad9='$Unidad9', Descripcion9='$Descripcion9', Campo10='$Campo10', Unidad10='$Unidad10',";
$Modificar.= " Descripcion10='$Descripcion10', Campo11='$Campo11', Unidad11='$Unidad11', Descripcion11='$Descripcion11',"; 
$Modificar.= " Campo12='$Campo12', Unidad12='$Unidad12', Descripcion12='$Descripcion12', Campo13='$Campo13', Unidad13='$Unidad13',";
$Modificar.= " Descripcion13='$Descripcion13', Campo14='$Campo14', Unidad14='$Unidad14', Descripcion14='$Descripcion14',";
$Modificar.= " Campo15='$Campo15', Unidad15='$Unidad15', Descripcion15='$Descripcion15', Campo16='$Campo16', Unidad16='$Unidad16',";
$Modificar.= " Descripcion16='$Descripcion16', Campo17='$Campo17', Unidad17='$Unidad17', Descripcion17='$Descripcion17',";
$Modificar.= " Campo18='$Campo18', Unidad18='$Unidad18', Descripcion18='$Descripcion18', Campo19='$Campo19', Unidad19='$Unidad19',";
$Modificar.= " Descripcion19='$Descripcion19', Campo20='$Campo20', Unidad20='$Unidad20', Descripcion20='$Descripcion20',";
$Modificar.= " Campo21='$Campo21', Unidad21='$Unidad21', Descripcion21='$Descripcion21', Campo22='$Campo22', Unidad22='$Unidad22',";
$Modificar.= " Descripcion22='$Descripcion22', Campo23='$Campo23', Unidad23='$Unidad23', Descripcion23='$Descripcion23',";
$Modificar.= " Campo24='$Campo24', Unidad24='$Unidad24', Descripcion24='$Descripcion24', Campo25='$Campo25', Unidad25='$Unidad25',";
$Modificar.= " Descripcion25='$Descripcion25', Campo26='$Campo26', Unidad26='$Unidad26', Descripcion26='$Descripcion26',";
$Modificar.= " Campo27='$Campo27', Unidad27='$Unidad27', Descripcion27='$Descripcion27', Campo28='$Campo28', Unidad28='$Unidad28',";
$Modificar.= " Descripcion28='$Descripcion28', Campo29='$Campo29', Unidad29='$Unidad29', Descripcion29='$Descripcion29', ";
$Modificar.= " Campo30='$Campo30', Unidad30='$Unidad30', Descripcion30='$Descripcion30', Campo31='$Campo31', Unidad31='$Unidad31',";
$Modificar.= " Descripcion31='$Descripcion31', Campo32='$Campo32', Unidad32='$Unidad32', Descripcion32='$Descripcion32',";
$Modificar.= " Campo33='$Campo33', Unidad33='$Unidad33', Descripcion33='$Descripcion33', Campo34='$Campo34', Unidad34='$Unidad34',"; 
$Modificar.= " Descripcion34='$Descripcion34',Campo35='$Campo35', Unidad35='$Unidad35', Descripcion35='$Descripcion35',Campo36='$Campo36',";
$Modificar.= " Unidad36='$Unidad36', Descripcion36='$Descripcion36',Campo37='$Campo37', Unidad37='$Unidad37', Descripcion37='$Descripcion37,";
$Modificar.= " Campo38='$Campo38', Unidad38='$Unidad38', Descripcion38='$Descripcion38'";
$Modificar.= " WHERE Fecha='$Fecha' and Cod_Tipo='$CookieTipoUsuario'";
//echo "hola".Modificar;
mysql_query($Modificar);
include("cerrar.php");
header("location:Fundicion.php");
 }
 else 
  {

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
$Descripcion14 = "Número Cargas C_1";

$Unidad15 = "AC";
$Descripcion15 = "Número Cargas C_1";

$Unidad16 = "F/S";
$Descripcion16 = "Carga Fria (S/PRECIPITADO)";

$Unidad17 = "F/S";
$Descripcion17 = "Número Cargas C_1";

$Unidad18 = "D";
$Descripcion18 = "Número Cargas C_2";

$Unidad19 = "AC";
$Descripcion19 = "Número Cargas C_2";

$Unidad20 = "D";
$Descripcion20 = "Número Cargas C_3";

$Unidad21 = "AC";
$Descripcion21 = "Número Cargas C_3";

$Unidad22 = "t/d";
$Descripcion22 = "Blister Total Trasp.";

$Unidad23 = "F/S";
$Descripcion23 = "Número Cargas C_2";

$Unidad24 = "F/S";
$Descripcion24 = "Número Cargas C_3";

$Unidad25 = "Ollas";
$Descripcion25 = "Escoria CT Tratada";

$Unidad26 = "T/día";
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

$Unidad38 = "T/d";
$Descripcion38 = "Tonelaje Scrap";



$Fecha =$ano."-".$mes."-".$dia;


$Insertar = "INSERT INTO fundicion";
$Insertar.= " (Fecha, Rut, Nombre, Cod_Tipo, Seccion, Campo1, Unidad1, Descripcion1, Campo2, Unidad2, Descripcion2, Campo3,";
$Insertar.= " Unidad3, Descripcion3,Campo4, Unidad4, Descripcion4, Campo5, Unidad5, Descripcion5, Campo6, Unidad6, Descripcion6,";
$Insertar.= " Campo7, Unidad7, Descripcion7, Campo8, Unidad8, Descripcion8, Campo9, Unidad9, Descripcion9,Campo10, Unidad10,";
$Insertar.= " Descripcion10, Campo11, Unidad11, Descripcion11, Campo12, Unidad12, Descripcion12, Campo13, Unidad13, Descripcion13,";
$Insertar.= " Campo14, Unidad14, Descripcion14, Campo15, Unidad15, Descripcion15, Campo16, Unidad16, Descripcion16, Campo17, Unidad17,";
$Insertar.= " Descripcion17, Campo18, Unidad18, Descripcion18, Campo19, Unidad19, Descripcion19, Campo20, Unidad20, Descripcion20,";
$Insertar.= " Campo21, Unidad21, Descripcion21, Campo22, Unidad22, Descripcion22, Campo23, Unidad23, Descripcion23, Campo24, Unidad24,";
$Insertar.= " Descripcion24, Campo25, Unidad25, Descripcion25, Campo26, Unidad26, Descripcion26, Campo27, Unidad27, Descripcion27,";
$Insertar.= " Campo28, Unidad28, Descripcion28, Campo29, Unidad29, Descripcion29, Campo30, Unidad30, Descripcion30, Campo31, Unidad31,";
$Insertar.= " Descripcion31, Campo32, Unidad32, Descripcion32, Campo33, Unidad33, Descripcion33, Campo34, Unidad34, Descripcion34,";
$Insertar.= " Campo35, Unidad35, Descripcion35, Campo36, Unidad36, Descripcion36, Campo37, Unidad37, Descripcion37, Campo38, Unidad38,";
$Insertar.= " Descripcion38)"; 
$Insertar.= " VALUES ('$Fecha', '$CookieUsuario', '$CookieNombreUsuario', '$Cod_Tipo', '$Seccion', '$Campo1', '$Unidad1',";
$Insertar.= " '$Descripcion1', '$Campo2', '$Unidad2', '$Descripcion2', '$Campo3', '$Unidad3', '$Descripcion3', '$Campo4', '$Unidad4',";
$Insertar.= " '$Descripcion4', '$Campo5', '$Unidad5', '$Descripcion5', '$Campo6', '$Unidad6', '$Descripcion6', '$Campo7', '$Unidad7',";
$Insertar.= " '$Descripcion7', '$Campo8', '$Unidad8', '$Descripcion8', '$Campo9', '$Unidad9', '$Descripcion9', '$Campo10', '$Unidad10',";
$Insertar.= " '$Descripcion10', '$Campo11', '$Unidad11', '$Descripcion11', '$Campo12', '$Unidad12', '$Descripcion12', '$Campo13',";
$Insertar.= " '$Unidad13', '$Descripcion13', '$Campo14', '$Unidad14', '$Descripcion14', '$Campo15', '$Unidad15', '$Descripcion15',";
$Insertar.= " '$Campo16', '$Unidad16', '$Descripcion16', '$Campo17', '$Unidad17', '$Descripcion17', '$Campo18', '$Unidad18',";
$Insertar.= " '$Descripcion18', '$Campo19', '$Unidad19', '$Descripcion19', '$Campo20', '$Unidad20', '$Descripcion20', '$Campo21',";
$Insertar.= " '$Unidad21', '$Descripcion21', '$Campo22', '$Unidad22', '$Descripcion22', '$Campo23', '$Unidad23', '$Descripcion23',";
$Insertar.= " '$Campo24', '$Unidad24', '$Descripcion24', '$Campo25', '$Unidad25', '$Descripcion25', '$Campo26', '$Unidad26',";
$Insertar.= " '$Descripcion26', '$Campo27', '$Unidad27', '$Descripcion27', '$Campo28', '$Unidad28', '$Descripcion28', '$Campo29',";
$Insertar.= " '$Unidad29', '$Descripcion29', '$Campo30', '$Unidad30', '$Descripcion30', '$Campo31', '$Unidad31', '$Descripcion31',"; 
$Insertar.= " '$Campo32', '$Unidad32', '$Descripcion32', '$Campo33', '$Unidad33', '$Descripcion33', '$Campo34', '$Unidad34',";
$Insertar.= " '$Descripcion34', '$Campo35', '$Unidad35', '$Descripcion35', '$Campo36', '$Unidad36', '$Descripcion36', '$Campo37',";
$Insertar.= " '$Unidad37', '$Descripcion37', '$Campo38', '$Unidad38', '$Descripcion38')";

mysql_query($Insertar);
//echo "INser".$Insertar;  
include("cerrar.php");
header("location:Fundicion.php");  
}
?>
