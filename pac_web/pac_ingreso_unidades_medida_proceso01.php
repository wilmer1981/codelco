<?php
	include("../principal/conectar_pac_web.php");

			if($CheckEst == ''){
				$CheckEst = 0;
			}
	
	switch ($Proceso)
	{
		case "N":
		
			$Insertar="insert into pac_web.pac_unidades_medida (cod_sap,nombre,activo) values (";
			$Insertar = $Insertar."'$TxtCodSap','$TxtNombre','$CheckEst')";
		 	$result = mysqli_query($link, $Insertar);
		 	if (!$result) {
    			die('Invalid query: ' . mysql_error());
			}
		 	$msg = "Registro creado correctamente.";

			break;
		case "M":
			$Modificar="UPDATE pac_web.pac_unidades_medida set cod_sap='$TxtCodSap',nombre='$TxtNombre',activo='$CheckEst' where cod_unidad='".$cod_unidad."'";
			$result = mysqli_query($link, $Modificar);
		 	if (!$result) {
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
					$Consulta = "select * from pac_web.guia_despacho where cod_unidad='".$Datos[$i]."'";
					$Resultado=mysqli_query($link, $Consulta);
						if (!$Resultado) {
    					die('Invalid query: ' . mysql_error());
						}
					if (!$Fila=mysqli_fetch_array($Resultado))
					{
					$Eliminar ="delete from pac_web.pac_unidades_medida where cod_unidad='".$Datos[$i]."'";
					$eliminar = mysqli_query($link, $Eliminar);
						if (!$eliminar) {
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

		header("location:pac_ingreso_unidades_medida.php?EncontroRelacion=".$EncontroRelacion."&reg_delete=".$reg_delete);
	}
	else
	{
		echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmIngUnidad.action='pac_ingreso_unidades_medida.php';";
		echo "window.opener.document.FrmIngUnidad.submit();";
		echo "window.close();";
		echo "alert('".$msg."');";
		echo "</script>";

	}	

?>