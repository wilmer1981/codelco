<?
include("conectar.php");
/**********************************DATOS_TRABAJADOR*********************************/  

if(($opcion == "gf")&&($rut_dv)){

  /*******Guardar Licencias*********/
   while(list($clave,$valor) = each($desde_lic)){
	  $cadena = explode("/", $desde_lic[$clave]); // Poner fecha "desde_lic" en formato BBDD.
	  $desde_lic[$clave] = $cadena[2]."-".$cadena[1]."-".$cadena[0];
	  
  	  $cadena = explode("/", $hasta_lic[$clave]); // Poner fecha "hasta_lic" en formato BBDD.
	  $hasta_lic[$clave] = $cadena[2]."-".$cadena[1]."-".$cadena[0];

	  $pagado_lic[$clave] = str_replace('.','', $pagado_lic[$clave]); // Elimina puntos a los miles	
	//  $insertar="INSERT INTO subs_web.licencias (rut,desde,hasta,dias,valor) values ('".$rut_dv."','".$desde_lic[$clave]."','".$hasta_lic[$clave]."','".$dias_lic[$clave]."','".$pagado_lic[$clave]."')";
	  $consulta = mysql_query($insertar);

	}
  /*******Fin Guardar Licencias*****/	
}
?>