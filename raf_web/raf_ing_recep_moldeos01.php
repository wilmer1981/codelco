<?
include("../principal/conectar_raf_web.php");

if($Proceso == "G")
{	
	if($hornada1 == '')
	   $hornada1 = 0;		

	if($ton_proy1 == '')
		$ton_proy1 = 0;

	if($hornada2 == '')
	   $hornada2 = 0;		

	if($ton_proy2 == '')
		$ton_proy2 = 0;

	if($hornada3 == '')
	   $hornada3 = 0;		

	if($ton_proy3 == '')
		$ton_proy3 = 0;




	$Fecha = $Ano.'-'.$Mes.'-'.$Dia;	
	$Elimina = "DELETE FROM raf_web.proyeccion_moldeo WHERE fecha = '$Fecha' AND turno = '$cmbturno'";
	mysql_query($Elimina);

	$Insertar = "INSERT INTO raf_web.proyeccion_moldeo (fecha,turno,hornada1,ton_proy1,hornada2,ton_proy2,hornada3,ton_proy3,observacion)";
	$Insertar.= " VALUES('$Fecha','$cmbturno',$hornada1,$ton_proy1,$hornada2,$ton_proy2,$hornada3,$ton_proy3,'$observacion')";
	mysql_query($Insertar);

		
	$Actualiza = "UPDATE raf_web.proyeccion_moldeo set observacion = '$observacion'";
	$Actualiza.= " WHERE fecha = '$Fecha'";		
header("Location:raf_ing_recep_moldeos.php");
}

?>