<?php
	include("../principal/conectar_principal.php");
		$SQL="alter table proyecto_modernizacion.leyes add Homologacion_ley_GD varchar(20) DEFAULT NULL;";
		mysqli_query($link, $SQL);
				

?>
