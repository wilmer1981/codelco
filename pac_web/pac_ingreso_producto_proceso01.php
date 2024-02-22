<?php
	include("../principal/conectar_pac_web.php");

			if($CheckEst == ''){
				$CheckEst = 0;
			}
	
	switch ($Proceso)
	{
		case "N":
		
			$Insertar="insert into pac_web.pac_productos (cod_sap,nombre,activo,concentracion,NU,cod_sipa) values (";
			$Insertar = $Insertar."'$TxtCodSap','$TxtNombre','$CheckEst','$TxtConcentracion','$TxtNU','$CmbProductoSipa')";
		 	$result1=mysqli_query($link, $Insertar);
		 	if (!$result1) {
    			die('Invalid query: ' . mysql_error());
			}

		 	$msg = "Registro creado correctamente.";

			break;
		case "M":
			$Modificar="UPDATE pac_web.pac_productos set cod_sap='$TxtCodSap',nombre='$TxtNombre',activo='$CheckEst',concentracion='$TxtConcentracion',NU='$TxtNU',cod_sipa='$CmbProductoSipa' where cod_producto='".$cod_producto."'";
			$result2=mysqli_query($link, $Modificar);
			if (!$result2) {
    			die('Invalid query: ' . mysql_error());
			}
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
					$Consulta = "select * from pac_web.guia_despacho where cod_producto='".$Datos[$i]."'";
					$Resultado=mysqli_query($link, $Consulta);
					if (!$Fila=mysqli_fetch_array($Resultado))
					{
					$Eliminar ="delete from pac_web.pac_productos where cod_producto='".$Datos[$i]."'";
					$result1 = mysqli_query($link, $Eliminar);
					if (!$result1) {
    				 die('Invalid query: ' . mysql_error());
					}
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

		header("location:pac_ingreso_productos.php?EncontroRelacion=".$EncontroRelacion."&reg_delete=".$reg_delete);
	}
	else
	{
		echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmIngProd.action='pac_ingreso_productos.php';";
		echo "window.opener.document.FrmIngProd.submit();";
		echo "window.close();";
		echo "alert('".$msg."');";
		echo "</script>";

	}	

?>