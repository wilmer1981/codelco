<?php
	include("../principal/conectar_principal.php");
	
	switch ($Proceso)
	{
		case "N"://NUEVA MINA
			$Insertar="insert into age_web.mina () values (";
			$Insertar.="'$TxtCodFaena','$TxtDescripcion','$TxtCodMina','$TxtSierra','$TxtComuna','$TxtProvincia','$TxtRutPropiet','$CmbTipoFaena')";
			mysqli_query($link, $Insertar);
			break;
		case "M"://MODIFICAR MINA
			$Modificar="UPDATE age_web.mina set descripcion='$TxtDescripcion',cod_mina='$TxtCodMina',sierra='$TxtSierra', ";
			$Modificar.="comuna='$TxtComuna',provincia='$TxtProvincia',rut_propietario='$TxtRutPropiet',tipo_faena='$CmbTipoFaena' where cod_faena='$TxtCodFaena'";
			mysqli_query($link, $Modificar);
			break;
		case "E"://ELIMINAR MINA
			$Eliminar ="delete from age_web.mina where cod_faena='$TxtCodFaena'";
			mysqli_query($link, $Eliminar);
			break;
	}
	header("location:age_minas_proceso.php?Recarga=S&CmbMina=".$TxtCodFaena);
?>