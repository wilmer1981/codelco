<?php
	include("../principal/conectar_principal.php");
	switch($Proceso)
	{
		case "M"://MODIFICA FECHA CREACION PAQUETES CUANDO ESTEN ABIERTOS

				$Consulta="Select peso_rango from  sec_web.sec_parametro_peso";
				$rs = mysqli_query($link, $Consulta);
				if ($row = mysqli_fetch_array($rs))
				{
					$peso_anterior=$row["peso_rango"];
				}
				if(!intval($TxtPeso))
					$TxtPeso=500;
				$Actualizar="UPDATE sec_web.sec_parametro_peso set peso_rango='".$TxtPeso."',fecha='".date('Y-m-d G:i:s')."', usuario='".$CookieRut."',peso_anterior='".$peso_anterior."' ";
				mysqli_query($link, $Actualizar);
			header("Location:sec_modificar_peso.php?Msj=1");
		break;
	}
?>