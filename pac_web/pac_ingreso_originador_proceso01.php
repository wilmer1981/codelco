<?php
	include("../principal/conectar_pac_web.php");

	$Proceso = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Valores = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";

	$TxtNombre  = isset($_REQUEST["TxtNombre"])?$_REQUEST["TxtNombre"]:"";
	$TxtRut     = isset($_REQUEST["TxtRut"])?$_REQUEST["TxtRut"]:"";
	$TxtDv      = isset($_REQUEST["TxtDv"])?$_REQUEST["TxtDv"]:"";
	$TxtLugar   = isset($_REQUEST["TxtLugar"])?$_REQUEST["TxtLugar"]:"";	
	$TxtDivSap  = isset($_REQUEST["TxtDivSap"])?$_REQUEST["TxtDivSap"]:"";
	$TxtAlmSap     = isset($_REQUEST["TxtAlmSap"])?$_REQUEST["TxtAlmSap"]:"";
	$CheckEst   = isset($_REQUEST["CheckEst"])?$_REQUEST["CheckEst"]:0;


	$RutOriginador=$TxtRut."-".$TxtDv;
	/*
	if($CheckEst == ''){
		$CheckEst = 0;
	}
	*/
	
	switch ($Proceso)
	{
		case "N":
		
			$Insertar="INSERT INTO pac_web.pac_originador (rut,nombre,lugar,div_sap,almacen_sap,activo) values (";
			$Insertar = $Insertar."'".$RutOriginador."','$TxtNombre','$TxtLugar','$TxtDivSap','$TxtAlmSap','$CheckEst')";
		 	mysqli_query($link, $Insertar);
		 	$msg = "Registro creado correctamente.";

			break;
		case "M":
			$Modificar="UPDATE pac_web.pac_originador set rut='".$RutOriginador."',nombre='$TxtNombre',lugar='$TxtLugar',div_sap='$TxtDivSap',almacen_sap='$TxtAlmSap',activo='$CheckEst' where cod_originador='".$cod_originador."'";
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
					$Consulta = "SELECT * from pac_web.guia_despacho where cod_originador='".$Datos[$i]."'";
					$Resultado=mysqli_query($link, $Consulta);
					if (!$Fila=mysqli_fetch_array($Resultado))
					{
					$Eliminar ="DELETE from pac_web.pac_originador where cod_originador='".$Datos[$i]."'";
					mysqli_query($link, $Eliminar);
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

		header("location:pac_ingreso_originador.php?EncontroRelacion=".$EncontroRelacion."&reg_delete=".$reg_delete);
	}
	else
	{
		echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmIngOriginador.action='pac_ingreso_originador.php';";
		echo "window.opener.document.FrmIngOriginador.submit();";
		echo "window.close();";
		echo "alert('".$msg."');";
		echo "</script>";

	}	

?>