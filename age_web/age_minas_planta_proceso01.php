<?php
	include("../principal/conectar_principal.php");
	
	switch ($Proceso)
	{
		case "N"://NUEVA MINA/PLANTA
			$Insertar="insert into sipa_web.minaprv (rut_prv,cod_mina,nombre_mina,ind_faena,sierra,comuna,fecha_padron) values (";
			$Insertar.="'$CmbProveedor','$TxtCodMina','$TxtDescripcion','$CmbTipoFaena','$TxtSierra','$TxtComuna','$TxtFecha')";
			echo $Insertar;
			//mysqli_query($link, $Insertar);
			break;
		case "M"://MODIFICAR MINA/PLANTA
			$Modificar="UPDATE age_web.mina set nombre_mina='$TxtDescripcion',,sierra='$TxtSierra', ";
			$Modificar.="comuna='$TxtComuna',provincia='$TxtProvincia',rut_propietario='$TxtRutPropiet',tipo_faena='$CmbTipoFaena' ";
			$Modificar.="where rut_prv='$CmbProveedor' and cod_mina='$TxtCodMina'";
			mysqli_query($link, $Modificar);
			break;
		case "E"://ELIMINAR MINA/PLANTA
			$Eliminar ="delete from age_web.mina where cod_faena='$TxtCodFaena'";
			mysqli_query($link, $Eliminar);
			break;
	}
	//header("location:age_minas_proceso.php?Recarga=S&CmbMina=".$TxtCodFaena);
?>