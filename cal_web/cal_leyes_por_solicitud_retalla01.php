<?php
include("../principal/conectar_cal_web.php");

$CookieRut=$_COOKIE["CookieRut"];

$Opcion = isset($_REQUEST["Opcion"])?$_REQUEST["Opcion"]:"";
$Rec    = isset($_REQUEST["Rec"])?$_REQUEST["Rec"]:"";
$Sol    = isset($_REQUEST["Sol"])?$_REQUEST["Sol"]:"";

$ValoresLeyes        = isset($_REQUEST["ValoresLeyes"])?$_REQUEST["ValoresLeyes"]:"";
$ValoresImpurezas    = isset($_REQUEST["ValoresImpurezas"])?$_REQUEST["ValoresImpurezas"]:"";
$ValoresLeyesFisicas = isset($_REQUEST["ValoresLeyesFisicas"])?$_REQUEST["ValoresLeyesFisicas"]:"";
$Muestras            = isset($_REQUEST["Muestras"])?$_REQUEST["Muestras"]:"";
/*
$Personalizar        = isset($_REQUEST["Personalizar"])?$_REQUEST["Personalizar"]:"";
$Muestras            = isset($_REQUEST["Muestras"])?$_REQUEST["Muestras"]:"";
$Productos           = isset($_REQUEST["Productos"])?$_REQUEST["Productos"]:"";
$SubProducto         = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"";
$NombrePlantilla     = isset($_REQUEST["NombrePlantilla"])?$_REQUEST["NombrePlantilla"]:"";
$CodPlantilla        = isset($_REQUEST["CodPlantilla"])?$_REQUEST["CodPlantilla"]:"";
$Modificando         = isset($_REQUEST["Modificando"])?$_REQUEST["Modificando"]:"";
$Salir               = isset($_REQUEST["Salir"])?$_REQUEST["Salir"]:"";
$SolAut              = isset($_REQUEST["SolAut"])?$_REQUEST["SolAut"]:"";
$BuscarDetalle       = isset($_REQUEST["BuscarDetalle"])?$_REQUEST["BuscarDetalle"]:"";
$BuscarPrv           = isset($_REQUEST["BuscarPrv"])?$_REQUEST["BuscarPrv"]:"";
$CmbRutPrv           = isset($_REQUEST["CmbRutPrv"])?$_REQUEST["CmbRutPrv"]:"";
$VolverAEsp          = isset($_REQUEST["VolverAEsp"])?$_REQUEST["VolverAEsp"]:"";*/

$ValCheck = $Muestras;
$Rut      = $CookieRut;

if ($Opcion == 4)
{
	$Consulta="select * from cal_web.solicitud_analisis where nro_solicitud = '".$Sol."' and recargo ='".$Rec."'";
	$Respuesta=mysqli_query($link, $Consulta);
	$Fil=mysqli_fetch_array($Respuesta);
	$Actualizar="UPDATE cal_web.solicitud_analisis set leyes='".$ValoresLeyes."',impurezas='".$ValoresImpurezas."' where nro_solicitud ='".$Sol."' and recargo = '".$Rec."'  ";  
	mysqli_query($link, $Actualizar);
	$Eliminar="delete from cal_web.leyes_por_solicitud where  nro_solicitud=".$Sol." and recargo = '".$Rec."' ";
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
							$Insertar = "insert into cal_web.leyes_por_solicitud (rut_funcionario,recargo,fecha_hora,nro_solicitud,cod_leyes,cod_unidad,cod_producto,cod_subproducto,id_muestra) values ('";
							$Insertar = $Insertar.$Fil["rut_funcionario"]."','";
							$Insertar = $Insertar.$Rec."','";
							$Insertar = $Insertar.$Fil["fecha_hora"]."',";
							$Insertar = $Insertar.$Sol.",'";
							$Insertar = $Insertar.$Ley."','";
							$Insertar = $Insertar.$Unidad."','";
							$Insertar = $Insertar.$Fil["cod_producto"]."','";
							$Insertar = $Insertar.$Fil["cod_subproducto"]."','";
							$Insertar = $Insertar.$Fil["id_muestra"]."')";
							//echo $Insertar."<br>";
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
							$Insertar = "insert into cal_web.leyes_por_solicitud (rut_funcionario,recargo,fecha_hora,nro_solicitud,cod_leyes,cod_unidad,cod_producto,cod_subproducto,id_muestra) values ('";
							$Insertar = $Insertar.$Fil["rut_funcionario"]."','";
							$Insertar = $Insertar.$Rec."','";
							$Insertar = $Insertar.$Fil["fecha_hora"]."',";
							$Insertar = $Insertar.$Sol.",'";
							$Insertar = $Insertar.$Impureza."','";
							$Insertar = $Insertar.$Unidad."','";
							$Insertar = $Insertar.$Fil["cod_producto"]."','";
							$Insertar = $Insertar.$Fil["cod_subproducto"]."','";
							$Insertar = $Insertar.$Fil["id_muestra"]."')";
							mysqli_query($link, $Insertar);
						}
					}
				$Impurezas = substr($Impurezas,$k + 2);
				$k = 0;
				}
			}
			echo "<script languaje='JavaScript'>";
			echo " window.opener.document.FrmRetalla.action='cal_retalla.php?Rut=".$Fil["rut_funcionario"]."&Rec=".$Rec."&SA=".$Sol."';";
			echo " window.opener.document.FrmRetalla.submit();";
			echo "window.close();</script>";
}
if($Opcion == '5')
{
	//modificado por rene 12-09-2013
	
	/*echo "<script languaje='JavaScript'>";
	echo " window.opener.document.FrmMuestrasJefe.action='cal_adm_solicitud_muestreo_jefe.php';";
	echo " window.opener.document.FrmMuestrasJefe.submit();";
	echo "window.close();</script>";*/
	
	echo "<script languaje='JavaScript'>";
	echo " window.opener.document.FrmMuestras.action='cal_adm_solicitud_muestrera.php';";
	echo " window.opener.document.FrmMuestras.submit();";
	echo "window.close();</script>";

}
?>
