<?php
	include("../principal/conectar_sec_web.php");

	$Proceso  = $_REQUEST["Proceso"];
	$Valores  = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	$TxtRut     = isset($_REQUEST["TxtRut"])?$_REQUEST["TxtRut"]:"";
	$TxtDv      = isset($_REQUEST["TxtDv"])?$_REQUEST["TxtDv"]:"";
	$TxtNombre  = isset($_REQUEST["TxtNombre"])?$_REQUEST["TxtNombre"]:"";
	$TxtLugar   = isset($_REQUEST["TxtLugar"])?$_REQUEST["TxtLugar"]:"";
	$TxtDivSap  = isset($_REQUEST["TxtDivSap"])?$_REQUEST["TxtDivSap"]:"";
	$TxtAlmSap  = isset($_REQUEST["TxtAlmSap"])?$_REQUEST["TxtAlmSap"]:"";
	$CheckEst   = isset($_REQUEST["CheckEst"])?$_REQUEST["CheckEst"]:"";
	$cod_originador   = isset($_REQUEST["cod_originador"])?$_REQUEST["cod_originador"]:"";


	$RutOriginador = $TxtRut."-".$TxtDv;
	if($CheckEst == ''){
		$CheckEst = 0;
	}
	
	switch ($Proceso)
	{
		case "N":
		
			$Insertar="insert into sec_web.sec_originador (rut,nombre,lugar,div_sap,almacen_sap,activo) values (";
			$Insertar = $Insertar."'".$RutOriginador."','$TxtNombre','$TxtLugar','$TxtDivSap','$TxtAlmSap','$CheckEst')";
		 	mysqli_query($link, $Insertar);
			/* echo $Insertar;*/
		 	$msg = "Registro creado correctamente.";

			break;
		case "M":
			$Modificar="UPDATE sec_web.sec_originador set rut='".$RutOriginador."',nombre='$TxtNombre',lugar='$TxtLugar',div_sap='$TxtDivSap',almacen_sap='$TxtAlmSap',activo='$CheckEst' where cod_originador='".$cod_originador."'";
			mysqli_query($link, $Modificar);
			$msg = "Registro modificado correctamente.";
			break;
		case "E":
			$reg_delete=false;
			$EncontroRelacion=false;
			$Datos = explode("//", $Valores);
			for ($i=0;$i<=count($Datos);$i++)
			{
				if($Datos[$i]!='')
				{
					//$Consulta = "select * from sec_web.guia_despacho where cod_originador='".$Datos[$i]."'";
					$Consulta = "select * from sec_web.guia_despacho_emb where cod_originador='".$Datos[$i]."'";
					$Resultado=mysqli_query($link, $Consulta);
					if (!$Fila=mysqli_fetch_array($Resultado))
					{
					$Eliminar ="delete from sec_web.sec_originador where cod_originador='".$Datos[$i]."'";
					mysqli_query($link, $Eliminar);
					$msg = "Registro Eliminado correctamente.";
/*					echo $Eliminar;*/
					$reg_delete=true;
					}
					else
					{
					$EncontroRelacion=true;
					}
				}
			}
			break;	
	}
	if ($Proceso=="E")
	{

		header("location:sec_originador.php?EncontroRelacion=".$EncontroRelacion."&reg_delete=".$reg_delete);
	}
	else
	{
		echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmIngOriginador.action='sec_originador.php';";
		echo "window.opener.document.FrmIngOriginador.submit();";
		echo "window.close();";
		echo "alert('".$msg."');";
		echo "</script>";

	}	

?>