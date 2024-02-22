<?php
$Rut=$CookieRut;
include("../principal/conectar_cal_web.php");
if ($Personalizar =='S')
{
	if ($CodPlantilla == "")
	{
		$Consulta = "select max(cod_plantilla) as plantilla from plantillas";
		$Respuesta = mysqli_query($link, $Consulta);
		$Fila=mysqli_fetch_array($Respuesta);
		$CodPlantilla = $Fila["plantilla"] + 1;
	}	
	$Consulta="select * from plantillas where rut_funcionario ='$Rut' and cod_plantilla=".$CodPlantilla;
	$Respuesta = mysqli_query($link, $Consulta);
	if (!$Fila=mysqli_fetch_array($Respuesta))
	{
		$Insertar = "insert into plantillas (rut_funcionario,cod_plantilla,nombre_plantilla,cod_producto,cod_subproducto,tipo_plantilla)";
		$Insertar = $Insertar." values ('$Rut','$CodPlantilla','$NombrePlantilla','$Producto','$SubProducto','P')";
		mysqli_query($link, $Insertar);		
	}
	$Leyes =$ValoresLeyes;
	for ($k = 0;$k <= strlen($Leyes); $k++)
	{
		if (substr($Leyes,$k,2) == "//")
		{
			$LeyesUnidades = substr($Leyes,0,$k);
			for ($f=0;$f<=strlen($LeyesUnidades);$f++)
			{
				if (substr($LeyesUnidades,$f,2) == "~~")
				{
					$Ley = substr($LeyesUnidades,0,$f);			
					$Unidad = substr($LeyesUnidades,$f+2,strlen($LeyesUnidades));
					$Consulta="select * from leyes_por_plantillas where rut_funcionario ='$Rut' and cod_plantilla=".$CodPlantilla." and cod_leyes='".$Ley."'";
					$Respuesta = mysqli_query($link, $Consulta);
					if (!$Fila=mysqli_fetch_array($Respuesta))
					{
						$Insertar = "insert into leyes_por_plantillas (rut_funcionario,cod_plantilla,cod_leyes,cod_unidad) values ('$Rut','$CodPlantilla','$Ley','$Unidad')";
						mysqli_query($link, $Insertar);
					}	
				}
			}
		$Leyes = substr($Leyes,$k + 2);
		$k = 0;
		}
	}
	$Impurezas=$ValoresImpurezas;		
	for ($k = 0;$k <= strlen($Impurezas); $k++)
	{
		if (substr($Impurezas,$k,2) == "//")
		{
			$ImpurezasUnidades = substr($Impurezas,0,$k);
			for ($f=0;$f<=strlen($ImpurezasUnidades);$f++)
			{
				if (substr($ImpurezasUnidades,$f,2) == "~~")
				{
					$Impureza = substr($ImpurezasUnidades,0,$f);			
					$Unidad = substr($ImpurezasUnidades,$f+2,strlen($ImpurezasUnidades));
					$Insertar = "insert into leyes_por_plantillas (rut_funcionario,cod_plantilla,cod_leyes,cod_unidad) values ('$Rut','$CodPlantilla','$Impureza','$Unidad')";
					mysqli_query($link, $Insertar);
				}
			}
		$Impurezas = substr($Impurezas,$k + 2);
		$k = 0;
		}
	}
	echo "<script languaje='JavaScript'>";
	echo " window.opener.document.FrmPersonalizar.action='cal_personalizar_plantilla.php?Plantilla=".$CodPlantilla."&NombrePlantilla=".$NombrePlantilla."';";
	echo " window.opener.document.FrmPersonalizar.submit();";
	echo "window.close();</script>";
}
	
?>
