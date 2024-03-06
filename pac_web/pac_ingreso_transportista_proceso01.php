<?php
	include("../principal/conectar_pac_web.php");

	$Proceso = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$TxtRut  = isset($_REQUEST["TxtRut"])?$_REQUEST["TxtRut"]:"";
	$TxtDv = isset($_REQUEST["TxtDv"])?$_REQUEST["TxtDv"]:"";
	$Valores = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";

	$TxtNombre     = isset($_REQUEST["TxtNombre"])?$_REQUEST["TxtNombre"]:"";
	$TxtDireccion = isset($_REQUEST["TxtDireccion"])?$_REQUEST["TxtCiudad"]:"";
	$TxtCiudad    = isset($_REQUEST["TxtCiudad"])?$_REQUEST["TxtDireccion"]:"";
	$TxtTelefono  = isset($_REQUEST["TxtTelefono"])?$_REQUEST["TxtTelefono"]:"";
	$TxtFax    = isset($_REQUEST["TxtFax"])?$_REQUEST["TxtFax"]:"";
	$TxtGiro   = isset($_REQUEST["TxtGiro"])?$_REQUEST["TxtGiro"]:"";

	$RutTransp = $TxtRut."-".$TxtDv;
	/*$TxtIndicadorTras = $CmbTras;*/
	/*echo $TxtIndicadorTras;*/
	switch ($Proceso)
	{
		case "N":
			$Insertar="insert into pac_web.transportista (rut_transportista,nombre,direccion,ciudad,telefono,fax,giro_transp) values (";
			$Insertar = $Insertar."'$RutTransp','$TxtNombre','$TxtDireccion','$TxtCiudad','$TxtTelefono','$TxtFax','$TxtGiro')";
			$result1=mysqli_query($link, $Insertar);
		 	if (!$result1) {
    			die('Invalid query: ' . mysql_error());
			}
			$msg = "Registro creado correctamente.";
			break;
		case "M":
			$Modificar="UPDATE pac_web.transportista set nombre='$TxtNombre',direccion='$TxtDireccion',ciudad='$TxtCiudad',telefono='$TxtTelefono',fax='$TxtFax',giro_transp='$TxtGiro' where rut_transportista='".$RutTransp."'";
			$result1=mysqli_query($link, $Modificar);
		 	if (!$result1) {
    			die('Invalid query: ' . mysql_error());
			}
			//echo "Query ".$Modificar."<br>";
			$msg = "Registro modificado correctamente.";
			break;
		case "E":
			$reg_delete=false;
			$EncontroRelacion=false;
			$Datos=$Valores;
			for ($i=0;$i<=strlen($Datos);$i++)
			{
				if (substr($Datos,$i,2)=="//")
				{
					$RutTransp=substr($Datos,0,$i);
					$Eliminar ="delete from pac_web.transportista where rut_transportista='".$RutTransp."'";
					$result1=mysqli_query($link, $Eliminar);
		 			if (!$result1) {
    					die('Invalid query: ' . mysql_error());
					}
					$reg_delete=true;
					$Datos=substr($Datos,$i+2);
					$i=0;
				}
			}
			break;	
	}
	if ($Proceso=="E")
	{
		header("location:pac_ingreso_transportista.php?EncontroRelacion=".$EncontroRelacion."&reg_delete=".$reg_delete);
	}
	else
	{
		echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmIngTransp.action='pac_ingreso_transportista.php';";
		echo "window.opener.document.FrmIngTransp.submit();";
		echo "window.close();";
		echo "alert('".$msg."');";
		echo "</script>";
	}	
?>