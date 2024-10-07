<?php
include("../principal/conectar_cal_web.php");
$CookieRut=$_COOKIE["CookieRut"];
$Rut=$CookieRut;

	$Sol = isset($_REQUEST["Sol"])?$_REQUEST["Sol"]:"";
	$Rec = isset($_REQUEST["Rec"])?$_REQUEST["Rec"]:"";
	$ValoresLeyes = isset($_REQUEST["ValoresLeyes"])?$_REQUEST["ValoresLeyes"]:"";
	$ValoresImpurezas = isset($_REQUEST["ValoresImpurezas"])?$_REQUEST["ValoresImpurezas"]:"";
	$ValoresLeyesFisicas = isset($_REQUEST["ValoresLeyesFisicas"])?$_REQUEST["ValoresLeyesFisicas"]:"";
	$Opcion = isset($_REQUEST["Opcion"])?$_REQUEST["Opcion"]:"";
	
if ($Rec == 'N')
{
	$Consulta="select nro_solicitud,cod_producto,cod_subproducto,fecha_hora,id_muestra,rut_funcionario from cal_web.solicitud_analisis where nro_solicitud ='".$Sol."'"; 
	$Respuesta = mysqli_query($link, $Consulta);
	$Fila=mysqli_fetch_array($Respuesta);
	$Eliminar="delete from cal_web.leyes_por_solicitud where  nro_solicitud='".$Sol."' and isnull(valor)";
	mysqli_query($link, $Eliminar);
	$Leyes = $ValoresLeyes;
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
					$Insertar = "INSERT IGNORE INTO cal_web.leyes_por_solicitud (rut_funcionario,fecha_hora,nro_solicitud,cod_leyes,cod_unidad,cod_producto,cod_subproducto,id_muestra) values ('";
					$Insertar = $Insertar.$Fila["rut_funcionario"]."','";
					$Insertar = $Insertar.$Fila["fecha_hora"]."',";
					$Insertar = $Insertar.$Sol.",'";
					$Insertar = $Insertar.$Ley."','";
					$Insertar = $Insertar.$Unidad."','";
					$Insertar = $Insertar.$Fila["cod_producto"]."','";
					$Insertar = $Insertar.$Fila["cod_subproducto"]."','";
					$Insertar = $Insertar.$Fila["id_muestra"]."')";
					mysqli_query($link, $Insertar);
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
					$Insertar = "INSERT IGNORE INTO cal_web.leyes_por_solicitud (rut_funcionario,fecha_hora,nro_solicitud,cod_leyes,cod_unidad,cod_producto,cod_subproducto,id_muestra) values ('";
					$Insertar = $Insertar.$Fila["rut_funcionario"]."','";
					$Insertar = $Insertar.$Fila["fecha_hora"]."',";
					$Insertar = $Insertar.$Sol.",'";
					$Insertar = $Insertar.$Impureza."','";
					$Insertar = $Insertar.$Unidad."','";
					$Insertar = $Insertar.$Fila["cod_producto"]."','";
					$Insertar = $Insertar.$Fila["cod_subproducto"]."','";
					$Insertar = $Insertar.$Fila["id_muestra"]."')";
					mysqli_query($link, $Insertar);
				}
			}
		$Impurezas = substr($Impurezas,$k + 2);
		$k = 0;
		}
	}
	$LeyesFisicas=$ValoresLeyesFisicas;		
	for ($k = 0;$k <= strlen($LeyesFisicas); $k++)
	{
		if (substr($LeyesFisicas,$k,2) == "//")
		{
			$FisicaUnidades = substr($LeyesFisicas,0,$k);
			for ($f=0;$f<=strlen($FisicaUnidades);$f++)
			{
				if (substr($FisicaUnidades,$f,2) == "~~")
				{
					$Fisica = substr($FisicaUnidades,0,$f);			
					$Unidad = substr($FisicaUnidades,$f+2,strlen($FisicaUnidades));
					$Insertar = "INSERT IGNORE INTO cal_web.leyes_por_solicitud (rut_funcionario,fecha_hora,nro_solicitud,cod_leyes,cod_unidad,cod_producto,cod_subproducto,id_muestra) values ('";
					$Insertar = $Insertar.$Fila["rut_funcionario"]."','";
					$Insertar = $Insertar.$Fila["fecha_hora"]."',";
					$Insertar = $Insertar.$Sol.",'";
					$Insertar = $Insertar.$Fisica."','";
					$Insertar = $Insertar.$Unidad."','";
					$Insertar = $Insertar.$Fila["cod_producto"]."','";
					$Insertar = $Insertar.$Fila["cod_subproducto"]."','";
					$Insertar = $Insertar.$Fila["id_muestra"]."')";
					mysqli_query($link, $Insertar);
				}
			}
		$LeyesFisicas = substr($LeyesFisicas,$k + 2);
		$k = 0;
		}
	}
	$Actualiza="update solicitud_analisis set leyes ='".$ValoresLeyes.$ValoresLeyesFisicas."',impurezas='".$ValoresImpurezas."' where nro_solicitud='".$Sol."'"; 
	mysqli_query($link, $Actualiza);
}
else//con recargo
{
	$Consulta="select nro_solicitud,cod_producto,cod_subproducto,fecha_hora,id_muestra,rut_funcionario from cal_web.solicitud_analisis where nro_solicitud ='".$Sol."' and recargo = '".$Rec."'"; 
	$Respuesta = mysqli_query($link, $Consulta);
	$Fila=mysqli_fetch_array($Respuesta);
	$Eliminar="delete from cal_web.leyes_por_solicitud where  nro_solicitud=".$Sol." and recargo = '".$Rec."' and isnull(valor)";
	mysqli_query($link, $Eliminar);
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
					$Insertar = "INSERT IGNORE INTO cal_web.leyes_por_solicitud (rut_funcionario,recargo,fecha_hora,nro_solicitud,cod_leyes,cod_unidad,cod_producto,cod_subproducto,id_muestra) values ('";
					$Insertar = $Insertar.$Fila["rut_funcionario"]."','";
					$Insertar = $Insertar.$Rec."','";
					$Insertar = $Insertar.$Fila["fecha_hora"]."',";
					$Insertar = $Insertar.$Sol.",'";
					$Insertar = $Insertar.$Ley."','";
					$Insertar = $Insertar.$Unidad."','";
					$Insertar = $Insertar.$Fila["cod_producto"]."','";
					$Insertar = $Insertar.$Fila["cod_subproducto"]."','";
					$Insertar = $Insertar.$Fila["id_muestra"]."')";
					mysqli_query($link, $Insertar);
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
					$Insertar = "insert IGNORE into cal_web.leyes_por_solicitud (rut_funcionario,recargo,fecha_hora,nro_solicitud,cod_leyes,cod_unidad,cod_producto,cod_subproducto,id_muestra) values ('";
					$Insertar = $Insertar.$Fila["rut_funcionario"]."','";
					$Insertar = $Insertar.$Rec."','";
					$Insertar = $Insertar.$Fila["fecha_hora"]."',";
					$Insertar = $Insertar.$Sol.",'";
					$Insertar = $Insertar.$Impureza."','";
					$Insertar = $Insertar.$Unidad."','";
					$Insertar = $Insertar.$Fila["cod_producto"]."','";
					$Insertar = $Insertar.$Fila["cod_subproducto"]."','";
					$Insertar = $Insertar.$Fila["id_muestra"]."')";
					mysqli_query($link, $Insertar);
				}
			}
		$Impurezas = substr($Impurezas,$k + 2);
		$k = 0;
		}
	}
	$LeyesFisicas=$ValoresLeyesFisicas;		
	for ($k = 0;$k <= strlen($LeyesFisicas); $k++)
	{
		if (substr($LeyesFisicas,$k,2) == "//")
		{
			$FisicaUnidades = substr($LeyesFisicas,0,$k);
			for ($f=0;$f<=strlen($FisicaUnidades);$f++)
			{
				if (substr($FisicaUnidades,$f,2) == "~~")
				{
					$Fisica = substr($FisicaUnidades,0,$f);			
					$Unidad = substr($FisicaUnidades,$f+2,strlen($FisicaUnidades));
					$Insertar = "insert IGNORE into cal_web.leyes_por_solicitud (rut_funcionario,recargo,fecha_hora,nro_solicitud,cod_leyes,cod_unidad,cod_producto,cod_subproducto,id_muestra) values ('";
					$Insertar = $Insertar.$Fila["rut_funcionario"]."','";
					$Insertar = $Insertar.$Rec."','";
					$Insertar = $Insertar.$Fila["fecha_hora"]."',";
					$Insertar = $Insertar.$Sol.",'";
					$Insertar = $Insertar.$Fisica."','";
					$Insertar = $Insertar.$Unidad."','";
					$Insertar = $Insertar.$Fila["cod_producto"]."','";
					$Insertar = $Insertar.$Fila["cod_subproducto"]."','";
					$Insertar = $Insertar.$Fila["id_muestra"]."')";
					mysqli_query($link, $Insertar);
				}
			}
		$LeyesFisicas = substr($LeyesFisicas,$k + 2);
		$k = 0;
		}
	}
}	
$Actualiza="update solicitud_analisis set leyes ='".$ValoresLeyes.$ValoresLeyesFisicas."',impurezas='".$ValoresImpurezas."' where nro_solicitud='".$Sol."' and recargo = '".$Rec."'"; 
mysqli_query($link, $Actualiza);
echo "<script languaje='JavaScript'>";
//echo " window.opener.document.FrmIngLeyes.action='cal_adm_ingreso_leyes.php?SolA=".$Sol."&Recargo=".$Rec."';";
//echo " window.opener.document.FrmIngLeyes.submit();";
echo "window.close();</script>";
	
?>
