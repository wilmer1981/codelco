<?php
include("../principal/conectar_raf_web.php");

if($Proceso == "G")
{	

	$Fecha = $Ano.'-'.$Mes.'-'.$Dia;	
	$Elimina = "DELETE FROM sea_web.renovacion_grupos WHERE fecha = '$Fecha' AND turno = '$cmbturno'";
	mysqli_query($link, $Elimina);

	$Insertar = "INSERT INTO sea_web.renovacion_grupos (fecha,turno,grupo1,producto1,grupo2,producto2,grupo3,producto3)";
	$Insertar.= " VALUES('$Fecha','$cmbturno',$grupo1,'$cmbproducto1',$grupo2,'$cmbproducto2','$grupo3','$cmbproducto3')";
	mysqli_query($link, $Insertar);
	
	header("Location:sea_ing_renov_grupos.php");
}

?>